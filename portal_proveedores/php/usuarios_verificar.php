<?php
    session_start();

	include('../models/Usuarios.php');

    $rfc = $_REQUEST['rfc'];
    $folioOc = $_REQUEST['folioOc'];
    $folioE01 = $_REQUEST['folioE01'];
    $cveUnidad = $_REQUEST['cveUnidad'];
    
    $modeloUsuarios = new Usuarios();
    
    echo $resultado = $modeloUsuarios->verificarUsuarios($rfc,$folioE01,$folioOc,$cveUnidad);
    
 	
?>