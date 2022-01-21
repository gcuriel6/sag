<?php 
session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); 

$formatoAr = $arreglo['formatoAr'];
//$tipoActivo = $arreglo['tipoActivo'];

if($formatoAr == 'C')
    $tituloAr = 'SALIDA POR COMODATO';
else
    $tituloAr = 'SALIDA POR RESPONSIVA';

$idRegistro = $arreglo['id'];

// Informacion de la empresa 
        $query = "SELECT
        DATE(NOW()) AS fecha,
        activos.tipo AS tipo_activo,
        activos.no_serie,
        activos.num_economico AS num_e,
        activos.descripcion,
        activos.valor_adquisicion,
        IFNULL(activos.observaciones,'') AS observaciones,
        cat_unidades_negocio.descripcion AS du,
        cat_unidades_negocio.nombre,
         cat_unidades_negocio.logo,
        sucursales.descr,
        IF(activos_responsables.id_trabajador>0,CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)),razones_sociales.razon_social)AS reponsable_comodato,
        IFNULL(usuarios.nombre_comp,'') as usuario_captura,
        trabajadores.cve_nom AS no_empleado, cat_puestos.puesto,
        IFNULL(celulares.imei,'') AS imei_celular,
        IFNULL(celulares_marcas.marca,'') AS marca_celular,
        IFNULL(vehiculos_marcas.marcas,'') AS marca_vehiculo,
        IFNULL(armas_marcas.marca,'') AS marca_arma,
        IFNULL(equipo_computo_marcas.marca,'') AS marca_equipo_computo
        FROM activos
        INNER JOIN activos_responsables  ON activos.id =  activos_responsables.id_activo
        INNER JOIN cat_unidades_negocio ON activos_responsables.id_unidad_negocio = cat_unidades_negocio.id
        INNER JOIN sucursales ON activos_responsables.id_sucursal = sucursales.id_sucursal
        LEFT JOIN trabajadores  ON activos_responsables.id_trabajador= trabajadores.id_trabajador
        LEFT JOIN razones_sociales ON activos_responsables.id_cliente = razones_sociales.id 
        LEFT JOIN usuarios ON activos_responsables.id_usuario_captura= usuarios.id_usuario
        LEFT JOIN cat_puestos ON trabajadores.id_puesto=cat_puestos.id_puesto
        LEFT JOIN celulares ON activos.id=celulares.id_activo
        LEFT JOIN celulares_marcas ON celulares.id_marca=celulares_marcas.id
        LEFT JOIN vehiculos ON activos.id=vehiculos.id_activo
        LEFT JOIN vehiculos_marcas ON vehiculos.id_marca=vehiculos_marcas.id
        LEFT JOIN armas_activos ON activos.id=armas_activos.id_activo
        LEFT JOIN armas_marcas ON armas_activos.id_marca=armas_marcas.id
        LEFT JOIN equipo_computo ON activos.id=equipo_computo.id_activo
        LEFT JOIN equipo_computo_marcas ON equipo_computo.id_marca=equipo_computo_marcas.id
        WHERE   activos.id =".$idRegistro."
        ORDER BY activos_responsables.id DESC 
        LIMIT 1";  

        $consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);


//---datos almacen encabezado---
$fecha = $row['fecha'];
$noSerie = $row['no_serie']; 
$nE = $row['num_e'];   
$descripcion = $row['descripcion'];  
$valor = $row['valor_adquisicion'];  
$observaciones = $row['observaciones'];  
$unidad = $row['du']; 
$logo = $row['logo'];
$sucursal = $row['descr'];   
$reponsableComodato = $row['reponsable_comodato'];
$usuarioCaptura = $row['usuario_captura'];
$tipo_activo = $row['tipo_activo'];
$noEmpleado = $row['no_empleado'];
$puesto = $row['puesto'];

$imei_celular = $row['imei_celular'];
$marca_celular = $row['marca_celular'];
$marca_vehiculo = $row['marca_vehiculo'];
$marca_arma = $row['marca_arma'];
$marca_equipo_computo = $row['marca_equipo_computo'];

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
        <td colspan="2"><strong>Concepto: </strong>  Responsiva de Activo Fijo </td>
    </tr>
