<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];
$formatoAr = $arreglo['formatoAr'];
//$tipoActivo = $arreglo['tipoActivo'];

if($formatoAr == 'C')
    $tituloAr = 'SALIDA POR COMODATO';
else
    $tituloAr = 'SALIDA POR RESPONSIVA';

//$conceptoAlmacen = $arreglo['concepto'];

// Informacion de la empresa 
$query = "SELECT a.id,
            a.folio,
            a.cve_concepto,
            a.id_unidad_negocio,
            d.nombre AS unidad,
            d.logo,
            d.clave as clave_unidad,
            a.id_sucursal,
            e.descr AS sucursal,
            DATE(a.fecha) AS fecha,
            a.observacion,
            a.id_clasificacion,
            f.nombre AS clasificacion,
            a.id_sucursal_destino,
            g.descr AS sucursal_destino,
            a.id_proveedor,
            l.id_trabajador,
            b.nombre AS proveedor,
            ifNUll(CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido_p),' ',TRIM(c.apellido_m)),'') AS empleado,
            a.id_departamento,
            h.des_dep AS departamento,
            IFNULL(i.descripcion,'') AS area,
            IFNULL(CONCAT(TRIM(j.nombre),' ',TRIM(j.apellido_p),' ',TRIM(j.apellido_m)),'') AS supervisor,
            k.nombre_comp as usuario_captura,
            k.usuario,
            n.tipo AS tipo_activo,
            IF(l.id_trabajador>0,CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido_p),' ',TRIM(c.apellido_m)),IF(l.responsable_externo='',m.razon_social,l.responsable_externo))AS reponsable_comodato,
            cat_puestos.puesto,
            c.cve_nom AS no_empleado,
            n.no_serie,
            n.num_economico AS num_e,
            vehiculos.modelo,
            vehiculos_marcas.marcas AS marca,
            vehiculos.placas AS placa,
            vehiculos.anio
            FROM almacen_e a
            LEFT JOIN proveedores b ON a.id_proveedor=b.id
            LEFT JOIN activos_responsables l ON a.id_activo_fijo=l.id_activo AND responsable=1
            LEFT JOIN trabajadores c ON l.id_trabajador=c.id_trabajador
            LEFT JOIN cat_unidades_negocio d ON a.id_unidad_negocio=d.id
            LEFT JOIN sucursales e ON a.id_sucursal=e.id_sucursal
            LEFT JOIN clasificacion_salidas f ON a.id_clasificacion=f.id
            LEFT JOIN sucursales g ON a.id_sucursal_destino=g.id_sucursal
            LEFT JOIN deptos h ON a.id_departamento=h.id_depto
            LEFT JOIN cat_areas i ON h.id_area=i.id
            LEFT JOIN trabajadores j ON h.id_supervisor=j.id_trabajador
            LEFT JOIN razones_sociales m ON l.id_cliente = m.id 
            LEFT JOIN usuarios k ON a.id_usuario_captura= k.id_usuario
            LEFT JOIN activos n ON l.id_activo=n.id
            LEFT JOIN cat_puestos ON c.id_puesto=cat_puestos.id_puesto
            LEFT JOIN vehiculos ON n.id=vehiculos.id_activo
            LEFT JOIN vehiculos_marcas ON vehiculos.id_marca=vehiculos_marcas.id
            WHERE a.id=".$idRegistro;

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$fecha = $row['fecha'];
$logo = $row['logo'];
$folio = $row['folio'];
$unidad = $row['unidad'];
$claveUnidad = $row['clave_unidad'];
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
$usuarioCaptura = $row['usuario_captura'];
$usuario = $row['usuario'];  
$reponsableComodato = $row['reponsable_comodato'];
$tipo_activo = $row['tipo_activo'];   

