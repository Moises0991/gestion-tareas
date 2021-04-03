<!-- validacion de usuario -->
<?php
    $nickname=$_POST["nickname"];
    $password=$_POST["password"];

    try {

        // se establece la conexion
        include '../../login/data/config.php';
        $conection = new mysqli($host_name, $user_db, $pass_db, $db_name);

        // se preparan consultas de usuario
        $sql_managers = "SELECT * FROM managers WHERE nickname = '$nickname'";
        $sql_employees = "SELECT * FROM employees WHERE nickname = '$nickname'";

        // se ejecutan quieries
        $managers_query = $conection -> query($sql_managers);
        $employees_query = $conection -> query($sql_employees);

    } catch (PDOException $pe) {
        die("No se pudo establecer conexion con la base de datos: $db_name :" . $pe->getMessage());
    }

    if ($conection -> connect_error) {
        // die("La conexion fallo: " . $conexion -> connect_error);
    }


    // $password = md5($password);
    
    // se evalua en que tabla esta contenido el usuario 
    if (mysqli_num_rows($managers_query) > 0) {

        $row = $managers_query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            session_start();
            $_SESSION["manager"] = $nickname;
            $_SESSION["username"] = $row['username'];
            $_SESSION['loggedin'] = true;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5*60);

            include ('../../chat/Chat.php');
            $chat = new Chat();
            $user = $chat->loginUsers($_POST['nickname'], $_POST['password']);	

            // asegura que no devuelva vacio la creacion de usuario y crea sesion
            if(!empty($user)) {
                $_SESSION['nickname'] = $user[0]['nickname'];
                $_SESSION['userid'] = $user[0]['userid'];

                // se actualizar el chat de acuerdo al usuario "userid"
                $chat->updateUserOnline($user[0]['userid'], 1);
                $lastInsertId = $chat->insertUserLoginDetails($user[0]['userid']);
                $_SESSION['login_details_id'] = $lastInsertId;
            } else {
                $loginError = "Usuario y Contraseña invalida";
            };

            header("Location: ../../index1.php");
            // exit();

        } else {
            echo 'usuario y contraseña incorrectos';
            echo "<br><a href ='lockscreen.php'> Volver a intentarlo</a>";
            exit();
        }

    } else if(mysqli_num_rows($employees_query) > 0){

        $row = $employees_query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            session_start();
            $_SESSION['id_employee'] = $row['id'];
            $_SESSION["employee"]=$nickname;
            $_SESSION["username"] = $row['username'];
            $_SESSION['loggedin'] = true;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5*60);
            header("Location: ../../index1.php");
            exit();

        } else {
            echo 'usuario y contraseña incorrectos';
            echo "<br><a href ='lockscreen.php'> Volver a intentarlo</a>";
            exit();
        }

    } else {
        echo 'usuario y contraseña incorrectos';
        echo "<br><a href ='lockscreen.php'> Volver a intentarlo</a>";
        exit();
    }
    //cierro conexion
    mysqli_close($conexion); 
?>