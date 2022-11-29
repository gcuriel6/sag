<?php

include 'conectar.php';

class Finanzas
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Finanzas()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los registros de dash gastos segun el tipo de informacion que se requiere
      * 
      * @param varchar $datos array que contiene los datos para la busqueda
      * idUnidadNegocio
      * idSucursal
      * idEmpresaFiscal
      * mes
      * anio
      * tipo    1= totales    2=detalle
      *
    **/
    function buscarDashFinanzas($datos){

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $fecha = isset($datos['fecha']) ? $datos['fecha'] : '';
        $tipoRenglon = isset($datos['tipoRenglon']) ? $datos['tipoRenglon'] : '';
        $tipo = $datos['tipo'];
        $verificado = isset($datos['verificado']) ? $datos['verificado'] : '';

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

        if($idSucursal != '')
        {
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
                        -- SUM( pre.pagos_mensual )+ SUM( pre.notas_mensual ) AS cobrado_facturado,
                        SUM( pre.total_facturado )-(
                        SUM( pre.pagos_mensual )+ SUM( pre.notas_mensual )) AS saldo_facturado,
                        SUM( pre.abonos_facturado + pre.total_pagos + pre.abonos_otros_ingresos ) AS cobranza_mes,
                        SUM( pre.total_otros_ingresos ) AS total_otros_ingresos,
                        SUM( pre.abonos_otros_ingresos ) AS abonos_otros_ingresos,
                        SUM( pre.saldo_otros_ingresos ) AS saldo_otros_ingresos,
                        pre.pagos_mensualII AS cobrado_facturado
                    FROM
                        (
                    /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                    SELECT IF(a.es_plan=1,MONTH(a.fecha_inicio),MONTH( a.fecha )) AS mes,                            
                            IF(a.es_plan=1,YEAR(a.fecha_inicio),YEAR ( a.fecha )) AS anio,                            
                            CONCAT(IF(IF(a.es_plan=1,MONTH(a.fecha_inicio),MONTH(a.fecha)) < 10,CONCAT('0',IF(a.es_plan=1,MONTH(a.fecha_inicio),MONTH( a.fecha ))),IF(a.es_plan=1,MONTH(a.fecha_inicio),MONTH( a.fecha ))),'-',IF(a.es_plan=1,YEAR(a.fecha_inicio),YEAR( a.fecha ))) AS fecha,
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
                        -- para el total de lo facturado
                        /*cambie el INNER por LEFT*/
                        LEFT JOIN 
                        (       
                            SELECT 
                            IF(a.es_plan=1,YEAR(a.fecha_inicio),YEAR(a.fecha))AS anio,                            
		                    IF(a.es_plan=1,MONTH(a.fecha_inicio),MONTH(a.fecha)) AS nes,
                            SUM(IF(a.estatus IN ('A','T') AND pagos_e.estatus IN ('A', 'T'),pagos_d.importe_pagado,0)) AS pagos_mensual
                            FROM facturas a
                            LEFT JOIN  pagos_d  ON a.id = pagos_d.id_factura 
                            LEFT JOIN pagos_e  ON pagos_d.id_pago_e = pagos_e.id  
                            WHERE 1 $unidad $sucursal $empresa_fiscal
                            GROUP BY IF(a.es_plan=1,YEAR(a.fecha_inicio),YEAR(a.fecha)), IF(a.es_plan=1,MONTH(a.fecha_inicio),MONTH(a.fecha)) 
                        ) pagado_actual ON IF(a.es_plan=1,YEAR(a.fecha_inicio),YEAR(a.fecha)) = pagado_actual.anio AND  IF(a.es_plan=1,MONTH(a.fecha_inicio),MONTH(a.fecha)) = pagado_actual.nes
                        -- para el total de lo facturado
                        WHERE
                            1 $unidad $sucursal $empresa_fiscal
                            AND a.estatus IN ('A','T')                         
	                        GROUP BY IF(a.es_plan=1,YEAR(a.fecha_inicio),YEAR( a.fecha )),IF(a.es_plan=1,MONTH(a.fecha_inicio),MONTH( a.fecha ))
                    /* ESTE OBTIENE LO DE OTROS INGRESO DE CXC POR MES*/
                        UNION ALL
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
                            AND a.estatus IN('A','T','S')
                        GROUP BY
                            YEAR (
                            IF
                            ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )),
                            MONTH (
                            IF
                            ( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) UNION ALL
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
                            a.estatus IN ('T','A') 
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
                        WHERE MONTH(DATE( a.fecha ))= MONTH(IF(c.es_plan=1,DATE(c.fecha_inicio),DATE( c.fecha ))) 
                            $unidad $sucursal $empresa_fiscal
                            AND a.estatus IN('A','T') 
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
                {
                        $query = "SELECT pre.id,
                        k.estatus,
                        k.verificado,
                        n.nombre AS unidad_negocio,
                        o.descr AS sucursal,
                        pre.anio,
                        pre.mes,
                        pre.fecha,
                        l.razon_social AS emisor,
                        k.razon_social AS receptor,
                        k.folio,
                        IFNULL(m.uuid_timbre,'') AS uuid,
                        k.fecha,
                        IFNULL(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY),'') AS fecha_vencimiento,
                        k.dias_credito,
                        IFNULL(IF(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)>CURDATE(),'',DATEDIFF(CURDATE(),DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY))),'') AS dias_vencimiento,
                        SUM(pre.subtotal_facturado) AS subtotal,
                        SUM(pre.total_facturado) AS facturado,
                        SUM(pre.pagos_mensual) AS cobrado_facturado, 
                        SUM(pre.total_facturado)-SUM(pre.pagos_mensual) - SUM(pre.notas_mensual) AS saldo_facturado,-- SUM(pre.total_facturado)-SUM(pre.pagos_mensual) AS saldo_facturado,
                        SUM(pre.notas_mensual) AS notas_credito,
                        IFNULL(pre.fecha_aplicacion_pago,'') AS fecha_aplicacion_pago
                        FROM
                        (/*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                        SELECT a.id,MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio,
                        CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                         IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.subtotal),0),0)),0) AS subtotal_facturado, 
                        IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion ),0),0)),0) AS total_facturado,
                        IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0, a.total,0),0)),0) AS abonos_facturado,
                        IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,(a.total - a.importe_retencion),(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,
                        SUM(IFNULL(pagos.pagos_mensual, 0)) AS pagos_mensual,
                        SUM(IFNULL(f_nc.notas_mensual, 0)) AS notas_mensual,-- f_nc.notas_mensual
                        IF(SUM(IFNULL(pagos.pagos_mensual, 0))>0,pagos.fecha,f_nc.fecha) AS fecha_aplicacion_pago
                        FROM facturas a

                        LEFT JOIN 
                        (

                            SELECT 
                            b.id_factura,
                            SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                            DATE(MAX(a.fecha)) AS fecha
                            FROM pagos_e a
                            LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                            LEFT JOIN facturas c ON b.id_factura=c.id
                            GROUP BY b.id_factura

                        ) pagos ON a.id = pagos.id_factura -- join to pagos

                        LEFT JOIN 
                        (
                            SELECT 
                            facturas.id_factura_nota_credito  AS id_factura,
                            SUM(IF(facturas.estatus IN ('A','T'), (facturas.total - facturas.importe_retencion ), 0)) AS notas_mensual,
                            MAX(fecha) AS fecha
                            FROM facturas 
                            WHERE facturas.id_factura_nota_credito > 0 AND facturas.estatus IN ('A','T')
                            GROUP BY facturas.id_factura_nota_credito

                            
                        )f_nc ON a.id =  f_nc.id_factura

                        WHERE 1 $unidad $sucursal $empresa_fiscal $condFecha $verif AND a.estatus IN('A','T')
                        GROUP BY a.id
                        /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
                        ) AS pre
                        LEFT JOIN facturas k ON pre.id=k.id
                        LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                        LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                        LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                        LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                        GROUP BY pre.id
                        ORDER BY pre.id DESC";

                        // echo $query;
                        // exit();
                }else{


                    $query = " SELECT pre.id,   
                        pre.id_cxc,                             
                        IF(pre.id_cxc > 0,p.estatus,k.estatus) AS estatus,                                
                        IFNULL(k.verificado,'') AS verificado, 
                        IF(pre.id_cxc > 0,q.nombre,n.nombre) AS unidad_negocio, 
                        IF(pre.id_cxc > 0,r.descr,o.descr) AS sucursal,                            
                        pre.anio,                                
                        pre.mes,                                
                        pre.fecha,                                
                        IFNULL(l.razon_social,'') AS emisor,                                
                        IF(pre.id_cxc > 0,s.razon_social,k.razon_social) AS receptor, 
                        IF(pre.id_cxc > 0,p.folio_cxc,k.folio) AS folio,                                
                        IFNULL(IF(pre.id_cxc > 0,'',m.uuid_timbre),'') AS uuid,  
                        IF(pre.id_cxc > 0,p.fecha,k.fecha) AS fecha,    
                        IFNULL(IF(pre.id_cxc > 0,p.vencimiento,DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)),'') AS fecha_vencimiento,                                
                        IF(pre.id_cxc > 0,s.dias_cred,k.dias_credito) AS dias_credito,      
                        IFNULL(IF(pre.id_cxc > 0,IF(p.vencimiento>CURDATE(),0,DATEDIFF(CURDATE(),p.vencimiento)),                          
                        IF(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)>CURDATE(),0,DATEDIFF(CURDATE(),DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)))),'') AS dias_vencimiento,                                
                        SUM(pre.subtotal_facturado) AS subtotal, 
                        SUM(pre.total_facturado)+SUM(pre.total_otros_ingresos) AS facturado,                                
                        SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)+SUM(pre.abonos_otros_ingresos) AS cobrado_facturado,                                
                        (SUM(pre.total_facturado)+SUM(pre.total_otros_ingresos))-(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)+SUM(pre.saldo_otros_ingresos)) AS saldo_facturado,                                
                        SUM(pre.notas_mensual) AS notas_credito                                
                        FROM                                    
                        (/*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/                                    
                        SELECT 
                        a.id,
                        0 AS id_cxc, 
                        MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio,                                    
                        CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,   
                        IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.subtotal),0),0)),0) AS subtotal_facturado,                                 
                        IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion),0),0)),0) AS total_facturado,                                    
                        IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado,                                    
                        IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion) ,(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,                                    
                        SUM(IFNULL(pagos.pagos_mensual, 0)) AS pagos_mensual,                                    
                        SUM(IFNULL(f_nc.notas_mensual, 0)) AS notas_mensual,
                        0 AS total_otros_ingresos,
                        0 AS abonos_otros_ingresos,
                        0 AS saldo_otros_ingresos                                   
                        FROM facturas a                     

                        INNER JOIN 
                        (

                        SELECT 
                        b.id_factura,
                        SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual
                        FROM pagos_e a
                        LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                        LEFT JOIN facturas c ON b.id_factura=c.id
                        WHERE 1 $unidad $sucursal $empresa_fiscal $condFecha    
                        GROUP BY b.id_factura

                        ) pagos ON a.id = pagos.id_factura 

                        LEFT JOIN 
                        (
                        SELECT 
                        a.id_factura_nota_credito AS id_factura,
                        SUM(IF(a.estatus IN ('A','T'), (a.total - a.importe_retencion ), 0)) AS notas_mensual
                        FROM facturas a
                        WHERE a.id_factura_nota_credito > 0 AND a.estatus IN ('A','T') $unidad $sucursal $empresa_fiscal $condFecha 
                        GROUP BY a.id_factura_nota_credito  
                        )f_nc ON a.id =  f_nc.id_factura

                        WHERE 1   $unidad $sucursal $empresa_fiscal  AND a.estatus IN ('A','T')                                 
                        GROUP BY a.id                            
                        ) AS pre                                
                        LEFT JOIN facturas k ON pre.id=k.id                                
                        LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa                                
                        LEFT JOIN facturas_cfdi m ON k.id=m.id_factura                                
                        LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id                                
                        LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal   
                        LEFT JOIN cxc p ON p.id=pre.id_cxc                                 
                        LEFT JOIN cat_unidades_negocio q ON p.id_unidad_negocio=q.id                                
                        LEFT JOIN sucursales r ON p.id_sucursal=r.id_sucursal
                        LEFT JOIN razones_sociales s ON p.id_razon_social=s.id

                        WHERE 1 

                        GROUP BY pre.id,pre.id_cxc                              
                        ORDER BY pre.id DESC"; // ,pre.id_cxc desc

                }
            }

            // echo $query;
            // exit();

            $result = $this->link->query($query);

            return query2json($result);

        }else{
            
            $arr = array();
            $arr[] = '';

            return json_encode($arr);
        }
    }//- fin function buscarDashFinanzas

    function guardarVerificadoIdFactura($datos){
        $verifica = 0;
  
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");
   
        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("COMMIT;");
        else
            $this->link->query('ROLLBACK;');

        return $verifica;
    }//- fin function guardarVerificadoIdFactura

    function guardarActualizar($datos){
        $verifica = 0;

        $idFactura = $datos['idFactura'];
        $valor = $datos['valor'];

        $query = "UPDATE facturas SET verificado='$valor' WHERE id=".$idFactura;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
            $verifica=1;
        
        return $verifica;
    }//- fin function guardarActualizar

    function buscarDettaleOtrosIngresos($datos){
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $fecha = isset($datos['fecha']) ? $datos['fecha'] : '';

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
                    a.id AS id_cxc,
                    IF(a.id_venta>0,'VENTA',IF(a.id_plan>0,'PLAN',IF(a.id_orden_servicio>0,'ORDEN','')))AS tipo,
                    IF(a.folio_venta>0,a.folio_venta,IF(a.id_plan>0,a.folio_recibo,IF(a.id_orden_servicio>0,a.id_orden_servicio,a.folio_cxc)))AS folio,
                    MONTH(IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) AS mes,
                    YEAR(IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) AS anio,
                    CONCAT(IF(MONTH (IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo )) < 10,
                        CONCAT('0',MONTH(IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo ))),
                        MONTH (IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo ))),'-',YEAR (
                    IF( a.id_plan = 0, a.fecha, a.fecha_corte_recibo ))) AS fecha,
                    IFNULL(SUM(IF(a.estatus NOT IN ( 'C', 'P' ),IF(( SUBSTR( a.cve_concepto, 1, 1 ) = 'C' ),(a.total - a.retencion - a.descuento), 0 ),0 )),0 ) AS total_otros_ingresos,
                    a.total AS total,
                    a.subtotal AS subtotal, 
                    a.tasa_iva AS porcentaje_iva,
                    IFNULL(IF(a.id_razon_social>0,f.razon_social,e.razon_social),'') AS cliente,
                    e.nombre_corto AS nombre_corto_servicio,
                    e.razon_social as razon_social_servicio,
                    f.nombre_corto,
                    f.razon_social,
                    un.nombre AS unidad_negocio,
                    s.descr AS sucursal
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

        $result = $this->link->query($query);

        return query2json($result);
    }

    function buscarDashFinanzas2($datos){

        $idUnidadNegocio = $datos['idUnidad'];
        $idSucursal = $datos['idSucursal'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $fechaI = $datos['fechaI'];
        $fechaF = $datos['fechaF'];

        $unidad='';
        $sucursal='';
        $empresa_fiscal='';
        $condFecha='';
        $query='';

        if($idSucursal != ''){
            if($idUnidadNegocio != ''){
                if($idUnidadNegocio[0] == ','){
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

            // if(fechaI == "" && fechaF != "")
            
            if($fechaI == '' && $fechaF == ''){
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
                        pre.fecha,
                        l.razon_social AS emisor,
                        k.razon_social AS receptor,
                        k.folio,
                        IFNULL(m.uuid_timbre,'') AS uuid,
                        k.fecha,
                        IFNULL(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY),'') AS fecha_vencimiento,
                        k.dias_credito,
                        IFNULL(IF(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)>CURDATE(),'',DATEDIFF(CURDATE(),DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY))),'') AS dias_vencimiento,
                        SUM(pre.subtotal_facturado) AS subtotal,
                        SUM(pre.total_facturado) AS facturado,
                        SUM(pre.pagos_mensual) AS cobrado_facturado, 
                        SUM(pre.total_facturado)-SUM(pre.pagos_mensual) - SUM(pre.notas_mensual) AS saldo_facturado,-- SUM(pre.total_facturado)-SUM(pre.pagos_mensual) AS saldo_facturado,
                        SUM(pre.notas_mensual) AS notas_credito,
                        IFNULL(pre.fecha_aplicacion_pago,'') AS fecha_aplicacion_pago
                        FROM
                        (/*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                        SELECT a.id,MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio,
                        CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                            IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.subtotal),0),0)),0) AS subtotal_facturado, 
                        IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion ),0),0)),0) AS total_facturado,
                        IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0, a.total,0),0)),0) AS abonos_facturado,
                        IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,(a.total - a.importe_retencion),(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,
                        SUM(IFNULL(pagos.pagos_mensual, 0)) AS pagos_mensual,
                        SUM(IFNULL(f_nc.notas_mensual, 0)) AS notas_mensual,-- f_nc.notas_mensual
                        IF(SUM(IFNULL(pagos.pagos_mensual, 0))>0,pagos.fecha,f_nc.fecha) AS fecha_aplicacion_pago
                    FROM facturas a
                    LEFT JOIN 
                    (
                        SELECT 
                        b.id_factura,
                        SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                        DATE(MAX(a.fecha)) AS fecha
                        FROM pagos_e a
                        LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                        LEFT JOIN facturas c ON b.id_factura=c.id
                        GROUP BY b.id_factura
                    ) pagos ON a.id = pagos.id_factura -- join to pagos
                    LEFT JOIN 
                    (
                        SELECT 
                        facturas.id_factura_nota_credito  AS id_factura,
                        SUM(IF(facturas.estatus IN ('A','T'), (facturas.total - facturas.importe_retencion ), 0)) AS notas_mensual,
                        MAX(fecha) AS fecha
                        FROM facturas 
                        WHERE facturas.id_factura_nota_credito > 0 AND facturas.estatus IN ('A','T')
                        GROUP BY facturas.id_factura_nota_credito                        
                    )f_nc ON a.id =  f_nc.id_factura
                    WHERE 1 $unidad $sucursal $empresa_fiscal $condFecha AND a.estatus IN('A','T')
                    AND a.id_factura_nota_credito=0
                    GROUP BY a.id
                    ) AS pre
                    LEFT JOIN facturas k ON pre.id=k.id
                    LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                    LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                    LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                    LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                    GROUP BY pre.id
                    ORDER BY pre.id DESC";

            // echo $query;
            // exit();

            $result = $this->link->query($query);

            return query2json($result);

        }else{
            
            $arr = array();
            $arr[] = '';

            return json_encode($arr);
        }
    }//- fin function buscarDashFinanzas2

    function buscarDashFinanzas3($datos){

        $idUnidadNegocio = $datos['idUnidad'];
        $idSucursal = $datos['idSucursal'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $fechaI = $datos['fechaI'];
        $fechaF = $datos['fechaF'];

        $unidad='';
        $sucursal='';
        $empresa_fiscal='';
        $condFecha='';
        $query='';

        if($idSucursal != ''){
            if($idUnidadNegocio != ''){
                if($idUnidadNegocio[0] == ','){
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

            // if(fechaI == "" && fechaF != "")
            
            if($fechaI == '' && $fechaF == ''){
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
                        pre.fecha,
                        l.razon_social AS emisor,
                        k.razon_social AS receptor,
                        k.folio,
                        IFNULL(m.uuid_timbre,'') AS uuid,
                        k.fecha,
                        IFNULL(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY),'') AS fecha_vencimiento,
                        k.dias_credito,
                        IFNULL(IF(DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY)>CURDATE(),'',DATEDIFF(CURDATE(),DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY))),'') AS dias_vencimiento,
                        SUM(pre.subtotal_facturado) AS subtotal,
                        SUM(pre.total_facturado) AS facturado,
                        SUM(pre.pagos_mensual) AS cobrado_facturado, 
                        SUM(pre.total_facturado)-SUM(pre.pagos_mensual) - SUM(pre.notas_mensual) AS saldo_facturado,-- SUM(pre.total_facturado)-SUM(pre.pagos_mensual) AS saldo_facturado,
                        SUM(pre.notas_mensual) AS notas_credito,
                        IFNULL(pre.fecha_aplicacion_pago,'') AS fecha_aplicacion_pago
                        FROM
                        (/*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                            SELECT a.id,MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio,
                            CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                            IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.subtotal),0),0)),0) AS subtotal_facturado, 
                            IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion ),0),0)),0) AS total_facturado,
                            IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0, a.total,0),0)),0) AS abonos_facturado,
                            IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,(a.total - a.importe_retencion),(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,
                            SUM(IFNULL(pagos.pagos_mensual, 0)) AS pagos_mensual,
                            SUM(IFNULL(f_nc.notas_mensual, 0)) AS notas_mensual,-- f_nc.notas_mensual
                            IF(SUM(IFNULL(pagos.pagos_mensual, 0))>0,pagos.fecha,f_nc.fecha) AS fecha_aplicacion_pago
                        FROM facturas a
                        LEFT JOIN 
                        (
                            SELECT 
                            b.id_factura,
                            SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                            DATE(MAX(a.fecha)) AS fecha
                            FROM pagos_e a
                            LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                            LEFT JOIN facturas c ON b.id_factura=c.id
                            GROUP BY b.id_factura
                        ) pagos ON a.id = pagos.id_factura -- join to pagos
                        LEFT JOIN 
                        (
                            SELECT 
                            facturas.id_factura_nota_credito  AS id_factura,
                            SUM(IF(facturas.estatus IN ('A','T'), (facturas.total - facturas.importe_retencion ), 0)) AS notas_mensual,
                            MAX(fecha) AS fecha
                            FROM facturas 
                            WHERE facturas.id_factura_nota_credito > 0 AND facturas.estatus IN ('A','T')
                            GROUP BY facturas.id_factura_nota_credito                        
                        )f_nc ON a.id =  f_nc.id_factura
                        WHERE 1 $unidad $sucursal $empresa_fiscal $condFecha AND a.estatus IN('A','T')
                        AND a.id_factura_nota_credito>0
                        GROUP BY a.id
                        ) AS pre
                    LEFT JOIN facturas k ON pre.id=k.id
                    LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                    LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                    LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                    LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                    GROUP BY pre.id
                    ORDER BY pre.id DESC";

            // echo $query;
            // exit();

            $result = $this->link->query($query);

            return query2json($result);

        }else{
            
            $arr = array();
            $arr[] = '';

            return json_encode($arr);
        }
    }//- fin function buscarDashFinanzas3
    
}//--fin de class Finanzas

/*}

$query = "SELECT pre.anio,IF(pre.mes<10,CONCAT('0',pre.mes),pre.mes) AS mes,pre.fecha,
                            SUM(pre.total_facturado) AS facturado,
                            SUM(pre.verificado) AS verificado,
                            SUM(pre.pagos_mensual)+SUM(pre.notas_mensual) AS cobrado_facturado,
                            SUM(pre.total_facturado)-(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)) AS saldo_facturado,
                            SUM(pre.abonos_facturado+pre.total_pagos+pre.abonos_otros_ingresos) AS cobranza_mes,
                            SUM(pre.total_otros_ingresos) AS total_otros_ingresos,
                            SUM(pre.abonos_otros_ingresos) AS abonos_otros_ingresos,
                            SUM(pre.saldo_otros_ingresos) AS saldo_otros_ingresos
                            FROM
                                (/*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**
                                SELECT MONTH(a.fecha) AS mes,YEAR(a.fecha) AS anio,
                                CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                                IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion),0),0)),0) AS total_facturado,
                                IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado,
                                IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0, (a.total - a.importe_retencion),(a.total - a.importe_retencion)*-1),0)),0) AS saldo_facturado,
                                IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.verificado='S',a.total,0),0)),0) AS verificado,
                                GROUP_CONCAT(a.id) AS id_facturas_mes,
                                0 AS total_pagos,
                                0 AS total_otros_ingresos,
                                0 AS abonos_otros_ingresos,
                                0 AS saldo_otros_ingresos,
                                0 AS pagos_mensual,
                                0 AS notas_mensual
                                FROM facturas a
                                WHERE 1 $unidad $sucursal $empresa_fiscal
                                GROUP BY YEAR(a.fecha),MONTH(a.fecha)
                                UNION ALL
                                /* ESTE OBTIENE LO DE OTROS INGRESO DE CXC POR MES*
                                SELECT MONTH(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo)) AS mes,
                                YEAR(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo)) AS anio,
                                CONCAT(IF(MONTH(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo)) < 10,CONCAT('0',MONTH(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo))),MONTH(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo))),'-',YEAR(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo))) AS fecha,
                                0 AS total_facturado,
                                0 AS abonos_facturado,
                                0 AS saldo_facturado,
                                0 AS verificado,
                                0 AS id_facturas_mes,
                                0 AS total_pagos,
                                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'), (a.total - a.retencion),0),0)),0) AS total_otros_ingresos,
                                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'A'),a.total,0),0)),0) AS abonos_otros_ingresos,
                                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'), (a.total - a.retencion),((a.total - a.retencion) * -(1))),0)),0) AS saldo_otros_ingresos,
                                0 AS pagos_mensual,
                                0 AS notas_mensual
                                FROM cxc a
                                WHERE a.id_factura=0 AND a.id_nota_credito=0 $unidad $sucursal 
                                GROUP BY YEAR(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo)),MONTH(IF(a.id_plan=0,a.fecha,a.fecha_corte_recibo))
                                UNION ALL
                                /* AQUI OBTINE LA INFORMACION DEL TOTAL DE PAGOS POR MES*
                                SELECT MONTH(DATE(a.fecha)) AS mes,
                                YEAR(DATE(a.fecha)) AS anio,
                                CONCAT(IF(MONTH(DATE(a.fecha)) < 10,CONCAT('0',MONTH(DATE(a.fecha))),MONTH(DATE(a.fecha))),'-',YEAR(DATE(a.fecha))) AS fecha,
                                0 AS total_facturado,
                                0 AS abonos_facturado,
                                0 AS saldo_facturado,
                                0 AS verificado,
                                0 AS id_facturas_mes,
                                IFNULL(SUM(b.importe_pagado),0) AS total_pagos,
                                0 AS total_otros_ingresos,
                                0 AS abonos_otros_ingresos,
                                0 AS saldo_otros_ingresos,
                                0 AS pagos_mensual,
                                0 AS notas_mensual
                                FROM pagos_e a
                                LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                                WHERE a.estatus='T' $unidad $sucursal $empresa_fiscal
                                GROUP BY YEAR(DATE(a.fecha)),MONTH(DATE(a.fecha))
                                /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*
                                UNION ALL
                                SELECT 
                                MONTH(DATE(a.fecha)) AS mes,
                                YEAR(DATE(a.fecha)) AS anio,
                                DATE_FORMAT(DATE(a.fecha), '%Y-%m') AS fecha,
                                0 AS total_facturado,
                                0 AS abonos_facturado,
                                0 AS saldo_facturado,
                                0 AS verificado,
                                0 AS id_facturas_mes,
                                0 AS total_pagos,
                                0 AS total_otros_ingresos,
                                0 AS abonos_otros_ingresos,
                                0 AS saldo_otros_ingresos,
                                SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                                0 AS notas_mensual
                                FROM pagos_e a
                                LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                                LEFT JOIN facturas c ON b.id_factura=c.id 
                                WHERE MONTH(DATE(a.fecha))=MONTH(DATE(c.fecha)) $unidad $sucursal $empresa_fiscal
                                GROUP BY DATE_FORMAT(a.fecha,'%Y-%m')
                                /* AQUI OPTINE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURAS DEL MES*
                                UNION ALL
                                SELECT 
                                MONTH(DATE(sub.fecha)) AS mes,
                                YEAR(DATE(sub.fecha)) AS anio,
                                DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha,
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
                                SUM(IF(sub.id=b.id_factura_nota_credito AND DATE_FORMAT(sub.fecha,'%Y-%m')=DATE_FORMAT(b.fecha,'%Y-%m'),b.total,0))AS notas_mensual
                                FROM (                    
                                    SELECT 
                                    a.id,folio,a.fecha,'F' AS tipo,a.id AS  id_factura,
                                    SUM(a.total) AS total 
                                    FROM facturas a
                                    WHERE  a.estatus IN('A','T') AND a.id_factura_nota_credito=0 $unidad $sucursal $empresa_fiscal
                                    GROUP BY a.id
                                )AS sub
                                LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito  AND b.estatus ='T'
                                GROUP BY DATE_FORMAT(sub.fecha,'%Y-%m')
                                /*FACTURAS CON SALDOS VENCIDOS (PRESUPUESTO_INGRESOS)*
                                
                                ) AS pre
                            GROUP BY pre.anio,pre.mes
                            ORDER BY pre.anio DESC,pre.mes DESC";
*/
    
?>