<?php 
    session_start();
    
    // se validad que sea el usuario autorizado
    if (!isset($_SESSION['employee'])) 
    {
        header("location: ../../index.php"); 
    }
    
    echo 'esta es la pagina del empleado';
    // session_destroy();
?>
