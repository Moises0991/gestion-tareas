<?php
    // include 'funciones.php';
	
    // csrf();
    // if (isset($_POST['submit'])&& !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    //     die();
    // }

    if (isset($_POST['submit'])) { //el isset es una funcion que determina si una variable esta definida o no en el php
        $resultado = [
           'error' => false,
           'mensaje' => 'El usuario ' . escapar($_POST['username']) . ' ha sido agregado con éxito'
        ];
        $config = include '../database/config.php';

        try {

            $dns = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            // a continuacion se crea la variable con el pdo que servira para la conexion a la base de datos
            $conexion = new PDO ($dns, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            $contraseña = md5($_POST['password']);
			// en el siguiente array se guardan en las claves los valores que se recibieron en el submit de acuerdo al name del form
            $usuario = [
                "nombre_usuario" => $_POST['username'],
                "apellidos_usuario" => $_POST['surname'],
                "password_usuario" => $contraseña,
                "edad_usuario" => $_POST['edad'],
                "correo_usuario" => $_POST['email'],
                "profesion_usuario" => "1"
            ];

            // a continuacion se se crea la varible consulta sql; que sera la que realizara la consulta en la base de datos
            $consultaSQL = "INSERT INTO usuarios (nombre_usuario, apellidos_usuario, password_usuario, edad_usuario, correo_usuario, profesion_usuario)";
            // implode sirve para convertir un array en una cadena de texto
            // array_keys — Devuelve todas las claves de un array o un subconjunto de claves de un array
            $consultaSQL .= "values (:" .implode(", :", array_keys($usuario)).")";
            // hasta el punto anterior no se han especificado que los datos de la consulta provengan de el array usuarios
            // en la varible sentencia se almacena toda la informacion necesaria para almacenar los datos que ingrese el usuario
            //prepare sirve para preparar una sentencia para su ejecución y devuelve un objeto sentencia
            // Prepara una sentencia SQL para ser ejecutada por el método PDOStatement::execute().
            $sentencia = $conexion->prepare($consultaSQL);
            // en la siguiente linea se ejecuta la sentencia con los valores del array
            //Execute permite ejecutar un script o una función PHP
            $sentencia->execute($usuario);

        } catch (PDOException $error) {

            $resultado['error'] = true;
            $resultado['mensaje'] = $error -> getMessage();
            
        }
    }
?>

<!--------------------------- se crea el html -------------------------------------->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>FormWizard_v1</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.css">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="wrapper" style="background: rgb(61 116 158 / 85%);">
            <form action="" id="wizard">
        		<!-- SECTION 1 -->
                <h2></h2>
                <section>
                    <div class="inner">
						<div class="image-holder">
							<img src="images/form-wizard-1.jpg" alt="">
						</div>
						<div class="form-content" >
							<div class="form-header">
								<h3>Registration</h3>
							</div>
							<p>Please fill with your details</p>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" placeholder="First Name" class="form-control">
								</div>
								<div class="form-holder">
									<input type="text" placeholder="Last Name" class="form-control">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" placeholder="Your Email" class="form-control">
								</div>
								<div class="form-holder">
									<input type="text" placeholder="Phone Number" class="form-control">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" placeholder="Age" class="form-control">
								</div>
								<div class="form-holder" style="align-self: flex-end; transform: translateY(4px);">
									<div class="checkbox-tick">
										<label class="male">
											<input type="radio" name="gender" value="male" checked> Male<br>
											<span class="checkmark"></span>
										</label>
										<label class="female">
											<input type="radio" name="gender" value="female"> Female<br>
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="checkbox-circle">
								<label>
									<input type="checkbox" checked> Nor again is there anyone who loves or pursues or desires to obtaini.
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
							<img src="images/form-wizard-2.jpg" alt="">
						</div>
						<div class="form-content">
							<div class="form-header">
								<h3>Registration</h3>
							</div>
							<p>Please fill with additional info</p>
							<div class="form-row">
								<div class="form-holder w-100">
									<input type="text" placeholder="Address" class="form-control">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" placeholder="City" class="form-control">
								</div>
								<div class="form-holder">
									<input type="text" placeholder="Zip Code" class="form-control">
								</div>
							</div>

							<div class="form-row">
								<div class="select">
									<div class="form-holder">
										<div class="select-control">Your country</div>
										<i class="zmdi zmdi-caret-down"></i>
									</div>
									<ul class="dropdown">
										<li rel="United States">United States</li>
										<li rel="United Kingdom">United Kingdom</li>
										<li rel="Viet Nam">Viet Nam</li>
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
							<img src="images/form-wizard-3.jpg" alt="">
						</div>
						<div class="form-content">
							<div class="form-header">
								<h3>Registration</h3>
							</div>
							<p>Send an optional message</p>
							<div class="form-row">
								<div class="form-holder w-100">
									<textarea name="" id="" placeholder="Your messagere here!" class="form-control" style="height: 99px;"></textarea>
								</div>
							</div>
							<div class="checkbox-circle mt-24">
								<label>
									<input type="checkbox" checked>  Please accept <a href="#">terms and conditions ?</a>
									<span class="checkmark"></span>
								</label>
							</div>
						</div>
					</div>
                </section>
            </form>
		</div>

		<!-- JQUERY -->
		<script src="js/jquery-3.3.1.min.js"></script>

		<!-- JQUERY STEP -->
		<script src="js/jquery.steps.js"></script>
		<script src="js/main.js"></script>
		<!-- Template created and distributed by Colorlib -->
</body>
</html>
