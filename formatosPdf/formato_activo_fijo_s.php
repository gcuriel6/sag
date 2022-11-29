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
/* .borde_negro_tabla{
    border: 1px solid black;
} */
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
        <td width="750">
            El suscrito, en mi carácter de responsable, manifiesto que recibo bajo mi resguardo y responsabilidad, como herramienta de trabajo para el desarrollo de mis actividades, el vehículo descrito en el presente documento, propiedad de SEGURIDAD PRIVADA GINTHER DE OCCIDENTE, S. DE R.L. DE C.V.
        </td>
    </tr>
    <tr>
        <td width="750">
            En ese tenor, enterado de su alcance, expreso mi aceptación a cumplir con las obligaciones siguientes:
        </td>
    </tr>
    <tr>
        <td width="750">
            1.- Usar el vehículo única y exclusivamente para el desarrollo de las actividades laborales que me sean encomendadas, salvo excepción expresamente autorizada por el coordinador o la gerencia, sin que dicha excepción pueda ser para trasladarse a bares, centros nocturnos o eventos políticos no relacionados con la actividad de la empresa.
        </td>
    </tr>
    <tr>
        <td width="750">
            2.- Revisar la unidad antes y después de conducirla, elaborando el check-list correspondiente y remitiéndolo al personal de operaciones y activo fijo diariamente, en el entendido de que las cuestiones no reportadas al momento de tomar la unidad serán responsabilidad del suscrito.
        </td>
    </tr>
    <tr>
        <td width="750">
            3.- Responder por cualquier desperfecto, daños, siniestro o falla mecánica causada por mi negligencia, mal uso o descuido del vehículo o relacionado con éste, para lo cual autorizo mediante este documento su descuento vía nómina, en caso de ser necesario; respondiendo la empresa únicamente por las reparaciones y daños por caso fortuito, fuerza mayor o circunstancias no imputables al suscrito, previo análisis del Departamento de Activo Fijo con base en el dictamen entregado por la compañía de seguros respectiva.
        </td>
    </tr>
    <tr>
        <td width="750">
            4.- Asumir por mi cuenta la reparación de neumáticos perforados (no aplica en el caso de ATT).
        </td>
    </tr>
    <tr>
        <td width="750">
            5.- Mantener la unidad en buen estado, limpia y funcional para el servicio.
        </td>
    </tr>
    <tr>
        <td width="750">
            6.- Reportar las necesidades de aditamentos como torreta, extintor, atrapa birlos, pértiga, faros de reversa, luces, reflejante, calzas, eslinga, pala, barras de amacice y cualquier aditamento solicitado por el Departamento de Seguridad Industrial al personal de seguridad industrial de la empresa o, en su defecto, al líder operativo para su reparación.
        </td>
    </tr>
    <tr>
        <td width="750">
            7.- Entregar semanalmente bitácoras de visitas para recibir suministro de gasolina, a juicio del Departamento de Activo Fijo.
        </td>
    </tr>
    <tr>
        <td width="750">
            8.- Respetar los límites de velocidad establecidos por el Departamento de Seguridad Industrial (ciudad 70 km máximo, salvo disposición expresa en contrario en la señalización vial correspondiente;100 km máximo en carretera salvo disposición expresa en contrario en la señalización vial correspondiente).
        </td>
    </tr>
    <tr>
        <td width="750">
            9.- Acatar todas las reglas y límites establecidos por el Departamento de Seguridad Industrial de las diferentes UDN.
        </td>
    </tr>
    <tr>
        <td width="750">
            10.- Asumir el costo de las infracciones viales ocasionadas mientras se tenga el resguardo de la unidad, autorizando mediante este acto el descuento del importe vía nómina, de ser necesario.
        </td>
    </tr>
    <tr>
        <td width="750">
            11.- No prestar la unidad a personal ajeno a la empresa o a personas no autorizadas para su manejo, salvo previa autorización expresa del coordinador o gerencia.
        </td>
    </tr>
    <tr>
        <td width="750">
            12.- No trasladar a personal ajeno a la empresa, salvo previa autorización expresa del coordinador o gerencia.
        </td>
    </tr>
    <tr>
        <td width="750">
            13.- No fumar dentro de la unidad.
        </td>
    </tr>
    <tr>
        <td width="750">
            14.- No ingerir alimentos dentro de la unidad.
        </td>
    </tr>
    <tr>
        <td width="750">
            15.- No rebasar el límite de personas a bordo conforme a las características técnicas del vehículo.
        </td>
    </tr>
    <tr>
        <td width="750">
            16.- No trasladar a personas en espacios del vehículo que no se encuentren destinados o habilitados para ello.
        </td>
    </tr>
    <tr>
        <td width="750">
            17.- No conducir en estado de ebriedad ni consumir bebidas alcohólicas dentro de la unidad.
        </td>
    </tr>
    <tr>
        <td width="750">
            18.- Contar con todos los documentos legales para la circulación del vehículo, tales como póliza de seguro vigente, tarjeta de circulación vigente y licencia de conducir vigente; debiendo, en su caso, solicitar los primeros dos documentos al coordinador o personal de activo fijo.
        </td>
    </tr>
    <tr>
        <td width="750">
            19.- En caso de siniestro llamar al 01-800 marcado en la póliza de seguro entregada, dar aviso inmediatamente al gerente a cargo y hacer del conocimiento al Departamento de Activo Fijo.
        </td>
    </tr>
    <tr>
        <td width="750">
            Así mismo, manifiesto que tengo conocimiento de que el incumplimiento a las obligaciones asumidas son motivo de sanción conforme a la legislación laboral vigente.
        </td>
    </tr>
    <tr>
        <td width="750">
            Así lo asumo y dejo constancia de mi voluntad libre de toda coacción con mi firma que obra en la parte superior de la presente responsiva.
        </td>
    </tr>
