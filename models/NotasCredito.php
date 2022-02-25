<?php

require_once('conectar.php');
require_once('CFDIDenken.php');

class NotasCredito
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function __construct()
    {
  
      $this->link = Conectarse();

    }
    /**Se agrega condicionAlarmas para identificar las notas de credito de alrmas que bienen de una venta orden o plan */
    function buscarNotasCredito($datos){
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $condicionAlarmas='';
        $esVentaOrdenPlan = isset($datos['esVentaOrdenPlan'])? $datos['esVentaOrdenPlan'] : 0 ;

        if($esVentaOrdenPlan > 0){

            $condicionAlarmas='AND (h.id_plan >0 OR h.id_venta>0 OR h.id_orden=0)';
        }else{

            $condicionAlarmas=' AND (h.id_plan =0 AND h.id_venta=0 AND h.id_orden=0)';
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

            $result = $this->link->query("SELECT a.id,a.id_factura_nota_credito,a.folio AS folio_factura,
                                            a.folio_nota_credito,a.observaciones AS descripcion,
                                            (a.total-a.importe_retencion) AS total,a.estatus,a.fecha,d.descr AS sucursal,
                                            e.nombre AS unidad_negocio,a.id_cliente,
                                            a.metodo_pago,a.id_unidad_negocio,
                                            IF(h.id_plan >0 OR h.id_venta>0 OR h.id_orden>0,i.razon_social,IFNULL(f.razon_social,'')) AS razon_social,
                                            CONCAT(cat_metodo_pago.clave,'-',cat_metodo_pago.descripcion) AS metodo_pago,
                                            CONCAT(cat_formas_pago.clave_concepto,'-',cat_formas_pago.descripcion) AS forma_pago
                                            FROM facturas a
                                            INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
                                            INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                                            LEFT JOIN facturas_cfdi c ON a.id=c.id_factura
                                            LEFT JOIN cat_unidades_negocio e ON a.id_unidad_negocio=e.id
                                            LEFT JOIN razones_sociales f ON a.id_razon_social = f.id
                                            LEFT JOIN facturas_d h ON a.id=h.id_factura
                                            LEFT JOIN servicios i ON a.id_razon_social = i.id
                                            LEFT JOIN cat_metodo_pago ON a.metodo_pago=cat_metodo_pago.clave
                                            LEFT JOIN cat_formas_pago ON a.forma_pago=cat_formas_pago.clave
                                            WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal AND a.id_factura_nota_credito > 0 $condicionAlarmas
                                            GROUP BY a.id
                                            ORDER BY a.fecha DESC");
        
            return query2json($result);

        }else{
                
            $arr = array();

            return json_encode($arr);
        }
    }//- fin function buscarNotasCredito

    /**
      * Guarda registros
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarNotaCredito($datos){
        $verifica = 0;
        // error_log("verificando sesion1");
        // error_log(json_encode($_SESSION));

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica === 0){
            // error_log("hizo rollback");
            // error_log("verificando sesion");
            // error_log(json_encode($_SESSION));
            $this->link->query('ROLLBACK;');
        }else{
            // error_log("hizo commit");
            // error_log("verificando sesion");
            // error_log(json_encode($_SESSION));
            $this->link->query("COMMIT;");
        }
        return $verifica;
    }
    //- fin function guardarFacturacion

    /**
      * Guarda registros
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarActualizar($datos){
        // error_log("verificando sesion2");
        // error_log(json_encode($datos));

        $verifica = 0;

        $idUsuario = $_SESSION['id_usuario'];
        $descripcion = $datos['descripcion'];
        $tasaIva = $datos['tasaIva'];
        $importe = $datos['importe'];
        $idFactura = $datos['idFactura'];
        $folioFactura = $datos['folioFactura'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idCliente = $datos['idCliente'];
        $idEmpresaFiscalEmisor = $datos['idEmpresaFiscalEmisor'];
        $idCFDIEmpresaFiscal = $datos['idCFDIEmpresaFiscal'];
        $idRazonSocialReceptor = $datos['idRazonSocialReceptor'];
        $razonSocialReceptor = $datos['razonSocialReceptor'];
        $codigoPostal = $datos['codigoPostal'];
        $rfc = $datos['rfc'];
        $idUsoCFDI = $datos['idUsoCFDI'];
        $idMetodoPago = $datos['idMetodoPago'];
        $idFormaPago = $datos['idFormaPago'];
        $fecha = $datos['fecha'];
        $diasCredito = $datos['diasCredito'];
        $digitosCuenta = $datos['digitosCuenta'];
        $mes = $datos['mes'];
        $anio = $datos['anio'];
        $fechaInicioPeriodo = $datos['fechaInicioPeriodo'];
        $fechaFinPeriodo = $datos['fechaFinPeriodo'];
        $usuario = $datos['usuario'];

        //-->NJES Feb/14/2020 Se agrega importe retención
        $retencion = isset($datos['retencion']) ? $datos['retencion'] : 0;
        $importeRetencion = isset($datos['importeRetencion']) ? $datos['importeRetencion'] : 0;
        $porcentajeRetencion = isset($datos['porcentajeRetencion']) ? $datos['porcentajeRetencion'] : 0;
        
        //$iva = ($importe*$tasaIva)/100;
        //$total = $importe+$iva;
        $iva = $datos['iva'];
        $total = $datos['total']+$importeRetencion;

        $folioNotaCredito = $this->obtenerFolio($idEmpresaFiscalEmisor, 'folio_nota_credito') + 1;

        //-->NJES Jun/08/2021 agregar moneda y tipo de cambio,
        //en guinthercorp se cuarda el quivalente en pesos y en cfdi_denken2 se guarda el monto original
        $importePesos = isset($datos['importe_pesos']) ? $datos['importe_pesos'] : $importe;
        
        $importeRetencionPesos = isset($datos['importe_retencion_pesos']) ? $datos['importe_retencion_pesos'] : $importeRetencion;
        $ivaPesos = isset($datos['iva_pesos']) ? $datos['iva_pesos'] : $iva;
        $totalP = isset($datos['total_pesos']) ? $datos['total_pesos'] : $total;
        $totalPesos = $totalP + $importeRetencionPesos;
        $moneda = isset($datos['moneda']) ? $datos['moneda'] : 'MXN';

        $monedaFactura = isset($datos['moneda_factura']) ? $datos['moneda_factura'] : 'MXN';

        //-->NJES Jun/16/2021 guardar en ginthercorp los datos de pagos en dolares,
        //para cuando es una nota de credito y la moneda de la factura es USD se debe calcular el equivalente 
        //importes en dolares y se captura el tipo_cambio
        //ESTO PARA FACILITAR EL CALCULO DE SALDO DE LA FACTURA
        $subtotalUsd = 0;
        $ivaUsd = 0;
        $importeRetencionUsd = 0;
        $totalUsd = 0;

        $tipoCambio = 1;
        $tipoCambioC=1;
        if($moneda != 'MXN')
        {
            $tipoCambio = isset($datos['tipo_cambio']) ? $datos['tipo_cambio'] : 1;
            $tipoCambioC = $tipoCambio;
            $subtotalUsd = $importe;
            $ivaUsd = $iva;
            $importeRetencionUsd = $importeRetencion;
            $totalUsd = $total;
        }

        if($moneda == 'MXN' && $monedaFactura != 'MXN')
        {
            $tipoCambioC = isset($datos['tipo_cambio']) ? $datos['tipo_cambio'] : 1;
            $subtotalUsd = $this->num_2dec($importePesos/$tipoCambioC);
            $ivaUsd = $this->num_2dec($ivaPesos/$tipoCambioC);
            $importeRetencionUsd = $this->num_2dec($importeRetencionPesos/$tipoCambioC);
            $totalUsd = (floatval($subtotalUsd)+floatval($ivaUsd))+floatval($importeRetencionUsd);
        }

        //--> se guarda el folio nota credito en el folio cuando es nota de credito para no modificar el xml que se genera,
        // ya que obtenemos el campo folio para generarlo
        $query = "INSERT INTO facturas(id_factura_nota_credito,id_unidad_negocio,id_sucursal,folio,
                folio_nota_credito,id_empresa_fiscal, id_razon_social,id_cliente,uso_cfdi,metodo_pago,
                forma_pago,digitos_cuenta,subtotal,iva,total,fecha,anio,mes,observaciones,dias_credito,
                porcentaje_iva,fecha_inicio,fecha_fin,rfc_razon_social,razon_social,retencion,importe_retencion,
                moneda,tipo_cambio,subtotal_usd,iva_usd,importe_retencion_usd,total_usd, id_capturo) 
                VALUES ('$idFactura','$idUnidadNegocio','$idSucursal','$folioNotaCredito','$folioNotaCredito',
                '$idEmpresaFiscalEmisor','$idRazonSocialReceptor','$idCliente','$idUsoCFDI','$idMetodoPago',
                '$idFormaPago','$digitosCuenta','$importePesos','$ivaPesos','$totalPesos','$fecha','$anio','$mes','$descripcion',
                '$diasCredito','$tasaIva','$fechaInicioPeriodo','$fechaFinPeriodo','$rfc','$razonSocialReceptor',
                '$retencion','$importeRetencionPesos',
                '$moneda','$tipoCambioC','$subtotalUsd','$ivaUsd','$importeRetencionUsd','$totalUsd', $idUsuario)";
        
        // error_log("primer insert");
        // error_log($query);
        // error_log("verificando sesion4");
        // error_log(json_encode($_SESSION));

        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idNotaCredito = mysqli_insert_id($this->link);

        //en cfdi_denken2 se guarda el importe capturado
        $facturaE = array('folio'=>$folioNotaCredito,
                          'folioNotaCredito'=>$folioNotaCredito,
                          'fecha'=>$fecha,
                          'subtotal'=>$importe,
                          'iva'=>$iva,
                          'idMetodoPago'=>$idMetodoPago,
                          'idFormaPago'=>$idFormaPago,
                          'idUsoCFDI'=>$idUsoCFDI,
                          'rfc'=>$rfc,
                          'razonSocialReceptor'=>$razonSocialReceptor,
                          'codigoPostal'=>$codigoPostal,
                          'empresaFiscal'=>$idCFDIEmpresaFiscal,
                          'usuario'=>$usuario,
                          'tasaIva'=>$tasaIva,
                          'tipo'=>'notaC',
                          'tipo_cfd'=>'E',
                          'retencion'=>$retencion,
                          'importeRetencion'=>$importeRetencion,
                          'porcentajeRetencion'=>$porcentajeRetencion,
                          'moneda'=>$moneda,
                          'tipo_cambio'=>$tipoCambio,
                          'idFactura'=>$idFactura
                        );

        if ($result) 
        {
            //importe es el importe capturado e importe pesos el equivalente a pesos
            $verifica = $this->guardarPartidas($idNotaCredito,$importe,$importePesos,$descripcion,$facturaE,$idEmpresaFiscalEmisor,$folioNotaCredito); 
        }

        return $verifica;
    }//- fin function guardarFacturacion

    function buscarNotasCreditoidFactura($idFactura){
        /*$result = $this->link->query("SELECT id,folio_nota_credito,observaciones AS descripcion,
                                        total AS total,subtotal,iva,importe_retencion,estatus,id_factura_cfdi,
                                        CONCAT(cat_metodo_pago.clave,'-',cat_metodo_pago.descripcion) AS metodo_pago,
                                        CONCAT(cat_formas_pago.clave_concepto,'-',cat_formas_pago.descripcion) AS forma_pago
                                        FROM facturas 
                                        LEFT JOIN cat_metodo_pago ON facturas.metodo_pago=cat_metodo_pago.clave
                                        LEFT JOIN cat_formas_pago ON facturas.forma_pago=cat_formas_pago.clave 
                                        WHERE facturas.id_factura_nota_credito=$idFactura
                                        ORDER BY facturas.id ASC");

        return query2json($result);*/
        //-->NJES Jun/08/2021 mostrar los importes originales para en caso de moneda USD
        $result = mysqli_query($this->link,"SELECT id,folio_nota_credito,observaciones AS descripcion,
            (total-importe_retencion) AS total,subtotal,iva,importe_retencion,estatus,id_factura_cfdi,
            CONCAT(cat_metodo_pago.clave,'-',cat_metodo_pago.descripcion) AS metodo_pago,
            CONCAT(cat_formas_pago.clave_concepto,'-',cat_formas_pago.descripcion) AS forma_pago
            FROM facturas 
            LEFT JOIN cat_metodo_pago ON facturas.metodo_pago=cat_metodo_pago.clave
            LEFT JOIN cat_formas_pago ON facturas.forma_pago=cat_formas_pago.clave 
            WHERE facturas.id_factura_nota_credito=$idFactura
            ORDER BY facturas.id ASC");

        $array = array();

        while($row = mysqli_fetch_assoc($result))
        {
            $id = $row['id'];
            $folioNotaCredito = $row['folio_nota_credito'];
            $descripcion = $row['descripcion'];
            $total = $row['total'];
            $subtotal = $row['subtotal'];
            $iva = $row['iva'];
            $importeRetencion = $row['importe_retencion'];
            $estatus = $row['estatus'];
            $idFacturaCFDI = $row['id_factura_cfdi'];
            $metodoPago = $row['metodo_pago'];
            $formaPago = $row['forma_pago'];

            $cfdiDenken = new CFDIDenken();
            $rowB = $cfdiDenken -> obtenerDatosFacturaE($idFacturaCFDI);

            $subtotalOriginal = $rowB['subtotal']; 
            $ivaOriginal = $rowB['iva']; 
            $moneda = $rowB['moneda'];  
            $tipoCambio = $rowB['tcambio'];  
            $importeRetencionOriginal = $rowB['importe_retencion']; 

            $array[] = array('id'=>$id,'folio_nota_credito'=>$folioNotaCredito,'descripcion'=>$descripcion,
                            'total'=>$total,'subtotal'=>$subtotal,'iva'=>$iva,'importe_retencion'=>$importeRetencion,
                            'estatus'=>$estatus,'id_factura_cfdi'=>$idFacturaCFDI,'metodo_pago'=>$metodoPago,
                            'forma_pago'=>$formaPago,'subtotal_original'=>$subtotalOriginal,
                            'iva_original'=>$ivaOriginal,'moneda'=>$moneda,
                            'tipo_cambio'=>$tipoCambio,'importe_retencion_original'=>$importeRetencionOriginal);
        }

        return json_encode($array);
    }//- fin function buscarNotasCreditoidFactura

    /**
      * Obtiene el folio actual de la empresa fiscal
      *
      * @param int $idEmpresaFiscal
      *
    **/ 
    function obtenerFolio($idEmpresaFiscal, $tipo)
    {
        // error_log("verificando sesion3");
        // error_log(json_encode($_SESSION));

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

        $query = "UPDATE empresas_fiscales
                    SET $tipo = $folio
                    WHERE id_empresa = $idEmpresaFiscal";
        // error_log("segundo update");
        // error_log($query);
        // error_log("verificando sesion9");
        // error_log(json_encode($_SESSION));

        $result = mysqli_query($this->link, $query);
    }

    /**
        * Guarda las partidas de la factura
        *
        * @param int $idFactura
        * @param varchar $partidas  array que contiene los datos
        *
    **/
    function guardarPartidas($idNotaCredito,$importe,$importePesos,$descripcion,$facturaE, $idEmpresaFiscalEmisor, $folioNotaCredito){
        $verifica = 0;

        $facturaD = array();

        $idClaveSATProducto = 84111506;
        $idClaveSATUnidad = 'ACT';
        $nombreUnidadSAT = 'ACTIVIDAD';
        $nombreProductoSAT = 'Servicios de facturación';
        $cantidad = 1;
        $precio = $importePesos;
        $descripcion = $descripcion;

        $query = "INSERT INTO facturas_d(id_factura,cantidad,precio_unitario,importe,descripcion,
            clave_unidad_sat,unidad_sat,clave_producto_sat,producto_sat) 
            VALUES ('$idNotaCredito','$cantidad','$precio','$importePesos','$descripcion','$idClaveSATUnidad',
            '$nombreUnidadSAT','$idClaveSATProducto','$nombreProductoSAT')";

        // echo $query;
        // exit();
        // error_log("segundo insert");
        // error_log($query);
        // error_log("verificando sesion5");
        // error_log(json_encode($_SESSION));

        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        //->le voy agregando al array los registros
        //en cfdi_denken2 se guarda el importe capturado
        array_push($facturaD,['concepto'=>$descripcion,
                        'precioUnitario'=>$importe,
                        'cantidad'=>$cantidad,
                        'claveProducto'=>$idClaveSATProducto,
                        'claveUnidad'=>$idClaveSATUnidad,
                        'unidad'=>$nombreUnidadSAT]);

        if($result) 
        {
            $cfdiDenke = new CFDIDenken();  //--> hago una instancia de la otra clase para poder usar las funciones de la otra en esta
            
            $idCFDI = $cfdiDenke->guardaFactura($facturaE,$facturaD); 
            $verifica = $this->actualizaCFDINotaCredito($idNotaCredito,$idCFDI);
            $this->actualizarFolio($idEmpresaFiscalEmisor, $folioNotaCredito, 'folio_nota_credito');
        }else{
            $verifica = 0;
        }

        return $verifica;
    }//- fin function guardarPartidas

    function actualizaCFDINotaCredito($idFactura,$idCFDI){
        $verifica = 0;

        $query = "UPDATE facturas SET id_factura_cfdi ='$idCFDI' WHERE id=".$idFactura;
        // echo $query;
        // exit();
        // error_log("primer update");
        // error_log($query);
        // error_log("verificando sesion8");
        // error_log(json_encode($_SESSION));

        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
            $verifica = json_encode(array('idFactura'=>$idFactura,'idCFDI'=>$idCFDI));

        return $verifica;
    }//- fin function actualizaCFDINotaCredito

    function eliminarNotaCredito($id){
        $verifica = 0;

        $query = "DELETE FROM facturas WHERE id=".$id;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
        {
            $query2 = "DELETE FROM facturas_d WHERE id_factura=".$id;
            $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

            if($result2)
                $verifica = 1;
            else   
                $verifica = 0;

        }else
            $verifica = 0;
        

        return $verifica;
    }//- fin function eliminarNotaCredito

    function num_2dec($numero)
	{
		return number_format($numero, 2, '.', '');
	}
    
}//--fin de class NotasCredito
    
?>