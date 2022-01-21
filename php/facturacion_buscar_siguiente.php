<?php

session_start();
include('../models/Facturacion.php');


$modelFacturacion = new Facturacion();

if (isset($_SESSION['usuario']))
{

    $resultado = $modelFacturacion->obtenerFacturasSemana();
    
	$facturas = array();
    foreach($resultado as $r)
    {
        $r['fecha_facturar'] =  $modelFacturacion->buscarDiasSiguiente($r['periodicidad'], $r['dia']);
        $r['fecha_inicio_periodo'] =  $modelFacturacion->fechaInicioPeriodoFacturacion($r['periodicidad'], $r['dia']);
        $r['fecha_fin_periodo'] =  $modelFacturacion->fechaFinPeriodoFacturacion($r['periodicidad'], $r['dia'],$r['fecha_inicio_periodo']);
    	if($modelFacturacion->verificaFactura($r['id_contrato'], $r['fecha_facturar']) == 0 && $r['fecha_facturar'] != "")
    		array_push($facturas, $r);

    }

    echo json_encode($facturas);

}
else
    echo json_encode("sesion");
 	
?>