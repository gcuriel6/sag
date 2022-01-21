<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];
$formatoAr = $arreglo['formatoAr'];

if($formatoAr == 'C')
    $tituloAr = 'SALIDA POR COMODATO';
else
    $tituloAr = 'SALIDA POR RESPONSIVA';

//$conceptoAlmacen = $arreglo['concepto'];

// Informacion de la empresa 
$query = "SELECT
        activos.folio_recepcion AS folio,
        DATE(NOW()) AS fecha,
        activos.no_serie,
        activos.num_economico AS num_e,
        cat_unidades_negocio.descripcion AS du,
        cat_unidades_negocio.nombre,
        cat_unidades_negocio.logo,
        IF(activos_responsables.id_trabajador>0,CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)),IF(activos_responsables.responsable_externo='',razones_sociales.razon_social,activos_responsables.responsable_externo))AS reponsable_comodato,
        IFNULL(usuarios.nombre_comp,'') as usuario_captura,
        armas_activos.modelo,
        armas_activos.matricula,
        armas_marcas.marca,
        IF(activos_responsables.responsable_externo='',cat_puestos.puesto,'EXTERNO') AS puesto,
        trabajadores.cve_nom AS no_empleado,
        activos_responsables.cuip
        FROM activos
        INNER JOIN activos_responsables  ON activos.id =  activos_responsables.id_activo
        INNER JOIN cat_unidades_negocio ON activos_responsables.id_unidad_negocio = cat_unidades_negocio.id
        INNER JOIN sucursales ON activos_responsables.id_sucursal = sucursales.id_sucursal
        LEFT JOIN trabajadores  ON activos_responsables.id_trabajador= trabajadores.id_trabajador
        LEFT JOIN razones_sociales ON activos_responsables.id_cliente = razones_sociales.id 
        LEFT JOIN usuarios ON activos_responsables.id_usuario_captura= usuarios.id_usuario
        LEFT JOIN armas_activos ON activos.id=armas_activos.id_activo
        LEFT JOIN armas_marcas ON armas_activos.id_marca=armas_marcas.id 
        LEFT JOIN cat_puestos ON trabajadores.id_puesto=cat_puestos.id_puesto
        WHERE   activos.id =".$idRegistro."
        ORDER BY activos_responsables.id DESC 
        LIMIT 1";

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$fecha = $row['fecha'];
$noSerie = $row['no_serie']; 
$nE = $row['num_e'];     
$unidad = $row['du']; 
$reponsableComodato = $row['reponsable_comodato'];
$usuarioCaptura = $row['usuario_captura'];

$folio = $row['folio'];
$marca = $row['marca'];
$modelo = $row['modelo'];
$cuip = $row['cuip'];
$no_empleado = $row['no_empleado'];
$empleado = $row['reponsable_comodato'];
$puesto = $row['puesto'];

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
	font-size:12px;
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
.borde_negro_tabla{
    border: 1px solid black;
}
.borde_negro_tabla td{
    padding:5px;
}

</style>
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="3mm"  backbottom="5mm">

<table width="710" border="0">
    <tr>
        <!--<td width="200" align="top"><?php/* echo '<img src="../imagenes/'.$row['logo'].'"  width="150"/>';*/?></td>-->
        <td width="250" align="top"><?php echo $unidad; ?></td>
        <td width="250" class="datos" align="center" ><strong><?php echo $tituloAr;?></strong> <br>
            GINTHERCORP<br> 
            CORPORATIVO<br>
        </td>
        <td width="130"></td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $folio;?></td>
                </tr>
                <tr>
                    <td class="verde">Fecha</td>
                    <td class="dato"><?php echo $fecha ?></td>
                </tr>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table class="borde_tabla" width="100%">

    <thead>
        <tr class="encabezado">
            <td width='200' align="center">No. Empleado</td>
            <td width='310' align="center">Nombre </td>
            <td width='250' align="center">Puesto</td>
        </tr>
    </thead>
    <tbody>
    <?php

    echo   "<tr>
                <td width='200'>" . $no_empleado . "</td>
                <td width='310'>" . $empleado. "</td> 
                <td width='250'>" . $puesto . "</td>          
            </tr>";
    ?> 
    </tbody>
</table>

<br><br>

<table class="borde_tabla">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">No. Economico</td>
            <td width='150' align="center">No. Serie </td>
            <td width='140' align="center">Marca</td>
            <td width='140' align="center">Modelo</td>
            <td width='170' align="center">CUIP</td>
        </tr>
    </thead>
    <tbody>
    <?php




    echo   "<tr>
                <td width='150'>" . $nE . "</td>
                <td width='150'>" . $noSerie . "</td>
                <td width='140'>" . $marca . "</td>
                <td width='140'>" . $modelo. "</td> 
                <td width='170'>" . $cuip . "</td>          
            </tr>";
    ?> 
    </tbody>
</table>

<br><br>
<br><br>
<br><br>
<br><br>

<table width="710">
    <tr>
        <td width="70"></td>
        <td width="250"  align="center">______________________________________</td>
        <td width="60"></td>
        <td width="250"  align="center">______________________________________</td>
        <td width="70"></td>
    </tr>
    <tr>
        <td width="70"></td>
        <td width="250" align="center"><?php echo $reponsableComodato;?><br><b>NOMBRE RESPONSABLE</b></td>
        <td width="60"></td>
        <td width="250" align="center"><?php echo $usuarioCaptura?><br><b>NOMBRE QUIEN ENTREGA ACTIVO</b></td>
        <td width="70"></td>
    </tr>
</table>

<br>
<br>


<page_footer style="text-align:right;font-size:10px;">
    [[page_cu]] de [[page_nb]]
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
