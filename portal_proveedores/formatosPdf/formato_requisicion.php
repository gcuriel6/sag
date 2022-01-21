<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
include("../php/conectar.php");
$link = Conectarse();

$datos=$_REQUEST['datos'];

$arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

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
      requisiciones.descripcion AS descripcion,
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

<table width="710" border="0">
    <tr>
        <td width="200" align="top"><?php echo '<img src="../imagenes/'.$rowU['logo'].'"  width="150"/>';?></td>
        <td width="400" class="datos" align="center" ><strong>REQUISICIÓN</strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <?php echo $rowU['direccion']; ?><BR> 
            CP:<?php echo $rowU['codigopostal'];?>.<br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $rowU['folio'];?></td>
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
        <td width="280" class="datos" align="left" ><?php echo $rowU['are']; ?></td>
        <td width="90" class="verde" align="left" >Departamento</td>
        <td width="290" class="datos" align="left" ><?php echo $rowU['depto']; ?></td>
    </tr>
</table>

<table width="710" class="borde_tabla">
    <tr class="encabezado">
        <td width="220" class="datos" align="center" ><b>Proveedor</b></td>
        <td width="200" class="datos" align="center" ><b>Solicitó</b></td>
        <td width="200" class="datos" align="center" ><b>Fecha de Pedido</b></td>
        <td width="55" class="datos" align="center" ><b>Días de Entrega</b></td>
        <td width="55" class="datos" align="center" ><b>Tipo</b></td>
    </tr>
    <tr>
        <td width="220" class="datos" align="left" ><?php echo $rowU['proveedor']; ?></td>
        <td width="200" class="datos" align="center" ><?php echo $rowU['solicito']; ?></td>
        <td width="200" class="datos" align="center" ><?php echo $rowU['fecha_pedido']; ?></td>
        <td width="55" class="datos" align="center" ><?php echo $rowU['tiempo_entrega']; ?></td>
        <td width="55-" class="datos" align="center" >
            <?php

                if($rowU['tipo'] == 1)
                    echo 'Activos Fijos';
                else if($rowU['tipo'] == 2)
                    echo 'Gastos';
                 else if($rowU['tipo'] == 3)
                    echo 'Mantenimiento ';
                else
                    echo 'Stock';

            ?>
                
            </td>
    </tr>
    <tr>
        <td colspan="5" width="50" class="datos"  ><b>Descripción</b></td> 
    </tr>
    <tr>
        <td colspan="5" width="200" class="datos" ><?php echo $rowU['descripcion']; ?></td>
    </tr>
</table>
   
   <table width="710" class="borde_tabla">
    <tr class="encabezado">
      <td width="130">Familia</td>
      <td width="130">Linea</td>
      <td width="100">Concepto</td>
      <td width="180">Descripción</td>
      <td width="70">Cantidad</td>
      <td width="50">% IVA</td>
      <td width="70">Precio U.</td>
    </tr>
<?php

  $queryD = "SELECT 
    requisiciones_d.id_producto,
    requisiciones_d.id_linea,
    requisiciones_d.id_familia,
    requisiciones_d.descripcion,
    requisiciones_d.cantidad,
    productos.clave,
    productos.concepto,
    productos.costo,
    productos.talla as verifica_talla,
    0 AS descuento,
    16 AS iva,
    (requisiciones_d.cantidad*productos.costo)AS importe,
    lineas.descripcion AS linea,
    familias.descripcion AS familia
    FROM requisiciones_d 
    LEFT JOIN productos ON requisiciones_d.id_producto=productos.id
    LEFT JOIN lineas ON requisiciones_d.id_linea=lineas.id
    LEFT JOIN familias ON requisiciones_d.id_familia=familias.id
    WHERE requisiciones_d.id_requisicion = $idRequisicion
    ORDER BY requisiciones_d.id DESC";
  $resultDetalle = mysqli_query($link, $queryD);
  while($rowD = mysqli_fetch_array($resultDetalle))
  {

      echo "<tr>";
      echo "<td>" . $rowD['familia'] . "</td>";
      echo "<td>" . $rowD['linea'] . "</td>";
      echo "<td>" . normaliza($rowD['concepto'], 20) . "</td>";
      echo "<td>" . normaliza($rowD['descripcion'], 20) . "</td>";
      echo "<td>" . $rowD['cantidad'] . "</td>";
      echo "<td>" . $rowD['iva'] . "</td>";
      echo "<td text-align='center'>" . $rowD['costo'] . "</td>";
      echo "</tr>";

  }
       

?>


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
    return $number; 
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