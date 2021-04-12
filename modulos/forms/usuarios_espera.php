<?php include 'header.php'?>
<!-- aqui haremos modificaciones para que el manager funcione
1- hay modificaciones en el header de la carpeta forms -->
<?php
        // include 'funciones.php';
        if (isset($_GET['solicitante']))
        {
        $color = 'danger';
          $resultado = [
            'error' => false,
              'mensaje' => 'El solicitante ' . escapar($_GET['solicitante']) . ' ha sido rechazado con exito'
           ];

        }

        if(isset($_GET['aprobado']))
        {
          $color = 'success';

          $resultado = [
            'error' => false,
              'mensaje' => 'El solicitante ' . escapar($_GET['aprobado']) . ' ha sido aprobado con exito'
           ];

        }

        csrf();
        if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
            die();
        }
        
        $error = false;
        $config = include '../config.php';
// aqui inicia la consulta para ver las tareas


try {

  // el objetivo de las dos lineas siguientes es el de guardar los datos del dns y el pdo para establecer la proxima conexion a la bd
  $dns = 'mysql:host=' . $config['db']['host'] .';dbname=' . $config['db']['name'];
  $conexion = new PDO($dns, $config['db']['user'] ,$config['db']['pass'] ,$config['db']['options']);


  $consultaSQL = "SELECT * FROM usuarios_espera";


  // a continuacion se guarda en "sentencia" la preparacion del sql que creara la conexion con la base de datos
  $sentencia = $conexion -> prepare($consultaSQL);
  // en la siguiente linea se ejecuta la sentencia sql anterior, con el fin de que se realize la conexion y se muestren todos los datos de la tabla alumnos
  $sentencia -> execute();
  // PDOStatement::fetchAll(), devuelve un array que contiene todas las filas restantes del conjunto de resultados.
  $tarea = $sentencia -> fetchAll();

  
} catch (PDOException $error) {

  //en el momento de que exista algun error, primero verifico que exista la base de datos 
           $error = $error -> getMessage();

}

// en la siguiente linea se emplea un operador ternario ($resultado = $condicion ? 'verdadero' : 'falso';)
// la siguiente instruccion quiere decir si la posicion con valor "apellido" del array post se encuentra definida? entonces
// agregar entre parentesis el apellido al titulo; sino lista de alumnos se queda igual
// termina 

?>        

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Solicitud de registro</h1>
          </div>
          
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
         <li class="breadcrumb-item"><a href="#">Home</a></li>
         <li class="breadcrumb-item active">Solicitud de usuarios</li>
            </ol>
          </div>    
                  </div>
<!-- ------------------- -->
                  <?php
    if (isset($resultado)) {
      ?>
      <!-- el siguiente codigo se encuentra dentro de html -->
      <div class="container mt-3">
        <div class="row">
          <div class="col-md-12">
            <!-- en el siguiente div se establece si el mensaje sera de danger o success, dependiendo de lo que almacene $resultado -->
            <!-- a continuacion con el \<\?=cosa a imprimir?> se consigue de foma mas corta la impresion echo en php -->
            <div class="alert alert-<?= $resultado['error'] ? 'danger' : $color ?>" role="alert">
              <?= $resultado['mensaje'] ?>
            </div>
          </div>
        </div>
      </div>
      <?php
    }
    ?> 

<!-- ----------------------------------- -->
      </div><!-- /.container-fluid -->

    </section>

   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="justify-content-center">
        
        <div class="card">
          
              <div class="card-header">
   
                <h3 class="card-title">Estas son solicitudes de registro</h3>

         <div class="card-tools">
                  <!-- <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                  </ul> -->
                 
                  <form class="form-inline" method="post">
                
                    <input type="search" name="buscar_tarea" class="form-control form-control-navbar" placeholder="Nombre tarea" value="">
                   
                    
                    <button type="submit" class="btn btn-default">
                       <i class="fa fa-search"></i>
                     </button>
                      
            </form>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th >#</th>
                      <th>Nombre del solicitante</th>
                      <th>Puesto</th>
                      <th>email</th>
                      <th >Fecha solicitud</th>
                       <th>Accion</th>
                    


                    </tr>
                  </thead>
                  <tbody>

                    <?php
                            // rowCount() devuelve el número de filas afectadas por la última sentencia DELETE, INSERT, o UPDATE
                            // y el proposito de rowCount es saber si existen a alumnos
                            if ($tarea && $sentencia -> rowCount()>0) {
                              $i=0;
                                foreach ($tarea as $fila) {
                                    $i=$i+1;
                                    switch ($fila['puesto'])              
                                     {
                                      case "Empleado":
                                        $estilo="badge bg-primary";

                                        break;
                                        case "Gerente":
                                         $estilo="badge bg-success";
                                         break;
                                         
                                     }
                                     

                                   ?>
                                    <!-- lo que se viene a continuacion no es codigo php y, sirve para que se vallan mostrando las filas con la informacion que hay
                                    en el array $fila (que fila es una posicion de la tabla alumnos [por lo tanto alumnos es $sentencia]) -->
                                  
                                    <tr>
                                        <td><?php echo escapar($i);?></td>
                                        <td><?=escapar($fila["username"]);?></td>
                                      <td ><span class="<?=escapar($estilo);?>"><?=escapar($fila["puesto"]);?></span></td>
              
                                        <td><?=escapar($fila["email"]);?></td>
                                         
                                        <td><?=escapar($fila["create_at"]);?></td>

                                        <td >  <a href="<?= 'aceptar_usuario.php?id=' . escapar($fila["id"]) ?>">️️<button type="button" class="btn btn-info ">Ver solicitud</button></a></span></td>   
                                     
                                    
                                    <?php
                                    
                                }
                              }
                                  ?>
                                   

                   
                    <!-- <tr>
                      <td>2.</td>
                      <td>Limpiar base de datos</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar bg-warning" style="width: 70%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-warning">70%</span></td>
                      <th>Ver tarea</th>
                    </tr>
                    <tr>
                      <td>3.</td>
                      <td>Ajustar div</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-primary" style="width: 30%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-primary">30%</span></td>
                      <th>Ver tarea</th>
                    </tr>
                    <tr>
                      <td>4.</td>
                      <td>Reparar errores</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-success" style="width: 90%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-success">90%</span></td>
                      <th>Ver tarea</th> 

                    </tr> -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-rc
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
