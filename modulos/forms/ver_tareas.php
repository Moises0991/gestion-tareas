
<?php include 'header.php';?>

 <?php
//  include 'funciones.php';
 csrf();
 if (isset($_POST['submit'])&& !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
     die();
 }

 try {
  $config = include '../config.php';
   
  $dns = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  // a continuacion se crea la variable con el pdo que servira para la conexion a la base de datos
  $conexion = new PDO ($dns, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  // $hoy = getdate();
 $_SESSION['id_tarea'] =  $_GET['id'];
 $id =  $_GET['id'];
  
  $consultaSQL = "SELECT *FROM tareas_asignadas WHERE id=" . $id;
  $sentencia = $conexion -> prepare($consultaSQL);
  $sentencia -> execute();
  $tareas = $sentencia -> fetch(PDO::FETCH_ASSOC);
    
  //modificacion para agragar descarga 25/03/21
  $consulta_archivos= "SELECT  nombre_archivo FROM archivos_tareas where id_tareas=" . $id;
  $sentencia1 = $conexion -> prepare($consulta_archivos);
  $sentencia1 -> execute();
  $archivos = $sentencia1 -> fetchAll();

  $consulta_archivos_entregados= "SELECT nombre_archivo FROM archivos_tareas_terminadas where id_tareas=" . $id;
  $sentencia9 = $conexion -> prepare($consulta_archivos_entregados);
  $sentencia9 -> execute();
  $archivos_entregados = $sentencia9 -> fetchAll();

 $id_usuario = $tareas["id_usuario"];
  $usuarios= "SELECT *from employees where id = $id_usuario";
  $sentencia2 = $conexion -> prepare($usuarios);

  $sentencia2 -> execute();
  $usuario = $sentencia2 ->  fetch(PDO::FETCH_ASSOC);


  
  $consulta_archivos_entregados= "SELECT nombre_archivo FROM archivos_tareas_terminadas where id_tareas=" . $id;
  $sentencia9 = $conexion -> prepare($consulta_archivos_entregados);
  $sentencia9 -> execute();
  $archivos_entregados = $sentencia9 -> fetchAll();

  // descripcion_entrega

//que la tarea este en por hacer
if (isset($_POST['submit']) && $tareas['estado_tarea'] == "Terminada") { //el isset es una funcion que determina si una variable esta definida o no en el php
  $resultado = [
   'error' => false,
     'mensaje' =>  ' se agrego el comentario con exito.'
  ];
       $comentario= $_POST['comentario_entrega'];
      
       if (isset($_SESSION["manager"])){
        $usua =  $_SESSION["username"];

       }else{     $usua =$usuario["username"];}
     $consultaSQL5 = " INSERT INTO comentarios_tarea (comentario,nombre_usuarios,id_tareas) VALUES ('$comentario','$usua','$id')";
     $sentencia5 = $conexion -> prepare($consultaSQL5);
     $sentencia5 -> execute();      

}

$consulta_comentarios= "SELECT *FROM comentarios_tarea  where id_tareas=" . $id;
$sentencia10 = $conexion -> prepare($consulta_comentarios);
$sentencia10 -> execute();
$comentario = $sentencia10 -> fetchAll();



if (isset($_POST['submit']) && $tareas['estado_tarea'] == "En progreso") { //el isset es una funcion que determina si una variable esta definida o no en el php
  $resultado = [
   'error' => false,
     'mensaje' => 'La tarea ' . escapar($tareas['nombre_tarea']) . ' ha sido entrgada con exito.'
  ];
       $comentario= $_POST['comentario_entrega'];
       $id_manager = 0;
     // $nombre_tarea= $_POST['nombre'];
     // $nombre_usuario= $_POST['usuarios'];
     // $descripcion_tarea =$_POST['descripcion'];
     // $importancia_tarea =$_POST['importancia'];
     // $fecha_termina=$_POST['fecha_expira'];
     // $hora_termina = $_POST['hora_termina'];
     // $file_name = $_FILES['file']['name'];
     // $file_tmp =$_FILES['file']['tmp_name'];
     // $ruta = "../tareas/". $file_name;
     // move_uploaded_file($file_tmp,$ruta);
     // $consultaSQL = "INSERT INTO tareas_asignadas (nombre_tarea, id_usuario, descripcion_tarea, importancia_tarea,estado_tarea,fecha_expira,hora_expira,archivo) VALUES ('$nombre_tarea','$nombre_usuario','$descripcion_tarea','$importancia_tarea','Por hacer','$fecha_termina','$hora_termina','$file_name')";
     
     //  $conexion->query($consultaSQL);

     //  $consultaSQL = "SELECT * FROM employees";
     //  $sentencia = $conexion -> prepare($consultaSQL);
     //  $sentencia -> execute();
     //  $empleados = $sentencia -> fetchAll();
     
     $usua =$usuario["username"];
     $consultaSQL5 = " INSERT INTO comentarios_tarea (comentario,nombre_usuarios,id_tareas) VALUES ('$comentario','$usua','$id')";
     $sentencia5 = $conexion -> prepare($consultaSQL5);
     $sentencia5 -> execute();
     


     $consultaSQL3 = " UPDATE tareas_asignadas set estado_tarea = 'Terminada', update_at = NOW() where id= " . $id;
     $sentencia3 = $conexion -> prepare($consultaSQL3);
     $sentencia3 -> execute();

    
       

}









 if (isset($_POST['submit']) && $tareas['estado_tarea'] == "Por hacer") { //el isset es una funcion que determina si una variable esta definida o no en el php
         $resultado = [
          'error' => false,
            'mensaje' => 'La tarea ' . escapar($tareas['nombre_tarea']) . ' ha sido aceptada con exito, el estatus de la tarea cambiara a "En progreso"'
         ];
            // $nombre_tarea= $_POST['nombre'];
            // $nombre_usuario= $_POST['usuarios'];
            // $descripcion_tarea =$_POST['descripcion'];
            // $importancia_tarea =$_POST['importancia'];
            // $fecha_termina=$_POST['fecha_expira'];
            // $hora_termina = $_POST['hora_termina'];
            // $file_name = $_FILES['file']['name'];
            // $file_tmp =$_FILES['file']['tmp_name'];
            // $ruta = "../tareas/". $file_name;
            // move_uploaded_file($file_tmp,$ruta);
            // $consultaSQL = "INSERT INTO tareas_asignadas (nombre_tarea, id_usuario, descripcion_tarea, importancia_tarea,estado_tarea,fecha_expira,hora_expira,archivo) VALUES ('$nombre_tarea','$nombre_usuario','$descripcion_tarea','$importancia_tarea','Por hacer','$fecha_termina','$hora_termina','$file_name')";
            
            //  $conexion->query($consultaSQL);

            //  $consultaSQL = "SELECT * FROM employees";
            //  $sentencia = $conexion -> prepare($consultaSQL);
            //  $sentencia -> execute();
            //  $empleados = $sentencia -> fetchAll();
            
            $consultaSQL3 = " UPDATE tareas_asignadas set estado_tarea = 'En progreso' where id= " . $id;
            $sentencia3 = $conexion -> prepare($consultaSQL3);
            $sentencia3 -> execute();

            $consultaSQL = "SELECT *FROM tareas_asignadas WHERE id=" . $id;
            $sentencia = $conexion -> prepare($consultaSQL);
            $sentencia -> execute();
            $tareas = $sentencia -> fetch(PDO::FETCH_ASSOC);
              

    }



  } catch (PDOException $error) {

    $resultado['error'] = true;
    $resultado['mensaje'] = $error -> getMessage(); 
}






?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tarea "<?= escapar($tareas["nombre_tarea"]);?>"</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">ver tarea</li>
            </ol>
          </div>
        </div>
      <!-- ----------------- -->
        <?php
     if (isset($resultado)) {
      ?>
      <!-- el siguiente codigo se encuentra dentro de html -->
      <div class="container mt-3">
        <div class="row">
          <div class="col-md-12">
            <!-- en el siguiente div se establece si el mensaje sera de danger o success, dependiendo de lo que almacene $resultado -->
            <!-- a continuacion con el \<\?=cosa a imprimir?> se consigue de foma mas corta la impresion echo en php -->
            <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
              <?= $resultado['mensaje'] ?>
            </div>
          </div>
        </div>
      </div>
      <?php
     }
     ?> 
       <!-- --------------------------------------- -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <!-- left column -->
          <div class="col-md-10">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ver tarea</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" id="CreateForm" enctype="multipart/form-data">
              <div class="card-body">
                
   <div class="form-group">
                <table class="form" align="center">
                    <tbody>
                        <tr class="">
                            <td class="c0"><label><br>Nombre de <br>tarea:</label></td>
                            <td class="c1"><input type="text" size="74" class="form-control" placeholder="Actividad 1..." name="nombre"  value="<?= escapar($tareas["nombre_tarea"]);?>" disabled></td>
                        </tr>
                        <tr class="">
                            <td class="c0"><label>Para usuario:</label></td>
                            <td class="c1"><input type="text" size="74" class="form-control" placeholder="Actividad 1..." name="nombre"  value="<?= escapar($usuario["username"]);?>" disabled></td>
                        </tr>
                        <tr>
                          <td class="c0"><label>Instrucciones de<br>actividad:</label></td>
                          <td class="c1"><textarea class="form-control" size="74" name="descripcion" disabled><?= escapar($tareas["descripcion_tarea"]);?></textarea></td>
                        </tr>
                        <tr>
                            <td class="c0"><label>Importancia:</label></td>
                            <td class="c1"><input type="text" size="74" class="form-control" placeholder="Actividad 1..." name="nombre"  value="<?= escapar($tareas["importancia_tarea"]);?>" disabled></td>

                        </tr>
                        <tr>
                            <td class="c0"><label>Fecha de<br> creacion</label></td>
                            <td class="c1"><input class="form-control" type="text" value="<?= escapar($tareas["fecha_creacion"]);?>" disabled></td>
                        </tr>
                        <tr>
                            <td class="c0"><label>Fecha en la<br> que expira:</label></td>
                            <td class="c1"><input class="form-control" type="text" value="<?= escapar($tareas["fecha_expira"]);?>" disabled></td>
                        </tr>
                        <tr class="">
                            <td class="c0"><label>Hora en la<br> que expira:</label></td>
                            <td class="c1"><input class="form-control" type="text" value="<?= escapar($tareas["hora_expira"]);?>" disabled ></td>

                        </tr>
                    </tbody>
                </table>
    </div>

             <div class="card-body">
             <div class="form-group">
                    <label for="exampleInputFile">Archivos Adjuntos</label>
                     <?php
                        if ($archivos && $sentencia1 -> rowCount()>0) {
                            foreach ($archivos as $fila) {
                              ?>
                            
                             <br> <a href="<?= '../tareas/' . escapar($fila["nombre_archivo"])?>"> <?php echo escapar($fila['nombre_archivo'])?></a>


<?php
                            }
                          }else{

                            
                                echo "<br>no hay archivos adjuntos";

                          }
                     
                     ?>




                                      </div>
                                      <?php
                                      if(isset($_SESSION['id_employee']) && $tareas['id_usuario']==$_SESSION['id_employee']){
                                          if($tareas['estado_tarea'] == "Por hacer")
                                          {
                                      ?>
                                      <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">

                                      <button type="submit" name="submit" form="CreateForm" class="btn btn-primary">Aceptar tarea</button>

                                      <?php
                                        }
                                      }
                                      ?>
                                  
                  
                </div>
                
                </div>

 </form>
 
            <!-- /.card -->
          </div>
        </div>
            </div>
            
            

          
         
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
<?php


    if((isset($_SESSION['id_employee']) && $tareas['id_usuario']==$_SESSION['id_employee'])|| isset($_SESSION['userid']) )
    {
      if($tareas['estado_tarea'] == "Terminada")
      {
      ?>
          <section class="content">
            <div class="container-fluid">
              <div class="row justify-content-center">
                <!-- left column -->
                <div class="col-md-10">
                  <!-- general form elements -->
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Tarea enviada</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                    <div class="form-group">
                    <label for="exampleInputFile">Archivos Adjuntos entregados</label>
                     <?php
                    // /
                        if ($archivos_entregados && $sentencia9 -> rowCount()>0) {
                            foreach ($archivos_entregados as $fila3) {
                              ?>
                            
                             <br> <a href="<?= '../tareas/' . escapar($fila3["nombre_archivo"])?>"> <?php echo escapar($fila3['nombre_archivo'])?></a>


<?php
                            }
                          }else{

                            
                                echo "<br>no hay archivos adjuntos";

                          }
                     
                     ?>


         <div class="form-group">
         <br>
         <label>comentarios sobre la tarea</label>
         <?php
                    // /
                        if ($comentario && $sentencia10 -> rowCount()>0) {
                            foreach ($comentario as $fila4) {
                              ?>

     

         <br>
         <!--  -->           
                    <label>Usuario: <?php echo escapar($fila4['nombre_usuarios'])?> </label>
                    <textarea class="form-control" rows="3" name="comentario_entrega" placeholder="Enter ..." disabled><?php echo escapar($fila4['comentario'])?></textarea>
                  

<!--  -->

      
<?php
                            }
                          }else {
                            echo "<br>no hay comentarios sobre esta tarea";
                          }
?>
                          <form method="POST" id="nuevo_comentario" enctype="multipart/form-data">


                          
                                     <br>   
                                        <label>Nuevo Comentario</label>
                                        <textarea class="form-control" rows="3" name="comentario_entrega" placeholder="Enter ..."></textarea>
                                        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                                      
                    </form>
                    <br>
                    <button type="submit" name="submit" form="nuevo_comentario" class="btn btn-primary">Nuevo comentario</button>

                    <?php

      }
if($tareas['estado_tarea'] == "En progreso")
{
?>
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <!-- left column -->
          <div class="col-md-10">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Entregar tarea</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                
   <div class="form-group">
   
   <form method="POST" id="enviar_tarea" enctype="multipart/form-data">


      <label>Nombre tarea</label>
                    <br>
                    
                    <label>Comentarios de la tarea</label>
                    <textarea class="form-control" rows="3" name="comentario_entrega" placeholder="Enter ..."></textarea>
                    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                  
</form>

<!-- subir archivo -->

<div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Subir contenido extra <small><em>(Cualquier tipo de archivo)</em> </small></h3>
              </div>
              <div class="card-body">
                <div id="actions" class="row">
                  <div class="col-lg-6">
                    <div class="btn-group w-100">
                      <span class="btn btn-success col fileinput-button">
                        <i class="fas fa-plus"></i>
                        <span>Add files</span>
                      </span>
                      <button type="" class="btn btn-primary col start">
                        <i class="fas fa-upload"></i>
                        <span>Start upload</span>
                      </button>
                      <button type="reset" class="btn btn-warning col cancel">
                        <i class="fas fa-times-circle"></i>
                        <span>Cancel upload</span>
                      </button>
                    </div>
                  </div>
                  <div class="col-lg-6 d-flex align-items-center">
                    <div class="fileupload-process w-100">
                      <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="table table-striped files" id="previews">
                  <div id="template" class="row mt-2">
                    <div class="col-auto">
                        <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <p class="mb-0">
                          <span class="lead" data-dz-name></span>
                          (<span data-dz-size></span>)
                        </p>
                        <strong class="error text-danger" data-dz-errormessage></strong>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                      <div class="btn-group">
                        <button class="btn btn-primary start">
                          <i class="fas fa-upload"></i>
                          <span>Start</span>
                        </button>
                        <button data-dz-remove class="btn btn-warning cancel">
                          <i class="fas fa-times-circle"></i>
                          <span>Cancel</span>
                        </button>
                        <button data-dz-remove class="btn btn-danger delete">
                          <i class="fas fa-trash"></i>
                          <span>Delete</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
               

                </div>
                
          <!--/.col (right) -->
        </div>
        <!-- fin subir  -->



                <div class="card-footer">
                  <button type="submit" name="submit" form="enviar_tarea" class="btn btn-primary">Entregar tarea</button>
                
                </div>

                </div>
                
          <!--/.col (right) -->
        </div>
              <!-- /.card-body -->
              <div class="card-footer">
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
            </div>
            
            

          
         
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
    <?php
}
    }
    ?>

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
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="../../plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
  $(function () {
    bsCustomFileInput.init();
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "subir_archivo_terminados.php", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
 

  // DropzoneJS Demo Code End
</script>
</body>
</html>
