<?php

require_once('conectar.php');

class PresupuestoIngresosSinCotizacion
{

    public $link;

    function PresupuestoIngresosSinCotizacion()
    {

      $this->link = Conectarse();

    }

    function buscaInformacionPresupuesto($idUnidad, $idSucursal, $anio, $mes, $tipo){
     
      $condicionUnidad = "a.id_unidad_negocio=".$idUnidad;
      $condicionSucursal = "AND a.id_sucursal = ".$idSucursal;
      $condicionMes = "AND ((a.mes=".$mes." AND a.anio =".$anio.")  OR (a.vencimiento < now() AND a.estatus='P'))"; 
      $condicionMesF = "AND ((a.mes=".$mes." AND a.anio =".$anio.")  OR (DATE_ADD(a.fecha_inicio, INTERVAL a.dias_credito DAY) < NOW() AND a.estatus='T'))"; 

      if($idSucursal!=''){

        if (strpos($idSucursal, ',') !== false) {
          $dato=substr($idSucursal,1);
          $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
        }else{
          $condicionSucursal=' AND a.id_sucursal ='.$idSucursal;
        }

      }else{
        
        $condicionSucursal=' AND a.id_sucursal =0';
      }

      
        $result = $this->link->query("SELECT 
          a.id,
          a.id_unidad_negocio,
          a.id_sucursal,
          IFNULL(IF(a.folio_factura>0,a.folio_factura,''),'') AS folio_factura,
          a.fecha,
          a.total,
          a.referencia,
          a.vencimiento AS vence,
          a.id_razon_social,
          b.nombre AS unidad_negocio,
          c.descr AS sucursal,
          '' AS observaciones,
          d.razon_social,
          IF(a.estatus='P','PENDIENTE',IF(a.estatus='T','TIMBRADA','LIQUIDADA'))AS estatus,
          IF(a.estatus='P' AND a.vencimiento<CURRENT_DATE(),'vencida','noVencida')AS vencida
        FROM cxc a
        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id 
        LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
        LEFT JOIN razones_sociales d ON a.id_razon_social = d.id
        LEFT JOIN facturas e ON a.id_factura=e.id 
        WHERE $condicionUnidad $condicionSucursal $condicionMes AND  a.cargo_inicial=1 AND a.estatus!='C' AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0 AND e.id_contrato=0
        UNION ALL
        SELECT 
              pre.id,
              k.id_unidad_negocio,
              k.id_sucursal,
              IFNULL(IF(k.folio>0,k.folio,''),'') AS folio_factura,
              pre.fecha,
              SUM(pre.total_facturado)-(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)) AS total,
              '' AS referencia,
              DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) AS vence,
              k.id_razon_social,
              n.nombre AS unidad_negocio,
              o.descr AS sucursal,
              l.razon_social AS razon_social,
              IFNULL(k.observaciones,'') as observaciones,
              IF(k.estatus='P','PENDIENTE',IF(k.estatus='T','TIMBRADA','LIQUIDADA'))AS estatus,
              IF(k.estatus='T' AND DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) < CURRENT_DATE(),'vencida','noVencida')AS vencida
        FROM (
              /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
              SELECT a.id,
                CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total,0),0)),0) AS total_facturado,
                IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado,
                IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,a.total,(a.total)*-1),0)),0) AS saldo_facturado,
                0 AS pagos_mensual,
                0 AS notas_mensual
              FROM facturas a
              WHERE $condicionUnidad $condicionSucursal $condicionMesF  AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 AND a.id_contrato=0
              GROUP BY a.id
              /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
              UNION ALL
              SELECT 
                  b.id_factura,
                  DATE_FORMAT(DATE(c.fecha), '%Y-%m') AS fecha,
                  0 AS total_facturado,
                  0 AS abonos_facturado,
                  0 AS saldo_facturado,
                  SUM(IF(a.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                  0 AS notas_mensual
              FROM pagos_e c
              LEFT JOIN pagos_d b ON c.id=b.id_pago_e
              LEFT JOIN facturas a ON b.id_factura=a.id 
              WHERE $condicionUnidad $condicionSucursal $condicionMesF  AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 AND a.id_contrato=0
              GROUP BY b.id_factura
              /* AQUI OBTINE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/
              UNION ALL
              SELECT 
                sub.id_factura,
                DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha,
                0 AS total_facturado,
                0 AS abonos_facturado,
                0 AS saldo_facturado,
                0 AS pagos_mensual,
                SUM(IF(sub.id=b.id_factura_nota_credito,b.total,0))AS notas_mensual
              FROM (                    
                      SELECT 
                      a.id,
                      folio,
                      a.fecha,'F' AS tipo,
                      a.id AS  id_factura,
                      SUM(a.total) AS total 
                      FROM facturas a
                      WHERE  a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND $condicionUnidad $condicionSucursal $condicionMesF AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 AND a.id_contrato=0
                      GROUP BY a.id
              )AS sub
            LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito  AND b.estatus ='T'
            GROUP BY sub.id_factura
            ) AS pre
            LEFT JOIN facturas k ON pre.id=k.id
            LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
            LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
            LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
            LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
            GROUP BY pre.id
            HAVING total>0");
            return query2json($result);
    
        
    }

}
    
?>