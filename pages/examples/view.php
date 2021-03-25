<?php
    
    session_start();
    include '../../login/data/config.php';
    $conection = new mysqli($host_name, $user_db, $pass_db, $db_name);

    //revisar conexion
    if($conection->connect_error){
    //    die("Connection failed: " . $conection->connect_error);
    }
    
    // queries para determina tipo de usuario
    $sql_managers = "SELECT * FROM managers WHERE nickname = {$_GET['nickname']}";
    $sql_employees = "SELECT * FROM employees WHERE nickname = {$_GET['nickname']}";

    // se ejecutan quieries
    $managers_query = $conection -> query($sql_managers);
    $employees_query = $conection -> query($sql_employees);

    // se evalua tipo de usuario
    if (mysqli_num_rows($managers_query) > 0) {
        $table = 'managers';
    } else if(mysqli_num_rows($employees_query) > 0){
        $table = 'employees';
    } 

    // se ejecuta consulta final independientemente de la tabla origen
    $sql = "SELECT picture FROM $table WHERE nickname = {$_GET['nickname']}";
    $sentence = $conection -> query($sql);


    if($sentence->num_rows > 0){
        $imgDatos = $sentence->fetch_assoc();
        
        // se muestran datos
        header("Content-type: image/jpg"); 
        echo $imgDatos['picture']; 
    }else{
        echo 'Imagen no existe...';
    }
?>