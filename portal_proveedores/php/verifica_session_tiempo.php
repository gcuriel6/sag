<?php
session_start();

$inactividad = 900;
if(isset($_SESSION["usuarioP"]) && $_SESSION["usuarioP"] != ''){
	// Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	$sessionTTL = time() - $_SESSION["timeout"];
	
	if($sessionTTL > $inactividad){
		session_destroy();
		echo 0;
	}else{
		echo 1;
	}
}else{
	echo 0;
}

?>