<?php 
session_start();
include("../php/conectar.php");
$link = Conectarse();
$linkCFDI = ConectarseCFDI();
include("../widgets/numerosLetras.php");
include('../widgets/phpqrcode/qrlib.php');

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idFactura = $arreglo['idRegistro'];
$tipo_factura = $arreglo['nombreArchivo'];
$tipoAr = $arreglo['tipoAr'];

if($tipoAr == 'nota_credito')
{
    $folioOpc = ' a.folio_nota_credito AS folio,';
	$folioFac = ' a.id_factura_nota_credito AS id_factura_nota_credito,';
}else{
	$folioOpc = ' a.folio AS folio,';
	$folioFac = '';
}

// Informacion de la empresa 
$query = "SELECT a.id,
            e.nombre AS unidad_negocio,
            e.logo,
            d.descr AS sucursal,
            a.id_sucursal,
            $folioOpc
            $folioFac
            IFNULL(n.uuid_timbre,'') AS folio_fiscal,
            IFNULL(n.no_cert_cfdi,'') AS certificado_cfdi,
            IFNULL(n.no_cert_timbre,'') AS certificado_timbre,
            IFNULL(n.sello_cfdi,'') AS sello_cfdi,
            IFNULL(n.sello_timbre,'') AS sello_timbre,
            IFNULL(n.cadena_cfdi,'') AS cadena_cfdi,
            IFNULL(n.fecha_timbre,'') AS fecha_timbre,
            IFNULL(n.hora_timbre,'') AS hora_timbre,
            a.razon_social AS razon_social_receptor,
            a.rfc_razon_social AS rfc_receptor,
            CONCAT(a.uso_cfdi,' ',f.descripcion) AS uso_cfdi,
            CONCAT(a.metodo_pago,' ',g.descripcion) AS metodo_pago,
            CONCAT(a.forma_pago,' ',h.descripcion) AS forma_pago,
            a.digitos_cuenta,
            a.porcentaje_iva,
            a.subtotal,
            a.iva,
            a.importe_retencion,
            (a.total-a.importe_retencion) AS total,
            a.retencion,
            a.id_factura_cfdi,a.fecha_inicio,a.fecha_fin,
            b.rfc AS rfc_emisor,
            n.xml_timbre AS xml_timbre,
            b.id_empresa,
            b.razon_social AS empresa_fiscal_emisor,
            CONCAT(b.calle,' ',b.num_ext,', ',b.colonia,' C.P.',b.cp,'. ',i.municipio,', ',j.estado,', México.') AS direccion_emisor,
            CONCAT_WS('' , k.domicilio, ' ', k.no_exterior, IF( k.no_interior != '',CONCAT_WS(' ', 'Int.',k.no_interior),' '), k.colonia,' ',' C.P.',k.codigo_postal,'. ', IF(l.municipio != ' ', CONCAT_WS(' ', l.municipio, ', ') , ' ' ), IF(m.estado != ' ', CONCAT_WS(' ', m.estado, ', ') , ' ' ), p.pais) AS direccion_receptor,
            CONCAT(i.municipio,', ',j.estado,', México., C.P. ', b.cp) AS lugar_exp,
            b.regimenfiscal
        FROM facturas a
        LEFT JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
        LEFT JOIN cat_clientes c ON a.id_cliente=c.id
        INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
        INNER JOIN cat_unidades_negocio e ON a.id_unidad_negocio=e.id
        LEFT JOIN cat_uso_cfdi f ON a.uso_cfdi=f.clave 
            LEFT JOIN cat_metodo_pago g ON a.metodo_pago=g.clave 
            LEFT JOIN cat_formas_pago h ON a.forma_pago=h.clave
        LEFT JOIN municipios i ON b.id_municipio=i.id
        LEFT JOIN estados j ON b.id_estado=j.id
        LEFT JOIN razones_sociales k ON a.id_razon_social=k.id
        LEFT JOIN municipios l ON k.id_municipio=l.id
        LEFT JOIN estados m ON k.id_estado=m.id
        LEFT JOIN paises p ON k.id_pais=p.id
        LEFT JOIN facturas_cfdi n ON a.id=n.id_factura
        WHERE a.id=".$idFactura;

