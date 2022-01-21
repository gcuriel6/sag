<?php
	session_start();
	$id_supervisor = $_SESSION['id_supervisor'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Captura Incidencias</title>
<link rel="icon" href="imagenes/favicon.ico">
</head>


	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	<link rel="stylesheet" href="css/general.css" />
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/alert.js"></script>


<script>
	var id_registro = 0;
	var id_supervisor=<?php echo $id_supervisor?>;
	var vfecha = 1;
	var remp = 0;
	var registro = 0;
	
	var aux = new Date();
	function addZ(n){return n<10? '0'+n:''+n;}
	var hoy = aux.getFullYear()+'-'+addZ(aux.getMonth()+1)+'-'+addZ(aux.getDate());
	
	$(function() {
		$('.fecha').datepicker({
			format: "yyyy-mm-dd",
		    autoclose: true,
		    changeMonth: true,
	        changeYear: true
		}).on('changeDate', function(ev){
			$(this).datepicker('hide');
			 actualizaPantalla();
		});
		
		$('.fecha').val(hoy);
		
		$.post('php/obtener_options.php',{tipo:'motivos_inc'},function(data){	
			$('#s_incidencia').html(data);
		});
		
		$.post('php/obtener_options.php',{tipo:'tipo_eve'},function(data){	
			$('#s_tipo').html(data);
		});
		
		$.post('php/obtener_options.php',{tipo:'tipo_fac'},function(data){	
			$('#s_cobro').html(data);
		});
		
		$.post('php/obtener_options.php',{tipo:'motivos_rem'},function(data){	
			$('.inc_rem').html(data);
		});
		
		
		
		$.post('php/obtener_options.php',{tipo:'super_incidencias','id_supervisor':id_supervisor},function(data){
			//alert(data);
			$('#s_super').html(data);
		});
	
		$('#s_super').change(function(){
			$.post('php/obtener_options.php',{tipo:'deptos_supervisor','id_supervisor':$(this).val()},function(data2){	
				$('#s_deptos').html(data2);
			});
		});
		
		
		$('#s_deptos').change(function(){
			$('.fecha').val(hoy);
			var fecha = $('#i_fecini').val() ;
			$.post('php/busca_incidencias_depto_dia.php',{'id_depto':$(this).val(),'fecha':fecha},function(data2){
				var datos = JSON.parse(data2);
				var num = datos[0];
				//alert(num);
				$('#t_incidencias tbody').html('');
				for(var i = 1;i<=num;i++){
					var dato = datos[i];
					
					var boton = "<button registro='"+dato.registro+"' class='btn btn-danger b_editar_incidencia'>Editar</button>";
				
					
					var html = "<tr class='renglon_incidencia'><td>"+dato.id_empleado+"</td><td>"+dato.difvacante+"</td><td>"+dato.nombre+"</td><td>"+dato.puesto+"</td><td>"+dato.incidencia+"</td><td>"+dato.incidencia_aux+"</td><td>"+boton+"</td></tr>";
					$('#t_incidencias tbody').append(html);
				}
			});
		});
		
		function actualizaPantalla(){
			var botones = 1;
			var fecha = $('#i_fecini').val() ;

			$.post('php/verifica_fecha_captura_incidencias.php',{'fecha':fecha},function(data){
				
				if(data == 1)
					botones = 1;
				else
					botones = 0;
				
				
				$.post('php/busca_incidencias_depto_dia.php',{'id_depto':$('#s_deptos').val(),'fecha':fecha},function(data2){
					//alert('aqui mero 1');
					var datos = JSON.parse(data2);
					var num = datos[0];
					$('#t_incidencias tbody').html('');
					for(var i = 1;i<=num;i++){
						var dato = datos[i];
						if(botones==1)
							var boton = "<button registro='"+dato.registro+"' class='btn btn-danger b_editar_incidencia'>Editar</button>";
						else
							var boton = "<button registro='"+dato.registro+"' class='btn btn-danger b_consulta_incidencia'>Consulta</button>";
					
						var html = "<tr class='renglon_incidencia'><td>"+dato.id_empleado+"</td><td>"+dato.difvacante+"</td><td>"+dato.nombre+"</td><td>"+dato.puesto+"</td><td>"+dato.incidencia+"</td><td>"+dato.incidencia_aux+"</td><td>"+boton+"</td></tr>";
						$('#t_incidencias tbody').append(html);
					}
				});
			});
			
			
			
		}
			
		
		$('#b_actualizar').click(function(){
			if($('#s_deptos').val()!=null){
				$(".ifiltro").val('');
				actualizaPantalla();
			}
		});
		
		function limpiaIncidencia(){
			$('#ta_justificacion').val('');
			$('#i_fecha').val('');
			$('#i_no_nomina').val('');
			$('#i_nombre_empleado').val('');
			$('#s_incidencia').val('');
			$('#s_tipo').val('');
			$('#s_cobro').val('');
			$('#s_inc_1').val('');
			$('#s_inc_2').val('');
			$('#s_inc_3').val('');
			$('.rem').each(function(){
				$(this).val('');
				$(this).attr('alt');
			});
		}
		
		
		function llenaIncidencia(registro){
			limpiaIncidencia();
			$.post('php/busca_detalle_incidencia.php',{'registro':registro},function(data2){
				var datos = JSON.parse(data2);
				//alert(registro);
				$('#ta_justificacion').val(datos.justificacion);
				$('#i_fecha').val(datos.fecha);
				$('#i_no_nomina').val(datos.id_empleado);
				$('#i_nombre_empleado').val(datos.nombre_empleado);
				$('#s_incidencia').val(datos.incidencia);
				$('#s_tipo').val(datos.tipo);
				$('#s_cobro').val(datos.cobro);
				
				$('#i_reemp1').attr('alt2',datos.reem1);
				$('#i_reemp1').val(datos.nom_reem1)
				$('#s_inc_1').val(datos.incidencia1);
				
				$('#i_reemp2').attr('alt2',datos.reem2);
				$('#i_reemp2').val(datos.nom_reem2)
				$('#s_inc_2').val(datos.incidencia2);
				
				$('#i_reemp3').attr('alt2',datos.reem3);
				$('#i_reemp3').val(datos.nom_reem3)
				$('#s_inc_3').val(datos.incidencia3);
				
				var motivo = $('.o_motivos_inc:selected').attr('alt');
				var aux = $('.o_motivos_inc:selected').attr('alt2');
				var eve_fac = $('.o_motivos_inc:selected').attr('alt3');
				
				if(datos.id_empleado==0){
					$('.tr_reem').show();
				}
				else{
					if(aux==0){
						$('.tr_reem').hide();
					}else{
						$('.tr_reem').show();
					}
					if(eve_fac==0){
						$('.tr_e_f').hide();
					}else{
						$('.tr_e_f').show();
					}
				}
				$('#i_nombre_motivo').val(motivo);
			});
		};
		
		$('#t_incidencias').on('click','.b_editar_incidencia',function(){
			
			$('.tr_reem').hide();
			$('.tr_e_f').hide();
			registro = $(this).attr('registro');
			llenaIncidencia(registro);
			
			$('#b_guardar').show();
			$('#contenido').animate({left:'-105%'},'1000');
			$('#contenido2').animate({left:'15%'},'1000');
		});
		
		$('#t_incidencias').on('click','.b_consulta_incidencia',function(){
			
			registro = $(this).attr('registro') ;
			llenaIncidencia(registro);
			
			$('#b_guardar').hide();
			$('#contenido').animate({left:'-105%'},'1000');
			$('#contenido2').animate({left:'15%'},'1000');
		});
		
		$('#s_incidencia').change(function(){
			var id_empleado = $('#i_no_nomina').val();
			var motivo = $('.o_motivos_inc:selected').attr('alt');
			var aux = $('.o_motivos_inc:selected').attr('alt2');
			var eve_fac = $('.o_motivos_inc:selected').attr('alt3');
			$('#i_nombre_motivo').val(motivo);
			if(id_empleado==0){
				$('.tr_reem').show();
			}
			else{
				if(aux==0){
					$('.tr_reem').hide();
					$('#s_inc_1').val('');
					$('#s_inc_2').val('');
					$('#s_inc_3').val('');
					$('.rem').each(function(){
						$(this).val('');
						$(this).attr('alt2','');
					});
				}else{
					$('.tr_reem').show();
				}
				if(eve_fac==0){
					$('.tr_e_f').hide();
				}else{
					$('.tr_e_f').show();
				}
			}
		});
		
		$.expr[':'].contains = $.expr.createPseudo(function(arg) {
				return function(elem) {
					return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
				};
			});
			
			$('.ifiltro').change(function() {
				var aux = $(this).val();
				
				var tabla = $(this).attr('tabla');
				var tabla = '#' + tabla;
				if (aux == '') {
					$(tabla + '>tbody>tr').show();
				} else {
					$(tabla + '>tbody>tr').hide();			
					$(tabla + '>tbody>tr>td:contains(' + aux + ')').parent().show();		
				}
			});
			
		$('.rem').change(function(){
			remp = $(this).attr('alt');
			llenaModal($(this).val());
			$('#i_reemp'+remp).val('');
		});
		
		$('#b_regresar').click(function(){
			$('#contenido').animate({left:'5%'},'1000');
			$('#contenido2').animate({left:'-105%'},'1000');
		});
		
		$('#b_guardar').click(function(){
			var info = {'registro':registro,
			'motivo':$('#s_incidencia').val(),
			'justificacion':$('#ta_justificacion').val(),
			'tipo':$('#s_tipo').val(),
			'cobro':$('#s_cobro').val(),
			'reem1':$('#i_reemp1').attr('alt2'),
			'incidencia1':$('#s_inc_1').val(),
			'reem2':$('#i_reemp2').attr('alt2'),
			'incidencia2':$('#s_inc_2').val(),
			'reem3':$('#i_reemp3').attr('alt2'),
			'incidencia3':$('#s_inc_3').val()
			};
			
			$.post('php/guarda_incidencia.php',info,function(data)
			{

				mandarMensajeError(data);	
				if(data == 1)
				{

					actualizaPantalla();
					mandarMensaje('Registro Editado Correctamente');
					$(".ifiltro").val('');
					$('#contenido').animate({left:'5%'},'1000');
					$('#contenido2').animate({left:'-105%'},'1000');
				}
				else
					mandarMensajeError('No se pudo guardar correctamente');

			});
			
		});
		
		function llenaModal(valor){
			$.post('php/busca_empleados_activos.php',{'valor':valor},function(data){
				
				var datos = JSON.parse(data);
				var num = datos[0];
				if(num==1){
					var dato = datos[1];
					id_trabajador = dato.id_empleado;
					llenaTrabajador(dato);
				}
				else{
					//alert(data);
					$('#t_trabajadores tbody').html('');
					for(var i = 1;i<=num;i++){
						var dato = datos[i];	
						var html = "<tr class='renglon_trabajador' alt2='"+dato.nombre+' '+dato.apellido_p+' '+dato.apellido_m+"' alt='"+dato.id_empleado+"'><td>"+dato.id_empleado+"</td><td>"+dato.nombre+' '+dato.apellido_p+' '+dato.apellido_m+"</td><td>"+dato.des_dep+"</td><td>"+dato.sucursal+"</td></tr>";
						$('#t_trabajadores tbody').append(html);
					}
					$('#i_filtro_trabajador').val('');
					$('#modal_trabajadores').modal('show');
				}
			});
		};
		$('#t_trabajadores').on('click','.renglon_trabajador',function(){
			$('#i_reemp'+remp).val($(this).attr('alt2'));
			$('#i_reemp'+remp).attr('alt2',$(this).attr('alt'));

			$('#modal_trabajadores').modal('hide');
		});
		
	});
</script>

<style>
	body{
		background: #fefefe url('imagenes/trabajo1.jpg') no-repeat ;
		background-size: cover;
		}
		
	#transparencia{
		position: absolute;
		top:0px;
		left: 0px;
		width: 100%;
		height: 100%;
		background-color: rgba(255,255,255,0.7);
	}
	
	#contenido {
			position: absolute;
			top: 5%;
			left: 5%;
			width: 90%;
			bottom: 5%;
			
			background-color: rgba(238,238,238,0.8);
			border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
		
		}
		
	#contenido2 {
			position: absolute;
			top: 5%;
			left: -105%;
			width: 70%;
			bottom: 5%;
			
			background-color: rgba(238,238,238,0.8);
			border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
		
		}
	#t_busqueda{
		position: absolute;
		top: 1%;
		left: 5%;
		width: 90%;
		height: 5%;
	}
	
	
	
	.rojo td{
		color:red;
		font-weight: bold;
	}
	
	#t_incidencias
	{
		position: absolute;
		top: 1%;
		left: 1%;
		width: 98%;
		
	}
	#d_incidencias{
		position: absolute;
		bottom: 5%;
		left: 5%;
		width: 90%;
		top: 15%;
		background-color: rgba(238,238,238,0.8);
		border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
        overflow: auto;
	}
	#t_forma{
		position: absolute;
		top: 10%;
		left: 10%;
		width:80%;
		bottom:30%;
	}
	
	#t_historial{
		position: absolute;
		top: 74%;
		left: 10%;
		width:80%;
		bottom:5%;
	}
	#d_trabajadores{
		position:relative;
		top:5%;
		overflow: auto;
		height: 80%;
		
		
	}
