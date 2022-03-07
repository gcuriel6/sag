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
    #div_t_facturas_pagadas,
    #div_t_facturas_pagadas,
    #div_t_facturas{
        max-height:180px;
        min-height:180px;
        overflow-y:auto;
        border: 1px solid #ddd;
        overflow-x:hidden;
    }
    
    #div_t_pagos_cancelados,
    #div_t_buscar_notas_credito,
    #div_t_notas_credito{
        max-height:300px;
        min-height:300px;
        overflow-y:auto;
        overflow-x:hidden;
    }
    #div_t_pagos_relacionados
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
    #div_radio_iva,
    #div_radio_iva_nc{
        padding-top:28px;
    }
    .boton_eliminar{
        width:50px;
    }
    #dialog_buscar_pagos > .modal-lg,
    #dialog_buscar_facturas > .modal-lg,
    #dialog_buscar_notas_credito > .modal-lg,
    #dialog_notas_credito > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    #div_facturas_pagadas_detalle, 
    #div_b_timbrar,
    .secundarios,
    #div_b_verificar_estatus,
    #div_b_descargar_acuse,
    #div_relacion_pagos{
        display:none;
    }
    #forma_notas_credito{
        border: 1px solid #ddd;
        padding:15px;
    }
    #dialog_correo{
        z-index:2000;
    }
    #div_b_buscar_facturas{
        padding-top:32px;
    }
    #div_venta_publico_general{
        display:none;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_facturas_pagadas,
        #div_t_facturas_pagadas,
        #div_t_facturas,
        #div_t_pagos_cancelados,
        #div_t_buscar_notas_credito,
        #div_t_notas_credito{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
        #div_radio_iva,
        #div_radio_iva_nc{
            padding-top:10px;
        }
        .boton_eliminar{
            width:100%;
        }
        #dialog_buscar_pagos > .modal-lg,
        #dialog_buscar_facturas > .modal-lg,
        #dialog_buscar_notas_credito > .modal-lg,
        #dialog_notas_credito > .modal-lg{
            max-width: 100%;
        }
        #div_b_buscar_facturas{
            padding-top:5px;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">
        <div class="row">
            <div class="col-md-12" id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-2">
                        <div class="titulo_ban">Ingresos sin factura</div>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_cont_estatus" style="text-align:center;">
                        <div id="div_estatus"></div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_pagos"><i class="fa fa-search" aria-hidden="true"></i> Buscar Ingreso</button>
                    </div> 
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_guardar">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                
                <form id="forma_general" name="forma_general">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="s_id_unidades" class="col-form-label requerido">Unidad de Negocio </label>
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="s_id_sucursales" class="col-form-label requerido">Sucursal </label>
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-5">
                                    <label for="i_folio" class="col-form-label">Folio</label>
                                    <input type="text" id="i_folio" name="i_folio" class="form-control form-control-sm"  autocomplete="off" readonly>
                                    <input type="hidden" id="i_id" name="i_id">
                                    <input type="hidden" id="i_id_cfdi" name="i_id_cfdi">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label for="i_importe" class="col-form-label">Importe</label>
                            <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm"  autocomplete="off" >
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="s_clientes" class="col-form-label">Cliente</label>
                            <select id="s_clientes" name="s_clientes" class="form-control form-control-sm"></select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="s_razones" class="col-form-label">Razon Social</label>
                            <select id="s_razones" name="s_razones" class="form-control form-control-sm" disabled></select>
                        </div>
                        <div class="col-md-4">
                            <label for="i_rfc" class="col-form-label">RFC</label>
                            <input type="text" id="i_rfc" name="i_rfc" class="form-control form-control-sm" disabled></input>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                         <div class="col-md-1">
                            <label for="i_concepto_ingreso" class="col-form-label">Concepto de ingreso</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="i_concepto_ingreso" name="i_concepto_ingreso" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                        <div class="col-md-1">
                            <label for="i_concepto_ingreso" class="col-form-label">Descripción del ingreso</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="i_descripcion" name="i_descripcion" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-1">
                            <label for="s_banco" class="col-form-label requerido">Banco</label>
                        </div>
                        <div class="col-md-3">
                            <select id="s_banco" name="s_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>

                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="i_cuenta_cliente" class="col-form-label requerido">Fecha del pago</label>
                                </div>
                                <div class="input-group col-md-5">
                                    <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm fecha validate[required]" autocomplete="off" >
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
            </div> <!--div_contenedor-->
        </div>      
    </div> <!--div_principal-->

    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>
</body>

<div id="fondo_cargando"></div>

<div id="dialog_empresa_fiscal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Empresa Fiscal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_empresa_fiscal" id="i_filtro_empresa_fiscal" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_empresa_fiscal">
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


