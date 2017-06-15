<?php

	include "../src/query.php";
	
	session_start();
	//non-valid initial value so that this is defined for the page
	$_SESSION['talkingToId'] = -1;
	$_SESSION['isIncognito'] = 'false';

	if(!isset($_SESSION['id']))
	{
		header("Location: index.php");
	}
	$profile = new Profile($_SESSION['id']);
	
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
		<script type="text/javascript" src="js/emojionearea.min.js"></script>
		<script type="text/javascript" src="js/emojione.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Envoy - messaging</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<link rel="icon" type="image/png" href="images/Envoy.png"/>

		<!--Emojione-->
		<link rel="stylesheet" type="text/css" href="css/emojionearea.min.css" >

		<link href="css/normalize.css" rel="stylesheet"></link>
		
		<link href="css/font-awesome.min.css" rel="stylesheet"></link>

		<link href="css/chat.css" rel="stylesheet">

		<style type="text/css">
			.container{
					margin-top:4em;
					
					border-radius:10px 10px 10px 0px;
					border:3px solid #c800c8;
					background-color:#f9f9f9;
					/*zoom: 90%;
					-moz-transform: scale(0.9);
			*/}
			.btn-default{

				background-color:inherit;
				color:white;
				border:none;
			}
			.btn-default:hover{

				background-color: #980098 !important;
				color:white;
			}
			.btn-default:active{
				background-color: #980098 !important;
			}
			.col-md-1{
				padding-left:0px !important;
			}

			.pastChats{
				color:white;
				background-color: #c800c8;
				padding:0.5em;
				border-bottom:1px solid white;
			}
			.pastChats:hover{
				cursor:pointer;
			}
			#leftSidebarWrapper{

				display:none;
				color:white;
				border-radius:10px 0px 0px 0px;
				border-right: 1px solid #c800c8;
				overflow-y: hidden;
				background-color: #c800c8 !important;
				height:46.5em;
			}
			#rightSidebarWrapper{

				display:none;
				color:white;
				border-radius:0px 10px 10px 0px;
				overflow-y:hidden;
				background-color: #c800c8 !important;
				height:46.5em;

			}
			#userWrapper{
				border-right:1px solid #c800c8;
				height:46.5em;
			}
			#historyBox{
				margin-top:2em;
				overflow-y: scroll;
				height:33em;
			}
			body{
				background-color:#dadada;
				
			}

		</style>

	</head>

	<body onload="enableOnLoad();showStatus();">
		<div id="particles-js" style="height:110%; width:100%; margin-top:-5em; position:fixed;"></div>
		<div class="container">

			<div class="row">
				<div id="leftSidebarWrapper">

					<div class="col-md-2" style="padding-top:0.5em;padding-bottom:3em;">
						<button type="button" class="btn btn-default" onclick="hideLeftSidebar();">
								<span class="glyphicon glyphicon-arrow-up"></span>
						</button>
					</div>
					<div class="col-md-12 text-center" >
							<div style="padding-bottom:5em;">
								<?php echo "<a href='' data-toggle='modal'  data-target = '#uploadprofilepicmodal'  title='Upload profile picture'><img class='img-circle' id='profilePicDisplay' src='../src/profilePics/".$profile->getProfilePicById($_SESSION['id'])."' width='300px'></a>";
								?>
							</div>
						</div>

						<!-- Modal -->
						<div class = "modal fade" id = "uploadprofilepicmodal"  role = "dialog" >

							<div class = "modal-dialog">
								<div class = "modal-content">

									<div class = "modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title" style="color:blue;">Upload profile images</h4>
									</div>

									<div class = "modal-body" style="height:10em;">
										<div class="col-md-6" style="position:relative;">
											<input type="file" onchange="removeOldName1();showName1(this.value);" name="profilepic" id="profilepic" style="position:relative;z-index:2;text-align:right;opacity:0;">
											<div id="picture" style="position:absolute;top:-4px;left:0px;z-index:1;">
												<button class="btn btn-primary">Select</button>
												<div id="fileSelected" style="color:blue;"></div>
											</div>
										</div>
										<div class="col-md-6">
											<input type="button" value="Upload" class="btn btn-primary upload" onclick="uploadProfilePic();" style="float:right;">
										</div>
										<br/><br/><br/><br/>
										<div class="col-md-10">
											<progress id = "progressBar1" value = "0" max="100" style="width:450px;"></progress>
												<div id = "status1" style="color:blue;"></div>
												<div id = "loaded_n_total1" style="color:blue;"></div>
												<br><br>
										</div>
										<br><br>
									</div>


									<div class = "modal-footer">
										<button type = "button" class="btn btn-primary" data-dismiss="modal">Close</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->

						</div><!-- /.modal -->

					<div class="col-md-12 text-center text-bold " style="margin-bottom:3em;font-size: 16px;"><strong><?php echo $profile->getNameById($_SESSION['id']);?></strong>
					</div>
					
					<br><br><br>
					
					<!-- the status that is shown -->
					<div class="col-md-10 col-md-offset-2" id="blueBox1">

					</div>

					<!-- the status box to change the current status -->
					<div class="col-md-12 " id="statusBox" >
							<div class="input-group">

								<input type="text" id="statusBar" class="form-control" placeholder="Status" value="<?php echo trim($profile->getStatusById($_SESSION['id']));?>" aria-describedby="statusBar">

								<span class="input-group-btn">
									<button class="btn btn-success" onclick="showStatus();" aria-label="Send" >
										<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
									</button>
								</span>
							</div>
					</div>
					<script>
							function showStatus()
							{
								var newStatus = document.getElementById("statusBar").value;
								newStatus = newStatus.trim();
								var xhttp;
								if (window.XMLHttpRequest)
								{
									xhttp = new XMLHttpRequest();}
								else
								{
									xhttp = new ActiveXObject("Microsoft.XMLHTTP");
								}
								xhttp.onreadystatechange=function()
								{
									if(this.readyState == 4 && this.status == 200)
									{
										hideStatusBox();
										document.getElementById("blueBox1").innerHTML = this.responseText;
										$(document).ready(function() {
											$("#userStatus").emojioneArea();
										});

									}
								};
								xhttp.open("POST","../src/ajax/showStatus.php",true);
								xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
								var para = "status=" + newStatus;
								xhttp.send(para);
							}
							
							function sendMessage(cid,filetype)
							{
								if (window.XMLHttpRequest)
								{
									// code for IE7+, Firefox, Chrome, Opera, Safari
									xmlhttp = new XMLHttpRequest();
								}
								else
								{  // code for IE6, IE5
									xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
								}
								xmlhttp.onreadystatechange=function()
								{
									if(this.readyState == 4 && this.status == 200)
									{
										if(this.responseText == "true")
										{
											clearSendBar();
										}
										else
											alert("error in sending message");
																	
										var height = 0;
										$("#chatBox div").each(function(i,value){
											height += parseInt($(this).height());
										});
										
										height += '';
										$("#chatBox").animate({scrollTop: height});
									}
								};

								content = document.getElementById("messageBar").value;
								if(content != "")
								{
									xmlhttp.open("GET","../src/ajax/sendMessage.php?cid="+cid+"&"+"content="+content+"&"+"filetype="+filetype,true);
									xmlhttp.send();
								}

							}
						</script>	
				</div>

				<div class="col-md-4" id="userWrapper" >
					<div class="row" style="height:7em;background-color: #c800c8; padding-top:0.50em; padding-bottom:0.30em; border-radius:10px 0px 0px 0px;">
						<div class="col-md-10" >
							<a>
								<?php  echo "<img id='displayPic' class='img-circle' src='../src/profilePics/".$profile->getProfilePicById($_SESSION['id'])."' width='87px' height='87px'>"; ?>
							</a>
						</div>

						<div class="col-md-2" style="padding-top:8%">
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="glyphicon glyphicon-option-vertical" ></span>
								</button>
								<ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenu1">
									<li ><a href="#" onclick="showLeftSidebar();disableMyStatus();">View profile</a></li>
									
									<li><a href="#" onclick="showStarredBox();">Starred Messages</a></li>
									
									<li><a href="#" onclick="showRequestsBox();">Friend Requests</a></li>
									
									<li><a href="#" id="changePassword" data-toggle="modal"  data-target = "#changePasswordModal" >Change Password</a></li>
									<li><a href="javascript:putOffline();" id="logout" >Logout</a></li>
								</ul>
							</div>
						</div>
					</div>

									<!-- Modal -->
					<div class = "modal fade" id = "changePasswordModal"  role = "dialog" >
						<div class = "modal-dialog">
							<div class = "modal-content">

								<div class = "modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="color:blue;">Change Password</h4>
								</div>

								<div class = "modal-body" style="height:12em;">
								<!--	<div class="col-md-6" style="position:relative;">-->

									<label class="col-sm-4 control-label">Password : </label>
					<div class="col-sm-8">
					  <input type="password" class="form-control" placeholder="Password" name="password" required="required" id="pass"/>
					</div>
									<br><br>
									<label class="col-sm-4 control-label">New Password : </label>
					<div class="col-sm-8">
					  <input type="password" class="form-control" placeholder="New Password" name="newPassword" required="required" id="new_pass"/>
					</div>
									<br><br>
									<label class="col-sm-4 control-label">Confirm Password : </label>
					<div class="col-sm-8">
					  <input type="password" class="form-control" placeholder="Confirm Password" name="conPassword" required="required" id="con_pass"/>
					</div>
									<br><br>
									<div style="color:#FF0000;" id="errorOnChangePassword"></div>
									<br>
								</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-primary" name="submitPassword" onclick="changePassword()" style="float:left;margin-left:5%;">Submit</button>
									<button type = "button" class="btn btn-primary" data-dismiss="modal" style="float:right;margin-right:5%;">Close</button>
							</div>


							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

					<!--Search Box-->
					<div class="row">
						<div class="col-md-12" style="margin-top:2em;" >
							<div class="input-group" id="searchBox">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-search" id="searchIcon"></span>
								</span>
								<input type="text" id="searchBar" oninput="liveSearch(this.value);" class="form-control" placeholder="Search" aria-describedby="searchBar">
							</div>
							<div class="col-md-12" >
									<div class="col-md-12" style="margin-left:23px;width:89%; position:absolute;z-index:100;" id="livesearch"></div><!-- added for dynamic response -->
							</div>
						</div><!--close searchBar-->
					</div>

					
					<!--history of chats done with people-->					
					<!--History Box-->
					<div class="row" id="historyBox">
						<div class="col-md-12">
						
						</div>
					</div><!--close history box-->

			</div><!-- close userWrapper -->


				<!--Message Column-->
				<div class="col-md-8" id="messageColumn" style="background-image:url(images/Envoy.png);background-repeat:no-repeat;background-position: 50% 50%;" >
					<div id="messageWrapper" >
						
						<div id="particles-js" style="height:44em;">
							<script src="js/particles.min.js"></script>
								<script src="js/app.js"></script>
								<!--<img class="img" src="images/p1.jpg" style="height:100%; width:100%">-->
						</div>



					</div><!-- close messageWrapper -->
				</div><!-- close col-md-8 -->

				<!--Hidden rightSidebar-->
				<div class="col-md-4" id="rightSidebarWrapper" >

				</div><!-- close rightSidebarWrapper -->


			</div><!--closed row-->

		</div><!-- closed container-->
	
	<!--
		<div class="container-fluid" style="height:2em;position:absolute;top:100%;background-color:#77aaff;">
		<footer class="text-center">
				&copy; Made By Sumir Himani Parth
		</footer>
		</div>
	-->

		

		<script type="text/javascript" src="js/chatScripts.js"></script>
	</body>
</html>
