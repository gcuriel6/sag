<?php

	$id = $_GET["id"];

	session_start();
	include '../php/conectar.php';
	include ("php/php_tools.php");
	$link = Conectarse();

	$query1 = "SELECT *
				FROM documentos_clientes
				WHERE id_cliente = $id;";

	$documentos = mysqli_query($link,$query1);

	$query2 = "SELECT rs.*,
					mu1.municipio as mun1,
					es1.estado as es1,
					pa1.pais as pa1,
					mu2.municipio as mun2,
					es2.estado as es2,
					pa2.pais as pa2,
					GROUP_CONCAT(su.descr) sucursales
				FROM razones_sociales rs
				INNER JOIN razones_sociales_unidades rsu ON rsu.id_razon_social = rs.id
				INNER JOIN sucursales su ON su.id_sucursal = rsu.id_sucursal
				LEFT JOIN municipios mu1 ON mu1.id = rs.id_municipio
				LEFT JOIN estados es1 ON es1.id = rs.id_estado
				LEFT JOIN paises pa1 ON pa1.id = rs.id_pais
				LEFT JOIN municipios mu2 ON mu2.id = rs.id_municipio_servicio
				LEFT JOIN estados es2 ON es2.id = rs.id_estado_servicio
				LEFT JOIN paises pa2 ON pa2.id = rs.id_pais_servicio
				WHERE rs.id_cliente = $id
				GROUP BY rs.id";

	$clientes = mysqli_query($link,$query2);

	$query3 = "SELECT cc.id_contrato, cc.id_razon_social, cc.id_depto, cp.puesto, pr.id_sucursal, pr.oficiales, pr.sueldo_quincena, pr.bono_quincena, pr.tiempos_extras, pr.observaciones, su.descr sucursal, de.des_dep depto
				FROM contratos_cliente cc
				INNER JOIN presupuesto pr ON pr.id_depto = cc.id_depto 
				INNER JOIN cat_puestos cp ON cp.id_puesto = pr.id_puesto
				INNER JOIN sucursales su ON su.id_sucursal = pr.id_sucursal
				INNER JOIN deptos de ON de.id_depto = pr.id_depto
				WHERE cc.id_cliente = $id
				ORDER BY cc.id_contrato, pr.id_sucursal, pr.id_depto";

	$contrat = mysqli_query($link,$query3);

	$registro = mysqli_fetch_array($clientes);
	$archivos = mysqli_fetch_array($documentos);

	function cardDocumento($campo){

		$boton = "";
		global $archivos;

		if(isset($archivos[$campo])){
			$ruta = $archivos[$campo];
			$boton = "<a href='clientes/docs/$ruta' class='btn btn-success' target='_blank'>Ver Doc</a>";
		}else{
			$boton = "<button class='btn btn-warning btnSubirDoc' alt='$campo'>Subir Doc</button>";
		}

		echo "<div class='col-md-2'>
				<div class='card'>
					<div class='card-header'>
						$campo
					</div>
					<div class='card-body'>
						$boton
					</div>
				</div>
			</div>";
	}

	function generarContratoSucursal($arreglo){

		$sucursal = $arreglo[0]["sucursal"];
		$contrato = $arreglo[0]["id_contrato"];
		$depto = $arreglo[0]["depto"];
		$total = 0;

		$string = "<div class='col-12'>
			<div>
				<h4>Sucursal: $sucursal</h4>
				<h4>Contrato: $contrato</h4>
				<h4>Departamento: $depto</h4>
			</div>
			<table class='table table-hover table-bordered'>
				<thead class='table-dark'>
					<tr>
						<th>Puesto</th>
						<th>Oficiales</th>
						<th>SueldoQuincena</th>
						<th>BonoQuincena</th>
						<th>TiemposExtras</th>
						<th>Observaciones</th>
					</tr>
				</thead>
				<tbody>";

				foreach ($arreglo as $row) {
					$puesto = $row["puesto"];
					$oficiales = $row["oficiales"];
					$sueldo_quincena = $row["sueldo_quincena"];
					$bono_quincena = $row["bono_quincena"];
					$tiempos_extras = $row["tiempos_extras"];
					$observaciones = $row["observaciones"];

					$sueldoMensual = $sueldo_quincena * 2;
					$bonoMensual = $bono_quincena * 2;

					$total += ($oficiales * ($sueldoMensual + $bonoMensual + $tiempos_extras));

					$string .= "<tr>
									<th>$puesto</th>
									<th>$oficiales</th>
									<th>$sueldo_quincena</th>
									<th>$bono_quincena</th>
									<th>$tiempos_extras</th>
									<th>$observaciones</th>
								</tr>";
				}

		$string .= "</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>Total:</th>
							<th>$total</th>
						</tr>
					</tfoot>
				</table>
			</div>";

			echo $string;

	}

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

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/general.js"></script>
<link rel="stylesheet" href="css/general.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/css/all.min.css" integrity="sha512-ioRJH7yXnyX+7fXTQEKPULWkMn3CqMcapK0NNtCN8q//sW7ZeVFcbMJ9RvX99TwDg6P8rAH2IqUSt2TLab4Xmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
	body{
		padding: 4rem;
	}

	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		color: #fff;
		background-color: #198754;
		border-color: #dee2e6 #dee2e6 #fff;
	}
