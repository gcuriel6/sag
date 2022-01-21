<?php
session_start();
include('../models/Recibos.php');

$datos = $_REQUEST['datos'];

$idSucursal = $datos['idSucursal'];
$idUnidadNegocio = $datos['idUnidadNegocio'];
$fechaInicio = $datos['fechaInicio'];
$fechaFin = $datos['fechaFin'];
$usuario = $datos['usuario'];
$idUsuario = $datos['idUsuario'];

/*$idSucursal = 23;//$datos['idSucursal'];
$idUnidadNegocio = 2;//$datos['idUnidadNegocio'];
$fechaInicio = '2020-01-01';//$datos['fechaInicio'];
$fechaFin = '2020-01-31';//$datos['fechaFin'];
$usuario = 'ADMIN';//$datos['usuario'];
$idUsuario = 1;*/


$modelRecibos = new Recibos();

if (isset($_SESSION['usuario']))
{

    $warning = '<ul>';
    $valorW = 0;
    $contador=0;
    //$resultado = $modelRecibos->obtenerPlanes($datos);
    $resultado = $modelRecibos->obtenerPlanesFormato($idSucursal);
    
	$planes = array();
    foreach($resultado as $r)
    {
        $r['fecha_recibo'] =  $modelRecibos->buscarFecha($r['fecha_captura'],$r['meses'],$r['tipo_plan'], $r['dia_corte'], $fechaInicio, $fechaFin);
        
        if(count($r['fecha_recibo'])>0)
        {
            $contador = $contador + count($r['fecha_recibo']);
            foreach($r['fecha_recibo'] as $d)
            {
                if($modelRecibos->verificaExisteCxC($r['id'], $d) == 0 && $d != "")
                {
                    $info = array();
                    //-->NJES April/23/2020 la fecha vencimiento debe ser un dia antes de la fecha del siguiente recibo
                    $fechaV = $modelRecibos->fechaVencimiento($r['tipo_plan'],$r['dia_corte'],$r['meses'],$d);
                    $anio = date("Y", strtotime($fechaInicio));
                    $mes = date("m", strtotime($fechaInicio));
                    $fechaVencimiento = date("Y-m-d",strtotime($fechaV."- 1 Day"));

                    $info = array('idPlan'=>$r['id'],
                                'fechaRecibo'=>$d,
                                'idUnidadNegocio'=>$idUnidadNegocio,
                                'idSucursal'=>$idSucursal,
                                'factura'=>$r['factura'],
                                'idServicio'=>$r['id_servicio'],
                                'usuario'=>$usuario,
                                'idUsuario'=>$idUsuario,
                                'monto'=>$r['cantidad'],
                                'fechaVencimiento'=>$fechaVencimiento,
                                'anio'=>$anio,
                                'mes'=>$mes,
                                //-->NJES Feb/18/2020 se envia parametro para la concatenacion de la descripción de la prefactura
                                'meses'=>$r['meses']);

                    $idCxC = $modelRecibos->generaCxC($info);
                
                    if($idCxC == 0)
                    {
                        $warning .= '<li> El recibo del plan '.$r['id'].' con fecha '.$d.' no genero CxC.</li>';
                        $valorW++;
                    }
                }
            }

        
            $r['num']=$contador;
            array_push($planes,$r);  //si esta en el rango de fechas genero el recibo
        }
        
    }

    $warning .= '</ul>';
    
    //echo json_encode($planes);
    if(count($planes)>0)
        $numD = 1;
    else
        $numD = 0; 

    $bloques = array();
    $generaT = $modelRecibos->generaTablaTemporal($planes);
    foreach($generaT AS $tm)
    {
        array_push($bloques,['bloques'=>$tm['bloques'],'totales'=>$tm['totales']]);
    }
    $numRecibosSF = $modelRecibos->buscaCxCsinFactura();
 
    echo json_encode(array('dato'=>$numD, 'bloques'=>$bloques, 'warning'=>$warning, 'valor'=>$valorW,'planes'=>$contador, 'num_recibos_sf'=>$numRecibosSF));
    
}
else
    echo json_encode("sesion");
 	
?>