// echo $query;
// exit();


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
$uso_cfdi = $row['uso_cfdi'];
$rfc_receptor = $row['rfc_receptor'];
$razon_social_receptor = $row['razon_social_receptor'];
$direccion_receptor = $row['direccion_receptor'];
$id_empresa = $row['id_empresa'];
//$subtotal = $row['subtotal'];
//$iva = $row['iva'];
//$total = $row['total'];
//$retencion = $row['importe_retencion'];
$bandera_retencion = $row['retencion'];
$digitos_cuenta = $row['digitos_cuenta'];
$folio_fiscal = $row['folio_fiscal'];
$certificado_timbre = $row['certificado_timbre'];
$certificado_cfdi = $row['certificado_cfdi'];
$sello_cfdi = $row['sello_cfdi'];
$sello_timbre = $row['sello_timbre'];
$cadena_cfdi = $row['cadena_cfdi'];
$hora_timbre = $row['hora_timbre'];
$fecha_timbre = $row['fecha_timbre'];
$lugar_exp = $row['lugar_exp'];
$xml = $row['xml_timbre'];
$porcentaje_iva = $row['porcentaje_iva'];
$regimenfiscal = $row['regimenfiscal'];
$sEmisor = substr($row['sello_cfdi'], -8); 

if($porcentaje_iva == 16)
    $porcentaje_retencion = 6;
else
    $porcentaje_retencion = 3;

$id_sucursal = $row['id_sucursal'];

//-->NJES May/25/2021   
$idFacturaCFDI = $row['id_factura_cfdi'];
$queryCFDI = "SELECT subtotal, iva, moneda, tcambio, importe_retencion
            FROM factura_e
            WHERE registro =".$idFacturaCFDI;
$consultaCFDI = mysqli_query($linkCFDI,$queryCFDI);
$rowCDFI = mysqli_fetch_array($consultaCFDI);

$subtotal = $rowCDFI['subtotal'];
$iva = $rowCDFI['iva'];
$total = ($rowCDFI['subtotal']+$rowCDFI['iva'])-$rowCDFI['importe_retencion'];
$retencion = $rowCDFI['importe_retencion'];
$moneda = $rowCDFI['moneda'];
$tipoCambio = $rowCDFI['tcambio'];

if($xml != null){
    $sxml = simplexml_load_string($xml);
    $sxml->registerXPathNamespace('c','http://www.sat.gob.mx/cfd/3');

    $comprobanteA = (array)$sxml->xpath('//c:Comprobante');
    $comprobante = $comprobanteA[0];

    $cbb = sprintf("https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?fe=%s&re=%s&rr=%s&tt=%s&id=%s", $sEmisor, $rfc_emisor, $rfc_receptor, $comprobante['Total'], $folio_fiscal);
    QRcode::png($cbb,'../facturacion/qr/'.$idFactura.'.png');
}

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
    #div_detalle{
        height:360px;
        border:1px;
        width:773px;
    }
    .lab_bold{
        font-weight:bold;
    }
    .borde_right{
        border-right:1px;
    }
    .border_bottom th {
        border-bottom:1pt solid black;
    }
    .font_light_sello{
        font-weight:lighter;
        text-align:justify;
        font-size:8px;
    }
