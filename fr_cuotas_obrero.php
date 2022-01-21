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
                    <div class="col-sm-12 col-md-5">
                        <div class="titulo_ban">Catálogo de Cuotas Obrero Patronales</div>
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
                <br>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>

                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-10 col-md-10">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="i_razon_social" class="col-md-3 col-form-label requerido">Razón Social</label>
                                <div class="input-group col-sm-12 col-md-7">
                                    <input type="text" id="i_razon_social" name="i_razon_social" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_razon_social" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_salario_diario" class="col-sm-12 col-md-3 col-form-label requerido">Salario Diario </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" id="i_salario_diario" name="i_salario_diario" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_salario_diario_i" class="col-sm-12 col-md-3 col-form-label requerido">Salario Diario Integrado </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" id="i_salario_diario_i" name="i_salario_diario_i" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_cuota_imss" class="col-sm-12 col-md-3 col-form-label requerido">Cuota IMSS </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" id="i_cuota_imss" name="i_cuota_imss" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_cuota_infonavit" class="col-sm-12 col-md-3 col-form-label requerido">Cuota INFONAVIT </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" id="i_cuota_infonavit" name="i_cuota_infonavit" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_sar" class="col-sm-12 col-md-3 col-form-label requerido">SAR </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" id="i_sar" name="i_sar" class="form-control validate[required,custom[number],min[1]]" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_concepto_sueldo" class="col-sm-12 col-md-3 col-form-label">Concepto del sueldo </label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" id="i_concepto_sueldo" name="i_concepto_sueldo" class="form-control" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_inactivo" class="col-sm-3 col-md-3">Inactivo</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                </div>
                                <div class="col-sm-12 col-md-2"></div>
                                <div class="col-sm-12 col-md-5">
                                <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_CUOTAS_OBRERO" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                </div>
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
                    <!--<input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>-->
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_razon_social" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Razones Sociales</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-10">
                    <input type="text" name="i_filtro_razon_social" id="i_filtro_razon_social" alt="renglon_razon_social" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                </div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_razon_social">
                    <thead>
                        <tr class="renglon">
                            <th scope="col">Razón Social</th>
                            <th scope="col">RFC</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    </table>  
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>

