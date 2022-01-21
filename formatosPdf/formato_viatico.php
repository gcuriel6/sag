<?php 
session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idViatico = $arreglo['idRegistro'];

$query = "SELECT 
                a.folio, b.nombre AS unidad,
                a.destino,
                a.distancia,
                a.motivos,
                a.fecha_inicio,
                a.fecha_fin,
                a.dias,
                a.noches,
                a.prospectacion,
                a.atencion,
                a.otros,
                a.fecha_comprobacion,
                a.autorizo,
                a.total,
                IF(a.estatus='A','Guardado',IF(a.estatus='S','Solicitado',IF(a.estatus='CA','Cancelado','Comprobado'))) AS estatus,
                if(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(f.nombre),' ',TRIM(f.apellido_p),' ',TRIM(f.apellido_m))) AS empleado,
                b.logo AS logo,
                b.clave as clave_unidad,
                c.descr AS sucursal,
                ifnull(c.codigopostal,'') AS codigopostal,
                CONCAT(c.calle ,'  Num. Ext: ', c.no_exterior,(IF(c.no_interior!='',' Num. Int: ','')), c.no_interior) AS direccion,
                c.colonia AS colonia,
                d.descripcion AS area,
                e.des_dep AS departamento,
                CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)) AS solicito,
                h.usuario,
                i.estado,
                j.municipio,
                if(k.id_trabajador>0,CONCAT(TRIM(k.nombre),' ',TRIM(k.apellido_p),' ',TRIM(k.apellido_m)),h.nombre_comp) AS capturo
            FROM  viaticos a
            LEFT JOIN cat_unidades_negocio AS b ON  a.id_unidad_negocio = b.id
            LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
            LEFT JOIN estados i ON c.id_estado = i.id
            LEFT JOIN municipios j ON c.id_municipio = j.id
            LEFT JOIN cat_areas d ON a.id_area = d.id
            LEFT JOIN deptos e ON a.id_departamento=e.id_depto
            LEFT JOIN trabajadores f ON a.id_empleado=f.id_trabajador
            LEFT JOIN trabajadores g ON a.id_solicito=g.id_trabajador
            LEFT JOIN usuarios h ON a.id_usuario_captura=h.id_usuario
            LEFT JOIN trabajadores k ON h.id_empleado=k.id_trabajador
            WHERE a.id=".$idViatico;

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
        <td width="435" class="datos" align="center" ><strong>Comprobante de Viáticos</strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <br>
            Calle: <?php echo $rowU['direccion']; ?> Colonia: <?php echo $rowU['colonia']; ?> C.P.: <?php echo $rowU['codigopostal']; ?><BR> 
            <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $rowU['clave_unidad'].'-'.$rowU['folio'];?></td>
                </tr>
                <tr>
                    <td class="verde">Estatus</td>
                    <td class="dato"><?php echo $rowU['estatus'] ?></td>
                </tr>
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
        <td class="verde" width="130">Área: </td>
        <td width="245"><?php echo normaliza($rowU['area'],38) ?></td>
        <td class="verde" width="130">Departamento: </td>
        <td width="245"><?php echo normaliza($rowU['departamento'],40) ?></td>
    </tr>
    <tr>
        <td class="verde">Solicito: </td>
        <td><?php echo normaliza($rowU['solicito'],38) ?></td>
        <td class="verde">Capturo: </td>
        <td><?php echo normaliza($rowU['capturo'],40) ?></td>
    </tr>
    <tr>
        <td class="verde">Empleado: </td>
        <td><?php echo normaliza($rowU['empleado'],38) ?></td>
    </tr>
    <tr>
        <td class="verde">Motivos de Viaje: </td>
        <td><?php echo normaliza($rowU['motivos'],38) ?></td>
    </tr>
    <tr>
        <td class="verde">Destino: </td>
        <td><?php echo normaliza($rowU['destino'],38) ?></td>
        <td class="verde">Distancia: </td>
        <td><?php echo $rowU['distancia'].' Km.'; ?></td>
    </tr>
</table>
<table>
    <tr>
        <td width="50" class="verde">Del: </td>
        <td width="100"><?php echo $rowU['fecha_inicio'] ?></td>
        <td width="50" class="verde">Al: </td>
        <td width="100"><?php echo $rowU['fecha_fin'] ?></td>
        <td width="70" class="verde">Días: </td>
        <td width="50"><?php echo $rowU['dias'] ?></td>
        <td width="70" class="verde">Noches: </td>
        <td width="50"><?php echo $rowU['noches'] ?></td>
    </tr>
</table>

<br><br>

<table class='borde_tabla'>
    <tr class="encabezado">
        <td width="205" class="verde" align="ceter" >CATEGORIA</td>
        <td width="210" class="verde" align="ceter" >OBSERVACIONES</td>
        <td width="90" class="verde" align="ceter" >CANTIDAD</td>
        <td width="120" class="verde" align="ceter" >IMPORTE UNITARIO</td>
        <td width="120" class="verde" align="ceter" >TOTAL</td>
    </tr>

    <?php

        $total = 0;

        $query = "SELECT 
                    a.cantidad,
                    a.importe_unitario AS importe,
                    b.descripcion AS clasificacion,
                    (a.cantidad*a.importe_unitario) AS total,
                    a.observaciones
                    FROM  viaticos_d a
                    LEFT JOIN viaticos_clasificacion b ON a.id_clasificacion= b.id
                    WHERE a.id_viaticos=$idViatico
                    ORDER BY a.id ASC";

    $result = mysqli_query($link, $query);
    while($row = mysqli_fetch_array($result))
    {
        echo '<tr>';
        echo '<td class="datos">' . normaliza($row['clasificacion'],25) . '</td>';
        //-->NJES June/04/2020 agregar observaciones a cada partida
        echo '<td class="datos">' . normaliza($row['observaciones'],25) . '</td>';
        echo '<td class="datos">' . $row['cantidad'] . '</td>';
        echo '<td class="datos" align="right">' . dos_decimales($row['importe']) . '</td>';
        echo '<td class="datos" align="right">' . dos_decimales($row['total']) . '</td>';
        echo '</tr>';

        $total=$total+$row['total'];
    }

    echo '<tr><td colspan="4" class="verde" align="right">Total '.dos_decimales($total).'</td></tr>';    
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