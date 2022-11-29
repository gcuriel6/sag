<?php

require_once('conectar.php');
require_once('CFDIDenken.php');

class Facturacion
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function __construct()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Guarda registros
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarFacturacion($datos){
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

    /**
      * Guarda registros
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarActualizar($datos)
    {

        // echo mb_strlen(serialize((array)$datos), '8bit');
        // echo "<br>";
        // print_r($datos["partidas"]);
        // exit();

        // print_r($datos);
        // exit();

        $verifica = 0;

        $idUsuario = $_SESSION['id_usuario'];
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
        $diasCredito = $datos['diasCredito'];
        $tasaIva = $datos['tasaIva'];
        $digitosCuenta = $datos['digitosCuenta'];
        $mes = $datos['mes'];
        $anio = $datos['anio'];
        $observaciones = $datos['observaciones'];
        $partidas = $datos['partidas'];
        $subtotal = $datos['subtotal'];
        $iva = $datos['iva'];
        $total = $datos['total'];
        $fechaInicioPeriodo = $datos['fechaInicioPeriodo'];
        $fechaFinPeriodo = $datos['fechaFinPeriodo'];
        $codigoPostal = $datos['codigoPostal'];
        $idCFDIEmpresaFiscal = $datos['idCFDIEmpresaFiscal'];
        $usuario = $datos['usuario'];
        $idContrato = isset($datos['idContrato']) ? $datos['idContrato'] : 0;
        $tipo = isset($datos['tipo']) ? $datos['tipo'] :'';
        $facturasSustituir = isset($datos['facturasSustituir']) ? $datos['facturasSustituir'] : '';
        $retencion = isset($datos['retencion']) ? $datos['retencion'] : 0;
        $importeRetencion = isset($datos['importeRetencion']) ? $datos['importeRetencion'] : 0;
        $porcentajeRetencion = isset($datos['porcentajeRetencion']) ? $datos['porcentajeRetencion'] : 0;

        $regimen_fiscal = isset($datos["regimen_fiscal"]) ? $datos["regimen_fiscal"] : 0;
        
        $idCxC = isset($datos['idCxC']) ?  $datos['idCxC'] : 0;
        
        $esPlan = isset($datos['esPlan']) ? $datos['esPlan'] : 0;
        $esVentaOrden = isset($datos['esVentaOrden']) ? $datos['esVentaOrden'] : 0;

        //--MGFS 17-02-2020 SE AGREGAN DATOS FARA FACTURAION CON DESCRIPCION ALTERNA
        $llevaDescripcionAlterna = isset($datos['llevaDescripcionAlterna']) ? $datos['llevaDescripcionAlterna'] : 0;
        $claveProductoA = isset($datos['claveProductoA']) ? $datos['claveProductoA'] : '';
        $productoA = isset($datos['productoA']) ? $datos['productoA'] : '';
        $claveUnidadA = isset($datos['claveUnidadA']) ? $datos['claveUnidadA'] : '';
        $unidadA = isset($datos['unidadA']) ? $datos['unidadA'] : '';
        $descripcionA = isset($datos['descripcionA']) ? $datos['descripcionA'] : '';

        // print_r($datos);
        // exit();

        $id_salida_venta = isset($datos['id_salida_venta']) ? $datos['id_salida_venta'] : 0;

        if($id_salida_venta != 0 && $id_salida_venta != ""){
            $exploded = explode(",", $id_salida_venta);

            if(count($exploded) > 1){
                $id_salida_venta_insertar = 0;
            }else{
                $id_salida_venta_insertar = $id_salida_venta;
            }
        }else{
            $id_salida_venta_insertar = 0;
        }

        $clienteAlternoPG = isset($datos['cliente_alterno_pg']) ? $datos['cliente_alterno_pg'] : '';

        $adendaF = isset($datos['adenda_file']) ? $datos['adenda_file'] : '';
        $adendaP = isset($datos['adenda_purchase']) ? $datos['adenda_purchase'] : '';
        $adendaT = isset($datos['adenda_transport']) ? $datos['adenda_transport'] : '';
        $adendaB = isset($datos['adenda_branch']) ? $datos['adenda_branch'] : '';
        
        //--MGFS 03-03-2020  se agrega la bandera si es facturacion por rfc
        $facturaRfc = 0;
        if($idCliente > 1){
            $idsServicios = isset($datos['idsServicios']) ? $datos['idsServicios'] : 0;
            $idsUnicos = array_unique($idsServicios);

            if(count($idsUnicos)>1){
                $facturaRfc = 1;
            }
        }
        
        //-->NJES Feb/20/2020 se obtiene el descuento porque en ventas alarmas pueden traer descuento y se prorratea para las partidas al guardar prefactura
        $descuento = isset($datos['descuento']) ? $datos['descuento'] : 0;

        //-->NJES May/25/2021
        $subtotalOriginal = isset($datos['subtotal_original']) ? $datos['subtotal_original'] : $subtotal;
        $ivaOriginal = isset($datos['iva_original']) ? $datos['iva_original'] : $iva;
        $totalO = isset($datos['total_original']) ? $datos['total_original'] : $total;
        $importeRetencionOriginal = isset($datos['importe_retencion_original']) ? $datos['importe_retencion_original'] : $importeRetencion;
        $totalOriginal = $totalO + $importeRetencionOriginal;
        $moneda = isset($datos['moneda']) ? $datos['moneda'] : 'MXN';

        $monedaFactura = isset($datos['moneda_factura']) ? $datos['moneda_factura'] : 'MXN';

        $deptos = $datos["deptos"];

        //-->NJES Jun/16/2021 guardar en ginthercorp los datos de pagos en dolares,
        //para cuando es una nota de credito y la moneda de la factura es USD se debe calcular el equivalente 
        //importes en dolares y se captura el tipo_cambio
        //ESTO PARA FACILITAR EL CALCULO DE SALDO DE LA FACTURA
        $subtotalUsd = 0;
        $ivaUsd = 0;
        $importe_retencionUsd = 0;
        $totalUsd = 0;

        $tipoCambio = 1;
        if($moneda != 'MXN')
        {
            $tipoCambio = isset($datos['tipo_cambio']) ? $datos['tipo_cambio'] : 1;
            $tipoCambioC = $tipoCambio;
            $subtotalUsd = $this->num_2dec($subtotalOriginal);
            $ivaUsd = $this->num_2dec($ivaOriginal);
            $importeRetencionUsd = $this->num_2dec($importeRetencionOriginal);
            $totalUsd = (floatval($subtotalUsd)+floatval($ivaUsd))+floatval($importeRetencionUsd);
        }

        //-->NJES May/27/2020 se calcula el porcentaje descuento para la partida de descripción alterna
        //es necesario que se divida el porcentaje de descuento entre 100 porque ese porcentaje de descuento despues se multiplica por la cantidad y costo unitario 
        //$porcentajeDescuentoAlt = (($descuento*100)/$subtotal)/100; 
        $porcentajeDescuentoAlt = (($descuento*100)/$subtotalOriginal)/100;

        $facturaDA = array();
        //->le voy agregando al array los registros
        array_push($facturaDA,['concepto'=>$descripcionA,
        //'precioUnitario'=>$subtotal,
        'precioUnitario'=>$subtotalOriginal,
        'cantidad'=>1,
        'claveProducto'=>$claveProductoA,
        'claveUnidad'=>$claveUnidadA,
        'unidad'=>$unidadA,
        'porcentajeDescuento'=>$porcentajeDescuentoAlt]);


        $folio = $this->obtenerFolio($idEmpresaFiscalEmisor, 'folio_factura') + 1;

        $query = "INSERT INTO facturas(id_unidad_negocio,id_sucursal,folio,id_empresa_fiscal,id_razon_social,
                id_cliente,uso_cfdi,metodo_pago,forma_pago,digitos_cuenta,fecha,anio,mes,observaciones,
                dias_credito,porcentaje_iva,subtotal,iva,total,fecha_inicio,fecha_fin,rfc_razon_social,razon_social,
                id_contrato,es_plan,es_venta_orden,id_cxc,retencion,importe_retencion,
                lleva_descripcion_alterna,descripcion_alterna,clave_unidad_sat,unidad_sat,clave_producto_sat,
                producto_sat,descuento,factura_por_rfc,id_almacen_e,cliente_alterno,moneda,tipo_cambio,subtotal_usd,
                iva_usd,importe_retencion_usd,total_usd, id_capturo) 
                VALUES ('$idUnidadNegocio','$idSucursal','$folio','$idEmpresaFiscalEmisor','$idRazonSocialReceptor',
                '$idCliente','$idUsoCFDI','$idMetodoPago','$idFormaPago','$digitosCuenta','$fecha','$anio',
                '$mes','$observaciones','$diasCredito','$tasaIva','$subtotal','$iva','$total','$fechaInicioPeriodo',
                '$fechaFinPeriodo','$rfc','$razonSocialReceptor','$idContrato','$esPlan','$esVentaOrden','$idCxC',
                '$retencion','$importeRetencion','$llevaDescripcionAlterna','$descripcionA','$claveUnidadA','$unidadA',
                '$claveProductoA','$productoA','$descuento','$facturaRfc', $id_salida_venta_insertar, '$clienteAlternoPG',
                '$moneda','$tipoCambioC','$subtotalUsd','$ivaUsd','$importeRetencionUsd','$totalUsd',$idUsuario)";
        
        // echo $query;
        // exit();
        
        $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));
        $idFactura = mysqli_insert_id($this->link);

        $porcentajeIva = $tasaIva;

        /*
        GCM- 2022-05-12 Se agrega el insert para la tabla de facturas_deptos para saber a cual departamento fue la factura
        GCM- 2022-06-22 Se agrega el insert para salidas ventas a tabla facturas_ventas
        */

        if($deptos != ""){
            $exploded = explode(", ", $deptos);

            foreach($exploded as $dept){

                $query = "INSERT INTO facturas_deptos (id_factura, id_depto)
                            VALUES($idFactura, $dept);";
                
                $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));
            }
        }

        if($id_salida_venta != 0 && $id_salida_venta != ""){
            $exploded = explode(",", $id_salida_venta);

            if(count($exploded) > 1){
                foreach($exploded as $venta){

                    $query = "INSERT INTO facturas_ventas (id_factura, id_almacen_e)
                                VALUES($idFactura, $venta);";
                    
                    $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));
                }
            }
        }

        $facturaE = array('folio'=>$folio,
                            'fecha'=>$fecha,
                            //'subtotal'=>$subtotal,
                            //'iva'=>$iva,
                            'subtotal'=>$subtotalOriginal,
                            'iva'=>$ivaOriginal,
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
                            'facturasSustituir'=>$facturasSustituir,
                            'retencion'=>$retencion,
                            //'importeRetencion'=>$importeRetencion,
                            'importeRetencion'=>$importeRetencionOriginal,
                            'porcentajeRetencion'=>$porcentajeRetencion,
                            'descripcionAlterna'=>$llevaDescripcionAlterna,
                            'facturaDA'=>$facturaDA,
                            'descuento'=>$descuento,
                            'id_razon_social'=>$idRazonSocialReceptor,
                            'adenda_f'=>$adendaF,
                            'adenda_p'=>$adendaP,
                            'adenda_t'=>$adendaT,
                            'adenda_b'=>$adendaB,
                            'moneda'=>$moneda,
                            'tipo_cambio'=>$tipoCambio,
                            'regimen_fiscal'=>$regimen_fiscal
                        );

        if ($result) 
          $verifica = $this->guardarPartidas($idFactura,$partidas,$facturaE, $idEmpresaFiscalEmisor, $folio, $tipo, $facturasSustituir); 

        return $verifica;
    }//- fin function guardarFacturacion

    /**
      * Obtiene el folio actual de la empresa fiscal
      *
      * @param int $idEmpresaFiscal
      *
    **/ 
    function obtenerFolio($idEmpresaFiscal, $tipo)
    {

        $result = mysqli_query($this->link, "SELECT  $tipo as folio FROM empresas_fiscales WHERE id_empresa = $idEmpresaFiscal");
        $row = mysqli_fetch_assoc($result);
        return $row['folio'];
    }

    /**
        * Actualiza el folio actual de la emoresa fiscal
        *
        * @param int $idEmpresaFiscal
        * @param int $folio
        *
    **/
    function actualizarFolio($idEmpresaFiscal, $folio, $tipo)
    {

        $result = mysqli_query($this->link, "UPDATE empresas_fiscales set $tipo = $folio WHERE id_empresa = $idEmpresaFiscal");
    }
    

    /**
        * Guarda las partidas de la factura
        *
        * @param int $idFactura
        * @param varchar $partidas  array que contiene los datos
        *
    **/
    function guardarPartidas($idFactura,$partidas,$facturaE, $idEmpresaFiscalEmisor, $folio, $tipo, $facturasSustituir){
        $verifica = 0;

        $facturaD = array();
        foreach($partidas as $partida)
        {
            $idClaveSATProducto = $partida['idClaveSATProducto'];
            $idClaveSATUnidad = $partida['idClaveSATUnidad'];
            $nombreUnidadSAT = $partida['nombreUnidadSAT'];
            $nombreProductoSAT = $partida['nombreProductoSAT'];
            $cantidad = $partida['cantidad'];
            $precio = $partida['precio'];
            $importe = $partida['importe'];
            $descripcion = $partida['descripcion'];
            $idVenta = isset($partida['idVenta'])? $partida['idVenta'] : 0 ;
            $idOrden = isset($partida['idOrden'])? $partida['idOrden'] : 0 ;
            $idCXC = isset($partida['idCXC'])? $partida['idCXC'] : 0 ;
            $idServicio = isset($partida['idServicio'])? $partida['idServicio'] : 0 ;

            $idPlan = isset($partida['idPlan']) ?  $partida['idPlan'] : 0;
            $fechaRecibo = isset($partida['fechaRecibo']) ?  $partida['fechaRecibo'] : '0000-00-00';

            //-->NJES Feb/20/2020 se guarda el descuento porque en ventas alarmas pueden traer descuento y se prorratea para las partidas al guardar prefactura
            $montoDescuento =  isset($partida['montoDescuento']) ?  $partida['montoDescuento'] : 0;
            $porcentajeDescuento =  isset($partida['porcentajeDescuento']) ?  $partida['porcentajeDescuento'] : 0;

            //-->NJES May/25/2021
            $precioOriginal = isset($partida['precio_original']) ? $partida['precio_original'] : $precio;

            $query = "INSERT INTO facturas_d(id_factura,cantidad,precio_unitario,importe,descripcion,
                clave_unidad_sat,unidad_sat,clave_producto_sat,producto_sat,id_venta,id_orden,id_cxc,
                id_plan,fecha_recibo,monto_descuento,porcentaje_descuento,id_servicio) 
                VALUES ('$idFactura','$cantidad','$precio','$importe','$descripcion','$idClaveSATUnidad',
                '$nombreUnidadSAT','$idClaveSATProducto','$nombreProductoSAT','$idVenta','$idOrden',
                '$idCXC','$idPlan','$fechaRecibo','$montoDescuento','$porcentajeDescuento','$idServicio')";
                
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            //->le voy agregando al array los registros
            array_push($facturaD,['concepto'=>$descripcion,
                          //'precioUnitario'=>$precio,
                          'precioUnitario'=>$precioOriginal,
                          'cantidad'=>$cantidad,
                          'claveProducto'=>$idClaveSATProducto,
                          'claveUnidad'=>$idClaveSATUnidad,
                          'unidad'=>$nombreUnidadSAT,
                          'porcentajeDescuento'=>$porcentajeDescuento]);

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
            if($tipo == 'sustituir'){
                if($facturaE['descripcionAlterna']==1){
                    $facturaD = array();
                    $facturaD = $facturaE['facturaDA'];
                }
                $verifica = $this->guardaSustituirFactura($facturasSustituir,$facturaE,$facturaD,$idFactura,$idCFDI,$idEmpresaFiscalEmisor, $folio);
            }else{
                $cfdiDenke = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
                if($facturaE['descripcionAlterna']==1){
                    $facturaD = array();
                    $facturaD = $facturaE['facturaDA'];
                }
                $idCFDI = $cfdiDenke->guardaFactura($facturaE,$facturaD); 
                $verifica = $this->actualizaCFDIFactura($idFactura,$idCFDI);
                $this->actualizarFolio($idEmpresaFiscalEmisor, $folio, 'folio_factura');
                $this->actualizarAdenda($idFactura, $idCFDI, $facturaE['id_razon_social'], $facturaE);
            }

        }

        return $verifica;
    }//- fin function guardarPartidas

    function actualizaCFDIFactura($idFactura,$idCFDI){
        $verifica = 0;

        $query = "UPDATE facturas SET id_factura_cfdi ='$idCFDI' WHERE id=".$idFactura;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
            $verifica = $idFactura;
        

        return $verifica;
    }//- fin function actualizaFolioFactura

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

    function buscarFacturasIdCFDI($idFactura){
        $result = $this->link->query("SELECT a.id, a.id_factura_cfdi
                                        FROM facturas a
                                        WHERE a.id=".$idFactura);

        return query2json($result);
    }

    function buscarFacturas($datos)
    {

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];

        if($idSucursal != '')  //-->No tengo sucursales con permisos en la unidad entonces debo regresar un array vacio
        {
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }

            if($fechaInicio == '' && $fechaFin == '')
            {
                $fecha=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $fecha=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $fecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            $query = "SELECT a.id,a.folio,IFNULL(c.uuid_timbre,'') AS folio_fiscal,b.razon_social AS empresa_fiscal,
                            a.razon_social,a.rfc_razon_social,a.fecha,c.estatus,d.descr AS sucursal,a.id_cliente,
                            a.metodo_pago,a.id_unidad_negocio,
                            IFNULL(a.observaciones, '') observaciones,
                            IFNULL(e.usuario, '') usuario
                        FROM facturas a
                        INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
                        INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                        LEFT JOIN facturas_cfdi c ON a.id=c.id_factura
                        LEFT JOIN usuarios e ON e.id_usuario = a.id_capturo
                        WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $fecha AND a.id_factura_nota_credito=0 AND a.es_plan=0 AND a.es_venta_orden=0
                        GROUP BY a.id
                        ORDER BY a.fecha DESC";

            // echo $query;
            // exit();

            $result = $this->link->query($query);
        
            return query2json($result);

        }else{
                
            $arr = array();

            return json_encode($arr);
        }
    }//- fin function buscarFacturas

    function buscarFacturasId($idFactura){

        $query = "SELECT a.id, a.id_factura_cfdi, a.id_unidad_negocio,a.id_sucursal,a.folio,a.id_empresa_fiscal,
        a.id_razon_social,a.razon_social,a.rfc_razon_social,a.id_cliente,
        a.uso_cfdi,a.metodo_pago,a.forma_pago,r.correo_facturas AS email, a.digitos_cuenta,
        a.fecha,a.anio,a.mes,a.observaciones,a.dias_credito,a.porcentaje_iva,
        a.subtotal,a.iva,a.total,a.fecha_inicio,a.fecha_fin,
        IFNULL(d.estatus, 'A') AS estatus,b.razon_social AS empresa_fiscal, b.id_cfdi AS id_cfdi , c.nombre_comercial AS cliente,
        IFNULL(d.uuid_timbre,'') AS folio_fiscal,IFNULL(GROUP_CONCAT(f.uuid_timbre),'') AS facturas_relacionadas,
        (IFNULL(total_pagos.total_facturas, 0) + IFNULL(total_notas.total_facturas, 0)) AS num_notas_credito,
        a.retencion,a.importe_retencion, (a.total - a.importe_retencion) AS ret,
        IF(a.id_almacen_e IS NULL OR a.id_almacen_e = 0, (SELECT GROUP_CONCAT(id_almacen_e) FROM facturas_ventas WHERE id_factura = a.id GROUP BY id_factura), a.id_almacen_e) AS id_almacen_e,
        IF(h.folio_venta_stock = 0 OR h.folio_venta_stock IS NULL,(SELECT GROUP_CONCAT(h.folio_venta_stock) FROM almacen_e h WHERE h.id IN (SELECT id_almacen_e FROM facturas_ventas WHERE id_factura = a.id)), h.folio_venta_stock) AS folio_venta,
        a.cliente_alterno, r.regimen_fiscal
        FROM facturas a
        INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
        LEFT JOIN razones_sociales r ON a.id_razon_social = r.id
        LEFT JOIN cat_clientes c ON a.id_cliente=c.id
        LEFT JOIN facturas_cfdi d ON a.id=d.id_factura
        LEFT JOIN facturas_r e ON a.id=e.id_factura
        LEFT JOIN facturas_cfdi f ON e.id_factura_sustituida=f.id_factura
        LEFT JOIN facturas g ON a.id=g.id_factura_nota_credito AND g.estatus!='C'
        LEFT JOIN almacen_e h ON a.id_almacen_e=h.id
        LEFT JOIN 
        (
            SELECT 
            pagos_d.id_factura AS id_factura,
            COUNT(pagos_d.id_factura) AS total_facturas
            FROM pagos_d
            INNER JOIN pagos_e ON pagos_d.id_pago_e = pagos_e.id
            INNER JOIN pagos_cfdi ON pagos_e.id = pagos_cfdi.id_pago_e
            WHERE pagos_cfdi.estatus_cfdi != 'C'
            GROUP BY pagos_d.id_factura
        ) total_pagos ON a.id = total_pagos.id_factura
        LEFT JOIN 
        (

            SELECT 
            facturas.id_factura_nota_credito AS id_factura,
            COUNT(facturas.id_factura_nota_credito) AS total_facturas
            FROM facturas
            INNER JOIN facturas_cfdi ON facturas.id = facturas_cfdi.id_factura
            WHERE facturas_cfdi.estatus != 'C'
            GROUP BY facturas.id_factura_nota_credito
            
        ) total_notas ON a.id = total_notas.id_factura
        WHERE a.id=".$idFactura;

        // echo $query;
        // exit();

        $result = mysqli_query($this->link,$query);
        
        //return query2json($result);

        //-->NJES May/25/2021
        $array = array();

        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $idFacturaCFDI = $row['id_factura_cfdi'];
        $idUnidadNegocio = $row['id_unidad_negocio'];
        $idSucursal = $row['id_sucursal'];
        $folio = $row['folio'];
        $idEmpresaFiscal = $row['id_empresa_fiscal'];
        $idRazonSocial = $row['id_razon_social'];
        $razonSocial = $row['razon_social'];
        $rfcRazonSocial = $row['rfc_razon_social'];
        $idCliente = $row['id_cliente'];
        $usoCFDI = $row['uso_cfdi'];
        $metodoPago = $row['metodo_pago'];
        $formaPago = $row['forma_pago'];
        $email = $row['email'];
        $digitosCuenta = $row['digitos_cuenta'];
        $fecha = $row['fecha'];
        $anio = $row['anio'];
        $mes = $row['mes'];
        $observaciones = $row['observaciones'];
        $diasCredito = $row['dias_credito'];
        $porcentajeIva = $row['porcentaje_iva'];
        $subtotal = $row['subtotal'];
        $iva = $row['iva'];
        $total = $row['total'];
        $fechaInicio = $row['fecha_inicio'];
        $fechaFin = $row['fecha_fin'];
        $estatus = $row['estatus'];
        $empresaFiscal = $row['empresa_fiscal'];
        $idCFDI = $row['id_cfdi'];
        $cliente = $row['cliente'];
        $facturasRelacionadas = $row['facturas_relacionadas'];
        $numNotasCredito = $row['num_notas_credito'];
        $retencion = $row['retencion'];
        $importeRetencion = $row['importe_retencion'];
        $ret = $row['ret'];
        $idAlmacenE = $row['id_almacen_e'];
        $folioVenta = $row['folio_venta'];
        $clienteAlterno = $row['cliente_alterno'];
        $usoCDFI = $row['uso_cfdi'];
        $folioFiscal = $row['folio_fiscal'];

        $cfdiDenken = new CFDIDenken();
        $rowB = $cfdiDenken -> obtenerDatosFacturaE($idFacturaCFDI);

        $subtotalOriginal = $rowB['subtotal']; 
        $ivaOriginal = $rowB['iva']; 
        $moneda = $rowB['moneda'];  
        $tipoCambio = $rowB['tcambio'];  
        $importeRetencionOriginal = $rowB['importe_retencion']; 

        $array[] = array('id'=>$id,'id_factura_cfdi'=>$idFacturaCFDI,
        'folio_fiscal'=>$folioFiscal,
        'id_unidad_negocio'=>$idUnidadNegocio,'id_sucursal'=>$idSucursal,
        'folio'=>$folio,'id_empresa_fiscal'=>$idEmpresaFiscal,
        'id_razon_social'=>$idRazonSocial,'razon_social'=>$razonSocial,
        'rfc_razon_social'=>$rfcRazonSocial,'id_cliente'=>$idCliente,
        'uso_cfdi'=>$usoCDFI,'metodo_pago'=>$metodoPago,'forma_pago'=>$formaPago,
        'email'=>$email,'digitos_cuenta'=>$digitosCuenta,'fecha'=>$fecha,'anio'=>$anio,
        'mes'=>$mes,'observaciones'=>$observaciones,'dias_credito'=>$diasCredito,
        'porcentaje_iva'=>$porcentajeIva,'subtotal'=>$subtotal,'iva'=>$iva,'total'=>$total,
        'fecha_inicio'=>$fechaInicio,'fecha_fin'=>$fechaFin,'estatus'=>$estatus,
        'empresa_fiscal'=>$empresaFiscal,'id_cfdi'=>$idCFDI,'cliente'=>$cliente,
        'facturas_relacionadas'=>$facturasRelacionadas,'num_notas_credito'=>$numNotasCredito,
        'retencion'=>$retencion,'importe_retencion'=>$importeRetencion,'ret'=>$ret,
        'id_almacen_e'=>$idAlmacenE,'folio_venta'=>$folioVenta,'cliente_alterno'=>$clienteAlterno,
        'subtotal_original'=>$subtotalOriginal,'iva_original'=>$ivaOriginal,'moneda'=>$moneda,
        'tipo_cambio'=>$tipoCambio,'importe_retencion_original'=>$importeRetencionOriginal);

        return json_encode($array);

    }//- fin function buscarFacturasId

    function buscarFacturasDetalleId($idFactura){
        //-->NJES Feb/20/2020 se obtiene el descuento porque en ventas alarmas pueden traer descuento y se prorratea para las partidas al guardar prefactura
        $result = $this->link->query("SELECT a.id,a.cantidad,a.precio_unitario,((a.importe*b.porcentaje_iva)/100) AS iva,
                                        IF(b.retencion=1,(((a.importe*b.porcentaje_iva)/100)+a.importe)-((a.importe*6)/100),(((a.importe*b.porcentaje_iva)/100)+a.importe)) AS importe,
                                        IF(b.retencion=1,(a.importe*6)/100,0) AS retencion,
                                        a.descripcion,a.clave_unidad_sat,a.unidad_sat,
                                        a.clave_producto_sat,a.producto_sat,a.id_cxc,a.id_servicio,
                                        a.porcentaje_descuento,a.monto_descuento,b.porcentaje_iva,b.retencion AS bandera_retencion,
                                        b.id_factura_cfdi
                                        FROM facturas_d a
                                        INNER JOIN facturas b ON a.id_factura=b.id 
                                        WHERE a.id_factura=$idFactura
                                        ORDER BY a.id ASC");
        
        return query2json($result);
    }//- fin function buscarFacturasDetalleId


    function actualizarDatosCFDI($id, $idCFDI)
    {
            $verifica = 0;
    
            $cfdiDenken = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
            
            $datosCFDI = $cfdiDenken->obtenerCFDI($idCFDI);  

            $registro = $datosCFDI['registro'];
            $tipo_cfdi = $datosCFDI['tipo_cfd'];
            $no_cert_cfdi = $datosCFDI['no_cert_cfd'];
            $cert_cfdi = $datosCFDI['cert_cfd'];
            $fecha_cfdi = $datosCFDI['fecha_cfd'];
            $hora_cfdi = $datosCFDI['hora_cfd'];
            $sello_cfdi = $datosCFDI['sello_cfd'];
            $cadena_cfdi = $datosCFDI['cadena_cfd'];
            $xml_cfdi = $datosCFDI['xml_cfd'];
            $version_timbre = $datosCFDI['version_timbre'];
            $fecha_timbre = $datosCFDI['fecha_timbre'];
            $hora_timbre = $datosCFDI['hora_timbre'];
            $no_cert_timbre = $datosCFDI['no_cert_timbre'];
            $sello_timbre = $datosCFDI['sello_timbre'];
            $uuid_timbre = $datosCFDI['uuid_timbre'];
            $xml_timbre = $datosCFDI['xml_timbre'];
            $estatus_cfd = $datosCFDI['estatus_cfd'];
            
            $query = "INSERT INTO facturas_cfdi(id_factura,tipo_cfdi,no_cert_cfdi,cert_cfdi,fecha_cfdi,hora_cfdi,
                    sello_cfdi,cadena_cfdi,xml_cfdi,version_timbre,fecha_timbre,hora_timbre,no_cert_timbre,sello_timbre,
                    uuid_timbre,xml_timbre,estatus) VALUES('$id','$tipo_cfdi','$no_cert_cfdi','$cert_cfdi','$fecha_cfdi',
                    '$hora_cfdi','$sello_cfdi','$cadena_cfdi','$xml_cfdi','$version_timbre','$fecha_timbre','$hora_timbre',
                    '$no_cert_timbre','$sello_timbre','$uuid_timbre','$xml_timbre','$estatus_cfd')";

            // error_log("primer insert Facturacion");
            // error_log($query);
            // error_log("verificando sesion again");
            // error_log(json_encode($_SESSION));

            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if($result)
            {
                $update_status = "UPDATE facturas SET estatus='T' WHERE id=".$id;
                $result_estatus = mysqli_query($this->link, $update_status) or die(mysqli_error());

                if($result_estatus)
                    $verifica = $id;
            }else
                $verifica = 0;
            
            

            return $verifica;
    }



    function validarfacturaCFDI($id)
    {


        $verifica = false;

        $result = mysqli_query($this->link, "SELECT id FROM facturas_cfdi WHERE id_factura = $id");
        $row = mysqli_fetch_assoc($result);

        if(isset($row['id']))
            $verifica = true;
        else
        {

            $queryI = "INSERT INTO facturas_cfdi (id_factura, estatus) VALUES($id, 'C')";
            $resultI = mysqli_query($this->link, $queryI) or die(mysqli_error());
            
            if($resultI)
                $verifica = true;

        }

        return $verifica;

    }

    function actualizarEstatusFactura($id,$estatus){
        $verifica = 0;
        //-->NJES Sep/10/2020 Desvincular la salida por venta de almacen de la factura cuando la factura se cancela
        if($estatus == 'C')
            $query = "UPDATE facturas SET estatus='$estatus',id_almacen_e=0 WHERE id=".$id;
        else
            $query = "UPDATE facturas SET estatus='$estatus' WHERE id=".$id;
        
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
        {

            if($this->validarfacturaCFDI($id) == true)
            {

                $query2 = "UPDATE facturas_cfdi SET estatus='$estatus' WHERE id_factura=".$id;
                $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

                if($result2)
                    $verifica = $id;
                
            }
            

        }

        return $verifica; 
    }

    function descargarAcuse($idFactura,$idCFDI){
        $verifica = 0;

        $cfdiDenken = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
            
        $datosCFDI = $cfdiDenken->obtenerAcuse($idCFDI); 
        
        $fechaCan = $datosCFDI['fecha_can'];
        $horaCan = $datosCFDI['hora_can'];
        $acuseCan = $datosCFDI['acuse_can'];

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $signature = array("'Signature'");
        $signatureEscape  = array("\'Signature\'");
        $acuseN = str_replace($signature, $signatureEscape, $acuseCan);

        $query = "UPDATE facturas_cfdi SET fecha_cancelacion='$fechaCan',hora_cancelacion='$horaCan',
                    acuse='$acuseN' WHERE id_factura=".$idFactura;
                    
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
            $verifica = $this -> actualizarEstatusFactura($idFactura,'C');
        
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
        
        return $verifica; 
    }


    function descargarXML($idFactura,$folioFactura){
        $verifica = '';

        $folio = $folioFactura.'_'.$idFactura;

        header('Content-type: text/plain');

        //if(isset($_REQUEST['tipo']))
          //  header("Content-Disposition: attachment; filename=\"nota_$folio.xml\"");
        //else
            header("Content-Disposition: attachment; filename=\"factura_$folio.xml\"");
        
        $resultXML = mysqli_query($this->link, "SELECT xml_timbre FROM facturas_cfdi WHERE id_factura = $idFactura");
        $registroXML = mysqli_fetch_assoc($resultXML);
        $verifica = $registroXML['xml_timbre'];

        return $verifica;
    }

    function generarBajaXml($idFactura,$folioFactura,$tipo){
        $verifica = 0;

        $ruta = "../facturacion/archivos/".$tipo."_" .$folioFactura."_".$idFactura.".xml";

        if (!empty($idFactura))
        {
            $query = "SELECT xml_timbre FROM facturas_cfdi WHERE id_factura = " . $idFactura;
            $consulta = mysqli_query($this->link, $query)or die(mysqli_error());
            $row = mysqli_fetch_array($consulta);
            
            $file = fopen($ruta, "w") or die("Problemas en la creación");
            fputs($file, $row['xml_timbre']);
            fclose($file);
            
            if(file_exists($ruta))
                $verifica = 1;
            else
                $verifica = 0;
        }
    
        return $verifica;
    }

    function enviarCorreoFacturaTimbrada($datos){
        
        include_once("../vendor/lib_mail/class.phpmailer.php");
        include_once("../vendor/lib_mail/class.smtp.php");

        $verifica = 0;
	
		$dest_mail = $datos["dest_mail"];
		$destinatarios = explode(',', $dest_mail);
		$mensaje = $datos["mensaje"];
		$asunto = $datos["asunto"] . " NO. " . $datos['folio'];
        $ruta = $datos['ruta'];
        
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
		$mail->IsSMTP();
		$mail->IsHTML(true);	
		// $mail->SMTPSecure = "STARTTLS";
        $mail->SMTPSecure = "ssl";
		$mail->SMTPAuth = true;
		// $mail->Host = "smtp.gmail.com";
		// $mail->Port = 587;
		// $mail->Username = "ginthercorp.info@gmail.com"; 
		// $mail->Password = "secorp2022";
        $mail->Host = "mail.ginthercorp.com";
		$mail->Port = 465;
		$mail->Username = "facturas@ginthercorp.com"; 
		$mail->Password = "secorp2022";
		

		$mail->SetFrom("facturas@ginthercorp.com","FACTURACIÓN");
        // $mail->From = "test@curiel.com";
        // $mail->FromName = "TEST2CURIEL";
		
		$mail->Subject = $asunto;
		$mail->MsgHTML($mensaje);

		for($i = 0; $i < count($destinatarios); $i++)
		{
			$mail->AddAddress($destinatarios[$i], "Contacto");	
		}
		
		$mail->AddAttachment($ruta . '.xml');

		$mail->AddAttachment($ruta . '.pdf');

		$verifica = false;
		
        if(!$mail->Send()){
			$verifica = 0; //Intento Fallido;
            error_log($mail->ErrorInfo);
		}else{
			$verifica = 1; //exito
        }

        return $verifica;
    }

    function obtenerFacturasSemana()
    {

        $query = "(select
            cat_unidades_negocio.descripcion as unidad,
            sucursales.descr as sucursal,
            contratos_cliente.id_razon_social_factura as id_empresa_fiscal,
            empresas_fiscales.razon_social as empresa_fiscal,
            empresas_fiscales.id_cfdi as id_cfdi,
            contratos_cliente.id_contrato as id_contrato,
            contratos_cliente.id_cliente as id_cliente,
            contratos_cliente.fecha as fecha_inicio_contrato,
            contratos_cliente.vigencia as fecha_fin_contrato,
            cat_clientes.nombre_comercial as cliente,
            datediff(contratos_cliente.vigencia, NOW()) as dias_contrato,
            contratos_cliente.id_razon_social as id_razon_social,
            cotizacion.id as id_cotizacion,
            cotizacion.folio as folio_cotizacion,
            cotizacion.periodicidad as periodicidad,
            cotizacion.tipo_facturacion as tipo_facturacion,
            cotizacion.fecha_inicio_facturacion as fecha_inicio_facturacion,
            cotizacion.dia as dia,
            proyecto.id_unidad_negocio as id_unidad_negocio,
            proyecto.id_sucursal as id_sucursal,
            razones_sociales.correo_facturas as correo_facturas,
            razones_sociales.razon_social as razon_social_receptor,
            razones_sociales.rfc as rfc_receptor,
            razones_sociales.codigo_postal as codigo_postal_receptor
            from contratos_cliente
            inner join cotizacion on contratos_cliente.id_cotizacion = cotizacion.id
            inner join proyecto on cotizacion.id_proyecto = proyecto.id
            inner join cat_clientes on contratos_cliente.id_cliente = cat_clientes.id
            inner join razones_sociales on contratos_cliente.id_razon_social  = razones_sociales.id
            inner join cat_unidades_negocio on proyecto.id_unidad_negocio =cat_unidades_negocio.id
            inner join sucursales on proyecto.id_sucursal = sucursales.id_sucursal
            inner join empresas_fiscales on contratos_cliente.id_razon_social_factura = empresas_fiscales.id_empresa
            where cotizacion.periodicidad = 1
            and contratos_cliente.vigencia > NOW() AND razones_sociales.activo=1)

            union

            (select
            cat_unidades_negocio.descripcion as unidad,
            sucursales.descr as sucursal,
            contratos_cliente.id_razon_social_factura as id_empresa_fiscal,
            empresas_fiscales.razon_social as empresa_fiscal,
            empresas_fiscales.id_cfdi as id_cfdi,
            contratos_cliente.id_contrato as id_contrato,
            contratos_cliente.id_cliente as id_cliente,
            contratos_cliente.fecha as fecha_inicio_contrato,
            contratos_cliente.vigencia as fecha_fin_contrato,
            cat_clientes.nombre_comercial as cliente,
            datediff(contratos_cliente.vigencia, NOW()) as dias_contrato,
            contratos_cliente.id_razon_social as id_razon_social,
            cotizacion.id as id_cotizacion,
            cotizacion.folio as folio_cotizacion,
            cotizacion.periodicidad as periodicidad,
            cotizacion.tipo_facturacion as tipo_facturacion,
            cotizacion.fecha_inicio_facturacion as fecha_inicio_facturacion,
            cotizacion.dia as dia,
            proyecto.id_unidad_negocio as id_unidad_negocio,
            proyecto.id_sucursal as id_sucursal,
            razones_sociales.correo_facturas as correo_facturas,
            razones_sociales.razon_social as razon_social_receptor,
            razones_sociales.rfc as rfc_receptor,
            razones_sociales.codigo_postal as codigo_postal_receptor
            from contratos_cliente
            inner join cotizacion on contratos_cliente.id_cotizacion = cotizacion.id
            inner join proyecto on cotizacion.id_proyecto = proyecto.id
            inner join cat_clientes on contratos_cliente.id_cliente = cat_clientes.id
            inner join razones_sociales on contratos_cliente.id_razon_social  = razones_sociales.id
            inner join cat_unidades_negocio on proyecto.id_unidad_negocio =cat_unidades_negocio.id
            inner join sucursales on proyecto.id_sucursal = sucursales.id_sucursal
            inner join empresas_fiscales on contratos_cliente.id_razon_social_factura = empresas_fiscales.id_empresa
            where cotizacion.periodicidad = 2
            and contratos_cliente.vigencia > NOW() AND razones_sociales.activo=1)

            union 

            (select
            cat_unidades_negocio.descripcion as unidad,
            sucursales.descr as sucursal,
            contratos_cliente.id_razon_social_factura as id_empresa_fiscal,
            empresas_fiscales.razon_social as empresa_fiscal,
            empresas_fiscales.id_cfdi as id_cfdi,
            contratos_cliente.id_contrato as id_contrato,
            contratos_cliente.id_cliente as id_cliente,
            contratos_cliente.fecha as fecha_inicio_contrato,
            contratos_cliente.vigencia as fecha_fin_contrato,
            cat_clientes.nombre_comercial as cliente,
            datediff(contratos_cliente.vigencia, NOW()) as dias_contrato,
            contratos_cliente.id_razon_social as id_razon_social,
            cotizacion.id as id_cotizacion,
            cotizacion.folio as folio_cotizacion,
            cotizacion.periodicidad as periodicidad,
            cotizacion.tipo_facturacion as tipo_facturacion,
            cotizacion.fecha_inicio_facturacion as fecha_inicio_facturacion,
            cotizacion.dia as dia,
            proyecto.id_unidad_negocio as id_unidad_negocio,
            proyecto.id_sucursal as id_sucursal,
            razones_sociales.correo_facturas as correo_facturas,
            razones_sociales.razon_social as razon_social_receptor,
            razones_sociales.rfc as rfc_receptor,
            razones_sociales.codigo_postal as codigo_postal_receptor
            from contratos_cliente
            inner join cotizacion on contratos_cliente.id_cotizacion = cotizacion.id
            inner join proyecto on cotizacion.id_proyecto = proyecto.id
            inner join cat_clientes on contratos_cliente.id_cliente = cat_clientes.id
            inner join razones_sociales on contratos_cliente.id_razon_social  = razones_sociales.id
            inner join cat_unidades_negocio on proyecto.id_unidad_negocio =cat_unidades_negocio.id
            inner join sucursales on proyecto.id_sucursal = sucursales.id_sucursal
            inner join empresas_fiscales on contratos_cliente.id_razon_social_factura = empresas_fiscales.id_empresa
            where cotizacion.periodicidad = 3
            and contratos_cliente.vigencia > NOW() AND razones_sociales.activo=1)

            union 

            (select
            cat_unidades_negocio.descripcion as unidad,
            sucursales.descr as sucursal,
            contratos_cliente.id_razon_social_factura as id_empresa_fiscal,
            empresas_fiscales.razon_social as empresa_fiscal,
            empresas_fiscales.id_cfdi as id_cfdi,
            contratos_cliente.id_contrato as id_contrato,
            contratos_cliente.id_cliente as id_cliente,
            contratos_cliente.fecha as fecha_inicio_contrato,
            contratos_cliente.vigencia as fecha_fin_contrato,
            cat_clientes.nombre_comercial as cliente,
            datediff(contratos_cliente.vigencia, NOW()) as dias_contrato,
            contratos_cliente.id_razon_social as id_razon_social,
            cotizacion.id as id_cotizacion,
            cotizacion.folio as folio_cotizacion,
            cotizacion.periodicidad as periodicidad,
            cotizacion.tipo_facturacion as tipo_facturacion,
            cotizacion.fecha_inicio_facturacion as fecha_inicio_facturacion,
            cotizacion.dia as dia,
            proyecto.id_unidad_negocio as id_unidad_negocio,
            proyecto.id_sucursal as id_sucursal,
            razones_sociales.correo_facturas as correo_facturas,
            razones_sociales.razon_social as razon_social_receptor,
            razones_sociales.rfc as rfc_receptor,
            razones_sociales.codigo_postal as codigo_postal_receptor
            from contratos_cliente
            inner join cotizacion on contratos_cliente.id_cotizacion = cotizacion.id
            inner join proyecto on cotizacion.id_proyecto = proyecto.id
            inner join cat_clientes on contratos_cliente.id_cliente = cat_clientes.id
            inner join razones_sociales on contratos_cliente.id_razon_social  = razones_sociales.id
            inner join cat_unidades_negocio on proyecto.id_unidad_negocio =cat_unidades_negocio.id
            inner join sucursales on proyecto.id_sucursal = sucursales.id_sucursal
            inner join empresas_fiscales on contratos_cliente.id_razon_social_factura = empresas_fiscales.id_empresa
            where cotizacion.periodicidad = 4
            and contratos_cliente.vigencia > NOW() AND razones_sociales.activo=1)

            order by id_contrato desc";

    $result = $this->link->query($query);
    return $result;

}

