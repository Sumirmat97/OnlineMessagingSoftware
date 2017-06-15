<?php
	
	include "../query.php";
	session_start();
	$profile = new Profile($_SESSION['id']);
	
	$result = $profile->setStatus($_POST['status']);
	if($result){
?>  		<div class="input-group">			
				<input type="text" class="text-center blueBox" id="userStatus" style="text-align:center;" value="<?php echo trim($profile->getStatusById($_SESSION['id']));?>" >
				
				<span class="input-group-btn"> 
					<button class="btn btn-default" onclick="showStatusBox();" aria-label="Send" >
						<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					</button>
				</span>			
			</div>
			
<?php
	}
	else 
	{
?>
		<div class="input-group">			
			<input type="text" class="text-center blueBox" id="userStatus" style="text-align:center;" value="Status" >
			
			<span class="input-group-btn"> 
				<button class="btn btn-default" onclick="showStatusBox();" aria-label="Send" >
					<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				</button>
			</span>			
		</div>
<?php	
	}		
?>