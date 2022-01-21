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
    .div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        min-height:250px;
        max-height:250px;
        overflow:auto;
    }
    #pantalla_deudores_diversos,
    #pantalla_pago_deudores{
        position: absolute;
        top:10px;
        left:-101%;
        height: 95%;
    }
    .texto_right{
        text-align:right;
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
    }
    
</style>

<body>
    <div><input id="i_id_sucursal" type="hidden"/></div>
    <div class="container-fluid" id="pantalla_deudores_diversos">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Deudores Diversos</div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="i_filtro" class="col-sm-2 col-md-1 col-form-label">Filtro</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control filtrar_renglones" alt="renglon_deudores" id="i_filtro" name="i_filtro" placeholder="Filtrar" autocomplete="off">
                                    </div>
                                    <div class="col-sm-12 col-md-2"></div>
                                    <div class="col-sm-12 col-md-2">
                                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                    </div>
                                </div>
                                <div class="row form-group" id="div_registros">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon">
                                            <thead>
                                                <tr class="renglon">
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Categoría</th>
                                                    <th scope="col">Importe</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col" width="10%"></th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div id="div_t_registros">
                                            <table class="tablon"  id="t_registros">
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>  
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-5"></div>
                                            <div class="col-sm-12 col-md-1">Total:</div>
                                            <div class="col-sm-12 col-md-2">
                                                <input type="text" id="i_total" name="i_total" class="form-control form-control-sm texto_right" autocomplete="off" readonly>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            <br>
            <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
            </form>
            <h9 style="color:red;"> * Los deudores diversos de categoria VIATICO se deben comprobar en Finanzas Viajes modulo de Viaticos.</h9>
            </div> <!--div_contenedor-->
        </div>      
    </div> <!--pantalla_deudores_diversos-->

    <div class="container-fluid" id="pantalla_pago_deudores">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="titulo_ban">Pago de Deudores Diversos</div>
                    </div>
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <form id="forma" name="forma">
                                    <div class="form-group row">
                                        <label for="i_nombre" class="col-sm-12 col-md-2 col-form-label requerido">Nombre</label>
                                        <div class="input-group col-md-7">
                                            <input type="text" id="i_empleado" name="i_empleado" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_referencia" class="col-sm-12 col-md-2 col-form-label requerido">Referencia</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control validate[required]" id="i_referencia" name="i_referencia" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_importe_d" class="col-sm-12 col-md-2 col-form-label requerido">Importe DD</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control" id="i_importe_d" name="i_importe_d" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_importe_c" class="col-sm-12 col-md-2 col-form-label requerido">Importe Comprobado</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control validate[required,custom[number]] numeroMoneda" id="i_importe_c" name="i_importe_c" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3">
                                            <label for="i_devolucion" class="col-form-label">Devolución</label>
                                            <input type="text" class="form-control validate[custom[number]] numeroMoneda" id="i_devolucion" name="i_devolucion" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-5">
                                            <label for="s_cuenta_banco" class="col-form-label">Cuenta Banco</label>
                                            <select class="form-control" id="s_cuenta_banco" name="s_cuenta_banco" style="width:100%;"></select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="i_fecha_aplicacion" class="col-sm-12 col-md-12 col-form-label">Fecha de aplicación</label>
                                                <div class="input-group col-sm-12 col-md-11">
                                                    <input type="text" name="i_fecha_aplicacion" id="i_fecha_aplicacion" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                                    <div class="input-group-addon input_group_span">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label for="i_descuento" class="col-sm-12 col-md-12 col-form-label">Descuento a Nómina</label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input type="text" class="form-control validate[custom[number]]" id="i_descuento" name="i_descuento" readonly autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label for="i_quincenas" class="col-sm-12 col-md-12 col-form-label">Quincenas</label>
                                                <div class="col-sm-12 col-md-9">
                                                    <input type="text" class="form-control validate[custom[number],min[1]]" id="i_quincenas" name="i_quincenas" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label for="i_fecha_inicio" class="col-sm-12 col-md-12 col-form-label">Fecha Inicio</label>
                                                <div class="input-group col-sm-12 col-md-10">
                                                    <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
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
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-8"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_aplicar"><i class="fa fa-check" aria-hidden="true"></i> Aplicar</button>
                    </div>
                </div>
            <br>
            </div> <!--div_contenedor-->
        </div>      
    </div> <!--pantalla_pago_deudores-->
    
</body>

