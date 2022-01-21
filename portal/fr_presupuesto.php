<?php
	session_start();
	$usuario = $_SESSION['usuario'];
	error_reporting(-1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Forma Presupuesto</title>
<link rel="icon" href="imagenes/favicon.ico">
</head>


	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	<link rel="stylesheet" href="css/general.css" />
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-datepicker-new.js"></script>
	<script src="js/alert.js"></script>


<script>

var id_depto = 0,registro=0;
	$(function(){	
		
		
		function mascaraDinero(){
			$('.dinero').each(function(){
		    	var valor = $(this).html();
		    	
		    	var svalor =  valor.replace('$','');
		    	
		        svalor = svalor.toString();
		    	var arr = svalor.split(".");
		    	var aux = arr[0];
		    	var svalor_antes = aux.toString();
		    	if(arr[1]){
		    		aux = arr[1];
		        	var svalor_despues = aux.toString();
		    	}
		    	else
		    	{
		    		var svalor_despues = '00';
		    	}
		    	if(parseInt(svalor_antes) >= 1000000){
			    		var millones = svalor_antes.substring(0,(svalor_antes.length-6));
			    		var miles = svalor_antes.substring((svalor_antes.length-6),(svalor_antes.length-3));
			    		var despues = svalor_antes.substring((svalor_antes.length-3));
			    		var svalor_nuevo = millones+','+miles+','+despues;
			    }
			    else if(parseInt(svalor_antes) >= 1000){
		    		var antes = svalor_antes.substring(0,(svalor_antes.length-3));
		    		var despues = svalor_antes.substring((svalor_antes.length-3));
		    		var svalor_nuevo = antes+','+despues;
		    	}
		    	else{
		    		var svalor_nuevo = svalor_antes; 
		    	}
		    	
		    	$(this).html('$'+svalor_nuevo+'.'+svalor_despues);
		    	
		    });
		}
		
		$('.datepicker').datepicker({
				format:'yyyy-mm-dd',
				startDate: "0d"
				
		}).on('show', function(){		
					 	
					// Obtener valores actuales z-index de cada elemento
					var zIndexModal = 1041;
					var zIndexFecha = $('.datepicker').css('z-index');
				 
				        // alert(zIndexModal + zIndexFEcha);
				 
				        // Re asignamos el valor z-index para mostrar sobre la ventana modal
				        $('.datepicker').css('z-index',zIndexModal+1);
				       
					
			}).on('changeDate', function(ev){ 
				$(this).datepicker('hide');
			});
		
		$.post('php/obtener_options.php',{tipo:'sucursales'},function(data)
		{	
			$('#s_sucursales').html(data);
			actualizaPresupuesto();
			// aqui revisando
		});
		
		$.post('php/obtener_options.php',{tipo:'puestos'},function(data){	
			$('#s_puestos').html(data);
			$('#editar_puestos').html(data);
		});
		
		function calculaTotales(){
			
			var oficiales = 0;
			$('.td_oficiales').each(function(){
				
				oficiales = oficiales + parseFloat($(this).html());
			});
			
			
			
			var vacantes = 0;
			
			$('.td_puesto:contains("VACANTE")').each(function(){
				vacantes = vacantes + parseFloat($(this).parent().find('.td_oficiales').html());
			});
			
			$('#i_vacantes').val(vacantes);
			
			
			
			oficiales = oficiales - vacantes;
			$('#i_posiciones').val(oficiales);
			
			
			var monto_total = 0;
			
			$('.td_tot_total').each(function(){
				
				if($(this).html()!=''){
				
				var aux = $(this).attr('alt');
				var monto = $(this).html();
				
				$('.span_costo[alt="'+aux+'"]').html(monto);	
				monto = monto.replace('$','');
				monto = monto.replace(/,/g,'');
				monto_total = monto_total + parseFloat(monto);
				
				}
			});

			$('#td_monto_sucursal').html(monto_total);
		}
		
		function actualizaDepartamento(depto){

			var col_i = $(".panel[alt='"+depto+"']").find('.panel-collapse').attr('id');
			$(".panel[alt='"+depto+"']").html('');
			$.post('php/busca_depto_presupuesto.php',{id_depto:depto},function(data){	
				//alert(data);
				var dato = JSON.parse(data);

				if(dato.validado_presupuesto==1)
				{
					var boton = "<button alt='"+dato.id_depto+"' class='btn btn-success b_validado b_para_edicion'>Publicado</button>";
				}
				else{
					var boton = "<button alt='"+dato.id_depto+"' class='btn btn-warning b_validado b_para_edicion'>Publicar</button>";
				}
				
				var boton_facturado = "<button alt='"+dato.id_depto+"' class='btn btn-primary b_facturado b_para_edicion'>Modificar</button>";
				
				var html = '<div class="panel-heading"><h4 class="panel-title"><table style="width:100%"><tr><td><a data-toggle="collapse" data-parent="#accordion" href="#'+col_i+'">'+dato.des_dep+' Editado';
				html = html + '</a></h4></td><td style="width:300px;text-align:right">Costo: <span class="span_costo dinero"  alt="'+dato.id_depto+'" ></span></td><td class="b_para_edicion" style="width:300px;text-align:right">A Facturar: <span class="span_promediofac dinero"  alt="'+dato.id_depto+'" >'+dato.promediofac+'</span> '+boton_facturado+'</td></tr></table></div><div id="'+col_i+'" class="panel-collapse collapse"><div class="panel-body"><table alt="'+dato.id_depto+'" width="100%" border="0" style="margin-top: -15px;" class="table table-striped t_departamentos"><thead><tr style="background-color: #f5f5f0;"><td width="15%">Posición</td><td width="6%">Oficiales</td><td width="9%">Sueldo Q</td><td width="9%">Bono Q</td><td width="9%">T Extra</td><td width="9%">Dia 31</td><td width="9%">Festivo</td><td width="9%">Bono Var</td><td width="20%">Observaciones</td><td width="10%">Total mensual</td></tr></thead><tbody>';
				html = html + '</tbody><tfoot><tr class="tr_totales" alt="'+dato.id_depto+'"><td colspan="1">TOTALES</td><td class="td_tot_posiciones"></td><td class="td_tot_sueldo"></td><td class="td_tot_bono"></td><td class="td_tot_extras"></td><td class="td_tot_variables"></td><td></td><td></td><td></td><td class="td_tot_total dinero" alt="'+dato.id_depto+'"></td></tr>';
				html = html + '<tr><td colspan="4" align="center"><button type="button" class="btn btn-primary b_agregar_pos b_para_edicion" alt="'+dato.id_depto+'"  data-toggle="modal" data-target="#modal_posicion">Agregar</button></td><td colspan="4">'+boton+'</td></tr></tfoot></table></div></div>';
			
				$(".panel[alt='"+depto+"']").append(html);

				var tabla = $(".panel[alt='"+depto+"']").find('.t_departamentos').find('tbody');
				$.post('php/busca_presupuesto_depto.php',{'id_depto':depto},function(data2){
					datos = JSON.parse(data2);
					num = datos[0];
					tabla.html('');
					var cant_posiciones = 0;
					var cant_total = 0;
					
					for(var i = 1;i<=num;i++){
						dato = datos[i];
						cant_posiciones =  cant_posiciones + parseInt(dato.oficiales);
						cant_total =  cant_total + (2*parseFloat(dato.oficiales)*(parseFloat(dato.sueldo_quincena)+parseFloat(dato.bono_quincena))+parseFloat(dato.tiempos_extras)+parseFloat(dato.bono_variable)+parseFloat(dato.dia31)+parseFloat(dato.dia_festivo));
						
						html = "<tr class='renglon_posicion'  alt='"+dato.registro+"' ><td class='td_puesto'>"+dato.puesto+"</td><td class='td_oficiales'>"+dato.oficiales+"</td><td>"+dato.sueldo_quincena+"</td><td>"+dato.bono_quincena+"</td><td>"+dato.tiempos_extras+"</td><td>"+dato.dia31+"</td><td>"+dato.dia_festivo+"</td><td>"+dato.bono_variable+"</td><td>"+dato.observaciones+"</td><td class='td_total dinero'>"+(2*parseFloat(dato.oficiales)*(parseFloat(dato.sueldo_quincena)+parseFloat(dato.bono_quincena))+parseFloat(dato.tiempos_extras)+parseFloat(dato.bono_variable)+parseFloat(dato.dia31)+parseFloat(dato.dia_festivo))+"</td><td><button type='button' class='btn btn-primary b_editar b_para_edicion'  alt2='"+dato.id_depto+"'  alt='"+dato.registro+"'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button><button type='button' class='btn btn-warning b_borrar b_para_edicion'  alt2='"+dato.id_depto+"'  alt='"+dato.registro+"'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td></tr>";
						tabla.append(html);
					}
						$('.tr_totales[alt="'+depto+'"]').find('.td_tot_posiciones').html(cant_posiciones);
						$('.tr_totales[alt="'+depto+'"]').find('.td_tot_total').html(cant_total);
						calculaTotales();
						mascaraDinero();
						
				});
				$('.panel-collapse').addClass('in');
				
			});

			
		}
		/*
		$("#accordion").on('click','.panel-heading',function(){
			var dep = $(this).parent().attr('alt');
			actualizaDepartamento(dep);
		});
		*/
		function actualizaPresupuesto(){

			
			$.post('php/busca_deptos_presupuesto.php',{sucursal:$('#s_sucursales').val()},function(data)
			{	
				//alert(data);
				var datos = JSON.parse(data);
				var num = datos[0];
				$('#i_departamentos').val(num);
				$('#accordion').html('');
				for(var i = 1;i<=num;i++)
				{

					var dato = datos[i];


					var dato = datos[i];
					
					if(dato.validado_presupuesto==1){
						var boton = "<button alt='"+dato.id_depto+"' class='btn btn-success b_validado b_para_edicion'>Publicado</button>";
					}
					else{
						var boton = "<button alt='"+dato.id_depto+"' class='btn btn-warning b_validado b_para_edicion'>Publicar</button>";
					}
					
					var boton_facturado = "<button alt='"+dato.id_depto+"' class='btn btn-primary b_facturado b_para_edicion'>Modificar</button>";
					
					var html = ' <div class="panel panel-default" alt="'+dato.id_depto+'"><div class="panel-heading"><h4 class="panel-title"><table style="width:100%"><tr><td><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+i+'">'+dato.des_dep;
					html = html + '</a></h4></td><td style="width:300px;text-align:right">Costo: <span class="span_costo dinero"  alt="'+dato.id_depto+'" ></span></td><td class="b_para_edicion" style="width:300px;text-align:right">A Facturar: <span class="span_promediofac dinero"  alt="'+dato.id_depto+'" >'+dato.promediofac+'</span> '+boton_facturado+'</td></tr></table></div><div id="collapse'+i+'" class="panel-collapse collapse"><div class="panel-body"><table alt="'+dato.id_depto+'" width="100%" border="0" style="margin-top: -15px;" class="table table-striped t_departamentos"><thead><tr style="background-color: #f5f5f0;"><td width="15%">Posición</td><td width="6%">Oficiales</td><td width="9%">Sueldo Q</td><td width="9%">Bono Q</td><td width="9%">T Extra</td><td width="9%">Dia 31</td><td width="9%">Festivo</td><td width="9%">Bono Var</td><td width="20%">Observaciones</td><td width="10%">Total mensual</td></tr></thead><tbody>';
					html = html + '</tbody><tfoot><tr class="tr_totales" alt="'+dato.id_depto+'"><td colspan="1">TOTALES</td><td class="td_tot_posiciones"></td><td class="td_tot_sueldo"></td><td class="td_tot_bono"></td><td class="td_tot_extras"></td><td class="td_tot_variables"></td><td></td><td></td><td></td><td class="td_tot_total dinero" alt="'+dato.id_depto+'"></td></tr>';
					html = html + '<tr><td colspan="4" align="center"><button type="button" class="btn btn-primary b_agregar_pos b_para_edicion" alt="'+dato.id_depto+'"  data-toggle="modal" data-target="#modal_posicion">Agregar</button></td><td colspan="4">'+boton+'</td></tr></tfoot></table></div></div></div>';

					$('#accordion').append(html);

				}

				var depas = num;
				var cont = 0;
				
				$('.t_departamentos').each(function()
				{
					var depto = $(this).attr('alt');
					var tabla = $(this).find('tbody');
					$.post('php/busca_presupuesto_depto.php',{'id_depto':depto},function(data2){
						datos = JSON.parse(data2);
						num = datos[0];
						tabla.html('');
						var cant_posiciones = 0;
						var cant_total = 0;
						
						for(var i = 1;i<=num;i++){
							dato = datos[i];
						    cant_posiciones =  cant_posiciones + parseInt(dato.oficiales);
						    cant_total =  cant_total + (2*parseFloat(dato.oficiales)*(parseFloat(dato.sueldo_quincena)+parseFloat(dato.bono_quincena))+parseFloat(dato.tiempos_extras)+parseFloat(dato.bono_variable)+parseFloat(dato.dia31)+parseFloat(dato.dia_festivo));
							
							html = "<tr class='renglon_posicion'  alt='"+dato.registro+"' ><td class='td_puesto'>"+dato.puesto+"</td><td class='td_oficiales'>"+dato.oficiales+"</td><td>"+dato.sueldo_quincena+"</td><td>"+dato.bono_quincena+"</td><td>"+dato.tiempos_extras+"</td><td>"+dato.dia31+"</td><td>"+dato.dia_festivo+"</td><td>"+dato.bono_variable+"</td><td>"+dato.observaciones+"</td><td class='td_total dinero'>"+(2*parseFloat(dato.oficiales)*(parseFloat(dato.sueldo_quincena)+parseFloat(dato.bono_quincena))+parseFloat(dato.tiempos_extras)+parseFloat(dato.bono_variable)+parseFloat(dato.dia31)+parseFloat(dato.dia_festivo))+"</td><td><button type='button' class='btn btn-primary b_editar b_para_edicion'  alt2='"+dato.id_depto+"'  alt='"+dato.registro+"'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button><button type='button' class='btn btn-warning b_borrar b_para_edicion'  alt2='"+dato.id_depto+"'  alt='"+dato.registro+"'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td></tr>";
							tabla.append(html);
						}
							$('.tr_totales[alt="'+depto+'"]').find('.td_tot_posiciones').html(cant_posiciones);
							$('.tr_totales[alt="'+depto+'"]').find('.td_tot_total').html(cant_total);
							cont++;
							if(cont == depas){
								calculaTotales();
								mascaraDinero();
							}
					});
				});

				$('.panel-collapse').addClass('in');
				
			});
			
		}
		
		$('#accordion').on('click','.b_facturado',function(){
			id_depto = $(this).attr('alt');
			$('#i_promediofac').val('');
			$('#modal_cambiar_promediofac').modal('show');
		});
		
		$('#b_cambia_promediofac').click(function(){
			var info = {'id_depto':id_depto,
				'promediofac':$('#i_promediofac').val()};
			$.post('php/cambia_promediofac_depto.php',info,function(data){
				if(data==1){
					$('.span_promediofac[alt="'+id_depto+'"]').html($('#i_promediofac').val());
					mascaraDinero();
					$('#modal_cambiar_promediofac').modal('hide');
					mandarMensaje('Promedio a Facturar modificado correctamente');
				}
				else{
					mandarMensajeError('Error:'+data);
				}
			});
			
		});
		
		
		$('#accordion').on('click','.b_validado',function(){
			if($(this).html()!='Publicado'){
				id_depto = $(this).attr('alt');
				$('#i_fecha_publicar').val('');
				$('#modal_publicar_cambios').modal('show');
			}
		});
		
			
		$('#b_publicar_cambios').click(function(){	
			
			if($('.t_departamentos[alt="'+id_depto+'"] tbody tr').length!= 0){
			
				if($('#i_fecha_publicar').val()!=''){
					if($('.b_validado[alt="'+id_depto+'"]').html()=='Publicado')
						var opcion = 0;
					else
						var opcion = 1;
						
						
					var info = {'id_depto':id_depto,'opcion':opcion,'fecha':$('#i_fecha_publicar').val()};
					
					
					$.post('php/cambia_estatus_presupuesto.php',info,function(data){
						if(data==1){
							actualizaDepartamento(id_depto);
							 $('#modal_publicar_cambios').modal('hide');
							 mandarMensaje('Se Publico el Cambio con fecha de: '+$('#i_fecha_publicar').val());
						}
						else
							mandarMensajeError('Error:'+data);
					});
					
				}
				else{
					mandarMensajeError('Indicar una fecha');
				}
			
			}
			else{
				mandarMensajeError('Favor de Agregar por lo menos una posicion');
			}
			
		});
		
		
		$('#s_sucursales').change(function(){
			actualizaPresupuesto();
		});
		
		$('#b_expandir').click(function(){
			if($('.panel-collapse').hasClass("in"))
				$('.panel-collapse').removeClass('in');
			else
				$('.panel-collapse').addClass('in');
		});
		
		$('#b_agregar').click(function(){
			window.open('../fr_departamentos.php','_self');
		});
		//--MGFS 10-01-2020 SE AGREGA BOTON PARA EDITAR UN DEPARTAMENTO DESDE PORTAL
		$('#b_activar_departamento').click(function(){
			window.open('fr_departamentos.php','_self');
		});
		
		$('#accordion').on('click','.b_agregar_pos',function(){
			id_depto = $(this).attr('alt');
			$('#s_puestos').val();
			$('#i_oficiales').val('');
			$('#i_sueldo').val('');
			$('#i_bonos').val('');
			$('#i_extras').val('');
			$('#i_bono_var').val('');
			$('#i_dia31').val('');
			$('#i_dia_festivo').val('');
			$('#ta_observaciones').val('');
		});
		
		$('#accordion').on('click','.b_editar',function(){
		    registro = $(this).attr('alt');
		    id_depto = $(this).attr('alt2');
			
			$.post('php/busca_registro_presupuesto.php',{'registro':registro},function(data){
				var dato = JSON.parse(data);
				$('#editar_puestos').val(dato.id_puesto);
				$('#editar_oficiales').val(dato.oficiales);
				$('#editar_sueldo').val(dato.sueldo_quincena);
				$('#editar_bonos').val(dato.bono_quincena);
				$('#editar_extras').val(dato.tiempos_extras);
				$('#editar_bono_var').val(dato.bono_variable);
				$('#editar_dia31').val(dato.dia31);
				$('#editar_dia_festivo').val(dato.dia_festivo);
				$('#editar_observaciones').val(dato.observaciones);
				$('#modal_editar').modal('show');
			});
			
		});
		
		$('#accordion').on('click','.b_borrar',function(){
		    registro = $(this).attr('alt');
			$('#modal_borrar_presupuesto').modal('show');
		});
		
		$('#b_borrar_registro').click(function(){
			
			$.post('php/borra_registro_presupuesto.php',{'registro':registro},function(data){
				if(data!=0){
							//alert(data);
							 actualizaDepartamento(data);
							 $('#modal_borrar_presupuesto').modal('hide');
							 mandarMensaje('El registro se Borro Correctamente');
							 
						}
						else
							mandarMensajeError('Error:'+data);
			});
		});
		
		$('#b_editar_posicion').click(function(){
			
			var info = {'registro':registro,
						'id_puesto':$('#editar_puestos').val(),
						'oficiales':$('#editar_oficiales').val(),
						'sueldo':$('#editar_sueldo').val(),
						'bonos':$('#editar_bonos').val(),
						'extras':$('#editar_extras').val(),
						'bono_var':$('#editar_bono_var').val(),
						'dia31':$('#editar_dia31').val(),
						'dia_festivo':$('#editar_dia_festivo').val(),
						'observaciones':$('#editar_observaciones').val()};
			$.post('php/cambia_registro_presupuesto.php',info,function(data){
				if(data==1){
					//actualizaPresupuesto();
					$.post('php/cambia_estatus_presupuesto.php',{'id_depto':id_depto,'opcion':0},function(data2){
						if(data2==1){
							 actualizaDepartamento(id_depto);
						}
						else
							mandarMensajeError("Error:"+data);
					});	
					$('#modal_editar').modal('hide');
				}
				else
					mandarMensajeError('Error:'+data);
			});
		});
		
		$('#b_crear_posicion').click(function(){
			var info = {'id_sucursal':$('#s_sucursales').val(),
						'id_depto':id_depto,
						'id_puesto':$('#s_puestos').val(),
						'oficiales':$('#i_oficiales').val(),
						'sueldo':$('#i_sueldo').val(),
						'bonos':$('#i_bonos').val(),
						'extras':$('#i_extras').val(),
						'bono_var':$('#i_bono_var').val(),
						'dia31':$('#i_dia31').val(),
						'dia_festivo':$('#i_dia_festivo').val(),
						'observaciones':$('#ta_observaciones').val()};
			$.post('php/crea_presupuesto_depto.php',info,function(data){
				console.log('resultado:'+data);
				if(data==1){
					$.post('php/cambia_estatus_presupuesto.php',{'id_depto':id_depto,'opcion':0},function(data2){
						if(data2==1){
							actualizaDepartamento(id_depto);
						}
						else
							mandarMensajeError("Error:"+data);
					});	
					$('#modal_posicion').modal('hide');
				}
				else
					mandarMensajeError("Error:"+data);
			});
		});
	});
</script>

<style>
	body{
		background: #fefefe url('imagenes/trabajo1.jpg') no-repeat ;
		background-size: cover;
		}
	.modal{
		z-index: 1041;
	}
	.b_para_edicion{
		display:<?php echo ($usuario == 'BLANCACHAVEZ' ||  $usuario == 'CONTRALORIA' ||  $usuario == 'ALINJIMENEZ') ? 'display' : 'none';?>;
	}	
	#transparencia{
		position: absolute;
		top:0px;
		left: 0px;
		width: 100%;
		height: 100%;
		background-color: rgba(255,255,255,0.7);
	}
	
	.tr_totales td{
		background-color: rgba(240,173,78,0.7);
		color: white;
	}
	
	#contenido {
			position: absolute;
			top: 2%;
			left: 3%;
			width: 95%;
			bottom: 2%;
			padding: 20px;
			background-color: rgba(238,238,238,0.8);
			border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
		}
		
		#div_contenedor{
			max-height: 85%; 
			min-height: 85%; 
			border: 1px solid #fff;
		}
		
		#div_contenido{
			margin-top: 2%; 
			width: 90%;
			overflow-x: hidden; 
			overflow-y:scroll;
		}
		
		#div_botones{
			width: 8%;
			float:right;
			margin-left:5%;
			margin-top:-35%;
		}
		
		#accordion{
			max-height: 500px; 
			min-height: 500px;  
			border: 1px solid #fff; 
			margin-left: 15px; 
		}
	
