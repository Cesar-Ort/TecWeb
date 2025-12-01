<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        'celo218crlo218.',
        'marketzone'
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conextada!');
    }
?>