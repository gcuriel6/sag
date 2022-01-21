<?php 
session_start();
include("conectar.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y
     
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
        <td width="400" class="datos" align="center" ><strong>Reporte CXP Facturas Saldadas</strong> <br></td>
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
    <thead>
        <tr class="encabezado">
            <th scope="col" width="50">FAC</th>
            <th scope="col" width="100">FECHA</th>
            <th scope="col" width="120">PROVEEDOR</th>
            <th scope="col" width="120">BANCO</th>
            <th scope="col" width="50">CUENTA</th>
            <th scope="col" width="100">CARGO</th>
            <th scope="col" width="100">ABONO</th>
        </tr>
    </thead>
    <tbody>
    <?php

    $queryE = "SELECT
    b.id,
    cxp_s.id_cxp,
    b.no_factura,
    b.fecha,
    IFNULL(c.cuenta,'') AS cuenta,
    IFNULL(d.descripcion,'') AS banco,
    IFNULL(e.nombre,'') AS proveedor,
    IFNULL(IF((SUBSTR(b.clave_concepto,1,1) = 'C'),(b.subtotal +b.iva),0),0) AS cargo, 
    IFNULL(IF((SUBSTR(b.clave_concepto,1,1) = 'A'),(b.subtotal + b.iva),0),0) AS abono
    FROM 
        (SELECT id_cxp,
        IFNULL(SUM(IF((SUBSTR(a.clave_concepto,1,1) = 'C'),(a.subtotal + a.iva),0)),0) AS cargos,
        IFNULL(SUM(IF((SUBSTR(a.clave_concepto,1,1) = 'C'),(a.subtotal + a.iva),((a.subtotal + a.iva) * -(1)))),0) AS saldo
        FROM cxp a
        GROUP BY a.id_cxp
        HAVING cargos>0 AND saldo=0) AS cxp_s
        
    LEFT JOIN cxp b ON b.id_cxp=cxp_s.id_cxp AND b.subtotal>0
    LEFT JOIN cuentas_bancos c ON c.id=b.id_cuenta_banco
    LEFT JOIN bancos d ON d.id=b.id_banco
    LEFT JOIN proveedores e ON b.id_proveedor=e.id
    LEFT JOIN conceptos_cxp f ON b.id_concepto=f.id
    GROUP BY b.id	
    ORDER BY b.no_factura,b.id_cxp";

        $resultEncabezado = mysqli_query($link, $queryE);
        while($rowE = mysqli_fetch_array($resultEncabezado))
        {


            echo "<tr>";
            echo "<td>" . $rowE['no_factura'] . "</td>";
            echo "<td>" . $rowE['fecha'] . "</td>";
            echo "<td>" . normaliza($rowE['proveedor'],20) . "</td>";
            echo "<td>" . normaliza($rowE['banco'],20) . "</td>";
            echo "<td>" . $rowE['cuenta'] . "</td>";
            echo "<td align='right'>" . dos_decimales($rowE['cargo']). "</td>";
            echo "<td align='right'>" . dos_decimales($rowE['abono']) . "</td>";
            echo "</tr>";

     
    }?>
    </tbody>
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