</style>

<body>
	<div id="transparencia">
		
	</div>
	
	
		
	<div id="contenido">		
		<table id="t_busqueda" >
			<tr>
				<td>
					Supervisor:
					<select id="s_super">
				
					</select>
				</td>
				<td>
					Departamento:
					<select id="s_deptos" class='cambia'>
				
					</select>
				</td>
				<td>
					<button type='button' class='btn btn-primary' id='b_actualizar'  ><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> Actualizar</button>
				</td>
			</tr>	
			<tr>
				<td colspan="3" class="cen">
					Fecha: <input id="i_fecini" class="fecha cambia" />
				</td>
			</tr>	
			
		</table>
	
		<div id="d_incidencias">
			<table id="t_incidencias" class="table table-striped ">
				<thead>
					<tr>
						<td colspan="3">Filtro<input class="ifiltro" tabla='t_incidencias'></td>
					</tr>
					<tr>
						<td>
							id_empleado
						</td>
						<td>
							dif_vacante
						</td>
						<td>
							empleado
						</td>
						<td>
							puesto
						</td>
						<td>
							incidencia
						</td>
						<td>
							captura
						</td>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>		
		</div>
	</div>
		
	<div id="contenido2">
		<table id="t_forma">
			<tr>
				<td class="cen" colspan="2"># Nomina<input id="i_no_nomina" class="input_num" /> <input id="i_nombre_empleado" class="input_larga" /></td>
			</tr>
			<tr>
				<td class="cen" colspan="2">Fecha<input id="i_fecha" class="input_corta" /></td>
			</tr>
			<tr>
				<td class="cen" colspan="2">Incidencia<select id="s_incidencia" ></select><input id="i_nombre_motivo" class="input_larga" /></td>
			</tr>
			<tr class="tr_e_f">
				<td class="cen" >Tipo<select id="s_tipo" class='evento'></select></td>
			
				<td class="cen">Cobro<select id="s_cobro" class='evento'></select></td>
			</tr>
			<tr>
				<td class="cen" colspan="2" id='b_limpia'>Justificacion:</td>
			</tr>
			<tr>
				<td class="cen" colspan="2"><textarea id="ta_justificacion" cols='60' rows="4"></textarea></td>
			</tr>
			<tr class="tr_reem">
				<td class="cen" colspan="2">Remp1<input id="i_reemp1" alt='1'  alt2='' class="input_larga rem" />Inc:<select id="s_inc_1" class="inc_rem"></select></td>
			</tr>
			<tr class="tr_reem">
				<td class="cen" colspan="2">Remp2<input id="i_reemp2" alt="2" alt2='' class="input_larga rem" />Inc:<select id="s_inc_2" class="inc_rem"></select></td>
			</tr>
			<tr class="tr_reem">
				<td class="cen" colspan="2">Remp3<input id="i_reemp3" alt="3" alt2='' class="input_larga rem" />Inc:<select id="s_inc_3" class="inc_rem"></select></td>
			</tr>
			<tr>
				<td  class="der">
					<a id="b_regresar" class="btn btn-default">Regresar</a>
				</td>
				<td >
					<a id="b_guardar" class="btn btn-default">Guardar</a>
				</td>
			</tr>
			
		</table>
		<table id="t_historial">
			
		</table>
	</div>
	<div class="modal fade" id="modal_trabajadores" tabindex="-1" role="dialog" aria-labelledby="modal_label_trabajadores" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_presupuesto">Trabajadores Encontrados</h4>
		      </div>
		      <div  class="modal-body table-responsive">
		      	<div id="d_trabajadores">
		        <table id="t_trabajadores" class="table table-bordered">
		        	<thead>
		        		<tr>
		        			<td colspan="4">
		        				<input id="i_filtro_trabajador" class="ifiltro" tabla='t_trabajadores' />
		        			</td>
		        		</tr>
		        		<tr>
		        			<td>id</td>
		        			<td>nombre</td>
		        			<td>depto</td>
		        			<td>sucursal</td>
		        		</tr>
		        	</thead>
		        	<tbody>
		        		
		        	</tbody>
		        </table>
		      </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		      </div>
		    </div>
		  </div>
		</div>
</body>
</html>