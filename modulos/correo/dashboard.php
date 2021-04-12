

<!-- <html>
<head>


</head>
<body>
    


<h1>Formulario de contacto</h1>
<div class="contact">
	<div class="contact-main">
	<form method="post">
		<h3>Tu correo electrónico</h3>
		<input type="email" placeholder="your@email.com"   name="customer_email" required />
		
		<h3>Tu nombre</h3>
		<input type="text" placeholder="Your name"  name="customer_name" required />
		<h3>Asunto</h3>
		<input type="text" placeholder="Subject"  name="subject" required /> -->
		<?php
			
				//Mando a llamar la funcion que se encarga de enviar el correo electronico
				function captura($correo, $asignador){
				/*Configuracion de variables para enviar el correo*/
				include("sendmail.php");
				$email =$correo;
				$nombre = $asignador;
				$mail_username="sir.isaacnewton480@gmail.com";//Correo electronico saliente ejemplo: tucorreo@gmail.com
				$mail_userpassword="qawsedrf12345678";//Tu contraseña de gmail
				$mail_addAddress= $email;//correo electronico que recibira el mensaje
				$template="../correo/email_template.php";//Ruta de la plantilla HTML para enviar nuestro mensaje
				
				/*Inicio captura de datos enviados por $_POST para enviar el correo */
				$mail_setFromEmail=$mail_addAddress;
				$mail_setFromName=$nombre;
				$txt_message="-";
				$mail_subject="Tarea nueva asignada";
				
				sendemail($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template);//Enviar el mensaje
				}
		?>
	<!-- </div>
	<div class="enviar">
		<div class="contact-check">
			
		</div>
        <div class="contact-enviar">
		  <input type="submit" value="Enviar mensaje" name="send">
		</div>
		<div class="clear"> </div>
		</form>
</div>
</div>


</body>
</html> -->