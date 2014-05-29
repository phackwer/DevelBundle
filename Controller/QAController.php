<?php

namespace Ibram\Core\DevelBundle\Controller;

class QAController extends ControllerAbstract
{
    public function phpUnitAction()
    {
        exec('cd '.$this->_getRootDir().' && bin'.self::$ds.'phing test', $out);
        
        $out = implode("\n", $out);

        return $this->render('IbramCoreDevelBundle::out.html.twig', array('out' => $out));
    }

    public function pmdAction()
    {
        exec('cd '.$this->_getRootDir().' && bin'.self::$ds.'phing md', $out);
        
        $out = implode("\n", $out);

        return $this->render('IbramCoreDevelBundle::out.html.twig', array('out' => $out));
    }

    public function cpdAction()
    {
        exec('cd '.$this->_getRootDir().' && bin'.self::$ds.'phing cpd', $out);
        
        $out = implode("\n", $out);

        return $this->render('IbramCoreDevelBundle::out.html.twig', array('out' => $out));
    }

    public function checkStyleAction()
    {
        exec('cd '.$this->_getRootDir().' && bin'.self::$ds.'phing cs', $out);
        
        $out = implode("\n", $out);

        return $this->render('IbramCoreDevelBundle::out.html.twig', array('out' => $out));
    }

}
