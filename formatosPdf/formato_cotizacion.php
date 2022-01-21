<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idCotizacion = $arreglo['idRegistro'];

//-->NJES En cotizaciones, se debe de imprimir todos los conceptos aunque su precio sea cero (DEN18-2467) -- Dic/13/2019 <--//

// Informacion de la empresa 
$query = "SELECT 
a.folio,
a.nombre,
a.estatus AS estatus_cotizacion,
a.id_cliente,
a.firma_digital,
a.texto_inicio,a.texto_fin,
IF(a.periodicidad=1,'SEMANAL',IF(a.periodicidad=2,'QUINCENAL',IF(a.periodicidad=3,'MENSUAL','UNICO')))AS periodicidad,
a.elementos_observaciones_externas,
a.equipo_observaciones_externas,
a.servicios_observaciones_externas,
a.vehiculos_observaciones_externas,
a.consumibles_observaciones_externas,
DATE(a.timestamp_version) AS fecha,
b.descripcion AS proyecto,
d.descr AS sucursal,
d.codigopostal,
CONCAT(d.calle,' No. Ext ' ,d.no_exterior,(IF(d.no_interior!='','No. Int ','')),d.no_interior) AS direccion,
IFNULL(h.nombre,'') AS firmante,
IFNULL(h.firma,'') AS firma,
i.nombre AS unidad_negocio,
i.logo,
i.clave as clave_unidad,
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
$claveUnidad = $rowU['clave_unidad'];
$textoInicio = $rowU['texto_inicio'];
$textoFin = $rowU['texto_fin'];
$periodicidad = $rowU['periodicidad'];
$elementos_observaciones = $rowU['elementos_observaciones_externas'];
$equipo_observaciones = $rowU['equipo_observaciones_externas'];
$servicios_observaciones = $rowU['servicios_observaciones_externas'];
$vehiculos_observaciones = $rowU['vehiculos_observaciones_externas'];
$consumibles_observaciones = $rowU['consumibles_observaciones_externas'];
  
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

.listas_niv_dos{
    list-style: none;
}

</style>

<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="3mm"  backbottom="5mm" style="border:1px solid #333;">
<page_header style='text-align: right;font-size: 8px;'> 
    <?php echo "Fecha Impresión:" .date('d/m/Y H:i:s');?>
</page_header> 
<page_footer style='text-align: right;font-size: 10px;'> 
        Página:[[page_cu]] de [[page_nb]]
</page_footer>
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
                  <td class="dato"><?php echo $claveUnidad.'-'.$folioCotizacion;?></td>
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
    <tr>
        <td colspan="2"><!--SE AGREGA LA PERIODICIDA, MONEDA Y QUE INCLUYE IVA-->
        <table width="710" border="0">
            <tr>
                <td width="230"><strong>Periodicidad: </strong><?php echo $rowU['periodicidad'];?></td>
                <td width="280" align="center"><strong>Moneda: </strong>MXN</td>
                <td width="230" align="right"><strong>Los precios no Incluyen IVA </strong></td>
            </tr>
        </table>
       </td>
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

<p><?php echo niveles($textoInicio);?></p>
<!--SE AGREGAN LAS OBSERVACIONES EN CONSULTAS Y TABLAS DE CADA SECCION Y CADA REGISTRO-->
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
            <td width='150' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
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
                    <td width='150'>".$rowE['puesto']."</td>
                    <td width='100' align='right'>".$rowE['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowE['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowE['precio_total'])."</td>  
                    <td width='250' style='text-align:justify;'>".$rowE['observaciones']."</td>         
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidad;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecio)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotal)?></td>
            <td width='250' align="right"></td>

        </tr>
        <?php if($elementos_observaciones != ''){ ?>
            <tr>
            <td colspan="5"><strong>Observaciones: </strong> <?php echo $elementos_observaciones;?></td>
            </tr>
            <?php } ?>
    </tfoot>
   
