<?php

	include "../query.php";
	session_start();

	$query = new Query($_SESSION['id']);
	
	$result = $query->setStarred(substr($_GET['mid'],1),$_SESSION['id']);
	
	if($result === "true")
		echo "true";
	else
		return "false";

	
?>
