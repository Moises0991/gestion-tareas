<?php
             $config = include '../config.php';
             session_start();
             include '../usuario.php';
         
             $dns = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
             // a continuacion se crea la variable con el pdo que servira para la conexion a la base de datos
             $conexion = new PDO ($dns, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
            $file_name = $_FILES['file']['name'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $ruta = "../tareas_terminadas/". $file_name;
            move_uploaded_file($file_tmp,$ruta);
            $id= $_SESSION['id_tarea'];

            $consulta = "SELECT MAX(id) AS id FROM tareas_asignadas";
            $sentencia = $conexion -> prepare($consulta);
            $sentencia -> execute();
            $id_ultima = $sentencia ->  fetch(PDO::FETCH_ASSOC);
            $id_tarea_actual = $id_ultima["id"]+1;
            $consultaSQL = "INSERT INTO archivos_tareas_terminadas (nombre_archivo, id_tareas) VALUES ('$file_name',' $id')";
            $conexion->query($consultaSQL);



?>