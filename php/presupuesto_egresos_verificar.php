<?php

session_start();
include("../models/PresupuestoEgresos.php");
require_once '../widgets/excel_reader2.php';
$link = Conectarse();

$presupuestoEgresos = new PresupuestoEgresos();
$data = new Spreadsheet_Excel_Reader("../excel/presupuesto_egresos.xls");

$anio = $_REQUEST['anio'];
$mes = $_REQUEST['mes'];
$tipo = $_REQUEST['tipo'];
$id_unidad_negocio_select = $_REQUEST['id_unidad_negocio'];
$nombre_unidad_select = $_REQUEST['nombre_unidad'];
		
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
		//$area = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][3]);
		//$depto = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][4]);
		$familia = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][3]);
		$concepto = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][4]);
		$importe = $data->sheets[0]['cells'][$i][5];

		$verificaVacio = false;

		/*if($area == '')
		{
			$verificaVacio = true;
			$col = 3;
		}

		
		if($depto == '')
		{
			$verificaVacio = true;
			$col = 4;
		}*/

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

					//-->NJES December/08/2020 compara si la unidad de cada renglon es diferente a la unidad del combo selecionado para cargar el presupúesto
					if($id_unidad_negocio_select != 16 && $idUnidadNegocio !== $id_unidad_negocio_select)
					{
						$warning .= '<li>La unidad del renglon ' . $i . ' no es igual a la unidad seleccionada para cargar el presupuesto</li>';
						$verificaInfo  = true;
					}

					/*//-->NJES December/08/2020 si la unidad seleccionada es ginthercorp no debe dejar ingresar registros con unidad diferente a esa
					if($nombre_unidad_select == 'GINTHERCORP')
					{
						$warning .= '<li>No se encontró ningún registro correspondiente a la clave unidad del renglon ' . $i . '</li>';
						$verificaInfo  = true;
					}*/

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
					$idUnidadNegocio = 16;//$presupuestoEgresos->buscaIdUnidad('COR
					$idSucursal = 0;
					$idFamilia = $presupuestoEgresos->buscarFamilias($familia);
					$idConcepto = $concepto == '' ? 'null': $presupuestoEgresos->buscarConceptos($concepto,$idFamilia);	
				}			
				
				$verificaInfo = false;

				
				if($verificaInfo == true)
				{
					$verifica = true;
				}
				else
				{

					if(strtoupper($unidadS) != 'GINTHERCORP')
					{

						//$idArea = $presupuestoEgresos->buscarAreas($area);
						//$idDepto = $presupuestoEgresos->buscarDeptos($depto, $idSucursal,$idArea);
						$idFamilia = $presupuestoEgresos->buscarFamilias($familia);
						$idConcepto = $concepto == '' ? 'null': $presupuestoEgresos->buscarConceptos($concepto,$idFamilia);

						/*if($idArea == 0)
						{
							$warning .= '<li>No se encontró ningún registro correspondiente a Áreas con la descripción (' . $area . ') de la línea ' . $i . '</li>';
							$verificaInfo  = true;
							$verifica = true;
						}

						if($idDepto === 0)
						{
							$warning .= '<li>No se encontró ningún registro correspondiente a Departamento con la descripción (' . $depto . ') de la línea ' . $i . '</li>';
							$verificaInfo  = true;
							$verifica = true;
						}*/

						if($idFamilia === 0)
						{
							$warning .= '<li>No se encontró ningún registro correspondiente a Familia con la descripción (' . $familia . ') de la línea ' . $i . '</li>';
							$verificaInfo  = true;
							$verifica = true;
						}

						if($idConcepto === 0)
						{
							//$test .= $idConcepto . ' * ';
							$warning .= '<li>No se encontró ningún registro correspondiente a Clasificación con la descripción (' . $concepto . ' ) de la línea ' . $i . '</li>';
							$verificaInfo  = true;
							$verifica = true;
						}

						//-->December/08/2020 aqui talvez validar que por ejemplo enl campo 1-secorp vaya vacio

					}


					if($verificaInfo == false)
					{
						$datosRelacion = array();
						if(strtoupper($unidadS) == 'GINTHERCORP')
						{
							
							$contT=0;
							
							for($k=6; $k <= $numCol; $k++) // antes era 8
							{
							
								$sucursal = $presupuestoEgresos->limpiarCadena($data->sheets[0]['cells'][$i][$k]);
								
								if($sucursal != '')
								{
									$verificaInfo = false;

									$pos = strpos($data->sheets[0]['cells'][2][$k], '-');
									$idUnidadNegocioX = substr($data->sheets[0]['cells'][2][$k],0,$pos);
									$unidadX = $data->sheets[0]['cells'][2][$k];

									//-->NJES December/08/2020 compara que la unidad a prorratear si sea igual a la unidad seleccionada en el combo
									//es decir si mi unidad del combo selecconada no es corporativo, y viene un registro para prorrateo, verificar que la unidad a prorratear
									//si sea la del combo, que en teoria deberia de ser porque la plantilla solo mostrará esa unidad para prorrateo
									//echo $id_unidad_negocio_select .' !=  16  && '. $idUnidadNegocioX .' !== '. $id_unidad_negocio_select;
									if($id_unidad_negocio_select != 16 && $idUnidadNegocioX !== $id_unidad_negocio_select)
									{
										//$warning .= '<li>No se encontró ningún registro correspondiente a la sucursal para unidad de negocio '.$unidadX.' del renglon ' . $i . '</li>';
										$warning .='<li>La unidad a prorratear '.$unidadX.' en el renglon '.$i.' no corresponde a la unidad seleccionada en el combo </li>';
										$verificaInfo  = true;
										$verifica = true;
									}

									$sucursales='';
									if($sucursal == 'X' || $sucursal == 'x')
									{
										$sucursales = explode(",",$presupuestoEgresos->buscarSucursalesUnidad($idUnidadNegocioX));
									}else{
										$sucursales = array_map('trim',explode(",",$sucursal));
									}

									//$verificaInfo = false;

									foreach($sucursales AS $m)
									{
										$contT++;
										$idS = $m;
										//echo '*'.$idS.'-'.$idUnidadNegocioX.'*';
										$idSucursalX = $presupuestoEgresos->buscaIdSucursal($idS,$idUnidadNegocioX);
									
										if($idSucursalX === 0)
										{
											$warning .= '<li>No corresponde la sucursal ID '.$idS.' para unidad de negocio '.$unidadX.' del renglon ' . $i . '</li>';
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

						
						//'id_area'=>$idArea,
						//'id_depto'=>$idDepto,

						array_push($datosValidos, [
							'claveUnidad'=>$unidadS,
							'id_unidad_s'=>$idUnidadNegocio, //id unidad registro prespuesto egresos
							'id_sucursal_s'=>$idSucursal,  //id sucursal presupuesto egresos
							'id_area'=>0,
							'id_depto'=>0,
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


$pos = strpos($warning, 'li');


//if($verifica == false)
if($pos === false)
{

	$verifica =  $presupuestoEgresos->guardarPresupuesto($id_unidad_negocio_select,$anio, $mes, $tipo, $datosValidos);

	//echo json_encode(array('verifica'=>$verifica));
	if($verifica == true)
		$warning .= '<ul><li>Error al subir el archivo (sucursales duplicadas para prorrateo).</li></ul>';
	

}
else
	$verifica = true;

echo json_encode(array('verifica'=>$verifica, 'warning'=>$warning));



?>