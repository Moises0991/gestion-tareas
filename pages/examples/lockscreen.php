<!-- uso de cookies -->
<?php
  if(isset($_COOKIE['username']))
  { 
    $username = $_COOKIE['username']; 
  } 

  if(isset($_COOKIE['nickname']))
  { 
    $nickname = $_COOKIE['nickname']; 
  } 

?>

<!-- se guarda el nombre del usuario -->
<?php
  session_start();
  if (isset($_SESSION['manager'])){
    $username = $_SESSION['username']; 
    $nickname = $_SESSION['manager'];
    setcookie('username', $username); 
    setcookie('nickname', $nickname); 
  } else if (isset($_SESSION['employee'])){
    $username = $_SESSION['username'];
    $nickname = $_SESSION['employee'];
    setcookie('username', $username); 
    setcookie('nickname', $nickname); 
  }
  session_destroy();
?>

<!-- comienzo del html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sesion expirada</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

  <style>
    html{
      background: url("https://www.yaencontre.com/noticias/wp-content/uploads/2018/09/laptop-2557574_1920-1.jpg") 50% fixed;
      background-size: cover;
      height: 100%;
    }
    body {
    color: whitesmoke;
    }
    b {
      color:white;
    }
  </style>
</head>
<body class="hold-transition lockscreen" style=" background: rgba(4, 40, 68, 0.85);">
  <!-- Automatic element centering -->
  <div class="lockscreen-wrapper" style="padding-top: 10%; margin-top: 0%;">
    <div class="lockscreen-logo">
      <a href="../../index2.html" style="color:white"><b>Nice</b>Code</a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name" style="color: #cddc39; text-transform: capitalize;"><?=$username?></div>
    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
      <!-- lockscreen image -->
      <div class="lockscreen-image">
        <img src="view.php?nickname='<?=$nickname?>'" style="object-fit: cover;" alt="User Image">
      </div>
      <!-- /.lockscreen-image -->

      <!-- lockscreen credentials (contains the form) -->
      <form class="lockscreen-credentials" action="checklog.php" method="post">
        <div class="input-group">
          <input type="hidden" name="nickname" value="<?=$nickname?>">
          <input type="password" class="form-control" placeholder="password" name="password">

          <div class="input-group-append">
            <button type="button" class="btn">
              <i class="fas fa-arrow-right text-muted"></i>
            </button>
          </div>
        </div>
      </form>
      <!-- /.lockscreen credentials -->

    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
      Ingrese contraseña para recuperar su sesión
    </div>
    <div class="text-center">
      <a href="../../index.php">O ingrese con usuario diferente</a>
    </div>
  </div>
  <!-- /.center -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>