<?php

require_once('conectar.php');

class Cobranza
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Cobranza()
    {
  
      $this->link = Conectarse();

    }

    /** 
    *
    *Busca los registros de facturas y cxc que se tienen que cobrar
    *@param int tipo 0=CXC 1=PUE 2=PPD
    *@param int orden  0=clientes   1=fecha vencimiento
    *@param varchar tabla    (semana, siguiente, vencidos)
    *
    **/
    function buscarCobranzaReporte($fechaInicio,$fechaFin,$idsSucursales){
        // $tipo = $datos['tipo'];
        // $orden = $datos['orden'];
        // $tabla = $datos['tabla'];
        $arregloSucursales = explode(",", $idsSucursales);
        $stringSucursales = $idsSucursales;

        // $condFechaCxc = '';
        // $condFechaFactura = '';

        IF(COUNT($arregloSucursales) > 1){
            $condSucursales = " AND cxc.id_sucursal IN ($stringSucursales)";
        }else{
            $condSucursales = " AND cxc.id_sucursal = $stringSucursales";
        }

        /*if($fechaInicio == '' && $fechaFin == '')
        {
            $condFechaCxc=" AND a.vencimiento >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            $condFechaFactura=" AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condFechaCxc=" AND  a.vencimiento >= '$fechaInicio' ";
            $condFechaFactura=" AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
            $condFechaCxc=" AND DATE(a.vencimiento) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            $condFechaFactura=" AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY)  BETWEEN '$fechaInicio' AND '$fechaFin'";
        }*/

        //-->NJES June/08/2020 no tomar la fecha vencimiento para filtrar, sino la fecha y fecha sola sin dias de credito
        // ya que se debe comenzar a cobrar desde que se indica y no hasta que vencera
        // if($fechaInicio == '' && $fechaFin == '')
        // {
        //     $condFechaCxc=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        //     $condFechaFactura=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        // }else if($fechaInicio != '' &&  $fechaFin == '')
        // {
        //     $condFechaCxc=" AND  a.fecha >= '$fechaInicio' ";
        //     $condFechaFactura=" AND a.fecha >= '$fechaInicio' ";
        // }else{  //-->trae fecha inicio y fecha fin
        //     $condFechaCxc=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        //     $condFechaFactura=" AND a.fecha  BETWEEN '$fechaInicio' AND '$fechaFin'";
        // }

        //-->NJES October/21/2020 se agrega filtro sucursal, si solo tiene permiso a una sucursal
        //se pone por default en el combo y comienza la busqueda, de inicio busca de todas las sucursales a las que tiene permiso.
        // if($idsSucursales[0] == ',')
        // {
        //     $dato=substr($idsSucursales,1);
        //     $condSucursales=' AND a.id_sucursal IN ('.$dato.')';
        // }else{ 
        //     $condSucursales=' AND a.id_sucursal ='.$idsSucursales;
        // }

            // $query = "/*AQUI SE OBTINEN TODOS LOS CXC QUE NO FACTURAN*/
            // (SELECT 
            //     1 as registros_cxc,
            //     a.id AS folio_cxc,
            //     IF(a.folio_factura=0,'',a.folio_factura) AS folio_factura,
            //     'CXC' AS tipo,
            //     IF(a.id_venta>0,'VENTA',IF(a.id_plan>0,'PLAN',IF(a.id_orden_servicio>0,'ORDEN',''))) AS origen,
            //     IF(a.id_venta>0,a.folio_venta,IF(a.id_plan>0,a.folio_recibo,IF(a.id_orden_servicio>0,a.id_orden_servicio,0))) AS folio_origen,
            //     IF(a.id_venta>0,a.fecha,a.fecha_corte_recibo) AS fecha_inicio,
            //     IF(a.id_venta>0,a.fecha,a.vencimiento) AS fecha_fin,
            //     IF(a.id_venta>0,a.fecha,a.vencimiento) AS vencimiento,
            //     a.id_unidad_negocio,
            //     IFNULL(b.nombre,'') AS unidad,
            //     a.id_sucursal,
            //     IFNULL(c.descr,'') AS sucursal,
            //     a.id_razon_social_servicio AS id_servicio,
            //     IFNULL(d.nombre_corto,'') AS cliente,
            //     IFNULL(d.razon_social,'') AS razon_social,
            //     IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C' AND a.cargo_inicial=1),a.total,0),0)),0) AS cargos,
            //     (SELECT IFNULL(SUM(IF(estatus NOT IN('C','P'),IF((SUBSTR(cve_concepto,1,1) = 'A'),total,0),0)),0) FROM cxc WHERE folio_cxc=a.id) AS abonos,
            //     (SELECT IFNULL(SUM(IF(estatus NOT IN('C','P'),IF((SUBSTR(cve_concepto,1,1) = 'C'),total,total * -(1)),0)),0) FROM cxc WHERE folio_cxc=a.id) AS saldo
            // FROM cxc a
            // LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
            // LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
            // LEFT JOIN servicios d ON a.id_razon_social_servicio=d.id
            // WHERE a.id_factura=0 AND a.id_nota_credito=0 AND (a.id_orden_servicio>0 OR a.id_venta>0 OR a.id_plan>0)
            // $condSucursales $condFechaCxc
            // GROUP BY a.folio_cxc
            // HAVING saldo > 0
            // ORDER BY d.nombre_corto ASC)            
            // UNION ALL      
            // /*AQUI SE OBTINEN TODAS LAS FACTURAS DE ALARMAS*/      
            // (SELECT 
            //     pre.registros_cxc,
            //     pre.folio_cxc,
            //     k.folio AS folio_factura,
            //     'FACTURA' AS tipo,
            //     '' AS origen,
            //     '' AS folio_orgen,
            //     k.fecha_inicio,
            //     k.fecha_fin,
            //     DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) AS vencimiento,
            //     k.id_unidad_negocio,
            //     n.nombre AS unidad,
            //     k.id_sucursal,
            //     o.descr AS sucursal,
            //     k.id_razon_social AS id_servicio,
            //     IF(k.id_razon_social > 0 ,TRIM(p.nombre_corto),'Venta Publico en General') AS cliente,
            //     IF(k.id_razon_social > 0 ,TRIM(p.razon_social),'Venta Publico en General') AS razon_social,
            //     SUM(pre.total_facturado) AS cargos,
            //     SUM(pre.pagos_mensual)+SUM(pre.notas_mensual) AS abonos,
            //     SUM(pre.total_facturado)-(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)) AS saldo
                
            // FROM( 
            //     /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
            //     SELECT  a.id,
            //         COUNT(DISTINCT(b.id_cxc))AS registros_cxc,
            //         GROUP_CONCAT(DISTINCT(b.id_cxc))AS folio_cxc,
            //         a.metodo_pago,
            //         CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
            //         IFNULL(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total-a.descuento,0),0),0) AS total_facturado,
            //         IFNULL(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito!=0,a.total-a.descuento,0),0),0) AS abonos_facturado,
            //         IFNULL(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total-a.descuento,(a.total-a.descuento)),0),0) AS saldo_facturado,
            //         0 AS pagos_mensual,
            //         0 AS notas_mensual
            //     FROM facturas a
            //     LEFT JOIN facturas_d b ON a.id=b.id_factura
            //     WHERE (a.es_plan>0 OR a.es_venta_orden>0 OR a.id_cxc>0) 
            //     $condSucursales $condFechaFactura
            //     GROUP BY a.id
            //     /* AQUI OBTIENE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
            //     UNION ALL
            //     SELECT 
            //         b.id_factura,
            //         0 AS registros_cxc,
            //         '' AS folio_cxc,
            //         a.metodo_pago,
            //         DATE_FORMAT(DATE(c.fecha), '%Y-%m') AS fecha,
            //         0 AS total_facturado,
            //         0 AS abonos_facturado,
            //         0 AS saldo_facturado,
            //         SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
            //         0 AS notas_mensual
            //     FROM pagos_e c
            //     LEFT JOIN pagos_d b ON c.id=b.id_pago_e
            //     LEFT JOIN facturas a ON b.id_factura=a.id 
            //     WHERE (a.es_plan>0 OR a.es_venta_orden>0 OR a.id_cxc>0) 
            //     $condSucursales $condFechaFactura
            //     GROUP BY b.id_factura
            //     /* AQUI OBTIENE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/
            //     UNION ALL
            //     SELECT 
            //         sub.id_factura,
            //         0 AS registros_cxc,
            //         '' AS folio_cxc,
            //         sub.metodo_pago,
            //         DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha,
            //         0 AS total_facturado,
            //         0 AS abonos_facturado,
            //         0 AS saldo_facturado,
            //         0 AS pagos_mensual,
            //         SUM(IF(sub.id=b.id_factura_nota_credito,b.total,0))AS notas_mensual
            //     FROM ( 
            //     SELECT 
            //     a.id,
            //     a.metodo_pago,
            //     a.folio,
            //     a.fecha,'F' AS tipo,
            //     a.id AS id_factura,
            //     SUM(a.total) AS total 
            //     FROM facturas a
            //     WHERE a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND (a.es_plan>0 OR a.es_venta_orden>0 OR a.id_cxc>0) 
            //     $condSucursales $condFechaFactura
            //     GROUP BY a.id
            //     )AS sub
            //     LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito AND b.estatus ='T'
            //     GROUP BY sub.id_factura
            // ) AS pre
            // LEFT JOIN facturas k ON pre.id=k.id
            // LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
            // LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
            // LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
            // LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
            // LEFT JOIN servicios p ON k.id_razon_social = p.id
            // GROUP BY pre.id
            // HAVING saldo > 0
            // ORDER BY p.nombre_corto ASC)";

        $query = "SELECT
                    suc.descripcion sucursal,
                    IFNULL(ser.nombre_corto,'Venta al publico en general') servicio,
                    IFNULL(ser.razon_social, '') razon_social,
                    'CXC' tipo,
                    group_concat(cxc.id) idCxc,
                    IFNULL(GROUP_CONCAT(IF(cxc.id_venta>0,'VENTA',IF(cxc.id_plan>0,'PLAN',IF(cxc.id_orden_servicio>0,'ORDEN',null)))),'') AS origen,
                    IFNULL(group_concat(IF(cxc.folio_recibo=0,null,cxc.folio_recibo)),'') folioCxc,
                    cxc.folio_factura folioFactura,
                    cxc.fecha fechaInicio,
                    cxc.vencimiento fechaVencimiento,
                    SUM(cxc.subtotal) subtotal,
                    SUM(cxc.iva) iva,
                    SUM(cxc.total) total,
                    pd.importe_pagado totalPagado,
                    COUNT(cxc.id) registrosCXC,
                    SUM(cxc.total) - pd.importe_pagado saldo
                FROM cxc as cxc
                INNER JOIN sucursales suc ON suc.id_sucursal = cxc.id_sucursal
                INNER JOIN pagos_d pd ON pd.id = cxc.id_pago_d
                INNER JOIN pagos_e pe ON pe.id = pd.id_pago_e
                LEFT JOIN servicios ser ON ser.id = pe.id_razon_social
                WHERE cxc.id_factura = 0
                    AND cxc.id_cxc_pago <> 0
                    AND cxc.id_unidad_negocio = 2
                    $condSucursales
                    AND cxc.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                GROUP BY pd.id
                UNION ALL
                SELECT
                    suc.descripcion sucursal,
                    IFNULL(ser.nombre_corto,'Venta al publico en general') servicio,
                    IFNULL(ser.razon_social, '') razon_social,
                    'FAC' tipo,
                    group_concat(cxc.id) idCxc,
                    IFNULL(GROUP_CONCAT(IF(cxc.id_venta>0,'VENTA',IF(cxc.id_plan>0,'PLAN',IF(cxc.id_orden_servicio>0,'ORDEN',null)))),'') AS origen,
                    IFNULL(group_concat(IF(cxc.folio_recibo=0,null,cxc.folio_recibo)),'') folioCxc,
                    cxc.folio_factura folioFactura,
                    cxc.fecha fechaInicio,
                    cxc.vencimiento fechaVencimiento,
                    fac.subtotal subtotal,
                    fac.iva iva,
                    fac.total total,
                    pd.importe_pagado totalPagado,
                    COUNT(cxc.id) registrosCXC,
                    fac.total - pd.importe_pagado saldo
                FROM cxc as cxc
                INNER JOIN facturas fac ON fac.id = cxc.id_factura
                INNER JOIN sucursales suc ON suc.id_sucursal = cxc.id_sucursal
                INNER JOIN pagos_d pd ON pd.id_factura = fac.id
                INNER JOIN pagos_e pe ON pe.id = pd.id_pago_e
                LEFT JOIN servicios ser ON ser.id = pe.id_razon_social
                WHERE cxc.id_unidad_negocio = 2
                    $condSucursales
                    AND cxc.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                GROUP BY fac.id";

            // echo $query;
            // exit();
        
        $result = $this->link->query($query);

        return query2json($result);

    }//- fin function buscarCobranza

    function buscaFoliosOrigen($idsCXC){

        $condicion='';

        if($idsCXC!=''){

            if (strpos($idsCXC, ',') !== false) {
              $dato=substr($idsCXC,0);
              $condicion=' WHERE id in ('.$dato.')';
            }else{
              $condicion=' WHERE id ='.$idsCXC;
            }
    
          }else{
            
            $condicion=' WHERE id =0';
          }
        $query = "SELECT GROUP_CONCAT(IF(id_venta>0,CONCAT('Venta:',folio_venta),IF(id_plan>0,CONCAT('PLAN:',folio_recibo),CONCAT('ORDEN: ',id_orden_servicio)))) AS folios,        
        GROUP_CONCAT(IF(id_venta>0,'VENTA',IF(id_plan>0,'PLAN','ORDEN'))) AS origen 
        FROM cxc 
        $condicion
        GROUP BY id_factura";
        $result = $this->link->query($query);

        return query2json($result);
    }
    
}//--fin de class Cobranza
    
?>