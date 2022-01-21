<?php
    session_start();
	include('../models/Requisiciones.php');

    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
	$idUnidad = isset($_REQUEST['id_unidad']) ? $_REQUEST['id_unidad'] : null;
    $fechaDe = isset($_REQUEST['fecha_de']) ? $_REQUEST['fecha_de'] : null;
    $fechaA = isset($_REQUEST['fecha_a']) ? $_REQUEST['fecha_a'] : null;

    $modeloRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario']))
          echo $modeloRequisiciones->buscarRequisicionesTodas($id, $idUnidad, $fechaDe, $fechaA);
    else
        echo json_encode("sesion");
 	
?>
<?php
/*
session_start();

include('../models/Requisiciones.php');


$requisicionA = [];
$requisicionD = [];

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
$partidas = $_REQUEST['partidas'];

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
        'tallas'=>$t
	]);

}

$modelRequisiciones = new Requisiciones();

if (isset($_SESSION['usuario']))
      echo $modelRequisiciones->guardarRequisicion($requisicionA, $requisicionD);
else
    echo json_encode('login');
 	*/

?>