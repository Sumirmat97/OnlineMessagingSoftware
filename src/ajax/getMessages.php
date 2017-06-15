<?php 
	
	include "../query.php";
	include "../getTime.php";
	session_start();
	
	$query = new Query($_SESSION['id']);
	
	$result = $query->getMessages($_GET['cid'],$_GET['count']);
	
	while($row = pg_fetch_assoc($result))
	{
		if($row['senderid'] == $_SESSION['id'])
		{
			if($row['filetype'] == "text")
			{
				?>
				<div class="row ">
					<div class=" message col-md-6 col-md-offset-6">
						<div id="<?php echo 'm'.$row['mid']?>" class="messageSent">
							<div class="messageText"><?php echo $row['content'];?><br/></div >
							
							
							<div class="col-md-2 starContainer" >
								<button id="<?php echo 's'.$row['mid'];?>" class="glyphicon glyphicon-star-empty btn btn-xs" onclick="setStarred('<?php echo 'm'.$row['mid'];?>','<?php echo 's'.$row['mid'];?>');" aria-label="star">	
								</button>
							</div>

							<div class="col-md-7 col-md-offset-1" >
								<span class="time"><?php echo periodElapsed(strtotime($row['timestamp']));?></span>
							</div>
							<?php 
								if($row['status'] == "t")
								{	
							?>
								<div class="col-md-1 " >
									<span class="fa-stack fa-xs " style="color:#33aaff">
										<i class="fa fa-check fa-stack-1x" style="margin-left:4px"></i>
										<i class="fa fa-check fa-inverse fa-stack-1x" style="margin-left:-3px;"></i>
										<i class="fa fa-check fa-stack-1x" style="margin-left:-4px"></i>
									</span>		
								</div>
							<?php
								}
								else
								{
							?>
								<div class="col-md-1 " >							
									<span class="glyphicon glyphicon-ok " aria-hidden="true"></span>
								</div>
							<?php
								}
							?>
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
						<div id="<?php echo 'm'.$row['mid']?>" class="messageSent col-md-6 col-md-offset-6">
							<div class="messageVideo"> 
								<video width="320px" height="240px" controls>
									<source src="../src/uploads/<?php echo $row['content']?>" type="video/mp4">
										Your browser does not support the video tag.
								</video> 
								<br/>
							</div>
							
							<div class="col-md-2 starContainer" >
								<button id="<?php echo 's'.$row['mid'];?>" class="glyphicon glyphicon-star-empty  btn btn-xs" onclick="setStarred('<?php echo 'm'.$row['mid'];?>','<?php echo 's'.$row['mid'];?>');" aria-label="star">	
								</button>
							</div>

							<div class="col-md-7 col-md-offset-1" >
								<span class="time"><?php echo periodElapsed(strtotime($row['timestamp']));?></span>
							</div>
							<?php 
								if($row['status'] == "tt")
								{	
							?>
								<div class="col-md-1 " >
									<span class="fa-stack fa-xs " style="color:#33aaff">
										<i class="fa fa-check fa-stack-1x" style="margin-left:4px"></i>
										<i class="fa fa-check fa-inverse fa-stack-1x" style="margin-left:-3px;"></i>
										<i class="fa fa-check fa-stack-1x" style="margin-left:-4px"></i>
									</span>		
								</div>
							<?php
								}
								else
								{
							?>
								<div class="col-md-1 " >							
									<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								</div>
							<?php
								}
							?>
						
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
						<div id="<?php echo 'm'.$row['mid']?>" class="messageSent col-md-6 col-md-offset-6">
							<div class="messageImage" >
								<img src="../src/uploads/<?php echo $row['content'];?> " width="300px" />
								<br/>
							</div>
							
							<div class="col-md-2 starContainer" >
								<button id="<?php echo 's'.$row['mid'];?>" class="glyphicon glyphicon-star-empty  btn btn-xs" onclick="setStarred('<?php echo 'm'.$row['mid'];?>','<?php echo 's'.$row['mid'];?>');" aria-label="star">	
								</button>
							</div>

							<div class="col-md-7 col-md-offset-1" >
								<span class="time"><?php echo periodElapsed(strtotime($row['timestamp']));?></span>
							</div>
							<?php 
								if($row['status'] == "t")
								{	
							?>
								<div class="col-md-1 " >
									<span class="fa-stack fa-xs" style="color:#33aaff">
										<i class="fa fa-check fa-stack-1x" style="margin-left:4px"></i>
										<i class="fa fa-check fa-inverse fa-stack-1x" style="margin-left:-3px;"></i>
										<i class="fa fa-check fa-stack-1x" style="margin-left:-4px"></i>
									</span>		
								</div>
							<?php
								}
								else
								{
							?>
								<div class="col-md-1 " >							
									<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								</div>
							<?php
								}
							?>
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
						<div id="<?php echo 'm'.$row['mid']?>" class="messageSent col-md-6 col-md-offset-6">
							<div class="messagePdf">
								<a href="../src/uploads/<?php echo $row['content'];?>" target='_blank'><?php $pos = strpos($row['content'],"/"); echo substr($row['content'],$pos+1);?></a>
							<br/>
							</div>
							
							<div class="col-md-2 starContainer" >
								<button id="<?php echo 's'.$row['mid'];?>" class="glyphicon glyphicon-star-empty  btn btn-xs" onclick="setStarred('<?php echo 'm'.$row['mid'];?>','<?php echo 's'.$row['mid'];?>');" aria-label="star">	
								</button>
							</div>

							<div class="col-md-7 col-md-offset-1" >
								<span class="time"><?php echo periodElapsed(strtotime($row['timestamp']));?></span>
							</div>
							<?php 
								if($row['status'] == "t")
								{	
							?>
								<div class="col-md-1 " >
									<span class="fa-stack fa-xs" style="color:#33aaff">
										<i class="fa fa-check fa-stack-1x" style="margin-left:4px"></i>
										<i class="fa fa-check fa-inverse fa-stack-1x" style="margin-left:-3px;"></i>
										<i class="fa fa-check fa-stack-1x" style="margin-left:-4px"></i>
									</span>		
								</div>
							<?php
								}
								else
								{
							?>
								<div class="col-md-1 " >							
									<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								</div>
							<?php
								}
							?>							
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
						<div id="<?php echo 'm'.$row['mid']?>" class="messageRecieved ">
							<div class="messageText"><?php echo $row['content'];?><br/></div>	
							
							<div class="col-md-2 starContainer" >
								<button id="<?php echo 's'.$row['mid'];?>" class="glyphicon glyphicon-star-empty  btn btn-xs" onclick="setStarred('<?php echo 'm'.$row['mid'];?>','<?php echo 's'.$row['mid'];?>');" aria-label="star">	
								</button>
							</div>

							<div class="col-md-7 col-md-offset-1" >
								<span class="time"><?php echo periodElapsed(strtotime($row['timestamp']));?></span>
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
						<div id="<?php echo 'm'.$row['mid']?>" class="messageRecieved col-md-6">
							<div class="messageVideo"> 
								<video width="320px" height="240px" controls>
									<source src="../src/uploads/<?php echo $row['content'];?>" type="video/mp4">
										Your browser does not support the video tag.
								</video> 
								<br/>
							</div>
							
							<div class="col-md-2 starContainer" >
								<button id="<?php echo 's'.$row['mid'];?>" class="glyphicon glyphicon-star-empty  btn btn-xs" onclick="setStarred('<?php echo 'm'.$row['mid'];?>','<?php echo 's'.$row['mid'];?>');" aria-label="star">	
								</button>
							</div>

							<div class="col-md-7 col-md-offset-1" >
								<span class="time"><?php echo periodElapsed(strtotime($row['timestamp']));?></span>
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
						<div id="<?php echo 'm'.$row['mid']?>" class="messageRecieved col-md-5">
							<div class="messageImage">
								<img src="../src/uploads/<?php echo $row['content'];?> " width="300px"/>
								<br/>
							</div>
								
							<div class="col-md-2 starContainer" >
								<button id="<?php echo 's'.$row['mid'];?>" class="glyphicon glyphicon-star-empty  btn btn-xs" onclick="setStarred('<?php echo 'm'.$row['mid'];?>','<?php echo 's'.$row['mid'];?>');" aria-label="star">	
								</button>
							</div>

							<div class="col-md-7 col-md-offset-1" >
								<span class="time"><?php echo periodElapsed(strtotime($row['timestamp']));?></span>
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
						<div id="<?php echo 'm'.$row['mid']?>" class="messageRecieved	col-md-6">
							<div class="messagePdf">
								<a href="../src/uploads/<?php echo $row['content'];?>" target='_blank'><?php $pos = strpos($row['content'],"/"); echo substr($row['content'],$pos+1);?></a>
								<br/>
							</div>
								
							<div class="col-md-2 starContainer" >
								<button id="<?php echo 's'.$row['mid'];?>" class="glyphicon glyphicon-star-empty  btn btn-xs" onclick="setStarred('<?php echo 'm'.$row['mid'];?>','<?php echo 's'.$row['mid'];?>');" aria-label="star">	
								</button>
							</div>

							<div class="col-md-7 col-md-offset-1" >
								<span class="time"><?php echo periodElapsed(strtotime($row['timestamp']));?></span>
							</div>
							
						</div>
					</div>
				</div>
				<?php
			}
			
		}
	}
		
?>