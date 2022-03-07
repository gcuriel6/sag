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
    #div_radio_iva{
        padding-top:28px;
    }
    .boton_eliminar{
        width:50px;
    }
    #dialog_buscar_facturas > .modal-lg,
    #dialog_sustituir > .modal-lg,
    #dialog_buscar_notas_credito > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
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
        #div_radio_iva{
            padding-top:10px;
        }
        .boton_eliminar{
            width:100%;
        }
        #dialog_buscar_facturas > .modal-lg,
        #dialog_adenda > .modal-lg,
        #dialog_sustituir > .modal-lg,
        #dialog_buscar_notas_credito > .modal-lg,
        #dialog_notas_credito > .modal-lg{
            max-width: 100%;
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
                        <div class="titulo_ban">Facturación</div>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_cont_estatus" style="text-align:center;">
                        <div id="div_estatus"></div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_factura"><i class="fa fa-search" aria-hidden="true"></i> Buscar Factura</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_nota_credito"><i class="fa fa-search" aria-hidden="true"></i> Buscar Nota Crédito</button>
                    </div>
                    <div class="col-sm-12 col-md-2 secundarios botones_factura">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_nota_credito"><i class="fa fa-floppy-o" aria-hidden="true"></i> Nota Crédito</button>
                    </div>
                    <div class="col-sm-12 col-md-2" id="div_b_guardar_prefactura">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_prefactura"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Prefactura</button>
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
                    <?php
                        //boton exclusivo para fundacion caudillos
                        if($_SESSION["id_unidad_actual"]==29){
                            ?>
                                <div class="col-sm-12 col-md-2 secundarios botones_factura">
                                    <button type="button" class="btn btn-info btn-sm form-control" id="b_descargar_pdf2"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar Recibo</button>
                                </div>
                            <?php
                        }
                    ?>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                
                <form id="forma_general" name="forma_general">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="s_id_unidades" class="col-form-label requerido">Unidad de Negocio </label>
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="s_id_sucursales" class="col-form-label requerido">Sucursal </label>
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="s_empresa_fiscal" class="col-md-12 col-form-label requerido">Empresa Fiscal (emisora)</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_empresa_fiscal" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="s_cfdi" class="col-form-label requerido">Uso de CFDI </label>
                                    <select id="s_cfdi" name="s_cfdi" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="i_folio_fiscal" class="col-form-label">Folio Fiscal</label>
                                    <input type="text" id="i_folio_fiscal" name="i_folio_fiscal" class="form-control form-control-sm"  autocomplete="off" readonly>
                                </div>
                            </div>
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
                            <!--<div class="row">
                                <div class="col-md-12">
                                    <label for="s_razon_social" class="col-form-label requerido">Razón Social (receptor) 
                                        <button class="btn btn-secondary btn-sm" type="button" id="b_ver_razon_social" style="display:none;">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </label>
                                    <select id="s_razon_social" name="s_razon_social" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                    <input type="hidden" id="i_email" name="i_email">
                                </div>
                            </div>-->
                            <div class="row">
                                <label for="s_razon_social" class="col-md-12 col-form-label requerido">Razón Social (receptor) </label>
                                <div class="input-group col-md-12">
                                    <select id="s_razon_social" name="s_razon_social" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                                    <input type="hidden" id="i_email" name="i_email">
                                    <div class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="b_ver_razon_social" style="margin:0px;">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--<div class="col-md-10">
                                    <label for="i_rfc" class="col-form-label requerido">RFC</label>
                                    <input type="text" id="i_rfc" name="i_rfc" class="form-control form-control-sm validate[required,minSize[12],maxSize[13]]"  autocomplete="off" readonly>
                                </div>-->

                                <label for="i_rfc" class="col-md-12 col-form-label requerido">RFC</label>
                                <div class="input-group col-md-12">

                                    <input type="text" id="i_rfc" name="i_rfc" class="form-control form-control-sm validate[required,minSize[12],maxSize[13]]"  autocomplete="off" readonly>
                                    <input type="hidden" id="i_purchase" name="i_purchase">
                                    <input type="hidden" id="i_file" name="i_file">
                                    <input type="hidden" id="i_branch" name="i_branch">
                                    <input type="hidden" id="i_transport" name="i_transport">
                                    <div class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="b_adenda" style="margin:0px;">
                                            <i class="fa fa-file-o" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="i_folio_interno" class="col-form-label">Folio Interno</label>
                                            <input type="text" id="i_folio_interno" name="i_folio_interno" class="form-control form-control-sm"  autocomplete="off" readonly>
                                            <input type="hidden" id="i_id" name="i_id">
                                            <input type="hidden" id="i_id_cfdi" name="i_id_cfdi">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="i_fecha" class="col-form-label requerido">Fecha</label>
                                            <input type="text" id="i_fecha" name="i_fecha" class="form-control form-control-sm validate[required] fecha"  autocomplete="off" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="i_dias_credito" class="col-form-label requerido">Días de Credito</label>
                                            <input type="text" id="i_dias_credito" name="i_dias_credito" class="form-control form-control-sm validate[required,custom[integer]]"  autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-3" id="div_relacion_facturas"><br>
                                            <label for="i_relacion_factura" class="col-form-label">Relación Facturas</label>
                                            <button type="button" class="btn btn-info" id="b_ver_relacion_facturas"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            <!--<input type="text" id="i_relacion_factura" name="i_relacion_factura" class="form-control form-control-sm"  autocomplete="off" readonly>-->
                                        </div>
                                        <div class="col-md-7" id="div_radio_iva">
                                            <div class="row">
                                                <label for="i_iva" class="col-md-3 col-form-label requerido">Tasa IVA</label>
                                                <div class="col-sm-12 col-md-3">
                                                    16% <input type="radio" name="radio_iva" id="r_16" value="16" checked> 
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    8% <input type="radio" name="radio_iva" id="r_8" value="8">
                                                </div>
                                                <div class="col-sm-4 col-md-3">
                                                    0% <input type="radio" name="radio_iva" id="r_0" value="0">  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3"> 
                                            <br>
                                            <label for="ch_retencion" class="col-form-label">Retención</label>
                                            <input type="checkbox" id="ch_retencion" name="ch_retencion" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="s_metodo_pago" class="col-form-label requerido">Método de Pago </label>
                                                    <select id="s_metodo_pago" name="s_metodo_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="s_forma_pago" class="col-form-label requerido">Forma de Pago </label>
                                                    <select id="s_forma_pago" name="s_forma_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="i_4_cuenta" class="col-md-12 col-form-label">Últimos 4 digitos de la cuenta</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="i_4_cuenta" name="i_4_cuenta" class="form-control form-control-sm validate[custom[integer],minSize[4],maxSize[4]]"  autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="s_concepto" class="col-md-3 col-form-label"><br>Periodo</label>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <label for="s_mes" class="col-form-label requerido">Mes</label>
                                                            <select id="s_mes" name="s_mes" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label for="i_anio" class="col-form-label requerido">Año</label>
                                                            <input type="text" id="i_anio" name="i_anio" class="form-control form-control-sm validate[required,custom[integer],minSize[4],maxSize[4]]"  autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <label for="i_observaciones" class="col-form-label requerido">Observaciones</label>
                            <input type="text" id="i_observaciones" name="i_observaciones" class="form-control form-control-sm validate[required]"  autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="i_inicio_periodo" class="col-form-label requerido">Inicio de Periodo</label>
                                    <input type="text" id="i_inicio_periodo" name="i_inicio_periodo" class="form-control form-control-sm validate[required] fecha"  autocomplete="off" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="i_fin_periodo" class="col-form-label requerido">Fin de Periodo</label>
                                    <input type="text" id="i_fin_periodo" name="i_fin_periodo" class="form-control form-control-sm validate[required] fecha"  autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
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
                            <div class="row" id="div_tipo_cambio" style="display:none;">
                                <div class="col-md-12">
                                    <label for="i_tipo_cambio" class="col-form-label requerido">Tipo de Cambio</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="i_tipo_cambio" name="i_tipo_cambio" class="form-control form-control-sm validate[required,custom[number],min[15]]" value="15.00"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row verificar_permiso_ocultar" alt="VINCULAR_SALIDA_POR_VENTA" id="div_salida_por_venta" style="display:none;">
                        <div class="col-sm-12 col-md-3">
                            <div class="row">
                                <label for="i_salida_por_venta" class="col-md-12 col-form-label requerido">Salida por venta de almacén</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_salida_por_venta" name="i_salida_por_venta" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_salida_por_venta" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12 col-md-3">
                            <div class="row">
                                <label for="i_salida_por_venta_masivo" class="col-md-12 col-form-label requerido">Salida por venta de almacén Masivo</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_salida_por_venta_masivo" name="i_salida_por_venta_masivo" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_salida_por_venta_masivo" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </form><!--div forma_general-->
                <br>
                <div class="card">
                    <h5 class="card-header">Servicios</h5>
                    <div class="card-body">
                        <form id="forma_partidas" name="forma_partidas">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="s_clave_sat_s" class="col-form-label requerido">Clave SAT del Producto/Servicio </label>
                                    <select id="s_clave_sat_s" name="s_clave_sat_s" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-4">
                                    <label for="s_id_unidades_s" class="col-form-label requerido">Unidad SAT </label>
                                    <select id="s_id_unidades_s" name="s_id_unidades_s" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                
                            </div>
                            <div class="row form-group">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="i_cantidad_s" class="col-form-label requerido">Cantidad</label>
                                            <input type="text" id="i_cantidad_s" name="i_cantidad_s" class="form-control form-control-sm validate[required,custom[number],min[0.01]]"  autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="i_precio_s" class="col-form-label requerido">Precio Unitario</label>
                                            <input type="text" id="i_precio_s" name="i_precio_s" class="form-control form-control-sm validate[required,custom[number],min[0.01]]"  autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="i_importe_s" class="col-form-label requerido">Importe</label>
                                            <input type="text" id="i_importe_s" name="i_importe_s" class="form-control validate[required] form-control-sm"  autocomplete="off" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" id="i_precio_s_pesos" name="i_precio_s_pesos"/>
                                    <input type="hidden" id="i_importe_s_pesos" name="i_importe_s_pesos"/>
                                    <input type="hidden" id="i_iva_s_pesos" name="i_iva_s_pesos"/>
                                    <input type="hidden" id="i_retencion_s_pesos" name="i_retencion_s_pesos"/>
                                </div>
                                <div class="col-md-2"><br>
                                    <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="i_descripcion_s" class="col-md-2 col-form-label requerido">Descripción</label>
                                <div class="col-md-10">
                                    <textarea type="text" id="i_descripcion_s" name="i_descripcion_s" class="form-control form-control-sm validate[required]"  autocomplete="off"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!--div card-->
                <br>

                <div class="row form-group">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Clave SAT del producto</th>
                                    <th scope="col">Unidad SAT</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Precio Unitario</th>
                                    <th scope="col">Iva</th>
                                    <th scope="col">Retención</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col" class="datos_pesos"></th>
                                    <th scope="col" width="5px"></th>
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
                    <div class="col-sm-12 col-md-2">
                        <input type="hidden" id="i_subtotal_original" name="i_subtotal_original"/>
                        <input type="hidden" id="i_iva_total_original" name="i_iva_total_original"/>
                        <input type="hidden" id="i_retencion_original" name="i_retencion_original"/>
                        <input type="hidden" id="i_total_original" name="i_total_original"/>
                    </div>
                    <div class="col-sm-12 col-md-10">
                        <div class="row">
                            <label for="i_subtotal" class="col-sm-12 col-md-1 col-form-label">Subtotal: </label>
                            <div class="col-sm-12 col-md-2">
                                <input type="hidden" id="i_sub_calculado" name="i_sub_calculado" class="form-control form-control-sm "  autocomplete="off" readonly>
                                <input type="text" id="i_subtotal" name="i_subtotal" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                            </div>
                            <label for="i_iva_total" class="col-sm-12 col-md-1 col-form-label">IVA:</label>
                            <div class="col-sm-12 col-md-2">
                                <input type="text" id="i_iva_total" name="i_iva_total" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                            </div>
                            <label for="i_retencion" class="col-sm-12 col-md-1 col-form-label">Retención: </label>
                            <div class="col-sm-12 col-md-2">
                                <input id="i_retencion" type="text" class="form-control form-control-sm validate[custom[number]]"  autocomplete="off" readonly/>
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
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_empresa_fiscal" alt="renglon_empresa_fiscal" id="i_filtro_empresa_fiscal" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
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

