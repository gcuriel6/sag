<?php

require_once('conectar.php');

class CxC
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function CxC()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los proveedores de los registros de CxC
      * 
      * @param varchar $factura . Si es != 0  buscar todos los proveedores que coincidan con esa factura
      *
    **/
    function buscarRegistroIdCxC($tipo,$id){
        //-->NJES July/02/2020 agregar a la busqueda si el cxc tiene abonos
        if($id!=0)
        {
            $condicion=' a.id ='.$id;

            $result = $this->link->query("SELECT 
            a.id AS id_cxc,
            a.id_unidad_negocio,
            a.id_sucursal,
            a.vencimiento,
            a.anio,
            a.mes, 
            a.tasa_iva as porcentaje_iva, 
            a.id_factura,  
            a.id_nota_credito,
            a.folio_cxc,
            a.id_razon_social,
            a.id_cuenta_banco,
            a.estatus,      
            a.subtotal,
            a.total,
            a.iva,
            a.referencia,
            a.id_concepto,
            a.id_cuenta_banco,
            a.id_banco,    
            a.total AS cargo_inicial, 
            a.facturar,
            IF(a.folio_cxc>0,a.folio_cxc,IF(a.folio_factura>0,a.folio_factura,a.folio_nota_credito)) AS folio,          
            d.id_cliente,
            e.nombre_comercial AS cliente,
            (SELECT COUNT(id) AS abonos FROM cxc WHERE folio_cxc = $id AND folio_cxc!=id AND estatus != 'C') AS abonos
            FROM cxc a           
            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id           
            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal   
            LEFT JOIN razones_sociales d ON a.id_razon_social=d.id 
            LEFT JOIN cat_clientes e ON d.id_cliente=e.id
            WHERE  $condicion
            ORDER BY a.fecha DESC");
        
        

        }else{
                
            $result = array();

           
        }

        return query2json($result);

    }//- fin function buscarProveedoresCxC

    function buscarRegistroInicial($datos){
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $clientesInactivos = isset($datos['clientesInactivos']) ? $datos['clientesInactivos'] : 1;
        //-->NJES July/20/2020 para ver o no los cxc de clientes inactivos, por default se muestran solo activos
        $condFecha = '';

        if($fechaInicio == '' && $fechaFin == '')
        {
            $condFecha=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condFecha=" AND a.fecha >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
            $condFecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        if($clientesInactivos == 1)
            $condClientesActivos = 'AND e.inactivo=0'; //-->mostrar solo los clientes activos
        else
            $condClientesActivos = ''; //-->mostrar tambien clientes inactivos

        if($idSucursal != '')  //-->No tengo sucursales con permisos en la unidad entonces debo regresar un array vacio
        {
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }

        $result = $this->link->query("SELECT 
                            a.id,
                            a.id_unidad_negocio,
                            a.fecha AS fecha, 
                            a.id_factura,  
                            ntc.id AS id_nota_credito,
                            -- a.estatus,           
                            IF(a.folio_cxc > 0, a.estatus, fcfdi.estatus) AS estatus,
                            (a.total - IFNULL(fac.importe_retencion,0) )AS cargo_inicial,
                            IF(a.folio_cxc > 0,'CXC',IF(a.folio_factura>0,'FAC','NOT')) AS tipo,      
                            IF(a.folio_cxc = 0,'',a.folio_cxc) AS folio_cxc,           
                            IF(a.folio_factura = 0,'',a.folio_factura) AS factura,           
                            IF(ntc.folio_nota_credito is null ,'', ntc.folio_nota_credito) AS nota,            
                            IF(a.folio_cxc > 0, IFNULL(SUM(IF(a.estatus NOT IN('C','P'),a.subtotal + a.iva - IFNULL(fac.importe_retencion,0) + IFNULL((ac_cxc.cargos_cxc),0) - IFNULL((ac_cxc.abonos_cxc),0),0)),0),
                                ( (a.total - IFNULL(fac.importe_retencion,0) + IFNULL((ac_cxc.cargos_cxc),0)) - ( (IFNULL(ntc.abonos_notas, 0)) + (IFNULL(pagos.total_abonos, 0)) + IFNULL((ac_cxc.abonos_cxc),0) )))  AS saldo,            
                            IFNULL((ac_cxc.cargos_cxc),0),
                            IFNULL((ac_cxc.abonos_cxc),0),
                            IFNULL(ntc.abonos_notas, 0),
                            IFNULL(pagos.total_abonos, 0),
                            b.nombre AS unidad_negocio,           
                            c.descr AS sucursal,
                            d.razon_social,
                            d.id_cliente,
                            e.nombre_comercial AS cliente,
                            fac.id_empresa_fiscal,
                            ef.razon_social AS empresa_fiscal,
                            a.vencimiento AS fecha_vencimiento,
                            a.id_razon_social,
                            d.rfc AS rfc_receptor  
                            FROM cxc a           
                            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id           
                            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal   
                            LEFT JOIN razones_sociales d ON a.id_razon_social=d.id 
                            LEFT JOIN cat_clientes e ON d.id_cliente=e.id
                            LEFT JOIN facturas fac ON a.id_factura=fac.id
                            LEFT JOIN facturas_cfdi fcfdi ON fac.id = fcfdi.id_factura
                            LEFT JOIN empresas_fiscales ef ON fac.id_empresa_fiscal=ef.id_empresa 

                            LEFT JOIN (
                                SELECT id,id_factura_nota_credito,
                                GROUP_CONCAT(folio_nota_credito)  folio_nota_credito,
                                SUM(total-importe_retencion) AS abonos_notas
                                FROM facturas 
                                WHERE id_factura_nota_credito > 0 AND estatus = 'T'
                                GROUP BY id_factura_nota_credito
                            ) ntc ON a.id_factura=ntc.id_factura_nota_credito
                            LEFT JOIN
                            (
                                SELECT SUM(importe_pagado) AS total_abonos,
                                id_factura AS id_factura
                                FROM 
                                pagos_d
                                INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
                                WHERE pagos_cfdi.estatus_cfdi IN  ('T', 'A')
                                GROUP BY id_factura
                            ) pagos ON a.id_factura  = pagos.id_factura
                            LEFT JOIN (
                                SELECT SUM(IF((SUBSTR(cve_concepto,1,1) = 'C'),total,0)) AS cargos_cxc,
                                SUM(IF((SUBSTR(cve_concepto,1,1) = 'A'),total,0)) AS abonos_cxc,
                                folio_cxc
                                FROM cxc
                                WHERE cargo_inicial=0 AND estatus NOT IN ('C','P')
                                GROUP BY folio_cxc
                            ) ac_cxc ON a.id = ac_cxc.folio_cxc
                    WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $condFecha 
                    AND a.id_orden_servicio=0 AND a.id_venta=0 AND SUBSTR(a.cve_concepto, 1, 1) = 'C' AND a.cargo_inicial=1
                    $condClientesActivos 
                    GROUP BY a.folio_cxc,a.id_factura,a.id_nota_credito
                    ORDER BY a.id DESC");
        
            return query2json($result);

        }else{
                
            $arr = array();

            return json_encode($arr);
        }

    }//- fin function buscarFacturas
    /**
      * Guardo CxC los cargos y abonos a una factura
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarCxC($datos){
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function guardarCxC

    /**
      * Guardo CxC los cargos y abonos a una factura
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarActualizar($datos){
        $verifica = 0;


        $idCxC = $datos['idCxC'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idRazonSocialReceptor = $datos['idRazonSocialReceptor'];
        $vencimiento = $datos['vencimiento'];
        $tasaIva = $datos['tasaIva'];
        $mes = $datos['mes'];
        $anio = $datos['anio'];
        $idConcepto = $datos['idConcepto'];
        $cveConcepto = $datos['cveConcepto'];
        $fecha = $datos['fecha'];
        $importe = $datos['importe'];
        $totalIva = $datos['totalIva'];
        $total = $datos['total'];
        $referencia = $datos['referencia'];
        $idBanco = $datos['idBanco'];
        $idCuentaBanco = $datos['idCuentaBanco'];
        $idUsuario = $datos['idUsuario'];
        $estatus = isset($datos['estatus']) ? $datos['estatus'] : 'A';
        $cargoInicial = $datos['cargoInicial'];
        $idOrdenServicio = $datos['idOrdenServicio'];
        $idRazonSocialServicio = $datos['idRazonSocialServicio'];
        $facturar = isset($datos['facturar']) ? $datos['facturar'] : '0';
        $tipoCuenta = isset($datos['tipoCuenta']) ? $datos['tipoCuenta'] : '';
        //-->NJES March/18/2020 se agrega concepto cobro al generar cobro de orden servicio
        $conceptoCobro = isset($datos['conceptoCobro']) ? $datos['conceptoCobro'] : '';

        $observaciones = isset($datos['observaciones']) ? $datos['observaciones'] : '';
       

        $query = "INSERT INTO cxc(id_unidad_negocio,id_sucursal,folio_cxc,id_razon_social,fecha,id_concepto,cve_concepto,tasa_iva,subtotal,iva,total,referencia,mes,anio,vencimiento,cargo_inicial,id_banco,id_cuenta_banco,estatus,usuario_captura,id_orden_servicio,id_razon_social_servicio,facturar,concepto_cobro,observaciones) 
                    VALUES ('$idUnidadNegocio','$idSucursal','$idCxC','$idRazonSocialReceptor','$fecha','$idConcepto','$cveConcepto','$tasaIva','$importe','$totalIva','$total','$referencia','$mes','$anio','$vencimiento','$cargoInicial','$idBanco','$idCuentaBanco','$estatus','$idUsuario','$idOrdenServicio','$idRazonSocialServicio','$facturar','$conceptoCobro','$observaciones')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $id = mysqli_insert_id($this->link);

        if ($result) 
        {  
            if($cargoInicial==1){

                $queryU = "UPDATE cxc SET folio_cxc='$id' WHERE id=".$id;
                $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
                $verifica = $id;

            }else{

                $query="SELECT    
                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),((a.subtotal + a.iva) * -(1))),0)),0) AS saldo            
                FROM cxc a           
                WHERE a.folio_cxc=".$idCxC;
                $resultS=mysqli_query($this->link, $query);
                $numRows=mysqli_num_rows($resultS);
                if($numRows>0){

                    $datoS = mysqli_fetch_array($resultS);
                    $saldo= $datoS['saldo'];

                    $arr=array(
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'importe'=>$total,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'categoria'=>'Seguimiento a Cobranza',
                        'fechaAplicacion'=>$fecha
                    );
                  
                    if($saldo==0){

                        $queryU = "UPDATE cxc SET estatus='S' WHERE folio_cxc=".$idCxC;
                        $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
                        if($resultU){
                            if(substr($cveConcepto,0,1)=='A')
                            {
                                if($tipoCuenta == 0)
                                {
                                    $verifica = $this -> guardarMovimientosBancos($id,$arr);
                                }else{
                                    $verifica = $this -> guardarGastoCajaChica($id,$arr);
                                }

                            }else
                                $verifica = $id; 
                        }else{
                            $verifica = 0;
                        }

                    }else{
                        if(substr($cveConcepto,0,1)=='A')
                        {
                            if($tipoCuenta == 0)
                            {
                                $verifica = $this -> guardarMovimientosBancos($id,$arr);
                            }else{
                                $verifica = $this -> guardarGastoCajaChica($id,$arr);
                            }

                        }else
                            $verifica = $id;                        
                    }
                }else{
                    $verifica = $id;
                }

                
            }
            
        }else{
            $verifica = 0;
        }
        
        return $verifica;
    }//- fin function guardarActualizar

    
    /**
      * Busca el saldo actual de la factura
      * 
      * @param int id_CxC de la factura
      *
    **/
    function buscarSaldoActualIdCxC($idCxC,$tipo){
        
        $condicion='';
        $query = "";

        if($tipo == 'CXC'){
            //$condicion = "WHERE a.id = ".$idCxC;
            //-->NJES Feb/11/2020 se obtiene el saldo de un cxc menos sus abonos y se ligan por medio del folio_cxc
            //se obtienen el cargo inicial para ver si se podra cancelar el cxc 
            $condicion = "WHERE a.folio_cxc = ".$idCxC;
            $query = "SELECT IF(a.cargo_inicial=1,a.subtotal + a.iva,0) AS cargo_inicial,
                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),((a.subtotal + a.iva) * -(1))),0)),0) AS saldo
                FROM cxc a
                $condicion
                GROUP BY a.folio_cxc";
        }else if( $tipo == 'FAC')
        {
            $condicion = "WHERE a.id = ".$idCxC;
            $query = "SELECT             
                ((a.total - a.retencion) + IFNULL(ac_cxc.cargos_cxc,0)) - ((IFNULL(not_a.total_notas, 0)) + (IFNULL(pagos.total_abonos, 0)) + IFNULL(ac_cxc.abonos_cxc,0) ) AS saldo  
                FROM cxc a           
                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id           
                LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal   
                LEFT JOIN razones_sociales d ON a.id_razon_social=d.id 
                LEFT JOIN cat_clientes e ON d.id_cliente=e.id

                left join (
                    SELECT SUM(aa.total - aa.importe_retencion) AS total_notas,
                    aa.id_factura_nota_credito
                    FROM 
                    facturas aa
                    INNER JOIN facturas_cfdi ff ON aa.id = ff.id_factura 
                    WHERE ff.estatus = 'T'
                    GROUP BY aa.id_factura_nota_credito
                ) not_a ON a.id_factura = not_a.id_factura_nota_credito
                
                LEFT JOIN
                (
                    SELECT SUM(importe_pagado) AS total_abonos,
                    id_factura AS id_factura
                    FROM 
                    pagos_d
                    INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
                    WHERE pagos_cfdi.estatus_cfdi IN  ('T', 'A')
                    GROUP BY id_factura
                ) pagos ON a.id_factura  = pagos.id_factura

                LEFT JOIN (
                    SELECT SUM(IF((SUBSTR(cve_concepto,1,1) = 'C'),total,0)) AS cargos_cxc,
                    SUM(IF((SUBSTR(cve_concepto,1,1) = 'A'),total,0)) AS abonos_cxc,
                    folio_cxc
                    FROM cxc
                    WHERE cxc.cargo_inicial=0
                    GROUP BY folio_cxc
                ) ac_cxc ON a.id = ac_cxc.folio_cxc
                $condicion
                GROUP BY a.folio_cxc,a.id_factura,a.id_nota_credito
                ORDER BY a.id DESC";
        }
        
        $resultado = $this->link->query($query);

        return query2json($resultado);
    }//- fin function buscarSaldoActualIdCxC

    function buscarRegistrosIdCxC($idCxC,$tipo){

        $condicion='';
        $query = "";

        if($tipo == 'CXC')
        {

            $condicion = "WHERE a.folio_cxc = ".$idCxC;
            $query = "SELECT a.id AS folio,'Abono' AS tipo,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)as concepto,a.subtotal,a.iva,
                                            IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.retencion),0) AS cargos,
                                            IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva - a.retencion),0) AS abonos
                                            FROM cxc a
                                            LEFT JOIN conceptos_cxp b ON  a.id_concepto=b.id 
                                            $condicion
                                            ORDER BY a.id ASC";

        }else if( $tipo == 'FAC')
        {

            $condicion = "WHERE a.id_factura = (SELECT id_factura FROM cxc WHERE id=".$idCxC.") ";//OR  a.id_nota_credito = (SELECT id_nota_credito FROM cxc WHERE id=".$idCxC." )
            $query = "SELECT a.id AS folio,'Abono' AS tipo,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,
                IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - IFNULL(fc.importe_retencion,0)),0) AS cargos,
                IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva - IFNULL(fc.importe_retencion,0)),0) AS abonos
                FROM cxc a
                LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                LEFT JOIN facturas fc ON a.id_factura=fc.id 
                WHERE a.id_factura = (SELECT id_factura FROM cxc WHERE id= " . $idCxC . ")
                UNION 
                SELECT fc.folio,'Nota de Credito' AS tipo,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,
                IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - IFNULL(fc.importe_retencion,0)),0) AS cargos,
                (a.total - IFNULL(fc.importe_retencion,0)) AS abonos
                FROM cxc a
                LEFT JOIN conceptos_cxp b ON  a.id_concepto=b.id
                LEFT JOIN facturas fc ON a.id_nota_credito=fc.id
                WHERE a.id_nota_credito IN (SELECT id FROM facturas WHERE id_factura_nota_credito = (SELECT id_factura FROM cxc WHERE id =  " . $idCxC . "))
                UNION 
                SELECT a.folio_pago AS folio,'Pago' AS tipo,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,
                IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.retencion),0) AS cargos,
                (a.total - a.retencion) AS abonos
                FROM cxc a
                LEFT JOIN conceptos_cxp b ON  a.id_concepto=b.id
                WHERE a.id_pago_d IN (SELECT id FROM pagos_d WHERE id_factura = (SELECT id_factura FROM cxc WHERE id =  " . $idCxC . "))
                UNION 
                SELECT a.id AS folio,IF((SUBSTR(a.cve_concepto,1,1) = 'C'),'Cargo','Abono') AS tipo,
                a.estatus,a.id_orden_servicio,
                a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,
                CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,                
                IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.total),0) AS cargos,                
                IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.total),0) AS abonos 
                FROM cxc a                
                LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id                 
                WHERE a.folio_cxc = ".$idCxC;
            
        }
        /*else{
            $condicion = "WHERE a.id_nota_credito = (SELECT id_nota_credito FROM cxc WHERE id=".$idCxC.")";
        }*/

        $resultado = $this->link->query($query);

        return query2json($resultado);
    }//- fin function buscarRegistrosIdCxC


    /**
      * Cancela una partida de una factura o la factura completa
      * 
      * @param varchar $tipo indica si se cancela una factura o una partida
      * @param int $idRegistro id de la partida para cancelar o id_CxC para cancelar la factura completa con sus partidas
      * @param int $idUsuario id del usuario que genera el movimiento
      *
    **/
    function cancelarCxC($idCXC,$tipo,$idUsuario,$justificacion){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");
       
        $verifica = $this -> cancelar($idCXC,$tipo,$idUsuario,$justificacion);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function cancelarCxC

    function cancelar($idCXC,$tipo,$idUsuario,$justificacion){
        $verifica=0;

        //-->NJES March/27/2020 se solicita que se justifique la cancelación de un cxc o una partida del cxc
        
         //--- cambia de estatus un registro especifioco a cancelado
         if($tipo=='registro'){
            $busqueda = "SELECT a.id_unidad_negocio,a.id_sucursal,a.id_razon_social,a.fecha,
                            a.id_cuenta_banco,a.total,a.id_concepto,a.cve_concepto,b.tipo AS tipo_cuenta
                            FROM cxc a
                            LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                            WHERE a.id=".$idCXC;
            $resultC = mysqli_query($this->link, $busqueda) or die(mysqli_error());

            if($resultC)
            {
                    $datosC=mysqli_fetch_array($resultC);

                    $idUnidadNegocio=$datosC['id_unidad_negocio']; 
                    $idSucursal=$datosC['id_sucursal'];
                    $fecha=$datosC['fecha'];
                    $tipoCuenta=$datosC['tipo_cuenta'];
                    $importe=$datosC['total']*(-1);
                    $idCuentaBanco=$datosC['id_cuenta_banco'];
                    $cveConcepto=$datosC['cve_concepto'];

                    $arr=array(
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'importe'=>$importe,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'categoria'=>'Seguimiento a Cobranza',
                        'fechaAplicacion'=>$fecha
                    );

                    $query="UPDATE cxc SET estatus='C',justificacion_cancelado='$justificacion' WHERE id=".$idCXC;
                    $result = mysqli_query($this->link, $query) or die(mysqli_error());

                    if($result)
                    {
                        if(substr($cveConcepto,0,1)=='A')
                        {
                            if($tipoCuenta == 0)
                            {
                                $verifica = $this -> guardarMovimientosBancos($idCXC,$arr);
                            }else{
                                $verifica = $this -> guardarGastoCajaChica($idCXC,$arr);
                            }

                        }else
                            $verifica = $idCXC;
                    }else{
                        $verifica = 0;
                    }
            }else{
                $verifica = 0;
            }
        }
        //-- cambia de estatus todo el cxc cargo inicicial y sus moviemientos relacionados
        if($tipo=='folio'){
            $query="UPDATE cxc SET estatus='C',justificacion_cancelado='$justificacion' WHERE folio_cxc=".$idCXC;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if($result)
            {
                $busqueda = "SELECT a.id,a.id_unidad_negocio,a.id_sucursal,a.id_razon_social,a.fecha,
                            a.id_cuenta_banco,a.total,a.id_concepto,a.cve_concepto,b.tipo AS tipo_cuenta
                            FROM cxc a
                            LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                            WHERE a.folio_cxc=$idCXC AND a.cargo_inicial=0";
                $resultC = mysqli_query($this->link, $busqueda) or die(mysqli_error());
                $num=mysqli_num_rows($resultC);

                if($num > 0)
                {
                    for ($i=1; $i <=$num ; $i++) { 
                        $row=mysqli_fetch_array($resultC);

                        $idCxPPartida=$row['id'];
                        $idUnidadNegocio=$row['id_unidad_negocio']; 
                        $idSucursal=$row['id_sucursal'];
                        $fecha=$row['fecha'];
                        $tipoCuenta=$row['tipo_cuenta'];
                        $importe=$row['total']*(-1);
                        $idCuentaBanco=$row['id_cuenta_banco'];
                        $cveConcepto=$row['cve_concepto'];

                        $arr=array(
                            'idUnidadNegocio'=>$idUnidadNegocio,
                            'idSucursal'=>$idSucursal,
                            'importe'=>$importe,
                            'idCuentaBanco'=>$idCuentaBanco,
                            'idUsuario'=>$idUsuario,
                            'categoria'=>'Seguimiento a Cobranza',
                            'fechaAplicacion'=>$fecha
                        );

                        if(substr($cveConcepto,0,1)=='A')
                        {
                            if($tipoCuenta == 0)
                            {
                                $verifica = $this -> guardarMovimientosBancos($idCxPPartida,$arr);
                            }else{
                                $verifica = $this -> guardarGastoCajaChica($idCxPPartida,$arr);
                            }

                        }else
                            $verifica = $idCXC;


                        if($verifica == 0)    
                            break;

                    }

                }else
                    $verifica=$idCXC;

            }else
                $verifica=0;
        }

        return $verifica;
    }//- fin function cancelar

  
    function buscarCargoInicialIdCxC($idCxC){
        $resultado = $this->link->query("SELECT id,(subtotal+iva) AS cargo_inicial FROM cxc WHERE id=".$idCxC);

        return query2json($resultado);
    }//- fin function buscarCargoInicialIdCxC

    //---MGFS SE AGREGA LA CONDICION PARA QUE TAMBIEN MJESTRE LAS VENTAS DE ALARMAS
    //---MGFS 22-01-2020 SE AGREGA LA CONDICION PARA QUE SE PUEDAN VER LOS PLANES( DE LOS RECIBOS GENERADOS)'a.id_plan>0'
    //---MGFS 23-01-2020 SE MODIFICA CONDICION PLAN ((a.id_plan > 0 AND a.facturar=0)) 
    //---PARA QUE NO SE MUESTREN LOS PLANES QUE SE HARÁN FACTURA Y NO SE DUPLIQUEN LOS ABONO DESDE PAGOS Y MODULO CXC ALARMAS
    function buscarRegistroInicialAlarmas($datos){
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $folio = $datos['folio'];
        $condFecha = '';

        if($fechaInicio == '' && $fechaFin == '')
        {
            $condFecha=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condFecha=" AND a.fecha >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
            $condFecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }
        $condicion_folio='';

        if($idSucursal != '')  //-->No tengo sucursales con permisos en la unidad entonces debo regresar un array vacio
        {
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }

            if($folio!=''){
                $condFecha='';
                $condicion_folio= " AND a.id=".$folio;
            }

            //-->NJES Feb/11/2020 se elimina condicion (AND a.facturar=0) para que muestre tambien los cxc que facturan
            //-->NJES March/19/2020 mostrar folio de recibo plan, venta o orden servicio
            $query = "SELECT 
            a.id,
            a.id_unidad_negocio,
            a.fecha AS fecha, 
            a.estatus,           
            a.total AS cargo_inicial, 
            IF(a.folio_factura>0,'FAC',IF(a.folio_nota_credito>0,'NOT','CXC')) AS tipo,          
            IF(a.folio_cxc=0,'',a.folio_cxc) AS folio_cxc,           
            a.id_orden_servicio,        
            IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.descuento),((a.subtotal + a.iva - a.descuento) * -(1))),0)),0) AS saldo,            
            IF(a.id_venta>0,'VENTA',IF(a.id_orden_servicio>0,'ORDEN SERVICIO',IF(a.id_plan>0,'PLAN','CXC')))AS cargo_por,
            b.nombre AS unidad_negocio,           
            c.descr AS sucursal,
            d.id as id_cliente,
            d.nombre_corto,
            d.nombre_corto AS cliente,
            IFNULL(d.razon_social,'') AS razon_social,
            IF(a.id_venta>0,f.folio,IF(a.id_orden_servicio>0,a.id_orden_servicio,IF(a.id_plan>0,a.folio_recibo,a.folio_cxc)))AS folio,
            a.vencimiento  
            FROM cxc a           
            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id           
            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal   
            LEFT JOIN servicios d ON a.id_razon_social_servicio=d.id 
            LEFT JOIN servicios_ordenes e ON a.id_orden_servicio=e.id
            LEFT JOIN notas_e f ON a.id_venta=f.id
            WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $condicion_folio $condFecha 
            AND (a.id_plan > 0 OR a.id_orden_servicio > 0 OR a.id_venta >0)
            GROUP BY a.folio_cxc,a.id_factura,a.id_nota_credito
            ORDER BY a.id DESC";

            // echo $query;
            // exit();
            
            $result = $this->link->query($query);
        
            return query2json($result);

        }else{
                
            $arr = array();

            return json_encode($arr);
        }
    }//- fin function buscarFacturas


    /**
      * Busca los proveedores de los registros de CxC
      * 
      * @param varchar $factura . Si es != 0  buscar todos los proveedores que coincidan con esa factura
      *
    **/
    function buscarRegistroIdCxCAlarmas($tipo,$id){
        
        if($id!=0)
        {
            $condicion=' a.id ='.$id;

            $result = $this->link->query("SELECT 
            a.id AS id_cxc,
            a.id_unidad_negocio,
            a.id_sucursal,
            a.vencimiento,
	        a.anio,
            a.mes, 
            a.tasa_iva as porcentaje_iva, 
            a.id_factura,  
            a.id_nota_credito,
            a.folio_cxc,
            a.id_razon_social_servicio as id_razon_social,
            a.id_cuenta_banco,
            a.estatus,      
            a.subtotal,
            a.retencion,
            a.total,
            a.iva,
            a.referencia,
            a.id_concepto,
            a.id_banco,    
            a.total AS cargo_inicial, 
            IF(a.folio_factura>0,a.folio_factura,IF(a.folio_nota_credito>0,a.folio_nota_credito,a.folio_cxc)) AS folio,          
            IF(a.id_venta>0,'VENTA',IF(a.id_orden_servicio>0,'ORDEN SERVICIO',IF(a.id_plan>0,'PLAN','CXC')))AS cargo_por,
            a.id_razon_social_servicio as id_cliente,
            a.facturar,
            a.id_venta,
            a.id_orden_servicio,
            a.id_plan,
            d.nombre_corto,
            d.nombre_corto AS cliente,
            IFNULL(d.razon_social,'') AS razon_social,
            a.id_factura,
            ifnull(e.descripcion,'') as cuenta_banco,
            IFNULL(a.observaciones,'') AS observaciones
            FROM cxc a           
            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id           
            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal   
            LEFT JOIN servicios d ON a.id_razon_social_servicio=d.id 
            LEFT JOIN  cuentas_bancos e ON a.id_cuenta_banco=e.id
            WHERE  $condicion
            ORDER BY a.fecha DESC");
        
        

        }else{
                
            $result = array();

           
        }

        return query2json($result);

    }//- fin function buscarProveedoresCxC

    /**
      * Busca los cargos y abonos de una factura
      * 
      * @param int id_CxC de la factura
      *
    **/
    function buscarEstadoCuenta($idCliente,$tipo,$fechaInicio,$fechaFin){

        $condicion='';
        $condFecha = '';

        if($fechaInicio == '' && $fechaFin == '')
        {
            $condFecha=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condFecha=" AND a.fecha >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
            $condFecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        if($tipo == 'orden_servicio'){
            $condicion =  " AND a.id_razon_social_servicio = ".$idCliente." AND a.estatus NOT IN('C','P')";
        }

        $query = "SELECT a.id_orden_servicio,a.folio_cxc as folio,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,
        IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),0) AS cargos,
        IF( IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) = 0, IFNULL(pagos_abonos.importe_pagado, 0), IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) ) AS abonos,
        SUBSTR(a.cve_concepto,1,1)AS tipo,
        IFNULL(IF(c.es_plan=1,a.vencimiento,DATE_ADD(c.fecha, INTERVAL c.dias_credito DAY)),'') AS fecha_vencimiento,
        IF(c.folio>0,c.folio,'') AS folio_factura
        FROM cxc a
        LEFT JOIN conceptos_cxp b ON a.cve_concepto=b.clave AND b.tipo=1
        LEFT JOIN facturas c ON a.id_factura=c.id
        LEFT JOIN 
        (

        SELECT SUM(cxc.total) AS importe_pagado, cxc.id AS id_cxc
        -- SELECT SUM(pagos_d.importe_pagado) AS importe_pagado, cxc.id AS id_cxc
        FROM pagos_d
        INNER JOIN pagos_e ON pagos_d.id_pago_e = pagos_e.id
        INNER JOIN facturas ON pagos_d.id_factura = facturas.id
        INNER JOIN cxc ON facturas.id_cxc = cxc.id
        WHERE pagos_e.estatus != 'C'

        GROUP BY cxc.id

        ) pagos_abonos  ON a.id = pagos_abonos.id_cxc
        WHERE 1 $condicion AND a.folio_cxc IN(SELECT DISTINCT(a.folio_cxc ) AS folio_cxc FROM cxc a  WHERE 1 $condicion $condFecha) 
        ORDER BY a.id ASC";

        // echo $query;
        // exit();

        $resultado = $this->link->query($query);

        return query2json($resultado);
    }//- fin function buscarRegistrosIdCxC

      /**
        * Actualiza los registros relacionados con la factura realizada
        *
        * @param int $idFactura
        * @param varchar $partidas  array que contiene los datos
        *
    **/
    function actualizaCXCIDFactura($idFacturaA,$estatus,$tipo,$registrosCXC,$idServicio,$idsServicios){
      
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");


        //--MGFS 03-03-2020  se agrega la bandera si es facturacion por rfc
        $facturaRfc = 0;
        if($idServicio > 1){
            $idsServicios = isset($idsServicios) ? $idsServicios : '';
            $idsUnicos = array_unique($idsServicios);

            if(count($idsUnicos)>1){
                $facturaRfc = 1;
            }
        }
        //--cuando manda cancelar libera el cxc quitando el id_factura y folio_fcatura
        if($tipo=='Cancelar'){
            $folioF = 0;
            $idFactura = 0; 
        }else{
            //-- si no es cancelacion deja ell id de la prefactura que se acaba de generar
            $idFactura = $idFacturaA;
        }

        
        if($idFactura>0){
            $queryFolio="SELECT folio FROM facturas WHERE id=".$idFacturaA;
            $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
            $rowF = mysqli_fetch_array($resultF);
            $folioF = $rowF['folio'];
        }
       //-- Se agrega la fcaturacion por rfc  la cual puede tener diferentes servciios(clientes con mismo rfc), si el idservicio=1 es para pueblico en general
       //--- si trae varios servicios pero es el mismo no factura por rfc
       //--- si va a timbrar solo cambiará el estatus
        if($idServicio ==1 || $facturaRfc==0 || $estatus=='T' || $estatus=='P'){

        
            foreach($registrosCXC as $partida){
            
                $idCXC = isset($partida['idCXC'])? $partida['idCXC'] : 0 ;

                $query = "UPDATE cxc SET estatus='$estatus', id_factura='$idFactura',folio_factura='$folioF' WHERE id=".$idCXC;
                $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
                if ($result) {
                
                    $verifica = $idFacturaA;
                }else{
                    
                    $verifica = 0;
                    break;
                }

            }
        }else{
            // si la factura es por rfc trae varios ids servicios (clientes con mismo rfc)
            foreach($registrosCXC as $partida){
            
                $idCXC = isset($partida['idCXC'])? $partida['idCXC'] : 0 ;
                $idServicioP = isset($partida['idServicio'])? $partida['idServicio'] : 0 ;
                //--SI CANCELA---
                //-- si cancela se regresan los valosres originales a los valores iniciales
                //-- subtotal = subtotal_origen, iva=iva_origen, total= total_origen se regresa el estatus a A para poder volver a facturar

                if($idFactura==0){

                    $query = "UPDATE cxc SET estatus='$estatus', id_factura='$idFactura',folio_factura='$folioF',factura_por_rfc=0, subtotal = subtotal_origen ,iva = iva_origen ,total=total_origen, subtotal_origen = 0 ,iva_origen = 0 ,total_origen=0 WHERE id=".$idCXC;
                    $result = mysqli_query($this->link, $query) or die(mysqli_error());

                }else{
                    //-- SI ES UNA PREFACTURA--
                    // -- asigna sus valores a los valores originales subtotal_origen= subtotal, iva_origen=iva, total_origen=total 
                    $queryU = "UPDATE cxc SET  subtotal_origen=subtotal, iva_origen=iva, total_origen=total WHERE id=".$idCXC;
                    $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());

                    if($resultU)
                    {   
                        if($idServicio!=$idServicioP){
                        //-- asigna el id y folio de factura y limpia sus valores a 0 
                        $query = "UPDATE cxc SET estatus='$estatus', id_factura='$idFactura',folio_factura='$folioF',factura_por_rfc=1, subtotal=0, iva=0,total=0 WHERE id=".$idCXC;
                        $result = mysqli_query($this->link, $query) or die(mysqli_error());
                        }else{
                             //-- asigna el id y folio de factura y mantiene sus valores
                            $query = "UPDATE cxc SET estatus='$estatus', id_factura='$idFactura',folio_factura='$folioF',factura_por_rfc=1 WHERE id=".$idCXC;
                            $result = mysqli_query($this->link, $query) or die(mysqli_error());
                        }

                        if ($result) {
                
                            $verifica = $idFacturaA;
                        }else{
                            
                            $verifica = 0;
                            break;
                        }
                    }else{
                        $verifica = 0;
                        break;
                    }
                }
        
                if ($result) {
                    
                    $verifica = $idFacturaA;
                   
                }else{
                    
                    $verifica = 0;
                    break;
                }

            }

        }
        //--cuando sea una prefactura y traiga mas de un id servicio debera sumar los cxc con id_servicio difrente 
        //--y se lo sumara al id_cxc menor del servicio que esta facturando
        if($tipo=='Prefactura' && $facturaRfc==1){
            $verifica = $this -> asignaMontoServicio($idFacturaA,$idServicio);
        }

        if($verifica > 0)
           
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function guardarPartidas

    function asignaMontoServicio($idFacturaA,$idServicio){
        $verifica = 0;
        //--- busco todos los cxc del servicio que esta facturando y obtengo el cxc menor
        $buscaCxc = "SELECT id 
                    FROM cxc 
                    WHERE id_factura=".$idFacturaA." AND id_razon_social_servicio=".$idServicio." 
                    ORDER BY id ASC 
                    LIMIT 1";
        $resultCxc = mysqli_query($this->link, $buscaCxc) or die(mysqli_error());
        $rows = mysqli_num_rows($resultCxc);
      
        if($rows>0){


            $rowCxc = mysqli_fetch_array($resultCxc);
            $idCxcMenor = $rowCxc['id'];
            //--- ontengo el total de todos los cxc con diferente id_servicio del qu essta facturando y ek dell cxc menor  para asignarselo 
 
            $obtieneTotales = "SELECT 
                                    SUM(subtotal_origen) AS subtotal,
                                    SUM(iva_origen) AS iva, 
                                    SUM(total_origen) AS total 
                                FROM cxc 
                                WHERE id_factura=".$idFacturaA." AND (id_razon_social_servicio!=".$idServicio." OR id=".$idCxcMenor.") 
                                GROUP BY id_factura";
            $resultTotales = mysqli_query($this->link, $obtieneTotales) or die(mysqli_error());

            $rowT = mysqli_fetch_array($resultTotales);
            $subtotal = $rowT['subtotal']; 
            $iva = $rowT['iva']; 
            $total = $rowT['total'];  
            //-- Le asigno los valores al cxc menor del d¿servicio que esta facturando
            $queryUC = "UPDATE cxc SET  subtotal='$subtotal', iva='$iva', total='$total' WHERE id=".$idCxcMenor;
            $resultUC = mysqli_query($this->link, $queryUC) or die(mysqli_error());

            if($resultUC){

                $verifica = $idFacturaA;

            }else{
                $verifica = 0;
            }

        }else{

            $verifica = 0;
        }
        
        return $verifica;
    }

    function guardarMovimientosBancos($idCxC,$datos){
        $verifica = 0;
  
        $idCuentaBanco = $datos['idCuentaBanco'];
        $idUsuario = $datos['idUsuario'];
        $importe = $datos['importe'];
        $categoria = $datos['categoria'];
        $fecha = $datos['fecha'];
        $fechaAplicacion = $datos['fechaAplicacion'];
        
        $query = "INSERT INTO movimientos_bancos(id_cuenta_banco,monto,tipo,id_usuario,observaciones,id_cxc,fecha_aplicacion) 
                  VALUES ('$idCuentaBanco','$importe','A','$idUsuario','$categoria','$idCxC','$fechaAplicacion')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
            $verifica = $idCxC;          
        else
          $verifica = 0;
        
  
        return $verifica;
      }//- fin function guardarMovimientosBancos
  
      function guardarGastoCajaChica($idCxC,$datos){
        $verifica = 0;
  
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $importe = $datos['importe'];
        $categoria = $datos['categoria'];
        $idUsuario = $datos['idUsuario'];
        $fecha = $datos['fecha'];
        $fechaAplicacion = $datos['fechaAplicacion'];
  
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
            //--> Inserta en caja chica cargo
            $query="INSERT INTO caja_chica(folio,id_unidad_negocio,id_sucursal,id_concepto,clave_concepto,fecha,importe,observaciones,estatus,id_usuario,id_cxc)
                    VALUES('$folio','$idUnidadNegocio','$idSucursal',15,'C01','$fechaAplicacion','$importe','$categoria',1,'$idUsuario','$idCxC')";
            $result=mysqli_query($this->link, $query)or die(mysqli_error());
            
            if($result)
            {
              $verifica = $idCxC;      
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
      }//- fin function guardarGastoCajaChica

       /**
      * Busca los cargos y abonos de una factura de alarmas
      * 
      * @param int id_CxC de la factura
      *
    **/
    function buscarRegistrosIdCxCAlarmas($idCxC,$tipo){

        $condicion='';
        $query = "";

        if($tipo == 'CXC')
        {

            $condicion = "WHERE a.folio_cxc = ".$idCxC;
            $query = "SELECT '' AS tipo_abono,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)as concepto,a.subtotal,a.iva,
                                            IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.descuento - a.retencion),0) AS cargos,
                                            IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva - a.retencion),0) AS abonos,
                                            IFNULL(a.observaciones,'') AS observaciones
                                            FROM cxc a
                                            LEFT JOIN conceptos_cxp b ON  a.id_concepto=b.id 
                                            $condicion
                                            ORDER BY a.id ASC";

        //}else if( $tipo == 'FAC')
        }else{
            //$condicionPagos = '';
            $condicionPagos = "SELECT 'pago' AS tipo_abono,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,
                    IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.retencion),0) AS cargos,
                    (a.total - a.retencion) AS abonos,
                    IFNULL(a.observaciones,'') AS observaciones
                    FROM cxc a
                    LEFT JOIN conceptos_cxp b ON  a.id_concepto=b.id
                    WHERE a.id_pago_d IN (SELECT id FROM pagos_d WHERE id_factura = (SELECT id_factura FROM cxc WHERE id =  " . $idCxC . "))"; 

            $facturaMultiple = "SELECT DISTINCT(multiple_cxc) as multiple_cxc FROM pagos_d WHERE id_factura = (SELECT id_factura FROM cxc WHERE id =  ".$idCxC.")";
            $resulFM = mysqli_query($this->link,$facturaMultiple) or die(mysqli_error());
            $numRows = mysqli_num_rows($resulFM);
            if($numRows>0){
                $rowFM = mysqli_fetch_array($resulFM);
                $multipleCXC = $rowFM['multiple_cxc'];
                if($multipleCXC==1)
                {


                    $condicionPagos = " SELECT 'pago' AS tipo_abono,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,
                    IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.descuento - a.retencion),0) AS cargos,
                    (a.total - a.retencion) AS abonos,
                    IFNULL(a.observaciones,'') AS observaciones
                    FROM cxc a
                    LEFT JOIN conceptos_cxp b ON  a.id_concepto=b.id
                    WHERE a.id_cxc_pago = ".$idCxC;

                }

            }
                


            //$condicion = "WHERE a.id_factura = (SELECT id_factura FROM cxc WHERE id=".$idCxC.") ";//OR  a.id_nota_credito = (SELECT id_nota_credito FROM cxc WHERE id=".$idCxC." )
            $query = "SELECT 'cargo' AS tipo_abono,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,
                IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.descuento - a.retencion),0) AS cargos,
                IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva - a.retencion),0) AS abonos,
                IFNULL(a.observaciones,'') AS observaciones
                FROM cxc a
                LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id 
                WHERE a.id = " . $idCxC . "
                UNION 
                SELECT 'nota_credito' AS tipo_abono,a.estatus,a.id_orden_servicio,a.cargo_inicial,a.id,a.fecha,IFNULL(a.referencia,'') AS referencia,CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,a.subtotal,a.iva,
                IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.retencion),0) AS cargos,
                (a.total - a.retencion) AS abonos,
                IFNULL(a.observaciones,'') AS observaciones
                FROM cxc a
                LEFT JOIN conceptos_cxp b ON  a.id_concepto=b.id
                WHERE a.id_nota_credito IN (SELECT id FROM facturas WHERE id_factura_nota_credito = (SELECT id_factura FROM cxc WHERE id =  " . $idCxC . "))
                UNION 
                $condicionPagos";

        }
        /*else{
            $condicion = "WHERE a.id_nota_credito = (SELECT id_nota_credito FROM cxc WHERE id=".$idCxC.")";
        }*/

        // echo $query;
        // exit();
        
        $resultado = $this->link->query($query);
        return query2json($resultado);

    }//- fin function buscarRegistrosIdCxC

    /**
      * Busca el saldo actual de la factura
      * 
      * @param int id_CxC de la factura
      *
    **/
    function buscarSaldoActualIdCxCAlarmas($idCxC,$tipo){
        
        $condicion='';
        $query = "";

        if($tipo == 'CXC'){
            //$condicion = "WHERE a.id = ".$idCxC;
            //-->NJES Feb/11/2020 se obtiene el saldo de un cxc menos sus abonos y se ligan por medio del folio_cxc
            //se obtienen el cargo inicial para ver si se podra cancelar el cxc 
            $condicion = "WHERE a.folio_cxc = ".$idCxC;
            $query = "SELECT 0 AS multi,a.id_factura,IF(a.cargo_inicial=1,a.subtotal + a.iva - a.descuento,0) AS cargo_inicial,
                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - a.descuento),((a.subtotal + a.iva - a.descuento) * -(1))),0)),0) AS saldo
                FROM cxc a
                $condicion
                GROUP BY a.folio_cxc";
        }else if( $tipo == 'FAC')
        {
            $multi = 0;
            //--- SE AGREGA LA CONDICION DE PAGOS PARA LAS FACTURAS DE ALARMAS CON MULTIPLES CXC 
            $condicionPagos = "(SELECT SUM(importe_pagado) AS total_abonos,
            id_factura AS id_factura
            FROM 
            pagos_d
            INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
            WHERE pagos_cfdi.estatus_cfdi IN  ('T', 'A')
            GROUP BY id_factura) pagos ON a.id_factura  = pagos.id_factura";

            $facturaMultiple = "SELECT DISTINCT(multiple_cxc) as multiple_cxc FROM pagos_d WHERE id_factura = (SELECT id_factura FROM cxc WHERE id =  $idCxC)";
            $resulFM = mysqli_query($this->link,$facturaMultiple) or die(mysqli_error());
            $numRows = mysqli_num_rows($resulFM);
            if($numRows>0){
                $rowFM = mysqli_fetch_array($resulFM);
                $multipleCXC = $rowFM['multiple_cxc'];
                if($multipleCXC==1){
                    $multi = 1;
                    $condicionPagos = "(                    
                        SELECT SUM(total) AS total_abonos,id_cxc_pago
                        FROM cxc
                        WHERE id_cxc_pago=$idCxC AND estatus!='C'
                        GROUP BY id_cxc_pago              
                    ) pagos   ON a.id  = pagos.id_cxc_pago";
                }
            }
            //$condicion = "WHERE a.id_factura = (SELECT id_factura FROM cxc WHERE id=".$idCxC.")";
            $condicion = "WHERE a.id = ".$idCxC;
            $query = "SELECT $multi AS multi,a.id_factura,            
                (facturas.total - facturas.retencion -facturas.descuento) - ((IFNULL(ntc.total, 0)) + (IFNULL(pagos.total_abonos, 0)) ) AS saldo  
                FROM cxc a
                INNER JOIN facturas ON facturas.id = a.id_factura            
                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id           
                LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal   
                LEFT JOIN razones_sociales d ON a.id_razon_social=d.id 
                LEFT JOIN cat_clientes e ON d.id_cliente=e.id

                LEFT JOIN facturas ntc ON a.id_factura = ntc.id_factura_nota_credito AND ntc.estatus != 'C'
                LEFT JOIN
                
                    $condicionPagos
                
                $condicion
                GROUP BY a.folio_cxc,a.id_factura,a.id_nota_credito
                ORDER BY a.id DESC";
        }
        /*else{
            $condicion = "WHERE a.id_nota_credito = (SELECT id_nota_credito FROM cxc WHERE id=".$idCxC.")";
        }*/
       
        $resultado = $this->link->query($query);

        return query2json($resultado);
    }//- fin function buscarSaldoActualIdCxCAlarmas

    function buscaNumCxCMismaFactura($idCxC){
        $verifica = 0;

        $busca = "SELECT id_factura FROM cxc WHERE id=$idCxC";
        $resultB = mysqli_query($this->link, $busca)or die(mysqli_error());
        $numB = mysqli_num_rows($resultB);

        if($numB > 0)
        {
            $rowB = mysqli_fetch_assoc($resultB);
            $idFactura = $rowB['id_factura'];

            if($idFactura > 0)
            {
                $query = "SELECT COUNT(id) AS nums FROM cxc WHERE id_factura = $idFactura";
                $result = mysqli_query($this->link, $query)or die(mysqli_error());
                $num = mysqli_num_rows($result);

                if($num > 0)
                {
                    $row2 = mysqli_fetch_assoc($result);
                    $verifica = $row2['nums'];
                }
            }
        }

        return $verifica;
    }

    function buscarRegistroCxCMismaFactura($idFactura){
        $resultado = $this->link->query("SELECT 
            a.id,
            a.fecha AS fecha,       
            a.total AS cargo_inicial,         
            IF(a.folio_cxc=0,'',a.folio_cxc) AS folio_cxc,                   
            IF(a.id_venta>0,'VENTA',IF(a.id_orden_servicio>0,'ORDEN SERVICIO',IF(a.id_plan>0,'PLAN','CXC')))AS cargo_por,
            IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),((a.subtotal + a.iva) * -(1))),0)),0) AS saldo,            
            d.nombre_corto,
            d.nombre_corto AS cliente,
            IFNULL(d.razon_social,'') AS razon_social,
            IF(a.id_venta>0,f.folio,IF(a.id_orden_servicio>0,a.id_orden_servicio,IF(a.id_plan>0,a.folio_recibo,a.folio_cxc)))AS folio   
            FROM cxc a           
            LEFT JOIN servicios d ON a.id_razon_social_servicio=d.id 
            LEFT JOIN notas_e f ON a.id_venta=f.id
            WHERE a.id_factura=$idFactura 
            AND (a.id_plan > 0 OR a.id_orden_servicio > 0 OR a.id_venta >0)
            GROUP BY a.folio_cxc,a.id_factura,a.id_nota_credito
            ORDER BY a.id DESC");

        return query2json($resultado);
    }

    function buscarAbonosMismaFactura($idFactura){
        $resultado = $this->link->query("SELECT folio_nota_credito AS folio,
            'Nota de Credito' AS tipo,
            fecha,
            IFNULL(observaciones,'') AS concepto,
            (total-importe_retencion) AS importe_pagado
            FROM facturas 
            WHERE id_factura_nota_credito=$idFactura AND estatus = 'T'
            UNION ALL
            SELECT pagos_e.folio AS folio,
            'Pago' AS tipo,
            DATE(pagos_e.fecha) AS fecha,
            CONCAT(conceptos_cxp.clave,'-',conceptos_cxp.descripcion) AS concepto,
            pagos_d.importe_pagado
            FROM pagos_d 
            INNER JOIN pagos_e ON pagos_d.id_pago_e=pagos_e.id
            LEFT JOIN conceptos_cxp ON pagos_e.concepto=conceptos_cxp.id AND conceptos_cxp.tipo=5
            WHERE id_factura=$idFactura AND pagos_e.estatus IN ('T','A')");

        return query2json($resultado);
    }
    

    function obtenerFolioSinFactura($idUnidadNegocio)
        {

            $result = mysqli_query($this->link, "SELECT folio_pago_sin_factura+1 as folio FROM cat_unidades_negocio WHERE id = $idUnidadNegocio");
            $row = mysqli_fetch_assoc($result);
            return $row['folio']++;
        }



    /**
      * Guardar pagos sin factura
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarPagoSinFactura($datos){ // aqui ojo
        $verifica = 0;

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $fecha = $datos['fecha'];
        $importe = $datos['importe'];
        $idCuentaBanco = $datos['idCuentaBanco'];
        $concepto = $datos['concepto'];
        $descripcion = $datos['descripcion'];

        $folio = $this ->  obtenerFolioSinFactura($idUnidadNegocio); 


        $query = "INSERT INTO pagos_sin_factura(id_unidad_negocio,id_sucursal,fecha,monto,id_cuenta_banco,concepto,descripcion,folio) 
                    VALUES ('$idUnidadNegocio','$idSucursal','$fecha','$importe','$idCuentaBanco','$concepto','$descripcion','$folio')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $id = mysqli_insert_id($this->link);

        if ($result) 
        {  
            $query = "UPDATE cat_unidades_negocio SET folio_pago_sin_factura = '$folio' WHERE id= '$idUnidadNegocio'";
            $resultF = mysqli_query($this->link, $query) or die(mysqli_error());
            
            if($resultF){

                $query="SELECT monto FROM pagos_sin_factura WHERE id=$id";
                $resultS=mysqli_query($this->link, $query);
                $numRows=mysqli_num_rows($resultS);
                if($numRows>0){

                    $datoS = mysqli_fetch_array($resultS);
                    $saldo= $datoS['monto'];

                    $arr=array(
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'importe'=>$saldo,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'categoria'=>'Pago sin factura',
                        'fechaAplicacion'=>$fecha
                    );

                    $verifica = $this -> guardarMovimientosBancos($id,$arr); 
                }
                else{
                    $verifica = 0;
                }
            }else{
                $verifica = 0;
            }
            
        }else{
            $verifica = 0;
        }
    
        return $verifica;
    }//- fin function guardarPagoSinF

    function editarCxC($datos){
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> editarIdCxC($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function guardarCxC

    /**
      * Guardo CxC los cargos y abonos a una factura
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function editarIdCxC($datos){
        $verifica = 0;


        $idCxC = $datos['idCxC'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idRazonSocialReceptor = $datos['idRazonSocialReceptor'];
        $vencimiento = $datos['vencimiento'];
        $tasaIva = $datos['tasaIva'];
        $mes = $datos['mes'];
        $anio = $datos['anio'];
        $idConcepto = $datos['idConcepto'];
        $cveConcepto = $datos['cveConcepto'];
        $fecha = $datos['fecha'];
        $importe = $datos['importe'];
        $totalIva = $datos['totalIva'];
        $total = $datos['total'];
        $referencia = $datos['referencia'];
        $idBanco = $datos['idBanco'];
        $idCuentaBanco = $datos['idCuentaBanco'];
        $idUsuario = $datos['idUsuario'];
        $estatus = isset($datos['estatus']) ? $datos['estatus'] : 'A';
        $cargoInicial = $datos['cargoInicial'];
        $idOrdenServicio = $datos['idOrdenServicio'];
        $idRazonSocialServicio = $datos['idRazonSocialServicio'];
        $facturar = isset($datos['facturar']) ? $datos['facturar'] : '0';
        $tipoCuenta = isset($datos['tipoCuenta']) ? $datos['tipoCuenta'] : '';
        //-->NJES March/18/2020 se agrega concepto cobro al generar cobro de orden servicio
        $conceptoCobro = isset($datos['conceptoCobro']) ? $datos['conceptoCobro'] : '';

        $observaciones = isset($datos['observaciones']) ? $datos['observaciones'] : '';
       

        /*$query = "INSERT INTO cxc(id_unidad_negocio,id_sucursal,folio_cxc,id_razon_social,fecha,id_concepto,cve_concepto,tasa_iva,subtotal,iva,total,referencia,mes,anio,vencimiento,cargo_inicial,id_banco,id_cuenta_banco,estatus,usuario_captura,id_orden_servicio,id_razon_social_servicio,facturar,concepto_cobro,observaciones) 
                    VALUES ('$idUnidadNegocio','$idSucursal','$idCxC','$idRazonSocialReceptor','$fecha','$idConcepto','$cveConcepto','$tasaIva','$importe','$totalIva','$total','$referencia','$mes','$anio','$vencimiento','$cargoInicial','$idBanco','$idCuentaBanco','$estatus','$idUsuario','$idOrdenServicio','$idRazonSocialServicio','$facturar','$conceptoCobro','$observaciones')";
        */
        $query = "UPDATE cxc SET fecha='$fecha',
                                id_concepto='$idConcepto',
                                cve_concepto='$cveConcepto',
                                tasa_iva='$tasaIva',
                                subtotal='$importe',
                                iva='$totalIva',
                                total='$total',
                                referencia='$referencia',
                                mes='$mes',
                                anio='$anio',
                                vencimiento='$vencimiento',
                                id_banco='$idBanco',
                                id_cuenta_banco='$idCuentaBanco',
                                estatus='$estatus',
                                usuario_captura='$idUsuario',
                                facturar='$facturar',
                                concepto_cobro='$conceptoCobro'
                            WHERE id=".$idCxC;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if ($result) 
        {  
            if($cargoInicial==1){

                $queryU = "UPDATE cxc SET folio_cxc='$idCxC' WHERE id=".$idCxC;
                $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
                $verifica = $idCxC;

            }else{

                $query="SELECT    
                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),((a.subtotal + a.iva) * -(1))),0)),0) AS saldo            
                FROM cxc a           
                WHERE a.folio_cxc=".$idCxC;
                $resultS=mysqli_query($this->link, $query);
                $numRows=mysqli_num_rows($resultS);
                if($numRows>0){

                    $datoS = mysqli_fetch_array($resultS);
                    $saldo= $datoS['saldo'];

                    $arr=array(
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'importe'=>$total,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'categoria'=>'Seguimiento a Cobranza',
                        'fechaAplicacion'=>$fecha
                    );
                  
                    if($saldo==0){

                        $queryU = "UPDATE cxc SET estatus='S' WHERE folio_cxc=".$idCxC;
                        $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
                        if($resultU){
                            if(substr($cveConcepto,0,1)=='A')
                            {
                                if($tipoCuenta == 0)
                                {
                                    $verifica = $this -> editarMovimientosBancosId($idCxC,$arr);
                                }else{
                                    $verifica = $this -> editarGastoCajaChicaId($idCxC,$arr);
                                }

                            }else
                                $verifica = $idCxC; 
                        }else{
                            $verifica = 0;
                        }

                    }else{
                        if(substr($cveConcepto,0,1)=='A')
                        {
                            if($tipoCuenta == 0)
                            {
                                $verifica = $this -> editarMovimientosBancosId($idCxC,$arr);
                            }else{
                                $verifica = $this -> editarGastoCajaChicaId($idCxC,$arr);
                            }

                        }else
                            $verifica = $idCxC;                        
                    }
                }else{
                    $verifica = $idCxC;
                }
                
            }
            
        }else{
            $verifica = 0;
        }
        
        return $verifica;
    }//- fin function guardarActualizar

    function editarMovimientosBancosId($idCxC,$datos){
        $verifica = 0;
  
        $idCuentaBanco = $datos['idCuentaBanco'];
        $idUsuario = $datos['idUsuario'];
        $importe = $datos['importe'];
        $categoria = $datos['categoria'];
        $fecha = $datos['fecha'];
        $fechaAplicacion = $datos['fechaAplicacion'];

        $busca = "SELECT id FROM movimientos_bancos WHERE id_cxc=$idCxC ORDER BY id ASC LIMIT 1";
        $result_busca=mysqli_query($this->link, $busca);
        
        $dato_busca = mysqli_fetch_array($result_busca);
        $id= $dato_busca['id'];
        
        $query = "UPDATE movimientos_bancos SET id_cuenta_banco='$idCuentaBanco',
                                                monto='$importe',
                                                tipo='A',
                                                id_usuario='$idUsuario',
                                                observaciones='$categoria',
                                                fecha_aplicacion='$fechaAplicacion'
                                            WHERE id=".$id;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
            $verifica = $idCxC;          
        else
          $verifica = 0;
        
  
        return $verifica;
    }//- fin function guardarMovimientosBancos
  
    function editarGastoCajaChicaId($idCxC,$datos){
        $verifica = 0;
  
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $importe = $datos['importe'];
        $categoria = $datos['categoria'];
        $idUsuario = $datos['idUsuario'];
        $fecha = $datos['fecha'];
        $fechaAplicacion = $datos['fechaAplicacion'];

        $busca = "SELECT id FROM caja_chica WHERE id_cxc=$idCxC ORDER BY id ASC LIMIT 1";
        $result_busca=mysqli_query($this->link, $busca);
        
        $dato_busca = mysqli_fetch_array($result_busca);
        $id= $dato_busca['id'];
  
        //--> Inserta en caja chica cargo
        $query="UPDATE caja_chica SET id_concepto=15,
                                    clave_concepto='C01',
                                    fecha='$fechaAplicacion',
                                    importe='$importe',
                                    observaciones='$categoria',
                                    estatus=1,
                                    id_usuario='$idUsuario'
                                WHERE id=".$id;
        $result=mysqli_query($this->link, $query)or die(mysqli_error());
        
        if($result)
        {
            $verifica = $idCxC;      
        }else{
            $verifica = 0;
        }
  
        return $verifica;
    }//- fin function guardarGastoCajaChica

    function buscarFacturasCXCPendientes($datos)
    {

        $idUnidadNegocio = $datos['id_unidad_negocio'];
        $idSucursal = $datos['id_sucursal'];
        $fechaInicio = $datos['fecha_de'];
        $fechaFin = $datos['fecha_a'];
        $idCliente = $datos['id_cliente'];
        $idRazonSocial = $datos['id_razon_social'];
        $nombreUnidad = $datos['nombre_unidad'];

        $condicion = '';

        if($fechaInicio == '' && $fechaFin == '')
            $condicion .= " AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        else if($fechaInicio != '' &&  $fechaFin == '')
            $condicion .= " AND a.fecha >= '$fechaInicio' ";
        else
            $condicion .= " AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";

        if($idUnidadNegocio != '' || $idUnidadNegocio != null)
            $condicion .= " AND a.id_unidad_negocio =  $idUnidadNegocio";

        if($idSucursal != '' || $idSucursal != null)
            $condicion .= " AND a.id_sucursal =  $idSucursal";

        //-->NJES March/30/2021 agregar campos y filtros
        if($idCliente != '' || $idCliente != null)
        {
            if($nombreUnidad == 'ALARMAS')
            {
                $condicion .= " AND a.id_razon_social_servicio =  $idCliente";
            }else{
                $condicion .= " AND d.id_cliente =  $idCliente";
            }
        }

        if($idRazonSocial != '' || $idRazonSocial != null)
        {
            if($nombreUnidad == 'ALARMAS')
            {
                $condicion .= " AND a.id_razon_social_servicio =  $idRazonSocial";
            }else{
                $condicion .= " AND a.id_razon_social =  $idRazonSocial";
            }
        }

        $query = "
            SELECT
            facturando.id,
            facturando.id_unidad_negocio,
            facturando.fecha, 
            facturando.id_factura,  
            facturando.id_nota_credito,
            facturando.estatus,
            facturando.cargo_inicial,
            facturando.tipo,      
            facturando.folio_cxc,           
            facturando.factura,           
            facturando.nota,            
            facturando.saldo,            
            facturando.unidad_negocio,           
            facturando.sucursal,
            facturando.razon_social,
            facturando.id_cliente,
            facturando.cliente,
            facturando.id_empresa_fiscal,
            facturando.empresa_fiscal,
            facturando.fecha_vencimiento   
            FROM
            (SELECT 
            a.id,
            a.id_unidad_negocio,
            a.fecha AS fecha, 
            a.id_factura,  
            ntc.id AS id_nota_credito,
            IFNULL(IF(a.folio_cxc > 0, a.estatus, fcfdi.estatus),'') AS estatus,
            (a.total - IFNULL(fac.importe_retencion,0) )AS cargo_inicial,
            IF(a.id_factura = 0,'CXC',IF(a.folio_factura>0,'FAC','NOT')) AS tipo,      
            IF(a.folio_cxc = 0,'',a.folio_cxc) AS folio_cxc,           
            IF(a.folio_factura = 0,'',a.folio_factura) AS factura,           
            IF(ntc.folio_nota_credito IS NULL ,'', ntc.folio_nota_credito) AS nota,            
            IF(a.id_factura = 0, IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva - IFNULL(fac.importe_retencion,0))  - (IFNULL(cxc_abonos.abono, 0))  ,((a.subtotal + a.iva - IFNULL(fac.importe_retencion,0)) * -(1))),0)),0), ( (a.total - IFNULL(fac.importe_retencion,0) ) - ( (IFNULL(ntc.abonos_notas, 0)) + (IFNULL(pagos.total_abonos, 0)) )))  AS saldo,            
            b.nombre AS unidad_negocio,           
            c.descr AS sucursal,
            IFNULL(IF(b.nombre='ALARMAS',s.razon_social,d.razon_social),'') AS razon_social,
            IF(b.nombre='ALARMAS',a.id_razon_social_servicio,d.id_cliente) AS id_cliente,
            IFNULL(IF(b.nombre='ALARMAS',s.nombre_corto,e.nombre_comercial),'') AS cliente,
            fac.id_empresa_fiscal,
            IFNULL(ef.razon_social,'') AS empresa_fiscal,
            a.vencimiento AS fecha_vencimiento  
            FROM cxc a           
            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id           
            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal   
            LEFT JOIN razones_sociales d ON a.id_razon_social=d.id 
            LEFT JOIN cat_clientes e ON d.id_cliente=e.id
            LEFT JOIN facturas fac ON a.id_factura=fac.id
            LEFT JOIN facturas_cfdi fcfdi ON fac.id = fcfdi.id_factura
            LEFT JOIN empresas_fiscales ef ON fac.id_empresa_fiscal=ef.id_empresa 
            LEFT JOIN servicios s ON a.id_razon_social_servicio=s.id

            LEFT JOIN 
            (
            SELECT folio_cxc, SUM(total) AS abono
            FROM cxc 
            WHERE SUBSTR(cve_concepto,1,1) = 'A'
            GROUP BY folio_cxc
            ) cxc_abonos ON a.folio_cxc = cxc_abonos.folio_cxc

            LEFT JOIN (
            SELECT id,id_factura_nota_credito,
            GROUP_CONCAT(folio_nota_credito)  folio_nota_credito,
            SUM(total-importe_retencion) AS abonos_notas
            FROM facturas 
            WHERE id_factura_nota_credito > 0 AND estatus = 'T'
            GROUP BY id_factura_nota_credito
            ) ntc ON a.id_factura=ntc.id_factura_nota_credito
            LEFT JOIN
            (
            SELECT SUM(importe_pagado) AS total_abonos,
            id_factura AS id_factura
            FROM 
            pagos_d
            INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
            WHERE pagos_cfdi.estatus_cfdi IN  ('T', 'A')
            GROUP BY id_factura
            ) pagos ON a.id_factura  = pagos.id_factura
            WHERE a.id_orden_servicio=0 AND a.id_venta=0 
            AND SUBSTR(a.cve_concepto, 1, 1) = 'C' AND a.estatus != 'C' 
            $condicion
            GROUP BY a.folio_cxc,a.id_factura,a.id_nota_credito
            ORDER BY a.id DESC
            ) facturando 
            WHERE facturando.saldo >= 1 AND facturando.estatus != 'C'
            ORDER BY facturando.fecha DESC
        ";

        $result = $this->link->query($query);    
        return query2json($result);

    }


}//--fin de class CxC
    
?>