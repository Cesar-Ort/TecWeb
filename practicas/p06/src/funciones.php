<?php
//Primer ejercicio
    function multiplo5y7($numero){
        $numero = (int)$numero;
        return [
            'numero' => $numero,
            'multi5' => ($numero % 5 === 0),
            'multi7' => ($numero % 7 === 0),
            'multiplosAmbos' => ($numero % 35 === 0),
        ];
    }
//Segundo ejercicio
    function GSP($min = 1,$max = 9999 ){
        $rows = [];
        $iteracion = 0;

        while (true) {
            $a = rand($min, $max);
            $b = rand($min, $max);
            $c = rand($min, $max);
            $rows[] = [$a, $b, $c];
            $iteracion++;

            if (($a % 2 !== 0) && ($b % 2 !== 0) && ($c % 2 !==0)) {
                break;
            }
            if ($iteracion > 10000){
                break;
            }
        }
        return [
        'rows' => $rows,
        'iteracion' => $iteracion,
        'total_numeros' => $iteracion * 3
        ];
    }
    
//Tercer ejercicio
    function encontrarMultiploWhile($n, $min=1, $max = 10000){
        $intentos = 0;
        while(true) {
            $num = rand($min,$max);
            $intentos++;
            if ($n !=0 && $num % $n === 0){
                return ['numero' => $num, 'intentos' => $intentos];
            }
            if ( $intentos > 10000){
                return ['numero' => null, 'intentos' => $intentos];
            }
        }
    }

    function encontrarMultiploDoWhile($n, $min=1, $max = 10000){
        $intentos=0;
        do {
            $num = rand($min, $max);
            $intentos++;
            if( $intentos > 10000);
        } while($n == 0 || $num % $n !== 0);
        if( $n == 0){
            return [ 'numero' => null, 'intentos' => $intentos];
        }
        return [ 'numero' => $n, 'intentos'=> $intentos];
    }

//Cuarto ejercicio
    function arregloAscii() {
        $arr = [];
        for($i=97; $i<122; $i++){
            $arr[$i] = chr[$i];  
        }
        return $arr;
    }
?>