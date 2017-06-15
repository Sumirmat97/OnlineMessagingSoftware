<?php

	include "../query.php";
	session_start();
	
	$profile = new Profile($_SESSION['id']);
	$query = new Query($_SESSION['id']);
	$_SESSION['talkingToId'] = substr($_GET['id'],1); 
	$_SESSION['cid'] = $query->getConversationId($_SESSION['id'],$_SESSION['talkingToId']);	?>
	
					<div class="heading">
						<div class="row" id="chatHead" style="height:7em;background-color:#c800c8; padding-top:0.5em; padding-bottom:0.3em; border-radius:0px 10px 0px 0px;">
							<div class="col-md-2">
								<?php  echo "<img id='photo' class='img-circle' src='../src/profilePics/".$profile->getProfilePicById($_SESSION['talkingToId'])."' width='87px' height='87px'>"; ?>
							</div>
							<div class="col-md-7 text-center" id="chatName" style="color:white;padding-top:2.3em;"><strong><?php echo $profile->getNameById($_SESSION['talkingToId']);?></strong>
								<div id="user2Status" style="padding-top:0.5em; font-size:12px;">
									
								</div>
							</div>
							<div class="col-md-1" id="attachFiles" style="padding-top:2em;">
								<a href="#" data-toggle="tooltip" data-placement="bottom" title="Attach Files">
									<button type="button" class="btn btn-default" name="fileToUpload" id="fileToUpload" data-toggle="modal" data-target="#myModal">
											<span class="glyphicon glyphicon-paperclip" > </span>
									</button>

									<!-- Modal -->
									<div class="modal fade" id="myModal" role="dialog">
										<div class="modal-dialog">

											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Upload file and images</h4>
												</div>
												<div class="modal-body " style="height:10em;">
														<!--	<form id = "upload_form" enctype="multipart/form-data" method="post">-->
															<div class="col-md-6" style="position:relative;">
																<input type="file" onchange="showName(this.value);removeOldName();" name="file1" id="file1" style="position:relative;z-index:2;text-align:right;opacity:0;">
																<div id="fakefile" style="position:absolute;top:-4px;left:0px;z-index:1;">
																	<button class="btn btn-primary">Select</button>

																</div>
															</div>

															<div class="col-md-6">
																<input type="button" value="Upload" class="btn btn-primary upload" onclick="uploadFile()" style="float:right;">
															</div>

															<div class="col-md-10" id="nameHolder"></div>

														<br/><br/><br/><br>
																<div class="col-md-10">
																	<progress id = "progressBar" value = "0" max="100" style="width:400px;"></progress>
																	<div id = "status"></div>
																	<div id = "loaded_n_total"></div><br><br>
																</div>
																<br><br>
												</div>
														<!--</form>-->
												<div class="modal-footer">
														<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>

							<div class="col-md-1" id="dropdown" style="padding-top:2em;">
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<span class="glyphicon glyphicon-option-vertical" ></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenu1">
										<li><a href="#" id="viewUser2" onclick="showRightSidebar();">View profile</a></li>
										<li><a href="javascript:deleteChatHistory();">Delete chat</a></li>
										<li id="incognito"><a href="javascript:incognitoOpen();">Go Incognito</a></li>
									</ul>
								</div>
							</div>

						</div><!--close row-->
					</div><!--close heading-->


					<div class="row" style="height:35em;">
						<div id="chatBox" style="height:35em;overflow-y:scroll;padding-top: 20px;padding-right: 30px;padding-left: 30px;padding-bottom: 20px;overflow-x: hidden;">
						

						</div>
					</div>

					<div class="row" id="chatFooter" style="height:4.5em;background-color:#c800c8;border-radius:0px 0px 10px 0px;">
						<div class="col-md-12" style="padding-bottom:1.05em;padding-top:1em;" >

								<div class="input-group">

									<input type="text" class="form-control" placeholder="Type a message" aria-describedby="sendBar" id="messageBar" value="" >

									<span class="input-group-btn" >
										
										<button class="btn btn-success" aria-label="Send" onclick="sendMessage(<?php echo $_SESSION['cid'];?>,'text');">
											<span class="glyphicon glyphicon-send" aria-hidden="true"></span>
										</button>
									</span>
								</div>
							
						</div><!-- close col-md-12 -->
					</div><!--close row-->
<?php echo "|".$_SESSION['cid'];?>