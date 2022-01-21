<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datos=$_REQUEST['datos'];

$arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idOrden = $arreglo['idRegistro'];

// Informacion de la empresa 
$query = "SELECT a.id,
a.folio,
a.id_unidad_negocio,
a.id_sucursal,
DATE(a.fecha_captura) AS fecha,
a.observaciones_entrega AS observacion,
a.id_proveedor,
a.id_departamento,
a.fecha_pedido,
a.tiempo_entrega,
a.fecha_entrega,
a.condiciones_pago,
b.nombre AS proveedor,
c.razon_social AS a_facturar,
d.nombre AS unidad,
d.logo,
e.descr AS sucursal,
CONCAT(e.calle, ' #',e.no_exterior,IF(e.no_interior!='',CONCAT(' No.Int: ',e.no_interior),'')) AS direccion,
e.colonia,
e.codigopostal,
f.municipio,
g.estado,
h.des_dep AS departamento,
IFNULL(i.descripcion,'') AS nom_area
FROM orden_compra a
LEFT JOIN proveedores b ON a.id_proveedor=b.id
LEFT JOIN empresas_fiscales c ON a.id_empresa_fiscal = c.id_empresa
LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
LEFT JOIN municipios f ON e.id_municipio = f.id
LEFT JOIN estados g ON e.id_estado=g.id
LEFT JOIN deptos h ON a.id_departamento=h.id_depto
LEFT JOIN cat_areas i ON h.id_area=i.id
WHERE a.id=".$idRegistro;

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$fecha = $row['fecha'];
$logo = $row['logo'];
$folio = $row['folio'];

$unidad = $row['unidad'];
$sucursal = $row['sucursal'];
$direccion = $row['direccion'];
$colonia = $row['colonia'];
$codigopostal= $row['codigopostal'];
$municipio = $row['municipio'];
$estado = $row['estado'];
$observacion = $row['observacion'];

$fecha_pedido = $row['fecha_pedido'];
$fecha_entrega = $row['fecha_entrega'];
$tiempo_entrega = $row['tiempo_entrega'];
$condiciones_pago = $row['condiciones_pago'];

$idProveedor = $row['id_proveedor'];
$proveedor = $row['proveedor'];
$idDepartamento = $row['id_departamento'];
$departamento = $row['departamento'];
$nom_area = $row['nom_area'];
      
?>
<style>
table td{
    font-size:13px;
	font-weight:100;	
}
.borde_tabla td{
	padding-left:0px;
    padding-right:0px;
    padding-top: 0px;
    padding-bottom: 0px;
	border: 1px solid #FCFBF9;
	font-size:13px;
	text-transform: capitalize;
    vertical-align:top;
	
}
.verde,.encabezado{
	background:#F2F0FB;
	color:#333333;
	font-size:13px;
	font-weight:200;
  text-transform: capitalize;
}
.dato{
	font-size:13px;
	text-transform: capitalize;
}

</style>
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="3mm"  backbottom="5mm">

<table width="710" border="0">
    <tr>
        <td width="200" align="top"><?php echo '<img src="../imagenes/'.$row['logo'].'"  width="150"/>';?></td>
        <td width="400" class="datos" align="center" ><strong>ORDEN DE COMPRA</strong> <br>
            <?php echo $sucursal;?><br>
            <?php echo $direccion;?><br>
            <?php echo 'Col: '.$colonia.' C.P.: '.$codigopostal;?><br>
            <?php echo $municipio.', '.$estado.'.';?>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $folio;?></td>
                </tr>
                <tr>
                    <td class="verde">Fecha</td>
                    <td class="dato"><?php echo $fecha ?></td>
                </tr>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table class="borde_tabla" width="100%">

    <?php //si tiene Proveedor se agrega
    if($idProveedor != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Proveedor: </strong><?php echo $proveedor;?></td>
    </tr>
    <?php
    }
    ?>

    <?php //si tiene empleado se agrega
    if($idTrabajador != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Empleado: </strong><?php echo $empleado;?></td>
    </tr>
    <?php
    }
    ?>

    <?php //si tiene clasificacion se agrega
    if($idClasificacion != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Clasificacion a Presupuesto: </strong><?php echo $clasificacion;?></td>
    </tr>
    <?php
    }
    ?>

    <?php //si tiene departamento se agrega
    if($idDepartamento != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Departamento: </strong><?php echo $departamento;?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Área: </strong><?php echo $nom_area;?></td>
    </tr>
    <?php
    }
    ?>

