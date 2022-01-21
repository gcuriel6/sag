<?php
	include 'conectar.php';
	$link = Conectarse();

    $pedidoD = $_REQUEST['pedidoD'];

	$condicion='';
	if($pedidoD!=''){
		$condicion="WHERE id_pedido_d='$pedidoD'";
	}

	$resultado = $link->query("SELECT id,imagen FROM pedidos_imagenes $condicion ORDER BY id");

	echo query2json($resultado);
	
?>