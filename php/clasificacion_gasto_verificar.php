<?php
    session_start();

	include('../models/ClasificacionGasto.php');

    $clave = $_REQUEST['clave'];
    
    $modeloClasificacionGasto = new ClasificacionGasto();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloClasificacionGasto->verificarClasificacionGasto($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>