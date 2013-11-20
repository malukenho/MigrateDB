<?php
require dirname(__FILE__).'/../interface/inputFacade.php';

class MySQL implements inputFacade
{
	
	public function driveExists(){
		$driveName = 'mysql';
		if(! in_array($driveName, PDO::getAvailableDrivers())) {
		    printf(
		    	'%sThe <strong>%s</strong> drive not found', 
		    	nl2br(PHP_EOL), 
		    	$driveName
		    );
		    exit(2);
		}
	}

	

}

return new Mysql;