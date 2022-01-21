<?php

    session_start();
	include('../models/Requisiciones.php');
    include('../models/Tallas.php');

	$idRequisicion = $_REQUEST['id'];
    $modeloRequisiciones = new Requisiciones();
    $modeloTallas = new Tallas();
    $detallesA = array();
    if (isset($_SESSION['usuario']))
    {

        $detalles = json_decode($modeloRequisiciones->buscarDetallesRequisiciones($idRequisicion), true);
        foreach($detalles as $detalle)
        {
            array_push($detallesA, [
                'id'=>$detalle['id'],
                'id_producto'=>$detalle['id_producto'],
                'id_linea'=>$detalle['id_linea'],
                'id_familia'=>$detalle['id_familia'],
                'cantidad'=>$detalle['cantidad'],
                'descripcion'=>$detalle['descripcion'],
                'costo_unitario'=>$detalle['costo_unitario' ],
                'porcentaje_iva'=>$detalle['porcentaje_iva'],
                'justificacion'=>$detalle['justificacion'],
                'total'=>$detalle['total'],
                'excede_presupuesto'=>$detalle['excede_presupuesto'],
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