</style>

<body>
	
	<div class="content">

		<div class="row">
			<div class="col-12 text-center">
				<a href="fr_resumen_clientes.php" class="btn btn-warning">Regresar</a>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Información</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Documentos</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">Contratos</button>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="row mb-3">
							<div class="col-12">
								<div class="card">
									<div class="card-header bg-success text-white">
										Información
									</div>
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-md-6">
												<div class="form-group">
													<label>Nombre Corto</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["nombre_corto"]; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Correo</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["correo_facturas"]; ?>">
												</div>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-md-6">
												<div class="form-group">
													<label>RFC</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["rfc"]; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Telefono</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["telefono_r_legal"]; ?>">
												</div>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-md-6">
												<div class="form-group">
													<label>Razon Social</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["razon_social"]; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Representante</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["r_legal"]; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-12">
								<div class="card">
									<div class="card-header bg-success text-white">
										Domicilio Fiscal
									</div>
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-md-6">
												<div class="form-group">
													<label>Domicilio</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["domicilio"]; ?>">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Codigo Postal</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["codigo_postal"]; ?>">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>No. Exterior</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["no_exterior"]; ?>">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>No. Interior</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["no_interior"]; ?>">
												</div>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-md-3">
												<div class="form-group">
													<label>Municipio</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["mun1"]; ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Estado</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["es1"]; ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Pais</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["pa1"]; ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Colonia</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["colonia"]; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-12">
								<div class="card">
									<div class="card-header bg-success text-white">
										Domicilio de Servicio
									</div>
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-md-6">
												<div class="form-group">
													<label>Domicilio</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["domicilio_servicio"]; ?>">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Codigo Postal</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["codigo_postal_servicio"]; ?>">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>No. Exterior</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["no_exterior_servicio"]; ?>">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>No. Interior</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["no_interior_servicio"]; ?>">
												</div>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-md-3">
												<div class="form-group">
													<label>Municipio</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["mun2"]; ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Estado</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["es2"]; ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Pais</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["pa2"]; ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Colonia</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["colonia_servicio"]; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-12">
								<div class="card">
									<div class="card-header bg-success text-white">
										Contacto Administrativo
									</div>
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-md-4">
												<div class="form-group">
													<label>Contacto</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["contacto"]; ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Telefono</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["telefono"]; ?>">
												</div>
											</div>
											<div class="col-md-1">
												<div class="form-group">
													<label>Extension</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["ext"]; ?>">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Correo</label>
													<input type="text" class="form-control" readonly value="<?php echo $registro["email"]; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-12">
								<div class="card">
									<div class="card-header bg-success text-white">
										Contacto Operativo
									</div>
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-md-4">
												<div class="form-group">
													<label>Contacto</label>
													<input type="text" class="form-control" readonly  value="<?php echo $registro["contacto_operativo"]; ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Telefono</label>
													<input type="text" class="form-control" readonly  value="<?php echo $registro["telefono_operativo"]; ?>">
												</div>
											</div>
											<div class="col-md-1">
												<div class="form-group">
													<label>Extension</label>
													<input type="text" class="form-control" readonly  value="<?php echo $registro["ext_operativo"]; ?>">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Correo</label>
													<input type="text" class="form-control" readonly  value="<?php echo $registro["correo_operativo"]; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<div class="row mb-3">
							<div class="col-12">
								<div class="card">
									<div class="card-header bg-success text-white">
										Documentos
									</div>
									<div class="card-body">
										<div class="row">
											<?php
												cardDocumento("constancia_situacion");
												cardDocumento("acta_constitutiva");
												cardDocumento("registro_patronal");										
												cardDocumento("ife_r_legal");
												cardDocumento("poder_r_legal");
												cardDocumento("comprobante_domicilio");										
												cardDocumento("acta_nacimiento");
												cardDocumento("curp");
												cardDocumento("contrato");
												cardDocumento("equipo");
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
						<div class="row">
							<?php
								$anterior = 0;
								$mientras = [];

								if (mysqli_num_rows($contrat) > 0) {
									// output data of each row
									while($row = mysqli_fetch_assoc($contrat)) {
										if($row["id_contrato"] == $anterior){

											$mientras[] = $row;

										}else{

											if(count($mientras) > 0){
												generarContratoSucursal($mientras);
											}

											$mientras = [];

											$mientras[] = $row;
										}

										$anterior = $row["id_contrato"];
									}

									if(count($mientras) > 0){
										generarContratoSucursal($mientras);
									}

								}else{
									echo '<div class="col-12"><h2>No hay contratos</h2></div>';
								}
							?>
						</div>
					</div>
				</div>	
			</div>
		</div>	

	</div>

	<div class="modal" tabindex="-1" role="dialog" id="modalSubirDocumento">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Subir documento para: <span id="nombreCampo"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
				<div class="form-group col-12">
					<label>Archivo</label>
					<input type="file" class="form-control" id="archivoSubirDocumento"></input>
				</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="btnGuardarArchivo">Guardar</button>
			</div>
			</div>
		</div>
	</div>

