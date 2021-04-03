<?php
  include 'modulos/forms/funciones.php';
  session_start();
  $now = time();

  // evaluacion de tiempo en sesion
  if($now > $_SESSION['expire']) {
    header('Location: pages/examples/lockscreen.php');
    exit;
  } else {
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (5*60);
  }



  // conexion
  include 'login/data/config.php';


  if (isset($_SESSION['manager'])) {
    $username = $_SESSION['username'];
    $nickname = $_SESSION['manager'];
    $sql = "SELECT * FROM managers WHERE nickname = '$nickname'";
    $query = $conection -> query($sql);
    $row = $query -> fetch_array(MYSQLI_ASSOC);

  } else if (isset($_SESSION['employee'])) {
    $username = $_SESSION['username'];
    $nickname = $_SESSION['employee'];
    $sql = "SELECT * FROM employees WHERE nickname = '$nickname'";
    $query = $conection -> query($sql);
    $row = $query -> fetch_array(MYSQLI_ASSOC);
  
    // consulta
    $sql = "SELECT count(*) total FROM employees";
    $query = $conection -> query($sql);
    $task = $query -> fetch_array(MYSQLI_ASSOC);

    $id = $_SESSION["id_employee"];

    $task_type = array("Normal", "Alta", "Urgente", "inmediata");
    for ($i = 0; $i <= 3; $i++) {
      $type_a = $task_type[$i];
      $sql1 = "SELECT count(*) total FROM tareas_asignadas where id_usuario = $id and importancia_tarea = '$type_a' ";
      $sentence1 = $conection -> query($sql1);
      $task1 = $sentence1 -> fetch_array(MYSQLI_ASSOC);
      if($i==0){$tipo_normal = $task1["total"];}
      if($i==1){$tipo_alta = $task1["total"];}
      if($i==2){$tipo_urgente = $task1["total"];}
      if($i==3){$tipo_inmediata = $task1["total"];}
    } 
  }

  include 'header.php';
