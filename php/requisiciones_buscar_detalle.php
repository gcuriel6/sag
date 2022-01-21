<?php
    session_start();
    include('../models/Requisiciones.php');
    include('../models/Tallas.php');

    $idRequisicion = $_REQUEST['idRequisicion'];

    $modeloRequisiciones = new Requisiciones();
    $modeloTallas = new Tallas();
    $detallesA = array();

    if (isset($_SESSION['usuario'])){

        $detalles = json_decode($modeloRequisiciones->buscarRequisicionDetalle($idRequisicion), true);
        foreach($detalles as $detalle)
        {
            array_push($detallesA, [
                'id'=>$detalle['id'],
                'id_producto'=>$detalle['id_producto'],
                'id_linea'=>$detalle['id_linea'],
                'id_familia'=>$detalle['id_familia'],
                'descripcion'=>$detalle['descripcion' ],
                'cantidad'=>$detalle['cantidad'],
                'clave'=>$detalle['clave'],
                'concepto'=>$detalle['concepto'], 
                'costo'=>$detalle['costo'], 
                'verifica_talla'=>$detalle['verifica_talla'], 
                'descuento'=>$detalle['descuento'],
                'iva'=>$detalle['iva'],
                'importe'=>$detalle['importe'],
                'linea'=>$detalle['linea'],
                'familia'=>$detalle['familia'],    
                'tallas_solicitadas'=>$modeloTallas->obtenerTallasDetalle($detalle['id'], 1)
            ]);
        }

        echo json_encode($detallesA);
    }else{
        echo json_encode("sesion");
    }
 	
?>