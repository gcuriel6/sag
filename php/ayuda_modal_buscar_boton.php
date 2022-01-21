<?php
    session_start();

	include('../widgets/AyudaModal.php');

    $pantalla = $_REQUEST['pantalla'];
    
    $modeloAyudaModal = new AyudaModal();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAyudaModal->buscarBotonAyudaForma($pantalla);
    }else{
        echo json_encode("sesion");
    }
 	
?>