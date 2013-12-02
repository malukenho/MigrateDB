# MigrateDB




**MigrateDB** is a simple tool to migrate data between databases.

#### Step 1

Well, we have the follow table
```sql
mysql> SELECT * FROM user;
+------+------------+---------+
| id   | name       | passwd  |
+------+------------+---------+
|    1 | Kika Pimpo | 123@456 |
|    2 | RamStrYou  | 1!#@$%6 |
+------+------------+---------+
1 row in set (0.00 sec)
```

And are wanted migrate this datas to another table.
```sql
mysql> SELECT * FROM member;
+-----------+-----------------+------------+
| user_id   | user_name       | user_pass  |
+-----------+-----------------+------------+
|           Nothing to see here            |
+-----------+-----------------+------------+
1 row in set (0.00 sec)
```
Let's go!

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

$router = new MigrateDB(new User);
 
$result = $router->setConnection($mySql, $mySql2)
    ->MapperDatas('1');
 
$router->replyTo(new InsertUser)
    ->with($result);
```
You can set it like this too

```php
<?php
$routerClient = new MigrateDB(new ClientData);

$routerClient->registerFilter(new ClientFilter)
    ->replyTo(new ClientDataReply)
    ->with(
        $routerClient->setConnection(
            $mySqlConnection, 
            $fireBirdConnection
        )->MapperDatas(
            rand(0, 9)
        )
    );
```
