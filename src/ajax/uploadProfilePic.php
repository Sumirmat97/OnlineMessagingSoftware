<?php

	include "../query.php";
	session_start();

	//object created
	$profile = new Profile($_SESSION['id']);

	  $imgFile = $_FILES['profilepic']['name'];
	  $tmp_dir = $_FILES['profilepic']['tmp_name'];
	  $imgSize = $_FILES['profilepic']['size'];
	  $fileType = $_FILES["profilepic"]["type"];
	  $fileErrorMsg = $_FILES["profilepic"]["error"];

	  if($imgFile)
	  {
		$upload_dir = '../profilePics/'; // upload directory
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		$valid_extensions = array('gif', 'jpeg', 'jpg', 'png'); // valid extensions

		$userpic = $_SESSION['id'].".".$imgExt;
		if(in_array($imgExt, $valid_extensions))
		{
		  if($imgSize < 500000000000)
		  {
			//  $picture=$profile->getProfilePicById($_SESSION['id']);
			//  unlink($upload_dir.$picture);
			  move_uploaded_file($tmp_dir,$upload_dir.$userpic);
			 
			  if($profile->changeProfilePic($userpic))
			  {
				echo "Updated!!! Reload To Refresh";
			  }
		  }
		  else
		  {
			echo "Sorry, your file is too large.";
		  }
		}
		else
		{
		  echo "Sorry, only JPG, JPEG, PNG, GIF files are allowed.";
		}
	  }

 ?>
