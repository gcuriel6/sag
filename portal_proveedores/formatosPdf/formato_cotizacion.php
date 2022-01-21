<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datos=$_REQUEST['datos'];

$arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idCotizacion = $arreglo['idRegistro'];
$textoInicio = $arreglo['textoInicio'];
$textoFin = $arreglo['textoFin'];

// Informacion de la empresa 
$query = "SELECT 
a.folio,
a.nombre,
a.estatus AS estatus_cotizacion,
a.id_cliente,
a.firma_digital,
DATE(a.timestamp_version) AS fecha,
b.descripcion AS proyecto,
d.descr AS sucursal,
d.codigopostal,
CONCAT(d.calle,' No. Ext ' ,d.no_exterior,(IF(d.no_interior!='','No. Int ','')),d.no_interior) AS direccion,
IFNULL(h.nombre,'') AS firmante,
IFNULL(h.firma,'') AS firma,
i.nombre AS unidad_negocio,
i.logo,
j.razon_social AS razon_social_emisora
FROM cotizacion a
LEFT JOIN proyecto b ON a.id_proyecto=b.id
LEFT JOIN sucursales d ON b.id_sucursal=d.id_sucursal
LEFT JOIN cat_unidades_negocio i ON b.id_unidad_negocio=i.id
LEFT JOIN cat_firmantes h ON a.id_firmante=h.id
LEFT JOIN empresas_fiscales j ON a.id_razon_social_emisora=j.id_empresa
WHERE a.id=".$idCotizacion;
$consulta = mysqli_query($link,$query);
$rowU = mysqli_fetch_array($consulta);
//---datos sucursal---
$nombre = $rowU['nombre'];
$sucursal =$rowU['razon_social_emisora'];
$domicilio = $rowU['direccion'];
$municipio = 'Aguascalientes';
$estado_corto = 'Ags';
$cp = $rowU['codigopostal'];
$fecha = $rowU['fecha'];
$logo = $rowU['logo'];
$nombreCliente = $rowU['cliente'];
$folioCotizacion = $rowU['folio'];



      
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

</style>
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="3mm"  backbottom="5mm">

<table width="710" border="0">
    <tr>
        <td width="200" align="top"><?php echo '<img src="../imagenes/'.$rowU['logo'].'"  width="150"/>';?></td>
        <td width="400" class="datos" align="center" ><strong>COTIZACIÓN</strong> <br>
            <label class='titulo'><strong><?php echo $sucursal; ?></strong></label><br>
            <?php echo $domicilio; ?><BR> 
            CP:<?php echo $cp;?>.<br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $folioCotizacion;?></td>
                </tr>
                <tr>
                    <td class="verde">Fecha</td>
                    <td class="dato"><?php echo $fecha ?></td>
                </tr>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
                <?php if($estatus=='C'){?>
                <tr>
                    <td colspan="2" align=" center">Cancelado</td>
                </tr>
                <?php }?>
            </table>
        </td>
    </tr>
</table>
<br>
<table class="borde_tabla" width="100%">
    <tr>
        <td colspan="2"><strong>Proyecto: </strong><?php echo $rowU['proyecto'];?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Nombre: </strong><?php echo $rowU['nombre'];?></td>
    </tr>
    <?php //---BUSCA DATOS CLIENTE-------
    $queryC="SELECT
a.id,a.nombre,a.dirigido,a.razon_social,a.telefono,a.email,a.calle,a.num_exterior,a.num_interior,a.codigo_postal,a.colonia,a.id_municipio,a.id_estado,a.id_pais,a.rfc,a.representante_legal,a.contacto,IFNULL(b.estado,'') AS estado
FROM pre_clientes a LEFT JOIN estados b ON a.id_estado=b.id WHERE a.id=(SELECT id_cliente FROM cotizacion WHERE id=".$idCotizacion.")";
    $resultC=mysqli_query($link,$queryC);
    $dCliente=mysqli_fetch_array($resultC); 
                                
    ?>
    <tr class="encabezado">
        <td colspan="2"><strong>Datos del Cliente </strong></td>
    </tr>
    <tr>
       <td width="400" class="dato">
        <?php echo "
                    <strong>".$dCliente['nombre']."</strong><br> 
                    <strong>Calle: </strong>".$dCliente['calle']. "  #".$dCliente['num_exterior']." <strong>CP: </strong>".$dCliente['codigo_postal']."<br>
                    <strong>Telefono: </strong>".$dCliente['telefono']."<br>";
                   
        ?>              
        </td>
        <td width="310">
          <?php echo "<strong>RFC: </strong>".$dCliente['rfc']."<br> 
                      <strong>Estado: </strong>".$dCliente['estado']."<br>
                      <strong>Correo: </strong>".$dCliente['email']."<br>";
          ?>
        </td>
    </tr>    
