<?php

include_once('conectar.php');
include_once('Requisiciones.php');

class OrdenCompra
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function OrdenCompra()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una orden de compra
      * 
      * @param array $datos contiene los datos de la orden a aguardar o auctualizar
      *
    **/      
    function guardarOrdenCompra($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> verificarRequisUsadas($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarOrdenCompra


    function verificarRequisUsadas($datos){
      $verifica = 0;
      $idsRequisiciones = $datos['ids_requisiciones'];

      $queryR="SELECT id_orden_compra FROM requisiciones WHERE id IN ('$idsRequisiciones') AND id_orden_compra>0";
      $resultR = mysqli_query($this->link, $queryR) or die(mysqli_error());
      $numRows = mysqli_num_rows($resultR);
     
      if($numRows == 0){
          $verifica = $this -> guardarActualizar($datos);
      }else{
          $verifica = 0;
      }

      return $verifica;

    }

    /**
      * Guarda los datos de una orden de compra, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param varchar $datos contiene los parametros a guardar/actualizar
      *
      **/ 
      function guardarActualizar($datos){
    
        $verifica = 0;

        $idOrdenCompra= $datos['idOrdenCompra'];
        $folio= $datos['folio'];
        $tipoMov = $datos['tipoMov'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idArea = $datos['idArea'];
        $idDepartamento = $datos['idDepartamento'];
        $idProveedor = $datos['idProveedor'];
        $idEmprezaFiscal = $datos['idEmprezaFiscal'];
        $idUsuario = $datos['idUsuario'];
        $solicito = $datos['solicito'];
        $requisiciones = $datos['requisiciones'];
        $idsRequisiciones = $datos['idsRequisiciones'];
        $tipoGastoStock = $datos['tipoGastoStock'];
        $fechaPedido = $datos['fechaPedido'];
        $tiempoEntrega = $datos['tiempoEntrega'];
        $fechaEntrega = $datos['fechaEntrega'];
        $condicionPago = $datos['condicionPago'];
        $observacionesEntrega = $datos['observacionesEntrega'];
        $estatus = $datos['estatus'];
        $partidas = $datos['partidas'];
        $detalle = $datos['detalle'];
        

        if($tipoMov==0){

          $queryFolio="SELECT folio_oc FROM cat_unidades_negocio WHERE id=".$idUnidadNegocio;
          $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
          if($resultF){

            $datos=mysqli_fetch_array($resultF);
            $folioA=$datos['folio_oc'];
            $folio= $folioA+1;
  
            $queryU = "UPDATE cat_unidades_negocio SET folio_oc='$folio' WHERE id=".$idUnidadNegocio;
            $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
            if($resultU){
    
              $query = "INSERT INTO orden_compra (folio,tipo,id_usuario,usuario,estatus,fecha_pedido,tiempo_entrega,fecha_entrega,condiciones_pago,observaciones_entrega,requisiciones,ids_requisiciones,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_empresa_fiscal,id_proveedor) 
              VALUES ('$folio','$tipoGastoStock','$idUsuario','$solicito','A','$fechaPedido','$tiempoEntrega','$fechaEntrega','$condicionPago','$observacionesEntrega','$requisiciones','$idsRequisiciones','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idEmprezaFiscal','$idProveedor')";
              $result = mysqli_query($this->link, $query) or die(mysqli_error());
              $idOrdenCompra = mysqli_insert_id($this->link);
  
            }else{
              $result=0;
            }

          }else{
            $result=0;
          }

        }else{

          //--- se quita el id de oc a las requis que este afectando la orden
          $queryR = "UPDATE requisiciones SET id_orden_compra='0', folio_orden_compra='0', estatus='2' WHERE id_orden_compra=".$idOrdenCompra;
          $resultR = mysqli_query($this->link, $queryR) or die(mysqli_error());

          $query = "UPDATE orden_compra 
                      SET tipo='$tipoGastoStock',
                      id_usuario_modif='$idUsuario',
                      usuario_modificacion='$solicito',
                      estatus='$estatus',
                      fecha_pedido='$fechaPedido',
                      tiempo_entrega='$tiempoEntrega',
                      fecha_entrega='$fechaEntrega',
                      condiciones_pago='$condicionPago',
                      observaciones_entrega='$observacionesEntrega',
                      fecha_modificacion='CURRENT_DATE()',
                      requisiciones='$requisiciones',
                      ids_requisiciones='$idsRequisiciones',
                      id_unidad_negocio='$idUnidadNegocio',
                      id_sucursal='$idSucursal',
                      id_area='$idArea',
                      id_departamento='$idDepartamento',
                      id_empresa_fiscal='$idEmprezaFiscal',
                      id_proveedor='$idProveedor'
                      WHERE id=".$idOrdenCompra;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result)
        {
          if($requisiciones!=''){
            //--- se asigna el id_oc a cada requi afectada se cambia a estatus ordenada
            $queryR = "UPDATE requisiciones SET id_orden_compra='$idOrdenCompra', folio_orden_compra='$folio', estatus='4' WHERE id in (".$idsRequisiciones.")";
            $resultR = mysqli_query($this->link, $queryR) or die(mysqli_error());
          }

          $verifica = $this -> guardarDetalle($idOrdenCompra,$tipoMov,$folio,$detalle); 
        }else{
          $verifica = 0;
        } 

        return $verifica;
    }//-- fin function guardarActualizar


    function guardarDetalle($idOrdenCompra,$tipoMov,$folio,$detalle){
  
      $verifica=0;

      $num_partida=0;

      //--- se eliminan las partidas actuales de la oc para volverlas a insertar
      $queryBorra = "DELETE FROM orden_compra_d WHERE id_orden_compra=".$idOrdenCompra;
      $result = mysqli_query($this->link, $queryBorra) or die(mysqli_error());
      if($result){

          for($i=1;$i<=$detalle[0];$i++){

            $num_partida++;

            $idRequi = $detalle[$i]['idRequi'];
            $idRequiD = $detalle[$i]['idRequiD'];
            $idProducto = $detalle[$i]['idProducto'];
            $clave = $detalle[$i]['clave'];
            $concepto = $detalle[$i]['concepto'];
            $descripcion = $detalle[$i]['descripcion'];
            $cantidad = $detalle[$i]['cantidad'];
            $costo = $detalle[$i]['costo'];
            $iva = $detalle[$i]['iva'];
            $descuento = $detalle[$i]['descuento'];
            $importe = $detalle[$i]['importe'];
            //$tallas = '';
            $verificaTallas = 0;

            $tallas = $detalle[$i]['tallas'];
            if($tallas != '')
              $verificaTallas = 1;

            $query = "INSERT INTO orden_compra_d (id_orden_compra,id_requisicion,id_producto,clave_producto,cantidad,concepto,descripcion,costo_unitario,iva,costo_total,tallas,porcentaje_descuento,importe,estatus,id_requi_d,num_partida) 
            VALUES ('$idOrdenCompra','$idRequi','$idProducto','$clave','$cantidad','$concepto','$descripcion','$costo','$iva','$importe','$verificaTallas','$descuento','$importe','A','$idRequiD','$num_partida')";
            $resultD = mysqli_query($this->link, $query) or die(mysqli_error());
            if($resultD)
            {

              $idDetalle = mysqli_insert_id($this->link);
              if($verificaTallas == 1)
              {

                $tallaArray = json_decode($tallas, true);
                foreach($tallaArray as $tA)
                {

                  $tallaD = $tA['talla'];
                  $cantidadD = $tA['cantidad'];
                  $queryT = "INSERT INTO tallas (tipo, id_detalle, talla, cantidad) VALUES (2, $idDetalle, '$tallaD', $cantidadD)";
                  $resultT = mysqli_query($this->link, $queryT) or die(mysqli_error());

                }

              }

              if($i==$detalle[0]){
                $verifica = $folio;
                break;
              }

            }else{
              $verifica = 0;
              break;
            }

          }//--fin for

      }else{//--if delete
        $verifica = 0;
      }

      return $verifica;
      
    }
    /**
      * Busca los datos de las ordenes de compra, por default muestra con las fechas de los ultimos 30 días
      * 
      * @param varchar $fechaInicio para filtrar a partir de que fecha de pedido mostrar registros
      * @param varchar $fechaFin para filtrar hasta que fecha de pedido mostrar registros
      *
      **/ 
    function buscarOrdenCompra($fechaInicio,$fechaFin,$idUnidadNegocio,$idSucursal,$buscarTodo){
        $condicion='';
        $condicionEstatus='';
        if($buscarTodo==''){
           $condicionEstatus="AND a.estatus!='C'";
        }

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND a.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND a.fecha_pedido >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND a.fecha_pedido >= '$fechaInicio' AND a.fecha_pedido <= '$fechaFin' ";
        }
      
        //-->NJES November/11/2020 verificar si la orden tiene productos de familia fletes y logistica (1=si,0=no)
          $result = $this->link->query("SELECT a.id,a.folio,IF(a.estatus = 'A','Activa',IF(a.estatus = 'I','Impresa','Cancelada')) AS estatus,
          a.fecha_pedido,b.nombre AS proveedor,COUNT(c.id) AS partidas,
          IFNULL(SUM(IF(c.porcentaje_descuento>0,c.costo_total+((c.costo_total-((c.porcentaje_descuento*c.costo_total)/100))*(c.iva/100)),c.costo_total+(c.costo_total*(c.iva/100)))),0) AS total,
          a.id_unidad_negocio,a.id_sucursal,a.id_area,d.descr AS sucursal, a.usuario as solicito,
          SUM(IF(familias.id_familia_gasto=104,1,0)) AS fam_fletes
          FROM orden_compra a
          LEFT JOIN proveedores b ON a.id_proveedor=b.id
          LEFT JOIN orden_compra_d c ON a.id=c.id_orden_compra
          LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
          LEFT JOIN productos ON c.id_producto = productos.id
          LEFT JOIN familias ON productos.id_familia = familias.id
          WHERE a.id_unidad_negocio=".$idUnidadNegocio." AND a.id_sucursal=".$idSucursal." $condicionEstatus  $condicion AND a.tipo != 4
          GROUP BY a.id
          ORDER BY a.id DESC");

        return query2json($result);
    }//-- fin function buscarOrdenCompra

    /**
      * Busca los datos de una orden de compra
      * 
      * @param int $idOrdenCompra de la orden de compra de la que se va a buscar el registro
      *
      **/ 
    function buscarOrdenCompraId($idOrdenCompra){
        $result = $this->link->query("SELECT a.id,a.folio,tipo,usuario,a.estatus,
                                        a.fecha_pedido,a.tiempo_entrega,a.fecha_entrega,a.condiciones_pago,a.observaciones_entrega,a.requisiciones,a.ids_requisiciones,
                                        a.id_unidad_negocio,a.id_sucursal,a.id_area,a.id_departamento,a.id_empresa_fiscal,b.razon_social AS empresa_fiscal,
                                        a.id_proveedor,c.nombre AS proveedor, a.usuario as solicito,a.impresa
                                        FROM orden_compra a 
                                        LEFT JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
                                        LEFT JOIN proveedores c ON a.id_proveedor=c.id
                                        WHERE a.id=".$idOrdenCompra);

        return query2json($result);
    }//-- fin function buscarOrdenCompraId

    /**
      * Busca las partidas de una orden de compra
      * 
      * @param int $idOrdenCompra de la orden de compra de la que se va a buscar el registro
      *
      **/ 
      function buscarOrdenCompraIdDetalle($idOrdenCompra){
        $result = $this->link->query("SELECT 
        orden_compra_d.id,
        orden_compra_d.id_requisicion AS idRequi,
        orden_compra_d.id_requi_d AS idRequiD,
        orden_compra_d.id_producto,
        orden_compra_d.clave_producto AS clave,
        orden_compra_d.cantidad,
        orden_compra_d.cantidad_entrega AS entregados,
        orden_compra_d.concepto,
        orden_compra_d.descripcion AS descripcion,
        orden_compra_d.costo_unitario AS costo,
        orden_compra_d.iva,
        orden_compra_d.estatus AS estatus,
        orden_compra_d.porcentaje_descuento AS descuento,
        orden_compra_d.importe,
        productos.id_linea,
        productos.id_familia,
        IFNULL(lineas.descripcion,'') AS linea,
        IFNULL(familias.descripcion,'') AS familia,
        familias.tallas AS verifica_talla,
        ifnull(requisiciones.folio,0) as folioRequi,
        requisiciones.b_anticipo,
        requisiciones_d.descuento_total
        FROM orden_compra_d
        LEFT JOIN productos ON orden_compra_d.id_producto = productos.id
        LEFT JOIN lineas ON productos.id_linea = lineas.id
        LEFT JOIN familias ON productos.id_familia = familias.id
        LEFT JOIN requisiciones ON orden_compra_d.id_requisicion = requisiciones.id
        LEFT JOIN requisiciones_d ON orden_compra_d.id_requi_d=requisiciones_d.id
        WHERE orden_compra_d.id_orden_compra = ".$idOrdenCompra);

        return query2json($result);
    }//-- fin function buscarOrdenCompraIdDetalle

    function cancelarRestante($idPartida,$entregados)
    {

      $verifica = false;

      $query = "UPDATE orden_compra_d SET cantidad_entrega = '$entregados', estatus = 'L' WHERE id = $idPartida";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      if($result)
        $verifica = true;

      return $verifica;

    }

    function cancelarPartida($idOrdenCompra,$idPartida,$idRequisicion)
    {

      $verifica = false;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $query = "UPDATE orden_compra_d SET estatus = 'C' WHERE id = $idPartida";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      if($result){

        //-->NJES August/14/2020 cancela la requi de la orden de compra y su cxp si tiene anticipo
        $modeloRequisiciones = new Requisiciones();

        $cancela_cxp_requi = $modeloRequisiciones -> cancelarRequisicion($idRequisicion);
         
        if($cancela_cxp_requi == true)
        {
          //--MGFS 27-01-2020 SE AGREGA VALIDACIÓN PARA QUE SI SE CANCELAN DE 1 POR UNA LAS PARTIDAS Y SE CANCELAN TODAS 
          //--SE CANCELE LA ORDEN EN GENERAL PARA QUE LIBERE LA REQUI ASIGNADA
          $veificaOc = "SELECT COUNT(id)AS partidas,SUM(IF(estatus='C',1,0)) as canceladas FROM orden_compra_d WHERE id_orden_compra=".$idOrdenCompra;
          $resultVOC = mysqli_query($this->link, $veificaOc) or die(mysqli_error());
          $rowV = mysqli_fetch_array($resultVOC);
          $totalPartidas = $rowV['partidas'];
          $partidasCanceladas = $rowV['canceladas'];

          if($totalPartidas == $partidasCanceladas)
          {

            $verifica = $this -> cancelarOden($idOrdenCompra); 

          }else{
            
            $verifica = true;
          }
        }else
          $verifica = false;

      }else
        $verifica = false;
        

      if($verifica == true)
        $this->link->query("commit;");
      else
        $this->link->query('rollback;');


      return $verifica;

    }

    function cancelarOden($idOrdenCompra)
    {
      $verifica = false;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $query = "UPDATE orden_compra SET estatus = 'C' WHERE id = $idOrdenCompra";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      $queryD = "UPDATE orden_compra_d SET estatus = 'C' WHERE id_orden_compra = $idOrdenCompra";
      $resultD = mysqli_query($this->link, $queryD) or die(mysqli_error());
      //--MGFS SI UNA ORDEN SE SANCELA SE CANCELAN LAS REQUIS CORRESPONDIENTES SE CAMBIA ESTATUS 2 AS 7(CANCELADA)
      //-->NJES November/11/2020 la requi se cambia a estas 2 para que aparezca al importar requisiciones y se pueda asignar a una nueva oc
      $queryRA = "UPDATE requisiciones SET estatus = '2', id_orden_compra='0', folio_orden_compra='0' WHERE id_orden_compra = $idOrdenCompra";
      $resultRA = mysqli_query($this->link, $queryRA) or die(mysqli_error());

      //-->NJES August/14/2020 cancelar los cxp de las requis de la orden de compra
      if($result)
      {
        $query_BC = "SELECT id FROM cxp 
        WHERE id_requisicion IN(SELECT GROUP_CONCAT(DISTINCT(id_requisicion)) AS id FROM orden_compra_d WHERE  id_orden_compra=$idOrdenCompra) 
        AND estatus!='C'";
        $result_BC = mysqli_query($this->link, $query_BC) or die(mysqli_error());
        $num = mysqli_num_rows($result_BC);
        
        if($num > 0)
        {
          while($row = mysqli_fetch_array($result_BC))
          {
            $idCXP = $row['id'];

            $actualiza = "UPDATE cxp SET estatus='C' WHERE id=".$idCXP; 
            $result2 = mysqli_query($this->link, $actualiza) or die(mysqli_error());
            if($result2)
              $verifica = true;
            else{
              $verifica = false;
              break;
            }
          }
        }else
          $verifica = true;
        
      }

      if($verifica == true)
        $this->link->query("commit;");
      else
        $this->link->query('rollback;');

      return $verifica;      

    }

    /**
      * Busca los datos de las ordenes de compra, que etan pendientes de entrar al almacen
      * 
      * @param int $idUnidadNegocio Muestra solo las ordenes de la unidad de negocio actual
      * @param int $idSucursal Muestra solos las ordenes de la sucursal a la que se tiene acceso 
      * MGFS se agrega campo tipo 0=activo fijo 1=gasto 2=Mantenimeinto 3=stock ' para ingresar en la recepcion de 
      * mercancias el no de economico de un vehiculo si el oc  es de tipo 2=MANTENIMIENTO
      **/ 
      function buscarOrdenCompraImportar($idUnidadNegocio,$idSucursal){

        //-->NJES Feb/13/2020 se obtiene id area, id_departamento de la orden compra para poder afectar presupuesto en algunos casos
        $result = $this->link->query("SELECT 
        s.id,
        s.tipo,
        s.concepto_tipo,
        s.folio,
        s.fecha,
        s.id_proveedor,
        s.requisiciones,
        s.ids_requisiciones,
        s.partidas,
        s.ordenado AS ordenado,
        SUM(s.entregado) AS entregado,
        IFNULL(f.no_economico,'') AS no_economico,
        b.nombre AS proveedor,
        s.id_area,
        s.id_departamento,
        s.fam_fletes,
        SUM(IF(f.b_anticipo=1,1,0)) AS b_anticipo
      FROM /* OBTENGO LA CANTIDAD ORDENADA */
        (SELECT 
          a.id,
          a.tipo,
          IF(a.tipo=1,'GASTO',IF(a.tipo=2,'MANTENIMIENTO',IF(a.tipo=3,'STOCK','ACTIVO_FIJO')))AS concepto_tipo,
          a.folio,
          a.fecha_pedido AS fecha,
          a.id_proveedor,
          a.requisiciones,
          a.ids_requisiciones,
          COUNT(DISTINCT(c.id)) AS partidas,
          IFNULL(SUM(c.cantidad),0) AS ordenado,
          0 AS entregado,
          a.id_area,
          a.id_departamento,
          SUM(IF(familias.id_familia_gasto=104,1,0)) AS fam_fletes
        FROM orden_compra a
        LEFT JOIN orden_compra_d c ON a.id=c.id_orden_compra AND c.estatus='I'
        LEFT JOIN productos ON c.id_producto = productos.id
        LEFT JOIN familias ON productos.id_familia = familias.id
        WHERE a.id_unidad_negocio=".$idUnidadNegocio." AND a.id_sucursal=".$idSucursal." AND a.estatus='I' 
        GROUP BY a.id
        UNION ALL /* OBTENGO LA CANTIDAD ENTREGADA(RECIBIDA) */
        SELECT 
          a.id,
          '' AS tipo,
          '' AS concepto_tipo,
          '' AS folio,
          '' AS fecha,
          0 AS id_proveedor,
          0 AS requisiciones,
          '' AS ids_requisiciones,
          0 AS partidas,
          0 AS ordenado,
          IFNULL(SUM(e.cantidad),0) AS entregado,
          a.id_area,
          a.id_departamento,
          SUM(IF(familias.id_familia_gasto=104,1,0)) AS fam_fletes
        FROM orden_compra a
        LEFT JOIN orden_compra_d c ON a.id=c.id_orden_compra AND c.estatus='I'
        LEFT JOIN almacen_d e ON a.id=e.id_oc AND c.id=e.id_oc_d AND e.estatus='A' AND e.cve_concepto='E01'
        LEFT JOIN productos ON c.id_producto = productos.id
        LEFT JOIN familias ON productos.id_familia = familias.id
        WHERE a.id_unidad_negocio=".$idUnidadNegocio." AND a.id_sucursal=".$idSucursal." AND a.estatus='I' 
        GROUP BY a.id) AS s
      LEFT JOIN requisiciones f ON f.id IN (s.ids_requisiciones)
      LEFT JOIN proveedores b ON s.id_proveedor=b.id	
      GROUP BY s.id	
      HAVING ordenado!=entregado");
    
        return query2json($result);
    }//-- fin function buscarOrdenCompraImportar

    /**
      * Busca las partidas de una orden de compra
      * 
      * @param int $idOrdenCompra de la orden de compra de la que se va a buscar el registro
      *
      **/ 
      function buscarOrdenCompraIdDetalleImportar($idOrdenCompra){
        //-->NJES November/11/2020 buscar el id_familia_gasto del producto de la orden de compra
        $result = $this->link->query("SELECT 
        orden_compra_d.id,
        orden_compra_d.id_producto,
        orden_compra_d.concepto,
        orden_compra_d.iva,
        orden_compra_d.porcentaje_descuento as descuento,
        orden_compra_d.importe,
        orden_compra_d.costo_unitario AS costo,
        (orden_compra_d.cantidad -IFNULL(SUM(almacen_d.cantidad),0))AS faltante,
        IFNULL(lineas.descripcion,'') AS linea,
        familias.tallas AS verifica_talla,
        IFNULL(familias.descripcion,'') AS familia,
        familias.id_familia_gasto,
        '' AS tallas
        FROM orden_compra_d
        LEFT JOIN almacen_d ON orden_compra_d.id_orden_compra=almacen_d.id_oc AND  orden_compra_d.id=almacen_d.id_oc_d AND almacen_d.cve_concepto='E01' AND orden_compra_d.id_producto=almacen_d.id_producto AND almacen_d.estatus='A'
        LEFT JOIN productos ON orden_compra_d.id_producto = productos.id
        LEFT JOIN lineas ON productos.id_linea = lineas.id
        LEFT JOIN familias ON productos.id_familia = familias.id
        WHERE orden_compra_d.id_orden_compra = ".$idOrdenCompra." AND orden_compra_d.estatus='I'
        GROUP BY orden_compra_d.id
        HAVING faltante > 0 ");

        return query2json($result);
    }//-- fin function buscarOrdenCompraIdDetalleImportar

    /**
     * 
     * Busca los datos de compras para formar reportes
     * @param varchar $datos array que contiene los datos de los fltros para hacer la Búsqueda de y el tipo de reporte
     * 
    **/
    function buscarOrdenCompraReportes($datos){
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
        $condicion=" AND orden_compra.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
      }else if($fechaInicio != '' &&  $fechaFin == '')
      {
        $condicion=" AND orden_compra.fecha_pedido >= '$fechaInicio' ";
      }else{  //-->trae fecha inicio y fecha fin
        $condicion=" AND DATE(orden_compra.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin' ";
      }

      if($idSucursal != NULL)
      {
        $sucursal=" AND orden_compra.id_sucursal=".$idSucursal;
      }else{
        $sucursal='';
      }

      if($idArea != NULL)
      {
        $area=" AND orden_compra.id_area=".$idArea;
      }else{
        $area='';
      }

      if($idDepartamento != NULL)
      {
        $departamento=" AND orden_compra.id_departamento=".$idDepartamento;
      }else{
        $departamento='';
      }
      
      if($idProveedor != NULL)
      {
        $proveedor=" AND orden_compra.id_proveedor=".$idProveedor;
      }else{
        $proveedor='';
      }

      if($tipoReporte == 'ordenCompraAgrupadas')
      {
        $query="SELECT 
                orden_compra.id,
                cat_unidades_negocio.nombre AS unidad,
                sucursales.descr AS sucursal,
                cat_areas.descripcion AS are,
                deptos.des_dep AS depto,
                orden_compra.folio AS folio,
                orden_compra.fecha_pedido AS fecha,
                IFNULL(orden_compra.usuario,'') AS solicito,
                proveedores.nombre AS proveedor,
                SUM(orden_compra_d.costo_total) AS importe_sin_iva,
                SUM((((orden_compra_d.costo_total/100)*orden_compra_d.iva)+orden_compra_d.costo_total)) AS importe_con_iva,
                IFNULL(requisiciones.monto_anticipo,0) AS monto_anticipo,
                IFNULL(cxpII.total,0) AS abonos_anticipo
                FROM orden_compra 
                LEFT JOIN orden_compra_d ON orden_compra.id=orden_compra_d.id_orden_compra
                LEFT JOIN cat_unidades_negocio ON orden_compra.id_unidad_negocio = cat_unidades_negocio.id
                LEFT JOIN sucursales ON orden_compra.id_sucursal = sucursales.id_sucursal
                LEFT JOIN cat_areas ON orden_compra.id_area = cat_areas.id
                LEFT JOIN deptos ON orden_compra.id_departamento = deptos.id_depto AND deptos.tipo='I'
                LEFT JOIN proveedores ON orden_compra.id_proveedor = proveedores.id
                LEFT JOIN 
                (
                  SELECT f.id,f.id_orden_compra,f.b_anticipo,SUM(f.monto_anticipo) AS monto_anticipo 
                  FROM requisiciones f
                  INNER JOIN cxp ON f.id=cxp.id_requisicion
                  WHERE cxp.estatus!='C'
                  GROUP BY f.id_orden_compra
                  
                ) AS requisiciones ON orden_compra.id = requisiciones.id_orden_compra

                LEFT JOIN
                (

                  SELECT rr.id_orden_compra AS idoc , SUM(yy.subtotal + yy.iva) AS total 
                  FROM cxp xx
                  INNER JOIN requisiciones rr ON xx.id_requisicion = rr.id
                  INNER JOIN cxp yy ON xx.id = yy.id_cxp  
                
                  WHERE yy.id_requisicion = 0 AND yy.estatus!='C'
                  GROUP BY rr.id_orden_compra

                ) AS cxpII ON orden_compra.id = cxpII.idoc
                WHERE orden_compra.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                GROUP BY orden_compra.id
                ORDER BY orden_compra.fecha_pedido";
      }

      if($tipoReporte == 'detalleCompras')
      {
        $query="SELECT 
                orden_compra_d.id,
                cat_unidades_negocio.nombre AS unidad,
                sucursales.descr AS sucursal,
                cat_areas.descripcion AS are,
                IFNULL(deptos.des_dep,'') AS depto,
                orden_compra.folio AS folio,
                orden_compra.fecha_pedido AS fecha,
                IFNULL(orden_compra.usuario,'') AS solicito,
                proveedores.nombre AS proveedor,
                orden_compra_d.num_partida,
                orden_compra_d.id_producto,
                orden_compra_d.clave_producto AS clave,
                IFNULL(lineas.descripcion,'') AS linea,
                IFNULL(familias.descripcion,'') AS familia,
                orden_compra_d.cantidad,
                orden_compra_d.concepto,
                orden_compra_d.descripcion,
                orden_compra_d.costo_unitario,
                IFNULL(orden_compra_d.porcentaje_descuento,0) AS descuento,
                ((orden_compra_d.costo_total/100)*orden_compra_d.iva) AS porcentaje_iva,
                orden_compra_d.costo_total AS importe_sin_iva,
                (((orden_compra_d.costo_total/100)*orden_compra_d.iva)+orden_compra_d.costo_total) AS importe_con_iva,
                IF(orden_compra.estatus='A','Activa',IF(orden_compra.estatus='I','Impresa',IF(orden_compra.estatus='C','Cancelada','Liquidada'))) AS estatus
                FROM orden_compra_d
                LEFT JOIN orden_compra ON orden_compra_d.id_orden_compra=orden_compra.id
                LEFT JOIN cat_unidades_negocio ON orden_compra.id_unidad_negocio = cat_unidades_negocio.id
                LEFT JOIN sucursales ON orden_compra.id_sucursal = sucursales.id_sucursal
                LEFT JOIN cat_areas ON orden_compra.id_area = cat_areas.id
                LEFT JOIN deptos ON orden_compra.id_departamento = deptos.id_depto AND deptos.tipo='I'
                LEFT JOIN proveedores ON orden_compra.id_proveedor = proveedores.id
                LEFT JOIN productos ON orden_compra_d.id_producto = productos.id
                LEFT JOIN lineas ON productos.id_linea = lineas.id
                LEFT JOIN familias ON productos.id_familia = familias.id
                WHERE orden_compra.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                ORDER BY orden_compra.fecha_pedido";
      }

      if($tipoReporte == 'backorderCompras')
      {
        $query="SELECT 
                orden_compra_d.id,
                cat_unidades_negocio.nombre AS unidad,
                sucursales.descr AS sucursal,
                cat_areas.descripcion AS are,
                IFNULL(deptos.des_dep,'') AS depto,
                orden_compra.folio AS folio,
                orden_compra.fecha_pedido AS fecha,
                IFNULL(orden_compra.usuario,'') AS solicito,
                proveedores.nombre AS proveedor,
                orden_compra_d.num_partida,
                orden_compra_d.id_producto,
                orden_compra_d.clave_producto AS clave,
                IFNULL(lineas.descripcion,'') AS linea,
                IFNULL(familias.descripcion,'') AS familia,
                (orden_compra_d.cantidad - orden_compra_d.cantidad_entrega) AS cantidad,
                orden_compra_d.concepto,
                orden_compra_d.descripcion,
                orden_compra_d.costo_unitario,
                IFNULL(orden_compra_d.porcentaje_descuento,0) AS descuento,
                ((((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario))/100)*orden_compra_d.iva) AS porcentaje_iva,
                ((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario)) AS importe_sin_iva,
                (((((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario))/100)*orden_compra_d.iva)+((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario))) AS importe_con_iva
                FROM orden_compra_d
                LEFT JOIN orden_compra ON orden_compra_d.id_orden_compra=orden_compra.id
                LEFT JOIN cat_unidades_negocio ON orden_compra.id_unidad_negocio = cat_unidades_negocio.id
                LEFT JOIN sucursales ON orden_compra.id_sucursal = sucursales.id_sucursal
                LEFT JOIN cat_areas ON orden_compra.id_area = cat_areas.id
                LEFT JOIN deptos ON orden_compra.id_departamento = deptos.id_depto  AND deptos.tipo='I'
                LEFT JOIN proveedores ON orden_compra.id_proveedor = proveedores.id
                LEFT JOIN productos ON orden_compra_d.id_producto = productos.id
                LEFT JOIN lineas ON productos.id_linea = lineas.id
                LEFT JOIN familias ON productos.id_familia = familias.id
                WHERE orden_compra.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                HAVING cantidad > 0
                ORDER BY orden_compra.fecha_pedido";
      }

      $result = $this->link->query($query);

      return query2json($result);
    }//-- fin function buscarOrdenCompraReportes


    function imprimirOden($idOrden)
    {

      $verifica = 0;

      $query = "UPDATE orden_compra SET estatus = 'I', impresa='1' WHERE id = $idOrden";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      $queryD = "UPDATE orden_compra_d SET estatus = 'I' WHERE id_orden_compra = $idOrden";
      $resultD = mysqli_query($this->link, $queryD) or die(mysqli_error());
      if($result)
        $verifica = 1;

      return $verifica;      

    }
    /**
     * MUESTRA EL NUMERO DE REQUIS REALCIONADAS A UNA OC QUE TIENEN ANTICIPOS PARA SABER SI SE PUEDE CANCELAR O NO 
     */
    function buscarOrdenCompraRequisAnticipos($idOrdenCompra){
      $verifica = 0;

      /*$query = "SELECT  COUNT(a.id) AS requis_con_anticipos
                FROM requisiciones a
                WHERE a.id =ANY (SELECT id_requisicion AS id FROM orden_compra_d WHERE  id_orden_compra=".$idOrdenCompra.") AND b_anticipo=1";*/

      $query = "SELECT  COUNT(a.id) AS requis_con_anticipos,COUNT(cxp.abonos) AS abonos
                FROM requisiciones a
                LEFT JOIN (
                  SELECT COUNT(b.id) AS abonos,a.id_requisicion,a.id
                  FROM cxp a
                  LEFT JOIN cxp b ON a.id=b.id_cxp 
                  WHERE a.id_requisicion=ANY(SELECT id_requisicion AS id FROM orden_compra_d WHERE  id_orden_compra=".$idOrdenCompra.") 
                  AND b.id!=b.id_cxp AND b.estatus!='C'
                ) AS cxp ON a.id=cxp.id_requisicion
                WHERE a.id =ANY (SELECT id_requisicion AS id FROM orden_compra_d WHERE  id_orden_compra=".$idOrdenCompra.") AND b_anticipo=1";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
      $rows = mysqli_num_rows($result);
      if($rows>0){
        $row = mysqli_fetch_array($result);
        //$verifica = $row['requis_con_anticipos'];  
        $verifica = $row['abonos'];  
      }

      return $verifica;

    }

}//--fin de class OrdenCompra
    
?>