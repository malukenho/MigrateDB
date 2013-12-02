# MigrateDB




**MigrateDB** is a simple tool to migrate data between databases.

#### Step 1
Create the class to get data of a table. You can use the annotation @of_table to set it, and @complement to increase you query

```php
<?php
/**
 * @of_table   user 
 * @to_table   member
 * @complement WHERE status = '1'
 */
class User implements EnumTablesRelation
{
	const user_id = 'id';
	const user_name = 'name'
	const user_pass = 'passwd';
}
```
#### Step 2
Create the class to relation with previous class. It go insert the tada selected on *Step 1* on this database

```php
<?php
/**
 * @of_table   user 
 * @to_table   member
 */
class InsertUser implements EnumTablesRelation
{
	const IDENTIFY = 'user_id';
	const USERNAME = 'user_name'
	const PASSWORD = 'user_pass';
}
```
#### Final Step

Create file of configuration and execute migration :3

```php
<?php
$loader = require 'Load.php';
 
$loader->getService('Mapper.User')
    ->getService('Mapper.InsertUser');


$mySql = new PDO('...');
$mySql2 = new PDO('...');

$router = new RouterMap(new User);
 
$result = $router->setConnection($mySql, $mySql2)
    ->MapperDatas('1');
 
$router->replyTo(new InsertUser)
    ->with($result);
```
You can set it like this too

```php
<?php
$routerClient = new RouterMap(new ClientData);

$routerClient->registerFilter(new ClientFilter)
    ->replyTo(new ClientDataReply)
    ->with(
        $routerClient->setConnection(
            $mySqlConnection, 
            $fireBirdConnection
        )->MapperDatas(
            $value['idpessoa']
        )
    );
```
