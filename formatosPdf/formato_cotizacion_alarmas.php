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
$query = "SELECT 
a.folio AS folio,
a.id_sucursal,
DATE(a.fecha_captura) AS fecha,
a.porcentaje_iva,
a.subtotal,
a.iva,
a.total,
a.descuento,
b.descr AS sucursal,
c.nombre AS unidad,
c.logo,
c.clave AS clave_unidad,
a.cliente_cotizacion AS cliente,
a.observaciones_cotizacion,
a.vendedor,
f.telefono1 AS telefono_vendedor,
IF(a.tipo_cotizacion>0,IF(a.tipo_cotizacion=1,'Alarma',IF(a.tipo_cotizacion=2,'Servicio de Monitoreo','Mixta')),'') AS tipo_cotizacion,
CONCAT(d.domicilio,' ',d.no_exterior,IF(d.no_interior!='',CONCAT(' INT:',d.no_interior),''),'<br> COL:',d.colonia)AS domicilio_f,
CONCAT(d.domicilio_s,' ',d.no_exterior_s,IF(d.no_interior_s!='',CONCAT(' INT:',d.no_interior_s),''),'<br> COL:',d.colonia_s)AS domicilio_s,
CONCAT(b.calle,' No. Ext ' ,b.no_exterior,(IF(b.no_interior!='','No. Int ','')),b.no_interior) AS direccion_sucursal,
b.codigopostal AS cp_sucursal,
b.colonia AS colonia_sucursal,
g.estado AS estado_sucursal,
h.municipio AS municipio_sucursal
FROM notas_e a
LEFT JOIN sucursales b ON a.id_sucursal=b.id_sucursal
LEFT JOIN cat_unidades_negocio c ON b.id_unidad_negocio=c.id
LEFT JOIN servicios d ON a.id_cliente=d.id
LEFT JOIN usuarios e ON a.id_usuario_captura=e.id_usuario
LEFT JOIN trabajadores f ON e.id_empleado=f.id_trabajador
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
$subtotal = $row['subtotal'];
$iva = $row['iva'];
$descuento = $row['descuento'];
$total = $row['total'];
$obsevacionesCotizacion = $row['observaciones_cotizacion'];
$domicilio_s = $row['domicilio_s'];
$domicilio_f = $row['domicilio_f'];

$tipo_cotizacion = $row['tipo_cotizacion'];

//-->NJES Sep/23/2020 se agrega vendedor, que es el tranajador ligado al usuario logueado (usuario captura)
$vendedor = $row['vendedor'];
$telefono = $row['telefono_vendedor'];

$direccion_sucursal = $row['direccion_sucursal'];
$colonia_sucursal = $row['colonia_sucursal'];
$cp_sucursal = $row['cp_sucursal'];
$municipio_sucursal = $row['municipio_sucursal'];
$estado_sucursal = $row['estado_sucursal'];

$id_sucursal = $row['id_sucursal'];

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
        <!--NJES March/24/2021 si la sucursal es SEYCOM mostrar ese logo tambien-->
        <?php if($id_sucursal == 57) {?>
            <td width="160" align="top">
        <?php }else{ ?>
            <td width="180" align="top">
        <?php } ?>
            <?php echo '<img src="../imagenes/'.$row['logo'].'"  width="150"/>';?>
        </td>

        <?php if($id_sucursal == 57) {?>
            <td width="350" class="datos" align="center" >
        <?php }else{ ?>
            <td width="450" class="datos" align="center" >
        <?php } ?>
            <strong>COTIZACIÓN</strong> <br>
            Unidad de Negocio: <?php echo $unidad; ?><br> 
            Sucursal: <?php echo $sucursal;?><br>
            <!--<?php echo $domicilio_f;?><br>-->
            Calle: <?php echo $direccion_sucursal; ?><br> 
            Colonia: <?php echo $colonia_sucursal; ?> 
            <br>C.P. <?php echo $cp_sucursal; ?><br> 
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
            </table>
        </td>
    </tr>
</table>

