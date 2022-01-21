<?php

include 'conectar.php';

class PresupuestoEgresosSeguimiento
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function PresupuestoEgresosSeguimiento()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Buscamos registros y generamos archivo PresupuestoEgresosSeguimiento
      *
      * @param varchar $reporte para ver cual quert se va a generar
      * @param array $datos fltros para realizar el reporte
      *
    **/
    function obtieneTablaReporte($reporte,$datos){

        $idUnidad = $datos['idUnidad'];
        $idSucursal = $datos['idSucursal'];
        //-->NJES July/14/2020 quitar area y departamento ya que no se toma e cuenta ni en la carga ni en el consumo de presupuesto egresos
        //$idArea = $datos['idArea'];
        //$idDepartamento = $datos['idDepartamento'];
        $mesInicial = $datos['mesInicial'];
        $mesFinal = $datos['mesFinal'];
        $anio = $datos['anio'];

        //-->NJES July/19/2020 enviar la lista de sucursales permisos de la unidad, modulo y usuario
        //si no hay una sucursal seleccionada o si es la opci�n Mostrar Todas
        //$condicionSucursal = ($idSucursal>0)?' AND a.id_sucursal='.$idSucursal :'';
        if($idSucursal[0] == ',')
        {
            $dato=substr($idSucursal,1);
            $condicionSucursal = ' AND a.id_sucursal IN('.$dato.') ';
        }else{ 
            $condicionSucursal = ' AND a.id_sucursal ='.$idSucursal;
        }

        //$condicionArea = ($idArea>0)?'AND a.id_area='.$idArea:'';
        //$condicionDepartamentoS1 = ($idDepartamento>0)?' AND a.id_depto='.$idDepartamento :'';
        //$condicionDepartamentoS2 = ($idDepartamento>0)?' AND a.id_departamento='.$idDepartamento :'';
        $condicionMesS1 = ($mesFinal>0)?'  AND a.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
        $condicionMesS2 = ($mesFinal>0)?'  AND MONTH(a.fecha_captura) BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
        $condicionMesS3 = ($mesFinal>0)?'  AND b.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
        $condicionAnioS1 = ($anio>0)?" AND a.anio=".$anio :" ";
        $condicionAnioS2 = ($anio>0)?" AND YEAR(a.fecha_captura)=".$anio :" ";
        $condicionAnioS3 = ($anio>0)?" AND b.anio=".$anio :" ";
      
        $html='';

        if($reporte == 'familia'){
            //-->NJES JUNE/02/2020 Obtener el total al final de cada columna
            $query = "SELECT 
                        IF(IFNULL(n.familia,'')='','TOTAL',IF(n.familia='sin_fam','',n.familia)) AS FAMILIA,
                        FORMAT(SUM(n.presupuesto),2) AS PRESUPUESTO,
                        FORMAT(SUM(n.ejercido),2) AS EJERCIDO,
                        CONCAT(FORMAT(SUM(n.porcentaje),2),'%') AS PORCENTAJE
                        FROM (
                            SELECT tabla.familia AS familia, 
                            IFNULL(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo),0) AS presupuesto, 
                            IFNULL(SUM(tabla.ejercido),0) AS ejercido, 
                            IF((SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)),0),0) AS porcentaje 
                            FROM (	
                                SELECT 
                                    IFNULL(b.descr,'sin_fam') AS familia,
                                    SUM(a.monto) AS presupuesto,
                                    0 AS ejercido,0 AS factor_prorrateo
                                FROM presupuesto_egresos a 
                                LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                                WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS1 $condicionMesS1
                                GROUP BY a.id_familia_gasto
                                UNION ALL
                                
                                SELECT 
                                    IFNULL(b.descr,'sin_fam') AS familia,
                                    0 AS presupuesto,SUM(a.monto) AS ejercido,0 AS factor_prorrateo 
                                FROM movimientos_presupuesto a 
                                LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                                WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS2 $condicionMesS2
                                GROUP BY a.id_familia_gasto
                                UNION ALL
                                
                                SELECT IFNULL(c.descr,'sin_fam') AS familia,0 AS presupuesto,0 AS ejercido,
                                SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo
                                FROM presupuestos_prorrateados a 
                                LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
                                LEFT JOIN fam_gastos c ON a.id_familia_gasto = c.id_fam
                                WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS3 $condicionMesS3
                                GROUP BY a.id_familia_gasto
                            ) AS tabla
                            
                            GROUP BY tabla.familia
                            ORDER BY tabla.familia ASC
                        ) AS n 
                    GROUP BY n.familia WITH ROLLUP";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
               
        }

        if($reporte == 'clasificacion'){
            $query = "SELECT 
                tabla.familia AS Familia,
                tabla.clasificacion AS Clasificacion,
                FORMAT(IFNULL(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo),0),2) AS Presupuesto,
                FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS ejercido,
                CONCAT(FORMAT(IF((SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)),0),0),2),' %') AS PORCENTAJE
                FROM (  
                    SELECT 
                        IFNULL(b.descr,'') AS familia,
                        IFNULL(c.descr,'') AS clasificacion,
                        SUM(a.monto) AS presupuesto,0 AS ejercido,
                        0 AS factor_prorrateo
                    FROM presupuesto_egresos a 
                    LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                    LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
                    WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS1 $condicionMesS1
                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                    UNION ALL
                
                    SELECT 
                        IFNULL(b.descr,'') AS familia,
                        IFNULL(c.descr,'') AS clasificacion,
                        0 AS presupuesto,
                        SUM(a.monto) AS ejercido,
                        0 AS factor_prorrateo
                    FROM movimientos_presupuesto a 
                    LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                    LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
                    WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS2 $condicionMesS2
                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                    UNION ALL	
                    
                    SELECT IFNULL(c.descr,'') AS familia,
                    IFNULL(d.descr,'') AS clasificacion,
                    0 AS presupuesto,0 AS ejercido,
                    SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo
                    FROM presupuestos_prorrateados a 
                    LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
                    LEFT JOIN fam_gastos c ON a.id_familia_gasto = c.id_fam
                    LEFT JOIN gastos_clasificacion d ON a.id_clasificacion=d.id_clas
                    WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS3 $condicionMesS3
                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                ) AS tabla
                
                GROUP BY tabla.clasificacion ,tabla.familia
                ORDER BY tabla.familia ASC";

            //-->NJES JUNE/02/2020 obtener el total de presupuesto, ejercido y porcentaje para agregarlo a la tabla como otro registro
            $query_total = "SELECT 
                'TOTAL' AS familia,
                '' AS clasificacion,
                FORMAT(IFNULL(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo),0),2) AS total_presupuesto,
                FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS total_ejercido,
                CONCAT(FORMAT(IF((SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)),0),0),2),' %') AS total_porcentaje
                FROM (  
                    SELECT 
                        IFNULL(b.descr,'') AS familia,
                        IFNULL(c.descr,'') AS clasificacion,
                        SUM(a.monto) AS presupuesto,0 AS ejercido,
                        0 AS factor_prorrateo
                    FROM presupuesto_egresos a 
                    LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                    LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
                    WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS1 $condicionMesS1
                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                    UNION ALL
                
                    SELECT 
                        IFNULL(b.descr,'') AS familia,
                        IFNULL(c.descr,'') AS clasificacion,
                        0 AS presupuesto,
                        SUM(a.monto) AS ejercido,
                        0 AS factor_prorrateo
                    FROM movimientos_presupuesto a 
                    LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                    LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
                    WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS2 $condicionMesS2
                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                    UNION ALL	
                    
                    SELECT IFNULL(c.descr,'') AS familia,
                    IFNULL(d.descr,'') AS clasificacion,
                    0 AS presupuesto,0 AS ejercido,
                    SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo
                    FROM presupuestos_prorrateados a 
                    LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
                    LEFT JOIN fam_gastos c ON a.id_familia_gasto = c.id_fam
                    LEFT JOIN gastos_clasificacion d ON a.id_clasificacion=d.id_clas
                    WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS3 $condicionMesS3
                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                ) AS tabla";

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
                    
                }
            } 

            //-->NJES JUNE/02/2020 Obtener el total al final de cada columna
            $query = "SELECT 
                IF(IFNULL(tabla.familia,'')='','TOTAL',IF(tabla.familia='sin_fam','',tabla.familia)) AS FAMILIA,
                FORMAT(IFNULL(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo),0),2) AS Presupuesto,
                $condicionDias
                FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS ejercido,
                CONCAT(FORMAT(IF((SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)),0),0),2),' %') AS PORCENTAJE
                FROM (	
                SELECT 
                IFNULL(b.descr,'sin_fam') AS familia,
                SUM(a.monto) AS presupuesto,
                $condicionDiasP
                0 AS ejercido,
                0 AS factor_prorrateo
                FROM presupuesto_egresos a 
                LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS1 $condicionMesS1
                GROUP BY a.id_familia_gasto
                UNION ALL
                
                SELECT 
                IFNULL(b.descr,'sin_fam') AS familia,
                0 AS presupuesto,
                $condicionFecha
                SUM(a.monto) AS ejercido,
                0 AS factor_prorrateo
                FROM movimientos_presupuesto a 
                LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS2 $condicionMesS2
                GROUP BY a.id,a.id_familia_gasto
                UNION ALL
                
                SELECT IFNULL(c.descr,'sin_fam') AS familia,0 AS presupuesto,
                $condicionDiasP
                0 AS ejercido,
                SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo
                FROM presupuestos_prorrateados a 
                LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
                LEFT JOIN fam_gastos c ON a.id_familia_gasto = c.id_fam
                WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS3 $condicionMesS3
                GROUP BY a.id_familia_gasto
                ) AS tabla
                
                GROUP BY tabla.familia WITH ROLLUP";

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
            
            $renTotal = $cont;
            $renGastado = $renTotal-1;
            
            $saldo=0;  
            while($registro = mysqli_fetch_array($resultado))
            {
                $html.="<tr class='renglon_presupuesto ".$reporte."'>";
                $i=0;
                $band=0;
                foreach($campos2 as $field)
                {
                    //NJES Jan/14/2020 SEGUIMIENTO PRESUPUESTO EGRESOS (2) (DEN18-2427) 
                    //Marcar con otro color, las partidas no presupuestados en las que s� ha habido egresos.
                    $i++;
                    $sinPresupuesto = '';
                    $sinGasto = '';
                    if($reporte == 'familia')
                    {
                        if($i==2 && $registro[$field] == 0)
                        {
                            $sinPresupuesto = 'class="sin_presupuesto"';
                            $band=1;
                        }

                        if($i==3 && $registro[$field] == 0 && $band==1)
                        {
                            $sinGasto = 'class="sin_gasto"';
                            $band=0;
                        }
                    }

                    if($reporte == 'clasificacion')
                    {
                        if($i==3 && $registro[$field] == 0)
                        {
                            $sinPresupuesto = 'class="sin_presupuesto"';
                            $band=1;
                        }

                        if($i==4 && $registro[$field] == 0 && $band==1)
                        {
                            $sinGasto = 'class="sin_gasto"';
                            $band=0;
                        }
                    }

                    if($reporte == 'diario')
                    {
                        if($i==2 && $registro[$field] == 0)
                        {
                            $sinPresupuesto = 'class="sin_presupuesto"';
                            $band=1;
                        }

                        if($i==$renGastado && $registro[$field] == 0 && $band==1)
                        {
                            $sinGasto = 'class="sin_gasto"';
                            $band=0;
                        }
                    }

                    $texto = $registro[$field];

                    $html.="<td ".$sinPresupuesto." ".$sinGasto.">".$texto."</td>";
                                               
                }



                $html.="</tr>";
            }

            if($reporte == 'clasificacion')
            {
                $resultado1 = mysqli_query($this->link, $query_total);
             
                while($registro1 = mysqli_fetch_array($resultado1))
                {
                    $html.="<tr class='renglon_presupuesto'>";

                    $html.="<td>".$registro1['familia']."</td>";
                    $html.="<td>".$registro1['clasificacion']."</td>";
                    $html.="<td>".$registro1['total_presupuesto']."</td>";
                    $html.="<td>".$registro1['total_ejercido']."</td>";
                    $html.="<td>".$registro1['total_porcentaje']."</td>";

                    $html.="</tr>";
                }
            }

            $html.="</tbody></table>";
            
        }else{
            $html.="Error, en el Query";
        }

        return $html;
    }//-- fin function generaPresupuestoEgresosSeguimiento
    
}//--fin de class PresupuestoEgresosSeguimiento
    
?>