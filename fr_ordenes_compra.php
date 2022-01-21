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
    #div_principal{
        padding-top:20px;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
   .input_group_span{
        background-color: rgb(96,91,89); 
        color: white;
   }
   #dialog_ordenes_compra > .modal-lg{
        min-width: 90%;
        max-width: 90%;
   }
   #dialog_buscar_productos > .modal-lg{
        min-width: 80%;
        max-width: 80%;
   }
   #dialog_buscar_requisiciones > .modal-lg{
        min-width: 90%;
        max-width: 90%;
   }

   .izquierda { 
        text-align: right; 
    }

   #d_estatus_oc{
       padding-top:7px;
       text-align:center;
       font-weight:bold;
       font-size:15px;
       height:40px;
       vertical-align:middle;
   }

   #b_buscar_oc{
       margin-left:-29px;
       margin-top:0px;
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
        #b_buscar_oc{
            margin-left:0px;
            margin-top:0px;
        }
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

    .Rechazado td{
        background:#F8D7DA;
    }
    .Pendiente td{
        background:#FFF3CD;
    }

</style>

<body>
    <div class="container-fluid" id="div_principal"> <!--div_principal-->

        <div class="row"> <!--div_row-->
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor"> <!--div_contenedor-->
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Orden Compra</div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Limpia campos pantalla" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Guardar/Editar" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Imprime la Orden de compra" class="btn btn-dark btn-sm form-control" id="b_imprimir" ><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Imprime la Orden de compra" class="btn btn-dark btn-sm form-control" id="b_pre_imprimir" ><i class="fa fa-print" aria-hidden="true"></i> Pre-Imprimir</button>
                        <form id="f_imprimir" action="php/imprime_orden_compra.php" method="POST" target="_blank">
                            <input type="hidden" id="i_t_inicio_im" name='texto_inicio'>
                            <input type="hidden" id="i_t_fin_im" name='texto_fin'>
                            <input type="hidden" id="i_registro_im" name='registro'>
                            <input type="hidden" id="i_orden" name='i_orden'>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                </div>
                <br>
                <div class="row">

                    <div class="col-sm-2 col-md-1" style="text-align:rigth;"><strong><label for="i_folio" class="col-form-label">Folio OC</label></strong></div>
                    <div class="col-sm-2 col-md-2">
                            <input type="text" id="i_folio" name="i_folio" readonly class="form-control form-control-sm validate[required]" disabled autocomplete="off"/>
                    </div>
                    <div class="col-sm-12 col-md-1" class="botonBuscar">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Buscar ordenes de compra" class="btn btn-info btn-block form-control" id="b_buscar_oc"><i class="fa fa-search" aria-hidden="true"></i> </button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div id="d_estatus_oc" class="alert"></div>
                    </div>
                   
                    <div class="col-sm-12 col-md-6">
                        
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                Activos Fijos <input type="radio" name="rdb_tipo" id="r_activo" value="0" checked> 
                            </div>
                             <!--<div class="col-sm-12 col-md-3"> MGFS 16-12-2019 issue DEN18-2402
                               Gastos <input type="radio" name="rdb_tipo" id="r_gasto" value="1"> 
                            </div>-->
                            <div class="col-md-auto col-sm-12 col-md-4">
                                Mantenimiento <input type="radio" name="rdb_tipo" id="r_mantenimiento" value="2"> 
                            </div>
                            <div class="col-sm-12 col-md-2">
                                Stock <input type="radio" name="rdb_tipo" id="r_stock" value="3"> 
                            </div>
                        </div>
                    </div>
                    
                </div>

                <form id="form_orden_compra" name="form_orden_compra">
                    <div class="row"> 
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="s_id_unidades" class="col-sm-12 col-md-12 col-form-label requerido">Unidad </label>
                                <div class="col-sm-12 col-md-12">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]"  autocomplete="off"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="s_id_area" class="col-sm-12 col-md-12 col-form-label requerido">Área </label>
                                <div class="col-sm-12 col-md-12">
                                    <select id="s_id_area" name="s_id_area" class="form-control form-control-sm validate[required]" autocomplete="off" readonly></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="l_requisiciones" class="col-sm-12 col-md-12 col-form-label requerido">Requisición </label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="text" id="i_requisiciones" name="i_requisiciones" class="form-control form-control-sm validate[required]" readonly autocomplete="off"/>
                                    <input type="hidden" id="ids_requisiciones" name="ids_requisiciones" />
                             
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row"> 
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="s_id_sucursales" class="col-sm-12 col-md-12 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-12 col-md-12">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="s_id_departamento" class="col-sm-12 col-md-12 col-form-label requerido">Departamento </label>
                                <div class="col-sm-12 col-md-12">
                                    <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm validate[required]" autocomplete="off" readonly></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="i_solicito" class="col-sm-12 col-md-12 col-form-label requerido">Solicitó </label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="text" id="i_solicito" name="i_solicito" disabled class="form-control form-control-sm validate[required]" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                        <label for="i_proveedor" class="col-2 col-md-2 col-form-label requerido">Proveedor </label>
                            <div class="row">
                                
                                <div class="input-group col-sm-12 col-md-10">
                                    <input type="text" id="i_proveedor" name="i_proveedor" class="form-control validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_proveedor" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="b_detalle_proveedor" style="margin:0px;">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                        <label for="i_facturar" class="col-3 col-md-3 col-form-label requerido">Facturar a </label><br>
                            <div class="row">
                               
                                <div class="input-group col-sm-12 col-md-9">
                                    <input type="text" id="i_facturar" name="i_facturar" class="form-control validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_facturar" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2 col-md-2">
                            <label for="i_fecha_pedido" class="col-form-label requerido">Fecha Pedido </label>
                            <input type="text" id="i_fecha_pedido" name="i_fecha_pedido" readonly class="form-control form-control-sm fecha validate[required]" autocomplete="off"/>
                        </div>
                        <div class="col-sm-2 col-md-1"></div>
                        <div class="col-sm-2 col-md-2">
                            <label for="i_tiempo_entrega" class="col-form-label requerido">Tiempo Entrega </label>
                            <input type="text" id="i_tiempo_entrega" name="i_tiempo_entrega" class="form-control form-control-sm validate[required,custom[integer]]" autocomplete="off"/> 
                        </div>
                        <div class="col-sm-2 col-md-1"><br><br>Días</div>
                        <div class="col-sm-2 col-md-2">
                            <label for="i_fecha_entrega" class="col-form-label requerido">Fecha Entrega </label>
                            <input type="text" id="i_fecha_entrega" name="i_fecha_entrega" readonly class="form-control form-control-sm fecha validate[required]" autocomplete="off"/>
                        </div>
                        
                        <div class="col-sm-2 col-md-1"></div>
                        <div class="col-sm-2 col-md-2">
                            <label for="i_condicion_pago" class="col-form-label requerido">Condiciones Pago </label>
                            <input type="text" id="i_condicion_pago" name="i_condicion_pago" class="form-control form-control-sm validate[required,custom[integer]]" autocomplete="off"/> 
                        </div>
                        <div class="col-sm-2 col-md-1"><br><br>Días</div>
                    </div>

                   

                    <div class="row">
                        <div class="col-sm-10 col-md-10">
                            <div class="row">
                                <label for="ta_observaciones_entrega" class="col-sm-12 col-md-3 col-form-label requerido">Observaciones Entrega </label>
                                <div class="col-sm-9 col-md-9">
                                    <textarea  id="ta_observaciones_entrega" name="ta_observaciones_entrega" class="form-control validate[required]" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>   
                </form> <!--datos orden fin-->
                 <hr>  <!--linea gris-->

                <!--<form id="form_editar_producto" name="form_editar_producto">
                    
                    <div class="card">
                    
                        <h5 class="card-header">Productos</h5>
                             <div  class="card-body">

                                <div class="row" ><!-- style="background:rgba(20,136,154,0.1);border-radius:3px;padding:5px;" --
                                 
                                <!-- Datos id requi, producto, clave, familia linea--
                             
                                 <div class="col-sm-2 col-md-2">
                                    <label for="i_id_requi" class="col-form-label requerido">ID Requi </label>
                                    <input type="text" id="i_id_requi" name="i_id_requi" class="form-control form-control-sm validate[required]" value="0" readonly autocomplete="off"/>
                                    <input type="hidden" id="i_tipo_producto" name="i_tipo_producto">
                                </div>

                                <div class="col-sm-2 col-md-6">
                                    <label for="i_producto" class="col-form-label requerido">Producto </label>
                                    <div class="input-group col-sm-10 col-md-10">
                                            <input type="text" id="i_producto" name="i_producto" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <!--<button class="btn btn-primary" type="button" id="b_buscar_productos" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>--
                                            </div>
                                        </div>  
                                </div>
                                
                                <div class="col-sm-12 col-md-2">
                                    <label for="i_linea" class="col-form-label requerido">Línea </label>
                                    <input type="text" id="i_linea" name="i_linea" class="form-control form-control-sm validate[required]" readonly autocomplete="off"/>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="i_familia" class="col-form-label requerido">Familia </label>
                                    <input type="text" id="i_familia" name="i_familia" class="form-control form-control-sm validate[required]" readonly autocomplete="off"/>
                                </div>
                          

                            <!-- Datos concepto descripcion--
                            
                                <div class="col-sm-6 col-md-6">
                                    <label for="i_concepto" class="col-form-label requerido">Concepto </label>
                                    <input type="text" id="i_concepto" name="i_concepto" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="i_descripcion" class="col-form-label requerido">Descripción </label>
                                    <input type="text" id="i_descripcion" name="i_descripcion" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                                </div>
                            <!-- Datos cantidad costo iva descuento--
                                <div class="col-sm-2 col-md-2">
                                    <label for="i_cantidad" class="col-form-label requerido">Cantidad </label>
                                    <input type="text" id="i_cantidad" name="i_cantidad" class="form-control form-control-sm validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <label for="i_costo" class="col-form-label requerido">Costo </label>
                                    <input type="text" id="i_costo" name="i_costo"  class="form-control form-control-sm validate[required,min[0.1]] numeroMoneda" autocomplete="off"/>
                                </div>
                                <div class="col-sm-1 col-md-1">
                                    <label for="i_iva" class="col-form-label requerido">IVA </label>
                                    <input type="text" id="i_iva" name="i_iva" class="form-control form-control-sm validate[required,custom[number],min[0],max[16]]" value="16" autocomplete="off"/>
                                </div>
                                <div class="col-sm-1 col-md-1">
                                    <label for="i_descuento" class="col-form-label requerido">Des% </label>
                                    <input type="text" id="i_descuento" name="i_descuento"  class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off" value="0"/>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <label for="i_importe" class="col-form-label requerido">Importe </label>
                                    <input type="text" id="i_importe" name="i_importe" readonly class="form-control form-control-sm validate[required] numeroMoneda" autocomplete="off"/>
                                </div>
                                <div class="col-sm-1 col-md-1"></div>
                                

                             </div>
                        </div>

                    </div> 


                </form> --><!--datos orden fin-->
                <hr>
                <form id="form_productos">
                <div class="row">
                    <div class="col-sm-4 col-md-4"></div>
                    <div class="col-sm-4 col-md-4">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Importar Requisiciónes Autorizadas" class="btn btn-success btn-sm form-control" id="b_importar_requis"><i class="fa fa-download" aria-hidden="true"></i> Importar Requisiciones</button>
                    </div>
                </div>  

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_partidas">
                        <thead>
                            <tr class="renglon">
                                <th scope="col" width="5%">ID Requi</th>
                                <th scope="col" width="10%">Catálogo</th>
                                <th scope="col" width="10%">Familia</th>
                                <th scope="col" width="10%">Línea</th>
                                <th scope="col" width="20%">Concepto</th>
                                <th scope="col" width="20%">Descripción</th>
                                <th scope="col" width="5%">Cant</th>
                                <th scope="col" width="5%">CostoU</th>
                                <th scope="col" width="5%">Des%</th>
                                <th scope="col" width="5%">IVA%</th>
                                <th scope="col" width="9%">Importe sin/IVA</th>
                                <th scope="col" width="3%">Tallas</th>
                                <!--<th scope="col" width="3%"></th>-->
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col" colspan="13"></th>
                            </tr>
                            <tr class="tr_totales">
                                <th scope="col" colspan="7"></th>
                                <th scope="col" colspan="2">DESCUENTO</th>
                                <th scope="col" colspan="2">
                                    <input type="text" id="i_descuento_total" name="i_descuento_total" readonly class="i_t" autocomplete="off"/>
                                </th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                            <tr class="tr_totales">
                                <th scope="col" colspan="7"></th>
                                <th scope="col" colspan="2">SUBTOTAL</th>
                                <th scope="col" colspan="2">
                                    <input type="text" id="i_subtotal" name="i_subtotal" readonly class="validate[required] i_t" autocomplete="off"/>
                                </th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                            <tr  class="tr_totales">
                                <th scope="col" colspan="7"></th>
                                <th scope="col" colspan="2">IVA</th>
                                <th scope="col" colspan="2">
                                    <input type="text" id="i_total_iva" name="i_total_iva" readonly class="validate[required] i_t" autocomplete="off"/>
                                </th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                            <tr  class="tr_totales">
                                <th scope="col" colspan="7"></th>
                                <th scope="col" colspan="2">TOTAL</th>
                                <th scope="col" colspan="2">
                                    <input type="text" id="i_total" name="i_total" readonly class="validate[required] i_t" autocomplete="off"/>
                                </th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                        </tfoot>
                        </table>  
                    </div>
                </div>
                </form>
                <br><br><br>
            </div>
        </div>  
    </div>
