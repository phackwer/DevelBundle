<?php
namespace SanSIS\Core\DevelBundle\Service;

use \SanSIS\Core\BaseBundle\ServiceLayer\ServiceAbstract;

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
			if (strstr($key, 'SanSIS') && !strstr($key, 'SanSISCore')) {
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