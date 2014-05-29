<?php

namespace SanSIS\Core\DevelBundle\Controller;

class GenerateController extends ControllerAbstract
{
    public function appCoreBundleAction()
    {
    	$request = $this->getRequest();
    }

    public function configYmlAction()
    {
    }

    public function parametersYmlAction()
    {
    	return $this->render('SanSISCoreDevelBundle:Generate:parametersYml.html.twig');
    }

}