</body> 

 <div id="dialog_ordenes_compra" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Órdenes de Compra</h5>
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
                    </div>
                    <label for="s_filtro_sucursal" class="col-sm-12 col-md-1 col-form-label">Sucursal</label>
                    <div class="col-sm-12 col-md-3">
                        <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control filtros" placeholder="Sucursal" autocomplete="off" style="width:100%;"></select>
                    </div> 
                </div>       
                <div class="row">
                    <div class="col-sm-12 col-md-2">
                    <input type="text" name="i_filtro_1" id="i_filtro_1" alt="i_filtro1" alt2="1" alt3="renglon_orden_compra" alt4="2" class="form-control filtrar_campos_renglones" placeholder="Folio" autocomplete="off">
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <input type="text" name="i_filtro_2" id="i_filtro_2" alt="i_filtro2" alt2="2" alt3="renglon_orden_compra" alt4="2" class="form-control filtrar_campos_renglones" placeholder="Proveedor" autocomplete="off">
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
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
                    </div>
                    
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_ordenes_compra">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha Pedido</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Partidas</th>
                                    <th scope="col">Total</th>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
 
<div id="dialog_proveedores" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Proveedores</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_proveedor" id="i_filtro_proveedor" alt="renglon_proveedor" class="filtrar_renglones form-control filtrar_renglones" alt="renglon_razon_social_emisora" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_proveedores">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Proveedor</th>
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
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_empresa_fiscal" id="i_filtro_empresa_fiscal" class="form-control filtrar_renglones" alt="renglon_empresa_fiscal" placeholder="Filtrar" autocomplete="off"></div>
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

<div id="dialog_buscar_productos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Buscar Produtos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_producto_b" id="i_filtro_producto_b" class="form-control filtrar_renglones" alt="producto-partida" placeholder="Filtrar" autocomplete="off"></div>
                </div>
                <br>    
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_productos">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Familia</th> 
                                <th scope="col">Línea</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Ultimo costo de Compra</th>
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

<div id="dialog_buscar_requisiciones" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Requisiciones <label id="l_tipo_requi"></label></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_requisiciones" id="i_filtro_requisiciones" class="form-control filtrar_renglones" alt="requisicion-partida" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_requisiciones">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Unidad Negocio</th> 
                                <th scope="col">Clave Suc</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Area</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Estatus Proveedor</th>
                                <th scope="col">Folio</th>
                                <th scope="col">Descripción General</th> 
                                <th scope="col">Importe Total</th>
                                <th scope="col" id="thM">No Económico</th>
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

