 <?php
    // date_default_timezone_set('America/Chihuahua');
    // error_log("verificando sesion antes de");
    // error_log(json_encode($_SESSION));

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // error_log("verificando sesion despues de");
    // error_log(json_encode($_SESSION));
    
    include('../models/Facturacion.php');
    
    $id = $_REQUEST['id'];
    $idCFDI = $_REQUEST['id_cfdi'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario']))
        echo $modeloFacturacion->actualizarDatosCFDI($id,$idCFDI);
    else
        echo "sesion";

?>