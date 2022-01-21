<?php 
session_start();
include("../php/conectar.php");
$link = Conectarse();
include("../widgets/numerosLetras.php");
include('../widgets/phpqrcode/qrlib.php');

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idPago = $arreglo['idRegistro'];
$tipo_pago = $arreglo['nombreArchivo'];

$verRelacionAbonos = $arreglo['verRelacionAbonos'];

// Informacion de la empresa 
$query = "SELECT a.id,e.nombre AS unidad_negocio,
e.logo,
d.descr AS sucursal,
a.folio AS folio,
a.rfc_cliente AS rfc_receptor,
b.rfc AS rfc_emisor,
IFNULL(n.uuid_timbre,'') AS folio_fiscal,
IFNULL(n.no_cert_cfdi,'') AS certificado_cfdi,
IFNULL(n.no_cert_timbre,'') AS certificado_timbre,
IFNULL(n.sello_cfdi,'') AS sello_cfdi,
IFNULL(n.sello_timbre,'') AS sello_timbre,
IFNULL(n.cadena_cfdi,'') AS cadena_cfdi,
IFNULL(n.fecha_timbre,'') AS fecha_timbre,
IFNULL(n.hora_timbre,'') AS hora_timbre,
a.razon_cliente,
a.rfc_cliente,
CONCAT(a.metodo_pago,' ',g.descripcion) AS metodo_pago,
CONCAT(a.forma_pago,' ',h.descripcion) AS forma_pago,
a.id_pago_cfdi,
IFNULL(a.banco_cliente,'') AS banco_cliente,
IFNULL(a.cuenta_cliente,'') AS cuenta_cliente,
p.fecha_pago,

n.xml_timbre AS xml_timbre,
b.razon_social AS empresa_fiscal,
CONCAT(b.calle,' ',b.num_ext,', ',b.colonia,' C.P.',b.cp,'. ',i.municipio,', ',j.estado,', México.') AS direccion_emisor,
IF(e.nombre='ALARMAS',CONCAT(q.domicilio,' ',q.no_exterior,' ',IF(q.no_interior != '',CONCAT('Int.',q.no_exterior),' '),', ',q.colonia,' ',' C.P.',q.codigo_postal,'. ',r.municipio,', ',s.estado,', México.'),CONCAT(k.domicilio,' ',k.no_exterior,' ',IF(k.no_interior != '',CONCAT('Int.',k.no_exterior),' '),', ',k.colonia,' ',' C.P.',k.codigo_postal,'. ',l.municipio,', ',m.estado,', México.')) AS direccion_receptor,
IF(e.nombre='ALARMAS',CONCAT(r.municipio,', ',s.estado,', México.',' C.P. ',q.codigo_postal),CONCAT(l.municipio,', ',m.estado,', México.',' C.P. ',k.codigo_postal)) AS lugar_exp,
o.folio_factura,p.monto_pago,p.monto_pago_usd,p.moneda,p.tipo_cambio,
a.id_sucursal,
b.regimenfiscal
FROM pagos_e a
LEFT JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
LEFT JOIN cat_clientes c ON a.id_cliente=c.id
INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
INNER JOIN cat_unidades_negocio e ON a.id_unidad_negocio=e.id
INNER JOIN cat_metodo_pago g ON a.metodo_pago=g.clave
INNER JOIN cat_formas_pago h ON a.forma_pago=h.clave
LEFT JOIN municipios i ON b.id_municipio=i.id
LEFT JOIN estados j ON b.id_estado=j.id
LEFT JOIN razones_sociales k ON a.id_razon_social=k.id
LEFT JOIN municipios l ON k.id_municipio=l.id
LEFT JOIN estados m ON k.id_estado=m.id
LEFT JOIN pagos_cfdi n ON a.id=n.id_pago_e
LEFT JOIN pagos_d o ON a.id=o.id_pago_e
LEFT JOIN pagos_p p ON a.id=p.id_pago_e
LEFT JOIN servicios q ON a.id_razon_social=q.id
LEFT JOIN municipios r ON q.id_municipio=r.id
LEFT JOIN estados s ON q.id_estado=s.id
WHERE a.id=".$idPago;

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$logo = $row['logo'];
$folio = $row['folio'];
$unidad_negocio = $row['unidad_negocio'];
$sucursal = $row['sucursal'];
$rfc_emisor = $row['rfc_emisor'];
$empresa_fiscal_emisor = $row['empresa_fiscal_emisor'];
$direccion_emisor = $row['direccion_emisor'];
$metodo_pago = $row['metodo_pago'];
$forma_pago = $row['forma_pago'];
$uso_cfdi = 'P01 Por definir';
$rfc_receptor = $row['rfc_receptor'];
$razon_social_receptor = $row['razon_cliente'];
$direccion_receptor = $row['direccion_receptor'];
$folio_fiscal = $row['folio_fiscal'];
$certificado_timbre = $row['certificado_timbre'];
$certificado_cfdi = $row['certificado_cfdi'];
$sello_cfdi = $row['sello_cfdi'];
$sello_timbre = $row['sello_timbre'];
$cadena_cfdi = $row['cadena_cfdi'];
$hora_timbre = $row['hora_timbre'];
$fecha_timbre = $row['fecha_timbre'];
$lugar_exp = $row['lugar_exp'];
$fecha_pago = $row['fecha_pago'];
$banco_cliente = $row['banco_cliente'];
$cuenta_cliente = $row['cuenta_cliente'];
$monto_pago = $row['monto_pago'];
$regimenfiscal = $row['regimenfiscal'];