<div id="dialog_detalles" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle Deudor Diverso: <span id="dato_deudor"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_detalle"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
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
 
    var modulo='DEUDORES_DIVERSOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var idRegistro = 0;
    var tipo = '';
    var idEmpleado = 0;
    var idUnidadNegocio = 0;
    var idSucursal = 0;
    var idArea = 0;
    var idDepartamento = 0;
    var idGasto = 0;
    var idViatico = 0;
    var categoria = '';
    var idFamiliaGasto = 0;
    var idClasificacionGasto = 0;

    $(function(){

        $("#pantalla_deudores_diversos").css({left : "0%"}); 

        mostrarBotonAyuda(modulo);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraDeudoresDiversos();
        //** MGFS 20-12-2019 Muestra solo las cuenta de caja chica issue DEN18-2425 */
        muestraCuentaCajaChica('s_cuenta_banco','');

        function muestraDeudoresDiversos(){
            $('#t_registros tbody').empty();
            var total=0;
            $.ajax({
                type: 'POST',
                url: 'php/deudores_diversos_buscar.php',
                dataType:"json", 
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                            
                            if(data[i].id_gasto != 0)
                            {
                                var boton = '<button type="button" class="btn btn-info btn-sm b_buscar_gasto" alt="'+data[i].id+'" alt2="'+data[i].id_gasto+'">\
                                                    <i class="fa fa-search" aria-hidden="true"></i>\
                                            </button>';
                            }else{
                                var boton = '<button type="button" class="btn btn-success btn-sm" alt="'+data[i].id+'" alt3="'+data[i].id_viatico+'" title="Para comprar ve a menu en Finanzas Viajes -> Viaticos">\
                                                    <i class="fa fa-info" aria-hidden="true"></i>\
                                            </button>';
                            }
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_deudores" total="'+data[i].importe+'">\
                                        <td data-label="Nombre">'+data[i].deudor_diverso+'</td>\
                                        <td data-label="Categoría">'+data[i].categoria+'</td>\
                                        <td data-label="Importe"> '+formatearNumero(data[i].importe)+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td width="10%">\
                                            <button type="button" class="btn btn-secondary btn-sm b_detalle" alt="'+data[i].id+'" gasto="'+data[i].id_gasto+'" viatico="'+data[i].id_viatico+'" tipo="'+data[i].tipo+'">\
                                                <i class="fa fa-eye" aria-hidden="true"></i>\
                                            </button> '+boton+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html);  
                            
                            total=total+parseFloat(data[i].importe);
                            
                        }

                        //$('#i_total').val(formatearNumero(total));
                        calculaTotal();

                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="4">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);

                        $('#i_total').val('');
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/deudores_diversos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar deudores diversos');
                }
            });
        }

        $('#i_filtro').keyup(function(){
            calculaTotal();
        });

        function calculaTotal(){
            var total=0;
            $('.renglon_deudores').each(function(){
                if($(this).css('display')!='none')
                {
                    var valor= parseFloat(quitaComa($(this).attr('total')));

                    total=total+valor;
                }
            });

            $('#i_total').val(formatearNumero(total));
        }

        function muestraDeudorDiversoId(id){
            $.ajax({
                type: 'POST',
                url: 'php/deudores_diversos_buscar_id.php',
                dataType:"json", 
                data:  {'id':id},
                success: function(data) {
                    if(data.length != 0){
                        idEmpleado = data[0].id_empleado;
                        idUnidadNegocio = data[0].id_unidad_negocio;
                        idSucursal = data[0].id_sucursal;
                        idArea = data[0].id_area;
                        idDepartamento = data[0].id_departamento;
                        categoria = data[0].categoria;
                        idFamiliaGasto = data[0].id_familia_gastos;
                        //-->NJES Jan/17/2020 se agrega buscar id_clasificacion_gasto
                        idClasificacionGasto = data[0].id_clasificacion_gasto;
                        
                        $('#i_empleado').val(data[0].deudor_diverso);
                        $('#i_importe_d').val(formatearNumero(data[0].importe));
                    } 

                },
                error: function (xhr) 
                {
                    console.log('php/deudores_diversos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar deudor diverso');
                }
            });
        }

        $('#t_registros').on('click', '.b_buscar_gasto', function() {
            idRegistro = $(this).attr('alt');
            tipo = 'gasto';
            idGasto = $(this).attr('alt2');

            muestraDeudorDiversoId(idRegistro);

            $("#pantalla_deudores_diversos").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_pago_deudores').animate({left : "0%"}, 600, 'swing');
        });

        $('#t_registros').on('click', '.b_buscar_viatico', function() {
            idRegistro = $(this).attr('alt');
            tipo = 'viatico';
            idViatico = $(this).attr('alt3');

            muestraDeudorDiversoId(idRegistro);

            $("#pantalla_deudores_diversos").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_pago_deudores').animate({left : "0%"}, 600, 'swing');
        });

        $('#b_regresar').click(function(){
            muestraDeudoresDiversos();
            $("#pantalla_pago_deudores").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_deudores_diversos').animate({left : "0%"}, 600, 'swing');
        });

        $('#b_aplicar').click(function(){
            $('#b_aplicar').prop('disabled',true);

            if($('#forma').validationEngine('validate'))
            {
                var importeD = $('#i_importe_d').val()=='' ? 0 : $('#i_importe_d').val();
                var importeC = $('#i_importe_c').val()=='' ? 0 : $('#i_importe_c').val();
                var devolucion = $('#i_devolucion').val()=='' ? 0 : $('#i_devolucion').val();
                var descuentoN = $('#i_descuento').val()=='' ? 0 : $('#i_descuento').val();

                //--> suma comprobante ingreso + devolucion + descuento nomina
                var suma = parseFloat(quitaComa(importeC)) + parseFloat(quitaComa(devolucion)) + parseFloat(quitaComa(descuentoN));
            
                if(suma == parseFloat(quitaComa($('#i_importe_d').val())))
                {
                    guardar();
                }else{
                    mandarMensaje('La suma del importe comprobado, devolución y descuento a nómina no puede ser mayor al importe del deudor diverso.');
                    $('#b_aplicar').prop('disabled',false);
                }
            }else{
                $('#b_aplicar').prop('disabled',false);
            }
        });

        $('#i_importe_c,#i_devolucion').change(function(){
            var importeD = $('#i_importe_d').val(); 
            var importeC = $('#i_importe_c').val()==''? 0 : $('#i_importe_c').val();
            var devolucion = $('#i_devolucion').val()==''? 0 : $('#i_devolucion').val();

            var sumaComDev = parseFloat(quitaComa(importeC)) + parseFloat(quitaComa(devolucion));
            
            if(sumaComDev < parseFloat(quitaComa($('#i_importe_d').val())))
            {
                var descuentoNomina = parseFloat(quitaComa($('#i_importe_d').val())) - parseFloat(quitaComa(importeC)) - parseFloat(quitaComa(devolucion));
                //-->NJES March/13/2020 validar que si lleva descuento de nomina la quincena minima sea 1
                $('#i_descuento').val(formatearNumero(descuentoNomina));
                $('#i_quincenas').removeClass('validate[custom[number],min[1]]').addClass('validate[required,custom[number],min[1]]');
                $('#i_fecha_inicio').addClass('validate[required]');
            }else{
                $('#i_descuento').val(''); 
                $('#i_quincenas').val('').removeClass('validate[required,custom[number],min[1]]').addClass('validate[custom[number],min[1]]').validationEngine('hide');
                $('#i_fecha_inicio').val('').removeClass('validate[required]').validationEngine('hide');
            }

            if($('#i_devolucion').val() != '')
            {
                $('#s_cuenta_banco,#i_fecha_aplicacion').addClass('validate[required]');
            }else{
                $('#i_fecha_aplicacion').val('');
                $('#s_cuenta_banco,#i_fecha_aplicacion').removeClass('validate[required]').validationEngine('hide');
            }
        });

        $('#s_cuenta_banco').change(function(){
            if($('#s_cuenta_banco').val() > 0)
            {
                $('#i_devolucion').removeClass('validate[custom[number]]').addClass('validate[required,custom[number]]');
            }else{
                $('#i_devolucion').removeClass('validate[required,custom[number]]').addClass('validate[custom[number]]');
            }
        });

        function guardar(){
            if($('#i_devolucion').val() != '')
                var importe_devolucion = parseFloat(quitaComa($('#i_devolucion').val()));
            else
                var importe_devolucion = 0;

            if($('#i_descuento').val() != '')
                var importe_descuento = parseFloat(quitaComa($('#i_descuento').val()));
            else
                var importe_descuento = 0;

            var info = {
                'idRegistro' : idRegistro,
                'idGasto' : idGasto,
                'idViatico' : idViatico,
                'importeDD' : parseFloat(quitaComa($('#i_importe_d').val())),
                'referencia' : $('#i_referencia').val(),
                'importeC' : parseFloat(quitaComa($('#i_importe_c').val())),
                'devolucion' :  importe_devolucion,
                'idCuentaBanco' :  $('#s_cuenta_banco').val(),
                'tipoCuentaBanco' : $('#s_cuenta_banco option:selected').attr('alt2'),
                'fechaAplicacion' : $('#i_fecha_aplicacion').val(),
                'descuento' : importe_descuento,
                'quincenas' : $('#i_quincenas').val(),
                'tipo' : tipo,
                'idUsuario' : idUsuario, 
                'idEmpleado' : idEmpleado,
                'idUnidadNegocio' : idUnidadNegocio,
                'idSucursal' : idSucursal,
                'idArea' : idArea,
                'idDepartamento' : idDepartamento,
                'empleado' : $('#i_empleado').val(),
                'justificacion' : categoria,
                'fecha_inicio' : $('#i_fecha_inicio').val(),
                'idFamiliaGasto' : idFamiliaGasto,
                //-->NJES Jan/17/2020 se manda guardar id_clasificacion_gasto para movimientos_presupuesto
                'idClasificacionGasto' : idClasificacionGasto
            };

            console.log(JSON.stringify(info));

            $.ajax({
                type: 'POST',
                url: 'php/deudores_diversos_guardar.php',
                data:  {'datos':info},
                success: function(data) {
                    console.log('data '+data);
                    //mandarMensaje(data);
                    if(data > 0 )
                    { 
                        mandarMensaje('Se realizo el proceso correctamente');
                        $('#forma input').val('');
                         //--> MGFS 20-12-2019 Muestra solo las cuenta de caja chica issue DEN18-2425 
                         muestraCuentaCajaChica('s_cuenta_banco','');
                        $('#b_aplicar').prop('disabled',false);
                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_aplicar').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/deudores_diversos_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_aplicar').prop('disabled',false);
                }
            });
        }

        $('#t_registros').on('click', '.b_detalle', function() {
            var id = $(this).attr('alt');
            var tipo = $(this).attr('tipo');
            var idGasto = $(this).attr('gasto');
            var idViatico = $(this).attr('viatico');
            
            if(tipo == 'gasto')
            {
                mostrarDetalleGasto(idGasto);
            }else{
                mostrarDetalleViatico(idViatico);
            }
        });

        function mostrarDetalleGasto(id){
            $.ajax({
                type: 'POST',
                url: 'php/gastos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idGasto':id
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#dato_deudor').text(data[0].nombre);

                        var detalles = '<p><b>Unidad de Negocio:</b> '+data[0].unidad+'</p>';
                            detalles += '<p><b>Sucursal:</b> '+data[0].sucursal+'</p>';
                            detalles += '<p><b>Familia:</b> '+data[0].familia_gastos+'</p>';
                            detalles += '<p><b>Clasificacion:</b> '+data[0].clasificacion_gasto+'</p>';
                            detalles += '<p><b>Área:</b> '+data[0].are+'</p>';
                            detalles += '<p><b>Departamento:</b> '+data[0].departamento+'</p>';
                            if(data[0].id_cuenta_banco > 0)
                            { 
                                detalles += '<p><b>Cuenta Banco:</b> '+data[0].banco+' - '+data[0].cuenta+'</p>';
                            }
                            detalles += '<p><b>Concepto:</b> '+data[0].concepto+'</p>';
                            detalles += '<p><b>Observaciones:</b> '+data[0].observaciones+'</p>';
                            detalles += '<p><b>Monto:</b> $'+formatearNumero(data[0].total)+'</p>';
                            detalles += '<p><b>Nombre:</b> '+data[0].nombre+'</p>';
                            detalles += '<p><b>Proveedor:</b> '+data[0].proveedor+'</p>';

                        $('#div_datos_detalle').html(detalles);

                    }

                    $('#dialog_detalles').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/gastos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar detalle del registro');
                }
            });
        }

        function mostrarDetalleViatico(id){
            $.ajax({
                type: 'POST',
                url: 'php/viaticos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idViatico':id
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#dato_factura').text(data[0].nombre);

                        var detalles = '<p><b>Unidad de Negocio:</b> '+data[0].unidad+'</p>';
                            detalles += '<p><b>Sucursal:</b> '+data[0].sucursal+'</p>';
                            detalles += '<p><b>Área:</b> '+data[0].are+'</p>';
                            detalles += '<p><b>Departamento:</b> '+data[0].departamento+'</p>';
                            detalles += '<p><b>Solicitó:</b> '+data[0].solicito+'</p>';
                            detalles += '<p><b>Destino:</b> '+data[0].destino+'</p>';
                            detalles += '<p><b>Distancia:</b> '+data[0].distancia+'</p>';
                            detalles += '<p><b>Motivos del Viaje:</b> '+data[0].motivos+'</p>';
                            detalles += '<p><b>Del:</b> '+data[0].fecha_inicio+' <b>Al:</b> '+data[0].fecha_fin+'</p>';
                            detalles += '<p><b>Días:</b> '+data[0].dias+' <b>Noches:</b> '+data[0].noches+'</p>';
                            detalles += '<p><b>Monto:</b> $'+formatearNumero(data[0].total)+'</p>';
                            detalles += '<p><b>Autorizó:</b> '+data[0].autorizo+'</p>';
                            detalles += '<p><b>Nombre:</b> '+data[0].empleado+'</p>';

                        $('#div_datos_detalle').html(detalles);

                    }

                    $('#dialog_detalles').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/viaticos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar detalle del registro');
                }
            });
        }


        $('#b_excel').click(function(){

            var datos = {
                'tipo':1  //todos los deudores
            };

            $("#i_nombre_excel").val('Deudores Diversos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>