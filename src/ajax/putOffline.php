<?php
		
		include "../query.php";
		session_start();
		$query = new Query($_SESSION['id']);

		$result = $query->putOffline($_SESSION['id']);
	/*
		$query->deleteIncognitoChat($_SESSION['id']);
	*/	
		header("Location: ../logout.php");
?>