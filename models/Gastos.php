<?php

require_once('conectar.php');
require_once('MovimientosPresupuesto.php');

class Gastos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Gastos()
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
    function guardarGastos($datos){
    
        $verifica = 0;
        $$verifica2 = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);
    
        if($verifica > 0){

          $deudoresDiversos = $datos[1]['deudoresDiversos'];

          //-->NJES July/30/2020
          $diferentesFamilias = $datos[1]['diferentesFamilias'];

          //-->NJES July/30/2020 guardar detalle de gastos porque viene de una requi de diferentes familias de gastos
          if($diferentesFamilias == 1)
          {
            $verifica2 = 0;
            $datosRequisDiferentesFamilias = $datos[1]['datosRequisDiferentesFamilias'];
            //guardarGastosDetalle($idRegistro,$datosRequisDiferentesFamilias);
            
            foreach($datosRequisDiferentesFamilias as $d)
            {
              $idFamiliaGasto = $d['idFamiliaGasto'];
              $idClasificacion = $d['idClasificacion'];
              $idRequisicionD = $d['idRequisicionD'];
              $total = $d['total'];

              $query="INSERT INTO gastos_d(id_gasto,id_familia_gasto,id_clasificacion,id_requisicion_d)
                      VALUES('$verifica','$idFamiliaGasto','$idClasificacion','$idRequisicionD')";
              $result=mysqli_query($this->link, $query)or die(mysqli_error());

              if($result)
              {
                 /* MGFS (cuando no es deudor diverso se genera el egreso por default por que sale el dinero en el momento
              *  cuando es deudor diverso se genera el egereso hasta que hace la comprabacion y se paga en cxp lo comprobado 
              *  si lo comprobado es  menos se ira a movimientos ingresos)
              *   
              * SI NO ES DEUDOR DIVERSO SE GENERA POR DEFAOULT SU MOVIMIENTO EN LA TABLA (movimientos_presupuesto)
              * SI ES DEUDOR DIVERSO SU MOVIMIENTO EN LA TABLA(movimientos_presupuesto) SE GENERA HASTA HACER EL PAGO EN CXP_PAGOS
              */
                if($deudoresDiversos==0)
                {
                  $tipoMov = $datos[1]['tipoMov'];
                  //-->NJES June/16/2020 DEN18-2760 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
                  //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
                  $afectarPresupuesto = new MovimientosPresupuesto();

                  if($tipoMov==0){
                    $arrDatosMP = array(
                      'idUnidadNegocio' => $datos[1]['idUnidad'],
                      'idSucursal' => $datos[1]['idSucursal'],
                      'idFamiliaGasto' => $idFamiliaGasto,
                      'clasificacionGasto' => $idClasificacion,
                      'total' => $total,
                      'tipo' => 'C',
                      'idGasto' => $verifica,
                      'fecha' => $datos[1]['fecha_aplicacion']
                    );

                    $verifica2 = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 
                  }else{
                    $arrDatosMP = array(
                      'estatus' => 'C',
                      'id' => $verifica,  //-->en este caso sería el id_gasto pero id podria ser id_viatico, id_cxp, etc.
                      'tipo' => 'gasto'
                    );
                    $verifica2 = $afectarPresupuesto->actualizarEstatusMovimientoPresupuesto($arrDatosMP); 
                  }
                }else{ //--si es deudor diverso = 1 no genera el movimientos_presupuesto
                  //$this->link->query("commit;");
                  $verifica2 = 1;
                }

              }else{
                $verifica2 = 0;
                break;
              }
            }

            if($verifica2 > 0){
              $this->link->query("commit;");
            }else{
              $verifica = 0;
              $this->link->query('rollback;');
            }

          }else{
            
            /* MGFS (cuando no es deudor diverso se genera el egreso por default por que sale el dinero en el momento
            *  cuando es deudor diverso se genera el egereso hasta que hace la comprabacion y se paga en cxp lo comprobado 
            *  si lo comprobado es  menos se ira a movimientos ingresos)
            *   
            * SI NO ES DEUDOR DIVERSO SE GENERA POR DEFAOULT SU MOVIMIENTO EN LA TABLA (movimientos_presupuesto)
            * SI ES DEUDOR DIVERSO SU MOVIMIENTO EN LA TABLA(movimientos_presupuesto) SE GENERA HASTA HACER EL PAGO EN CXP_PAGOS
            */
            if($deudoresDiversos==0)
            {
              //-->NJES June/16/2020 DEN18-2760 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
              //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos

              $tipoMov = $datos[1]['tipoMov'];

              $afectarPresupuesto = new MovimientosPresupuesto();

              if($tipoMov==0){
                $arrDatosMP = array(
                  'idUnidadNegocio' => $datos[1]['idUnidad'],
                  'idSucursal' => $datos[1]['idSucursal'],
                  'idFamiliaGasto' => $datos[1]['familiaGasto'],
                  'clasificacionGasto' => $datos[1]['clasificacionGasto'],
                  'total' => $datos[1]['total'],
                  'tipo' => 'C',
                  'idGasto' => $verifica,
                  'fecha' => $datos[1]['fecha_aplicacion']
                );

                $verifica2 = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 
              }else{
                $arrDatosMP = array(
                  'estatus' => 'C',
                  'id' => $verifica,  //-->en este caso sería el id_gasto pero id podria ser id_viatico, id_cxp, etc.
                  'tipo' => 'gasto'
                );
                $verifica2 = $afectarPresupuesto->actualizarEstatusMovimientoPresupuesto($arrDatosMP); 
              }

              if( $verifica2 > 0){

                $this->link->query("commit;");

              }else{
                $verifica = 0;
                $this->link->query('rollback;');
              }

            }else{//--si es deudor diverso = 1 no genera el movimientos_presupuesto

              $this->link->query("commit;");
            }
          }

        }else{
          $this->link->query('rollback;');

        }
            

        return $verifica;

    } //-- fin function guardarGastos


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
        $tipoMov = $datos[1]['tipoMov'];
        $idUsuario = $datos[1]['idUsuario'];
        $idGasto = $datos[1]['idGasto'];
        $idUnidad = $datos[1]['idUnidad'];
        $idSucursal = $datos[1]['idSucursal'];
        $idArea = $datos[1]['idArea'];
        $idDepto = $datos[1]['idDepto'];
        $idProveedor = $datos[1]['idProveedor'];
        $fecha = $datos[1]['fecha'];
        $fechaReferencia = $datos[1]['fechaReferencia'];
        $tipoGasto = $datos[1]['tipoGasto'];
        $referencia = $datos[1]['referencia'];
        $familiaGasto = $datos[1]['familiaGasto'];
        $clasificacionGasto = $datos[1]['clasificacionGasto'];
        $nombreClasificacion = $datos[1]['nombreClasificacion'];
        $concepto = $datos[1]['concepto'];
        $idCuenta = $datos[1]['idCuenta'];
        $idBanco = $datos[1]['idBanco'];
        $observaciones = $datos[1]['observaciones'];
        $deudoresDiversos = $datos[1]['deudoresDiversos'];
        $idEmpleado = $datos[1]['idEmpleado'];
        $nomEmpleado = $datos[1]['nomEmpleado'];
        $subtotal = $datos[1]['subtotal'];
        $iva = $datos[1]['iva'];
        $total = $datos[1]['total'];
        $justificacion = $datos[1]['justificacion'];
        $tipoCuenta = $datos[1]['tipoCuenta'];
        $idRequisicion = $datos[1]['idRequisicion'];
        $folioRequisicion = $datos[1]['folioRequisicion'];
        $diferentesFamilias = $datos[1]['diferentesFamilias'];
        $fechaAplicacion = $datos[1]['fecha_aplicacion'];

        //-->NJES 23/septembrer/2020 cachar que si no trae familia gasto y clasificacion termine con el proceso
        //esto solo cuando no viene de diferentes familias porque solo asi debe traer familia y clasificacion a insertar en el gasto
        //si es diferentes familias la familia gasto y clasificacion se guardan en gastos_d
        if($diferentesFamilias == 1 || ($diferentesFamilias == 0 && $familiaGasto != null && $clasificacionGasto != null))
        {  
        //---- se hace la insercion  
          if($tipoMov==0){  

            $query = "INSERT INTO gastos(id_unidad_negocio, id_sucursal, id_area, id_departamento, id_familia, id_clasificacion, referencia, id_concepto, fecha, fecha_referencia,observaciones, id_proveedor, tipo, id_banco, id_cuenta_banco, subtotal, iva, id_trabajador, nombre, tipo_deudor, concepto, id_usuario, id_requisicion, folio_requisicion,fecha_aplicacion_presupuestos) 
            VALUES ('$idUnidad','$idSucursal','$idArea','$idDepto','$familiaGasto','$clasificacionGasto','$referencia','G99','$fecha','$fechaReferencia','$observaciones','$idProveedor','$tipoGasto','$idBanco','$idCuenta','$subtotal','$iva','$idEmpleado','$nomEmpleado','$deudoresDiversos', '$concepto','$idUsuario','$idRequisicion','$folioRequisicion','$fechaAplicacion')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idRegistro = mysqli_insert_id($this->link);

          }else{
            /*--  Se hace la cancelacion  del ingreso 
            //--  justificacion='$justificacion'
            //--- MGFS 09-01-2020 SE AGREGA ', id_requisicion='0', folio_requisicion='0' 
                  PARA QUE SI SE CANCEL UN GASTO QUE TIENE UN ID_REQUI SE LIBERE LA REQUISOCION*/
            $idRegistro=$idGasto;
            $query = "UPDATE gastos SET estatus='0', id_requisicion='0', folio_requisicion='0' WHERE id=".$idGasto;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
          }

          if ($result)
          { 
            //-->Si no es deudor diverso guardo el movimiento en bancos o caja chica inmediatamente
            if($deudoresDiversos == 0){
              if($tipoCuenta == 0)
              {
                $verifica = $this -> guardarMovimientosBancos($datos,$idRegistro);
              }else{
                $verifica = $this -> guardarGastoCajaChica($datos,$idRegistro);
              }
            }else{
              //-->Si es deudor diverso no genera movimiento presupuesto hasta que se genere el pago en cxp masivo
              //-->NJES Jan/27/2020 la clasificacion gasto se llamara VALES en lugar de GASOLINA
              if($nombreClasificacion == 'VALES'){

                $verifica = $this -> guardarValesGasolina($datos,$idRegistro);

              }else if($nombreClasificacion == 'CAJA CHICA'){

                $verifica = $this -> guardarCajaChica($datos,$idRegistro);

              }else{
                $verifica = $idRegistro;
              }
            }
              
          } 
        }
        
        return $verifica;
    }

    function guardarMovimientosBancos($datos,$idRegistro){
          
      $verifica = 0;

      $idGasto = $datos[1]['idGasto'];
      $idBanco = $datos[1]['idBanco'];
      $tipoMov = $datos[1]['tipoMov'];
      $idCuenta = $datos[1]['idCuenta'];
      //-->NJES April/05/2021 cambiar parametro fecha por fecha_aplicacion ya que es la que indica el usuarios para afectar el movimiento banco
      $fecha = $datos[1]['fecha_aplicacion'];
      $observaciones = $datos[1]['observaciones'];
      $total = $datos[1]['total'];
      $idUsuario = $datos[1]['idUsuario'];
      $nombreClasificacion = $datos[1]['nombreClasificacion'];
      $tipo='C';// tipo Abono
      //---- se hace la insercion  
      if($tipoMov==0){
          $estatus='1';// estatus Activo
         
      }else{

          $query = "UPDATE movimientos_bancos SET estatus='0' WHERE id_gasto=".$idRegistro;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());

          $estatus='0'; // estatus cancelado 
          $total= $total * (-1);
      }

          $query = "INSERT INTO movimientos_bancos(id_cuenta_banco, monto, transferencia,tipo,id_usuario,observaciones,estatus,id_gasto,fecha_aplicacion) 
          VALUES ('$idCuenta','$total',0,'$tipo','$idUsuario','$observaciones','$estatus','$idRegistro','$fecha')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          //$idRegistro = mysqli_insert_id($this->link);

      if ($result)
      { 
        //-->NJES Jan/27/2020 la clasificacion gasto se llamara VALES en lugar de GASOLINA
        if($nombreClasificacion == 'VALES')
        {
          $verifica = $this -> guardarValesGasolina($datos,$idRegistro);
        }else if($nombreClasificacion == 'CAJA CHICA')
        {
          $verifica = $this -> guardarCajaChica($datos,$idRegistro);
        }else{
          $verifica = $idRegistro;
        }
      }else{
        $verifica = 0;
      }
      
      
      return $verifica;
  }

  function guardarGastoCajaChica($datos,$idRegistro){
    $verifica = 0;

    $concepto = $datos[1]['concepto'];
    $tipoMov = $datos[1]['tipoMov'];
    //-->NJES April/05/2021 cambiar parametro fecha por fecha_aplicacion ya que es la que indica el usuarios para afectar el movimiento banco
    $fecha = $datos[1]['fecha_aplicacion'];
    $importe = $datos[1]['total'];
    $idUsuario = $datos[1]['idUsuario'];
    //$idUnidad = $datos[1]['idUnidad'];
    //$idSucursal = $datos[1]['idSucursal'];
    $nombreClasificacion = $datos[1]['nombreClasificacion'];

    $idCuenta = $datos[1]['idCuenta'];

    if($tipoMov==0){
      $importe = $importe;
      $estatus='1';// estatus Activo
    }else{ 
      $importe= $importe * (-1);
      $estatus='0';// estatus Cancelado
    }

      //-->NJES Jan/21/2020 Busco id_unidad_negocio, id_sucursal de la cuenta banco caja chica de la que voy a hacer un egreso G01
      $buscaCuenta = "SELECT id_unidad_negocio,id_sucursal 
            FROM cuentas_bancos WHERE id=".$idCuenta;
      $resultC = mysqli_query($this->link, $buscaCuenta) or die(mysqli_error());

      if($resultC)
      {
        $datosC=mysqli_fetch_array($resultC);
        $idUnidadNegocioG=$datosC['id_unidad_negocio']; 
        $idSucursalG=$datosC['id_sucursal'];

        //-->busca el folio de la sucursal para aumentarlo
        $queryFolio="SELECT folio_caja_chica FROM sucursales WHERE id_sucursal=".$idSucursalG;
        $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());

        if($resultF)
        {
          $datosX=mysqli_fetch_array($resultF);
          $folioA=$datosX['folio_caja_chica'];
          $folio= $folioA+1;

          //--> aumenta el folio de la sucursal
          $queryU = "UPDATE sucursales SET folio_caja_chica='$folio' WHERE id_sucursal=".$idSucursalG;
          $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
          if($resultU)
          {
            //--> Inserta en caja chica el ingreso o egreso
            $query="INSERT INTO caja_chica(folio,id_unidad_negocio,id_sucursal,id_concepto,clave_concepto,fecha,importe,observaciones,estatus,id_usuario,id_gasto)
                    VALUES('$folio','$idUnidadNegocioG','$idSucursalG',16,'G01','$fecha','$importe','$concepto','$estatus','$idUsuario','$idRegistro')";
            $result=mysqli_query($this->link, $query)or die(mysqli_error());
            $id = mysqli_insert_id($this->link);

            if($result)
            {
              //-->NJES Jan/27/2020 la clasificacion gasto se llamara VALES en lugar de GASOLINA
              if($nombreClasificacion == 'VALES')
              {
                $verifica = $this -> guardarValesGasolina($datos,$idRegistro);
              }else{
                $verifica = $idRegistro; 
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
  }

    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=ininactivo 2=todos
      *
      **/
      function buscarGastos($idUnidadNegocio,$idSucursal,$fechaInicio,$fechaFin){

      $condicionFecha='';
    
      if($fechaInicio == '' && $fechaFin == ''){

        $condicionFecha=" AND gastos.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";

      }else if($fechaInicio != '' &&  $fechaFin == ''){

        $condicionFecha=" AND gastos.fecha >= '$fechaInicio' ";

      }else{  //-->trae fecha inicio y fecha fin

        $condicionFecha=" AND gastos.fecha >= '$fechaInicio' AND gastos.fecha <= '$fechaFin' ";
      }
        //-->NJES March/12/2020 se agrega folio requsiición cuando aplique
        //IFNULL(IF(cuentas_bancos.tipo=1,CONCAT('CAJA CHICA - ',cuentas_bancos.descripcion),cuentas_bancos.descripcion),'') AS cuenta
        $resultado = $this->link->query("SELECT 
        gastos.id,
        gastos.estatus,
        unidad.nombre AS unidad,
        sucursales.descr AS sucursal,
        deptos.des_dep AS departamento,
        IF(requisiciones.b_varias_familias=1,'DIFERENTES FAMILIAS',fam_gastos.descr) AS familia_gastos,
        IF(requisiciones.b_varias_familias=1,'DIFERENTES CLASIFICACIONES',gastos_clasificacion.descr) AS clasificacion_gasto,
        gastos.fecha,
        gastos.fecha_referencia,
        IF(gastos.tipo='F','Factura',IF(gastos.tipo='N','Nota',IF(gastos.tipo='R','Recibo','Reposición')))AS tipo_gasto, 
        concat(gastos.tipo,': ',gastos.referencia) as referencia,
        proveedores.nombre as proveedor,
        gastos.observaciones,
        IFNULL(gastos.id_requisicion,0) as id_requisicion,
        IFNULL(gastos.folio_requisicion,'') as folio_requisicion, 
        (gastos.subtotal+gastos.iva) AS total, 
        bancos.clave AS banco,
        IFNULL(IF(cuentas_bancos.tipo=1,cuentas_bancos.descripcion,cuentas_bancos.descripcion),'') AS cuenta,
        IF(gastos.folio_requisicion>0,gastos.folio_requisicion,'') AS folio_requisicion,
        requisiciones.b_varias_familias
        FROM  gastos 
        LEFT JOIN cat_unidades_negocio AS unidad ON  gastos.id_unidad_negocio = unidad.id
        LEFT JOIN sucursales ON gastos.id_sucursal = sucursales.id_sucursal
        LEFT JOIN deptos ON gastos.id_departamento =  deptos.id_depto
        LEFT JOIN fam_gastos ON gastos.id_familia = fam_gastos.id_fam
        LEFT JOIN gastos_clasificacion ON gastos.id_clasificacion = gastos_clasificacion.id_clas
        LEFT JOIN proveedores ON gastos.id_proveedor = proveedores.id
        LEFT JOIN bancos ON gastos.id_banco = bancos.id
        LEFT JOIN cuentas_bancos ON gastos.id_cuenta_banco = cuentas_bancos.id
        LEFT JOIN requisiciones ON gastos.id_requisicion=requisiciones.id
        WHERE  gastos.id_unidad_negocio=".$idUnidadNegocio." AND gastos.id_sucursal=".$idSucursal."  $condicionFecha
        ORDER BY gastos.id DESC");
        return query2json($resultado);

      }//- fin function buscarGastos
      /***MGFS 17-07-2018 Se agrega validacion para que solo se puedan cancelar los gastos del mes que no tengan un registro en movimientos_bancos */      
      function buscarGastosId($idGasto){

        $resultado = $this->link->query("SELECT 
        gastos.id,
        gastos.id_unidad_negocio, 
        gastos.id_sucursal, 
        gastos.id_area, 
        gastos.id_departamento, 
        gastos.id_familia, 
        gastos.id_clasificacion, 
        gastos.referencia,
        gastos.id_concepto,
        gastos.concepto,
        gastos.fecha,
        gastos.fecha_referencia,
        gastos.observaciones, 
        gastos.id_proveedor, 
        gastos.tipo, 
        gastos.id_banco, 
        gastos.id_cuenta_banco, 
        gastos.subtotal, 
        gastos.iva,
        (gastos.subtotal+gastos.iva) AS total, 
        gastos.id_trabajador,
        gastos.nombre,
        gastos.tipo_deudor AS deudor,
        gastos.estatus,
        IFNULL(gastos.id_requisicion,0) as id_requisicion,
        IFNULL(gastos.folio_requisicion,'') as folio_requisicion, 
        unidad.nombre AS unidad,
        sucursales.descr AS sucursal,
        cat_areas.descripcion AS are,
        deptos.des_dep AS departamento,
        IF(requisiciones.b_varias_familias=1,'VARIAS FAMILIAS',fam_gastos.descr) AS familia_gastos,
        IF(requisiciones.b_varias_familias=1,'VARIAS CLASIFICACIONES',gastos_clasificacion.descr) AS clasificacion_gasto,
        proveedores.nombre AS proveedor,
        IFNULL(IF(cuentas_bancos.tipo=1,'CAJA CHICA',bancos.clave),'') AS banco,
        IFNULL(cuentas_bancos.descripcion,'') AS cuenta,
        IF((IFNULL(movimientos_bancos.id,0))=0 AND DATE_FORMAT(gastos.fecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m'),1,0) AS bandera_cancela,
        requisiciones.b_varias_familias,
        gastos.fecha_aplicacion_presupuestos AS fecha_aplicacion
        FROM  gastos 
        LEFT JOIN cat_unidades_negocio AS unidad ON  gastos.id_unidad_negocio = unidad.id
        LEFT JOIN sucursales ON gastos.id_sucursal = sucursales.id_sucursal
        LEFT JOIN cat_areas ON gastos.id_area =  cat_areas.id
        LEFT JOIN deptos ON gastos.id_departamento =  deptos.id_depto
        LEFT JOIN fam_gastos ON gastos.id_familia = fam_gastos.id_fam
        LEFT JOIN gastos_clasificacion ON gastos.id_clasificacion = gastos_clasificacion.id_clas
        LEFT JOIN proveedores ON gastos.id_proveedor = proveedores.id
        LEFT JOIN bancos ON gastos.id_banco = bancos.id
        LEFT JOIN requisiciones ON gastos.id_requisicion=requisiciones.id
        LEFT JOIN cuentas_bancos ON gastos.id_cuenta_banco = cuentas_bancos.id
        LEFT JOIN movimientos_bancos ON gastos.id = movimientos_bancos.id_gasto AND movimientos_bancos.estatus=1 AND movimientos_bancos.tipo='C' 
        WHERE gastos.id=".$idGasto);
        return query2json($resultado);
        ////-->si no tiene un movimiento en banco y si de hoy se puede cancelar  

      }//- fin function buscarGastosId
 
      function guardarValesGasolina($datos,$idRegistro){
        $verifica = 0;
        
        $idUsuario = $datos[1]['idUsuario'];
        $idUnidadNegocio = $datos[1]['idUnidad'];
        $idSucursal = $datos[1]['idSucursal'];
        $idArea = $datos[1]['idArea'];
        $idDepartamento = $datos[1]['idDepto'];
        //-->NJES April/05/2021 cambiar parametro fecha por fecha_aplicacion ya que es la que indica el usuarios para afectar el movimiento banco
        $fecha = $datos[1]['fecha_aplicacion'];
        $observaciones = $datos[1]['observaciones'];
        $idEmpleado = $datos[1]['idEmpleado'];
        $empleado = $datos[1]['nomEmpleado'];
        $importe = $datos[1]['total'];

        $query="INSERT INTO vales_gasolina(id_unidad_negocio,id_sucursal,id_area,id_departamento,id_concepto,clave_concepto,fecha,id_empleado,nombre_empleado,importe,observaciones,estatus,id_gasto,id_usuario)
                VALUES('$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento',12,'C01','$fecha','$idEmpleado','$empleado','$importe','$observaciones',1,'$idRegistro','$idUsuario')";
        $result=mysqli_query($this->link, $query)or die(mysqli_error());

        if($result)
        {
            $verifica = $idRegistro;
        }else{
          $verifica = 0;
        }

        return $verifica;
      }//- fin function guardarValesGasolina

      function guardarCajaChica($datos,$idRegistro){
        $verifica = 0;
        
        $idUsuario = $datos[1]['idUsuario'];
        $idUnidadNegocio = $datos[1]['idUnidad'];
        $idSucursal = $datos[1]['idSucursal'];
        $idArea = $datos[1]['idArea'];
        $idDepartamento = $datos[1]['idDepto'];
        //-->NJES April/05/2021 cambiar parametro fecha por fecha_aplicacion ya que es la que indica el usuarios para afectar el movimiento banco
        $fecha = $datos[1]['fecha_aplicacion'];
        $observaciones = $datos[1]['observaciones'];
        $idEmpleado = $datos[1]['idEmpleado'];
        $empleado = $datos[1]['nomEmpleado'];
        $importe = $datos[1]['total'];

        //-->NJES Jan/21/2020 Aumentar el folio de la caja chica de la sucursal  a la que se hara el abono 
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
            $query="INSERT INTO caja_chica(id_unidad_negocio,id_sucursal,id_area,id_departamento,id_concepto,clave_concepto,fecha,id_empleado,nombre_empleado,importe,observaciones,estatus,id_gasto,id_usuario)
                    VALUES('$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento',15,'C01','$fecha','$idEmpleado','$empleado','$importe','$observaciones',1,'$idRegistro','$idUsuario')";
            $result=mysqli_query($this->link, $query)or die(mysqli_error());

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

        return $verifica;
      }//- fin function guardarCajaChica

      function buscarGastosEmpleadosDeudoresDiversos(){
        $result = $this->link->query("SELECT a.id_trabajador,a.nombre,IF(a.id_trabajador = 0,'Externo',b.puesto) AS puesto,IF(a.id_trabajador = 0,'Externo',c.des_dep) AS departamento
                                      FROM gastos a
                                      LEFT JOIN trabajadores d ON a.id_trabajador=d.id_trabajador
                                      LEFT JOIN cat_puestos b ON d.id_puesto=b.id_puesto
                                      LEFT JOIN deptos c ON d.id_depto=c.id_depto
                                      WHERE a.tipo_deudor=1 AND a.comprobado=0
                                      GROUP BY a.nombre");

        return query2json($result);
      }//- fin function buscarGastosEmpleadosDeudoresDiversos

      function buscarDetallesGastosId($idGasto){
        $result = $this->link->query("SELECT gastos_d.id,
        gastos_d.id_familia_gasto,
        gastos_d.id_clasificacion,
        gastos_d.id_requisicion_d,
        fam_gastos.descr AS familia_gasto,
        gastos_clasificacion.descr AS clasificacion_gasto,
        productos.concepto AS concepto,
        requisiciones_d.cantidad AS cantidad,
        requisiciones_d.costo_unitario AS costo_unitario,
        requisiciones_d.iva AS porcentaje_iva,
        ((requisiciones_d.cantidad*requisiciones_d.costo_unitario)*requisiciones_d.iva)/100 AS iva
        FROM gastos_d
        LEFT JOIN fam_gastos ON gastos_d.id_familia_gasto=fam_gastos.id_fam
        LEFT JOIN gastos_clasificacion ON gastos_d.id_clasificacion = gastos_clasificacion.id_clas
        LEFT JOIN requisiciones_d ON gastos_d.id_requisicion_d=requisiciones_d.id
        INNER JOIN productos ON requisiciones_d.id_producto = productos.id
        WHERE gastos_d.id_gasto=$idGasto");

        return query2json($result);
      }

      //-->NJES November/06/2020 omitir requisicion para que no aparezca en esta lista y no se ligue a un gasto
      function guardarOmitirRequisicion($id){
        $verifica = 0;

        $actualiza = "UPDATE requisiciones SET omitir=1 WHERE id=".$id; 
        $result2 = mysqli_query($this->link, $actualiza) or die(mysqli_error());
        
        if($result2)
          $verifica = 1;

        return $verifica;
      }

      /*function guardarGastosDetalle($idGasto,$info){
        $verifica = 0;

        foreach($info as $datos)
        {
          $idFamiliaGasto = $datos['idFamiliaGasto'];
          $idClasificacion = $datos['idClasificacion'];
          $idRequisicionD = $datos['idRequisicionD'];
          $total = $datos['total'];

          $query="INSERT INTO gastos_d(id_gasto,id_familia_gasto,id_clasificacion,id_requisicion_d)
                  VALUES('$idGasto','$idFamiliaGasto','$idClasificacion','$idRequisicionD')";
          $result=mysqli_query($this->link, $query)or die(mysqli_error());

          if($result)
            $verifica = $idGasto;
          else{
            $verifica = 0;
            break;
          }
        }

        return $verifica:
      }*/
    
}//--fin de class Gastos
    
?>