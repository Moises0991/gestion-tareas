<?php 
session_start();
include ('../../Chat.php');
$chat = new Chat();
$chat->updateUserOnline($_SESSION['userid'], 0);
header("Location: ../../index1.php");
?>






