<?php
    include_once __DIR__.'/database.php';

    $producto = file_get_contents('php://input');
    
    if(!empty($producto)) {
        $jsonOBJ = json_decode($producto);
        
        $id = $jsonOBJ->id;
        $nombre = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
        $marca = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
        $modelo = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
        $precio = $jsonOBJ->precio;
        $detalles = mysqli_real_escape_string($conexion, $jsonOBJ->detalles);
        $cantidad = $jsonOBJ->cantidad;
        $imagen = mysqli_real_escape_string($conexion, $jsonOBJ->imagen);
        
        $query = "UPDATE productos SET 
                  nombre = '{$nombre}',
                  marca = '{$marca}',
                  modelo = '{$modelo}',
                  precio = {$precio},
                  detalles = '{$detalles}',
                  cantidad = {$cantidad},
                  imagen = '{$imagen}'
                  WHERE id = {$id}";
        
        if($conexion->query($query)) {
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Producto modificado exitosamente'
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Error al modificar: ' . mysqli_error($conexion)
            ));
        }
        
        $conexion->close();
    }
?>