<?php

namespace SanSIS\Core\DevelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SanSISCoreDevelBundle:Default:index.html.twig', array('name' => $name));
    }
}
