<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datos=$_REQUEST['datos'];

$arreglo = json_decode($datos, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];
$conceptoAlmacen = $arreglo['concepto'];

// Informacion de la empresa 
$query = "SELECT a.id,
            a.folio,
            a.cve_concepto,
            a.id_unidad_negocio,
            d.nombre AS unidad,
            d.logo,
            a.id_sucursal,
            e.descr AS sucursal,
            DATE(a.fecha) AS fecha,
            a.observacion,
            a.id_clasificacion,
            f.nombre AS clasificacion,
            a.id_sucursal_destino,
            g.descr AS sucursal_destino,
            a.id_proveedor,
            a.id_trabajador,
            b.nombre AS proveedor,
            CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido_p),' ',TRIM(c.apellido_m)) AS empleado,
            a.id_departamento,
            h.des_dep AS departamento,
            IFNULL(i.descripcion,'') AS area,
            IFNULL(CONCAT(TRIM(j.nombre),' ',TRIM(j.apellido_p),' ',TRIM(j.apellido_m)),'') AS supervisor
            FROM almacen_e a
            LEFT JOIN proveedores b ON a.id_proveedor=b.id
            LEFT JOIN trabajadores c ON a.id_trabajador=c.id_trabajador
            LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
            LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
            LEFT JOIN clasificacion_salidas f ON a.id_clasificacion=f.id
            LEFT JOIN sucursales g ON a.id_sucursal_destino=g.id_sucursal
            LEFT JOIN deptos h ON a.id_departamento=h.id_depto
            LEFT JOIN cat_areas i ON h.id_area=i.id
            LEFT JOIN trabajadores j ON h.id_supervisor=j.id_trabajador
            WHERE a.id=".$idRegistro;

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$fecha = $row['fecha'];
$logo = $row['logo'];
$folio = $row['folio'];
$unidad = $row['unidad'];
$sucursal = $row['sucursal'];
$observacion = $row['observacion'];
$idClasificacion = $row['id_clasificacion'];
$clasificacion = $row['clasificacion'];
$idSucursalDestino = $row['id_sucursal_destino'];
$sucursalDestino = $row['sucursal_destino'];
$idProveedor = $row['id_proveedor'];
$proveedor = $row['proveedor'];
$idTrabajador = $row['id_trabajador'];
$empleado = $row['empleado'];
$idDepartamento = $row['id_departamento'];
$departamento = $row['departamento'];
$area = $row['area'];
$supervisor = $row['supervisor'];
      
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
	font-size:12px;
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
        <td width="200" align="top"><?php echo '<img src="../imagenes/'.$row['logo'].'"  width="150"/>';?></td>
        <td width="400" class="datos" align="center" ><strong>ALMACEN</strong> <br>
            Unidad de Negocio: <?php echo $unidad; ?><br> 
            Sucursal: <?php echo $sucursal;?><br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $folio;?></td>
                </tr>
                <tr>
                    <td class="verde">Fecha</td>
                    <td class="dato"><?php echo $fecha ?></td>
                </tr>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table class="borde_tabla" width="100%">
    <tr>
        <td colspan="2"><strong>Concepto: </strong><?php echo $conceptoAlmacen;?></td>
    </tr>

    <?php //si tiene sucursal destino se agrega
    if($idSucursalDestino != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Sucursal Destino: </strong><?php echo $sucursalDestino;?></td>
    </tr>
    <?php
    }
    ?>

    <?php //si tiene Proveedor se agrega
    if($idProveedor != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Proveedor: </strong><?php echo $proveedor;?></td>
    </tr>
    <?php
    }
    ?>

    <?php //si tiene empleado se agrega
    if($idTrabajador != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Empleado: </strong><?php echo $empleado;?></td>
    </tr>
    <?php
    }
    ?>

    <?php //si tiene clasificacion se agrega
    if($idClasificacion != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Clasificacion a Presupuesto: </strong><?php echo $clasificacion;?></td>
    </tr>
    <?php
    }
    ?>

    <?php //si tiene departamento se agrega
    if($idDepartamento != 0){ 
    ?>
    <tr>
        <td colspan="2"><strong>Departamento: </strong><?php echo $departamento;?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Área: </strong><?php echo $area;?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Supervisor: </strong><?php echo $supervisor;?></td>
    </tr>
    <?php
    }
    ?>

</table>

<p><?php echo $observacion;?></p>


<!---- Productos---->
<?php  
  
    $queryE="SELECT a.id_producto,
                a.precio,
                a.cantidad,
                a.talla,
                a.marca,
                b.concepto,
                b.descripcion,
                c.descripcion AS familia,
                c.id AS id_familia, 
                d.descripcion AS linea,
                d.id AS id_linea,
                (a.precio * a.cantidad) AS importe
                FROM almacen_d a
                LEFT JOIN productos b ON a.id_producto=b.id
                LEFT JOIN familias c ON b.id_familia = c.id
                LEFT JOIN lineas d ON b.id_linea = d.id
                WHERE a.id_almacen_e=".$idRegistro."
                ORDER BY a.id";
    $consultaE = mysqli_query($link,$queryE);
    $numeroFilasE = mysqli_num_rows($consultaE); 
    if($numeroFilasE>0){    
?>
<h4>Productos </h4>
<table class="borde_tabla" width="720">
    <thead>
        <tr class="encabezado">
            <td width='88' align="center">Catálogo </td>
            <td width='100' align="center">Familia</td>
            <td width='100' align="center">Línea</td>
            <td width='100' align="center">Concepto</td>
            <td width='100' align="center">Marca</td>
            <td width='66' align="center">Cantidad</td>
            <td width='88' align="center">Precio Unitario</td>
            <td width='88' align="center">Importe</td>
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
       $tPrecioTotal = $tPrecioTotal + $rowE['importe'];
      
        echo   "<tr>
                    <td width='88'>".$rowE['id_producto']."</td>
                    <td width='100'>".$rowE['familia']."</td> 
                    <td width='100'>".$rowE['linea']."</td> 
                    <td width='100'>".$rowE['concepto']."</td> 
                    <td width='100'>".$rowE['marca']."</td> 
                    <td width='66' align='right'>".$rowE['cantidad']."</td> 
                    <td width='88' align='right'>".dos_decimales($rowE['precio'])."</td>
                    <td width='88' align='right'>".dos_decimales($rowE['importe'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
</table>
<br>
<table>
    <tr class="encabezado">
        <td width='515'>Totales </td>
        <td width='66' align="right"><?php echo $tCantidad;?></td>
        <td width='88' align="center"><?php echo dos_decimales($tPrecio)?></td>
        <td width='88' align="right"><?php echo dos_decimales($tPrecioTotal)?></td>
    </tr>
</table>
<?php }?>

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
