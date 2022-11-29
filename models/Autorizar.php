<?php

require_once('conectar.php');

class Autorizar
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Autorizar()
    {
  
      $this->link = Conectarse();

    }

  
    
    /**
      * Busca los datos de una autorizacion, retorna un JSON con los datos correspondientes
      * 
      * @param int $activo indica el estatus 1=pendiente 2=aprobada 
      *
      **/
      function buscarAutorizar($idsUnidades,$idUsuario,$idsSucursales,$fechaInicio,$fechaFin)
      {
        if($idsSucursales!=''){

          if (strpos($idsSucursales, ',') !== false) {
            
            $dato=substr(trim($idsSucursales),1);
            $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
          }else{
            $condicionSucursal=' AND a.id_sucursal ='.$idsSucursales;
          }
    
        }else{
          
          $condicionSucursal=' AND a.id_sucursal =0';
        }
       
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

        $permisoStock = $this -> buscarPermisosAutorizacionTipo($idUsuario,3,'AUTORIZAR_REQUISICIONES_STOCK',$idsSucursales);
        $permisoGastos = $this -> buscarPermisosAutorizacionTipo($idUsuario,1,'AUTORIZAR_REQUISICIONES_GASTOS',$idsSucursales);
        $permisoActivos = $this -> buscarPermisosAutorizacionTipo($idUsuario,0,'AUTORIZAR_REQUISICIONES_ACTIVOS_FIJOS',$idsSucursales);
        $permisoMantenimiento = $this -> buscarPermisosAutorizacionTipo($idUsuario,2,'AUTORIZAR_REQUISICIONES_MANTENIMIENTO',$idsSucursales);

        $permisoServicio = $this -> buscarPermisosAutorizacionTipo($idUsuario ,4, 'AUTORIZAR_REQUISICIONES_SERVICIO', $idsSucursales);

        //-- MGFS 09-01-2020 SE AGREGA VALIADCION (AND id_gasto=0) PARA QUE NO SE PUEDA CAMBIAR A PENDIENTE UNA REQUI TIPO GASTO CON UN GASTO ASIGNADO
        if($permisoStock == '' && $permisoGastos == '' && $permisoActivos == '' && $permisoMantenimiento == '' && $permisoServicio == '')
          $condicionPermisosTipos = "HAVING 0 AND id_gasto=0";
        else
        {

          $permisosTipo1 = $permisoStock.' '.$permisoGastos.' '.$permisoActivos.' '.$permisoMantenimiento . ' ' . $permisoServicio;
          $permisosTipo= substr(trim($permisosTipo1), 2, -1);
          $condicionPermisosTipos = "HAVING 1 AND id_gasto=0 AND ( $permisosTipo ))";
        }

        /** HACE LA BUSUQEDA DE TODO DE TODAS LAS UNIDADES QUE TIENE PERMISO Y SEGUN SI TIENE PERMISO POR TIPO
         * SE AGREGA LA CONDICION EN EL HAVING POR EJEMPLO OR (a.id_unidad_negocio=1 AND a.tipo=3)
         *  EL ULTIMO PARENTECIS ES PARA COMPLETAR LA CADENA YA QUE SE ESTA EXTRAYENODO EL PRIMER 'OR' 
         * Y QUITA EL ULTIMO ELEMENTO DE LA CADENA QUE ES UN PARENTECIS  substr(trim($permisosTipo1), 2, -1);
         */

        $query = "SELECT a.id_sucursal,a.id_unidad_negocio,a.tipo,a.id,a.folio,a.descripcion,a.total,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar','Pagada'))))) AS estatus,
                  IF(a.tipo=0,'ACTIVOS FIJOS',IF(a.tipo=1,'GASTOS',IF(a.tipo=2,'MANTENIMIENTO',IF(a.tipo = 3,'STOCK', 'ORDEN DE SERVICIO'))))AS tipo,b.nombre AS unidad_negocio,c.clave AS clave_suc,c.descripcion AS sucursal,
                  IF((a.total>d.monto_minimo OR a.total=d.monto_minimo) AND (a.total=d.monto_maximo OR a.total<d.monto_maximo),'si','no') AS editar,
                  IFNULL(e.id,0) AS id_gasto,a.estatus AS estatus_numero, DATE(a.fecha_creacion) fechaCreacion, f.nombre_comp usuarioCapturo
                          FROM requisiciones a
                          LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                          LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                          LEFT JOIN cat_autorizaciones d ON d.id_usuario = $idUsuario AND d.activo=1
                          LEFT JOIN gastos e ON a.id=e.id_requisicion
                          INNER JOIN usuarios f ON f.id_usuario = a.id_capturo
                          WHERE a.presupuesto_aprobado=1 $condicionSucursal AND a.estatus<=2 AND (a.id_orden_compra='' OR ISNULL(a.id_orden_compra) OR a.id_orden_compra=0) $condFecha
                          $condicionPermisosTipos
                          ORDER BY a.folio DESC";
      
        // echo $query;
        // exit();

        // error_log($query);
        // print_r([$query]);
        // exit();
        
        $resultado = $this->link->query($query);
        return query2json($resultado);

      }//- fin function buscarAutorizar
    
      /**
      * Busca todas las requis que fueron rechazadas=3 o canceladas=7 para poder reactivarlas
      *  -- MGFS 06-02-2020 SE CAMBIA AND a.id_unidad_negocio IN ($idsUnidades) POR $condicionSucursal
      **/
      function buscarRequisReactivar($idsUnidades,$idUsuario,$idsSucursales)
      {

        // cambiando
        if($idsSucursales!=''){

          if (strpos($idsSucursales, ',') !== false) 
          {
            
            $dato=substr(trim($idsSucursales),1);
            $dato = rtrim($idsSucursales, ',');
            $dato = ltrim($idsSucursales, ',');

            $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
          }else{
            $condicionSucursal=' AND a.id_sucursal ='.$idsSucursales;
          }
    
        }else{
          
          $condicionSucursal=' AND a.id_sucursal =0';
        }
  
        $resultado = $this->link->query("SELECT a.id,a.folio,a.descripcion,a.total,a.fecha_pedido,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar',IF(a.estatus=6,'Pagada','Cancelada')))))) AS estatus,b.nombre AS unidad_negocio,c.clave AS clave_suc,c.descripcion AS sucursal,
        IF((a.total>d.monto_minimo OR a.total=d.monto_minimo) AND (a.total=d.monto_maximo OR a.total<d.monto_maximo),'si','no') AS editar
                FROM requisiciones a
                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                LEFT JOIN cat_autorizaciones d ON d.id_usuario=".$idUsuario." AND d.activo=1
                WHERE a.presupuesto_aprobado=1 AND a.estatus IN (3,7) $condicionSucursal AND  a.fecha_pedido >= DATE_SUB(CURDATE() , INTERVAL 60 DAY)");
        return query2json($resultado);

      }//- fin function buscarRequisReactivar

      /**
      * Busca todas las requis de mantenimiento que fueron rechazadas=3 o canceladas=7 para poder reactivarlas
      * se quita el filtro de  a.presupuesto_aprobado=2  ya que se contradice 
      * -- MGFS 06-02-2020 SE CAMBIA AND a.id_unidad_negocio IN ($idsUnidades) POR $condicionSucursal
      **/
      function buscarRequisPresupuestoReactivar($idsUnidades,$idUsuario,$idsSucursales){
        
        if($idsSucursales!=''){

          if (strpos($idsSucursales, ',') !== false) {
            
            $dato=substr(trim($idsSucursales),1);
            $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
          }else{
            $condicionSucursal=' AND a.id_sucursal ='.$idsSucursales;
          }
    
        }else{
          
          $condicionSucursal=' AND a.id_sucursal =0';
        }
  
        $resultado = $this->link->query("SELECT a.id,a.folio,a.descripcion,a.total,a.fecha_pedido,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar',IF(a.estatus=6,'Pagada','Cancelada')))))) AS estatusRequi,b.nombre AS unidad_negocio,c.clave AS clave_suc,c.descripcion AS sucursal,
        IF((a.total>d.monto_minimo OR a.total=d.monto_minimo) AND (a.total=d.monto_maximo OR a.total<d.monto_maximo),'si','no') AS editar,if(a.presupuesto_aprobado=0,'Pendiente',if(a.presupuesto_aprobado=1,'Aprobado','Rechazado')) as estatus
                FROM requisiciones a
                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                LEFT JOIN cat_autorizaciones d ON d.id_usuario=".$idUsuario." AND d.activo=1
                WHERE a.presupuesto_aprobado=2 $condicionSucursal AND  a.fecha_pedido >= DATE_SUB(CURDATE() , INTERVAL 60 DAY)");
        return query2json($resultado);

      }//- fin function buscarRequisReactivar

      /**
      * Busca una requis que fue rechazadas o canceladas para poder reactivarla
      *
      **/
      function buscarRequisReactivarId($idRequisicion){
      
        $resultado = $this->link->query("SELECT a.id,a.folio,a.descripcion,a.total,a.fecha_pedido,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar',IF(a.estatus=6,'Pagada','Cancelada')))))) AS estatus, a.total AS costo, IFNULL(a.solicito,'')AS solicito, e.des_dep AS departamento
        FROM requisiciones a
        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
        LEFT JOIN cat_autorizaciones d ON d.id_usuario=1 AND d.activo=1
        LEFT JOIN deptos e ON a.id_departamento=e.id_depto
        WHERE a.id=".$idRequisicion);
        return query2json($resultado);

      }//- fin function buscarRequisReactivarId

    /**
      * Manda llamar a la funcion que actualiza el estatus de una requi
      * 
      * @param int $id es el id de a requisision a actualizar
      * @param int $estatus 1 = Pendiente, 2 = Autorizadar, 3 = NO autorizada, 4 = Orden de compra, 5 = Por Pagar, 6 =  Pagada
      *
      **/      
    function guardarAutorizar($id,$estatus){
    
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      //--> NJES Jan/28/2020 si se autoriza la requi se buscan sus datos para ver si requiere anticipo 
      //y generar el cxp por el cargo del monto anticipo
      if($estatus == 2)
      {

        $busca = "SELECT id,folio,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_proveedor,b_anticipo,monto_anticipo
        FROM requisiciones 
        WHERE id=".$id;
        $result_busca = mysqli_query($this->link, $busca) or die(mysqli_error());
        $row = mysqli_fetch_array($result_busca);

        $b_anticipo = $row['b_anticipo'];

        $idUnidadNegocio = $row['id_unidad_negocio'];
        $idSucursal = $row['id_sucursal'];
        $idArea = $row['id_area'];
        $idDepartamento = $row['id_departamento'];
        $idProveedor = $row['id_proveedor'];
        $monto_anticipo = $row['monto_anticipo'];
        //-->NJES April/24/2020 concatenar el folio de la requi y no el id
        $folioR = $row['folio'];

        $idConcepto = 8;
        $claveConcepto = 'C01';
        $referencia = 'AR-'.$folioR;
        $estatusX = 'P';
        $concepto = 'Anticipo Requisición';

        if($b_anticipo == 1) //--> Si requiere anticipo, genera cxp y actaliza estatus de la requisición
        {

          //--- se genera el cargo inicial en cxp del anticipo de la requi ya que fue aprobado
          $queryI = "INSERT INTO cxp(id_proveedor,no_factura,id_concepto,clave_concepto,fecha,subtotal,iva,referencia,id_unidad_negocio,id_sucursal,estatus,id_area,id_departamento,concepto,id_requisicion) 
                    VALUES ('$idProveedor','0','$idConcepto','$claveConcepto',CURDATE(),'$monto_anticipo','0','$referencia','$idUnidadNegocio','$idSucursal','$estatusX','$idArea','$idDepartamento','$concepto','$id')";
          $resultI = mysqli_query($this->link, $queryI) or die(mysqli_error());
          $idCXP = mysqli_insert_id($this->link);

          // se actualiza el registro generado para asiganarle el id_cxp para que sea el cargo inicial 
          //ya que es como internamente lo reconocemos id=id_cxp
          $actualiza = "UPDATE cxp SET id_cxp=$idCXP WHERE id=".$idCXP; 
          $result2 = mysqli_query($this->link, $actualiza) or die(mysqli_error());
          if($result2)
          {

            //-->NJES July/24/2020 se genera bitacora al autorizar o rechazar una requisición cada vez
            $datos = array('idRequisicion'=>$id,
                            'estatus'=>$estatus,
                            'idUsuario'=>$_SESSION['id_usuario']);

            $query = "UPDATE requisiciones SET estatus=".$estatus." WHERE id=".$id;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if($result)
              $verifica = $this->guardaBitacoraAutorizaRechazaRequi($datos);
            
          }
          else
            $verifica = 0;

        }
        else
        { //--> No requiere anticipo y solo acualiza estatus de la requisición

          //-->NJES July/24/2020 se genera bitacora al autorizar o rechazar una requisición cada vez
          $datos = array('idRequisicion'=>$id,
                          'estatus'=>$estatus,
                          'idUsuario'=>$_SESSION['id_usuario']);

          $query = "UPDATE requisiciones SET estatus=".$estatus." WHERE id=".$id;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());

          if($result)
          {

            if($this->guardarOrdenServicio($id))
              $verifica = $this->guardaBitacoraAutorizaRechazaRequi($datos);
            
          }

        }
      }
      else
      {

        $busca = "SELECT id FROM cxp WHERE id_requisicion=$id AND estatus!='C'";
        $result_busca = mysqli_query($this->link, $busca) or die(mysqli_error());
        $num = mysqli_num_rows($result_busca);
        if($num > 0)
        {

          $row = mysqli_fetch_array($result_busca);
          $idCXP = $row['id'];

          $actualiza = "UPDATE cxp SET estatus='C' WHERE id=".$idCXP; 
          $result2 = mysqli_query($this->link, $actualiza) or die(mysqli_error());
          if($result2)
          {
            //-->NJES July/24/2020 se genera bitacora al autorizar o rechazar una requisición cada vez
            $datos = array('idRequisicion'=>$id,
                          'estatus'=>$estatus,
                          'idUsuario'=>$_SESSION['id_usuario']);

            $query = "UPDATE requisiciones SET estatus=".$estatus." WHERE id=".$id;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if($result)
              $verifica = $this->guardaBitacoraAutorizaRechazaRequi($datos);

          }
          else
            $verifica = 0;

        }
        else
        {
          //-->NJES July/24/2020 se genera bitacora al autorizar o rechazar una requisición cada vez
          $datos = array('idRequisicion'=>$id,
                          'estatus'=>$estatus,
                          'idUsuario'=>$_SESSION['id_usuario']);

          $query = "UPDATE requisiciones SET estatus=".$estatus." WHERE id=".$id;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());

          if($result)
            $verifica = $this->guardaBitacoraAutorizaRechazaRequi($datos);

        }

      }

     if($verifica > 0)
        $this->link->query("commit;");
     else
          $this->link->query('rollback;');

      return $verifica;

  } //-- fin function guardarAutorizar

  function guardarOrdenServicio($idRequisicion)
  {

    $verifica = false;

    $resultRequi = mysqli_query($this->link, "SELECT id_unidad_negocio, id_sucursal, id_area, id_departamento, folio, id_proveedor, fecha_pedido,
                subtotal, iva, total, tipo FROM requisiciones
                WHERE id = $idRequisicion");
    $rRequi = mysqli_fetch_assoc($resultRequi);

    $idUnidadNegocio = $rRequi['id_unidad_negocio'];
    $idSucursal = $rRequi['id_sucursal'];
    $idArea = $rRequi['id_area'];
    $idDepartamento = $rRequi['id_departamento'];
    $folio = $rRequi['folio'];
    $idProveedor = $rRequi['id_proveedor'];
    $fechaPedido = $rRequi['fecha_pedido'];
    $subtotal = $rRequi['subtotal'];
    $iva = $rRequi['iva'];
    $total = $rRequi['total'];
    $tipo = $rRequi['tipo'];


    if($tipo == 4)
    {


      $folios = $this->foliosOrdenServicio($idUnidadNegocio);
      $folioOC = $folios[0];
      $folioEA = $folios[1];


      $queryOC = "INSERT INTO orden_compra
      (folio, tipo, fecha_captura,requisiciones, ids_requisiciones, id_unidad_negocio, id_sucursal, id_area, id_departamento, id_proveedor)
      VALUES
      ($folioOC, 4, '$fechaPedido', '$folio', '$idRequisicion', $idUnidadNegocio, $idSucursal, $idArea, $idDepartamento, $idProveedor)";
      
      $resultOC = mysqli_query($this->link, $queryOC) or die(mysqli_error());

      if($resultOC)
      {

        $idOC = mysqli_insert_id($this->link);

        $queryEA = "INSERT INTO  almacen_e (folio, id_compania,id_sucursal, fecha, id_proveedor, id_unidad_negocio, id_oc, id_departamento,id_area, tipo_oc, cve_concepto)
        VALUES ($folioEA, $idSucursal, $idSucursal, '$fechaPedido', $idProveedor, $idUnidadNegocio, $idOC, $idDepartamento, $idArea, 4, '')";

         $resultEA = mysqli_query($this->link, $queryEA) or die(mysqli_error());

        if($resultEA)
        {

          $idEA = mysqli_insert_id($this->link);
          $resultDeta = mysqli_query($this->link, "INSERT INTO almacen_d (id_almacen_e, id_producto, cantidad, precio, id_oc, cve_concepto) VALUES
            ($idEA, 0, 1, $subtotal, $idOC, '')") or die(mysqli_error());
          if(mysqli_query($this->link, "UPDATE requisiciones SET id_orden_compra= $idOC, folio_orden_compra = $folioEA  WHERE id = $idRequisicion") or die(mysqli_error()))
            $verifica = true;

        }

      }

    }
    else
      $verifica = true;
    

    return $verifica;

  }

  function foliosOrdenServicio($idUnidadNegocio)
  {

    $verifica = false;

    $query = "SELECT folio_oc, folio_entrada_almacen FROM cat_unidades_negocio WHERE id = $idUnidadNegocio";
    $result = mysqli_query($this->link, $query) or die(mysqli_error());

    if($result)
    {

      $r = mysqli_fetch_array($result);
      $folioOC   = $r['folio_oc'] + 1;
      $folioEA   = $r['folio_entrada_almacen'] + 1;

      if(mysqli_query($this->link, "UPDATE cat_unidades_negocio SET folio_oc= $folioOC, folio_entrada_almacen = $folioEA  WHERE id = $idUnidadNegocio") or die(mysqli_error()))
      {

        $verifica[0] = $folioOC;
        $verifica[1] = $folioEA;

      }

    }

    return $verifica;

  }

  /** 
   * @param int $idRequisicion busca en cxp
  **/
  function buscaNumeroAbonosCxpRequisicion($idRequisicion){
    $verifica = 0;

    $busca = "SELECT id FROM cxp WHERE id_requisicion=".$idRequisicion." AND estatus!='C'";
    $result_busca = mysqli_query($this->link, $busca) or die(mysqli_error());
    $num = mysqli_num_rows($result_busca);
    if($num > 0)
    {
      $row = mysqli_fetch_array($result_busca);
      $id = $row['id'];

      $query = "SELECT COUNT(id) AS abonos FROM cxp WHERE id_cxp=".$id." AND id!=id_cxp AND estatus!='C'";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      $rowX = mysqli_fetch_array($result);
      $abonos = $rowX['abonos'];

      $verifica = $abonos;
    }

    return $verifica;
  }//-- fin function buscaNumeroAbonosCxpRequisicion

  /**
  * Busca los datos de una autorizacion, retorna un JSON con los datos correspondientes
  * 
  * @param int $activo indica el estatus 1=pendiente 2=aprobada 
  *
  **/
  function buscarPendientesAutorizar($idsUnidades,$idUsuario,$idsSucursales)
  {
    if($idsSucursales!=''){

      if (strpos($idsSucursales, ',') !== false) {
        
        $dato=substr(trim($idsSucursales),1);
        $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
      }else{
        $condicionSucursal=' AND a.id_sucursal ='.$idsSucursales;
      }

    }else{
      
      $condicionSucursal=' AND a.id_sucursal =0';
    }

    $resultado = $this->link->query("SELECT a.id,a.folio,a.descripcion,a.total,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar',IF(a.estatus=6,'Pagada','Cancelada')))))) AS estatus,
    IF(a.tipo=0,'ACTIVOS FIJOS',IF(a.tipo=1,'GASTOS',IF(a.tipo=2,'MANTENIMIENTO',IF(a.tipo = 3,'STOCK', 'ORDEN DE SERVICIO'))))AS tipo,b.nombre AS unidad_negocio,c.clave AS clave_suc,c.descripcion AS sucursal,
    IF((a.total>d.monto_minimo OR a.total=d.monto_minimo) AND (a.total=d.monto_maximo OR a.total<d.monto_maximo),'si','no') AS editar,
    IFNULL(e.id,0) AS id_gasto    
            FROM requisiciones a
            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
            LEFT JOIN cat_autorizaciones d ON d.id_usuario = $idUsuario AND d.activo=1
            LEFT JOIN gastos e ON a.id=e.id_requisicion
            WHERE a.presupuesto_aprobado=1 $condicionSucursal AND a.estatus=1 AND (a.id_orden_compra='' OR ISNULL(a.id_orden_compra) OR a.id_orden_compra=0)
            HAVING id_gasto=0");
    return query2json($resultado);

  }//- fin function buscarPendientesAutorizar


  /**
      * Busca los datos de una autorizacion, retorna un JSON con los datos correspondientes
      * 
      * @param int $activo indica el estatus 1=pendiente 2=aprobada 
      *
      **/
      function buscarRechazadasPresupuesto($idsUnidades,$idUsuario,$idsSucursales)
      {
        if($idsSucursales!=''){

          if (strpos($idsSucursales, ',') !== false) {
            
            $dato=substr(trim($idsSucursales),1);
            $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
          }else{
            $condicionSucursal=' AND a.id_sucursal ='.$idsSucursales;
          }
    
        }else{
          
          $condicionSucursal=' AND a.id_sucursal =0';
        }
  
        $resultado = $this->link->query("SELECT a.id,a.folio,a.descripcion,a.total,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar',IF(a.estatus=6,'Pagada','Cancelada')))))) AS estatus,
        IF(a.tipo=0,'ACTIVOS FIJOS',IF(a.tipo=1,'GASTOS',IF(a.tipo=2,'MANTENIMIENTO',IF(a.tipo = 3,'STOCK', 'ORDEN DE SERVICIO'))))AS tipo,b.nombre AS unidad_negocio,c.clave AS clave_suc,c.descripcion AS sucursal,
        IF((a.total>d.monto_minimo OR a.total=d.monto_minimo) AND (a.total=d.monto_maximo OR a.total<d.monto_maximo),'si','no') AS editar
                FROM requisiciones a
                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                LEFT JOIN cat_autorizaciones d ON d.id_usuario = $idUsuario AND d.activo=1
                WHERE a.presupuesto_aprobado=2 $condicionSucursal
                ORDER BY a.fecha_presupuesto DESC");
        return query2json($resultado);

      }//- fin function buscarRechazadasPresupuesto($idsUnidades,$idUsuario)



  /**
  * Obtiene las sucursales a las que se puede aceder de una unidad de negocio un usuario especifico
  *
  * @param int $idUnidadNegocio dato que dice en que unidad de negocio se encuentra actialmente
  * @param varchar $modulo solo para indicar de modulo se quiere obtener el permiso
  * @param int $idUsuario usuario logueado actualmente
  *
  **/
  function buscarPermisosAutorizacionTipo($idUsuario,$tipo,$boton,$idsSucursales){

    if($idsSucursales!=''){

      if (strpos($idsSucursales, ',') !== false) {
        
        $dato=substr(trim($idsSucursales),1);
        $condicionSucursal=' a.id_sucursal in ('.$dato.')';
      }else{
        $condicionSucursal=' a.id_sucursal ='.$idsSucursales;
      }

    }else{
      
      $condicionSucursal=' a.id_sucursal =0';
    }
    $verifica = '';

    $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$boton' ORDER BY orden";
    $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
    $num = mysqli_num_rows($resultM);

    if($num > 0){

      $rowsM = $resultM->fetch_assoc();
      $pantallaM=$rowsM['sistema'];
      $permisoForma=$rowsM['comando'];

      /*$queryP = "SELECT 
      a.id,
      IFNULL(b.permiso,0)AS permiso 
    FROM cat_unidades_negocio a	
    LEFT JOIN  permisos b ON a.id=b.id_unidad_negocio AND b.id_usuario=$idUsuario AND b.pantalla = '$pantallaM'
    WHERE a.id IN ($idUnidadadesNegocio) 
    GROUP BY a.id";  */   
      $queryP = "SELECT 
      a.id_sucursal,
      IFNULL(b.permiso,0)AS permiso 
    FROM sucursales a	
    LEFT JOIN  permisos b ON a.id_sucursal=b.id_sucursal AND b.id_usuario=$idUsuario AND b.pantalla = 'AUTORIZAR_REQUISICIONES'
    WHERE $condicionSucursal 
    GROUP BY a.id_sucursal";     
                      
      $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
      $numP = mysqli_num_rows($resultP);

      if($numP > 0){

        $cont=0;
        while($row = $resultP->fetch_assoc()){

          $permisoUsuario=$row['permiso'];
          $idSucursal = $row['id_sucursal'];
          //$idUnidad=$row['id'];
          
          if($this -> checaBit($permisoForma,$permisoUsuario)){
              $verifica .= " OR (a.id_sucursal=$idSucursal AND a.tipo=$tipo)";
          }else{
              $verifica .= '';
          }
        
        }
        
      }else{
        
          $verifica = '';
      }

    }else{
      
      $verifica = '';
    }

    return $verifica;
  }//-- fin function buscarPermisosBotonArchivosCarpeta

  /**
  * Obtiene la comparacion binaria para saber si tiene permiso o no a un modulo
  *
  * @param int $permiso_forma es el permiso que se encuentra en la tabla de menus (comando) del modulo ingresado o (sistema)
  * @param int $permiso_usuario es el permiso que tiene un usuario en la tabla de permisos sobre una pantalla especifica (modulo->sistema)
  *
  **/
  function checaBit($permiso_forma,$permiso_usuario)
  { 
    if(((int)$permiso_forma & (int)$permiso_usuario)==0)
      return 0;
    else 
      return 1;
  }

  function guardaBitacoraAutorizaRechazaRequi($datos){
    $verifica = 0;

    $idRequisicion = $datos['idRequisicion'];
    $estatus = $datos['estatus'];
    $idUsuario = $datos['idUsuario'];

    $query = "INSERT INTO requisiciones_autorizar_bitacora(id_requisicion,estatus,id_usuario) 
      VALUES ('$idRequisicion','$estatus','$idUsuario')";
    $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
    if($result)
      $verifica = 1;
    else
      $verifica = 0;

    return $verifica;
  }

    
}//--fin de class Autorizar
    
?>