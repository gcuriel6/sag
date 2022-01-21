<?php

require_once('conectar.php');

class ReportesAlarmas
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function ReportesAlarmas()
    {
  
      $this->link = Conectarse();

    }

    function buscarReporte($datos){
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $reporte = $datos['reporte'];
        $idSucursal = $datos['idSucursal'];

        if($reporte == 'cotizaciones_ventas')
        {
            if($fechaInicio == '' && $fechaFin == '')
                $condFecha = " AND DATE(a.fecha_captura) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            else if($fechaInicio != '' &&  $fechaFin == '')
                $condFecha = " AND DATE(a.fecha_captura) >= '$fechaInicio' ";
            else
                $condFecha = " AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin'";

            if($idSucursal != '')  //-->No tengo sucursales con permisos en la unidad entonces debo regresar un array vacio
            {
                if($idSucursal[0] == ',')
                {
                    $dato=substr($idSucursal,1);
                    $condSucursal = ' AND a.id_sucursal IN('.$dato.') ';
                }else{ 
                    $condSucursal = ' AND a.id_sucursal ='.$idSucursal;
                }
            }
            
            $query = "SELECT a.folio,
                        DATE(a.fecha_captura) AS fecha_captura,
                        IF(a.cotizacion=1,'Cotización','Venta') AS movimiento,
                        IF(a.tipo_cotizacion>0,IF(a.tipo_cotizacion=1,'Alarma',IF(a.tipo_cotizacion=2,'Servicio de Monitoreo','Mixta')),'') AS tipo_cotizacion,
                        IFNULL(b.folio,'') AS folio_cotizacion,
                        TRIM(IF(a.id_cliente=0,a.cliente_cotizacion,c.nombre_corto)) AS cliente,
                        -- IF(a.estatus='C','Cancelada',IF(a.cotizacion=1,'Seguimiento','Autorizada')) AS estatus,
                        IF(a.estatus='C','Cancelada',IF(a.cotizacion=0,'Activo', (IF(f.id > 0, 'Autorizada', 'Seguimiento') ))) AS estatus,
                        d.usuario AS usuario_captura,
                        a.descuento,
                        a.costo_instalacion,
                        a.costo_administrativo,
                        a.comision_venta,
                        a.subtotal AS precio_venta,
                        a.total AS importe_cotizado,
                        IFNULL(a.vendedor, '')  as vendedor,
                        SUM(IFNULL(f.ultimo_precio_compra * e.cantidad,0.00)) AS precio_ultima_compra,
                        IFNULL(f.id, 0) AS id_venta,
                        s.descr AS sucursal
                        FROM notas_e a
                        LEFT JOIN sucursales s ON a.id_sucursal=s.id_sucursal
                        LEFT JOIN servicios c ON a.id_cliente=c.id
                        LEFT JOIN notas_e b ON a.id_cotizacion=b.id
                        LEFT JOIN notas_e f ON a.id=f.id_cotizacion
                        LEFT JOIN usuarios d ON a.id_usuario_captura=d.id_usuario
                        LEFT JOIN notas_d e ON a.id=e.id_nota_e
                        LEFT JOIN (
                            SELECT id_producto,MAX(ultima_fecha_compra),ultimo_precio_compra
                            FROM productos_unidades 
                            WHERE id_unidades=2 GROUP BY id_producto ORDER BY ultima_fecha_compra DESC
                        ) AS f ON e.id_producto=f.id_producto
                        WHERE 1=1 $condSucursal $condFecha
                        GROUP BY a.id
                        ORDER BY a.fecha_captura ASC";
        }
        
        $result = $this->link->query($query);

        return query2json($result);
    }//- fin function buscarCobranza

    
}//--fin de class Cobranza
    
?>