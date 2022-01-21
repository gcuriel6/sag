<?php
$datosO=$_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$path = $arreglo['path'];
$tipo = $arreglo['tipo']; //1=abrir pdf en navegador 2=guardar el archivo en carpeta  3=abrir pdf en navegador   4=descargar archivo
$idRegistro = isset($arreglo['idRegistro']) ? $arreglo['idRegistro'] : 0;
$nombreArchivo = $arreglo['nombreArchivo'];
$idRazonSocial = isset($arreglo['idRazonSocial']) ? $arreglo['idRazonSocial'] : '';

$vp =isset($arreglo['vp']) ? $arreglo['vp'] : '';
$folioFactura = isset($arreglo['folioFactura']) ? $arreglo['folioFactura'] :0;

if($vp=='vp_cotizacion'){
	@unlink('../cotizaciones/cotizacion_vp_'.$idRazonSocial.'.pdf');

}
if($vp=='vp_requi'){
	@unlink('../formatosPdf/formato_vp_requisicion_'.$idRegistro.'.pdf');
}

ob_start();
include('../formatosPdf/'.$path.'.php');
$content = ob_get_clean();

// convert in PDF
require_once('../vendor/pdf/html2pdf.class.php');
try
{
	if($tipo == 1)
	{
		$html2pdf = new HTML2PDF('P', 'Letter', 'fr');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($nombreArchivo.'.pdf');
	}

	if($tipo == 2)
	{
		$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		if($vp=='vp_cotizacion'){
			$html2pdf->Output('../cotizaciones/cotizacion_vp_'.$idRazonSocial.'.pdf','f');
		}elseif($vp=='vp_requi'){
				$html2pdf->Output('../formatosPdf/formato_vp_requisicion_'.$idRegistro.'.pdf','f');
				
		}else{
			$html2pdf->Output('../cotizaciones/cotizacion_'.$idRegistro.'.pdf','f');
		}
	}	


}
catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>