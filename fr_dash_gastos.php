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
        min-height:250px;
        max-height:250px;
        overflow:auto;
    }
    .tablon {
        font-size: 10px;
    }
    #pantalla_dash_gastos,
    #pantalla_detalle_deptos,
    #pantalla_detalle_gastos{
        position: absolute;
        top:10px;
        left : -101%;
        height: 95%;
    }
    #i_total_gasto,
    #i_total_detalle,
    #i_total{
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

    <div class="container-fluid"  id="pantalla_dash_gastos">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Dash Gastos</div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-8"> 
                                        <div class="row">
                                            <label for="s_id_unidades" class="col-form-label col-md-4">Unidad de Negocio </label>
                                            <div class="col-md-8">
                                                <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" id="ch_todas" name="ch_todas" value=""> Mostrar todas
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8"> 
                                        <div class="row">
                                        <label for="s_id_sucursales" class="col-form-label col-md-4">Sucursal</label>
                                            <div class="col-md-8">
                                                <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-2"></div>
                            <div class="col-sm-12 col-md-8">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Mes/Año</th>
                                            <th scope="col">Total</th>
                                            <th scope="col" width="10%"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_dash">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4"></div>
                                    <div class="col-sm-12 col-md-2">
                                        Total
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="text" id="i_total" name="i_total" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6"></div>
                            <div class="col-sm-12 col-md-5">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div>   <!--pantalla_dash_gastos-->  
    </div>

    <div class="container-fluid"  id="pantalla_detalle_deptos">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Detalle Dash de Gastos</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar1"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4 div_fecha"></div>
                                    <div class="col-md-6" id="div_unidad"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <tbody>
                                        <tr>
                                            <th><input type="text" name="i_filtro_unidades" id="i_filtro_1" alt="filtro_unidad" alt2="1" alt3="renglon_registros_d" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Unidad de Negocio" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_sucursales" id="i_filtro_2" alt="filtro_sucursal" alt2="2" alt3="renglon_registros_d" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Sucursal" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_areas" id="i_filtro_3" alt="filtro_area" alt2="3" alt3="renglon_registros_d" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Área" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_departamentos" id="i_filtro_4" alt2="4" alt3="renglon_registros_d" alt4="4" alt="filtro_departamento" class="filtrar_campos_renglones form-control" placeholder="Departamento" autocomplete="off"></th>
                                            <th></th>
                                            <th width="10%"></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Área</th>
                                            <th scope="col">Departamento</th>
                                            <th scope="col">Total</th>
                                            <th scope="col" width="10%"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_deptos">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-8"></div>
                                    <div class="col-sm-12 col-md-1">
                                        Total
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <input type="text" id="i_total_detalle" name="i_total_detalle" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-8"></div>
                            <div class="col-sm-12 col-md-4">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_excel2" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div> 
    </div>  <!--pantalla_detalle_deptos-->

    <div class="container-fluid" id="pantalla_detalle_gastos">
        <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Detalle Dash de Gastos</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar2"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-3 div_fecha"></div>
                                    <div class="col-md-5" id="div_unidad_g"></div>
                                    <div class="col-md-4" id="div_sucursal_g"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="div_departamento_g"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Fecha Gasto</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Proveedor</th>
                                            <th scope="col">Familia</th>
                                            <th scope="col">Clasificación</th>
                                            <th scope="col">Fecha Ref</th>
                                            <th scope="col">Referencia</th>
                                            <th scope="col">Importe</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_gastos">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9"></div>
                                    <div class="col-sm-12 col-md-1">
                                        Total
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <input type="text" id="i_total_gasto" name="i_total_gasto" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-10"></div>
                            <div class="col-sm-12 col-md-4">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_excel3"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div> 
    </div>  <!--pantalla_detalle_gastos-->

    
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
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='DASH_GASTOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var fecha = '';

    $(function(){

        $("#pantalla_dash_gastos").css({left : "0%"});

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

        mostrarRegistrosDash(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));

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
            mostrarRegistrosDash($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
        });

        $('#s_id_sucursales').change(function(){
            if($('#s_id_sucursales').val() >= 1)
            {
                mostrarRegistrosDash($('#s_id_unidades').val(),$('#s_id_sucursales').val());
                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0" selected>Mostrar Todas</option>');
                mostrarRegistrosDash($('#s_id_unidades').val(),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario));
            }
        });

        $('#ch_todas').change(function(){
            if($("#ch_todas").is(':checked'))
            {
                $('#s_id_unidades').val('').select2({placeholder: 'Selecciona',
                                                    templateResult: setCurrency,
                                                    templateSelection: setCurrency});
                $('#s_id_sucursales').val('').select2({placeholder: ''}).prop('disabled',true);

                mostrarRegistrosDash(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario));
            }else{
                muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
                $('#s_id_sucursales').val('').select2({placeholder: 'Elige una Sucursal'}).prop('disabled',false);
                
                mostrarRegistrosDash(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#b_regresar1').click(function(){
            if($("#ch_todas").is(':checked'))
            {
                mostrarRegistrosDash(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario));
            }else{
                if($('#s_id_sucursales').val() >= 1)
                {
                    mostrarRegistrosDash($('#s_id_unidades').val(),$('#s_id_sucursales').val());
                }else{
                    mostrarRegistrosDash($('#s_id_unidades').val(),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario));
                }
            }
            $("#pantalla_detalle_deptos").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_dash_gastos').animate({left : "0%"}, 600, 'swing');
        });

        $('#b_regresar2').click(function(){
            $("#pantalla_detalle_gastos").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_deptos').animate({left : "0%"}, 600, 'swing');
        });

        function mostrarRegistrosDash(idUnidadNegocio,idSucursal){
            //--> tipo: 1=registros dash  2=registros departamento    3=registros gastos
            $('.renglon_registros').remove();
            $('#i_total').val('');
            
            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'tipo':1
            };

            var total=0;
           
            $.ajax({
                type: 'POST',
                url: 'php/dash_gastos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0 && data!=''){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros">\
                                        <td data-label="Mes/Año">'+data[i].fecha+'</td>\
                                        <td data-label="Total">'+formatearNumero(data[i].total)+'</td>\
                                        <td width="10%"><button type="button" class="btn btn-info btn-sm b_detalle" alt="'+data[i].mes+'" alt2="'+data[i].anio+'" alt3="'+data[i].fecha_c+'">\
                                                <i class="fa fa-cubes" aria-hidden="true"></i>\
                                            </button></td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_dash tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].total));
                        }

                        $('#i_total').val(formatearNumero(total));

                        $('#b_excel').prop('disabled',false);

                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="3">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_dash tbody').append(html);

                        $('#b_excel').prop('disabled',true);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/dash_gastos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Dash Gastos');
                }
            });
        }

        function mostrarRegistrosDetalle(idUnidadNegocio,idSucursal,fecha){
            //--> tipo: 1=registros dash  2=registros departamento    3=registros gastos
            $('.renglon_registros_d').remove();
            $('#i_total_detalle').val('');
           
            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'fecha':fecha,
                'tipo':2
            };

            var total=0;
           
            $.ajax({
                type: 'POST',
                url: 'php/dash_gastos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros_d">\
                                        <td data-label="Unidad de Negocio" class="filtro_unidad">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal" class="filtro_sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Área" class="filtro_area">'+data[i].area+'</td>\
                                        <td data-label="Departamento" class="filtro_departamento">'+data[i].departamento+'</td>\
                                        <td data-label="Total">'+formatearNumero(data[i].total)+'</td>\
                                        <td width="10%"><button type="button" class="btn btn-info btn-sm b_detalle" alt="'+data[i].id_departamento+'" alt4="'+data[i].id_unidad_negocio+'" alt5="'+data[i].id_sucursal+'" alt2="'+data[i].unidad_negocio+'" alt3="'+data[i].sucursal+'" alt6="'+data[i].departamento+'">\
                                                <i class="fa fa-cubes" aria-hidden="true"></i>\
                                            </button></td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_deptos tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].total));
                        }

                        $('#i_total_detalle').val(formatearNumero(total));

                        $('#b_excel2').prop('disabled',false);

                    }else{
                        var html='<tr class="renglon_registros_d">\
                                        <td colspan="6">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_deptos tbody').append(html);

                        $('#b_excel2').prop('disabled',true);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/dash_gastos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Detalle Dash Gastos');
                }
            });
        }

        function mostrarRegistrosDetalleGastos(idUnidadNegocio,idSucursal,fecha,idDepartamento){
            //--> tipo: 1=registros dash  2=registros departamento    3=registros gastos
            $('.renglon_registros_g').remove();
            $('#i_total_gasto').val('');

            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'fecha':fecha,
                'idDepartamento':idDepartamento,
                'tipo':3
            };

            var total=0;
           
            $.ajax({
                type: 'POST',
                url: 'php/dash_gastos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros_g">\
                                        <td data-label="Fecha" class="filtro_area">'+data[i].fecha+'</td>\
                                        <td data-label="Descripción" class="filtro_unidad">'+data[i].descripcion+'</td>\
                                        <td data-label="Proveedor" class="filtro_sucursal">'+data[i].proveedor+'</td>\
                                        <td data-label="Familia" class="filtro_area">'+data[i].familia+'</td>\
                                        <td data-label="Clasificacion" class="filtro_departamento">'+data[i].clasificacion+'</td>\
                                        <td data-label="Fecha Referncia" class="filtro_area">'+data[i].fecha_referencia+'</td>\
                                        <td data-label="Referencia" class="filtro_area">'+data[i].referencia+'</td>\
                                        <td data-label="Importe">'+formatearNumero(data[i].importe)+'</td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_gastos tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].importe));
                        }

                        $('#i_total_gasto').val(formatearNumero(total));

                    }else{
                        var html='<tr class="renglon_registros_g">\
                                        <td colspan="6">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_gastos tbody').append(html);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/dash_gastos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Detalle Dash Gastos');
                }
            });
        }

        $(document).on('click','#t_registros_dash .b_detalle',function(){
            var mes = $(this).attr('alt');
            var anio = $(this).attr('alt2');
            fecha = $(this).attr('alt3');
            var mes_letra = '';

            switch(mes){
                case '1':
                    mes_letra = 'Enero';
                break;
                case '2':
                    mes_letra = 'Febrero';
                break;
                case '3':
                    mes_letra = 'Marzo';
                break;
                case '4':
                    mes_letra = 'Abril';
                break;
                case '5':
                    mes_letra = 'Mayo';
                break;
                case '6':
                    mes_letra = 'Junio';
                break;
                case '7':
                    mes_letra = 'Julio';
                break;
                case '8':
                    mes_letra = 'Agosto';
                break;
                case '9':
                    mes_letra = 'Septiembre';
                break;
                case '10':
                    mes_letra = 'Octubre';
                break;
                case '11':
                    mes_letra = 'Noviembre';
                break;
                default:
                    mes_letra = 'Diciembre';
                break;
            }

            $('.div_fecha').text(mes_letra+' '+anio);

            if($("#ch_todas").is(':checked'))
            {
                mostrarRegistrosDetalle(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),fecha);
            }else{
                if($('#s_id_sucursales').val() >= 1)
                {
                    mostrarRegistrosDetalle($('#s_id_unidades').val(),$('#s_id_sucursales').val(),fecha);
                }else{
                    mostrarRegistrosDetalle($('#s_id_unidades').val(),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),fecha);
                }
            }
            
            if($('#s_id_unidades').val() >= 1)
            {
                $('#div_unidad').text('Unidad de Negocio: '+$('#s_id_unidades option:selected').text());
            }else{
                $('#div_unidad').text('');
            }

            $("#pantalla_dash_gastos").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_deptos').animate({left : "0%"}, 600, 'swing');
        });

        $(document).on('click','#t_registros_deptos .b_detalle',function(){
            var idDepartamento = $(this).attr('alt');
            var idUnidadNegocio = $(this).attr('alt4');
            var idSucursal = $(this).attr('alt5');

            $('#b_excel3').attr({'alt':idUnidadNegocio,'alt2':idSucursal,'alt3':idDepartamento});

            $('#div_unidad_g').text('Unidad de Negocio: '+$(this).attr('alt2'));
            $('#div_sucursal_g').text('Sucursal: '+$(this).attr('alt3'));
            $('#div_departamento_g').text('Departamento: '+$(this).attr('alt6'));

            mostrarRegistrosDetalleGastos(idUnidadNegocio,idSucursal,fecha,idDepartamento);

            $("#pantalla_detalle_deptos").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_gastos').animate({left : "0%"}, 600, 'swing');
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
                'tipo':1
            };

            $("#i_nombre_excel").val('Dash Gastos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('DASH_GASTOS');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel2').click(function(){

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
                'fecha':fecha,
                'tipo':2
            };

            $("#i_nombre_excel").val('Dash Gastos Detalles');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('DASH_GASTOS');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel3').click(function(){

            var idUnidadNegocio = $(this).attr('alt1');
            var idSucursal = $(this).attr('alt2');
            var idDepartamento = $(this).attr('alt3');
           
            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'idDepartamento':idDepartamento,
                'fecha':fecha,
                'tipo':3
            };
            
            $("#i_nombre_excel").val('Dash Gastos Detalles G');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('DASH_GASTOS');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>