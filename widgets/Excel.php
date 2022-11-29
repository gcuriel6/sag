<?php

include 'conectar.php';

class Excel
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Excel()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Buscamos registros y generamos archivo excel
      *
      * @param varchar $nombre que se le dara al archivo
      * @param varchar $modulo para ver cual quert se va a generar
      * @param varchar $fecha para componer el nombre del archivo
      *
    **/
    function generaExcel($nombre,$modulo,$fecha,$datos){
        
        header("Content-type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: filename=" .$nombre. "_" .$fecha. ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $html='';

        if($modulo == 'COSTO_ADMINISTRATIVO'){

            $query="SELECT a.costo AS COSTO,IF(a.activo=1,'Activo','Inactivo') AS ESTATUS,b.nombre AS UNIDAD_NEGOCIO, c.descripcion AS SUCURSAL
                        FROM cat_costos_administrativos a 
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                        ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo == 'SUCURSALES'){

            $query="SELECT a.clave AS CLAVE,a.descripcion AS NOMBRE,a.descr AS DESCRIPCIÓN,a.calle AS CALLE,a.no_exterior AS NUM_EXTERIOR,a.no_interior AS NUM_INTERIOR,a.colonia AS COLONIA,
                        a.codigopostal AS CODIGO_POSTAL,IFNULL(c.pais,'') AS PAIS,IFNULL(d.estado,'') AS ESTADO,IFNULL(e.municipio,'') AS MUNICIPIO,
                        IF(a.nomina=0,'No','Si') AS NOMINA,IF(a.activo=1,'Activo','Inactivo') AS ESTATUS,b.nombre AS UNIDAD_NEGOCIO,
                        IF(IFNULL(f.id_sucursal,0)=0,'No','Si') AS DESCUENTO_DIA,IF(IFNULL(g.id_sucursal,0)=0,'No','Si') AS ANTICIPO,
                        IF(IFNULL(h.id_sucursal,0)=0,'No','Si') AS ANTICIPO_ADMINISTRATIVA,IF(IFNULL(i.id_sucursal,0)=0,'No','Si') AS DESCUENTO_CAJA,
                        IFNULL(i.monto,0) AS MONTO_DESCUENTO_CAJA
                        FROM sucursales a
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                        LEFT JOIN paises c ON a.id_pais=c.id
                        LEFT JOIN estados d ON a.id_estado=d.id
                        LEFT JOIN municipios e ON a.id_municipio=e.id
                        LEFT JOIN d28_suc f ON a.id_sucursal=f.id_sucursal
                        LEFT JOIN suc_con_ant g ON a.id_sucursal=g.id_sucursal
                        LEFT JOIN suc_con_ant_a h ON a.id_sucursal=h.id_sucursal
                        LEFT JOIN descuento_caja i ON a.id_sucursal=i.id_sucursal
                        ORDER BY a.id_sucursal";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo == 'PORCENTAJE_UTILIDAD'){
            $query="SELECT a.utilidad AS PORCENTAJE_UTILIDAD,IF(a.activo=1,'Activo','Inactivo') AS ESTATUS,b.nombre AS UNIDAD_NEGOCIO, c.descripcion AS SUCURSAL
                        FROM cat_porcentaje_utilidad a 
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                        ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'FIRMANTES'){
            $query="SELECT nombre AS NOMBRE,telefono AS TELEFONO, email AS EMAIL, iniciales AS INICIALES,IF(firma='','No','Si') AS FIRMA,IF(activo=1,'Activo','Inactivo') AS ESTATUS
                        FROM cat_firmantes 
                        ORDER BY id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo=='USUARIOS'){

            $query="SELECT usuario AS USUARIO,nombre_comp AS NOMBRE_COMPLETO,id_empleado AS ID_EMPLEADO,id_supervisor AS ID_SUPERVISOR,IF(activo=1,'ACTIVO','INACTIVO') AS ESTATUS FROM usuarios ORDER BY id_usuario";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='AREAS'){

            $query="SELECT clave AS CLAVE,descripcion AS DESCRIPCIÓN,IF(activa=1,'ACTIVA','INACTIVA') AS ESTATUS FROM cat_areas ORDER BY clave";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='UNIFORMES'){

            $query="SELECT clave AS CLAVE, nombre as NOMBRE, descripcion AS DESCRIPCIÓN, costo AS COSTO, IF(activo=1,'ACTIVO','INACTIVO') AS ESTATUS FROM cat_uniformes ORDER BY clave";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='SALARIOS'){

            $arreglo = json_decode($datos, true);

            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];

            $unidad='';
            $sucursal='';

            if($idUnidadNegocio != '')
            {
                if($idUnidadNegocio[0] == ',')
                {
                    $dato=substr($idUnidadNegocio,1);
                    $unidad = " AND a.id_unidad_negocio IN($dato) ";
                }else{ 
                    $unidad = " AND a.id_unidad_negocio = $idUnidadNegocio";
                }
            }

            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = " AND a.id_sucursal IN($dato) ";
            }else{ 
                $sucursal = " AND a.id_sucursal = $idSucursal";
            }


            $query="SELECT  b.nombre AS UNIDAD_NEGOCIO,d.descr AS SUCURSAL,c.puesto AS PUESTO,
                        sueldo_mensual AS SUELDO_MENSUAL, 
                        porcentaje_dispersion AS PORCENTAJE_DISPERSION, 
                        sueldo_festivo AS FESTIVO,
                        sueldo_dia31 AS DÍA_31,
                        IFNULL(dias_vacaciones,'') AS DIAS_VACACIONES,
                        IF(a.inactivo=0,'Activo','Inactivo')AS ESTATUS
                        FROM cat_salarios a
                        LEFT JOIN  cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                        LEFT JOIN cat_puestos c ON a.id_puesto=c.id_puesto
                        LEFT JOIN  sucursales d ON a.id_sucursal=d.id_sucursal
                        WHERE 1 $unidad $sucursal
                        ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());  
        }

        if($modulo=='UNIDADES_NEGOCIO'){

            $query="SELECT clave AS CLAVE,nombre AS NOMBRE, IF(inactivo=0,'Activo','Inactivo')AS ESTATUS
                FROM cat_unidades_negocio 
                ORDER BY clave";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='PLANTILLAS_COTIZACIONES'){

            $query="SELECT IF(a.elementos=0,'NO','SI') AS ELEMENTOS,IF(a.equipo=0,'NO','SI') AS EQUIPO,IF(a.servicios=0,'NO','SI') AS SERVICIOS,IF(a.vehiculos=0,'NO','SI') AS VEICULOS,IF(a.consumibles=0,'NO','SI') AS CONSUMIBLES,texto_inicio as TEXTO_INICIO, texto_fin as TEXTO_FIN,tesoreria AS TESORERIA,recursos_humanos AS RECURSOS_HUMANOS,operaciones AS OPERACIONES,compras AS COMPRAS,activos_fijos AS ACTIVOS_FIJOS,a.comercial AS COMERCIAL,a.contraloria AS CONTRALORIA,b.nombre AS UNIDAD_NEGOCIO,IF(a.activo=1,'ACTIVO','INACTIVO') AS ESTATUS
                    FROM cat_plantillas_cotizacion a
                    LEFT JOIN cat_unidades_negocio  b ON a.id_unidad_negocio=b.id
                    ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='ASIGNACION_AUTORIZACIONES'){

            $query="SELECT  b.nombre_comp AS USUARIO, FORMAT(a.monto_minimo,2) AS MONTO_MINIMO, FORMAT(a.monto_maximo,2) AS MONTO_MAXIMO, IF(a.activo=1,'ACTIVO','INACTIVO') AS ESTATUS  FROM cat_autorizaciones a LEFT JOIN usuarios b ON a.id_usuario=b.id_usuario  ORDER BY b.nombre_comp";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='LINEAS'){

            $query="SELECT clave AS CLAVE,descripcion AS DESCRIPCIÓN,IF(inactiva=0,'ACTIVA','INACTIVA') AS ESTATUS FROM lineas ORDER BY id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='FAMILIAS'){
            
            $query="SELECT a.clave AS CLAVE,a.descripcion AS DESCRIPCIÓN,IF(a.tipo=0,'Gasto',IF(a.tipo=1,'Stock',IF(a.tipo=2,'Mantenimiento',IF(a.tipo=3,'Activo Fijo',''))))AS TIPO,
                    IF(a.tallas=0,'No','Si') AS USA_TALLAS,if(a.inactiva=0,'Activa','Inactiva')as ESTATUS,IFNULL(b.descr,'') AS FAMILIA_GASTO
                    FROM familias a
                    LEFT JOIN fam_gastos b ON a.id_familia_gasto=b.id_fam 
                    ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='PRODUCTOS'){

            $query="SELECT
                        productos.clave AS CLAVE,
                        familias.descripcion AS FAMILIA,
                        lineas.descripcion AS LINEA,
                        productos.concepto AS CONCEPTO,
                        productos.descripcion AS DESCRIPCIÓN,
                        productos.costo AS COSTO,
                        IF(productos.servicio=1,'Si','No') AS SERVICIO,
                        productos.codigo_barras AS CODIGO_BARRAS,
                        productos.iva AS IVA,
                        IF(productos.inactivo=0,'Activo','Inactivo') AS ESTATUS,
                        GROUP_CONCAT(cat_unidades_negocio.descripcion)AS UNIDADES
                        FROM productos
                        LEFT JOIN familias ON productos.id_familia = familias.id
                        LEFT JOIN lineas ON productos.id_linea = lineas.id
                        LEFT JOIN productos_unidades ON productos.id = productos_unidades.id_producto
                        LEFT JOIN cat_unidades_negocio ON productos_unidades.id_unidades=cat_unidades_negocio.id
                        GROUP BY productos.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='PROVEEDORES'){
            $query="SELECT 
            a.nombre AS NOMBRE,
            a.rfc AS RFC,
            a.domicilio AS DOMICILIO,
            a.cp AS CP,
            a.colonia AS COLONIA,
            a.num_int AS NO_INT,
            a.num_ext AS NO_EXT,
            IF(a.facturable=1,'Si','No') AS FACTURABLE,
            IFNULL(b.municipio,'') AS MUNICIPIO,
            IFNULL(c.estado,'') AS ESTADO,
            IFNULL(d.pais,'') AS PAIS,
            IFNULL(e.descripcion,'') AS BANCO,    
            a.cuenta AS CUENTA,
            a.clabe AS CLABE,
            a.dias_credito AS DIAS_CREDITO,
            a.telefono AS TELEFONOS,
            a.extension AS EXTENSION,
            a.web AS WEB,
            a.contacto AS CONTACTO,
            a.condiciones AS CONDICIONES,
            a.grupo AS GRUPO,
            IF(a.inactivo=1,'Inactivo','Activo') AS ESTATUS                          
            FROM proveedores a
            LEFT JOIN municipios b ON a.id_municipio=b.id
            LEFT JOIN estados c ON a.id_estado=c.id
            LEFT JOIN paises d ON a.id_pais=d.id
            LEFT JOIN bancos e ON a.id_banco=e.id
            ORDER BY a.id";
            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());    
        }

        if($modulo=='DEPARTAMENTOS'){
            $query="SELECT
            deptos.cve_dep AS CLAVE,
            deptos.des_dep AS DESCRIPCIÓN,
            IF(deptos.inactivo=0,'Activo','Inactivo') AS ESTATUS,
            deptos.domicilio AS DOMICILIO,
            deptos.no_int AS NO_INT,
            deptos.no_ext AS NO_EXT,
            deptos.colonia AS COLONIA,
            deptos.codigo_postal AS CODIGO_POSTAL,
            IFNULL(municipios.municipio,'') AS MUNICIPIO,
            IFNULL(estados.estado,'') AS ESTADO,
            paises.pais AS PAIS,
            IFNULL(deptos.ubicacion,'') AS UBICACION,
            IF(deptos.tipo='O','Operacion','Interno') AS TIPO,
            IFNULL(deptos.inicio_servicio,'') AS INICIO_SERVICIO,
            IFNULL(cat_areas.descripcion,'') AS AREA,
            IFNULL(cat_unidades_negocio.descripcion,'') AS UNIDAD,
            IFNULL(sucursales.descripcion,'') AS SUCURSAL,
            deptos.id_departamento_nomina AS ID_DEPTO_NOMINA,
            IFNULL(CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)),'') AS SUPERVISOR
            FROM deptos 
            LEFT JOIN cat_unidades_negocio ON deptos.id_unidad_negocio=cat_unidades_negocio.id
            LEFT JOIN sucursales ON deptos.id_sucursal = sucursales.id_sucursal
            LEFT JOIN cat_areas ON deptos.id_area=cat_areas.id
            LEFT JOIN municipios ON deptos.id_municipio=municipios.id
            LEFT JOIN estados ON deptos.id_estado=estados.id
            LEFT JOIN paises ON deptos.id_pais=paises.id
            LEFT JOIN trabajadores ON deptos.id_supervisor=trabajadores.id_trabajador
            ORDER BY deptos.id_depto";
            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());    
        }

        if($modulo == 'REPORTES_REQUISICIONES'){
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
            
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idArea = $arreglo['idArea'];
            $idDepartamento = $arreglo['idDepartamento'];
            $idProveedor = $arreglo['idProveedor'];

            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND a.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND a.fecha_pedido >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND DATE(a.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            if($idSucursal != '')
            {
                $sucursal=" AND a.id_sucursal=".$idSucursal;
            }else{
                $sucursal='';
            }

            if($idArea != '')
            {
                $area=" AND a.id_area=".$idArea;
            }else{
                $area='';
            }

            if($idDepartamento != '')
            {
                $departamento=" AND a.id_departamento=".$idDepartamento;
            }else{
                $departamento='';
            }
            
            if($idProveedor != '')
            {
                $proveedor=" AND a.id_proveedor=".$idProveedor;
            }else{
                $proveedor='';
            }

            if($nombre == 'Detalle de Requisiciones')
            {
                $query="SELECT g.id AS ID,
                        a.folio AS FOLIO,
                        b.nombre AS UNIDAD,
                        c.descripcion AS SUCURSAL,
                        d.descripcion AS AREA,
                        e.des_dep AS DEPTO,
                        IFNULL(a.folio_orden_compra,'') AS FOLIO_ORDEN_COMPRA,
                        a.fecha_pedido AS FECHA,
                        IFNULL(a.solicito,'') AS SOLICITO,
                        f.nombre AS PROVEEDOR,
                        g.num_partida AS PARTIDA,
                        j.descripcion AS FAMILIA,
                        i.descripcion AS LINEA,
                        g.descripcion AS DESCRIPCIÓN,
                        g.concepto AS DETALLE,
                        IFNULL(l.unidad_medida,'') AS UNIDAD_MEDIDA,
                        g.cantidad AS CANTIDAD,
                        FORMAT(g.costo_unitario,2) AS COSTO_UNITARIO,
                        FORMAT(IFNULL(g.descuento_total,0),2) AS DESCUENTO_TOTAL,
                        FORMAT(((g.total/100)*g.iva),2) AS PORCENTAJE_IVA,
                        FORMAT(g.total,2) AS IMPORTE_SIN_IVA,
                        FORMAT((((g.total/100)*g.iva)+g.total),2) AS IMPORTE_CON_IVA,
                        IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',
                        IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar', IF(a.estatus = 6, 'Pagada', 'Cancelada') ) )))) AS ESTATUS,
                       
                        -- g.excede_presupuesto,
                          CASE
                              WHEN a.tipo = 0 THEN 'Activo Fijo'
                              WHEN a.tipo = 1 THEN 'Gasto'
                              WHEN a.tipo = 2 THEN 'Mantenimiento'
                              ELSE 'Stock'
                          END AS tipo,
                          IF(IFNULL(n.id_entrada_compra,0)>0,'SI','NO') AS en_portal,
                          IFNULL(m.folio,'') AS folio_recepcion_mercancia

                        FROM requisiciones_d g
                        LEFT JOIN requisiciones a ON g.id_requisicion=a.id
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                        LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                        LEFT JOIN cat_areas d ON a.id_area = d.id
                        LEFT JOIN deptos e ON a.id_departamento = e.id_depto
                        LEFT JOIN proveedores f ON a.id_proveedor = f.id
                        LEFT JOIN productos h ON g.id_producto = h.id
                        LEFT JOIN lineas i ON g.id_linea = i.id
                        LEFT JOIN familias j ON g.id_familia = j.id
                        LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                        LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra

                        LEFT JOIN almacen_e m ON k.id=m.id_oc
                        LEFT JOIN cxp n ON m.id=n.id_entrada_compra

                        WHERE a.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                        GROUP BY g.id
                        ORDER BY a.fecha_pedido";
            }else if($nombre == 'Requisiciones Agrupadas')
            {
                //-->NJES October/28/2020 mostrar quien autorizo una requi fuera de presupuesto o dentro del presupuesto en reporte agrupados
                //-->NJES February/03/2021 Agregar estatus gasto
                $query="SELECT a.id AS ID,
                                a.folio AS FOLIO,
                                IF(a.folio_mantenimiento > 0,a.folio_mantenimiento,'NA') AS FOLIO_MANTENIMIENTO,
                                b.nombre AS UNIDAD,
                                c.descripcion AS SUCURSAL,
                                d.descripcion AS AREA,
                                e.des_dep AS DEPTO,
                                IFNULL(a.folio_orden_compra,'') AS FOLIO_ORDEN_COMPRA,
                                a.fecha_pedido AS FECHA,
                                IF(a.b_anticipo = 1 , 'CON ANTICIPO',  'SIN ANTICIPO') AS ANTICIPO,
                                IFNULL(a.solicito,'') AS SOLICITO,
                                us.usuario as CAPTURO,
                                IFNULL(h.usuario,'NA') AS AUTORIZÓ_FUERA_PRESUPUESTO,
                                IFNULL(j.usuario,'') AS AUTORIZÓ,
                                f.nombre AS PROVEEDOR,
                                a.descripcion AS DESCRIPCIÓN,
                                FORMAT(a.subtotal,2) AS IMPORTE_SIN_IVA,
                                FORMAT(a.total,2) AS IMPORTE_CON_IVA,
                                IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',
                                IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar', IF(a.estatus = 6, 'Pagada', 'Cancelada') ) )))) AS ESTATUS,
                                IFNULL(m.folio,'') AS FOLIO_RECEPCIÓN_MERCANCIA,
                                CASE
                                    WHEN a.tipo = 0 THEN 'Activo Fijo'
                                    WHEN a.tipo = 1 THEN 'Gasto'
                                    WHEN a.tipo = 2 THEN 'Mantenimiento'
                                    ELSE 'Stock'
                                END AS TIPO,
                                IF(IFNULL(n.id_entrada_compra,0)>0,'SI','NO') AS EN_PORTAL,
                                IF(a.tipo=1,'No Aplica',IF(a.b_anticipo=1 && o.estatus!='L' && IFNULL(n.id_entrada_compra,0)=0,'Pendiente de Pago',
                                IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)=0,'Pagado',
                                IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus!='L','Pendiente de Pago',
                                IF(a.b_anticipo=1 && o.estatus!='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus='L','Pendiente de Pago',
                                IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus='L','Pagado', IF(n.estatus='L', 'Pagado', IF(n.estatus='P', 'Pendiente de Pago', 'No portal de proveedores')) )))))) AS ESTATUS_CXP,
                                IFNULL(o.fecha, 'No Aplica') as FECHA_PAGO_CXP,
                                IFNULL(n.no_factura, 'No Aplica') as NO_FACTURA,
                                IF(a.tipo=1,IF(a.estatus=1,'Pendiente',IF(a.estatus=7,'Cancelado',IF(a.omitir=1,'Pagado',IF(IFNULL(ga.id_requisicion,0)>0 && ga.estatus=1,'Pagado','Pendiente')))),'No Aplica') AS ESTATUS_GASTO,
                                IFNULL(ga.fecha_referencia, 'No Aplica') as FECHA_PAGO_GASTO,
                                IF(a.excede_presupuesto = 1, 'Excede Presup', 'Dentro presup') AS Presupuesto
                        FROM requisiciones a
                        INNER JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                        INNER JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                        INNER JOIN cat_areas d ON a.id_area = d.id
                        INNER JOIN deptos e ON a.id_departamento = e.id_depto
                        INNER JOIN proveedores f ON a.id_proveedor = f.id
                        LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                        LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra
                        LEFT JOIN almacen_e m ON k.id=m.id_oc
                        LEFT JOIN cxp n ON m.id=n.id_entrada_compra
                        LEFT JOIN cxp o ON n.id_cxp = o.id_cxp AND SUBSTR(o.clave_concepto,1,1) = 'A'
                        LEFT JOIN requisiciones_autorizar_bitacora g ON a.id=g.id_requisicion AND (a.excede_presupuesto=1 OR a.excede_presupuesto=0) AND g.estatus=1
                        LEFT JOIN usuarios h ON g.id_usuario=h.id_usuario 
                        LEFT JOIN requisiciones_autorizar_bitacora i ON a.id=i.id_requisicion AND (a.excede_presupuesto=1 OR a.excede_presupuesto=0) AND i.estatus=2
                        LEFT JOIN usuarios j ON i.id_usuario=j.id_usuario
                        LEFT JOIN usuarios us ON us.id_usuario = a.id_capturo
                        LEFT JOIN gastos ga ON a.id=ga.id_requisicion
                        WHERE -- (n.estatus != 'C' || o.estatus != 'C') AND 
                        a.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                        GROUP BY a.id
                        ORDER BY a.fecha_pedido";

                        // echo $query;
                        // exit();
            }else{
                $query="SELECT g.id AS ID,
                        a.folio AS FOLIO,
                        b.nombre AS UNIDAD,
                        c.descripcion AS SUCURSAL,
                        d.descripcion AS AREA,
                        e.des_dep AS DEPTO,
                        IFNULL(a.folio_orden_compra,'') AS FOLIO_ORDEN_COMPRA,
                        a.fecha_pedido AS FECHA,
                        IFNULL(a.solicito,'') AS SOLICITO,
                        f.nombre AS PROVEEDOR,
                        g.num_partida AS PARTIDA,
                        j.descripcion AS FAMILIA,
                        i.descripcion AS LINEA,
                        g.descripcion AS DESCRIPCIÓN,
                        g.concepto AS DETALLE,
                        IFNULL(l.unidad_medida,'') AS UNIDAD_MEDIDA,
                        g.cantidad AS CANTIDAD,
                        FORMAT(g.costo_unitario,2) AS COSTO_UNITARIO,
                        FORMAT(IFNULL(l.porcentaje_descuento,0),2) AS PORCENTAJE_DCTO,
                        FORMAT(((g.total/100)*g.iva),2) AS PORCENTAJE_IVA,
                        FORMAT(g.total,2) AS IMPORTE_SIN_IVA,
                        FORMAT((((g.total/100)*g.iva)+g.total),2) AS IMPORTE_CON_IVA
                        FROM requisiciones_d g
                        LEFT JOIN requisiciones a ON g.id_requisicion=a.id
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                        LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                        LEFT JOIN cat_areas d ON a.id_area = d.id
                        LEFT JOIN deptos e ON a.id_departamento = e.id_depto
                        LEFT JOIN proveedores f ON a.id_proveedor = f.id
                        LEFT JOIN productos h ON g.id_producto = h.id
                        LEFT JOIN lineas i ON g.id_linea = i.id
                        LEFT JOIN familias j ON g.id_familia = j.id
                        LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                        LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra
                        WHERE a.id_unidad_negocio=".$idUnidadNegocio." AND a.estatus=1 $sucursal $area $departamento $proveedor $condicion
                        ORDER BY a.fecha_pedido";
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTES_ORDEN_COMPRAS'){
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
            
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idArea = $arreglo['idArea'];
            $idDepartamento = $arreglo['idDepartamento'];
            $idProveedor = $arreglo['idProveedor'];

            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND orden_compra.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND orden_compra.fecha_pedido >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND orden_compra.fecha_pedido >= '$fechaInicio' AND orden_compra.fecha_pedido <= '$fechaFin' ";
            }

            if($idSucursal != '')
            {
                $sucursal=" AND orden_compra.id_sucursal=".$idSucursal;
            }else{
                $sucursal='';
            }

            if($idArea != '')
            {
                $area=" AND orden_compra.id_area=".$idArea;
            }else{
                $area='';
            }

            if($idDepartamento != '')
            {
                $departamento=" AND orden_compra.id_departamento=".$idDepartamento;
            }else{
                $departamento='';
            }
            
            if($idProveedor != '')
            {
                $proveedor=" AND orden_compra.id_proveedor=".$idProveedor;
            }else{
                $proveedor='';
            }

            if($nombre == 'Detalle de Compras')
            {
                $query="SELECT 
                        orden_compra_d.id AS ID,
                        cat_unidades_negocio.nombre AS UNIDAD,
                        sucursales.descripcion AS SUCURSAL,
                        cat_areas.descripcion AS AREA,
                        deptos.des_dep AS DEPTO,
                        orden_compra.folio AS FOLIO,
                        orden_compra.fecha_pedido AS FECHA,
                        IFNULL(orden_compra.usuario,'') AS SOLICITA,
                        proveedores.nombre AS PROVEEDOR,
                        orden_compra_d.num_partida AS PARTIDA,
                        orden_compra_d.clave_producto AS CATÁLOGO,
                        lineas.descripcion AS LINEA,
                        familias.descripcion AS FAMILIA,
                        orden_compra_d.cantidad AS CANTIDAD,
                        orden_compra_d.concepto AS CONCEPTO,
                        orden_compra_d.descripcion AS DESCRIPCIÓN,
                        FORMAT(orden_compra_d.costo_unitario,2) AS COSTO_UNITARIO,
                        FORMAT(IFNULL(orden_compra_d.porcentaje_descuento,0),2) AS PORCENTAJE_DESCUENTO,
                        FORMAT(((orden_compra_d.costo_total/100)*orden_compra_d.iva),2) AS PORCENTAJE_IVA,
                        FORMAT(orden_compra_d.costo_total,2) AS IMPORTE_SIN_IVA,
                        FORMAT((((orden_compra_d.costo_total/100)*orden_compra_d.iva)+orden_compra_d.costo_total),2) AS IMPORTE_CON_IVA,
                        IF(orden_compra.estatus='A','Activa',IF(orden_compra.estatus='I','Impresa',IF(orden_compra.estatus='C','Cancelada','Liquidada'))) AS ESTATUS,
                        IFNULL(almacen_e.folio,'') AS FOLIO_RMS,
                        IF(IFNULL(cxp.id_entrada_compra,0)>0,'Si','No') AS PORTAL_PROVEEDORES
                        FROM orden_compra_d
                        LEFT JOIN orden_compra ON orden_compra_d.id_orden_compra=orden_compra.id
                        LEFT JOIN cat_unidades_negocio ON orden_compra.id_unidad_negocio = cat_unidades_negocio.id
                        LEFT JOIN sucursales ON orden_compra.id_sucursal = sucursales.id_sucursal
                        LEFT JOIN cat_areas ON orden_compra.id_area = cat_areas.id
                        LEFT JOIN deptos ON orden_compra.id_departamento = deptos.id_depto
                        LEFT JOIN proveedores ON orden_compra.id_proveedor = proveedores.id
                        LEFT JOIN productos ON orden_compra_d.id_producto = productos.id
                        LEFT JOIN lineas ON productos.id_linea = lineas.id
                        LEFT JOIN familias ON productos.id_familia = familias.id
                        LEFT JOIN almacen_e ON orden_compra.id=almacen_e.id_oc
                        LEFT JOIN cxp ON almacen_e.id=cxp.id_entrada_compra
                        WHERE orden_compra.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                        ORDER BY orden_compra.fecha_pedido";
            }else if($nombre == 'Ordenes de Compra Agrupadas')
            {
                $query="SELECT 
                        orden_compra.id AS ID,
                        cat_unidades_negocio.nombre AS UNIDAD,
                        sucursales.descripcion AS SUCURSAL,
                        cat_areas.descripcion AS AREA,
                        deptos.des_dep AS DEPTO,
                        orden_compra.folio AS FOLIO,
                        orden_compra.fecha_pedido AS FECHA,
                        IFNULL(orden_compra.usuario,'') AS SOLICITA,
                        proveedores.nombre AS PROVEEDOR,
                        FORMAT(SUM(orden_compra_d.costo_total),2) AS IMPORTE_SIN_IVA,
                        FORMAT(SUM((((orden_compra_d.costo_total/100)*orden_compra_d.iva)+orden_compra_d.costo_total)),2) AS IMPORTE_CON_IVA,
                        IFNULL(requisiciones.monto_anticipo,0) AS MONTO_ANTICIPO,
                        IFNULL(cxpII.total,0) AS ABONOS_ANTICIPO,
                        IFNULL(almacen_e.folio,'') AS FOLIO_RMS,
                        IF(IFNULL(cxp.id_entrada_compra,0)>0,'Si','No') AS PORTAL_PROVEEDORES
                        FROM orden_compra 
                        LEFT JOIN orden_compra_d ON orden_compra.id=orden_compra_d.id_orden_compra
                        LEFT JOIN cat_unidades_negocio ON orden_compra.id_unidad_negocio = cat_unidades_negocio.id
                        LEFT JOIN sucursales ON orden_compra.id_sucursal = sucursales.id_sucursal
                        LEFT JOIN cat_areas ON orden_compra.id_area = cat_areas.id
                        LEFT JOIN deptos ON orden_compra.id_departamento = deptos.id_depto
                        LEFT JOIN proveedores ON orden_compra.id_proveedor = proveedores.id
                        LEFT JOIN almacen_e ON orden_compra.id=almacen_e.id_oc
                        LEFT JOIN cxp ON almacen_e.id=cxp.id_entrada_compra
                        LEFT JOIN 
                        (
                            SELECT f.id,f.id_orden_compra,f.b_anticipo,SUM(f.monto_anticipo) AS monto_anticipo 
                            FROM requisiciones f
                            INNER JOIN cxp ON f.id=cxp.id_requisicion
                            WHERE cxp.estatus!='C'
                            GROUP BY f.id_orden_compra
                            
                        ) AS requisiciones ON orden_compra.id = requisiciones.id_orden_compra
                        LEFT JOIN
                        (

                            SELECT rr.id_orden_compra AS idoc , SUM(yy.subtotal + yy.iva) AS total 
                            FROM cxp xx
                            INNER JOIN requisiciones rr ON xx.id_requisicion = rr.id
                            INNER JOIN cxp yy ON xx.id = yy.id_cxp  
                        
                            WHERE yy.id_requisicion = 0 AND yy.estatus!='C'
                            GROUP BY rr.id_orden_compra

                        ) AS cxpII ON orden_compra.id = cxpII.idoc
                        WHERE orden_compra.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                        GROUP BY orden_compra.id
                        ORDER BY orden_compra.fecha_pedido";
            }else{
                $query="SELECT 
                        orden_compra_d.id AS ID,
                        cat_unidades_negocio.nombre AS UNIDAD,
                        sucursales.descripcion AS SUCURSAL,
                        cat_areas.descripcion AS AREA,
                        deptos.des_dep AS DEPTO,
                        orden_compra.folio AS FOLIO,
                        orden_compra.fecha_pedido AS FECHA,
                        IFNULL(orden_compra.usuario,'') AS SOLICITA,
                        proveedores.nombre AS PROVEEDOR,
                        orden_compra_d.num_partida PARTIDA,
                        orden_compra_d.clave_producto AS CATÁLOGO,
                        lineas.descripcion AS LINEA,
                        familias.descripcion AS FAMILIA,
                        (orden_compra_d.cantidad - orden_compra_d.cantidad_entrega) AS CANTIDAD,
                        orden_compra_d.concepto AS CONCEPTO,
                        orden_compra_d.descripcion AS DESCRIPCIÓN,
                        FORMAT(orden_compra_d.costo_unitario,2) AS COSTO_UNITARIO,
                        FORMAT(IFNULL(orden_compra_d.porcentaje_descuento,0),2) AS PORCENTAJE_DESCUENTO,
                        FORMAT(((((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario))/100)*orden_compra_d.iva),2) AS PORCENTAJE_IVA,
                        FORMAT(((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario)),2) AS IMPORTE_SIN_IVA,
                        FORMAT((((((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario))/100)*orden_compra_d.iva)+((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario))),2) AS IMPORTE_CON_IVA,
                        IFNULL(almacen_e.folio,'') AS FOLIO_RMS,
                        IF(IFNULL(cxp.id_entrada_compra,0)>0,'Si','No') AS PORTAL_PROVEEDORES
                        FROM orden_compra_d
                        LEFT JOIN orden_compra ON orden_compra_d.id_orden_compra=orden_compra.id
                        LEFT JOIN cat_unidades_negocio ON orden_compra.id_unidad_negocio = cat_unidades_negocio.id
                        LEFT JOIN sucursales ON orden_compra.id_sucursal = sucursales.id_sucursal
                        LEFT JOIN cat_areas ON orden_compra.id_area = cat_areas.id
                        LEFT JOIN deptos ON orden_compra.id_departamento = deptos.id_depto
                        LEFT JOIN proveedores ON orden_compra.id_proveedor = proveedores.id
                        LEFT JOIN productos ON orden_compra_d.id_producto = productos.id
                        LEFT JOIN lineas ON productos.id_linea = lineas.id
                        LEFT JOIN familias ON productos.id_familia = familias.id
                        LEFT JOIN almacen_e ON orden_compra.id=almacen_e.id_oc
                        LEFT JOIN cxp ON almacen_e.id=cxp.id_entrada_compra
                        WHERE orden_compra.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                        HAVING cantidad > 0
                        ORDER BY orden_compra.fecha_pedido";
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo=='CLIENTES'){
            $query="SELECT 
            cat_clientes.id AS CLAVE_CLIENTE,
            cat_clientes.nombre_comercial AS NOMBRE_COMERCIAL,
            cat_clientes.fecha_inicio AS FECHA_INICIO,
            cat_clientes.datos_contacto AS DATOS_CONTACTO,
            IF(cat_clientes.inactivo=0,'ACTIVO','INACTIVO') AS ESTATUS,
            razones_sociales.rfc AS RFC, 
            razones_sociales.nombre_corto AS NOMBRE_CORTO, 
            razones_sociales.razon_social AS RAZON_SOCIAL,
            razones_sociales.r_legal AS REPRESNTANTE_LEGAL,
            razones_sociales.domicilio AS DOMICILIO,
            razones_sociales.no_exterior AS NO_EXTERIOR,
            razones_sociales.no_interior AS NO_INTERIOR,
            razones_sociales.colonia AS COLONIA,
            municipios.municipio AS MUNICIPIO,
            estados.estado AS ESTADO,
            paises.pais AS PAIS,
            razones_sociales.codigo_postal AS CODIGO_POSTAL,
            razones_sociales.dias_cred AS DIAS_CREDITO,
            razones_sociales.limite_cred AS CREDITO_LIMITE,
            razones_sociales.cred_activo AS CREDITO_ACTIVO,
            razones_sociales.otros_contactos AS OTROS_CONTACTOS,
            razones_sociales.contacto AS CONTACTO,
            razones_sociales.email AS CORREO,
            razones_sociales.telefono AS TELEFONOS,
            razones_sociales.ext AS EXTENSION,
            IF(razones_sociales.activo=1,'ACTIVO','INACTIVO') AS ESTATUS
            FROM razones_sociales 
            LEFT JOIN cat_clientes ON razones_sociales.id_cliente=cat_clientes.id
            LEFT JOIN municipios  ON razones_sociales.id_municipio=municipios.id
            LEFT JOIN estados  ON razones_sociales.id_estado=estados.id
            LEFT JOIN paises  ON razones_sociales.id_pais=paises.id
            ORDER BY cat_clientes.id";
            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());    
        }

        if($modulo == 'INVENTARIO'){

            $arreglo = json_decode($datos, true);
            $idSucursal = $arreglo['id_sucursal'];

            $query = "SELECT
                        produ.id_producto AS CATALOGO,
                        produ.concepto AS CONCEPTO,
                        produ.descripcion_producto AS DESCRIPCION,
                        produ.familia AS FAMILIA,
                        produ.linea AS LINEA,
                        produ.precio AS PRECIO,
                        produ.precio_venta AS PRECIOVENTA,
                        produ.existencia  AS EXISTENCIA,
                        FORMAT((produ.precio*produ.existencia),2) AS IMPORTE
                        FROM(

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
                            LEFT JOIN productos_unidades ON productos.id = productos_unidades.id_producto
                            LEFT JOIN productos_sucursales ON productos.id = productos_sucursales.fk_id_producto AND productos_sucursales.fk_id_sucursal = $idSucursal
                            INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
                            INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id  AND almacen_e.id_unidad_negocio=productos_unidades.id_unidades
                            WHERE almacen_e.id_sucursal = $idSucursal AND familias.tipo NOT IN (0,2)  AND almacen_e.estatus != 'C'
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
                            LEFT JOIN(
                            
                                SELECT 
                                pr.id AS id_original,
                                pr.equivalente_usado AS id_equivalente
                                FROM productos pr

                            ) po ON productos.id = po.id_equivalente
                            INNER JOIN productos_unidades ON  po.id_original = productos_unidades.id_producto
                            INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
                            INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id  AND almacen_e.id_unidad_negocio=productos_unidades.id_unidades
                            WHERE almacen_e.id_sucursal = $idSucursal AND familias.tipo NOT IN (0,2)  AND almacen_e.estatus != 'C'
                            AND productos.servicio = 0
                            GROUP BY productos.id

                        ) AS produ
                        GROUP BY produ.id_producto";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'DETALLE_MOV')
        {

            $arreglo = json_decode($datos, true);
            $idSucursal = $arreglo['id_sucursal'];
            $idProducto = $arreglo['id_producto'];

            $and = " ";
            if($arreglo['fecha_de'] != '')
                $and .= " AND almacen_e.fecha >= '" . $arreglo['fecha_de'] . "'";      

            if($arreglo['fecha_a'] != '')
                $and .= " AND almacen_e.fecha <= '" . $arreglo['fecha_a'] . "'"; 

            $query = "SELECT
                almacen_e.folio AS folio,
                DATE(almacen_e.fecha) AS fecha,
                almacen_d.cve_concepto AS clave,
                productos.concepto AS concepto,
                IF(almacen_e.id_trabajador = 0, proveedores.nombre, CONCAT_WS(' ' , TRIM(trabajadores.nombre), TRIM(trabajadores.apellido_p), TRIM(trabajadores.apellido_m))) AS ref_movimiento,
                almacen_e.referencia AS referencia,
                almacen_d.precio AS precio,
                almacen_d.cantidad AS cantidad
                FROM productos
                INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
                INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
                LEFT JOIN proveedores ON almacen_e.id_proveedor = proveedores.id
                LEFT JOIN trabajadores ON almacen_e.id_trabajador =  trabajadores.id_trabajador
                WHERE almacen_e.id_sucursal = $idSucursal and almacen_e.estatus != 'C'
                AND productos.id = $idProducto
                $and";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'DETALLE_MOV_2')
        {

            $arreglo = json_decode($datos, true);
            $idSucursal = $arreglo['id_sucursal'];
            $idProducto = $arreglo['id_producto'];

            $and = " ";
            if($arreglo['fecha_de'] != '')
                $and .= " AND almacen_e.fecha >= '" . $arreglo['fecha_de'] . "'";      

            if($arreglo['fecha_a'] != '')
                $and .= " AND almacen_e.fecha <= '" . $arreglo['fecha_a'] . "'"; 

            $query = "SELECT
                        almacen_e.folio AS folio,
                        DATE(almacen_e.fecha) AS fecha,
                        almacen_d.cve_concepto AS clave,
                        productos.concepto AS concepto,
                        IF(almacen_e.id_trabajador = 0, proveedores.nombre, CONCAT_WS(' ' , TRIM(trabajadores.nombre), TRIM(trabajadores.apellido_p), TRIM(trabajadores.apellido_m))) AS ref_movimiento,
                        almacen_e.referencia AS referencia,
                        almacen_d.precio AS precio,
                        tallas.talla,
                        tallas.cantidad,
                        almacen_e.cve_concepto
                    FROM productos
                    LEFT JOIN almacen_d ON productos.id = almacen_d.id_producto
                    left join tallas ON tallas.id_detalle= almacen_d.id
                    LEFT JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
                    LEFT JOIN proveedores ON almacen_e.id_proveedor = proveedores.id
                    LEFT JOIN trabajadores ON almacen_e.id_trabajador =  trabajadores.id_trabajador
                    WHERE almacen_e.id_sucursal = $idSucursal and almacen_e.estatus != 'C'
                    AND productos.id = $idProducto
                    $and";

                    // echo $query;
                    // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'INVENTARIO_ACUMULADO')
        {

            $arreglo = json_decode($datos, true);
            $idUnidad = $arreglo['id_unidad'];
            $idSucursal = $arreglo['id_sucursal'];
            $idProducto = $arreglo['id_producto'];
            $idFamilia = $arreglo['id_familia'];
            $idLinea = $arreglo['id_linea'];
            $fechaDe = $arreglo['fecha_de'];
            $fechaA = $arreglo['fecha_a'];

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


            $query = "SELECT
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

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'INVENTARIO_DETALLADO')
        {

            $arreglo = json_decode($datos, true);
            $idUnidad = $arreglo['id_unidad'];
            $idSucursal = $arreglo['id_sucursal'];
            $idProducto = $arreglo['id_producto'];
            $idFamilia = $arreglo['id_familia'];
            $idLinea = $arreglo['id_linea'];
            $fechaDe = $arreglo['fecha_de'];
            $fechaA = $arreglo['fecha_a'];

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
                DATE(almacen_e.fecha) AS fecha,
                familias.descripcion AS familia,
                lineas.descripcion AS linea,
                productos.id AS id_producto,
                productos.concepto as concepto,
                IF(almacen_e.id_trabajador = 0, proveedores.nombre, CONCAT_WS(' ' , TRIM(trabajadores.nombre), TRIM(trabajadores.apellido_p), TRIM(trabajadores.apellido_m))) AS ref,
                almacen_d.cantidad AS cantidad,
                almacen_d.precio AS precio,
                IFNULL(productos_unidades.ultimo_precio_compra, 0) AS ultimo_precio,
                IFNULL(productos_unidades.ultima_fecha_compra, '0000-00-00') AS ultima_fecha
                FROM productos
                INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
                INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
                INNER JOIN familias ON productos.id_familia = familias.id
                INNER JOIN lineas ON productos.id_linea = lineas.id
                LEFT JOIN productos_unidades ON productos.id = productos_unidades.id_producto AND productos_unidades.id_unidades = $idUnidad
                LEFT JOIN proveedores ON almacen_e.id_proveedor = proveedores.id
                LEFT JOIN trabajadores ON almacen_e.id_trabajador =  trabajadores.id_trabajador
                WHERE almacen_e.id_unidad_negocio = $idUnidad AND almacen_e.estatus != 'C'
                $and
                ORDER BY almacen_e.id ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo=='FAMILIAS_GASTOS')
        {

            $query="SELECT clave AS CLAVE, descr AS DESCRIPCIÓN,IF(activo=0,'ACTIVA','INACTIVA') AS ESTATUS 
                    FROM fam_gastos 
                    ORDER BY id_fam ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo == 'CLASIFICACION_GASTOS')
        {
            $query="SELECT  a.clave AS CLAVE, a.descr AS DESCRIPCIÓN,b.descr AS FAMILIA_GASTO,
                    IF(a.activo=0,'ACTIVA','INACTIVA') AS ESTATUS 
                    FROM gastos_clasificacion a
                    LEFT JOIN fam_gastos b ON a.id_fam=b.id_fam
                    ORDER BY a.id_clas ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'BANCOS')
        {
            $query="SELECT 
            clave AS CLAVE,
            descripcion AS BANCO,
            IF(activo=1,'ACTIVO','INACTIVO')AS ESTATUS
            FROM bancos 
            ORDER BY clave";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'CUENTAS_BANCOS')
        {
            $query="SELECT 
            cuentas_bancos.cuenta AS CUENTA,
            cuentas_bancos.descripcion AS DESCRIPCION,
            bancos.descripcion AS BANCO,
            cat_unidades_negocio.nombre AS UNIDAD_NEGOCIO,
            IF(cuentas_bancos.activa=1,'ACTIVA','INACTIVA')AS ESTATUS
            FROM cuentas_bancos 
            LEFT JOIN bancos ON cuentas_bancos.id_banco=bancos.id
            LEFT JOIN cat_unidades_negocio ON cuentas_bancos.id_unidad_negocio=cat_unidades_negocio.id
            ORDER BY cuentas_bancos.descripcion";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'REPORTES_BANCOS')
        {
            $arreglo = json_decode($datos, true);
           
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idCuenta = isset($arreglo['idCuenta'])?$arreglo['idCuenta']:'';
            $saldosCuentas = (isset($arreglo['saldosCuentas'])!='')?$arreglo['saldosCuentas']:'';
            
            $condicionFecha='';
        

            if($idCuenta==''){

                if($fechaInicio == '' && $fechaFin == '')
                {
                    $condicionFecha=" AND DATE(a.fecha_aplicacion) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY)";
                }else if($fechaInicio != '' &&  $fechaFin == '')
                {
                    $condicionFecha=" AND DATE(a.fecha_aplicacion) >= '$fechaInicio'";
                }else{  //-->trae fecha inicio y fecha fin
                    $condicionFecha=" AND DATE(a.fecha_aplicacion) BETWEEN '$fechaInicio' AND '$fechaFin'";
                }

                $query="SELECT pre.id,
                    pre.id_cuenta_banco,               
                    pre.id_banco,        
                    pre.cuenta AS CUENTA,   
                    pre.descripcion AS DESCRIPCIÓN,     
                    pre.banco AS BANCO,         
                    FORMAT(SUM(pre.saldo_actual),2) AS IMPORTE,
                    FORMAT(SUM(pre.saldo_fecha_inicio),2) AS SALDO_FECHA_INICIO, 
                    FORMAT(SUM(pre.saldo_fecha_fin),2) AS SALDO_FECHA_FIN
                    FROM 
                        (SELECT a.id,a.id_cuenta_banco,               
                        IFNULL(b.id_banco,0) AS id_banco,        
                        IFNULL(b.cuenta,'') AS cuenta,        
                        IFNULL(c.descripcion,'') AS banco,        
                        IFNULL(b.descripcion,'') AS descripcion,              
                        a.fecha_aplicacion, 
                        0 AS saldo_actual,
                        0 AS saldo_fecha_inicio, 
                        0 AS saldo_fecha_fin
                        FROM movimientos_bancos a 
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        WHERE 1 $condicionFecha 
                        GROUP BY a.id_cuenta_banco
                        UNION ALL
                        SELECT a.id,a.id_cuenta_banco,               
                        IFNULL(b.id_banco,0) AS id_banco,        
                        IFNULL(b.cuenta,'') AS cuenta,        
                        IFNULL(c.descripcion,'') AS banco,        
                        IFNULL(b.descripcion,'') AS descripcion,              
                        a.fecha_aplicacion, 
                        IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0) AS saldo_actual,
                        0 AS saldo_fecha_inicio, 
                        0 AS saldo_fecha_fin
                        FROM movimientos_bancos a 
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id 
                        GROUP BY a.id_cuenta_banco
                        UNION ALL
                        SELECT a.id,a.id_cuenta_banco,               
                        IFNULL(b.id_banco,0) AS id_banco,        
                        IFNULL(b.cuenta,'') AS cuenta,        
                        IFNULL(c.descripcion,'') AS banco,        
                        IFNULL(b.descripcion,'') AS descripcion,              
                        a.fecha_aplicacion, 
                        0 AS saldo_actual,
                        IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0) AS saldo_fecha_inicio, 
                        0 AS saldo_fecha_fin
                        FROM movimientos_bancos a 
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        WHERE DATE(a.fecha_aplicacion) < '$fechaInicio'
                        GROUP BY a.id_cuenta_banco
                        UNION ALL
                        SELECT a.id,a.id_cuenta_banco,               
                        IFNULL(b.id_banco,0) AS id_banco,        
                        IFNULL(b.cuenta,'') AS cuenta,        
                        IFNULL(c.descripcion,'') AS banco,        
                        IFNULL(b.descripcion,'') AS descripcion,              
                        a.fecha_aplicacion, 
                        0 AS saldo_actual,
                        0 AS saldo_fecha_inicio, 
                        IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0) AS saldo_fecha_fin
                        FROM movimientos_bancos a 
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        WHERE DATE(a.fecha_aplicacion) < '$fechaFin'
                        GROUP BY a.id_cuenta_banco
                    ) AS pre 
                    GROUP BY pre.id_cuenta_banco
                    ORDER BY pre.fecha_aplicacion DESC";

            }else{

            
                if($fechaInicio == '' && $fechaFin == '')
                {
                    $condicionFechaDetalle=" WHERE a.id_cuenta_banco='$idCuenta' GROUP BY a.id";
                }else if($fechaInicio != '' &&  $fechaFin == '')
                {
                    $condicionFechaDetalle=" WHERE a.id_cuenta_banco='$idCuenta' AND DATE(a.fecha_aplicacion) >= '$fechaInicio' 
                                    GROUP BY a.id";
                }else{  //-->trae fecha inicio y fecha fin
                    $condicionFechaDetalle=" WHERE a.id_cuenta_banco='$idCuenta' AND DATE(a.fecha_aplicacion) BETWEEN '$fechaInicio' AND '$fechaFin' 
                                    GROUP BY a.id";
                }

                //-->NJES October/09/2010 mostrar folio de pago y folio factura para los casos de los movimientos que se generaron al hacer pagos a facturas multiples
                //para que sea mas faci el rastreo de finanzas
                //-->NJES January/26/2021 hice la relacion a cxp.id porque en este caso solo queriamos los folios, 
                //y como tal los folio solo estan en el cargo inicial, no en los abonos
                //se muestra sucursales de los movimientos cuentas relacionados a las compras
                $query="SELECT 
                IFNULL(sucursales.descr,'') AS SUCURSAL,
                IFNULL(orden_compra.folio,'No aplica') AS FOLIO_ORDE_COMPRA,
                IFNULL(IF(cxp.id_requisicion > 0,requisiciones.folio,orden_compra.requisiciones),'No aplica') AS FOLIO_REQUISICIÓN,
                a.fecha_aplicacion as FECHA_APLICACION, 
                CONCAT('* ',b.cuenta) as CUENTA,
                b.descripcion AS DESCRIPCION,
                c.descripcion AS BANCO,
                FORMAT(a.monto,2) as MONTO,
                 CASE
                    WHEN a.tipo = 'T' THEN 'Transferencia'
                    WHEN a.tipo = 'I' THEN 'Monto Inicial'
                    WHEN a.tipo = 'C' THEN 'Cargo'
                    ELSE 'Abono'
                END AS TIPO,
                CASE
                    WHEN a.tipo = 'I' THEN 'Ingreso'
                    WHEN a.tipo = 'A' THEN 'Ingreso'
                    WHEN a.tipo = 'C' THEN 'Egreso'
                    WHEN a.tipo = 'T' AND a.transferencia = 0 THEN 'Egreso'
                    ELSE 'Ingreso'
                END AS MOVIMIENTO,
                IFNULL(a.observaciones,'') as OBSERVACIONES,
                IFNULL(e.folio_factura,'') AS FOLIO_FACTURA,
                IFNULL(d.folio_pago,'') AS FOLIO_PAGO      
                FROM movimientos_bancos a
                LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                LEFT JOIN bancos c ON b.id_banco=c.id
                LEFT JOIN cxc d ON a.id_cxc=d.id
                LEFT JOIN pagos_d e ON d.id_pago_d=e.id
                LEFT JOIN cxp ON a.id_cxp=cxp.id
                LEFT JOIN almacen_e ON cxp.id_entrada_compra=almacen_e.id
                LEFT JOIN orden_compra ON almacen_e.id_oc=orden_compra.id
                LEFT JOIN sucursales ON cxp.id_sucursal=sucursales.id_sucursal
                LEFT JOIN requisiciones ON cxp.id_requisicion=requisiciones.id
                
                $condicionFechaDetalle 
                ORDER BY a.fecha_aplicacion DESC,a.id DESC";
            }

            

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'REPORTES_BANCOS_TODOS')
        {
            $arreglo = json_decode($datos, true);
           
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            
            $condicionFecha='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicionFecha=" AND MONTH(a.fecha_aplicacion) = MONTH(NOW()) AND YEAR(a.fecha_aplicacion) = YEAR(NOW())";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicionFecha=" AND DATE(a.fecha_aplicacion) >= '$fechaInicio'";
            }else{  //-->trae fecha inicio y fecha fin
                $condicionFecha=" AND DATE(a.fecha_aplicacion) BETWEEN '$fechaInicio' AND '$fechaFin'";
            }
        
            /*-->NJES July/01/2020 En la columna de Importe se debe mostrar el saldo actual de la cuenta 
            y el nombre de la columna debe corresponder a ese dato.  
            El reporte debe contar un  filtro de fechas y un campo para visualizar el saldo de la 
            fecha inicio seleccionada, así como un campo para visualizar el saldo de la fecha fin 
            seleccionada. */

            $query = "SELECT 
                        IFNULL(sucursales.descr,IFNULL(s2.descr,IFNULL(s3.descr,IFNULL(s4.descr,'')))) AS sucursal,
                        IFNULL(a.observaciones,'') as observaciones,
                        b.cuenta as cuenta,
                        c.descripcion AS banco,
                        b.descripcion,
                        CASE
                            WHEN a.tipo = 'A' THEN 'Ingreso'
                            WHEN a.tipo = 'I' THEN 'Ingreso'
                            WHEN a.tipo = 'T' AND a.transferencia <> 0 THEN 'Ingreso'
                            WHEN a.tipo = 'C' THEN 'Egreso'
                            WHEN a.tipo = 'T' AND a.transferencia = 0 THEN 'Egreso'
                            ELSE ''
                        END AS movimiento,
                        CASE
                            WHEN a.tipo = 'A' THEN a.monto
                            WHEN a.tipo = 'I' THEN a.monto
                            WHEN a.tipo = 'T' AND a.transferencia <> 0 THEN a.monto
                            ELSE ''
                        END AS montoIngreso,
                        CASE
                            WHEN a.tipo = 'C' THEN a.monto
                            WHEN a.tipo = 'T' AND a.transferencia = 0 THEN a.monto
                            ELSE ''
                        END AS montoEgreso,
                        a.fecha_aplicacion,
                        a.monto AS saldo,
                        IFNULL(d.folio_pago,'') AS folio_pago,
                        IFNULL(e.folio_factura,'') AS folio_factura,
                        IFNULL(orden_compra.folio,'No aplica') AS folio_oc,
                        IFNULL(IF(cxp.id_requisicion > 0,requisiciones.folio,orden_compra.requisiciones),'No aplica') AS folio_requi,
                        IFNULL(gas.folio_requisicion,'') AS folio_gasto,
                        IFNULL(vi.folio,'') AS folio_viatico
                    FROM movimientos_bancos a
                    LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                    LEFT JOIN bancos c ON b.id_banco=c.id
                    LEFT JOIN cxc d ON a.id_cxc=d.id
                    LEFT JOIN pagos_d e ON d.id_pago_d=e.id
                    LEFT JOIN cxp ON a.id_cxp=cxp.id
                    LEFT JOIN almacen_e ON cxp.id_entrada_compra=almacen_e.id
                    LEFT JOIN orden_compra ON almacen_e.id_oc=orden_compra.id
                    LEFT JOIN sucursales ON cxp.id_sucursal=sucursales.id_sucursal
                    LEFT JOIN requisiciones ON cxp.id_requisicion=requisiciones.id
                    LEFT JOIN gastos gas ON gas.id = a.id_gasto
                    LEFT JOIN sucursales s2 ON gas.id_sucursal=s2.id_sucursal
                    LEFT JOIN sucursales s3 ON d.id_sucursal=s3.id_sucursal
                    LEFT JOIN viaticos vi ON vi.id= a.id_viatico
                    LEFT JOIN sucursales s4 ON vi.id_sucursal=s4.id_sucursal
                    WHERE 1 
                    $condicionFecha 
                    ORDER BY a.fecha_aplicacion DESC,a.id DESC";
            

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'REPORTES_BANCOS_TODOS2')
        {
            $arreglo = json_decode($datos, true);
           
            $fechaInicio = $arreglo['fechaI'];
            $fechaFin = $arreglo['fechaF'];
            $idCuenta = $arreglo['idCuenta'];
            
            $condicionCuenta = "";

            if($idCuenta != 0 && $idCuenta != ""){
                $condicionCuenta = " AND a.id_cuenta_banco =$idCuenta ";
            }else{
                $idUsuario = $_SESSION["id_usuario"];

                $condicionCuenta = " AND b.id_unidad_negocio IN (
                                            SELECT DISTINCT(id_unidad_negocio)
                                            FROM permisos
                                            WHERE id_usuario = $idUsuario)";
            }

            $condicionFecha = " AND MONTH(a.fecha) = MONTH(NOW()) AND YEAR(a.fecha) = YEAR(NOW()) ";

            if($fechaInicio != "" && $fechaFin != ""){
                $condicionFecha = " AND DATE(a.fecha) BETWEEN DATE('$fechaInicio') AND DATE('$fechaFin') ";
            }

            $query = "SELECT 
                            IFNULL(sucursales.descr,IFNULL(s2.descr,IFNULL(s3.descr,IFNULL(s4.descr,'')))) AS sucursal,
                            IFNULL(a.observaciones,'') as observaciones,
                            b.cuenta as cuenta,
                            c.descripcion AS banco,
                            b.descripcion,
                            CASE
                                WHEN a.tipo = 'A' THEN 'Ingreso'
                                WHEN a.tipo = 'I' THEN 'Ingreso'
                                WHEN a.tipo = 'T' AND a.transferencia <> 0 THEN 'Ingreso'
                                WHEN a.tipo = 'C' THEN 'Egreso'
                                WHEN a.tipo = 'T' AND a.transferencia = 0 THEN 'Egreso'
                                ELSE ''
                            END AS movimiento,
                            CASE
                                WHEN a.tipo = 'A' THEN a.monto
                                WHEN a.tipo = 'I' THEN a.monto
                                WHEN a.tipo = 'T' AND a.transferencia <> 0 THEN a.monto
                                ELSE ''
                            END AS montoIngreso,
                            CASE
                                WHEN a.tipo = 'C' THEN a.monto
                                WHEN a.tipo = 'T' AND a.transferencia = 0 THEN a.monto
                                ELSE ''
                            END AS montoEgreso,
                            a.fecha_aplicacion,
                            a.monto AS saldo,
                            IFNULL(d.folio_pago,'') AS folio_pago,
                            IFNULL(e.folio_factura,'') AS folio_factura,
                            IFNULL(orden_compra.folio,'No aplica') AS folio_oc,
                            IFNULL(IF(cxp.id_requisicion > 0,requisiciones.folio,orden_compra.requisiciones),'No aplica') AS folio_requi,
                            IFNULL(gas.folio_requisicion,'') AS folio_gasto,
                            IFNULL(vi.folio,'') AS folio_viatico
                        FROM movimientos_bancos a
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        LEFT JOIN cxc d ON a.id_cxc=d.id
                        LEFT JOIN pagos_d e ON d.id_pago_d=e.id
                        LEFT JOIN cxp ON a.id_cxp=cxp.id
                        LEFT JOIN almacen_e ON cxp.id_entrada_compra=almacen_e.id
                        LEFT JOIN orden_compra ON almacen_e.id_oc=orden_compra.id
                        LEFT JOIN sucursales ON cxp.id_sucursal=sucursales.id_sucursal
                        LEFT JOIN requisiciones ON cxp.id_requisicion=requisiciones.id
                        LEFT JOIN gastos gas ON gas.id = a.id_gasto
                        LEFT JOIN sucursales s2 ON gas.id_sucursal=s2.id_sucursal
                        LEFT JOIN sucursales s3 ON d.id_sucursal=s3.id_sucursal
                        LEFT JOIN viaticos vi ON vi.id= a.id_viatico
                        LEFT JOIN sucursales s4 ON vi.id_sucursal=s4.id_sucursal
                        WHERE 1 
                        $condicionFecha 
                        $condicionCuenta 
                        ORDER BY a.id_cuenta_banco, a.fecha_aplicacion DESC,a.id DESC;";
                        
                        // echo $query;
                        // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'SALDOS_CUENTAS_BANCOS')
        {
            $arreglo = json_decode($datos, true);
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            $query="SELECT uno.cuenta AS CUENTA,uno.banco AS BANCO,uno.descripcion AS DESCRIPCIÓN,uno.saldo_inicial AS SALDO_INICIAL, dos.saldo_final AS SALDO_FINAL
                    FROM 
                    (SELECT IFNULL(b.cuenta,'') AS cuenta,IFNULL(c.descripcion,'') AS banco,IFNULL(b.descripcion,'') AS descripcion,a.fecha_aplicacion,a.id_cuenta_banco,
                        FORMAT(IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0),2) AS saldo_inicial,
                        0 AS saldo_final
                        FROM movimientos_bancos a
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        WHERE DATE(a.fecha_aplicacion) <= '$fechaInicio' 
                        GROUP BY a.id_cuenta_banco)  uno
                        LEFT JOIN 
                        (
                        SELECT a.id_cuenta_banco,
                        0 AS saldo_inicial,
                        FORMAT(IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0),2) AS saldo_final
                        FROM movimientos_bancos a
                        WHERE DATE(a.fecha_aplicacion) <= '$fechaFin' 
                        GROUP BY a.id_cuenta_banco) dos ON uno.id_cuenta_banco = dos.id_cuenta_banco";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }
        
        if($modulo == 'GASTOS')
        {
            //-->NJES March/12/2020 se agrega folio requsiición cuando aplique
            $query="SELECT 
            unidad.nombre AS UNIDAD_NEGOCIO,
            sucursales.descr AS SUCURSAL,
            deptos.des_dep AS DEPARTAMENTO,
            IF(requisiciones.b_varias_familias=1,'DIFERENTES FAMILIAS',fam_gastos.descr) AS FAMILIA_GASTOS,
            IF(requisiciones.b_varias_familias=1,'DIFERENTES CLASIFICACIONES',gastos_clasificacion.descr) AS CLASIFICACION_GASTO,
            gastos.fecha AS FECHA,
            IF(gastos.tipo='F','Factura',IF(gastos.tipo='N','Nota',IF(gastos.tipo='R','Recibo','Reposición')))AS TIPO_GASTO, 
            CONCAT(gastos.tipo,': ',gastos.referencia) AS REFERENCIA,
            proveedores.nombre AS PROVEEDOR,
            IF(gastos.folio_requisicion>0,gastos.folio_requisicion,'') AS FOLIO_REQUISICIÓN,
            gastos.observaciones AS OBSERVACIONES, 
            (gastos.subtotal+gastos.iva) AS TOTAL, 
            IF(cuentas_bancos.tipo=1,'CAJA CHICA',bancos.clave) AS BANCO,
            cuentas_bancos.cuenta AS CUENTA,
            gastos.estatus AS ESTATUS
            FROM  gastos 
            LEFT JOIN cat_unidades_negocio AS unidad ON  gastos.id_unidad_negocio = unidad.id
            LEFT JOIN sucursales ON gastos.id_sucursal = sucursales.id_sucursal
            LEFT JOIN deptos ON gastos.id_departamento =  deptos.id_depto
            LEFT JOIN fam_gastos ON gastos.id_familia = fam_gastos.id_fam
            LEFT JOIN gastos_clasificacion ON gastos.id_clasificacion = gastos_clasificacion.id_clas
            LEFT JOIN proveedores ON gastos.id_proveedor = proveedores.id
            LEFT JOIN bancos ON gastos.id_banco = bancos.id
            LEFT JOIN cuentas_bancos ON gastos.id_cuenta_banco = cuentas_bancos.id
            LEFT JOIN requisiciones ON gastos.id_requisicion=requisiciones.id
            WHERE gastos.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 1 YEAR) 
            ORDER BY gastos.id ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }
        
        if($modulo == 'ESTADO_DE_CUENTA_CXP')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
            
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idProveedor = $arreglo['idProveedor'];

            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            $query="SELECT b.clave AS CONCEPTO,IFNULL(a.fecha,'') AS FECHA,b.descripcion AS DESCRIPCIÓN,
                    IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva),0) AS CARGOS,
                    IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva),0) AS ABONOS,
                    0 AS SALDO,
                    a.referencia AS REFERENCIA
                    FROM cxp a
                    LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                    LEFT JOIN proveedores c ON a.id_proveedor=c.id
                    WHERE a.id_proveedor = $idProveedor
                    AND a.id_viatico=0  AND a.id_cxp IN(SELECT DISTINCT(a.id_cxp ) AS id_cxp FROM cxp a  WHERE  a.id_proveedor = $idProveedor AND a.id_viatico=0 $condicion) 
                    ORDER BY a.id ASC,a.fecha DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 

        }

        if($modulo == 'REPORTE_VG')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idSucursal = $arreglo['idSucursal'];

            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            $query = "SELECT IFNULL(a.folio,'') AS FOLIO,
                        c.nombre AS UNIDAD_DE_NEGOCIO,d.descr AS SUCURSAL,e.descripcion AS ÁREA,f.des_dep AS DEPARTAMENTO,
                        IF(a.nombre_empleado != '',a.nombre_empleado,CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m))) AS EMPLEADO,
                        a.observaciones AS OBSERVACIONES,a.fecha AS FECHA,
                        CONCAT('NE:',a.no_economico) as NO_ECONOMICO,a.clave_concepto AS CLAVE_CONCEPTO,
                        CONCAT(a.clave_concepto,' ',b.descripcion) AS CONCEPTO,a.importe AS IMPORTE_VALOR,
                        FORMAT(a.importe,2) AS IMPORTE,
                        0 AS SALDO
                        FROM vales_gasolina a
                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                        LEFT JOIN cat_areas e ON a.id_area=e.id
                        LEFT JOIN deptos f ON a.id_departamento=f.id_depto
                        LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
                        WHERE a.id_sucursal=$idSucursal $condicion
                        ORDER BY a.id ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'REPORTES_CCH')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idSucursal = $arreglo['idSucursal'];

            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            $query = "SELECT c.nombre AS UNIDAD_DE_NEGOCIO,d.descr AS SUCURSAL,IFNULL(e.descripcion,'') AS ÁREA,IFNULL(f.des_dep,'') AS DEPARTAMENTO,
                        IFNULL(IF(a.nombre_empleado != '',a.nombre_empleado,CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m))),'') AS EMPLEADO,
                        a.observaciones AS OBSERVACIONES,a.fecha AS FECHA,a.clave_concepto AS CLAVE_CONCEPTO,CONCAT(a.clave_concepto,' ',b.descripcion) AS CONCEPTO,a.importe AS IMPORTE_VALOR,FORMAT(a.importe,2) AS IMPORTE,
                        0 AS SALDO
                        FROM caja_chica a
                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                        LEFT JOIN cat_areas e ON a.id_area=e.id
                        LEFT JOIN deptos f ON a.id_departamento=f.id_depto
                        LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
                        WHERE a.id_sucursal=$idSucursal $condicion
                        ORDER BY a.id ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'DASH_GASTOS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idDepartamento = isset($arreglo['idDepartamento']) ? $arreglo['idDepartamento'] : 0;
            $fecha = isset($arreglo['fecha']) ? $arreglo['fecha'] : '';
            $tipo = $arreglo['tipo'];

            $unidad='';
            $sucursal='';
            $departamento='';

            if($idUnidadNegocio != '')
            {
                if($idUnidadNegocio[0] == ',')
                {
                    $dato=substr($idUnidadNegocio,1);
                    $unidad = " AND a.id_unidad_negocio IN($dato) ";
                }else{ 
                    $unidad = " AND a.id_unidad_negocio = $idUnidadNegocio";
                }
            }

            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = " AND a.id_sucursal IN($dato) ";
            }else{ 
                $sucursal = " AND a.id_sucursal = $idSucursal";
            }
        
            //if($idDepartamento != 0)
            //{
                $departamento = " AND a.id_departamento = $idDepartamento";
            //}

            if($fecha != '')
            {
                $condFecha = " AND MONTH(b.fecha) = MONTH('$fecha') AND YEAR(b.fecha) = YEAR('$fecha')";
            }

            if($tipo == 1)
            {
                $query = "SELECT CONCAT(IF(MONTH(b.fecha) < 10,CONCAT('0',MONTH(b.fecha)),MONTH(b.fecha)),'-',YEAR(b.fecha)) AS MES_AÑO,
                            FORMAT(SUM(a.monto),2) AS TOTAL
                            FROM movimientos_presupuesto a
                            LEFT JOIN gastos b ON a.id_gasto=b.id
                            WHERE 1 $unidad $sucursal AND a.tipo='C' AND a.estatus='A' AND !ISNULL(b.fecha) 
                            GROUP BY YEAR(b.fecha),MONTH(b.fecha)
                            ORDER BY YEAR(b.fecha) DESC,MONTH(b.fecha) DESC";
            
            }else if($tipo == 2)
            {
                $query = "SELECT c.nombre AS UNIDAD_DE_NEGOCIO,d.descr AS SUCURSAL,e.descripcion AS AREA, 
                            f.des_dep AS DEPARTAMENTO,FORMAT(SUM(a.monto),2) AS TOTAL
                            FROM movimientos_presupuesto a
                            LEFT JOIN gastos b ON a.id_gasto=b.id
                            LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                            LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                            LEFT JOIN cat_areas e ON a.id_area=e.id
                            LEFT JOIN deptos f ON a.id_departamento=f.id_depto
                            WHERE 1 $unidad $sucursal $condFecha AND a.tipo='C' AND a.estatus='A' AND !ISNULL(b.fecha)
                            GROUP BY a.id_departamento 
                            ORDER BY c.nombre,d.descr,f.des_dep";
                        
            }else{
                $query = "SELECT b.fecha as FECHA_GASTO,b.concepto AS DESCRIPCIÓN,e.nombre AS PROVEEDOR,
                            c.descr AS FAMILIA,d.descr AS CLASIFICACIÓN,IF(b.fecha_referencia='0000-00-00','',b.fecha_referencia) as FECHA_REFERENCIA,
                            b.referencia as REFERENCIA,FORMAT((a.monto),2) AS IMPORTE
                            FROM movimientos_presupuesto a 
                            LEFT JOIN gastos b ON a.id_gasto=b.id
                            LEFT JOIN fam_gastos c ON a.id_familia_gasto=c.id_fam
                            LEFT JOIN gastos_clasificacion d ON a.id_clasificacion=d.id_clas
                            LEFT JOIN proveedores e ON b.id_proveedor = e.id
                            WHERE 1 $unidad $sucursal $condFecha $departamento AND a.tipo='C' AND a.estatus='A' AND !ISNULL(b.fecha)
                            ORDER BY b.fecha DESC"; 
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'REPORTES_DD')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idEmpleado = isset($arreglo['idEmpleado']) ? $arreglo['idEmpleado'] : 0;
            $empleadoN = isset($arreglo['empleado']) ? $arreglo['empleado'] : '';
            $tipo = $arreglo['tipo'];

            $unidad='';
            $sucursal='';
            $condicion='';
            $empleado='';

            if($idUnidadNegocio != '')
            {
                if($idUnidadNegocio[0] == ',')
                {
                $dato=substr($idUnidadNegocio,1);
                $unidad = ' AND a.id_unidad_negocio IN('.$dato.') ';
                }else{ 
                $unidad = ' AND a.id_unidad_negocio ='.$idUnidadNegocio;
                }
            }

            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }

            if($idEmpleado != 0)
            {
                $empleado = ' AND a.id_empleado ='.$idEmpleado;
            }else{
                $empleado = " AND a.empleado ='$empleadoN'";
            }

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            if($tipo == 1)
            {
                $query ="SELECT c.nombre AS UNIDAD_DE_NEGOCIO,d.descr AS SUCURSAL,
                        IF(a.id_empleado > 0,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m)),a.empleado) AS NOMBRE,
                        FORMAT(SUM(a.importe),2) AS IMPORTE,a.fecha AS FECHA
                        FROM deudores_diversos a
                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal  
                        LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                        WHERE a.comprobado=0 $unidad $sucursal $condicion
                        GROUP BY a.id_empleado
                        ORDER BY a.fecha ASC";
            }else{
                $query ="SELECT c.nombre AS UNIDAD_DE_NEGOCIO,d.descr AS SUCURSAL,IF(a.id_gasto>0,'GASTO','VIATICO') AS TIPO,
                        a.categoria AS DESCRIPCIÓN,FORMAT(a.importe,2) AS IMPORTE,a.fecha AS FECHA
                        FROM deudores_diversos a
                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal  
                        LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                        WHERE a.comprobado=0 $empleado $unidad $sucursal $condicion
                        ORDER BY a.fecha ASC";
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'EDITAR_PRESUPUESTO')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $anio = $arreglo['anio'];
            $mes = $arreglo['mes'];

            if($mes > 0)
            {
                $condMes = ' AND presupuesto_egresos.mes ='.$mes;
            }else{
                $condMes = '';
            }

            $query="SELECT 
                        cat_unidades_negocio.nombre AS UNIDAD_NEGOCIO,
                        sucursales.descr AS SUCURSAL,
                        fam_gastos.descr AS FAMILIA,
                        gastos_clasificacion.descr AS CLASIFICACIÓN,
                        presupuesto_egresos.anio AS AÑO,
                        (CASE presupuesto_egresos.mes
                            WHEN  1 THEN 'Enero'
                            WHEN 2 THEN 'Febrero'
                            WHEN 3 THEN 'Marzo'
                            WHEN 4 THEN 'Abril'
                            WHEN 5 THEN 'Mayo'
                            WHEN 6 THEN 'Junio'
                            WHEN 7 THEN 'Julio'
                            WHEN 8 THEN 'Agosto'
                            WHEN 9 THEN 'Septiembre'
                            WHEN 10 THEN 'Octubre'
                            WHEN 11 THEN 'Noviembre'
                            WHEN 12 THEN 'Diciembre'
                            ELSE ''
                        END) AS MES,
                        presupuesto_egresos.monto AS IMPORTE
                        FROM presupuesto_egresos
                        INNER JOIN cat_unidades_negocio ON presupuesto_egresos.id_unidad_negocio = cat_unidades_negocio.id
                        INNER JOIN sucursales ON presupuesto_egresos.id_sucursal = sucursales.id_sucursal
                        INNER JOIN fam_gastos ON presupuesto_egresos.id_familia_gasto = fam_gastos.id_fam
                        LEFT JOIN gastos_clasificacion ON presupuesto_egresos.id_clasificacion = gastos_clasificacion.id_clas
                        WHERE presupuesto_egresos.id_unidad_negocio = $idUnidadNegocio
                        AND presupuesto_egresos.anio = $anio
                        $condMes
                        ORDER BY presupuesto_egresos.anio,presupuesto_egresos.mes DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'BITACORA_EGRESOS'){
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $tipo = $arreglo['tipo'];
            
            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND MONTH(a.fecha_modificacion)= MONTH(CURDATE()) AND YEAR(a.fecha_modificacion)= YEAR(CURDATE()) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND a.fecha_modificacion >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND DATE(a.fecha_modificacion) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            $query="SELECT 
                        a.fecha_modificacion AS FECHA,
                        h.usuario AS USUARIO,
                        IFNULL(g.descr,'') AS FAMILIA,
                        IFNULL(i.descr,'') AS CLASIFICACIÓN,
                        b.mes AS MES,
                        b.anio AS AÑO,
                        a.campos_modificados AS CAMPOS_MODIFICADOS
                        FROM presupuestos_bitacora a
                        LEFT JOIN  presupuesto_egresos b ON a.id_registro=b.id
                        LEFT JOIN cat_unidades_negocio c ON b.id_unidad_negocio = c.id
                        LEFT JOIN sucursales d ON b.id_sucursal = d.id_sucursal
                        LEFT JOIN fam_gastos g ON b.id_familia_gasto = g.id_fam
                        LEFT JOIN gastos_clasificacion i ON b.id_clasificacion = i.id_clas
                        LEFT JOIN usuarios h ON a.id_usuario_modificacion = h.id_usuario
                    WHERE a.modulo='$tipo' AND a.id_unidad_negocio = ".$idUnidadNegocio."
                    AND a.id_sucursal = ".$idSucursal." $condicion 
                    ORDER BY a.id DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'SEGUIMIENTO_EGRESOS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
            
            $mesInicial = $arreglo['mesInicio'];
            $mesFinal = $arreglo['mesFin'];
            $idUnidad = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            //-->NJES July/14/2020 quitar area y departamento ya que no se toma e cuenta ni en la carga ni en el consumo de presupuesto egresos
            //$idArea = $arreglo['idArea'];
            //$idDepartamento = $arreglo['idDepartamento'];
            $anio = $arreglo['anio'];
            $reporte = $arreglo['reporte'];

            //-->NJES July/19/2020 enviar la lista de sucursales permisos de la unidad, modulo y usuario
            //si no hay una sucursal seleccionada o si es la opción Mostrar Todas
            //$condicionSucursal = ($idSucursal>0)?' AND a.id_sucursal='.$idSucursal :'';
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $condicionSucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $condicionSucursal = ' AND a.id_sucursal ='.$idSucursal;
            }

            //$condicionArea = ($idArea>0)?'AND a.id_area='.$idArea:'';
            //$condicionDepartamentoS1 = ($idDepartamento>0)?' AND a.id_depto='.$idDepartamento :'';
            // $condicionDepartamentoS2 = ($idDepartamento>0)?' AND a.id_departamento='.$idDepartamento :'';
            $condicionMesS1 = ($mesFinal>0)?'  AND a.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
            $condicionMesS2 = ($mesFinal>0)?'  AND MONTH(a.fecha_captura) BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
            $condicionAnioS1 = ($anio>0)?" AND a.anio=".$anio :" ";
            $condicionAnioS2 = ($anio>0)?" AND YEAR(a.fecha_captura)=".$anio :" ";

            //if($idSucursal>0)
            //{
                $leftSucursal=' LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal';
                $selectSucursal=' tabla.sucursal AS SUCURSAL,';
                $selectSucursal2=' e.descr AS sucursal,';
            //}

            /*if($idArea>0)
            {
                $leftArea=' LEFT JOIN cat_areas f ON a.id_area=f.id';
                $selectArea=' tabla.area AS ÁREA,';
                $selectArea2=' f.descripcion AS area,';
            }

            if($idDepartamento>0)
            {
                $leftDepartamentoM=' LEFT JOIN deptos g ON a.id_departamento=g.id_depto';
                $leftDepartamento=' LEFT JOIN deptos g ON a.id_depto=g.id_depto';
                $selectDepartamento=' tabla.departamento AS DEPARTAMENTO,';
                $selectDepartamento2=' g.des_dep AS departamento,';
            }*/

            if($reporte == 'familia'){

                $query="SELECT 
                            tabla.unidad_negocio AS UNIDAD_NEGOCIO,
                            $selectSucursal
                            tabla.familia AS FAMILIA,
                            FORMAT(IFNULL(SUM(tabla.presupuesto),0),2) AS PRESUPUESTO,
                            FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS EJERCIDO,
                            CONCAT(FORMAT(IF(tabla.presupuesto > 0,IFNULL((SUM(tabla.ejercido) * 100)/SUM(tabla.presupuesto),0),0),2),' %') AS PORCENTAJE
                        FROM (	
                            SELECT 
                                c.nombre AS unidad_negocio,
                                $selectSucursal2
                                IFNULL(b.descr,'') AS familia,
                                SUM(a.monto) AS presupuesto,
                                0 AS ejercido
                            FROM presupuesto_egresos a 
                            LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                            LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                            $leftSucursal
                            WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS1 $condicionMesS1
                            GROUP BY a.id_familia_gasto
                          UNION ALL
                           
                           SELECT 
                                c.nombre AS unidad_negocio,
                                $selectSucursal2
                                IFNULL(b.descr,'') AS familia,
                                0 AS presupuesto,SUM(a.monto) AS ejercido
                            FROM movimientos_presupuesto a 
                            LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                            LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                            $leftSucursal
                            WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS2 $condicionMesS2
                            GROUP BY a.id_familia_gasto
                            ) AS tabla
    
                        GROUP BY tabla.familia
                        ORDER BY tabla.familia ASC";
               
            }else if($reporte == 'clasificacion')
            {
    
               $query="SELECT 
                            tabla.unidad_negocio AS UNIDAD_NEGOCIO,
                            $selectSucursal
                            tabla.familia AS FAMILIA,
                            tabla.clasificacion AS CLASIFICACIÓN,
                            FORMAT(IFNULL(SUM(tabla.presupuesto),0),2) AS PRESUPUESTO,
                            FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS EJERCIDO,
                            CONCAT(FORMAT(IF(tabla.presupuesto > 0,IFNULL((SUM(tabla.ejercido) * 100)/SUM(tabla.presupuesto),0),0),2),' %') AS PORCENTAJE
                        FROM (  
                                    SELECT 
                                        d.nombre AS unidad_negocio,
                                        $selectSucursal2
                                        IFNULL(b.descr,'') AS familia,
                                        IFNULL(c.descr,'') AS clasificacion,
                                        SUM(a.monto) AS presupuesto,0 AS ejercido
                                    FROM presupuesto_egresos a 
                                    LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                                    LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
                                    LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
                                    $leftSucursal
                                    WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS1 $condicionMesS1
                                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                                UNION ALL
    
                                    SELECT 
                                        d.nombre AS unidad_negocio,
                                        $selectSucursal2
                                        IFNULL(b.descr,'') AS familia,
                                        IFNULL(c.descr,'') AS clasificacion,
                                        0 AS presupuesto,
                                        SUM(a.monto) AS ejercido
                                    FROM movimientos_presupuesto a 
                                    LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                                    LEFT JOIN gastos_clasificacion c ON a.id_clasificacion=c.id_clas
                                    LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
                                    $leftSucursal
                                    WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS2 $condicionMesS2
                                    GROUP BY a.id_clasificacion,a.id_familia_gasto
                             ) AS tabla
    
                        GROUP BY tabla.clasificacion ,tabla.familia
                        ORDER BY tabla.familia ASC";
               
            }else{
    
                $fecha=$anio."-".$mesInicial."-01";
    
                $queryDias="SELECT dayofmonth(last_day('$fecha')) as dias_mes";
                $resultDias = mysqli_query($this->link, $queryDias)or die(mysqli_error());
    
                $condicionDias = ''; 
                $condicionFecha = '';
    
                if($resultDias){
    
                    $rowD=mysqli_fetch_array($resultDias);
    
                    $totalDias=$rowD['dias_mes'];
    
                    for($j=1;$j<=$totalDias;$j++){
                       
                        $condicionDias.="FORMAT(IFNULL(SUM(tabla.d".$j."),0),2) AS D".$j.",";
                        $condicionDiasP.="0 AS D".$j.",";
                        $condicionFecha.="IF(DATE_FORMAT(a.fecha_captura,'%d')=".$j.",IFNULL(SUM(a.monto),0),0) AS d".$j.",";
                        
                    }
                } 
    
                 
               $query="SELECT   
                                tabla.unidad_negocio AS UNIDAD_NEGOCIO,
                                $selectSucursal
                                tabla.familia AS FAMILIA,
                                FORMAT(IFNULL(SUM(tabla.presupuesto),0),2) AS PRESUPUESTO,
                                $condicionDias
                                FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS EJERCIDO,
                                CONCAT(FORMAT(IF(tabla.presupuesto > 0,IFNULL((SUM(tabla.ejercido) * 100)/SUM(tabla.presupuesto),0),0),2),' %') AS PORCENTAJE
                            FROM (	
                                SELECT 
                                    c.nombre AS unidad_negocio,
                                    $selectSucursal2
                                    IFNULL(b.descr,'') AS familia,
                                    SUM(a.monto) AS presupuesto,
                                    $condicionDiasP
                                    0 AS ejercido
                                FROM presupuesto_egresos a 
                                LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                                LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                                $leftSucursal
                                WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS1 $condicionMesS1
                                GROUP BY a.id_familia_gasto
                                UNION ALL
                                
                                SELECT 
                                    c.nombre AS unidad_negocio,
                                    $selectSucursal2
                                    IFNULL(b.descr,'') AS familia,
                                    0 AS presupuesto,
                                    $condicionFecha
                                    SUM(a.monto) AS ejercido
                                FROM movimientos_presupuesto a 
                                LEFT JOIN fam_gastos b ON a.id_familia_gasto = b.id_fam
                                LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                                $leftSucursal
                                WHERE a.id_unidad_negocio=".$idUnidad." $condicionSucursal $condicionAnioS2 $condicionMesS2
                                GROUP BY a.id,a.id_familia_gasto
                                ) AS tabla
    
                            GROUP BY tabla.familia
                            ORDER BY tabla.familia ASC";
            
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'RECLASIFICACION_GASTOS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
            
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idArea = $arreglo['idArea'];
            $idDepartamento = $arreglo['idDepartamento'];
            $idFamiliaGasto = $arreglo['idFamiliaGasto'];
            $idClasificacion = $arreglo['idClasificacion'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            $sucursal = '';
            $area = '';
            $departamento = '';
            $familia = '';
            $clasificacion = '';
            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
            $condicion=" AND DATE(a.fecha_captura) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
            $condicion=" AND DATE(a.fecha_captura) >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
            $condicion=" AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            if($idSucursal > 0)
                $sucursal = " AND a.id_sucursal =".$idSucursal;

            if($idArea > 0)
                $area = " AND a.id_area =".$idArea;

            if($idDepartamento > 0)
                $departamento = " AND a.id_departamento =".$idDepartamento;

            if($idFamiliaGasto > 0)
                $familia = " AND a.id_familia_gasto =".$idFamiliaGasto;

            if($idClasificacion > 0)
                $clasificacion = " AND a.id_clasificacion =".$idClasificacion;

            $query = "SELECT IFNULL(d.nombre,'') AS UNIDAD_NEGOCIO,IFNULL(e.descr,'') AS SUCURSAL, 
                        IFNULL(f.descripcion,'') AS ÁREA,IFNULL(g.des_dep,'') AS DEPARTAMENTO,
                        IFNULL(h.descr,'') AS FAMILIA_GASTO,IFNULL(i.descr,'') AS CLASIFICACIÓN,
                        IFNULL(j.nombre,'') AS PROVEEDOR,c.folio AS FACTURA,DATE(a.fecha_captura) AS FECHA,
                        FORMAT(a.monto,2) AS IMPORTE,IFNULL(c.referencia,'') AS REFERENCIA
                        FROM movimientos_presupuesto a
                        LEFT JOIN almacen_d b ON a.id_almacen_d=b.id
                        LEFT JOIN almacen_e c ON b.id_almacen_e=c.id
                        LEFT JOIN proveedores j ON c.id_proveedor=j.id
                        LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
                        LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
                        LEFT JOIN cat_areas f ON a.id_area=f.id
                        LEFT JOIN deptos g ON a.id_departamento=g.id_depto
                        LEFT JOIN fam_gastos h ON a.id_familia_gasto=h.id_fam
                        LEFT JOIN gastos_clasificacion i ON a.id_clasificacion=i.id_clas
                        WHERE a.id_unidad_negocio = $idUnidadNegocio 
                        $sucursal $area $departamento $familia $clasificacion $condicion
                        ORDER BY a.fecha_captura DESC,a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'PRESUPUESTOS_INGRESOS_FACTURACION')
        {

           

            $arreglo = json_decode($datos, true);
            $idUnidad = $arreglo['idUnidad'];
            $anio = $arreglo['anio'];
            $mes = $arreglo['mes'];
            $tipo = $arreglo['tipo'];
            $fecha = $anio.'-'.$mes;
            $idRazonSocial = $arreglo['idRazonSocial'];
            $idsSucursal = $arreglo['idsSucursal'];
           
            if (strpos($idsSucursal, ',') !== false) {
                $dato=substr($idsSucursal,1);
                $condicionSucursales=' AND proyecto.id_sucursal in ('.$dato.')';
            }else{
                $condicionSucursales=' AND proyecto.id_sucursal ='.$idsSucursal;
            }

            if($idRazonSocial>0){
                $condicionRazonSocial = "AND contratos_cliente.id_razon_social_factura=".$idRazonSocial;
            }else{
                $condicionRazonSocial = "";
            }


            $condicionFecha1 = " AND (a.anio='$anio' AND a.mes='$mes')";
            $condicionFecha2 = " ('$fecha' BETWEEN DATE_FORMAT(contratos_cliente.fecha,'%Y-%m') AND DATE_FORMAT(contratos_cliente.vigencia,'%Y-%m'))";
            
            $query = "SELECT  
                sub.unidad AS UNIDAD,		
                sub.sucursal AS SUCURSAL,                                        
                sub.departamento AS DEPARTAMENTO,                    
                IFNULL(cat_areas.descripcion,'') AS AREA,                    
                IFNULL(facturas.observaciones,'') AS OBSERVACIONES,                    
                IFNULL(facturas.folio,'') AS FACTURA,                    
                IFNULL(empresas_fiscales.razon_social,'') AS RAZON_SOCIAL,                    
                IFNULL(DATE_ADD(facturas.fecha, INTERVAL  IFNULL(facturas.dias_credito,0) DAY),'') AS VENCIMIENTO,
                SUM(sub.total) AS TOTAL     
            FROM(
                /**SE OBTIENENE LOS COTRATOS Y COTIZACIONES POR VENCER */                        
                SELECT 
                    contratos_cliente.id_contrato AS id,
                    contratos_cliente.id_razon_social_factura,
                    GROUP_CONCAT(contratos_cliente.id_cotizacion) id_cotizacion,
                    contratos_cliente.id_depto,
                    deptos.des_dep AS departamento,
                    deptos.id_area,
                    b.descr AS sucursal,
                    c.descripcion AS unidad,
                    0 AS total
                FROM contratos_cliente 
                LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
                LEFT JOIN cotizacion ON contratos_cliente.id_cotizacion=cotizacion.id
                LEFT JOIN proyecto ON cotizacion.id_proyecto = proyecto.id
                LEFT JOIN sucursales b ON proyecto.id_sucursal=b.id_sucursal
                LEFT JOIN cat_unidades_negocio c ON proyecto.id_unidad_negocio=c.id
                WHERE $condicionFecha2 AND proyecto.id_unidad_negocio=".$idUnidad." $condicionSucursales  $condicionRazonSocial 
                UNION ALL
                /*SE OBTIENE EL TOTAL DE COTIZACIONES ELEMENTOS**/
                SELECT 
                    contratos_cliente.id_contrato AS id,
                    contratos_cliente.id_razon_social_factura,
                    '' id_cotizacion,
                    contratos_cliente.id_depto,
                    deptos.des_dep AS departamento,
                    deptos.id_area,
                    b.descr AS sucursal,
                    c.descripcion AS unidad,
                    IFNULL(SUM(costo_total),0) AS total
                FROM contratos_cliente 
                LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
                LEFT JOIN cotizacion ON contratos_cliente.id_cotizacion=cotizacion.id
                LEFT JOIN proyecto ON cotizacion.id_proyecto = proyecto.id
                LEFT JOIN sucursales b ON proyecto.id_sucursal=b.id_sucursal
                LEFT JOIN cat_unidades_negocio c ON proyecto.id_unidad_negocio=c.id
                LEFT JOIN cotizacion_elementos ON contratos_cliente.id_cotizacion=cotizacion_elementos.id_cotizacion
                WHERE $condicionFecha2 AND proyecto.id_unidad_negocio=".$idUnidad." $condicionSucursales  $condicionRazonSocial
                GROUP BY deptos.des_dep                          
                UNION ALL
                /*SE OBTIENE EL TOTAL DE COTIZACIONES EQUIPOS**/
                SELECT 
                    contratos_cliente.id_contrato AS id,
                    contratos_cliente.id_razon_social_factura,
                    '' id_cotizacion,
                    contratos_cliente.id_depto,
                    deptos.des_dep AS departamento,
                    deptos.id_area,
                    b.descr AS sucursal,
                    c.descripcion AS unidad,
                    IFNULL(SUM(IF(tipo_pago = 1 AND prorratear = 0,costo_total,0)),0) AS total
                FROM contratos_cliente 
                LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
                LEFT JOIN cotizacion ON contratos_cliente.id_cotizacion=cotizacion.id
                LEFT JOIN proyecto ON cotizacion.id_proyecto = proyecto.id
                LEFT JOIN sucursales b ON proyecto.id_sucursal=b.id_sucursal
                LEFT JOIN cat_unidades_negocio c ON proyecto.id_unidad_negocio=c.id
                LEFT JOIN cotizacion_equipo ON contratos_cliente.id_cotizacion=cotizacion_equipo.id_cotizacion
                WHERE $condicionFecha2 AND proyecto.id_unidad_negocio=".$idUnidad." $condicionSucursales  $condicionRazonSocial
                GROUP BY deptos.des_dep  
                UNION ALL
                /*SE OBTIENE EL TOTAL DE COTIZACIONES VEHICULOS**/
                SELECT 
                    contratos_cliente.id_contrato AS id,
                    contratos_cliente.id_razon_social_factura,
                    '' id_cotizacion,
                    contratos_cliente.id_depto,
                    deptos.des_dep AS departamento,
                    deptos.id_area,
                    b.descr AS sucursal,
                    c.descripcion AS unidad,
                    IFNULL(SUM(IF(tipo_pago = 1,costo_total,0)),0) AS total
                FROM contratos_cliente 
                LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
                LEFT JOIN cotizacion ON contratos_cliente.id_cotizacion=cotizacion.id
                LEFT JOIN proyecto ON cotizacion.id_proyecto = proyecto.id
                LEFT JOIN sucursales b ON proyecto.id_sucursal=b.id_sucursal
                LEFT JOIN cat_unidades_negocio c ON proyecto.id_unidad_negocio=c.id
                LEFT JOIN cotizacion_vehiculos ON contratos_cliente.id_cotizacion=cotizacion_vehiculos.id_cotizacion
                WHERE $condicionFecha2 AND proyecto.id_unidad_negocio=".$idUnidad." $condicionSucursales  $condicionRazonSocial
                GROUP BY deptos.des_dep  
                UNION ALL
                /*SE OBTIENE EL TOTAL DE COTIZACIONES SERVICIOS**/
                SELECT 
                    contratos_cliente.id_contrato AS id,
                    contratos_cliente.id_razon_social_factura,
                    '' id_cotizacion,
                    contratos_cliente.id_depto,
                    deptos.des_dep AS departamento,
                    deptos.id_area,
                    b.descr AS sucursal,
                    c.descripcion AS unidad,
                    IFNULL(SUM(IF(tipo_pago = 1,costo_total,0)),0) AS total
                FROM contratos_cliente 
                LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
                LEFT JOIN cotizacion ON contratos_cliente.id_cotizacion=cotizacion.id
                LEFT JOIN proyecto ON cotizacion.id_proyecto = proyecto.id
                LEFT JOIN sucursales b ON proyecto.id_sucursal=b.id_sucursal
                LEFT JOIN cat_unidades_negocio c ON proyecto.id_unidad_negocio=c.id
                LEFT JOIN cotizacion_servicios ON contratos_cliente.id_cotizacion=cotizacion_servicios.id_cotizacion
                WHERE $condicionFecha2 AND proyecto.id_unidad_negocio=".$idUnidad." $condicionSucursales  $condicionRazonSocial
                GROUP BY deptos.des_dep                          
            )AS sub 
            LEFT JOIN cat_areas ON sub.id_area=cat_areas.id
            LEFT JOIN empresas_fiscales  empresas_fiscales ON sub.id_razon_social_factura=empresas_fiscales.id_empresa
            LEFT JOIN facturas ON sub.id = facturas.id_contrato
            GROUP BY sub.id_depto";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'PAGOS_CXP'){
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar 

            $orden = $arreglo['orden'];
            $tipo = $arreglo['tipo'];

            if($orden == 0)
                $condicion = ' ORDER BY PROVEEDOR_EMPLEADO ASC, VENCE ASC';
            else
                $condicion = ' ORDER BY VENCE ASC';
            
            if($tipo == 1) //ordenes de compra
            {
                $query = "SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                                suc.clave AS CLAVE_SUCURSAL,
                                b.nombre AS PROVEEDOR_EMPLEADO,
                                a.no_factura AS FACTURA,
                                IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                                    DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                                    CASE 
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                                    ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                                    END) AS VENCE,
                                FORMAT((SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')),2) AS IMPORTE,
                                CONCAT('OC-',a.referencia) AS REFERENCIA,
                                c.clave AS BANCO, 
                                IFNULL(b.cuenta, '') AS CUENTA_CLABE,
                                'SI' AS VENCIDO
                        FROM cxp a
                        LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                        LEFT JOIN proveedores b ON a.id_proveedor=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        LEFT JOIN almacen_e d ON d.id=a.id_entrada_compra
                        LEFT JOIN orden_compra e ON e.id=d.id_oc 
                        LEFT JOIN requisiciones g ON e.ids_requisiciones=g.id
                        LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
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
                        SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                                suc.clave AS CLAVE_SUCURSAL,
                                b.nombre AS PROVEEDOR_EMPLEADO,
                                a.no_factura AS FACTURA,
                                IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                                DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                                    CASE 
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                                        WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                                    ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                                    END) AS VENCE,
                                FORMAT((SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')),2) AS IMPORTE,
                                CONCAT('OC-',a.referencia) AS REFERENCIA,
                                c.clave AS BANCO, 
                                IFNULL(b.cuenta, '') AS CUENTA_CLABE,
                                'NO' AS VENCIDO
                        FROM cxp a
                        LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                        LEFT JOIN proveedores b ON a.id_proveedor=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        LEFT JOIN almacen_e d ON d.id=a.id_entrada_compra
                        LEFT JOIN orden_compra e ON e.id=d.id_oc
                        LEFT JOIN requisiciones g ON e.ids_requisiciones=g.id 
                        LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
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
                            END)  BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 30 DAY)
                        HAVING importe > 0 
                    $condicion";
            }else if($tipo == 2) //deudores diversos
            {
                $query = "SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                    IF(a.id_trabajador=0,a.nombre,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS PROVEEDOR_EMPLEADO,
                    a.referencia AS FACTURA,
                    a.fecha AS VENCE,
                    FORMAT((a.subtotal+a.iva),2) AS IMPORTE,
                    CONCAT('DD-',a.referencia) AS REFERENCIA,
                    '' AS BANCO, 
                    '' AS CUENTA_CLABE,
                    'SI' AS VENCIDO
                    FROM gastos a
                    LEFT JOIN trabajadores b ON a.id_trabajador=b.id_trabajador
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    WHERE a.tipo_deudor=1 AND a.comprobado=0 AND a.estatus=1 AND a.fecha <= CURDATE()
                    HAVING importe > 0
                    UNION ALL
                    SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                    IF(a.id_trabajador=0,a.nombre,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS PROVEEDOR_EMPLEADO,
                    a.referencia AS FACTURA,
                    a.fecha AS VENCE,
                    FORMAT((a.subtotal+a.iva),2) AS IMPORTE,
                    CONCAT('DD-',a.referencia) AS REFERENCIA,
                    '' AS BANCO, 
                    '' AS CUENTA_CLABE,
                    'NO' AS VENCIDO
                    FROM gastos a
                    LEFT JOIN trabajadores b ON a.id_trabajador=b.id_trabajador
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    WHERE a.tipo_deudor=1 AND a.comprobado=0 AND a.estatus=1 
                    AND a.fecha BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 30 DAY)
                    HAVING importe > 0
                  $condicion";
            }else if($tipo == 3) //viaticos
            {
                $query = "SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                    suc.clave AS CLAVE_SUCURSAL,
                    IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS PROVEEDOR_EMPLEADO,
                    a.folio AS FACTURA, 
                    DATE(a.fecha_captura) AS VENCE,
                    FORMAT(a.total,2) AS IMPORTE, 
                    CONCAT('VIA-',a.folio) AS REFERENCIA,
                    '' AS BANCO,'' AS CUENTA_CLABE,
                    'SI' AS VENCIDO
                    FROM viaticos a
                    LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                    LEFT JOIN deudores_diversos c ON c.id_viatico=a.id 
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
                    WHERE a.reposicion_gasto=0 AND a.estatus='S' AND a.impresa=1 AND a.autorizo!='' AND IFNULL(c.id,0) > 0
                    HAVING importe > 0 
                    UNION ALL
                    SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                            suc.clave AS CLAVE_SUCURSAL,
                    IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS PROVEEDOR_EMPLEADO,
                    a.no_factura AS FACTURA,
                    a.fecha AS VENCE,
                    FORMAT((a.subtotal+a.iva),2) AS IMPORTE,
                    CONCAT('VIA-',a.referencia) AS REFERENCIA,
                    '' AS BANCO,
                    '' AS CUENTA_CLABE,
                    'SI' AS VENCIDO
                    FROM cxp a
                    LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
                    WHERE a.id_viatico > 0 AND a.estatus IN('A','P') AND a.fecha <= CURDATE()
                    HAVING importe > 0
                    UNION ALL
                    SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                            suc.clave AS CLAVE_SUCURSAL,
                    IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS PROVEEDOR_EMPLEADO,
                    a.folio AS FACTURA, 
                    DATE(a.fecha_captura) AS VENCE,
                    FORMAT(a.total,2) AS IMPORTE, 
                    CONCAT('VIA-',a.folio) AS REFERENCIA,
                    '' AS BANCO,'' AS CUENTA_CLABE,
                    'NO' AS VENCIDO
                    FROM viaticos a
                    LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                    LEFT JOIN deudores_diversos c ON c.id_viatico=a.id 
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
                    WHERE a.reposicion_gasto=0 AND a.estatus='S' AND a.impresa=1 AND a.autorizo!='' AND IFNULL(c.id,0) > 0
                    AND DATE(a.fecha_captura) BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 30 DAY)
                    HAVING importe > 0
                    UNION ALL
                    SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                                suc.clave AS CLAVE_SUCURSAL,
                    IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m))) AS PROVEEDOR_EMPLEADO,
                    a.no_factura AS FACTURA,
                    a.fecha AS VENCE,
                    FORMAT((a.subtotal+a.iva),2) AS IMPORTE,
                    CONCAT('VIA-',a.referencia) AS REFERENCIA,
                    '' AS BANCO,
                    '' AS CUENTA_CLABE,
                    'NO' AS VENCIDO
                    FROM cxp a
                    LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
                    WHERE a.id_viatico > 0 AND a.estatus IN ('P','A')
                    AND a.fecha BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 30 DAY)
                    HAVING importe > 0
                  $condicion";
            }else if($tipo == 4) //anticipos
            {
                $query = "SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                    suc.clave AS CLAVE_SUCURSAL,
                    b.nombre AS PROVEEDOR_EMPLEADO,
                    CONCAT(a.id,'',a.id_requisicion) AS FACTURA, 
                    a.fecha AS VENCE,
                    FORMAT((SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')),2) AS IMPORTE,
                    CONCAT('AR-',d.folio) AS REFERENCIA,
                    IFNULL(c.clave,'') AS BANCO,
                    IFNULL(b.cuenta,'') AS CUENTA_CLABE,
                    'SI' AS VENCIDO
                    FROM cxp a
                    LEFT JOIN proveedores b ON a.id_proveedor=b.id
                    LEFT JOIN bancos c ON b.id_banco=c.id
                    LEFT JOIN requisiciones d ON a.id_requisicion=d.id
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
                    WHERE a.id_requisicion > 0 AND a.id_viatico = 0 AND a.estatus IN('P','A') 
                    AND  a.fecha  <= CURDATE()
                    HAVING importe > 0
                    UNION ALL
                    SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                    suc.clave AS CLAVE_SUCURSAL,
                    b.nombre AS PROVEEDOR_EMPLEADO,
                    CONCAT(a.id,'',a.id_requisicion) AS FACTURA, 
                    a.fecha AS VENCE,
                    FORMAT((SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')),2) AS IMPORTE,
                    CONCAT('AR-',d.folio) AS REFERENCIA,
                    IFNULL(c.clave,'') AS BANCO,
                    IFNULL(b.cuenta,'') AS CUENTA_CLABE,
                    'NO' AS VENCIDO
                    FROM cxp a
                    LEFT JOIN proveedores b ON a.id_proveedor=b.id
                    LEFT JOIN bancos c ON b.id_banco=c.id
                    LEFT JOIN requisiciones d ON a.id_requisicion=d.id
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
                    WHERE a.id_requisicion > 0 AND a.id_viatico = 0 AND a.estatus IN('P','A') 
                    AND a.fecha BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 30 DAY)
                    HAVING importe > 0
                  $condicion";

            }else{
                $query = "SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                    suc.clave AS CLAVE_SUCURSAL,
                    b.nombre AS PROVEEDOR_EMPLEADO,
                    a.no_factura AS FACTURA,
                    IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                    DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                    CASE 
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                    ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                    END) AS VENCE,
                    FORMAT((SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')),2) AS IMPORTE,
                    CONCAT('OS-',a.referencia) AS REFERENCIA,
                    c.clave AS BANCO, 
                    IFNULL(b.cuenta, '') AS CUENTA_CLABE,
                    'SI' AS VENCIDO
                    FROM cxp a
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    LEFT JOIN proveedores b ON a.id_proveedor=b.id
                    LEFT JOIN bancos c ON b.id_banco=c.id
                    LEFT JOIN almacen_e d ON d.id=a.id_entrada_compra
                    LEFT JOIN orden_compra e ON e.id=d.id_oc 
                    LEFT JOIN requisiciones g ON e.ids_requisiciones=g.id 
                    LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
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
                    HAVING importe > 0
                    UNION ALL
                    SELECT f.clave AS CLAVE_UNIDAD_NEGOCIO,
                    suc.clave AS CLAVE_SUCURSAL,
                    b.nombre AS PROVEEDOR_EMPLEADO,
                    a.no_factura AS FACTURA,
                    IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
                    DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
                    CASE 
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
                    ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
                    END) AS VENCE,
                    FORMAT((SELECT IFNULL(SUM(IF((SUBSTR(clave_concepto,1,1) = 'C'),(subtotal + iva - descuento),((subtotal + iva - descuento) * -(1)))),0) FROM cxp WHERE id_cxp=a.id_cxp AND a.estatus IN('P','A')),2) AS IMPORTE,
                    CONCAT('OS-',a.referencia) AS REFERENCIA,
                    c.clave AS BANCO, 
                    IFNULL(b.cuenta, '') AS CUENTA_CLABE,
                    'NO' AS VENCIDO
                    FROM cxp a
                    LEFT JOIN cat_unidades_negocio f ON a.id_unidad_negocio=f.id
                    LEFT JOIN proveedores b ON a.id_proveedor=b.id
                    LEFT JOIN bancos c ON b.id_banco=c.id
                    LEFT JOIN almacen_e d ON d.id=a.id_entrada_compra
                    LEFT JOIN orden_compra e ON e.id=d.id_oc
                    LEFT JOIN requisiciones g ON e.ids_requisiciones=g.id 
                    LEFT JOIN sucursales suc ON suc.id_sucursal = a.id_sucursal
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
                    END)  BETWEEN ADDDATE(CURDATE(), INTERVAL 1 DAY) AND  ADDDATE(CURDATE(), INTERVAL 30 DAY)
                    HAVING importe > 0 
                  $condicion";
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'DEUDORES_DIVERSOS')
        {

            $query = "SELECT IF(a.id_empleado > 0,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m)),a.empleado) AS NOMBRE,
            a.categoria AS CATEGORIA,
            a.importe AS IMPORTE,
            a.fecha AS FECHA,
            IF(a.id_gasto > 0,'GASTO','VIATICO') AS TIPO
                        
                        FROM deudores_diversos a
                        LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                        WHERE a.comprobado=0
                        ORDER BY a.fecha ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'R_PENDIENTES_AUTORIZAR')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar 

            //$idsUnidades = $arreglo['idsUnidades'];
            $idUsuario = $arreglo['idUsuario'];

            $idsUnidades=substr($arreglo['idsUnidades'],1);

            $query = "SELECT 
            b.nombre AS UNIDAD_NEGOCIO,
            c.descripcion AS SUCURSAL,
            a.folio AS FOLIO,
            a.descripcion AS DESCRIPCION,
            IF(a.tipo=0,'ACTIVOS FIJOS',IF(a.tipo=1,'GASTOS',IF(a.tipo=2,'MANTENIMIENTO','STOCK')))AS TIPO,
            FORMAT(a.total,2) AS TOTAL,
            IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'No Autorizada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar','Pagada'))))) AS ESTATUS
                    FROM requisiciones a
                    LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                    LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                    LEFT JOIN cat_autorizaciones d ON d.id_usuario = $idUsuario AND d.activo=1
                    WHERE a.id_unidad_negocio IN ($idsUnidades) AND a.estatus=1 AND (a.id_orden_compra='' OR ISNULL(a.id_orden_compra) OR a.id_orden_compra=0)";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'CXC')
        {

            $arreglo = json_decode($datos, true);

            $idUnidadNegocio = $arreglo['idUNidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $todas = $arreglo['todas'];
           
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            $clientesInactivos = isset($arreglo['clientesInactivos']) ? $arreglo['clientesInactivos'] : 1;

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

            if($todas == 1)
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }

            //-->NJES November/20/2020 agregar campos a reporte excel
            //-->NJES April/30/2021 mostrarid_cliente.id_razon_social y rfc_receptor a reporte excel
            $query = "SELECT 
                            b.nombre AS UNIDAD_DE_NEGOCIO,           
                            c.descr AS SUCURSAL,
                            a.fecha AS FECHA,
                            a.vencimiento AS FECHA_VENCIMIENTO,
                            d.id_cliente AS ID_CLIENTE,
                            e.nombre_comercial AS CLIENTE,
                            a.id_razon_social AS ID_RAZÓN_SOCIAL,
                            d.razon_social AS RAZÓN_SOCIAL,
                            d.rfc AS RFC_RECEPTOR, 
                            fac.razon_social AS EMISOR,
                            a.id AS FOLIO_CXC,
                            IF(a.folio_factura = 0,'',a.folio_factura) AS FACTURA,
                            IF(ntc.folio_nota_credito is null ,'', ntc.folio_nota_credito) AS FOLIO_NOTA_CREDITO,
                            IFNULL(pagos.folios_pagos,'') AS FOLIO_PAGO,
                            IFNULL(pagos.fechas_pagos,'') AS FECHA_PAGO,
                            (a.total - IFNULL(fac.importe_retencion,0) )AS CARGO_INICIAL,
                            IFNULL(pagos.total_abonos, 0) AS PAGO,
                            IFNULL(ntc.abonos_notas, 0) AS NOTA_CREDITO,
                            IF(a.folio_cxc > 0, 
                                -- IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),((a.subtotal + a.iva - IFNULL(fac.importe_retencion,0))),(((a.subtotal + a.iva - IFNULL(fac.importe_retencion,0))) * -(1))),0)),0),
                                IFNULL(SUM(IF(a.estatus NOT IN('C','P'),a.subtotal + a.iva - IFNULL(fac.importe_retencion,0) + IFNULL((ac_cxc.cargos_cxc),0) - IFNULL((ac_cxc.abonos_cxc),0),0)),0),
                                ( (a.total - IFNULL(fac.importe_retencion,0) + IFNULL((ac_cxc.cargos_cxc),0)) - ( (IFNULL(ntc.abonos_notas, 0)) + (IFNULL(pagos.total_abonos, 0)) + IFNULL((ac_cxc.abonos_cxc),0) ))) AS SALDO,
                            CASE

                                WHEN IF(a.folio_cxc > 0, a.estatus, fcfdi.estatus) = 'T' THEN 'TIMBRADA'
                                WHEN IF(a.folio_cxc > 0, a.estatus, fcfdi.estatus) = 'C' THEN 'CANCELADA'
                                WHEN IF(a.folio_cxc > 0, a.estatus, fcfdi.estatus) = 'P' THEN 'PENDIENTE'
                                WHEN IF(a.folio_cxc > 0, a.estatus, fcfdi.estatus) = 'A' THEN 'SIN TIMBRAR'
                                WHEN IF(a.folio_cxc > 0, a.estatus, fcfdi.estatus) = 'S' THEN 'PAGADA'
                                ELSE IF(a.folio_cxc > 0, a.estatus, fcfdi.estatus)
                                
                                /*WHEN a.estatus = 'T' THEN 'TIMBRADA'
                                WHEN a.estatus = 'C' THEN 'CANCELADA'
                                WHEN a.estatus = 'P' THEN 'PENDIENTE'
                                WHEN a.estatus = 'A' THEN 'SIN TIMBRAR'
                                WHEN a.estatus = 'S' THEN 'PAGADA'
                                ELSE a.estatus*/
                            END AS ESTATUS                               
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
                                id_factura AS id_factura,
                                GROUP_CONCAT(pagos_e.folio,' ') AS folios_pagos,
                                GROUP_CONCAT(DATE(pagos_e.fecha),' ') AS fechas_pagos
                                FROM 
                                pagos_d
                                INNER JOIN pagos_cfdi ON pagos_d.id_pago_e = pagos_cfdi.id_pago_e 
                                INNER JOIN pagos_e ON pagos_d.id_pago_e = pagos_e.id
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
                    ORDER BY a.id DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }


        if($modulo == 'SERVICIOS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar 

            //$idsUnidades = $arreglo['idsUnidades'];
            //$idUsuario = $arreglo['idUsuario'];

            $query = "SELECT
                        sucursales.descr AS SUCURSAL,
                        servicios.cuenta AS CUENTA, 
                        servicios.rfc AS RFC, 
                        servicios.nombre_corto AS NOMBRE_CORTO, 
                        IFNULL(IF(servicios.razon_social!='',servicios.razon_social,servicios.nombre_corto),servicios.nombre_corto) AS RAZÓN_SOCIAL,
                        servicios.r_legal AS REPRESENTANTE_LEGAL,
                        IF(servicios.activo=1,'ACTIVO','INACTIVO') AS ESTATUS,
                    
                        servicios.domicilio AS DOMICILIO,
                        servicios.no_exterior AS NO_EXT,
                        servicios.no_interior AS NO_INT,
                        servicios.colonia AS COLONIA,
                        municipios.municipio AS MUNICIPIO,
                        estados.estado AS ESTADO,
                        paises.pais AS PAIS,
                        servicios.codigo_postal AS CODIGO_POSTAL,
                    
                        servicios.telefonos AS TELEFONOS,
                        servicios.ext AS EXTENSION,
                        servicios.celular,
                        servicios.otros_contactos AS OTROS_CONTACTOS,
                        servicios.contacto AS CONTACTO,
                        servicios.correos AS CORREOS,
                    
                        servicios_cat_planes.descripcion AS PLAN,
                        servicios_cat_planes.cantidad AS IMPORTE_PLAN,
                        IF(servicios.entrega=0,'FISICA',IF(servicios.entrega=1,'CORREO ELECTRNICO','FISICA Y CORREO ELECTRONICO')) AS TIPO_ENTREGA,
                        servicios.dia_corte AS FECHA_CORTE,
                        IF(servicios.tipo_recibo_facura='R','RECIBO','FACTURA') AS TIPO_RECIBO_FACTURA,
                        IF(servicios.pago='E','EFECTIVO','TRANSFERENCIA')AS TIPO_PAGO,
                        (SELECT IFNULL(especificaciones_cobranza,'') FROM servicios_bitacora_planes WHERE id_servicio=servicios.id ORDER BY id DESC LIMIT 1) AS ESPECIFICACIONES_COBRANZA,
                        servicios.fecha_captura AS FECHA_CAPTURA,
                        tabla.fecha,
                        tabla.vencimiento
                    FROM servicios 
                    LEFT JOIN municipios  ON servicios.id_municipio=municipios.id
                    LEFT JOIN estados  ON servicios.id_estado=estados.id
                    LEFT JOIN paises  ON servicios.id_pais=paises.id
                    LEFT JOIN servicios_cat_planes  ON servicios.id_plan=servicios_cat_planes.id
                    LEFT JOIN sucursales ON servicios.id_sucursal = sucursales.id_sucursal
                    LEFT JOIN (SELECT MAX(cxc.fecha) AS fecha, MAX(cxc.vencimiento) as vencimiento, cxc.id_sucursal, sbp.id_servicio
                                FROM cxc
                                INNER JOIN servicios_bitacora_planes sbp ON sbp.id = cxc.id_plan
                                GROUP BY sbp.id_servicio
                                ORDER BY cxc.id DESC) as tabla ON tabla.id_sucursal = servicios.id_sucursal AND tabla.id_servicio = servicios.id
                    ORDER BY servicios.id";

                    // echo $query;
                    // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'CXC_ALARMAS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar 
            $idCliente = $arreglo['idCliente'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            $condicion = " AND a.id_razon_social_servicio = ".$idCliente." AND a.estatus!='C'";

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
            

            $query = "SELECT 
            IFNULL(IF(c.razon_social!='',c.razon_social,c.nombre_corto),c.nombre_corto) AS CLIENTE,
            d.descr AS SUCURSAL,
                a.fecha AS FECHA,
                IFNULL(a.referencia,'') AS REFERENCIA,
                a.id_orden_servicio AS ID_ORDEN,
                a.folio_cxc AS FOLIO_CXC,
                IF(e.folio>0,e.folio,'') AS FOLIO_FACTURA,
                IFNULL(IF(e.es_plan=1,a.vencimiento,DATE_ADD(e.fecha, INTERVAL e.dias_credito DAY)),'') AS FECHA_VENCIMIENTO,
                CONCAT(a.cve_concepto ,'-', b.descripcion)AS CONCEPTO,
                IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),0) AS CARGOS,
                -- IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) AS ABONOS
                IF( IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) = 0, IFNULL(pagos_abonos.importe_pagado, 0), IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) ) AS ABONOS

                FROM cxc a
                LEFT JOIN conceptos_cxp b ON a.cve_concepto=b.clave AND b.tipo=1
                LEFT JOIN servicios c ON a.id_razon_social_servicio=c.id
                LEFT JOIN sucursales d ON a.id_sucursal = d.id_sucursal
                LEFT JOIN facturas e ON a.id_factura=e.id
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
                WHERE 1 $condicion
                AND a.folio_cxc IN(SELECT DISTINCT(a.folio_cxc ) AS folio_cxc FROM cxc a  WHERE 1 $condicion $condFecha)
                ORDER BY a.id ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'COTIZACIONES_REPORTES')
        {

            $arreglo = json_decode($datos, true);

            $condicionFecha='';
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicionFecha=" AND DATE(a.timestamp_version) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicionFecha=" AND DATE(a.timestamp_version) >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicionFecha=" AND DATE(a.timestamp_version) >= '$fechaInicio' AND DATE(a.timestamp_version) <= '$fechaFin' ";
            }

            //-->NJES December/15/2020 agregar campos en reporte de cotizaciones
            $query = "SELECT
            sub.folio AS FOLIO,
            sub.cotizacion AS COTIZACION,
            sub.version AS VERSION,
            sub.fecha_creacion AS FECHA_CREACION,
            sub.proyecto AS PROYECTO,
            sub.cliente AS CLIENTE,
            sub.sucursal AS SUCURSAL,
            sub.unidad_negocio AS UNIDAD_NEGOCIO,
            sub.costo_total AS COSTO_TOTAL,
            sub.precio_total AS PRECIO_DE_VENTA_TOTAL,
            CONCAT(((((sub.precio_total+sub.inversion_cliente)*100)/((sub.inversion_secorp/12)+sub.costo_total))-100),'%') AS PORCENTAJE_UTILIDAD,
            sub.estatus_cotizacion AS ESTATUS_COTIZACION,
            sub.estatus_proyecto AS ESTATUS_PROYECTO,
            sub.justificacion_rechazada AS JUSTIFICACION_RECHAZO,
            sub.usuario_captura AS USUARIO 
            FROM (
                SELECT 
                a.folio AS folio,
                a.nombre AS cotizacion,
                a.version,
                a.timestamp_version AS fecha_creacion,
                b.descripcion AS proyecto,
                c.nombre AS cliente,
                d.descr AS sucursal,
                e.nombre AS unidad_negocio,
                IF(a.estatus=1,'ACTIVA','IMPRESA') AS estatus_cotizacion,
                IF(b.estatus=1,'Proceso',IF(b.estatus=2,'Negociación',IF(b.estatus=3,'Rechazada','Aprobada'))) AS estatus_proyecto,
                IFNULL(a.justificacion_rechazada,'') AS justificacion_rechazada,
                b.usuario_captura,
                (IFNULL(SUM(cotizacion_elementos.costo_total),0) +
                IFNULL(SUM(IF(cotizacion_equipo.tipo_pago = 1 AND cotizacion_equipo.prorratear = 0,cotizacion_equipo.costo_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_servicios.tipo_pago = 1,cotizacion_servicios.costo_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_vehiculos.tipo_pago = 1,cotizacion_vehiculos.costo_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_consumibles.tipo_pago = 1 AND cotizacion_consumibles.prorratear = 0,cotizacion_consumibles.costo_total,0)),0)) AS costo_total,
                
                (IFNULL(SUM(cotizacion_elementos.precio_total),0) +
                IFNULL(SUM(IF(cotizacion_equipo.tipo_pago = 1,cotizacion_equipo.precio_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_servicios.tipo_pago = 1,cotizacion_servicios.precio_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_vehiculos.tipo_pago = 1,cotizacion_vehiculos.precio_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_consumibles.tipo_pago = 1,cotizacion_consumibles.precio_total,0)),0)) AS precio_total,
            
                (IFNULL(SUM(IF(cotizacion_equipo.tipo_pago = 2 AND cotizacion_equipo.prorratear = 0,cotizacion_equipo.costo_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_servicios.tipo_pago = 2,cotizacion_servicios.costo_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_vehiculos.tipo_pago = 2,cotizacion_vehiculos.costo_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_consumibles.tipo_pago = 2 AND cotizacion_consumibles.prorratear = 0,cotizacion_consumibles.costo_total,0)),0)) AS inversion_secorp,
            
                (IFNULL(SUM(IF(cotizacion_equipo.tipo_pago = 2,cotizacion_equipo.precio_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_servicios.tipo_pago = 2,cotizacion_servicios.precio_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_vehiculos.tipo_pago = 2,cotizacion_vehiculos.precio_total,0)),0) +
                IFNULL(SUM(IF(cotizacion_consumibles.tipo_pago = 2,cotizacion_consumibles.precio_total,0)),0)) AS inversion_cliente
                FROM cotizacion a
                LEFT JOIN proyecto b ON a.id_proyecto=b.id
                LEFT JOIN pre_clientes c ON a.id_cliente=c.id
                LEFT JOIN sucursales d ON b.id_sucursal=d.id_sucursal
                LEFT JOIN cat_unidades_negocio e ON d.id_unidad_negocio=e.id
                LEFT JOIN cotizacion_elementos ON a.id=cotizacion_elementos.id_cotizacion
                LEFT JOIN cotizacion_equipo ON a.id=cotizacion_equipo.id_cotizacion
                LEFT JOIN cotizacion_servicios ON a.id=cotizacion_servicios.id_cotizacion
                LEFT JOIN cotizacion_vehiculos ON a.id=cotizacion_vehiculos.id_cotizacion
                LEFT JOIN cotizacion_consumibles ON a.id=cotizacion_consumibles.id_cotizacion
                WHERE 1=1
                $condicionFecha
                GROUP BY a.id
                ORDER BY a.id DESC
            ) AS sub";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTE_VIATICOS')
        {

            $arreglo = json_decode($datos, true);

            $condicionFecha='';
            $idsSucursal = $arreglo['idsSucursal'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            
            $dato=substr($idsSucursal,1);
       
    
            $condicionSucursales='WHERE a.id_sucursal in ('.$dato.')';

            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND MONTH(a.fecha_captura)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND a.fecha_captura >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            $query = "SELECT 
                        e.nombre AS UNIDAD_NEGOCIO,
                        b.descr AS SUCURSAL,
                        DATE(a.fecha_captura) AS FECHA_CAPTURA,
                        a.folio AS FOLIO,
                        IF(a.id_empleado=0,a.nombre_empleado,(CONCAT(c.nombre,' ',c.apellido_p,' ',c.apellido_m))) AS EMPLEADO,
                        a.destino AS DESTINO,
                        a.fecha_inicio AS FECHA_INICIO,
                        a.fecha_fin AS FECHA_FIN,
                        a.total AS TOTAL,
                        IF(a.estatus='A','ACTIVO',IF(a.estatus='S','SOLICITADO',IF(a.estatus='CA','CANCELADO','COMPROBADO'))) AS ESTATUS,
                        IF(a.reposicion_gasto=0,'DEUDOR DIVERSO','REPOSICIÓN GASTO') AS TIPO,
                        IF(a.estatus='CA','CANCELADO',IF(IFNULL(d.id_viatico,0) > 0,IF(d.id is null,'Sin Pagar','Pagado'),IF(IFNULL(f.id_viatico,0) > 0,IF(f.estatus='L','Pagado',IF(f.estatus='C','Cancelado','Sin Pagar')),'Sin Pagar'))) AS ESTATUS_FINANZAS,
                        a.usuario_captura AS USUARIO                    
                    FROM  viaticos a
                    LEFT JOIN cat_unidades_negocio e ON  a.id_unidad_negocio = e.id
                    LEFT JOIN sucursales b ON a.id_sucursal = b.id_sucursal
                    LEFT JOIN trabajadores c ON a.id_empleado =  c.id_trabajador
                    LEFT JOIN deudores_diversos d ON a.id=d.id_viatico
                    LEFT JOIN cxp f ON a.id=f.id_viatico
                    $condicionSucursales $condicion
                    GROUP BY a.id
                    ORDER BY a.id DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTE_ORDENES_SERVICIO')
        {

            $arreglo = json_decode($datos, true);

            $idsSucursal = $arreglo['idsSucursal'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            
            //$dato=substr($idsSucursal,1);
            //$condicionSucursales='WHERE a.id_sucursal in ('.$dato.')';
            //-->NJES October/21/2020 se agrega filtro sucursal
            if($idsSucursal[0] == ',')
            {
                $dato=substr($idsSucursal,1);
                $condicionSucursales='WHERE a.id_sucursal IN ('.$dato.')';
            }else{ 
                $condicionSucursales='WHERE a.id_sucursal ='.$idsSucursal;
            }

            $condFecha = '';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condFecha=" AND a.fecha_captura >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condFecha=" AND  a.fecha_captura >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condFecha=" AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }
        

            $query = "SELECT
                c.descr AS SUCURSAL,
                a.id AS FOLIO,
                b.cuenta AS CUENTA,
                b.nombre_corto AS NOMBRE_CORTO,
                b.razon_social AS RAZON_SOCIAL,
                a.servicio AS SERVICIO,
                h.descripcion AS CLASIFICACIÓN,
                a.fecha_solicitud AS FECHA_SOLICITUD,
                CONCAT(d.usuario,' - ', d.nombre_comp) AS USUARIO_CAPTURA,
                a.fecha_captura AS FECHA_CAPTURA,
                a.fecha_servicio AS FECHA_PROGRAMADA,
                IF(a.fecha_pendiente='0000-00-00 00:00:00','',a.fecha_pendiente)AS FECHA_SEGUIMIENTO,
                IF(a.fecha_cancelacion='0000-00-00 00:00:00','',a.fecha_cancelacion)AS FECHA_CANCELACION,
                IF(a.fecha_cierre='0000-00-00 00:00:00','',a.fecha_cierre)AS FECHA_CIERRE,
                IF(a.estatus_orden='A','GENERADA',IF(a.estatus_orden='P','PENDIENTE','CANCELADA')) AS ESTATUS_ORDEN,
                a.acciones_realizadas AS ACCIONES_REALIZADAS,
                IF(a.estatus_cierre=0,'PENDIENTE','CERRADA') AS ESTATUS_CIERRE,
                IF(a.sin_cobro = 0 && IFNULL(cxc.id_orden_servicio,0) > 0,'Con cobro','Sin cobro') AS ESTATUS_COBRO,
                IFNULL(IF(a.sin_cobro = 0,FORMAT(cxc.total,2),''),'') AS MONTO
            FROM servicios_ordenes a
            LEFT JOIN servicios b ON a.id_servicio=b.id
            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
            LEFT JOIN usuarios d ON a.id_usuario_captura= d.id_usuario
            LEFT JOIN servicios_clasificacion h ON a.id_clasificacion_servicio=h.id
            LEFT JOIN cxc ON a.id=cxc.id_orden_servicio
            $condicionSucursales $condFecha
            ORDER BY a.fecha_captura DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTE_SEGUIMIENTO_ORDENES')
        {

            $arreglo = json_decode($datos, true);

            $idsSucursal = $arreglo['idsSucursal'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            //$dato=substr($idsSucursal,1);
            //$condicionSucursales='WHERE a.id_sucursal in ('.$dato.')';
            
            //-->NJES October/21/2020 se agrega filtro sucursal
            if($idsSucursal[0] == ',')
            {
                $dato=substr($idsSucursal,1);
                $condicionSucursales='WHERE a.id_sucursal IN ('.$dato.')';
            }else{ 
                $condicionSucursales='WHERE a.id_sucursal ='.$idsSucursal;
            }

            $condFecha = '';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condFecha=" AND a.fecha_captura >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condFecha=" AND  a.fecha_captura >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condFecha=" AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

                $query = "SELECT
                c.descr AS SUCURSAL, 
                a.id AS FOLIO,
                a.servicio AS SERVICIO,
                a.descripcion AS DESCRIPCION,
                a.tecnico AS TECNICO,
                IF(a.fecha_atencion='0000-00-00','',a.fecha_atencion) AS ATENCION,
                if(a.hora_llegada='00:00:00','',a.hora_llegada) as HORA_LLEGADA,
                a.gps_llegada AS GPS_LLEGADA,
                if(a.hora_salida='00:00:00','',a.hora_salida) as HORA_SALIDA,
                a.gps_salida AS GPS_SALIDA
            FROM servicios_ordenes a
            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
            $condicionSucursales $condFecha
            ORDER BY a.fecha_captura DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo=='CUOTAS_OBRERO'){

            $query="SELECT a.id AS ID,b.razon_social AS RAZÓN_SOCIAL,a.salario_diario AS SALARIO_DIARIO,
                    a.salario_integrado AS SALARIO_DIARIO_INTEGRADO,a.imss AS CUOTA_IMSS,
                    a.infonavit AS CUOTA_INFONAVIT,a.sar AS SAR,a.concepto AS CONCEPTO_SUELDO,
                    IF(a.inactivo=0,'ACTIVO','INACTIVO') AS ESTATUS
                    FROM cat_cuotas_obrero a
                    LEFT JOIN empresas_fiscales b ON a.id_razon_social=b.id_empresa
                    ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='SALDOS_CLIENTES'){
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $id = isset($arreglo['id']) ? $arreglo['id'] : 0;
            $tipo = $arreglo['tipo'];
            
            if($tipo == 1)
            {
                $query = "SELECT   
                facturas.id_cliente AS CLAVE, 
                cat_clientes.nombre_comercial AS NOMBRE_COMERCIAL_CLIENTE,              
                FORMAT(SUM(facturas.total - facturas.importe_retencion) - (pagos.total_pagos + (IFNULL(notas.total_notas, 0))),2) AS SALDO
            
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

                
            }else if($tipo == 2)
            {
                //-->NJES July/19/2020 se muestra unidad de negoci y sucursal
                $query = "SELECT
                cat_unidades_negocio.nombre AS UNIDAD_DE_NEGOCIO,
                sucursales.descr AS SUCURSAL,
                razones_sociales.nombre_corto AS NOMBRE_CORTO,
                razones_sociales.razon_social AS RAZÓN_SOCIAL,
                FORMAT(SUM(facturas.total - facturas.importe_retencion) -  (IFNULL(pagos.total_pagos, 0) + (IFNULL(notas.total_notas, 0))),2)  AS SALDO
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

                            
                            
            }else{
                //-->NJES November/20/2020 agregar campos
            $query = "SELECT 
                facturas.folio AS NO_FACTURA,
                facturas.fecha AS FECHA,
                FORMAT((facturas.total - facturas.importe_retencion),2) AS MONTO_FACTURA,
                ifnull(facturas.fecha_inicio, '') as INICIO_PERIODO,
                ifnull(facturas.fecha_fin, '') as FIN_PERIODO,
                CASE 
                    WHEN ((facturas.total - facturas.importe_retencion) - (IFNULL(pagos.total_pagos, 0) + (IFNULL(notas.total_notas, 0)))) = 0 THEN 'PAGADA'
                    
                    WHEN facturas_cfdi.estatus = 'A' THEN 'SIN TIMBRAR'
                    WHEN facturas_cfdi.estatus = 'P' THEN 'PENDIENTE CANCELAR'
                    WHEN facturas_cfdi.estatus = 'C' THEN 'CANCELADA'
                    ELSE 'TIMBRADA'
                    END AS ESTATUS,
                    /*WHEN facturas.estatus = 'A' THEN 'SIN TIMBRAR'
                    WHEN facturas.estatus = 'P' THEN 'PENDIENTE CANCELAR'
                    WHEN facturas.estatus = 'C' THEN 'CANCELADA'
                    ELSE 'TIMBRADA'
                END AS ESTATUS,*/
                -- ifnull(cxc.vencimiento,'') as FECHA_VENCIMIENTO,
                DATE_ADD(facturas.fecha, INTERVAL IFNULL(facturas.dias_credito,0) DAY) AS FECHA_VENCIMIENTO,
                IFNULL(pagos.folios_pagos,'') AS FOLIOS_DE_PAGOS,
                IFNULL(pagos.fechas_pagos,'') AS FECHAS_DE_PAGOS,
                IFNULL(pagos.total_pagos, 0) AS PAGO,
                (IFNULL(notas.total_notas, 0)) AS NOTA_CREDITO,
                (facturas.total - facturas.importe_retencion) - (IFNULL(pagos.total_pagos, 0) + (IFNULL(notas.total_notas, 0))) AS SALDO_FINAL_FACTURA
                FROM facturas
                left join cxc on cxc.id_factura = facturas.id
                left join facturas_cfdi on facturas.id = facturas_cfdi.id_factura
                INNER JOIN razones_sociales ON facturas.id_razon_social =  razones_sociales.id
                LEFT JOIN
                (
                SELECT
                pagos_d.id_factura,
                GROUP_CONCAT(pagos_e.folio,' ') AS folios_pagos,
                GROUP_CONCAT(DATE(pagos_e.fecha),' ') AS fechas_pagos,
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
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo=='SALDOS_CLIENTES_ALARMAS'){
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $id = isset($arreglo['id']) ? $arreglo['id'] : 0;
            $tipo = $arreglo['tipo'];
            
            if($tipo == 1)
            {
                $query = "SELECT 
                IF(IFNULL(n.id,'')='','TOTAL',n.id) AS CLAVE,
                IF(IFNULL(n.id,'')='','',n.nombre_comercial) AS NOMBRE_COMERCIAL,
                FORMAT(SUM(n.total),2) AS SALDO
                FROM (
                    SELECT 
                        fn.id_cliente AS id,
                        TRIM(a.razon_social) AS nombre_comercial,
                        SUM(IF(fn.tipo IN ('N','P'),fn.total*-1,fn.total)) AS total
                    FROM (
                        SELECT 
                            id_cliente,
                            folio,
                            fecha,
                            'F' AS tipo,id AS  id_factura,
                            SUM(total) AS total
                        FROM facturas 
                        WHERE  estatus IN('A','T') AND id_factura_nota_credito=0 AND id_unidad_negocio=2
                        GROUP BY id_cliente
                        UNION ALL
                        SELECT 
                            id_cliente,
                            folio,fecha,
                            'N' AS tipo,
                            id_factura_nota_credito AS id_factura,
                            SUM(total) AS total
                        FROM facturas 
                        WHERE estatus IN('A','T') AND id_factura_nota_credito!=0 AND id_unidad_negocio=2
                        GROUP BY id_cliente 
                        UNION ALL
                        SELECT
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
                        SELECT 
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
                    ORDER BY a.razon_social
                     ) AS n
                GROUP BY n.id WITH ROLLUP";
                                    
            }else{
                $query = "SELECT 
                IF(IFNULL(n.id,'')='','TOTAL',n.folio) AS FOLIO,
                IF(IFNULL(n.id,'')='','',n.fecha) AS FECHA,
                FORMAT(SUM(n.total),2) AS TOTAL_FACTURA,
                IF(IFNULL(n.id,'')='','',n.fecha_inicio) AS INICIO_PERIODO,
                IF(IFNULL(n.id,'')='','',n.fecha_fin) AS FIN_PERIODO
                FROM (  
                    SELECT fn.id,fn.folio,fn.fecha,fn.fecha_inicio,fn.fecha_fin,
                      SUM(IF(fn.tipo IN ('N','P'),fn.total*-1,fn.total)) AS total
                    FROM 
                      (SELECT 
                            id,
                            folio,
                            fecha,
                            'F' AS tipo,
                            id AS  id_factura,
                            SUM(total) AS total,fecha_inicio,fecha_fin 
                      FROM facturas 
                      WHERE id_razon_social=$id AND estatus IN('A','T') AND id_factura_nota_credito=0 AND id_unidad_negocio=2
                      GROUP BY id
                      UNION ALL
                      SELECT 
                            id,
                            folio,
                            fecha,
                            'N' AS tipo,
                            id_factura_nota_credito AS id_factura,
                            SUM(total) AS total,
                            fecha_inicio,
                            fecha_fin 
                      FROM facturas 
                      WHERE id_razon_social=$id AND estatus IN('A','T') AND id_factura_nota_credito!=0 AND id_unidad_negocio=2
                      GROUP BY id
                      UNION ALL
                      SELECT
                            a.id AS id,
                            b.folio_factura AS folio,
                            DATE(a.fecha) AS fecha,
                            'P' AS tipo,                  
                            b.id_factura AS id_factura,
                            IFNULL(SUM(b.importe_pagado),0) AS total,
                            '' AS fecha_inicio,
                            '' AS fecha_fin                   
                      FROM pagos_e a
                      LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                      WHERE a.id_razon_social=$id AND a.estatus IN('T') AND id_unidad_negocio=2
                      GROUP BY b.id_factura
                      UNION ALL
                      SELECT 
                            0 AS id,
                            0 AS folio,
                            a.fecha,
                            'C' AS tipo,
                            a.id_factura,
                            IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),a.total,((a.total) * -(1))),0)),0) AS total,
                            a.fecha AS fecha_inicio,
                            a.vencimiento AS fecha_fin 
                      FROM cxc a
                      LEFT JOIN razones_sociales b ON a.id_razon_social=b.id 
                      WHERE a.id_razon_social=$id AND a.estatus!='C' AND a.id_factura=0 AND a.id_nota_credito=0 AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0 AND a.id_razon_social>0 AND id_unidad_negocio=2
                      GROUP BY a.id
                    ) AS fn
                    GROUP BY fn.id_factura
                    ORDER BY fn.fecha
                ) AS n
                GROUP BY n.id WITH ROLLUP"; 
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }


        if($modulo == 'PRESUPUESTO_INGRESO')
        {
            $arreglo = json_decode($datos, true);
            $idUnidad = $arreglo['idUnidad'];
            $idSucursal = $arreglo['idsSucursal'];
            $anio = $arreglo['anio'];
            $mes = $arreglo['mes'];
            $tipo = $arreglo['tipo'];

            $condicionUnidad = "r.id_unidad_negocio=".$idUnidad;

            $estatus = "IF(r.estatus='P','PENDIENTE',IF(r.estatus='T','TIMBRADA',IF(r.estatus='A','SIN TIMBRAR','LIQUIDADA')))AS ESTATUS,";
      
            if($idUnidad != 2)
                $estatus = "IF(fc.estatus='T','TIMBRADA', 'PREFACTURA')AS ESTATUS,";

            $condicionVencimiento = "AND IF(r.vencimiento='0000-00-00',MONTH(fn.vencimiento_factura)<=$mes AND YEAR(fn.vencimiento_factura)<=$anio,MONTH(r.vencimiento)<=$mes AND YEAR(r.vencimiento)<=$anio)";  

            if (strpos($idSucursal, ',') !== false)
            {
              $dato=substr($idSucursal,1);
              $condicionSucursal=' AND r.id_sucursal in ('.$dato.')';
            }
            else
              $condicionSucursal=' AND r.id_sucursal ='.$idSucursal;
                
            $query = "SELECT * FROM (
                        SELECT 
                        b.nombre AS UNIDAD_NEGOCIO,
                        c.descr AS SUCURSAL,
                        IFNULL(IF(r.folio_factura>0,r.folio_factura,''),'') AS FACTURA,
                        r.fecha AS FECHA,
                        IF(r.vencimiento='0000-00-00',fn.vencimiento_factura,r.vencimiento) AS VENCE,
                        d.razon_social AS CLIENTE_RAZON_SOCIAL,
                        IFNULL(r.referencia,'') AS REFERENCIA,
                        (r.total-r.descuento-IFNULL(fn.importe_retencion,0)) AS TOTAL,
                        $estatus
                        (r.total-r.descuento-IFNULL(fn.importe_retencion,0))-(IFNULL(abonos.abonos_cxc,0)+IFNULL(fn.abonos_factura,0)) AS SALDO
                        
                        FROM cxc r 
                        LEFT JOIN cat_unidades_negocio b ON r.id_unidad_negocio = b.id       
                        LEFT JOIN sucursales c ON r.id_sucursal = c.id_sucursal      
                        LEFT JOIN razones_sociales d ON r.id_razon_social = d.id

                        LEFT JOIN facturas ff ON r.id_factura = ff.id
                        LEFT JOIN facturas_cfdi fc ON ff.id = fc.id_factura

                        LEFT JOIN (
                          SELECT folio_cxc,IFNULL(SUM(total),0) AS abonos_cxc
                          FROM cxc
                          WHERE id!=folio_cxc AND estatus != 'C'
                          GROUP BY folio_cxc
                        ) AS abonos ON r.id=abonos.folio_cxc
                        LEFT JOIN (
                          SELECT   
                          a.folio,
                          a.fecha,
                          a.dias_credito,
                          DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) AS vencimiento_factura,
                          a.id AS  id_factura,
                          a.importe_retencion,
                          IF(a.retencion=1,a.total-a.importe_retencion-a.descuento,a.total-a.descuento) AS total_factura,
                          IFNULL(nc.abonos_nc,0)+IFNULL(pagos.abonos_pagos,0) AS abonos_factura,
                          a.estatus AS estatus_factura,
                          a.anio,
                          a.mes
                          FROM facturas a
                          LEFT JOIN (
                            SELECT id, id_factura_nota_credito,SUM(total-importe_retencion) AS abonos_nc
                            FROM facturas 
                            WHERE estatus IN('T') AND id_factura_nota_credito!=0
                            GROUP BY id_factura_nota_credito
                          ) AS nc ON a.id=nc.id_factura_nota_credito
                          LEFT JOIN (
                            SELECT 
                            b.id_factura AS id_factura,
                            IFNULL(SUM(b.importe_pagado),0) AS abonos_pagos
                            FROM pagos_e a
                            LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                            WHERE a.estatus IN('A','T')
                            GROUP BY b.id_factura
                          ) AS pagos ON a.id=pagos.id_factura
                          WHERE  a.id_factura_nota_credito=0
                          GROUP BY a.id
                        ) fn ON r.id_factura=fn.id_factura
                        WHERE $condicionUnidad  $condicionSucursal
                        AND r.estatus!='C' AND r.id_nota_credito=0 AND r.id_pago=0
                        $condicionVencimiento
                        GROUP BY r.folio_cxc,r.id_factura
                        UNION ALL

                        SELECT 
                        b.nombre AS UNIDAD_NEGOCIO,                                                     
                        c.descr AS SUCURSAL,
                        '' AS FACTURA,
                        r.fecha as FECHA,
                        r.fecha AS VENCE,
                        'OTROS_INGRESOS' AS CLIENTE_RAZON_SOCIAL,
                        '' AS REFERENCIA,
                        SUM(r.importe) AS TOTAL,
                        IF(r.estatus=1,'Activa','Cancelada') AS ESTATUS,
                        
                        
                        SUM(r.importe) AS SALDO
                        FROM ingresos_sin_factura r 
                        LEFT JOIN cat_unidades_negocio b ON r.id_unidad_negocio = b.id                                                              
                        LEFT JOIN sucursales c ON r.id_sucursal = c.id_sucursal  
                        WHERE $condicionUnidad  $condicionSucursal 
                        AND r.estatus!=0 AND MONTH(r.fecha)=$mes AND YEAR(r.fecha)=$anio
                      ) AS tbl
                      HAVING  tbl.SALDO > 1 AND tbl.VENCE >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND (MONTH(tbl.VENCE)<=$mes AND YEAR(tbl.VENCE)<=$anio)
                      ORDER BY tbl.vence ASC";

                  


            /*
            $condicionUnidad = "r.id_unidad_negocio=".$idUnidad;

            $condicionVencimiento = "AND IF(r.vencimiento='0000-00-00',MONTH(fn.vencimiento_factura)<=$mes AND YEAR(fn.vencimiento_factura)<=$anio,MONTH(r.vencimiento)<=$mes AND YEAR(r.vencimiento)<=$anio)";  

            if (strpos($idSucursal, ',') !== false) {
                $dato=substr($idSucursal,1);
                $condicionSucursal=' AND r.id_sucursal in ('.$dato.')';
            }else{
                $condicionSucursal=' AND r.id_sucursal ='.$idSucursal;
            }  

            $query = "SELECT 
                IF(IFNULL(n.id,'')='','TOTAL',n.UNIDAD_NEGOCIO) AS UNIDAD_NEGOCIO,
                IF(IFNULL(n.id,'')='','',n.SUCURSAL) AS SUCURSAL,
                IF(IFNULL(n.id,'')='','',n.FACTURA) AS FACTURA,
                IF(IFNULL(n.id,'')='','',n.FECHA) AS FECHA,
                IF(IFNULL(n.id,'')='','',n.VENCE) AS VENCE,
                IF(IFNULL(n.id,'')='','',n.CLIENTE) AS CLIENTE,
                IF(IFNULL(n.id,'')='','',n.REFERENCIA) AS REFERENCIA,
                FORMAT(SUM(n.TOTAL),2) AS TOTAL,
                IF(IFNULL(n.id,'')='','',n.ESTATUS) AS ESTATUS
                FROM (SELECT * FROM 
                        (
                            SELECT
                            r.id,
                            b.nombre AS UNIDAD_NEGOCIO,
                            c.descr AS SUCURSAL,
                            IFNULL(IF(r.folio_factura>0,r.folio_factura,''),'') AS FACTURA,
                            r.fecha AS FECHA,
                            IF(r.vencimiento='0000-00-00',fn.vencimiento_factura,r.vencimiento) AS VENCE,
                            d.razon_social AS CLIENTE,
                            IFNULL(r.referencia,'') AS REFERENCIA,
                            (r.total-r.descuento-IFNULL(fn.importe_retencion,0)) AS TOTAL,
                            IF(r.estatus='P','PENDIENTE',IF(r.estatus='T','TIMBRADA',IF(r.estatus='A','SIN TIMBRAR','LIQUIDADA')))AS ESTATUS,
                            (r.total-r.descuento-IFNULL(fn.importe_retencion,0))-(IFNULL(abonos.abonos_cxc,0)+IFNULL(fn.abonos_factura,0)) AS SALDO
                            
                            FROM cxc r 
                            LEFT JOIN cat_unidades_negocio b ON r.id_unidad_negocio = b.id       
                            LEFT JOIN sucursales c ON r.id_sucursal = c.id_sucursal      
                            LEFT JOIN razones_sociales d ON r.id_razon_social = d.id  
                            LEFT JOIN (
                            SELECT folio_cxc,IFNULL(SUM(total),0) AS abonos_cxc
                            FROM cxc
                            WHERE id!=folio_cxc AND estatus != 'C'
                            GROUP BY folio_cxc
                            ) AS abonos ON r.id=abonos.folio_cxc
                            LEFT JOIN (
                            SELECT   
                            a.folio,
                            a.fecha,
                            a.dias_credito,
                            DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) AS vencimiento_factura,
                            a.id AS  id_factura,
                            a.importe_retencion,
                            IF(a.retencion=1,a.total-a.importe_retencion-a.descuento,a.total-a.descuento) AS total_factura,
                            IFNULL(nc.abonos_nc,0)+IFNULL(pagos.abonos_pagos,0) AS abonos_factura,
                            a.estatus AS estatus_factura,
                            a.anio,
                            a.mes
                            FROM facturas a
                            LEFT JOIN (
                                SELECT id, id_factura_nota_credito,SUM(total-importe_retencion) AS abonos_nc
                                FROM facturas 
                                WHERE estatus IN('T') AND id_factura_nota_credito!=0
                                GROUP BY id_factura_nota_credito
                            ) AS nc ON a.id=nc.id_factura_nota_credito
                            LEFT JOIN (
                                SELECT 
                                b.id_factura AS id_factura,
                                IFNULL(SUM(b.importe_pagado),0) AS abonos_pagos
                                FROM pagos_e a
                                LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                                WHERE a.estatus IN('A','T')
                                GROUP BY b.id_factura
                            ) AS pagos ON a.id=pagos.id_factura
                            WHERE  a.id_factura_nota_credito=0
                            GROUP BY a.id
                            ) fn ON r.id_factura=fn.id_factura
                            WHERE $condicionUnidad  $condicionSucursal
                            AND r.estatus!='C' AND r.id_nota_credito=0 AND r.id_pago=0
                            $condicionVencimiento
                            GROUP BY r.folio_cxc,r.id_factura
                            UNION ALL
                            SELECT 
                            r.id,
                            b.nombre AS UNIDAD_NEGOCIO,														
                            c.descr AS SUCURSAL,
                            '' AS FACTURA,
                            r.fecha AS FECHA,
                            r.fecha AS VENCE,
                            'OTROS_INGRESOS' AS CLIENTE,
                            '' AS REFERENCIA,
                            SUM(r.importe) AS TOTAL,
                            IF(r.estatus=1,'Activa','Cancelada') AS ESTATUS,
                            SUM(r.importe) AS SALDO
                            FROM ingresos_sin_factura r 
                            LEFT JOIN cat_unidades_negocio b ON r.id_unidad_negocio = b.id       														
                            LEFT JOIN sucursales c ON r.id_sucursal = c.id_sucursal  
                            WHERE $condicionUnidad  $condicionSucursal 
                            AND r.estatus!=0 AND MONTH(r.fecha)=$mes AND YEAR(r.fecha)=$anio
                        ) AS tbl
                        HAVING tbl.SALDO > 0 AND tbl.VENCE >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND (MONTH(tbl.VENCE)<=$mes AND YEAR(tbl.VENCE)<=$anio)
                        ORDER BY tbl.VENCE ASC
                        )AS n GROUP BY n.id WITH ROLLUP";*/

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'COBRANZA_SEGUIMIENTO')
        {
            $arreglo = json_decode($datos, true);

            $tipo = $arreglo['tipo'];
            $orden = $arreglo['orden'];
            $tabla = $arreglo['tabla'];
    
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
                $query = "SELECT 
                IF(IFNULL(n.folio,'')='','TOTAL',n.unidad) AS UNIDAD_NEGOCIO,
                IF(IFNULL(n.folio,'')='','',n.sucursal) AS SUCURSAL,
                IF(IFNULL(n.folio,'')='','',n.cliente) AS CLIENTE,
                IF(IFNULL(n.folio,'')='','',n.razon_social) AS RAZÓN_SOCIAL,
                IF(IFNULL(n.folio,'')='','',n.folio) AS FOLIO,
                IF(IFNULL(n.folio,'')='','',n.vencimiento) AS VENCIMIENTO,
                FORMAT(SUM(n.cargos),2) AS CARGOS,
                FORMAT(SUM(n.abonos),2) AS ABONOS,
                FORMAT(SUM(n.saldo),2) AS SALDO
                FROM(
                    SELECT a.id,
                        a.folio_cxc AS folio,
                        a.vencimiento,
                        IFNULL(b.nombre,'') AS unidad,
                        IFNULL(c.descr,'') AS sucursal,
                        IFNULL(e.nombre_comercial,'') AS cliente,
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
                        $ordenCXC
                    )AS n
                    GROUP BY n.folio WITH ROLLUP";
            }else{ //Factura

                if($tipo == 1)  //PUE
                    $condMetodo= " AND a.metodo_pago='PUE'";
                else //PPD
                    $condMetodo= " AND a.metodo_pago='PPD'";

                $query = "SELECT 
                    IF(IFNULL(n.id,'')='','TOTAL',n.unidad) AS UNIDAD_NEGOCIO,
                    IF(IFNULL(n.id,'')='','',n.sucursal) AS SUCURSAL,
                    IF(IFNULL(n.id,'')='','',n.cliente) AS CLIENTE,
                    IF(IFNULL(n.id,'')='','',n.razon_social) AS RAZÓN_SOCIAL,
                    IF(IFNULL(n.id,'')='','',n.folio) AS FOLIO,
                    IF(IFNULL(n.id,'')='','',n.vencimiento) AS VENCIMIENTO,
                    IF(IFNULL(n.id,'')='','',n.fecha_inicio) AS INICIO_PERIODO,
                    IF(IFNULL(n.id,'')='','',n.fecha_fin) AS FIN_PERIODO,
                    FORMAT(SUM(n.cargos),2) AS CARGOS,
                    FORMAT(SUM(n.abonos),2) AS ABONOS,
                    FORMAT(SUM(n.saldo),2) AS SALDO
                    FROM(
                        SELECT 
                            pre.id,
                            'factura' AS tipo,
                            n.nombre AS unidad,
                            o.descr AS sucursal,
                            k.folio,
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
                            IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total,0),0)),0) AS total_facturado,
                            IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado,
                            IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,a.total,(a.total)*-1),0)),0) AS saldo_facturado,
                            0 AS pagos_mensual,
                            0 AS notas_mensual
                            FROM facturas a
                            WHERE a.es_plan=0 AND a.es_venta_orden=0 AND a.id_cxc=0 $condMetodo $tablaFactura
                            GROUP BY a.id
                            /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
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
                            /* AQUI OBTINE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/
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
                            $ordenFactura
                        )AS n
                        GROUP BY n.id WITH ROLLUP";   
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'PRESUPUESTOS_INGRESOS_SIN_COTIZACION')
        {
            $arreglo = json_decode($datos, true);
            $idUnidad = $arreglo['idUnidad'];
            $idSucursal = $arreglo['idsSucursal'];
            $anio = $arreglo['anio'];
            $mes = $arreglo['mes'];
            $tipo = $arreglo['tipo'];

            $condicionUnidad = "a.id_unidad_negocio=".$idUnidad;
            $condicionMes = "AND ((a.mes=".$mes." AND a.anio =".$anio.")  OR (a.vencimiento < now() AND a.estatus='P'))"; 
            $condicionMesF = "AND ((a.mes=".$mes." AND a.anio =".$anio.")  OR (DATE_ADD(a.fecha_inicio, INTERVAL a.dias_credito DAY) < NOW() AND a.estatus='T'))"; 

            if (strpos($idSucursal, ',') !== false) {
                $dato=substr($idSucursal,1);
                $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
              }else{
                $condicionSucursal=' AND a.id_sucursal ='.$idSucursal;
              }
        

                $query = "SELECT 
                    SUB.unidad_negocio AS UNIDAD_NEGOCIO,
                    SUB.sucursal AS SUCURSAL,
                    SUB.folio_factura AS FOLIO_FACTURA,
                    SUB.fecha as FECHA,
                    SUB.vence AS VENCE,
                    SUB.razon_social AS CLIENTE,
                    SUB.referencia AS REFERENCIA,
                    FORMAT(SUB.total,2) AS TOTAL,   
                    SUB.estatus AS ESTATUS
                FROM (
                    SELECT 
                        a.id,
                        a.id_unidad_negocio,
                        a.id_sucursal,
                        IFNULL(IF(a.folio_factura>0,a.folio_factura,''),'') AS folio_factura,
                        a.fecha,
                        (a.total - a.retencion - a.descuento) AS total,
                        a.referencia,
                        a.vencimiento AS vence,
                        a.id_razon_social,
                        b.nombre AS unidad_negocio,
                        c.descr AS sucursal,
                        d.razon_social,
                        IF(a.estatus='P','PENDIENTE',IF(a.estatus='T','TIMBRADA','LIQUIDADA'))AS estatus,
                        IF(a.estatus='P' AND a.vencimiento<CURRENT_DATE(),'vencida','noVencida')AS vencida
                    FROM cxc a
                    LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id 
                    LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                    LEFT JOIN razones_sociales d ON a.id_razon_social = d.id
                    LEFT JOIN facturas e ON a.id_factura=e.id
                    WHERE $condicionUnidad $condicionSucursal $condicionMes AND  a.cargo_inicial=1 AND a.estatus!='C' AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0 AND e.id_contrato=0
                    UNION ALL
                    SELECT 
                        pre.id,
                        k.id_unidad_negocio,
                        k.id_sucursal,
                        IFNULL(IF(k.folio>0,k.folio,''),'') AS folio_factura,
                        pre.fecha,
                        SUM(pre.total_facturado)-(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)) AS total,
                        '' AS referencia,
                        DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) AS vence,
                        k.id_razon_social,
                        n.nombre AS unidad_negocio,
                        o.descr AS sucursal,
                        l.razon_social AS razon_social,
                        IF(k.estatus='P','PENDIENTE',IF(k.estatus='T','TIMBRADA','LIQUIDADA'))AS estatus,
                        IF(k.estatus='T' AND DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) < CURRENT_DATE(),'vencida','noVencida')AS vencida
                    FROM
                        (/*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                            SELECT a.id,
                                CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                                IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total-a.importe_retencion,0),0)),0) AS total_facturado,
                                IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total-a.importe_retencion,0),0)),0) AS abonos_facturado,
                                IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,a.total-a.importe_retencion,(a.total-a.importe_retencion)*-1),0)),0) AS saldo_facturado,
                                0 AS pagos_mensual,
                                0 AS notas_mensual
                            FROM facturas a
                            WHERE $condicionUnidad $condicionSucursal $condicionMesF  AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 AND a.id_contrato=0
                            GROUP BY a.id
                            /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
                            UNION ALL
                            SELECT 
                                b.id_factura,
                                DATE_FORMAT(DATE(c.fecha), '%Y-%m') AS fecha,
                                0 AS total_facturado,
                                0 AS abonos_facturado,
                                0 AS saldo_facturado,
                                SUM(IF(a.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                                0 AS notas_mensual
                            FROM pagos_e c
                            LEFT JOIN pagos_d b ON c.id=b.id_pago_e
                            LEFT JOIN facturas a ON b.id_factura=a.id 
                            WHERE $condicionUnidad $condicionSucursal $condicionMesF  AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 AND a.id_contrato=0
                            GROUP BY b.id_factura
                        /* AQUI OBTINE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/
                            UNION ALL
                            SELECT 
                            sub.id_factura,
                            DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha,
                            0 AS total_facturado,
                            0 AS abonos_facturado,
                            0 AS saldo_facturado,
                            0 AS pagos_mensual,
                            SUM(IF(sub.id=b.id_factura_nota_credito,b.total,0))AS notas_mensual
                            FROM (                    
                                SELECT 
                                a.id,
                                folio,
                                a.fecha,'F' AS tipo,
                                a.id AS  id_factura,
                                SUM(a.total-a.importe_retencion) AS total 
                            FROM facturas a
                            WHERE  a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND $condicionUnidad $condicionSucursal $condicionMesF AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 AND a.id_contrato=0
                            GROUP BY a.id
                            )AS sub
                            LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito  AND b.estatus ='T'
                            GROUP BY sub.id_factura
                    ) AS pre
                    LEFT JOIN facturas k ON pre.id=k.id
                    LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                    LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                    LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                    LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                    GROUP BY pre.id
                    HAVING total>0
                )AS SUB";
            

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }


        if($modulo == 'INGRESOS_SEGUIMIENTO')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
            
            $mesInicial = $arreglo['mesInicio'];
            $mesFinal = $arreglo['mesFin'];
            $idUnidad = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $idArea = $arreglo['idArea'];
            $idDepartamento = $arreglo['idDepartamento'];
            $anio = $arreglo['anio'];
            $reporte = $arreglo['reporte'];

            $condicionUnidad = "a.id_unidad_negocio=".$idUnidad;
            $condicionSucursal = "AND a.id_sucursal = ".$idSucursal;
            //$condicionMes = "AND (a.mes=".$mes." AND a.anio =".$anio.")"; 
            
            if($idSucursal!=''){

            if (strpos($idSucursal, ',') !== false) {
                $dato=substr($idSucursal,1);
                $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
            }else{
                $condicionSucursal=' AND a.id_sucursal ='.$idSucursal;
            }

            }else{
            
            $condicionSucursal=' AND a.id_sucursal =0';
            }


            $condicionMes1 = ($mesFinal>0)?'   a.mes BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
            $condicionMesS2 = ($mesFinal>0)?'   MONTH(a.fecha_captura) BETWEEN '.$mesInicial.' AND '.$mesFinal :'';
            $condicionAnioS1 = ($anio>0)?" AND a.anio=".$anio :" ";
            $condicionAnioS2 = ($anio>0)?" AND YEAR(a.fecha_captura)=".$anio :" ";
            
            $condicionMes = " AND ($condicionMes1 $condicionAnioS1)";
        
            $html='';

            if($reporte == 'cxc'){

                $query = "SELECT 
                            tabla.folio_factura AS Factura,
                            FORMAT(IFNULL(SUM(tabla.presupuesto),0),2) AS Presupuesto,
                            FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS ejercido,
                            CONCAT(FORMAT(IF(SUM(tabla.presupuesto) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)),0),0),2),' %') AS PORCENTAJE
                            FROM (
                                    SELECT 
                                    a.id,
                                    IFNULL(IF(a.folio_factura>0,a.folio_factura,''),'') AS folio_factura,
                                    IF(a.cargo_inicial=1,a.total,0) AS presupuesto,
                                    FORMAT(IFNULL(SUM(IF(a.estatus NOT IN('C'),IF((SUBSTR(e.cve_concepto,1,1) = 'A'),e.total,0),0)),0),2) AS ejercido,            
                                    b.nombre AS unidad_negocio,
                                    c.descr AS sucursal
                                FROM cxc a
                                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id 
                                LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                                LEFT JOIN razones_sociales d ON a.id_razon_social = d.id
                                LEFT JOIN cxc e ON a.id=e.folio_cxc
                                WHERE $condicionUnidad $condicionSucursal $condicionMes AND a.estatus!='C' AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0
                                GROUP BY a.folio_cxc
                                HAVING presupuesto >0
                                UNION ALL
                                SELECT 
                                        pre.id,
                                        IFNULL(IF(k.folio>0,k.folio,''),'') AS folio_factura,
                                        SUM(pre.total_facturado) AS presupuesto,
                                        (SUM(pre.pagos_mensual)+SUM(pre.notas_mensual))AS ejercido,
                                        n.nombre AS unidad_negocio,
                                        o.descr AS sucursal
                                FROM (
                                        /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/
                                        SELECT 
                                                a.id,
                                                CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
                                                IFNULL(SUM(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total,0),0)),0) AS total_facturado,
                                                IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado,
                                                IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,a.total,(a.total)*-1),0)),0) AS saldo_facturado,
                                                0 AS pagos_mensual,
                                                0 AS notas_mensual
                                        FROM facturas a
                                        WHERE $condicionUnidad $condicionSucursal $condicionMes AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0
                                        GROUP BY a.id
                                        /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
                                        UNION ALL
                                        SELECT 
                                                b.id_factura,
                                                DATE_FORMAT(DATE(c.fecha), '%Y-%m') AS fecha,
                                                0 AS total_facturado,
                                                0 AS abonos_facturado,
                                                0 AS saldo_facturado,
                                                SUM(IF(a.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
                                                0 AS notas_mensual
                                        FROM pagos_e c
                                        LEFT JOIN pagos_d b ON c.id=b.id_pago_e
                                        LEFT JOIN facturas a ON b.id_factura=a.id 
                                        WHERE $condicionUnidad AND a.id_sucursal=1 $condicionMes AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0
                                        GROUP BY b.id_factura
                                        /* AQUI OBTINE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/
                                        UNION ALL
                                        SELECT 
                                            sub.id_factura,
                                            DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha,
                                            0 AS total_facturado,
                                            0 AS abonos_facturado,
                                            0 AS saldo_facturado,
                                            0 AS pagos_mensual,
                                            SUM(IF(sub.id=b.id_factura_nota_credito,b.total,0))AS notas_mensual
                                        FROM (                    
                                        SELECT 
                                                a.id,
                                                folio,
                                                a.fecha,'F' AS tipo,
                                                a.id AS  id_factura,
                                                SUM(a.total) AS total 
                                        FROM facturas a
                                        WHERE  a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND $condicionUnidad $condicionSucursal $condicionMes AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0
                                        GROUP BY a.id
                                        )AS sub
                                    LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito  AND b.estatus ='T'
                                    GROUP BY sub.id_factura
                                ) AS pre
                                LEFT JOIN facturas k ON pre.id=k.id
                                LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
                                LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
                                LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
                                LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
                                GROUP BY pre.id
                                HAVING presupuesto>0) as tabla
                                GROUP BY tabla.folio_factura";

                $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
            }

            
            if($reporte == 'diario'){

            
                $fecha=$anio."-".$mesInicial."-01";

                $queryDias="SELECT dayofmonth(last_day('$fecha')) as dias_mes";
                $resultDias = mysqli_query($this->link, $queryDias)or die(mysqli_error());

                $condicionDias = ''; 
                $condicionFecha = '';

                if($resultDias){

                    $rowD=mysqli_fetch_array($resultDias);

                    $totalDias=$rowD['dias_mes'];

                    for($j=1;$j<=$totalDias;$j++){
                    
                        $condicionDias.="FORMAT(IFNULL(SUM(tabla.d".$j."),0),2) AS D".$j.",";
                        $condicionDiasP.="0 AS D".$j.",";
                        $condicionFecha.="IF(DATE_FORMAT(a.fecha_captura,'%d')=".$j.",IFNULL(SUM(a.monto),0),0) AS d".$j.",";
                        $condicionDia1.="IF(DATE_FORMAT(a.fecha_captura,'%d')=".$j.",IFNULL(SUM(IF(SUBSTR(e.cve_concepto,1,1) = 'A',e.total,0)),0),0) AS d".$j.",";
                        $condicionDia2.="IF(DATE_FORMAT(pre.fecha_captura,'%d')=".$j.",IFNULL((SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)),0),0) AS d".$j.",";
                    }
                } 

                
            
            $query = "SELECT 
                tabla.folio_factura AS Factura, 
                FORMAT(IFNULL(SUM(tabla.presupuesto),0),2) AS Presupuesto, 
                $condicionDias
                FORMAT(IFNULL(SUM(tabla.ejercido),0),2) AS ejercido, 
                CONCAT(FORMAT(IF(SUM(tabla.presupuesto) > 0,IFNULL((SUM(tabla.ejercido) * 100)/(SUM(tabla.presupuesto)),0),0),2),' %') AS PORCENTAJE 
            FROM ( 
                SELECT 
                a.id, 
                a.fecha_captura,
                IFNULL(IF(a.folio_factura>0,a.folio_factura,''),'') AS folio_factura, 
                IF(a.cargo_inicial=1,a.total,0) AS presupuesto, 
                $condicionDia1
                FORMAT(IFNULL(IF(SUBSTR(e.cve_concepto,1,1) = 'A',e.total,0),0),2) AS ejercido, 
                b.nombre AS unidad_negocio, 
                c.descr AS sucursal 
                FROM cxc a 
                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id 
                LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal 
                LEFT JOIN razones_sociales d ON a.id_razon_social = d.id 
                LEFT JOIN cxc e ON a.id=e.folio_cxc 
                WHERE $condicionUnidad $condicionSucursal AND ( a.mes BETWEEN 12 AND 12 AND a.anio=2019) AND a.estatus!='C' AND a.id_orden_servicio=0 AND a.id_venta=0 AND a.id_plan=0 
                GROUP BY a.folio_cxc 
                HAVING presupuesto >0 
                UNION ALL 
                SELECT 
                pre.id, 
                pre.fecha_captura, 
                IFNULL(IF(k.folio>0,k.folio,''),'') AS folio_factura, 
                SUM(pre.total_facturado) AS presupuesto, 
                $condicionDia2
                (SUM(pre.pagos_mensual)+SUM(pre.notas_mensual))AS ejercido, 
                n.nombre AS unidad_negocio, 
                o.descr AS sucursal 
                FROM ( 
                /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES**/ 
                SELECT 
                    a.id, 
                    a.fecha AS fecha_captura, 
                    CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha, 
                    IFNULL(SUM(IF(a.estatus IN ('A','T'),
                    IF(a.id_factura_nota_credito=0,a.total,0),0)),0) AS total_facturado, 
                    IFNULL(SUM(IF(a.estatus ='T',IF(a.id_factura_nota_credito!=0,a.total,0),0)),0) AS abonos_facturado, 
                    IFNULL(SUM(IF(a.estatus IN('A','T'),IF(a.id_factura_nota_credito=0,a.total,(a.total)*-1),0)),0) AS saldo_facturado, 
                    0 AS pagos_mensual, 
                    0 AS notas_mensual 
                FROM facturas a 
                WHERE $condicionUnidad $condicionSucursal AND ( a.mes BETWEEN 12 AND 12 AND a.anio=2019) AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 
                GROUP BY a.id 
                /* AQUI OPTINE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/ 
                UNION ALL 
                SELECT 
                    b.id_factura, 
                    c.fecha_captura, 
                    DATE_FORMAT(DATE(c.fecha), '%Y-%m') AS fecha, 
                    0 AS total_facturado, 
                    0 AS abonos_facturado, 
                    0 AS saldo_facturado, 
                    SUM(IF(a.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual, 
                    0 AS notas_mensual 
                FROM pagos_e c 
                LEFT JOIN pagos_d b ON c.id=b.id_pago_e 
                LEFT JOIN facturas a ON b.id_factura=a.id 
                WHERE $condicionUnidad AND a.id_sucursal=1 AND ( a.mes BETWEEN 12 AND 12 AND a.anio=2019) AND a.estatus!='C' AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 
                GROUP BY b.id_factura 
                /* AQUI OBTINE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/ 
                UNION ALL 
                SELECT 
                    sub.id_factura, 
                    sub.fecha_captura, 
                    DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha, 
                    0 AS total_facturado, 
                    0 AS abonos_facturado, 
                    0 AS saldo_facturado, 
                    0 AS pagos_mensual, 
                    SUM(IF(sub.id=b.id_factura_nota_credito,b.total,0))AS notas_mensual 
                FROM ( 
                    SELECT 
                    a.id, 
                    a.fecha AS fecha_captura, 
                    folio, 
                    a.fecha,
                    'F' AS tipo, 
                    a.id AS id_factura, 
                    SUM(a.total) AS total 
                    FROM facturas a 
                    WHERE a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND $condicionUnidad $condicionSucursal AND ( a.mes BETWEEN 12 AND 12 AND a.anio=2019) AND a.id_cxc=0 AND a.es_venta_orden=0 AND a.es_plan=0 
                    GROUP BY a.id )AS sub 
                LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito AND b.estatus ='T' 
                GROUP BY sub.id_factura ) AS pre 
                
                LEFT JOIN facturas k ON pre.id=k.id 
                LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa 
                LEFT JOIN facturas_cfdi m ON k.id=m.id_factura 
                LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id 
                LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal 
                GROUP BY pre.id 
                
            HAVING presupuesto>0) AS tabla 
            GROUP BY tabla.folio_factura";

            
                $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
            }
        }

        if($modulo == 'REPORTE_COMODATO')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

                $idUnidadNegocio = $arreglo['idUnidadNegocio'];
                $idSucursal = $arreglo['idSucursal'];
                $fechaInicio = $arreglo['fechaInicio'];
                $fechaFin = $arreglo['fechaFin'];
                $tipo = $arreglo['tipo'];

                $sucursal='';
                $condFecha='';

                if($idSucursal[0] == ',')
                {
                    $dato=substr($idSucursal,1);
                    $sucursal = " AND a.id_sucursal IN($dato) ";
                }else{ 
                    $sucursal = " AND a.id_sucursal = $idSucursal";
                }
            
                $condFecha = " AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
                
                //-->NJES March/18/2021 tipo 0 = acumulado, tipo 1 = detallado
                if($tipo == 0)
                {
                    $query = "SELECT a.folio AS NO_MOVIMIENTO,c.descr AS SUCURSAL,DATE(a.fecha) AS FECHA,
                            IFNULL(e.des_dep,'') AS DEPARTAMENTO,
                            IFNULL(f.descripcion,'') AS ÁREA,
                            IFNULL(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS SUPERVISOR,
                            a.no_partidas AS PARTIDAS,
                            SUM(d.precio*d.cantidad) AS IMPORTE_TOTAL                        
                            FROM almacen_e a
                            LEFT JOIN usuarios b ON a.id_usuario_captura=b.id_usuario
                            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                            LEFT JOIN almacen_d d ON a.id=d.id_almacen_e
                            LEFT JOIN deptos e ON a.id_departamento=e.id_depto
                            LEFT JOIN cat_areas f ON e.id_area=f.id
                            LEFT JOIN trabajadores g ON e.id_supervisor=g.id_trabajador
                            WHERE a.id_contrapartida=0 AND a.cve_concepto IN ('S06','E06') 
                            AND a.id_unidad_negocio=$idUnidadNegocio 
                            $sucursal $condFecha
                            GROUP BY a.id
                            ORDER BY a.id";
                }else{
                    $query = "SELECT a.folio AS NO_MOVIMIENTO,
                            c.descr AS SUCURSAL,DATE(a.fecha) AS FECHA,
                            IFNULL(f.descripcion,'') AS ÁREA,
                            IFNULL(e.des_dep,'') AS DEPARTAMENTO,
                            IFNULL(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS SUPERVISOR,
                            productos.concepto AS PRODUCTO,
                            d.precio AS PRECIO,d.cantidad AS CANTIDAD,(d.precio*d.cantidad) AS IMPORTE_TOTAL
                            FROM almacen_d d
                            LEFT JOIN productos ON d.id_producto=productos.id
                            LEFT JOIN almacen_e a ON d.id_almacen_e=a.id
                            LEFT JOIN usuarios b ON a.id_usuario_captura=b.id_usuario
                            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                            LEFT JOIN deptos e ON a.id_departamento=e.id_depto
                            LEFT JOIN cat_areas f ON e.id_area=f.id
                            LEFT JOIN trabajadores g ON e.id_supervisor=g.id_trabajador
                            WHERE a.id_contrapartida=0 AND a.cve_concepto IN ('S06','E06') 
                            AND a.id_unidad_negocio=$idUnidadNegocio 
                            $sucursal $condFecha
                            ORDER BY a.id";
                }
                
                $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'RECIBOS')
        {
            $query = "SELECT d.id AS SERVICIO,
                IFNULL(d.razon_social,'') AS RAZÓN_SOCIAL,
                IFNULL(d.rfc,'') AS RFC,
                d.dias_credito AS DÍAS_CREDITO,
                IFNULL(d.codigo_postal,'') AS CODIGO_POSTAL,
                d.porcentaje_iva AS PORCENTAJE_IVA,
                d.digitos_cuenta AS DIGITOS_CUENTA,
                b.id AS PLAN_SERVICIO,
                b.id_plan AS PLAN,
                c.descripcion AS NOMBRE_PLAN,
                IFNULL(c.cantidad,0) AS PRECIO,
                IFNULL(b.uso_cfdi,'') AS USO_CFDI,
                IFNULL(b.metodo_pago,'') AS METODO_PAGO,
                IFNULL(b.forma_pago,'') AS FORMA_PAGO,
                IFNULL(b.producto_sat,'') AS PRODUCTO_SAT,
                IFNULL(b.unidad_sat,'') AS UNIDAD_SAT,
                IFNULL(b.nombre_producto_sat,'') AS NOMBRE_PRODUCTO_SAT,
                IFNULL(b.nombre_unidad_sat,'') AS NOMBRE_UNIDAD_SAT,
                IFNULL(b.descripcion,'') AS DESCRIPCIÓN
                FROM cxc a
                LEFT JOIN servicios_bitacora_planes b ON a.id_plan=b.id_plan
                LEFT JOIN servicios_cat_planes c ON b.id_plan=c.id
                LEFT JOIN servicios d ON b.id_servicio=d.id
                WHERE a.id_plan > 0 AND a.id_factura=0 AND b.factura='SI'
                AND b.id IN (SELECT MAX(id)
                    FROM servicios_bitacora_planes 
                    GROUP BY id_servicio)
                    AND (d.razon_social IS NULL OR d.rfc IS NULL OR d.codigo_postal IS NULL 
                        OR c.cantidad IS NULL OR b.uso_cfdi IS NULL OR b.metodo_pago IS NULL 
                        OR b.forma_pago IS NULL OR b.producto_sat IS NULL OR b.unidad_sat IS NULL 
                        OR b.nombre_producto_sat IS NULL OR b.nombre_unidad_sat IS NULL OR b.descripcion IS NULL)
                ORDER BY d.razon_social ASC,c.descripcion ASC";
            
            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'MANTENIMIENTO_VEHICULOS')
        {

            $arreglo = json_decode($datos, true);

            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            $condFecha = '';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condFecha=" AND a.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condFecha=" AND  a.fecha_pedido >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condFecha=" AND DATE(a.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

                $query = "SELECT 
                a.fecha_pedido AS FECHA_PEDIDO,
                a.folio_mantenimiento AS REQUISICION,
                IFNULL(a.descripcion,'') AS DESCRIPCION, 
                b.no_serie AS NO_SERIE,
                num_economico AS NO_ECONOMICO,
                IFNULL(c.imei_gps,'') AS IMEI_GPS,
                IFNULL(c.modelo,'') as MODELO,
                IFNULL(placas,'') AS PLACAS,
                
                
                a.kilometraje AS KILOMETRAJE,
                a.total AS TOTAL
               
                FROM requisiciones a 
                LEFT JOIN activos b ON a.no_economico=b.num_economico 
                LEFT JOIN vehiculos c ON b.id=c.id_activo 
                WHERE a.tipo=2 AND a.id_orden_compra>0 $condFecha";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTE_ACTIVOS')
        {

            $arreglo = json_decode($datos, true);
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idsSucursal = $arreglo['idSucursal'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idEmpresaFiscal = isset($arreglo['idEmpresaFiscal']) ? $arreglo['idEmpresaFiscal'] : '';
            
            $condicionSucursales ='';
            if($idsSucursal!=''){

                if (strpos($idsSucursal, ',') !== false) {
                
                    $dato=substr(trim($idsSucursal),1);
                    $condicionSucursales=' AND c.id_sucursal in ('.$dato.')';
                }else{
                 $condicionSucursales=' AND c.id_sucursal ='.$idsSucursal;
                }

            }else{
                
                $condicionSucursales=' AND c.id_sucursal =0';
            }
            $condFecha = '';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condFecha=" AND a.fecha_adquisicion >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condFecha=" AND  a.fecha_adquisicion >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condFecha=" AND DATE(a.fecha_adquisicion) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            //-->NJES March/17/2021  agregar filtro empresa fiscal
            $condEmpresaFiscal = '';
            if($idEmpresaFiscal != '')
            {
                $condEmpresaFiscal = ' AND a.id_empresa_fiscal = '.$idEmpresaFiscal;
            }
        
            $query = "SELECT 
        
                    a.no_serie AS NO_SERIE,
                    a.num_economico AS NO_ECONOMICO,
                    IFNULL(f.imei_gps,'') AS IMEI_GPS,
                    a.descripcion AS DESCRIPCION,
                    a.fecha_adquisicion AS FECHA_ADQUISICION,
                    a.valor_adquisicion AS TOTAL,
                    b.razon_social AS PROPIETARIO,
                    IF(a.tipo=1,'Vehiculo',IF(a.tipo=2,'Celular',IF(a.tipo=3,'Equipo Computo','Otro'))) AS TIPO,
                    IF(IFNULL(c.id_trabajador,0)>0,IFNULL(CONCAT(c.id_trabajador,' - ',TRIM(d.nombre),' ',TRIM(d.apellido_p),' ',TRIM(d.apellido_m)),''),IFNULL(e.razon_social,'')) AS RESPONASABLE_CLIENTE,
                    IFNULL(f.vigencia_poliza,'') AS VIGENCIA_POLIZA,
                    IFNULL(g.nombre,'') AS UNIDAD_NEGOCIO,
                    IFNULL(h.descr,'') AS SUCURSAL
                    FROM activos a
                    LEFT JOIN empresas_fiscales b ON a.id_empresa_fiscal = b.id_empresa
                    LEFT JOIN activos_responsables c ON a.id=c.id_activo AND c.responsable=1
                    LEFT JOIN trabajadores d ON c.id_trabajador=d.id_trabajador
                    LEFT JOIN razones_sociales e ON c.id_cliente = e.id
                    LEFT JOIN vehiculos f ON a.id=f.id_activo
                    LEFT JOIN cat_unidades_negocio g ON c.id_unidad_negocio=g.id
                    LEFT JOIN sucursales h ON c.id_sucursal=h.id_sucursal
                    WHERE c.id_unidad_negocio=".$idUnidadNegocio." $condicionSucursales $condEmpresaFiscal $condFecha
                    ORDER BY a.id DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTES_REQUISICIONES_TODAS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
            
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idSucursal = $arreglo['idSucursal'];
            $idSucursal = rtrim($idSucursal, ",");

            $condicion='';

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicion=" AND a.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicion=" AND a.fecha_pedido >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condicion=" AND DATE(a.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }

            if($idSucursal != '')
            {
                $sucursal=" AND a.id_sucursal IN (".$idSucursal .")";
            }else{
                $sucursal='';
            }

            if($nombre == 'Detalle de Requisiciones')
            {
                $query="SELECT g.id AS ID,
                        a.folio AS FOLIO,
                        b.nombre AS UNIDAD,
                        c.descripcion AS SUCURSAL,
                        d.descripcion AS AREA,
                        e.des_dep AS DEPTO,
                        IFNULL(a.folio_orden_compra,'') AS FOLIO_ORDEN_COMPRA,
                        a.fecha_pedido AS FECHA,
                        IFNULL(a.solicito,'') AS SOLICITO,
                        f.nombre AS PROVEEDOR,
                        g.num_partida AS PARTIDA,
                        j.descripcion AS FAMILIA,
                        i.descripcion AS LINEA,
                        g.descripcion AS DESCRIPCIÓN,
                        g.concepto AS DETALLE,
                        IFNULL(l.unidad_medida,'') AS UNIDAD_MEDIDA,
                        g.cantidad AS CANTIDAD,
                        FORMAT(g.costo_unitario,2) AS COSTO_UNITARIO,
                        FORMAT(IFNULL(g.descuento_total,0),2) AS DESCUENTO_total,
                        FORMAT(((g.total/100)*g.iva),2) AS PORCENTAJE_IVA,
                        FORMAT(g.total,2) AS IMPORTE_SIN_IVA,
                        FORMAT((((g.total/100)*g.iva)+g.total),2) AS IMPORTE_CON_IVA,
                        IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',
                        IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar', IF(a.estatus = 6, 'Pagada', 'Cancelada') ) )))) AS ESTATUS,
                       
                        -- g.excede_presupuesto,
                          CASE
                              WHEN a.tipo = 0 THEN 'Activo Fijo'
                              WHEN a.tipo = 1 THEN 'Gasto'
                              WHEN a.tipo = 2 THEN 'Mantenimiento'
                              ELSE 'Stock'
                          END AS tipo,
                          IF(IFNULL(n.id_entrada_compra,0)>0,'SI','NO') AS en_portal,
                          IFNULL(m.folio,'') AS folio_recepcion_mercancia
                          -- 0=activo fijo 1=gasto 2=Mantenimeinto 3=stock 

                        FROM requisiciones_d g
                        LEFT JOIN requisiciones a ON g.id_requisicion=a.id
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                        LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                        LEFT JOIN cat_areas d ON a.id_area = d.id
                        LEFT JOIN deptos e ON a.id_departamento = e.id_depto
                        LEFT JOIN proveedores f ON a.id_proveedor = f.id
                        LEFT JOIN productos h ON g.id_producto = h.id
                        LEFT JOIN lineas i ON g.id_linea = i.id
                        LEFT JOIN familias j ON g.id_familia = j.id
                        LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                        LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra

                        LEFT JOIN almacen_e m ON k.id=m.id_oc
                        LEFT JOIN cxp n ON m.id=n.id_entrada_compra

                        WHERE 1 $sucursal  $condicion
                        GROUP BY g.id
                        ORDER BY a.fecha_pedido";
            }else if($nombre == 'Requisiciones Agrupadas')
            {

                $prov = isset($arreglo['prov']) ? $arreglo['prov'] : 0;
                

                if($prov == 0){
                    $condProveedor = "";
                }else{
                    $condProveedor = " AND f.id = $prov";
                }
                //-->NJES October/28/2020 mostrar quien autorizo una requi fuera de presupuesto o dentro del presupuesto en reporte agrupados
                 //-->NJES February/03/2021 Agregar estatus gasto
                $query="SELECT a.id AS ID,
                            a.folio AS FOLIO,
                            IF(a.folio_mantenimiento > 0,a.folio_mantenimiento,'NA') AS FOLIO_MANTENIMIENTO,
                            b.nombre AS UNIDAD,
                            c.descripcion AS SUCURSAL,
                            d.descripcion AS AREA,
                            e.des_dep AS DEPTO,
                            IFNULL(a.folio_orden_compra,'') AS FOLIO_ORDEN_COMPRA,
                            a.fecha_pedido AS FECHA,
                            IF(a.b_anticipo = 1 , 'CON ANTICIPO',  'SIN ANTICIPO') AS ANTICIPO,
                            IFNULL(a.solicito,'') AS SOLICITO,
                            us.usuario as CAPTURO,
                            IFNULL(h.usuario,'NA') AS AUTORIZO_FUERA_PRESUPUESTO,
                            IFNULL(j.usuario,'') AS AUTORIZO,
                            f.nombre AS PROVEEDOR,
                            a.descripcion AS DESCRIPCION,
                            FORMAT(a.subtotal,2) AS IMPORTE_SIN_IVA,
                            FORMAT(a.total,2) AS IMPORTE_CON_IVA,
                            IF(a.excede_presupuesto = 1, IF(a.estatus=1, IF((SELECT COUNT(id) FROM requisiciones_autorizar_bitacora WHERE id_requisicion = a.id) = 0, 'Pendiente Fuera', IF((SELECT COUNT(id) FROM requisiciones_autorizar_bitacora WHERE id_requisicion = a.id) = 1, 'Autorizada fuera', 'NO DEBERIA')),IF(a.estatus=2,'Autorizada Fuera',IF(a.estatus=3,'Rechazada Fuera', IF(a.estatus=4,'Orden de compra(1)',IF(a.estatus=5,'Por Pagar(1)', IF(a.estatus = 6, 'Pagada(1)', 'Cancelada Fuera') ) )))), '') as ESTATUS_FUERA,
                            IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada', IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar', IF(a.estatus = 6, 'Pagada', 'Cancelada') ) )))) AS ESTATUS,    
                            IFNULL(m.folio,'') AS FOLIO_RECEPCION_MERCANCIA,
                            CASE
                                WHEN a.tipo = 0 THEN 'Activo Fijo'
                                WHEN a.tipo = 1 THEN 'Gasto'
                                WHEN a.tipo = 2 THEN 'Mantenimiento'
                                ELSE 'Stock'
                            END AS TIPO,
                            IF(IFNULL(n.id_entrada_compra,0)>0,'SI','NO') AS EN_PORTAL,
                            IF(o.estatus IS NULL,
                            IF(a.tipo=1,'No Aplica',IF(a.b_anticipo=1 && ccc.estatus!='L' && IFNULL(n.id_entrada_compra,0)=0,'Pendiente de Pago',
                            IF(a.b_anticipo=1 && ccc.estatus='L' && IFNULL(n.id_entrada_compra,0)=0,'Pagado',
                            IF(a.b_anticipo=1 && ccc.estatus='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus!='L','Pendiente de Pago',
                            IF(a.b_anticipo=1 && ccc.estatus!='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus='L','Pendiente de Pago',
                            IF(a.b_anticipo=1 && ccc.estatus='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus='L','Pagado', IF(n.estatus='L', 'Pagado', IF(n.estatus='P', 'Pendiente de Pago', 'No portal de proveedores')) )))))),
                            IF(a.tipo=1,'No Aplica',IF(a.b_anticipo=1 && o.estatus!='L' && IFNULL(n.id_entrada_compra,0)=0,'Pendiente de Pago',
                            IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)=0,'Pagado',
                            IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus!='L','Pendiente de Pago',
                            IF(a.b_anticipo=1 && o.estatus!='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus='L','Pendiente de Pago',
                            IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus='L','Pagado', IF(n.estatus='L', 'Pagado', IF(n.estatus='P', 'Pendiente de Pago', 'No portal de proveedores')) ))))))) AS ESTATUS_CXP,
                            IFNULL(o.fecha, IFNULL(ccc.fecha, 'No Aplica')) as FECHA_PAGO_CXP,
                            IFNULL(n.no_factura, 'No Aplica') as NO_FACTURA,
                            IF(a.tipo=1,IF(a.estatus=1,'Pendiente',IF(a.estatus=7,'Cancelado',IF(a.omitir=1,'Pagado',IF(IFNULL(ga.id_requisicion,0)>0 && ga.estatus=1,'Pagado','Pendiente')))),'No Aplica') AS ESTATUS_GASTO,
                            IFNULL(ga.fecha_referencia, 'No Aplica') as FECHA_PAGO_GASTO,
                            IF(a.excede_presupuesto = 1, 'Excede Presup', 'Dentro presup') AS Presupuesto
                        FROM requisiciones a
                        INNER JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                        INNER JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                        INNER JOIN cat_areas d ON a.id_area = d.id
                        INNER JOIN deptos e ON a.id_departamento = e.id_depto
                        INNER JOIN proveedores f ON a.id_proveedor = f.id $condProveedor
                        LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                        LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra
                        LEFT JOIN almacen_e m ON k.id=m.id_oc
                        LEFT JOIN cxp n ON m.id=n.id_entrada_compra
                        LEFT JOIN cxp o ON n.id_cxp = o.id_cxp AND SUBSTR(o.clave_concepto,1,1) = 'A'
                        LEFT JOIN cxp ccc ON a.id = ccc.id_requisicion
                        LEFT JOIN requisiciones_autorizar_bitacora g ON a.id=g.id_requisicion AND (a.excede_presupuesto=1 OR a.excede_presupuesto=0) AND g.estatus=1
                        LEFT JOIN usuarios h ON g.id_usuario=h.id_usuario 
                        LEFT JOIN requisiciones_autorizar_bitacora i ON a.id=i.id_requisicion AND (a.excede_presupuesto=1 OR a.excede_presupuesto=0) AND i.estatus=2
                        LEFT JOIN usuarios j ON i.id_usuario=j.id_usuario
                        LEFT JOIN usuarios us ON us.id_usuario = a.id_capturo
                        LEFT JOIN gastos ga ON a.id=ga.id_requisicion 
                        WHERE 1 $sucursal  $condicion
                        GROUP BY a.id
                        ORDER BY a.fecha_pedido";

                        // echo $query;
                        // exit();
            }else{
                $query="SELECT g.id AS ID,
                        a.folio AS FOLIO,
                        b.nombre AS UNIDAD,
                        c.descripcion AS SUCURSAL,
                        d.descripcion AS AREA,
                        e.des_dep AS DEPTO,
                        IFNULL(a.folio_orden_compra,'') AS FOLIO_ORDEN_COMPRA,
                        a.fecha_pedido AS FECHA,
                        IFNULL(a.solicito,'') AS SOLICITO,
                        f.nombre AS PROVEEDOR,
                        g.num_partida AS PARTIDA,
                        j.descripcion AS FAMILIA,
                        i.descripcion AS LINEA,
                        g.descripcion AS DESCRIPCIÓN,
                        g.concepto AS DETALLE,
                        IFNULL(l.unidad_medida,'') AS UNIDAD_MEDIDA,
                        g.cantidad AS CANTIDAD,
                        FORMAT(g.costo_unitario,2) AS COSTO_UNITARIO,
                        FORMAT(IFNULL(l.porcentaje_descuento,0),2) AS PORCENTAJE_DCTO,
                        FORMAT(((g.total/100)*g.iva),2) AS PORCENTAJE_IVA,
                        FORMAT(g.total,2) AS IMPORTE_SIN_IVA,
                        FORMAT((((g.total/100)*g.iva)+g.total),2) AS IMPORTE_CON_IVA
                        FROM requisiciones_d g
                        LEFT JOIN requisiciones a ON g.id_requisicion=a.id
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
                        LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
                        LEFT JOIN cat_areas d ON a.id_area = d.id
                        LEFT JOIN deptos e ON a.id_departamento = e.id_depto
                        LEFT JOIN proveedores f ON a.id_proveedor = f.id
                        LEFT JOIN productos h ON g.id_producto = h.id
                        LEFT JOIN lineas i ON g.id_linea = i.id
                        LEFT JOIN familias j ON g.id_familia = j.id
                        LEFT JOIN orden_compra k ON a.id_orden_compra=k.id
                        LEFT JOIN orden_compra_d l ON k.id=l.id_orden_compra
                        WHERE 1 AND a.estatus=1 $sucursal  $condicion
                        ORDER BY a.fecha_pedido";
            }

            // echo $query;
            // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'REPORTE_COBRANZA')
        {

            $arreglo = json_decode($datos, true);
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            // $idsSucursal = $arreglo['idsSucursal'];
            
            // $condFechaCxc = '';
            // $condFechaFactura = '';

            // //-->NJES October/21/2020 se agrega filtro sucursal
            // if($idsSucursal[0] == ',')
            // {
            //     $dato=substr($idsSucursal,1);
            //     $condSucursales=' AND a.id_sucursal IN ('.$dato.')';
            // }else{ 
            //     $condSucursales=' AND a.id_sucursal ='.$idsSucursal;
            // }

            // if($fechaInicio == '' && $fechaFin == '')
            // {
            //     $condFechaCxc=" AND a.vencimiento >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            //     $condFechaFactura=" AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            // }else if($fechaInicio != '' &&  $fechaFin == '')
            // {
            //     $condFechaCxc=" AND  a.vencimiento >= '$fechaInicio' ";
            //     $condFechaFactura=" AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) >= '$fechaInicio' ";
            // }else{  //-->trae fecha inicio y fecha fin
            //     $condFechaCxc=" AND DATE(a.vencimiento) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            //     $condFechaFactura=" AND DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY)  BETWEEN '$fechaInicio' AND '$fechaFin'";
            // }

            $arregloSucursales = explode(",", $arreglo['idsSucursal']);
            $stringSucursales = $arreglo['idsSucursal'];

            // $condFechaCxc = '';
            // $condFechaFactura = '';

            IF(COUNT($arregloSucursales) > 1){
                $condSucursales = " AND cxc.id_sucursal IN ($stringSucursales)";
            }else{
                $condSucursales = " AND cxc.id_sucursal = $stringSucursales";
            }

            $query = "SELECT
                        suc.descripcion sucursal,
                        IFNULL(ser.nombre_corto,'Venta al publico en general') servicio,
                        IFNULL(ser.razon_social, '') razon_social,
                        'CXC' tipo,
                        GROUP_CONCAT(cxc.id SEPARATOR ';') idCxc,
                        IFNULL(GROUP_CONCAT(IF(cxc.id_venta>0,'VENTA',IF(cxc.id_plan>0,'PLAN',IF(cxc.id_orden_servicio>0,'ORDEN',null))) SEPARATOR ';'),'') AS origen,
                        IFNULL(GROUP_CONCAT(IF(cxc.folio_recibo=0,null,cxc.folio_recibo) SEPARATOR ';'),'') folioCxc,
                        cxc.folio_factura folioFactura,
                        cxc.fecha fechaInicio,
                        cxc.vencimiento fechaVencimiento,
                        SUM(cxc.subtotal) subtotal,
                        SUM(cxc.iva) iva,
                        SUM(cxc.total) total,
                        pd.importe_pagado totalPagado,
                        COUNT(cxc.id) registrosCXC,
                        SUM(cxc.total) - pd.importe_pagado saldo,
                    IFNULL(ne.vendedor, IFNULL(ne2.vendedor, '')) vendedor
                    FROM cxc as cxc
                    INNER JOIN sucursales suc ON suc.id_sucursal = cxc.id_sucursal
                    INNER JOIN pagos_d pd ON pd.id = cxc.id_pago_d
                    INNER JOIN pagos_e pe ON pe.id = pd.id_pago_e
                    LEFT JOIN servicios ser ON ser.id = pe.id_razon_social
                LEFT JOIN notas_e ne ON ne.id=cxc.id_venta
                LEFT JOIN notas_e ne2 ON ne.id=cxc.id_plan
                    WHERE cxc.id_factura = 0
                        AND cxc.id_cxc_pago <> 0
                        AND cxc.id_unidad_negocio = 2
                        $condSucursales
                        AND cxc.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    GROUP BY pd.id
                    UNION ALL
                    SELECT
                        suc.descripcion sucursal,
                        IFNULL(ser.nombre_corto,'Venta al publico en general') servicio,
                        IFNULL(ser.razon_social, '') razon_social,
                        'FAC' tipo,
                        GROUP_CONCAT(cxc.id SEPARATOR ';') idCxc,
                        IFNULL(GROUP_CONCAT(IF(cxc.id_venta>0,'VENTA',IF(cxc.id_plan>0,'PLAN',IF(cxc.id_orden_servicio>0,'ORDEN',null))) SEPARATOR ';'),'') AS origen,
                        IFNULL(GROUP_CONCAT(IF(cxc.folio_recibo=0,null,cxc.folio_recibo) SEPARATOR ';'),'') folioCxc,
                        cxc.folio_factura folioFactura,
                        cxc.fecha fechaInicio,
                        cxc.vencimiento fechaVencimiento,
                        fac.subtotal subtotal,
                        fac.iva iva,
                        fac.total total,
                        pd.importe_pagado totalPagado,
                        COUNT(cxc.id) registrosCXC,
                        fac.total - pd.importe_pagado saldo,
                    IFNULL(ne.vendedor, IFNULL(ne2.vendedor, '')) vendedor
                    FROM cxc as cxc
                    INNER JOIN facturas fac ON fac.id = cxc.id_factura
                    INNER JOIN sucursales suc ON suc.id_sucursal = cxc.id_sucursal
                    INNER JOIN pagos_d pd ON pd.id_factura = fac.id
                    INNER JOIN pagos_e pe ON pe.id = pd.id_pago_e
                    LEFT JOIN servicios ser ON ser.id = pe.id_razon_social
                LEFT JOIN notas_e ne ON ne.id=cxc.id_venta
                LEFT JOIN notas_e ne2 ON ne.id=cxc.id_plan
                    WHERE cxc.id_unidad_negocio = 2
                        $condSucursales
                        AND cxc.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    GROUP BY fac.id";        

            // $query = "/*AQUI SE OBTINEN TODOS LOS CXC QUE NO FACTURAN*/
            // (SELECT 
            //     IFNULL(b.nombre,'') AS UNIDAD,
            //     IFNULL(c.descr,'') AS SUCURSAL,
            //     IFNULL(d.nombre_corto,'') AS NOMBRE_CORTO,
            //     IFNULL(d.razon_social,'') AS RAZON_SOCIAL,
            //     '' AS NOMBRES_CLIENTES,
            //     a.id AS FOLIO_CXC,
            //     IF(a.folio_factura=0,'',a.folio_factura) AS FOLIO_FACTURA,
            //     'CXC' AS TIPO,
            //     IF(a.id_venta>0,a.fecha,a.fecha_corte_recibo) AS FECHA_INICIO,
            //     IF(a.id_venta>0,a.fecha,a.vencimiento) AS FECHA_FIN,
            //     IF(a.id_venta>0,a.fecha,a.vencimiento) AS VENCIMIENTO,
            //     FORMAT(IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C' AND a.cargo_inicial=1),a.total,0),0)),0),2) AS CARGOS,
            //     FORMAT(IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'A'),a.total,0),0)),0),2) AS ABONOS,
            //     FORMAT(IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),a.total,((a.total) * -(1))),0)),0),2) AS SALDO
            // FROM cxc a
            // LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
            // LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
            // LEFT JOIN servicios d ON a.id_razon_social_servicio=d.id
            // WHERE a.id_factura=0 AND a.id_nota_credito=0 AND (a.id_orden_servicio>0 OR a.id_venta>0 OR a.id_plan>0) AND a.facturar=0 
            // $condSucursales $condFechaCxc
            // GROUP BY a.folio_cxc
            // HAVING saldo > 0
            // ORDER BY d.nombre_corto ASC)            
            // UNION ALL      
            // /*AQUI SE OBTINEN TODAS LAS FACTURAS DE ALARMAS*/      
            // (SELECT 
            //     n.nombre AS UNIDAD,
            //     o.descr AS SUCURSAL,
            //     IFNULL(TRIM(p.nombre_corto),'VENTA PUBLICO EN GENERAL') AS NOMBRE_CORTO,
            //     IFNULL(p.razon_social,IFNULL(TRIM(p.nombre_corto),'VENTA PUBLICO EN GENERAL')) AS RAZON_SOCIAL,
            //     pre.nombres_cxc AS NOMBRES_CXC,
            //     pre.folio_cxc AS FOLIO_CXC,
            //     k.folio AS FOLIO_FACTURA,
            //     'FACTURA' AS TIPO,   
            //     k.fecha_inicio AS FECHA_INICIO,
            //     k.fecha_fin AS FECHA_FIN,
            //     DATE_ADD(k.fecha, INTERVAL k.dias_credito DAY) AS VENCIMIENTO,
            //     FORMAT(SUM(pre.total_facturado),2) AS CARGOS,
            //     FORMAT(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual),2) AS ABONOS,
            //     FORMAT(SUM(pre.total_facturado)-(SUM(pre.pagos_mensual)+SUM(pre.notas_mensual)),2) AS SALDO
            // FROM( 
            //     /*SE OBTIENE TOTAL FACTURADO Y TOTAL NOTAS CREDITO DEL MES*/
            //     SELECT  a.id,
            //         COUNT(DISTINCT(b.id_cxc))AS registros_cxc,
            //         GROUP_CONCAT(DISTINCT(b.id_cxc) SEPARATOR ';')AS folio_cxc,
            //         GROUP_CONCAT(DISTINCT(d.nombre_corto) SEPARATOR ';')AS nombres_cxc,
            //         a.metodo_pago,
            //         CONCAT(IF(MONTH(a.fecha) < 10,CONCAT('0',MONTH(a.fecha)),MONTH(a.fecha)),'-',YEAR(a.fecha)) AS fecha,
            //         IFNULL(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total-a.descuento,0),0),0) AS total_facturado,
            //         IFNULL(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito!=0,a.total-a.descuento,0),0),0) AS abonos_facturado,
            //         IFNULL(IF(a.estatus IN ('A','T'),IF(a.id_factura_nota_credito=0,a.total-a.descuento,(a.total-a.descuento)),0),0) AS saldo_facturado,
            //         0 AS pagos_mensual,
            //         0 AS notas_mensual
            //     FROM facturas a
            //     LEFT JOIN facturas_d b ON a.id=b.id_factura
            //     LEFT JOIN cxc c ON b.id_cxc = c.id
            //     LEFT JOIN servicios d ON d.id=c.id_razon_social_servicio
            //     WHERE (a.es_plan>0 OR a.es_venta_orden>0 OR a.id_cxc>0) 
            //     $condSucursales $condFechaFactura
            //     GROUP BY a.id
            // /* AQUI OBTIENE LA INFORMACION DEL TOTAL DE PAGOS POR FACTURAS DEL MES*/
            // UNION ALL
            // SELECT 
            //     b.id_factura,
            //     0 AS registros_cxc,
            //     '' AS folio_cxc,
            //     '2' as nombres_cxc,
            //     a.metodo_pago,
            //     DATE_FORMAT(DATE(c.fecha), '%Y-%m') AS fecha,
            //     0 AS total_facturado,
            //     0 AS abonos_facturado,
            //     0 AS saldo_facturado,
            //     SUM(IF(c.estatus IN ('A','T'),b.importe_pagado,0)) AS pagos_mensual,
            //     0 AS notas_mensual
            // FROM pagos_e c
            // LEFT JOIN pagos_d b ON c.id=b.id_pago_e
            // LEFT JOIN facturas a ON b.id_factura=a.id 
            // WHERE (a.es_plan>0 OR a.es_venta_orden>0 OR a.id_cxc>0) 
            //     $condSucursales $condFechaFactura
            //     GROUP BY b.id_factura
            // /* AQUI OBTIENE LA INFORMACION DEL TOTAL DE NOTAS DE CREDITO POR FACTURA*/
            // UNION ALL
            // SELECT 
            //     sub.id_factura,
            //     0 AS registros_cxc,
            //     '' AS folio_cxc,
            //     '1' as nombres_cxc,
            //     sub.metodo_pago,
            //     DATE_FORMAT(sub.fecha,'%Y-%m') AS fecha,
            //     0 AS total_facturado,
            //     0 AS abonos_facturado,
            //     0 AS saldo_facturado,
            //     0 AS pagos_mensual,
            //     SUM(IF(sub.id=b.id_factura_nota_credito,b.total,0))AS notas_mensual
            // FROM ( 
            // SELECT 
            // a.id,
            // a.metodo_pago,
            // a.folio,
            // a.fecha,'F' AS tipo,
            // a.id AS id_factura,
            // SUM(a.total) AS total 
            // FROM facturas a
            // WHERE a.estatus IN('A','T') AND a.id_factura_nota_credito=0 AND (a.es_plan>0 OR a.es_venta_orden>0 OR a.id_cxc>0) 
            // $condSucursales $condFechaFactura
            // GROUP BY a.id
            //     )AS sub
            //     LEFT JOIN facturas b ON sub.id=b.id_factura_nota_credito AND b.estatus ='T'
            //     GROUP BY sub.id_factura
            // ) AS pre
            // LEFT JOIN facturas k ON pre.id=k.id
            // LEFT JOIN empresas_fiscales l ON k.id_empresa_fiscal=l.id_empresa
            // LEFT JOIN facturas_cfdi m ON k.id=m.id_factura
            // LEFT JOIN cat_unidades_negocio n ON k.id_unidad_negocio=n.id
            // LEFT JOIN sucursales o ON k.id_sucursal=o.id_sucursal
            // LEFT JOIN servicios p ON k.id_razon_social = p.id
            // GROUP BY pre.id
            // HAVING saldo > 0
            // ORDER BY p.nombre_corto ASC)";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTE_COBRANZA_DIA')
        {

            $arreglo = json_decode($datos, true);
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];            
            
            $query = "SELECT
                        ser.nombre_corto AS Cliente,
                        ser.cuenta AS NumCuenta,
                        ser.telefonos AS Telefonos,
                        CASE
                            WHEN cxc.id_orden_servicio > 0 THEN cxc.id_orden_servicio
                            WHEN cxc.id_venta > 0 THEN cxc.folio_venta
                            WHEN cxc.folio_recibo > 0 THEN cxc.folio_recibo
                            ELSE cxc.folio_cxc
                        END AS Folio,
                            CASE
                            WHEN cxc.id_orden_servicio > 0 THEN 'Servicio'
                            WHEN cxc.id_venta > 0 THEN 'Instalacion'
                            WHEN cxc.folio_recibo > 0 THEN 'Monitoreo'
                            ELSE ''
                        END AS Tipo,
                        cxc.total AS Importe,
                        cb.monto_ingresado,
                        cxc.fecha as Fecha,
                        IFNULL(tablaComents.coments, '') Comentarios,
                        cb.fecha AS FechaPago,
                        cb.forma_pago AS Tipo,
                        ccp.descripcion AS FormaPago,
                        cub.descripcion AS CuentaBanco,
                        cb.referencias AS Referencias,
                        us.usuario
                    FROM cxc_bitacora cb
                    INNER JOIN cxc ON cb.folio_cxc = cxc.id
                    INNER JOIN servicios ser ON cxc.id_razon_social_servicio = ser.id
                    INNER JOIN conceptos_cxp ccp ON ccp.id = cb.id_concepto
                    INNER JOIN cuentas_bancos cub ON cub.id = cb.id_cuenta_banco
                    INNER JOIN usuarios us ON us.id_usuario = cb.id_usuario_captura
                    LEFT JOIN (
                        SELECT fk_id_cxc AS id_cxc, GROUP_CONCAT(comentario SEPARATOR '\n') AS coments FROM bitacora_cobranza GROUP BY fk_id_cxc
                    ) AS tablaComents ON tablaComents.id_cxc = cxc.id
                    WHERE DATE(cb.fecha) BETWEEN '$fechaInicio' AND '$fechaFin'
                    ORDER BY cb.fecha DESC";
            
            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTE_COBRANZA_DIA_COMPLETO')
        {

            $arreglo = json_decode($datos, true);
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];            
            
            $query = "SELECT
                  cxc.id,
                  cxc.id_orden_servicio,
                  cxc.folio_venta,
                  cxc.id_venta,
                  cxc.folio_recibo,
                  (cxc.total - IFNULL(tabla.abonado, 0)) as total,
                  se.nombre_corto,
                  se.cuenta,
                  se.telefonos,
                  cxc.fecha
                FROM cxc
                LEFT JOIN servicios se ON cxc.id_razon_social_servicio = se.id
                LEFT JOIN (
                  SELECT SUM(monto_ingresado) AS abonado, folio_cxc
                  FROM cxc_bitacora
                  GROUP BY folio_cxc
                ) AS tabla ON tabla.folio_cxc = cxc.folio_cxc 
                WHERE cxc.id_sucursal IN (23, 57, 72)
                AND cxc.fecha_captura BETWEEN '$fechaInicio' AND '$fechaFin'
                AND (cxc.folio_venta <> 0 OR cxc.folio_recibo <> 0 OR cxc.id_orden_servicio <> 0)
                AND cxc.estatus IN ('T', 'A')";
            
            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo=='REPORTES_RECIBO'){
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            //$id = isset($arreglo['id']) ? $arreglo['id'] : 0;
            //$tipo = $arreglo['tipo'];
            $arregloSucursales = explode(",", $arreglo['idSucursal']);
            $stringSucursales = $arreglo['idSucursal'];

            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            // $idSucursal = $arreglo['idSucursal'];

            //-->NJES October/21/2020 se agrega filtro sucursal
            IF(COUNT($arregloSucursales) > 1){
                $condSucursales = " AND suc.id_sucursal IN($stringSucursales)";
            }else{
                $condSucursales = " AND suc.id_sucursal = $stringSucursales";
            }
      
              //$condSucursales='';
      
            if($fechaInicio == '' && $fechaFin == '')
                $condFecha = " AND DATE(cxc.fecha) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            else if($fechaInicio != '' &&  $fechaFin == '')
                $condFecha = " AND DATE(cxc.fecha) >= '$fechaInicio' ";
            else
                $condFecha = " AND DATE(cxc.fecha) BETWEEN '$fechaInicio' AND '$fechaFin'";
            
            $query = "SELECT 
                fac.id,
                suc.descripcion sucursal,
                cxc.folio_factura folioFac,
                cxc.folio_recibo folioRec,
                IF(fac.es_plan = 1, cxc.fecha_corte_recibo, cxc.fecha_captura) fecha,
                ser.nombre_corto servicio,
                ser.cuenta,
                IFNULL(scp.descripcion, '') plan,
                IFNULL(ne.folio, '') venta,
                IFNULL(so.id, '') soid,
                COUNT(cxc.id) num_mult_cxc,
                SUM(cxc.total) importeCxc,
                fac.observaciones,
                CASE
                    WHEN cxc.id_venta > 0 THEN ne.vendedor
                    ELSE ''
                END vendedor,
                CASE
                    WHEN cxc.id_venta > 0 THEN ne.tecnico
                    WHEN cxc.id_orden_servicio > 0 THEN so.tecnico
                    ELSE ''
                END tecnico,
                CASE
                    WHEN cxc.id_orden_servicio > 0 THEN us.usuario
                    ELSE ''
                END usuarioCreacion,
                fac.total importeFac,
                fac.subtotal importeSinIvaFac,
                IFNULL(pagos.abono, 0) abono,
                IFNULL(so.servicio, '') descServicio,
                fac.descuento,
                ((fac.total - IFNULL(pagos.abono, 0))-fac.descuento) saldoInsoluto,
                cxc.fecha_corte_recibo fechaInicio,
                cxc.vencimiento fechaFin,
                CASE
                    WHEN cxc.estatus = 'C' THEN 'Cancelado'
                    WHEN cxc.estatus = 'A' THEN 'Activo'
                    WHEN cxc.estatus = 'T' THEN 'Timbrado'
                END estatusCxc,
                IFNULL(cxc.justificacion_cancelado, '') justiCanc,
                CASE
                    WHEN fac.estatus = 'C' THEN 'Cancelado'
                    WHEN fac.estatus = 'A' THEN 'Activo'
                    WHEN fac.estatus = 'T' THEN 'Timbrado'
                END estatusFac
              FROM cxc as cxc
              LEFT JOIN sucursales suc ON suc.id_sucursal = cxc.id_sucursal
              LEFT JOIN servicios ser ON cxc.id_razon_social_servicio = ser.id
              INNER JOIN facturas fac ON cxc.id_factura = fac.id
              LEFT JOIN servicios_bitacora_planes sbp ON cxc.id_plan = sbp.id
              LEFT JOIN servicios_cat_planes scp ON sbp.id_plan = scp.id
              LEFT JOIN notas_e ne ON ne.id = cxc.id_venta
              LEFT JOIN servicios_ordenes so ON cxc.id_orden_servicio = so.id
              LEFT JOIN usuarios us ON us.id_usuario = so.id_usuario_captura
              LEFT JOIN (
                SELECT SUM(importe_pagado) abono, id_factura
                  FROM pagos_d
                  GROUP BY id_factura
                ) pagos ON pagos.id_factura = fac.id
              WHERE suc.id_unidad_negocio = 2
                    $condSucursales
                    $condFecha
              GROUP BY cxc.id_factura ,fac.id;";

            // $query = "SELECT  
            //             su.descr AS SUCURSAL,
            //             r.folio_recibo AS FOLIO_RECIBO,
            //             r.fecha_corte_recibo AS FECHA_DE_RECIBO,
            //             u.nombre_corto AS NOMBRE_CORTO_DE_CLIENTE,
            //             IFNULL(s.descripcion,'') AS PLAN,
            //             r.total AS IMPORTE_CXC,
            //             IFNULL(fn.total_factura,0) AS IMPORTE_FACTURA,
            //             IFNULL(fn.abonos_factura,0)+IFNULL(abonos.abonos_cxc,0) AS ABONOS,
            //             IF(IFNULL(fn.total_factura,0)>0 && fn.estatus_factura='T',fn.total_factura-IFNULL(fn.abonos_factura,0),r.total-IFNULL(abonos.abonos_cxc,0)) AS SALDO_INSOLUTO,
            //             r.fecha_corte_recibo AS FECHA_INICIO_DE_PERIODO,
            //             r.vencimiento AS FECHA_FIN_DE_PERIODO,
            //             IF(r.estatus='A','Activo',IF(r.estatus='P','Pendiente',IF(r.estatus='S','Saldado',IF(r.estatus='T','Timbrado','Cancelado')))) AS ESTATUS_DE_CXC,
            //             IFNULL(r.justificacion_cancelado,'') AS JUSTIFICACIÓN_DE_CANCELACIÓN,
            //             CASE
            //             WHEN fn.estatus_factura = 'A' THEN 'Sin Timbrar'
            //             WHEN fn.estatus_factura = 'T' THEN 'Timbrada'
            //             WHEN fn.estatus_factura = 'P' THEN 'Pendiente'
            //             WHEN fn.estatus_factura = 'C' THEN 'Cancelada'
            //             ELSE IFNULL(fn.estatus_factura,'')
            //             END AS ESTATUS_DE_FACTURACIÓN
            //       FROM cxc r 
            //       LEFT JOIN servicios_bitacora_planes f ON r.id_plan=f.id
            //       LEFT JOIN servicios_cat_planes s ON f.id_plan=s.id
            //       LEFT JOIN servicios u ON r.id_razon_social_servicio=u.id
            //       LEFT JOIN sucursales su ON r.id_sucursal=su.id_sucursal
            //       LEFT JOIN (
            //         SELECT COUNT(id) AS num_mult_cxc,id_factura 
            //         FROM cxc WHERE id_factura > 0 
            //         GROUP BY id_factura) AS mult ON r.id_factura=mult.id_factura
            //       LEFT JOIN (
            //         SELECT folio_cxc,IFNULL(SUM(total),0) AS abonos_cxc
            //         FROM cxc
            //         WHERE id!=folio_cxc AND estatus != 'C'
            //         GROUP BY folio_cxc) AS abonos ON r.id=abonos.folio_cxc
            //       LEFT JOIN (SELECT   a.id_razon_social,
            //         a.id_cliente,
            //         a.folio,
            //         a.fecha,
            //         'F' AS tipo,
            //         a.id AS  id_factura,
            //         IF(a.retencion=1,SUM(IFNULL(a.total,0))-SUM(IFNULL(a.importe_retencion,0))-a.descuento,SUM(IFNULL(a.total,0))-a.descuento) AS total_factura,
            //         SUM(IFNULL(nc.abonos_nc,0))+SUM(IFNULL(pagos.abonos_pagos,0)) AS abonos_factura,
            //         a.estatus AS estatus_factura
            //         FROM facturas a
            //         LEFT JOIN (SELECT id, id_factura_nota_credito,SUM(total) AS abonos_nc
            //           FROM facturas 
            //           WHERE estatus IN('T') AND id_factura_nota_credito!=0 AND id_unidad_negocio=2
            //           GROUP BY id_factura_nota_credito) AS nc ON a.id=nc.id_factura_nota_credito
            //         LEFT JOIN (SELECT 
            //           b.id_factura AS id_factura,
            //           IFNULL(SUM(b.importe_pagado),0) AS abonos_pagos
            //           FROM pagos_e a
            //           LEFT JOIN pagos_d b ON a.id=b.id_pago_e
            //           WHERE a.estatus IN('A','T') AND id_unidad_negocio=2
            //           GROUP BY b.id_factura) AS pagos ON a.id=pagos.id_factura
            //         WHERE  a.id_factura_nota_credito=0 AND a.id_unidad_negocio=2
            //         GROUP BY a.id
            //         ) fn ON r.id_factura=fn.id_factura
            //       WHERE r.id_plan > 0 AND r.folio_recibo > 0 AND r.id_unidad_negocio=2
            //       $condSucursales $condFecha
            //       GROUP BY r.folio_recibo
            //       ORDER BY r.folio_recibo ASC";

            /*$query = "SELECT  
                        r.folio_recibo AS FOLIO_RECIBO,
                        r.fecha_corte_recibo AS FECHA_DE_RECIBO,
                        u.nombre_corto AS NOMBRE_CORTO_DE_CLIENTE,
                        IFNULL(s.descripcion,'') AS PLAN,
                        r.total AS IMPORTE_CXC,
                        IFNULL(fn.total_factura,0) AS IMPORTE_FACTURA,
                        IFNULL(fn.abonos_factura,0)+IFNULL(abonos.abonos_cxc,0) AS ABONOS,
                        IF(IFNULL(fn.total_factura,0)>0 && fn.estatus_factura='T',fn.total_factura-IFNULL(fn.abonos_factura,0),r.total-IFNULL(abonos.abonos_cxc,0)) AS SALDO_INSOLUTO,
                        r.fecha_corte_recibo AS FECHA_INICIO_DE_PERIODO,
                        r.vencimiento AS FECHA_FIN_DE_PERIODO,
                        IF(r.estatus='A','Activo',IF(r.estatus='P','Pendiente',IF(r.estatus='S','Saldado',IF(r.estatus='T','Timbrado','Cancelado')))) AS ESTATUS_DE_CXC,
                        IFNULL(r.justificacion_cancelado,'') AS JUSTIFICACIÓN_DE_CANCELACIÓN,
                        CASE
                        WHEN fn.estatus_factura = 'A' THEN 'Sin Timbrar'
                        WHEN fn.estatus_factura = 'T' THEN 'Timbrada'
                        WHEN fn.estatus_factura = 'P' THEN 'Pendiente'
                        WHEN fn.estatus_factura = 'C' THEN 'Cancelada'
                        ELSE IFNULL(fn.estatus_factura,'')
                        END AS ESTATUS_DE_FACTURACIÓN
                        FROM cxc r 
                        LEFT JOIN servicios_bitacora_planes f ON r.id_plan=f.id
                        LEFT JOIN servicios_cat_planes s ON f.id_plan=s.id
                        LEFT JOIN servicios u ON r.id_razon_social_servicio=u.id
                        LEFT JOIN sucursales su ON r.id_sucursal=su.id_sucursal
                        LEFT JOIN (
                        SELECT folio_cxc,IFNULL(SUM(total),0) AS abonos_cxc
                        FROM cxc
                        WHERE id!=folio_cxc AND estatus != 'C'
                        GROUP BY folio_cxc) AS abonos ON r.id=abonos.folio_cxc
                        LEFT JOIN (SELECT   a.id_razon_social,
                        a.id_cliente,
                        a.folio,
                        a.fecha,
                        'F' AS tipo,
                        a.id AS  id_factura,
                        IF(a.retencion=1,SUM(a.total)-SUM(a.importe_retencion)-a.descuento,SUM(a.total)-a.descuento) AS total_factura,
                        SUM(nc.abonos_nc)+SUM(pagos.abonos_pagos) AS abonos_factura,
                        a.estatus AS estatus_factura
                        FROM facturas a
                        LEFT JOIN (SELECT id, id_factura_nota_credito,SUM(total) AS abonos_nc
                            FROM facturas 
                            WHERE estatus IN('T') AND id_factura_nota_credito!=0 AND id_unidad_negocio=2
                            GROUP BY id_factura_nota_credito) AS nc ON a.id=nc.id_factura_nota_credito
                        LEFT JOIN (SELECT 
                            b.id_factura AS id_factura,
                            IFNULL(SUM(b.importe_pagado),0) AS abonos_pagos
                            FROM pagos_e a
                            LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                            WHERE a.estatus IN('A','T') AND id_unidad_negocio=2
                            GROUP BY b.id_factura) AS pagos ON a.id=pagos.id_factura
                        WHERE  a.id_factura_nota_credito=0 AND a.id_unidad_negocio=2
                        GROUP BY a.id
                        ) fn ON r.id_factura=fn.id_factura
                        WHERE r.id_plan > 0 AND r.folio_recibo > 0 AND r.id_unidad_negocio=2 
                        $condSucursales $condFecha
                        GROUP BY r.folio_recibo
                        ORDER BY r.folio_recibo ASC";*/

            // echo $query;
            // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'REPORTE_COTIZACIONES_VENTAS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];
            $idSucursal = $arreglo['idSucursal'];

            if($fechaInicio == '' && $fechaFin == '')
                $condFecha = " AND DATE(a.fecha_captura) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            else if($fechaInicio != '' &&  $fechaFin == '')
                $condFecha = " AND DATE(a.fecha_captura) >= '$fechaInicio' ";
            else
                $condFecha = " AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin'";
            
            $query = "SELECT s.descr AS SUCURSAL, a.folio AS FOLIO,
                        IF(a.cotizacion=1,'Cotización','Venta') AS MOVIMIENTO,
                        IF(a.tipo_cotizacion>0,IF(a.tipo_cotizacion=1,'Alarma',IF(a.tipo_cotizacion=2,'Servicio de Monitoreo','Mixta')),'') AS TIPO,
                        IFNULL(b.folio,'') AS FOLIO_COTIZACIÓN,
                        DATE(a.fecha_captura) AS FECHA_CAPTURA,
                        TRIM(IF(a.id_cliente=0,a.cliente_cotizacion,c.nombre_corto)) AS CLIENTE,
                        iFNULL(a.vendedor, '')  as VENDEDOR,
                        a.total AS IMPORTE_COTIZADO,
                        a.subtotal AS PRECIO_VENTA_SIN_IVA,
                        SUM(IFNULL(f.ultimo_precio_compra * e.cantidad,0.00)) AS PRECIO_ÚLTIMA_COMPRA,
                        a.descuento AS DESCUENTO,
                        a.costo_instalacion AS IMPORTE_INSTALACIÓN,
                        a.costo_administrativo AS IMPORTE_ADMIN,
                        a.comision_venta AS IMPORTE_COMISION,
                        d.usuario AS USUARIO_CAPTURA,
                        -- IF(a.estatus='A','Activa','Cancelada') AS ESTATUS
                        IF(a.estatus='C','Cancelada',IF(a.cotizacion=0,'Activo', (IF(f.id > 0, 'Autorizada', 'Seguimiento') ))) AS ESTATUS
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
                        WHERE a.id_sucursal=$idSucursal
                        $condFecha
                        GROUP BY a.id
                        ORDER BY a.fecha_captura ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'REPORTE_ACTIVOS_ASIGNACIONES')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            if($fechaInicio == '' && $fechaFin == '')
              $condFecha=" AND DATE(activos_responsables.fecha_inicio) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            else if($fechaInicio != '' &&  $fechaFin == '')
              $condFecha=" AND DATE(activos_responsables.fecha_inicio) >= '$fechaInicio' ";
            else  //-->trae fecha inicio y fecha fin
              $condFecha=" AND DATE(activos_responsables.fecha_inicio) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            
            
            $query = "SELECT 
                        empresas_fiscales.razon_social AS RAZÓN_SOCIAL,
                        sucursales.descr AS SUCURSAL, 
                        cat_areas.descripcion AS ÁREA, 
                        deptos.des_dep AS DEPARTAMENTO,
                        activos_responsables.id_trabajador AS NO_EMPLEADO, 
                        activos_responsables.id_cliente AS NO_TRABAJADOR, 
                        IF(activos_responsables.id_cliente>0, IFNULL(razones_sociales.razon_social,''),CONCAT(IFNULL(trabajadores.nombre,''),'',IFNULL(trabajadores.apellido_p,''),' ',IFNULL(trabajadores.apellido_m,''))) AS RESPONSABLE,
                        activos.no_serie AS NO_SERIE, 
                        activos.num_economico AS NO_ECONOMICO,
                        IFNULL(vehiculos.imei_gps,'') AS IMEI_GPS,
                        activos.descripcion AS DESCRIPCIÓN,
                        activos_responsables.fecha_inicio AS FECHA_INICIO,
                        IF(activos_responsables.fecha_fin='0000-00-00','',activos_responsables.fecha_fin) AS FECHA_FIN
                        FROM activos_responsables
                        LEFT JOIN empresas_fiscales ON empresas_fiscales.id_empresa=activos_responsables.id_unidad_negocio
                        LEFT JOIN sucursales ON sucursales.id_sucursal=activos_responsables.id_sucursal
                        LEFT JOIN cat_areas ON cat_areas.id=activos_responsables.id_area
                        LEFT JOIN deptos ON deptos.id_depto=activos_responsables.id_departamento
                        LEFT JOIN trabajadores ON trabajadores.id_trabajador=activos_responsables.id_trabajador
                        LEFT JOIN activos ON activos.id=activos_responsables.id_activo
                        LEFT JOIN razones_sociales ON razones_sociales.id=activos_responsables.id_cliente
                        LEFT JOIN vehiculos ON activos.id=vehiculos.id_activo
                        WHERE activos_responsables.id_unidad_negocio=$idUnidadNegocio
                        $condFecha
                        ORDER BY activos_responsables.id DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }    

        if($modulo == 'MOVIMIENTO_BANCOS')
        {
            $query = "SELECT    c.descripcion AS Banco,
                            b.cuenta AS Cuenta,
                            a.monto,
                            a.tipo
                        FROM movimientos_bancos a
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        WHERE MONTH(a.fecha)=MONTH(CURDATE())";
            
            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'REPORTE_ACTIVOS_BITACORA')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar

            $tipo = $arreglo['tipo'];
            $fechaInicio = $arreglo['fechaInicio'];
            $fechaFin = $arreglo['fechaFin'];

            $condicionTipo = '';
            if($tipo!='')
                $condicionTipo = " AND activos_bitacora.tipo LIKE '%$tipo%' ";
            

            if($fechaInicio == '' && $fechaFin == '')
                $condFecha=" AND activos_bitacora.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            else if($fechaInicio != '' &&  $fechaFin == '')
                $condFecha=" AND activos_bitacora.fecha >= '$fechaInicio' ";
            else
                $condFecha=" AND activos_bitacora.fecha BETWEEN '$fechaInicio' AND '$fechaFin' ";
            
            
            $query = "SELECT 
                    activos.no_serie AS NO_SERIE,
                    activos.num_economico AS NO_ECONOMICO,
                    activos_bitacora.tipo AS TIPO, 
                    IFNULL(requisiciones.folio,'') AS FOLIO_REQUISICIÓN,
                    activos_bitacora.descripcion AS DESCRIPCIÓN, 
                    activos_bitacora.fecha AS FECHA, 
                    activos_bitacora.kilometraje AS KILOMETRAJE
                    FROM activos_bitacora
                    LEFT JOIN activos ON activos.id = activos_bitacora.id_activo
                    LEFT JOIN requisiciones ON activos.num_economico=requisiciones.no_economico
                    WHERE 1 $condicionTipo $condFecha";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'REPORTE_PEDIDOS_ALMACEN')
        {

            $query = "SELECT 
                pedidos.id AS FOLIO_PEDIDO,
                almacen_e.folio AS FOLIO_ALMACEN,
                CONCAT_WS(' - ', almacen_e.cve_concepto, conceptos_almacen.concepto) AS CONCEPTO,
                cat_clientes.nombre_comercial AS CLIENTE,
                razones_sociales.razon_social AS RAZON_SOCIAL,
                pedidos.fecha_captura AS FECHA,
                pedidos.subtotal AS SUBTOTAL,
                pedidos.iva AS IVA,
                pedidos.total AS TOTAL
                FROM pedidos
                INNER JOIN cat_clientes ON pedidos.id_cliente = cat_clientes.id
                INNER JOIN razones_sociales ON pedidos.id_razon_social = razones_sociales.id
                INNER JOIN almacen_e ON pedidos.id = almacen_e.id_pedido
                INNER JOIN conceptos_almacen ON almacen_e.cve_concepto = conceptos_almacen.clave";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTE_PEDIDOS_REAL')
        {

            $query = "
                SELECT
                  productos.clave AS CLAVE_PRODUCTO,
                  productos.concepto AS CONCEPTO,
                  SUM(pedidos_d.m_real) AS MERMA_REAL,
                  familias.descripcion AS FAM,
                  lineas.descripcion AS LINEA                  
                  FROM pedidos_d
                  INNER JOIN productos ON pedidos_d.id_producto = productos.id
                  INNER JOIN familias  ON productos.id_familia = familias.id
                  INNER JOIN lineas ON productos.id_linea = lineas.id
                  GROUP BY pedidos_d.id_producto";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'REPORTE_PRODUCTO_TERM')
        {

            $query = "
                SELECT 
          facturas.folio AS folio_factura,
          facturas.fecha AS fecha,
          facturas_d.cantidad AS total_producto,
          facturas_d.descripcion AS producto
          FROM facturas_d
          INNER JOIN facturas ON facturas_d.id_factura = facturas.id
          WHERE facturas.id_unidad_negocio = 3
          GROUP BY facturas_d.descripcion";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo == 'GASTOS_REQUIS_AUTORIZADAS')
        {
            $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
            $idUnidadNegocio = $arreglo['idUnidadNegocio'];
            $idSucursal = $arreglo['idSucursal'];
            $fecha_inicio = $arreglo['fecha_inicio'];
            $fecha_fin = $arreglo['fecha_fin'];

            $where = '';

            if($idUnidadNegocio[0] == ',')
            {
                $dato=substr($idUnidadNegocio,1);
                $where .= ' AND cat_unidades_negocio.id IN('.$dato.') ';
            }else{ 
                $where .= ' AND cat_unidades_negocio.id ='.$idUnidadNegocio;
            }
        
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $where .= ' AND sucursales.id_sucursal IN('.$dato.') ';
            }else{ 
                $where .= ' AND sucursales.id_sucursal ='.$idSucursal;
            }
            
            if($fecha_inicio == '' && $fecha_fin == '')
                $where .= " AND requisiciones.fecha_pedido >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            else if($fecha_inicio != '' &&  $fecha_fin == '')
                $where .= " AND requisiciones.fecha_pedido >= '$fecha_inicio' ";
            else  //-->trae fecha inicio y fecha fin
                $where .= " AND requisiciones.fecha_pedido >= '$fecha_inicio' AND requisiciones.fecha_pedido <= '$fecha_fin' ";
    

            $query = "SELECT
                requisiciones.folio AS FOLIO,
                cat_unidades_negocio.nombre AS UNIDAD_NEGOCIO, 
                sucursales.descr AS SUCURSAL,
                cat_areas.descripcion AS AREA,
                IFNULL(deptos.des_dep,'') AS DEPARTAMENTO,
                proveedores.nombre as PROVEEDOR,
                FORMAT(requisiciones.total,2) AS MONTO,
                IF(requisiciones.estatus=2,'Autorizada','Pendiente') AS ESTATUS
                FROM requisiciones
                INNER JOIN cat_unidades_negocio ON requisiciones.id_unidad_negocio = cat_unidades_negocio.id
                INNER JOIN sucursales ON requisiciones.id_sucursal = sucursales.id_sucursal
                INNER JOIN cat_areas ON requisiciones.id_area = cat_areas.id
                INNER JOIN deptos ON requisiciones.id_departamento = deptos.id_depto AND deptos.tipo='I'
                INNER JOIN proveedores ON requisiciones.id_proveedor = proveedores.id
                LEFT JOIN gastos ON requisiciones.id=gastos.id_requisicion
                WHERE requisiciones.tipo=1 AND requisiciones.estatus=2 AND requisiciones.omitir=0
                AND gastos.id_requisicion IS NULL
                $where
                ORDER BY requisiciones.id DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'CXC_NO_COBRADAS')
        {

            $arreglo = json_decode($datos, true);

            $idUnidadNegocio = $arreglo['id_unidad_negocio'];
            $idSucursal = $arreglo['id_sucursal'];
            $fechaInicio = $arreglo['fecha_de'];
            $fechaFin = $arreglo['fecha_a'];
            $idCliente = $arreglo['id_cliente'];
            $idRazonSocial = $arreglo['id_razon_social'];
            $nombreUnidad = $arreglo['nombre_unidad'];

            $condicion = '';

            if($fechaInicio == '' && $fechaFin == '')
                $condicion .= " AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            else if($fechaInicio != '' &&  $fechaFin == '')
                $condicion .= " AND a.fecha >= '$fechaInicio' ";
            else
                $condicion .= " AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";

            if($idUnidadNegocio != '')
                $condicion .= " AND a.id_unidad_negocio =  $idUnidadNegocio";

            if($idSucursal != '')
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
                facturando.unidad_negocio AS UNIDAD_NEGOCIO,  
                facturando.sucursal AS SUCURSAL,
                facturando.fecha AS FECHA,
                facturando.cliente AS CLIENTE,  
                facturando.razon_social AS RAZON_SOCIAL_RECEPTOR,
                facturando.empresa_fiscal AS RAZON_SOCIAL_EMISOR,
                facturando.fecha_vencimiento AS FECHA_VENCIMIENTO, 
                facturando.folio_cxc AS FOLIO_CXC,           
                facturando.factura AS FACTURA,           
                facturando.nota AS NOTA_CREDITO,            
                facturando.cargo_inicial AS CARGO_INICIAL,
                facturando.saldo AS SALDO,
                CASE
                    WHEN facturando.estatus = 'C' THEN 'Cancelada'
                    WHEN facturando.estatus = 'P' THEN 'Pendiente'
                    WHEN facturando.estatus = 'S' THEN 'Saldada'
                    WHEN facturando.estatus = 'T' THEN 'Timbrada'
                    ELSE 'Sin Timbrar'
                END AS ESTATUS            
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

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
            
        }

        if($modulo == 'REPORTES_REQUISICIONES_FUERA_PRESUPUESTO'){

            $arreglo = json_decode($datos, true);

            $idUsuario = $arreglo['idUsuario'];
            $idsSucursales = $arreglo['idsSucursales'];

            if($idsSucursales!=''){

                if (strpos($idsSucursales, ',') !== false) {
                  
                  $dato=substr(trim($idsSucursales),1);
                  $condicionSucursal=' a.id_sucursal in ('.$dato.')';
                }else{
                  $condicionSucursal=' a.id_sucursal ='.$idsSucursales;
                }
          
            }else{            
                $condicionSucursal=' a.id_sucursal =0';
            }
    
            $query = "SELECT b.nombre AS unidad_negocio,
                            c.clave AS clave_suc,
                            c.descripcion AS sucursal,
                            a.folio,
                            e.nombre_comp as usuarioCapturo,
                            DATE(a.fecha_creacion) as fechaCreacion,
                            a.descripcion descripcionGeneral,
                            a.total importeTotal,
                            IF(a.tipo=0,'ACTIVOS FIJOS',IF(a.tipo=1,'GASTOS',IF(a.tipo=2,'MANTENIMIENTO', IF(a.tipo = 3,'STOCK', 'ORDEN DE SERVICIO'))))AS tipo,
                            IF(a.presupuesto_aprobado=0,'Pendiente',IF(a.presupuesto_aprobado=1,'Autorizada','Rechazada')) AS estatus
                        FROM requisiciones a
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                        LEFT JOIN cat_autorizaciones d ON d.id_usuario = $idUsuario AND d.activo=1
                        INNER JOIN usuarios e ON e.id_usuario = a.id_capturo
                        WHERE $condicionSucursal AND a.presupuesto_aprobado=0
                        AND a.estatus<=2 AND (a.id_orden_compra='' OR ISNULL(a.id_orden_compra) OR a.id_orden_compra=0)";        

            // echo $query;
            // exit();

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($resultado){

            $registro = mysqli_fetch_array($resultado);
            $columnas = sizeof($registro)/2;
            $campos = array_keys($registro);

            $saldo_inicial = 0;
            if($modulo == 'REPORTES_CCH')
            {
                $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
                $fechaInicio = $arreglo['fechaInicio'];
                $fechaFin = $arreglo['fechaFin'];
                $idSucursal = $arreglo['idSucursal'];

                $query1="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_inicial
                    FROM caja_chica
                    WHERE id_sucursal=$idSucursal AND fecha<='$fechaInicio'
                    GROUP BY id_sucursal";
                $result1 = mysqli_query($this->link, $query1) or die(mysqli_error());

                $datosR=mysqli_fetch_array($result1);
                if($datosR['saldo_inicial'] != '')
                    $saldo_inicial = $datosR['saldo_inicial'];
        
            }

            if($modulo == 'REPORTE_VG')
            {
                $arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
                $fechaInicio = $arreglo['fechaInicio'];
                $fechaFin = $arreglo['fechaFin'];
                $idSucursal = $arreglo['idSucursal'];

                // AND fecha<='$fechaInicio'
                $query1="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_inicial
                    FROM vales_gasolina
                    WHERE id_sucursal=$idSucursal AND fecha <= DATE_ADD('$fechaInicio', INTERVAL -1 DAY)
                    GROUP BY id_sucursal";
                $result1 = mysqli_query($this->link, $query1) or die(mysqli_error());

                $datosR=mysqli_fetch_array($result1);
                if($datosR['saldo_inicial'] != '')
                    $saldo_inicial = $datosR['saldo_inicial'];

            }

            $html.="<h4>&nbsp;&nbsp;&nbsp;&nbsp;".$nombre." ".$fecha."</h4>";
            
            if($modulo == 'REPORTES_CCH')
                $html.="<table><tr><td colspan='10' align='right'><h4>Saldo Inicial: ".$this -> dos_decimales($saldo_inicial)."</h4></td></tr><table>";

            if($modulo == 'REPORTE_VG')
                $html.="<table><tr><td colspan='11' align='right'><h4>Saldo Inicial: ".$this -> dos_decimales($saldo_inicial)."</h4></td></tr><table>";
            
            //-->NJES December/15/2020 mostrar razón social en el tercer nivel
            if($modulo=='SALDOS_CLIENTES'){
                $arreglo = json_decode($datos, true); 
    
                $razon_social = $arreglo['razon_social'];
                $tipo = $arreglo['tipo'];

                if($tipo == 3)
                   $html.="<table><tr><td colspan='12' style='text-align:center; font-size:17px; padding:6px; background-color : #D4EDDA; padding:2px; font-weight: bold;'>".$razon_social."</td></tr></table>"; 
            } 

            $html.="<table border='1'><thead><tr>";
            $cont=0;
            foreach($campos as $campo)
            {
                if(is_string($campo))
                {
                    $campos2[$cont] = $campo;
                
                    //-->NJES November/20/2020 si es diferente de esos modulos o si es igual pero diferente de esos campos crea los td
                    if($modulo == 'REPORTES_CCH' || $modulo == 'REPORTE_VG')
                    {
                        if($campo != 'CLAVE_CONCEPTO' && $campo != 'IMPORTE_VALOR')
                            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>".$campo."</td>";
                    
                    }else
                        $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>".$campo."</td>";

                    $cont++;
                }
            }
            $html.="</tr></thead><tbody>";
            $resultado = mysqli_query( $this->link, $query);
            
            
            $saldo=0;  
            while($registro = mysqli_fetch_array($resultado))
            {
                $html.="<tr class='renglon'>";

                if($modulo == 'ESTADO_DE_CUENTA_CXP')
                {
                    $cargos=$registro['CARGOS'];
                    $abonos=$registro['ABONOS'];
                    $saldo = $saldo + $cargos -$abonos;

                }

                if($modulo == 'REPORTES_CCH' || $modulo == 'REPORTE_VG')
                {
                    if($registro['CLAVE_CONCEPTO'] == 'C01' || $registro['CLAVE_CONCEPTO'] == 'D01')
                        $saldo_inicial +=  (float)$registro['IMPORTE_VALOR'];
                    else
                        $saldo_inicial +=  (float)$registro['IMPORTE_VALOR'] * -1;
                }

                foreach($campos2 as $field)
                {
                    
                    $texto = $registro[$field];

                    if($modulo == 'ESTADO_DE_CUENTA_CXP')
                    {
                        if($field=='SALDO'){
                            $html.="<td valign='top'>".$saldo."</td>";
                        }else{
                            $html.="<td valign='top'>".$texto."</td>";
                        }

                    }else if($modulo == 'REPORTES_CCH' || $modulo == 'REPORTE_VG')
                    {
                        if($field=='SALDO'){
                            $html.="<td valign='top'>".$this -> dos_decimales($saldo_inicial)."</td>";
                        }else{
                            if($field != 'CLAVE_CONCEPTO' && $field != 'IMPORTE_VALOR' && $field != 'SALDO')
                                $html.="<td valign='top'>".$texto."</td>";
                        } 
                    }else
                    {

                        if(strstr($field, 'CLABE' ) || strstr($field, 'IMEI_GPS' ))
                            $html.="<td valign='top'>" . $texto . '&nbsp;' . "</td>";                            
                        else
                            $html.="<td valign='top'>" . $texto  . "</td>";

                    }
                            
                }

                $html.="</tr>";
            }
            if($modulo == 'REPORTES_CCH')
            {

                $saldoF = 0;

                $arregloSF = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
                $fechaFinSF = $arregloSF['fechaFin'];
                $idSucursalSF = $arregloSF['idSucursal'];

                $querySF="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_final
                    FROM caja_chica
                    WHERE id_sucursal=$idSucursalSF AND fecha<='$fechaFinSF'
                    GROUP BY id_sucursal";
                $resultSF = mysqli_query($this->link, $querySF) or die(mysqli_error());

                $datosSF = mysqli_fetch_array($resultSF);
                if($datosSF['saldo_final'] != '')
                    $saldoF = $datosSF['saldo_final'];

                $html.="<tr><td colspan='9' align='right'>Saldo Final</td><td>".$this -> dos_decimales($saldoF)."</td></tr>"; 

            }
            
            if($modulo == 'REPORTE_VG')
            {

                $saldoF = 0;

                $arregloSF = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar
            
                $fechaFinSF = $arregloSF['fechaFin'];
                $idSucursalSF = $arregloSF['idSucursal'];

                $querySF = "SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_final
                    FROM vales_gasolina
                    WHERE id_sucursal=$idSucursalSF AND fecha<='$fechaFinSF'
                    GROUP BY id_sucursal";
                
                $resultSF = mysqli_query($this->link, $querySF) or die(mysqli_error());

                $datosSF = mysqli_fetch_array($resultSF);
                if($datosSF['saldo_final'] != '')
                    $saldoF = $datosSF['saldo_final'];
                    
                $html.="<tr><td colspan='10' align='right'>Saldo Final</td><td>".$this -> dos_decimales($saldoF)."</td></tr>"; 

            }
            

            $html.="</tbody></table>";
            
        }else{
            $html.="Error, en el Query";
        }

        return $html;
    }//-- fin function generaExcel

    function dos_decimales($number, $fractional=true) { 
        if ($fractional) { 
            $number = sprintf('%.2f', $number); 
        } 
        while (true) { 
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
            if ($replaced != $number) { 
                $number = $replaced; 
            } else { 
                break; 
            } 
        } 
        return $number; 
    }
    
}//--fin de class Excel
    
?>