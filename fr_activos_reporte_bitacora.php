<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GINTHERCORP</title>
    <!-- Hojas de estilo -->
    <link href="css/css/bootstrap.css" rel="stylesheet"  type="text/css" media="all">
    <link href="css/validationEngine.jquery.css" rel="stylesheet" />
    <link href="css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <link href="css/general.css" rel="stylesheet"  type="text/css"/>
    <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="vendor/select2/css/select2.css" rel="stylesheet"/>
</head>

<style> 
    body{
        background-color:rgb(238,238,238);
    }
    #div_principal{
        padding-top:20px;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        height:330px;
        overflow:auto;
    }
    #dialog_buscar_productos > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    #dialog_buscar_salidas_comodato > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    .boton_eliminar{
        width:50px;
    }
    .leyenda_almacenes{
        float:right; 
        color:green; 
        font-size:13px;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_registros{
            height:auto;
            overflow:auto;
        }
        #dialog_buscar_productos > .modal-lg{
            max-width: 100%;
        }
        #dialog_buscar_salidas_comodato > .modal-lg{
            max-width: 100%;
        }
        .boton_eliminar{
            width:100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <!--<div class="col-md-1"></div>-->
            <div class="col-md-offset-1 col-md-12" id="div_contenedor">
            <br>
                <div class="row form-group">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reporte Activos Fijos Historial de Bitácora</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>
                <form id="forma_salida_comodato" name="forma_salida_comodato">
                    <div class="form-group row"> 
                        <div class="col-sm-12 col-md-1">
                            <label for="s_bitacora_tipo" class="col-sm-12 col-md-12 col-form-label requerido">Tipo </label>
                        </div>
                        <div class="col-md-2">
                            <select id="s_bitacora_tipo" name="s_bitacora_tipo" class="form-control form-control-sm">
                                <option selected="true" disabled="disabled">Selecciona:</option>
                                <option value="Informativo">Informativo</option>
                                <option value="Mantenimiento">Mantenimiento</option>
                                <option value="Siniestro">Siniestro</option>
                                <option value="">Todos</option>
                            </select>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-sm-12 col-md-1">Del: </div>
                                <div class="input-group col-sm-12 col-md-5">
                                    <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                    <div class="input-group-addon input_group_span">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-1">Al: </div>
                                <div class="input-group col-sm-12 col-md-5">
                                    <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                    <div class="input-group-addon input_group_span">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="text" id="i_filtro_1" name="i_filtro_2" alt="i_filtro1" alt2="1" alt3="renglon_registro" alt4="2" class="form-control filtrar_campos_renglones" placeholder="No. Serie" style="font-size:14px;" autocomplete="off">
                                    </th>
                                    <th>
                                        <input type="text" id="i_filtro_2" name="i_filtro_2" alt="i_filtro2" alt2="2" alt3="renglon_registro" alt4="2" class="form-control filtrar_campos_renglones" placeholder="No. Económico" style="font-size:14px;" autocomplete="off">
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr class="renglon">
                                    <th scope="col">No. Serie</th>
                                    <th scope="col">No. Económico</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Folio Requisición</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Kilometraje</th>
                                    <th scope="col">Dictamen de Seguro</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_registros">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>
                    
</body>


<!-- Modal Mostrar PDF -->
<div class="modal fade" id="dialog_archivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
            <h4 class="modal-title" id="label_pdf"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

			</div>
			<div class="modal-body">
        <label style="font-size:10px;">Nota: En caso de reemplazar el archivo y no visualizarse Deshabilitar Cache  <button type="button" class="btn2" id="b__archivo_info" style=""><i class="fa fa-info" aria-hidden="true" style="font-size:9px;"></i></button> </label>
				<div style="width:100%" id="div_archivo"></div>
			</div>

		</div>
	</div>
</div>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='REPORTE_ACTIVOS_BITACORA';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var idSalidaComodato = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        mostrarBotonAyuda(modulo);
        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        }); 

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);
     
        muestraRegistros(primerDiaMes,ultimoDiaMes);

        $('#s_bitacora_tipo').change(function(){
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#i_fecha_inicio').change(function(){
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#i_fecha_fin').change(function(){
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        function muestraRegistros(fechaInicio,fechaFin){

            $('#t_registros tbody').html('');

            $.ajax({
                type: "POST",
                url: "php/activos_bitacora_filtro.php",
                data: {
                    'no_economico':'', 
                    'tipo':$("#s_bitacora_tipo").val(),
                    'fechaInicio' : fechaInicio,
                    'fechaFin' : fechaFin
                },
                dataType: 'json',
                success: function(data){
                    if(data.length>0)
                    {
                        var html = "";
                        for (var i = 0; i < data.length; i++) {
                            actual=data[i];

                            html += "<tr class='renglon_registro'>";
                            html += "<td class='i_filtro1'>" + actual.no_serie + "</td>";
                            html += "<td class='i_filtro2'>" + actual.num_economico + "</td>";
                            html += "<td>" + actual.tipo + "</td>";
                            html += "<td>" + actual.folio_requisicion + "</td>";
                            html += "<td>" + actual.descripcion + "</td>";
                            html += "<td>" + actual.fecha + "</td>";
                            html += "<td>" + actual.kilometraje + "</td>";
                            html += "<td>" + ((actual.tipo=='Siniestro') ? "<button class='btn btn-primary' type='button' id='preview_dictamen' activo='"+actual.id_activo+"' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
                            html += "</tr>";
                        }
                        
                        $("#t_registros tbody").html(html);
                        $('#b_excel').prop('disabled',false);
                    }else{
                        $('#b_excel').prop('disabled',true);
                        var html = "<tr><td colspan='8'>No se encontro información</td></tr>";

                        $("#t_registros tbody").html(html);
                    }
                },
                    error: function (data){
                    console.log("php/activos_bitacora_filtro.php-->"+JSON.stringify(data));
                    mandarMensaje("* Error al buscar activos bitacora");
                }
            });
        }

        $(document).on('click','#preview_dictamen',function(){
            var id = $(this).attr('activo');

            $("#div_archivo").empty();
            $("#div_archivo").val('');

            var ruta='activosPdf/formato_dictamen_seguro_'+id+'.pdf';
            var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
            $('#label_pdf').html('Dictamen de Seguro PDF')
            $.ajax({
                url:ruta,
                type:'HEAD',
                error: function()
                {
                    mandarMensaje('Este activo no contiene archivo PDF guardado');
                },
                success: function()
                {
                    $("#div_archivo").empty();
                    $("#div_archivo").val('');
                    $("#div_archivo").append(fil);
                    $('#dialog_archivo').modal('show');
                }
            });
        });

        $('#b_excel').click(function(){
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();

            var datos = {
                'tipo':$("#s_bitacora_tipo").val(),
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val()
            };
            
            $("#i_nombre_excel").val('Reporte Activos Fijos Historial Bitácora');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>