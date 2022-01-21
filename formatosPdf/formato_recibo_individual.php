<?php 
session_start();
include("conectar.php");
$link = Conectarse();
include('../models/Recibos.php');
include("../widgets/numerosLetras.php");

$modelRecibos = new Recibos();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idSucursal = $arreglo['idSucursal'];
$idUnidadNegocio = $arreglo['idUnidadNegocio'];
$idServicio = $arreglo['idServicio'];
$datosRecibo = $arreglo['datosRecibo'];

$rowU = $modelRecibos->obtenerDatosSucursal($idSucursal);
foreach($rowU as $t)
{
    $logo = $t['logo'];
    $sucursal = $t['sucursal'];
}

//foreach($datosRecibo as $d)
//{
    $id_plan = $datosRecibo['id'];
    $forma_entrega = $datosRecibo['entrega'];
    $forma_pago = $datosRecibo['pago'];
    $cliente = $datosRecibo['nombre_corto'];
    $cuenta = $datosRecibo['cuenta'];
    $direccion = $datosRecibo['direccion'];
    $colonia = $datosRecibo['colonia'];
    $estado = $datosRecibo['estado'];
    $municipio = $datosRecibo['municipio'];
    $codigo_postal = $datosRecibo['codigo_postal'];
    $direccionS = $datosRecibo['direccion_s'];
    $coloniaS = $datosRecibo['colonia_s'];
    $estadoS = $datosRecibo['estado_s'];
    $municipioS = $datosRecibo['municipio_s'];
    $codigo_postalS = $datosRecibo['codigo_postal_s'];
    $especificaciones_cobranza = $datosRecibo['especificaciones_cobranza'];
    $factura = $datosRecibo['factura'];
    $contacto = $datosRecibo['contacto'];
    $telefono = $datosRecibo['telefono'];
    $fecha_recibo = isset($datosRecibo['fecha_recibo']) ? $datosRecibo['fecha_recibo'] : '';

    $recibo_extraordinario = $datosRecibo['recibo_extraordinario'];
    $precio_extraordinario = isset($datosRecibo['precio_extraordinario']) ? $datosRecibo['precio_extraordinario'] : 0;
    $descripcion_extra = isset($datosRecibo['descripcion_extra']) ? $datosRecibo['descripcion_extra'] : '';

    if($recibo_extraordinario == 1)
    {
        $plan = $descripcion_extra;
        $cantidad = $precio_extraordinario;
    }else{
        $plan = $datosRecibo['plan'];
        $cantidad = $datosRecibo['cantidad'];
    }
    
    
   
    $query = "SELECT id,folio_recibo,vencimiento
                FROM cxc 
                WHERE id_plan=$id_plan AND fecha_corte_recibo='$fecha_recibo' AND estatus!='C'";
    
    $consulta = mysqli_query($link,$query);
    $row = mysqli_fetch_array($consulta);

    $folio_recibo = $row['folio_recibo'];
    $vencimiento = $row['vencimiento'];
//}

