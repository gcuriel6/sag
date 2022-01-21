<?php
	session_start();
	$id_supervisor = $_SESSION['id_supervisor'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Anticipos</title>
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
	var id_supervisor=<?php echo $id_supervisor?>;
	var	quincena = 0;
	var ano = 0;
	var cerrado = 0;
	var dep_cer = 0;
	
	$(function() {
				
		$.post('php/obtener_options.php',{tipo:'super_anticipos','id_supervisor':id_supervisor},function(data2){
			$('#s_super').html(data2);
		});
		
		$('#s_super').change(function(){
				$.post('php/obtener_options.php',{tipo:'deptos_supervisor','id_supervisor':$(this).val()},function(data2){	
					$('#s_deptos').html(data2);
				});
			});

		$('#s_deptos').change(function(){
			//alert($('#s_super').val());
			$.post('php/cerrados_anticipos.php',{tipo:'checar','id_supervisor':$('#s_super').val(),'id_depto':$(this).val()},function(data3){
				var datos_c = JSON.parse(data3);
				var dato_c = datos_c[0];
				//alert(JSON.stringify(data3));
				quincena = dato_c.quincena;
				ano = dato_c.ano;
				cerrado = dato_c.cerrado;
				dep_cer = dato_c.dep_cer;
			});
			
			$.post('php/busca_depto_anticipos.php',{'id_depto':$(this).val()},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				//alert(JSON.stringify(data));
				$('#t_anticipos tbody').html('');
				for(var i = 1;i<=num;i++){
					var dato = datos[i];
						
					var inp_monto = "<input alt='"+dato.id_trabajador+"' alt1='"+dato.quincena+"' alt2='"+dato.ano+"' alt3='"+dato.id_depto+"' type='text' class='i_monto' name=''  size='10' value='"+dato.monto+"'>";
					
					var html = "<tr class='renglon_anticipo'><td>"+dato.id_trabajador+"</td><td>"+dato.nombre+"</td><td>"+inp_monto+"</td><td>"+dato.autorizado+"</td></tr>";
					
					$('#t_anticipos tbody').append(html);
				}
			});
	});
	
	$('#t_anticipos').on('change','.i_monto',function(){
		if(  !(isNaN($(this).val())) ) {
			//alert('entro');
			//alert($(this).val());
			if(dep_cer==0)
			{			
				$.post('php/graba_anticipos.php',{'id_empleado':$(this).attr('alt'),'quincena':$(this).attr('alt1'),'ano':$(this).attr('alt2'),'id_depto':$(this).attr('alt3'),'monto':$(this).val()},function(data1){	
				
					//alert(JSON.stringify(data1));
					actualizaPantalla();
				
				});
			}
			else 
			{
				mandarMensajeError('Los departamentos del supervisor estan liberado no se puede realizar cambios');
				actualizaPantalla();
			}
		}
		else
		{
			mandarMensajeError('El valor propocionado no es un numero');
			actualizaPantalla();
		}
	});
	
	$('#b_liberar').click(function(){
		if($('#s_super').val()!=null){
			if(dep_cer==0)
			{
				$.post('php/cerrados_anticipos.php',{tipo:'cerrar','id_supervisor':$('#s_super').val()},function(data4){
					if(data4==1)
					{
						mandarMensajeError('Se liberaron los departamentos del supervisor, ya no se pueden realizar modificaciones');	
					}
					else
					{
						/*mandarMensajeError('Se liberaron los departamentos del supervisor, ya no se pueden realizar modificaciones'+data4);*/
						mandarMensajeError(data4);
					}
	
				});
			}
			else 
			{
				mandarMensajeError('Los departamentos del supervisor ya se encuentran liberados');
			}
		}
	});
	
	function actualizaPantalla(){
			$.post('php/busca_depto_anticipos.php',{'id_depto':$('#s_deptos').val()},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				
				//alert(JSON.stringify(data));
				$('#t_anticipos tbody').html('');
				for(var i = 1;i<=num;i++){
					var dato = datos[i];
						
					var inp_monto = "<input alt='"+dato.id_trabajador+"' alt1='"+dato.quincena+"' alt2='"+dato.ano+"' alt3='"+dato.id_depto+"' type='text' class='i_monto' name=''  size='10' value='"+dato.monto+"'>";
					
					var html = "<tr class='renglon_anticipo'><td>"+dato.id_trabajador+"</td><td>"+dato.nombre+"</td><td>"+inp_monto+"</td><td>"+dato.autorizado+"</td></tr>";
					
					$('#t_anticipos tbody').append(html);
				}
			});

			
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
	#t_busqueda{
		position: absolute;
		top: 7%;
		left: 5%;
		width: 90%;
		height: 5%;
	}
	#t_anticipos
	{
		position: absolute;
		top: 1%;
		left: 1%;
		width: 98%;
		
	}
	#d_anticipos{
		position: absolute;
		top: 13%;
		left: 5%;
		width: 90%;
		height: 80%;
		background-color: rgba(238,238,238,0.8);
		border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
        overflow: auto;
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
		height: 40%;
		background-color: rgba(238,238,238,0.8);
		border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
        overflow: auto;
	}
	
	#d_titulo{
		position:absolute;
		top:1%;
		right:10%;
		font-size: 25px;
	}
	
</style>
<body>
	<div id="transparencia">
		
	</div>
	
	
		
	<div id="contenido">
		
		<div id="d_titulo">
			ANTICIPOS
		</div>
				
		<table id="t_busqueda" >
		<tr>
			<td>
				Supervisor:
				<select id="s_super">
			
				</select>
			</td>
			<td>
				Departamento:
				<select id="s_deptos">
			
				</select>
			</td>
		</tr>		
		
	</table>
	<div id="d_anticipos">  
		<table id="t_anticipos"  class="table table-striped ">    
			<thead>
				<tr>
					<!-- <td colspan="3">Filtro<input class="ifiltro" tabla='t_anticipos'></td>-->
					<td><button type='button' class='btn btn-primary' id='b_liberar'>Liberar</button></td>
				</tr>
				<tr>
					<td>
						Num. Nomina
					</td>
					<td>
						Nombre
					</td>
					<td>
						Monto
					</td>
					<td>
						Autorizado
					</td>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>		
		</div>
	</div>
	
	
</body>
</html>