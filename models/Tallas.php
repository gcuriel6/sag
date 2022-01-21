<?php

include_once('conectar.php');

class Tallas
{

    public $link;

    function Tallas()
    {
  
      $this->link = Conectarse();

    }

    function obtenerTallasDetalle($idDetalle, $tipo)
    {

    	$resultado = $this->link->query("SELECT * FROM tallas WHERE tipo = $tipo AND id_detalle = $idDetalle");
      	return query2json($resultado);

    }

    function obtenerListaTallas()
    {

    	$resultado = $this->link->query("SELECT DISTINCT(talla) AS talla FROM tallas ORDER BY talla ASC");
      	return query2json($resultado);

    }

}//--fin de class Tallas
    
?>