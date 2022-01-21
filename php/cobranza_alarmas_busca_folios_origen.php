<?php
    session_start();
	include('../models/CobranzaAlarmas.php');

    $idsCXC = $_REQUEST['idsCXC'];

    $modeloCobranza = new Cobranza();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCobranza->buscaFoliosOrigen($idsCXC);
    }else{
        echo json_encode("sesion");
    }
 	
?>