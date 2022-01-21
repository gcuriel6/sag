<?php
    session_start();
    include('../models/EmpresasFiscales.php');
    
    $rfc = $_REQUEST['rfc'];

    $modeloEmpresasFiscales = new EmpresasFiscales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloEmpresasFiscales->buscarEmpresasFiscalesDiferenteRFC($rfc);
    }else{
        echo json_encode("sesion");
    }
 	
?>