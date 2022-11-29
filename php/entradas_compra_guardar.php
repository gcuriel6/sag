<?php
session_start();
include('../models/EntradasCompra.php');


$entradaA = [];
$entradaD = [];

$entradaA['idUnidadNegocio'] = $_REQUEST['idUnidadNegocio'];
$entradaA['idSucursal']= $_REQUEST['idSucursal'];
$entradaA['idProveedor'] = $_REQUEST['idProveedor'];
$entradaA['idUsuario'] = $_REQUEST['idUsuario'];
$entradaA['idOrden'] = $_REQUEST['idOrden'];
$entradaA['usuario'] = $_REQUEST['usuario'];
$entradaA['tipoMov'] = $_REQUEST['tipoMov'];
$entradaA['cveConcepto'] = $_REQUEST['cveConcepto'];
$entradaA['noPartidas'] = $_REQUEST['noPartidas'];
$entradaA['noEconomico'] = $_REQUEST['noEconomico'];
$entradaA['servicio'] = $_REQUEST['servicio'];
$entradaA['tipoOC'] = $_REQUEST['tipoOC'];
//-->NJES Feb/13/2020 se reciben id de area y departamento para afectar presupuesto cuando sea una entrada de tipo mantenimiento
$entradaA['idArea'] = $_REQUEST['idArea'];
$entradaA['idDepartamento'] = $_REQUEST['idDepartamento'];
$entradaA['importe'] = $_REQUEST['importe'];
$entradaA['foliosRequis'] = $_REQUEST['foliosRequis'];
$entradaA['idsRequis'] = $_REQUEST['idsRequis'];
$entradaA['montoIsr'] = $_REQUEST['montoIsr'];

$partidas = $_REQUEST['partidas'];

$verificando = '';
foreach($partidas as $partida)
{
	$t = '';
	if($partida['tallas'] != '')
		$t .= $partida['tallas'];

	array_push($entradaD, [
        'nPartida'=>$partida['nPartida'],
        'idAlmacenD'=>$partida['idAlmacenD'],
        'idProducto'=>$partida['idProducto'], 
        'concepto'=>$partida['concepto'],
        'idOrden'=>$partida['idOrden'],
        'cantidad'=>$partida['cantidad'],
        'iva'=>$partida['iva'], 
        'descuento'=>$partida['descuento'],
        'costo'=>$partida['costo'],
        'llevaTallas'=>$partida['llevaTallas'],
        'tallas'=>$t,
        'id_familia_gasto'=>$partida['id_familia_gasto'],
        'importe'=>$partida['importe']
	]);

}

$modelEntradasCompra = new EntradasCompra();

if (isset($_SESSION['usuario'])){
   
      echo $resultado = $modelEntradasCompra->guardarEntradasCompra($entradaA, $entradaD);

}
else{
    echo "session";
}
    
 	

?>