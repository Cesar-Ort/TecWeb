<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__.'/src/funciones.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6: Funciones, arreglos y ciclos PHP</title>
</head>
<body>
    <h1>Práctica 6: Funciones, arreglos y ciclos PHP</h1>


    <fieldset>
        <legend>Ejercicio 1: ¿Es multiplo de 5 y 7? (Ingresa un numero)</legend>
            <form method="get">
                <label for="numero">Número (GET):</label>
                <input type="number" id="numero" name="numero" value="<?php echo htmlspecialchars($_GET['numero'] ?? ''); ?>">
                <input type="submit" value= "Comprobar">
            </form>
    
    <?php
        if(isset($_GET['numero']))
        {
             $res = multiplo5y7($_GET['numero']);
            echo "<p>Valor comprobado: <strong>" . $res['numero'] . "</strong></p>";
            echo "<ul>";
            echo "<li>Múltiplo de 5: " . ($res['multi5'] ? 'Sí' : 'No') . "</li>";
            echo "<li>Múltiplo de 7: " . ($res['multi7'] ? 'Sí' : 'No') . "</li>";
            echo "<li>Múltiplo de ambos (35): " . ($res['multiplosAmbos'] ? 'Sí' : 'No') . "</li>";
            echo "</ul>";
            unset($res);
        }
    ?>
    </fieldset>

        <fieldset>
            <legend>Ejercicio 2: Generar triples aleatorios hasta patrón par o impar</legend>
            <form method="post">
                <input type="hidden" name="ejem2" value="1">
                <label for="min">Mínimo:</label>
                <input type="number" id="min" name="min" value="1">
                <label for="max">Máximo:</label>
                <input type="number" id="max" name="max" value="9999">
                <input type="submit" value="Generar">
            </form>
                <?php
            if(isset($_POST["ejem2"]))
            {
                $min = (int)($_POST['min'] ?? 1);
                $max = (int)($_POST['max' ?? 9999]);
                $out = GSP($min,$max);
                    echo "<p>Iteraciones: <strong>" . $out['iterations'] . "</strong> — Números generados: <strong>" . $out['total_numbers'] . "</strong></p>";
                    echo "<table><thead><tr><th>#</th><th>n1</th><th>n2</th><th>n3</th></tr></thead><tbody>";
                    $i = 1;
            foreach ($out['rows'] as $row) {
                echo "<tr><td>" . $i++ . "</td><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>";
            }
            echo "</tbody></table>";
            unset($out);
            }
        ?>
        </fieldset>

        <fieldset>
            <legend>Ejercicio 3: Buscar multiplo de un numero usando While y DoWhile</legend>
                <form method="get">
                <label for="n">Buscar múltiplo de (GET):</label>
                <input type="number" id="n" name="n" value="<?php echo htmlspecialchars($_GET['n'] ?? ''); ?>">
                <input type="submit" value="Buscar">
                </form>
                <?php
        if (isset($_GET['n']) && $_GET['n'] !== '') {
            $n = (int)$_GET['n'];
            echo "<h4>Usando while</h4>";
            $r1 = encontrarMultiploWhile($n);
            echo "<p>Número encontrado: " . ($r1['number'] ?? '—') . " después de {$r1['attempts']} intentos.</p>";
            echo "<h4>Usando do-while</h4>";
            $r2 = encontrarMultiploDoWhile($n);
            echo "<p>Número encontrado: " . ($r2['number'] ?? '—') . " después de {$r2['attempts']} intentos.</p>";
            unset($r1, $r2);
        }
        ?>
        </fieldset>

        <fieldset>
            <legend>Ejercicio 4: arreglo con ASCII </legend>
            <?php
        $arr = arregloAscii();
        echo "<table><thead><tr><th>Código</th><th>Letra</th></tr></thead><tbody>";
        foreach ($arr as $key => $val) {
            echo "<tr><td>$key</td><td>$val</td></tr>";
        }
        echo "</tbody></table>";
        unset($arr);
        ?>
        </fieldset>
    
</body>
</html>