<?php

require_once('conectar.php');

class ReclasificacionGastos
{

    public $link;

    function ReclasificacionGastos()
    {

      $this->link = Conectarse();

    }

    /**
        * Busca los registros de la tabla movimientos_presupuestos
        * @param $datos array que contiene los parametros de filtros para busquedas
    */
    function buscarReclasificacionGastos($datos){
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idArea = $datos['idArea'];
        $idDepartamento = $datos['idDepartamento'];
        $idFamiliaGasto = $datos['idFamiliaGasto'];
        $idClasificacion = $datos['idClasificacion'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];

        $sucursal = '';
        $area = '';
        $departamento = '';
        $familia = '';
        $clasificacion = '';
        $condicion='';

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND DATE(a.fecha_captura) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND DATE(a.fecha_captura) >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        if($idSucursal > 0)
            $sucursal = " AND a.id_sucursal =".$idSucursal;

        if($idArea > 0)
            $area = " AND a.id_area =".$idArea;

        if($idDepartamento > 0)
            $departamento = " AND a.id_departamento =".$idDepartamento;

        if($idFamiliaGasto > 0)
            $familia = " AND a.id_familia_gasto =".$idFamiliaGasto;

        if($idClasificacion > 0)
            $clasificacion = " AND a.id_clasificacion =".$idClasificacion;

        $resultado = $this->link->query("SELECT sub.id,sub.importe,sub.fecha,sub.factura,sub.referencia,sub.id_proveedor,sub.proveedor,
                                            sub.id_unidad_negocio,sub.unidad_negocio,sub.id_sucursal,sub.sucursal,
                                            sub.id_area,sub.area,sub.id_departamento,sub.departamento,
                                            sub.id_familia_gasto,sub.familia_gasto,sub.id_clasificacion,sub.clasificacion,sub.nums,
                                            sub.tipo,IFNULL(sub.descripcion,'') AS descripcion,
                                            IF(sub.modificados LIKE '%unidad_negocio%' || sub.modificados LIKE '%sucursal%','SI','NO') AS llaves1,
                                            IF(sub.modificados LIKE '%area%' || sub.modificados LIKE '%departamento%' || sub.modificados LIKE '%familia_gasto%' || sub.modificados LIKE '%clasificacion%','SI','NO') AS llaves2
                                            FROM(
                                                SELECT a.id,a.monto AS importe,DATE(a.fecha_captura) AS fecha, IFNULL(c.folio,'') AS factura,
                                                IFNULL(c.referencia,'') AS referencia,c.id_proveedor,IFNULL(j.nombre,'') AS proveedor,
                                                a.id_unidad_negocio,IFNULL(d.nombre,'') AS unidad_negocio,a.id_sucursal,IFNULL(e.descr,'') AS sucursal,
                                                a.id_area,IFNULL(f.descripcion,'') AS area,a.id_departamento,IFNULL(g.des_dep,'') AS departamento,
                                                a.id_familia_gasto,IFNULL(h.descr,'') AS familia_gasto,a.id_clasificacion,IFNULL(i.descr,'') AS clasificacion,
                                                COUNT(m.id_registro) AS nums,GROUP_CONCAT(DISTINCT(m.campos_modificados)) AS modificados,
                                                CASE
                                                    WHEN a.id_activo > 0 THEN 'ACTIVO FIJO'
                                                    WHEN a.id_gasto > 0 THEN 'GASTOS'
                                                    WHEN a.id_viatico > 0 THEN 'VIATICOS'
                                                    ELSE 'ALMACEN'
                                                END AS tipo,
                                                CASE
                                                    WHEN a.id_activo > 0 THEN p.descripcion
                                                    WHEN a.id_gasto > 0 THEN n.concepto
                                                    WHEN a.id_viatico > 0 THEN CONCAT('Destino: ',o.destino,'. Motivos: ',o.motivos)
                                                    ELSE  IFNULL(CASE b.cve_concepto 
                                                                    WHEN 'E01' THEN CONCAT(b.cve_concepto, ' - ','RECEPCIÓN DE MERCANCÍAS Y SERVICIOS')
                                                                    WHEN 'E02' THEN CONCAT(b.cve_concepto, ' - ','ENTRADA DE UNIFORMES') 
                                                                    WHEN 'E03' THEN CONCAT(b.cve_concepto, ' - ','ENTRADA POR TRANSFERENCIA SUCURSAL')
                                                                    WHEN 'E05' THEN CONCAT(b.cve_concepto, ' - ','ENTRADA POR RESPONSIVA')
                                                                    WHEN 'E06' THEN CONCAT(b.cve_concepto, ' - ','ENTRADA POR COMODATO')
                                                                    WHEN 'E99' THEN CONCAT(b.cve_concepto, ' - ','ENTRADA POR AJUSTE')
                                                                    WHEN 'S01' THEN CONCAT(b.cve_concepto, ' - ','SALIDA POR STOCK')
                                                                    WHEN 'S02' THEN CONCAT(b.cve_concepto, ' - ','SALIDA DE UNIFORMES') 
                                                                    WHEN 'S03' THEN CONCAT(b.cve_concepto, ' - ','SALIDA POR TRANSFERENCIA SUCURSAL')
                                                                    WHEN 'S04' THEN CONCAT(b.cve_concepto, ' - ','SALIDA POR DEVOLUCION A PROVEEDOR')
                                                                    WHEN 'S05' THEN CONCAT(b.cve_concepto, ' - ','SALIDA POR RESPONSIVA')
                                                                    WHEN 'S06' THEN CONCAT(b.cve_concepto, ' - ','SALIDA POR COMODATO')
                                                                    WHEN 'S07' THEN CONCAT(b.cve_concepto, ' - ','SALIDA POR VENTA')
                                                                    WHEN 'S10' THEN CONCAT(b.cve_concepto, ' - ','SALIDA POR ACTIVO FIJO')
                                                                    WHEN 'S99' THEN CONCAT(b.cve_concepto, ' - ','SALIDA POR AJUSTE') 
                                                                END,'') 
                                                END AS descripcion
                                                FROM movimientos_presupuesto a
                                                LEFT JOIN almacen_d b ON a.id_almacen_d=b.id
                                                LEFT JOIN almacen_e c ON b.id_almacen_e=c.id
                                                LEFT JOIN proveedores j ON c.id_proveedor=j.id
                                                LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
                                                LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
                                                LEFT JOIN cat_areas f ON a.id_area=f.id
                                                LEFT JOIN deptos g ON a.id_departamento=g.id_depto
                                                LEFT JOIN fam_gastos h ON a.id_familia_gasto=h.id_fam
                                                LEFT JOIN gastos_clasificacion i ON a.id_clasificacion=i.id_clas
                                                LEFT JOIN presupuestos_bitacora m ON a.id=m.id_registro
                                                /*NJES RECLASIFICACIÓN DE GASTOS (1) (DEN18-2408) Dic/26/2019*/ 
                                                LEFT JOIN gastos n ON a.id_gasto=n.id
                                                LEFT JOIN viaticos o ON a.id_viatico=o.id
                                                LEFT JOIN activos p ON a.id_activo=p.id
                                                /**/
                                                WHERE a.estatus='A' AND a.id_unidad_negocio = $idUnidadNegocio 
                                                $sucursal $area $departamento $familia $clasificacion $condicion
                                                GROUP BY a.id
                                                ORDER BY a.fecha_captura DESC,a.id
                                            ) AS sub");

        return query2json($resultado);

    }//-- fin funcion buscarReclasificacionGastos

    /**
      * Actualiza un campo especifico de la tabla movimientos_presupuesto
      * 
      * @param varchar $datos contiene los parametros a guardar/actualizar
      *
      **/
    function actualizarReclasificacionGastos($datos){
        $verifica = 0;

        $campo = $datos['campo'];
        $idRegistro = $datos['idRegistro'];
        $valor = $datos['valor'];

        switch($campo)
        {
            case 'unidad_negocio':
            {
                $query="UPDATE movimientos_presupuesto SET id_unidad_negocio='$valor',id_sucursal=0,id_departamento=0 WHERE id=".$idRegistro;
                $result = mysqli_query($this->link,$query) or die(mysqli_error());
            }break;
            case 'sucursal':
            {
                $query="UPDATE movimientos_presupuesto SET id_sucursal='$valor',id_departamento=0 WHERE id=".$idRegistro;
                $result = mysqli_query($this->link,$query) or die(mysqli_error());
            }break;
            case 'area':
            {
                $query="UPDATE movimientos_presupuesto SET id_area='$valor',id_departamento=0 WHERE id=".$idRegistro;
                $result = mysqli_query($this->link,$query) or die(mysqli_error());
            }
            break;
            case 'departamento':
            {
                $query="UPDATE movimientos_presupuesto SET id_departamento='$valor' WHERE id=".$idRegistro;
                $result = mysqli_query($this->link,$query) or die(mysqli_error());
            }
            break;
            case 'familia_gasto':
            {
                $query="UPDATE movimientos_presupuesto SET id_familia_gasto='$valor',id_clasificacion=0 WHERE id=".$idRegistro;
                $result = mysqli_query($this->link,$query) or die(mysqli_error());
            }
            break;
            default:
            {
                $query="UPDATE movimientos_presupuesto SET id_clasificacion='$valor' WHERE id=".$idRegistro;
                $result = mysqli_query($this->link,$query) or die(mysqli_error());
            }
            break;
        }

        if($result)
            $verifica = 1;

        return $verifica;
    }//-- fin funcion buscarReclasificacionGastos

    function buscarReclasificacionGastoId($id){
        $query = "SELECT a.id,a.monto AS importe,DATE(a.fecha_captura) AS fecha, 
        a.id_unidad_negocio,IFNULL(d.nombre,'') AS unidad_negocio,a.id_sucursal,IFNULL(e.descr,'') AS sucursal,
        a.id_area,IFNULL(f.descripcion,'') AS AREA,a.id_departamento,IFNULL(g.des_dep,'') AS departamento,
        a.id_familia_gasto,IFNULL(h.descr,'') AS familia_gasto,a.id_clasificacion,IFNULL(i.descr,'') AS clasificacion
        FROM movimientos_presupuesto a
        LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
        LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
        LEFT JOIN cat_areas f ON a.id_area=f.id
        LEFT JOIN deptos g ON a.id_departamento=g.id_depto
        LEFT JOIN fam_gastos h ON a.id_familia_gasto=h.id_fam
        LEFT JOIN gastos_clasificacion i ON a.id_clasificacion=i.id_clas
        WHERE a.id=$id
        GROUP BY a.id
        ORDER BY a.fecha_captura DESC,a.id";

        $resultado = $this->link->query($query);
        return query2json($resultado);
    }

}//-- fin clase ReclasificacionGastos
    
?>