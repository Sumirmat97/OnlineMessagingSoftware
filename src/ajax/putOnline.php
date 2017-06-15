<?php
		
		include "../query.php";
		session_start();
		$query = new Query($_SESSION['id']);

		$result = $query->putOnline();
		
		
?>