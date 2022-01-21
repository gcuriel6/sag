<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idSucursal = $arreglo['idSucursal'];
$idUnidadNegocio = $arreglo['idUnidadNegocio'];
$idRegistro = $arreglo['idRegistro'];

$query = "SELECT 
c.fecha_corte_recibo as fecha_recibo,
e.nombre AS unidad,
e.logo AS logo,
d.descr AS sucursal,
d.codigopostal,
CONCAT(d.calle,' No. Ext ' ,d.no_exterior,(IF(d.no_interior!='','No. Int ','')),d.no_interior) AS direccion,
d.colonia AS colonia,
f.estado,
g.municipio
FROM servicios_bitacora_planes a
LEFT JOIN cxc c ON a.id=c.id_plan 
LEFT JOIN sucursales d ON c.id_sucursal=d.id_sucursal  
LEFT JOIN cat_unidades_negocio e ON d.id_unidad_negocio=e.id 
LEFT JOIN estados f ON d.id_estado = f.id
LEFT JOIN municipios g ON d.id_municipio = g.id
WHERE a.id=".$idRegistro." 
GROUP BY a.id_servicio
ORDER BY a.id ASC";
$consulta = mysqli_query($link,$query);
$t = mysqli_fetch_array($consulta);

$logo = $t['logo'];
$direccion = $t['direccion'];
$colonia = $t['colonia'];
$codigoPostal = $t['codigopostal'];
$municipio = $t['municipio'];
$estado = $t['estado'];
$sucursal = $t['sucursal'];
$fecha_recibo = $t['fecha_recibo'];

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
</style>

<page backtop="1mm"  backbottom="2mm">

    <div style="height:400px; padding-top:50px; padding-bottom:50px;">
    <table width="710" border="0">
        <tr>
             <!-- MGFS  08-01-2020 SE AGREGA VALIDACION PARA VER QUE LA IMAGEN EXISTA EN LA CARPETA 
        YA QUE SI NO EXISTE PUEDE MARCAR ERROR AL GENERAR EL PDF-->
        <?php
            $carpeta = "../imagenes/".$logo;
            if(file_exists($carpeta)){ ?>
                <td width="160"><?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?></td><?php 
            }else{?>
                <td width="160"></td><?php
            } ?>
            <td width="440" class="datos" align="center" ><strong>Recibo de Plan de Servicio</strong> <br>
                <label class='titulo'><strong><?php echo $sucursal; ?></strong></label><br>
                <br>
                Calle: <?php echo $direccion; ?> Colonia: <?php echo $colonia; ?> C.P. <?php echo $codigoPostal; ?><BR> 
                <?php echo $municipio;?>, <?php echo $estado;?>.<br>
            </td>
            <td width="110">
                <table class='borde_tabla'>
                    <tr>
                        <td class="verde">Fecha </td>
                        <td class="dato"><?php echo $fecha_recibo;?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <?php

        $queryP ="SELECT a.id,
        a.factura,
        a.dia_corte,
        IFNULL(c.id_plan,0) AS id_plan_cxc,
        d.tipo AS tipo_plan,
        d.meses,
        DATE(a.fecha_captura) AS fecha_captura,
        DATE(c.fecha) AS fecha_captura,
        IFNULL(b.nombre_corto,'') AS cliente,
        IFNULL(b.cuenta,'') AS cuenta,
        IFNULL(b.rfc,'') AS rfc,
        IFNULL(CONCAT(b.domicilio,' No. Ext ' ,b.no_exterior,(IF(b.no_interior!='','No. Int ','')),b.no_interior),'') AS direccion, 
        IFNULL(b.colonia,'') AS colonia, 
        IFNULL(e.estado,'') AS estado, 
        IFNULL(f.municipio,'') AS municipio,
        IFNULL(b.codigo_postal,'') AS codigo_postal,
        IF(b.entrega=0,'FISICA',IF(b.entrega=1,'CORREO','FISICA Y CORREO')) AS entrega,
        IF(b.pago='E','EFECTIVO','TRANSFERENCIA') AS pago,
        d.descripcion AS plan, 
        d.cantidad
        FROM servicios_bitacora_planes a
        INNER JOIN servicios b ON a.id_servicio=b.id
        LEFT JOIN cxc c ON a.id=c.id_plan 
        INNER JOIN servicios_cat_planes d ON a.id_plan=d.id
        LEFT JOIN estados e ON b.id_estado = e.id
        LEFT JOIN municipios f ON b.id_municipio = f.id
        WHERE a.id=$idRegistro
        GROUP BY a.id_servicio
        ORDER BY a.id ASC";
        $consultaP = mysqli_query($link,$queryP);
        $d = mysqli_fetch_array($consultaP);
   
        
        $plan = $d['plan'];
        $forma_entrega = $d['entrega'];
        $forma_pago = $d['pago'];
        $cliente = $d['cliente'];
        $cantidad = $d['cantidad'];
        $cuenta = $d['cuenta'];
        $direccion = $d['direccion'];
        $colonia = $d['colonia'];
        $estado = $d['estado'];
        $municipio = $d['municipio'];
        $codigo_postal = $d['codigo_postal'];
?>
    <table>
        <tr>
            <td class="verde">Cliente:</td>
            <td class="dato"><?php echo $cliente;?></td>
        </tr>
        <tr>
            <td class="verde">Cuenta:</td>
            <td class="dato"><?php echo $cuenta;?></td>
        </tr>
        <tr>
            <td class="verde">Direccion:</td>
            <td class="dato"><?php echo $direccion;?>
            <br>
            <?php echo $colonia.' C.P. '.$codigo_postal;?>
            <br>
            <?php echo $municipio.', '.$estado;?>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td class="verde">Plan:</td>
            <td class="dato"><?php echo $plan;?></td>
            <td class="verde">Costo:</td>
            <td class="dato"><?php echo dos_decimales($cantidad);?></td>
        </tr>
        <tr>
            <td class="verde">Forma Entrega:</td>
            <td class="dato"><?php echo $forma_entrega;?></td>
        </tr>
        <tr>
            <td class="verde">Forma Pago:</td>
            <td class="dato"><?php echo $forma_pago;?></td>
        </tr>
    </table>
    </div>

<br>
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
      $ntexto.=$aux[$cont]."<br> &nbsp;&nbsp;&nbsp;";
      $cont++;
    }
    return $ntexto;
  }
?>
