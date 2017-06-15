<?php
	
	include "../query.php";
	
	session_start();
	
	$query = new Query($_SESSION['id']);
	
	$query->declineRequest($_GET['requestNo']);
	
?>