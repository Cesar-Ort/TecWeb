<?php
use TECWEB\MYAPI\Read\Read;
require_once __DIR__ . '/myapi/vendor/autoload.php';

if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $read = new Read('marketzone');
    $read->search($search);
    echo $read->getData();
}
?>