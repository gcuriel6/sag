<?php

	function obtieneDate($link){
		$query = "SELECT CURDATE() as hoy";
		$result=mysqli_query($link,$query);
		$row = mysqli_fetch_array($result);
		
		return $row['hoy'];
	}
	
	function obtieneSOS($link){
		$query = "SELECT '2016-09-29' as hoy";
		$result=mysqli_query($link,$query);
		$row = mysqli_fetch_array($result);
		
		return $row['hoy'];
	}
	
	function obtieneNow($link){
		$query = "SELECT NOW() as ahora";
		$result=mysqli_query($link,$query);
		$row = mysqli_fetch_array($result);
		
		return $row['ahora'];
	}
	
	function obtieneTime($link){
		$query = "SELECT CURTIME() as ahora";
		$result=mysqli_query($link,$query);
		$row = mysqli_fetch_array($result);
		
		return $row['ahora'];
	}

?>