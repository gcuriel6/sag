<?php

include_once('conectar.php');

class Almacenes
{

    public $link;

    function Almacenes()
    {
  
      $this->link = Conectarse();

    }

    function buscarInventarioSucursal($idSucursal)
    {

      //-->NJES July/29/2020 mostrar el ultimo precio de compra por unidad en el inventario
      /*$resultado = $this->link->query("
          SELECT
          productos.id AS id_producto,
          productos.clave AS clave_producto,
          productos.concepto AS concepto,
          productos.descripcion AS descripcion_producto,
          productos.id_familia AS id_familia,
          familias.descripcion AS familia,
          productos.id_linea AS id_linea,
          lineas.descripcion AS linea,
          productos.costo,
          productos_unidades.ultimo_precio_compra AS precio,
          IFNULL(productos_unidades.ultimo_precio_compra, 0) AS precio,
          SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia 
          FROM productos
          INNER JOIN familias ON productos.id_familia = familias.id
          INNER JOIN lineas ON productos.id_linea = lineas.id
          LEFT JOIN productos_unidades ON productos.id = productos_unidades.id_producto
          INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
          INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id AND almacen_e.id_unidad_negocio=productos_unidades.id_unidades
          WHERE almacen_e.id_sucursal = $idSucursal 
          -- AND almacen_e.estatus != 'C'
          $and
          GROUP BY productos.id");*/

        //-->NJES October/08/2020 no mostrar los productos de tipo activo fijo y mantenimiento
      $query = "SELECT
                  produ.id_producto,
                  produ.clave_producto,
                  produ.concepto,
                  produ.descripcion_producto,
                  produ.id_familia,
                  produ.familia,
                  produ.id_linea,
                  produ.linea,
                  produ.costo,
                  produ.precio,
                  produ.precio_venta,
                  produ.existencia 
                FROM
                (
                  SELECT
                    productos.id AS id_producto,
                    productos.clave AS clave_producto,
                    productos.concepto AS concepto,
                    productos.descripcion AS descripcion_producto,
                    productos.id_familia AS id_familia,
                    familias.descripcion AS familia,
                    productos.id_linea AS id_linea,
                    lineas.descripcion AS linea,
                    IFNULL(productos_sucursales.costo_compra, productos.costo) costo,
                    IFNULL(productos_sucursales.costo_compra, IFNULL(productos_unidades.ultimo_precio_compra, 0)) AS precio,
                    SUM(IF(SUBSTR(almacen_d.cve_concepto,1,1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia,
                    IFNULL(productos_sucursales.precio_venta, productos.precio_venta) precio_venta
                  FROM productos
                  INNER JOIN familias ON productos.id_familia = familias.id
                  INNER JOIN lineas ON productos.id_linea = lineas.id
                  LEFT JOIN productos_unidades ON productos.id = productos_unidades.id_producto
                  LEFT JOIN productos_sucursales ON productos.id = productos_sucursales.fk_id_producto AND productos_sucursales.fk_id_sucursal = $idSucursal
                  INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
                  INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id  AND almacen_e.id_unidad_negocio=productos_unidades.id_unidades
                  WHERE almacen_e.id_sucursal = $idSucursal AND familias.tipo NOT IN (0,2) AND almacen_e.estatus != 'C'
                  AND productos.servicio = 0
                  GROUP BY productos.id

                  UNION ALL

                  SELECT
                    productos.id AS id_producto,
                    productos.clave AS clave_producto,
                    productos.concepto AS concepto,
                    productos.descripcion AS descripcion_producto,
                    productos.id_familia AS id_familia,
                    familias.descripcion AS familia,
                    productos.id_linea AS id_linea,
                    lineas.descripcion AS linea,
                    IFNULL(productos_sucursales.costo_compra, productos.costo) costo,
                    IFNULL(productos_sucursales.costo_compra, IFNULL(productos_unidades.ultimo_precio_compra, 0)) AS precio,
                    SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia,
                    IFNULL(productos_sucursales.precio_venta, productos.precio_venta) precio_venta
                  FROM productos
                  INNER JOIN familias ON productos.id_familia = familias.id
                  INNER JOIN lineas ON productos.id_linea = lineas.id
                  LEFT JOIN productos_sucursales ON productos.id = productos_sucursales.fk_id_producto AND productos_sucursales.fk_id_sucursal = $idSucursal
                  LEFT JOIN 
                  (
                    SELECT 
                    pr.id AS id_original,
                    pr.equivalente_usado AS id_equivalente
                    FROM productos pr) po ON productos.id = po.id_equivalente
                  INNER JOIN productos_unidades ON  po.id_original = productos_unidades.id_producto
                  INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
                  INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id  AND almacen_e.id_unidad_negocio=productos_unidades.id_unidades
                  WHERE almacen_e.id_sucursal = $idSucursal AND familias.tipo NOT IN (0,2) AND almacen_e.estatus != 'C'
                  AND productos.servicio = 0
                  GROUP BY productos.id) AS produ
                GROUP BY produ.id_producto";

        // echo $query;
        // exit();
      
      $resultado = $this->link->query($query);

      return query2json($resultado);

    }

    function buscarExistenciaProducto($idSucursal, $idProducto, $fechaInicio)
    {

      $and = " ";
      if($fechaInicio != '')
        $and .= " AND date(almacen_e.fecha) >= '$fechaInicio'";

      $result = mysqli_query($this->link, 
        "SELECT
          SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia 
          FROM productos
          INNER JOIN familias ON productos.id_familia = familias.id
          INNER JOIN lineas ON productos.id_linea = lineas.id
          INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
          INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
          WHERE almacen_e.id_sucursal = $idSucursal  and almacen_e.estatus != 'C'
          AND productos.id = $idProducto
          $and
          GROUP BY productos.id");
      $row = mysqli_fetch_assoc($result);
      return $row['existencia'];

    }

    function buscarExistenciaProductoRangoFechas($idSucursal, $idProducto, $fechaFin)
    {

      $and = " ";
      if($fechaFin != '')
        $and .= " AND DATE(almacen_e.fecha) <= '$fechaFin'";

      $result = mysqli_query($this->link, 
        "SELECT
          SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia 
          FROM productos
          INNER JOIN familias ON productos.id_familia = familias.id
          INNER JOIN lineas ON productos.id_linea = lineas.id
          INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
          INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
          WHERE almacen_e.id_sucursal = $idSucursal and almacen_e.estatus != 'C'
          AND productos.id = $idProducto
          $and
          GROUP BY productos.id");
      $row = mysqli_fetch_assoc($result);
      return $row['existencia'];

    }

    function buscarRastreo($idSucursal, $idProducto, $fechaDe, $fechaA)
    {


      $and = " ";

      $condicionBusquedaRango='';
      if($fechaA != ''){
        // SE PONE DATE EN 'DATE(almacen_e.fecha)' PARA QUE AGARRE EL BETWEEN EN >= Y <=
        $and .= " AND DATE(almacen_e.fecha) BETWEEN '$fechaDe' AND '$fechaA'"; 

        $condicionBusquedaRango="
        SELECT
          0 as id,
          0 AS no_movimiento,
          '$fechaDe' AS fecha,
          'ES' AS clave,
          productos.concepto AS concepto,
          0 AS id_trabajador,
          0 AS id_proveedor,
          '' AS ref,
          '' AS referencia,
          '' AS precio,
          IFNULL(SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)),0) AS cantidad,
          'ES - SALDO INICIAL' AS concepto_mov
        FROM productos
        INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
        INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
        LEFT JOIN proveedores ON almacen_e.id_proveedor = proveedores.id
        LEFT JOIN trabajadores ON almacen_e.id_trabajador =  trabajadores.id_trabajador
        WHERE almacen_e.id_sucursal = $idSucursal  AND almacen_e.estatus != 'C'
        AND productos.id = $idProducto 
        AND DATE(almacen_e.fecha) <'$fechaDe' 
        UNION";
      }

      $resultado = $this->link->query("
        $condicionBusquedaRango
        SELECT
          almacen_d.id,
          almacen_e.folio AS no_movimiento,
          DATE(almacen_e.fecha) AS fecha,
          almacen_d.cve_concepto AS clave,
          productos.concepto AS concepto,
          trabajadores.id_trabajador AS id_trabajador,
          proveedores.id AS id_proveedor,
          IFNULL(IF(almacen_e.id_trabajador = 0, proveedores.nombre, CONCAT_WS(' ' , TRIM(trabajadores.nombre), TRIM(trabajadores.apellido_p), TRIM(trabajadores.apellido_m))),'') AS ref,
          almacen_e.referencia AS referencia,
          almacen_d.precio AS precio,
          almacen_d.cantidad AS cantidad,
          IFNULL(CASE almacen_d.cve_concepto 
              WHEN 'E01' THEN CONCAT(almacen_d.cve_concepto, ' - ','RECEPCIÓN DE MERCANCÍAS Y SERVICIOS')
              WHEN 'E02' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA DE UNIFORMES') 
              WHEN 'E03' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR TRANSFERENCIA SUCURSAL')
              WHEN 'E05' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR RESPONSIVA')
              WHEN 'E06' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR COMODATO')
              WHEN 'E07' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR STOCK')
              WHEN 'E08' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR PRODUCCION')
              WHEN 'E09' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR RECICLAJE')
              WHEN 'E99' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR AJUSTE')
              WHEN 'S01' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR STOCK')
              WHEN 'S02' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA DE UNIFORMES') 
              WHEN 'S03' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR TRANSFERENCIA SUCURSAL')
              WHEN 'S04' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR DEVOLUCION A PROVEEDOR')
              WHEN 'S05' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR RESPONSIVA')
              WHEN 'S06' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR COMODATO')
              WHEN 'S07' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR VENTA')
              WHEN 'S08' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR PRODUCCION')
              WHEN 'S10' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR ACTIVO FIJO')
              WHEN 'S12' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR CONSUMO')
              WHEN 'S99' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR AJUSTE') 
          END,'') AS concepto_mov
        FROM productos
        INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
        INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
        LEFT JOIN proveedores ON almacen_e.id_proveedor = proveedores.id
        LEFT JOIN trabajadores ON almacen_e.id_trabajador =  trabajadores.id_trabajador
        WHERE almacen_e.id_sucursal = $idSucursal AND almacen_e.estatus != 'C'
        AND productos.id = $idProducto
        $and
        GROUP BY almacen_d.id");
      
      return query2json($resultado);

    }

    function reporteDetallado($idUnidad, $idSucursal, $idFamilia, $idLinea, $idProducto, $concepto, $fechaDe, $fechaA){

      $and = " ";

      if($idSucursal != '')
        $and .= " AND almacen_e.id_sucursal = $idSucursal"; 

      if($idFamilia != '')
        $and .= " AND productos.id_familia = $idFamilia"; 

      if($idLinea != '')
        $and .= " AND productos.id_linea = $idLinea"; 

      if($idProducto != '')
        $and .= " AND productos.id = $idProducto"; 

      if($idLinea != '')
        $and .= " AND productos.id_linea = $idLinea"; 

      if($fechaDe != '')
        $and .= " AND almacen_e.fecha >= '$fechaDe'";      

      if($fechaA != '')
        $and .= " AND almacen_e.fecha <= '$fechaA'";

      $query = "SELECT
                  almacen_e.id AS no_movimiento,
                  almacen_d.cve_concepto AS cve_concepto,
                  IFNULL(CASE almacen_d.cve_concepto 
                    WHEN 'E01' THEN CONCAT(almacen_d.cve_concepto, ' - ','RECEPCIÓN DE MERCANCÍAS Y SERVICIOS')
                    WHEN 'E02' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA DE UNIFORMES') 
                    WHEN 'E03' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR TRANSFERENCIA SUCURSAL')
                    WHEN 'E05' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR RESPONSIVA')
                    WHEN 'E06' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR COMODATO')
                    WHEN 'E07' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR STOCK')
                    WHEN 'E08' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR PRODUCCION')
                    WHEN 'E09' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR RECICLAJE')
                    WHEN 'E99' THEN CONCAT(almacen_d.cve_concepto, ' - ','ENTRADA POR AJUSTE')
                    WHEN 'S01' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR STOCK')
                    WHEN 'S02' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA DE UNIFORMES') 
                    WHEN 'S03' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR TRANSFERENCIA SUCURSAL')
                    WHEN 'S04' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR DEVOLUCION A PROVEEDOR')
                    WHEN 'S05' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR RESPONSIVA')
                    WHEN 'S06' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR COMODATO')
                    WHEN 'S07' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR VENTA')
                    WHEN 'S08' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR PRODUCCION')
                    WHEN 'S10' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR ACTIVO FIJO')
                    WHEN 'S12' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR ACTIVO CONSUMO')
                    WHEN 'S99' THEN CONCAT(almacen_d.cve_concepto, ' - ','SALIDA POR AJUSTE') 
                  END,'') AS concepto_mov,
                  DATE(almacen_e.fecha) AS fecha,
                  IFNULL(familias.descripcion,'') AS familia,
                  IFNULL(lineas.descripcion,'') AS linea,
                  IFNULL(productos.id,'') AS id_producto,
                  IFNULL(productos.concepto,'') as concepto,
                  IFNULL(IF(almacen_e.id_trabajador = 0, proveedores.nombre, CONCAT_WS(' ' , TRIM(trabajadores.nombre), TRIM(trabajadores.apellido_p), TRIM(trabajadores.apellido_m))),'') AS ref,
                  almacen_d.cantidad AS cantidad,
                  almacen_d.precio AS precio,
                  IF('$idSucursal' = '', IFNULL(productos_unidades.ultimo_precio_compra, 0),IFNULL((SELECT costo_compra FROM productos_sucursales WHERE fk_id_producto = productos.id AND fk_id_sucursal = '$idSucursal'), IFNULL(productos_unidades.ultimo_precio_compra, 0))) AS ultimo_precio,
                  IFNULL(productos_unidades.ultima_fecha_compra, '0000-00-00') AS ultima_fecha
                FROM productos
                INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
                INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
                INNER JOIN familias ON productos.id_familia = familias.id
                INNER JOIN lineas ON productos.id_linea = lineas.id
                LEFT JOIN productos_unidades ON productos.id = productos_unidades.id_producto AND productos_unidades.id_unidades = $idUnidad
                LEFT JOIN proveedores ON almacen_e.id_proveedor = proveedores.id
                LEFT JOIN trabajadores ON almacen_e.id_trabajador =  trabajadores.id_trabajador
                WHERE almacen_e.id_unidad_negocio = $idUnidad and almacen_e.estatus != 'C'
                        $and
                ORDER BY productos.id ASC,almacen_e.id ASC";
                
                // error_log( $query);
                // exit();

      $resultado = $this->link->query($query);
      
      return query2json($resultado);

    }

    function reporteAcumulado($idUnidad, $idSucursal, $idFamilia, $idLinea, $idProducto, $fechaDe, $fechaA)
    {


      $and = " ";
      $andFN = " ";
      $andFD = " ";
      $having = " ";

      if($idSucursal != '')
        $and .= " AND almacen_e.id_sucursal = $idSucursal"; 

      if($idFamilia != '')
        $and .= " AND productos.id_familia = $idFamilia"; 

      if($idLinea != '')
        $and .= " AND productos.id_linea = $idLinea"; 

      if($idProducto != '')
        $and .= " AND productos.id = $idProducto"; 

      if($idLinea != '')
        $and .= " AND productos.id_linea = $idLinea"; 

      if($fechaDe != '')
      {
        //$andFN .= " AND almacen_e.fecha <= '$fechaDe'";
        //-->NJES August/24/2020 para la existencia inicial considerar del inicio de los tiempos a la fecha inicio
        $andFD .= " AND DATE(almacen_e.fecha) <='$fechaDe'";
      }
      else
       $having .= " HAVING almacen_e.fecha =  MIN(DATE(almacen_e.fecha))"; 

      if($fechaA != '')
      {
        //-->NJES August/24/2020 para la existencia inicial considerar del inicio de los tiempos a la fecha fin
        $andFN .= " AND almacen_e.fecha <= '$fechaA'";
      }

      
      //-->NJES August/24/2020 para las entradas y salidas considerar los rangos de fechas capturadas
      if($fechaDe == '' && $fechaA == '')
      {
        $condFecha="";
      }else if($fechaDe != '' &&  $fechaA == '')
      {
        $condFecha=" AND almacen_e.fecha >= '$fechaDe' ";
      }else if($fechaDe == '' &&  $fechaA != '')
      {
        $condFecha=" AND almacen_e.fecha <= '$fechaA' ";
      }else{  //-->trae fecha inicio y fecha fin
        $condFecha=" AND DATE(almacen_e.fecha) BETWEEN '$fechaDe' AND '$fechaA' ";
      }

      //-->la existencia fin deberia de ser la suma de la existencia inicial + entradas - salidas

      $query="SELECT
            productos.id AS id_producto,
            IFNULL(familias.descripcion,'') AS familia,
            IFNULL(lineas.descripcion,'') AS linea,
            IFNULL(productos.concepto,'') AS concepto,

            IF(existencias_iniciales.existencia_i IS NULL, 0 , existencias_iniciales.existencia_i) AS existencia_inicial,
            IF(entradas.cantidad_entradas IS NULL, 0, entradas.cantidad_entradas) AS entradas,
            IF(salidas.cantidad_salidas IS NULL, 0, salidas.cantidad_salidas) AS salidas,
            existencias_finales.existencia_f AS existencia_final,

            IFNULL(productos_unidades.ultimo_precio_compra, 0) AS ultimo_precio,
            IFNULL(productos_unidades.ultima_fecha_compra, '0000-00-00') AS ultima_fecha,
            IFNULL((existencias_finales.existencia_f*productos_unidades.ultimo_precio_compra),0) AS valor_inventario
            FROM productos
            INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
            INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
            INNER JOIN familias ON productos.id_familia = familias.id
            INNER JOIN lineas ON productos.id_linea = lineas.id
            LEFT JOIN productos_unidades ON productos.id = productos_unidades.id_producto AND productos_unidades.id_unidades = $idUnidad
            LEFT JOIN proveedores ON almacen_e.id_proveedor = proveedores.id
            LEFT JOIN trabajadores ON almacen_e.id_trabajador =  trabajadores.id_trabajador

            LEFT JOIN 
            (
            SELECT 
            productos.id AS id_producto,
            almacen_e.fecha as f,
            SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia_i
            FROM productos
            INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
            INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
            WHERE almacen_e.id_unidad_negocio = $idUnidad AND almacen_e.estatus != 'C'
            $and
            $andFD
            GROUP BY productos.id
            $having
            ) existencias_iniciales ON productos.id = existencias_iniciales.id_producto

            INNER JOIN 
            (
            SELECT 
            almacen_d.id_producto AS id_producto,
            SUM(almacen_d.cantidad) AS cantidad_entradas
            FROM almacen_d
            INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
            INNER JOIN productos ON almacen_d.id_producto = productos.id
            WHERE SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E' AND almacen_e.estatus != 'C'
            $and
            $condFecha
            GROUP BY almacen_d.id_producto
            ) entradas ON productos.id = entradas.id_producto

            LEFT JOIN 
            (
            SELECT 
            almacen_d.id_producto AS id_producto,
            SUM(almacen_d.cantidad) AS cantidad_salidas
            FROM almacen_d
            INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
            INNER JOIN productos ON almacen_d.id_producto = productos.id
            WHERE SUBSTR(almacen_d.cve_concepto, 1, 1) = 'S' 
            AND almacen_e.id_unidad_negocio = $idUnidad AND almacen_e.estatus != 'C'
            $and
            $condFecha
            GROUP BY almacen_d.id_producto
            ) salidas ON productos.id = salidas.id_producto


            LEFT JOIN 
            (
            SELECT 
            productos.id AS id_producto,
            SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia_f
            FROM productos
            INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
            INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
            WHERE almacen_e.id_unidad_negocio = $idUnidad AND almacen_e.estatus != 'C'
            $and
            $andFN
            GROUP BY productos.id
            ) existencias_finales ON productos.id = existencias_finales.id_producto

            WHERE almacen_e.id_unidad_negocio = $idUnidad
            $and
            $andFN
            GROUP BY productos.id";

      // echo $query;
      // exit();

      $resultado = $this->link->query($query);

      return query2json($resultado);

    }


    function buscaFoliosActivoFijos($idSucursal){

      $condicionSucursal='';

      if($idSucursal>0){
        $condicionSucursal = " AND id_sucursal=".$idSucursal;
      }

      //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
      //-->NJES November/11/2020 no mostrar los productos de familia gasto FLETES Y LOGISTICA, de ese ya se afecto el presupuesto en la recepción de mercancia
      /*$resultado = $this->link->query("SELECT 
        SUM(sub.id_e)AS id_e,
        SUM(sub.id_d)AS id_d,
        SUM(sub.partida)AS partida,
        sub.folio,
        sub.id_producto,
        sub.cve_concepto,
        sub.id_sucursal, 
        sub.id_unidad_negocio,
        SUM( IF(SUBSTR(sub.cve_concepto, 1, 1) = 'E', sub.cantidad, sub.cantidad*-1)) AS cantidad,
        s.descr AS sucursal,
        p.concepto,
        IFNULL(p.descripcion,'') AS descripcion,
        f.descripcion AS familia,
        l.descripcion AS linea,
        f.id_familia_gasto
      FROM(
            SELECT
              b.id AS id_e, 
              a.id AS id_d, 
              a.partida,
              a.cantidad AS cantidad,
              a.id_producto,
              b.cve_concepto,
              b.folio,
              b.id_sucursal,
              b.id_unidad_negocio,
              b.id_activo_fijo
            FROM almacen_d a
            LEFT JOIN almacen_e b ON a.id_almacen_e=b.id
            WHERE a.id_almacen_e=ANY(SELECT id FROM almacen_e WHERE  cve_concepto = 'E01' $condicionSucursal AND tipo_oc='0' AND estatus!='C') AND a.estatus!='C'
            UNION 
            SELECT 
              0 AS id_e,
              0 AS id_d,
              0 AS partida,
              SUM(a.cantidad) AS cantidad,
              a.id_producto,
              b.cve_concepto,
              b.folio_recepcion AS folio,
              b.id_sucursal,
              b.id_unidad_negocio,
              b.id_activo_fijo
            FROM almacen_d a
            LEFT JOIN almacen_e b ON a.id_almacen_e=b.id
            WHERE a.id_almacen_e=ANY(SELECT id FROM almacen_e WHERE cve_concepto = 'S10' $condicionSucursal AND estatus!='C' AND folio_recepcion>0) AND a.estatus!='C'
            GROUP BY b.folio_recepcion,a.id_producto
      ) AS sub
      LEFT JOIN  sucursales s ON sub.id_sucursal=s.id_sucursal
      LEFT JOIN productos p ON sub.id_producto=p.id
      LEFT JOIN familias f ON p.id_familia=f.id
      LEFT JOIN lineas l ON p.id_linea=l.id
      WHERE f.id_familia_gasto!=104 AND sub.id_activo_fijo IS NULL 
      GROUP BY sub.id_sucursal,sub.folio,sub.id_producto
      HAVING cantidad >0
      ORDER BY sub.id_sucursal,sub.id_d ASC");*/

      $resultado = $this->link->query("SELECT 
      almacen_e.folio,
      almacen_e.id AS id_e,
      almacen_d.id AS id_d,
      almacen_e.id_unidad_negocio,
      almacen_e.id_sucursal,
      almacen_d.id_producto,
      sucursales.descr AS sucursal,
      productos.concepto,
      IFNULL(productos.descripcion,'') AS descripcion,
      familias.descripcion AS familia,
      lineas.descripcion AS linea,
      familias.id_familia_gasto,
      SUM(almacen_d.partida) AS partida,
      -- (SUM(almacen_d.cantidad) - salidas.cantidad) AS cantidad
      (SUM(almacen_d.cantidad) - IFNULL(salidas.cantidad, 0)) AS cantidad
      FROM almacen_e
      INNER JOIN almacen_d ON almacen_e.id=almacen_d.id_almacen_e
      LEFT JOIN (
      SELECT almacen_e.folio_recepcion,
      almacen_e.id AS id_e,almacen_d.id AS id_d,almacen_d.id_producto,SUM(almacen_d.cantidad) AS cantidad,
      almacen_e.id_sucursal
      FROM almacen_e
      LEFT JOIN almacen_d ON almacen_e.id=almacen_d.id_almacen_e
      WHERE almacen_e.cve_concepto = 'S10' AND almacen_e.estatus!='C' AND almacen_e.folio_recepcion>0
      GROUP BY almacen_e.id_sucursal,almacen_e.folio_recepcion,almacen_d.id_producto
      ) AS salidas ON almacen_e.folio=salidas.folio_recepcion AND salidas.id_sucursal=almacen_e.id_sucursal
      INNER JOIN  sucursales ON almacen_e.id_sucursal=sucursales.id_sucursal
      INNER JOIN productos ON almacen_d.id_producto=productos.id
      INNER JOIN familias ON productos.id_familia=familias.id
      INNER JOIN lineas ON productos.id_linea=lineas.id
      WHERE almacen_e.cve_concepto = 'E01' AND almacen_e.tipo_oc='0' AND almacen_e.estatus!='C' AND familias.id_familia_gasto!=104
      GROUP BY almacen_e.id_sucursal,almacen_e.folio,almacen_d.id_producto
      HAVING cantidad > 0
      ORDER BY almacen_d.id_producto ASC,almacen_e.id_sucursal ASC,almacen_d.id ASC");
      
      return query2json($resultado);
    }

    function buscarComodatosAlmacenReporte($datos){
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
            $fecha=" AND a.fecha >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
            $fecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        //-->NJES March/18/2021 tipo 0 = acumulado, tipo 1 = detallado
        if($tipo == 0)
        {
          $resultado = $this->link->query("SELECT a.id,a.folio,c.descr AS sucursal,DATE(a.fecha) AS fecha,
                      a.no_partidas AS partidas,SUM(d.precio*d.cantidad) AS importe_total,
                      IFNULL(f.descripcion,'') AS area,
                      IFNULL(e.des_dep,'') AS departamento,
                      IFNULL(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS supervisor
                      FROM almacen_e a
                      LEFT JOIN usuarios b ON a.id_usuario_captura=b.id_usuario
                      LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                      LEFT JOIN almacen_d d ON a.id=d.id_almacen_e
                      LEFT JOIN deptos e ON a.id_departamento=e.id_depto
                      LEFT JOIN cat_areas f ON e.id_area=f.id
                      LEFT JOIN trabajadores g ON e.id_supervisor=g.id_trabajador
                      WHERE a.id_contrapartida=0 AND a.cve_concepto IN ('S06','E06') AND a.id_unidad_negocio=$idUnidadNegocio 
                      $sucursal $fecha
                      GROUP BY a.id
                      ORDER BY a.id");
        }else{
          $resultado = $this->link->query("SELECT a.id,a.folio,c.descr AS sucursal,DATE(a.fecha) AS fecha,
                        IFNULL(f.descripcion,'') AS area,
                        IFNULL(e.des_dep,'') AS departamento,
                        IFNULL(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS supervisor,
                        productos.concepto AS producto,
                        d.precio,d.cantidad,(d.precio*d.cantidad) AS importe_total
                        FROM almacen_d d
                        LEFT JOIN productos ON d.id_producto=productos.id
                        LEFT JOIN almacen_e a ON d.id_almacen_e=a.id
                        LEFT JOIN usuarios b ON a.id_usuario_captura=b.id_usuario
                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                        LEFT JOIN deptos e ON a.id_departamento=e.id_depto
                        LEFT JOIN cat_areas f ON e.id_area=f.id
                        LEFT JOIN trabajadores g ON e.id_supervisor=g.id_trabajador
                        WHERE a.id_contrapartida=0 AND a.cve_concepto IN ('S06','E06') AND a.id_unidad_negocio=$idUnidadNegocio 
                        $sucursal $fecha
                        ORDER BY a.id");
        }

        return query2json($resultado);
      }else{  
        $arr = array();

        return json_encode($arr);
      }
    }

}//--fin de class Almacenes

?>