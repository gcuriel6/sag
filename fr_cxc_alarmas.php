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
    body{
        background-color:rgb(238,238,238);
        overflow-x:hidden;

    }
    #div_principal{
      position: absolute;
      top:0px;
      left : -101%;
      height: 100%;
      background-color: rgba(250,250,250,0.6);
      
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        max-height:400px;
        overflow:auto;
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

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_registros{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
    }

    .NOT{
        color:#002699;
        font-size:13px;
    }
    .FAC{
        color:green;
        font-size:13px;
    }
    .CXC{
        color:grey;
        font-size:13px;
    }

    .td_titulo{
        border:1px solid #A3CED7;
        background : rgba(163,206,215,0.3);
        width:300px;
    }

    .td_valor{
        border:1px solid #A3CED7;
        width:500px;
    }

    #dialog_buscar_registros > .modal-lg{
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
    
   #d_estatus{
       padding-top:7px;
       text-align:center;
       font-weight:bold;
       font-size:15px;
       height:40px;
       vertical-align:middle;
   }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            
            <div id="div_contenedor">
            <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban"> CXC ALARMAS</div>
                    </div>
                    <div class="col-sm-12 col-md-3"></div>
                    <div class="col-sm-12 col-md-2">
                        <div class="alert" id="d_estatus" role="alert"></div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_estado_cuenta"><i class="fa fa-info" aria-hidden="true"></i> Estado Cuenta</button>
                    </div>
                </div>

                <form id="forma_cxc" name="forma_cxc">
                
                    <div class="form-group row"><!-- row--->
                        <label for="i_folio" class="col-1 col-md-1 col-form-label requerido">Folio </label>
                        <div class="col-md-3">    
                            <div class="input-group col-sm-12 col-md-12">
                                <input type="text" id="i_folio" name="i_folio" class="form-control" readonly autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="b_buscar_cxc" style="margin:0px;">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <label for="i_cliente" class="col-sm-1 col-md-1 col-form-label requerido">Cliente</label>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_cliente" name="i_cliente" class="form-control  validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div><!-- /row--->     
                    <div class="form-group row">
                        <label for="s_id_sucursales" class="col-sm-1 col-md-1 col-form-label requerido">Sucursal </label>
                        <div class="col-sm-4 col-md-4">
                            <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;" disabled></select>
                        </div>

                        <label for="s_cuenta_banco" class=" col-md-1 col-form-label requerido">Banco</label>
                        <div class="col-md-4">
                            <select id="s_cuenta_banco" name="s_cuenta_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>  
                        </div>
                    </div>  
                    
                        
                    <div class="row form-group">
                        <label for="s_concepto" class="col-md-1 col-form-label"><br>Periodo</label>
                        <div class="col-md-3">
                            <label for="s_mes" class="col-form-label requerido">Mes</label>
                            <select id="s_mes" name="s_mes" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" disabled></select>
                        </div>
                        <div class="col-md-1">
                            <label for="i_anio" class="col-form-label requerido">Año</label>
                            <input type="text" id="i_anio" name="i_anio" class="form-control form-control-sm validate[required,custom[integer],minSize[4],maxSize[4]]"  disabled autocomplete="off">
                        </div>
                        
                        <div class="col-md-2">
                            <label for="i_vencimiento" class="col-form-label requerido">Vencimiento</label>
                            <input type="text" id="i_vencimiento" name="i_vencimiento" class="form-control form-control-sm validate[required] fecha" readonly disabled autocomplete="off">
                        </div>
                        
                        <div class="col-md-5">
                            <label for="" class="col-md-3 col-form-label requerido">Tasa IVA</label>
                            <div class="row"><!-- row--->
                                <div class="col-sm-4 col-md-4">
                                16% <input type="radio" name="radio_iva" id="r_16" value="16" checked>  
                                </div>
                                <div class="col-sm-4 col-md-4">
                                8%  <input type="radio" name="radio_iva" id="r_8" value="8"> 
                                </div>
                            </div>
                        </div>

                    </div> <!-- /row---> 
                        
                    <br> 
                    <div class="row" style="border:1px solid #A3CED7;background:rgba(163,206,215,0.3);padding-bottom:10px;"><!-- row--->
                        <div class="col-md-2">
                            <label for="i_fecha" class="col-form-label requerido">Fecha</label>
                            <input type="text" id="i_fecha" name="i_fecha" class="form-control form-control-sm validate[required] fecha"  autocomplete="off" readonly>
                        </div>
                        
                        <div class="col-md-2">
                        <label for="s_concepto" class="col-form-label requerido">Concepto</label>
                        <select id="s_concepto" name="s_concepto" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>  
                        </div>
                        
                        <div class="col-md-2">
                            <label for="i_importe" class="col-form-label requerido">Importe</label>
                            <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm validate[required] numeroMoneda" readonly autocomplete="off">
                        </div>
                        
                        <div class="col-md-2">
                            <label for="i_total_iva" class="col-form-label requerido">Iva</label>
                            <input type="text" id="i_total_iva" name="i_total_iva" class="form-control form-control-sm validate[required] numeroMoneda" readonly  autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <label for="i_total" class="col-form-label requerido">Total</label>
                            <input type="text" id="i_total" name="i_total" class="form-control form-control-sm validate[required] numeroMoneda" autocomplete="off">
                        </div>
                        
                        <div class="col-md-2">
                            <label for="i_referencia" class="col-form-label requerido">Referencia</label>
                            <input type="text" id="i_referencia" name="i_referencia" class="form-control form-control-sm validate[required]"  autocomplete="off">
                        </div>
                        
                        <div class="col-md-12" style="padding-top:10px;">
                            <div class="row">
                                <label for="i_observaciones" class="col-md-2 col-form-label">Observaciones</label>
                                <div class="col-md-10">
                                <input type="text" id="i_observaciones" name="i_observaciones" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-plus" aria-hidden="true"></i> </button>
                        </div>
                        
                    </div><!-- /row--->
                </form><!--div forma_general-->
             <br>
              <div class="row">
             
                <table class="tablon">
                    <thead>
                        <tr class="renglon">
                            <th scope="col">Fecha</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">IVA</th>
                            <th scope="col">Cargos</th>
                            <th scope="col">Abonos</th>
                            <th scope="col">Referencia</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col">x</th>
                            <th scope="col"></th>
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
              <div class="row" style="border:1px solid #A3CED7;background:rgba(163,206,215,0.3);padding-bottom:10px;"><!-- row--->
                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_ver_saldo_multiple" disabled><i class="fa fa-eye" aria-hidden="true"></i> Ver Saldo</button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <label for="i_saldo" class="col-form-label">SALDO</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="i_saldo" name="i_saldo" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off" readonly>
                    </div>
                </div>      
                
            </div> <!--div_contenedor-->
      </div><!-- fin foma div_nuevo_cxc-->
      
            </div> <!--div_contenedor-->
        </div>      

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

    <div id="dialog_buscar_registros" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Cuentas por Cobrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="row">
                        <label for="s_id_sucursales_n" class="col-sm-12 col-md-4 col-form-label">Sucursal</label>
                        <div class="col-sm-12 col-md-8">
                            <select id="s_id_sucursales_n" name="s_id_sucursales_n" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
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
                    </div>
                </div>  
                </div>  
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <input type="text" name="i_filtro" id="i_filtro" alt="renglon_registros" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                    </div>
                    <div class="col-sm-12 col-md-1" style="text-align:right">ID </div>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" name="i_folio_b" id="i_folio_b" alt="renglon_registros" class="form-control form-control-sm" placeholder="Ingresa ID" autocomplete="off">
                    </div>
                
                </div>
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">ID</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Vencimiento</th>
                                    <th scope="col">Nombre Corto</th>
                                    <th scope="col">Razon Social</th>
                                    <th scope="col">Operación</th>
                                    <th scope="col">Cargo Inicial</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Estatus</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_registros_buscar">
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
    
