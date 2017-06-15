<?php

	session_start();
	if($_SESSION['isIncognito'] == 'false')
	{
		$_SESSION['isIncognito'] = 'true'; 
	}
	else
		$_SESSION['isIncognito'] = 'false';
	
?>