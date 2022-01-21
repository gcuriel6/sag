<?php

	function num_2dec($numero)
	{
		return number_format($numero, 2, '.', '');
	}

    $tipo = $_REQUEST['tipo'];
    if($tipo == 1)
    {

    	$cantidad = $_REQUEST['cantidad'];
    	$precio = num_2dec($_REQUEST['precio']);
    	$importe = number_format((float)($cantidad * $precio),2,'.','');
    	echo $importe;

    }

	if($tipo == 2)
    {

    	$cantidad = $_REQUEST['cantidad'];
    	$precio = num_2dec($_REQUEST['precio']);
		$tipoCambio = num_2dec($_REQUEST['tipo_cambio']);

    	$importe = number_format((float)(($cantidad * $precio)*$tipoCambio),2,'.','');
    	echo $importe;

    }

	if($tipo == 3)
    {
    	$precio = num_2dec($_REQUEST['precio']);
		$tipoCambio = num_2dec($_REQUEST['tipo_cambio']);

    	$importe = number_format((float)($precio*$tipoCambio),2,'.','');
    	echo $importe;

    }

?>