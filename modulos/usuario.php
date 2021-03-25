<?php


if (isset($_SESSION['manager'])) {
    $user = $_SESSION['manager'];
    $id_usuarios_archivos = $_SESSION['userid'];

  } else if (isset($_SESSION['employee'])) {
    $user = $_SESSION['employee'];
    $id_usuarios_archivos = $_SESSION['id_employee'];
  }
?>