</table>
<br><br>
<?php }?>
<!---- EQUIPOS MENSUAL---->
<?php  
  
    $queryEq="SELECT a.id,a.nombre,a.cantidad,if(a.prorratear=1,0,a.precio) AS precio,
            if(a.prorratear=1,0,a.precio_total) AS precio_total,a.observaciones
            FROM cotizacion_equipo a
            WHERE a.id_cotizacion=".$idCotizacion."
            AND a.tipo_pago = 1 ORDER BY a.nombre";
    $consultaEq = mysqli_query($link,$queryEq);
    $numeroFilasEq = mysqli_num_rows($consultaEq);
    if($numeroFilasEq>0){        
?>
<h4>Equipos</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
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
                    <td width='150'>".$rowEq['nombre']."</td>
                    <td width='100' align='right'>".$rowEq['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowEq['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowEq['precio_total'])."</td> 
                    <td width='250' style='text-align:justify;'>".$rowEq['observaciones']."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadq;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecioq)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotalq)?></td>
            <td width='250'></td>
        </tr>
        <?php if($equipo_observaciones != ''){?>
            <tr>
                <td colspan="5"><strong>Observaciones: </strong> <?php echo $equipo_observaciones;?></td>
            </tr>
        <?php } ?>
    </tfoot>
   
</table>
<br><br>
<?php }?>

<!---- EQUIPOS INVERSION---->
<?php  
  
    $queryEq2="SELECT a.id,a.nombre,a.cantidad,if(a.prorratear=1,0,a.precio) AS precio,
                if(a.prorratear=1,0,a.precio_total) AS precio_total,a.observaciones
                FROM cotizacion_equipo a
                WHERE a.id_cotizacion=".$idCotizacion."
                AND a.tipo_pago = 2 ORDER BY a.nombre";
    $consultaEq2 = mysqli_query($link,$queryEq2);
    $numeroFilasEq2 = mysqli_num_rows($consultaEq2);
    if($numeroFilasEq2>0){        
?>
<h4>Equipo en Venta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="font-size:13px;font-style: italic;font-weight:none;">* No tiene costo mensual</label></h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
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
                    <td width='150'>".$rowEq2['nombre']."</td>
                    <td width='100' align='right'>".$rowEq2['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowEq2['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowEq2['precio_total'])."</td> 
                    <td width='250' style='text-align:justify;'>".$rowEq2['observaciones']."</td>            
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadq2;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecioq2)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotalq2)?></td>
            <td width='250'> </td>
        </tr>
    </tfoot>
   
</table>
<br><br>
<?php }?>
<!---- SERVICIOS MENSUAL---->
<?php  
  
    $queryS="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total,a.observaciones
                FROM cotizacion_servicios a
                WHERE a.id_cotizacion=".$idCotizacion." 
                AND tipo_pago = 1 ORDER BY a.nombre";
    $consultaS = mysqli_query($link,$queryS);
    $numeroFilasS = mysqli_num_rows($consultaS);
    if($numeroFilasS>0){        
?>
<h4>Servicios</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
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
                    <td width='150'>".$rowS['nombre']."</td>
                    <td width='100' align='right'>".$rowS['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowS['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowS['precio_total'])."</td>  
                    <td width='250' style='text-align:justify;'>".$rowS['observaciones']."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadS;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecioS)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotalS)?></td>
            <td width='250'> </td>
        </tr>
        <?php if($servicios_observaciones != ''){?>
            <tr>
            <td colspan="5"><strong>Observaciones: </strong> <?php echo $servicios_observaciones;?></td>
            </tr>
        <?php } ?>
    </tfoot>
   
