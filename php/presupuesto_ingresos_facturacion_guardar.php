<?php
session_start();
include("../models/PresupuestoIngresosFacturacion.php");
//include("../models/PresupuestoEgresosBitacora.php");
$link = Conectarse();

$modeloPresupuestoIngresosFacturacion = new PresupuestoIngresosFacturacion();


$modeloPresupuestoIngresosFacturacion->link->begin_transaction();
$modeloPresupuestoIngresosFacturacion->link->query("START TRANSACTION;");

$idUnidad = $_REQUEST['id_unidad'];
$idSucursal =$_REQUEST['id_sucursal'];
$anio = $_REQUEST['anio'];
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : 0;
$datos = $_REQUEST['datos'];
$idUsuario = $_REQUEST['idUsuario'];
$modulo = $_REQUEST['modulo'];

if (isset($_SESSION['usuario'])){

      $result = $modeloPresupuestoIngresosFacturacion -> guardarPresupuesto($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo);
     

      if($result > 0 )
      {
     
        $modeloPresupuestoIngresosFacturacion->link->query("COMMIT;");
        echo $result;
        
      }else{
     
        $modeloPresupuestoIngresosFacturacion->link->query("ROLLBACK;");
        echo 0;
      }
}else{
    echo json_encode("sesion");
}	
?>