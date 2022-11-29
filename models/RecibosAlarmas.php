<?php

include 'conectar.php';

class RecibosAlarmas
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function RecibosAlarmas()
    {
  
      $this->link = Conectarse();

    }


      function buscarRecibosAlarmas($datos){

        $arregloSucursales = explode(",", $datos['idSucursal']);
        $stringSucursales = $datos['idSucursal'];

        // print_r($idSucursal);
        // echo "<br>";
        // echo count($idSucursal);
        // exit();
      
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        // $idSucursal = $datos['idSucursal'];

        /*$query = "SELECT  r.folio_recibo,
                          r.fecha,
                          r.total AS insoluto,
                          u.nombre_corto,
                          IF(r.estatus='A','Activo',IF(estatus='P','Pendiente',IF(estatus='S','saldado',IF(estatus='T','timbrado','Cancelado')))) AS estatus,
                          IFNULL(s.descripcion,'') AS plan,
                          IFNULL(r.total-SUM(IF(fn.tipo IN ('N','P'),fn.total*-1,fn.total)),r.total) AS total
                        FROM cxc r 
                        LEFT JOIN (SELECT   id_razon_social,
                              id_cliente,
                              folio,
                              fecha,
                              'F' AS tipo,
                              id AS  id_factura,
                              IF(retencion=1,SUM(total)-SUM(importe_retencion),SUM(total)) AS total
                            FROM facturas 
                            WHERE  estatus IN('A','T') AND id_factura_nota_credito=0 AND id_unidad_negocio=2
                            GROUP BY folio
                            UNION ALL
                            SELECT  id_razon_social,
                              id_cliente,
                              folio,
                              fecha,
                              'N' AS tipo,
                              id_factura_nota_credito AS id_factura,
                              SUM(total) AS total
                            FROM facturas 
                            WHERE estatus IN('A','T') AND id_factura_nota_credito!=0 AND id_unidad_negocio=2
                            GROUP BY folio
                            UNION ALL
                            SELECT  a.id_razon_social,
                              a.id_cliente,
                              b.folio_factura AS folio,
                              DATE(a.fecha) AS fecha,
                              'P' AS tipo,                  
                              b.id_factura AS id_factura,
                              IFNULL(SUM(b.importe_pagado),0) AS total
                            FROM pagos_e a
                            LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                            WHERE a.estatus IN('T') AND id_unidad_negocio=2
                            GROUP BY b.folio_factura) fn ON r.folio_factura=fn.folio
                        LEFT JOIN servicios_cat_planes s ON r.id_plan=s.id
                        LEFT JOIN servicios u ON r.id_razon_social_servicio=u.id
                        WHERE r.folio_recibo<>0
                        GROUP BY r.folio_recibo";*/

        //-->NJES October/21/2020 se agrega filtro sucursal, si solo tiene permiso a una sucursal
        //se pone por default en el combo y comienza la busqueda, de inicio busca de todas las sucursales a las que tiene permiso.
        /*if($idSucursal[0] == ',')
        {
            $dato=substr($idSucursal,1);
            $condSucursales=' AND r.id_sucursal IN ('.$dato.')';
        }else{ 
            $condSucursales=' AND r.id_sucursal ='.$idSucursal;
        }*/

        
        // $condSucursales=' AND r.id_sucursal =' . $idSucursal;

        IF(COUNT($arregloSucursales) > 1){
          $condSucursales = " AND suc.id_sucursal IN($stringSucursales)";
        }else{
          $condSucursales = " AND suc.id_sucursal = $stringSucursales";
        }

        //$condSucursales='';

        if($fechaInicio == '' && $fechaFin == '')
            $condFecha = " AND DATE(cxc.fecha) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        else if($fechaInicio != '' &&  $fechaFin == '')
            $condFecha = " AND DATE(cxc.fecha) >= '$fechaInicio' ";
        else
            $condFecha = " AND DATE(cxc.fecha) BETWEEN '$fechaInicio' AND '$fechaFin'";

        // $query = "SELECT
        //           r.id,
        //           r.folio_cxc,
        //           r.folio_recibo,
        //           r.fecha_corte_recibo AS fecha,
        //           u.nombre_corto,
        //           IFNULL(s.descripcion,'') AS plan,
        //           IF(r.estatus='A','Activo',IF(r.estatus='P','Pendiente',IF(r.estatus='S','Saldado',IF(r.estatus='T','Timbrado','Cancelado')))) AS estatus,
        //           CASE
        //             WHEN fn.estatus_factura = 'A' THEN 'Sin Timbrar'
        //             WHEN fn.estatus_factura = 'T' THEN 'Timbrada'
        //             WHEN fn.estatus_factura = 'P' THEN 'Pendiente'
        //             WHEN fn.estatus_factura = 'C' THEN 'Cancelada'
        //             ELSE IFNULL(fn.estatus_factura,'')
        //           END AS estatus_factura,
        //           r.fecha_corte_recibo AS fecha_inicio_periodo,
        //           r.vencimiento AS fecha_fin_periodo,
        //           IFNULL(r.justificacion_cancelado,'') AS justificacion_cancelado,
        //           r.total AS importe,
        //           IFNULL(fn.total_factura,0) AS total_factura,
        //           IFNULL(fn.abonos_factura,0)+IFNULL(abonos.abonos_cxc,0) AS abonos,
        //           IF(IFNULL(fn.total_factura,0)>0 && fn.estatus_factura='T',fn.total_factura-IFNULL(fn.abonos_factura,0),r.total-IFNULL(abonos.abonos_cxc,0)) AS saldo,
        //           r.id_factura,
        //           su.descr AS sucursal,
        //           IFNULL(mult.num_mult_cxc,0) AS num_mult_cxc
        //           FROM cxc r 
        //           LEFT JOIN servicios_bitacora_planes f ON r.id_plan=f.id
        //           LEFT JOIN servicios_cat_planes s ON f.id_plan=s.id
        //           LEFT JOIN servicios u ON r.id_razon_social_servicio=u.id
        //           LEFT JOIN sucursales su ON r.id_sucursal=su.id_sucursal
        //           LEFT JOIN (
        //             SELECT COUNT(id) AS num_mult_cxc,id_factura 
        //             FROM cxc WHERE id_factura > 0 
        //             GROUP BY id_factura) AS mult ON r.id_factura=mult.id_factura
        //           LEFT JOIN (
        //             SELECT folio_cxc,IFNULL(SUM(total),0) AS abonos_cxc
        //             FROM cxc
        //             WHERE id!=folio_cxc AND estatus != 'C'
        //             GROUP BY folio_cxc) AS abonos ON r.id=abonos.folio_cxc
        //           LEFT JOIN (SELECT   a.id_razon_social,
        //             a.id_cliente,
        //             a.folio,
        //             a.fecha,
        //             'F' AS tipo,
        //             a.id AS  id_factura,
        //             IF(a.retencion=1,SUM(IFNULL(a.total,0))-SUM(IFNULL(a.importe_retencion,0))-a.descuento,SUM(IFNULL(a.total,0))-a.descuento) AS total_factura,
        //             SUM(IFNULL(nc.abonos_nc,0))+SUM(IFNULL(pagos.abonos_pagos,0)) AS abonos_factura,
        //             a.estatus AS estatus_factura
        //             FROM facturas a
        //             LEFT JOIN (SELECT id, id_factura_nota_credito,SUM(total) AS abonos_nc
        //               FROM facturas 
        //               WHERE estatus IN('T') AND id_factura_nota_credito!=0 AND id_unidad_negocio=2
        //               GROUP BY id_factura_nota_credito) AS nc ON a.id=nc.id_factura_nota_credito
        //             LEFT JOIN (SELECT 
        //               b.id_factura AS id_factura,
        //               IFNULL(SUM(b.importe_pagado),0) AS abonos_pagos
        //               FROM pagos_e a
        //               LEFT JOIN pagos_d b ON a.id=b.id_pago_e
        //               WHERE a.estatus IN('A','T') AND id_unidad_negocio=2
        //               GROUP BY b.id_factura) AS pagos ON a.id=pagos.id_factura
        //             WHERE  a.id_factura_nota_credito=0 AND a.id_unidad_negocio=2
        //             GROUP BY a.id
        //             ) fn ON r.id_factura=fn.id_factura
        //           WHERE r.id_plan > 0 AND r.folio_recibo > 0 AND r.id_unidad_negocio=2
        //           $condSucursales $condFecha
        //           GROUP BY r.folio_recibo
        //           ORDER BY r.folio_recibo ASC";

        // echo $query;
        // exit();

        $query = "SELECT 
                    fac.id,
                    suc.descripcion sucursal,
                    cxc.folio_factura folioFac,
                    cxc.folio_recibo folioRec,
                    IF(fac.es_plan = 1, cxc.fecha_corte_recibo, cxc.fecha_captura) fecha,
                    ser.nombre_corto servicio,
                    ser.cuenta,
                    IFNULL(scp.descripcion, '') plan,
                    IFNULL(ne.folio, '') venta,
                    IFNULL(so.id, '') soid,
                    COUNT(cxc.id) num_mult_cxc,
                    SUM(cxc.total) importeCxc,
                    fac.observaciones,
                    fac.total importeFac,
                    fac.subtotal importeSinIvaFac,
                    IFNULL(pagos.abono, 0) abono,
                    IFNULL(so.servicio, '') descServicio,
                    fac.descuento,
                    ((fac.total - IFNULL(pagos.abono, 0))-fac.descuento) saldoInsoluto,
                    cxc.fecha_corte_recibo fechaInicio,
                    cxc.vencimiento fechaFin,
                    CASE
                        WHEN cxc.estatus = 'C' THEN 'Cancelado'
                        WHEN cxc.estatus = 'A' THEN 'Activo'
                        WHEN cxc.estatus = 'T' THEN 'Timbrado'
                        WHEN cxc.estatus = 'S' THEN 'Pagado'
                    END estatusCxc,
                    IFNULL(cxc.justificacion_cancelado, '') justiCanc,
                    CASE
                        WHEN fac.estatus = 'C' THEN 'Cancelado'
                        WHEN fac.estatus = 'A' THEN 'Activo'
                        WHEN fac.estatus = 'T' THEN 'Timbrado'
                    END estatusFac,
                    CASE
                      WHEN cxc.id_venta > 0 THEN ne.vendedor
                      ELSE ''
                    END vendedor,
                    CASE
                      WHEN cxc.id_venta > 0 THEN ne.tecnico
                      WHEN cxc.id_orden_servicio > 0 THEN so.tecnico
                      ELSE ''
                    END tecnico,
                    CASE
                      WHEN cxc.id_orden_servicio > 0 THEN us.usuario
                      ELSE ''
                    END usuarioCreacion
                  FROM cxc as cxc
                  LEFT JOIN sucursales suc ON suc.id_sucursal = cxc.id_sucursal
                  LEFT JOIN servicios ser ON cxc.id_razon_social_servicio = ser.id
                  INNER JOIN facturas fac ON cxc.id_factura = fac.id
                  LEFT JOIN servicios_bitacora_planes sbp ON cxc.id_plan = sbp.id
                  LEFT JOIN servicios_cat_planes scp ON sbp.id_plan = scp.id
                  LEFT JOIN notas_e ne ON ne.id = cxc.id_venta
                  LEFT JOIN servicios_ordenes so ON cxc.id_orden_servicio = so.id
                  LEFT JOIN usuarios us ON so.id_usuario_captura = us.id_usuario
                  LEFT JOIN (
                    SELECT SUM(importe_pagado) abono, id_factura
                      FROM pagos_d
                      GROUP BY id_factura
                    ) pagos ON pagos.id_factura = fac.id
                  WHERE suc.id_unidad_negocio = 2
                        $condSucursales
                        $condFecha
                  GROUP BY cxc.id_factura ,fac.id;";

        // echo $query;
        // exit();

        $result = $this->link->query($query);
        
        return query2json($result);
      }//- fin function buscarRecibosAlarmas


}//--fin de class Clientes
    
?>