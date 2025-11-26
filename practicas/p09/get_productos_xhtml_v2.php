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
    // Mensaje de error claro para desarrollo; en producción muestra algo genérico.
    die("Error en la conexión a la BD: " . $conexion->connect_error);
}

if ($tope !== null) {
    // Filtrar por unidades <= $tope
    $topeSafe = intval($tope); // ya fue casteado, esto es por seguridad
    $query = "SELECT * FROM productos WHERE unidades <= $topeSafe ORDER BY id ASC";
} else {
    // Sin parámetro: devuelve todos los productos
    $query = "SELECT * FROM productos ORDER BY id ASC";
}


// Ejecutar consulta
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
        /* Generacion de estilo sencillo para una mejor visualización */
        body { font-family: Arial, sans-serif; margin: 20px; }
        .producto { margin-bottom: 12px; padding:8px; border:1px solid #ccc; border-radius:4px; }
        .thumb { max-width:120px; display:block; margin-bottom:6px; }
        .precio { font-weight:bold; }
    </style>
</head>
<body>
<h1>Productos<?php echo ($tope !== null) ? " (unidades ≤ " . htmlspecialchars($tope) . ")" : ""; ?></h1>

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
        $unidades = isset($row['unidades']) ? intval($row['unidades']) : 0;
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
        echo "</div>";
    }
}
?>

</body>
</html>
<?php
$conexion->close();
?>
