<?php

//session_start();
include("../models/PresupuestoEgresos.php");
require_once '../widgets/excel_reader2.php';
//$link = Conectarse();

$presupuestoEgresos = new PresupuestoEgresos();
$data = new Spreadsheet_Excel_Reader("../excel/presupuesto_egresos.xls");

$anio = $_REQUEST['anio'];
$mes = $_REQUEST['mes'];
$tipo = $_REQUEST['tipo'];
		
$verifica = false;
$warning = '<ul>';
$datosValidos = array();
$datosRelacion = array();


$test = "** ";

	$y = $data->sheets[0];
	$numRow = $y['numRows'];
	$numCol = $y['numCols'];

	$contSI=0;
	$contSuc=0;

	$contFC=0;
	$contFCD=0;
	$contFCD2=0;
	$contFCX=0;

	for($i=3; $i <= $numRow; $i++)
	{

		$col = 0;
		
		$unidadS = $data->sheets[0]['cells'][$i][1];
		$sucursalS = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][2]);
		$area = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][3]);
		$depto = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][4]);
		$familia = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][5]);
		$concepto = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][6]);
        $importe = $data->sheets[0]['cells'][$i][7];
       
		$verificaVacio = false;

		if($area == '')
		{
			$verificaVacio = true;
			$col = 3;
		}

		
		if($depto == '')
		{
			$verificaVacio = true;
			$col = 4;
		}

		if($familia == '')
		{
			$verificaVacio = true;
			$col = 5;
		}
		
		if($importe == '')
		{
			$verificaVacio = true;
			$col = 7;
		}

		if($verificaVacio == true)
		{
			$verifica = true;
			$warning .= '<li>El documento tiene datos vacíos en el renglón '.$i.' en la columna '.$col.'<br>';
		}
		else
		{
			
			$unidadD = 0;

				if(strtoupper($unidadS) != 'GINTHERCORP') 
				{  
                    $contSuc++;
                    
                    $idUnidadNegocio =  $presupuestoEgresos->buscaIdUnidad($unidadS);

//echo  $sucursalS.'-'.$idUnidadNegocio;//buscaIdSucursalClave
					$idSucursal = $presupuestoEgresos->buscaIdSucursalClave($sucursalS,$idUnidadNegocio);

					if($idUnidadNegocio === 0)
					{
						$warning .= '<li>No se encontró ningún registro correspondiente a la clave unidad del renglon ' . $i . '</li>';
						$verificaInfo  = true;
					}
					
					if($idSucursal === 0)
					{
						$warning .= '<li>No se encontró ningún registro correspondiente a la clave sucursal del renglon ' . $i . '</li>';
						$verificaInfo  = true;
					}

				}
                else
                {
                    $idUnidadNegocio =  $presupuestoEgresos->buscaIdUnidad('cor');
					$idSucursal ='NULL';//$presupuestoEgresos->buscaIdSucursalClave($sucursalS,$idUnidadNegocio);
                }
					//$idUnidadNegocio =  $presupuestoEgresos->buscaIdUnidad('COR');*/
				
				$verificaInfo = false;

				
				if($verificaInfo == true)
				{
					$verifica = true;
				}
				else
				{

					if(strtoupper($unidadS) != 'GINTHERCORP')
					{

						$idArea = $presupuestoEgresos->buscarAreas($area);
						$idDepto = $presupuestoEgresos->buscarDeptos($depto, $idSucursal,$idArea);
						$idFamilia = $presupuestoEgresos->buscarFamilias($familia);
						$idConcepto = $concepto == '' ? 'null': $presupuestoEgresos->buscarConceptos($concepto,$idFamilia);

						if($idArea == 0)
						{
							$warning .= '<li>No se encontró ningún registro correspondiente a Áreas con la descripción de la línea ' . $i . '</li>';
							$verificaInfo  = true;
							$verifica = true;
						}

						if($idDepto === 0)
						{
							$warning .= '<li>No se encontró ningún registro correspondiente a Departamento con la descripción de la línea ' . $i . '</li>';
							$verificaInfo  = true;
							$verifica = true;
						}

						if($idFamilia === 0)
						{
							$warning .= '<li>No se encontró ningún registro correspondiente a Familia con la descripción de la línea ' . $i . '</li>';
							$verificaInfo  = true;
							$verifica = true;
						}

						if($idConcepto === 0)
						{
							//$test .= $idConcepto . ' * ';
							$warning .= '<li>No se encontró ningún registro correspondiente a Clasificación con la descripción de la línea ' . $idConcepto . '</li>';
							$verificaInfo  = true;
							$verifica = true;
						}

					}


					if($verificaInfo == false)
					{
						$datosRelacion = array();
						if(strtoupper($unidadS) == 'GINTHERCORP')
						{
							
							$contT=0;
							
							for($k=8; $k <= $numCol; $k++)
							{
							
								$sucursal = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][$k]);
								
								if($sucursal != '')
								{
									$pos = strpos($data->sheets[0]['cells'][2][$k], '-');
									$idUnidadNegocioX = substr($data->sheets[0]['cells'][2][$k],0,$pos);
									
									$unidadX = $data->sheets[0]['cells'][2][$k];

									$sucursales='';
									if($sucursal == 'X' || $sucursal == 'x')
									{
										$sucursales = explode(",",$presupuestoEgresos->buscarSucursalesUnidad($idUnidadNegocioX));
									}else{
										$sucursales = array_map('trim',explode(",",$sucursal));
									}

									$verificaInfo = false;

									foreach($sucursales AS $m)
									{
										$contT++;
										$idS = $m;
										//echo '*'.$idS.'-'.$idUnidadNegocioX.'*';
										$idSucursalX = $presupuestoEgresos->buscaIdSucursal($idS,$idUnidadNegocioX);
									
										if($idSucursalX === 0)
										{
											$warning .= '<li>No se encontró ningún registro correspondiente a la sucursal para unidad de negocio '.$unidadX.' del renglon ' . $i . '</li>';
											$verificaInfo  = true;
											$verifica = true;
										}else{
											$idFamiliaX = $presupuestoEgresos->buscarFamilias($familia);
											$idConceptoX = $concepto == '' ? 'null': $presupuestoEgresos->buscarConceptos($concepto,$idFamiliaX);

											if($idFamiliaX === 0)
											{
												$warning .= '<li>No se encontró ningún registro correspondiente a Familia con la descripción de la línea ' . $i . ' para la unidad '.$unidadX.'</li>';
												$verificaInfo  = true;
												$verifica = true;
											}

											if($idConceptoX === 0)
											{
												$warning .= '<li>No se encontró ningún registro correspondiente a Clasificación con la descripción de la línea ' . $i . ' para la unidad '.$unidadX.'</li>';
												$verificaInfo  = true;
												$verifica = true;
											}

											if($verificaInfo == false)
											{
												array_push($datosRelacion, [
													'id_unidad_negocio'=>$idUnidadNegocioX,
													'id_sucursal'=>$idSucursalX,
													'id_familia'=>$idFamiliaX,
													'id_concepto'=>$idConceptoX,
													'importe'=>$importe
												]);

											}

										}
									}
								}
							}
								
							if($contT < 2)
								$unidadD++;
						}

						array_push($datosValidos, [
							'claveUnidad'=>$unidadS,
							'id_unidad_s'=>$idUnidadNegocio, //id unidad registro prespuesto egresos
							'id_sucursal_s'=>$idSucursal,  //id sucursal presupuesto egresos
							'id_area'=>$idArea,
							'id_depto'=>$idDepto,
							'id_familia'=>$idFamilia,
							'id_concepto'=>$idConcepto,
							'importe'=>$importe,
							'claveUnidad'=>$unidadS,
							'datosRelacion'=>$datosRelacion
						]);
					}

					if(strtoupper($unidadS) != 'GINTHERCORP') 
					{
						foreach($datosValidos as $z)
						{
							if($z['claveUnidad'] != 'GINTHERCORP')
							{
								if($idSucursal == $z['id_sucursal_s'])
								{
									$contSI++;
								}
							}
						}
					}

					/*if($contSI > $contSuc)
					{
						$warning .= '<li>No se pueden guardar registros con sucursales iguales para el renglon '.$i.'</li>';
						$verificaInfo  = true;
						$verifica = true;
					}*/

				}
			
			if($unidadD > 0)
			{
				$warning .= '<li> Debe existir minimo dos unidades de negocio con sucursal asignada para prorrateo Ginthercorp en el renglon '.$i.'</li>';
				$verifica = true;
			}
		}	

	}

