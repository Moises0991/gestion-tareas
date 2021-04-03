<!-- validacion de usuario -->
<?php
    session_start();
    // datos obtenidos
    $nickname=$_POST["nickname"];
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

    // se consulta inf completa de user
    $sql = "SELECT * FROM $table WHERE nickname = '$nickname'";
    $query = $conection -> query($sql);

    } catch (PDOException $pe) {
        die("No se pudo establecer conexion con la base de datos: $db_name :" . $pe->getMessage());
    }

    if ($conection -> connect_error) {
        // die("La conexion fallo: " . $conexion -> connect_error);
    }

    // $password = md5($password);
    if ($table == 'managers') {

        $user = $_POST['username'];
        $surnames = $_POST['surnames'];
        $username = $user . ' ' . $surnames;
        $age = $_POST['age'];

        $row = $query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {

            if(isset($_POST["submit"])){

                $destinationFolder="../../img/avatars/";
            
                // si hay algun archivo que subir
                if(isset($_FILES["avatar"]) && $_FILES["avatar"]["name"])
                {
                    // si es un formato de imagen
                    if($_FILES["avatar"]["type"]=="image/jpeg" || $_FILES["avatar"]["type"]=="image/pjpeg" || $_FILES["avatar"]["type"]=="image/gif" || $_FILES["avatar"]["type"]=="image/png") {
        
                        // si exsite la carpeta o se ha creado
                        if(file_exists($destinationFolder) || @mkdir($destinationFolder)) {

                            // validacion de tipo de formato
                            $format = substr($_FILES["avatar"]["name"],-2);
                            if ($format == "eg") {
                                $format = ".jpeg";
                            } else if ($format == "pg") {
                                $format = ".jpg";
                            } else if ($format == "ng") {
                                $format = ".png";
                            } else if ($format == "if") {
                                $format = ".gif";
                            }
                            $filename = $nickname . $format;

                            $source=$_FILES["avatar"]["tmp_name"];
                            $destination=$destinationFolder.$filename;

                            // movemos el archivo y se ejecuta la consulta de update
                            if(@move_uploaded_file($source, $destination)) {
                                $sql_update = "UPDATE $table SET username = '$username', user_age = '$age', email = '$email', phone = '$phone', pass_user = '$new_pass', avatar = '$filename', update_at = now() WHERE nickname='$nickname'";
                                $sentence = $conection -> prepare($sql_update);
                                $sentence -> execute();
                                header("Location: profile.php");
                                if($sentence){
                                    echo "consulta guardada Correctamente.";
                                }else{
                                    echo "Ha fallado la subida, reintente nuevamente.";
                                } 
                            }else{
                                echo "<br>No se ha podido mover el archivo: ".$filename;
                            }
                        }else{
                            echo "<br>No se ha podido crear la carpeta: ".$destinationFolder;
                        }
                    }else{
                        echo "<br>".$filename." - NO es imagen jpg, png o gif";
                    }
                }else{
                    echo "<br>No se ha subido ninguna imagen";
                }      
            }
            exit();
        } else {
            echo 'Contraseña actual es erronea';
            echo "<br><a href ='profile.php'> Volver a intentarlo</a>";
            exit();
        }

    } else if($table == 'employees'){

        $row = $query -> fetch_array(MYSQLI_ASSOC);
        
        if ($password == $row['pass_user']) {
            
            if(isset($_POST["submit"])){


                $destinationFolder="../../img/avatars/";
            
                // si hay algun archivo que subir
                if(isset($_FILES["avatar"]) && $_FILES["avatar"]["name"])
                {
                    // si es un formato de imagen
                    if($_FILES["avatar"]["type"]=="image/jpeg" || $_FILES["avatar"]["type"]=="image/pjpeg" || $_FILES["avatar"]["type"]=="image/gif" || $_FILES["avatar"]["type"]=="image/png") {
        
                        // si exsite la carpeta o se ha creado
                        if(file_exists($destinationFolder) || @mkdir($destinationFolder)) {

                            // validacion de tipo de formato
                            $format = substr($_FILES["avatar"]["name"],-2);
                            if ($format == "eg") {
                                $format = ".jpeg";
                            } else if ($format == "pg") {
                                $format = ".jpg";
                            } else if ($format == "ng") {
                                $format = ".png";
                            } else if ($format == "if") {
                                $format = ".gif";
                            }
                            $filename = $nickname . $format;

                            $source=$_FILES["avatar"]["tmp_name"];
                            $destination=$destinationFolder.$filename;

                            // movemos el archivo y se ejecuta la consulta de update
                            if(@move_uploaded_file($source, $destination)) {

                                $sql_update = "UPDATE $table SET email='$email', phone = '$phone', pass_user = '$new_pass', avatar = '$filename', update_at = now() WHERE nickname='$nickname'";
                                $sentence = $conection -> prepare($sql_update);
                                $sentence -> execute();

                                header("Location: profile.php");
                                if($sentence){
                                    echo "consulta guardada Correctamente.";
                                }else{
                                    echo "Ha fallado la subida, reintente nuevamente.";
                                } 
                            }else{
                                echo "<br>No se ha podido mover el archivo: ".$filename;
                            }
                        }else{
                            echo "<br>No se ha podido crear la carpeta: ".$destinationFolder;
                        }
                    }else{
                        echo "<br>".$filename." - NO es imagen jpg, png o gif";
                    }
                }else{
                    echo "<br>No se ha subido ninguna imagen";
                }      
                
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