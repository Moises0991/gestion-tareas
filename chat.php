<?php 
session_start();
// include('chat/header.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!-- jQuery -->
	<title>Chat</title>
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
	<link href="chat/css/style.css" rel="stylesheet" id="bootstrap-css">
	<script src="chat/js/chat.js"></script>

	<style>
	.modal-dialog {
		width: 400px;
		margin: 30px auto;	
	}
	</style>
	
</head>
<div class="container">		
	<!-- se evalua si ha una sesion iniciada -->
	<?php if(isset($_SESSION['userid']) && $_SESSION['userid']) { ?> 	
		<div class="chat">	
			<div id="frame">		

				<!-------------------------------------------------------------------------------------------------------->
				<!---------------------------------------- inicio div aside ------------------------------------------>
				<div id="sidepanel">
					<!---------------------------------------- inicio div perfil ------------------------------------------>
					<div id="profile">
					<?php
					include ('chat/Chat.php');
					$chat = new Chat();
					$loggedUser = $chat->getUserDetails($_SESSION['userid']);
					echo '<div class="wrap">';
					$currentSession = '';
					foreach ($loggedUser as $user) {
						$currentSession = $user['current_session'];
						echo '<img id="profile-img" src="chat/userpics/'.$user['avatar'].'" class="online" alt="" />';
						echo  '<p>'.$user['nickname'].'</p>';
							echo '<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>';
							echo '<div id="status-options">';
							echo '<ul>';
								echo '<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>';
								echo '<li id="status-away"><span class="status-circle"></span> <p>Ausente</p></li>';
								echo '<li id="status-busy"><span class="status-circle"></span> <p>Ocupado</p></li>';
								echo '<li id="status-offline"><span class="status-circle"></span> <p>Desconectado</p></li>';
							echo '</ul>';
							echo '</div>';
							echo '<div id="expanded">';			
							echo '<a href="logout.php">Salir</a>';
							echo '</div>';
					}
					echo '</div>';
					?>
					</div>
					<!---------------------------------------- fin div perfil ------------------------------------------>


					<!---------------------------------------- inicio div search ------------------------------------------>
					<div id="search">
						<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
						<input type="text" placeholder="Buscar Contactos..." />					
					</div>
					<!---------------------------------------- fin div search ------------------------------------------>


					<!---------------------------------------- incio div contacts ------------------------------------------>
					<div id="contacts">	
					<?php
					echo '<ul>';
					$chatUsers = $chat->chatUsers($_SESSION['userid']);
					foreach ($chatUsers as $user) {
						$status = 'offline';						
						if($user['online']) {
							$status = 'online';
						}
						$activeUser = '';
						if($user['userid'] == $currentSession) {
							$activeUser = "active";
						}
						echo '<li id="'.$user['userid'].'" class="contact '.$activeUser.'" data-touserid="'.$user['userid'].'" data-tousername="'.$user['nickname'].'">';
						echo '<div class="wrap">';
						echo '<span id="status_'.$user['userid'].'" class="contact-status '.$status.'"></span>';
						echo '<img src="chat/userpics/'.$user['avatar'].'" alt="" />';
						echo '<div class="meta">';
						echo '<p class="name">'.$user['nickname'].'<span id="unread_'.$user['userid'].'" class="unread">'.$chat->getUnreadMessageCount($user['userid'], $_SESSION['userid']).'</span></p>';
						echo '<p class="preview"><span id="isTyping_'.$user['userid'].'" class="isTyping"></span></p>';
						echo '</div>';
						echo '</div>';
						echo '</li>'; 
					}
					echo '</ul>';
					?>
					</div>
					<!---------------------------------------- fin div contacts ------------------------------------------>


					<!---------------------------------------- incio div bottom-bar ------------------------------------------>
					<div id="bottom-bar">	
						<button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Agregar Contactos</span></button>
						<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Configuracion</span></button>					
					</div>
					<!---------------------------------------- fin div bottom-bar ------------------------------------------>


				</div>			
				<!---------------------------------------- fin div aside ------------------------------------------>
				<!-------------------------------------------------------------------------------------------------------->



				<!-------------------------------------------------------------------------------------------------------->
				<!---------------------------------------- comienzo div content ------------------------------------------>
				<div class="content" id="content"> 

				<!---------------------------------------- comienzo div contact perfil ------------------------------------------>
					<div class="contact-profile" id="userSection">	
					<?php
					$userDetails = $chat->getUserDetails($currentSession);
					foreach ($userDetails as $user) {										
						echo '<img src="chat/userpics/'.$user['avatar'].'" alt="" />';
							echo '<p>'.$user['nickname'].'</p>';
							echo '<div class="social-media">';
								echo '<i class="fa fa-facebook" aria-hidden="true"></i>';
								echo '<i class="fa fa-twitter" aria-hidden="true"></i>';
								 echo '<i class="fa fa-instagram" aria-hidden="true"></i>';
							echo '</div>';
					}	
					?>						
					</div>
				<!---------------------------------------- final div contact perfil ------------------------------------------>


				<!---------------------------------------- comienzo div messages ------------------------------------------>
        <!-- mensajes -->
					<div class="messages" id="conversation">		
					<?php
					echo $chat->getUserChat($_SESSION['userid'], $currentSession);						
					?>
					</div>
				<!---------------------------------------- fin div messages ------------------------------------------>


				<!---------------------------------------- inicio div mensaje de entrada ------------------------------------------>
					<div class="message-input" id="replySection">				
						<div class="message-input" id="replyContainer">
							<div class="wrap">
								<input type="text" class="chatMessage" id="chatMessage<?php echo $currentSession; ?>" placeholder="Escribe tu mensaje..." />
								<button class="submit chatButton" id="chatButton<?php echo $currentSession; ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>	
							</div>
						</div>					
					</div>
				<!---------------------------------------- fin div mensaje de entrada ------------------------------------------>
        
				</div>
				<!---------------------------------------- fin div content ------------------------------------------>
				<!-------------------------------------------------------------------------------------------------------->
			</div>
		</div>
	<?php } else { echo 'esta roña no esta funcionando'; } ?>
</div>	
<!---------------------------------------- fin div container ------------------------------------------>
<?php include('chat/footer.php');?>
