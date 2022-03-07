<?php

require_once('conectar.php');

class CFDIDenken
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $linkCFDI;
    public $link;

    function __construct()
    {
  
      $this->linkCFDI = ConectarseCFDI();
      $this->link = Conectarse();

    }

    function guardaFactura($facturaE,$facturaD)
    {
        // error_log(json_encode($facturaE));
        
        $verifica = 0;

        $folio = $facturaE['folio'];
        $folioNotaCredito = isset($facturaE['folioNotaCredito']) ? $facturaE['folioNotaCredito'] : 0;
        $fecha = $facturaE['fecha'];
        $subtotal = $facturaE['subtotal'];
        $iva = $facturaE['iva'];
        $idMetodoPago = $facturaE['idMetodoPago'];
        $idFormaPago = $facturaE['idFormaPago'];
        $idUsoCFDI = $facturaE['idUsoCFDI'];
        $rfc = $facturaE['rfc'];
        $razonSocialReceptor = $facturaE['razonSocialReceptor'];
        $codigoPostal = $facturaE['codigoPostal'];
        $idCFDIEmpresaFiscal = $facturaE['empresaFiscal'];
        $usuario = $facturaE['usuario'];
        $tasaIva = $facturaE['tasaIva'];
        $tipo = $facturaE['tipo'];
        $facturasSustituir = $facturaE['facturasSustituir'];
        $tipo_cfd = $facturaE['tipo_cfd'];
        $retencion = isset($facturaE['retencion']) ? $facturaE['retencion'] : 0;
        $importeRetencion = isset($facturaE['importeRetencion']) ? $facturaE['importeRetencion'] : 0;
        $porcentajeRetencion = isset($facturaE['porcentajeRetencion']) ? $facturaE['porcentajeRetencion'] : 0;

        //-->NJES Feb/20/2020 se obtiene el descuento porque en ventas alarmas pueden traer descuento y se prorratea para las partidas al guardar prefactura
        $descuento = isset($facturaE['descuento']) ? $facturaE['descuento'] : 0;
        
        //-->NJES May/25/2021
        $moneda = $facturaE['moneda'];
        $tipoCambio = $facturaE['tipo_cambio'];

        $query = "INSERT INTO factura_e(id_empresa,tipo_cfd,folio,nota_credito,fecha,subtotal,iva,
                    moneda,tcambio,usuario_captura,metodo_pago,forma_pago,uso_cfdi,rfc_cliente,
                    razon_cliente,pais_cliente,cod_pos_cliente,retencion,importe_retencion,
                    porcentaje_retencion,descuento) 
                    VALUES ('$idCFDIEmpresaFiscal','$tipo_cfd','$folio','$folioNotaCredito','$fecha',
                    '$subtotal','$iva','$moneda',$tipoCambio,'$usuario','$idMetodoPago','$idFormaPago','$idUsoCFDI',
                    '$rfc','$razonSocialReceptor','MX','$codigoPostal','$retencion','$importeRetencion',
                    '$porcentajeRetencion','$descuento')";
        // echo $query;
        // exit();
        // error_log("tercer insert");
        // error_log($query);
        // error_log("verificando sesion6");
        // error_log(json_encode($_SESSION));
        
        $result = mysqli_query($this->linkCFDI, $query) or die(mysqli_error($this->linkCFDI));
        $idCFDI = mysqli_insert_id($this->linkCFDI);

        if($result)
        {
            // echo $tipo;
            // exit();
            if($tipo == 'sustituir')
                $verifica = $this -> guardaSustituirFactura($facturaD,$idCFDI,$tasaIva,$facturasSustituir);
            else{
                $verifica = $this -> guardarPartidas($facturaD,$idCFDI,$tasaIva);

                if($folioNotaCredito != 0){

                    $idFactura = $facturaE['idFactura'];

                    // $query = "INSERT INTO factura_r(registro_e,tipo_relacion,uuid_documento) 
                    //             VALUES ('$idCFDI','$tipo','$uuidDoc')";
                    $query = "SELECT uuid_timbre FROM facturas_cfdi WHERE id_factura = $idFactura;";

                    $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

                    while($miRow = mysqli_fetch_array($result)){
                        $uuidDoc = $miRow["uuid_timbre"];

                        $query2 = "INSERT INTO factura_r(registro_e,tipo_relacion,uuid_documento) 
                                    VALUES ('$idCFDI','01','$uuidDoc')";

                        mysqli_query($this->linkCFDI, $query2) or die(mysqli_error($this->linkCFDI));
                    }

                    // if ($result) 
                    // {
                    //     $verifica = 1;
                    // }else{
                    //     $verifica = 0;
                    //     break;
                    // }

                }
            }
        }

        return $verifica;
    }

    function guardaSustituirFactura($facturaD,$idCFDI,$tasaIva,$facturasSustituir){
        $verifica = 0;

        foreach($facturasSustituir as $partida)
        {
            // print_r($partida);
            // continue;
            $tipo = $partida['tipo'];
            $uuidDoc = $partida['uuidDoc'];

            $query = "INSERT INTO factura_r(registro_e,tipo_relacion,uuid_documento) 
                        VALUES ('$idCFDI','$tipo','$uuidDoc')";
            $result = mysqli_query($this->linkCFDI, $query) or die(mysqli_error($this->linkCFDI));

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
            $verifica = $this -> guardarPartidas($facturaD,$idCFDI,$tasaIva);
        }

        return $verifica;
    }

    function guardarPartidas($facturaD,$idCFDI,$tasaIva){
        $verifica = 0;

        // print_r($facturaD);
        // exit();

        foreach($facturaD as $partida)
        {
            $concepto = $partida['concepto'];
            $precioUnitario = $partida['precioUnitario'];
            $cantidad = $partida['cantidad'];
            $claveProducto = $partida['claveProducto'];
            $claveUnidad = $partida['claveUnidad'];
            $unidad = $partida['unidad'];

            //-->NJES Feb/20/2020 se obtiene el descuento porque en ventas alarmas pueden traer descuento y se prorratea para las partidas al guardar prefactura
            $porcentajeDescuento = isset($partida['porcentajeDescuento']) ? $partida['porcentajeDescuento'] : 0;

            if($tasaIva == 16)
                $tIva = 0.16;
            else if($tasaIva == 8)
                $tIva = 0.08;
            else
                $tIva = 0;

            $query = "INSERT INTO factura_d(registro_e,concepto,precio_unitario,cantidad,clave_prod_serv,
                    clave_unidad,unidad,tasa_iva,descuento) 
                    VALUES ('$idCFDI','$concepto','$precioUnitario','$cantidad','$claveProducto',
                    '$claveUnidad','$unidad','$tIva','$porcentajeDescuento')";

            // error_log("multiples insert");
            // error_log($query);
            // error_log("verificando sesion7");
            // error_log(json_encode($_SESSION));

            $result = mysqli_query($this->linkCFDI, $query) or die(mysqli_error($this->linkCFDI));

            if ($result) 
            {
                $verifica = $idCFDI;

            }else{
                $verifica = 0;
                break;
            }

        }

        return $verifica;
    }

    function obtenerCFDI($idCFDI){
        $result = mysqli_query($this->linkCFDI,"SELECT registro,tipo_cfd,no_cert_cfd,cert_cfd,fecha_cfd,hora_cfd,sello_cfd,cadena_cfd,xml_cfd,
        version_timbre,fecha_timbre,hora_timbre,no_cert_timbre,sello_timbre,uuid_timbre,xml_timbre,estatus_cfd 
        FROM factura_cfd WHERE registro_e=".$idCFDI);

        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function obtenerAcuse($idCFDI){
        $result = mysqli_query($this->linkCFDI,"SELECT fecha_can,hora_can,acuse_can 
            FROM factura_cfd WHERE registro_e=".$idCFDI);

        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function obtenerAcusePagos($idCFDI){
        $result = mysqli_query($this->linkCFDI,"SELECT fecha_can,hora_can,acuse_can 
            FROM pagos_cfd WHERE registro_e=".$idCFDI);

        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function guardaPago($pagosE,$pagosD){
        // error_log(json_encode($pagosD));
        // error_log(json_encode($pagosE));
        $verifica = 0;

        $idEmpresaFiscal = $pagosE['idEmpresaFiscal'];
        $folio = $pagosE['folio'];
        $fecha = $pagosE['fecha'];
        $rfc_cliente = $pagosE['rfcCliente'];
        $razon_social_cliente = $pagosE['razonSocialCliente'];
        $cp_cliente = $pagosE['cpCliente'];
        $usuario = $pagosE['usuario'];
        $tipo = $pagosE['tipo'];
        $pagosSustituir = $pagosE['pagosSustituir'];

        $monto = $pagosE['monto'];
        $idMetodoPago = $pagosE['idMetodoPago'];
        $formaPago = $pagosE['formaPago'];

        //-->NJES Jun/11/2021 
        $moneda = $pagosE['moneda'];
        $tipoCambio = $pagosE['tipo_cambio'];

        $query = "INSERT INTO pagos_e(folio,fecha,rfc_cliente,razon_cliente,pais_cliente,
                    cod_pos_cliente,usuario_captura,id_empresa) 
                    VALUES ('$folio','$fecha','$rfc_cliente','$razon_social_cliente',
                    'MXN','$cp_cliente','$usuario','$idEmpresaFiscal')";
        $result = mysqli_query($this->linkCFDI, $query) or die(mysqli_error($this->linkCFDI));
        $idCFDI = mysqli_insert_id($this->linkCFDI);

        if($result)
        {
            if($tipo == 'sustituir')
                $verifica = $this -> guardaSustituirPago($pagosD,$idCFDI,$formaPago,$idMetodoPago,$monto,$fecha,$pagosSustituir,$moneda,$tipoCambio);
            else
                $verifica = $this -> guardarPagosP($pagosD,$idCFDI,$formaPago,$idMetodoPago,$monto,$fecha,$moneda,$tipoCambio);
        }

        return $verifica;
    }

    function guardarPagosP($pagosD,$idCFDI,$formaPago,$idMetodoPago,$monto,$fecha,$moneda,$tipoCambio){
        $verifica = 0;

        $fechaN = $fecha.'T12:00:00';

        $query = "INSERT INTO pagos_p(registro_e,monto_pago,forma_pago,moneda_pago,fecha_pago,tcambio) 
                VALUES ('$idCFDI','$monto','$formaPago','$moneda','$fechaN','$tipoCambio')";
        $result = mysqli_query($this->linkCFDI, $query) or die(mysqli_error($this->linkCFDI));
        $idPagoP = mysqli_insert_id($this->linkCFDI);

        if($result)
            $verifica = $this->guardarPartidasPagos($pagosD,$idCFDI,$idPagoP,$idMetodoPago,$moneda); 

        return $verifica;
    }//- fin function guardarPagosP

    function guardarPartidasPagos($pagosD,$idCFDI,$idPagoP,$idMetodoPago,$moneda){
        $verifica = 0;
        foreach($pagosD as $partida)
        {
            $uuidfactura = $partida['uuidfactura'];
            $folioFactura = $partida['folioFactura'];
            $saldoAnterior = $partida['saldoAnterior'];
            $saldoInsoluto = $partida['saldoInsoluto'];
            $importePagado = $partida['importePagado'];
            $numParcialidad = $partida['numParcialidad'];

            $query = "INSERT INTO pagos_d(registro_p,uuid_dr,folio_dr,metodo_pago_dr,
                    moneda_dr,importe_saldo_anterior,importe_saldo_insoluto,importe_pagado,num_parcialidad) 
                    VALUES ('$idPagoP','$uuidfactura','$folioFactura','$idMetodoPago','$moneda','$saldoAnterior',
                    '$saldoInsoluto','$importePagado','$numParcialidad')";
            $result = mysqli_query($this->linkCFDI, $query) or die(mysqli_error($this->linkCFDI));

            if ($result) 
            {
                $verifica = $idCFDI;

            }else{
                $verifica = 0;
                break;
            }

        }

        return $verifica;
    }

    function obtenerCFDIPagos($idCFDI){
        $result = mysqli_query($this->linkCFDI,"SELECT registro,tipo_cfd,no_cert_cfd,cert_cfd,fecha_cfd,hora_cfd,sello_cfd,cadena_cfd,xml_cfd,
        version_timbre,fecha_timbre,hora_timbre,no_cert_timbre,sello_timbre,uuid_timbre,xml_timbre,estatus_cfd 
        FROM pagos_cfd WHERE registro_e=".$idCFDI);

        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function guardaSustituirPago($pagosD,$idCFDI,$formaPago,$idMetodoPago,$monto,$fecha,$pagosSustituir,$moneda,$tipoCambio){
        $verifica = 0;

        foreach($pagosSustituir as $partida)
        {
            $tipo = $partida['tipo'];
            $uuidDoc = $partida['uuidDoc'];

            $query = "INSERT INTO pagos_r(registro_e,tipo_relacion,uuid_documento) 
                        VALUES ('$idCFDI','$tipo','$uuidDoc')";
            $result = mysqli_query($this->linkCFDI, $query) or die(mysqli_error($this->linkCFDI));

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
            $verifica = $this -> guardarPagosP($pagosD,$idCFDI,$formaPago,$idMetodoPago,$monto,$fecha,$moneda,$tipoCambio);
        }

        return $verifica;
    }

    function insertarAdenda($idCFDI, $adenda)
    {

        $verifica = false;

        header ("content-type: text/text");
        
        $query = "UPDATE factura_e SET adenda = '" .  $adenda . "' where registro = $idCFDI" ;
        $result = mysqli_query($this->linkCFDI, $query) or die(mysqli_error($this->linkCFDI));

        if ($result) 
            $verifica = true;

        return $verifica;

    }

    function obtenerDatosFacturaE($idFacturaCFDI){
        $result = mysqli_query($this->linkCFDI,"SELECT subtotal, iva, moneda, tcambio, importe_retencion
                                                FROM factura_e
                                                WHERE registro =".$idFacturaCFDI);
                                                
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function obtenerDatosFacturaESaldos($idFacturaCFDI,$idsFacturaCfdiNc){

        $array = array();

        $query ="SELECT factura_e.registro,factura_e.subtotal, factura_e.iva, factura_e.moneda, 
        factura_e.tcambio, factura_e.importe_retencion,
        IF(factura_e.retencion=1,(factura_e.subtotal+factura_e.iva)-IFNULL(factura_e.descuento,0)-factura_e.importe_retencion,(factura_e.subtotal+factura_e.iva)-IFNULL(factura_e.descuento,0)) AS saldo_inicial,
        IFNULL(pagos.total_abonos, 0) AS pagos
        FROM factura_e 
        LEFT JOIN factura_cfd ON factura_e.registro=factura_cfd.registro_e
        LEFT JOIN (
            SELECT pagos_d.uuid_dr,SUM(pagos_d.importe_pagado) AS total_abonos           
            FROM pagos_d            
            LEFT JOIN pagos_p ON pagos_d.registro_p=pagos_p.registro
            LEFT JOIN pagos_cfd ON pagos_p.registro_e=pagos_cfd.registro_e           
            WHERE pagos_cfd.estatus_cfd IN  ('T', 'A')            
            GROUP BY pagos_d.uuid_dr     
        ) pagos ON factura_cfd.uuid_timbre=pagos.uuid_dr
        WHERE factura_e.registro = ".$idFacturaCFDI;

        $result = mysqli_query($this->linkCFDI,$query);

        $row = mysqli_fetch_assoc($result);

        $subtotal = $row['subtotal'];
        $iva = $row['iva'];
        $moneda = $row['moneda'];
        $tCambio = $row['tcambio'];
        $importeRetencion = $row['importe_retencion'];
        $saldoInicial = $row['saldo_inicial'];
        $pagos = $row['pagos'];

        $notasAbonos = 0;

        if($idsFacturaCfdiNc != '')
        {
            $queryb = "SELECT SUM((factura_e.subtotal+factura_e.iva)-factura_e.importe_retencion) AS abonos_notas
            FROM factura_e 
            WHERE factura_e.registro IN ($idsFacturaCfdiNc)";

            $resultb = mysqli_query($this->linkCFDI,$queryb);

            $rowb = mysqli_fetch_assoc($resultb);

            $notasAbonos = $rowb['abonos_notas'];

        }

        $abonos = $pagos+$notasAbonos;
        $saldo = $saldoInicial-$abonos;
            
        $array = array('subtotal'=>$subtotal,
                        'iva'=>$iva,
                        'moneda'=>$moneda,
                        'tcambio'=>$tCambio,
                        'importe_retencion'=>$importeRetencion,
                        'cargo_original'=>$saldoInicial,
                        'abono_original'=>$abonos,
                        'saldo_original'=>$saldo);
                                                        
        return $array;
    }

}//--fin de class CFDIDenken
    
?>