function buscarDiasSemana($tipo, $dia)
{

    $diaF = "";

    $diario = [

        'L'=>'monday this week',
        'M;'=>'tuesday this week',
        'X'=>'wednesday this week',
        'J'=>'thursday this week',
        'V'=>'friday this week',
        'S'=>'saturday this week',
        'D'=>'sunday this week',

    ];

    $diaActual = date("d");

    $quincenal = [

        'Q1'=>[1, 16],
        'Q2'=>[2, 17],
        'Q3'=>[3, 18],
        'Q4'=>[4, 19],
        'Q5'=>[5, 20],
        'Q6'=>[6, 21],
        'Q7'=>[7, 22],
        'Q8'=>[8, 23],
        'Q9'=>[9, 24],
        'Q10'=>[10, 25],
        'Q11'=>[11, 26],
        'Q12'=>[12, 27],
        'Q13'=>[13, 28],
        'Q14'=>[14, 29],
        'Q15'=>[15, 30]

    ];

    if($tipo == 1)
        $diaF = date('Y-m-d', strtotime( $diario[$dia] ));
    else if($tipo == 2)
    {

        $nQ = $quincenal[$dia];
        $key = 0;
        if($diaActual > 15)
            $key = 1;

        if($nQ[$key] < 10)
            $diaF = date("Y") . '-' . date("m") . '-0' . $nQ[$key];
        else
            $diaF = date("Y") . '-' . date("m") . '-' . $nQ[$key]; 

    }else if($tipo == 3)
        $diaF = date("Y") . '-' . date("m") . '-' . $dia;
    else
        $diaF = $dia;

    //if( (date('Y-m-d', strtotime($diaF))) >= date( 'Y-m-d', strtotime( 'monday this week' )) == false && (date('Y-m-d', strtotime($diaF))) <= date( 'Y-m-d', strtotime( 'sunday this week' )) == false)

    $c = 0;
    if( (date('Y-m-d', strtotime($diaF))) >= date( 'Y-m-d', strtotime( 'monday this week' )) == false)
        $c++;

    if((date('Y-m-d', strtotime($diaF))) <= date( 'Y-m-d', strtotime( 'sunday this week' )) == false)
        $c++;

    if($c > 0)
        $diaF = "";

    return $diaF;

}

