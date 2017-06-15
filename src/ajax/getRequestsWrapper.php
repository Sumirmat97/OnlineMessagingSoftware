<?php

	include "../query.php";
	session_start();
	
	$profile = new Profile($_SESSION['id']);
	$query = new Query($_SESSION['id']);
?>
					<div class="heading">
						<div class="row" id="requestsHead" style="height:7em;background-color:#c800c8; padding-top:0.5em; padding-bottom:0.3em; border-radius:0px 10px 0px 0px;">
							<div class="col-md-6 col-md-offset-2 text-center" id="requestsHeader" style="color:white;padding-top:2.3em;font-size:16px; "><strong>Friend Requests</strong></div>

						</div><!--close row-->
					</div><!--close heading-->


					<div class="row" style="height:39em;">
						<div id="requestsBox" style="height:39em;overflow-y:scroll;padding-top: 20px;padding-right: 30px;padding-left: 30px;padding-bottom: 20px;overflow-x: hidden;">
						

						</div>
					</div>
<?php echo "|".$_SESSION['id'];?>