if($row['moneda'] == 'MXN')
    $monto_pago = $row['monto_pago'];
else
    $monto_pago = $row['monto_pago_usd'];

$moneda = $row['moneda'];
$tipoCambio = $row['tipo_cambio'];

$xml = $row['xml_timbre'];

$sEmisor = substr($row['sello_cfdi'], -8); 

$id_sucursal = $row['id_sucursal'];

$cbb = sprintf("https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?fe=%s&re=%s&rr=%s&tt=%s&id=%s", $sEmisor, $rfc_emisor, $rfc_receptor, '0', $folio_fiscal);
QRcode::png($cbb,'../pagos/qr/'.$idPago.'.png');

?>
<style>
    table{
        font-size:11px;
        vertical-align:top;
    }
    .font_light{
        font-weight:lighter;
    }
    .bordePad{
        border:1px;
        font-weight:bold;
        padding:5px 1px 5px 5px;
    }
    .bordePadSeg{
        border:1px;
        font-weight:bold;
        padding:1px 2px 2px 4px;
    }
    #div_relacion_abonos{
        border:1px;
        width:773px;
        margin-bottom:5px;
    }
    #div_detalle{
        height:300px;
        border:1px;
        width:773px;
    }
    #div_detalle2{
        height:50px;
        border:1px;
        width:773px;
        padding:0;
        margin-bottom:5px;
    }
    .lab_bold{
        font-weight:bold;
    }
    .borde_right{
        border-right:1px;
    }
    .borde_left{
        border-left:1px;
    }
    .border_bottom th {
        border-bottom:1pt solid black;
    }
    .border_top{
        border-top:1pt solid black;
    }
