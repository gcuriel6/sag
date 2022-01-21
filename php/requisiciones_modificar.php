<?php

session_start();

include('../models/Requisiciones.php');

$requisicionA = [];
$requisicionD = [];

$requisicionA['id'] = $_REQUEST['id'];
$requisicionA['folio'] = $_REQUEST['folio'];
$requisicionA['id_unidad'] = $_REQUEST['id_unidad'];
$requisicionA['id_sucursal']= $_REQUEST['id_sucursal'];
$requisicionA['id_area'] = $_REQUEST['id_area'];
$requisicionA['id_depto'] = $_REQUEST['id_depto'];
$requisicionA['id_proveedor'] = $_REQUEST['id_proveedor'];
$requisicionA['fecha_pedido'] = $_REQUEST['fecha_pedido'];
$requisicionA['solicito'] = $_REQUEST['solicito'];
$requisicionA['dias_entrega'] = $_REQUEST['dias_entrega'];
$requisicionA['id_usuario'] = $_REQUEST['id_usuario'];
$requisicionA['usuario'] = $_REQUEST['usuario'];
$requisicionA['descripcion'] = $_REQUEST['descripcion'];
$requisicionA['tipo'] = $_REQUEST['tipo'];
$requisicionA['subtotal'] = $_REQUEST['subtotal'];
$requisicionA['iva'] = $_REQUEST['iva'];
$requisicionA['total'] = $_REQUEST['total'];
$requisicionA['excedePresupuesto'] = $_REQUEST['excedePresupuesto'];
$requisicionA['id_familia_gasto'] = $_REQUEST['id_familia_gasto'];
//-->NJES Jan/27/2020 se agregan parametros para anticipo de la requisición
$requisicionA['anticipo'] = $_REQUEST['anticipo'];
$requisicionA['monto_anticipo'] = $_REQUEST['monto_anticipo'];
$requisicionA['id_activo_fijo'] = $_REQUEST['id_activo_fijo'];

//-->NJES July/30/2020 bandera si es diferentes familias gastos
$requisicionA['diferentesFamilias'] = isset($_REQUEST['diferentesFamilias']) ? $_REQUEST['diferentesFamilias'] : 0;

/**MGFS 05-11-2019 SE AGREGAN DATOS PARA LAS REQUISICIONES DE MANTENIMIENTO */
$requisicionA['mantenimiento'] = isset($_REQUEST['mantenimiento']) ? $_REQUEST['mantenimiento'] : 0;
$requisicionA['folioMantenimiento'] = isset($_REQUEST['folioMantenimiento']) ? $_REQUEST['mantenimiento'] : 0;
$requisicionA['noEconomico'] = isset($_REQUEST['noEconomico']) ? $_REQUEST['noEconomico'] : '';
$requisicionA['responsable'] = isset($_REQUEST['responsable']) ? $_REQUEST['responsable'] : '';
$requisicionA['kilometraje'] = isset($_REQUEST['kilometraje']) ? $_REQUEST['kilometraje'] : 0;

//-->NJES October/28/2020 se agrega descuento por partida, el costo unitario de cada partida ya incluye el descuento
//y en base de datos se agregan dos campo en requisiciones_d (descuento_unitario y descuento_total)
//si se quiere saber el costo orif¿ginal solo se suma el costo_unitario + descuento_unitario
//en el encabezado en requisiciones se guarda el total de descuento de las partidas
$requisicionA['descuento'] = isset($_REQUEST['descuento_total']) ? $_REQUEST['descuento_total'] : 0;

$partidas = $_REQUEST['partidas'];

$requisicionA['estatusActualR'] = isset($_REQUEST['estatusActualR']) ? $_REQUEST['estatusActualR'] : '';

foreach($partidas as $partida)
{

	$t = '';
	if($partida['tallas'] != '')
		$t .= $partida['tallas'];

	array_push($requisicionD, [
		'n_partida'=>$partida['n_partida'],
        'id_producto'=>$partida['id_producto'], 
        'concepto'=>$partida['concepto'],
        'id_familia'=>$partida['id_familia'],
        'familia'=>$partida['familia'],
        'id_linea'=>$partida['id_linea'],
        'linea'=>$partida['linea'],
        'precio'=>$partida['precio'],
        'cantidad'=>$partida['cantidad'], 
        'costo'=>$partida['costo'],
        'descripcion'=>$partida['descripcion'],
        'justificacion'=>$partida['justificacion'],
        'iva'=>$partida['iva'],
        'excedePD'=>$partida['excedePD'],
        'tallas'=>$t,
        'descuento'=>$partida['descuento'],
        'descuento_total'=>$partida['descuento_total']
	]);

}

$modelRequisiciones = new Requisiciones();

if (isset($_SESSION['usuario']))
      echo $modelRequisiciones->modificarRequisicion($requisicionA, $requisicionD);
else
    echo ("NO");
 	

?>