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
        min-height:350px;
        max-height:350px;
        overflow:auto;
    }
    .tablon {
        font-size: 10px;
    }
    
    #fondo_cargando
    {
        position: absolute;
        top: 1%;
        background-image:url('imagenes/3.svg');

        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:3%;
        border-radius: 5px;
        z-index:2000;
        display:none;
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


    <div class="container-fluid"  id="pantalla_recibos_clientes"> 
        <div class="row">
            <div class="col-md-12 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes Recibo</div>
                    </div>
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <!--NJES October/21/2020 se agrega filtro sucursal-->
                            <label for="s_id_sucursales_filtro" class="col-sm-2 col-md-1 col-form-label requerido">Sucursal </label>
                            <div class="col-sm-12 col-md-3">
                                <select id="s_id_sucursales_filtro" name="s_id_sucursales_filtro" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                            </div>
                            <div class="col-md-4">
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
                            <div class="col-sm-12 col-md-4">
                                <input type="text" name="i_filtro_clientes" id="i_filtro_clientes" class="form-control filtrar_renglones" alt="renglon_clientes" placeholder="Filtrar" autocomplete="off">
                            </div>
                        </div>
                        <br>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Folio de recibo</th>
                                            <th scope="col">Folio de factura</th>
                                            <th scope="col">Fecha de recibo</th>
                                            <th scope="col">Nombre corto de cliente</th>
                                            <th scope="col">Numero de Cuenta</th>
                                            <th scope="col">Plan</th>
                                            <th scope="col">Venta</th>
                                            <th scope="col">Orden de Servicio</th>
                                            <th scope="col">Observaciones</th>
                                            <th scope="col">Servicio</th>
                                            <th scope="col">Vendedor</th>
                                            <th scope="col">Técnico</th>
                                            <th scope="col">UsuarioCreacion</th>
                                            <th scope="col">Importe CxC</th>
                                            <th scope="col">Importe Factura</th>
                                            <th scope="col">Abonos</th>
                                            <th scope="col">Saldo insoluto</th>
                                            <th scope="col">Importe sin IVA</th>
                                            <th scope="col">Fecha inicio de periodo</th>
                                            <th scope="col">Fecha fin de periodo</th>
                                            <th scope="col">Estatus de CxC</th>
                                            <th scope="col">Justificación de cancelación</th>
                                            <th scope="col">Estatus de facturación</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_clientes">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div>   <!--pantalla_saldos_clientes-->  
    </div>

    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>
    
</body>

<div id="dialog_ver_saldo_multiple" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información y saldo de relación CxC-Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        Folio Factura <input type="text" id="i_folio_factura" name="i_folio_factura" class="form-control form-control-sm"  autocomplete="off" readonly>
                    </div>
                    <div class="col-md-3">
                        Total <input type="text" id="i_total_factura" name="i_total_factura" class="form-control form-control-sm"  autocomplete="off" readonly>
                    </div>
                    <div class="col-md-3">
                        Saldo <input type="text" id="i_saldo_factura" name="i_saldo_factura" class="form-control form-control-sm"  autocomplete="off" readonly>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th colspan="7">Registros CxC de factura</th>
                                </tr>
                                <tr class="renglon">
                                    <th scope="col">ID</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Nombre Corto</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">Operación</th>
                                    <th scope="col">Importe</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros_multiples">
                            <table class="tablon"  id="t_registros_multiples">
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
                <br> 
                <div class="row">
                    <div class="col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th colspan="5">Pagos de factura</th>
                                </tr>
                                <tr class="renglon">
                                    <th scope="col">Folio</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Abonos</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_pagos_multiples">
                            <table class="tablon"  id="t_pagos_multiples">
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div id="fondo_cargando"></div>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='REPORTES_RECIBO';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var fecha = '';

    $(function(){

        $("#pantalla_recibos_clientes").css({left : "0%"});

        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        mostrarBotonAyuda(modulo);
        muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        setTimeout(() => {
            mostrarRecibosAlarmas();
        }, 4000);

        //mostrarRecibosAlarmas();

        $('#i_fecha_inicio').change(function(){
            mostrarRecibosAlarmas();
        });

        $('#i_fecha_fin').change(function(){
            mostrarRecibosAlarmas();
        });

        //-->NJES October/21/2020 se agrega filtro sucursal
        $('#s_id_sucursales_filtro').change(function(){
            mostrarRecibosAlarmas();//mostrarRegistros();
        });

        function mostrarRecibosAlarmas(){
         
            $('.renglon_clientes').remove();
            $('.renglon_registros').remove();
            
            var total=0;

            //-->NJES October/21/2020 se agrega filtro sucursal
            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else{
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);
                idSucursal = idSucursal.replace(/^,/, '');
            }

            //console.log('id sucursal' + idSucursal);

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idSucursal':idSucursal
            };

            $('#fondo_cargando').show();

            $.ajax({
                type: 'POST',
                url: 'php/recibos_alarmas_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0 && data!=''){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){

                            var botonMultiple = '';
                            if(data[i].num_mult_cxc > 1)
                            {
                                botonMultiple = '<button type="button" class="btn btn-success btn-sm b_ver_saldo_multiple" id_factura="'+data[i].id+'" id_cxc="'+data[i].idCxc+'">\
                                                    <i class="fa fa-info" aria-hidden="true"></i>\
                                            </button>';
                            }
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_clientes">\
                                        <td data-label=">Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label=">Folio de recibo">'+data[i].folioRec+'</td>\
                                        <td data-label=">Folio de factura">'+data[i].folioFac+'</td>\
                                        <td data-label="Fecha de recibo">'+data[i].fecha+'</td>\
                                        <td data-label="Nombre corto de cliente">'+data[i].servicio+'</td>\
                                        <td data-label="Numero de Cuenta">'+data[i].cuenta+'</td>\
                                        <td data-label="Plan">'+data[i].plan+'</td>\
                                        <td data-label="Venta">'+data[i].venta+'</td>\
                                        <td data-label="Orden de Servicio">'+data[i].soid+'</td>\
                                        <td data-label="Observaciones">'+data[i].observaciones+'</td>\
                                        <td data-label="Servicio">'+data[i].descServicio+'</td>\
                                        <td data-label="Vendedor">'+data[i].vendedor+'</td>\
                                        <td data-label="Tecnico">'+data[i].tecnico+'</td>\
                                        <td data-label="USuarioCreacion">'+data[i].usuarioCreacion+'</td>\
                                        <td data-label="Importe CxC">'+formatearNumero(data[i].importeCxc)+'</td>\
                                        <td data-label="Importe Factura">'+formatearNumero(data[i].importeFac)+' '+botonMultiple+'</td>\
                                        <td data-label="Abonos">'+formatearNumero(data[i].abono)+'</td>\
                                        <td data-label="Saldo Insoluto">'+formatearNumero(data[i].saldoInsoluto)+'</td>\
                                        <td data-label="Importe sin IVA">'+formatearNumero(data[i].importeSinIvaFac)+'</td>\
                                        <td data-label="Fecha inicio de periodo">'+data[i].fechaInicio+'</td>\
                                        <td data-label="Fecha fin de periodo">'+data[i].fechaFin+'</td>\
                                        <td data-label=">Estatus de CxC">'+data[i].estatusCxc+'</td>\
                                        <td data-label="Justificación de cancelación">'+data[i].justiCanc+'</td>\
                                        <td data-label="Estatus de facturación">'+data[i].estatusFac+'</td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_clientes tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].importe));
                        }

                        $('#b_excel').prop('disabled',false);
                        $('#fondo_cargando').hide();

                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="13">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_clientes tbody').append(html);

                        $('#b_excel').prop('disabled',true);
                        $('#fondo_cargando').hide();

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/recibos_alarmas_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Recibos');
                    $('#fondo_cargando').hide();
                }
            });
        }

        $(document).on('click','.b_ver_saldo_multiple',function(){
            var idFactura = $(this).attr('id_factura');
            $('#t_registros_multiples tbody').empty();
            $('#t_pagos_multiples tbody').empty();
            $('#dialog_ver_saldo_multiple').modal('show');

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_saldo_idFactura_multiple_cxc.php',
                dataType:"json", 
                data:  {'idFactura':idFactura},
                success: function(data) {
                    if(data.length > 0)
                    {
                        $('#i_saldo_factura').val(0).val(formatearNumero(data[0].saldo));
                        $('#i_total_factura').val(0).val(formatearNumero(data[0].cargo_inicial));
                        $('#i_folio_factura').val('').val(data[0].folio);
                    }else{
                        $('#i_saldo_factura').val(0);
                        $('#i_total_factura').val(0);
                        $('#i_folio_factura').val('');
                    }

                    muestraRegistrosMultipleFacturaCxC(idFactura);
                    muestraRegistrosMultipleFacturaAbonos(idFactura);
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_buscar_saldo_idFactura.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar el saldo de la factura.');
                }
            });
            
        });

        function muestraRegistrosMultipleFacturaCxC(idFactura){
            $.ajax({
                type: 'POST',
                url: 'php/cxc_buscar_registros_misma_factura.php',
                dataType:"json", 
                data:  {'idFactura':idFactura},
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_registros_cxc_factura">\
                                        <td data-label="ID">'+data[i].id+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Nombre Corto">'+data[i].nombre_corto+'</td>\
                                        <td data-label="Razón Social">'+data[i].razon_social+'</td>\
                                        <td data-label="Operación">'+data[i].cargo_por+'</td>\
                                        <td data-label="Total">'+formatearNumero(data[i].cargo_inicial)+'</td>\
                                    </tr>';

                            $('#t_registros_multiples tbody').append(html); 
                        }
                    }else{
                        var html='<tr class="renglon_registros_cxc_factura">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_multiples tbody').append(html); 
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxc_buscar_registros_misma_factura.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar los cxc de la factura.');
                }
            });
        }

        function muestraRegistrosMultipleFacturaAbonos(idFactura){
            $.ajax({
                type: 'POST',
                url: 'php/cxc_buscar_abonos_misma_factura.php',
                dataType:"json", 
                data:  {'idFactura':idFactura},
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_registros_pagos_factura">\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Tipo">'+data[i].tipo+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Concepto">'+data[i].concepto+'</td>\
                                        <td data-label="Abonos">'+formatearNumero(data[i].importe_pagado)+'</td>\
                                    </tr>';

                            $('#t_pagos_multiples tbody').append(html); 
                        }
                    }else{
                        var html='<tr class="renglon_registros_pagos_factura">\
                                        <td colspan="5">No se encontró información</td>\
                                    </tr>';

                        $('#t_pagos_multiples tbody').append(html); 
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxc_buscar_abonos_misma_factura.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar los cxc de la factura.');
                }
            });
        }

        function mostrarSaldosFacturasRS(idRazonSocial){
            //--> tipo: 1=saldos clientes  2=saldos razones sociales clientes    3=saldos facturas razón social
            $('.renglon_rs_detalle').remove();
            $('.renglon_registros').remove();
            $('#i_total').val('');

            var total=0;

            var datos = {
                'id':idRazonSocial,
                'tipo':3
            };
           
            $.ajax({
                type: 'POST',
                url: 'php/recivos_alarmas.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_rs_detalle">\
                                        <td data-label="No. Factura">'+data[i].folio+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Total Factura">'+formatearNumero(data[i].total)+'</td>\
                                        <td data-label="Inicio Periodo">'+data[i].fecha_inicio+'</td>\
                                        <td data-label="Fin Periodo">'+data[i].fecha_fin+'</td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_rs_detalle tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].total));
                        }

                        $('#i_total').val(formatearNumero(total));

                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="5">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_rs_detalle tbody').append(html);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/recivos_alarmas.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Detalle Dash Gastos');
                }
            });
        }

        $('#b_excel').click(function(){

            //-->NJES October/21/2020 se agrega filtro sucursal
            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else{
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);
                idSucursal = idSucursal.replace(/^,/, '');
            }

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idSucursal':idSucursal
            };

            $("#i_nombre_excel").val('Recibos Alarmas');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>