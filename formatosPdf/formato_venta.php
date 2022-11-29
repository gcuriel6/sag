<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];
$conceptoAlmacen = isset($arreglo['concepto']) ? $arreglo['concepto'] : "";
//(a.costo_instalacion+a.costo_administrativo+a.comision_venta)
// Informacion de la empresa 
$query = "SELECT 
a.folio,
a.id_sucursal,
DATE(a.fecha_captura) AS fecha,
a.porcentaje_iva,
a.subtotal,
a.iva,
a.total,
a.costo_instalacion,
a.costo_administrativo,
a.comision_venta,
a.descuento,
(a.costo_instalacion+a.costo_administrativo+a.comision_venta) AS total_costo,
IF(a.estatus='C','CANCELADA',IF(a.cotizacion=1,'SEGUIMIENTO','AUTORIZADA')) AS estatus,
b.descr AS sucursal,
c.nombre AS unidad,
c.logo,
c.clave AS clave_unidad,
a.vendedor,
IF(a.tipo_cotizacion>0,IF(a.tipo_cotizacion=1,'Alarma',IF(a.tipo_cotizacion=2,'Servicio de Monitoreo','Mixta')),'') AS tipo_cotizacion,
IFNULL(d.razon_social,'')AS razon_social, 
UPPER(d.nombre_corto) AS cliente,
CONCAT(d.domicilio,' ',d.no_exterior,IF(d.no_interior!='',CONCAT(' INT:',d.no_interior),''),'<br> COL:',d.colonia)AS domicilio_f,
CONCAT(d.domicilio_s,' ',d.no_exterior_s,IF(d.no_interior_s!='',CONCAT(' INT:',d.no_interior_s),''),'<br> COL:',d.colonia_s)AS domicilio_s,
CONCAT(b.calle,' No. Ext ' ,b.no_exterior,(IF(b.no_interior!='','No. Int ','')),b.no_interior) AS direccion_sucursal,
b.codigopostal AS cp_sucursal,
b.colonia AS colonia_sucursal,
g.estado AS estado_sucursal,
h.municipio AS municipio_sucursal,
d.latitud,
d.longitud,
d.cuenta,
d.telefonos,
a.facturar,
a.observaciones_cotizacion as observ
FROM notas_e a
LEFT JOIN sucursales b ON a.id_sucursal=b.id_sucursal
LEFT JOIN cat_unidades_negocio c ON b.id_unidad_negocio=c.id
LEFT JOIN servicios d ON a.id_cliente=d.id
LEFT JOIN estados g ON b.id_estado = g.id
LEFT JOIN municipios h ON b.id_municipio = h.id
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
$cliente = $row['cliente'];

$porcentajeIva = $row['porcentaje_iva'];
//$subtotal = $row['subtotal'];
$iva = $row['iva'];
$total = $row['total'];

$estatus = $row['estatus'];
$totalCosto = $row['total_costo'];
$descuento = $row['descuento'];

$domicilio_s = $row['domicilio_s'];
$domicilio_f = $row['domicilio_f'];

$tipo_cotizacion = $row['tipo_cotizacion'];

//-->NJES Sep/23/2020 se agrega vendedor, que es el tranajador ligado al usuario logueado (usuario captura)
$vendedor = $row['vendedor'];

$direccion_sucursal = $row['direccion_sucursal'];
$direccion_sucursal = $row['direccion_sucursal'];
$colonia_sucursal = $row['colonia_sucursal'];
$cp_sucursal = $row['cp_sucursal'];
$municipio_sucursal = $row['municipio_sucursal'];
$estado_sucursal = $row['estado_sucursal'];

$id_sucursal = $row['id_sucursal'];

