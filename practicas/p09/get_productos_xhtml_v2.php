<?php
// Content-Type para XHTML
header("Content-Type: application/xhtml+xml; charset=UTF-8");

$tope = isset($_GET['tope']) ? intval($_GET['tope']) : null;

$host = "localhost";               
$user = "root";                    
$pass = "celo218crlo218.";         
$db   = "marketzone";              

$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Error en la conexión a la BD: " . $conexion->connect_error);
}

if ($tope !== null) {
    $topeSafe = intval($tope);
    $query = "SELECT * FROM productos WHERE unidades <= $topeSafe ORDER BY id ASC";
} else {
    $query = "SELECT * FROM productos ORDER BY id ASC";
}

$resultado = $conexion->query($query);
if ($resultado === false) {
    die("Error en la consulta: " . $conexion->error);
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Productos - Marketzone</title>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    
    <style type="text/css">
        body { font-family: Arial, sans-serif; margin: 20px; }
        .producto { margin-bottom: 12px; padding:8px; border:1px solid #ccc; border-radius:4px; }
        .thumb { max-width:120px; display:block; margin-bottom:6px; }
        .precio { font-weight:bold; }
        .btn-modificar {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 8px;
        }
        .btn-modificar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<h1>Productos<?php if($tope !== null) { echo " (unidades menor o igual a " . htmlspecialchars($tope) . ")"; } ?></h1>

<?php
if ($resultado->num_rows === 0) {
    echo "<p>No se encontraron productos.</p>";
} else {
    while ($row = $resultado->fetch_assoc()) {
        $id = htmlspecialchars($row['id']);
        $nombre = htmlspecialchars($row['nombre']);
        $marca = isset($row['marca']) ? htmlspecialchars($row['marca']) : '';
        $modelo = isset($row['modelo']) ? htmlspecialchars($row['modelo']) : '';
        $precio = isset($row['precio']) ? htmlspecialchars($row['precio']) : '';
        $detalles = isset($row['detalles']) ? htmlspecialchars($row['detalles']) : '';
        
        // CORREGIDO: Verificar si existe la columna 'unidades' o 'cantidad'
        if (isset($row['unidades'])) {
            $unidades = intval($row['unidades']);
        } elseif (isset($row['cantidad'])) {
            $unidades = intval($row['cantidad']);
        } else {
            $unidades = 0;
        }
        
        $imagen = isset($row['imagen']) ? $row['imagen'] : '';
        
        $imgFolder = "img"; 
        if ($imagen !== '') {
            if (strpos($imagen, '/') !== false) {
                $imgSrc = $imagen;
            } else {
                $imgSrc = $imgFolder . '/' . $imagen;
            }
        } else {
            $imgSrc = ''; 
        }

        echo "<div class=\"producto\" id=\"prod-$id\">";
        if ($imgSrc !== '') {
            echo "<img src=\"" . htmlspecialchars($imgSrc) . "\" alt=\"" . $nombre . "\" class=\"thumb\" />";
        }
        echo "<h2>" . $nombre . "</h2>";
        echo "<p>Marca: " . $marca . " | Modelo: " . $modelo . "</p>";
        echo "<p class=\"precio\">Precio: $" . $precio . " | Unidades: " . $unidades . "</p>";
        echo "<p>" . nl2br($detalles) . "</p>";
        echo "<p><a href=\"get_producto_by_id.php?id=" . $id . "\">Ver detalle</a></p>";
        
        // CORREGIDO: Usar htmlspecialchars para toda la URL (convierte & en &amp; automáticamente)
        $urlModificar = htmlspecialchars(
            "formulario_productos_v2.php?id=" . $row['id'] . 
            "&nombre=" . urlencode($row['nombre']) .
            "&marca=" . urlencode($row['marca']) .
            "&modelo=" . urlencode($row['modelo']) .
            "&precio=" . urlencode($row['precio']) .
            "&cantidad=" . $unidades .
            "&detalles=" . urlencode($row['detalles']) .
            "&imagen=" . urlencode($row['imagen'])
        );
        
        echo "<a href=\"" . $urlModificar . "\" class=\"btn-modificar\">Modificar</a>";
        echo "</div>";
    }
}
?>

</body>
</html>
<?php
$conexion->close();
?>