<?php
	include "getConnection.php";
	
	function register($fields)
	{
		$dbconn = getConnection();
		
		if($dbconn === "Connection Failed")
			$passErr = "Connection Failed";
		else
		{
			$checkfields = array('username'=>$fields['username']);
			if($resultSelect = pg_select($dbconn,'users',$checkfields))
				return false;
			else if(pg_insert($dbconn,'users',$fields))
			{
				$resultSelect = pg_select($dbconn,'users',$checkfields);
				print_r($resultSelect);
				if(mkdir("../src/uploads/".$resultSelect[0]['uid']))
					return true;
			}
				
		}
	}

