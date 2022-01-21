<?php

    session_start();
	include('../models/OrdenCompra.php');
    include('../models/Tallas.php');

	$idOrdenCompra = $_REQUEST['id'];
    $modeloOrdenCompra = new OrdenCompra();
    $modeloTallas = new Tallas();
    $detallesA = array();
    if (isset($_SESSION['usuario']))
    {

        $detalles = json_decode($modeloOrdenCompra->buscarDetallesOrdenCompraTallas($idOrdenCompra), true);
        foreach($detalles as $detalle)
        {
            array_push($detallesA, [
                'id'=>$detalle['id'],
                'id_producto'=>$detalle['id_producto'];
                'cantidad'=>$detalle['cantidad'],
                'concepto'=>$detalle['concepto'],
                'costo_unitario'=>$detalle['costo_unitario' ],
                'concepto'=>$detalle['concepto'],
                'linea'=>$detalle['linea'],
                'familia'=>$detalle['familia'],  
                'verifica_talla'=>$detalle['verifica_talla'],  
                'tallas'=>$modeloTallas->obtenerTallasDetalle($detalle['id'], 1)
            ]);
        }

        echo json_encode($detallesA);

    }
    else
        echo json_encode("sesion");
 	
?>