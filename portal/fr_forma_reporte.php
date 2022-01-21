<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Forma Consulta Cliente</title>
</head>


	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/alert.js"></script>


<script>

    var aux = new Date();
	var hoy = aux.getFullYear()+'-'+(aux.getMonth()+1)+'-'+aux.getDate();
		
	$(document).ready(function(){
		
		
		$('.fecha').datepicker({
			format: "dd/mm/yyyy",
		    autoclose: true,
		    changeMonth: true,
	        changeYear: true
		});
		
		$(".fecha").on("changeDate", function(event){
			var valor = $("#s_reportes").val();
		    var myArray = valor.split('-');
			$.post('php/genera_reporte_datos.php',{'id_reporte':myArray[0],'fecha_inicio':$("#i_fecha_inicio").val(),'fecha_fin':$("#i_fecha_fin").val()},function(data){
				$("#d_res").html(data);
			});
		   
		});
			
		$.get('php/obtener_options.php',{ tipo: 'reportes'}, function(data){
			$('#s_reportes').html(data);

		});//fin llena combo
		
		
		$.get('php/obtener_options.php',{ tipo: 'ano'}, function(data){
			$('#s_ano').html(data);
			$.get('php/obtener_options.php',{ tipo: 'quincenas','ano':$('#s_ano').val()}, function(data){
				$('#s_quincena').html(data);

			});
		});

		$.get('php/obtener_options.php',{ tipo: 'ano_b'}, function(data){
			$('#s_ano_b').html(data);
			$.get('php/obtener_options.php',{ tipo: 'bimestre','ano_b':$('#s_ano_b').val()}, function(data){
				$('#s_bimestre').html(data);

			});
		});

		
		$('#s_ano').change(function(){
			$.get('php/obtener_options.php',{ tipo: 'quincenas','ano':$(this).val()}, function(data){
				$('#s_quincena').html(data);

			});
		});
		

		$('#s_ano_b').change(function(){
			$.get('php/obtener_options.php',{ tipo: 'bimestre','ano_b':$(this).val()}, function(data){
				$('#s_bimestre').html(data);

			});
		});


		$("#s_reportes").change(function(){
			
			$("#td_fecha_inicio").hide();
			$("#td_fecha_fin").hide();
			$(".periodo").hide();

			$(".periodo_b").hide();
			
			var valor = $("#s_reportes").val();
            var myArray = valor.split('-');
     
		
			
			if(myArray[1]==6)
			{
				$(".periodo_b").show();
			}else if(myArray[1]==5)
			{
				$(".periodo").show();
			}
			else if(myArray[1]==4)
			{
				$("#td_fecha_inicio").show();
				$("#td_fecha_fin").show();
				
				$.post('php/genera_reporte_datos.php',{'id_reporte':myArray[0],'fecha_inicio':$("#i_fecha_inicio").val(),'fecha_fin':$("#i_fecha_fin").val()},function(data){
				
					$("#d_res").html(data);
				});
			}else if(myArray[1]==3)
			{
				$("#td_fecha_inicio").show();
				$("#td_fecha_fin").show();
				
				$.post('php/genera_reporte_datos.php',{'id_reporte':myArray[0],'fecha_inicio':$("#i_fecha_inicio").val(),'fecha_fin':$("#i_fecha_fin").val()},function(data){
				
					$("#d_res").html(data);
				});
			}else if(myArray[1]==2)
			{
				$(".periodo").show();
			}
			else if(myArray[1]==1)
			{
				$("#td_fecha_inicio").show();
				$("#td_fecha_fin").show();
				
				$.post('php/genera_reporte_datos.php',{'id_reporte':myArray[0],'fecha_inicio':$("#i_fecha_inicio").val(),'fecha_fin':$("#i_fecha_fin").val()},function(data){
				
					$("#d_res").html(data);
				});
			}else if(myArray[1]==0)
			{
				
				$.post('php/genera_reporte_datos.php',{'id_reporte':myArray[0]},function(data){
				
					$("#d_res").html(data);
				});
			}
			
			
		
		});
		
		$('#s_quincena').change(function(){
			var valor = $("#s_reportes").val();
            var myArray = valor.split('-');
            
            $.post('php/genera_reporte_datos.php',{'id_reporte':myArray[0],'ano':$("#s_ano").val(),'quincena':$("#s_quincena").val()},function(data){
				
					$("#d_res").html(data);
				});
		});


		$('#s_bimestre').change(function(){
			var valor = $("#s_reportes").val();
            		var myArray = valor.split('-');
              		$.post('php/genera_reporte_datos.php',{'id_reporte':myArray[0],'ano':$("#s_ano_b").val(),'bimestre':$("#s_bimestre").val()},function(data){
				$("#d_res").html(data);
			});
		});
		
		
		$("#b_imprimir").click(function(){
			var valor = $("#s_reportes").val();
			
            var myArray = valor.split('-');
			var id_reporte = myArray[0];
			if(id_reporte=='' || id_reporte==null)
			{
				notificar('Debes seleccionar primero un reporte');
				
			}else{
			var nom_reporte = $("#s_reportes option:selected").html();
			var html = '<tr class="tr_primero">';
			html += $(".tr_primero").html();
			html += '</tr>';
			
			$('#d_res .renglon').each(function(){
				if($(this).css('display')!='none')
				{
				html += '<tr class=".renglon">';
				html+= $(this).html();
				html += '</tr>';
				}
			});
			$("#i_html").val('<table class="query_table">'+html+'</table>');
			$("#i_nom_reporte").val(nom_reporte);
			$("#f_imprimir").submit();
			}
		});
	
		$('#b_excel2').click(function(){
			var selected = s_reportes.options[s_reportes.selectedIndex].text;
			var valor = $("#s_reportes").val();
			if(valor!=null){
	            var myArray = valor.split('-');
				var id_reporte = myArray[0];
				if(id_reporte=='' || id_reporte==null)
				{
					notificar('Debes seleccionar primero un reporte');
					
				}else{
				var html ='<tr class="tr_primero">';
				html += $(".tr_primero").html();
				html += '</tr>';
				var prim=html.replace(/<td>/g,'<td><h3>');
				var seg=prim.replace(/<\/td>/g,'</h3></td>');
				html=seg;
				
				$('#d_res .renglon').each(function(){
					var texto = $(this).html();
					texto = texto.replace(/<br>/g,'');
					texto = texto.replace(/<td/g,'<td style="border: 1px solid #AAA;"');
					if($(this).css('display')!='none'){
						html += '<tr class=".renglon">';
						html+= texto;
						html += '</tr>';
					}
				});
				$("#i_excel").val(html);
				$("#nombre").val(selected);
				$("#fecha").val(hoy);
				$("#f_imprimir_excel").submit();
				}
			}else{
				notificar('Debes seleccionar primero un reporte');
			}
		});
		
		$.expr[":"].contains = $.expr.createPseudo(function(arg) {
		    return function( elem ) {
		        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
		    };
		});
		
		$('#i_filtro').change(function(){
			var aux = $("#i_filtro").val();
			if(aux == '')
			{
			$('.renglon').show();
			}
			else
			{
			$('.renglon').hide();
			$('.renglon:contains(' + aux + ')').show();
			aux = aux.toLowerCase();
			$('.renglon:contains(' + aux + ')').show();
			aux = aux.toUpperCase();
			$('.renglon:contains(' + aux + ')').show();
			}
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
			<tr>
				<td>REPORTE: <select id="s_reportes"></select></td>
				<td id="td_fecha_inicio" style="display: none">FECHA INICIO: <input id="i_fecha_inicio" class="fecha" /></td>
				<td id="td_fecha_fin" style="display: none">FECHA FIN: <input id="i_fecha_fin" class="fecha" /></td>
				<td  class='periodo' style="display: none">AÑO: <select id="s_ano"></select></td>
				<td  class='periodo' style="display: none">QUINCENA: <select id="s_quincena"></select></td>
				
				<td  class='periodo_b' style="display: none">AÑO: <select id="s_ano_b"></select></td>
				<td  class='periodo_b' style="display: none">BIMESTRE: <select id="s_bimestre"></select></td>

				<td>FILTRAR: <input id="i_filtro" /></td>
				<td>
					<a id="b_excel2" class="btn btn-primary">EXCEL</a>
					<form id="f_imprimir_excel" action="php/prueba_excel.php" method="POST" target="_blank">
						<input type="hidden" id="i_excel" name='i_excel'>
						<input type="hidden" id="nombre" name='nombre'>
						<input type="hidden" id="fecha" name='fecha'>
					</form>
				</td>
				<td>
					<a id="b_imprimir" class="btn btn-primary">IMPRIMIR</a>
					<form id="f_imprimir" action="php/imprime_reporte.php" method="POST" target="_blank">
						<input type="hidden" id="i_html" name='html'>
						<input type="hidden" id="i_nom_reporte" name='nom_reporte'>
					</form>
				</td>
			</tr>
		</table>
	</div>
	<div id="d_res" class="cuadro">
		
	</div>
</body>
</html>
