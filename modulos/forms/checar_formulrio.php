<?php
if (isset($_POST['nombre'])){
    $nombre_tarea= $_POST['nombre'];

   echo $nombre_tarea. '<br>';
   $nombre_usuario= $_POST['usuarios'];
   echo $nombre_usuario. '<br>';
   $descripcion_tarea =$_POST['descripcion'];
   echo $descripcion_tarea. '<br>';
   $importancia_tarea =$_POST['importancia'];

   echo $importancia_tarea;
   $fecha_termina =$_POST['fecha_expira'];
   echo $fecha_termina;
    
   echo "soy un texto";

} 
?>