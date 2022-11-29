
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
            total,
            tiempo_entrega AS diasEntrega
            FROM vision_cotizacion vc
            WHERE vc.id = $idCotiz";

$consultaInfo = mysqli_query($link, $queryInfo);
$rowInfo = mysqli_fetch_array($consultaInfo);

//---datos sucursal---
$fecha = $rowInfo['fecha'];
$estatus = $rowInfo['estatus'];
$cliente = $rowInfo['cliente'];
$total = $rowInfo['total'];
$diasEntrega = $rowInfo["diasEntrega"];

$queryProductos = "SELECT vcp.cantidad, vp.nombre, vp.descripcion, vcp.costo, vp.clave, vp.url_imagen imagen
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

    table{        
        width:100%;
    }
</style>

<?php
    $amarillo = "#f8c915";
    $azul = "#16446c";
    $totalCotiz = 0;
?>

<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="5mm"  backbottom="5mm" backright="5mm" backleft="5mm">
<!--<img src="../imagenes/'.$rowU['logo'].'"  width="150"/>-->
<page_footer style="text-align:right;font-size:10px;">
    [[page_cu]] de [[page_nb]]
</page_footer>
<!-- <td class="dato"> [[page_cu]] de [[page_nb]]</td> -->
    <div class="cuadroPrincipal" style="width:100%;">
        <table style="width:100%;background-color:#f8c915;border:2px solid black;padding: 20px;">
            <tr>
                <th style="width:50%;">
                    <label>DATOS FISCALES:</label><br>
                    <label>SECORP VISION PUBLICITARIA S DE RL DE CV</label><br>
                    <label>RFC SVP1102043U5</label><br>
                    <label>DIRECCION: CERRADA DE BARROCA #6106</label><br>
                    <label>COL. PLAZA BARROCA CP. 31215 CHIHUAHUA,CHIH</label><br>
                    <label>TEL (614) 222 90 44</label>
                </th>
                <td style="width:50%;">
                    <img src='../vision/visionlogoblanco.png' style="width:100%;">
                </td>
            </tr>
        </table>
        <table style="width:100%;border:2px solid black;padding: 20px;">
            <tr>
                <th style="width:100%;">
                    <label>FECHA <?php echo $fecha; ?></label><br>
                    <label>CON ATENCIÓN A: <?php echo $cliente; ?></label>
                </th>
            </tr>
        </table>
        <table style="width:100%;background-color:#f8c915;border:2px solid black;padding: 5px;">
            <tr>
                <th style="width:100%;text-align:center;font-size:30px;">
                    COTIZACIÓN
                </th>
            </tr>
        </table>
        <table style="width:100%;border:2px solid black;border-collapse: collapse;">
            <tr>
                <th style="width:16.666%;text-align:center;border:2px solid black;padding:10px 0;">FOTO</th>
                <th style="width:16.666%;text-align:center;border:2px solid black;padding:10px 0;">DESCRIPCION</th>
                <th style="width:16.666%;text-align:center;border:2px solid black;padding:10px 0;">DECORADO</th>
                <th style="width:16.666%;text-align:center;border:2px solid black;padding:10px 0;">CANTIDAD</th>
                <th style="width:16.666%;text-align:center;border:2px solid black;padding:10px 0;">PRECIO UNITARIO</th>
                <th style="width:16.666%;text-align:center;border:2px solid black;padding:10px 0;">TOTAL (CON IVA)</th>
            </tr>
            <!-- aqui van productos -->
            <?php
                while($row = mysqli_fetch_assoc($consultaProductos)){
                    $imagen = $row["imagen"];
                    $descripcion = $row["descripcion"];
                    $cantidad = $row["cantidad"];
                    $costo = $row["costo"];
                    $total = $cantidad * $costo;
                    $totalCotiz+=$total;

                    //<img src='../vision/$imagen' style='width:100%;' >

                    echo "<tr>";
                        echo "<td style='width:16.666%;text-align:center;border:2px solid black;padding:10px 0;'><img src='../vision/$imagen' style='width:100%;' ></td>";
                        echo "<td style='width:16.666%;text-align:center;border:2px solid black;padding:10px 0;'>$descripcion</td>";
                        echo "<td style='width:16.666%;text-align:center;border:2px solid black;padding:10px 0;'></td>";
                        echo "<td style='width:16.666%;text-align:center;border:2px solid black;padding:10px 0;'>$cantidad</td>";
                        echo "<td style='width:16.666%;text-align:center;border:2px solid black;padding:10px 0;'>$costo</td>";
                        echo "<td style='width:16.666%;text-align:center;border:2px solid black;padding:10px 0;'>$total</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <table style="width:100%;background-color:#16446c;border:2px solid black;padding: 5px;">
            <tr>
                <th style="width:50%;text-align:left;font-size:30px;">
                </th>
                <th style="width:50%;text-align:right;font-size:30px;background-color:#f8c915;">
                    <?php 
                        echo "Total: $totalCotiz";
                    ?>
                </th>
            </tr>
            <tr>
                <th style="width:50%;text-align:left;font-size:15px;color:white;">
                    <label>Precios unitarios en MXN mas IVA</label><br>
                    <label>Se requiere una orden de compra para hacer pedido</label><br>
                    <label>Precios sujetos a existencias</label><br>
                    <label>Tiempo de entrega estimado: <?php echo $diasEntrega; ?> días habiles</label><br>
                    <label>Se requiere un anticipo de 50% para inicio de pedido y OC</label><br>
                    <label>Vigencia de la cotización 8 días hábiles</label> 
                </th>
                <th style="width:50%;text-align:center;font-size:15px;color:white;">
                    <span>DATOS DE TRANSFERENCIA</span><br>
                    <span>BANCO: BANORTE</span><br>
                    <span>CLABE INTERBANCARIA:</span><br>
                    <span>072 150 00314750716 3</span>
                </th>
            </tr>
        </table>
        <table style="width:100%;margin-top:10px;">
            <tr>
                <th style="width:50%;text-align:left;font-size:15px;">
                    <label>VISIONPUBLICIDAD.MX</label><br>
                </th>
                <th style="width:50%;text-align:right;font-size:15px;">
                    <label>Suheyt Holguín (614) 494 2232 </label>
                </th>
            </tr>
        </table>
        
    </div>

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