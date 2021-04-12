<?php

include 'funciones.php';
csrf();
if (isset($_POST['submit'])&& !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$config = include '../config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $id = $_GET['id'];
    $name = $_GET['solicitante'];
    $consultaSQL = "DELETE FROM usuarios_espera WHERE id=" . $id;

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    // header() es usado para enviar encabezados HTTP sin formato. 
    // header() debe ser llamado antes de mostrar nada por pantalla
    header("Location: usuarios_espera.php?solicitante=$name");
    // con la linea anterior se consiguio redireccionarnos al archivo index
    
  } catch (PDOException $error) {

    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();

  }



?>