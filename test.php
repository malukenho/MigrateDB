<?php
$a = require 'Load.php';

$b = $a->getService('Service.Sienge');

$b->setInput(
	$a->getService('Provide.Mysql')
)->setOutput(
	$a->getService('Provide.FireBird')
);