<div id="dialog_agregar_tallas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Tallas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
               <div class="col-sm-12 col-md-6 tallas_oculto">    
                     <label for="i_t_total">Total de Productos</label>
                    <input type="text" text-align="center" id="i_t_total" name="i_t_total" class="form-control izquierda" readonly >
                    <input type="hidden" text-align="center" id="i_t_total_a" name="i_t_total_a" value="0" class="form-control">
                    <input type="hidden" text-align="center" id="i_t_numero_partida" name="i_t_numero_partida" class="form-control"  >                    
                    <datalist id="lista_tallas"></datalist>
                    <label for="i_t_talla">Talla</label>
                    <input type="text" id="i_t_talla" name="lista_tallas"  list="lista_tallas" class="form-control" autocomplete="off">
                    <label for="i_t_cantidad">Cantidad</label>
                    <input type="text" id="i_t_cantidad" name="i_t_cantidad" class="form-control izquierda" autocomplete="off">
                    <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar_talla"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                    </div>
                <div class="col-sm-12 col-md-6 tallas_oculto" style='overflow:auto; max-height:280px;'>
                        <table class="tablon"  id="t_tallas_solicitadas">
                        <thead>
                            <tr class="renglon">
                                <th scope="col" colspan="2">Tallas Solicitadas en Requi</th> 
                            </tr>
                            <tr class="renglon">
                                <th scope="col">Talla</th> 
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>  
                    </div>
            </div>    
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_tallas">
                      <thead>
                        <tr class="renglon">
                            <th scope="col">Talla</th> 
                            <th scope="col">Cantidad</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                    <button type="button" class="btn btn-success btn-sm form-control tallas_oculto" id="b_guardar_talla"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_proveedores_datos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos Proveedor: <span id="nombre_proveedor"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_proveedor"></div>
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
 
    var idOrdenCompra=0;
    var tipoMov=0;
    var modulo='ORDEN_COMPRA';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var estatus = 'A';
 
    var idProveedorF = 0;
    var totalPartidas = 0;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var noEconomicoActual='';
    var idProveedorActual=0;

    var idAreaA=0;
    var idDeptoA=0;

    var ivaRequis = 0;
    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraAreasAcceso('s_id_area', $('#s_id_sucursales').val());
        muestraTallas();

        $('#i_solicito').val(usuario);



        $('#s_id_area').prop('disabled',true); 
        $('#s_id_departamento').prop('disabled',true); 
        $('#i_proveedor').attr('alt',0).prop('disabled',true);
        $('#b_importar_requis').prop('disabled',true); 
        $('#b_buscar_proveedor').prop('disabled',true);

        $('#s_id_sucursales').change(function(){
            idProveedorF = 0;
           $('#b_importar_requis').prop('disabled',false);
           $('#s_id_area').val('');
           $('#s_id_area').select2({placeholder: 'Selecciona'});
           $('#i_proveedor').attr('alt',0).val('');
           $('#s_id_departamento').empty();
           $('#form_editar_producto').find('input').not('#i_iva,#i_descuento').val('');
           $('#t_partidas tbody').empty();
           $('#i_subtotal').val('');
           $('#i_total_iva').val('');
           $('#i_total').val('');
           $('#i_descuento_total').val('');
           $('#b_buscar_proveedor').prop('disabled',false);
           noEconomicoActual='';
           idProveedorActual=0;
           idAreaA=0;
           idDeptoA=0;
           ivaRequis=0;
           $('#i_requisiciones').val('');
           $('#ids_requisiciones').val('');
           muestraDepartamentoAreaInternos('s_id_departamento', $('#s_id_sucursales').val(), idAreaA);
        });

        if($('#s_id_sucursales').val() != null)
        {
            console.log('si hay ' + $('#s_id_sucursales').val());
            $('#b_importar_requis').prop('disabled', false);
        }
        else
            console.log('no hay ' + $('#s_id_sucursales').val())
      
        $('#s_id_unidades').change(function(){
            idUnidadActual=$(this).val();
            limpiarNoUNidad();
        });
    
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#b_buscar_proveedor').click(function(){
            $('#i_proveedor').validationEngine('hide');
            $('#i_filtro_proveedor').val('');

            if($('#i_facturar').val() != '')
                var rfc = $('#i_facturar').attr('rfc');
            else
                var rfc = '';

            muestraModalProveedoresAprobadosUnidades('renglon_proveedor','t_proveedores tbody','dialog_proveedores',$('#s_id_unidades').val(),rfc);
        });

        $('#t_proveedores').on('click', '.renglon_proveedor', function() {
            var id = $(this).attr('alt');
            idProveedorF = id;
            var nombre = $(this).attr('alt2');
            var rfc = $(this).attr('alt3');
            $('#i_proveedor').attr({'alt':id,'rfc':rfc}).val(nombre);

            $('#t_partidas tbody').empty();
            $('#i_subtotal').val(formatearNumero(0));
            $('#i_total_iva').val(formatearNumero(0));
            $('#i_total').val(formatearNumero(0));
            $('#i_descuento_total').val(formatearNumero(0));
            $('#i_requisiciones').val('');
            $('#ids_requisiciones').val('');

            $('#s_id_area').val('');
            $('#s_id_area').select2({placeholder: 'Selecciona'});
            $('#s_id_departamento').empty();
            noEconomicoActual='';
            idProveedorActual=0;
            idAreaA=0;
            idDeptoA=0;
            ivaRequis=0;
            $('#dialog_proveedores').modal('hide');
        });

        $('#b_buscar_facturar').click(function(){
            $('#i_filtro_empresa_fiscal').val('');
            if($('#i_proveedor').val()!='')
                var rfc = $('#i_proveedor').attr('rfc');
            else
                var rfc = '';

            muestraModalEmpresasFiscalesRFC('renglon_empresa_fiscal','t_empresa_fiscal tbody','dialog_empresa_fiscal',rfc);
        });

        $('#t_empresa_fiscal').on('click', '.renglon_empresa_fiscal', function() {

            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var rfc = $(this).attr('rfc');
            $('#i_facturar').attr({'alt':id,'rfc':rfc}).val(nombre);
            $('#dialog_empresa_fiscal').modal('hide');

        });

        $('#b_detalle_proveedor').click(function(){
            if($('#i_proveedor').val() != '')
            {
                var idProveedor = $('#i_proveedor').attr('alt');
              
                $.ajax({
                    type: 'POST',
                    url: 'php/proveedores_buscar_id.php',
                    dataType:"json", 
                    data:{
                        'idProveedor':idProveedor
                    },
                    success: function(data) {
                        if(data.length > 0){
                            if(data[0].num_int != '')
                            {
                                var num_int=' Int.'+data[0].num_int;
                            }else{
                                var num_int='';
                            }

                            $('#nombre_proveedor').text(data[0].nombre);

                            var detalles = '<p>Nombre: '+data[0].nombre+'</p>';
                                detalles += '<p>RFC: '+data[0].rfc+'</p>';
                                detalles += '<p>Domicilio: '+data[0].domicilio+' '+data[0].num_ext+' '+num_int+'. '+data[0].colonia+', '+data[0].municipio+', '+data[0].estado+', '+data[0].pais+'</p>';
                                detalles += '<p>Código Postal: '+data[0].cp+'</p>';
                                detalles += '<p>Telefono: '+data[0].telefono+'</p>';
                                detalles += '<p>Dias Credito: '+data[0].dias_credito+'</p>';
                                detalles += '<p>Web: '+data[0].web+'</p>';
                                detalles += '<p>Contacto: '+data[0].contacto+'</p>';
                                detalles += '<p>Condiciones: '+data[0].condiciones+'</p>';

                            $('#div_datos_proveedor').html(detalles);

                        }

                        $('#dialog_proveedores_datos').modal('show');
                        
                    },
                    error: function (xhr) 
                    {
                        console.log('php/proveedores_buscar_id.php --> '+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }
                });
            }else{
                mandarMensaje('Primero debes selecionar un proveedor');
            }
        });

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscarOrden();
            }
        });

        $('#i_fecha_fin').change(function(){
            buscarOrden();
        });

        $('#b_buscar_oc').click(function(){
            muestraSelectUnidades(matriz,'s_filtro_unidad',$('#s_id_unidades').val());
            $('#form_orden_compra input,textarea').validationEngine('hide');
            $('#form_editar_producto input').validationEngine('hide');
            $('#dialog_ordenes_compra').modal('show');
            $('forma').validationEngine('hide');
            $('#s_filtro_unidad').prop('disabled',false);
            $('#s_filtro_sucursal').prop('disabled',false);
            $('#i_filtro_1').val('');
            $('#i_filtro_2').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
            $('.renglon_orden_compra').remove();

        });

        $(document).on('change','#s_filtro_unidad',function(){
            var idUnidad=$(this).val();
            if(idUnidad!= ''){
                $('.img-flag').css({'width':'50px','height':'20px'});
            }
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidad,modulo,idUsuario);
            $('#i_filtro_1').val('');
            $('#i_filtro_2').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');
            $('.renglon_orden_compra').remove();
            
        });

       $(document).on('change','#s_filtro_sucursal',function(){
            buscarOrden();
       });

        function buscarOrden(){
            $('.renglon_orden_compra').remove();

            $.ajax({

                type: 'POST',
                url: 'php/orden_compra_buscar.php',
                dataType:"json", 
                data:{'fechaInicio':$('#i_fecha_inicio').val(),
                      'fechaFin':$('#i_fecha_fin').val(),
                      'idUnidadNegocio': $('#s_filtro_unidad').val(),
                      'idSucursal':$('#s_filtro_sucursal').val(),
                      'buscarTodo':'todo'
                },
                success: function(data) {
                    if(data.length != 0){

                        $('.renglon_orden_compra').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_orden_compra" alt="'+data[i].id+'" alt2="'+data[i].id_unidad_negocio+'" alt3="'+data[i].id_sucursal+'" alt4="'+data[i].id_area+'" alt5="' + data[i].estatus+ '">\
                                        <td data-label="Orden" class="i_filtro1">' + data[i].sucursal+ '</td>\
                                        <td data-label="Orden" class="i_filtro1">' + data[i].folio+ '</td>\
                                        <td data-label="Fecha Pedido">' + data[i].fecha_pedido+ '</td>\
                                        <td data-label="Proveedor" class="i_filtro2">' + data[i].proveedor+ '</td>\
                                        <td data-label="Partidas">' + data[i].partidas+ '</td>\
                                        <td data-label="Total">' + formatearNumero(data[i].total)+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_ordenes_compra tbody').append(html);   
                              
                        }
                    }else{

                            mandarMensaje('No se encontró información');
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/orden_compra_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_ordenes_compra').on('click', '.renglon_orden_compra', function() {
            muestraSucursalesPermiso('s_id_sucursales',$(this).attr('alt2'),modulo,idUsuario);
            muestraDepartamentoAreaInternos('s_id_departamento', $(this).attr('alt3'), $(this).attr('alt4'));
            idOrdenCompra = $(this).attr('alt');
            tipoMov = 1;
            $('#dialog_ordenes_compra').modal('hide');

            muestraRegistro(idOrdenCompra);
    
            muestraRegistroDetalle(idOrdenCompra,$(this).attr('alt5')); 
        });

        function muestraRegistro(){
            $('#b_imprimir').prop('disabled',false);
            $('#b_pre_imprimir').prop('disabled',false);
            $.ajax({
                type: 'POST',
                url: 'php/orden_compra_buscar_id.php',
                dataType:"json", 
                data:{
                    'idOrdenCompra':idOrdenCompra
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#d_estatus_oc').removeAttr('class');
                        estatus = data[0].estatus;

                        if(data[0].estatus == 'A')
                        {
                            $('#d_estatus_oc').addClass('alert alert-sm alert-info').text('ACTIVA');
                            habilita();

                        }else if(data[0].estatus == 'I'){
                            $('#d_estatus_oc').addClass('alert alert-sm alert-success').text('IMPRESA');
                            deshabilita();
                        }else{
                            $('#d_estatus_oc').addClass('alert alert-sm alert-danger').text('CANCELADA');
                            deshabilita();
                        }

                        $('#i_folio').val(data[0].folio);
                        $('#i_solicito').val(data[0].usuario);
                        $('#i_requisiciones').val(data[0].requisiciones);
                        $('#ids_requisiciones').val(data[0].ids_requisiciones);
                        $('#i_facturar').attr('alt',data[0].id_empresa_fiscal).val(data[0].empresa_fiscal);
                        $('#i_proveedor').attr('alt',data[0].id_proveedor).val(data[0].proveedor);
                        $('#i_fecha_pedido').val(data[0].fecha_pedido);
                        $('#i_tiempo_entrega').val(data[0].tiempo_entrega);
                        $('#i_fecha_entrega').val(data[0].fecha_entrega);
                        $('#i_condicion_pago').val(data[0].condiciones_pago);
                        $('#ta_observaciones_entrega').val(data[0].observaciones_entrega);

                        //3=stock 0=activo fijo 2= mantenimiento
                        if(data[0].tipo == 0)
                        {
                            $('#r_activo').prop('checked',true);
                        }else if(data[0].tipo == 1)
                        {
                            $('#r_gasto').prop('checked',true);
                        }else if(data[0].tipo == 2)
                        {
                            $('#r_mantenimiento').prop('checked',true);
                        }else{
                            $('#r_stock').prop('checked',true);
                        }

                        $('#s_id_unidades').val(data[0].id_unidad_negocio).prop('disabled',true);
                        $("#s_id_unidades").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                        if(data[0].id_sucursal != 0)
                        {
                            $('#s_id_sucursales').val(data[0].id_sucursal).prop('disabled',true);
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

                        $('#b_imprimir').attr('alt',data[0].impresa);
                    }
                    
                },
                error: function (xhr) 
                {
                    console.log('php/orden_compra_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

         //****************AGREGA DETALLE DE LA REQUISICION SELECIONADA A LA TABLA t_partidas******** */
         function muestraRegistroDetalle(idOrdenCompra,estatus)
         {

            $('#t_partidas tbody').empty();
            $.ajax({
                type: 'POST',
                url: 'php/orden_compra_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idOrdenCompra':idOrdenCompra
                },
                success: function(data)
                {
                    for(var i=0; data.length>i; i++)
                    {
                        var clasePartida='partida';
                        var botonTallaId='';
                        var botonEliminarId='';
                        if(estatus=='Activa')
                        {
                            clasePartida="partida-oc";
                            $('#b_importar_requis').prop('disabled',true);
                            botonTallaId="b_talla";
                            botonEliminarId="b_eliminar";
                        }else
                        {
                            clasePartida="partida-"+estatus;
                            $('#b_importar_requis').prop('disabled',true);
                            botonTallaId="b_no_talla";
                            botonEliminarId="b_no_eliminar";
                        }

                        var oc = data[i];
                        totalPartidas++;
                        
                        var html = "<tr class='"+clasePartida+"' folio='"+oc.folioRequi+"' requi='"+oc.idRequi+"' idRequiD='"+oc.idRequiD+"'  producto='" + oc.id_producto + "' clave='" + oc.clave + "' concepto='" + oc.concepto+ "' id_familia='" + oc.id_familia + "' familia='" + oc.familia + "' id_linea='" + oc.id_linea + "' linea='" + oc.linea + "' costo='" + oc.costo + "' cantidad='" +  oc.cantidad + "' descuento='" + oc.descuento + "' descripcion='" + oc.descripcion + "' importe='" + oc.importe + "' iva='" + oc.iva + "' descuento_requi_d='"+oc.descuento_requisicion+"'>";
                            html += "<td>" + oc.folioRequi + "</td>";
                            html += "<td>" + oc.clave + "</td>";
                            html += "<td>" + oc.familia + "</td>";
                            html += "<td>" + oc.linea + "</td>";
                            html += "<td>" + oc.concepto + "</td>";
                            html += "<td>" + oc.descripcion + "</td>";
                            html += "<td align='right'>" + oc.cantidad + "</td>";
                            html += "<td align='right'>" + formatearNumero(oc.costo) + "</td>";
                            html += "<td align='right'>" + oc.descuento + "</td>";
                            html += "<td align='right'>" + oc.iva + "</td>";
                            html += "<td>" + formatearNumero(oc.importe) + "</td>";

                            var botonTalla = '';
                            if(parseInt(oc.verifica_talla) == 1 )
                            {

                                botonTalla = "<button type='button' class='btn btn-success btn-sm class-" + totalPartidas + "' id='b_talla' alt='" + oc.id_producto + "'  alt2='" + oc.cantidad + "' alt3='" + totalPartidas + "'><i class='fa fa-list' style='font-size:10px;' aria-hidden='true'></i></button><input  class='tallas-i' type='hidden' id='i_talla" + totalPartidas + "'  name='i_talla" + totalPartidas + "' value='" + oc.tallas + "' tallas_solicitadas='"+oc.tallas_solicitadas+"'>";

                            }

                            html += "<td>" + botonTalla + "</td>";

                            //html += "<td><button type='button' class='btn btn-danger btn-sm' id='"+botonEliminarId+"' alt='" + oc.id_producto + "'><i class='fa fa-remove' style='font-size:10px;' aria-hidden='true'></i></button></td>";

                            html += "</tr>";

                            $('#t_partidas tbody').append(html);
                    
                    }
                   
                    if(parseInt(data.length)==parseInt(i)){
                        calculaTotales();
                    }
         
                },
                error: function (xhr)
                {
                    console.log('php/orden_compra_buscar_detalle.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar las partidas de la OC');
                }
            });
        }


        $('#b_guardar').on('click',function(){
            $('#b_guardar').prop('disabled',true);

            //-->NJES August/14/2020 heredar las tallas de la requisición, solo en recepción de mercancia se pueden capturar
            /*var verificaPartidas = validarTallas();
            if(verificaPartidas == true)
            {
                mandarMensaje('Algunas Partidas necesitan especificar las tallas, favor de verificar.');
                $('#b_guardar').prop('disabled',false);
            }else{*/

                if ($('#form_orden_compra').validationEngine('validate'))
                {

                    if($('#t_partidas .partida-oc').length > 0)
                    {
                        if($('#i_requisiciones').val()!=''){

                            guardar();
                         
                        }else{
                            mandaMensaje('Debes importar por lo menos una requisición para poder guardar');
                            $('#b_guardar').prop('disabled',false);
                        }
                       
                    }else{
                        mandarMensaje('Debe existir por lo menos un producto para generar la Orden de Compra');
                        $('#b_guardar').prop('disabled',false);
                    }

                }
                else
                    $('#b_guardar').prop('disabled',false);

            //}

        });


        function guardar(){

            
            var datos = {
                'tipoMov':tipoMov,
                'idOrdenCompra':idOrdenCompra,
                'folio':$('#i_folio').val(),
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'idSucursal':$('#s_id_sucursales').val(),
                'idArea':$('#s_id_area').val(),
                'idDepartamento':$('#s_id_departamento').val(),
                'idProveedor':$('#i_proveedor').attr('alt'),
                'idEmprezaFiscal':$('#i_facturar').attr('alt'),
                'idUsuario':idUsuario,
                'solicito':$('#i_solicito').val(),
                'requisiciones':$('#i_requisiciones').val(),
                'idsRequisiciones':$('#ids_requisiciones').val(),
                'tipoGastoStock':$('input[name=rdb_tipo]:checked').val(),
                'fechaPedido':$('#i_fecha_pedido').val(),
                'tiempoEntrega':$('#i_tiempo_entrega').val(),
                'fechaEntrega':$('#i_fecha_entrega').val(),
                'condicionPago':$('#i_condicion_pago').val(),
                'observacionesEntrega':$('#ta_observaciones_entrega').val(),
                'estatus':estatus,
                'partidas':$("#t_partidas .partida-oc").length,
                'detalle':obtenerPartidas()
            };
            //console.log(JSON.stringify(datos));
            
            $.ajax({
                type: 'POST',
                url: 'php/orden_compra_guardar.php',
                data:  {'datos':datos},
                success: function(data) {
                  
                    console.log("Resultado:"+data);
                    if(data > 0 )
                    { 
                        mandarMensaje('La orden compra: '+data+' se guardó correctamente');
                        limpiar();
                    
                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/orden_compra_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                    $('#b_guardar').prop('disabled',false);
                }
            });
               
        }

        $('#b_nuevo').click(function(){
            limpiar();
        });

        function limpiarNoUNidad(){
            $('#form_orden_compra input,textarea').not(':radio').val('');
            $('#form_orden_compra input,textarea').validationEngine('hide');
            $('#form_editar_producto input').validationEngine('hide').val('');
            $('#s_id_area,#s_id_departamento').prop('disabled',true); 
            $('#b_importar_requis').prop('disabled',true); 
            $('#t_partidas tbody').empty();
            $('#i_producto').attr('alt',0);
            $('#i_folio').val('');
            $('#d_estatus_oc').text('').removeAttr('class');
            $('.i_t').val(0);
            $('#i_iva').val(16);
            $('#i_descuento').val(0);
            $('#i_solicito').val(usuario);
    
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            
            muestraAreasAcceso('s_id_area', $('#s_id_sucursales').val());
            $('#s_id_departamento').val('');
            $('#s_id_departamento').select2({placeholder: 'Selecciona'});
            $('#s_id_sucursales').prop('disabled',false);

            $('#s_id_area').prop('disabled',true);
            $('#s_id_departamento').prop('disabled',true); 
            $('#i_proveedor').attr('alt',0).prop('disabled',true); 
            $('#b_buscar_proveedor').prop('disabled',true);
            muestraTallas();
            habilita();
            $('#i_requisiciones').val('');
            $('#ids_requisiciones').val('');
        }

        function limpiar(){
            $('#form_orden_compra input,textarea').not(':radio').val('');
            $('#form_orden_compra input,textarea').validationEngine('hide');
            $('#form_editar_producto input').validationEngine('hide').val('');
            $('#s_id_area,#s_id_departamento').prop('disabled',true); 
            
            $('#b_importar_requis').prop('disabled',true); 
            
            $('#b_guardar').prop('disabled',false); 
            $('#b_imprimir').prop('disabled',true);
            $('#b_pre_imprimir').prop('disabled',true);
            $('#t_partidas tbody').empty();
            $('#i_producto').attr('alt',0);
            $('#i_folio').val('');
            $('#d_estatus_oc').text('').removeAttr('class');
            $('.i_t').val(0);
            $('#i_iva').val(16);
            $('#i_descuento').val(0);
            $('#i_solicito').val(usuario);

            noEconomicoActual='';
            idProveedorActual=0;
            idAreaA=0;
            idDeptoA=0;
            ivaRequis=0;
            tipoMov=0;
            idOrdenCompra=0;

            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            muestraAreasAcceso('s_id_area', $('#s_id_sucursales').val());
            $('#s_id_departamento').val('');
            $('#s_id_departamento').select2({placeholder: 'Selecciona'});
            $('#s_id_unidades').prop('disabled',false);
            $('#s_id_sucursales').prop('disabled',false);

            $('#s_id_area').prop('disabled',true);
            $('#s_id_departamento').prop('disabled',true);
            $('#i_proveedor').attr('alt',0).prop('disabled',true);
            $('#b_buscar_proveedor').prop('disabled',true);

            muestraTallas();
            habilita();
        }

        $('#b_buscar_productos').click(function()
        {
            $('#i_filtro_producto_b').val('');

            $('#form_editar_producto').validationEngine('hide');

            var idUnidad = $('#s_id_unidades').val();
        
            $('#t_productos >tbody tr').remove();

            var tipoProducto = $('input[name=rdb_tipo]:checked').val();

            $.ajax({
                type: 'POST',
                url: 'php/productos_buscar_activos.php',
                dataType:"json", 
                data:{
                    'idUnidad':idUnidad,
                    'idLinea': $('#i_filtro_linea').attr('alt'),
                    'idFamilia' :$('#i_filtro_familia').attr('alt'),
                    'tipo': tipoProducto
                },
                success: function(data)
                {
                   
                    for(var i=0; data.length>i; i++)
                    {

                        var producto = data[i];

                        var html = "<tr class='producto-partida' alt='" + producto.id + "' alt1='" + producto.clave + "' alt2='" + producto.concepto+ "' alt3='" + producto.id_familia + "' alt4='" + producto.familia + "' alt5='" + producto.id_linea + "' alt6='" + producto.linea + "' alt7='" + producto.costo + "' alt8='" + producto.descripcion + "' alt9='" + producto.verifica_talla + "'>";
                        html += "<td>" + producto.familia + "</td>";
                        html += "<td>" + producto.linea + "</td>";
                        html += "<td>" + producto.concepto + "</td>";
                        html += "<td align='right'>" + formatearNumero(producto.costo) +  "</td>";
                        html += "</tr>";

                        $('#t_productos tbody').append(html);
                    
                    }

                    $('#dialog_buscar_productos').modal('show');
         
                },
                error: function (xhr)
                {
                    console.log('php/productos_buscar_activos.php-->'+xhr.responseText);
                    mandarMensaje(' No se encontro información al buscar los productos');
                }
            });
            
           
        });

        $("#t_productos").on('click',".producto-partida",function()
        {

            var idProducto = $(this).attr('alt');
            var clave = $(this).attr('alt1');
            var concepto = $(this).attr('alt2');
            var idFamilia = $(this).attr('alt3');
            var familia = $(this).attr('alt4');
            var idLinea = $(this).attr('alt5');
            var linea = $(this).attr('alt6');
            var costo = $(this).attr('alt7');
            var descripcion = $(this).attr('alt8');
            var verificaTalla = $(this).attr('alt9');

            $('#i_id_requi').val(0).attr('idRequi',0).attr('idRequiD',0);
            $('#i_producto').attr('alt',idProducto).val(clave);
            $('#i_linea').attr('alt',idLinea).val(linea);  
            $('#i_familia').attr('alt',idFamilia).val(familia);
            $('#i_concepto').val(concepto);
            $('#i_descripcion').val(descripcion);
            $('#i_costo').val(formatearNumero(costo));
            $('#i_cantidad').val(0);
            $('#i_importe').val(0);
            $('#i_tipo_producto').val(verificaTalla);

            $('#dialog_buscar_productos').modal('hide');


        });

        $('#i_costo,#i_cantidad,#i_descuento').on('change',function(){
           
            if($(this).validationEngine('validate')==false) {

                var descuento = $('#i_descuento').val();
                var costo=quitaComa($('#i_costo').val());
                var cantidad=$('#i_cantidad').val();

                if(cantidad==''){
                    cantidad=0;
                }

                if(costo==''){
                    precio=0;
                }

                if(costo > 0 && descuento==0){

                    $('#i_importe').val(formatearNumero(parseInt(cantidad)*parseFloat(costo)));

                }else if(costo > 0 && descuento>0){

                    var importe=parseInt(cantidad)*parseFloat(costo);
                    var descuento=((parseFloat(descuento)*importe)/100);
                    $('#i_importe').val(formatearNumero(importe-descuento));

                }else{
                    $('#i_importe').val(0);
                }

            }else{
            $('#i_importe').val(0);
            }
        });


        $(document).on('click','#b_talla',function()
         {
            $('#i_t_total').val(0);
            $('#i_t_total_a').val(0);
            $('#i_t_numero_partida').val('');
            $('#i_t_talla').val('');
            $('#i_t_cantidad').val('');
            $('#t_tallas >tbody tr').remove();
            $('#t_tallas_solicitadas >tbody tr').remove();

            var idProducto = $(this).attr('alt');
            var cantidad = $(this).attr('alt2');
            var nPartida = $(this).attr('alt3');
            var tallasAgregadas = $('#i_talla' + nPartida).val();
            var tallasSolicitadas = $('#i_talla' + nPartida).attr('tallas_solicitadas');

            $('#i_t_numero_partida').val(nPartida);

            //-->NJES August/14/2020 heredar las tallas de la requisición, solo en recepción de mercancia se pueden capturar
            /*if(tallasSolicitadas!=''){
                var tallasOc = JSON.parse(tallasSolicitadas);
                for(var i=0; tallasOc.length>i; i++)
                {

                    var tallaOc = tallasOc[i];
                    var html = "<tr>";
                    html += "<td>" + tallaOc.talla + "</td>";
                    html += "<td>" + tallaOc.cantidad + "</td>";
                    html += "</tr>";

                    $('#t_tallas_solicitadas tbody').append(html);

                }
            }*/

            //if(tallasAgregadas == '')
                //$('#i_t_total').val(cantidad);
            //else
            //{

                $('#i_t_total').val(cantidad);
                $('#i_t_total_a').val(cantidad);
                //var tallasArray = JSON.parse(tallasAgregadas);
                //for(var i=0; tallasArray.length>i; i++)
                //{
                var tallasOc = JSON.parse(tallasSolicitadas);
                //$('#i_talla' + nPartida).val(tallasSolicitadas);
                
                for(var i=0; tallasOc.length>i; i++)
                {

                    var tallaActual = tallasOc[i];
                    var html = "<tr alt='" + tallaActual.talla + "' alt2='" + tallaActual.cantidad + "' >";
                    html += "<td>" + tallaActual.talla + "</td>";
                    html += "<td>" + tallaActual.cantidad + "</td>";
                    //html += "<td><button type='button' class='btn btn-danger btn-sm form-control' alt='" + tallaActual.talla + "' alt2='" + tallaActual.cantidad + "' id='b_eliminar_talla'><i class='fa fa-remove' aria-hidden='true'></i></button></td>";
                    html += "</tr>"

                    $('#t_tallas tbody').append(html);

                }                

                $('.tallas_oculto').hide();
            //}
            
            $('#dialog_agregar_tallas').modal('show');

        });

        //**************ELIMINAR PARTIDAS************** */
        $(document).on('click','#b_eliminar',function(){
            $(this).parent().parent().remove();
            calculaTotales();
            verificaRequiImportadas();
        });

    
        
        
        //****************OBTENER PARTIDAS***************** */
        function obtenerPartidas(){
            
            var j = 0;
            var arreDatos = [];
            
            $("#t_partidas .partida-oc").each(function() {

                var idRequi = $(this).attr('requi');
                var idRequiD = $(this).attr('idRequiD');
                var idProducto = $(this).attr('producto');
                var clave = $(this).attr('clave');
                var concepto = $(this).attr('concepto');
                var descripcion =$(this).attr('descripcion');
                var cantidad = $(this).attr('cantidad');
                var costo = quitaComa($(this).attr('costo'));
                var iva = $(this).attr('iva');
                var importe = quitaComa($(this).attr('importe'));
                var descuento = $(this).attr('descuento');
                var nPartida = $(this).attr('total_partidas');

                var tallas = $(this).find('.tallas-i').val();
                if(tallas == undefined)
                    tallas = '';

                //mandarMensaje(tallas);

                j++;

                arreDatos[j] = {
                    
                   'idRequi' : idRequi,
                   'idRequiD' : idRequiD,
                   'idProducto' : idProducto,
                   'clave' : clave,
                   'concepto' : concepto,
                   'descripcion' : descripcion,
                   'cantidad' : cantidad,
                   'costo' : costo,
                   'iva' : iva,
                   'descuento' : descuento,
                   'importe' : importe,
                   'tallas': tallas 
                };
            });
            
            arreDatos[0] = j;
            return arreDatos;
        }

        $('input[name=rdb_tipo]').on('change',function(){
            $('#t_partidas tbody').empty();
            $('#i_subtotal').val(formatearNumero(0));
            $('#i_total_iva').val(formatearNumero(0));
            $('#i_total').val(formatearNumero(0));
            $('#i_descuento_total').val(formatearNumero(0));
            $('#i_requisiciones').val('');
            $('#ids_requisiciones').val('');
            $('#s_id_area').val('');
            $('#s_id_area').select2({placeholder: 'Selecciona'});
            $('#i_proveedor').attr('alt',0).val('');
            $('#s_id_departamento').empty();
            $('#i_requisiciones').val('');
            $('#ids_requisiciones').val('');
            idAreaA = 0;
            idDeptoA = 0;
            ivaRequis=0;
        });

        //****************IMPORTAR REQUISICIONES***************************** */
        $('#b_importar_requis').on('click',function(){
            if(parseInt($('.partida-oc').length) == 0 ){
                noEconomicoActual='';
                idProveedorActual=0;
            }
            var idUnidad = $('#s_id_unidades').val();
            var idSucursal = $('#s_id_sucursales').val();
            $('#l_tipo_requi').text('');
            $('#t_requisiciones >tbody tr').remove();
            $('#thM').hide();
        
            var tipoProducto = $('input[name=rdb_tipo]:checked').val();

            if(tipoProducto==0){
                $('#l_tipo_requi').text('ACTIVO FIJO');
            }else if(tipoProducto==2){
                $('#thM').show();
                $('#l_tipo_requi').text('MANTENIMIENTO');
            }else{
                $('#l_tipo_requi').text('STOCK');
            }

            $('#i_filtro_requisiciones').val('');
        
            $.ajax({
                type: 'POST',
                url: 'php/requisiciones_buscar_importar.php',
                dataType:"json", 
                data:{
                    'idUnidad':idUnidad,
                    'idSucursal':idSucursal,
                    'idProveedor':idProveedorF,
                    'tipo': tipoProducto
                },
                success: function(data){
                   
                    for(var i=0; data.length>i; i++){

                        var requi = data[i];

                        if(i==1){
                           
                        }
                        var estatusProveedor='';
                        if(requi.aprobado==1){
                            estatusProveedor='Aprobado';
                        }else{

                            if(requi.rechazado==1){
                                estatusProveedor='Rechazado';
                            }else{
                                estatusProveedor='Pendiente';
                            }

                        }
                        
                        var tdM='';
                        if(tipoProducto==2){
                            tdM="<td align='right'>" + requi.no_economico +  "</td>";
                        }

                       
                        var html = "<tr class='requisicion-partida "+estatusProveedor+"' alt='" + requi.id + "' alt2='" + requi.folio + "' idDepartamento='" + requi.id_departamento + "' idArea='" + requi.id_area + "' idProveedor='" + requi.id_proveedor + "' proveedor='" + requi.proveedor + "' aprobado='" + requi.aprobado + "' noEconomico='" + requi.no_economico + "' importe_total='"+requi.importe_total+"' subtotal='"+requi.subtotal+"' iva='"+requi.iva+"' descuento='"+requi.descuento+"' iva_max='"+requi.iva_m+"'>";
                        html += "<td>" + requi.unidad + "</td>";
                        html += "<td>" + requi.clave_suc + "</td>";
                        html += "<td>" + requi.sucursal + "</td>";
                        html += "<td>" + requi.area_r + "</td>";
                        html += "<td>" + requi.departamento + "</td>";
                        html += "<td>" + requi.proveedor + "</td>";
                        html += "<td>" + estatusProveedor+ "</td>";
                        html += "<td>" + requi.folio + "</td>";
                        html += "<td>" + requi.descripcion + "</td>";
                        html += "<td align='right'>" + requi.total +  "</td>";
                        html += tdM;
                        html += "<td>" + requi.estatus + "</td>";
                        html += "</tr>";

                        $('#t_requisiciones tbody').append(html);
                    
                    }

                    $('#dialog_buscar_requisiciones').modal('show');
        
                },
                error: function (xhr)
                {   
                    console.log('php/requisiciones_buscar_importar.php-->'+ JSON.stringify(xhr));
                    mandarMensaje(' No se encontro información al buscar requisiciones para importar');
                }
            });

        });

        $("#t_requisiciones").on('click',".requisicion-partida",function(){

            var idRequi = $(this).attr('alt');
            var folio = $(this).attr('alt2');
            var aprobado = $(this).attr('aprobado');
            var noEconomico = $(this).attr('noEconomico');
            var idProveedor = $(this).attr('idProveedor');
            var idDepartamento = $(this).attr('idDepartamento');
            var idArea = $(this).attr('idArea');
            var proveedor = $(this).attr('proveedor');

            var total = parseFloat($(this).attr('importe_total'));
            var subtotal = parseFloat($(this).attr('subtotal'));
            var iva = parseFloat($(this).attr('iva'));

            //-->NJES November/20/2020 descuento total de la requisicion
            var descuento = parseFloat($(this).attr('descuento'));

            //-->NJES November/20/2020 obtener el valor actual para sumarle los montos de las demas requisiciones a importar
            if($('#i_subtotal').val() != '')
                var subtotal_T = parseFloat(quitaComa($('#i_subtotal').val()));
            else
                var subtotal_T = 0;

            if($('#i_total_iva').val() != '')
                var iva_T = parseFloat(quitaComa($('#i_total_iva').val()));
            else
                var iva_T = 0;

            if($('#i_total').val() != '')
                var total_T = parseFloat(quitaComa($('#i_total').val()));
            else
                var total_T = 0;

            if($('#i_descuento_total').val() != '')
                var descuento_T = parseFloat(quitaComa($('#i_descuento_total').val()));
            else
                var descuento_T = 0;


            //--- MGFS 31-01-2020 SE VALIDA QUE SEA LA MISMA AREA Y DEPTO 
            if((idAreaA==0 && idDeptoA==0) || (idAreaA==idArea && idDeptoA==idDepartamento) ){
                 
                idAreaA = idArea;
                idDeptoA = idDepartamento;
                //-- se agrega funcion paar que cargue el valor correspondiente ya que de la otra forma estaba agarrando siempre el primer valor
                muestraDepartamentoAreaInternosO('s_id_departamento', $('#s_id_sucursales').val(), idArea, idDepartamento);
               
                if(aprobado==1){

                    var requisAgregadas = $('#i_requisiciones').val();
                    
                    if(requisAgregadas.indexOf(folio) > -1== false){
                        //--MGFS 27-01-2020 SE AGREGA VALIDACIÓN PARA UE NO SE AGREGUEN REQUIS DE MANTENIMIENTO DE DIFERENTE NO ECONÓMICO
                        var tipoProducto = $('input[name=rdb_tipo]:checked').val();

                        if(parseInt(tipoProducto)==1 || parseInt(tipoProducto)==3 || noEconomicoActual=='' || noEconomicoActual==noEconomico){
                            //--MGFS 27-01-2020 SE AGREGA VALIDACIÓN PARA QUE NO SE AGREGUEN REQUIS DE DIFERENTE PROVEEDOR
                        
                            if(parseInt(idProveedorActual)==0 || parseInt(idProveedorActual)==parseInt(idProveedor)){

                                //-->NJES December/02/2020 validar que todas las partidas de requis tengan el mismo iva ó (0 y 16) ó (0 y 8)
                                if(ivaRequis == 0 || parseInt($(this).attr('iva_max')) == ivaRequis || parseInt($(this).attr('iva_max')) == 0)
                                {
                                    if(parseInt($(this).attr('iva_max')) > 0)
                                        ivaRequis = parseInt($(this).attr('iva_max'));

                                    agregaDetalleRequi(idRequi,folio);

                                    //-->NJES November/20/2020 ir sumando los valores de los montos de todas las requis que se vayan importando
                                    //-->NJES October/30/2020 mostrar el total del encabezado de la requi
                                    $('#i_subtotal').val(formatearNumero(subtotal+subtotal_T));
                                    $('#i_total_iva').val(formatearNumero(iva+iva_T));
                                    $('#i_total').val(formatearNumero(total+total_T));
                                    //-->NJES November/20/2020 mostrar el descuento total de las requis importadas
                                    $('#i_descuento_total').val(formatearNumero(descuento+descuento_T));

                                    var valor=$('#i_requisiciones').val();
                                    var valorIds=$('#ids_requisiciones').val();

                                    if(valor==''){

                                        $('#i_requisiciones').val(folio);
                                        $('#ids_requisiciones').val(idRequi);
                                        noEconomicoActual=noEconomico;
                                        idProveedorActual=idProveedor;

                                    }else{

                                        $('#i_requisiciones').val(valor+', '+folio);
                                        $('#ids_requisiciones').val(valorIds+', '+idRequi);
                                    }

                                    $('#i_proveedor').attr('alt',idProveedor).val(proveedor);
                                
                                    if(idArea != 0){
                                        $('#s_id_area').val(idArea);
                                        $('#s_id_area').select2({placeholder: $(this).data('elemento')});
                                    }else{
                                        $('#s_id_area').val('');
                                        $('#s_id_area').select2({placeholder: 'Selecciona'});
                                    }
                
                                    $('#dialog_buscar_requisiciones').modal('hide');
                                }else{
                                    if(ivaRequis > 0)
                                        mandarMensaje('Todas las partidas de las requisiciones deben ser con iva '+ivaRequis+' ó 0');
                                    else
                                        mandarMensaje('Todas las partidas de las requisiciones deben ser con mismo iva ó bien (0 y 8) ó (0 y 16)');
                                }
                            }else{
                                mandarMensaje('No puedes agregar requisiciones con diferente proveedor');
                            }
                        }else{
                            mandarMensaje('No puedes importar una requisicion de con diferente número económico');
                        }

                    }else{

                        mandarMensaje('La requisición: '+folio+' ya se agregó');
                    }
                }else{
                    mandarMensaje('La requisición: '+folio+' no puede ser agregada por que no esta aprobado el proveedor, comunicarse con el administrador');
                }
            }else{
                mandarMensaje('La requisición: '+folio+' no puede ser selecionada, debe tener la misma Area y Departamento, que la requisición agregada');
            }
        });

        function validarTallas()
        {

            var verifica = false;

            $('.tallas-i').each(function(i, obj)
            {

                if($(this).val() == '')
                    verifica = true;
            
            });  

            return verifica;

        }

        $('#b_agregar_talla').click(function()
        {
            $('#b_agregar_talla').prop('disabled',true);

            var talla = $('#i_t_talla').val();
            var cantidad = $('#i_t_cantidad').val();
            var totalA = $('#i_t_total_a').val();
            
            var verifica = false;
            if(talla == '' || talla == null)
                verifica = true;

            if(cantidad == '' || cantidad == null)
                verifica = true;

            if(verifica == true){
                mandarMensaje('Datos incompletos.');
                $('#b_agregar_talla').prop('disabled',false);
            }else
            {
                if((parseInt(cantidad) + parseInt(totalA)) <= parseFloat($('#i_t_total').val()))
                {
                    var html = "<tr alt='" + talla + "' alt2='" + cantidad + "' >";
                    html += "<td>" + talla + "</td>";
                    html += "<td>" + cantidad + "</td>";
                    html += "<td><button type='button' class='btn btn-danger btn-sm form-control' alt='" + talla + "' alt2='" + cantidad + "' id='b_eliminar_talla'><i class='fa fa-remove' aria-hidden='true'></i></button></td>";
                    html += "</tr>"

                    $('#t_tallas tbody').append(html);
                    $('#i_t_total_a').val(parseInt(cantidad) + parseInt(totalA));
                    $('#i_t_talla').val('');
                    $('#i_t_cantidad').val('');
                    $('#b_agregar_talla').prop('disabled',false);
                }else{
                    mandarMensaje('La cantidad sobrepasa la cantidad de productos disponibles. Verifica la cantidad de tallas agregadas.');
                    $('#b_agregar_talla').prop('disabled',false);
                }

            }

        });


        $(document).on('click','#b_eliminar_talla',function()
         {
            $(this).parent().parent().remove();
            var cantidad = $(this).attr('alt2');
            var totalA = $('#i_t_total_a').val();

            $('#i_t_total_a').val(parseInt(totalA) - parseInt(cantidad));

        });



        $('#b_guardar_talla').click(function()
        {

            $('#b_guardar_talla').prop('disabled',true);
            var totalProdutos = $('#i_t_total').val();
            var totalProdutosAgregados = $('#i_t_total_a').val();
            var nPartida = $('#i_t_numero_partida').val();

            if(parseFloat(totalProdutos) != parseFloat(totalProdutosAgregados)){
                mandarMensaje('No corresponde el total de productos con tallas asignadas con el total de productos de la requisición. Verificar.');
                $('#b_guardar_talla').prop('disabled',false);
                var clase = 'class-' + nPartida;
                $('.' + clase).each(function()
                {
                    $(this).removeClass('btn-success').addClass('btn-primary');
                });
            }else
            {

                var tallasA = [];
                var contador = 0;
                $("#t_tallas tbody tr").each(function()
                {

                    var talla = $(this).attr('alt');
                    var cantidad = $(this).attr('alt2');

                    tallasA[contador] = {
                        'talla': talla,
                        'cantidad': cantidad
                    };

                    contador++;
                    
                });

                var jsonTallas = JSON.stringify(tallasA);
                $('#i_talla' + nPartida).val(jsonTallas);

                $('#i_t_total_a').val('');
                $('#i_t_total').val('');
                $('#t_tallas >tbody tr').remove();
                $('#dialog_agregar_tallas').modal('hide');

                var clase = 'class-' + nPartida;
                $('.' + clase).each(function()
                {
                    $(this).removeClass('btn-primary').addClass('btn-success');
                });
                // aqui las tallas
                $('#b_guardar_talla').prop('disabled',false);

            }

        });

         //****************AGREGA DETALLE DE LA REQUISICION SELECIONADA A LA TABLA t_partidas******** */
        function agregaDetalleRequi(idRequi,folio){
            
            $.ajax({
                type: 'POST',
                url: 'php/requisiciones_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idRequisicion':idRequi
                },
                success: function(data)
                {
                    for(var i=0; data.length>i; i++)
                    {

                        totalPartidas++;

                        var requiD = data[i];

                        var html = "<tr class='partida-oc' folio='"+folio+"' requi='"+idRequi+"' idRequiD='"+requiD.id+"'  producto='" + requiD.id_producto + "' clave='" + requiD.clave + "' concepto='" + requiD.concepto+ "' id_familia='" + requiD.id_familia + "' familia='" + requiD.familia + "' id_linea='" + requiD.id_linea + "' linea='" + requiD.linea + "' costo='" + requiD.costo + "' cantidad='" +  requiD.cantidad + "' descuento='" + requiD.descuento + "' descripcion='" + requiD.descripcion + "' importe='" + requiD.importe + "' iva='" + requiD.iva + "' total_partidas='" + totalPartidas + "' >";
                            html += "<td>" + folio + "</td>";
                            html += "<td>" + requiD.clave + "</td>";
                            html += "<td>" + requiD.familia + "</td>";
                            html += "<td>" + requiD.linea + "</td>";
                            html += "<td>" + requiD.concepto + "</td>";
                            html += "<td>" + requiD.descripcion + "</td>";
                            html += "<td align='right'>" + requiD.cantidad + "</td>";
                            html += "<td align='right'>" + formatearNumero(requiD.costo) + "</td>";
                            html += "<td align='right'>" + requiD.descuento + "</td>";
                            html += "<td align='right'>" + requiD.iva + "</td>";
                            html += "<td>" + formatearNumero(requiD.importe) + "</td>";

                            //-->NJES August/14/2020 heredar las tallas de la requisición, solo en recepción de mercancia se pueden capturar
                            var botonTalla = '';
                            if(requiD.verifica_talla == 1)
                                botonTalla = "<button type='button' class='btn btn-success btn-sm class-" + totalPartidas + "' id='b_talla' alt='" + requiD.id_producto + "'  alt2='" + requiD.cantidad + "' alt3='" + totalPartidas + "' ><i class='fa fa-list' style='font-size:10px;' aria-hidden='true'></i></button></button><input  class='tallas-i' type='hidden' id='i_talla" + totalPartidas + "'  name='i_talla" + totalPartidas + "' value='"+requiD.tallas_solicitadas+"' tallas_solicitadas='"+requiD.tallas_solicitadas+"'>";

                            html += "<td>" + botonTalla + "</td>";


////                            html += "<td><button type='button' class='btn btn-danger btn-sm' id='b_eliminar' alt='" + requiD.id_producto + "'><i class='fa fa-remove' style='font-size:10px;' aria-hidden='true'></i></button></td>";

                            html += "</tr>";

                            $('#t_partidas tbody').append(html);
                    
                    }
                    //-->NJES October/30/2020 mostrar el total del encabezado de la requi
                    /*if(data.length==i){
                        calculaTotales();
                    }*/
         
                },
                error: function (xhr)
                {
                    console.log('php/requisiciones_buscar_detalle.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('No se encontro información al buscar las partidas de la requisición');
                }
            });
        }

        function cargarTallas(){

            var html = "<tr alt='" + tallaActual.talla + "' alt2='" + tallaActual.cantidad + "' >";
                html += "<td>" + tallaActual.talla + "</td>";
                html += "<td>" + tallaActual.cantidad + "</td>";
                html += "<td><button type='button' class='btn btn-danger btn-sm form-control' alt='" + tallaActual.talla + "' alt2='" + tallaActual.cantidad + "'></td>";
                html += "</tr>";

            $('#t_tallas tbody').append(html);
        }


        function calculaTotales(){
          
            var subtotal=0;
            var totalIva=0;
            var total=0;
            var descuentoTRequis = 0;

            $("#t_partidas > tbody tr").each(function() {
               
                var cantidad = $(this).attr('cantidad');
                var costo = $(this).attr('costo');
                var iva = $(this).attr('iva');
                var importe = $(this).attr('importe');
                var descuento = $(this).attr('descuento');
                var descuento_requi = parseFloat(quitaComa($(this).attr('descuento_requi_d')));

                descuentoTRequis = descuentoTRequis + descuento_requi;

                if(descuento > 0){
                    
                    var subtotalP=parseFloat(cantidad)*parseFloat(costo);
                    var descuentoTotal=((parseFloat(descuento)*subtotalP)/100);
                    
                    subtotal+=(subtotalP-descuentoTotal);

                    totalIva+=((parseFloat(cantidad)*parseFloat(costo))-descuentoTotal)*(iva/100);

                }else{

                    subtotal+=parseFloat(cantidad)*parseFloat(costo);
                    totalIva+=(parseFloat(cantidad)*parseFloat(costo))*(iva/100);
                }
                
            
                
            });
           
              $('#i_subtotal').val(formatearNumero(subtotal));
              $('#i_total_iva').val(formatearNumero(totalIva));
              $('#i_total').val(formatearNumero(subtotal+totalIva));
              $('#i_descuento_total').val(formatearNumero(descuentoTRequis));
             
        }

        $('#b_requisiciones').on('click',function(){
            window.open("fr_requisiciones.php","_self");
        });

        $('#i_iva').on('change',function(){
            if($(this).validationEngine('validate')==false) {

                var iva=$('#i_iva').val();
                if(iva==0 || iva==8 || iva==16){

                }else{
                    $('#i_iva').val(16);
                    mandarMensaje('Para el iva solo puedes ingresar 0, 8 o 16');
                }

            }else{
                $('#i_iva').val(16);
            }
        });


        function habilita(){
            $('#form_orden_compra input,textarea,select,input:radio').prop('disabled',false);
            $('#form_editar_producto input').prop('disabled',false);
            $('#b_buscar_productos').prop('disabled',false);
            $('#b_importar_requis').prop('disabled',false);
            $('#b_guardar').prop('disabled',false);
            //$('#b_buscar_proveedor').prop('disabled',false);

            $('#b_buscar_facturar').prop('disabled',false);
            $(document).find('#b_talla').prop('disabled',false);
            $(document).find('#b_eliminar').prop('disabled',false);
            $('#s_id_area').prop('disabled',true);
            $('#s_id_departamento').prop('disabled',true);
            $('#b_importar_requis').prop('disabled',true);
    
        }

        function deshabilita(){
            $('#form_orden_compra input,textarea,select,input:radio').prop('disabled',true);
            $('#form_editar_producto input').prop('disabled',true);
            $('#b_buscar_productos').prop('disabled',true);
            $('#b_importar_requis').prop('disabled',true);
            $('#b_guardar').prop('disabled',true);
            $('#b_buscar_proveedor').prop('disabled',true);
            $('#b_buscar_facturar').prop('disabled',true);
            $(document).find('#b_talla').prop('disabled',true);
            $(document).find('#b_eliminar').prop('disabled',true);

            
        }

        function verificaRequiImportadas(){
            var requis='';
            var folios='';
        
            $("#t_partidas .partida-oc").each(function() {

                var folio=$(this).attr('folio');
                var idRequi=$(this).attr('requi');

                if(folio>0 && folios.indexOf(folio)==-1){
                    folios=folios+ folio+",";
                }

                if(idRequi>0 && requis.indexOf(idRequi)==-1){
                    requis=requis+ idRequi+",";
                }
            });  
            //--- se asignan los folios de requisisones
            if(folios.substr(-1)==','){
                $('#i_requisiciones').val(folios.substr(0, (folios.length-1)));
            }else{
                $('#i_requisiciones').val(folios);
            } 
            //--- se asignan los folios de ids de requisiciones
            if(requis.substr(-1)==','){
                $('#ids_requisiciones').val(requis.substr(0, (requis.length-1)));
            }else{
                $('#ids_requisiciones').val(requis);
            }         
        }

          /*********************inicio llena lista tallas*********************/
          function muestraTallas(){
            $('#lista_tallas').empty();
            $.ajax({
                type: 'POST',
                url: 'php/tallas_buscar_lista.php',
                dataType:"json", 
                success: function(data) {
                    $('#lista_clientes').empty();
                    for(var i=0;data.length>i;i++){

                        var html='<option value="'+data[i].talla+'"></option>';
                        
                        $('#lista_tallas').append(html);
                    }
                },
                error: function (xhr) {
                    console.log('tallas_buscar_lista.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar tallas.');
                }
            });
        }

        $('#b_imprimir').click(function(){

            var impresa=$(this).attr('alt');
            
            if(parseInt(impresa)==0){
                $.ajax({
                    type: 'POST',
                    url: 'php/orden_compra_actualiza_estatus_impresa.php',
                    dataType:"json", 
                    data:{
                        'idOrden':idOrdenCompra
                    },
                    success: function(data)
                    {
                        if(data==1){
                            $('#d_estatus_oc').text('').removeAttr('class');
                            $('#d_estatus_oc').addClass('alert alert-sm alert-success').text('IMPRESA');
                            deshabilita();
                            mandarMensaje('Esta orden de compra: '+ $('#i_folio').val() + ' ya no podrá ser editada');
                        }else{
                            mandarMensaje('Ocurrio un error al cambiar a estatus impresa');
                        }
                    },
                    error: function (xhr)
                    {
                        console.log('php/orden_compra_actualiza_estatus_impresa.php-->'+ JSON.stringify(xhr));
                        mandarMensaje('* Ocurrio un error al cambiar a estatus impresa');
                    }
                });

            }
           

            var datos = {
                'path':'formato_orden_compra',
                'idRegistro':idOrdenCompra,
                'nombreArchivo':'orden_compra',
                'tipo':1
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
          
        });

        $('#b_pre_imprimir').click(function()
        {

            var datos = {
                'path':'formato_pre_orden_compra',
                'idRegistro':idOrdenCompra,
                'nombreArchivo':'pre_orden_compra',
                'tipo':1
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
          
        });

        function muestraDepartamentoAreaInternosO(idSelect, idSucursal, idArea, idDepartamento){

            $('#'+idSelect).select2();

            $('#'+idSelect).html('');
            var html='<option selected disabled>Elige una Departamento</option>';
            $('#'+idSelect).append(html);

            $.ajax({

                    type: 'POST',
                    url: 'php/combos_buscar.php',
                    dataType:"json", 
                    data:{

                        'tipoSelect' : 'DEPARTAMENTOS_AREA_INTERNOS',
                        'idSucursal': idSucursal,
                        'idArea': idArea 

                    },
                    success: function(data)
                    {
                        if(data != 0)
                        {

                            var arreglo=data;
                            for(var i=0;i<arreglo.length;i++)
                            {
                                var dato=arreglo[i];
                                var html="<option value="+dato.id_depto+">"+dato.des_dep+"</option>";
                                $('#'+idSelect).append(html);
                                if(idDepartamento != 0){    
                                    $('#s_id_departamento').val(idDepartamento);
                                    $('#s_id_departamento').select2({placeholder: $(this).data('elemento')});
                                }else{
                                    $('#s_id_departamento').val('');
                                    $('#s_id_departamento').select2({placeholder: 'Selecciona'});
                                }
                            }

                        }

                    },
                    error: function (xhr) {
                        console.log("muestraDepartamentoAreaInternos: "+JSON.stringify(xhr));  
                        //--MGFS 13-12-2019 se quita el mensaje de que no se encontraron departamentos internos ya se mostraba cada vez que cambiaban de sucursal
                        //--ISSUE DEN18-2468 
                        //mandarMensaje('* No se encontró información de Departamentos Internos');
                    }
            });
        }
       
    });

</script>

</html>