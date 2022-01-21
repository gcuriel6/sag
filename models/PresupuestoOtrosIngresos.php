<?php

require_once('conectar.php');

class PresupuestoOtrosIngresos
{

    public $link;

    function PresupuestoOtrosIngresos()
    {

      $this->link = Conectarse();

    }

    function buscaInformacionPresupuesto($idUnidad, $idSucursal, $anio, $mes, $idDepartamento, $idArea){
      $fecha = $anio.'-'.$mes;
      $condicionFecha1 = " AND (presupuesto_ingresos.anio='$anio' AND presupuesto_ingresos.mes='$mes')";
      $condicionFecha2 = " ('$fecha' BETWEEN DATE_FORMAT(contratos_cliente.fecha,'%Y-%m') AND DATE_FORMAT(contratos_cliente.vigencia,'%Y-%m'))";
      
      if($ipo=='anual'){
        $condicionFecha1 = " AND presupuesto_ingresos.anio='$anio' ";
        $condicionFecha2 = " ('$anio' BETWEEN DATE_FORMAT(contratos_cliente.fecha,'%Y') AND DATE_FORMAT(contratos_cliente.vigencia,'%Y'))";
      }
      /* CONDICION PARA BUSCAR OTROS INGRESOS SI ES LA PRIMERA VEZ QUE SE HACE LA BUSQUEDA 
      O SI AUN NO HAY REGISTROS GUARDADOS DEL MODULO DE PRESUPUESTO INGRESOS (MODULO=0)*/
      $condicionOtrosIngresos="SELECT 
                                  0  AS id,
                                  0 AS id_cotizacion,
                                  SUM(presupuesto_ingresos.otros_ingresos) AS otros_ingresos,
                                  IFNULL(presupuesto_ingresos.observaciones,'') as observaciones
                                FROM presupuesto_ingresos
                                WHERE presupuesto_ingresos.modulo=1 $condicionFecha1 AND presupuesto_ingresos.id_unidad_negocio=".$idUnidad."  AND presupuesto_ingresos.id_sucursal=".$idSucursal." AND presupuesto_ingresos.id_depto=".$idDepartamento." AND presupuesto_ingresos.id_area=".$idArea."
                                ORDER BY presupuesto_ingresos.id DESC";
      /* VERIFICO SI EXISTE UNA INSECION DE ESTE MES Y AÑO CON LAS LLAVES */
      $buscaPresupuesto = "SELECT id 
                           FROM presupuesto_ingresos 
                           WHERE modulo=0 AND id_unidad_negocio=".$idUnidad." AND id_sucursal=".$idSucursal." AND (anio='$anio' AND mes='$mes') AND id_depto=".$idDepartamento." AND id_area=".$idArea;
      $resultP = mysqli_query($this->link, $buscaPresupuesto)or die (mysqli_error());
      $numP = mysqli_num_rows($resultP);   
      
      if($numP>0){
        /** SI EXISTE REGISTRO DE LA BUSUQEDA LA CONDICION PARA CALCULA LOS OTROS INGRESOS SERA DE LA INFOMACION ENCONTRADA DEL MODULO 0 */
        $condicionOtrosIngresos="SELECT 
                                  presupuesto_ingresos.id,
                                  0 AS id_cotizacion,
                                  SUM(presupuesto_ingresos.otros_ingresos) AS otros_ingresos,
                                  IFNULL(presupuesto_ingresos.observaciones,'') as observaciones
                                FROM presupuesto_ingresos
                                WHERE presupuesto_ingresos.modulo=0 $condicionFecha1 AND presupuesto_ingresos.id_unidad_negocio=".$idUnidad."  AND presupuesto_ingresos.id_sucursal=".$idSucursal." AND presupuesto_ingresos.id_depto=".$idDepartamento." AND presupuesto_ingresos.id_area=".$idArea."
                                ORDER BY presupuesto_ingresos.id DESC";

      }

     
      /** SE REALIZA EL QUERY QUE TRAERA LOS IDS DE COTIZACION QUE INTERVENDRAN (QUE TENGAN UN CONTRATO Y 
       * LA COTIZACION TENGA LAS LLAVEZ INGREDASD EL MES Y AÑO SE TOMA DEL CONTRATO TABLA(contratos_cliente))
       * Y LA CONDICION DE OTROS INGRESOS QUE CORRESPONDA PARA OBTENER EL PRESUPÚESTO */
      $queryB = "SELECT
                    sum(sub.id) as id,
                    sub.id_cotizacion,
                    SUM(sub.otros_ingresos)AS otros_ingresos,
                    sub.observaciones as observaciones,
                    IF('$mes'<=MONTH(CURDATE()),'no','si') AS editar
                  FROM(
                        (SELECT 
                            0 AS id,
                            GROUP_CONCAT(contratos_cliente.id_cotizacion) id_cotizacion,
                            0 AS otros_ingresos,
                            '' AS observaciones
                          FROM contratos_cliente 
                          LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
                          LEFT JOIN cat_areas ON deptos.id_area=cat_areas.id
                          LEFT JOIN cotizacion ON contratos_cliente.id_cotizacion=cotizacion.id
                          LEFT JOIN proyecto ON cotizacion.id_proyecto = proyecto.id
                          WHERE $condicionFecha2 AND proyecto.id_unidad_negocio=".$idUnidad." AND proyecto.id_sucursal=".$idSucursal."  AND  contratos_cliente.id_depto=".$idDepartamento." AND   deptos.id_area=".$idArea."                     
                          ORDER BY contratos_cliente.fecha DESC)
                        UNION
                        ($condicionOtrosIngresos) 
                        )AS sub";
       $resultB = mysqli_query($this->link, $queryB)or die (mysqli_error());
       $numB = mysqli_num_rows($resultB); 
      
       if($numB > 0){

         $total=0;

         while( $rowB = mysqli_fetch_array($resultB)){

          $idCotizacion = $rowB['id_cotizacion'];
          $otrosIngresos = $rowB['otros_ingresos'];
          $importeC = 0;
          if($idCotizacion!=''){
            /* UNA VEZ QUE SE ONTIENEN LAS COTIZACIONES SE OBTINE EL TOTAL DE CADA UNA Y SE AGRUPA POR DEARTAMENTO */  
            $buscaTotal = "SELECT SUM(importe_cotizacion.costo_mensual)AS total
                          FROM  (SELECT IFNULL(SUM(costo_total),0) AS costo_mensual
                                  FROM cotizacion_elementos  WHERE id_cotizacion in (".$idCotizacion.")
                                  UNION ALL
                                  SELECT IFNULL(SUM(IF(tipo_pago = 1 AND prorratear = 0,costo_total,0)),0) AS costo_mensual
                                  FROM cotizacion_equipo WHERE id_cotizacion in (".$idCotizacion.")
                                  UNION ALL
                                  SELECT IFNULL(SUM(IF(tipo_pago = 1,costo_total,0)),0) AS costo_mensual
                                  FROM cotizacion_servicios WHERE id_cotizacion in(".$idCotizacion.")
                                  UNION ALL
                                  SELECT IFNULL(SUM(IF(tipo_pago = 1,costo_total,0)),0) AS costo_mensual
                                  FROM cotizacion_vehiculos WHERE id_cotizacion in (".$idCotizacion.")) AS importe_cotizacion";
            $resultT = mysqli_query($this->link, $buscaTotal)or die (mysqli_error());
            $numT = mysqli_num_rows($resultT); 

            if($numT > 0){

              $rowT = mysqli_fetch_array($resultT);
              $importeC = $rowT['total'];

            }  
          }

          $total = $importeC + $otrosIngresos;

          $arr[] = array(
            'id' => $rowB['id'],
            'importe' => $importeC,
            'otros_ingresos' => $otrosIngresos,
            'observaciones' => $rowB['observaciones'],
            'total' => $total,
            'editar' => $rowB['editar']

          );

         }
         
       }else{

          $queryB = "SELECT IF('$mes'<=MONTH(CURDATE()),'no','si') AS editar";
          $resultB = mysqli_query($this->link, $queryB)or die (mysqli_error());
          $numB = mysqli_num_rows($resultB);
          $rowB= mysqli_fetch_array($resultB);
         
          $arr[] = array(
            'id' => 0,
            'importe' => 0,
            'otros_ingresos' => 0,
            'observaciones' => '',
            'total' => 0,
            'editar' => $rowB['editar']

          );
       }  

       return json_encode($arr);
    }




