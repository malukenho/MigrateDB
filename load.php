<?php
require 'Factory.php';
require 'Interface/EnumTablesRelation.php';

require 'Interface/FilterParams.php';
require 'RouterMap.php';

require 'Mapper/Sienge/Clients.php';
require 'Mapper/Sienge/Usuario.php';
require 'Mapper/Sienge/Empreendimentos.php';

require 'Filters/InsertUserConditions.php';

return new Factory;