function buscarDiasSiguiente($tipo, $dia)
{

    $diaF = "";

    $diario = [

        'L'=>'monday next week',
        'M;'=>'tuesday next week',
        'X'=>'wednesday next week',
        'J'=>'thursday next week',
        'V'=>'friday next week',
        'S'=>'saturday next week',
        'D'=>'sunday next week',

    ];

    $diaActual = date("d");

    $quincenal = [

        'Q1'=>[1, 16],
        'Q2'=>[2, 17],
        'Q3'=>[3, 18],
        'Q4'=>[4, 19],
        'Q5'=>[5, 20],
        'Q6'=>[6, 21],
        'Q7'=>[7, 22],
        'Q8'=>[8, 23],
        'Q9'=>[9, 24],
        'Q10'=>[10, 25],
        'Q11'=>[11, 26],
        'Q12'=>[12, 27],
        'Q13'=>[13, 28],
        'Q14'=>[14, 29],
        'Q15'=>[15, 30]

    ];

    if($tipo == 1)
        $diaF = date('Y-m-d', strtotime( $diario[$dia] ));
    else if($tipo == 2)
    {

        $nQ = $quincenal[$dia];
        $key = 0;
        if($diaActual > 15)
            $key = 1;

        if($nQ[$key] < 10)
            $diaF = date("Y") . '-' . date("m") . '-0' . $nQ[$key];
        else
            $diaF = date("Y") . '-' . date("m") . '-' . $nQ[$key];

    }//-->NJES May/21/2020 se agrega periodicidad 4 (Unico) una fecha unica
    else if($tipo == 3)
        $diaF = date("Y") . '-' . date("m") . '-' . $dia;
    else
        $diaF = $dia;

    //if( (date('Y-m-d', strtotime($diaF))) >= date( 'Y-m-d', strtotime( 'monday this week' )) == false && (date('Y-m-d', strtotime($diaF))) <= date( 'Y-m-d', strtotime( 'sunday this week' )) == false)

    $c = 0;
    if( (date('Y-m-d', strtotime($diaF))) >= date( 'Y-m-d', strtotime( 'monday next week' )) == false)
        $c++;

    if((date('Y-m-d', strtotime($diaF))) <= date( 'Y-m-d', strtotime( 'sunday next week' )) == false)
        $c++;

    if($c > 0)
        $diaF = "";

    return $diaF;

}

