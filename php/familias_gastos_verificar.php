<?php
    session_start();

	include('../models/FamiliasGastos.php');

    $clave = $_REQUEST['clave'];
    
    $modeloFamiliasGastos = new FamiliasGastos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFamiliasGastos->verificarFamiliasGastos($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>