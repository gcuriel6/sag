<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRequisicion = $arreglo['idRegistro'];


// Informacion de la empresa 
$query = "SELECT
      requisiciones.id AS id,
      requisiciones.id_unidad_negocio AS id_unidad_negocio,
      requisiciones.id_sucursal AS id_sucursal,
      requisiciones.id_area AS id_area,
      requisiciones.id_departamento AS id_departamento,
      requisiciones.folio AS folio,
      requisiciones.estatus AS estatus,
      cat_unidades_negocio.nombre AS unidad, 
      cat_unidades_negocio.logo as logo,
      cat_unidades_negocio.clave as clave_unidad,
      sucursales.descr AS sucursal,
      sucursales.codigopostal,
      CONCAT(sucursales.calle,' No. Ext ' ,sucursales.no_exterior,(IF(sucursales.no_interior!='','No. Int ','')),sucursales.no_interior) AS direccion,
      cat_areas.descripcion AS are,
      deptos.des_dep AS depto,
      requisiciones.solicito AS solicito,
      requisiciones.capturo AS capturo,
      requisiciones.id_proveedor AS id_proveedor,
      requisiciones.fecha_pedido AS fecha_pedido,
      requisiciones.tiempo_entrega AS tiempo_entrega,
      ifnull(requisiciones.descripcion,'') AS descripcion,
      requisiciones.id_orden_compra AS id_orden_compra,
      requisiciones.folio_orden_compra AS folio_orden_compra,
      requisiciones.subtotal AS subtotal,
      requisiciones.iva AS iva,
      requisiciones.total AS total,
      requisiciones.id_capturo AS id_capturo,
      requisiciones.tipo AS tipo,

       requisiciones.subtotal AS subtotal,
       requisiciones.iva AS iva,
       requisiciones.total AS total,
      
      requisiciones.folio_mantenimiento AS folio_mantenimiento,
      requisiciones.no_economico AS no_economico,
      requisiciones.responsable AS responsable,
      requisiciones.kilometraje AS kilometraje,  

      requisiciones.descuento AS descuento,
      proveedores.nombre as proveedor
      FROM requisiciones
      INNER JOIN cat_unidades_negocio ON requisiciones.id_unidad_negocio = cat_unidades_negocio.id
      INNER JOIN sucursales ON requisiciones.id_sucursal = sucursales.id_sucursal
      INNER JOIN cat_areas ON requisiciones.id_area = cat_areas.id
      INNER JOIN deptos ON requisiciones.id_departamento = deptos.id_depto
      INNER JOIN proveedores ON requisiciones.id_proveedor = proveedores.id
      WHERE requisiciones.id = $idRequisicion";

$consulta = mysqli_query($link, $query);
$rowU = mysqli_fetch_array($consulta);
//---datos sucursal---
$id = $rowU['id'];




      
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
    font-weight:bolder;
	
}
.borde_tabla2 td{
	border: 1px solid #F2F0FB;
	font-size:13px;
	text-transform: capitalize;
    vertical-align:top;
    font-weight:bolder;
	
}
.verde,.encabezado{
	background:#F2F0FB;
	color:#333333;
	font-size:13px;
	font-weight:bold;
    text-transform: capitalize;
}
.gris{
    background:#fafafa;
	color:#333333;
}
.dato{
	font-size:13px;
	text-transform: capitalize;
}
th, td {
    word-wrap: break-word;
}

@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_montos_nomina{
            height:auto;
            overflow:auto;
        }
        #td_descripcion{
            width:100%;
        }
        #td_clave{
            width:100%;
        }
    }

</style>
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="3mm"  backbottom="5mm">

<page_footer style="text-align:right;font-size:10px;">
    [[page_cu]] de [[page_nb]]
</page_footer>

<table width="710" border="0">
    <tr>
        <td width="200" align="top"><?php echo ($rowU['logo']!='')?'<img src="../imagenes/'.$rowU['logo'].'"  width="150"/>':'';?></td>
        <td width="400" class="datos" align="center" ><strong>REQUISICIÓN DE MANTENIMIENTO</strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <?php echo $rowU['direccion']; ?><BR> 
            CP:<?php echo $rowU['codigopostal'];?>.<br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio Requi</td>
                  <td class="dato"><?php echo $rowU['clave_unidad'].'-'.$rowU['folio'];?></td>
                </tr>
                <tr>
                  <td class="verde">Folio Mtto</td>
                  <td class="dato"><?php echo $rowU['clave_unidad'].'-'.$rowU['folio_mantenimiento'];?></td>
                </tr>
                <tr>
                    <td class="verde">Fecha Pedido</td>
                    <td class="dato"><?php echo $rowU['fecha_pedido'] ?></td>
                </tr>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
                <?php if($rowU['estatus']=='C'){?>
                <tr>
                    <td colspan="2" align=" center">Cancelado</td>
                </tr>
                <?php }?>
            </table>
        </td>
    </tr>
</table>

