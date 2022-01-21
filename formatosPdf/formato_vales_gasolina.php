<?php 
session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];

$query = "SELECT a.folio AS folio,a.estatus AS estatus,b.nombre AS unidad,b.logo AS logo,c.descr AS sucursal,c.codigopostal,
            CONCAT(c.calle,' No. Ext ' ,c.no_exterior,(IF(c.no_interior!='','No. Int ','')),c.no_interior) AS direccion,
            c.colonia AS colonia,d.estado,e.municipio,DATE(a.fecha_registro) AS fecha_registro,
            DATE_FORMAT(a.fecha_registro, '%H:%i:%S' ) AS horas,a.fecha,
            UPPER(IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(f.nombre),' ',TRIM(f.apellido_p),' ',TRIM(f.apellido_m)))) AS empleado,
            IF(a.id_empleado=0,'Externo',f.cve_nom) AS num_nomina,a.importe,UPPER(a.observaciones) AS observaciones,g.des_dep AS departamento,
            IF(a.externo_no_economico=0,a.no_economico,'Externo') AS no_economico
            FROM vales_gasolina a
            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio = b.id
            LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
            LEFT JOIN estados d ON c.id_estado = d.id
            LEFT JOIN municipios e ON c.id_municipio = e.id
            LEFT JOIN trabajadores f ON a.id_empleado = f.id_trabajador
            LEFT JOIN deptos g ON a.id_departamento = g.id_depto
            WHERE a.id=".$idRegistro;

$consulta = mysqli_query($link, $query);
$rowU = mysqli_fetch_array($consulta);
$logo = $rowU['logo'];
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
        <!-- MGFS  08-01-2020 SE AGREGA VALIDACION PARA VER QUE LA IMAGEN EXISTA EN LA CARPETA 
        YA QUE SI NO EXISTE PUEDE MARCAR ERROR AL GENERAR EL PDF-->
        <?php
            $carpeta = "../imagenes/".$logo;
            if(file_exists($carpeta)){ ?>
                <td width="180"><?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?></td><?php 
            }else{?>
                <td width="180"></td><?php
            } ?>
        <td width="460" class="datos" align="center" ><strong>Comprobante de Vales de Gasolina</strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <br>
            Calle: <?php echo $rowU['direccion']; ?><br> Colonia: <?php echo $rowU['colonia']; ?> C.P. <?php echo $rowU['codigopostal']; ?><BR> 
            <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <?php if($rowU['folio']>0){?>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $rowU['folio'];?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="verde">Fecha</td>
                    <td class="dato"><?php echo $rowU['fecha_registro'] ?></td>
                </tr>
                <tr>
                    <td class="verde">Hora</td>
                    <td class="dato"><?php echo $rowU['horas'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br><br>

<table width="710" class='borde_tabla'>
    <tr>
        <td width="100" class="verde">Observaciones: </td>
        <td width="660" stye="text-align:justify;"><?php echo normaliza($rowU['observaciones'],90) ?></td>
    </tr>
</table>

<br><br>

<table width="710" class='borde_tabla'>
    <tr class="encabezado">
        <td width="100" class="verde" align="left" >No. Nómina</td>
        <td width="215" class="verde" align="left" >Nombre</td>
        <td width="185" class="verde" align="left" >Departamento</td>
        <td width="120" class="verde" align="left" >No. Ecónomico</td>
        <td width="120" class="verde" align="left" >Monto</td>
    </tr>
    <tr>
        <td class="datos" align="left" ><?php echo $rowU['num_nomina'] ?></td>
        <td class="datos" align="left" ><?php echo normaliza($rowU['empleado'],27) ?></td>
        <td class="datos" align="left" ><?php echo normaliza($rowU['departamento'],25) ?></td>
        <td class="datos" align="left" ><?php echo normaliza($rowU['no_economico'],15) ?></td>
        <td class="datos" align="right" ><?php echo dos_decimales($rowU['importe']) ?></td>
    </tr>
</table>

<br><br>

<table width="710" class='borde_tabla'>
    <tr>
        <td class="verde">Fecha: </td>
        <td><?php echo $rowU['fecha'] ?></td>
    </tr>
</table>

<br><br>

<table width="710">
    <tr>
        <td width="370" align="center">ENTREGADO POR: </td>
        <td width="370" align="center">RECIBIDO POR: </td>
    </tr>
</table>

<br><br><br>

<table width="710">
    <tr>
        <td width="370"  align="center">___________________________________</td>
        <td width="370"  align="center">___________________________________</td>
    </tr>
</table>

<br><br>
<p style="color: gray">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
                        - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                        - - - - - - - - - - - - - - - - - - - - - - - - -</p>
<br><br>

<table width="710" border="0">
    <tr>
         <!-- MGFS  08-01-2020 SE AGREGA VALIDACION PARA VER QUE LA IMAGEN EXISTA EN LA CARPETA 
        YA QUE SI NO EXISTE PUEDE MARCAR ERROR AL GENERAR EL PDF-->
        <?php
            $carpeta = "../imagenes/".$logo;
            if(file_exists($carpeta)){ ?>
                <td width="180"><?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?></td><?php 
            }else{?>
                <td width="180"></td><?php
            } ?>
        <td width="460" class="datos" align="center" ><strong>Comprobante de Vales de Gasolina</strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <br>
            Calle: <?php echo $rowU['direccion']; ?><br> Colonia: <?php echo $rowU['colonia']; ?> C.P. <?php echo $rowU['codigopostal']; ?><BR> 
            <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <?php if($rowU['folio']>0){?>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $rowU['folio'];?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="verde">Fecha</td>
                    <td class="dato"><?php echo $rowU['fecha_registro'] ?></td>
                </tr>
                <tr>
                    <td class="verde">Hora</td>
                    <td class="dato"><?php echo $rowU['horas'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br><br>

<table width="710" class='borde_tabla'>
    <tr>
        <td class="verde">Observaciones: </td>
        <td stye="text-align:justify;"><?php echo normaliza($rowU['observaciones'],90) ?></td>
    </tr>
</table>

<br><br>

<table width="710" class='borde_tabla'>
    <tr class="encabezado">
        <td width="100" class="verde" align="left" >No. Nómina</td>
        <td width="215" class="verde" align="left" >Nombre</td>
        <td width="185" class="verde" align="left" >Departamento</td>
        <td width="120" class="verde" align="left" >No. Ecónomico</td>
        <td width="120" class="verde" align="left" >Monto</td>
    </tr>
    <tr>
        <td class="datos" align="left" ><?php echo $rowU['num_nomina'] ?></td>
        <td class="datos" align="left" ><?php echo normaliza($rowU['empleado'],27) ?></td>
        <td class="datos" align="left" ><?php echo normaliza($rowU['departamento'],25) ?></td>
        <td class="datos" align="left" ><?php echo normaliza($rowU['no_economico'],15) ?></td>
        <td class="datos" align="right" ><?php echo dos_decimales($rowU['importe']) ?></td>
    </tr>
</table>

<br><br>

<table width="710" class='borde_tabla'>
    <tr>
        <td class="verde">Fecha: </td>
        <td><?php echo $rowU['fecha'] ?></td>
    </tr>
</table>

<br><br>

<table width="710">
    <tr>
        <td width="370" align="center">ENTREGADO POR: </td>
        <td width="370" align="center">RECIBIDO POR: </td>
    </tr>
</table>

<br><br><br>

<table width="710">
    <tr>
        <td width="370"  align="center">___________________________________</td>
        <td width="370"  align="center">___________________________________</td>
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