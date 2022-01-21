<?php

include 'conectar.php';

class Clientes
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Clientes()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la nombreComercial del cliente no se repita
      *
      * @param varchar $nombreComercial  usado para indentificar en las Búsqueda de  des un cliente
      *
    **/
    function verificarClientes($nombreComercial){
      
      $verifica = 0;

      $query = "SELECT id FROM cat_clientes WHERE nombre_comercial = '$nombreComercial'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaClientes

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una cliente
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización

      *
    **/      
    function guardarClientes($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarClientes


     /**
      * Guarda los datos de una cliente, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del cliente para realizarla
      * @param varchar $clave es una clave para identificar una cliente en particular
      * @param varchar $descripcion brebe descripcion de una cliente
      * @param int $ininactivo estatus de una cliente  1='inactivo' 0='Ininactivo'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idCliente = $datos[1]['idCliente'];
        $tipoMov = $datos[1]['tipoMov'];
        $fechaInicio = $datos[1]['fechaInicio'];
        $nombreComercial = $datos[1]['nombreComercial'];
        $datosContacto = $datos[1]['datosContacto'];
        $inactivo = $datos[1]['inactivo'];
        if($tipoMov==0){

          $query = "INSERT INTO cat_clientes(nombre_comercial, fecha_inicio, datos_contacto) VALUES ('$nombreComercial','$fechaInicio','$datosContacto')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idCliente = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_clientes SET nombre_comercial='$nombreComercial',fecha_inicio='$fechaInicio',datos_contacto='$datosContacto',inactivo='$inactivo' WHERE id=".$idCliente;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idCliente;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una cliente, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=ininactivo 2=todos
      *
      **/
      function buscarClientes($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE inactivo=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE inactivo=0';
        }

        $resultado = $this->link->query("SELECT id,nombre_comercial,fecha_inicio,IF(inactivo=0,'ACTIVO','INACTIVO') AS estatus 
        FROM cat_clientes
        $condicionEstatus
        ORDER BY nombre_comercial");
        return query2json($resultado);

      }//- fin function buscarClientes

      function buscarClientesId($idCliente){
        
        $resultado = $this->link->query("SELECT id,nombre_comercial,fecha_inicio,datos_contacto,inactivo      
        FROM cat_clientes
        WHERE id=$idCliente
        ORDER BY id");
        return query2json($resultado);
          

      }//- fin function buscarClientesId

      /**
      * Busca los el total de saldos por cliente, razones sociales de cliente y facturas de razones social
      * 
      * @param varchar $datos array que contiene los datos para la busqueda
      * $id    filtro para busqueda (idCliente/idRazonSocial)
      * $tipo    1=saldos clientes  2=saldos razones sociales clientes    3=saldos facturas razón social
      *
      **/
      function buscarSaldosClientes($datos){
        $id = isset($datos['id']) ? $datos['id'] : 0;
        $tipo = $datos['tipo'];

        if($tipo == 1)
        {

            $query = "SELECT                  
            SUM(facturas.total - facturas.importe_retencion) - (pagos.total_pagos + (IFNULL(notas.total_notas, 0))) AS total,
		facturas.id_cliente AS id,
		cat_clientes.nombre_comercial AS razon_social,
		cat_clientes.nombre_comercial AS nombre_comercial
      FROM facturas
              INNER JOIN cat_clientes ON facturas.id_cliente =  cat_clientes.id
              INNER JOIN
              (
			SELECT 
			pagos_e.id_cliente,
		SUM(pagos_d.importe_pagado) AS total_pagos
FROM
pagos_e
INNER JOIN pagos_d  ON pagos_e.id = pagos_d.id_pago_e
			-- LEFT JOIN pagos_p  ON pagos_e.id = pagos_p.id_pago_e
			WHERE pagos_e.id_unidad_negocio != 2  AND pagos_e.estatus IN ('A', 'T' )
			GROUP  BY pagos_e.id_cliente
			
			
              ) pagos  ON facturas.id_cliente = pagos.id_cliente
              
              LEFT JOIN
              (
			SELECT 
			facturas.id_cliente,
			SUM(facturas.total - facturas.importe_retencion) AS total_notas
			FROM
			facturas
			WHERE facturas.id_unidad_negocio != 2  AND facturas.estatus IN ('A', 'T' )
			AND facturas.id_factura_nota_credito > 0 
			GROUP  BY facturas.id_cliente
			
			
              ) notas  ON facturas.id_cliente = notas.id_cliente
              
              WHERE  facturas.estatus IN('A','T') AND facturas.id_factura_nota_credito = 0
              AND facturas.id_unidad_negocio != 2
              GROUP BY facturas.id_cliente";

            $result = $this->link->query($query);
            
        }else if($tipo == 2)
        {
            
              $query = "SELECT
              SUM(facturas.total - facturas.importe_retencion) -  (IFNULL(pagos.total_pagos, 0) + (IFNULL(notas.total_notas, 0)))  AS total,
              facturas.id_razon_social AS id,
              razones_sociales.razon_social AS razon_social,
              cat_unidades_negocio.nombre AS unidad,
              sucursales.descr AS sucursal,
              razones_sociales.nombre_corto AS nombre_corto
              FROM facturas
              INNER JOIN cat_unidades_negocio ON facturas.id_unidad_negocio=cat_unidades_negocio.id
              INNER JOIN sucursales ON facturas.id_sucursal=sucursales.id_sucursal
              INNER JOIN razones_sociales ON facturas.id_razon_social =  razones_sociales.id
              left JOIN
              (
              SELECT 
              pagos_e.id_razon_social, 
              SUM(pagos_d.importe_pagado) AS total_pagos
              FROM
              pagos_e
              INNER JOIN pagos_d  ON pagos_e.id = pagos_d.id_pago_e
              WHERE pagos_e.id_unidad_negocio != 2  AND pagos_e.estatus IN ('A', 'T' )
              AND pagos_e.id_cliente = " . $id . "
              GROUP  BY pagos_e.id_razon_social
                
              
              ) pagos  ON facturas.id_razon_social = pagos.id_razon_social
              
              LEFT JOIN
              (
              SELECT 
              facturas.id_razon_social,
              SUM(facturas.total - facturas.importe_retencion) AS total_notas
              FROM
              facturas
              WHERE facturas.id_unidad_negocio != 2  AND facturas.estatus IN ('A', 'T' )
              AND facturas.id_factura_nota_credito > 0 AND facturas.id_cliente = " . $id . "
              GROUP  BY facturas.id_razon_social
              
              
              ) notas  ON facturas.id_razon_social = notas.id_razon_social
              
              WHERE  facturas.estatus IN('A','T') AND facturas.id_factura_nota_credito = 0
              AND facturas.id_unidad_negocio != 2 AND facturas.id_cliente = " . $id . "
              GROUP BY facturas.id_razon_social";

                        
           $result = $this->link->query($query);
                        
        }else{
          //-->NJES November/20/2020 agregar campos
          $query = "SELECT 
            facturas.id,
            facturas.folio,
            facturas.fecha,
            'F' AS tipo,
            facturas.id AS  id_factura,
            (facturas.total - (facturas.importe_retencion - facturas.descuento)) AS monto_factura,
            IFNULL(facturas.fecha_inicio, '') AS fecha_inicio,
            IFNULL(facturas.fecha_fin, '') AS fecha_fin,
            CASE 
              WHEN ((facturas.total - facturas.importe_retencion) - (IFNULL(pagos.total_pagos, 0) + (IFNULL(notas.total_notas, 0)))) = 0 THEN 'PAGADA'
              WHEN facturas_cfdi.estatus = 'A' THEN 'SIN TIMBRAR'
              WHEN facturas_cfdi.estatus = 'P' THEN 'PENDIENTE CANCELAR'
              WHEN facturas_cfdi.estatus = 'C' THEN 'CANCELADA'
              ELSE 'TIMBRADA'
            END AS estatus,

            /*
            WHEN facturas.estatus = 'A' THEN 'SIN TIMBRAR'
              WHEN facturas.estatus = 'P' THEN 'PENDIENTE CANCELAR'
              WHEN facturas.estatus = 'C' THEN 'CANCELADA'
              ELSE 'TIMBRADA'
            END AS estatus,
            */
            -- IFNULL(cxc.vencimiento,'') AS vencimiento,
            DATE_ADD(facturas.fecha, INTERVAL IFNULL(facturas.dias_credito,0) DAY) AS vencimiento,
            IFNULL(pagos.folios_pagos,'') AS folios_pagos,
            IFNULL(pagos.fechas_pagos,'') AS fechas_pagos,
            IFNULL(pagos.total_pagos, 0) AS pago,
            (IFNULL(notas.total_notas, 0)) AS nota_credito,
            (IFNULL(pagos.total_pagos, 0) + (IFNULL(notas.total_notas, 0))) AS abonos,
            (facturas.total - facturas.importe_retencion) - (IFNULL(pagos.total_pagos, 0) + (IFNULL(notas.total_notas, 0))) AS saldo
              FROM facturas
               left join cxc on cxc.id_factura = facturas.id
               left join facturas_cfdi on facturas.id = facturas_cfdi.id_factura
              INNER JOIN razones_sociales ON facturas.id_razon_social =  razones_sociales.id
              LEFT JOIN
              (
              SELECT
              GROUP_CONCAT(pagos_e.folio,' ') AS folios_pagos,
	            GROUP_CONCAT(DATE(pagos_e.fecha),' ') AS fechas_pagos,
              pagos_d.id_factura,
              SUM(pagos_d.importe_pagado) AS total_pagos
              FROM
              pagos_e
              INNER JOIN pagos_d  ON pagos_e.id = pagos_d.id_pago_e
              WHERE pagos_e.id_unidad_negocio != 2  AND pagos_e.estatus IN ('A', 'T' )
              AND pagos_e.id_razon_social =  " . $id . "
              GROUP BY pagos_d.id_factura

              ) pagos  ON facturas.id = pagos.id_factura

              LEFT JOIN
              (
              SELECT 
              facturas.id_factura_nota_credito AS id_factura,
              SUM(facturas.total - facturas.importe_retencion) AS total_notas
              FROM
              facturas
              WHERE facturas.id_unidad_negocio != 2  AND facturas.estatus IN ('A', 'T' )
              AND facturas.id_factura_nota_credito > 0 AND facturas.id_razon_social =  " . $id . "
              GROUP BY facturas.id_factura_nota_credito

              ) notas  ON facturas.id = notas.id_factura
              WHERE facturas.id_razon_social =   " . $id . "  AND facturas.estatus IN('A','T') AND facturas.id_factura_nota_credito = 0 AND facturas.id_unidad_negocio != 2
              GROUP BY facturas.id";

            $result = $this->link->query($query);
        }
        
        return query2json($result);
      }//- fin function buscarSaldosClientes

  
      /**
      * Busca los el total de saldos por cliente, razones sociales de cliente y facturas de razones socia para alarmas
      * 
      * @param varchar $datos array que contiene los datos para la busqueda
      * $id    filtro para busqueda (idCliente/idRazonSocial)
      * $tipo    1=saldos clientes  2=saldos razones sociales clientes    3=saldos facturas razón social
      *
      **/
      function buscarSaldosClientesAlarmas($datos){
        $id = isset($datos['id']) ? $datos['id'] : 0;
        $tipo = $datos['tipo'];

        if($tipo == 1)
        {
            $query = "SELECT  
            fn.id_cliente AS id,
            IFNULL(TRIM(a.razon_social),'') AS razon_social,
            SUM(IF(fn.tipo IN ('N','P'),fn.total*-1,fn.total)) AS total
            FROM (
              SELECT id_unidad_negocio,
               id_razon_social,
                id_cliente,
                folio,
                fecha,
                'F' AS tipo,
                id AS  id_factura,
                IF(retencion=1,SUM(total)-SUM(importe_retencion),SUM(total)) AS total
              FROM facturas 
              WHERE  estatus IN('A','T') AND id_factura_nota_credito=0 AND id_unidad_negocio=2
              GROUP BY id_cliente
              UNION ALL
              SELECT id_unidad_negocio,
                   id_razon_social,
                id_cliente,
                folio,fecha,
                'N' AS tipo,
                id_factura_nota_credito AS id_factura,
                SUM(total) AS total
              FROM facturas 
              WHERE estatus IN('A','T') AND id_factura_nota_credito!=0 AND id_unidad_negocio=2
              GROUP BY id_cliente 
              UNION ALL
              SELECT a.id_unidad_negocio,
                a.id_razon_social,
                a.id_cliente,
                b.folio_factura AS folio,
                DATE(a.fecha) AS fecha,
                'P' AS tipo,                  
                b.id_factura AS id_factura,
                IFNULL(SUM(b.importe_pagado),0) AS total
              FROM pagos_e a
              LEFT JOIN pagos_d b ON a.id=b.id_pago_e
              WHERE a.estatus IN('T') AND id_unidad_negocio=2
              GROUP BY a.id_cliente
              UNION ALL 
              SELECT a.id_unidad_negocio,
                a.id_razon_social,
                IFNULL(b.id_cliente,0) AS id_cliente,
                a.folio_cxc AS folio,
                a.fecha,
                'C' AS tipo,
                a.id_factura,
                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),a.total,((a.total) * -(1))),0)),0) AS total
              FROM cxc a
              LEFT JOIN razones_sociales b ON a.id_razon_social=b.id
              WHERE a.estatus!='C' AND a.id_factura=0 AND a.id_nota_credito=0 AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0 AND a.id_razon_social>0 AND id_unidad_negocio=2
              GROUP BY b.id_cliente
            ) AS fn
            LEFT JOIN servicios a ON fn.id_cliente=a.id
            WHERE !ISNULL(fn.id_cliente) 
            GROUP BY fn.id_cliente
            ORDER BY a.razon_social";

            $result = $this->link->query($query);
            
        }else if($tipo == 2)
        {
            $query = "SELECT 
              facturas.id,folio,facturas.fecha,'F' AS tipo,facturas.id AS  id_factura,
              (facturas.total - facturas.importe_retencion) AS total_factura,
              (facturas.total - facturas.importe_retencion) - (IFNULL(pagos.total_pagos, 0) + (IFNULL(notas.total_notas, 0))) AS total,
              facturas.fecha_inicio,facturas.fecha_fin 
              FROM facturas
              INNER JOIN razones_sociales ON facturas.id_razon_social =  razones_sociales.id
              LEFT JOIN
              (
              SELECT
              pagos_d.id_factura,
              SUM(pagos_d.importe_pagado) AS total_pagos
              FROM
              pagos_e
              INNER JOIN pagos_d  ON pagos_e.id = pagos_d.id_pago_e
              WHERE pagos_e.id_unidad_negocio != 2  AND pagos_e.estatus IN ('A', 'T' )
              AND pagos_e.id_razon_social =  " . $id . "
              GROUP BY pagos_d.id_factura

              ) pagos  ON facturas.id = pagos.id_factura

              LEFT JOIN
              (
              SELECT 
              facturas.id_factura_nota_credito AS id_factura,
              SUM(facturas.total - facturas.importe_retencion) AS total_notas
              FROM
              facturas
              WHERE facturas.id_unidad_negocio != 2  AND facturas.estatus IN ('A', 'T' )
              AND facturas.id_factura_nota_credito > 0 AND facturas.id_razon_social =  " . $id . "
              GROUP BY facturas.id_factura_nota_credito

              ) notas  ON facturas.id = notas.id_factura
              WHERE facturas.id_razon_social =   " . $id . "  AND facturas.estatus IN('A','T') AND facturas.id_factura_nota_credito = 0 AND facturas.id_unidad_negocio != 2
              GROUP BY facturas.id";

            $result = $this->link->query($query);
        }
        
        return query2json($result);
      }//- fin function buscarSaldosClientes

    
}//--fin de class Clientes
    
?>