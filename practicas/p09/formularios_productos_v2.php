<?php
// Recibir datos por GET si vienen (para edición)
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$nombre = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '';
$marca = isset($_GET['marca']) ? htmlspecialchars($_GET['marca']) : '';
$modelo = isset($_GET['modelo']) ? htmlspecialchars($_GET['modelo']) : '';
$precio = isset($_GET['precio']) ? htmlspecialchars($_GET['precio']) : '';
$cantidad = isset($_GET['cantidad']) ? htmlspecialchars($_GET['cantidad']) : '';
$detalles = isset($_GET['detalles']) ? htmlspecialchars($_GET['detalles']) : '';
$imagen = isset($_GET['imagen']) ? htmlspecialchars($_GET['imagen']) : '';

// Determinar si es edición o registro nuevo
$esEdicion = !empty($id);

// CRÍTICO: Cambiar el action según el modo
if ($esEdicion) {
    $action = "update_producto.php";
    $titulo = "Edición de producto";
    $botonTexto = "Actualizar producto";
} else {
    $action = "set_producto_v2.php";
    $titulo = "Agregación de producto";
    $botonTexto = "Enviar formulario";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?php echo $titulo; ?></title>
    <style type="text/css">
        body { 
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; 
            max-width: 900px; 
            margin: 24px auto; 
            padding: 0 12px; 
        }
        ul { list-style-type: none; padding-left: 0;}
        legend {font-weight: bold; }
        fieldset { margin-top: 16px; padding: 15px; }
        li { margin: 10px 0; }
        label { display: inline-block; width: 160px; }
        .actions { margin-top: 12px; }
        
        /* Estilos para botones del formulario */
        .btn-submit {
            background-color: #4CAF50;
            color: white;
            padding: 12px 28px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(76, 175, 80, 0.3);
        }
        
        .btn-submit:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(76, 175, 80, 0.4);
        }
        
        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(76, 175, 80, 0.3);
        }
        
        .btn-reset {
            background-color: #ff9800;
            color: white;
            padding: 12px 28px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(255, 152, 0, 0.3);
            margin-left: 10px;
        }
        
        .btn-reset:hover {
            background-color: #e68900;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(255, 152, 0, 0.4);
        }
        
        .btn-reset:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(255, 152, 0, 0.3);
        }
        
        .btn-cancelar {
            background-color: #f44336;
            color: white;
            padding: 12px 28px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(244, 67, 54, 0.3);
        }
        
        .btn-cancelar:hover {
            background-color: #da190b;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(244, 67, 54, 0.4);
        }
        
        .btn-cancelar:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(244, 67, 54, 0.3);
        }
        .info-box {
            background-color: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196f3;
            margin-bottom: 20px;
        }
        .modo-edicion {
            background-color: #fff3cd;
            border-left-color: #ffc107;
        }
    </style>
