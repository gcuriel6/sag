<?php

include_once('conectar.php');
include_once('Autorizar.php');

class Requisiciones
{

    public $link;

    function Requisiciones()
    {

      $this->link = Conectarse();

    }
    /**
    * Funcion  que se usa al importar una requi en ordenes de compra
    * solo muestra las requis de una unidade de negocio y sucursal actual 
    * Trae solo las requis autorizadas (estatus=2)
    * requisicionesImportarbuscarRequisicionesImportar
    * @param int $idUnidad unidad de negocio selecionada en la orden de compra
    * @param int $idSucursal sucursal selecionada en la orden de compra
    * 0=activo fijo 1=gasto 2=Mantenimeinto 3=stock
    **/
    function buscarRequisicionesImportar($idUnidad, $idSucursal, $idProveedor, $tipo)
    {
      $condicionProveedor = '';
      if($idProveedor > 0){
        $condicionProveedor = "AND requisiciones.id_proveedor=".$idProveedor;
      }
      $resultado = $this->link->query("
      SELECT 
      requisiciones.id,
      requisiciones.folio,
      requisiciones.descripcion,
      requisiciones.id_area,
      requisiciones.id_departamento,
      requisiciones.id_proveedor,
      requisiciones.tipo AS tipo,
      IF(requisiciones.tipo=0,'ACTIVO FIJO',IF(requisiciones.tipo=1,'GASTO',IF(requisiciones.tipo=2,'MANTENIMIENTO','STOCK'))) AS tipo_requi,
      IFNULL(requisiciones.no_economico,'') AS no_economico,
      'Autorizada' AS estatus,
      FORMAT(requisiciones.total,2) AS total,
      cat_unidades_negocio.nombre AS unidad,
      sucursales.clave AS clave_suc,
      sucursales.descr AS sucursal,
      TRIM(proveedores.nombre) AS proveedor,
      proveedores.aprobado,
      proveedores.rechazado,
      cat_areas.descripcion AS area_r,
      IFNULL(deptos.des_dep,'') AS departamento,
      requisiciones.total AS importe_total,
      requisiciones.subtotal,
      requisiciones.iva,
      requisiciones.descuento,
      MAX(requisiciones_d.iva) AS iva_m
      FROM requisiciones
      LEFT JOIN cat_unidades_negocio ON requisiciones.id_unidad_negocio=cat_unidades_negocio.id
      LEFT JOIN sucursales ON requisiciones.id_sucursal=sucursales.id_sucursal 
      LEFT JOIN proveedores  ON requisiciones.id_proveedor=proveedores.id
      LEFT JOIN cat_areas ON requisiciones.id_area = cat_areas.id
      LEFT JOIN deptos ON requisiciones.id_departamento = deptos.id_depto AND deptos.tipo='I'
      INNER JOIN requisiciones_d ON requisiciones.id=requisiciones_d.id_requisicion
      WHERE requisiciones.estatus=2 AND requisiciones.id_orden_compra=0 AND requisiciones.id_unidad_negocio=".$idUnidad." AND requisiciones.id_sucursal=".$idSucursal." AND requisiciones.tipo = $tipo $condicionProveedor
      GROUP BY requisiciones.id
      ORDER BY requisiciones.id DESC");
      return query2json($resultado);

    }

   /**
    * Funcion  que se usa al importar una requi en ordenes de compra
    * Trae el detalle de una requi especifica
    *
    * @param int $idRequisicion id de la requisicion selecionada en la orden de compra
    *
    **/
    function buscarRequisicionDetalle($idRequisicion)
    {
      $resultado = $this->link->query("
              SELECT 
                requisiciones_d.id,       
                requisiciones_d.id_producto,
                requisiciones_d.id_linea,
                requisiciones_d.id_familia,
                requisiciones_d.descripcion,
                requisiciones_d.cantidad,
                requisiciones_d.costo_unitario as costo,
                (requisiciones_d.cantidad*requisiciones_d.costo_unitario)AS importe,
                productos.clave,
                productos.concepto,
                0 AS descuento,
                requisiciones_d.iva AS iva,
                lineas.descripcion AS linea,
                familias.descripcion AS familia,
                familias.tallas AS verifica_talla
              FROM requisiciones_d 
              LEFT JOIN productos ON requisiciones_d.id_producto=productos.id
              LEFT JOIN lineas ON requisiciones_d.id_linea=lineas.id
              LEFT JOIN familias ON requisiciones_d.id_familia=familias.id
              WHERE requisiciones_d.id_requisicion=".$idRequisicion."
              ORDER BY requisiciones_d.id desc");
      return query2json($resultado);

    }

    function buscarRequisicionUsadas($idsRequisiciones)
    {
      $datos='';
     
      $resultado = $this->link->query("SELECT CONCAT(id,'-',folio_orden_compra,'<br>') AS usada FROM requisiciones WHERE id IN($idsRequisiciones) AND folio_orden_compra>0
      ORDER BY id desc");
      $numRows=mysqli_num_rows($resultado);
      if($numRows>0){
        while($dato=mysqli_fetch_array($resultado)){
          $datos.=$dato['usada'];
        }
        
      }
      
      return $datos;
    }

    /**
      * Guarda las requisiciones
      *
      * @param array $requisicionA
      * @param array $requisicionD
      *
      **/
    function guardarRequisicion($requisicionA, $requisicionD)
    {

      $verifica = 0;

      $idUnidad = $requisicionA['id_unidad'];
      $idSucursal = $requisicionA['id_sucursal'];
      $idArea = $requisicionA['id_area'];
      $idDepto = $requisicionA['id_depto'];
      $idProveedor = $requisicionA['id_proveedor'];
      $fechaPedido = $requisicionA['fecha_pedido'];
      $solicito = $requisicionA['solicito'];
      $diasEntrega = ($requisicionA['dias_entrega'] == '' ? 0 : $requisicionA['dias_entrega']);
      $idUsuario = $requisicionA['id_usuario'];
      $usuario = $requisicionA['usuario'];
      $descripcion = $requisicionA['descripcion'];
      $tipo = $requisicionA['tipo'];

      //-->NJES Jan/17/2020 guardar el id_familia_gasto en requisiciones
      $idFamiliaGasto = $requisicionA['id_familia_gasto'];

      //-->NJES Jan/27/2020 se agregan parametros para anticipo de la requisición
      $anticipo = $requisicionA['anticipo'];
      $montoAnticipo = $requisicionA['monto_anticipo'];

      //-->NJES March/11/2020 guardar el id del activo fijo vehiculo para requisiciones mantenimiento
      $idActivo = $requisicionA['id_activo_fijo'];

      //-->NJES July/30/2020 bandera si es diferentes familias gastos
      $diferentesFamilias = $requisicionA['diferentesFamilias'];

      $subtotal = $requisicionA['subtotal'];
      $iva = $requisicionA['iva'];
      $total = $requisicionA['total'];
      $excedePresupuesto = $requisicionA['excedePresupuesto'];
      /** si la requi no excede ningu presupuesto ($excedePresupuesto=0) por defaulto se valida el presupuesto ($presupuestoAprobado=1)) */
      $presupuestoAprobado=1;
      if($excedePresupuesto==1){
        $presupuestoAprobado=0;
      }

      $fechaCreacion = date("Y-m-d") . ' ' . date('H:i:s');
      $folio = $this->obtenerFolio($idUnidad) + 1;
      /**MGFS 05-11-2019   SE AGREGAN CAMPOS PARA REQUISICIONES DE MANTENIMIENTO */
      $mantenimiento = ($requisicionA['mantenimiento'] == '' ? 0 : $requisicionA['mantenimiento']);
      $noEconomico  = ($requisicionA['noEconomico'] == '' ? '' : $requisicionA['noEconomico']);
      $responsable  = ($requisicionA['responsable'] == '' ? '' : $requisicionA['responsable']);
      $kilometraje  = ($requisicionA['kilometraje'] == '' ? 0 : $requisicionA['kilometraje']);

      $descuento  = ($requisicionA['descuento'] == '' ? 0 : $requisicionA['descuento']);

      if($mantenimiento==1){
        $folioMantenimiento = $this->obtenerFolioMantenimiento($idUnidad) + 1;
      }else{
        $folioMantenimiento = 0;
      }
     

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $query = "INSERT INTO requisiciones 
            (id_unidad_negocio, id_sucursal, id_area, id_departamento, folio, solicito, capturo, id_capturo, id_proveedor, fecha_pedido, tiempo_entrega, descripcion, fecha_creacion, estatus, tipo, subtotal,iva, total, excede_presupuesto, presupuesto_aprobado, folio_mantenimiento, no_economico, responsable, kilometraje,id_familia_gasto,b_anticipo,monto_anticipo,id_activo_fijo,b_varias_familias,descuento)
            VALUES($idUnidad, $idSucursal, $idArea, $idDepto, $folio, '$solicito', '$usuario', $idUsuario,
            $idProveedor, '$fechaPedido', $diasEntrega, '$descripcion', '$fechaCreacion', 1, $tipo, $subtotal, $iva, $total, '$excedePresupuesto', '$presupuestoAprobado','$folioMantenimiento', '$noEconomico','$responsable','$kilometraje','$idFamiliaGasto','$anticipo','$montoAnticipo','$idActivo','$diferentesFamilias','$descuento')";

        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
        {

          $idRequisicion = mysqli_insert_id($this->link);

          $this->actualizarFolio($idUnidad, $folio);
          if($mantenimiento==1){
            $this->actualizarFolioMantenimiento($idUnidad, $folioMantenimiento);
          }
          if($this->guardarDetalles($idRequisicion, $requisicionD))
            $verifica = $folio;

        }

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        //return json_encode(array('id'=>$idRequisicion, 'folio'=>$folio));
        return $verifica;

    }

    /**
      * Editar las requisiciones
      *
      * @param array $requisicionA
      * @param array $requisicionD
      *
      **/
    function modificarRequisicion($requisicionA, $requisicionD)
    {

      $verifica = 0;

      $idRequisicion = $requisicionA['id'];
      $folio = $requisicionA['folio'];
      $idProveedor = $requisicionA['id_proveedor'];
      $fechaPedido = $requisicionA['fecha_pedido'];
      $solicito = $requisicionA['solicito'];
      $diasEntrega = ($requisicionA['dias_entrega'] == '' ? 0 : $requisicionA['dias_entrega']);
      $descripcion = $requisicionA['descripcion'];
      $tipo = $requisicionA['tipo'];

      $subtotal = $requisicionA['subtotal'];
      $iva = $requisicionA['iva'];
      $total = $requisicionA['total'];
      $excedePresupuesto = $requisicionA['excedePresupuesto'];
      /** si la requi no excede ningu presupuesto ($excedePresupuesto=0) por defaulto se valida el presupuesto ($presupuestoAprobado=1)) */
      $presupuestoAprobado=1;
      if($excedePresupuesto==1){
        $presupuestoAprobado=0;
      }

      //-->NJES Jan/17/2020 guardar el id_familia_gasto en requisiciones
      $idFamiliaGasto = $requisicionA['id_familia_gasto'];

      //-->NJES Jan/27/2020 se agregan parametros para anticipo de la requisición
      $anticipo = $requisicionA['anticipo'];
      $montoAnticipo = $requisicionA['monto_anticipo'];

      //-->NJES March/11/2020 guardar el id del activo fijo vehiculo para requisiciones mantenimiento
      $idActivo = $requisicionA['id_activo_fijo'];

      //-->NJES July/30/2020 bandera si es diferentes familias gastos
      $diferentesFamilias = $requisicionA['diferentesFamilias'];

       /**MGFS 05-11-2019   SE AGREGAN CAMPOS PARA REQUISICIONES DE MANTENIMIENTO */
       $mantenimiento = ($requisicionA['mantenimiento'] == '' ? 0 : $requisicionA['mantenimiento']);
       $noEconomico  = ($requisicionA['noEconomico'] == '' ? '' : $requisicionA['noEconomico']);
       $responsable  = ($requisicionA['responsable'] == '' ? '' : $requisicionA['responsable']);
       $kilometraje  = ($requisicionA['kilometraje'] == '' ? 0 : $requisicionA['kilometraje']);

      $descuento  = ($requisicionA['descuento'] == '' ? 0 : $requisicionA['descuento']);

      $estatusActualR = $requisicionA['estatusActualR'];


      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      //-->NJES February/03/2021 si la requisicion es pendiente y se actualiza, 
      //se debe actualizar la fecha de pedidio con la fecha en que se esta actualizando
      if($estatusActualR == 1)
        {
          $query = "UPDATE requisiciones SET tipo = $tipo,
            solicito = '$solicito', id_proveedor = $idProveedor, fecha_pedido = CURDATE(), 
            tiempo_entrega = $diasEntrega, descripcion = '$descripcion', subtotal = $subtotal, 
            iva = $iva, total = $total , excede_presupuesto = '$excedePresupuesto', 
            presupuesto_aprobado = '$presupuestoAprobado', no_economico = '$noEconomico', 
            responsable = '$responsable', kilometraje = '$kilometraje', id_familia_gasto='$idFamiliaGasto',
            b_anticipo='$anticipo',monto_anticipo='$montoAnticipo',id_activo_fijo='$idActivo',
            b_varias_familias='$diferentesFamilias',descuento='$descuento' 
            WHERE id = $idRequisicion";
        }else{
          $query = "UPDATE requisiciones SET tipo = $tipo,
            solicito = '$solicito', id_proveedor = $idProveedor, fecha_pedido = '$fechaPedido', 
            tiempo_entrega = $diasEntrega, descripcion = '$descripcion', subtotal = $subtotal, 
            iva = $iva, total = $total , excede_presupuesto = '$excedePresupuesto', 
            presupuesto_aprobado = '$presupuestoAprobado', no_economico = '$noEconomico', 
            responsable = '$responsable', kilometraje = '$kilometraje', id_familia_gasto='$idFamiliaGasto',
            b_anticipo='$anticipo',monto_anticipo='$montoAnticipo',id_activo_fijo='$idActivo',
            b_varias_familias='$diferentesFamilias',descuento='$descuento' 
            WHERE id = $idRequisicion";
        }
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if($result)
        {

          $this->eliminarDetalles($idRequisicion);
          if($this->guardarDetalles($idRequisicion, $requisicionD) == true)
            $verifica = $folio;

        }
        
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        //return json_encode(array('id'=>$idRequisicion, 'folio'=>$folio));
       return $verifica;

    }       

    /**
      * Obtiene el folio actual de las requisiciones
      *
      * @param int $idUnidad
      *
      **/ 
    function obtenerFolio($idUnidad)
    {

      $result = mysqli_query($this->link, "SELECT folio_requisicion FROM cat_unidades_negocio WHERE id = $idUnidad");
      $row = mysqli_fetch_assoc($result);
      return $row['folio_requisicion'];
    }


    /**
      * Actualiza el folio actual de las requisiciones
      *
      * @param int $idUnidad
      * @param int $folio
      *
      **/
    function actualizarFolio($idUnidad, $folio)
    {
      $result = mysqli_query($this->link, "UPDATE cat_unidades_negocio SET folio_requisicion = $folio WHERE id = $idUnidad");
    }

    /**
      * Guardar los detalles de la requisiciones, esta función es usada para guardar y para editar
      *
      * @param array $requisicionA
      * @param array $requisicionD
      *
      **/
    function guardarDetalles($idRequisicion, $requisicionD)
    {

      $verifica = false;

      $num_partida=0;

      foreach($requisicionD as $detalle)
      {

        // print_r($detalle);
        // continue;

          $num_partida++;
          $nPartida = $detalle['n_partida'];
          $idProducto = $detalle['id_producto'];
          $concepto = $detalle['concepto'];
          $idFamilia = $detalle['id_familia'];
          $familia = $detalle['familia'];
          $idLinea = $detalle['id_linea'];
          $linea = $detalle['linea'];
          $precio = $detalle['precio'];
          $cantidad = $detalle['cantidad'];
          $costo = $detalle['costo'];
          $descripcion = $detalle['descripcion'];
          $justificacion = $detalle['justificacion'];
          $iva = $detalle['iva'];
          $excedePD = $detalle['excedePD'];
          $tallas = $detalle['tallas'];
          $descuento = $detalle['descuento'];
          $descuento_total = $detalle['descuento_total'];

          $query = " INSERT INTO requisiciones_d (id_requisicion, id_producto, id_linea, id_familia, cantidad, descripcion, costo_unitario, iva, total, justificacion, concepto,num_partida, excede_presupuesto,descuento_unitario,descuento_total) 
            VALUES ($idRequisicion, $idProducto, $idLinea, $idFamilia, $cantidad, '$descripcion', $precio, $iva, $costo,'$justificacion', '$concepto','$num_partida','$excedePD','$descuento','$descuento_total')";

          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idDetalle = mysqli_insert_id($this->link);

          //if($idDetalle > 0)
          if($result)
          {
            if($tallas != '')
            { 

              $tallaArray = json_decode($tallas, true);
              foreach($tallaArray as $tA)
              {

                $tallaD = $tA['talla'];
                $cantidadD = $tA['cantidad'];
                $queryT = "INSERT INTO tallas (tipo, id_detalle, talla, cantidad) VALUES (1, $idDetalle, '$tallaD', $cantidadD)";
                $resultT = mysqli_query($this->link, $queryT) or die(mysqli_error());
                //if(mysqli_num_rows($resultT) > 0)
                if($resultT)
                  $verifica = true;
                else
                {
                  $verifica = false;
                  break;
                }

              }

            }
            else
              $verifica = true;

          }
          else
          {
            
            $verifica = false;
            break;
          }

      }
      // exit();
   
      return $verifica;

    }

    /**
      * Busca todas las requisiciones
      *
      * @param int id
      *  MGFS 16-01-2020 SE AGREGA BUSUQEDA DE ID GASTO RELACIONADO A UNA REQUI DE GASTOS
      **/
    function buscarRequisicionesTodas($mantenimiento,$id, $idUnidad, $idSucursal, $fechaDe, $fechaA)
    {

      $where = " WHERE 1";
      if($mantenimiento >0){
        $where .= " AND requisiciones.folio_mantenimiento >0 ";
      }else{ 
        $where .= " AND requisiciones.folio_mantenimiento =0 ";
      }
      if($id != null)
        $where .= " AND requisiciones.id = $id";

      if($idUnidad != null)
        $where .= " AND cat_unidades_negocio.id = $idUnidad ";

      if($idSucursal != null)
        $where .= " AND sucursales.id_sucursal = $idSucursal ";  

      if ($id == null){
        if($fechaDe == '' && $fechaA == '')
          $where .= " AND requisiciones.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        else if($fechaDe != null &&  $fechaA == null)
          $where .= " AND requisiciones.fecha_pedido >= '$fechaDe' ";
        else  //-->trae fecha inicio y fecha fin
          $where .= " AND requisiciones.fecha_pedido >= '$fechaDe' AND requisiciones.fecha_pedido <= '$fechaA' ";
      }

      $query = "SELECT
                  requisiciones.id AS id,
                  requisiciones.id_unidad_negocio AS id_unidad_negocio,
                  requisiciones.id_sucursal AS id_sucursal,
                  requisiciones.id_area AS id_area,
                  requisiciones.id_departamento AS id_departamento,
                  requisiciones.folio AS folio,
                  requisiciones.estatus AS estatus,
                  requisiciones.presupuesto_aprobado,
                  cat_unidades_negocio.nombre AS unidad, 
                  sucursales.descr AS sucursal,
                  cat_areas.descripcion AS are,
                  IFNULL(deptos.des_dep,'') AS depto,
                  requisiciones.solicito AS solicito,
                  requisiciones.id_proveedor AS id_proveedor,
                  requisiciones.fecha_pedido AS fecha_pedido,
                  requisiciones.tiempo_entrega AS tiempo_entrega,
                  requisiciones.descripcion AS descripcion,
                  requisiciones.id_orden_compra AS id_orden_compra,
                  requisiciones.folio_orden_compra AS folio_orden_compra,
                  requisiciones.subtotal AS subtotal,
                  requisiciones.iva AS iva,
                  requisiciones.total AS total,
                  requisiciones.id_capturo AS id_capturo,
                  requisiciones.tipo AS tipo,
                  requisiciones.descuento,
                  requisiciones.excede_presupuesto AS excede_presupuesto,
                  requisiciones.folio_mantenimiento AS folio_mantenimiento,
                  requisiciones.no_economico AS no_economico,
                  requisiciones.responsable AS responsable,
                  requisiciones.kilometraje AS kilometraje,

                  requisiciones.id_familia_gasto,
                  requisiciones.b_anticipo,
                  requisiciones.monto_anticipo,
                  requisiciones.b_varias_familias,

                  proveedores.nombre as proveedor,
                  usuarios.usuario AS capturo,

                  IFNULL(gastos.id,0) AS id_gasto,
                  IFNULL(gastos.referencia,'') AS referencia_gasto,
                  requisiciones.id_activo_fijo,
                  IFNULL(CONCAT(activos_responsables.id_trabajador,' - ',TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)),'Sin responsable') AS responsable_activo_fijo,
                  MAX(requisiciones_d.iva) AS iva_m
                FROM requisiciones
                INNER JOIN cat_unidades_negocio ON requisiciones.id_unidad_negocio = cat_unidades_negocio.id
                INNER JOIN sucursales ON requisiciones.id_sucursal = sucursales.id_sucursal
                INNER JOIN cat_areas ON requisiciones.id_area = cat_areas.id
                INNER JOIN deptos ON requisiciones.id_departamento = deptos.id_depto AND deptos.tipo='I'
                INNER JOIN proveedores ON requisiciones.id_proveedor = proveedores.id
                LEFT JOIN  usuarios ON requisiciones.id_capturo=usuarios.id_usuario
                LEFT JOIN gastos ON requisiciones.id = gastos.id_requisicion
                LEFT JOIN activos ON requisiciones.id_activo_fijo=activos.id
                LEFT JOIN activos_responsables ON activos.id = activos_responsables.id_activo AND activos_responsables.responsable=1
                LEFT JOIN trabajadores ON activos_responsables.id_trabajador = trabajadores.id_trabajador
                INNER JOIN requisiciones_d ON requisiciones.id=requisiciones_d.id_requisicion
                $where
                GROUP BY requisiciones.id
                ORDER BY requisiciones.id DESC";
       
      //-->NJES March/11/2020 se obtiene el responsable del activo fijo
      $resultado = $this->link->query($query);

      return query2json($resultado);
    }

    function cancelarRequisicion($idRequisicion)
    {

      $verifica = false;

      $busca = "SELECT id FROM cxp WHERE id_requisicion=$idRequisicion AND estatus!='C'";
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
          $query = "UPDATE requisiciones SET estatus = 7 WHERE id = $idRequisicion";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());

          if($result)
            $verifica = true;

        }else
          $verifica = false;

      }else{

        $query = "UPDATE requisiciones SET estatus = 7 WHERE id = $idRequisicion";

        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if($result)
          $verifica = true;
      }

