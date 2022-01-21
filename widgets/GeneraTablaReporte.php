<?php

include 'conectar.php';

class GeneraTablaReporte
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function GeneraTablaReporte()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Buscamos registros y generamos archivo GeneraTablaReporte
      *
      * @param varchar $reporte para ver cual quert se va a generar
      * @param array $datos fltros para realizar el reporte
      *
    **/
    function obtieneTablaReporte($reporte,$datos){
      
        $html='';

        if($reporte == 'presupuesto_egresos_familia'){

            $idUnidad = $datos['idUnidad'];
            $idSucursal = $datos['idSucursal'];
            $idArea = $datos['idArea'];
            $idDepartamento = $datos['idDepartamento'];
            $mesInicial = $datos['mesInicial'];
            $mesFinal = $datos['mesFinal'];
            $anio = $datos['anio'];

            $condicionSucursal=($idSucursal>0)?' AND a.id_sucursal='.$idSucursal :'';
            $condicionArea=($idArea>0)?'AND a.id_area='.$idArea:'';
            $condicionDepartamentoS1=($idDepartamento>0)?' AND a.id_depto='.$idDepartamento :'';
            $condicionDepartamentoS2=($idDepartamento>0)?' AND a.id_departamento='.$idDepartamento :'';
            $condicionMesS1=($mesFinal>0)?'  AND a.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
            $condicionMesS2=($mesFinal>0)?'  AND MONTH(a.fecha_captura) BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
            $condicionAnioS1=($anio>0)?" AND a.anio=".$anio :" ";
            $condicionAnioS2=($anio>0)?" AND YEAR(a.fecha_captura)=".$anio :" ";

           echo  $query="SELECT tabla.familia AS Familia,IFNULL(SUM(tabla.presupuesto),0) AS Presupuesto,IFNULL(SUM(tabla.ejercido),0) AS ejercido,
            IF(tabla.presupuesto > 0,IFNULL((SUM(tabla.ejercido) * 100)/SUM(tabla.presupuesto),0),0) AS PORCENTAJE
            FROM (SELECT IFNULL(b.descr,'') AS familia,SUM(a.monto) AS presupuesto,0 AS ejercido
            FROM presupuesto_egresos a 
            LEFT JOIN fam_gastos b ON a.id_familia = b.id_fam
            WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionArea $condicionDepartamentoS1 
            $condicionAnioS1 $condicionMesS1
            UNION ALL
            SELECT IFNULL(b.descr,'') AS familia,0 AS presupuesto,SUM(a.monto) AS ejercido
            FROM movimientos_presupuesto a 
            LEFT JOIN fam_gastos b ON a.id_familia = b.id_fam
            WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionArea $condicionDepartamentoS2 
            $condicionAnioS2 $condicionMesS2
            GROUP BY a.id_familia) AS tabla
            GROUP BY tabla.familia
            ORDER BY tabla.familia ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($reporte == 'presupuesto_egresos_clasificacion'){

            $idUnidad = $datos['idUnidad'];
            $idSucursal = $datos['idSucursal'];
            $idArea = $datos['idArea'];
            $idDepartamento = $datos['idDepartamento'];
            $mesInicial = $datos['mesInicial'];
            $mesFinal = $datos['mesFinal'];
            $anio = $datos['anio'];

            $condicionSucursal=($idSucursal>0)?' AND a.id_sucursal='.$idSucursal :'';
            $condicionArea=($idArea>0)?'AND a.id_area='.$idArea:'';
            $condicionDepartamentoS1=($idDepartamento>0)?' AND a.id_depto='.$idDepartamento :'';
            $condicionDepartamentoS2=($idDepartamento>0)?' AND a.id_departamento='.$idDepartamento :'';
            $condicionMesS1=($mesFinal>0)?'  AND a.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
            $condicionMesS2=($mesFinal>0)?'  AND MONTH(a.fecha_captura) BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
            $condicionAnioS1=($anio>0)?" AND a.anio=".$anio :" ";
            $condicionAnioS2=($anio>0)?" AND YEAR(a.fecha_captura)=".$anio :" ";

            $query="SELECT tabla.familia AS Familia,tabla.clasificacion AS Clasificacion,IFNULL(SUM(tabla.presupuesto),0) AS Presupuesto,IFNULL(SUM(tabla.ejercido),0) AS ejercido,
            IF(tabla.presupuesto > 0,IFNULL((SUM(tabla.ejercido) * 100)/SUM(tabla.presupuesto),0),0) AS PORCENTAJE
            FROM (SELECT IFNULL(b.descr,'') AS familia,IFNULL(c.descr,'') AS clasificacion,SUM(a.monto) AS presupuesto,0 AS ejercido
            FROM presupuesto_egresos a 
            LEFT JOIN fam_gastos b ON a.id_familia = b.id_fam
            LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
            WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionArea $condicionDepartamentoS1 
            $condicionAnioS1 $condicionMesS1
            UNION ALL
            SELECT IFNULL(b.descr,'') AS familia,'' AS clasificacion,0 AS presupuesto,SUM(a.monto) AS ejercido
            FROM movimientos_presupuesto a 
            LEFT JOIN fam_gastos b ON a.id_familia = b.id_fam
            WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionArea $condicionDepartamentoS2 
            $condicionAnioS2 $condicionMesS2
            GROUP BY a.id_familia) AS tabla
            GROUP BY tabla.familia
            ORDER BY tabla.familia ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }
       

        if($resultado){

            $registro = mysqli_fetch_array($resultado);
            $columnas = sizeof($registro)/2;
            $campos = array_keys($registro);
            $html.="<table class='tablon'><thead><tr class='renglon'>";
            $cont=0;
            foreach($campos as $campo)
            {
                if(is_string($campo))
                {
                $campos2[$cont] = $campo;
            
                $html.="<th scope='col'>".$campo."</td>";
                $cont++;
                }
            }
            $html.="</tr></thead><tbody>";
            $resultado = mysqli_query( $this->link, $query);
            
            
            $saldo=0;  
            while($registro = mysqli_fetch_array($resultado))
            {
                $html.="<tr class='renglon_'.$reporte.'>";

                foreach($campos2 as $field)
                {
                    
                    $texto = $registro[$field];

                    $html.="<td>".$texto."</td>";
                    
                            
                }

                $html.="</tr>";
            }

            $html.="</tbody></table>";
            
        }else{
            $html.="Error, en el Query";
        }

        return $html;
    }//-- fin function generaGeneraTablaReporte
    
}//--fin de class GeneraTablaReporte
    
?>