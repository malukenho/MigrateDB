<?php
namespace MigrateDB;

use ReflectionClass;
use ReflectionObject;
use Exception;
use PDO;

class MigrateDBTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function if_class_can_be_instanciate()
	{
		$reflection = new ReflectionClass('\MigrateDB\MigrateDB');
		$instance = $reflection->newInstanceWithoutConstructor();
		$this->assertInstanceOf('\MigrateDB\MigrateDB', $instance);
		return $instance;
	}

	/**
	 * @test
	 */
	public function connection_can_be_storaged_on_class_on_setConnection_method()
	{
		$router = $this->if_class_can_be_instanciate();
		$pdoConnection = new PDO('sqlite:\\memory');

		$router = $router->setConnection(
			$pdoConnection, 
			$pdoConnection
		);

		$this->assertInstanceOf(
			'\MigrateDB\MigrateDB',
			$router,
			'No match class type'
		);

		$reflection = new ReflectionObject($router);

		$propertyOfDB = $reflection->getProperty('_ofDb');
		$propertyOfDB->setAccessible(true);
		$ofConnection = $propertyOfDB->getValue($router);
		$this->assertInstanceOf('PDO', $ofConnection);

		$propertyToDB = $reflection->getProperty('_toDb');
		$propertyToDB->setAccessible(true);
		$toConnection = $propertyToDB->getValue($router);
		$this->assertInstanceOf('PDO', $toConnection);
	}
}