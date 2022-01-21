<?php
    session_start();

	include('../models/Departamentos.php');

    $clave = $_REQUEST['clave'];
    
    $modeloDepartamentos = new Departamentos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloDepartamentos->verificarDepartamentos($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>