<?php

include 'conectar.php';

class Excel
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Excel()
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
    function generaExcel($nombre,$modulo,$fecha,$datos){
        
        header("Content-type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: filename=" .$nombre. "_" .$fecha. ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $html='';

        if($modulo == 'ENCUESTA'){

            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
            
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            $query="SELECT 
                b.pregunta AS Pregunta,
                SUM(IF(respuesta=1, 1,0)) AS Malo ,
                SUM(IF(respuesta=2, 1,0)) AS Regular,
                SUM(IF(respuesta=3, 1,0)) AS Satisfecho,
                b.fecha_captura AS Fecha_Alta,
                IF(b.fecha_inactivacion='0000-00-00','',b.fecha_inactivacion) AS Fecha_Inactiva
            FROM encuestas_d a
            LEFT JOIN  preguntas b ON a.id_pregunta=b.id
            WHERE DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin'
            GROUP BY a.id_pregunta";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
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

                    }else{
                        $html.="<td valign='top'>".$texto."</td>";
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