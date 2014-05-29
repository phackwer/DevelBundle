<?php

namespace Ibram\Core\DevelBundle\Controller;

class DefaultController extends ControllerAbstract
{
    public function indexAction()
    {
        return $this->render('IbramCoreDevelBundle:Default:index.html.twig');
    }
}
