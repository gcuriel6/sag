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
    <link href="vendor/switch.css" rel="stylesheet"/>
    <link href="css/general.css" rel="stylesheet"  type="text/css"/>
   
</head>

<style> 
    body{
        background-color:rgb(238,238,238);
        overflow-x:hidden;

    }
    #div_principal{
      position: absolute;
      top:0px;
      left: 0px;
      height: 100%;
      background-color: rgba(250,250,250,0.6);
      
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #d_estatus{
       padding-top:5px;
       text-align:center;
       font-weight:bold;
       font-size:13px;
       height:30px;
       vertical-align:middle;
   }
    

    .tablon {
        font-size: 10px;
    }

    #div_t_registros{
        height:160px;
        overflow:auto;
    } 

    #dialog_buscar_productos > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        
    }
  

    #dialog_factura_nota > .modal-lg{
        min-width: 80%;
        max-width: 80%;
   }

   @media screen and(max-width: 1030px){
        .modal-lg{
            min-width: 800px;
            max-width: 800px;
        }
    }

    @media screen and (max-width: 600px) {
        .modal-dialog{
            max-width: 300px;
        }
    }

    .numeroMoneda{
        text-align:right;
    }

    .totales{
        font-size:17;
        font-weight:bold;
        text-align:right;
    }

    .classCotizacion{
        background:rgb(212,237,218);
    }
    .classVC{
        background:rgba(163,206,215,0.3);
    }

    .classRenCotizacion th{
        background:rgb(40,167,69);
        color:#fff;
    }
    .classRenVC th{
        background:rgb(0,105,217);
        color:#fff; 
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
           
        <div class="col-md-1"></div>
        <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-2">
                    <div class="titulo_ban" id="titulo_forma"> COTIZACIÓN</div>
                </div>
                <div class="col-sm-12 col-md-2">
                <h5><span id='i_fecha' class="badge badge-secondary" ></span></h5>
                </div>
                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_nueva"><i class="fa fa-eraser" aria-hidden="true"></i> Nueva</button>
                </div>

                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_ventas"><i class="fa fa-search" aria-hidden="true"></i> Ventas</button>
                </div>

                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_cotizaciones"><i class="fa fa-search" aria-hidden="true"></i> Cotizaciones</button>
                </div>
                    
                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                </div>
                
                
            </div>

            
            <br>
            <form id="forma" name="forma">
            <div class="form-group row">
                <label for="s_id_sucursales" class="col-sm-2 col-md-2 col-form-label requerido">SUCURSAL </label>
                <div class="col-sm-3 col-md-3">
                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                </div>
                
                <div class="col-md-1">
                    <label for="i_folio" class="col-form-label">Folio</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_folio" name="i_folio" class="form-control form-control-sm"  autocomplete="off" readonly>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div id="d_estatus" class="alert alert-left"></div>
                </div>
               
                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-primary btn-sm form-control botones_cotizacion" id="b_convertir_a_venta"><i class="fa fa-magic" aria-hidden="true"></i> Convertir a Venta</button>
                </div>
            </div>  
            <div class="form-group row"><!-- row--->
                <label for="i_cliente" id="l_cliente" name="l_cliente" class="col-sm-12 col-md-2 col-form-label">CLIENTE <input type="checkbox" name="ch_cliente" id="ch_cliente"></label>
                
                <div class="col-md-6">
                    <div class="row">
                
                        <div class="input-group col-sm-12 col-md-12">
                            <input type="text" id="i_cliente" name="i_cliente" class="form-control form-control-sm validate[required]" style="font-size:14px;" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                  
                                </button>
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-info" title="Historia de ventas del cliente" type="button" id="b_historial" style="margin:0px;">
                                    <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            
                <label for="check_facturar" class="col-md-2 col-form-label"> <input type="checkbox" name="ch_facturar" id="ch_facturar"> Facturar </label>
                
                <div class="col-sm-12 col-md-2" id="div_folio_cotizacion">
                    Folio Cotización <input type="text" id="i_folio_cotizacion" name="i_folio_cotizacion" class="form-control form-control-sm"  autocomplete="off" readonly style="text-align:center;">
                </div>

                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-warning btn-sm form-control botones_cotizacion" id="b_editar_cotizacion"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Cotización</button>
                </div>
            </div><!-- /row--->

            <div class="row form-group">
                <label for="s_tipo_cotizacion" class="col-sm-12 col-md-2 col-form-label requerido">Tipo Cotización</label>
                <div class="col-md-3">
                    <select id="s_tipo_cotizacion" name="s_tipo_cotizacion" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;">
                        <option value="0" selected disabled>Selecciona</option>
                        <option value="1">Alarma</option>
                        <option value="2">Servicio de Monitoreo</option>
                        <option value="3">Mixta</option>
                    </select>
                </div>
                <div class="col-md-2" style="text-align:right;">
                    <label for="i_vendedor" class="col-form-label">Vendedor</label>
                </div>
                <div class="col-md-4">
                    <input type="text" id="i_vendedor" name="i_vendedor" class="form-control form-control-sm" readonly  autocomplete="off">
                </div>
            </div>

            <div class="row">
                <div class="col-md-1" style="text-align:right;">
                    <label for="i_costo_instalacion" class="col-form-label">Instalación</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_costo_instalacion" name="i_costo_instalacion" class="form-control form-control-sm validate[custom[number]] numeroMoneda costo"  autocomplete="off">
                </div>
                <div class="col-md-1">
                    <label for="i_costo_admin" class="col-form-label">Admin</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_costo_admin" name="i_costo_admin" class="form-control form-control-sm validate[custom[number]] numeroMoneda costo"  autocomplete="off">
                </div>
                <div class="col-md-1">
                    <label for="i_comision_venta" class="col-form-label">Comisión</label>
                </div>
                <div class="col-md-1">
                    <input type="text" id="i_comision_venta" name="i_comision_venta" class="form-control form-control-sm validate[custom[number]] numeroMoneda costo"  autocomplete="off">
                </div>
                <div class="col-md-1">
                    <label for="i_comision_venta" class="col-form-label">Costos</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_total_costo" name="i_total_costo" class="form-control form-control-sm validate[custom[number]] numeroMoneda"  autocomplete="off" readonly>
                </div>
            </div>

            
            </form>  
            <form id="form_partidas" name="form_partidas">  
            <div class="row classVC" style="border:1px solid #A3CED7;padding-bottom:10px;"><!-- row--->
                
                 
                
                <div class="col-md-2">
                    <label for="i_cantidad" class="col-form-label requerido">Cantidad</label>
                    <input type="text" id="i_cantidad" name="i_cantidad" class="form-control form-control-sm validate[required,custom[number],min[0.01]]"  autocomplete="off">
                </div>
                
                <div class="col-md-5">
                    <label for="i_producto" class="col-form-label requerido">Producto</label>
                    <div class="input-group col-sm-12 col-md-12">
                        <input type="text" id="i_producto" name="i_producto" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="b_buscar_productos" style="margin:0px;">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <label for="i_precio" class="col-form-label requerido">Precio</label>
                    <input type="text" id="i_precio" name="i_precio" class="form-control form-control-sm validate[required,custom[number]] numeroMoneda"  autocomplete="off">
                </div>
            
                <div class="col-md-2">
                    <label for="i_importe" class="col-form-label requerido">Importe</label>
                    <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm validate[required,custom[number]] numeroMoneda" readonly autocomplete="off">
                </div>
                
                <div class="col-md-1"><br>
                <button type="button" class="btn btn-success btn-block form-control" id="b_agregar_producto"><i class="fa fa-plus" aria-hidden="true"></i> </button>
                </div>
                
            </div><!-- /row--->
            </form><!--div forma_general-->
            <div class="row">
                <table class="tablon">
                    <thead>
                        <tr class="renglon classRenVC classRenCotizacion">
                            <th scope="col" width="10%">Cantidad</th>
                            <th scope="col" width="10%">Clave</th>
                            <th scope="col" width="40%">Producto</th>
                            <th scope="col" width="15%">Precio</th>
                            <th scope="col" width="15%">Importe</th>
                            <th scope="col" width="10%">X</th>
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
            <br>
    
            <div class="row classVC" style="border-top:1px solid #A3CED7;"><!-- row--->
                <div class="col-md-8"></div>
                <div class="col-md-1">
                    <label for="i_subtotal" class="col-form-label">Subtotal</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_subtotal" name="i_subtotal" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off" readonly>
                </div>
            </div>  
            
            <div class="row classVC"><!-- row--->
                <!-- MGFS 02-01-2020 SE AGREGAN LAS OBSERVACIONES PARA LAS COTIZACIONES -->
                <label for="" class="col-md-2 col-form-label">Observaciones &nbsp;<span class="badge badge-info"  title="Las observaciones ingresadas solo se mostrarán en pantalla  y en el formato de cotización"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                <div class="col-md-6">
                    <textarea id="ta_observaciones" name="ta_observaciones" rows="1" class="form-control form-control-sm"  autocomplete="off"></textarea>
                </div>
                
                <div class="col-md-1">
                    <label for="i_subtotal" class="col-form-label">Descuento</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_descuento" name="i_descuento" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off">
                </div>
            </div>  
            <div class="row classVC"><!-- row--->
                <div class="col-md-3"></div>
                <div class="col-md-5">
                    <div class="row">
                        <label for="" class="col-md-3 col-form-label requerido">Tasa IVA</label>
                        <div class="col-sm-2 col-md-2">
                            16% <input type="radio" name="radio_iva" id="r_16" value="16"> 
                        </div>
                        <!--<div class="col-sm-2 col-md-2">
                            8% <input type="radio" name="radio_iva" id="r_8" value="8">
                        </div>
                        <div class="col-sm-4 col-md-3">
                           0% <input type="radio" name="radio_iva" id="r_0" value="0" checked>
                        </div>-->
                    </div>
                </div>
                <div class="col-md-1">
                    <label for="i_total_iva" class="col-form-label">Total IVA</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_total_iva" name="i_total_iva" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off" readonly>
                </div>
            </div> 
            
            <div class="row classVC"><!-- row--->
                
                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-warning btn-sm form-control verificar_permiso" id="b_orden_servicio" alt="ORDEN_SERVICIO"><i class="fa fa-wrench" aria-hidden="true"></i> Orden Servicio</button>
                </div>
                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-primary btn-sm form-control verificar_permiso" id="b_facturar" alt="FACTURACION_ALARMAS"><i class="fa fa-file-code-o" aria-hidden="true"></i> Facturar</button>
                </div>
                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-info btn-sm form-control" id="b_imprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                </div>
                <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                </div>
               
                <div class="col-md-1">
                    <label for="i_total" class="col-form-label"><strong>TOTAL</strong></label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_total" name="i_total" class="form-control form-control-sm validate[required] numeroMoneda totales"  style="border:2px solid #000;" autocomplete="off" readonly>
                </div>
            </div>  
            
            
        </div> <!--div_contenedor-->
        </div><!-- fin row-->
    </div> <!--div_principal-->


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

    <div id="dialog_buscar_productos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Produtos </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <span id="span_unidad"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="input-group col-sm-12 col-md-5">
                        <input type="text" id="i_familia_filtro" name="i_familia_filtro" class="form-control" placeholder="Filtrar Por Familia" readonly autocomplete="off">
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="b_buscar_familia_filtro" style="margin:0px;" disabled>
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div> 
                    <div class="input-group col-sm-12 col-md-3">
                        <input type="text" id="i_linea_filtro" name="i_linea_filtro" class="form-control" placeholder="Filtrar Por Línea" readonly autocomplete="off">
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="b_buscar_lineas_filtro" style="margin:0px;">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>  
                    <div class="col-sm-12 col-md-3">
                        <input type="text" name="i_filtro_producto" id="i_filtro_producto" class="form-control filtrar_renglones" alt="tr_producto" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>  
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon"  id="t_productos">
                                <thead>
                                    <tr class="renglon">
                                        <th scope="col">Familia</th> 
                                        <th scope="col">Línea</th>
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Clave</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Existencia</th>
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

    <div id="dialog_buscar_ventas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_busqueda">Búsqueda Ventas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row" style="padding:15px;">
                <div class="col-sm-12 col-md-12 alert alert-success" role="alert" id="a_cliente"></div>
            </div>    
            <div class="form-group row">
                <label for="s_id_sucursales_filtro" class="col-sm-2 col-md-2 col-form-label">Sucursal </label>
                <div class="col-sm-3 col-md-4">
                    <select id="s_id_sucursales_filtro" name="s_id_sucursales_filtro" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                </div>
                <div class="col-sm-6 col-md-6"><h6><span class="badge badge-warning">Por defatul muestra la información del mes actual</span></h6></div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <input type="text" name="i_filtro_ventas" id="i_filtro_ventas" class="form-control filtrar_renglones" alt="renglon_ordenes" placeholder="Filtrar" autocomplete="off">
                </div>
                <div class="col-sm-12 col-md-1">Del: </div>
                <div class="input-group col-sm-12 col-md-3">
                    <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                    <div class="input-group-addon input_group_span">
                        <span class="input-group-text">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-1">Al: </div>
                <div class="input-group col-sm-12 col-md-3">
                    <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                    <div class="input-group-addon input_group_span">
                        <span class="input-group-text">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_ventas">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Folio</th>
                          <th scope="col">Sucursal</th>
                          <th scope="col">Fecha</th>
                          <th scope="col">Cliente</th>
                          <th scope="col">Total</th>
                          <th scope="col">Estatus</th>
                          <th scope="col" id="th_folio_cotizacion">Folio Cotización</th>
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

<div id="dialog_buscar_lineas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Líneas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_lineas" id="i_filtro_lineas" class="form-control filtrar_renglones" alt="renglon_lineas" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_lineas">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Clave</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Familia</th>
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
<script src="vendor/switch.js"></script>

<script>
  
    var modulo='VENTAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var idVenta = 0;
    var tipo_mov = 0;
    var historial = 0;
    var puedeEditar=0;
    var tipoR=0;
    var imprimirFormato='';
    var existenciaG = 0;
    var cantidadG = 0;
    var tipoRegistro = '';
    
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);

        //-->NJES May/22/2020 verifica los botones que tengan la clase verifica_permiso para ver si tienen permiso segun la forma indicada en el alt
        verificarPermisosAlarmas(idUsuario,idUnidadActual);

        //-->NJES Sep/23/2020 agregar campo vendedor (trabajador ligado a usuario logueado)
        //-->NJES February/17/2021 la funcion original era muestraVendedor(), y al cambiarla por muestraVendedorVenta(parametro)
        //no cambiaron todas las funciones donde se mandaba llamara
        muestraVendedorVenta(idUsuario);
        
        console.log('***********');

        $('.botones_cotizacion').hide();
        $('#div_folio_cotizacion').hide();
        /*---MGFS 02-01-2020 SE AGREGA CAMBIO PARA INGRESAR EL NOMBRE DE UN CLIENTE SI ES UNA COTIZACION, 
             SI SE CAMBIA A VENTA SE TENDRA QUE AGREGAR DE LA BUSUQEDA SE SERVICIOS(CLIENTES)*/
        $('#l_cliente').removeClass('requerido');
        $('#ch_cliente').prop('checked',false);
        $('#b_buscar_clientes').prop('disabled',true);
        $('#b_historial').prop('disabled',true);
        $('#i_cliente').attr('alt',0).attr('alt2',0).prop('readonly',false);
        $('#ta_observaciones').val('').prop('readonly',false);

        /*verificaChkdFactura();

        function verificaChkdFactura(){
            if($('#ch_facturar').is(':checked'))
                $('input[name=radio_iva]').prop('disabled',false);
            else{
                $('input[name=radio_iva]').prop('disabled',true);
                $('#r_0').prop('checked',true);
            }
        }*/

        /*$('#ch_facturar').change(function(){
            verificaChkdFactura();
        });*/
        $('#r_16').prop('checked',true);
        $('input[name=radio_iva]').prop('disabled',true);
        

        $('#b_cancelar').prop('disabled',true);
        $('#b_imprimir').prop('disabled',true);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha').html(hoy);
    

        function labelEstatus(estatus){
            var est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #0066cc;">SIN TIMBRAR</label>';
                        if(estatus == 'T')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">TIMBRADA</label>';
                        else if(estatus == 'C')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ff0000;">CANCELADA</label>';
                        else if(estatus == 'P')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ffc107;">PENDIENTE</label>';
                        else if(estatus == 'S')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">SALDADA</label>';
                        else if(estatus == 'A')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">ACTIVA</label>';
                        
            return est;
        }

        /***** BUSQUEDA DE CLIENTES */   
        $('#b_buscar_clientes').on('click',function(){

            //-->NJES October/20/2020 buscar los clientes por sucursal
            if($('#s_id_sucursales').val() != null){

                $('#forma').validationEngine('hide');
                $('#i_filtro_servicios').val('');
                $('.renglon_servicios').remove();

                $.ajax({

                    type: 'POST',
                    url: 'php/servicios_buscar.php',
                    dataType:"json", 
                    data:{'estatus':2,
                        'idSucursal':$('#s_id_sucursales').val()},

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

                            var html='<tr class="renglon_servicios" alt="'+data[i].id+'"  alt2="' + data[i].nombre_corto+ '" alt3="' + data[i].porcentaje_iva+ '" alt4="' + data[i].razon_social+ '">\
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
            }else{
                mandarMensaje('Selecciona una sucursal para iniciar la busqueda de clientes');
            }
        });

        $('#t_servicios').on('click', '.renglon_servicios', function(){

            var idServicio = $(this).attr('alt');
            var nombreCorto = $(this).attr('alt2');
            var tasaIva = $(this).attr('alt3');
            var razonSocial = $(this).attr('alt4');

            $('#i_cliente').attr('alt',idServicio).attr('alt2',tasaIva).attr('alt3',razonSocial).val(nombreCorto);
            $('#r_16').prop('checked',true);
            calcularTotal();
            /*if($('#ch_facturar').is(':checked')==true){

               /* $('input[name=radio_iva]').prop('checked',false); 

                if(parseInt(tasaIva) == 16){
                    $('#r_16').prop('checked',true);
                }else if(parseInt(tasaIva) == 8){
                    $('#r_8').prop('checked',true);
                }else{
                    $('#r_0').prop('checked',true);
                }
                
                calcularTotal();

            }else{

                //$('#r_0').prop('checked',true);
                calcularTotal();
            }*/

            $('#dialog_buscar_servicios').modal('hide');

        });
        /***** FIN BUSQUEDA DE CLIENTES */   


        /*$('#ch_facturar').on('change',function(){
           
            
            if($('#ch_facturar').is(':checked')==true){
              

                $('input[name=radio_iva]').prop('checked',false); 

                var tasaIva= $('#i_cliente').attr('alt2');
              
                if(parseInt(tasaIva) == 16){
                    $('#r_16').prop('checked',true);
                }else if(parseInt(tasaIva) == 8){
                    $('#r_8').prop('checked',true);
                }else{
                    $('#r_0').prop('checked',true);
                }

                calcularTotal();    
                  

            }else{
               
                $('#r_0').prop('checked',true);
                calcularTotal();
            }

        });*/

        $('input[name=radio_iva]').on('change',function(){
            if($('#ch_facturar').is(':checked')==true){
                calcularTotal();
            }
        });

        $('#i_descuento').change(function(){
            calcularTotal();
        });

        /***** BOTON BUSQUEDA DE PRODUCTOS */   
        $('#b_buscar_productos').click(function()
        {

            $('#i_filtro_producto').val('');
            if($('#s_id_sucursales').val() != null)
            {

                var idUnidad = idUnidadActual;
                var idSucursal = $('#s_id_sucursales').val();

                $('#dialog_buscar_productos').modal('show');
                // verificando ando
                //muestraFamiliaAlarmas('i_familia_filtro')
                buscarProductos();
                
            }
            else
            {
                mandarMensaje('Seleccionar una Sucursal para buscar sus productos existentes');
            }

        });

         /***** FUNCTION BUSQUEDA DE PRODUCTOS */   
        function buscarProductos(idFamiliaAlarmas)
        {

            // verificando ando
            idFamiliaAlarmas = 102;  
            console.log('verificando');          
          
            $('#t_productos >tbody tr').remove();

                /*console.log('verificando... ' + idFamiliaAlarmas);
                console.log(JSON.stringify(
                    {
                        'idUnidad':idUnidadActual,
                        'idSucursal':$('#s_id_sucursales').val(),
                        'idFamilia':idFamiliaAlarmas,
                        'idLinea':$('#i_linea_filtro').attr('alt')
                    }
                ));*/
                // verificando
                // //NJES Jan/16/2020 buscar los productos sin y con existencia
            $.ajax({
                type: 'POST',
                url: 'php/productos_buscar_activos_todos.php',
                dataType:"json", 
                async: false,
                data:{
                    'idUnidad':idUnidadActual,
                    'idSucursal':$('#s_id_sucursales').val(),
                    'idFamilia':idFamiliaAlarmas,
                    'idLinea':$('#i_linea_filtro').attr('alt'),
                    'tipo': 1
                },                
                success: function(data)
                {

                    //console.log('consulta -> ' + data);
                    
                    if(data.length != 0)
                    {
                
                        for(var i=0;data.length>i;i++)
                        {

                            var producto = data[i];
                            
                            var html = "<tr class='tr_producto' alt='" + producto.id + "'  alt2='" + producto.clave+ "' alt3='" + producto.concepto + "' alt4='" + producto.cantidad + "' alt5='" + producto.costo + "' alt6='" + producto.existencia + "' alt7='" + producto.descripcion + "' alt8='" + producto.id_familia_gasto + "' servicio='"+producto.servicio+"'>";
                                html += "<td data-label='Familia'>" + producto.familia + "</td>";
                                html += "<td data-label='Línea'>" + producto.linea + "</td>";
                                html += "<td data-label='Concepto'>" + producto.concepto + "</td>";
                                html += "<td data-label='Clave'>" + producto.clave + "</td>";
                                html += "<td align='right' data-label='Precio'>" + formatearNumero(producto.costo) +  "</td>";
                                html +="<td data-label='Existencia'>"+ producto.existencia +"</td>";
                                html += "</tr>";
                            ///agrega la tabla creada al div 
                            $('#t_productos tbody').append(html);   
                                
                        }

                    }else{
                        var html = "<tr><td colspan='5'>No se encontró información</td><tr>";
                        $('#t_productos tbody').append(html);  
                    }

                },
                error: function (xhr) {
                    console.log('php/productos_buscar_activos_todos.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar productos');
                }
            });
        }

        $("#t_productos").on('click','.tr_producto',function(){

            var idProducto = $(this).attr('alt');
            //--> NJES Jan/27/2020 se quita validación para que puedan agregar un mismo producto 
            //ya que Claudia Regalado necesita agregar partidas en costo 0 y otras con costo del mismo producto
            //if(productosAgregados(idProducto)=='')
            //{
                var claveProducto = $(this).attr('alt2');
                var producto = $(this).attr('alt3');
                var cantidad = $(this).attr('alt4');
                var precio = $(this).attr('alt5');
                var existencia = $(this).attr('alt6');
                var descripcion = $(this).attr('alt7');
                var idFamiliaGasto = $(this).attr('alt8');
                var servicio = $(this).attr('servicio');

                $('#i_producto').attr('alt',idProducto).attr('alt2',claveProducto).attr('alt3',descripcion).attr('alt4',idFamiliaGasto).attr('servicio',servicio).val(producto);
                $('#i_precio').val(formatearNumero(precio));
                //NJES Jan/16/2020 permitir poner decimales y que el valor minimo no sea 1, puede ir por ejemplo 0.2
                $('#i_cantidad').attr('alt',existencia);
                if($('#i_cantidad').val() != '')
                    $('#i_importe').val(formatearNumero(precio*parseFloat(quitaComa($('#i_cantidad').val()))));
                else
                    $('#i_importe').val('');

                $('#form_partidas').validationEngine('hide');
                $('#dialog_buscar_productos').modal('hide');

            /*}else{
                mandarMensaje('Este producto ya fue agregado intenta con otro');
            }*/

        });
        /***** FIN BUSQUEDA DE PRODUCTOS */   

        /***** VERIFICA PRODUCTOS AGREGADOS */   
        function  productosAgregados(idProducto){
            var encontrado='';
            $('#t_registros tbody tr').each(function(){
                
                var idProductoA=$(this).attr('idProducto');
                if(idProducto==idProductoA){
                    encontrado='SI';
                }
            });
            
            return encontrado;
        }

        function  productosServiciosAgregados(){
            var contProductos=0;
            var contServicios=0;
          
            $('#t_registros tbody tr').each(function(){
                
                var esServicio=$(this).attr('servicio');
                if(esServicio==1){
                    contServicios++;
                }else{
                    contProductos++;
                }
            });
            
            if(contServicios > 0 && contProductos > 0)
                return 1;
            else if(contServicios == 0 && contProductos > 0)
                return 1;   
            else
                return 0;

        }

        /***** CAMBIO DE PRECIO O CANTIDAD */   
        $('#i_precio,#i_cantidad').on('change',function(){

            if($(this).validationEngine('validate')==false) {

                var precio=quitaComa($('#i_precio').val());
                var cantidad=quitaComa($('#i_cantidad').val());
               
                if(precio==''){
                    precio=0;
                }

                if(precio > 0){
                    //NJES Jan/16/2020 permitir poner decimales y que el valor minimo no sea 1, puede ir por ejemplo 0.2
                    $('#i_importe').val(formatearNumero(parseFloat(cantidad)*parseFloat(precio)));

                }else{
                    $('#i_importe').val(0);
                }
            }else{
            $('#i_importe').val(0);
            }
        });

        //**************AGREGAR PARTIDAS************** */
        $('#b_agregar_producto').click(function(){

            $('#b_agregar_producto').prop('disabled',true);

            if($('#form_partidas').validationEngine('validate'))
            {
                var idProducto = $('#i_producto').attr('alt');
                var claveProducto = $('#i_producto').attr('alt2');
                var descripcion = $('#i_producto').attr('alt3');
                var idFamiliaGasto = $('#i_producto').attr('alt4');
                var producto = $('#i_producto').val();
                var cantidad = $('#i_cantidad').val();
                var precio = $('#i_precio').val();
                var importe = $('#i_importe').val();
                var existencia = $('#i_cantidad').attr('alt');
                var servico = $('#i_producto').attr('servicio');

                var html = "<tr class='partida' idProducto='" + idProducto + "' servicio='"+servico+"' descripcion='" + descripcion + "' idFamiliaGasto='" + idFamiliaGasto + "' claveProducto='" + claveProducto + "' producto='" + producto + "'  precio='" + precio + "' cantidad='" +  cantidad + "'  importe='" + importe + "'  existencia='"+existencia+"'>";
                html += "<td width='10%' data-label='Cantidad'>" + cantidad + "</td>";
                html += "<td width='10%' data-label='Clave'>" + claveProducto + "</td>";
                html += "<td width='40%' data-label='Producto'>" + producto + "</td>";
                html += "<td width='15%' data-label='PRECIO UNITARIO' align='right' >" + precio + "</td>";
                html += "<td width='15%' data-label='Importe' align='right'>" + importe + "</td>";
                html += "<td width='10%' class='boton_eliminar'><button type='button' class='btn btn-danger btn-sm form-control' id='b_eliminar' alt='" + idProducto + "'><i class='fa fa-remove' style='font-size:10px;' aria-hidden='true'></i></button></td>";

                html += "</tr>";

                $('#t_registros tbody').append(html);

                $('#form_partidas input').val('');
                $('#i_producto').attr('alt',0).attr('alt2','').val('');
                $('#b_agregar_producto').prop('disabled',false);
                calcularTotal();
            }else{
                $('#b_agregar_producto').prop('disabled',false);
            }
        });

        //**************ELIMINAR PARTIDAS************** */
        $(document).on('click','#b_eliminar',function(){
            $(this).parent().parent().remove();
            calcularTotal();
        });

        //****************EDITAR PARTIDAS***************** */
        $("#t_registros").on('dblclick',".partida",function(){
            if($('#i_producto').val() == '')
            {
                var idProducto = $(this).attr('idProducto');
                var descripcion = $(this).attr('descripcion');
                var idFamiliaGasto = $(this).attr('idFamiliaGasto');
                var producto = $(this).attr('producto');
                var clave = $(this).attr('claveproducto');
                var cantidad = $(this).attr('cantidad');
                var precio = $(this).attr('precio');
                var importe = $(this).attr('importe');
                var existencia = $(this).attr('existencia');

                $('#i_producto').attr('alt',idProducto).attr('alt2',clave).attr('alt3',descripcion).attr('alt4',idFamiliaGasto).val(producto);
                //NJES Jan/16/2020 permitir poner decimales y que el valor minimo no sea 1, puede ir por ejemplo 0.2
                $('#i_cantidad').attr('alt',existencia).val(formatearNumero(cantidad));
                $('#i_precio').val(formatearNumero(precio));
                $('#i_importe').val(formatearNumero(importe));
        
                $(this).remove();

                calcularTotal();

            }else{
                mandarMensaje('Debes agregar primero el producto actual');
            }
        });

        //**************CALCULA TOTAL************** */
        function calcularTotal(){

            var subtotal = 0;
            var tasaIva = 0;
            var totalIva = 0;

            //if($('#ch_facturar').is(':checked')==true){
                tasaIva = $('input[name=radio_iva]:checked').val();
            //}

            $("#t_registros .partida").each(function() {
                var importe = quitaComa($(this).attr('importe'));
                
                subtotal = subtotal+parseFloat(importe);
            });

            var descuento = ($('#i_descuento').val() != '') ? quitaComa($('#i_descuento').val()) : 0;
            
            $('#i_subtotal').val(formatearNumero(subtotal));

           
            var totalIva=0;
            var sumaTotalesDescuento=0;
           
            if( parseInt(tasaIva) > 0 ){
                sumaTotalesDescuento=(parseFloat(subtotal)-parseFloat(descuento));
                totalIva = parseFloat(sumaTotalesDescuento)*(parseInt(tasaIva)/100);
            }else
                sumaTotalesDescuento=(parseFloat(subtotal)-parseFloat(descuento));


            $('#i_total_iva').val(formatearNumero(totalIva));

            var total = parseFloat(sumaTotalesDescuento)+parseFloat(totalIva);
        
           
            $('#i_total').val(formatearNumero(total));

        }

        $(document).on('change','.costo',function(){

            calcularTotalCosto();
        });

        function  calcularTotalCosto(){
            var costoI=($('#i_costo_instalacion').val()!='')?quitaComa($('#i_costo_instalacion').val()):0;
            var costoA=($('#i_costo_admin').val()!='')?quitaComa($('#i_costo_admin').val()):0;
            var comision=($('#i_comision_venta').val()!='')?quitaComa($('#i_comision_venta').val()):0;
            
            var totalCosto=parseFloat(costoI)+parseFloat(costoA)+parseFloat(comision);
            $('#i_total_costo').val(formatearNumero(totalCosto));
        }


        $('#b_guardar').on('click',function(){
            $('#b_guardar').prop('disabled',true);
            if($('#forma').validationEngine('validate')){

                if( $(".partida").length > 0 ){

                    if($('#i_producto').val()==''){
                        //--> NJES Jan/27/2020 se quita validación porque ya se pueden cotizar solo servicios e imprimirlos, y convertirlos a venta
                        //if(productosServiciosAgregados() > 0){
                            var cotizacion=1;
                            guardar(cotizacion);
                        /*}else{
                            mandarMensaje('Debe haber por lo menos un producto que no sea servicio para guardar.');
                            $('#b_guardar').prop('disabled',false);
                        }*/
                    }else{
                        mandarMensaje('Debes agregar el producto que esta en edición');
                        $('#b_guardar').prop('disabled',false);
                    }
                }else{
                    mandarMensaje('Debes agregar por lo menos un producto');
                    $('#b_guardar').prop('disabled',false);
                }

            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardar(cotizacion){

            
            
            var datos = {
                'tipo_mov' : tipo_mov,
                'idVenta' : idVenta,
                'idUnidadNegocio' : idUnidadActual,
                'idSucursal' : $('#s_id_sucursales').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'cliente' : $('#i_cliente').val(),
                'facturar' : $('#ch_facturar').is(':checked')?1:0,
                'cotizacion'  :cotizacion,
                'idUsuario' : idUsuario,
                'usuario' : usuario,
                'anio' : anio,
                'mes' : numMes,

                'porcentajeIva' : $('input[name=radio_iva]:checked').val(),
                'subtotal' : quitaComa($('#i_subtotal').val()),
                'iva' : quitaComa($('#i_total_iva').val()),
                'total' : quitaComa($('#i_total').val()),
                'descuento' : quitaComa($('#i_descuento').val()),

                'fecha' : $('#i_fecha').text(),
                'noPartidas' : $(".partida").length,

                'costoInstalacion' : $('#i_costo_instalacion').val(),
                'costoAdmin' : $('#i_costo_admin').val(),
                'comisionVenta' : $('#i_comision_venta').val(),
                'costoTotal' : quitaComa($('#i_total_costo').val()),

                'observaciones' : $('#ta_observaciones').val(),

                'detalle' : obtenerPartidas(),
                //-->NJES Jan/31/2020 se envian solo las partidas de ptoductos porque los servicios no generan una salida de almacen
                'detalleAlmacen' : obtenerPartidasParaAlmacen(),
                'tipoCotizacion' : $('#s_tipo_cotizacion').val(),
                //-->NJES Sep/23/2020 se agrega vendedor, es el trabajador ligado al usuario logueado
                'vendedor' : $('#i_vendedor').val(),
                'folio' : $('#i_folio').val()
            };

            //console.log(JSON.stringify(datos));
            
            $.ajax({
                type: 'POST',
                url: 'php/ventas_guardar.php',
                data:{
                    'cotizacion' : cotizacion,
                    'datos' : datos
                },
                success: function(data) {
                    console.log("Resultado:"+JSON.stringify(data));
                    if(data>0){
                        idVenta=data;
                        if(parseInt(cotizacion)==0){
                            $('#b_guardar').prop('disabled',false);
                            
                            $('#b_nueva').click();
                            var datos = {
                                'path':'formato_venta',
                                'idRegistro':data,
                                'nombreArchivo':'venta',
                                'tipo':1
                            };

                            let objJsonStr = JSON.stringify(datos);
                            let datosJ = datosUrl(objJsonStr);

                            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
                            mandarMensaje('La venta se guardó correctamente');
                            

                        }else{
                            $('#b_guardar').prop('disabled',false);
                            
                            $('#b_nueva').click();
                            var datos = {
                                'path':'formato_cotizacion_alarmas',
                                'idRegistro':data,
                                'nombreArchivo':'cotizacion',
                                'tipo':1
                            };

                            let objJsonStr = JSON.stringify(datos);
                            let datosJ = datosUrl(objJsonStr);

                            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
                            mandarMensaje('La cotización se guardó correctamente');
                            
                        }

                    }else{
                        $('#b_guardar').prop('disabled',false);
                        mandarMensaje('Ocurrio un error durante el proceso');
                    }
                },
                error: function (xhr) {
                    $('#b_guardar').prop('disabled',false);
                    console.log('php/ventas_guardar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error durante el proceso');
                }
            }); 

        }

        //****************OBTENER PARTIDAS***************** */
        function obtenerPartidas(){

            var j = 0;
            var arreDatos = [];

            $("#t_registros .partida").each(function() {
            
                var idProducto = $(this).attr('idProducto');
                var claveProducto = $(this).attr('claveProducto');
                var producto = $(this).attr('producto');
                var descripcion = $(this).attr('descripcion');
                var idFamiliaGasto = $(this).attr('idFamiliaGasto');
                var cantidad = $(this).attr('cantidad');
                var precio = quitaComa($(this).attr('precio'));
                var importe = quitaComa($(this).attr('importe'));

                j++;

                arreDatos[j] = {
                    'idProducto' : idProducto,
                    'claveProducto' : claveProducto,
                    'producto' : producto,
                    'descripcion' : descripcion,
                    'idFamiliaGasto' : idFamiliaGasto,
                    'cantidad' : cantidad,
                    'precio' : precio,
                    'importe' : importe
                };
            });

            arreDatos[0] = j;
            return arreDatos;
        }

        //-->NJES Jan/31/2020 obtiene solo las partidas de ptoductos porque los servicios no generan una salida de almacen
        function obtenerPartidasParaAlmacen(){

            var j = 0;
            var arreDatos = [];

            $("#t_registros .partida").each(function() {

                var idProducto = $(this).attr('idProducto');
                var claveProducto = $(this).attr('claveProducto');
                var producto = $(this).attr('producto');
                var descripcion = $(this).attr('descripcion');
                var idFamiliaGasto = $(this).attr('idFamiliaGasto');
                var cantidad = $(this).attr('cantidad');
                var precio = quitaComa($(this).attr('precio'));
                var importe = quitaComa($(this).attr('importe'));
                var servicio = parseInt($(this).attr('servicio'));

                if(servicio == 0){
                    j++;

                    arreDatos[j] = {
                        'idProducto' : idProducto,
                        'claveProducto' : claveProducto,
                        'producto' : producto,
                        'descripcion' : descripcion,
                        'idFamiliaGasto' : idFamiliaGasto,
                        'cantidad' : cantidad,
                        'precio' : precio,
                        'importe' : importe
                    };
                }
            });

            arreDatos[0] = j;
            return arreDatos;
        }

        //****************BUSCAR VENTAS***************** */

        $('#i_fecha_inicio').change(function()
        {

            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscarVentas(tipoR);
            }

        });

        $('#i_fecha_fin').change(function(){ 

            buscarVentas(tipoR);

        });

        $('#s_id_sucursales_filtro').change(function(){
            buscarVentas(tipoR);
        });

        $('#b_buscar_ventas').on('click',function(){
            tipoR=0;
            historial=0;

            muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
            $('#dialog_buscar_ventas').modal('show');
            $('#titulo_busqueda').text('').text('Busqueda de Ventas');
            $('#a_cliente').hide().text('');
            $('#t_ventas > tbody').empty();   
            $('#i_fecha_inicio').val(primerDiaMes);
            $('#i_fecha_fin').val(ultimoDiaMes);

            buscarVentas(0);

        });




        /******BUSCA HISTORIAL DE VENTAS DEL CLIENTE***** */
        $('#b_historial').on('click',function(){
                tipoR=0;
                historial=1;

                if($('#i_cliente').val()!=''){

                $('#dialog_buscar_ventas').modal('show');
                $('#titulo_busqueda').text('').text('Historial de Ventas');
                $('#a_cliente').show().text(" Cliente: "+ $('#i_cliente').val());
                $('#t_ventas > tbody').empty();   
                $('#i_fecha_inicio').val(primerDiaMes);
                $('#i_fecha_fin').val(ultimoDiaMes);

                buscarVentas(0);

            }else{
                mandarMensaje('Debes seleccionar un cliente primero');
            }

        });

        /******BUSCA COTIZACIONES***** */
        $('#b_buscar_cotizaciones').on('click',function(){

            historial=0;

            muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
            $('#dialog_buscar_ventas').modal('show');
            $('#titulo_busqueda').text('').text('Busqueda de Cotizaciones');
            $('#a_cliente').hide().text('');
            $('#t_ventas > tbody').empty();   
            $('#i_fecha_inicio').val(primerDiaMes);
            $('#i_fecha_fin').val(ultimoDiaMes);
            tipoR=1;
            buscarVentas(1);

        });

        function buscarVentas(tipoR){

            $('#b_imprimir').prop('disabled',false);
            $('#forma').validationEngine('hide');
            $('#form_partidas').validationEngine('hide');
            $('#i_filtro_ventas').val('');
            $('#t_ventas tbody').html(''); 
            var idCliente=0;
            if(historial==1){
                idCliente = $('#i_cliente').attr('alt');
            }

            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);

            $.ajax({

                type: 'POST',
                url: 'php/ventas_buscar.php',
                dataType:"json", 
                data:{

                'cotizacion' : tipoR,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'idCliente': idCliente,
                'idSucursal': idSucursal

                },

                success: function(data) {
                //console.log(data);
                if(data.length != 0){

                    $('.renglon_ordenes').remove();
            
                    for(var i=0;data.length>i;i++){

                        ///llena la tabla con renglones de registros
                        var estatus='';
                        
                        // verificando ventas
                        if(tipoR == 0)
                        {

                            if(data[i].estatus == 'A')
                                estatus = 'Activa';
                            else
                                estatus = 'Cancelada';

                        }
                        else
                        {

                            if(data[i].estatus == 'A')
                            {

                                if(data[i].id_venta > 0)
                                    estatus = 'Autorizada'; 
                                else
                                    estatus = 'Seguimiento';

                            }
                            else
                                estatus = 'Cancelada';

                        }                        
                        
                        if(tipoR == 0)
                        {
                            $('#th_folio_cotizacion').show();
                            var html='<tr class="renglon_ordenes" alt="'+data[i].id+'"  alt2="'+data[i].cotizacion+'" sucursal="'+data[i].id_sucursal+'" tipo="' + tipoR + '">\
                                    <td data-label="Folio">' +data[i].folio+ '</td>\
                                    <td data-label="Sucursal">' +data[i].sucursal+ '</td>\
                                    <td data-label="Fecha">' +data[i].fecha+ '</td>\
                                    <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                    <td data-label="Total">' + formatearNumero(data[i].total)+ '</td>\
                                    <td data-label="Estatus">' + estatus + '</td>\
                                    <td data-label="Folio Cotización">' +data[i].folio_cotizacion+ '</td>\
                                </tr>';
                        }else{
                            $('#th_folio_cotizacion').hide();
                            var html='<tr class="renglon_ordenes" alt="'+data[i].id+'"  alt2="'+data[i].cotizacion+'" sucursal="'+data[i].id_sucursal+'" tipo="' + tipoR + '">\
                                    <td data-label="Folio">' +data[i].folio+ '</td>\
                                    <td data-label="Sucursal">' +data[i].sucursal+ '</td>\
                                    <td data-label="Fecha">' +data[i].fecha+ '</td>\
                                    <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                    <td data-label="Total">' + formatearNumero(data[i].total)+ '</td>\
                                    <td data-label="Estatus">' + estatus + '</td>\
                                </tr>';
                        }

                        ///agrega la tabla creada al div 
                        $('#t_ventas tbody').append(html);     
                    }

                }else{

                    mandarMensaje('No se encontró información con los parametros ingresados');
                }

                },
                error: function (xhr) {
                    console.log('php/ventas_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema al buscar la ventas');
                }
            });
        } 

        $('#t_ventas').on('click', '.renglon_ordenes', function()
        {

            //
            idVenta = $(this).attr('alt');
            var tipoR = $(this).attr('alt2');
            var idSucursal = $(this).attr('sucursal');
            //-->NJES Sep/28/2020 para que actualice un registro en notas_e 
            tipo_mov = 1;

            // cargando venta

            var classReg='partida_b';
            if(tipoR==1)
            {// 1=cotizacion 0= Venta
                $('#titulo_forma').text('').text('COTIZACIÓN');
                classReg = 'partida';
                imprimirFormato = 'formato_cotizacion_alarmas';
                $('#l_cliente').removeClass('requerido');
                //$('#ch_cliente').prop('checked',false).prop('disabled',true);
                $('#i_cliente').prop('readonly',true);
            
            }
            else
            {
                $('#titulo_forma').text('').text('VENTA');
                imprimirFormato = 'formato_venta';
                $('#l_cliente').addClass('requerido');
                $('#ch_cliente').prop('checked',true).prop('disabled',true);
                $('#i_cliente').prop('readonly',true);
            }
            $('#dialog_buscar_ventas').modal('hide');
            muestraRegistroVenta(idSucursal);
            muestraDetalleVenta(classReg);           
    
        });

        function muestraRegistroVenta(idSucursal){
            puedeEditar=0;
            $('#b_cancelar').prop('disabled',true);

            // verificando

            console.log(' ** ' + idVenta);

            $.ajax({
                type: 'POST',
                url: 'php/ventas_buscar_id.php',
                dataType:"json", 
                data:{
                    'idVenta':idVenta,
                    'idSucursal':idSucursal,
                    'idUnidadNegocio':idUnidadActual
                    //-->NJES May/18/2020 validar permiso para cancelar ventas de meses anteriores
                },
                success: function(data) {
                    console.log(data);

                    if(data.length != 0)
                    {
                        muestraVendedorVenta(data[0].id_usuario_captura);

                        $('#i_folio').val(data[0].folio).attr('alt',data[0].id_cxc);
                        $('#i_cliente').val(data[0].cliente).attr('alt',data[0].id_cliente).attr('alt3',data[0].razon_social);
                        $('#b_buscar_clientes').prop('disabled',true);
                        $('#b_agregar_producto').prop('disabled',true);
                        $('#b_guardar').prop('disabled',true);
                        $('#b_convertir_a_venta').prop('disabled',true);
                        $('#i_folio_cotizacion').val(data[0].folio_cotizacion);

                        var idSucursal =  data[0].id_sucursal;

                        if(parseInt(idSucursal) != 0)
                        {
                            $('#s_id_sucursales').val(idSucursal);
                            $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_id_sucursales').val('');
                            $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
                        }
                        
                        $('#s_tipo_cotizacion').val(data[0].tipo_cotizacion).prop('disabled',true);

                        var facturar = data[0].facturar;
                        if(parseInt(facturar)==1)
                            $('#ch_facturar').prop('checked',true).prop('disabled',true);
                        else
                            $('#ch_facturar').prop('checked',false).prop('disabled',true);
                        
                        //$('#ch_cotizacion').prop('disabled',false);  
                        $('#s_id_sucursales').prop('disabled',true);  
                        if(parseInt(data[0].cotizacion)==0){//--es una venta

                            //--> NJES Jan/31/2020 se quitan porque ya no existia el input creado y se agrega valor en variable para saber que es lo que se esta mostrando actualmente 
                            /*$('#ch_cotizacion').prop('checked',false);
                            $('#ch_cotizacion').bootstrapToggle('off');
                            $('#ch_cotizacion').prop('disabled',true);*/
                            tipoRegistro = 'venta';

                            if(data[0].cancelar=='si')
                                $('#b_cancelar').prop('disabled',false);
                            else
                                $('#b_cancelar').prop('disabled',true);

                            // verificando el boton
                            

                            $('#form_partidas input').prop('disabled',true);
                            $('#b_buscar_productos').prop('disabled',true);
                            $('.botones_cotizacion').hide();
                            $('#div_folio_cotizacion').show();

                        }else{//--es una cotizacion

                            if(data[0].id_cliente == 0)
                                $('#ch_cliente').prop('checked',false).prop('disabled',true);
                            else
                                $('#ch_cliente').prop('checked',true).prop('disabled',true);
                           
                            //--> NJES Jan/31/2020 se quitan porque ya no existia el input creado y se agrega valor en variable para saber que es lo que se esta mostrando actualmente 
                            /*$('#ch_cotizacion').prop('checked',true);
                            $('#ch_cotizacion').bootstrapToggle('on');
                            $('#ch_cotizacion').prop('disabled',true);*/
                            tipoRegistro = 'cotizacion';
                            $('#div_folio_cotizacion').hide();
                            if(data[0].estatus!='C'){
                                puedeEditar=1;
                                $('#form_partidas input').prop('disabled',true);
                                //-->NJES Sep/28/2020 si la cotización esta ligada a una venta ocultar botones de convertir a venta y editar
                                if(data[0].id_cotizacion == 0)
                                    $('.botones_cotizacion').prop('disabled',false).show();
                                else
                                    $('.botones_cotizacion').hide();

                            }else{
                                
                                $('#b_cancelar').prop('disabled',true);
                                $('#form_partidas input').prop('disabled',true);
                                $('#b_buscar_productos').prop('disabled',true);

                                //-->NJES Sep/28/2020 si la cotización esta ligada a una venta ocultar botones de convertir a venta y editar
                                if(data[0].id_cotizacion == 0)
                                    $('.botones_cotizacion').prop('disabled',true).show();
                                else
                                    $('.botones_cotizacion').hide();
                                
                            }

                        } 

                        $('input[name=radio_iva]').prop('checked',false).prop('disabled',true);

                        var tasaIva = data[0].porcentaje_iva;
                        if(parseInt(tasaIva) == 16){
                            $('#r_16').prop('checked',true);
                        }else if(parseInt(tasaIva) == 8){
                            $('#r_8').prop('checked',true);
                        }else{
                            $('#r_0').prop('checked',true);
                        }

                       
                        $('#i_descuento').val(formatearNumero(data[0].descuento)).prop('disabled',true);
                        $('#i_subtotal').val(formatearNumero(data[0].subtotal));
                        $('#i_total_iva').val(formatearNumero(data[0].iva));
                        $('#i_total').val(formatearNumero(data[0].total));

                        // verificando estatus

                        $('#d_estatus').removeAttr('class');
                        if(data[0].estatus=='A')
                        {

                            if(data[0].cotizacion == 1)
                            {

                                if(data[0].id_venta > 1)
                                    $('#d_estatus').addClass('alert alert-sm alert-info').text('AUTORIZADA'); 
                                else
                                    $('#d_estatus').addClass('alert alert-sm alert-info').text('SEGUIMIENTO');  
                                
                            }
                            else
                            {
                                $('#d_estatus').addClass('alert alert-sm alert-info').text('ACTIVA'); 
                            }

                        }else
                        {
                            $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA'); 
                        }

                        $('#i_costo_instalacion').val(formatearNumero(data[0].costo_instalacion)).prop('disabled',true);
                        $('#i_costo_admin').val(formatearNumero(data[0].costo_administrativo)).prop('disabled',true);
                        $('#i_comision_venta').val(formatearNumero(data[0].comision_venta)).prop('disabled',true);
                        $('#i_total_costo').val(formatearNumero(data[0].costo_total)).prop('disabled',true);
                        $('#ta_observaciones').val('');
                        $('#ta_observaciones').val(data[0].observaciones_cotizacion).prop('disabled',true);

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
        

         function muestraDetalleVenta(classPartida){

            $('.partida').remove();
            $('.partida_b').remove();

            $.ajax({
                type: 'POST',
                url: 'php/ventas_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idVenta':idVenta
                },
                success: function(data) {
                    console.log(data);

                    if(data.length != 0){

                        $('.partida_b').remove();

                        for(var i=0;data.length>i;i++){
                            
                            var html = "<tr class='"+classPartida+"' idProducto='" + data[i].id_producto + "' descripcion='" + data[i].descripcion + "' idFamiliaGasto='" + data[i].id_familia_gasto + "' claveProducto='" + data[i].clave_producto + "' producto='" + data[i].producto + "'  precio='" + data[i].precio + "' cantidad='" +  data[i].cantidad + "'  importe='" + data[i].importe + "'  existencia='"+data[i].existencia+"' servicio='"+data[i].servicio+"'>";
                            html += "<td width='10%' data-label='Cantidad'>" + data[i].cantidad + "</td>";
                            html += "<td width='10%' data-label='Clave'>" + data[i].clave_producto + "</td>";
                            html += "<td width='40%' data-label='Producto'>" + data[i].producto + "</td>";
                            html += "<td width='15%' data-label='PRECIO UNITARIO' align='right' >" + formatearNumero(data[i].precio) + "</td>";
                            html += "<td width='15%' data-label='Importe' align='right'>" + formatearNumero(data[i].importe) + "</td>";
                            html += "<td width='10%' class='boton_eliminar'><button type='button' class='btn btn-danger btn-sm form-control b_eliminar_partida' id='b_eliminar' alt='" + data[i].id_producto + "' disabled><i class='fa fa-remove' style='font-size:10px;' aria-hidden='true'></i></button></td>";

                            html += "</tr>";

                            $('#t_registros tbody').append(html);
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

        //***********CANCELAR VENTA*********** */
        $('#b_orden_servicio').on('click',function(){
            var idServicio = $('#i_cliente').attr('alt');
            window.open("fr_servicios_ordenes.php?idServicio="+idServicio+"&nombreCorto="+$('#i_cliente').val()+"&idSucursal="+$('#s_id_sucursales').val()+"&regresar=1"+"&tipo=ventas","_self");
        });

        //***********CANCELAR VENTA*********** */
        $('#b_facturar').on('click',function(){
            var idServicio = $('#i_cliente').attr('alt');
            window.open("fr_facturacion_alarmas.php?idServicio="+idServicio+"&nombreCorto="+$('#i_cliente').val()+"&idSucursal="+$('#s_id_sucursales').val()+"&regresar=1","_self");
        });

        //***********CANCELAR VENTA*********** */
        $('#b_cancelar').on('click',function(){

            $('#b_cancelar').prop('disabled',true);
            //var mensajeR=$('#ch_cotizacion').is(':checked')?'cotización':'venta';

            //-->NJES Jan/31/2020 se toma el valor de la variable para el mensaje que se muestra cuando se cancele venta o cotización
            if(tipoRegistro=='venta')
                var mensajeR='venta';
            else
                var mensajeR='cotización';

            $.ajax({
                type: 'POST',
                url: 'php/ventas_cancelar.php',
                dataType:"json", 
                data:{
                    'idVenta':idVenta,
                    'tipoR':tipoR,
                    'idUsuario' : idUsuario
                },
                success: function(data) {
                    
                    if(data>0){
                        $('#d_estatus').removeAttr('class');
                        $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
                        mandarMensaje('La '+mensajeR+' se canceló correctamente');
                        bloquear();

                    }else{
                        mandarMensaje('Ocurrio un error al cancelar la '+mensajeR+', intentalo nuevamente');
                        $('#b_cancelar').prop('disabled',false);
                    }
                },
                error: function (xhr) {
                    console.log('php/ventas_cancelar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al cancelar la '+mensajeR+', intentalo nuevamente');
                    $('#b_cancelar').prop('disabled',false);
                }
            });   
        });

        //***********NUEVA VENTA***************** */
        $('#b_nueva').on('click',function(){
            limpiar();
        });

        function limpiar(){
            idVenta = 0;
            historial = 0;
            tipo_mov = 0;

            $('#titulo_forma').text('').text('COTIZACIÓN');
            $('#i_folio').val('').attr('alt',0);
            $('#i_cliente').val('').attr('alt',0).attr('alt2',0).attr('alt3',0).prop('readonly',false);
            $('#b_buscar_clientes').prop('disabled',false);
            $('#b_agregar_producto').prop('disabled',false);
            $('#b_guardar').prop('disabled',false);
            $('#b_convertir_a_venta').prop('disabled',true);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            $('#s_id_sucursales').val('').prop('disabled',false);
            $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
            $('#ch_facturar').prop('checked',false).prop('disabled',false);
            
            //--> NJES Jan/31/2020 se quitan porque ya no existia el input creado y se agrega valor en variable para saber que es lo que se esta mostrando actualmente 
            /*$('#ch_cotizacion').prop('disabled',false); 
            $('#ch_cotizacion').prop('checked',true);
            $('#ch_cotizacion').bootstrapToggle('on');
            $('#ch_cotizacion').prop('disabled',true);*/
            tipoRegistro = 'cotizacion';
        

            //$('input[name=radio_iva]').prop('checked',false).prop('disabled',false);
            //$('#r_0').prop('checked',true);
            $('input[name=radio_iva]').prop('disabled',true);
            $('#r_16').prop('checked',true);

            $('#i_subtotal').val(formatearNumero(0.00));
            $('#i_total_iva').val(formatearNumero(0.00));
            $('#i_total').val(formatearNumero(0.00));
           
            $('#i_descuento').val(formatearNumero(0.00)).prop('disabled',false);

            $('#i_costo_instalacion').val('').prop('disabled',false);
            $('#i_costo_admin').val('').prop('disabled',false);
            $('#i_comision_venta').val('').prop('disabled',false);
            $('#i_total_costo').val('').prop('disabled',false);

            $('#form_partidas input').prop('disabled',false).val('');
            $('#b_buscar_productos').prop('disabled',false);

            $('#d_estatus').removeAttr('class');
            $('#d_estatus').addClass('alert alert-sm alert-light').text('');  
            $('#b_cancelar').prop('disabled',true);
            $('#b_imprimir').prop('disabled',true);
            $('.botones_cotizacion').hide();
            $('#div_folio_cotizacion').hide();

            $('.partida_b').remove();
            $('.partida').remove();

            $('#ch_cliente').prop('checked',false).prop('disabled',false);
            $('#b_buscar_clientes').prop('disabled',true);
            $('#b_historial').prop('disabled',true);
            $('#i_cliente').prop('readonly',false);
            
            $('#ta_observaciones').val('').prop('disabled',false);    

            $('#s_tipo_cotizacion').val(0).prop('disabled',false);
            
            //-->NJES February/17/2021 la funcion original era muestraVendedor(), y al cambiarla por muestraVendedorVenta(parametro)
            //no cambiaron todas las funciones donde se mandaba llamar
            muestraVendedorVenta(idUsuario);
        }

        $(document).ready(function()
         {

            $('#i_costo_instalacion,#i_costo_admin,#i_comision_venta,#i_descuento,#i_cantidad,#i_precio').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });
            
        });

        $('#b_imprimir').click(function(){
            if($('#i_folio').val()!=''){
                imprimir();
            }else{
                mandarMensaje('Debes selecionar una venta o cotización, para imprimir');
            }
           

        });


        function imprimir(){
           
            var datos = {
                'path':imprimirFormato,
                'idRegistro':idVenta,
                'nombreArchivo':'venta',
                'tipo':1
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_blank');
           

        }
        function bloquear(){
            $('#b_cancelar').prop('disabled',true);
            $('#form_partidas input').prop('disabled',true);
            $('#b_buscar_productos').prop('disabled',true);
            $('#b_guardar').prop('disabled',true);
            $('#b_buscar_clientes').prop('disabled',true);
            $('#b_agregar_producto').prop('disabled',true);
            $('#b_convertir_a_venta').prop('disabled',true);
            $('#s_id_sucursales').prop('disabled',true);
            $(document).find('.b_eliminar_partida').prop('disabled',true);
            $('#ch_facturar').prop('disabled',true);
            $('input[name=radio_iva]').prop('checked',false).prop('disabled',true);
            $('#r_0').prop('checked',true);
            $('#s_tipo_cotizacion').prop('disabled',true);
        }

        //***********EDITAR COTIZACION*********** */
        $(document).on('click','#b_editar_cotizacion',function(){
            $('#b_cancelar').prop('disabled',false);
            $('#form_partidas input').prop('disabled',false);
            $('#b_buscar_productos').prop('disabled',false);
            $('#b_guardar').prop('disabled',false);
            $('#b_agregar_producto').prop('disabled',false);
            $('#b_convertir_a_venta').prop('disabled',true);
            $('#s_id_sucursales').prop('disabled',true);
            $(document).find('.b_eliminar_partida').prop('disabled',false);
            $('#ch_facturar').prop('disabled',false);
            $('#r_16').prop('checked',true);
            $('input[name=radio_iva]').prop('disabled',true);
            $('#i_descuento').prop('disabled',false);
            $('#i_costo_instalacion').prop('disabled',false);
            $('#i_costo_admin').prop('disabled',false);
            $('#i_comision_venta').prop('disabled',false);
            $('#i_total_costo').prop('disabled',false);
            $('#ta_observaciones').prop('disabled',false);
            $('#s_tipo_cotizacion').prop('disabled',false);

            //-->NJES November/04/2020 permitir editar cliente al editar una cotización
            if($('#ch_cliente').is(':checked'))
            {
                $('#b_buscar_clientes').prop('disabled',false);
                $('#b_historial').prop('disabled',false);
            }else{
                $('#b_buscar_clientes').prop('disabled',true);
                $('#b_historial').prop('disabled',true);
            }

            $('#ch_cliente').prop('disabled',false);
            $('#i_cliente').prop('readonly',false);

            //-->NJES February/17/2020 la funcion original era muestraVendedor(), y al cambiarla por muestraVendedorVenta(parametro)
            //no cambiaron todas las funciones donde se mandaba llamar
            muestraVendedorVenta(idUsuario);

            //idVenta = 0;
        });
         //***********CONVERTIR UNA COTIZACION A VENTA*********** */

        $(document).on('click','#b_convertir_a_venta',function(){
            //-->NJES Sep/28/2020 para que cree un nuevo registro en notas_e y no actualice
            tipo_mov=0;
            //--> obtiene los productos que se quieren agregar pero la existencia no es suficiente para converir a venta
            $.ajax({
                type: 'POST',
                url: 'php/ventas_buscar_productos_distintos.php',
                dataType:"json", 
                data:{'idCotizacion':idVenta},

                success: function(data) {
                    
                    if(data.length==0){
                        convertiVenta();
                    }else{
                        var mensaje="";
                        for(var i=0; data.length>i;i++){
                            mensaje=mensaje+'<p style="font-size:14.5px;">El producto: '+data[i].producto+' con clave '+data[i].clave+' requiere una cantidad de '+data[i].requerido+' y tiene una existencia de '+data[i].existencia+'.</p>';
                        }
                        mandarMensaje(mensaje);
                        tipo_mov=1;
                    }
                },
                error: function (xhr) {
                    console.log('php/ventas_buscar_productos_distintos.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar existencia de productos');
                }
            });
        });

        function convertiVenta(){

            $('#b_convertir_a_venta').prop('disabled',true);

            if(parseInt($('#i_cliente').attr('alt'))>0){

                if($('#forma').validationEngine('validate')){

                    if( $(".partida").length > 0 ){

                        if($('#i_producto').val()==''){
                            guardar(0);
                            $('#b_convertir_a_venta').prop('disabled',false);                            
                        }else{
                            mandarMensaje('Debes agregar el producto que esta en edición');
                            $('#b_convertir_a_venta').prop('disabled',false);
                            tipo_mov=1;
                        }
                    }else{
                        mandarMensaje('Debes agregar por lo menos un producto');
                        $('#b_convertir_a_venta').prop('disabled',false);
                        tipo_mov=1;
                    }

                }else{
                    $('#b_convertir_a_venta').prop('disabled',false);
                }
            }else{
                $('#b_convertir_a_venta').prop('disabled',false);
                $('#ch_cliente').prop('checked',true).prop('disabled',true);
                $('#b_buscar_clientes').prop('disabled',false);
                $('#b_historial').prop('disabled',false);
                $('#i_cliente').val('').attr('alt',0).attr('alt2',0);
                $('#i_cliente').prop('readonly',true);
                $('#ta_observaciones').val('');
                mandarMensaje('Debes ingresar un cliente registrado');
                tipo_mov=1;
                
            }
        }

        $('#b_buscar_lineas_filtro').on('click',function(){
            buscaLineas();
        });

        function buscaLineas(){

            var  idFamilia = 102;//$('#i_familia_filtro').attr('alt');

            $('#i_filtro_lineas').val('');
            $('.renglon_lineas').remove();

            $.ajax({

                type: 'POST',
                url: 'php/lineas_buscar_idFamilia.php',
                dataType:"json", 
                data:{'idFamilia':idFamilia},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_lineas').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            
                            var html='<tr class="renglon_lineas" alt="'+data[i].id+'" alt2="' + data[i].descripcion+ '">\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Familia">' + data[i].familia+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_lineas tbody').append(html);   
                            $('#dialog_buscar_lineas').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/lineas_buscar_idFamilia.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar lineas');
                }
            });
        }

        $('#t_lineas').on('click', '.renglon_lineas', function() {
            var idLinea = $(this).attr('alt');
            var linea = $(this).attr('alt2');

            $('#i_linea_filtro').val(linea).attr('alt',idLinea);
            buscarProductos();

            $('#dialog_buscar_lineas').modal('hide');

        });

        $('#ch_cliente').change(function(){

            if($('#ch_cliente').is(':checked')==true){
                $('#b_buscar_clientes').prop('disabled',false);
                $('#b_historial').prop('disabled',false);
                $('#i_cliente').val('').attr('alt',0).attr('alt2',0);
                $('#i_cliente').prop('readonly',true);
                $('#l_cliente').addClass('requerido');
            }else{
                $('#b_buscar_clientes').prop('disabled',true);
                $('#b_historial').prop('disabled',true);
                $('#i_cliente').val('').attr('alt',0).attr('alt2',0);
                $('#i_cliente').prop('readonly',false);
                $('#l_cliente').removeClass('requerido');
            }
        });

        function muestraVendedorVenta(idUs)
        {

            $('#i_vendedor').val('');

            $.ajax({
                type: 'POST',
                url: 'php/usuarios_trabajador_buscar.php',
                dataType:"json", 
                data:{'idUsuario':idUs},

                success: function(data) {
                    
                    if(data.length!=0){
                        $('#i_vendedor').val(data[0].vendedor);
                    }
                },
                error: function (xhr) {
                    console.log('php/usuarios_trabajador_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar vendedor');
                }
            });
        }

        function muestraVendedor(){
            $('#i_vendedor').val('');


            //alert('Usuario: ' + idUsuario);
            
            $.ajax({
                type: 'POST',
                url: 'php/usuarios_trabajador_buscar.php',
                dataType:"json", 
                data:{'idUsuario':idUsuario},

                success: function(data) {
                    
                    if(data.length!=0){
                        $('#i_vendedor').val(data[0].vendedor);
                    }
                },
                error: function (xhr) {
                    console.log('php/familias_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar familias');
                }
            });
        }
        
    });

</script>

</html>