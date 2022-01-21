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
        /*background-color:#000;*/
        left: 1%;
        width: 98%;
        bottom:3%;
        /*border: 2px solid #6495ed;*/
        /*opacity: .1;*/
        /*filter:Alpha(opacity=10);*/
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
    #div_t_facturas{
        max-height:200px;
        min-height:200px;
        overflow-y:auto;
        border: 1px solid #ddd;
        overflow-x:hidden;
    }
    #div_t_facturas_canceladas,
    #div_t_buscar_notas_credito,
    #div_t_notas_credito{
        max-height:300px;
        min-height:300px;
        overflow-y:auto;
        overflow-x:hidden;
    }
    #div_t_facturas_relacionadas
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
    #dialog_buscar_facturas > .modal-lg,
    #dialog_sustituir > .modal-lg,
    #dialog_buscar_notas_credito > .modal-lg,
    #dialog_descripcion_alterna > .modal-lg,
    #dialog_notas_credito > .modal-lg{
        min-width: 90%;
        max-width: 90%;
    } 
    #div_b_timbrar,
    .secundarios,
    #div_b_verificar_estatus,
    #div_b_descargar_acuse,
    #div_b_solicitud_cancelacion,
    #div_cont_estatus,
    #div_relacion_facturas{
        display:none;
    }
    #forma_notas_credito{
        border: 1px solid #ddd;
        padding:15px;
    }
    #dialog_correo{
        z-index:2000;
    }
    .modal{
        overflow-y: scroll !important;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_facturas,
        #div_t_facturas_canceladas,
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
        #dialog_buscar_facturas > .modal-lg,
        #dialog_sustituir > .modal-lg,
        #dialog_buscar_notas_credito > .modal-lg,
        #dialog_descripcion_alterna > .modal-lg,
        #dialog_notas_credito > .modal-lg{
            max-width: 100%;
        }
    }

    .VENTA{
        color:#007BFF;
    }

    .ORDEN{
        color:#155724;
    }

    .PLAN{
        color:#856404;
    }

    .noDatosSat{
        color:#D9534F;
    }

    .tituloTD{
        font-weight:bold;
        font-size:13px;
    }

    .datoTD{
        color:#002699;
        font-weight:bold;
        font-size:13px;
    }

    .ticketAgregado{
        color:#000;
        font-weight:bold;
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">
        <div class="row">
            <div class="col-md-12" id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-2">
                        <div class="titulo_ban">Facturación</div>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_cont_estatus" style="text-align:center;">
                        <div id="div_estatus"></div>
                    </div>
                   
                    <div class="col-sm-12 col-md-1">
                        <button type="button" class="btn btn-primary btn-sm form-control" id="b_buscar_factura"><i class="fa fa-search" aria-hidden="true"></i>  Facturas</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_buscar_nota_credito"><i class="fa fa-search" aria-hidden="true"></i> Notas Crédito</button>
                    </div>
                    <div class="col-sm-12 col-md-2 secundarios botones_factura">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_nota_credito"><i class="fa fa-floppy-o" aria-hidden="true"></i> Nota Crédito</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_sin_factura"><i class="fa fa-search" aria-hidden="true"></i> Sin Factura</button>
                    </div>
                    <div class="col-sm-12 col-md-1">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_guardar_prefactura">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_prefactura"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Prefactura</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_sustituir">
                        <button type="button" class="btn btn-warning btn-sm form-control" id="b_sustituir"><i class="fa fa-exchange" aria-hidden="true"></i> Sustituir</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_verificar_estatus">
                        <button type="button" class="btn btn-warning btn-sm form-control" id="b_verificar_estatus"><i class="fa fa-eye" aria-hidden="true"></i> Verificar Estatus</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_descargar_acuse">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_descargar_acuse"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar Acuse</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_solicitud_cancelacion">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_descargar_solicitud_cancelacion"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Solicitud Cancelación</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-3 secundarios divs_alt"></div>
                    <div class="col-sm-12 col-md-2 secundarios" id="div_b_timbrar">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_timbrar"><i class="fa fa-bell" aria-hidden="true"></i> Timbrar</button>
                    </div>
                    <div class="col-sm-12 col-md-2 secundarios botones_prefactura" id="div_b_cancelar">
                        <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                    </div>
                    <div class="col-sm-12 col-md-2 secundarios botones_prefactura">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_descargar_prefactura"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PreFactura</button>
                    </div>
                    <div class="col-sm-12 col-md-2 secundarios botones_factura">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_descargar_pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar Factura</button>
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

                <div class="form-group row">
                    
                    <div class="col-md-4">
                        <label for="s_id_sucursales" class="col-form-label requerido">Sucursal </label>
                        <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <label for="i_folio_fiscal" class="col-form-label">Folio Fiscal</label>
                            <input type="text" id="i_folio_fiscal" name="i_folio_fiscal" class="form-control form-control-sm"  autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="i_folio_interno" class="col-form-label">Folio Interno</label>
                        <input type="text" id="i_folio_interno" name="i_folio_interno" class="form-control form-control-sm"  autocomplete="off" readonly>
                        <input type="hidden" id="i_id" name="i_id">
                        <input type="hidden" id="i_id_cfdi" name="i_id_cfdi">
                    </div>

                    <div class="col-md-2">
                        <label for="i_fecha" class="col-form-label requerido">Fecha</label>
                        <input type="text" id="i_fecha" name="i_fecha" class="form-control form-control-sm validate[required] fecha"  autocomplete="off" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="i_dias_credito" class="col-form-label requerido">DíasCredito</label>
                        <input type="text" id="i_dias_credito" name="i_dias_credito" class="form-control form-control-sm validate[required,custom[integer]]"  autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <input type="hidden" id="i_email" name="i_email">
                        <label for="i_cliente" class="col-sm-12 col-md-12 col-form-label requerido">Cliente</label>
                        <div class="input-group col-sm-12 col-md-12">
                            <input type="text" id="i_cliente" name="i_cliente" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <label for="i_descripcion_alterna_pg" class="col-sm-12 col-md-12 col-form-label cliente_alterno_pg" style="display:none;">Descripción alterna de Venta al Público en General</label>
                        <input type="text" id="i_descripcion_alterna_pg" name="i_descripcion_alterna_pg" class="cliente_alterno_pg form-control form-control-sm" autocomplete="off" style="display:none;">
                    </div>
                    <div class="col-md-2">
                        <label for="i_rfc" class="col-form-label requerido">RFC</label>
                        <input type="text" id="i_rfc" name="i_rfc" class="form-control form-control-sm validate[required,minSize[12],maxSize[13]]"  autocomplete="off" readonly>
                    </div>
                    <div class="col-sm-2 col-md-2" stye="margin-top:10px;">
                      <div class="alert alert-primary" role="alert">
                        <input type="checkbox" name="ch_factura_por_rfc" id="ch_factura_por_rfc" > Facturar por RFC
                        </div>
                    </div>

                    <div class="col-sm-2 col-md-3">
                        <label for="i_4_cuenta" class="col-md-12 col-form-label">Últimos 4 digitos de la cuenta</label>
                        <div class="col-md-4">
                            <input type="text" id="i_4_cuenta" name="i_4_cuenta" maxlength="4" class="form-control form-control-sm validate[custom[integer],minSize[4],maxSize[4]]"  autocomplete="off">
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-1">
                                       
                            
                        <label for="i_iva" class="col-form-label requerido">Tasa IVA</label><br>
                        <div>
                            16% <input type="radio" name="radio_iva" id="r_16" value="16" checked> 
                        </div>
                        
                    </div>
                </div>

                <div class="form-group row">
                  
                    <div class="col-md-4">
                        <label for="s_cfdi" class="col-form-label requerido">Uso de CFDI </label>
                        <select id="s_cfdi" name="s_cfdi" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="s_metodo_pago" class="col-form-label requerido">Método de Pago </label>
                        <select id="s_metodo_pago" name="s_metodo_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>

                    <div class="col-md-4">
                        <label for="s_forma_pago" class="col-form-label requerido">Forma de Pago </label>
                        <select id="s_forma_pago" name="s_forma_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                   
               
                </div>

                
                    
                    <div class="form-group row">
                        <label for="s_empresa_fiscal" class="col-md-12 col-form-label requerido">Empresa Fiscal (emisora)</label>
                        <div class="input-group col-sm-4 col-md-4">
                            <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar_empresa_fiscal" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-info" type="button" id="b_ver_informacion" style="margin:0px;">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-auto">
                            <div class="row">

                                <div class="col-sm-12 col-md-12">
                                    <input type="checkbox" name="ch_lleva_descripcion_alterna" id="ch_lleva_descripcion_alterna" > LLeva Descripción Alterna
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-success btn-sm form-control" id="b_descripcion_alterna"><i class="fa fa-floppy-o" aria-hidden="true"></i> Datos Descripción Alterna</button>
                        </div>
                        <div class="col-md-2" id="div_relacion_facturas">
                            <button type="button" class="btn btn-info btn-sm form-control" id="b_ver_relacion_facturas"><i class="fa fa-search" aria-hidden="true"></i> Relación Facturas</button>
                            <!--<input type="text" id="i_relacion_factura" name="i_relacion_factura" class="form-control form-control-sm"  autocomplete="off" readonly>-->
                        </div>

                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="i_observaciones" class="col-form-label requerido">Observaciones</label>
                            <input type="text" id="i_observaciones" name="i_observaciones" class="form-control form-control-sm validate[required]"  autocomplete="off">
                        </div>
                    </div>
                </form><!--div forma_general-->
                <br>
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Ticket</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">% IVA</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Por Facturar</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_facturas">
                            <table class="tablon"  id="t_tickets">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
               
                <form id="forma_partidas" name="forma_partidas" style="background:rgba(23,162,184,0.2);padding-bottom:10px;border:1px solid #333;border-radius:5px;">
                    <div class="row">
                        <div class="col-md-1">
                            <input type="hidden" id="i_tipo" name="i_tipo">
                            <input type="hidden" id="i_id_servicio" name="i_id_servicio">
                            <input type="hidden" id="i_registro_d" name="i_registro_d">
                            <input type="hidden" id="i_id_cxc" name="i_id_cxc">
                        </div>
                        <div class="col-md-6">
                            <label for="s_clave_sat_s" class="col-form-label requerido">Clave SAT del Producto/Servicio </label>
                            <select id="s_clave_sat_s" name="s_clave_sat_s" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="s_id_unidades_s" class="col-form-label requerido">Unidad SAT </label>
                            <select id="s_id_unidades_s" name="s_id_unidades_s" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-md-1"></div>
                        <label for="i_descripcion_s" class="col-md-1 col-form-label requerido">Descripción</label>
                        <div class="col-md-9">
                            <textarea type="text" id="i_descripcion_s" name="i_descripcion_s" class="form-control form-control-sm validate[required]"  autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-1"></div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="i_cantidad_s" class="col-form-label requerido">Cantidad</label>
                                    <input type="text" id="i_cantidad_s" name="i_cantidad_s" class="form-control form-control-sm validate[required,custom[number],min[0.01]]" readonly  autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <label for="i_precio_s" class="col-form-label requerido">Precio Unitario</label>
                                    <input type="text" id="i_precio_s" name="i_precio_s" class="form-control form-control-sm validate[required,custom[number],min[0.01]]" readonly autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <label for="i_importe_s" class="col-form-label requerido">Importe</label>
                                    <input type="text" id="i_importe_s" name="i_importe_s" class="form-control validate[required] form-control-sm"  autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-2"><br>
                            <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                        </div>
                    </div>
                </form>
                   
                <br>

                <div class="row form-group">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col" width="15%">Clave SAT del producto</th>
                                    <th scope="col" width="5%">Unidad SAT</th>
                                    <th scope="col" width="10%">Cantidad</th>
                                    <th scope="col" width="15%">Descripción</th>
                                    <th scope="col" width="15%">Precio Unitario</th>
                                    <th scope="col" width="15%">Importe</th>
                                    <th scope="col" width="15%">Descuento</th>
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

                <div class="row">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2"> </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="row">
                            <label for="i_subtotal" class="col-sm-12 col-md-1 col-form-label">Subtotal: </label>
                            <div class="col-sm-12 col-md-2">
                                <input type="hidden" id="i_sub_calculado" name="i_sub_calculado" class="form-control form-control-sm">
                                <input type="text" id="i_subtotal" name="i_subtotal" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                            </div>
                            <!--NJES Feb/20/2020-->
                            <label for="i_descuento" class="col-sm-12 col-md-1 col-form-label">Descuento: </label>
                            <div class="col-sm-12 col-md-2"> 
                                <input type="hidden" id="i_desc_calculado" name="i_desc_calculado" class="form-control form-control-sm">  
                                <input type="text" id="i_descuento" name="i_descuento" class="form-control form-control-sm validate[custom[number]]"  autocomplete="off" readonly>
                            </div>
                            <label for="i_iva_total" class="col-sm-12 col-md-1 col-form-label">IVA:</label>
                            <div class="col-sm-12 col-md-2">
                                <input type="text" id="i_iva_total" name="i_iva_total" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                            </div>
                            <label for="i_total" class="col-sm-12 col-md-1 col-form-label">Total: </label>
                            <div class="col-sm-12 col-md-2">
                                <input type="text" id="i_total" name="i_total" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div> 

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

<div id="dialog_buscar_servicios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Servicios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_servicios" id="i_filtro_servicios" class="form-control filtrar_renglones" alt="renglon_servicios" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_servicios">
                      <thead>
                        <tr class="renglon">
                          <th scope="col" width="15%">Sucursal</th>
                          <th scope="col" width="10%">Cuenta</th>
                          <th scope="col" width="10%">RFC</th>
                          <th scope="col" width="10%">Nombre Corto</th>
                          <th scope="col" width="15%">Razon Social</th>
                          <th scope="col" width="10%">Estatus</th>
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

<div id="dialog_buscar_facturas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" style="overflow-y: scroll;" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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

                <label for="s_filtro_sucursal" class="col-md-1 col-form-label">Sucursal </label>
                <div class="col-md-4">
                    <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control form-control-sm filtros" autocomplete="off" style="width:100%;"></select>
                </div>

                <label for="s_tipo_busqueda" class="col-md-1 col-form-label">Buscar: </label>
                <div class="col-md-4">
                    <select id="s_filtro_tipo_busqueda" name="s_filtro_tipo_busqueda" class="form-control form-control-sm " autocomplete="off" style="width:100%;">
                    <option value='P'>Facturas Planes</option>
                    <option value='V'>Facturas Ventas y ordenes</option>
                    </select>
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
                    <input type="text" name="i_filtro_facturas" id="i_filtro_facturas" class="form-control form-control-sm filtrar_renglones" alt="renglon_facturas" placeholder="Filtrar" autocomplete="off">
                </div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_facturas_buscar">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Sucursal</th>
                                <th scope="col">Empresa Fiscal (emisor)</th>
                                <th scope="col">Folio</th>
                                <th scope="col">Folio Fiscal</th>
                                <th scope="col">Cuenta</th>
                                <th scope="col">Nombre Corto</th>
                                <th scope="col">Razón Social (receptor)</th>
                                <th scope="col">RFC Razón Social</th>
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
                <h5 class="modal-title">Sustituir Facturas Canceladas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6"> 
                        <input type="text" name="i_filtro_facturas_canceladas" id="i_filtro_facturas_canceladas" class="form-control form-control-sm filtrar_renglones" alt="facturas_canceladas" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Folio Interno</th>
                                    <th scope="col">Folio Fiscal</th>
                                    <th scope="col">RFC Emisor</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">RFC Receptor</th>
                                    <th scope="col">Razón Social Receptor</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col" width="9%"></th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_facturas_canceladas">
                            <table class="tablon"  id="t_facturas_canceladas">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">   
                <button type="button" class="btn btn-success btn-sm" id="b_guardar_sustituir"><i class="fa fa-exchange" aria-hidden="true"></i> Aplicar Sustitución</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_relacion_facturas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relación de Facturas</h5>
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
                                    <th scope="col">Folio Interno</th>
                                    <th scope="col">Folio Fiscal</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_facturas_relacionadas">
                            <table class="tablon"  id="t_facturas_relacionadas">
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

<div id="dialog_buscar_notas_credito" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Notas de Crédito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="s_filtro_sucursal_NC" class="col-md-1 col-form-label">Sucursal </label>
                    <div class="col-md-4">
                        <select id="s_filtro_sucursal_NC" name="s_filtro_sucursal_NC" class="form-control form-control-sm filtros" autocomplete="off" style="width:100%;"></select>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio_NC" id="i_fecha_inicio_NC" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_fin_NC" id="i_fecha_fin_NC" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <input type="text" name="i_filtro_NC" id="i_filtro_NC" class="form-control form-control-sm filtrar_renglones" alt="renglon_nota_credito_b" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>  
                <br>  
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Unidad de Negocio</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Folio Factura</th>
                                    <th scope="col">Folio Nota de Crédito</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estatus</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_buscar_notas_credito">
                            <table class="tablon"  id="t_buscar_notas_credito">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">   
                <button type="button" class="btn btn-success btn-sm" id="b_guardar_sustituir"><i class="fa fa-exchange" aria-hidden="true"></i> Aplicar Sustitución</button>
            </div>-->
        </div>
    </div>
</div>

<div id="dialog_notas_credito" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NOTAS DE CRÉDITO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forma_notas_credito" name="forma_notas_credito">
                    <!--NJES Feb/18/2020 se agrega para mostrar el saldo actual de la factura-->
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="s_metodo_pago_nc" class="col-form-label requerido">Método de Pago </label>
                                    <select id="s_metodo_pago_nc" name="s_metodo_pago_nc" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="s_forma_pago_nc" class="col-form-label requerido">Forma de Pago</label>
                                    <select id="s_forma_pago_nc" name="s_forma_pago_nc" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2" style="text-align:right;">Saldo Factura</div>
                        <div class="col-sm-12 col-md-2">
                            <b>$ <label id="label_saldo_actual_factura"></label></b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <label for="i_descripcion_nc" class="col-form-label requerido">Descripción </label>
                            <input type="text" id="i_descripcion_nc" name="i_descripcion_nc" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                        </div> 
                        <div class="col-sm-12 col-md-3" id="div_radio_iva_nc">
                            <div class="row">
                                <label for="radio_iva_nc" class="col-md-4 col-form-label requerido">% IVA</label>
                                <div class="col-sm-4 col-md-4">
                                    16% <input type="radio" name="radio_iva_nc" id="r_16_nc" value="16" checked> 
                                </div>
                                <!--<div class="col-sm-4 col-md-4">
                                    8% <input type="radio" name="radio_iva_nc" id="r_8_nc" value="8">
                                </div>-->
                            </div>
                        </div> 
                        <div class="col-sm-12 col-md-2">
                            <label for="i_importe_nc" class="col-form-label requerido">Importe (Sin IVA)</label>
                            <input type="text" id="i_importe_nc" name="i_importe_nc" class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off"/>
                            <input type="hidden" id="i_iva_nc" name="i_iva_nc" class="form-control" autocomplete="off" readonly/>
                            <input type="hidden" id="i_total_nc" name="i_total_nc" class="form-control" autocomplete="off" readonly/>
                        </div> 
                        <div class="col-sm-12 col-md-2">
                            <br>
                            <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar_nota_credito"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                        </div>  
                    </div>
                </form>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Folio</th>
                                    <th scope="col">Método Pago</th>
                                    <th scope="col">Forma Pago</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                    <th scope="col">Estatus</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_notas_credito">
                            <table class="tablon"  id="t_notas_credito">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">   
                <button type="button" class="btn btn-success btn-sm" id="b_guardar_sustituir"><i class="fa fa-exchange" aria-hidden="true"></i> Aplicar Sustitución</button>
            </div>-->
        </div>
    </div>
</div>

<div id="dialog_datos_empresa_fiscal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Datos de Empresa Fiscal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_datos_empresa_fiscal">
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

<div id="dialog_descripcion_alterna" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Descripción Alterna</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="forma_da" name="forma_da" style="background:rgba(23,162,184,0.2);padding-bottom:10px;border:1px solid #333;border-radius:5px;">
            <div class="row">
                <div class="col-md-1">
                    <input type="hidden" id="i_tipo" name="i_tipo">
                    <input type="hidden" id="i_registro_d" name="i_registro_d">
                    <input type="hidden" id="i_id_cxc" name="i_id_cxc">
                </div>
                <div class="col-md-6">
                    <label for="s_clave_sat_s_da" class="col-form-label requerido">Clave SAT del Producto/Servicio </label>
                    <select id="s_clave_sat_s_da" name="s_clave_sat_s_da" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                </div>
                <div class="col-md-4">
                    <label for="s_id_unidades_s_da" class="col-form-label requerido">Unidad SAT </label>
                    <select id="s_id_unidades_s_da" name="s_id_unidades_s_da" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                </div>
                
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-1"></div>
                <label for="i_descripcion_s_da" class="col-md-1 col-form-label requerido">Descripción</label>
                <div class="col-md-9">
                    <textarea type="text" id="i_descripcion_s_da" rows="2" name="i_descripcion_s_da" class="form-control form-control-sm validate[required]"  autocomplete="off"></textarea>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="i_cantidad_s_da" class="col-form-label requerido">Cantidad</label>
                            <input type="text" id="i_cantidad_s_da" name="i_cantidad_s_da" class="form-control form-control-sm validate[required,custom[number],min[0.01]]" readonly  autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="i_precio_s_da" class="col-form-label requerido">Precio Unitario</label>
                            <input type="text" id="i_precio_s_da" name="i_precio_s_da" class="form-control form-control-sm validate[required,custom[number],min[0.01]]" readonly autocomplete="off">
                        </div>
                       <!--<div class="col-md-4">
                            <label for="i_importe_s_da" class="col-form-label requerido">Importe</label>
                            <input type="text" id="i_importe_s_da" name="i_importe_s_da" class="form-control validate[required] form-control-sm"  autocomplete="off" readonly>
                        </div>-->
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2"><br>
                    <button type="button" class="btn btn-success btn-sm form-control" id="b_guardar_descripcion_alterna"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                </div>
            </div>
        </form>
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
  
    var modulo='FACTURACION_ALARMAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var idFactura = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    var esVentaOrden = 0;
    var esPlan = 0;

    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        generaFecha('s_mes');
        muestraSelectUsoCFDI('s_cfdi');
        muestraSelectMetodoPago('s_metodo_pago');
        muestraSelectClaveProductoSAT('s_clave_sat_s');
        $('#s_clave_sat_s').prop('disabled',true);
        muestraSelectClaveUnidadesSAT('s_id_unidades_s');
        $('#s_id_unidades_s').prop('disabled',true);
        $('#i_descripcion_s').prop('disabled',true);
        $('#b_agregar').prop('disabled',true);
        $('#b_ver_informacion').prop('disabled',true);
        $('#b_descripcion_alterna').prop('disabled',true);

        muestraSelectClaveProductoSAT('s_clave_sat_s_da');
        muestraSelectClaveUnidadesSAT('s_id_unidades_s_da');
        $('#i_descripcion_s_da').val('');

        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
        $('#b_buscar_clientes').prop('disabled',true);
        $(document).on('change','#s_id_sucursales',function(){
            $('#b_buscar_clientes').prop('disabled',false);
        });

        //-->NJES July/14/2020 agregar metodo y forma de pago a notas de credito
        muestraSelectMetodoPago('s_metodo_pago_nc');
        muestraSelectFormaPago('TODOS','s_forma_pago_nc');

        $('[data-toggle="tooltip"]').tooltip();
        
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        }); 

        $('#i_fecha').val(hoy);

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);
        
        $('#b_buscar_clientes').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_servicios').val('');
            $('.renglon_servicios').remove();

            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar2.php',
                dataType:"json", 
                data:{
                    'estatus':2,
                    'idSucursal':$('#s_id_sucursales').val()
                },  

                success: function(data) {
                console.log(data);
                if(data.length != 0){

                    $('.renglon_servicios').remove();
            
                    for(var i=0;data.length>i;i++){

                        ///llena la tabla con renglones de registros
                        var activo='';
                        
                        if(parseInt(data[i].activo) == 1){

                            activo='Activo';
                        }else{
                            activo='Inactivo';
                        }

                        //-->NJES Feb/19/2020 se obtiene el codigo postal y se asigna como atributo al cliente servicio
                        var html='<tr class="renglon_servicios" alt="'+data[i].id+'" alt2="'+ data[i].razon_social +'" alt3="' + data[i].rfc+ '" alt4="' + data[i].porcentaje_iva + '" alt5="' + data[i].correos + '" alt6="' + data[i].nombre_corto + '" codigo_postal="'+data[i].codigo_postal+'">\
                                    <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                    <td data-label="ID">' + data[i].cuenta+ '</td>\
                                    <td data-label="RFC">' + data[i].rfc+ '</td>\
                                    <td data-label="Nombre">' + data[i].nombre_corto+ '</td>\
                                    <td data-label="Razón Social">' + data[i].razon_social+ '</td>\
                                    <td data-label="Estatus">' + activo+ '</td>\
                                </tr>';
                        ///agrega la tabla creada al div 
                        $('#t_servicios tbody').append(html);   
                        $('#dialog_buscar_servicios').modal('show');   
                    }
                }else{

                    mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/servicios_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        });

        $('#t_servicios').on('click', '.renglon_servicios', function() {
            $('#ch_factura_por_rfc').prop('checked',false).prop('disabled',false); 
            var idServicio = $(this).attr('alt');
            var razonSocial = $(this).attr('alt2');
            var rfc = $(this).attr('alt3');
            var porcentajeIva = $(this).attr('alt4');
            var correos = $(this).attr('alt5');
            var nombreCorto = $(this).attr('alt6');
            //-->NJES Feb/19/2020 se toma valor del atributo codigo_postal
            var codigo_postal = $(this).attr('codigo_postal');
            console.log(nombreCorto);
            if(razonSocial!=''){
                $('#i_email').val(correos);
                $('#i_cliente').val(nombreCorto).attr('alt',idServicio).attr('alt2',razonSocial).attr('codigo_postal',codigo_postal);
                $('#i_rfc').val(rfc);

                $('input[name=radio_iva]').prop('checked',false);   
                if(parseInt(porcentajeIva) == 16){
                    $('#r_16').prop('checked',true);
                }else if(porcentajeIva == 8){
                    $('#r_8').prop('checked',true);
                }

                obtenerTickets(idServicio,'');

                $('#dialog_buscar_servicios').modal('hide');
            }else{
                mandarMensaje('No puedes generar la facturas para el cliente:<br> <strong> '+nombreCorto+' </strong> <br>Ya que no tiene razón social, favor de ingresarla en servicios.');
            }
        });

        $('#ch_factura_por_rfc').on('click',function()
        {
            
            if($('#ch_factura_por_rfc').is(':checked'))
            {
                // obtener tickets
                var idServicio = $('#i_cliente').attr('alt');
                var rfcA= $('#i_rfc').val();
                obtenerTicketsRFC(idServicio, rfcA);
            }
            else
            {
                var idServicio = $('#i_cliente').attr('alt');
                obtenerTickets(idServicio, '');
            }

        });

        $('#b_sin_factura').on('click',function(){
            $('.cliente_alterno_pg').show();
            //-->NJES May/07/2020 el servicio para venta publico en egeneral es 0, 
            //porque el uno en producción ya se esta usando y es para otro servicio
            var idServicio = 0;
            var razonSocial = 'VENTA PUBLICO EN GENERAL';
            var rfc = 'XAXX010101000';
            var porcentajeIva = 16;
            
            $('#i_email').val('');
            //-->NJES Feb/19/2020 se asigna atributo codigo_postal del servicio
            $('#i_cliente').val(razonSocial).attr('alt',idServicio).attr('alt2',razonSocial).attr('codigo_postal','');
            $('#i_rfc').val(rfc);
            $('#ch_factura_por_rfc').prop('checked',false).prop('disabled',true); 
            $('input[name=radio_iva]').prop('checked',false);   
            if(parseInt(porcentajeIva) == 16){
                $('#r_16').prop('checked',true);
            }else if(porcentajeIva == 8){
                $('#r_8').prop('checked',true);
            }
           
            obtenerTickets(0,'');
        });

        function obtenerTickets(idServicio,rfcA){

            $('.renglon_tickets').remove();
            //-->NJES Feb/27/2020 se limpian las partidas para facturas
            $('#t_facturas tbody').empty();

            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar_tickets_por_facturar.php',
                dataType:"json", 
                data:{'idServicio':idServicio,
                        'rfc':rfcA
                },

                success: function(data) {
               
                    if(data.length != 0){

                        $('.renglon_tickets').remove();
                        for(var i=0;data.length>i;i++){
                            var html='<tr class="renglon_tickets ' + data[i].tipo+ ' TICKET_'+data[i].id_cxc+'" idCXC="'+data[i].id_cxc+'" idServicio="'+data[i].id_servicio+'" alt="'+data[i].id_registro+'" alt2="'+data[i].tipo+'" alt3="'+data[i].porcentaje_iva+'" alt4="'+data[i].vencimiento+'" alt5="'+data[i].fecha_corte_recibo+'">\
                                        <td data-label="Servicio">' + data[i].servicio+ '</td>\
                                        <td data-label="Ticket">' + data[i].tipo+ '</td>\
                                        <td data-label="Ticket">' + data[i].folio+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="% IVA">' + data[i].porcentaje_iva + '%</td>\
                                        <td data-label="Total">' + formatearNumeroCSS(data[i].total + '')+ '</td>\
                                        <td data-label="Total">' + formatearNumeroCSS(data[i].total + '')+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_tickets tbody').append(html);   
                        }

                    }else{
                        if(idServicio>0 && rfcA!=''){
                            mandarMensaje('No tiene ticket pendientes, con diferentes Clientes con mismo rfc');
                            $('#ch_factura_por_rfc').prop('checked',false).prop('disabled',true); 
                        }else{
                            mandarMensaje('No tiene ticket pendientes');
                        }
                    }

                },
                error: function (xhr) {
                    console.log('php/servicios_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        function obtenerTicketsRFC(idServicio,rfcA)
        {

            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar_tickets_por_facturar.php',
                dataType:"json", 
                data:{'idServicio':idServicio,
                        'rfc':rfcA
                },

                success: function(data) {
            
                    if(data.length != 0){

                        for(var i=0;data.length>i;i++){
                            var html='<tr class="renglon_tickets ' + data[i].tipo+ ' TICKET_'+data[i].id_cxc+'" idCXC="'+data[i].id_cxc+'" idServicio="'+data[i].id_servicio+'" alt="'+data[i].id_registro+'" alt2="'+data[i].tipo+'" alt3="'+data[i].porcentaje_iva+'" alt4="'+data[i].vencimiento+'" alt5="'+data[i].fecha_corte_recibo+'">\
                                        <td data-label="Servicio">' + data[i].servicio+ '</td>\
                                        <td data-label="Ticket">' + data[i].tipo+ '</td>\
                                        <td data-label="Ticket">' + data[i].folio+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="% IVA">' + data[i].porcentaje_iva + '%</td>\
                                        <td data-label="Total">' + formatearNumeroCSS(data[i].total + '')+ '</td>\
                                        <td data-label="Total">' + formatearNumeroCSS(data[i].total + '')+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_tickets tbody').append(html);   
                        }

                    }else{
                        if(idServicio>0 && rfcA!=''){
                            mandarMensaje('No tiene ticket pendientes, con diferentes Clientes con mismo rfc');
                            $('#ch_factura_por_rfc').prop('checked',false).prop('disabled',true); 
                        }else{
                            mandarMensaje('No tiene ticket pendientes');
                        }
                    }

                },
                error: function (xhr) {
                    console.log('php/servicios_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#t_tickets').on('dblclick', '.renglon_tickets', function()
        {

            // añadiendo a factura
            var idCXC = $(this).attr('idCXC');
            var idRegistro = $(this).attr('alt');
            var tipo = $(this).attr('alt2');
            var tasaIvaRegistro = $(this).attr('alt3');
            var finPeriodo = $(this).attr('alt4');//vencimiento
            var inicioPeriodo = $(this).attr('alt5');//fecha_corte_recibo
            var tasaIvaActual = $('input[name=radio_iva]:checked').val();
            var idServicio = $(this).attr('idServicio');
            
            if(parseInt(tasaIvaRegistro) == parseInt(tasaIvaActual)){
                $(this).addClass('ticketAgregado');

                if(tipo=='VENTA'){
                    
                    if(ventasAgregadas(idRegistro)==0){
                        buscaDetalleVenta(idRegistro,idCXC,idServicio);
                    }else{
                        mandarMensaje('Este ticket de venta ya fue agregado');
                    }
                }else if(tipo=='PLAN'){
                   
                    //if(planesAgregados(idRegistro)==0){
                    //-->NJES Feb/27/2020 se toma el id del cxc ya que un id plan puede tener 1 o mas registros con el mismo id_plan pero diferente id_cxc
                    if(planesAgregados(idCXC)==0){
                        buscaDetallePlan(idRegistro,idCXC,idServicio);
                    }else{
                        mandarMensaje('Este plan ya fue agregado');
                    }
                    
                }else{

                    if(odenesAgregadas(idRegistro)==0){
                        buscaDetalleOrden(idRegistro,idCXC,idServicio);
                    }else{
                        mandarMensaje('Este ticket de Orden ya fue agregado');
                    }
                
                }
            }else{
                mandarMensaje('Solo puedes agregar registros con la misma tasa Iva, si modifica la tasa iva se perderan los registros que estan agregados');
            }
           
        });

        function ventasAgregadas(idRegistro){
            var existe=0;
            $('.VENTA').each(function(){
                var idRegistroT= parseFloat($(this).attr('idRegistro'));
                if(idRegistroT==idRegistro){
                    existe = existe + 1;
                }else{
                    existe = existe + 0;
                }
            });

            return existe;
        }

        function odenesAgregadas(idRegistro){
            var existe=0;
            $('.ORDEN').each(function(){
                var idRegistroT= parseFloat($(this).attr('idRegistro'));
                if(idRegistroT==idRegistro){
                    existe = existe + 1;
                }else{
                    existe = existe + 0;
                }
            });

            return existe;
        }

        function planesAgregados(idRegistro){
            var existe=0;
            $('#t_facturas .PLAN').each(function(){
                //var idRegistroT= parseFloat($(this).attr('idRegistro'));
                //-->NJES Feb/27/2020  compara si el id registro de plan en cxc ya se agrego como partida para facturar
                var idRegistroT= parseInt($(this).attr('idCXC'));
                if(idRegistroT==idRegistro){
                    existe = existe + 1;
                }else{
                    existe = existe + 0;
                }
            });

            return existe;
        }


        function buscaDetalleVenta(idRegistro,idCXC,idServicio){
            
            $.ajax({
                type: 'POST',
                url: 'php/ventas_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idVenta':idRegistro
                },
                success: function(data) {
                    console.log(data);

                    if(data.length != 0){

                        for(var i=0;data.length>i;i++){

                            var html = "<tr class='renglonP renglon_partida VENTA VENTA_"+idCXC+"' tipo='VENTA' idCXC='"+idCXC+"' idServicio='"+idServicio+"' idOrden='0' idVenta='"+idRegistro+"' idRegistro='"+idRegistro+"' idProducto='" + data[i].id_producto + "' idPlan='0' idOrden='0' importe='"+data[i].importe+"' cantidad='"+data[i].cantidad +"' precio='"+data[i].precio +"' descripcion='"+data[i].producto +"' descuento='"+data[i].descuento+"' porcentaje_descuento='"+data[i].porcentaje_desc+"' claveProducto='' claveUnidad=''>";
                            html += "<td width='15%' data-label='Clave Sat'></td>";
                            html += "<td width='5%' data-label='Clave Unidad'></td>";
                            html += "<td width='10%' data-label='Cantidad'>" + data[i].cantidad + "</td>";
                            html += "<td width='20%' data-label='Descripcion'>" + data[i].producto + "</td>";
                            html += "<td width='15%' data-label='PRECIO UNITARIO' align='right' >" + formatearNumeroCSS(data[i].precio + '') + "</td>";
                            html += "<td width='15%' data-label='Importe' align='right'>" + formatearNumeroCSS(data[i].importe + '') + "</td>";
                            //-->NJES Feb/20/2020 se agrega la parte de descuento prorrateado porque las ventas pueden tener descuento
                            html += "<td width='15%' data-label='DESCUENTO' align='right' >" + formatearNumeroCSS(data[i].descuento + '') + "</td>";
                            html += "<td width='3%'><button type='button' class='btn btn-danger btn-sm form-control b_eliminar' alt='VENTA_"+idCXC+"' alt2='"+idCXC+"' alt3='"+idServicio+"'><i class='fa fa-remove' aria-hidden='true'></i></button></td>";
                            html += "</tr>";

                            $('#t_facturas tbody').append(html);

                            calculaTotales();
                            
                        }

                    }else{
                        mandarMensaje('No se encontró información');
                    }
                   
                   
                },
                error: function (xhr) {
                    console.log('php/ventas_detalle.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        function buscaDetalleOrden(idRegistro,idCXC,idServicio){
            
            $.ajax({
                type: 'POST',
                url: 'php/servicios_ordenes_buscar_id.php',
                dataType:"json", 
                data:{
                    'idOrdenServicio':idRegistro
                },
                success: function(data) {
                    console.log(data);

                    if(data.length != 0){

                        for(var i=0;data.length>i;i++){
                            
                        var html = "<tr class='renglonP renglon_partida ORDEN ORDEN_"+idCXC+"' tipo='ORDEN' idCXC='"+idCXC+"' idServicio='"+idServicio+"'  idOrden='"+idRegistro+"' idVenta='0'  idRegistro='"+idRegistro+"' idProducto='0' idOrden='" + data[i].idRegistro + "' idPlan='0' importe='"+data[i].subtotal+"'  cantidad='1' precio='"+data[i].subtotal +"' descripcion='"+data[i].concepto_cobro +"' descuento='0.00' porcentaje_descuento='0' claveProducto='' claveUnidad=''>";
                            html += "<td width='15%' data-label='Clave Sat'></td>";
                            html += "<td width='5%' data-label='Clave Unidad'></td>";
                            html += "<td width='10%' data-label='Cantidad'>1</td>";
                            //-->NJES October/07/2020 mostrar concepo cobro cuando la factura tiene ligado el cobro de una orden de servicio
                            html += "<td width='20%' data-label='Descripcion'>" + data[i].concepto_cobro + "</td>";
                            html += "<td width='15%' data-label='PRECIO UNITARIO' align='right' >" + formatearNumeroCSS(data[i].subtotal + '') + "</td>";
                            html += "<td width='15%' data-label='Importe' align='right'>" + formatearNumeroCSS(data[i].subtotal + '') + "</td>";
                            //-->NJES Feb/20/2020  se agrega la parte de descuento prorrateado porque las ventas pueden tener descuento
                            html += "<td width='15%' data-label='DESCUENTO' align='right' >" + formatearNumeroCSS('0.00' + '') + "</td>";
                            html += "<td width='3%'><button type='button' class='btn btn-danger btn-sm form-control b_eliminar' alt='ORDEN_"+idCXC+"' alt2='"+idCXC+"' alt3='"+idServicio+"'><i class='fa fa-remove' aria-hidden='true'></i></button></td>";
                            html += "</tr>";

                            $('#t_facturas tbody').append(html);

                            calculaTotales();
    
                        }
                        
                    }else{
                        mandarMensaje('No se encontró información');
                    }
                   
                   
                },
                error: function (xhr) {
                    console.log('php/ventas_detalle.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        function buscaDetallePlan(idRegistro,idCXC,idServicio){
           
            $.ajax({
                type: 'POST',
                url: 'php/servicios_planes_buscar_id.php',
                dataType:"json", 
                data:{
                    'idBitacoraPlan':idRegistro,
                    'idCXC':idCXC
                },
                success: function(data) {
                    
                    if(data.length != 0){

                        for(var i=0;data.length>i;i++){
                            
                            var descripcionF='';
                            
                            if(parseInt(data[i].meses)==1){
                                descripcionF = data[i].descripcion_plan + ' '+data[i].descripcion_cat +' DE '+ nombreMes(parseInt(data[i].anio_actual)) +' CUENTA: '+ data[i].cuenta ;
                            }else if(parseInt(data[i].meses)==12){
                                descripcionF = data[i].descripcion_plan +' '+ data[i].descripcion_cat+ ' DEL PERIODO '+ nombreMes(parseInt(data[i].mes_actual))+' '+ data[i].anio_actual +' - '+nombreMes(parseInt(data[i].mes_fin))+' '+ data[i].anio_siguiente +' CUENTA: '+ data[i].cuenta;
                            }else{
                                descripcionF = data[i].descripcion_plan +' '+ data[i].descripcion_cat+ ' DEL PERIODO '+ nombreMes(parseInt(data[i].mes_actual)) +' - '+nombreMes(parseInt(data[i].mes_fin))+' CUENTA: '+ data[i].cuenta;
                            }

                            /*registro+= '<tr class="renglonP renglon_partida editar '+tipo+'" tipo="'+tipo+'" idCXC="'+idCXC+'" idServicio="'+idServicio+'" idOrden="'+idOrden+'" idVenta="'+idVenta+'" idPlan="'+idPlan+'"  idRegistro="'+idRegistroD+'" claveProducto="'+claveProducto+'" producto="'+producto+'" claveUnidad="'+claveUnidad+'" nombreUnidad="'+nombreUnidad+'" nombreProducto="'+nombreProducto+'" cantidad="'+cantidad+'" precio="'+precio+'" importe="'+importe+'" descripcion="'+descripcion+'" descuento="'+descuento+'" porcentaje_descuento="'+porcentaje_descuento+'">';
                
                            registro+= '<td width="15%" data-label="Clave Sat">'+producto+'</td>';
                            registro+= '<td width="5%" data-label="Clave Unidad">'+unidad+'</td>';
                            registro+= '<td width="10%" data-label="Cantidad" align="right">'+formatearNumeroCSS(cantidad.toFixed(4) + '')+'</td>';
                            registro+= '<td width="20%" data-label="Descripcion">'+descripcion+'</td>';
                            registro+= '<td width="15%" data-label="PRECIO UNITARIO" align="right">'+formatearNumeroCSS(precio.toFixed(4) + '')+'</td>';
                            registro+= '<td width="15%" data-label="Importe" align="right">'+formatearNumeroCSS(importe.toFixed(4) + '')+'</td>';
                            registro+= '<td width="15%" data-label="DESCUENTO" align="right">'+formatearNumeroCSS(descuento+ '')+'</td>';
                            registro+= '</tr>';*/

                            var html = "<tr class='renglonP renglon_partida PLAN PLAN_"+idCXC+"' tipo='PLAN' idCXC='"+idCXC+"' idServicio='"+idServicio+"'  idPlan='"+idRegistro+"' idVenta='0'  idOrden='0' idRegistro='"+idRegistro+"' idProducto='0' importe='"+data[i].subtotal+"'  cantidad='1' precio='"+data[i].subtotal +"' descripcion='"+descripcionF +"' descuento='0.00' porcentaje_descuento='0' claveProducto='92121701' producto='92121701 - Vigilancia o mantenimiento o monitoreo de alarmas' claveUnidad='E48' nombreUnidad='Unidad de servicio' nombreProducto='Vigilancia o mantenimiento o monitoreo de alarmas'>";
                            html += "<td width='15%' data-label='Clave Sat'>92121701 - Vigilancia o mantenimiento o monitoreo de alarmas</td>";
                            html += "<td width='5%' data-label='Clave Unidad'>E48 - Unidad de servicio</td>";
                            html += "<td width='10%' data-label='Cantidad'>1</td>";
                            html += "<td width='20%' data-label='Descripcion'>" + descripcionF + "</td>";
                            html += "<td width='15%' data-label='PRECIO UNITARIO' align='right' >" + formatearNumeroCSS(data[i].subtotal + '') + "</td>";
                            html += "<td width='15%' data-label='Importe' align='right'>" + formatearNumeroCSS(data[i].subtotal + '') + "</td>";
                            //-->NJES Feb/20/2020 se agrega la parte de descuento prorrateado porque las ventas pueden tener descuento
                            html += "<td width='15%' data-label='DESCUENTO' align='right' >" + formatearNumeroCSS('0.00' + '') + "</td>";
                            html += "<td width='3%'><button type='button' class='btn btn-danger btn-sm form-control b_eliminar' alt='PLAN_"+idCXC+"' alt2='"+idCXC+"' alt3='"+idServicio+"'><i class='fa fa-remove' aria-hidden='true'></i></button></td>";
                            html += "</tr>";

                            $('#t_facturas tbody').append(html);

                            calculaTotales();
    
                        }
                        
                    }else{
                        mandarMensaje('No se encontró información');
                    }
                   
                   
                },
                error: function (xhr) {
                    console.log('php/servicios_planes_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }
        //--MGFS SE AGREGA LA FUNCION PARA ELIMINAR PARTIDAS COMPLETAS DE UN VENTA O DE  UNA ORDEN O PLAN
        //**************ELIMINAR PARTIDAS************** */
        $(document).on('click','.b_eliminar',function(){
            var registros = $(this).attr('alt');
            var idCxc = $(this).attr('alt2');
            var idServicioE = $(this).attr('alt3');
            //-- MGFS SE QUITA LA CLASE DE AGRAGADO--
            $(document).find('.TICKET_'+idCxc).removeClass('ticketAgregado');
            $('.renglon_partida').each(function(){
                if($(this).hasClass(registros)){
                    $(this).remove();
                }
                
            })

            calculaTotales();
        });

        function nombreMes(numMes){
            var mes='';
            switch(numMes) {
            case 1: 
                mes = 'ENERO';
                break;
            case 2: 
                mes = 'FEBRERO';
                break;
            case 3: 
                mes = 'MARZO';
                break;  
            case 4: 
                mes = 'ABRIL';
                break;
            case 5: 
                mes = 'MAYO';
                break;
            case 6: 
                mes = 'JUNIO';
                break;  
            case 7: 
                mes = 'JULIO';
                break;
            case 8: 
                mes = 'AGOSTO';
                break;
            case 9: 
                mes = 'SEPTIEMBRE';
                break;  
            case 10: 
                mes = 'OCTUBRE';
                break;
            case 11: 
                mes = 'NOVIEMBRE';
                break;
            case 12:
                mes = 'DICIEMBRE';
                break;        
            default: mes ='';
            }
            return mes;
        }

        $('#t_facturas').on('dblclick', '.renglon_partida', function()
        {

            // añadiendo a factura
            if($('#s_clave_sat_s').val() == null)
            {
                
                var renglon=$(this);
                var tipo = renglon.attr('tipo');
                var idRegistroD = renglon.attr('idRegistro');
                var idServicio = renglon.attr('idServicio');
                $('#i_tipo').val(tipo);
                $('#i_id_servicio').val(idServicio);
                $('#i_registro_d').val(idRegistroD);
                $('#i_id_cxc').val(renglon.attr('idCXC'));
                $('#s_clave_sat_s').val(renglon.attr('claveProducto'));
                $('#s_clave_sat_s').select2({placeholder: $(this).data('elemento')});
                $('#s_id_unidades_s').val(renglon.attr('claveUnidad'));
                $('#s_id_unidades_s').select2({placeholder: $(this).data('elemento')}); 
                $('#i_cantidad_s').val(formatearNumero(renglon.attr('cantidad')));
                $('#i_precio_s').val(formatearNumero(renglon.attr('precio')));
                $('#i_importe_s').val(formatearNumero(renglon.attr('importe'))).attr({'descuento':renglon.attr('descuento'),'porcentaje_descuento':renglon.attr('porcentaje_descuento')});
                $('#i_descripcion_s').val(renglon.attr('descripcion'));


                $('#s_clave_sat_s').prop('disabled',false);
                $('#s_id_unidades_s').prop('disabled',false);
                $('#i_descripcion_s').prop('disabled',false);
                $('#b_agregar').prop('disabled',false);

                $(this).remove();
                calculaTotales();
            }else{
                mandarMensaje('Debes agregar primero el producto/servicio actual');
            }
        });

        $('#b_agregar').click(function(){
            $('#b_agregar').prop('disabled',true);
            if($('#forma_partidas').validationEngine('validate'))
            {
                var claveProducto = $('#s_clave_sat_s').val(); 
                var producto = $('#s_clave_sat_s option:selected').text();
                var claveUnidad = $('#s_id_unidades_s').val(); 
                var unidad = $('#s_id_unidades_s option:selected').text();
                var nombreUnidad = $('#s_id_unidades_s option:selected').attr('alt');
                var nombreProducto = $('#s_clave_sat_s option:selected').attr('alt');
                var cantidad = parseFloat(quitaComa($('#i_cantidad_s').val()));
                var precio = parseFloat(quitaComa($('#i_precio_s').val()));
                var importe = parseFloat(quitaComa($('#i_importe_s').val()));
                //-->NJES Feb/20/2020 se agrega la parte de descuento prorrateado porque las ventas pueden tener descuento
                var descuento = (parseFloat(quitaComa($('#i_importe_s').attr('descuento'))) == 0) ? '00.0' : parseFloat(quitaComa($('#i_importe_s').attr('descuento')));
                var porcentaje_descuento = quitaComa($('#i_importe_s').attr('porcentaje_descuento'));
                var descripcion = $('#i_descripcion_s').val();
                var idCXC = $('#i_id_cxc').val();
                var tipo = $('#i_tipo').val();
                var idServicio = $('#i_id_servicio').val();
                var idRegistroD = $('#i_registro_d').val();
                var idVenta = 0;
                var idOrden = 0;
                var idPlan = 0;
                if(tipo=='VENTA'){
                    idVenta = idRegistroD;
                }else if(tipo=='PLAN'){
                    idPlan = idRegistroD;  
                }else{
                    idOrden = idRegistroD;
                }

                var registro='';
                registro+= '<tr class="renglonP renglon_partida editar '+tipo+'" tipo="'+tipo+'" idCXC="'+idCXC+'" idServicio="'+idServicio+'" idOrden="'+idOrden+'" idVenta="'+idVenta+'" idPlan="'+idPlan+'"  idRegistro="'+idRegistroD+'" claveProducto="'+claveProducto+'" producto="'+producto+'" claveUnidad="'+claveUnidad+'" nombreUnidad="'+nombreUnidad+'" nombreProducto="'+nombreProducto+'" cantidad="'+cantidad+'" precio="'+precio+'" importe="'+importe+'" descripcion="'+descripcion+'" descuento="'+descuento+'" porcentaje_descuento="'+porcentaje_descuento+'">';
                
                registro+= '<td width="15%" data-label="Clave Sat">'+producto+'</td>';
                registro+= '<td width="5%" data-label="Clave Unidad">'+unidad+'</td>';
                registro+= '<td width="10%" data-label="Cantidad" align="right">'+formatearNumeroCSS(cantidad.toFixed(4) + '')+'</td>';
                registro+= '<td width="20%" data-label="Descripcion">'+descripcion+'</td>';
                registro+= '<td width="15%" data-label="PRECIO UNITARIO" align="right">'+formatearNumeroCSS(precio.toFixed(4) + '')+'</td>';
                registro+= '<td width="15%" data-label="Importe" align="right">'+formatearNumeroCSS(importe.toFixed(4) + '')+'</td>';
                registro+= '<td width="15%" data-label="DESCUENTO" align="right">'+formatearNumeroCSS(descuento+ '')+'</td>';
                registro+= '</tr>';
                $('#t_facturas tbody').append(registro);

                limpiaFormaPartidas();

                $('#s_clave_sat_s').prop('disabled',true);
                $('#s_id_unidades_s').prop('disabled',true);
                $('#i_descripcion_s').prop('disabled',true);
                $('#b_agregar').prop('disabled',true);

                calculaTotales();
            }else{
                $('#b_agregar').prop('disabled',false);
                $('#i_descripcion_s').prop('disabled',false);
            }
        });

        /*$(document).on('click','#b_eliminar',function(){
            $(this).parent().parent().remove();
            calculaTotales();
        });*/

        

        function limpiaFormaPartidas(){
            $('#b_agregar').prop('disabled',false);
            $('#i_descripcion_s').prop('disabled',false);
            $('#forma_partidas input,textarea').not('#i_descripcion_s_da').val('');
            muestraSelectClaveProductoSAT('s_clave_sat_s');
            muestraSelectClaveUnidadesSAT('s_id_unidades_s');
        }


        $('#b_buscar_empresa_fiscal').click(function()
        {
            $('#i_filtro_empresa_fiscal').val('');

            //-->NJES April/06/2021 si la sucursal es seycom buscar la empresa fiscal de seycom, sino las del otro rfc
            if($('#s_id_sucursales').val() != null)
            {
                if($('#s_id_sucursales').val() == 57)
                    var rfc='SEY131211QS7';
                else
                    var rfc='SAL080528436';

                buscarEmpresasFiscalesCFDIRFC('renglon_empresa_fiscal','t_empresa_fiscal tbody','dialog_empresa_fiscal',rfc);
            }else{
                mandarMensaje('Selecciona una sucursal para buscar empresas fiscales');
            } 
        });

        $('#s_id_sucursales').change(function(){
            $('#i_empresa_fiscal').val('').attr({'alt':'','alt2':''});
        });
        
        $('#t_empresa_fiscal').on('click', '.renglon_empresa_fiscal', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var idCFDI = $(this).attr('alt3');
            $('#i_empresa_fiscal').attr('alt',id).attr('alt2',idCFDI).val(nombre);
           
            var rfc = $(this).attr('alt4');
            var calle = $(this).attr('alt5');
            var calleFiscal = $(this).attr('alt6');
            var numExt = $(this).attr('alt7');
            var colonia = $(this).attr('alt8');
            var cp = $(this).attr('alt9');
            var estado = $(this).attr('alt10');
            var municipio = $(this).attr('alt11');
            var representante = $(this).attr('alt12');

            $('#t_datos_empresa_fiscal body').empty();

            var htmlInfo="<tr><td class='tituloTD' width='30%'>Nombre</td><td class='datoTD' width='70%'>"+nombre+"</td></tr>\
            <tr><td class='tituloTD'>RFC</td><td class='datoTD'>"+rfc+"</td></tr>\
            <tr><td class='tituloTD'>Calle</td><td class='datoTD'>"+calle+" No Ext "+numExt+"</td></tr>\
            <tr><td class='tituloTD'>Calle Fiscal</td><td class='datoTD'>"+calleFiscal+" No Ext "+numExt+"</td></tr>\
            <tr><td class='tituloTD'>Colonia</td><td class='datoTD'>"+colonia+"</td></tr>\
            <tr><td class='tituloTD'>C.P.</td><td class='datoTD'>"+cp+"</td></tr>\
            <tr><td class='tituloTD'>Municipio</td><td class='datoTD'>"+municipio+"</td></tr>\
            <tr><td class='tituloTD'>Estado</td><td class='datoTD'>"+estado+"</td></tr>\
            <tr><td class='tituloTD'>Representante</td><td class='datoTD'>"+representante+"</td></tr>";

            $('#t_datos_empresa_fiscal tbody').append(htmlInfo);
            $('#b_ver_informacion').prop('disabled',false);
            $('#dialog_empresa_fiscal').modal('hide');
        });

        $('#b_ver_informacion').on('click',function(){
            $('#dialog_datos_empresa_fiscal').modal('show');
        });

        

        $('#s_metodo_pago').change(function(){
            var tipo = $(this).val();
            muestraSelectFormaPago(tipo,'s_forma_pago');
        });

        $('#s_metodo_pago_nc').change(function(){
            var tipo = 'TODOS';
            muestraSelectFormaPago(tipo,'s_forma_pago_nc');
        });

        $('input[name=radio_iva]').change(function(){
            $('#t_facturas tbody').empty();
            calculaTotales();
        });

        $('#b_buscar_factura').click(function(){

            $('#forma_general').validationEngine('hide');
            $('#s_filtro_tipo_busqueda').val('V').prop('disabled',false);
            $('#s_filtro_sucursal').prop('disabled',false);
            $('#dialog_buscar_facturas').modal('show');

            buscarFacturas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
        });

        $('#s_filtro_tipo_busqueda').change(function(){

            buscarFacturas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
        });

        $('#s_filtro_unidad').change(function(){
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
            $('.img-flag').css({'width':'50px','height':'20px'});
            buscarFacturas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
        });

        $('#s_filtro_sucursal').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarFacturas(idUnidadActual,$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarFacturas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#i_fecha_inicio').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarFacturas(idUnidadActual,$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarFacturas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarFacturas(idUnidadActual,$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarFacturas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        function buscarFacturas(idUnidadNegocio,idSucursal){
            $('#i_filtro_facturas').val('');
            $('.renglon_facturas').remove();
            $('#t_facturas_buscar tbody').html('');

            var info = {
                'idUnidadNegocio' : idUnidadNegocio,
                'idSucursal': idSucursal,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'tipoBusqueda' : $('#s_filtro_tipo_busqueda').val()
            };

            console.log(JSON.stringify(info));

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_alarmas_buscar.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data) {
                    if(data.length != 0){                    
                        for(var i=0;data.length>i;i++){
                            var fechaPeriodo = '';
                            if(data[i].id_plan > 0)
                            {
                                fechaPeriodo = 'title="Periodo: '+data[i].fecha_inicio+' - '+data[i].fecha_fin+'"';
                            }
                            //-->NJES Feb/10/2020 Se muestra el nombre corto en las busquedas y cuenta
                            var html='<tr class="renglon_facturas" '+fechaPeriodo+' alt="'+data[i].id+'" id_unidad_negocio="'+data[i].id_unidad_negocio+'" cliente="'+data[i].id_cliente+'" metodo="'+data[i].metodo_pago+'">\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Empresa Fiscal (emisor)">'+data[i].empresa_fiscal+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Folio Fiscal">'+data[i].folio_fiscal+'</td>\
                                        <td data-label="Cuenta">'+data[i].cuenta+'</td>\
                                        <td data-label="Nombre Corto">'+data[i].nombre_corto+'</td>\
                                        <td data-label="Razón Social (receptor)">'+data[i].razon_social+'</td>\
                                        <td data-label="RFC Razón Social">'+data[i].rfc_razon_social+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_facturas_buscar tbody').append(html);   
                        }
                    }else{
                        var html='<tr class="renglon_fact">\
                                        <td colspan="10">No se encontró información</td>\
                                    </tr>';

                        $('#t_facturas_buscar tbody').append(html);
                    }
                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas.');
                }
            });
        }

        $('#t_facturas_buscar').on('click', '.renglon_facturas', function(){
            idFactura = $(this).attr('alt');
            var idCliente = $(this).attr('cliente');
            var metodoPago = $(this).attr('metodo');
            var idUnidadNegocio = $(this).attr('id_unidad_negocio');
            $(this).removeClass('.renglon_facturas');
            $('#div_estatus').html('');
           
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
            muestraSelectFormaPago(metodoPago,'s_forma_pago');
           
            muestraRegistro(idFactura);
            muestraRegistroDetalle(idFactura);
            obtenerTicketsFactura(idFactura);
        });
        //--- esto se agrega para que no duplique el estatus
        $('#t_facturas_buscar').on('dblclick', '.renglon_facturas', function(){

        });

        function muestraRegistro(idFactura){
           
            $('#b_agregar').prop('disabled',true);
            $('#i_descripcion_s').prop('disabled',true);
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_id_alarmas.php',
                dataType:"json", 
                data : {'idFactura':idFactura},
                success: function(data) {
                    if(data.length >0){                    
                        var dato = data[0];

                        $('#forma_general input,select').prop('disabled',true);
                        $('#b_buscar_clientes,#b_buscar_empresa_fiscal').prop('disabled',true);
                        $('#div_estatus').html('');
                        $('#div_estatus').append(labelEstatus(dato.estatus));

                        //-->NJES May/27/2020 verifica si el saldo de la factura es igual al cargo inicial,
                        //si no no podra cancelar la factura, el boton cancelar no aparecera
                        $.ajax({
                            type: 'POST',
                            url: 'php/facturacion_buscar_saldo_idFactura.php',
                            dataType:"json", 
                            data:  {'idFactura':idFactura},
                            success: function(data1) {
                                if(data1.length > 0)
                                {
                                    if(parseFloat(dato.total)-parseFloat(dato.importe_retencion) == data1[0].saldo)
                                        mostrarOcultarBotones(dato.registros,dato.estatus,dato.folio_fiscal,dato.num_notas_credito);
                                    else
                                        mostrarOcultarBotones(dato.registros,dato.estatus,dato.folio_fiscal,dato.num_notas_credito);
                                }else
                                    mostrarOcultarBotones(dato.registros,dato.estatus,dato.folio_fiscal,dato.num_notas_credito);
                            },
                            error: function (xhr1) 
                            {
                                console.log('php/facturacion_buscar_saldo_idFactura.php --> '+JSON.stringify(xhr1));
                                //mandarMensaje('* No se encontró información al buscar el saldo de la factura.');
                            }
                        });
                        //mostrarOcultarBotones(dato.registros,dato.estatus,dato.folio_fiscal,dato.num_notas_credito);

                        $('#b_ver_relacion_facturas').attr('alt',idFactura);

                        if(dato.facturas_relacionadas != '')
                        {
                            $('#div_relacion_facturas').css('display','block');
                        }else{
                            $('#div_relacion_facturas').css('display','none');
                        }

                        //-->NJES Feb/19/2020 se asigna valor al atributo codigo_postal
                        $('#i_cliente').attr('alt',dato.id_cliente).attr('alt2',dato.razon_social).attr('codigo_postal',dato.codigo_postal).val(dato.cliente);
                        $('#i_empresa_fiscal').attr('alt', dato.id_empresa_fiscal).val(dato.empresa_fiscal);
                        $('#i_empresa_fiscal').attr('alt2', dato.id_cfdi_fiscal);
                        $('#b_ver_iformacion').prop('disabled',true);
                        $('#i_rfc').val(dato.rfc_razon_social);
                        $('#i_email').val(dato.email);
                        $('#i_fecha').val(dato.fecha);
                        $('#i_dias_credito').val(dato.dias_credito);
                        $('#i_folio_fiscal').val(dato.folio_fiscal);
                        $('#i_folio_interno').val(dato.folio);
                        $('#i_4_cuenta').val(dato.digitos_cuenta);
            
                        $('#i_observaciones').val(dato.observaciones);
                        $('#i_subtotal').val(formatearNumero(dato.subtotal));
                        $('#i_iva_total').val(formatearNumero(dato.iva));
                        $('#i_total').val(formatearNumero(parseFloat(dato.total)-parseFloat(dato.descuento)));
                        //-->NJES Feb/20/2020 se agrega la parte de descuento porque las ventas pueden tener descuento
                        $('#i_descuento').val(formatearNumero(dato.descuento));
                       
                        $('#i_inicio_periodo').val(dato.fecha_inicio);
                        $('#i_fin_periodo').val(dato.fecha_fin);

                        $('#i_id').val(dato.id);
                        $('#i_id_cfdi').val(dato.id_factura_cfdi);
                        
                        if(dato.porcentaje_iva == 16)
                            $('#r_16').prop('checked',true);
                        else if(dato.porcentaje_iva == 8)
                            $('#r_8').prop('checked',true);
                        else
                            $('#r_0').prop('checked',true);

                        if(dato.id_cliente == 0 && dato.cliente_alterno != '')
                        {
                            $('#i_descripcion_alterna_pg').val(dato.cliente_alterno);
                            $('.cliente_alterno_pg').show();
                        }else{
                            $('#i_descripcion_alterna_pg').val('');

                            if(dato.id_cliente > 0)
                                $('.cliente_alterno_pg').hide();
                            else
                                $('.cliente_alterno_pg').show();
                        }

                       
                        $('#s_id_sucursales').val(dato.id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                        

                        $('#s_cfdi').val(dato.uso_cfdi);
                        $('#s_cfdi').select2({placeholder: $(this).data('elemento')});

                        $('#s_metodo_pago').val(dato.metodo_pago);
                        $('#s_metodo_pago').select2({placeholder: $(this).data('elemento')});
                        
                        $('#s_forma_pago').val(dato.forma_pago);
                        $('#s_forma_pago').select2({placeholder: $(this).data('elemento')});
                       
                        
                        if(parseInt(dato.lleva_descripcion_alterna)==1){
            
                            $('#ch_lleva_descripcion_alterna').prop('checked',true).prop('disabled',true);
                            $('#b_descripcion_alterna').prop('disabled',false);
                            $('#s_clave_sat_s_da').val(dato.clave_producto_sat).prop('disabled',true);
                            $('#s_clave_sat_s_da').select2({placeholder: $(this).data('elemento')});
                            $('#s_id_unidades_s_da').val(dato.clave_unidad_sat).prop('disabled',true);
                            $('#s_id_unidades_s_da').select2({placeholder: $(this).data('elemento')});
                            $('#i_descripcion_s_da').val(dato.descripcion_alterna).prop('disabled',true);

                        }else{
                           
                            $('#ch_lleva_descripcion_alterna').prop('checked',false);
                            $('#b_descripcion_alterna').prop('disabled',true);
                            muestraSelectClaveProductoSAT('s_clave_sat_s_da');
                            $('#s_clave_sat_s_da').prop('disabled',true);
                            muestraSelectClaveUnidadesSAT('s_id_unidades_s_da');
                            $('#s_id_unidades_s_da').prop('disabled',true);
                            $('#i_descripcion_s_da').val('').prop('disabled',true);
                        }
                        
                       
                        
                        $('#dialog_buscar_facturas').modal('hide');
                    }else{
                        mandarMensaje('No se encontro Información de la factura');
                    }

                    $('#s_metodo_pago_nc,#s_forma_pago_nc').prop('disabled',false);
                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar factura.');
                }
            });
        }

        function labelEstatus(estatus){
            var est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #0066cc;">SIN TIMBRAR</label>';
                        if(estatus == 'T')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">TIMBRADA</label>';
                        else if(estatus == 'C')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ff0000;">CANCELADA</label>';
                        else if(estatus == 'P')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ffc107;">PENDIENTE</label>';
        
            return est;
        }

        function muestraRegistroDetalle(idFactura){
          
            $('#t_facturas tbody').html(''); 

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_alarmas_buscar_detalle_id.php',
                dataType:"json", 
                data : {'idFactura':idFactura},
                success: function(data) {                   
                    for(var i=0;data.length>i;i++)
                    {
                        var idServicio =data[i].id_servicio;
                        var idOrden=data[i].id_orden;
                        var idVenta=data[i].id_venta;
                        var idPlan=data[i].id_plan;
                        var precio = parseFloat(data[i].precio_unitario);
                        var importe = parseFloat(data[i].importe);
                        //-->NJES Jun/10/2021 redondear a dos decimales
                        importe = (+(Math.round(importe + "e+2")  + "e-2"));
                        
                        var cantidad = parseFloat(data[i].cantidad);
                        //-->NJES Feb/20/2020 se agrega la parte de descuento porque las ventas pueden tener descuento
                        var porcentaje_descuento = parseFloat(data[i].porcentaje_descuento);
                        var descuento = parseFloat(data[i].monto_descuento);
                        
                        var registro = '<tr class="renglonP renglon_busqueda" idCXC="'+data[i].id_cxc+'" idServicio="'+idServicio+'" idOrden="'+idOrden+'" idVenta="'+idVenta+'"  idPlan="'+idPlan+'"  claveProducto="'+data[i].clave_producto_sat+'" claveUnidad="'+data[i].clave_unidad_sat+'" nombreUnidad="'+data[i].unidad_sat+'" nombreProducto="'+data[i].producto_sat+'"  cantidad="'+data[i].cantidad+'" precio="'+data[i].precio_unitario+'" importe="'+importe+'" descripcion="'+data[i].descripcion+'" descuento="'+data[i].monto_descuento+'" porcentaje_descuento="'+parseFloat(data[i].porcentaje_descuento)*100+'">';
                            registro+= '<td width="15%">'+data[i].clave_producto_sat+' - '+data[i].producto_sat+'</td>';
                            registro+= '<td width="5%">'+data[i].clave_unidad_sat+' - '+data[i].unidad_sat+'</td>';
                            registro+= '<td width="10%" align="right">'+formatearNumeroCSS(data[i].cantidad + '')+'</td>';
                            registro+= '<td width="20%">'+data[i].descripcion+'</td>';
                            registro+= '<td width="15%" align="right">'+formatearNumeroCSS(data[i].precio_unitario + '')+'</td>';
                            registro+= '<td width="15%" align="right">'+formatearNumeroCSS(importe.toFixed(6) + '')+'</td>';
                            registro+= '<td width="15%" align="right">'+formatearNumeroCSS(data[i].monto_descuento + '')+'</td>';
                            registro+= '</tr>';

                        $('#t_facturas tbody').append(registro); 
                    }
                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_detalle_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar partidas facturas.');
                }
            });
        }

        function mostrarOcultarBotones(registros,tipo,folioFiscal,numNC){
            $('#div_b_guardar_prefactura,#div_b_sustituir').css('display','none');
            $('#div_cont_estatus').css('display','block');
            //if(registros==1){
            //-->NJES Feb/11/2020 como el cxc se libero de la factura registros aparece en 0
            if(registros<=1){
    
                if(tipo == 'T') //->Timbrada
                {
                    $('.botones_factura').css('display','block');
                    $('.botones_prefactura').css('display','block');
                    $('.divs_alt').css('display','none');
                    $('#div_b_timbrar').css('display','none');
                    $('#div_b_verificar_estatus').css('display','none');
                    $('#div_b_descargar_acuse').css('display','none');
                    $('#div_b_solicitud_cancelacion').css('display','none');

                    if(numNC > 0)
                        $('#div_b_cancelar').css('display','none');
                    else
                        $('#div_b_cancelar').css('display','block');

                }else if(tipo == 'A') //-> Sin timbrar
                {
                    $('#div_b_timbrar').css('display','block');
                    $('.botones_prefactura').css('display','block');
                    $('.divs_alt').css('display','block');
                    $('#div_b_verificar_estatus').css('display','none');
                    $('#div_b_descargar_acuse').css('display','none');
                    $('.botones_factura').css('display','none');
                    $('#div_b_solicitud_cancelacion').css('display','none');
                }else if(tipo == 'P') //-> Pendiente
                {
                    $('#div_b_timbrar').css('display','none');
                    $('.botones_prefactura').css('display','none');
                    $('.botones_factura').css('display','none');
                    $('#div_b_descargar_acuse').css('display','none');
                    $('#div_b_solicitud_cancelacion').css('display','block');
                    $('#div_b_verificar_estatus').css('display','block');
                }else{  //-> Cancelada
                    $('#div_b_timbrar').css('display','none');
                    $('.botones_prefactura').css('display','none');
                    $('.botones_factura').css('display','none');
                    $('.divs_alt').css('display','none');
                    $('#div_b_verificar_estatus').css('display','none');
                    $('#div_b_solicitud_cancelacion').css('display','none');

                    if(folioFiscal != '')
                        $('#div_b_descargar_acuse').css('display','block');
                    else
                        $('#div_b_descargar_acuse').css('display','none'); 
                }
            }else{
                mandarMensaje('No puedes, Timbrar o Cancelar este registro porque ya tiene abonos, debes cancelarlos primero');
            }

        }

        $('#b_guardar_prefactura').click(function(){
            
            var idServicioO=$('#i_cliente').attr('alt');
            
            $('#b_guardar_prefactura').prop('disabled',true);

            if ($('#forma_general').validationEngine('validate')){   
                //--MGFS se agrega validacion para que por  lo menos lleve un ticket del cliente selecionado, si el cliente no es publico en genral
                //--idsServicios.length>1 para validar qeu por lo menos vayan 2 servicos diferentes si no no tiene caso marcarlo como por rfc
                var idsServicios = obtieneIdsServicios();
                if( idServicioO==1 || $('#ch_factura_por_rfc').is(':checked')==false || ( $('#ch_factura_por_rfc').is(':checked')==true && idServicioO >1 &&  idsServicios.length>1 && JSON.stringify(idsServicios).indexOf(idServicioO)!= -1)){

                    if($('#t_facturas .renglon_partida').length > 0  && $('#i_descripcion_s').val()=='')
                    {
                        if(verificaDatosPartidas()==''){
                        
                            if(($('#ch_lleva_descripcion_alterna').is(':checked'))){
                                var resultadoVerificacion = verificaDatosAlternos();
                                if(resultadoVerificacion==''){
                                    
                                    guardar('prefactura');
                                }else{
                                    $('#b_descripcion_alterna').click();
                                    mandarMensaje('Verifica que la descripción alterna tenga todos sus datos SAT correspondientes, Clave Sat Producto y Unidad Sat y una descripción:<br>'+resultadoVerificacion);
                                    $('#b_guardar_prefactura').prop('disabled',false);
                                }
                            }else{
                                guardar('prefactura');
                            }
                            

                        }else{
                            mandarMensaje('Verifica que los productos tengan todos sus datos SAT correspondientes, Clave Sat Producto y Unidad Sat');
                            $('#b_guardar_prefactura').prop('disabled',false);
                        }
                        
                    }else{
                        mandarMensaje('Debe existir por lo menos un producto/servicio para guardar, y verifica que no no haya un producto en edición');
                        $('#b_guardar_prefactura').prop('disabled',false);
                    }
                }
                else
                {
                    mandarMensaje('Debes agregar por lo menos un ticket del cliente selecionado, y un ticket de un cliente diferente');
                    $('#b_guardar_prefactura').prop('disabled',false);
                }
            }else{
                $('#b_guardar_prefactura').prop('disabled',false);
            }
        });

        function verificaDatosPartidas(){
            var tieneDatos='';
            $('.renglon_partida').removeClass('noDatosSat');
            $("#t_facturas .renglon_partida").each(function() {

                var idClaveSATProducto = $(this).attr('claveProducto');
                var idClaveSATUnidad = $(this).attr('claveUnidad');
                if(idClaveSATProducto!='' && idClaveSATUnidad!=''){
                    tieneDatos=tieneDatos+'';
                }else{
                    tieneDatos=tieneDatos+'No';
                    $(this).addClass('noDatosSat');
                }
            });
            return tieneDatos;
        }

        function guardar(tipo){
            
            var idUnidadNegocio = idUnidadActual;
            var idCliente = $('#i_cliente').attr('alt');
            var idMetodoPago = $('#s_metodo_pago').val();

            var info={
                'idUnidadNegocio' : idUnidadActual,
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscalEmisor' : $('#i_empresa_fiscal').attr('alt'),
                'idCFDIEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt2'),
                'idRazonSocialReceptor' : $('#i_cliente').attr('alt'),
                'razonSocialReceptor' : $('#i_cliente').attr('alt2'),
                'codigoPostal' : $('#i_cliente').attr('codigo_postal'),
                'rfc' : $('#i_rfc').val(),
                'idUsoCFDI' : $('#s_cfdi').val(),
                'idMetodoPago' : $('#s_metodo_pago').val(),
                'idFormaPago' : $('#s_forma_pago').val(),
                'fecha' : $('#i_fecha').val(),
                'diasCredito' : $('#i_dias_credito').val(),
                'tasaIva' : $('input[name=radio_iva]:checked').val(),
                'digitosCuenta' : $('#i_4_cuenta').val(),
                'mes' : numMes,
                'anio' : anio,
                'observaciones' : $('#i_observaciones').val(),                
                'subtotal' : quitaComa($('#i_subtotal').val()),
                'iva' : quitaComa($('#i_iva_total').val()),
                'total' : parseFloat(quitaComa($('#i_total').val()))+parseFloat(quitaComa($('#i_descuento').val())),
                //-->NJES Feb/20/2020 se agrega la parte de descuento porque las ventas pueden tener descuento
                'descuento' : quitaComa($('#i_descuento').val()),
                'fechaInicioPeriodo' : hoy,//$('#i_inicio_periodo').val(),
                'fechaFinPeriodo' : hoy,//$('#i_fin_periodo').val(),
                'usuario' : usuario,
                'facturasSustituir' : obtieneFacturasSustituir(),
                'tipo' : tipo,
                'esVentaOrden':obtieneEsOrdenVenta(),
                'esPlan':obtieneEsPlan(),
                'llevaDescripcionAlterna' : ($('#ch_lleva_descripcion_alterna').is(':checked'))?1:0,
                'claveProductoA' : $('#s_clave_sat_s_da').val(), 
                'productoA': $('#s_clave_sat_s_da option:selected').attr('alt'),
                'claveUnidadA' : $('#s_id_unidades_s_da').val(), 
                'unidadA' : $('#s_id_unidades_s_da option:selected').attr('alt'),
                'descripcionA' : $('#i_descripcion_s_da').val(),
                'idsServicios' : obtieneIdsServicios(),
                'cliente_alterno_pg' : $('#i_descripcion_alterna_pg').val(),
                'partidas' : obtienePartidas(),
            };

            // console.log(info);
            // console.log(new Blob([JSON.stringify(info)]).size);

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_guardar.php',
                data:  {'datos':JSON.stringify(info)},
                success: function(data) {
                    
                    console.log('Resultado'+data);
                    if(data > 0 )
                    { 
                      
                        idFactura = data;

                        if(obtieneFacturasSustituir().length > 0)
                        {
                            $('#dialog_sustituir').modal('hide');
                        }

                        //--> NJES Jan/24/2020 se liga la prefactura al cxc y se deja el estatus en A
                        actualizaCXC(data,'Prefactura','A',obtieneIdsCXC(),'Se guardo correctamente');
                       
                    }else{ 

                        if(obtieneFacturasSustituir().length > 0)
                        {
                            $('#dialog_sustituir').modal('hide');
                        }

                        mandarMensaje('Error al guardar .'+tipo);
                        $('#b_guardar_prefactura').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar_prefactura').prop('disabled',false);
                }
            });
        };

        function actualizaCXC(idFactura,tipo,estatus,datos,mensaje){
            
            var info={
                'idFactura' : idFactura,
                'estatus': estatus,
                'registrosCXC':datos,
                'idServicio' : $('#i_cliente').attr('alt'),
                'idsServicios': obtieneIdsServicios(),
                'tipo': tipo
            };

            console.log('envia:'+JSON.stringify(info));
         
            $.ajax({
                type: 'POST',
                url: 'php/cxc_actualiza_id_factura.php',
                data:  {'datos':info},
                success: function(data) {
                   console.log(data);
                    if(parseInt(data) > 0 )
                    { 
                        mandarMensaje(mensaje);
                        limpiarGuardar();
                        muestraRegistro(idFactura);
                        muestraRegistroDetalle(idFactura);
                    }else{ 
                        mandarMensaje(mensaje +' \n Pero ocurrio un error al modificar la cuenta por cobrar correpndiente, comunicarse con administrador');

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar_prefactura').prop('disabled',false);
                }
            });
        }

        function obtieneEsOrdenVenta(){
            var esVentaOrden=0;
            $("#t_facturas .renglon_partida").each(function() {
                var idOrden = $(this).attr('idOrden');
                var idVenta = $(this).attr('idVenta');
                var idPlan = $(this).attr('idPlan');

                if(parseInt(idOrden) > 0 || parseInt(idVenta)>0){
                    esVentaOrden= esVentaOrden+1;
                }else{
                    esVentaOrden= esVentaOrden+0;
                }
                
            
            });
             if(parseInt(esVentaOrden)>0){
                return 1;
             }else{
                return 0;
             }
            
        }

        function obtieneEsPlan(){
            var esPlan=0;
            $("#t_facturas .renglon_partida").each(function() {
                var idPlan = $(this).attr('idPlan');

                if(parseInt(idPlan) > 0 ){
                    esPlan= esPlan+1;
                }else{
                    esPlan= esPlan+0;
                }
                
            
            });
             if(parseInt(esPlan)>0){
                return 1;
             }else{
                return 0;
             }
            
        }

        
        function obtienePartidas()
        {

            var j = 0;
            var arreglo = [];

            $("#t_facturas .renglon_partida").each(function() {
                var idServicio = $(this).attr('idServicio');
                var idOrden = $(this).attr('idOrden');
                var idVenta = $(this).attr('idVenta');
                var idPlan = $(this).attr('idPlan');
                var idClaveSATProducto = $(this).attr('claveProducto');
                var idClaveSATUnidad = $(this).attr('claveUnidad');
                var nombreUnidadSAT = $(this).attr('nombreUnidad');
                var nombreProductoSAT = $(this).attr('nombreProducto');
                var cantidad = $(this).attr('cantidad');
                var precio = $(this).attr('precio');
                var importe = $(this).attr('importe');
                var descripcion = $(this).attr('descripcion');
                var idCXC = $(this).attr('idCXC');
                //-->NJES Feb/20/2020 se agrega la parte de descuento prorrateado porque las ventas pueden tener descuento
                var descuento = $(this).attr('descuento');
                var porcentajeDescuento =  parseFloat($(this).attr('porcentaje_descuento'))/100;
                
                arreglo[j] = {
                    'idVenta': idVenta,
                    'idOrden' : idOrden,
                    'idPlan' : idPlan,
                    'idClaveSATProducto' : idClaveSATProducto,
                    'idClaveSATUnidad' : idClaveSATUnidad,
                    'nombreUnidadSAT' : nombreUnidadSAT,
                    'nombreProductoSAT' : nombreProductoSAT,
                    'cantidad' : cantidad,
                    'precio' : precio,
                    'importe' : importe,
                    'descripcion' : descripcion,
                    'idCXC' : idCXC,
                    'montoDescuento' : descuento,
                    'porcentajeDescuento' : porcentajeDescuento,
                    'idServicio' : idServicio
                };  

                // console.log("**"+j+"**",arreglo[j]);

                j++;
            });

            // console.log(arreglo);

            return arreglo;
        }

        function obtieneIdsServicios(){
            
            var arreglo = [];

            $("#t_facturas .renglonP").each(function() {
                var idServicio = $(this).attr('idServicio');
                if(JSON.stringify(arreglo).indexOf(idServicio)=== -1){
                    arreglo.push(idServicio)
                }

            });
            console.log(JSON.stringify(arreglo));
            return arreglo;
        }

        function obtieneIdsCXC(){
            var j = 0;
            var arreglo = [];

            $("#t_facturas .renglonP").each(function() {
                var idOrden = $(this).attr('idOrden');
                var idVenta = $(this).attr('idVenta');
                var idPlan = $(this).attr('idPlan');
                var idCXC = $(this).attr('idCXC');
                var idServicio = $(this).attr('idServicio');
                if(JSON.stringify(arreglo).indexOf(idCXC)=== -1){

                    arreglo[j] = {
                        'idCXC' : idCXC,
                        'idServicio' : idServicio
                    }; 


                    j++;
                }

            });
            //console.log(JSON.stringify(arreglo));
            return arreglo;
        }

       /* function obtieneIdsCXC2(){
            var j = 0;
            var arreglo = [];

            $("#t_facturas .renglon_partida").each(function() {
                var idOrden = $(this).attr('idOrden');
                var idVenta = $(this).attr('idVenta');
                var idPlan = $(this).attr('idPlan');
                var idCXC = $(this).attr('idCXC');
                var idServicio = $(this).attr('idServicio');
               
                if(JSON.stringify(arreglo).indexOf(idCXC)=== -1){

                    arreglo[j] = {
                        'idCXC' : idCXC,
                        'idServicio' : idServicio
                    }; 


                    j++;
                }
            });
           
            return arreglo;
        }*/

        $('#i_precio_s, #i_cantidad_s').change(function(){

            if($(this).validationEngine('validate')==false) {
                var precio=quitaComa($('#i_precio_s').val());
                var cantidad=$('#i_cantidad_s').val();

                if(precio==''){
                    precio=0;
                }

                if(precio > 0 && cantidad > 0)
                {
                    var t = parseFloat(cantidad)*parseFloat(precio);
                    $('#i_importe_s').val(formatearNumero(t.toFixed(2)));

                }else{
                    $('#i_importe_s').val('');
                }
            }else{
                $('#i_importe_s').val('');
                $(this).val('');
            }

        });

    $('#b_timbrar').click(function()
    {
        
        var id = $('#i_id').val();
        var idCFDI = $('#i_id_cfdi').val();
        var idEmpresa = $('#i_empresa_fiscal').attr('alt2');
    
        $('#fondo_cargando').show();
        $.ajax({
            type: 'GET',
            // url: '../cfdi_corporativo/php/ws_genera_factura.php',
            url: '../cfdi_corporativo/php/ws_gf_retencion.php',
            data : {'empresa':idEmpresa, 'registro': idCFDI},
            success: function(data)
            {
                console.log(data);

                if(data == 'OK')
                {
                    if(parseInt(actualizarDatosCFDI(id, idCFDI)) == parseInt(id))
                    {
                        
                        idFactura = id;
                        actualizaCXC(idFactura,'Timbrar','T',obtieneIdsCXC(),'La factura se timbro correctamente');
                       
                    }else{
                        mandarMensaje('La factura se timbro pero no me actualizó los datos xml');  ///vacio
                    }
                }
                else
                    mandarMensaje('Error al generar timbre (1)');

                $('#fondo_cargando').hide();   
            },
            error: function (xhr) {
                //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                mandarMensaje('* Error al generar timbre (2)');
            }
        });

    });

    //-->NJES May/25/2020 se solicita se confirme la cancelación de una factura
    $('#b_cancelar').click(function(){
        mandarMensajeConfimacion('¿Estas seguro que deseas cancelar la factura?',$('#i_id').val(),'cancelar_factura');
    });

    $(document).on('click','#b_cancelar_factura',function(){
        
        var tipo = $('#div_estatus label').text();

        var id = $('#i_id').val();
        var idCFDI = $('#i_id_cfdi').val();
        var idEmpresa = $('#i_empresa_fiscal').attr('alt2');
        $('#fondo_cargando').show();

        if(tipo == 'TIMBRADA')
        {
            $.ajax({
                type: 'GET',
                url: '../cfdi_corporativo/php/cancelar_nuevo.php',
                data : {'empresa':idEmpresa, 'registro': idCFDI},
                success: function(data)
                {
                    var n = data.indexOf("OK");
                    if(n < 0)
                    {
                        mandarMensaje("Error al enviar petición para cancelar factura: " + data);
                    }else{
                        if(parseInt(actualizarEstatusFactura(id,'P')) == parseInt(id))
                        {
                           
                            idFactura = id;
                            actualizaCXC(idFactura,'Pendiente','P',obtieneIdsCXC(),'La factura se mando a cancelar de manera correcta, verificar la respuesta del receptor.');
                         
                        }else
                        mandarMensaje('No se puedo enviar la petición de cancelar la factura');  //vacio
                        
                    }

                    $('#fondo_cargando').hide();   
                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al enviar petición para cancelar factura');
                }
            });
        }else{
            if(parseInt(actualizarEstatusFactura(id,'C')) == parseInt(id))
            {
                //-->NJES Feb/11/2020 se libera el cxc de la prefactura y se cambia a estatus A cuando la prefactura se cancela
                idFactura = id;
                actualizaCXC(id,'Cancelar','A',obtieneIdsCXC(),'La pre factura se mando a cancelar de manera correcta.');
                $('#fondo_cargando').hide();
            }else{
                mandarMensaje('No se puedo enviar la petición de cancelar de la pre factura'); //vacio
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
            url: '../cfdi_corporativo/php/veifica_status.php',
            data : {'empresa':idEmpresa, 'registro': idCFDI},
            success: function(data)
            {
                if(data == 1)
                {  //bajamos xml y actualizamos estatus a cancelada en ginther
                    $.ajax({
                        type: 'POST',
                        url: 'php/facturacion_descargar_acuse.php',
                        data : {'idFactura':id, 'idCFDI': idCFDI},
                        success: function(data)
                        {
                            //console.log('*'+data+'*');
                            if(data > 0)
                            {
                                //-->NJES Jan/24/2020 se libera el cxc de la factura y se cambia a estatus A cuando la factura se cancela
                                actualizaCXC(id,'Cancelar','A',obtieneIdsCXC(),'Se aprobó la cancelación.');
                            }else{
                                mandarMensaje('Error al descargar acuse y actualizar');
                            }

                        },
                        error: function (xhr) {
                            //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                            mandarMensaje('* Error al descargar acuse y actualizar');
                        }
                    });
                }else if(data == 2)
                {
                    mandarMensaje('La factura no ha sido aprobada por el cliente favor de intentarlo mas tarde');
                }else{
                    ///actualizamos estatus a timbrado 

                    if(parseInt(actualizarEstatusFactura(id,'T')) == parseInt(id))
                    {
                        limpiarGuardar();
                        idFactura = id;
                        muestraRegistro(id);
                        muestraRegistroDetalle(id);
                        mandarMensaje('Rechazada. Se actualizó estatus a factura timbrada.');
                    }else{
                        mandarMensaje('No se puedo actualizar estatus a timbrada');  //vacio
                    }
                }

                $('#fondo_cargando').hide();   
            },
            error: function (xhr) {
                //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                mandarMensaje('* Error al generar timbre');
            }
        });
    });


    
        function limpiarGuardar(){
            $('#forma_general input').not('[type=radio]').val('');
            $('#i_subtotal, #i_iva_total, #i_total').val('');
            $('#t_facturas tbody').html('');
            $('#div_estatus').html('');
        }

        function limpiar(){
            $('.cliente_alterno_pg').hide();
            $('#i_descripcion_alterna_pg').val('');
            $('#forma_general input').not('[type=radio]').val('');
            $('#b_guardar_prefactura').prop('disabled',false);
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            generaFecha('s_mes');
            muestraSelectUsoCFDI('s_cfdi');
            muestraSelectMetodoPago('s_metodo_pago');
            $('#s_forma_pago').html('').val('');
            $('#i_subtotal, #i_iva_total, #i_total').val('');
            $('#i_fecha').val(hoy);
            $('#t_facturas tbody').html('');
            $('#div_estatus').html('');
            $('#div_b_verificar_estatus').css('display','none');
            $('#div_b_descargar_acuse').css('display','none'); 
            $('#div_b_solicitud_cancelacion').css('display','none'); 
            idFactura = 0;
            $('#forma_general input,select').prop('disabled',false);
            $('#b_buscar_clientes,#b_buscar_empresa_fiscal').prop('disabled',false);
            //-->NJES Feb/19/2020 se limpian los atrinutos de input
            $('#i_cliente').attr({'alt':'','alt2':'','codigo_postal':''});
            $('#i_empresa_fiscal').val('').attr({'alt':'','alt2':''});
        }

        $('#b_nuevo').click(function(){
            limpiar();
            limpiaFormaPartidas();
            $('#div_b_guardar_prefactura,#div_b_sustituir').css('display','block');
            $('.secundarios,#div_cont_estatus').css('display','none');
            $('#div_relacion_facturas').css('display','none');
            $('.renglon_tickets').remove();
            $('#s_clave_sat_s').prop('disabled',true);
            $('#s_id_unidades_s').prop('disabled',true);
            $('#i_descripcion_s').prop('disabled',true);
            $('#b_agregar').prop('disabled',true);
            $('#b_ver_informacion').prop('disabled',true);

            $('#ch_lleva_descripcion_alterna').prop('checked',false);
            $('#b_descripcion_alterna').prop('disabled',true);
            muestraSelectClaveProductoSAT('s_clave_sat_s_da');
            $('#s_clave_sat_s_da').prop('disabled',false);
            muestraSelectClaveUnidadesSAT('s_id_unidades_s_da');
            $('#s_id_unidades_s_da').prop('disabled',false);
            $('#i_descripcion_s_da').val('').prop('disabled',false);
            $('#forma_general').validationEngine('hide');
            $('#forma_partidas').validationEngine('hide');
            $('#t_tickets tbody').empty();
            $('#i_descuento').val('');
        });

        $('#b_sustituir').click(function(){
            $('#b_sustituir').prop('disabled',true);
            if ($('#forma_general').validationEngine('validate'))
            {
                if($('#t_facturas .renglon_partida').length > 0)
                {
                    muestraFacturasCanceladas();
                }else{
                    mandarMensaje('Debe existir por lo menos un producto/servicio para guardar');
                }

                $('#b_sustituir').prop('disabled',false);
            }else{
                $('#b_sustituir').prop('disabled',false);
            }
        });

        function muestraFacturasCanceladas(){
            $('#t_facturas_canceladas').html('');
            $('#i_filtro_facturas_canceladas').val('');

            var datos = {
                'idUnidadNegocio' : idUnidadActual,//$('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt'),
                'idRazonSocial' : $('#i_cliente').attr('alt')
            };

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_alarmas_buscar_canceladas.php',
                dataType:"json", 
                data:{'datos':datos}, 
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        for(var i=0;data.length>i;i++)
                        {
                            var html='<tr class="facturas_canceladas" alt="'+data[i].id+'">\
                                        <td data-label="Folio Interno" style="text-align:left;">'+data[i].folio+'</td>\
                                        <td data-label="Folio Fiscal">'+data[i].folio_fiscal+'</td>\
                                        <td data-label="RFC Emisor">'+data[i].rfc_emisor+'</td>\
                                        <td data-label="Cliente">'+data[i].cliente_receptor+'</td>\
                                        <td data-label="RFC Receptor">'+data[i].rfc_receptor+'</td>\
                                        <td data-label="Razón Social Receptor">'+data[i].razon_social_receptor+'</td>\
                                        <td data-label="Monto">'+formatearNumero(data[i].total)+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td width="8%">\
                                            <input type="checkbox" class="ch_sustituir" name="ch_sustituir" value="'+data[i].id+'" id="ch_sustituir_'+data[i].id+'" alt="'+data[i].folio_fiscal+'">\
                                        </td>\
                                    </tr>';

                            $('#t_facturas_canceladas').append(html);   
                        }

                    }else{
                        var html = '<tr><td colspan="9">No se encontraron regstros</td></tr>';
                        $('#t_facturas_canceladas').append(html); 
                    }
                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_canceladas.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas canceladas');
                }
            });

            $('#dialog_sustituir').modal('show');
        }

        $('#b_guardar_sustituir').click(function(){

            if(obtieneFacturasSustituir().length > 0)
            {
                mandarMensajeConfimacion('Se sustituiran las facturas canceladas con la nueva, ¿Deseas continuar?',0,'aceptar_sustituir');
            }else{
                mandarMensaje('Debe existir por lo menos una factura seleccionada para sustituir.');
                $('#b_guardar_sustituir').prop('disabled',false);
            }
        });

        $('#b_ver_relacion_facturas').click(function(){
            var id = $(this).attr('alt');
            muestraFacturasSustituidas(id);
        });

        function muestraFacturasSustituidas(id){
            $('#t_facturas_relacionadas tbody').html('');

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_facturas_sustituidas.php',
                dataType:"json", 
                data:{'idFactura':id}, 
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        for(var i=0;data.length>i;i++)
                        {
                            var html='<tr>\
                                        <td data-label="Folio Interno" style="text-align:left;">'+data[i].folio_interno+'</td>\
                                        <td data-label="Folio Fiscal">'+data[i].folio_fiscal+'</td>\
                                        <td data-label="Monto">'+formatearNumero(data[i].total)+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                    </tr>';

                            $('#t_facturas_relacionadas tbody').append(html);
                        }
                    }
                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_facturas_sustituidas.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas sustituidas');
                }
            });

            $('#dialog_relacion_facturas').modal('show');
        }

        function obtieneFacturasSustituir(){
            var j = 0;
            var arreglo = [];

            $(".ch_sustituir").each(function(){
                if($(this).is(':checked'))
                {
                    var id = $(this).val();
                    var folioF = $(this).attr('alt');
                    arreglo[j] = {
                        'idFactura' : id,
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

        /*function calculaTotales(){

            var subtotal=0;
            var iva=0;
            var total=0;
            var descuento=0;

            $('.renglon_partida').each(function(){

                var valor= parseFloat($(this).attr('importe'));
                var des= parseFloat($(this).attr('descuento'));

                //-->NJES Feb/27/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
                //redondear cada valor y tomar solo dos decimales ya que el calculo al formar el xml asi lo hace
                total=total+(parseFloat(valor.toFixed(2))*1000);
                descuento=descuento+(parseFloat(des)*1000);
            });

            var valorIva = $('input[name=radio_iva]:checked').val();
            var valorI = 0;
             if(valorIva==16){
                 iva=1.16;
                 ivaD = 0.16;
                 valorI = 16;
             }else{
                 iva=1.08;
                 ivaD = 0.08;
                 valorI = 8;
             }

            //-->NJES Feb/27/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
            var subtotal = ((parseFloat(total)/1000)/iva);
            var montoIva = subtotal*ivaD;

            var iv = (((parseFloat(total)/1000)-(parseFloat(descuento)/1000))/100*valorI);
             var tt = ((parseFloat(total)/1000)-(parseFloat(descuento)/1000)) + iv;

            $('#i_subtotal').val(formatearNumero((parseFloat(total)/1000).toFixed(2)));
            $('#i_iva_total').val(formatearNumero(iv.toFixed(2)));
            $('#i_total').val(formatearNumero(tt.toFixed(2))); // aqui we

            $('#i_descuento').val(formatearNumero((parseFloat(descuento)/1000).toFixed(2)));

        }*/

        //-->NJES May/13/2020 modificar proceso de calculo de decimales
        function calculaTotales(){
            var subtotal=0;
            var iva=0;
            var total=0;
            var descuento=0;

            $('.renglon_partida').each(function(){
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: 'php/verifica_importes.php',
                    dataType:"json", 
                    data:  {'tipo':1, 'cantidad': parseFloat($(this).attr('cantidad')), 'precio': parseFloat($(this).attr('precio'))},
                    success: function(data)
                    {
                      
                        $('#i_sub_calculado').val(data);

                    }
                });

                var valor_importe = $('#i_sub_calculado').val();
                valor_importe = (+(Math.round(valor_importe + "e+2")  + "e-2"));
                total=total+(parseFloat(valor_importe)*1000);

                var valor_descuento =  parseFloat($(this).attr('descuento'));
                valor_descuento = (+(Math.round(valor_descuento + "e+2")  + "e-2"));
                descuento=descuento+(parseFloat(valor_descuento)*1000);
            });

            var valorIva = $('input[name=radio_iva]:checked').val();
            var valorI = 0;
            if(valorIva==16){
                iva=1.16;
                ivaD = 0.16;
                valorI = 16;
            }else{
                iva=1.08;
                ivaD = 0.08;
                valorI = 8;
            }

            var subtotal = ((parseFloat(total)/1000)/iva);
            var montoIva = subtotal*ivaD;

            var iv = (((parseFloat(total)/1000)-(parseFloat(descuento)/1000))/100*valorI);
            var tt = ((parseFloat(total)/1000)-(parseFloat(descuento)/1000)) + iv;

            var sub_f = (+(Math.round((parseFloat(total)/1000) + "e+2")  + "e-2"));
            var iv_f = (+(Math.round(iv + "e+2")  + "e-2"));
            var total_f =  (+(Math.round(tt + "e+2")  + "e-2"));
            var desc_f =  (+(Math.round((parseFloat(descuento)/1000) + "e+2")  + "e-2"));

            $('#i_subtotal').val(formatearNumero(sub_f));
            $('#i_iva_total').val(formatearNumero(iv_f));
            $('#i_total').val(formatearNumero(total_f));
            $('#i_descuento').val(formatearNumero(desc_f));

        }

        $(document).ready(function()
        {

            $('#i_cantidad_s').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });

        });

         $(document).ready(function()
         {

            $('#i_importe_nc').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });

        });

        $('#i_importe_nc').change(function(){
            var precio=quitaComa($('#i_importe_nc').val());

            if(precio=='')
                precio=0;
            

            if(precio > 0)
            {
                var valorIva = $('input[name=radio_iva_nc]:checked').val();
                var iva = (parseFloat(precio)*parseInt(valorIva))/100;
                iva = (+(Math.round(iva + "e+2")  + "e-2"));

                var total = parseFloat(precio)+iva;
                total = (+(Math.round(total + "e+2")  + "e-2"));
                
                $('#i_iva_nc').val(iva);
                $('#i_total_nc').val(total);
            }

        });

         $(document).ready(function()
         {

            $('#i_precio_s').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });
            
        });

        $('#b_descargar_prefactura').click(function(){
            var datos = {
                'path':'formato_factura_alarmas',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Prefactura',
                'tipo':1,
                'tipoAr':'prefactura'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        });

        $('#b_descargar_acuse').click(function(){
            var datos = {
                'path':'formato_acuse_factura_alarmas',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Acuse_Factura',
                'tipo':1,
                'tipoAr':'factura'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        });

        $('#b_descargar_solicitud_cancelacion').click(function(){

            var datos = {
                'path':'formato_solicitud_cancelacion_alarmas',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Solicitud Cancelacion',
                'tipo':1,
                'tipoAr':'factura'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');

        });

        $('#b_descargar_pdf').click(function(){
            var datos = {
                'path':'formato_factura_alarmas',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Factura',
                'tipo':1,
                'tipoAr':'factura'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        });

        $('#b_descargar_xml').click(function(){
            var idFactura = $('#i_id').val();
            var folio = $('#i_folio_interno').val();

            window.open("php/facturacion_descargar_xml.php?id=" + idFactura + "&folio=" + folio);
        });

        $('#b_enviar_correo').click(function(){
            var idFactura=$('#i_id').val();
            var folio=$("#i_folio_interno").val();
            generaPdf(idFactura,folio,'Factura','factura','factura');
        });

        $("#b_enviar").click(function (){
            var idFactura = $(this).attr('idFactura');
            var folioFactura = $(this).attr('idFactura');
            var ruta = $(this).attr('ruta');
            var tipo = $(this).attr('tipo');
            //var ruta = '../facturacion/archivos/factura_'+folioFactura+'_'+idFactura;

            mandaCorreo(idFactura,folioFactura,ruta,tipo);
        });

        function generaPdf(id,folio,nombreArchivo,tipo,tipoAr)
        {
            var ruta = '../facturacion/archivos/'+tipoAr+'_'+folio+'_'+id;

            var datos = {
                'path':'formato_factura_alarmas',
                'idRegistro':id,
                'folioFactura':folio,
                'nombreArchivo':nombreArchivo,
                'vp':tipo,
                'tipoAr':tipoAr,
                'tipo':2  //guardar archivo en carpeta
            };
            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            //window.open("php/convierte_pdf.php?D="+datosJ,'_new');

            $.get('php/convierte_pdf.php',{'D':datosJ},function(data)
            {
                if(data=='OK')
                    generaXml(id,folio,ruta,nombreArchivo,tipoAr);
                else
                    mandarMensaje(data);
            });
        }

        function generaXml(idFactura,folioFactura,ruta,nombreArchivo,tipoAr)
        {
            $.post('php/facturacion_generar_baja_xml.php',{'id':idFactura,'folio':folioFactura,'tipo':tipoAr},
            function(data_ruta)
            {
                if(data_ruta==0)
                {
                    mandarMensaje("Ocurrio un error al crear archivo xml");
                }else{
                    $('#t_enviar_correo >tbody tr').remove();   
                    var correo = $('#i_email').val();

                    $('#t_enviar_correo').append("<tr><td>Ingresa una o varias direcciones de correo electronico separado por coma<br/> para poder enviar correo con los documentos del la factura timbrada <br/><br/><textarea type='text' class='form-control' id='dir_correo' name='dir_correo'>" + correo + "</textarea><br/><span class='ejemplo'>Ejemplo: usuario@denken.mx,usuario@correo.mx</span> </td></tr>");
                    $('#b_enviar').attr({'idFactura':idFactura,'folioFactura':folioFactura,'ruta':ruta,'tipo':nombreArchivo});

                    $("#dialog_correo").modal('show');
                    // viendo lo del correo         
                }
            });
        }

        function mandaCorreo(idFactura,folioFactura,ruta,tipo)
        {
            if(validarEmail( $('#dir_correo').val()) =='')
            {

                $("#dialog_correo").modal('hide');

                $('#fondo_cargando').show();

                var datos = {
                    'ruta' : ruta,
                    'asunto' : tipo+" y documentos",
                    'mensaje' : tipo+" generada", 
                    'dest_mail' : $('#dir_correo').val(), 
                    'id' : idFactura,
                    'folio' : folioFactura
                };

                $.post('php/facturacion_enviar_correo_timbres.php',{'datos':datos},function(data)
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

        $('#b_guardar_nota_credito').click(function(){
            muestraNotasCreditoIdFactura(idFactura);
            $('#s_metodo_pago_nc,#s_forma_pago_nc').prop('disabled',false);
            $('#dialog_notas_credito').modal('show');
        });

        $('#b_agregar_nota_credito').click(function(){
            $('#b_agregar_nota_credito').prop('disabled',true);

            if ($('#forma_notas_credito').validationEngine('validate'))
            {
                //-->NJES Feb/18/2020 se compara que el importe del abono de la nota no revase el saldo actual de la factura
                if(parseFloat(quitaComa($('#i_importe_nc').val())) <= parseFloat(quitaComa($('#label_saldo_actual_factura').text())))
                {
                    guardarNotaCredito();
                }else{
                    mandarMensaje('No puedes abonar mas del saldo actual de la factura.');
                    $('#b_agregar_nota_credito').prop('disabled',false);
                }   
            }else{
                $('#b_agregar_nota_credito').prop('disabled',false);
            }
        });

        function guardarNotaCredito(){
            var idFactura = $("#i_id").val();
            var folioFactura = $("#i_folio_interno").val();

            var info={
                'descripcion' : $('#i_descripcion_nc').val(),
                'tasaIva' : $('input[name=radio_iva_nc]:checked').val(),
                'importe' : parseFloat(quitaComa($('#i_importe_nc').val())),
                'idFactura' : idFactura,
                'folioFactura' : folioFactura,
                'idUnidadNegocio' : idUnidadActual,
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscalEmisor' : $('#i_empresa_fiscal').attr('alt'),
                'idCFDIEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt2'),
                //-->NJES Feb/19/2020 se toman los valores del inpit 
                'idRazonSocialReceptor' : $('#i_cliente').attr('alt'),
                'razonSocialReceptor' : $('#i_cliente').attr('alt2'),
                'codigoPostal' : $('#i_cliente').attr('codigo_postal'),
                'rfc' : $('#i_rfc').val(),
                'idUsoCFDI' : $('#s_cfdi').val(),
                //-->NJES July/14/2020 se puede seleccionar el metodo y forma pago (anteriormente estaba como metodo: PUE y forma: 01)
                'idMetodoPago' : $('#s_metodo_pago_nc').val(),
                'idFormaPago' : $('#s_forma_pago_nc').val(),
                'fecha' : $('#i_fecha').val(),
                'diasCredito' : $('#i_dias_credito').val(),
                'digitosCuenta' : $('#i_4_cuenta').val(),
                'mes' : numMes,//$('#s_mes').val(),
                'anio' : anio,//$('#i_anio').val(),
                'observaciones' : $('#i_observaciones').val(),
                'fechaInicioPeriodo' : hoy,//$('#i_inicio_periodo').val(),
                'fechaFinPeriodo' : hoy,//$('#i_fin_periodo').val(),
                'usuario' : usuario,
                'iva' : quitaComa($('#i_iva_nc').val()),
                'total' : quitaComa($('#i_total_nc').val())
            };
            

            $.ajax({
                type: 'POST',
                url: 'php/nota_credito_guardar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) {
                    console.log(data.idFactura+' * '+data.idCFDI);
                    if(data != 0 )
                    { 
                        $('#i_descripcion_nc').val('');
                        $('#i_iva_nc').val('');
                        $('#i_importe_nc').val('');

                        //-->NJES July/14/2020 agregar metodo y forma de pago a notas de credito
                        muestraSelectFormaPago('TODOS','s_forma_pago_nc');
                        muestraSelectMetodoPago('s_metodo_pago_nc');
                        $('#s_metodo_pago_nc,#s_forma_pago_nc').prop('disabled',false);

                        var id=data.idFactura;
                        var idCFDI = data.idCFDI;
                        var idEmpresa = $('#i_empresa_fiscal').attr('alt2');

                        timbrarNotaCredito(idFactura,id,idCFDI,idEmpresa);
                        
                        //mandarMensaje('Se guardo la nota de crédito');
                        //muestraNotasCreditoIdFactura(idFactura);
                    }else{ 
                        mandarMensaje('Error al guardar Nota de Crédito.');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/nota_credito_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar nota de crédito.');
                }
            });

            $('#b_agregar_nota_credito').prop('disabled',false);
        }

        function timbrarNotaCredito(idFactura,id,idCFDI,idEmpresa){
            $('#fondo_cargando').show();
            $.ajax({
                type: 'GET',
                // url: '../cfdi_corporativo/php/ws_genera_factura.php',
                url: '../cfdi_corporativo/php/ws_gf_retencion.php',
                data : {'empresa':idEmpresa, 'registro': idCFDI},
                success: function(data)
                {
                    console.log(data);
                    if(data == 'OK')
                    {
                        if(parseInt(actualizarDatosCFDI(id, idCFDI)) == parseInt(id))
                        {
                            mandarMensaje('La nota de credito se guardo y timbro correctamente');
                            
                        }else{
                            mandarMensaje('La factura se creo y timbro pero no me actualizó los datos xml');  ///vacio
                        }

                        //-->NJES May/27/2020 al guardar una nota de credito si se timbra buscar los datos de la factura 
                        //para que se actualice y ver si se muestra o no el boton cancelar factura
                        muestraRegistro(idFactura);
                    }
                    else
                    {
                        eliminarNotaCredito(id);
                        mandarMensaje('Ocurrio un error al timbrar la Nota de Crédito: ' + data + '. Verificar los datos.');  ///vacio
                    }


                    muestraNotasCreditoIdFactura(idFactura);
                    $('#fondo_cargando').hide(); 
                },
                error: function (xhr) {
                    //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al generar timbre');
                }
            });
        }

        function eliminarNotaCredito(id){
            $.ajax({
                type: 'POST',
                url: 'php/nota_credito_eliminar.php',
                dataType:"json", 
                data:  {'id':id},
                success: function(data) {
                    if(data = 0 )
                    { 
                        mandarMensaje('Nota Credito guardada. Error al generar timbre');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/nota_credito_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al eliminar nota de credito.');
                }
            });
        }

        function muestraNotasCreditoIdFactura(idFactura){
            //-->NJES Feb/18/2020 se muestra el saldo actual que queda de la factura para que no me permita abonar mas de lo que se tiene que pagar
            muestraSaldoActualFactura(idFactura);

            $('#t_notas_credito tbody').html('');
 
            $.ajax({
                type: 'POST',
                url: 'php/notas_credito_buscar_idFactura.php',
                dataType:"json", 
                data:  {'idFactura':idFactura},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){

                            var cancelar='<button type="button" alt="'+data[i].id+'" alt2="'+data[i].id_factura_cfdi+'" class="btn btn-danger btn-sm b_cancelar_NC " data-toggle="tooltip" data-placement="top" title="Cancelar Nota de Crédito"><i class="fa fa-close" aria-hidden="true"></i></button>';
                            var verificarEstatus='<button type="button" alt="'+data[i].id+'" alt2="'+data[i].id_factura_cfdi+'" class="btn btn-warning btn-sm b_verificar_estatus_NC" data-toggle="tooltip" data-placement="top" title="Verificar Estatus Nota de Crédito"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                            var pdfNotaCredito='<button type="button" alt="'+data[i].id+'" alt2="'+data[i].id_factura_cfdi+'" class="btn btn-info btn-sm b_pdf_NC" data-toggle="tooltip" data-placement="top" title="Descargar PDF Nota de Crédito"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>';
                            var xmlNotaCredito='<button type="button" alt="'+data[i].id+'" alt2="'+data[i].id_factura_cfdi+'" alt3="'+data[i].folio_nota_credito+'" class="btn btn-secondary btn-sm b_xml_NC" data-toggle="tooltip" data-placement="top" title="Descargar XML Nota de Crédito"><i class="fa fa-file-code-o" aria-hidden="true"></i></button>'
                            var descargarAcuse='<button type="button" alt="'+data[i].id+'" alt2="'+data[i].id_factura_cfdi+'" class="btn btn-info btn-sm b_acuse_NC" data-toggle="tooltip" data-placement="top" title="Descargar Acuse Nota de Crédito"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>';
                            var correoNotaCredito='<button type="button" alt="'+data[i].id+'" alt2="'+data[i].id_factura_cfdi+'" alt3="'+data[i].folio_nota_credito+'" class="btn btn-success btn-sm b_enviar_correo_NC" data-toggle="tooltip" data-placement="top" title="Enviar correo con Nota de Crédito"><i class="fa fa-envelope" aria-hidden="true"></i></button>';

                            var botones = '';
                            switch(data[i].estatus) {
                                case 'T':
                                    botones = cancelar+'  '+pdfNotaCredito+'  '+xmlNotaCredito+'  '+correoNotaCredito;
                                    break;
                                case 'C':
                                    botones = descargarAcuse;
                                    break;
                                case 'P':
                                    botones = verificarEstatus;
                                    break;
                                default:
                                    // 
                            }
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_nota_credito" alt="'+data[i].id+'">\
                                        <td data-label="Folio">'+data[i].folio_nota_credito+'</td>\
                                        <td data-label="Método Pago">'+data[i].metodo_pago+'</td>\
                                        <td data-label="Forma Pago">'+data[i].forma_pago+'</td>\
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td data-label="Total">$'+formatearNumeroCSS(data[i].total)+'</td>\
                                        <td>'+botones+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
                                        /tr>';
                            ///agrega la tabla creada al div 
                            $('#t_notas_credito tbody').append(html);                             
                        }

                        $('[data-toggle="tooltip"]').tooltip();

                    }else{
                        var html='<tr class="renglon_nota_credito_b">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_notas_credito tbody').append(html);

                    }

                    $('#s_metodo_pago_nc,#s_forma_pago_nc').prop('disabled',false);
                },
                error: function (xhr) 
                {
                    console.log('php/notas_credito_buscar_idFactura.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Notas de Crédito');
                }
            });
        }

        //-->NJES Feb/18/2020 se muestra el saldo actual que queda de la factura para que no me permita abonar mas de lo que se tiene que pagar
        function muestraSaldoActualFactura(idFactura){
            $('#label_saldo_actual_factura').text('');

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_saldo_idFactura.php',
                dataType:"json", 
                data:  {'idFactura':idFactura},
                success: function(data) {
                    $('#label_saldo_actual_factura').text(formatearNumero(data[0].saldo));
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_buscar_saldo_idFactura.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar el saldo de la factura.');
                }
            });
        }

        //-->NJES May/25/2020 se solicita se confirme la cancelación de un pago
        $('#t_notas_credito').on('click', '.b_cancelar_NC', function(){
            var idNotaCredito = $(this).attr('alt');
            var idCFDI = $(this).attr('alt2');
            mandarMensajeConfimacionDos('¿Estas seguro que deseas cancelar la nota de credito?',idNotaCredito,idCFDI,'cancelar_nota_credito');
        });

        $(document).on('click','#b_cancelar_nota_credito',function(){
            
            $('#fondo_cargando').show(); 
            var idFactura = $("#i_id").val();
            var idNotaCredito = $(this).attr('alt');
            var idCFDI = $(this).attr('alt2');
            var idEmpresa = $('#i_empresa_fiscal').attr('alt2');

            $.ajax({
                type: 'GET',
                url: '../cfdi_corporativo/php/cancelar_nuevo.php',
                data : {'empresa':idEmpresa, 'registro': idCFDI},
                success: function(data)
                {
                    var n = data.indexOf("OK");
                    if(n < 0)
                    {
                        mandarMensaje("Error al enviar petición para cancelar nota de crédito");
                    }else{
                        if(parseInt(actualizarEstatusFactura(idNotaCredito,'P')) == parseInt(idNotaCredito))
                        {
                            mandarMensaje('La nota de crédito se mando a cancelar de manera correcta, verificar la respuesta del receptor.');
                            
                            //-->NJES May/27/2020 al guardar una nota de credito si se timbra buscar los datos de la factura 
                            //para que se actualice y ver si se muestra o no el boton cancelar factura
                            muestraRegistro(idFactura);
                        }else
                            mandarMensaje('No se puedo enviar la petición de cancelar la nota de crédito');  //vacio
                        
                    }

                    muestraNotasCreditoIdFactura(idFactura);
                    $('#fondo_cargando').hide(); 
                },
                error: function (xhr) {
                    //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al enviar petición para cancelar la nota de crédito');
                }
            });

            $('[data-toggle="tooltip"]').tooltip('hide');
        });

        $('#t_notas_credito').on('click', '.b_verificar_estatus_NC', function(){
            var idFactura = $("#i_id").val();
            var idNotaCredito = $(this).attr('alt');
            var idCFDI = $(this).attr('alt2');
            var idEmpresa = $('#i_empresa_fiscal').attr('alt2');

            $('#fondo_cargando').show();

            $.ajax({
                type: 'GET',
                url: '../cfdi_corporativo/php/veifica_status.php',
                data : {'empresa':idEmpresa, 'registro': idCFDI},
                success: function(data)
                {
                    if(data == 1)
                    {  //bajamos xml y actualizamos estatus a cancelada en ginther
                        $.ajax({
                            type: 'POST',
                            url: 'php/facturacion_descargar_acuse.php',
                            data : {'idFactura':idNotaCredito, 'idCFDI': idCFDI},
                            success: function(data)
                            {
                                console.log('*'+data+'*');
                                if(data > 0)
                                {
                                    mandarMensaje('Se aprobó la cancelación.');

                                    //-->NJES May/27/2020 al guardar una nota de credito si se timbra buscar los datos de la factura 
                                    //para que se actualice y ver si se muestra o no el boton cancelar factura
                                    muestraRegistro(idFactura);
                                }else{
                                    mandarMensaje('Error al descargar acuse y actualizar');
                                }

                            },
                            error: function (xhr) {
                                //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                                mandarMensaje('* Error al descargar acuse y actualizar');
                            }
                        });
                    }else if(data == 2)
                    {
                        mandarMensaje('La nota de crédito no ha sido aprobada por el cliente favor de intentarlo mas tarde');
                    }else{
                        ///actualizamos estatus a timbrado 

                        if(parseInt(actualizarEstatusFactura(idNotaCredito,'T')) == parseInt(idNotaCredito))
                        {
                            mandarMensaje('Rechazada. Se actualizó estatus a nota de crédito timbrada.');
                        }else{
                            mandarMensaje('No se puedo actualizar estatus a timbrada');  //vacio
                        }
                    }

                    muestraNotasCreditoIdFactura(idFactura);
                    $('#fondo_cargando').hide();   
                },
                error: function (xhr) {
                    //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al verificar estatus nota de crédito');
                }
            });

            $('[data-toggle="tooltip"]').tooltip('hide');
        });

        $('#t_notas_credito').on('click', '.b_acuse_NC', function(){
            var idNotaCredito = $(this).attr('alt');

            var datos = {
                'path':'formato_acuse_factura',
                'idRegistro':idNotaCredito,
                'nombreArchivo':'Nota_de_Crédito',
                'tipo':1,
                'tipoAr':'notaC'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');

            $('[data-toggle="tooltip"]').tooltip('hide');
        });

        $('#t_notas_credito').on('click', '.b_pdf_NC', function(){
            var idNotaCredito = $(this).attr('alt');

            var datos = {
                'path':'formato_factura_alarmas',
                'idRegistro':idNotaCredito,
                'nombreArchivo':'Nota de Credito',
                'tipo':1,
                'tipoAr':'nota_credito'
            };
          
            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');

            $('[data-toggle="tooltip"]').tooltip('hide');
        });

        $('#t_notas_credito').on('click', '.b_xml_NC', function(){
            var idNotaCredito = $(this).attr('alt');
            var folio = $(this).attr('alt3');

            window.open("php/facturacion_descargar_xml.php?id=" + idNotaCredito + "&folio=" + folio);

            $('[data-toggle="tooltip"]').tooltip('hide');
        });

        $('#t_notas_credito').on('click', '.b_enviar_correo_NC', function(){
            var idNotaCredito = $(this).attr('alt');
            var folio = $(this).attr('alt3');

            generaPdf(idNotaCredito,folio,'Nota de Credito','nota_de_credito','nota_de_credito');

            $('[data-toggle="tooltip"]').tooltip('hide');
        });

        $('#b_buscar_nota_credito').click(function(){
            fechaHoyServidor('i_fecha_inicio_NC','primerDiaMes');
            fechaHoyServidor('i_fecha_fin_NC','ultimoDiaMes');
            muestraSucursalesPermiso('s_filtro_sucursal_NC',idUnidadActual,modulo,idUsuario);

            $('#i_fecha_inicio_NC').val(primerDiaMes);
            $('#i_fecha_fin_NC').val(ultimoDiaMes);

            $('#s_filtro_sucursal_NC').prop('disabled',false);
            $('#i_filtro_NC').val('');
            mostrarNotasCreditoTodas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            $('#dialog_buscar_notas_credito').modal('show');
        });

        function mostrarNotasCreditoTodas(idUnidadNegocio,idSucursal){
            $('#t_buscar_notas_credito tbody').html(''); 

            $('#i_filtro_facturas').val('');
            $('.renglon_facturas').remove();

            var info = {
                'idUnidadNegocio' : idUnidadActual,
                'idSucursal': idSucursal,
                'fechaInicio' : $('#i_fecha_inicio_NC').val(),
                'fechaFin' : $('#i_fecha_fin_NC').val(),
                'esVentaOrdenPlan': 1
            };

            $.ajax({
                type: 'POST',
                url: 'php/notas_credito_buscar_todas.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){

                            
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_nota_credito_b" idNotaCredito="'+data[i].id+'" idFactura="'+data[i].id_factura_nota_credito+'" id_unidad_negocio="'+data[i].id_unidad_negocio+'" cliente="'+data[i].id_cliente+'" metodo="'+data[i].metodo_pago+'">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Folio Factura">'+data[i].folio_factura+'</td>\
                                        <td data-label="Folio Nota Crédito">'+data[i].folio_nota_credito+'</td>\
                                        <td data-label="Razon Social">'+data[i].razon_social+'</td>\
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td data-label="Total">$'+formatearNumero(data[i].total)+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_buscar_notas_credito tbody').append(html);   
                            
                        }

                    }else{
                        var html='<tr class="renglon_nota_credito_b">\
                                        <td colspan="8">No se encontró información</td>\
                                    </tr>';

                        $('#t_buscar_notas_credito tbody').append(html);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/notas_credito_buscar_todas.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Notas de Crédito');
                }
            });

        }

        $('#t_buscar_notas_credito').on('click', '.renglon_nota_credito_b', function(){
            idFactura = $(this).attr('idFactura');
            var idCliente = $(this).attr('cliente');
            var metodoPago = $(this).attr('metodo');
            var idUnidadNegocio = $(this).attr('id_unidad_negocio');
            $('#div_estatus').html('');

            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
            muestraSelectFormaPago(metodoPago,'s_forma_pago');

            muestraRegistro(idFactura);
            muestraRegistroDetalle(idFactura);
            $('#dialog_buscar_notas_credito').modal('hide');
        });

        fechaHoyServidor('i_fecha_inicio_NC','primerDiaMes');
        fechaHoyServidor('i_fecha_fin_NC','ultimoDiaMes');
        muestraSucursalesPermiso('s_filtro_sucursal_NC',idUnidadActual,modulo,idUsuario);

        $('#i_fecha_inicio_NC').val(primerDiaMes);
        $('#i_fecha_fin_NC').val(ultimoDiaMes);

    

        $('#s_filtro_sucursal_NC').change(function(){
    
            if($('#s_filtro_sucursal_NC').val() >= 1)
            {
                mostrarNotasCreditoTodas(idUnidadActual,$('#s_filtro_sucursal_NC').val());
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0" selected>Mostrar Todas</option>');
                mostrarNotasCreditoTodas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#i_fecha_inicio_NC').change(function(){
            if($('#s_filtro_sucursal_NC').val() >= 1)
            {
                mostrarNotasCreditoTodas(idUnidadActual,$('#s_filtro_sucursal_NC').val());
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0" selected>Mostrar Todas</option>');
                mostrarNotasCreditoTodas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#i_fecha_fin_NC').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                mostrarNotasCreditoTodas(idUnidadActual,$('#s_filtro_sucursal_NC').val());
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0" selected>Mostrar Todas</option>');
                mostrarNotasCreditoTodas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

            
        $(document).on('click','#ch_lleva_descripcion_alterna',function(){
            if($(this).is(':checked')==false){
                muestraSelectClaveProductoSAT('s_clave_sat_s_da');
                muestraSelectClaveUnidadesSAT('s_id_unidades_s_da');
                $('#i_descripcion_s_da').val('');
                
                $('#b_descripcion_alterna').prop('disabled',true);
            }else{
                $('#b_descripcion_alterna').prop('disabled',false);
            }
        });

        $('#b_descripcion_alterna').on('click',function(){
            $('#dialog_descripcion_alterna').modal('show');
            $('#i_cantidad_s_da').val(1).prop('disabled',true);
            $('#i_precio_s_da').val($('#i_subtotal').val()).prop('disabled',true);
            $('#i_importe_s_da').val($('#i_subtotal').val()).prop('disabled',true);
        });

        $('#b_guardar_descripcion_alterna').on('click',function(){
            if ($('#forma_da').validationEngine('validate'))
            {   
                $('#dialog_descripcion_alterna').modal('hide');
            }
        });


        function verificaDatosAlternos(){
            var vacio='';
           
            if($('#s_clave_sat_s_da').val()=='' || $('#s_clave_sat_s_da').val()===null ){
                
                vacio+='<br> - La clave SAT es obligatoria';
            } 
            
            if($('#s_id_unidades_s_da').val()=='' || $('#s_id_unidades_s_da').val()===null){
                vacio+='<br> - Verifica la unidad SAT es obligatoria';
            } 
            
            if($('#i_descripcion_s_da').val()==''){
                vacio+='<br> - Verifica la descripción Alterna es obligatoria';
            }


            return vacio;
        }

        function obtenerDatosDescripcionAlterna(){
            
            var j = 0;
            var arreglo = [];
                
                arreglo[j] = {
                    'idVenta': idVenta,
                    'idOrden' : idOrden,
                    'idPlan' : idPlan,
                    'idClaveSATProducto' : idClaveSATProducto,
                    'idClaveSATUnidad' : idClaveSATUnidad,
                    'nombreUnidadSAT' : nombreUnidadSAT,
                    'nombreProductoSAT' : nombreProductoSAT,
                    'cantidad' : cantidad,
                    'precio' : precio,
                    'importe' : importe,
                    'descripcion' : descripcion,
                    'idCXC' : idCXC
                };  

            return arreglo;
        
        }

        //-->NJES Feb/20/2020
        function obtenerTicketsFactura(idFactura){
            $('#t_tickets tbody').empty();
            $('.renglon_tickets_facturas').remove();

            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar_tickets_facturas.php',
                dataType:"json", 
                data:{'idFactura':idFactura},

                success: function(data) {
            
                    if(data.length != 0){

                        $('.renglon_tickets').remove();
                        for(var i=0;data.length>i;i++){
                            var html='<tr class="renglon_tickets_facturas" idCXC="'+data[i].id_cxc+'" idServicio="'+data[i].id_servicio+'" alt="'+data[i].id_registro+'" alt2="'+data[i].tipo+'">\
                                        <td data-label="Tipo">' + data[i].servicio+ '</td>\
                                        <td data-label="Tipo">' + data[i].tipo+ '</td>\
                                        <td data-label="Ticket">' + data[i].folio+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="% IVA">' + data[i].porcentaje_iva + '%</td>\
                                        <td data-label="Total">' + formatearNumeroCSS(data[i].total + '')+ '</td>\
                                        <td data-label="Total a Facturar">' + formatearNumeroCSS(data[i].total + '')+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_tickets tbody').append(html);   
                        }

                    }else{
                        mandarMensaje('No tiene ticket de partidas de la factura.');
                    }

                },
                error: function (xhr) {
                    console.log('php/servicios_buscar_tickets_facturas.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar ticket de partidas de la factura');
                }
            });
        }

        //-->NJES November/04/2020 evita enter en los textarea
        $('textarea').keydown(function (event){
            return noEnter(event);
        });

    });

</script>

</html>
