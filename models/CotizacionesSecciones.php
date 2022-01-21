<?php

include 'conectar.php';

class CotizacionesSecciones
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function CotizacionesSecciones()
    {
  
      $this->link = Conectarse();

    }

  //-----------Se incluyen funciones para guardar, buscar, eliminar datos elementos, equipos, servicios y vehiculos que pertenecen a secciones (de cotizaciones)-----------//
  
  /**
    * Busca los datos de equipos que pertenecen a una cotizacion, retorna un JSON con los datos correspondientes
    *
    * @param int $idCotizacion para buscar los equipos que pértenecen a ese id
    *
    **/
  function buscarEquipos($idCotizacion){
        $result = $this->link->query("SELECT a.id,a.nombre,a.tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.observaciones,a.cantidad,a.prorratear,b.estatus AS estatus
                                        FROM cotizacion_equipo a
                                        LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                                        WHERE a.id_cotizacion=".$idCotizacion."
                                        ORDER BY a.id");

        return query2json($result);
  }//-- fin function buscarEquipos
  
  /**
    * Busca los datos de un equipo, retorna un JSON con los datos correspondientes
    *
    * @param int $idEquipo para buscar los datos de equipo en especifico
    *
    **/
  function buscarEquiposId($idEquipo){
        $result = $this->link->query("SELECT id,nombre,tipo_pago,costo,precio,costo_total,precio_total,observaciones,cantidad,prorratear
                                        FROM cotizacion_equipo 
                                        WHERE id=".$idEquipo);

        return query2json($result);
  }//-- fin function buscarEquiposId

  /**
    * Guarda un registro
    *
    * @param varchar $datos array con datos de equipo a guardar
    *
    **/
  function guardarEquipos($datos){
        $verifica = 0;
        
       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> insertarEquipos($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
  }//-- fin function guardarEquipos

  /**
    * Guarda un registro
    *
    * @param varchar $datos array con datos de equipo a guardar
    *
    * nombre - del equipo
    * cantidad - numero unidades de equipo
    * tipo_pago - 1=pago mensual 2=pago unico
    * costo - cantidad sueldo mensual
    * precio - cantidad precio
    * costo_total - cantidad calculada de costo * cantidad
    * precio_total - cantidad calculada de precio * cantidad
    * observaciones - texto adicional
    * prorratear - 1=si se prorratea 0=no se prorratea
    * idCotizacion - id de la cotizacion a la cual pertenece el equipo
    *
    **/
  function insertarEquipos($datos){
        $verifica = 0;

        $nombre = $datos['nombre'];
        $cantidad = $datos['cantidad'];
        $tipo_pago = $datos['tipo_pago'];
        $costo = $datos['costo'];
        $precio = $datos['precio'];
        $costo_total = $datos['costoTotal'];
        $precio_total = $datos['precioTotal'];
        $observaciones = $datos['observaciones'];
        $prorratear = $datos['prorratear'];
        $idCotizacion = $datos['idCotizacion'];

        $busqueda="SELECT id,cantidad 
                    FROM cotizacion_equipo 
                    WHERE nombre='$nombre' AND tipo_pago='$tipo_pago' AND costo='$costo' 
                    AND precio='$precio' AND observaciones='$observaciones' AND id_cotizacion=".$idCotizacion;
        $result_busqueda= mysqli_query($this->link,$busqueda) or die(mysqli_error());
        $num = mysqli_num_rows($result_busqueda);

        if($num > 0)
        {
            $row=mysqli_fetch_array($result_busqueda);
            $id_equipo=$row['id'];
            $cantidad_ant=$row['cantidad'];
            $cant_total=$cantidad_ant+$cantidad;
            $costo_tot=$costo*$cantidad;
            $precio_tot=$precio*$cantidad;

            $update = "UPDATE cotizacion_equipo SET 
                        cantidad='$cant_total',
                        costo_total='$costo_tot',
                        precio_total='$precio_tot' 
                        WHERE id=".$id_equipo;
            $result = mysqli_query($this->link,$update) or die(mysqli_error());

            if($result){
                $verifica = $id_equipo;
            }else{
                $verifica = 0;
            }
        }else{
            $insert = "INSERT INTO cotizacion_equipo(nombre,tipo_pago,costo,precio,costo_total,precio_total,id_cotizacion,observaciones,cantidad,prorratear) 
						VALUES ('$nombre','$tipo_pago','$costo','$precio','$costo_total','$precio_total','$idCotizacion','$observaciones','$cantidad','$prorratear')";
            $result = mysqli_query($this->link,$insert) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);
            
            if ($result) {
                $verifica = $id_registro;
            }else{
                $verifica = 0;
            }
        }
    
        return $verifica;
  }//-- fin function insertarEquipos

  /**
    * Elimina un registro
    *
    * @param int $idEquipo de registro para borrar
    *
    **/
  function eliminarEquipos($idEquipo){
        $query = "DELETE FROM cotizacion_equipo WHERE id =".$idEquipo;
        $result=mysqli_query($this->link,$query)or die(mysqli_error());

        if ($result) {
            $verifica = 1;
        }else{
            $verifica = 0;
        }

        return $verifica;
  }//-- fin function eliminarEquipos

  function buscarEquipoProrrateo($idCotizacion){
    $result = $this->link->query("SELECT (IFNULL(SUM(a.costo_total),0))+(IFNULL(SUM(b.costo_total),0)) AS prorrateo
              FROM cotizacion_equipo a
              LEFT JOIN cotizacion_consumibles b ON a.id_cotizacion=b.id_cotizacion AND b.prorratear=1
              WHERE a.id_cotizacion=$idCotizacion AND a.prorratear=1");

      return query2json($result);
  }//-- fin function buscarEquipoProrrateo

  /**
    * Busca los datos de Elementos que pertenecen a una cotizacion, retorna un JSON con los datos correspondientes
    *
    * @param int $idCotizacion para buscar los Elementos que pértenecen a ese id
    *
    **/
  function buscarElementos($idCotizacion){
      $result = $this->link->query("SELECT a.id,a.sueldo,a.bono,a.tiempo_extra,a.otros,a.observaciones,a.cantidad,a.vacaciones,a.aguinaldo,
                                      a.festivo,a.dia_31,a.administrativo,a.infonavit,a.imss,a.costo,a.costo_total,a.precio,a.precio_total,a.id_salario,
                                      d.puesto,g.estatus AS estatus,-- IFNULL(SUM(e.cantidad*f.costo),0) AS uniformes,
                                      IFNULL(SUM(e.costo_unitario_mensual),0) AS uniformes,
                                      IFNULL(a.costo - (a.sueldo + a.bono + a.tiempo_extra + a.otros + a.vacaciones + a.aguinaldo + a.festivo + a.dia_31 + a.administrativo + a.infonavit + a.imss + IFNULL(SUM(e.costo_unitario_mensual),0)),0) AS dispersion,
                                      a.id_cuota_obrero,h.salario_diario,h.id_razon_social,i.razon_social
                                      FROM cotizacion_elementos a
                                      LEFT JOIN cotizacion g ON a.id_cotizacion=g.id
                                      LEFT JOIN cat_salarios c ON a.id_salario=c.id
                                      LEFT JOIN cat_puestos d ON c.id_puesto=d.id_puesto
                                      LEFT JOIN uniformes_elementos e ON a.id=e.id_elemento
                                      LEFT JOIN cat_uniformes f ON e.id_uniforme=f.id
                                      LEFT JOIN cat_cuotas_obrero h ON a.id_cuota_obrero=h.id    
                                      LEFT JOIN empresas_fiscales i ON h.id_razon_social=i.id_empresa 
                                      WHERE a.id_cotizacion=$idCotizacion
                                      GROUP BY a.id
                                      ORDER BY a.id");

      return query2json($result);
  }//-- fin function buscarElementos
    
  /**
    * Busca los datos de un Elemento, retorna un JSON con los datos correspondientes
    *
    * @param int $idElemento para buscar los datos de Elemento en especifico
    *
    **/
  function buscarElementosId($idElemento){
      $result = $this->link->query("SELECT a.id,a.sueldo,a.costo,a.costo_total,a.precio,a.precio_total,a.bono,a.tiempo_extra,a.otros,a.observaciones,a.cantidad,a.vacaciones,                                         
                                      a.aguinaldo,a.festivo,a.dia_31,a.administrativo,a.infonavit,a.imss,a.id_salario,c.puesto,a.porcentaje_dispersion, -- b.porcentaje_dispersion,
                                      IFNULL(a.costo - (a.sueldo + a.bono + a.tiempo_extra + a.otros + a.vacaciones + a.aguinaldo + a.festivo + a.dia_31 + a.administrativo + a.infonavit + a.imss + IFNULL(SUM(d.costo_unitario_mensual),0)),0) AS dispersion,
                                      a.id_cuota_obrero,f.salario_diario,f.id_razon_social,g.razon_social,a.salario,a.id_razon_social AS id_razon_social_capturada,h.razon_social AS razon_social_capturada
                                      FROM cotizacion_elementos a
                                      LEFT JOIN cat_salarios b ON a.id_salario=b.id
                                      LEFT JOIN cat_puestos c ON b.id_puesto=c.id_puesto
                                      LEFT JOIN uniformes_elementos d ON a.id=d.id_elemento
                                      LEFT JOIN cat_uniformes e ON d.id_uniforme=e.id
                                      LEFT JOIN cat_cuotas_obrero f ON a.id_cuota_obrero=f.id
                                      LEFT JOIN empresas_fiscales g ON f.id_razon_social=g.id_empresa
                                      LEFT JOIN empresas_fiscales h ON a.id_razon_social=h.id_empresa
                                      WHERE a.id=".$idElemento);

      return query2json($result);
  }//-- fin function buscarElementosId
  
  /**
    * Guarda un registro
    *
    * @param varchar $datos array con datos de Elemento a guardar
    *
    **/
  function guardarElementos($datos){
      $verifica = 0;
          
     $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> insertarElementos($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
  }//-- fin function guardarElementos

  /**
    * Guarda un registro
    *
    * @param varchar $datos array con datos de elemento a guardar
    *
    * id_salario
    * cantidad
    * sueldo
    * precio
    * costo
    * costo_total
    * precio_total
    * bono
    * tiempo
    * otros
    * vacaciones
    * aguinaldo
    * festivo
    * costo_administrativo
    * infonavit
    * imss
    * observaciones
    * idCotizacion - id de la cotizacion a la cual pertenece el equipo
    * uniformes
    *
    **/
  function insertarElementos($datos){
      $verifica = 0;

      $id_salario = $datos['id_salario'];
      $cantidad = $datos['cantidad'];
      $sueldo = $datos['sueldo'];
      $precio = $datos['precio'];
      $costo = $datos['costo'];
      $costo_total = $datos['costo_total'];
      $precio_total = $datos['precio_total'];
      $bono = $datos['bono'];
      $tiempo = $datos['tiempo'];
      $otros = $datos['otros'];
      $vacaciones = $datos['vacaciones'];
      $aguinaldo = $datos['aguinaldo'];
      $festivo = $datos['festivo'];
      $dia31 = $datos['dia31'];
      $costo_administrativo = $datos['costo_administrativo'];
      $infonavit = $datos['infonavit'];
      $imss = $datos['imss'];
      $observaciones = $datos['observaciones'];
      $idCotizacion = $datos['idCotizacion'];
      $uniformes = $datos['uniformes'];
      $idCuotaObrero = $datos['idCuotaObrero'];
      $salario = $datos['salario'];
      $id_razon_social = $datos['id_razon_social'];
      $porcentaje_dispersion = $datos['porcentaje_dispersion'];

      //-->NJES Sep/29/2020 verificar por id salario o monto salario el registro, sino guardar salario o id_salario segun el que venga mayotr a 0
      if($id_salario == 0)
        $cond_salario = " salario='$salario' AND id_razon_social='$id_razon_social'";
      else
        $cond_salario = " id_salario='$id_salario' AND id_cuota_obrero='$idCuotaObrero'";

      $busqueda="SELECT id,cantidad 
                  FROM cotizacion_elementos 
                  WHERE $cond_salario AND sueldo='$sueldo' AND precio='$precio' AND bono='$bono' 
                  AND tiempo_extra='$tiempo' AND otros='$otros' AND vacaciones='$vacaciones' 
                  AND aguinaldo='$aguinaldo' AND festivo='$festivo' AND dia_31='$dia31' 
                  AND administrativo='$administrativo' AND infonavit='$infonavit' AND imss='$imss' 
                  AND observaciones='$observaciones' AND porcentaje_dispersion='$porcentaje_dispersion' 
                  AND id_cotizacion=".$idCotizacion;
      $result_busqueda= mysqli_query($this->link,$busqueda) or die(mysqli_error());
      $num = mysqli_num_rows($result_busqueda);

      if($num > 0)
      {
          $row=mysqli_fetch_array($result_busqueda);
          $id_elemento=$row['id'];
          $cantidad_ant=$row['cantidad'];
          $cant_total=$cantidad_ant+$cantidad;
          $costo_a=$costo_total*$cant_total;
          $precio_a=$precio_total*$cant_total;

          $update = "UPDATE cotizacion_elementos SET 
                      cantidad='$cant_total',
                      costo_total='$costo_a',
                      precio_total='$precio_a' 
                      WHERE id=".$id_elemento;
          $result = mysqli_query($this->link,$update) or die(mysqli_error());

          if($result){
              $verifica = $this -> guardarUniformes($id_elemento,$uniformes);
            }else{
              $verifica = 0;
          }
      }else{
          $insert = "INSERT INTO cotizacion_elementos(id_salario,sueldo,costo,costo_total,precio,precio_total,bono,tiempo_extra,otros,vacaciones,aguinaldo,festivo,dia_31,administrativo,infonavit,imss,id_cuota_obrero,observaciones,cantidad,id_cotizacion,salario,id_razon_social,porcentaje_dispersion) 
          VALUES ('$id_salario','$sueldo','$costo','$costo_total','$precio','$precio_total','$bono','$tiempo','$otros','$vacaciones','$aguinaldo','$festivo','$dia31','$costo_administrativo','$infonavit','$imss','$idCuotaObrero','$observaciones','$cantidad','$idCotizacion','$salario','$id_razon_social','$porcentaje_dispersion')";
          $result = mysqli_query($this->link,$insert) or die(mysqli_error());
          $id_registro = mysqli_insert_id($this->link);
          
          if ($result) {
              $verifica = $this -> guardarUniformes($id_registro,$uniformes);
          }else{
              $verifica = 0;
          }
      }
  
      return $verifica;
  }//-- fin function insertarEquipos

  /**
    * guarda los uniformes para elemento
    *
    * @param int $id_elemento al que pertenece los registros
    * @param varchar $uniformes array que contiene el id del uniforme y cantidad unidades
    * id_uniforme
    * cantidad 
    *
    **/
  function guardarUniformes($id_elemento,$uniformes){
      $num=$uniformes[0];
      if($num > 0)
      {
        for($i=1;$i<=$uniformes[0];$i++){

            $id_uniforme = $uniformes[$i]['id_uniforme'];
            $cantidad = $uniformes[$i]['cantidad'];
            $costo_unitario = $uniformes[$i]['costo_unitario'];
            $costo_total = $uniformes[$i]['costo_total'];
            $costo_mensual = $uniformes[$i]['costo_mensual'];

            $insert = "INSERT INTO uniformes_elementos(id_uniforme,cantidad,id_elemento,costo_unitario,costo_total,costo_unitario_mensual) 
            VALUES ('$id_uniforme','$cantidad','$id_elemento','$costo_unitario','$costo_total','$costo_mensual')";
            $result = mysqli_query($this->link,$insert) or die(mysqli_error());
            
            if ($result) {
                $verifica = $id_elemento;
            }else{
                $verifica = 0;
                break;
            }
        }
      }else{
        $verifica = $id_elemento;
      }

      return $verifica;
  }//-- fin function guardarUniformes
  
  /**
    * Elimina un registro
    *
    * @param int $idElemento de registro para borrar
    *
    **/
  function eliminarElementos($idElemento){
      $query = "DELETE FROM cotizacion_elementos WHERE id =".$idElemento;
      $result=mysqli_query($this->link,$query)or die(mysqli_error());

      if ($result) {
          $verifica = $this -> eliminarUniformesIdElemento($idElemento);
      }else{
          $verifica = 0;
      }

      return $verifica;
  }//-- fin function eliminarElementos

  /**
    * Elimina registros de elementos
    *
    * @param int $idElemento de registro para borrar
    *
    **/
    function eliminarUniformesIdElemento($idElemento){
      $query = "DELETE FROM uniformes_elementos WHERE id_elemento =".$idElemento;
      $result=mysqli_query($this->link,$query)or die(mysqli_error());

      if ($result) {
          $verifica = 1;
      }else{
          $verifica = 0;
      }

      return $verifica;
  }//-- fin function eliminarUniformes

  /**
    * Buscar uniformes que pertenecen a un elemento
    *
    * @param int $idElemento de registro para buscar
    *
    **/
  function buscarUniformesIdElemento($idElemento){
      $result = $this->link->query("SELECT a.id,a.id_uniforme,a.cantidad,b.nombre,b.descripcion,
                                        a.costo_unitario AS costo,a.costo_unitario_mensual AS costo_mensual,
                                        a.costo_total
                                        -- b.costo
                                        FROM uniformes_elementos a
                                        LEFT JOIN cat_uniformes b ON a.id_uniforme=b.id
                                        WHERE a.id_elemento=$idElemento
                                        ORDER BY a.id");
      return query2json($result);
  }//-- fin function buscarUniformesIdElemento

  /**
    * dividir costo total equipos prorrateo entre 12 y entre el numero de elementos y el 
    * resultado sumarlo al total de cada elemento
    *
    * @param int $idCotizacion para buscar los costos totales de los elementos y el prorrateo de equipos
    *
    **/
  function guardarProrrateoElementos($idCotizacion){
    $verifica = 0;
    
   $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

    $verifica = $this -> actualizarProrrateoElementos($idCotizacion);

    if($verifica > 0)
        $this->link->query("commit;");
    else
        $this->link->query('rollback;');

    return $verifica;
}//-- fin function guardarProrrateoElementos

  /**
    * Busca dato prorrateo de equipo, numero de elementos, costos de elementos
    *
    * @param int $idCotizacion para buscar los costos totales de los elementos y el prorrateo de equipos
    *
    **/
  function actualizarProrrateoElementos($idCotizacion){
      $verifica = 0;

      $busca_prorrateo="SELECT (IFNULL(SUM(a.costo_total),0))+(IFNULL(SUM(b.costo_total),0)) AS prorrateo
                        FROM cotizacion_equipo a
                        LEFT JOIN cotizacion_consumibles b ON a.id_cotizacion=b.id_cotizacion AND b.prorratear=1
                        WHERE a.id_cotizacion$idCotizacion AND a.prorratear=1";

      $result1 = mysqli_query($this->link, $busca_prorrateo) or die(mysqli_error());
      $num = mysqli_num_rows($result1);
      if($num > 0){
          $row=mysqli_fetch_array($result1);
          $prorrateo = $row['prorrateo'];

          $busca_num_ele="SELECT IFNULL(SUM(cantidad),0) AS num_elementos
                            FROM cotizacion_elementos
                            WHERE id_cotizacion=$idCotizacion";
          $res_num_ele = mysqli_query($this->link, $busca_num_ele) or die(mysqli_error());
          $row_ele=mysqli_fetch_array($res_num_ele);

          $num_elementos = $row_ele['num_elementos'];

          if($prorrateo > 0 && $num_elementos > 0){
            $prorrateo_total = ($prorrateo/12)/$num_elementos;
          }else{
            $prorrateo_total = 0;
          }
          
          $busca_elementos="SELECT a.id,a.porcentaje_dispersion,a.cantidad,
                              SUM(a.sueldo) + SUM(a.bono) + SUM(a.tiempo_extra) + SUM(a.otros) + SUM(a.vacaciones) + SUM(a.aguinaldo) + SUM(a.festivo) + SUM(a.dia_31) + SUM(a.administrativo) + SUM(a.infonavit) + SUM(a.imss) AS costo_unitario,
                              (SUM(a.sueldo) + SUM(a.bono) + SUM(a.tiempo_extra) + SUM(a.otros) + SUM(a.vacaciones) + SUM(a.aguinaldo) + SUM(a.festivo) + SUM(a.dia_31) + SUM(a.administrativo) + SUM(a.infonavit) + SUM(a.imss))*a.cantidad AS costo_total
                              FROM cotizacion_elementos a
                              LEFT JOIN cat_salarios b ON a.id_salario=b.id
                              WHERE a.id_cotizacion=$idCotizacion
                              GROUP BY a.id";

        $result2 = mysqli_query($this->link, $busca_elementos) or die(mysqli_error());
        $num2 = mysqli_num_rows($result2);
        if($num2 > 0){  
          for ($i=1; $i <=$num2 ; $i++) {
              $row2=mysqli_fetch_array($result2);

              $id = $row2['id'];
              $porcentaje_dispersion = $row2['porcentaje_dispersion'];
              $cantidad = $row2['cantidad'];
              $costo_unitario = $row2['costo_unitario'];
              $costo_total = $row2['costo_total'];

              $busca_c_uni="SELECT -- IFNULL(SUM(c.cantidad*d.costo),0) AS total_uniformes
                              IFNULL(SUM(c.costo_unitario_mensual),0) AS total_uniformes
                              FROM cotizacion_elementos a
                              LEFT JOIN cat_salarios b ON a.id_salario=b.id
                              LEFT JOIN uniformes_elementos c ON a.id=c.id_elemento
                              LEFT JOIN cat_uniformes d ON c.id_uniforme=d.id
                              WHERE a.id=$id
                              GROUP BY a.id";

              $result_c = mysqli_query($this->link, $busca_c_uni) or die(mysqli_error());
              $row_c=mysqli_fetch_array($result_c);

              $costo_uniforme = $row_c['total_uniformes'];

              $porcentajeU = (($costo_unitario + $costo_uniforme) * $porcentaje_dispersion)/100;
              $porcentajeT = (($costo_total + ($costo_uniforme * $cantidad)) * $porcentaje_dispersion)/100;

              $costo_UP = ($porcentajeU + $costo_unitario + $costo_uniforme) + $prorrateo_total;
              $costo_TP = ($porcentajeT + $costo_total + ($costo_uniforme * $cantidad)) + $prorrateo_total;

              $actualiza="UPDATE cotizacion_elementos SET 
                              costo='$costo_UP',
                              costo_total='$costo_TP' 
                              WHERE id=".$id;
              $result3 = mysqli_query($this->link,$actualiza) or die(mysqli_error());
              
              if($result3){
                  $verifica = 1;
              }else{
                  $verifica = 0;
                  break;
              }
          }
        }else{
          $verifica = 0;
        }
    }else{
      $verifica = 0;
    }  

    return $verifica;

  }//-- fin function guardarActualizarProrrateoElementos

 /**
    * Busca los datos de servicios que pertenecen a una cotizacion, retorna un JSON con los datos correspondientes
    *
    * @param int $idCotizacion para buscar los servicios que pértenecen a ese id
    *
    **/
  function buscarServicios($idCotizacion){

        $result = $this->link->query("SELECT a.id,a.nombre,a.tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.observaciones,a.cantidad,b.estatus AS estatus
                                        FROM cotizacion_servicios a
                                        LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                                        WHERE a.id_cotizacion=".$idCotizacion."
                                        ORDER BY a.id");

        return query2json($result);
  }//-- fin function buscarServicios
  
  /**
    * Busca los datos de un servicio, retorna un JSON con los datos correspondientes
    *
    * @param int $idServicio para buscar los datos de servicio en especifico
    *
    **/
  function buscarServiciosId($idServicio){
        $result = $this->link->query("SELECT id,nombre,tipo_pago,costo,precio,costo_total,precio_total,observaciones,cantidad
                                        FROM cotizacion_servicios 
                                        WHERE id=".$idServicio);

        return query2json($result);
  }//-- fin function buscarServiciosId

  /**
    * Guarda un registro
    *
    * @param varchar $datos array con datos de servicio a guardar
    *
    **/
  function guardarServicios($datos){
        $verifica = 0;
        
       $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

        $verifica = $this -> insertarServicios($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
  }//-- fin function guardarEquipos

  /**
    * Guarda un registro
    *
    * @param varchar $datos array con datos de servicio a guardar
    *
    * nombre - del servicio
    * cantidad - numero unidades de servicio
    * tipo_pago - 1=pago mensual 2=pago unico
    * costo - cantidad sueldo mensual
    * precio - cantidad precio
    * costo_total - cantidad calculada de costo * cantidad
    * precio_total - cantidad calculada de precio * cantidad
    * observaciones - texto adicional
    * idCotizacion - id de la cotizacion a la cual pertenece el servicio
    *
    **/
  function insertarServicios($datos){
        $verifica = 0;

        $nombre = $datos['nombre'];
        $cantidad = $datos['cantidad'];
        $tipo_pago = $datos['tipo_pago'];
        $costo = $datos['costo'];
        $precio = $datos['precio'];
        $costo_total = $datos['costoTotal'];
        $precio_total = $datos['precioTotal'];
        $observaciones = $datos['observaciones'];
        $idCotizacion = $datos['idCotizacion'];

        $busqueda="SELECT id,cantidad 
                    FROM cotizacion_servicios 
                    WHERE nombre='$nombre' AND tipo_pago='$tipo_pago' AND costo='$costo' 
                    AND precio='$precio' AND observaciones='$observaciones' AND id_cotizacion=".$idCotizacion;
        $result_busqueda= mysqli_query($this->link,$busqueda) or die(mysqli_error());
        $num = mysqli_num_rows($result_busqueda);

        if($num > 0)
        {
            $row=mysqli_fetch_array($result_busqueda);
            $id_servicio=$row['id'];
            $cantidad_ant=$row['cantidad'];
            $cant_total=$cantidad_ant+$cantidad;
            $costo_tot=$costo*$cantidad;
            $precio_tot=$precio*$cantidad;

            $update = "UPDATE cotizacion_servicios SET 
                        cantidad='$cant_total',
                        costo_total='$costo_tot',
                        precio_total='$precio_tot' 
                        WHERE id=".$id_servicio;
            $result = mysqli_query($this->link,$update) or die(mysqli_error());

            if($result){
                $verifica = $id_servicio;
            }else{
                $verifica = 0;
            }
        }else{
      
            $insert = "INSERT INTO cotizacion_servicios(nombre,tipo_pago,costo,precio,costo_total,precio_total,id_cotizacion,observaciones,cantidad) 
            VALUES ('$nombre','$tipo_pago','$costo','$precio','$costo_total','$precio_total','$idCotizacion','$observaciones','$cantidad')";
            $result = mysqli_query($this->link,$insert) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);
            
            if ($result) {
                $verifica = $id_registro;
            }else{
                $verifica = 0;
            }
        }
    
        return $verifica;
  }//-- fin function insertarServicios

  /**
    * Elimina un registro
    *
    * @param int $idServicio de registro para borrar
    *
    **/
  function eliminarServicios($idServicio){
        $query = "DELETE FROM cotizacion_servicios WHERE id =".$idServicio;
        $result=mysqli_query($this->link,$query)or die(mysqli_error());

        if ($result) {
            $verifica = 1;
        }else{
            $verifica = 0;
        }

        return $verifica;
  }//-- fin function eliminarServicios

  /**
    * Busca los datos de vehiculos que pertenecen a una cotizacion, retorna un JSON con los datos correspondientes
    *
    * @param int $idCotizacion para buscar los equipos que pértenecen a ese id
    *
    **/
  function buscarVehiculos($idCotizacion){

        $result = $this->link->query("SELECT a.id,a.nombre,a.tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.observaciones,a.cantidad,b.estatus AS estatus
                                        FROM cotizacion_vehiculos a
                                        LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                                        WHERE a.id_cotizacion=".$idCotizacion."
                                        ORDER BY a.id");

        return query2json($result);
  }//-- fin function buscarVehiculos

  /**
    * Busca los datos de un Vehiculo, retorna un JSON con los datos correspondientes
    *
    * @param int $idServicio para buscar los datos de vehiculo en especifico
    *
    **/
  function buscarVehiculosId($idVehiculo){
        $result = $this->link->query("SELECT id,nombre,tipo_pago,costo,precio,costo_total,precio_total,observaciones,cantidad
                                        FROM cotizacion_vehiculos 
                                        WHERE id=".$idVehiculo);

        return query2json($result);
  }//-- fin function buscarVehiculosId

  /**
    * Guarda un registro
    *
    * @param varchar $datos array con datos de vehiculo a guardar
    *
    **/
  function guardarVehiculos($datos){
        $verifica = 0;
        
       $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

        $verifica = $this -> insertarVehiculos($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
  }//-- fin function guardarEquipos

  /**
    * Guarda un registro
    *
    * @param varchar $datos array con datos de vehiculo a guardar
    *
    * nombre - del vehiculo
    * cantidad - numero unidades de vehiculo
    * tipo_pago - 1=pago mensual 2=pago unico
    * costo - cantidad sueldo mensual
    * precio - cantidad precio
    * costo_total - cantidad calculada de costo * cantidad
    * precio_total - cantidad calculada de precio * cantidad
    * observaciones - texto adicional
    * idCotizacion - id de la cotizacion a la cual pertenece el vehiculo
    *
    **/
  function insertarVehiculos($datos){
        $verifica = 0;

        $nombre = $datos['nombre'];
        $cantidad = $datos['cantidad'];
        $tipo_pago = $datos['tipo_pago'];
        $costo = $datos['costo'];
        $precio = $datos['precio'];
        $costo_total = $datos['costoTotal'];
        $precio_total = $datos['precioTotal'];
        $observaciones = $datos['observaciones'];
        $idCotizacion = $datos['idCotizacion'];

        $busqueda="SELECT id,cantidad 
                    FROM cotizacion_vehiculos 
                    WHERE nombre='$nombre' AND tipo_pago='$tipo_pago' AND costo='$costo' 
                    AND precio='$precio' AND observaciones='$observaciones' AND id_cotizacion=".$idCotizacion;
        $result_busqueda= mysqli_query($this->link,$busqueda) or die(mysqli_error());
        $num = mysqli_num_rows($result_busqueda);

        if($num > 0)
        {
            $row=mysqli_fetch_array($result_busqueda);
            $id_vehiculo=$row['id'];
            $cantidad_ant=$row['cantidad'];
            $cant_total=$cantidad_ant+$cantidad;
            $costo_tot=$costo*$cantidad;
            $precio_tot=$precio*$cantidad;

            $update = "UPDATE cotizacion_vehiculos SET 
                        cantidad='$cant_total',
                        costo_total='$costo_tot',
                        precio_total='$precio_tot' 
                        WHERE id=".$id_vehiculo;
            $result = mysqli_query($this->link,$update) or die(mysqli_error());

            if($result){
                $verifica = $id_vehiculo;
            }else{
                $verifica = 0;
            }
        }else{
      
            $insert = "INSERT INTO cotizacion_vehiculos(nombre,tipo_pago,costo,precio,costo_total,precio_total,id_cotizacion,observaciones,cantidad) 
            VALUES ('$nombre','$tipo_pago','$costo','$precio','$costo_total','$precio_total','$idCotizacion','$observaciones','$cantidad')";
            $result = mysqli_query($this->link,$insert) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);
            
            if ($result) {
                $verifica = $id_registro;
            }else{
                $verifica = 0;
            }
        }
    
        return $verifica;
  }//-- fin function insertarVehiculos

  /**
    * Elimina un registro
    *
    * @param int $idVehiculo de registro para borrar
    *
    **/
  function eliminarVehiculos($idVehiculo){
        $query = "DELETE FROM cotizacion_vehiculos WHERE id =".$idVehiculo;
        $result=mysqli_query($this->link,$query)or die(mysqli_error());

        if ($result) {
            $verifica = 1;
        }else{
            $verifica = 0;
        }

        return $verifica;
  }//-- fin function eliminarVehiculos

  //-----------Se incluyen funciones para guardar, buscar, eliminar datos elementos, equipos, servicios y vehiculos que pertenecen a secciones (de cotizaciones)-----------//

  /**
    * Busca los datos de consumibles que pertenecen a una cotizacion, retorna un JSON con los datos correspondientes
    *
    * @param int $idCotizacion para buscar los consumibles que pértenecen a ese id
    *
    **/
    function buscarConsumibles($idCotizacion){
      $result = $this->link->query("SELECT a.id,a.nombre,a.tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.observaciones,a.cantidad,a.prorratear,b.estatus AS estatus
                                      FROM cotizacion_consumibles a
                                      LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                                      WHERE a.id_cotizacion=".$idCotizacion."
                                      ORDER BY a.id");

      return query2json($result);
    }//-- fin function buscarConsumibles

    /**
      * Busca los datos de un consumible, retorna un JSON con los datos correspondientes
      *
      * @param int $idConsumible para buscar los datos de consumible en especifico
      *
      **/
    function buscarConsumibleId($idConsumible){
          $result = $this->link->query("SELECT id,nombre,tipo_pago,costo,precio,costo_total,precio_total,observaciones,cantidad,prorratear
                                          FROM cotizacion_consumibles 
                                          WHERE id=".$idConsumible);

          return query2json($result);
    }//-- fin function buscarConsumibleId

    /**
      * Guarda un registro
      *
      * @param varchar $datos array con datos de equipo a guardar
      *
      **/
    function guardarConsumibles($datos){
          $verifica = 0;
          
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

          $verifica = $this -> insertarConsumibles($datos);

          if($verifica > 0)
              $this->link->query("commit;");
          else
              $this->link->query('rollback;');

          return $verifica;
    }//-- fin function guardarConsumibles

    /**
      * Guarda un registro
      *
      * @param varchar $datos array con datos de consuible a guardar
      *
      * nombre - del consumible
      * cantidad - numero unidades de consumible
      * tipo_pago - 1=pago mensual 2=pago unico
      * costo - cantidad sueldo mensual
      * precio - cantidad precio
      * costo_total - cantidad calculada de costo * cantidad
      * precio_total - cantidad calculada de precio * cantidad
      * observaciones - texto adicional
      * prorratear - 1=si se prorratea 0=no se prorratea
      * idCotizacion - id de la cotizacion a la cual pertenece el consumible
      *
      **/
    function insertarConsumibles($datos){
          $verifica = 0;

          $nombre = $datos['nombre'];
          $cantidad = $datos['cantidad'];
          $tipo_pago = $datos['tipo_pago'];
          $costo = $datos['costo'];
          $precio = $datos['precio'];
          $costo_total = $datos['costoTotal'];
          $precio_total = $datos['precioTotal'];
          $observaciones = $datos['observaciones'];
          $prorratear = $datos['prorratear'];
          $idCotizacion = $datos['idCotizacion'];

          $busqueda="SELECT id,cantidad 
                      FROM cotizacion_consumibles 
                      WHERE nombre='$nombre' AND tipo_pago='$tipo_pago' AND costo='$costo' 
                      AND precio='$precio' AND observaciones='$observaciones' AND id_cotizacion=".$idCotizacion;
          $result_busqueda= mysqli_query($this->link,$busqueda) or die(mysqli_error());
          $num = mysqli_num_rows($result_busqueda);

          if($num > 0)
          {
              $row=mysqli_fetch_array($result_busqueda);
              $id_consumible=$row['id'];
              $cantidad_ant=$row['cantidad'];
              $cant_total=$cantidad_ant+$cantidad;
              $costo_tot=$costo*$cantidad;
              $precio_tot=$precio*$cantidad;

              $update = "UPDATE cotizacion_consumibles SET 
                          cantidad='$cant_total',
                          costo_total='$costo_tot',
                          precio_total='$precio_tot' 
                          WHERE id=".$id_consumible;
              $result = mysqli_query($this->link,$update) or die(mysqli_error());

              if($result){
                  $verifica = $id_consumible;
              }else{
                  $verifica = 0;
              }
          }else{
              $insert = "INSERT INTO cotizacion_consumibles(nombre,tipo_pago,costo,precio,costo_total,precio_total,id_cotizacion,observaciones,cantidad,prorratear) 
              VALUES ('$nombre','$tipo_pago','$costo','$precio','$costo_total','$precio_total','$idCotizacion','$observaciones','$cantidad','$prorratear')";
              $result = mysqli_query($this->link,$insert) or die(mysqli_error());
              $id_registro = mysqli_insert_id($this->link);
              
              if ($result) {
                  $verifica = $id_registro;
              }else{
                  $verifica = 0;
              }
          }
      
          return $verifica;
    }//-- fin function insertarConsumibles

    /**
      * Elimina un registro
      *
      * @param int $idConsumible de registro para borrar
      *
      **/
    function eliminarConsumibles($idConsumible){
          $query = "DELETE FROM cotizacion_consumibles WHERE id =".$idConsumible;
          $result=mysqli_query($this->link,$query)or die(mysqli_error());

          if ($result) {
              $verifica = 1;
          }else{
              $verifica = 0;
          }

          return $verifica;
    }//-- fin function eliminarConsumibles

}//--fin de class CotizacionesSecciones
    
?>