<div id="dialog_adenda" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" style="overflow-y: scroll;" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adenda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <!---->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="i_purchase_d" class="col-form-label">Orden de Compra</label>
                            <input type="text" id="i_purchase_d" name="i_purchase_d" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <label for="i_file_d" class="col-form-label">No. Archivo</label>
                            <input type="text" id="i_file_d" name="i_file_d" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <label for="i_branch_d" class="col-form-label">Centro Sucursal</label>
                            <input type="text" id="i_branch_d" name="i_branch_d" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <label for="i_transport_d" class="col-form-label">Referencia Transporte</label>
                            <input type="text" id="i_transport_d" name="i_transport_d" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success btn-sm form-control" id="b_asignar_adenda"><i class="fa fa-floppy-o" aria-hidden="true"></i> Asignar Adenda</button>
                        </div>
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
                                <th scope="col">Razón Social (receptor)</th>
                                <th scope="col">RFC Razón Social</th>
                                <th scope="col">Observaciones</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Estatus</th>
                                <th scope="col">Usuario</th>
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
                    <label for="s_filtro_unidad_NC" class="col-md-2 col-form-label">Unidad de Negocio </label>
                    <div class="col-md-4">
                        <select id="s_filtro_unidad_NC" name="s_filtro_unidad_NC" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                    </div>
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
                <h5 class="modal-title">NOTAS DE CRÉDITO </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forma_notas_credito" name="forma_notas_credito">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="s_metodo_pago_nc" class="col-form-label requerido">Método de Pago </label>
                            <select id="s_metodo_pago_nc" name="s_metodo_pago_nc" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="s_forma_pago_nc" class="col-form-label requerido">Forma de Pago</label>
                            <select id="s_forma_pago_nc" name="s_forma_pago_nc" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="radio_moneda_nc" class="col-form-label requerido">Moneda</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" name="radio_moneda_nc" id="r_MXN_nc" value="MXN" checked> MXN
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" name="radio_moneda_nc" id="r_USD_nc" value="USD"> USD
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row div_tipo_cambio_nc" style="display:none;">
                                <div class="col-md-12">
                                    <label for="i_tipo_cambio_nc" class="col-form-label requerido">Tipo de Cambio</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="i_tipo_cambio_nc" name="i_tipo_cambio_nc" class="form-control form-control-sm validate[required,custom[number],min[15]]" value="15.00"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <label for="i_descripcion_nc" class="col-form-label requerido">Descripción </label>
                            <input type="text" id="i_descripcion_nc" name="i_descripcion_nc" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                        </div> 
                        <div class="col-sm-12 col-md-2" id="div_radio_iva_nc">
                            <div class="row">
                                <label for="i_iva_nc" class="col-md-12 col-form-label requerido" style="text-align:center;">% IVA</label>
                                <div class="col-sm-4 col-md-4">
                                    16% <input type="radio" name="radio_iva_nc" id="r_16_nc" value="16" checked> 
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    8% <input type="radio" name="radio_iva_nc" id="r_8_nc" value="8">
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    0% <input type="radio" name="radio_iva_nc" id="r_0_nc" value="0">  
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2" style="text-align:center;"> 
                            <br>
                            <label for="ch_retencion_nc" class="col-form-label">Retención</label>
                            <input type="checkbox" id="ch_retencion_nc" name="ch_retencion_nc" value="">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="i_importe_nc" class="col-form-label requerido">Importe (Sin IVA)</label>
                            <input type="text" id="i_importe_nc" name="i_importe_nc" class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off"/>
                            <input type="hidden" id="i_importe_nc_pesos" name="i_importe_nc_pesos" class="form-control form-control-sm validate[required,custom[number]]"/>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_iva_nc" class="col-form-label">IVA</label>
                                    <input type="text" id="i_iva_nc" name="i_iva_nc" class="form-control" autocomplete="off" readonly/>
                                    <input type="hidden" id="i_iva_nc_pesos" name="i_iva_nc_pesos" class="form-control"/>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_retencion_nc" class="col-form-label">Retención</label>
                                    <input type="text" id="i_retencion_nc" name="i_retencion_nc" class="form-control" autocomplete="off" readonly/>
                                    <input type="hidden" id="i_retencion_nc_pesos" name="i_retencion_nc_pesos" class="form-control">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_total_nc" class="col-form-label">Total</label>
                                    <input type="text" id="i_total_nc" name="i_total_nc" class="form-control" autocomplete="off" readonly/>
                                    <input type="hidden" id="i_total_nc_pesos" name="i_total_nc_pesos" class="form-control"/>
                                </div>
                            </div>
                            <div class="row div_tipo_cambio_nc_valores" style="display:none;">
                                <div class="col-sm-12 col-md-3">
                                    <label for="l_importe_pesos" class="col-form-label">Importe Pesos</label>
                                    <b><label id="l_importe_pesos" class="col-form-label form-control"></label></b>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="l_iva_pesos" class="col-form-label">IVA Pesos</label>
                                    <b><label id="l_iva_pesos" class="col-form-label form-control"></label></b>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="l_retencion_pesos" class="col-form-label">Retención Pesos</label>
                                    <b><label id="l_retencion_pesos" class="col-form-label form-control"></label></b>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="l_total_pesos" class="col-form-label">Total Pesos</label>
                                    <b><label id="l_total_pesos" class="col-form-label form-control"></label></b>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <br>
                            <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar_nota_credito"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                        </div> 
                        <!--NJES Feb/18/2020 se agrega para mostrar el saldo actual de la factura-->
                        <div class="col-sm-12 col-md-2">
                            <div class="row" id="div_saldo_factura_usd">
                                <label class="col-md-12 col-form-label">Saldo Factura USD</label>
                                <div class="col-md-12">
                                    <b>$ <label id="label_saldo_actual_factura_usd"></label></b>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-12 col-form-label">Saldo Factura MXN</label>
                                <div class="col-md-12">
                                    <b>$ <label id="label_saldo_actual_factura"></label></b>
                                </div>
                            </div>
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
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Iva</th>
                                    <th scope="col">Retención</th>
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

<div id="dialog_razon_social" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos Razón Social: <span id="nombre_razon_social"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_razon_social"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_salida_venta" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de salidas por venta de almacén</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_salida_venta" alt="renglon_salida_venta" id="i_filtro_salida_venta" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_salida_venta">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">No. Movimiento</th>
                                <th scope="col">Unidad de Negocio</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Partidas</th>
                                <th scope="col">Importe</th>
                                <th scope="col">Observaciones</th>
                                <!-- <th scope="col"></th> -->
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
            <!-- <button type="button" id="btnGuardarSalidasMasivas" class="btn btn-primary btn-sm" data-dismiss="modal">Guardar</button> -->
        </div>
        </div>
    </div>
</div>

<!-- <div id="dialog_salida_venta_masivo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de salidas masivas por venta de almacén</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_salida_venta_masivo">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">No. Movimiento</th>
                                <th scope="col">Unidad de Negocio</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Partidas</th>
                                <th scope="col">Importe</th>
                                <th scope="col">Observaciones</th>
                                <th scope="col"></th>
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
            <button type="button" id="btnGuardarSalidasMasivas" class="btn btn-primary btn-sm" data-dismiss="modal">Guardar</button>
        </div>
        </div>
    </div>
