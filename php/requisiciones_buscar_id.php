<?php
    session_start();
    include('../models/Requisiciones.php');
    
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
   

    $modeloRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario'])){

          echo $modeloRequisiciones->buscarRequisicionesId($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>