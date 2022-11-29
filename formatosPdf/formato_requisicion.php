
<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$respuestaGoogle = ( currencyConverter("MXN","USD"));
$taza = $respuestaGoogle["exhangeRate"];
/*
    Unidades de requis en dolares
    -30 - Alimentos Mexicanos
    -19 - FAM
*/
$unidadesDolares = array(30);

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

      requisiciones.descuento AS descuento,
      proveedores.nombre as proveedor,
      requisiciones.b_anticipo,
      requisiciones.monto_anticipo
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
<!--<img src="../imagenes/'.$rowU['logo'].'"  width="150"/>-->
<page_footer style="text-align:right;font-size:10px;">
    [[page_cu]] de [[page_nb]]
</page_footer>
<table width="710" border="0">
    <tr>
            <?php
            $carpeta = "../imagenes/".$rowU['logo'];
            if(file_exists($carpeta)){ ?>
                <td width="200"><?php echo '<img src="../imagenes/'.$rowU['logo'].'"  width="150"/>';?></td><?php 
            }else{?>
                <td width="200"></td><?php
            } ?>
        <td width="400" class="datos" align="center" ><strong>REQUISICIÓN</strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <?php echo $rowU['direccion']; ?><BR> 
            CP:<?php echo $rowU['codigopostal'];?>.<br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $rowU['clave_unidad'].'-'.$rowU['folio'];?></td>
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
<?php

  if($rowU['tipo']  == 4)
  {

    $queryF = "SELECT 
        orden_compra.folio AS folio_oc,
        almacen_e.folio AS folio_ea
        FROM requisiciones 
        INNER JOIN orden_compra ON requisiciones.id = orden_compra.ids_requisiciones 
        INNER JOIN almacen_e ON orden_compra.id = almacen_e.id_oc 
        WHERE requisiciones.id = $idRequisicion";

    $consultaF = mysqli_query($link, $queryF);
    $r = mysqli_fetch_array($consultaF); 

    if($r['folio_oc'] != null) 
    {
      echo '<table width="710" class="borde_tabla">';
    echo '<tr class="encabezado"><td width="440" class="datos" align="center" ><b>Folio Orden de Compra</b></td><td width="440" class="datos" align="center" ><b>Folio Recepción de Servicio</b></td></tr>';
    echo '<tr>';
    echo '<td  align="center">' . $r['folio_oc'] .  '</td>';
    echo '<td  align="center">' . $r['folio_ea'] .  '</td>';
    echo '</tr>';
    echo '</table>';
    }

    


  }

?>


<table width="710" class="borde_tabla">
    <tr class="encabezado">
        <td width="220" class="datos" align="center" ><b>Proveedor</b></td>
        <td width="200" class="datos" align="center" ><b>Solicitó</b></td>
        <td width="130" class="datos" align="center" ><b>Fecha de Pedido</b></td>
        <td width="55" class="datos" align="center" ><b>Días de Entrega</b></td>
        <td width="140" class="datos" align="center" ><b>Tipo</b></td>
    </tr>
    <tr>
        <td width="220" class="datos" align="left" ><?php echo $rowU['proveedor']; ?></td>
        <td width="200" class="datos" align="center" ><?php echo $rowU['solicito']; ?></td>
        <td width="130" class="datos" align="center" ><?php echo $rowU['fecha_pedido']; ?></td>
        <td width="55" class="datos" align="center" ><?php echo $rowU['tiempo_entrega']; ?></td>
        <td width="140" class="datos" align="center" >
            <?php

                if($rowU['tipo'] == 0)
                    echo 'Activos Fijos';
                else if($rowU['tipo'] == 1)
                    echo 'Gastos';
                 else if($rowU['tipo'] == 2)
                    echo 'Mantenimiento ';
                else if($rowU['tipo'] == 3)
                    echo 'Stock';
                  else
                    echo "Orden de Servicio";

            ?>
                
            </td>
    </tr>
        <?php
            $tiposAnticipo = [0,2,3];

            if(in_array($rowU["tipo"],$tiposAnticipo)){
                if($rowU["b_anticipo"]==1){
                    ?>
                        <tr>
                            <td colspan="4" class="datos"><b>Descripción</b></td> 
                            <td class="datos"><b>Anticipo</b></td> 
                        </tr>
                        <tr>
                            <td colspan="4" class="datos" ><?php echo normaliza($rowU['descripcion'],94); ?></td>
                            <td class="datos"><?php echo $rowU["monto_anticipo"]; ?></td>
                        </tr>
                    <?php
                }else{
                    ?>
                        <tr>
                            <td colspan="5" width="50" class="datos"  ><b>Descripción</b></td> 
                        </tr>
                        <tr>
                            <td colspan="5" class="datos" ><?php echo normaliza($rowU['descripcion'],94); ?></td>
                        </tr>
                    <?php
                }
            }else{
                ?>
                    <tr>
                        <td colspan="5" width="50" class="datos"  ><b>Descripción</b></td> 
                    </tr>
                    <tr>
                        <td colspan="5" class="datos" ><?php echo normaliza($rowU['descripcion'],94); ?></td>
                    </tr>
                <?php
            }
        ?>
</table>
   <br>
   <table width="710" class="borde_tabla2">
    <thead>
        <tr class="encabezado" cellspacin="5" cellpading="5">
        <td width="250"><strong>Familia Gastos/Familia/<br>
                        Línea/Concepto/<br>
                        Descripción/Justificación</strong></td>
        <td width="70"><strong>Cantidad</strong></td>
        <td width="50"><strong>% IVA</strong></td>
        <td width="85"><strong>Precio U.</strong></td>
        <td width="80"><strong>Descuento U.</strong></td>
        <td width="80"><strong>Descuento T.</strong></td>
        <td width="90"><strong>Importe</strong></td>
        </tr>
    </thead>
    <tbody>