</div> -->

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='FACTURACION';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var idFactura = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });

    $(function(){
        var fechaN = new Date();
        var anioN = fechaN.getFullYear();

        $('#i_fecha').val(hoy);

        $.ajax(
        {
            type: "POST",
            url: "php/verificando_ando.php",
            cache: false,
            success: function(res)
            {
                console.log('** ' + res);                
            }
        });

        verificarPermisosShowHide(idUsuario,idUnidadActual);
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        generaFecha('s_mes');
        muestraSelectUsoCFDI('s_cfdi');
        muestraSelectMetodoPago('s_metodo_pago');
        muestraSelectClaveProductoSAT('s_clave_sat_s');
        muestraSelectClaveUnidadesSAT('s_id_unidades_s');

        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        muestraSelectUnidades(matriz,'s_filtro_unidad',idUnidadActual);
        muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);

        //-->NJES July/14/2020 agregar metodo y forma de pago a notas de credito
        muestraSelectMetodoPago('s_metodo_pago_nc');
        muestraSelectFormaPago('TODOS','s_forma_pago_nc');

        $('#b_adenda').prop('disabled', true);

        $('[data-toggle="tooltip"]').tooltip();

        $('[data-toggle="popover"]').popover();       

        $('#s_id_unidades').change(function(){
            var idUnidadNegocio = $('#s_id_unidades').val();
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
            verificarPermisosShowHide(idUsuario,idUnidadNegocio);
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        }); 

        $('#i_fecha').val(hoy);

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);
        
        $('#b_buscar_clientes').click(function()
        {
            $('#b_adenda').prop('disabled', true);
            $('#i_rfc').val('');
            $('#i_filtro_cliente').val('');
            muestraModalClientes('renglon_cliente','t_clientes tbody','dialog_clientes');
        });

        $('#t_clientes').on('click', '.renglon_cliente', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_cliente').attr('alt',id).val(nombre);
            $('#dialog_clientes').modal('hide'); 
            $('#i_email').val('');

            if($('#s_id_unidades').val() != '')
            {
                muestraSelectRazonesSociales(id,$('#s_id_unidades').val(),'s_razon_social');
            }
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
        });

        $('#s_razon_social').change(function()
        {

            var rfc = $('#s_razon_social option:selected').attr('alt2');
            var dias_credito = $('#s_razon_social option:selected').attr('alt');
            var correo = $('#s_razon_social option:selected').attr('alt4');
            var adenda = $('#s_razon_social option:selected').attr('alt7');

            $('#i_dias_credito').val(dias_credito);
            $('#i_rfc').val(rfc);
            $('#i_email').val(correo);

            if(adenda == 1)
                $('#b_adenda').prop('disabled', false);

        });

        $('#b_adenda').click(function()
        {

            //verificando adenda
            $('#i_purchase_d').val($('#i_purchase').val());
            $('#i_file_d').val($('#i_file').val());
            $('#i_branch_d').val($('#i_branch').val());
            $('#i_transport_d').val($('#i_transport').val());

            $('#dialog_adenda').modal('show');

        });

        $('#b_asignar_adenda').click(function()
        {

            //verificando adenda

            var cont = 0;

            if($('#i_purchase_d').val() != '')
                cont++;

            if($('#i_file_d').val() != '')
                cont++;

            if($('#i_branch_d').val() != '')
                cont++;

            if($('#i_transport_d').val() != '')
                cont++;

            if(cont > 1)
            {

                $('#i_purchase').val($('#i_purchase_d').val());
                $('#i_file').val($('#i_file_d').val());
                $('#i_branch').val($('#i_branch_d').val());
                $('#i_transport').val($('#i_transport_d').val());

            }
            else
                mandarMensaje('Agregar por lo menos un dato a la Adenda');


            $('#dialog_adenda').modal('hide');

        });

        $('#b_ver_razon_social').click(function(){
            if($('#s_razon_social').val() != null)
            {
                var idRazonSocial = $('#s_razon_social').val();
                
                $.ajax({
                    type: 'POST',
                    url: 'php/razones_sociales_buscar_id.php',
                    dataType:"json", 
                    data:{
                        'idRazonSocial':idRazonSocial
                    },
                    success: function(data) {
                        if(data.length > 0){
                            if(data[0].num_int != '')
                            {
                                var num_int=' Int.'+data[0].no_interior;
                            }else{
                                var num_int='';
                            }

                            $('#nombre_razon_social').text(data[0].razon_social);

                            var detalles = '<p>Nombre corto: '+data[0].nombre_corto+'</p>';
                                detalles += '<p>RFC: '+data[0].rfc+'</p>';
                                detalles += '<p>Domicilio: '+data[0].domicilio+' '+data[0].no_exterior+' '+num_int+'. '+data[0].colonia+', '+data[0].municipio+', '+data[0].estado+', '+data[0].pais+'</p>';
                                detalles += '<p>Código Postal: '+data[0].codigo_postal+'</p>';
                                detalles += '<p>Telefono: '+data[0].telefono+'</p>';
                                detalles += '<p>Días Credito: '+data[0].dias_cred+'</p>';
                                detalles += '<p>Representante Legal: '+data[0].r_legal+'</p>';
                                detalles += '<p>Contacto: '+data[0].contacto+'</p>';

                            $('#div_datos_razon_social').html(detalles);

                        }

                        $('#dialog_razon_social').modal('show');
                        
                    },
                    error: function (xhr) 
                    {
                        console.log('php/proveedores_buscar_id.php --> '+JSON.stringify(xhr));
                        mandarMensaje('Error al mostrar datos de razón social');
                    }
                });
            }else{
                mandarMensaje('Primero debes selecionar una razón social');
            }
        });

        $('#s_metodo_pago').change(function(){
            var tipo = 'TODOS';//$(this).val();
            muestraSelectFormaPago(tipo,'s_forma_pago');
        });

        $('#s_metodo_pago_nc').change(function(){
            var tipo = 'TODOS';
            muestraSelectFormaPago(tipo,'s_forma_pago_nc');
        });

        $('input[name=radio_iva]').change(function(){
            if($("#r_0").is(':checked'))
                $('#ch_retencion').prop({'checked':false,'disabled':true});
            else
                $('#ch_retencion').prop('disabled',false);

            calculaTotales();
        });

        $('#b_buscar_factura').click(function(){
            $('#forma_general').validationEngine('hide');
            
            $('#dialog_buscar_facturas').modal('show');
            $('#s_filtro_unidad').prop('disabled',false);
            $('#s_filtro_sucursal').prop('disabled',false);

            buscarFacturas(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
        });

        $('#s_filtro_unidad').change(function(){
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);
            $('.img-flag').css({'width':'50px','height':'20px'});

            buscarFacturas($('#s_filtro_unidad').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad').val(),modulo,idUsuario));
        });

        $('#s_filtro_sucursal').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarFacturas($('#s_filtro_unidad').val(),$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarFacturas($('#s_filtro_unidad').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad').val(),modulo,idUsuario));
            }
        });

        $('#i_fecha_inicio').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarFacturas($('#s_filtro_unidad').val(),$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarFacturas($('#s_filtro_unidad').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad').val(),modulo,idUsuario));
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarFacturas($('#s_filtro_unidad').val(),$('#s_filtro_sucursal').val());
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarFacturas($('#s_filtro_unidad').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad').val(),modulo,idUsuario));
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
                'fechaFin' : $('#i_fecha_fin').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data) {
                    if(data.length != 0){                    
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_facturas" alt="'+data[i].id+'" id_unidad_negocio="'+data[i].id_unidad_negocio+'" cliente="'+data[i].id_cliente+'" metodo="'+data[i].metodo_pago+'">\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Empresa Fiscal (emisor)">'+data[i].empresa_fiscal+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Folio Fiscal">'+data[i].folio_fiscal+'</td>\
                                        <td data-label="Razón Social (receptor)">'+data[i].razon_social+'</td>\
                                        <td data-label="RFC Razón Social">'+data[i].rfc_razon_social+'</td>\
                                        <td data-label="Fecha">'+data[i].observaciones+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
                                        <td data-label="Fecha">'+data[i].usuario+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_facturas_buscar tbody').append(html);   
                        }
                    }else{
                        var html='<tr class="renglon_fact">\
                                        <td colspan="7">No se encontró información</td>\
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
            $('#div_estatus').html('');

            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
            muestraSelectRazonesSociales(idCliente,idUnidadNegocio,'s_razon_social');
            muestraSelectFormaPago(metodoPago,'s_forma_pago');

            muestraRegistro(idFactura);
            muestraRegistroDetalle(idFactura);
        });

        function muestraRegistro(idFactura){
            $('#b_agregar').prop('disabled',true);

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_id.php',
                dataType:"json", 
                data : {'idFactura':idFactura},
                success: function(data) {
                    if(data.length >0){                    
                        var dato = data[0];

                        $('#forma_general input,select').prop('disabled',true);
                        $('#b_buscar_clientes,#b_buscar_empresa_fiscal,#b_salida_por_venta').prop('disabled',true);

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

                                    //-->NJES July/10/2020 el primer id estaba comentado y el segundo no, pero el segundo el dato.ret no estaba definido, no existe en el query
                                    if(parseFloat(dato.total)-parseFloat(dato.importe_retencion) == data1[0].saldo)
                                    {
                                        mostrarOcultarBotones(dato.estatus,dato.folio_fiscal,dato.num_notas_credito);
                                        //alert('f');
                                    }
                                    //if(parseFloat(dato.ret) == data1[0].saldo)
                                        
                                    else
                                    {
                                        //alert('in');
                                        mostrarOcultarBotones(dato.estatus,dato.folio_fiscal, dato.num_notas_credito);
                                    }
                                }else
                                    mostrarOcultarBotones(dato.estatus,dato.folio_fiscal,dato.num_notas_credito);
                            },
                            error: function (xhr1) 
                            {
                                console.log('php/facturacion_buscar_saldo_idFactura.php --> '+JSON.stringify(xhr1));
                                //mandarMensaje('* No se encontró información al buscar el saldo de la factura.');
                            }
                        });
                        //mostrarOcultarBotones(dato.estatus,dato.folio_fiscal,dato.num_notas_credito);

                        $('#b_ver_relacion_facturas').attr('alt',idFactura);

                        if(dato.facturas_relacionadas != '')
                        {
                            $('#div_relacion_facturas').css('display','block');
                        }else{
                            $('#div_relacion_facturas').css('display','none');
                        }

                        $('#i_cliente').attr('alt',dato.id_cliente).val(dato.cliente);
                        $('#i_empresa_fiscal').attr('alt', dato.id_empresa_fiscal).val(dato.empresa_fiscal);
                        $('#i_empresa_fiscal').attr('alt2', dato.id_cfdi);
                        $('#i_rfc').val(dato.rfc_razon_social);
                        $('#i_email').val(dato.email);
                        $('#i_fecha').val(dato.fecha);
                        $('#i_dias_credito').val(dato.dias_credito);
                        $('#i_folio_fiscal').val(dato.folio_fiscal);
                        $('#i_folio_interno').val(dato.folio);
                        $('#i_4_cuenta').val(dato.digitos_cuenta);
                        $('#i_anio').val(dato.anio);
                        $('#i_observaciones').val(dato.observaciones);
                        $('#i_subtotal').val(formatearNumero(dato.subtotal));
                        $('#i_iva_total').val(formatearNumero(dato.iva));
                        $('#i_total').val(formatearNumero(parseFloat(dato.total)-parseFloat(dato.importe_retencion)));
                        $('#i_retencion').val(formatearNumero(dato.importe_retencion));
                        if(dato.retencion == 1)
                            $('#ch_retencion').prop('checked',true);
                        else
                            $('#ch_retencion').prop('checked',false);

                        /*
                            $('#i_subtotal').val(formatearNumeroA6Dec(dato.subtotal));
                            $('#i_iva_total').val(formatearNumeroA6Dec(dato.iva));
                            $('#i_total').val(formatearNumeroA6Dec(dato.total));
                        */
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

                        $('#s_id_unidades').val(dato.id_unidad_negocio);
                        $("#s_id_unidades").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                        $('#s_id_sucursales').val(dato.id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                        
                        $('#s_razon_social').val(dato.id_razon_social);
                        $('#s_razon_social').select2({placeholder: $(this).data('elemento')});

                        $('#s_cfdi').val(dato.uso_cfdi);
                        $('#s_cfdi').select2({placeholder: $(this).data('elemento')});

                        $('#s_metodo_pago').val(dato.metodo_pago);
                        $('#s_metodo_pago').select2({placeholder: $(this).data('elemento')});

                        $('#s_forma_pago').val(dato.forma_pago);
                        $('#s_forma_pago').select2({placeholder: $(this).data('elemento')});

                        $('#s_mes').val(dato.mes);
                        $('#s_mes').select2({placeholder: $(this).data('elemento')});

                        //-->NJES Sep/10/2020 mostrar folio salida por venta almacen si esta ligada a la factura
                        $('#i_salida_por_venta').attr('alt',dato.id_almacen_e).val(dato.folio_venta);

                        //-->NJES May/25/2021 agregar moneda y tipo de cambio, 
                        //en guinthercorp se cuarda el quivalente en pesos y en cfdi_denken2 se guarda el monto original
                        $('#i_subtotal_original').val(dato.subtotal_original);
                        $('#i_iva_total_original').val(dato.iva_original);
                        $('#i_total_original').val((parseFloat(dato.subtotal_original)+parseFloat(dato.iva_original))-parseFloat(dato.importe_retencion_original));
                        $('#i_retencion_original').val(dato.importe_retencion_original);

                        if(dato.moneda == 'MXN')
                        {
                            $('#r_MXN').prop('checked',true);
                            $('#div_tipo_cambio').hide();
                        }else{
                            $('#r_USD').prop('checked',true);
                            $('#div_tipo_cambio').show(); 
                            $('#i_tipo_cambio').val(dato.tipo_cambio);
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
                url: 'php/facturacion_buscar_detalle_id.php',
                dataType:"json", 
                data : {'idFactura':idFactura},
                success: function(data) {                   
                    for(var i=0;data.length>i;i++)
                    {

                        var registro='';
                        var precio = parseFloat(data[i].precio_unitario);
                        //var iva = parseFloat(data[i].iva);
                        //var importe = parseFloat(data[i].importe);
                        var cantidad = parseFloat(data[i].cantidad);
                        //var retencion = parseFloat(data[i].retencion);

                        //-->NJES May/19/2021 calcular el importe por partida, iva y retencion; segun el porcentaje iva, cantidad y precio
                        //porque al calcularlo en el query no redondea y los queremos redondeados
                        var importe_u = 0;
                        $.ajax({
                            type: 'POST',
                            async: false,
                            url: 'php/verifica_importes.php',
                            dataType:"json", 
                            data:  {'tipo':1, 'cantidad': parseFloat(cantidad), 'precio': parseFloat(precio)},
                            success: function(data)
                            {
                                importe_u = data;
                            }
                        });
                    
                        var valor = (+(Math.round(importe_u + "e+2")  + "e-2"));

                        var valorIva = parseFloat(data[i].porcentaje_iva);
                        var iva = (valor*parseInt(valorIva))/100;
                        
                        if(data[i].bandera_retencion == 1){
                            if(parseInt(valorIva) == 16)
                                var retencion = (6*(valor))/100;
                            else
                                var retencion = (3*(valor))/100;
                        }else
                            var retencion = 0;

                        var importe = (+(Math.round((((valor)+iva)-retencion) + "e+2")  + "e-2"));

                        registro+= '<tr class="renglon_partida" claveProducto="'+data[i].clave_producto_sat+'" claveUnidad="'+data[i].clave_unidad_sat+'" nombreUnidad="'+data[i].unidad_sat+'" nombreProducto="'+data[i].producto_sat+'"  cantidad="'+data[i].cantidad+'" precio="'+data[i].precio_unitario+'" importe="'+parseFloat(data[i].precio_unitario)*parseFloat(data[i].cantidad)+'" descripcion="'+data[i].descripcion+'">';
                            registro+= '<td>'+data[i].clave_producto_sat+' - '+data[i].producto_sat+'</td>';
                            registro+= '<td>'+data[i].clave_unidad_sat+' - '+data[i].unidad_sat+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(cantidad.toFixed(6) + '')+'</td>';
                            registro+= '<td>'+data[i].descripcion+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(precio.toFixed(4) + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(iva.toFixed(2) + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(retencion.toFixed(2) + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(importe.toFixed(6) + '')+'</td>';
                            registro+= '<td class="datos_pesos"></td>';
                            registro+= '<td class="boton_eliminar"></td>';
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

        function mostrarOcultarBotones(tipo,folioFiscal,numNC){
            $('#div_b_guardar_prefactura,#div_b_sustituir').css('display','none');
            $('#div_cont_estatus').css('display','block');
            
            if(tipo == 'T') //->Timbrada
            {
                $('.botones_factura').css('display','block');
                $('.botones_prefactura').css('display','block');
                $('.divs_alt').css('display','none');
                $('#div_b_timbrar').css('display','none');
                $('#div_b_verificar_estatus').css('display','none');
                $('#div_b_solicitud_cancelacion').css('display','none');
                $('#div_b_descargar_acuse').css('display','none');

                if(parseInt(numNC) > 0)
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
                $('#div_b_solicitud_cancelacion').css('display','none');
                $('.botones_factura').css('display','none');
            }else if(tipo == 'P') //-> Pendiente
            {
                $('#div_b_timbrar').css('display','none');
                $('.botones_prefactura').css('display','none');
                $('.botones_factura').css('display','none');
                $('.divs_alt').css('display','none');
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

        }

        $('#b_guardar_prefactura').click(function()
        {

            $('#b_guardar_prefactura').prop('disabled',true);
            if ($('#forma_general').validationEngine('validate'))
            {

                if(verificaAdenda() == true)
                {

                    if($('#t_facturas .renglon_partida').length > 0)
                        guardar('prefactura');
                    else
                    {
                        mandarMensaje('Debe existir por lo menos un producto/servicio para guardar');
                        $('#b_guardar_prefactura').prop('disabled',false);
                    }

                }
                else
                {
                    mandarMensaje('Debe existir por lo menos un detalle para la adenda.');
                    $('#b_guardar_prefactura').prop('disabled',false);
                }

            }
            else
                $('#b_guardar_prefactura').prop('disabled',false);
            
        });

        function verificaAdenda(){

            var verifica = false;

            var vAdenda = $('#s_razon_social option:selected').attr('alt7');

            if(parseInt(vAdenda) == 1)
            {

                var cont = 0;

                if($('#i_purchase').val() != '')
                    cont++;

                if($('#i_file').val() != '')
                    cont++;

                if($('#i_branch').val() != '')
                    cont++;

                if($('#i_transport').val() != '')
                    cont++;

                if(cont > 1)
                    verifica = true;

            }
            else
                verifica = true;
            



            return verifica;

        }

        function guardar(tipo){
            
            var idUnidadNegocio = $('#s_id_unidades').val();
            var idCliente = $('#i_cliente').attr('alt');
            var idMetodoPago = $('#s_metodo_pago').val();

            //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
            var ivaR = $('input[name=radio_iva]:checked').val();

            if(parseInt(ivaR) == 16)
                var porcentajeR = 6;
            else
                var porcentajeR = 3;

            var info={
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscalEmisor' : $('#i_empresa_fiscal').attr('alt'),
                'idCFDIEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt2'),
                'idRazonSocialReceptor' : $('#s_razon_social').val(),
                'razonSocialReceptor' : $('#s_razon_social option:selected').attr('alt6'),//$('#s_razon_social option:selected').text(),
                'codigoPostal' : $('#s_razon_social option:selected').attr('alt3'),
                'rfc' : $('#i_rfc').val(),
                'idUsoCFDI' : $('#s_cfdi').val(),
                'idMetodoPago' : $('#s_metodo_pago').val(),
                'idFormaPago' : $('#s_forma_pago').val(),
                'fecha' : $('#i_fecha').val(),
                'diasCredito' : $('#i_dias_credito').val(),
                'tasaIva' : $('input[name=radio_iva]:checked').val(),
                'digitosCuenta' : $('#i_4_cuenta').val(),
                'mes' : $('#s_mes').val(),
                'anio' : $('#i_anio').val(),
                'observaciones' : $('#i_observaciones').val(),
                'partidas' : obtienePartidas(),
                'subtotal' : quitaComa($('#i_subtotal').val()),
                'iva' : quitaComa($('#i_iva_total').val()),
                'total' : parseFloat(quitaComa($('#i_total').val()))+parseFloat(quitaComa($('#i_retencion').val())),
                'fechaInicioPeriodo' : $('#i_inicio_periodo').val(),
                'fechaFinPeriodo' : $('#i_fin_periodo').val(),
                'usuario' : usuario,
                'facturasSustituir' : obtieneFacturasSustituir(),
                'retencion' : $("#ch_retencion").is(':checked') ? 1 : 0,
                'importeRetencion' : quitaComa($('#i_retencion').val()),
                'porcentajeRetencion' : porcentajeR,
                'tipo' : tipo,
                'id_salida_venta' : $('#i_salida_por_venta').attr('alt'),
                'adenda': parseInt($('#s_razon_social option:selected').attr('alt7')),
                'adenda_file': $('#i_file').val(),
                'adenda_purchase': $('#i_purchase').val(),
                'adenda_transport': $('#i_transport').val(),
                'adenda_branch': $('#i_branch').val(),
                //-->NJES May/25/2021 agregar moneda y tipo de cambio, 
                //en guinthercorp se cuarda el quivalente en pesos y en cfdi_denken2 se guarda el monto original
                'subtotal_original' : $('#i_subtotal_original').val(),
                'iva_original' : $('#i_iva_total_original').val(),
                'total_original' : parseFloat($('#i_total_original').val())+parseFloat($('#i_retencion_original').val()),
                'importe_retencion_original' : $('#i_retencion_original').val(),
                'moneda' : $('input[name=radio_moneda]:checked').val(),
                'tipo_cambio' : quitaComa($('#i_tipo_cambio').val())
            };

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_guardar.php',
                data:  {'datos':info},
                success: function(data) 
                {

                    //console.log(data);
                    //$('#b_guardar_prefactura').prop('disabled',false);
                    if(data > 0 )
                    { 
                        limpiarGuardar();
                        idFactura = data;

                        if(obtieneFacturasSustituir().length > 0)
                        {
                            $('#dialog_sustituir').modal('hide');
                        }

                        mandarMensaje('Se guardo correctamente');
                        muestraRegistro(data);
                        muestraRegistroDetalle(data);
                    }else{ 

                        if(obtieneFacturasSustituir().length > 0)
                        {
                            $('#dialog_sustituir').modal('hide');
                        }

                        mandarMensaje('Error al guardar.');
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

        function obtienePartidas(){
            var j = 0;
            var arreglo = [];

            $("#t_facturas .renglon_partida").each(function() {
                var idClaveSATProducto = $(this).attr('claveProducto');
                var idClaveSATUnidad = $(this).attr('claveUnidad');
                var nombreUnidadSAT = $(this).attr('nombreUnidad');
                var nombreProductoSAT = $(this).attr('nombreProducto');
                var cantidad = $(this).attr('cantidad');
                var precio = $(this).attr('precio');
                var importe = parseFloat($(this).attr('cantidad'))*parseFloat($(this).attr('precio'));
                var descripcion = $(this).attr('descripcion');

                //-->NJES May/25/2021 el la cantidad original capturada, ya sea en pesos o dolares
                //el atributo cantidad viene el equivalente en pesos
                //en ginthercorp se guardara el importe y precio equivalente en pesos
                //en denken_cfdi2 se guarda el precio capturado
                var precio_original = $(this).attr('precio_original');
                
                arreglo[j] = {
                    'idClaveSATProducto' : idClaveSATProducto,
                    'idClaveSATUnidad' : idClaveSATUnidad,
                    'nombreUnidadSAT' : nombreUnidadSAT,
                    'nombreProductoSAT' : nombreProductoSAT,
                    'cantidad' : cantidad,
                    'precio' : precio,
                    'importe' : importe,
                    'descripcion' : descripcion,
                    'precio_original' : precio_original
                };  

                j++;
            });

            return arreglo;
        }

        $('#i_precio_s, #i_cantidad_s').change(function(){

            if($(this).validationEngine('validate')==false) {
                calculaImporteP();
            }else{
                $('#i_importe_s').val('');
                $(this).val('');
            }

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

        //-->NJES May/25/2021 calcula los importes de la forma detalle para el equivalente en pesos y original
        function calculaImporteP(){
            var precio=quitaComa($('#i_precio_s').val());
            var cantidad=quitaComa($('#i_cantidad_s').val());

            var tipoCambio = 1;
            if($("#r_USD").is(':checked'))
                var tipoCambio = quitaComa($('#i_tipo_cambio').val());

            if(precio==''){
                precio=0;
            }

            if(precio > 0 && cantidad > 0)
            {
                //obtiene el importe equivalente a pesos
                var importePesos = calculaImportesEnPHP(2,cantidad,precio,tipoCambio);

                //obtiene el quivalente unitario a pesos
                var importeUPesos = calculaImportesEnPHP(3,0,precio,tipoCambio);

                //obtiene el importe original
                var importe = calculaImportesEnPHP(1,cantidad,precio,1);
            
                var valor = (+(Math.round(importe + "e+2")  + "e-2"));

                var valorPesos = (+(Math.round(importePesos + "e+2")  + "e-2"));
                var precioUPesos = (+(Math.round(importeUPesos + "e+2")  + "e-2"));

                var valorIva = $('input[name=radio_iva]:checked').val();
                var iva = (valor*parseInt(valorIva))/100;

                var ivaPesos = (valorPesos*parseInt(valorIva))/100;
                
                //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                if($("#ch_retencion").is(':checked')){
                    if(parseInt(valorIva) == 16)
                    {
                        var retencionP = (6*(valor))/100;
                        var retencionPPesos = (6*(ivaPesos))/100;
                    }else{
                        var retencionP = (3*(valor))/100;
                        var retencionPPesos = (6*(ivaPesos))/100;
                    }
                }else{
                    var retencionP = 0;
                    var retencionPPesos = 0;
                }

                var t = (+(Math.round((((valor)+iva)-retencionP) + "e+2")  + "e-2"));
                $('#i_importe_s').val(formatearNumeroA6Dec(t));

                //almacen tambien el importe en pesos porque son los que se van a mostrar en las partidas y en la forma, 
                //pero en los pdf y xml se mostrara los importes originales y la moneda y tipo cambio
                var tPesos = (+(Math.round((((valorPesos)+ivaPesos)-retencionPPesos) + "e+2")  + "e-2"));
                $('#i_importe_s_pesos').val(formatearNumeroA6Dec(tPesos));
                $('#i_precio_s_pesos').val(precioUPesos);
                $('#i_iva_s_pesos').val(ivaPesos);
                $('#i_retencion_s_pesos').val(retencionPPesos);

            }else{
                $('#i_importe_s').val('');
                $('#i_importe_s_pesos').val('');
                $('#i_precio_s_pesos').val('');
                $('#i_iva_s_pesos').val('');
                $('#i_retencion_s_pesos').val('');
            }
        }

        $('#b_timbrar').click(function()
        {

            $('#b_timbrar').prop('disabled', true);

            var id = $('#i_id').val();
            var idCFDI = $('#i_id_cfdi').val();
            var idEmpresa = $('#i_empresa_fiscal').attr('alt2');        
        
            $('#fondo_cargando').show();
            $.ajax({
                type: 'GET',
                url: '../cfdi_corporativo/php/ws_gf_retencion.php', 
                data : {'empresa':idEmpresa, 'registro': idCFDI},
                success: function(data)
                {
                    console.log(data);
                    if(data == 'OK')
                    {

                        if(parseInt(actualizarDatosCFDI(id, idCFDI)) == parseInt(id))
                        {
                            limpiarGuardar();
                            idFactura = id;
                            muestraRegistro(id);
                            muestraRegistroDetalle(id);
                            mandarMensaje('La factura se timbro correctamente');
                            
                        }else{
                            mandarMensaje('La factura se timbro pero no me actualizó los datos xml');  ///vacio
                        }
                    }
                    else
                        mandarMensaje('Error al generar timbre' + data);

                    $('#b_timbrar').prop('disabled', false);
                    $('#fondo_cargando').hide();   
                    
                },
                error: function (xhr)
                {
                    console.log(' error sistema: '+JSON.stringify(xhr));
                    //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al generar timbre .');
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
                                limpiarGuardar();
                                idFactura = id;
                                muestraRegistro(id);
                                muestraRegistroDetalle(id);
                                mandarMensaje('La factura se mando a cancelar de manera correcta, verificar la respuesta del receptor.');
                                
                            }else
                            mandarMensaje('No se puedo enviar la petición de cancelar la factura');  //vacio
                            
                        }

                        $('#fondo_cargando').hide();   
                    },
                    error: function (xhr) {
                        //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* Error al enviar petición para cancelar factura');
                    }
                });
            }else{
                if(parseInt(actualizarEstatusFactura(id,'C')) == parseInt(id))
                {
                    limpiarGuardar();
                    idFactura = id;
                    muestraRegistro(id);
                    muestraRegistroDetalle(id);
                    mandarMensaje('La pre factura se mando a cancelar de manera correcta, verificar la respuesta del receptor.');
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
            console.log('CFDI ' + idCFDI);
            console.log('E ' + idEmpresa);
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
                                console.log('*'+data+'*');
                                if(data > 0)
                                {
                                    limpiarGuardar();
                                    muestraRegistro(data);
                                    muestraRegistroDetalle(data);
                                    mandarMensaje('Se aprobó la cancelación.');
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
                        mandarMensaje('La factura no ha sido aprobada por el cliente favor de intentarlo mas tarde');
                    else{
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
                    console.log('veifica_status.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al verificar estatus factura');
                    $('#fondo_cargando').hide(); 
                }
            });
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
                var descripcion = $('#i_descripcion_s').val();
                var valorIva = $('input[name=radio_iva]:checked').val();
                var iva = ((parseFloat(quitaComa($('#i_cantidad_s').val()))*parseFloat(quitaComa($('#i_precio_s').val())))*parseInt(valorIva))/100;
                
                //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                if($("#ch_retencion").is(':checked'))
                {
                    if(parseInt(valorIva) == 16)
                        var retencion = (6*precio)/100;
                    else
                        var retencion = (3*precio)/100;
                }else
                    var retencion = 0;

                var importePesos = parseFloat($('#i_importe_s_pesos').val());
                var precioPesos = parseFloat($('#i_precio_s_pesos').val());
                var ivaPesos = parseFloat($('#i_iva_s_pesos').val());
                var retencionPesos = parseFloat($('#i_retencion_s_pesos').val());

                var botonImportesOriginales='<button type="button" class="btn btn-info btn-sm" data-trigger="focus" data-toggle="popover" data-placement="top" title="Importes Originales Capturados" data-container="body" data-content="Precio: '+formatearNumero(precio) +' Iva: '+formatearNumero(iva)+' Retención: '+formatearNumero(retencion)+' Importe: '+formatearNumero(importe)+'">\
                                                        <i class="fa fa-eye" aria-hidden="true"></i>\
                                                    </button>';
            
                var registro='';
                registro+= '<tr class="renglon_partida editar" claveProducto="'+claveProducto+'" producto="'+producto+'" claveUnidad="'+claveUnidad+'" nombreUnidad="'+nombreUnidad+'" nombreProducto="'+nombreProducto+'" cantidad="'+cantidad+'" precio="'+precioPesos+'" importe="'+importePesos+'" descripcion="'+descripcion+'" precio_original="'+precio+'" importe_original="'+importe+'">';
                registro+= '<td>'+producto+'</td>';
                registro+= '<td>'+unidad+'</td>';
                registro+= '<td style="text-align:right;">'+formatearNumeroCSS(cantidad.toFixed(6) + '')+'</td>';
                registro+= '<td>'+descripcion+'</td>';
                registro+= '<td style="text-align:right;">'+formatearNumeroCSS(precioPesos.toFixed(4) + '')+'</td>';
                registro+= '<td style="text-align:right;">'+formatearNumeroCSS(ivaPesos.toFixed(2) + '')+'</td>';
                registro+= '<td style="text-align:right;">'+formatearNumeroCSS(retencionPesos.toFixed(2) + '')+'</td>';
                registro+= '<td style="text-align:right;">'+formatearNumeroCSS(importePesos.toFixed(6) + '')+'</td>';
                registro+= '<td class="datos_pesos">'+botonImportesOriginales+'</td>';
                registro+= '<td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>';
                registro+= '</tr>';
                $('#t_facturas tbody').append(registro);

                $('[data-toggle="popover"]').popover();

                limpiaFormaPartidas();
                calculaTotales();
            }else{
                $('#b_agregar').prop('disabled',false);
            }
        });

        $(document).on('click','#b_eliminar',function(){
            $(this).parent().parent().remove();
            calculaTotales();
        });

        $('#t_facturas').on('dblclick', '.editar', function() {
            if($('#s_clave_sat_s').val() == null)
            {
                var renglon=$(this);
                var cantidad = renglon.attr('cantidad');
                //var precio = renglon.attr('precio');
                //var importe = renglon.attr('importe');
                var precio = renglon.attr('precio_original');
                var importe = renglon.attr('importe_original');
                
                $('#s_clave_sat_s').val(renglon.attr('claveProducto'));
                $('#s_clave_sat_s').select2({placeholder: $(this).data('elemento')});
                $('#s_id_unidades_s').val(renglon.attr('claveUnidad'));
                $('#s_id_unidades_s').select2({placeholder: $(this).data('elemento')}); 
                
                $('#i_cantidad_s').val(formatearNumeroA6Dec(cantidad));
                $('#i_precio_s').val(formatearNumeroA4Dec(precio));
                $('#i_importe_s').val(formatearNumeroA6Dec(importe));
                $('#i_descripcion_s').val(renglon.attr('descripcion'));

                $(this).remove();
                calculaTotales();
            }else{
                mandarMensaje('Debes agregar primero el producto/servicio actual');
            }
        });

        function limpiaFormaPartidas(){
            $('#b_agregar').prop('disabled',false);
            $('#forma_partidas input,textarea').val('');
            muestraSelectClaveProductoSAT('s_clave_sat_s');
            muestraSelectClaveUnidadesSAT('s_id_unidades_s');
        }

        function limpiarGuardar(){
            $('#forma_general input').not('[type=radio]').val('');
            $('#i_subtotal, #i_iva_total, #i_total').val('');
            $('#t_facturas tbody').html('');
            $('#div_estatus').html('');
            $('#b_adenda').prop('disabled', true);
            $('#r_MXN').prop('checked',true);
            $('#div_tipo_cambio').hide();
            $('#i_tipo_cambio').val('15.00');
        }

        function limpiar(){
            $('#forma_general input').not('[type=radio]').val('');
            $('#b_guardar_prefactura').prop('disabled',false);
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            verificarPermisosShowHide(idUsuario,idUnidadActual);
            generaFecha('s_mes');
            muestraSelectUsoCFDI('s_cfdi');
            muestraSelectMetodoPago('s_metodo_pago');
            $('#s_razon_social').html('').val('');
            $('#s_forma_pago').html('').val('');
            $('#i_subtotal, #i_iva_total, #i_total, #i_retencion').val('');
            $('#i_fecha').val(hoy);
            $('#t_facturas tbody').html('');
            $('#div_estatus').html('');
            $('#div_b_verificar_estatus').css('display','none');
            $('#div_b_descargar_acuse').css('display','none'); 
            idFactura = 0;
            $('#forma_general input,select').prop('disabled',false);
            $('#b_buscar_clientes,#b_buscar_empresa_fiscal,#b_salida_por_venta').prop('disabled',false);
            $('#i_anio').val(anioN);
            $('#ch_retencion').prop('checked',false);
            $('form').validationEngine('hide');
            $('#b_adenda').prop('disabled', true);
            $('#r_MXN').prop('checked',true);
            $('#div_tipo_cambio').hide();
            $('#i_tipo_cambio').val('15.00');
        }

        $('#b_nuevo').click(function(){
            limpiar();
            limpiaFormaPartidas();
            $('#div_b_guardar_prefactura,#div_b_sustituir').css('display','block');
            $('.secundarios,#div_cont_estatus').css('display','none');
            $('#div_relacion_facturas').css('display','none');
            $('#div_b_solicitud_cancelacion').css('display','none');
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
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt'),
                'idRazonSocial' : $('#s_razon_social').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_canceladas.php',
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

        //-->NJES May/25/2021 agregar moneda y tipo de cambio, 
        //en guinthercorp se cuarda el quivalente en pesos y en cfdi_denken2 se guarda el monto original
        function calculaTotales()
        {

            var subtotal = 0;
            var iva = 0;
            var total = 0;
            var retencion = 0;

            var subtotalOriginal = 0;
            var ivaOriginal = 0;
            var totalOriginal = 0;
            var retencionOriginal = 0;

            var tipoCambio = 1;
            if($("#r_USD").is(':checked'))
                var tipoCambio = parseFloat(quitaComa($('#i_tipo_cambio').val()));

            $('.renglon_partida').each(function()
            {
                //-->este obtiene el subtotal original
                var valorOriginal = calculaImportesEnPHP(1,$(this).attr('cantidad'),$(this).attr('precio_original'),1); 

                valorOriginal = (+(Math.round(valorOriginal + "e+2")  + "e-2"));
                subtotalOriginal=subtotalOriginal+(parseFloat(valorOriginal)*1000);

                //obtiene el calculo del precio original capturado por el monto tipo de cambio
                var valorUP = calculaImportesEnPHP(3,1,$(this).attr('precio_original'),tipoCambio); 

                //-->NJES Feb/26/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
                //redondear cada valor y tomar solo dos decimales ya que el calculo al formar el xml asi lo hace
                valorUP = (+(Math.round(valorUP + "e+2")  + "e-2"));
                $(this).attr('precio',valorUP);
                $(this).find('td').eq(4).text('').append(formatearNumeroCSS(valorUP.toFixed(4) + ''));
               
                //calcula el importe total de la cantidad*precio*tipo cambio para obtener el equivalente a pesos
                var valor = calculaImportesEnPHP(2,$(this).attr('cantidad'),$(this).attr('precio_original'),tipoCambio); 
                valor = (+(Math.round(valor + "e+2")  + "e-2"));

                subtotal=subtotal+(parseFloat(valor)*1000);
                
                //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
                var ivaPi = $('input[name=radio_iva]:checked').val();
                var ivaP=(valor*parseInt(ivaPi))/100;
                ivaP = (+(Math.round(ivaP + "e+2")  + "e-2"));
                var datoIvaP =  formatearNumeroCSS(ivaP.toFixed(2) + '');
                $(this).find('td').eq(5).text('').append(datoIvaP);

                //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                if($("#ch_retencion").is(':checked'))
                {
                    if(parseInt($('input[name=radio_iva]:checked').val()) == 16)
                        var retencionP = (6*valor)/100;
                    else
                        var retencionP = (3*valor)/100;
                }else
                    var retencionP = 0;

                $(this).find('td').eq(6).text('').append(formatearNumeroCSS(retencionP.toFixed(2)));

                var importe = (+(Math.round((valor + parseFloat(ivaP) - parseFloat(retencionP))+ "e+2")  + "e-2"));
                $(this).attr('importe',importe);
                var importeP =  formatearNumeroCSS(importe.toFixed(6) + '');
                $(this).find('td').eq(7).text('').append(importeP);

                var precioX = parseFloat($(this).attr('precio_original'));
                var ivaX = (valorOriginal*parseInt(ivaPi))/100;
                //ivaX = (+(Math.round(ivaX + "e+2")  + "e-2"));
                
                if($("#ch_retencion").is(':checked'))
                {
                    if(parseInt($('input[name=radio_iva]:checked').val()) == 16)
                        var retencionX = (6*valorOriginal)/100;
                    else
                        var retencionX = (3*valorOriginal)/100;
                }else
                    var retencionX = 0;

                var importeX = (valorOriginal+parseFloat(ivaX))-retencionX;

                var botonImportesOriginales='<button type="button" class="btn btn-info btn-sm" data-trigger="focus" data-toggle="popover" data-placement="top" title="Importes Originales Capturados" data-container="body" data-content="Precio: '+formatearNumero(precioX) +' Iva: '+formatearNumero(ivaX)+' Retención: '+formatearNumero(retencionX)+' Importe: '+formatearNumero(importeX)+'">\
                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                </button>';
                $(this).find('td').eq(8).html('').append(botonImportesOriginales);

                $('[data-toggle="popover"]').popover();
            });

            var valorIva = $('input[name=radio_iva]:checked').val();

            //-->NJES Feb/26/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
            iva=((parseFloat(subtotal)/1000)*parseInt(valorIva))/100;

            ivaOriginal=((parseFloat(subtotalOriginal)/1000)*parseInt(valorIva))/100;
            
            //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
            if($("#ch_retencion").is(':checked'))
            {
                //-->NJES Feb/26/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
                //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                if(parseInt(valorIva) == 16)
                {
                    retencion = (6*(parseFloat(subtotal)/1000))/100;
                    retencionOriginal = (6*(parseFloat(subtotalOriginal)/1000))/100;
                }else{
                    retencion = (3*(parseFloat(subtotal)/1000))/100;
                    retencionOriginal = (3*(parseFloat(subtotalOriginal)/1000))/100;
                } 
            }
                           
            //-->NJES Feb/26/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
            total=(parseFloat(subtotal)/1000)+iva-parseFloat(retencion);

            totalOriginal=(parseFloat(subtotalOriginal)/1000)+ivaOriginal-parseFloat(retencionOriginal);

            var sS =  parseFloat(subtotal)/1000;
            sS =  (+(Math.round(sS + "e+2")  + "e-2"));
            var sIVA =  (+(Math.round(iva + "e+2")  + "e-2"));
            var sT =  (+(Math.round(total + "e+2")  + "e-2"));
            var sR =  (+(Math.round(retencion + "e+2")  + "e-2"));

            $('#i_subtotal').val(formatearNumero(sS));  
            $('#i_iva_total').val(formatearNumero(sIVA));
            $('#i_total').val(formatearNumero(sT)); 
            $('#i_retencion').val(formatearNumero(sR));

            //almacena los montos originales para guardarlos en cfdi_denken2
            $('#i_subtotal_original').val((+(Math.round((parseFloat(subtotalOriginal)/1000) + "e+2")  + "e-2")));  
            $('#i_iva_total_original').val((+(Math.round(ivaOriginal + "e+2")  + "e-2")));
            $('#i_total_original').val((+(Math.round(totalOriginal + "e+2")  + "e-2"))); 
            $('#i_retencion_original').val((+(Math.round(retencionOriginal + "e+2")  + "e-2")));

        }

        $(document).ready(function(){

            $('#i_cantidad_s').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 6);
            });

            $('#i_importe_nc').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });

            $('#i_precio_s').keypress(function (event)
            {
                //-->NJES May/14/2021 permitir 4 decimales
                return validateDecimalKeyPressN(this, event, 4);
            });

            $('#i_tipo_cambio').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });

            $('#i_anio').keypress(function (event){
                return valideKeySoloNumeros(event);
            });

            $('#i_4_cuenta').keypress(function (event){
                return valideKeySoloNumeros(event);
            });
        });


        $('#i_tipo_cambio').change(function (){
            if($('#i_tipo_cambio').val() == '')
            {
                $('#i_tipo_cambio').val('15.00');
                calculaImporteP();
                calculaTotales();
            }else{
                calculaImporteP();
                calculaTotales();
            }
            
        });

        $('#b_descargar_prefactura').click(function(){
            var datos = {
                'path':'formato_factura',
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
                'path':'formato_acuse_factura',
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
                'path':'formato_solicitud_cancelacion',
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
                'path':'formato_factura',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Factura',
                'tipo':1,
                'tipoAr':'factura'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        });

        $('#b_descargar_pdf2').click(function(){
            var datos = {
                'path':'formato_factura2',
                'idRegistro':$('#i_id').val(),
                'nombreArchivo':'Recibo Deducible',
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

        function generaPdf(id,folio,nombreArchivo,tipo,tipoAr){
            var ruta = '../facturacion/archivos/'+tipoAr+'_'+folio+'_'+id;

            var datos = {
                'path':'formato_factura',
                'idRegistro':id,
                'folioFactura':folio,
                'nombreArchivo':nombreArchivo,
                'vp':tipo,
                'tipoAr':tipoAr,
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

        function generaXml(idFactura,folioFactura,ruta,nombreArchivo,tipoAr){
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

        function mandaCorreo(idFactura,folioFactura,ruta,tipo){
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

            //-->NJES Jun/08/2021 si la moneda de la factura es en dolares, la nota de credito puede ser en dolares o pesos
            //pero si la factura fue en pesos, las notas de credito solo pueden ser en pesos
            if($("#r_MXN").is(':checked'))
            {
                $('#r_MXN_nc').prop('checked',true);
                $('input[name=radio_moneda_nc]').prop('disabled',true);
                $('.div_tipo_cambio_nc').hide();
                $('.div_tipo_cambio_nc_valores').hide();
                $('#div_saldo_factura_usd').hide();
            }else{
                $('input[name=radio_moneda_nc]').prop('disabled',false);
                $('#div_saldo_factura_usd').show();

                if($('#r_MXN_nc').is(':checked'))
                    $('.div_tipo_cambio_nc').show();
            }
        });

        $('#b_agregar_nota_credito').click(function(){
            $('#b_agregar_nota_credito').prop('disabled',true);

            if ($('#forma_notas_credito').validationEngine('validate'))
            {   
                //-->NJES Feb/18/2020 se compara que el importe del abono de la nota no revase el saldo actual de la factura
                if(parseFloat(quitaComa($('#i_total_nc_pesos').val())) <= parseFloat(quitaComa($('#label_saldo_actual_factura').text())))
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

            //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
            var ivaR = $('input[name=radio_iva_nc]:checked').val();

            if(parseInt(ivaR) == 16)
                var porcentajeR = 6;
            else
                var porcentajeR = 3;

            var info={
                'descripcion' : $('#i_descripcion_nc').val(),
                'tasaIva' : $('input[name=radio_iva_nc]:checked').val(),
                'importe' : parseFloat(quitaComa($('#i_importe_nc').val())),
                'idFactura' : idFactura,
                'folioFactura' : folioFactura,
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscalEmisor' : $('#i_empresa_fiscal').attr('alt'),
                'idCFDIEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt2'),
                'idRazonSocialReceptor' : $('#s_razon_social').val(),
                'razonSocialReceptor' : $('#s_razon_social option:selected').attr('alt6'),
                'codigoPostal' : $('#s_razon_social option:selected').attr('alt3'),
                'rfc' : $('#i_rfc').val(),
                'idUsoCFDI' : $('#s_cfdi').val(),
                //-->NJES July/14/2020 se puede seleccionar el metodo y forma pago (anteriormente estaba como metodo: PUE y forma: 01)
                'idMetodoPago' : $('#s_metodo_pago_nc').val(),
                'idFormaPago' : $('#s_forma_pago_nc').val(),
                'fecha' : $('#i_fecha').val(),
                'diasCredito' : $('#i_dias_credito').val(),
                'digitosCuenta' : $('#i_4_cuenta').val(),
                'mes' : $('#s_mes').val(),
                'anio' : $('#i_anio').val(),
                'observaciones' : $('#i_observaciones').val(),
                'fechaInicioPeriodo' : $('#i_inicio_periodo').val(),
                'fechaFinPeriodo' : $('#i_fin_periodo').val(),
                'usuario' : usuario,
                //-->NJES Feb/14/2020 se agrega retencion a las notas de credito
                'retencion' : $("#ch_retencion_nc").is(':checked') ? 1 : 0,
                'importeRetencion' : quitaComa($('#i_retencion_nc').val()),
                'porcentajeRetencion' : porcentajeR,
                'iva' : quitaComa($('#i_iva_nc').val()),
                'total' : quitaComa($('#i_total_nc').val()),
                //-->NJES Jun/08/2021 agregar moneda y tipo de cambio, 
                //en guinthercorp se cuarda el quivalente en pesos y en cfdi_denken2 se guarda el monto original
                'importe_pesos' : quitaComa($('#i_importe_nc_pesos').val()),
                'importe_retencion_pesos' : quitaComa($('#i_retencion_nc_pesos').val()),
                'iva_pesos' : quitaComa($('#i_iva_nc_pesos').val()),
                'total_pesos' : quitaComa($('#i_total_nc_pesos').val()),
                'moneda' : $('input[name=radio_moneda_nc]:checked').val(),
                'tipo_cambio' : quitaComa($('#i_tipo_cambio_nc').val()),
                'moneda_factura' : $('input[name=radio_moneda]:checked').val()
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
                        $('#i_retencion_nc').val('');
                        $('#i_total_nc').val('');
                        $('#ch_retencion_nc').prop('checked',false);

                        $('#r_MXN_nc').prop('checked',true);
                        if($('#r_USD').is(':checked'))
                            $('.div_tipo_cambio_nc').show();
                        else
                            $('.div_tipo_cambio_nc').hide();
                        $('.div_tipo_cambio_nc_valores').hide();
                        $('#i_tipo_cambio_nc').val('15.00');
                        $('#i_importe_nc_pesos').val('');
                        $('#i_retencion_nc_pesos').val('');
                        $('#i_iva_nc_pesos').val('');
                        $('#i_total_nc_pesos').val('');

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
                    console.log('../cfdi_corporativo/php/ws_gf_retencion.php --> '+JSON.stringify(xhr));
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

            $('.renglon_nota_credito').remove();

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
                            var descargarAcuse='<button type="button" alt="'+data[i].id+'" alt2="'+data[i].id_factura_cfdi+'" class="btn btn-info btn-sm b_acuse_NC" data-toggle="tooltip" data-placement="top" title="Descargar Acuse de Cancelación Nota de Crédito"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>';
                            var correoNotaCredito='<button type="button" alt="'+data[i].id+'" alt2="'+data[i].id_factura_cfdi+'" alt3="'+data[i].folio_nota_credito+'" class="btn btn-success btn-sm b_enviar_correo_NC" data-toggle="tooltip" data-placement="top" title="Enviar correo con Nota de Crédito"><i class="fa fa-envelope" aria-hidden="true"></i></button>';

                            if(data[i].moneda == 'USD')
                            {
                                var precio = data[i].subtotal_original;
                                var iva = data[i].iva_original;
                                var retencion = data[i].importe_retencion_original;
                                var importe = (parseFloat(data[i].subtotal_original)+parseFloat(data[i].iva_original))-parseFloat(data[i].importe_retencion_original);
                                importe = (+(Math.round(importe + "e+2")  + "e-2"));
                                var tipoCambio = data[i].tipo_cambio;

                                var botonImportesUSD='<button type="button" class="btn btn-info btn-sm" data-trigger="focus" data-toggle="popover" data-placement="top" title="Importes Originales Capturados" data-container="body" data-content="Precio: '+formatearNumero(precio) +' Tipo Cambio: '+formatearNumero(tipoCambio)+' Iva: '+formatearNumero(iva)+' Retención: '+formatearNumero(retencion)+' Importe: '+formatearNumero(importe)+'">\
                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                </button>';
                            }else{
                                var botonImportesUSD='';
                            }

                            var botones = '';
                            switch(data[i].estatus) {
                                case 'T':
                                    botones = botonImportesUSD+' '+cancelar+'  '+pdfNotaCredito+'  '+xmlNotaCredito+'  '+correoNotaCredito;
                                    break;
                                case 'C':
                                    botones = botonImportesUSD+' '+descargarAcuse;
                                    break;
                                case 'P':
                                    botones = botonImportesUSD+' '+verificarEstatus;
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
                                        <td data-label="Subtotal">$'+formatearNumeroCSS(data[i].subtotal)+'</td>\
                                        <td data-label="Iva">$'+formatearNumeroCSS(data[i].iva)+'</td>\
                                        <td data-label="Retención">$'+formatearNumeroCSS(data[i].importe_retencion)+'</td>\
                                        <td data-label="Total">$'+formatearNumeroCSS(data[i].total)+'</td>\
                                        <td>'+botones+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
                                        /tr>';
                            ///agrega la tabla creada al div 
                            $('#t_notas_credito tbody').append(html);                             
                        }

                        $('[data-toggle="tooltip"]').tooltip();
                        $('[data-toggle="popover"]').popover(); 

                    }else{
                        var html='<tr class="renglon_nota_credito_b">\
                                        <td colspan="10">No se encontró información</td>\
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
            $('#label_saldo_actual_factura_usd').text('');

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_saldo_idFactura.php',
                dataType:"json", 
                data:  {'idFactura':idFactura},
                success: function(data) {
                    $('#label_saldo_actual_factura').text(formatearNumero(data[0].saldo));

                    if($("#r_USD").is(':checked'))
                    {
                        //var saldoPesos = parseFloat(quitaComa($('#label_saldo_actual_factura').text()));
                        //var saldoUSD = saldoPesos/parseFloat(quitaComa($('#i_tipo_cambio').val()));
                        $('#label_saldo_actual_factura_usd').text(formatearNumero(data[0].saldo_usd));
                    }
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

            console.log(idEmpresa + ' ** ' + idCFDI);

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
                'path':'formato_factura',
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
            mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad_NC').val(),modulo,idUsuario));
            $('#dialog_buscar_notas_credito').modal('show');
            
            $('#s_filtro_unidad_NC').prop('disabled',false);
            $('#s_filtro_sucursal_NC').prop('disabled',false);
        });

        function mostrarNotasCreditoTodas(idUnidadNegocio,idSucursal){
            $('#t_buscar_notas_credito tbody').html(''); 

            $('#i_filtro_facturas').val('');
            $('.renglon_nota_credito_b').remove();

            var info = {
                'idUnidadNegocio' : idUnidadNegocio,
                'idSucursal': idSucursal,
                'fechaInicio' : $('#i_fecha_inicio_NC').val(),
                'fechaFin' : $('#i_fecha_fin_NC').val()
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
            muestraSelectRazonesSociales(idCliente,idUnidadNegocio,'s_razon_social');
            muestraSelectFormaPago(metodoPago,'s_forma_pago');

            muestraRegistro(idFactura);
            muestraRegistroDetalle(idFactura);
            $('#dialog_buscar_notas_credito').modal('hide');
        });

        fechaHoyServidor('i_fecha_inicio_NC','primerDiaMes');
        fechaHoyServidor('i_fecha_fin_NC','ultimoDiaMes');
        muestraSelectUnidades(matriz,'s_filtro_unidad_NC',idUnidadActual);
        muestraSucursalesPermiso('s_filtro_sucursal_NC',idUnidadActual,modulo,idUsuario);

        $('#i_fecha_inicio_NC').val(primerDiaMes);
        $('#i_fecha_fin_NC').val(ultimoDiaMes);

        $('#s_filtro_unidad_NC').change(function(){
            muestraSucursalesPermiso('s_filtro_sucursal_NC',$('#s_filtro_unidad_NC').val(),modulo,idUsuario);
            $('.img-flag').css({'width':'50px','height':'20px'});
            mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad_NC').val(),modulo,idUsuario));
        });

        $('#s_filtro_sucursal_NC').change(function(){
            if($('#s_filtro_sucursal_NC').val() >= 1)
            {
                mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),$('#s_filtro_sucursal_NC').val());
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0" selected>Mostrar Todas</option>');
                mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad_NC').val(),modulo,idUsuario));
            }
        });

        $('#i_fecha_inicio_NC').change(function(){
            if($('#s_filtro_sucursal_NC').val() >= 1)
            {
                mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),$('#s_filtro_sucursal_NC').val());
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0" selected>Mostrar Todas</option>');
                mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad_NC').val(),modulo,idUsuario));
            }
        });

        $('#i_fecha_fin_NC').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),$('#s_filtro_sucursal_NC').val());
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0" selected>Mostrar Todas</option>');
                mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),muestraSucursalesPermisoListaId($('#s_filtro_unidad_NC').val(),modulo,idUsuario));
            }
        });

        //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
        $('#ch_retencion').change(function(){
            calculaTotales();
            //calcularRetencionPartidas();
        });



        //--> NJES Feb/14/2020 agregar campo retención a notas de credito
        $('#ch_retencion_nc').change(function(){
            calculaTotalesNC();
        });

        $('input[name=radio_iva_nc]').change(function(){
            if($("#r_0_nc").is(':checked'))
                $('#ch_retencion_nc').prop({'checked':false,'disabled':true});
            else
                $('#ch_retencion_nc').prop('disabled',false);

            calculaTotalesNC();
        });

        function calculaTotalesNC(){
            var precio=quitaComa($('#i_importe_nc').val());

            if(precio==''){
                precio=0;
            }

            //-->NJES Jun/08/2021 calcular equivalente a pesos cuando la moneda es dolares
            var tipoCambio = 1;
            if($("#r_USD_nc").is(':checked'))
                var tipoCambio = quitaComa($('#i_tipo_cambio_nc').val());

            if(precio > 0)
            {
                var valorIva = $('input[name=radio_iva_nc]:checked').val();
                var iva = (parseFloat(precio)*parseInt(valorIva))/100;
                iva = (+(Math.round(iva + "e+2")  + "e-2"));

                //obtiene el importe quivalente a pesos
                var importePesos = calculaImportesEnPHP(3,0,precio,tipoCambio);
                importePesos = (+(Math.round(importePesos + "e+2")  + "e-2"));

                var ivaPesos = (parseFloat(importePesos)*parseInt(valorIva))/100;
                ivaPesos = (+(Math.round(ivaPesos + "e+2")  + "e-2"));

                //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                if($("#ch_retencion_nc").is(':checked'))
                {
                    if(parseInt(valorIva) == 16)
                    {
                        var retencionP = (6*parseFloat(precio))/100;
                        var retencionPesos = (6*parseFloat(importePesos))/100;
                    }else{
                        var retencionP = (3*parseFloat(precio))/100;
                        var retencionPesos = (3*parseFloat(importePesos))/100;
                    }
                }else{
                    var retencionP = 0;
                    var retencionPesos = 0;
                }

                var total = (parseFloat(precio)+iva)-retencionP;
                total = (+(Math.round(total + "e+2")  + "e-2"));
                $('#i_iva_nc').val(formatearNumero(iva));
                $('#i_retencion_nc').val(formatearNumero(+(Math.round(retencionP + "e+2")  + "e-2")));
                $('#i_total_nc').val(formatearNumero(total));

                var totalPesos = (parseFloat(importePesos)+ivaPesos)-retencionPesos;
                totalPesos = (+(Math.round(totalPesos + "e+2")  + "e-2"));

                $('#i_importe_nc_pesos').val(importePesos);
                $('#i_iva_nc_pesos').val(ivaPesos);
                $('#i_retencion_nc_pesos').val(+(Math.round(retencionPesos + "e+2")  + "e-2"));
                $('#i_total_nc_pesos').val(totalPesos);

                $('#l_importe_pesos').text('$ '+formatearNumero(importePesos));
                $('#l_iva_pesos').text('$ '+formatearNumero(ivaPesos));
                $('#l_retencion_pesos').text('$ '+formatearNumero(+(Math.round(retencionPesos + "e+2")  + "e-2")));
                $('#l_total_pesos').text('$ '+formatearNumero(totalPesos));

            }else{
                $('#i_importe_nc').val('');
                $('#i_iva_nc').val('');
                $('#i_retencion_nc').val('');
                $('#i_total_nc').val('');

                $('#i_importe_nc_pesos').val('');
                $('#i_retencion_nc_pesos').val('');
                $('#i_iva_nc_pesos').val('');
                $('#i_total_nc_pesos').val('');

                $('#l_importe_pesos').text('');
                $('#l_iva_pesos').text('');
                $('#l_retencion_pesos').text('');
                $('#l_total_pesos').text('');
            }
        }

        $('#i_importe_nc').change(function(){
            if($(this).validationEngine('validate')==false) {
                calculaTotalesNC();
            }else{
                $('#i_importe_nc').val('');
                $('#i_iva_nc').val('');
                $('#i_retencion_nc').val('');
                $('#i_total_nc').val('');

                $('#i_importe_nc_pesos').val('');
                $('#i_retencion_nc_pesos').val('');
                $('#i_iva_nc_pesos').val('');
                $('#i_total_nc_pesos').val('');

                $('#l_importe_pesos').text('');
                $('#l_iva_pesos').text('');
                $('#l_retencion_pesos').text('');
                $('#l_total_pesos').text('');
            }
        });

        //-->Agregar salida por venta a factura
        $('#b_salida_por_venta').click(function(){
            if($('#s_id_unidades').val() != null && $('#s_id_sucursales').val() != null)
            {
                $('#i_filtro_salida_venta').val('');
                muestraModalSalidasVentasAlmacen('renglon_salida_venta','t_salida_venta tbody','dialog_salida_venta');
            }else
                mandarMensaje('Es necesario seleccionar Unidad de Negocio y Sucursal para comenzar la busqueda.');
        });

        // $('#b_salida_por_venta_masivo').click(function(){
        //     if($('#s_id_unidades').val() != null && $('#s_id_sucursales').val() != null)
        //     {
        //         $('#i_filtro_salida_venta_masivo').val('');
        //         muestraModalSalidasVentasAlmacenMasivo('renglon_salida_venta_masivo','t_salida_venta_masivo tbody','dialog_salida_venta_masivo');
        //     }else
        //         mandarMensaje('Es necesario seleccionar Unidad de Negocio y Sucursal para comenzar la busqueda.');
        // });

        $('#t_salida_venta').on('click', '.renglon_salida_venta', function() {
            var id = $(this).attr('alt');
            var folio_venta = $(this).attr('folio_venta');
            $('#i_salida_por_venta').attr('alt',id).val(folio_venta);
            $('#i_salida_por_venta').trigger("change");
            $('#dialog_salida_venta').modal('hide');
        });

        $("#i_salida_por_venta").on("change",function(){
            let folio = $(this).val();
            let sucursal = $('#s_id_sucursales').val();
            traerPartidas(folio, sucursal);
        });

        $("#btnGuardarSalidasMasivas").on("click",()=>{
            let rows = $("#t_salida_venta").find(".checkMasivo:checked").parents(".renglon_salida_venta");

            let cadenaAlt ="";
            let cadenaFolio = "";
            $.each(rows, function(index, value){
                // console.log(value);
                let id = $(value).attr('alt');
                let folio_venta = $(value).attr('folio_venta');

                cadenaAlt += id+",";
                cadenaFolio += folio_venta+",";
                // console.log(id, folio_venta);
            });

            cadenaAlt = cadenaAlt.slice(0, -1);
            cadenaFolio = cadenaFolio.slice(0, -1);

            console.log(cadenaAlt, cadenaFolio);
            $('#i_salida_por_venta').attr('alt',cadenaAlt).val(cadenaFolio);
            $('#i_salida_por_venta').trigger("change");
        });

        function muestraModalSalidasVentasAlmacen(renglon,tabla,modal){
            $('#'+tabla).empty(); 

            var datos = {
                'idUnidadNegocio': $('#s_id_unidades').val(),
                'idSucursal':$('#s_id_sucursales').val(),
                'tipoSalida':'S07'
            }; 

            $.ajax({
                type: 'POST',
                url: 'php/almacen_salidas_busca_ventas_libres.php',
                dataType:"json", 
                data:{
                    'datos': datos
                },
                success: function(data) {
                
                if(data.length != 0){

                        $('.'+renglon).remove();
                
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="'+renglon+'" alt="'+data[i].id+'" folio_venta="'+data[i].folio_venta+'">\
                                        <td data-label="No. Movimiento">' + data[i].folio_venta+ '</td>\
                                        <td data-label="Unidad de Negocio">' + data[i].unidad+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="Partidas">' + data[i].partidas+ '</td>\
                                        <td data-label="Importe Total">' + formatearNumero(data[i].importe_total)+ '</td>\
                                        <td data-label="Observaciones">' + data[i].observacion+ '</td>\
                                    </tr>';
                            $('#'+tabla).append(html);   

                            /*
                                <td><div class="form-check"><input class="form-check-input checkMasivo" type="checkbox"></div>\</td>\

                            */
                        }
                }else{
                    var html='<tr><td colspan="6">No se encontró información</td></tr>';
                    $('#'+tabla).append(html); 
                }

                $('#'+modal).modal('show'); 

                },
                error: function (xhr) {
                    console.log('almacen_salidas_busca_ventas_libres.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Ventas Almacén');
                }
            });
        }

        function muestraModalSalidasVentasAlmacenMasivo(renglon,tabla,modal){
            $('#'+tabla).empty(); 

            var datos = {
                'idUnidadNegocio': $('#s_id_unidades').val(),
                'idSucursal':$('#s_id_sucursales').val(),
                'tipoSalida':'S07'
            }; 

            $.ajax({
                type: 'POST',
                url: 'php/almacen_salidas_busca_ventas_libres.php',
                dataType:"json", 
                data:{
                    'datos': datos
                },
                success: function(data) {
                
                if(data.length != 0){

                        $('.'+renglon).remove();
                
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="'+renglon+'" alt="'+data[i].id+'" folio_venta="'+data[i].folio_venta+'">\
                                        <td data-label="No. Movimiento">' + data[i].folio_venta+ '</td>\
                                        <td data-label="Unidad de Negocio">' + data[i].unidad+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="Partidas">' + data[i].partidas+ '</td>\
                                        <td data-label="Importe Total">' + formatearNumero(data[i].importe_total)+ '</td>\
                                        <td data-label="Observaciones">' + data[i].observacion+ '</td>\
                                        <td><div class="form-check"><input class="form-check-input checkMasivo" type="checkbox"></div>\</td>\
                                    </tr>';
                            $('#'+tabla).append(html);   
                        }
                }else{
                    var html='<tr><td colspan="7">No se encontró información</td></tr>';
                    $('#'+tabla).append(html); 
                }

                $('#'+modal).modal('show'); 

                },
                error: function (xhr) {
                    console.log('almacen_salidas_busca_ventas_libres.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Ventas Almacén');
                }
            });
        }

        //-->NJES May/25/2021 agregar moneda y tipo de cambio
        $('input[name=radio_moneda]').change(function(){
            $('#t_facturas tbody').empty();
            limpiaFormaPartidas();
            $('#i_subtotal,#i_iva_total,#i_retencion,#i_total').val('');
            $('#i_subtotal_original,#i_iva_total_original,#i_retencion_original,#i_total_original').val('');

            if($("#r_MXN").is(':checked'))
            {
                $('#div_tipo_cambio').hide();
            }else{
                $('#div_tipo_cambio').show();
            }
            
        });

        //-->NJES Jun/08/2021 agregar moneda y tipo de cambio en notas de credito
        $('input[name=radio_moneda_nc]').change(function(){
            if($("#r_MXN_nc").is(':checked'))
            {
                if($('#r_USD').is(':checked'))
                    $('.div_tipo_cambio_nc,.div_tipo_cambio_nc_valores').show();
                else
                    $('.div_tipo_cambio_nc,.div_tipo_cambio_nc_valores').hide();
            }else{
                $('.div_tipo_cambio_nc,.div_tipo_cambio_nc_valores').show();
            }

            calculaTotalesNC();
            
        });

        function traerPartidas(folio, sucursal){
            var datos = {
                'idFolioVenta': folio,
                'idSucursal':sucursal,
                'tipoSalida':'S07'
            }; 

            $.ajax({
                type: 'POST',
                url: 'php/almacen_partidas_salida_venta.php',
                dataType:"json", 
                data:{
                    'datos': datos
                },
                success: function(data) {
                
                if(data.length != 0){

                        $('#t_facturas tbody').html("");
                
                        for(var i=0;data.length>i;i++){

                            var claveProducto = ""; 
                            var producto = "";
                            var claveUnidad = ""; 
                            var unidad = "";
                            var nombreUnidad = "";
                            var nombreProducto = "";
                            var cantidad = parseFloat(quitaComa(data[i].cantidad));
                            var precio = parseFloat(quitaComa(data[i].costo));

                            var tipoCambio = 1;
                            if($("#r_USD").is(':checked'))
                                var tipoCambio = quitaComa($('#i_tipo_cambio').val());

                            
                            //obtiene el importe equivalente a pesos
                            var importePesos = calculaImportesEnPHP(2,cantidad,precio,tipoCambio);

                            //obtiene el quivalente unitario a pesos
                            var importeUPesos = calculaImportesEnPHP(3,0,precio,tipoCambio);

                            //obtiene el importe original
                            var importe = calculaImportesEnPHP(1,cantidad,precio,1);
                        
                            var valor = (+(Math.round(importe + "e+2")  + "e-2"));

                            var valorPesos = (+(Math.round(importePesos + "e+2")  + "e-2"));
                            var precioUPesos = (+(Math.round(importeUPesos + "e+2")  + "e-2"));

                            var valorIva = data[i].iva;
                            var iva = (valor*parseInt(valorIva))/100;

                            var ivaPesos = (valorPesos*parseInt(valorIva))/100;
                            
                            //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                            if($("#ch_retencion").is(':checked')){
                                if(parseInt(valorIva) == 16)
                                {
                                    var retencionP = (6*(valor))/100;
                                    var retencionPPesos = (6*(ivaPesos))/100;
                                }else{
                                    var retencionP = (3*(valor))/100;
                                    var retencionPPesos = (6*(ivaPesos))/100;
                                }
                            }else{
                                var retencionP = 0;
                                var retencionPPesos = 0;
                            }

                            var t = (+(Math.round((((valor)+iva)-retencionP) + "e+2")  + "e-2"));                            

                            // var importe = parseFloat(quitaComa($('#i_importe_s').val()));
                            importe = formatearNumeroA6Dec(t);

                            var tPesos = (+(Math.round((((valorPesos)+ivaPesos)-retencionPPesos) + "e+2")  + "e-2"));
                            $('#i_importe_s_pesos').val(formatearNumeroA6Dec(tPesos));
                            $('#i_precio_s_pesos').val(precioUPesos);
                            $('#i_iva_s_pesos').val(ivaPesos);
                            $('#i_retencion_s_pesos').val(retencionPPesos);

                            var descripcion = data[i].concepto;
                            var valorIva = data[i].iva;
                            var iva = ((parseFloat(quitaComa(cantidad))*parseFloat(quitaComa(precio)))*parseInt(valorIva))/100;
                            
                            //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                            if($("#ch_retencion").is(':checked'))
                            {
                                if(parseInt(valorIva) == 16)
                                    var retencion = (6*precio)/100;
                                else
                                    var retencion = (3*precio)/100;
                            }else
                                var retencion = 0;

                            var importePesos = parseFloat($('#i_importe_s_pesos').val());
                            var precioPesos = parseFloat($('#i_precio_s_pesos').val());
                            var ivaPesos = parseFloat($('#i_iva_s_pesos').val());
                            var retencionPesos = parseFloat($('#i_retencion_s_pesos').val());

                            var botonImportesOriginales='<button type="button" class="btn btn-info btn-sm" data-trigger="focus" data-toggle="popover" data-placement="top" title="Importes Originales Capturados" data-container="body" data-content="Precio: '+formatearNumero(precio) +' Iva: '+formatearNumero(iva)+' Retención: '+formatearNumero(retencion)+' Importe: '+formatearNumero(importe)+'">\
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                                </button>';
                        
                            var registro='';
                            registro+= '<tr class="renglon_partida editar" claveProducto="'+claveProducto+'" producto="'+producto+'" claveUnidad="'+claveUnidad+'" nombreUnidad="'+nombreUnidad+'" nombreProducto="'+nombreProducto+'" cantidad="'+cantidad+'" precio="'+precioPesos+'" importe="'+importePesos+'" descripcion="'+descripcion+'" precio_original="'+precio+'" importe_original="'+importe+'">';
                            registro+= '<td>'+producto+'</td>';
                            registro+= '<td>'+unidad+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(cantidad.toFixed(6) + '')+'</td>';
                            registro+= '<td>'+descripcion+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(precioPesos.toFixed(4) + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(ivaPesos.toFixed(2) + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(retencionPesos.toFixed(2) + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(importePesos.toFixed(6) + '')+'</td>';
                            registro+= '<td class="datos_pesos">'+botonImportesOriginales+'</td>';
                            registro+= '<td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>';
                            registro+= '</tr>';
                            $('#t_facturas tbody').append(registro);

                            $('[data-toggle="popover"]').popover();
                        }
                }else{
                    var html='<tr><td colspan="6">No se encontró información</td></tr>';
                    $('#'+tabla).append(html); 
                }

                // $('#'+modal).modal('show'); 

                },
                error: function (xhr) {
                    console.log('almacen_salidas_busca_ventas_libres.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Ventas Almacén');
                }
            });
        }
    });

</script>

</html>
