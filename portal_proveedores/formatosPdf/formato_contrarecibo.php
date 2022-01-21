<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];

// Informacion de la empresa 
$query = "SELECT a.id,
a.id_cxp AS folio,
a.no_factura,
a.id_unidad_negocio,
a.id_sucursal,
DATE(a.fecha) AS fecha,
a.observaciones AS observacion,
a.id_proveedor,
a.subtotal,
a.descuento,
a.iva,
(a.subtotal+a.iva-a.descuento) AS importe,
b.nombre AS proveedor,
d.nombre AS unidad,
d.logo,
e.descr AS sucursal,
CONCAT(e.calle, ' #',e.no_exterior,IF(e.no_interior!='',CONCAT(' No.Int: ',e.no_interior),'')) AS direccion,
e.colonia,
e.codigopostal,
f.municipio,
g.estado,
h.folio AS folio_entrada,
DATE(h.fecha) AS fecha_entrada,
DATE_FORMAT(h.fecha,'%H:%i:%s')AS hora_entrada,
i.folio AS folio_oc,
IF(WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY))=0,
DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY),
CASE 
WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 6 DAY)
WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 5 DAY)
WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 4 DAY)
WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 3 DAY)
WHEN WEEKDAY(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 2 DAY)
ELSE DATE_ADD(DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY), INTERVAL 1 DAY)
END) AS fecha_vigencia,
i.requisiciones AS folio_requi
FROM cxp a
LEFT JOIN proveedores b ON a.id_proveedor=b.id
LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
LEFT JOIN municipios f ON e.id_municipio = f.id
LEFT JOIN estados g ON e.id_estado=g.id
LEFT JOIN almacen_e h ON a.id_entrada_compra=h.id 
LEFT JOIN orden_compra i ON h.id_oc=i.id
WHERE a.id=".$idRegistro;

//DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)AS fecha_vigencia,

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$fecha = $row['fecha'];
$fecha_entrada = $row['fecha_entrada'];
$hora_entrada = $row['hora_entrada'];
$logo = $row['logo'];
$folio = $row['folio'];

$id= $row['id'];
$descuento= $row['descuento'];

$unidad = $row['unidad'];
$sucursal = $row['sucursal'];
$direccion = $row['direccion'];
$colonia = $row['colonia'];
$codigopostal= $row['codigopostal'];
$municipio = $row['municipio'];
$estado = $row['estado'];
$observacion = $row['observacion'];

$idProveedor = $row['id_proveedor'];
$proveedor = $row['proveedor'];

$iva = $row['iva'];
$subtotal = $row['subtotal'];
$importe = $row['importe'];
$factura = $row['no_factura'];
$folio = $row['folio'];
$folioOC = $row['folio_oc'];
$folioE01 = $row['folio_entrada'];
$fechaPago = $row['fecha_vigencia']; 

$folioRequi = $row['folio_requi']; 
?>
<style>
table td{
    font-size:13px;
	font-weight:100;	
}
.borde_tabla td {
	padding-left:2px;
    padding-right:2px;
    padding-top: 0px;
    padding-bottom: 0px;
	border: 1px solid #000;
	font-size:13px;
	text-transform: capitalize;
    vertical-align:top;
	
}
.borde_tabla2 td {
	padding-left:0px;
    padding-right:0px;
    padding-top: 0px;
    padding-bottom: 0px;
	border: 0px solid #000;
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
        <td width="200" align="top"><?php echo '<img src="../../imagenes/'.$logo.'"  width="150"/>';?></td>
        <td width="400" class="datos" align="center" ><strong>CONTRARECIBO</strong> <br>
            <?php echo $sucursal;?><br>
            <?php echo $direccion;?><br>
            <?php echo 'Col: '.$colonia.' C.P.: '.$codigopostal;?><br>
            <?php echo $municipio.', '.$estado.'.';?>
        </td>
        <td width="110">
            <table border="0">
                <tr>
                    <td class="">Fecha : </td>
                    <td class="dato"><?php echo $fecha_entrada ?></td>
                </tr>
                <tr>
                    <td class="">Hora : </td>
                    <td class="dato"><?php echo $hora_entrada ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="borde_tabla" width="710">
   
    <tr>
        <td width='120'><table border="0" class="borde_tabla2"><tr><td width="80">Folio Entrada</td><td width="40" align="right"><?php echo $folioE01;?></td></tr></table></td>
        <td width='100'><table border="0" class="borde_tabla2"><tr><td width="110">Orden de compra </td><td width="70" align="right"><?php echo $folioOC;?></td></tr></table></td>
        <td width='100'><table border="0" class="borde_tabla2"><tr><td width="90">Requisición </td><td width="70" align="right"><?php echo $folioRequi;?></td></tr></table></td>
        <td width='260'><table border="0" class="borde_tabla2"><tr><td width="180">Fecha de recibido</td><td width="80" align="right"><?php echo $fecha;?></td></tr></table></td>
    </tr>
    <tr>
        <td width='120' rowspan="2">&nbsp;&nbsp;Factura <br>&nbsp;&nbsp; <?php echo $factura;?></td>
        <td width='355' rowspan="2" colspan="2">&nbsp;&nbsp;Proveedor<br> &nbsp;&nbsp;<?php echo $proveedor;?></td>
        <td width='260'><table border="0" class="borde_tabla2"><tr><td width="180">Fecha Programada de pago </td><td width="80" align="right"><?php echo $fechaPago;?></td></tr></table></td>
    </tr>
    <tr>
        <td width='260'><table border="0" class="borde_tabla2"><tr><td width="100">Subtotal  </td><td width="160" align="right"><?php echo dos_decimales($subtotal);?></td></tr><tr><td width="100">IVA  </td><td width="160" align="right"><?php echo dos_decimales($iva);?></td></tr>


            <?php
            if($descuento > 0)
            {
            ?>

        <tr><td width="100">Descuento  </td><td width="160" align="right"><?php echo dos_decimales($descuento);?></td></tr>
<?php } ?>


            <tr><td width="100">Importe  </td><td width="160" align="right"><?php echo dos_decimales($importe);?></td></tr></table></td>
    </tr>
   
</table>
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
    return '$'.$number; 
}
?>
