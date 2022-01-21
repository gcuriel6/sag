<?php

require_once('conectar.php');
require_once('CFDIDenken.php');

class Pedidos
{

    public $link;
    public $idUnidadNegocio;
    public $idSucursal;

    function Pedidos()
    {
  
      $this->link = Conectarse();
      $this->idUnidadNegocio = 3;
      $this->idSucursal = 24;

    }

    function buscarProductos($idUnidad)
    {

      $resultado = $this->link->query("
        SELECT
          productos.id AS id,
          productos.clave AS clave_producto,
          productos.concepto AS concepto,
          productos.descripcion AS descripcion_producto,
          productos.id_familia AS id_familia,
          familias.descripcion AS familia,
          productos.id_linea AS id_linea,
          lineas.descripcion AS linea,
          productos.costo as precio,
          almacen_d.precio AS precio_ea,
          SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia 
          FROM productos
          INNER JOIN familias ON productos.id_familia = familias.id
          INNER JOIN lineas ON productos.id_linea = lineas.id
          INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
          INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
          WHERE almacen_e.id_unidad_negocio  = $idUnidad 
          GROUP BY productos.id");

      return query2json($resultado);

    } 

    function buscarPedidosAlmacen()
    {

      $resultado = $this->link->query("
        SELECT 
        pedidos.id AS id_pedido,
        pedidos.id_cliente AS id_cliente,
        cat_clientes.nombre_comercial AS cliente,
        pedidos.id_razon_social AS id_razon_social,
        razones_sociales.razon_social AS razon_social,
        pedidos.fecha_captura AS fecha,
        pedidos.subtotal AS subtotal,
        pedidos.iva AS iva,
        pedidos.total AS total,
        almacen_e.id AS id_almacen,
        almacen_e.folio AS folio_almacen,
        almacen_e.cve_concepto AS clave_concepto,
        conceptos_almacen.concepto AS concepto
        FROM pedidos
        INNER JOIN cat_clientes ON pedidos.id_cliente = cat_clientes.id
        INNER JOIN razones_sociales ON pedidos.id_razon_social = razones_sociales.id
        INNER JOIN almacen_e ON pedidos.id = almacen_e.id_pedido
        INNER JOIN conceptos_almacen ON almacen_e.cve_concepto = conceptos_almacen.clave");

      return query2json($resultado);

    } 

    function buscarProductoTer()
    {

      $resultado = $this->link->query("
        SELECT 
          facturas.folio AS folio_factura,
          facturas.fecha AS fecha,
          facturas_d.cantidad AS total_producto,
          facturas_d.descripcion AS producto
          FROM facturas_d
          INNER JOIN facturas ON facturas_d.id_factura = facturas.id
          WHERE facturas.id_unidad_negocio = 3
          GROUP BY facturas_d.descripcion");

      return query2json($resultado);

    } 

    function buscarPedidosReal()
    {

      $resultado = $this->link->query("
        SELECT
          pedidos_d.id_producto AS id_producto,
          productos.clave AS clave_producto,
          productos.concepto AS concepto,
          SUM(pedidos_d.m_real) AS m_real,
          lineas.descripcion AS linea,
          familias.descripcion AS fam
          FROM pedidos_d
          INNER JOIN productos ON pedidos_d.id_producto = productos.id
          INNER JOIN familias  ON productos.id_familia = familias.id
          INNER JOIN lineas ON productos.id_linea = lineas.id
          GROUP BY pedidos_d.id_producto");

      return query2json($resultado);

    } 

    function buscarTiposImpresion()
    {

      $resultado = $this->link->query("
        SELECT
        id, descripcion from tipos_impresion");

      return query2json($resultado);

    }

    function buscarClientes($idUnidad)
    {

      $resultado = $this->link->query("
       SELECT
        cat_clientes.id AS id_cliente, 
        cat_clientes.nombre_comercial AS cliente,
        razones_sociales.id AS id_razon_social,
        razones_sociales.rfc AS rfc,
        razones_sociales.nombre_corto,
        razones_sociales.razon_social  
        FROM 
        razones_sociales
        INNER JOIN cat_clientes ON razones_sociales.id_cliente = cat_clientes.id
        INNER JOIN razones_sociales_unidades ON  razones_sociales.id = razones_sociales_unidades.id_razon_social

        WHERE razones_sociales_unidades.id_unidad = $idUnidad");

      return query2json($resultado);

    }

    function buscarPedidos($idPedido)
    {

      $condicion = "";  
      if($idPedido > 0)
        $condicion = "WHERE pedidos.id = $idPedido";

      $resultado = $this->link->query("
       
        SELECT
        pedidos.id,
        pedidos.id_cliente,
        pedidos.id_razon_social,
        pedidos.total,
        pedidos.iva,
        pedidos.fecha,
        pedidos.subtotal,
        pedidos.vendedor,
        pedidos.estatus,
        pedidos.instrucciones_empaque,
        pedidos.folio,
        cat_clientes.nombre_comercial AS cliente,
        razones_sociales.rfc,
        razones_sociales.nombre_corto,
        razones_sociales.razon_social,

        pedidos.fecha_impresion,
        pedidos.fecha_envio,
        pedidos.paqueteria,
        pedidos.guias,
        pedidos.datos_recepcion,
        pedidos.tipo

        FROM pedidos
        INNER JOIN cat_clientes ON pedidos.id_cliente = cat_clientes.id
        INNER JOIN razones_sociales ON pedidos.id_razon_social=razones_sociales.id
        $condicion ORDER BY pedidos.id DESC  
        ");

      return query2json($resultado);

    }
     function buscarPedidosFacturacion($idRazonSocial)
    {



      $resultado = $this->link->query("
       
        SELECT
        pedidos.id,
        pedidos.id_cliente,
        pedidos.id_razon_social,
        pedidos.total,
        pedidos.iva,
        pedidos.fecha,
        pedidos.subtotal,
        pedidos.vendedor,
        pedidos.estatus,
        pedidos.instrucciones_empaque,
        pedidos.folio,
        cat_clientes.nombre_comercial AS cliente,
        razones_sociales.rfc,
        razones_sociales.nombre_corto,
        razones_sociales.razon_social,

        pedidos.fecha_impresion,
        pedidos.fecha_envio,
        pedidos.paqueteria,
        pedidos.guias,
        pedidos.datos_recepcion,
        pedidos.tipo

        FROM pedidos
        INNER JOIN cat_clientes ON pedidos.id_cliente = cat_clientes.id
        INNER JOIN razones_sociales ON pedidos.id_razon_social=razones_sociales.id
        WHERE pedidos.id_razon_social = $idRazonSocial AND pedidos.tipo = 0 AND pedidos.estatus = 'A'  ORDER BY pedidos.id DESC  
        ");

      return query2json($resultado);

    }

    function buscarDetalles($idPedido)
    {


      $resultado = $this->link->query("
       
        SELECT
          pedidos_d.id,
          pedidos_d.id_pedido,
          pedidos_d.id_producto,
          pedidos_d.cantidad,
          pedidos_d.comodato,
          pedidos_d.precio,
          pedidos_d.iva,
          pedidos_d.importe,
          ifnull(pedidos_d.observaciones, '') as observaciones,
          
          pedidos_d.tipo_impresion,
          productos.clave,
          productos.concepto
          FROM pedidos_d
          INNER JOIN productos ON pedidos_d.id_producto = productos.id
          WHERE pedidos_d.id_pedido = $idPedido
                  ");

      return query2json($resultado);

    }

    function obtenerFolio()
    {

        $result = mysqli_query($this->link, "SELECT folio_pedido  FROM cat_unidades_negocio WHERE id = 3");
        $row = mysqli_fetch_assoc($result);
        return (int)$row['folio_pedido'] + 1;
    }

    function obtenerFolioFactura($tipo)
    {

        $result = mysqli_query($this->link, "SELECT  $tipo as folio FROM empresas_fiscales WHERE id_empresa = 3");
        $row = mysqli_fetch_assoc($result);
        return $row['folio'];
    }

    function updateFolio($folio)
    {

        $result = mysqli_query($this->link, "UPDATE cat_unidades_negocio SET folio_pedido = $folio   WHERE id = 3");

    }

    function guardarPedidos($data)
    {

      $verifica = false;  

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardar($data);

      if($verifica > 0)
        $this->link->query("commit;");
      else
        $this->link->query('rollback;');

        return $verifica;

    }

    function foliosAlmacen()
    {

      $folio = 0;

      $queryFolio = "SELECT folio_salida_almacen FROM cat_unidades_negocio WHERE id= "  . $this->idUnidadNegocio;
      $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
      if($resultF)
      {

        $datosX  =mysqli_fetch_array($resultF);
        $folioA = $datosX['folio_salida_almacen'];
        $folio = $folioA + 1;

        $queryU = "UPDATE cat_unidades_negocio SET folio_salida_almacen='$folio' WHERE id=". $this->idUnidadNegocio;
        $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());

      }

      return $folio;

    }

    function guardaAlmacen($idPedido, $tipo, $productos, $idUsuario, $usuario)
    {

      $verifica = false;
      $idUN = $this->idUnidadNegocio;
      $idSuc = $this->idSucursal;
      $fecha =  date("Y-m-d");
      $partidas = sizeof($productos); 

      if($tipo == 0)
      {

        $folioA = $this->foliosAlmacen();

         $queryA = "INSERT INTO almacen_e (folio, id_compania, id_sucursal, fecha, cve_concepto, id_unidad_negocio, id_usuario_captura, usuario_captura, no_partidas, id_pedido) VALUES ($folioA, $idSuc, $idSuc, '$fecha', 'S12', $idUN, $idUsuario, '$usuario', $partidas, $idPedido)";
         $resultA = mysqli_query($this->link, $queryA) or die(mysqli_error());
         $idA = mysqli_insert_id($this->link);

         if($resultA)
         {

          foreach($productos as $producto)
          {

            $idProducto = $producto['id_producto'];
            $precio = $producto['precio'];
            $cantidad = $producto['cantidad'];
            $comodato = $producto['comodato'];
            $importe = $producto['importe'];
            $iva = $producto['iva'];
 

            $queryDA = " INSERT INTO almacen_d(id_almacen_e, cve_concepto, id_producto, cantidad, precio) VALUES($idA, 'S12', $idProducto, $cantidad, $precio)";
            $resultDA = mysqli_query($this->link, $queryDA) or die(mysqli_error());

            if($resultDA)
              $verifica = true;
            else
            {
              $verifica = false;
              break;
            }

          }

         }

      }
      else
        $verifica = true;

      return $verifica;

    }

    function guardar($data)
    {

        $verifica = 0; 

        $fecha = $data['fecha'];
        $vendedor = $data['vendedor'];
        $idCliente = $data['id_cliente'];
        $idRazonSocial = $data['id_razon_social'];
        $subtotal = $data['subtotal'];
        $iva = $data['iva'];
        $total = $data['total'];
        $instrucciones = $data['instrucciones'];
        $productos = $data['productos'];
        $tipo = $data['tipo'];

        $idUsuario = $data['id_usuario'];
        $usuario = $data['usuario'];

        $folio = $this->obtenerFolio();

        $queryPedido = "INSERT INTO pedidos(id_cliente, id_razon_social, total, iva, subtotal, vendedor, fecha, instrucciones_empaque, folio, tipo) VALUES ($idCliente, $idRazonSocial, $total, $iva, $subtotal, '$vendedor', '$fecha', '$instrucciones', $folio , $tipo)";
        $resultPedido = mysqli_query($this->link, $queryPedido) or die(mysqli_error());
        $idPedido = mysqli_insert_id($this->link);

        $this->updateFolio ($folio);

        if($resultPedido)//if(mysqli_affected_rows( $this->link) > 0 )
        {


          if($this->guardaAlmacen($idPedido, $tipo, $productos, $idUsuario, $usuario))
          {

            if($this->guardarDetalles($idPedido, $productos))
              $verifica = $folio;

          }          

        }     

        return $verifica;

    }

    function guardarDetalles($idPedido, $productos)
    {

      $verifica = false;

      foreach($productos as $producto)
      {

          $idProducto = $producto['id_producto'];
          $precio = $producto['precio'];
          $cantidad = $producto['cantidad'];
          $comodato = $producto['comodato'];
          $importe = $producto['importe'];
          $iva = $producto['iva'];

        $queryDetalle = "INSERT INTO pedidos_d(id_pedido, id_producto, cantidad, comodato, precio, iva, importe) VALUES ($idPedido, $idProducto, $cantidad, $comodato, $precio, $iva, $importe)";
        $resultDetalle = mysqli_query($this->link, $queryDetalle) or die(mysqli_error());

        if($resultDetalle)
          $verifica = true;
        else
        {
             $verifica = false;
             break;
        }

      }

      return $verifica;

  }

  function guardarProduccion($idPedido, $datosPedido, $datosProduccion)
  {

    $verifica = false;

    $this->link->begin_transaction();
    $this->link->query("START TRANSACTION;");

    $verifica = $this->guardarProduccionPedido($idPedido, $datosPedido);

    if($verifica == true)
      $verifica = $this->actualizaProductos($datosProduccion);


    if($verifica == true)
      $this->link->query("commit;");
    else
      $this->link->query('rollback;');


    return $verifica;


  }


  function guardarProduccionPedido($idPedido, $datos)
  {

    $verifica = false;

    
    $fechaImpresion = $datos['fecha_impresion'];
    $envio = $datos['envio'];
    $paqueteria = $datos['paqueteria'];
    $guias = $datos['guias'];
    $datosRecepcion = $datos['datos_recepcion'];

    $queryPedido= "UPDATE pedidos SET fecha_impresion = '$fechaImpresion', fecha_envio = '$envio', paqueteria = '$paqueteria',  guias = '$guias', datos_recepcion = '$datosRecepcion' 
       WHERE id = $idPedido ";
    $resultPedido = mysqli_query($this->link, $queryPedido) or die(mysqli_error());

    if($resultPedido)
      $verifica = true;

    return $verifica;

  }

  function actualizaProductos($productos)
  {

    $verifica = false;

    for($i=1; $i<=$productos[0]; $i++)
    {

      $id = $productos[$i]['id_registro'];
      $tipoImpresion = $productos[$i]['tipo_impresion'];
      $observaciones = $productos[$i]['observaciones'];

      $queryD = "UPDATE pedidos_d SET observaciones = '$observaciones', tipo_impresion = '$tipoImpresion' WHERE id = $id "; 
      $resultD = mysqli_query($this->link, $queryD) or die(mysqli_error());

      if($resultD)
        $verifica = true;
      else
      {
        $verifica = false;
        break;
      }

    }

    return $verifica;

  }

  function actualizarPedido($idPedido, $estatus)
  {

    $verifica = false;
    $queryD = "UPDATE pedidos SET estatus = '$estatus' WHERE id = $idPedido "; 
    $resultD = mysqli_query($this->link, $queryD) or die(mysqli_error());

    if($resultD)
      $verifica = true;

    return $verifica;

  }

  function guardarFacturacion($datos)
  {

    $verifica = 0;

    $this->link->begin_transaction();
    $this->link->query("START TRANSACTION;");

    $verifica = $this -> guardarActualizar($datos);

    if($verifica > 0)
        $this->link->query("commit;");
    else
        $this->link->query('rollback;');

    return $verifica;

  }//- fin function guardarFacturacion

  function guardarActualizar($datos)
  {

    $verifica = 0;



    $idUnidadNegocio = $datos['idUnidadNegocio'];
    $idSucursal = $datos['idSucursal'];
    $idCliente = $datos['idCliente'];
    $idEmpresaFiscalEmisor = $datos['idEmpresaFiscalEmisor'];
    $idRazonSocialReceptor = $datos['idRazonSocialReceptor'];
    $razonSocialReceptor = $datos['razonSocialReceptor'];
    $rfc = $datos['rfc'];
    $idUsoCFDI = $datos['idUsoCFDI'];
    $idMetodoPago = $datos['idMetodoPago'];
    $idFormaPago = $datos['idFormaPago'];
    $fecha = $datos['fecha'];
    $tasaIva = $datos['tasaIva'];
    $digitosCuenta = $datos['digitosCuenta'];
    $observaciones = $datos['observaciones'];
    $partidas = $datos['partidas'];
    $subtotal = $datos['subtotal'];
    $iva = $datos['iva'];
    $total = $datos['total'];
    $codigoPostal = $datos['codigoPostal'];
    $idCFDIEmpresaFiscal =  $datos['idCFDIEmpresaFiscal'];
    $usuario = $datos['usuario'];
    $idPedido = $datos['id_pedido'];
    $tipo = isset($datos['tipo']) ? $datos['tipo'] :'';
    $facturasSustituir = isset($datos['facturasSustituir']) ? $datos['facturasSustituir'] : '';

    $folio = $this->obtenerFolioFactura('folio_factura') + 1;

    $query = "INSERT INTO facturas(id_unidad_negocio,id_sucursal,folio,id_empresa_fiscal,id_razon_social,
            id_cliente,uso_cfdi,metodo_pago,forma_pago,digitos_cuenta,fecha,observaciones,
            porcentaje_iva,subtotal,iva,total,fecha_inicio,fecha_fin,rfc_razon_social,razon_social) 
            VALUES ('$idUnidadNegocio','$idSucursal','$folio','$idEmpresaFiscalEmisor','$idRazonSocialReceptor',
            '$idCliente','$idUsoCFDI','$idMetodoPago','$idFormaPago','$digitosCuenta','$fecha', '$observaciones','$tasaIva','$subtotal','$iva','$total','$fechaInicioPeriodo',
            '$fechaFinPeriodo','$rfc','$razonSocialReceptor')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idFactura = mysqli_insert_id($this->link);

        $porcentajeIva = $tasaIva;

        $facturaE = array('folio'=>$folio,
                            'fecha'=>$fecha,
                            'subtotal'=>$subtotal,
                            'iva'=>$iva,
                            'idMetodoPago'=>$idMetodoPago,
                            'idFormaPago'=>$idFormaPago,
                            'idUsoCFDI'=>$idUsoCFDI,
                            'rfc'=>$rfc,
                            'razonSocialReceptor'=>$razonSocialReceptor,
                            'codigoPostal'=>$codigoPostal,
                            'empresaFiscal'=>$idCFDIEmpresaFiscal,
                            'usuario'=>$usuario,
                            'tasaIva'=>$porcentajeIva,
                            'tipo'=>$tipo,
                            'tipo_cfd'=>'I',
                            'facturasSustituir'=>$facturasSustituir
                        );

        if($result) 
        {

          if(mysqli_query($this->link, "UPDATE pedidos SET estatus = 'F'   WHERE id = $idPedido"))
          {

            if($this->guardarPartidas($idFactura, $partidas, $facturaE, $idEmpresaFiscalEmisor, $folio, $tipo, $facturasSustituir))
              $verifica = $idFactura;
          }
          
        }

        return $verifica;
    }//- fin function guardarFacturacion

    function guardarPartidas($idFactura,$partidas,$facturaE, $idEmpresaFiscalEmisor, $folio, $tipo, $facturasSustituir)
    {


        $verifica = false;

        $facturaD = array();
        foreach($partidas as $partida)
        {

            $idClaveSATProducto = $partida['id_clave_sat'];
            $idClaveSATUnidad = $partida['id_clave_unidad'];
            $nombreUnidadSATA = explode("-" , $partida['clave_unidad']);
            $nombreProductoSATA = explode("-" , $partida['clave_sat']);
            $nombreUnidadSAT = trim($nombreUnidadSATA[1]);
            $nombreProductoSAT = trim($nombreProductoSATA[1]);
            $cantidad = $partida['cantidad'];
            $cantidadA = $partida['cantidad_antes'];
            $precio = $partida['precio'];
            $importe = $partida['importe'];
            $descripcion = $partida['concepto'];
            $idPedidoDetalle = $partida['id']; 

            $query = "INSERT INTO facturas_d(id_factura,cantidad,precio_unitario,importe,descripcion,
                clave_unidad_sat,unidad_sat,clave_producto_sat,producto_sat, id_pedido_d) 
                VALUES ('$idFactura','$cantidad','$precio','$importe','$descripcion','$idClaveSATUnidad',
                '$nombreUnidadSAT','$idClaveSATProducto','$nombreProductoSAT', $idPedidoDetalle)";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            $real = (double)$cantidadA - (double)$cantidad;

            array_push($facturaD,['concepto'=>$descripcion,
                          'precioUnitario'=>$precio,
                          'cantidad'=>$cantidad,
                          'claveProducto'=>$idClaveSATProducto,
                          'claveUnidad'=>$idClaveSATUnidad,
                          'unidad'=>$nombreUnidadSAT,
                          'porcentajeDescuento'=>$porcentajeDescuento]);

            if ($result) 
            {

              if(mysqli_query($this->link, "UPDATE pedidos_d SET m_real = $real   WHERE id = $idPedidoDetalle"))
               $verifica = true;
              else
              {
                  $verifica = false;
                  break;
              }

            }
            else
            {
                $verifica = false;
                break;
            }

        }

        if ($verifica == 1) 
        {
            if($tipo == 'sustituir')
                $verifica = $this->guardaSustituirFactura($facturasSustituir,$facturaE,$facturaD,$idFactura,$idCFDI,$idEmpresaFiscalEmisor, $folio);
            else
            {
                $cfdiDenke = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
                
                $idCFDI = $cfdiDenke->guardaFactura($facturaE,$facturaD); 
                $verifica = $this->actualizaCFDIFactura($idFactura,$idCFDI);
                $this->actualizarFolio($idEmpresaFiscalEmisor, $folio, 'folio_factura');
            }

        }

        return $verifica;
    }//- fin function guardarPartidas

    function actualizaCFDIFactura($idFactura,$idCFDI){
        $verifica = 0;

        $query = "UPDATE facturas SET id_factura_cfdi ='$idCFDI' WHERE id = "   . $idFactura;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
            $verifica = $idFactura;
        

        return $verifica;
    }//- fi

    function actualizarFolio($idEmpresaFiscal, $folio, $tipo)
    { 

        $result = mysqli_query($this->link, "UPDATE empresas_fiscales set $tipo = $folio WHERE id_empresa = 3");
    }

    function guardaSustituirFactura($facturasSustituir,$facturaE,$facturaD,$idFactura,$idCFDI,$idEmpresaFiscalEmisor, $folio){
        $verifica = 0;

        foreach($facturasSustituir as $partida)
        {
            $idFacturaS = $partida['idFactura'];
            $tipo = $partida['tipo'];

            $query = "INSERT INTO facturas_r(id_factura,id_factura_sustituida,tipo) 
                VALUES ('$idFactura','$idFacturaS','$tipo')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if ($result) 
            {
                $verifica = 1;
            }else{
                $verifica = 0;
                break;
            }
        }

        if ($verifica == 1) 
        {
            $cfdiDenke = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
            
            $idCFDI = $cfdiDenke->guardaFactura($facturaE,$facturaD); 
            $verifica = $this->actualizaCFDIFactura($idFactura,$idCFDI);
            $this->actualizarFolio($idEmpresaFiscalEmisor, $folio, 'folio_factura');

        }

        return $verifica;
    }//- fin function guardaSustituirFactura
    

}//--fin de class Pedidos

?>