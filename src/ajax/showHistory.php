<?php

include "../query.php";
session_start();
$query = new Query($_SESSION['id']);

$result = $query->showHistory($_SESSION['id']);
if($result)
{
  while($row = pg_fetch_assoc($result)){
    $x=$row['cid'];//the array of cid
    $r = $query->getOtherUserId($x);
    $userfetch = pg_fetch_assoc($r);
    if($userfetch['user1'] == $_SESSION['id'])
    {
      $otheruserid = $userfetch['user2'];
    }
    else {
      $otheruserid = $userfetch['user1'];
    }
    $info = $query->getInfoOfUid($otheruserid);
    $information = pg_fetch_assoc($info);
    ?>
    <div class="row pastChats" id="<?php echo 'u'.$otheruserid;?>" onclick="showChat(this.id);">

      <div class="col-md-4 ">
        <img class="img-circle" src="../src/profilePics/<?php echo $information['picture'];?>" width="60px">
      </div>
      <div class="col-md-8" style="padding:0.8em;">
        <div class="row" ><?php echo $information['username']; ?>
        </div>
        <div class="row" style="font-size:1em;"><?php echo $information['status']; ?>
        </div>
      </div>
    </div>

<?php
  }
}
 ?>
