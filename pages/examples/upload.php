<!-- validacion de usuario -->
<?php
    $user=$_POST["user"];
    $table=$_POST["session"];
    $password=$_POST["current_pass"];

    try {

    // se establece la conexion
    include '../../login/data/config.php';
    $conection = new mysqli($host_name, $user_db, $pass_db, $db_name);

    // se consulta inf completa de user
    $sql = "SELECT * FROM $table WHERE username = '$user'";
    $query = $conection -> query($sql);

    } catch (PDOException $pe) {
        die("No se pudo establecer conexion con la base de datos: $db_name :" . $pe->getMessage());
    }

    if ($conection -> connect_error) {
        // die("La conexion fallo: " . $conexion -> connect_error);
    }

    // $password = md5($password);
    if ($table == 'managers') {

        $row = $managers_query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            session_start();
            $_SESSION["manager"] = $user;
            $_SESSION["surnames"] = $row['surnames'];
            $_SESSION['loggedin'] = true;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5*60);
            header("Location: ../../index1.php");
            // exit();

            include ('../../chat/Chat.php');
            $chat = new Chat();
            $user = $chat->loginUsers($_POST['username'], $_POST['password']);	

            // asegura que no devuelva vacio la creacion de usuario y crea sesion
            if(!empty($user)) {
                $_SESSION['username'] = $user[0]['username'];
                $_SESSION['userid'] = $user[0]['userid'];

                // se actualizar el chat de acuerdo al usuario "userid"
                $chat->updateUserOnline($user[0]['userid'], 1);
                $lastInsertId = $chat->insertUserLoginDetails($user[0]['userid']);
                $_SESSION['login_details_id'] = $lastInsertId;
            } else {
                $loginError = "Usuario y Contraseña invalida";
            };
        } else {
            echo 'usuario y contraseña incorrectos';
            echo "<br><a href ='lockscreen.php'> Volver a intentarlo</a>";
            exit();
        }

    } else if($table == 'employees'){

        $row = $query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            session_start();

            // $id = $_GET['id'];
            // $nombre_usuario = $_POST['username'];
            // $apellidos_usuario = $_POST['surname'];
            // $password_usuario = md5($_POST['password']);
            // $edad_usuario = $_POST['edad'];
            // $correo_usuario = $_POST['email'];
            // $profesion_usuario = "2";
       

            // $consultaSQL = "UPDATE usuarios SET
            //                 nombre_usuario = '$nombre_usuario',
            //                 apellidos_usuario = '$apellidos_usuario',
            //                 password_usuario = '$password_usuario',
            //                 edad_usuario = '$edad_usuario',
            //                 correo_usuario = '$correo_usuario',
            //                 profesion_usuario = '$profesion_usuario',
            //                 update_at = NOW()
            //                 WHERE id ='$id'";


            // $sentencia = $conexion -> prepare($consultaSQL);
            // // la $sentencia que ya tiene establecida la conexion y la consulta que se realizara se ejecuta con el array alumno
            // // que es el que contiene los datos que se van a actualizar
           
            // $sentencia -> execute();


            header("Location: profile.php");
            exit();

        } else {
            echo 'Contraseña actual es erronea';
            echo "<br><a href ='profile.php'> Volver a intentarlo</a>";
            exit();
        }

    } else {
        echo 'No es ni empleado, ni manager';
        echo "<br><a href ='profile.php'> Volver a intentarlo</a>";
        exit();
    }
    //cierro conexion
    mysqli_close($conexion); 
?>