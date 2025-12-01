<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_POST['id']) ) {
    $id = $_POST['id'];
    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    if ( $result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'") ) {
        // SE OBTIENEN LOS RESULTADOS
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if(!is_null($row)) {
            // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
            foreach($row as $key => $value) {
                $data[$key] = $value;
            }
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }
    $conexion->close();
} 
// NUEVA FUNCIONALIDAD: Búsqueda por nombre, marca o detalles
elseif( isset($_POST['search']) ) {
    $search = $_POST['search'];
    // SE REALIZA LA QUERY DE BÚSQUEDA CON LIKE
    $query = "SELECT * FROM productos WHERE (nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
    
    if ( $result = $conexion->query($query) ) {
        // SE OBTIENEN TODOS LOS RESULTADOS
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            // SE CODIFICAN A UTF-8 LOS DATOS Y SE AGREGAN AL ARREGLO DE RESPUESTA
            $data[] = $row;
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }
    $conexion->close();
}
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>