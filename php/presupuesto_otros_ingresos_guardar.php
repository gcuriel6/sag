<?php
session_start();
include("../models/PresupuestoOtrosIngresos.php");
include("../models/PresupuestoEgresosBitacora.php");
$link = Conectarse();

$modeloPresupuestoOtrosIngresos = new PresupuestoOtrosIngresos();
$modeloPresupuestoEgresosBitacora = new PresupuestoEgresosBitacora();

$modeloPresupuestoOtrosIngresos->link->begin_transaction();
$modeloPresupuestoOtrosIngresos->link->query("START TRANSACTION;");

$idRegistro = $_REQUEST['idRegistro'];
$idUnidad = $_REQUEST['id_unidad'];
$idSucursal = $_REQUEST['id_sucursal'];
$idArea = $_REQUEST['idArea'];
$idDepartamento = $_REQUEST['idDepartamento'];
$anio = $_REQUEST['anio'];
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : 0;
$otrosIngresos = $_REQUEST['otrosIngresos'];
$observaciones = $_REQUEST['observaciones'];
$total = $_REQUEST['total'];


if (isset($_SESSION['usuario'])){

      $result = $modeloPresupuestoOtrosIngresos -> guardarOtrosIngresos($idRegistro, $idUnidad, $idSucursal, $anio, $mes, $idDepartamento, $idArea, $otrosIngresos, $observaciones, $total);
     
      if($result > 0)
      {
         
        $camposModificados = $_REQUEST['camposModificados'];
        $idUsuario = $_REQUEST['idUsuario'];
        $modulo = $_REQUEST['modulo'];
        $idUnidadNegocio = $_REQUEST['id_unidad'];
        $idSucursal = $_REQUEST['id_sucursal'];

        $idRegistro = $result;
        

        $arr = array('camposModificados'=>$camposModificados,
                    'modulo'=>$modulo,
                    'idUnidadNegocio'=>$idUnidadNegocio,
                    'idSucursal'=>$idSucursal,
                    'idRegistro'=>$idRegistro,
                    'idUsuario'=>$idUsuario);

        $result2 =  $modeloPresupuestoEgresosBitacora->guardarPresupuestoEgresosBitacora($arr);
        if($result2 > 0)
        {
          

            $modeloPresupuestoOtrosIngresos->link->query("COMMIT;");
            echo 1;
        
        }else{
          
            $modeloPresupuestoOtrosIngresos->link->query("ROLLBACK;");
   
            echo 0;
        }
      }else{
        
        
        $modeloPresupuestoOtrosIngresos->link->query("ROLLBACK;");
   
        echo 0;
      }
}else{
    echo json_encode("sesion");
}	
?>