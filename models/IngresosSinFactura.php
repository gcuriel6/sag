<?php

include 'conectar.php';

class IngresosSinFactura
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function IngresosSinFactura()
    {
  
      $this->link = Conectarse();

    }

    
    /**
      * Manda llamar a la funcion que guarda la informacion sobre una area
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $ininactivo estatus de una area  1='inactivo' 0='Ininactivo'  
      *
    **/      
    function guardarIngresosSinFactura($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarIngresosSinFactura


     /**
      * Guarda los datos de una area, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del area para realizarla
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $ininactivo estatus de una area  1='inactivo' 0='Ininactivo'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idIngreso = $datos[1]['idIngreso'];
        $idBanco = $datos[1]['idBanco'];
        $tipoMov = $datos[1]['tipoMov'];
        $idEmpresa = $datos[1]['idEmpresa'];
        $cuenta = $datos[1]['cuenta'];
        $idTipoIngreso = $datos[1]['idTipoIngreso'];
        $fecha = $datos[1]['fecha'];
        $observaciones = $datos[1]['observaciones'];
        $importe = $datos[1]['importe'];
        $justificacion = $datos[1]['justificacion'];
        $idUsuario = $datos[1]['idUsuario'];
        $tipoCuenta = $datos[1]['tipoCuenta'];
        $descripcion = $datos[1]['descripcion'];
        //-->NJES INGRESOS SIN FACTURA (1) 
        //* Agregar campos para especificar la Unidad de Negocio, la sucursal, el área y el departamento interno. Por default se debe mostrar seleccionada el área FINANZAS . 
        //*  Afectar los presupuestos de ingreso de acuerdo a la clasificación Unidad de Negocio – Sucursal – Área – Departamento Interno de los ingresos sin factura.
        // Dic/19/2019<--//
        $idUnidadNegocio = $datos[1]['idUnidadNegocio'];
        $idSucursal = $datos[1]['idSucursal'];
        $idArea = $datos[1]['idArea'];
        $idDepartamento = $datos[1]['idDepartamento'];
        $fondeo = $datos[1]['fondeo'];

        //---- se hace la insercion  
        if($tipoMov==0){

          $query = "INSERT INTO ingresos_sin_factura(id_tipo_ingreso, fecha, observaciones, id_banco, id_cuenta_banco, importe, id_empresa_fiscal,id_unidad_negocio,id_sucursal,id_area,id_departamento, fondeo) 
          VALUES ('$idTipoIngreso','$fecha','$observaciones','$idBanco','$cuenta','$importe','$idEmpresa','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento', $fondeo)";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idRegistro = mysqli_insert_id($this->link);

        }else{// Se hace la cancelacion  del ingreso 
          $idRegistro=$idIngreso;
          $query = "UPDATE ingresos_sin_factura SET estatus='0', justificacion='$justificacion' WHERE id=".$idIngreso;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result)
        { 
          if($tipoCuenta == 0){
            $verifica = $this->guardarMovimientosBancos($datos,$idRegistro);
          }else{
            $verifica = $this->guardaCajaChica($datos,$idRegistro);
          }
        }else{
          $verifica = 0;
        } 

        return $verifica;
    }


    function guardarMovimientosBancos($datos,$idRegistro){
          
        $verifica = 0;

        $idIngreso = $datos[1]['idIngreso'];
        $idBanco = $datos[1]['idBanco'];
        $tipoMov = $datos[1]['tipoMov'];
        $idEmpresa = $datos[1]['idEmpresa'];
        $cuenta = $datos[1]['cuenta'];
        $idTipoIngreso = $datos[1]['idTipoIngreso'];
        $fecha = $datos[1]['fecha'];
        $observaciones = $datos[1]['observaciones'];
        $importe = $datos[1]['importe'];
        $idUsuario = $datos[1]['idUsuario'];
        $tipo='A';// tipo Abono
        //---- se hace la insercion  
        if($tipoMov==0){
            $estatus='1';// estatus Activo
           
        }else{

            $query = "UPDATE movimientos_bancos SET estatus='0' WHERE id_ingreso_sin_factura=".$idRegistro;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            $estatus='0'; // estatus cancelado 
            $importe= $importe * (-1);
        }

            $query = "INSERT INTO movimientos_bancos(id_cuenta_banco, monto, id_ingreso_sin_factura, transferencia,tipo,id_usuario,observaciones,estatus,fecha_aplicacion) 
            VALUES ('$cuenta','$importe','$idRegistro',0,'$tipo','$idUsuario','$observaciones','$estatus','$fecha')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idRegistro = mysqli_insert_id($this->link);

        if ($result) 
            $verifica = $idRegistro;
        
        
        return $verifica;
    }

    function guardaCajaChica($datos,$idRegistro){
      $verifica = 0;

      $observaciones = $datos[1]['observaciones'];
      $tipoMov = $datos[1]['tipoMov'];
      $idCuentaBanco = $datos[1]['cuenta'];
      $fecha = $datos[1]['fecha'];
      $importe = $datos[1]['importe'];
      $idUsuario = $datos[1]['idUsuario'];
      //-->NJES Jan/21/2020 se toman estas porque se toma la caja chica de la unidad y sucursal seleccionada
      $idUnidadNegocio = $datos[1]['idUnidadNegocio'];
      $idSucursal = $datos[1]['idSucursal'];

      if($tipoMov==0){
        $importe = $importe;
        $estatus='1';// estatus Activo
      }else{ 
        $importe= $importe * (-1);
        $estatus='0';// estatus Cancelado
      }

      /*//-->busco id_unidad_negocio, id_sucursal de la cuenta banco origen de la que voy a hacer un egreso
      $buscaCuenta = "SELECT id_unidad_negocio,id_sucursal 
            FROM cuentas_bancos WHERE id=".$idCuentaBanco;
      $resultC = mysqli_query($this->link, $buscaCuenta) or die(mysqli_error());

      if($resultC)
      {
        $datosC=mysqli_fetch_array($resultC);
        $idUnidadNegocio=$datosC['id_unidad_negocio']; 
        $idSucursal=$datosC['id_sucursal']; */

        //-->busca el folio de la sucursal para aumentarlo
        $queryFolio="SELECT folio_caja_chica FROM sucursales WHERE id_sucursal=".$idSucursal;
        $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());

        if($resultF)
        {
          $datosX=mysqli_fetch_array($resultF);
          $folioA=$datosX['folio_caja_chica'];
          $folio= $folioA+1;

          //--> aumenta el folio de la sucursal
          $queryU = "UPDATE sucursales SET folio_caja_chica='$folio' WHERE id_sucursal=".$idSucursal;
          $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
          if($resultU)
          {
            //--> Inserta en caja chica el ingreso o egreso
            $query="INSERT INTO caja_chica(folio,id_unidad_negocio,id_sucursal,id_concepto,clave_concepto,fecha,importe,observaciones,estatus,id_usuario,id_ingreso_sin_factura)
                    VALUES('$folio','$idUnidadNegocio','$idSucursal',15,'C01','$fecha','$importe','$observaciones','$estatus','$idUsuario','$idRegistro')";
            $result=mysqli_query($this->link, $query)or die(mysqli_error());
            $id = mysqli_insert_id($this->link);

            if($result)
            {
              $verifica = $idRegistro; 
            }else{
              $verifica = 0;
            }
          }else{
            $verifica = 0;
          }
        }else{
          $verifica = 0;
        }

      /*}else{
        $verifica = 0;
      }*/

      return $verifica;
    }

    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=ininactivo 2=todos
      *
      **/
      function buscarIngresosSinFactura($fechaInicio,$fechaFin){

      $condicionFecha='';
    
      if($fechaInicio == '' && $fechaFin == ''){

        $condicionFecha=" WHERE DATE(ingresos_sin_factura.fecha) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";

      }else if($fechaInicio != '' &&  $fechaFin == ''){

        $condicionFecha=" WHERE DATE(ingresos_sin_factura.fecha) >= '$fechaInicio' ";

      }else{  //-->trae fecha inicio y fecha fin

        $condicionFecha=" WHERE DATE(ingresos_sin_factura.fecha) >= '$fechaInicio' AND DATE(ingresos_sin_factura.fecha) <= '$fechaFin' ";
      }

        $resultado = $this->link->query("SELECT 
        ingresos_sin_factura.id,
        ingresos_sin_factura.fecha, 
        ingresos_sin_factura.observaciones, 
        ingresos_sin_factura.importe, 
        ingresos_sin_factura.estatus,
        empresas_fiscales.razon_social AS empresa_fiscal,
        IF(cuentas_bancos.tipo=1,'CAJA CHICA',bancos.clave) AS banco,
        cuentas_bancos.descripcion as cuenta,
        cat_tipos_ingreso.descripcion AS tipo_ingreso,
        cat_unidades_negocio.nombre AS unidad_negocio,
        sucursales.descr AS sucursal,
        cat_areas.descripcion AS area,
        deptos.des_dep AS departamento
        FROM  ingresos_sin_factura 
        LEFT JOIN empresas_fiscales ON ingresos_sin_factura.id_empresa_fiscal = empresas_fiscales.id_empresa
        LEFT JOIN bancos ON ingresos_sin_factura.id_banco = bancos.id
        LEFT JOIN cuentas_bancos ON ingresos_sin_factura.id_cuenta_banco = cuentas_bancos.id
        LEFT JOIN cat_tipos_ingreso ON ingresos_sin_factura.id_tipo_ingreso = cat_tipos_ingreso.id
        LEFT JOIN cat_unidades_negocio ON ingresos_sin_factura.id_unidad_negocio=cat_unidades_negocio.id
        LEFT JOIN sucursales ON ingresos_sin_factura.id_sucursal=sucursales.id_sucursal
        LEFT JOIN cat_areas ON ingresos_sin_factura.id_area=cat_areas.id
        LEFT JOIN deptos ON ingresos_sin_factura.id_departamento=deptos.id_depto
        $condicionFecha
        ORDER BY ingresos_sin_factura.fecha DESC");
        return query2json($resultado);

      }//- fin function buscarIngresosSinFactura

      function buscarIngresosSinFacturaId($idTipoIngreso){
        
        $resultado = $this->link->query("SELECT 
        ingresos_sin_factura.id,
        ingresos_sin_factura.id_tipo_ingreso, 
        ingresos_sin_factura.fecha, 
        ingresos_sin_factura.observaciones, 
        ingresos_sin_factura.id_banco, 
        ingresos_sin_factura.id_cuenta_banco, 
        ingresos_sin_factura.importe, 
        ingresos_sin_factura.estatus,
        ingresos_sin_factura.id_empresa_fiscal,
        empresas_fiscales.razon_social AS empresa_fiscal,
        bancos.clave AS banco,
        cuentas_bancos.descripcion as cuenta,
        cat_tipos_ingreso.descripcion AS tipo_ingreso,
        ingresos_sin_factura.id_unidad_negocio,
        ingresos_sin_factura.id_sucursal,
        ingresos_sin_factura.id_area,
        ingresos_sin_factura.id_departamento,
        sucursales.descr AS sucursal,
        cat_areas.descripcion AS area,
        deptos.des_dep AS departamento
        FROM  ingresos_sin_factura 
        LEFT JOIN empresas_fiscales ON ingresos_sin_factura.id_empresa_fiscal = empresas_fiscales.id_empresa
        LEFT JOIN bancos ON ingresos_sin_factura.id_banco = bancos.id
        LEFT JOIN cuentas_bancos ON ingresos_sin_factura.id_cuenta_banco = cuentas_bancos.id
        LEFT JOIN cat_tipos_ingreso ON ingresos_sin_factura.id_tipo_ingreso = cat_tipos_ingreso.id
        LEFT JOIN cat_unidades_negocio ON ingresos_sin_factura.id_unidad_negocio=cat_unidades_negocio.id
        LEFT JOIN sucursales ON ingresos_sin_factura.id_sucursal=sucursales.id_sucursal
        LEFT JOIN cat_areas ON ingresos_sin_factura.id_area=cat_areas.id
        LEFT JOIN deptos ON ingresos_sin_factura.id_departamento=deptos.id_depto
        WHERE ingresos_sin_factura.id=".$idTipoIngreso);
        return query2json($resultado);
          

      }//- fin function buscarIngresosSinFacturaId
 

    
}//--fin de class IngresosSinFactura
    
?>