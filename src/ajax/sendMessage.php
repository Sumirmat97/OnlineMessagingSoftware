<?php
	session_start();
	include "../query.php";
	
	$query = new Query($_SESSION['id']);
	if($query->sendMessage($_GET['cid'],$_GET['content'],$_GET['filetype'],$_SESSION['isIncognito']))
		echo "true";
	else
		echo "false";
		
?>