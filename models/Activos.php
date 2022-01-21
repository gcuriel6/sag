<?php

//include 'conectar.php';
require_once('conectar.php');
require_once('../widgets/VerificarPermiso.php');
require_once('MovimientosPresupuesto.php');

class Activos
{
    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Activos(){
      $this->link = Conectarse();
    }

    /** Funcion para guardar los Datos Generales en Activos, solo cuando el tipo esta marcado en OTRO    **/
    // @param entrada: Arreglo Formulario Datos generales array
    // @output: ID registro insertado int

    /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
      ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
    */

    function guardarDatosGenerales($datos_generales){

      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $noSerie = $datos_generales['noSerie'];
      $noEco = $datos_generales['noEco'];
      $descripcion = $datos_generales['descripcion'];
      $codBarras = $datos_generales['codBarras'];
      $fechaAdq = $datos_generales['fechaAdq'];
      $valAdq = $datos_generales['valAdq'];
      $fechaBaja = $datos_generales['fechaBaja'];
      $propietario = $datos_generales['propietario'];
      $radioCompra = $datos_generales['radioCompra'];
      $anticipo = $datos_generales['anticipo'];
      $mensualidades = $datos_generales['mensualidades'];
      $fechaFinCredito = $datos_generales['fechaFinCredito'];
      $observaciones = $datos_generales['observaciones'];
      $radioTipo = $datos_generales['radioTipo'];

      $folioRecepcion = $datos_generales['folioRecepcion'];
      $idAlmacenE = $datos_generales['idAlmacenE'];
      $idAlmacenD = $datos_generales['idAlmacenD'];
      $idUnidadNegocio = $datos_generales['idUnidadNegocio'];
      $idUsuario = $datos_generales['idUsuario'];
      $usuario = $datos_generales['usuario'];

      $idSucursal = $datos_generales['idSucursal'];

      //-->NJES December/17/2020 inactivar/activar activo y guardar usuario captura
      $inactivo = $datos_generales['inactivo'];

      if($inactivo == 1)
        $idUsuarioBaja = $datos_generales['idUsuario'];
      else
        $idUsuarioBaja = 0;

      $sql = "INSERT INTO activos (no_serie, num_economico, descripcion, codigo_barras, fecha_adquisicion, valor_adquisicion, fecha_baja, id_empresa_fiscal, financiamiento, anticipo, mensualidades, fin_credito, observaciones, tipo, folio_recepcion, id_sucursal,inactivo,id_usuario_captura,id_usuario_baja)VALUES('$noSerie','$noEco','$descripcion','$codBarras','$fechaAdq',$valAdq,'$fechaBaja',$propietario,$radioCompra,$anticipo,$mensualidades,'$fechaFinCredito','$observaciones',$radioTipo,'$folioRecepcion','$idSucursal','$inactivo','$idUsuario','$idUsuarioBaja')";
      $result = mysqli_query($this->link, $sql) or die(mysqli_error());
      $idActivo = mysqli_insert_id($this->link);
      $_SESSION["id_activo"]=$idActivo;
      if ($result) {
          if($radioTipo != 5)
          {
            $verifica = $this -> generaSalidaPorResponsiva($idActivo, $folioRecepcion, $idAlmacenE, $idAlmacenD, $idUnidadNegocio, $idUsuario, $usuario, $tipoActivo);
          }else
            $verifica = $idActivo;
      }else {
        $this->link->query('rollback;');
        $verifica = 0;
      }
      return $verifica;
    } //-- fin function guardarDatosGenerales

    /**
     *  GENERA UNA SALIDA POR RESPONSIVA DEL ACTIVO FIJO 
     *  @output: ID registro insertado
    */
    function generaSalidaPorResponsiva($idActivo, $folioRecepcion, $idAlmacenE, $idAlmacenD, $idUnidadNegocio, $idUsuario, $usuario){
        
        $verifica = 0;
        
        $fecha=date("Y-m-d");
        $queryFolio="SELECT folio_salida_almacen FROM cat_unidades_negocio WHERE id=".$idUnidadNegocio;
        $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
        if($resultF)
        {
          $datosX=mysqli_fetch_array($resultF);
          $folioA=$datosX['folio_salida_almacen'];
          $folio= $folioA+1;

          $queryU = "UPDATE cat_unidades_negocio SET folio_salida_almacen='$folio' WHERE id=".$idUnidadNegocio;
          $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
          if($resultU)
          {
              $query = "INSERT INTO almacen_e (folio,cve_concepto,id_compania,id_unidad_negocio,id_sucursal,observacion,id_usuario_captura,usuario_captura,no_partidas,id_clasificacion,id_proveedor,id_trabajador,id_sucursal_destino,id_departamento,id_area,id_venta,folio_recepcion,id_activo_fijo) 
                        (SELECT ".$folio.",'S10',id_compania,id_unidad_negocio,id_sucursal,observacion,".$idUsuario.",'".$usuario."',1,id_clasificacion,id_proveedor,id_trabajador,id_sucursal_destino,id_departamento,id_area,id_venta,".$folioRecepcion.", ".$idActivo." 
                        FROM almacen_e 
                        WHERE id=".$idAlmacenE.")";
              $result = mysqli_query($this->link, $query) or die(mysqli_error());
              $idSalida = mysqli_insert_id($this->link);
                  
              if($result)
              {
                  $verifica = $this -> guardarDetalle($idActivo, $idSalida, $idAlmacenE, $idAlmacenD,$folio);
              }else{
                  $this->link->query('rollback;');
                  $verifica = 0;
              }
          }else{
              $this->link->query('rollback;');
              $verifica = 0;
          }

        }else{
          $this->link->query('rollback;');
          $verifica = 0;
        }

        return $verifica;
    }//-- fin function generaSalidaPorResponsiva

    function guardarDetalle($idActivo, $idSalida, $idAlmacenE, $idAlmacenD,$folio){

      $verifica = 0;
      
      $query = "INSERT INTO almacen_d (id_almacen_e,cve_concepto,id_producto,lote,fecha_cad,cantidad,precio,factor,id_oc,partida,iva,ieps,talla,marca,lleva_talla,estatus,id_oc_d,porcentaje_descuento)
      SELECT ".$idSalida.",'S10',id_producto,lote,fecha_cad,1,precio,factor,id_oc,1,iva,ieps,talla,marca,lleva_talla,estatus,id_oc_d,porcentaje_descuento 
      FROM almacen_d 
      WHERE id=".$idAlmacenD;
      $resultD = mysqli_query($this->link, $query) or die(mysqli_error());
      $idAlmacenDN = mysqli_insert_id($this->link);

      if($resultD){
        
        $this->link->query("commit;");
      
        $verifica = $idActivo;

        //-->NJES Feb/12/2020 se afecta movimiento presupuesto hasta que se asigna a un responsable o comodato
        /*$busca1="SELECT id_unidad_negocio,id_sucursal,id_departamento,id_area
          FROM almacen_e 
          WHERE id=$idSalida";
        $result1 = mysqli_query($this->link, $busca1) or die(mysqli_error());
        $row1 = mysqli_fetch_array($result1);

        $idUnidadNegocio = $row1['id_unidad_negocio'];
        $idSucursal = $row1['id_sucursal'];
        $idDepartamento = $row1['id_departamento'];
        $idArea = $row1['id_area'];
        
        $busca2="SELECT precio FROM almacen_d WHERE id=$idAlmacenDN";
        $result2 = mysqli_query($this->link, $busca2) or die(mysqli_error());
        $row2 = mysqli_fetch_array($result2);

        $importe = $row2['precio'];

        $arr = array('idAlmacenD'=>$idAlmacenDN,
                      'importe'=>$importe,
                      'folio'=>$folio, 
                      'idUnidadNegocio'=>$idUnidadNegocio,
                      'idSucursal'=>$idSucursal,
                      'idDepartamento'=>$idDepartamento,
                      'idArea'=>$idArea,
                      'idFamiliaGasto'=>0,
                      'idActivo'=>$idActivo);

        $verifica = $this -> guardaMovimientoPresupuesto($arr);*/
      }else{
        $this->link->query('rollback;');
        $verifica = 0;
      }
      
    
      return $verifica;
    }



    // @param entrada: Arreglo Formulario Datos generales array y ID de Registro int
    // @output: booleano
    /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
      ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
    */
    function actualizarDatosGenerales($datos_generales, $id){
      $verifica = false;
      
      $_SESSION["id_activo"]=$id;
      $noSerie = $datos_generales['noSerie'];
      $noEco = $datos_generales['noEco'];
      $descripcion = $datos_generales['descripcion'];
      $codBarras = $datos_generales['codBarras'];
      $fechaAdq = $datos_generales['fechaAdq'];
      $valAdq = $datos_generales['valAdq'];
      $fechaBaja = $datos_generales['fechaBaja'];
      $propietario = $datos_generales['propietario'];
      $radioCompra = $datos_generales['radioCompra'];
      $anticipo = $datos_generales['anticipo'];
      $mensualidades = $datos_generales['mensualidades'];
      $fechaFinCredito = $datos_generales['fechaFinCredito'];
      $observaciones = $datos_generales['observaciones'];
      $radioTipo = $datos_generales['radioTipo'];

      //-->NJES December/17/2020 inactivar activo y guardar usuario que lo inactivo
      $inactivo = $datos_generales['inactivo'];

      if($inactivo == 1)
        $idUsuarioBaja = $datos_generales['idUsuario'];
      else
        $idUsuarioBaja = 0;

      $sql = "UPDATE activos SET no_serie='$noSerie', num_economico='$noEco', descripcion='$descripcion',
        codigo_barras='$codBarras', fecha_adquisicion='$fechaAdq', valor_adquisicion=$valAdq, fecha_baja='$fechaBaja',
        id_empresa_fiscal=$propietario, financiamiento=$radioCompra, anticipo=$anticipo, mensualidades=$mensualidades,
        fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo',inactivo='$inactivo',
        id_usuario_baja='$idUsuarioBaja' WHERE id = $id";
      $result = mysqli_query($this->link, $sql) or die(mysqli_error());
      if ($result) {
       $verifica = true;
      }
      else {
       $verifica = false;
      }

      return $verifica;

    } //-- fin function Actualizar


