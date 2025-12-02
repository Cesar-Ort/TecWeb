<?php
use TECWEB\MYAPI\Create\Create;
require_once __DIR__ . '/myapi/vendor/autoload.php';

$producto = file_get_contents('php://input');

if(!empty($producto)) {
    $jsonOBJ = json_decode($producto);
    $create = new Create('marketzone');
    $create->add($jsonOBJ);
    echo $create->getData();
}
?>