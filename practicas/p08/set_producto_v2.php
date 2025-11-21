<?php
header('Content-Type: text/html; charset=utf-8');


$dbHost = 'localhost';
$dbName = 'marketzone';
$dbUser = 'root';
$dbPass = 'celo218crlo218.'; 

// Reciben datos
$nombre   = trim($_POST['nombre']   ?? '');
$marca    = trim($_POST['marca']    ?? '');
$modelo   = trim($_POST['modelo']   ?? '');
$precio   = $_POST['precio'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;
$detalles = trim($_POST['detalles'] ?? '');
$imagen   = trim($_POST['imagen']   ?? '');

// Valida el servidor
$errors = [];

// Campos obligatorios
if ($nombre === '' || $marca === '' || $modelo === '') {
    $errors[] = "Los campos Nombre, Marca y Modelo son obligatorios.";
}

// Validar precio (debe ser numérico y no negativo)
if ($precio === null || $precio === '') {
    $errors[] = "El precio es obligatorio.";
} elseif (!is_numeric($precio) || floatval($precio) < 0) {
    $errors[] = "El precio debe ser un número válido mayor o igual a 0.";
} else {
    $precio = floatval($precio);
}

// Validar cantidad (entero >= 0)
if ($cantidad === null || $cantidad === '') {
    $errors[] = "La cantidad es obligatoria.";
} elseif (!is_numeric($cantidad) || intval($cantidad) < 0) {
    $errors[] = "La cantidad debe ser un número entero mayor o igual a 0.";
} else {
    $cantidad = intval($cantidad);
}

// Si hay errores, mostrar y terminar
if (!empty($errors)) {
    echo "<h3>Errores en el formulario:</h3><ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul><p><a href='formulario_productos.html'>Regresar al formulario</a></p>";
    exit;
}

try {
    // Conexión PDO
    $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Comprobamos si existe algun duplicado (nombre + modelo + marca)
    $sqlCheck = "SELECT id FROM productos WHERE nombre = :nombre AND modelo = :modelo AND marca = :marca LIMIT 1";
    $stmt = $pdo->prepare($sqlCheck);
    $stmt->execute([
        ':nombre' => $nombre,
        ':modelo' => $modelo,
        ':marca'  => $marca
    ]);

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p>Producto duplicado: ya existe un producto con el mismo nombre, modelo y marca.</p>";
        echo "<p><a href='formulario_productos.html'>Regresar</a></p>";
        exit;
    }

    // Insertamos utilizando column names (eliminado debe tener DEFAULT 0 en la BD)
    $sqlInsert = "
      INSERT INTO productos (nombre, marca, modelo, precio, cantidad, detalles, imagen)
      VALUES (:nombre, :marca, :modelo, :precio, :cantidad, :detalles, :imagen)
    ";
    $stmt = $pdo->prepare($sqlInsert);
    $stmt->execute([
        ':nombre'   => $nombre,
        ':marca'    => $marca,
        ':modelo'   => $modelo,
        ':precio'   => $precio,
        ':cantidad' => $cantidad,
        ':detalles' => $detalles,
        ':imagen'   => $imagen
    ]);

    $idInsertado = $pdo->lastInsertId();

    echo "<h2>Producto insertado correctamente</h2>";
    echo "<p>ID: " . htmlspecialchars($idInsertado) . "</p>";
    echo "<ul>
            <li>Nombre: " . htmlspecialchars($nombre) . "</li>
            <li>Marca: "  . htmlspecialchars($marca)  . "</li>
            <li>Modelo: " . htmlspecialchars($modelo) . "</li>
            <li>Precio: $" . htmlspecialchars(number_format($precio, 2)) . "</li>
            <li>Cantidad: " . htmlspecialchars($cantidad) . "</li>
          </ul>";
    echo "<p><a href='get_productos_vigentes.php'>Ver productos vigentes</a></p>";
    echo "<p><a href='formulario_productos.html'>Agregar otro producto</a></p>";

} catch (PDOException $e) {
    // Control de errores 
    echo "<h3>Error de base de datos:</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='formulario_productos.html'>Regresar</a></p>";
    exit;
}
?>
