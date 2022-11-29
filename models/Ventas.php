<?php

require_once('conectar.php');
require_once('../widgets/VerificarPermiso.php');
require_once('MovimientosPresupuesto.php');

class Ventas
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function __construct()
    {
  
      $this->link = Conectarse();

    }


    /**
      * Manda llamar a la funcion que guarda la informacion sobre una venta
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una venta en particular
      * @param varchar $descripcion brebe descripcion de una venta
      * @param int $inactiva estatus de una venta  1='Activa' 0='Inactiva'  
      *
    **/      
    function guardarVentas($datos){
    
        $verifica = 0;

      
        $verifica = $this -> guardarActualizar($datos);


        return $verifica;

    } //-- fin function guardarVentas


     /**
      * Guarda los datos de una venta, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del venta para realizarla
      * @param varchar $clave es una clave para identificar una venta en particular
      * @param varchar $descripcion brebe descripcion de una venta
      * @param int $inactiva estatus de una venta  1='Activa' 0='Inactiva'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;
    
        $idVenta = $datos['idVenta'];
        $tipo_mov = $datos['tipo_mov'];
        $idUnidad = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idCliente = $datos['idCliente'];
        $facturar = $datos['facturar'];
        $cotizacion = $datos['cotizacion'];

        $porcentajeIva = $datos['porcentajeIva'];
        $subtotal = $datos['subtotal'];
        $iva = $datos['iva'];
        $total = $datos['total']; 

        $porcentajeDescuento = $datos['porcentajeDescuento'];
        $descuento = (isset($datos['descuento'])!='')? $datos['descuento'] : 0 ;

        $idUsuario = $datos['idUsuario'];
        $fecha = $datos['fecha'];
        $detalle = $datos['detalle'];

        $idCxC = 0;
        $idConcepto = 8;
        $cveConcepto = 'C01';
        $cargoInicial = 1;
        $estatusCxc='A';
        $mes = $datos['mes'];
        $anio = $datos['anio']; 

        $costoInstalacion = $datos['costoInstalacion'];
        $costoAdmin = $datos['costoAdmin']; 
        $comisionVenta = $datos['comisionVenta'];
        $costoTotal = $datos['costoTotal'];

        $cliente = $datos['cliente'];
        $observaciones = $datos['observaciones'];

        $idCotizacion = $datos['idVenta'];

        $tipoCotizacion = $datos['tipoCotizacion'];

        $vendedor = $datos['vendedor'];

        //-->NJES November/04/2020 enviar parametro id sucursal y no id unidad
        if($cotizacion==1){
          if($tipo_mov == 0)
            $folio = $this->obtenerFolioCotizacion($idSucursal) + 1;
          else
            $folio = $datos['folio'];
         
        }else{
          $folio = $this->obtenerFolioVenta($idSucursal) + 1;
          $cliente = '';
          $observaciones = '';
        }

        if($tipo_mov == 0)
        {
          $query = "INSERT INTO notas_e(cotizacion,folio,id_sucursal,id_cliente,facturar,descuento,porcentaje_iva,subtotal,iva,total,id_usuario_captura,costo_instalacion,costo_administrativo,comision_venta,costo_total,cliente_cotizacion,observaciones_cotizacion,id_cotizacion,tipo_cotizacion,vendedor) 
                    VALUES ('$cotizacion','$folio','$idSucursal','$idCliente','$facturar','$descuento','$porcentajeIva','$subtotal','$iva','$total','$idUsuario','$costoInstalacion','$costoAdmin','$comisionVenta','$costoTotal','$cliente','$observaciones','$idCotizacion','$tipoCotizacion','$vendedor')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idVenta = mysqli_insert_id($this->link);
        }else{
          //-->cuando es una edicion no liga la cotizacion con una venta porque se estaria ligando con su mima cotizacion, 
          //ademas las cotizaciones solo se pueden editar mienstras no se hayan convertido (ligado) a ventas
          $query = "UPDATE  notas_e 
                    SET cotizacion='$cotizacion',folio='$folio',id_sucursal='$idSucursal',id_cliente='$idCliente',facturar='$facturar',descuento='$descuento',porcentaje_iva='$porcentajeIva',subtotal='$subtotal',iva='$iva',total='$total',id_usuario_captura='$idUsuario',costo_instalacion='$costoInstalacion',costo_administrativo='$costoAdmin',comision_venta='$comisionVenta',costo_total='$costoTotal',cliente_cotizacion='$cliente',observaciones_cotizacion='$observaciones',tipo_cotizacion='$tipoCotizacion',vendedor='$vendedor'
                    WHERE id=$idVenta";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
        }
      
        
        if ($result){

          if($cotizacion==0){
          
            $queryC = "INSERT INTO cxc(id_unidad_negocio,id_sucursal,folio_cxc,fecha,id_concepto,cve_concepto,descuento,tasa_iva,subtotal,iva,total,referencia,mes,anio,cargo_inicial,estatus,usuario_captura,id_razon_social_servicio,id_venta,folio_venta,facturar) 
            VALUES ('$idUnidad','$idSucursal','$idCxC','$fecha','$idConcepto','$cveConcepto',$descuento,'$porcentajeIva','$subtotal','$iva','$total','$idVenta','$mes','$anio','$cargoInicial','$estatusCxc','$idUsuario','$idCliente','$idVenta','$folio','$facturar')";
            $resultC = mysqli_query($this->link, $queryC) or die(mysqli_error());
            $idCxc = mysqli_insert_id($this->link);

            if ($resultC) 
            {  
    
                  $queryU = "UPDATE cxc SET folio_cxc='$idCxc' WHERE id=".$idCxc;
                  $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
                  if($resultU){
                    $this->actualizarFolioVentas($idSucursal, $folio);
                    $verifica = $this -> guardarDetalle($idVenta,$detalle,$cotizacion); 

                  }else{

                    echo 0;
                  }
                

            }else{

              $verifica = 0;
            }

        }else{//---cotizacion---
          //-->NJES November/04/2020 solo cuando es nuevo registro actualizar folio
          if($tipo_mov == 0)
            $this->actualizarFolioCotizacion($idSucursal, $folio);

          $verifica = $this -> guardarDetalle($idVenta,$detalle,$cotizacion); 
        }

        }else{//--result

          $verifica = 0;
        }  
     
          

        
        return $verifica;
    }

     /**
      * Obtiene el folio actual de las ventas
      *
      * @param int $idUnidad
      *
      **/ 
      function obtenerFolioVenta($idSucursal)
      {
  
        $result = mysqli_query($this->link, "SELECT folio_ventas FROM sucursales WHERE id_sucursal = $idSucursal");
        $row = mysqli_fetch_assoc($result);
     
        return $row['folio_ventas'];
      }
  
  
      /**
        * Actualiza el folio actual de las ventas
        *
        * @param int $idSucursal
        * @param int $folio
        *
        **/
      function actualizarFolioVentas($idSucursal, $folio)
      {
        $result = mysqli_query($this->link, "UPDATE sucursales SET folio_ventas = $folio WHERE id_sucursal = $idSucursal");
      }

        /**
      * Guarda los datos de una venta, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $idProducto id del producto de la venta
      * @param varchar $claveProducto clave del producto
      * @param text $producto nombre del producto 
      * @param int $cantidad cantidad a vender
      * @param double $precio del producto 
      *
      **/ 
      function guardarDetalle($idVenta,$detalle,$cotizacion){
          
        $verifica = 0;

        $queryBorra = "DELETE FROM notas_d WHERE id_nota_e=".$idVenta;
        $result = mysqli_query($this->link, $queryBorra) or die(mysqli_error());

        for($i=1;$i<=$detalle[0];$i++){
          
          $idProducto = $detalle[$i]['idProducto'];
          $claveProducto = $detalle[$i]['claveProducto'];
          $producto = $detalle[$i]['producto'];
          $cantidad = $detalle[$i]['cantidad'];
          $precio = $detalle[$i]['precio'];
          
          $queryD = "INSERT INTO notas_d(id_nota_e,id_producto,clave,producto,cantidad,precio) VALUES ('$idVenta','$idProducto','$claveProducto','$producto','$cantidad','$precio')";
          $resultD = mysqli_query($this->link, $queryD) or die(mysqli_error());
                   
          if ($resultD){

              if($i==$detalle[0]){

                 $verifica = $idVenta;

              }
          }else{

            $verifica = 0;
            break;
          }  
          
        }
        
        return $verifica;
    }

    
    /**
      * Busca los datos de una venta, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activa 0=inactiva 2=todos
      *
      **///--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
      function buscarVentas($cotizacion,$fechaInicio,$fechaFin,$idCliente,$idSucursal){
        
        $condCotizacion="WHERE a.cotizacion=".$cotizacion;

        $condFecha = '';

        if($fechaInicio == '' && $fechaFin == '')
        {
            $condFecha=" AND a.fecha_captura >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condFecha=" AND a.fecha_captura >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
            $condFecha=" AND  DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }
       
        $condCliente='';

        if( $idCliente > 0 ){
          $condCliente=" AND  a.id_cliente=".$idCliente;
        }

        if($idSucursal != '')  //-->No tengo sucursales con permisos en la unidad entonces debo regresar un array vacio
        {
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }
        }  

        $resultado = $this->link->query("SELECT 
                          a.id,
                          a.folio,
                          a.cotizacion,
                          a.id_sucursal,
                          a.id_cliente,
                          DATE(a.fecha_captura) AS fecha,
                          a.total,
                          a.estatus,
                          a.costo_instalacion,
                          a.costo_administrativo,
                          a.comision_venta,
                          a.costo_total,
                          b.descr AS sucursal,
                          IFNULL(c.nombre_corto,'') AS nombre_corto,
                          TRIM(IF(a.id_cliente=0,a.cliente_cotizacion,c.nombre_corto)) AS cliente,
                          IFNULL(c.razon_social,'') AS razon_social,
                          IFNULL(d.folio,'') AS folio_cotizacion,
                          IFNULL(f.id, 0) AS id_venta,
                          a.vendedor
                      FROM notas_e a
                      LEFT JOIN sucursales b ON a.id_sucursal=b.id_sucursal
                      LEFT JOIN servicios c ON a.id_cliente=c.id
                      LEFT JOIN notas_e d ON a.id_cotizacion=d.id
                      LEFT JOIN notas_e f ON a.id = f.id_cotizacion
                      $condCotizacion $condFecha $condCliente $sucursal
                      GROUP BY a.id
                      ORDER BY a.id DESC");
                      return query2json($resultado);

      }//- fin function buscarVentas

      function buscarVentasId($idVenta,$idSucursal,$idUnidadNegocio){
        //-->NJES May/18/2020 validar permiso para cancelar ventas de meses anteriores
        $permisoModel = new VerificarPermiso();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta

        $idUsuario = $_SESSION['id_usuario'];

        $permisoCancelarAnteriores = $permisoModel -> buscarPermisosBotones($idUsuario,'CANCELAR_VENTAS_ANTERIORES',0,$idSucursal,$idUnidadNegocio);

        if($permisoCancelarAnteriores == 0){
          $condicion = "IF(a.estatus='C','no',IF(MONTH(a.fecha_captura)=MONTH(CURDATE()),IF(a.total=IFNULL(SUM(IF(e.estatus NOT IN('C','P'),IF((SUBSTR(e.cve_concepto,1,1) = 'C'),(e.subtotal + e.iva - a.descuento),((e.subtotal + e.iva - a.descuento) * -(1))),0)),0),'si','no'),'no')) AS cancelar,";
        }else{
          $condicion = "IF(a.estatus='C','no',IF(a.total=IFNULL(SUM(IF(e.estatus NOT IN('C','P'),IF((SUBSTR(e.cve_concepto,1,1) = 'C'),(e.subtotal + e.iva - a.descuento),((e.subtotal + e.iva - a.descuento) * -(1))),0)),0),'si','no')) AS cancelar,";
        }

        $resultado = $this->link->query("SELECT 
        a.id,
        a.folio,
        a.cotizacion,
        a.id_usuario_captura,
        a.id_sucursal,
        a.id_cliente,
        a.porcentaje_iva,
        a.facturar,
        DATE(a.fecha_captura) AS fecha,
        a.descuento,
        a.subtotal,
        a.iva,
        a.total,
        a.estatus,
        a.costo_instalacion,
        a.costo_administrativo,
        a.comision_venta,
        a.costo_total,
        TRIM(IF(a.id_cliente=0,a.cliente_cotizacion,c.nombre_corto)) AS cliente,
        IFNULL(c.razon_social,'') AS razon_social,
        a.observaciones_cotizacion,
        $condicion
        d.id AS id_cxc,
        IFNULL(f.folio,'') AS folio_cotizacion,
        a.tipo_cotizacion,
        IFNULL(g.id_cotizacion,0) AS id_cotizacion,
        IFNULL(g.id, 0) AS id_venta,
        a.vendedor
        FROM notas_e a
        LEFT JOIN servicios c ON a.id_cliente=c.id
        LEFT JOIN cxc d ON a.id=d.id_venta
        LEFT JOIN cxc e ON d.id=e.folio_cxc
        LEFT JOIN notas_e f ON a.id_cotizacion=f.id
        LEFT JOIN notas_e g ON a.id=g.id_cotizacion
        WHERE a.id=$idVenta
        ORDER BY a.id");
        return query2json($resultado);
      }//- fin function buscarVentasId


      function buscarVentasDetalle($idVenta){
        /*$resultado = $this->link->query("SELECT a.id_producto,a.clave as clave_producto,a.producto,a.cantidad,a.precio,(a.cantidad*a.precio)AS importe,c.id_familia_gasto
        FROM notas_d a
        LEFT JOIN productos b ON a.id_producto=b.id
        LEFT JOIN familias c ON b.id_familia=c.id
        WHERE a.id_nota_e=".$idVenta."
        ORDER BY a.id");*/
        //NJES Jan/16/2020 buscar la existencia de las partidas de los productos de las ventas
        //-->NJES Feb/20/2020 se calcula el descuento prorrateado por partida

        $query = "SELECT a.id_producto,a.clave AS clave_producto,a.producto,a.cantidad,a.precio,(a.cantidad*a.precio)AS importe,c.id_familia_gasto,
                  IFNULL(SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),0) AS existencia,b.servicio,
                  b.descripcion,
                  d.descuento AS descuento_venta,
                  (d.descuento*100)/d.subtotal AS porcentaje_desc,
                  ((a.cantidad*a.precio)*((d.descuento*100)/d.subtotal))/100 AS descuento
                  FROM notas_d a
                  LEFT JOIN productos b ON a.id_producto=b.id
                  LEFT JOIN familias c ON b.id_familia=c.id
                  LEFT JOIN notas_e d ON a.id_nota_e=d.id
                  INNER JOIN productos_unidades ON b.id = productos_unidades.id_producto
                  LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=d.id_sucursal AND almacen_e.estatus!='C'
                  LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = b.id
                  WHERE a.id_nota_e=".$idVenta."
                  GROUP BY a.id
                  ORDER BY a.id";

        // echo $query;
        // exit();

        $resultado = $this->link->query($query);
        return query2json($resultado);
          

      }//- fin function buscarVentasId
    

      function cancelarVentas($idVenta,$tipoR,$idUsuario){
    
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        if($tipoR==1){//--CANCELA COTIZACION-----
          
          $cancelaC = mysqli_query($this->link, "UPDATE notas_e SET estatus = 'C' WHERE id = $idVenta");

          if($cancelaC > 0)
            $verifica  = $this -> insertaBitacoraCancelar($idVenta,$idUsuario);

        }else{//--CANCELA VENTAS-----

          $calcelaV = $this -> cancelarVentasAlamcenCXC($idVenta);

          if($calcelaV > 0)
            $verifica  = $this -> insertaBitacoraCancelar($idVenta,$idUsuario);
        }
      
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarUsuarios

    //-->NJES February/17/2021 generar bitacora con usuario y timestamp al cancelar venta o cotizacion en alarmas
    function insertaBitacoraCancelar($idRegistro,$idUsuario){
      $verifica = 0;

      $query = "INSERT INTO notas_e_bitacora_cancelacion (id_usuario,id_nota_e) 
                VALUES('$idUsuario','$idRegistro')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
                   
      if($result)
        $verifica = 1;

      return $verifica;
    }


      function cancelarVentasAlamcenCXC($idVenta){
        // error_reporting(E_ALL);

        $verificar=0;

        $resultVenta = mysqli_query($this->link, "UPDATE notas_e SET estatus = 'C' WHERE id = $idVenta");
        
        if($resultVenta){

          //->NJES August/07/2020 busca si la venta tiene productos diferentes de servicio ya que los servicios no generan
          //salida de almacen, y para que me permita cancelar la venta y el cxc sin tratar de hacer movimientos en almacen
          $queryP = "SELECT COUNT(notas_d.id_producto) AS num_productos
                      FROM notas_d
                      LEFT JOIN productos ON notas_d.id_producto=productos.id
                      WHERE notas_d.id_nota_e=$idVenta AND productos.servicio=0";
          $resultP = mysqli_query($this->link,$queryP);
          $datoP=mysqli_fetch_array($resultP);
          $num_productos = $datoP['num_productos'];

          // verificando aqui
          if((int)$num_productos > 0)
          {

            $buscaIdAlmacenD = "SELECT id FROM almacen_e WHERE id_venta=".$idVenta;
            $resultIdD = mysqli_query($this->link,$buscaIdAlmacenD);
            $rowsD = mysqli_num_rows($resultIdD);
            if($rowsD>0){

              $datoD=mysqli_fetch_array($resultIdD);
              $idAlmacenD = $datoD['id'];

              $resultAlmacenD = mysqli_query($this->link, "UPDATE almacen_d SET estatus = 'C' WHERE id_almacen_e = $idAlmacenD");
              
              if($resultAlmacenD){

                $resultAlmacen = mysqli_query($this->link, "UPDATE almacen_e SET estatus = 'C' WHERE id_venta = $idVenta");
            
                if($resultAlmacen){
                  
                  $resultcxc = mysqli_query($this->link, "UPDATE cxc SET estatus = 'C' WHERE id_venta = $idVenta");
                  
                  if($resultcxc){
                    $resultMP = 0;
                    //$resultMP = mysqli_query($this->link, "UPDATE movimientos_presupuesto SET estatus = 'C' WHERE id_almacen_d IN ( SELECT id FROM almacen_d  WHERE id_almacen_e = $idAlmacenD )");

                    //-->NJES June/22/2020 como se cancelo la venta, afectar movimientos presupuesto con monto negativo
                    // ya que al verificar el presupuesto en requisiciones no se toma en cuenta el estatus de los movimientos presupuestos, 
                    // ni en los reportes de seqimiento presupuesto egresos

                    //-->buscamos los id de las partidas de almacen_d (detalle) del almacen_e 
                    //para buscar los registros de movimientos presupuestos y poder generar registros con montos negativos
                    $busca_ids = "SELECT GROUP_CONCAT(id) AS id FROM almacen_d  WHERE id_almacen_e =".$idAlmacenD;
                    $result_ids = mysqli_query($this->link,$busca_ids);
                    $dato_ids=mysqli_fetch_array($result_ids);
                    $idsD = $dato_ids['id'];

                    $buscaDatos = "SELECT id_almacen_d,monto,id_unidad_negocio,id_sucursal,id_familia_gasto,id_clasificacion 
                                  FROM movimientos_presupuesto WHERE id_almacen_d IN ($idsD)";
                    $resultDatos = mysqli_query($this->link, $buscaDatos) or die(mysqli_error());
                    $num=mysqli_num_rows($resultDatos);
                    
                    if($num > 0)
                    {
                      for ($i=1; $i <=$num ; $i++) { 
                        $row=mysqli_fetch_array($resultDatos);

                        $idAlmacenC = $row['id_almacen_d'];
                        $idUnidadNegocio = $row['id_unidad_negocio'];
                        $idSucursal = $row['id_sucursal'];
                        $idFamiliaGasto = $row['id_familia_gasto'];
                        $idClasificacion = $row['id_clasificacion'];
                        $importe = $row['monto'];
                        $importeC = $importe*(-1);

                        $arr = array('idAlmacenD'=>$idAlmacenC,
                              'total'=>$importeC,
                              'idUnidadNegocio'=>$idUnidadNegocio,
                              'idSucursal'=>$idSucursal,
                              'idFamiliaGasto'=>$idFamiliaGasto,
                              'clasificacionGasto'=>$idClasificacion,
                              'tipo'=>'C'
                            );

                        $afectarPresupuesto = new MovimientosPresupuesto();

                        $movP = $afectarPresupuesto->guardarMovimientoPresupuesto($arr);
                        
                        if($movP > 0)
                          $resultMP = 1;
                        else{
                          $resultMP = 0;
                          break;
                        }
                        
                      }
                    }else{
                      //GCM - 2022-05-17 Se le agrega el return 1 por que no estaba cancelando ventas cuando no tenian movimientos en presup.
                      return 1;
                    }
                  
                    if($resultMP > 0){
                    
                      $verifica = 1;

                    }else{//--$resultcxc
                      
                      $verifica = 0;
                    }

                  }else{//--$resultcxc
                    
                    $verifica = 0;
                  }

                }else{//--$resultAlmacen
                  $verifica = 0;
                }

              }else{//--$resultAlmacenD
                $verifica = 0;
              }

            }else{//--si no encuentra registros en almacen d

              $verifica = 0;

            }
          }else{
            $resultcxc = mysqli_query($this->link, "UPDATE cxc SET estatus = 'C' WHERE id_venta = $idVenta");
            if($resultcxc)
              $verifica = 1;
            else
              $verifica = 0;

          }

        }else{//--$resultVenta
          $verifica = 0;
        }
        
        return $verifica;

      }//- fin function cancelarVentas


       /**
      * Obtiene el folio actual de las ventas
      *
      * @param int $idSucursal
      *
      **/ 
      function obtenerFolioCotizacion($idSucursal)
      {
  
        $result = mysqli_query($this->link, "SELECT folio_cotizacion_alarmas as folio_cotizacion FROM sucursales WHERE id_sucursal = $idSucursal");
        $row = mysqli_fetch_assoc($result);
     
        return $row['folio_cotizacion'];
      }

      /**
        * Actualiza el folio actual de las ctizacion venta
        *
        * @param int $idSucursal
        * @param int $folio
        *
        **/
        function actualizarFolioCotizacion($idSucursal, $folio)
        {
          $result = mysqli_query($this->link, "UPDATE sucursales SET folio_cotizacion_alarmas = $folio WHERE id_sucursal = $idSucursal");
        }

        function buscaProductosDistintos($idCotizacion){
  
          $resultado = $this->link->query("SELECT 
          s.id_producto,
          s.clave,
          s.producto,
          s.requerido,
          SUM(s.existencia) AS existencia,
          IF(s.requerido>SUM(s.existencia),'no','si')AS completa
        FROM 
          (SELECT 
            DISTINCT(a.id_producto) AS id_producto,
            a.clave,
            a.producto,
            SUM(a.cantidad) AS requerido,
            0 existencia
          FROM notas_d a
          LEFT JOIN productos b ON a.id_producto=b.id
          WHERE id_nota_e=".$idCotizacion." AND b.servicio=0
          GROUP BY id_producto
          UNION ALL
          SELECT 
            DISTINCT(a.id_producto) AS id_producto,
            '' AS clave,
            '' AS producto,
            0 AS requerido,
            IFNULL(SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),0) AS existencia
          FROM notas_d a
          LEFT JOIN productos b ON a.id_producto=b.id
          LEFT JOIN familias c ON b.id_familia=c.id
          LEFT JOIN notas_e d ON a.id_nota_e=d.id
          INNER JOIN productos_unidades ON b.id = productos_unidades.id_producto
          LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=d.id_sucursal AND almacen_e.estatus!='C'
          LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = b.id
          WHERE a.id_nota_e=".$idCotizacion." AND b.servicio=0
          GROUP BY a.id) s
        GROUP BY s.id_producto
        HAVING completa='no'");
          return query2json($resultado);
        }


        function buscaProductoExistencia($idProducto,$idCotizacion){
  
          $buscaExistencia="SELECT 
                            s.id_producto,
                            s.clave,
                            s.producto,
                            s.requerido,
                            SUM(s.existencia) AS existencia,
                            IF(s.requerido>SUM(s.existencia),'no','si')AS completa
                          FROM 
                            (SELECT 
                              DISTINCT(a.id_producto) AS id_producto,
                              a.clave,
                              a.producto,
                              SUM(a.cantidad) AS requerido,
                              0 existencia
                            FROM notas_d a
                            LEFT JOIN productos b ON a.id_producto=b.id
                            WHERE id_nota_e=".$idCotizacion." AND a.id_producto=".$idProducto." AND b.servicio=0
                            GROUP BY id_producto
                            UNION ALL
                            SELECT 
                              DISTINCT(a.id_producto) AS id_producto,
                              '' AS clave,
                              '' AS producto,
                              0 AS requerido,
                              IFNULL(SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),0) AS existencia
                            FROM notas_d a
                            LEFT JOIN productos b ON a.id_producto=b.id
                            LEFT JOIN familias c ON b.id_familia=c.id
                            LEFT JOIN notas_e d ON a.id_nota_e=d.id
                            INNER JOIN productos_unidades ON b.id = productos_unidades.id_producto
                            LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=d.id_sucursal AND almacen_e.estatus!='C'
                            LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = b.id
                            WHERE a.id_nota_e=".$idCotizacion." AND a.id_producto=".$idProducto." AND b.servicio=0
                            GROUP BY a.id) s
                          GROUP BY s.id_producto
                          HAVING completa='no'";
         
          $result = mysqli_query($this->link,$buscaExistencia);
          $numR = mysqli_num_rows($result);
          return $numR;
        }
  
 

    
}//--fin de class Ventas
    
?>