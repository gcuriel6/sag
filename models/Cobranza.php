<?php

require_once('conectar.php');
require_once('CxC.php');
require_once('Pagos.php');

class Cobranza
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Cobranza()
    {
  
      $this->link = Conectarse();

    }

    /** 
    *
    *Busca los registros de facturas y cxc que se tienen que cobrar
    *@param int tipo 0=CXC 1=PUE 2=PPD
    *@param int orden  0=clientes   1=fecha vencimiento
    *@param varchar tabla    (semana, siguiente, vencidos)
    *
    **/
    function buscarCobranza($datos){
        $tipo = $datos['tipo'];
        $orden = $datos['orden'];
        $tabla = $datos['tabla'];

        if($tabla == 'semana')
        {
            $tablaCXC = ' AND a.vencimiento BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 WEEK)';
            $tablaFactura = ' AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 WEEK)';
        }else if($tabla == 'siguiente')
        {
            $tablaCXC = ' AND a.vencimiento BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL 1 WEEK) AND DATE_ADD(CURRENT_DATE(), INTERVAL 2 WEEK)';
            $tablaFactura = ' AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL 1 WEEK) AND DATE_ADD(CURRENT_DATE(), INTERVAL 2 WEEK)';
        }else{
            $tablaCXC = ' AND a.vencimiento < CURRENT_DATE()';
            $tablaFactura = ' AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) < CURRENT_DATE()';
        }

        if($order == 0)
        {
            $ordenCXC = ' ORDER BY e.nombre_comercial ASC';
            $ordenFactura = ' ORDER BY q.nombre_comercial ASC';
        }else{
            $ordenCXC = ' ORDER BY a.vencimiento ASC';
            $ordenFactura = ' ORDER BY DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) ASC';
        }
            

        if($tipo==0)  //CXC
        {
            $query = "SELECT a.id,
                        'cxc' AS tipo,
                        a.folio_cxc AS folio,
                        a.vencimiento,
                        a.id_unidad_negocio,
                        IFNULL(b.nombre,'') AS unidad,
                        a.id_sucursal,
                        IFNULL(c.descr,'') AS sucursal,
                        0 AS id_empresa_fiscal,
                        d.id_cliente,
                        IFNULL(e.nombre_comercial,'') AS cliente,
                        a.id_razon_social,
                        IFNULL(d.razon_social,'') AS razon_social,
                        IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C' AND a.cargo_inicial=1),a.total,0),0)),0) AS cargos,
                        IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'A'),a.total,0),0)),0) AS abonos,
                        IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),a.total,((a.total) * -(1))),0)),0) AS saldo
                        FROM cxc a
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                        LEFT JOIN razones_sociales d ON a.id_razon_social=d.id
                        LEFT JOIN cat_clientes e ON d.id_cliente=e.id
                        WHERE a.id_factura=0 AND a.id_nota_credito=0 AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0 
                        $tablaCXC 
                        GROUP BY a.folio_cxc
                        HAVING saldo > 0
                        $ordenCXC";
        }else{ //Factura

            if($tipo == 1)  //PUE
                $condMetodo= " AND a.metodo_pago='PUE'";
            else //PPD
                $condMetodo= " AND a.metodo_pago='PPD'";

            $query = "SELECT 
                        pre.id,
                        'factura' AS tipo,
                        n.nombre AS unidad,
                        o.descr AS sucursal,
                        k.folio,
                        k.id_unidad_negocio,
                        k.id_sucursal,
                        k.id_razon_social,
                        k.id_empresa_fiscal,
                        p.id_cliente,
                        l.razon_social AS razon_social,
                        TRIM(q.nombre_comercial) AS cliente,
                        DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) AS vencimiento,
                        k.fecha_inicio,
                        k.fecha_fin,
                        SUM(pre.total_facturado) AS cargos,
                        SUM(pre.pagos_mensual)+SUM(pre.notas_mensual) AS abonos,
                        SUM(pre.total_facturado)-(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)) AS saldo
                        FROM( 
                        /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                        SELECT a.id,
                        a.metodo_pago,
                        CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                        IFNULL(SUM(IF(a.estatus IN ('T'),IF(a.id_factura_nota_credito=0,a.total,0),0)),0) AS total_facturado,
                        IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado,
                        IFNULL(SUM(IF(a.estatus IN('T'),IF(a.id_factura_nota_credito=0,a.total,(a.total)*-1),0)),0) AS saldo_facturado,
                        0 AS pagos_mensual,
                        0 AS notas_mensual
                        FROM facturas a
                        WHERE a.es_plan=0 AND a.es_venta_orden=0 AND a.id_cxc=0 $condMetodo $tablaFactura
                        GROUP BY a.id
                        /* AQUI OBTIENE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
                        UNION ALL
                        SELECT 
                        b.id_factura,
                        a.metodo_pago,
                        DATE_FORMAT(DATE(c.fecha), '%Y-%m') AS fecha,
                        0 AS total_facturado,
                        0 AS abonos_facturado,
                        0 AS saldo_facturado,
                        SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                        0 AS notas_mensual
                        FROM pagos_e c
                        LEFT JOIN pagos_d b ON c.id=b.id_pago_e
                        LEFT JOIN facturas a ON b.id_factura=a.id 
                        WHERE a.es_plan=0 AND a.es_venta_orden=0 AND a.id_cxc=0 $condMetodo $tablaFactura
                        GROUP BY b.id_factura
                        /* AQUI OBTIENE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/
                        UNION ALL
                        SELECT 
                        sub.id_factura,
                        sub.metodo_pago,
                        DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha,
                        0 AS total_facturado,
                        0 AS abonos_facturado,
                        0 AS saldo_facturado,
                        0 AS pagos_mensual,
                        SUM(IF(sub.id=b.id_factura_nota_credito,b.total,0))AS notas_mensual
                        FROM ( 
                        SELECT 
                        a.id,
                        a.metodo_pago,
                        a.folio,
                        a.fecha,'F' AS tipo,
                        a.id AS id_factura,
                        SUM(a.total) AS total 
                        FROM facturas a
                        WHERE a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND a.es_plan=0 AND a.es_venta_orden=0 AND a.id_cxc=0 $condMetodo $tablaFactura
                        GROUP BY a.id
                        )AS sub
                        LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito AND b.estatus ='T'
                        GROUP BY sub.id_factura
                        ) AS pre
                        LEFT JOIN facturas k ON pre.id=k.id
                        LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                        LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                        LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                        LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                        LEFT JOIN razones_sociales p ON k.id_razon_social = p.id
                        LEFT JOIN cat_clientes q ON p.id_cliente = q.id
                        GROUP BY pre.id
                        HAVING saldo > 0
                        $ordenFactura";   
            
        }


        $result = $this->link->query($query);

        return query2json($result);
    }//- fin function buscarCobranza

    function guardarCobranza($datos){
        $verifica = 0;
  
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $idMetodoPago = $datos['idMetodoPago'];

        if($idMetodoPago == 'CXC')
          $verifica = $this -> guardarCxC($datos);
        else
          $verifica = $this -> guardarPago($datos);

        if($verifica > 0)
            $this->link->query("COMMIT;");
        else
            $this->link->query('ROLLBACK;');

            return $verifica;
    }//- fin function guardarCobranza

    function guardarCxC($datos){
        $verifica = 0;

        $idConcepto = $datos['idConcepto'];
        $cveConcepto = $datos['cveConcepto'];
        $idBanco = $datos['idBanco'];
        $idCuentaBanco = $datos['idCuentaBanco'];
        $idUsuario = $datos['idUsuario'];
        $tipoCuenta = $datos['tipoCuenta'];
        $fechaAplicacion = $datos['fechaAplicacion'];
        $idBancoCliente = $datos['idBancoCliente'];
        $idCuentaCliente = $datos['idCuentaCliente'];
        $usuario = $datos['usuario'];
        $idMetodoPago = $datos['idMetodoPago'];
        $formaPago = $datos['formaPago'];
        $importeTotal = $datos['importe'];

        $registros = $datos['registros'];

        for($i=1;$i<=$registros[0];$i++){

            $id = $registros[$i]['id'];
            $tipo = $registros[$i]['tipo'];
            $importe = $registros[$i]['importe'];
            $saldoAnterior = $registros[$i]['saldo'];

                $busqueda = "SELECT id_unidad_negocio,id_sucursal,id_razon_social,fecha,referencia,mes,anio,vencimiento
                            FROM cxc 
                            WHERE id=".$id;
                $resultC = mysqli_query($this->link, $busqueda) or die(mysqli_error());
  
                if($resultC)
                {
                    $datosC=mysqli_fetch_array($resultC);

                    $idUnidadNegocio=$datosC['id_unidad_negocio']; 
                    $idSucursal=$datosC['id_sucursal'];
                    $idRazonSocialReceptor=$datosC['id_razon_social'];
                    $fecha=$datosC['fecha'];
                    $referencia=$datosC['referencia'];
                    $mes=$datosC['mes'];
                    $anio=$datosC['anio'];
                    $vencimiento=$datosC['vencimiento'];

                    $arr=array('idCxC'=>$id,
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'idRazonSocialReceptor'=>$idRazonSocialReceptor,
                        'vencimiento'=>$vencimiento,
                        'tasaIva'=>0,
                        'mes'=>$mes,
                        'anio'=>$anio,
                        'idConcepto'=>$idConcepto,
                        'cveConcepto'=>$cveConcepto,
                        'fecha'=>$fecha,
                        'importe'=>$importe,
                        'totalIva'=>0,
                        'total'=>$importe,
                        'referencia'=>$referencia,
                        'idBanco'=>$idBanco,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'estatus'=>'A',
                        'cargoInicial'=>0,
                        'idOrdenServicio'=>0,
                        'idRazonSocialServicio'=>0,
                        'categoria'=>'Seguimiento a Cobranza',
                        'fechaAplicacion'=>$fechaAplicacion,
                        'tipoCuenta'=>$tipoCuenta
                    );
                }

                $modeloCxC = new CxC();
                $idN = $modeloCxC->guardarActualizar($arr);

                if($idN > 0)
                {
                    $verifica = $idN;
                }else
                    break;
            
        }
   
        return $verifica;
    }//- fin function guardar

    function guardarPago($datos){
      $verifica = 0;

        $arregloPagos=array();

        $idConcepto = $datos['idConcepto'];
        $cveConcepto = $datos['cveConcepto'];
        $idBanco = $datos['idBanco'];
        $idCuentaBanco = $datos['idCuentaBanco'];
        $idUsuario = $datos['idUsuario'];
        $tipoCuenta = $datos['tipoCuenta'];
        $fechaAplicacion = $datos['fechaAplicacion'];
        $idBancoCliente = $datos['idBancoCliente'];
        $idCuentaCliente = $datos['idCuentaCliente'];
        $usuario = $datos['usuario'];
        $idMetodoPago = $datos['idMetodoPago'];
        $formaPago = $datos['formaPago'];
        $importeTotal = $datos['importe'];

        $registros = $datos['registros'];

        for($i=1;$i<=$registros[0];$i++){

            $id = $registros[$i]['id'];
            $tipo = $registros[$i]['tipo'];
            $importe = $registros[$i]['importe'];
            $saldoAnterior = $registros[$i]['saldo'];

                $busqueda = "SELECT a.id_unidad_negocio,a.id_sucursal,a.id_empresa_fiscal,a.id_cliente,
                            a.id_razon_social,a.razon_social,a.rfc_razon_social,b.codigo_postal,b.email,
                            c.uuid_timbre,a.folio
                            FROM facturas a
                            LEFT JOIN facturas_cfdi c ON a.id=c.id_factura
                            LEFT JOIN razones_sociales b ON a.id_razon_social=b.id 
                            WHERE a.id=".$id;
                $resultC = mysqli_query($this->link, $busqueda) or die(mysqli_error());
  
                if($resultC)
                {
                    $datosC=mysqli_fetch_array($resultC);

                    $idUnidadNegocio=$datosC['id_unidad_negocio']; 
                    $idSucursal=$datosC['id_sucursal'];
                    $idRazonSocial=$datosC['id_razon_social'];
                    $idCliente=$datosC['id_cliente'];
                    $razonSocial=$datosC['razon_social'];
                    $rfcRazonSocial=$datosC['rfc_razon_social'];
                    $idEmpresaFiscal=$datosC['id_empresa_fiscal'];
                    $codigoPostal=$datosC['codigo_postal'];
                    $email=$datosC['email'];
                    $folio=$datosC['folio'];
                    $uuid=$datosC['uuid_timbre'];

                    $facturasPagar=array();

                    $facturasPagar[1] = array(
                      'idFactura'=>$id,
                      'uuidfactura'=>$uuid,
                      'folioFactura'=>$folio,
                      'importe'=>$importe,
                      'saldoAnterior'=>$saldoAnterior
                    );

                    $arr=array('idUnidadNegocio'=>$idUnidadNegocio,
                      'idSucursal'=>$idSucursal,
                      'idCliente'=>$idCliente,
                      'idEmpresaFiscal'=>$idEmpresaFiscal,
                      'idMetodoPago'=>$idMetodoPago,
                      'formaPago'=>$formaPago,
                      'fecha'=>$fechaAplicacion,
                      'importe'=>$importe,
                      'concepto'=>$idConcepto,
                      'bancoCliente'=>$idBancoCliente,
                      'idCuentaBanco'=>$idCuentaBanco,
                      'tipoCuenta'=>$tipoCuenta,
                      'idUsuario'=>$idUsuario,
                      'numCuentaCliente'=>$idCuentaCliente,
                      'usuario'=>$usuario,
                      'idRazonSocialCliente'=>$idRazonSocial,
                      'razonSocialCliente'=>$razonSocial,
                      'rfcCliente'=>$rfcRazonSocial,
                      'emailCliente'=>$email,
                      'cpCliente'=>$codigoPostal,
                      'facturasPagar'=>$facturasPagar,
                      'tipo'=>'pago'
                    );
                }

                $modeloPagos = new Pagos();
                $idN = $modeloPagos->guardarActualizar($arr);
               
                if(count($idN) > 0)
                {  
                    $inf = json_decode($idN, true);
                    if($idMetodoPago == 'PPD')
                    {
                      $idPago = $inf['idPago'];
                      $idCFDI = $inf['idCFDI'];
                      array_push($arregloPagos,['idPago'=>$idPago,
                                                'idCFDI'=>$idCFDI,
                                                'idEmpresa'=>$idEmpresaFiscal,'tipo'=>'pago']);
                    }else{
                      $idPago = $inf['idPago'];
                      array_push($arregloPagos,['idPago'=>$idPago,
                                                'idEmpresa'=>$idEmpresaFiscal,
                                                'tipo'=>'pago']);
                    }

                    $verifica = $arregloPagos;
                    
                }else
                    break;
            

        }
   
        return json_encode($verifica);
    }
    
}//--fin de class Cobranza
    
?>