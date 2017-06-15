<?php

		function periodElapsed($timeInSec)
		{
			// function to compare date to present and print period elapsed
			$d=$timeInSec*1000;
			$now=date("U")*1000;
			$difference=$now-$d;
			//echo $difference."<br>";
			$result="";
			if($difference<1)
			{
				$result="error";
			}
			$divSet=[1000,60,60,24,7,4,12,1];
			$timeSet=["millisecond","sec","min","hour","day","week","month","year"];
			$info=0;
			$at=0;
			for($i=0;$i<sizeof($divSet);$i+=1)
			{
				if($difference%$divSet[$i]!=0)
				{
					$info= ($difference%$divSet[$i]);
					$at=$i;
				}else if($divSet[$i]==1&&$difference>=1)
				{
					$info=$difference%1000000000;
					$at=$i;
				}
				$difference/=$divSet[$i];
			}
			if($info!=1)
			{
				$result=($info." ".$timeSet[$at]."s ago");
			}
			else
			{
				switch($at)
				{
					case 0:
					case 1:
					case 2:
					case 3:
						$result=("a ".$timeSet[$at]." ago");
						break;
					case 4:
						$result=("yesterday");
						break;
					case 5:
					case 6:
					case 7:
						$result=("last ".$timeSet[$at]);
						break;
				}
			}
		return $result;
	}	
	
	