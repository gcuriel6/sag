<?php

session_start();

include('../models/Requisiciones.php');
$idRequisicion = $_REQUEST['id'];
$modelRequisiciones = new Requisiciones();

if (isset($_SESSION['usuario']))
      echo $modelRequisiciones->cancelarRequisicion($idRequisicion);
else
    echo json_encode('login');
 	

?>