<?php
// Configuración de la base de datos
$host = "localhost";
$user = "root";
$pass = "celo218crlo218.";
$db = "marketzone";

// Crear conexión
$conexion = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conexion->connect_error) {
    die("ERROR: No pudo conectarse con la DB. " . $conexion->connect_error);
}

// Verificar que se reciban los datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir y limpiar datos
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $marca = isset($_POST['marca']) ? trim($_POST['marca']) : '';
    $modelo = isset($_POST['modelo']) ? trim($_POST['modelo']) : '';
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
    $detalles = isset($_POST['detalles']) ? trim($_POST['detalles']) : '';
    $unidades = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
    $imagen = isset($_POST['imagen']) ? trim($_POST['imagen']) : 'src/imagen.png';

    // Validar que el ID sea válido
    if ($id <= 0) {
        die("ERROR: ID de producto no válido.");
    }

    // Preparar la consulta SQL con prepared statements (seguridad)
    $sql = "UPDATE productos 
            SET nombre = ?, 
                marca = ?, 
                modelo = ?, 
                precio = ?, 
                detalles = ?, 
                cantidad = ?, 
                imagen = ? 
            WHERE id = ?";

    // Preparar statement
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        die("ERROR: No se pudo preparar la consulta. " . $conexion->error);
    }

    // Vincular parámetros (s=string, d=double, i=integer)
    $stmt->bind_param("sssdsisi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Verificar si se actualizó algún registro
        if ($stmt->affected_rows > 0) {
            $mensaje = "✅ Registro actualizado correctamente.";
            $tipo = "success";
        } else {
            $mensaje = "ℹ️ No se realizaron cambios (los datos son idénticos o el ID no existe).";
            $tipo = "info";
        }
    } else {
        $mensaje = "❌ ERROR: No se ejecutó la actualización. " . $stmt->error;
        $tipo = "error";
    }

    // Cerrar statement
    $stmt->close();

} else {
    $mensaje = "❌ ERROR: Método de solicitud no válido.";
    $tipo = "error";
}

// Cerrar conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Actualización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .mensaje {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 18px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .enlaces {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado de la Actualización</h1>
        
        <div class="mensaje <?php echo $tipo; ?>">
            <?php echo $mensaje; ?>
        </div>

        <div class="enlaces">
            <h3>¿Qué deseas hacer?</h3>
            <a href="get_productos_xhtml_v2.php" class="btn btn-primary">Ver todos los productos</a>
            <a href="get_productos_vigente_v2.php" class="btn btn-secondary">Ver productos vigentes</a>
        </div>
    </div>
</body>
</html>