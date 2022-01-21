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

            $query="SELECT a.id as ID,a.costo AS COSTO,IF(a.activo=1,'Activo','Inactivo') AS ESTATUS,b.nombre AS UNIDAD_NEGOCIO, c.descripcion AS SUCURSAL
                        FROM cat_costos_administrativos a 
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                        ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo == 'SUCURSALES'){

            $query="SELECT a.id_sucursal AS ID,a.clave AS CLAVE,a.descripcion AS NOMBRE,a.descr AS DESCRIPCIÓN,a.calle AS CALLE,a.no_exterior AS NUM_EXTERIOR,a.no_interior AS NUM_INTERIOR,a.colonia AS COLONIA,
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
            $query="SELECT a.id AS ID,a.utilidad AS PORCENTAJE_UTILIDAD,IF(a.activo=1,'Activo','Inactivo') AS ESTATUS,b.nombre AS UNIDAD_NEGOCIO, c.descripcion AS SUCURSAL
                        FROM cat_porcentaje_utilidad a 
                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                        ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo == 'FIRMANTES'){
            $query="SELECT id AS ID,nombre AS NOMBRE,telefono AS TELEFONO, email AS EMAIL, iniciales AS INICIALES,IF(firma='','No','Si') AS FIRMA,IF(activo=1,'Activo','Inactivo') AS ESTATUS
                        FROM cat_firmantes 
                        ORDER BY id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo=='USUARIOS'){

            $query="SELECT id_usuario AS ID,usuario AS USUARIO,nombre_comp AS NOMBRE_COMPLETO,id_empleado AS ID_EMPLEADO,id_supervisor AS ID_SUPERVISOR,IF(activo=1,'ACTIVO','INACTIVO') AS ESTATUS FROM usuarios ORDER BY id_usuario";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='AREAS'){

            $query="SELECT id AS ID,clave AS CLAVE,descripcion AS DESCRIPCIÓN,IF(activa=1,'ACTIVA','INACTIVA') AS ESTATUS FROM cat_areas ORDER BY clave";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='UNIFORMES'){

            $query="SELECT id AS ID, clave AS CLAVE, nombre as NOMBRE, descripcion AS DESCRIPCIÓN, costo AS COSTO, IF(activo=1,'ACTIVO','INACTIVO') AS ESTATUS FROM cat_uniformes ORDER BY clave";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='SALARIOS'){

            $query="SELECT a.id AS ID,a.id_unidad_negocio AS ID_UNIDAD_NEGOCIO, b.nombre AS UNIDAD_NEGOCIO, a.id_puesto AS ID_PUESTO,c.puesto AS PUESTO, a.salario_diario AS SALARIO_DIARIO, salario_diario_integrado AS SALARIO_DIARIO_INTEGRADO, sueldo_mensual AS SUELDO_MENSUAL, cuota_imss AS CUOTA_IMSS, cuota_infonavit AS CUOTA_INFONAVIT, porcentaje_dispersion AS PORCENTAJE_DISPERSION, IF(a.inactivo=0,'Activo','Inactivo')AS ESTATUS
FROM cat_salarios a
LEFT JOIN  cat_unidades_negocio b ON a.id_unidad_negocio=b.id
LEFT JOIN cat_puestos c ON a.id_puesto=c.id_puesto
ORDER BY id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='UNIDADES_NEGOCIO'){

            $query="SELECT id AS ID,clave AS CLAVE,nombre AS NOMBRE, IF(inactivo=0,'Activo','Inactivo')AS ESTATUS
FROM cat_unidades_negocio 
ORDER BY clave";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }
        if($modulo=='PLANTILLAS_COTIZACIONES'){

            $query="SELECT a.id,IF(a.elementos=0,'NO','SI') AS ELEMENTOS,IF(a.equipo=0,'NO','SI') AS EQUIPO,IF(a.servicios=0,'NO','SI') AS SERVICIOS,IF(a.vehiculos=0,'NO','SI') AS VEICULOS,tesoreria AS TESORERIA,recursos_humanos AS RECURSOS_HUMANOS,operaciones AS OPERACIONES,compras AS COMPRAS,activos_fijos AS ACTIVOS_FIJOS,a.id_unidad_negocio AS ID_UNIDAD_NEGOCIO,b.nombre AS UNIDAD_NEGOCIO,IF(a.activo=1,'ACTIVO','INACTIVO') AS ESTATUS
FROM cat_plantillas_cotizacion a
LEFT JOIN cat_unidades_negocio  b ON a.id_unidad_negocio=b.id
ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='ASIGNACION_AUTORIZACIONES'){

            $query="SELECT a.id AS ID, b.nombre_comp AS USUARIO, FORMAT(a.monto_minimo,2) AS MONTO_MINIMO, FORMAT(a.monto_maximo,2) AS MONTO_MAXIMO, IF(a.activo=1,'ACTIVO','INACTIVO') AS ESTATUS  FROM cat_autorizaciones a LEFT JOIN usuarios b ON a.id_usuario=b.id_usuario  ORDER BY b.nombre_comp";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            

        }

        if($modulo=='LINEAS'){

            $query="SELECT id AS ID,clave AS CLAVE,descripcion AS DESCRIPCIÓN,IF(inactiva=0,'ACTIVA','INACTIVA') AS ESTATUS FROM lineas ORDER BY id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='FAMILIAS')
        {
            
            $query="SELECT a.id AS ID,a.clave AS CLAVE,a.descripcion AS DESCRIPCIÓN,IF(a.tipo=0,'Gasto',IF(a.tipo=1,'Stock',IF(a.tipo=2,'Mantenimiento',IF(a.tipo=3,'Activo Fijo',''))))AS TIPO,
                    IF(a.tallas=0,'No','Si') AS USA_TALLAS,if(a.inactiva=0,'Activa','Inactiva')as ESTATUS,IFNULL(b.descr,'') AS FAMILIA_GASTO
                    FROM familias a
                    LEFT JOIN fam_gastos b ON a.id_familia_gasto=b.id_fam 
                    ORDER BY a.id";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo=='PRODUCTOS'){

            $query="SELECT
                        productos.id AS ID,
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
            a.id AS ID,
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
            deptos.id_depto AS ID, 
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

        if($modulo == 'REPORTES_REQUISICIONES')
        {
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
                $condicion=" AND a.fecha_pedido >= '$fechaInicio' AND a.fecha_pedido <= '$fechaFin' ";
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
                        FORMAT(IFNULL(l.porcentaje_descuento,0),2) AS PORCENTAJE_DCTO,
                        FORMAT(((g.total/100)*g.iva),2) AS PORCENTAJE_IVA,
                        FORMAT(g.total,2) AS IMPORTE_SIN_IVA,
                        FORMAT((((g.total/100)*g.iva)+g.total),2) AS IMPORTE_CON_IVA,
                        IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'No autorizada',
                        IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar','Pagada'))))) AS ESTATUS,
                        IFNULL(k.folio,'') AS FOLIO_RECEPCIÓN_MERCANCIA,
                        CASE
                            WHEN a.tipo = 0 THEN 'Activo Fijo'
                            WHEN a.tipo = 1 THEN 'Gasto'
                            WHEN a.tipo = 2 THEN 'Mantenimiento'
                            ELSE 'Stock'
                        END AS TIPO,
                        IF(IFNULL(n.id_entrada_compra,0)>0,'SI','NO') AS EN_PORTAL
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
                        ORDER BY a.fecha_pedido";
            }else if($nombre == 'Requisiciones Agrupadas')
            {
                $query="SELECT a.id AS ID,
                        a.folio AS FOLIO,
                        b.nombre AS UNIDAD,
                        c.descripcion AS SUCURSAL,
                        d.descripcion AS AREA,
                        e.des_dep AS DEPTO,
                        IFNULL(a.folio_orden_compra,'') AS FOLIO_ORDEN_COMPRA,
                        a.fecha_pedido AS FECHA,
                        IFNULL(a.solicito,'') AS SOLICITO,
                        f.nombre AS PROVEEDOR,
                        a.descripcion AS DESCRIPCIÓN,
                        FORMAT(a.subtotal,2) AS IMPORTE_SIN_IVA,
                        FORMAT(a.total,2) AS IMPORTE_CON_IVA,
                        IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'No autorizada',
                        IF(a.estatus=4,'Orden de compra',IF(a.estatus=5,'Por Pagar','Pagada'))))) AS ESTATUS,
                        IFNULL(k.folio,'') AS FOLIO_RECEPCIÓN_MERCANCIA,
                        CASE
                            WHEN a.tipo = 0 THEN 'Activo Fijo'
                            WHEN a.tipo = 1 THEN 'Gasto'
                            WHEN a.tipo = 2 THEN 'Mantenimiento'
                            ELSE 'Stock'
                        END AS TIPO,
                        IF(IFNULL(n.id_entrada_compra,0)>0,'SI','NO') AS EN_PORTAL,
                        IF(a.b_anticipo=1 && o.estatus!='L' && IFNULL(n.id_entrada_compra,0)=0,'Pendiente de Pago',
                        IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)=0,'Pagado',
                        IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus!='L','Pendiente de Pago',
                        IF(a.b_anticipo=1 && o.estatus!='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus='L','Pendiente de Pago',
                        IF(a.b_anticipo=1 && o.estatus='L' && IFNULL(n.id_entrada_compra,0)>0 && n.estatus='L','Pagado','No portal de proveedores'))))) AS ESTATUS_CXP
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
                        LEFT JOIN cxp o ON a.id=o.id_requisicion
                        WHERE a.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                        ORDER BY a.fecha_pedido";
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

        if($modulo == 'REPORTES_ORDEN_COMPRAS')
        {
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
                        IF(orden_compra.estatus='A','Activa',IF(orden_compra.estatus='I','Impresa',IF(orden_compra.estatus='C','Cancelada','Liquidada'))) AS ESTATUS
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
                        FORMAT(SUM((((orden_compra_d.costo_total/100)*orden_compra_d.iva)+orden_compra_d.costo_total)),2) AS IMPORTE_CON_IVA
                        FROM orden_compra 
                        LEFT JOIN orden_compra_d ON orden_compra.id=orden_compra_d.id_orden_compra
                        LEFT JOIN cat_unidades_negocio ON orden_compra.id_unidad_negocio = cat_unidades_negocio.id
                        LEFT JOIN sucursales ON orden_compra.id_sucursal = sucursales.id_sucursal
                        LEFT JOIN cat_areas ON orden_compra.id_area = cat_areas.id
                        LEFT JOIN deptos ON orden_compra.id_departamento = deptos.id_depto
                        LEFT JOIN proveedores ON orden_compra.id_proveedor = proveedores.id
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
                        FORMAT((((((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario))/100)*orden_compra_d.iva)+((orden_compra_d.cantidad - orden_compra_d.cantidad_entrega)*(orden_compra_d.costo_unitario))),2) AS IMPORTE_CON_IVA
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
                        WHERE orden_compra.id_unidad_negocio=".$idUnidadNegocio." $sucursal $area $departamento $proveedor $condicion
                        HAVING cantidad > 0
                        ORDER BY orden_compra.fecha_pedido";
            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());
        }

        if($modulo=='CLIENTES'){
            $query="SELECT 
            cat_clientes.id AS CVE_CLIENTE,
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

        if($modulo == 'INVENTARIO')
        {

            $arreglo = json_decode($datos, true);
            $idSucursal = $arreglo['id_sucursal'];

            $and = ' ';

            if($arreglo['id_producto'] != '')
                $and .= " AND productos.id LIKE '%" . $arreglo['id_producto'] . "%'";

            if($arreglo['familia'] != '')
                $and .= " AND familias.descripcion LIKE '%" . $arreglo['familia'] . "%'";

            if($arreglo['linea'] != '')
                $and .= " AND lineas.descripcion LIKE '%" . $arreglo['linea'] . "%'";

            if($arreglo['linea'] != '')
                $and .= " AND productos.concepto LIKE '%" . $arreglo['concepto'] . "%'";


            $query = " SELECT
              productos.id AS CATALOGO,
              productos.concepto AS CONCEPTO,
              productos.descripcion AS DESCRIPCIÓN,
              familias.descripcion AS FAMILIA,
              lineas.descripcion AS LINEA,
              almacen_d.precio as PRECIO,
              SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', almacen_d.cantidad, almacen_d.cantidad*-1)) AS EXISTENCIA 
              FROM productos
              INNER JOIN familias ON productos.id_familia = familias.id
              INNER JOIN lineas ON productos.id_linea = lineas.id
              INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
              INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
              WHERE almacen_e.id_sucursal = $idSucursal
              $and
              GROUP BY productos.id";
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
                almacen_e.id AS no_movimiento,
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
                WHERE almacen_e.id_sucursal = $idSucursal
                AND productos.id = $idProducto
                $and";

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
            $andFN .= " AND almacen_e.fecha >= '$fechaDe'";
            $andFD .= " AND DATE(almacen_e.fecha) ='$fechaDe'";
            }
            else
            $having .= " HAVING almacen_e.fecha =  MIN(DATE(almacen_e.fecha))"; 

            if($fechaA != '')
            $andFN .= " AND almacen_e.fecha <= '$fechaA'";



            $query = "SELECT
            productos.id AS id_producto,
            familias.descripcion AS familia,
            lineas.descripcion AS linea,
            productos.concepto AS concepto,

            IF(existencias_iniciales.existencia_i IS NULL, 0 , existencias_iniciales.existencia_i) AS existencia_inicial,
            IF(entradas.cantidad_entradas IS NULL, 0, entradas.cantidad_entradas) AS entradas,
            IF(salidas.cantidad_salidas IS NULL, 0, salidas.cantidad_salidas) AS salidas,
            existencias_finales.existencia_f AS existencia_final,

            productos_unidades.ultimo_precio_compra AS ultimo_precio,
            productos_unidades.ultima_fecha_compra AS ultima_fecha
            FROM productos
            INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
            INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
            INNER JOIN familias ON productos.id_familia = familias.id
            INNER JOIN lineas ON productos.id_linea = lineas.id
            INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto AND productos_unidades.id_unidades = 3
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
            WHERE almacen_e.id_unidad_negocio = $idUnidad
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
            WHERE SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E' 
            $and
            $andFN
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
            AND almacen_e.id_unidad_negocio = $idUnidad
            $and
            $andFN
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
            WHERE almacen_e.id_unidad_negocio = $idUnidad
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
                productos_unidades.ultimo_precio_compra AS ultimo_precio,
                productos_unidades.ultima_fecha_compra AS ultima_fecha
                FROM productos
                INNER JOIN almacen_d ON productos.id = almacen_d.id_producto
                INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
                INNER JOIN familias ON productos.id_familia = familias.id
                INNER JOIN lineas ON productos.id_linea = lineas.id
                INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto AND productos_unidades.id_unidades = $idUnidad
                LEFT JOIN proveedores ON almacen_e.id_proveedor = proveedores.id
                LEFT JOIN trabajadores ON almacen_e.id_trabajador =  trabajadores.id_trabajador
                WHERE almacen_e.id_unidad_negocio = $idUnidad
                $and
                ORDER BY almacen_e.id ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());

        }

        if($modulo=='FAMILIAS_GASTOS')
        {

            $query="SELECT id_fam AS ID, clave AS CLAVE, descr AS DESCRIPCIÓN,IF(activo=0,'ACTIVA','INACTIVA') AS ESTATUS 
                    FROM fam_gastos 
                    ORDER BY id_fam ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error());            
        }

        if($modulo == 'CLASIFICACION_GASTOS')
        {
            $query="SELECT id_clas AS ID, clave AS CLAVE, descr AS DESCRIPCIÓN,IF(activo=0,'ACTIVA','INACTIVA') AS ESTATUS 
                    FROM gastos_clasificacion 
                    ORDER BY id_clas ASC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }

        if($modulo == 'BANCOS')
        {
            $query="SELECT 
            id AS ID,
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
            cuentas_bancos.id AS ID,
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
            $idCuentaBanco = isset($arreglo['idCuentaBanco']) ? $arreglo['idCuentaBanco'] : 0;
            $fecha_dia = $arreglo['fecha'];
            
            if($nombre == 'Movimientos Bancos')
            {
                $query="SELECT b.cuenta AS CUENTA,c.descripcion AS BANCO,b.descripcion AS DESCRIPCIÓN,a.observaciones AS OBSERVACIONES,
                        IF(a.tipo='T','Transferencia',IF(a.tipo='I','Monto Inicial',IF(a.tipo='C','Cargo','Abono'))) AS TIPO,
                        FORMAT(a.monto,2) AS MONTO,DATE(a.fecha) AS FECHA
                        FROM movimientos_bancos a
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        WHERE DATE(a.fecha)='$fecha_dia'
                        ORDER BY a.id_cuenta_banco,a.fecha";

            }else if($nombre == 'Saldo Cuentas Bancos')
            {
                $query="SELECT a.id_cuenta_banco AS ID_CUENTA_BANCO,b.cuenta AS CUENTA,c.descripcion AS BANCO,b.descripcion AS DESCRIPCIÓN,
                        FORMAT(IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0),2) AS TOTAL
                        FROM movimientos_bancos a
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        WHERE DATE(a.fecha)='$fecha_dia'
                        GROUP BY a.id_cuenta_banco
                        ORDER BY a.fecha";

            }else{  ///es el modulo detalle cuenta

                $query="SELECT b.cuenta AS CUENTA,c.descripcion AS BANCO,b.descripcion AS DESCRIPCIÓN,a.observaciones AS OBSERVACIONES,
                        IF(a.tipo='T','Transferencia',IF(a.tipo='I','Monto Inicial',IF(a.tipo='C','Cargo','Abono'))) AS TIPO,
                        FORMAT(a.monto,2) AS MONTO,DATE(a.fecha) AS FECHA
                        FROM movimientos_bancos a
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        WHERE a.id_cuenta_banco = $idCuentaBanco AND DATE(a.fecha)='$fecha_dia'
                        ORDER BY a.fecha";

            }

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 
        }
        
        if($modulo == 'GASTOS')
        {
            $query="SELECT 
            gastos.id AS ID,
            unidad.nombre AS UNIDAD_NEGOCIO,
            sucursales.descr AS SUCURSAL,
            deptos.des_dep AS DEPARTAMENTO,
            fam_gastos.descr AS FAMILIA_GASTOS,
            gastos_clasificacion.descr AS CLASIFICACION_GASTO,
            gastos.fecha AS FECHA,
            IF(gastos.tipo='F','Factura',IF(gastos.tipo='N','Nota','Recibo'))AS TIPO_GASTO, 
            CONCAT(gastos.tipo,': ',gastos.referencia) AS REFERENCIA,
            proveedores.nombre AS PROVEEDOR,
            gastos.observaciones AS OBSERVACIONES, 
            (gastos.subtotal+gastos.iva) AS TOTAL, 
            bancos.clave AS BANCO,
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
                    $condicion
                    ORDER BY a.id ASC,a.fecha DESC";

            $resultado = mysqli_query($this->link, $query)or die(mysqli_error()); 

        }

        if($resultado){

            $registro = mysqli_fetch_array($resultado);
            $columnas = sizeof($registro)/2;
            $campos = array_keys($registro);
            $html.="<h4>&nbsp;&nbsp;&nbsp;&nbsp;".$nombre." ".$fecha."</h4>";
            $html.="<table border='1'><thead><tr>";
            $cont=0;
            foreach($campos as $campo)
            {
                if(is_string($campo))
                {
                $campos2[$cont] = $campo;
            
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

                    }else{
                        $html.="<td valign='top'>".$texto."</td>";
                    }
                            
                }

                $html.="</tr>";
            }

            $html.="</tbody></table>";
            
        }else{
            $html.="Error, en el Query";
        }

        return $html;
    }//-- fin function generaExcel
    
}//--fin de class Excel
    
?>