<meta charset="UTF-8"/>
<?php
session_start();
include '../php/conectar.php';
$link = Conectarse();

$id_unidad = $_REQUEST['id_unidad'];
$nombre = $_REQUEST['nombre'];

header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: filename=plantilla.xls");
header("Pragma: no-cache");
header("Expires: 0");

$html='';

    /*$query = "SELECT a.id,a.nombre,a.clave,CONCAT(a.id,'-',a.nombre) AS unidad_negocio
                FROM cat_unidades_negocio a 
                LEFT JOIN sucursales b ON a.id=b.id_unidad_negocio
                WHERE b.nomina=1 AND a.inactivo=0 AND b.activo=1
                GROUP BY a.id ORDER BY a.id";*/

    //-->NJES December/08/2020 validar si la unidad selecconada es CORPORATIVO mostrar todas las unidades para prorratear pero no la 16 (corporativo),
    //sino solo la unidad seleccionada
    if($id_unidad == 16)
    {
        $query = "SELECT id,nombre,CONCAT(id,'-',nombre) AS unidad_negocio
                FROM cat_unidades_negocio
                WHERE inactivo=0 AND id != 16";
    }else{
        $query = "SELECT id,nombre,CONCAT(id,'-',nombre) AS unidad_negocio
                FROM cat_unidades_negocio
                WHERE id=$id_unidad AND inactivo=0";
    }

    $consulta = mysqli_query($link, $query) or die(mysqli_error());
    $num=mysqli_num_rows($consulta);
    $unidad='';
    for ($i=1; $i <=$num ; $i++) {
        $row = mysqli_fetch_array($consulta);
    
        $unidad.='<td style="background-color:#99cc00;" align="center">'.strtoupper($row['unidad_negocio']).'</td>';
    }

    $num_colspan=$num+7;

    $html.='<table width="100%" style="color:#fff; font-weight:bold;">';
        $html.='<tr>';
            $html.='<td colspan="'.$num_colspan.'" style="background-color:#669900;" align="center">PRESUPUESTO DE EGRESOS</td>';        
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td style="background-color:#99cc00;" align="center">CLAVE UNIDAD</td>';
            $html.='<td style="background-color:#99cc00;" align="center">CLAVE SUCURSAL</td>';
            //$html.='<td style="background-color:#99cc00;" align="center">CLAVE AREA</td>';    
            //$html.='<td style="background-color:#99cc00;" align="center">DEPARTAMENTO INTERNO</td>';  
            $html.='<td style="background-color:#99cc00;" align="center">FAMILIA</td>';  
            $html.='<td style="background-color:#99cc00;" align="center">CLASIFICACION</td>';      
            $html.='<td style="background-color:#99cc00;" align="center">IMPORTE</td>';
            $html.=$unidad;
        $html.='</tr>';
    $html.='</table>';    

    echo $html;
?>