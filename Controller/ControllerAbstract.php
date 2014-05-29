<?php

namespace SanSIS\Core\DevelBundle\Controller;

use \SanSIS\Core\BaseBundle\Controller\ControllerAbstract as BaseControllerAbstract;

class ControllerAbstract extends BaseControllerAbstract
{
	protected static $ds = DIRECTORY_SEPARATOR;
	
	protected function _getRootDir()
	{
        $rootdir = str_replace('/',self::$ds,$this->get('kernel')->getRootdir());
        $rootdir = str_replace('app', '', $rootdir);

		return str_replace(' ','\\ ', $rootdir);
	}

    protected function _getConsoleCommand()
    {
        return 'cd '.$this->_getRootDir().' && php '.$this->_getRootDir().'app'.self::$ds.'console';
    }
}