    // @param entrada: Tipo(Info/Mtto) string, decripcion string, id (Id Activo) int
    // @output: ID registro insertado
    function guardarBitacora($tipo, $descripcion, $kilometraje, $id){
      $verifica = 0;

      $fecha=date("Y-m-d");
      $query = "INSERT INTO activos_bitacora (tipo, descripcion, fecha, kilometraje, id_activo)
      VALUES ('$tipo','$descripcion','$fecha','$kilometraje',$id)";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      $id_bitacora_activo = mysqli_insert_id($this->link);
      if ($result) {
        $verifica = $id_bitacora_activo; //true;
      }
      else {
        $verifica = 0;
      }

      return $verifica;
    }//-- fin function

    /** Funcion para agregar tipo de Vehiculo   **/
    // @param entrada: Tipo Vehiculo string
    // @output: Total int
    function validarTipoVeh($tipoVeh){
      $sql = "SELECT COUNT(tipos) as total from vehiculos_tipos where tipos LIKE '$tipoVeh'";
      $result = mysqli_query($this->link,$sql) or die(mysqli_error());
      $total = mysqli_fetch_array($result);
      return $total['total'];
    }

    // @param entrada: Tipo Vehiculo string
    // @output: boolean
    function guardarTipoVeh($tipoVeh){
      $verifica = false;
      $sql2 = "INSERT into vehiculos_tipos (tipos) VALUES ('$tipoVeh')";
      $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
      if ($result2) {
        $verifica = true;
      }
      else {
        $verifica = false;
      }

      return $verifica;
    }

    /** Funcion para agregar marca de Vehiculo   **/
    // @param entrada: Marca Vehiculo string
    // @output: Total int
    function validarMarcaVeh($marcaVeh){
      $sql = "SELECT COUNT(marcas) AS total FROM vehiculos_marcas WHERE marcas = '$marcaVeh'";
      $result = mysqli_query($this->link,$sql) or die(mysqli_error());
      $total = mysqli_fetch_array($result);
      return $total['total'];
      // return $sql;
    }

    // @param entrada: Marca Vehiculo string
    // @output: boolen
    function guardarMarcaVeh($marcaVeh){
      $verifica = false;
      $sql2 = "INSERT into vehiculos_marcas (marcas) VALUES ('$marcaVeh')";
      $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
      if ($result2) {
        $verifica = true;
      }
      else {
        $verifica = false;
      }

      return $verifica;
    }
    //
    /** Funcion para agregar marca de Celular   **/
    // @param entrada: Marca Celular string
    // @output: Total int
    function validarMarcaCel($marcaCel){
      $sql = "SELECT COUNT(marca) AS total FROM celulares_marcas WHERE marca LIKE '$marcaCel'";
      $result = mysqli_query($this->link,$sql) or die(mysqli_error());
      $total = mysqli_fetch_array($result);
      return $total['total'];
      // return $sql;
    }

    // @param entrada: Marca Celular string
    // @output: boolean
    function guardarMarcaCel($marcaCel){
      $sql2 = "INSERT into celulares_marcas (marca) VALUES ('$marcaCel')";
      $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
      if ($result2) {
        return true;
      }
      else {
        return false;
      }
    }
    //
    /** Funcion para agregar compañia de Celular   **/
    // @param entrada: Compañia Celular string
    // @output: Total int
    function validarCompaniaCel($companiaCel){
      $sql = "SELECT COUNT(compania) AS total FROM celulares_companias WHERE compania LIKE '$companiaCel'";
      $result = mysqli_query($this->link,$sql) or die(mysqli_error());
      $total = mysqli_fetch_array($result);
      return $total['total'];
      // return $sql;
    }

    // @param entrada: Compañia Celular string
    // @output: boolean
    function guardarCompaniaCel($companiaCel){
      $verifica = false;

      $sql2 = "INSERT into celulares_companias (compania) VALUES ('$companiaCel')";
      $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
      if ($result2) {
        $verifica = true;
      }
      else {
        $verifica = false;
      }

      return $verifica;
    }
    //
    //
    /** Funcion para agregar tipo de Equipo de Computo   **/
    // @param entrada: Tipo de Equipo string
    // @output: Total int
    function validarTipoEq($tipoEq){
      $sql = "SELECT COUNT(tipo) AS total FROM equipo_computo_tipo WHERE tipo LIKE '$tipoEq'";
      $result = mysqli_query($this->link,$sql) or die(mysqli_error());
      $total = mysqli_fetch_array($result);
      return $total['total'];
      // return $sql;
    }

    // @param entrada: Tipo de Equipo Computo string
    // @output: boolean
    function guardarTipoEq($tipoEq){
      $verifica = false;
      $sql2 = "INSERT into equipo_computo_tipo (tipo) VALUES ('$tipoEq')";
      $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
      if ($result2) {
        $verifica = true;
      }
      else {
        $verifica = false;
      }

      return $verifica;
    }
    //
    /** Funcion para agregar Marca de Equipo de Computo   **/
    // @param entrada: TMarca de Equipo Computo string
    // @output: Total int
    function validarMarcaEq($marcaEq){
      $sql = "SELECT COUNT(marca) AS total FROM equipo_computo_marcas WHERE marca LIKE '$marcaEq'";
      $result = mysqli_query($this->link,$sql) or die(mysqli_error());
      $total = mysqli_fetch_array($result);
      return $total['total'];
      // return $sql;
    }

    // @param entrada: Marca de Equipo string
    // @output: boolean
    function guardarMarcaEq($marcaEq){
      $verifica = false;
      $sql2 = "INSERT into equipo_computo_marcas (marca) VALUES ('$marcaEq')";
      $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
      if ($result2){
        $verifica = true;
      }
      else{
        $verifica = false;
      }

      return $verifica;
    }


    /**
       * Guarda registros de Activos Tipo Vehiculo
     **/
    // @param entrada: Datos Generales array(), Datos Vehiculo array()
    // @output: JSON (ID Activo, ID Vehiculo)
    function guardarActivoVehiculo($datos_generales, $datos_vehiculo){
        $verifica = 0;
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

          $verifica =$this -> guardarActivoVehiculoTransaction($datos_generales, $datos_vehiculo);

        if($verifica != 0){
          $this->link->query("commit;");
        }
        else{
          $this->link->query('rollback;');
        }

        return json_encode($verifica);

    }//- fin function

    /**
       * Guarda registros de Activos Tipo Vehiculo Transaccion Iniciando por guardar los datos link_generales
       * donde si se guarda obtenemos su id para relacionarlo al registro del vehiculo
     **/
    function guardarActivoVehiculoTransaction($datos_generales, $datos_vehiculo){
        $verifica = false;
        // Datos Vehiculo
        $vehTipo = $datos_vehiculo['vehTipo'];
        $vehMarca = $datos_vehiculo['vehMarca'];
        $vehColor = $datos_vehiculo['vehColor'];
        $vehModelo = $datos_vehiculo['vehModelo'];
        $vehVigencia = $datos_vehiculo['vehVigencia'];
        $vehPlacas = $datos_vehiculo['vehPlacas'];
        $vehAnio = $datos_vehiculo['vehAnio'];
        $vehVigenciaCirculacion = $datos_vehiculo['vehVigenciaCirculacion'];
        $imeiGPS = $datos_vehiculo['imeiGPS'];

          $idActivo = $this->guardarDatosGenerales($datos_generales);
          
        if ( $idActivo > 0 ){
          /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
            ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
          */
          $_SESSION["id_activo"]=$idActivo;
          $query2 = "INSERT INTO vehiculos (id_tipo_vehiculo, id_marca, color, modelo, placas, vigencia_poliza, vigencia_tarjeta_circulacion, id_activo, anio,imei_gps) 
                    VALUES ($vehTipo, $vehMarca, '$vehColor', '$vehModelo', '$vehPlacas', '$vehVigencia', '$vehVigenciaCirculacion', $idActivo,'$vehAnio','$imeiGPS')";
          $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
          $idVeh = mysqli_insert_id($this->link);
          $arreglo = array();

          if ($result2){
            array_push($arreglo,['id'=>$idActivo, 'idVeh'=>$idVeh]);
              $verifica = $arreglo;
          }else{
              $verifica = false;
          }
        }
        else{
          $verifica = false;
        }

        return $verifica;
    }//- fin function


    /*********************************************************************************************************************************************
       * Actualizar registros de Activos Tipo Vehiculo     *****************************************************************************************
     *********************************************************************************************************************************************/
    // @param entrada: Datos Generales array(), Datos Vehiculo array(), ID Activo, ID Vehiculo
    // @output: int
    function actualizarActivoVehiculo($datos_generales, $datos_vehiculo, $id, $id_veh){
        $verifica = 0;
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

          $verifica =$this -> actualizarActivoVehiculoTransaction($datos_generales, $datos_vehiculo, $id, $id_veh);

        if($verifica == 1){
          $this->link->query("commit;");
        }
        else{
          $this->link->query('rollback;');
        }

        return $verifica;

    }//- fin function

