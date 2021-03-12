<?php
    // if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    //     die();
    // }
    return [
        // a continuacion se crea un array que contiene la informacion necesaria para realizar la configuracion de la conexion con la base de datos
        'db' => [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'name' => 'data_users',
            // ATTR_ERRMODE:  es un atributo que sirve para el Reporte de errores.
            // los pdo sirven para realizar la conexion con la base de datos (aunque no en este caso)
            // el operador de resolucion de ambito :: permite acceder a elementos estaticos, constantes y sobreescribir propiedades o metodos de una clase
            // PDO::ERRMODE_EXCEPTION: sirve para lanzar exceptions
            'options' => [
                // a continuacion se esta accediendo a los atributos del objeto pdo, con el objetivo de notificar errores
                PDO :: ATTR_ERRMODE => PDO :: ERRMODE_EXCEPTION
            ]
        ]
    ];
?>