?>





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index1.php">Inicio</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <?php 
        if (isset($_SESSION['employee'])) {
      ?>
        <!-- Small boxes (Stat box) -->
        <div class="row ">
        
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= escapar($tipo_normal); ?><sup style="font-size: 20px"></sup></h3>
                <p>Tareas normales</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="modulos/forms/tareas.php" class="small-box-footer">Ver todas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning" style="color:white">
              <div class="inner" style="color: white">
                <h3><?= escapar($tipo_alta); ?></h3>
                <p>Tareas altas</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="modulos/forms/tareas.php" class="small-box-footer">Ver todas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
            <!-- ./col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-orange" >
              <div class="inner"style="color: white">
                <h3><?= escapar($tipo_urgente); ?></h3>
                <p>Tareas urgentes</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="modulos/forms/tareas.php" class="small-box-footer">Ver todas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= escapar($tipo_inmediata); ?></h3>
                <p>Tareas inmediatas</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="modulos/forms/tareas.php" class="small-box-footer">Ver todas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      <?php
        } else if (isset($_SESSION['manager'])) {
      ?>
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      <?php
        }
      ?>
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Progreso
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
                <iframe src="pages/examples/uplot_copy.html" width="100%" height="300" scrolling="no" style="border:none" >
              </iframe>
              <div class="card-body" style="padding:0px">
              </div><!-- /.card-body -->
            </div>
            <!-- chat directo -->
            <?php 
              if (isset($_SESSION['manager'])){
            ?>

              <!-- se evalua si ha una sesion iniciada -->
              <?php if(isset($_SESSION['userid']) && $_SESSION['userid']) { ?> 	
                      <?php
                      include ('chat/Chat.php');
                      $chat = new Chat();
                      $loggedUser = $chat->getUserDetails($_SESSION['userid']);
                      $currentSession = '';
                      foreach ($loggedUser as $user) {
                        $currentSession = $user['current_session'];
                      }
                      ?>
              <?php } ?>
              
              <!-- comienzo del header -->
              <?php
              $userDetails = $chat->getUserDetails($currentSession);
              foreach ($userDetails as $user) {										
                $name =$user['username'];
              }	
              ?>						
              <div class="card direct-chat direct-chat-primary">
                <div class="card-header">
                  <h3 class="card-title"> Chat con <span style="color:blue" id="userSection"><?=$name?></span></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool save-button" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                      <i class="fas fa-comments"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- fin del header -->

                <div class="card-body">
                  <!-- la conversacion es cargada aqui -->
                  <div class="direct-chat-messages">
                      <div class="messages" id="conversation">		
                        <?php
                        echo $chat->getUserChat($_SESSION['userid'], $currentSession);						
                        ?>
                      </div>
                  </div>
                  <!-- fin de area de mensajes -->

                  <!-- los contactos son cargados aqui -->
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">


                      <?php
                      $chatUsers = $chat->chatUsers($_SESSION['userid']);
                      foreach ($chatUsers as $user) {
                        $status = 'offline';						
                        if($user['online']) {
                          $status = 'online';
                        }
                        $activeUser = '';
                        if($user['userid'] == $currentSession) {
                          $activeUser = "active";
                        }
                        if($chat->getUnreadMessageCount($user['userid'], $_SESSION['userid'])>0){
                          $style = 'color: #10ff00; background: #163f69; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; text-align: center; border-radius: 50%; position:absolute; top:-4px; left:27px';
                          $styleMessage = 'color: #8bc34a';
                        } else {
                          $style = '';
                          $styleMessage = '';
                        }
                        echo '
                          <li style="cursor: pointer;" id="'.$user['userid'].'" class="contact '.$activeUser.'" data-touserid="'.$user['userid'].'" data-tousername="'.$user['nickname'].'">
                            <div style="position:relative; float:left; margin-right:15px">
                              <img class="contacts-list-img" src="img/avatars/'.$user['avatar'].'" style="width:40px; height:40px; object-fit:cover">
                              <span style="'.$style.'" id="unread_'.$user['userid'].'" class="unread">'.$chat->getUnreadMessageCount($user['userid'], $_SESSION['userid']).'</span>
                            </div>
                              <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  <span style="'.$styleMessage.'" id="contact-name_'.$user['userid'].'">'.$user['username'].'</span>
                                  <span style="color:#5e95c7" id="isTyping_'.$user['userid'].'" class="isTyping"></span>
                                  <small class="contacts-list-date float-right" id="contact-date_'.$user['userid'].'">'.$chat->getLatestMessage($user['userid'], $_SESSION['userid'], 'date').'</small>
                                </span>
                                <span class="contacts-list-msg" id="contact-message_'.$user['userid'].'">'.$chat->getLatestMessage($user['userid'], $_SESSION['userid'], 'message').'</span>
                              </div>
                          </li>
                        
                        ';
                      }
                      ?>
                    </ul>
                    <!-- / fin de la lista de contactos -->
                  </div>
                </div>
                <!-- / fin de card-body del chat -->
                <div class="card-footer message-input" id="replySection">
                    <div class="input-group message-input" id="replyContainer">
                      <input type="text" placeholder="Mensaje..." class="form-control chatMessage" id="chatMessage<?=$currentSession;?>">
                      <span class="input-group-append">
                        <button type="button" class="btn btn-primary submit chatButton" id="chatButton<?=$currentSession?>">Enviar</button>
                      </span>
                    </div>
                </div>
                <!-- /.card-footer-->
              </div>
            <?php 
              }
            ?>
            <!-- fin de directo -->
            <?php 
              if (isset($_SESSION['employee'])){
            ?>

              <!-- TO DO List -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Por hacer
                  </h3>

                  <div class="card-tools">
                    <ul class="pagination pagination-sm">
                      <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                      <li class="page-item"><a href="#" class="page-link">1</a></li>
                      <li class="page-item"><a href="#" class="page-link">2</a></li>
                      <li class="page-item"><a href="#" class="page-link">3</a></li>
                      <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                    </ul>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <ul class="todo-list" data-widget="todo-list">
                    <li>
                      <!-- drag handle -->
                      <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <!-- checkbox -->
                      <div  class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo1" id="todoCheck1">
                        <label for="todoCheck1"></label>
                      </div>
                      <!-- todo text -->
                      <span class="text">Design a nice theme</span>
                      <!-- Emphasis label -->
                      <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                      <!-- General tools such as edit or delete-->
                      <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div  class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                        <label for="todoCheck2"></label>
                      </div>
                      <span class="text">Make the theme responsive</span>
                      <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                      <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div  class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo3" id="todoCheck3">
                        <label for="todoCheck3"></label>
                      </div>
                      <span class="text">Let theme shine like a star</span>
                      <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                      <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div  class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo4" id="todoCheck4">
                        <label for="todoCheck4"></label>
                      </div>
                      <span class="text">Let theme shine like a star</span>
                      <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                      <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div  class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo5" id="todoCheck5">
                        <label for="todoCheck5"></label>
                      </div>
                      <span class="text">Check your messages and notifications</span>
                      <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                      <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                    <li>
                      <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                      </span>
                      <div  class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo6" id="todoCheck6">
                        <label for="todoCheck6"></label>
                      </div>
                      <span class="text">Let theme shine like a star</span>
                      <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                      <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                      </div>
                    </li>
                  </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> Nueva tarea</button>
                </div>
            </div>
          <?php 
            }
          ?>
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">
            <!-- Map card -->
            <div class="card bg-gradient-primary" style="display: none">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitors
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="remove" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->
            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendario
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- USERS LIST -->



            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Usuarios</h3>

                <div class="card-tools">
                  <span class="badge badge-success">Conectados</span>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto; max-height: 321px">
                <ul class="users-list clearfix">

                  <?php 
                  $all_managers = "SELECT * FROM managers";
                  $result_managers = mysqli_query($conection, $all_managers);

                  if (mysqli_num_rows($result_managers) > 0) {
                      while($row_manager = mysqli_fetch_assoc($result_managers)){
                        ?>
                          <li>
                            <img
                            src="img/avatars/<?=$row_manager['avatar']?>"
                            style="width: 90px; height: 90px; object-fit:cover"
                            alt="User Image" class="medias">
                            <a class="users-list-name" href="#"><?=$row_manager['username'];?></a>
                            <span class="users-list-date">Today</span>
                          </li>
                        <?php 
                      }   
                  } else {
                      die("Error: No hay datos en la tabla seleccionada");
                  }
                  $all_employees = "SELECT * FROM employees";
                  $result_employees = mysqli_query($conection, $all_employees);

                  if (mysqli_num_rows($result_employees) > 0) {
                      while($row_employee = mysqli_fetch_assoc($result_employees)){
                        ?>
                          <li>
                            <img
                            src="img/avatars/<?=$row_employee['avatar']?>"
                            style="width: 90px; height: 90px; object-fit:cover"
                            alt="User Image" class="medias">
                            <a class="users-list-name" href="#"><?=$row_employee['username'];?></a>
                            <span class="users-list-date">Today</span>
                          </li>
                        <?php 
                      }   
                  } else {
                      die("Error: No hay datos en la tabla seleccionada");
                  }
                  ?>
                </ul>
                <!-- /.users-list -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a href="javascript:">Ver todos los usuarios</a>
              </div>
              <!-- /.card-footer -->
            </div>
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Realizado por <a href="https://adminlte.io">NiceCode</a>&copy;.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-rc
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script> $.widget.bridge('uibutton', $.ui.button) </script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/sparklines/sparkline.js"></script>
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>