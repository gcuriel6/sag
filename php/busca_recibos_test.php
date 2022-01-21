<?php

session_start();
include('../models/Recibos.php');

//if($k == 0 || $k == 585) // 585

$idSucursal = 57;
$idUnidadNegocio = 2;
$fechaInicio = '2021-06-01';
$fechaFin = '2021-06-30';
$usuario = 'dev';
$idUsuario = 315;

/*
    23 -> SECORP SUCURSAL ALARMAS
    43 -> ALARMAS DELICIAS
    57 -> SUCURSAL ALARMAS SEYCOM
*/

$modelRecibos = new Recibos();
$resultado = $modelRecibos->obtenerPlanesFormato($idSucursal);
    
$planes = array();
foreach($resultado as $r)
{

	if($r['id'] == 2019 )
	{

		echo ' Fecha Captura: ' . $r['fecha_captura'] . ' Meses: ' .$r['meses'] . ' Tipo Plan: ' . $r['tipo_plan'] . ' Dia Corte: ' . $r['dia_corte'] . ' Fecha Inicio: ' . $fechaInicio . ' Fecha Fin: ' . $fechaFin ;

		//$r['fecha_recibo'] =  $modelRecibos->buscarFechaII($r['fecha_captura'],$r['meses'],$r['tipo_plan'], $r['dia_corte'], $fechaInicio, $fechaFin);

		echo '<br><br>';

		$fecha_captura = $r['fecha_captura'];
		$dia = $r['dia_corte'];
		$meses = $r['meses'];

		$anio = date("Y", strtotime($fecha_captura));
        $mes = date("m", strtotime($fecha_captura));

        $verificaFF = explode("-", $dia);

		if(count($verificaFF)  == 1)
        {


                if($dia < 10)
                    $diaN = '0'.$dia;
                else
                    $diaN = $dia;


                if($mes < 10)
                    $diaF = $anio . '-' . $mes . '-' . $diaN;
                else
                    $diaF = $anio . '-' . $mes . '-' . $diaN;


                echo 'D ' . $diaF  . '<br><br>';

                if($dia > 28)
                {

                	$dA = date("d", strtotime($diaF));
                    $dS = date("d",strtotime($diaF."+ ".$meses." month"));

                    echo $dA . ' - ' . $dS . '<br><br>';

                    if($dA != $dS)
                        $diaF = date("Y-m-d",strtotime($diaF." -".$dS." Day"));//$diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month -".$dS." Day"));
                    else
                        $diaF = date("Y-m-d",strtotime($diaF));//$diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));

                }
                else
                    $diaF = date("Y-m-d",strtotime($diaF));//$diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));

                /*echo $dia . ' ** ' . $diaF .'<br><br>';
                echo $diaF . ' ** ' . $fechaFin .'<br><br>';
                echo $diaF . ' ** ' . $fechaInicio . '<br>**<br>';*/

                /*if($diaF>=$fechaInicio)
                    array_push($arrFechas, $diaF);
                
                
                if($dia > 28)
                {
                    //-- por si el mes llega a caer en febrero se le restan los dias del siguiente mes 
                    //-- para que si ponga la fecha de febrero con el ultimo dia de ese mes y no se lo pase
                    $diaA = date("d", strtotime($diaF));
                    $diaS = date("d",strtotime($diaF."+ ".$meses." month"));

                    echo 'A -> ' . $diaA . ' * ' . $diaS . ' <br> ';
                    if($dia == $diaA)
                    {
                    	echo 'B -> ' . $diaF . ' ** ' . $meses . ' <br> ';
                        if($diaA != $diaS)
                            $diaF = 'A';//date("Y-m-d",strtotime($diaF."+ ".$meses." month -".$diaS." Day"));
                        else
                            $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));
                    }else
                    {
                    	echo 'C ->  <br> ';
                        $a = date("Y", strtotime($diaF."+ ".$meses." month"));
                        $m = date("m", strtotime($diaF."+ ".$meses." month"));

                        $diaF = $a . '-' . $m . '-' . $dia;
                    }
                    
                }
                else
                    $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));

                echo 'final ' . $diaF;*/
                echo 'Iniciando ... ' . $diaF;
                $arrFechas=array();
                while($diaF <= $fechaFin)
                {


                	echo $diaF . ' ** ' . $fechaInicio . '<br>';
                    if($diaF>=$fechaInicio)
                        array_push($arrFechas, $diaF);
                    
                    
                    if($dia > 28)
                    {
                        //-- por si el mes llega a caer en febrero se le restan los dias del siguiente mes 
                        //-- para que si ponga la fecha de febrero con el ultimo dia de ese mes y no se lo pase
                        $diaA = date("d", strtotime($diaF));
                        $diaS = date("d",strtotime($diaF."+ ".$meses." month"));

                        if($dia == $diaA)
                        {
                            if($diaA != $diaS)
                                $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month -".$diaS." Day"));
                            else
                                $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));
                        }else{

                            $a = date("Y", strtotime($diaF."+ ".$meses." month"));
                            $m = date("m", strtotime($diaF."+ ".$meses." month"));

                            echo $a . ' * ' . $m;

                            $diaF = $a . '-' . $m . '-' . $dia;

                            echo '<br><br>';
                        }
                        
                    }
                    else
                        $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));
                    
                }

                var_dump($arrFechas);



        }

		//var_dump($f['fecha_recibo']);
	
	}

	//echo $r['id'] . ' - ' . $r['cuenta'] . ' - ' . $r['nombre_corto'] .  ' Fecha Captura: ' . $r['fecha_captura'] . ' Meses: ' .$r['meses'] . ' Tipo Plan: ' . $r['tipo_plan'] . ' Dia Corte: ' . $r['dia_corte'] . ' Fecha Inicio: ' . $fechaInicio . ' Fecha Fin: ' . $fechaFin . '<br><br>';

    
	
}

	
?>