</head>
<body>
    <?php if ($esEdicion): ?>
        <div class="info-box modo-edicion">
            <strong>MODO EDICIÓN:</strong> Estás editando el producto ID: <?php echo $id; ?>
        </div>
    <?php endif; ?>

    <h1><?php echo $titulo; ?></h1>

    <form id="formularioProducto" action="<?php echo $action; ?>" method="post">
        
        <?php if ($esEdicion): ?>
            <!-- Campo oculto con el ID del producto a modificar -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>

        <fieldset>
            <legend>Formulario para Tintas</legend>
            <ul>
                <li>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" 
                           value="<?php echo $nombre; ?>" 
                           placeholder="Nombre del producto">
                </li>
                <li>
                    <label for="marca">Marca:</label>
                    <select name="marca" id="marca">
                        <option value="">-- SELECCIONA UNO --</option>
                        <option value="brother" <?php echo ($marca === 'brother') ? 'selected' : ''; ?>>Brother</option>
                        <option value="hp" <?php echo ($marca === 'hp') ? 'selected' : ''; ?>>HP</option>
                        <option value="epson" <?php echo ($marca === 'epson') ? 'selected' : ''; ?>>Epson</option>
                        <option value="canon" <?php echo ($marca === 'canon') ? 'selected' : ''; ?>>Canon</option>
                        <option value="generico" <?php echo ($marca === 'generico') ? 'selected' : ''; ?>>Generico</option>
                    </select>
                </li>
                <li>
                    <label for="modelo">Modelo:</label>
                    <input type="text" name="modelo" id="modelo" 
                           value="<?php echo $modelo; ?>" 
                           placeholder="Modelo de equipo">
                </li>
                <li>
                    <label for="precio">Precio:</label>
                    <input type="number" name="precio" id="precio" 
                           value="<?php echo $precio; ?>" 
                           step="0.01"
                           min="100" max="1000000" 
                           placeholder="Precio al público">
                </li>
                <li>
                    <label for="cantidad">Unidades:</label>
                    <input type="number" name="cantidad" id="cantidad" 
                           value="<?php echo $cantidad; ?>" 
                           min="0"
                           max="100000" 
                           placeholder="Piezas disponibles">
                </li>
                <li>
                    <label for="detalles">Detalles:</label>
                    <input type="text" name="detalles" id="detalles" 
                           value="<?php echo $detalles; ?>" 
                           maxlength="250" 
                           placeholder="Descripción del producto">
                </li>
                <li>
                    <label for="imagen">Imagen (URL):</label>
                    <textarea name="imagen" id="imagen" rows="3" cols="60" 
                              maxlength="500" 
                              placeholder="URL de la imagen (opcional)"><?php echo $imagen; ?></textarea>
                </li>
            </ul>
        </fieldset>

        <p class="actions">
            <input type="submit" value="<?php echo $botonTexto; ?>" class="btn-submit">
            <input type="reset" value="Restablecer" class="btn-reset">
            <a href="get_productos_xhtml_v2.php" class="btn-cancelar">Cancelar</a>
        </p>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("formularioProducto");

            form.addEventListener("submit", function (event) {
                // Obtener valores
                const nombre = document.getElementById("nombre").value.trim();
                const marca = document.getElementById("marca").value;
                const modelo = document.getElementById("modelo").value.trim();
                const precioRaw = document.getElementById("precio").value;
                const precio = precioRaw === "" ? NaN : parseFloat(precioRaw);
                const detalles = document.getElementById("detalles").value.trim();
                const unidadesRaw = document.getElementById("cantidad").value;
                const unidades = unidadesRaw === "" ? NaN : parseInt(unidadesRaw, 10);
                const imagen = document.getElementById("imagen").value.trim();

                let errores = "";

                // Validación del nombre: menos de 100 caracteres
                if (nombre === "" || nombre.length > 100) {
                    errores += "- ERROR 00 \n El nombre es obligatorio y debe tener máximo 100 caracteres.\n";
                }

                // Validación de la marca: debe elegirse (select)
                if (marca === "") {
                    errores += "- ERROR 01 \n Debes seleccionar una marca.\n";
                }

                // Validación del modelo: que sea alfanumérico y menos de 25 caracteres
                const regexModelo = /^[A-Za-z0-9\s\-]+$/;
                if (modelo === "" || modelo.length > 25 || !regexModelo.test(modelo)) {
                    errores += "- ERROR 03 \n El modelo es obligatorio, máximo 25 caracteres y solo caracteres alfanuméricos, espacios o guiones.\n";
                }

                // Validación del precio: debe ser mayor a 99.99
                if (isNaN(precio) || precio <= 99.99) {
                    errores += "- ERROR 04 \n El precio debe ser un número mayor a 99.99.\n";
                }

                // Validación de los detalles: es opcional, pero si se usa que sea menor a 250 caracteres
                if (detalles.length > 250) {
                    errores += "- ERROR 05 \n Los detalles deben tener máximo 250 caracteres.\n";
                }

                // Validación de las unidades: tiene que ser mayor o igual a 0
                if (isNaN(unidades) || unidades < 0) {
                    errores += "- ERROR 06 \n Las unidades deben ser un número entero mayor o igual a 0.\n";
                }

                // Validación de la imagen: si está vacío, se asigna ruta por defecto
                if (imagen === "") {
                    document.getElementById("imagen").value = "src/imagen.png";
                }

                // Si hay errores → cancelar envío
                if (errores !== "") {
                    alert("Corrige los siguientes errores:\n\n" + errores);
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
</body>
</html>