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


                    // echo $query;
                    // exit();

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

                // echo $query;
                // echo "<br>000000000000000000000000000000000000000000000000000000000000000000000000000<br>";
                // echo $query_total;
                // exit();

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
                        WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionAnioS1 $condicionMesS1
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
                        LEFT JOIN almacen_d c ON c.id = a.id_almacen_d
                        WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionAnioS2 $condicionMesS2 -- AND SUBSTR(c.cve_concepto, 1, 1) <> 'S'
                        GROUP BY a.id,a.id_familia_gasto
                        
                        UNION ALL
                        
                        SELECT
                            IFNULL(c.descr,'sin_fam') AS familia,
                            0 AS presupuesto,
                            $condicionDiasP
                            0 AS ejercido,
                            SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo
                        FROM presupuestos_prorrateados a 
                        LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
                        LEFT JOIN fam_gastos c ON a.id_familia_gasto = c.id_fam
                        WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionAnioS3 $condicionMesS3
                        GROUP BY a.id_familia_gasto
                    ) AS tabla
                    
                    GROUP BY tabla.familia WITH ROLLUP";

                // echo $query;
                // exit();

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

    function obtieneGraficaReporte($reporte,$datos){

        $idUnidad = $datos['idUnidad'];
        $idSucursal = isset($datos['idSucursal']) ? $datos['idSucursal'] : 0;
        
        $fechaInicial = $datos['fechaInicial'];
        $fechaFinal = $datos['fechaFinal'];

        if($idSucursal!=""){
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $condicionSucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $condicionSucursal = ' AND a.id_sucursal ='.$idSucursal;
            }
        }else{
            $condicionSucursal = "";
        }

        $fechaInicio = ($fechaInicial != "") ? $fechaInicial: date('Y-m-d');
        $fechaFin = ($fechaFinal != "") ? $fechaFinal: date('Y-m-d');
        
        // $condicionMesS1 = ($mesFinal>0)?'  AND a.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
        // $condicionMesS2 = ($mesFinal>0)?'  AND MONTH(a.fecha_captura) BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
        // $condicionMesS3 = ($mesFinal>0)?'  AND b.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
        // $condicionAnioS1 = ($anio>0)?" AND a.anio=".$anio :" ";
        // $condicionAnioS2 = ($anio>0)?" AND YEAR(a.fecha_captura)=".$anio :" ";
        // $condicionAnioS3 = ($anio>0)?" AND b.anio=".$anio :" ";

        $condicionFechaMesAnio1 =  "AND a.mes BETWEEN MONTH('$fechaInicio') AND MONTH('$fechaFin')
                                    AND a.anio BETWEEN YEAR('$fechaInicio') AND YEAR('$fechaFin')";

        $condicionFechaMesAnio2 =  "AND b.mes BETWEEN MONTH('$fechaInicio') AND MONTH('$fechaFin')
                                    AND b.anio BETWEEN YEAR('$fechaInicio') AND YEAR('$fechaFin')";

        $condicionFecha1 = " AND a.fecha_captura BETWEEN '$fechaInicio' AND '$fechaFin' ";

      
        $html='';

        if($reporte == 'familia'){
            //-->NJES JUNE/02/2020 Obtener el total al final de cada columna
            $query = "SELECT 
                        IF(IFNULL(n.familia,'')='','TOTAL',IF(n.familia='sin_fam','',n.familia)) AS FAMILIA,
                        SUM(n.presupuesto) AS PRESUPUESTO,
                        SUM(n.ejercido) AS EJERCIDO,
                        CONCAT(FORMAT(SUM(n.porcentaje),2),'%') AS PORCENTAJE,
                        n.id_fam
                    FROM (
                        SELECT tabla.familia AS familia, 
                        IFNULL(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo),0) AS presupuesto, 
                        IFNULL(SUM(tabla.ejercido),0) AS ejercido, 
                        IF((SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)),0),0) AS porcentaje,
                        tabla.id_fam
                        FROM (	
                            SELECT 
                                IFNULL(b.descr,'sin_fam') AS familia,
                                SUM(a.monto) AS presupuesto,
                                0 AS ejercido,
                                0 AS factor_prorrateo,
                                b.id_fam AS id_fam
                            FROM presupuesto_egresos a 
                            LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                            WHERE a.id_unidad_negocio=$idUnidad $condicionFechaMesAnio1
                            GROUP BY a.id_familia_gasto

                            UNION ALL
                            
                            SELECT 
                                IFNULL(b.descr,'sin_fam') AS familia,
                                0 AS presupuesto,
                                SUM(a.monto) AS ejercido,
                                0 AS factor_prorrateo,
                                b.id_fam AS id_fam
                            FROM movimientos_presupuesto a 
                            LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                            WHERE a.id_unidad_negocio=$idUnidad $condicionFecha1
                            GROUP BY a.id_familia_gasto
                            UNION ALL
                            
                            SELECT
                                IFNULL(c.descr,'sin_fam') AS familia,
                                0 AS presupuesto,
                                0 AS ejercido,
                                SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo,
                                c.id_fam AS id_fam
                            FROM presupuestos_prorrateados a 
                            LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
                            LEFT JOIN fam_gastos c ON a.id_familia_gasto = c.id_fam
                            WHERE a.id_unidad_negocio=$idUnidad $condicionFechaMesAnio2
                            GROUP BY a.id_familia_gasto
                        ) AS tabla
                        
                        GROUP BY tabla.familia
                        ORDER BY tabla.familia ASC
                    ) AS n 
                    GROUP BY n.familia WITH ROLLUP";

                    // echo $query;
                    // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
               
        }

        if($reporte == 'clasificacion'){
            
            $query = "SELECT 
                tabla.familia AS FAMILIA,
                tabla.clasificacion AS Clasificacion,
                IFNULL(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo),0) AS PRESUPUESTO,
                IFNULL(SUM(tabla.ejercido),0) AS EJERCIDO,
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
                    WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionFechaMesAnio1
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
                    WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionFecha1
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
                    WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionFechaMesAnio2
                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                ) AS tabla
                
                GROUP BY tabla.clasificacion ,tabla.familia
                ORDER BY tabla.familia ASC";

            //-->NJES JUNE/02/2020 obtener el total de presupuesto, ejercido y porcentaje para agregarlo a la tabla como otro registro
            // $query_total = "SELECT 
            //     'TOTAL' AS familia,
            //     '' AS clasificacion,
            //     FORMAT(IFNULL(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo),0),2) AS total_presupuesto,
            //     FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS total_ejercido,
            //     CONCAT(FORMAT(IF((SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)),0),0),2),' %') AS total_porcentaje
            //     FROM (  
            //         SELECT 
            //             IFNULL(b.descr,'') AS familia,
            //             IFNULL(c.descr,'') AS clasificacion,
            //             SUM(a.monto) AS presupuesto,0 AS ejercido,
            //             0 AS factor_prorrateo
            //         FROM presupuesto_egresos a 
            //         LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
            //         LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
            //         WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionAnioS1 $condicionMesS1
            //         GROUP BY a.id_clasificacion,a.id_familia_gasto
            //         UNION ALL
                
            //         SELECT 
            //             IFNULL(b.descr,'') AS familia,
            //             IFNULL(c.descr,'') AS clasificacion,
            //             0 AS presupuesto,
            //             SUM(a.monto) AS ejercido,
            //             0 AS factor_prorrateo
            //         FROM movimientos_presupuesto a 
            //         LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
            //         LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
            //         WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionAnioS2 $condicionMesS2
            //         GROUP BY a.id_clasificacion,a.id_familia_gasto
            //         UNION ALL	
                    
            //         SELECT IFNULL(c.descr,'') AS familia,
            //         IFNULL(d.descr,'') AS clasificacion,
            //         0 AS presupuesto,0 AS ejercido,
            //         SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo
            //         FROM presupuestos_prorrateados a 
            //         LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
            //         LEFT JOIN fam_gastos c ON a.id_familia_gasto = c.id_fam
            //         LEFT JOIN gastos_clasificacion d ON a.id_clasificacion=d.id_clas
            //         WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionAnioS3 $condicionMesS3
            //         GROUP BY a.id_clasificacion,a.id_familia_gasto
            //     ) AS tabla";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());  
        }

        if($reporte == 'diario'){

            $queryDias="SELECT dayofmonth(last_day('$fechaFin')) as dias_mes";
            $resultDias = mysqli_query($this->link, $queryDias)or die(mysqli_error());

            $idFamilia = (isset($datos["id"])) ? $datos["id"]: 0;


            // $condicionDias = ''; 
            // $condicionFecha = '';
            $condicion1 = $condicion2 = $condicion3 = "";

            if($resultDias){

                $rowD=mysqli_fetch_array($resultDias);

                $totalDias=$rowD['dias_mes'];

                for($j=1;$j<=$totalDias;$j++){
                   
                    // $condicionDias.="FORMAT(IFNULL(SUM(tabla.d".$j."),0),2) AS D".$j.",";
                    // $condicionDiasP.="0 AS D".$j.",";
                    // $condicionFecha.="IF(DATE_FORMAT(a.fecha_captura,'%d')=".$j.",IFNULL(SUM(a.monto),0),0) AS d".$j.",";
                    $condicion1 .= "0 AS D$j,";
                    $condicion2 .= "ROUND(SUM(IF(DAY(mp.fecha_captura)=$j,mp.monto,0)), 2) AS D$j,";
                    $condicion3 .= "ROUND(SUM(D$j), 2) as D$j,";
                }
            } 

            //-->NJES JUNE/02/2020 Obtener el total al final de cada columna
            // $query = "SELECT 
            //                 IF(IFNULL(tabla.familia,'')='','TOTAL',IF(tabla.familia='sin_fam','',tabla.familia)) AS FAMILIA,
            //                 IFNULL(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo),0) AS PRESUPUESTO,
            //                 $condicionDias
            //                 IFNULL(SUM(tabla.ejercido),0) AS EJERCIDO,
            //                 CONCAT(FORMAT(IF((SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)+SUM(tabla.factor_prorrateo)),0),0),2),' %') AS PORCENTAJE
            //             FROM (	
            //                 SELECT 
            //                     IFNULL(b.descr,'sin_fam') AS familia,
            //                     SUM(a.monto) AS presupuesto,
            //                     $condicionDiasP
            //                     0 AS ejercido,
            //                     0 AS factor_prorrateo,
            //                     b.id_fam,
            //                     c.id_clas
            //                 FROM presupuesto_egresos a 
            //                 LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
            //                 LEFT JOIN gastos_clasificacion c ON c.id_fam = b.id_fam
            //                 WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionFechaMesAnio1
            //                 GROUP BY c.id_clas, a.id_familia_gasto

            //                 UNION ALL
                            
            //                 SELECT 
            //                     IFNULL(b.descr,'sin_fam') AS familia,
            //                     0 AS presupuesto,
            //                     $condicionFecha
            //                     SUM(a.monto) AS ejercido,
            //                     0 AS factor_prorrateo,
            //                     b.id_fam,
            //                     c.id_clas
            //                 FROM movimientos_presupuesto a 
            //                 LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
            //                 LEFT JOIN gastos_clasificacion c ON c.id_fam = b.id_fam
            //                 WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionFecha1
            //                 GROUP BY c.id_clas, a.id,a.id_familia_gasto

            //                 UNION ALL
                            
            //                 SELECT
            //                     IFNULL(c.descr,'sin_fam') AS familia,
            //                     0 AS presupuesto,
            //                     $condicionDiasP
            //                     0 AS ejercido,
            //                     SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo,
            //                     c.id_fam,
            //                     d.id_clas
            //                 FROM presupuestos_prorrateados a 
            //                 LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
            //                 LEFT JOIN fam_gastos c ON a.id_familia_gasto = c.id_fam
            //                 LEFT JOIN gastos_clasificacion d ON d.id_fam = c.id_fam
            //                 WHERE a.id_unidad_negocio=$idUnidad $condicionSucursal $condicionFechaMesAnio2
            //                 GROUP BY d.id_clas, a.id_familia_gasto
            //             ) AS tabla
            //             WHERE tabla.id_fam=$idFamilia 
            //             GROUP BY tabla.id_clas, tabla.id_fam";

                $query = "SELECT
                                su.descr,
                                tablas.clasificacion,
                                ROUND(SUM(presupuesto),2) AS presupuesto,
                                ROUND(SUM(egresado),2) AS egresado,
                                IFNULL(ROUND((SUM(egresado) / SUM(presupuesto))*100,2),'NA') AS porcentaje,
                                $condicion3
                                '' AS ''
                            FROM (
                                SELECT
                                    pe.id_sucursal,
                                    gc.id_clas,
                                    gc.descr AS clasificacion,
                                    $condicion1
                                    pe.monto AS presupuesto,
                                    0 AS egresado
                                FROM presupuesto_egresos pe
                                INNER JOIN gastos_clasificacion gc ON pe.id_clasificacion = gc.id_clas
                                WHERE pe.id_unidad_negocio = $idUnidad
                                    AND pe.id_familia_gasto = $idFamilia
                                    AND pe.mes = MONTH('$fechaInicio')
                                    AND pe.anio = YEAR('$fechaInicio')
                                GROUP BY pe.id_sucursal, pe.id_clasificacion
                            
                                UNION ALL
                            
                                SELECT
                                    mp.id_sucursal,
                                    gc.id_clas,
                                    gc.descr AS clasificacion,
                                    $condicion2
                                    0 AS presupuesto,
                                    SUM(mp.monto) AS egresado
                                FROM movimientos_presupuesto mp
                                INNER JOIN gastos_clasificacion gc ON mp.id_clasificacion = gc.id_clas
                                WHERE mp.id_unidad_negocio = $idUnidad
                                    AND mp.id_familia_gasto = $idFamilia
                                    AND MONTH(mp.fecha_captura) = MONTH('$fechaInicio')
                                    AND YEAR(mp.fecha_captura) = YEAR('$fechaInicio')
                                GROUP BY mp.id_sucursal, mp.id_clasificacion
                            ) as tablas
                            INNER JOIN sucursales su ON su.id_sucursal = tablas.id_sucursal
                            GROUP BY tablas.id_sucursal, tablas.id_clas;";

            // echo $query;
            // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($reporte == 'unidad'){
            //-->NJES JUNE/02/2020 Obtener el total al final de cada columna
            $query = "SELECT 
                        IF(IFNULL(n.familia,'')='','TOTAL',IF(n.familia='sin_fam','',n.familia)) AS FAMILIA,
                        SUM(n.presupuesto) AS PRESUPUESTO,
                        SUM(n.ejercido) AS EJERCIDO,
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
                                INNER JOIN sucursales b ON a.id_sucursal = b.id_sucursal AND b.activo = 1
                                WHERE a.id_unidad_negocio=$idUnidad $condicionFechaMesAnio1
                                GROUP BY a.id_sucursal
                                UNION ALL
                                
                                SELECT 
                                    IFNULL(b.descr,'sin_fam') AS familia,
                                    0 AS presupuesto,SUM(a.monto) AS ejercido,0 AS factor_prorrateo 
                                FROM movimientos_presupuesto a 
                                INNER JOIN sucursales b ON a.id_sucursal = b.id_sucursal AND b.activo = 1
                                WHERE a.id_unidad_negocio=$idUnidad $condicionFecha1
                                GROUP BY a.id_sucursal
                                UNION ALL
                                
                                SELECT IFNULL(c.descr,'sin_fam') AS familia,0 AS presupuesto,0 AS ejercido,
                                SUM((a.porcentaje_prorrateo*IFNULL(b.monto,0))/100) AS factor_prorrateo
                                FROM presupuestos_prorrateados a 
                                LEFT JOIN presupuesto_egresos b ON a.id_presupuesto_egreso=b.id
                                INNER JOIN sucursales c ON a.id_sucursal = c.id_sucursal AND c.activo = 1
                                WHERE a.id_unidad_negocio=$idUnidad $condicionFechaMesAnio2
                                GROUP BY a.id_sucursal
                            ) AS tabla
                            
                            GROUP BY tabla.familia
                            ORDER BY tabla.familia ASC
                        ) AS n 
                    GROUP BY n.familia WITH ROLLUP";

                    // echo $query;
                    // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
               
        }

        if($reporte == "bancos"){

            $query = "SELECT
                            cb.descripcion FAMILIA,
                            (sd.cantidad) PRESUPUESTO,
                            sd.cantidad + (SUM(IF(mb.tipo = 'I' OR mb.tipo = 'A' OR (mb.tipo = 'T' AND mb.transferencia <> 0),mb.monto,0)) - SUM(IF(mb.tipo = 'C' OR (mb.tipo = 'T' AND mb.transferencia = 0),mb.monto,0))) as EJERCIDO,
                            us.usuario
                        FROM saldos_diarios sd
                        INNER JOIN cuentas_bancos cb ON cb.id = sd.id_cuenta_banco
                        INNER JOIN cuentas_banco_admin cba ON cba.fk_cuenta_banco = cb.id
                        INNER JOIN usuarios us ON us.id_usuario = cba.fk_id_usuario
                        LEFT JOIN movimientos_bancos mb ON mb.id_cuenta_banco = cb.id AND DATE(mb.fecha) = DATE(NOW())
                        WHERE sd.fecha = (SELECT MAX(t2.fecha)
                                            FROM saldos_diarios t2
                                            WHERE t2.id_cuenta_banco = sd.id_cuenta_banco)
                        GROUP BY sd.id_cuenta_banco
                        ORDER BY us.id_usuario;";

            // echo $query;
            // exit();

            $resultado = $this->link->query($query);

            return query2json($resultado);
        }

        if($reporte == "facDiaria"){

            // $query = "SELECT
            //             cun.nombre,
            //             fa.id_unidad_negocio,
            //             su.descr AS FAMILIA,
            //             SUM(IF(fa.estatus <> 'C', fa.total,0)) AS EJERCIDO,
            //             SUM(IF(fa.estatus = 'C',fa.total, 0)) AS PRESUPUESTO
            //         FROM facturas fa
            //         INNER JOIN cat_unidades_negocio cun ON cun.id = fa.id_unidad_negocio
            //         INNER JOIN sucursales su ON fa.id_sucursal = su.id_sucursal
            //         WHERE DATE(fa.fecha_inicio) >= '$fechaInicio' AND DATE(fa.fecha_fin) <= '$fechaFin'
            //         GROUP BY fa.id_unidad_negocio, fa.id_sucursal";

            $query = "SELECT
                        su.id_sucursal,
                        cun.nombre,
                        fa.id_unidad_negocio,
                        su.descr AS FAMILIA,
                        SUM(IF(fa.anio BETWEEN YEAR('$fechaInicio') AND YEAR('$fechaFin') AND fa.mes BETWEEN MONTH('$fechaFin') AND MONTH('$fechaFin'), fa.total,0)) AS EJERCIDO,
                        SUM(IF(DATE(fa.fecha_registro) >= '$fechaInicio' AND DATE(fa.fecha_registro) <= '$fechaFin',fa.total, 0)) AS PRESUPUESTO
                    FROM facturas fa
                    INNER JOIN cat_unidades_negocio cun ON cun.id = fa.id_unidad_negocio
                    INNER JOIN sucursales su ON fa.id_sucursal = su.id_sucursal
                    WHERE fa.estatus <> 'C'
                        AND (
                            (fa.anio BETWEEN YEAR('$fechaInicio') AND YEAR('$fechaFin') AND fa.mes BETWEEN MONTH('$fechaFin') AND MONTH('$fechaFin'))
                            OR
                            (DATE(fa.fecha_registro) >= '$fechaInicio' AND DATE(fa.fecha_registro) <= '$fechaFin')
                        )
                    GROUP BY fa.id_unidad_negocio, fa.id_sucursal";

            // echo $query;
            // exit();

            $resultado = $this->link->query($query);

            return query2json($resultado);
        }
       
        if($reporte == "ingCxc"){

            $query = "SELECT
                            tabla.nombre,
                            tabla.id_unidad_negocio,
                            CONCAT(tabla.nombre,' - ',tabla.FAMILIA) as FAMILIA,
                            SUM(tabla.EJERCIDO) EJERCIDO,
                            SUM(tabla.presupuesto) PRESUPUESTO
                        FROM (
                            SELECT cun.nombre, fa.id_unidad_negocio, su.descr AS FAMILIA, SUM(IF(fa.estatus <> 'C', fa.total,0)) EJERCIDO, SUM(IF(fa.estatus = 'C', '', 0)) AS PRESUPUESTO, fa.id_sucursal
                            FROM cxc fa
                            INNER JOIN cat_unidades_negocio cun ON cun.id = fa.id_unidad_negocio
                            INNER JOIN sucursales su ON fa.id_sucursal = su.id_sucursal
                            WHERE DATE(fa.fecha) BETWEEN '$fechaInicio' AND '$fechaFin'
                                -- AND fa.id NOT IN (SELECT id_cxc FROM pagos_sin_factura_bitacora)
                                -- AND fa.folio_cxc <> 0
                                AND fa.id_pago <> 0
                            GROUP BY fa.id_unidad_negocio, fa.id_sucursal
                        
                            UNION ALL
                        
                            SELECT IFNULL(cun.nombre,'SIN UNIDAD') nombre, psf.id_unidad_negocio, IFNULL(su.descr, 'SIN SUCURSAL') AS FAMILIA, SUM(psf.monto) EJERCIDO, 0 PRESUPUESTO, psf.id_sucursal
                            FROM pagos_sin_factura psf
                            LEFT JOIN cat_unidades_negocio cun ON cun.id = psf.id_unidad_negocio
                            LEFT JOIN sucursales su ON psf.id_sucursal = su.id_sucursal
                            WHERE DATE(psf.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' AND psf.monto <> 0
                            GROUP BY psf.id_unidad_negocio, psf.id_sucursal
                        ) as tabla
                        GROUP BY tabla.id_unidad_negocio, tabla.id_sucursal";

            // echo $query;
            // exit();

            $resultado = $this->link->query($query);

            return query2json($resultado);
        }

        if($reporte == "ingVSegr"){

            $query = "SELECT
                            a.id_unidad_negocio,
                            IF(a.id_unidad_negocio = 0, 'SIN UNIDAD', c.nombre) AS FAMILIA,
                            SUM(IF(a.tipo = 'I' OR (a.tipo = 'A' AND a.fondeo = 0),a.monto,0)) as EJERCIDO,
                            SUM(IF(a.tipo = 'C',a.monto,0)) as PRESUPUESTO,
                            SUM(IF(a.tipo = 'I' OR (a.tipo = 'A' AND a.fondeo = 0),a.monto,0)) - SUM(IF(a.tipo = 'C' OR (a.tipo = 'T' AND a.transferencia = 0),a.monto,0)) AS SALDO,
                            SUM(IF(a.fondeo = 1 AND a.transferencia <> 0, /* AQUI IF TRUE*/IF(a.id_unidad_negocio2 = (SELECT (SELECT id_unidad_negocio FROM cuentas_bancos WHERE id = mb.id_cuenta_banco) id_unidad_negocio2 FROM movimientos_bancos mb WHERE id = a.transferencia), 0, a.monto),/* AQUI IF FALSE*/0)) AS FONDEO
                        FROM (
                            SELECT 
                                CASE
                                    WHEN mb.id_ingreso_sin_factura > 0 THEN (SELECT id_unidad_negocio FROM ingresos_sin_factura WHERE id = mb.id_ingreso_sin_factura)
                                    WHEN mb.id_psf > 0 THEN (SELECT id_unidad_negocio FROM pagos_sin_factura WHERE id = mb.id_psf)
                                    WHEN mb.id_cxc > 0 THEN (SELECT id_unidad_negocio FROM cxc WHERE id = mb.id_cxc)
                                    WHEN mb.id_gasto > 0 THEN (SELECT id_unidad_negocio FROM gastos WHERE id = mb.id_gasto)
                                    WHEN mb.id_viatico > 0 THEN (SELECT id_unidad_negocio FROM viaticos WHERE id = mb.id_viatico)
                                    WHEN mb.id_caja_chica > 0 THEN (SELECT id_unidad_negocio FROM caja_chica WHERE id = mb.id_caja_chica)
                                    WHEN mb.id_cxp > 0 THEN (SELECT id_unidad_negocio FROM cxp WHERE id = mb.id_cxp)
                                    WHEN mb.id_nomina > 0 THEN (SELECT su.id_unidad_negocio FROM periodos_s ps INNER JOIN sucursales su ON ps.id_sucursal = su.id_sucursal WHERE ps.id_nomina = mb.id_nomina)
                                    WHEN mb.id_nomina_a > 0 THEN (SELECT su.id_unidad_negocio FROM periodos_s_a ps INNER JOIN sucursales su ON ps.id_sucursal = su.id_sucursal WHERE ps.id_nomina_a = mb.id_nomina_a)
                                    ELSE (SELECT id_unidad_negocio FROM cuentas_bancos WHERE id = mb.id_cuenta_banco)
                                END AS id_unidad_negocio,
                                (SELECT id_unidad_negocio FROM cuentas_bancos WHERE id = mb.id_cuenta_banco) id_unidad_negocio2,
                                tipo,
                                transferencia,
                                monto,
                                fecha_aplicacion,
                                fecha,
                                id_cuenta_banco,
                                id,
                                fondeo
                            FROM movimientos_bancos mb
                            WHERE mb.tipo <> 'I'
                                AND IF(fecha_aplicacion='0000-00-00', (DATE(fecha) BETWEEN '$fechaInicio' AND '$fechaFin'), (DATE(fecha_aplicacion) BETWEEN '$fechaInicio' AND '$fechaFin'))
                        ) AS a
                        LEFT JOIN cat_unidades_negocio c ON c.id = a.id_unidad_negocio
                        GROUP BY a.id_unidad_negocio;";

            // echo $query;
            // exit();

            $resultado = $this->link->query($query);

            return query2json($resultado);
        }

        if($reporte == "oficialesDob"){

            $query = "SELECT
                            dep.des_dep depto,
                            suc.descr sucursal,
                            i2.id_empleado id,
                            CONCAT_WS(' ', REPLACE(tra.nombre,'  ',''), REPLACE(tra.apellido_p,'  ',''), REPLACE(tra.apellido_m,'  ','')) empleado,
                            i2.incidencia,
                            i2.incidencia_aux,
                            i2.fecha
                        FROM incidencias2 i2
                        INNER JOIN deptos dep ON i2.id_depto = dep.id_depto
                        INNER JOIN sucursales suc ON i2.id_compania = suc.id_sucursal
                        INNER JOIN trabajadores tra ON i2.id_empleado = tra.id_trabajador
                        WHERE
                            DATE(i2.fecha) BETWEEN '$fechaInicio' AND '$fechaFin'
                            AND i2.incidencia_aux IN (SELECT clave FROM motivos WHERE descr LIKE '%extra%')
                        ORDER BY i2.fecha ASC;";

            // echo $query;
            // exit();

            $resultado = $this->link->query($query);

            return query2json($resultado);
        }

        if($reporte == 'especial'){
            
            $query = "SELECT
                        a.id_unidad_negocio as ID,
                        c.nombre AS UNIDAD,
                        SUM(IF(a.tipo = 'I' OR a.tipo = 'A' OR (a.tipo = 'T' AND a.transferencia <> 0),a.monto,0)) as INGRESOS,
                        SUM(IF(a.tipo = 'C' OR (a.tipo = 'T' AND a.transferencia = 0),a.monto,0)) as EGRESOS,
                        SUM(IF(a.tipo = 'I' OR a.tipo = 'A' OR (a.tipo = 'T' AND a.transferencia <> 0),a.monto,0)) - SUM(IF(a.tipo = 'C' OR (a.tipo = 'T' AND a.transferencia = 0),a.monto,0)) AS SALDO,
                        MONTH(a.fecha_aplicacion) as MES
                        FROM (
                            SELECT 
                                CASE
                                    WHEN mb.id_ingreso_sin_factura > 0 THEN (SELECT id_unidad_negocio FROM ingresos_sin_factura WHERE id = mb.id_ingreso_sin_factura)
                                    WHEN mb.id_psf > 0 THEN (SELECT id_unidad_negocio FROM pagos_sin_factura WHERE id = mb.id_psf)
                                    WHEN mb.id_cxc > 0 THEN (SELECT id_unidad_negocio FROM cxc WHERE id = mb.id_cxc)
                                    WHEN mb.id_gasto > 0 THEN (SELECT id_unidad_negocio FROM gastos WHERE id = mb.id_gasto)
                                    WHEN mb.id_viatico > 0 THEN (SELECT id_unidad_negocio FROM viaticos WHERE id = mb.id_viatico)
                                    WHEN mb.id_caja_chica > 0 THEN (SELECT id_unidad_negocio FROM caja_chica WHERE id = mb.id_caja_chica)
                                    WHEN mb.id_cxp > 0 THEN (SELECT id_unidad_negocio FROM cxp WHERE id = mb.id_cxp)
                                    WHEN mb.id_nomina > 0 THEN (SELECT su.id_unidad_negocio FROM periodos_s ps INNER JOIN sucursales su ON ps.id_sucursal = su.id_sucursal WHERE ps.id_nomina = mb.id_nomina)
                                    WHEN mb.id_nomina_a > 0 THEN (SELECT su.id_unidad_negocio FROM periodos_s_a ps INNER JOIN sucursales su ON ps.id_sucursal = su.id_sucursal WHERE ps.id_nomina_a = mb.id_nomina_a)
                                    ELSE (SELECT id_unidad_negocio FROM cuentas_bancos WHERE id = mb.id_cuenta_banco)
                                END AS id_unidad_negocio,
                                (SELECT id_unidad_negocio FROM cuentas_bancos WHERE id = mb.id_cuenta_banco) id_unidad_negocio2,
                                tipo,
                                transferencia,
                                monto,
                                fecha_aplicacion,
                                id_cuenta_banco,
                                id
                            FROM movimientos_bancos mb
                            WHERE mb.tipo NOT IN ('I', 'T')
                                AND YEAR(mb.fecha_aplicacion) = YEAR('$fechaInicio')
                        ) AS a
                    INNER JOIN cat_unidades_negocio c ON c.id = a.id_unidad_negocio                    
                    GROUP BY a.id_unidad_negocio, MONTH(a.fecha_aplicacion)
                    ORDER by a.id_unidad_negocio ASC, MONTH(a.fecha_aplicacion) ASC;";

                    // echo $query;
                    // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());  
        }

        if($reporte == 'especial2'){
            
            $query = "SELECT
                            a.id_unidad_negocio as ID,
                            c.nombre AS UNIDAD,
                            SUM(IF(a.tipo = 'I' OR a.tipo = 'A' OR (a.tipo = 'T' AND a.transferencia <> 0),a.monto,0)) as EGRESOS,
                            SUM(IF(a.tipo = 'C' OR (a.tipo = 'T' AND a.transferencia = 0),a.monto,0)) as INGRESOS,
                            SUM(IF(a.tipo = 'I' OR a.tipo = 'A' OR (a.tipo = 'T' AND a.transferencia <> 0),a.monto,0)) - SUM(IF(a.tipo = 'C' OR (a.tipo = 'T' AND a.transferencia = 0),a.monto,0)) AS SALDO,
                            MONTH(a.fecha_aplicacion) as MES
                            FROM (
                                SELECT 
                                    CASE
                                        WHEN mb.id_ingreso_sin_factura > 0 THEN (SELECT id_unidad_negocio FROM ingresos_sin_factura WHERE id = mb.id_ingreso_sin_factura)
                                        WHEN mb.id_psf > 0 THEN (SELECT id_unidad_negocio FROM pagos_sin_factura WHERE id = mb.id_psf)
                                        WHEN mb.id_cxc > 0 THEN (SELECT id_unidad_negocio FROM cxc WHERE id = mb.id_cxc)
                                        WHEN mb.id_gasto > 0 THEN (SELECT id_unidad_negocio FROM gastos WHERE id = mb.id_gasto)
                                        WHEN mb.id_viatico > 0 THEN (SELECT id_unidad_negocio FROM viaticos WHERE id = mb.id_viatico)
                                        WHEN mb.id_caja_chica > 0 THEN (SELECT id_unidad_negocio FROM caja_chica WHERE id = mb.id_caja_chica)
                                        WHEN mb.id_cxp > 0 THEN (SELECT id_unidad_negocio FROM cxp WHERE id = mb.id_cxp)
                                        WHEN mb.id_nomina > 0 THEN (SELECT su.id_unidad_negocio FROM periodos_s ps INNER JOIN sucursales su ON ps.id_sucursal = su.id_sucursal WHERE ps.id_nomina = mb.id_nomina)
                                        WHEN mb.id_nomina_a > 0 THEN (SELECT su.id_unidad_negocio FROM periodos_s_a ps INNER JOIN sucursales su ON ps.id_sucursal = su.id_sucursal WHERE ps.id_nomina_a = mb.id_nomina_a)
                                        ELSE (SELECT id_unidad_negocio FROM cuentas_bancos WHERE id = mb.id_cuenta_banco)
                                    END AS id_unidad_negocio,
                                    (SELECT id_unidad_negocio FROM cuentas_bancos WHERE id = mb.id_cuenta_banco) id_unidad_negocio2,
                                    tipo,
                                    transferencia,
                                    monto,
                                    fecha_aplicacion,
                                    id_cuenta_banco,
                                    id
                                FROM movimientos_bancos mb
                                WHERE mb.tipo NOT IN ('I', 'T')
                            ) AS a
                        INNER JOIN cat_unidades_negocio c ON c.id = a.id_unidad_negocio
                        WHERE YEAR(a.fecha_aplicacion) = YEAR('$fechaInicio')
                        GROUP BY a.id_unidad_negocio, MONTH(a.fecha_aplicacion)
                        ORDER by a.id_unidad_negocio ASC, MONTH(a.fecha_aplicacion) ASC;";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());  
        }

        if($reporte == "facCanceladas"){

            $query = "SELECT
                        su.descr FAMILIA,
                        fa.total AS EJERCIDO,
                        '' AS PRESUPUESTO,
                        fac.fecha_cancelacion FECHA,
                        rs.razon_social AS CLIENTE,
                        fa.FOLIO
                    FROM facturas fa
                    INNER JOIN cat_unidades_negocio cun ON cun.id = fa.id_unidad_negocio
                    INNER JOIN sucursales su ON fa.id_sucursal = su.id_sucursal
                    INNER JOIN facturas_cfdi fac ON fa.id = fac.id_factura
                    INNER JOIN razones_sociales rs ON rs.id = fa.id_razon_social
                    WHERE fa.estatus = 'C'
                        AND DATE(fac.fecha_cancelacion) >= '$fechaInicio'
                        AND DATE(fac.fecha_cancelacion) <= '$fechaFin'
                        AND fa.id_unidad_negocio = 1;";

            // echo $query;
            // exit();

            $resultado = $this->link->query($query);

            return query2json($resultado);
        }

        if($reporte == "detalleFacSuc"){

            $idSuc = $datos['id'];

            // $query = "SELECT
            //             cun.nombre,
            //             fa.id_unidad_negocio,
            //             su.descr AS FAMILIA,
            //             SUM(IF(fa.estatus <> 'C', fa.total,0)) AS EJERCIDO,
            //             SUM(IF(fa.estatus = 'C',fa.total, 0)) AS PRESUPUESTO
            //         FROM facturas fa
            //         INNER JOIN cat_unidades_negocio cun ON cun.id = fa.id_unidad_negocio
            //         INNER JOIN sucursales su ON fa.id_sucursal = su.id_sucursal
            //         WHERE DATE(fa.fecha_inicio) >= '$fechaInicio' AND DATE(fa.fecha_fin) <= '$fechaFin'
            //         GROUP BY fa.id_unidad_negocio, fa.id_sucursal";

            $query = "SELECT
                        fa.folio AS FOLIO,
                        DATE(fa.fecha_registro) AS FECHA,
                        fa.razon_social AS RAZON_SOCIAL,
                        CONCAT('$',FORMAT(fa.total,2)) as MONTO
                    FROM facturas fa
                    WHERE fa.estatus <> 'C'
                        AND (
                            (fa.anio BETWEEN YEAR('$fechaInicio') AND YEAR('$fechaFin') AND fa.mes BETWEEN MONTH('$fechaFin') AND MONTH('$fechaFin'))
                            OR
                            (DATE(fa.fecha_registro) >= '$fechaInicio' AND DATE(fa.fecha_registro) <= '$fechaFin')
                        ) AND fa.id_sucursal = $idSuc";

            // echo $query;
            // exit();

            $resultado = $this->link->query($query);

            return query2json($resultado);
        }

        if($resultado){

            echo query2json($resultado);
            
        }else{
            $html.="Error, en el Query";
        }

        return $html;
    }//-- fin function generaPresupuestoEgresosSeguimiento
    
}//--fin de class PresupuestoEgresosSeguimiento
    
?>