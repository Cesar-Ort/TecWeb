<?php
use TECWEB\MYAPI\Delete\Delete;
require_once __DIR__ . '/myapi/vendor/autoload.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = new Delete('marketzone');
    $delete->delete($id);
    echo $delete->getData();
}
?>