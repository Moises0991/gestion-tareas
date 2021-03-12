<?php 
    include 'config.php';

    try {
        $conection = new PDO ('mysql:host=' . $host_name, $user_db, $pass_db);
        $sql = file_get_contents("migration.sql");  //file_get_contens es un metodo que asigna una consulta sql a una varible
        $conection -> exec($sql); 
        echo "Base de datos y tablas creadas con exito";
        // header('Location: ../../index.php');

    } catch (PDOException $error) {
        echo $error -> getMessage();
    }
?>