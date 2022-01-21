<?php

include 'conectar.php';
//session_start();

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

      $sql = "INSERT INTO activos (no_serie, num_economico, descripcion, codigo_barras, fecha_adquisicion, valor_adquisicion, fecha_baja, id_empresa_fiscal, financiamiento, anticipo, mensualidades, fin_credito, observaciones, tipo, folio_recepcion, id_sucursal)VALUES('$noSerie','$noEco','$descripcion','$codBarras','$fechaAdq',$valAdq,'$fechaBaja',$propietario,$radioCompra,$anticipo,$mensualidades,'$fechaFinCredito','$observaciones',$radioTipo,'$folioRecepcion','$idSucursal')";
      $result = mysqli_query($this->link, $sql) or die(mysqli_error());
      $idActivo = mysqli_insert_id($this->link);
      $_SESSION["id_activo"]=$idActivo;
      if ($result) {
          
          $verifica = $this -> generaSalidaPorResponsiva($idActivo, $folioRecepcion, $idAlmacenE, $idAlmacenD, $idUnidadNegocio, $idUsuario, $usuario, $tipoActivo);
      }else {
        $this->link->query('rollback;');
        $verifica = 0;
      }
      return $verifica;
    } //-- fin function guardarDatosGenerales

    /**
     *  GENERA UNA SLAIDA POR RESPONSIVA DEL ACTIVO FIJO 
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
      
      //$this->link->query("commit;");
     
      //$verifica = $idActivo;

      $busca1="SELECT id_unidad_negocio,id_sucursal,id_departamento,id_area
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

      $verifica = $this -> guardaMovimientoPresupuesto($arr);
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

      $sql = "UPDATE activos SET no_serie='$noSerie', num_economico='$noEco', descripcion='$descripcion',
codigo_barras='$codBarras', fecha_adquisicion='$fechaAdq', valor_adquisicion=$valAdq, fecha_baja='$fechaBaja',
id_empresa_fiscal=$propietario, financiamiento=$radioCompra, anticipo=$anticipo, mensualidades=$mensualidades,
fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo' WHERE id = $id";
      $result = mysqli_query($this->link, $sql) or die(mysqli_error());
      if ($result) {
       return true;
      }
      else {
       return false;
      }

    } //-- fin function Actualizar


    // @param entrada: Tipo(Info/Mtto) string, decripcion string, id (Id Activo) int
    // @output: ID registro insertado
    function guardarBitacora($tipo, $descripcion, $id){
      $fecha=date("Y-m-d");
      $query = "INSERT INTO activos_bitacora (tipo, descripcion, fecha, id_activo)
VALUES ('$tipo','$descripcion','$fecha',$id)";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      if ($result) {
        return true;
      }
      else {
        return false;
      }
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
     $sql2 = "INSERT into vehiculos_tipos (tipos) VALUES ('$tipoVeh')";
     $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
     if ($result2) {
       return true;
     }
     else {
       return false;
     }
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
     $sql2 = "INSERT into vehiculos_marcas (marcas) VALUES ('$marcaVeh')";
     $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
     if ($result2) {
       return true;
     }
     else {
       return false;
     }
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
     $sql2 = "INSERT into celulares_companias (compania) VALUES ('$companiaCel')";
     $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
     if ($result2) {
       return true;
     }
     else {
       return false;
     }
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
     $sql2 = "INSERT into equipo_computo_tipo (tipo) VALUES ('$tipoEq')";
     $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
     if ($result2) {
       return true;
     }
     else {
       return false;
     }
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
     $sql2 = "INSERT into equipo_computo_marcas (marca) VALUES ('$marcaEq')";
     $result2 = mysqli_query($this->link,$sql2) or die(mysqli_error());
     if ($result2){
       return true;
     }
     else{
       return false;
     }
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
       $vehVigenciaCirculacion = $datos_vehiculo['vehVigenciaCirculacion'];

        $idActivo = $this->guardarDatosGenerales($datos_generales);
        
       if ( $idActivo > 0 ){
        /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
          ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
        */
         $_SESSION["id_activo"]=$idActivo;
         $query2 = "INSERT INTO vehiculos (id_tipo_vehiculo, id_marca, color, modelo, placas, vigencia_poliza, vigencia_tarjeta_circulacion, id_activo) VALUES ($vehTipo, $vehMarca, '$vehColor', '$vehModelo', '$vehPlacas', '$vehVigencia', '$vehVigenciaCirculacion', $idActivo)";
         $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
         $idVeh = mysqli_insert_id($this->link);
         $arreglo = array();

         if ($result2){
           array_push($arreglo,['id'=>$idActivo, 'idVeh'=>$idVeh]);
             return $verifica = $arreglo;
         }else{
             return $verifica = false;
         }
       }
       else{
        return  $verifica = false;
       }
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
      
       // Datos Vehiculo
       $vehTipo = $datos_vehiculo['vehTipo'];
       $vehMarca = $datos_vehiculo['vehMarca'];
       $vehColor = $datos_vehiculo['vehColor'];
       $vehModelo = $datos_vehiculo['vehModelo'];
       $vehVigencia = $datos_vehiculo['vehVigencia'];
       $vehPlacas = $datos_vehiculo['vehPlacas'];
       $vehVigenciaCirculacion = $datos_vehiculo['vehVigenciaCirculacion'];

       $query = "UPDATE activos SET no_serie='$noSerie', num_economico='$noEco', descripcion='$descripcion',
 codigo_barras='$codBarras', fecha_adquisicion='$fechaAdq', valor_adquisicion=$valAdq, fecha_baja='$fechaBaja',
 id_empresa_fiscal=$propietario, financiamiento=$radioCompra, anticipo=$anticipo, mensualidades=$mensualidades,
 fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo' WHERE id = $id";
       $result = mysqli_query($this->link, $query) or die(mysqli_error());
       if ($result){
         $idActivo = mysqli_insert_id($this->link);
         $query2 = "UPDATE vehiculos SET id_tipo_vehiculo=$vehTipo, id_marca=$vehMarca, color='$vehColor', modelo='$vehModelo',
placas='$vehPlacas', vigencia_poliza='$vehVigencia',
vigencia_tarjeta_circulacion='$vehVigenciaCirculacion' WHERE id = $id_veh";
         $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

         if ($result2){
             return $verifica = 1;
         }else{
             return $verifica = 0;
         }
       }
       else{
        return  $verifica = 0;
       }
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
             return $verifica = $arregloCel;
         }else{
             return $verifica = false;
         }
       }
       else{
        return  $verifica = false;
       }
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
 fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo' WHERE id = $id";
       $result = mysqli_query($this->link, $query) or die(mysqli_error());

       if ($result){
         $idActivo = mysqli_insert_id($this->link);
         $query2 = "UPDATE celulares SET id_marca=$celMarca, modelo='$celModelo',
imei='$celImei', num_telefono='$celNumero',
id_compania=$celCompania, paquete='$celPaquete', no_contrato='$celContrato', vigencia='$celVigenciaContrato' WHERE id = $id_cel";
         $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

         if ($result2){
             return $verifica = 1;
         }else{
             return $verifica = 0;
         }
       }
       else{
        return  $verifica = 0;
       }
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
             return $verifica = $arregloEq;
         }else{
             return $verifica = false;
         }
       }
       else{
         return  $verifica = false;
       }
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
         // Datos Vehiculo
         $eqMarca = $datos_eq['eqMarca'];
         $eqModelo = $datos_eq['eqModelo'];
         $eqTipo = $datos_eq['eqTipo'];
         $eqCargador = $datos_eq['eqCargador'];
         $eqCaracteristicas = $datos_eq['eqCaracteristicas'];

         $query = "UPDATE activos SET no_serie='$noSerie', num_economico='$noEco', descripcion='$descripcion',
   codigo_barras='$codBarras', fecha_adquisicion='$fechaAdq', valor_adquisicion=$valAdq, fecha_baja='$fechaBaja',
   id_empresa_fiscal=$propietario, financiamiento=$radioCompra, anticipo=$anticipo, mensualidades=$mensualidades,
   fin_credito='$fechaFinCredito', observaciones='$observaciones', tipo='$radioTipo' WHERE id = $id";
         $result = mysqli_query($this->link, $query) or die(mysqli_error());

         if ($result){
           $idActivo = mysqli_insert_id($this->link);
           $query2 = "UPDATE equipo_computo SET id_marca=$eqMarca, modelo='$eqModelo',
id_tipo_equipo=$eqTipo, serie_cargador='$eqCargador', caracteristicas='$eqCaracteristicas' WHERE id = $id_eq";
           $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

           if ($result2){
               return $verifica = 1;
           }else{
               return $verifica = 0;
           }
         }
         else{
           return  $verifica = 0;
         }
       }//- fin function

       // @param entrada:
       // @output: JSON(Activos)
     function buscarActivos(){
       $query = "SELECT activos.id AS id,
       activos.no_serie AS no_serie,
       activos.num_economico AS num_economico,
       activos.descripcion AS descripcion,
       activos.fecha_adquisicion AS fecha_adquisicion,
       activos.valor_adquisicion AS valor_adquisicion,
       empresas_fiscales.razon_social AS propietario,
       activos.tipo AS tipo
       FROM activos
       LEFT JOIN empresas_fiscales
       ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
       ORDER BY activos.id DESC";
       $result = mysqli_query($this->link, $query) or die(mysqli_error());
       if ($result) {
         return query2json($result);
       }
     }//- fin function

     // @param entrada: ID Activo
     // @output: JSON(Activo)
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
        IFNULL(almacen_e.id,0) AS idS10,
        IF(activos_responsables.id_trabajador>0,'R',IF(activos_responsables.id_cliente>0,'C','N')) AS tipo_responsable
       FROM activos
       LEFT JOIN empresas_fiscales ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
       LEFT JOIN almacen_e on activos.id = almacen_e.id_activo_fijo
       LEFT JOIN activos_responsables ON activos.id = activos_responsables.id_activo AND activos.responsable=1
       WHERE activos.id=$idActivo 
       ORDER BY activos.fecha_adquisicion DESC";

       $result = mysqli_query($this->link, $query) or die(mysqli_error());
  
       if ($result) {
         return query2json($result);
       }
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
       
       IFNULL(CONCAT(activos_responsables.id_trabajador,' - ',TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)),'') AS empleado,
       IFNULL(razones_sociales.razon_social,'') as cliente
      FROM activos_responsables 
      LEFT JOIN trabajadores ON activos_responsables.id_trabajador = trabajadores.id_trabajador
      LEFT JOIN razones_sociales ON activos_responsables.id_cliente = razones_sociales.id
      WHERE activos_responsables.id_activo=$idActivo  AND activos_responsables.responsable = 1";

      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      if ($result) {
        return query2json($result);
      }
    }//- fin function

     // @param entrada: No. Serie string(number), Fecha date, Empresa int, F date
     // @output: JSON(Activo)
     function buscarActivosFiltro($no_serie, $fecha, $empresa, $tipo, $f, $no_economico){
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

          if($tipo!=''){
            $condicionTipo = "AND activos.tipo LIKE '%$tipo%'";
          }
          if($no_economico!=''){
            $condicionEconomico = "AND activos.num_economico LIKE '%$no_economico%'";
          }

         $query = "SELECT activos.id AS id,
         activos.no_serie AS no_serie,
         activos.num_economico AS num_economico,
         activos.descripcion AS descripcion,
         activos.fecha_adquisicion AS fecha_adquisicion,
         activos.valor_adquisicion AS valor_adquisicion,
         empresas_fiscales.razon_social AS propietario,
         activos.id_empresa_fiscal AS id_empresa_fiscal,
         activos.tipo AS tipo
         FROM activos
         LEFT JOIN empresas_fiscales
         ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
         WHERE 1=1   $condicionSerie $condicionFecha $condicionEmpresa $condicionTipo $condicionEconomico";
         $result = mysqli_query($this->link, $query) or die(mysqli_error());
         if ($result) {
           return query2json($result);
         }
         // echo $query;
     }//- fin function

     // @param entrada: No. Serie string(number)
     // @output: JSON(Avtivos Bitacora)
     function buscarBitacoraFiltro($no_economico, $tipo){

          $condicionTipo = '';
          $condicionNoEconomico = '';
          if($tipo!=''){
            $condicionTipo = " AND activos_bitacora.tipo LIKE '%$tipo%' ";
          }
          if($no_economico!=''){
            $condicionNoEconomico = " AND activos.num_economico LIKE '%$no_economico%' ";
          }
         $query = "SELECT activos_bitacora.tipo, activos_bitacora.descripcion, activos_bitacora.fecha, activos.no_serie,activos.num_economico
FROM activos_bitacora
LEFT JOIN activos ON activos.id = activos_bitacora.id_activo
WHERE 1 $condicionNoEconomico $condicionTipo";
         $result = mysqli_query($this->link, $query) or die(mysqli_error());
         if ($result) {
           return query2json($result);
         }
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
       vehiculos.vigencia_poliza AS poliza,
       vehiculos.vigencia_tarjeta_circulacion AS circulacion
       FROM activos
       LEFT JOIN empresas_fiscales
       ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
       LEFT JOIN vehiculos
       ON vehiculos.id_activo = activos.id
       WHERE activos.tipo=1 AND activos.id=$id";
       $result = mysqli_query($this->link, $query) or die(mysqli_error());
       if ($result) {
         return query2json($result);
       }
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
       if ($result) {
         return query2json($result);
       }
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
       if ($result) {
         return query2json($result);
       }
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

      $query = "SELECT 
      activos_bitacora.tipo AS tipo, 
      activos_bitacora.descripcion AS descripcion,
      activos_bitacora.fecha AS fecha, 
      activos.id AS id_activo,
      activos.no_serie AS no_serie,
      activos.num_economico
FROM activos_bitacora
LEFT JOIN activos ON activos.id = activos_bitacora.id_activo
$condicion
ORDER BY activos_bitacora.fecha DESC";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
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
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Semana Licencia)
     function activosSeguimientoSemanaLicencia(){
       $query = "SELECT activos.id as id_activo, vehiculos.id as id, activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_licencia, vehiculos.no_licencia
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_licencia BETWEEN CURDATE()
AND CURDATE() + INTERVAL 30 DAY";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
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
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Semana Licencia)
     function activosSeguimientoMesLicencia(){
       $query = "SELECT activos.id as id_activo, vehiculos.id as id, activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_licencia, vehiculos.no_licencia
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_licencia BETWEEN CURDATE() + INTERVAL 31 DAY
AND CURDATE() + INTERVAL 60 DAY";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
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
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Sin Atender Licencia)
     function activosSeguimientoSinAtenderLicencia(){
       $query = "SELECT activos.id as id_activo, vehiculos.id as id, activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_licencia, vehiculos.no_licencia
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_licencia < CURDATE()";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Semana Vehiculo Poliza)
     function activosSeguimientoSemanaVehiculoPoliza(){
       $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_poliza
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_poliza BETWEEN CURDATE()
AND CURDATE() + INTERVAL 30 DAY";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Mes Vehiculo Poliza)
     function activosSeguimientoMesVehiculoPoliza(){
       $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_poliza
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_poliza BETWEEN CURDATE() + INTERVAL 31 DAY
AND CURDATE() + INTERVAL 60 DAY";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Sin Atender Vehiculo Poliza)
     function activosSeguimientoSinAtenderVehiculoPoliza(){
       $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_poliza
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_poliza < CURDATE() ";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Semana Vehiculo Circulacion)
     function activosSeguimientoSemanaVehiculoCirculacion(){
       $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_tarjeta_circulacion
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_tarjeta_circulacion BETWEEN CURDATE()
AND CURDATE() + INTERVAL 30 DAY ";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Mes Vehiculo Circulacion)
     function activosSeguimientoMesVehiculoCirculacion(){
       $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_tarjeta_circulacion
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_tarjeta_circulacion BETWEEN CURDATE() + INTERVAL 31 DAY
AND CURDATE() + INTERVAL 60 DAY";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
     }//- fin function

     // @param entrada:
     // @output: JSON(Seguimiento Sin Atender Vehiculo Circulacion)
     function activosSeguimientoSinAtenderVehiculoCirculacion(){
       $query = "SELECT activos.num_economico, activos.no_serie, activos.tipo,
activos.descripcion, vehiculos.vigencia_tarjeta_circulacion
FROM activos
LEFT JOIN vehiculos
ON vehiculos.id_activo=activos.id
WHERE vehiculos.vigencia_tarjeta_circulacion < CURDATE()";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
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
        if ($result) {
          return query2json($result);
        }
      }

      function verificarResponsable($activo,$tipo){
        $query = "SELECT COUNT(id_activo) AS total FROM activos_responsables WHERE id_activo=$activo";
        $result = mysqli_query($this->link,$query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }
      }//Fin
       /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
          ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
        */
      function guardarResponsable($no_empleado, $no_cliente, $unidad, $sucursal, $area, $dpto, $activo, $vehNoLicencia, $vehVigenciaLicencia){
        $_SESSION["id_activo"] = $activo;
        $query = "INSERT INTO activos_responsables (id_unidad_negocio, id_sucursal, id_area, id_departamento, id_trabajador, id_cliente, id_activo, fecha_inicio, no_licencia, vigencia_licencia,responsable)
        VALUES ($unidad,$sucursal,$area,$dpto,$no_empleado, $no_cliente,$activo,NOW(), '$vehNoLicencia', '$vehVigenciaLicencia',1)";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return true;
        }
        else {
          return false;
        }
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
      
          $query = "SELECT id FROM activos_responsables WHERE id_activo=$activo AND fecha_fin=0000-00-00";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id = mysqli_fetch_array($result);
          $id = $id['id'];

          if ($result){
            $query2 = "UPDATE activos_responsables SET fecha_fin=CURDATE() WHERE id = $id";
            $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

            if ($result2) {
              $query3 = "INSERT INTO activos_responsables (id_unidad_negocio, id_sucursal, id_area, id_departamento, id_trabajador, id_cliente, id_activo, fecha_inicio, no_licencia, vigencia_licencia, responsable) VALUES ($unidad,$sucursal,$area,$dpto,$no_empleado, $no_cliente, $activo, NOW(), '$vehNoLicencia', '$vehVigenciaLicencia', 1)";
              $result3 = mysqli_query($this->link, $query3) or die(mysqli_error());

              if ($result3){
                return $verifica = 1;

              }else{
                return $verifica = 0;
              }
            }
            else {
              return $verifica=0;
            }
          }
          else {
            return $verifica = 0;
          }
      }//- fin function

      // @param entrada: Unidad Negocio int, No, empleado int, No. Serie int
      // @output: JSON (Responsables)
      function responsablesFiltro($unidad, $no_empleado, $no_cliente, $no_serie, $idActivo){
        $condicion ='';
        if($unidad>0){
           $condicion.=" AND empresas_fiscales.id_empresa=".$unidad;
        }

        if($idActivo>0){
          $condicion.=" AND activos_responsables.id_activo =".$idActivo;
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
WHERE 1  $condicion
ORDER BY activos_responsables.id DESC";
        $result = mysqli_query($this->link,$query) or die(mysqli_error());
        if ($result) {
          return query2json($result);
        }

      }//Fin



      // @param entrada: No. Serie string(number), Fecha date, Empresa int, F date
     // @output: JSON(Activo)
     function buscarActivosFiltroE01($noEconomico, $tipo){
       $condicionTipo='';
       $condicionNoEconomico='';

       if($tipo!=''){
        $condicionTipo='  AND activos.tipo = '.$tipo;
       }

       if($noEconomico!=''){
        $condicionNoEconomico="  AND activos.num_economico LIKE '%$noEconomico%'";
       }

      $query = "SELECT activos.id AS id,
      activos.no_serie AS no_serie,
      activos.descripcion AS descripcion,
      activos.num_economico AS no_economico,
      activos.tipo AS tipo
      FROM activos
      LEFT JOIN empresas_fiscales
      ON empresas_fiscales.id_empresa = activos.id_empresa_fiscal
      WHERE 1=1  $condicionTipo  $condicionNoEconomico";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      if ($result) {
        return query2json($result);
      }
  }//- fin function
       /*---MGFS 17-01-2020 SE AGREGA LA VARIABLE DE SESSION $_SESSION["id_activo"] YA QUE USA ESTA VARIABLE
        ---PARA GURADAR LOS PDFS CORRESPONDIENTES 
      */
      // Actualizar datos de licencia en Seguimiento Modal
      function actualizarLicenciaSeguimiento($no_lic, $vig_lic, $id, $id_activo){
        $_SESSION["id_activo"]=$id_activo;
        $query = "UPDATE activos_responsables SET no_licencia='$no_lic', vigencia_licencia='$vig_lic' WHERE id = $id";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return true;
        }
        else {
          return false;
        }
      }//- fin function

      /***
       * DEVOLVER EL ACTIVO FIJO Y LIMPOIAR LOS CAMOS PARA PODER REASIGNAR UN responsable
       */
      function devolverActivoSelectedResponsable($idResponsable){

        $query = "UPDATE activos_responsables SET devolucion=1, responsable=0  WHERE id=".$idResponsable;     
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) {
          return 1;
        }
        else {
          return 0;
        }

      } //Fin

      /**
      * Guarda en movimientos_presupuesto el movimiento, segun los registros guardados en almacen_d
      * 
      * @param int $idAlmacenD del almacen_d que se inserto
      * @param int $idPresupuestoEgreso del que se esta consumiendo el saldo
      * @param varchar $fecha del regostro
      * @param double $importe del registro almacen_d que se inserto
      * @param int $folio del registro en almacen_e
      *
    **/ 
    function guardaMovimientoPresupuesto($datos){
      $verifica = 0;

      $idAlmacenD = $datos['idAlmacenD'];
      $importe = $datos['importe'];
      $folio = $datos['folio'];
      //$fecha = $datos['fecha'];//se cambia por un timestamp
      $idUnidadNegocio = $datos['idUnidadNegocio'];
      $idSucursal = $datos['idSucursal'];
      $idDepartamento = $datos['idDepartamento'];
      $idArea = $datos['idArea'];
      $idFamiliaGasto = $datos['idFamiliaGasto'];
      $idActivo = $datos['idActivo'];

      $query = "INSERT INTO movimientos_presupuesto (monto,tipo,id_almacen_d,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_familia_gasto,id_unidad_negocio_o,id_sucursal_o,id_area_o,id_departamento_o,id_familia_gasto_o) 
                    VALUES ('$importe','C','$idAlmacenD','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idFamiliaGasto','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idFamiliaGasto')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      if($result)
      {
        $this->link->query("commit;");
        $verifica = $idActivo;
      }else{
        $this->link->query('rollback;');
        $verifica = 0;
      }
     
      return $verifica;
    }//-- fin function guardaMovimientoPresupuesto


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
      a.folio_mantenimiento AS requisicion,
      a.fecha_pedido,
      a.kilometraje,
      a.total,
      IFNULL(a.descripcion,'') AS descripcion 
      FROM requisiciones a 
      LEFT JOIN activos b ON a.no_economico=b.num_economico 
      LEFT JOIN vehiculos c ON b.id=c.id_activo 
      WHERE a.tipo=2 AND a.id_orden_compra>0 $condFecha";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
    if ($result) {
      return query2json($result);
    }
 }//- fin function

}//--fin de class Activos

?>
