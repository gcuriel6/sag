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
	$nombreArch = 'FACTURA CANCELADA';
	$folioOpc = ' a.folio AS folio,';
	$folioFac = '';
}else{
	$nombreArch = 'NOTA DE CRÉDITO CANCELADA';
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
CONCAT(b.calle,' ',b.num_ext,', ',b.colonia,' C.P.',b.cp,'. ',i.municipio,', ',j.estado,', México.') AS direccion_emisor
FROM facturas a
LEFT JOIN empresas_fiscales b ON a.id_empresa_fiscal=b.id_empresa
INNER JOIN sucursales d ON a.id_sucursal=d.id_sucursal
INNER JOIN cat_unidades_negocio e ON a.id_unidad_negocio=e.id
INNER JOIN cat_uso_cfdi f ON a.uso_cfdi=f.clave
LEFT JOIN municipios i ON b.id_municipio=i.id
LEFT JOIN estados j ON b.id_estado=j.id
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
    strong{
		font-size: 11px;
	}
	td{
		font-family:Arial, Helvetica, sans-serif;
		font-size: 9px;
	}
	.t_large{
		font-family:Arial, Helvetica, sans-serif;
		font-size: 10px;
	}
	.t_small{
		font-family:Courier, monospace;
		font-size: 8px;
		padding-bottom:5px;
	}
	.neg_titulo{
		font-size: 14px;
		font-weight: bold;
	}
	.neg{
		font-size: 11px;
		font-weight: bold;
	}
	.nor{
		font-weight:100;
		text-align:justify;
	}
	.peque_may{
		font-size:10px;
		text-align:justify;
		padding-top:2px;
	}
	.letra_min{
		font-family:Arial, Helvetica, sans-serif;
		font-size:8px;
	}
	.centrado{
		text-align:center;
	}
	.derecha{
		text-align:right;
		padding-right: 5px;
	}
	.b_left{
		border-left:1px solid #000000;
	}
	.b_bottom{
		border-bottom:1px solid #ccc;
	}
	.b_der{
		border-right:1px solid  #ccc;
	}
	.b_top{
		border-top:1px solid  #ccc;
	}
	.encabezado td{
		border:1px solid  #ccc;
		color: #000;
		font-weight: bold;
		text-align: center;
		padding:5px 0px;
	}
	.encabezado2 td{
		border-left:1px solid  #ccc;
		border-right: 1px solid  #ccc;
		border-bottom: 1px solid  #fff;
		color: #000;
		font-weight: bold;
		text-align: center;
		padding:5px 0px;
	}
	.contenido td{
		border:1px solid  #ccc;
		color: #000;
		padding:3px;
	}
	p{
		padding:0px;
		margin: 0px;
	}
	#borde{
		border:solid  #ccc;
		position:relative;
		width:100%;
		padding-bottom:3px;
		padding-left:2px;
		padding-top: 5px;

	}
	.borde{
		border:1px solid  #ccc;
	}
    .der {
        float: right;
    }
</style>
<page backtop="3mm">
	
	<table width="710" >
		<tr>
 		<td width="500" align="center">
		 	<?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?>
			<br><span class="neg_titulo" style="margin-bottom: 5px;"></span><br/><br/>
		</td>
 		<td width="210" align="right">
 			<table width="100%">
 				<tr>
 					<td colspan="2" class="neg" align="center"><?php echo $nombreArch ?></td>
 				</tr>
 				<tr>
 					<td align="right">FOLIO:</td>
 					<td align="left"><?php echo $folio; ?></td>
 				</tr>
 				<tr>
 					<td align="right">VERSIÓN ANEXO SAT:</td>
 					<td align="left">3.3</td>
 				</tr>
 			</table>
 		</td>
 	</tr>
	</table>
	<table width="710">
		<tr>
			<td>
				Estimado: <?php echo $razon_social_receptor; ?><br><br>
				<b><?php echo $rfc_emisor.' - '.$empresa_fiscal_emisor; ?></b><br>
                <b><?php echo $direccion_emisor; ?></b><br><br>
				Ha cancelado el documento : <?php echo $folio; ?><br><br>
				Con folio fiscal : <?php echo $folio_fiscal; ?> <br><br>
				Sello de cancelación: <?php echo $parsed; ?><br><br>

				Por favor tome en cuenta ya que no tiene valor fiscal.
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
