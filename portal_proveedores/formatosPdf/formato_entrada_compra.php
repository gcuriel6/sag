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
DATE(a.fecha) AS fecha,
a.observacion AS observacion,
a.id_proveedor,
FORMAT((a.subtotal+a.iva),2) AS importe,
b.nombre AS proveedor,
d.nombre AS unidad,
d.logo,
e.descr AS sucursal,
CONCAT(e.calle, ' #',e.no_exterior,IF(e.no_interior!='',CONCAT(' No.Int: ',e.no_interior),'')) AS direccion,
e.colonia,
e.codigopostal,
f.municipio,
g.estado
FROM almacen_e a
LEFT JOIN proveedores b ON a.id_proveedor=b.id
LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
LEFT JOIN municipios f ON e.id_municipio = f.id
LEFT JOIN estados g ON e.id_estado=g.id
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

$idProveedor = $row['id_proveedor'];
$proveedor = $row['proveedor'];

$importe = $row['importe'];
$folio = $row['folio'];
$folioOC = $row['folio_oc'];
$folioE01 = $folio['folio_entrada'];
      
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
        <td width="400" class="datos" align="center" ><strong>ENTRADA POR COMPRA</strong> <br>
            <?php echo $sucursal;?><br>
            <?php echo $direccion;?><br>
            <?php echo 'Col: '.$colonia.' C.P.: '.$codigopostal;?><br>
            <?php echo $municipio.', '.$estado.'.';?>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                    <td class="verde">Fecha</td>
                    <td class="dato"><?php echo $fecha ?></td>
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
<table class="borde_tabla" width="710">
    <thead>
        <tr>
            <td width='230' align="center">Folio  <?php echo $folio;?></td>
            <td width='230' align="center">Orden de Compra <?php echo $folio_oc;?></td>
            <td width='230' align="center">Fecha de Recibido <?php echo $fecha;?></td>
        </tr>
        <tr>
            <td width='230' align="center">Factura  <?php echo $factura;?></td>
            <td width='230' align="center">Proveedor <?php echo $proveedor;?></td>
            <td width='230' align="center">Fecha Programada de Pago <?php echo $fecha_vigencia;?><br> Importe</td>
        </tr>
    </thead>
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
