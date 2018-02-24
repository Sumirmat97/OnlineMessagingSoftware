<?php 

function getConnection()
{
	
		if($conn = pg_connect("host=localhost port=5432 dbname=DBMSproject user=postgres password=admin"))
			return $conn;
		else 
			return "Connection Failed";
	}

