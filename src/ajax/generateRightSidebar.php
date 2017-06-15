<?php
	
	include "../query.php";
	session_start();
	$profile = new Profile($_SESSION['id']);	

?>		
				<div class="col-md-2" style="padding-top:0.5em;padding-bottom:2.8em;">
					<button type="button" class="btn btn-default btn-sm" onclick="hideRightSidebar();">
							<span class="glyphicon glyphicon-arrow-right"></span>
					</button>
				</div>

				<div class="col-md-12 text-center">
					<div style="padding-bottom:5em;">
							<?php echo "<img class='img-circle' src='../src/profilePics/".$profile->getProfilePicById($_SESSION['talkingToId'])."' width='300px'>"; ?>
					</div>
				</div>

				<div class="col-md-12 text-center text-bold " style="margin-bottom:3em;font-size: 16px;"><strong><?php echo $profile->getNameById($_SESSION['talkingToId']);?></strong>
				</div>
				
				<br><br><br>
				
				<div class="col-md-12">
					<div class="input-group">
						
						<input type="text" id="status2" class="form-control blueBox text-center" value="<?php echo trim($profile->getStatusById($_SESSION['talkingToId']));?>" aria-describedby="status">
										
					</div>						
				</div>	