<br>
<table width="100%">
    <tr>
        <td width="490">
            <table class="borde_tabla" width="100%">
                <?php //si tiene Proveedor se agrega
                if($cliente != ''){ 
                ?>
                <tr>
                    <td><strong>Cliente: </strong><?php echo $cliente;?></td>
                </tr>
                <tr>
                    <td><strong>Domicilio: </strong><?php echo $domicilio_s;?></td>
                </tr>
                <?php
                }
                ?>

                <?php if($tipo_cotizacion != ''){ ?>
                <tr>
                    <td><strong>Tipo Cotización: </strong><?php echo $tipo_cotizacion;?></td>
                </tr>
                <?php } ?>
            </table>
        </td>
        <td width="240">
            <table class="borde_tabla" width="100%">
                <?php 
                if($vendedor != ''){ 
                ?>
                <tr>
                    <td><strong>Vendedor: </strong><?php echo normaliza($vendedor,28);?></td>
                </tr>
                <tr>
                    <td><strong>Teléfono: </strong><?php echo $telefono;?></td>
                </tr>
                <?php
                }
                ?>
            </table>
        </td>
    </tr>
</table>

<!---- Productos---->
<?php  
  
    $queryE="SELECT a.id_producto,
                    a.clave,
                    a.precio,
                    a.cantidad,
                    a.producto,
                    b.descripcion,
                    (a.precio * a.cantidad) AS importe
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
            <td align="center">Cantidad</td>
            <td align="center">Clave</td>
            <td align="center">Producto</td>
            <td align="center">Precio Unitario</td>
            <td align="center">Importe</td>
        </tr>
    </thead>
    <tbody>
    <?php
    
    while ($rowE = mysqli_fetch_array($consultaE)){
      
      
        echo   "<tr>
                    <td width='110'>".$rowE['cantidad']."</td> 
                    <td width='125'>".$rowE['clave']."</td> 
                    <td width='255'>".$rowE['producto']."</td>                    
                    <td width='125' align='right'>".dos_decimales($rowE['precio'])."</td>
                    <td width='125' align='right'>".dos_decimales($rowE['importe'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
</table>
<br>
<table>
    <tr class="encabezado">
        <td width='630' align='right' colspan="2">Subtotal</td>
        <td width='125' align='right'><?php echo dos_decimales($subtotal)?></td> 
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

<br><br>
<label>Notas/Facturar a: </label>
<div style="border:1pz solid #f6f4ee; width:760px; height:70px; padding:5px;">
    <?php //si tiene Proveedor se agrega
    if($obsevacionesCotizacion != '')
    { 
        echo $obsevacionesCotizacion;
    }
    ?>
</div>

<br><br>
<table style="border: 1px solid red;">
    <tr>
        <td width="745" style="border-bottom: 1px solid red; padding:5px;">TERMINOS Y CONDICIONES</td>
    </tr>
    <tr>
        <td style="padding:5px;">
            Garantía de 1 año, contara defectos de fábrica, instalación y programación NO incluye  robo y/o extravío. <br>
            Cotización realizada en moneda nacional pagando un 50%  de anticipo para la instalación. <br>
            Vigencia  de cotizacón 15 días hábiles a partir de la fecha de expedición. <br>
        </td>
    </tr>
</table>

<br><br><br><br><br><br>
<table style="text-align:center;">
    <tr>
        <td>
            <table>
                <tr>
                    <td width="400">______________________________________</td>
                </tr>
                <tr>
                    <td>Firma Cliente<br><br><br><br><br><br></td>
                </tr>
                
                <tr>
                    <td width="400">______________________________________</td>
                </tr>
                <tr>
                    <td>Firma Vendedor</td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>    
                    <td width="250" style="background:black; color:white; text-align:center; font-size:14px;">Datos de Transferencia</td>
                </tr>
                <tr>    
                    <td style="border:1px solid black; padding:5px 20px;">
                    Banco: Banorte<br>
                    CTA: 1020150070<br>
                    CLABE: 072150010201500701
                    </td>
                </tr>
            </table>
        </td>
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
    return '$'.$number; 
}

function normaliza($texto,$longitud){
    $ntexto='';
    $aux = str_split($texto,$longitud);
    $cont=0;
    while($cont < sizeof($aux))
    {
      $ntexto.=$aux[$cont]."<br> &nbsp;&nbsp;&nbsp;";
      $cont++;
    }
    return $ntexto;
}

?>