function fechaInicioPeriodoFacturacion($tipo, $dia){
    $diaF = "";

    $diario = [

        'L'=>'monday this week',
        'M;'=>'tuesday this week',
        'X'=>'wednesday this week',
        'J'=>'thursday this week',
        'V'=>'friday this week',
        'S'=>'saturday this week',
        'D'=>'sunday this week',

    ];

    $diaActual = date("d");

    $quincenal = [

        'Q1'=>[1, 16],
        'Q2'=>[2, 17],
        'Q3'=>[3, 18],
        'Q4'=>[4, 19],
        'Q5'=>[5, 20],
        'Q6'=>[6, 21],
        'Q7'=>[7, 22],
        'Q8'=>[8, 23],
        'Q9'=>[9, 24],
        'Q10'=>[10, 25],
        'Q11'=>[11, 26],
        'Q12'=>[12, 27],
        'Q13'=>[13, 28],
        'Q14'=>[14, 29],
        'Q15'=>[15, 30]

    ];

    if($tipo == 1)
        $diaF = date('Y-m-d', strtotime( $diario[$dia] ));
    else if($tipo == 2)
    {

        $nQ = $quincenal[$dia];
        $key = 0;
        if($diaActual > 15)
            $key = 1;

        if($nQ[$key] < 10)
            $diaF = date("Y") . '-' . date("m") . '-0' . $nQ[$key];
        else
            $diaF = date("Y") . '-' . date("m") . '-' . $nQ[$key]; 

    }else if($tipo == 3)
        $diaF = date("Y") . '-' . date("m") . '-' . $dia;
    else
        $diaF = $dia;


    return $diaF;
}

