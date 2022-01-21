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
    #div_t_registros{
        height:270px;
        overflow:auto;
    }
    #dialog_buscar_productos > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    #dialog_buscar_entradas_compra > .modal-lg{
        min-width: 80%;
        max-width: 80%;
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
        #dialog_buscar_entradas_compra > .modal-lg{
            max-width: 100%;
        }
    }

    .editar{
        background-color:#B7D6BE;
        text-align:right;
        font-weight:bold;
    }

    .editar > input{
        text-align:right;
        font-weight:bold;
        font-size:12px;
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
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Recepción de Mercancías y Servicios</div>
                    </div>
                   
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Imprime la Recepción de Mercancías y Servicios" class="btn btn-dark btn-sm form-control" id="b_imprimir" ><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                    </div>
                </div>
                <br>

                <form id="forma_entrada_ajuste" name="forma_entrada_ajuste">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group row">
                                <label for="i_folio" class="col-sm-12 col-md-3 col-form-label">No. Mov </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" id="i_folio" name="i_folio" class="form-control form-control-sm" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_fecha" class="col-sm-12 col-md-3 col-form-label">Fecha </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" id="i_fecha" name="i_fecha" class="form-control fecha form-control-sm" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div id="d_estatus_oc" class="alert"></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group row">
                                <label for="s_id_unidades" class="col-sm-12 col-md-4 col-form-label requerido">Unidad Negocio</label>
                                <div class="col-sm-12 col-md-8">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="s_id_sucursales" class="col-sm-12 col-md-4 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-12 col-md-8">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="i_proveedor" class="col-1 col-md-1 col-form-label requerido">Proveedor </label>
                        <div class="input-group col-sm-12 col-md-5">
                            <input type="text" id="i_proveedor" name="i_proveedor" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-info" type="button" id="b_detalle_proveedor" style="margin:0px;">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                            
                        </div>
                        <label for="i_vehiculo" id='l_vehiculo' class="col-auto col-md-auto col-form-label">No Ecónomico Vehículo </label>
                        <div class="input-group col-sm-12 col-md-3">
                        <input type="hidden" id="i_servicio" name="i_servicio">
                            <input type="text" id="i_no_economico" name="i_no_economico" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                            <!--<div class="input-group-btn">
                                <button class="btn btn-info" type="button" id="b_buscar_activo" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>-->
                            
                        </div>
                        
                    </div>
                </form>
                <hr><!--LInea gris -->

                
                <div class="row">
                    <div class="col-sm-4 col-md-1"></div>
                    <label for="i_oc" class="col-sm-12 col-md-1 col-form-label"><strong>OC </strong></label>
                    <div class="col-sm-12 col-md-2">
                        <input type="text" id="i_oc" name="i_oc" class="form-control form-control-sm" autocomplete="off" readonly>
                        <input type="hidden" name="i_id_orden" id="i_id_orden">
                    </div>
                    <div class="col-sm-4 col-md-1"></div>
                    <div class="col-sm-4 col-md-4">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Importar Ordenes de Compra " class="btn btn-success btn-sm form-control" id="b_importar_oc"><i class="fa fa-download" aria-hidden="true"></i> Importar Orden Compra</button>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon" id="t_partidas" border="2">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col" width="5%">Partida</th>
                                    <th scope="col" width="5%">Catálogo</th>
                                    <th scope="col" width="10%">Familia</th>
                                    <th scope="col" width="20%">Concepto</th>
                                    <th scope="col" width="10%">Cantidad</th>
                                    <th scope="col" width="10%">Recibiendo</th>
                                    <th scope="col" width="10%">Costo Unit<br> OC</th>
                                    <th scope="col" width="10%">Costo Unit<br> Factura</th>
                                    <th scope="col" width="5%">Des%</th>
                                    <th scope="col" width="5%">IVA%</th>
                                    <th scope="col" width="9%">Importe sin/IVA</th>
                                    <th scope="col" width="5%"></th>
                                    <th scope="col" width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table><!--//--MGFS 21-01-2020 SE AGREGA VALIDACION PARA QUE TODAS LAS PARTIDAS LLEVEN POR LO MENOS CANTIDAD 1-->
                        <div id="div_t_registros">
                            <form id="formPartidas" name="fromPartidas">
                            <table class="tablon"  id="t_registros">
                                <tbody>
                                    
                                </tbody>
                            </table>
                            </form>  
                        </div>  
                        <table>
                            <tfoot>
                                   
                                <tr class="tr_totales">
                                    <th scope="col" width="70%"></th>
                                    <th scope="col" colspan="2"  width="10%">SUBTOTAL</th>
                                    <th scope="col" width="9%">
                                        <input type="text" id="i_subtotal" name="i_subtotal" readonly class="validate[required] i_t" autocomplete="off"/>
                                    </th>
                                    <th scope="col" colspan="2" width="10%"></th>
                                </tr>
                                <tr  class="tr_totales">
                                    <th scope="col" width="70%"></th>
                                    <th scope="col" colspan="2"  width="10%">IVA</th>
                                    <th scope="col" width="9%">
                                        <input type="text" id="i_total_iva" name="i_total_iva" readonly class="validate[required] i_t" autocomplete="off"/>
                                    </th>
                                    <th scope="col" colspan="2" width="10%"></th>
                                </tr>
                                <tr  class="tr_totales">
                                    <th scope="col" width="70%"></th>
                                    <th scope="col" colspan="2"  width="10%">TOTAL</th>
                                    <th scope="col" width="9%" >
                                        <input type="text" id="i_total" name="i_total" readonly class="validate[required] i_t" autocomplete="off"/>
                                    </th>
                                    <th scope="col" colspan="2" width="10%"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

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

<div id="dialog_importar_oc" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Ordenes Pendientes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_importar_oc" id="i_filtro_importar_oc" alt="renglon_oc" class="filtrar_renglones form-control filtrar_renglones"  placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_importar_oc">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">OC</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Requisicion</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Partidas</th>
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
                <div class="col-sm-12 col-md-6">
                    <label for="i_t_total">Total de Productos restantes</label>
                    <input type="text" text-align="center" id="i_t_total" name="i_t_total" class="form-control col-md-5" readonly >
                    <input type="hidden" text-align="center" id="i_t_total_a" name="i_t_total_a" value="0" class="form-control">
                    <input type="hidden" text-align="center" id="i_t_numero_partida" name="i_t_numero_partida" class="form-control"  >                    
                    <datalist id="lista_tallas"></datalist>
                    <label for="i_t_talla">Talla</label>
                    <input type="text" id="i_t_talla" name="lista_tallas"  list="lista_tallas" class="form-control" autocomplete="off">
                    <label for="i_t_cantidad">Cantidad</label>
                    <input type="text" id="i_t_cantidad" name="i_t_cantidad" class="form-control col-md-5" autocomplete="off">
                    <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar_talla"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                    </div>
                    <div class="col-sm-12 col-md-6" style='overflow:auto; max-height:280px;'>
                        <table class="tablon"  id="t_tallas_solicitadas">
                        <thead>
                            <tr class="renglon">
                                <th scope="col" colspan="2">Tallas Solicitadas en OC</th> 
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
                            <th scope="col" width="8%"></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                    <button type="button" class="btn btn-success btn-sm form-control" id="b_guardar_talla"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_buscar_entradas_compra" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de  Recepción de Mercancías y Servicios</h5>
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
                                <input type="text" name="i_filtro_entradas_compra" id="i_filtro_entradas_compra" alt="renglon_entradas_compra" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_entradas_compra">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">No. Movimiento</th>
                                    <th scope="col">Folio OC</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Usuario Captura</th>
                                    <th scope="col">Partidas</th>
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

<!-- Modal Buscar Activo -->
<div id="dialog_buscar_activos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-right: 17px;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buscar Activos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_buscar_activos">
          <div class="row">
             <div class="col-auto">
              <label class="col-form-label">No. Económico:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_busca_no_economico" name="i_busca_no_economico" class="form-control form-control-sm" autocomplete="off">
            </div>

            <div class="col-auto">
              <label for="s_buscar_tipo" class="col-form-label"> Tipo:</label>
            </div>
            <div class="col-md-4">
              <select id="s_buscar_tipo" name="s_buscar_tipo" class="form-control form-control-sm">
                <option selected="true" disabled="disabled">Seleccione el Tipo:</option>
                <option value="1">Vehículo</option>
                <option value="2">Celular</option>
                <option value="3">Equipo de Computo</option>
                <option value="4">Otro</option>
                <option value="">Todos</option>
              </select>
            </div>

          </div>

          <div class="row">
            <div class="col-auto">
              <label class="col-form-label">Filtrar</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="i_filtro_activos" id="i_filtro_activos" alt="activo_renglon" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"> 
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-sm-12 col-md-12" style="height:480px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">No. Serie</th>
                    <th scope="col">No. Economico</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Tipo</th>
                  </tr>
                </thead>
                <tbody id="t_buscar_activo">

                </tbody>
              </table>
            </div>
            <div class="col-md-2">
            </div>
          </div>
        </div>
      </form>
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
 
    var modulo='RECEPCION_MERCANCIA_SERVICIOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var idEntradaCompra=0;
    var tipoMov=0;
    var tipoOC = 0; //--3=stock 0=activo fijo 2= mantenimiento

    $(function(){
        mostrarBotonAyuda(modulo);

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraTallas();
        $('#b_imprimir').prop('disabled',true);
        $('#b_buscar_activo').prop('disabled',true);

        var fecha = new Date();
        if(fecha.getMonth() <9)
        {
            var mes = '0'+(fecha.getMonth()+1);
        }else{
            var mes = fecha.getMonth()+1;
        }

        if(fecha.getDate() < 9)
        {
            var dia = '0'+fecha.getDate();
        }else{
            var dia = fecha.getDate();
        }

        var fecha_hoy = fecha.getFullYear() + "-" + mes + "-" + dia;
        $('#i_fecha').val(fecha_hoy);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

               
        $('#s_id_unidades').change(function(){
            var idUnidadNegocio = $('#s_id_unidades').val();
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
        });

        $('#b_nuevo').click(function(){
            limpiar();
        });

        $('#b_buscar_proveedor').click(function(){
            $('#i_filtro_proveedor').val('');
            muestraModalProveedores('renglon_proveedor','t_proveedores tbody','dialog_proveedores');
        });

        $('#t_proveedores').on('click', '.renglon_proveedor', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_proveedor').attr('alt',id).val(nombre);
            $('#dialog_proveedores').modal('hide');
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
                        mandarMensaje('* Error en el sistema');
                    }
                });
            }else{
                mandarMensaje('Primero debes selecionar un proveedor');
            }
        });

    //****************IMPORTAR ORDENES DE COMPRA***************************** */
    $('#b_importar_oc').on('click',function(){

        if(($('#s_id_unidades').val() != null) && ($('#s_id_sucursales').val() != null))
        {
            $('#i_filtro_importar_oc').val('');

            var idUnidad = $('#s_id_unidades').val();
            var idSucursal = $('#s_id_sucursales').val();
            $('#t_importar_oc >tbody tr').remove();

            $.ajax({
                type: 'POST',
                url: 'php/orden_compra_buscar_importar.php',
                dataType:"json", 
                data:{
                    'idUnidadNegocio':idUnidad,
                    'idSucursal':idSucursal
                },
                success: function(data)
                {

                    for(var i=0; data.length>i; i++)
                    {

                        var oc = data[i];

                        var infoM='';
                        if(oc.no_economico!=''){
                            infoM="title='Requsición para el No Económico: "+oc.no_economico+"'";
                        }

                        //-->NJES Feb/13/2020 se agregan para enviar parametros area y departamento para poder afectar presupuesto cuando es una entrada de tipo mantenimiento
                        //-->NJES March/23/2020 se agrega folios y id de requis de la oc importada en la entrada compra
                        var html = "<tr class='renglon_oc' "+infoM+" alt='" + oc.id + "' alt1='" + oc.folio + "' alt2='" + oc.id_proveedor + "' alt3='" + oc.proveedor + "' alt4='"+oc.tipo+"' alt5='"+oc.no_economico+"' area='"+oc.id_area+"' depto='"+oc.id_departamento+"' ids_requis='"+oc.ids_requisiciones+"' folios_requis='"+oc.requisiciones+"' fam_fletes='"+oc.fam_fletes+"' b_anticipo='"+oc.b_anticipo+"'>";
                        html += "<td>" + oc.folio + "</td>";
                        html += "<td>" + oc.fecha + "</td>";
                        html += "<td>" + oc.concepto_tipo + "</td>";
                        html += "<td>" + oc.requisiciones + "</td>";
                        html += "<td>" + oc.proveedor + "</td>";
                        html += "<td>" + oc.partidas + "</td>";
                        html += "</tr>";

                        $('#t_importar_oc tbody').append(html);
                    
                    }

                    $('#dialog_importar_oc').modal('show');

                },
                error: function (xhr)
                {   
                    console.log('php/orden_compra_buscar_importar.php-->'+ JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }else{
            mandarMensaje('Seleccionar Unidad de Negocio y Sucursal para buscar información');
        }
    });

    $("#t_importar_oc").on('click',".renglon_oc",function(){

        var idOrden = $(this).attr('alt');
        var folio = $(this).attr('alt1');
        var idProveedor = $(this).attr('alt2');
        var proveedor = $(this).attr('alt3');
        tipoOC = $(this).attr('alt4');//--3=stock 0=activo fijo 2= mantenimiento
        /* MGFS 23-10-2019 para ingresar en la recepcion de mercancias 
        el no de economico de un vehiculo si el oc  es de tipo 2=MANTENIMIENTO*/
        $('#i_no_economico').removeAttr('class');
        //---MGFS 27-01-2020 SE AGREGA EL no economico de las requis importadas en la oc importada
        var noEconomico = $(this).attr('alt5');

        var idArea = $(this).attr('area');
        var idDepartamento = $(this).attr('depto');
        //-->NJES March/23/2020 se agrega folios y id de requis de la oc importada en la entrada compra
        var ids_requis = $(this).attr('ids_requis');
        var folios_requis = $(this).attr('folios_requis');

        var fam_fletes = $(this).attr('fam_fletes');

        var b_anticipo = $(this).attr('b_anticipo');
    
        if(parseInt(tipoOC)==2){
            $('#l_vehiculo').addClass('requerido');
            $('#i_no_economico').val(noEconomico);
            $('#i_no_economico').addClass('form-control form-control-sm validate[required]');
            $('#i_servicio').val(1);
            $('#b_buscar_activo').attr('alt',idOrden).prop('disabled',false);
        }else{
            $('#l_vehiculo').removeClass('requerido');
            $('#i_no_economico').addClass('form-control form-control-sm');
            $('#i_servicio').val(0);
            $('#b_buscar_activo').attr('alt',0).prop('disabled',true);
        }

        //-->NJES Feb/13/2020 se agregan para enviar parametros area y departamento para poder afectar presupuesto cuando es una entrada de tipo mantenimiento
        $('#i_oc').val(folio).attr({'area':idArea,'depto':idDepartamento,'folios_requis':folios_requis,'ids_requis':ids_requis});
        $('#i_id_orden').val(idOrden);
        $('#i_proveedor').val(proveedor).attr('alt',idProveedor);

        agregaDetalleOc(idOrden,fam_fletes,b_anticipo);

        $('#dialog_importar_oc').modal('hide');
    });

    //****************AGREGA DETALLE DE LA ORDEN SELECIONADA A LA TABLA t_partidas******** */
    function agregaDetalleOc(idOrden,fam_fletes,b_anticipo){
       
        $('.renglon_partida').remove();

        $.ajax({
            type: 'POST',
            url: 'php/orden_compra_buscar_detalle_importar.php',
            dataType:"json", 
            data:{
                'idOrdenCompra':idOrden
            },
            success: function(data)
            {   
                var totalPartidas=0;
                
                for(var i=0; data.length>i; i++)
                {
                    totalPartidas++;

                    var ocD = data[i];
                    //-->NJES December/02/2020 si alguna de las requis involucradas en la OC tiene anticipo no se puede generar la entrada parcial,
                    //debe ser completa porque al momento de generar el cxp y restarle al total el anticipo se estaría haciendo para cada
                    //factura que tenga relación con la entrada y las OC y las requis, ya que si es parcial no se sabria a cuanto equivale el anticipo,
                    //y aparte si por ejemplo tiene un anticipo de 1000 y la entrada la genera parcial por 500 como se va a restar 500-1000 y se genera el cxp por -500, no tiene sentido.
                    
                    //-->NJES November/11/2020 cuando la orden de compra que se importa tiene requis de familia gasto FLETES Y LOGISTICA
                    //se debe generar la entrada por el total de la orden, no puede ser parcial
                    if(b_anticipo > 0)
                    {
                        //GCM - 17/dec/2021 se quita el disabled  -- var disabled = 'disabled';
                        //GCM - 17/dec/2021 se regresa el disabled
                        var disabled = 'disabled';
                        var cant = ocD.faltante;
                        var total = formatearNumero(ocD.faltante*ocD.costo);
                    }else if(fam_fletes > 0)
                    {
                        var disabled = '';
                        var cant = ocD.faltante;
                        var total = formatearNumero(ocD.faltante*ocD.costo);
                    }else{
                        var disabled = '';
                        var cant = 0;
                        var total = formatearNumero(0);
                    }

                    var inputCantidadRecibida='<input '+disabled+' type="text" style="width:100%;" class="validate[min[1],max['+ocD.faltante+']] form-control form-control-sm  cantidad_recibida dato_input" id="i_cantidad_'+totalPartidas+'" value="'+cant+'" alt="' + ocD.id_producto + '" alt3="' + totalPartidas + '" alt4="' + ocD.descuento + '" />';
                    var inputPrecioFactura='<input type="text" style="width:100%;" class="validate[required,min[0.01],max['+ocD.costo+']] numeroMoneda form-control  form-control-sm costo_factura dato_input" id="i_costo_'+totalPartidas+'" alt3="' + totalPartidas + '" alt4="' + ocD.descuento + '" value="' + formatearNumero(ocD.costo) + '"/>';
            
                    var html = "<tr class='renglon_partida' alt='"+totalPartidas+"' idAlmacenD='"+ocD.id+"' verificaTallas='"+ocD.verifica_talla+"' idOrden='"+idOrden+"'  idProducto='" + ocD.id_producto + "' concepto='" + ocD.concepto+ "' idFamilia='" + ocD.id_familia + "' id_familia_gasto='"+ocD.id_familia_gasto+"'>";
                        html += "<td width='5%'>" +totalPartidas+ "</td>";
                        html += "<td width='5%'>" + ocD.id_producto + "</td>";
                        html += "<td width='10%'>" + ocD.familia + "</td>";
                        html += "<td width='20%'>" + ocD.concepto + "</td>";
                        html += "<td align='right' width='10%'>" + ocD.faltante + "</td>";
                        html += "<td align='right' width='10%' class='editar'>" + inputCantidadRecibida + "</td>";
                        html += "<td align='right' width='10%'>" + formatearNumero(ocD.costo) + "</td>";
                        html += "<td align='right' width='10%' class='editar'>" + inputPrecioFactura + "</td>";
                        html += "<td align='right' width='5%' class='descuento'>" + ocD.descuento + "</td>";
                        html += "<td align='right' width='5%' class='iva'>" + ocD.iva + "</td>";
                        html += "<td align='right' width='10%' class='editar importe' id='importe_" +totalPartidas+ "'>" + total + "</td>";
                      
                        var botonTalla = '';
                       
                        if(ocD.verifica_talla == 1)
                        botonTalla = "<button type='button' class='btn btn-primary btn-sm form-control class-" + totalPartidas + "  b_talla' id='b_talla_" + totalPartidas + "' alt='" + ocD.id_producto + "'  alt2='" + ocD.faltante + "'  alt3='" + totalPartidas + "' ><i class='fa fa-list' aria-hidden='true'></i></button><input  class='tallas-i' type='hidden' id='i_talla" + totalPartidas + "'  name='i_talla" + totalPartidas + "' tallas_solicitadas='"+ocD.tallas_solicitadas+"'>";

                        html += "<td width='5%'>" + botonTalla + "</td>";
                        html += "<td width='5%'><button "+disabled+" type='button' class='btn btn-danger btn-sm b_eliminar' id='b_eliminar' alt='" + ocD.id_producto + "'><i class='fa fa-remove' style='font-size:10px;' aria-hidden='true'></i></button></td>";
                        html += "</tr>";

                        // aqui
                        $('#t_registros tbody').append(html);
                        //$('#t_partidas tbody').append(html);
                    
                        if(parseInt(data.length)==parseInt(totalPartidas)){
                            calculaTotales();
                        }
                
                }
               
                

            },
            error: function (xhr)
            {
                console.log('php/orden_compra_buscar_detalle_importar.php-->'+ JSON.stringify(xhr));
                mandarMensaje(xhr.responseText);
            }
        });
    }

    $(document).on('click','#b_eliminar',function(){
        $(this).parent().parent().remove();
        calculaTotales();
    });

        $(document).on('change','.dato_input',function(){
            var partida = $(this).attr('alt3');
            var descuento = $(this).attr('alt4');
            var costo=quitaComa($('#i_costo_'+partida).val());
            var cantidad=$('#i_cantidad_'+partida).val();

           if($(this).validationEngine('validate')==false) {

               

               if(cantidad==''){
                   cantidad=0;
               }

               if(costo==''){
                   precio=0;
               }

               if(costo > 0 && descuento==0){
               
                $('#importe_'+partida).text(formatearNumero(parseInt(cantidad)*parseFloat(costo)));
                calculaTotales();

               }else if(costo > 0 && descuento>0){

                   var importe=parseInt(cantidad)*parseFloat(costo);
                   var descuento=((parseFloat(descuento)*importe)/100);
                   $('#importe_'+partida).text(formatearNumero(importe-descuento));
                   calculaTotales();

               }else{
                $('#importe_'+partida).text(0);
                calculaTotales();
               }

           }else{
            $('#importe_'+partida).text(0);
            calculaTotales();
           }
       });

    function calculaTotales(){
          
          var subtotal=0;
          var totalIva=0;
          var total=0;

          $("#t_registros > tbody tr").each(function() {
             
              var cantidad = $(this).find('.cantidad_recibida').val();
              var costo = quitaComa($(this).find('.costo_factura').val());
              var iva = $(this).find('.iva').text();
              var importe = quitaComa($(this).find('.importe').text());
              var descuento = $(this).find('.descuento').text();
              //alert(cantidad+"--"+costo+"--"+iva+"--"+importe+"--"+descuento);

              if(descuento > 0){
                  
                  var subtotalP=parseInt(cantidad)*parseFloat(costo);
                  var descuentoTotal=((parseFloat(descuento)*subtotalP)/100);
                  
                  subtotal+=(subtotalP-descuentoTotal);

                  totalIva+=((parseInt(cantidad)*parseFloat(costo))-descuentoTotal)*(iva/100);

              }else{

                  subtotal+=parseInt(cantidad)*parseFloat(costo);
                  totalIva+=(parseInt(cantidad)*parseFloat(costo))*(iva/100);
              }
              
          
              
          });
         
            $('#i_subtotal').val(formatearNumero(subtotal));
            $('#i_total_iva').val(formatearNumero(totalIva));
            $('#i_total').val(formatearNumero(subtotal+totalIva));
           
      }

      function calculaTotal(){
          
          var subtotal=0;
          var totalIva=0;
          var total=0;

          $("#t_registros > tbody tr").each(function() {
             
              var cantidad = $(this).attr('cantidad');
              var costo = $(this).attr('precio');
              var iva = $(this).attr('iva');
              var importe = parseFloat(cantidad) * parseFloat(costo);
              var descuento = $(this).attr('descuento');
             
              if(descuento > 0){
                  
                  var subtotalP=parseInt(cantidad)*parseFloat(costo);
                  var descuentoTotal=((parseFloat(descuento)*subtotalP)/100);
                  
                  subtotal+=(subtotalP-descuentoTotal);

                  totalIva+=((parseInt(cantidad)*parseFloat(costo))-descuentoTotal)*(iva/100);

              }else{

                  subtotal+=parseInt(cantidad)*parseFloat(costo);
                  totalIva+=(parseInt(cantidad)*parseFloat(costo))*(iva/100);
              }
              
          
              
          });
         
            $('#i_subtotal').val(formatearNumero(subtotal));
            $('#i_total_iva').val(formatearNumero(totalIva));
            $('#i_total').val(formatearNumero(subtotal+totalIva));
           
      }

        $('#b_guardar').on('click',function(){
            $('#b_guardar').prop('disabled',true);
            
            //--MGFS 21-01-2020 SE AGREGA VALIDACION PARA QUE TODAS LAS PARTIDAS LLEVEN POR LO MENOS CANTIDAD 1
            //-- YA QUE SE GUARDO UNA ENTRADA PARA CAUIDILLO EN 0--
            if ($('#forma').validationEngine('validate') && $('#formPartidas').validationEngine('validate')){

                if($('#t_registros .renglon_partida').length > 0)
                {
                    var verificaPartidas = validarTallas();
                    if(verificaPartidas == false){
                        guardar();
                    }else{
                        mandarMensaje('Algunas Partidas necesitan especificar las tallas, favor de verificar.')
                        $('#b_guardar').prop('disabled',false);
                    }
                }else{
                    mandarMensaje('Debe existir por lo menos un producto para generar la Recepción');
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });


        function guardar(){
            
            var datos = {
                'tipoMov' : tipoMov,
                'idEntradaCompra' : idEntradaCompra,
                'cveConcepto' : 'E01',
                'folio' : $('#i_folio').val(),
                'idOrden' : $('#i_id_orden').val(),
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idProveedor' : $('#i_proveedor').attr('alt'),
                'idUsuario' : idUsuario,
                'usuario' : usuario,
                'noPartidas' : $('#t_registros .renglon_partida').length,
                'noEconomico' : $('#i_no_economico').val(),
                'servicio' : $('#i_servicio').val(),
                'tipoOC' :tipoOC,
                'partidas' : obtenerPartidas(),
                //-->NJES Feb/13/2020 se envian parametros para poder afectar presupuesto cuando es una entrada de tipo mantenimiento
                'idArea' : $('#i_oc').attr('area'),
                'idDepartamento' : $('#i_oc').attr('depto'),
                'importe' : quitaComa($('#i_total').val()),
                //-->NJES March/23/2020 se agrega folios y id de requis de la oc importada en la entrada compra para guardar en la bitacora de activos
                'foliosRequis' : $('#i_oc').attr('folios_requis'),
                'idsRequis' : $('#i_oc').attr('ids_requis')
            };
            
            $.ajax({
                type: 'POST',
                url: 'php/entradas_compra_guardar.php',
                data:  datos,
                success: function(data)
                {
                   console.log(data);
                    if(data > 0)
                    { //-->Se actualizaron los datos de cotización y proyectos
                        //imprimir cotización
                        mandarMensaje('La recepción de mercacias y servicios: '+data+' se guardó correctamente');
                        limpiar();
                    
                    }else{ //-->No se actualizaron los datos del proyecto
                        mandarMensaje('Error al guardar--.');
                        $('#b_guardar').prop('disabled',false);
                    }
                    
                },
                error: function (xhr) 
                {
                    console.log('php/entrada_almacen_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                    $('#b_guardar').prop('disabled',false);
                }
            });
               
        }

        //****************OBTENER PARTIDAS***************** */
        function obtenerPartidas(){
            
            var j = 0;
            var arreDatos = [];
            
            $("#t_registros .renglon_partida").each(function() {
                var nPartida = $(this).attr('alt');
                var idAlmacenD = $(this).attr('idAlmacenD');
                var idOrden = $(this).attr('idOrden');
                var idProducto = $(this).attr('idProducto');
                var concepto = $(this).attr('concepto');
                var cantidad = $(this).find('.cantidad_recibida').val();
                var iva = $(this).find('.iva').text();
                var descuento = $(this).find('.descuento').text();
                var costo = quitaComa($(this).find('.costo_factura').val());
                //-->NJES November/11/2020 enviar la familia gasto y el importe por partida para afectar presuúesto cuando el de FLETES Y LOGISTICA
                var id_familia_gasto = $(this).attr('id_familia_gasto');
                var importe = $(this).find('.importe').text();

                var lleva_tallas = $(this).attr('verificaTallas');
                var tallas = $(this).find('.tallas-i').val();
                if(tallas == undefined)
                    tallas = '';

                arreDatos[j] = {
                   'nPartida' : nPartida,
                   'idOrden' : idOrden,
                   'idProducto' : idProducto,
                   'idAlmacenD' : idAlmacenD,
                   'concepto' : concepto,
                   'cantidad' : cantidad,
                   'iva' : iva,
                   'descuento' : descuento,
                   'costo' : costo,
                   'llevaTallas' : lleva_tallas,
                   'tallas' : tallas,
                   'id_familia_gasto' : id_familia_gasto,
                   'importe' : importe
                };
                j++;
            });
            
            return arreDatos;
        }


        $(document).on('change','.cantidad_recibida',function(){

            var recibida = $(this).val();
            var nPartida = $(this).attr('alt3');
            var tallasAgregadas = $('#i_talla' + nPartida).val();

            $(document).find('#b_talla_'+nPartida).attr('alt2',recibida);
        });


       
         $(document).on('click','.b_talla',function()
         { 
            var idProducto = $(this).attr('alt');
            var cantidad = $(this).attr('alt2');
            var nPartida = $(this).attr('alt3');
            var tallasAgregadas = $('#i_talla' + nPartida).val();
            var tallasSolicitadas = $('#i_talla' + nPartida).attr('tallas_solicitadas');

            $('#b_agregar_talla').prop('disabled',false);
            $('#b_guardar_talla').prop('disabled',false);
            $('#b_eliminar_talla').prop('disabled',false);
            $('#i_t_talla').prop('disabled',false);
            $('#i_t_cantidad').prop('disabled',false);
            

            $('#i_t_total').val(0);
            $('#i_t_total_a').val(0);
            $('#i_t_numero_partida').val('');
            $('#i_t_talla').val('');
            $('#i_t_cantidad').val('');
            $('#t_tallas >tbody tr').remove();
            $('#t_tallas_solicitadas >tbody tr').remove();
            $('#i_t_numero_partida').val(nPartida);


            if(tallasSolicitadas!=''){
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
            }

            
            if(tallasAgregadas == ''){
                $('#i_t_total').val(cantidad);
    
            }
            else
            {

                $('#i_t_total').val(cantidad);
                $('#i_t_total_a').val(cantidad);
                var tallasArray = JSON.parse(tallasAgregadas);
                for(var i=0; tallasArray.length>i; i++)
                {

                    var tallaActual = tallasArray[i];
                    var html = "<tr alt='" + tallaActual.talla + "' alt2='" + tallaActual.cantidad + "' >";
                    html += "<td>" + tallaActual.talla + "</td>";
                    html += "<td>" + tallaActual.cantidad + "</td>";
                    html += "<td><button type='button' class='btn btn-danger btn-sm form-control' alt='" + tallaActual.talla + "' alt2='" + tallaActual.cantidad + "' id='b_eliminar_talla'><i class='fa fa-remove' aria-hidden='true'></i></button></td>";
                    html += "</tr>"

                    $('#t_tallas tbody').append(html);

                }


            }

            if(tipoMov==1){
                $('#b_agregar_talla').prop('disabled',true);
                $('#b_guardar_talla').prop('disabled',true);
                $('#b_eliminar_talla').prop('disabled',true);
                $('#i_t_talla').prop('disabled',true);
                $('#i_t_cantidad').prop('disabled',true);
            }
            
            $('#dialog_agregar_tallas').modal('show');

        });

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

            if(verifica == true)
            {
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

        $('#b_guardar_talla').click(function()
        {
            $('#b_guardar_talla').prop('disabled',true);

            var totalProdutos = $('#i_t_total').val();
            var totalProdutosAgregados = $('#i_t_total_a').val();
            var nPartida = $('#i_t_numero_partida').val();
        
            if(parseFloat(totalProdutos) != parseFloat(totalProdutosAgregados))
            {
                $('#b_guardar_talla').prop('disabled',false);
                mandarMensaje('No corresponde el total de productos con tallas asignadas con el total de productos de los productos recibidos. Verificar.');
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

        $(document).on('click','#b_eliminar_talla',function()
         {
            $(this).parent().parent().remove();
            var cantidad = $(this).attr('alt2');
            var totalA = $('#i_t_total_a').val();

            $('#i_t_total_a').val(parseInt(totalA) - parseInt(cantidad));

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


        $('#b_buscar').click(function(){
            muestraSelectUnidades(matriz,'s_filtro_unidad',$('#s_id_unidades').val());
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_id_unidades').val(),modulo,idUsuario);
            $('form').validationEngine('hide');
            $('#i_filtro_entradas_compra').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');
            $('#dialog_buscar_entradas_compra').modal('show');
            $('.renglon_entradas_compra').remove();
            
        });

        $(document).on('change','#s_filtro_unidad',function(){
            if($('#s_filtro_unidad').val()!= ''){
                $('.img-flag').css({'width':'50px','height':'20px'});
            }
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);
            $('#i_filtro_entradas_compra').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');
            $('.renglon_entradas_compra').remove();
        });

        $(document).on('change','#s_filtro_sucursal',function(){
          
            buscarEntradasPorCompra();
            $('#i_fecha_inicio').prop('disabled',false);
        });

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '' && $('#s_filtro_sucursal').val()!='')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscarEntradasPorCompra();
            }else{
                mandarMensaje('Debes ingresar una sucursal');
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_filtro_sucursal').val()!=''){
                buscarEntradasPorCompra();
            }else{
                mandarMensaje('Debes ingresar una sucursal');
            }
        });

        function buscarEntradasPorCompra(){
            $('.renglon_entradas_compra').remove();

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idUnidadNegocio': $('#s_filtro_unidad').val(),
                'idSucursal':$('#s_filtro_sucursal').val(),
                'tipoEntrada':'E01'
            }; 

            $.ajax({

                type: 'POST',
                url: 'php/entradas_compra_buscar.php',
                dataType:"json", 
                data:{'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_entradas_compra" alt="'+data[i].id+'" alt1="' + data[i].folio+ '" alt2="'+data[i].id_unidad_negocio+'" alt3="'+data[i].id_sucursal+'" alt4="'+data[i].id_proveedor+'" alt5="'+data[i].proveedor+'" alt6="'+data[i].id_oc+'" alt7="'+data[i].fecha+'" alt8="' + data[i].sucursal + '"  alt9="' + data[i].folio + '" alt10="' + data[i].folio_ec + '" alt11="' + data[i].no_economico + '" alt12="' + data[i].servicio + '" alt13="' + data[i].tipo_oc + '">\
                                        <td data-label="No. Movimiento">' + data[i].folio_ec+ '</td>\
                                        <td data-label="OC">' + data[i].folio+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="Proveedor">' + data[i].proveedor+ '</td>\
                                        <td data-label="Usuario Captura">' + data[i].usuario+ '</td>\
                                        <td data-label="Partidas">' + data[i].partidas+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_entradas_compra tbody').append(html);   
                              
                        }
                    }else{

                            mandarMensaje('No se encontró información');
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/entradas_compra_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#t_entradas_compra').on('click', '.renglon_entradas_compra', function()
        {


            muestraSucursalesPermiso('s_id_sucursales',$(this).attr('alt2'),modulo,idUsuario);
            idEntradaCompra = $(this).attr('alt');
            var noMov = $(this).attr('alt1');
            var idUnidad = $(this).attr('alt2');
            var idSucursal = $(this).attr('alt3');
            var idProveedor = $(this).attr('alt4');
            var proveedor = $(this).attr('alt5');
            var idOc = $(this).attr('alt6');
            var fecha = $(this).attr('alt7');
            var sucursal = $(this).attr('alt8');
            var folioOC = $(this).attr('alt9');
            var folioEC = $(this).attr('alt10');

            var noEconomico = $(this).attr('alt11');
            var servicio = $(this).attr('alt12');
            tipoOC = $(this).attr('alt13');

            $('#i_folio').val(folioEC);
            $('#i_oc').val(folioOC);
            $('#i_fecha').val(fecha);
            $('#i_proveedor').val(proveedor).attr('alt', idProveedor);

            $('#i_no_economico').val(noEconomico);
            $('#i_servicio').val(servicio);

            $('#s_id_unidades').val(idUnidad);
            $("#s_id_unidades").select2({
                templateResult: setCurrency,
                templateSelection: setCurrency
            });

            $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

            if(idSucursal != 0)
            {
                optionSurucursal = new Option(sucursal, idSucursal, true, true);
                $('#s_id_sucursales').append(optionSurucursal);

            }
            else
            {
                $('#s_id_sucursales').val('');
                $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
            }

            tipoMov = 1;
            $('#dialog_buscar_entradas_compra').modal('hide');
            $('#b_guardar').prop('disabled',true);
            $('#b_imprimir').prop('disabled',false);
            $('#s_id_sucursales').prop('disabled',true);
            $('#forma_entrada_ajuste').find(' input,select').prop('disabled',true);
            $('#b_importar_oc').prop('disabled',true);
            muestraRegistroDetalle(idEntradaCompra);
            

        });

        function muestraRegistroDetalle(idEntradaCompra){

            $('#t_registros tbody').empty();
            $.ajax({
                type: 'POST',
                url: 'php/entradas_compra_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idEntradaCompra':idEntradaCompra
                },
                success: function(data)
                {
                    var totalPartidas = 0;
                    
                    for(var i=0; data.length>i; i++)
                    {

                        var detalle = data[i];

                        totalPartidas++;

                        var html = "<tr class='renglon_partida' alt='" + totalPartidas +  "' producto='" + detalle.id_producto + "' concepto='" + detalle.concepto+ "' id_familia='" + detalle.id_familia + "' familia='" + detalle.familia + "' id_linea='" + detalle.id_linea + "' linea='" + detalle.linea + "' precio='" + detalle.precio + "' cantidad='" +  detalle.cantidad + "' costo='" + redondear(parseFloat(detalle.costo_unitario) * parseInt(detalle.cantidad)) + "' descripcion='" + detalle.descripcion + "' justificacion='" + detalle.justificacion + "' iva='" + detalle.iva + "' descuento='" + detalle.descuento + "' >";
                        html += "<td width='5%'>" + detalle.partida + "</td>";
                        html += "<td width='5%'>" + detalle.id_producto + "</td>";
                        html += "<td width='10%'>" + detalle.familia + "</td>";
                        html += "<td width='20%'>" + detalle.concepto + "</td>";
                        html += "<td width='10%' align='right'>" + detalle.cantidad_oc + "</td>";
                        html += "<td width='10%' align='right' class='editar'>" + detalle.cantidad + "</td>";
                        
                        html += "<td width='10%' align='right'>" +formatearNumero( detalle.precio_oc )+ "</td>";

                        html += "<td width='10%' align='right'>" +formatearNumero( detalle.precio )+ "</td>";
                        html += "<td width='5%' align='right' class='editar'>" + detalle.descuento + "</td>";
                        html += "<td width='5%' align='right' class='editar'>" + detalle.iva + "</td>";
                        html += "<td width='9%' align='right' class='editar'>" + formatearNumero( detalle.precio * detalle.cantidad )+ "</td>";
                                    
                        var botonTalla = '';
                        if(detalle.verifica_talla == 1)
                        {

                            botonTalla = "<button type='button' class='btn btn-success btn-sm form-control b_talla' id='b_talla_" + detalle.id_producto + "' alt='" + detalle.id_producto + "'  alt2='" + detalle.cantidad + "'  alt3='" + totalPartidas + "' ><i class='fa fa-list' aria-hidden='true'></i></button><input  class='tallas-i' type='hidden' id='i_talla" + totalPartidas + "'  name='i_talla" + totalPartidas + "' value='" + detalle.tallas + "' tallas_solicitadas='" + detalle.tallas_solicitadas + "'>";

                        }

                        html += "<td width='5%'>" + botonTalla + "</td>";

                        html += "<td width='5%'><button type='button' class='btn btn-danger btn-sm form-control' id='b_eliminar' alt='" + detalle.id_producto + "' disabled><i class='fa fa-remove' aria-hidden='true'></i></button></td>";

                        html += "</tr>";

                        // aqui

                        $('#t_registros tbody').append(html);
                       
                        if(parseInt(i)==parseInt((data.length)-1)){
                            calculaTotal();
                        }
                                
                    }

         
                },
                error: function (xhr)
                {
                    console.log('php/entradas_compra_buscar_detalle.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        function limpiar(){
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            $('input,textarea').not(':radio').val('');
            $('#i_oc').attr({'area':0,'depto':0});
            $('#i_proveedor').attr('alt',0);
            $('#t_registros tbody').empty();
            $('#d_estatus_oc').text('').removeAttr('class');
            $('.fecha').val(fecha_hoy);
            $('#b_guardar').prop('disabled',false);
            $('#b_imprimir').prop('disabled',true);
            $('#s_id_sucursales').prop('disabled',false);
            $('#s_id_unidades').prop('disabled',false);
            $('#b_importar_oc').prop('disabled',false);
            tipoMov=0;
            idEntradaCompra=0;
            tipoOC=0;
            $('#l_vehiculo').removeClass('requerido');
            $('#i_no_economico').removeAttr('class');
            $('#i_no_economico').prop('disabled',true).addClass('form-control form-control-sm');
            $('#i_servicio').val(0);
            $('#b_buscar_activo').prop('disabled',true);
        }

        function limpiarNoUNidad(){

            $('input,textarea').not(':radio').val('');
            $('#i_proveedor').attr('alt',0);
            $('#t_registros tbody').empty();
            $('#d_estatus_oc').text('').removeAttr('class');
            $('.fecha').val(fecha_hoy);
            $('#b_guardar').prop('disabled',false);
            $('#s_id_sucursales').prop('disabled',false);
            $('#b_imprimir').prop('disabled',true);
            tipoMov=0;
            idEntradaCompra=0;
            
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            
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
                    mandarMensaje(' * No se encontró información al buscar tallas.');
                }
            });
        }

        $('#b_imprimir').click(function(){
            if(idEntradaCompra>0){
                var datos = {
                    'path':'formato_entrada_compra',
                    'idRegistro':idEntradaCompra,
                    'nombreArchivo':'recepciondemercanciasyservicios',
                    'tipo':1
                };

                let objJsonStr = JSON.stringify(datos);
                let datosJ = datosUrl(objJsonStr);

                window.open("php/convierte_pdf.php?D="+datosJ,'_new');
            }else{
                mandarMensaje('Debes selecionar una Recepción de mercancías y Servicios');
            }

        });

        /**** MODULO DE NO ECONOMICO QUE VIENE DE ACTIVOS */
        $('#b_buscar_activo').click(function(){
            $("#dialog_buscar_activos").modal('show');
            $("#i_busca_no_economico").val('');
            $("#i_fecha_buscar_activo").val('');
            $("#i_fecha_buscar_activo_fin").val('');
            $("#s_buscar_tipo").val();
            $('#s_buscar_propietario').val('1');
        });

        // Filtros de Historial de Bitacora
        $("#i_busca_no_economico").keyup(function(e){
            buscarActivosFijos();
        });

         // Filtros de Historial de Bitacora
         $("#s_buscar_tipo").on('change',function(e){
            buscarActivosFijos();
        });

        function buscarActivosFijos(){
            $("#i_busca_no_economico").focus();
            var noEconomico = $("#i_busca_no_economico").val();
            var tipo = $("#s_buscar_tipo").val();
    
            $.ajax({
                type: "POST",
                url: "php/activos_buscar_filtro_E01.php",
                data: {'noEconomico':noEconomico,'tipo':tipo},
                dataType: 'json',
                success: function(data){
                  
                    salida = "";
                    tipo = "";
                        for (var i = 0; i < data.length; i++) {
                            actual=data[i];
                            if (actual.tipo==1) {tipo="Vehiculo";}
                            else if (actual.tipo=="2") {tipo="Celular";}
                            else if (actual.tipo==3) {tipo="Equipo de Computo";}
                            else {tipo="Otro";}
                            salida += "<tr class='activo_renglon' alt="+actual.no_economico+">";
                            salida += "<td>" + actual.no_serie + "</td>";
                            salida += "<td>" + actual.no_economico + "</td>";
                            salida += "<td>" + actual.descripcion + "</td>";
                            salida += "<td>" + tipo + "</td>";
                            salida += "</tr>";
                        }
                    $("#t_buscar_activo").empty();
                    $("#t_buscar_activo").html(salida);
                },
                error: function (data){
                    console.log( "php/activos_buscar_filtro_E01.php -->"+JSON.stringify(data));
                    mandarMensaje("* Error con la Busqueda.");
                }
            });
        }

        $('#t_buscar_activo').on('click', '.activo_renglon', function() {
            var noEconomico = $(this).attr('alt');

            $('#i_no_economico').val(noEconomico);

            $('#dialog_buscar_activos').modal('hide');
        });


    });

</script>

</html>