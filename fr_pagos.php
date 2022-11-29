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
    .importes_pesos,
    #div_venta_publico_general{
        display:none;
    }

    .select2-container {
        width: 100% !important;
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
                        <div class="titulo_ban">Pagos</div>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_cont_estatus" style="text-align:center;">
                        <div id="div_estatus"></div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_pagos"><i class="fa fa-search" aria-hidden="true"></i> Buscar Pagos</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_guardar">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_sustituir">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_sustituir"><i class="fa fa-exchange" aria-hidden="true"></i> Sustituir</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_verificar_estatus">
                        <button type="button" class="btn btn-warning btn-sm form-control" id="b_verificar_estatus"><i class="fa fa-eye" aria-hidden="true"></i> Verificar Estatus</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_descargar_acuse">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_descargar_acuse"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar Acuse</button>
                    </div>
                    <div class="col-sm-12 col-md-2 secundarios botones_prefactura" id="div_b_cancelar">
                        <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                    </div>
                    <div class="col-md-2" id="div_relacion_pagos">
                        <label for="i_relacion_factura" class="col-form-label">Relación pagos</label>
                        <button type="button" class="btn btn-info" id="b_ver_relacion_pagos"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <!--<input type="text" id="i_relacion_factura" name="i_relacion_factura" class="form-control form-control-sm"  autocomplete="off" readonly>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-3 secundarios divs_alt"></div>
                    <div class="col-sm-12 col-md-3 secundarios botones_prefactura" id="div_b_cancelar"></div>
                    <div class="col-sm-12 col-md-2 secundarios botones_factura">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_descargar_pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar Pago</button>
                    </div>
                    <div class="col-sm-12 col-md-2 secundarios botones_factura">
                        <button type="button" class="btn btn-secondary btn-sm form-control" id="b_descargar_xml"><i class="fa fa-file-code-o" aria-hidden="true"></i> Descargar XML</button>
                    </div>
                    <div class="col-sm-12 col-md-2 secundarios botones_factura">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_enviar_correo"><i class="fa fa-envelope" aria-hidden="true"></i>  Enviar por Correo</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                
                <form id="forma_general" name="forma_general">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="s_id_unidades" class="col-form-label requerido">Unidad de Negocio </label>
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="s_id_sucursales" class="col-form-label requerido">Sucursal </label>
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="s_metodo_pago" class="col-form-label requerido">Método de Pago </label>
                                    <select id="s_metodo_pago" name="s_metodo_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="radio_moneda" class="col-form-label requerido">Moneda</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="radio" name="radio_moneda" id="r_MXN" value="MXN" checked> MXN
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="radio" name="radio_moneda" id="r_USD" value="USD"> USD
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row div_tipo_cambio" style="display:none;">
                                                <div class="col-md-12">
                                                    <label for="i_tipo_cambio" class="col-form-label requerido">Tipo de Cambio</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="i_tipo_cambio" name="i_tipo_cambio" class="form-control form-control-sm validate[required,custom[number],min[15]]" value="15.00"  autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="row">
                                <label for="s_empresa_fiscal" class="col-md-12 col-form-label requerido">Empresa Fiscal</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_empresa_fiscal" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <label for="i_cliente" class="col-sm-12 col-md-12 col-form-label requerido">Cliente</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_cliente" name="i_cliente" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="s_razon_social" class="col-form-label requerido">Razón Social (receptor)</label>
                            <select id="s_razon_social" name="s_razon_social" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                            <input type="hidden" id="i_email_cliente" name="i_email_cliente">
                            <input type="hidden" id="i_rfc_cliente" name="i_rfc_cliente">
                            <input type="hidden" id="i_pais_cliente" name="i_pais_cliente">
                            <input type="hidden" id="i_cp_cliente" name="i_cp_cliente">
                            <input type="hidden" id="i_email" name="i_email">
                        </div>
                        <div class="col-sm-12 col-md-1" id="div_b_buscar_facturas">
                            <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_facturas" disabled><i class="fa fa-search" aria-hidden="true"></i> Facturas</button>
                        </div>
                        <div class="col-md-2">
                            <label for="i_folio" class="col-form-label">Folio</label>
                            <input type="text" id="i_folio" name="i_folio" class="form-control form-control-sm"  autocomplete="off" readonly>
                            <input type="hidden" id="i_id" name="i_id">
                            <input type="hidden" id="i_id_cfdi" name="i_id_cfdi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2" id="div_venta_publico_general">
                            <input type="checkbox" name="ch_venta_publico_general" id="ch_venta_publico_general" > Venta Publico General
                        </div>
                        <div class="col-md-2 div_por_rfc">
                            <input type="checkbox" name="ch_factura_por_rfc" id="ch_factura_por_rfc" > Pago por RFC
                        </div>
                        <div class="col-md-3 div_por_rfc">
                            <div class="row">
                                <label for="i_rfc" class="col-md-2 col-form-label requerido">RFC</label>
                                <div class="col-md-9">
                                    <input type="text" id="i_rfc" name="i_rfc" class="form-control form-control-sm validate[required,minSize[12],maxSize[13]]"  autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <label for="i_importe" class="col-md-3 col-form-label">Importe</label>
                                <div class="col-md-8">
                                    <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm"  autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 div_tipo_cambio" style="display:none;">
                            <div class="row">
                                <label class="col-md-5 col-form-label">Importe MXN</label>
                                <div class="col-md-5">
                                    <input type="text" id="i_importe_pesos" name="i_importe_pesos" class="form-control form-control-sm"  autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <table width="100%">
                        <td align="right">
                            <span style="color:green; font-size:12px;">*El importe capturado es en la moneda seleccionada</span>
                        </td>
                    </table>
                    <div class="row form-group" id="div_facturas_a_pagar">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon">
                                <thead>
                                    <tr class="renglon">
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Folio</th>
                                        <th scope="col">UUID</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Saldo Inicial</th>
                                        <th scope="col" class="importes_pesos">Saldo Inicial MXN</th>
                                        <th scope="col">Abonos</th>
                                        <th scope="col" class="importes_pesos">Abonos MXN</th>
                                        <th scope="col">Saldo Restante</th>
                                        <th scope="col" class="importes_pesos">Saldo Restante MXN</th>
                                        <th scope="col">Monto a Pagar</th>
                                        <th scope="col" class="importes_pesos">Monto a Pagar MXN</th>
                                        <th scope="col">Referencia</th>
                                        <th scope="col" width="5%"></th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="div_t_facturas">
                                <table class="tablon"  id="t_facturas">
                                    <tbody>
                                        
                                    </tbody>
                                </table>  
                            </div>  
                        </div>
                    </div>

                    <div class="row form-group" id="div_facturas_pagadas_detalle">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon">
                                <thead>
                                    <tr class="renglon">
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Folio</th>
                                        <th scope="col">UUID</th>
                                        <th scope="col">Monto a Pagar</th>
                                        <th scope="col" class="importes_pesos">Monto a Pagar MXN</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="div_t_facturas_pagadas">
                                <table class="tablon"  id="t_facturas_pagadas">
                                    <tbody>
                                        
                                    </tbody>
                                </table>  
                            </div>  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-1">
                            <div class="form-check">
                                <input class="form-check-input" id="ch_psf" type="checkbox">
                                <label class="form-check-label">PSF</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1">
                            <label for="s_concepto" class="col-form-label requerido">Concepto</label>
                        </div>
                        <div class="col-md-3">
                            <select id="s_concepto" name="s_concepto" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-1">
                            <label for="i_banco_cliente" class="col-form-label">Banco del Cliente</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="i_banco_cliente" name="i_banco_cliente" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <label for="i_cuenta_cliente" class="col-form-label">Número de cuenta del cliente</label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="i_cuenta_cliente" name="i_cuenta_cliente" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <label for="s_forma_pago" class="col-form-label requerido">Forma de Pago</label>
                        </div>
                        <div class="col-md-3">
                            <select id="s_forma_pago" name="s_forma_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-1">
                            <label for="s_banco" class="col-form-label requerido">Banco</label>
                        </div>
                        <div class="col-md-3">
                            <select id="s_banco" name="s_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="i_cuenta_cliente" class="col-form-label requerido">Fecha de aplicación del pago</label>
                                </div>
                                <div class="input-group col-md-5">
                                    <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm fecha validate[required]" autocomplete="off" readonly>
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

<div id="dialog_clientes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Clientes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_cliente" id="i_filtro_cliente" alt="renglon_cliente" class="filtrar_renglones form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_clientes">
                    <thead>
                        <tr class="renglon">
                            <th scope="col" style="text-align:left;">ID</th>
                            <th scope="col">Nombre Comercial</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">Fecha Inicio</th>
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
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_empresa_fiscal" id="i_filtro_empresa_fiscal" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off" alt="renglon_empresa_fiscal"></div>
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
            <h5 class="modal-title">Búsqueda de Pagos</h5>
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
                                    <th scope="col">Factura</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Empresa Fiscal</th>
                                    <th scope="col">RFC</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Fecha</th>
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
            <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>

<div id="dialog_buscar_facturas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Facturas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">  
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <input type="text" name="i_filtro_facturas" id="i_filtro_facturas" class="form-control form-control-sm filtrar_renglones" alt="renglon_facturas" placeholder="Filtrar" autocomplete="off">
                    </div>
                    <div class="col-sm-12 col-md-5">
                        Mostrar facturas con saldo insoluto cero <input type="checkbox" id="ch_saldo_insoluto_cero" name="ch_saldo_insoluto_cero" value="">
                    </div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_facturas_buscar">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Folio</th>
                                    <th scope="col">UUID</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Saldo Inicial</th>
                                    <th scope="col">Abonos</th>
                                    <th scope="col">Saldo Insoluto</th>
                                    <th scope="col" width="5%"></th>
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

<div id="dialog_correo" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enviar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table id="t_enviar_correo" >
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">    
                <button type="button" class="btn btn-primary" id="b_enviar"><span class="glyphicon glyphicon-floppy-save"></span> Enviar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_sustituir" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Pagos a Sustituir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6"> 
                        <input type="text" name="i_filtro_pagos_cancelados" id="i_filtro_pagos_cancelados" class="form-control form-control-sm filtrar_renglones" alt="pagos_cancelados" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Folio</th>
                                    <th scope="col">UUID</th>
                                    <th scope="col" width="9%"></th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_pagos_cancelados">
                            <table class="tablon"  id="t_pagos_cancelados">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">   
                <button type="button" class="btn btn-success btn-sm" id="b_guardar_sustituir"><i class="fa fa-exchange" aria-hidden="true"></i> Sustituir</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_relacion_pagos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relación de Pagos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Folio</th>
                                    <th scope="col">UUID</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_pagos_relacionados">
                            <table class="tablon"  id="t_pagos_relacionados">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">    
                <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_pagos_psf" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagos sin Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="s_pagos_psf">Pagos</label>
                            <select class="form-control" id="s_pagos_psf"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" id="btnGuardarPSF">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-sm" tabindex="-1" aria-labelledby="mySmallModalLabel" id="modal_alerta_confirm" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Mensaje del sistema</h5>
        </div>
        <div class="modal-body">
            <p>¿Quieres que se muestren los documentos relacionados en el formato?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger b_imprimir_pdf_confirm" alt="NO">No</button>
            <button  type="button" class="btn btn-primary b_imprimir_pdf_confirm" alt="SI"> Si</button>
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

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        
        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        muestraSelectUnidades(matriz,'s_filtro_unidad',idUnidadActual);
        muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);

        muestraConceptosCxPPagos('s_concepto',5);
        muestraSelectFormaPago('PUE','s_forma_pago');
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        muestraCuentasBancos('s_banco', 0,1,idUnidadActual);
        muestraSelectMetodoPago('s_metodo_pago');

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

        $('#b_buscar_clientes').click(function(){
            
            if($('#s_id_unidades').find('option:selected').text()=='ALARMAS')
            {
                $('#i_filtro_cliente').val('');
                muestraModalServicios('renglon_cliente','t_clientes tbody','dialog_clientes');
            }
            else
            {
                $('#i_filtro_cliente').val('');
                muestraModalClientes('renglon_cliente','t_clientes tbody','dialog_clientes');
            }

        });

        $('#t_clientes').on('click', '.renglon_cliente', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_cliente').attr('alt',id).val(nombre);

            $('#i_pais_cliente').val('');
            $('#i_rfc_cliente').val('');
            $('#i_email_cliente').val('');
            $('#i_email').val('');
            $('#i_cp_cliente').val('');
            $('#i_rfc').val('');

            if($('#s_id_unidades').find('option:selected').text()=='ALARMAS'){

                var razonSocial = $(this).attr('alt3');
                $('#s_razon_social').empty();
                $('#s_razon_social').append('<option value="'+id+'" alt6="'+razonSocial+'">'+razonSocial+'<option>');
                var rfc = $(this).attr('alt4');
                var correo = $(this).attr('alt6');
                var cp = $(this).attr('alt5');
                var pais = $(this).attr('alt7');
                
                //-->NJES April/03/2020 verifica si el rfc del nuevo cliente seleccionado es igual al de las partidas para poder buscar mas facturas
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
                
                $('#i_pais_cliente').val(pais);
                $('#i_rfc_cliente').val(rfc);
                $('#i_email_cliente').val(correo);
                $('#i_email').val(correo);
                $('#i_cp_cliente').val(cp);

                //$('.div_por_rfc').css('display','block');
            }//else{
               // $('.div_por_rfc').css('display','none');
               // $('#ch_factura_por_rfc').prop('checked',false);
            //}

            

            $('#dialog_clientes').modal('hide'); 
            

            if($('#s_id_unidades').val() != '')
            {

                if($('#s_id_unidades').find('option:selected').text()!='ALARMAS'){
                    $('#i_email').val('');
                    muestraSelectRazonesSociales(id,$('#s_id_unidades').val(),'s_razon_social');
                }
            }

            habilitaBotonFacturas();
        });

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

        $('#b_buscar_facturas').click(function()
        {

            $('#ch_saldo_insoluto_cero').prop('checked', false);
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
            if($('#s_id_unidades').val() != '' && $('#s_id_sucursales').val() != '' && $('#s_metodo_pago').val() && $('#i_empresa_fiscal').val() != '' && $('#i_cliente').val() != '' && $('#s_razon_social').val())
                $('#b_buscar_facturas').prop('disabled',false);
            else
                $('#b_buscar_facturas').prop('disabled',true);
        }

        $('#ch_saldo_insoluto_cero').change(function()
        {
            mostrarFacturas();
        });

        function mostrarFacturas()
        {

            $('#i_filtro_facturas').val('');
            $('#t_facturas_buscar tbody').html('');
            $('#b_buscar_facturas').prop("disabled", true);

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
                'nombreUnidad' : $('#s_id_unidades').find('option:selected').text(),
                'saldo_insoluto_cero' : $("#ch_saldo_insoluto_cero").is(':checked') ? 1 : 0,
                //-->NJES Jun/11/2021 filtra por moneda
                'moneda' : $('input[name=radio_moneda]:checked').val()
            };
            //url: 'php/facturacion_buscar_facturas_idCliente.php',
            //console.log('cliente ' +  $('#i_cliente').attr('alt'));
            //console.log('fiscal ' +  $('#s_razon_social').val());
            //console.log('razon ' +$('#i_empresa_fiscal').attr('alt'));
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_facturas_idCliente_un_cxc.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data) {
                    //console.log(data);
                    if(data.length != 0){                    
                        for(var i=0;data.length>i;i++){

                            var botonInfo = '';
                            if(parseFloat(data[i].saldo_insoluto) <= 0 && parseFloat(data[i].saldo_insoluto_moneda) > 0)
                            {
                                botonInfo='<button type="button" class="btn btn-info btn-sm" data-trigger="focus" data-toggle="popover" data-placement="top" title="Importante!" data-container="body" data-content="El saldo insoluto en pesos es menor a 0, pero el saldo insoluto de la moneda original $'+formatearNumero(data[i].saldo_insoluto_moneda)+' aun no esta liquidado.">\
                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                </button>';
                            }

                            //-->NJES April/03/2020 se agregan nuevos atributos en cada registro 
                            var html='<tr class="renglon_facturas " alt="'+data[i].id+'" unidad="'+$('#s_id_unidades').val()+'" sucursal="'+data[i].id_sucursal+'" empresa_fiscal="'+$('#i_empresa_fiscal').attr('alt')+'" metodo_pago="'+$('#s_metodo_pago').val()+'" razon_social="'+$('#s_razon_social').val()+'" id_cliente="'+data[i].id_cliente+'" cliente="'+data[i].cliente+'" rfc_razon_social="'+data[i].rfc_razon_social+'" registrosCXC="'+data[i].registros_cxc+'" fecha="'+data[i].fecha+'" folio="'+data[i].folio+'" uuid="'+data[i].folio_uuid+'" cargo="'+data[i].saldo_inicial+'" abono="'+formatearNumero(parseFloat(data[i].total_abonos)+parseFloat(data[i].abonos_nc))+'" saldo="'+data[i].saldo_insoluto+'" referencia="'+data[i].referencia+'" moneda="'+data[i].moneda+'" cargo_original="'+data[i].cargo_original+'" abono_original="'+data[i].abono_original+'" saldo_original="'+data[i].saldo_original+'">\
                                        <td data-label="Folio" class="renglon_facturas_s">'+data[i].folio+'</td>\
                                        <td data-label="UUID" class="renglon_facturas_s">'+data[i].folio_uuid+'</td>\
                                        <td data-label="Cliente" class="renglon_facturas_s">'+data[i].cliente+'</td>\
                                        <td data-label="Sucursal" class="renglon_facturas_s">'+data[i].sucursal+'</td>\
                                        <td data-label="Fecha" class="renglon_facturas_s">'+data[i].fecha+'</td>\
                                        <td data-label="Saldo Inicial" class="renglon_facturas_s">'+formatearNumero(data[i].saldo_inicial)+'</td>\
                                        <td data-label="Abonos" class="renglon_facturas_s">'+formatearNumero(parseFloat(data[i].total_abonos)+parseFloat(data[i].abonos_nc))+'</td>\
                                        <td data-label="Saldo Insoluto" class="renglon_facturas_s">'+formatearNumero(data[i].saldo_insoluto)+'</td>\
                                        <td width="5%">'+botonInfo+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_facturas_buscar tbody').append(html);   
                        }

                        $('[data-toggle="popover"]').popover();
                    }else{
                        var html='<tr class="renglon_fact">\
                                        <td colspan="9">No se encontró información</td>\
                                    </tr>';

                        $('#t_facturas_buscar tbody').append(html);
                    }

                    $('#dialog_buscar_facturas').modal('show');
                    $('#b_buscar_facturas').prop("disabled", false);
                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_facturas_idCliente_un_cxc.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas.');
                    $('#b_buscar_facturas').prop("disabled", false);
                }
            });
        }

        $('#t_facturas_buscar').on('click', '.renglon_facturas_s', function(){
            var idFactura = $(this).parent().attr('alt');
            var registrosCXC = $(this).parent().attr('registrosCXC');
            var multipleCXC = (registrosCXC==1)?0:1;

            if(facturaAgregada(idFactura) == '')
            {
                var fecha = $(this).parent().attr('fecha');
                var folio = $(this).parent().attr('folio');
                var uuid = $(this).parent().attr('uuid');
                var saldo_inicial = $(this).parent().attr('cargo');
                var total_abonos = $(this).parent().attr('abono');
                var saldo_insoluto = $(this).parent().attr('saldo');
                var referencia = $(this).parent().attr('referencia');
                //-->NJES April/03/2020 se toman vaores de nuevos atributos
                var rfc_razon_social = $(this).parent().attr('rfc_razon_social');
                var idCliente = $(this).parent().attr('id_cliente');
                var cliente = $(this).parent().attr('cliente');

                var unidad = $(this).parent().attr('unidad');
                var sucursal = $(this).parent().attr('sucursal');
                var empresa_fiscal = $(this).parent().attr('empresa_fiscal');
                var metodo_pago = $(this).parent().attr('metodo_pago');
                var razon_social = $(this).parent().attr('razon_social');

                //-->NJES Jun/11/2021 si la moeda es dolares mostrar los importes originales, porque se muestran los importes en pesos
                var moneda = $(this).parent().attr('moneda');
                var saldo_inicial_original = $(this).parent().attr('cargo_original');
                var total_abonos_original = $(this).parent().attr('abono_original');
                var saldo_insoluto_original = $(this).parent().attr('saldo_original');

                //-->NJES April/03/2020 compara si la nueva factura a agregar tiene los mismos registros de llaves que las partidas actuales
                //sino las borra y agrega con las nuevas caracteristicas
                var mensaje = verificaLlaves(unidad,sucursal,empresa_fiscal,metodo_pago,razon_social,idCliente,moneda);
                //console.log(mensaje);
                if(verificaLlaves(unidad,sucursal,empresa_fiscal,metodo_pago,razon_social,idCliente,moneda) != '')
                {
                    $('#t_facturas tbody').empty();
                    mandarMensaje(mensaje);

                    if(moneda != 'USD')
                    {
                        var html='<tr class="factura_pagar" alt="'+idFactura+'" unidad="'+unidad+'" sucursal="'+sucursal+'" empresa_fiscal="'+empresa_fiscal+'" metodo_pago="'+metodo_pago+'" razon_social="'+razon_social+'" id_cliente="'+idCliente+'" rfc_razon_social="'+rfc_razon_social+'" registrosCXC="'+multipleCXC+'" folio="'+folio+'" uuid="'+uuid+'" saldo_restante="'+saldo_insoluto+'" saldo_restante_original="'+saldo_insoluto_original+'" moneda="'+moneda+'">\
                            <td data-label="Fecha">'+fecha+'</td>\
                            <td data-label="Folio">'+folio+'</td>\
                            <td data-label="UUID">'+uuid+'</td>\
                            <td data-label="Cliente">'+cliente+'</td>\
                            <td data-label="Saldo Inicial">'+formatearNumero(saldo_inicial)+'</td>\
                            <td data-label="Abonos">'+formatearNumero(total_abonos)+'</td>\
                            <td data-label="Saldo Restante">'+formatearNumero(saldo_insoluto)+'</td>\
                            <td data-label="Monto a Pagar"><input id="i_monto_'+idFactura+'" type="text" alt="'+saldo_insoluto+'" saldo_original="'+saldo_insoluto_original+'" class="montos form-control form-control-sm validate[required,min[0.1]] numeroMoneda" value="" autocomplete="off"></td>\
                            <td data-label="Referencia">'+referencia+'</td>\
                            <td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>\
                        </tr>';
                    }else{
                        var html='<tr class="factura_pagar" alt="'+idFactura+'" unidad="'+unidad+'" sucursal="'+sucursal+'" empresa_fiscal="'+empresa_fiscal+'" metodo_pago="'+metodo_pago+'" razon_social="'+razon_social+'" id_cliente="'+idCliente+'" rfc_razon_social="'+rfc_razon_social+'" registrosCXC="'+multipleCXC+'" folio="'+folio+'" uuid="'+uuid+'" saldo_restante="'+saldo_insoluto+'" saldo_restante_original="'+saldo_insoluto_original+'" moneda="'+moneda+'">\
                            <td data-label="Fecha">'+fecha+'</td>\
                            <td data-label="Folio">'+folio+'</td>\
                            <td data-label="UUID">'+uuid+'</td>\
                            <td data-label="Cliente">'+cliente+'</td>\
                            <td data-label="Saldo Inicial">'+formatearNumero(saldo_inicial_original)+'</td>\
                            <td class="importes_pesos" data-label="Saldo Inicial MXN">'+formatearNumero(saldo_inicial)+'</td>\
                            <td data-label="Abonos">'+formatearNumero(total_abonos_original)+'</td>\
                            <td class="importes_pesos" data-label="Abonos MXN">'+formatearNumero(total_abonos)+'</td>\
                            <td data-label="Saldo Restante">'+formatearNumero(saldo_insoluto_original)+'</td>\
                            <td class="importes_pesos" data-label="Saldo Restante MXN">'+formatearNumero(saldo_insoluto)+'</td>\
                            <td data-label="Monto a Pagar"><input id="i_monto_'+idFactura+'" type="text" alt="'+saldo_insoluto+'" saldo_original="'+saldo_insoluto_original+'" class="montos form-control form-control-sm validate[required,min[0.1]] numeroMoneda" value="" autocomplete="off"></td>\
                            <td class="importes_pesos" data-label="Monto a Pagar MXN"></td>\
                            <td data-label="Referencia">'+referencia+'</td>\
                            <td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>\
                        </tr>';
                    }
                }else{
                    if(moneda != 'USD')
                    {
                        var html='<tr class="factura_pagar" alt="'+idFactura+'" unidad="'+unidad+'" sucursal="'+sucursal+'" empresa_fiscal="'+empresa_fiscal+'" metodo_pago="'+metodo_pago+'" razon_social="'+razon_social+'" id_cliente="'+idCliente+'" rfc_razon_social="'+rfc_razon_social+'" registrosCXC="'+multipleCXC+'" folio="'+folio+'" uuid="'+uuid+'" saldo_restante="'+saldo_insoluto+'" saldo_restante_original="'+saldo_insoluto_original+'" moneda="'+moneda+'">\
                                <td data-label="Fecha">'+fecha+'</td>\
                                <td data-label="Folio">'+folio+'</td>\
                                <td data-label="UUID">'+uuid+'</td>\
                                <td data-label="Cliente">'+cliente+'</td>\
                                <td data-label="Saldo Inicial">'+formatearNumero(saldo_inicial)+'</td>\
                                <td data-label="Abonos">'+formatearNumero(total_abonos)+'</td>\
                                <td data-label="Saldo Restante">'+formatearNumero(saldo_insoluto)+'</td>\
                                <td data-label="Monto a Pagar"><input id="i_monto_'+idFactura+'" type="text" alt="'+saldo_insoluto+'" saldo_original="'+saldo_insoluto_original+'" class="montos form-control form-control-sm validate[required,min[0.1]] numeroMoneda" value="" autocomplete="off"></td>\
                                <td data-label="Referencia">'+referencia+'</td>\
                                <td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>\
                            </tr>';
                    }else{
                        var html='<tr class="factura_pagar" alt="'+idFactura+'" unidad="'+unidad+'" sucursal="'+sucursal+'" empresa_fiscal="'+empresa_fiscal+'" metodo_pago="'+metodo_pago+'" razon_social="'+razon_social+'" id_cliente="'+idCliente+'" rfc_razon_social="'+rfc_razon_social+'" registrosCXC="'+multipleCXC+'" folio="'+folio+'" uuid="'+uuid+'" saldo_restante="'+saldo_insoluto+'" saldo_restante_original="'+saldo_insoluto_original+'" moneda="'+moneda+'">\
                                <td data-label="Fecha">'+fecha+'</td>\
                                <td data-label="Folio">'+folio+'</td>\
                                <td data-label="UUID">'+uuid+'</td>\
                                <td data-label="Cliente">'+cliente+'</td>\
                                <td data-label="Saldo Inicial">'+formatearNumero(saldo_inicial_original)+'</td>\
                                <td class="importes_pesos" data-label="Saldo Inicial MXN">'+formatearNumero(saldo_inicial)+'</td>\
                                <td data-label="Abonos">'+formatearNumero(total_abonos_original)+'</td>\
                                <td class="importes_pesos" data-label="Abonos MXN">'+formatearNumero(total_abonos)+'</td>\
                                <td data-label="Saldo Restante">'+formatearNumero(saldo_insoluto_original)+'</td>\
                                <td class="importes_pesos" data-label="Saldo Restante MXN">'+formatearNumero(saldo_insoluto)+'</td>\
                                <td data-label="Monto a Pagar"><input id="i_monto_'+idFactura+'" type="text" alt="'+saldo_insoluto+'" saldo_original="'+saldo_insoluto_original+'"  class="montos form-control form-control-sm validate[required,min[0.1]] numeroMoneda" value="" autocomplete="off"></td>\
                                <td class="importes_pesos" data-label="Monto a Pagar MXN"></td>\
                                <td data-label="Referencia">'+referencia+'</td>\
                                <td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>\
                            </tr>';
                    }
                }

                $('#t_facturas tbody').append(html);

                if(moneda != 'USD')
                    $('.importes_pesos').hide();
                else
                    $('.importes_pesos').show();
                            
                $('#dialog_buscar_facturas').modal('hide');
            }else
                mandarMensaje('La factura ya fue agregada, intenta con otra.');
    
        });

        function verificaLlaves(unidad,sucursal,empresa_fiscal,metodo_pago,razon_social,cliente,moneda){
            var mensaje = '';

            if($('#t_facturas .factura_pagar').length > 0)
            {
                $("#t_facturas .factura_pagar").each(function(index) {
                    //if(index == 0)
                    //{
                        var unidad_R = $(this).attr('unidad');
                        var sucursal_R = $(this).attr('sucursal');
                        var empresa_fiscal_R = $(this).attr('empresa_fiscal');
                        var metodo_pago_R = $(this).attr('metodo_pago');
                        var razon_social_R = $(this).attr('razon_social');
                        var cliente_R = $(this).attr('id_cliente');
                        var moneda_R = $(this).attr('moneda');

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
                        }else if(empresa_fiscal_R != empresa_fiscal)
                        {
                            mensaje+='<p>La unidad empresa fiscal no es igual a la de las facturasseleccionadas para las partidas por lo que se quitaron.</p>';
                            return false;
                        }else if(metodo_pago_R != metodo_pago)
                        {
                            mensaje+='<p>El metodo pago seleccionado no es igual a la de las facturas seleccionadas para las partidas por lo que se quitaron.</p>';
                            return false;
                        }else if(moneda_R != moneda){
                            mensaje+='<p>La moneda seleccionada no es igual a la de las facturas seleccionadas para las partidas por lo que se quitaron.</p>';
                            return false;
                        }else if($('#ch_factura_por_rfc').is(':checked') == false && razon_social_R != razon_social)
                        {
                            mensaje+='<p>La razón social seleccionada no es igual a la de las facturas seleccionadas para las partidas por lo que se quitaron.</p>';
                            return false;
                        }else if($('#ch_factura_por_rfc').is(':checked') == false && cliente_R != cliente && $('#s_id_unidades').find('option:selected').text()=='ALARMAS')
                        {
                            mensaje+='<p>El cliente seleccionada no es igual al de las facturas seleccionadas para las partidas por lo que se quitaron.</p>';
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
            var renglon = $(this).parent().parent();
            var monto = quitaComa($(this).val());

            if($('#r_USD').is(':checked'))
                var saldoAnterior = $(this).attr('saldo_original');
            else
                var saldoAnterior = $(this).attr('alt');

            if(parseFloat(monto) <= parseFloat(saldoAnterior))
            {
                if(monto == '')
                    $(this).val(0);

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
            var importePesos = 0;

            //-->NJES Feb/25/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
            $('.factura_pagar').each(function(){
                var renglon = $(this);

                var id = $(this).attr('alt');
                if($('#i_monto_'+id).val() != '')
                {
                    var valor = parseFloat(quitaComa($('#i_monto_'+id).val()))*1000;

                    //-->NJES Jun/11/2021 si la moneda es dolares; cada que se edite el tipo de cambio o el monto a pagar 
                    //se actualiza el importe de la factura a pagar en pesos
                    if($('#r_USD').is(':checked'))
                    {
                        var val = parseFloat(quitaComa($('#i_monto_'+id).val()));
                        var tipoCambio = parseFloat($('#i_tipo_cambio').val());
                        var importeP = calculaImportesEnPHP(3,0,val,tipoCambio);
                        renglon.find('td').eq(11).text('').append(formatearNumero(importeP));
                    }

                }else{
                    var valor = 0;

                    if($('#r_USD').is(':checked'))
                    {
                        renglon.find('td').eq(11).text('');
                    }
                }
                
                importe=importe+valor;
            });

            var total = parseFloat(importe)/1000;

            $('#i_importe').val(formatearNumero(total));

            //-->NJES Jun/11/2021 si la moneda es dolares; cada que se edite el tipo de cambio o el monto a pagar 
            //se actualiza el importe total a pagar en pesos 
            if($('#r_USD').is(':checked'))
            {
                var tipoCambio = parseFloat($('#i_tipo_cambio').val());
                importePesos = calculaImportesEnPHP(3,0,total,tipoCambio);
                $('#i_importe_pesos').val(formatearNumero(importePesos));
            }
        }

        $('#t_facturas').on('click', '#b_eliminar', function()
        {
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
            var idCliente = $('#i_cliente').attr('alt');
            var idSucursal = $('#s_id_sucursales').val();

            $('#b_guardar').prop('disabled',true);
            if ($('#forma_general').validationEngine('validate'))
            {
                if($('#t_facturas .factura_pagar').length > 0)
                {
                    //-->NJES April/03/2020 verifica si es un pago por mismo rfc para que minimo exista una partida para el cliente
                    //y otra para cliete diferete pero mismo rfc
                    if($('#ch_factura_por_rfc').is(':checked'))
                    {
                        if($('#s_id_unidades').find('option:selected').text() == 'ALARMAS')
                        {

                            var idsServicios = idServicioMismoRFC();
                            //console.log(' '+idsServicios.length+' * '+JSON.stringify(idsServicios).indexOf(idCliente)+' '); 
                            if(idsServicios.length > 1 && JSON.stringify(idsServicios).indexOf(idCliente) != -1){
                                
                                if($("#ch_psf").is(":checked")) {
                                    mostrarModalPSF();
                                }else{
                                    guardar('pago');
                                }  
                            }else
                            {
                                mandarMensaje('Debe existir por lo menos una factura para el cliente seleccionado y una factura para diferente cliente pero mismo RFC.');
                                $('#b_guardar').prop('disabled',false);
                            }

                        }
                        else
                        {

                            //-->NJES April/20/2020 se agrega funcion para validar que cuando es pago por rfc y es 
                            //unidad diferente de alarmas tenga partidas igual y diferente de sucursal pero mismo rfc
                            var idsSucursales = idSucursalMismoRFC();
                            console.log(' '+idsSucursales.length+' * '+JSON.stringify(idsSucursales).indexOf(idSucursal)+' ');
                            if(idsSucursales.length > 1 && JSON.stringify(idsSucursales).indexOf(idSucursal) != -1){
                                if($("#ch_psf").is(":checked")) {
                                    mostrarModalPSF();
                                }else{
                                    guardar('pago');
                                }   
                            }else{
                                mandarMensaje('Debe existir por lo menos una factura para la sucursale seleccionada y una factura para diferente sucursal pero mismo RFC.');
                                $('#b_guardar').prop('disabled',false);
                            }
                        }
                    }else{
                        
                        var unidad = $('#s_id_unidades').val();
                        var sucursal = $('#s_id_sucursales').val();
                        var empresa_fiscal = $('#i_empresa_fiscal').attr('alt');
                        var metodo_pago = $('#s_metodo_pago').val();
                        var razon_social = $('#s_razon_social').val();
                        var idCliente = $('#i_cliente').attr('alt');
                        var moneda = $('input[name=radio_moneda]:checked').val();

                        if(verificaLlaves(unidad,sucursal,empresa_fiscal,metodo_pago,razon_social,idCliente,moneda) != '')
                        {
                            mandarMensaje('Alguna de las partidas no cohincide con los datos principales.'); 
                            $('#b_guardar').prop('disabled',false);
                        }else{
                            if($("#ch_psf").is(":checked")) {
                                mostrarModalPSF();
                            }else{
                                guardar('pago');
                            }  
                        }
                    }
                }else{
                    mandarMensaje('Debe existir por lo menos una factura para generar el pago.');
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
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
        function idSucursalMismoRFC()
        {

            var arreglo = [];

            $("#t_facturas .factura_pagar").each(function()
            {

                var idSucursal = $(this).attr('sucursal');

                //if(JSON.stringify(arreglo).indexOf(idSucursal)=== -1)
                var vA = arreglo.includes(idSucursal);
                if(vA == false)
                {

                    console.log('Agregando... ' + idSucursal);
                    arreglo.push(idSucursal)

                }

            });
            
            console.log('VERIFICANDO' + JSON.stringify(arreglo));
            return arreglo;

        }

        function guardar(tipo){
            
            var metodoPago = $('#s_metodo_pago').val();
            var idEmpresa = $('#i_empresa_fiscal').attr('alt2');

            let idCuentaBanco = $('#s_banco').val();
            let fecha = $('#i_fecha').val();
            let tipoCuenta = $('#s_banco option:selected').attr('alt2');

            if(tipo == "pagoSF"){
                idCuentaBanco = $("#s_pagos_psf option:selected").attr("alt2");
                // fecha = $("#s_pagos_psf option:selected").attr("alt1");
                tipoCuenta = 0;
            }

            if($('#ch_factura_por_rfc').is(':checked'))
                var mismoRFC = 1;
            else
                var mismoRFC = 0;
            
            var info={
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt'),
                'idMetodoPago' : $('#s_metodo_pago').val(),
                'importe' : quitaComa($('#i_importe').val()),
                'concepto' : $('#s_concepto').val(),
                'formaPago' : $('#s_forma_pago').val(),
                'bancoCliente' : $('#i_banco_cliente').val(),
                idCuentaBanco,
                idUsuario,
                tipoCuenta,
                'numCuentaCliente' : $('#i_cuenta_cliente').val(),
                fecha,
                usuario,
                'facturasPagar' : obtieneFacturasPagar(),
                'idRazonSocialCliente' : $('#s_razon_social').val(),
                'rfcCliente' : $('#i_rfc_cliente').val(),
                'razonSocialCliente' : $('#s_razon_social option:selected').attr('alt6'),
                'cpCliente' : $('#i_cp_cliente').val(),
                'pagosSustituir' : obtienePagosSustituir(),
                tipo,
                //-->NJES April/03/2020 envia bandera para indicar si es un pago por mismo rfc
                mismoRFC,
                //-->NJES Jun/13/2021 agrega moneda y tipo de cambio
                //en guinthercorp se cuarda el quivalente en pesos y en cfdi_denken2 se guarda el monto original
                'moneda' : $('input[name=radio_moneda]:checked').val(),
                'tipo_cambio' : quitaComa($('#i_tipo_cambio').val()),
                'importe_pesos' : quitaComa($('#i_importe_pesos').val()),
                'pagoSF' : $("#s_pagos_psf").val()
            };

            console.log(JSON.stringify(info));

            $.ajax({
                type: 'POST',
                url: 'php/pagos_guardar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) {

                    if(data != 0 )
                    {
                        $('#i_id').val(data.idPago);

                        var idPago = data.idPago;
                        var idCFDI = data.idCFDI;

                        if(metodoPago == 'PPD')
                            timbrarPago(idPago,idCFDI,idEmpresa,tipo);
                        else{
                            mandarMensaje('Se guardo correctamente');
                            muestraRegistro(idPago);
                            muestraRegistroDetalle(idPago);
                        }
                    }else{
                        mandarMensaje('Error al guardar.');
                    } 
                    $('#b_guardar').prop('disabled',false);
                },
                error: function (xhr) 
                {
                    console.log('php/pagos_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        };

        function obtieneFacturasPagar(){
            var j = 0;
            var arreglo = [];

            $("#t_facturas .factura_pagar").each(function() {
                var renglon = $(this);
                var idFactura = renglon.attr('alt');

                if($('#r_USD').is(':checked'))
                {
                    var importe = quitaComa(renglon.find('td').eq(10).find('input').val());
                    var importePesos = quitaComa(renglon.find('td').eq(11).text());
                }else{
                    var importe = quitaComa(renglon.find('td').eq(7).find('input').val());
                    var importePesos = importe;
                }

                var saldoAnterior = renglon.attr('saldo_restante');
                var saldoAnteriorOriginal = renglon.attr('saldo_restante_original');
                var uuidFactura = renglon.attr('uuid');
                var folioFactura = renglon.attr('folio');
                var registrosCXC = renglon.attr('registrosCXC');
                //-->NJES April/03/2020 envia id servicio (cliente) de cada partida de factura a pagar
                var idServicio = renglon.attr('id_cliente');

                arreglo[j] = {
                    'idFactura' : idFactura,
                    'uuidfactura' : uuidFactura,
                    'folioFactura' : folioFactura,
                    'importe' : importe,
                    'importe_pesos' : importePesos,
                    'saldoAnterior' : saldoAnterior,
                    'saldo_anterior_original' : saldoAnteriorOriginal,
                    'multipleCXC' : registrosCXC,
                    'idServicio' : idServicio
                };  

                j++;
            });

            return arreglo;
        }

        function timbrarPago(idPago,idCFDI,idEmpresa,tipo){
            $('#fondo_cargando').show();
           
            if(tipo == 'sustituir')
            {
                var ruta = '../cfdi_corporativo/php/sustituir_pagos.php';
                var datos = {'empresa':idEmpresa, 'registro_s': idCFDI};
            }else{
                var ruta = '../cfdi_corporativo/php/ws_genera_pagos.php';
                var datos = {'empresa':idEmpresa, 'registro': idCFDI};
            }

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

                        muestraRegistro(idPago);
                        muestraRegistroDetalle(idPago);
                        
                    }else{
                        eliminarPago(idPago);
                        limpiar();
                        mandarMensaje('Ocurrio un error al timbrar el pago: ' + data + '. Verificar los datos.');  ///vacio
                    }

                    if(obtienePagosSustituir().length > 0)
                    {
                        $('#dialog_sustituir').modal('hide');
                    }

                    $('#fondo_cargando').hide(); 
                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('* Error al generar timbre');
                    eliminarPago(idPago);
                    limpiar();
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

                ///console.log(estatus + ' ** ' + metodo);
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
                url: 'php/pagos_buscar.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data) {
                    if(data.length != 0){                    
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_pagos" alt="'+data[i].id+'" id_unidad_negocio="'+data[i].id_unidad_negocio+'" cliente="'+data[i].id_cliente+'">\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Folio Factura">'+data[i].folio_factura+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Empresa Fiscal">'+data[i].empresa_fiscal+'</td>\
                                        <td data-label="RFC">'+data[i].rfc_cliente+'</td>\
                                        <td data-label="Razón Social">'+data[i].razon_cliente+'</td>\
                                        <td data-label="Monto">'+formatearNumero(data[i].monto_pago)+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus,data[i].metodo_pago)+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_pagos_buscar tbody').append(html);   
                        }
                    }else{
                        var html='<tr class="renglon_fact">\
                                        <td colspan="8">No se encontró información</td>\
                                    </tr>';

                        $('#t_pagos_buscar tbody').append(html);
                    }
                },
                error: function (xhr) {
                    console.log('php/pagos_buscar.php --> '+JSON.stringify(xhr));
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
            muestraSelectRazonesSociales(idCliente,idUnidadNegocio,'s_razon_social');
            
            muestraRegistro(idPago);
            muestraRegistroDetalle(idPago);
        });

        function muestraRegistro(idPago){
            $('#b_agregar').prop('disabled',true);
            $('#div_estatus').html('');
            $('#i_email').val('');
            $.ajax({
                type: 'POST',
                url: 'php/pagos_buscar_id.php',
                dataType:"json", 
                data : {'idPago':idPago},
                success: function(data) {
                    if(data.length >0){                    
                        var dato = data[0];

                        $('#div_estatus').append(labelEstatus(dato.estatus,dato.metodo_pago));

                        mostrarOcultarBotones(dato.estatus,dato.folio_fiscal,0,dato.metodo_pago);

                        $('#b_ver_relacion_pagos').attr('alt',idPago);

                        if(dato.pagos_relacionados != '')
                        {
                            $('#div_relacion_pagos').css('display','block');
                        }else{
                            $('#div_relacion_pagos').css('display','none');
                        }

                        $('#i_cliente').attr('alt',dato.id_cliente).val(dato.cliente);
                        $('#i_empresa_fiscal').attr('alt', dato.id_empresa_fiscal).val(dato.empresa_fiscal);
                        $('#i_empresa_fiscal').attr('alt2', dato.id_cfdi);
                        $('#i_banco_cliente').val(dato.banco_cliente);
                        $('#i_cuenta_cliente').val(dato.cuenta_cliente);
                        $('#i_fecha').val(dato.fecha);
                        $('#i_folio').val(dato.folio);
                        $('#i_importe').val(formatearNumero(dato.monto_pago));
                        
                        $('#i_id').val(dato.id);
                        $('#i_id_cfdi').val(dato.id_pago_cfdi);
                        
                        $('#s_id_unidades').val(dato.id_unidad_negocio);
                        $("#s_id_unidades").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                        $('#s_id_sucursales').val(dato.id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                      
                        $('#i_email').val(dato.correo);
                        
                        if($('#s_id_unidades').find('option:selected').text()=='ALARMAS'){

                            $('#s_razon_social').append('<option value="'+dato.id_cliente+'" alt6="'+dato.razon_social_alarmas+'">'+dato.razon_social_alarmas+'<option>');
                            $('#s_razon_social').val(dato.id_razon_social);
                            $('#s_razon_social').select2({placeholder: $(this).data('elemento')});
                            
                        }else{

                            $('#s_razon_social').val(dato.id_razon_social);
                            $('#s_razon_social').select2({placeholder: $(this).data('elemento')});
                            
                        }

                        $('#s_concepto').val(dato.concepto);
                        $('#s_concepto').select2({placeholder: $(this).data('elemento')});

                        $('#s_metodo_pago').val(dato.metodo_pago);
                        $('#s_metodo_pago').select2({placeholder: $(this).data('elemento')});

                        $('#s_forma_pago').val(dato.forma_pago);
                        $('#s_forma_pago').select2({placeholder: $(this).data('elemento')});
                       
                        $('#s_banco').val(dato.id_cuenta_banco);
                        $('#s_banco').select2({placeholder: $(this).data('elemento')});

                        if(dato.moneda == 'MXN')
                        {
                            $('#r_MXN').prop('checked',true);
                            $('.div_tipo_cambio').hide();
                        }else{
                            $('#r_USD').prop('checked',true);
                            $('.div_tipo_cambio').show(); 
                            $('#i_tipo_cambio').val(dato.tipo_cambio);
                        }

                        $('#dialog_buscar_pagos').modal('hide');

                        $('#forma_general input,select').prop('disabled',true);
                        $('#b_buscar_clientes,#b_buscar_empresa_fiscal,#b_buscar_facturas').prop('disabled',true);
                    }else{
                        mandarMensaje('No se encontro Información del pago');
                    }
                },
                error: function (xhr) {
                    console.log('php/pagos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar pago.');
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
                        if(data[i].moneda != 'USD')
                            $('.importes_pesos').hide();
                        else
                            $('.importes_pesos').show();

                        var registro='';

                        registro+= '<tr class="renglon_pagos_detalle" alt="'+data[i].id+'" folio="'+data[i].folio+'" uuid="'+data[i].uuid+'">';
                            registro+= '<td data-label="Fecha">'+data[i].fecha+'</td>';
                            registro+= '<td data-label="Folio">'+data[i].folio+'</td>';
                            registro+= '<td data-label="UUID" style="text-align:right;">'+data[i].uuid,''+'</td>';
                            if(data[i].moneda == 'USD')
                                registro+= '<td data-label="Monto a Pagar">'+formatearNumero(data[i].monto_pago_usd)+'</td>';
                            
                            registro+= '<td data-label="Monto a Pagar MXN">'+formatearNumero(data[i].monto_pago)+'</td>';
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

        //-->NJES May/25/2020 se solicita se confirme la cancelación de un pago
        $('#b_cancelar').click(function(){
            mandarMensajeConfimacion('¿Estas seguro que deseas cancelar el pago?',$('#i_id').val(),'cancelar_pago');
        });

        $(document).on('click','#b_cancelar_pago',function(){
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
                    url: '../cfdi_corporativo/php/cancelar_pago_3_3.php',
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
                url: '../cfdi_corporativo/php/verifica_status_pago.php',
                data : {'empresa':idEmpresa, 'registro': idCFDI},
                success: function(data){
                    // mandarMensaje(data);
                    if(data == 1){  //bajamos xml y actualizamos estatus a cancelada en ginther
                        $.ajax({
                            type: 'POST',
                            url: 'php/pagos_descargar_acuse.php',
                            data : {'idPago':id, 'idCFDI': idCFDI},
                            success: function(data){
                                //console.log('*'+data+'*');
                                if(data > 0){
                                    muestraRegistro(data);
                                    muestraRegistroDetalle(data);
                                    mandarMensaje('Se aprobó la cancelación.');
                                }else{
                                    mandarMensaje('Error al descargar acuse y actualizar');
                                }
                            },
                            error: function (xhr){
                                //console.log('php/pagos_descargar_acuse.php --> '+JSON.stringify(xhr));
                                mandarMensaje('* Error al descargar acuse y actualizar');
                            }
                        });
                    }else if(data == 2){
                        mandarMensaje('El pago no ha sido aprobada por el cliente favor de intentarlo mas tarde');
                    }else{
                        ///actualizamos estatus a timbrado
                        if(parseInt(actualizarEstatusPago(id,'T')) == parseInt(id)){
                            muestraRegistro(id);
                            muestraRegistroDetalle(id);
                            mandarMensaje('Rechazada. Se actualizó estatus a timbrado.');
                        }else{
                            mandarMensaje('No se puedo actualizar estatus a timbrado');  //vacio
                        }
                    }

                    $('#fondo_cargando').hide();   
                },
                error: function (xhr){
                    //console.log('php/verifica_status_pago.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al generar timbre');
                }
            });
        });


        $('#b_nuevo').click(function(){
            limpiar();
        });

        function limpiar(){
            $('#forma_general input,select').prop('disabled',false).not('[type=radio]').val('');
            $('#b_buscar_clientes,#b_buscar_empresa_fiscal,#b_buscar_facturas').prop('disabled',false);
            $('#t_facturas_pagadas tbody').html('');
            $('#t_facturas tbody').html('');
            $('#div_facturas_pagadas_detalle').css('display','none');
            $('#div_facturas_a_pagar').css('display','block'); 
            $('#div_estatus').html('');
            $('#div_b_verificar_estatus,#div_b_descargar_acuse,.secundarios ').css('display','none');
            $('#div_b_guardar,#div_b_sustituir').css('display','block');

            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            
            muestraConceptosCxPPagos('s_concepto',5);
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

            $('#r_MXN').prop('checked',true);
            $('.div_tipo_cambio').hide();
            $('#i_tipo_cambio').val('15.00');      
            
            $("#dialog_pagos_psf").modal("hide");
            
            $("#ch_psf").prop("checked", false);
            $("#ch_psf").trigger("change");
            $("#s_banco").attr("disabled", false)
        }

        $('#b_descargar_pdf').click(function(){

            $("#modal_alerta_confirm").modal("show");
        });

        $('.b_imprimir_pdf_confirm').click(function(){
            var verRelacion = $(this).attr('alt');

            var datos = {
                'path':'formato_pago',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Recibo de Pagos',
                'tipo':1,
                'verRelacionAbonos':verRelacion
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');

            $("#modal_alerta_confirm").modal("hide");
        });

        $('#b_descargar_acuse').click(function()
        {

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

            $.get('php/convierte_pdf.php',{'D':datosJ},function(data){                
                if(data=='OK'){
                    generaXml(id,folio,ruta,nombreArchivo,tipoAr);
                }else{
                    mandarMensaje(data);
                }    
            });

        }

        function generaXml(idPago,folioPago,ruta,nombreArchivo,tipoAr)
        {
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

        function mandaCorreo(idPago,folioPago,ruta,tipo)
        {
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
                $('#s_metodo_pago').val('PUE').select2({placeholder: $(this).data('elemento')}).prop({'disabled':false,'selected':true});
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

        //-->NJES October/29/2020 mostrar por default las facturas con saldo insoluto mayor a 0, 
        //o mostrar las de saldo insoluto 0
        $('#ch_saldo_insoluto_cero').change(function(){
            mostrarFacturas();
        });

        //-->NJES Jun/11/2021 agregar moneda y tipo de cambio
        $('input[name=radio_moneda]').change(function(){

            if($("#r_MXN").is(':checked'))
            {
                $('.div_tipo_cambio').hide();
            }else{
                $('.div_tipo_cambio').show();
            }
            
        });

        $('#i_tipo_cambio').change(function(){
            if($('#i_importe').val() != '' && parseFloat($('#i_importe').val()) > 0)
                calculaTotalesImporte();
        });

        function calculaImportesEnPHP(tipo,cantidad,precio,tipoCambio){
            var importe = 0;

            $.ajax({
                type: 'POST',
                async: false,
                url: 'php/verifica_importes.php',
                dataType:"json", 
                data:  {'tipo':tipo, 'cantidad': parseFloat(cantidad), 'precio': parseFloat(precio), 'tipo_cambio' : parseFloat(tipoCambio)},
                success: function(data)
                {
                    importe = data;
                }
            });

            return importe;
        }

        $('#ch_psf').change(function() {
            let inputs = "#i_banco_cliente, #s_banco, #i_cuenta_cliente, #i_fecha";
            // if(this.checked) {
            //     $(inputs).attr("disabled", true).removeClass("validate[required]");
            // }else{
            //     $(inputs).attr("disabled", false).addClass("validate[required]");
            // }  
            $(inputs).attr("disabled", false)/*.addClass("validate[required]")*/;
            $("#s_banco").attr("disabled", true).removeClass("validate[required]");
        });

        function mostrarModalPSF(){

            var razon_social = $('#s_razon_social').val();
            var idCliente = $('#i_cliente').attr('alt');

            $.ajax({
                type: 'POST',
                url: 'php/buscar_pagos_psf.php',
                dataType:"json", 
                data : {razon_social, idCliente},
                success: function(data) {
                    $('#b_guardar').prop('disabled',false);
                    if(data.length > 0){
                        $("#s_pagos_psf").html("<option value='0' disabled selected>...</option>");

                        data.map(function(x, y) {
                            $("#s_pagos_psf").append(`<option value="${x.idPsf}" alt1="${x.fecha}" alt2="${x.id_cuenta_banco}">${x.monto} - ${x.folio} - ${x.concepto} - ${x.fecha}</option>`);
                        });

                        $("#dialog_pagos_psf").modal("toggle");

                        $('#s_pagos_psf').select2(
                            {dropdownParent: $("#dialog_pagos_psf")}
                        );
                    }else{
                        mandarMensaje("No hay pagos sin factura para esta razón social");
                    }
                },
                error: function (xhr) {
                    console.log('php/buscar_pagos_psf.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se guardo pago sin factura');
                    $('#b_guardar').prop('disabled',false);
                }
            });

            $("#btnGuardarPSF").off("click");
            $("#btnGuardarPSF").on("click", ()=>{
                let idPsf = $("#s_pagos_psf").val();

                if(idPsf != null && idPsf != 0){
                    guardar('pagoSF');
                }
            });
        }

        // $('#ch_psf').change(function() {
        //     if(this.checked) {
                
        //     }else{

        //     }  
        // });
       
    });

</script>

</html>
