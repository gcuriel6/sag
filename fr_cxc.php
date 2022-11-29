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
    #div_principal,
    #div_nuevo_cxc{
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
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            
            <div id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">CXC</div>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <input type="checkbox" id="ch_clientes_inactivos" name="ch_clientes_inactivos" value=""> Ver clientes inactivos
                    </div>
                    <div class="col-sm-12 col-md-2">
                       <!-- <button type="button" class="btn btn-info btn-sm form-control"  id="b_pdf" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>-->
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="form-group row">
                            <label for="s_id_unidades" class="col-sm-12 col-md-4 col-form-label">Unidad de Negocio</label>
                            <div class="col-sm-12 col-md-8">
                                <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="s_id_sucursales" class="col-sm-12 col-md-4 col-form-label">Sucursal</label>
                            <div class="col-sm-12 col-md-8">
                                <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-7">
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
                            <div class="col-sm-12 col-md-5">
                                <button type="button" class="btn btn-info btn-sm form-control" id="b_nuevo" ><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <input type="text" name="i_filtro" id="i_filtro" alt="renglon_registros" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_registros" ><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                            </div>
                      
                        </div>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Unidad de Negocio</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Fecha Vencimiento</th>
                                    <th scope="col">Id Cliente</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Id Razón Social</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">RFC Receptor</th>
                                    <th scope="col">Deptos</th>
                                    <th scope="col">Folio CXC</th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Nota Credito</th>
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

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    <div class="container-fluid" id="div_nuevo_cxc"> <!--div_ forma razon social-->
      <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
              <br>
              <div class="row">
                  <div class="col-sm-12 col-md-3">
                      <div class="titulo_ban">Nuevo CXC</div>
                  </div>
                  <div class="col-sm-12 col-md-7 div_c"></div>
                  <div class="col-sm-12 col-md-4 div_pago"></div>
                  <div class="col-sm-12 col-md-2 div_pago">
                    <button type="button" class="btn btn-info btn-sm form-control" id="b_ver_datos_factura"><i class="fa fa-eye" aria-hidden="true"></i> Ver Datos Factura</button>
                  </div>
                  <div class="col-sm-12 col-md-2">
                      <button type="button" class="btn btn-info btn-sm form-control" id="b_regresar"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> regresar</button>
                  </div>
                  
              </div>

              <form id="forma_cxc" name="forma_cxc">
             
                    <div class="row"><!-- row--->
                     
                      <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="s_id_unidades_n" class="col-form-label requerido">Unidad de Negocio </label>
                                <select id="s_id_unidades_n" name="s_id_unidades_n" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                      <div class="row">
                                <div class="col-md-12">
                                <label for="s_id_sucursales_n" class="col-form-label requerido">Sucursal </label>
                                    <select id="s_id_sucursales_n" name="s_id_sucursales_n" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                      </div>
                      <div class="col-md-3">
                            <label for="i_folio" class="col-2 col-md-2 col-form-label requerido">Folio </label>
                            <div class="row">
                                
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_folio" name="i_folio" class="form-control" readonly autocomplete="off">
                                    <!--<div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_cxc" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>-->
                                    <div class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="b_detalle_registro" style="margin:0px;">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                      </div>
                      
                      <div class="col-sm-12 col-md-2"><br>
                        <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                    </div>
    
                    </div><!-- /row--->  

                    <div class="row"><!-- row--->
                     
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
                      <div class="col-md-4">
                        <label for="s_razon_social" class="col-form-label requerido">Razón Social (receptor)</label>
                        <select id="s_razon_social" name="s_razon_social" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                      </div>
                      <div class="col-md-4">
                        <label for="s_cuenta_banco" class="col-form-label requerido">Banco</label>
                        <select id="s_cuenta_banco" name="s_cuenta_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>  
                      </div>
                      
                    </div><!-- /row---> 
                    <div class="row"><!-- row--->
                     
                      <div class="col-md-5">
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
                      <div class="col-md-2">
                          <label for="i_vencimiento" class="col-form-label requerido">Vencimiento</label>
                          <input type="text" id="i_vencimiento" name="i_vencimiento" class="form-control form-control-sm validate[required] fecha" readonly  autocomplete="off">
                      </div>
                      <div class="col-md-5">
                        <div class="row">
                            <label for="" class="col-md-12 col-form-label requerido">Tasa IVA</label>
                            <div class="col-sm-4 col-md-3">
                                16% <input type="radio" name="radio_iva" id="r_16" value="16" checked> 
                            </div>
                            <div class="col-sm-4 col-md-3">
                                8% <input type="radio" name="radio_iva" id="r_8" value="8">
                            </div>
                            <div class="col-sm-4 col-md-3">
                                0% <input type="radio" name="radio_iva" id="r_0" value="0">  
                            </div>
                        </div>
                      </div>
                    </div> <!-- /row---> 
                    <div class="row div_pago">
                        <div class="col-md-4">
                            <label for="s_empresa_fiscal" class="col-md-12 col-form-label requerido">Empresa Fiscal</label>
                            <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="s_concepto_pago" class="col-form-label requerido">Concepto</label>
                            <select id="s_concepto_pago" name="s_concepto_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="s_forma_pago" class="col-form-label requerido">Forma de Pago</label>
                            <select id="s_forma_pago" name="s_forma_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>
                    <div class="row div_pago">
                        <div class="col-md-4">
                            <label for="i_banco_cliente" class="col-form-label">Banco del Cliente</label>
                            <input type="text" id="i_banco_cliente" name="i_banco_cliente" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="i_cuenta_cliente" class="col-form-label">Número de cuenta del cliente</label>
                            <input type="text" id="i_cuenta_cliente" name="i_cuenta_cliente" class="form-control form-control-sm"  autocomplete="off">
                        </div>
                    </div>
                       <br> 
                      <div class="row" style="border:1px solid #A3CED7;background:rgba(163,206,215,0.3);padding-bottom:10px;"><!-- row--->
                     
                      <div class="col-md-2">
                          <label for="i_fecha" class="col-form-label requerido">Fecha</label>
                          <input type="text" id="i_fecha" name="i_fecha" class="form-control form-control-sm validate[required] fecha"  autocomplete="off" readonly>
                      </div>
                     
                      <div class="col-md-2 div_s_concepto">
                        <label for="s_concepto" class="col-form-label requerido">Concepto</label>
                        <select id="s_concepto" name="s_concepto" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>  
                      </div>
                     
                      <div class="col-md-2">
                          <label for="i_importe" class="col-form-label requerido">Importe</label>
                          <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off">
                      </div>
                      
                      <div class="col-md-2">
                          <label for="i_total_iva" class="col-form-label requerido">Iva</label>
                          <input type="text" id="i_total_iva" name="i_total_iva" class="form-control form-control-sm validate[required] numeroMoneda" readonly  autocomplete="off">
                      </div>
                      <div class="col-md-2">
                          <label for="i_total" class="col-form-label requerido">Total</label>
                          <input type="text" id="i_total" name="i_total" class="form-control form-control-sm validate[required] numeroMoneda" readonly autocomplete="off">
                      </div>
                      
                      <div class="col-md-2 div_s_concepto">
                          <label for="i_referencia" class="col-form-label requerido">Referencia</label>
                          <input type="text" id="i_referencia" name="i_referencia" class="form-control form-control-sm validate[required]"  autocomplete="off">
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
                            <th scope="col">Folio</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">IVA</th>
                            <th scope="col">Cargos</th>
                            <th scope="col">Abonos</th>
                            <th scope="col">Referencia</th>
                            <th scope="col">x</th>
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
                    <div class="col-md-7"></div>
                      
                      <div class="col-md-1">
                          <label for="i_saldo" class="col-form-label">SALDO</label>
                      </div>
                      <div class="col-md-2">
                          <input type="text" id="i_saldo" name="i_saldo" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off" readonly>
                      </div>
                </div>      
                
            </div> <!--div_contenedor-->
      </div><!-- fin foma div_nuevo_cxc-->
    </div>

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

