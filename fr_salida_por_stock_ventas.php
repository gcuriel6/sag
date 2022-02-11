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
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        height:170px;
        overflow:auto;
    }
    #dialog_buscar_productos > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    #dialog_buscar_salidas_stock > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    .boton_eliminar{
        width:50px;
    }
    .leyenda_almacenes{
        float:right; 
        color:green; 
        font-size:13px;
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
        #dialog_buscar_productos > .modal-lg{
            max-width: 100%;
        }
        #dialog_buscar_salidas_stock > .modal-lg{
            max-width: 100%;
        }
        .boton_eliminar{
            width:100%;
        }
    }
    .titulo_ban{
        background:#9A2E34;
    }
    .tr_totales th{
        border:none;
        background:rgba(231,243,245,0.6);
        font-weight:bold;
        font-size:11px;
        text-align:right;
    }
    .tr_totales th input{
        font-weight:bold;
        font-size:11px;
        text-align:right;
        margin-right:10px;
        padding-right:10px;
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">SALIDA POR VENTAS</div>
                    </div>
                    
                   
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Ventas</button>   
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_imprimir" disabled><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                    </div>
                </div>

                <form id="forma_salida_stock" name="forma_salida_stock">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <label for="i_folio" class="col-sm-12 col-md-2 col-form-label">Folio </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" id="i_folio" name="i_folio" class="form-control form-control-sm" autocomplete="off" readonly>
                                    <input type="hidden" id="i_num_movimiento" name="i_num_movimiento" class="form-control form-control-sm" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <h4><span id='i_fecha' class="badge badge-secondary" ></span></h4>
                            <input type="hidden" id="i_fecha" name="i_fecha" class="form-control form-control-sm" autocomplete="off" readonly>
                        </div>
                        
                        
                        <div class="col-md-5">
                            <div class="row">
                                <label for="i_tipo_salida" class="col-sm-12 col-md-3 col-form-label">Concepto </label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" id="i_tipo_salida" name="i_tipo_salida" value="S07 Salida por Venta" class="form-control form-control-sm" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <div class="row">
                                <label for="s_id_unidades" class="col-sm-12 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                                <div class="col-sm-12 col-md-12">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <label for="s_id_sucursales" class="col-sm-12 col-md-12 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-12 col-md-12">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <label for="s_id_area" class="col-md-12 col-form-label requerido">Área </label>
                                <div class="col-md-12">
                                    <select id="s_id_area" name="s_id_area" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <label for="s_id_departamento" class="col-md-10 col-form-label requerido">Departamento </label>
                                <div class="col-md-12">
                                    <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm validate[required]" autocomplete="off" disabled></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_observaciones" class="col-form-label col-sm-12 col-md-2 requerido">Observaciones </label>
                        <div class="col-sm-12 col-md-10">
                            <input type="text" id="i_observaciones" name="i_observaciones" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                        </div>
                    </div>
                </form>
                

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_productos"><i class="fa fa-search" aria-hidden="true"></i> Buscar Productos</button>
                    </div>
                </div>

                <div class="card">
                   
                    <div class="card-body">
                    <form id="form_partidas" name="form_partidas">
                            <div class="row">
                                <div class="col-sm-12 col-md-2">
                                    <label for="i_producto" class="col-form-label requerido">Catálogo </label>
                                    <div class="input-group col-sm-12 col-md-12">
                                        <input type="text" id="i_producto" name="i_producto" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    </div> 
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="i_familia" class="col-form-label requerido">Familia </label>
                                    <input type="text" id="i_familia" name="i_familia" class="form-control form-control-sm validate[required]" readonly autocomplete="off"/>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="i_linea" class="col-form-label requerido">Linea </label>
                                    <input type="text" id="i_linea" name="i_linea" class="form-control form-control-sm validate[required]" readonly autocomplete="off"/>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_concepto" class="col-form-label requerido">Concepto </label>
                                    <input type="text" id="i_concepto" name="i_concepto" class="form-control form-control-sm validate[required]" readonly autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_marca" class="col-form-label requerido">Marca </label>
                                    <input type="text" id="i_marca" name="i_marca" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="i_cantidad" class="col-form-label requerido">Cantidad </label>
                                    <input type="text" id="i_cantidad" name="i_cantidad" class="form-control form-control-sm validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                                <!--<div class="col-sm-12 col-md-5">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="i_precio_venta" class="col-form-label requerido">Precio Unitario </label>
                                            <input type="text" id="i_precio_venta" name="i_precio_venta" class="form-control form-control-sm validate[required,custom[number]] numeroMoneda" autocomplete="off"/>
                                            <input type="hidden" id="i_precio" name="i_precio" class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off"/>
                                        </div>
                                       
                                        <div class="col-md-6">
                                            <label for="i_importe" class="col-form-label requerido">Importe </label>
                                            <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="col-sm-12 col-md-2">
                                    <label for="i_precio_venta" class="col-form-label requerido">Precio Unitario </label>
                                    <input type="text" id="i_precio_venta" name="i_precio_venta" class="form-control form-control-sm validate[required,custom[number]] numeroMoneda" autocomplete="off"/>
                                    <input type="hidden" id="i_precio" name="i_precio" class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off"/>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="i_descuento" class="col-form-label">Descuento </label>
                                    <input type="text" id="i_descuento" name="i_descuento" placeholder="Descuento" class="form-control form-control-sm validate[min[0]] numeroMonedaDecimales izquierda" autocomplete="off">
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <label for="i_iva" class="col-form-label">Iva </label>
                                    <input type="text" id="i_iva" name="i_iva" placeholder="IVA" class="form-control form-control-sm validate[required]" autocomplete="off" value="16">
                                </div>
                                <!--<div class="col-sm-12 col-md-2">
                                    <br>
                                    <button type="button" data-toggle="tooltip" data-placement="top" title="Agregar producto" class="btn btn-success btn-sm form-control" id="b_agregar_producto"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                </div>-->
                            </div>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label for="i_importe" class="col-md-4 col-form-label requerido">Importe </label>
                                        <div class="col-md-7">
                                            <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <button type="button" data-toggle="tooltip" data-placement="top" title="Agregar producto" class="btn btn-success btn-sm form-control" id="b_agregar_producto"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                </div>
                            </div>
                    </form>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Catálogo</th>
                                    <th scope="col">Familia</th>
                                    <th scope="col">Línea</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio Unitario</th>

                                    <th scope="col">Descuento Unitario</th>
                                    <th scope="col">Descuento Total</th>
                                    <th scope="col">% IVA</th>

                                    <th scope="col">Importe Total</th>
                                    <th scope="col" width="50px"></th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_registros">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div> 
                        <table class="tablon">
                        <tfoot>
                            <tr class="tr_totales">
                                <th colspan="11">
                                    <label for="i_descuento_total" class="col-sm-2 col-md-2 col-form-label ">Descuento </label>
                                </th>
                                <th>
                                    <input type="text" id="i_descuento_total" name="i_descuento_total" value="0" readonly class="validate[custom[number]] izquierda"  autocomplete="off"/>
                                </th>
                                <th colspan="1"></th>
                            </tr>
                            <tr class="tr_totales">
                                <th colspan="11">
                                    <label for="i_subtotal" class="col-sm-2 col-md-2 col-form-label ">Subtotal </label>
                                </th>
                                <th>
                                    <input type="text" id="i_subtotal" name="i_subtotal" value="0" readonly class="validate[required,custom[number],min[1]] izquierda"  autocomplete="off"/>
                                </th>
                                <th colspan="1"></th>
                            </tr>
                            <tr class="tr_totales">
                                <th colspan="11">
                                    <label for="i_total_iva" class="col-sm-2 col-md-1 col-form-label ">IVA </label>
                                </th>
                                <th>
                                    <input type="text" value="0" id="i_total_iva" name="i_total_iva" class="validate[required,custom[number],min[0]] izquierda" readonly autocomplete="off"/>
                                </th>
                                <th colspan="1"></th>  
                            </tr>
                            <tr class="tr_totales">
                                <th  colspan="11">
                                    <label for="i_total" class="col-sm-2 col-md-1 col-form-label ">Total </label>
                                </th>
                                <th>
                                    <input type="text" id="i_total" value="0" name="i_total" class="validate[required,custom[number],min[1]] izquierda" readonly autocomplete="off"/>
                                </th>
                                <th colspan="1"></th>
                            </tr>
                            </tfoot>
                        </table> 
                    </div>
                </div>
            <br>
            <!--<div class="row classVC" style="border-top:1px solid #A3CED7;">
                <div class="col-md-8"></div>
                <div class="col-md-1">
                    <label for="i_descuento_total" class="col-form-label">Descuento</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_descuento_total" name="i_descuento_total" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off" readonly>
                </div>
            </div> 
            <div class="row classVC">
                <div class="col-md-8"></div>
                <div class="col-md-1">
                    <label for="i_subtotal" class="col-form-label">Subtotal</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_subtotal" name="i_subtotal" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off" readonly>
                </div>
            </div>  
            
            <div class="row classVC">
                <div class="col-md-3"></div>
                <div class="col-md-5">
                    <div class="row">
                        <label for="" class="col-md-3 col-form-label requerido">Tasa IVA</label>
                        <div class="col-sm-2 col-md-2">
                            16% <input type="radio" name="radio_iva" id="r_16" value="16" checked> 
                        </div>
                        <div class="col-sm-2 col-md-2">
                            8% <input type="radio" name="radio_iva" id="r_8" value="8">
                        </div>
                        <div class="col-sm-4 col-md-3">
                           0% <input type="radio" name="radio_iva" id="r_0" value="0" >
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <label for="i_total_iva" class="col-form-label">Total IVA</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_total_iva" name="i_total_iva" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off" readonly>
                </div>
            </div> 
            
            <div class="row classVC">
                <div class="col-md-8">
                </div>
                <div class="col-md-1">
                    <label for="i_total" class="col-form-label"><strong>TOTAL</strong></label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_total" name="i_total" class="form-control form-control-sm validate[required] numeroMoneda totales"  style="border:2px solid #000;" autocomplete="off" readonly>
                </div>
            </div> -->

            </div> 
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_salidas_stock" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de  Salidas de Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="s_filtro_unidad" class="col-sm-12 col-md-4 col-form-label">Unidad de Negocio </label>
                            <div class="col-sm-12 col-md-7">
                                <select id="s_filtro_unidad" name="s_filtro_unidad" class="form-control" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="s_filtro_sucursal" class="col-sm-12 col-md-4 col-form-label">Sucursal </label>
                            <div class="col-sm-12 col-md-7">
                                <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control fecha" autocomplete="off" readonly disabled>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="i_filtro_salidas_stock" id="i_filtro_salidas_stock" alt="renglon_salidas_stock" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_salidas_stock">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">No. Movimiento</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Usuario Captura</th>
                                    <th scope="col">Partidas</th>
                                    <th scope="col">Importe Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                <div class="input-group col-sm-12 col-md-3">
                    <input type="text" id="i_familia_filtro" name="i_familia_filtro" class="form-control" placeholder="Filtrar Por Familia" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_familia_filtro" style="margin:0px;">
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
                <div class="col-sm-12 col-md-4">
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
                                    <th scope="col">Costo</th>
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

<div id="dialog_buscar_familias" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Familias</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_familias" id="i_filtro_familias" class="form-control filtrar_renglones" alt="renglon_familias" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_familias">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">ID</th>
                            <th scope="col">Clave</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Tallas</th>
                            <th scope="col">Tipo</th>
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='S_POR_VENTA';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    
    var matriz = <?php echo $_SESSION['sucursales']?>;

    var idSalidaVenta = 0;
    var idFamilia = 0;
    //var saldoDisponible = 0;
    //var idPresupuestoEgreso = 0;

    var ivaRequi = '';

    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraAreasAcceso('s_id_area');

        $('#s_id_unidades').change(function(){
            var idUnidadNegocio = $('#s_id_unidades').val();
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
            muestraDepartamentoAreaInternos('s_id_departamento', $('#s_id_sucursales').val(), $('#s_id_area').val());
            muestraAreasAcceso('s_id_area');
            $('#form_partidas input').val('');
            $("#t_registros tr").remove();
        });

    

        $('#s_id_sucursales').change(function(){
           var idSucursal = $('#s_id_sucursales').val();
           var idArea = $('#s_id_area').val();
           $("#s_id_departamento").empty();
           if(idSucursal > 0 && idArea > 0)
            {
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }

            $('#form_partidas input').val('');
            $("#t_registros tr").remove();
        });

       $('#s_id_area').change(function(){
            var idSucursal = $('#s_id_sucursales').val();
            var idArea = $('#s_id_area').val();
            $("#s_id_departamento").empty();
            if(idSucursal > 0 && idArea > 0)
            {
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }
        });
        $('#i_fecha').html(hoy);
        $('#i_fecha').val(hoy);
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#b_buscar_lineas_filtro').prop('disabled',true);

        $('#b_buscar_productos').click(function(){

            $('#i_filtro_producto').val('');

            if(($('#s_id_unidades').val() != null) && ($('#s_id_sucursales').val() != null) && ($('#s_id_area').val() != null) && ($('#s_id_departamento').val() != null))
            {
                var idUnidad = $('#s_id_unidades').val();
                var idSucursal = $('#s_id_sucursales').val();

                $('#t_productos >tbody tr').remove();

                $.ajax({
                    type: 'POST',
                    //url: 'php/productos_buscar_activos_existencia.php',
                    url: 'php/productos_buscar_activos_todos.php',
                    dataType:"json", 
                    data:{
                        'idUnidad':idUnidad,
                        'idSucursal':idSucursal,
                        'idFamilia':0,
                        'idLinea':0,
                        'tipo': 1
                    },
                    success: function(data)
                    {

                        $('#span_unidad').text('Unidad Negocio '+$('#s_id_unidades option:selected').text());
                    
                        for(var i=0; data.length>i; i++)
                        {

                            var producto = data[i];

                            /*
                            GCM - 31/01/2022 - Se agregan variables existenciaTexto y existenciaCantidad por que si es servicio no deja agregar mas de 1, ya que el query retorna 0 en existencia
                            */

                            let existenciaTexto;
                            let existenciaCantidad;

                            if(producto.servicio == 0){
                                existenciaTexto = producto.existencia;
                                existenciaCantidad = producto.existencia;
                            }else{
                                existenciaTexto = "Servicio";
                                existenciaCantidad = 999999;
                            }

                            var html = "<tr class='tr_producto' alt='" + producto.id + "'  alt2='" + producto.concepto+ "' alt3='" + producto.id_familia + "' alt4='" + producto.familia + "' alt5='" + producto.id_linea + "' alt6='" + producto.linea + "' alt7='" + producto.costo + "' alt8='" + producto.descripcion + "' alt9='" + existenciaCantidad + "' alt10='"+producto.precio_venta+"' id_fam='"+producto.id_familia_gasto+"' servicio='"+producto.servicio+"'>";
                            html += "<td data-label='Familia'>" + producto.familia + "</td>";
                            html += "<td data-label='Línea'>" + producto.linea + "</td>";
                            html += "<td data-label='Concepto'>" + producto.concepto + "</td>";
                            html += "<td align='right' data-label='Precio'>" + formatearNumero(producto.costo) +  "</td>";
                            html +="<td data-label='Existencia'>"+ existenciaTexto +"</td>";
                            html += "</tr>";

                            $('#t_productos tbody').append(html);
                        
                        }

                        $('#dialog_buscar_productos').modal('show');

                    },
                    error: function (xhr)
                    {
                        console.log('php/productos_buscar_activos_todos.php-->'+JSON.stringify(xhr));
                        mandarMensaje('* No se encontró información al buscar productos');
                    }
                });
            }else{
                mandarMensaje('Seleccionar Unidad de Negocio, Sucursal, Área y Departamento para buscar información');
            }
        });

        $("#t_productos").on('click','.tr_producto',function(){
            var renglon = $(this);
            idFamilia = $(this).attr('alt3');
            var idProducto = renglon.attr('alt');
            //--> NJES April/07/2020 se quita validación para que puedan agregar un mismo producto 
            //ya que Claudia Regalado necesita agregar partidas en costo 0 y otras con costo del mismo producto
            //if(productosAgregados(idProducto)==''){ 
                var concepto = renglon.attr('alt2');
                var idFamilia = renglon.attr('alt3');
                var familia = renglon.attr('alt4');
                var idLinea = renglon.attr('alt5');
                var linea = renglon.attr('alt6');
                var precio = renglon.attr('alt7');
                var descripcion = renglon.attr('alt8');
                var existencia = renglon.attr('alt9');
                var precioVenta = renglon.attr('alt10');
                var idFamiliaGasto = renglon.attr('id_fam');
                var servicio = $(this).attr('servicio');

                //-->NJES April/08/2020 si el producto no es de tipo servicio verifica que tenga existencia mayor a 0 para que se pueda usar
                if(servicio == 0 && existencia == 0)
                    mandarMensaje('El producto no se puede agregar si no tiene existencia cuando no es un servicio.');
                else
                {
                    $('#i_producto').attr('alt',idProducto).attr('alt2',descripcion).attr('alt4',idFamiliaGasto).attr('servicio',servicio).val(idProducto);
                    $('#i_linea').attr('alt',idLinea).val(linea);  
                    $('#i_familia').attr('alt',idFamilia).attr('alt2',idFamiliaGasto).val(familia);
                    $('#i_concepto').val(concepto);
                    $('#i_precio').val(formatearNumero(precio));
                    $('#i_precio_venta').val(formatearNumero(precioVenta));
                    $('#i_cantidad').attr('alt',existencia).val(1).removeAttr('class').addClass('form-control form-control-sm validate[required,custom[number],min[1],max['+existencia+']]');
                    //NJES Jan/16/2020 permitir poner decimales y que el valor minimo no sea 1, puede ir por ejemplo 0.2
                    // $('#i_cantidad').attr('alt',existencia).val(1);
                    $('#i_importe').val(formatearNumero(0.00));
                    $('#form_partidas').validationEngine('hide');
                    $('#dialog_buscar_productos').modal('hide');
                }
            //}else{
            //    mandarMensaje('Este producto ya fue agregado intenta con otro');
            //}
            
                      
        });

        function  productosAgregados(idProducto){
            var encontrado='';
            $('#t_registros tbody tr').each(function(){
                
                var idProductoA=$(this).attr('producto');
                if(idProducto==idProductoA){
                    encontrado='SI';
                }
            });
            
            return encontrado;
        }

        $('#b_buscar_familia_filtro').on('click',function(){
            buscaFamilias();
        });

        function buscaFamilias(){
            $('#i_filtro_familias').val('');
            $('.renglon_familias').remove();

            $.ajax({

                type: 'POST',
                url: 'php/familias_buscar.php',
                dataType:"json", 
                data:{'estatus':0},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_familias').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='inactivo';
                            }else{
                                inactivo='Activa';
                            }

                            var html='<tr class="renglon_familias" alt="'+data[i].id+'" alt2="'+data[i].descripcion+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Tallas">' + data[i].tallas+ '</td>\
                                        <td data-label="Tipo">' + data[i].tipo+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_familias tbody').append(html);   
                            $('#dialog_buscar_familias').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información al buscar familias');
                }

                },
                error: function (xhr) {
                    console.log('php/familias_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información');
                }
            });
        }

        $('#t_familias').on('click', '.renglon_familias', function() {
            var  idFamilia = $(this).attr('alt');
            var  familia = $(this).attr('alt2');

            $('#i_familia_filtro').attr('alt',idFamilia).val(familia);
            buscarProductos();
            $('#b_buscar_lineas_filtro').prop('disabled',false);
                        
            $('#dialog_buscar_familias').modal('hide');

        });

        $('#b_buscar_lineas_filtro').on('click',function(){
            buscaLineas();
        });

        function buscaLineas(){

            var  idFamilia = $('#i_familia_filtro').attr('alt');

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
                    mandarMensaje('* No se encontró información al buscar líneas');
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

        function buscarProductos(){
            $('#t_productos >tbody tr').remove();

            $.ajax({
                type: 'POST',
                //url: 'php/productos_buscar_activos_existencia.php',
                url: 'php/productos_buscar_activos_todos.php',
                dataType:"json", 
                data:{
                    'idUnidad':$('#s_id_unidades').val(),
                    'idSucursal':$('#s_id_sucursales').val(),
                    'idFamilia':$('#i_familia_filtro').attr('alt'),
                    'idLinea':$('#i_linea_filtro').attr('alt')
                },
                success: function(data) {
                    console.log(JSON.stringify(data));
                    if(data.length != 0){
                    
                        for(var i=0;data.length>i;i++){

                            var producto = data[i];
                            ///llena la tabla con renglones de registros
                            
                            var html = "<tr class='tr_producto' alt='" + producto.id + "'  alt2='" + producto.concepto+ "' alt3='" + producto.id_familia + "' alt4='" + producto.familia + "' alt5='" + producto.id_linea + "' alt6='" + producto.linea + "' alt7='" + producto.costo + "' alt8='" + producto.descripcion + "' alt9='"+producto.existencia+"' id_fam='"+producto.id_familia_gasto+"' servicio='"+producto.servicio+"'>";
                                html += "<td data-label='Familia'>" + producto.familia + "</td>";
                                html += "<td data-label='Línea'>" + producto.linea + "</td>";
                                html += "<td data-label='Concepto'>" + producto.concepto + "</td>";
                                html += "<td align='right' data-label='Precio'>" + formatearNumero(producto.costo) +  "</td>";
                                html +="<td data-label='Existencia'>"+ producto.existencia +"</td>";
                                html += "</tr>";
                            ///agrega la tabla creada al div 
                            $('#t_productos tbody').append(html);   
                                
                        }
                    }else{

                        mandarMensaje('No se encontró información');
                    }

                },
                error: function (xhr) {
                    console.log('php/productos_buscar_activos_todos.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar productos');
                }
            });
        }

        $(document).ready(function()
        {

            $('#i_precio_venta,#i_descuento').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 4);
            });

        });

        $('#i_precio_venta,#i_cantidad,#i_descuento').on('change',function(){

            if($(this).validationEngine('validate')==false) {

                var precio=quitaComa($('#i_precio_venta').val());
                var cantidad=$('#i_cantidad').val();

                if($('#i_descuento').val() != '')
                    var descuento = quitaComa($('#i_descuento').val());
                else
                    var descuento = 0;
                
                if(precio==''){
                    precio=0;
                }

                if(precio > 0){
                    
                    $('#i_importe').val(formatearNumero(parseInt(cantidad)*(parseFloat(precio)-parseFloat(descuento))));
                   
                }else{
                    $('#i_importe').val(0);
                }
            }else{
            $('#i_importe').val(0);
            }
        });

        (function($) {
            $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                }
            });
            };
        }(jQuery));

        $("#i_iva").inputFilter(function(value)
        {
            return /^\d*$/.test(value) && (value === "" || parseInt(value) == 0 || parseInt(value) == 8 || parseInt(value) == 1 || parseInt(value) == 16);
        });

        $('#b_agregar_producto').click(function(){
            $('#b_agregar_producto').prop('disabled',true);

            if($('#form_partidas').validationEngine('validate'))
            {
                var idProducto = $('#i_producto').attr('alt');
                var id = $('#i_producto').val();
                var idLinea =  $('#i_linea').attr('alt');
                var linea = $('#i_linea').val();
                var idFamilia = $('#i_familia').attr('alt');
                var idFamiliaGasto = $('#i_familia').attr('alt2');
                var familia = $('#i_familia').val();
                var concepto = $('#i_concepto').val();
                var cantidad = $('#i_cantidad').val();
                var precio = $('#i_precio').val();
                var precioVenta = $('#i_precio_venta').val();
                var importe = $('#i_importe').val();
                var descripcion = $('#i_producto').attr('alt2');
                var marca = $('#i_marca').val();
                var existencia = $('#i_cantidad').attr('alt');
                var servico = $('#i_producto').attr('servicio');

                var iva = $('#i_iva').val();
                if($('#i_descuento').val() != '')
                    var descuento = $('#i_descuento').val();
                else
                    var descuento = 0;

                //-->NJES April/08/2020 verifica la existencia de un producto segun las partidas
                var verificaE = verificaExistencia(idProducto,cantidad,existencia);
                if(servico == 0 && verificaE > 0)
                {
                    mandarMensaje('El producto: '+concepto+' catálogo '+id+' requiere una cantidad de '+cantidad+', lleva '+verificaE+' agregados y tiene una existencia de '+existencia);
                    $('#b_agregar_producto').prop('disabled',false);
                }else{
                    //-->validar que el descuento no sea mayor al precio 
                    if($('#i_descuento').val() == '' || ($('#i_descuento').val() != '' && (parseFloat(quitaComa($('#i_descuento').val())) <= parseFloat(quitaComa($('#i_precio_venta').val())))))
                    {
                        //-->permitir mezclar partidas con porcentaje de IVA del 0% y 16% o del 0% y 8%
                        if(ivaRequi=='' || (parseInt(ivaRequi)==parseInt($('#i_iva').val()) || parseInt($('#i_iva').val()) == 0))
                        {
                            if(parseInt(iva) != 0)
                                ivaRequi=iva;

                            var precioAct = parseFloat(quitaComa(precioVenta))-parseFloat(quitaComa(descuento));
                            var descuentoTotal = parseFloat(quitaComa(cantidad))*parseFloat(quitaComa(descuento));

                            var html = "<tr class='partida' producto='" + idProducto + "' servicio='"+servico+"' concepto='" + concepto+ "' id_familia='" + idFamilia + "' familia='" + familia + "' id_linea='" + idLinea + "' linea='" + linea + "' precio='" + precio + "' precioVenta='" + precioAct + "' cantidad='" +  cantidad + "' descripcion='" + descripcion + "' importe='" + importe + "' descuento='"+quitaComa(descuento)+"' descuento_total='"+descuentoTotal+"' iva='" + iva + "' marca='"+marca+"' existencia='"+existencia+"' fam_gasto='"+idFamiliaGasto+"'>";
                            html += "<td data-label='CATÁLOGO'>" + id + "</td>";
                            html += "<td data-label='FAMILIA'>" + familia + "</td>";
                            html += "<td data-label='LÍNEA'>" + linea + "</td>";
                            html += "<td data-label='CONCEPTO'>" + concepto + "</td>";
                            html += "<td data-label='MARCA'>" + marca + "</td>";
                            html += "<td align='right' data-label='CANTIDAD'>" + cantidad + "</td>";
                            html += "<td align='right' data-label='PRECIO UNITARIO'>" + formatearNumero(precioAct) + "</td>";
                            html += "<td align='right'>" + descuento + "</td>";
                            html += "<td align='right'>" + descuentoTotal + "</td>";
                            html += "<td align='right'>" + iva + "</td>";
                            html += "<td data-label='IMPORTE'>" + formatearNumero(importe) + "</td>";

                            html += "<td class='boton_eliminar'><button type='button' class='btn btn-danger btn-sm form-control' id='b_eliminar' alt='" + idProducto + "'><i class='fa fa-remove' style='font-size:10px;' aria-hidden='true'></i></button></td>";

                            html += "</tr>";

                            $('#t_registros tbody').append(html);

                            $('#form_partidas input').val('');
                            
                            //$('#i_cantidad').removeAttr('class');
                            //$('#i_cantidad').addClass('form-control form-control-sm validate[required,custom[number],min[0.01],max[0.01]]');

                            $('#b_agregar_producto').prop('disabled',false);
                            calcularTotal();
                        }else{
                            mandarMensaje('Debes ingresar productos con la misma TASA IVA: '+ivaRequi+' ó 0');
                            
                            $('#b_agregar_producto').prop('disabled',false);
                        }
                    }else{
                        $('#b_agregar_producto').prop('disabled',false);
                        mandarMensaje('El descuento no debe ser mayor al precio');
                    }
                }
            }else{
                $('#b_agregar_producto').prop('disabled',false);
            }
        });

            //**************ELIMINAR PARTIDAS************** */
        $(document).on('click','#b_eliminar',function(){
            $(this).parent().parent().remove();
            calcularTotal();

            if($('#t_registros .partida').length==0){
                ivaRequi='';
            }

            var iva0 = 0;
            $('#t_registros .partida').each(function(){
                if(parseInt($(this).attr('iva')) == 0)
                    iva0 ++;
            });

            //-->si quedan solo partidas con iva 0 permitir agregar nueva iva con 8 ó 16, ó igual seguir con 0
            if(iva0 == $('#t_registros .partida').length)
                ivaRequi='';
        });

            //****************EDITAR PARTIDAS***************** */
        $("#t_registros").on('dblclick',".partida",function(){
            if($('#i_producto').val() == '')
            {
                var idProducto = $(this).attr('producto');
                var idLinea = $(this).attr('id_linea');
                var linea = $(this).attr('linea');
                var idFamilia = $(this).attr('id_familia');
                var idFamiliaGasto = $(this).attr('fam_gasto');
                var familia = $(this).attr('familia');
                var concepto = $(this).attr('concepto');
                var descripcion =$(this).attr('descripcion');
                var cantidad = $(this).attr('cantidad');
                var precio = $(this).attr('precio');
                var precioVenta = $(this).attr('precioVenta');
                var importe = $(this).attr('importe');
                var marca = $(this).attr('marca');
                var existencia = $(this).attr('existencia');
                //idPresupuestoEgreso = $(this).attr('idPE');

                $('#i_producto').attr('alt',idProducto).attr('alt2',descripcion).val(idProducto);
                $('#i_linea').attr('alt',idLinea).val(linea);  
                $('#i_familia').attr('alt',idFamilia).attr('alt2',idFamiliaGasto).val(familia);
                $('#i_concepto').val(concepto);
                $('#i_cantidad').attr('alt',existencia).val(cantidad).removeAttr('class').addClass('form-control form-control-sm validate[required,custom[number],min[1],max['+existencia+']]');
                //NJES April/07/2020 permitir poner decimales y que el valor minimo no sea 1, puede ir por ejemplo 0.2
                // $('#i_cantidad').attr('alt',existencia).val(formatearNumero(cantidad));
                $('#i_precio').val(formatearNumero(precio));
                $('#i_precio_venta').val(formatearNumero(precioVenta));
                $('#i_importe').val(formatearNumero(importe));
                $('#i_marca').val(marca);

                $('#i_descuento').val($(this).attr('descuento'));
                $('#i_iva').val($(this).attr('iva'));

                var iva16 = 0;
                var iva8 = 0;
                var iva0 = 0;

                if($('#t_registros .partida').length > 1)
                {
                    
                    $('#t_registros .partida').each(function(){
                        if(parseInt($(this).attr('iva')) == 16)
                            iva16 ++;

                        if(parseInt($(this).attr('iva')) == 8)
                            iva8 ++;
                        
                        if(parseInt($(this).attr('iva')) == 0)
                            iva0 ++;
                    });

                    //-->no actualizar la variable iva cuando el productos es de iva 0
                    if(parseInt($(this).attr('iva')) != 0)
                    {
                        if(((iva16 == 1 || iva8 == 1) && (iva0+iva16 == $('#t_registros .partida').length || iva0+iva8 == $('#t_registros .partida').length)) || (iva0 == $('#t_registros .partida').length)) 
                        {    
                            ivaRequi='';
                        }else{
                            ivaRequi=$(this).attr('iva');
                        }
                    }
                    
                }else
                    ivaRequi='';

                $(this).remove();
                calcularTotal();

            }else{
                mandarMensaje('Debes agregar primero el producto actual');
            }
        });

        $('input[name=radio_iva]').on('change',function(){
            
            calcularTotal();
            
        });


        //**************CALCULA TOTAL************** */
        function calcularTotal(){
           

            var subtotal = 0;
            //var tasaIva = 0;
            var totalIva = 0;
            var descuentoTotal = 0;

            tasaIva = $('input[name=radio_iva]:checked').val();
            

            $("#t_registros .partida").each(function() {
                var importe = quitaComa($(this).attr('importe'));
                var iva = parseInt($(this).attr('iva'));
                var descuento = parseFloat($(this).attr('descuento_total'));
                
                subtotal = subtotal+parseFloat(importe);
                totalIva += ((importe/100) * iva);
                descuentoTotal += descuento;
            });

            var total = parseFloat(subtotal)+parseFloat(totalIva);

            $('#i_total_iva').val(formatearNumero(totalIva));
            $('#i_descuento_total').val(formatearNumero(descuentoTotal));
            $('#i_subtotal').val(formatearNumero(subtotal));
            $('#i_total').val(formatearNumero(total));

        }

            //****************OBTENER PARTIDAS***************** */
        function obtenerPartidas(){

            var j = 0;
            var arreDatos = [];

            $("#t_registros .partida").each(function() {
            
                var idProducto = $(this).attr('producto');
                var concepto = $(this).attr('concepto');
                var descripcion =$(this).attr('descripcion');
                var cantidad = quitaComa($(this).attr('cantidad'));
                var precio = quitaComa($(this).attr('precio'));
                var precioVenta = quitaComa($(this).attr('precioVenta'));
                var importe = quitaComa($(this).attr('importe'));
                var marca = $(this).attr('marca');
                var idFamiliaGasto = $(this).attr('fam_gasto');

                var descuento = $(this).attr('descuento');
                var iva = $(this).attr('iva');

                j++;

                arreDatos[j] = {
                    'idProducto' : idProducto,
                    'concepto' : concepto,
                    'descripcion' : descripcion,
                    'cantidad' : cantidad,
                    'precio' : precio,
                    'precioVenta' : precioVenta,
                    'importe' : importe,
                    'marca' : marca,
                    'idFamiliaGasto':idFamiliaGasto,
                    'descuento':descuento,
                    'iva_d':iva
                };
            });

            arreDatos[0] = j;
            return arreDatos;
        }

        $('#b_nuevo').click(function(){
            limpiar();
        });

        $('#b_guardar').click(function(){
            $('#b_guardar').prop('disabled',true);
           
            if ($('#forma_salida_stock').validationEngine('validate')){
                if($('#t_registros .partida').length > 0)
                {
                    if($('#i_producto').val() == ''){
                        guardar();
                    }else{
                        mandarMensaje('Para guardar debes agregar el producto que esta en edición');
                        $('#b_guardar').prop('disabled',false);
                    }
                   
                }else{
                    mandarMensaje('Debe existir por lo menos un producto para generar la salida de stock');
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardar(){

            //S07 = Salida de ventas Stock
            var datos = {
                'tipoSalida':'S07',
                'idSalida':idSalidaVenta,
                'folio':$('#i_num_movimiento').val(),
                'folioVenta':$('#i_folio').val(),
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'idSucursal':$('#s_id_sucursales').val(),
                'fecha':$('#i_fecha').val(),
                'idUsuario':idUsuario,
                'noPartidas': $('#t_registros .partida').length,
                'usuario':usuario,
                'idDepartamento':$('#s_id_departamento').val(),
                'idArea':$('#s_id_area').val(),
                'iva' : $('input[name=radio_iva]:checked').val(),
                //-->NJES August/25/2020 agregar observacion en salida por venta
                'observacion' : $('#i_observaciones').val(),
                'detalle':obtenerPartidas()
            };

            $.ajax({
                type: 'POST',
                url: 'php/almacen_salidas_guardar.php',
                data:  {'datos':datos},
                success: function(data) {
                    console.log(data);
                    if(data > 0 )
                    { 
                        mandarMensaje('El registro con folio: '+data+' se guardó correctamente');
                        limpiar();
                    
                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/almacen_salidas_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        $('#b_buscar').click(function(){
            muestraSelectUnidades(matriz,'s_filtro_unidad',$('#s_id_unidades').val());
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_id_unidades').val(),modulo,idUsuario);
            $('form').validationEngine('hide');
            $('#i_filtro_salidas_stock').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('').prop('disabled',true);
            $('.renglon_salidas_stock').remove();
            $('#dialog_buscar_salidas_stock').modal('show');

        });

        $(document).on('change','#s_filtro_unidad',function(){
            if($('#s_filtro_unidad').val()!= ''){
                $('.img-flag').css({'width':'50px','height':'20px'});
            }
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);

            $('#i_filtro_salidas_stock').val('');
            $('#i_fecha_inicio').val('').prop('disabled',false);
            $('#i_fecha_fin').val('').prop('disabled',true);
            $('.renglon_salidas_stock').remove();

        });

        $(document).on('change','#s_filtro_sucursal',function(){
            buscarSalidasDeStock($('#s_filtro_unidad').val());
        });

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscarSalidasDeStock($('#s_filtro_unidad').val());
            }
        });

        $('#i_fecha_fin').change(function(){
            buscarSalidasDeStock($('#s_filtro_unidad').val());
        });

        function buscarSalidasDeStock(idUnidadNegocio){
            $('.renglon_salidas_stock').remove();

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idUnidadNegocio': idUnidadNegocio,
                'idSucursal':$('#s_filtro_sucursal').val(),
                'tipoSalida':'S07'
            }; 

            $.ajax({

                type: 'POST',
                url: 'php/almacen_salidas_busca_ventas_stock.php',
                dataType:"json", 
                data:{'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_salidas_stock" alt="'+data[i].id+'" alt2="'+data[i].id_unidad_negocio+'" alt3="'+data[i].id_sucursal+'" area="'+data[i].id_area+'" subtotal="'+data[i].subtotal+'" total_iva="'+data[i].total_iva_d+'" importe_total="'+data[i].importe_total_d+'" descuento_total="'+data[i].descuento_total_d+'">\
                                        <td data-label="No. Movimiento">' + data[i].folio_venta+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="Usuario Captura">' + data[i].usuario+ '</td>\
                                        <td data-label="Partidas">' + data[i].partidas+ '</td>\
                                        <td data-label="Importe Total">' + formatearNumero(data[i].importe_total_d)+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_salidas_stock tbody').append(html);   
                              
                        }
                    }else{

                            mandarMensaje('No se encontró información');
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/almacen_salidas_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar');
                }
            });
        }

        $('#t_salidas_stock').on('click', '.renglon_salidas_stock', function() {
            muestraSucursalesPermiso('s_id_sucursales',$(this).attr('alt2'),modulo,idUsuario);
            idSalidaVenta = $(this).attr('alt');
            var idArea = $(this).attr('area');
            var idSucursal = $(this).attr('alt3');

            var subtotal = $(this).attr('subtotal');
            var total_iva = $(this).attr('total_iva');
            var importe_total = $(this).attr('importe_total');
            var descuento_total = $(this).attr('descuento_total');
            
            $('#i_subtotal').val(formatearNumero(subtotal));
            $('#i_total_iva').val(formatearNumero(total_iva));
            $('#i_total').val(formatearNumero(importe_total));
            $('#i_descuento_total').val(formatearNumero(descuento_total));

            $('#dialog_buscar_salidas_stock').modal('hide');
            muestraRegistro(idSalidaVenta);
            muestraRegistroDetalle(idSalidaVenta); 
            $('#b_guardar,#b_agregar_producto,#b_buscar_productos,#b_buscar_departamento').prop('disabled',true);
            $('#b_imprimir').prop('disabled',false);
            $('#forma_salida_stock').find(' input,select').prop('disabled',true);
            $('#form_partidas input').prop('disabled',true);
            muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
        });

        function muestraRegistro(idSalidaVenta){
            $.ajax({
                type: 'POST',
                url: 'php/almacen_salidas_buscar_id.php',
                dataType:"json", 
                data:{
                    'idSalida':idSalidaVenta
                },
                success: function(data) {
                    if(data.length > 0){
                        
                        $('#i_num_movimiento').val(data[0].folio);
                        $('#i_folio').val(data[0].folio_venta_stock);
                        $('#i_fecha').val(data[0].fecha);
                        $('#i_area').val(data[0].area);
                        $('#i_supervisor').val(data[0].supervisor);
                        //-->NJES August/25/2020 agregar observacion en salida por venta
                        $('#i_observaciones').val(data[0].observacion);

                        $('#s_id_unidades').val(data[0].id_unidad_negocio);
                        $("#s_id_unidades").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                        if(data[0].id_sucursal != 0)
                        {
                            $('#s_id_sucursales').val(data[0].id_sucursal);
                            $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_id_sucursales').val('');
                            $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
                        }

                        if(data[0].id_area != 0)
                        {
                            $('#s_id_area').val(data[0].id_area);
                            $('#s_id_area').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_id_area').val('');
                            $('#s_id_area').select2({placeholder: 'Selecciona'});
                        }

                        if(data[0].id_departamento != 0)
                        {
                            $('#s_id_departamento').val(data[0].id_departamento);
                            $('#s_id_departamento').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_id_departamento').val('');
                            $('#s_id_departamento').select2({placeholder: 'Selecciona'});
                        }

                        /*$('input[name=radio_iva]').prop('checked',false); 

                        if(parseInt(data[0].iva) == 16){
                            $('#r_16').prop('checked',true);
                        }else if(parseInt(data[0].tasaIva) == 8){
                            $('#r_8').prop('checked',true);
                        }else{
                            $('#r_0').prop('checked',true);
                        }*/

                        if(data[0].iva_m != 0)
                            ivaRequi = data[0].iva_m;
    
                    }
                    
                },
                error: function (xhr) 
                {
                    console.log('php/almacen_salidas_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al mostrar registros');
                }
            });
        }

        function muestraRegistroDetalle(idSalidaVenta){
            $('#t_registros tbody').empty();
            $.ajax({
                type: 'POST',
                url: 'php/almacen_salidas_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idSalida':idSalidaVenta
                },
                success: function(data)
                {
                    for(var i=0; data.length>i; i++)
                    {
                        var importe= parseFloat(data[i].cantidad)*parseFloat(data[i].precio_venta);
                        var html = "<tr class='partida_SA' producto='" + data[i].id_producto + "' concepto='" + data[i].concepto+ "' id_familia='" + data[i].id_familia + "' familia='" + data[i].familia + "' id_linea='" + data[i].id_linea + "' linea='" + data[i].linea + "' precio='" + data[i].precio + "' precioVenta='" + data[i].precioVenta + "' descuento='"+data[i].descuento+"' iva='"+data[i].iva+"' cantidad='" +  data[i].cantidad + "' descripcion='" + data[i].descripcion + "' importe='" + importe + "' marca='"+data[i].marca+"'>";
                            html += "<td data-label='CATÁLOGO'>" + data[i].id_producto + "</td>";
                            html += "<td data-label='FAMILIA'>" + data[i].familia + "</td>";
                            html += "<td data-label='LÍNEA'>" + data[i].linea + "</td>";
                            html += "<td data-label='CONCEPTO'>" + data[i].concepto + "</td>";
                            html += "<td data-label='MARCA'>" + data[i].marca + "</td>";
                            html += "<td align='right' data-label='CANTIDAD'>" + data[i].cantidad + "</td>";
                            html += "<td align='right' data-label='PRECIO UNITARIO'>" + formatearNumero(data[i].precio_venta) + "</td>";
                            html += "<td align='right' data-label='DESCUENTO UNITARIO'>" + formatearNumero(data[i].descuento) + "</td>";
                            html += "<td align='right' data-label='DESCUENTO TOTAL'>" + formatearNumero(parseFloat(data[i].cantidad)*parseFloat(data[i].descuento)) + "</td>";
                            html += "<td align='right' data-label='IVA'>" + formatearNumero(data[i].iva) + "</td>";
                            html += "<td data-label='IMPORTE'>" + formatearNumero(importe) + "</td>";

                            html += "<td class='boton_eliminar'></td>";

                            html += "</tr>";

                        $('#t_registros tbody').append(html);
                       
                    }
         
                },
                error: function (xhr)
                {
                    console.log('php/almacen_salidas_buscar_detalle.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al mostrar detalle');
                }
            });
        }

        $('#b_imprimir').click(function(){
            
            var datos = {
                'path':'formato_almacen_venta_stock',
                'idRegistro':idSalidaVenta,
                'nombreArchivo':'venta',
                'tipo':1,
                'concepto':'S07 Salida por Venta'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new')

        });

        function limpiar(){
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            muestraAreasAcceso('s_id_area');
            $('#i_folio').val('');
            $('#i_num_movimiento').val('');

            $('#form_partidas input').val('');
            $('#s_id_unidades,#s_id_sucursales,#s_id_area').prop('disabled',false);
            $("#t_registros tr").remove();
            $('#b_guardar,#b_agregar_producto,#b_buscar_productos').prop('disabled',false);
            $('#s_id_departamento').prop('disabled',true);

            $('#forma_salida_stock').validationEngine('hide');
            $('#form_partidas').validationEngine('hide');
            $('#form_partidas input').prop('disabled',false);
            $('#b_imprimir').prop('disabled',true);
            $('#s_id_departamento').html('');

            $('#i_subtotal').val('');
            $('#i_total_iva').val('');
            $('#i_total').val('');
            $('#i_observaciones').val('').prop('disabled',false);

            //saldoDisponible = 0;

            $('#i_iva').val(16);
            $('#i_descuento').val('');
            ivaRequi='';
        }

        //-->NJES April/08/2020 verifica la existencia de un producto segun las partidas
        function verificaExistencia(idProducto,cantidad,existencia){
            var bandera = 0;
            var cantidadActual = 0;
            $("#t_registros .partida").each(function() {
                var id_Prod = $(this).attr('producto');
                var cantidad_N = $(this).attr('cantidad');

                if(idProducto == id_Prod)
                {
                    cantidadActual = cantidadActual+parseFloat(quitaComa(cantidad_N));
                }

            });

            var cant = parseFloat(quitaComa(cantidad))+parseFloat(cantidadActual);
            if(cant <= existencia)
                bandera = 0;
            else
                bandera = cantidadActual;

            return bandera; 
        }

    });

</script>

</html>