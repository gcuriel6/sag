<?php
session_start();
include("../models/PresupuestoIngresos.php");
//include("../models/PresupuestoEgresosBitacora.php");
$link = Conectarse();

$modeloPresupuestoIngresos = new PresupuestoIngresos();


$modeloPresupuestoIngresos->link->begin_transaction();
$modeloPresupuestoIngresos->link->query("START TRANSACTION;");

$idUnidad = $_REQUEST['id_unidad'];
$idSucursal =$_REQUEST['id_sucursal'];
$anio = $_REQUEST['anio'];
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : 0;
$datos = $_REQUEST['datos'];
$idUsuario = $_REQUEST['idUsuario'];
$modulo = $_REQUEST['modulo'];

if (isset($_SESSION['usuario'])){

      $result = $modeloPresupuestoIngresos -> guardarPresupuesto($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo);
     

      if($result > 0 )
      {
     
        $modeloPresupuestoIngresos->link->query("COMMIT;");
        echo $result;
        
      }else{
     
        $modeloPresupuestoIngresos->link->query("ROLLBACK;");
        echo 0;
      }
}else{
    echo json_encode("sesion");
}	
?>