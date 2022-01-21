<?php

require_once('conectar.php');

class MovimientosPresupuesto
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function MovimientosPresupuesto()
    {
  
      $this->link = Conectarse();

    }
     
    function guardarMovimientoPresupuesto($datos){
        $verifica = 0;

        $hoy = date("Y-m-d H:i:s",time());

        $total = $datos['total'];
        $tipo = $datos['tipo'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idFamiliaGasto = $datos['idFamiliaGasto'];
        $clasificacionGasto = $datos['clasificacionGasto'];

        $idGasto = isset($datos['idGasto']) ? $datos['idGasto'] : 0;
        $idViatico = isset($datos['idViatico']) ? $datos['idViatico'] : 0;
        $idCxP = isset($datos['idCxP']) ? $datos['idCxP'] : 0;
        $idAlmacenD = isset($datos['idAlmacenD']) ? $datos['idAlmacenD'] : 0;
        $idActivo = isset($datos['idActivo']) ? $datos['idActivo'] : 0;
        $idEntradaCompra = isset($datos['idEntradaCompra']) ? $datos['idEntradaCompra'] : 0;
        $idOrdenServicio = isset($datos['idOrdenServicio']) ? $datos['idOrdenServicio'] : 0;
        $estatus = isset($datos['estatus']) ? $datos['estatus'] : 'A';

        //-->NJES April/05/2021 en gastos se selecciona una fecha aplicacion, 
        //si existe el parametro fecha se toma, sino se asigna una fecha actual
        $fecha = isset($datos['fecha']) ? $datos['fecha'].' 12:00:00' : $hoy;

        $query = "INSERT INTO movimientos_presupuesto ( 
                        monto,
                        tipo,
                        id_unidad_negocio,
                        id_sucursal,
                        id_familia_gasto,
                        id_clasificacion,
                        id_unidad_negocio_o,
                        id_sucursal_o,
                        id_familia_gasto_o,
                        id_clasificacion_o,

                        id_orden_servicio,

                        id_gasto,
                        id_viatico,
                        id_almacen_d,
                        id_entrada_compra,
                        id_cxp,
                        id_activo,
                        estatus,
                        fecha_captura) 
                    VALUES (
                        '$total',
                        '$tipo',
                        '$idUnidadNegocio',
                        '$idSucursal',
                        '$idFamiliaGasto',
                        '$clasificacionGasto',
                        '$idUnidadNegocio',
                        '$idSucursal',
                        '$idFamiliaGasto',
                        '$clasificacionGasto',

                        '$idOrdenServicio',

                        '$idGasto',
                        '$idViatico',
                        '$idAlmacenD',
                        '$idEntradaCompra',
                        '$idCxP',
                        '$idActivo',
                        '$estatus',
                        '$fecha')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
        {
          $verifica = 1;
        }else{
          $verifica = 0;
        }
      
        return $verifica;

    } //-- fin function guardarMovimientoPresupuesto

    function actualizarEstatusMovimientoPresupuesto($datos){
        $verifica = 0;

        $estatus = $datos['estatus'];
        $id = $datos['id'];
        $tipo = $datos['tipo'];

        if($tipo == 'gasto')
            $concatQuery = ' WHERE id_gasto='.$id;

        $query = "UPDATE movimientos_presupuesto SET estatus='$estatus' $concatQuery";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
        {
          $verifica = 1;
        }else{
          $verifica = 0;
        }
      
        return $verifica;

    } //-- fin function actualizarEstatusMovimientoPresupuesto

    
}//--fin de class MovimientosPresupuesto
    
?>