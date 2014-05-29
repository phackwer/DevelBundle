<?php

namespace SanSIS\Core\DevelBundle\Controller;

class ToolsController extends ControllerAbstract
{
    public function cacheClearAction()
    {
        $command = $this->_getConsoleCommand().' cache:clear';
        exec($command.' --env=prod', $out1);
        exec($command.' --env=hmg', $out2);
        exec($command.' --env=ad', $out3);

        $cleartwigcache = 'rm -rf '.$this->_getRootDir().'1/* && rm -rf '.$this->_getRootDir().'web/1/*';

        exec($cleartwigcache, $out4);

        $out = "Atenção: a limpeza do cache de ambiente de desenvolvimento deve ser feita manualmente no ambiente do desenvolvedor.\n\n";
        $out .= implode("\n", $out1);
        $out .= "\n".implode("\n", $out2);
        $out .= "\n".implode("\n", $out3);
        $out .= "\n".implode("\n", $out4);

        return $this->render('SanSISCoreDevelBundle::out.html.twig', array('out' => $out));
    }

    public function assetsInstallAction()
    {
        exec($this->_getConsoleCommand().' assets:install --symlink', $out);

        $out = implode("\n", $out);

        return $this->render('SanSISCoreDevelBundle::out.html.twig', array('out' => $out));
    }

    public function serviceListAction()
    {
    }

    public function routerDebugAction()
    {
        exec($this->_getConsoleCommand().' router:debug', $out);
        
        $out = implode("\n", $out);
        
        return $this->render('SanSISCoreDevelBundle::out.html.twig', array('out' => $out));
    }

    public function reportLoadFixturesAction()
    {
        exec($this->_getConsoleCommand().' doctrine:fixtures:load --fixtures=src/SanSIS/Core/ReportBundle --append', $out);

        $out = implode("\n", $out);

        return $this->render('SanSISCoreDevelBundle::out.html.twig', array('out' => $out));
    }

}