</style>
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="23mm"  backbottom="2mm">
<page_header footer='page'>
<table>
    <tr>
        <?php
        $carpeta = "../imagenes/".$logo;
        if(file_exists($carpeta))
        {
        ?>
            <!--NJES March/24/2021 si la sucursal es SEYCOM mostrar ese logo tambien-->
            <?php if($id_sucursal == 57) {?>
                <td width="150" align="top">
            <?php }else{ ?>
                <td width="150" align="top">
            <?php } ?>
            <?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?></td>
        <?php
        }else{
        ?>
            <td width="165"></td>
        <?php
        } 
        ?>
        <?php if($id_sucursal == 57) {?>
            <?php if($tipo_factura != 'Prefactura') { ?>
                <td width="240" style="font-weight:bold;">
            <?php }else{ ?>
            <td width="320" style="font-weight:bold;">
            <?php } ?>
        <?php }else{ ?>
            <td width="335" style="font-weight:bold;">
        <?php } ?>
            DATOS DEL EMISOR <br>
            <!--<div class="font_light">SUCURSAL: <?php echo strtoupper($sucursal); ?></div>-->
            <label id="dato_rfc" class="font_light"><?php echo strtoupper($rfc_emisor); ?></label><br>
            <label id="dato_empresa" class="font_light"><?php echo strtoupper($empresa_fiscal_emisor); ?></label><br>
            <label id="dato_direccion" class="font_light"><?php echo $direccion_emisor; ?></label>
            <?php
                if($id_empresa == 2){
                    ?>
                        <br><label id="dato_rfc" class="font_light">R.E.P.S.E. - No. DE FOLIO DE INGRESO: 2778</label><br>
                        <label id="dato_rfc" class="font_light">No. DE ACUERDO: STPS/UTD/DGIFT/AR1876/2021</label><br>
                    <?php
                }
            ?>
        </td>
        
        <?php if($id_sucursal == 57) {?>
            <td width="120" align="top">
                <?php echo '<img src="../imagenes/seycom.png"  width="120"/>';?>
            </td>
            <td width="150">
        <?php }else{ ?>
            <td width="270">
        <?php } ?>
            <table align="right">
                <tr>
                	<td align="right" class="font_light">Página [[page_cu]] de [[page_nb]]</td>
                </tr>
                <tr>
                    <td align="center" class="bordePad" ><?php echo strtoupper($tipo_factura); ?></td>
                </tr>
                <?php if($tipo_factura != 'Prefactura') { ?>
                <tr>
                    <td class="bordePad" style="height:23px;">FOLIO FISCAL<br><br>
                        <label id="dato_folio_fiscal" class="font_light"><?php echo $folio_fiscal; ?></label>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>
</page_header>
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
<?php if($tipo_factura != 'Prefactura') { ?>
<table class="bordePad">
    <tr>
        <td width="250">NO. DE SERIE DEL CERTIFICADO DEL SAT <br>
            <label class="font_light"><?php echo $certificado_timbre;  ?></label>
        </td>
        <td width="250">NO. DE SERIE DEL CERTIFICADO DEL CSD <br>
            <label class="font_light"><?php echo $certificado_cfdi;  ?></label>
        </td>
        <td width="246">LUGAR, FECHA Y HORA DE EXPEDICION <br>
            <label class="font_light"><?php echo $lugar_exp; ?> <?php echo $fecha_timbre .' '. $hora_timbre; ?></label>
        </td>
    </tr>
</table>
<?php } ?>
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
        <?php if($tipo_factura != 'Prefactura') { ?>
            FECHA Y HORA DE CERTIFICACIÓN<br>
            <label class="font_light"><?php echo $fecha_timbre .' '. $hora_timbre; ?></label><br><br>
        <?php } ?>
            <label>PAGO EN </label><label class="font_light"></label><br>
            <label>NO DE CUENTA </label> <label class="font_light"> <?php echo $digitos_cuenta; ?></label><br>
            <label>MONEDA </label> <label class="font_light"> <?php echo $moneda; ?></label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>TIPO DE CAMBIO </label> <label class="font_light"> <?php echo $tipoCambio; ?></label>
        </td>
    </tr>
</table>
<?php if($tipoAr == 'nota_credito'){
    $buscaCFDI_R="SELECT IFNULL(n.uuid_timbre,'') AS folio_fiscal_relacionado,a.folio AS folio_interno_relacion
                    FROM facturas a
                    LEFT JOIN facturas_cfdi n ON a.id=n.id_factura
                    WHERE a.id=".$row['id_factura_nota_credito'];
    $consultaB = mysqli_query($link,$buscaCFDI_R);
    $rowB = mysqli_fetch_array($consultaB);
    $cfdi_relacionado = $rowB['folio_fiscal_relacionado'];
    $folio_interno_relacion = $rowB['folio_interno_relacion'];
?>
<table>
    <tr>
        <td class="bordePad" colspan="2">CFDI relacionado</td>
    </tr>
    <tr>
        <td width="582" class="bordePad">UUID 
        <label class="font_light"><?php echo $cfdi_relacionado;?></label></td>
        <td width="155" class="bordePad">Folio Interno 
        <label class="font_light"><?php echo '  '.$folio_interno_relacion;?></label></td>
    </tr>
</table>
<?php }?>
<div id="div_detalle">
    <table>
        <tr class="border_bottom">
            <th width="85" class="borde_right">CLAVE PRODUCTO</th>
            <th width="80" class="borde_right">CANTIDAD</th>
            <th width="105" class="borde_right">UNIDAD</th>
            <th width="246" class="borde_right">DESCRIPCIÓN</th>
            <th width="90" class="borde_right">PRECIO UNITARIO</th>
            <th width="110">IMPORTE</th>
        </tr>
        <tbody>
        <?php
            /*$query_detalle="SELECT a.id,a.cantidad,a.precio_unitario,(((a.cantidad*a.precio_unitario)*b.porcentaje_iva)/100) AS iva,
                            ((a.importe*6)/100) AS importe_retencion,
                            (((a.importe*b.porcentaje_iva)/100)+a.importe) AS importeII,
                            (a.importe) AS importe,
                            a.descripcion,a.clave_unidad_sat,a.unidad_sat,
                            a.clave_producto_sat,a.producto_sat,a.id_cxc
                            FROM facturas_d a
                            INNER JOIN facturas b ON a.id_factura=b.id 
                            WHERE a.id_factura=$idFactura
                            ORDER BY a.id ASC";*/
            $query_detalle="SELECT clave_prod_serv AS clave_producto_sat,
                            clave_unidad AS clave_unidad_sat,unidad AS unidad_sat,
                            concepto AS descripcion,
                            precio_unitario,cantidad,
                            precio_unitario*cantidad AS importe
                            FROM factura_d
                            WHERE registro_e=".$idFacturaCFDI;

            $result = mysqli_query($linkCFDI,$query_detalle);
            $num_rows = mysqli_num_rows($result);
            if($num_rows > 0)
            {
                while ($dato = mysqli_fetch_array($result))
                {

                    $importe = num_2dec($dato['precio_unitario'])*$dato['cantidad'];
            
                echo "<tr>
                    <td width='80' class='borde_right'>".normaliza($dato['clave_producto_sat'],12)."</td>
                    <td width='85' class='borde_right' align='right'>".seis_decimales_cant($dato['cantidad'])."</td>
                    <td width='113' class='borde_right'>".normaliza($dato['clave_unidad_sat'].' '.$dato['unidad_sat'],17)."</td>
                    <td width='246' class='borde_right'>".normaliza(strtoupper($dato['descripcion']),36)."</td>
                    <td width='80'  class='borde_right' align='right'>".seis_decimales(num_2dec($dato['precio_unitario']))."</td>
                    <td width='110' align='right'>".seis_decimales(num_2dec($importe))."</td>
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
                <label class="font_light"><?php echo numtoletras($total); ?></label>
            <?php }else {?>
                <label class="font_light"><?php echo numtoletrasUsd($total); ?></label>
            <?php }?>
        </td>
        <td width="173" class="bordePad">
            <table>
                <tr>
                    <td width="70">Subtotal</td>
                    <td width="90" class="font_light" align="right"><?php echo dos_decimales($subtotal); ?></td>
                </tr>
                <tr>
                    <td>Iva</td>
                    <td class="font_light" align="right"><?php echo dos_decimales($iva); ?></td>
                </tr>
                <?php
                if($bandera_retencion == 1)
                {
                ?>
                <tr>
                    <td>Retención</td>
                    <td class="font_light" align="right"><?php echo dos_decimales($retencion); ?></td>
                </tr>
                <tr>
                    <td>% retención</td>
                    <td class="font_light" align="right"><?php echo $porcentaje_retencion.'%'; ?></td>
                </tr>
                <?php }?>
                <tr>
                <?php if($moneda == 'MXN'){ ?>
                    <td>Total MXN</td>
                <?php }else {?>
                    <td>Total USD</td>
                <?php }?>
                    <td class="font_light" align="right"><?php echo dos_decimales($total); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php if($tipo_factura == 'Factura') { ?>
<label class="font_light_sello" style="font-size:11px;">Este documento es una representación impresa de un CFDI</label>
<table>
    <tr>
        <td width="165" align="center" style="vertical-align:middle;">
            <?php echo '<img src="../facturacion/qr/'.$idFactura.'.png"/>';?>
        </td>
        <td width="570">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="lab_bold">Sello Digital del CFDI<br>
                        <label class="font_light_sello"><?php echo normaliza($sello_cfdi,120); ?></label>
                    </td>
                </tr>
                <tr>
                    <td class="lab_bold">Sello SAT<br>
                        <label class="font_light_sello"><?php echo normaliza($sello_timbre,120); ?></label>
                    </td>
                </tr>
                <tr>
                    <td class="lab_bold">Cadena Original del complemento de certificación digital del SAT<br>
                        <label class="font_light_sello"><?php echo normaliza($cadena_cfdi,130); ?></label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php }else{?>
    <label class="font_light" style="font-size:11px;">Este documento no representa un comprobante fiscal digital</label>
<?php } ?>
<page_footer style="text-align:right; font-size:10px;">
    [[page_cu]]/[[page_nb]]
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

function seis_decimales($number, $fractional=true) { 
    if ($fractional) { 
        $number = sprintf('%.6f', $number); 
    } 
    $pos = strpos($number, '.');
    $numero = substr($number, 0, $pos);
    $decimal = substr($number, $pos);
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $numero); 
        if ($replaced != $numero) { 
            $numero = $replaced; 
        } else { 
            break; 
        } 
    } 
    return '$ '.$numero.''.$decimal; 
}

function seis_decimales_cant($number, $fractional=true) { 
    if ($fractional) { 
        $number = sprintf('%.6f', $number); 
    } 
    $pos = strpos($number, '.');
    $numero = substr($number, 0, $pos);
    $decimal = substr($number, $pos);
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $numero); 
        if ($replaced != $numero) { 
            $numero = $replaced; 
        } else { 
            break; 
        } 
    } 
    return $numero.''.$decimal; 
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

function num_2dec($numero)
{
    return number_format($numero, 2, '.', '');
}
?>