<?php

  $queryD = "SELECT 
  requisiciones_d.id_producto,
  requisiciones_d.id_linea,
  requisiciones_d.id_familia,
  requisiciones_d.cantidad,
  requisiciones_d.justificacion,
  productos.clave,
  requisiciones_d.costo_unitario AS costo,
  productos.talla AS verifica_talla,
  0 AS descuento,
  requisiciones_d.iva AS iva,
  (requisiciones_d.cantidad*requisiciones_d.costo_unitario)AS importe,
  UPPER(CONCAT(IFNULL(fam_gastos.descr,''),' / ',IFNULL(familias.descripcion,''),' / ',IFNULL(lineas.descripcion,''),' / ',IFNULL(productos.concepto,''),' / ',IFNULL(requisiciones_d.descripcion,''),' / ',IFNULL(requisiciones_d.justificacion,''))) AS info,
  requisiciones_d.descuento_unitario,
  requisiciones_d.descuento_total
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
      //--> NJES Modificar formato de requisiciones (DEN18-2469) -- Dic/13/2019 <--//
      echo "<tr class='".$fondo."'>";
      echo "<td width='250'>- " .normaliza($rowD['info'],40)."</td>";
      echo "<td width='70' align='right'>" . $rowD['cantidad'] . "</td>";

      //GCM 26/Nov/2021 Si la unidad actual es la 6 (comercializadora) se mostraran los precios en dolares
      if(in_array($_SESSION["id_unidad_actual"],$unidadesDolares)){
        echo "<td width='50' align='right'>" . $rowD['iva'] . "</td>";
        echo "<td width='85' align='right'>" . dos_decimales(convetirPesosDolares($taza, $rowD['costo'])) . "USD</td>";
        echo "<td width='80' align='right'>" . dos_decimales(convetirPesosDolares($taza, $rowD['descuento_unitario'])) . "USD</td>";
        echo "<td width='80' align='right'>" . dos_decimales(convetirPesosDolares($taza, $rowD['descuento_total'])) . "USD</td>";
        echo "<td width='90' align='right'>" . dos_decimales(convetirPesosDolares($taza, $rowD['importe'])) . "USD</td>";
        echo "</tr>";

      }else{
        echo "<td width='50' align='right'>" . $rowD['iva'] . "</td>";
        echo "<td width='85' align='right'>" . dos_decimales($rowD['costo']) . "</td>";
        echo "<td width='80' align='right'>" . dos_decimales($rowD['descuento_unitario']) . "</td>";
        echo "<td width='80' align='right'>" . dos_decimales($rowD['descuento_total']) . "</td>";
        echo "<td width='90' align='right'>" . dos_decimales($rowD['importe']) . "</td>";
        echo "</tr>";
      }      

  }
   

?>
</tbody>
<tfoot>

        <?php
            if(in_array($_SESSION["id_unidad_actual"],$unidadesDolares)){
                ?>
                    <tr>
                        <td colspan="4" rowspan="4"><strong> Descripción General </strong><br><?php echo normaliza($rowU['descripcion'],58);?></td>
                        <td class="verde" colspan="2">Descuento </td>
                        <td class="dato"  align="right"><?php echo dos_decimales(convetirPesosDolares($taza,$rowU['descuento']))?>USD</td>    
                    </tr>
                    <tr>
                        <td class="verde" colspan="2">SubTotal </td>
                        <td class="dato"  align="right"><?php echo dos_decimales(convetirPesosDolares($taza,$rowU['subtotal']))?>USD</td>    
                    </tr>
                    <tr>
                        
                        <td class="verde" colspan="2">Iva </td>
                        <td class="dato"  align="right"><?php echo dos_decimales(convetirPesosDolares($taza,$rowU['iva']))?>USD</td>    
                    </tr>
                    <tr>
                        
                        <td class="verde" colspan="2">Total </td>
                        <td class="dato" align="right"><?php echo dos_decimales(convetirPesosDolares($taza,$rowU['total']))?>USD</td>    
                    </tr>
                <?php
            }else{
                ?>
                    <tr>
                        <td colspan="4" rowspan="4"><strong> Descripción General </strong><br><?php echo normaliza($rowU['descripcion'],58);?></td>
                        <td class="verde" colspan="2">Descuento </td>
                        <td class="dato"  align="right"><?php echo dos_decimales($rowU['descuento'])?></td>    
                    </tr>
                    <tr>
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
                <?php
            }
        ?>
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

//GCM 26/Nov/2021 Funcion para convertir de pesos a dolares
function currencyConverter($fromCurrency,$toCurrency) {	
	$fromCurrency = urlencode($fromCurrency);
	$toCurrency = urlencode($toCurrency);	
	$url  = "https://www.google.com/search?q=".$fromCurrency."+to+".$toCurrency;
	$get = file_get_contents($url);
	$data = preg_split('/\D\s(.*?)\s=\s/',$get);
	$exhangeRate = (float) substr($data[1],0,7);
	$data = array( 'exhangeRate' => $exhangeRate,
 'fromCurrency' => strtoupper($fromCurrency), 'toCurrency' => strtoupper($toCurrency));
	return( $data );	
}

function convetirPesosDolares($taza, $cantidad){

    return $taza*$cantidad;

}

?>