/* para obtener la fecha fin periodo de una factura*/
function fechaFinPeriodoFacturacion($tipo,$dia,$fechaInicioPeriodo){
    $diaF = "";

    $diario = [

        'L'=>'monday next week',
        'M;'=>'tuesday next week',
        'X'=>'wednesday next week',
        'J'=>'thursday next week',
        'V'=>'friday next week',
        'S'=>'saturday next week',
        'D'=>'sunday next week',

    ];

    $diaActual = date("d",strtotime($fechaInicioPeriodo));
    $mesActual = date("m",strtotime($fechaInicioPeriodo));
    $anioActual = date("Y",strtotime($fechaInicioPeriodo));

    $quincenal = [

        'Q1'=>[1, 16],
        'Q2'=>[2, 17],
        'Q3'=>[3, 18],
        'Q4'=>[4, 19],
        'Q5'=>[5, 20],
        'Q6'=>[6, 21],
        'Q7'=>[7, 22],
        'Q8'=>[8, 23],
        'Q9'=>[9, 24],
        'Q10'=>[10, 25],
        'Q11'=>[11, 26],
        'Q12'=>[12, 27],
        'Q13'=>[13, 28],
        'Q14'=>[14, 29],
        'Q15'=>[15, 30]

    ];

    if($tipo == 1)
    {
        //$diaF = date('Y-m-d', strtotime( $diario[$dia] ));
        $diaF = date("Y-m-d",strtotime($diario[$dia],strtotime($fechaInicioPeriodo)));
    }else if($tipo == 2)
    {

        $nQ = $quincenal[$dia];
        
        if($diaActual > 15)
        {
            if($mesActual < 12)
            {
                $mesActual++;
                if($mesActual < 10)
                {
                    if($nQ[0] < 10)
                        $diaF = $anioActual . '-0' . $mesActual . '-0' . $nQ[0];
                    else
                        $diaF = $anioActual . '-0' . $mesActual . '-' . $nQ[0];
                }else{
                    if($nQ[0] < 10)
                        $diaF = $anioActual . '-' . $mesActual . '-0' . $nQ[0];
                    else
                        $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[0];
                }
            }else{
                $mesActual = '01';
                $anioActual++;
                if($nQ[0] < 10)
                    $diaF = $anioActual . '-' . $mesActual . '-0' . $nQ[0];
                else
                    $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[0];
            }
        }else
        {
            $diaF = $anioActual . '-' . $mesActual  . '-' . $nQ[1];
        }

    }else if($tipo == 3){
        if($mesActual < 12)
        {
            $mesActual++;
            if($mesActual < 10)
                $diaF = $anioActual . '-0' . $mesActual . '-' . $dia;
            else
                $diaF = $anioActual . '-' . $mesActual . '-' . $dia;
        }else{
            $mesActual = '01';
            $anioActual++;
            $diaF = $anioActual . '-' . $mesActual . '-' . $dia;
        }
      
    //-->NJES May/21/2020 se agrega periodicidad 4 (Unico) una fecha unica
    }else
        $diaF = $dia;

    return $diaF;
}

