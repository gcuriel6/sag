<?php 
session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idSucursal = $arreglo['idRegistro'];
$fechaFin = $arreglo['fechaFin'];
$fechaInicio = $arreglo['fechaInicio'];

$condicion='';

if($fechaInicio == '' && $fechaFin == '')
{
    $condicion=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
}else if($fechaInicio != '' &&  $fechaFin == '')
{
    $condicion=" AND a.fecha >= '$fechaInicio' ";
}else{  //-->trae fecha inicio y fecha fin
    $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
}

$query1="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_inicial
            FROM caja_chica
            WHERE id_sucursal=$idSucursal AND fecha<='$fechaInicio'
            GROUP BY id_sucursal";

$consulta1 = mysqli_query($link, $query1);
$row1 = mysqli_fetch_array($consulta1);

$query2="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_final
            FROM caja_chica
            WHERE id_sucursal=$idSucursal AND fecha<='$fechaFin'
            GROUP BY id_sucursal";

$consulta2 = mysqli_query($link, $query2);
$row2 = mysqli_fetch_array($consulta2);

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

<table width="930" border="0">
    <tr>
        <td width="930" class="datos" align="center" >
            <br><br><br>
            <strong>Reportes de Caja Chica</strong>
            <br><br><br>
        </td>
    </tr>
</table>

<table width="930" border="0">
    <tr>
        <td width="50" class="verde">Del: </td>
        <td width="100" class="dato"><?php echo $fechaInicio ?></td>       
        <td width="50" class="verde">Al: </td>
        <td width="100" class="dato"><?php echo $fechaFin ?></td>
    </tr>
</table>

<br>

<table width="930" border="0">
    <tr>
        <td width="100" class="verde">Saldo Inicial: </td>
        <td width="100" class="dato"> <?php echo dos_decimales($row1['saldo_inicial']) ?></td>       
        <td width="100" class="verde">Saldo Final: </td>
        <td width="100" class="dato"> <?php echo dos_decimales($row2['saldo_final']) ?></td>
    </tr>
</table>

<br><br><br>

<table width="930" class='borde_tabla'>
    <tr class="encabezado">
        <td width="110" class="verde" align="ceter" >UNIDAD DE NEGOCIO</td>
        <td width="110" class="verde" align="ceter" >SUCURSAL</td>
        <td width="110" class="verde" align="ceter" >ÁREA</td>
        <td width="110" class="verde" align="ceter" >DEPARTAMENTO</td>
        <td width="110" class="verde" align="ceter" >EMPLEADO</td>
        <td width="110" class="verde" align="ceter" >OBSERVACIONES</td>
        <td width="100" class="verde" align="ceter" >FECHA</td>
        <td width="100" class="verde" align="ceter" >CONCEPTO</td>
        <td width="100" class="verde" align="ceter" >MONTO</td>
    </tr>
    <?php
        $query = "SELECT c.nombre AS unidad_negocio,d.descr AS sucursal,e.descripcion AS area,f.des_dep AS departamento,
                IF(a.nombre_empleado != '',a.nombre_empleado,CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m))) AS empleado,
                a.observaciones,a.fecha,CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,a.importe
                FROM caja_chica a
                LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                LEFT JOIN cat_areas e ON a.id_area=e.id
                LEFT JOIN deptos f ON a.id_departamento=f.id_depto
                LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
                WHERE a.id_sucursal=$idSucursal $condicion
                ORDER BY a.id ASC";

        $result = mysqli_query($link, $query);
        while($row = mysqli_fetch_array($result))
        {
            echo '<tr>';
            echo '<td class="datos">' . normaliza($row['unidad_negocio'],14) . '</td>';
            echo '<td class="datos">' . normaliza($row['sucursal'],14) . '</td>';
            echo '<td class="datos">' . normaliza($row['area'],14) . '</td>';
            echo '<td class="datos">' . normaliza($row['departamento'],14) . '</td>';
            echo '<td class="datos">' . normaliza($row['empleado'],14) . '</td>';
            echo '<td class="datos">' . normaliza($row['observaciones'],14) . '</td>';
            echo '<td class="datos">' . normaliza($row['fecha'],10) . '</td>';
            echo '<td class="datos">' . normaliza($row['concepto'],14) . '</td>';
            echo '<td class="datos" align="right">' . dos_decimales($row['importe']) . '</td>';
            echo '</tr>';
        }
    ?>
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
    return '$'. $number; 
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