</table>
<br><br>
<?php }?>
<!---- SERVICIOS INVERSION---->
<?php  
  
    $queryS2="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total,a.observaciones
                FROM cotizacion_servicios a
                WHERE a.id_cotizacion=".$idCotizacion." 
                AND tipo_pago = 2 ORDER BY a.nombre";
    $consultaS2 = mysqli_query($link,$queryS2);
    $numeroFilasS2 = mysqli_num_rows($consultaS2);
    if($numeroFilasS2>0){        
?>
<h4>Servicios Adicionales  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="font-size:13px;font-style: italic;font-weight:none;">* No tiene costo mensual</label></h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">Nombre</td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
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
                    <td width='150'>".$rowS2['nombre']."</td>
                    <td width='100' align='right'>".$rowS2['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowS2['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowS2['precio_total'])."</td>
                    <td width='250' style='text-align:justify;'>".$rowS2['observaciones']."</td>             
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadS2;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecioS2)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotalS2)?></td>
            <td width='250'> </td>
        </tr>
    </tfoot>
   
</table>
<br><br>
<?php }?>
<!---- VEHICULOS MENSUAL---->
<?php  
  
    $queryV="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total,a.observaciones
            FROM cotizacion_vehiculos a
            WHERE a.id_cotizacion=".$idCotizacion." 
            AND a.tipo_pago = 1 ORDER BY a.nombre";
    $consultaV = mysqli_query($link,$queryV);
    $numeroFilasV = mysqli_num_rows($consultaV);
    if($numeroFilasV>0){        
?>
<h4>Vehiculos</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
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
                    <td width='150'>".$rowV['nombre']."</td>
                    <td width='100' align='right'>".$rowV['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowV['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowV['precio_total'])."</td>
                    <td width='250' style='text-align:justify;'>".$rowV['observaciones']."</td>          
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadV;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecioV)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotalV)?></td>
            <td width='250'> </td>
        </tr>
        <?php if($vehiculos_observaciones != ''){ ?>
            <tr>
            <td colspan="5"><strong>Observaciones: </strong> <?php echo $vehiculos_observaciones;?></td>
            </tr>
            <?php } ?>
    </tfoot>
   
</table>
<br><br>
<?php }?>
<!---- VEHICULOS INVERSIÓN---->
<?php  
  
    $queryV2="SELECT a.id,a.nombre,a.cantidad,a.precio,a.precio_total,a.observaciones
                FROM cotizacion_vehiculos a
                WHERE a.id_cotizacion=".$idCotizacion." 
                AND a.tipo_pago = 2 ORDER BY a.nombre";
    $consultaV2 = mysqli_query($link,$queryV2);
    $numeroFilasV2 = mysqli_num_rows($consultaV2);
   
    if($numeroFilasV2 > 0){        
?>
<h4>Vehiculos Inversión</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
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
                    <td width='150'>".$rowV2['nombre']."</td>
                    <td width='100' align='right'>".$rowV2['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowV2['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowV2['precio_total'])."</td> 
                    <td width='250' style='text-align:justify;'>".$rowV2['observaciones']."</td>            
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadV2;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecioV2)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotalV2)?></td>
            <td width='250'> </td>
        </tr>
    </tfoot>
   
</table>
<br><br>
<?php }?>
<!---- CONSUMIBLES---->
<?php  
  
    $queryC1="SELECT a.id,a.nombre,a.cantidad,if(a.prorratear=1,0,a.precio) AS precio,
            if(a.prorratear=1,0,a.precio_total) AS precio_total,a.observaciones
            FROM cotizacion_consumibles a
            WHERE a.id_cotizacion=".$idCotizacion." 
            AND a.tipo_pago = 1 ORDER BY a.nombre";
    $consultaC1 = mysqli_query($link,$queryC1);
    $numeroFilasC1 = mysqli_num_rows($consultaC1);
   
    if($numeroFilasC1 > 0){        
?>
<h4>Consumibles </h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
        </tr>
    </thead>
    <tbody>
    <?php
    $tCantidadC1=0;
    $tPrecioC1=0;
    $tPrecioTotalC1=0;
    while ($rowC1 = mysqli_fetch_array($consultaC1)){
       $tCantidadC1 = $tCantidadC1 + $rowC1['cantidad'];
       $tPrecioC1 = $tPrecioC1 + $rowC1['precio'];
       $tPrecioTotalC1 = $tPrecioTotalC1 + $rowC1['precio_total'];
      
        echo   "<tr>
                    <td width='150'>".$rowC1['nombre']."</td>
                    <td width='100' align='right'>".$rowC1['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowC1['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowC1['precio_total'])."</td>  
                    <td width='250' style='text-align:justify;'>".$rowC1['observaciones']."</td>         
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadC1;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecioC1)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotalC1)?></td>
            <td width='250' align="right"></td>

        </tr>
        <?php if($consumibles_observaciones != ''){ ?>
            <tr>
            <td colspan="5"><strong>Observaciones: </strong> <?php echo $consumibles_observaciones;?></td>
            </tr>
        <?php } ?>
    </tfoot>
   
