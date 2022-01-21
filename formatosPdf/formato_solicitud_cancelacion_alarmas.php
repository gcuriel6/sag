<?php 
session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idFactura = $arreglo['idRegistro'];
$tipoAr = $arreglo['tipoAr'];

if($tipoAr == 'factura')
{
	$nombreArch = 'SOLICITUD CANCELACIÓN DE FACTURA';
	$folioOpc = ' a.folio AS folio,';
	$folioFac = '';
}else{
	$nombreArch = 'SOLICITUD DE CANCELACIÓN  DE NOTA DE CRÉDITO';
	$folioOpc = ' a.folio_nota_credito AS folio,';
}

// Informacion de la empresa 
$query = "SELECT a.id,
e.logo,
d.descr AS sucursal,
$folioOpc
IFNULL(n.uuid_timbre,'') AS folio_fiscal,
IFNULL(n.acuse,'') AS acuse,
a.razon_social AS razon_social_receptor,
b.rfc AS rfc_emisor,
b.razon_social AS empresa_fiscal_emisor,
CONCAT(b.calle,' ',b.num_ext,', ',b.colonia,' C.P.',b.cp,'. ',i.municipio,', ',j.estado,', México.') AS direccion_emisor,
CONCAT_WS('' , k.domicilio, ' ', k.no_exterior, IF( k.no_interior != '',CONCAT_WS(' ', 'Int.',k.no_interior),' '), k.colonia,' ',' C.P.',k.codigo_postal,'. ', IF(l.municipio != ' ', CONCAT_WS(' ', l.municipio, ', ') , ' ' ), IF(m.estado != ' ', CONCAT_WS(' ', m.estado, ', ') , ' ' ), ' México.') AS direccion_receptor
FROM facturas a
LEFT JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
INNER JOIN cat_unidades_negocio e ON a.id_unidad_negocio=e.id
INNER JOIN cat_uso_cfdi f ON a.uso_cfdi=f.clave
LEFT JOIN municipios i ON b.id_municipio=i.id
LEFT JOIN estados j ON b.id_estado=j.id
LEFT JOIN servicios k ON a.id_razon_social=k.id
LEFT JOIN municipios l ON k.id_municipio=l.id
LEFT JOIN estados m ON k.id_estado=m.id
LEFT JOIN facturas_cfdi n ON a.id=n.id_factura
WHERE a.id=".$idFactura;

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$logo = $row['logo'];
$folio = $row['folio'];
$sucursal = $row['sucursal'];
$rfc_emisor = $row['rfc_emisor'];
$empresa_fiscal_emisor = $row['empresa_fiscal_emisor'];
$direccion_emisor = $row['direccion_emisor'];
$razon_social_receptor = $row['razon_social_receptor'];
$folio_fiscal = $row['folio_fiscal'];
$acuse = $row['acuse'];
$direccion_receptor = $row['direccion_receptor'];

function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

$parsed = get_string_between((string)$acuse, '<SignatureValue>', '</SignatureValue>');
 
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
</style>
<page backtop="3mm">
<table>
    <tr>
        <?php
        $carpeta = "../imagenes/".$logo;
        if(file_exists($carpeta)){?>
            <td width="165"><?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?></td>
        <?php
        }else{?>
            <td width="165"></td>
        <?php
        } ?>
        <td width="330" style="font-weight:bold;text-align:center;">
            <strong><?php echo $nombreArch ?></strong><BR>
            DATOS DEL EMISOR <br>
            <!--<div class="font_light">SUCURSAL: <?php echo strtoupper($sucursal); ?></div>-->
            <label id="dato_rfc" class="font_light"><?php echo strtoupper($rfc_emisor); ?></label><br>
            <label id="dato_empresa" class="font_light"><?php echo strtoupper($empresa_fiscal_emisor); ?></label><br>
            <label id="dato_direccion" class="font_light"><?php echo $direccion_emisor; ?></label>
        </td>
        <td width="250">
            <table>
                <tr>
 					<td align="right"><strong>FOLIO:</strong></td>
 					<td align="left"><?php echo $folio; ?></td>
 				</tr>
                <tr>
 					<td align="right"><strong>VERSIÓN ANEXO SAT:</strong></td>
 					<td align="left">3.3</td>
 				</tr>
                 <tr>
                	<td colspan="2" align="right" class="font_light">Página [[page_cu]] de [[page_nb]]</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td width="710" class="bordePad">DATOS DEL RECEPTOR<br>
            <label class="font_light"><?php echo strtoupper($rfc_receptor); ?></label><br>
            <label class="font_light"><?php echo $razon_social_receptor; ?></label><br>
            <label class="font_light"><?php echo $direccion_receptor; ?></label>
        </td>
    </tr>
</table>
	<br><br>
	<table width="710" style="font-size:13px;">
		<tr>
			<td>
				Estimado: <?php echo $razon_social_receptor; ?><br><br>
				Ha solicitado la cancelación del documento : <?php echo $folio; ?><br><br>
				Con folio fiscal : <?php echo $folio_fiscal; ?> <br><br>
			</td>
		</tr>
	</table>

</page>
          
<?php 
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
