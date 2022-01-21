<?php
    session_start();
	include('../models/OrdenCompra.php');
	include('../models/Tallas.php');

    $idOrdenCompra = $_REQUEST['idOrdenCompra'];
    
    $modeloOrdenCompra = new OrdenCompra();
   	$modeloTallas = new Tallas();

    $detallesA = array();
    if (isset($_SESSION['usuario']))
    {

        //echo $resultado = $modeloOrdenCompra->buscarOrdenCompraIdDetalle($idOrdenCompra);
        $detalles = json_decode($modeloOrdenCompra->buscarOrdenCompraIdDetalle($idOrdenCompra), true);
        foreach($detalles as $detalle)
        {
            array_push($detallesA, [
                'id'=>$detalle['id'],
                'idRequi'=>$detalle['idRequi'],
                'idRequiD'=>$detalle['idRequiD'],
                'id_producto'=>$detalle['id_producto'],
                'clave'=>$detalle['clave'],
                'cantidad'=>$detalle['cantidad'],
                'concepto'=>$detalle['concepto'],
                'cantidad'=>$detalle['cantidad'],
                'costo'=>$detalle['costo'],
                'iva'=>$detalle['iva'],
                'descuento'=>$detalle['descuento'],
                'descripcion'=>$detalle['descripcion'],
               	'importe'=>$detalle['importe'],
               	'id_linea'=>$detalle['id_linea'],
               	'id_familia'=>$detalle['id_familia'],
               	'linea'=>$detalle['linea'],
                'familia'=>$detalle['familia'],
                'folioRequi'=>$detalle['folioRequi'],
                'entregados'=>$detalle['entregados'],
                'estatus'=>$detalle['estatus'],
				'verifica_talla'=>$detalle['verifica_talla'],  
                'tallas_solicitadas'=>$modeloTallas->obtenerTallasDetalle($detalle['idRequiD'], 1),
                'tallas'=>$modeloTallas->obtenerTallasDetalle($detalle['id'], 2),
                'b_anticipo'=>$detalle['b_anticipo'],
                'descuento_requisicion'=>$detalle['descuento_total']
            ]);
        }

        echo json_encode($detallesA);
    }
    else
        echo json_encode("sesion");
 	
?>