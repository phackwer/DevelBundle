<?php
namespace Ibram\Core\DevelBundle\Service;

use \Ibram\Core\BaseBundle\ServiceLayer\ServiceAbstract;

/**
 * @author pablo.sanchez
 *
 */
abstract class DevelService extends ServiceAbstract
{
	protected function generateClassSkeleton($namespace, $class, $extends = null, $classType = null)
	{
		if ($classType)
			$classType .= ' ';
		$skel  = "<?php\n";
		$skel .= "namespace {$namespace};\n\n";
		$skel .= $classType."class {$class} extends {$extends}\n";
		$skel .= "{\n";
		$skel .= "}\n";
	
		return $skel;
	}
	
	public function getBundles($bundles){
	
		$filteredBundles = array();
	
		foreach($bundles as $key => $bundle) {
			if (strstr($key, 'Ibram') && !strstr($key, 'IbramCore')) {
				$bundleName = get_class($bundle);
				$bundleName = explode('\\',$bundleName);
				array_pop($bundleName);
				$bundleName = implode('\\',$bundleName);
				$filteredBundles[] = $bundleName;
			}
		}
	
		return $filteredBundles;
	
	}
}