      /**
        * Recorre los diferentes registros de presupuesto para guardar
        * @param $idUnidad int
        * @param $idSucursal int
        * @param $anio int
        * @param $mes int
        * @param $tipo int
        * @return bool
        */
      function  guardarOtrosIngresos($idRegistro, $idUnidad, $idSucursal, $anio, $mes, $idDepartamento, $idArea, $otrosIngresos, $observaciones, $total)
      {

        $verifica = 0;
        
        $verifica = $this -> guardar($idRegistro, $idUnidad, $idSucursal, $anio, $mes, $idDepartamento, $idArea, $otrosIngresos, $observaciones, $total);

        return $verifica;

      }

     
    
      function guardar($idRegistro, $idUnidad, $idSucursal, $anio, $mes, $idDepartamento, $idArea, $otrosIngresos, $observaciones, $total)
      {
          $verifica = 0;
          $idNuevoRegistro = $idRegistro;

          if($idRegistro == 0){

            $queryT = "INSERT INTO presupuesto_ingresos (id_unidad_negocio, id_sucursal, id_area, id_depto,observaciones,importe,otros_ingresos, anio, mes, monto, modulo) 
                      VALUES ('$idUnidad', '$idSucursal', '$idArea', '$idDepartamento', '$observaciones',0, '$otrosIngresos', '$anio', '$mes', '$total',1)";
            $result = mysqli_query($this->link, $queryT) or die (mysqli_error());
            $idNuevoRegistro = mysqli_insert_id($this->link);
          }else{

            $queryT = "UPDATE presupuesto_ingresos SET otros_ingresos='$otrosIngresos', observaciones='$observaciones', total='$total' WHERE id=".$idRegistro;
            $result = mysqli_query($this->link, $queryT);
          
          }

          if($result){
  
            $verifica = $idNuevoRegistro;
            
          }else{
            
            $verifica = 0;
            
          }
            
        

        return $verifica;

      }

}
    
?>