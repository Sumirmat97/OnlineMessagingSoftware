<?php 
	
	include "../query.php";
	session_start();
	
	$query = new Query($_SESSION['id']);
	
	
	$result = $query->getStarredMessages($_GET['ownerid']);
	
	while($row = pg_fetch_assoc($result))
	{	
		$profile = new Profile($row['senderid']);
		if($row['senderid'] == $_SESSION['id'])
		{		
			if($row['filetype'] == "text")
			{
				?>
				<div class="row ">
					<div class=" message col-md-6 col-md-offset-6">
						
						<div id="<?php echo 'ms'.$row['msid']?>" class="messageSent">
							<div class="col-md-12 text-center "><strong><?php echo $profile->getNameById($row['senderid']); ?></strong></div><br/><br/>
							<div class="messageText"><?php echo $row['content'];?><br/></div >
							
							<div class="col-md-2 binContainer" >
								<button id="<?php echo 'b'.$row['msid'];?>" class="glyphicon glyphicon-trash btn btn-xs" onclick="removeStarred('<?php echo $row['msid']?>');" aria-label="bin">	
								</button>
							</div>
							
						</div>						
					</div>
				</div>
				<?php
			}	
			else if($row['filetype'] == "video")
			{
				?>
				<div class="row ">
					<div class="message col-md-6 col-md-offset-6">
						<div id="<?php echo 'ms'.$row['msid']?>" class="messageSent col-md-6 col-md-offset-6">
							<div class="col-md-12 text-center "><strong><?php echo $profile->getNameById($row['senderid']); ?></strong></div><br/><br/>
							<div class="messageVideo"> 
								<video width="320px" height="240px" controls>
									<source src="../src/uploads/<?php echo $row['content']?>" type="video/mp4">
										Your browser does not support the video tag.
								</video> 
								<br/>

								<div class="col-md-2 binContainer" >
									<button id="<?php echo 'b'.$row['msid'];?>" class="glyphicon glyphicon-trash btn btn-xs" onclick="removeStarred('<?php echo $row['msid']?>');" aria-label="bin">	
									</button>
								</div>
							</div>
							
						
						</div>
					</div>
				</div>
				<?php
			}
			else if($row['filetype'] == "image")
			{
				?>
				<div class="row ">
					<div class="message col-md-6 col-md-offset-6">
						<div id="<?php echo 'ms'.$row['msid']?>" class="messageSent col-md-6 col-md-offset-6">
						<div class="col-md-12 text-center "><strong><?php echo $profile->getNameById($row['senderid']); ?></strong></div><br/><br/>
							<div class="messageImage" >
								<img src="../src/uploads/<?php echo $row['content'];?> " width="300px" />
								<br/>
							</div>
							
							
							<div class="col-md-2 binContainer" >
								<button id="<?php echo 'b'.$row['msid'];?>" class="glyphicon glyphicon-trash btn btn-xs" onclick="removeStarred('<?php echo $row['msid']?>');" aria-label="bin">	
								</button>
							</div>

						</div>
					</div>
				</div>
				<?php
			}
			else if($row['filetype'] == "pdf")
			{
				?>
				<div class="row ">
					<div class="message col-md-6 col-md-offset-6">
						<div id="<?php echo 'ms'.$row['msid']?>" class="messageSent col-md-6 col-md-offset-6">
							<div class="col-md-12 text-center "><strong><?php echo $profile->getNameById($row['senderid']); ?></strong></div><br/><br/>
							<div class="messagePdf">
								<a href="../src/uploads/<?php echo $row['content'];?>" target='_blank'><?php $pos = strpos($row['content'],"/"); echo substr($row['content'],$pos+1);?></a>
								<br/>
								
								
								<div class="col-md-2 binContainer" >
									<button id="<?php echo 'b'.$row['msid'];?>" class="glyphicon glyphicon-trash btn btn-xs" onclick="removeStarred('<?php echo $row['msid']?>');" aria-label="bin">	
									</button>
								</div>

							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		
		else
		{
			
			if($row['filetype'] == "text")
			{
				?>
				<div class="row ">
					<div class="message col-md-6">
						<div id="<?php echo 'ms'.$row['msid']?>" class="messageRecieved ">
							<div class="col-md-12 text-center "><strong><?php echo $profile->getNameById($row['senderid']); ?></strong></div><br/><br/>
							<div class="messageText"><?php echo $row['content'];?><br/></div>	
							
							<div class="col-md-2 binContainer" >
								<button id="<?php echo 'b'.$row['msid'];?>" class="glyphicon glyphicon-trash btn btn-xs" onclick="removeStarred('<?php echo $row['msid']?>');" aria-label="bin">	
								</button>
							</div>

						</div>
					</div>
				</div>
					
				<?php
			}	
			else if($row['filetype'] == "video")
			{
				?>
				<div class="row ">
					<div class="message col-md-6">
						<div id="<?php echo 'ms'.$row['msid']?>" class="messageRecieved col-md-6">
							<div class="col-md-12 text-center "><strong><?php echo $profile->getNameById($row['senderid']); ?></strong></div><br/><br/>
							<div class="messageVideo"> 
								<video width="320px" height="240px" controls>
									<source src="../src/uploads/<?php echo $row['content'];?>" type="video/mp4">
										Your browser does not support the video tag.
								</video> 
								<br/>
								
							<div class="col-md-2 binContainer" >
								<button id="<?php echo 'b'.$row['msid'];?>" class="glyphicon glyphicon-trash btn btn-xs" onclick="removeStarred('<?php echo $row['msid']?>');" aria-label="bin">	
								</button>
							</div>

							</div>
								
						</div>
					</div>
				</div>
				<?php
			}
			else if($row['filetype'] == "image")
			{
				?>
				<div class="row ">
					<div class="message col-md-6">
						<div id="<?php echo 'ms'.$row['msid']?>" class="messageRecieved col-md-5">
							<div class="col-md-12 text-center "><strong><?php echo $profile->getNameById($row['senderid']); ?></strong></div><br/><br/>
							<div class="messageImage">
								<img src="../src/uploads/<?php echo $row['content'];?> " width="300px"/>
								<br/>

							
							<div class="col-md-2 binContainer" >
								<button id="<?php echo 'b'.$row['msid'];?>" class="glyphicon glyphicon-trash btn btn-xs" onclick="removeStarred('<?php echo $row['msid']?>');" aria-label="bin">	
								</button>
							</div>

							</div>							
						</div>
					</div>
				</div>
				<?php
			}
			else if($row['filetype'] == "pdf")
			{
				?>
				<div class="row ">
					<div class="message col-md-6">
						<div id="<?php echo 'ms'.$row['msid']?>" class="messageRecieved col-md-6">
							<div class="col-md-12 text-center "><strong><?php echo $profile->getNameById($row['senderid']); ?></strong></div><br/><br/>
							<div class="messagePdf">
								<a href="../src/uploads/<?php echo $row['content'];?>" target='_blank'><?php $pos = strpos($row['content'],"/"); echo substr($row['content'],$pos+1);?></a>
								<br/>
								
								
							<div class="col-md-2 binContainer" >
								<button id="<?php echo 'b'.$row['msid'];?>" class="glyphicon glyphicon-trash btn btn-xs" onclick="removeStarred('<?php echo $row['msid']?>');" aria-label="bin">	
								</button>
							</div>

							</div>
						</div>
					</div>
				</div>
				<?php
			}
			
		}
	}
		
?>