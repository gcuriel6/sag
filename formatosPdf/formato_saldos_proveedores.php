<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
$idProveedor = $arreglo['idRegistro'];     
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
        <td width="200" align="top"></td>
        <td width="360" class="datos" ><strong>CxP Saldos Proveedores</strong> <br></td>
        <td width="110">
            <table class='borde_tabla'>
                <tr>
                    <td class="verde">Fecha Impresión</td>
                    <td class="dato"><?php echo date("d-m-Y"); ?></td>
                </tr>
                <tr>
                	<td class="verde">Página</td>
                	<td class="dato"> [[page_cu]] de [[page_nb]]</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="710" class="borde_tabla">
    <tbody>
    <?php

    $condicionProveedor='';

    if($idProveedor>0){
        $condicionProveedor ="WHERE a.id_proveedor=".$idProveedor;
    }

            $queryE = "SELECT  
                a.id_proveedor,	
                c.nombre AS proveedor,                                   
                (SUM(IF(CURDATE() > DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY),(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva),0) - IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva),0)),0)))AS vencido,
                (SUM(IF(CURDATE() <= DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY),(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva),0) - IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva),0)),0)))AS sin_vencer,
               
                (SUM(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva),0))-SUM(IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva),0))) AS saldo
                FROM cxp a
                LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                LEFT JOIN proveedores c ON a.id_proveedor=c.id
                $condicionProveedor
                GROUP BY a.id_proveedor
              
                HAVING saldo!=0
                ORDER BY a.id ASC,a.fecha DESC";

        $resultEncabezado = mysqli_query($link, $queryE);
        while($rowE = mysqli_fetch_array($resultEncabezado))
        {
            $idProveedorE = $rowE['id_proveedor'];

            echo '<tr class="encabezado">';
            echo '<th scope="col" colspan="5">PROVEEDOR</th>';
            echo '<th scope="col" width="100">SIN VENCER</th>';
            echo '<th scope="col" width="100">VENCIDO</th>';
            echo '<th scope="col" width="100">SALDO</th>';
            echo '</tr>';

            echo "<tr>";
            echo "<td colspan='5'>" . $rowE['proveedor'] . "</td>";
            echo "<td width='100' align='right'>" . dos_decimales($rowE['sin_vencer']). "</td>";
            echo "<td width='100' align='right'>" . dos_decimales($rowE['vencido']). "</td>";
            echo "<td width='100' align='right'>" . dos_decimales($rowE['saldo']) . "</td>";
            echo "</tr>";

        

    ?>
        <!--NJES October/09/2020 se quita la parte de que en un td agregue la nueva tabla, porque era mucho conyenido para y marcaa error al crearla-->
        <!--<tr class="renglon">
            <td colspan="4">
                <table width="710" class="borde_tabla">-->
                    <tr class="encabezado">
                        <th scope="col" width="90">FOLIO FACTURA</th>
                        <th scope="col" width="90">FECHA</th>
                        <th scope="col" width="90">FECHA VENCIMIENTO</th>
                        <th scope="col" width="160">REFERENCIA</th>
                        <th scope="col" width="210">CONCEPTO</th>
                        <th scope="col" width="100">CARGO</th>
                        <th scope="col" width="100">ABONO</th>
                        <th scope="col" width="120">SALDO</th>
                    </tr>

                <?php

                $queryD = "SELECT 
                a.id_proveedor,	
                IF(a.no_factura=0,'',a.no_factura) AS folio_factura,
                a.fecha,
                DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY) AS vencimiento,
                a.referencia,
                CONCAT(b.clave,' - ',b.descripcion) AS concepto,
                c.nombre AS proveedor,
                if(a.estatus='C','Cancelada','') as estatus,
                IF(CURDATE() > DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY),'Vencida','') AS vencida,
                (IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0)) AS cargos,
                (IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva -a.descuento),0)) AS abonos
                FROM cxp a
                LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                LEFT JOIN proveedores c ON a.id_proveedor=c.id
                WHERE a.id_proveedor=$idProveedorE
                GROUP BY a.id
                -- ORDER BY a.id ASC,a.fecha DESC
                ORDER BY a.id_cxp ASC,a.id ASC,a.fecha DESC";

                    $totalCargos=0;
                    $totalAbonos=0;
                    $saldo=0;

                    $resultDetalle = mysqli_query($link, $queryD);
                    while($rowD = mysqli_fetch_array($resultDetalle))
                    {

                        $totalCargos=$totalCargos+$rowD['cargos'];
                        $totalAbonos=$totalAbonos+$rowD['abonos'];
                        $saldo = $totalCargos - $totalAbonos;

                        //-->NJES November/04/2020 se agrega folio de la factura que subio el proveedor
                        echo "<tr>";
                        echo "<td width='90'>" . $rowD['folio_factura'] . "</td>";
                        echo "<td width='90'>" . $rowD['fecha'] . "</td>";
                        if($rowE['saldo'] > 0)
                            echo "<td width='90'>" . $rowD['vencimiento'] . "</td>";
                        else
                            echo "<td width='90'>" . $rowD['vencimiento'] . "</td>";
                        echo "<td width='160'>" . normaliza($rowD['referencia'],50) . "</td>";
                        echo "<td width='210'>" . normaliza($rowD['concepto'],50). "</td>";
                        echo "<td width='100' align='right'>" . dos_decimales($rowD['cargos']). "</td>";
                        echo "<td width='100' align='right'>" . dos_decimales($rowD['abonos']) . "</td>";
                        echo "<td width='120' align='right'>" . dos_decimales($saldo) . "</td>";
                        echo "</tr>";

                    }

                ?>


                <!--</table>
            </td>
        </tr>-->
        <tr><td colspan="6"><br></td></tr>
       <?php }?>
    </tbody>
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