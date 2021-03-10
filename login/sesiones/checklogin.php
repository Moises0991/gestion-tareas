<?php
session_start();
?>

<?php

$host_db = "localhost";
$user_db = "root";
$pass_db = "";
$db_name = "data_usuarios1";
$tbl_name = "usuarios";


$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
//si hay algun error con la conexion, crea la base de datos 
 include 'instalar.php';
 die("La conexion falló: " . $conexion->connect_error);
 
}

$username = $_POST['username'];
$password = $_POST['password'];




$sql = "SELECT * FROM $tbl_name WHERE nombre_usuario = '$username'";

$result = $conexion->query($sql);


if ($result->num_rows > 0) {     
 }
 $row = $result->fetch_array(MYSQLI_ASSOC);

   $password = md5($password);

    if($password == $row['password_usuario']){
 
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (5 * 10);

    echo "Bienvenido! " . $_SESSION['username'];
    header('Location: ../../index1.html');
   

 } else { 
   echo "Username o Password estan incorrectos.";

   echo "<br><a href='../../index.html'>Volver a Intentarlo</a>";
 }
 mysqli_close($conexion); 
 ?>

