<?php

namespace SanSIS\Core\DevelBundle\Service;

use Symfony\Component\HttpFoundation\Request;

use \SanSIS\Core\DevelBundle\Service\DevelService;

class ReverseService extends DevelService
{
	public function getSchemas(Request $request)
	{
		$schemas = $this->scm->listDatabases();
		
		asort($schemas);
		
		return $schemas;
	}
	
	public function generateBundle(Request $request, $rootdir)
	{
		$response = '';
			 
		$dsp = DIRECTORY_SEPARATOR;
		
		$bundle = $request->query->get('bundle');
		
		$path = implode($dsp, explode('\\', $bundle));
		
		exec('cd '.$this->get('kernel')->getRootdir().'/.. && console generate:bundle --namespace='.$bundle.' --dir=src [--bundle-name=...] --no-interaction', $out);
		
		$rootdir = str_replace('app','src',$rootdir.$dsp);
		$rootdir = $rootdir.$path.$dsp;
		
		$arrExtraBundleDirs = array(
			'Entity' 			=> 'AbstractBase',
			'EntityRepository' 	=> 'AbstractBase',
			'Menu'				=> null,			
			'Service'			=> 'AbstractBase'	
		);
		
		foreach ($arrExtraBundleDirs as $dir => $base)
		{
			$mkdir = $rootdir.$dir.$dsp;
		
			if (!file_exists($mkdir))
				mkdir($mkdir);
			
			if (!file_exists($mkdir.'AbstractBase.php')) {
				$class  = $this->generateClassSkeleton(
						$bundle,
						'abstract '.$base,
						'\\SanSIS\\Core\\BaseBundle\\'.$dir.'\\AbstractBase');
				file_put_contents($mkdir.'AbstractBase.php', $class);
				echo 'Criado arquivo '.$mkdir.'AbstractBase.php'."<br>\n";
			}
		}
		
		$nspEntity = $bundle.'\\Entity\\';
		$nspRepo = $bundle.'\\EntityRepository\\';
		
		return $response;
	}
}