    /**
       * Guarda registros de Activos Tipo Vehiculo Transaccion Iniciando por guardar los datos link_generales
       * donde si se guarda obtenemos su id para relacionarlo al registro del vehiculo
     **/
    function actualizarActivoVehiculoTransaction($datos_generales, $datos_vehiculo, $id, $id_veh){
        $verifica = 0;
        // Datos Generales
        $noSerie = $datos_generales['noSerie'];
        $noEco = $datos_generales['noEco'];
        $descripcion = $datos_generales['descripcion'];
        $codBarras = $datos_generales['codBarras'];
        $fechaAdq = $datos_generales['fechaAdq'];
        $valAdq = $datos_generales['valAdq'];
        $fechaBaja = $datos_generales['fechaBaja'];
        $propietario = $datos_generales['propietario'];
        $radioCompra = $datos_generales['radioCompra'];
        $anticipo = $datos_generales['anticipo'];
        $mensualidades = $datos_generales['mensualidades'];
        $fechaFinCredito = $datos_generales['fechaFinCredito'];
        $observaciones = $datos_generales['observaciones'];
        $radioTipo = $datos_generales['radioTipo'];

        //-->NJES December/17/2020 inactivar/activar activos y guardar usuario baja
        $inactivo = $datos_generales['inactivo'];

        if($inactivo == 1)
          $idUsuarioBaja = $datos_generales['idUsuario'];
        else
          $idUsuarioBaja = 0;
        
        // Datos Vehiculo
        $vehTipo = $datos_vehiculo['vehTipo'];
        $vehMarca = $datos_vehiculo['vehMarca'];
        $vehColor = $datos_vehiculo['vehColor'];
        $vehModelo = $datos_vehiculo['vehModelo'];
        $vehVigencia = $datos_vehiculo['vehVigencia'];
        $vehPlacas = $datos_vehiculo['vehPlacas'];
        $vehAnio = $datos_vehiculo['vehAnio'];
        $vehVigenciaCirculacion = $datos_vehiculo['vehVigenciaCirculacion'];
        $imeiGPS = $datos_vehiculo['imeiGPS'];

        $query = "UPDATE activos SET no_serie='$noSerie', num_economico='$noEco', descripcion='$descripcion',
            codigo_barras='$codBarras', fecha_adquisicion='$fechaAdq', valor_adquisicion=$valAdq, fecha_baja='$fechaBaja',
            id_empresa_fiscal=$propietario, financiamiento=$radioCompra, anticipo=$anticipo, mensualidades=$mensualidades,
            fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo',inactivo='$inactivo',
            id_usuario_baja='$idUsuarioBaja' WHERE id = $id";
                  $result = mysqli_query($this->link, $query) or die(mysqli_error());
                  if ($result){
                    $idActivo = mysqli_insert_id($this->link);
                    $query2 = "UPDATE vehiculos SET id_tipo_vehiculo=$vehTipo, id_marca=$vehMarca, color='$vehColor', modelo='$vehModelo',
            placas='$vehPlacas', vigencia_poliza='$vehVigencia',
            vigencia_tarjeta_circulacion='$vehVigenciaCirculacion',anio='$vehAnio',imei_gps='$imeiGPS' WHERE id = $id_veh";
          $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

          if ($result2){
              $verifica = 1;
          }else{
              $verifica = 0;
          }
        }
        else{
          $verifica = 0;
        }

        return $verifica;
    }//- fin function

    /**
       * Guarda registros de Activos Tipo Vehiculo
     **/
    // @param entrada: Datos Generales array(), Datos Celular array()
    // @output: JSON (ID Activo, ID Celular)
    function guardarActivoCelular($datos_generales, $datos_celular){
        $verifica = 0;
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

          $verifica =$this -> guardarActivoCelularTransaction($datos_generales, $datos_celular);

        if($verifica != 0){
          $this->link->query("commit;");
        }
        else{
          $this->link->query('rollback;');
        }

        return json_encode($verifica);

    }//- fin function

    /**
       * Guarda registros de Activos Tipo Celuar Transaccion Iniciando por guardar los datos generales
     **/
    function guardarActivoCelularTransaction($datos_generales, $datos_celular){
        $verifica = false;
        // Datos Vehiculo
        $celMarca = $datos_celular['celMarca'];
        $celModelo = $datos_celular['celModelo'];
        $celImei = $datos_celular['celImei'];
        $celNumero = $datos_celular['celNumero'];
        $celCompania = $datos_celular['celCompania'];
        $celPaquete = $datos_celular['celPaquete'];
        $celContrato = $datos_celular['celContrato'];
        $celVigenciaContrato = $datos_celular['celVigenciaContrato'];

        $idActivo = $this->guardarDatosGenerales($datos_generales);
        
        if ( $idActivo > 0 ){
          
          $query2 = "INSERT INTO celulares (id_marca, modelo, imei, num_telefono, id_compania, paquete, no_contrato, vigencia, id_activo) VALUES ($celMarca,'$celModelo','$celImei','$celNumero',$celCompania,'$celPaquete','$celContrato','$celVigenciaContrato',$idActivo)";
          $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
          $idCel = mysqli_insert_id($this->link);
          $arregloCel = array();

          if ($result2){
            array_push($arregloCel,['id'=>$idActivo, 'idCel'=>$idCel]);
              $verifica = $arregloCel;
          }else{
              $verifica = false;
          }
        }
        else{
          $verifica = false;
        }

        return $verifica;
    }//- fin function

    // Actualizar Datos Generales y Formulario Celular
    // @param entrada: Datos Generales array(), Datos Celular array(), ID Activo, ID Celular
    // @output: int
    function actualizarActivoCelular($datos_generales, $datos_celular, $id, $id_cel){
        $verifica = 0;
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

          $verifica =$this -> actualizarActivoCelularTransaction($datos_generales, $datos_celular, $id, $id_cel);

        if($verifica == 1){
          $this->link->query("commit;");
        }
        else{
          $this->link->query('rollback;');
        }

        return $verifica;

    }//- fin function

    /**
       * Actualiza registros de Activos Tipo Celuar Transaccion Iniciando por guardar los datos generales
     **/
    function actualizarActivoCelularTransaction($datos_generales, $datos_celular, $id, $id_cel){
        $verifica = 0;
        // Datos Generales
        $noSerie = $datos_generales['noSerie'];
        $noEco = $datos_generales['noEco'];
        $descripcion = $datos_generales['descripcion'];
        $codBarras = $datos_generales['codBarras'];
        $fechaAdq = $datos_generales['fechaAdq'];
        $valAdq = $datos_generales['valAdq'];
        $fechaBaja = $datos_generales['fechaBaja'];
        $propietario = $datos_generales['propietario'];
        $radioCompra = $datos_generales['radioCompra'];
        $anticipo = $datos_generales['anticipo'];
        $mensualidades = $datos_generales['mensualidades'];
        $fechaFinCredito = $datos_generales['fechaFinCredito'];
        $observaciones = $datos_generales['observaciones'];
        $radioTipo = $datos_generales['radioTipo'];

        //-->NJES December/17/2020 inactivar/activar activo y guardar usuario baja
        $inactivo = $datos_generales['inactivo'];

        if($inactivo == 1)
          $idUsuarioBaja = $datos_generales['idUsuario'];
        else
          $idUsuarioBaja = 0;

        // Datos Vehiculo
        $celMarca = $datos_celular['celMarca'];
        $celModelo = $datos_celular['celModelo'];
        $celImei = $datos_celular['celImei'];
        $celNumero = $datos_celular['celNumero'];
        $celCompania = $datos_celular['celCompania'];
        $celPaquete = $datos_celular['celPaquete'];
        $celContrato = $datos_celular['celContrato'];
        $celVigenciaContrato = $datos_celular['celVigenciaContrato'];

        $query = "UPDATE activos SET no_serie='$noSerie', num_economico='$noEco', descripcion='$descripcion',
            codigo_barras='$codBarras', fecha_adquisicion='$fechaAdq', valor_adquisicion=$valAdq, fecha_baja='$fechaBaja',
            id_empresa_fiscal=$propietario, financiamiento=$radioCompra, anticipo=$anticipo, mensualidades=$mensualidades,
            fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo',inactivo='$inactivo',
        id_usuario_baja='$idUsuarioBaja' WHERE id = $id";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if ($result){
          $idActivo = mysqli_insert_id($this->link);
          $query2 = "UPDATE celulares SET id_marca=$celMarca, modelo='$celModelo',
            imei='$celImei', num_telefono='$celNumero',
            id_compania=$celCompania, paquete='$celPaquete', no_contrato='$celContrato', vigencia='$celVigenciaContrato' WHERE id = $id_cel";
          $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

          if ($result2){
              $verifica = 1;
          }else{
              $verifica = 0;
          }
        }
        else{
          $verifica = 0;
        }

