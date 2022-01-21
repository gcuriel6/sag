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
        overflow-x:hidden;
    }
    .div_contenedor{
        background-color: #ffffff;
    }
    .div_t_registros{
        min-height:280px;
        max-height:280px;
        overflow:auto;
    }
    .tablon {
        font-size: 10px;
    }
    #pantalla_deudores,
    #pantalla_detalle_deudor{
        position: absolute;
        top:10px;
        left:-101%;
        height: 95%;
    }
    #i_total,#i_total_detalle{
        text-align:right;
    }
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        .div_t_registros{
            height:auto;
            overflow:auto;
        }
    }
    
</style>

<body>
    <div><input id="i_id_sucursal" type="hidden"/></div>

    <div class="container-fluid"  id="pantalla_deudores">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes Deudores Diversos</div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5"> 
                                        <div class="row">
                                            <div class="col-md-12"> 
                                                <div class="row">
                                                    <label for="s_id_unidades" class="col-form-label col-md-3">Unidad de Negocio </label>
                                                    <div class="col-md-9">
                                                        <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12"> 
                                                <div class="row">
                                                    <label for="s_id_sucursales" class="col-form-label col-md-3">Sucursal</label>
                                                    <div class="col-md-9">
                                                        <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <input type="checkbox" id="ch_todas" name="ch_todas" value=""> Mostrar todas
                                            </div>
                                            <div class="col-sm-12 col-md-8">
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
                                        <div class="row">
                                            <div class="col-md-8"> 
                                                <input type="text" name="i_filtro_deudores" id="i_filtro_deudores" alt="renglon_deudor" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" width="10%"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_deudores">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-1">
                                        Total
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <input type="text" id="i_total" name="i_total" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div>   <!--pantalla_dash_gastos-->  
    </div>

    <div class="container-fluid"  id="pantalla_detalle_deudor">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reporte Detalle Deudor Diverso</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <label class="col-md-4" id="nombre_deudor"></label>
                    <div class="col-sm-12 col-md-3" id="div_fechas"></div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="i_filtro_dtalle" id="i_filtro_dtalle" alt="renglon_detalle" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-2"></div>
                            <div class="col-sm-12 col-md-2">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_excel2" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar1"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                            </div>
                        </div>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Fecha</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_detalle">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-7"></div>
                                    <div class="col-sm-12 col-md-1">
                                        Total
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <input type="text" id="i_total_detalle" name="i_total_detalle" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div> 
    </div>  <!--pantalla_detalle_deptos-->

    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>
    