</table>
<table class='borde_tabla' width='710'>
    <tr>
        <td class="verde" width="177" align='center'>Fecha Pedido</td>
        <td class="verde" width="177" align='center'>Tiempo Entrega</td>
        <td class="verde" width="177" align='center'>Fecha Entrega</td>
        <td class="verde" width="177" align='center'>Forma Pago</td>
    
    </tr>
    <tr>
        <td class="dato" align='center'><?php echo $fecha_pedido ?></td>
        <td class="dato" align='center'><?php echo $tiempo_entrega ?> Dias</td>
        <td class="dato" align='center'><?php echo $fecha_entrega ?></td>
        <td class="dato" align='center'><?php echo $condiciones_pago ?> Dias</td>
    </tr>
</table>



<!---- Productos---->
<?php  
  
    $queryE="SELECT a.id_producto,
    a.costo_unitario,
    a.cantidad,
    a.iva,
    a.porcentaje_descuento AS descuento,
    a.tallas AS lleva_tallas,
    b.concepto,
    b.descripcion,
    c.descripcion AS familia,
    c.id AS id_familia, 
    d.descripcion AS linea,
    d.id AS id_linea,
    (a.costo_unitario * a.cantidad) AS importe,
    IFNULL(IF(a.tallas=1,(SELECT GROUP_CONCAT('<br> - ', cantidad ,' ', talla) FROM tallas WHERE tipo=2 AND id_detalle=a.id),''),'') AS tallas
    FROM orden_compra_d a
    LEFT JOIN productos b ON a.id_producto=b.id
    LEFT JOIN familias c ON b.id_familia = c.id
    LEFT JOIN lineas d ON b.id_linea = d.id
    WHERE a.id_orden_compra=".$idRegistro."
    ORDER BY a.id";
    $consultaE = mysqli_query($link,$queryE);
    $numeroFilasE = mysqli_num_rows($consultaE); 
    if($numeroFilasE>0){    
?>
<h4>Productos </h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='60' align="center">Catálogo </td>
            <td width='180' align="center">Concepto</td>
            <td width='100' align="center">Tallas</td>
            <td width='50' align="center">Cantidad</td>
            <td width='80' align="center">Costo Unitario</td>
            <td width='50' align="center">IVA%</td>
            <td width='50' align="center">Des%</td>
            <td width='120' align="center">Importe</td>
        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidad=0;
    $tPrecio=0;
    $tPrecioTotal=0;
    $subtotal=0;
    $totalIva=0;
    while ($rowE = mysqli_fetch_array($consultaE)){
       $tCantidad = $tCantidad + $rowE['cantidad'];
       $tPrecio = $tPrecio + $rowE['costo_unitario'];
       
       if($rowE['descuento'] > 0){
                    
            $subtotalP=$rowE['cantidad']*parseFloat(costo);
            $descuentoTotal=(($rowE['descuento']*$subtotalP)/100);
            
            $subtotal=$subtotal+($subtotalP-$descuentoTotal);
            $totalIva=$totalIva+((($rowE['cantidad']*$rowE['costo_unitario'])-$descuentoTotal)*($rowE['iva']/100));

        }else{

            $subtotal=$subtotal+($rowE['cantidad']*$rowE['costo_unitario']);
            $totalIva=$totalIva+(($rowE['cantidad']*$rowE['costo_unitario'])*($rowE['iva']/100));
        }
        echo   "<tr>
                    <td>".$rowE['id_producto']."</td>
                    <td>".$rowE['concepto']."</td> 
                    <td>".$rowE['tallas']."</td> 
                    <td align='right'>".$rowE['cantidad']."</td> 
                    <td align='right'>".dos_decimales($rowE['costo_unitario'])."</td>
                    <td align='right'>".$rowE['iva']."</td> 
                    <td align='right'>".$rowE['descuento']."</td> 
                    <td align='right'>".dos_decimales($rowE['importe'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" rowspan="3"><strong> Observaciones: </strong><?php echo $observacion;?></td>
            <td class="verde" colspan="2">SubTotal </td>
            <td class="dato"  align="right"><?php echo dos_decimales($subtotal)?></td>    
        </tr>
        <tr>
            
            <td class="verde" colspan="2">Iva </td>
            <td class="dato"  align="right"><?php echo dos_decimales($totalIva)?></td>    
        </tr>
        <tr>
            
            <td class="verde" colspan="2">Total </td>
            <td class="dato" align="right"><?php echo dos_decimales($subtotal+$totalIva)?></td>    
        </tr>
    </tfoot>
</table>
<?php }?>

<!--</page_footer>-->
</page>
          
<?php 

function fecha($fecha) {
    list($anyo, $mes, $dia) = explode("-", $fecha);
    $fechamod = $dia . "/" . $mes . "/" . $anyo;
    return $fechamod;
}
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
?>
