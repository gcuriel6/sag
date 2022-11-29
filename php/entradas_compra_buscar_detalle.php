<?php

    session_start();
	include('../models/EntradasCompra.php');
    include('../models/Tallas.php');

	$idEntradaCompra = $_REQUEST['idEntradaCompra'];
    $modeloEntradasCompra = new EntradasCompra();
    $modeloTallas = new Tallas();
    $detallesA = array();
    if (isset($_SESSION['usuario']))
    {

        $detalles = json_decode($modeloEntradasCompra->buscarDetallesEntradaCompra($idEntradaCompra), true);
        foreach($detalles as $detalle)
        {
            array_push($detallesA, [
                'id'=>$detalle['id'],
                'id_oc_d'=>$detalle['id_oc_d'],
                'id_producto'=>$detalle['id_producto'],
                'cantidad'=>$detalle['cantidad'],
                'cantidad_oc'=>$detalle['cantidad_oc'],
                'iva'=>$detalle['iva'],
                'precio'=>$detalle['precio'],
                'precio_oc'=>$detalle['precio_oc'],
                'partida'=>$detalle['partida'],
                'concepto'=>$detalle['concepto'],
                'linea'=>$detalle['linea'],
                'familia'=>$detalle['familia'],  
                'verifica_talla'=>$detalle['lleva_talla'],  
                'descuento'=>$detalle['descuento'],
                'isr'=>$detalle['isr'],
                'tallas_solicitadas'=>$modeloTallas->obtenerTallasDetalle($detalle['id_oc_d'], 2),
                'tallas'=>$modeloTallas->obtenerTallasDetalle($detalle['id'], 3)
            ]);
        }

        echo json_encode($detallesA);

    }
    else
        echo json_encode("sesion");
 	
?>