</table>

<p><?php echo $textoInicio;?></p>


<!---- ELEMENTOS---->
<?php  
  
    $queryE="SELECT a.id,a.sueldo,a.bono,a.tiempo_extra,a.otros,a.observaciones,a.cantidad,a.vacaciones,a.aguinaldo,
                                        a.festivo,a.administrativo,a.infonavit,a.imss,a.costo,a.costo_total,a.precio,a.precio_total,a.id_salario,
                                        d.puesto,b.estatus AS estatus
                                        FROM cotizacion_elementos a
                                        LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                                        LEFT JOIN cat_salarios c ON a.id_salario=c.id
                                        LEFT JOIN cat_puestos d ON c.id_puesto=d.id_puesto
                                        WHERE a.id_cotizacion=".$idCotizacion." AND a.precio!=0
                                        ORDER BY a.id";
    $consultaE = mysqli_query($link,$queryE);
    $numeroFilasE = mysqli_num_rows($consultaE); 
    if($numeroFilasE>0){    
?>
<h4>Elementos </h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='210' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='200' align="center">Precio Unitario </td>
            <td width='200' align="center">Precio Final</td>
            

        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidad=0;
    $tPrecio=0;
    $tPrecioTotal=0;
    while ($rowE = mysqli_fetch_array($consultaE)){
       $tCantidad = $tCantidad + $rowE['cantidad'];
       $tPrecio = $tPrecio + $rowE['precio'];
       $tPrecioTotal = $tPrecioTotal + $rowE['precio_total'];
      
        echo   "<tr>
                    <td width='210'>".$rowE['puesto']."</td>
                    <td width='100' align='right'>".$rowE['cantidad']."</td> 
                    <td width='200' align='right'>".dos_decimales($rowE['precio'])."</td>
                    <td width='200' align='right'>".dos_decimales($rowE['precio_total'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='210'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidad;?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecio)?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioTotal)?></td>
            

        </tr>
    </tfoot>
   
</table>
<?php }?>
<br><br>
<!---- EQUIPOS MENSUAL---->
<?php  
  
    $queryEq="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total
                                        FROM cotizacion_equipo a
                                        WHERE a.id_cotizacion=".$idCotizacion."
                                        AND a.tipo_pago = 1 AND a.precio!=0 ORDER BY a.nombre";
    $consultaEq = mysqli_query($link,$queryEq);
    $numeroFilasEq = mysqli_num_rows($consultaEq);
    if($numeroFilasEq>0){        
?>
<h4>Equipos Mensual</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='210' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='200' align="center">Precio Unitario </td>
            <td width='200' align="center">Precio Final</td>
            

        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidadq=0;
    $tPrecioq=0;
    $tPrecioTotalq=0;
    while ($rowEq = mysqli_fetch_array($consultaEq)){
       $tCantidadq = $tCantidadq + $rowEq['cantidad'];
       $tPrecioq = $tPrecioq + $rowEq['precio'];
       $tPrecioTotalq = $tPrecioTotalq + $rowEq['precio_total'];
      
        echo   "<tr>
                    <td width='210'>".$rowEq['nombre']."</td>
                    <td width='100' align='right'>".$rowEq['cantidad']."</td> 
                    <td width='200' align='right'>".dos_decimales($rowEq['precio'])."</td>
                    <td width='200' align='right'>".dos_decimales($rowEq['precio_total'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='210'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadq;?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioq)?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioTotalq)?></td>
            

        </tr>
    </tfoot>
   
</table>
<?php }?>

<br><br>
<!---- EQUIPOS INVERSION---->
<?php  
  
    $queryEq2="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total
                                        FROM cotizacion_equipo a
                                        WHERE a.id_cotizacion=".$idCotizacion."
                                        AND a.tipo_pago = 2 AND a.precio!=0 ORDER BY a.nombre";
    $consultaEq2 = mysqli_query($link,$queryEq2);
    $numeroFilasEq2 = mysqli_num_rows($consultaEq2);
    if($numeroFilasEq2>0){        
?>
<h4>Equipos Inversión</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='210' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='200' align="center">Precio Unitario </td>
            <td width='200' align="center">Precio Final</td>
            

        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidadq2=0;
    $tPrecioq2=0;
    $tPrecioTotalq2=0;
    while ($rowEq2 = mysqli_fetch_array($consultaEq2)){
       $tCantidadq2 = $tCantidadq2 + $rowEq2['cantidad'];
       $tPrecioq2 = $tPrecioq2 + $rowEq2['precio'];
       $tPrecioTotalq2 = $tPrecioTotalq2 + $rowEq2['precio_total'];
      
        echo   "<tr>
                    <td width='210'>".$rowEq2['nombre']."</td>
                    <td width='100' align='right'>".$rowEq2['cantidad']."</td> 
                    <td width='200' align='right'>".dos_decimales($rowEq2['precio'])."</td>
                    <td width='200' align='right'>".dos_decimales($rowEq2['precio_total'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='210'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadq2;?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioq2)?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioTotalq2)?></td>
            

        </tr>
    </tfoot>
   
</table>
<?php }?>
<br><br>
<!---- SERVICIOS MENSUAL---->
<?php  
  
    $queryS="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total
                                        FROM cotizacion_servicios a
                                        WHERE a.id_cotizacion=".$idCotizacion." AND tipo_pago = 2 AND a.precio!=0 ORDER BY a.nombre";
    $consultaS = mysqli_query($link,$queryS);
    $numeroFilasS = mysqli_num_rows($consultaS);
    if($numeroFilasS>0){        
?>
<h4>Servicios Mensual</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='210' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='200' align="center">Precio Unitario </td>
            <td width='200' align="center">Precio Final</td>
            

        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidadS=0;
    $tPrecioS=0;
    $tPrecioTotalS=0;
    while ($rowS = mysqli_fetch_array($consultaS)){
       $tCantidadS = $tCantidadS + $rowS['cantidad'];
       $tPrecioS = $tPrecioS + $rowS['precio'];
       $tPrecioTotalS = $tPrecioTotalS + $rowS['precio_total'];
      
        echo   "<tr>
                    <td width='210'>".$rowS['nombre']."</td>
                    <td width='100' align='right'>".$rowS['cantidad']."</td> 
                    <td width='200' align='right'>".dos_decimales($rowS['precio'])."</td>
                    <td width='200' align='right'>".dos_decimales($rowS['precio_total'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='210'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadS;?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioS)?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioTotalS)?></td>
            

        </tr>
    </tfoot>
   
</table>
<?php }?>
<br><br>
<!---- SERVICIOS INVERSION---->
<?php  
  
    $queryS2="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total
                                        FROM cotizacion_servicios a
                                        WHERE a.id_cotizacion=".$idCotizacion." AND tipo_pago = 1 AND a.precio!=0 ORDER BY a.nombre";
    $consultaS2 = mysqli_query($link,$queryS2);
    $numeroFilasS2 = mysqli_num_rows($consultaS);
    if($numeroFilasS2>0){        
?>
<h4>Servicios Inversión</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='210' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='200' align="center">Precio Unitario </td>
            <td width='200' align="center">Precio Final</td>
            

        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidadS2=0;
    $tPrecioS2=0;
    $tPrecioTotalS2=0;
    while ($rowS2 = mysqli_fetch_array($consultaS2)){
       $tCantidadS2 = $tCantidadS2 + $rowS2['cantidad'];
       $tPrecioS2 = $tPrecioS2 + $rowS2['precio'];
       $tPrecioTotalS2 = $tPrecioTotalS2 + $rowS2['precio_total'];
      
        echo   "<tr>
                    <td width='210'>".$rowS2['nombre']."</td>
                    <td width='100' align='right'>".$rowS2['cantidad']."</td> 
                    <td width='200' align='right'>".dos_decimales($rowS2['precio'])."</td>
                    <td width='200' align='right'>".dos_decimales($rowS2['precio_total'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='210'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadS2;?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioS2)?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioTotalS2)?></td>
            

        </tr>
    </tfoot>
   
</table>
<?php }?>
<br><br>
<!---- VEHICULOS MENSUAL---->
<?php  
  
    $queryV="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total
                                        FROM cotizacion_vehiculos a
                                        WHERE a.id_cotizacion=".$idCotizacion." AND a.tipo_pago = 1 AND a.precio!=0 ORDER BY a.nombre";
    $consultaV = mysqli_query($link,$queryV);
    $numeroFilasV = mysqli_num_rows($consultaV);
    if($numeroFilasV>0){        
?>
<h4>Vehiculos Mensuales</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='210' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='200' align="center">Precio Unitario </td>
            <td width='200' align="center">Precio Final</td>
            

        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidadV=0;
    $tPrecioV=0;
    $tPrecioTotalV=0;
    while ($rowV = mysqli_fetch_array($consultaV)){
       $tCantidadV = $tCantidadV + $rowV['cantidad'];
       $tPrecioV = $tPrecioV + $rowV['precio'];
       $tPrecioTotalV = $tPrecioTotalV + $rowV['precio_total'];
      
        echo   "<tr>
                    <td width='210'>".$rowV['nombre']."</td>
                    <td width='100' align='right'>".$rowV['cantidad']."</td> 
                    <td width='200' align='right'>".dos_decimales($rowV['precio'])."</td>
                    <td width='200' align='right'>".dos_decimales($rowV['precio_total'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='210'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadV;?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioV)?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioTotalV)?></td>
            

        </tr>
    </tfoot>
   
</table>
<?php }?>
<br><br>
<!---- VEHICULOS INVERSIÓN---->
<?php  
  
    $queryV2="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total
                                        FROM cotizacion_vehiculos a
                                        WHERE a.id_cotizacion=".$idCotizacion." AND a.tipo_pago = 2 AND a.precio!=0 ORDER BY a.nombre";
    $consultaV2 = mysqli_query($link,$queryV2);
    $numeroFilasV2 = mysqli_num_rows($consultaV2);
    if($numeroFilasV2>0){        
?>
<h4>Vehiculos Inversión</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='210' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='200' align="center">Precio Unitario </td>
            <td width='200' align="center">Precio Final</td>
            

        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidadV2=0;
    $tPrecioV2=0;
    $tPrecioTotalV2=0;
    while ($rowV2 = mysqli_fetch_array($consultaV2)){
       $tCantidadV2 = $tCantidadV2 + $rowV2['cantidad'];
       $tPrecioV2 = $tPrecioV + $rowV['precio'];
       $tPrecioTotalV2 = $tPrecioTotalV2 + $rowV2['precio_total'];
      
        echo   "<tr>
                    <td width='210'>".$rowV2['nombre']."</td>
                    <td width='100' align='right'>".$rowV2['cantidad']."</td> 
                    <td width='200' align='right'>".dos_decimales($rowV2['precio'])."</td>
                    <td width='200' align='right'>".dos_decimales($rowV2['precio_total'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='210'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadV2;?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioV2)?></td>
            <td width='200' align="right"><?php echo dos_decimales($tPrecioTotalV2)?></td>
            

        </tr>
    </tfoot>
   
</table>
<?php }?>
<br><br>


<p><?php echo $textoFin;?></p>

<br><br>
<table width="710" border="0">
    <tr>
        <td width="710" align="center"><?php
            if($rowU['firma_digital']==1 && $$rowU['firma_digital']!='')
            echo '<img src="../imagenes/'.$rowU['firma_digital'].'" />';
            ?><br>______________________________<br> <?php echo $rowU['firmante']?></td>
       
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
    return $number; 
}
?>
