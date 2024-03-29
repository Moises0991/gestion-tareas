<?php
session_start();
include ('Chat.php');
$chat = new Chat();



if($_POST['action'] == 'update_user_list') {
	$chatUsers = $chat->chatUsers($_SESSION['userid']);
	$data = array(
		"profileHTML" => $chatUsers,	
	);
	echo json_encode($data);	
}



if($_POST['action'] == 'insert_chat') {
	$chat->insertChat($_POST['to_user_id'], $_SESSION['userid'], $_POST['chat_message']);
}



if($_POST['action'] == 'show_chat') {
	$chat->showUserChat($_SESSION['userid'], $_POST['to_user_id']);
}


if($_POST['action'] == 'update_user_chat') {
	$conversation = $chat->getUserChat($_SESSION['userid'], $_POST['to_user_id']);
	$data = array(
		"conversation" => $conversation			
	);
	echo json_encode($data);
}



if($_POST['action'] == 'update_unread_message') {
	$count = $chat->getUnreadMessageCount($_POST['to_user_id'], $_SESSION['userid']);
	$message = $chat->getLatestMessage($_POST['to_user_id'], $_SESSION['userid'], 'message');
	$date = $chat->getLatestMessage($_POST['to_user_id'], $_SESSION['userid'], 'date');
	$data = array(
		"count" => $count,		
		"message" => $message,
		"date" => $date			
	);
	echo json_encode($data);
}

// se actualiza la lista de tareas pendientes
if($_POST['action'] == 'update_tasks') {
	$selected = $chat->updateTasksList($_POST['taskId'],$_POST['userId']);
	$data = array(
		"selected" => $selected,		
	);
	echo json_encode($data);
}

// se muestra la lista de tareas pendientes
if($_POST['action'] == 'show_tasks') {
	$list = $chat->showTaskList($_POST['userId']);
	$data = array(
		"list" => $list,		
	);
	echo json_encode($data);
}


if($_POST['action'] == 'update_typing_status') {
	$chat->updateTypingStatus($_POST["is_type"], $_SESSION["login_details_id"]);
}



if($_POST['action'] == 'show_typing_status') {
	$message = $chat->fetchIsTypeStatus($_POST['to_user_id']);
	$data = array(
		"message" => $message			
	);
	echo json_encode($data);
}
?>