$latitud = $row['latitud'];
$longitud = $row['longitud'];
$cuenta = $row['cuenta'];
$telefonos = $row["telefonos"];
$facturar = $row["facturar"] == 1 ? "Si" : "No";
$observ = $row["observ"];
      
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
        <?php
        $carpeta = "../imagenes/".$logo;
        if(file_exists($carpeta)){ ?>
            <!--NJES March/24/2021 si la sucursal es SEYCOM mostrar ese logo tambien-->
            <?php if($id_sucursal == 57) {?>
                <td width="160" align="top">
            <?php }else{ ?>
                <td width="180" align="top">
            <?php } ?>
                <?php echo '<img src="../imagenes/'.$logo.'"  width="150" height="50"/>';?></td><?php 
        }else{?>
            <td width="180"></td><?php
        } ?>
        <?php if($id_sucursal == 57) {?>
            <td width="350" class="datos" align="center" >
        <?php }else{ ?>
            <td width="450" class="datos" align="center" >
        <?php } ?>
            <strong>VENTAS</strong> <br>
            Unidad de Negocio: <?php echo $unidad; ?><br> 
            Sucursal: <?php echo $sucursal;?><br>
            <!--<?php echo $domicilio_f;?><br>-->

            Calle: <?php echo $direccion_sucursal; ?><br> 
            Colonia: <?php echo $colonia_sucursal; ?><br> 
            C.P. <?php echo $cp_sucursal; ?><BR> 
            <?php echo $municipio_sucursal;?>, <?php echo $estado_sucursal;?>.<br>
        </td>

        <?php if($id_sucursal == 57) {?>
            <td width="130" align="top">
                <?php echo '<img src="../imagenes/seycom.png"  width="120"/>';?>
            </td>
            <td width="100">
        <?php }else{ ?>
            <td width="120">
        <?php } ?>
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $claveUnidad.'-'.$folio;?></td>
                </tr>
                <tr>
                    <td class="verde">Fecha</td>
                    <td class="dato"><?php echo $fecha ?></td>
                </tr>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
                <tr>
                    <td class="verde" colspan="2" align="center"><?php echo $estatus; ?></td>
                    
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<table width="100%">
    <tr>
        <!-- parte de la info -->
        <td>
            <table class="borde_tabla" width="100%">
                <?php if($vendedor != ''){ ?>
                    <tr><td><strong>Vendedor: </strong></td></tr>
                    <tr><td><?php echo $vendedor;?></td></tr>
                <?php } ?>

                <?php //si tiene Proveedor se agrega
                if($cliente != ''){ 
                ?>
                    <tr><td><strong>Cliente: </strong></td></tr>
                    <tr><td><?php echo $cliente;?></td></tr>
                    <tr><td><strong>Cuenta: </strong></td></tr>
                    <tr><td><?php echo $cuenta;?></td></tr>
                    <tr><td><strong>Domicilio: </strong></td></tr>
                    <tr><td><?php echo $domicilio_s;?></td></tr>
                    <tr><td><strong>Telefonos: </strong></td></tr>
                    <tr><td><?php echo $telefonos;?></td></tr>
                    <tr><td><strong>Factura: </strong></td></tr>
                    <tr><td><?php echo $facturar;?></td></tr>
                <?php
                }
                ?>
            
                <?php if($tipo_cotizacion != ''){ ?>
                    <tr><td><strong>Tipo Cotización: </strong></td></tr>
                    <tr><td><?php echo $tipo_cotizacion;?></td></tr>
                <?php } ?>
                
            </table>
        </td>
        <!-- mapa va aqui -->
        <td>
            <img src="<?php echo "https://maps.googleapis.com/maps/api/staticmap?center=$latitud,$longitud&zoom=16&size=500x250&key=AIzaSyBoD4mBMwf4boXGnAKMeC_-VK9NaON_W2w&markers=$latitud,$longitud";?>">
        </td>
    </tr>
</table>

<!---- Productos---->

<?php  
/*** 13-11-2019 MGFS SE AGREGA UNA CONSULTA PARA OBTENER EL TOTAL DE SERVICIO Y EL TOTAL DE PRODUCTOS 
 * PARA REALIZAR EL PRORATEO DEL TOTAL DE SERVICIOS Y EL TOTAL DE LOS COSTOS
 * SE SUMA EL TOTAL DE SERVICOOS CON EL TOTAL DE LOS COSTOS Y SE DIVIDE ENTRE EL TOTAL DE PRODUCTOS
 */

 /**
  * MGFS 17-01-2020 SE QUITA EL PRORRATEO A PETICIÓN DE SINTIA(SECORP)
  */
/*$queryS="SELECT SUM(cantidad)AS total_productos,SUM(sub.importe)AS total_servicios
FROM
(	(SELECT
        0 AS cantidad,
		(a.precio * a.cantidad) AS importe,
		b.servicio
	FROM notas_d a
	LEFT JOIN productos b ON a.id_producto=b.id
	WHERE a.id_nota_e=".$idRegistro."
	HAVING servicio=1
    ORDER BY a.id)
    UNION 
    (SELECT
        a.cantidad,
		0 AS importe,
		b.servicio
	FROM notas_d a
	LEFT JOIN productos b ON a.id_producto=b.id
	WHERE a.id_nota_e=".$idRegistro."
	HAVING servicio=0
	ORDER BY a.id)
)AS sub";
$consultaS = mysqli_query($link,$queryS);
$numeroFilasS = mysqli_num_rows($consultaS);

$totalServicios=0;
$totalProductos=0;
$$prorrateo=0;

if($numeroFilasS>0){
    $rowS = mysqli_fetch_array($consultaS);   
    $totalServicios = $rowS['total_servicios'];
    $totalProductos = $rowS['total_productos'];
}

$proratear =  $totalServicios + $totalCosto;
$prorrateo = $proratear/$totalProductos;*/