</table>
<br><br>
<?php }?>
<!---- CONSUMIBLES INVERSION---->
<?php  
  
    $queryC1="SELECT a.id,a.nombre,a.cantidad,if(a.prorratear=1,0,a.precio) AS precio,
            if(a.prorratear=1,0,a.precio_total) AS precio_total,a.observaciones
            FROM cotizacion_consumibles a
            WHERE a.id_cotizacion=".$idCotizacion." 
            AND a.tipo_pago = 2 ORDER BY a.nombre";
    $consultaC1 = mysqli_query($link,$queryC1);
    $numeroFilasC1 = mysqli_num_rows($consultaC1);
   
    if($numeroFilasC1 > 0){        
?>
<h4>Consumibles Inversión.</h4>
<table class="borde_tabla" width="710">
    <thead>
        <tr class="encabezado">
            <td width='150' align="center">Nombre </td>
            <td width='100' align="center">Cantidad</td>
            <td width='100' align="center">Precio Unitario </td>
            <td width='110' align="center">Precio Final</td>
            <td width='250'>Observaciones</td>
        </tr>
    </thead>
    <tbody>
    <?php
   

    $tCantidadC2=0;
    $tPrecioC2=0;
    $tPrecioTotalC2=0;
    //$result = mysqli_query($link,$query_detalle);
    //while ($dato = mysqli_fetch_array($result))
    while ($rowC2 = mysqli_fetch_array($consultaC1)){
       $tCantidadC2 = $tCantidadC2 + $rowC2['cantidad'];
       $tPrecioC2 = $tPrecioC2 + $rowC2['precio'];
       $tPrecioTotalC2 = $tPrecioTotalC2 + $rowC2['precio_total'];
      
        echo   "<tr>
                    <td width='150'>".$rowC2['nombre']."</td>
                    <td width='100' align='right'>".$rowC2['cantidad']."</td> 
                    <td width='100' align='right'>".dos_decimales($rowC2['precio'])."</td>
                    <td width='110' align='right'>".dos_decimales($rowC2['precio_total'])."</td>  
                    <td width='250' style='text-align:justify;'>".$rowC2['observaciones']."</td>         
                </tr>";
    
    }
    ?> 
    </tbody>
     <tfoot>
        <tr class="encabezado">
            <td width='150'>Totales </td>
            <td width='100' align="right"><?php echo $tCantidadC2;?></td>
            <td width='100' align="right"><?php echo dos_decimales($tPrecioC2)?></td>
            <td width='110' align="right"><?php echo dos_decimales($tPrecioTotalC2)?></td>
            <td width='250' align="right"></td>

        </tr>
    </tfoot>
</table>
<br><br>
<?php }?>

<p><?php echo niveles($textoFin);?></p>

<table width="710" border="0">
    <tr>
        <td width="710" align="center"><?php
            
            if($rowU['firma_digital']==1 && $rowU['firma_digital']!='')
            echo '<img style="height:100px;" src="../firmantes/'.$rowU['firma'].'" />';
            ?><br>______________________________<br> <?php echo $rowU['firmante']?>
        </td>
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

 /**$nivelES INICIO**/
