<?php
    session_start();
	include('../models/Autorizar.php');

    $id = $_REQUEST['id'];
    $estatus = $_REQUEST['estatus'];

    $modeloAutorizar = new Autorizar();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizar->guardarAutorizar($id,$estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>