<div id="dialog_factura_nota" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id='h_titulo'></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div id="div_datos"></div>
                <br>  
                <div class="row">
                  
                    <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Clave SAT del producto</th>
                                    <th scope="col">Unidad SAT</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Precio Unitario</th>
                                    <th scope="col">Importe</th>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_datos_factura" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos Factura: <span id="dato_factura"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_factura"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
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

<script>
  
    var modulo='CXC';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var matriz = <?php echo $_SESSION['sucursales']?>;

    var cargoInicial = 0;
    var estatus ='A';
    var tipo = '';
    var idCXC = 0;
    var banderaCancela =0;
    var anteriorClase = '';
    var sucursalesPermiso=sucursalesPermiso=muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario);
   
    $(function(){
        $("#div_principal").css({left : "0%"});
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraSelectUnidades(matriz,'s_id_unidades_n',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales_n',idUnidadActual,modulo,idUsuario);

        //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxc solo se puede pagar de bancos
        //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
         //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        muestraCuentasBancosSaldos('s_cuenta_banco', 0,1,idUnidadActual);
        muestraConceptosCxP('s_concepto',1);

        $('.div_pago').hide();
        $('.div_c').show();

        generaFecha('s_mes');
         
        
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });
        
        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio').change(function(){
            if($('#s_id_sucursales').val() >= 1)
            {
                buscaCXC($('#s_id_unidades').val(),$('#s_id_sucursales').val());
                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0" selected>Mostrar Todas</option>');
                buscaCXC($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_id_sucursales').val() >= 1)
            {
                buscaCXC($('#s_id_unidades').val(),$('#s_id_sucursales').val());
                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0" selected>Mostrar Todas</option>');
                buscaCXC($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
            }
        });

        $('#s_id_unidades_n').change(function(){
            muestraSucursalesPermiso('s_id_sucursales_n',$('#s_id_unidades_n').val(),modulo,idUsuario);
            $('.img-flag').css({'width':'50px','height':'20px'});
            
            $('#t_registros tbody').empty();
            $('#b_cancelar').prop('disabled',true);
            $('#i_folio').val('');
            $('#i_saldo').val(0);
            anteriorClase = $('#i_importe').attr('class');
            $('#i_importe').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]] numeroMoneda');
           
            cargoInicial=1;
            tipo='CXC'; 
             //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancosSaldos('s_cuenta_banco', 0,1,$('#s_id_unidades_n').val()); 
        });

        $('#s_id_sucursales_n').change(function(){
            $('#t_registros tbody').empty();
            $('#b_cancelar').prop('disabled',true);
            $('#i_folio').val('');
            $('#i_saldo').val(0);
            anteriorClase = $('#i_importe').attr('class');
            $('#i_importe').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]] numeroMoneda');
           
            cargoInicial=1;
            tipo='CXC';           
        });

        buscaCXC(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));

        /***BUSQUEDA DE REGISTRO INICIAL */
        $('#b_buscar_registros').click(function(){

            buscaCXC($('#s_id_unidades').val(),$('#s_id_sucursales').val());
        });

        $('#s_id_unidades').change(function(){
            muestraSucursalesPermiso('s_id_sucursales',$('#s_id_unidades').val(),modulo,idUsuario);
            $('.img-flag').css({'width':'50px','height':'20px'});
            buscaCXC($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
        });

        $('#s_id_sucursales').change(function(){
            
            if($('#s_id_sucursales').val() >= 1)
            {
                buscaCXC($('#s_id_unidades').val(),$('#s_id_sucursales').val());
                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0" selected>Mostrar Todas</option>');
                buscaCXC($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
            }
        });

        function buscaCXC(idUnidadNegocio,idSucursal){
            sucursalesPermiso=idSucursal;
            $('#i_filtro').val('');
            $('.renglon_registros').remove();
            $('#t_registros_buscar tbody').html('');

            var info = {
                'idUnidadNegocio' : idUnidadNegocio,
                'idSucursal': idSucursal,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'clientesInactivos':$('#ch_clientes_inactivos').is(':checked') ? 0 : 1
                //-->NJES July/20/2020 0= mostrar tambien los inactivos, 1= solo activos
            };

            $.ajax({
                type: 'POST',
                url: 'php/cxc_buscar_inicial.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data)
                {
                    
                    if(data.length != 0)
                    { 
                                     
                        for(var i=0;data.length>i;i++){
                            //-->NJES April/30/2021 mostrarid_cliente.id_razon_social y rfc_receptor a reporte excel
                            var html='<tr class="renglon_registros '+data[i].tipo+'" alt="'+data[i].tipo+'" alt2="'+data[i].id+'" alt3="'+data[i].id_unidad_negocio+'" alt4="'+data[i].id_cliente+'"  alt5="'+data[i].estatus+'" idCXC="'+data[i].folio_cxc+'" idFactura="'+data[i].id_factura+'" idNota="'+data[i].id_nota_credito+'" id_em_f="'+data[i].id_empresa_fiscal+'" empresa_fiscal="'+data[i].empresa_fiscal+'">\
                                        <td data-label="Unidad Negocio">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Fecha Vencimiento">'+data[i].fecha_vencimiento+'</td>\
                                        <td data-label="Id Cliente">'+data[i].id_cliente+'</td>\
                                        <td data-label="Cliente">'+data[i].cliente+'</td>\
                                        <td data-label="Id Razón Social">'+data[i].id_razon_social+'</td>\
                                        <td data-label="Razón Social (receptor)">'+data[i].razon_social+'</td>\
                                        <td data-label="RFC Receptor">'+data[i].rfc_receptor+'</td>\
                                        <td data-label="Deptos">'+data[i].deptos+'</td>\
                                        <td data-label="Folio cxc">'+data[i].id+'</td>\
                                        <td data-label="Factura">'+data[i].factura+'</td>\
                                        <td data-label="Nota">'+data[i].nota+'</td>\
                                        <td data-label="Saldo Inicial">'+formatearNumeroCSS(data[i].cargo_inicial,'')+'</td>\
                                        <td data-label="Saldo Inicial">'+formatearNumeroCSS(data[i].saldo,'')+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_buscar tbody').append(html);   
                        }

                        $('#b_excel').prop('disabled',false);
                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="15">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_buscar tbody').append(html);
                    }
                },
                error: function (xhr) {
                    console.log('php/cxc_buscar_inicial.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar registros.');
                }
            });
        }
        //--- BUSQUEDA PRINCIPAL
        $('#t_registros_buscar').on('click', '.renglon_registros', function(){
            tipo = $(this).attr('alt');
            idCXC = $(this).attr('alt2');
            var idUnidadNegocio = $(this).attr('alt3');
            var idCliente = $(this).attr('alt4');
            var estatus = $(this).attr('alt5');
            $("#div_principal").animate({left : "-101%"}, 500, 'swing');
            $('#div_nuevo_cxc').animate({left : "0%"}, 600, 'swing');
            
            var empresa_fiscal = $(this).attr('empresa_fiscal');
            var id_empresa_fiscal = $(this).attr('id_em_f');
            $('#i_empresa_fiscal').val(empresa_fiscal).attr('alt',id_empresa_fiscal);

            muestraSucursalesPermiso('s_id_sucursales_n',idUnidadNegocio,modulo,idUsuario);
            //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxc solo se puede pagar de bancos
            //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancosSaldos('s_cuenta_banco', 0,1,idUnidadNegocio);
            muestraConceptosCxP('s_concepto',1);
            muestraSelectRazonesSociales(idCliente,idUnidadNegocio,'s_razon_social');
            
            $('#form_razon_social').find('input,textarea').val('');
            $('#form_razon_social select').val(0);
            cargoInicial=0;
           
            if(tipo=='CXC' ){

                if(estatus!='C'){
                    $('#div_nuevo_cxc').find('input,select').prop('disabled',false);
                    $('#b_guardar').prop('disabled',false);
                    $('#b_buscar_clientes').prop('disabled',false);
                    $('#b_cancelar').prop('disabled',false);
                    $('#b_detalle_registro').prop('disabled',true);
                    $('#s_cuenta_banco').prop('disabled',false);

                    $('#div_nuevo_cxc').find('input,select').prop('disabled',true);
                    $('#b_buscar_clientes').prop('disabled',true);
                    $('#i_fecha,#s_concepto,#i_importe,#i_referencia').prop('disabled',false);
                }else{
                    $('#div_nuevo_cxc').find('input,select').prop('disabled',true);
                    $('#b_guardar').prop('disabled',true);
                    $('#b_buscar_clientes').prop('disabled',true);
                    $('#b_cancelar').prop('disabled',true);
                    $('#b_detalle_registro').prop('disabled',true);
                }

                $('.div_s_concepto').show();
                $('.div_pago').hide();
                $('.div_c').show();
                
            }else{
               
                $('#div_nuevo_cxc').find('input,select').prop('disabled',true);
                //$('#b_guardar').prop('disabled',true);
                $('#b_buscar_clientes').prop('disabled',true);
                $('#b_cancelar').prop('disabled',true);
                $('#b_detalle_registro').prop('disabled',false);
                //$('#s_id_unidades_n,#s_id_sucursales_n,#i_folio,#i_cliente,#s_razon_social,#s_cuenta_banco,#s_mes,#i_anio,#i_vencimiento')
                $('#i_fecha,#s_concepto,#i_importe,#i_referencia').prop('disabled',false);
                $('#s_cuenta_banco').prop('disabled',false);
                $('#s_concepto_pago,#s_forma_pago,#i_banco_cliente,#i_cuenta_cliente').prop('disabled',false),
                $('.div_s_concepto').hide();
                $('.div_pago').show();
                $('.div_c').hide();
            }
            muestraRegistro(tipo,idCXC);
            
        });

        function muestraRegistro(tipo,id){
           
            $.ajax({
                type: 'POST',
                url: 'php/cxc_buscar_registro_id.php',
                dataType:"json", 
                data : {'tipo':tipo,
                        'id':id
                },
                success: function(data) {
                   
                    if(parseInt(data.length) >0){                    
                        var dato = data[0];

                        $('#i_cliente').attr('alt',dato.id_cliente).val(dato.cliente);
                       
                        //$('#i_folio').val(dato.folio);
                        $('#i_folio').val(dato.id_cxc).attr('alt',dato.id_factura).attr('alt2',dato.id_nota_credito).attr('id_cxc',id);
                        $('#i_anio').val((dato.anio));
                        $('#i_vencimiento').val((dato.vencimiento));
                       
                        if(parseInt(dato.porcentaje_iva) == 16)
                            $('#r_16').prop('checked',true);
                        else if(dato.porcentaje_iva == 8)
                            $('#r_8').prop('checked',true);
                        else
                            $('#r_0').prop('checked',true);

                        $('#s_id_unidades_n').val(dato.id_unidad_negocio);
                        $("#s_id_unidades_n").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                        $('#s_id_sucursales_n').val(dato.id_sucursal);
                        $('#s_id_sucursales_n').select2({placeholder: $(this).data('elemento')});
                       
                       
                        $('#s_cuenta_banco').val(dato.id_cuenta_banco);
                        $('#s_cuenta_banco').select2({placeholder: $(this).data('elemento')});
                       
                        $('#s_razon_social').val(dato.id_razon_social);
                        $('#s_razon_social').select2({placeholder: $(this).data('elemento')});

                        $('#s_mes').val(dato.mes);
                        $('#s_mes').select2({placeholder: $(this).data('elemento')});
                      
                        if(dato.estatus=='A'){
                           
                            $('#b_cancelar').prop('disabled',false);
                            if(tipo=='CXC')
                             $('#b_cancelar').prop('disabled',false);
                            else
                            $('#b_cancelar').prop('disabled',true);
                            
                        }else{

                            if(dato.estatus=='C'){
                                $('#b_cancelar').prop('disabled',true);
                            }else{
                                if(tipo=='CXC')
                                    $('#b_cancelar').prop('disabled',false);
                                else
                                    $('#b_cancelar').prop('disabled',true);
                            }

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

        function labelEstatus(estatus){
            var est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #0066cc;">SIN TIMBRAR</label>';
                        if(estatus == 'T')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">TIMBRADA</label>';
                        else if(estatus == 'C')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ff0000;">CANCELADA</label>';
                        else if(estatus == 'P')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ffc107;">PENDIENTE</label>';
                        else if(estatus == 'A')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #28a745;">ACTIVO</label>';
                        else if(estatus == 'S')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">SALDADA</label>';
                       
            return est;
        }

     /*****FIN BUSQUEDA DE REGISTROS INICAL */   

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
                muestraSelectRazonesSociales(id,$('#s_id_unidades').val(),'s_razon_social');
            }
        });

       

        $('#s_razon_social').change(function(){
            var rfc = $('#s_razon_social option:selected').attr('alt2');
            var dias_credito = $('#s_razon_social option:selected').attr('alt');
            var correo = $('#s_razon_social option:selected').attr('alt4');

            $('#i_dias_credito').val(dias_credito);
            $('#i_rfc').val(rfc);
            $('#i_email').val(correo);
        });

        $('#i_fecha').val(hoy);
        $('#i_anio').val(anio);


        $('#b_nuevo').on('click',function(){

            $("#div_principal").animate({left : "-101%"}, 500, 'swing');
            $('#div_nuevo_cxc').animate({left : "0%"}, 600, 'swing');

            $('#t_registros tbody').empty();
            $('#form_razon_social').find('input,textarea').not('input:radio').val('');
            //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxc solo se puede pagar de bancos
            //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
             //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancosSaldos('s_cuenta_banco', 0,1,idUnidadActual);
            muestraConceptosCxP('s_concepto',1);
            $('#i_folio').val('');
            $('#i_cliente').val('');
            $('#i_vencimiento').val('');
            $('#s_mes').val('');
            $('#i_anio').val('');
            $('#i_saldo').val(formatearNumero(0.00));
            muestraSelectRazonesSociales(0,idUnidadActual,'s_razon_social');
            muestraSucursalesPermiso('s_id_sucursales_n',$('#s_id_unidades_n').val(),modulo,idUsuario);
            $('#form_razon_social select').val(0);
            $('#b_cancelar').prop('disabled',true);

            $('#div_nuevo_cxc').find('input,select').prop('disabled',false);
            $('#b_buscar_clientes').prop('disabled',false);
           
            cargoInicial=1;
            tipo='CXC';  
            $('.div_s_concepto').show();
            $('.div_pago').hide();
            $('.div_c').show();         
        });

        $('#b_regresar').on('click',function(){
           
            $("#div_nuevo_cxc").animate({left : "-101%"}, 500, 'swing');
            $('#div_principal').animate({left : "0%"}, 600, 'swing');
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxc solo se puede pagar de bancos
            //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
             //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancosSaldos('s_cuenta_banco',0,1,idUnidadActual);
            muestraConceptosCxP('s_concepto',1);
            generaFecha('s_mes');

            muestraConceptosCxP('s_concepto_pago',5);
            muestraSelectFormaPago('PUE','s_forma_pago');

            $('#i_banco_cliente,#i_cuenta_cliente').val('');
            $('#i_importe,#i_total_iva,#i_total').val('');
            
            $('#i_fecha_inicio').val(primerDiaMes);
            $('#i_fecha_fin').val(ultimoDiaMes);
            $('#t_registros tbody').empty();

            buscaCXC(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));

        });

        $('input[name=radio_iva]').on('change',function(){

            var importe = quitaComa($('#i_importe').val());
            var tasa_iva = $('input[name=radio_iva]:checked').val();
            var total_iva=0;
            

            if(parseInt(tasa_iva) > 0){
                total_iva = parseFloat(importe) * (parseInt(tasa_iva)/100);
            }

            var total = importe + total_iva;
            $('#i_total_iva').val(formatearNumero(total_iva));
            $('#i_total').val(formatearNumero(total));

        });

        $('#i_importe').on('change',function(){

            anteriorClase = $('#i_importe').attr('class');

            var importe = quitaComa($(this).val());
            var tasa_iva = $('input[name=radio_iva]:checked').val();
            var total_iva=0;
            

            if(parseInt(tasa_iva) > 0){
                total_iva = parseFloat(importe) * (parseInt(tasa_iva)/100);
            }

            var total = importe + total_iva;
           
            $('#i_total_iva').val(formatearNumero(total_iva));
            $('#i_total').val(formatearNumero(total));
            
        });
        

        $('#b_guardar').click(function(){
            $('#b_guardar').prop('disabled',true);

            if($('#forma_cxc').validationEngine('validate'))
            {
                if(parseFloat(quitaComa($('#i_saldo').val())) > 0)
                {   
                    if(parseFloat(quitaComa($('#i_saldo').val())) >= parseFloat(quitaComa($('#i_importe').val())))
                    {  
                        if(tipo=='CXC' )
                            guardar();
                        else{
                            //-->NJES Jun/18/2021 si es un C04 (Cargo Moneda Cambiaria) o A08 (Abono Moneda Cambiaria) 
                            //no genera registro en pagos, solo en cxc
                            var concepto = $('#s_concepto_pago option:selected').attr('alt');
                            var idConcepto = $('#s_concepto_pago option:selected').val();

                            if(idConcepto == 33 || idConcepto == 34)
                                guardar();
                            else
                                guardarPago();
                        }
                    }else{
                        mandarMensaje('Solo puedes abonar una cantidad igual o menos al saldo');
                        $('#b_guardar').prop('disabled',false);
                    }
                }else{
                    if(tipo=='CXC' )
                        var concepto = $('#s_concepto option:selected').attr('alt');
                    else
                        var concepto = $('#s_concepto_pago option:selected').attr('alt');

                    var res = concepto.substr(0, 1);
                    if(res == 'C'){
                        //--> Si es un cargo no comparo mi saldo disponible de la cuenta por que es un ingreso a mi
                        if(tipo=='CXC' )
                            guardar();
                        else{
                            //-->NJES Jun/18/2021 si es un C04 (Cargo Moneda Cambiaria) o A08 (Abono Moneda Cambiaria) 
                            //no genera registro en pagos, solo en cxc
                            var idConcepto = $('#s_concepto_pago option:selected').val();

                            if(idConcepto == 33 || idConcepto == 34)
                                guardar();
                            else
                                guardarPago();
                        }
                    }else{
                        mandarMensaje('No es posible realizar un abono cuando el saldo es 0');
                        $('#b_guardar').prop('disabled',false);
                    }
                }

            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardar(){

            //-->NJES Jun/18/2021 si es un C04 (Cargo Moneda Cambiaria) o A08 (Abono Moneda Cambiaria) 
            //no genera registro en pagos, solo en cxc
            if(tipo=='CXC')
            {
                var idConcepto = $('#s_concepto option:selected').val();
                var cveConcepto = $('#s_concepto option:selected').attr('alt');
            }else{
                var idConcepto = $('#s_concepto_pago option:selected').val();
                var cveConcepto = $('#s_concepto_pago option:selected').attr('alt');
            }

            var info = {

                'idCxC' : $('#i_folio').val(),
                'folio' : $('#i_folio').val(),
                'idUnidadNegocio' : $('#s_id_unidades_n').val(),
                'idSucursal' : $('#s_id_sucursales_n').val(),
                'idRazonSocialReceptor' : $('#s_razon_social').val(),
                'idBanco' : $('#s_cuenta_banco option:selected').attr('alt'),
                'idCuentaBanco' : $('#s_cuenta_banco').val(),
                'tipoCuenta' : $('#s_cuenta_banco option:selected').attr('alt2'),

                'vencimiento' : $('#i_vencimiento').val(),
                'tasaIva' : $('input[name=radio_iva]:checked').val(),
                'mes' : $('#s_mes').val(),
                'anio' : $('#i_anio').val(),
                
               
                'fecha' : $('#i_fecha').val(),
                
                'idConcepto' : idConcepto,
                'cveConcepto' : cveConcepto,

                'importe' : quitaComa($('#i_importe').val()),
                'totalIva' : quitaComa($('#i_total_iva').val()),
                'total' : quitaComa($('#i_total').val()),
                'referencia' : $('#i_referencia').val(),

                'cargoInicial': cargoInicial,
                'idUsuario' : idUsuario,
                'estatus' : estatus,
            };

            $.ajax({
                type: 'POST',
                url: 'php/cxc_guardar.php',
                data:  {'datos':info},
                dataType:"json",
                success: function(data) {
                   console.log(JSON.stringify(data));
                    if(data > 0 )
                    { 
                        if($('#i_folio').val()!='' && parseInt($('#i_folio').val())>0){
                             idCxC = $('#i_folio').val();
                        }else{
                            
                            idCxC = data;
                            $('#i_folio').val(data);
                        }
                        
                        mandarMensaje('Se realizo el proceso correctamente');
                        $('#s_concepto').prop('disabled',false);
                        muestraConceptosCxP('s_concepto',1);
                        $('#i_fecha,#i_importe,#i_total_iva,#i_total,#i_referencia').val('');
                        $('#i_importe,#i_referencia').prop('disabled',false);
                        muestraSaldoDisponible(idCxC,tipo);
                        $('#b_cancelar').prop('disabled',false);      
                        $('#b_guardar').prop('disabled',false);

                        //$('#div_nuevo_cxc').find('input,select').prop('disabled',true);
                        $('#b_buscar_clientes').prop('disabled',true);

                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }

                    $('.div_pago').hide();
                    $('.div_c').show();
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
            //alert(idCxC+' * '+tipo);
            cargoInicial = 0;
            saldoActual = 0;
            $.ajax({
                type: 'POST',
                url: 'php/cxc_saldo_actual_buscar.php',
                dataType:"json", 
                data:{'idCxC' : idCxC,
                      'tipo' : tipo
                },
                success: function(data)
                { console.log('Sado:'+data);
                   
                    var arreglo=data;
                    if(parseInt(arreglo.length)>0){
                      
                        for(var i=0;i<arreglo.length;i++)
                        {
                            var dato=arreglo[i];
                            estatus='A';
                            $('#i_saldo').val(formatearNumero(dato.saldo));
                            saldoActual = parseFloat(dato.saldo);   

                            if(parseFloat(dato.saldo) > 0)
                            {
                                $('#i_importe').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01],max['+parseFloat(dato.saldo)+']] numeroMoneda');
                            
                            }else if(parseFloat(dato.saldo) == 0){
                                estatus='S';
                                $('#i_importe').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]] numeroMoneda');
                            }else{
                                $('#i_importe').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]] numeroMoneda');
                            }

                           
                        }
                        muestraRegistros(idCxC,tipo);
                    }
                },
                error: function (xhr) {
                    console.log("cxc_saldo_actual_buscar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo de la factura');
                }
            });
        }

        function muestraRegistros(idCxC,tipo){
           //alert('muestra registros '+idCxC+' * '+tipo);
            $('#t_registros tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/cxc_registros_idCxC_buscar.php',
                dataType:"json", 
                data:{'idCxC':idCxC,
                      'tipo':tipo
                },
                success: function(data) {
                    //console.log("Registro:"+data);
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
                                    if(tipo == 'CXC')
                                    {
                                        var boton = '<button type="button" class="btn btn-danger btn-sm b_cancelar_p" alt="'+data[i].id+'">\
                                                    <i class="fa fa-ban" aria-hidden="true"></i>\
                                                </button>';
                                    }else
                                        var boton = '';

                                }else{
                                    var boton = '';
                                }
                                var cancelado = '';
                            }

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon estatus_'+data[i].estatus+'" '+cancelado+'  alt="'+data[i].id+'">\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Tipo">'+data[i].tipo+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Concepto">'+data[i].concepto+'</td>\
                                        <td data-label="Concepto">'+data[i].iva+'</td>\
                                        <td data-label="Cargos" class="cargos">'+formatearNumero(data[i].cargos)+'</td>\
                                        <td data-label="Abonos" class="cargos">'+formatearNumero(data[i].abonos)+'</td>\
                                        <td data-label="Referencia">'+data[i].referencia+'</td>\
                                        <td>'+boton+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html); 
                            
                        }

                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="8">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxc_registros_idCxC_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos de factura');
                }
            });
        }

        
        ///----CANCELAR--------------------------------------
        $(document).on('click','.b_cancelar_p',function(){

            var id = $(this).attr('alt');

            $.ajax({
                type: 'POST',
                url: 'php/cxc_cancelar.php',
                dataType:"json", 
                data:{'idCXC':id,
                      'tipo':'registro',
                      'idUsuario':idUsuario
                },
                success: function(data) {
                    if(data.length != 0){
                        mandarMensaje('El registro se canceló correctamente');
                        muestraSaldoDisponible($('#i_folio').val(),tipo);
                    }else{
                        mandarMensaje('Ocurrio un error durante el proceso');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxc_cancelar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se pudó cancelar el registro');
                }
            });        

        });

        $(document).on('click','#b_cancelar',function(){

            $.ajax({
                type: 'POST',
                url: 'php/cxc_cancelar.php',
                dataType:"json", 
                data:{'idCXC':$('#i_folio').val(),
                    'tipo':'folio',
                    'idUsuario':idUsuario
                },
                success: function(data) {
                    if(data.length != 0){
                        mandarMensaje('El movimiento de cxc se canceló correctamente');
                        muestraSaldoDisponible($('#i_folio').val(),'CXC');
                        $('#b_cancelar').prop('disabled',true);
                    }else{
                        mandarMensaje('Ocurrio un error durante el proceso');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxc_cancelar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se pudó cancelar el cxc');
                }
            });        

        });


        $('#b_excel').click(function(){

            if($('#i_fecha_inicio').val() != '')
            {
                var fechaInicio = $('#i_fecha_inicio').val();
            }else{
                var fechaInicio = primerDiaMes;
            }

            if($('#i_fecha_fin').val() != '')
            {
                var fechaFin = $('#i_fecha_fin').val();
            }else{
                var fechaFin = ultimoDiaMes;
            }
            var todas=0;

            var sucursal='';
         
            if($('#s_id_sucursales').val()>0){
                sucursal = $('#s_id_sucursales').val();
            }else{
                sucursal = sucursalesPermiso;
                todas=1;
                
            }
            
            var datos = {
                'idUNidadNegocio':$('#s_id_unidades').val(),
                'idSucursal':sucursal,
                'todas':todas,
                'fechaInicio':fechaInicio,
                'fechaFin':fechaFin,
                'clientesInactivos':$('#ch_clientes_inactivos').is(':checked') ? 0 : 1
                //-->NJES July/20/2020 0= mostrar tambien los inactivos, 1= solo activos
            };
            
            $("#i_nombre_excel").val('Registros CXC');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('CXC');
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

        muestraConceptosCxP('s_concepto_pago',5);
        muestraSelectFormaPago('PUE','s_forma_pago');
        
        function guardarPago(){
            var info = {
                'idUnidadNegocio' : $('#s_id_unidades_n').val(),
                'idSucursal' : $('#s_id_sucursales_n').val(),
                'idCliente' : $('#i_cliente').attr('alt'),
                'idMetodoPago' : 'PUE',
                'importe' : quitaComa($('#i_importe').val()),
                'idCuentaBanco' : $('#s_cuenta_banco option:selected').attr('alt'),
                'tipoCuenta' : $('#s_cuenta_banco option:selected').attr('alt2'),
                'idUsuario' : idUsuario,
                'fecha' : $('#i_fecha').val(),
                'usuario' : usuario,
                'idRazonSocialCliente' : $('#s_razon_social').val(),
                'razonSocialCliente' : $('#s_razon_social option:selected').attr('alt6'),
                'rfcCliente' : $('#s_razon_social option:selected').attr('alt2'),
                'cpCliente' : $('#s_razon_social option:selected').attr('alt3'),
                'tipo' : 'pago',
                'mismoRFC' : 0,
                'idEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt'),
                'concepto' : $('#s_concepto_pago').val(),
                'formaPago' : $('#s_forma_pago').val(),        
                'bancoCliente' : $('#i_banco_cliente').val(),        
                'numCuentaCliente' : $('#i_cuenta_cliente').val(),
                'facturasPagar' : obtieneFacturasPagar() 
                //'pagosSustituir' : obtienePagosSustituir(),
                
            };

            console.log(JSON.stringify(info));

            $.ajax({
                type: 'POST',
                url: 'php/pagos_guardar.php',
                data:  {'datos':info},
                dataType:"json",
                success: function(data) {
                console.log(JSON.stringify(data));
                    if(data != 0 )
                    { 
                        idCxC = $('#i_folio').attr('id_cxc');
                        
                        mandarMensaje('Se realizo el proceso correctamente');
                        $('#s_concepto_cxp').prop('disabled',false);
                        muestraConceptosCxP('s_concepto',1);
                        $('#i_fecha,#i_importe,#i_total_iva,#i_total,#i_referencia').val('');
                        muestraSaldoDisponible(idCxC,'FAC');
                        //$('#b_cancelar').prop('disabled',false);      
                        $('#b_guardar').prop('disabled',false);

                        muestraConceptosCxP('s_concepto_pago',5);
                        muestraSelectFormaPago('PUE','s_forma_pago');
                        $('#i_banco_cliente,#i_cuenta_cliente').val('');
                    
                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }

                    $('.div_pago').show();
                    $('.div_c').hide();
                },
                error: function (xhr) 
                {
                    console.log('php/cxp_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        function obtieneFacturasPagar(){
            var j = 0;
            var arreglo = [];

            var idFactura = $('#i_folio').attr('alt');
            var datosF = datosFactura(idFactura);

            arreglo[j] = {
                'idFactura' : idFactura,
                'uuidfactura' : datosF[2],
                'folioFactura' : datosF[0],
                'importe' : quitaComa($('#i_importe').val()),
                'saldoAnterior' : quitaComa($('#i_saldo').val()),
                'multipleCXC' : datosF[3],
                'idServicio' : datosF[1]
            };  

            return arreglo;
        }

        function datosFactura(idFactura){
            var arr = [];
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_pocos_datos_buscar.php',
                data:  {'idFactura':idFactura},
                dataType:"json",
                async: false,
                success: function(data) {
                    console.log(JSON.stringify(data));
                    var multipleCxC = 0;

                    if(data[0].registros_cxc > 1)
                        multipleCxC = 1;

                    arr = [data[0].folio,data[0].id_cliente,data[0].uuid_timbre,multipleCxC];
                },
                error: function (xhr) 
                {
                    console.log('php/cxp_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                }
            });

            return arr;
        }

        $('#b_ver_datos_factura').click(function(){
            var idFactura = $('#i_folio').attr('alt');

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_id.php',
                dataType:"json", 
                data:{
                    'idFactura':idFactura
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#dato_factura').text(data[0].folio);

                        var detalles = '<p><b>Folio Fiscal:</b> '+data[0].folio_fiscal+'</p>';
                            detalles += '<p><b>Empresa Fiscal:</b> '+data[0].empresa_fiscal+'</p>';
                            detalles += '<p><b>Cliente:</b> '+data[0].cliente+'</p>';
                            detalles += '<p><b>Razón Social:</b> '+data[0].razon_social+'</p>';
                            detalles += '<p><b>RFC:</b> '+data[0].rfc_razon_social+'</p>';
                            detalles += '<p><b>Metodo Pago:</b> '+data[0].metodo_pago+'</p>';
                            /*if(data[0].retencion == 1)
                            {
                                detalles += '<p><b>importe Retención:</b> '+data[0].importe_retencion+'</p>';
                            }*/

                        $('#div_datos_factura').html(detalles);

                    }

                    $('#dialog_datos_factura').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos de factura');
                }
            });
        });

        $('#ch_clientes_inactivos').click(function(){
            if($('#s_id_sucursales').val() >= 1)
            {
                buscaCXC($('#s_id_unidades').val(),$('#s_id_sucursales').val());
            }else{
                buscaCXC($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
            }
        });
        
    });

</script>

</html>