function verificaFactura($idContrato, $fechaFacturar)
{

    $result = mysqli_query($this->link, "SELECT  COUNT(*) as verifica FROM facturas WHERE id_contrato = $idContrato AND fecha ='$fechaFacturar'");
    $row = mysqli_fetch_assoc($result);
    return $row['verifica']; 

}
    function guardarSeguimientoPartidas($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $idClaveSATProducto = $datos['idClaveSATProducto'];
        $idClaveSATUnidad = $datos['idClaveSATUnidad'];
        $nombreUnidadSAT = $datos['nombreUnidadSAT'];
        $nombreProductoSAT = $datos['nombreProductoSAT'];
        $cantidad = $datos['cantidad'];
        $precio = $datos['precio'];
        $importe = $datos['importe'];
        $descripcion = $datos['descripcion'];
        $idCliente = $datos['idCliente'];
        $idPartida = $datos['idPartida'];

        if($idPartida == 0)
        {
            $query = "INSERT INTO facturas_seguimiento_d(id_cliente,cantidad,precio_unitario,
                    importe,descripcion,clave_unidad_sat,unidad_sat,clave_producto_sat,producto_sat,chk_timbrar) 
                    VALUES ('$idCliente','$cantidad','$precio','$importe','$descripcion',
                    '$idClaveSATUnidad','$nombreUnidadSAT','$idClaveSATProducto','$nombreProductoSAT',0)";
        }else{
            $query = "UPDATE facturas_seguimiento_d SET cantidad='$cantidad',
                    precio_unitario='$precio',importe='$importe',descripcion='$descripcion',
                    clave_unidad_sat='$idClaveSATUnidad',unidad_sat='$nombreUnidadSAT',
                    clave_producto_sat='$idClaveSATProducto',producto_sat='$nombreProductoSAT',chk_timbrar=0
                    WHERE id=".$idPartida;
        }

        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result) 
            $verifica = 1;
        else
            $verifica = 0;
        

        if($verifica > 0)
            $this->link->query("COMMIT;");
        else
            $this->link->query('ROLLBACK;');

        return $verifica;
    }

    function buscarSeguimientoPartidas($idCliente){
        $result = $this->link->query("SELECT id,cantidad,precio_unitario,importe,descripcion,
                                    clave_unidad_sat,unidad_sat,clave_producto_sat,producto_sat,
                                    chk_timbrar
                                    FROM facturas_seguimiento_d 
                                    WHERE id_cliente=$idCliente
                                    ORDER BY id ASC");
        
        return query2json($result);
    }

    function actualizarSeleccionChkPartida($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $idPartida = $datos['idPartida'];
        $opcion = $datos['opcion'];

        $query = "UPDATE facturas_seguimiento_d SET chk_timbrar='$opcion' WHERE id=".$idPartida;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result) 
            $verifica = 1;
        else
            $verifica = 0;
        

        if($verifica > 0)
            $this->link->query("COMMIT;");
        else
            $this->link->query('ROLLBACK;');

        return $verifica;
    }

    function eliminarPartida($idPartida){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $query = "DELETE FROM facturas_seguimiento_d WHERE id=".$idPartida;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result) 
            $verifica = 1;
        else
            $verifica = 0;
        

        if($verifica > 0)
            $this->link->query("COMMIT;");
        else
            $this->link->query('ROLLBACK;');

        return $verifica;
    }

    function actualizarDatosCliente($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $idCliente = $datos['idCliente'];
        $idEmpresaFiscalEmisor = $datos['idEmpresaFiscalEmisor'];
        $idUsoCFDI = $datos['idUsoCFDI'];
        $idMetodoPago = $datos['idMetodoPago'];
        $idFormaPago = $datos['idFormaPago'];
        $tasaIva = $datos['tasaIva'];
        $digitosCuenta = $datos['digitosCuenta'];
        $observaciones = $datos['observaciones'];
        $usuario = $datos['usuario'];


        $query = "UPDATE cat_clientes SET id_empresa_fiscal='$idEmpresaFiscalEmisor',
                    uso_cfdi='$idUsoCFDI',metodo_pago='$idMetodoPago',forma_pago='$idFormaPago',
                    tasa_iva='$tasaIva',digitos_cuenta='$digitosCuenta',observaciones='$observaciones'
                    WHERE id=".$idCliente;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result) 
            $verifica = $this -> guardarActualizar($datos);
        else
            $verifica = 0;
        
        if($verifica > 0)
            $this->link->query("COMMIT;");
        else
            $this->link->query('ROLLBACK;');

        return $verifica;
    }

    function buscarSeguimientoidCliente($idCliente){
        $result = $this->link->query("SELECT IFNULL(b.razon_social,'') AS empresa_fiscal,a.id_empresa_fiscal,
        a.uso_cfdi,a.metodo_pago,a.forma_pago,a.tasa_iva,a.digitos_cuenta,
        IFNULL(a.subtotal,0) AS subtotal,IFNULL(a.iva,0) AS iva,IFNULL(a.total,0) AS total,a.observaciones,IFNULL(b.id_cfdi,0) AS id_cfdi
        FROM cat_clientes a
        LEFT JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
        WHERE a.id=".$idCliente);
        
        return query2json($result);
    }

    function buscarFacturasCanceladas($datos){

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idCliente = $datos['idCliente'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $idRazonSocial = $datos['idRazonSocial'];

        $result = $this->link->query("SELECT a.id,a.folio,a.id_factura_cfdi,IFNULL(d.uuid_timbre,'') AS folio_fiscal,a.total,a.fecha, 
        a.razon_social AS razon_social_receptor,a.rfc_razon_social AS rfc_receptor,
        b.razon_social AS empresa_fiscal_emisor,b.rfc AS rfc_emisor,c.nombre_comercial AS cliente_receptor
        FROM facturas a
        INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
        INNER JOIN razones_sociales r ON a.id_razon_social = r.id
        INNER JOIN cat_clientes c ON a.id_cliente=c.id
        INNER JOIN facturas_cfdi d ON a.id=d.id_factura
        WHERE NOT EXISTS(SELECT 
        r.id_factura AS id_factura_nueva,
        r.id_factura_sustituida AS factura_sustituida
        FROM facturas_r r
        INNER JOIN facturas aa ON r.id_factura = aa.id
        INNER JOIN facturas bb ON r.id_factura_sustituida = bb.id
        LEFT JOIN facturas_cfdi cc ON aa.id=cc.id_factura
        WHERE IF(aa.estatus = 'C', cc.uuid_timbre IS NOT NULL, aa.estatus IN('A','T')) AND r.id_factura_sustituida = a.id)
        AND a.id_unidad_negocio=$idUnidadNegocio AND a.id_sucursal=$idSucursal 
        AND a.id_cliente=$idCliente AND a.id_empresa_fiscal=$idEmpresaFiscal AND a.es_plan=0 AND a.es_venta_orden=0 
        AND a.id_razon_social=$idRazonSocial AND LENGTH(d.uuid_timbre) > 0 AND   a.estatus='C'");
        
        return query2json($result);
    }

    function buscarFacturasSustituidasId($idFactura){
        $result = $this->link->query("SELECT e.id_factura_sustituida AS id,a.folio AS folio_interno,
        f.uuid_timbre AS folio_fiscal,a.fecha,a.total
        FROM facturas_r e 
        LEFT JOIN facturas_cfdi f ON e.id_factura_sustituida=f.id_factura
        LEFT JOIN facturas a ON a.id=e.id_factura_sustituida
        WHERE e.id_factura=".$idFactura);
        
        return query2json($result);
    }//- fin function buscarFacturasSustituidasId

    function buscarFacturasIdClienteUnCxc($datos){

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idCliente = $datos['idCliente'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $metodoPago = $datos['metodoPago'];
        $idRazonSocial = $datos['idRazonSocial']; 
        //
        //-->NJES April/03/2020 realiza la busqueda por rfc o por cliente y razón social
        $mismoRFC = isset($datos['mismoRFC']) ? $datos['mismoRFC'] : 0 ;
        $rfc = isset($datos['rfc']) ? $datos['rfc'] : '' ;

        $nombreUnidad = isset($datos['nombreUnidad']) ? $datos['nombreUnidad'] : '' ;

        //-->NJES Jun/11/2021 filtra por moneda
        $moneda = isset($datos['moneda']) ? $datos['moneda'] : '' ;

        //-->NJES October/29/2020 mostrar por default las facturas con saldo insoluto mayor a 0, 
        //o mostrar las de saldo insoluto 0
        $saldo_insoluto_cero = isset($datos['saldo_insoluto_cero']) ? $datos['saldo_insoluto_cero'] : 0 ;
        
        //-->NJES Jun/22/2021 tomar como saldo insoluto cero el de la moneda original (pesos o dolares)
        if($saldo_insoluto_cero == 0)
            $condSaldoInsoluto = ' HAVING tab.saldo_insoluto_moneda > 0 ';
        else
            $condSaldoInsoluto = ' HAVING tab.saldo_insoluto_moneda <= 0';

        if($mismoRFC == 1)
        {
            //-->NJES April/17/2020 si es una unidad diferente de alarmas no buscar por sucursal
            // ni por razon social y buscar por cliente y rfc
            if($nombreUnidad == 'ALARMAS')
                $cond = " AND a.id_sucursal=$idSucursal AND a.rfc_razon_social='$rfc'";  
            else
                $cond = " AND a.id_cliente=$idCliente AND a.rfc_razon_social='$rfc'";
        }else
            $cond = " AND a.id_sucursal=$idSucursal AND a.id_cliente=$idCliente AND a.id_razon_social=$idRazonSocial ";
           
        $query = "
        SELECT * FROM (SELECT sub.*, IFNULL(SUM(IF(w.retencion=1,w.total-w.importe_retencion,w.total)),0) AS abonos_ncii,
        IFNULL(sub.total_notas, 0) AS abonos_nc,
        IFNULL(sub.total_notas_usd, 0) AS abonos_nc_usd,
        (sub.saldo_inicial-sub.total_abonos-IFNULL(sub.total_notas,0))AS saldo_insoluto,
        (sub.saldo_inicial_usd-sub.total_abonos_usd-IFNULL(sub.total_notas_usd,0))AS saldo_insoluto_usd,
        IF(sub.moneda = 'MXN',(sub.saldo_inicial-sub.total_abonos-IFNULL(sub.total_notas,0)),(sub.saldo_inicial_usd-sub.total_abonos_usd-IFNULL(sub.total_notas_usd,0))) AS saldo_insoluto_moneda,
        COUNT(DISTINCT(IFNULL(fd.id_cxc,''))) AS registros_cxc
        FROM (        
            SELECT a.id,a.id_factura_cfdi,a.id_cliente,k.descr AS sucursal,a.id_sucursal, 
            a.moneda,a.tipo_cambio,      
            IF(a.id_cliente>0,IF(i.nombre='ALARMAS',j.nombre_corto,g.nombre_comercial),'VENTA PUBLICO EN GENERAL') AS cliente,        
            a.rfc_razon_social,a.folio,IFNULL(c.uuid_timbre,'') AS folio_uuid,a.fecha,        
            a.observaciones AS referencia,        
            IF(a.retencion=1,a.total-a.descuento-a.importe_retencion,a.total-a.descuento) AS saldo_inicial,
            IF(a.retencion=1,a.total_usd-a.importe_retencion_usd,a.total_usd) AS saldo_inicial_usd,        
            IFNULL(total_a.total_abonos, 0) AS total_abonos,
            IFNULL(total_a.total_abonos_usd, 0) AS total_abonos_usd,
            COUNT(DISTINCT(IFNULL(fd.id_cxc,''))) AS registros_cxc_a,  
            not_a.total_notas,
            IFNULL(not_a.total_notas_usd, 0) AS total_notas_usd,
            IFNULL(not_a.id_factura_cfdi_nc,'') AS ids_factura_cfdi_nc
            FROM facturas a   
            INNER JOIN sucursales k on a.id_sucursal=k.id_sucursal     
            INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa        
            INNER JOIN facturas_cfdi c ON a.id=c.id_factura        
            LEFT JOIN pagos_d d ON a.id = d.id_factura        
            LEFT JOIN pagos_e e ON d.id_pago_e = e.id        
            LEFT JOIN pagos_cfdi f ON d.id_pago_e = f.id_pago_e        
            LEFT JOIN cat_clientes g ON a.id_cliente=g.id        
            INNER JOIN cat_unidades_negocio i ON a.id_unidad_negocio=i.id        
            LEFT JOIN servicios j ON a.id_cliente=j.id
            LEFT JOIN        
            (       SELECT SUM(importe_pagado) AS total_abonos,    
                SUM(importe_pagado_usd) AS total_abonos_usd,         
                id_factura AS id_factura            
                FROM             pagos_d            
                INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e             
                WHERE pagos_cfdi.estatus_cfdi IN  ('T', 'A')            
                GROUP BY id_factura        
            ) total_a ON a.id  = total_a.id_factura                
            LEFT JOIN 
		(
			SELECT SUM(aa.total - aa.importe_retencion) AS total_notas,
            SUM(aa.total_usd - aa.importe_retencion_usd) AS total_notas_usd,
			aa.id_factura_nota_credito,GROUP_CONCAT(aa.id_factura_cfdi) AS id_factura_cfdi_nc
			FROM 
			facturas aa
			INNER JOIN facturas_cfdi ff ON aa.id = ff.id_factura 
			WHERE ff.estatus = 'T'
			GROUP BY aa.id_factura_nota_credito
		) not_a ON a.id = not_a.id_factura_nota_credito
            LEFT JOIN         
            (       SELECT pagos_d.id_factura AS id_fac, SUM(pagos_d.importe_pagado) AS total_pagos        
                FROM pagos_d        
                INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e        
                WHERE         pagos_cfdi.estatus_cfdi != 'C'        
                GROUP BY pagos_d.id_factura        
            ) otro ON d.id_factura = otro.id_fac 
            
            LEFT JOIN facturas_d fd ON a.id=fd.id_factura
            WHERE a.id_unidad_negocio=$idUnidadNegocio 
            $cond AND a.id_empresa_fiscal=$idEmpresaFiscal
            AND a.metodo_pago='$metodoPago' AND a.id_factura_nota_credito=0 AND c.estatus='T' 
          
            GROUP BY a.id
            ORDER BY a.fecha DESC) AS sub
            LEFT JOIN facturas w ON sub.id=w.id_factura_nota_credito AND w.estatus='T' 
            LEFT JOIN facturas_d fd ON sub.id=fd.id_factura 
            GROUP BY sub.id
            ORDER BY sub.fecha DESC ) AS tab
            $condSaldoInsoluto
            /*HAVING registros_cxc=1*/";

            // echo $query;
            // exit();

        //$result = $this->link->query("
        $result = mysqli_query($this->link,$query);
        
        //return query2json($result);

        //-->NJES Jun/11/2021
        $array = array();

        while($row = mysqli_fetch_assoc($result))
        {
            $id = $row['id'];
            $idCliente = $row['id_cliente'];
            $sucursal = $row['sucursal'];
            $idSucursal = $row['id_sucursal'];   
            $cliente = $row['cliente'];  
            $rfcRazonSocial = $row['rfc_razon_social'];
            $folio = $row['folio'];
            $folioUUID = $row['folio_uuid'];
            $fecha = $row['fecha'];    
            $referencia = $row['referencia'];       
            $saldoInicial = $row['saldo_inicial'];      
            $totalAbonos = $row['total_abonos'];
            $registrosCxcA = $row['registros_cxc_a'];
            $totalNotas = $row['total_notas'];
            $abonosNcii = $row['abonos_ncii'];
            $abonosNC = $row['abonos_nc'];
            $saldoInsoluto = $row['saldo_insoluto'];
            $registrosCxc = $row['registros_cxc'];
            $idFacturaCFDI = $row['id_factura_cfdi'];
            $idsFacturaCfdiNc = $row['ids_factura_cfdi_nc'];

            $monedaOriginal = $row['moneda'];  
            $tipoCambio = $row['tipo_cambio'];

            $saldoInsolutoMoneda = $row['saldo_insoluto_moneda'];

            if($monedaOriginal != 'MXN')
            {
                $cargoOriginal = $row['saldo_inicial_usd']; 
                $abonoOriginal = $row['total_abonos_usd']+$row['abonos_nc_usd']; 
                $saldoOriginal = $row['saldo_insoluto_usd']; 
            }else{
                $cargoOriginal = $row['saldo_inicial']; 
                $abonoOriginal = $row['total_abonos']+$row['abonos_nc']; 
                $saldoOriginal = $row['saldo_insoluto']; 
            }

            if($monedaOriginal == $moneda)
            {

                $array[] = array('id'=>$id,'id_cliente'=>$idCliente,'sucursal'=>$sucursal,
                        'id_sucursal'=>$idSucursal,'cliente'=>$cliente,'rfc_razon_social'=>$rfcRazonSocial,
                        'folio'=>$folio,'folio_uuid'=>$folioUUID,'fecha'=>$fecha,'referencia'=>$referencia,
                        'saldo_inicial'=>$saldoInicial,'total_abonos'=>$totalAbonos,
                        'registros_cxc_a'=>$registrosCxcA,'total_notas'=>$totalNotas,'abonos_ncii'=>$abonosNcii,
                        'abonos_nc'=>$abonosNC,'saldo_insoluto'=>$saldoInsoluto,'registros_cxc'=>$registrosCxc,
                        'moneda'=>$monedaOriginal,'cargo_original'=>$cargoOriginal,'abono_original'=>$abonoOriginal,
                        'saldo_original'=>$saldoOriginal,'saldo_insoluto_moneda'=>$saldoInsolutoMoneda);

            }
        }

        return json_encode($array);

    }//- fin function buscarFacturasIdCliente

    function buscarFacturasIdCliente($datos){

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idCliente = $datos['idCliente'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $metodoPago = $datos['metodoPago'];
        $idRazonSocial = $datos['idRazonSocial']; 

        $result = $this->link->query("
            SELECT sub.*, IFNULL(SUM(IF(w.retencion=1,w.total-w.importe_retencion,w.total)),0) AS abonos_nc,(sub.saldo_inicial-sub.total_abonos-IFNULL(SUM(IF(w.retencion=1,w.total-w.importe_retencion,w.total)),0))AS saldo_insoluto
            FROM (
            SELECT a.id,a.folio,IFNULL(c.uuid_timbre,'') AS folio_uuid,a.fecha,
            a.observaciones AS referencia,
            IF(a.retencion=1,a.total-a.importe_retencion-a.descuento,a.total-a.descuento) AS saldo_inicial,
            IFNULL(total_a.total_abonos, 0) AS total_abonos
            FROM facturas a
            INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
            INNER JOIN facturas_cfdi c ON a.id=c.id_factura
            LEFT JOIN pagos_d d ON a.id = d.id_factura
            LEFT JOIN pagos_e e ON d.id_pago_e = e.id
            LEFT JOIN pagos_cfdi f ON d.id_pago_e = f.id_pago_e
            LEFT JOIN
            (
                SELECT SUM(importe_pagado) AS total_abonos,
                id_factura AS id_factura
                FROM 
                pagos_d
                INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
                WHERE pagos_cfdi.estatus_cfdi IN  ('T', 'A')
                GROUP BY id_factura
            ) total_a ON a.id  = total_a.id_factura
            
            LEFT JOIN 
            (
            SELECT pagos_d.id_factura AS id_fac, SUM(pagos_d.importe_pagado) AS total_pagos
            FROM pagos_d
            INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e
            WHERE 
            pagos_cfdi.estatus_cfdi != 'C'
            GROUP BY pagos_d.id_factura
            ) otro ON d.id_factura = otro.id_fac
            WHERE a.id_unidad_negocio=$idUnidadNegocio AND a.id_sucursal=$idSucursal
            AND a.id_cliente=$idCliente AND a.id_razon_social=$idRazonSocial AND a.id_empresa_fiscal=$idEmpresaFiscal
            AND a.metodo_pago='$metodoPago' AND a.id_factura_nota_credito=0 AND c.estatus='T' 
          
            GROUP BY a.id
            ORDER BY a.fecha DESC) AS sub
            LEFT JOIN facturas w ON sub.id=w.id_factura_nota_credito AND w.estatus='T' 
            GROUP BY sub.id");
        
        return query2json($result);

    }//- fin function buscarFacturasIdCliente

    function buscarSaldoFacturaId($idFactura){
        $result = $this->link->query("SELECT sub.folio,sub.cargo_inicial,sub.cargo_inicial_usd,
        (sub.cargo_inicial-IFNULL(sub.total_abonos,0)-IFNULL(SUM(IF(w.retencion=1,w.total-w.importe_retencion,w.total)),0))AS saldo,
        (sub.cargo_inicial_usd-IFNULL(sub.total_abonos_usd,0)-IFNULL(SUM(IF(w.retencion=1,w.total_usd-w.importe_retencion_usd,w.total_usd)),0))AS saldo_usd
        FROM (
        SELECT a.id,a.folio,
        IF(a.retencion=1,a.total-a.importe_retencion-a.descuento,a.total-a.descuento) AS cargo_inicial,
        IF(a.retencion=1,a.total_usd-a.importe_retencion_usd-a.descuento,a.total_usd-a.descuento) AS cargo_inicial_usd,
        IFNULL(total_a.total_abonos, 0) AS total_abonos,
        IFNULL(total_a.total_abonos_usd, 0) AS total_abonos_usd
        FROM facturas a
        INNER JOIN facturas_cfdi c ON a.id=c.id_factura
        LEFT JOIN pagos_d d ON a.id = d.id_factura
        LEFT JOIN
        (
        SELECT SUM(importe_pagado) AS total_abonos,
        SUM(importe_pagado_usd) AS total_abonos_usd,
        id_factura AS id_factura
        FROM 
        pagos_d
        INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
        WHERE pagos_cfdi.estatus_cfdi IN  ('A','T')
        GROUP BY id_factura
        ) total_a ON a.id  = total_a.id_factura
        
        LEFT JOIN 
        (
        SELECT pagos_d.id_factura AS id_fac, SUM(pagos_d.importe_pagado) AS total_pagos
        FROM pagos_d
        INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e
        WHERE 
        pagos_cfdi.estatus_cfdi != 'C'
        GROUP BY pagos_d.id_factura
        ) otro ON d.id_factura = otro.id_fac
        WHERE a.id=$idFactura AND a.id_factura_nota_credito=0 AND c.estatus='T' 
        
        GROUP BY a.id
        ORDER BY a.fecha DESC) AS sub
        LEFT JOIN facturas w ON sub.id=w.id_factura_nota_credito AND w.estatus='T' 
        GROUP BY sub.id");
        
        return query2json($result);
    }//- fin function buscarSaldoFacturaId

    function buscarFacturasPagosTimbrados($datos){
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $tipo = $datos['tipo'];

        if($idSucursal != '')  //-->No tengo sucursales con permisos en la unidad entonces debo regresar un array vacio
        {
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }

            if($fechaInicio == '' && $fechaFin == '')
            {
                $fecha=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $fecha=" AND DATE(a.fecha) >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $fecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            if($idUnidadNegocio == 2)
            {
                $clienteN = 'i.nombre_corto AS cliente';
                $clientes = 'LEFT JOIN servicios i ON a.id_cliente=i.id';
            }else{
                $clienteN = 'h.nombre_comercial AS cliente';
                $clientes = 'LEFT JOIN cat_clientes h ON a.id_cliente=h.id';
            }

            if($tipo == 'facturas')
            {
                $result = $this->link->query("SELECT sub.*, 
                IFNULL(SUM(IF(w.retencion=1,w.total-w.importe_retencion,w.total)),0) AS abonos_nc,(sub.saldo_inicial-sub.total_abonos-IFNULL(SUM(IF(w.retencion=1,w.total-w.importe_retencion,w.total)),0))AS saldo_actual,
                'factura' AS tipo
                FROM (
                SELECT a.id,
                a.folio,
                a.id_factura_cfdi AS id_cfdi,
                IFNULL(c.uuid_timbre,'') AS folio_fiscal,
                a.fecha,
                b.id_cfdi AS id_cfdi_empresa_fiscal,
                b.razon_social AS empresa_fiscal,
                b.rfc AS rfc_empresa_fiscal,
                a.razon_social,
                a.rfc_razon_social,
                g.descr AS sucursal,
                IF(a.retencion=1,a.total-a.importe_retencion-a.descuento,a.total-a.descuento) AS saldo_inicial,
                IFNULL(total_a.total_abonos, 0) AS total_abonos,
                j.nombre AS unidad,
                $clienteN
                FROM facturas a
                INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
                INNER JOIN facturas_cfdi c ON a.id=c.id_factura
                LEFT JOIN pagos_d d ON a.id = d.id_factura
                LEFT JOIN pagos_e e ON d.id_pago_e = e.id
                LEFT JOIN pagos_cfdi f ON d.id_pago_e = f.id_pago_e
                INNER JOIN sucursales g ON a.id_sucursal=g.id_sucursal
                LEFT JOIN cat_unidades_negocio j ON a.id_unidad_negocio=j.id
                $clientes
                    LEFT JOIN
                    (
                        SELECT SUM(importe_pagado) AS total_abonos,
                        id_factura AS id_factura
                        FROM 
                        pagos_d
                        INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
                        WHERE pagos_cfdi.estatus_cfdi IN  ('T', 'A')
                        GROUP BY id_factura
                    ) total_a ON a.id  = total_a.id_factura
                    
                    LEFT JOIN 
                    (
                    SELECT pagos_d.id_factura AS id_fac, SUM(pagos_d.importe_pagado) AS total_pagos
                    FROM pagos_d
                    INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e
                    WHERE 
                    pagos_cfdi.estatus_cfdi != 'C'
                    GROUP BY pagos_d.id_factura
                    ) otro ON d.id_factura = otro.id_fac
                    WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $fecha AND a.id_factura_nota_credito=0 AND c.estatus='T' 
                
                    GROUP BY a.id
                    ORDER BY a.fecha DESC) AS sub
                    LEFT JOIN facturas w ON sub.id=w.id_factura_nota_credito AND w.estatus='T' 
                    GROUP BY sub.id");

            }else{
                $result = $this->link->query("SELECT a.id,
                a.folio,
                a.id_pago_cfdi AS id_cfdi,
                IFNULL(f.uuid_timbre,'') AS folio_fiscal,
                b.id_cfdi AS id_cfdi_empresa_fiscal,
                b.razon_social AS empresa_fiscal,
                b.rfc AS rfc_empresa_fiscal,
                a.razon_cliente AS razon_social,
                a.rfc_cliente AS rfc_razon_social,
                DATE(a.fecha) AS fecha,
                d.descr AS sucursal,
                c.monto_pago AS saldo_inicial,
                c.monto_pago AS saldo_actual,
                'pago' AS tipo,
                j.nombre AS unidad,
                $clienteN
                FROM pagos_e a
                INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
                INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                INNER JOIN pagos_p c ON c.id_pago_e=a.id
                INNER JOIN pagos_cfdi f ON a.id = f.id_pago_e
                LEFT JOIN cat_unidades_negocio j ON a.id_unidad_negocio=j.id
                $clientes
                WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $fecha AND a.estatus='T'
                GROUP BY a.id
                ORDER BY a.fecha DESC,a.id;");
            }
        
            return query2json($result);

        }else{
                
            $arr = array();

            return json_encode($arr);
        }
    }//--buscarFacturasPagosTimbrados

    function cancelarFacturaPagoConXmlAcuse($folioFiscal,$idRegistro,$tipo,$rfcEmisor,$rfcReceptor){
        $verifica = 1;
        $mensaje = '';

        $xml= file_get_contents($_FILES['xml']['tmp_name']);
        $sxml = simplexml_load_string($xml);
       
        $atributos = $sxml->attributes();
        $rfcEmisorXml = $atributos['RfcEmisor'];  //-->obtenemos el valor del atributo llamado RfcEmisor
        
        $folioFiscalXml = $sxml->Folios->UUID;  //-->obtenemos el valor del nodo llamado UUID

        //-->Valida que sea el mismo UUID del archivo xml acuse y el de la factura o pago seleccionado 
        if($folioFiscal != $folioFiscalXml)
        {
            $verifica = 0;
            $mensaje.='<p>El Folio Fiscal del xml no es el mismo del registro.</p>';
        }

        //-->Valida que sea el mismo rfc emisor del archivo xml acuse y el de la factura o pago seleccionado 
        if($rfcEmisor != $rfcEmisorXml)
        {
            $verifica = 0;
            $mensaje.='<p>El RFC del emisor del xml no es el mismo del registro.</p>';
        }

        if($verifica == 0)
        {
            return json_encode(array('dato'=>$verifica,'mensaje'=>$mensaje));
        }else{
            if(($_FILES['xml']['tmp_name']))
            {
                if(isset($_FILES['xml']['name']))
                {
                    $nombre_imagen=$_FILES['xml']['name']; 
                    if($tipo == 'factura')
                    {
                        $nombreXml="xml_factura_".$idRegistro.".xml";
                        $rutaXML = "../xml_acuse_facturas/".$nombreXml;
                    }else{
                        $nombreXml="xml_pago_".$idRegistro.".xml";
                        $rutaXML = "../xml_acuse_pagos/".$nombreXml;
                    }
                    
                    if((move_uploaded_file($_FILES['xml']['tmp_name'],$rutaXML)))
                    {
                        $verifica = 1;
                        $mensaje .='<p>Archivo guardado.</p>';
                    }else
                        $verifica = 0;
                }else
                    $verifica = 0;
            }else
                $verifica = 0;
        
            if($verifica == 0){
                $mensaje .='<p>Error al cargar archivo.</p>';
                return json_encode(array('dato'=>$verifica,'mensaje'=>$mensaje));
            }else
                return json_encode(array('dato'=>$verifica,'mensaje'=>$mensaje));
        }

    }//--cancelarFacturaPagoConXmlAcuse

    function buscarSaldoFacturaIdMultipleCxC($idFactura){
        $result = $this->link->query("SELECT sub.folio,sub.cargo_inicial,
        (sub.cargo_inicial-IFNULL(sub.total_abonos,0)-IFNULL(SUM(IF(w.retencion=1,w.total-w.importe_retencion,w.total)),0))AS saldo
        FROM (
        SELECT a.id,a.folio,
        IF(a.retencion=1,a.total-a.importe_retencion-a.descuento,a.total-a.descuento) AS cargo_inicial,
        IFNULL(total_a.total_abonos, 0) AS total_abonos
        FROM facturas a
        LEFT JOIN facturas_cfdi c ON a.id=c.id_factura
        LEFT JOIN pagos_d d ON a.id = d.id_factura
        LEFT JOIN
        (
        SELECT SUM(importe_pagado) AS total_abonos,
        id_factura AS id_factura
        FROM 
        pagos_d
        INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
        WHERE pagos_cfdi.estatus_cfdi IN  ('T','A')
        GROUP BY id_factura
        ) total_a ON a.id  = total_a.id_factura
        
        LEFT JOIN 
        (
        SELECT pagos_d.id_factura AS id_fac, SUM(pagos_d.importe_pagado) AS total_pagos
        FROM pagos_d
        INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e
        WHERE 
        pagos_cfdi.estatus_cfdi != 'C'
        GROUP BY pagos_d.id_factura
        ) otro ON d.id_factura = otro.id_fac
        WHERE a.id=$idFactura AND a.id_factura_nota_credito=0 AND a.estatus IN ('A','T') 
        
        GROUP BY a.id
        ORDER BY a.fecha DESC) AS sub
        LEFT JOIN facturas w ON sub.id=w.id_factura_nota_credito AND w.estatus='T' 
        GROUP BY sub.id");
        
        return query2json($result);
    }//--fin funcion buscarSaldoFacturaIdMultipleCxC

    function buscaDatosIdFacturaCxC($idFactura){
        $result = $this->link->query("SELECT a.folio,a.id_cliente,b.uuid_timbre,
            COUNT(DISTINCT(IFNULL(c.id_cxc,0))) AS registros_cxc
            FROM facturas a
            LEFT JOIN facturas_cfdi b ON a.id=b.id_factura
            LEFT JOIN facturas_d c ON a.id=c.id_factura
            WHERE a.id=".$idFactura);
        
        return query2json($result);
    }

    function buscarFacturasProceso()
    {

        $result = $this->link->query("
            SELECT a.id,a.folio,IFNULL(c.uuid_timbre,'') AS folio_fiscal,b.razon_social AS empresa_fiscal,
            a.razon_social,a.rfc_razon_social,a.fecha,c.estatus,d.descr AS sucursal,a.id_cliente,
            a.metodo_pago,a.id_unidad_negocio
            FROM facturas a
            INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
            INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
            LEFT JOIN facturas_cfdi c ON a.id=c.id_factura
            WHERE a.id_empresa_fiscal = 5 AND a.fecha BETWEEN '2019-01-01' AND '2019-12-31' AND c.estatus = 'T' -- AND a.mes = 12
            AND a.id_factura_nota_credito=0 AND a.es_plan=0 AND a.es_venta_orden=0
            GROUP BY a.id
            ORDER BY a.fecha DESC");

    return query2json($result);

    }

    function actualizarAdenda($idFactura, $idCFDI, $idRazonSocial, $facturaE)
    {

       $verifica = false;

        $aF = $facturaE['adenda_f'];
        $aP = $facturaE['adenda_p'];
        $aT = $facturaE['adenda_t'];
        $aB = $facturaE['adenda_b'];

        $result = mysqli_query($this->link, "SELECT adenda FROM razones_sociales WHERE id = $idRazonSocial");
        $r = mysqli_fetch_assoc($result);

        if((int)$r['adenda'] == 1)
        {

            $adenda = '<cfdi:Addenda>
                <kn:KNRECEPCION xmlns:kn="http://www.w3.org/2001/XMLSchema" xsi:schemaLocation="C:Usersdavid.dominguezDesktopXSD_17_11_2016.xsd">
                    <kn:Tipo>
                    <kn:FacturasKN>';

            if($aP != '')
                $adenda .= '<kn:Purchase_Order>' .  $aP . '</kn:Purchase_Order>';
            else
                $adenda .= '<kn:Purchase_Order/>';

            if($aF != '')
                $adenda .= '<kn:FileNumber_GL>' .  $aF . '</kn:FileNumber_GL>';        
            else
                $adenda .= '<kn:FileNumber_GL/>';

            if($aB != '')
                $adenda .= '<kn:Branch_Centre>' .  $aB . '</kn:Branch_Centre>';        
            else
                $adenda .= '<kn:Branch_Centre/>';

            if($aT != '')
                $adenda .= '<kn:TransportRef>' .  $aT . '</kn:TransportRef>';        
            else
                $adenda .= '<kn:TransportRef/>';


            $adenda .= '</kn:FacturasKN>
                    </kn:Tipo>
                    </kn:KNRECEPCION>
                </cfdi:Addenda>';

            $cfdi = new CFDIDenken();
            $verifica =  $cfdi->insertarAdenda($idCFDI, $adenda);

        }
        else
            $verifica = $verifica = true;
        
        return $verifica;

    }

    function num_2dec($numero)
	{
		return number_format($numero, 2, '.', '');
	}

}//--fin de class Facturacion
    
?>