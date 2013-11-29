<?php
error_reporting(-1);
ini_set('display_errors', 1);

require __DIR__.'/../RouterMap.php';
require __DIR__.'/../Interface/EnumTablesRelation.php';
require __DIR__.'/../Interface/FilterParams.php';


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
	public function connection_can_be_storaged_on_class_on_setConnection_method()
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

	/**
	 * @test
	 */
	public function filter_can_be_registred_and_storage_on_class()
	{
		$mockRouterMap = $this->getMockBuilder('RouterMap')
			->disableOriginalConstructor()
			->getMock();
		
		$mockRouterMap->expects($this->any())
			->method('registerFilter')
			->will($this->throwException(new Exception));

		$this->assertInstanceOf('RouterMap', $mockRouterMap);

		$filter = $this->getMockBuilder('FilterParams')
			->getMock();

		$this->assertInstanceOf('FilterParams', $filter);

		$router = $this->if_class_can_be_instanciate();

		$this->assertInstanceOf(
			'RouterMap', 
			$router->registerFilter($filter)
		);

	}

	/**
	 * @test
	 */
	public function replyTo_method_can_storage_data_and_get_information_by_annotations_returning_self_object()
	{
		$mockRouterMap = $this->getMockBuilder('RouterMap', array('ReplyTo'))
			->disableOriginalConstructor()
			->getMock();

		$this->assertInstanceOf('RouterMap', $mockRouterMap);

		$EnumTablesRelation = $this->getMockBuilder('EnumTablesRelation')
			->getMock();

		$this->assertInstanceOf('EnumTablesRelation', $EnumTablesRelation);

		$mockRouterMap->expects($this->any())
			->method('ReplyTo')
			->with($EnumTablesRelation);

		$mockRouterMap->ReplyTo($EnumTablesRelation);
		
		$this->assertInstanceOf('RouterMap', $mockRouterMap);

	}

}