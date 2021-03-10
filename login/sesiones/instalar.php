<?php 
 //crea una conexion     

        $conexion2 = new mysqli($host_db, $user_db, $pass_db);
//guarda el query del rchivo migracion en la variable $sql
        $sql = file_get_contents('data/migracion.sql');     //file_get_contens es un metodo que asigna una consulta sql a una varible
        //ejecuta el  query atraves de la variable
        $conexion2 -> multi_query($sql);     //exec es un metodo para ejercutar la consulta
        //te regresa al login
        header('Location: ../../index.html');

?>