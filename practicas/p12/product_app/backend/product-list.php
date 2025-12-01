<?php
use TECWEB\MYAPI\Read\Read;
require_once __DIR__ . '/myapi/vendor/autoload.php';

$read = new Read('marketzone');
$read->list();
echo $read->getData();
?>