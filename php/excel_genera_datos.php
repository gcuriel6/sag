<?php

session_start();
    
    $nombre=$_REQUEST['i_nombre_excel'];
    $modulo=$_REQUEST['i_modulo_excel'];
    $fecha=$_REQUEST['i_fecha_excel'];
    $registros = json_decode($_REQUEST['i_datos_excel'],true);
    $datos=json_decode($registros, true);

    header("Content-type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: filename=" .$nombre. "_" .$fecha. ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo '<meta charset="UTF-8"/>';  

    if (isset($_SESSION['usuario'])){

        $html='';

        $html.="<h4>&nbsp;&nbsp;&nbsp;&nbsp;".$nombre." ".$fecha."</h4>";
        $html.="<table border='1'><thead><tr>";

        if($modulo == 'REPORTES_DE_PERMISOS')
        {
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>USUARIO</td>";
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>NO. EMPLEADO</td>";
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>NOMBRE</td>";
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>ESTATUS</td>";
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>UNIDAD DE NEGOCIO</td>";
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>SUCURSAL</td>";
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>MENÚ</td>";
            $html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>PERMISO RESTRICCIÓN</td>";
            //$html.="<td style='background-color:#002699;color:#ffffff;font-weight:bold;'>TIPO</td>";
        }

        $html.="</tr></thead><tbody>";
        
        foreach ($datos as $dt)
        {
            $html.="<tr>";
            $html.="<td>".$dt['usuario']."</td>";
            $html.="<td>".$dt['cve_nom']."</td>";
            $html.="<td>".$dt['nombre']."</td>";
            $html.="<td>".$dt['estatus']."</td>";
            $html.="<td>".$dt['unidad_negocio']."</td>";
            $html.="<td>".$dt['sucursal']."</td>";
            $html.="<td>".$dt['padre']."</td>";
            $html.="<td>".$dt['hijo']."</td>";
            //$html.="<td>".$dt['descripcion']."</td>"; //para si se agrega opcion alguna descipcion o el tipo de opcion, ej.: Boton Solicitar Viatico
            $html.="</tr>";
        }

        $html.="</tbody></table>";

        echo $html;
    }else{
        echo json_encode("sesion");
    }

 	
?>