<?php
error_reporting(-1);
ini_set('display_errors', 1);

require __DIR__.'/../RouterMap.php';


class testRouterMap extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function if_class_can_be_instanciate()
	{
		$reflection = new ReflectionClass('RouterMap');
		$instance = $reflection->newInstanceWithoutConstructor();
		$this->assertInstanceOf('RouterMap', $instance);
		return $instance;
	}

	/**
	 * @test
	 */
	public function connection_can_be_storaged_on_class()
	{
		$router = $this->if_class_can_be_instanciate();
		$pdoConnection = new PDO('sqlite:\\memory');

		$router = $router->setConnection(
			$pdoConnection, 
			$pdoConnection
		);

		$this->assertInstanceOf(
			'RouterMap',
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