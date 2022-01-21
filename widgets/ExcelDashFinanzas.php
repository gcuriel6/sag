<?php

include 'conectar.php';

class ExcelDashFinanzas
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function ExcelDashFinanzas()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Buscamos registros y generamos archivo excel
      *
      * @param varchar $nombre que se le dara al archivo
      * @param varchar $modulo para ver cual quert se va a generar
      * @param varchar $fecha para componer el nombre del archivo
      *
    **/
    function generaExcelDashFinanzas($nombre,$modulo,$fecha,$datos){
        
        header("Content-type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: filename=" .$nombre. "_" .$fecha. ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $html='';

        if($modulo=='DASH_FINANZAS'){

            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idEmpresaFiscal = $arreglo['idEmpresaFiscal'];
            $fecha = isset($arreglo['fecha']) ? $arreglo['fecha'] : '';
            $tipoRenglon = isset($arreglo['tipoRenglon']) ? $arreglo['tipoRenglon'] : '';
            $tipo = $arreglo['tipo'];
            $verificado = isset($arreglo['verificado']) ? $arreglo['verificado'] : '';

            $unidad='';
            $sucursal='';
            $empresa_fiscal='';
            $condFecha='';
            $query='';
            $verif='';
            $verif2='';

            if($verificado != '')
            {
                $verif=" AND a.verificado='$verificado'";
                $verif2=" AND c.verificado='$verificado'";
            }

      
                if($idUnidadNegocio != '')
                {
                    if($idUnidadNegocio[0] == ',')
                    {
                        $dato=substr($idUnidadNegocio,1);
                        $unidad = ' AND a.id_unidad_negocio IN('.$dato.') ';
                    }else{ 
                        $unidad = ' AND a.id_unidad_negocio ='.$idUnidadNegocio;
                    }
                }

                if($idSucursal[0] == ',')
                {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
                }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
                }

                if($idEmpresaFiscal != '')
                {
                    $empresa_fiscal = ' AND a.id_empresa_fiscal = '.$idEmpresaFiscal;
                }
                
                if($fecha != '')
                {
                    $condFecha = " AND DATE_FORMAT(DATE(a.fecha), '%Y-%m') = '$fecha'";
                    $condFecha2 = " AND DATE_FORMAT(DATE(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo)), '%Y-%m') = '$fecha'";
                }
                
                 if($tipo == 1)
            {
                $query = "SELECT
                        pre.anio,
                    IF
                        ( pre.mes < 10, CONCAT( '0', pre.mes ), pre.mes ) AS mes,
                        pre.fecha,
                        SUM( pre.total_facturado ) AS facturado,
                        SUM( pre.verificado ) AS verificado,
                        SUM( pre.total_facturado )-(
                        SUM( pre.pagos_mensual )+ SUM( pre.notas_mensual )) AS saldo_facturado,
                        SUM( pre.abonos_facturado + pre.total_pagos + pre.abonos_otros_ingresos ) AS cobranza_mes,
                        SUM( pre.total_otros_ingresos ) AS total_otros_ingresos,
                        SUM( pre.abonos_otros_ingresos ) AS abonos_otros_ingresos,
                        SUM( pre.saldo_otros_ingresos ) AS saldo_otros_ingresos,
                        pre.pagos_mensualII AS cobrado_facturado
                    FROM
                        (
                        SELECT MONTH
                            ( a.fecha ) AS mes,
                            YEAR ( a.fecha ) AS anio,
                            CONCAT(
                            IF
                                (
                                    MONTH ( a.fecha ) < 10,
                                    CONCAT(
                                        '0',
                                    MONTH ( a.fecha )),
                                MONTH ( a.fecha )),
                                '-',
                            YEAR ( a.fecha )) AS fecha,
                            IFNULL(
                                SUM(
                                IF
                                    (
                                        a.estatus IN ( 'A', 'T' ),
                                    IF
                                        ( a.id_factura_nota_credito = 0, ( a.total - a.importe_retencion ), 0 ),
                                        0 
                                    )),
                                0 
                            ) AS total_facturado,
                            IFNULL(
                                SUM(
                                IF
                                ( a.estatus = 'T', IF ( a.id_factura_nota_credito != 0, a.total - a.importe_retencion, 0 ), 0 )),
                                0 
                            ) AS abonos_facturado,
                            IFNULL(
                                SUM(
                                IF
                                    (
                                        a.estatus IN ( 'A', 'T' ),
                                    IF
                                        ( a.id_factura_nota_credito = 0, ( a.total - a.importe_retencion ),( a.total - a.importe_retencion )*- 1 ),
                                        0 
                                    )),
                                0 
                            ) AS saldo_facturado,
                            IFNULL(
                                SUM(
                                IF
                                ( a.estatus IN ( 'A', 'T' ), IF ( a.verificado = 'S', a.total - a.importe_retencion, 0 ), 0 )),
                                0 
                            ) AS verificado,
                            GROUP_CONCAT( a.id ) AS id_facturas_mes,
                            0 AS total_pagos,
                            0 AS total_otros_ingresos,
                            0 AS abonos_otros_ingresos,
                            0 AS saldo_otros_ingresos,
                            0 AS pagos_mensual,
                            0 AS notas_mensual,
                             pagado_actual.pagos_mensual AS pagos_mensualII
                        FROM
                            facturas a
                        INNER JOIN 
                        (       
                            SELECT 
                            YEAR(a.fecha)AS anio,
                            MONTH(a.fecha) AS nes,
                            SUM(IF(a.estatus IN ('A','T') AND pagos_e.estatus IN ('A', 'T'),pagos_d.importe_pagado,0)) AS pagos_mensual
                            FROM facturas a
                            LEFT JOIN  pagos_d  ON a.id = pagos_d.id_factura 
                            LEFT JOIN pagos_e  ON pagos_d.id_pago_e = pagos_e.id  
                             WHERE 1 $unidad $sucursal $empresa_fiscal
                            GROUP BY YEAR(a.fecha), MONTH(a.fecha)
                        ) pagado_actual ON YEAR(a.fecha) = pagado_actual.anio AND  MONTH(a.fecha) = pagado_actual.nes
                        
                        WHERE
                            1 $unidad $sucursal $empresa_fiscal
                        GROUP BY
                            YEAR ( a.fecha ),
                            MONTH ( a.fecha ) UNION ALL
                    /* ESTE OBTIENE LO DE OTROS INGRESO DE CXC POR MES*/
                        SELECT MONTH
                            (
                            IF
                            ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) AS mes,
                            YEAR (
                            IF
                            ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) AS anio,
                            CONCAT(
                            IF
                                (
                                    MONTH (
                                    IF
                                    ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) < 10,
                                    CONCAT(
                                        '0',
                                        MONTH (
                                        IF
                                        ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo ))),
                                    MONTH (
                                    IF
                                    ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo ))),
                                '-',
                                YEAR (
                                IF
                                ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo ))) AS fecha,
                            0 AS total_facturado,
                            0 AS abonos_facturado,
                            0 AS saldo_facturado,
                            0 AS verificado,
                            0 AS id_facturas_mes,
                            0 AS total_pagos,
                            IFNULL(
                                SUM(
                                IF
                                    (
                                        a.estatus NOT IN ( 'C', 'P' ),
                                    IF
                                        (( SUBSTR( a.cve_concepto, 1, 1 ) = 'C' ), ( a.total - a.retencion - a.descuento), 0 ),
                                        0 
                                    )),
                                0 
                            ) AS total_otros_ingresos,
                            IFNULL(
                                SUM(
                                IF
                                    (
                                        a.estatus NOT IN ( 'C', 'P' ),
                                    IF
                                        (( SUBSTR( a.cve_concepto, 1, 1 ) = 'A' ), a.total, 0 ),
                                        0 
                                    )),
                                0 
                            ) AS abonos_otros_ingresos,
                            IFNULL(
                                SUM(
                                IF
                                    (
                                        a.estatus NOT IN ( 'C', 'P' ),
                                    IF
                                        ((
                                                SUBSTR( a.cve_concepto, 1, 1 ) = 'C' 
                                                ),
                                            ( a.total - a.retencion - a.descuento),((
                                                    a.total - a.retencion - a.descuento
                                                    ) * -(
                                                    1 
                                                ))),
                                        0 
                                    )),
                                0 
                            ) AS saldo_otros_ingresos,
                            0 AS pagos_mensual,
                            0 AS notas_mensual,
                            0 AS pagos_mensualII
                        FROM
                            cxc a 
                        WHERE
                            a.id_factura = 0 
                            AND a.id_nota_credito = 0 
                            $unidad $sucursal $empresa_fiscal 
                        GROUP BY
                            YEAR (
                            IF
                            ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )),
                            MONTH (
                            IF
                            ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) 
                        UNION ALL
                    /* AQUI OBTINE LA INFORMACION DEL TOTAL DE PAGOS POR MES*/
                        SELECT MONTH
                            (
                            DATE( a.fecha )) AS mes,
                            YEAR (
                            DATE( a.fecha )) AS anio,
                            CONCAT(
                            IF
                                (
                                    MONTH (
                                    DATE( a.fecha )) < 10,
                                    CONCAT(
                                        '0',
                                        MONTH (
                                        DATE( a.fecha ))),
                                    MONTH (
                                    DATE( a.fecha ))),
                                '-',
                                YEAR (
                                DATE( a.fecha ))) AS fecha,
                            0 AS total_facturado,
                            0 AS abonos_facturado,
                            0 AS saldo_facturado,
                            0 AS verificado,
                            0 AS id_facturas_mes,
                            IFNULL( SUM( b.importe_pagado ), 0 ) AS total_pagos,
                            0 AS total_otros_ingresos,
                            0 AS abonos_otros_ingresos,
                            0 AS saldo_otros_ingresos,
                            0 AS pagos_mensual,
                            0 AS notas_mensual,
                            0 AS pagos_mensualII
                        FROM
                            pagos_e a
                            LEFT JOIN pagos_d b ON a.id = b.id_pago_e 
                        WHERE
                            a.estatus = 'T' 
                            $unidad $sucursal $empresa_fiscal
                        GROUP BY
                            YEAR (
                            DATE( a.fecha )),
                            MONTH (
                            DATE( a.fecha )) /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
                        UNION ALL
                        SELECT MONTH
                            (
                            DATE( a.fecha )) AS mes,
                            YEAR (
                            DATE( a.fecha )) AS anio,
                            DATE_FORMAT( DATE( a.fecha ), '%Y-%m' ) AS fecha,
                            0 AS total_facturado,
                            0 AS abonos_facturado,
                            0 AS saldo_facturado,
                            0 AS verificado,
                            0 AS id_facturas_mes,
                            0 AS total_pagos,
                            0 AS total_otros_ingresos,
                            0 AS abonos_otros_ingresos,
                            0 AS saldo_otros_ingresos,
                            SUM(
                            IF
                            ( c.estatus IN ( 'A', 'T' ), b.importe_pagado, 0 )) AS pagos_mensual,
                            0 AS notas_mensual ,
                            0 AS pagos_mensualII
                        FROM
                            pagos_e a
                            LEFT JOIN pagos_d b ON a.id = b.id_pago_e
                            LEFT JOIN facturas c ON b.id_factura = c.id 
                        WHERE
                            MONTH (
                                DATE( a.fecha ))= MONTH (
                            DATE( c.fecha )) 
                            $unidad $sucursal $empresa_fiscal
                        GROUP BY
                            DATE_FORMAT( a.fecha, '%Y-%m' ) /* AQUI OPTINE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURAS DEL MES*/
                        UNION ALL
                        SELECT MONTH
                            (
                            DATE( sub.fecha )) AS mes,
                            YEAR (
                            DATE( sub.fecha )) AS anio,
                            DATE_FORMAT( sub.fecha, '%Y-%m' ) AS fecha,
                            0 AS total_facturado,
                            0 AS abonos_facturado,
                            0 AS saldo_facturado,
                            0 AS verificado,
                            0 AS id_facturas_mes,
                            0 AS total_pagos,
                            0 AS total_otros_ingresos,
                            0 AS abonos_otros_ingresos,
                            0 AS saldo_otros_ingresos,
                            0 AS pagos_mensual,
                            SUM(
                            IF
                                (
                                    sub.id = b.id_factura_nota_credito 
                                    AND DATE_FORMAT( sub.fecha, '%Y-%m' )= DATE_FORMAT( b.fecha, '%Y-%m' ),
                                    b.total - b.importe_retencion,
                                    0 
                                )) AS notas_mensual ,
                                0 AS pagos_mensuaII
                                
                        FROM
                            (
                            SELECT
                                a.id,
                                folio,
                                a.fecha,
                                'F' AS tipo,
                                a.id AS id_factura,
                                SUM( a.total - a.importe_retencion) AS total 
                            FROM
                                facturas a 
                            WHERE
                                a.estatus IN ( 'A', 'T' ) 
                                AND a.id_factura_nota_credito = 0 
                                $unidad $sucursal $empresa_fiscal
                            GROUP BY
                                a.id 
                            ) AS sub
                            LEFT JOIN facturas b ON sub.id = b.id_factura_nota_credito 
                            AND b.estatus = 'T' 
                        GROUP BY
                            DATE_FORMAT( sub.fecha, '%Y-%m' ) /*FACTURAS CON SALDOS VENCIDOS (PRESUPUESTO_INGRESOS)*/
                            
                        ) AS pre 
                    GROUP BY
                        pre.anio,
                        pre.mes 
                    ORDER BY
                        pre.anio DESC,
                        pre.mes DESC";                      
               
            }else{
                if($tipoRenglon=='facturado')
                { // esta
                        $query = "SELECT pre.id,
                        k.estatus,
                        k.verificado,
                        n.nombre AS unidad_negocio,
                        o.descr AS sucursal,
                        pre.anio,
                        pre.mes,
                        pre.fecha_inicio,
                        pre.fecha_fin,
                        pre.fecha,
                        l.razon_social AS emisor,
                        razones_sociales.nombre_corto,
                        k.razon_social AS receptor,
                        IF(pre.id_factura_nota_credito=0,'Factura',IF(pre.id_factura_nota_credito>0,'Nota de Credito','')) AS tipo,
                        IF(k.id_factura_nota_credito=0,k.folio,xd.folio) AS folio_factura,
                        IFNULL(k.folio_nota_credito,pre.folios_notas) AS folio_nota_credito,
                        IFNULL(m.uuid_timbre,'') AS uuid,
                        pre.metodo_pago,
                        k.fecha,
                        DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) AS fecha_vencimiento,
                        k.dias_credito,
                        IF(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)>CURDATE(),'',DATEDIFF(CURDATE(),DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY))) AS dias_vencimiento,
                        SUM(pre.sub_total) AS sub_total,
                        SUM(pre.total_facturado) AS facturado,
                        SUM(pre.pagos_mensual) AS cobrado_facturado, 
                        SUM(pre.total_facturado)-SUM(pre.pagos_mensual) - SUM(pre.notas_mensual) AS saldo_facturado,
                        k.importe_retencion,
                       -- SUM(pre.notas_mensual) AS notas_credito
                        SUM(pre.notas_mensual) AS notas_credito,-- * -1 AS notas_credito-- CONCAT_WS('-', SUM(pre.notas_mensual)) AS notas_credito
                        pre.folios_pagos AS pagos,
                        IFNULL(pre.fecha_aplicacion_pago,'') AS fecha_de_abonos,
                        us.usuario                        
                        FROM
                        (/*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                        SELECT a.id,a.id_factura_nota_credito,MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio, a.fecha_inicio, a.fecha_fin,
                        CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                        IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion ),0),0)),0) AS total_facturado,
                        IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0, a.total,0),0)),0) AS abonos_facturado,
                        IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.subtotal),(a.subtotal)*-1),0)),0) AS sub_total,
                        IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,(a.total - a.importe_retencion),(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,
                        SUM(IFNULL(pagos.pagos_mensual, 0)) AS pagos_mensual,
                        SUM(IFNULL(f_nc.notas_mensual, 0)) AS notas_mensual,
                        IFNULL(pagos.folios_pagos,'') AS folios_pagos,
                        IFNULL(f_nc.folios_notas,'') AS folios_notas,
                        IF(SUM(IFNULL(pagos.pagos_mensual, 0))>0,pagos.fecha,f_nc.fecha) AS fecha_aplicacion_pago,
                        a.id_capturo,
                        a.metodo_pago
                        FROM facturas a

                        LEFT JOIN 
                        (

                            SELECT 
                            GROUP_CONCAT(a.folio,' ') as folios_pagos,
                            b.id_factura,
                            SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                            DATE(MAX(a.fecha)) AS fecha
                            FROM pagos_e a
                            LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                            LEFT JOIN facturas c ON b.id_factura=c.id
                            GROUP BY b.id_factura

                        ) pagos ON a.id = pagos.id_factura 

                        LEFT JOIN 
                        (
                             SELECT 
                             GROUP_CONCAT(facturas.folio_nota_credito,' ') as folios_notas,
                            facturas.id_factura_nota_credito  AS id_factura,
                            SUM(IF(facturas.estatus IN ('A','T'), (facturas.total - facturas.importe_retencion ), 0)) AS notas_mensual,
                            MAX(fecha) AS fecha
                            FROM facturas 
                            WHERE facturas.id_factura_nota_credito > 0 AND facturas.estatus IN ('A','T')
                            GROUP BY facturas.id_factura_nota_credito
                            
                        )f_nc ON a.id =  f_nc.id_factura

                        WHERE 1 $unidad $sucursal $empresa_fiscal $condFecha $verif
                        GROUP BY a.id
                        /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
                        ) AS pre
                        LEFT JOIN facturas k ON pre.id=k.id
                        LEFT JOIN facturas xd ON k.id_factura_nota_credito=xd.id
                        LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                        LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                        LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                        LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                        left join razones_sociales on k.id_razon_social = razones_sociales.id
                        left join usuarios us ON us.id_usuario = pre.id_capturo
                        GROUP BY pre.id
                        ORDER BY pre.id DESC -- --";

                }else{


                    $query = " SELECT pre.id,   
                        pre.id_cxc,                             
                        IF(pre.id_cxc > 0,p.estatus,k.estatus) AS estatus,                                
                        IFNULL(k.verificado,'') AS verificado, 
                        IF(pre.id_cxc > 0,q.nombre,n.nombre) AS unidad_negocio, 
                        IF(pre.id_cxc > 0,r.descr,o.descr) AS sucursal,                            
                        pre.anio,                                
                        pre.mes,               
                        pre.fecha_inicio,
                        pre.fecha_fin,                 
                        pre.fecha,                                
                        IFNULL(l.razon_social,'') AS emisor,    
                        s.nombre_corto,                            
                        IF(pre.id_cxc > 0,s.razon_social,k.razon_social) AS receptor, 
                        IF(pre.id_factura_nota_credito=0,'Factura',IF(pre.id_factura_nota_credito>0,'Nota de Credito','')) AS tipo,
                        IF(pre.id_cxc > 0,p.folio_cxc,IF(k.id_factura_nota_credito=0,k.folio,xd.folio)) AS folio,
                        IF(pre.id_cxc > 0,p.folio_cxc,IFNULL(k.folio_nota_credito,pre.folios_notas)) AS folio_nota_credito,                              
                        IFNULL(IF(pre.id_cxc > 0,'',m.uuid_timbre),'') AS uuid,  
                        IF(pre.id_cxc > 0,p.fecha,k.fecha) AS fecha,    
                        IF(pre.id_cxc > 0,p.vencimiento,DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)) AS fecha_vencimiento,                                
                        IF(pre.id_cxc > 0,s.dias_cred,k.dias_credito) AS dias_credito,      
                        IF(pre.id_cxc > 0,IF(p.vencimiento>CURDATE(),0,DATEDIFF(CURDATE(),p.vencimiento)),                          
                        IF(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)>CURDATE(),0,DATEDIFF(CURDATE(),DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)))) AS dias_vencimiento,                                
                        SUM(pre.subtotal) AS subtotal,
                        SUM(pre.total_facturado)+SUM(pre.total_otros_ingresos) AS facturado,                                
                        SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)+SUM(pre.abonos_otros_ingresos) AS cobrado_facturado,                                
                        (SUM(pre.total_facturado)+SUM(pre.total_otros_ingresos))-(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)+SUM(pre.saldo_otros_ingresos)) AS saldo_facturado,                                
                        -- SUM(pre.notas_mensual) AS notas_credito 
                        pre.importe_retencion,
                        SUM(pre.notas_mensual) AS notas_credito, -- * -1 AS notas_credito  
                        pre.folios_pagos AS pagos,
                        IFNULL(pre.fecha_aplicacion_pago,'') AS fecha_de_abonos                          
                        FROM                                    
                        (/*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/                                    
                        SELECT 
                        a.id,
                        a.id_factura_nota_credito,
                        0 AS id_cxc, 
                        MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio, a.fecha_inicio,
                        a.fecha_fin,    
                        a.importe_retencion,
                        IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.subtotal),(a.subtotal)*-1),0)),0) AS subtotal,                               
                        CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,                                    
                        IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion),0),0)),0) AS total_facturado,                                    
                        IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado,                                    
                        IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion) ,(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,                                    
                        SUM(IFNULL(pagos.pagos_mensual, 0)) AS pagos_mensual,                                    
                        SUM(IFNULL(f_nc.notas_mensual, 0)) AS notas_mensual,
                        0 AS total_otros_ingresos,
                        0 AS abonos_otros_ingresos,
                        0 AS saldo_otros_ingresos,
                        IFNULL(pagos.folios_pagos,'') AS folios_pagos,
                        IFNULL(f_nc.folios_notas,'') AS folios_notas,
                        IF(SUM(IFNULL(pagos.pagos_mensual, 0))>0,pagos.fecha,f_nc.fecha) AS fecha_aplicacion_pago                                 
                        FROM facturas a                     

                        INNER JOIN 
                        (

                        SELECT 
                        GROUP_CONCAT(a.folio,' ') as folios_pagos,
                        b.id_factura,
                        SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                        DATE(MAX(a.fecha)) AS fecha
                        FROM pagos_e a
                        LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                        LEFT JOIN facturas c ON b.id_factura=c.id
                        WHERE 1 $unidad $sucursal $empresa_fiscal $condFecha    
                        GROUP BY b.id_factura

                        ) pagos ON a.id = pagos.id_factura 

                        LEFT JOIN 
                        (
                        SELECT 
                        GROUP_CONCAT(a.folio_nota_credito,' ') as folios_notas,
                        a.id AS id_factura,
                        SUM(IF(a.estatus IN ('A','T'), (a.total - a.importe_retencion ), 0)) AS notas_mensual,
                        MAX(a.fecha) AS fecha
                        FROM facturas a
                        WHERE a.id_factura_nota_credito > 0 AND a.estatus IN ('A','T') $unidad $sucursal $empresa_fiscal $condFecha    
                        GROUP BY a.id_factura_nota_credito
                        )f_nc ON a.id =  f_nc.id_factura

                        WHERE 1   $unidad $sucursal $empresa_fiscal                                   
                        GROUP BY a.id                            
                        ) AS pre                                
                        LEFT JOIN facturas k ON pre.id=k.id     
                        LEFT JOIN facturas xd ON k.id_factura_nota_credito=xd.id                           
                        LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa                                
                        LEFT JOIN facturas_cfdi m ON k.id=m.id_factura                                
                        LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id                                
                        LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal   
                        LEFT JOIN cxc p ON p.id=pre.id_cxc                                 
                        LEFT JOIN cat_unidades_negocio q ON p.id_unidad_negocio=q.id                                
                        LEFT JOIN sucursales r ON p.id_sucursal=r.id_sucursal
                        LEFT JOIN razones_sociales s ON k.id_razon_social=s.id

                        WHERE 1 

                        GROUP BY pre.id,pre.id_cxc                              
                        ORDER BY pre.id DESC -- **"; // ,pre.id_cxc desc

                        
                }
            }

            // echo $query;
            // exit();           

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
            //return $query;
        }

        if($modulo == 'DASH_FINANZAS_OTROS_INGRESOS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idEmpresaFiscal = $arreglo['idEmpresaFiscal'];
            $fecha = isset($arreglo['fecha']) ? $arreglo['fecha'] : '';

            $unidad='';
            $sucursal='';
            $empresa_fiscal='';
            $condFecha='';

            if($idUnidadNegocio != '')
            {
                if($idUnidadNegocio[0] == ',')
                {
                    $dato=substr($idUnidadNegocio,1);
                    $unidad = ' AND a.id_unidad_negocio IN('.$dato.') ';
                }else{ 
                    $unidad = ' AND a.id_unidad_negocio ='.$idUnidadNegocio;
                }
            }

            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }

            if($idEmpresaFiscal != '')
            {
                $empresa_fiscal = ' AND a.id_empresa_fiscal = '.$idEmpresaFiscal;
            }
            
            if($fecha != '')
            {
                $condFecha = " AND DATE_FORMAT(DATE(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo)), '%Y-%m') = '$fecha'";
            }

            $query = "SELECT 
            a.id AS ID,
            un.nombre AS UNIDAD_NEGOCIO,
            s.descr AS SUCURSAL,
            YEAR(IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) AS ANIO,
            MONTH(IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) AS MES,
            IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo ) AS FECHA,
            IFNULL(IF(a.id_razon_social>0,f.nombre_corto,e.nombre_corto),'') AS NOMBRE_CORTO,
            IFNULL(IF(a.id_razon_social>0,f.razon_social,e.razon_social),'') AS CLIENTE,
            IF(a.folio_venta>0,a.folio_venta,IF(a.id_plan>0,a.folio_recibo,IF(a.id_orden_servicio>0,a.id_orden_servicio,a.folio_cxc)))AS FOLIO,
            IF(a.id_venta>0,'VENTA',IF(a.id_plan>0,'PLAN',IF(a.id_orden_servicio>0,'ORDEN','')))AS TIPO,
            FORMAT(a.subtotal,2) AS SUBTOTAL,
            FORMAT(IFNULL(SUM(IF(a.estatus NOT IN ( 'C', 'P' ),IF(( SUBSTR( a.cve_concepto, 1, 1 ) = 'C' ),(a.total - a.retencion - a.descuento), 0 ),0 )),0 ),2) AS TOTAL            
            FROM cxc a
            LEFT JOIN cat_unidades_negocio un ON a.id_unidad_negocio=un.id
            LEFT JOIN sucursales s ON a.id_sucursal=s.id_sucursal
            LEFT JOIN notas_e b ON a.id_venta=b.id  
            LEFT JOIN servicios_ordenes c ON a.id_orden_servicio=c.id 
            LEFT JOIN servicios_bitacora_planes d ON a.id_plan=d.id
            LEFT JOIN servicios e ON a.id_razon_social_servicio=e.id
            LEFT JOIN razones_sociales f ON a.id_razon_social=f.id
            WHERE a.id_factura = 0 AND a.id_nota_credito = 0 
            $unidad $sucursal $empresa_fiscal $condFecha
            AND a.estatus IN('A','T','S') AND SUBSTR( a.cve_concepto, 1, 1 ) = 'C'
            GROUP BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo=='DASH_FINANZAS2'){

            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            // print_r($arreglo);
            // exit();
            
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idEmpresaFiscal = $arreglo['idEmpresaFiscal'];
            $fechaI = $arreglo['fechaI'];
            $fechaF = $arreglo['fechaF'];

            $unidad='';
            $sucursal='';
            $empresa_fiscal='';
            $condFecha='';
            $query='';

            if($idSucursal != ''){

                if($idUnidadNegocio != ''){
                    if($idUnidadNegocio[0] == ',')
                    {
                        $dato=substr($idUnidadNegocio,1);
                        $unidad = ' AND a.id_unidad_negocio IN('.$dato.') ';
                    }else{ 
                        $unidad = ' AND a.id_unidad_negocio ='.$idUnidadNegocio;
                    }
                }

                if($idSucursal[0] == ','){
                    $dato=substr($idSucursal,1);
                    $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
                }else{ 
                    $sucursal = ' AND a.id_sucursal ='.$idSucursal;
                }

                if($idEmpresaFiscal != 0){
                    $empresa_fiscal = ' AND a.id_empresa_fiscal = '.$idEmpresaFiscal;
                }
                
                if($fechaI == '' && $fechaF == '')
                {
                    $condFecha = " AND DATE(a.fecha) = DATE(NOW())";
                }else{
                    if($fechaF == ''){
                        $condFecha = " AND DATE(a.fecha) BETWEEN '$fechaI' AND DATE(NOW())";
                    }else{
                        $condFecha = " AND DATE(a.fecha) BETWEEN '$fechaI' AND '$fechaF'";
                    }
                }
                
                $query = "SELECT
                                pre.id,
                                k.estatus,
                                k.verificado,
                                n.nombre AS unidad_negocio,
                                o.descr AS sucursal,
                                pre.anio,
                                pre.mes,
                                pre.fecha_inicio,
                                pre.fecha_fin,
                                pre.fecha,
                                l.razon_social AS emisor,
                                razones_sociales.nombre_corto,
                                k.razon_social AS receptor,
                                IF(pre.id_factura_nota_credito=0,'Factura',IF(pre.id_factura_nota_credito>0,'Nota de Credito','')) AS tipo,
                                IF(k.id_factura_nota_credito=0,k.folio,xd.folio) AS folio_factura,
                                IFNULL(m.uuid_timbre,'') AS uuid,
                                pre.metodo_pago,
                                k.fecha,
                                DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) AS fecha_vencimiento,
                                k.dias_credito,
                                IF(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)>CURDATE(),'',DATEDIFF(CURDATE(),DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY))) AS dias_vencimiento,
                                SUM(pre.sub_total) AS sub_total,
                                SUM(pre.total_facturado) AS facturado,
                                SUM(pre.pagos_mensual) AS cobrado_facturado, 
                                SUM(pre.total_facturado)-SUM(pre.pagos_mensual) - SUM(pre.notas_mensual) AS saldo_facturado,
                                IF(k.estatus='C',0,k.importe_retencion) as importe_retencion,
                                pre.folios_pagos AS pagos,
                                IFNULL(pre.fecha_aplicacion_pago,'') AS fecha_de_abonos,
                                us.usuario                        
                            FROM
                            (
                                SELECT
                                    a.id,a.id_factura_nota_credito,MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio, a.fecha_inicio, a.fecha_fin,
                                    CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                                    IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion ),0),0)),0) AS total_facturado,
                                    IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0, a.total,0),0)),0) AS abonos_facturado,
                                    IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.subtotal),(a.subtotal)*-1),0)),0) AS sub_total,
                                    IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,(a.total - a.importe_retencion),(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,
                                    SUM(IFNULL(pagos.pagos_mensual, 0)) AS pagos_mensual,
                                    SUM(IFNULL(f_nc.notas_mensual, 0)) AS notas_mensual,
                                    IFNULL(pagos.folios_pagos,'') AS folios_pagos,
                                    IFNULL(f_nc.folios_notas,'') AS folios_notas,
                                    IF(SUM(IFNULL(pagos.pagos_mensual, 0))>0,pagos.fecha,f_nc.fecha) AS fecha_aplicacion_pago,
                                    a.id_capturo,
                                    a.metodo_pago
                                FROM facturas a
                                LEFT JOIN 
                                (
                                    SELECT 
                                        GROUP_CONCAT(a.folio,' ') as folios_pagos,
                                        b.id_factura,
                                        SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                                        DATE(MAX(a.fecha)) AS fecha
                                    FROM pagos_e a
                                    LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                                    LEFT JOIN facturas c ON b.id_factura=c.id
                                    GROUP BY b.id_factura

                                ) pagos ON a.id = pagos.id_factura 
                                LEFT JOIN 
                                (
                                    SELECT 
                                        GROUP_CONCAT(facturas.folio_nota_credito,' ') as folios_notas,
                                        facturas.id_factura_nota_credito  AS id_factura,
                                        SUM(IF(facturas.estatus IN ('A','T'), (facturas.total - facturas.importe_retencion ), 0)) AS notas_mensual,
                                        MAX(fecha) AS fecha
                                    FROM facturas 
                                    WHERE facturas.id_factura_nota_credito > 0 AND facturas.estatus IN ('A','T')
                                    GROUP BY facturas.id_factura_nota_credito
                                    
                                )f_nc ON a.id =  f_nc.id_factura
                                WHERE 1 $unidad $sucursal $empresa_fiscal $condFecha
                                GROUP BY a.id
                            ) AS pre
                            LEFT JOIN facturas k ON pre.id=k.id
                            LEFT JOIN facturas xd ON k.id_factura_nota_credito=xd.id
                            LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                            LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                            LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                            LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                            left join razones_sociales on k.id_razon_social = razones_sociales.id
                            left join usuarios us ON us.id_usuario = pre.id_capturo
                            WHERE pre.id_factura_nota_credito = 0
                            GROUP BY pre.id
                            ORDER BY pre.id DESC";

                // echo $query;
                // exit();

            }

            // echo $query;
            // exit();           

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
            //return $query;
        }

        if($modulo=='DASH_FINANZAS3'){

            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            // print_r($arreglo);
            // exit();
            
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idEmpresaFiscal = $arreglo['idEmpresaFiscal'];
            $fechaI = $arreglo['fechaI'];
            $fechaF = $arreglo['fechaF'];

            $unidad='';
            $sucursal='';
            $empresa_fiscal='';
            $condFecha='';
            $query='';

            if($idSucursal != ''){

                if($idUnidadNegocio != ''){
                    if($idUnidadNegocio[0] == ',')
                    {
                        $dato=substr($idUnidadNegocio,1);
                        $unidad = ' AND a.id_unidad_negocio IN('.$dato.') ';
                    }else{ 
                        $unidad = ' AND a.id_unidad_negocio ='.$idUnidadNegocio;
                    }
                }

                if($idSucursal[0] == ','){
                    $dato=substr($idSucursal,1);
                    $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
                }else{ 
                    $sucursal = ' AND a.id_sucursal ='.$idSucursal;
                }

                if($idEmpresaFiscal != 0){
                    $empresa_fiscal = ' AND a.id_empresa_fiscal = '.$idEmpresaFiscal;
                }
                
                if($fechaI == '' && $fechaF == '')
                {
                    $condFecha = " AND DATE(a.fecha) = DATE(NOW())";
                }else{
                    if($fechaF == ''){
                        $condFecha = " AND DATE(a.fecha) BETWEEN '$fechaI' AND DATE(NOW())";
                    }else{
                        $condFecha = " AND DATE(a.fecha) BETWEEN '$fechaI' AND '$fechaF'";
                    }
                }
                
                $query = "SELECT
                                pre.id,
                                k.estatus,
                                k.verificado,
                                n.nombre AS unidad_negocio,
                                o.descr AS sucursal,
                                pre.anio,
                                pre.mes,
                                pre.fecha_inicio,
                                pre.fecha_fin,
                                pre.fecha,
                                l.razon_social AS emisor,
                                razones_sociales.nombre_corto,
                                k.razon_social AS receptor,
                                IF(pre.id_factura_nota_credito=0,'Factura',IF(pre.id_factura_nota_credito>0,'Nota de Credito','')) AS tipo,
                                IF(k.id_factura_nota_credito=0,k.folio,xd.folio) AS folio_factura,
                                IFNULL(k.folio_nota_credito, '') as folio_nota_credito,
                                IFNULL(m.uuid_timbre,'') AS uuid,
                                pre.metodo_pago,
                                k.fecha,
                                DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) AS fecha_vencimiento,
                                k.dias_credito,
                                IF(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)>CURDATE(),'',DATEDIFF(CURDATE(),DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY))) AS dias_vencimiento,
                                SUM(pre.sub_total) AS sub_total,
                                SUM(pre.total_facturado) AS facturado,
                                SUM(pre.pagos_mensual) AS cobrado_facturado, 
                                SUM(pre.total_facturado)-SUM(pre.pagos_mensual) - SUM(pre.notas_mensual) AS saldo_facturado,
                                k.importe_retencion,
                                pre.folios_pagos AS pagos,
                                IFNULL(pre.fecha_aplicacion_pago,'') AS fecha_de_abonos,
                                us.usuario                        
                            FROM
                            (
                                SELECT
                                    a.id,a.id_factura_nota_credito,MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio, a.fecha_inicio, a.fecha_fin,
                                    CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                                    IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion ),0),0)),0) AS total_facturado,
                                    IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0, a.total,0),0)),0) AS abonos_facturado,
                                    IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.subtotal),(a.subtotal)*-1),0)),0) AS sub_total,
                                    IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,(a.total - a.importe_retencion),(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,
                                    SUM(IFNULL(pagos.pagos_mensual, 0)) AS pagos_mensual,
                                    SUM(IFNULL(f_nc.notas_mensual, 0)) AS notas_mensual,
                                    IFNULL(pagos.folios_pagos,'') AS folios_pagos,
                                    IFNULL(f_nc.folios_notas,'') AS folios_notas,
                                    IF(SUM(IFNULL(pagos.pagos_mensual, 0))>0,pagos.fecha,f_nc.fecha) AS fecha_aplicacion_pago,
                                    a.id_capturo,
                                    a.metodo_pago
                                FROM facturas a
                                LEFT JOIN 
                                (
                                    SELECT 
                                        GROUP_CONCAT(a.folio,' ') as folios_pagos,
                                        b.id_factura,
                                        SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                                        DATE(MAX(a.fecha)) AS fecha
                                    FROM pagos_e a
                                    LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                                    LEFT JOIN facturas c ON b.id_factura=c.id
                                    GROUP BY b.id_factura

                                ) pagos ON a.id = pagos.id_factura 
                                LEFT JOIN 
                                (
                                    SELECT 
                                        GROUP_CONCAT(facturas.folio_nota_credito,' ') as folios_notas,
                                        facturas.id_factura_nota_credito  AS id_factura,
                                        SUM(IF(facturas.estatus IN ('A','T'), (facturas.total - facturas.importe_retencion ), 0)) AS notas_mensual,
                                        MAX(fecha) AS fecha
                                    FROM facturas 
                                    WHERE facturas.id_factura_nota_credito > 0 AND facturas.estatus IN ('A','T')
                                    GROUP BY facturas.id_factura_nota_credito
                                    
                                )f_nc ON a.id =  f_nc.id_factura
                                WHERE 1 $unidad $sucursal $empresa_fiscal $condFecha
                                GROUP BY a.id
                            ) AS pre
                            LEFT JOIN facturas k ON pre.id=k.id
                            LEFT JOIN facturas xd ON k.id_factura_nota_credito=xd.id
                            LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                            LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                            LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                            LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                            left join razones_sociales on k.id_razon_social = razones_sociales.id
                            left join usuarios us ON us.id_usuario = pre.id_capturo
                            WHERE pre.id_factura_nota_credito > 0
                            GROUP BY pre.id
                            ORDER BY pre.id DESC";

                // echo $query;
                // exit();

            }

            // echo $query;
            // exit();           

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
            //return $query;
        }

        if($resultado){

            $registro = mysqli_fetch_array($resultado);
            $columnas = sizeof($registro)/2;
            $campos = array_keys($registro);
            $html.="<h4>&nbsp;&nbsp;&nbsp;&nbsp;".$nombre." ".$fecha."</h4>";
            $html.="<table border='1'><thead><tr>";
            $cont=0;
            foreach($campos as $campo)
            {
                if(is_string($campo))
                {
                $campos2[$cont] = $campo;
            
                $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>".$campo."</td>";
                $cont++;
                }
            }
            $html.="</tr></thead><tbody>";
            $resultado = mysqli_query( $this->link, $query);
            
            
            $saldo=0;  
            while($registro = mysqli_fetch_array($resultado))
            {
                $html.="<tr class='renglon'>";

                if($modulo == 'ESTADO_DE_CUENTA_CXP')
                {
                    $cargos=$registro['CARGOS'];
                    $abonos=$registro['ABONOS'];
                    $saldo = $saldo + $cargos -$abonos;

                }

                foreach($campos2 as $field)
                {
                    
                    $texto = $registro[$field];

                    if($modulo == 'ESTADO_DE_CUENTA_CXP')
                    {
                        if($field=='SALDO'){
                            $html.="<td valign='top'>".$saldo."</td>";
                        }else{
                            $html.="<td valign='top'>".$texto."</td>";
                        }

                    }else
                    {

                        if(strstr($field, 'CLABE' ) )
                            $html.="<td valign='top'>" . $texto . '&nbsp;' . "</td>";                            
                        else
                            $html.="<td valign='top'>" . $texto  . "</td>";

                    }
                            
                }

                $html.="</tr>";
            }

            $html.="</tbody></table>";
            
        }else{
            $html.="Error, en el Query";
        }

        return $html;
    }//-- fin function generaExcel
    
}//--fin de class Excel
    
?>