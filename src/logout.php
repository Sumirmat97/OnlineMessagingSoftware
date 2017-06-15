<?php
		include "query.php";
		session_start();
		
		$query = new Query($_SESSION['id']);
		$query->deleteIncognitoChat($_SESSION['id']);
		
	
		if(isset($_SESSION['id']))
		{
			print_r($_SESSION);
			session_destroy();
		}
		
		header("Location: ../web/index.php#tologin");
?>