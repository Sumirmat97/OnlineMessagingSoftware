<?php 
	
	include "../query.php";
	session_start();
	
	$query = new Query($_SESSION['id']);
	
	
	$result = $query->getRequests($_GET['receiverid']);
	
	while($row = pg_fetch_assoc($result))
	{			
		$profile = new Profile($row['senderid']);
		
		?>
		<div class="col-md-12">
			
			<div class="alert alert-info alert-dismissable fade in" >
				
				<div class="row">
					<div class="col-md-4">
					<?php  echo "<img id='displayPic' class='img-circle ' src='../src/profilePics/".$profile->getProfilePicById($row['senderid'])."' width='87px' height='87px' >"; ?>
					</div>
					<div class="col-md-4" style="margin-top:5%;">
					<?php echo $profile->getNameById($row['senderid']);?>
					</div>	
					<div class="col-md-4" style="margin-top:4%;">
					<button  class="btn btn-success" onclick="acceptRequest(<?php echo $row['requestno'];?>,<?php echo $row['senderid'];?>,<?php echo $row['receiverid'];?>);getRequests(<?php echo $_SESSION['id'];?>);">Accept</button>
					<button  class="btn btn-danger" onclick="declineRequest(<?php echo $row['requestno'];?>);getRequests(<?php echo $_SESSION['id'];?>);">Decline</button>
					</div>
				</div>
			</div>
		</div>
		<?php
	
	}
		
?>