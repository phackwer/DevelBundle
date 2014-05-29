<?php

namespace SanSIS\Core\DevelBundle\Controller;

class DefaultController extends ControllerAbstract
{
    public function indexAction()
    {
        return $this->render('SanSISCoreDevelBundle:Default:index.html.twig');
    }
}