?>
<style>
table td{
    font-size:13px;
	font-weight:100;	
}
.borde_tabla td{
	padding-left:5px;
    padding-right:5px;
    padding-top: 2px;
    padding-bottom: 1px;
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

<!--<page backtop="1mm"  backbottom="2mm">-->
<?php
     
        for($i=1;$i<=2;$i++)
        {
            if($i==1)
                $reciboT = 'CLIENTE';
            else
                $reciboT = 'ALARMAS';
        
?>
<?php
        if($i==1){
?>
    <page backtop="1mm"  backbottom="2mm">
<?php
    }
?>
    <!--<div style="padding-top:10px; padding-bottom:10px;">-->
    <table width="710" border="0">
        <tr>
        <?php
        $carpeta = "../imagenes/".$logo;
        if(file_exists($carpeta)){ ?>
             <!--NJES April/'5/2021 si la sucursal es SEYCOM mostrar ese logo tambien-->
             <?php if($idSucursal == 57) {?>
                    <td width="150" align="top">
                <?php }else{ ?>
                    <td width="180" align="top">
                <?php } ?>
                <?php echo '<img src="../imagenes/'.$logo.'"  width="150"/>';?></td><?php 
        }else{?>
            <td width="180"></td><?php
        } ?>
            <?php if($idSucursal == 57) {?>
                <td width="315" class="datos" align="center" >
            <?php }else{ ?>
                <td width="410" class="datos" align="center" >
            <?php } ?>
            <strong>Recibo de Plan de Servicio</strong> <br>
                <label><strong><?php echo $sucursal; ?></strong></label><br>
                <br>
                <?php if($factura==1){ ?>
                    <?php echo $factura; ?> CALLE: <?php echo $direccion; ?> COLONIA: <?php echo $colonia; ?> C.P. <?php echo $codigo_postal; ?><BR> 
                    <?php echo $municipio;?>, <?php echo $estado;?>.<br>
                <?php }else{ ?>
                    <?php echo $factura; ?> CALLE: <?php echo $direccionS; ?> COLONIA: <?php echo $coloniaS; ?> C.P. <?php echo $codigo_postalS; ?><BR> 
                    <?php echo $municipioS;?>, <?php echo $estadoS;?>.<br>
                <?php } ?>        
               
            </td>
            <?php if($idSucursal == 57) {?>
                <td width="100" align="top">
                    <?php echo '<img src="../imagenes/seycom.png"  width="120"/>';?>
                </td>
                <td width="100">
            <?php }else{ ?>
                <td width="150">
            <?php } ?>
                <table class='borde_tabla'>
                    <tr>
                        <td class="verde" width="37"> Folio </td>
                        <td class="dato" align="center"><?php echo $folio_recibo;?></td>
                    </tr>
                    <tr>
                        <td class="verde"> Fecha </td>
                        <td class="dato"> <?php echo $fecha_recibo;?> </td>
                    </tr>
                    <tr>
                        <td class="verde" colspan="2" align="center"><?php echo $reciboT;?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table width="710" class='borde_tabla'>
        <tr>
            <td colspan="4" class="verde" align="left" ><strong>DATOS DEL CLIENTE:</strong></td>
        </tr>
        <tr>
            <td width="100" class="verde" align="left" >CLIENTE:</td>
            <td  width="280" class="datos" align="left" ><?php echo $cliente; ?></td>
            <td width="100" class="verde" align="left" >CUENTA:</td>
            <td width="165"class="datos" align="left" ><?php echo $cuenta; ?></td>
        </tr>
        <tr>
            <td width="100" class="verde" align="left" >DOMICILIO:</td>
            <td colspan="3" class="datos" align="left" >
                <?php echo normaliza($direccionS.', '.$coloniaS.' C.P. '.$codigo_postalS.'. '.$municipioS.', '.$estadoS,90); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="left" >CONTACTO:</td>
            <td class="datos" align="left" ><?php echo $contacto; ?></td>
            <td width="100" class="verde" align="left" >TELEFONO:</td>
            <td class="datos" align="left" ><?php echo $telefono; ?></td>
        </tr>
    </table>
    <table class='borde_tabla'>
        <tr>
            <td width="100" class="verde" align="left" >FORMA ENTREGA:</td>
            <td width="90" class="datos" align="left" ><?php echo $forma_entrega; ?></td>
            <td width="95" class="verde" align="left" >FORMA PAGO:</td>
            <td width="95" class="datos" align="left" ><?php echo $forma_pago; ?></td>
            <td width="65" class="verde" align="left" >PERIODO:</td>
            <td width="150" class="datos" align="center" ><?php echo $fecha_recibo.' - '.$vencimiento; ?></td>
        </tr>
    </table>
    <br>
    <table class="borde_tabla" cellspacing="0" cellpading="0">
        <tr class="encabezado">
            <td width='50' align="center">Cantidad</td>
            <td width='90' align="center">Unidad</td>
            <td width='280' align="center">Servicio</td>
            <td width='100' align="center">Precio Unitario</td>
            <td width='110' align="center">Importe</td>
        </tr>
        <tr>
            <td align="center" style='border:none;border-left:1px solid #333;border-radius:0px;' align='center'>1</td>
            <td align="center" style="border:none;">Servicio</td>
            <td style="text-align:justify;border:none;"><?php echo normaliza($plan,37); ?></td>
            <td align="right" style="border:none;"><?php echo dos_decimales($cantidad);?></td>
            <td align="right" style='border:none;border-right:1px solid #333;border-radius:0px;' align='center'><?php echo dos_decimales($cantidad);?></td>
        </tr>
        <tr>
            <td colspan="3" align="left"><strong>CANTIDAD CON LETRA:</strong>
                <br><?php echo normaliza(numtoletras($cantidad),70); ?>
            </td>
            <td align="center"><br><strong>TOTAL</strong></td>
            <td align="center"><br><?php echo dos_decimales($cantidad);?></td>
        </tr>
    </table>
    <table class="borde_tabla">
        <tr class="encabezado">
            <td width="726">Especificaciones Cobranza</td>
        </tr>
        <tr>
            <td><?php echo normaliza($especificaciones_cobranza,100);?></td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td width="400" style="text-align:justify; font-size:9.5px;">POR ESTE PAGARÉ ME(NOS) OBLIGO(AMOS) A PAGAR INCONDICIONALMENTE A LA 
                ORDEN DE SERCORP ALARMAS S DE RL DE CV EN ESTA CIUDAD 
                EN SU DOMICILIO <br>EL DIA  _____  DE  ________________________  DE __________ 
                <br>LA CANTIDAD DE: $ __________________________________<br>
                (___________________________________________________)
                SI ESTE PAGARÉ NO FUESE CUBIERTO EN SU VENCIMIENTO CAUSARÁ INTERÉS MORATORIO 
                DEL _________% MENSUAL HASTA SU TOTAL LIQUIDACIÓN.
            </td>
            <td width="340" align="right"><br><br><br><strong>ACEPTO Y PAGARÉ</strong>_______________________
            </td>
        </tr>
    </table>
    <?php
        if($i==1){
    ?>
    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    <?php
        }else{
    ?>
    </page>
    <?php
        }
    ?>
    <!--</div>-->
<?php 
        }
   // }
?>
<br>
<!--</page>-->
          
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