<table width="710"class='borde_tabla'>
    <tr>
        <td width="70" class="verde" align="left" >Area</td>
        <td width="285" class="datos" align="left" ><?php echo normaliza($rowU['are'],60); ?></td>
        <td width="90" class="verde" align="left" >Departamento</td>
        <td width="290" class="datos" align="left" ><?php echo normaliza($rowU['depto'],60); ?></td>
    </tr>
    <tr>
        <td class="verde" align="left" ><b>Proveedor</b></td>
        <td width="285" class="datos" align="left" ><?php echo normaliza($rowU['proveedor'],60); ?></td>
        <td class="verde" align="left" ><b>Fecha Pedido</b></td>
        <td width="290" class="datos" align="left" ><?php echo $rowU['fecha_pedido']; ?></td>

    </tr>
    <tr>
        <td class="verde" align="left" ><b>Responsable</b></td>
        <td width="285" class="datos" align="left" ><?php echo normaliza($rowU['responsable'],60); ?></td>
        <td class="verde" align="left" ><b>Vehiculo</b></td>
        <td width="290" class="datos" align="left" ><?php echo normaliza($rowU['no_economico'],60); ?></td>
    </tr>
    <tr>
        <td class="verde" align="left" ><b>Solicitó</b></td>
        <td width="285" class="datos" align="left" ><?php echo normaliza($rowU['solicito'],60); ?></td>
        <td class="verde" align="left" ><b>Kilometraje</b></td>
        <td width="290" class="datos" align="left" ><?php echo $rowU['kilometraje']; ?></td>
    </tr>
    <tr>
        <td class="verde" align="left" ><b>Descripción</b></td>
        <td colspan="3"  class="datos" ><?php echo normaliza($rowU['descripcion'],90); ?></td>
    </tr>
</table>
   <br>
   <table width="710" class="borde_tabla2">
    <thead>
        <tr class="encabezado" cellspacin="5" cellpading="5">
        <td width="130"><strong>Familia Gastos/ - Familia/ - Linea</strong></td>
        <td width="180"><strong>- Concepto/- Descripcion/ <br>-Justificacion</strong></td>
        <td width="60"><strong>Cantidad</strong></td>
        <td width="40"><strong>% IVA</strong></td>
        <td width="70"><strong>Precio U.</strong></td>
        <td width="70"><strong>Desc. U.</strong></td>
        <td width="70"><strong>Desc. T.</strong></td>
        <td width="70"><strong>Importe</strong></td>
        </tr>
    </thead>
    <tbody>
<?php

  $queryD = "SELECT 
  requisiciones_d.id_producto,
  requisiciones_d.id_linea,
  requisiciones_d.id_familia,
  requisiciones_d.descripcion,
  requisiciones_d.cantidad,
  requisiciones_d.justificacion,
  productos.clave,
  productos.concepto,
  requisiciones_d.costo_unitario AS costo,
  productos.talla AS verifica_talla,
  0 AS descuento,
  16 AS iva,
  (requisiciones_d.cantidad*requisiciones_d.costo_unitario)AS importe,
  lineas.descripcion AS linea,
  familias.descripcion AS familia,
  requisiciones_d.descuento_unitario,
  requisiciones_d.descuento_total,
  IFNULL(fam_gastos.descr,'') AS familia_gastos
  FROM requisiciones_d 
  LEFT JOIN productos ON requisiciones_d.id_producto=productos.id
  LEFT JOIN lineas ON requisiciones_d.id_linea=lineas.id
  LEFT JOIN familias ON requisiciones_d.id_familia=familias.id
  LEFT JOIN fam_gastos ON familias.id_familia_gasto=fam_gastos.id_fam
  WHERE requisiciones_d.id_requisicion = $idRequisicion
  ORDER BY requisiciones_d.id DESC";
  $resultDetalle = mysqli_query($link, $queryD);
  $cont= 0;
  while($rowD = mysqli_fetch_array($resultDetalle))
  {
      $cont++;
      $fondo='gris';
      if($cont%2){
        $fondo='';
      }
      echo "<tr class='".$fondo."'>";
      echo "<td width='130'>- " . normaliza($rowD['familia_gastos'], 15) . " <br>  - ". normaliza($rowD['familia'], 15) . " <br>  - ".normaliza($rowD['linea'],15)."</td>";
      echo "<td width='180'>- " . normaliza($rowD['concepto'],30) . " <br> - ".normaliza($rowD['descripcion'],30). " <br> - ".normaliza($rowD['justificacion'],41)."</td>";
      echo "<td width='60' align='right'>" . $rowD['cantidad'] . "</td>";
      echo "<td width='40' align='right'>" . $rowD['iva'] . "</td>";
      echo "<td width='70' align='right'>" . dos_decimales($rowD['costo']) . "</td>";
      echo "<td width='70' align='right'>" . dos_decimales($rowD['descuento_unitario']) . "</td>";
      echo "<td width='70' align='right'>" . dos_decimales($rowD['descuento_total']) . "</td>";
      echo "<td width='70' align='right'>" . dos_decimales($rowD['importe']) . "</td>";
      echo "</tr>";

  }
       

?>
</tbody>
<tfoot>
        <tr>
            <td colspan="5" rowspan="4"><strong> Descripción General: </strong><br><?php echo normaliza($rowU['descripcion'],67);?></td>
            <td class="verde" colspan="2">Descuento </td>
            <td class="dato"  align="right"><?php echo dos_decimales($rowU['descuento'])?></td>    
        </tr>
        <tr>
            <!--NJES March/12/2020 se normaliza texto para que no se sobrepase del borde-->
            <td class="verde" colspan="2">SubTotal </td>
            <td class="dato"  align="right"><?php echo dos_decimales($rowU['subtotal'])?></td>    
        </tr>
        <tr>
            
            <td class="verde" colspan="2">Iva </td>
            <td class="dato"  align="right"><?php echo dos_decimales($rowU['iva'])?></td>    
        </tr>
        <tr>
            
            <td class="verde" colspan="2">Total </td>
            <td class="dato" align="right"><?php echo dos_decimales($rowU['total'])?></td>    
        </tr>
    </tfoot>

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