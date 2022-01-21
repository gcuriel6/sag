<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];
$conceptoAlmacen = $arreglo['concepto'];

// Informacion de la empresa 
$query = "SELECT a.id,
a.folio,
a.folio_venta_stock AS folio_venta,
a.cve_concepto,
a.id_unidad_negocio,
d.nombre AS unidad,
d.logo,
d.clave AS clave_unidad,
a.id_sucursal,
e.descr AS sucursal,
DATE(a.fecha) AS fecha,
a.observacion,
k.nombre_comp AS usuario_captura,
k.usuario,
a.iva,
-- IF(a.iva=0,SUM(l.precio_venta*l.cantidad),(SUM(l.precio_venta*l.cantidad)+(SUM(l.precio_venta*l.cantidad)*(a.iva/100)))) AS total,
SUM(l.precio_venta*l.cantidad) AS subtotal,
-- (SUM(l.precio_venta*l.cantidad)*(a.iva/100)) AS total_iva
SUM(l.cantidad*l.descuento_unitario) AS descuento_total,
SUM((l.precio_venta*l.cantidad)*(l.iva/100)) as total_iva,
SUM(l.precio_venta*l.cantidad)+SUM((l.precio_venta*l.cantidad)*(l.iva/100)) AS total
FROM almacen_e a
LEFT JOIN almacen_d l ON a.id=l.id_almacen_e
LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
LEFT JOIN sucursales g ON a.id_sucursal_destino=g.id_sucursal
LEFT JOIN usuarios k ON a.id_usuario_captura= k.id_usuario
WHERE a.id=".$idRegistro;

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$fecha = $row['fecha'];
$logo = $row['logo'];
$folio = $row['folio'];
$unidad = $row['unidad'];
$claveUnidad = $row['clave_unidad'];
$sucursal = $row['sucursal'];
$observacion = $row['observacion'];
$usuarioCaptura = $row['usuario_captura'];
$usuario = $row['usuario']; 
$folioVenta = $row['folio_venta'];    
$subtotal = $row['subtotal']; 
$totalIva = $row['total_iva']; 
$total = $row['total'];  
$descuento_total = $row['descuento_total']; 
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
	font-size:12px;
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
        <td width="200" align="top"><?php echo '<img src="../imagenes/'.$row['logo'].'"  width="200"/>';?></td>
        <td width="400" class="datos" align="center" ><strong>VENTA</strong> <br>
            Unidad de Negocio: <?php echo $unidad; ?><br> 
            Sucursal: <?php echo $sucursal;?><br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $claveUnidad.'-'.$folioVenta;?></td>
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
    <tr>
        <td><strong>Concepto: </strong></td><td>VENTA</td>
    </tr>
    <tr>
        <td><strong>Generado Por: </strong></td><td><?php echo $usuarioCaptura;?></td>
    </tr>
    <tr>
        <td><strong>Observaciones: </strong></td><td><?php echo normaliza($observacion,120);?></td>
    </tr>
</table>

<!---- Productos---->
<?php  
  
    $queryE="SELECT a.id_producto,
                a.precio_venta as precio,
                a.cantidad,
                a.talla,
                a.marca,
                b.concepto,
                b.descripcion,
                c.descripcion AS familia,
                c.id AS id_familia, 
                d.descripcion AS linea,
                d.id AS id_linea,
                (a.precio_venta * a.cantidad) AS importe,
                a.descuento_unitario,
                a.iva
                FROM almacen_d a
                LEFT JOIN productos b ON a.id_producto=b.id
                LEFT JOIN familias c ON b.id_familia = c.id
                LEFT JOIN lineas d ON b.id_linea = d.id
                WHERE a.id_almacen_e=".$idRegistro."
                ORDER BY a.id";
    $consultaE = mysqli_query($link,$queryE);
    $numeroFilasE = mysqli_num_rows($consultaE); 
    if($numeroFilasE>0){    
?>
<h4>Productos </h4>
<table class="borde_tabla" width="720">
    <thead>
        <tr class="encabezado">
            <td width='58' align="center">Catálogo </td>
            <td width='90' align="center">Familia</td>
            <td width='90' align="center">Línea</td>
            <td width='95' align="center">Concepto</td>
            <td width='90' align="center">Marca</td>
            <td width='40' align="center">Cant</td>
            <td width='78' align="center">Precio Unitario</td>
            <td width='60' align="center">Descuento Unitario</td>
            <td width='40' align="center">Iva</td>
            <td width='78' align="center">Importe</td>
        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidad=0;
    $tPrecio=0;
    $tPrecioTotal=0;
    while ($rowE = mysqli_fetch_array($consultaE)){
       $tCantidad = $tCantidad + $rowE['cantidad'];
       $tPrecio = $tPrecio + $rowE['precio'];
       $tPrecioTotal = $tPrecioTotal + $rowE['importe'];
      
        echo   "<tr>
                    <td width='58'>".$rowE['id_producto']."</td>
                    <td width='90'>".$rowE['familia']."</td> 
                    <td width='90'>".$rowE['linea']."</td> 
                    <td width='95'>".$rowE['concepto']."</td> 
                    <td width='90'>".$rowE['marca']."</td> 
                    <td width='40' align='right'>".$rowE['cantidad']."</td> 
                    <td width='78' align='right'> ".dos_decimales($rowE['precio'])."</td>
                    <td width='60' align='right'> ".dos_decimales($rowE['descuento_unitario'])."</td>
                    <td width='40' align='right'> ".dos_decimales($rowE['iva'])."</td>
                    <td width='78' align='right'> ".dos_decimales($rowE['importe'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
</table>
<br>
<table>
    <tr>
        <td width='550'> </td>
        <td class='verde' align="right" width='100'>DESCUENTO </td>
        <td width='110' align="right"><?php echo dos_decimales($descuento_total);?></td>
    </tr>
    <tr>
        <td width='550'> </td>
        <td class='verde' align="right" width='100'>SUBTOTAL </td>
        <td width='110' align="right"><?php echo dos_decimales($subtotal);?></td>
    </tr>
    <tr>
        <td width='550'> </td>
        <td class='verde' align="right" width='100'>IVA </td>
        <td width='110' align="right"><?php echo dos_decimales($totalIva);?></td>
    </tr>
    <tr>
        <td width='550'> </td>
        <td class='verde' align="right" width='100'>TOTAL </td>
        <td width='110' align="right"><?php echo dos_decimales($total);?></td>
    </tr>
</table>
<?php }?>

<br><br>

<!--<table width="710">
    <tr>
        <td width="710"  align="center">______________________________________</td>
    </tr>
    <tr>
        <td width="710" align="center"><?php echo $usuarioCaptura;?></td>
    </tr>
</table>-->
<page_footer style="text-align:right;font-size:10px;">
    [[page_cu]] de [[page_nb]]
</page_footer>

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
    return '$ '.$number; 
}
function normaliza($texto,$longitud)
{
    $ntexto='';
    $aux = str_split($texto,$longitud);
    $cont=0;
    while($cont < sizeof($aux))
    {
        $ntexto.=$aux[$cont]."<br>";
        $cont++;
    }
    return $ntexto;
}
?>
