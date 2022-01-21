<?php
    session_start();
    include('../models/OrdenCompra.php');
    include('../models/Tallas.php');

    $idOrdenCompra = $_REQUEST['idOrdenCompra'];
    
    $modeloOrdenCompra = new OrdenCompra();
    $modeloTallas = new Tallas();

    $detallesA = array();

    if (isset($_SESSION['usuario'])){

        $detalles = json_decode($modeloOrdenCompra->buscarOrdenCompraIdDetalleImportar($idOrdenCompra), true);
      
        foreach($detalles as $detalle)
        {
         
            array_push($detallesA, [
                'id'=>$detalle['id'],
                'id_producto'=>$detalle['id_producto'],
                'concepto'=>$detalle['concepto'],
                'costo'=>$detalle['costo'],
                'faltante'=>$detalle['faltante'],
                'linea'=>$detalle['linea'],
                'familia'=>$detalle['familia'],
                'iva'=>$detalle['iva'],
                'descuento'=>$detalle['descuento'],
                'importe'=>$detalle['importe'],
                'verifica_talla'=>$detalle['verifica_talla'],
                //-->NJES November/11/2020 buscar el id de la familia gasto
                'id_familia_gasto'=>$detalle['id_familia_gasto'],
                'tallas_solicitadas'=>$modeloTallas->obtenerTallasDetalle($detalle['id'], 2)
            ]);

        }
        echo json_encode($detallesA);
    }else{
        echo json_encode("sesion");
    }
?>