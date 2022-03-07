<?php

require_once('conectar.php');
require_once('MovimientosPresupuesto.php');

class CxpPagos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function CxpPagos()
    {
  
      $this->link = Conectarse();

    }

    function buscarCxPPagos($ordenar,$tipo){
      $query = "";

      if($ordenar == 0)
      {
          $condicion = ' ORDER BY proveedor ASC,fecha ASC';
      }else{
          $condicion = ' ORDER BY fecha ASC';
      }

      if($tipo == 1) //ordenes de compra
      {
        $query = "SELECT 'cxp_oc' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          h.clave AS clave_sucursal,
                          1 AS b_provedor,
                          0 AS b_empleado,
                          a.id,
                          0 AS id_viatico,
                          a.no_factura AS factura,
                          a.id_proveedor AS id_proveedor,
                  b.nombre AS proveedor,
                  (SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')) AS importe,
                  -- a.fecha AS fecha_creacion,
                  IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                  DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                  CASE 
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                  ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                  END) AS fecha,
                  CONCAT('OC-',e.folio,' RE-(',e.requisiciones,')') AS referencia,e.id AS id_oc,
                  IFNULL(b.cuenta,'') AS cuenta_clabe,IFNULL(c.clave,'') AS banco,a.id_entrada_compra AS idE01,
                  1 AS vencidos
                  FROM cxp a
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN proveedores b ON a.id_proveedor=b.id
                  LEFT JOIN bancos c ON b.id_banco=c.id
                  LEFT JOIN almacen_e d ON d.id=a.id_entrada_compra
                  LEFT JOIN orden_compra e ON e.id=d.id_oc 
                  LEFT JOIN requisiciones g ON e.ids_requisiciones=g.id
                  LEFT JOIN sucursales h ON h.id_sucursal = a.id_sucursal
                  WHERE a.id_entrada_compra > 0 AND a.id_viatico = 0 AND id_requisicion=0 AND a.estatus IN('P','A') AND g.tipo!=4
                  AND 
                  -- a.fecha
                  IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                  DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                  CASE 
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                  ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                  END)  <= CURDATE()
                  HAVING importe > 0
                  UNION ALL
                  SELECT 'cxp_oc' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          h.clave AS clave_sucursal,
                          1 AS b_provedor,
                          0 AS b_empleado,
                          a.id,
                          0 AS id_viatico,
                          a.no_factura AS factura,
                          a.id_proveedor AS id_proveedor,
                  b.nombre AS proveedor,
                  (SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva -descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')) AS importe,
                  IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                  DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                  CASE 
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                  ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                  END) AS fecha,
                  CONCAT('OC-',e.folio,' RE-(',e.requisiciones,')') AS referencia,e.id AS id_oc,
                  IFNULL(b.cuenta,'') AS cuenta_clabe,c.clave AS banco,a.id_entrada_compra AS idE01,
                  0 AS vencidos
                  FROM cxp a
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN proveedores b ON a.id_proveedor=b.id
                  LEFT JOIN bancos c ON b.id_banco=c.id
                  LEFT JOIN almacen_e d ON d.id=a.id_entrada_compra
                  LEFT JOIN orden_compra e ON e.id=d.id_oc 
                  LEFT JOIN requisiciones g ON e.ids_requisiciones=g.id
                  LEFT JOIN sucursales h ON h.id_sucursal = a.id_sucursal 
                  WHERE a.id_entrada_compra > 0 AND a.id_viatico = 0 AND id_requisicion=0 AND a.estatus IN('P','A') AND g.tipo!=4
                  AND
                  IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                  DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                  CASE 
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                  ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                  END)  BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 365 DAY)
                  HAVING importe > 0 
                  $condicion";

                  // verificando condiciones
      }else if($tipo == 2) //deudores diversos
      {
        $query = "SELECT 'gasto' AS tipo,f.clave AS clave_unidad_negocio,0 AS b_provedor,1 AS b_empleado,a.id,0 AS id_viatico,a.referencia AS factura,a.id_trabajador AS id_proveedor,
                  IF(a.id_trabajador=0,a.nombre,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS proveedor,
                  (a.subtotal+a.iva) AS importe,a.fecha,CONCAT('DD-',a.referencia) AS referencia,0 AS id_oc,
                  '' AS cuenta_clabe,'' AS banco,0 AS idE01,
                  1 AS vencidos
                  FROM gastos a
                  LEFT JOIN trabajadores b ON a.id_trabajador=b.id_trabajador
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  WHERE a.tipo_deudor=1 AND a.comprobado=0 AND a.estatus=1 AND a.fecha <= CURDATE()
                  HAVING importe > 0
                  UNION ALL
                  SELECT 'gasto' AS tipo,f.clave AS clave_unidad_negocio,1 AS b_provedor,0 AS b_empleado,a.id,0 AS id_viatico,a.referencia AS factura,a.id_trabajador AS id_proveedor,
                  IF(a.id_trabajador=0,a.nombre,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS proveedor,
                  (a.subtotal+a.iva) AS importe,a.fecha, CONCAT('DD-',a.referencia) AS referencia,0 AS id_oc,
                  '' AS cuenta_clabe,'' AS banco, 0 AS idE01,
                  0 AS vencidos
                  FROM gastos a
                  LEFT JOIN trabajadores b ON a.id_trabajador=b.id_trabajador
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  WHERE a.tipo_deudor=1 AND a.comprobado=0 AND a.estatus=1 
                  AND a.fecha BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 365 DAY)
                  HAVING importe > 0
                  $condicion";
      }else if($tipo == 3) //viaticos
      {
        $query = "SELECT 'viatico' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          g.clave AS clave_sucursal,
                          0 AS b_provedor,
                          1 AS b_empleado,
                          a.id,
                          a.id AS id_viatico,
                          a.folio AS factura,
                          a.id_empleado AS id_proveedor,
                        IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS proveedor,
                        a.total AS importe, DATE(a.fecha_captura) AS fecha, CONCAT('VIA-',a.folio) AS referencia,IFNULL(c.id,0)AS deudor_diverso,
                        '' AS cuenta_clabe,'' AS banco,0 AS idE01,
                        1 AS vencidos
                  FROM viaticos a
                  LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                  LEFT JOIN deudores_diversos c ON c.id_viatico=a.id 
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN sucursales g ON a.id_sucursal = g.id_sucursal
                  WHERE a.reposicion_gasto=0 AND a.estatus='S' AND a.impresa=1 AND a.autorizo!='' 
                  -- AND DATE(a.fecha_captura) BETWEEN  ADDDATE(CURDATE(), INTERVAL -30 DAY) AND CURDATE()
                  HAVING importe > 0 AND deudor_diverso=0
                  UNION ALL
                  SELECT 'cxp_viatico' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          g.clave AS clave_sucursal,
                          0 AS b_provedor,
                          1 AS b_empleado,
                          a.id,
                          a.id_viatico AS id_viatico,
                          a.no_factura AS factura,
                          a.id_empleado AS id_proveedor,
                          IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS proveedor,
                          (a.subtotal+a.iva-a.descuento) AS importe,a.fecha,CONCAT('VIA-',a.no_factura) AS referencia,0 AS id_oc,
                          '' AS cuenta_clabe,'' AS banco,0 AS idE01,
                          1 AS vencidos
                  FROM cxp a
                  LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN sucursales g ON a.id_sucursal = g.id_sucursal
                  WHERE a.id_viatico > 0 AND a.estatus IN('A','P') AND a.fecha <= CURDATE()
                  HAVING importe > 0
                  UNION ALL
                  SELECT 'viatico' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          g.clave AS clave_sucursal,
                          0 AS b_provedor,
                          1 AS b_empleado,
                          a.id,
                          a.id AS id_viatico,
                          a.folio AS factura,
                          a.id_empleado AS id_proveedor,
                  IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS proveedor,
                  a.total AS importe, DATE(a.fecha_captura) AS fecha, CONCAT('VIA-',a.folio) AS referencia,IFNULL(c.id,0)AS deudor_diverso,
                  '' AS cuenta_clabe,'' AS banco, 0 AS idE01,
                  0 AS vencidos
                  FROM viaticos a
                  LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                  LEFT JOIN deudores_diversos c ON c.id_viatico=a.id 
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN sucursales g ON a.id_sucursal = g.id_sucursal
                  WHERE a.reposicion_gasto=0 AND a.estatus='S' AND a.impresa=1 AND a.autorizo!='' 
                  AND DATE(a.fecha_captura) BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 365 DAY)
                  HAVING importe > 0 AND deudor_diverso=0
                  UNION ALL
                  SELECT 'cxp_viatico' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          g.clave AS clave_sucursal,
                          0 AS b_provedor,
                          1 AS b_empleado,
                          a.id,
                          a.id_viatico AS id_viatico,
                          a.no_factura AS factura,
                          a.id_empleado AS id_proveedor,
                  IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS proveedor,
                  (a.subtotal+a.iva-a.descuento) AS importe,a.fecha,CONCAT('VIA-',a.no_factura) AS referencia,0 AS id_oc,
                  '' AS cuenta_clabe,'' AS banco, 0 AS idE01,
                  0 AS vencidos
                  FROM cxp a
                  LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN sucursales g ON a.id_sucursal = g.id_sucursal
                  WHERE a.id_viatico > 0 AND a.estatus IN ('P','A')
                  AND a.fecha BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 365 DAY)
                  HAVING importe > 0
                  $condicion";
      }else if($tipo == 4) //anticipos
      {
        $query = "SELECT 'cxp_ar' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          g.clave AS clave_sucursal,
                          1 AS b_provedor,0 AS b_empleado,a.id,0 AS id_viatico,CONCAT(a.id,'',a.id_requisicion) AS factura, a.id_proveedor AS id_proveedor,
                  b.nombre AS proveedor,
                  (SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')) AS importe,
                  a.fecha,
                  CONCAT('AR-',d.folio) AS referencia,0 AS id_oc,
                  IFNULL(b.cuenta,'') AS cuenta_clabe,IFNULL(c.clave,'') AS banco,IFNULL(a.id_entrada_compra,0) AS idE01,
                  1 AS vencidos
                  FROM cxp a
                  LEFT JOIN proveedores b ON a.id_proveedor=b.id
                  LEFT JOIN bancos c ON b.id_banco=c.id
                  LEFT JOIN requisiciones d ON a.id_requisicion=d.id
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN sucursales g ON g.id_sucursal = a.id_sucursal
                  WHERE a.id_requisicion > 0 AND a.id_viatico = 0 AND a.estatus IN('P','A') 
                  AND  a.fecha  <= CURDATE()
                  HAVING importe > 0
                  UNION ALL
                  SELECT 'cxp_ar' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          g.clave AS clave_sucursal,
                          1 AS b_provedor,0 AS b_empleado,a.id,0 AS id_viatico,CONCAT(a.id,'',a.id_requisicion) AS factura, a.id_proveedor AS id_proveedor,
                  b.nombre AS proveedor,
                  (SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva -descuento),((subtotal + iva- descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')) AS importe,
                  a.fecha,
                  CONCAT('AR-',d.folio) AS referencia,0 AS id_oc,
                  IFNULL(b.cuenta,'') AS cuenta_clabe,IFNULL(c.clave,'') AS banco,IFNULL(a.id_entrada_compra,0) AS idE01,
                  0 AS vencidos
                  FROM cxp a
                  LEFT JOIN proveedores b ON a.id_proveedor=b.id
                  LEFT JOIN bancos c ON b.id_banco=c.id
                  LEFT JOIN requisiciones d ON a.id_requisicion=d.id
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN sucursales g ON g.id_sucursal = a.id_sucursal
                  WHERE a.id_requisicion > 0 AND a.id_viatico = 0 AND a.estatus IN('P','A') 
                  AND a.fecha BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 365 DAY)
                  HAVING importe > 0
                  $condicion";

        //-->NJES April/24/2020 concatenar el folio de la requi haciendo un left join porque antes no se guardaba el folio, sino el id
      }else{
        $query = "SELECT 'cxp_os' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          h.clave AS clave_sucursal,
                          1 AS b_provedor,
                          0 AS b_empleado,a.id,0 AS id_viatico,a.no_factura AS factura, a.id_proveedor AS id_proveedor,
                  b.nombre AS proveedor,
                  (SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')) AS importe,
                  -- a.fecha AS fecha_creacion,
                  IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                  DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                  CASE 
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                  ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                  END) AS fecha,
                  CONCAT('OS-',e.folio,' RE-(',e.requisiciones,')') AS referencia,e.id AS id_oc,
                  IFNULL(b.cuenta,'') AS cuenta_clabe,IFNULL(c.clave,'') AS banco,a.id_entrada_compra AS idE01,
                  1 AS vencidos
                  FROM cxp a
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN proveedores b ON a.id_proveedor=b.id
                  LEFT JOIN bancos c ON b.id_banco=c.id
                  LEFT JOIN almacen_e d ON d.id=a.id_entrada_compra
                  LEFT JOIN orden_compra e ON e.id=d.id_oc 
                  LEFT JOIN requisiciones g ON e.ids_requisiciones=g.id
                  LEFT JOIN sucursales h ON h.id_sucursal = a.id_sucursal
                  WHERE a.id_entrada_compra > 0 AND a.id_viatico = 0 AND id_requisicion=0 AND a.estatus IN('P','A') AND g.tipo=4
                  AND 
                  -- a.fecha
                  IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                  DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                  CASE 
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                  ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                  END)  <= CURDATE()
                  GROUP BY a.id
                  HAVING importe > 0
                  UNION ALL
                  SELECT 'cxp_os' AS tipo,
                          f.clave AS clave_unidad_negocio,
                          h.clave AS clave_sucursal,
                          1 AS b_provedor,0 AS b_empleado,a.id,0 AS id_viatico,a.no_factura AS factura, a.id_proveedor AS id_proveedor,
                  b.nombre AS proveedor,
                  (SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva -descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')) AS importe,
                  IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                  DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                  CASE 
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                  ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                  END) AS fecha,
                  CONCAT('OS-',e.folio,' RE-(',e.requisiciones,')') AS referencia,e.id AS id_oc,
                  IFNULL(b.cuenta,'') AS cuenta_clabe,c.clave AS banco,a.id_entrada_compra AS idE01,
                  0 AS vencidos
                  FROM cxp a
                  LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                  LEFT JOIN proveedores b ON a.id_proveedor=b.id
                  LEFT JOIN bancos c ON b.id_banco=c.id
                  LEFT JOIN almacen_e d ON d.id=a.id_entrada_compra
                  LEFT JOIN orden_compra e ON e.id=d.id_oc 
                  LEFT JOIN requisiciones g ON e.ids_requisiciones=g.id
                  LEFT JOIN sucursales h ON h.id_sucursal = a.id_sucursal
                  WHERE a.id_entrada_compra > 0 AND a.id_viatico = 0 AND id_requisicion=0 AND a.estatus IN('P','A') AND g.tipo=4
                  AND
                  IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                  DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                  CASE 
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                  WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                  ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                  END)  BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 365 DAY)
                  HAVING importe > 0
                  $condicion";
      }

      $result = $this->link->query($query);

      return query2json($result);
    }

    /**
      * Guardo cargos de abono para los cxp ó deudores_diversos indicados
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarCxP($datos){
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardar($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
    }//- fin function guardarCxP

    /**
      * Guardo cargos de abono para los cxp ó deudores_diversos indicados
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardar($datos){
      $verifica = 0;

      $registros = $datos['registros'];
      $referenciaN = $datos['referenciaN'];
      $idConcepto = $datos['idConcepto'];
      $claveConcepto = $datos['claveConcepto'];
      $idBanco = $datos['idBanco'];
      $idCuentaBanco = $datos['idCuentaBanco'];
      $idUsuario = $datos['idUsuario'];
      $tipoCuenta = $datos['tipoCuenta'];
      $fechaAplicacion = $datos['fechaAplicacion'];

      // print_r($datos);
      // exit();

      for($i=1;$i<=$registros[0];$i++){

        $id = $registros[$i]['id'];
        $tipo = $registros[$i]['tipo'];
        $referencia = $registros[$i]['referencia'].' '.$referenciaN;
        $importe = $registros[$i]['importe'];
        $rutaXml = $registros[$i]['rutaXml'];
        $rutaPdf = $registros[$i]['rutaPdf'];

        if($tipo == 'gasto'){
          //NJES Jan/17/01/2020 se busca el id_clasificacion_gasto del gasto para guardarlo en deudores_diversos
          $busqueda="SELECT a.id_unidad_negocio,a.id_sucursal,a.id_area,a.id_departamento,a.id_familia,a.id_clasificacion,a.fecha,a.id_trabajador AS id_empleado,
                      IF(a.id_trabajador=0,a.nombre,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS empleado,a.fecha_aplicacion_presupuestos
                      FROM gastos a
                      LEFT JOIN trabajadores b ON a.id_trabajador=b.id_trabajador
                      WHERE a.id=".$id;
          $resultC = mysqli_query($this->link, $busqueda) or die(mysqli_error());
  
          if($resultC)
          {
            $datosC=mysqli_fetch_array($resultC);
            $idUnidadNegocio=$datosC['id_unidad_negocio']; 
            $idSucursal=$datosC['id_sucursal'];
            $idDepartamento=$datosC['id_departamento'];
            $idArea=$datosC['id_area'];
            $fecha=$datosC['fecha'];
            $id_empleado=$datosC['id_empleado'];
            $empleado=$datosC['empleado'];
            $idFamiliaGasto=$datosC['id_familia'];
            $idClasificacionGasto=$datosC['id_clasificacion'];

            //-->NJES April/06/2021 tomar la fecha aplicacion capturada en gastos al afectar movimientos presupuesto
            $fechaAplicacionGasto = $datosC['fecha_aplicacion_presupuestos'];

            $arr=array('id_gasto'=>$id,
                        'id_viatico'=>0,
                        'referencia'=>$referencia,
                        'importe'=>$importe,
                        'categoria'=>'GASTO',
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'idDepartamento'=>$idDepartamento,
                        'idArea'=>$idArea,
                        'idFamiliaGasto'=>$idFamiliaGasto,
                        'idClasificacionGasto'=>$idClasificacionGasto,
                        'fecha'=>$fecha,
                        'id_empleado'=>$id_empleado,
                        'empleado'=>$empleado,
                        'idConcepto'=>$idConcepto,
                        'claveConcepto'=>$claveConcepto,
                        'idBanco'=>$idBanco,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'tipoCuenta'=>$tipoCuenta,
                        'fechaAplicacion'=>$fechaAplicacion,
                        'tipo'=>$tipo,
                        'fecha_aplicacion_gasto'=>$fechaAplicacionGasto);
            if($i == 1)
            {
              $verifica = $this -> guardarDeudorDiverso($arr);
            }else{
              if($verifica == 1)
              {
                $verifica = $this -> guardarDeudorDiverso($arr);
              }else{
                $verifica = 0;
                break;
              }
            }

          }else{
            $verifica = 0;
            break;
          }
        }else if($tipo == 'viatico'){
          //-->NJES Jan/17/2020 buscar id_clasificacion_gasto de viatico para insertarlo en movimientos_presupuesto
          $busqueda="SELECT a.id_unidad_negocio,a.id_sucursal,a.id_area,a.id_departamento,a.id_familia_gasto,
                      a.id_clasificacion_gasto,
                      DATE(a.fecha_captura) AS fecha,a.id_empleado,
                      IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS empleado
                      FROM viaticos a
                      LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                      WHERE a.id=".$id;
          $resultC = mysqli_query($this->link, $busqueda) or die(mysqli_error());
  
          if($resultC){
            $datosC=mysqli_fetch_array($resultC);
            $idUnidadNegocio=$datosC['id_unidad_negocio']; 
            $idSucursal=$datosC['id_sucursal'];
            $idDepartamento=$datosC['id_departamento'];
            $idArea=$datosC['id_area'];
            $idFamiliaGasto=$datosC['id_familia_gasto'];
            $fecha=$datosC['fecha'];
            $id_empleado=$datosC['id_empleado'];
            $empleado=$datosC['empleado'];
            $idClasificacionGasto=$datosC['id_clasificacion_gasto'];

            $arr=array('id_viatico'=>$id,
                        'id_gasto'=>0,
                        'referencia'=>$referencia,
                        'importe'=>$importe,
                        'categoria'=>'VIATICO',
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'idDepartamento'=>$idDepartamento,
                        'idArea'=>$idArea,
                        'idFamiliaGasto'=>$idFamiliaGasto,
                        'idClasificacionGasto'=>$idClasificacionGasto,
                        'fecha'=>$fecha,
                        'id_empleado'=>$id_empleado,
                        'empleado'=>$empleado,
                        'idConcepto'=>$idConcepto,
                        'claveConcepto'=>$claveConcepto,
                        'idBanco'=>$idBanco,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'tipoCuenta'=>$tipoCuenta,
                        'fechaAplicacion'=>$fechaAplicacion,
                        'tipo'=>$tipo
                        );

            
            if($i == 1){
              $verifica = $this -> guardarDeudorDiverso($arr);
            }else{
              if($verifica == 1){
                $verifica = $this -> guardarDeudorDiverso($arr);
              }else{
                $verifica = 0;
                break;
              }
            }
          }else{
            $verifica = 0;
            break;
          }
        }else{ //es cxp_viatico o cxp_oc (registros generados del protal de proveedores)

          //-->NJES Jan/20/2020 buscar id_clasificacion_gasto de cxp que se genero de un viatico para insertarlo en movimientos_presupuesto
          $busqueda="SELECT
                        a.id,
                        a.no_factura,
                        a.fecha,
                        a.id_unidad_negocio,
                        a.id_proveedor,
                        a.id_sucursal,
                        a.id_area,
                        a.id_departamento,
                        a.concepto,
                        a.id_empleado,
                        a.id_viatico,
                        a.id_familia_gasto,
                        a.id_clasificacion_gasto,
                        IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS empleado
                      FROM cxp a
                      LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                      WHERE a.id=".$id;

                      // echo $busqueda;
                      // exit();
          $resultC = mysqli_query($this->link, $busqueda) or die(mysqli_error());
  
          if($resultC){
            $datosC=mysqli_fetch_array($resultC);
            // print_r($datosC);
            // exit();
            $idUnidadNegocio=$datosC['id_unidad_negocio']; 
            $idSucursal=$datosC['id_sucursal'];
            $idDepartamento=$datosC['id_departamento'];
            $idArea=$datosC['id_area'];
            $fecha=$datosC['fecha'];
            $id_empleado=$datosC['id_empleado'];
            $empleado=$datosC['empleado'];
            $factura=$datosC['no_factura']; 
            $concepto=$datosC['concepto'];
            $id_viatico=$datosC['id_viatico'];
            $idProveedor=$datosC['id_proveedor'];
            $id_familia_gasto=$datosC['id_familia_gasto'];
            $idClasificacionGasto=$datosC['id_clasificacion_gasto'];
            $idOrdenServicio = 0;

            if($tipo == 'cxp_os' || $tipo == 'cxp_oc'){
              $busquedaReq = "SELECT 
                                cxp.id_entrada_compra AS id_ea,
                                orden_compra.id AS id_oc,
                                requisiciones.id AS id_requi,
                                requisiciones.id_familia_gasto AS id_fam
                              FROM cxp 
                              INNER JOIN almacen_e ON cxp.id_entrada_compra = almacen_e.id
                              INNER JOIN orden_compra ON almacen_e.id_oc = orden_compra.id
                              INNER JOIN requisiciones ON orden_compra.ids_requisiciones = requisiciones.id
                              WHERE cxp.id = $id ";

              // echo $busquedaReq;
              // exit();

              $resultReq = mysqli_query($this->link, $busquedaReq) or die(mysqli_error());

              if($resultReq){
                $dReq = mysqli_fetch_array($resultReq);
                $id_familia_gasto=  $dReq['id_fam'];
                $idOrdenServicio = $dReq['id_requi'];
              }else{
                $verifica = false;
                break;
              }            
            }

            if($tipo == 'cxp_ar'){
              $busquedaReq = "SELECT 
                                cxp.id_entrada_compra AS id_ea,
                                requisiciones.id AS id_requi,
                                requisiciones.id_familia_gasto AS id_fam
                              FROM cxp
                              INNER JOIN requisiciones ON cxp.id_requisicion = requisiciones.id
                              WHERE cxp.id = $id ";

              $resultReq = mysqli_query($this->link, $busquedaReq) or die(mysqli_error());

              if($resultReq){
                $dReq = mysqli_fetch_array($resultReq);
                $id_familia_gasto=  $dReq['id_fam'];
                $idOrdenServicio = $dReq['id_requi'];
              }else{
                $verifica = false;
                break;
              }  
            }

            $arr=array('id_cxp'=>$id,
                        'id_viatico'=>$id_viatico,
                        'idFamiliaGasto'=>$id_familia_gasto,
                        'idClasificacionGasto'=>$idClasificacionGasto,
                        'referencia'=>$referencia,
                        'importe'=>$importe,
                        'categoria'=>$concepto,
                        'idUnidadNegocio'=>$idUnidadNegocio,
                        'idSucursal'=>$idSucursal,
                        'idDepartamento'=>$idDepartamento,
                        'idArea'=>$idArea,
                        'fecha'=>$fecha,
                        'id_empleado'=>$id_empleado,
                        'empleado'=>$empleado,
                        'idConcepto'=>$idConcepto,
                        'claveConcepto'=>$claveConcepto,
                        'idBanco'=>$idBanco,
                        'idCuentaBanco'=>$idCuentaBanco,
                        'idUsuario'=>$idUsuario,
                        'tipoCuenta'=>$tipoCuenta,
                        'factura'=>$factura,
                        'tipo'=>$tipo,
                        'rutaXml'=>$rutaXml,
                        'rutaPdf'=>$rutaPdf,
                        'idProveedor'=>$idProveedor,
                        'fechaAplicacion'=>$fechaAplicacion,
                        'idOrdenServicio'=>$idOrdenServicio);

              // print_r($arr);
              // exit();

            if($i == 1){
              $verifica = $this -> guardarPagoCxP($arr);
            }else{
              if($verifica == 1)
                $verifica = $this -> guardarPagoCxP($arr);
              else
              {
                $verifica = 0;
                break;
              }
            }
          }else{
            $verifica = 0;
            break;
          }
        }
      }

      return $verifica;
    }//- fin function guardar

    /**
      * Guardo registro de deudores_diversos indicados
      * 
      * @param varchar $datos array que contiene los datos a insertar
      * @param varchar $arr array que contiene los datos a insertar
      *
    **/
    function guardarDeudorDiverso($datos){

      $verifica = 0;

      $tipoCuenta = $datos['tipoCuenta'];
      $id_gasto = $datos['id_gasto'];
      $id_viatico = $datos['id_viatico'];
      $referencia = $datos['referencia'];
      $importe = $datos['importe'];
      $categoria = $datos['categoria'];
      $idUnidadNegocio = $datos['idUnidadNegocio'];
      $idSucursal = $datos['idSucursal'];
      $idDepartamento = $datos['idDepartamento'];
      $idArea = $datos['idArea'];
      $fecha = $datos['fecha'];
      $id_empleado = $datos['id_empleado'];
      $empleado = $datos['empleado'];
      $fechaAplicacion = $datos['fechaAplicacion'];
      $idFamiliaGasto = isset($datos['idFamiliaGasto']) ? $datos['idFamiliaGasto'] : 0;
      //-->NJES Jan/17/2020 se manda guardar id_clasificacion_gasto
      $idClasificacionGasto = isset($datos['idClasificacionGasto']) ? $datos['idClasificacionGasto'] : 0;

      $tipo = isset($datos['tipo']) ? $datos['tipo'] : '';

      $query="INSERT INTO deudores_diversos(id_gasto,id_viatico,importe,comprobado,referencia,categoria,fecha,id_empleado,empleado,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_familia_gastos,id_clasificacion_gasto)
              VALUES ('$id_gasto','$id_viatico','$importe',0,'$referencia','$categoria','$fechaAplicacion','$id_empleado','$empleado','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idFamiliaGasto','$idClasificacionGasto')";
      $result=mysqli_query($this->link, $query)or die(mysqli_error());
      
      if($result)
      {
        //-->NJES June/19/2020 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
        //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
        $afectarPresupuesto = new MovimientosPresupuesto();

        if($tipo == 'gasto')
        {
          $fechaAplicacionGasto = $datos['fecha_aplicacion_gasto'];

          $queryB = "SELECT gastos_d.id,
                      gastos_d.id_familia_gasto,
                      gastos_d.id_clasificacion,
                      gastos_d.id_requisicion_d,
                      (requisiciones_d.cantidad*requisiciones_d.costo_unitario)+((requisiciones_d.cantidad*requisiciones_d.costo_unitario)*requisiciones_d.iva)/100 AS total
                      FROM gastos_d
                      LEFT JOIN requisiciones_d ON gastos_d.id_requisicion_d=requisiciones_d.id
                      WHERE gastos_d.id_gasto=$id_gasto";

          $res_queryB = mysqli_query($this->link,$queryB) or die(mysqli_error());
          $num_queryB = mysqli_num_rows($res_queryB);

          if($num_queryB > 0)
          {
            while($d = mysqli_fetch_array($res_queryB))
            {

              $idFamiliaGastoP = $d['id_familia_gasto'];
              $idClasificacionP = $d['id_clasificacion'];
              $total = $d['total'];

              $arrDatosMP = array(
                'idUnidadNegocio' => $idUnidadNegocio,
                'idSucursal' => $idSucursal,
                'idFamiliaGasto' => $idFamiliaGastoP,
                'clasificacionGasto' => $idClasificacionP,
                'total' => $total,
                'tipo' => 'C',
                'idGasto' => $id_gasto,
                'idViatico' => $id_viatico,
                'fecha' => $fechaAplicacionGasto
              );
            
              //---CUANDO SE LIQUIDA UN PAGO POR VIATICO O GASTO GENERA SU MOVIMIENTO_PRESUPUESTO--
              $afecta = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 

              if($afecta > 0)
                $resultMP = $afecta;
              else{
                $resultMP = 0 ;
                break;
              }
              
            }
          }else{
            $arrDatosMP = array(
              'idUnidadNegocio' => $idUnidadNegocio,
              'idSucursal' => $idSucursal,
              'idFamiliaGasto' => $idFamiliaGasto,
              'clasificacionGasto' => $idClasificacionGasto,
              'total' => $importe,
              'tipo' => 'C',
              'idGasto' => $id_gasto,
              'idViatico' => $id_viatico,
              'fecha' => $fechaAplicacionGasto
            );
          
            //---CUANDO SE LIQUIDA UN PAGO POR VIATICO O GASTO GENERA SU MOVIMIENTO_PRESUPUESTO--
            $resultMP = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 
          }

        }else{
          
          $arrDatosMP = array(
            'idUnidadNegocio' => $idUnidadNegocio,
            'idSucursal' => $idSucursal,
            'idFamiliaGasto' => $idFamiliaGasto,
            'clasificacionGasto' => $idClasificacionGasto,
            'total' => $importe,
            'tipo' => 'C',
            'idGasto' => $id_gasto,
            'idViatico' => $id_viatico
          );
        
          //---CUANDO SE LIQUIDA UN PAGO POR VIATICO O GASTO GENERA SU MOVIMIENTO_PRESUPUESTO--
          $resultMP = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 
        }
        
          if($resultMP > 0)
          {
            if($id_gasto == 0)
            {
              $queryA="UPDATE viaticos SET estatus='S' WHERE id=".$id_viatico;
            }else{
              $queryA="UPDATE gastos SET comprobado=1 WHERE id=".$id_gasto;
            }

            $resultA = mysqli_query($this->link, $queryA) or die(mysqli_error());

            if($resultA)
            {
              
              if($tipoCuenta == 0)
              {
                $verifica = $this -> guardarMovimientosBancos($datos);

              }else{

                $verifica = $this -> guardarGastoCajaChica($datos);
              }

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
    }//- fin function guardarDeudorDiverso

    function guardarMovimientosBancos($datos){
      $verifica = 0;

      $idCuentaBanco = $datos['idCuentaBanco'];
      $idUsuario = $datos['idUsuario'];
      $id_gasto = isset($datos['id_gasto']) ? $datos['id_gasto'] : 0;
      $id_viatico = isset($datos['id_viatico']) ? $datos['id_viatico'] :0 ;
      $id_cxp = isset($datos['id_cxp']) ? $datos['id_cxp'] : 0;
      $importe = $datos['importe'];
      $categoria = $datos['categoria'];
      $tipo = isset($datos['tipo']) ? $datos['tipo'] : '';
      $rutaXml = isset($datos['rutaXml']) ? $datos['rutaXml'] : '';
      $rutaPdf = isset($datos['rutaPdf']) ? $datos['rutaPdf'] : '';
      $fecha = $datos['fecha'];
      //-->NJES April/06/2021 si es deudor diverso de gasto tomar la fecha aplicacion capturada en e modulo de gastos
      if($tipo == 'gasto')
        $fechaAplicacion = $datos['fecha_aplicacion_gasto'];
      else
        $fechaAplicacion = $datos['fechaAplicacion'];
      
      
      $query = "INSERT INTO movimientos_bancos(id_cuenta_banco,monto,tipo,id_usuario,observaciones,id_gasto,id_viatico,id_cxp,fecha_aplicacion) 
                VALUES ('$idCuentaBanco','$importe','C','$idUsuario','$categoria','$id_gasto','$id_viatico','$id_cxp','$fechaAplicacion')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
      if($result)
      { 
        if($tipo=='cxp_oc'){
          
          @unlink('../'.$rutaPdf);
          @unlink('../'.$rutaXml);
          $verifica = 1; 
          
        }else{
          $verifica = 1; 
        }
                   
      }else{
        $verifica = 0;
      }

      return $verifica;
    }//- fin function guardarMovimientosBancos

    function guardarGastoCajaChica($datos){
      $verifica = 0;

      $idUnidadNegocio = $datos['idUnidadNegocio'];
      $idSucursal = $datos['idSucursal'];
      $idDepartamento = $datos['idDepartamento'];
      $idArea = $datos['idArea'];
      $importe = $datos['importe'];
      $id_gasto = isset($datos['id_gasto']) ? $datos['id_gasto'] : 0;
      $id_viatico = isset($datos['id_viatico']) ? $datos['id_viatico'] :0 ;
      $id_cxp = isset($datos['id_cxp']) ? $datos['id_cxp'] : 0;
      $categoria = $datos['categoria'];
      $idUsuario = $datos['idUsuario'];
      $fecha = $datos['fecha'];

      $tipo = isset($datos['tipo']) ? $datos['tipo'] : '';
      //-->NJES April/06/2021 si es deudor diverso de gasto tomar la fecha aplicacion capturada en e modulo de gastos
      if($tipo == 'gasto')
        $fechaAplicacion = $datos['fecha_aplicacion_gasto'];
      else
        $fechaAplicacion = $datos['fechaAplicacion'];

      //-->NJES Jan/21/2020 Busco id_unidad_negocio, id_sucursal de la cuenta banco caja chica de la que voy a hacer un egreso G01
      $buscaCuenta = "SELECT id_unidad_negocio,id_sucursal 
      FROM cuentas_bancos WHERE id=".$idCuentaOrigen;
      $resultC = mysqli_query($this->link, $buscaCuenta) or die(mysqli_error());

      if($resultC)
      {
        $datosC=mysqli_fetch_array($resultC);
        $idUnidadNegocioG=$datosC['id_unidad_negocio']; 
        $idSucursalG=$datosC['id_sucursal'];

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
            //--> Inserta en caja chica el gasto G01
            $query="INSERT INTO caja_chica(folio,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_concepto,clave_concepto,fecha,importe,observaciones,estatus,id_usuario,id_gasto,id_viatico,id_cxp)
                    VALUES('$folio','$idUnidadNegocioG','$idSucursalG','$idArea','$idDepartamento',16,'G01','$fechaAplicacion','$importe','$categoria',1,'$idUsuario','$id_gasto','$id_viatico','$id_cxp')";
            $result=mysqli_query($this->link, $query)or die(mysqli_error());
            
            if($result)
            {
              $verifica = 1;      
            }else{
              $verifica = 0;
            }
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

    function guardarPagoCxP($datos){

      // print_r($datos);
      // exit();
    
      $verifica = 0;

      $idCxP = $datos['id_cxp'];
      $id_viatico = isset($datos['id_viatico']) ? $datos['id_viatico'] : 0;
      $id_gasto = isset($datos['id_gasto']) ? $datos['id_gasto'] : 0;
      $factura = $datos['factura'];
      $idProveedor = isset($datos['idProveedor']) ? $datos['idProveedor'] : 0;
      $idConcepto = $datos['idConcepto'];
      $claveConcepto = $datos['claveConcepto'];
      $fecha = $datos['fecha'];
      $importe = $datos['importe'];
      $referencia = $datos['referencia'];
      $idBanco = $datos['idBanco'];
      $idCuentaBanco = $datos['idCuentaBanco'];
      $idUsuario = $datos['idUsuario'];
      $tipoCuenta = $datos['tipoCuenta'];
      $idUnidadNegocio = isset($datos['idUnidadNegocio']) ? $datos['idUnidadNegocio'] : 0;
      $idSucursal = isset($datos['idSucursal']) ? $datos['idSucursal'] : 0;
      $idDepartamento = isset($datos['idDepartamento']) ? $datos['idDepartamento'] : 0;
      $idArea = isset($datos['idArea']) ? $datos['idArea'] : 0;
      $fechaAplicacion = $datos['fechaAplicacion'];
      $idFamiliaGasto = isset($datos['idFamiliaGasto']) ? $datos['idFamiliaGasto'] : 0;
      $idOrdenServicio = isset($datos['idOrdenServicio']) ? $datos['idOrdenServicio'] : 0;

      $tipo = $datos['tipo'];

      //-->NJES Jan/17/2020 id_clasificacion_gasto de cxp que se genero de un viatico para insertarlo en movimientos_presupuesto
      $idClasificacionGasto = isset($datos['idClasificacionGasto']) ? $datos['idClasificacionGasto'] : 0;

      $query = "INSERT INTO cxp(id_cxp,id_proveedor,no_factura,id_concepto,clave_concepto,fecha,subtotal,referencia,id_banco,id_cuenta_banco,estatus,id_viatico,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_familia_gasto,id_clasificacion_gasto) 
                  VALUES ('$idCxP','$idProveedor','$factura','$idConcepto','$claveConcepto','$fechaAplicacion','$importe','$referencia','$idBanco','$idCuentaBanco','L','$id_viatico','$idUnidadNegocio','$idSucursal','$idDepartamento','$idArea','$idFamiliaGasto','$idClasificacionGasto')";

      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
      if($result){
        $queryA="UPDATE cxp SET estatus='L' WHERE id=".$idCxP;
        $resultA = mysqli_query($this->link, $queryA) or die(mysqli_error());

        if($resultA){
          // if($tipo == 'cxp_viatico' || $tipo == 'cxp_os')
          // {
            //-->NJES June/19/2020 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
            //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
          $afectarPresupuesto = new MovimientosPresupuesto();

          switch($tipo){
            case "cxp_oc":
              $separado = explode(" ",$referencia);
              $masSeparado=explode("-", $separado[0]);
              $idOrdenCompra =  $masSeparado[1];

              $queryOC = "SELECT sum(cantidad * precio) monto, pr.id_clas, fa.id_familia_gasto id_familia
                          FROM almacen_d ad
                          inner join productos pr ON ad.id_producto = pr.id 
                          INNER JOIN almacen_e ae ON ae.id = ad.id_almacen_e 
                          INNER JOIN familias fa ON pr.id_familia = fa.id
                          INNER JOIN cxp ON cxp.id_entrada_compra = ae.id
                          where ae.id_oc = (SELECT id FROM orden_compra WHERE folio = '$idOrdenCompra' AND id_sucursal = '$idSucursal') 
                          AND cxp.id_cxp = $idCxP 
                          group by pr.id_clas";

                // echo $queryOC;
                // exit();

              $resultOC = mysqli_query($this->link, $queryOC) or die(mysqli_error());

              while($row = mysqli_fetch_array($resultOC)) {  

                $id_clas = $row["id_clas"];
                $id_fam = $row["id_familia"];
                $monto = $row["monto"];

                $arrDatosMP = array(
                  'idUnidadNegocio' => $idUnidadNegocio,
                  'idSucursal' => $idSucursal,
                  'idFamiliaGasto' => $id_fam,
                  'clasificacionGasto' => $id_clas,
                  'total' => $monto,
                  'tipo' => 'C',
                  'idGasto' => $id_gasto,
                  'idViatico' => $id_viatico,
                  'fecha'=>$fechaAplicacion
                );
                
                $resultMP = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 
              }

              break;
            case "cxp_ar":
              $queryOC = "SELECT sum(r.total) monto, pr.id_clas, fa.id_familia_gasto id_familia 
                          FROM requisiciones_d rd 
                          inner join productos pr ON rd.id_producto = pr.id
                          INNER JOIN requisiciones r ON rd.id_requisicion = r.id
                          INNER JOIN familias fa ON pr.id_familia = fa.id 
                          inner join cxp cxp ON cxp.id_requisicion=r.id
                          where r.id = $idOrdenServicio 
                          group by pr.id_clas;";

              $resultOC = mysqli_query($this->link, $queryOC) or die(mysqli_error());
              $cantidad = mysqli_num_rows($resultOC);

              $monto = $importe / $cantidad;

              while($row = mysqli_fetch_array($resultOC)) {  

                // print_r($row);
                // continue;

                $id_clas = $row["id_clas"];
                $id_fam = $row["id_familia"];

                $arrDatosMP = array(
                  'idUnidadNegocio' => $idUnidadNegocio,
                  'idSucursal' => $idSucursal,
                  'idFamiliaGasto' => $id_fam,
                  'clasificacionGasto' => $id_clas,
                  'total' => $monto,
                  'tipo' => 'C',
                  'idGasto' => $id_gasto,
                  'idViatico' => $id_viatico,
                  'fecha'=>$fechaAplicacion
                );
                
                $resultMP = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 
              }
              break;
            default:
                $arrDatosMP = array(
                  'idUnidadNegocio' => $idUnidadNegocio,
                  'idSucursal' => $idSucursal,
                  'idFamiliaGasto' => $idFamiliaGasto,
                  'clasificacionGasto' => $idClasificacionGasto,
                  'total' => $importe,
                  'tipo' => 'C',
                  'idGasto' => $id_gasto,
                  'idViatico' => $id_viatico,
                  'fecha'=>$fechaAplicacion
                );
                
                $resultMP = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 
              break;
          }

          
          
          if($resultMP > 0){
            if($tipoCuenta == 0){
              $verifica = $this -> guardarMovimientosBancos($datos);
            }else{
              $verifica = $this -> guardarGastoCajaChica($datos);
            }
          }else{
            $verifica = 0;
          }
          // }
          // else
          // { //-->NJES Feb/06/2020 Cuando es un cxp de orden de compra, anticipo requisición no afectar movimiento presupuesto porque ya se afecto al generar la recepción de mercancia
            
          //   if($tipoCuenta == 0)
          //   {
          //     $verifica = $this -> guardarMovimientosBancos($datos);
          //   }else{
          //     $verifica = $this -> guardarGastoCajaChica($datos);
          //   }
          // }

        }else{
          $verifica = 0;
        }
      }else{
        $verifica = 0;
      }

      return $verifica;
    }//- fin function guardarPagoCxP

    /**
      * Busca los detalles del registro de cxp
      * 
      * @param int $id del cxp que se va a buscar el detalle
      * @param varchar $tipo para ver si es un cxp relacionado con viaticos, ordenes de compra, requisiciones.
      *
    **/
    function buscarDetalleRegistro($id,$tipo){

      if($tipo == 'cxp_viatico')
      {
        $query = "SELECT a.id,a.id_viatico,(a.subtotal+a.iva-a.descuento) AS total,g.destino,g.distancia,g.motivos,
                  g.fecha_inicio,g.fecha_fin,g.dias,g.noches,g.autorizo,
                  IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS empleado,
                  c.nombre AS unidad,d.descr AS sucursal,f.des_dep AS departamento,e.descripcion AS are,
                  CONCAT(h.nombre,' ',h.apellido_p,' ',h.apellido_m) AS solicito
                  FROM cxp a
                  LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                  LEFT JOIN cat_unidades_negocio c ON  a.id_unidad_negocio = c.id
                  LEFT JOIN sucursales d ON a.id_sucursal = d.id_sucursal
                  LEFT JOIN cat_areas e ON a.id_area = e.id
                  LEFT JOIN deptos f ON a.id_departamento=f.id_depto
                  LEFT JOIN viaticos g ON a.id_viatico=g.id
                  LEFT JOIN trabajadores h ON g.id_solicito=h.id_trabajador
                  WHERE a.id=".$id;
      }else{
        $query = "SELECT 
                  a.id,
                  a.concepto,
                  (SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva -descuento),((subtotal + iva -descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp ) AS saldo,
                  c.nombre AS unidad,
                  d.descr AS sucursal,
                  f.des_dep AS departamento,
                  e.descripcion AS are,
                  g.nombre AS proveedor,
                  b.solicito,
                  b.fecha_pedido,
                  b.tiempo_entrega AS dias_entrega,
                  b.total,
                  b.monto_anticipo,
                  a.id_requisicion,
                  b.folio
                  FROM cxp a
                  LEFT JOIN requisiciones b ON a.id_requisicion=b.id
                  LEFT JOIN cat_unidades_negocio c ON  a.id_unidad_negocio = c.id
                  LEFT JOIN sucursales d ON a.id_sucursal = d.id_sucursal
                  LEFT JOIN cat_areas e ON a.id_area = e.id
                  LEFT JOIN deptos f ON a.id_departamento=f.id_depto
                  LEFT JOIN proveedores g ON a.id_proveedor=g.id
                  WHERE a.id=".$id;
      }

      $result = $this->link->query($query);

      return query2json($result);
    }//- fin function buscarDetalleRegistro

}//--fin de class CxpPagos
    
?>