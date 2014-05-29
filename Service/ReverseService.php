<?php

namespace Ibram\Core\DevelBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use Doctrine\ORM\EntityManager;

use \Ibram\Core\DevelBundle\Doctrine\DBAL\Platforms\SysAllOraclePlatform;
use \Ibram\Core\DevelBundle\Doctrine\DBAL\Schema\SysAllOracleSchemaManager;
use \Ibram\Core\DevelBundle\Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use \Ibram\Core\DevelBundle\Service\DevelService;

class ReverseService extends DevelService
{
    protected $em;
    protected $conn;
    protected $driver;
    protected $platform;
    protected $scm;
    protected $cmf;
    
    public function __construct(EntityManager $entityManager)
    {
        //Altera parâmetros da conexão
        $this->em = $entityManager;
        $this->conn = $entityManager->getConnection();
        //Plataforma personalizada
        $this->platform = new SysAllOraclePlatform();
        //Schema manager personalizado
        $this->scm = new SysAllOracleSchemaManager($this->conn, $this->platform);
        
        //obtém e define driver utilizado
        $this->driver = new DatabaseDriver($this->scm);
        $entityManager->getConfiguration()->setMetadataDriverImpl($this->driver);
        
        //realiza a reversa do banco
        $this->cmf = new DisconnectedClassMetadataFactory();
        $this->cmf->setEntityManager($entityManager);
        
        parent::__construct($entityManager);
    }
    
    public function getSchemas(Request $request)
    {
        $schemas = $this->scm->listDatabases();
        
        asort($schemas);
        
        return $schemas;
    }
    
    public function getSchemaTables(Request $request)
    {
        $schema = $request->query->get('schema');
        
        $this->scm->setSchema($schema);
        $tables = $this->scm->listTableNames();;

        sort($tables);

//        echo '<pre>';
//        var_dump($tables);die;
    
        return $tables;
    }
    
    public function reverseEntities(Request $request, $rootdir)
    {
        $response = '';
             
        $dsp = DIRECTORY_SEPARATOR;
        
        $bundle = $request->request->get('bundle');
        $schema = $request->request->get('schema');
        $tables = $request->request->get('tables');
        
        $path = implode($dsp, explode('\\', $bundle));
        $model_dir = $rootdir.'src'.$dsp.$path.$dsp.'Entity'.$dsp;
        $repos_dir = $rootdir.'src'.$dsp.$path.$dsp.'EntityRepository'.$dsp;

        $nspEntity = $bundle.'\\Entity';
        $nspRepo = $bundle.'\\EntityRepository';
        
        $this->driver->setNamespace($nspEntity.'\\');
        
        $this->scm->setSchema($schema);

        $egn = new \Doctrine\ORM\Tools\EntityGenerator();
        $egn->setGenerateAnnotations(true);
        $egn->setClassToExtend($bundle.'\\Entity\\AbstractBase');
        $egn->setGenerateStubMethods(true);
        $egn->setUpdateEntityIfExists(true);

        $metadata = array();

        if (!count($tables)) {
            $metadata = $this->cmf->getAllMetadata();
        } else
        {
            $class = array();
            foreach($tables as $key => $table){
                $arr = explode('_',$table);
                foreach ($arr as $k => $v) {
                    $arr[$k] = ucfirst(strtolower($v));
                }

                $class[$key] = $nspEntity.'\\'.implode('',$arr);

//                $metadata = $this->cmf->loadMetadata($class[$key]);

                $metadata[$key] = $this->cmf->getMetadataFor($class[$key]);
            }
//            var_dump($class);die;
        }

        if (!file_exists($model_dir))
            mkdir($model_dir);

        if (!file_exists($repos_dir))
            mkdir($repos_dir);

        if (!file_exists($model_dir.'AbstractBase.php')) {
            $model  = $this->generateClassSkeleton(
                    $nspEntity,
                    'AbstractBase',
                    '\\Ibram\\Core\\BaseBundle\\Entity\\AbstractBase',
                    'abstract');
            file_put_contents($model_dir.'AbstractBase.php', $model);
            $response .= 'Criado arquivo '.$model_dir."AbstractBase.php\n";
        }

        if (!file_exists($repos_dir.'AbstractBase.php')) {
            $repo  = $this->generateClassSkeleton(
                    $nspRepo,
                    'AbstractBase',
                    '\\Ibram\\Core\\BaseBundle\\EntityRepository\\AbstractBase',
                    'abstract');
            file_put_contents($repos_dir.'AbstractBase.php', $repo);
            $response .= 'Criado arquivo '.$repos_dir."AbstractBase.php\n";
        }

        var_dump($tables);
        
        foreach ($metadata as $key => $entity) {

            $currTable = $metadata[$key]->table;

            echo $key;die;


                $name = explode('\\',$entity->name);
            $pos = count($name) - 1;
            $class = explode('.', $name[$pos]);
            if (isset($class[1]) && $class[1])
                $className = $name[$pos] = ucfirst($class[1]);
            else
                $className = $name[$pos];
            $metadata[$key]->table = array('name' => $schema.'.'.implode('',$metadata[$key]->table));
            //$metadata[$key]->name = implode('\\',$name);
            //$metadata[$key]->rootEntityName = $metadata[$key]->name;

            foreach($metadata[$key]->associationMappings as $assk => $ass) {
                $name = explode('\\',$metadata[$key]->associationMappings[$assk]['targetEntity']);
                $pos = count($name) - 1;
                $class = explode('.', $name[$pos]);
                if (isset($class[1]) && $class[1])
                    $name[$pos] = $class[0].ucfirst($class[1]);

                $metadata[$key]->associationMappings[$assk]['targetEntity'] = implode('\\',$name);

                $name = explode('\\',$metadata[$key]->associationMappings[$assk]['sourceEntity']);
                $pos = count($name) - 1;
                $class = explode('.', $name[$pos]);
                if (isset($class[1]) && $class[1])
                    $name[$pos] = $class[0].ucfirst($class[1]);

                $metadata[$key]->associationMappings[$assk]['sourceEntity'] = implode('\\',$name);
            }
            
            //Cria arquivo da classe
            $addRepo = !file_exists($model_dir.$className.".php");
            
            $egn->writeEntityClass($entity, $rootdir);
            
            if ($addRepo)
            {
                //define o repository default da classe
                $entityCode = file_get_contents($model_dir.$className.".php");
                $entityCode = str_replace(
                        "@ORM\\Entity",
                        "@ORM\\Entity\n * @ORM\Entity(repositoryClass=\"\\$nspRepo\\$className\")\n",
                        $entityCode);
                file_put_contents($model_dir.$className.".php", $entityCode);
                $response .=  'Criado arquivo '.$model_dir.$className.".php\n";
            }
            
            //cria o repository se já não existir
            if (!file_exists($repos_dir.$className.'.php')) {
                $repo  = $this->generateClassSkeleton(
                        $nspRepo,
                        $className,
                        'AbstractBase');
                file_put_contents($repos_dir.$className.'.php', $repo);
                $response .=  'Criado arquivo '.$repos_dir.$className.".php\n";
            }
        }
        
        return $response;
    }

    public function getCurrentSequencesList()
    {
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        return $metadata;
    }
}