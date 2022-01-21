<?php
session_start();
include("../models/ReclasificacionGastos.php");
include("../models/PresupuestoEgresosBitacora.php");
$link = Conectarse();

$datos = $_REQUEST['datos'];

$modeloReclasificacionGastos = new ReclasificacionGastos();
$modeloPresupuestoEgresosBitacora = new PresupuestoEgresosBitacora();

$modeloReclasificacionGastos->link->begin_transaction();
$modeloReclasificacionGastos->link->query("START TRANSACTION;");

if (isset($_SESSION['usuario']))
{
      $result =  $modeloReclasificacionGastos->actualizarReclasificacionGastos($datos);

      if($result == 1)
      {
        $camposModificados = $datos['camposModificados'];
        $idUsuario = $datos['idUsuario'];
        $modulo = $datos['modulo'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idRegistro = $datos['idRegistro'];

        $arr = array('camposModificados'=>$camposModificados,
                    'modulo'=>$modulo,
                    'idUnidadNegocio'=>$idUnidadNegocio,
                    'idSucursal'=>$idSucursal,
                    'idRegistro'=>$idRegistro,
                    'idUsuario'=>$idUsuario);

        $result2 =  $modeloPresupuestoEgresosBitacora->guardarPresupuestoEgresosBitacora($arr);
        if($result2 > 0)
        {
            $modeloReclasificacionGastos->link->query("COMMIT;");
            echo 1;
        }else{
            $modeloReclasificacionGastos->link->query("ROLLBACK;");
            echo 0;
        }
      }else{
        $modeloReclasificacionGastos->link->query("ROLLBACK;");
        echo 0;
      }
}else{
    echo json_encode("sesion");
}
		
?>