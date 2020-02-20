<?php

require_once("../conf/config.php");

$config = new DB_Config('devel.net.ilb.ru', 'fbproxy', 'FBPROXY', 'fbproxy', 'fbproxies', 3050, 'firebird');

$PDOFactory = DB_PDOFactory::getInstance();
$pdo = $PDOFactory->getPDO($config, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$firebirdProxy = FirebirdInterface_ProxyFactory::generateProxy($pdo);
$r = $firebirdProxy->sumTwoNum([':A' => 1, ':B' => 2]);

var_dump($r);