</style>

<body>
	<div id="transparencia">
		
	</div>
	
	<div id="contenido">
		<table id="t_busqueda" >
			<tr>
				<td>
					Sucursal:
					<select id="s_sucursales">
				
					</select>
				</td>
			</tr>
		</table>
			
		<div id="div_contenedor">
			<div id="div_contenido">
				<div id="accordion" class="panel-group">
					
								  
				</div>	
			</div>
						
			<div id="div_botones">
				<button type="button" class="btn btn-primary " id="b_expandir">Expandir</button>		
				<!-- MGFS 10-01-2020 SE MODIFICA BOTON PARA QUE VAYA A AGREGAR UN DEPARTAMENTO DESDE GINTHERCORP-->
				<button type="button" class="btn btn-primary" id="b_agregar" style="margin-top: 20%;">Agregar</button>
				<!-- MGFS 10-01-2020 SE AGREGA BOTON PARA ACCEDER A CREAR Y EDITAR DEPARTAMENTOS DE PORTAL--->
				<button type="button" class="btn btn-primary b_para_edicion" id="b_activar_departamento" style="margin-top: 20%;">Activar</button>
			</div>
		</div>
				
		<table width="100%" border="0" style="margin-top: 1%;">
			<tr>
				<td width="30%" align="center">Total departamentos <input type="text" id="i_departamentos" name=""  size="10"></td>
				<td width="20%">Total posiciones <input type="text" id="i_posiciones" name=""  size="10"></td>
				<td width="20%">Total vacantes <input type="text" id="i_vacantes" name=""  size="10"></td>
				<td width="20%">Monto Sucursal </td>
				<td class="dinero" id="td_monto_sucursal"></td>
				
			</tr>
		</table>
	</div>
	
	 <!-- Dialogos -->
	<div class="modal fade" id="modal_posicion" tabindex="-1" role="dialog" aria-labelledby="modal_label_posicion" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		       <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
		        <h4 class="modal-title">Creacion de Posicion</h4>
		      </div>
		      <div class="modal-body table-responsive">
		      	<table>
		      		<tr>
		      			<td>Posicion</td>
		      			<td>Oficiales</td>
		      			<td>Sueldo Q</td>
		      			<td>Bono Q</td>
		      			<td>T Extra</td>
		      			
		      			
		      		</tr>
		      		<tr>
		      			<td><select id="s_puestos"></select></td>
		      			<td><input id="i_oficiales" class="input_num" /></td>
		      			<td><input id="i_sueldo" class="input_corta" /></td>
		      			<td><input id="i_bonos" class="input_corta" /></td>
		      			<td><input id="i_extras" class="input_corta" /></td>
		      			
		      		</tr>
		      		<tr>
		      			<td></td>
		      			<td></td>
		      			<td>Dia 28/29/31</td>
		      			<td>Dia Festivo</td>
		      			<td>Bono Var</td>
		      		</tr>
		      		<tr>
		      			<td></td>
		      			<td></td>
		      			<td><input id="i_dia31" class="input_corta" /></td>
		      			<td><input id="i_dia_festivo" class="input_corta" /></td>
		      			<td><input id="i_bono_var" class="input_corta" /></td>
		      			
		      		</tr>
		      		<tr>
		      			<td>Observaciones</td>
		      		</tr>
		      		<tr>
		      			<td colspan="5"><textarea id="ta_observaciones"></textarea></td>
		      		</tr>
		      	</table>
		      </div>
		      <div class="modal-footer">
		       <button type="button" class="btn btn-default b_cierre" data-dismiss="modal">Cancelar</button>
		       <button id="b_crear_posicion" type="button" class="btn btn-primary">Aceptar</button>
		        
		      </div>
		    </div>
		  </div>
		</div>
		
		
		<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="modal_label_posicion" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		       <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
		        <h4 class="modal-title">Editar de Posicion</h4>
		      </div>
		      <div class="modal-body table-responsive">
		      	<table style="width: 100%;">
		      		<tr>
		      			<td>Posicion</td>
		      			<td>Oficiales</td>
		      			<td>Sueldo Q</td>
		      			<td>Bono Q</td>
		      			<td>T Extra</td>
		      			
		      			
		      		</tr>
		      		<tr>
		      			<td><select id="editar_puestos"></select></td>
		      			<td><input id="editar_oficiales" class="input_num" /></td>
		      			<td><input id="editar_sueldo" class="input_corta" /></td>
		      			<td><input id="editar_bonos" class="input_corta" /></td>
		      			<td><input id="editar_extras" class="input_corta" /></td>
		      			
		      			
		      		</tr>
		      		<tr>
		      			<td></td>
		      			<td></td>
		      			<td>Dia 28/29/31</td>
		      			<td>Dia Festivo</td>
		      			<td>Bono Var</td>
		      		</tr>
		      		<tr>
		      			<td></td>
		      			<td></td>
		      			<td><input id="editar_dia31" class="input_corta" /></td>
		      			<td><input id="editar_dia_festivo" class="input_corta" /></td>
		      			<td><input id="editar_bono_var" class="input_corta" /></td>
		      		</tr>
		      		<tr>
		      			<td>Observaciones</td>
		      		</tr>
		      		<tr>
		      			<td colspan="5"><textarea id="editar_observaciones"></textarea></td>
		      		</tr>
		      	</table>
		      </div>
		      <div class="modal-footer">
		       <button type="button" class="btn btn-default b_cierre" data-dismiss="modal">Cancelar</button>
		       <button id="b_editar_posicion" type="button" class="btn btn-primary">Aceptar</button>
		        
		      </div>
		    </div>
		  </div>
		</div>
		<div class="modal fade" id="modal_borrar_presupuesto" tabindex="-1" role="dialog" aria-labelledby="modal_label_borrar" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_presupuesto">Borrar Registro Presupuesto</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo" class="table table-bordered">
		        	<tbody>
		        		<tr>
		        			<td class="cen"><h4>¿Esta seguro que desea BORRAR el registro?</h4></td>
		        		</tr>
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="button" class="btn btn-primary" id="b_borrar_registro" >Borrar</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<div class="modal fade" id="modal_publicar_cambios" tabindex="-1" role="dialog" aria-labelledby="modal_label_aplicar_cambios" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_presupuesto">Publicar Cambios</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo" class="table table-bordered">
		        	<tbody>
		        		<tr>
		        			<td class="cen"><h4>Se aplicaran los cambios registrados</h4></td>
		        		</tr>
		        		<tr>
		        			<td class="cen">
		        				A partir de que fecha:
		        			</td>
		        		</tr>
		        		<tr>
		        			<td class="cen">
		        				<input id="i_fecha_publicar" class="datepicker" />
		        			</td>
		        		</tr>
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="button" class="btn btn-primary" id="b_publicar_cambios" >Aplicar Cambios</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<div class="modal fade" id="modal_cambiar_promediofac" tabindex="-1" role="dialog" aria-labelledby="modal_label_cambiar_promediofac" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_presupuesto">Modificar Promedio de Facturacion</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo" class="table table-bordered">
		        	<tbody>
		        		<tr>
		        			<td class="cen"><h4>Cantidad Promedio de Facturacion:</h4></td>
		        		</tr>
		        		<tr>
		        			<td class="cen">
		        				<input id="i_promediofac" />
		        			</td>
		        		</tr>
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="button" class="btn btn-primary" id="b_cambia_promediofac" >Modificar</button>
		      </div>
		    </div>
		  </div>
		</div>
</body>
</html>