</table>

<?php

    if($tipo_activo == 1)
    {

?>
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
                    <td width='200'>" . $noEmpleado . "</td>
                    <td width='310'>" . $reponsableComodato. "</td> 
                    <td width='250'>" . $puesto . "</td>          
                </tr>";
        ?> 
        </tbody>
    </table>
<?php
    }
?>

<h4>Productos </h4>
<table class="borde_tabla" width="720">
    <thead>
        <tr class="encabezado">


            <?php

                if($tipo_activo == 1)
                {

            ?>

            <td width='150' align="center">No. Serie </td>
            <td width='150' align="center">No. Eco.</td>
            <td width='150' align="center">Marca</td>
            <td width='130' align="center">Modelo</td>
            <td width='100' align="center">Placas</td>
            <td width='60' align="center">Año</td>

            <?php
            
                }
                else
                {

            ?>

            <?php if($tipo_activo==2){?>
                <td width='140' align="center">Código IMEI</td>
            <?php }else{?>
                <td width='140' align="center">No. Serie</td>
            <?php }?>

            <td width='100' align="center">No. Eco.</td>
            <td width='100' align="center">Marca</td>
            <td width='100' align="center">Activo</td>
            <td width='100' align="center">Valor Adquisitivo</td>
            <td width='200' align="center">Observaciones</td>

            <?php
            
                }

            ?>
            
        </tr>
    </thead>
    <tbody>
    <?php

        if($tipo_activo == 1)
        {


            
            $queryD = "SELECT
            vehiculos.modelo,
            vehiculos_marcas.marcas AS marca,
            vehiculos.placas AS placa,
            vehiculos.anio
            FROM activos
            LEFT JOIN vehiculos ON activos.id=vehiculos.id_activo
            LEFT JOIN vehiculos_marcas ON vehiculos.id_marca=vehiculos_marcas.id
            WHERE   activos.id =".$idRegistro;  

            $consultaD = mysqli_query($link, $queryD);        
            $rD = mysqli_fetch_array($consultaD);        
            $marcaA = $rD['marca'];
            $placaA = $rD['placa'];
            $modeloA = $rD['modelo'];
            $anioA = $rD['anio'];

            echo   "<tr>
                <td width='150'>" . $noSerie . "</td>
                <td width='150'>" . $nE . "</td>
                <td width='150'>" . $marcaA . "</td>
                <td width='130'>" . $modeloA . "</td> 
                <td width='100'>" . $placaA . "</td> 
                <td width='60'>" . $anioA . "</td>          
            </tr>";

        }
        else
        {

            if($tipo_activo==1)
                $marca = $marca_vehiculo;
            else if($tipo_activo==2)
                $marca = $marca_celular;
            else if($tipo_activo==3)
                $marca = $marca_equipo_computo;
            else if($tipo_activo==5)
                $marca = $marca_arma;
            else
                $marca = '';

            if($tipo_activo==2)
                $codigo = $imei_celular;
            else
                $codigo = $noSerie;


            echo "<tr>
                <td width='140'>" . $codigo . "</td>
                <td width='100'>" . $nE . "</td>
                <td width='100'>" . $marca . "</td>
                <td width='100'>" . $descripcion . "</td>
                <td width='100' align='right'> ".dos_decimales($valor)."</td> 
                <td width='200'>" . $observaciones . "</td>          
            </tr>";   
        }


    ?> 
    </tbody>
</table>

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
        <td width="250" align="center"><?php echo $reponsableComodato;?></td>
        <td width="70"></td>
    </tr>
    <tr>
        <td width="70"></td>
        <td width="250" align="center"><b>NOMBRE QUIEN ENTREGA ACTIVO</b></td>
        <td width="60"></td>
        <td width="250" align="center"><b>NOMBRE RESPONSABLE</b></td>
        <td width="70"></td>
    </tr>
</table>
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
<br>
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
?>