</table>
<?php }?>
<br>
<page_footer style="text-align:right;font-size:10px;">
    [[page_cu]] de [[page_nb]]
</page_footer>

</page>

<page backtop="3mm"  backbottom="5mm">
    <table class="borde_negro_tabla">
        <tr>
            <td width="750" align="center">
            <h1>PAGARÉ</h1>
            </td>
        </tr>
        <tr>
            <td width="750" align="justify">
            Por este pagaré me obligo incondicionalmente a pagar a la orden de Seguridad Privada Ginther de Occidente, S. de R.L. de C.V., en el domicilio ubicado en Cerrada de Barroca No. 6106, Colonia Plaza Barroca, Chihuahua, Chihuahua, C.P. 31215, o en cualquier otro que se me requiera, la cantidad de $________________________(___________________________M.N.) que me obligo a cubrir en ____ pagos mensuales, vencidos y sucesivos, cada uno por la cantidad que en moneda nacional sea equivalente a  ___________ veces el salario mínimo general vigente en la ciudad de Chihuahua, Chih., en la fecha de cada pago, debiendo realizar el primer pago el día __ de ____ de 20__.
            </td>
        </tr>
        <tr>
            <td width="750" align="justify">
            Lo anterior, implica que la cantidad mencionada en moneda nacional en este pagaré se incrementará en forma proporcional a los cambios que experimente el salario mínimo general vigente en la ciudad de Chihuahua, Chih., entre la fecha de firma de este documento y la fecha de cada pago mensual, tomando como base que el monto del salario mínimo general a la fecha de firma de este pagaré es de $___________ (_________________M.N.).
            </td>
        </tr>
        <tr>
            <td width="750" align="justify">
            El incumplimiento en el pago de dos mensualidades como máximo, da derecho a Seguridad Privada Ginther de Occidente, S. de R.L. de C.V. o a su tenedor, a exigir el cumplimiento del saldo insoluto.
            </td>
        </tr>
        <tr>
            <td width="750" align="justify">
            Este pagaré sólo perderá su ejecutividad mediante su destrucción, que podrá ocurrir: cuando el deudor cumpla con todas y cada una de sus obligaciones contraídas con Seguridad Privada Ginther de Occidente, S. de R.L. de C.V. a juicio de ésta última; en caso de liquidación del monto total consignado en este documento; en caso de sustitución por un nuevo documento por razones de reestructuración, en virtud de un nuevo plan de pago que acuerde Seguridad Privada Ginther de Occidente, S. de R.L. de C.V. con el deudor.
            </td>
        </tr>
        <tr>
            <td width="750" align="justify">
            Suscrito en la ciudad de Chihuahua, Chih., a los ___ días del mes de ______________ de 20__.
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width="375" style="border: 1px solid black;">
                <p align="center">ACEPTO</p>
                <p align="center">EL SUSCRIPTOR</p>
                <p>Nombre:</p>
                <p>Domicilio:</p>
                <p>Teléfono:</p>
            </td>
            <td width="375" style="border: 1px solid black;">
                <p align="center">ACEPTO</p>
                <p align="center">EL AVAL</p>
                <p>Nombre:</p>
                <p>Domicilio:</p>
                <p>Teléfono:</p>
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
    return '$ '.$number; 
}
?>