/*
<b>…</b>  texto en negrita
<i>…</i>  texto en cursiva
<u>…</u>  texto en subrayado
<center>…</center>  texto centrado   (para html5 no funciona)


[    $nivel sin biñeta
|    $nivel con biñeta a
||   doble $nivel con biñeta b 
[|   $nivel con biñeta a
[||  doble $nivel con biñeta b

.replace(/\n/g, '<br />')
*/

$nivel_ant=1;
$nivel_act=0;
$pos_act=0;
$html_niv='';
$contador=0;

function niveles($dato_texto){
    $html_niv='';
    $nivel_ant=1; $nivel_act=0; $pos_act=0; $contador=0;
    $txt_restante='';
    $txt_anterior='';
    $txt_restante=trim($dato_texto);
                
    
    $letra='';
    $letra = substr($txt_restante,0,1);
    
    if($letra=='|'){
        
        $pos_act=strpos($txt_restante,'|');
    }else if($letra=='['){
        
        $pos_act=strpos($txt_restante,'[');
    }else{
        
        $pos_or=0; $pos_co=0;
        $pos_or=strpos($txt_restante,'|');
        $pos_co=strpos($txt_restante,'[');
        $p_or=0; $p_co=0;
        if($pos_or !== false){
            $p_or=$pos_or;
        }else{
            $p_or=1;
        }
        
        if($pos_co !== false){
            $p_co=$pos_co;
        }else{
            $p_co=1;
        }
        
        if($pos_or !== false && $pos_co !== false){
            
            if($p_or < $p_co){
                $pos_act=strpos($txt_restante,'|');
            }else{
                $pos_act=strpos($txt_restante,'[');
            }
        }else{
            
            if($p_or > $p_co){
                $pos_act=strpos($txt_restante,'|');
            }else{
                $pos_act=strpos($txt_restante,'[');
            }
        }
        
        
    }

    
        if($pos_act !== false){
            $txt_anterior=substr($txt_restante,0,$pos_act);
            $html_niv.=$txt_anterior;

            $html_niv.="<ul>";
            
            $txt_restante=substr($txt_restante,$pos_act);
            
            while($txt_restante != ''){
                
                $txt_restante=trim($txt_restante);
                
                $letra2='';
                $letra2 = substr($txt_restante,0,1);
                
                if($letra2=='|'){
                    $pos_act=strpos($txt_restante,'|');
                    
                    $a=''; $b=''; $c=''; $nivel=0;
                    $a=substr($txt_restante,0,1);
                    $b=substr($txt_restante,1,1);
                    $c=substr($txt_restante,2,1);
                    $nivel=0;
                    if($a == '|'){
                        $nivel++;
                    }
                    if($b == '|'){
                        $nivel++;
                    }
                    if($c == '|'){
                        $nivel++;
                    }
                }else{
                    $pos_act=strpos($txt_restante,'[');
                    
                    $a=''; $b=''; $c=''; $nivel=0;
                    $a=substr($txt_restante,0,1);
                    $b=substr($txt_restante,1,1);
                    $c=substr($txt_restante,2,1);
                    $nivel=0;
                    if($a == '['){
                        $nivel++;
                    }
                    if($b == '['){
                        $nivel++;
                    }
                    if($c == '['){
                        $nivel++;
                    }
                }
                
                $nivel_act=$nivel;
                
                if($nivel_ant == $nivel_act){  
                    $busca_sig_or='';
                    $busca_sig_or=substr($txt_restante,$nivel_act);
                    
                    $letra3='';
                    $letra3 = substr($busca_sig_or,0,1);
                
                     $pos_sig_or=0;
                    if($letra3=='|'){
                        $pos_sig_or=strpos($busca_sig_or,'|');
                    }else if($letra3=='['){
                        $pos_sig_or=strpos($busca_sig_or,'[');
                    }else{

                        $pos_or=0; $pos_co=0;
                        $pos_or=strpos($busca_sig_or,'|');
                        $pos_co=strpos($busca_sig_or,'[');
                        
                        $p_or=0; $p_co=0;
                        if($pos_or !== false){
                            $p_or=$pos_or;
                        }else{
                            $p_or=1;
                        }
                        
                        if($pos_co != false){
                            $p_co=$pos_co;
                        }else{
                            $p_co=1;
                        }

                        
                        if($pos_or !== false && $pos_co !== false){
                            
                            if($p_or < $p_co){
                                $pos_sig_or=strpos($busca_sig_or,'|');
                            }else{
                                $pos_sig_or=strpos($busca_sig_or,'[');
                            }
                        }else{
                            
                            if($p_or > $p_co){
                                $pos_sig_or=strpos($busca_sig_or,'|');
                            }else{
                                $pos_sig_or=strpos($busca_sig_or,'[');
                            }
                        }
                        
                    }
                    
                    if($pos_sig_or === false){
                        $txt_anterior=substr($txt_restante,$nivel_act);
                        
                        if($nivel_act == 1){
                            
                            if($letra2=='|'){
                                $html_niv.='</li><li>'.$txt_anterior.'</li>';   
                            }else{
                                $html_niv.='</li><li class="listas_niv_dos">'.$txt_anterior.'</li>';   
                            }
                            
                        }else if($nivel_act == 2){
                            
                            if($letra2=='|'){
                                $html_niv.='</li><li>'.$txt_anterior.'</li></ul></li>';  
                            }else{
                                $html_niv.='</li><li class="listas_niv_dos">'.$txt_anterior.'</li></ul></li>';  
                            }	
                            
                        }else{
                        
                            if($letra2=='|'){
                                $html_niv.='</li><li>'.$txt_anterior.'</li></ul></li></ul></li>';    
                            }else{
                                $html_niv.='</li><li class="listas_niv_dos">'.$txt_anterior.'</li></ul></li></ul></li>';   
                            }
                        }
                        $txt_restante='';
                    }else{
                        
                        //$valorN=$pos_sig_or+$nivel_act;
                        
                        $txt_anterior=substr($txt_restante,$nivel_act,$pos_sig_or);
                        //$txt_anterior=substr($txt_restante,$nivel_act,$valorN);
                        
                        if($nivel_act == 1){

                            if($contador == 0){
                                if($letra2=='|'){
                                    $html_niv.='<li>'.$txt_anterior;  
                                }else{
                                    $html_niv.='<li class="listas_niv_dos">'.$txt_anterior;  
                                }
                                
                            }else{
                                if($letra2=='|'){
                                    $html_niv.='</li><li>'.$txt_anterior;   
                                }else{
                                    $html_niv.='</li><li class="listas_niv_dos">'.$txt_anterior;  
                                }
                            }
                            $contador ++;
                            
                        }else if($nivel_act == 2){
                            
                            if($letra2=='|'){
                                $html_niv.='</li><li>'.$txt_anterior;  
                            }else{
                                $html_niv.='</li><li class="listas_niv_dos">'.$txt_anterior;  
                            }
                            
                        }else{
                            
                            if($letra2=='|'){
                                $html_niv.='</li><li>'.$txt_anterior;  
                            }else{
                                $html_niv.='</li><li class="listas_niv_dos">'.$txt_anterior;  
                            }
                        }
                        $valorNN =$pos_sig_or+$nivel_act;
                        $txt_restante=substr($txt_restante,$valorNN);
                    }
                    
                }else if($nivel_ant < $nivel_act){  

                     $busca_sig_or='';
                    
                    $busca_sig_or=substr($txt_restante,$nivel_act);

                     $letra4='';
                    
                    $letra4 = substr($busca_sig_or,0,1);
            
                     $pos_sig_or=0;

                    if($letra4=='|'){
                        $pos_sig_or=strpos($busca_sig_or,'|');
                    }else if($letra4=='['){
                        $pos_sig_or=strpos($busca_sig_or,'[');
                    }else{
                         $pos_or=0; $pos_co=0;
                        $pos_or=strpos($busca_sig_or,'|');
                        $pos_co=strpos($busca_sig_or,'[');
                        
                         $p_or=0; $p_co=0;

                        if($pos_or !== false){
                            $p_or=$pos_or;
                        }else{
                            $p_or=1;
                        }
                        
                        if($pos_co != false){
                            $p_co=$pos_co;
                        }else{
                            $p_co=1;
                        }
                        

                        if($pos_or !== false && $pos_co !== false){
                            
                            if($p_or < $p_co){
                                $pos_sig_or=strpos($busca_sig_or,'|');
                            }else{
                                $pos_sig_or=strpos($busca_sig_or,'[');
                            }
                        }else{
                            
                            if($p_or > $p_co){
                                $pos_sig_or=strpos($busca_sig_or,'|');
                            }else{
                                $pos_sig_or=strpos($busca_sig_or,'[');
                            }
                        }
                        
                    }
                    
                    if($pos_sig_or === false){
                        $txt_anterior=substr($txt_restante,$nivel_act);
                        
                        if(($nivel_ant == 1) && ($nivel_act == 2)){
                            
                            if($letra2=='|'){
                                $html_niv.='<ul><li>'.$txt_anterior.'</li></ul></li>';  
                            }else{
                                $html_niv.='<ul><li class="listas_niv_dos">'.$txt_anterior.'</li></ul></li>';   
                                
                            }
                            
                        }else if(($nivel_ant == 1) && ($nivel_act == 3)){
                            ////este nunca va  aocurrir porque no se puede pasar de $nivel 1 al 3
                            if($letra2=='|'){
                                $html_niv.='</ul></li><ul><li>'.$txt_anterior.'</li></ul>';
                            }else{
                                $html_niv.='</ul></li><ul><li class="listas_niv_dos">'.$txt_anterior.'</li></ul>';
                                
                            }
                            
                        }else{
                            
                            if($letra2=='|'){
                                $html_niv.='<ul><li>'.$txt_anterior.'</li></ul></li></ul></li></ul>';    
                                
                            }else{
                                $html_niv.='<ul><li class="listas_niv_dos">'.$txt_anterior.'</li></ul></li></ul></li></ul>';  
                                
                            }
                        }  
                        $txt_restante='';
                    }else{
                        $valorNNN= $pos_sig_or+$nivel_act;
                        $txt_anterior=substr($txt_restante,$nivel_act,$pos_sig_or);
                        //$txt_anterior=substr($txt_restante,$nivel_act,$valorNNN);
                        
                        if(($nivel_ant == 1) && ($nivel_act == 2)){
                            
                            if($letra2=='|'){
                                $html_niv.='<ul><li>'.$txt_anterior;   
                                
                            }else{
                                $html_niv.='<ul><li class="listas_niv_dos">'.$txt_anterior;  
                                
                            }
                            
                        }else if(($nivel_ant == 1) && ($nivel_act == 3)){
                            
                            if($letra2=='|'){
                                $html_niv.='<ul><li>'.$txt_anterior;   
                                
                            }else{
                                
                                $html_niv.='<ul><li class="listas_niv_dos">'.$txt_anterior;    
                                
                            }
                            
                        }else{   
                            
                            if($letra2=='|'){
                                
                                $html_niv.='<ul><li>'.$txt_anterior;  
                                
                            }else{
                                
                                $html_niv.='<ul><li class="listas_niv_dos">'.$txt_anterior;   
                                
                            }
                        }
                        $valorN1=$pos_sig_or+$nivel_act;
                        $txt_restante=substr($txt_restante,$valorN1);
                    }
                    
                }else{  

                    $busca_sig_or='';

                    $busca_sig_or=substr($txt_restante,$nivel_act);
                    
                    $letra5='';
                    $letra5 = substr($busca_sig_or,0,1);
                    
                     $pos_sig_or=0;
                    if($letra5=='|'){
                        $pos_sig_or=strpos($busca_sig_or,'|');
                    }else if($letra5=='|'){
                        $pos_sig_or=strpos($busca_sig_or,'[');
                    }else{
                        $pos_or=0; $pos_co=0;
                        $pos_or=strpos($busca_sig_or,'|');
                        $pos_co=strpos($busca_sig_or,'[');
                        
                         $p_or=0; $p_co=0;
                        if($pos_or !== false){
                            $p_or=$pos_or;
                        }else{
                            $p_or=1;
                        }
                        
                        if($pos_co != false){
                            $p_co=$pos_co;
                        }else{
                            $p_co=1;
                        }
                        
                        if($pos_or !== false && $pos_co !== false){
                            
                            if($p_or < $p_co){
                                $pos_sig_or=strpos($busca_sig_or,'|');
                            }else{
                                $pos_sig_or=strpos($busca_sig_or,'[');
                            }
                        }else{
                            
                            if($p_or > $p_co){
                                $pos_sig_or=strpos($busca_sig_or,'|');
                            }else{
                                $pos_sig_or=strpos($busca_sig_or,'[');
                            }
                        }
                        
                    }
                    
                    if($pos_sig_or === false){
                        $txt_anterior=substr($txt_restante,$nivel_act);
                        
                        if(($nivel_ant == 2) && ($nivel_act == 1)){
                            
                            if($letra2=='|'){
                                
                                $html_niv.='</li></ul></li><li>'.$txt_anterior.'</li>'; 
                            
                            }else{
                                
                                $html_niv.='</li></ul></li><li class="listas_niv_dos">'.$txt_anterior.'</li>';    
                                
                            } 
                            
                        }else if(($nivel_ant == 3) && ($nivel_act == 1)){
                            
                            if($letra2=='|'){
                                
                                $html_niv.='</li></ul></li></ul></li><li>'.$txt_anterior.'</li>';  
                                
                            }else{
                                
                                $html_niv.='</li></ul></li></ul></li><li class="listas_niv_dos">'.$txt_anterior.'</li>';    
                            
                            }

                        }else{   
                            
                            if($letra2=='|'){
                                
                                $html_niv.='</li></ul></li><li>'.$txt_anterior.'</li></ul></li>';  
                                
                            }else{
                                
                                $html_niv.='</li></ul></li><li class="listas_niv_dos">'.$txt_anterior.'</li></ul></li>'; 
                                
                            }
                        }
                        $txt_restante='';
                    }else{
                        $valorN2 = $pos_sig_or+$nivel_act;
                        $txt_anterior=substr($txt_restante,$nivel_act,$pos_sig_or);
                        //$txt_anterior=substr($txt_restante,$nivel_act,$valorN2);
                        if(($nivel_ant == 2) && ($nivel_act == 1)){
                            
                            if($letra2=='|'){
                                
                                $html_niv.='</li></ul></li><li>'.$txt_anterior;  
                                
                            }else{
                                
                                $html_niv.='</li></ul></li><li class="listas_niv_dos">'.$txt_anterior;  
                                
                            }
                            
                        }else if(($nivel_ant == 3) && ($nivel_act == 1)){

                            
                            if($letra2=='|'){
                                
                                $html_niv.='</li></ul></li></ul></li><li>'.$txt_anterior;   
                                
                            }else{
                                
                                $html_niv.='</li></ul></li></ul></li><li class="listas_niv_dos">'.$txt_anterior;  
                                
                            }
                            
                        }else{   
                            
                            if($letra2=='|'){
                                
                                $html_niv.='</li></ul></li><li>'.$txt_anterior;     
                            
                            }else{
                                
                                $html_niv.='</li></ul></li><li class="listas_niv_dos">'.$txt_anterior;     ///YA
                                
                            }
                        }
                        $valorN3= $pos_sig_or+$nivel_act;
                        $txt_restante=substr($txt_restante,$valorN3);
                    }
                }
                $nivel_ant=$nivel;
            }
            
            $html_niv.='</ul>';
            
        }else{
            $html_niv.=$txt_restante;
        }

        return $html_niv;
}
/**$nivelES FIN**/

?>
