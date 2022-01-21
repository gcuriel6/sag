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
    #div_t_montos_nomina{
        height:170px;
        overflow:auto;
    }
    #td_descripcion{
        width:30%;
    }
    #td_clave{
        width:10%;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_montos_nomina{
            height:auto;
            overflow:auto;
        }
        #td_descripcion{
            width:100%;
        }
        #td_clave{
            width:100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-offset-1 col-md-8" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Salarios</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>
                <br><br>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>

                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-10 col-md-10">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="s_id_unidades" class="col-sm-3 col-md-3 col-form-label requerido">Unidad de Negocio </label>
                                <div class="col-sm-12 col-md-5">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="s_id_sucursales" class="col-sm-3 col-md-3 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-12 col-md-5">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="s_id_puesto" class="col-sm-3 col-md-3 col-form-label requerido">Puesto </label>
                                <div class="col-sm-12 col-md-5">
                                    <select id="s_id_puesto" name="s_id_puesto" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            <!--<div class="form-group row">
                                <label for="i_sueldo_mensual" class="col-sm-3 col-md-3 col-form-label requerido">Sueldo Mensual</label>
                                <div class="col-sm-3 col-md-4">
                                    <input type="text" id="i_sueldo_mensual" name="i_sueldo_mensual" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_dispersion" class="col-sm-3 col-md-3 col-form-label requerido">% Dispersión </label>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" id="i_dispersion" name="i_dispersion" class="form-control validate[required,custom[number],min[1]]" autocomplete="off" value="4" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_vacaciones" class="col-sm-12 col-md-4 col-form-label requerido">Vacaciones tomadas en cuenta para cotización </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" id="i_vacaciones" name="i_vacaciones" class="form-control validate[required]" autocomplete="off" value="10" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_sueldo_festivo" class="col-sm-3 col-md-3 col-form-label requerido">Festivo</label>
                                <div class="col-sm-3 col-md-4">
                                    <input type="text" id="i_sueldo_festivo" name="i_sueldo_festivo" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_sueldo_dia31" class="col-sm-3 col-md-3 col-form-label requerido">Día 31</label>
                                <div class="col-sm-3 col-md-4">
                                    <input type="text" id="i_sueldo_dia31" name="i_sueldo_dia31" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_inactivo" class="col-sm-3 col-md-3">Inactivo</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                </div>
                                <div class="col-sm-12 col-md-2"></div>
                                <div class="col-sm-12 col-md-5">
                                <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_SALARIOS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                </div>
                            </div>-->
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group row">
                                        <label for="i_sueldo_mensual" class="col-sm-12 col-md-6 col-form-label requerido">Sueldo Mensual</label>
                                        <div class="col-sm-12 col-md-6">
                                            <input type="text" id="i_sueldo_mensual" name="i_sueldo_mensual" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_dispersion" class="col-sm-12 col-md-6 col-form-label requerido">% Dispersión </label>
                                        <div class="col-sm-12 col-md-4">
                                            <input type="text" id="i_dispersion" name="i_dispersion" class="form-control validate[required,custom[number],min[1]]" autocomplete="off" value="4" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_vacaciones" class="col-sm-12 col-md-7 col-form-label requerido">Vacaciones tomadas en cuenta para cotización </label>
                                        <div class="col-sm-12 col-md-4">
                                            <input type="text" id="i_vacaciones" name="i_vacaciones" class="form-control validate[required]" autocomplete="off" value="10" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group row">
                                        <label for="i_sueldo_festivo" class="col-sm-12 col-md-5 col-form-label requerido">Festivo</label>
                                        <div class="col-sm-12 col-md-6">
                                            <input type="text" id="i_sueldo_festivo" name="i_sueldo_festivo" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_sueldo_dia31" class="col-sm-12 col-md-5 col-form-label requerido">Día 31</label>
                                        <div class="col-sm-12 col-md-6">
                                            <input type="text" id="i_sueldo_dia31" name="i_sueldo_dia31" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ch_inactivo" class="col-sm-3 col-md-3">Inactivo</label>
                                        <div class="col-sm-10 col-md-2">
                                            <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-7"></div>
                                <div class="col-sm-12 col-md-5">
                                <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_SALARIOS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                </div>
                            </div>

                        </form>
                        <div class="col-sm-1 col-md-1"></div>
                    </div>
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_salarios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Salarios</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <label for="s_id_unidades_filtro" class="col-sm-12 col-md-3 col-form-label requerido">Unidad de Negocio </label>
                <div class="col-sm-12 col-md-4">
                    <select id="s_id_unidades_filtro" name="s_id_unidades_filtro" class="form-control" style="width:100%;" autocomplete="off"></select>
                </div>
                <label for="s_id_sucursales_filtro" class="col-sm-12 col-md-2 col-form-label requerido">Sucursal </label>
                <div class="col-sm-12 col-md-3">
                    <select id="s_id_sucursales_filtro" name="s_id_sucursales_filtro" class="form-control" style="width:100%;" autocomplete="off"></select>
                </div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_salarios" id="i_filtro_salarios" class="form-control filtrar_renglones" alt="renglon_salarios" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_salarios">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Unidad Negocio</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Puesto</th>
                                <th scope="col">Sueldo Mensual</th>
                                <th scope="col">Estatus</th>
                            </tr>
                        </thead>
                    <tbody>
                        
                    </tbody>
                    </table>  
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var id=0;
    var tipoMov=0;
    var modulo='SALARIOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUnidadNegocio=0;
    var nombreUnidadN='';
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var sueldoOriginal=0;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraSelectUnidades(matriz,'s_id_unidades_filtro',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
        muestraSelectPuestos('s_id_puesto');
        //muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

       $('#ch_inactivo').prop('checked',false).attr('disabled',true);

        $('#s_id_unidades').change(function(){
            var idUnidadNegocio = $('#s_id_unidades').val();
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
        });

        $('#s_id_unidades_filtro').change(function(){
            var idUnidadNegocio = $('#s_id_unidades_filtro').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadNegocio,modulo,idUsuario);
            var idSucursal = muestraSucursalesPermisoListaId($('#s_id_unidades_filtro').val(),modulo,idUsuario);

            muestraSalarios(idUnidadNegocio,idSucursal);
        });

        $('#s_id_sucursales_filtro').change(function(){
            var idUnidadNegocio = $('#s_id_unidades_filtro').val();
            var idSucursal = $('#s_id_sucursales_filtro').val();

            muestraSalarios(idUnidadNegocio,idSucursal);
        });

        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_salarios').val('');
            $('.renglon_salarios').remove();

            $('#dialog_buscar_salarios').modal('show'); 

            var idUnidadNegocio = $('#s_id_unidades_filtro').val();
            muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadNegocio,modulo,idUsuario);
            var idSucursal = muestraSucursalesPermisoListaId($('#s_id_unidades_filtro').val(),modulo,idUsuario);

            muestraSalarios(idUnidadNegocio,idSucursal);

        });

        function muestraSalarios(idUnidadNegocio,idSucursal){
            $.ajax({
                type: 'POST',
                url: 'php/salarios_buscar.php',
                dataType:"json", 
                data:{'estatus':2,'idUnidadNegocio':idUnidadNegocio,'idSucursal':idSucursal},

                success: function(data) {
                    console.log(data);
                
                if(data.length != 0){

                        $('.renglon_salarios').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activo';
                            }

                            var html='<tr class="renglon_salarios" alt="'+data[i].id+'">\
                                        <td data-label="Unidad Negocio">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Puesto">' + data[i].puesto+ '</td>\
                                        <td data-label="Sueldo Mensual">' + formatearNumero(data[i].sueldo_mensual)+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_salarios tbody').append(html);     
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/salarios_buscar.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar los salarios');
                }
            });
        }

        $('#t_salarios').on('click', '.renglon_salarios', function() {
            
            tipoMov = 1;
            $('#b_guardar').prop('disabled',false);
            
            id = $(this).attr('alt');
            
            $('#dialog_buscar_salarios').modal('hide');
            muestraRegistro();

        });



        function muestraRegistro(){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/salarios_buscar_id.php',
                dataType:"json", 
                data:{
                    'id':id
                },
                success: function(data) {
                    
                    id=data[0].id;

                    if(data[0].id_unidad_negocio > 0){    
                        $('#s_id_unidades').val(data[0].id_unidad_negocio);
                        $('#s_id_unidades').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_unidades').val('');
                        $('#s_id_unidades').select2({placeholder: 'Elige una Unidad Negocio'});
                    }

                    if(data[0].id_sucursal > 0){    
                        $('#s_id_sucursales').val(data[0].id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_sucursales').val('');
                        $('#s_id_sucursales').select2({placeholder: 'Elige una Sucursal'});
                    }

                    if(data[0].id_puesto > 0){    
                        $('#s_id_puesto').val(data[0].id_puesto);
                        $('#s_id_puesto').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_puesto').val('');
                        $('#s_id_puesto').select2({placeholder: 'Elige un Puesto'});
                    }
                   
                    $('#i_sueldo_mensual').val(formatearNumero(data[0].sueldo_mensual));
                    $('#i_dispersion').val(data[0].porcentaje_dispersion);
                    $('#i_sueldo_festivo').val(data[0].sueldo_festivo);
                    $('#i_sueldo_dia31').val(data[0].sueldo_dia31);
                    $('#i_vacaciones').val(data[0].dias_vacaciones);
                    sueldoOriginal=quitaComa(data[0].sueldo_mensual);
                    
                    if (data[0].inactivo == 0) {
                        $('#ch_inactivo').prop('checked', false).attr('disabled',false);
                    } else {
                        $('#ch_inactivo').prop('checked', true).attr('disabled',false);
                    }
                   
                },
                error: function (xhr) {
                  
                    console.log('php/salarios_buscar_id.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar el salario');
                }
            });
        }

        

        $('#b_guardar').click(function(){
           
            $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                
                verificaSalario();

            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });


       function verificaSalario(){
           var info = {
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'idSucursal':$('#s_id_sucursales').val(),
                'idPuesto':$('#s_id_puesto').val(),
                'sueldoMensual':quitaComa($('#i_sueldo_mensual').val())
           };

        $.ajax({
                type: 'POST',
                url: 'php/salarios_verificar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) 
                {
                    if(data == 1)
                    {
                        if (tipoMov == 1 && sueldoOriginal === quitaComa($('#i_sueldo_mensual').val())) 
                        {
                            guardar();
                        } else {
                            mandarMensaje('Ya existe un salario con esos datos. Intenta con otro.');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    console.log('php/salarios_verificar.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al verificar el salario');
                    $('#b_guardar').prop('disabled',false);
                }
            });
       }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */
        function guardar(){
            var datos = Array();

            datos ={
                'id':id,
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'idSucursal':$('#s_id_sucursales').val(),
                'idPuesto':$('#s_id_puesto').val(),
                'sueldoMensual':quitaComa($('#i_sueldo_mensual').val()),
                'sueldoFestivo':quitaComa($('#i_sueldo_festivo').val()),
                'sueldoDia31':quitaComa($('#i_sueldo_dia31').val()),
                'vacaciones':$('#i_vacaciones').val(),
                'dispersion':quitaComa($('#i_dispersion').val()),
                'inactivo':$('#ch_inactivo').is(':checked') ? 1 : 0,
                'tipoMov':tipoMov
            }

            $.ajax({
                type: 'POST',
                url: 'php/salarios_guardar.php',  
                dataType: 'json',
                data:{'datos':datos},
                success: function(data)
                {
                    if(data > 0)
                    {
                        if(tipoMov == 0)
                        {
                            mandarMensaje('Se guardó el nuevo registro');
                            limpiar();
                        }else{
                            mandarMensaje('Se actualizó el registro');
                            limpiar();
                        }
                    }else{
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }
                },
                //si ha ocurrido un error
                error: function(xhr){

                    console.log('php/salarios_guardar.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* Error en el guardado');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

       
        $('#b_nuevo').on('click',function(){
            limpiar();
        });

        /*Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){

            $('input,textarea').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('checked',false).attr('disabled',true);
            $('#s_id_unidades').val(idUnidadActual);
            $("#s_id_unidades").select2({
                templateResult: setCurrency,
                templateSelection: setCurrency
            });
            $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            $('#s_id_puesto').val('');
            $('#s_id_puesto').select2({placeholder: 'Selecciona'});
            id=0;
            tipoMov=0;
            sueldoOriginal=0;
        }

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
       
        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();

            var idUnidadNegocio = listaUnidadesNegocioId(matriz);
            var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario);
                        
            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal
            };
            
            $("#i_nombre_excel").val('Registros Salarios');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('SALARIOS');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });

        $(document).ready(function(){
            $('#i_vacaciones').keypress(function (event){
                return valideKeySoloNumeros(event);
            });
        });

        $(document).ready(function()
        {

            $('#i_sueldo_mensual,#i_sueldo_festivo,#i_sueldo_dia31,#i_dispersion').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });
            
        });
        
    });

</script>

</html>