$nE = $row['num_e'];
$noSerie = $row['no_serie'];
$marca = $row['marca'];
$modelo = $row['modelo'];
$placa = $row['placa'];
$no_empleado = $row['no_empleado'];
$puesto = $row['puesto'];
$anio = $row['anio'];

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
.borde_negro_tabla{
    border: 1px solid black;
}
.borde_negro_tabla td{
    padding:5px;
}
</style>
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="3mm"  backbottom="5mm">
<?php if($tipo_activo==1 && $formatoAr == 'R'){?>
<table width="710" border="0">
    <tr>
        <!--<td width="200" align="top"><?php/* echo '<img src="../imagenes/'.$row['logo'].'"  width="150"/>';*/?></td>-->
        <td width="250" align="top"><?php echo $unidad; ?></td>
        <td width="250" class="datos" align="center" ><strong><?php echo $tituloAr;?></strong> <br>
            GINTHERCORP<br> 
            CORPORATIVO<br>
        </td>
        <td width="130"></td>
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
<?php }else{?>
<table width="710" border="0">
    <tr>
        <td width="200" align="top"><?php echo '<img src="../imagenes/'.$row['logo'].'"  width="150"/>';?></td>
        <td width="400" class="datos" align="center" ><strong><?php echo $tituloAr;?></strong> <br>
            Unidad de Negocio: <?php echo $unidad; ?><br> 
            Sucursal: <?php echo $sucursal;?><br>
        </td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                  <td class="verde">Folio</td>
                  <td class="dato"><?php echo $claveUnidad.'-'.$folio;?></td>
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
<?php }?>
<br>
<?php if($tipo_activo==1){?>

    <?php if($formatoAr == 'R'){?>
    <table class="borde_tabla" width="100%">
        <thead>
            <tr class="encabezado">
                <td width='200' align="center">No. Empleado</td>
                <td width='310' align="center">Nombre </td>
                <td width='250' align="center">Puesto</td>
            </tr>
        </thead>
        <tbody>
        <?php

        echo   "<tr>
                    <td width='200'>" . $no_empleado . "</td>
                    <td width='310'>" . $reponsableComodato. "</td> 
                    <td width='250'>" . $puesto . "</td>          
                </tr>";
        ?> 
        </tbody>
    </table>
    <?php }?>

    <br><br>

    <table class="borde_tabla">
        <thead>
            <tr class="encabezado">
                <td width='150' align="center">No. Economico</td>
                <td width='150' align="center">No. Serie </td>
                <td width='150' align="center">Marca</td>
                <td width='130' align="center">Modelo</td>
                <td width='100' align="center">Placa</td>
                <td width='60' align="center">Año</td>
            </tr>
        </thead>
        <tbody>
        <?php

        echo   "<tr>
                    <td width='150'>" . $nE . "</td>
                    <td width='150'>" . $noSerie . "</td>
                    <td width='150'>" . $marca . "</td>
                    <td width='130'>" . $modelo. "</td> 
                    <td width='100'>" . $placa . "</td>  
                    <td width='60'>" . $anio . "</td>        
                </tr>";
        ?> 
        </tbody>
    </table>
<?php }else{?>
<table class="borde_tabla" width="100%">
    <tr>
        <td colspan="2"><strong>Concepto: </strong> Salida por Responsiva </td>
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

    <tr>
        <td colspan="2"><strong>Generado Por: </strong>(<?php echo $usuario.")  ".$usuarioCaptura;?></td>
    </tr>

</table>
<p><strong>Observaciones: </strong> <?php echo $observacion;?></p>



<!---- Productos---->
<?php  
  //-->NJES March/11/2020 mostrar no serie y num economico del activo
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
                (a.precio * a.cantidad) AS importe,
                f.no_serie, 
                f.num_economico,
                IFNULL(celulares.imei,'') AS imei_celular,
                IFNULL(celulares_marcas.marca,'') AS marca_celular,
                IFNULL(vehiculos_marcas.marcas,'') AS marca_vehiculo,
                IFNULL(armas_marcas.marca,'') AS marca_arma,
                IFNULL(equipo_computo_marcas.marca,'') AS marca_equipo_computo
                FROM almacen_d a
                LEFT JOIN productos b ON a.id_producto=b.id
                LEFT JOIN familias c ON b.id_familia = c.id
                LEFT JOIN lineas d ON b.id_linea = d.id
                LEFT JOIN almacen_e e ON a.id_almacen_e=e.id
                LEFT JOIN activos f ON e.id_activo_fijo=f.id
                LEFT JOIN celulares ON f.id=celulares.id_activo
                LEFT JOIN celulares_marcas ON celulares.id_marca=celulares_marcas.id
                LEFT JOIN vehiculos ON f.id=vehiculos.id_activo
                LEFT JOIN vehiculos_marcas ON vehiculos.id_marca=vehiculos_marcas.id
                LEFT JOIN armas_activos ON f.id=armas_activos.id_activo
                LEFT JOIN armas_marcas ON armas_activos.id_marca=armas_marcas.id
                LEFT JOIN equipo_computo ON f.id=equipo_computo.id_activo
                LEFT JOIN equipo_computo_marcas ON equipo_computo.id_marca=equipo_computo_marcas.id
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
            <td width='50' align="center">Catálogo </td>
            <td width='90' align="center">Familia</td>
            <td width='90' align="center">Línea</td>
            <td width='90' align="center">Concepto</td>
            <td width='80' align="center">Marca</td>
        <?php if($tipo_activo==2){?>
            <td width='68' align="center">Código IMEI</td>
        <?php }else{?>
            <td width='68' align="center">No. Serie</td>
        <?php }?>
            <td width='68' align="center">No. Económico</td>
            <td width='40' align="center">Cant</td>
            <td width='70' align="center">Precio U.</td>
            <td width='75' align="center">Importe</td>
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

        if($tipo_activo==1)
            $marca = $rowE['marca_vehiculo'];
        else if($tipo_activo==2)
            $marca = $rowE['marca_celular'];
        else if($tipo_activo==3)
            $marca = $rowE['marca_equipo_computo'];
        else if($tipo_activo==5)
            $marca = $rowE['marca_arma'];
        else
            $marca = $rowE['marca'];

        if($tipo_activo==2)
            $codigo = $rowE['imei_celular'];
        else
            $codigo = $rowE['no_serie'];
      
        echo   "<tr>
                    <td width='50'>".$rowE['id_producto']."</td>
                    <td width='90'>".$rowE['familia']."</td> 
                    <td width='90'>".$rowE['linea']."</td> 
                    <td width='90'>".$rowE['concepto']."</td> 
                    <td width='80'>".normaliza($marca,13)."</td> 
                    <td width='68' align='center'>".normaliza($codigo,10)."</td> 
                    <td width='68' align='center'>".normaliza($rowE['num_economico'],10)."</td> 
                    <td width='40' align='right'>".$rowE['cantidad']."</td> 
                    <td width='70' align='right'> ".dos_decimales($rowE['precio'])."</td>
                    <td width='75' align='right'> ".dos_decimales($rowE['importe'])."</td>           
                </tr>";
    
    }
    ?> 
    </tbody>
</table>
<br>
<table>
    <tr class="encabezado">
        <td width='570'>Totales </td>
        <td width='41' align="right"><?php echo $tCantidad;?></td>
        <td width='71' align="center"> <?php echo dos_decimales($tPrecio)?></td>
        <td width='76' align="right"> <?php echo dos_decimales($tPrecioTotal)?></td>
    </tr>
</table>
<?php }?>
<?php }?>
<?php if($tipo_activo==1){?>
    <br><br>
    <br><br>
    <br><br>

    <table width="710">
        <tr>
            <td width="70"></td>
            <td width="250"  align="center">______________________________________</td>
            <td width="60"></td>
            <td width="250"  align="center">______________________________________</td>
            <td width="70"></td>
        </tr>
        <tr>
            <td width="70"></td>
            <td width="250" align="center"><?php echo $reponsableComodato;?><br><b>NOMBRE RESPONSABLE</b></td>
            <td width="60"></td>
            <td width="250" align="center"><?php echo $usuarioCaptura?><br><b>NOMBRE QUIEN ENTREGA ACTIVO</b></td>
            <td width="70"></td>
        </tr>
    </table>
<?php }else{?>
    <br><br>
    <br><br>

    <table width="710">
        <tr>
            <td width="70"></td>
            <td width="250"  align="center">______________________________________</td>
            <td width="60"></td>
            <td width="250"  align="center">______________________________________</td>
            <td width="70"></td>
        </tr>
        <tr>
            <td width="70"></td>
            <td width="250" align="center"><?php echo $usuarioCaptura;?></td>
            <td width="60"></td>
            <td width="250" align="center"><?php echo $reponsableComodato?></td>
            <td width="70"></td>
        </tr>
    </table>
<?php }?>
<!--MGFS SOLO SE IMPRIME SI ES 1=VEHICULO-->
<!--NJES May/18/2020 se agrega nueva descripcion para vehiculo-->
<?php if($tipo_activo==1){?>
<br>
<br>
<table class="borde_negro_tabla">
<tr>
        <td width="750" style="border-bottom: 1px solid black;">
            1- SE HACE ENTREGA DEL ACTIVO ARRIBA MENCIONADO, PARA EL USO EXCLUSIVO DE LA OPERACIÓN, DE ACUERDO A
            SU PUESTO DE TRABAJO. QUEDA PROHIBIDO EL USO INADECUADO, MANEJO EN EXCESO DE VELOCIDAD (PERMITIDO
            EN CIUDAD 70KM MÁXIMO, 100KM EN CARRETERA MÁXIMO), NO USAR EN ESTADO DE EBRIEDAD, NO ACUDIR A
            BARES, ANTROS O EVENTOS POLÍTICOS CON EL VEHÍCULO. EL FALTAR ALGUNO DE LOS PUNTOS MENCIONADOS
            ARRIBA SERÁ MOTIVO PARA RETIRO DEL VEHÍCULO. MANTENER SIEMPRE LIMPIO.
        </td>
    </tr>
    <tr>
        <td width="750" style="border-bottom: 1px solid black;">
            2. DEBERÁ ENTREGAR SEMANALMENTE BITÁCORAS DE VISITAS PARA RECIBIR EL APOYO DE GASOLINA OTORGADO,
            DEPENDIENDO EL CARGO.
        </td>
    </tr>
    <tr>
        <td width="750" style="border-bottom: 1px solid black;">
            3.- EN CASO DE SINIESTRO LLAMAR AL 01-800 MARCADO EN LA PÓLIZA DE SEGURO ENTREGADA, DAR AVISO
            INMEDIATAMENTE AL GERENTE A CARGO Y HACER DEL CONOCIMIENTO AL DEPARTAMENTO DE ACTIVO FIJO.
        </td>
    </tr>
    <tr>
        <td width="750" style="border-bottom: 1px solid black;">
            4.- EN CASO DE QUE UN INCIDENTE HAYA SIDO POR DESCUIDO O NEGLIGENCIA DE EMPLEADO, LOS DAÑOS
            CORRERÁN 100% POR PARTE DEL USUARIO, SI NO, SE HARÁ UN ANÁLISIS POR PARTE DEL DEPARTAMENTO DE
            ACTIVO FIJO, CON EL DICTAMEN ENTREGADO POR LA ASEGURADORA.
        </td>
    </tr>
    <tr>
        <td width="750" style="border-bottom: 1px solid black;">
            5.- LAS DESPONCHADURAS CORREN POR PARTE DEL USUARIO. EN CASO DE LA SUCURSAL ATT, NO APLICA.
        </td>
    </tr>
    <tr>
        <td width="750">
            6.- LOS USUARIOS, SON RESPONSABLES DEL PAGO DE MULTAS. ESTAS SERÁN MONITOREADAS CADA MES Y SERÁN DESCONTADAS VÍA NÓMINA.
        </td>
    </tr>
</table>
<?php }?>

<page_footer style="text-align:right;font-size:10px;">
    [[page_cu]] de [[page_nb]]
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
