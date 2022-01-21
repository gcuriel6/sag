<?php

require_once('conectar.php');
require_once('CFDIDenken.php');

class FacturacionAlarmas
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function FacturacionAlarmas()
    {
  
      $this->link = Conectarse();

    }

    function buscarFacturas($datos){
      $idUnidadNegocio = $datos['idUnidadNegocio'];
      $idSucursal = $datos['idSucursal'];
      $fechaInicio = $datos['fechaInicio'];
      $fechaFin = $datos['fechaFin'];
      $tipoBusqueda = $datos['tipoBusqueda'];

      $condicionFacturas='';

      if($tipoBusqueda=='V'){

        $condicionFacturas='AND (g.id_venta > 0 OR g.id_orden > 0 OR a.es_plan > 0 OR a.es_venta_orden > 0)';

      }else{
           
        $condicionFacturas='AND (g.id_plan > 0 OR a.es_plan > 0)';
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
                    a.razon_social,a.rfc_razon_social,a.fecha,a.estatus,d.descr AS sucursal,a.id_cliente,
                    a.metodo_pago,a.id_unidad_negocio,a.id_cxc,
                    
                    IF(TRIM(a.rfc_razon_social) = 'XAXX010101000' , 'PUBLICO EN GENERAL' , IFNULL(e.nombre_corto,'') ) as nombre_corto,
                    IF(TRIM(a.rfc_razon_social) = 'XAXX010101000' , '' , IFNULL(e.cuenta,'') ) as cuenta,
                    IFNULL(f.fecha_corte_recibo,'') AS fecha_inicio,
                    IFNULL(f.vencimiento,'') AS fecha_fin,
                    IFNULL(g.id_plan,0) AS id_plan
                    FROM facturas a
                    LEFT JOIN facturas_d g ON a.id=g.id_factura
                    INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
                    INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                    LEFT JOIN facturas_cfdi c ON a.id=c.id_factura
                    LEFT JOIN cxc f ON g.id_cxc=f.id AND a.id_razon_social=f.id_razon_social_servicio
                    LEFT JOIN servicios e ON a.id_razon_social=e.id
                    WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $fecha AND a.id_factura_nota_credito=0 $condicionFacturas
                    GROUP BY a.id
                    ORDER BY a.fecha DESC";

        //   echo $query;
        //   exit();

          //-->NJES Feb/10/2020 Se muestra el nombre corto en las busquedas y cuenta
          $result = $this->link->query($query);
      
          return query2json($result);

      }else{
              
          $arr = array();

          return json_encode($arr);
      }
  }//- fin function buscarFacturas

 
    function buscarFacturasIdAlarmas($idFactura){
        //-->NJES Feb/20/2020
        $result = $this->link->query("SELECT a.id, a.id_factura_cfdi, a.id_unidad_negocio,a.id_sucursal,a.folio,a.id_empresa_fiscal,
                                        a.id_razon_social,a.razon_social,a.rfc_razon_social,a.id_cliente,
                                        a.uso_cfdi,a.metodo_pago,a.forma_pago,IFNULL(c.correos,'') AS email, a.digitos_cuenta,
                                        a.fecha,a.anio,a.mes,a.observaciones,a.dias_credito,a.porcentaje_iva,
                                        a.subtotal,a.iva,a.total,a.id_factura_cfdi,a.fecha_inicio,a.fecha_fin,
                                        a.lleva_descripcion_alterna,a.descripcion_alterna,a.clave_unidad_sat,a.unidad_sat,a.clave_producto_sat,a.producto_sat,
                                        a.estatus,b.razon_social AS empresa_fiscal, b.id_cfdi AS id_cfdi , c.razon_social AS cliente,
                                        IFNULL(d.uuid_timbre,'') AS folio_fiscal,IFNULL(GROUP_CONCAT(f.uuid_timbre),'') AS facturas_relacionadas,
                                        COUNT(g.id_factura_nota_credito) AS num_notas_credito,
                                        b.id_empresa as id_empresa_fiscal,
                                        b.razon_social AS empresa_fiscal,
                                        b.id_cfdi as id_cfdi_fiscal,
                                        h.id AS idcxc,
                                        a.descuento,
                                        a.id_razon_social AS id_servicio,
                                        IFNULL(c.codigo_postal,'') AS codigo_postal,
                                        (SELECT COUNT(folio_cxc) FROM cxc WHERE folio_cxc=h.id AND estatus !='C') AS registros,
                                        a.cliente_alterno
                                        FROM facturas a
                                        INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
                                        LEFT JOIN servicios c ON a.id_razon_social=c.id
                                        LEFT JOIN facturas_cfdi d ON a.id=d.id_factura
                                        LEFT JOIN facturas_r e ON a.id=e.id_factura
                                        LEFT JOIN facturas_cfdi f ON e.id_factura_sustituida=f.id_factura
                                        LEFT JOIN facturas g ON a.id=g.id_factura_nota_credito AND g.estatus!='C'
                                        LEFT JOIN cxc h ON a.id=h.id_factura AND h.cargo_inicial=1 
                                        WHERE a.id=".$idFactura);
        
        return query2json($result);
    }//- fin function buscarFacturasId

    function buscarFacturasAlarmasDetalleId($idFactura){
        $query = "SELECT a.id,a.cantidad,a.precio_unitario,b.porcentaje_iva,a.importe AS importe_o,
                ((a.importe*b.porcentaje_iva)/100) AS iva,
                IF(b.retencion=1,(((a.importe*b.porcentaje_iva)/100)+a.importe)-((a.importe*6)/100),(((a.importe*b.porcentaje_iva)/100)+a.importe)) AS importe,
                IF(b.retencion=1,(a.importe*6)/100,0) AS retencion,
                a.descripcion,a.clave_unidad_sat,a.unidad_sat,
                a.clave_producto_sat,a.producto_sat,
                a.id_cxc,a.id_venta,a.id_orden,a.id_plan,IF(IFNULL(a.id_servicio,0)>0,a.id_servicio,b.id_razon_social) AS id_servicio,
                a.porcentaje_descuento,a.monto_descuento
                FROM facturas_d a
                INNER JOIN facturas b ON a.id_factura=b.id 
                WHERE a.id_factura=$idFactura
                ORDER BY a.id ASC";

        // echo $query;
        // exit();

        //-->NJES Feb/20/2020 se obtiene el descuento porque en ventas alarmas pueden traer descuento y se prorratea para las partidas al guardar prefactura
        $result = $this->link->query($query);
        
        return query2json($result);
    }//- fin function buscarFacturasDetalleId

    function buscarFacturasCanceladas($datos){

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idCliente = $datos['idCliente'];
        $idEmpresaFiscal = $datos['idEmpresaFiscal'];
        $idRazonSocial = $datos['idRazonSocial'];

        $result = $this->link->query("SELECT a.id,a.folio,a.id_factura_cfdi,IFNULL(d.uuid_timbre,'') AS folio_fiscal,a.total,a.fecha, 
        a.razon_social AS razon_social_receptor,a.rfc_razon_social AS rfc_receptor,
        b.razon_social AS empresa_fiscal_emisor,b.rfc AS rfc_emisor,r.razon_social AS cliente_receptor
        FROM facturas a
        INNER JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
        INNER JOIN servicios r ON a.id_razon_social = r.id
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
        AND a.id_cliente=$idCliente AND a.id_empresa_fiscal=$idEmpresaFiscal 
        AND a.id_razon_social=$idRazonSocial AND a.estatus='C' AND LENGTH(d.uuid_timbre) > 0");

        //--AND  a.es_venta_orden > 0 
        
        return query2json($result);
    }

    function buscaIdCxCIdServicio($idFactura){

        $result = $this->link->query("SELECT 
        a.id,
        a.id_cxc AS id_cxc,
        IF(IFNULL(a.id_servicio,0)>0,a.id_servicio,b.id_razon_social) AS id_servicio
        FROM facturas_d a
        INNER JOIN facturas b ON a.id_factura=b.id 
        WHERE a.id_factura=$idFactura
        ORDER BY a.id ASC");
        
        return query2json($result);
    }//- fin function buscaIdCxCIdServicio

}//--fin de class Facturacion
    
?>