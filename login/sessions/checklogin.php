<?php
    //Recibimos las dos variables
    $user=$_POST["username"];
    $password=$_POST["password"];

    try {

        // se establece la conexion
        include '../data/config.php';
        $conection = new mysqli($host_name, $user_db, $pass_db, $db_name);

        // se preparan consultas de usuario
        $sql_managers = "SELECT * FROM managers WHERE username = '$user'";
        $sql_employees = "SELECT * FROM employees WHERE username = '$user'";

        // se ejecutan quieries
        $managers_query = $conection -> query($sql_managers);
        $employees_query = $conection -> query($sql_employees);

    } catch (PDOException $pe) {
        die("No se pudo establecer conexion con la base de datos: $db_name :" . $pe->getMessage());
    }

    if ($conection -> connect_error) {
        include '../data/install.php';
        // die("La conexion fallo: " . $conexion -> connect_error);
    }


    // $password = md5($password);
    
    // se evalua en que tabla esta contenido el usuario 
    if (mysqli_num_rows($managers_query) > 0) {

        $row = $managers_query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            session_start();

            ///////////////////// aqui comienza parte del chat ////////////////////////////////
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
                header("Location: ../../chat/index.php");
            } else {
                $loginError = "Usuario y Contraseña invalida";
            };
            ///////////////////// aqui termina parte del chat ////////////////////////////////

            $_SESSION["manager"]=$user;
            $_SESSION['loggedin'] = true;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5*60);
            // header("Location: ../pages/manager.php");
            exit();

        } else {
            echo 'usuario y contraseña incorrectos';
            echo "<br><a href ='../../index.php'> Volver a intentarlo</a>";
            exit();
        }

    } else if(mysqli_num_rows($employees_query) > 0){

        $row = $employees_query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            session_start();
            $_SESSION['id_employee'] = $row['id'];
            $_SESSION["employee"]=$user;
            $_SESSION['loggedin'] = true;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (1*60);
            header("Location: ../../index1.php");
            exit();

        } else {
            echo 'usuario y contraseña incorrectos';
            echo "<br><a href ='../../index.php'> Volver a intentarlo</a>";
            exit();
        }

    } else {
        echo 'usuario y contraseña incorrectos';
        echo "<br><a href ='../../index.php'> Volver a intentarlo</a>";
        exit();
    }
    //cierro conexion
    mysqli_close($conexion); 


?>