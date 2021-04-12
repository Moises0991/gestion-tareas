<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
    // include 'funciones.php';
	
    // csrf();
    // if (isset($_POST['submit'])&& !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    //     die();
    // }

	// se valida envio de formulario
    if (isset($_POST['submit'])) { 

		$config = include '../login/data/config.php';
		$conection = new mysqli($host_name, $user_db, $pass_db, $db_name);
        
		$SQL1 = "SELECT count(*) total FROM usuarios_espera";
		$sentence1 = $conection -> query($SQL1);
		$task1 = $sentence1 -> fetch_array(MYSQLI_ASSOC);
       if($task1['total'] > 2){
	
	}else {

		$resultado = [
			'error' => false,
			'mensaje' => 'El usuario ' . $_POST['username'] . ' ha sido agregado con éxito'
		 ];
		 
		
		
        try {


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
			$puesto = $_POST['job'];
			$comentario = $_POST['message'];

			if ($_POST['gender']=='male') {
				$filename = $nickname . '.jpg';
				$source = '../chat/userpics/user5.jpg';
				$destination = '../img/avatars/'.$filename;
				$sexo = "Hombre";
				if (!copy($source, $destination)) {
					echo "Error al copiar $source...\n";
				}
			} else {
				$filename = $nickname . '.jpg';
				$source = '../chat/userpics/user4.jpg';
				$destination = '../img/avatars/'.$filename;
				$sexo = "Mujer";
				if (!copy($source, $destination)) {
					echo "Error al copiar $source...\n";
				}
			}

	          	$sql = "INSERT INTO `usuarios_espera` (`nickname`, `username`, `pass_user`, `user_age`, `email`, `phone`, `avatar`, `puesto`, `comentarios`, `sexo`) ";
				$sql .= "VALUES ('$nickname', '$username', '$pass_user', '$user_age', '$email', '$phone', '$filename', '$puesto', '$comentario', '$sexo')";
				$sentence = $conection->prepare($sql);
				$sentence->execute();

			
			
        } catch (PDOException $error) {

            $resultado['error'] = true;
            $resultado['mensaje'] = $error -> getMessage();
            
        }
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
																<!--  -->
			
<!--  -->
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
									<input type="text" placeholder="Nombre" class="form-control" name="username" required pattern="[A-Za-z-ñ-Ñ]+" title="Solo se aceptan letras de la [A-Z] o [a-z]" maxlength="40">
								</div>
								<div class="form-holder">
									<input type="text" placeholder="Apellidos" class="form-control" name="surnames" required pattern="[A-Za-z-ñ-Ñ]+" title="Solo se aceptan letras de la [A-Z] o [a-z]" maxlength="40">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="Email" placeholder="Correo" class="form-control" name="email" required pattern="[A-Za-z0-9-ñ-Ñ ]+" title="Solo se aceptan letras de la [A-Z] o [a-z] y numeros" maxlength="40">
								</div>
								<div class="form-holder">
									<input type="text" placeholder="Telefono" required pattern="[0-9 ]+" title="Solo se aceptan numeros" maxlength="10" class="form-control" name="phone">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" placeholder="Edad" class="form-control" name="age" required pattern="[0-9]+" title="Solo se aceptan numeros" maxlength="2">
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
									<input type="text" placeholder="Nickname" class="form-control" name="nickname" required pattern="[A-Za-z0-9-ñ-Ñ ]+" title="Solo se aceptan letras de la [A-Z] o [a-z] y numeros" maxlength="40">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="password" placeholder="Contraseña" class="form-control" name="password" required pattern="[A-Za-z0-9-ñ-Ñ ]+" title="Solo se aceptan letras de la [A-Z] o [a-z] y numeros" maxlength="40">
								</div>
								<div class="form-holder">
									<input type="password" placeholder="Confirmar Contraseña" class="form-control" name="confirm_password" required pattern="[A-Za-z0-9-ñ-Ñ ]+" title="Solo se aceptan letras de la [A-Z] o [a-z] y numeros" maxlength="40">
								</div>
							</div>
							<div class="form-row">
								<div class="select">
									<div class="form-holder">
										<div class="select-control">Puesto</div>
										<i class="zmdi zmdi-caret-down"></i>
									</div>
									<ul class="dropdown">
										<li rel="Empleado" onclick="choice('Empleado')">Empleado</li>
										<li rel="Gerente" onclick="choice('Gerente')">Gerente</li>
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
							<input type="submit" id="confirm" name="submit" value="Submit" style="background: #6d7f52; height: 41px; color: white; width: 124px; border:none" >
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


<?php
if(isset($_POST['submit'])){
if (isset($resultado)) {
?>
<script>	
		
		swal("Correcto!", "Tu solicitud, fue enviada con exito!", "success");
</script>



<?php
}else {
?>

<script>	
		
		swal("Solicitud rechazada!", "Se alcanzo el limite de solicitudes!", "error");
</script>


<?php
}}
?>