</body>

<div id="dialog_estado_cuenta" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <label for="i_cliente_e" class="col-md-2 col-form-label requerido">Cliente</label>
                    <div class="col-md-8">
                        <input type="text" id="i_cliente_e" name="i_cliente_e" class="form-control form-control-sm validate[required]" readonly  autocomplete="off">
                    </div>
                    <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_SERVICIOS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-12 col-md-4"> </div>
                        <div class="col-sm-12 col-md-1"></div>
                        <div class="col-sm-12 col-md-4">
                            
                            <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                                <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                                <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                                <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                                <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                            
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-10">
                        <div class="row">
                            <div class="col-sm-12 col-md-1 requerido">Del: </div>
                            <div class="input-group col-sm-12 col-md-4">
                                <input type="text" name="i_fecha_inicio_ec" id="i_fecha_inicio_ec" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div> 
                            <div class="col-sm-12 col-md-1 requerido">Al: </div>
                            <div class="input-group col-sm-12 col-md-4">
                                <input type="text" name="i_fecha_fin_ec" id="i_fecha_fin_ec" class="form-control form-control-sm fecha" autocomplete="off" readonly>
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
                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col">Id Orden</th>
                                    <th scope="col">Folio CXC</th>
                                    <th scope="col">Folio Factura</th>
                                    <th scope="col">Fecha Vencimiento</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Cargos</th>
                                    <th scope="col">Abonos</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_estado_cuenta">
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr class="renglon">
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col" id="total_cargos"></th>
                                        <th scope="col" id="total_abonos"></th>
                                    </tr>
                                    <tr class="renglon">
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">Saldo</th>
                                        <th scope="col" id="total_saldo"></th>
                                    </tr>
                                </tfoot>
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

    <div id="dialog_confirmar_abono" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación de Abono</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    Este cliente Factura, si generas abono ahora no podrá facturar, deseas continuar
                </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" id="b_no_confirmar">NO</button>
                <button type="button" class="btn btn-success btn-sm" id="b_confirmar"> &nbsp;SI&nbsp; </button>
            </div>
            </div>
        </div>
    </div>

    <div id="dialog_ver_saldo_multiple" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información y saldo de relación CxC-Factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            Folio Factura <input type="text" id="i_folio_factura" name="i_folio_factura" class="form-control form-control-sm"  autocomplete="off" readonly>
                        </div>
                        <div class="col-md-3">
                            Total <input type="text" id="i_total_factura" name="i_total_factura" class="form-control form-control-sm"  autocomplete="off" readonly>
                        </div>
                        <div class="col-md-3">
                            Saldo <input type="text" id="i_saldo_factura" name="i_saldo_factura" class="form-control form-control-sm"  autocomplete="off" readonly>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="tablon">
                                <thead>
                                    <tr class="renglon">
                                        <th colspan="7">Registros CxC de factura</th>
                                    </tr>
                                    <tr class="renglon">
                                        <th scope="col">ID</th>
                                        <th scope="col">Folio</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Nombre Corto</th>
                                        <th scope="col">Razón Social</th>
                                        <th scope="col">Operación</th>
                                        <th scope="col">Importe</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="div_t_registros_multiples">
                                <table class="tablon"  id="t_registros_multiples">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                    <br> 
                    <div class="row">
                        <div class="col-md-12">
                            <table class="tablon">
                                <thead>
                                    <tr class="renglon">
                                        <th colspan="5">Pagos de factura</th>
                                    </tr>
                                    <tr class="renglon">
                                        <th scope="col">Folio</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Abonos</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="div_t_pagos_multiples">
                                <table class="tablon"  id="t_pagos_multiples">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<!--NJES March/27/2020 se solicita que se justifique la cancelación de un cxc o una partida del cxc-->
    <div id="dialog_justifica_cancelar_a" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Justificación Cancelar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forma_justificacion_a" name="forma_justificacion_a">
                    <div class="row">
                        <label for="ta_jutificacion_a" class="col-md-3 col-form-label requerido">Justificación</label>
                        <div class="col-md-9">
                            <textarea type="text" id="ta_justificacion_a" name="ta_justificacion_a" class="form-control form-control-sm validate[required]"  autocomplete="off"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="b_cancelar_a">Guardar</button>
            </div>
            </div>
        </div>
    </div>

    <div id="dialog_justifica_cancelar_b" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Justificación Cancelar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forma_justificacion_b" name="forma_justificacion_b">
                    <div class="row">
                        <label for="ta_jutificacion_b" class="col-md-3 col-form-label requerido">Justificación</label>
                        <div class="col-md-9">
                            <textarea type="text" id="ta_justificacion_b" name="ta_justificacion_b" class="form-control form-control-sm validate[required]"  autocomplete="off"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="b_cancelar_b">Guardar</button>
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
  
    var modulo='CXC_ALARMAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var cargoInicial = 0;
    //var estatus ='P';
    //-->NJES Feb/11/2020
    var estatus ='A';
    var tipo = '';
    var idCXC = 0;
    var banderaCancela =0;
    var anteriorClase = '';
    var sucursalesPermiso=muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);
    var idOrdenServicio = 0;
    $(function(){
        $('#b_cancelar').prop('disabled',true);
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraSelectUnidades(matriz,'s_id_unidades_n',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales_n',idUnidadActual,modulo,idUsuario);
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        //-->NJES March/30/2020 se envia parametro uno para que no muestre las caja chica
        muestraCuentasBancosSaldosUnidad('s_cuenta_banco',0,1,idUnidadActual);
        muestraConceptosCxP('s_concepto',1);

        generaFecha('s_mes');
        $("#div_principal").css({left : "0%"}); 
        
        fechaHoyServidor('i_fecha_inicio_ec','primerDiaMes');
        fechaHoyServidor('i_fecha_fin_ec','ultimoDiaMes');
        

        /***BUSQUEDA DE REGISTRO INICIAL */
        $('#b_buscar_cxc').click(function(){
            $('#i_fecha_inicio').val(primerDiaMes);
            $('#i_fecha_fin').val(ultimoDiaMes);
            $('#i_filtro').val('');
            $('#i_folio_b').val('');
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            $('#dialog_buscar_registros').modal('show');
            buscaCXC(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            
        });

        $('#s_id_sucursales_n').change(function(){
            
            if($('#s_id_sucursales_n').val() >= 1)
            {
                buscaCXC(idUnidadActual,$('#s_id_sucursales_n').val());
                $('#s_id_sucursales_n').find('option[value="0"]').remove();
                $('#s_id_sucursales_n').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_id_sucursales_n').find('option[value="0"]').remove();
                $('#s_id_sucursales_n').append('<option value="0" selected>Mostrar Todas</option>');
                buscaCXC(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#i_fecha_inicio').on('change',function(){
            $('#i_fecha_fin').val('');
        });

        $('#i_fecha_fin').on('change',function(){
            //buscaCXC(idUnidadActual,$('#s_id_sucursales_n').val());
            if($('#s_id_sucursales_n').val() >= 1)
            {
                buscaCXC(idUnidadActual,$('#s_id_sucursales_n').val());
                $('#s_id_sucursales_n').find('option[value="0"]').remove();
                $('#s_id_sucursales_n').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_id_sucursales_n').find('option[value="0"]').remove();
                $('#s_id_sucursales_n').append('<option value="0" selected>Mostrar Todas</option>');
                buscaCXC(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#i_folio_b').on('change',function(){
           
            buscaCXC(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
        });

        function buscaCXC(idUnidadActual,idSucursal){
           
            sucursalesPermiso=idSucursal;
            $('#i_filtro').val('');
            $('.renglon_registros').remove();
            $('#t_registros_buscar tbody').html('');

            var info = {
                'idUnidadNegocio' : idUnidadActual,
                'idSucursal': idSucursal,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'folio' : $('#i_folio_b').val()
            };
            
            $.ajax({
                type: 'POST',
                url: 'php/cxc_buscar_inicial_alarmas.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data) {
         
                    if(data.length != 0){ 
                                     
                        for(var i=0;data.length>i;i++){
                            //-->NJES March/19/2020 mostrar folio de recibo plan, venta o orden servicio (se cambia folio_cxc por ID)
                            var html='<tr class="renglon_registros '+data[i].tipo+'" alt="'+data[i].tipo+'" alt2="'+data[i].id+'" alt3="'+data[i].id_unidad_negocio+'" alt4="'+data[i].id_cliente+'"  alt5="'+data[i].estatus+'" alt6="'+data[i].id_orden_servicio+'" alt7="'+data[i].razon_social+'"  alt8="'+data[i].nombre_corto+'" idCXC="'+data[i].folio_cxc+'" idFactura="'+data[i].id_factura+'" idNota="'+data[i].id_nota_credito+'" >\
                                        <td data-label="ID">'+data[i].folio_cxc+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Vencimiento">'+data[i].vencimiento+'</td>\
                                        <td data-label="Nombre Corto">'+data[i].nombre_corto+'</td>\
                                        <td data-label="Razón Social (receptor)">'+data[i].razon_social+'</td>\
                                        <td data-label="Operacion">'+data[i].cargo_por+'</td>\
                                        <td data-label="Cargo Inicial">'+formatearNumeroCSS(data[i].cargo_inicial,'')+'</td>\
                                        <td data-label="Total">'+formatearNumeroCSS(data[i].saldo,'')+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_buscar tbody').append(html);   
                        }
                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="11">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_buscar tbody').append(html);
                    }
                },
                error: function (xhr) {
                    console.log('php/cxc_buscar_inicial_alarmas.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar registros.');
                }
            });
        }
        //--- BUSQUEDA PRINCIPAL
        $('#t_registros_buscar').on('click', '.renglon_registros', function()
        {

            tipo = $(this).attr('alt');
            idCXC = $(this).attr('alt2');
            var idUnidadNegocio = $(this).attr('alt3');
            var idCliente = $(this).attr('alt4');
            var estatusR = $(this).attr('alt5');
            idOrdenServicio = $(this).attr('alt6');
            var razonSocial = $(this).attr('alt7');
            var nombreCorto = $(this).attr('alt8');
            $('#i_observaciones').val('');
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            //-->NJES March/30/2020 se envia parametro uno para que no muestre las caja chica
            muestraCuentasBancosSaldosUnidad('s_cuenta_banco',0, 1,idUnidadNegocio);
            muestraConceptosCxP('s_concepto',5);

            cargoInicial=0;
        
            //if(estatus!='C'){
            if(estatusR=='A'){
                $('#div_nuevo_cxc').find('input,select').prop('disabled',false);
                $('#b_guardar').prop('disabled',false);
                $('#b_buscar_clientes').prop('disabled',false);
                //$('#b_cancelar').prop('disabled',false);
                $('#b_detalle_registro').prop('disabled',true);
            }else{
                $('#div_nuevo_cxc').find('input,select').prop('disabled',true);
                $('#b_guardar').prop('disabled',true);
                $('#b_buscar_clientes').prop('disabled',true);
                //$('#b_cancelar').prop('disabled',true);
                $('#b_detalle_registro').prop('disabled',true);

            }
                
            muestraRegistro(tipo,idCXC);
            $('#dialog_buscar_registros').modal('hide');
            
        });

        function muestraRegistro(tipo,id){
            $('#b_buscar_clientes').prop('disabled',true);
            $('#i_importe').val(' ');
            $('#i_total_iva').val(' ');
            $('#i_total').val('');
            $('#forma_cxc').validationEngine('hide');
           
            $.ajax({
                type: 'POST',
                url: 'php/cxc_buscar_registro_id_alarmas.php',
                dataType:"json", 
                data : {'tipo':tipo,
                        'id':id
                },
                success: function(data) {
                   
                    if(parseInt(data.length) >0){                    
                        var dato = data[0];

                        $('#i_cliente').attr('alt',dato.id_cliente).attr('alt2',dato.facturar).val(dato.cliente);
                       
                        //-->NJES March/24/2020 mostrar el folio del cxc y no de la factura
                        $('#i_folio').val(dato.folio_cxc).attr('alt',dato.id_factura).attr('alt2',dato.id_nota_credito);
                        $('#i_anio').val((dato.anio));
                        $('#i_vencimiento').val((dato.vencimiento));
                       
                        if(parseInt(dato.porcentaje_iva) == 16)
                            $('#r_16').prop('checked',true);
                        else if(dato.porcentaje_iva == 8)
                            $('#r_8').prop('checked',true);

                        $('#s_id_sucursales').val(dato.id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                       

                        //var optionCuenta = new Option(dato.cuenta_banco, dato.id_cuenta_banco, true, true);
                        //$('#s_cuenta_banco').append(optionCuenta).trigger('change');
                        //-->NJES March/30/2020 se envia parametro uno para que no muestre las caja chica
                        muestraCuentasBancosSaldosUnidad('s_cuenta_banco',0, 1,dato.id_unidad_negocio);
                        $('#s_cuenta_banco').val(dato.id_cuenta_banco);
                        $('#s_cuenta_banco').select2({placeholder: $(this).data('elemento')});
                       
                        $('#s_razon_social').val(dato.id_razon_social);
                        $('#s_razon_social').select2({placeholder: $(this).data('elemento')});

                        $('#s_mes').val(dato.mes);
                        $('#s_mes').select2({placeholder: $(this).data('elemento')});

                        $('#b_guardar').prop('disabled',true);
                        $('#d_estatus').removeAttr('class');
                        $('#s_cuenta_banco').prop('disabled',true);
                        $('#s_concepto').prop('disabled',true);
                        $('#i_total').prop('disabled',true);
                        $('#i_referencia').prop('disabled',true);
                        $('#b_cancelar').prop('disabled',true);
                      
                        if(dato.estatus=='P'){
                            /*$('#d_estatus').addClass('alert alert-sm alert-warning').text('PENDIENTE');
                            $('#b_cancelar').prop('disabled',false);
                            if(tipo=='CXC')
                             $('#b_cancelar').prop('disabled',false);
                            else
                            $('#b_cancelar').prop('disabled',true);*/
                            $('#d_estatus').addClass('alert alert-sm alert-warning').text('PENDIENTE');
                            $('#b_cancelar').prop('disabled',true);
                            /*if(dato.cargo_por=='CXC'){
                                $('#b_cancelar').prop('disabled',false);
                            }else{
                                $('#b_cancelar').prop('disabled',true);
                            }*/
                            
                        }else if(dato.estatus=='C'){
                           
                            $('#b_cancelar').prop('disabled',true);
                            $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
                        }else if(dato.estatus=='A'){
                            /*if(tipo=='CXC')
                            $('#b_cancelar').prop('disabled',false);
                            else
                            $('#b_cancelar').prop('disabled',true);*/


                            $('#b_guardar').prop('disabled',false);
                            $('#d_estatus').addClass('alert alert-sm alert-info').text('ACTIVA');
                            $('#s_cuenta_banco').prop('disabled',false);
                            $('#s_concepto').prop('disabled',false);
                            $('#i_total').prop('disabled',false);
                            $('#i_referencia').prop('disabled',false);

                            if(dato.id_factura == 0)
                                $('#b_cancelar').prop('disabled',false);

                            /*if(dato.cargo_por=='PLAN'){
                                $('#b_cancelar').prop('disabled',false);
                            }*/
                        }else{
                            $('#b_cancelar').prop('disabled',true);
                            $('#d_estatus').addClass('alert alert-sm alert-success').text('TIMBRADA');
                        }
 
                    }else{
                        mandarMensaje('No se encontro Información del registro');
                    }
                },
                error: function (xhr) {
                    console.log('php/cxc_busca_registro_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar el registro.');
                }
            });
            muestraSaldoDisponible(id,tipo);
        }

        function labelEstatus(estatusL){
            var est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #0066cc;"> SIN TIMBRAR </label>';
                        if(estatusL == 'T')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;"> &nbsp; TIMBRADA &nbsp;</label>';
                        else if(estatusL == 'C')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ff0000;"> &nbsp; CANCELADA &nbsp; </label>';
                        else if(estatusL == 'P')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ffc107;"> &nbsp; PENDIENTE &nbsp; </label>';
                        else if(estatusL == 'S')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;"> &nbsp; SALDADA &nbsp; </label>';
                        else if(estatusL == 'A')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #0C5460;"> &nbsp; ACTIVA &nbsp; </label>';
                       
                       
            return est;
        }

     /*****FIN BUSQUEDA DE REGISTROS INICAL */   

     $('#b_buscar_clientes').on('click',function(){

        $('#forma').validationEngine('hide');
        $('#i_filtro_servicios').val('');
        $('.renglon_servicios').remove();

        $.ajax({

            type: 'POST',
            url: 'php/servicios_buscar.php',
            dataType:"json", 
            data:{'estatus':2},

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

                    var html='<tr class="renglon_servicios" alt="'+data[i].id+'"  alt2="' + data[i].razon_social+ '" alt3="' + data[i].nombre_corto+ '">\
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

    $('#t_servicios').on('click', '.renglon_servicios', function(){
        var idServicio = $(this).attr('alt');
        var razonSocial = $(this).attr('alt2');
        var nombreCorto = $(this).attr('alt3');
        
        $('#i_cliente').attr('alt',idServicio).val(nombreCorto);
        $('#dialog_buscar_servicios').modal('hide');
       
    });


    $('.fecha').datepicker({
        format : "yyyy-mm-dd",
        autoclose: true,
        language: "es",
        todayHighlight: true,
    });

    $('#i_fecha').val(hoy);
    $('#i_anio').val(anio);


    /*$('#b_nuevo').on('click',function(){

        $("#div_principal").animate({left : "-101%"}, 500, 'swing');
        $('#div_nuevo_cxc').animate({left : "0%"}, 600, 'swing');

        $('#t_registros tbody').empty();
        $('#form_razon_social').find('input,textarea').not('input:radio').val('');
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        muestraCuentasBancosSaldosUnidad('s_cuenta_banco', 0,idUnidadActual);
        muestraConceptosCxP('s_concepto',1);
        $('#i_folio').val('');
        $('#i_cliente').val('');
        $('#i_vencimiento').val('');
        $('#s_mes').val('');
        $('#i_anio').val('');
        $('#i_saldo').val(formatearNumero(0.00));
        muestraSucursalesPermiso('s_id_sucursales_n',$('#s_id_unidades_n').val(),modulo,idUsuario);
        $('#b_cancelar').prop('disabled',true);
        $('#d_estatus').removeAttr('class');
        cargoInicial=1;
        tipo='CXC';           
    });*/


    $('input[name=radio_iva]').on('change',function(){

        if($('#i_total').val() != '')
            var total = quitaComa($('#i_total').val());
        else
            var total = 0;

        var tasa_iva = $('input[name=radio_iva]:checked').val();
        var total_iva=0;
        
        if(parseInt(tasa_iva) > 0){
            total_iva = (parseFloat(total) * (parseInt(tasa_iva)))/100;
        }

        var importe = parseFloat(total) - parseFloat(total_iva);
        $('#i_importe').val(formatearNumero(importe));
        $('#i_total_iva').val(formatearNumero(total_iva));
        $('#i_total').val(formatearNumero(total));

    });

    $('#i_total').on('change',function(){

        var total = quitaComa($(this).val());
        var tasa_iva = $('input[name=radio_iva]:checked').val();

        if(parseInt(tasa_iva) > 0){
            total_iva = (parseFloat(total) * (parseInt(tasa_iva)))/100;
        }

        var importe =  parseFloat(total) - total_iva;

        $('#i_total_iva').val(formatearNumero(total_iva));
        $('#i_importe').val(formatearNumero(importe));
        $('#i_total').val(formatearNumero(total));

    });
        

    $('#b_guardar').click(function(){
        $('#b_guardar').prop('disabled',true);

        if($('#forma_cxc').validationEngine('validate'))
        {
            if(parseFloat(quitaComa($('#i_saldo').val())) > 0)
            {   
                if(parseFloat(quitaComa($('#i_saldo').val())) >= parseFloat(quitaComa($('#i_total').val())))
                {  
                    if($('#i_cliente').attr('alt2')==1){
                        $('#dialog_confirmar_abono').modal('show');
                    }else{
                        guardar();
                    }
                    
                }else{
                    mandarMensaje('Solo puedes abonar una cantidad igual o menos al saldo');
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
                var concepto = $('#s_concepto option:selected').attr('alt');
                var res = concepto.substr(0, 1);
                if(res == 'C'){
                    //--> Si es un cargo no comparo mi saldo disponible de la cuenta por que es un ingreso a mi
                    guardar();
                }else{
                    mandarMensaje('No es posible realizar un abono cuando el saldo es 0');
                    $('#b_guardar').prop('disabled',false);
                }
            }

        }else{
            $('#b_guardar').prop('disabled',false);
        }
    });

    $(document).on('click','#b_no_confirmar',function(){
        $('#b_guardar').prop('disabled',false);
        $('#dialog_confirmar_abono').modal('hide');
    
    });

    $(document).on('click','#b_confirmar',function(){
        $('#b_guardar').prop('disabled',false);
        $('#dialog_confirmar_abono').modal('hide');
        guardar();
    });

    function guardar(){

        var info = {

            'idCxC' : $('#i_folio').val(),
            'folio' : $('#i_folio').val(),
            'idOrdenServicio':idOrdenServicio,
            'idUnidadNegocio' : idUnidadActual,
            'idSucursal' : $('#s_id_sucursales').val(),
            'idRazonSocialReceptor' : 0,
            'idRazonSocialServicio' : $('#i_cliente').attr('alt'),
            'idBanco' : $('#s_cuenta_banco option:selected').attr('alt'),
            'idCuentaBanco' : $('#s_cuenta_banco').val(),

            'vencimiento' : $('#i_vencimiento').val(),
            'tasaIva' : $('input[name=radio_iva]:checked').val(),
            'mes' : $('#s_mes').val(),
            'anio' : $('#i_anio').val(),
            
            
            'fecha' : $('#i_fecha').val(),
            'idConcepto' : $('#s_concepto option:selected').val(),
            'cveConcepto' : $('#s_concepto option:selected').attr('alt'),
            'importe' : quitaComa($('#i_importe').val()),
            'totalIva' : quitaComa($('#i_total_iva').val()),
            'total' : quitaComa($('#i_total').val()),
            'referencia' : $('#i_referencia').val(),

            'cargoInicial': cargoInicial,
            'idUsuario' : idUsuario,
            'estatus' : estatus,
            //-->NJES May/28/2020 se agregan observaciones a los abonos de cxc
            'observaciones' : $('#i_observaciones').val()
        };

        //console.log(JSON.stringify(info));

        $.ajax({
            type: 'POST',
            url: 'php/cxc_guardar.php',
            data:  {'datos':info},
            success: function(data) {
                console.log(data);
                if(data > 0 )
                { 
                    if($('#i_folio').val()!='' && parseInt($('#i_folio').val())>0){
                        idCxC = $('#i_folio').val();
                    }else{
                        idCxC = data;
                        $('#i_folio').val(data);
                    }
                    
                    mandarMensaje('Se realizo el proceso correctamente');
                    $('#s_concepto_cxp').prop('disabled',false);
                    muestraConceptosCxP('s_concepto',1);
                    $('#i_fecha,#i_importe,#i_total_iva,#i_total,#i_referencia').val('');
                    muestraSaldoDisponible(idCxC,tipo);
                    $('#b_guardar').prop('disabled',false);
                    $('#i_observaciones').val('');
                
                }else{ 
                    mandarMensaje('Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            },
            error: function (xhr) 
            {
                console.log('php/cxp_guardar.php --> '+JSON.stringify(xhr));
                mandarMensaje('* Error al guardar.');
                $('#b_guardar').prop('disabled',false);
            }
        });
    }


        function muestraSaldoDisponible(idCxC,tipo){
            console.log(' idCxC: '+idCxC+' tipo: '+tipo);
            cargoInicial = 0;
            saldoActual = 0;
            
            $.ajax({
                type: 'POST',
                url: 'php/cxc_saldo_actual_buscar_alarmas.php',
                dataType:"json", 
                data:{'idCxC' : idCxC,
                      'tipo' : tipo
                },
                success: function(data)
                { console.log('Sado:'+JSON.stringify(data));
                   
                    var arreglo=data;
                    if(parseInt(arreglo.length)>0){
                      
                        for(var i=0;i<arreglo.length;i++)
                        {
                            var dato=arreglo[i];
                            estatus='A'; //-->NJES Feb/11/2020 el estatus es A para un abono, solo si se salda se camia a S
                           
                            if(dato.multi == 0)
                            {
                                $('#i_saldo').val(formatearNumero(dato.saldo));
                            }else{
                                $('#i_saldo').val('');
                            }

                            if(verFacturasCxCs(idCxC) > 1)
                            {
                                $('#b_ver_saldo_multiple').prop('disabled',false).attr({'idCxC':idCxC,'idFactura':dato.id_factura});
                            }else{
                                $('#b_ver_saldo_multiple').prop('disabled',true).attr({'idCxC':0,'idFactura':0});
                            }

                            saldoActual = parseFloat(dato.saldo);   

                            if(parseFloat(dato.saldo) > 0)
                            {
                                $('#i_total').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01],max['+parseFloat(dato.saldo)+']]');
                            
                            }else if(parseFloat(dato.saldo) == 0){
                                estatus='S';
                                $('#i_total').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]]');
                            }else{
                                $('#i_total').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]]');
                            }

                            //-->NJES Feb/11/2020 solo si el saldo actual es igual al cargo inicial se puede cancelar el cxc, 
                            //porque no tiene abonos activos
                            if(parseFloat(dato.saldo) == parseFloat(dato.cargo_inicial))
                                $('#b_cancelar').prop('disabled',false);
                            else
                                $('#b_cancelar').prop('disabled',true);
                           
                        }
                        // verificando
                        muestraRegistros(idCxC,tipo);
                    }
                },
                error: function (xhr) {
                    console.log("cxp_saldo_actual_buscar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo de la factura');
                }
            });
        }

        function muestraRegistros(idCxC,tipo)
        {

            console.log('****' + idCxC + ' ** ' + tipo + '****');

            $('#t_registros tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/cxc_registros_idCxC_buscar_alarmas.php',
                dataType:"json", 
                data:{'idCxC':idCxC,
                      'tipo':tipo
                },
                success: function(data) {
                    
                    if(data.length != 0){

                        for(var i=0;data.length>i;i++){
                            
                            if(data[i].id == idCxC)
                            {
                                if(data[i].estatus == 'C')
                                {
                                   
                                    $('#b_guardar').prop('disabled',true);
                                }
                            }

                            if(data[i].estatus == 'C')
                            {
                                var boton = '';

                                //--> compara si el dato es un valor positivo 
                                if(Math.sign(data[i].abonos)  == 1 || Math.sign(data[i].cargos)  == 1)
                                {
                                    var cancelado = 'style="background-color:#ffe6e6;"';
                                }else{
                                    var cancelado = '';
                                }
                            }else{
                                if(i > 0)
                                {
                                    if(data[i].tipo_abono == 'nota_credito' || data[i].tipo_abono == 'pago')
                                        var boton = '';
                                    else{
                                    var boton = '<button type="button" class="btn btn-danger btn-sm b_cancelar_p" alt="'+data[i].id+'">\
                                                    <i class="fa fa-ban" aria-hidden="true"></i>\
                                                </button>';
                                    }
                                }else{
                                    var boton = '';
                                }
                                var cancelado = '';
                            }

                            var b_imprimir="";
                            if(data[i].cargo_inicial==1){

                                var imprimirFormato='';
                                var nombreFormato='';
                                var idImpresion=0;
                                
                                if(parseInt(data[i].id_orden_servicio) > 0){

                                    idImpresion = data[i].id_orden_servicio;
                                    imprimirFormato='formato_orden_servicio';
                                    nombreFormato = 'orden_servicio';

                                }else if(parseInt(data[i].id_venta) > 0){

                                    idImpresion = data[i].id_venta;
                                    imprimirFormato='formato_venta';
                                    nombreFormato = 'Venta';

                                }else if(parseInt(data[i].id_plan) > 0){

                                    idImpresion = data[i].id_plan;
                                    imprimirFormato='formato_recibo_plan';
                                    nombreFormato = 'Recibo';

                                }else{
                                    idImpresion = data[i].id;
                                    imprimirFormato='formato_cxc_alarmas_cargo';
                                    nombreFormato = 'recibo_cargo_cxc';
                                }
                                b_imprimir = '<button type="button" class="btn btn-dark btn-sm b_imprimir_formato" alt="'+imprimirFormato+'" alt2="'+idImpresion+'" alt3="'+nombreFormato+'" alt4="'+data[i].id+'">\
                                                    <i class="fa fa-print" aria-hidden="true"></i>\
                                                </button>';

                            }else{
                                b_imprimir = '<button type="button" class="btn btn-info btn-sm b_imprimir_abono" alt="'+data[i].id+'">\
                                                    <i class="fa fa-print" aria-hidden="true"></i>\
                                                </button>';
                            }

                            ///llena la tabla con renglones de registros
                            if(verFacturasCxCs(idCxC) > 1)
                            {
                                if(parseInt(data[i].id) == parseInt(idCxC)){
                                    var html='<tr class="renglon estatus_'+data[i].estatus+'" '+cancelado+'  alt="'+data[i].id+'">\
                                                <td data-label="Fecha">'+data[i].fecha+'</td>\
                                                <td data-label="Concepto">'+data[i].concepto+'</td>\
                                                <td data-label="Concepto">'+data[i].iva+'</td>\
                                                <td data-label="Cargos" class="cargos">'+formatearNumero(data[i].cargos)+'</td>\
                                                <td data-label="Abonos" class="cargos">'+formatearNumero(data[i].abonos)+'</td>\
                                                <td data-label="Referencia">'+data[i].referencia+'</td>\
                                                <td data-label="Observaciones">'+data[i].observaciones+'</td>\
                                                <td>'+boton+'</td>\
                                                <td>'+b_imprimir+'</td>\
                                            </tr>';
                                    
                                    $('#t_registros tbody').append(html); 
                                }
                            }else{
                                var html='<tr class="renglon estatus_'+data[i].estatus+'" '+cancelado+'  alt="'+data[i].id+'">\
                                            <td data-label="Fecha">'+data[i].fecha+'</td>\
                                            <td data-label="Concepto">'+data[i].concepto+'</td>\
                                            <td data-label="Concepto">'+data[i].iva+'</td>\
                                            <td data-label="Cargos" class="cargos">'+formatearNumero(data[i].cargos)+'</td>\
                                            <td data-label="Abonos" class="cargos">'+formatearNumero(data[i].abonos)+'</td>\
                                            <td data-label="Referencia">'+data[i].referencia+'</td>\
                                            <td data-label="Observaciones">'+data[i].observaciones+'</td>\
                                            <td>'+boton+'</td>\
                                            <td>'+b_imprimir+'</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_registros tbody').append(html); 
                            }
                            
                        }

                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxc_registros_idCxC_buscar_alarmas.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos de factura');
                }
            });
           
        }

        
        ///----CANCELAR--------------------------------------
        //-->NJES March/27/2020 se solicita que se justifique la cancelación de un cxc o una partida del cxc
        $(document).on('click','.b_cancelar_p',function(){

            var id = $(this).attr('alt');
            $('#b_cancelar_b').attr('id_partida',id);

            $('#dialog_justifica_cancelar_b').modal('show');        

        });

        $(document).on('click','#b_cancelar_b',function(){
            $('#b_cancelar_b').prop('disabled',true);
            var id = $('#b_cancelar_b').attr('id_partida');
            
            if($('#forma_justificacion_b').validationEngine('validate'))
            {
                $.ajax({
                    type: 'POST',
                    url: 'php/cxc_cancelar.php',
                    dataType:"json", 
                    data:{'idCXC':id,
                        'tipo':'registro',
                        'justificacion':$('#ta_justificacion_b').val()
                    },
                    success: function(data) {
                        if(data.length != 0){
                            mandarMensaje('El registro se canceló correctamente');
                            muestraSaldoDisponible($('#i_folio').val(),tipo);
                            $('#b_cancelar_b').prop('disabled',false);
                            $('#ta_justificacion_b').val('');
                            $('#dialog_justifica_cancelar_b').modal('hide');
                        }else{
                            mandarMensaje('Ocurrio un error durante el proceso');
                            $('#b_cancelar_b').prop('disabled',false);
                        }
                    },
                    error: function (xhr) 
                    {
                        console.log('php/cxc_cancelar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* No se pudó cancelar el registro');
                        $('#b_cancelar_b').prop('disabled',false);
                    }
                });      
            }else
                $('#b_cancelar_b').prop('disabled',false);
            
        });

        $(document).on('click','#b_cancelar',function(){
            $('#dialog_justifica_cancelar_a').modal('show');
        });

        
        $(document).on('click','#b_cancelar_a',function(){
            $('#b_cancelar_a').prop('disabled',true);

            if($('#forma_justificacion_a').validationEngine('validate'))
            {
                $.ajax({
                    type: 'POST',
                    url: 'php/cxc_cancelar.php',
                    dataType:"json", 
                    data:{'idCXC':$('#i_folio').val(),
                        'tipo':'folio',
                        'justificacion':$('#ta_justificacion_a').val()
                    },
                    success: function(data) {
                        if(data.length != 0){
                            mandarMensaje('El movimiento de cxc se canceló correctamente');
                            muestraSaldoDisponible($('#i_folio').val());
                            $('#b_cancelar_a').prop('disabled',false);
                            $('#b_cancelar').prop('disabled',true);
                            $('#ta_justificacion_a').val('');
                            $('#dialog_justifica_cancelar_a').modal('hide');
                        }else{
                            mandarMensaje('Ocurrio un error durante el proceso');
                            $('#b_cancelar_a').prop('disabled',false);
                        }
                    },
                    error: function (xhr) 
                    {
                        console.log('php/cxc_cancelar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* No se pudó cancelar el cxc');
                        $('#b_cancelar_a').prop('disabled',false);
                    }
                });        
            }else
                $('#b_cancelar_a').prop('disabled',false);
            
        });


        $('#b_excel').click(function(){

          
            var datos = {
                'idCliente':$('#i_cliente').attr('alt'),
                'fechaInicio':$('#i_fecha_inicio_ec').val(),
                'fechaFin':$('#i_fecha_fin_ec').val()
            };
            
            $("#i_nombre_excel").val('Estado de Cuenta Cliente');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('CXC_ALARMAS');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });


        $('#b_detalle_registro').click(function(){
            if($('#i_folio').val() != '')
            {
                if(tipo=='FAC'){
                    var idFactura = $('#i_folio').attr('alt');
                    $('#h_titulo').text('Factura: '+$('#i_folio').val());
                    
                    muestraRegistroFactura(idFactura);
                }else{
                    $('#h_titulo').text('Nota: '+$('#i_folio').val());
                    var idNota = $('#i_folio').attr('alt2');
                    muestraRegistroFactura(idNota);
                }
              
            }else{
                mandarMensaje('Primero debes selecionar un folio');
            }
        });


        function muestraRegistroFactura(idFactura){
           
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_id.php',
                dataType:"json", 
                data : {'idFactura':idFactura},
                success: function(data) {
                    if(data.length >0){                    
                        var dato = data[0];

                        var detalles="<table>\
                        <tr><td class='td_titulo'>Cliente: </td><td class='td_valor'>"+dato.cliente+"</td></tr>\
                        <tr><td class='td_titulo'>Empresa Fiscal: </td><td class='td_valor'>"+dato.empresa_fiscal+"</td></tr>\
                        <tr><td class='td_titulo'>RFC : </td><td class='td_valor'>"+dato.rfc_razon_social+"</td></tr>\
                        <tr><td class='td_titulo'>Email: </td><td class='td_valor'>"+dato.email+"</td></tr>\
                        <tr><td class='td_titulo'>Fecha: </td><td class='td_valor'>"+dato.fecha+"</td><td class='td_titulo'>Dias Credito: </td><td class='td_valor'>"+dato.dias_credito+"</td></tr>\
                        <tr><td class='td_titulo'>Periodo Fecha Inicio: </td><td class='td_valor'>"+dato.fecha_inicio+"</td><td class='td_titulo'>Periodo Fecha Fin : </td><td class='td_valor'>"+dato.fecha_fin+"</td></tr>\
                        <tr><td class='td_titulo'>Año: </td><td class='td_valor'>"+dato.anio+"</td><td class='td_titulo'>4 Digitos: </td><td class='td_valor'>"+dato.digitos_cuenta+"</td></tr>\
                        <tr><td class='td_titulo'>Metodo Pago: </td><td class='td_valor'>"+dato.metodo_pago+"</td></tr>\
                        <tr><td class='td_titulo'>Observaciones: </td><td class='td_valor' colspan='3'>"+dato.observaciones+"</td></tr>\
                        <tr><td class='td_titulo' >Porcentaje IVA: </td><td class='td_valor' align='right'><strong>"+dato.porcentaje_iva+" % </strong></td></tr>\
                        <tr><td class='td_titulo' >Subtotal : </td><td class='td_valor' align='right'><strong>"+formatearNumero(dato.subtotal)+"</strong></td></tr>\
                        <tr><td class='td_titulo' >IVA: </td><td class='td_valor' align='right'><strong>"+formatearNumero(dato.iva)+"</strong></td></tr>\
                        <tr><td class='td_titulo' >Total: </td><td class='td_valor' align='right'><strong>"+formatearNumero(dato.total)+"</strong></td></tr>\
                        </table>";
                        
                        $('#div_datos').html(detalles);
                        muestraRegistroDetalle(idFactura);
                        
                        $('#dialog_factura_nota').modal('show');
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
                        var importe = parseFloat(data[i].importe);
                        var cantidad = parseFloat(data[i].cantidad);

                        registro+= '<tr class="renglon_partida" claveProducto="'+data[i].clave_producto_sat+'" claveUnidad="'+data[i].clave_unidad_sat+'" nombreUnidad="'+data[i].unidad_sat+'" nombreProducto="'+data[i].producto_sat+'"  cantidad="'+data[i].cantidad+'" precio="'+data[i].precio_unitario+'" importe="'+data[i].importe+'" descripcion="'+data[i].descripcion+'">';
                            registro+= '<td>'+data[i].clave_producto_sat+' - '+data[i].producto_sat+'</td>';
                            registro+= '<td>'+data[i].clave_unidad_sat+' - '+data[i].unidad_sat+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(data[i].cantidad + '')+'</td>';
                            registro+= '<td>'+data[i].descripcion+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(data[i].precio_unitario + '')+'</td>';
                            registro+= '<td style="text-align:right;">'+formatearNumeroCSS(data[i].importe + '')+'</td>';
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


    //---- IMPRIME EL FORMATO CORRESPONDIENTE--------------------------------
        
    $(document).on('click','.b_imprimir_formato',function(){
        var path = $(this).attr('alt');
        var id = $(this).attr('alt2');
        var nombre = $(this).attr('alt3');
        var idCxc = $(this).attr('alt4');
      
        generaFormato(path,id,nombre,idCxc);
    });
    //---- IMPRIMIR cargo inicial --------------------------------------------  

   /* $(document).on('click','.b_imprimir_cargo',function(){
        var idCXC = $(this).attr('alt');
        generaFormatoCargo(idCXC);
    });*/

    function generaFormato(path,idRegistro,nombre,idCxc){
        var tipo = 1;

        var datos = {
            'path':'formato_cxc_alarmas_cargo',//path,
            'idRegistro':idCxc,
            'nombreArchivo':nombre,
            'tipo':tipo
        };

        let objJsonStr = JSON.stringify(datos);
        let datosJ = datosUrl(objJsonStr);

        window.open("php/convierte_pdf.php?D="+datosJ,'_new');
    }

    //---- IMPRIMIR ABONOS--------------------------------------------  

    $(document).on('click','.b_imprimir_abono',function(){
          var idRegistro = $(this).attr('alt');
          generaFormatoAbono(idRegistro);
      });

    function generaFormatoAbono(idRegistro){
        var tipo = 1;

        var datos = {
            'path':'formato_cxc_alarmas_abono',
            'idRegistro':idRegistro,
            'nombreArchivo':'recibo_abono_cxc',
            'tipo':tipo
        };
       
        let objJsonStr = JSON.stringify(datos);
        let datosJ = datosUrl(objJsonStr);

        window.open("php/convierte_pdf.php?D="+datosJ,'_new');
    }

    $('#b_estado_cuenta').click(function(){
        var idCliente=$('#i_cliente').attr('alt');
        if(idCliente>0){
            $('#dialog_estado_cuenta').modal('show');
            $('#i_cliente_e').val($('#i_cliente').val());
            buscaEstadoCuenta(idCliente,'orden_servicio');
        }else{
            mandarMensaje('Debes seleccionar un cliente primero');
        }
    });

    $('#i_fecha_inicio_ec,#i_fecha_fin_ec').change(function(){
        var idCliente=$('#i_cliente').attr('alt');
        if(idCliente>0){
            $('#dialog_estado_cuenta').modal('show');
            $('#i_cliente_e').val($('#i_cliente').val());
            buscaEstadoCuenta(idCliente,'orden_servicio');
        }else{
            mandarMensaje('Debes seleccionar un cliente primero');
        }
    });

    function buscaEstadoCuenta(idCliente,tipo){
        $('#t_estado_cuenta tbody').empty();
        
        $.ajax({
            type: 'POST',
            url: 'php/cxc_buscar_estado_cuenta.php',
            dataType:"json", 
            data:{'idCliente':idCliente,
                'tipo':tipo,
                'fechaInicio':$('#i_fecha_inicio_ec').val(),
                'fechaFin':$('#i_fecha_fin_ec').val()
            },
            success: function(data) {
        
                if(data.length != 0){

                    var sumCargos=0;
                    var sumAbonos=0;
                    var totalSaldo=0;

                    for(var i=0;data.length>i;i++){

                        if(data[i].tipo=='A' && data[i].estatus!='C')
                        {
                            sumCargos=sumCargos+0;
                            sumAbonos=sumAbonos+parseFloat(data[i].abonos);

                        }
                        else if(data[i].tipo=='C' && data[i].estatus!='C')
                        {

                            sumCargos=sumCargos+parseFloat(data[i].cargos);
                            sumAbonos=sumAbonos+0;
                        }

                        if(data[i].abonos > 0 && data[i].estatus!='C')
                            sumAbonos=sumAbonos+parseFloat(data[i].abonos);
                        
                        ///llena la tabla con renglones de registros
                        var html='<tr class="renglon_estado_cuenta" alt="'+data[i].id+'">\
                                    <td data-label="Fecha">'+data[i].fecha+'</td>\
                                    <td data-label="Referencia">'+data[i].referencia+'</td>\
                                    <td data-label="id Orden Servicio">'+data[i].id_orden_servicio+'</td>\
                                    <td data-label="Folio">'+data[i].folio+'</td>\
                                    <td data-label="Folio Factura">'+data[i].folio_factura+'</td>\
                                    <td data-label="Fecha Vencimiento">'+data[i].fecha_vencimiento+'</td>\
                                    <td data-label="Concepto">'+data[i].concepto+'</td>\
                                    <td data-label="Cargos" class="cargos">'+formatearNumero(data[i].cargos)+'</td>\
                                    <td data-label="Abonos" class="cargos">'+formatearNumero(data[i].abonos)+'</td>\
                                </tr>';
                        ///agrega la tabla creada al div 
                        $('#t_estado_cuenta tbody').append(html); 

                        $('#total_cargos').html(formatearNumero(sumCargos));
                        $('#total_abonos').html(formatearNumero(sumAbonos));

                    }
                    $('#total_saldo').html(formatearNumero(parseFloat(sumCargos)-parseFloat(sumAbonos)));

                }else{
                    var html='<tr class="renglon_estado_cuenta">\
                                    <td colspan="9">No se encontró información</td>\
                                </tr>';

                    $('#t_estado_cuenta tbody').append(html);
                    $('#total_cargos').html('');
                    $('#total_abonos').html('');
                    $('#total_saldo').html('');
                }

            },
            error: function (xhr) 
            {
                console.log('php/cxc_registros_idCxC_buscar_alarmas.php --> '+JSON.stringify(xhr));
                mandarMensaje('* No se encontró información al buscar datos de factura');
            }
        });

    }

    function verFacturasCxCs(id){
        var verifica = 1;

        $.ajax({
            type: 'POST',
            url: 'php/cxc_num_misma_factura.php',
            data:  {'idCxC':id},
            async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
            success: function(data) 
            {
                verifica = data;
            },
            error: function (xhr) {
                console.log('error --> php/cxc_num_misma_factura.php --> '+JSON.stringify(xhr));
                mandarMensaje('* No se encontro información al buscar los cxc de vinculados a la factura.');
            }
        });
        console.log(' idCxC: '+id+' data: '+verifica);
        return verifica;
    }

    $('#b_ver_saldo_multiple').click(function(){
        var idFactura = $('#b_ver_saldo_multiple').attr('idFactura');
        $('#t_registros_multiples tbody').empty();
        $('#t_pagos_multiples tbody').empty();
        $('#dialog_ver_saldo_multiple').modal('show');

        $.ajax({
            type: 'POST',
            url: 'php/facturacion_buscar_saldo_idFactura_multiple_cxc.php',
            dataType:"json", 
            data:  {'idFactura':idFactura},
            success: function(data) {
                if(data.length > 0)
                {
                    $('#i_saldo_factura').val(0).val(formatearNumero(data[0].saldo));
                    $('#i_total_factura').val(0).val(formatearNumero(data[0].cargo_inicial));
                    $('#i_folio_factura').val('').val(data[0].folio);
                }else{
                    $('#i_saldo_factura').val(0);
                    $('#i_total_factura').val(0);
                    $('#i_folio_factura').val('');
                }

                muestraRegistrosMultipleFacturaCxC(idFactura);
                muestraRegistrosMultipleFacturaAbonos(idFactura);
            },
            error: function (xhr) 
            {
                console.log('php/facturacion_buscar_saldo_idFactura.php --> '+JSON.stringify(xhr));
                mandarMensaje('* No se encontró información al buscar el saldo de la factura.');
            }
        });
        
    });

        function muestraRegistrosMultipleFacturaCxC(idFactura){
            $.ajax({
                type: 'POST',
                url: 'php/cxc_buscar_registros_misma_factura.php',
                dataType:"json", 
                data:  {'idFactura':idFactura},
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_registros_cxc_factura">\
                                        <td data-label="ID">'+data[i].id+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Nombre Corto">'+data[i].nombre_corto+'</td>\
                                        <td data-label="Razón Social">'+data[i].razon_social+'</td>\
                                        <td data-label="Operación">'+data[i].cargo_por+'</td>\
                                        <td data-label="Total">'+formatearNumero(data[i].cargo_inicial)+'</td>\
                                    </tr>';

                            $('#t_registros_multiples tbody').append(html); 
                        }
                    }else{
                        var html='<tr class="renglon_registros_cxc_factura">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_multiples tbody').append(html); 
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxc_buscar_registros_misma_factura.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar los cxc de la factura.');
                }
            });
        }

        function muestraRegistrosMultipleFacturaAbonos(idFactura){
            $.ajax({
                type: 'POST',
                url: 'php/cxc_buscar_abonos_misma_factura.php',
                dataType:"json", 
                data:  {'idFactura':idFactura},
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_registros_pagos_factura">\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Tipo">'+data[i].tipo+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Concepto">'+data[i].concepto+'</td>\
                                        <td data-label="Abonos">'+formatearNumero(data[i].importe_pagado)+'</td>\
                                    </tr>';

                            $('#t_pagos_multiples tbody').append(html); 
                        }
                    }else{
                        var html='<tr class="renglon_registros_pagos_factura">\
                                        <td colspan="5">No se encontró información</td>\
                                    </tr>';

                        $('#t_pagos_multiples tbody').append(html); 
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxc_buscar_abonos_misma_factura.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar los cxc de la factura.');
                }
            });
        }
        
    });

</script>

</html>