<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$fechaInicio = $arreglo['fechaInicio'];
$fechaFin = $arreglo['fechaFin'];
$idProveedor = $arreglo['idRegistro'];

$condicion='';

if($fechaInicio == '' && $fechaFin == '')
{
    $condicion=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
}else if($fechaInicio != '' &&  $fechaFin == '')
{
    $condicion=" AND a.fecha >= '$fechaInicio' ";
}else{  //-->trae fecha inicio y fecha fin
    $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
}


// Informacion de la empresa 
$query = "SELECT nombre AS proveedor,rfc,telefono,contacto FROM proveedores WHERE id=".$idProveedor;

$consulta = mysqli_query($link, $query);
$rowU = mysqli_fetch_array($consulta);
     
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
        <td width="200" align="top"></td>
        <td width="400" class="datos" align="center" ><strong>CxP Estado de Cuenta</strong> <br></td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>
<table width="710"class='borde_tabla'>
    <tr>
        <td width="100" class="verde" align="left" >Proveedor </td>
        <td width="460" class="datos" align="left" ><?php echo $rowU['proveedor']; ?></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >RFC </td>
        <td width="350" class="datos" align="left" ><?php echo $rowU['rfc']; ?></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >Teléfono </td>
        <td width="350" class="datos" align="left" ><?php echo $rowU['telefono']; ?></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >Contacto </td>
        <td width="350" class="datos" align="left" ><?php echo $rowU['contacto']; ?></td>
    </tr>
</table>
<br>
<table width="710" class="borde_tabla">
    <tr class="encabezado">
      <td width="60">Concepto</td>
      <td width="70">Fecha</td>
      <td width="110">Descripción</td>
      <td width="100">Cargos</td>
      <td width="100">Abonos</td>
      <td width="100">Saldo</td>
      <td width="190">Referencia</td>
    </tr>
<?php

  $queryD = "SELECT b.clave AS concepto,b.descripcion,IFNULL(a.fecha,'') AS fecha,a.referencia,
                IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva),0) AS cargos,
                IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva),0) AS abonos
                FROM cxp a
                LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                LEFT JOIN proveedores c ON a.id_proveedor=c.id
                WHERE a.id_proveedor = $idProveedor
                AND a.id_viatico=0  AND a.id_cxp IN(SELECT DISTINCT(a.id_cxp ) AS id_cxp FROM cxp a  WHERE a.id_proveedor = $idProveedor AND a.id_viatico=0 $condicion) 
                ORDER BY a.id ASC,a.fecha DESC";

    $totalCargos=0;
    $totalAbonos=0;
    $saldo=0;

    $resultDetalle = mysqli_query($link, $queryD);
    while($rowD = mysqli_fetch_array($resultDetalle))
    {

        $totalCargos=$totalCargos+$rowD['cargos'];
        $totalAbonos=$totalAbonos+$rowD['abonos'];
        $saldo = $totalCargos - $totalAbonos;

        echo "<tr>";
        echo "<td>" . $rowD['concepto'] . "</td>";
        echo "<td>" . $rowD['fecha'] . "</td>";
        echo "<td>" . normaliza($rowD['descripcion'],20). "</td>";
        echo "<td>" . dos_decimales($rowD['cargos']). "</td>";
        echo "<td>" . dos_decimales($rowD['abonos']) . "</td>";
        echo "<td>" . dos_decimales($saldo) . "</td>";
        echo "<td>" . normaliza($rowD['referencia'], 30) . "</td>";
        echo "</tr>";

    }

?>


</table>
<br>
<table width="710" class="borde_tabla">
    <tr class="encabezado">
        <td width="460">Saldo Actual</td>
        <td width="100"><?php echo dos_decimales($saldo); ?></td>
    </tr>
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