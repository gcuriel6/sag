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
    #l_ejemplo{
        color:#2DB67C;
        font-size:13px;
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
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Plantilla de Cotización</div>
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
                                        <label for="s_id_unidades" class="col-sm-3 col-md-3 col-form-label requerido">Unidad de Negocio </label>
                                        <div class="col-sm-12 col-md-6">
                                            <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_costo" class="col-sm-3 col-md-3 col-form-label requerido">Secciones</label>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input validate[required]" type="checkbox" name="ch_secciones" value="1" id="ch_elementos">
                                                <label class="form-check-label" for="ch_elementos">
                                                    ELEMENTOS
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input validate[required]" type="checkbox" name="ch_secciones" value="2" id="ch_equipo">
                                                <label class="form-check-label" for="ch_equipo">
                                                    EQUIPO
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input validate[required]" type="checkbox" name="ch_secciones" value="3" id="ch_servicios">
                                                <label class="form-check-label" for="ch_servicios">
                                                    SERVICIOS
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input validate[required]" type="checkbox" name="ch_secciones" value="4" id="ch_vehiculos">
                                                <label class="form-check-label" for="ch_vehiculos">
                                                    VEHÍCULOS
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input validate[required]" type="checkbox" name="ch_secciones" value="5" id="ch_consumibles">
                                                <label class="form-check-label" for="ch_consumibles">
                                                    CONSUMIBLES
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        <label class="col-sm-12 col-md-12" style="background-color: #A3CED7; font-size: 13; font-weight: bold;">ENVÍOS</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-12 col-md-2"></label>
                                        <label class="col-sm-12 col-md-10" id="l_ejemplo">*Si son varios correos, separar por comas. Ej., uno@ejemplo.com,dos@ejemplo.com</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ta_tesoreria" class="col-sm-2 col-md-2 col-form-label">Tesorería</label>
                                        <div class="col-sm-10 col-md-10">
                                            <textarea id="ta_tesoreria" name="ta_tesoreria" rows="3" class="form-control validate[custom[multiEmail]]" placeholder="Ingrese correo(s) electrónico(s)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ta_recursos_humanos" class="col-sm-2 col-md-2 col-form-label">Recursos Humanos</label>
                                        <div class="col-sm-10 col-md-10">
                                            <textarea id="ta_recursos_humanos" name="ta_recursos_humanos" rows="3" class="form-control validate[custom[multiEmail]]" placeholder="Ingrese correo(s) electrónico(s)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ta_operaciones" class="col-sm-2 col-md-2 col-form-label">Operaciones</label>
                                        <div class="col-sm-10 col-md-10">
                                            <textarea id="ta_operaciones" name="ta_operaciones" rows="3" class="form-control validate[custom[multiEmail]]" placeholder="Ingrese correo(s) electrónico(s)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ta_compras" class="col-sm-2 col-md-2 col-form-label">Compras</label>
                                        <div class="col-sm-10 col-md-10">
                                            <textarea id="ta_compras" name="ta_compras" rows="3" class="form-control validate[custom[multiEmail]]" placeholder="Ingrese correo(s) electrónico(s)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ta_activos_fijos" class="col-sm-2 col-md-2 col-form-label">Activos Fijos</label>
                                        <div class="col-sm-10 col-md-10">
                                            <textarea id="ta_activos_fijos" name="ta_activos_fijos" rows="3" class="form-control validate[custom[multiEmail]]" placeholder="Ingrese correo(s) electrónico(s)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ta_comercial" class="col-sm-2 col-md-2 col-form-label">Comercial</label>
                                        <div class="col-sm-10 col-md-10">
                                            <textarea id="ta_comercial" name="ta_comercial" rows="3" class="form-control validate[custom[multiEmail]]" placeholder="Ingrese correo(s) electrónico(s)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ta_contraloria" class="col-sm-2 col-md-2 col-form-label">Contraloría</label>
                                        <div class="col-sm-10 col-md-10">
                                            <textarea id="ta_contraloria" name="ta_contraloria" rows="3" class="form-control validate[custom[multiEmail]]" placeholder="Ingrese correo(s) electrónico(s)"></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <label for="ch_activo" class="col-sm-2 col-md-2">Activo</label>
                                        <div class="col-sm-10 col-md-2">
                                            <input type="checkbox" id="ch_activo" name="ch_activo" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-12 col-md-12" id="l_ejemplo">
                                        * Asi es como se le da formato al texto, las estiquetas van sin espacio:<br>
                                        </label>
                                        <label class="col-sm-12 col-md-4" id="l_ejemplo">
                                            &lt;b&gt;... &lt;/b&gt;texto en negrita<br>
                                            &lt;i&gt; … &lt;/i&gt;  texto en cursiva<br>
                                            &lt;u&gt; … &lt;/u&gt;  texto en subrayado<br>
                                            &lt;center&gt;…&lt;/center&gt;  texto centrado <br>
                                        </label>
                                        <label class="col-sm-12 col-md-4" id="l_ejemplo">
                                            [    $nivel sin biñeta<br>
                                            |    $nivel con biñeta a<br>
                                            ||   doble $nivel con biñeta b <br>
                                            [|   $nivel con biñeta a <br>
                                            [||  doble $nivel con biñeta b <br>
                                        </label>
                                    </div>
                                    <div class="form-group row">
                                       
                                        <label for="ta_texto_inicio" class="col-sm-2 col-md-2 col-form-label">Texto Inicio</label>
                                        <div class="col-sm-12 col-md-12">
                                            <textarea id="ta_texto_inicio" name="ta_texto_inicio" rows="10" class="form-control validate[required]" placeholder="Ingresa el texto inicio"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">    
                                        <label for="ta_texto_fin" class="col-sm-2 col-md-2 col-form-label">Texto Fin</label>
                                        <div class="col-sm-12 col-md-12">
                                            <textarea id="ta_texto_fin" name="ta_texto_fin" rows="10" class="form-control validate[required]" placeholder="Ingresa el texto fin"></textarea>
                                    
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
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_PLANTILLAS_COTIZACIONES" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
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

<div id="dialog_buscar_plantillas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Plantillas de Cotización</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_plantilla" id="i_filtro_plantilla" class="form-control filtrar_renglones"  alt="renglon_plantilla" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_plantillas">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Unidad Negocio</th>
                                <th scope="col">Elementos</th>
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
    var modulo='PLANTILLAS_COTIZACIONES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUnidadNegocio=0;
    var idSucursalOriginal=0;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        
        $('#s_id_unidades').change(function(){
            idUnidadNegocio = $('#s_id_unidades').val();
        });

        $('#ch_activo').prop('checked',true).attr('disabled',true);

        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_plantilla').val('');
            $('.renglon_plantilla').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/plantillas_cotizaciones_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_plantilla').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].activo) == 1){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_plantilla" alt="'+data[i].id+'">\
                                        <td data-label="Unidad Negocio">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="Secciones">' + data[i].secciones+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_plantillas tbody').append(html);   
                            $('#dialog_buscar_plantillas').modal('show');   
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

        $('#t_plantillas').on('click', '.renglon_plantilla', function() {
            
            tipoMov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_activo').prop('disabled',false);
        
            id = $(this).attr('alt');
            
            $('#dialog_buscar_plantillas').modal('hide');
            muestraRegistro();


        });



        function muestraRegistro(){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/plantillas_cotizaciones_buscar_id.php',
                dataType:"json", 
                data:{
                    'id':id
                },
                success: function(data) {

                    id=data[0].id;

                    $('#s_id_unidades').val(data[0].id_unidad_negocio);
                    $("#s_id_unidades").select2({
                        templateResult: setCurrency,
                        templateSelection: setCurrency
                    });
                    $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                    idUnidadOriginal=data[0].id_unidad_negocio;
                    if (data[0].elementos == 0) {
                        $('#ch_elementos').prop('checked', false);
                    } else {
                        $('#ch_elementos').prop('checked', true);
                    }

                    if (data[0].equipo == 0) {
                        $('#ch_equipo').prop('checked', false);
                    } else {
                        $('#ch_equipo').prop('checked', true);
                    }

                    if (data[0].servicios == 0) {
                        $('#ch_servicios').prop('checked', false);
                    } else {
                        $('#ch_servicios').prop('checked', true);
                    }

                    if (data[0].vehiculos == 0) {
                        $('#ch_vehiculos').prop('checked', false);
                    } else {
                        $('#ch_vehiculos').prop('checked', true);
                    }

                    if (data[0].consumibles == 0) {
                        $('#ch_consumibles').prop('checked', false);
                    } else {
                        $('#ch_consumibles').prop('checked', true);
                    }
    
                    $('#ta_tesoreria').val(data[0].tesoreria);
                    $('#ta_recursos_humanos').val(data[0].recursos_humanos);
                    $('#ta_operaciones').val(data[0].operaciones);
                    $('#ta_compras').val(data[0].compras);
                    $('#ta_activos_fijos').val(data[0].activos_fijos);
                    $('#ta_comercial').val(data[0].comercial);
                    $('#ta_contraloria').val(data[0].contraloria);

                    
                    if (data[0].activo == 0) {
                        $('#ch_activo').prop('checked', false);
                    } else {
                        $('#ch_activo').prop('checked', true);
                    }

                    $('#ta_texto_inicio').val(data[0].texto_inicio);
                    $('#ta_texto_fin').val(data[0].texto_fin);
                   
                },
                error: function (xhr) {
                    mandarMensaje(xhr.responseText);
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
                url: 'php/plantillas_cotizaciones_verificar.php',
                dataType:"json", 
                data:  {'idUnidadNegocio':$('#s_id_unidades').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipoMov == 1 && idUnidadOriginal === $('#s_id_unidades').val()) {
                            guardar();
                        } else {

                            mandarMensaje('La unidad de Negocio: '+ $('#s_id_unidades option:selected').text()+' ya tiene una plantilla intenta con otra, o puedes buscar su información para editarla');
                            $('#s_id_unidades').val('');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    mandarMensaje(JSON.stringify(xhr));
                    //mandarMensaje(xhr.responseText);
                }
            });
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

         $.ajax({
                type: 'POST',
                url: 'php/plantillas_cotizaciones_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                  console.log(data);
                        if (data > 0 ) {
                            if (tipoMov == 0){
                            
                                mandarMensaje('Se guardó el nuevo registro');
                                $('#b_nuevo').click();
    
                            }else{
                                
                                mandarMensaje('Se actualizó el registro');
                                $('#b_nuevo').click();
                               
                            }
                      

                        }else{
                           
                            mandarMensaje('Error en el guardado');
                            $('#b_guardar').prop('disabled',false);
                        }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log(JSON.stringify(xhr));
                    mandarMensaje("Ha ocurrido un error.");
                    $('#b_guardar').prop('disabled',false);
                }
            });
           
        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
                var paq = {
                    'tipoMov' : tipoMov,
                    'id' : id,
                    'idUnidadNegocio' : $('#s_id_unidades').val(),
                    'elementos' : $("#ch_elementos").is(':checked') ? 1 : 0,
                    'vehiculos' : $("#ch_vehiculos").is(':checked') ? 1 : 0,
                    'servicios' : $("#ch_servicios").is(':checked') ? 1 : 0,
                    'equipo' : $("#ch_equipo").is(':checked') ? 1 : 0,
                    'consumibles' : $("#ch_consumibles").is(':checked') ? 1 : 0,
                    'tesoreria' : $('#ta_tesoreria').val(),
                    'operaciones' : $('#ta_operaciones').val(),
                    'compras' : $('#ta_compras').val(),
                    'recursosHumanos' : $('#ta_recursos_humanos').val(),
                    'activosFijos' : $('#ta_activos_fijos').val(),
                    'comercial' : $('#ta_comercial').val(),
                    'contraloria' : $('#ta_contraloria').val(),
                    'activo' : $("#ch_activo").is(':checked') ? 1 : 0,
                    'textoInicio' : $('#ta_texto_inicio').val(),
                    'textoFin' : $('#ta_texto_fin').val()
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
       

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
            
            id=0;
            usuarioOriginal='';
            tipoMov=0;
            $('input,textarea').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('input').prop('checked', false);
            $('#ch_activo').prop('checked',true).attr('disabled',true);
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            
        }


        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Plantillas Cotizaciones');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('PLANTILLAS_COTIZACIONES');
            
            $("#f_imprimir_excel").submit();
        });


    });

</script>

</html>