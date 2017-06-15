<?php
	include "../query.php";
	session_start();
	
	$query = new Query($_SESSION['id']);
	
	$query->acceptRequest($_GET['requestNo'],$_GET['senderId'],$_GET['receiverId']);
	
?>