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
    body{
        background-color:rgb(238,238,238);
    }
    #div_contenedor{
        background-color: #ffffff;
        padding-bottom:10px;
    }
    .div_contenedor_tabla{
        max-height:180px;
        min-height:180px;
        overflow:auto;
        border: 1px solid #ddd;
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
    #forma{
        border: 1px solid #ddd;
        padding:0px 5px 20px 5px;
    }
    #i_total_vencido,
    #i_total_siguiente,
    #i_total_semana{
        text-align:right;
    }
    .td_ch{
        width:3%;
    }
    .th_pagar{
        width:13%;
    }
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        .div_contenedor_tabla{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
        .td_ch{
            width:100%;
        }
        .th_pagar{
            width:100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-12" id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Seguimiento a Cobranza</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <label class="col-md-2"><b>Tipo: </b></label>
                            <div class="col-sm-12 col-md-2">
                                <input type="radio" name="radio_tipo" id="r_cxc" value="0" alt="CXC" checked> CxC  
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <input type="radio" name="radio_tipo" id="r_pue" value="1" alt="PUE"> Facturas_PUE
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <input type="radio" name="radio_tipo" id="r_ppd" value="2" alt="PPD"> Factras PPD  
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <label class="col-md-3"><b>Ordenar: </b></label>
                            <div class="col-sm-12 col-md-4">
                                <input type="radio" name="radio_ordenar" id="r_cliente" value="0" checked> Cliente  
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <input type="radio" name="radio_ordenar" id="r_vencimiento" value="1"> Vencimiento
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                
                <form id="forma" name="forma">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="s_concepto" class="col-form-label">Concepto </label>
                            <select id="s_concepto" name="s_concepto" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-3">
                            <label for="s_forma_pago" class="col-form-label">Forma de Pago </label>
                            <select id="s_forma_pago" name="s_forma_pago" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="s_cuenta_banco" class="col-form-label">Banco </label>
                            <select id="s_cuenta_banco" name="s_cuenta_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-2">
                            <label for="i_importe" class="col-form-label">Importe</label>
                            <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="i_cuenta_banco_cliente" class="col-form-label">Banco del Cliente </label>
                            <input type="text" id="i_cuenta_banco_cliente" name="i_cuenta_banco_cliente" class="form-control form-control-sm validate[required]"  autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <label for="i_cuenta_cliente" class="col-form-label">Cuenta del Cliente</label>
                            <input type="text" id="i_cuenta_cliente" name="i_cuenta_cliente" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <label for="i_fecha" class="col-md-12 col-form-label">Fecha de Applicación</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                    <div class="input-group-addon input_group_span">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                        </div>
                    </div>
                </form>

                <br>

                <div id="accordion">
                    <div class="card" id="div_card_semana"> <!--div_card_elementos inicio-->
                        <div class="card-header" role="tab" id="heading_semana">
                            <h5 class="mb-0 row">
                                <div class="col-md-3">
                                    <a data-toggle="collapse" href="#collapse_semana" aria-expanded="true" aria-controls="collapse_semana">Por Cobrar en la Semana </a>
                                </div>
                            </h5>
                        </div>

                        <div id="collapse_semana" class="collapse show" role="tabpanel" aria-labelledby="heading_semana" data-parent="#accordion">
                            <div class="card-body" style="padding:0px;">
                                <div class="row" id="div_semana">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="titulo_tabla">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    <input type="text" id="i_filtro_semana" name="i_filtro_semana" alt="renglon_semana" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                                </div>
                                                <div class="col-md-4"><h6><span class="badge badge-default">* Debes seleccionar folios de la misma Razón Social</span></h6></div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="tablon">
                                            <thead>
                                                <tr class="renglon">
                                                    <th scope="col">Unidad de Negocio</th>
                                                    <th scope="col">Sucursal</th>
                                                    <th scope="col">Cliente</th>
                                                    <th scope="col">Razón Social</th>
                                                    <th scope="col">Folio</th>
                                                    <th scope="col">Vencimiento</th>
                                                    <th scope="col" class="fecha_hide">Inicio Periodo</th>
                                                    <th scope="col" class="fecha_hide">Fin Periodo</th>
                                                    <th scope="col">Cargos</th>
                                                    <th scope="col">Abonos</th>
                                                    <th scope="col">Saldo</th>
                                                    <th scope="col" class="th_pagar">Pagar</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="div_contenedor_tabla">
                                            <table class="tablon"  id="t_semana">
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>  
                                        </div>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9"></div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="row">
                                            <label for="i_total_semana" class="col-form-label col-md-4" style="text-align:center;"><strong>Total</strong></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" id="i_total_semana" name="i_total_semana" class="form-control form-control-sm" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card" id="div_card_por_siguiente"> <!--div_card_elementos inicio-->
                        <div class="card-header" role="tab" id="heading_por_siguiente">
                            <h5 class="mb-0 row">
                                <div class="col-md-3">
                                    <a data-toggle="collapse" href="#collapse_por_siguiente" aria-expanded="true" aria-controls="collapse_por_vencer">Por Cobrar la Siguiente Semana </a>
                                </div>
                            </h5>
                        </div>

                        <div id="collapse_por_siguiente" class="collapse" role="tabpanel" aria-labelledby="heading_por_siguiente" data-parent="#accordion">
                            <div class="card-body" style="padding:0px;">
                                <div class="row" id="div_por_vencer">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="titulo_tabla">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    <input type="text" id="i_filtro_siguiente" name="i_filtro_siguiente" alt="renglon_siguiente" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-success btn-sm form-control" id="b_excel2"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="tablon">
                                            <thead>
                                                <tr class="renglon">
                                                    <th scope="col">Unidad de Negocio</th>
                                                    <th scope="col">Sucursal</th>
                                                    <th scope="col">Cliente</th>
                                                    <th scope="col">Razón Social</th>
                                                    <th scope="col">Folio</th>
                                                    <th scope="col">Vencimiento</th>
                                                    <th scope="col" class="fecha_hide">Inicio Periodo</th>
                                                    <th scope="col" class="fecha_hide">Fin Periodo</th>
                                                    <th scope="col">Cargos</th>
                                                    <th scope="col">Abonos</th>
                                                    <th scope="col">Saldo</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="div_contenedor_tabla">
                                            <table class="tablon"  id="t_por_siguiente">
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>  
                                        </div>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9"></div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="row">
                                            <label for="i_total_siguiente" class="col-form-label col-md-4" style="text-align:center;"><strong>Total</strong></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" id="i_total_siguiente" name="i_total_siguiente" class="form-control form-control-sm" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="div_card_vencido"> <!--div_card_elementos inicio-->
                        <div class="card-header" role="tab" id="heading_vencido">
                            <h5 class="mb-0 row">
                                <div class="col-md-3">
                                    <a data-toggle="collapse" href="#collapse_vencido" aria-expanded="true" aria-controls="collapse_vencido">Sin Cobrar </a>
                                </div>
                            </h5>
                        </div>

                        <div id="collapse_vencido" class="collapse" role="tabpanel" aria-labelledby="heading_vencido" data-parent="#accordion">
                            <div class="card-body" style="padding:0px;">
                                <div class="row" id="div_vencido">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="titulo_tabla">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    <input type="text" id="i_filtro_vencido" name="i_filtro_vencido" alt="renglon_vencido" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-success btn-sm form-control" id="b_excel3"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="tablon">
                                            <thead>
                                                <tr class="renglon">
                                                    <th scope="col">Unidad de Negocio</th>
                                                    <th scope="col">Sucursal</th>
                                                    <th scope="col">Cliente</th>
                                                    <th scope="col">Razón Social</th>
                                                    <th scope="col">Folio</th>
                                                    <th scope="col">Vencimiento</th>
                                                    <th scope="col" class="fecha_hide">Inicio Periodo</th>
                                                    <th scope="col" class="fecha_hide">Fin Periodo</th>
                                                    <th scope="col">Cargos</th>
                                                    <th scope="col">Abonos</th>
                                                    <th scope="col">Saldo</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="div_contenedor_tabla">
                                            <table class="tablon"  id="t_vencido">
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>  
                                        </div>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9"></div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="row">
                                            <label for="i_total_vencido" class="col-form-label col-md-4" style="text-align:center;"><strong>Total</strong></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" id="i_total_vencido" name="i_total_vencido" class="form-control form-control-sm" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

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
  
    var modulo='COBRANZA_SEGUIMIENTO';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        $('.fecha_hide').hide();

        mostrarBotonAyuda(modulo);
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        muestraCuentasBancos('s_cuenta_banco', 0,0,idUnidadActual);
        muestraConceptosCxPAbonos('s_concepto');
        muestraFormaPago();
        verificaRadioOrden();

        function muestraFormaPago(){
            if($('#r_pue').is(':checked'))
            {
                $('.fecha_hide').show();
                muestraSelectFormaPago('PUE','s_forma_pago');
                $('#s_forma_pago').addClass('validate[required]').prop('disabled',false);
            }else if($('#r_ppd').is(':checked'))
            {
                $('.fecha_hide').show();
                muestraSelectFormaPago('PUE','s_forma_pago');
                $('#s_forma_pago').addClass('validate[required]').prop('disabled',false);
            }else{
                $('.fecha_hide').hide();
                $('#s_forma_pago').removeClass('validate[required]').prop('disabled',true);
            }
        }

        $('input[name=radio_tipo]').change(function(){
            muestraFormaPago();
            verificaRadioOrden();
        });
        
        $('input[name=radio_ordenar]').change(function(){
            $('#i_importe').val('');
            verificaRadioOrden();
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#s_cuenta_banco').change(function(){
            var idCuentaBanco = $('#s_cuenta_banco').val();
            var tipo = $('#s_cuenta_banco option:selected').attr('alt2');
            var idSucursal = $('#s_cuenta_banco option:selected').attr('alt3');
           
            if(tipo == 0)
            {
                $('#s_concepto').prop('disabled',false);
            }else{
                $('#s_concepto').val(7).select2({placeholder: $(this).data('elemento')}).prop('disabled',true);
            }
        });

        function verificaRadioOrden(){
            if($("#r_cliente").is(':checked')) 
            {
                muestraRegistrosSemana($("#r_cliente").val());
                muestraRegistrosSiguiente($("#r_cliente").val());
                muestraRegistrosVencidos($('#r_vencimiento').val());
            }else{
                muestraRegistrosSemana($('#r_vencimiento').val());
                muestraRegistrosSiguiente($('#r_vencimiento').val());
                muestraRegistrosVencidos($('#r_vencimiento').val());
            }
        }

        function muestraRegistrosSemana(ordenar){

            var info = {
                'tipo':$('input[name=radio_tipo]:checked').val(),
                'orden':ordenar,
                'tabla':'semana'
            };

            $('#t_semana tbody').empty();
            $('#t_semana tbody').html('');
            $('#i_total_semana').val('');

            $.ajax({
                type: 'POST',
                url: 'php/cobranza_buscar.php',
                dataType:"json", 
                data:{'datos':info},
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            var columnaFechaInicio = '';
                            var columnaFechaFin = '';

                            if($('input[name=radio_tipo]:checked').attr('alt') != 'CXC')
                            {
                                $('.th_pagar').css('width','11%');
                                columnaFechaInicio = '<td data-label="Inicio Periodo" class="fecha_hide">'+data[i].fecha_inicio+'</td>';
                                columnaFechaFin = '<td data-label="Fin Periodo" class="fecha_hide">'+data[i].fecha_fin+'</td>';
                            }else
                                $('.th_pagar').css('width','13%');

                            var html='<tr class="renglon_semana" alt="'+data[i].id+'">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Cliente">'+data[i].cliente+'</td>\
                                        <td data-label="Razón Social">'+data[i].razon_social+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Vencimiento">'+data[i].vencimiento+'</td>'+columnaFechaInicio+' '+columnaFechaFin+'\
                                        <td data-label="Cargos">'+formatearNumero(data[i].cargos)+'</td>\
                                        <td data-label="Abonos">'+formatearNumero(data[i].abonos)+'</td>\
                                        <td data-label="Saldo" class="semana_saldo" alt="'+data[i].saldo+'">'+formatearNumero(data[i].saldo)+'</td>\
                                        <td class="td_ch">\
                                            <input type="checkbox" class="ch_pagar" name="ch_pagar" value="'+data[i].id+'" alt="'+data[i].saldo+'" razon_social="'+data[i].id_razon_social+'" tipo="'+data[i].tipo+'">\
                                        </td>\
                                        <td>\
                                            <input type="text" id="i_monto_'+data[i].id+'" name="i_monto_'+data[i].id+'" disabled class="form-control form-control-sm input_montos"  autocomplete="off">\
                                        </td>\
                                    </tr>';
                            
                            $('#t_semana tbody').append(html);  
                        }

                        sumaTotalSemana();
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="11">No se encontró información</td>\
                                    </tr>';

                        $('#t_semana tbody').append(html);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cobranza_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos cobranza');
                }
            });
        }

        function muestraRegistrosSiguiente(ordenar){

            var info = {
                'tipo':$('input[name=radio_tipo]:checked').val(),
                'orden':ordenar,
                'tabla':'siguiente'
            };

            $('#t_por_siguiente tbody').empty();
            $('#t_por_siguiente tbody').html('');
            $('#i_total_siguiente').val('');

            $.ajax({
                type: 'POST',
                url: 'php/cobranza_buscar.php',
                dataType:"json", 
                data:{'datos':info},
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            var columnaFechaInicio = '';
                            var columnaFechaFin = '';

                            if($('input[name=radio_tipo]:checked').attr('alt') != 'CXC')
                            {
                                columnaFechaInicio = '<td data-label="Inicio Periodo" class="fecha_hide">'+data[i].fecha_inicio+'</td>';
                                columnaFechaFin = '<td data-label="Fin Periodo" class="fecha_hide">'+data[i].fecha_fin+'</td>';
                            }

                            var html='<tr class="renglon_siguiente" alt="'+data[i].id+'">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Cliente">'+data[i].cliente+'</td>\
                                        <td data-label="Razón Social">'+data[i].razon_social+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Vencimiento">'+data[i].vencimiento+'</td>'+columnaFechaInicio+' '+columnaFechaFin+'\
                                        <td data-label="Cargos">'+formatearNumero(data[i].cargos)+'</td>\
                                        <td data-label="Abonos">'+formatearNumero(data[i].abonos)+'</td>\
                                        <td data-label="Saldo" class="siguiente_saldo" alt="'+data[i].saldo+'">'+formatearNumero(data[i].saldo)+'</td>\
                                    </tr>';
                            
                            $('#t_por_siguiente tbody').append(html);  
                        }

                        sumaTotalSiguiente();
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="9">No se encontró información</td>\
                                    </tr>';

                        $('#t_por_siguiente tbody').append(html);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cobranza_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos cobranza');
                }
            });
        }

        function muestraRegistrosVencidos(ordenar){

            var info = {
                'tipo':$('input[name=radio_tipo]:checked').val(),
                'orden':ordenar,
                'tabla':'vencidos'
            };

            $('#t_vencido tbody').empty();
            $('#t_vencido tbody').html('');
            $('#i_total_vencido').val('');

            $.ajax({
                type: 'POST',
                url: 'php/cobranza_buscar.php',
                dataType:"json", 
                data:{'datos':info},
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            var columnaFechaInicio = '';
                            var columnaFechaFin = '';

                            if($('input[name=radio_tipo]:checked').attr('alt') != 'CXC')
                            {
                                columnaFechaInicio = '<td data-label="Inicio Periodo" class="fecha_hide">'+data[i].fecha_inicio+'</td>';
                                columnaFechaFin = '<td data-label="Fin Periodo" class="fecha_hide">'+data[i].fecha_fin+'</td>';
                            }

                            var html='<tr class="renglon_vencido" alt="'+data[i].id+'">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Cliente">'+data[i].cliente+'</td>\
                                        <td data-label="Razón Social">'+data[i].razon_social+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Vencimiento">'+data[i].vencimiento+'</td>'+columnaFechaInicio+' '+columnaFechaFin+'\
                                        <td data-label="Cargos">'+formatearNumero(data[i].cargos)+'</td>\
                                        <td data-label="Abonos">'+formatearNumero(data[i].abonos)+'</td>\
                                        <td data-label="Saldo" class="vencidos_saldo" alt="'+data[i].saldo+'">'+formatearNumero(data[i].saldo)+'</td>\
                                    </tr>';
                            
                            $('#t_vencido tbody').append(html);  
                        }

                        sumaTotalVencidos();
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="9">No se encontró información</td>\
                                    </tr>';

                        $('#t_vencido tbody').append(html);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cobranza_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos cobranza');
                }
            });
        }

        function sumaTotalSemana(){
            var total=0;
            $('.semana_saldo').each(function(){
                if($(this).parent().css('display')!='none')
                {
                    var valor= parseFloat(quitaComa($(this).attr('alt')));

                    total=total+valor;
                }
            });

            $('#i_total_semana').val(formatearNumero(total));
        }

        function sumaTotalSiguiente(){
            var total=0;
            $('.siguiente_saldo').each(function(){
                if($(this).parent().css('display')!='none')
                {
                    var valor= parseFloat(quitaComa($(this).attr('alt')));

                    total=total+valor;
                }
            });

            $('#i_total_siguiente').val(formatearNumero(total));
        }

        function sumaTotalVencidos(){
            var total=0;
            $('.vencidos_saldo').each(function(){
                if($(this).parent().css('display')!='none')
                {
                    var valor= parseFloat(quitaComa($(this).attr('alt')));

                    total=total+valor;
                }
            });

            $('#i_total_vencido').val(formatearNumero(total));
        }

        $(document).on('change','#t_semana .ch_pagar',function(){
            var id = $(this).val();
            var valor = $(this).attr('alt');

            if($(this).is(':checked'))
            {
                $('#i_monto_'+id).val(formatearNumero(valor)).prop('disabled',false);
            }else{
                $('#i_monto_'+id).val('').prop('disabled',true);
            }
            
            calculaMontoAPagar();
        });

        function calculaMontoAPagar(){
            var total=0;
            $('.ch_pagar').each(function(){
                if($(this).is(':checked'))
                {
                    if($(this).parent().parent().css('display')!='none')
                    {
                        var id = $(this).val();
                        var valor= parseFloat(quitaComa($('#i_monto_'+id).val()));

                        total=total+valor;
                    }
                }
            });

            $('#i_importe').val(formatearNumero(total));
        }

        $(document).on('keypress','#t_semana .input_montos',function(event){
            return validateDecimalKeyPressN(this, event, 2);
        });

        $(document).on('change','#t_semana .input_montos',function(){
            if($(this).validationEngine('validate')==false) {
                var precio = quitaComa($(this).val());

                if(precio==''){
                    precio=0;
                }

                if(precio > 0)
                {
                    calculaMontoAPagar();
                }else{
                    $('#i_importe').val(0);
                }
            }else{
                $('#i_importe').val(0);
                $(this).val(0);
            }
        });

        $('#b_guardar').click(function(){
           
           $('#b_guardar').prop('disabled',true);

            if($('#forma').validationEngine('validate'))
            {
                if(verificarMismaRazonSocial()==0){
                    if($('input[name=radio_tipo]:checked').val() == 0)
                        guardarCxC();
                    else
                        guardarPagos();
                }else{
                    mandarMensaje('No puedes guardar un pago a diferentes razones sociales, verifica que los folios a pagar sean de la misma razón social');
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardarCxC(){
            if($('#i_importe').val()!='' && parseFloat(quitaComa($('#i_importe').val()))>0){

                var info = {
                    'idConcepto' :  $('#s_concepto').val(),
                    'cveConcepto' : $('#s_concepto option:selected').attr('alt'),
                    'idBanco' : $('#s_cuenta_banco option:selected').attr('alt'),
                    'idCuentaBanco' : $('#s_cuenta_banco').val(),
                    'idUsuario' : idUsuario,
                    'usuario' : usuario,
                    'tipoCuenta' : $('#s_cuenta_banco option:selected').attr('alt2'),
                    'fechaAplicacion':$('#i_fecha').val(),
                    'idBancoCliente' : $('#i_cuenta_banco_cliente').val(),
                    'idCuentaCliente' : $('#i_cuenta_cliente').val(),
                    'idMetodoPago' : $('input[name=radio_tipo]:checked').attr('alt'),
                    'formaPago' : $('#s_forma_pago').val(),
                    'importe' : quitaComa($('#i_importe').val()),
                    'registros' : obtieneRegistrosAPagar()
                };

                $.ajax({
                    type: 'POST',
                    url: 'php/cobranza_guardar.php',
                    data:  {'datos':info},
                    success: function(data) {
                        console.log(data);
                        if(data > 0 )
                        { 
                            mandarMensaje('Se realizo el proceso correctamente');
                            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                            muestraCuentasBancos('s_cuenta_banco', 0,0,idUnidadActual);
                            muestraConceptosCxPAbonos('s_concepto');
                            $('#i_fecha,#i_cuenta_banco_cliente,#i_cuenta_cliente,#i_importe').val('');
                            verificaRadioOrden();
                            $('#b_guardar').prop('disabled',false); 
                            $('#s_concepto').prop('disabled',false);
                        }else{ 
                            mandarMensaje('Error al guardar.');
                            $('#b_guardar').prop('disabled',false);
                        }
                    },
                    error: function (xhr) 
                    {
                        console.log('php/cobranza_guardar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }
                });
            }else{
                mandarMensaje('Debes seleccionar por lo menos un registro');
                $('#b_guardar').prop('disabled',false);
            }
        }

        function guardarPagos(){
            if($('#i_importe').val()!='' && parseFloat(quitaComa($('#i_importe').val()))>0){


                var info = {
                    'idConcepto' :  $('#s_concepto').val(),
                    'cveConcepto' : $('#s_concepto option:selected').attr('alt'),
                    'idBanco' : $('#s_cuenta_banco option:selected').attr('alt'),
                    'idCuentaBanco' : $('#s_cuenta_banco').val(),
                    'idUsuario' : idUsuario,
                    'usuario' : usuario,
                    'tipoCuenta' : $('#s_cuenta_banco option:selected').attr('alt2'),
                    'fechaAplicacion':$('#i_fecha').val(),
                    'idBancoCliente' : $('#i_cuenta_banco_cliente').val(),
                    'idCuentaCliente' : $('#i_cuenta_cliente').val(),
                    'idMetodoPago' : $('input[name=radio_tipo]:checked').attr('alt'),
                    'formaPago' : $('#s_forma_pago').val(),
                    'importe' : quitaComa($('#i_importe').val()),
                    'registros' : obtieneRegistrosAPagar()
                };

                $.ajax({
                    type: 'POST',
                    url: 'php/cobranza_guardar.php',
                    data:  {'datos':info},
                    dataType:"json", 
                    success: function(data) {
                        if(data.length != 0 )
                        {
                            if($('input[name=radio_tipo]:checked').attr('alt') == 'PPD')
                                mandarTimbrar(data);
                            else{
                                mandarMensaje('Se realizo el proceso correctamente');
                                //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                                muestraCuentasBancos('s_cuenta_banco', 0,0,idUnidadActual);
                                muestraConceptosCxPAbonos('s_concepto');
                                $('#i_fecha,#i_cuenta_banco_cliente,#i_cuenta_cliente,#i_importe').val('');
                                verificaRadioOrden();
                                $('#b_guardar').prop('disabled',false); 
                                $('#s_concepto').prop('disabled',false);
                            }

                        }else{ 
                            mandarMensaje('Error al guardar.');
                            $('#b_guardar').prop('disabled',false);
                        }
                    },
                    error: function (xhr) 
                    {
                        console.log('php/cobranza_guardar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }
                });
            }else{
                mandarMensaje('Debes seleccionar por lo menos un registro');
                $('#b_guardar').prop('disabled',false);
            }
        }

        function mandarTimbrar(arr){
            var dato = JSON.parse(JSON.stringify(arr));

            for(var i=0;i < dato.length;i++)
            {
                //console.log(' idPago: '+dato[i].idPago);
                var idPago = dato[i].idPago;
                var idCFDI = dato[i].idCFDI;
                var idEmpresa = dato[i].idEmpresa;
                var tipo = dato[i].tipo;

                timbrarPago(idPago,idCFDI,idEmpresa,tipo);
            }
        }

        function timbrarPago(idPago,idCFDI,idEmpresa,tipo){
            $('#fondo_cargando').show();
           
            var ruta = 'http://192.168.0.180/cfdi_3_3/php/ws_genera_pagos.php';
            var datos = {'empresa':idEmpresa, 'registro': idCFDI};
            

            $.ajax({
                type: 'GET',
                url: ruta,
                data : datos,
                success: function(data)
                {
                    console.log(data);
                    if(data == 'OK')
                    {
                        if(parseInt(actualizarDatosCFDIPagos(idPago, idCFDI)) == parseInt(idPago))
                        {
                            mandarMensaje('El pago se guardo y timbro correctamente');
                            
                        }else{
                            mandarMensaje('El pago se creo y timbro pero no me actualizó los datos xml');  ///vacio
                        }
                        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                        muestraCuentasBancos('s_cuenta_banco', 0,0,idUnidadActual);
                        muestraConceptosCxPAbonos('s_concepto');
                        $('#i_fecha,#i_cuenta_banco_cliente,#i_cuenta_cliente,#i_importe').val('');
                        verificaRadioOrden();
                        $('#b_guardar').prop('disabled',false); 
                        $('#s_concepto').prop('disabled',false);
                        
                    }else{
                        eliminarPago(idPago);
                        mandarMensaje('Ocurrio un error al timbrar el pago: ' + data + '. Verificar los datos.');  ///vacio
                    }

                    $('#fondo_cargando').hide(); 
                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('* Error al generar timbre');
                    eliminarPago(idPago);
                    //limpiar();
                    $('#fondo_cargando').hide(); 
                }
            });
        }

        function eliminarPago(idPago){
            $.ajax({
                type: 'POST',
                url: 'php/pagos_eliminar.php',
                data:  {'id':idPago},
                success: function(data) {
                    
                    if(data = 0 )
                        mandarMensaje('Pago guardado. Error al generar timbre');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/pagos_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al eliminar Pago.');
                }
            });
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_cuenta_banco', 0,0,idUnidadActual);
            muestraConceptosCxPAbonos('s_concepto');
            $('#i_fecha,#i_cuenta_banco_cliente,#i_cuenta_cliente,#i_importe').val('');
            verificaRadioOrden();
            $('#b_guardar').prop('disabled',false); 
            $('#s_concepto').prop('disabled',false);
        }

        function obtieneRegistrosAPagar(){
            var j = 0;
            var arreglo = [];

            $(".ch_pagar").each(function() {
                if($(this).is(':checked'))
                {
                    var cont=0;
                    if($(this).parent().parent().css('display')!='none')
                    {
                        var id = $(this).val();
                        var importe = quitaComa($('#i_monto_'+$(this).val()).val());
                        var tipo = $(this).attr('tipo');
                        var saldo = $(this).attr('alt');
                        
                        j++;

                        arreglo[j] = {
                            'id' : id,
                            'tipo' : tipo,
                            'importe' : importe,
                            'saldo' : saldo
                        };
                    }
                }
            });

            arreglo[0] = j;
            return arreglo;
        }

        function verificarMismaRazonSocial(){

            var primerRazonSocial=0;
            var diferenteRazonSocial=0;
            var cont=0;

            $(".ch_pagar").each(function() {

                if($(this).is(':checked'))
                {
                    if($(this).parent().parent().css('display')!='none')
                    {
                        if(cont==0){
                            primerRazonSocial=$(this).attr('razon_social');
                            cont++;
                        }
                        if(primerRazonSocial!=$(this).attr('razon_social')){
                            diferenteRazonSocial++;
                        }
                        
                    
                    }
                }
            });
            //--- O = ES EL MISMO 1<= HAY DIFERENTES
            return diferenteRazonSocial;
        }
       
        $('#b_excel').click(function(){
            var datos = {
                'tipo':$('input[name=radio_tipo]:checked').val(),
                'orden':$('input[name=radio_ordenar]:checked').val(),
                'tabla':'semana'
            };

            $("#i_nombre_excel").val('Cobranza Por Cobrar en la Semana');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel2').click(function(){
            var datos = {
                'tipo':$('input[name=radio_tipo]:checked').val(),
                'orden':$('input[name=radio_ordenar]:checked').val(),
                'tabla':'siguiente'
            };

            $("#i_nombre_excel").val('Cobranza Por Cobrar la siguiente Semana');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel3').click(function(){
            var datos = {
                'tipo':$('input[name=radio_tipo]:checked').val(),
                'orden':$('input[name=radio_ordenar]:checked').val(),
                'tabla':'vencidos'
            };

            $("#i_nombre_excel").val('Cobranza Sin cobrar');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });
        
    });

</script>

</html>