</body>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='REPORTES_DD';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var fecha = '';

    $(function(){

        $("#pantalla_deudores").css({left : "0%"}); 

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

        mostrarRegistrosDeudoresDiversos(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario),primerDiaMes,ultimoDiaMes);

        function listaUnidadesNegocioId(datos)
        {
            var lista='';
            if(datos.length > 0)
            {
                for (i = 0; i < datos.length; i++) {
                    lista+=','+datos[i].id_unidad;
                }
            
            }else{
                lista='';
            }
            return lista;
        }

        $('#s_id_unidades').change(function(){
            $('#ch_todas').prop('checked',false)
            muestraSucursalesPermiso('s_id_sucursales',$('#s_id_unidades').val(),modulo,idUsuario);
            $('#s_id_sucursales').prop('disabled',false);
            
            verFechas();
        });

        $('#s_id_sucursales').change(function(){
            verFechas();
        });

        $('#ch_todas').change(function(){
            verFechas();
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio').change(function(){
            verFechas();
        });

        $('#i_fecha_fin').change(function(){
            verFechas();
        });

        $('#b_regresar1').click(function(){
            verFechas();

            $("#pantalla_detalle_deudor").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_deudores').animate({left : "0%"}, 600, 'swing');
        });

        function verFechas(){
            if($('#i_fecha_inicio').val() == '')
            {
                if($("#ch_todas").is(':checked'))
                {
                    $('#s_id_unidades').val('').select2({placeholder: 'Selecciona',
                                                        templateResult: setCurrency,
                                                        templateSelection: setCurrency});
                    $('#s_id_sucursales').val('').select2({placeholder: ''}).prop('disabled',true);

                    mostrarRegistrosDeudoresDiversos(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),primerDiaMes,ultimoDiaMes);
                }else{
                    if($('#s_id_sucursales').val() >= 1)
                    {
                        mostrarRegistrosDeudoresDiversos($('#s_id_unidades').val(),$('#s_id_sucursales').val(),primerDiaMes,ultimoDiaMes);
                        $('#s_id_sucursales').find('option[value="0"]').remove();
                        $('#s_id_sucursales').append('<option value="0">Mostrar Todas</option>');
                    }else{
                        mostrarRegistrosDeudoresDiversos($('#s_id_unidades').val(),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),primerDiaMes,ultimoDiaMes);
                        $('#s_id_sucursales').find('option[value="0"]').remove();
                        $('#s_id_sucursales').append('<option value="0" selected>Mostrar Todas</option>');
                    }
                }
            }else if($('#i_fecha_inicio').val() != '' &&  $('#i_fecha_fin').val() == ''){
                if($("#ch_todas").is(':checked'))
                {
                    $('#s_id_unidades').val('').select2({placeholder: 'Selecciona',
                                                        templateResult: setCurrency,
                                                        templateSelection: setCurrency});
                    $('#s_id_sucursales').val('').select2({placeholder: ''}).prop('disabled',true);

                    mostrarRegistrosDeudoresDiversos(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),$('#i_fecha_inicio').val(),ultimoDiaMes);
                }else{
                    if($('#s_id_sucursales').val() >= 1)
                    {
                        mostrarRegistrosDeudoresDiversos($('#s_id_unidades').val(),$('#s_id_sucursales').val(),$('#i_fecha_inicio').val(),ultimoDiaMes);
                        $('#s_id_sucursales').find('option[value="0"]').remove();
                        $('#s_id_sucursales').append('<option value="0">Mostrar Todas</option>');
                    }else{
                        mostrarRegistrosDeudoresDiversos($('#s_id_unidades').val(),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),$('#i_fecha_inicio').val(),ultimoDiaMes);
                        $('#s_id_sucursales').find('option[value="0"]').remove();
                        $('#s_id_sucursales').append('<option value="0" selected>Mostrar Todas</option>');
                    }
                }
            }else{  //- Tiene las dos fechas
                if($("#ch_todas").is(':checked'))
                {
                    $('#s_id_unidades').val('').select2({placeholder: 'Selecciona',
                                                        templateResult: setCurrency,
                                                        templateSelection: setCurrency});
                    $('#s_id_sucursales').val('').select2({placeholder: ''}).prop('disabled',true);

                    mostrarRegistrosDeudoresDiversos(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),$('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                }else{
                    if($('#s_id_sucursales').val() >= 1)
                    {
                        mostrarRegistrosDeudoresDiversos($('#s_id_unidades').val(),$('#s_id_sucursales').val(),$('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                        $('#s_id_sucursales').find('option[value="0"]').remove();
                        $('#s_id_sucursales').append('<option value="0">Mostrar Todas</option>');
                    }else{
                        mostrarRegistrosDeudoresDiversos($('#s_id_unidades').val(),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),$('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                        $('#s_id_sucursales').find('option[value="0"]').remove();
                        $('#s_id_sucursales').append('<option value="0" selected>Mostrar Todas</option>');
                    }
                }
            }
        }

        function mostrarRegistrosDeudoresDiversos(idUnidadNegocio,idSucursal,fechaInicio,fechaFin){
            $('#i_fecha_inicio').val(fechaInicio);
            $('#i_fecha_fin').val(fechaFin);

            $('.renglon_deudor').remove();
            $('#i_total').val('');
            
            var datos = {
                'idUnidadNegocio' : idUnidadNegocio,
                'idSucursal' : idSucursal,
                'fechaInicio' : fechaInicio,
                'fechaFin' : fechaFin,
                'tipo' : 1   //todos los deudores
            };

            var total=0;
           
            $.ajax({
                type: 'POST',
                url: 'php/deudores_diversos_reportes_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0 && data!=''){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_deudor">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Nombre">'+data[i].deudor_diverso+'</td>\
                                        <td data-label="Importe">$'+formatearNumero(data[i].importe)+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td width="10%"><button type="button" class="btn btn-info btn-sm b_detalle" alt="'+data[i].id_empleado+'" alt2="'+data[i].id_unidad_negocio+'" alt3="'+data[i].id_sucursal+'" alt4="'+data[i].deudor_diverso+'">\
                                                <i class="fa fa-cubes" aria-hidden="true"></i>\
                                            </button></td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_deudores tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].importe));
                        }

                        $('#i_total').val(formatearNumero(total));

                        $('#b_excel').prop('disabled',false);

                    }else{
                        var html='<tr class="renglon_deudor">\
                                        <td colspan="6">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_deudores tbody').append(html);

                        $('#b_excel').prop('disabled',true);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/deudores_diversos_reportes_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Deudores Diversos');
                }
            });
        }

        function mostrarRegistrosDeudoresId(idUnidadNegocio,idSucursal,idEmpleado,empleado){
            $('.renglon_detalle').remove();
            $('#i_total_detalle').val('');
            
            var datos = {
                'idUnidadNegocio' : idUnidadNegocio,
                'idSucursal' : idSucursal,
                'idEmpleado' : idEmpleado,
                'empleado' : empleado,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'tipo' : 2  //detalle deudor
            };

            var total=0;
           
            $.ajax({
                type: 'POST',
                url: 'php/deudores_diversos_reportes_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0 && data!=''){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_detalle">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Tipo">'+data[i].tipo+'</td>\
                                        <td data-label="Descripción">'+data[i].categoria+'</td>\
                                        <td data-label="Importe">$'+formatearNumero(data[i].importe)+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_detalle tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].importe));
                        }

                        $('#i_total_detalle').val(formatearNumero(total));

                        $('#b_excel2').prop('disabled',false).attr({'alt':idUnidadNegocio,'alt2':idSucursal,'alt3':idEmpleado,'alt4':empleado});

                    }else{
                        var html='<tr class="renglon_detalle">\
                                        <td colspan="6">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_detalle tbody').append(html);

                        $('#b_excel2').prop('disabled',true);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/deudores_diversos_reportes_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Detalle de Deudores Diversos');
                }
            });
        }

        $(document).on('click','#t_registros_deudores .b_detalle',function(){
            var idEmpleado = $(this).attr('alt');
            var idUnidadNegocio = $(this).attr('alt2');
            var idSucursal = $(this).attr('alt3');
            var empleado = $(this).attr('alt4');

            $('#nombre_deudor').text(empleado).css('font-weight','bold');
            $('#div_fechas').text('Del: '+$('#i_fecha_inicio').val()+' Al: '+$('#i_fecha_fin').val());

            mostrarRegistrosDeudoresId(idUnidadNegocio,idSucursal,idEmpleado,empleado);

            $("#pantalla_deudores").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_deudor').animate({left : "0%"}, 600, 'swing');
        });

        $('#b_excel').click(function(){

            if($("#ch_todas").is(':checked'))
            {
                var idUnidadNegocio = listaUnidadesNegocioId(matriz);
                var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario);
            }else{
                var idUnidadNegocio = $('#s_id_unidades').val();
                if($('#s_id_sucursales').val() >= 1)
                {
                    var idSucursal = $('#s_id_sucursales').val();
                }else{
                    var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario)
                }
            }

            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'tipo':1  //todos los deudores
            };

            $("#i_nombre_excel").val('Reporte Deudores Diversos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel2').click(function(){

            var datos = {
                'idUnidadNegocio':$(this).attr('alt'),
                'idSucursal':$(this).attr('alt2'),
                'idEmpleado' : $(this).attr('alt3'),
                'empleado' : $(this).attr('alt4'),
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'tipo':2   //detalle deudor
            };

            $("#i_nombre_excel").val('Reporte '+$('#nombre_deudor').text());
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>