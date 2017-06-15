<?php

	include "getConnection.php";
	
	class Profile{

		var $dbconn;
		var $field;
		
		public function __construct($id)
		{
			$this->dbconn = getConnection();
			$this->field = array("uid"=>$id);
		}
		
		public function __destruct()
		{
			//pg_close($this->dbconn);
		}
		
		public function setStatus($status)
		{
			$data = array("status"=>$status);
			if(pg_update($this->dbconn,'users',$data,$this->field))
				return true;
			else 
				return false;			
		}
				
		public function getProfilePicById($id)
		{
			$field2 = array("uid"=>$id);
			if($result = pg_select($this->dbconn,"users",$field2))
			{
				return $result[0]['picture'];
			}
			else 
				return '-1.jpg';
		}
		
		public function changeProfilePic($userpic)
		{
			$data = array("picture"=>$userpic);
			if(pg_update($this->dbconn,"users",$data,$this->field))
				return true;
			else
				return false;
		}
		
		public function getNameById($id)
		{
			$field2 = array("uid"=>$id);
			if($result = pg_select($this->dbconn,"users",$field2))
			{
				return $result[0]['username'];
			}
			else 
				return 'Name';
		}
		
		public function getStatusById($id)
		{
			$field2 = array("uid"=>$id);
			if($result = pg_select($this->dbconn,"users",$field2))
			{
				return $result[0]['status'];
			}
			else 
				return 'Status';
		}
		
		public function changePassword($newPassword)
		{
			$data = array("pass"=>$newPassword);

			if(pg_update($this->dbconn,"users",$data,$this->field))
			{
				return true;
			}
			else {
				return false;
			}
		}

		public function getPassword($id)
		{
			$query = "SELECT pass FROM users WHERE uid = $id";
			$result = pg_query($this->dbconn,$query);
			if($result)
			{
				return $result;
			}
			else {
				return false;
			}
		}
		
	}

	class Query{

		var $dbconn;
		var $field;

		public function __construct($id)
		{
			$this->dbconn = getConnection();
			$this->field = array("uid"=>$id);
		}

		public function __destruct()
		{
			pg_close($this->dbconn);
		}
		
		public function search($name)
		{
			$profile = new Profile($this->field['uid']);
			
			$query = "select * from users where username ~* '(^| )".$name."' and username != '".$profile->getNameById($this->field['uid'])."' limit 5;";
			
			$result = pg_query($this->dbconn,$query);
			
			return $result;
		}
		
		public function sendRequest($receiverId)
		{
			$query = "insert into requests (senderid,receiverid) values (".$this->field['uid'].",".$receiverId.");";
			$result = pg_query($this->dbconn,$query);
			
			return $result;
		}
		
		public function getRequests($receiverId)
		{
			$query = "select * from requests where receiverid = ".$receiverId." order by requestno desc;";
			$result = pg_query($this->dbconn,$query);
			
			return $result;
		}
		
		public function acceptRequest($requestNo,$senderId,$receiverId)
		{
			$query1 = "update users set friends = friends || '{".$senderId."}' where uid = ".$receiverId.";";
			$query2 = "update users set friends = friends || '{".$receiverId."}' where uid = ".$senderId.";";
			$query3 = "delete from requests where requestno = ".$requestNo.";";
			$result = pg_query($this->dbconn,$query1);
			$result = pg_query($this->dbconn,$query2);
			$result = pg_query($this->dbconn,$query3);
			
		}
		
		public function declineRequest($requestNo)
		{
			$query = "delete from requests where requestno = ".$requestNo.";";
			$result = pg_query($this->dbconn,$query);
		}
		
		public function checkFriend($id)
		{
			$query = "select uid from users where friends @> '{".$id."}' and uid = ".$this->field['uid'].";";
			
			$result = pg_query($this->dbconn,$query);
						
			return $result;
			
		}
		public function checkOnline($id)
		{
			$fields2 = array("uid"=>$id);
			if($result = pg_select($this->dbconn,"users",$fields2))
			{
				return $result[0]['logintime'];
			}
			else
				return '-1';
		}

		public function putOnline()
		{
			$data = array("logintime"=>"");
			if(pg_update($this->dbconn,'users',$data,$this->field))
				return true;
			else
				return false;
		}


		public function putOffline($id)
		{
			$query = "update users set logintime = now() where uid = ".$id;
				if(pg_query($this->dbconn,$query))
					return true;
				else
					return false;
		}

		public function getConversationId($id1,$id2)
		{	
			if($id1 < $id2)
			{
				$data = array('user1' =>$id1 ,'user2' =>$id2 );
			}
			else
			{
				$data = array('user1' =>$id2 ,'user2' =>$id1 );
			}
			if($result = pg_select($this->dbconn,'conversation',$data))
			{}
				
			else
			{
				$res=pg_insert($this->dbconn,'conversation',$data);	
				$result = pg_select($this->dbconn,'conversation',$data);
			}
			return $result[0]['cid'];
		}

		public function sendMessage($cid,$content,$filetype,$isIncognito)
		{
			$query = "insert into messages (content,cid,senderid,filetype,timestamp,isincognito) values('".$content."',".$cid.",".$_SESSION['id'].",'".$filetype."',now(),".$isIncognito.");";
						
			if($result = pg_query($this->dbconn,$query))
					return true;
				else
					return 	false;
		}
		
		public function setSeen($cid,$senderid)
		{
			$data = array("status"=>true);
			$checkfields = array("cid" =>$cid,"senderid"=>$senderid,"status"=>false);
			if(pg_update($this->dbconn,'messages',$data,$checkfields))
				return true;
			else
				return false;
		}
		
		public function getMessageHistory($cid)
		{
			$query = "select * from messages where cid=".$cid." order by mid asc";
			$result = pg_query($this->dbconn,$query);
			
			return $result;
		}
		
		public function getMessages($cid,$count)
		{
			$query = "select * from messages where cid = ".$cid." order by mid asc offset ".$count.";";
			$result = pg_query($this->dbconn,$query);
			
			return $result;
		}
		
		public function deleteChatHistory($cid)
		{
			$query = "delete from messages where cid =".$cid." ;";
			pg_query($this->dbconn,$query);
			
		}
		
		public function setStarred($mid,$ownerid)
		{
			$result = "";
			$query = "insert into messagestarred (content,senderid,timestamp,filetype,ownerid,mid) select content,senderid,timestamp,filetype,'".$ownerid."',mid from messages where mid=".$mid;
			if($result = pg_query($this->dbconn,$query))
				return "true";
			else 
				return "false";
		}
		
		public function getStarredMessages($ownerid)
		{
			$query = "select * from messagestarred where ownerid = ".$ownerid." order by msid desc;";
			$result = pg_query($this->dbconn,$query);
			
			return $result;
		}
		
		public function removeStarred($msid)
		{
			$query = "delete from messagestarred where msid = ".$msid." ;";
			pg_query($this->dbconn,$query);
			
		}
		
		public function deleteIncognitoChat($id)
		{
			$query = "delete from messages where isincognito = true and senderid = ".$id." ;";
			$result = pg_query($this->dbconn,$query);
		}
		
		public function showHistory($id)
		{
			$query = "SELECT cid from (SELECT b.cid,msgid FROM (select cid,max(mid) as msgid from messages where cid in (select cid from conversation where (user1=$id or user2=$id)) GROUP BY cid) AS b JOIN conversation AS c ON b.cid = c.cid ORDER BY b.msgid DESC ) as arr;";
			$result = pg_query($this->dbconn,$query);
			if($result)
				return $result;
			else
				return false;
		}
		public function getInfoOfUid($id)
		{
			$query = "SELECT username,status,picture FROM users WHERE uid = ".$id;
			if($result = pg_query($this->dbconn,$query))
			{
				return $result;
			}
			else 
			{
				return false;
			}
		}
		public function getOtherUserId($result)
		{
			$query = "SELECT user1,user2 FROM conversation WHERE cid = ".$result.";";
			if($output = pg_query($this->dbconn,$query))
			{
				return $output;
			}
			else 
			{
				return false;
			}
		}
		
		
	}