</style>
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="1mm"  backbottom="2mm">
<table>
    <tr>
        <!--NJES March/24/2021 si la sucursal es SEYCOM mostrar ese logo tambien-->
        <?php if($id_sucursal == 57) {?>
            <td width="150" align="top">
        <?php }else{ ?>
            <td width="165" align="top">
        <?php } ?>
        <?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?></td>

        <?php if($id_sucursal == 57) {?>
            <td width="250" style="font-weight:bold;">
        <?php }else{ ?>
            <td width="330" style="font-weight:bold;">
        <?php } ?>
            DATOS DEL EMISOR <br>
            <div class="font_light">SUCURSAL: <?php echo strtoupper($sucursal); ?></div>
            <label id="dato_rfc" class="font_light"><?php echo strtoupper($rfc_emisor); ?></label><br>
            <label id="dato_empresa" class="font_light"><?php echo strtoupper($empresa_fiscal_emisor); ?></label><br>
            <label id="dato_direccion" class="font_light"><?php echo $direccion_emisor; ?></label>
        </td>

        <?php if($id_sucursal == 57) {?>
            <td width="120" align="top">
                <?php echo '<img src="../imagenes/seycom.png"  width="120"/>';?>
            </td>
            <td width="200">
        <?php }else{ ?>
            <td width="260">
        <?php } ?>
            <table align="right">
                <tr>
                	<td align="right" class="font_light">Página [[page_cu]] de [[page_nb]]</td>
                </tr>
                <tr>
                    <td width="110" align="center" class="bordePad" ><?php echo strtoupper($tipo_pago); ?></td>
                </tr>
                <tr>
                    <td class="bordePad" style="height:23px;">FOLIO FISCAL<br><br>
                        <label id="dato_folio_fiscal" class="font_light"><?php echo $folio_fiscal; ?></label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php



        if($xml != null)
        {

            $sxml = simplexml_load_string($xml);
            $sxml->registerXPathNamespace('c','http://www.sat.gob.mx/cfd/3');//Declaramos el Name Space cfdi como c
            $comprobante = (array)$sxml->xpath('//c:Comprobante');//Obtenemos el array de cfdi:Comprobante
            $comprobante_data = $comprobante[0];

            $relacionados = $sxml->xpath('//c:CfdiRelacionados');//Obtenemos el array de cfdi:Emisor
            $relacionado = $sxml->xpath('//c:CfdiRelacionado');

            $tipoR = $relacionados[0];


            if(count($relacionados) > 0)
            {


                echo "CFDI RELACIONADOS<table class='bordePad'  width='100%'>";

                 foreach($relacionado as $r)
                {
                    echo "<tr>";
                    echo "<td  width='50%'><b>Tipo de Relación: </b>" . $tipoR['TipoRelacion']  . "</td>";
                    echo "<td  width='10'></td>";
                    echo "<td  width='50%'><b>CFDI Relacionado: </b>" . $r['UUID'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                
            }

        }

        

        ?>
        <br>
<table class="bordePad">
    <tr>
        <td width="250">NO. DE SERIE DEL CERTIFICADO DEL SAT <br>
            <label class="font_light"><?php echo $certificado_timbre;  ?></label>
        </td>
        <td width="250">NO. DE SERIE DEL CERTIFICADO DEL CSD <br>
            <label class="font_light"><?php echo $certificado_cfdi;  ?></label>
        </td>
        <td width="246">LUGAR, FECHA Y HORA DE EXPEDICION <br>
            <label class="font_light"><?php echo $lugar_exp; ?> <?php echo $fecha_timbre .'T'. $hora_timbre; ?></label>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td width="132" class="bordePadSeg">SERIE Y FOLIO<br>
            <div class="font_light" align="right" style="font-size:14px;"> <?php echo $folio; ?></div>
        </td>
        <td width="132" class="bordePadSeg">REGIMEN FISCAL<br>
            <label class="font_light"><?php echo $regimenfiscal; ?></label>
        </td>
        <td width="132"class="bordePadSeg">METODO DE PAGO<br>
            <label class="font_light"><?php echo $metodo_pago; ?></label>
        </td>
        <td width="143" class="bordePadSeg">FORMA DE PAGO<br>
            <label class="font_light"><?php echo $forma_pago; ?></label>
        </td>
        <td width="143" class="bordePadSeg">USO DE CFDI<br>
            <label class="font_light"><?php echo $uso_cfdi; ?></label>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td width="432" class="bordePad">DATOS DEL RECEPTOR<br>
            <label class="font_light"><?php echo strtoupper($rfc_receptor); ?></label><br>
            <label class="font_light"><?php echo $razon_social_receptor; ?></label><br>
            <label class="font_light"><?php echo $direccion_receptor; ?></label>
        </td>
        <td width="305" class="bordePad">
            FECHA Y HORA DE CERTIFICACIÓN<br>
            <label class="font_light"><?php echo $fecha_timbre .' '. $hora_timbre; ?></label><br>
            <label>FECHA APLICACIÓN DEL PAGO </label><label class="font_light"><?php echo $fecha_pago; ?></label><br>
            <label>BANCO CLIENTE </label><label class="font_light"><?php echo $banco_cliente; ?></label><br>
            <label>NÚMERO DE CUENTA DEL CLIENTE </label><label class="font_light"><?php echo $cuenta_cliente; ?></label><br>
            <!--<label>PAGO EN </label><label class="font_light"></label><br>
            <label>NO DE CUENTA </label> <label class="font_light"></label><br>-->
            <label>MONEDA </label> <label class="font_light"> <?php echo $moneda; ?></label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>TIPO DE CAMBIO </label> <label class="font_light"> <?php echo $tipoCambio; ?></label>
        </td>
    </tr>
</table>
<div id="div_detalle2">
    <table>
        <tr class="border_bottom">
            <th width="85" class="borde_right">CLAVE PRODUCTO</th>
            <th width="80" class="borde_right">CANTIDAD</th>
            <th width="85" class="borde_right">UNIDAD</th>
            <th width="320" class="borde_right">DESCRIPCIÓN</th>
            <th width="85" class="borde_right">PRECIO UNITARIO</th>
            <th width="80">IMPORTE</th>
        </tr>
        <tbody>
            <tr>
                <td width="80" class="borde_right">84111506</td>
                <td width="80" align="center" class="borde_right">1</td>
                <td width="80" align="center" class="borde_right">ACT</td>
                <td width="320" class="borde_right">Pago</td>
                <td width="80" align="center" class="borde_right">0.00</td>
                <td width="80" align="right">0.00</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table style="border-top:1px solid black;">
        <tr>
            <td width="586" style="border-right:1px solid black;">TOTAL CON LETRA <br>
                <label class="font_light">TOTALCERO <?php echo $moneda; ?> 00/100</label>
            </td>
            <td width="150">
                <table>
                    <tr>
                        <td width="70">Subtotal</td>
                        <td width="80" class="font_light" align="right">0.00</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td class="font_light" align="right">0.00</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<?php if($verRelacionAbonos == 'SI')
{?>

<div id="div_relacion_abonos">
    <table>
        <tr>
            <td colspan="6" style="border-bottom:1px solid black; font-weight:bold; padding:5px 2px 10px 2px;">Abonos relacionado a facturas</td>
        </tr>
        <tr class="border_bottom">
            <th width="80" class="borde_right">FACTURA</th>
            <th width="110" class="borde_right">TIPO</th>
            <th width="80" class="borde_right">FOLIO</th>
            <th width="245" class="borde_right">UUID</th>
            <th width="112" class="borde_right">IMPORTE</th>
            <th width="121" >TOTAL</th>
        </tr>
    </table>
    <table>
        <tr>
            <?php
                $query_ids_factura="SELECT id_factura,folio_factura FROM pagos_d WHERE id_pago_e=".$idPago;
                $result_ids = mysqli_query($link,$query_ids_factura);
                $num_rows_ids = mysqli_num_rows($result_ids);
                if($num_rows_ids > 0)
                {
                    for ($j=0;$j<$num_rows_ids;$j++)
                    {
                        $dato_ids = mysqli_fetch_array($result_ids);

                        $id_factura = $dato_ids['id_factura'];
                        $folio_factura = $dato_ids['folio_factura'];
                        $total = 0;

                        $query_r = "SELECT a.folio AS factura,'Nota de Credito' AS tipo,a.folio,
                                    (a.total-a.importe_retencion) AS importe,
                                    (a.total_usd-a.importe_retencion_usd) AS importe_usd,
                                    b.uuid_timbre AS uuid 
                                    FROM facturas a
                                    LEFT JOIN facturas_cfdi b ON a.id=b.id_factura
                                    WHERE id_factura_nota_credito=$id_factura AND a.estatus='T'
                                    UNION ALL
                                    SELECT pagos_d.folio_factura AS factura,'Pago' AS tipo, pagos_e.folio,
                                    pagos_d.importe_pagado AS importe,
                                    pagos_d.importe_pagado_usd AS importe_usd,
                                    pagos_cfdi.uuid_timbre AS uuid
                                    FROM pagos_d 
                                    LEFT JOIN pagos_e ON pagos_d.id_pago_e=pagos_e.id
                                    LEFT JOIN pagos_cfdi ON pagos_e.id=pagos_cfdi.id_pago_e
                                    WHERE id_factura=$id_factura AND pagos_e.estatus IN ('A','T')";
                        $result_r = mysqli_query($link,$query_r);
                        $num_rows_r = mysqli_num_rows($result_r);
                        if($num_rows_r > 0)
                        {
                            if($j == 0)
                                $border_top = '';
                            else
                                $border_top = 'border_top';

                            echo "<tr><td width='73' class='".$border_top."'>".$folio_factura."</td><td class='".$border_top."'>";
                            for ($i=0;$i<$num_rows_r;$i++)
                            {
                                $dato_r = mysqli_fetch_array($result_r);

                                if($moneda != 'MXN')
                                    $importe = $dato_r['importe_usd'];
                                else
                                    $importe = $dato_r['importe'];

                                $total = $total+$importe;

                                if($dato_r['uuid'] == '')
                                    $uuid = 'PAGO UNICO';
                                else
                                    $uuid = $dato_r['uuid'];  
                                    
                                
                                echo "<table><tr>
                                        <td width='107' class='borde_left borde_right'>".$dato_r['tipo']."</td>
                                        <td width='75' class='borde_right'>".$dato_r['folio']."</td>
                                        <td width='240' class='borde_right'>".$uuid."</td>
                                        <td width='108' class='borde_right'>".dos_decimales($importe)."</td>
                                    </tr></table>";    
                            }
                            echo "</td><td width='121' class='".$border_top."'>".dos_decimales($total)."</td></tr>";
                        }
                    }
                }
            ?>
        </tr>
    </table>
</div>
<?php }?>

<div id="div_detalle">
    <table>
        <tr>
            <td colspan="8" style="border-bottom:1px solid black; font-weight:bold; padding:5px 2px 10px 2px;">CFDI relacionado</td>
        </tr>
        <tr class="border_bottom">
            <th width="213" class="borde_right">UUID</th>
            <th width="75" class="borde_right">FOLIO</th>
            <th width="75" class="borde_right">METODO</th>
            <th width="75" class="borde_right">TOTAL</th>
            <th width="75" class="borde_right">PARCIALIDAD</th>
            <th width="75" class="borde_right">SALDO ANTERIOR</th>
            <th width="75" class="borde_right">SALDO PENDIENTE</th>
            <th width="75">MONTO PAGADO</th>
        </tr>
        <tbody>
        <?php
            $query_detalle="SELECT a.id,a.uuid_factura,a.folio_factura,a.metodo_pago,a.num_parcialidad,
            IF(a.moneda='MXN',if(b.retencion=1,b.total-b.importe_retencion,b.total),
            if(b.retencion=1,b.total_usd-b.importe_retencion_usd,b.total_usd)) AS total,
            IF(a.moneda='MXN',a.importe_saldo_anterior,a.importe_saldo_anterior_usd) AS importe_saldo_anterior,
            IF(a.moneda='MXN',a.importe_saldo_insoluto,a.importe_saldo_insoluto_usd) AS importe_saldo_insoluto,
            IF(a.moneda='MXN',a.importe_pagado,a.importe_pagado_usd) AS importe_pagado            
            FROM pagos_d a
            INNER JOIN facturas b ON a.id_factura=b.id
            WHERE a.id_pago_e=$idPago
            ORDER BY a.id ASC";
            $result = mysqli_query($link,$query_detalle);
            $num_rows = mysqli_num_rows($result);
            if($num_rows > 0)
            {
                while ($dato = mysqli_fetch_array($result))
                {
            
                echo "<tr>
                    <td width='213' class='borde_right'>".normaliza($dato['uuid_factura'],33)."</td>
                    <td width='70' class='borde_right'>".$dato['folio_factura']."</td>
                    <td width='70' class='borde_right'>".$dato['metodo_pago']."</td>
                    <td width='70' class='borde_right'>".dos_decimales($dato['total'])."</td>
                    <td width='70'  class='borde_right'>".$dato['num_parcialidad']."</td>
                    <td width='70' class='borde_right' align='right'>".dos_decimales($dato['importe_saldo_anterior'])."</td>
                    <td width='70' class='borde_right' align='right'>".dos_decimales($dato['importe_saldo_insoluto'])."</td>
                    <td width='70' align='right'>".dos_decimales($dato['importe_pagado'])."</td>
                </tr>";
            
                }
            }
        ?>
        </tbody>
    </table>
</div>
<table>
    <tr>
        <td width="563" class="bordePad">TOTAL CON LETRA <br>
            <?php if($moneda == 'MXN'){ ?>
                <label class="font_light"><?php echo numtoletras($monto_pago); ?></label>
            <?php }else {?>
                <label class="font_light"><?php echo numtoletrasUsd($monto_pago); ?></label>
            <?php }?>
        </td>
        <td width="173" class="bordePad">
            <table>
                <tr>
                    <td>Total <?php echo $moneda; ?></td>
                    <td class="font_light" align="right"><?php echo dos_decimales($monto_pago); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<label class="font_light" style="font-size:11px;">Este documento es una representación impresa de un CFDI</label>
<table>
    <tr>
        <td width="165" align="center" style="vertical-align:middle;">
            <?php echo '<img src="../pagos/qr/'.$idPago.'.png"/>';?>
        </td>
        <td width="570">
            <table>
                <tr>
                    <td width="70" class="lab_bold">Sello Digital del CFDI<br>
                        <label class="font_light"><?php echo normaliza($sello_cfdi,85); ?></label>
                    </td>
                </tr>
                <tr>
                    <td class="lab_bold">Sello SAT<br>
                        <label class="font_light"><?php echo normaliza($sello_timbre,85); ?></label><br>
                    </td>
                </tr>
                <tr>
                    <td class="lab_bold">Cadena Original del complemento de certificación digital del SAT<br>
                        <label class="font_light"><?php echo normaliza($cadena_cfdi,85); ?></label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
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
