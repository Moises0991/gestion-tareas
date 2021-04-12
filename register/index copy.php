<?php
    // include 'funciones.php';
	
    // csrf();
    // if (isset($_POST['submit'])&& !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    //     die();
    // }

	// se valida envio de formulario
    if (isset($_POST['submit'])) { 

        $resultado = [
           'error' => false,
           'mensaje' => 'El usuario ' . $_POST['username'] . ' ha sido agregado con éxito'
        ];

        try {

			$config = include '../login/data/config.php';
			$conection = new mysqli($host_name, $user_db, $pass_db, $db_name);

            // $contraseña = md5($_POST['password']);
			$user = $_POST['username'];
			$surnames = $_POST['surnames'];
			$pass_user = $_POST['password'];
			$user_age = $_POST['age'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$nickname = $_POST['nickname'];
			$confirm_password = $_POST['confirm_password'];
			$current_session = '1';
			$online = '0';
			$username = $user . ' ' . $surnames;

			if ($_POST['gender']=='male') {
				$filename = $nickname . '.jpg';
				$source = '../chat/userpics/user5.jpg';
				$destination = '../img/avatars/'.$filename;
				if (!copy($source, $destination)) {
					echo "Error al copiar $source...\n";
				}
			} else {
				$filename = $nickname . '.jpg';
				$source = '../chat/userpics/user4.jpg';
				$destination = '../img/avatars/'.$filename;
				if (!copy($source, $destination)) {
					echo "Error al copiar $source...\n";
				}
			}

			if(isset($_POST['job']) && $_POST['job']=='manager') {

				$sql = "INSERT INTO `managers` (`nickname`, `username`, `pass_user`, `user_age`, `email`, `phone`, `avatar`, `current_session`, `online`) ";
				$sql .= "VALUES ('$nickname', '$username', '$pass_user','$user_age', '$email', '$phone', '$filename', '$current_session', '$online')";
				$sentence = $conection->prepare($sql);
				$sentence->execute();

			} else {

				$sql = "INSERT INTO `employees` (`nickname`, `username`, `pass_user`, `user_age`, `email`, `phone`, `avatar`) ";
				$sql .= "VALUES ('$nickname', '$username', '$pass_user', '$user_age', '$email', '$phone', '$filename')";
				$sentence = $conection->prepare($sql);
				$sentence->execute();
			}
			
        } catch (PDOException $error) {

            $resultado['error'] = true;
            $resultado['mensaje'] = $error -> getMessage();
            
        }
    }
?>

<!--------------------------- se crea el formulario -------------------------------------->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Registro</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body style="background: url('https://digitalsevilla.com/wp-content/uploads/2018/10/programa-contable-1-1080x720.jpg') 50% fixed; background-size: cover;">
		<div class="wrapper"style="background: rgba(4, 40, 68, 0.85)" >
            <form method="post" id="wizard">
        		<!-- SECTION 1 -->
                <h2></h2>
                <section>
                    <div class="inner">
						<div class="image-holder">
							<img src="images/form-wizard-1.jpg" style="object-fit:cover; height: 521px;" alt="">
						</div>
						<div class="form-content" >
							<div class="form-header">
								<h3>Registrarse</h3>
							</div>
							<p>Rellena con datos de usuario</p>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" placeholder="Nombre" class="form-control" name="username">
								</div>
								<div class="form-holder">
									<input type="text" placeholder="Apellidos" class="form-control" name="surnames">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" placeholder="Correo" class="form-control" name="email">
								</div>
								<div class="form-holder">
									<input type="text" placeholder="Telefono" class="form-control" name="phone">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" placeholder="Edad" class="form-control" name="age">
								</div>
								<div class="form-holder" style="align-self: flex-end; transform: translateY(4px);">
									<div class="checkbox-tick">
										<label class="male">
											<input type="radio" name="gender" value="male" checked> Hombre<br>
											<span class="checkmark"></span>
										</label>
										<label class="female">
											<input type="radio" name="gender" value="female"> Mujer<br>
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="checkbox-circle">
								<label>
									<input type="checkbox" require> Soy responsable de la autenticidad de los datos Ingresados.
									<span class="checkmark"></span>
								</label>
							</div>
						</div>
					</div>
                </section>
				<!-- SECTION 2 -->
                <h2></h2>
                <section>
                    <div class="inner">
						<div class="image-holder">
							<img src="images/form-wizard-2.jpg" style="object-fit:cover; height: 521px;" alt="">
						</div>
						<div class="form-content">
							<div class="form-header">
								<h3>Registrarse</h3>
							</div>
							<p>Informacion adicional</p>
							<div class="form-row">
								<div class="form-holder w-100">
									<input type="text" placeholder="Nickname" class="form-control" name="nickname">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="password" placeholder="Contraseña" class="form-control" name="password">
								</div>
								<div class="form-holder">
									<input type="password" placeholder="Confirmar Contraseña" class="form-control" name="confirm_password">
								</div>
							</div>
							<div class="form-row">
								<div class="select">
									<div class="form-holder">
										<div class="select-control">Puesto</div>
										<i class="zmdi zmdi-caret-down"></i>
									</div>
									<ul class="dropdown">
										<li rel="Empleado" onclick="choice('Employee')">Empleado</li>
										<li rel="Gerente" onclick="choice('Manager')">Gerente</li>
										<script>
											function choice(option) {
												document.getElementById('job').value = option;
											}
										</script>
										<input type="hidden" name="job" id="job">
									</ul>
								</div>
								<div class="form-holder"></div>
							</div>
						</div>
					</div>
                </section>
                <!-- SECTION 3 -->
                <h2></h2>
                <section>
                    <div class="inner">
						<div class="image-holder">
							<img src="images/form-wizard-3.jpg" style="object-fit:cover; height: 521px;" alt="">
						</div>
						<div class="form-content">
							<div class="form-header">
								<h3>Registrarse	</h3>
							</div>
							<p>Acerca del empleado</p>
							<div class="form-row">
								<div class="form-holder w-100">
									<textarea name="message" id="" placeholder="Observaciones opcionales" class="form-control" style="height: 99px;"></textarea>
								</div>
							</div>
							<div class="checkbox-circle mt-24">
								<label>
									<input type="checkbox" name="agree" require>  Acepto el <a href="#">uso correcto de los datos</a>
									<span class="checkmark"></span>
								</label>
							</div>
							<input type="submit" name="submit" value="Submit" style="background: #6d7f52; height: 41px; color: white; width: 124px; border:none">
						</div>
					</div>
                </section>
            </form>
		</div>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/jquery.steps.js"></script>
		<script src="js/main.js"></script>
</body>
</html>
