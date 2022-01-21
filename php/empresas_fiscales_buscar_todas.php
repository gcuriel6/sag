<?php
    session_start();
	include('../models/EmpresasFiscales.php');

    $modeloEmpresasFiscales = new EmpresasFiscales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloEmpresasFiscales->buscaEmpresasFiscalesTodas();
    }else{
        echo json_encode("sesion");
    }
 	
?>