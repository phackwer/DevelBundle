<?php

namespace Ibram\Core\DevelBundle\Controller;

class ReverseController extends ControllerAbstract
{

    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    
    
    public function selectSchemaAction()
    {
        // Carregando processamento via chamada de servico
        $serv = $this->get('ibram_core_devel.service_reverse');
        
        $schemas = $serv->getSchemas($this->getRequest());
        $bundles = $serv->getBundles($this->get('kernel')->getBundles());
        
        $viewData = array(
            'schemas' => $schemas,
            'bundles' => $bundles
        );
        
        return $this->render('IbramCoreDevelBundle:Reverse:selectSchema.html.twig', $viewData);
    }
    
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    
    
    public function listSchemaTablesAction()
    {
        // Carregando processamento via chamada de servico
        $serv = $this->get('ibram_core_devel.service_reverse');
    
        $tables = $serv->getSchemaTables($this->getRequest());
    
        return $this->renderJson($tables);
    }

    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reverseEntitiesAction()
    {
        // Carregando processamento via chamada de servico
        $serv = $this->get('ibram_core_devel.service_reverse');
        
        $response = $serv->reverseEntities($this->getRequest(), $this->_getRootDir());
        
        return $this->render('IbramCoreDevelBundle:Reverse:createEntities.html.twig', array(
        		'response' => $response
        ));
    }

    public function getCurrentSequencesListAction()
    {
        $serv = $this->get('ibram_core_devel.service_reverse');
        $seqs = $serv->getCurrentSequencesList();
        return $this->renderJson($seqs);
    }
}
