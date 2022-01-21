<?php

session_start();
include("../models/PresupuestoEgresos.php");
include("../models/PresupuestoEgresosBitacora.php");
$link = Conectarse();

$datos = $_REQUEST['datos'];

$modeloPresupuestoEgresos = new PresupuestoEgresos();
$modeloPresupuestoEgresosBitacora = new PresupuestoEgresosBitacora();

$modeloPresupuestoEgresos->link->begin_transaction();
$modeloPresupuestoEgresos->link->query("START TRANSACTION;");

if (isset($_SESSION['usuario']))
{
      $result =  $modeloPresupuestoEgresos->editarPresupuestoEgreso($datos);

      if($result == 1)
      {
        $camposModificados = $datos['camposModificados'];
        $idUsuario = $datos['idUsuario'];
        $modulo = $datos['modulo'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idRegistro = $datos['idPresupuestoEgreso'];

        $arr = array('camposModificados'=>$camposModificados,
                    'modulo'=>$modulo,
                    'idUnidadNegocio'=>$idUnidadNegocio,
                    'idSucursal'=>$idSucursal,
                    'idRegistro'=>$idRegistro,
                    'idUsuario'=>$idUsuario);

        $result2 =  $modeloPresupuestoEgresosBitacora->guardarPresupuestoEgresosBitacora($arr);
        if($result2 > 0)
        {
            $modeloPresupuestoEgresos->link->query("COMMIT;");
            echo 1;
        }else{
            $modeloPresupuestoEgresos->link->query("ROLLBACK;");
            echo 0;
        }
      }else{
        $modeloPresupuestoEgresos->link->query("ROLLBACK;");
        echo 0;
      }
}else{
    echo json_encode("sesion");
}
		
?>