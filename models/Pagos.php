<?php

require_once('conectar.php');
require_once('CFDIDenken.php');
require_once('CxC.php');

class Pagos
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
     //--MGFS 21-02-2020 se agrega folio de factura---
    function buscarPagos($datos){
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

            $result = $this->link->query("
                                            SELECT a.id,a.folio,b.razon_social AS empresa_fiscal,GROUP_CONCAT(g.folio_factura) AS folio_factura,
                                            a.razon_cliente,a.rfc_cliente,DATE(a.fecha) AS fecha,f.estatus_cfdi AS estatus,d.descr AS sucursal,
                                            a.id_unidad_negocio,a.id_cliente,c.monto_pago,a.metodo_pago
                                            FROM pagos_e a
                                            INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
                                            INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                                            INNER JOIN pagos_p c ON c.id_pago_e=a.id
                                            INNER JOIN pagos_cfdi f ON a.id = f.id_pago_e
                                            LEFT JOIN pagos_d g ON a.id = g.id_pago_e
                                            WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $fecha
                                            GROUP BY a.id
                                            ORDER BY a.fecha DESC,a.id");
        
            return query2json($result);

        }else{
                
            $arr = array();

            return json_encode($arr);
        }
    }//- fin function buscarPagos
    //--MGFS SE AGREGA LA CONDICION DE PAGOS DE ALAMRNAS PARA BUSCAR LOS DATOS DE SERVICIOS Y SE AGREGA EL CORREO 
    function buscarPagosId($idPago){
        $result = $this->link->query("SELECT a.id,a.folio,a.id_sucursal,a.id_unidad_negocio,a.id_cuenta_banco,
        a.id_cliente,a.metodo_pago,DATE(a.fecha) AS fecha,a.id_razon_social,a.id_empresa_fiscal,
        b.razon_social AS empresa_fiscal,IF(a.id_cliente>0,IF(i.nombre='ALARMAS',j.nombre_corto,e.nombre_comercial),'VENTA PUBLICO EN GENERAL') AS cliente,
        if(a.id_cliente>0,j.razon_social,'VENTA PUBLICO EN GENERAL') AS razon_social_alarmas,IFNULL(IF(i.nombre='ALARMAS',j.correos,k.correo_facturas),'') AS correo,a.forma_pago,
        a.concepto,a.id_cuenta_banco,IFNULL(a.banco_cliente,'') AS banco_cliente,
        IFNULL(a.cuenta_cliente,'') AS cuenta_cliente,a.id_pago_cfdi, f.estatus_cfdi AS estatus,c.monto_pago,
        b.id_cfdi AS id_cfdi,IFNULL(f.uuid_timbre,'') AS folio_fiscal ,a.metodo_pago,
        IFNULL(f.uuid_timbre,'') AS folio_fiscal,IFNULL(GROUP_CONCAT(h.uuid_timbre),'') AS pagos_relacionados,
        c.moneda,c.tipo_cambio    
        FROM pagos_e a
        INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
        INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
        INNER JOIN pagos_p c ON c.id_pago_e=a.id
        LEFT JOIN cat_clientes e ON a.id_cliente=e.id
        LEFT JOIN pagos_cfdi f ON a.id=f.id_pago_e
        LEFT JOIN pagos_r g ON a.id=g.id_pago_e
        LEFT JOIN pagos_cfdi h ON g.id_pago_sustituido=h.id_pago_e
        INNER JOIN cat_unidades_negocio i ON a.id_unidad_negocio=i.id
        LEFT JOIN servicios j ON a.id_cliente=j.id
        LEFT JOIN razones_sociales k ON a.id_razon_social=k.id 
        WHERE a.id=".$idPago);
        
        return query2json($result);
    }//- fin function buscarPagos

    function buscarPagosDetalleId($idPago){
        $result = $this->link->query("SELECT a.id,a.uuid_factura  AS uuid,a.folio_factura AS folio,
        a.importe_pagado AS monto_pago,c.fecha,a.importe_pagado_usd AS monto_pago_usd,a.moneda
        FROM pagos_d a
        INNER JOIN pagos_p b ON a.id_pago_e=a.id_pago_e
        INNER JOIN facturas c ON a.id_factura=c.id
        INNER JOIN facturas_cfdi cfdi ON c.id = cfdi.id_factura
        WHERE a.id_pago_e=$idPago AND b.id_pago_e=$idPago ORDER BY c.fecha DESC");
        
        return query2json($result);
    }//- fin function buscarPagos

    /**
      * Guarda registros
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarPagos($datos){
        // error_log(json_encode($datos));
        // exit();
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this->guardarActualizar($datos);

        if($verifica === 0){
            // error_log("hizo rollback" );
            $this->link->query('ROLLBACK;');
        }else{
            // error_log("hizo commit" );
            $this->link->query("COMMIT;");
        }
        return $verifica;
    }//- fin function guardarFacturacion

    /**
      * Guarda registros
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarActualizar($datos){
        $verifica = 0;

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idCliente = $datos['idCliente'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $idMetodoPago = $datos['idMetodoPago'];
        $idFormaPago = $datos['idFormaPago'];
        $fecha = $datos['fecha'];
        $importe = $datos['importe'];
        $concepto = $datos['concepto'];
        $formaPago = $datos['formaPago'];
        $bancoCliente = $datos['bancoCliente'];
        $idCuentaBanco = $datos['idCuentaBanco'];
        $tipoCuenta = $datos['tipoCuenta'];
        $idUsuario = $datos['idUsuario'];
        $numCuentaCliente = $datos['numCuentaCliente'];
        $usuario = $datos['usuario'];
        $idRazonSocialCliente = $datos['idRazonSocialCliente'];
        $razonSocialCliente = $datos['razonSocialCliente'];
        $rfcCliente = $datos['rfcCliente'];
        $emailCliente = $datos['emailCliente'];
        $cpCliente = $datos['cpCliente'];
        $partidas = $datos['facturasPagar'];
        $pagosSustituir = isset($datos['pagosSustituir']) ? $datos['pagosSustituir'] : '';
        $tipo = isset($datos['tipo']) ? $datos['tipo'] :'';
        $idPagoSF = isset($datos['pagoSF']) ? $datos['pagoSF'] : 0;

        //-->NJES April/03/2020 recibe bandera para indicar si es por mismo rfc
        $mismoRFC = $datos['mismoRFC'];

        $moneda = isset($datos['moneda']) ? $datos['moneda'] : 'MXN';
        //-->NJES Jun/11/2021 agregar moneda, tipo de cambio e importes originales y en pesos
        //en ginthercorp se guarda importe en pesos y en cfdi_denken2 el importe original
        if($moneda == 'MXN')
            $importePesos = $importe;
        else
            $importePesos = isset($datos['importe_pesos']) ? $datos['importe_pesos'] : $importe;

        $tipoCambio = 1;
        if($moneda != 'MXN')
            $tipoCambio = isset($datos['tipo_cambio']) ? $datos['tipo_cambio'] : 1;

        $folio = $this->obtenerFolio($idEmpresaFiscal, 'folio_pago') + 1;

        $query = "INSERT INTO pagos_e(id_unidad_negocio,id_sucursal,folio,id_empresa_fiscal,
                id_cliente,id_razon_social,rfc_cliente,razon_cliente,cod_pos_cliente,
                metodo_pago,concepto,forma_pago,fecha,id_cuenta_banco,banco_cliente,cuenta_cliente,pago_por_rfc) 
                VALUES ('$idUnidadNegocio','$idSucursal','$folio','$idEmpresaFiscal','$idCliente',
                '$idRazonSocialCliente','$rfcCliente','$razonSocialCliente','$cpCliente',
                '$idMetodoPago','$concepto','$formaPago','$fecha','$idCuentaBanco',
                '$bancoCliente','$numCuentaCliente','$mismoRFC')";
                // error_log($query);
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idPago = mysqli_insert_id($this->link);

        $pagosE = array('folio'=>$folio,
                            'fecha'=>$fecha,
                            'idEmpresaFiscal'=>$idEmpresaFiscal,
                            'rfcCliente'=>$rfcCliente,
                            'razonSocialCliente'=>$razonSocialCliente,
                            'cpCliente'=>$cpCliente,
                            'usuario'=>$usuario,
                            'idMetodoPago'=>$idMetodoPago,
                            'formaPago'=>$formaPago,
                            'monto'=>$importe,
                            'pagosSustituir'=>$pagosSustituir,
                            'tipo'=>$tipo,
                            'moneda'=>$moneda,
                            'tipo_cambio'=>$tipoCambio);

        $datosInfo = array('folio'=>$folio,
                            'idPago'=>$idPago,
                            'idMetodoPago'=>$idMetodoPago,
                            'monto'=>$importePesos,
                            'fecha'=>$fecha,
                            'idEmpresaFiscal'=>$idEmpresaFiscal,
                            'partidas'=>$partidas,
                            'pagosE'=>$pagosE,
                            'pagosSustituir'=>$pagosSustituir,
                            'tipo'=>$tipo,
                            'idUnidadNegocio'=>$idUnidadNegocio,
                            'idSucursal'=>$idSucursal,
                            'idCuentaBanco'=>$idCuentaBanco,
                            'tipoCuenta'=>$tipoCuenta,
                            'idUsuario'=>$idUsuario,
                            'moneda'=>$moneda,
                            'monto_usd'=>$importe,
                            'tipo_cambio'=>$tipoCambio,
                            'idPagoSF'=>$idPagoSF
                            );

        if ($result) 
          $verifica = $this->guardarPagosP($datosInfo); 
        
        return $verifica;
    }//- fin function guardarFacturacion

    function guardarPagosP($datosInfo){
        $verifica = 0;
        // error_log("linea242".json_encode($datosInfo));
        /*
            "folio":3781,
            "idPago":86395,
            "idMetodoPago":"PPD",
            "monto":"7000",
            "fecha":"2022-02-23 23:00:00",
            "idEmpresaFiscal":"2",
            "partidas":[
                "idFactura":"88100",
                "uuidfactura":"630EC83E-EC54-46D8-92C7-9D504ED700A0",
                "folioFactura":"13123",
                "importe":"7000",
                "importe_pesos":"7000",
                "saldoAnterior":"57793.2400",
                "saldo_anterior_original":"57793.2400",
                "multipleCXC":"0",
                "idServicio":"148"
                ],
            "pagosE":{
                "folio":3781,
                "fecha":"2022-02-23 23:00:00",
                "idEmpresaFiscal":"2",
                "rfcCliente":"GCE9910122T4",
                "razonSocialCliente":"GCC CEMENTO S.A DE C.V",
                "cpCliente":"32676",
                "usuario":"JESSICALIMAS",
                "idMetodoPago":"PPD",
                "formaPago":"03",
                "monto":"7000",
                "pagosSustituir":"",
                "tipo":"pagoSF",
                "moneda":"MXN",
                "tipo_cambio":1
                },
            "pagosSustituir":"",
            "tipo":"pagoSF",
            "idUnidadNegocio":"1",
            "idSucursal":"2",
            "idCuentaBanco":"6",
            "tipoCuenta":"0",
            "idUsuario":"316",
            "moneda":"MXN",
            "monto_usd":"7000",
            "tipo_cambio":1,
            "idPagoSF":"1"}
        */

        $idPago = $datosInfo['idPago'];
        $monto = $datosInfo['monto'];
        $fecha = $datosInfo['fecha'].'T12:00:00';
        $moneda = $datosInfo['moneda'];

        if($moneda != 'MXN')
            $montoUsd = $datosInfo['monto_usd'];
        else
            $montoUsd = 0 ;
        
        $tipoCambio = $datosInfo['tipo_cambio'];

        $query = "INSERT INTO pagos_p(id_pago_e,monto_pago,moneda,fecha_pago,monto_pago_usd,tipo_cambio) 
                VALUES ('$idPago','$monto','$moneda','$fecha','$montoUsd','$tipoCambio')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
            $verifica = $this->guardarPartidas($datosInfo); 

        return $verifica;
    }//- fin function guardarPagosP

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
        return $result;
    }

    function guardarPartidas($datosInfo){
        $verifica = 0;

        $idPago = $datosInfo['idPago'];
        $idMetodoPago = $datosInfo['idMetodoPago'];
        $folio = $datosInfo['folio'];
        $idEmpresaFiscal = $datosInfo['idEmpresaFiscal'];
        $partidas = $datosInfo['partidas'];

        $idUnidadNegocio = $datosInfo['idUnidadNegocio'];
        $idSucursal = $datosInfo['idSucursal'];
        $idCuentaBanco = $datosInfo['idCuentaBanco'];
        $tipoCuenta = $datosInfo['tipoCuenta'];
        $idUsuario = $datosInfo['idUsuario'];
        $fecha = $datosInfo['fecha'];

        $pagosSustituir = $datosInfo['pagosSustituir'];
        $tipo = $datosInfo['tipo'];
        $idPagoSF = $datosInfo['idPagoSF'];

        $pagosE = $datosInfo['pagosE'];

        $moneda = $datosInfo['moneda'];

        $pagosD = array();

        foreach($partidas as $partida)
        {
            $idFactura = $partida['idFactura'];
            $uuidfactura = $partida['uuidfactura'];
            $folioFactura = $partida['folioFactura'];
            $importe = $partida['importe'];
            $saldoAnterior = $partida['saldoAnterior'];
            $multipleCXC = $partida['multipleCXC'];
            //$saldoInsoluto = $saldoAnterior - $importe;

            //-->NJES April/03/2020 recibe parametro id servicio para guardarlo por partida
            $idServicio = $partida['idServicio'];

            //-->NJES Jun/11/2021 en ginthercorp se guarda importe en pesos y en cfdi_denken2 el importe original
            $importePesos = isset($partida['importe_pesos']) ? $partida['importe_pesos'] : $importe;
            $saldoAnteriorOriginal = isset($partida['saldo_anterior_original']) ? $partida['saldo_anterior_original'] : $saldoAnterior;
            
            $saldoInsolutoPesos = $saldoAnterior - $importePesos;
            $saldoInsoluto = $saldoAnteriorOriginal - $importe;

            //cuando la moneda es en dolares guardar en el campo importe_pagado_usd el importe en dolares
            //si la moneda es MXN ese campo es 0
            if($moneda == 'MXN')
            {
                $importeUSD = 0;
                $saldoAnteriorOriginalUSD = 0;
                $saldoInsolutoUSD = 0;
            }else{
                $importeUSD = $importe;
                $saldoAnteriorOriginalUSD = $saldoAnteriorOriginal;
                $saldoInsolutoUSD = $saldoInsoluto;
            }

            $numPF = "SELECT MAX(num_parcialidad) AS parcialidad FROM pagos_d WHERE id_factura=".$idFactura;
            $resultPF = mysqli_query($this->link, $numPF) or die(mysqli_error());
            $rowPF = mysqli_fetch_array($resultPF);
            $numR = $rowPF['parcialidad'];
            $numParcialidad = $numR+1;

            $query = "INSERT INTO pagos_d(id_pago_e,id_factura,uuid_factura,folio_factura,metodo_pago,
                importe_saldo_anterior,importe_saldo_insoluto,importe_pagado,num_parcialidad,multiple_cxc,
                id_servicio,importe_pagado_usd,moneda,importe_saldo_anterior_usd,importe_saldo_insoluto_usd) 
                VALUES ('$idPago','$idFactura','$uuidfactura','$folioFactura','$idMetodoPago',
                '$saldoAnterior','$saldoInsolutoPesos','$importePesos','$numParcialidad','$multipleCXC',
                '$idServicio','$importeUSD','$moneda','$saldoAnteriorOriginalUSD','$saldoInsolutoUSD')";
                // error_log($query);
            $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));
            $idPagoD = mysqli_insert_id($this->link);

            //->le voy agregando al array los registros
            array_push($pagosD,['uuidfactura'=>$uuidfactura,
                          'folioFactura'=>$folioFactura,
                          'saldoAnterior'=>$saldoAnteriorOriginal,
                          'saldoInsoluto'=>$saldoInsoluto,
                          'importePagado'=>$importe,
                          'numParcialidad'=>$numParcialidad]);

            if ($result) 
            {
                // error_log(json_encode($datosInfo));
                //--MGFS SE AGREGA CONDICION DE MULTIPLE CXC PARA PAGAR VARIOS ID CXC CON UN SOLO PAGO
                if($multipleCXC==0){

                    $idCxC = $this->obtenerCxCPago($idPagoD);

                    $arreglo=array(
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'importe'=>$importePesos,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'categoria'=>'Pago a Factura',
                        'fechaAplicacion'=>$fecha
                    );
        
                    $cxcModelo = new CxC();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
                    $valor=0;
                    if($tipoCuenta == 0)
                    {
                        if($tipo == "pagoSF"){
                            $valor = $this->actualizarPagosSinFactura($idPagoSF, $importe, $idCxC, $fecha, $idFactura, $folioFactura);
                        }else{
                            $valor = $cxcModelo-> guardarMovimientosBancos($idCxC,$arreglo);
                        }                            
                    }else{
                        if($tipo == "pagoSF"){
                            $valor = $this->actualizarPagosSinFactura($idPagoSF, $importe, $idCxC, $fecha, $idFactura, $folioFactura);
                        }else{
                            $valor = $cxcModelo-> guardarGastoCajaChica($idCxC,$arreglo);
                        }
                    }

                    if((int)$valor > 0){
                        $verifica = 1;
                    }else{
                        $verifica = 0;
                        break;
                    }

                }else{
                    //-- MGFS SE INSERTAN MANUALMENTE LOS PAGOS DE LOS CXC CORRESPONDINETES A UNA FACTURA
                    $verifica = $this->generoCXC($idPago,$idPagoD,$idFactura,$importe,$tipoCuenta,$idCuentaBanco,$fecha,$idUsuario);
                } 

                //$verifica = 1;
            }else{
                $verifica = 0;
                break;
            }

        }

        if ($verifica == 1) 
        {
            if($this->actualizarFolio($idEmpresaFiscal, $folio, 'folio_pago') == 1)
            {
                // error_log("holi");
                $cfdiDenke = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta

                if($idMetodoPago == 'PPD')
                {
                    if($tipo == 'sustituir')
                        $verifica = $this->guardaSustituirPago($idPago,$pagosE,$pagosD,$pagosSustituir);
                    else{ //pago o pagoSF
                        $idCFDI = $cfdiDenke->guardaPago($pagosE,$pagosD); 
                        $verifica = $this->actualizaCFDIPago($idPago,$idCFDI);
                    }
                    // switch($tipo){
                    //     case "sustituir":
                    //         $verifica = $this->guardaSustituirPago($idPago,$pagosE,$pagosD,$pagosSustituir);
                    //         break;
                    //     case "pago":
                    //         $idCFDI = $cfdiDenke->guardaPago($pagosE,$pagosD);
                    //         $verifica = $this->actualizaCFDIPago($idPago,$idCFDI);
                    //         break;
                    //     case "pagoSF":
                    //         $idCFDI = $cfdiDenke->guardaPago($pagosE,$pagosD);
                    //         $resultado = $this->actualizarPagosSinFactura($idPagoSF, $partidas);
                    //         $verifica = $this->actualizaCFDIPago($idPago,$idCFDI);
                    //         break;
                    // }
                }else{
                    //$verifica = json_encode(array('idPago'=>$idPago));
                    //-->NJES May/08/2020 generar registro de cfdi tambien cuando es PUE
                    $idCFDI = $cfdiDenke->guardaPago($pagosE,$pagosD); 
                    $queryW = "INSERT INTO pagos_cfdi(id_pago_e,estatus_cfdi) VALUES('$idPago','A')";

                    $resultW = mysqli_query($this->link, $queryW) or die(mysqli_error());

                    if($resultW)
                        $verifica = $this->actualizaCFDIPago($idPago,$idCFDI);
                    else
                        $verifica = 0;
                }
            
            }else{
                // error_log("no holi");
                $verifica = 0;
            }
            //$this->actualizarFolio($idEmpresaFiscal, $folio, 'folio_pago');   

        }

        return $verifica;
    }//- fin function guardarPartidas

    function obtenerCxCPago($idPago)
    {
        $result = mysqli_query($this->link, "SELECT id FROM cxc WHERE id_pago_d = $idPago");
        $row = mysqli_fetch_assoc($result);
        return $row['id'];
    }//- fin function obtenerCxCPago

    function obtenerIdPagoD($idPago)
    {
        /*$result = mysqli_query($this->link, "SELECT id FROM pagos_d WHERE id_pago_e = $idPago");
        $row = mysqli_fetch_assoc($result);
        return $row['id'];*/

        //-->NJES Feb/25/2020 obtener todos los pagos_d del pago
        $query = "SELECT id FROM pagos_d WHERE id_pago_e = $idPago";
        $result = $this->link->query($query);

        return $result;
    }//- fin function obtenerIdPagoD

    function guardaSustituirPago($idPago,$pagosE,$pagosD,$pagosSustituir){
        $verifica = 0;

        foreach($pagosSustituir as $partida)
        {
            $idPagoS = $partida['idPago'];
            $tipo = $partida['tipo'];

            $query = "INSERT INTO pagos_r(id_pago_e,id_pago_sustituido,tipo) 
                VALUES ('$idPago','$idPagoS','$tipo')";
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
            
            $idCFDI = $cfdiDenke->guardaPago($pagosE,$pagosD); 
            $verifica = $this->actualizaCFDIPago($idPago,$idCFDI);
            $this->actualizarFolio($idEmpresaFiscal, $folio, 'folio_pago'); 

        }

        return $verifica;
    }//- fin function guardaSustituirPago

    function actualizaCFDIPago($idPago,$idCFDI){
        $verifica = 0;

        $query = "UPDATE pagos_e SET id_pago_cfdi ='$idCFDI' WHERE id=".$idPago;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
            $verifica = json_encode(array('idPago'=>$idPago,'idCFDI'=>$idCFDI));

        return $verifica;
    }//- fin function actualizaFolioFactura

    function actualizarDatosCFDI($id,$idCFDI){
        $verifica = 0;
    
        $cfdiDenken = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
        
        $datosCFDI = $cfdiDenken->obtenerCFDIPagos($idCFDI);  

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
        
        $query = "INSERT INTO pagos_cfdi(id_pago_e,tipo_cfdi,no_cert_cfdi,cert_cfdi,fecha_cfdi,hora_cfdi,
                sello_cfdi,cadena_cfdi,xml_cfdi,version_timbre,fecha_timbre,hora_timbre,no_cert_timbre,sello_timbre,
                uuid_timbre,xml_timbre,estatus_cfdi) VALUES('$id','$tipo_cfdi','$no_cert_cfdi','$cert_cfdi','$fecha_cfdi',
                '$hora_cfdi','$sello_cfdi','$cadena_cfdi','$xml_cfdi','$version_timbre','$fecha_timbre','$hora_timbre',
                '$no_cert_timbre','$sello_timbre','$uuid_timbre','$xml_timbre','$estatus_cfd')";

        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
        {
            $update_status = "UPDATE pagos_e SET estatus='T' WHERE id=".$id;
            $result_estatus = mysqli_query($this->link, $update_status) or die(mysqli_error());

            if($result_estatus)
                $verifica = $id;
        }else
            $verifica = 0;
        
        return $verifica;
    }

    function eliminarPago($id){
        $verifica = 0;

        //-->NJES Feb/25/2020 eliminar los cxc y movimientos dinero en banco o caja chica y si se eliminan todos eliminar pagos
        $idPagoD_result = $this->obtenerIdPagoD($id);

        foreach($idPagoD_result as $dato)
        {
            $idPago = $dato['id'];

            /*$resultIn = mysqli_query($this->link, "SELECT a.id,b.tipo AS tipo_cuenta
                                                    FROM cxc a
                                                    LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                                                    WHERE a.id_pago_d = $idPago");
            $rowIn = mysqli_fetch_assoc($resultIn);*/

            $query = "SELECT a.id,b.tipo AS tipo_cuenta
            FROM cxc a
            LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
            WHERE a.id_pago_d = $idPago";

            $result = $this->link->query($query);

            $query4 = "DELETE FROM cxc WHERE id_pago_d=".$idPago;
            $result4 = mysqli_query($this->link, $query4) or die(mysqli_error());

            if($result4)
            {
                foreach($result as $rowIn)
                {
                    $idCxC = $rowIn['id'];
                    $tipoCuenta = $rowIn['tipo_cuenta'];

                    if($tipoCuenta == 0)
                    {
                        $query5 = "DELETE FROM movimientos_bancos WHERE id_cxc=".$idCxC;
                        $result5 = mysqli_query($this->link, $query5) or die(mysqli_error());

                        if($result5)
                            $verifica = 1;
                        else{
                            $verifica = 0; 
                            break;
                        }

                    }else{
                        $resultS = mysqli_query($this->link, "SELECT id_sucursal FROM caja_chica WHERE id_cxc = $idCxC");
                        $rowS = mysqli_fetch_assoc($resultS);
                        $idSucursal = $rowIn['id_sucursal'];

                        $query5 = "DELETE FROM caja_chica WHERE id_cxc=".$idCxC;
                        $result5 = mysqli_query($this->link, $query5) or die(mysqli_error());

                        if($result5)
                        {
                            $resultFolio = mysqli_query($this->link, "SELECT folio_caja_chica FROM sucursales WHERE id_sucursal = $idSucursal");
                            $rowF = mysqli_fetch_assoc($resultFolio);
                            $folio = $rowF['folio_caja_chica']-1;

                            $queryU = "UPDATE sucursales SET folio_caja_chica='$folio' WHERE id_sucursal=".$idSucursal;
                            $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
                            
                            if($resultU)
                                $verifica = 1;
                            else{
                                $verifica = 0; 
                                break;
                            }
                        }else{
                            $verifica = 0; 
                            break;
                        }  
                    }
                }
            }else{
                $verifica = 0; 
                break; 
            }
        }

        if($verifica == 1)
        {
            $query = "DELETE FROM pagos_e WHERE id=".$id;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if($result)
            {
                $query2 = "DELETE FROM pagos_d WHERE id_pago_e=".$id;
                $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

                if($result2)
                {
                    $query3 = "DELETE FROM pagos_p WHERE id_pago_e=".$id;
                    $result3 = mysqli_query($this->link, $query3) or die(mysqli_error());

                    if($result3)
                    {
                        $verifica = 1;
                    }else
                        $verifica = 0;

                }else
                    $verifica = 0;

            }else
                $verifica = 0;
        }

        return $verifica;
    }

    function actualizarEstatusPago($id,$estatus){
        $verifica = 0;

        $estatusAnterior = $this -> buscaEstatusAnterior($id);

        $query = "UPDATE pagos_e SET estatus='$estatus' WHERE id=".$id;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
        {
            $query2 = "UPDATE pagos_cfdi SET estatus_cfdi='$estatus' WHERE id_pago_e=".$id;
            $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

            if($result2)
            {
                if($estatus == 'C')
                {
                    if($estatusAnterior == 'A')
                    {
                        $verifica = $this -> generaMovimientoDinero($id,$estatus,$estatusAnterior);
                    }else
                        $verifica = $id;

                }else{
                    $verifica = $this -> generaMovimientoDinero($id,$estatus,$estatusAnterior);
                } 
            }
        }

        return $verifica; 
    }

    function buscaEstatusAnterior($id){
        $estatus = '';

        $result = mysqli_query($this->link, "SELECT estatus
                    FROM pagos_e
                    WHERE id=$id");
        $row = mysqli_fetch_assoc($result);

        $estatus = $row['estatus'];

        return $estatus;
    }

    function generaMovimientoDinero($id,$estatus,$estatusAnterior){
        $verifica = 0;

        $cxcModelo = new CxC();

        $busca="SELECT id FROM  pagos_d WHERE id_pago_e=".$id;
        $resultC = mysqli_query($this->link, $busca) or die(mysqli_error());
        $num=mysqli_num_rows($resultC);

        if($num > 0)
        {
            for ($i=1; $i <=$num ; $i++) { 
                $row=mysqli_fetch_array($resultC);

                $idPagoD=$row['id'];

                $query = "SELECT a.id,a.id_unidad_negocio,a.id_sucursal,a.id_razon_social,a.fecha,
                    a.id_cuenta_banco,a.total,a.id_concepto,a.cve_concepto,b.tipo AS tipo_cuenta
                    FROM cxc a
                    LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                    WHERE a.id_pago_d=".$idPagoD;

                $result = $this->link->query($query);

                foreach($result as $rowS)
                {

                    $idCxC=$rowS['id'];
                    $idUnidadNegocio=$rowS['id_unidad_negocio']; 
                    $idSucursal=$rowS['id_sucursal'];
                    $fecha=$rowS['fecha'];
                    $tipoCuenta=$rowS['tipo_cuenta'];

                    if($estatus == 'T')
                        $importe=$rowS['total'];
                    else
                        $importe=$rowS['total']*(-1);
                    
                    $idCuentaBanco=$rowS['id_cuenta_banco'];

                    $arr=array(
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'importe'=>$importe,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$_SESSION['id_usuario'],
                        'categoria'=>'Pago a Factura',
                        'fechaAplicacion'=>$fecha
                    );

                    if($tipoCuenta == 0)
                    {
                        $valor = $cxcModelo -> guardarMovimientosBancos($idCxC,$arr);
                    }else{
                        $valor = $cxcModelo -> guardarGastoCajaChica($idCxC,$arr);
                    }

                    if($valor > 0)
                        $verifica = $id;
                    else{
                        $verifica = 0;
                        break;
                    } 
                }
            }

        }

        return $verifica;
    }

    function descargarAcuse($idPago,$idCFDI){
        $verifica = 0;

        $cfdiDenken = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
            
        $datosCFDI = $cfdiDenken->obtenerAcusePagos($idCFDI); 
        
        $fechaCan = $datosCFDI['fecha_can'];
        $horaCan = $datosCFDI['hora_can'];
        $acuseCan = $datosCFDI['acuse_can'];

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $signature = array("'Signature'");
        $signatureEscape  = array("\'Signature\'");
        $acuseN = str_replace($signature, $signatureEscape, $acuseCan);

        $query = "UPDATE pagos_cfdi SET fecha_can='$fechaCan',hora_can='$horaCan',
                    acuse_can='$acuseN' WHERE id_pago_e=".$idPago;
                    
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
            $verifica = $this -> actualizarEstatusPago($idPago,'C');
        
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
        
        return $verifica; 
    }

    function descargarXML($idPago,$folioPago){
        $verifica = '';

        $folio = $folioPago;

        header('Content-type: text/plain');

        //if(isset($_REQUEST['tipo']))
          //  header("Content-Disposition: attachment; filename=\"nota_$folio.xml\"");
        //else
            header("Content-Disposition: attachment; filename=\"pago_$folio.xml\"");
        
        $resultXML = mysqli_query($this->link, "SELECT xml_timbre FROM pagos_cfdi WHERE id_pago_e = $idPago");
        $registroXML = mysqli_fetch_assoc($resultXML);
        $verifica = $registroXML['xml_timbre'];

        return $verifica;
    }

    function enviarCorreoPagoTimbrado($datos){
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
		$mail->SMTPSecure = "STARTTLS";
		$mail->SMTPAuth = true;
		$mail->Host = "mail.ginthercorp.com";
		$mail->Port = 587;
		$mail->Username = "info@ginthercorp.com"; 
		$mail->Password = "secorp.01";
		

		$mail->SetFrom("info@ginthercorp.com","Recibo de Pagos");
		
		$mail->Subject = $asunto;
		$mail->MsgHTML($mensaje);

		for($i = 0; $i < count($destinatarios); $i++)
		{
			$mail->AddAddress($destinatarios[$i], "Contacto");	
		}
		
		$mail->AddAttachment($ruta . '.xml');

		$mail->AddAttachment($ruta . '.pdf');

		$verifica = false;
		
		if(!$mail->Send()) 	
			$verifica = 0; //Intento Fallido;
		else
			$verifica = 1; //exito

        return $verifica;
    }

    function generarBajaXml($idPago,$folioPago,$tipo){
        $verifica = 0;

        $ruta = "../pagos/archivos/".$tipo."_" .$folioPago."_".$idPago.".xml";

        if (!empty($idPago))
        {
            $query = "SELECT xml_timbre FROM pagos_cfdi WHERE id_pago_e = " . $idPago;
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

    function buscarPagosCancelados($datos){
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idCliente = $datos['idCliente'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $idRazonSocial = $datos['idRazonSocial'];

        $result = $this->link->query("SELECT a.id,a.folio,a.id_pago_cfdi,IFNULL(d.uuid_timbre,'') AS folio_fiscal
        FROM pagos_e a
        INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
        INNER JOIN razones_sociales r ON a.id_razon_social = r.id
        INNER JOIN cat_clientes c ON a.id_cliente=c.id
        INNER JOIN pagos_cfdi d ON a.id=d.id_pago_e
        WHERE NOT EXISTS(SELECT 
        r.id_pago_e AS id_pago_nuevo,
        r.id_pago_sustituido AS pago_sustituido
        FROM pagos_r r
        INNER JOIN pagos_e aa ON r.id_pago_e = aa.id
        INNER JOIN pagos_e bb ON r.id_pago_sustituido = bb.id
        LEFT JOIN pagos_cfdi cc ON aa.id=cc.id_pago_e
        WHERE IF(aa.estatus = 'C', cc.uuid_timbre IS NOT NULL, aa.estatus IN('A','T')) AND r.id_pago_sustituido = a.id)
        AND a.id_unidad_negocio=$idUnidadNegocio AND a.id_sucursal=$idSucursal 
        AND a.id_cliente=$idCliente AND a.id_empresa_fiscal=$idEmpresaFiscal 
        AND a.id_razon_social=$idRazonSocial AND a.estatus='C' AND a.metodo_pago='PPD'
        AND a.fecha_captura >= '2019-01-01'
         ORDER BY a.id");
        
        return query2json($result);
    }

    function buscarPagosSustituidosId($idPago){
        $result = $this->link->query("SELECT e.id_pago_sustituido AS id,a.folio AS folio_interno,
        f.uuid_timbre AS folio_fiscal,b.fecha_pago AS fecha,b.monto_pago AS total
        FROM pagos_r e 
        LEFT JOIN pagos_cfdi f ON e.id_pago_sustituido=f.id_pago_e
        LEFT JOIN pagos_e a ON a.id=e.id_pago_sustituido
        LEFT JOIN pagos_p b ON a.id=b.id_pago_e
        WHERE e.id_pago_e=".$idPago);
        
        return query2json($result);
    }

    /*function generarMovimientoDinero($idPago){
        $verifica = 0;

        $busqueda = "SELECT id,id_unidad_negocio,id_sucursal,id_razon_social,fecha,
                            referencia,mes,anio,vencimiento,id_concepto,cve_concepto,
                            id_cuenta_banco,total,usuario_captura
                            FROM cxc WHERE id_factura=".$idFactura;
        $resultC = mysqli_query($this->link, $busqueda) or die(mysqli_error());

        if($resultC)
        {
            $datosC=mysqli_fetch_array($resultC);

            $idCxC=$datosC['id']; 
            $idUnidadNegocio=$datosC['id_unidad_negocio']; 
            $idSucursal=$datosC['id_sucursal'];
            $idRazonSocialReceptor=$datosC['id_razon_social'];
            $fecha=$datosC['fecha'];
            $vencimiento=$datosC['vencimiento'];
            $total=$datosC['total'];
            $idUsuario=$datosC['usuario_captura'];
            $idCuentaBanco=$datosC['id_cuenta_banco'];
            //$tipoCuenta

            $arreglo=array(
                'idUnidadNegocio'=>$idUnidadNegocio,
                'idSucursal'=>$idSucursal,
                'importe'=>$total,
                'idCuentaBanco'=>$idCuentaBanco,
                'idUsuario'=>$idUsuario,
                'categoria'=>'Seguimiento a Cobranza',
                'fechaAplicacion'=>$fecha
            );

            $cxcModelo = new CxC();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
        
            if($tipoCuenta == 0)
            {
                $verifica = $cxcModelo-> guardarMovimientosBancos($idCxC,$arreglo);
            }else{
                $verifica = $cxcModelo-> guardarGastoCajaChica($idCxC,$arreglo);
            }
        }

        return $verifica;
    }*/

    function generoCXC($idPago,$idPagoD,$idFactura,$importe,$tipoCuenta,$idCuentaBanco,$fecha,$idUsuario){
       
        $verifica = 0;
        //--BUSCO LOS DATOS DE PAGOS E QUE SE CABAN DE INGRESAR PARA ASIGNARLOS AL REGISTRO DE CXC DE PAGO --------
        $pagosE="SELECT pagos_e.id, pagos_e.folio, pagos_e.id_unidad_negocio, pagos_e.id_sucursal, 
                pagos_e.fecha, pagos_e.id_razon_social, pagos_e.estatus, pagos_e.id_empresa_fiscal, pagos_e.concepto, conceptos_cxp.clave
                FROM pagos_e
                INNER JOIN conceptos_cxp ON pagos_e.concepto = conceptos_cxp.id
                WHERE pagos_e.id =".$idPago;
        $resultE= mysqli_query($this->link, $pagosE)or die(mysqli_error());
        $numRowsE = mysqli_num_rows($resultE);
        //if($numRowsE>0){
            $rowE = mysqli_fetch_array($resultE);
            $idUNPago = $rowE['id_unidad_negocio'];
            $idSucursalPago = $rowE['id_sucursal'];
            $folioPago = $rowE['folio'];
            $idE = $rowE['id'];
            $idRSPago = $rowE['id_razon_social'];
            $idEFPago = $rowE['id_empresa_fiscal'];
            $fechaPago = $rowE['fecha'];
            $estatusPago = $rowE['estatus'];
            $idConceptoPago = $rowE['concepto']; 
            $conceptoPago = $rowE['clave'];
            $importeRestante = $importe;
            //--BUSCO LOS CXC Y SU SALDO PARA SALDAR LO QUE FALTE--------
            $buscaCxcFactura = "SELECT 
            a.id, 
           (a.total-IFNULL(b.total,0)) AS saldo
           FROM cxc a
           LEFT JOIN cxc b ON a.id=b.id_cxc_pago AND b.estatus!='C'
           WHERE a.id =ANY(SELECT DISTINCT(id_cxc) FROM facturas_d WHERE id_factura=".$idFactura." ORDER BY id_cxc ASC)
           HAVING saldo>0";
            
           //-->NJES April/15/2020 se agrega foreach para que por cada cxc que se agan abonos mientras no se consuma el importe
            $resultCXC = $this->link->query($buscaCxcFactura);
            foreach($resultCXC as $dato)
            {
                $idCxC = $dato['id'];
                $saldo = $dato['saldo'];

                //solo se ingresan abonos miesntras tenga importe disponible, si ya se lo consumieron los cxc ya no
                while($importeRestante >0){
                    //--si el importe restatnte es mayor o igual al saldo  el importe asigado sera igual al saldo 
                    if($importeRestante >=$saldo){

                        $importeAsignado = $saldo;
                        $importeRestante = $importeRestante-$saldo;

                    }else{
                       //--- si el importe restante es menor al saldo pero matyor a 0 se lo asigno al cxc anctual
                        $importeAsignado = $importeRestante;
                        $importeRestante = 0;
                    }
                    

                    $guardaCxc="INSERT INTO cxc (id_unidad_negocio, id_sucursal, id_pago, folio_pago, id_pago_d,  id_razon_social, id_empresa_fiscal, fecha, fecha_captura, subtotal, iva, total, estatus, id_concepto, cve_concepto,id_cxc_pago,id_cuenta_banco)
                            VALUES ('$idUNPago', '$idSucursalPago', '$idPago', '$folioPago', '$idPagoD', '$idRSPago', '$idEFPago', '$fechaPago', NOW(),'$importeAsignado', 0, '$importeAsignado', '$estatusPago', '$idConceptoPago', '$conceptoPago','$idCxC','$idCuentaBanco')";
                    $resultGuardaCXC = mysqli_query($this->link, $guardaCxc)or die(mysqli_error());
                    $idCXCN = mysqli_insert_id($this->link);

                    if($resultGuardaCXC){
                        $arregloN=array(
                            'idUnidadNegocio'=>$idUNPago,
                            'idSucursal'=>$idSucursalPago,
                            'importe'=>$importeAsignado,
                            'idCuentaBanco'=>$idCuentaBanco,
                            'idUsuario'=>$idUsuario,
                            'categoria'=>'Pago a Factura',
                            'fechaAplicacion'=>$fecha
                        );
                 
                        $cxcModelo = new CxC();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
                        $valor=0;
                        
                        if($tipoCuenta == 0)
                        {
                            $valor = $cxcModelo-> guardarMovimientosBancos($idCXCN,$arregloN);
                        }else{
                            $valor = $cxcModelo-> guardarGastoCajaChica($idCXCN,$arregloN);
                        }

                        if($valor > 0)
                            $verifica = 1;
                        else{
                            $verifica = 0;
                            break;
                        } 

                    }else{
                        $verifica = 0;
                        break; 
                    }

                }
            }
     
        return $verifica;

    }//- fin function obtenerCxCPago

    /**
      * Guarda pagos sin factura
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarPagosSin($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $modelCXC = new CxC();
        $verifica = $modelCXC->guardarPagoSinFactura($datos);

        if($verifica === 0)
            $this->link->query('ROLLBACK;');
        else
            $this->link->query("COMMIT;");

        return $verifica;
    }//- fin function guardarpagossinfacturas

    function buscarPagosSinFacturaID($id){

        $query = "SELECT a.id,
                        a.folio,
                        a.id_unidad_negocio,
                        DATE(a.fecha) AS fecha,
                        b.descr AS sucursal,
                        a.id_sucursal,
                        a.monto,
                        a.concepto,
                        a.descripcion,
                        a.id_cuenta_banco,
                        c.descripcion AS banco,
                        a.id_cliente,
                        a.rfc_cliente,
                        a.id_razon_social as id_razon
                    FROM pagos_sin_factura a
                    INNER JOIN sucursales b ON a.id_sucursal=b.id_sucursal
                    LEFT JOIN cuentas_bancos c ON a.id_cuenta_banco = c.id
                    WHERE a.id = $id";
        
        $result = $this->link->query($query);

        return query2json($result);

    }//- fin function buscarPagos

 //- Busquedas de pagos sin factura
    function buscarPagosSinFactura($datos){
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
            
            $query = "SELECT a.id,
                                a.folio,
                                DATE(a.fecha) AS fecha,
                                b.descr AS sucursal,
                                a.id_unidad_negocio,
                                a.monto AS importe,
                                a.concepto,
                                a.descripcion,
                                c.descripcion AS banco
                        FROM pagos_sin_factura a
                        INNER JOIN sucursales b ON a.id_sucursal=b.id_sucursal
                        LEFT JOIN cuentas_bancos c ON a.id_cuenta_banco = c.id
                        WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $fecha
                        GROUP BY a.id
                        ORDER BY a.fecha DESC,a.id";

                        // echo $query;
                        // exit();

            $result = $this->link->query($query);
        
            return query2json($result);

        }else{
                
            $arr = array();

            return json_encode($arr);
        }
    }//- fin function buscarPagos

    // GCM 01/Mar/2022 se agrega funcion para traer PSF para el select en fr_pagos
    function buscarPagosPSF($idRazonSocial, $idCliente){

        $query = "SELECT concepto, descripcion, fecha, folio, id as idPsf, id_cuenta_banco, monto 
                    FROM pagos_sin_factura
                    WHERE id_cliente = $idCliente
                        AND id_razon_social = $idRazonSocial
                        AND estatus = 0";

                    // echo $query;
                    // exit();

        $result = $this->link->query($query);

        if($result){
            return query2json($result);
        }else{                
            $arr = array();
            return json_encode($arr);
        }
    }//- fin function buscarPagosPSF

    function actualizarPagosSinFactura($idPagoSF, $importe, $idCxC, $fecha, $idFactura, $folioFactura){
        $verificar = 0;

        $idUsuario = $_SESSION["id_usuario"];

        $query3 = "SELECT monto
                    FROM pagos_sin_factura
                    WHERE id = $idPagoSF";

        $result3 = mysqli_query($this->link, $query3) or die(mysqli_error($this->link));

        if($result3){
            $row = mysqli_fetch_array($result3);
            $monto = $row['monto'];

            if($monto >= $importe){
                $query = "INSERT INTO pagos_sin_factura_bitacora (fk_pago_sin_factura, monto_inicial, monto_final, monto_ingresado, id_usuario_captura, id_cxc)
                    SELECT $idPagoSF, monto, (monto - $importe), $importe, $idUsuario, $idCxC
                    FROM pagos_sin_factura
                    WHERE id = $idPagoSF;";

                $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

                if($result){
                    $query2 = "UPDATE pagos_sin_factura
                                SET monto = monto - $importe,
                                    estatus = CASE
                                                WHEN monto = 0 THEN 1
                                                ELSE 0
                                            END
                                WHERE id = $idPagoSF;";

                                error_log($query2);

                    $result2 = mysqli_query($this->link, $query2) or die(mysqli_error($this->link));

                    if($result2){
                        $query4 = "UPDATE cxc
                                    SET id_factura = $idFactura,
                                        folio_factura = '$folioFactura',
                                        mes = MONTH('$fecha'),
                                        anio = YEAR('$fecha');";

                        $result4 = mysqli_query($this->link, $query4) or die(mysqli_error($this->link));

                        if($result4){
                            $verificar = 1;
                        }else{
                            return 0;
                        }
                    }else{
                        return 0;
                    }
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }

        return $verificar;
    }

}//--fin de class Pagos
    
?>