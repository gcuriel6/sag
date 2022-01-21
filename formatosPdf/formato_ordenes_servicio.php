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
a.id AS folio,
UPPER(a.servicio) AS servicio,
UPPER(a.descripcion) AS descripcion,
a.proceso,
UPPER(a.acciones_realizadas) AS acciones_realizadas,
a.estatus_orden AS estatus,
a.fecha_servicio,
b.nombre AS unidad,
b.logo AS logo,
c.descr AS sucursal,c.codigopostal,
CONCAT(c.calle,' No. Ext ' ,c.no_exterior,(IF(c.no_interior!='','No. Int ','')),c.no_interior) AS direccion,
c.colonia AS colonia,
d.estado,
e.municipio,
DATE(a.fecha_captura) AS fecha_registro,
DATE_FORMAT(a.fecha_captura, '%H:%i:%S' ) AS horas,
f.razon_social, 
f.nombre_corto,
f.cuenta,
CONCAT(f.domicilio,' ',f.no_exterior,IF(f.no_interior!='',CONCAT(' INT:',f.no_interior),''),'<br> COL:',f.colonia)AS domicilio,
CONCAT(f.domicilio_s,' ',f.no_exterior_s,IF(f.no_interior_s!='',CONCAT(' INT:',f.no_interior_s),''),'<br> COL:',f.colonia_s)AS domicilio_s,
IFNULL(f.entre_calles_s,'') AS entre_calles_s,
IFNULL(j.estado,'') AS estado_s,
IFNULL(k.municipio,'') AS municipio_s,
f.contacto,
f.telefonos,
a.facturar,
IF(IFNULL(g.total,0)=0,h.cantidad,g.total)AS costo,
f.id_tipo_panel,
tipo_panel.nombre AS tipo_panel,
a.id_sucursal

            FROM servicios_ordenes a
            LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
            LEFT JOIN cat_unidades_negocio b ON c.id_unidad_negocio= b.id
            LEFT JOIN servicios f ON a.id_servicio = f.id
            LEFT JOIN estados d ON f.id_estado = d.id
            LEFT JOIN municipios e ON f.id_municipio = e.id
            LEFT JOIN estados j ON f.id_estado_s = j.id
            LEFT JOIN municipios k ON f.id_municipio_s = k.id
            LEFT JOIN cxc g ON a.id=g.id_orden_servicio AND g.cargo_inicial=1 AND g.estatus!='C'
            LEFT JOIN servicios_clasificacion h ON a.id_clasificacion_servicio=h.id
            LEFT JOIN tipo_panel ON f.id_tipo_panel=tipo_panel.id
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
	padding-left:5px;
    padding-right:5px;
    padding-top: 5px;
    padding-bottom: 5px;
	/*border: 1px solid #FCFBF9;*/
    border: 1px solid #333;
	font-size:13px;
	/*text-transform: capitalize;*/
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
            <td width="340" class="datos" align="center" >
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
            
            <!--<?php if($rowU['facturar']==1){?>
                <?php echo $rowU['domicilio']; ?> <br>
                <?php echo $rowU['municipio'];?>, <?php echo $rowU['estado'];?>.<br>
            <?php }else{?>
                <?php echo $rowU['domicilio_s']; ?> <br>
                <?php echo $rowU['municipio_s'];?>, <?php echo $rowU['estado_s'];?>.<br>
           <?php }?>-->

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

<table width="710" class='borde_tabla'>
    <tr>
        <td colspan="2" class="verde" align="left" ><strong>DATOS DEL CLIENTE:</strong></td>
        <td width="100" class="verde" align="left" >PANEL:</td>
        <td width="200"class="datos" align="left" ><?php echo $rowU['tipo_panel'] ?></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >CLIENTE:</td>
        <td  width="280" class="datos" align="left" ><?php echo $rowU['nombre_corto'] ?></td>
        <td width="100" class="verde" align="left" >CUENTA:</td>
        <td width="200"class="datos" align="left" ><?php echo $rowU['cuenta'] ?></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >DOMICILIO:</td>
        <td colspan="3" class="datos" align="left" ><?php echo $rowU['domicilio_s'] ?> <br>Entre calles: <?php echo $rowU['entre_calles_s'] ?> <br> Municipio: <?php echo $rowU['municipio_s'] ?></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >CONTACTO:</td>
        <td class="" style="font_size:13px;" align="left" ><?php echo $rowU['contacto'] ?></td>
        <td width="100" class="verde" align="left" >TELEFONO:</td>
        <td class="datos" align="left" ><?php echo $rowU['telefonos'] ?></td>
    </tr>
    <tr style="border:none;"><td colspan="2" style="border:none;"><br></td></tr>
    <tr>
        <td width="100" style="border:none;"><strong>TRABAJO:</strong><br><br><br></td>
        <td colspan="3"style="text-align:justify;"><?php echo normaliza($rowU['servicio'],80) ?></td>
    </tr>
</table>

<br>

<table width="700" class='borde_tabla'>
    <tr>
        <td width="110" class="verde" align="left" ><strong>COSTO:</strong></td>
        <td  width="100" style="border:2px solid #333;"><?php echo dos_decimales($rowU['costo']) ?></td>
        <td colspan="4"><?php echo numtoletras($rowU['costo']); ?></td>
    </tr>
    <tr>
        <td colspan="6" style="border:none;"></td>
    </tr>
    <tr>
        <td width="110" class="verde" align="left" >No.COTIZACIÓN:</td>
        <td  width="100" ></td>
        <td width="100" class="verde" align="left" >No.RECIBO:</td>
        <td  width="100" ></td>
        <td width="100" class="verde" align="left" >No.POLIZA:</td>
        <td  width="100" ></td>
        
    </tr>
    <tr>
        <td colspan="6" style="border:none;"></td>
    </tr>
    <tr>
        <td width="100" class="verde" align="left" >ASUNTO:</td>
        <td  width="100">ORDEN</td>
        <td  colspan="2" style="border:none;"></td>
        <td width="100" class="verde" align="left" >ESTATUS:</td>
        <td  width="100"></td>
        
    </tr>
    <tr>
        <td width="110" class="verde" align="left" >TEC.ELABORA:</td>
        <td  colspan="5"></td>
    </tr>  
    <tr>
        <td  colspan="6">
            <strong>OBSERVACIÓN:</strong><BR><BR>
            <p>FALLAS DETECTADAS:</p><BR>
            <p>POSIBLE CAUSA DE LA FALLA:</p><BR>
            <p style="text-align:justify;">ACCIÓN REALIZADA:<BR><?php echo normaliza($rowU['acciones_realizadas'],100) ?></p><BR>
            <p>SUGERENCIAS:</p><BR>

        </td>
    </tr>
</table>

<br><br>

<table width="710">
    <tr>
        <td width="170"></td>
        <td width="400"  align="center">___________________________________</td>
       
    </tr>
    <tr>
        <td width="170"></td>
        <td width="400" align="center">FIRMA DE CONFORMIDAD<BR> DEL CLIENTE </td>
        
    </tr>
</table>
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