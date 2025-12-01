<?php
use TECWEB\MYAPI\Read\Read;
require_once __DIR__ . '/myapi/vendor/autoload.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $read = new Read('marketzone');
    $read->single($id);
    echo $read->getData();
}
?>