<?php
    session_start();
    include('../models/Pagos.php');
    
    $id = $_REQUEST['id'];

    $modelPagos = new Pagos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modelPagos->eliminarPago($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>