<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);
        
        // SE VALIDA QUE EL JSON SEA VÁLIDO
        if(json_last_error() === JSON_ERROR_NONE) {
            
            // SE ESCAPA LA INFORMACIÓN PARA EVITAR INYECCIÓN SQL
            $nombre = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
            $marca = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
            $modelo = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
            $precio = $jsonOBJ->precio;
            $detalles = mysqli_real_escape_string($conexion, $jsonOBJ->detalles);
            $cantidad = $jsonOBJ->cantidad;
            $imagen = mysqli_real_escape_string($conexion, $jsonOBJ->imagen);
            
            // SE VERIFICA SI EL PRODUCTO YA EXISTE (solo con eliminado = 0)
            $query_validacion = "SELECT * FROM productos WHERE 
                                ((nombre = '{$nombre}' AND marca = '{$marca}') OR 
                                 (marca = '{$marca}' AND modelo = '{$modelo}'))
                                AND eliminado = 0";
            
            $resultado = $conexion->query($query_validacion);
            
            if($resultado->num_rows > 0) {
                // EL PRODUCTO YA EXISTE
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'El producto ya existe en la base de datos'
                ));
            } else {
                // SE INSERTA EL NUEVO PRODUCTO
                $query_insert = "INSERT INTO productos 
                                (nombre, marca, modelo, precio, detalles, cantidad, imagen, eliminado) 
                                VALUES 
                                ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$cantidad}, '{$imagen}', 0)";
                
                if($conexion->query($query_insert)) {
                    echo json_encode(array(
                        'status' => 'success',
                        'message' => 'Producto agregado exitosamente'
                    ));
                } else {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Error al insertar el producto: ' . mysqli_error($conexion)
                    ));
                }
            }
            
            $resultado->free();
            
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'JSON inválido recibido'
            ));
        }
        
        $conexion->close();
        
    } else {
        echo json_encode(array(
            'status' => 'error',
            'message' => 'No se recibió información del producto'
        ));
    }
?>