
<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
include("../php/conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idCotiz = $arreglo['idCotiz'];
// Informacion de la empresa 
$queryInfo = "SELECT vc.id idCotiz,
            DATE(vc.fecha) fecha,
            vc.estatus,
            IF(vc.fk_idcliente = 0,
            (SELECT nombre_cliente FROM vision_prospectos WHERE fk_cotizacion = vc.id),
            (SELECT nombre_corto FROM vision_clientes WHERE id_cliente = vc.fk_idcliente)) cliente,
            total
            FROM vision_cotizacion vc
            WHERE vc.id = $idCotiz";

$consultaInfo = mysqli_query($link, $queryInfo);
$rowInfo = mysqli_fetch_array($consultaInfo);

//---datos sucursal---
$fecha = $rowInfo['fecha'];
$estatus = $rowInfo['estatus'];
$cliente = $rowInfo['cliente'];
$total = $rowInfo['total'];

$queryProductos = "SELECT vcp.cantidad, vp.nombre, vp.descripcion, vp.costo, vp.clave, vp.url_imagen imagen
                    FROM vision_cotizacion_productos vcp
                    INNER JOIN vision_productos vp ON vcp.fk_productos = vp.id
                    WHERE vcp.fk_cotizacion = $idCotiz;";

$consultaProductos = mysqli_query($link, $queryProductos);

$queryMaterias = "SELECT vcm.cantidad, vm.descripcion, vm.clave, vm.unidad_medida
                    FROM vision_cotizacion_matprim vcm
                    INNER JOIN vision_materiaprima vm ON vcm.fk_matprim = vm.id
                    WHERE vcm.fk_cotizacion = $idCotiz";

$consultaMaterias = mysqli_query($link, $queryMaterias);
      
?>

<style>

@import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap');

    *{
        box-sizing: border-box;
        font-family: 'Lato', sans-serif;
    }
    .principal{
        /* background-color: red; */
        width:100%;
    }
    .principal th{
        width: 100%;
    }

    .secundaria{
        border: none;
    }

    .secundaria th,
    .secundaria td{
        border: 1px solid black;
    }

    .secundaria th{
        padding: 4px 1px;
    }

    .secundaria .header th{
        text-align: center;
        background-color: #444;
        color: white;
        padding: 4px 1px;
    }

    table{
        color: #444;
    }
</style>

<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="3mm"  backbottom="5mm">
<!--<img src="../imagenes/'.$rowU['logo'].'"  width="150"/>-->
<page_footer style="text-align:right;font-size:10px;">
    [[page_cu]] de [[page_nb]]
</page_footer>
<!-- <td class="dato"> [[page_cu]] de [[page_nb]]</td> -->
    <table class="principal" width=771>
        <tbody>
            <tr>
                <th width=351 style="padding-left:10px; line-height: 1.4;">
                    <label>SVP1102043U5</label><br>
                    <label>SECORP VISION PUBLICITARIAS. DE R.L. DE C.V</label><br>
                    <label>CERRADA DE BARROCA NO. 6106</label><br>
                    <label>PLAZABARROCA</label><br>
                    <label>C.P. 31215</label><br>
                    <label>CHIHUAHUA, CHIH.</label><br>
                    <label>TEL (614) 415-0252</label><br><br>

                    <label style="font-size: 18px;">Fecha: <?php echo  $fecha ?></label><br>
                    <label style="font-size: 18px;">Para: <?php echo  $cliente ?></label>
                </th>
                <th width=400><img src="../imagenes/logo_vision2021.png"  width="400"/></th>
            </tr>
        </tbody>
    </table>
    <table width=771>
        <tbody>
            <tr>
                <th width=751 style="padding-left:10px;">
                    <label style="font-size: 38px;">COTIZACIÓN</label>
                </th>
            </tr>
        </tbody>
    </table>
    <table width=700 class="secundaria" >
        <tbody>
            <tr class="header">
                <th width=100 style="padding-left:10px;">Foto</th>
                <th width=120>Descripción</th>
                <th width=120>Decorado</th>
                <th width=120>Escala</th>
                <th width=120>Precio Unidad</th>
                <th width=120>Total sin IVA</th>
            </tr>

            <?php
                while($row = mysqli_fetch_array($consultaProductos)){
                    $imagen = $row["imagen"];
                    $descr = $row["descripcion"];
                    $costo = ($row["costo"]);
                    $cantidad = $row["cantidad"];

                    $total = $costo * $cantidad;
                    $total = dos_decimales($total);

                    echo "<tr>
                            <th width=100 height=100 style='padding-left:10px; text-align:center;'><img src='../vision/$imagen' width='100' height='100'/></th>
                            <th width=120 height=100 style='text-align:left;'>$descr</th>
                            <th width=120 height=100 style='text-align:center;'></th>
                            <th width=120 height=100 style='text-align:center;'></th>
                            <th width=120 height=100 style='text-align:center;'>$$costo</th>
                            <th width=120 height=100 style='text-align:center;'>$total</th>
                        </tr>";
                }
            ?>

        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <th width=400 valign="top" style="font-size: 13px; font-weight: 600; line-height: 1.4;">
                    <label style="font-weight: bold; font-size: 16px;">DATOS FISCALES:</label><br>
                    <label>RAZON SOCIAL: SECORP VISION PUBLICITARIA S DE RL DE CV</label><br>
                    <label>RFC: SVP1102043U5</label><br>
                    <label>DIRECCION: CERRADA DE BARROCA 6106 C.P. 31215</label><br>
                    <label>CHIHUAHUA, CHHUAHUA</label>
                </th>
                <th width=300 valign="top" style="font-size: 13px; font-weight: 600; padding-left:10px; line-height: 1.4;">
                    <label style="font-weight: bold; font-size: 16px;">DATOS DE TRANSFERENCIA:</label><br>
                    <label>BANCO: BANORTE</label><br>
                    <label>No. CUENTA: 0314750716</label><br>
                    <label>CLAVE INTERBANCARIA: 072 150 00314750716 3</label>
                </th>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <th width=350 valign="top" style="font-size: 15px; font-weight: bold; line-height: 1.4;">
                    <label>- Precios unitarios en MN mas IVA</label><br>
                    <label>- Se requiere una orden de compra para hacer pedido</label><br>
                    <label>- Precios sujetos a existencias</label><br>
                    <label>- Tiempo de entrega de __ a __ días hábiles</label><br>
                    <label>- Se requiere un anticipo de 50% para inicio de pedido y OC</label><br>
                    <label>- Vigencia de la cotización 8 días hábiles</label>
                </th>
                <th width=350 valign="top" style="padding-left:20px; text-align: right; font-size: 17px; font-weight: 600; line-height: 1.2;">
                    <label style="font-size: 30px; font-weight: bold;">VISIONPUBLICIDAD.MX</label><br>
                    <label style="font-size: 20px; font-weight: bold;">Aténtamente:</label><br>
                    <label>José Luis Ramos</label><br>
                    <label>614.176.78.04</label><br>
                    <label>creativo@secorp.mx</label>
                </th>
            </tr>
        </tbody>
    </table>

</page>
          
<?php 

// while($rowD = mysqli_fetch_array($resultDetalle)){}

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

function normaliza($texto,$longitud){
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