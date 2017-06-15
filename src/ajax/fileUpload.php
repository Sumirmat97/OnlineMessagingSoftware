<?php

	include "../query.php";
	session_start();
	
	$query = new Query($_SESSION['id']); 

	$fileName = $_FILES["file1"]["name"];
	$fileTmpLoc = $_FILES["file1"]["tmp_name"];
	$fileType = $_FILES["file1"]["type"];
	$fileSize = $_FILES["file1"]["size"];
	$fileErrorMsg = $_FILES["file1"]["error"];

	if(!$fileTmpLoc)
	{
		echo "ERROR : plz browse for a file before clicking the uploaded";
		exit();
	}
	
	$extension = pathinfo($fileName,PATHINFO_EXTENSION);
	
	if($extension == "pdf")
		$fileType = "pdf";
	else if($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "JPG" ||$extension == "PNG" || $extension == "JPEG")
		$fileType = "image";
	
	else if($extension == "mp3" || $extension == "MP3")
		$fileType = "audio";
	
	else if($extension == "mp4" || $extension == "MP4")
		$fileType = "video";
	
	else
	{
			echo "Only .pdf, .jpg,.png, .gif, .jpeg, .mp3, .mp4 are supported ";
			unlink($fileTmpLoc);
			exit();
	}	
	
	if(move_uploaded_file($fileTmpLoc,"../uploads/".$_SESSION['id']."/".$fileName))
	{
		if($query->sendMessage($_SESSION['cid'],$_SESSION['id']."/".$fileName,$fileType,$_SESSION['isIncognito']))
			echo "Upload complete ";
		else
			echo "Error in uploading";
	}
	else
	{
		echo "move_uploaded_file function failed";
	}

 ?>
