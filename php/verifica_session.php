<?php
session_start();

if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] != ''){
	$_SESSION["timeout"] = time();
	echo 1;
}else{
    session_destroy();
	echo 0;
}

?>