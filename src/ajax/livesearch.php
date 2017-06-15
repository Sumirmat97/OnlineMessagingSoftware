<?php

	include "../query.php";
	
	session_start();
	
	$query = new Query($_SESSION['id']);
	
	$name = trim($_GET['q']);
	$name = pg_escape_string($name);
	if($name)
	{
		$result = $query->search($name);
	
		while($row = pg_fetch_array($result))
		{
			
			?>
			<div class="row pastChats" id="<?php echo 'u'.$row['uid'];?>" onclick="showChat(this.id);clearSearchBar();" >
				<div class="col-md-4 ">
					<img class="img-circle" src="../src/profilePics/<?php echo $row['picture']; ?>" width="43px">
				</div>
				<div class="col-md-8" style="padding:0.8em;">
					<?php echo $row['username'];?>

				</div>
			</div>
			<?php
		}
	}
?>
