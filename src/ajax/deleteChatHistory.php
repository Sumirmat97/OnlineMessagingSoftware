<?php
	include "../query.php";
	session_start();
	
	$query = new Query($_SESSION['id']);

	$query->deleteChatHistory($_SESSION['cid']);
	
	echo "deleted";
?>