$warning .= '</ul>';

//$verifica =  $presupuestoEgresos->guardarPresupuesto($anio, $mes, $tipo, $datosValidos);

if($verifica == false)
{
	
    //$verifica =  $presupuestoEgresos->guardarPresupuesto($anio, $mes, $tipo, $datosValidos);
    
    //var_dump($datosValidos);
    $uantos = 1;
    foreach($datosValidos as $dV)
          {
            $idPresupuesto = 0;
  
            $claveUnidad = $dV['claveUnidad'];
  
            $idUnidadS = $dV['id_unidad_s'];
            $idSucursalS = $dV['id_sucursal_s'];
            
            $idUnidad = isset($dV['id_unidad_negocio']) ? $dV['id_unidad_negocio'] : '';
            $idSucursal = isset($dV['id_sucursal']) ? $dV['id_sucursal'] : '';
            $idArea = $dV['id_area'];
            $idDepto = $dV['id_depto'];
            $idFamilia = $dV['id_familia'];
            $idConcepto = $dV['id_concepto'];
            $importe = $dV['importe'];
  
            $datosRelacion = $dV['datosRelacion'];
  
            
            $unidad = $idUnidadS;
            $sucursal = $idSucursalS;

            
            $queryT = "INSERT INTO presupuesto_egresos (id_unidad_negocio, id_sucursal, id_area, id_depto, id_familia_gasto, id_clasificacion, anio, mes, monto) 
                VALUES ($unidad, $sucursal, $idArea, $idDepto, $idFamilia, $idConcepto, 2020, 05, $importe)";

  
            
            if(strtoupper($claveUnidad) == 'GINTHERCORP')
            {

                echo $uantos . ' - '. $queryT .'<br>';
                $uantos++;
                echo '<br><br><br><br>';
                //var_dump($datosRelacion);
                foreach ($datosRelacion as $dT) 
                {
                    //
                    var_dump($dT);
                    echo '<br><br>';
                }
                echo '<br><br><br><br>';
                //$totalEmpleados = $this -> totalEmpleados($datosRelacion);
                //$verifica = $this -> guardarProrrateo($datosRelacion,$idPresupuesto,$totalEmpleados,$importe,$anio,$mes);
            
                //if($verifica == true)br?
                //break


            }else
                $verifica = false;
                
           
  
          }


	//if($verifica == true)
		//$warning = '<ul><li>Error al subir el archivo (sucursales duplicadas para prorrateo).</li></ul>';

}

//echo json_encode(array('verifica'=>$verifica, 'warning'=>$warning));

?>