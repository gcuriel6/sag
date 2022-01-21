 <?php

    session_start();
    include('../models/Facturacion.php');
    
    $id = $_REQUEST['id'];
    $idCFDI = $_REQUEST['id_cfdi'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario']))
        echo $modeloFacturacion->actualizarDatosCFDI($id,$idCFDI);
    else
        echo "sesion";

?>