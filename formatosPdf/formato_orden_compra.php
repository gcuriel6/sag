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
DATE(a.fecha_captura) AS fecha,
UPPER(a.observaciones_entrega) AS observacion,
a.id_proveedor,
a.id_departamento,
a.fecha_pedido,
a.tiempo_entrega,
a.fecha_entrega,
a.condiciones_pago,
b.nombre AS proveedor,
b.rfc,
c.razon_social AS a_facturar,
c.rfc as rfc_a_factura,
d.nombre AS unidad,
d.logo,
d.clave as clave_unidad,
e.descr AS sucursal,
CONCAT(e.calle, ' #',e.no_exterior,IF(e.no_interior!='',CONCAT(' No.Int: ',e.no_interior),'')) AS direccion,
e.colonia,
e.codigopostal,
f.municipio,
g.estado,
h.des_dep AS departamento,
IFNULL(i.descripcion,'') AS nom_area,
a.requisiciones AS folios_requisiciones
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

// echo $query;
// exit();

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$fecha = $row['fecha'];
$logo = $row['logo'];
$claveUnidad = $row['clave_unidad'];
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
$rfc = $row['rfc'];
$idDepartamento = $row['id_departamento'];
$departamento = $row['departamento'];
$nom_area = $row['nom_area'];

$facturaA = $row['a_facturar'];
$rfcFacturaA = $row['rfc_a_factura'];

$folios_requisiciones = $row['folios_requisiciones'];
      
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
        <!-- MGFS  08-01-2020 SE AGREGA VALIDACION PARA VER QUE LA IMAGEN EXISTA EN LA CARPETA 
        YA QUE SI NO EXISTE PUEDE MARCAR ERROR AL GENERAR EL PDF-->
        <?php
            $carpeta = "../imagenes/".$logo;
            if(file_exists($carpeta)){ ?>
                <td width="200"><?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?></td><?php 
            }else{?>
                <td width="200"></td><?php
            } ?>
        <td width="440" class="datos" align="center" ><strong>ORDEN DE COMPRA</strong> <br>
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
                <tr>
                	<td class="verde" colspan="2">Folio Requisicion</td>
                </tr>
                <tr>
                	<td class="dato" colspan="2"><?php echo $claveUnidad.' - '.$folios_requisiciones; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table class="borde_tabla" width="710">

    <?php //si tiene Proveedor se agrega
    if($idProveedor != 0){ 
    ?>
    <tr>
        <td width="510"><strong>Proveedor: </strong><?php echo $proveedor;?></td>
        <td width="200"><strong>RFC: </strong><?php echo $rfc;?></td>
    </tr>
    <tr>
        <td width="510"><strong>Factura a: </strong><?php echo $facturaA;?></td>
        <td width="200"><strong>RFC: </strong><?php echo $rfcFacturaA;?></td>
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
        <td colspan="2"><strong>Clasificación a Presupuesto: </strong><?php echo $clasificacion;?></td>
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
        <td class="verde" width="188" align='center'>Fecha Pedido</td>
        <td class="verde" width="188" align='center'>Tiempo Entrega</td>
        <td class="verde" width="188" align='center'>Fecha Entrega</td>
        <td class="verde" width="188" align='center'>Condiciones de Pago</td>
    
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
    UPPER(b.concepto) AS concepto,
    UPPER(b.descripcion) AS descripcion,
    UPPER(c.descripcion) AS familia,
    c.id AS id_familia, 
    UPPER(d.descripcion) AS linea,
    d.id AS id_linea,
    (a.costo_unitario * a.cantidad) AS importe,
    UPPER(IFNULL(IF(a.tallas=1,(SELECT GROUP_CONCAT(' - ', cantidad ,' ', talla) FROM tallas WHERE tipo=2 AND id_detalle=a.id),'NA'),'NA')) AS tallas,
    requisiciones_d.descuento_total
    FROM orden_compra_d a
    LEFT JOIN productos b ON a.id_producto=b.id
    LEFT JOIN familias c ON b.id_familia = c.id
    LEFT JOIN lineas d ON b.id_linea = d.id
    LEFT JOIN requisiciones_d ON a.id_requi_d=requisiciones_d.id
    WHERE a.id_orden_compra=".$idRegistro."
    ORDER BY a.id";

    // echo $queryE;
    // exit();
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
    $tCantidad=0;
    $tPrecio=0;
    $tPrecioTotal=0;
    $subtotal=0;
    $totalIva=0;
    $descuentoTRequis = 0;
    // error_reporting(E_ALL);
    while ($rowE = mysqli_fetch_array($consultaE)){
       $tCantidad = $tCantidad + $rowE['cantidad'];
       $tPrecio = $tPrecio + $rowE['costo_unitario'];
       
       if($rowE['descuento'] > 0){
                    
            $subtotalP=$rowE['cantidad']*floatval($rowE['costo_unitario']);
            $descuentoTotal=(($rowE['descuento']*$subtotalP)/100);
            
            $subtotal=$subtotal+($subtotalP-$descuentoTotal);
            $totalIva=$totalIva+((($rowE['cantidad']*$rowE['costo_unitario'])-$descuentoTotal)*($rowE['iva']/100));

        }else{

            $subtotal=$subtotal+($rowE['cantidad']*$rowE['costo_unitario']);
            $totalIva=$totalIva+(($rowE['cantidad']*$rowE['costo_unitario'])*($rowE['iva']/100));
        }

        //-->NJES November/20/2020 mostrar descuentode las requis de la OC en la sección de totales
        $descuentoTRequis = $descuentoTRequis + $rowE['descuento_total'];

        //--> NJES Cambiar formato de ordenes de compra (DEN18-2473) -- Dic/13/2019 <--//

        //--  MGFS  08-01-2020 SE CAMBIA EL PARAMETRO DE normaliza ya que se salia la ifo de la 
        //--  tabla y en la consulta se cambio a que todo se convierta a mayusculas para que todas 
        //--  la oc salgan del mismo tamaño en margen aprox
        echo   "<tr>
                    <td> ".normaliza($rowE['id_producto'].' / '.$rowE['familia'].' / '.$rowE['linea'].' / '.$rowE['concepto'].' / '.$rowE['descripcion'].' / '.$rowE['tallas'],42)."</td> 
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
            <td colspan="3" rowspan="4"><strong> Observaciones: </strong><br><?php echo normaliza($observacion,50);?></td>
            <td class="verde" colspan="2">Descuento </td>
            <td class="dato"  align="right"><?php echo dos_decimales($descuentoTRequis)?></td>    
        </tr>
        <tr>
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
