<?php

//razon  1064
//cfdi  16335

include('../models/Facturacion.php');
$facturacion = new Facturacion();
var_dump($facturacion->actualizarAdenda(100, 16335, 1064));

?>