        return $verifica;
    }//- fin function



    /**
       * Guarda registros de Activos Tipo Equipo de Computo
     **/
    // @param entrada: Datos Generales array(), Datos Equipo Computo array()
    // @output: JSON (ID Activo, ID Equipo Computo)
    function guardarActivoEq($datos_generales, $datos_eq){
        $verifica = 0;
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

          $verifica =$this -> guardarActivoEqTransaction($datos_generales, $datos_eq);

        if($verifica != 0){
          $this->link->query("commit;");
        }
        else{
          $this->link->query('rollback;');
        }

        return json_encode($verifica);

    }//- fin function

    /**
       * Guarda registros de Activos Tipo Equipo de Computo Transaccion Iniciando por guardar los datos generales
     **/
    function guardarActivoEqTransaction($datos_generales, $datos_eq){
        $verifica = false;

        // Datos Vehiculo
        $eqMarca = $datos_eq['eqMarca'];
        $eqModelo = $datos_eq['eqModelo'];
        $eqTipo = $datos_eq['eqTipo'];
        $eqCargador = $datos_eq['eqCargador'];
        $eqCaracteristicas = $datos_eq['eqCaracteristicas'];

        $idActivo = $this->guardarDatosGenerales($datos_generales);
        
        if ( $idActivo > 0 ){

          
          $query2 = "INSERT INTO equipo_computo (id_marca, modelo, id_tipo_equipo, serie_cargador, caracteristicas, id_activo) VALUES ($eqMarca,'$eqModelo',$eqTipo, '$eqCargador','$eqCaracteristicas',$idActivo)";
          $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
          $idEq = mysqli_insert_id($this->link);
          $arregloEq = array();

          if ($result2){
            array_push($arregloEq,['id'=>$idActivo, 'idEq'=>$idEq]);
              $verifica = $arregloEq;
          }else{
              $verifica = false;
          }
        }
        else{
          $verifica = false;
        }

        return $verifica;
    }//- fin function

    // Actualizar Datos Generales y formulario Equipo de Computo
    // @param entrada: Datos Generales array(), Datos Equipo Computo array(), ID Activo, ID Equipo Computo
    // @output: int
    function actualizarActivoEq($datos_generales, $datos_eq, $id, $id_eq){
        $verifica = 0;
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica =$this -> actualizarActivoEqTransaction($datos_generales, $datos_eq, $id, $id_eq);

        if($verifica == 1){
          $this->link->query("commit;");
        }
        else{
          $this->link->query('rollback;');
        }

        return $verifica;

    }//- fin function

    /**
     * Actualizar registros de Activos Tipo Equipo de Computo Transaccion Iniciando por guardar los datos generales
   **/
    function actualizarActivoEqTransaction($datos_generales, $datos_eq, $id, $id_eq){
         $verifica = 0;
         // Datos Generales
         $noSerie = $datos_generales['noSerie'];
         $noEco = $datos_generales['noEco'];
         $descripcion = $datos_generales['descripcion'];
         $codBarras = $datos_generales['codBarras'];
         $fechaAdq = $datos_generales['fechaAdq'];
         $valAdq = $datos_generales['valAdq'];
         $fechaBaja = $datos_generales['fechaBaja'];
         $propietario = $datos_generales['propietario'];
         $radioCompra = $datos_generales['radioCompra'];
         $anticipo = $datos_generales['anticipo'];
         $mensualidades = $datos_generales['mensualidades'];
         $fechaFinCredito = $datos_generales['fechaFinCredito'];
         $observaciones = $datos_generales['observaciones'];
         $radioTipo = $datos_generales['radioTipo'];

        //-->NJES December/17/2020 inactivar/activar activo y guardar usuario baja
        $inactivo = $datos_generales['inactivo'];

        if($inactivo == 1)
          $idUsuarioBaja = $datos_generales['idUsuario'];
        else
          $idUsuarioBaja = 0;

         // Datos Vehiculo
         $eqMarca = $datos_eq['eqMarca'];
         $eqModelo = $datos_eq['eqModelo'];
         $eqTipo = $datos_eq['eqTipo'];
         $eqCargador = $datos_eq['eqCargador'];
         $eqCaracteristicas = $datos_eq['eqCaracteristicas'];

         $query = "UPDATE activos SET no_serie='$noSerie', num_economico='$noEco', descripcion='$descripcion',
            codigo_barras='$codBarras', fecha_adquisicion='$fechaAdq', valor_adquisicion=$valAdq, fecha_baja='$fechaBaja',
            id_empresa_fiscal=$propietario, financiamiento=$radioCompra, anticipo=$anticipo, mensualidades=$mensualidades,
            fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo',inactivo='$inactivo',
        id_usuario_baja='$idUsuarioBaja' WHERE id = $id";
         $result = mysqli_query($this->link, $query) or die(mysqli_error());

         if ($result){
           $idActivo = mysqli_insert_id($this->link);
           $query2 = "UPDATE equipo_computo SET id_marca=$eqMarca, modelo='$eqModelo',
              id_tipo_equipo=$eqTipo, serie_cargador='$eqCargador', caracteristicas='$eqCaracteristicas' WHERE id = $id_eq";
           $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

           if ($result2){
               $verifica = 1;
           }else{
               $verifica = 0;
           }
         }
         else{
           $verifica = 0;
         }

         return $verifica;
    }//- fin function

    // @param entrada:
    // @output: JSON(Activos)
    function buscarActivos($datos){
      $permisoModel = new VerificarPermiso();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta

      $idUsuario = $datos['idUsuario'];
      $idSucursal = $datos['idSucursal'];
      $idUnidadNegocio = $datos['idUnidadNegocio'];

      $permisoGlobal = $permisoModel -> buscarPermisosArmasActivo($idUsuario,'OPCIONES_GLOBAL_ACTIVOS_FIJOS',$idSucursal,$idUnidadNegocio);

      $permisoArmas = $permisoModel -> buscarPermisosArmasActivo($idUsuario,'ARMAS_ACTIVOS_FIJOS',$idSucursal,$idUnidadNegocio);
      
      if($permisoGlobal == 0 && $permisoArmas == 0)
      {
        $arr = array();
        return json_encode($arr);
      }else{
        if($permisoGlobal == 1 && $permisoArmas == 0)
          $condicionTipo = ' WHERE activos.tipo IN (1,2,3,4)';
        else if($permisoGlobal == 0 && $permisoArmas == 1)
          $condicionTipo = ' WHERE activos.tipo=5';
        else
          $condicionTipo = '';

        $query = "SELECT activos.id AS id,
        activos.no_serie AS no_serie,
        activos.num_economico AS num_economico,
        activos.descripcion AS descripcion,
        activos.fecha_adquisicion AS fecha_adquisicion,
        activos.valor_adquisicion AS valor_adquisicion,
        empresas_fiscales.razon_social AS propietario,
        activos.tipo AS tipo,
        if(activos.inactivo = 1,'Inactivo','Activo') AS estatus
        FROM activos
        LEFT JOIN empresas_fiscales
        ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
        $condicionTipo
        ORDER BY activos.id DESC";

        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        return query2json($result);
      }
      //if ($result) {
        //return query2json($result);
      //}
    }//- fin function

    // @param entrada: ID Activo
    // @output: JSON(Activo)
    //-->NJES Feb/10/2020 se busca el id familia gasto del producto del almacen del activo,
    //el folio del almacen, id del almacen_d y precio para insertarlos al afectar presupuesto al asignar responsabe o comodato
    function buscarActivoSelected($idActivo){
      $query = "SELECT activos.id AS id,
      activos.no_serie AS no_serie,
      activos.num_economico AS num_economico,
      activos.descripcion AS descripcion,
      activos.codigo_barras AS codigo_barras,
      activos.fecha_adquisicion AS fecha_adquisicion,
      activos.valor_adquisicion AS valor_adquisicion,
      activos.fecha_baja AS fecha_baja,
      empresas_fiscales.razon_social AS propietario,
      activos.id_empresa_fiscal AS id_empresa_fiscal,
      activos.financiamiento AS financiamiento,
      activos.anticipo AS anticipo,
      activos.mensualidades AS mensualidades,
      activos.fin_credito AS fin_credito,
      activos.observaciones AS observaciones,
      activos.tipo AS tipo,
      activos.folio_recepcion AS folio_recepcion,
      activos.id_sucursal,
      if(activos_responsables.responsable_externo='',0,1) AS externo,
      IFNULL(almacen_e.id,0) AS idS10,
      IF(activos_responsables.id_trabajador>0,'R',IF(activos_responsables.responsable_externo!='','R',IF(activos_responsables.id_cliente>0,'C','N'))) AS tipo_responsable,
      familias.id_familia_gasto,
      almacen_e.folio,
      almacen_d.id AS id_almacen_d,
      almacen_d.precio AS precio,
      activos.inactivo,
      activos.b_reactivar,
      IFNULL(activos_responsables.responsable,0) AS responsable_asignado
      FROM activos
      LEFT JOIN empresas_fiscales ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
      LEFT JOIN almacen_e on activos.id = almacen_e.id_activo_fijo
      LEFT JOIN almacen_d ON almacen_d.id_almacen_e=almacen_e.id
      LEFT JOIN productos ON almacen_d.id_producto=productos.id
      LEFT JOIN familias ON productos.id_familia=familias.id
      LEFT JOIN activos_responsables ON activos.id = activos_responsables.id_activo 
      WHERE activos.id=$idActivo 
      ORDER BY activos.fecha_adquisicion DESC";

      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada: ID Activo
    // @output: JSON(Activo)
    function buscarActivoSelectedResponsable($idActivo){
      $query = "SELECT
       activos_responsables.id as id_activo_responsable,
       activos_responsables.id_unidad_negocio,
       activos_responsables.id_sucursal,
       activos_responsables.id_area,
       activos_responsables.id_departamento,
       activos_responsables.id_trabajador,
       activos_responsables.id_cliente,
       activos_responsables.id_activo,
       activos_responsables.fecha_inicio,
       activos_responsables.fecha_fin,
       activos_responsables.no_licencia,
       activos_responsables.vigencia_licencia,
       activos_responsables.devolucion,
       activos_responsables.responsable,
       activos_responsables.responsable_externo,
       activos_responsables.cuip,
       IFNULL(CONCAT(activos_responsables.id_trabajador,' - ',TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)),'') AS empleado,
       IFNULL(razones_sociales.razon_social,'') as cliente
      FROM activos_responsables 
      LEFT JOIN trabajadores ON activos_responsables.id_trabajador = trabajadores.id_trabajador
      LEFT JOIN razones_sociales ON activos_responsables.id_cliente = razones_sociales.id
      WHERE activos_responsables.id_activo=$idActivo  AND activos_responsables.responsable = 1";

      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada: No. Serie string(number), Fecha date, Empresa int, F date
    // @output: JSON(Activo)
    function buscarActivosFiltro($datos,$no_serie, $fecha, $empresa, $tipo, $f, $no_economico){
        $condicionSerie='';
        $condicionFecha='';
        $condicionEmpresa='';
        $condicionTipo='';
        $condicionEconomico='';

        if($no_serie!=''){
            $condicionSerie = " AND activos.no_serie LIKE '%$no_serie%'";
        }

        if($fecha!=''){
          $condicionFecha = "AND activos.fecha_adquisicion BETWEEN '$fecha' AND '$f'";
        }

        if($empresa!=''){
          $condicionEmpresa = " AND activos.id_empresa_fiscal='$empresa'";
        }

        $idUsuario = $datos['idUsuario'];
        $idSucursal = $datos['idSucursal'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];

        $permisoModel = new VerificarPermiso();

        $permisoGlobal = $permisoModel -> buscarPermisosArmasActivo($idUsuario,'OPCIONES_GLOBAL_ACTIVOS_FIJOS',$idSucursal,$idUnidadNegocio);

        $permisoArmas = $permisoModel -> buscarPermisosArmasActivo($idUsuario,'ARMAS_ACTIVOS_FIJOS',$idSucursal,$idUnidadNegocio);
        

        if($tipo!=''){
          $condicionTipo = "AND activos.tipo LIKE '%$tipo%'";
        }else{
          if($permisoGlobal == 1 && $permisoArmas == 0)
            $condicionTipo = ' AND activos.tipo IN (1,2,3,4)';
          else if($permisoGlobal == 0 && $permisoArmas == 1)
            $condicionTipo = ' AND activos.tipo=5';
          else
            $condicionTipo = '';
        }

        if($no_economico!=''){
          $condicionEconomico = "AND activos.num_economico LIKE '%$no_economico%'";
        }

        
        if($permisoGlobal == 0 && $permisoArmas == 0)
        {
          $arr = array();
          return json_encode($arr);
        }else{
          $query = "SELECT activos.id AS id,
          activos.no_serie AS no_serie,
          activos.num_economico AS num_economico,
          activos.descripcion AS descripcion,
          activos.fecha_adquisicion AS fecha_adquisicion,
          activos.valor_adquisicion AS valor_adquisicion,
          empresas_fiscales.razon_social AS propietario,
          activos.id_empresa_fiscal AS id_empresa_fiscal,
          activos.tipo AS tipo,
          if(activos.inactivo = 1,'Inactivo','Activo') AS estatus
          FROM activos
          LEFT JOIN empresas_fiscales
          ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
          WHERE 1=1   $condicionSerie $condicionFecha $condicionEmpresa $condicionTipo $condicionEconomico";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          
          return query2json($result);
        }
        //if ($result) {
          //return query2json($result);
        //}
        // echo $query;
    }//- fin function

    // @param entrada: No. Serie string(number)
    // @output: JSON(Avtivos Bitacora)
    function buscarBitacoraFiltro($no_economico, $tipo,$fechaInicio,$fechaFin){

        $condicionTipo = '';
        $condicionNoEconomico = '';
        if($tipo!=''){
          $condicionTipo = " AND activos_bitacora.tipo LIKE '%$tipo%' ";
        }
        if($no_economico!=''){
          $condicionNoEconomico = " AND activos.num_economico LIKE '%$no_economico%' ";
        }

        if($fechaInicio == '' && $fechaFin == '')
          $condFecha=" AND activos_bitacora.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        else if($fechaInicio != '' &&  $fechaFin == '')
          $condFecha=" AND activos_bitacora.fecha >= '$fechaInicio' ";
        else
          $condFecha=" AND activos_bitacora.fecha BETWEEN '$fechaInicio' AND '$fechaFin' ";

        $query = "SELECT 
          activos_bitacora.id AS id_bitacora,
          activos_bitacora.tipo, 
          activos_bitacora.descripcion, 
          activos_bitacora.fecha, 
          activos.no_serie,
          activos.num_economico,
          activos_bitacora.kilometraje,
          activos_bitacora.id_activo,
          IFNULL(requisiciones.folio,'') AS folio_requisicion
          FROM activos_bitacora
          LEFT JOIN activos ON activos.id = activos_bitacora.id_activo
          LEFT JOIN requisiciones ON activos.num_economico=requisiciones.no_economico
          WHERE 1 $condicionNoEconomico $condicionTipo $condFecha";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        //if ($result) {
          return query2json($result);
        //}
    }//- fin function

    // @param entrada: ID Tipo Vehiculo
    // @output: JSON(Vehiculos)
    function queryTipoVehiculo($id){
      $query = "SELECT vehiculos.id as id_veh,
      vehiculos.id_tipo_vehiculo AS tipo_vehiculo,
      vehiculos.id_marca AS marca,
      vehiculos.color AS color,
      vehiculos.modelo AS modelo,
      vehiculos.placas AS placas,
      vehiculos.anio AS anio,
      vehiculos.vigencia_poliza AS poliza,
      vehiculos.vigencia_tarjeta_circulacion AS circulacion,
      vehiculos.imei_gps
      FROM activos
      LEFT JOIN empresas_fiscales
      ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
      LEFT JOIN vehiculos
      ON vehiculos.id_activo = activos.id
      WHERE activos.tipo=1 AND activos.id=$id";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    function queryTipoCelular($id){
      $query = "SELECT celulares.id as id_cel,
      celulares.id_marca AS marca,
      celulares.modelo AS modelo,
      celulares.imei AS imei,
      celulares.num_telefono AS telefono,
      celulares.id_compania AS compania,
      celulares.paquete AS paquete,
      celulares.no_contrato AS contrato,
      celulares.vigencia AS vigencia
      FROM activos
      LEFT JOIN empresas_fiscales
      ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
      LEFT JOIN celulares
      ON celulares.id_activo = activos.id
      WHERE activos.tipo=2 AND activos.id=$id";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    function queryTipoEqComp($id){
      $query = "SELECT equipo_computo.id as id_eq,
      equipo_computo.id_marca AS marca,
      equipo_computo.modelo AS modelo,
      equipo_computo.id_tipo_equipo AS tipo_equipo,
      equipo_computo.serie_cargador AS serie_cargador,
      equipo_computo.caracteristicas AS caracteristicas
      FROM activos
      LEFT JOIN empresas_fiscales
      ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
      LEFT JOIN equipo_computo
      ON equipo_computo.id_activo = activos.id
      WHERE activos.tipo=3 AND activos.id=$id";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada: ID Bitacora int
    // @output: JSON(Activos Bitacora)
    function activosBitacora($id,$fechaInicio,$fechaFin){

      $condicion=''; 

      if($id > 0){
        $condicion = "WHERE activos.id = '$id'";
      }else{
        $condicion ="WHERE activos_bitacora.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
      }

      //-->NJES March/23/2020 se obtiene los folios de las requis de tipo mantenimiento del registro que se genero en automatico 
      //al generar la recepcion de mercancia
      $query = "SELECT 
          activos_bitacora.id AS id_bitacora,
          activos_bitacora.tipo AS tipo, 
          activos_bitacora.descripcion AS descripcion,
          activos_bitacora.fecha AS fecha, 
          activos_bitacora.kilometraje,
          activos.id AS id_activo,
          activos.no_serie AS no_serie,
          activos.num_economico,
          if(activos_bitacora.folios_requisicion != 0,activos_bitacora.folios_requisicion,'') AS folio_requisicion
          FROM activos_bitacora
          LEFT JOIN activos ON activos.id = activos_bitacora.id_activo
          $condicion
          ORDER BY activos_bitacora.fecha DESC";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Semana Celular)
    function activosSeguimientoSemanaCelular(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
        activos.descripcion, celulares.vigencia
        FROM activos
        LEFT JOIN celulares
        ON celulares.id_activo=activos.id
        WHERE celulares.vigencia BETWEEN CURDATE()
        AND CURDATE() + INTERVAL 30 DAY";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Semana Licencia)
    function activosSeguimientoSemanaLicencia(){
      $query = "SELECT activos.id as id_activo, vehiculos.id as id, activos.num_economico, activos.no_serie, activos.tipo,
        activos.descripcion, vehiculos.vigencia_licencia, vehiculos.no_licencia,IFNULL(vehiculos.imei_gps,'') AS imei_gps
        FROM activos
        LEFT JOIN vehiculos
        ON vehiculos.id_activo=activos.id
        WHERE vehiculos.vigencia_licencia BETWEEN CURDATE()
        AND CURDATE() + INTERVAL 30 DAY";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Mes Celular)
    function activosSeguimientoMesCelular(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
        activos.descripcion, celulares.vigencia
        FROM activos
        LEFT JOIN celulares
        ON celulares.id_activo=activos.id
        WHERE celulares.vigencia BETWEEN CURDATE() + INTERVAL 31 DAY
        AND CURDATE() + INTERVAL 60 DAY";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Semana Licencia)
    function activosSeguimientoMesLicencia(){
      $query = "SELECT activos.id as id_activo, vehiculos.id as id, activos.num_economico, activos.no_serie, activos.tipo,
        activos.descripcion, vehiculos.vigencia_licencia, vehiculos.no_licencia,IFNULL(vehiculos.imei_gps,'') AS imei_gps
        FROM activos
        LEFT JOIN vehiculos
        ON vehiculos.id_activo=activos.id
        WHERE vehiculos.vigencia_licencia BETWEEN CURDATE() + INTERVAL 31 DAY
        AND CURDATE() + INTERVAL 60 DAY";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Sin Atender Celular)
    function activosSeguimientoSinAtenderCelular(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
        activos.descripcion, celulares.vigencia
        FROM activos
        LEFT JOIN celulares
        ON celulares.id_activo=activos.id
        WHERE celulares.vigencia < CURDATE() ";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Sin Atender Licencia)
    function activosSeguimientoSinAtenderLicencia(){
      $query = "SELECT activos.id as id_activo, vehiculos.id as id, activos.num_economico, activos.no_serie, activos.tipo,
        activos.descripcion, vehiculos.vigencia_licencia, vehiculos.no_licencia,IFNULL(vehiculos.imei_gps,'') AS imei_gps
        FROM activos
        LEFT JOIN vehiculos
        ON vehiculos.id_activo=activos.id
        WHERE vehiculos.vigencia_licencia < CURDATE()";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Semana Vehiculo Poliza)
    function activosSeguimientoSemanaVehiculoPoliza(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
      activos.descripcion, vehiculos.vigencia_poliza,
      IFNULL(vehiculos.imei_gps,'') AS imei_gps
      FROM activos
      LEFT JOIN vehiculos
      ON vehiculos.id_activo=activos.id
      WHERE vehiculos.vigencia_poliza BETWEEN CURDATE()
      AND CURDATE() + INTERVAL 30 DAY";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Mes Vehiculo Poliza)
    function activosSeguimientoMesVehiculoPoliza(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
      activos.descripcion, vehiculos.vigencia_poliza,
      IFNULL(vehiculos.imei_gps,'') AS imei_gps
      FROM activos
      LEFT JOIN vehiculos
      ON vehiculos.id_activo=activos.id
      WHERE vehiculos.vigencia_poliza BETWEEN CURDATE() + INTERVAL 31 DAY
      AND CURDATE() + INTERVAL 60 DAY";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Sin Atender Vehiculo Poliza)
    function activosSeguimientoSinAtenderVehiculoPoliza(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
      activos.descripcion, vehiculos.vigencia_poliza,
      IFNULL(vehiculos.imei_gps,'') AS imei_gps
      FROM activos
      LEFT JOIN vehiculos
      ON vehiculos.id_activo=activos.id
      WHERE vehiculos.vigencia_poliza < CURDATE() ";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Semana Vehiculo Circulacion)
    function activosSeguimientoSemanaVehiculoCirculacion(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
        activos.descripcion, vehiculos.vigencia_tarjeta_circulacion,
        IFNULL(vehiculos.imei_gps,'') AS imei_gps
        FROM activos
        LEFT JOIN vehiculos
        ON vehiculos.id_activo=activos.id
        WHERE vehiculos.vigencia_tarjeta_circulacion BETWEEN CURDATE()
        AND CURDATE() + INTERVAL 30 DAY ";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Mes Vehiculo Circulacion)
    function activosSeguimientoMesVehiculoCirculacion(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
          activos.descripcion, vehiculos.vigencia_tarjeta_circulacion,
          IFNULL(vehiculos.imei_gps,'') AS imei_gps
          FROM activos
          LEFT JOIN vehiculos
          ON vehiculos.id_activo=activos.id
          WHERE vehiculos.vigencia_tarjeta_circulacion BETWEEN CURDATE() + INTERVAL 31 DAY
          AND CURDATE() + INTERVAL 60 DAY";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada:
    // @output: JSON(Seguimiento Sin Atender Vehiculo Circulacion)
    function activosSeguimientoSinAtenderVehiculoCirculacion(){
      $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
        activos.descripcion, vehiculos.vigencia_tarjeta_circulacion,
        IFNULL(vehiculos.imei_gps,'') AS imei_gps
        FROM activos
        LEFT JOIN vehiculos
        ON vehiculos.id_activo=activos.id
        WHERE vehiculos.vigencia_tarjeta_circulacion < CURDATE()";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    // @param entrada: ID Activo
    // @output: JSON(Activo Responsable)
    function activosResponsables($id,$fechaInicio,$fechaFin){

        $condicion=''; 

        if($id > 0){
          $condicion = "WHERE activos.id = '$id'";
        }else{
          $condicion ="WHERE DATE(activos_responsables.fecha_inicio) BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        $query = "SELECT 
                    activos_responsables.id, 
                    activos_responsables.fecha_inicio,
                    activos_responsables.fecha_fin,
                    activos_responsables.no_licencia AS no_licencia,
                    activos_responsables.vigencia_licencia AS vigencia_licencia,
                    empresas_fiscales.razon_social,
                    sucursales.descr AS sucursal, 
                    cat_areas.descripcion AS areas, 
                    deptos.des_dep AS dpto,
                    activos_responsables.id_trabajador, 
                    activos_responsables.id_cliente, 
                    IF(activos_responsables.id_cliente>0, IFNULL(razones_sociales.razon_social,''),CONCAT(IFNULL(trabajadores.nombre,''),'',IFNULL(trabajadores.apellido_p,''),' ',IFNULL(trabajadores.apellido_m,''))) AS responsable,
                    activos.id AS id_activo, 
                    activos.no_serie, 
                    activos.num_economico, 
                    activos.descripcion,
                    IFNULL(razones_sociales.razon_social,'') AS cliente
              FROM activos_responsables
              LEFT JOIN empresas_fiscales ON empresas_fiscales.id_empresa=activos_responsables.id_unidad_negocio
              LEFT JOIN sucursales ON sucursales.id_sucursal=activos_responsables.id_sucursal
              LEFT JOIN cat_areas ON cat_areas.id=activos_responsables.id_area
              LEFT JOIN deptos ON deptos.id_depto=activos_responsables.id_departamento
              LEFT JOIN trabajadores ON trabajadores.id_trabajador=activos_responsables.id_trabajador
              LEFT JOIN activos ON activos.id=activos_responsables.id_activo
              LEFT JOIN razones_sociales ON razones_sociales.id=activos_responsables.id_cliente
              $condicion
              ORDER BY activos_responsables.id DESC";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            //if ($result) {
              return query2json($result);
            //}
    }

    function verificarResponsable($activo){
      $query = "SELECT COUNT(id_activo) AS total FROM activos_responsables WHERE id_activo=$activo";
      $result = mysqli_query($this->link,$query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//Fin
      /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
        ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
      */
      //-->NJES Feb/11/2020 se reciben los parametros familia gasto y clasificaicon para afectar a presupuesto
    function guardarResponsable($datos)
    {
      
      $_SESSION["id_activo"] = $datos['activo'];
      $verifica = false;

      $no_empleado = (isset($datos['no_empleado'])!='')?$datos['no_empleado']:0;
      $no_cliente = (isset($datos['no_cliente'])!='')?$datos['no_cliente']:0;
      $unidad = $datos['unidad'];
      $sucursal = $datos['sucursal'];
      $area = $datos['area'];
      $dpto = $datos['dpto'];
      $activo = $datos['activo'];
      $vehNoLicencia = (isset($datos['vehNoLicencia'])!='')?$datos['vehNoLicencia']:''; 
      $vehVigenciaLicencia  = (isset($datos['vehVigenciaLicencia'])!='')?$datos['vehVigenciaLicencia']:'';
      $idFamiliaGasto = $datos['idFamiliaGasto'];
      $idClasificacionGasto = $datos['idClasificacionGasto'];
      $idAlmacenDN = $datos['idAlmacenD'];
      $importe = $datos['precio'];
      $folio = $datos['folio'];
      $idS10 = $datos['idS10'];
      $idUsuario = $_SESSION['id_usuario'];

      $cuip = isset($datos['cuip']) ? $datos['cuip'] : '';
      $responsable_externo = isset($datos['responsable_externo']) ? $datos['responsable_externo'] : '';

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $query = "INSERT INTO activos_responsables (id_unidad_negocio, id_sucursal, id_area, id_departamento, id_trabajador, id_cliente, id_activo, fecha_inicio, no_licencia, vigencia_licencia,responsable,id_usuario_captura,cuip,responsable_externo)
      VALUES ($unidad,$sucursal,$area,$dpto,$no_empleado, $no_cliente,$activo,NOW(), '$vehNoLicencia', '$vehVigenciaLicencia',1,'$idUsuario','$cuip','$responsable_externo')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      if ($result) {
        //return true;
        if($idS10 > 0)
        {
          $arr = array('idAlmacenD'=>$idAlmacenDN,
                    'total'=>$importe,
                    'idUnidadNegocio'=>$unidad,
                    'idSucursal'=>$sucursal,
                    'idFamiliaGasto'=>$idFamiliaGasto,
                    'clasificacionGasto'=>$idClasificacionGasto,
                    'idActivo'=>$activo,
                    'tipo'=>'C');

          //-->NJES June/18/2020 DEN18-2760 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
          //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
          //afecta movimiento presupuesto solo la primera vez que se asigna por responsiva o por comodato, 
          //si el activo ya esta ligado aunque haya sido devuelto ya no afectará presupuesto la siguiente vez que se asigne
          //No es necesario verificar si esta ligado ya que cada vez que se reasigna se usa otra funcion en la que no se afecta el presupuesto
          $afectarPresupuesto = new MovimientosPresupuesto();

          $movP = $afectarPresupuesto->guardarMovimientoPresupuesto($arr);

          if($movP > 0)
          {
            $this->link->query("commit;");
            $verifica = true;
          }else{
            $this->link->query('rollback;');
            $verifica = false;
          }

          //$verifica = $this -> guardaMovimientoPresupuesto($arr);
        }else{
          $this->link->query("commit;");
          $verifica = true;
        }          
      }
      else {
        $this->link->query('rollback;');
        $verifica = false;
      }

      return $verifica;
    } //Fin

    // Actualizar Datos Generales y formulario Equipo de Computo
    // @param entrada: ID activo int, Arreglo Responsable array()
    // @output: int
    function activosResponsableReasignar($activo, $arregloRes){
        $verifica = 0;
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica =$this -> actualizarActivoResponsable($activo, $arregloRes);

        if($verifica == 1){
          $this->link->query("commit;");
        }
        else{
          $this->link->query('rollback;');
        }

        return $verifica;

    }//- fin function

    /**
      * Actualizar registros de Activos Responsable, la fecha fin y registrar uno nuevo
    **/

    /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
      ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
    */
    function actualizarActivoResponsable($activo, $arregloRes){
        $verifica=0;
        $_SESSION["id_activo"]=$activo;
        // Arreglo Formulario Responsable
        $unidad = $arregloRes['unidad'];
        $sucursal = $arregloRes['sucursal'];
        $area = $arregloRes['area'];
        $dpto = $arregloRes['dpto'];
        $no_empleado = (isset($arregloRes['no_empleado']))?$arregloRes['no_empleado']:0;
        $no_cliente = (isset($arregloRes['no_cliente']))?$arregloRes['no_cliente']:0;
        $vehNoLicencia = (isset($arregloRes['vehNoLicencia']))?$arregloRes['vehNoLicencia']:'';
        $vehVigenciaLicencia = (isset($arregloRes['vehVigenciaLicencia']))?$arregloRes['vehVigenciaLicencia']:'';
        $idUsuario = $_SESSION['id_usuario'];
        
        $cuip = isset($arregloRes['cuip']) ? $arregloRes['cuip'] : '';
        $responsable_externo = isset($datos['responsable_externo']) ? $datos['responsable_externo'] : '';

        $query = "SELECT id FROM activos_responsables WHERE id_activo=$activo AND fecha_fin=0000-00-00";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $id = mysqli_fetch_array($result);
        $id = $id['id'];

        if ($result){
          $query2 = "UPDATE activos_responsables SET fecha_fin=CURDATE() WHERE id = $id";
          $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

          if ($result2) {
            $query3 = "INSERT INTO activos_responsables (id_unidad_negocio, id_sucursal, id_area, id_departamento, id_trabajador, id_cliente, id_activo, fecha_inicio, no_licencia, vigencia_licencia, responsable,id_usuario_captura,cuip,responsable_externo) 
                        VALUES ($unidad,$sucursal,$area,$dpto,$no_empleado, $no_cliente, $activo, NOW(), '$vehNoLicencia', '$vehVigenciaLicencia', 1,'$idUsuario','$cuip','$responsable_externo')";
            $result3 = mysqli_query($this->link, $query3) or die(mysqli_error());

            if ($result3){
              $verifica = 1;

            }else{
              $verifica = 0;
            }
          }
          else {
            $verifica=0;
          }
        }
        else {
          $verifica = 0;
        }

        return $verifica;
    }//- fin function

    // @param entrada: Unidad Negocio int, No, empleado int, No. Serie int
    // @output: JSON (Responsables)
    //-->NJES June/11/2020 se quitan los parametros $no_empleado, $no_cliente, $no_serie porque no se estan usando para el query
    function responsablesFiltro($unidad,$idActivo,$fechaInicio,$fechaFin){
            $condicion ='';
            if($unidad>0){
              //$condicion.=" AND empresas_fiscales.id_empresa=".$unidad;
              $condicion.=" AND activos_responsables.id_unidad_negocio=".$unidad;
            }

            if($idActivo>0){
              $condicion.=" AND activos_responsables.id_activo =".$idActivo;
            }

            if($fechaInicio == '' && $fechaFin == '')
            {
              $fecha=" AND DATE(activos_responsables.fecha_inicio) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
              $fecha=" AND DATE(activos_responsables.fecha_inicio) >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
              $fecha=" AND DATE(activos_responsables.fecha_inicio) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }
            
            $query = "SELECT 
                                activos_responsables.id, 
                                activos_responsables.fecha_inicio,
                                activos_responsables.fecha_fin,
                                activos_responsables.no_licencia AS no_licencia,
                                activos_responsables.vigencia_licencia AS vigencia_licencia,
                                empresas_fiscales.razon_social,
                                sucursales.descr AS sucursal, 
                                cat_areas.descripcion AS areas, 
                                deptos.des_dep AS dpto,
                                activos_responsables.id_trabajador, 
                                activos_responsables.id_cliente, 
                                IF(activos_responsables.id_cliente>0, IFNULL(razones_sociales.razon_social,''),CONCAT(IFNULL(trabajadores.nombre,''),'',IFNULL(trabajadores.apellido_p,''),' ',IFNULL(trabajadores.apellido_m,''))) AS responsable,
                                activos.id AS id_activo, 
                                activos.no_serie, 
                                activos.num_economico,
                                activos.descripcion,
                                IFNULL(razones_sociales.razon_social,'') AS cliente,
                                IFNULL(vehiculos.imei_gps,'') AS imei_gps
                          FROM activos_responsables
                          LEFT JOIN empresas_fiscales ON empresas_fiscales.id_empresa=activos_responsables.id_unidad_negocio
                          LEFT JOIN sucursales ON sucursales.id_sucursal=activos_responsables.id_sucursal
                          LEFT JOIN cat_areas ON cat_areas.id=activos_responsables.id_area
                          LEFT JOIN deptos ON deptos.id_depto=activos_responsables.id_departamento
                          LEFT JOIN trabajadores ON trabajadores.id_trabajador=activos_responsables.id_trabajador
                          LEFT JOIN activos ON activos.id=activos_responsables.id_activo
                          LEFT JOIN razones_sociales ON razones_sociales.id=activos_responsables.id_cliente
                          LEFT JOIN vehiculos ON activos.id=vehiculos.id_activo
                        WHERE 1  $condicion $fecha
                        ORDER BY activos_responsables.id DESC";
            $result = mysqli_query($this->link,$query) or die(mysqli_error());
            //if ($result) {
              return query2json($result);
            //}

    }//Fin



    // @param entrada: No. Serie string(number), Fecha date, Empresa int, F date
    // @output: JSON(Activo)
    function buscarActivosFiltroE01($noEconomico, $tipo)
    {

          $condicionTipo='';
          $condicionNoEconomico='';

          if($tipo!=''){
            $condicionTipo='  AND activos.tipo = '.$tipo;
          }

          if($noEconomico!=''){
            $condicionNoEconomico="  AND activos.num_economico LIKE '%$noEconomico%'";
          }

          //-->NJES March/11/2020 se obtiene el responsable del activo fijo
          //-->NJES December/18/2020 buscar solo los activos con estatus activo
          $query = "SELECT activos.id AS id,
          activos.no_serie AS no_serie,
          activos.descripcion AS descripcion,
          activos.num_economico AS no_economico,
          activos.tipo AS tipo,
          IFNULL(CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)),'') AS responsable
          FROM activos
          LEFT JOIN empresas_fiscales ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
          LEFT JOIN activos_responsables ON activos.id = activos_responsables.id_activo AND activos_responsables.responsable=1
          LEFT JOIN trabajadores ON activos_responsables.id_trabajador = trabajadores.id_trabajador
          WHERE 1=1  $condicionTipo  $condicionNoEconomico AND activos.inactivo=0";

          // echo $query;
          // exit();

          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          //if ($result) {
          
          return query2json($result);

          //}

    }//- fin function
          /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
            ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
          */
          // Actualizar datos de licencia en Seguimiento Modal
    function actualizarLicenciaSeguimiento($no_lic, $vig_lic, $id, $id_activo){
        $verifica = false;
        $_SESSION["id_activo"]=$id_activo;
        $query = "UPDATE activos_responsables SET no_licencia='$no_lic', vigencia_licencia='$vig_lic' WHERE id = $id";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          $verifica = true;
        }
        else {
          $verifica = false;
        }

        return $verifica;
    }//- fin function

          /***
           * DEVOLVER EL ACTIVO FIJO Y LIMPOIAR LOS CAMOS PARA PODER REASIGNAR UN responsable
           */
    function devolverActivoSelectedResponsable($idResponsable){
        $verifica = 0;
        $query = "UPDATE activos_responsables SET devolucion=1, responsable=0  WHERE id=".$idResponsable;     
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          $verifica = 1;
        }
        else {
          $verifica = 0;
        }

        return $verifica;

    } //Fin

    /* MGFS 28-01-2020 SE AGREGA REPORTE DE MANTENIMIENTO DE VEHICULOS---
    */
    function activosReporteMantenimientoVehiculos($fechaInicio,$fechaFin){
          $condFecha = '';

          if($fechaInicio == '' && $fechaFin == '')
          {
              $condFecha=" AND a.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
          }else if($fechaInicio != '' &&  $fechaFin == '')
          {
              $condFecha=" AND a.fecha_pedido >= '$fechaInicio' ";
          }else{  //-->trae fecha inicio y fecha fin
              $condFecha=" AND DATE(a.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin' ";
          }
          $query = "SELECT 
          b.no_serie,
          num_economico,
          IFNULL(c.modelo,'') as modelo,
          IFNULL(placas,'') AS placas,
          IFNULL(c.anio,'') AS anio,
          a.folio AS requisicion,
          a.fecha_pedido,
          a.kilometraje,
          a.total,
          IFNULL(a.descripcion,'') AS descripcion,
          IFNULL(c.imei_gps,'') AS imei_gps
          FROM requisiciones a 
          LEFT JOIN activos b ON a.no_economico=b.num_economico 
          LEFT JOIN vehiculos c ON b.id=c.id_activo 
          WHERE a.tipo=2 AND a.id_orden_compra>0 $condFecha";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
        //if ($result) {
          return query2json($result);
        //}
    }//- fin function

    function buscarReporteActivos($idUnidadNegocio,$idSucursal,$fechaInicio,$fechaFin,$idEmpresaFiscal){

      $condicionSucursales ='';
      if($idSucursal!=''){

        if (strpos($idSucursal, ',') !== false) {
          
          $dato=substr(trim($idSucursal),1);
          $condicionSucursales=' AND c.id_sucursal in ('.$dato.')';
        }else{
          $condicionSucursales=' AND c.id_sucursal ='.$idSucursal;
        }

      }else{
        
        $condicionSucursales=' AND c.id_sucursal =0';
      }

      $condFecha = '';

      if($fechaInicio == '' && $fechaFin == '')
      {
          $condFecha=" AND a.fecha_adquisicion >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
      }else if($fechaInicio != '' &&  $fechaFin == '')
      {
          $condFecha=" AND a.fecha_adquisicion >= '$fechaInicio' ";
      }else{  //-->trae fecha inicio y fecha fin
          $condFecha=" AND DATE(a.fecha_adquisicion) BETWEEN '$fechaInicio' AND '$fechaFin' ";
      }

      //-->NJES March/17/2021 agregar filtro empresa fiscal
      $condEmpresaFiscal = '';
      if($idEmpresaFiscal != '')
      {
        $condEmpresaFiscal = ' AND a.id_empresa_fiscal = '.$idEmpresaFiscal;
      }


      $query = "SELECT 
          a.id AS id,
          a.no_serie AS no_serie,
          a.num_economico AS num_economico,
          a.descripcion AS descripcion,
          a.fecha_adquisicion AS fecha_adquisicion,
          a.valor_adquisicion AS valor_adquisicion,
          b.razon_social AS propietario,
          IF(a.tipo=1,'Vehiculo',IF(a.tipo=2,'Celular',IF(a.tipo=3,'Equipo Computo','Otro'))) AS tipo,
          '' AS poliza,
          IFNULL(c.vigencia_licencia,'') AS vigencia_licencia,
          c.id_trabajador,
          c.id_cliente,
          IF(IFNULL(c.id_trabajador,0)>0,IFNULL(CONCAT(c.id_trabajador,' - ',TRIM(d.nombre),' ',TRIM(d.apellido_p),' ',TRIM(d.apellido_m)),''),IFNULL(e.razon_social,'')) AS responsable,
          IFNULL(f.vigencia_poliza,'') AS vigencia_poliza,
          IFNULL(g.nombre,'') AS unidad_negocio,
          IFNULL(h.descr,'') AS sucursal,
          c.id_unidad_negocio,
          c.id_sucursal,
          IFNULL(f.imei_gps,'') AS imei_gps
        FROM activos a
        LEFT JOIN empresas_fiscales b ON a.id_empresa_fiscal = b.id_empresa
        LEFT JOIN activos_responsables c ON a.id=c.id_activo AND c.responsable=1
        LEFT JOIN trabajadores d ON c.id_trabajador=d.id_trabajador
        LEFT JOIN razones_sociales e ON c.id_cliente = e.id
        LEFT JOIN vehiculos f ON a.id=f.id_activo
        LEFT JOIN cat_unidades_negocio g ON c.id_unidad_negocio=g.id
        LEFT JOIN sucursales h ON c.id_sucursal=h.id_sucursal
        WHERE c.id_unidad_negocio=".$idUnidadNegocio." $condicionSucursales $condEmpresaFiscal  $condFecha
        ORDER BY a.id DESC";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }//- fin function

    function verificarNumeroEconomico($numeroEconomico){
      $verifica = 0;

      $query = "SELECT id FROM activos WHERE num_economico = '$numeroEconomico'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

      return $verifica;
    }

    //-->NJES April/29/2020 se agregan funciones para guardar y verificar clase y marca de armas
    function validarMarcaArmas($marcaArmas){
      $sql = "SELECT COUNT(marca) AS total FROM armas_marcas WHERE marca LIKE '$marcaArmas'";
      $result = mysqli_query($this->link,$sql) or die(mysqli_error());
      $total = mysqli_fetch_array($result);
      return $total['total'];
    }

    function validarClaseArmas($claseArmas){
      $sql = "SELECT COUNT(clase) AS total FROM armas_clases WHERE clase LIKE '$claseArmas'";
      $result = mysqli_query($this->link,$sql) or die(mysqli_error());
      $total = mysqli_fetch_array($result);
      return $total['total'];
    }

    function guardarClaseArmas($claseArmas){
      $verifica = false;
      $sql2 = "INSERT into armas_clases (clase) VALUES ('$claseArmas')";
      $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
      if ($result2){
        $verifica = true;
      }
      else{
        $verifica = false;
      }

      return $verifica;
    }

    function guardarMarcaArmas($marcaArmas){
      $verifica = false;
      $sql2 = "INSERT into armas_marcas (marca) VALUES ('$marcaArmas')";
      $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
      if ($result2){
        $verifica = true;
      }
      else{
        $verifica = false;
      }

      return $verifica;
    }

    function guardarActivoArmas($datos_generales, $datos_armas){
      $verifica = 0;
      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica =$this -> guardarActivoArmasTransaction($datos_generales, $datos_armas);

      if($verifica != 0){
        $this->link->query("commit;");
      }
      else{
        $this->link->query('rollback;');
      }

      return json_encode($verifica);
    }

    function guardarActivoArmasTransaction($datos_generales, $datos_armas){
      $verifica = false;

      // Datos Armas
      $armasMarca = $datos_armas['armasMarca'];
      $armasClase = $datos_armas['armasClase'];
      $armasCalibre = $datos_armas['armasCalibre'];
      $armasModelo = $datos_armas['armasModelo'];
      $armasMatricula = $datos_armas['armasMatricula'];
      $armasFechaIngreso = $datos_armas['armasFechaIngreso'];
      $armasFechaBaja = $datos_armas['armasFechaBaja'];

      $idActivo = $this->guardarDatosGenerales($datos_generales);
      
      if ( $idActivo > 0 ){

      
        $query2 = "INSERT INTO armas_activos (id_marca, id_clase, calibre, modelo, matricula, fecha_ingreso, fecha_baja, id_activo) 
                    VALUES ('$armasMarca','$armasClase','$armasCalibre','$armasModelo','$armasMatricula','$armasFechaIngreso','$armasFechaBaja',$idActivo)";
        $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
        $idArmas = mysqli_insert_id($this->link);
        $arregloArmas = array();

        if ($result2){
          array_push($arregloArmas,['id'=>$idActivo, 'idArmas'=>$idArmas]);
          $verifica = $arregloArmas;
        }else{
            $verifica = false;
        }
      }
      else{
        $verifica = false;
      }

      return $verifica;
    }

    function actualizarActivoArmas($datos_generales, $datos_armas, $idActivo, $id_armas){
      $verifica = 0;
      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica =$this -> actualizarActivoArmasTransaction($datos_generales, $datos_armas, $idActivo, $id_armas);

      if($verifica != 0){
        $this->link->query("commit;");
      }
      else{
        $this->link->query('rollback;');
      }

      return json_encode($verifica);
    }

    function actualizarActivoArmasTransaction($datos_generales, $datos_armas, $idActivo, $id_armas){
      $verifica = 0;

      // Datos Generales
      $noSerie = $datos_generales['noSerie'];
      $noEco = $datos_generales['noEco'];
      $descripcion = $datos_generales['descripcion'];
      $codBarras = $datos_generales['codBarras'];
      $fechaAdq = $datos_generales['fechaAdq'];
      $valAdq = $datos_generales['valAdq'];
      $fechaBaja = $datos_generales['fechaBaja'];
      $propietario = $datos_generales['propietario'];
      $radioCompra = $datos_generales['radioCompra'];
      $anticipo = $datos_generales['anticipo'];
      $mensualidades = $datos_generales['mensualidades'];
      $fechaFinCredito = $datos_generales['fechaFinCredito'];
      $observaciones = $datos_generales['observaciones'];
      $radioTipo = $datos_generales['radioTipo'];

      //-->NJES December/17/2020 inactivar/activar activo y guardar usuario baja
      $inactivo = $datos_generales['inactivo'];

      if($inactivo == 1)
        $idUsuarioBaja = $datos_generales['idUsuario'];
      else
        $idUsuarioBaja = 0;

      // Datos Armas
      $armasMarca = $datos_armas['armasMarca'];
      $armasClase = $datos_armas['armasClase'];
      $armasCalibre = $datos_armas['armasCalibre'];
      $armasModelo = $datos_armas['armasModelo'];
      $armasMatricula = $datos_armas['armasMatricula'];
      $armasFechaIngreso = $datos_armas['armasFechaIngreso'];
      $armasFechaBaja = $datos_armas['armasFechaBaja'];

      $query = "UPDATE activos SET no_serie='$noSerie', num_economico='$noEco', descripcion='$descripcion',
                  codigo_barras='$codBarras', fecha_adquisicion='$fechaAdq', valor_adquisicion=$valAdq, fecha_baja='$fechaBaja',
                  id_empresa_fiscal=$propietario, financiamiento=$radioCompra, anticipo=$anticipo, mensualidades=$mensualidades,
                  fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo',inactivo='$inactivo',
                  id_usuario_baja='$idUsuarioBaja' WHERE id = $idActivo";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      if($result)
      {
        $query2 = "UPDATE armas_activos SET id_marca='$armasMarca', id_clase='$armasClase', 
                  calibre='$armasCalibre', modelo='$armasModelo', matricula='$armasMatricula', 
                  fecha_ingreso='$armasFechaIngreso', fecha_baja='$armasFechaBaja' 
                  WHERE id = $id_armas";
        $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

        if($result2)
        {
          $verifica = 1;
        }else{
          $verifica = 0;
        }
      }
      else{
        $verifica = 0;
      }

      return $verifica;
    }

    function queryTipoArmasComp($id){
      $query = "SELECT armas_activos.id as id_armas,
      armas_activos.id_marca,
      armas_activos.id_clase,
      armas_activos.modelo,
      armas_activos.calibre,
      armas_activos.matricula,
      armas_activos.fecha_ingreso,
      armas_activos.fecha_baja
      FROM activos
      LEFT JOIN empresas_fiscales
      ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
      LEFT JOIN armas_activos
      ON armas_activos.id_activo = activos.id
      WHERE activos.tipo=5 AND activos.id=$id";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      //if ($result) {
        return query2json($result);
      //}
    }

  function solicitarReactivar($id){
    $verifica = 0;

    $query = "UPDATE activos SET b_reactivar=1 WHERE id = $id";
    $result = mysqli_query($this->link, $query) or die(mysqli_error());

    if($result)
      $verifica = 1;

    return $verifica;
  }

  function verificarEstatus($id){
    $verifica = 0;

    $query = "SELECT inactivo FROM activos WHERE id=".$id;
    $result = mysqli_query($this->link, $query) or die(mysqli_error());

    $rowX = mysqli_fetch_array($result);
    $inactivo = $rowX['inactivo'];

    $verifica = $inactivo;

    return $verifica;
  }

  function buscarActivosReactivar(){
    $query = "SELECT id,num_economico,descripcion,
              CASE
                  WHEN tipo = 1 THEN 'Vehiculo'
                  WHEN tipo = 2 THEN 'Celular'
                  WHEN tipo = 3 THEN 'Equipo de Computo'
                  WHEN tipo = 4 THEN 'Otros'
                  ELSE 'Armas'
              END AS tipo,
              IF(inactivo=0,'Activo','Inactivo') AS estatus
              FROM activos WHERE b_reactivar=1
              ORDER BY id ASC";

    $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
    return query2json($result);
  }

  function rechazarReactivar($id){
    $verifica = 0;

    $query = "UPDATE activos SET b_reactivar=0 WHERE id = $id";
    $result = mysqli_query($this->link, $query) or die(mysqli_error());

    if($result)
      $verifica = 1;

    return $verifica;
  }

  function aprobarReactivar($id){
    $verifica = 0;

    $query = "UPDATE activos SET fecha_baja='0000-00-00',inactivo=0,b_reactivar=0 WHERE id = $id";
    $result = mysqli_query($this->link, $query) or die(mysqli_error());

    if($result)
      $verifica = 1;

    return $verifica;
  }

}//--fin de class Activos

?>