//--> NJES Jan/27/2020 Mostrar los servicios en la impresión ya que se elimino el prorrateo de las 
    //cotizaciones de venta alarmas y se solicita que se puedan convertir a venta cuando son servicios 
    //y no se toma en cuenta la existencia para ellos
    //se elimina HAVING servicio=0 de query
    $queryE="SELECT a.id_producto,
                    a.clave,
                    a.precio,
                    a.cantidad,
                    a.producto,
                    b.descripcion,
                    (a.precio * a.cantidad) AS importe,
                    b.servicio
                    FROM notas_d a
                    LEFT JOIN productos b ON a.id_producto=b.id
                    WHERE a.id_nota_e=".$idRegistro."
                    ORDER BY a.id";
    $consultaE = mysqli_query($link,$queryE);
    $numeroFilasE = mysqli_num_rows($consultaE); 
    if($numeroFilasE>0){    
?>
<h4>Productos </h4>
<table class="borde_tabla" width="720">
    <thead>
        <tr class="encabezado">
            <td width='88' align="center">Catálogo </td>
            <td width='100' align="center">Clave</td>
            <td width='100' align="center">Producto</td>
            <td width='66' align="center">Cantidad</td>
            <td width='88' align="center">Precio Unitario</td>
            <td width='88' align="center">Importe</td>
        </tr>
    </thead>
    <tbody>
    <?php
    /*** 13-11-2019 MGFS SE SUMA LA CANTIDAD CORREPONDIENTE AL PRORRATEO CALCULADO Y SE SUMA AL PRECIO 
     * Y SE RECALCULA EL IMPORTE
     */
    $totalServicio=0;
    $subtotal = 0;
    while ($rowE = mysqli_fetch_array($consultaE)){
        //$precio = $rowE['precio'] + $prorrateo; MGFS 17-01-2020 SE QUITA EL PRORRATE A PETICION DE SINTIA(SECORP)
        $precio = $rowE['precio'];
        $importe = $precio * $rowE['cantidad'];
        $subtotal =$subtotal + $importe;
        echo   "<tr>
                    <td width='100'>".$rowE['id_producto']."</td>
                    <td width='100'>".$rowE['clave']."</td> 
                    <td width='210'>".$rowE['producto']."</td>
                    <td width='100' align='right'>".$rowE['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($precio)."</td>
                    <td width='100' align='right'>".dos_decimales($importe)."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
</table>
<br>
<table width="720">
    <tr class="encabezado">
        <td width='630' align='right' colspan="2">Subtotal</td>
        <td width='100' align='right'><?php echo dos_decimales($subtotal)?></td> 
    </tr>
    <tr class="encabezado">
        <td width='610' align='right' colspan="2">Descuento</td>
        <td width='100' align='right'><?php echo dos_decimales($descuento)?></td> 
    </tr>
    <tr class="encabezado">
       
        <td width='510' align="right">Tasa Iva <?php echo $porcentajeIva;?>%</td>
        <td width='100' align="right">IVA</td>
        <td width='100' align="right"><?php echo dos_decimales($iva)?></td>
    </tr>
    
    <tr class="encabezado">
        <td width='610' align='right' colspan="2">Total</td>
        <td width='100' align='right'><?php echo dos_decimales($total)?></td> 
    </tr>
</table>
<?php }?>

<table width="750">
    <tr>
        <th>Observaciones</th>
    </tr>
    <tr>
        <td>
            <div style="border: solid 1px black; height: 100px; background-color: #f4f4f4; width: 100%;">
                <?php echo $observ; ?>
            </div>
        </td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td width="50"></td>
        <td width="300"><div style="border-bottom: solid 1px black; width:100%; height:120px;"></div></td>
        <td width="50"></td>
        <td width="300"><div style="border-bottom: solid 1px black; width:100%; height:120px;"></div></td>
        <td width="50"></td>
    </tr>
    <tr>
        <td width="50"></td>
        <td width="300"><div style="width: 100%; text-align: center;">Firma Cliente</div></td>
        <td width="50"></td>
        <td width="300"><div style="width: 100%; text-align: center;">Firma Técnico</div></td>
        <td width="50"></td>
    </tr>
</table>

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
    return '$ '.$number; 
}
?>
