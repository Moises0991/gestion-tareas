<?php
function sendemail($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template){
	require("PHPMailer-master/src/PHPMailer.php");
    require("PHPMailer-master/src/SMTP.php");
	require("PHPMailer-master/src/Exception.php");
	require("PHPMailer-master/src/OAuth.php");
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$mail->isSMTP();                            // Establecer el correo electrónico para utilizar SMTP
	$mail->Host = "ssl://smtp.gmail.com";
	//$mail->IsSMTP();              // Especificar el servidor de correo a utilizar 
	$mail->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
	$mail->Username = $mail_username;          // Correo electronico saliente ejemplo: tucorreo@gmail.com
	$mail->Password = $mail_userpassword; 		// Tu contraseña de gmail
	$mail->SMTPSecure = 'tls';                  // Habilitar encriptacion, `ssl` es aceptada
	$mail->Port = 465;     
	$mail->SMTPKeepAlive = true;   
	$mail->Mailer = 'smtp'; // don't change the quotes!                     // Puerto TCP  para conectarse 
	$mail->setFrom($mail_setFromEmail, $mail_setFromName);//Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
	$mail->addReplyTo($mail_setFromEmail, $mail_setFromName);//Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
	$mail->addAddress($mail_addAddress);   // Agregar quien recibe el e-mail enviado
	$message =file_get_contents($template);
	$mail->msgHTML($message);
	
	$mail->Body = "
	

			$message
	


		 $txt_message 
		
		";


	$mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML
	
	$mail->Subject = "$mail_subject";
	
	if(!$mail->send()) {
		echo '<p style="color:red">No se pudo enviar el mensaje..';
		echo 'Error de correo: ' . $mail->ErrorInfo;
		echo "</p>";
	} else {
		echo '<p style="color:green">Tu mensaje ha sido enviado!</p>';
	}
}




?>