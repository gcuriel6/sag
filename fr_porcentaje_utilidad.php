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
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Porcentaje de Utilidad</div>
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

                <div class="row">
                    <div class="col-md-2"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <form id="forma" name="forma">
                                    <div class="form-group row">
                                        <label for="s_id_unidades" class="col-sm-2 col-md-2 col-form-label requerido">Unidad de Negocio </label>
                                        <div class="col-sm-12 col-md-8">
                                            <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="s_id_sucursales" class="col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                                        <div class="col-sm-12 col-md-8">
                                            <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_porcentaje_u" class="col-sm-2 col-md-2 col-form-label requerido">% de Utilidad</label>
                                        <div class="col-sm-12 col-md-4">
                                            <input type="text" id="i_porcentaje_u" name="i_porcentaje_u" class="form-control validate[required,custom[number],min[1]]" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ch_inactivo" class="col-sm-2 col-md-2">Inactivo</label>
                                        <div class="col-sm-10 col-md-2">
                                            <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_PORCENTAJE_UTILIDAD" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_porcentaje_utilidad" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Porcentaje de Utilidad</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_porcentaje" id="i_filtro_porcentaje" class="form-control filtrar_renglones" alt="renglon_porcentaje_utilidad" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_porcentaje_utilidad">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Unidad Negocio</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">% de Utilidad</th>
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
 
    var idPorcentajeUtilidad=0;
    var tipo_mov=0;
    var modulo='PORCENTAJE_UTILIDAD';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUnidadNegocio=0;
    var idSucursalOriginal=0;
    var idUnidadNegocioOriginal=0;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

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
            idUnidadNegocio = $('#s_id_unidades').val();
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
        });

        $('#ch_inactivo').prop('checked',false).attr('disabled',true);

        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_porcentaje').val('');
            $('.renglon_porcentaje_utilidad').remove();

            $.ajax({

                type: 'POST',
                url: 'php/porcentaje_utilidad_buscar.php',
                dataType:"json", 
                data:{'estatus':2,'lista':listaUnidadesNegocioId(matriz)},

                success: function(data) {
                if(data.length != 0){

                        $('.renglon_porcentaje_utilidad').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].activo) == 1){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_porcentaje_utilidad" alt="'+data[i].id+'" alt2="'+data[i].id_unidad_negocio+'">\
                                        <td data-label="Unidad Negocio">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="% de Utilidad">' + data[i].utilidad+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_porcentaje_utilidad tbody').append(html);   
                            $('#dialog_buscar_porcentaje_utilidad').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_porcentaje_utilidad').on('click', '.renglon_porcentaje_utilidad', function() {
            muestraSucursalesPermiso('s_id_sucursales',$(this).attr('alt2'),modulo,idUsuario);
            idPorcentajeUtilidad = $(this).attr('alt');
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#dialog_buscar_porcentaje_utilidad').modal('hide');
            muestraRegistro();
        });

        function muestraRegistro(){ 

            $.ajax({
                type: 'POST',
                url: 'php/porcentaje_utilidad_buscar_id.php',
                dataType:"json", 
                data:{
                    'idPorcentajeUtilidad':idPorcentajeUtilidad
                },
                success: function(data) {

                    idSucursalOriginal=data[0].id_sucursal;
                    idUnidadNegocioOriginal=data[0].id_unidad_negocio;
                    
                    $('#i_porcentaje_u').val(data[0].utilidad);
                    
                    $('#s_id_unidades').val(data[0].id_unidad_negocio);
                    $("#s_id_unidades").select2({
                        templateResult: setCurrency,
                        templateSelection: setCurrency
                    });
                    $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                    if(data[0].id_sucursal != 0)
                    {
                        $('#s_id_sucursales').val(data[0].id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_sucursales').val('');
                        $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
                    }

                    if (data[0].activo == 1) {
                        $('#ch_inactivo').prop('checked', false).attr('disabled',false);
                    } else {
                        $('#ch_inactivo').prop('checked', true).attr('disabled',false);
                    }

                },
                error: function (xhr) {
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#b_guardar').click(function(){

            $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                
                verificar();

            }else{
            
                $('#b_guardar').prop('disabled',false);
            }
        });


        function verificar(){

            $.ajax({
                type: 'POST',
                url: 'php/porcentaje_utilidad_verificar.php',
                dataType:"json", 
                data:  {'id_unidad_negocio':$('#s_id_unidades').val(),
                        'id_sucursal':$('#s_id_sucursales').val()},
                success: function(data) 
                {   
                    if(data == 1){
                        if (tipo_mov == 1 && idUnidadNegocioOriginal === $('#s_id_unidades').val() && idSucursalOriginal === $('#s_id_sucursales').val()) {
                            guardar();
                        } else {
                            mandarMensaje('Ya existe un registro para la unidad: '+ $('#s_id_unidades option:selected').text()+' y sucursal: '+$('#s_id_sucursales option:selected').text()+'. Intenta con otras opciones');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    mandarMensaje('error: '+JSON.stringify(xhr));
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }


        /* funcion que manda a generar la insecion o actualizacion de un registro */
        function guardar(){
            var datos = Array();

            datos ={
                'idPorcentajeUtilidad':idPorcentajeUtilidad,
                'id_unidad_negocio':$('#s_id_unidades').val(),
                'id_sucursal':$('#s_id_sucursales').val(),
                'inactivo':$('#ch_inactivo').is(':checked') ? 0 : 1,
                'utilidad':quitaComa($('#i_porcentaje_u').val()),
                'tipo_mov':tipo_mov
            }

            $.ajax({
                type: 'POST',
                url: 'php/porcentaje_utilidad_guardar.php',  
                dataType: 'json',
                data:{'datos':datos},
                success: function(data)
                {
                    if(data == 1)
                    {
                        if(tipo_mov == 0)
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
                    message ="Ha ocurrido un error.";
                    mandarMensaje(message);
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
            $('.img-flag').css('height','20px'); //Cambia el tamaño de la imagen que se mostrara en el select

            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

            idPorcentajeUtilidad=0;
            tipo_mov=0;
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $("#i_nombre_excel").val('Registros Porcentaje Utilidad');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('PORCENTAJE_UTILIDAD');
            
            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>