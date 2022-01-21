<?php
    session_start();
    include('../models/Pagos.php');
    
    $idPago = $_REQUEST['id_pago'];

    $modelPagos = new Pagos();
	
    if (isset($_SESSION['usuario']))
    {

        echo  $modelPagos->buscarPagosSinFacturaID($idPago);
    }
    else
        echo json_encode("sesion");
 	
?>