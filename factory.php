<?php
/**
 * This class output a instace of class required by methods
 * You can get Service access and classes by this point
 *
 * @package oraculo
 * @author  Jefersson Nathan <jeferssonn@alfamaweb.com.br> 
 */
final class Factory
{
	/**
	 * Return a instace of service.
	 * You should pass to the method the name of path
	 * followed of dot and the filename
	 *
	 * <code>
	 *  // Include the file 'Mysql.php' on path 'Migration'
	 *	$Factory->getService('Migration.Mysql');
	 * </code>
	 */
	public function getService($serviceName)
	{
		$pathForFile = str_replace('.', DIRECTORY_SEPARATOR, $serviceName);
		$pathForFile .= '.php';

		if (! file_exists($pathForFile)) {
			return false;
		}

		return require_once $pathForFile;
	}
}