<?php
use TECWEB\MYAPI\Update\Update;
require_once __DIR__ . '/myapi/vendor/autoload.php';

$producto = file_get_contents('php://input');

if(!empty($producto)) {
    $jsonOBJ = json_decode($producto);
    $update = new Update('marketzone');
    $update->edit($jsonOBJ);
    echo $update->getData();
}
?>