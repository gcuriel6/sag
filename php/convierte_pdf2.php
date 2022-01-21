<?php
$datosO=$_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$path = $arreglo['path'];
$tipo = $arreglo['tipo']; //1=abrir pdf en navegador 2=guardar el archivo en carpeta  3=abrir pdf en navegador   4=descargar archivo
$idRegistro = isset($arreglo['idRegistro']) ? $arreglo['idRegistro'] : 0;
$folio = isset($arreglo['folio']) ? $arreglo['folio'] : 0;
$nombreArchivo = $arreglo['nombreArchivo'];
$idRazonSocial = isset($arreglo['idRazonSocial']) ? $arreglo['idRazonSocial'] : '';

$vp =isset($arreglo['vp']) ? $arreglo['vp'] : '';
$folioFactura = isset($arreglo['folioFactura']) ? $arreglo['folioFactura'] :0;

ob_start();
include('../formatosPdf/'.$path.'.php');
$content = ob_get_clean();

// convert in PDF
require_once('../vendor/pdf/html2pdf.class.php');
try
{
	

	$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('../impresiones/factura_'.$folio.'.pdf','f');

}
catch(HTML2PDF_exception $e)
{
	echo 'Error al generar el PDF, favor de notificar.';
	exit;
}

?>