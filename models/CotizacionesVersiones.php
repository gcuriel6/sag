<?php

include 'conectar.php';

class CotizacionesVersiones
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function CotizacionesVersiones()
    {
  
      $this->link = Conectarse();

    }


    /**
      * Manda llamar a la funcion para generar una nueva version de un cotizacion
      *
      * @param varchar $datos es un array que contiene los parametros
      * 
      **/
    function guardarVersionCotizacion($datos){
        $verifica = 0;
  
       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");
  
        $verifica = $this -> guardarVersion($datos);
  
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
  
        return $verifica;
    }//--fin function guardarCotizaciones

     /**
      * Guarda una version de una cotización
      *
      * @param varchar $datos es un array que contiene los parametros
      * 
      **/ 
    function guardarVersion($datos){
        $verifica=0;

        $idCotizacion = $datos['idCotizacion'];    
        $idProyecto = $datos['idProyecto'];
        $idUsuario = $datos['idUsuario'];
        $usuario = $datos['usuario'];
        $justificacionVersion = $datos['justificacionVersion'];
        $necesidadVersion = $datos['necesidadVersion'];
        $estatusProyecto = $datos['estatusProyecto'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];

        //query para obtener el numero de cotizaciones mas uno para aumentar el numero de la version de la siguiente cotización
        $busca_cotizacion_proy="SELECT COUNT(id) AS total_cotizaciones 
                                  FROM cotizacion 
                                  WHERE id_proyecto=".$idProyecto;
        $result_busca_cotizacion_proy = mysqli_query($this->link,$busca_cotizacion_proy) or die(mysqli_error());
        
        if($result_busca_cotizacion_proy)
        {
          $row_x=mysqli_fetch_array($result_busca_cotizacion_proy);
          $total_cot=$row_x['total_cotizaciones'];
          $version=$total_cot + 1;

          $busca_cot="SELECT a.texto_inicio,a.texto_fin,a.observaciones_generales,a.id_cliente,b.descripcion AS nom_proyecto,a.periodicidad,a.tipo_facturacion,
                        a.fecha_inicio_facturacion,a.dia,a.id_firmante,a.firma_digital,a.id_razon_social_emisora,
                        a.elementos_observaciones_externas,
                        a.elementos_observaciones_internas,
                        a.equipo_observaciones_externas,
                        a.equipo_observaciones_internas,
                        a.servicios_observaciones_externas,
                        a.servicios_observaciones_internas,
                        a.vehiculos_observaciones_externas,
                        a.vehiculos_observaciones_internas,
                        a.consumibles_observaciones_externas,
                        a.consumibles_observaciones_internas 
                        FROM cotizacion a 
                        LEFT JOIN proyecto b ON a.id_proyecto=b.id 
                        WHERE a.id=".$idCotizacion;
          $result_busca_cot = mysqli_query($this->link,$busca_cot) or die(mysqli_error());
          
          if($result_busca_cot)
          {
            $row_cot=mysqli_fetch_array($result_busca_cot);

            $cotizacion = $row_cot['nom_proyecto'].' '.$version;
            $texto_inicio = $row_cot['texto_inicio'];
            $texto_fin = $row_cot['texto_fin'];
            $observaciones_generales = $row_cot['observaciones_generales'];
            $id_cliente = $row_cot['id_cliente'];
            $periodicidad = $row_cot['periodicidad'];
            $tipo_facturacion = $row_cot['tipo_facturacion'];
            $fecha_inicio_facturacion = $row_cot['fecha_inicio_facturacion']; 
            $dia = $row_cot['dia']; 
            $id_firmante = $row_cot['id_firmante'];
            $firma_digital = $row_cot['firma_digital'];
            $razon_social_emisora = $row_cot['id_razon_social_emisora'];
            $elementosObservacionesExternas = $row_cot['elementos_observaciones_externas'];
            $elementosObservacionesInternas = $row_cot['elementos_observaciones_internas'];
            $equipoObservacionesExternas = $row_cot['equipo_observaciones_externas'];
            $equipoObservacionesInternas = $row_cot['equipo_observaciones_internas'];
            $serviciosObservacionesExternas = $row_cot['servicios_observaciones_externas'];
            $serviciosObservacionesInternas = $row_cot['servicios_observaciones_internas'];
            $vehiculosObservacionesExternas = $row_cot['vehiculos_observaciones_externas'];
            $vehiculosObservacionesInternas = $row_cot['vehiculos_observaciones_internas'];
            $consumiblesObservacionesExternas = $row_cot['consumibles_observaciones_externas'];
            $consumiblesObservacionesInternas = $row_cot['consumibles_observaciones_internas'];

            $queryFolio="SELECT folio_cotizacion FROM cat_unidades_negocio WHERE id=".$idUnidadNegocio;
            $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
            if($resultF){
              $dato_folio=mysqli_fetch_array($resultF);
              $folioA=$dato_folio['folio_cotizacion'];
              $folio= $folioA+1;
    
              $queryU = "UPDATE cat_unidades_negocio SET folio_cotizacion='$folio' WHERE id=".$idUnidadNegocio;
              $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
              if($resultU){

                $insert_cotizacion="INSERT INTO cotizacion(folio,nombre,texto_inicio,texto_fin,estatus,version,
                                      justificacion_version,necesidad_version,id_proyecto,id_cliente,
                                      observaciones_generales,usuario_captura,id_usuario,periodicidad,
                                      tipo_facturacion,fecha_inicio_facturacion,dia,id_firmante,firma_digital,
                                      id_razon_social_emisora,elementos_observaciones_externas,elementos_observaciones_internas,
                                      equipo_observaciones_externas,equipo_observaciones_internas,servicios_observaciones_externas,
                                      servicios_observaciones_internas,vehiculos_observaciones_externas,vehiculos_observaciones_internas,
                                      consumibles_observaciones_externas,consumibles_observaciones_internas)
                                      VALUES('$folio','$cotizacion','$texto_inicio','$texto_fin',1,'$version',
                                      '$justificacionVersion','$necesidadVersion','$idProyecto','$id_cliente',
                                      '$observaciones_generales','$usuario','$idUsuario','$periodicidad',
                                      '$tipo_facturacion','$fecha_inicio_facturacion','$dia','$id_firmante',
                                      '$firma_digital','$razon_social_emisora','$elementosObservacionesExternas',
                                      '$elementosObservacionesInternas','$equipoObservacionesExternas','$equipoObservacionesInternas',
                                      '$serviciosObservacionesExternas','$serviciosObservacionesInternas','$vehiculosObservacionesExternas',
                                      '$vehiculosObservacionesInternas','$consumiblesObservacionesExternas','$consumiblesObservacionesInternas')";
                $result_cotizacion = mysqli_query($this->link,$insert_cotizacion) or die(mysqli_error());
                $idCotizacionV=mysqli_insert_id($this->link);
                
                if ($result_cotizacion)
                {
                    $verifica = $this -> cambiaEstatusProyectos($idProyecto,$estatusProyecto,$idCotizacion,$idCotizacionV);
                }else{
                    $verifica = 0;
                }

              }else{
                $verifica = 0;
              }
            }else{
              $verifica = 0;
            }

          }else{
            $verifica = 0;
          }
        }else{
          $verifica = 0;
        }
         
        return $verifica;
    } //--fin function guardarCotizacion
    
    function cambiaEstatusProyectos($idProyecto,$estatusProyecto,$idCotizacion,$idCotizacionV){

      $verifica=0;

      $busca_ultimo_id="SELECT id FROM cotizacion WHERE id_proyecto=".$idProyecto." ORDER BY id DESC LIMIT 1";
      $resultU = mysqli_query($this->link,$busca_ultimo_id) or die(mysqli_error());
      $datoU=mysqli_fetch_array($resultU);
      $idU=$datoU['id'];

      $queryC="SELECT GROUP_CONCAT(id)as idsC FROM cotizacion WHERE id_proyecto=".$idProyecto." AND id < ".$idU;
      $resulC = mysqli_query($this->link,$queryC) or die(mysqli_error());
      $datoC=mysqli_fetch_array($resulC);
      $idsC=$datoC['idsC'];
      

      ///se actualizan las cotizaciones anteriores a la ultima version, del proyecto a estatus impresa(2)
      $actualiza_estatus_cot_ant="UPDATE cotizacion SET estatus=2 WHERE id in ($idsC)";
      $result_actualiza_estatus_cot_ant = mysqli_query($this->link,$actualiza_estatus_cot_ant) or die(mysqli_error());

      if($result_actualiza_estatus_cot_ant)
      {
        if($estatusProyecto == 3 || $estatusProyecto == 4)
        {
          $actualiza_proyecto="UPDATE proyecto SET estatus=1,fecha_fin='0000-00-00 00:00:00' WHERE id=".$idProyecto;
          $result_actualiza = mysqli_query($this->link,$actualiza_proyecto) or die(mysqli_error());
          if($result_actualiza){
              $verifica = $this->guardaServiciosVersion($idCotizacion,$idCotizacionV);
          }else{
            $verifica =0;
          }
        }else{
            $actualiza_proyecto="UPDATE proyecto SET estatus=1 WHERE id=".$idProyecto;
            $result_actualiza = mysqli_query($this->link,$actualiza_proyecto) or die(mysqli_error());
            if($result_actualiza){
              $verifica = $this->guardaServiciosVersion($idCotizacion,$idCotizacionV);
            }else{ 
              $verifica =0;
            }
        }
      }else{
        $verifica = 0;
      }

      return $verifica;
    }

  /**
    * guardaServiciosVersion Genera una copia de una cotizacion y se asigna a una nueva version
    *
    * @param int $idCotizacion id de la cotizacion a la que se genera la version sirve para buscar sus elementos
    * @param int $idCotizacionV id de la nueva cotizacion
    *
    **/
  function guardaServiciosVersion($idCotizacion,$idCotizacionV){
    
    $verifica = 0;

    $busca_servicios="SELECT a.id,a.nombre,a.tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.observaciones,a.cantidad 
                        FROM cotizacion_servicios a
                        WHERE a.id_cotizacion=".$idCotizacion."
                        ORDER BY a.id";
    $res_busca_servicios = mysqli_query($this->link,$busca_servicios) or die(mysqli_error());
    $num = mysqli_num_rows($res_busca_servicios);
    $conS=0;

    if($num > 0)
    {
      while($datos = mysqli_fetch_array($res_busca_servicios)){

          $nombre = $datos['nombre'];
          $cantidad = $datos['cantidad'];
          $tipo_pago = $datos['tipo_pago'];
          $costo = $datos['costo'];
          $precio = $datos['precio'];
          $costo_total = $datos['costo_total'];
          $precio_total = $datos['precio_total'];
          $observaciones = $datos['observaciones'];

  
          $insert = "INSERT INTO cotizacion_servicios(nombre,tipo_pago,costo,precio,costo_total,precio_total,id_cotizacion,observaciones,cantidad)VALUES ('$nombre','$tipo_pago','$costo','$precio','$costo_total','$precio_total','$idCotizacionV','$observaciones','$cantidad')";
          $result = mysqli_query($this->link,$insert) or die(mysqli_error());
          $id_registro = mysqli_insert_id($this->link);
          
          if ($result) {
              $conS++;
              if($conS==$num){
                  $verifica = $this->guardaEquipoVersion($idCotizacion,$idCotizacionV);
              }
          }else{
              $verifica = 0;
              break;
          }
      }
    }else{
      $verifica = $this->guardaEquipoVersion($idCotizacion,$idCotizacionV);
    }

    return $verifica;
  }//-- fin function guardaServiciosVersion

  /**
    * guardaEquipoVersion Genera una copia de una cotizacion y se asigna a una nueva version
    *
    * @param int $idCotizacion id de la cotizacion a la que se genera la version sirve para buscar sus elementos
    * @param int $idCotizacionV id de la nueva cotizacion
    *
    **/
  function guardaEquipoVersion($idCotizacion,$idCotizacionV){
       
      $verifica = 0;

      $busca_equipos="SELECT a.id,a.nombre,a.tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.observaciones,a.cantidad,a.prorratear,b.estatus AS estatus
                        FROM cotizacion_equipo a
                        LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                        WHERE a.id_cotizacion=".$idCotizacion."
                        ORDER BY a.id";
      $res_busca_equipos = mysqli_query($this->link,$busca_equipos) or die(mysqli_error());
      $num = mysqli_num_rows($res_busca_equipos);

      $contEq=0;

      if($num > 0)
      {
        while($datos=mysqli_fetch_array($res_busca_equipos)){                               

            $nombre = $datos['nombre'];
            $cantidad = $datos['cantidad'];
            $tipo_pago = $datos['tipo_pago'];
            $costo = $datos['costo'];
            $precio = $datos['precio'];
            $costo_total = $datos['costo_total'];
            $precio_total = $datos['precio_total'];
            $observaciones = $datos['observaciones'];
            $prorratear = $datos['prorratear'];
      
            $insert = "INSERT INTO cotizacion_equipo(nombre,tipo_pago,costo,precio,costo_total,precio_total,id_cotizacion,observaciones,cantidad,prorratear)VALUES ('$nombre','$tipo_pago','$costo','$precio','$costo_total','$precio_total','$idCotizacionV','$observaciones','$cantidad','$prorratear')";
            $result = mysqli_query($this->link,$insert) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);
            
            if ($result) {
                $contEq++;
                if($contEq==$num){
                    $verifica = $this->guardaConsumiblesVersion($idCotizacion,$idCotizacionV);
                }
            }else{
                $verifica = 0;
                break;
            }
        }
      }else{
        $verifica = $this->guardaConsumiblesVersion($idCotizacion,$idCotizacionV);
      }
  
      return $verifica;
  }//-- fin function guardaEquipoVersion

  /**
    * guardaConsumiblesVersion Genera una copia de una cotizacion y se asigna a una nueva version
    *
    * @param int $idCotizacion id de la cotizacion a la que se genera la version sirve para buscar sus elementos
    * @param int $idCotizacionV id de la nueva cotizacion
    *
    **/
    function guardaConsumiblesVersion($idCotizacion,$idCotizacionV){
       
      $verifica = 0;

      $busca_consumibles="SELECT a.id,a.nombre,a.tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.observaciones,a.cantidad,a.prorratear,b.estatus AS estatus
                        FROM cotizacion_consumibles a
                        LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                        WHERE a.id_cotizacion=".$idCotizacion."
                        ORDER BY a.id";
      $res_busca_consumibles = mysqli_query($this->link,$busca_consumibles) or die(mysqli_error());
      $num = mysqli_num_rows($res_busca_consumibles);

      $contEq=0;

      if($num > 0)
      {
        while($datos=mysqli_fetch_array($res_busca_consumibles)){                               

            $nombre = $datos['nombre'];
            $cantidad = $datos['cantidad'];
            $tipo_pago = $datos['tipo_pago'];
            $costo = $datos['costo'];
            $precio = $datos['precio'];
            $costo_total = $datos['costo_total'];
            $precio_total = $datos['precio_total'];
            $observaciones = $datos['observaciones'];
            $prorratear = $datos['prorratear'];
      
            $insert = "INSERT INTO cotizacion_consumibles(nombre,tipo_pago,costo,precio,costo_total,precio_total,id_cotizacion,observaciones,cantidad,prorratear)
                        VALUES ('$nombre','$tipo_pago','$costo','$precio','$costo_total','$precio_total','$idCotizacionV','$observaciones','$cantidad','$prorratear')";
            $result = mysqli_query($this->link,$insert) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);
            
            if ($result) {
                $contEq++;
                if($contEq==$num){
                    $verifica = $this->guardaVehiculosVersion($idCotizacion,$idCotizacionV);
                }
            }else{
                $verifica = 0;
                break;
            }
        }
      }else{
        $verifica = $this->guardaVehiculosVersion($idCotizacion,$idCotizacionV);
      }
  
      return $verifica;
  }//-- fin function guardaConsumiblesVersion

  /**
    * guardaVehiculosVersion Genera una copia de una cotizacion y se asigna a una nueva version
    *
    * @param int $idCotizacion id de la cotizacion a la que se genera la version sirve para buscar sus elementos
    * @param int $idCotizacionV id de la nueva cotizacion
    *
    **/
  function guardaVehiculosVersion($idCotizacion,$idCotizacionV){
      $verifica = 0;
     
      $busca_vehiculos="SELECT a.id,a.nombre,a.tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.observaciones,a.cantidad
                              FROM cotizacion_vehiculos a
                              WHERE a.id_cotizacion=".$idCotizacion."
                              ORDER BY a.id";
      $res_busca_vehiculos = mysqli_query($this->link,$busca_vehiculos) or die(mysqli_error());
      $num = mysqli_num_rows($res_busca_vehiculos);
      
      $contV=0;

      if($num > 0)
      {
        while($datos=mysqli_fetch_array($res_busca_vehiculos)){ 

            $nombre = $datos['nombre'];
            $cantidad = $datos['cantidad'];
            $tipo_pago = $datos['tipo_pago'];
            $costo = $datos['costo'];
            $precio = $datos['precio'];
            $costo_total = $datos['costo_total'];
            $precio_total = $datos['precio_total'];
            $observaciones = $datos['observaciones'];
        
      
            $insert = "INSERT INTO cotizacion_vehiculos(nombre,tipo_pago,costo,precio,costo_total,precio_total,id_cotizacion,observaciones,cantidad) VALUES ('$nombre','$tipo_pago','$costo','$precio','$costo_total','$precio_total','$idCotizacionV','$observaciones','$cantidad')";
            $result = mysqli_query($this->link,$insert) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);
            
            if ($result) {
                $contV++;
                if($contV==$num){
                  $verifica = $this->guardaElementosVersion($idCotizacion,$idCotizacionV);
                }
            }else{
                $verifica = 0;
                break;
            }
        }
      }else{
        $verifica = $this->guardaElementosVersion($idCotizacion,$idCotizacionV);
      }
  
      return $verifica;
  }//-- fin function insertarVehiculos

  /**
    * guardaServiciosVersion Genera una copia de una cotizacion y se asigna a una nueva version
    *
    * @param int $idCotizacion id de la cotizacion a la que se genera la version sirve para buscar sus elementos
    * @param int $idCotizacionV id de la nueva cotizacion
    *
    **/  
  function guardaElementosVersion($idCotizacion,$idCotizacionV){
      
      $verifica = 0;
      ////////busca elementos de cotización anterior y los inserta en la nueva cotización
      $busca_elementos = "SELECT a.id,a.sueldo,a.bono,a.tiempo_extra,a.otros,a.observaciones,a.cantidad,a.vacaciones,a.aguinaldo,
                             a.festivo,a.dia_31,a.administrativo,a.infonavit,a.imss,a.costo,a.costo_total,a.precio,a.precio_total,a.id_salario,
                             d.puesto,b.estatus AS estatus,a.id_cuota_obrero,a.salario,a.id_razon_social,a.porcentaje_dispersion
                             FROM cotizacion_elementos a
                             LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                             LEFT JOIN cat_salarios c ON a.id_salario=c.id
                             LEFT JOIN cat_puestos d ON c.id_puesto=d.id_puesto
                             WHERE a.id_cotizacion=".$idCotizacion."
                             ORDER BY a.id";
      $res_busca_elementos = mysqli_query($this->link,$busca_elementos) or die(mysqli_error());
      $num = mysqli_num_rows($res_busca_elementos);
      
      if($num > 0)
      {
        while($datos = mysqli_fetch_array($res_busca_elementos)){
            $id_elemento = $datos['id'];
            $id_salario = $datos['id_salario'];
            $cantidad = $datos['cantidad'];
            $sueldo = $datos['sueldo'];
            $precio = $datos['precio'];
            $costo = $datos['costo'];
            $costo_total = $datos['costo_total'];
            $precio_total = $datos['precio_total'];
            $bono = $datos['bono'];
            $tiempo = $datos['tiempo_extra'];
            $otros = $datos['otros'];
            $vacaciones = $datos['vacaciones'];
            $aguinaldo = $datos['aguinaldo'];
            $festivo = $datos['festivo'];
            $dia31 = $datos['dia_31'];
            $costo_administrativo = $datos['administrativo'];
            $infonavit = $datos['infonavit'];
            $imss = $datos['imss'];
            $observaciones = $datos['observaciones'];
            $uniformes = $datos['uniformes'];
            $id_cuota_obrero = $datos['id_cuota_obrero'];
            $salario = $datos['salario'];
            $id_razon_social = $datos['id_razon_social'];
            $porcentaje_dispersion = $datos['porcentaje_dispersion'];

    
            $insert = "INSERT INTO cotizacion_elementos(id_salario,sueldo,costo,costo_total,precio,precio_total,bono,tiempo_extra,otros,vacaciones,aguinaldo,festivo,dia_31,administrativo,infonavit,imss,id_cuota_obrero,observaciones,cantidad,id_cotizacion,salario,id_razon_social,porcentaje_dispersion)
                        VALUES ('$id_salario','$sueldo','$costo','$costo_total','$precio','$precio_total','$bono','$tiempo','$otros','$vacaciones','$aguinaldo','$festivo','$dia31','$costo_administrativo','$infonavit','$imss','$id_cuota_obrero','$observaciones','$cantidad','$idCotizacionV','$salario','$id_razon_social','$porcentaje_dispersion')";
            $result = mysqli_query($this->link,$insert) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);
                
            if ($result) {
                $verifica = $this -> guardarUniformesVersion($idCotizacionV,$id_elemento,$id_registro);
            }else{
                $verifica = 0;
                break;
            }     
        }
      }else{
        $verifica = $idCotizacionV;
      }

      return $verifica;
  }// fin guardaElementosVersion

  /**
    * guarda los uniformes para elemento
    *
    * @param int $id_elemento al que pertenece los registros
    * @param varchar $uniformes array que contiene el id del uniforme y cantidad unidades
    * id_uniforme
    * cantidad 
    *
    **/
  function guardarUniformesVersion($idCotizacionV,$id_elemento,$id_registro){
      $version =0;
 
      $busca_uniformes = "SELECT a.id,a.id_uniforme,a.cantidad,b.nombre,b.descripcion,-- b.costo
                              a.costo_unitario,a.costo_total,a.costo_unitario_mensual
                             FROM uniformes_elementos a
                             LEFT JOIN cat_uniformes b ON a.id_uniforme=b.id
                             WHERE a.id_elemento=$id_elemento
                             ORDER BY a.id";
      $res_busca_elementos = mysqli_query($this->link,$busca_uniformes) or die(mysqli_error());
      $num = mysqli_num_rows($res_busca_elementos);
      
      if($num>0){
 
        while($datos = mysqli_fetch_array($res_busca_elementos)){
  
          $id_uniforme = $datos['id_uniforme'];
          $cantidad = $datos['cantidad'];
          $costo_unitario = $datos['costo_unitario'];
          $costo_total = $datos['costo_total'];
          $costo_unitario_mensual = $datos['costo_unitario_mensual'];

          $insert = "INSERT INTO uniformes_elementos(id_uniforme,cantidad,id_elemento,costo_unitario,costo_total,costo_unitario_mensual) 
                              VALUES ('$id_uniforme','$cantidad','$id_registro','$costo_unitario','$costo_total','$costo_unitario_mensual')";
          $result = mysqli_query($this->link,$insert) or die(mysqli_error());
          
          if ($result) {
              $verifica = $idCotizacionV;
          }else{
            $verifica = 0;
            break;
          }
        }
      }else{
        $verifica = $idCotizacionV;
      }
 
     return $verifica;
  }//-- fin function guardarUniformesVersion

}//--fin de class Cotizaciones
    
?>