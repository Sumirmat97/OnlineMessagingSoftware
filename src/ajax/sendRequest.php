<?php
	include "../query.php";
	session_start();
	
	$query = new Query($_SESSION['id']);
	
	$result = $query->sendRequest(substr($_GET['id'],1));

	if($result == FALSE)
	{
		echo "alreadySent";
	}
	else
		echo "sent";
		
?>