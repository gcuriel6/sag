<?php

require_once('conectar.php');
require_once('PresupuestoEgresosBitacora.php');

class PresupuestoIngresosFacturacion
{

    public $link;

    function PresupuestoIngresosFacturacion()
    {

      $this->link = Conectarse();

    }

    function buscaInformacionPresupuesto($idUnidad, $idSucursal, $anio, $mes, $tipo, $idRazonSocial){
      $fecha = $anio.'-'.$mes;
      $condicionFecha1 = " AND (presupuesto_ingresos_facturacion.anio='$anio' AND presupuesto_ingresos_facturacion.mes='$mes')";
      $condicionFecha2 = " ('$fecha' BETWEEN DATE_FORMAT(contratos_cliente.fecha,'%Y-%m') AND DATE_FORMAT(contratos_cliente.vigencia,'%Y-%m'))";
      if($idRazonSocial>0){
        $condicionRazonSocial = "AND contratos_cliente.id_razon_social_factura=".$idRazonSocial;
      }else{
        $condicionRazonSocial = "";
      }
      if($idSucursal!=''){

        if (strpos($idSucursal, ',') !== false) {
          $dato=substr($idSucursal,1);
          $condicionSucursales=' AND proyecto.id_sucursal in ('.$dato.')';
        }else{
          $condicionSucursales=' AND proyecto.id_sucursal ='.$idSucursal;
        }

      }else{
        
        $condicionSucursales=' AND proyecto.id_sucursal = 0';
      }

      

     
      
      if($ipo=='anual'){
        $condicionFecha1 = " AND presupuesto_ingresos_facturacion.anio='$anio' ";
        $condicionFecha2 = " ('$anio' BETWEEN DATE_FORMAT(contratos_cliente.fecha,'%Y') AND DATE_FORMAT(contratos_cliente.vigencia,'%Y'))";
      }

      /** SE REALIZA EL QUERY QUE TRAERA LOS IDS DE COTIZACION QUE INTERVENDRAN (QUE TENGAN UN CONTRATO Y 
       * LA COTIZACION TENGA LAS LLAVEZ INGREDASD EL MES Y AÑO SE TOMA DEL CONTRATO TABLA(contratos_cliente))
       * Y LA CONDICION DE OTROS INGRESOS QUE CORRESPONDA PARA OBTENER EL PRESUPÚESTO */
     $queryB = "SELECT
                    sum(sub.id) as id,
                    sub.id_cotizacion,
                    sub.id_depto,               
                    sub.id_area,
                    sub.departamento,
                    IFNULL(sub.areas,'') as areas,
                    SUM(sub.otros_ingresos)AS otros_ingresos,
                    sub.observaciones as observaciones,
                    sub.folio_factura,
                    IFNULL(sub.razon_social,'') as razon_social,
                    IFNULL(if(sub.vencimiento ='0000-00-00','',sub.vencimiento),'') as  vencimiento, 
                    sub.sucursal
                  FROM(
                        (SELECT 
                            contratos_cliente.id_contrato AS id,
                            GROUP_CONCAT(DISTINCT(contratos_cliente.id_cotizacion)) id_cotizacion,
                            contratos_cliente.id_depto,
                            deptos.id_area,
                            deptos.des_dep AS departamento,
                            cat_areas.descripcion AS areas,
                            0 AS otros_ingresos,
                            '' AS observaciones,
                            IFNULL(facturas.folio,'') as folio_factura,
                            DATE_ADD(facturas.fecha, INTERVAL  IFNULL(facturas.dias_credito,0) DAY) as vencimiento,
                            empresas_fiscales.razon_social,
                            b.descr as sucursal
                          FROM contratos_cliente 
                          LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
                          LEFT JOIN cat_areas ON deptos.id_area=cat_areas.id
                          LEFT JOIN cotizacion ON contratos_cliente.id_cotizacion=cotizacion.id
                          LEFT JOIN proyecto ON cotizacion.id_proyecto = proyecto.id
                          LEFT JOIN facturas on contratos_cliente.id_contrato = facturas.id_contrato
                          LEFT JOIN sucursales ON facturas.id_sucursal=sucursales.id_sucursal
                          LEFT JOIN sucursales b ON proyecto.id_sucursal=b.id_sucursal
                          LEFT JOIN empresas_fiscales on contratos_cliente.id_razon_social_factura=empresas_fiscales.id_empresa
                          WHERE $condicionFecha2 AND proyecto.id_unidad_negocio=".$idUnidad." $condicionSucursales  $condicionRazonSocial                         
                          GROUP BY deptos.des_dep
                          ORDER BY contratos_cliente.fecha DESC) 
                        )AS sub
                  GROUP BY sub.id_depto";
       $resultB = mysqli_query($this->link, $queryB)or die (mysqli_error());
      $numB = mysqli_num_rows($resultB); 
      
      
       if($numB > 0){

         $total=0;

         while( $rowB = mysqli_fetch_array($resultB)){

          $idCotizacion = $rowB['id_cotizacion'];
          $otrosIngresos = $rowB['otros_ingresos'];
          $importeC = 0;
        
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

          $total = $importeC + $otrosIngresos;

          $arr[] = array(
            'id' => $rowB['id'],
            'id_departamento' => $rowB['id_depto'],
            'id_area' => $rowB['id_area'],
            'departamento' => $rowB['departamento'],
            'sucursal' => $rowB['sucursal'],
            'area' => $rowB['areas'],
            'importe' => $importeC,
            'otros_ingresos' => $otrosIngresos,
            'observaciones' => $rowB['observaciones'],
            'total' => $total,
            'folio_factura' => $rowB['folio_factura'],
            'vencimiento' => $rowB['vencimiento'],
            'razon_social' => $rowB['razon_social']

          );

         }
         
       }else{
          $arr = array();
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
      function guardarPresupuesto($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo)
      {

        $verifica = 0;

        /* VERIFICO SI EXISTE UNA INSECION DE ESTE MES Y AÑO CON LAS LLAVES */
        $buscaPresupuesto = "SELECT id 
                            FROM presupuesto_ingresos_facturacion 
                            WHERE modulo=0 AND id_unidad_negocio=".$idUnidad." AND id_sucursal=".$idSucursal." AND (anio='$anio' AND mes='$mes')";
        $resultP = mysqli_query($this->link, $buscaPresupuesto)or die (mysqli_error());
        $numP = mysqli_num_rows($resultP);   

        if($numP>0){
          
          $verifica = $this -> eliminarPresupuesto($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo);

        }else{
          
          $verifica = $this -> guardar($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo);
        }
        

        return $verifica;

      }

      /**
        * Borra presupuesto en caso de reemplazar
        * @param $anio int
        * @param $mes int
        * @param $tipo int
        * @return bool
        */
        function eliminarPresupuesto($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo)
        {
  
          $verifica = 0;
  
          $queryB = "DELETE FROM presupuesto_ingresos_facturacion WHERE id_unidad_negocio=".$idUnidad." AND id_sucursal=".$idSucursal." AND (anio = $anio AND mes = $mes)  AND modulo=0";
          $resultB = mysqli_query($this->link, $queryB);
         
          if($resultB)
            $verifica = $this -> guardar($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo);
          
        
  
          return $verifica;
  
        }


      
      
      function guardar($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo)
      {
        $verifica = 0;
        
        for($i=1;$i <= $datos[0];$i++){

          $idArea = $datos[$i]['idArea'];
          $idDepto = $datos[$i]['idDepartamento'];
          $importe = $datos[$i]['importe'];
          $otrosIngresos = $datos[$i]['otrosIngresos'];
          $observaciones = $datos[$i]['observaciones'];
          $total = $datos[$i]['total'];
          $factura = $datos[$i]['factura'];
          $vencimiento = $datos[$i]['vencimiento'];
          $camposModificados = $datos[$i]['camposModificados'];

          $queryT = "INSERT INTO presupuesto_ingresos_facturacion (id_unidad_negocio, id_sucursal, id_area, id_depto,observaciones,importe,otros_ingresos, anio, mes, monto, modulo, factura, vencimiento) 
                    VALUES ('$idUnidad', '$idSucursal', '$idArea', '$idDepto', '$observaciones', '$importe', '$otrosIngresos', '$anio', '$mes', '$total',0, '$factura', '$vencimiento')";
          $result = mysqli_query($this->link, $queryT);
          $idRegistro = mysqli_insert_id($this->link);
          if($result){

            $modeloPresupuestoEgresosBitacora = new PresupuestoEgresosBitacora();

            $arr = array(
              'camposModificados'=>$camposModificados,
              'modulo'=>$modulo,
              'idUnidadNegocio'=>$idUnidad,
              'idSucursal'=>$idSucursal,
              'idRegistro'=>$idRegistro,
              'idUsuario'=>$idUsuario
            );

            if($camposModificados != ''){
              $result2 =  $modeloPresupuestoEgresosBitacora->guardarPresupuestoEgresosBitacora($arr);
            }else{
              $result2 = 1;
            }
            
            if($result2 > 0)
            {
              if($i==$datos[0]){
             
                $verifica = $idRegistro;
              
              }
            }else{
                
                $verifica = 0;
                break;
            }
            
          }else{
            $verifica = 0;
            break;
          }
            
        }

        return $verifica;

      }


      function verificarSiHayInsercion($idUnidad,$idSucursal,$anio,$mes){
        $verifica = 0;
         /* VERIFICO SI EXISTE UNA INSECION DE ESTE MES Y AÑO CON LAS LLAVES */
         $buscaPresupuesto = "SELECT id 
         FROM presupuesto_ingresos_facturacion 
         WHERE modulo=0 AND id_unidad_negocio=".$idUnidad." AND id_sucursal=".$idSucursal." AND (anio='$anio' AND mes='$mes')";
          $resultP = mysqli_query($this->link, $buscaPresupuesto)or die (mysqli_error());
          $numP = mysqli_num_rows($resultP);   

          if($numP>0)
            $verifica = 1;
          
          return $verifica;
      }

}
    
?>