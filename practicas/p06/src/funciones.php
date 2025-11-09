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
            $arr[$i] = chr($i);  
        }
        return $arr;
    }

//Sexto ejercicio
    function registroVehicular(){
         $vehicles = [
        'ABC1001' => [
            'Auto' => ['marca' => 'HONDA', 'modelo' => 2020, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'Alfonzo Esparza', 'ciudad' => 'Puebla, Pue.', 'direccion' => 'C.U., Jardines de San Manuel']
        ],
        'DEF2002' => [
            'Auto' => ['marca' => 'MAZDA', 'modelo' => 2019, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Ma. del Consuelo Molina', 'ciudad' => 'Puebla, Pue.', 'direccion' => '97 oriente']
        ],
        'GHI3003' => [
            'Auto' => ['marca' => 'TOYOTA', 'modelo' => 2018, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Luis García', 'ciudad' => 'México, CDMX', 'direccion' => 'Av. Reforma 123']
        ],
        'JKL4004' => [
            'Auto' => ['marca' => 'FORD', 'modelo' => 2021, 'tipo' => 'hatchback'],
            'Propietario' => ['nombre' => 'Ana Pérez', 'ciudad' => 'Guadalajara, Jal.', 'direccion' => 'Calle Hidalgo 45']
        ],
        'MNO5005' => [
            'Auto' => ['marca' => 'NISSAN', 'modelo' => 2017, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Carlos López', 'ciudad' => 'Monterrey, N.L.', 'direccion' => 'Col. Centro 10']
        ],
        'PQR6006' => [
            'Auto' => ['marca' => 'KIA', 'modelo' => 2016, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'María Torres', 'ciudad' => 'León, Gto.', 'direccion' => 'Blvd. del Parque 8']
        ],
        'STU7007' => [
            'Auto' => ['marca' => 'CHEVROLET', 'modelo' => 2015, 'tipo' => 'hatchback'],
            'Propietario' => ['nombre' => 'Pedro Jiménez', 'ciudad' => 'Querétaro, Qro.', 'direccion' => 'Av. Central 55']
        ],
        'VWX8008' => [
            'Auto' => ['marca' => 'VOLKSWAGEN', 'modelo' => 2014, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Sofía Ramírez', 'ciudad' => 'Toluca, Méx.', 'direccion' => 'C. Juárez 200']
        ],
        'YZA9009' => [
            'Auto' => ['marca' => 'HYUNDAI', 'modelo' => 2013, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Miguel Ángel', 'ciudad' => 'Cancún, Q.R.', 'direccion' => 'Zona Hotelera 3']
        ],
        'BCD1010' => [
            'Auto' => ['marca' => 'SUBARU', 'modelo' => 2022, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'Laura Méndez', 'ciudad' => 'Puebla, Pue.', 'direccion' => 'Av. Brasil 77']
        ],
        'EFG1111' => [
            'Auto' => ['marca' => 'MAZDA', 'modelo' => 2021, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Diego Rivera', 'ciudad' => 'Oaxaca, Oax.', 'direccion' => 'Centro 12']
        ],
        'HIJ1212' => [
            'Auto' => ['marca' => 'HONDA', 'modelo' => 2012, 'tipo' => 'hatchback'],
            'Propietario' => ['nombre' => 'Cristina Flores', 'ciudad' => 'Puebla, Pue.', 'direccion' => 'Villas del Sol 4']
        ],
        'KLM1313' => [
            'Auto' => ['marca' => 'RENAULT', 'modelo' => 2010, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Raúl Mendoza', 'ciudad' => 'Veracruz, Ver.', 'direccion' => 'Col. Reforma 3']
        ],
        'NOP1414' => [
            'Auto' => ['marca' => 'BMW', 'modelo' => 2019, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Isabel Soto', 'ciudad' => 'Puebla, Pue.', 'direccion' => 'Lomas 9']
        ],
        'QRS1515' => [
            'Auto' => ['marca' => 'AUDI', 'modelo' => 2018, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'Fernando Cruz', 'ciudad' => 'Chihuahua, Chih.', 'direccion' => 'Av. Independencia 2']
        ]
    ];
    return $vehicles;
    }
    function validarMatriculaFormato($mat) {
    return preg_match('/^[A-Z]{3}[0-9]{4}$/', strtoupper($mat)) === 1;
    }
?>