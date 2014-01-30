[![Build Status](https://travis-ci.org/malukenho/MigrateDB.png?branch=master)](https://travis-ci.org/malukenho/MigrateDB)

# MigrateDB




**MigrateDB** is a simple tool to migrate data between databases.

#### Step 1

Installing the **MigrateDB** is very simple using composer :3

Create the follow script *composer.json*

```javascript
{
    "require": {
        "malukenho/migratedb": "dev-master"
    }
}
```
Run **composer install** and all's okay!



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

And would like to migrate this datas to another table.
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

Create the class to get data of a table. You can use the annotation ***@from_table*** to set it, and ***@complement*** to increase your query.

```php
<?php
/**
 * @Configurations(
 *     from_table="user",
 *     to_table="member",
 *     complement="WHERE status = '1'",
 *     type="select"
 * )
 */
class User implements EnumTablesRelation
{
	const user_id = 'id';
	const user_name = 'name'
	const user_pass = 'passwd';
}
```

The above code generates the following query

```sql
SELECT id, name, passwd FROM user WHERE status = 1
```

#### Step 2
Create the class to relation with previous class. It's gonna insert the data selected on *Step 1* on this database

```php
<?php
/**
 * @Configurations(
 *     from_table="user",
 *     to_table="member"
 * )
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
$loader = require __DIR__.'/vendor/autoload.php';

$mySql = new PDO('...');
$mySql2 = new PDO('...');

$router = new MigrateDB(new User);
 
$result = $router->setConnection($mySql, $mySql2)
    ->MapperDatas('1');
 
$router->replyTo(new InsertUser)
    ->with($result);
```
You can also set it like this

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


## Advanced

#### Types
We use advanced structures for migrating information between the database, it is decided according to the annotation `type` is the type definada in class `EnumTablesRelation`. There are **3 types** valid until now. They are:

- select
- join
- as

The **select** type has see on previous examples.

#### join

Here is a `join` example:

```php
<?php
/**
 * @Configurations(
 *     from_table="UserList",
 *     to_table="NewUserList",
 *     complement="WHERE UserList.iduser = $1",
 *     type="join"
 * )
 */
class UserRelation implements EnumTablesRelation
{
	const user_id = 'userid';
	const user_name = 'name.user_detail ON id = 1';
	const user_pass = 'passwd';
}
```

The previous code generate the following query:

```sql
SELECT 
    `UserList`.`userid` AS user_id, 
    `UserList`.`passwd` AS user_pass, 
    `user_detail`.`name` AS user_name 
        FROM UserList 
            INNER JOIN 
                `user_detail` ON user_detail.id = 1 
WHERE UserList.iduser = 1
```

#### as

Here is a `as` example:

```php
<?php
/**
 * @Configurations(
 *     from_table="UserList",
 *     to_table="NewUserList",
 *     complement="WHERE iduser = $1",
 *     type="as"
 * )
 */
class UserRelation implements EnumTablesRelation
{
	const user_id = 'userid';
	const user_name = 'name';
	const user_pass = 'passwd';
}
```

The previous code generate the following query:

```sql
SELECT 
    `user_id` AS `userid`, 
    `user_name` AS `name`, 
    `user_pass` AS `passwd` 
         FROM UserList 
WHERE iduser = 1
```
