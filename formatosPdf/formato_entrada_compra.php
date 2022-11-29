<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idOrden = $arreglo['idRegistro'];

// Informacion de la empresa 
$query = "SELECT a.id,
a.folio,
a.id_unidad_negocio,
a.id_sucursal,
DATE(a.fecha) AS fecha,
a.observacion AS observacion,
a.id_proveedor,
b.nombre AS proveedor,
d.nombre AS unidad,
d.logo,
d.clave as clave_unidad,
e.descr AS sucursal,
CONCAT(e.calle, ' #',e.no_exterior,IF(e.no_interior!='',CONCAT(' No.Int: ',e.no_interior),'')) AS direccion,
e.colonia,
e.codigopostal,
f.municipio,
g.estado,
h.nombre_comp as usuario_captura,
h.usuario,
c.folio folio_oc
FROM almacen_e a
LEFT JOIN proveedores b ON a.id_proveedor=b.id
LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
LEFT JOIN municipios f ON e.id_municipio = f.id
LEFT JOIN estados g ON e.id_estado=g.id
LEFT JOIN orden_compra c ON c.id = a.id_oc 
LEFT JOIN usuarios h ON a.id_usuario_captura= h.id_usuario
WHERE a.id=".$idRegistro;

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$fecha = $row['fecha'];
$logo = $row['logo'];
$claveUnidad = $row['clave_unidad'];
$folio = $row['folio'];
$folio_oc = $row["folio_oc"];

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

$usuarioCaptura = $row['usuario_captura'];
$usuario = $row['usuario'];

      
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
        <td width="440" class="datos" align="center" ><strong>RECEPCION  DE MERCANCIA Y SERVICIOS</strong> <br>
            <?php echo $sucursal;?><br>
            <?php echo $direccion;?><br>
            <?php echo 'Col: '.$colonia.' C.P.: '.$codigopostal;?><br>
            <?php echo $municipio.', '.$estado.'.';?>
        </td>
        <td width="120">
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
                <?php
                    if($folio_oc != NULL && $folio_oc != ""){
                ?>
                <tr>
                	<td class="verde">OC</td>
                	<td class="dato"> <?php echo $folio_oc ?></td>
                </tr>
                <?php
                    }
                ?>

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
    <tr>
        <td colspan="2"><strong>Generado Por: </strong><?php echo $usuario." - ".$usuarioCaptura;?></td>
    </tr>
    
</table>

<!---- Productos---->
<?php  
  
    $queryE="SELECT a.id_producto,
                    a.precio,
                    a.cantidad,
                    a.iva,
                    a.porcentaje_descuento AS descuento,
                    a.lleva_talla AS lleva_tallas,
                    b.concepto,
                    b.descripcion,
                    c.descripcion AS familia,
                    c.id AS id_familia, 
                    d.descripcion AS linea,
                    d.id AS id_linea,
                    (a.precio * a.cantidad) AS importe,
                    IFNULL(IF(a.lleva_talla=1,(SELECT GROUP_CONCAT(' - ', cantidad ,' ', talla) FROM tallas WHERE tipo=3 AND id_detalle=a.id),'NA'),'NA') AS tallas,
                    a.isr
                FROM almacen_d a
                LEFT JOIN productos b ON a.id_producto=b.id
                LEFT JOIN familias c ON b.id_familia = c.id
                LEFT JOIN lineas d ON b.id_linea = d.id
                WHERE a.id_almacen_e=$idRegistro
                ORDER BY a.id";

    $consultaE = mysqli_query($link,$queryE);
    $numeroFilasE = mysqli_num_rows($consultaE);
    if($numeroFilasE>0){
?>
<h4>Productos </h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='340' align="center">Catálogo/Familia/Línea/Concepto/Descripción/Tallas</td>
            <td width='50' align="center">Cantidad</td>
            <td width='100' align="center">Costo Unitario</td>
            <td width='50' align="center">IVA%</td>
            <td width='80' align="center">Des%</td>
            <td width='110' align="center">Importe</td>
        </tr>
    </thead>
    <tbody>
    <?php
    //$tCantidad=0;
    //$tPrecio=0;
    $tPrecioTotal=0;
    $subtotal=0;
    $totalIva=0;
    $totalIsr = 0;
    while ($rowE = mysqli_fetch_array($consultaE)){
       //$tCantidad = $tCantidad + $rowE['cantidad'];
       //$tPrecio = $tPrecio + $rowE['costo_unitario'];

       if($rowE["isr"] > 0){
           $totalIsr = $rowE["isr"];
       }
       
       if($rowE['descuento'] > 0){
                    
            $subtotalP=$rowE['cantidad']*parseFloat($rowE['precio']);
            $descuentoTotal=(($rowE['descuento']*$subtotalP)/100);
            
            $subtotal=$subtotal+($subtotalP-$descuentoTotal);
            $totalIva=$totalIva+((($rowE['cantidad']*$rowE['precio'])-$descuentoTotal)*($rowE['iva']/100));

        }else{

            $subtotal=$subtotal+($rowE['cantidad']*$rowE['precio']);
            $totalIva=$totalIva+(($rowE['cantidad']*$rowE['precio'])*($rowE['iva']/100));
        }
        //--> NJES Cambiar formato de recepción de mercancia (DEN18-2474) -- Dic/13/2019 <--//
        echo   "<tr>
                    <td>".normaliza($rowE['id_producto'].'/'.$rowE['familia'].'/'.$rowE['linea'].'/'.$rowE['concepto'].'/'.$rowE['descripcion'].'/'.$rowE['tallas'],43)."</td> 
                    <td align='right'>".$rowE['cantidad']."</td> 
                    <td align='right'>".dos_decimales($rowE['precio'])."</td>
                    <td align='right'>".$rowE['iva']."</td> 
                    <td align='right'>".$rowE['descuento']."</td> 
                    <td align='right'>".dos_decimales($rowE['importe'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" rowspan="3"><strong> Observaciones: </strong><?php echo $observacion;?></td>
            <td class="verde" colspan="2">SubTotal </td>
            <td class="dato"  align="right"><?php echo dos_decimales($subtotal)?></td>    
        </tr>
        <tr>
            <td class="verde" colspan="2">Iva </td>
            <td class="dato"  align="right"><?php echo dos_decimales($totalIva)?></td>    
        </tr>
        <tr>
            <td class="verde" colspan="2">ISR </td>
            <td class="dato"  align="right"><?php echo dos_decimales($totalIsr)?></td>    
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="verde" colspan="2">Total </td>
            <td class="dato" align="right"><?php echo dos_decimales(($subtotal+$totalIva)-$totalIsr)?></td>    
        </tr>
    </tfoot>
</table>

<br><br>

<table width="710">
    <tr>
        <td width="710"  align="center">______________________________________</td>
    </tr>
    <tr>
        <td width="710" align="center"><?php echo $usuarioCaptura;?></td>
    </tr>
</table>
<?php }?>
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
      $ntexto.=$aux[$cont]."<br> &nbsp;&nbsp;&nbsp;";
      $cont++;
    }
    return $ntexto;
  }
?>
