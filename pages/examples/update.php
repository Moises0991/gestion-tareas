<!-- validacion de usuario -->
<?php
    session_start();
    // datos obtenidos
    $user=$_POST["user"];
    $table=$_POST["session"];
    $password=$_POST["current_pass"];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $new_pass = $_POST['new_pass'];
    if (empty($new_pass)) {
        $new_pass = $password;
    } 


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

        $username = $_POST['username'];
        $surnames = $_POST['surnames'];
        $age = $_POST['age'];

        $row = $query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            
            if(isset($_POST["submit"])){

                $revisar = getimagesize($_FILES['picture']['tmp_name']);
                if($revisar !== false){

                    $image = $_FILES['picture']['tmp_name'];
                    $imgContenido = addslashes(file_get_contents($image));


                    $sql_update = "UPDATE $table SET username = '$username', surnames = '$surnames', user_age = '$age', email = '$email', phone = '$phone', pass_user = '$new_pass', picture = '$imgContenido', update_at = now() WHERE username='$user'";
                    $sentence = $conection -> prepare($sql_update);
                    $sentence -> execute();
                    // COndicional para verificar la subida del fichero
                    if($sentence){
                        echo "Archivo Subido Correctamente.";
                    }else{
                        echo "Ha fallado la subida, reintente nuevamente.";
                    } 
                    // Sie el usuario no selecciona ninguna imagen
                }else{
                    $sql_update = "UPDATE $table SET username = '$username', surnames = '$surnames', user_age = '$age', email = '$email', phone = '$phone', pass_user = '$new_pass', update_at = now() WHERE username='$user'";
                    $sentence = $conection -> prepare($sql_update);
                    $sentence -> execute();
                }

                header("Location: profile.php");
                exit();
            }
        } else {
            echo 'Contraseña actual es erronea';
            echo "<br><a href ='profile.php'> Volver a intentarlo</a>";
            exit();
        }

    } else if($table == 'employees'){

        $row = $query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            
            if(isset($_POST["submit"])){

                $revisar = getimagesize($_FILES['picture']['tmp_name']);
                if($revisar !== false){

                    $image = $_FILES['picture']['tmp_name'];
                    $imgContenido = addslashes(file_get_contents($image));
                    
                    if (empty($imgContenido)){
                        $imgContenido = $row['picture'];
                    }

                    $sql_update = "UPDATE $table SET email='$email', phone = '$phone', pass_user = '$new_pass', picture = '$imgContenido', update_at = now() WHERE username='$user'";
                    $sentence = $conection -> prepare($sql_update);
                    $sentence -> execute();

                    // COndicional para verificar la subida del fichero
                    if($sentence){
                        echo "Archivo Subido Correctamente.";
                    }else{
                        echo "Ha fallado la subida, reintente nuevamente.";
                    } 
                    // Sie el usuario no selecciona ninguna imagen
                }else{
                    $sql_update = "UPDATE $table SET email='$email', phone = '$phone', pass_user = '$new_pass', update_at = now() WHERE username='$user'";
                    $sentence = $conection -> prepare($sql_update);
                    $sentence -> execute();
                }

                header("Location: profile.php");
                exit();
            }
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
    mysqli_close($conection); 
?>