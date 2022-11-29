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
    <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="vendor/select2/css/select2.css" rel="stylesheet"/>
    <link href="css/general.css" rel="stylesheet"  type="text/css"/>
</head>

<style> 
    body{
        background-color:rgb(238,238,238);
        overflow-x:hidden;

    }
    /* #div_pantalla_saldos,
    #div_pantalla_detalle_cuenta{
        position: absolute;
        top:10px;
        left : -101%;
        height: 95%;
    
    } */
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        max-height:400px;
        overflow:auto;
    }
    .titulo_tabla{
        width:100%;
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: .15em;
        font-weight:bold;
    }
    .tablon {
        font-size: 10px;
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
        #div_principal{
            margin-left:0%;
        }
    }
    
</style>

<body>
    <!-- <div class="container-fluid" id="div_pantalla_saldos">

        <div class="row">
            <div class="col-sm-12 col-md-1"></div>
            <div class="col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reporte Saldos Cuentas</div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                    
                    <div class="col-sm-12 col-md-3">
                        <button type="button" class="btn btn-success btn-sm form-control" alt="BOTON_EXCEL_MOV_BANCOS" id="b_excel_saldos"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Reporte Saldos Cuentas</button>
                    </div>
                </div>

                <div class="form-group row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio_rb" id="i_fecha_inicio_rb" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_fin_rb" id="i_fecha_fin_rb" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div> 
                    <div class="col-md-5">
                        <input type="text" name="i_filtro" id="i_filtro" class="form-control form-control-sm filtrar_renglones" alt="renglon_saldos_cuentas" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>
                <hr><!--linea gris-->

                <!-- <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Banco</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Saldo Fecha Inicio</th>
                                    <th scope="col">Saldo Fecha Fin</th>
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

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

            <br> 
            </div> 
        </div>      

    </div> -->

    <div class="container-fluid" id="div_pantalla_detalle_cuenta">

        <div class="row">
            <div class="col-sm-12 col-md-1"></div>
            <div class="col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes Movimientos Bancos</div>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <!-- <button type="button" class="btn btn-success btn-sm form-control" id="b_regresar"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button> -->
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    
                    <div class="col-sm-12 col-md-3">
                        <button type="button" class="btn btn-success btn-sm form-control"  id="b_excel_movimientos"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Reporte Movimientos Bancos</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <div class="row">
                    <div class="col-md-3">
                    <input type="text" name="i_filtro_detalle" id="i_filtro_detalle" class="form-control form-control-sm filtrar_renglones" alt="renglon_movimientos" placeholder="Filtrar" autocomplete="off">
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control"  id="b_buscar_cuentas"><i class="fa fa-search" aria-hidden="true"></i> Saldos</button>
                    </div>
                    <div class="col-md-6">
                          
                        <div class="form-group row">
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
                <hr><!--linea gris-->

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Folio Orden de Compra</th>
                                    <th scope="col">Folio Requisición</th>
                                    <th scope="col">Aplicación</th>
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Banco</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Movimiento</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Movimiento</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col">Folio Factura</th>
                                    <th scope="col">Folio Pago</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_registros_detalle">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
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
    <div id="dialog_buscar_cuentas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Cuentas Bancos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_cuentas" id="i_filtro_cuentas" class="form-control filtrar_renglones" alt="renglon_cuentas" placeholder="Filtrar" autocomplete="off"></div>
                    </div>    
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon"  id="t_cuentas">
                            <thead>
                                <tr class="renglon">
                                <th scope="col">Cuenta</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Banco</th>
                                <th scope="col">Importe</th>
                                <th scope="col">SaldoInicio</th>
                                <th scope="col">SaldoFin</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            </table>  
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
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
  
    var modulo='REPORTES_BANCOS_TODOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var nombreReporte='';
    var idCuenta = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        // mostrarBotonAyuda(modulo);
        // muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        // fechaHoyServidor('i_fecha_inicio_rb','primerDiaMes');
        // fechaHoyServidor('i_fecha_fin_rb','ultimoDiaMes');

        //fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        //fechaHoyServidor('i_fecha_fin','ultimoDiaMes');

        $('#i_fecha_inicio,#i_fecha_fin').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        //-->NJES July/01/2020 
        // $('#i_fecha_inicio_rb').val(primerDiaMes);
        // $('#i_fecha_fin_rb').val(ultimoDiaMes);

        // $("#div_pantalla_saldos").css({left : "0%"});

        // $('#b_regresar').click(function(){

        //     buscaSaldosCuentasBancos();

        //     $("#div_pantalla_detalle_cuenta").animate({left : "-101%"}, 500, 'swing');
        //     $('#div_pantalla_saldos').animate({left : "0%"}, 600, 'swing');
        //     $('#i_filtro').val('');
        // });

        //-->NJES July/01/2020 
        // $('#i_fecha_inicio_rb').change(function(){
        //     buscaSaldosCuentasBancos();
        // });

        // $('#i_fecha_fin_rb').change(function(){
        //     buscaSaldosCuentasBancos(); 
        // });

        // buscaSaldosCuentasBancos();
        buscaDetalleCuentasBancosTodos();

        // function buscaSaldosCuentasBancos(){
           
        //     $('#t_registros tbody').empty();

        //     $.ajax({
        //         type: 'POST',
        //         url: 'php/movimientos_reportes_buscar.php',
        //         dataType:"json", 
        //         data:{
        //             'fechaInicio':$('#i_fecha_inicio_rb').val(),
        //             'fechaFin':$('#i_fecha_fin_rb').val(),
        //             'saldosCuentas':'TODO'
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             if(data.length != 0){
                
        //                 for(var i=0;data.length>i;i++){
        //                     ///llena la tabla con renglones de registros
        //                     //-->NJES July/01/2020 quitar campo tipo y movimientos y agregar saldo fecha inicio y saldo fecha fin
        //                     var html='<tr class="renglon_saldos_cuentas" alt="'+data[i].id_cuenta_banco+'" alt2="'+data[i].cuenta+'">\
        //                                 <td data-label="Cuenta">'+data[i].cuenta+'</td>\
        //                                 <td data-label="Descripción">'+data[i].descripcion+'</td>\
        //                                 <td data-label="Banco">'+data[i].banco+'</td>\
        //                                 <td data-label="Importe">$'+formatearNumero(data[i].saldo_actual)+'</td>\
        //                                 <td data-label="Saldo Fecha Inicio">$'+formatearNumero(data[i].saldo_fecha_inicio)+'</td>\
        //                                 <td data-label="Saldo Fecha Fin">$'+formatearNumero(data[i].saldo_fecha_fin)+'</td>\
        //                             </tr>';
        //                     ///agrega la tabla creada al div 
        //                     $('#t_registros tbody').append(html); 

        //                 }
        //             }else{
        //                 var html='<tr class="renglon">\
        //                                 <td colspan="7">No se encontró información</td>\
        //                             </tr>';

        //                 $('#t_registros tbody').append(html);
        //             }

        //         },
        //         error: function (xhr) 
        //         {
        //             console.log('php/requisiciones_reportes_buscar.php --> '+JSON.stringify(xhr));
        //             mandarMensaje('* No se encontró información de saldos');
        //         }
        //     });
        // }



        // $(document).on('click','.renglon_saldos_cuentas',function(){
        //     idCuenta = $(this).attr('alt');
        //     cuenta = $(this).attr('alt2');
        //     //$('#i_fecha_inicio').val($('#i_fecha_inicio_rb').val());
        //     //$('#i_fecha_fin').val($('#i_fecha_fin_rb').val());

        //     $('#b_excel_movimientos').attr('alt',idCuenta).attr('alt2',cuenta);
        //     //-->NJES July/01/2020 tomar de inicio las fechas seleccionadas en la primer pantalla
        //     //-->NJES January/26/2021 de inicio buscar sin filtro de fechas, hasta que haga el change en los filtros en la siguiente pantalla
        //     //buscaDetalleCuentasBancos(idCuenta,$('#i_fecha_inicio_rb').val(),$('#i_fecha_fin_rb').val());
        //     buscaDetalleCuentasBancos(idCuenta,'','');
           
        //     $("#div_pantalla_saldos").animate({left : "-101%"}, 500, 'swing');
        //     $('#div_pantalla_detalle_cuenta').animate({left : "0%"}, 600, 'swing');
        // });


                    
        // $('#b_excel_saldos').click(function(){
            
        //     if($('.renglon_saldos_cuentas').length>0){

        //         var datos = {
        //             'fechaInicio':$('#i_fecha_inicio_rb').val(),
        //             'fechaFin':$('#i_fecha_fin_rb').val()
        //         };
                
        //         $("#i_nombre_excel").val('Reporte Saldos Movimientos Bancos');
        //         $("#i_fecha_excel").val($('#i_fecha').val());
        //         $('#i_modulo_excel').val(modulo);
        //         $('#i_datos_excel').val(JSON.stringify(datos));
                
        //         $("#f_imprimir_excel").submit();
        //     }else{
        //         mandarMensaje('No hay información');
        //     }
        // });

///-------------- DETALLES DE LAS CUENTAS Y BUQEDA DE CUENTAS PARA CAMBIAR A OTRA CUENTA------------


        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').val('');
                //buscaDetalleCuentasBancos(idCuenta,$('#i_fecha_inicio').val());
                $('#i_fecha_fin').prop('disabled',false);

                buscaDetalleCuentasBancosTodos();
                
            }
        });

        $('#i_fecha_fin').change(function(){
           
            // buscaDetalleCuentasBancos(idCuenta,$('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            buscaDetalleCuentasBancosTodos();
        });

        

        // function buscaDetalleCuentasBancos(idCuenta,fechaInicio,fechaFin){
           
        //     $('#t_registros_detalle tbody').empty();

        //     $.ajax({
        //         type: 'POST',
        //         url: 'php/movimientos_reportes_buscar.php',
        //         dataType:"json", 
        //         data:{
        //             'fechaInicio':fechaInicio,
        //             'fechaFin':fechaFin,
        //             'idCuenta': idCuenta
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             if(data.length != 0){
                        
        //                 for(var i=0;data.length>i;i++){
        //                     ///llena la tabla con renglones de registros
        //                     //-->NJES October/09/2020 mostrar folio de pago y folio factura para los casos de los movimientos que se generaron al hacer pagos a facturas multiples
        //                     //para que sea mas faci el rastreo de finanzas
        //                     var html='<tr class="renglon_movimientos">\
        //                                 <td data-label="Sucursal">'+data[i].sucursal+'</td>\
        //                                 <td data-label="Folio Orden de Compra">'+data[i].folio_oc+'</td>\
        //                                 <td data-label="Folio Requisición">'+data[i].folio_requi+'</td>\
        //                                 <td data-label="Aplicación">'+data[i].fecha_aplicacion+'</td>\
        //                                 <td data-label="Cuenta">'+data[i].cuenta+'</td>\
        //                                 <td data-label="Descripción">'+data[i].descripcion+'</td>\
        //                                 <td data-label="Banco">'+data[i].banco+'</td>\
        //                                 <td data-label="Importe">$'+formatearNumero(data[i].saldo)+'</td>\
        //                                 <td data-label="Tipo">'+data[i].tipo+'</td>\
        //                                 <td data-label="Movimiento">'+data[i].movimiento+'</td>\
        //                                 <td data-label="Observaciones">'+data[i].observaciones+'</td>\
        //                                 <td data-label="Folio Factura">'+data[i].folio_factura+'</td>\
        //                                 <td data-label="Folio Pago">'+data[i].folio_pago+'</td>\
        //                             </tr>';
        //                     ///agrega la tabla creada al div 
        //                     $('#t_registros_detalle tbody').append(html); 

        //                 }
        //             }else{
        //                 var html='<tr class="renglon">\
        //                                 <td colspan="13">No se encontró información</td>\
        //                             </tr>';

        //                 $('#t_registros_detalle tbody').append(html);
        //             }

        //         },
        //         error: function (xhr) 
        //         {
        //             console.log('php/requisiciones_reportes_buscar.php --> '+JSON.stringify(xhr));
        //             mandarMensaje('* No se encontró información en detalle cuentas');
        //         }
        //     });
        // }

        // //--- BUSCA TODAS LAS CUENTAS----------------
        $('#b_buscar_cuentas').on('click',function(){

            let fechaInicio = $("#i_fecha_inicio").val();
            let fechaFin = $("#i_fecha_fin").val();

            $('#forma').validationEngine('hide');
            $('#i_filtro_cuentas').val('');
            $('.renglon_cuentas').remove();

            $.ajax({

                type: 'POST',
                url: 'php/movimientos_reportes_buscar.php',
                dataType:"json", 
                data:{fechaInicio, fechaFin},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_cuentas').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activa='';
                            
                            if(parseInt(data[i].activa) == 1){

                                activa='Activa';
                            }else{
                                activa='Inactiva';
                            }

                            var html='<tr class="renglon_cuentas" >\
                                        <td data-label="Cuenta">' + data[i].cuenta+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Banco">' + data[i].banco+ '</td>\
                                        <td data-label="Importe">' + data[i].saldo_actual+ '</td>\
                                        <td data-label="SaldoInicio">' + data[i].saldo_fecha_inicio+ '</td>\
                                        <td data-label="SaldoFin">' + data[i].saldo_fecha_fin+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_cuentas tbody').append(html);    
                        }

                        $('#dialog_buscar_cuentas').modal('show');  
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/cuentas_bancos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        // $(document).on('click','.renglon_cuentas',function(){
        //     idCuenta = $(this).attr('alt');
        //     var cuenta = $(this).attr('alt3');
        //     //$('#i_fecha_inicio').val(primerDiaMes);
        //     //$('#i_fecha_fin').val(ultimoDiaMes);

        //     $('#b_excel_movimientos').attr('alt',idCuenta).attr('alt2',cuenta);

        //     buscaDetalleCuentasBancos(idCuenta,$('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        //     $('#dialog_buscar_cuentas').modal('hide'); 
        // });


        $(document).on('click','#b_excel_movimientos',function(){
            
            if($('.renglon_movimientos').length>0){ 

                var datos = {
                    'fechaInicio':$('#i_fecha_inicio').val(),
                    'fechaFin':$('#i_fecha_fin').val()
                };
                
                $("#i_nombre_excel").val('Reporte Movimientos Cuenta Todos');
                $("#i_fecha_excel").val($('#i_fecha').val());
                $('#i_modulo_excel').val(modulo);
                $('#i_datos_excel').val(JSON.stringify(datos));
                
                $("#f_imprimir_excel").submit();
            }else{
                mandarMensaje('No hay información sobre la cuenta:'+cuenta+' ingresar un nuevo rango de fechas');
            }
        });

        function buscaDetalleCuentasBancosTodos(){
            let fechaInicio = $("#i_fecha_inicio").val();
            let fechaFin = $("#i_fecha_fin").val();

            $("#div_pantalla_saldos").animate({left : "-101%"}, 500, 'swing');
            $('#div_pantalla_detalle_cuenta').animate({left : "0%"}, 600, 'swing');

            $('#t_registros_detalle tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/movimientos_reportes_buscar_todos.php',
                dataType:"json", 
                data:{
                    'fechaInicio':fechaInicio,
                    'fechaFin':fechaFin
                },
                success: function(data) {
                    console.log(data);
                    if(data.length != 0){
                        
                        for(var i=0;data.length>i;i++){
                            ///llena la tabla con renglones de registros
                            //-->NJES October/09/2020 mostrar folio de pago y folio factura para los casos de los movimientos que se generaron al hacer pagos a facturas multiples
                            //para que sea mas faci el rastreo de finanzas
                            var html='<tr class="renglon_movimientos">\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Folio Orden de Compra">'+data[i].folio_oc+'</td>\
                                        <td data-label="Folio Requisición">'+data[i].folio_requi+'</td>\
                                        <td data-label="Aplicación">'+data[i].fecha_aplicacion+'</td>\
                                        <td data-label="Cuenta">'+data[i].cuenta+'</td>\
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td data-label="Banco">'+data[i].banco+'</td>\
                                        <td data-label="Importe">$'+formatearNumero(data[i].saldo)+'</td>\
                                        <td data-label="Tipo">'+data[i].tipo+'</td>\
                                        <td data-label="Movimiento">'+data[i].movimiento+'</td>\
                                        <td data-label="Tipo">'+data[i].tipo2+'</td>\
                                        <td data-label="Movimiento">'+data[i].movimiento2+'</td>\
                                        <td data-label="Observaciones">'+data[i].observaciones+'</td>\
                                        <td data-label="Folio Factura">'+data[i].folio_factura+'</td>\
                                        <td data-label="Folio Pago">'+data[i].folio_pago+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_detalle tbody').append(html); 

                        }
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="13">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_detalle tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/requisiciones_reportes_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información en detalle cuentas');
                }
            });
        }

        
    });

</script>

</html>