</body>

<script>

	const idCliente = <?php echo $id; ?>;

	$(".btnSubirDoc").on("click",function(){
		let campo = $(this).attr("alt");

		$("#nombreCampo").html(campo);

		$("#modalSubirDocumento").modal("toggle");
	});

	$("#btnGuardarArchivo").on("click", function(){
		let campo = $("#nombreCampo").html();
		let archivo = $("#archivoSubirDocumento").val();

		console.log("cliente: ", idCliente);
		console.log("campo: ", campo);
		console.log("archivo: ", archivo);

		if(archivo != ""){
			$("#archivoSubirDocumento").removeClass("is-invalid");
			guardarArchivo(idCliente, campo, archivo);
		}else{
			$("#archivoSubirDocumento").addClass("is-invalid");
		}
	});

	function guardarArchivo(idCliente, campo, archivo){
		//Damos el valor del input tipo_mov file
		var archivos = document.getElementById("archivoSubirDocumento");

		//Obtenemos el valor del input (los archivos) en modo de arreglo
		var i_archivo = archivos.files; 

		var datos = new FormData();

		datos.append('idCliente',idCliente);
		datos.append('campo',campo);
		datos.append('archivo',i_archivo[0]);

		$.ajax({
			type: 'POST',
			url: 'php/archivos_guardar.php',  
			cache: false,
			contentType: false,
			processData: false,
			data: datos,
			//una vez finalizado correctamente
			success: function(data) 
			{   
				if(data > 0)
				{
					alert('Se subio correctamente el archivo.');
					window.location.href = "fr_clientes_detalle.php?id="+idCliente;
				}else{
					$('#b_crear_archivo').prop('disabled',false);
				} 
			},
			error: function (xhr) {
				console.log("php/archivos_guardar.php--> "+JSON.stringify(xhr)); 
				$('#b_crear_archivo').prop('disabled',false);
			}
		});
	}
</script>

</html>