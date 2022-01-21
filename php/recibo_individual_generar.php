<?php
session_start();
include('../models/Recibos.php');

$datos = $_REQUEST['datos'];

// print_r($datos);
// exit();

$idServicio = $datos['idServicio'];
$idSucursal = $datos['idSucursal'];
$idUnidadNegocio = $datos['idUnidadNegocio'];
$fechaUltimoRecibo = $datos['fechaUltimoRecibo'];
$fechaExtraordinaria = $datos['fechaExtraordinaria'];
$reciboExtraordinario = $datos['reciboExtraordinario'];
$usuario = $datos['usuario'];
$idUsuario = $datos['idUsuario'];
//-->NJES March/18/2020 agregar precio y descripcion de plan a recibo individual cuando es fecha extraordinaria
$precio = isset($datos['precio']) ? $datos['precio'] : 0;
$descripcion = isset($datos['descripcion']) ? $datos['descripcion'] : '';

$modelRecibos = new Recibos();

if (isset($_SESSION['usuario']))
{

    $warning = '<ul>';
    $numD = 0;
    $idCxC = 0;

    $result = $modelRecibos->obtenerPlanesFormatoIdServicio($idServicio);
    
    if(count($result) > 0)
    {

        // print_r($result);
        // exit();
        foreach($result as $resultado)
        {
        
            // print_r($resultado);
            // exit();
            $numD = 1;
            
            if($reciboExtraordinario == 1)
            {
                if($modelRecibos->verificaExisteCxC($resultado['id'], $fechaExtraordinaria) == 0 && $fechaExtraordinaria != "")
                {
                    $info = array();
                    $fechaVencimiento = $modelRecibos->fechaVencimiento($resultado['tipo_plan'],$resultado['dia_corte'],$resultado['meses'],$fechaExtraordinaria);
                    $anio = date("Y", strtotime($fechaExtraordinaria));
                    $mes = date("m", strtotime($fechaExtraordinaria));

                    $info = array('idPlan'=>$resultado['id'],
                                'fechaRecibo'=>$fechaExtraordinaria,
                                'idUnidadNegocio'=>$idUnidadNegocio,
                                'idSucursal'=>$idSucursal,
                                'factura'=>$resultado['factura'],
                                'idServicio'=>$idServicio,
                                'usuario'=>$usuario,
                                'idUsuario'=>$idUsuario,
                                'monto'=>$precio,
                                'fechaVencimiento'=>$fechaVencimiento,
                                'anio'=>$anio,
                                'mes'=>$mes,
                                'meses'=>$resultado['meses'],
                                'banderaExtraordinaria'=>1,
                                'descripcionExtra'=>$descripcion);

                    $idCxC = $modelRecibos->generaCxC($info);

                    if($idCxC == 0)
                    {
                        $numD = 0; 
                        $warning .= '<li> El recibo del plan '.$resultado['id'].' con fecha '.$fechaExtraordinaria.' no genero CxC.</li>';
                    }else
                        $resultado['fecha_recibo'] = $fechaExtraordinaria;
                }else{
                    $resultado['fecha_recibo'] = $fechaExtraordinaria;
                }

                //-->NJES March/18/2020 agregar precio y descripcion de plan a recibo individual cuando es fecha extraordinaria
                $resultado['recibo_extraordinario'] = 1;
                $resultado['precio_extraordinario'] = $precio;
                $resultado['descripcion_extra'] = $descripcion;

            }else{
                if($fechaUltimoRecibo != '' && $fechaUltimoRecibo != "0000-00-00")
                    $fecha_recibo = $modelRecibos->fechaVencimiento($resultado['tipo_plan'],$resultado['dia_corte'],$resultado['meses'],$fechaUltimoRecibo);
                else
                    $fecha_recibo = $modelRecibos->fechaReciboIndividual($resultado['tipo_plan'],$resultado['dia_corte'],$resultado['meses'],$resultado['fecha_captura']);

                if($modelRecibos->verificaExisteCxC($resultado['id'], $fecha_recibo) == 0 && $fecha_recibo != "")
                {
                    $info = array();
                    $fechaVencimiento = $modelRecibos->fechaVencimiento($resultado['tipo_plan'],$resultado['dia_corte'],$resultado['meses'],$fecha_recibo);
                    $anio = date("Y", strtotime($fecha_recibo));
                    $mes = date("m", strtotime($fecha_recibo));

                    $info = array('idPlan'=>$resultado['id'],
                                'fechaRecibo'=>$fecha_recibo,
                                'idUnidadNegocio'=>$idUnidadNegocio,
                                'idSucursal'=>$idSucursal,
                                'factura'=>$resultado['factura'],
                                'idServicio'=>$idServicio,
                                'usuario'=>$usuario,
                                'idUsuario'=>$idUsuario,
                                'monto'=>$resultado['cantidad'],
                                'fechaVencimiento'=>$fechaVencimiento,
                                'anio'=>$anio,
                                'mes'=>$mes,
                                'meses'=>$resultado['meses'],
                                'banderaExtraordinaria'=>0,
                                'descripcionExtra'=>'');

                    // print_r($info);
                    // exit();

                    $idCxC = $modelRecibos->generaCxC($info);

                    if($idCxC == 0)
                    {
                        $numD = 0; 
                        $warning .= '<li> El recibo del plan '.$resultado['id'].' con fecha '.$fecha_recibo.' no genero CxC.</li>';
                    }else
                        $resultado['fecha_recibo'] = $fecha_recibo;
                    
                }else{
                    $resultado['fecha_recibo'] = $fecha_recibo;
                }

                $resultado['recibo_extraordinario'] = 0;
            }
        }
    }else{
        $numD = 0; 
        $warning .= '<li> No existen datos para generar recibos.</li>';
    }

    $warning .= '</ul>';

    echo json_encode(array('num'=>$numD,'datos'=>$resultado,'idCxC'=>$idCxC,'warning'=>$warning));

}
else
    echo json_encode("sesion");
 	
?>