<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4: variables de PHP</title>
</head>
<body>
    <h2>Practica 4</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>

    <?php
        echo "<h2>Ejercicio 1</h2>";
        $myvar = "Valida";
        $var7 = "Válida";
        $_myvar = "Válida";
        $_element1 = "Válida";
        /* 
        myvar es inválida porque falta $
        $house*5 es inválida porque no se permite * en nombres
        */ 
        echo "<p> Las variables válidas son: \$myvar, \$var7, \$_myvar, \$_element1</p>";

    ?>
</body>
</html>