<div id="dialog_buscar_cuotas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Cuotas Obrero Patronales</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_cuotas" id="i_filtro_cuotas" class="form-control filtrar_renglones" alt="renglon_cuotas" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cuotas">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Razón Social</th>
                                <th scope="col">Salario Diario</th>
                                <th scope="col">Salario D. Integrado</th>
                                <th scope="col">IMSS</th>
                                <th scope="col">Infonavit</th>
                                <th scope="col">SAR</th>
                                <th scope="col">Concepto del Sueldo</th>
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
    var modulo='CUOTAS_OBRERO';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var salarioDiarioOriginal=0;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
        //muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#ch_inactivo').prop('checked',false).attr('disabled',true);

        $('#b_buscar_razon_social').click(function()
        {
            $('#i_filtro_razon_social').val('');
            muestraModalEmpresasFiscales('renglon_razon_social','t_razon_social tbody','dialog_razon_social');
        });

        $('#t_razon_social').on('click', '.renglon_razon_social', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var idCFDI = $(this).attr('alt3');
            $('#i_razon_social').attr('alt',id).attr('alt2',idCFDI).val(nombre);
            $('#dialog_razon_social').modal('hide');
        });

        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_cuotas').val('');
            $('.renglon_cuotas').remove();

            $('#dialog_buscar_cuotas').modal('show'); 

            muestraCuotasObrero();

        });

        function muestraCuotasObrero(){
            $.ajax({
                type: 'POST',
                url: 'php/cuotas_obrero_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_cuotas').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activo';
                            }
                            
                            var html='<tr class="renglon_cuotas" alt="'+data[i].id+'">\
                                        <td data-label="Razón Social">' + data[i].razon_social+ '</td>\
                                        <td data-label="Salario Diario">' + formatearNumero(data[i].salario_diario)+ '</td>\
                                        <td data-label="Salario D. Integrado">' + formatearNumero(data[i].salario_integrado)+ '</td>\
                                        <td data-label="IMSS">' + formatearNumero(data[i].imss)+ '</td>\
                                        <td data-label="Infonavit">' + formatearNumero(data[i].infonavit)+ '</td>\
                                        <td data-label="SAR">' + formatearNumero(data[i].sar)+ '</td>\
                                        <td data-label="Concepto del Sueldo">' + data[i].concepto+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_cuotas tbody').append(html);     
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/cuotas_obrero_buscar.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar cuota obrero patronal');
                }
            });
        }

        $('#t_cuotas').on('click', '.renglon_cuotas', function() {
            
            tipoMov = 1;
            $('#b_guardar').prop('disabled',false);
            
            id = $(this).attr('alt');
            
            $('#dialog_buscar_cuotas').modal('hide');
            muestraRegistro();
        });



        function muestraRegistro(){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/cuotas_obrero_buscar_id.php',
                dataType:"json", 
                data:{
                    'id':id
                },
                success: function(data) {
                    
                    id=data[0].id;

                    $('#i_razon_social').attr('alt',data[0].id_razon_social).val(data[0].razon_social);
                    $('#i_salario_diario').val(formatearNumero(data[0].salario_diario));
                    $('#i_salario_diario_i').val(formatearNumero(data[0].salario_integrado));
                    $('#i_cuota_imss').val(formatearNumero(data[0].imss));
                    $('#i_cuota_infonavit').val(formatearNumero(data[0].infonavit));
                    $('#i_sar').val(formatearNumero(data[0].sar));
                    $('#i_concepto_sueldo').val(data[0].concepto);
                   
                    salarioDiarioOriginal=quitaComa(data[0].salario_diario);
                    
                    if(data[0].inactivo == 0) 
                    {
                        $('#ch_inactivo').prop('checked', false).attr('disabled',false);
                    } else {
                        $('#ch_inactivo').prop('checked', true).attr('disabled',false);
                    }
                   
                },
                error: function (xhr) {
                    console.log('php/cuotas_obrero_buscar_id.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar cuota obrero patronal');
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
           var info = {
                'idRazonSocial':$('#i_razon_social').attr('alt'),
                'salarioDiario':quitaComa($('#i_salario_diario').val())
           };

        $.ajax({
                type: 'POST',
                url: 'php/cuotas_obrero_verificar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) 
                {
                    if(data == 1)
                    {
                        if (tipoMov == 1 && salarioDiarioOriginal === quitaComa($('#i_salario_diario').val())) 
                        {
                            guardar();
                        } else {
                            mandarMensaje('Ya existe un registro activo con ese salario diario para la razón social. Intenta con otros.');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    console.log('php/cuotas_obrero_verificar.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al verificar cuota obrero patronal');
                    $('#b_guardar').prop('disabled',false);
                }
            });
       }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */
        function guardar(){
            var datos = Array();

            datos ={
                'id':id,
                'idRazonSocial':$('#i_razon_social').attr('alt'),
                'salarioDiario':quitaComa($('#i_salario_diario').val()),
                'salarioDiarioIntegrado':quitaComa($('#i_salario_diario_i').val()),
                'imss':quitaComa($('#i_cuota_imss').val()),
                'infonavit':quitaComa($('#i_cuota_imss').val()),
                'sar':quitaComa($('#i_sar').val()),
                'concepto':$('#i_concepto_sueldo').val(),
                'inactivo':$('#ch_inactivo').is(':checked') ? 1 : 0,
                'tipoMov':tipoMov
            }

            $.ajax({
                type: 'POST',
                url: 'php/cuotas_obrero_guardar.php',  
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

                    console.log('php/cuotas_obrero_guardar.php-->'+ JSON.stringify(xhr));
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

            $('input').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('checked',false).attr('disabled',true);
            id=0;
            tipoMov=0;
            salarioDiarioOriginal=0;
        }
       
        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $("#i_nombre_excel").val('Registros Cuotas Obrero Patronales');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            //$('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });
        
    });

</script>

</html>