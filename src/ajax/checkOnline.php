<?php
		
		include "../query.php";
		include "../getTime.php";
		session_start();
	
		$query = new Query($_SESSION['id']);
		
		$result = $query->checkOnline(substr($_GET['id'],1));
			
		if($result == "")
			echo "Online";
		else
			echo "Last seen at ". periodElapsed(strtotime($result));
		
?>