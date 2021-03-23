
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

  $hoy = getdate();
  $consultaSQL = "SELECT * FROM employees";
  $sentencia = $conexion -> prepare($consultaSQL);
  $sentencia -> execute();
  $empleados = $sentencia -> fetchAll();


 if (isset($_POST['submit'])) { //el isset es una funcion que determina si una variable esta definida o no en el php
         $resultado = [
          'error' => false,
            'mensaje' => 'La tarea ' . escapar($_POST['nombre']) . ' ha sido creada con éxito'
         ];
            $nombre_tarea= $_POST['nombre'];
            $nombre_usuario= $_POST['usuarios'];
            $descripcion_tarea =$_POST['descripcion'];
            $importancia_tarea =$_POST['importancia'];
            $fecha_termina=$_POST['fecha_expira'];
            $hora_termina = $_POST['hora_termina'];
            // $file_name = $_FILES['file']['name'];
            // $file_tmp =$_FILES['file']['tmp_name'];
            // $ruta = "../tareas/". $file_name;
            // move_uploaded_file($file_tmp,$ruta);
            $consultaSQL = "INSERT INTO tareas_asignadas (nombre_tarea, id_usuario, descripcion_tarea, importancia_tarea,estado_tarea,fecha_expira,hora_expira) VALUES ('$nombre_tarea','$nombre_usuario','$descripcion_tarea','$importancia_tarea','Por hacer','$fecha_termina','$hora_termina')";
            
             $conexion->query($consultaSQL);

             $consultaSQL = "SELECT * FROM employees";
             $sentencia = $conexion -> prepare($consultaSQL);
             $sentencia -> execute();
             $empleados = $sentencia -> fetchAll();

        
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
            <h1>Crear tareas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Crear tareas</li>
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
                <h3 class="card-title">Crear tarea</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                
                  <div class="form-group">
                    <label>Nombre de la tarea</label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="nombre">
                  </div>

                  <div class="form-group">
                    <label>Usuario</label>
                    <select class="form-control" name="usuarios">
                    <?php
                            if ($empleados && $sentencia -> rowCount()>0) {
                                foreach ($empleados as $fila) {
                                    ?>
                                     <option value="<?php echo escapar($fila["id"])?>"><?php echo escapar($fila["username"])." ". escapar($fila["surnames"]);?></option>
                    <?php
                                }
                            }
                        ?>
                    </select>
                  </div> 

                  <div class="form-group">
                    <label>Descripcion</label>
                    <textarea class="form-control" rows="3" name="descripcion" placeholder="Enter ..."></textarea>
                  </div>

                  
                  <div class="form-group">
                    <label>importancia</label>
                    <select class="form-control" name="importancia">
                      <option value="Normal">Normal</option>
                      <option value="Alta">Alta</option>
                      <option value="Urgente">Urgente</option>
                      <option value="Inmediata">inmediata</option>
                    </select>
                  </div> 

                  <div class="form-group">
                    <label>Fecha de la creacion</label>
                    <input type="text" class="form-control" placeholder="<?=escapar($hoy["mday"]);?>-0<?=escapar($hoy["mon"]);?>-<?=escapar($hoy["year"]);?>" disabled>
                  </div>

                  <div class="row ">
                    <div class="col-sm-6">
                    <div class="form-group">
                       <label>Fecha en la que expira:</label>
                           <input class="form-control" type="date" min="<?=escapar($hoy["year"]);?>-0<?=escapar($hoy["mon"]);?>-<?=escapar($hoy["mday"]);?>"  name="fecha_expira">
                          </div>
                          </div>
                        
                    <div class="col-sm-6">
                    <label>Hora en la que expira:</label>
                      <input class="form-control" type="time" name="hora_termina"/>
                          </div>
                         
                 </div>
                         
                  

              
              
                </div>
                
                <!-- /.card-body -->

                <div class="card-footer">
                <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                  <button type="submit" name="submit" class="btn btn-primary">Crear tarea</button>
                </div>
                
              </form>
              <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Dropzone.js <small><em>jQuery File Upload</em> like look</small></h3>
              </div>
              <div class="card-body">
                <div id="actions" class="row">
                  <div class="col-lg-6">
                    <div class="btn-group w-100">
                      <span class="btn btn-success col fileinput-button">
                        <i class="fas fa-plus"></i>
                        <span>Add files</span>
                      </span>
                      <button type="submit" class="btn btn-primary col start">
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
              <!-- /.card-body -->
              <div class="card-footer">
                Visit <a href="https://www.dropzonejs.com">dropzone.js documentation</a> for more examples and information about the plugin.
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
            </div>
            
            

          
          </div>
          
          <!--/.col (right) -->
        </div>
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
    url: "../tareas", // Set the url
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
