<?php
    session_start();

	include('../widgets/AyudaModal.php');

    $pantalla = $_REQUEST['pantalla'];
    $boton = $_REQUEST['boton'];
    
    $modeloAyudaModal = new AyudaModal();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAyudaModal->buscarTextoAyudaForma($pantalla,$boton);
    }else{
        echo json_encode("sesion");
    }
 	
?>