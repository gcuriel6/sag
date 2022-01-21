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
    #dialog_buscar_notas_credito > .modal-lg,
    #dialog_notas_credito > .modal-lg{
        min-width: 80%;
        max-width: 80%;
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
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                
                <form id="forma_general" name="forma_general">

                    <div class="row">

                        <div class="col-md-2">
                            <label for="i_folio_interno" class="col-form-label">Folio Interno</label>
                            <input type="text" id="i_folio_interno" name="i_folio_interno" class="form-control form-control-sm"  autocomplete="off" readonly>
                            <input type="hidden" id="i_id" name="i_id">
                            <input type="hidden" id="i_id_cfdi" name="i_id_cfdi">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="i_folio_fiscal" class="col-form-label">Folio Fiscal</label>
                            <input type="text" id="i_folio_fiscal" name="i_folio_fiscal" class="form-control form-control-sm"  autocomplete="off" readonly>
                        </div>

                        <div class="col-md-4" id="div_radio_iva">
                            <div class="row">
                                <label for="i_iva" class="col-md-5 col-form-label requerido">Tasa IVA</label>
                                <div class="col-sm-12 col-md-4">
                                    16% <input type="radio" name="radio_iva" id="r_16" value="16" checked> 
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <label for="s_razon_social" class="col-md-12 col-form-label requerido">Razón Social (receptor) </label>
                            <div class="input-group col-sm-12 col-md-12">
                                <select id="s_razon_social" name="s_razon_social" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                                <input type="hidden" id="i_email" name="i_email">
                                <div class="input-group-btn">
                                    <button class="btn btn-info" type="button" id="b_ver_razon_social" style="margin:0px;">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">

                            <div class="col-md-12">
                                <label for="i_rfc" class="col-form-label requerido">RFC</label>
                                <input type="text" id="i_rfc" name="i_rfc" class="form-control form-control-sm validate[required,minSize[12],maxSize[13]]"  autocomplete="off" readonly>
                            </div>

                        </div>                        

                    </div>

                    <div class="row">
                            
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

                    <div class="row">

                        <div class="col-md-2">
                            <label for="i_fecha" class="col-form-label requerido">Fecha</label>
                            <input type="text" id="i_fecha" name="i_fecha" class="form-control form-control-sm validate[required] fecha"  autocomplete="off" readonly>
                        </div>

                        <div class="col-md-4">
                            <div class="row">
                                <label for="i_4_cuenta" class="col-md-12 col-form-label">Últimos 4 digitos de la cuenta</label>
                                <div class="col-md-6">
                                    <input type="text" id="i_4_cuenta" name="i_4_cuenta" class="form-control form-control-sm validate[custom[integer],minSize[4],maxSize[4]]"  autocomplete="off">
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-6">
                            <label for="i_observaciones" class="col-form-label ">Observaciones</label>
                            <input type="text" id="i_observaciones" name="i_observaciones" class="form-control form-control-sm "  autocomplete="off">
                        </div>

                    </div>

                </form><!--div forma_general-->
                <br>

                <div class="card">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon"  id="t_pedidos">
                              <thead>
                                <tr>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Razon Social</th>
                                    <th scope="col">N-Corto</th>
                                    <th scope="col">RFC</th>
                                    <th scope="col" id="th_importe">Subtotal</th>
                                    <th scope="col" id="th_iva">IVA</th>
                                    <th scope="col" id="th_importe">Total</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>  
                        </div>
                    </div>
                </div>

               <!-- <div class="card">
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
                                <div class="col-md-2"></div>
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
                </div>-->
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
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-10">
                        <div class="row">
                            <label for="i_subtotal" class="col-sm-12 col-md-1 col-form-label">Subtotal: </label>
                            <div class="col-sm-12 col-md-2">
                                <input type="text" id="i_subtotal" name="i_subtotal" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
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
                        <div class="col-sm-12 col-md-5">
                            <label for="i_descripcion_nc" class="col-form-label requerido">Descripción </label>
                            <input type="text" id="i_descripcion_nc" name="i_descripcion_nc" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                        </div> 
                        <div class="col-sm-12 col-md-2" id="div_radio_iva_nc">
                            <div class="row">
                                <label for="i_iva_nc" class="col-md-12 col-form-label requerido" style="text-align:center;">% IVA</label>
                                <div class="col-sm-4 col-md-6">
                                    16% <input type="radio" name="radio_iva_nc" id="r_16_nc" value="16" checked> 
                                </div>
                                <div class="col-sm-4 col-md-6">
                                    8% <input type="radio" name="radio_iva_nc" id="r_8_nc" value="8">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="i_importe_nc" class="col-form-label requerido">Importe (Sin IVA)</label>
                            <input type="text" id="i_importe_nc" name="i_importe_nc" class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off"/>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_iva_nc" class="col-form-label">IVA</label>
                                    <input type="text" id="i_iva_nc" name="i_iva_nc" class="form-control" autocomplete="off" readonly/>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_total_nc" class="col-form-label">Total</label>
                                    <input type="text" id="i_total_nc" name="i_total_nc" class="form-control" autocomplete="off" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <br>
                            <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar_nota_credito"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                        </div> 
                        <!--NJES Feb/18/2020 se agrega para mostrar el saldo actual de la factura-->
                        <div class="col-sm-12 col-md-2">
                            <div class="row">
                                <label class="col-md-12 col-form-label">Saldo Factura</label>
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo = 'FACTURACION_VISION';
    var idUnidadActual = 3;// php echo $_SESSION['id_unidad_actual']
    var idSucursalVision = 24;
    var idUsuario = <?php echo $_SESSION['id_usuario']?>;
    var usuario = '<?php echo $_SESSION['usuario']?>';
    var idFactura = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        var fechaN = new Date();
        var anioN = fechaN.getFullYear();
        $('#i_anio').val(anioN);

        mostrarBotonAyuda(modulo);
        generaFecha('s_mes');
        muestraSelectUsoCFDI('s_cfdi');
        muestraSelectMetodoPago('s_metodo_pago');
        muestraSelectClaveProductoSAT('s_clave_sat_s');
        muestraSelectClaveUnidadesSAT('s_id_unidades_s');

        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');

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
        
        $('#b_buscar_clientes').click(function(){
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
                muestraSelectRazonesSociales(id, idUnidadActual,'s_razon_social');
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

            $('#i_rfc').val(rfc);
            $('#i_email').val(correo);

            buscarPedidos(('#s_razon_social').val()); // 

        });

        function buscaPedidos()
  {

      //
      $('.renglon_pedidos_busqueda').remove();

      $.ajax(
      {
        type: 'POST',
        url: 'php/pedidos_buscar_razon_social.php',
        data: {},
        dataType:"json", 
        success: function(data)
        {

            if(data.length != 0)
            {  

                for(var i = 0; data.length > i; i++)
                {

                    var html = '<tr class="renglon_pedidos_busqueda" alt="' + data[i].id + '"    >';
                    html += '<td data-label="Tipo">' + (data[i].tipo == 0 ? 'PEDIDO' : 'COTIZACIÓN') + '</td>';
                    html += '<td data-label="Folio">' + data[i].folio + '</td>';
                    html += '<td data-label="Fecha">' + data[i].fecha + '</td>';
                    html += '<td data-label="Cliente">' + data[i].cliente + '</td>';
                    html += '<td data-label="Razon Social">' + data[i].razon_social + '</td>';
                    html += '<td data-label="N-Corto">' + data[i].nombre_corto + '</td>';
                    html += '<td data-label="RFC">' + data[i].rfc + '</td>';                    
                    html += '<td data-label="Subtotal">' + formatearNumeroCSS(data[i].subtotal) + '</td>';
                    html += '<td data-label="IVA">' + formatearNumeroCSS(data[i].iva) + '</td>';
                     html += '<td data-label="Total">' + formatearNumeroCSS(data[i].total) + '</td>';
                    html += '<td data-label="Estatus">' + labelEstatus(data[i].estatus) + '</td>';
                    html += '<td data-label="">' + '' + '</td>';                    
                    html += '</tr>';

                    $('#t_pedidos tbody').append(html);                

                }

            }
            else
            {

              var html = '<tr class="renglon_fact"><td colspan="7">No se encontró información</td></tr>';
              $('#t_pedidos tbody').append(html);

            }


        },
        error: function (xhr)
        {
            mandarMensaje('* No se encontró información al buscar proDFSDFSDFSDFSDductos.');
        }

      });

  }   

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

        $('input[name=radio_iva]').change(function(){
            calculaTotales();
        });

        $('#b_buscar_factura').click(function(){
            $('#forma_general').validationEngine('hide');
            
            $('#dialog_buscar_facturas').modal('show');
            $('#s_filtro_unidad').prop('disabled',false);
            $('#s_filtro_sucursal').prop('disabled',false);

            // aqui ojote
            buscarFacturas(idUnidadActual, idSucursalVision);
        });

      


        $('#i_fecha_inicio').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarFacturas(idUnidadActual, idSucursalVision);
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                //
                buscarFacturas(idUnidadActual, idSucursalVision);
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_filtro_sucursal').val() >= 1)
            {
                buscarFacturas(idUnidadActual, idSucursalVision);
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal').find('option[value="0"]').remove();
                $('#s_filtro_sucursal').append('<option value="0" selected>Mostrar Todas</option>');
                buscarFacturas(idUnidadActual, idSucursalVision);
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
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
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
            muestraSelectRazonesSociales(idCliente,idUnidadActual,'s_razon_social');
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
                        $('#b_buscar_clientes,#b_buscar_empresa_fiscal').prop('disabled',true);

                        $('#div_estatus').append(labelEstatus(dato.estatus));

                        mostrarOcultarBotones(dato.estatus,dato.folio_fiscal,dato.num_notas_credito);

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
                        $('#i_total').val(formatearNumero(parseFloat(dato.total)));

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
                        
                        $('#dialog_buscar_facturas').modal('hide');
                    }else{
                        mandarMensaje('No se encontro Información de la factura');
                    }
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
                        var iva = parseFloat(data[i].iva);
                        var importe = parseFloat(data[i].importe);
                        var cantidad = parseFloat(data[i].cantidad);

                        registro+= '<tr class="renglon_partida" claveProducto="'+data[i].clave_producto_sat+'" claveUnidad="'+data[i].clave_unidad_sat+'" nombreUnidad="'+data[i].unidad_sat+'" nombreProducto="'+data[i].producto_sat+'"  cantidad="'+data[i].cantidad+'" precio="'+data[i].precio_unitario+'" importe="'+parseFloat(data[i].precio_unitario)*parseFloat(data[i].cantidad)+'" descripcion="'+data[i].descripcion+'">';
                            registro+= '<td>'+data[i].clave_producto_sat+' - '+data[i].producto_sat+'</td>';
                            registro+= '<td>'+data[i].clave_unidad_sat+' - '+data[i].unidad_sat+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(cantidad.toFixed(6) + '')+'</td>';
                            registro+= '<td>'+data[i].descripcion+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(precio.toFixed(2) + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(iva.toFixed(2) + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(importe.toFixed(6) + '')+'</td>';
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

        $('#b_guardar_prefactura').click(function(){
            $('#b_guardar_prefactura').prop('disabled',true);
            if ($('#forma_general').validationEngine('validate'))
            {
                if($('#t_facturas .renglon_partida').length > 0)
                {
                    guardar('prefactura');
                }else{
                    mandarMensaje('Debe existir por lo menos un producto/servicio para guardar');
                    $('#b_guardar_prefactura').prop('disabled',false);
                }
            }else{
                $('#b_guardar_prefactura').prop('disabled',false);
            }
        });

        function guardar(tipo){
            var idUnidadNegocio = $('#s_id_unidades').val();
            var idCliente = $('#i_cliente').attr('alt');
            var idMetodoPago = $('#s_metodo_pago').val();

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
                'total' : parseFloat(quitaComa($('#i_total').val())),
                'fechaInicioPeriodo' : $('#i_inicio_periodo').val(),
                'fechaFinPeriodo' : $('#i_fin_periodo').val(),
                'usuario' : usuario,
                'facturasSustituir' : obtieneFacturasSustituir(),
                'retencion' :  0,
                'importeRetencion' : 0,
                'porcentajeRetencion' : 6,
                'tipo' : tipo

            };

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_guardar.php',
                data:  {'datos':info},
                success: function(data) {
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
                
                arreglo[j] = {
                    'idClaveSATProducto' : idClaveSATProducto,
                    'idClaveSATUnidad' : idClaveSATUnidad,
                    'nombreUnidadSAT' : nombreUnidadSAT,
                    'nombreProductoSAT' : nombreProductoSAT,
                    'cantidad' : cantidad,
                    'precio' : precio,
                    'importe' : importe,
                    'descripcion' : descripcion
                };  

                j++;
            });

            return arreglo;
        }

        $('#i_precio_s, #i_cantidad_s').change(function(){

            if($(this).validationEngine('validate')==false) {
                var precio=quitaComa($('#i_precio_s').val());
                var cantidad=quitaComa($('#i_cantidad_s').val());

                if(precio==''){
                    precio=0;
                }

                if(precio > 0 && cantidad > 0)
                {
                    var valorIva = $('input[name=radio_iva]:checked').val();
                    var iva = ((parseFloat(cantidad)*parseFloat(precio))*parseInt(valorIva))/100;

                   

                    var t = ((parseFloat(cantidad)*parseFloat(precio))+iva);
                    $('#i_importe_s').val(formatearNumeroA6Dec(t));

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
            //url: 'https://denken.com.mx:172/cfdi_3_3/php/ws_genera_factura.php',
            url: 'https://denken.com.mx:172/cfdi_3_3/php/ws_gf_retencion.php', 
            data : {'empresa':idEmpresa, 'registro': idCFDI},
            success: function(data)
            {
                console.log(data); //3 22424
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
                    mandarMensaje('Error al generar timbre');

                $('#fondo_cargando').hide();   
            },
            error: function (xhr) {
                console.log(' error sistema: '+JSON.stringify(xhr));
                //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                mandarMensaje('* Error al generar timbre');
            }
        });

    });

    $('#b_cancelar').click(function(){
        var tipo = $('#div_estatus label').text();

        var id = $('#i_id').val();
        var idCFDI = $('#i_id_cfdi').val();
        var idEmpresa = $('#i_empresa_fiscal').attr('alt2');
        $('#fondo_cargando').show();

        if(tipo == 'TIMBRADA')
        {
            $.ajax({
                type: 'GET',
                url: 'https://denken.com.mx:172/cfdi_3_3/php/cancelar_nuevo.php',
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
        $('#fondo_cargando').show();
        $.ajax({
            type: 'GET',
            url: 'https://denken.com.mx:172/cfdi_3_3/php/veifica_status.php',
            dataType: "json",
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
            
         

            var registro='';
            registro+= '<tr class="renglon_partida editar" claveProducto="'+claveProducto+'" producto="'+producto+'" claveUnidad="'+claveUnidad+'" nombreUnidad="'+nombreUnidad+'" nombreProducto="'+nombreProducto+'" cantidad="'+cantidad+'" precio="'+precio+'" importe="'+importe+'" descripcion="'+descripcion+'">';
            registro+= '<td>'+producto+'</td>';
            registro+= '<td>'+unidad+'</td>';
            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(cantidad.toFixed(6) + '')+'</td>';
            registro+= '<td>'+descripcion+'</td>';
            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(precio.toFixed(2) + '')+'</td>';
            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(iva.toFixed(2) + '')+'</td>';
            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(importe.toFixed(6) + '')+'</td>';
            registro+= '<td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>';
            registro+= '</tr>';
            $('#t_facturas tbody').append(registro);

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
                var precio = renglon.attr('precio');
                var importe = renglon.attr('importe')
                
                $('#s_clave_sat_s').val(renglon.attr('claveProducto'));
                $('#s_clave_sat_s').select2({placeholder: $(this).data('elemento')});
                $('#s_id_unidades_s').val(renglon.attr('claveUnidad'));
                $('#s_id_unidades_s').select2({placeholder: $(this).data('elemento')}); 
                
                $('#i_cantidad_s').val(formatearNumeroA6Dec(cantidad));
                $('#i_precio_s').val(formatearNumero(precio));
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
        }

        function limpiar(){
            $('#forma_general input').not('[type=radio]').val('');
            $('#b_guardar_prefactura').prop('disabled',false);
            generaFecha('s_mes');
            muestraSelectUsoCFDI('s_cfdi');
            muestraSelectMetodoPago('s_metodo_pago');
            $('#s_razon_social').html('').val('');
            $('#s_forma_pago').html('').val('');
            $('#i_subtotal, #i_iva_total, #i_total').val('');
            $('#i_fecha').val(hoy);
            $('#t_facturas tbody').html('');
            $('#div_estatus').html('');
            $('#div_b_verificar_estatus').css('display','none');
            $('#div_b_descargar_acuse').css('display','none'); 
            idFactura = 0;
            $('#forma_general input,select').prop('disabled',false);
            $('#b_buscar_clientes,#b_buscar_empresa_fiscal').prop('disabled',false);
            $('#i_anio').val(anioN);
            $('form').validationEngine('hide');
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

        function calculaTotales(){

            var subtotal = 0;
            var iva = 0;
            var total = 0;

            $('.renglon_partida').each(function(){
                var valor= parseFloat($(this).attr('precio'))*parseFloat($(this).attr('cantidad'));
               
                //subtotal=subtotal+valor;    //************
                //-->NJES Feb/26/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
                //redondear cada valor y tomar solo dos decimales ya que el calculo al formar el xml asi lo hace
                subtotal=subtotal+(parseFloat(valor.toFixed(2))*1000);

                //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
                var ivaP = $('input[name=radio_iva]:checked').val();
                var ivaP=(valor*parseInt(ivaP))/100;
                var datoIvaP =  formatearNumeroCSS(ivaP.toFixed(2) + '');
                $(this).find('td').eq(5).text('').append(datoIvaP);


                var importe = valor + parseFloat(ivaP) ;
                var importeP =  formatearNumeroCSS(importe.toFixed(7) + '');
                $(this).find('td').eq(7).text('').append(importeP);
                //<--
            });

            var valorIva = $('input[name=radio_iva]:checked').val();

            //iva=(subtotal*parseInt(valorIva))/100;    //************
            //-->NJES Feb/26/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
            iva=((parseFloat(subtotal)/1000)*parseInt(valorIva))/100;
            
            //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
           
                           
            //total=subtotal+iva-parseFloat(retencion);   //************
            //-->NJES Feb/26/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
            total=(parseFloat(subtotal)/1000)+iva;

            //$('#i_subtotal').val(formatearNumero(subtotal.toFixed(2)));  //********** 
            //-->NJES Feb/26/2020 multiplicar cada partida por 1000 y la suma de todos dividiros entre 1000
            $('#i_subtotal').val(formatearNumero((parseFloat(subtotal)/1000).toFixed(2)));  
            $('#i_iva_total').val(formatearNumero(iva.toFixed(2)));
            $('#i_total').val(formatearNumero(total.toFixed(2))); 

            if($('#i_importe_s').val() != '')
            {
                var precio=quitaComa($('#i_precio_s').val());
                var cantidad=quitaComa($('#i_cantidad_s').val());

                var valorIva = $('input[name=radio_iva]:checked').val();
                var iva = ((parseFloat(cantidad)*parseFloat(precio))*parseInt(valorIva))/100;
                var importe = (parseFloat(cantidad))*parseFloat(precio);

              
                var t = ((parseFloat(cantidad)*parseFloat(precio))+iva);
                $('#i_importe_s').val(formatearNumeroA6Dec(t));
            }
        }

         $(document).ready(function()
         {

            $('#i_cantidad_s').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 6);
            });

        });

         $(document).ready(function()
         {

            $('#i_importe_nc').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });

        });

        $(document).ready(function()
         {

            $('#i_precio_s').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });
            
        });

        $(document).ready(function(){
            $('#i_anio').keypress(function (event){
                return valideKeySoloNumeros(event);
            });
        });

        $(document).ready(function(){
            $('#i_4_cuenta').keypress(function (event){
                return valideKeySoloNumeros(event);
            });
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
            $('#dialog_notas_credito').modal('show');
        });

        $('#b_agregar_nota_credito').click(function(){
            $('#b_agregar_nota_credito').prop('disabled',true);

            if ($('#forma_notas_credito').validationEngine('validate'))
            {   
                //-->NJES Feb/18/2020 se compara que el importe del abono de la nota no revase el saldo actual de la factura
                if(parseFloat(quitaComa($('#i_total_nc').val())) <= parseFloat(quitaComa($('#label_saldo_actual_factura').text())))
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
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idEmpresaFiscalEmisor' : $('#i_empresa_fiscal').attr('alt'),
                'idCFDIEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt2'),
                'idRazonSocialReceptor' : $('#s_razon_social').val(),
                'razonSocialReceptor' : $('#s_razon_social option:selected').text(),
                'codigoPostal' : $('#s_razon_social option:selected').attr('alt3'),
                'rfc' : $('#i_rfc').val(),
                'idUsoCFDI' : $('#s_cfdi').val(),
                'idMetodoPago' : 'PUE',
                'idFormaPago' : '01',
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
                'retencion' : 0,
                'importeRetencion' : 0,
                'porcentajeRetencion' : 6
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
                        $('#i_total_nc').val('');

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
                //url: 'https://denken.com.mx:172/cfdi_3_3/php/ws_genera_factura.php',
                url: 'https://denken.com.mx:172/cfdi_3_3/php/ws_gf_retencion.php', 
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
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td data-label="Subtotal">$'+formatearNumeroCSS(data[i].subtotal)+'</td>\
                                        <td data-label="Iva">$'+formatearNumeroCSS(data[i].iva)+'</td>\
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
                                        <td colspan="5">No se encontró información</td>\
                                    </tr>';

                        $('#t_notas_credito tbody').append(html);

                    }
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

        $('#t_notas_credito').on('click', '.b_cancelar_NC', function(){
            $('#fondo_cargando').show(); 
            var idFactura = $("#i_id").val();
            var idNotaCredito = $(this).attr('alt');
            var idCFDI = $(this).attr('alt2');
            var idEmpresa = $('#i_empresa_fiscal').attr('alt2');

            $.ajax({
                type: 'GET',
                url: 'https://denken.com.mx:172/cfdi_3_3/php/cancelar_nuevo.php',
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
                url: 'https://denken.com.mx:172/cfdi_3_3/php/veifica_status.php',
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
            mostrarNotasCreditoTodas(idUnidadActual, idSucursalVision);
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
            muestraSelectRazonesSociales(idCliente,idUnidadActual,'s_razon_social');
            muestraSelectFormaPago(metodoPago,'s_forma_pago');

            muestraRegistro(idFactura);
            muestraRegistroDetalle(idFactura);
            $('#dialog_buscar_notas_credito').modal('hide');
        });

        fechaHoyServidor('i_fecha_inicio_NC','primerDiaMes');
        fechaHoyServidor('i_fecha_fin_NC','ultimoDiaMes');

        $('#i_fecha_inicio_NC').val(primerDiaMes);
        $('#i_fecha_fin_NC').val(ultimoDiaMes);

        $('#s_filtro_unidad_NC').change(function(){
            muestraSucursalesPermiso('s_filtro_sucursal_NC',$('#s_filtro_unidad_NC').val(),modulo,idUsuario);
            $('.img-flag').css({'width':'50px','height':'20px'});
            mostrarNotasCreditoTodas(idUnidadActual, idSucursalVision);
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
                mostrarNotasCreditoTodas(idUnidadActual, idSucursalVision);
            }
        });

        $('#i_fecha_inicio_NC').change(function(){
            if($('#s_filtro_sucursal_NC').val() >= 1)
            {buscarFacturas(idUnidadActual, idSucursalVision);
                mostrarNotasCreditoTodas($('#s_filtro_unidad_NC').val(),$('#s_filtro_sucursal_NC').val());
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_filtro_sucursal_NC').find('option[value="0"]').remove();
                $('#s_filtro_sucursal_NC').append('<option value="0" selected>Mostrar Todas</option>');
                mostrarNotasCreditoTodas(idUnidadActual, idSucursalVision);
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
                mostrarNotasCreditoTodas(idUnidadActual, idSucursalVision);
            }
        });

        //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
       



  
        $('input[name=radio_iva_nc]').change(function(){
            calculaTotalesNC();
        });

        function calculaTotalesNC(){
            var precio=quitaComa($('#i_importe_nc').val());

            if(precio==''){
                precio=0;
            }

            if(precio > 0)
            {
                var valorIva = $('input[name=radio_iva_nc]:checked').val();
                var iva = (parseFloat(precio)*parseInt(valorIva))/100;

                var total = (parseFloat(precio)+iva);
                $('#i_iva_nc').val(formatearNumero(iva.toFixed(2)));
                $('#i_total_nc').val(formatearNumero(total.toFixed(2)));

            }else{
                $('#i_importe_nc').val('');
                $('#i_iva_nc').val('');
                $('#i_total_nc').val('');
            }
        }

        $('#i_importe_nc').change(function(){
            if($(this).validationEngine('validate')==false) {
                calculaTotalesNC();
            }else{
                $('#i_importe_nc').val('');
                $('#i_iva_nc').val('');
                $('#i_total_nc').val('');
            }
        });

    });

</script>

</html>