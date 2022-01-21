<?php

include 'conectar.php';

class PresupuestoIngresosSeguimiento
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function PresupuestoIngresosSeguimiento()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Buscamos registros y generamos archivo PresupuestoIngresosSeguimiento
      *
      * @param varchar $reporte para ver cual quert se va a generar
      * @param array $datos fltros para realizar el reporte
      *
    **/
    function obtieneTablaReporte($reporte,$datos){
       
        $idUnidad = $datos['idUnidad'];
        $idSucursal = $datos['idSucursal'];
        $idArea = $datos['idArea'];
        $idDepartamento = $datos['idDepartamento'];
        $mesInicial = $datos['mesInicial'];
        $mesFinal = $datos['mesFinal'];
        $anio = $datos['anio'];

        $condicionUnidad = "a.id_unidad_negocio=".$idUnidad;
        $condicionSucursal = "AND a.id_sucursal = ".$idSucursal;
        //$condicionMes = "AND (a.mes=".$mes." AND a.anio =".$anio.")"; 
        
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


        $condicionMes1 = ($mesFinal>0)?'   a.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
        $condicionMesS2 = ($mesFinal>0)?'   MONTH(a.fecha_captura) BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
        $condicionAnioS1 = ($anio>0)?" AND a.anio=".$anio :" ";
        $condicionAnioS2 = ($anio>0)?" AND YEAR(a.fecha_captura)=".$anio :" ";
        
        $condicionMes = " AND ($condicionMes1 $condicionAnioS1)";
      
        $html='';

        if($reporte == 'cxc'){

            $query = "SELECT 
                        tabla.folio_factura AS Factura,
                        FORMAT(IFNULL(SUM(tabla.presupuesto),0),2) AS Presupuesto,
                        FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS ejercido,
                        CONCAT(FORMAT(IF(SUM(tabla.presupuesto) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)),0),0),2),' %') AS PORCENTAJE
                        FROM (
                                SELECT 
                                a.id,
                                IFNULL(IF(a.folio_factura>0,a.folio_factura,''),'') AS folio_factura,
                                IF(a.cargo_inicial=1,a.total,0) AS presupuesto,
                                FORMAT(IFNULL(SUM(IF(a.estatus NOT IN('C'),IF((SUBSTR(e.cve_concepto,1,1) = 'A'),e.total,0),0)),0),2) AS ejercido,            
                                b.nombre AS unidad_negocio,
                                c.descr AS sucursal
                              FROM cxc a
                              LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id 
                              LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                              LEFT JOIN razones_sociales d ON a.id_razon_social = d.id
                              LEFT JOIN cxc e ON a.id=e.folio_cxc
                              WHERE $condicionUnidad $condicionSucursal $condicionMes AND a.estatus!='C' AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0
                              GROUP BY a.folio_cxc
                              HAVING presupuesto >0
                              UNION ALL
                              SELECT 
                                    pre.id,
                                    IFNULL(IF(k.folio>0,k.folio,''),'') AS folio_factura,
                                    SUM(pre.total_facturado) AS presupuesto,
                                    (SUM(pre.pagos_mensual)+SUM(pre.notas_mensual))AS ejercido,
                                    n.nombre AS unidad_negocio,
                                    o.descr AS sucursal
                              FROM (
                                    /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                                    SELECT 
                                            a.id,
                                            CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                                            IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total,0),0)),0) AS total_facturado,
                                            IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado,
                                            IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,a.total,(a.total)*-1),0)),0) AS saldo_facturado,
                                            0 AS pagos_mensual,
                                            0 AS notas_mensual
                                    FROM facturas a
                                    WHERE $condicionUnidad $condicionSucursal $condicionMes AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0
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
                                    WHERE $condicionUnidad AND a.id_sucursal=1 $condicionMes AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0
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
                                      WHERE  a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND $condicionUnidad $condicionSucursal $condicionMes AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0
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
                              HAVING presupuesto>0) as tabla
                              GROUP BY tabla.folio_factura";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        
        if($reporte == 'diario'){

           
            $fecha=$anio."-".$mesInicial."-01";

            $queryDias="SELECT dayofmonth(last_day('$fecha')) as dias_mes";
            $resultDias = mysqli_query($this->link, $queryDias)or die(mysqli_error());

            $condicionDias = ''; 
            $condicionFecha = '';

            if($resultDias){

                $rowD=mysqli_fetch_array($resultDias);

                $totalDias=$rowD['dias_mes'];

                for($j=1;$j<=$totalDias;$j++){
                   
                    $condicionDias.="FORMAT(IFNULL(SUM(tabla.d".$j."),0),2) AS D".$j.",";
                    $condicionDiasP.="0 AS D".$j.",";
                    $condicionFecha.="IF(DATE_FORMAT(a.fecha_captura,'%d')=".$j.",IFNULL(SUM(a.monto),0),0) AS d".$j.",";
                    $condicionDia1.="IF(DATE_FORMAT(a.fecha_captura,'%d')=".$j.",IFNULL(SUM(IF(SUBSTR(e.cve_concepto,1,1) = 'A',e.total,0)),0),0) AS d".$j.",";
                    $condicionDia2.="IF(DATE_FORMAT(pre.fecha_captura,'%d')=".$j.",IFNULL((SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)),0),0) AS d".$j.",";
                }
            } 

             
        
          $query = "SELECT 
            tabla.folio_factura AS Factura, 
            FORMAT(IFNULL(SUM(tabla.presupuesto),0),2) AS Presupuesto, 
            $condicionDias
            FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS ejercido, 
            CONCAT(FORMAT(IF(SUM(tabla.presupuesto) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)),0),0),2),' %') AS PORCENTAJE 
          FROM ( 
            SELECT 
              a.id, 
              a.fecha_captura,
              IFNULL(IF(a.folio_factura>0,a.folio_factura,''),'') AS folio_factura, 
              IF(a.cargo_inicial=1,a.total,0) AS presupuesto, 
              $condicionDia1
              FORMAT(IFNULL(IF(SUBSTR(e.cve_concepto,1,1) = 'A',e.total,0),0),2) AS ejercido, 
              b.nombre AS unidad_negocio, 
              c.descr AS sucursal 
            FROM cxc a 
            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id 
            LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal 
            LEFT JOIN razones_sociales d ON a.id_razon_social = d.id 
            LEFT JOIN cxc e ON a.id=e.folio_cxc 
            WHERE $condicionUnidad $condicionSucursal AND ( a.mes BETWEEN 12 AND 12 AND a.anio=2019) AND a.estatus!='C' AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0 
            GROUP BY a.folio_cxc 
            HAVING presupuesto >0 
            UNION ALL 
            SELECT 
              pre.id, 
              pre.fecha_captura, 
              IFNULL(IF(k.folio>0,k.folio,''),'') AS folio_factura, 
              SUM(pre.total_facturado) AS presupuesto, 
              $condicionDia2
              (SUM(pre.pagos_mensual)+SUM(pre.notas_mensual))AS ejercido, 
              n.nombre AS unidad_negocio, 
              o.descr AS sucursal 
            FROM ( 
              /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/ 
              SELECT 
                a.id, 
                a.fecha AS fecha_captura, 
                CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha, 
                IFNULL(SUM(IF(a.estatus IN ('A','T'),
                IF(a.id_factura_nota_credito=0,a.total,0),0)),0) AS total_facturado, 
                IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado, 
                IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,a.total,(a.total)*-1),0)),0) AS saldo_facturado, 
                0 AS pagos_mensual, 
                0 AS notas_mensual 
              FROM facturas a 
              WHERE $condicionUnidad $condicionSucursal AND ( a.mes BETWEEN 12 AND 12 AND a.anio=2019) AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 
              GROUP BY a.id 
              /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/ 
              UNION ALL 
              SELECT 
                b.id_factura, 
                c.fecha_captura, 
                DATE_FORMAT(DATE(c.fecha), '%Y-%m') AS fecha, 
                0 AS total_facturado, 
                0 AS abonos_facturado, 
                0 AS saldo_facturado, 
                SUM(IF(a.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual, 
                0 AS notas_mensual 
              FROM pagos_e c 
              LEFT JOIN pagos_d b ON c.id=b.id_pago_e 
              LEFT JOIN facturas a ON b.id_factura=a.id 
              WHERE $condicionUnidad AND a.id_sucursal=1 AND ( a.mes BETWEEN 12 AND 12 AND a.anio=2019) AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 
              GROUP BY b.id_factura 
              /* AQUI OBTINE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/ 
              UNION ALL 
              SELECT 
                sub.id_factura, 
                sub.fecha_captura, 
                DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha, 
                0 AS total_facturado, 
                0 AS abonos_facturado, 
                0 AS saldo_facturado, 
                0 AS pagos_mensual, 
                SUM(IF(sub.id=b.id_factura_nota_credito,b.total,0))AS notas_mensual 
              FROM ( 
                SELECT 
                  a.id, 
                  a.fecha AS fecha_captura, 
                  folio, 
                  a.fecha,
                  'F' AS tipo, 
                  a.id AS id_factura, 
                  SUM(a.total) AS total 
                FROM facturas a 
                WHERE a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND $condicionUnidad $condicionSucursal AND ( a.mes BETWEEN 12 AND 12 AND a.anio=2019) AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 
                GROUP BY a.id )AS sub 
              LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito AND b.estatus ='T' 
              GROUP BY sub.id_factura ) AS pre 
              
            LEFT JOIN facturas k ON pre.id=k.id 
            LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa 
            LEFT JOIN facturas_cfdi m ON k.id=m.id_factura 
            LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id 
            LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal 
            GROUP BY pre.id 
            
          HAVING presupuesto>0) AS tabla 
          GROUP BY tabla.folio_factura";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }
       

        if($resultado){

            $registro = mysqli_fetch_array($resultado);
            $columnas = sizeof($registro)/2;
            $campos = array_keys($registro);
            $html.="<table class='tablon table-striped' ><thead><tr class='renglon'>";
            $cont=0;
            foreach($campos as $campo)
            {
                if(is_string($campo))
                {
                    $campos2[$cont] = $campo;
                    if($reporte == 'diario'){

                        $html.="<th scope='col' class='".$campo."' width='100px;'>".$campo."</td>";
                    }else{
                        $html.="<th scope='col'>".$campo."</td>";
                    }
                    
                    $cont++;
                }
            }
            $html.="</tr></thead><tbody>";
            $resultado = mysqli_query( $this->link, $query);
            
            
            $saldo=0; 
            if(mysqli_num_rows($resultado)>0){

            while($registro = mysqli_fetch_array($resultado))
            {
                $html.="<tr class='renglon_presupuesto ".$reporte."'>";

                foreach($campos2 as $field)
                {
                    
                    $texto = $registro[$field];

                    $html.="<td>".$texto."</td>";
                    
                            
                }

                $html.="</tr>";
            }
          }else{
            $html.="<tr class='renglon_presupuesto ".$reporte."'><td colspan=".$columnas.">No se Encontró Información</td></tr>";
          }

            $html.="</tbody></table>";
            
        }else{
            $html.="Error, en el Query";
        }

        return $html;
    }//-- fin function generaPresupuestoIngresosSeguimiento
    
}//--fin de class PresupuestoIngresosSeguimiento
    
?>