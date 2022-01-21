<?php


	session_start();
	include '../php/conectar.php';
	include ("php/php_tools.php");
	$link = Conectarse();
	
	$usuario = $_SESSION['usuario'];
	
	//obtener permisos de edicion o consulta
	$query = "SELECT id_sucursal,deptos,nivel_web FROM accesos WHERE usuario = '$usuario'";
	$resultado = mysqli_query($link,$query);

	$query2 = "SELECT rs.id_cliente id, rs.rfc, rs.nombre_corto, rs.telefono, IF(rs.activo = 1, 'Activo', 'Inactivo') activo, rs.r_legal, GROUP_CONCAT(su.descr) sucursales
				FROM razones_sociales rs
				INNER JOIN razones_sociales_unidades rsu ON rsu.id_razon_social = rs.id
				INNER JOIN sucursales su ON su.id_sucursal = rsu.id_sucursal
				GROUP BY rs.id";
	$clientes = mysqli_query($link,$query2);

	$cont = 0;
	while ($registro = mysqli_fetch_array($resultado)) {
		$accesos[$cont][0] = $registro['id_sucursal'];
		$accesos[$cont][1] = $registro['deptos'];
		$accesos[$cont][2] = $registro['nivel_web'];
		$cont++;
	}


	//----------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Pragma" content="no-cache">
		<title>Documento sin título</title>
	</head>

	<style>
		body{
			padding: 4rem;
		}
	</style>

	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/general.js"></script>
	<link rel="stylesheet" href="css/general.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/css/all.min.css" integrity="sha512-ioRJH7yXnyX+7fXTQEKPULWkMn3CqMcapK0NNtCN8q//sW7ZeVFcbMJ9RvX99TwDg6P8rAH2IqUSt2TLab4Xmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
	<body>
		
		<div class="content">
			<div class="row">
				<div class="col-md-4 mx-auto">
					<div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_clientes" id="i_filtro_clientes" class="form-control filtrar_renglones" alt="renglon_clientes" placeholder="Filtrar" autocomplete="off"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<table class="table table-hover table-bordered">
						<thead class="table-dark">
							<tr>
								<th>Nombre</th>
								<th>RFC</th>
								<th>Representante</th>
								<th>Telefono</th>
								<th>Estatus</th>
								<th>Sucursales</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php

							while ($registro = mysqli_fetch_array($clientes)) {
								$id = $registro["id"];
								$rfc = $registro["rfc"];
								$nombre_corto = $registro["nombre_corto"];
								$telefono = $registro["telefono"];
								$activo = $registro["activo"];
								$r_legal = $registro["r_legal"];
								$sucursales = $registro["sucursales"];

								echo "<tr class='renglon_clientes'>
										<td>$nombre_corto</td>
										<td>$rfc</td>
										<td>$r_legal</td>
										<td>$telefono</td>
										<td>$activo</td>
										<td>$sucursales</td>
										<td><a class='btn btn-success' href='fr_clientes_detalle.php?id=$id'><i class='fas fa-arrow-right'></i></a></td>
									</tr>";
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<script>
			$(document).on('keyup','.filtrar_renglones',function(){

				var campo = $(this).attr('id');// obtene el id del filtro que se esta usuando
				var renglon = $(this).attr('alt');// obtine el nombre de la clase de el renglon de modal que se esta usando
				var aux = $("#"+campo).val();

				if(aux == '')
				{
					$('.'+renglon).show();
				}
				else
				{
					$('.'+renglon).hide();
					$('.'+renglon+':contains(' + aux + ')').show();
					aux = aux.toLowerCase();
					$('.'+renglon+':contains(' + aux + ')').show();
					aux = aux.toUpperCase();
					$('.'+renglon+':contains(' + aux + ')').show();
				}
			});
		</script>
	</body>

</html>