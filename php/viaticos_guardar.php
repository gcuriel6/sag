<?php
    session_start();
	include('../models/Viaticos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloViaticos = new Viaticos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloViaticos->guardarViaticos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>