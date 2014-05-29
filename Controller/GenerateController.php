<?php

namespace Ibram\Core\DevelBundle\Controller;

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
    	return $this->render('IbramCoreDevelBundle:Generate:parametersYml.html.twig');
    }

}