<div id="dialog_buscar_pagos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" style="overflow-y: scroll;" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Ingresos sin Factura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <label for="s_filtro_unidad" class="col-md-2 col-form-label">Unidad de Negocio </label>
                    <div class="col-md-4">
                        <select id="s_filtro_unidad" name="s_filtro_unidad" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <label for="s_filtro_sucursal" class="col-md-1 col-form-label">Sucursal </label>
                    <div class="col-md-4">
                        <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control form-control-sm filtros" autocomplete="off" style="width:100%;"></select>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm-12 col-md-5">
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
                    <div class="col-sm-12 col-md-6">
                        <input type="text" name="i_filtro_pagos" id="i_filtro_pagos" class="form-control form-control-sm filtrar_renglones" alt="renglon_pagos" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_pagos_buscar">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Descripión</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Banco</th>
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='PAGOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var idPago = 0;
    var rfcInicial = '';
    let objRazonesSociales = [];

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        
        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        muestraSelectUnidades(matriz,'s_filtro_unidad',idUnidadActual);
        muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);

        muestraCuentasBancos('s_banco', 0,1,idUnidadActual);
        mostrarClientes();
        mostrarRazones();

        //-->NJES May/07/2020 si la unindad es alarmas mostrar checkbox para buscar facturas a venta publico en general
        if(idUnidadActual == 2)
            $('#div_venta_publico_general').css('display','block');
        else{
            $('#div_venta_publico_general').css('display','none');
            $('#ch_factura_por_rfc').prop('disabled',false);
        }

        $('#s_id_unidades').change(function(){
            var idUnidadNegocio = $('#s_id_unidades').val();
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);

            $('#i_cliente').val('');
            $('#s_razon_social').append('<option value=" ">Selecciona<option>');
            $('#i_pais_cliente').val('');
            $('#i_rfc_cliente').val('');
            $('#i_email_cliente').val('');
            $('#i_email').val('');
            $('#i_cp_cliente').val('');
            $('#i_rfc').val('');
            rfcInicial = '';

            //-->NJES April/16/2020 permitir que los pagos por rfc sean para todas las unidades de negocio
            /*if($('#s_id_unidades').find('option:selected').text()=='ALARMAS')
            {
                $('.div_por_rfc').css('display','block');
            }else{
                $('.div_por_rfc').css('display','none');
                $('#ch_factura_por_rfc').prop('checked',false);
            }*/

            //-->NJES May/07/2020 si la unindad es alarmas mostrar checkbox para buscar facturas a venta publico en general
            if($('#s_id_unidades').find('option:selected').text()=='ALARMAS')
                $('#div_venta_publico_general').css('display','block');
            else{
                $('#div_venta_publico_general').css('display','none');
                $('#ch_factura_por_rfc').prop('disabled',false);
                $('#ch_factura_por_rfc').prop('disabled',false);
                $('#s_metodo_pago').prop('disabled',false);
                $('#s_razon_social').empty().prop('disabled',false);
                $('#i_cliente').val('').attr('alt','').attr('alt2','').attr('codigo_postal','');
                $('#i_rfc').val('');
                $('#b_buscar_clientes').prop('disabled',false);

                habilitaBotonFacturas();
            }
            $('#ch_venta_publico_general').prop('checked',false);
            

            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_banco', 0,1,idUnidadNegocio);

            $('#s_razon_social').empty();

            habilitaBotonFacturas();
        });

        $('#s_id_sucursales').change(function(){
            habilitaBotonFacturas();
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        }); 

        $('#i_fecha').val(hoy);

        $('#s_razon_social').change(function(){
            var rfc = $('#s_razon_social option:selected').attr('alt2');
            var correo = $('#s_razon_social option:selected').attr('alt4');
            var cp = $('#s_razon_social option:selected').attr('alt3');
            var pais = $('#s_razon_social option:selected').attr('alt5');

            $('#i_pais_cliente').val(pais);
            $('#i_rfc_cliente').val(rfc);
            $('#i_email_cliente').val(correo);
            $('#i_email').val(correo);
            $('#i_cp_cliente').val(cp);

            //-->NJES April/17/2020 verifica si el rfc del nuevo cliente seleccionado es igual al de las partidas para poder buscar mas facturas
            if($('#t_facturas .factura_pagar').length > 0)
            {
                $("#t_facturas .factura_pagar").each(function(index) {
                    if(index == 0)
                    {
                        var rfcAct = $(this).attr('rfc_razon_social');
                        var unidad = $(this).attr('unidad');
                        if($('#s_id_unidades').val() == unidad && rfc != rfcAct)
                            mandarMensaje('El RFC del cliente no es el mismo de las facturas seleccionadas a pagar.');
                        else
                            $('#i_rfc').val(rfc);
                        
                    }
                });
            }else{
                $('#i_rfc').val(rfc);
            }

            habilitaBotonFacturas();
        });

        $('#b_buscar_empresa_fiscal').click(function()
        {
            $('#i_filtro_empresa_fiscal').val('');
            muestraModalEmpresasFiscalesCFDI('renglon_empresa_fiscal','t_empresa_fiscal tbody','dialog_empresa_fiscal');
        });

        $('#t_empresa_fiscal').on('click', '.renglon_empresa_fiscal', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var idCFDI = $(this).attr('alt3');
            $('#i_empresa_fiscal').attr('alt',id).attr('alt2',idCFDI).val(nombre);
            $('#dialog_empresa_fiscal').modal('hide');

            habilitaBotonFacturas();
        });

        $('#b_buscar_facturas').click(function(){
            //-->NJES May/07/2020 si venta publico en general esta checked buscar las facturas con cliente 0
            /*if($('#ch_venta_publico_general').is(':checked'))
            {

            }else{*/
                if($('#ch_factura_por_rfc').is(':checked'))
                {
                    if($('#i_rfc').val() != '')
                        mostrarFacturas();
                    else{
                        mandarMensaje('El cliente seleccionado no tiene RFC, para realizar el pago por RFC es necesario que lo tenga.');
                    }
                }else
                    mostrarFacturas();
            //}
            
        });

        $('#s_metodo_pago').change(function(){
            habilitaBotonFacturas();

            if($('#s_metodo_pago').val() == 'PUE')
                $('#div_b_sustituir').css('display','none');
            else
                $('#div_b_sustituir').css('display','block');

        });

        function habilitaBotonFacturas(){
            if($('#s_id_unidades').val() != '' && $('#s_id_sucursales').val() != '' &&  $('#i_empresa_fiscal').val() != '' &&  $('#s_razon_social').val())
                $('#b_buscar_facturas').prop('disabled',false);
            else
                $('#b_buscar_facturas').prop('disabled',true);
        }

        function mostrarFacturas(){
            $('#i_filtro_facturas').val('');
            $('#t_facturas_buscar tbody').html('');

            if($('#ch_factura_por_rfc').is(':checked'))
            {
                var mismoRFC = 1;
                var rfc = $('#i_rfc').val();
            }else{
                var mismoRFC = 0;
                var rfc = $('#i_rfc').val();
            }

            var info = {
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt'),
                'idCliente' : $('#i_cliente').attr('alt'),
                'metodoPago' : $('#s_metodo_pago').val(),
                'idRazonSocial' : $('#s_razon_social').val(),
                //-->NJES April/03/2020 se envian paramentros para indicar si se buscaran facturas por mismo rfc aunque sean de diferente cliente
                'mismoRFC' : mismoRFC,
                'rfc' : rfc,
                'nombreUnidad' : $('#s_id_unidades').find('option:selected').text()
            };
            //url: 'php/facturacion_buscar_facturas_idCliente.php',
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_facturas_idCliente_un_cxc.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data) {
                    console.log(data);
                    if(data.length != 0){                    
                        for(var i=0;data.length>i;i++){
                            //-->NJES April/03/2020 se agregan nuevos atributos en cada registro 
                            var html='<tr class="renglon_facturas" alt="'+data[i].id+'" unidad="'+$('#s_id_unidades').val()+'" sucursal="'+data[i].id_sucursal+'" empresa_fiscal="'+$('#i_empresa_fiscal').attr('alt')+'" metodo_pago="'+$('#s_metodo_pago').val()+'" razon_social="'+$('#s_razon_social').val()+'" id_cliente="'+data[i].id_cliente+'" cliente="'+data[i].cliente+'" rfc_razon_social="'+data[i].rfc_razon_social+'" registrosCXC="'+data[i].registros_cxc+'" fecha="'+data[i].fecha+'" folio="'+data[i].folio+'" uuid="'+data[i].folio_uuid+'" cargo="'+data[i].saldo_inicial+'" abono="'+formatearNumero(parseFloat(data[i].total_abonos)+parseFloat(data[i].abonos_nc))+'" saldo="'+data[i].saldo_insoluto+'" referencia="'+data[i].referencia+'">\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="UUID">'+data[i].folio_uuid+'</td>\
                                        <td data-label="Cliente">'+data[i].cliente+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Saldo Inicial">'+formatearNumero(data[i].saldo_inicial)+'</td>\
                                        <td data-label="Abonos">'+formatearNumero(parseFloat(data[i].total_abonos)+parseFloat(data[i].abonos_nc))+'</td>\
                                        <td data-label="Saldo Insoluto">'+formatearNumero(data[i].saldo_insoluto)+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_facturas_buscar tbody').append(html);   
                        }
                    }else{
                        var html='<tr class="renglon_fact">\
                                        <td colspan="8">No se encontró información</td>\
                                    </tr>';

                        $('#t_facturas_buscar tbody').append(html);
                    }
                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_facturas_idCliente.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas.');
                }
            });

            $('#dialog_buscar_facturas').modal('show');
        }

        $('#t_facturas_buscar').on('click', '.renglon_facturas', function(){
            var idFactura = $(this).attr('alt');
            var registrosCXC = $(this).attr('registrosCXC');
            var multipleCXC = (registrosCXC==1)?0:1;

            if(facturaAgregada(idFactura) == '')
            {
                var fecha = $(this).attr('fecha');
                var folio = $(this).attr('folio');
                var uuid = $(this).attr('uuid');
                var saldo_inicial = $(this).attr('cargo');
                var total_abonos = $(this).attr('abono');
                var saldo_insoluto = $(this).attr('saldo');
                var referencia = $(this).attr('referencia');
                //-->NJES April/03/2020 se toman vaores de nuevos atributos
                var rfc_razon_social = $(this).attr('rfc_razon_social');
                var idCliente = $(this).attr('id_cliente');
                var cliente = $(this).attr('cliente');

                var unidad = $(this).attr('unidad');
                var sucursal = $(this).attr('sucursal');
                var empresa_fiscal = $(this).attr('empresa_fiscal');
                var metodo_pago = $(this).attr('metodo_pago');
                var razon_social = $(this).attr('razon_social');

                //-->NJES April/03/2020 compara si la nueva factura a agregar tiene los mismos registros de llaves que las partidas actuales
                //sino las borra y agrega con las nuevas caracteristicas
                var mensaje = verificaLlaves(unidad,sucursal,empresa_fiscal,metodo_pago,razon_social,idCliente);
                console.log(mensaje);
                if(verificaLlaves(unidad,sucursal,empresa_fiscal,metodo_pago,razon_social,idCliente) != '')
                {
                    $('#t_facturas tbody').empty();
                    mandarMensaje(mensaje);
                    
                    var html='<tr class="factura_pagar" alt="'+idFactura+'" unidad="'+unidad+'" sucursal="'+sucursal+'" empresa_fiscal="'+empresa_fiscal+'" metodo_pago="'+metodo_pago+'" razon_social="'+razon_social+'" id_cliente="'+idCliente+'" rfc_razon_social="'+rfc_razon_social+'" registrosCXC="'+multipleCXC+'" folio="'+folio+'" uuid="'+uuid+'" saldo_restante="'+saldo_insoluto+'">\
                            <td data-label="Fecha">'+fecha+'</td>\
                            <td data-label="Folio">'+folio+'</td>\
                            <td data-label="UUID">'+uuid+'</td>\
                            <td data-label="Cliente">'+cliente+'</td>\
                            <td data-label="Saldo Inicial">'+formatearNumero(saldo_inicial)+'</td>\
                            <td data-label="Abonos">'+formatearNumero(total_abonos)+'</td>\
                            <td data-label="Saldo Restante">'+formatearNumero(saldo_insoluto)+'</td>\
                            <td data-label="Monto a Pagar"><input id="i_monto_'+idFactura+'" type="text" alt="'+saldo_insoluto+'" class="montos form-control form-control-sm validate[required,min[0.1]] numeroMoneda" value="" autocomplete="off"></td>\
                            <td data-label="Referencia">'+referencia+'</td>\
                            <td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>\
                        </tr>';
                }else{
                    var html='<tr class="factura_pagar" alt="'+idFactura+'" unidad="'+unidad+'" sucursal="'+sucursal+'" empresa_fiscal="'+empresa_fiscal+'" metodo_pago="'+metodo_pago+'" razon_social="'+razon_social+'" id_cliente="'+idCliente+'" rfc_razon_social="'+rfc_razon_social+'" registrosCXC="'+multipleCXC+'" folio="'+folio+'" uuid="'+uuid+'" saldo_restante="'+saldo_insoluto+'">\
                                <td data-label="Fecha">'+fecha+'</td>\
                                <td data-label="Folio">'+folio+'</td>\
                                <td data-label="UUID">'+uuid+'</td>\
                                <td data-label="Cliente">'+cliente+'</td>\
                                <td data-label="Saldo Inicial">'+formatearNumero(saldo_inicial)+'</td>\
                                <td data-label="Abonos">'+formatearNumero(total_abonos)+'</td>\
                                <td data-label="Saldo Restante">'+formatearNumero(saldo_insoluto)+'</td>\
                                <td data-label="Monto a Pagar"><input id="i_monto_'+idFactura+'" type="text" alt="'+saldo_insoluto+'" class="montos form-control form-control-sm validate[required,min[0.1]] numeroMoneda" value="" autocomplete="off"></td>\
                                <td data-label="Referencia">'+referencia+'</td>\
                                <td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>\
                            </tr>';
                }

                $('#t_facturas tbody').append(html);
                            
                $('#dialog_buscar_facturas').modal('hide');
            }else
                mandarMensaje('La factura ya fue agregada, intenta con otra.');
    
        });

        function verificaLlaves(unidad,sucursal){
            var mensaje = '';

            if($('#t_facturas .factura_pagar').length > 0)
            {
                $("#t_facturas .factura_pagar").each(function(index) {
                    //if(index == 0)
                    //{
                        var unidad_R = $(this).attr('unidad');
                        var sucursal_R = $(this).attr('sucursal');

                        if(unidad_R != unidad)
                        {
                            mensaje+='<p>La unidad seleccionada no es igual a la de las facturas seleccionadas para las partidas por lo que se quitaron.</p>';
                            return false;
                        }else if(sucursal_R != sucursal && $('#s_id_unidades').find('option:selected').text()=='ALARMAS')
                        {
                            mensaje+='<p>La sucursal seleccionada no es igual a la de las facturas seleccionadas para las partidas por lo que se quitaron.</p>';
                            return false;
                        }else if(sucursal_R != sucursal && $('#s_id_unidades').find('option:selected').text() != 'ALARMAS' && $('#ch_factura_por_rfc').is(':checked') == false)
                        {
                            mensaje+='<p>La sucursal seleccionada no es igual a la de las facturas seleccionadas para las partidas por lo que se quitaron.</p>';
                            return false;
                        }else{ 
                            mensaje+='';
                        }
                    //}
                });
            }

            return mensaje;
        }

        $(document).ready(function(){
            $(document).on('keypress','.montos',function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });
        });

        $(document).on('change','.montos',function(){
            var monto = quitaComa($(this).val());
            var saldoAnterior = $(this).attr('alt');

            if(parseFloat(monto) <= parseFloat(saldoAnterior))
            {
                if(monto == ''){
                    $(this).val(0);
                }

                calculaTotalesImporte();
            }else{
                if(parseFloat(monto) > 0)
                {
                    mandarMensaje('El monto a pagar no puede ser mayor al saldo restante.');
                    $(this).val(0);
                    calculaTotalesImporte();
                }
            }

        });

        function calculaTotalesImporte(){
            var importe=0;

           
            $('.factura_pagar').each(function(){
                var id = $(this).attr('alt');
                if($('#i_monto_'+id).val() != '')
                    var valor = parseFloat(quitaComa($('#i_monto_'+id).val()))*1000;
                else
                    var valor = 0;
                
                importe=importe+valor;
            });

            var total = parseFloat(importe)/1000;

            $('#i_importe').val(formatearNumero(total));
        }

        $('#t_facturas').on('click', '#b_eliminar', function(){
            $(this).parent().parent().remove();
            calculaTotalesImporte();
        });

        function  facturaAgregada(idFactura){
            var encontrado='';
            $('#t_facturas tbody tr').each(function(){

                var id=$(this).attr('alt');
                if(idFactura==id){
                    encontrado='SI';
                }
            });
            
            return encontrado;
        }

        $('#b_guardar').click(function(){
            var idSucursal = $('#s_id_sucursales').val();

            $('#b_guardar').prop('disabled',true);
            if ($('#forma_general').validationEngine('validate')){                    
                var unidad = $('#s_id_unidades').val();
                var sucursal = $('#s_id_sucursales').val();
                var importe = $('#i_importe').attr('alt');
                var fecha = $('#i_fecha').val();
                var concepto = $('#i_concepto_ingreso').val();
                var descripcion = $('#i_descripcion').val();
                let cliente = $("#s_clientes").val();
                let razones = $("#s_razones").val();

                if(razones != null && razones != 0){
                    if(verificaLlaves(unidad,sucursal) != ''){
                        mandarMensaje('Alguna de las partidas no cohincide con los datos principales.'); 
                        $('#b_guardar').prop('disabled',false);
                    }else{
                        guardar('pago');
                    }    
                }            
            }else{
                mandarMensaje('Debe existir por lo menos una factura para generar el pago.');
                $('#b_guardar').prop('disabled',false);
            }
        });

        //-->NJES April/03/2020 busca en array el valor recorrido, si regresa -1 quiere decir que no es igual y lo agrega al array
        //para obtener solo los diferentes
        function idServicioMismoRFC(){
            var arreglo = [];

            $("#t_facturas .factura_pagar").each(function() {
                var idServicio = $(this).attr('id_cliente');
                if(JSON.stringify(arreglo).indexOf(idServicio)=== -1){
                    arreglo.push(idServicio)
                }
            });
            console.log(JSON.stringify(arreglo));
            return arreglo;
        }

        //-->NJES April/20/2020 busca en array el valor recorrido, si regresa -1 quiere decir que no es igual y lo agrega al array
        //para obtener solo los diferentes
        function idSucursalMismoRFC(){
            var arreglo = [];

            $("#t_facturas .factura_pagar").each(function() {
                var idSucursal = $(this).attr('sucursal');
                if(JSON.stringify(arreglo).indexOf(idSucursal)=== -1){
                    arreglo.push(idSucursal)
                }
            });
            console.log(JSON.stringify(arreglo));
            return arreglo;
        }

        function guardar(tipo){
            
            var info={
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'importe' : quitaComa($('#i_importe').val()),
                'idCuentaBanco' : $('#s_banco').val(),
                'fecha' : $('#i_fecha').val(),
                'concepto' : $('#i_concepto_ingreso').val(),
                'descripcion' : $('#i_descripcion').val(),
                'cliente' : $("#s_clientes").val(),
                'razon' : $("#s_razones").val(),
                'rfc' : $("#i_rfc").val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/pagos_guardar_sin_factura.php',
                //dataType:"json", 
                data:  {'datos':info},
                success: function(data){
                    //console.log(data);
                    if(data != 0 ){
                        $('#i_id').val(data.id);
                        var id = data.id;
                        mandarMensaje('Se guardo correctamente');
                    }else
                        mandarMensaje('Error al guardar.');

                    $('#b_guardar').prop('disabled',false);

                },
                error: function (xhr){
                    console.log('php/pagos_guardar_sin_factura.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        };

        function obtieneFacturasPagar(){
            var j = 0;
            var arreglo = [];

            $("#t_facturas .factura_pagar").each(function() {
                var idFactura = $(this).attr('alt');
                var importe = quitaComa($(this).find('td').eq(7).find('input').val());
                var saldoAnterior = $(this).attr('saldo_restante');
                var uuidfactura = $(this).attr('uuid');
                var folioFactura = $(this).attr('folio');
                var registrosCXC = $(this).attr('registrosCXC');
                //-->NJES April/03/2020 envia id servicio (cliente) de cada partida de factura a pagar
                var idServicio = $(this).attr('id_cliente');
                
                arreglo[j] = {
                    'idFactura' : idFactura,
                    'uuidfactura' : uuidfactura,
                    'folioFactura' : folioFactura,
                    'importe' : importe,
                    'saldoAnterior' : saldoAnterior,
                    'multipleCXC' : registrosCXC,
                    'idServicio' : idServicio
                };  

                j++;
            });

            return arreglo;
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
        }

        function labelEstatus(estatus,metodo){
            var est = '';



            if(metodo == 'PUE')
            {
                if(estatus != 'C')
                    est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid gray;">PAGO UNICO</label>';
                else
                    est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ff0000;">PAGO UNICO CANCELADO</label>';

            }else{

                console.log(estatus + ' ** ' + metodo);
                est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #0066cc;">SIN TIMBRAR</label>';
                if(estatus == 'T')
                    est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">TIMBRADO</label>';
                else if(estatus == 'C')
                    est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ff0000;">CANCELADO</label>';
                else if(estatus == 'P')
                    est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ffc107;">PENDIENTE</label>';
                //if(estatus == 'A')
                    //est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">TIMBRADO</label>';


            }
            return est;
        }

        $('#b_buscar_pagos').click(function(){

            muestraSelectUnidades(matriz,'s_filtro_unidad',idUnidadActual);
            $('#forma_general').validationEngine('hide');
            $('#dialog_buscar_pagos').modal('show');
            $('#s_filtro_unidad').prop('disabled',false);
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);
            $('#s_filtro_sucursal').prop('disabled',false);
            fechaHoyServidor('i_fecha_inicio','primerDiaMes');
            fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        
            buscarPagos(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));

        });

        $('#s_filtro_unidad').change(function(){
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);
            $('.img-flag').css({'width':'50px','height':'20px'});
            buscarPagos($('#s_filtro_unidad').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad').val(),modulo,idUsuario));
        });

        $('#s_filtro_sucursal').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarPagos($('#s_filtro_unidad').val(),$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarPagos($('#s_filtro_unidad').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad').val(),modulo,idUsuario));
            }
        });

        $('#i_fecha_inicio').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarPagos($('#s_filtro_unidad').val(),$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarPagos($('#s_filtro_unidad').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad').val(),modulo,idUsuario));
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarPagos($('#s_filtro_unidad').val(),$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarPagos($('#s_filtro_unidad').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad').val(),modulo,idUsuario));
            }
        });
        //--MGFS 21-02-2020 se agrega folio de factura---
        function buscarPagos(idUnidadNegocio,idSucursal){

            $('#i_filtro_pagos').val('');
            $('.renglon_pagos').remove();
            $('#t_pagos_buscar tbody').html('');

            var info = {
                'idUnidadNegocio' : idUnidadNegocio,
                'idSucursal': idSucursal,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/pagos_sin_factura_buscar.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data) {
                    console.log('Aqui va: '+JSON.stringify(data)+' '+data);
                    
                    if(data.length != 0)
                    {

                        for(var i=0;data.length>i;i++)
                        {

                            var html='<tr class="renglon_pagos" alt="'+data[i].id+'" id_unidad_negocio="'+data[i].id_unidad_negocio+'">\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Importe">'+formatearNumero(data[i].importe)+'</td>\
                                        <td data-label="Concepot">'+data[i].concepto+'</td>\
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Banco">'+data[i].banco+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_pagos_buscar tbody').append(html);   
                        }
                    }else
                    {
                        var html='<tr class="renglon_fact">\
                                        <td colspan="8">No se encontró información</td>\
                                    </tr>';

                        $('#t_pagos_buscar tbody').append(html);
                    }

                },
                error: function (xhr) {
                    console.log('php/pagos_buscar.php 777 --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar pagos.');
                }
            });
        }

        $('#t_pagos_buscar').on('click', '.renglon_pagos', function(){

            idPago = $(this).attr('alt');
            var idCliente = $(this).attr('cliente');
            var idUnidadNegocio = $(this).attr('id_unidad_negocio');
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_banco', 0,1,idUnidadNegocio);
            $('#div_estatus').html('');

            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
            //muestraSelectRazonesSociales(idCliente,idUnidadNegocio,'s_razon_social');
            
            muestraRegistro(idPago);
            //muestraRegistroDetalle(idPago);

        });

        function muestraRegistro(idPago){

            $('#b_agregar').prop('disabled',true);
            $('#div_estatus').html('');
            $('#i_email').val('');
            $.ajax({
                type: 'POST',
                url: 'php/pagos_buscar_id_sf.php',
                dataType:"json", 
                data : {'id_pago': idPago},
                success: function(data)
                {
                    if(data.length >0)
                    {
                        var dato = data[0];

                        $('#s_id_unidades').val(dato.id_unidad_negocio);
                        $("#s_id_unidades").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                        $('#s_id_sucursales').val(dato.id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});

                        $('#s_banco').val(dato.id_cuenta_banco);
                        $('#s_banco').select2({placeholder: $(this).data('elemento')});

                        $('#i_folio').val(dato.folio);
                        $('#i_concepto_ingreso').val(dato.concepto);
                        $('#i_descripcion').val(dato.descripcion);
                        $('#i_fecha').val(dato.fecha);
                        $('#i_importe').val(dato.monto);

                        $('#b_guardar').prop('disabled', true);

                        

                        if(dato.id_cliente == 0){
                            $("#s_clientes").val(-1);
                            $("#s_razones").html("<option value='0' disabled selected>...</option>");
                            $("#i_rfc").val("");
                        }else{
                            $("#s_clientes").val(dato.id_cliente);
                            $("#s_clientes").trigger("change");
                        }

                        if(dato.id_razon == 0){
                            mandarMensaje("Este pago no tiene razon social registrada, se seleccionara por default si el cliente solo cuenta con una razon social.");
                        }

                        setTimeout(() => {
                            let razones = $("#s_razones").val();

                            if(razones == null || razones == 0 || razones == undefined){
                                if(dato.id_razon != "" && dato.id_razon != 0){
                                    $("#s_razones").val(dato.id_razon);
                                    $("#s_razones").trigger("change");
                                }
                            }
                        }, 700);

                        $('#dialog_buscar_pagos').modal('hide');
                        
                    }else
                        mandarMensaje('No se encontro Información del pago');

                },
                error: function (xhr) {
                    console.log('php/pagos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar pago...');
                }
            });

        }

        function muestraRegistroDetalle(idPago){
            $('#div_facturas_a_pagar').css('display','none');
            $('#div_facturas_pagadas_detalle').css('display','block');

            $('#t_facturas_pagadas tbody').html(''); 
            $('.renglon_pagos_detalle').empty();

            $.ajax({
                type: 'POST',
                url: 'php/pagos_buscar_detalle_id.php',
                dataType:"json", 
                data : {'idPago':idPago},
                success: function(data) {                   
                    for(var i=0;data.length>i;i++)
                    {

                        var registro='';

                        registro+= '<tr class="renglon_pagos_detalle" alt="'+data[i].id+'" folio="'+data[i].folio+'" uuid="'+data[i].uuid+'">';
                            registro+= '<td data-label="Fecha">'+data[i].fecha+'</td>';
                            registro+= '<td data-label="Folio">'+data[i].folio+'</td>';
                            registro+= '<td data-label="UUID" style="text-align:right;">'+data[i].uuid,''+'</td>';
                            registro+= '<td data-label="Monto a Pagar">'+formatearNumero(data[i].monto_pago)+'</td>';
                        registro+= '</tr>';

                        $('#t_facturas_pagadas tbody').append(registro); 
                    }
                },
                error: function (xhr) {
                    console.log('php/pagos_buscar_detalle_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar partidas pagos.');
                }
            });
        }

        function mostrarOcultarBotones(tipo,folioFiscal,numNC,metodoP){
            $('#div_b_guardar,#div_b_sustituir').css('display','none');
            $('#div_cont_estatus').css('display','block');
            
            if(metodoP == 'PUE')
            {
                $('#div_b_timbrar').css('display','none');
                $('.botones_prefactura').css('display','none');
                $('.botones_factura').css('display','none');
                $('.divs_alt').css('display','none');
                $('#div_b_descargar_acuse').css('display','none');
                $('#div_b_verificar_estatus').css('display','none');

                if(tipo != 'C')
                    $('#div_b_cancelar').css('display','block');
                else
                    $('#div_b_cancelar').css('display','none');
                
            }else{
                if(tipo == 'T') //->Timbrado
                {
                    $('.botones_factura').css('display','block');
                    $('.botones_prefactura').css('display','block');
                    $('.divs_alt').css('display','none');
                    $('#div_b_timbrar').css('display','none');
                    $('#div_b_verificar_estatus').css('display','none');
                    $('#div_b_descargar_acuse').css('display','none');

                }else if(tipo == 'A') //-> Sin timbrar
                {
                    $('#div_b_timbrar').css('display','block');
                    $('.botones_prefactura').css('display','block');
                    $('.divs_alt').css('display','block');
                    $('#div_b_verificar_estatus').css('display','none');
                    $('#div_b_descargar_acuse').css('display','none');
                    $('.botones_factura').css('display','none');
                }else if(tipo == 'P') //-> Pendiente
                {
                    $('#div_b_timbrar').css('display','none');
                    $('.botones_prefactura').css('display','none');
                    $('.botones_factura').css('display','none');
                    $('.divs_alt').css('display','none');
                    $('#div_b_descargar_acuse').css('display','none');
                    $('#div_b_verificar_estatus').css('display','block');
                }else{  //-> Cancelada
                    $('#div_b_timbrar').css('display','none');
                    $('.botones_prefactura').css('display','none');
                    $('.botones_factura').css('display','none');
                    $('.divs_alt').css('display','none');
                    $('#div_b_verificar_estatus').css('display','none');

                    if(folioFiscal != '')
                        $('#div_b_descargar_acuse').css('display','block');
                    else
                        $('#div_b_descargar_acuse').css('display','none'); 
                }
            }

        }

        $('#b_cancelar').click(function(){
            var tipo = $('#div_estatus label').text();

            var id = $('#i_id').val();
            var idCFDI = $('#i_id_cfdi').val();
            var idEmpresa = $('#i_empresa_fiscal').attr('alt2');
            //var metodoPago = $('#s_metodo_pago option:selected').val();
            $('#fondo_cargando').show();

            if(tipo == 'TIMBRADO')
            {
                $.ajax({
                    type: 'GET',
                    url: 'http://denken.com.mx:380/cfdi_3_3/php/cancelar_pago_3_3.php',
                    data : {'empresa':idEmpresa, 'registro': idCFDI},
                    success: function(data)
                    {
                        var n = data.indexOf("OK");
                        if(n < 0)
                        {
                            mandarMensaje("Error al enviar petición para cancelar pago: " + data);
                        }else{
                            if(parseInt(actualizarEstatusPago(id,'P')) == parseInt(id))
                            {
                                muestraRegistro(id);
                                muestraRegistroDetalle(id);
                                mandarMensaje('El pago se mando a cancelar de manera correcta, verificar la respuesta del receptor.');
                                
                            }else
                            mandarMensaje('No se puedo enviar la petición de cancelar el pago');  //vacio
                            
                        }

                        $('#fondo_cargando').hide();   
                    },
                    error: function (xhr) {
                        //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* Error al enviar petición para cancelar pago');
                    }
                });
            }else{
                if(parseInt(actualizarEstatusPago(id,'C')) == parseInt(id))
                {
                    muestraRegistro(id);
                    muestraRegistroDetalle(id);
                    mandarMensaje('El pago se cancelo de manera correcta.');
                    $('#fondo_cargando').hide();
                }else{
                    mandarMensaje('No se puedo enviar la petición de cancelar *'); //vacio
                    $('#fondo_cargando').hide();
                }
            }
        });

        $('#b_verificar_estatus').click(function(){
            var id = $('#i_id').val();
            var idCFDI = $('#i_id_cfdi').val();
            var idEmpresa = $('#i_empresa_fiscal').attr('alt2');
            $('#fondo_cargando').show();
            $.ajax({
                type: 'GET',
                url: 'http://denken.com.mx:380/cfdi_3_3/php/verifica_status_pago.php',
                data : {'empresa':idEmpresa, 'registro': idCFDI},
                success: function(data)
                {
                    if(data == 1)
                    {  //bajamos xml y actualizamos estatus a cancelada en ginther
                        $.ajax({
                            type: 'POST',
                            url: 'php/pagos_descargar_acuse.php',
                            data : {'idPago':id, 'idCFDI': idCFDI},
                            success: function(data)
                            {
                                console.log('*'+data+'*');
                                if(data > 0)
                                {
                                    muestraRegistro(data);
                                    muestraRegistroDetalle(data);
                                    mandarMensaje('Se aprobó la cancelación.');
                                }else{
                                    mandarMensaje('Error al descargar acuse y actualizar');
                                }

                            },
                            error: function (xhr) {
                                //console.log('php/pagos_descargar_acuse.php --> '+JSON.stringify(xhr));
                                mandarMensaje('* Error al descargar acuse y actualizar');
                            }
                        });
                    }else if(data == 2)
                    {
                        mandarMensaje('El pago no ha sido aprobada por el cliente favor de intentarlo mas tarde');
                    }else{
                        ///actualizamos estatus a timbrado 

                        if(parseInt(actualizarEstatusPago(id,'T')) == parseInt(id))
                        {
                            muestraRegistro(id);
                            muestraRegistroDetalle(id);
                            mandarMensaje('Rechazada. Se actualizó estatus a timbrado.');
                        }else{
                            mandarMensaje('No se puedo actualizar estatus a timbrado');  //vacio
                        }
                    }

                    $('#fondo_cargando').hide();   
                },
                error: function (xhr) {
                    //console.log('php/verifica_status_pago.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al generar timbre');
                }
            });
        });


        $('#b_nuevo').click(function(){
            limpiar();
        });

        function limpiar(){
            $('#forma_general input,select').prop('disabled',false).val('');
            $('#b_buscar_empresa_fiscal,#b_buscar_facturas').prop('disabled',false);
            $('#t_facturas_pagadas tbody').html('');
            $('#t_facturas tbody').html('');
            $('#div_facturas_pagadas_detalle').css('display','none');
            $('#div_facturas_a_pagar').css('display','block'); 
            $('#div_estatus').html('');
            $('#div_b_verificar_estatus,#div_b_descargar_acuse,.secundarios ').css('display','none');
            $('#div_b_guardar,#div_b_sustituir').css('display','block');

            $('#b_guardar').prop('disabled', false);

            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            
            muestraConceptosCxP('s_concepto',5);
            muestraSelectFormaPago('PUE','s_forma_pago');
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_banco', 0,1,idUnidadActual);
            muestraSelectMetodoPago('s_metodo_pago');

            $('#s_razon_social').select2().html('');

            $('#i_fecha').val(hoy);

            $('#div_relacion_pagos').css('display','none');

            habilitaBotonFacturas();
            $('form').validationEngine('hide');

            muestraSelectUnidades(matriz,'s_filtro_unidad',idUnidadActual);
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);

            //-->NJES May/07/2020 si la unindad es alarmas mostrar checkbox para buscar facturas a venta publico en general
            if(idUnidadActual == 2)
                $('#div_venta_publico_general').css('display','block');
            else{
                $('#div_venta_publico_general').css('display','none');
                $('#ch_factura_por_rfc').prop('disabled',false);
            }

            $('#ch_venta_publico_general').prop('checked',false);
            $('#s_metodo_pago').prop('disabled',false);
            $('#s_razon_social').prop('disabled',false);
            $('#b_buscar_clientes').prop('disabled',false);

            $("#s_razones").html("<option disabled selected value='0'>...</option>");
            $("#s_razones").prop("disabled", true);
            $("#i_rfc").val("");
            $("#i_rfc").prop("disabled", true);
                
        }

        $('#b_descargar_pdf').click(function(){
            var datos = {
                'path':'formato_pago',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Recibo de Pagos',
                'tipo':1
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        });

        $('#b_descargar_acuse').click(function(){

            var datos = {
                'path':'formato_acuse_pago',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Acuse_Pago',
                'tipo':1
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');

        });

        $('#b_descargar_xml').click(function(){
            var idPago = $('#i_id').val();
            var folio = $('#i_folio').val();

            window.open("php/pagos_descargar_xml.php?id=" + idPago + "&folio=" + folio);
        });

        $('#b_enviar_correo').click(function(){
            var idPago=$('#i_id').val();
            var folio=$("#i_folio").val();
            generaPdf(idPago,folio,'Pago','pago','pago');
        });

        $("#b_enviar").click(function (){
            var idPago = $(this).attr('idPago');
            var folioPago = $(this).attr('folioPago');
            var ruta = $(this).attr('ruta');
            var tipo = $(this).attr('tipo');
            var ruta = '../pagos/archivos/pago_'+folioPago+'_'+idPago;

            mandaCorreo(idPago,folioPago,ruta,tipo);
        });

        function generaPdf(id,folio,nombreArchivo,tipo,tipoAr){
            var ruta = '../pagos/archivos/'+tipoAr+'_'+folio+'_'+id;

            var datos = {
                'path':'formato_pago',
                'idRegistro':id,
                'folioFactura':folio,
                'nombreArchivo':nombreArchivo,
                'vp':tipo,
                'tipo':2  //guardar archivo en carpeta
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            $.get('php/convierte_pdf.php',{'D':datosJ},function(data)
            {
                if(data=='OK')
                    generaXml(id,folio,ruta,nombreArchivo,tipoAr);
                else
                    mandarMensaje(data);
            });
        }

        function generaXml(idPago,folioPago,ruta,nombreArchivo,tipoAr){
            $.post('php/pagos_generar_baja_xml.php',{'id':idPago,'folio':folioPago,'tipo':tipoAr},
            function(data_ruta)
            {
                if(data_ruta==0)
                {
                    mandarMensaje("Ocurrio un error al crear archivo xml");
                }else{
                    $('#t_enviar_correo >tbody tr').remove();   
                    var correo = $('#i_email').val();

                    $('#t_enviar_correo').append("<tr><td>Ingresa una o varias direcciones de correo electronico separado por coma<br/> para poder enviar correo con los documentos del pago timbrado <br/><br/><textarea type='text' class='form-control' id='dir_correo' name='dir_correo'>" + correo + "</textarea><br/><span class='ejemplo'>Ejemplo: usuario@denken.mx,usuario@correo.mx</span> </td></tr>");
                    $('#b_enviar').attr({'idPago':idPago,'folioPago':folioPago,'ruta':ruta,'tipo':nombreArchivo});

                    $("#dialog_correo").modal('show');
                    // viendo lo del correo         
                }
            });
        }

        function mandaCorreo(idPago,folioPago,ruta,tipo){
            if(validarEmail( $('#dir_correo').val()) =='')
            {

                $("#dialog_correo").modal('hide');

                $('#fondo_cargando').show();

                var datos = {
                    'ruta' : ruta,
                    'asunto' : tipo+" y documentos",
                    'mensaje' : tipo+" generado", 
                    'dest_mail' : $('#dir_correo').val(), 
                    'id' : idPago,
                    'folio' : folioPago
                };

                $.post('php/pagos_enviar_correo_timbres.php',{'datos':datos},function(data)
                {
                    if(data == 1)
                        mandarMensaje('Los archivos se enviaron correctamente');
                    else
                        mandarMensaje('Intento Fallido');


                    $('#fondo_cargando').hide();
                }); 
            }
            else
                mandarMensaje(validarEmail( $('#dir_correo').val()));
        }

        function validarEmail(email){
            var aux='';
            expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            
            if(email!=''){
                
                email=email.split(",");
                
                for(var i=0; i < email.length;i++){
                    if(email[i]!=''){
                        if ( !expr.test(email[i].trim()) )
                        aux+=("La dirección de correo " + email + " es incorrecta. <br/>");
                        else
                        aux+='';
                    }else{
                        aux+='El ultimo correo no debe terminar en ,';
                    } 
                }
            }else{
                aux+='Debe ingresar por lo menos un correo';
            }
            return aux;    
        }

        $('#b_sustituir').click(function(){
            $('#b_sustituir').prop('disabled',true);
            if ($('#forma_general').validationEngine('validate'))
            {
                if($('#t_facturas tr').length > 0)
                {
                    muestraPagosCancelados();
                }else{
                    mandarMensaje('Debe existir por lo menos un abono a una factura para guardar');
                }

                $('#b_sustituir').prop('disabled',false);
            }else{
                $('#b_sustituir').prop('disabled',false);
            }
        });

        function muestraPagosCancelados(){
            $('#t_pagos_cancelados tbody').html('');
            $('#i_filtro_pagos_cancelados').val('');

            var datos = {
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt'),
                'idRazonSocial' : $('#s_razon_social').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/pagos_buscar_cancelados.php',
                dataType:"json", 
                data:{'datos':datos}, 
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        for(var i=0;data.length>i;i++)
                        {
                            var html='<tr class="pagos_cancelados" alt="'+data[i].id+'">\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="UUID">'+data[i].folio_fiscal+'</td>\
                                        <td width="8%">\
                                            <input type="checkbox" class="ch_sustituir" name="ch_sustituir" value="'+data[i].id+'" id="ch_sustituir_'+data[i].id+'" alt="'+data[i].folio_fiscal+'">\
                                        </td>\
                                    </tr>';

                            $('#t_pagos_cancelados tbody').append(html);   
                        }

                    }else{
                        var html = '<tr><td colspan="3">No se encontraron regstros</td></tr>';
                        $('#t_pagos_cancelados tbody').append(html); 
                    }
                },
                error: function (xhr) {
                    console.log('php/pagos_buscar_cancelaos.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar pagos cancelados');
                }
            });

            $('#dialog_sustituir').modal('show');
        }

        $('#b_guardar_sustituir').click(function(){

            if(obtienePagosSustituir().length > 0)
            {
                mandarMensajeConfimacion('Se sustituiran los pagos cancelados con el nuevo, ¿Deseas continuar?',0,'aceptar_sustituir');
            }else{
                mandarMensaje('Debe existir por lo menos un pago seleccionado para sustituir.');
                $('#b_guardar_sustituir').prop('disabled',false);
            }
        });

        function obtienePagosSustituir(){
            var j = 0;
            var arreglo = [];

            $(".ch_sustituir").each(function(){
                if($(this).is(':checked'))
                {
                    var id = $(this).val();
                    var folioF = $(this).attr('alt');
                    arreglo[j] = {
                        'idPago' : id,
                        'tipo' : '04',
                        'uuidDoc' : folioF
                    };  

                    j++;
                }
            });

            return arreglo;
        }

        $(document).on('click','#b_aceptar_sustituir',function(){ 
            guardar('sustituir');
        });

        $('#b_ver_relacion_pagos').click(function(){
            var id = $(this).attr('alt');
            muestraPagosSustituidos(id);
        });

        function muestraPagosSustituidos(id){
            $('#t_pagos_relacionados tbody').html('');

            $.ajax({
                type: 'POST',
                url: 'php/pagos_buscar_pagos_sustituidos.php',
                dataType:"json", 
                data:{'idPago':id}, 
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        for(var i=0;data.length>i;i++)
                        {
                            var html='<tr>\
                                        <td data-label="Folio" style="text-align:left;">'+data[i].folio_interno+'</td>\
                                        <td data-label="UUID">'+data[i].folio_fiscal+'</td>\
                                        <td data-label="Monto">'+formatearNumero(data[i].total)+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                    </tr>';

                            $('#t_pagos_relacionados tbody').append(html);
                        }
                    }
                },
                error: function (xhr) {
                    console.log('php/pagos_buscar_pagos_sustituidos.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar pagos sustituidos');
                }
            });

            $('#dialog_relacion_pagos').modal('show');
        }

        $('#ch_venta_publico_general').click(function(){
            if($('#ch_venta_publico_general').is(':checked'))
            {
                $('#ch_factura_por_rfc').prop({'disabled':true,'checked':false});
                $('#s_metodo_pago').val('PUE').select2({placeholder: $(this).data('elemento')}).prop({'disabled':true,'selected':true});
                var idServicio = 0;
                var razonSocial = 'VENTA PUBLICO EN GENERAL';
                var rfc = 'XAXX010101000';
                $('#s_razon_social').append('<option value="'+idServicio+'" alt6="'+razonSocial+'">'+razonSocial+'<option>').prop('disabled',true);
                $('#i_cliente').val(razonSocial).attr('alt',idServicio).attr('alt2',razonSocial).attr('codigo_postal','');
                $('#i_rfc').val(rfc);
                $('#i_rfc_cliente').val(rfc);
                $('#b_buscar_clientes').prop('disabled',true);

                habilitaBotonFacturas();
            }else{
                $('#ch_factura_por_rfc').prop('disabled',false);
                $('#s_metodo_pago').prop('disabled',false);
                $('#s_razon_social').empty().prop('disabled',false);
                $('#i_cliente').val('').attr('alt','').attr('alt2','').attr('codigo_postal','');
                $('#i_rfc').val('');
                $('#i_rfc_cliente').val('');
                $('#b_buscar_clientes').prop('disabled',false);

                habilitaBotonFacturas();
            }
        });

        $("#s_clientes").on("change",function(){
            let idCliente = $(this).val();
            $("#i_rfc").val("");

            if(idCliente != null && idCliente != 0){
                //todo here
                let filtrados = objRazonesSociales.filter(x => x.id_cliente == idCliente);

                if(filtrados.length == 0){
                    $("#s_razones").html(`<option value="0" selected disabled>...</option>`);
                    mandarMensaje("No hay razon social en este cliente");
                    $("#s_razones").prop("disabled", true);
                }else{
                    if(filtrados.length > 1){
                        $("#s_razones").html(`<option value="0" selected disabled>...</option>`);
                        $("#s_razones").prop("disabled", false);
                    }else{
                        $("#s_razones").html(``);
                        $("#s_razones").prop("disabled", true);
                        setTimeout(() => {
                            $("#s_razones").trigger("change");
                        }, 300);
                    }
                    filtrados.forEach(ele => {
                        $("#s_razones").append(`<option value="${ele.id}">${ele.nombre_corto} - ${ele.razon_social} (${ele.estatus})</option>`);
                    });
                }
                $("#s_razones").select2();
            }
        });

        $("#s_razones").on("change",function(){
            let idRazon = $(this).val();

            let filtrado = objRazonesSociales.filter(x => x.id == idRazon);

            $("#i_rfc").val(filtrado[0].rfc);
        });

        function mostrarClientes(){
            $.ajax({
                type: 'POST',
                url: 'php/clientes_buscar.php',
                data:  {'estatus':0},
                success: function(data){

                    let arreglo = JSON.parse(data);

                    $("#s_clientes").html(`<option value="0" selected disabled>...</option>`);
                    
                    arreglo.forEach(element => {
                        $("#s_clientes").append(`<option value="${element.id}">${element.nombre_comercial}</option>`);
                    });

                    $("#s_clientes").select2();
                    
                },
                error: function (xhr){
                    console.log('php/clientes_buscar.php --> '+JSON.stringify(xhr));
                }
            });
        }

        function mostrarRazones(){
            $.ajax({
                type: 'POST',
                url: 'php/razones_sociales_buscar.php',
                data:  {'estatus':3},
                success: function(data){
                    objRazonesSociales = JSON.parse(data);                    
                },
                error: function (xhr){
                    console.log('php/razones_sociales_buscar.php --> '+JSON.stringify(xhr));
                }
            });
        } 
       
    });

</script>

</html>