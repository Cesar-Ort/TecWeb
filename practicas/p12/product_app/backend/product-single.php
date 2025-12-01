<?php
    include_once __DIR__.'/database.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $query = "SELECT * FROM productos WHERE id = {$id}";
        $result = $conexion->query($query);
        
        if($result) {
            $producto = $result->fetch_assoc();
            echo json_encode($producto);
            $result->free();
        }
        
        $conexion->close();
    }
?>