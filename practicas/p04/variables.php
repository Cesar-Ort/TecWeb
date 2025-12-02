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


        echo "<h2>Ejercicio 2</h2>";
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;

        echo "\$a = $a, \$b = $b, \$c = $c<br>";

        $a = "PHP Server";
        $b = &$a; 

        echo "Déspues de la reasignaciones:<br>";
        echo "\$a = $a, \$b = $b, \$c = $c<br>";

        echo "El valor \$c sigue siendo referencia al valor actual de \$a.";

        echo "<h2>Ejercicio 3</h2>";
        $a = "PHP5";
    $z[] = &$a;
    $b = "5a version de PHP";
    $c = $b * 10; 
    $a .= $b;
    $b *= $c;
    $z[0] = "MySQL";

    var_dump($a, $b, $c, $z);

       echo "<h2>Ejercicio 4</h2>";
    global $a, $b, $c, $z;
    echo "<p>Desde global: $a, $b, $c</p>";
    print_r($GLOBALS);


    echo "<h2>Ejercicio 5</h2>";
    $a = "7 personas";
    $b = (integer) $a;
    $a = "9E3";
    $c = (double) $a;
    var_dump($a, $b, $c);

    echo "<h2>Ejercicio 6</h2>";
    $a = "0";
    $b = "TRUE";
    $c = FALSE;
    $d = ($a OR $b);
    $e = ($a AND $c);
    $f = ($a XOR $b);

    var_dump($a, $b, $c, $d, $e, $f);

    // Para mostrar booleanos en texto:
    echo "<br>c: " . var_export($c, true);
    echo "<br>e: " . var_export($e, true);


    echo "<h2>Ejercicio 7</h2>";

    echo "Versión de Apache y PHP: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
    echo "Sistema operativo del servidor: " . PHP_OS . "<br>";
    echo "Idioma del navegador: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br>";

    //unset($a, $b, $c, $d, $e, $f, $z);
    ?>
</body>
</html>