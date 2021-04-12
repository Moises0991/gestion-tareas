
<?php include 'header.php'?>

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
  // $consultaSQL = "SELECT * FROM employees";
  // $sentencia = $conexion -> prepare($consultaSQL);
  // $sentencia -> execute();
  // $empleados = $sentencia -> fetchAll();
  $id = $_GET['id'];
  $consultaSQL = "SELECT *FROM usuarios_espera WHERE id=" . $id;
  $sentencia = $conexion -> prepare($consultaSQL);
  $sentencia -> execute();
  $solicitante = $sentencia -> fetch(PDO::FETCH_ASSOC);

  $username = $solicitante['username'];
  $username_array = explode (" ", $username);
  $name = $username_array[0];
  $surname = $username_array[1] . ' ' . $username_array[2];


 if (isset($_POST['submit'])) { //el isset es una funcion que determina si una variable esta definida o no en el php
         $resultado = [
          'error' => false,
            'mensaje' => 'La tarea ' . escapar($_POST['username']) . ' ha sido creada con éxito'
         ];
         $user = $_POST['username'];
			$surnames = $_POST['surnames'];
			$pass_user = $_POST['password'];
			$user_age = $_POST['age'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$nickname = $_POST['nickname'];

			$current_session = '1';
			$online = '0';
			$username = $user . ' ' . $surnames;
       $puesto = $_POST['puesto'];
       $filename= escapar($solicitante["avatar"]);
       if($puesto == "Gerente")
       {

        $sql = "INSERT INTO `managers` (`nickname`, `username`, `pass_user`, `user_age`, `email`, `phone`, `avatar`, `current_session`, `online`) ";
				$sql .= "VALUES ('$nickname', '$username', '$pass_user','$user_age', '$email', '$phone', '$filename', '$current_session', '$online')";
				$sentence = $conexion->prepare($sql);
				$sentence->execute();
       
        $consulta_borrar = "DELETE FROM usuarios_espera WHERE id=" . $id;
        $sentencia_borrar = $conexion->prepare($consulta_borrar);
       $sentencia_borrar ->execute();


       }else
       {

        $sql = "INSERT INTO `employees` (`nickname`, `username`, `pass_user`, `user_age`, `email`, `phone`, `avatar`) ";
				$sql .= "VALUES ('$nickname', '$username', '$pass_user', '$user_age', '$email', '$phone', '$filename')";
				$sentence = $conexion->prepare($sql);
				$sentence->execute();
        $consulta_borrar = "DELETE FROM usuarios_espera WHERE id=" . $id;
        $sentencia_borrar = $conexion->prepare($consulta_borrar);
       $sentencia_borrar ->execute();
       }
?>
      <script> window.location.replace("usuarios_espera.php?aprobado=<?= $name?>");</script>
      <?php

       




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
            <h1>solicitud de registro</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Aceptar usuarios</li>
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
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Informacion del solicitante</h3>
              </div>
              <div class="card-body">
  <form method="post" id="aceptar">
    <h4><?=escapar($solicitante["username"]);?></h4>
    <br/>
    <div class="row">
      <h5>Datos del usuario</h5>
    </div>

    <div class="row">
    
      <div class="col">
         <div class="input-group mb-3">
           <span class="input-group-text" id="inputGroup-sizing-default" >Nombre</span>
           <input type="text" class="form-control input-lg" required pattern="[A-Za-z0-9-ñ-Ñ ]+" title="Solo se aceptan letras de la [A-Z] o [a-z] y numeros" maxlength="40" aria-label="Sizing example input" name="username" aria-describedby="inputGroup-sizing-default" value ="<?=escapar($name);?>">
         </div>

        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">Correo</span>
          <input type="email" class="form-control" maxlength="40" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="email" value ="<?=escapar($solicitante["email"]);?>">
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default"> Edad </span>
          <input type="text" class="form-control" required pattern="[0-9 ]+" title="Solo se aceptan numeros" maxlength="2"aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="age" value ="<?=escapar($solicitante["user_age"]);?>" >
        </div>
      </div>
     

      <div class="col">
        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">Apellido</span>
          <input type="text" class="form-control" required pattern="[A-Za-z0-9-ñ-Ñ ]+" title="Solo se aceptan letras de la [A-Z] o [a-z] y numeros" maxlength="40"  aria-label="Sizing example input" name="surnames" aria-describedby="inputGroup-sizing-default" value ="<?=escapar($surname);?>">
        </div>    
        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">Telefono</span>
          <input type="text" class="form-control" required pattern="[0-9 ]+" title="Solo se aceptan numeros" maxlength="10" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="phone" value ="<?=escapar($solicitante["phone"]);?>">
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">Sexo</span>
          <input type="text" class="form-control" required pattern="[A-Za-z ]+" title="Solo se aceptan letras de la [A-Z] o [a-z]" maxlength="6" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"  value ="<?=escapar($solicitante["sexo"]);?>">
        </div>
        
      </div>
    </div>
 

    <div class="row">
      <h5>Informacion de la cuenta</h5>
      </div>
    
         <div class="row">
           <div class="col">        
                    <div class="input-group mb-3">
                      <input type="hidden" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="password" value ="<?=escapar($solicitante["pass_user"]);?>">
                    </div>  
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-default">usuario</span>
                      <input type="text" class="form-control" aria-label="Sizing example input" required pattern="[A-Za-z0-9-ñ-Ñ ]+" title="Solo se aceptan letras de la [A-Z] o [a-z] y numeros" maxlength="40" aria-describedby="inputGroup-sizing-default"  name="nickname" value ="<?=escapar($solicitante["nickname"]);?>">
                    </div>        
           </div>

            <div class="col">
            
              <div class="input-group mb-3">
                <input type="hidden" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"  name="password" value ="<?=escapar($solicitante["pass_user"]);?>">
                <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
              </div>

              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Tipo de usuario</span>
                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required pattern="[A-Za-z ]+" title="Solo se aceptan letras de la [A-Z] o [a-z]"  name="puesto" value ="<?=escapar($solicitante["puesto"]);?>">
              </div>

          </div>
       </div> 

       <div class="row">
          <h5>Acerca del empleado</h5>
           <div class="input-group">
              <span class="input-group-text">Comentarios (opcional)</span>
              <textarea class="form-control" aria-label="With textarea"> <?=escapar($solicitante["comentarios"]);?></textarea>
            </div>
        </div>


        

  </form>
          <div class="p-4 row justify-content-center" >
              
              <div class="col">
              <button type="submit"  name="submit" class="btn btn-success " form="aceptar">Aceptar registro</button> 
                  
            
              </div>
            
              <div class=" col " >
              <span class="float-right ">  <a href="<?= 'borrar_solicitud.php?id=' .$id.'&solicitante='. $name?>"> <button type="button" create_form="rechazado" name="rechazar" class="btn btn-danger ">Rechazar registro</button></a> </span>
            
          </div>
     
  

</div>

</div>
</div>


            <!-- /.card -->
            <!-- /.card-body -->
            
            <!-- /.card -->
        
        
            
            

          
         
        <!-- /.row -->
        
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
    url: "subir_archivo.php", // Set the url
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
