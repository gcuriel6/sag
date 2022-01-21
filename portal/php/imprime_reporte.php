<?php
$html=$_REQUEST["html"];
$fecha=date('d/m/Y');
$hora=strftime('%H:%M:%S %P');
$css="
	<html>
	<link rel='stylesheet' href='../css/general.css' />
	<style>
	.query_tables{ width:810px;}
	.renglon td{
		width:150px;
	}
	.tr_primero td{
		width:200px;
		text-align:center;
	}
	
	</style>
	
	<body>
	<table>
		<tr><td>Reporte:</td><td>REPORTE DE AUDITORÍA</td></tr>
		<tr><td>Generado:</td><td>$fecha $hora</td></tr>
	</table>
	<br>
	";
$fin = "
	</body>
	</html>
";
	
$pagina = $css . $html . $fin; 
// convert in PDF
require_once('../../vendor/pdf/html2pdf/pdf/html2pdf.class.php');
try
{
	$html2pdf = new HTML2PDF('L', 'Letter', 'fr');
	//$html2pdf->setModeDebug();
	//$html2pdf->setDefaultFont('Arial');
	$html2pdf->writeHTML($pagina, isset($_GET['vuehtml']));
	$html2pdf->Output('reporte.pdf');
}
catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>