      return $verifica;

    }

    function buscarRequisicionesId($id = null)
    {


      $where = " ";
      if($id != null && $id != '')
        $where = " WHERE requisiciones.id = $id ";

      $query = "SELECT
                  requisiciones.id AS id,
                  requisiciones.id_unidad_negocio AS id_unidad_negocio,
                  requisiciones.id_sucursal AS id_sucursal,
                  requisiciones.id_area AS id_area,
                  IFNULL(requisiciones.id_departamento,0) AS id_departamento,
                  requisiciones.folio AS folio,
                  requisiciones.estatus AS estatus,
                  cat_unidades_negocio.nombre AS unidad, 
                  sucursales.descr AS sucursal,
                  cat_areas.descripcion AS are,
                  IFNULL(deptos.des_dep,'') AS depto,
                  requisiciones.solicito AS solicito,
                  requisiciones.capturo AS capturo,
                  requisiciones.id_proveedor AS id_proveedor,
                  requisiciones.fecha_pedido AS fecha_pedido,
                  requisiciones.tiempo_entrega AS tiempo_entrega,
                  requisiciones.descripcion AS descripcion,
                  requisiciones.id_orden_compra AS id_orden_compra,
                  requisiciones.folio_orden_compra AS folio_orden_compra,
                  requisiciones.subtotal AS subtotal,
                  requisiciones.iva AS iva,
                  requisiciones.total AS total,
                  requisiciones.id_capturo AS id_capturo,
                  requisiciones.tipo AS tipo,

                  requisiciones.subtotal AS subtotal,
                  requisiciones.iva AS iva,
                  requisiciones.total AS total,

                  requisiciones.excede_presupuesto as excede_presupuesto,

                  requisiciones.no_economico AS no_economico,
                  requisiciones.responsable AS responsable,
                  requisiciones.kilometraje AS kilometraje,

                  requisiciones.id_familia_gasto,
                  IFNULL(fam_gastos.descr,'') AS familia_gasto,
                  requisiciones.b_anticipo,
                  requisiciones.monto_anticipo,
                  requisiciones.b_varias_familias,

                  proveedores.nombre as proveedor,
                  IF((SELECT COUNT(id) FROM requisiciones_d WHERE id_requisicion = requisiciones.id) = 1,
                      (SELECT productos.id_clas FROM requisiciones_d INNER JOIN productos ON requisiciones_d.id_producto = productos.id WHERE id_requisicion = requisiciones.id),
                      0) contadorClas
                FROM requisiciones
                INNER JOIN cat_unidades_negocio ON requisiciones.id_unidad_negocio = cat_unidades_negocio.id
                INNER JOIN sucursales ON requisiciones.id_sucursal = sucursales.id_sucursal
                INNER JOIN cat_areas ON requisiciones.id_area = cat_areas.id
                INNER JOIN deptos ON requisiciones.id_departamento = deptos.id_depto 
                INNER JOIN proveedores ON requisiciones.id_proveedor = proveedores.id
                LEFT JOIN fam_gastos ON requisiciones.id_familia_gasto=fam_gastos.id_fam
                $where
                ORDER BY requisiciones.id DESC";

                echo $query;
                exit();

      $resultado = $this->link->query($query);
      return query2json($resultado);

    }

    /**
      * Buscar los detalles de determidada requisicion
      *
      * @param int $idRequisicin
      *
      **/
    function buscarDetallesRequisiciones($idRequisicion)
    {

      $query = "SELECT
                  requisiciones_d.id AS id,
                  requisiciones_d.id_producto AS id_producto,
                  requisiciones_d.id_linea AS id_linea,
                  requisiciones_d.id_familia AS id_familia,
                  requisiciones_d.cantidad AS cantidad,
                  requisiciones_d.descripcion AS descripcion,
                  requisiciones_d.costo_unitario AS costo_unitario,
                  requisiciones_d.iva AS porcentaje_iva,
                  requisiciones_d.justificacion AS justificacion,
                  requisiciones_d.total AS total,
                  requisiciones_d.excede_presupuesto AS excede_presupuesto,
                  requisiciones_d.descuento_unitario,
                  requisiciones_d.descuento_total,
                  productos.concepto AS concepto,
                  familias.tallas as verifica_talla,
                  IFNULL(lineas.descripcion,'') AS linea,
                  IFNULL(familias.descripcion,'') AS familia,
                  familias.id_familia_gasto,
                  fam_gastos.descr AS familia_gasto,
                  IFNULL(gastos_clasificacion.id_clas, 0) as id_clas,
                  IFNULL(gastos_clasificacion.descr, '') as clasificacion
                FROM requisiciones_d
                INNER JOIN productos ON requisiciones_d.id_producto = productos.id
                INNER JOIN lineas ON requisiciones_d.id_linea = lineas.id
                INNER JOIN familias ON requisiciones_d.id_familia = familias.id
                LEFT JOIN fam_gastos ON familias.id_familia_gasto=fam_gastos.id_fam
                LEFT JOIN gastos_clasificacion ON productos.id_clas = gastos_clasificacion.id_clas
                WHERE requisiciones_d.id_requisicion = $idRequisicion";

      $resultado = $this->link->query($query);
      return query2json($resultado);

    }

    /**
      * Busca las tallas de determinada partida
      *
      * @param int $idDetalle
      * @param int $tipo
      *
      **/
    function obtenerTallasDetalle($idDetalle, $tipo)
    {

      $resultado = $this->link->query("SELECT * FROM tallas WHERE tipo = $tipo AND id_detalle = $idDetalle");
        return query2json($resultado);

    }

    /**
      * Eliminar los detalles de determinada requisición
      *
      * @param int $idRequisicion
      *
      **/
    function eliminarDetalles($idRequisicion)
    {

      $resultado = $this->link->query("SELECT id FROM requisiciones_d WHERE id_requisicion = $idRequisicion");
      while($row = $resultado->fetch_assoc())
      {

        $idDetalle = $row['id'];
        $this->link->query("DELETE FROM tallas WHERE tipo = 1 AND id_detalle = $idDetalle");
        $this->link->query("DELETE from requisiciones_d where id = $idDetalle");
      
      }

    }

    /**
     * 
     * Busca los datos de requisiciones para formar reportes
     * @param varchar $datos array que contiene los datos de los fltros para hacer la Búsqueda de y el tipo de reporte
     * 
    **/
    function buscarRequisicionesReportes($datos){
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idArea = $datos['idArea'];
        $idDepartamento = $datos['idDepartamento'];
        $idProveedor = $datos['idProveedor'];
        $tipoReporte = $datos['tipoReporte'];

        $condicion='';

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND a.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND a.fecha_pedido >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND DATE(a.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        if($idSucursal != NULL)
        {
          $sucursal=" AND a.id_sucursal=".$idSucursal;
        }else{
          $sucursal='';
        }

        if($idArea != NULL)
        {
          $area=" AND a.id_area=".$idArea;
        }else{
          $area='';
        }

        if($idDepartamento != NULL)
        {
          $departamento=" AND a.id_departamento=".$idDepartamento;
        }else{
          $departamento='';
        }
        
        if($idProveedor != NULL)
        {
          $proveedor=" AND a.id_proveedor=".$idProveedor;
        }else{
          $proveedor='';
        }

        if($tipoReporte == 'requisicionesAgrupadas')
        {
          //-->NJES October/28/2020 mostrar quien autorizo una requi fuera de presupuesto o dentro del presupuesto en reporte agrupados
          $query="SELECT a.folio,a.id AS id,b.nombre AS unidad,c.descr AS sucursal,d.descripcion AS are,
                  IFNULL(e.des_dep,'') AS depto,IFNULL(a.id_orden_compra,'') AS id_orden_compra,
                  IFNULL(a.folio_orden_compra,'') AS folio_orden_compra,a.fecha_pedido AS fecha,
                  IFNULL(a.solicito,'') AS solicito,f.nombre AS proveedor,a.descripcion,a.subtotal AS subtotal,
                  a.iva AS iva,a.total AS total,a.excede_presupuesto, IF(a.b_anticipo = 1 , 'CON ANTICIPO',  'SIN ANTICIPO') AS anticipo,
                  IFNULL(h.usuario,'') AS autorizo_fuera_presupuesto,
                  IFNULL(j.usuario,'') AS autorizo,
                  IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',
                  IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar', IF(a.estatus = 6, 'Pagada', 'Cancelada') ) )))) AS estatus,
                  a.id_capturo,
                  us.usuario quienCapturo
                  FROM requisiciones a
                  INNER JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                  INNER JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                  INNER JOIN cat_areas d ON a.id_area = d.id
                  INNER JOIN deptos e ON a.id_departamento = e.id_depto AND e.tipo='I'
                  INNER JOIN proveedores f ON a.id_proveedor = f.id
                  LEFT JOIN requisiciones_autorizar_bitacora g ON a.id=g.id_requisicion AND (a.excede_presupuesto=1 OR a.excede_presupuesto=0) AND g.estatus=1
                  LEFT JOIN usuarios h ON g.id_usuario=h.id_usuario 
                  LEFT JOIN requisiciones_autorizar_bitacora i ON a.id=i.id_requisicion AND (a.excede_presupuesto=1 OR a.excede_presupuesto=0) AND i.estatus=2
                  LEFT JOIN usuarios j ON i.id_usuario=j.id_usuario
                  LEFT JOIN usuarios us ON us.id_usuario = a.id_capturo
                  WHERE a.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                  ORDER BY a.fecha_pedido";
        }

        if($tipoReporte == 'detalleRequisiciones')
        {
          $query="SELECT a.folio,g.id,g.num_partida,b.nombre AS unidad,c.descr AS sucursal,d.descripcion AS are,
                  IFNULL(e.des_dep,'') AS depto,IFNULL(a.id_orden_compra,'') AS id_orden_compra,
                  IFNULL(a.folio_orden_compra,'') AS folio_orden_compra,a.fecha_pedido AS fecha,
                  IFNULL(a.solicito,'') AS solicito,f.nombre AS proveedor,IFNULL(i.descripcion,'') AS linea,
                  IFNULL(j.descripcion,'') AS familia,g.descripcion,g.concepto AS detalle,IFNULL(l.unidad_medida,'') AS unidad_medida,g.cantidad,g.costo_unitario,
                  IFNULL(l.porcentaje_descuento,0) AS porcentaje_descuento,((g.total/100)*g.iva) AS porcentaje_iva,g.total AS importe_sin_iva,
                  (((g.total/100)*g.iva)+g.total) AS importe_con_iva,
                  IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',
                  IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar', IF(a.estatus = 6, 'Pagada', 'Cancelada') ) )))) AS estatus,
                  g.excede_presupuesto,
                  CASE
                      WHEN a.tipo = 0 THEN 'Activo Fijo'
                      WHEN a.tipo = 1 THEN 'Gasto'
                      WHEN a.tipo = 2 THEN 'Mantenimiento'
                      ELSE 'Stock'
                  END AS tipo,
                  IF(IFNULL(n.id_entrada_compra,0)>0,'SI','NO') AS en_portal,
                  IFNULL(m.folio,'') AS folio_recepcion_mercancia,
                  g.descuento_unitario,
                  g.descuento_total
                  FROM requisiciones_d g
                  LEFT JOIN requisiciones a ON g.id_requisicion=a.id
                  LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                  LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                  LEFT JOIN cat_areas d ON a.id_area = d.id
                  LEFT JOIN deptos e ON a.id_departamento = e.id_depto AND e.tipo='I'
                  LEFT JOIN proveedores f ON a.id_proveedor = f.id
                  LEFT JOIN productos h ON g.id_producto = h.id
                  LEFT JOIN lineas i ON g.id_linea = i.id
                  LEFT JOIN familias j ON g.id_familia = j.id
                  LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                  LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra

                  LEFT JOIN almacen_e m ON k.id=m.id_oc
                  LEFT JOIN cxp n ON m.id=n.id_entrada_compra

                  WHERE a.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                  GROUP BY g.id
                  ORDER BY a.fecha_pedido,g.id";
        }

        if($tipoReporte == 'backorderRequisiciones')
        {
          $query="SELECT a.folio,g.id,g.num_partida,b.nombre AS unidad,c.descr AS sucursal,d.descripcion AS are,
                  IFNULL(e.des_dep,'') AS depto,IFNULL(a.id_orden_compra,'') AS id_orden_compra,
                  IFNULL(a.folio_orden_compra,'') AS folio_orden_compra,a.fecha_pedido AS fecha,
                  IFNULL(a.solicito,'') AS solicito,f.nombre AS proveedor,IFNULL(i.descripcion,'') AS linea,
                  IFNULL(j.descripcion,'') AS familia,g.descripcion,g.concepto AS detalle,IFNULL(l.unidad_medida,'') AS unidad_medida,g.cantidad,g.costo_unitario,
                  IFNULL(l.porcentaje_descuento,0) AS porcentaje_descuento,((g.total/100)*g.iva) AS porcentaje_iva,g.total AS importe_sin_iva,
                  (((g.total/100)*g.iva)+g.total) AS importe_con_iva,g.excede_presupuesto
                  FROM requisiciones_d g
                  LEFT JOIN requisiciones a ON g.id_requisicion=a.id
                  LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                  LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                  LEFT JOIN cat_areas d ON a.id_area = d.id
                  LEFT JOIN deptos e ON a.id_departamento = e.id_depto AND e.tipo='I'
                  LEFT JOIN proveedores f ON a.id_proveedor = f.id
                  LEFT JOIN productos h ON g.id_producto = h.id
                  LEFT JOIN lineas i ON g.id_linea = i.id
                  LEFT JOIN familias j ON g.id_familia = j.id
                  LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                  LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra
                  WHERE a.id_unidad_negocio=".$idUnidadNegocio." AND a.estatus=1 $sucursal $area $departamento $proveedor $condicion
                  ORDER BY a.fecha_pedido";
        }

        // echo $query;
        // exit();

        $result = $this->link->query($query);

        return query2json($result);
        
    }//--fin function buscarRequisicionesReportes


    /**
    * Verifica el presupuesto de un producto que será agregado a la requi
   
    * @param int $idFamilia unidad de negocio selecionada en la orden de compra
    * @param int $idSucursal sucursal selecionada en la orden de compra
    *
    **/
    function buscarRequisicionesPresupuesto($idFamilia,$idUnidad,$idSucursal,$idClas)
    {

      $condClas = "";

      if($idClas != 0){
        $condClas = " AND a.id_clasificacion = $idClas ";
      }

      $query="SELECT 
                (IFNULL(SUM(tabla.presupuesto),0)-IFNULL(SUM(tabla.ejercido),0)) AS queda
              FROM (	
                    SELECT 
                        IFNULL(b.descr,'') AS familia,
                        SUM(a.monto) AS presupuesto,
                        0 AS ejercido
                    FROM presupuesto_egresos a 
                    LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                    WHERE a.id_unidad_negocio=$idUnidad AND a.id_sucursal=$idSucursal AND a.id_familia_gasto=(SELECT id_familia_gasto FROM familias WHERE id=$idFamilia ) AND a.anio = YEAR(CURDATE())AND a.mes = MONTH(CURDATE()) $condClas
                    GROUP BY a.id_familia_gasto

                    UNION ALL
                    
                    SELECT 
                        IFNULL(b.descr,'') AS familia,
                        0 AS presupuesto,
                        SUM(a.monto) AS ejercido
                    FROM movimientos_presupuesto a 
                    LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                    WHERE a.id_unidad_negocio=$idUnidad AND a.id_sucursal=$idSucursal AND a.id_familia_gasto=(SELECT id_familia_gasto FROM familias WHERE id=$idFamilia ) AND YEAR(a.fecha_captura) = YEAR(CURDATE())AND MONTH(a.fecha_captura) = MONTH(CURDATE()) $condClas 
                    GROUP BY a.id_familia_gasto
                  ) AS tabla              
              GROUP BY tabla.familia
              ORDER BY tabla.familia ASC";

      // echo $query;
      // exit();

      $result = mysqli_query($this->link,$query);
      $numRows = mysqli_num_rows($result);
      if($numRows>0){

        $row = mysqli_fetch_array($result);
        return $row['queda'];

      }else{

        return 0;
      }

    }

    function buscarRequisicionesRequisitados($idFamilia,$idUnidad,$idSucursal,$idClas){

      $query="SELECT
                SUM(tabla.presupuesto) - SUM(tabla.ejercido) AS difer
              FROM (
                SELECT
                  SUM(a.monto) AS presupuesto,
                  0 AS ejercido
                FROM presupuesto_egresos a 
                LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                WHERE a.id_unidad_negocio=$idFamilia AND a.id_sucursal=$idSucursal AND a.id_familia_gasto=(SELECT id_familia_gasto FROM familias WHERE id=$idFamilia ) AND a.anio = YEAR(CURDATE())AND a.mes = MONTH(CURDATE())
                GROUP BY a.id_familia_gasto
                  
                  UNION ALL
              
                SELECT
                  0 as presupuesto,
                  (re.total) as ejercido
                FROM requisiciones re
                INNER JOIN requisiciones_d rd ON rd.id_requisicion = re.id
                WHERE re.estatus <> 7
                AND re.id_unidad_negocio = $idUnidad
                AND re.id_sucursal = $idSucursal
                AND rd.id_familia = $idFamilia
                AND YEAR(re.fecha_creacion) = YEAR(NOW())
                AND MONTH(re.fecha_creacion) = MONTH(NOW())
                  GROUP BY re.id
              ) as tabla";

      // echo $query;
      // exit();

      $result = mysqli_query($this->link,$query);
      $numRows = mysqli_num_rows($result);
      if($numRows>0){

        $row = mysqli_fetch_array($result);
        return $row['queda'];

      }else{

        return 0;
      }

    }


    /**
      * Obtiene el folio actual de las requisiciones
      *
      * @param int $idUnidad
      *
      **/ 
      function obtenerFolioMantenimiento($idUnidad)
      {
  
        $result = mysqli_query($this->link, "SELECT folio_requisicion_mantenimiento FROM cat_unidades_negocio WHERE id = $idUnidad");
        $row = mysqli_fetch_assoc($result);
        return $row['folio_requisicion_mantenimiento'];
      }

      /**
      * Actualiza el folio actual de las requisiciones
      *
      * @param int $idUnidad
      * @param int $folio
      *
      **/
      function actualizarFolioMantenimiento($idUnidad, $folioMantenimiento)
      {
        $result = mysqli_query($this->link, "UPDATE cat_unidades_negocio SET folio_requisicion_mantenimiento = $folioMantenimiento WHERE id = $idUnidad");
      }


          /**
      * Busca todas las requisiciones
      *
      * @param int id
      *
      **/
    function buscarRequisicionesAutorizadasGastos($id, $idUnidad, $idSucursal, $fechaDe, $fechaA)
    {
      //-->NJES November/06/2020 que se muestren las requisiciones que no se han omitido en el modulo de gastos
      $where = " WHERE requisiciones.tipo=1 AND requisiciones.estatus=2 AND requisiciones.omitir=0";
    
      if($id != null)
        $where .= " AND requisiciones.id = $id";

      //-->NJES February/17/2021 se agrega checked para mostrar registros de las sucursales y 
      //unidades a las que tiene permiso el usuario en el modulo gastos
      
      //$where .= " AND cat_unidades_negocio.id = $idUnidad ";
      if($idUnidad[0] == ',')
      {
          $dato=substr($idUnidad,1);
          $where .= ' AND cat_unidades_negocio.id IN('.$dato.') ';
      }else{ 
          $where .= ' AND cat_unidades_negocio.id ='.$idUnidad;
      }
      
      //$where .= " AND sucursales.id_sucursal = $idSucursal ";  
      if($idSucursal[0] == ',')
      {
        $dato=substr($idSucursal,1);
        $where .= ' AND sucursales.id_sucursal IN('.$dato.') ';
      }else{ 
        $where .= ' AND sucursales.id_sucursal ='.$idSucursal;
      }

      if($fechaDe == '' && $fechaA == '')
        $where .= " AND requisiciones.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
      else if($fechaDe != null &&  $fechaA == null)
        $where .= " AND requisiciones.fecha_pedido >= '$fechaDe' ";
      else  //-->trae fecha inicio y fecha fin
        $where .= " AND requisiciones.fecha_pedido >= '$fechaDe' AND requisiciones.fecha_pedido <= '$fechaA' ";
      
    
    $resultado = $this->link->query("
      SELECT
      requisiciones.id AS id,
      requisiciones.id_unidad_negocio AS id_unidad_negocio,
      requisiciones.id_sucursal AS id_sucursal,
      requisiciones.id_area AS id_area,
      requisiciones.id_departamento AS id_departamento,
      requisiciones.folio AS folio,
      requisiciones.estatus AS estatus,
      cat_unidades_negocio.nombre AS unidad, 
      sucursales.descr AS sucursal,
      cat_areas.descripcion AS are,
      IFNULL(deptos.des_dep,'') AS depto,
      requisiciones.solicito AS solicito,
      requisiciones.id_proveedor AS id_proveedor,
      requisiciones.fecha_pedido AS fecha_pedido,
      requisiciones.tiempo_entrega AS tiempo_entrega,
      requisiciones.descripcion AS descripcion,
      requisiciones.id_orden_compra AS id_orden_compra,
      requisiciones.folio_orden_compra AS folio_orden_compra,
     
      requisiciones.id_capturo AS id_capturo,
      requisiciones.tipo AS tipo,

      requisiciones.subtotal AS subtotal,
      requisiciones.iva AS iva,
      requisiciones.total AS total,

      requisiciones.excede_presupuesto AS excede_presupuesto,

      requisiciones.folio_mantenimiento AS folio_mantenimiento,
      requisiciones.no_economico AS no_economico,
      requisiciones.responsable AS responsable,
      requisiciones.kilometraje AS kilometraje,

      requisiciones.id_familia_gasto,
      requisiciones.b_varias_familias,

      proveedores.nombre as proveedor,
      usuarios.usuario AS capturo,
      IFNULL(gastos.id_requisicion,0) AS id_requi_gasto
      FROM requisiciones
      INNER JOIN cat_unidades_negocio ON requisiciones.id_unidad_negocio = cat_unidades_negocio.id
      INNER JOIN sucursales ON requisiciones.id_sucursal = sucursales.id_sucursal
      INNER JOIN cat_areas ON requisiciones.id_area = cat_areas.id
      INNER JOIN deptos ON requisiciones.id_departamento = deptos.id_depto AND deptos.tipo='I'
      INNER JOIN proveedores ON requisiciones.id_proveedor = proveedores.id
      LEFT JOIN gastos ON requisiciones.id=gastos.id_requisicion
      LEFT JOIN  usuarios ON requisiciones.id_capturo=usuarios.id_usuario
      $where
      HAVING id_requi_gasto=0
      ORDER BY requisiciones.id DESC");

      return query2json($resultado);

    }

    function buscarRequisicionesReportesTodas($datos){
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idSucursal = $datos['idSucursal'];
        $tipoReporte = $datos['tipoReporte'];
        $prov = isset($datos['prov']) ? $datos['prov'] : 0;
        $idSucursal = rtrim($idSucursal, ",");

        if($prov == 0){
            $condProveedor = "";
        }else{
            $condProveedor = " AND f.id = $prov";
        }

        $condicion='';

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND a.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND a.fecha_pedido >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND DATE(a.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        if($idSucursal != NULL)
        {
          $sucursal=" AND a.id_sucursal IN (" . $idSucursal . ")";
        }else{
          $sucursal='';
        }

        if($tipoReporte == 'requisicionesAgrupadas')
        {
          //-->NJES October/28/2020 mostrar quien autorizo una requi fuera de presupuesto o dentro del presupuesto en reporte agrupados
          $query="SELECT a.folio,a.id AS id,b.nombre AS unidad,c.descr AS sucursal,d.descripcion AS are,
                  IFNULL(e.des_dep,'') AS depto,IFNULL(a.id_orden_compra,'') AS id_orden_compra,
                  IFNULL(a.folio_orden_compra,'') AS folio_orden_compra,a.fecha_pedido AS fecha,
                  IFNULL(a.solicito,'') AS solicito,f.nombre AS proveedor,a.descripcion,a.subtotal AS subtotal,
                  a.iva AS iva,a.total AS total,a.excede_presupuesto, IF(a.b_anticipo = 1 , 'CON ANTICIPO',  'SIN ANTICIPO') AS anticipo,
                  IFNULL(h.usuario,'') AS autorizo_fuera_presupuesto,
                  IFNULL(j.usuario,'') AS autorizo,
                  IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',
                  IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar', IF(a.estatus = 6, 'Pagada', 'Cancelada') ) )))) AS estatus
                  FROM requisiciones a
                  INNER JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                  INNER JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                  INNER JOIN cat_areas d ON a.id_area = d.id
                  INNER JOIN deptos e ON a.id_departamento = e.id_depto AND e.tipo='I'
                  INNER JOIN proveedores f ON a.id_proveedor = f.id $condProveedor
                  LEFT JOIN requisiciones_autorizar_bitacora g ON a.id=g.id_requisicion AND a.excede_presupuesto=1 AND g.estatus=2
                  LEFT JOIN usuarios h ON g.id_usuario=h.id_usuario
                  LEFT JOIN requisiciones_autorizar_bitacora i ON a.id=i.id_requisicion AND a.excede_presupuesto=0 AND i.estatus=2
                  LEFT JOIN usuarios j ON i.id_usuario=j.id_usuario 
                  WHERE 1  $sucursal $condicion
                  ORDER BY a.fecha_pedido";
        }

        if($tipoReporte == 'detalleRequisiciones')
        {
          $query="SELECT a.folio,g.id,g.num_partida,b.nombre AS unidad,c.descr AS sucursal,d.descripcion AS are,
                  IFNULL(e.des_dep,'') AS depto,IFNULL(a.id_orden_compra,'') AS id_orden_compra,
                  IFNULL(a.folio_orden_compra,'') AS folio_orden_compra,a.fecha_pedido AS fecha,
                  IFNULL(a.solicito,'') AS solicito,f.nombre AS proveedor,IFNULL(i.descripcion,'') AS linea,
                  IFNULL(j.descripcion,'') AS familia,g.descripcion,g.concepto AS detalle,IFNULL(l.unidad_medida,'') AS unidad_medida,g.cantidad,g.costo_unitario,
                  IFNULL(l.porcentaje_descuento,0) AS porcentaje_descuento,((g.total/100)*g.iva) AS porcentaje_iva,g.total AS importe_sin_iva,
                  (((g.total/100)*g.iva)+g.total) AS importe_con_iva,
                  IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',
                  IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar', IF(a.estatus = 6, 'Pagada', 'Cancelada') ) )))) AS estatus,
                  g.excede_presupuesto,
                  CASE
                      WHEN a.tipo = 0 THEN 'Activo Fijo'
                      WHEN a.tipo = 1 THEN 'Gasto'
                      WHEN a.tipo = 2 THEN 'Mantenimiento'
                      ELSE 'Stock'
                  END AS tipo,
                  IF(IFNULL(n.id_entrada_compra,0)>0,'SI','NO') AS en_portal,
                  IFNULL(m.folio,'') AS folio_recepcion_mercancia,
                  g.descuento_unitario,
                  g.descuento_total
                  FROM requisiciones_d g
                  LEFT JOIN requisiciones a ON g.id_requisicion=a.id
                  LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                  LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                  LEFT JOIN cat_areas d ON a.id_area = d.id
                  LEFT JOIN deptos e ON a.id_departamento = e.id_depto AND e.tipo='I'
                  LEFT JOIN proveedores f ON a.id_proveedor = f.id
                  LEFT JOIN productos h ON g.id_producto = h.id
                  LEFT JOIN lineas i ON g.id_linea = i.id
                  LEFT JOIN familias j ON g.id_familia = j.id
                  LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                  LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra
                  LEFT JOIN almacen_e m ON k.id=m.id_oc
                  LEFT JOIN cxp n ON m.id=n.id_entrada_compra
                  WHERE 1 $sucursal $condicion
                  GROUP BY g.id
                  ORDER BY a.fecha_pedido,g.id";
        }

        if($tipoReporte == 'backorderRequisiciones')
        {

          $query="SELECT a.folio,g.id,g.num_partida,b.nombre AS unidad,c.descr AS sucursal,d.descripcion AS are,
                  IFNULL(e.des_dep,'') AS depto,IFNULL(a.id_orden_compra,'') AS id_orden_compra,
                  IFNULL(a.folio_orden_compra,'') AS folio_orden_compra,a.fecha_pedido AS fecha,
                  IFNULL(a.solicito,'') AS solicito,f.nombre AS proveedor,IFNULL(i.descripcion,'') AS linea,
                  IFNULL(j.descripcion,'') AS familia,g.descripcion,g.concepto AS detalle,IFNULL(l.unidad_medida,'') AS unidad_medida,g.cantidad,g.costo_unitario,
                  IFNULL(l.porcentaje_descuento,0) AS porcentaje_descuento,((g.total/100)*g.iva) AS porcentaje_iva,g.total AS importe_sin_iva,
                  (((g.total/100)*g.iva)+g.total) AS importe_con_iva,g.excede_presupuesto
                  FROM requisiciones_d g
                  LEFT JOIN requisiciones a ON g.id_requisicion=a.id
                  LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                  LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                  LEFT JOIN cat_areas d ON a.id_area = d.id
                  LEFT JOIN deptos e ON a.id_departamento = e.id_depto AND e.tipo='I'
                  LEFT JOIN proveedores f ON a.id_proveedor = f.id
                  LEFT JOIN productos h ON g.id_producto = h.id
                  LEFT JOIN lineas i ON g.id_linea = i.id
                  LEFT JOIN familias j ON g.id_familia = j.id
                  LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                  LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra
                  WHERE a.estatus=1 $sucursal $condicion
                  ORDER BY a.fecha_pedido";
        }

        // echo $query;
        // exit();

        $result = $this->link->query($query);

        return query2json($result);
    }//--fin function buscarRequisicionesRep

    function validaOrdenServicio($id)
    {

      $result = mysqli_query($this->link, "SELECT 
        requisiciones.id AS id_requi,  orden_compra.id AS id_oc, almacen_e.id AS id_a, IFNULL(cxp.id, 0) AS id_cxp, IFNULL(cxp.estatus, 'X') AS estatus
        FROM requisiciones
        INNER JOIN orden_compra ON requisiciones.id = orden_compra.ids_requisiciones
        INNER JOIN almacen_e ON orden_compra.id = almacen_e.id_oc
        LEFT JOIN cxp ON almacen_e.id = cxp.id_entrada_compra
         WHERE requisiciones.id = $id");
      $r = mysqli_fetch_assoc($result);

      return $r['estatus'];
    }

    function rechazaOrdenServicio($id)
    {

      $verifica = false;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");


      $result = mysqli_query($this->link, "SELECT 
        requisiciones.id AS id_requi,  orden_compra.id AS id_oc, almacen_e.id AS id_a, IFNULL(cxp.id, 0) AS id_cxp, IFNULL(cxp.estatus, 'X') AS estatus
        FROM requisiciones
        INNER JOIN orden_compra ON requisiciones.id = orden_compra.ids_requisiciones
        INNER JOIN almacen_e ON orden_compra.id = almacen_e.id_oc
        LEFT JOIN cxp ON almacen_e.id = cxp.id_entrada_compra
         WHERE requisiciones.id = $id");

      $r = mysqli_fetch_assoc($result);

      $idRequi = $r['id_requi'];
      $idOC = $r['id_oc'];
      $idA = $r['id_a'];
      $idCXP = $r['id_cxp'];
      $estatus = $r['estatus'];

      if(mysqli_query($this->link, "DELETE FROM orden_compra WHERE id = $idOC"))
      {

        if(mysqli_query($this->link, "DELETE FROM almacen_d WHERE id_almacen_e = $idA"))
        {

          if(mysqli_query($this->link, "DELETE FROM almacen_e WHERE id = $idA"))
          {

            //
            if(mysqli_query($this->link, "UPDATE requisiciones set estatus = 3, folio_orden_compra = 0, id_orden_compra = 0 WHERE id = $idRequi"))
            {

              //-->NJES July/24/2020 se genera bitacora al autorizar o rechazar una requisición cada vez
              $bitacoraAutorizarRequi = new Autorizar();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
              
              $datos = array('idRequisicion'=>$idRequi,
                          'estatus'=>3,
                          'idUsuario'=>$_SESSION['id_usuario']);
              if($bitacoraAutorizarRequi->guardaBitacoraAutorizaRechazaRequi($datos) > 0)
              {
                if($estatus == 'P')
                {

                  if(mysqli_query($this->link, "DELETE FROM cxp WHERE id = $idCXP"))
                    $verifica = true;
                  
                }
                else
                  $verifica = true;
              }else
                $verifica = false;

            }

          }

        }

      }

      /*$query = "
        DELETE FROM orden_compra WHERE id = $idOC;
        DELETE FROM almacen_d WHERE id_almacen_e = $idA;
        DELETE FROM almacen_e WHERE id = $idA;
        UPDATE requisiciones set estatus = 3 WHERE id = $idRequi;";

      if($estatus == 'P')
        $query .= "DELETE FROM cxp WHERE id = $idCXP;";    

      if(mysqli_multi_query($this->link, $query))
        $verifica = true;*/

      if($verifica == true)
        $this->link->query("commit;");
      else
        $this->link->query('rollback;');      

      return $verifica;

    }

    function buscarRequisicionPartidas($idRequisicion){
      $query = "SELECT
                  requisiciones_d.id AS id,
                  requisiciones_d.cantidad AS cantidad,
                  requisiciones_d.costo_unitario AS costo_unitario,
                  requisiciones_d.iva AS porcentaje_iva,
                  ((requisiciones_d.cantidad*requisiciones_d.costo_unitario)*requisiciones_d.iva)/100 AS iva,
                  productos.concepto AS concepto,
                  familias.id_familia_gasto,
                  fam_gastos.descr AS familia_gasto,
                  productos.id_clas
                FROM requisiciones_d
                INNER JOIN productos ON requisiciones_d.id_producto = productos.id
                INNER JOIN familias ON requisiciones_d.id_familia = familias.id
                LEFT JOIN fam_gastos ON familias.id_familia_gasto=fam_gastos.id_fam
                WHERE requisiciones_d.id_requisicion = $idRequisicion";
      
      $resultado = $this->link->query($query);

      return query2json($resultado);
    }
  

}//--fin de class Requisiciones


?>