<?php
require 'Load.php';

$config['host']     = 'localhost';
$config['usuario']  = 'construtor_massa';
$config['senha']    = 'kidA09Ba@#ade';
$config['database'] = 'construtor_massai';

$fireBirdConnection = new PDO(
    'firebird:dbname=177.43.233.34:/home/SiengeWeb/SIENGE.FDB',
    'sysdba',
    'masterkey'
);

$fireBirdConnection->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

// ---- teste ----
$a = $fireBirdConnection->query(
	'select FIRST 1 CDCLIENTE from ECADCLIENTE order by CDCLIENTE DESC'
);


$result = $a->fetchAll();
$newID = ++$result[0][0];
$uniqueID = $newID;
// --- --


$mySqlConnection = new PDO(
    sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['database']), 
    $config['usuario'], 
    $config['senha']
);

$mySqlConnection->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);






// Insert Client
$router = new RouterMap(new Usuario);
$router->setConnection($mySqlConnection, $fireBirdConnection)
    ->registerFilter(new InsertUserConditions)
    ->MapperDatas($uniqueID);

$router = new RouterMap(new Clients);
$router->setConnection($mySqlConnection, $fireBirdConnection)
    ->registerFilter(new InsertUserConditions)
	->MapperDatas($uniqueID);