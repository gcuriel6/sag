<?php 
session_start();
include("../php/conectar.php");
include("../widgets/numerosLetras.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];

$query = "SELECT g.id_orden_servicio,g.total,g.id_razon_social_servicio,g.cve_concepto,
IF(h.id_orden_servicio > 0 ,'ORDEN DE SERVICIO',IF(h.id_plan>0,'PLAN',IF(h.id_venta>0,'VENTA','SERVICIO')))AS titulo,
IF(h.id_orden_servicio > 0 ,h.id_orden_servicio,IF(h.id_plan > 0 ,h.folio_recibo,IF(h.id_venta>0,h.folio_venta,h.id)))AS folio,
IFNULL(a.servicio,'') AS servicio,
a.descripcion,
a.proceso,
a.acciones_realizadas,
a.estatus_orden AS estatus,
g.estatus,
g.fecha,
b.nombre AS unidad,
IFNULL(b.logo,'') AS logo,
c.descr AS sucursal,c.codigopostal,
CONCAT(c.calle,' No. Ext ' ,c.no_exterior,(IF(c.no_interior!='','No. Int ','')),c.no_interior) AS direccion,
c.colonia AS colonia,
d.estado,
e.municipio,
DATE(a.fecha_captura) AS fecha_registro,
DATE_FORMAT(a.fecha_captura, '%H:%i:%S' ) AS horas,
f.razon_social,
f.nombre_corto,
g.id_sucursal
FROM cxc g
LEFT JOIN servicios_ordenes a ON g.id_orden_servicio=a.id
LEFT JOIN sucursales c ON g.id_sucursal = c.id_sucursal 
LEFT JOIN cat_unidades_negocio b ON c.id_unidad_negocio= b.id
LEFT JOIN estados d ON c.id_estado = d.id
LEFT JOIN municipios e ON c.id_municipio = e.id
LEFT JOIN servicios f ON g.id_razon_social_servicio = f.id
LEFT JOIN cxc h ON g.folio_cxc=h.id
WHERE g.id=".$idRegistro;

$consulta = mysqli_query($link, $query);
$rowU = mysqli_fetch_array($consulta);
$logo = $rowU['logo'];

$id_sucursal = $rowU['id_sucursal'];
?>
<style>
table td{
    font-size:13px;
	font-weight:100;	
}
.borde_tabla td{
	padding-left:5px;
    padding-right:5px;
    padding-top: 5px;
    padding-bottom: 5px;
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
        <?php
        $carpeta = "../imagenes/".$logo;
        if(file_exists($carpeta)){ ?>
            <!--NJES March/24/2021 si la sucursal es SEYCOM mostrar ese logo tambien-->
            <?php if($id_sucursal == 57) {?>
                <td width="130" align="top">
            <?php }else{ ?>
                <td width="180" align="top">
            <?php } ?>
            <?php echo '<img src="../imagenes/'.$logo.'"  width="150" height="50"/>';?></td><?php 
        }else{?>
            <td width="180"></td><?php
        } ?>

        <?php if($id_sucursal == 57) {?>
            <td width="345" class="datos" align="center" >
        <?php }else{ ?>
            <td width="450" class="datos" align="center" >
        <?php } ?>
        <strong>ABONO A <?php echo $rowU['titulo']?></strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <br>
            Calle: <?php echo $rowU['direccion']; ?><br> 
            Colonia: <?php echo $rowU['colonia']; ?><br> 
            C.P. <?php echo $rowU['codigopostal']; ?><BR> 
            <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>
        </td>

        <?php if($id_sucursal == 57) {?>
            <td width="130" align="top">
                <?php echo '<img src="../imagenes/seycom.png"  width="120"/>';?>
            </td>
            <td width="100">
        <?php }else{ ?>
            <td width="110">
        <?php } ?>
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio </td>
                  <td class="dato"><?php echo $rowU['folio'];?></td>
                </tr>
                <tr>
                  <td class="verde">Fecha </td>
                  <td class="dato"><?php echo $rowU['fecha'];?></td>
                </tr>
                <tr>
                  <td class="verde" colspan="2" align="center"><?php echo ($rowU['estatus']=='C')? 'CANCELADO' : 'APROBADO';?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br><br>

<table width="700" class='borde_tabla'>   
    <tr>
        <td width="150" class="verde" align="left" >Recibo</td>
        <td  width="550" style="border:none;"></td>
    </tr>
    <tr>
        <td class="datos" colspan="2" style="text-align:justify;" >Recibí de: <?php echo $rowU['nombre_corto'] ?> la cantidad  de: <?php echo dos_decimales($rowU['total']);?> <br>(<?php echo  numtoletras($rowU['total'])?>) 
        Por el servicio brindado.</td>
    </tr>
</table>
<br><br><br>

<table width="700">
    <tr>
        <td width="370" align="center">AUTORIZADO POR: </td>
        <td width="370" align="center">RECIBIDO POR: </td>
    </tr>
</table>

<br><br><br><br>

<table width="710">
    <tr>
        <td width="370"  align="center">___________________________________</td>
        <td width="370"  align="center">___________________________________</td>
    </tr>
</table>

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
    return '$'.$number; 
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