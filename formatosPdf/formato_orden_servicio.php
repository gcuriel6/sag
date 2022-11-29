<?php 
session_start();
include("../php/conectar.php");
include("../widgets/numerosLetras.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];
$modulo = isset($arreglo['modulo']) ? $arreglo['modulo'] : '';

$query = "SELECT 
    a.id AS folio,
    UPPER(a.servicio) AS servicio,
    UPPER(a.descripcion) AS descripcion,
    a.proceso,
    a.acciones_realizadas,
    a.estatus_orden AS estatus,
    a.fecha_servicio,
    a.fecha_solicitud,
    b.nombre AS unidad,
    b.logo AS logo,
    c.descr AS sucursal,c.codigopostal,
    CONCAT(c.calle,' No. Ext ' ,c.no_exterior,(IF(c.no_interior!='','No. Int ','')),c.no_interior) AS direccion,
    c.colonia AS colonia,
    d.estado,
    e.municipio,
    DATE(a.fecha_captura) AS fecha_registro,
    DATE_FORMAT(a.fecha_captura, '%H:%i:%S' ) AS horas,
    IFNULL(f.razon_social,'') AS razon_social, 
    f.nombre_corto,
    f.cuenta,
    CONCAT('CALLE:', f.domicilio,' ',f.no_exterior,IF(f.no_interior!='',CONCAT(' INT:',f.no_interior),''),'<br> COL:',f.colonia)AS domicilio_f,
    CONCAT('CALLE:',  f.domicilio_s,' ',f.no_exterior_s,IF(f.no_interior_s!='',CONCAT(' INT:',f.no_interior_s),''),'<br> COL:',f.colonia_s)AS domicilio_s,
    IFNULL(f.entre_calles_s,'') AS entre_calles_s,
    IFNULL(ms.municipio,'') AS municipio_s,
    f.contacto,
    f.telefonos,
    IF(IFNULL(g.total,0)=0,h.cantidad,g.total)AS costo,
    i.usuario,
    i.nombre_comp as nombre,
    f.tipo_recibo_facura AS facturar,
    h.descripcion AS clasificacion_servicio,
    a.id_sucursal,
    f.latitud,
    f.longitud,
    f.cuenta,
    f.telefonos,
    a.facturar
FROM servicios_ordenes a
LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
LEFT JOIN cat_unidades_negocio b ON c.id_unidad_negocio= b.id
LEFT JOIN estados d ON c.id_estado = d.id
LEFT JOIN municipios e ON c.id_municipio = e.id
LEFT JOIN servicios f ON a.id_servicio = f.id
LEFT JOIN municipios ms ON f.id_municipio_s = ms.id
LEFT JOIN cxc g ON a.id=g.id_orden_servicio AND g.cargo_inicial=1 AND g.estatus!='C'
LEFT JOIN servicios_clasificacion h ON a.id_clasificacion_servicio=h.id
LEFT JOIN usuarios i ON a.id_usuario_captura= i.id_usuario
WHERE a.id=".$idRegistro;

$consulta = mysqli_query($link, $query);
$rowU = mysqli_fetch_array($consulta);
$logo = $rowU['logo'];
$domicilio_s = $rowU['domicilio_s'];
$domicilio_f = $rowU['domicilio_f'];
$facturar = $rowU['facturar'];
$entre_calles_s = $rowU['entre_calles_s'];
$municipio_s = $rowU['municipio_s'];

$id_sucursal = $rowU['id_sucursal'];

$latitud = $rowU['latitud'];
$longitud = $rowU['longitud'];
$cuenta = $rowU['cuenta'];
$telefonos = $rowU["telefonos"];
$facturar = $rowU["facturar"] == 1 ? "Si" : "No";

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
    /*border: 1px solid #333;*/
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
            <td width="140" align="top">
        <?php }else{ ?>
            <td width="180" align="top">
        <?php } ?>
        <?php echo '<img src="../imagenes/'.$logo.'"  width="150" height="50"/>';?></td><?php 
    }else{?>
        <td width="180"></td><?php
    } ?>
        <?php if($id_sucursal == 57) {?>
            <td width="335" class="datos" align="center" >
        <?php }else{ ?>
            <td width="440" class="datos" align="center" >
        <?php } ?>
            <strong>Orden de Servicio</strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <br>

            <!--NJES October/06/2020 que se muestre en el encabezado, la dirección de la sucursal y no la dirección fiscal del cliente-->
            Calle: <?php echo $rowU['direccion']; ?><br> 
            Colonia: <?php echo $rowU['colonia']; ?><br> 
            C.P. <?php echo $rowU['codigopostal']; ?><BR> 
            <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>
            
            <!--<?php if($facturar==1){ 
                echo $domicilio_f; 
            }else{?>
                 Calle: <?php echo $rowU['direccion']; ?> Colonia: <?php echo $rowU['colonia']; ?> C.P. <?php echo $rowU['codigopostal']; ?><BR> 
            <?php } echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>-->

        </td>
        <?php if($id_sucursal == 57) {?>
            <td width="130" align="top">
                <?php echo '<img src="../imagenes/seycom.png"  width="120"/>';?>
            </td>
            <td width="100">
        <?php }else{ ?>
            <td width="130">
        <?php } ?>
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">FOLIO </td>
                  <td class="dato"><?php echo $rowU['folio'];?></td>
                </tr>
                <tr>
                    <td class="verde" align="left" >FECHA:</td>
                    <td class="datos" align="left" ><?php echo $rowU['fecha_servicio'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<table width="100%">
    <tr>
        <td>
            <table width="100%">
                <tr><th>USUARIO CAPTURÓ:</th></tr>
                <tr><td><?php echo $rowU['usuario'].'-'.$rowU['nombre'] ?></td></tr>
                <tr><th>CLIENTE:</th></tr>
                <tr><td><?php echo $rowU['nombre_corto'] ?></td></tr>
                <tr><th>CUENTA:</th></tr>
                <tr><td><?php echo $rowU['cuenta'] ?></td></tr>
                <tr><th>DOMICILIO:</th></tr>
                <tr><td><?php echo $domicilio_s ?></td></tr>
                <tr><th>CONTACTO:</th></tr>
                <tr><td><?php echo $rowU['contacto'] ?></td></tr>
                <tr><th>TELEFONO:</th></tr>
                <tr><td><?php echo $rowU['telefonos'] ?></td></tr>
            </table>
        </td>
        <td>
            <img src="<?php echo "https://maps.googleapis.com/maps/api/staticmap?center=$latitud,$longitud&zoom=16&size=500x250&key=AIzaSyBoD4mBMwf4boXGnAKMeC_-VK9NaON_W2w&markers=$latitud,$longitud";?>">
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <th>FECHA SERVICIO:</th>
        <td><?php echo $rowU['fecha_solicitud'] ?></td>
    </tr>
    <tr>
        <th>FECHA PROGRAMADA:</th>
        <td><?php echo $rowU['fecha_servicio'] ?></td>
    </tr>
    <tr>
        <th>SERVICIO:</th>
        <td><?php echo normaliza($rowU['servicio'],70) ?></td>
    </tr>
    <tr>
        <th>CLASIFICACIÓN:</th>
        <td><?php echo normaliza($rowU['clasificacion_servicio'],70) ?></td>
    </tr>
    <tr>
        <th>DESCRIPCIÓN:</th>
        <td><?php echo normaliza($rowU['descripcion'],70) ?></td>
    </tr>
</table>
<hr>

<?php if($modulo == 'orden_servicio')
{ ?>
<table>
    <tr><td width="750" style="padding-bottom:20px;">TRABAJO REALIZADO</td></tr>
    <tr><td style="padding-bottom:20px;">_____________________________________________________________________________________________________</td></tr>
    <tr><td style="padding-bottom:20px;">_____________________________________________________________________________________________________</td></tr>
    <tr><td width="750" style="padding-bottom:20px;">TÉCNICO, NOMBRE Y FORMA</td></tr>
    <tr><td style="padding-bottom:20px;">_____________________________________________________________________________________________________</td></tr>
    <tr><td width="750" style="padding-bottom:20px;">FECHA EN QUE SE REALIZÓ EL SERVICIO</td></tr>
    <tr><td style="padding-bottom:20px;">_____________________________________________________________________________________________________</td></tr>
    <tr><td width="750" style="padding-bottom:20px;">COSTO</td></tr>
    <tr><td>_____________________________________________________________________________________________________</td></tr>
</table>
<?php } ?>



<page_footer>
<BR>
<hr style="color:red;">
<table width="710">
    <tr>
        <td width="300" align="center">
            Calle: <?php echo $rowU['direccion']; ?> <BR>Colonia: <?php echo $rowU['colonia']; ?> C.P. <?php echo $rowU['codigopostal']; ?><BR> 
            <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.
        </td>
        <td width="200"  align="center">WWW.SECORP.MX</td>
        <td width="300"  align="center">CONTACTO 24H:<BR>TEL:(614) 415 0252<BR>monitoreo@secorp.mx</td>
       
    </tr>
</table>
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