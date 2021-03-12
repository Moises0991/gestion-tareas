<?php 
    session_start();

    // se validad que sea el usuario autorizado
    if (!isset($_SESSION['manager'])) 
    {
        header("location: ../../index.php"); 
    }

    echo 'esta es la pagina del manager';
    // session_destroy(); //va al final
?>