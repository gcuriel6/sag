<?php 
session_start();
include("../php/conectar.php");
include("../widgets/numerosLetras.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];

$query = "SELECT 
a.id AS folio_cxc,
a.tasa_iva,
a.iva,
a.subtotal,
a.total,
a.id_sucursal,
IF(a.id_orden_servicio > 0 ,'ORDEN DE SERVICIO',IF(a.id_plan>0,'PLAN',IF(a.id_venta>0,'VENTA','SERVICIO')))AS titulo,
IF(a.id_orden_servicio > 0 ,a.id_orden_servicio,IF(a.id_plan > 0 ,a.folio_recibo,IF(a.id_venta>0,a.folio_venta,a.id)))AS folio,
a.id_orden_servicio,
a.id_venta,
a.id_plan,
a.fecha_corte_recibo AS fecha_plan,
a.vencimiento as fecha_fin,
IF(a.estatus='P','Pendiente',IF(a.estatus='S','Saldado',IF(a.estatus='C','Cancelado','Timbrado'))) AS estatus,
b.nombre AS unidad,
b.logo AS logo,
c.descr AS sucursal,c.codigopostal,
CONCAT(c.calle,' No. Ext ' ,c.no_exterior,(IF(c.no_interior!='','No. Int ','')),c.no_interior) AS direccion,
c.colonia AS colonia,
UPPER(d.estado) AS estado,
UPPER(e.municipio) AS municipio,
DATE(a.fecha_captura) AS fecha_registro,
DATE_FORMAT(a.fecha_captura, '%H:%i:%S' ) AS horas,
IFNULL(f.razon_social,'') AS razon_social,
f.nombre_corto,
f.cuenta,
UPPER(CONCAT(f.domicilio,' ',f.no_exterior,IF(f.no_interior!='',CONCAT(' INT: ',f.no_interior),''),'<br> COL: ',f.colonia))AS domicilioF,
UPPER(CONCAT(f.domicilio_s,' ',f.no_exterior_s,IF(f.no_interior_s!='',CONCAT(' INT: ',f.no_interior_s),''),'<br> COL: ',f.colonia_s))AS domicilioS,
UPPER(j.estado) AS estado_s,
UPPER(k.municipio) AS municipio_s,
f.contacto,
f.telefonos,
a.concepto_cobro,
IFNULL(g.servicio,'')AS servicio,
IFNULL(g.descripcion,'')AS descripcion,
IFNULL(g.proceso,'')AS proceso,
IFNULL(g.acciones_realizadas,'')AS acciones_realizadas,
IFNULL(g.fecha_servicio,'')AS fecha_servicio,
if(a.b_fecha_extraordinaria=1,a.descripcion_plan,i.descripcion) AS des_plan,
IF(f.entrega=0,'FISICA',IF(f.entrega=1,'CORREO','FISICA Y CORREO')) AS entrega,
IF(f.pago='E','EFECTIVO','TRANSFERENCIA') AS pago
FROM cxc a
LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
LEFT JOIN cat_unidades_negocio b ON c.id_unidad_negocio= b.id
LEFT JOIN servicios f ON a.id_razon_social_servicio = f.id
LEFT JOIN estados d ON f.id_estado = d.id
LEFT JOIN municipios e ON f.id_municipio = e.id
LEFT JOIN estados j ON f.id_estado_s = j.id
LEFT JOIN municipios k ON f.id_municipio_s = k.id
LEFT JOIN servicios_ordenes g  ON g.id=a.id_orden_servicio AND a.cargo_inicial=1
LEFT JOIN servicios_bitacora_planes h ON a.id_plan=h.id
LEFT JOIN servicios_cat_planes i ON h.id_plan=i.id
WHERE a.id=".$idRegistro;

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
	padding:5px;
    border: 1px solid #333;
	/*border: 1px solid #FCFBF9;*/
	font-size:13px;
	/*text-transform: capitalize;*/
    vertical-align:top;
    border-radius:3px;
	
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
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="3mm"  backbottom="5mm">

<table width="710" border="0">
    <tr>
    <?php
    $carpeta = "../imagenes/".$logo;
    if(file_exists($carpeta)){ ?>
        <!--NJES March/24/2021 si la sucursal es SEYCOM mostrar ese logo tambien-->
        <?php if($id_sucursal == 57) {?>
                <td width="135" align="top">
            <?php }else{ ?>
                <td width="180" align="top">
            <?php } ?>
        <?php echo '<img src="../imagenes/'.$logo.'"  width="150" height="50"/>';?></td><?php 
    }else{?>
        <td width="180"></td><?php
    } ?>

        <?php if($id_sucursal == 57) {?>
            <td width="340" class="datos" align="center" >
        <?php }else{ ?>
            <td width="450" class="datos" align="center" >
        <?php } ?>
        <strong><?php echo $rowU['titulo']; ?></strong> <br>
            <label class='titulo'><strong><?php echo $rowU['sucursal']; ?></strong></label><br>
            <br>
            Calle: <?php echo $rowU['domicilioF']?><!-- <?php echo $rowU['direccion']; ?> Colonia: <?php echo $rowU['colonia']; ?> C.P. <?php echo $rowU['codigopostal']; ?>--><BR> 
            <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>
        </td>

        <?php if($id_sucursal == 57) {?>
            <td width="140" align="top">
                <?php echo '<img src="../imagenes/seycom.png"  width="120"/>';?>
            </td>
            <td width="100">
        <?php }else{ ?>
            <td width="110">
        <?php } ?>
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $rowU['folio'];?></td>
                </tr>
                <tr>
                <td class="verde" align="left" >Fecha:</td>
                <?php if($rowU['id_venta']> 0 ){ ?>
                    <td class="datos" align="left" ><?php echo $rowU['fecha_registro'] ?></td>
                <?php }else if($rowU['id_orden_servicio']){ ?>
                    <td class="datos" align="left" ><?php echo $rowU['fecha_servicio'] ?></td>
                <?php }else{?>
                    <td class="datos" align="left" ><?php echo $rowU['fecha_plan'] ?></td>
                <?php } ?>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="710" class='borde_tabla'>
    <tr>
        <td colspan="6" align="left" ><strong>DATOS DEL CLIENTE:</strong></td>

    </tr>
    <tr>
        <td width="100" class="verde" align="left" >CLIENTE:</td>
        <td  width="280" class="datos" align="left" ><?php echo $rowU['nombre_corto'] ?></td>
        <td width="100" class="verde" align="left" >CUENTA:</td>
        <td width="200"class="datos" align="left" ><?php echo $rowU['cuenta'] ?></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >DOMICILIO:</td>
        <td colspan="3" class="datos" align="left" ><?php echo $rowU['domicilioS'].'.  &nbsp;&nbsp;   '.$rowU['municipio_s'];?>, <?php echo $rowU['estado_s'];?>.<br></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >CONTACTO:</td>
        <td  align="left" ><?php echo $rowU['contacto'] ?></td>
        <td width="100" class="verde" align="left" >TELEFONO:</td>
        <td class="datos" align="left" ><?php echo $rowU['telefonos'] ?></td>
    </tr>
    </table>
    <table width="710" class='borde_tabla'>
    <?php if($rowU['id_plan']> 0 ){ ?>
    <tr>
        <td width="100" class="verde" align="left" >FORMA ENTREGA:</td>
        <td width="70" class="datos" align="left" ><?php echo $rowU['entrega'] ?></td>

        <td width="90" class="verde" align="left" >FORMA PAGO:</td>
        <td width="160" class="datos" align="left" ><?php echo $rowU['pago'] ?></td>

        <td width="60" class="verde" align="left" >PERIODO:</td>
        <td width="147" class="datos" align="left" ><?php echo $rowU['fecha_plan'].' - '.$rowU['fecha_fin'] ?></td>
    </tr>
    <?php } ?>
    <tr><td style="border:none;"></td></tr>
</table>
<?php if($rowU['id_plan']> 0 ){ ?>
    <table class="borde_tabla" width="710" cellspacing="0" cellpading="0">
    <thead>
        <tr class="encabezado">
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Unidad</td>
            <td width='250' align="center">Servicio</td>
            <td width='100' align="center">Precio Unitario</td>
            <td width='100' align="center">Importe</td>
        </tr>

    </thead>
    <tbody>
        <tr>
            <td align="center" style='border:none;border-left:1px solid #333;border-radius:0px;' align='center'>1</td>
            <td align="center" style="border:none;">SERVICIO</td>
            <td style="text-align:justify;border:none;"><?php echo normaliza($rowU['des_plan'],30) ?></td>
            <td align="right" style="border:none;"><?php echo dos_decimales($rowU['total']);?></td>
            <td align="right" style='border:none;border-right:1px solid #333;border-radius:0px;' align='center'><?php echo dos_decimales($rowU['total']);?></td>
        </tr>
        <tr><td colspan="5" style='border:none;border-right:1px solid #333;border:none;border-bottom:1px solid #333;border:none;border-left:1px solid #333;border-radius:0px;'></td></tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" align="left"><strong>CANTIDAD CON LETRA:</strong><?php echo numtoletras($rowU['total']); ?></td>
            <td align="center"><strong>TOTAL</strong></td>
            <td align="center"><?php echo dos_decimales($rowU['total']);?></td>
        </tr>
    </tfoot>
    </table>
    <br>
    <table width="720">
        <tr>
            <td width="300" style="text-align:justify; font-size:10px;">POR ESTE PAGARÉ ME(NOS) OBLIGO(AMOS) A PAGAR INCONDICIONALMENTE A LA 
                ORDEN DE SERCORP ALARMAS S DE RL DE CV EN ESTA CIUDAD 
                EN SU DOMICILIO <br>EL DIA  _____  DE  ________________________  DE __________ 
                <br>LA CANTIDAD DE: $ __________________________________<br>
                (___________________________________________________)
                SI ESTE PAGARÉ NO FUESE CUBIERTO EN SU VENCIMIENTO CAUSARÁ INTERÉS MORATORIO 
                DEL _________% MENSUAL HASTA SU TOTAL LIQUIDACIÓN.
            </td>
            <td width="450" align="right"><strong>ACEPTO Y PAGARÉ</strong>___________________________
            </td>
        </tr>
    </table>

<?php }else if($rowU['id_orden_servicio']> 0 ){ ?>
    <table class="borde_tabla" width="710" cellspacing="0" cellpading="0">
    <thead>
        <tr class="encabezado">
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Unidad</td>
            <td width='250' align="center">Servicio</td>
            <td width='100' align="center">Precio Unitario</td>
            <td width='100' align="center">Importe</td>
        </tr>

    </thead>
    <tbody>
        <tr>
            <td align="center" style='border:none;border-left:1px solid #333;border-radius:0px;' align='center'>1</td>
            <td align="center" style="border:none;">SERVICIO</td>
            <!--NJES March/18/2020 se agrega concepto cobro-->
            <td style="text-align:justify;border:none;"><?php echo normaliza($rowU['concepto_cobro'],30) ?></td>
            <td align="right" style="border:none;"><?php echo dos_decimales($rowU['total']);?></td>
            <td align="right" style='border:none;border-right:1px solid #333;border-radius:0px;' align='center'><?php echo dos_decimales($rowU['total']);?></td>
        </tr>
        <tr><td colspan="5" style='border:none;border-right:1px solid #333;border:none;border-bottom:1px solid #333;border:none;border-left:1px solid #333;border-radius:0px;'></td></tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" align="left"><strong>CANTIDAD CON LETRA:</strong><?php echo numtoletras($rowU['total']); ?></td>
            <td align="center"><strong>TOTAL</strong></td>
            <td align="center"><?php echo dos_decimales($rowU['total']);?></td>
        </tr>
    </tfoot>
    </table>
    <br>
    <table width="720">
        <tr>
            <td width="300" style="text-align:justify; font-size:10px;">POR ESTE PAGARÉ ME(NOS) OBLIGO(AMOS) A PAGAR INCONDICIONALMENTE A LA 
                ORDEN DE SERCORP ALARMAS S DE RL DE CV EN ESTA CIUDAD 
                EN SU DOMICILIO <br>EL DIA  _____  DE  ________________________  DE __________ 
                <br>LA CANTIDAD DE: $ __________________________________<br>
                (___________________________________________________)
                SI ESTE PAGARÉ NO FUESE CUBIERTO EN SU VENCIMIENTO CAUSARÁ INTERÉS MORATORIO 
                DEL _________% MENSUAL HASTA SU TOTAL LIQUIDACIÓN.
            </td>
            <td width="450" align="right"><strong>ACEPTO Y PAGARÉ</strong>___________________________
            </td>
        </tr>
    </table>

<?php }else{ ?>
    <!---- Productos---->
    <?php  
    
    $queryE="SELECT a.id_producto,
                    ifnull(a.clave,'') as clave,
                    a.precio,
                    a.cantidad,
                    a.producto,
                    b.descripcion,
                    (a.precio * a.cantidad) AS importe
                    FROM notas_d a
                    LEFT JOIN productos b ON a.id_producto=b.id
                    WHERE a.id_nota_e=".$rowU['id_venta']."
                    ORDER BY a.id";
    $consultaE = mysqli_query($link,$queryE);
    $numeroFilasE = mysqli_num_rows($consultaE); 
    if($numeroFilasE>0){    
    ?>
    <table class="borde_tabla" width="710" cellspacing="0" cellpading="0">
    <thead>
        <tr class="encabezado">
            <td width='80' align="center">Cantidad</td>
            <td width='100' align="center">Clave</td>
            <td width='200' align="center">Producto</td>
            <td width='120' align="center">Precio Unitario</td>
            <td width='120' align="center">Importe</td>
        </tr>
    </thead>
    <tbody>
    <?php
    
    while ($rowE = mysqli_fetch_array($consultaE)){
        
        
        echo   "<tr>
                    <td width='80' style='border:none;border-left:1px solid #333;border-radius:0px;' align='center'>".$rowE['cantidad']."</td> 
                    <td width='100' style='border:none;'>".$rowE['clave']."</td> 
                    <td width='200' style='border:none;'>".$rowE['producto']."</td>
                    <td width='120' style='border:none;' align='right'>".dos_decimales($rowE['precio'])."</td>
                    <td width='120' style='border:none;border-right:1px solid #333;border-radius:0px;' align='right'>".dos_decimales($rowE['importe'])."</td>           
                </tr>";
    
    }
    ?> 
    <tr><td colspan="5" style='border:none;border-right:1px solid #333;border:none;border-bottom:1px solid #333;border:none;border-left:1px solid #333;border-radius:0px;'></td></tr>
    </tbody>
    <tfoot>
        
        <tr>
            <td colspan="3" rowspan="3" align="left"><strong>CANTIDAD CON LETRA:</strong><?php echo normaliza(numtoletras($rowU['total']),40); ?></td>
            <td align="right"><strong>SUBTOTAL</strong></td>
            <td align="right"><?php echo dos_decimales($rowU['subtotal'])?></td>
        </tr>
        <tr>
            <td align="right"><strong><label style="font-size:10px;">TASA IVA </label><?php echo $rowU['tasa_iva'];?>% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I.V.A.</strong></td>
            <td align="right"><?php echo dos_decimales($rowU['iva'])?></td>
        </tr>
        <tr>
            <td align="right"><strong>TOTAL</strong></td>
            <td align="right"><?php echo dos_decimales($rowU['total'])?></td>
        </tr>
    </tfoot>
    </table>
    <br>
    <table width="720">
        <tr>
            <td width="300" style="text-align:justify; font-size:10px;">POR ESTE PAGARÉ ME(NOS) OBLIGO(AMOS) A PAGAR INCONDICIONALMENTE A LA 
            ORDEN DE SERCORP ALARMAS S DE RL DE CV EN ESTA CIUDAD 
            EN SU DOMICILIO <br>EL DIA  _____  DE  ________________________  DE __________ 
            <br>LA CANTIDAD DE: $ __________________________________<br>
            (___________________________________________________)
            SI ESTE PAGARÉ NO FUESE CUBIERTO EN SU VENCIMIENTO CAUSARÁ INTERÉS MORATORIO 
            DEL _________% MENSUAL HASTA SU TOTAL LIQUIDACIÓN.</td>
            <td width="450" align="right"><strong>ACEPTO Y PAGARÉ</strong>___________________________
            </td>
        </tr>
    </table>
    <?php }?>
<?php } ?>

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