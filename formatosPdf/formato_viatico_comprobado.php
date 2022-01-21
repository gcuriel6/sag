<?php 
session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idViatico = $arreglo['idRegistro'];

$query = "SELECT 
            viaticos.id,
            viaticos.folio,
            viaticos.destino,
            viaticos.total,
            viaticos.devolucion,
            viaticos.descuento_nomina,
            viaticos.quincenas,
            IF(viaticos.id_empleado=0,viaticos.nombre_empleado,
            CONCAT(TRIM(empleado.nombre),' ',TRIM(empleado.apellido_p),' ',TRIM(empleado.apellido_m))) AS empleado,
            CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)) AS solicito,
            unidad.nombre AS unidad,
            sucursales.descr AS sucursal,
            unidad.logo AS logo,
            IFNULL(sucursales.codigopostal,'') AS codigopostal,
            CONCAT(sucursales.calle ,'  Num. Ext: ', sucursales.no_exterior,(IF(sucursales.no_interior!='',' Num. Int: ','')), sucursales.no_interior) AS direccion,
            sucursales.colonia AS colonia,
            estados.estado,
            municipios.municipio
            FROM  viaticos 
            LEFT JOIN cat_unidades_negocio AS unidad ON  viaticos.id_unidad_negocio = unidad.id
            LEFT JOIN sucursales ON viaticos.id_sucursal = sucursales.id_sucursal
            LEFT JOIN cat_areas ON viaticos.id_area = cat_areas.id
            LEFT JOIN deptos ON viaticos.id_departamento=deptos.id_depto
            LEFT JOIN trabajadores AS empleado ON viaticos.id_empleado=empleado.id_trabajador
            LEFT JOIN trabajadores ON viaticos.id_solicito=trabajadores.id_trabajador
            LEFT JOIN estados ON sucursales.id_estado = estados.id
            LEFT JOIN municipios ON sucursales.id_municipio = municipios.id
            WHERE viaticos.id=".$idViatico;

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

<table border="0">
    <tr>
        <td width="140" align="top"><?php echo ($rowU['logo']!='')?'<img src="../imagenes/'.$rowU['logo'].'"  width="150"/>':'';?></td>
        <td width="420" class="datos" align="center" ><strong>Viático Comprobado</strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <br>
            Calle: <?php echo $rowU['direccion']; ?> Colonia: <?php echo $rowU['colonia']; ?> C.P.: <?php echo $rowU['codigopostal']; ?><BR> 
            <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                    <td class="verde">Fecha Impresión</td>
                    <td class="dato"><?php echo date("Y-m-d"); ?></td>
                </tr>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br><br>

<table class='borde_tabla'>
    <tr>
        <td class="verde">Folio</td>
        <td class="dato"><?php echo $rowU['folio'];?></td>
    </tr>
    <tr>
        <td class="verde">Empleado: </td>
        <td><?php echo $rowU['empleado'] ?></td>
    </tr>
    <tr>
        <td class="verde">Destino: </td>
        <td><?php echo $rowU['destino'] ?></td>
    </tr>
</table>

<br><br>

<table class='borde_tabla'>
    <tr class="encabezado">
        <td width="122" class="verde" align="ceter" >CATEGORÍA</td>
        <td width="90" class="verde" align="ceter" >CANTIDAD</td>
        <td width="95" class="verde" align="ceter" >IMPORTE UNITARIO</td>
        <td width="95" class="verde" align="ceter" >POR COMPROBAR</td>
        <td width="102" class="verde" align="ceter" >GASTO COMPROBADO</td>
        <td width="95" class="verde" align="ceter" >DIFERENCIA</td>
        <td width="110" class="verde" align="ceter" >REFERENCIA</td>
    </tr>
    <?php

        $total = 0;
        $totalComprobado = 0;
        $totalDiferencia = 0;

        $query = "SELECT 
                    viaticos_d.id,
                    viaticos_d.id_viaticos,
                    viaticos_d.id_clasificacion,
                    viaticos_d.cantidad,
                    viaticos_d.importe_unitario AS importe,
                    (viaticos_d.cantidad*viaticos_d.importe_unitario) AS total,
                    viaticos_d.gasto_comprobado,
                    viaticos_d.diferencia,
                    viaticos_d.referencia,
                    viaticos_clasificacion.descripcion AS clasificacion
                    FROM  viaticos_d 
                    LEFT JOIN viaticos_clasificacion ON viaticos_d.id_clasificacion= viaticos_clasificacion.id
                    WHERE viaticos_d.id_viaticos=".$idViatico."
                    ORDER BY viaticos_d.id ASC";

    $result = mysqli_query($link, $query);
    while($row = mysqli_fetch_array($result))
    {
        echo '<tr>';
        echo '<td class="datos">' . normaliza($row['clasificacion'],15) . '</td>';
        echo '<td class="datos">' . $row['cantidad'] . '</td>';
        echo '<td class="datos" align="right">' . dos_decimales($row['importe']) . '</td>';
        echo '<td class="datos" align="right">' . dos_decimales($row['total']) . '</td>';
        echo '<td class="datos" align="right">' . dos_decimales($row['gasto_comprobado']) . '</td>';
        echo '<td class="datos" align="right">' . dos_decimales($row['diferencia']) . '</td>';
        echo '<td class="datos" align="right">' . normaliza($row['referencia'],15) . '</td>';
        echo '</tr>';

        $total=$total+$row['total'];
        $totalComprobado=$totalComprobado+$row['gasto_comprobado'];
        $totalDiferencia=$totalDiferencia+$row['diferencia'];

    }

        echo '<tr>';
        echo '<td class="datos"></td>';
        echo '<td class="datos"></td>';
        echo '<td class="datos"></td>';
        echo '<td class="datos" align="right">' . dos_decimales($total) . '</td>';
        echo '<td class="datos" align="right">' . dos_decimales($totalComprobado) . '</td>';
        echo '<td class="datos" align="right">' . dos_decimales($totalDiferencia) . '</td>';
        echo '<td class="datos"></td>';
        echo '</tr>'; 
    ?>
</table>
<br><br>
<table class='borde_tabla'>
    <tr class="encabezado">
        <td width="180" class="datos"></td>
        <td width="95" class="verde" align="ceter" >FECHA DE APLICACIÓN</td>
        <td width="78"></td>
        <td width="92" class="verde" align="ceter" >DEVOLUCIÓN</td>
        <td width="95" align="right"><?php echo $rowU['devolucion'];?></td>
    </tr>
</table>
<table class='borde_tabla'>
    <tr class="encabezado">
        <td width="180" class="datos"></td>
        <td width="95" class="verde" align="ceter" >FECHA INICIO</td>
        <td width="78"></td>
        <td width="92" class="verde" align="ceter" >DESCUENTO A NÓMINA</td>
        <td width="95" align="right"><?php echo $rowU['descuento_nomina'];?></td>
        <td width="85" class="verde" align="ceter">QUINCENAS</td>
        <td width="85" align="right"><?php echo $rowU['quincenas'];?></td>
    </tr>
</table>

<br><br><br><br><br><br>
<table width="710">
    <tr>
        <td width="250"></td>
        <td align="center">___________________________________</td>
    </tr>
    <tr>
        <td width="250"></td>
        <td align="center">NOMBRE Y FIRMA</td>
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