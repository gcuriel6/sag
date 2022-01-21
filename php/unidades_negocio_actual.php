<?php
	ini_set("session.cookie_lifetime","0");
	ini_set("session.gc_maxlifetime","172800");
	session_start();
	
	include 'conectar.php';
    $link = Conectarse();
    
    $_SESSION['id_unidad_actual']=$_REQUEST['id_unidad'];
	unset($_SESSION["menuCargado"]);
    echo 1;

?>