<?php
    session_start();

	include('../models/UnidadesNegocio.php');

    $clave = $_REQUEST['clave'];
    
    $modeloUnidadNegocio = new UnidadesNegocio();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUnidadNegocio->verificarUnidadesNegocio($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>