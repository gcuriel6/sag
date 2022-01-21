<?php
    session_start();
	  include('../models/Activos.php');

    //-->NJES Feb/12/2020 se reciben los parametros en array para no enviar tantas variables
     $datos = $_REQUEST['datos'];

    $modeloActivos = new Activos();
    if (isset($_SESSION['usuario'])){

      echo $resultado = $modeloActivos->guardarResponsable($datos);
    }else{
        echo json_encode("sesion");
    }

?>
