<?php
		
		include "../query.php";
		
		session_start();
	
		$query = new Query($_SESSION['id']);
		
		$result = $query->checkFriend(substr($_GET['id'],1));
			
		if($row =  pg_fetch_assoc($result))
		{
			echo "yes";
		}
		else 
			echo "no";
		
?>