<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
		
	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/alert.js"></script>
	
	<script>
		$(document).ready(function()
		{
				$('.boton').button();
				
				$.get('php/obtener_options_rnomina.php',{ tipo: 'sucursal'}, function(data){
				$('#s_sucursales').html(data);
				});
				
				$.get('php/obtener_options_rnomina.php',{ tipo: 'ano'}, function(data){
				$('#s_anos').html(data);
				});
				
				$("#s_sucursales").change(function(){
					//alert($('#s_sucursales').val());
					$.get('php/obtener_options_rnomina.php',{ tipo: 'supervisor', compania: $('#s_sucursales').val() }, function(data){
					$('#s_super').html(data);
					//alert(data);
					
					});
				});
				
				$("#s_anos").change(function(){
					//alert($('#s_anos').val());
					$.get('php/obtener_options_rnomina.php',{ tipo: 'quincenas', ano: $('#s_anos').val() }, function(data){
					$('#s_quincenas').html(data);
					//alert(data);
					
					});
				});
				/*
				$("#s_super").change(function(){
					//alert($("#s_super").val());
					$("#frame_p").attr('src','reporte_incidencias_periodo_n.php?super='+$("#s_super").val());
				});
				*/

				
				$('#b_imprimir').click(function(){
					window.frames["frame_p"].focus();
					window.frames["frame_p"].print();
				});
				
				$('#b_buscar').click(function(){
					
					
						
					if(validaFiltros()=='')
					$("#frame_p").attr('src','php/reporte_incidencias_periodo_n.php?super='+$("#s_super").val()+'&quincena='+$("#s_quincenas").val()+'&ano='+$("#s_anos").val());
					else
					alert(validaFiltros());
				});
				
				function validaFiltros()
				{
					var mensaje='';
					if($("#s_super").val() == null)
						mensaje +='Selecciona un Supervisor \n';
					if($("#s_quincenas").val() == null)
						mensaje += 'Selecciona una quincena \n';
					if($("#s_anos").val()==null)
						mensaje += 'Selecciona un año';
						
					return mensaje;
				}
				
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
	#d_filtros{
		position: absolute;
		top:5%;
		left: 5%;
		width: 90%;
		height: 10.2%;
	}
	
	#d_filtros table{
		position: absolute;
		top:10%;
		left: 5%;
		width: 85%;
	}
	
	#d_res{
		position: absolute;
		top:17%;
		left: 5%;
		width: 90%;
		height: 80%;
		overflow: auto;
	}
	
	.query_table{
		position: absolute;
		top:5%;
		left:2%;
		width:96%;
	}
	
	.query_table td{
		padding: 5px;
	}
	
	.query_table .tr_primero {
		background-color: rgba(0,0,0,0.5);;
		color:#fefefe;
		text-align: left;
	}
	
	.query_table .tr_primero:hover {
		background-color: rgba(0,0,0,0.5);;
		color:#fefefe;
		text-align: left;
	}
	
	.query_table tr:nth-child(even){ background-color:#fefefe; color:#000;}
	.query_table tr:hover{ background:#000055; color:#fefefe;}
</style>



<body>
	<div id="transparencia">
		
	</div>
	<div id="d_filtros" class="cuadro">
		<table>
			<td> SUCURSAL: <select id='s_sucursales'> </select> </td>
			
			<td style="padding-left: 20px;">SUPERVISOR: <select id='s_super'> </select> </td>
			<td style="padding-left: 20px;">Año: <select id='s_anos'> </select> </td>
			<td style="padding-left: 20px;">Quincena: <select id='s_quincenas'> </select> </td>
			<td style="padding-left: 20px;"><a id="b_buscar" class="btn btn-primary">Buscar</a></td>
			<td style="padding-left: 20px;"><a id="b_imprimir" class="btn btn-primary">Imprimir</a></td>
		</table>
		

	</div>
	<div id="d_res" class="cuadro">
		<iframe id="frame_p" name="frame_p" style="position: absolute; top:10%; left:0px; width: 100%; height: 90%; border: 0px;">
			
		</iframe>
	</div>

</body>
</html>