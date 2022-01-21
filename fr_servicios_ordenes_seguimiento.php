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

    #d_estatus{
       padding-top:5px;
       text-align:center;
       font-weight:bold;
       font-size:13px;
       height:30px;
       vertical-align:middle;
   }
   
    #vistaPrevia_1{
        border: 1px solid rgb(214, 214, 194); 
        background-color: #fff; 
        max-height: 55px; 
        min-height: 55px;
        width:100px;
    }
    #label_nota{
        font-size:14px;
        color:#006600;
    }

    #dialog_seguimiento > .modal-lg{
        min-width: 80%;
        max-width: 80%;
   }

   
   textarea{
       resize:none;
   }

   .PENDIENTE td{
     background:#FFF3CD;
   }
   .CANCELADA td{
    background:#F8D7DA;
   }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row"><!-- row--->
            <div class="col-sm-1 col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row"><!-- row--->
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Ordenes Pendientes</div>
                    </div>
                    <!--NJES October/20/2020 se agrega filtro sucursal para pantalla secciones-->
                    <label for="s_id_sucursales_filtro" class="col-sm-2 col-md-1 col-form-label requerido">Sucursal </label>
                    <div class="col-sm-4 col-md-4">
                        <select id="s_id_sucursales_filtro" name="s_id_sucursales_filtro" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <!--NJES Jan/27/2020 se agrega boton para abrir todas las opciones del accordion -->
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_expandir"><i class="fa fa-expand" aria-hidden="true"></i> Expandir</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" id="b_regresar" alt="ORDEN_SERVICIO"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>
                <br>

                <div id="accordion">

                    <!--NJES Jan/27/2020 se agrega nueva seccion y se añaden a accordion-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button style="padding:0px;" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Vencidas
                                        </button>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="i_filtro_1" name="i_filtro_1" alt="renglon_sin_atender" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                    </div>
                                </div>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body" style="padding:0px;">
                                <div class="row" id="div_sin_atender">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon">
                                            <thead>
                                            <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                                <th scope="col"  colspan="8" style="text-align: left;">Vencidas </th>
                                            </tr>
                                            <tr class="renglon" style="background-color: #4CB594;">
                                                <th scope="col">ID</th>
                                                <th scope="col">Sucursal</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Tipo Servicio</th>
                                                <th scope="col">Prioridad</th>
                                                <th scope="col">Capturó</th>
                                                <th scope="col">Estatus</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>  
                                        <div style="overflow-y: scroll;min-height:200px;max-height:200px;">
                                            <table class="tablon"  id="t_sin_atender">
                                                <tbody>
                                                
                                                </tbody>
                                            </table>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button style="padding:0px;" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Más  de 48 horas Canceldas ó Pendientes
                                        </button>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="i_filtro_2" name="i_filtro_2" alt="renglon_mas48h" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                    </div>
                                </div>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" style="padding:0px;">
                                <div class="row" id="div_mas_48h">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon">
                                            <thead>
                                            <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                                <th scope="col"  colspan="8" style="text-align: left;">Más  de 48 horas Canceldas ó Pendientes</th>
                                            </tr>
                                            <tr class="renglon" style="background-color: #A94442;">
                                                <th scope="col">ID</th>
                                                <th scope="col">Sucursal</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Tipo Servicio</th>
                                                <th scope="col">Prioridad</th>
                                                <th scope="col">Capturó</th>
                                                <th scope="col">Estatus</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table> 
                                        <div style="overflow-y: scroll;min-height:200px;max-height:200px;">
                                            <table class="tablon"  id="t_mas_48h">
                                                <tbody>
                                                
                                                </tbody>
                                            </table>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button style="padding:0px;" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Esta semana
                                        </button>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="i_filtro_3" name="i_filtro_3" alt="renglon_menos_una_semana" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                    </div>
                                </div>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body" style="padding:0px;">
                                <div class="row" id="div_menos_una_semana">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon">
                                            <thead>
                                            <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                                <th scope="col"  colspan="8" style="text-align: left;">Esta semana</th>
                                            </tr>
                                            <tr class="renglon" style="background-color: #FEE89D;">
                                                <th scope="col">ID</th>
                                                <th scope="col">Sucursal</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Tipo Servicio</th>
                                                <th scope="col">Prioridad</th>
                                                <th scope="col">Capturó</th>
                                                <th scope="col">Estatus</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>  
                                        <div style="overflow-y: scroll;min-height:200px;max-height:200px;">
                                            <table class="tablon"  id="t_menos_una_semana">
                                                <tbody>
                                                
                                                </tbody>
                                            </table>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button style="padding:0px;" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Más de una semana
                                        </button>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="i_filtro_4" name="i_filtro_4" alt="renglon_una_semana" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                    </div>
                                </div>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="card-body" style="padding:0px;">
                                <div class="row" id="div_mas_una_semana">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon">
                                            <thead>
                                            <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                                <th scope="col"  colspan="8" style="text-align: left;">Más de una Semana</th>
                                            </tr>
                                            <tr class="renglon" style="background-color: #A3CED7;">
                                                <th scope="col">ID</th>
                                                <th scope="col">Sucursal</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Tipo Servicio</th>
                                                <th scope="col">Prioridad</th>
                                                <th scope="col">Capturó</th>
                                                <th scope="col">Estatus</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>  
                                        <div style="overflow-y: scroll;min-height:200px;max-height:200px;">
                                            <table class="tablon"  id="t_mas_una_semana">
                                                <tbody>
                                                
                                                </tbody>
                                            </table>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div> 
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_seguimiento" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pendientes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row"><!-- row--->
        <div class="col-md-1"></div>
        <div class="col-md-offset-1 col-md-10" id="div_contenedor">
        <br>            
        <form id="forma" name="forma">
            <div class="form-group row">
                <label for="s_id_sucursales" class="col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                <div class="col-sm-4 col-md-4">
                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;" disabled></select>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div id="d_estatus" class="alert alert-light"></div>
                </div>
                <div class="col-md-1">
                    <label for="i_fecha_sol" class="col-form-label">Solicitud</label>
                </div>
                <div class="col-md-2">
                    <input type="text" id="i_fecha_solicitud" name="i_fecha_solicitud" class="form-control form-control-sm  validate[required]"  autocomplete="off" readonly>
                </div>
                
            </div>
            <div class="form-group row">
                <label for="i_tecnico" class="col-2 col-md-2 col-form-label" id='l_tecnico'>Técnico </label><br>
                <div class="col-sm-12 col-md-6">
                    <div class="row"><!-- row--->
                        <div class="input-group col-sm-12 col-md-12">
                            <input type="text" id="i_tecnico" name="i_tecnico" class="form-control" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar_tecnico" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <label for="s_reporta" class="col-sm-1 col-md-1 col-form-label requerido">Reporta </label>
                <div class="col-sm-3 col-md-3">
                    <select class="form-control validate[required]" id="s_reporta" name="s_reporta" readonly></select>
                </div>
            </div>

            <div class="form-group row">
                <label for="i_cliente" class="col-2 col-md-2 col-form-label requerido">Cliente </label><br>
                <div class="col-sm-12 col-md-6">
                    <div class="row"><!-- row--->
                        <div class="input-group col-sm-12 col-md-12">
                            <input type="text" id="i_cliente" name="i_cliente" class="form-control validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="form-group row">
                <label for="i_servicio" class="col-sm-2 col-md-2 col-form-label">Servicio</label>
                <div class="col-sm-12 col-md-8">
                    <input type="text" class="form-control validate[required]" id="i_servicio" name="i_servicio" value="INSTALACIÓN" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="ta_descripcion" class="col-sm-2 col-md-2 col-form-label">Descripción</label>
                <div class="col-sm-12 col-md-8">
                    <textarea class="form-control validate[required]" id="ta_descripcion" name="ta_descripcion" readonly></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="ta_proceso" class="col-sm-2 col-md-2 col-form-label requerido">Proceso</label>
                <div class="col-sm-12 col-md-8">
                    <textarea class="form-control validate[required]" id="ta_proceso" name="ta_proceso"></textarea>
                </div>
            </div>

            <div class="form-group row">
                
                <label for="s_prioridad" class="col-sm-2 col-md-2 col-form-label requerido">Prioridad </label>
                <div class="col-sm-2 col-md-2">
                    <select class="form-control validate[required]" id="s_prioridad" name="s_prioridad" readonly></select>
                </div>
                <label for="s_clasificacion_servicios" class="col-sm-2 col-md-2 col-form-label requerido" readonly>Clasificación </label>
                <div class="col-sm-3 col-md-6">
                    <select class="form-control validate[required]" id="s_clasificacion_servicios" name="s_clasificacion_servicios"></select>
                </div>
            </div>

            <div class="form-group row">
                <label for="ta_acciones_realizadas" class="col-sm-2 col-md-2 col-form-label requerido">Acciónes Realizadas</label>
                <div class="col-sm-12 col-md-8">
                    <textarea class="form-control validate[required]" id="ta_acciones_realizadas" name="ta_acciones_realizadas"></textarea>
                </div>
            </div>
        </form>    
        </div>
        </div>    
      </div><!-- body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-md" id="b_cancelar_orden"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
        <button type="button" class="btn btn-warning btn-md verificar_permiso" alt="BOTON_SEGUIMIENTO_ORDEN_PENDIENTE" id="b_seguimiento_orden"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Seguimiento</button>
        <button type="button" class="btn btn-info btn-md verificar_permiso" alt="BOTON_IMPRIMIR_ORDEN_PENDIENTE" id="b_imprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
        <button type="button" class="btn btn-dark btn-md verificar_permiso" alt="BOTON_CIERRAR_ORDEN_PENDIENTE" id="b_cerrar_orden"><i class="fa fa-check-square-o" aria-hidden="true"></i> Cerrar Orden</button>
        <button type="button" class="btn btn-success btn-md" id="b_cobrar"><i class="fa fa-money" aria-hidden="true"></i> Generar Cobro</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dialog_cancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Justificación de la Cancelación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_cancelacion" name="form_cancelacion">
        <textarea id="t_justificacion" rows="5" name="t_justificacion" style="width:100%;resize:none;"></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="b_aceptar_cancelar" class="btn btn-primary verificar_permiso" alt="BOTON_CANCELAR_ORDEN_PENDIENTE">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dialog_cobrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cobrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="forma_cxc" name="forma_cxc">
        <div class="row">
            <div class="col-md-6">
                <label for="s_cuenta_banco" class="col-form-label requerido">Banco</label>
                <select id="s_cuenta_banco" name="s_cuenta_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>  
            </div>
            <label for="i_empleado" class="col-md-2 col-form-label"> <input type="checkbox" name="ch_facturar" id="ch_facturar"> Facturar </label>
            <label for="i_empleado" class="col-md-2 col-form-label"> <input type="checkbox" name="ch_sin_cobro" id="ch_sin_cobro"> Sin Cobro </label>
     
        </div> 
        <div class="row">
            <label for="s_concepto" class="col-md-2 col-form-label"><br>Periodo</label>
            <div class="col-md-4">
                <label for="s_mes" class="col-form-label requerido">Mes</label>
                <select id="s_mes" name="s_mes" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
            </div>
            <div class="col-md-2">
                <label for="i_anio" class="col-form-label requerido">Año</label>
                <input type="text" id="i_anio" name="i_anio" class="form-control form-control-sm validate[required,custom[integer],minSize[4],maxSize[4]]"  autocomplete="off">
            </div>
            
            <div class="col-md-3">
                <label for="i_vencimiento" class="col-form-label requerido">Vencimiento</label>
                <input type="text" id="i_vencimiento" name="i_vencimiento" class="form-control form-control-sm validate[required] fecha" readonly  autocomplete="off">
            </div>

        </div> <!-- /row---> 
        <br> 
        <div class="row" style="border:1px solid #A3CED7;background:rgba(163,206,215,0.3);padding-bottom:10px;"><!-- row--->
            
            <div class="col-md-4">
                <label for="i_fecha" class="col-form-label requerido">Fecha</label>
                <input type="text" id="i_fecha" name="i_fecha" class="form-control form-control-sm validate[required] fecha"  autocomplete="off" readonly>
            </div>

            <div class="col-md-4">
            <label for="s_concepto" class="col-form-label requerido">Concepto</label>
            <select id="s_concepto" name="s_concepto" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>  
            </div>

            <div class="col-md-4">
                <label for="i_referencia" class="col-md-2 col-form-label requerido">Referencia</label>
                <input type="text" id="i_referencia" name="i_referencia" class="form-control form-control-sm validate[required]"  autocomplete="off">
            </div>
            </div>
            <br>
            <div class="row"><!-- row--->
            <div class="col-md-7"><label for="" class="col-md-12 col-form-label requerido">Tasa IVA</label></div>
            <label for="i_importe" class="col-md-2 col-form-label requerido">Importe</label>
            <div class="col-md-3">
                <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm validate[required] numeroMoneda"  autocomplete="off">
            </div>
            </div>
            <div class="row"><!-- row--->
            <div class="col-md-7">
                <div class="row"><!-- row--->
                    <div class="col-sm-4 col-md-4">
                    16% <input type="radio" name="radio_iva" id="r_16" value="16" checked>  
                    </div>
                    <div class="col-sm-4 col-md-4">
                    8%  <input type="radio" name="radio_iva" id="r_8" value="8"> 
                    </div>
                </div>
                <div class="row">
                    <label for="i_concepto_cobro" class="col-md-12 col-form-label requerido">Concepto de cobro</label>
                    <div class="col-md-12">
                        <input type="text" id="i_concepto_cobro" name="i_concepto_cobro" class="form-control validate[required] form-control-sm" autocomplete="off">
                    </div>
                </div>
            </div>
            <label for="i_total_iva" class="col-md-2 col-form-label requerido">Iva</label>
            <div class="col-md-3">
                <input type="text" id="i_total_iva" name="i_total_iva" class="form-control form-control-sm validate[required] numeroMoneda" readonly  autocomplete="off">
            </div>
            </div>
            <div class="row"><!-- row--->
            <div class="col-md-7"></div>
            <label for="i_total" class="col-md-2 col-form-label requerido">Total</label>
            <div class="col-md-3">
                <input type="text" id="i_total" name="i_total" class="form-control form-control-sm validate[required] numeroMoneda" readonly autocomplete="off">
            </div>
            </div>
            
            <div class="row"><!-- row--->
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <button type="button" class="btn btn-dark btn-sm form-control verificar_permiso" alt="BOTON_COBRO_ORDEN_PENDIENTE" id="b_guardar_cxc"><i class="fa fa-save" aria-hidden="true"></i> Guardar </button>
            </div>
            
        </div><!-- /row--->
      </form><!--div forma_general-->
      <br>
      </div>
    </div>
  </div>
</div>

<div id="dialog_buscar_empleados" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Empleados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
             </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_empleados">
                      <thead>
                        <tr class="renglon">
                        <th scope="col" colspan="3"><h6><span class="badge badge-warning">Por default meestra los empelados activos de esta unidad de negocio</span></h6>
           </th>
                        </tr>
                        <tr class="renglon">
                          <th scope="col" colspan="2"><input type="text" name="i_filtro_tecnico" id="i_filtro_tecnico" class="form-control form-control-sm filtrar_renglones" alt="renglon_empleados" placeholder="Filtrar" autocomplete="off"></th>
                        </tr>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Sucursal</th>
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

<div id="dialog_fecha_atencion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cierre de Orden </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         Por favor ingresa la fecha de atención para cerrar esta orden:<br>
        <form id="form_fecha_a" name ="form_fecha_a">
            <div class="row">
                
                <div class="form-group">
                    <div class="input-group col-sm-12 col-md-12">
                         Fecha Atención: &nbsp;&nbsp;&nbsp;
                        <input type="text" name="i_fecha_atencion" id="i_fecha_atencion" class="form-control form-control-sm validate[required] fecha" autocomplete="off" readonly>
                        <div class="input-group-addon input_group_span">
                            <span class="input-group-text">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-dark btn-sm" id="b_guardar_fecha_atencion">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_correos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Correos cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         Por favor ingresa 1 o varios correos separados por ,<br>
        <form id="form_correos" name ="form_correos">
            <div class="row">
                Correos: <br>
                <div class="input-group col-sm-12 col-md-12">     
                    <input type="text" class="form-control validate[required,custom[multiEmail]]" id="i_correos" autocomplete="off" placeholder="ejemplo: correo1@alarmas.com,correo2@alarmas.com">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-dark btn-sm" id="b_guardar_correos">Guardar</button>
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

    var modulo='ORDENES_PENDIENTES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var estatusCierre='';
    var estatusOrden='';
    $(function(){

        muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
        mostrarBotonAyuda(modulo);
        buscarMas48H();
        buscarUnaSemana();
        buscarMenosSemana();
        verificarPermisoSoloLectura();
        //--> NJES Jan/27/2020 Agregar funcion para mostrar las ordenes de servicio que tienen mas de una semana sin atender
        sinAtender();

        function verificarPermisoSoloLectura(){
            $.ajax({
                type: 'POST',
                url: 'php/permisos_botones_alarmas_buscar.php', 
                data:{
                    'idUsuario' : idUsuario,
                    'boton':'SOLO_CONSULTA',
                    'idBoton':0,
                    'idUnidadNegocio':idUnidadActual
                },
                success: function(data) {
                    
                    if(data==1)
                    {
                        $('#forma input,textarea,select').prop('disabled',true);
                        $('#b_cerrar_orden,#b_imprimir,#b_seguimiento_orden,#b_aceptar_cancelar,#b_guardar_cxc').prop('disabled',true);
                        $(document).find('.verificar_permiso').prop('disabled',true);
                        $(document).find('#t_justificacion').prop('disabled',true);
                        $('#forma_cxc input,select').prop('disabled',true);
                        $('#b_buscar_clientes').prop('disabled',true);

                        if(obtienePermisoBotonRegresar(idUsuario,idUnidadActual) == 1)
                            $('#b_regresar').prop('disabled',false);
                        else
                            $('#b_regresar').prop('disabled',true);
                        
                    }else{
                        verificarPermisosAlarmas(idUsuario,idUnidadActual);
                    }

                },
                error: function (xhr) {
                    console.log("verificarPermisos: "+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al verificar permisos Alarmas');
                }
            });
        }

        //-->NJES May/22/2020 verifica los botones que tengan la clase verifica_permiso para ver si tienen permiso segun la forma indicada en el alt
        function obtienePermisoBotonRegresar(idUsuario,idUnidadActual){
            var permiso = 0;

            $.ajax({
                type: 'POST',
                url: 'php/permisos_botones_alarmas_buscar.php', 
                data:{
                    'idUsuario' : idUsuario,
                    'boton':'ORDEN_SERVICIO',
                    'idBoton':0,
                    'idUnidadNegocio':idUnidadActual
                },
                async : false,
                success: function(data) {
                    
                //-->si data es 1 si tiene permiso
                permiso = data;

                },
                error: function (xhr) {
                    console.log("php/permisos_botones_alarmas_buscar.php --> "+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al verificar permisos boton regresar a ordenes servicio');
                }
            });

            return permiso;
        }

        //-->NJES Jan/27/2020 se agrega boton para abrir todas las opciones del accordion 
        $('#b_expandir').click(function(){
            $('.collapse').addClass('show');
        });

        //-->NJES October/20/2020 se agrega filtro sucursal
        $('#s_id_sucursales_filtro').change(function(){
            buscarMas48H();
            buscarUnaSemana();
            buscarMenosSemana();
            verificarPermisoSoloLectura();
            sinAtender();
        });

        //--> NJES Jan/27/2020 Agregar funcion para mostrar las ordenes de servicio que tienen mas de una semana sin atender
        function sinAtender(){
            $('#t_sin_atender tbody').empty(); 

            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);

            $.ajax({
                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_buscar.php',
                dataType:"json", 
                data:{
                    'semana':'sin_atender',
                    'idSucursal': idSucursal
                },
                success: function(data) {

                    if(data.length != 0){

                        $('#t_sin_atender tbody').empty(); 
                       
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_sin_atender ' + data[i].estatus+ '" alt="'+data[i].id+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha_servicio+ '</td>\
                                        <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                        <td data-label="Tipo Servicio">' + data[i].tipo_servicio+ '</td>\
                                        <td data-label="Prioridad">' + data[i].prioridad+ '</td>\
                                        <td data-label="Capturó">' + data[i].usuario+'-'+data[i].nombre+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_sin_atender tbody').append(html);   
                             
                        }
                   }else{
                        var html='<tr><td colspan="8">No se encontró información sin atender por más de una semana</td></tr>';
                        ///agrega la tabla creada al div 
                        $('#t_sin_atender tbody').append(html);  
                   }

                },
                error: function (xhr) {
                    console.log('sinAtender() -- php/servicios_ordenes_buscar_una_semana.php--->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información sin atender por más de una semana');
                }
            });
        }

        $('#t_sin_atender').on('click', '.renglon_sin_atender', function() {
            idOrdenServicio = $(this).attr('alt');
            muestraRegistro();
        });

        function buscarMas48H(){
            $('#t_mas_48h tbody').empty(); 

            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);

            $.ajax({

                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_buscar.php',
                dataType:"json", 
                data:{
                    'semana':'mas48H',
                    'idSucursal':idSucursal
                },
                success: function(data) {

                    if(data.length != 0){

                        $('#t_mas_48h tbody').empty(); 
                       
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_mas48h ' + data[i].estatus+ '" alt="'+data[i].id+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha_servicio+ '</td>\
                                        <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                        <td data-label="Tipo Servicio">' + data[i].tipo_servicio+ '</td>\
                                        <td data-label="Prioridad">' + data[i].prioridad+ '</td>\
                                        <td data-label="Capturó">' + data[i].usuario+'-'+data[i].nombre+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_mas_48h tbody').append(html);   
                             
                        }
                   }else{
                    var html='<tr><td colspan="8">No se encontró información de mas de 48 horas</td></tr>';
                            ///agrega la tabla creada al div 
                            $('#t_mas_48h tbody').append(html);  
                       // mandarMensaje('No se encontró información de mas de una semana');
                   }

                },
                error: function (xhr) {
                    console.log('buscarMas48H() -- php/servicios_ordenes_buscar_una_semana.php--->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#t_mas_48h').on('click', '.renglon_mas48h', function() {
           idOrdenServicio = $(this).attr('alt');
           muestraRegistro();

        });
        
        function buscarUnaSemana(){
            $('#t_mas_una_semana tbody').empty();  
            
            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);

            $.ajax({

                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_buscar.php',
                dataType:"json", 
                data:{
                    'semana':'mas',
                    'idSucursal' : idSucursal
                },
                success: function(data) {

                    if(data.length != 0){

                        $('#t_mas_una_semana tbody').empty();  
                       
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_una_semana ' + data[i].estatus+ '" alt="'+data[i].id+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha_servicio+ '</td>\
                                        <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                        <td data-label="Tipo Servicio">' + data[i].tipo_servicio+ '</td>\
                                        <td data-label="Prioridad">' + data[i].prioridad+ '</td>\
                                        <td data-label="Capturó">' + data[i].usuario+'-'+data[i].nombre+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_mas_una_semana tbody').append(html);   
                             
                        }
                   }else{
                        $('#t_mas_una_semana tbody').empty();  
                        var html='<tr><td colspan="8">No se encontró información de mas de una semana</td></tr>';
                        $('#t_mas_una_semana tbody').append(html);  
                        //mandarMensaje('No se encontró información de mas de una semana');
                   }

                },
                error: function (xhr) {
                    console.log('buscarUnaSemana() -- php/servicios_ordenes_buscar_una_semana.php--->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#t_mas_una_semana').on('click', '.renglon_una_semana', function() {
           idOrdenServicio = $(this).attr('alt');
           muestraRegistro();

        });



        function buscarMenosSemana(){
            $('#t_menos_una_semana tbody').empty();  

            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);

            $.ajax({

                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_buscar.php',
                dataType:"json", 
                data:{
                    'semana':'menos',
                    'idSucursal':idSucursal
                },
                success: function(data) {

                    if(data.length != 0){

                        $('#t_menos_una_semana tbody').empty(); 
                       
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_menos_una_semana ' + data[i].estatus+ '" alt="'+data[i].id+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha_servicio+ '</td>\
                                        <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                        <td data-label="Tipo Servicio">' + data[i].tipo_servicio+ '</td>\
                                        <td data-label="Prioridad">' + data[i].prioridad+ '</td>\
                                        <td data-label="Capturó">' + data[i].usuario+'-'+data[i].nombre+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_menos_una_semana tbody').append(html);   
                             
                        }
                   }else{
                        $('#t_menos_una_semana tbody').empty(); 
                        var html='<tr><td colspan="8">No se encontró información de menos de una semana</td></tr>';
                        $('#t_menos_una_semana tbody').append(html); 
                        //mandarMensaje('No se encontró información de menos de una semana');
                   }

                },
                error: function (xhr) {
                    console.log('buscarMenosSemana() -- php/servicios_ordenes_seguimiento_buscar.php--->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#t_menos_una_semana').on('click', '.renglon_menos_una_semana', function() {
           idOrdenServicio = $(this).attr('alt');

           muestraRegistro();

        });

        function muestraRegistro(){ 
            $('#l_tecnico').removeClass('requerido');
            $('#i_tecnico').removeClass('validate[required]').validationEngine('hide');
            verificarPermisosAlarmas(idUsuario,idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            muestraSelectReporta('s_reporta','general');
            muestraSelectPrioridad('s_prioridad');
            muestraSelectClasificacionServicios('s_clasificacion_servicios');
          
          
            $.ajax({
                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_buscar_id.php',
                dataType:"json", 
                data:{
                    'idOrdenServicio':idOrdenServicio
                },
                success: function(data) {
                   
                    idOrdenServicio=data[0].id;

                    $('#b_imprimir').attr('alt1',data[0].id);
                    $('#b_cerrar_orden').attr('alt1',data[0].id).attr('alt2',data[0].id_cxc).attr('alt3',data[0].sin_cobro).attr('alt4',data[0].fecha_atencion).attr('alt5',data[0].correos);
                    $('#b_aceptar_cancelar').attr('alt1',data[0].id);
                    $('#b_seguimiento_orden').attr('alt1',data[0].id);
                    $('#b_cobrar').attr('alt1',data[0].id).attr('alt2',data[0].cantidad).attr('alt3',data[0].id_cxc).attr('alt4',data[0].porcentaje_iva).attr('alt5',data[0].sin_cobro).attr('alt6',data[0].concepto_cobro).attr('id_factura',data[0].id_factura);
                    
                    $('#b_cancelar_orden').attr('alt',data[0].id_factura);
                   
                    if(parseInt(data[0].estatus_cierre)==1)
                    {
                        $('#b_imprimir').prop('disabled', true);
                        $('#b_cerrar_orden').prop('disabled',true);
                    }
                    else
                        $('#b_imprimir').prop('disabled',false);

                    $('#t_justificacion').val('').prop('disabled',false);
                    $('#d_estatus').removeAttr('class').text('');
             
                    if(data[0].estatus_orden=='P'){
                        $('#d_estatus').addClass('alert alert-sm alert-warning').text('PENDIENTE');
                        $('#b_seguimiento_orden').prop('disabled','true');
                    }
                    if(data[0].estatus_orden=='C'){
                        $('#t_justificacion').val(data[0].justificacion_cancelacion).prop('disabled',true);
                        $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
                        $('#b_aceptar_cancelar').prop('disabled',true); 
                        $('#b_seguimiento_orden').prop('disabled','true');
                    }

                    $('#i_fecha_solicitud').val(data[0].fecha_solicitud);
                    $('#i_cliente').val(data[0].cliente).attr('alt',data[0].id_servicio).attr('correos',data[0].correos);
                    $('#i_servicio').val(data[0].servicio);
                    $('#ta_descripcion').val(data[0].descripcion);
                    $('#ta_proceso').val(data[0].proceso);
                    $('#ta_acciones_realizadas').val(data[0].acciones_realizadas);
                  
                    if(data[0].id_sucursal != 0)
                    {
                        $('#s_id_sucursales').val(data[0].id_sucursal).prop('disabled',true);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_sucursales').val('').prop('disabled',true);
                        $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
                    }
                    
                    if(data[0].reporta != 0)
                    {
                        $('#s_reporta').val(data[0].reporta).prop('disabled',true);
                        $('#s_reporta').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_reporta').val('').prop('disabled',true);
                        $('#s_reporta').select2({placeholder: 'Selecciona'});
                    }
                    if(data[0].prioridad != 0)
                    {
                        $('#s_prioridad').val(data[0].prioridad).prop('disabled',true);
                        $('#s_prioridad').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_prioridad').val('').prop('disabled',true);
                        $('#s_prioridad').select2({placeholder: 'Selecciona'});
                    }
                    if(data[0].id_clasificacion_servicio != 0)
                    {
                        $('#s_clasificacion_servicios').val(data[0].id_clasificacion_servicio).prop('disabled',true);
                        $('#s_clasificacion_servicios').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_clasificacion_servicios').val('').prop('disabled',true);
                        $('#s_clasificacion_servicios').select2({placeholder: 'Selecciona'});
                    }

                    $('#i_tecnico').attr('alt',data[0].id_tecnico).val(data[0].tecnico);

                    $('#dialog_seguimiento').modal('show');
                    
                },
                error: function (xhr) {
                    console.log('php/servicios_ordenes_seguimiento_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
      }

    //---- IMPRIMIR --------------------------------------------  

      $('#b_imprimir').on('click',function(){
          var idOrdenServicio = $(this).attr('alt1');
          generaFormato(idOrdenServicio);
      });

    function generaFormato(idRegistro){
        var tipo = 1;

        var datos = {
            'path':'formato_ordenes_servicio',
            'idRegistro':idRegistro,
            'nombreArchivo':'orden_servicio',
            'tipo':tipo
        };

        let objJsonStr = JSON.stringify(datos);
        let datosJ = datosUrl(objJsonStr);

        window.open("php/convierte_pdf.php?D="+datosJ,'_new')
    }

    //---CERRAR---------------------------------------

    //--- mgfs 20-01-2020 se agrega la fecha de atencion al momento de generar el cierre
    $('#b_cerrar_orden').on('click',function(){

        $('#b_cerrar_orden').prop('disabled',true);

        $('#l_tecnico').addClass('requerido');
        $('#i_tecnico').addClass('validate[required]');
        var idOrdenServicio = $(this).attr('alt1');
        var fechaAtencion = $(this).attr('alt4');
        var correos = $(this).attr('alt5');

       
            if ($('#forma').validationEngine('validate')){

                if(correos==''){

                    $('#dialog_correos').modal('show');

                }else{

                    $('#fecha_atencion').val('');
                    $('#fecha_atencion').val(fechaAtencion);
                    $('#dialog_fecha_atencion').modal('show');
                    $('#i_fecha_atencion').datepicker({
                        format : "yyyy-mm-dd",
                        autoclose: true,
                        language: "es",
                        todayHighlight: true
                    });
                }
            }else{
                $('#b_cerrar_orden').prop('disabled',false);
            }
        


    });

    $(document).on('click','#b_guardar_correos',function(){

        if ($('#form_correos').validationEngine('validate')){
           
            $.ajax({
                type: 'POST',
                url: 'php/servicios_actualizar_correos.php', 
                dataType:"json", 
                
                data:{
                       'idServicio':$('#i_cliente').attr('alt'),
                       'correos': $('#i_correos').val()
                    },
                //una vez finalizado correctamente
                success: function(data){
                    console.log(data);
                    if (data > 0 ) {
                        $('#dialog_correos').modal('hide');
                       
                        var idOrdenServicio = $('#b_cerrar_orden').attr('alt1');
                        var fechaAtencion = $('#b_cerrar_orden').attr('alt4');
                        var correos = $('#b_cerrar_orden').attr('alt5');
                        $('#b_cerrar_orden').prop('disabled',true);

                        $('#fecha_atencion').val('');
                        $('#fecha_atencion').val(fechaAtencion);
                        $('#dialog_fecha_atencion').modal('show');
                        $('#i_fecha_atencion').datepicker({
                            format : "yyyy-mm-dd",
                            autoclose: true,
                            language: "es",
                            todayHighlight: true
                        });
                        
                    }else{

                        mandarMensaje('Ocurrio un error al guardar el correo del cliente');
                        $('#b_cerrar_orden').prop('disabled',false);
                    }
                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/servicios_ordenes_seguimiento_correos.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al guardar los correos del cliente');
                    $('#b_cerrar_orden').prop('disabled',false);
                }
            });
        }else{
            $('#b_cerrar_orden').prop('disabled',false);
        }  
    });

    $(document).on('click','#b_guardar_fecha_atencion',function(){
        
        var idOrdenServicio = $('#b_cerrar_orden').attr('alt1');

        if ($('#form_fecha_a').validationEngine('validate')){
           
            $.ajax({
                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_fecha_atencion.php', 
                dataType:"json", 
                
                data:{
                       'idOrdenServicio':idOrdenServicio,
                       'fechaAtencion': $('#i_fecha_atencion').val()
                    },
                //una vez finalizado correctamente
                success: function(data){
                    console.log(data);
                    if (data > 0 ) {

                        $('#b_cerrar_orden').attr('alt4',$('#i_fecha_atencion').val());
                        $('#dialog_fecha_atencion').modal('hide');
                        guardaCierre();

                    }else{

                        mandarMensaje('Ocurrio un error al guardar la fecha de atención');
                        $('#b_cerrar_orden').prop('disabled',false);
                    }
                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/servicios_ordenes_seguimiento_fecha_atencion.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al guardar la fecha de atención');
                    $('#b_cerrar_orden').prop('disabled',false);
                }
            });
        }else{
            $('#b_cerrar_orden').prop('disabled',false);
        }  
    });    

    
        
    
     function guardaCierre(){

        var idOrdenServicio = $('#b_cerrar_orden').attr('alt1');
        var idCXC = $('#b_cerrar_orden').attr('alt2');
        var sinCobrar = $('#b_cerrar_orden').attr('alt3');
      
        if(parseInt(idCXC)>0 || parseInt(sinCobrar)>0){
        
            if ($('#forma').validationEngine('validate')){

            
                $.ajax({
                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_cierre.php', 
                dataType:"json", 
                
                data: {

                        'idOrdenServicio':idOrdenServicio,
                        'idSucursal':$('#s_id_sucursales').val(),
                        'servicio':$('#ta_descripcion').val(),
                        'proceso':$('#ta_proceso').val(),
                        'accionesRealizadas':$('#ta_acciones_realizadas').val(),
                        'correos':$('#i_cliente').attr('correos'),
                        'idTecnico':$('#i_tecnico').attr('alt'),
                        'tecnico':$('#i_tecnico').val()
                },
                //una vez finalizado correctamente
                success: function(data){
                    console.log(data);
                    if (data > 0 ) {
                        
                        mandarMensaje('La orden de servicio se cerró correctamente');

                      
                        buscarMas48H();
                        buscarUnaSemana();
                        buscarMenosSemana();
                        verificarPermisoSoloLectura();
                        //--> NJES Jan/27/2020 Agregar funcion para mostrar las ordenes de servicio que tienen mas de una semana sin atender
                        sinAtender();
    

                    }else{
                            
                        mandarMensaje('Error al cerrar la orden de servicio (1)');
                        $('#b_cerrar_orden').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                    error: function(xhr){
                    console.log('php/servicios_ordenes_seguimiento_guardar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* Error al cerrar la orden de servicio (2)');
                    $('#b_cerrar_orden').prop('disabled',false);
                }
            });

            }else{
            
                $('#b_cerrar_orden').prop('disabled',false);
            }
        }else{
            mandarMensaje('Por favor ponerse en contracto con Finanzas ya que no se a definido el cobro de esta orden');
            $('#b_cerrar_orden').prop('disabled',false);
        }    
    
     }
    
     $("#dialog_seguimiento").on('hidden.bs.modal', function () {
        buscarMas48H();
        buscarUnaSemana();
        buscarMenosSemana();
        verificarPermisoSoloLectura();
    });

      //----COBRAR--------------------------------------------------------

      $('#b_cobrar').on('click',function(){
        var idOrdenServicio = $(this).attr('alt1');
        var cantidad = $(this).attr('alt2');
        var idCXC = $(this).attr('alt3');
        var porcentajeIva = $(this).attr('alt4');
        var sinCobro = $(this).attr('alt5');
        var concepto_cobro = $(this).attr('alt6');
   
        $('#ch_facturar').prop('checked',false).prop('disabled',false);
        $('#ch_sin_cobro').prop('checked',false).prop('disabled',false);
       
        $('#dialog_cancelar').modal('hide');
        $('#dialog_cobrar').modal('show');
        
        if(parseInt(sinCobro)==1)
            $('#ch_sin_cobro').prop('checked',true);
        else
            $('#ch_sin_cobro').prop('checked',false);


        muestraConceptosCxP('s_concepto',7);
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        //-->NJES March/30/2020 se envia parametro uno para que no muestre las caja chica
        muestraCuentasBancosUnidad('s_cuenta_banco', 0,1,idUnidadActual);
        generaFecha('s_mes');

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha').val(hoy);
        $('#i_anio').val(anio);
        $('#i_referencia').val(idOrdenServicio);
        $('#i_importe').val(formatearNumero(cantidad));
        //-->NJES March/18/2020 se agrega concepto cobro
        $('#i_concepto_cobro').val(concepto_cobro);
        
        
        if( parseInt(idCXC) > 0 ){
            muestraRegistroCxC(idCXC);
            $('#b_guardar_cxc').prop('disabled',true);
            $('#forma_cxc').find('input,select').prop('disabled',true);
        }else{
            $('input[name=radio_iva]').prop('checked',false);   
                    
            if(parseInt(porcentajeIva) == 16){

                var importe = cantidad;
                var tasa_iva =16;
                var total_iva=0;

                if(parseInt(tasa_iva) > 0){
                    total_iva = parseFloat(importe) * (parseInt(tasa_iva)/100);
                }

                var total = importe + total_iva;

                $('#i_total_iva').val(formatearNumero(total_iva));
                $('#i_total').val(formatearNumero(total));

               
                $('#r_16').prop('checked',true);

            }else if(porcentajeIva == 8){
                
                var importe = cantidad;
                var tasa_iva =8;
                var total_iva=0;
                
                if(parseInt(tasa_iva) > 0){
                    total_iva = parseFloat(importe) * (parseInt(tasa_iva)/100);
                }

                var total = importe + total_iva;

                $('#i_total_iva').val(formatearNumero(total_iva));
                $('#i_total').val(formatearNumero(total));

                $('#r_8').prop('checked',true);
            }

            if($('#ch_sin_cobro').is(':checked')){
                //$('#b_guardar_cxc').prop('disabled',true);
                $('#b_guardar_cxc').attr({'id_registro':idOrdenServicio,'editar':'si'});
                $('#forma_cxc').find('input,select').prop('disabled',true);
            }else{
                $('#b_guardar_cxc').prop('disabled',false).attr({'id_registro':idOrdenServicio,'editar':'no'});
                $('#forma_cxc').find('input,select').prop('disabled',false);
            }

            $('#ch_sin_cobro,#ch_facturar').prop('disabled',false);

            verificarPermisoSoloLectura(); 
        }

        
      });

        $('input[name=radio_iva]').on('change',function(){

            var importe = quitaComa($('#i_importe').val());
            var tasa_iva = $('input[name=radio_iva]:checked').val();
            var total_iva=0;


            if(parseInt(tasa_iva) > 0){
                total_iva = parseFloat(importe) * (parseInt(tasa_iva)/100);
            }else{
                total_iva = 0;
            }

            var total = importe + total_iva;
            $('#i_total_iva').val(formatearNumero(total_iva));
            $('#i_total').val(formatearNumero(total));

        });

        $('#i_importe').on('change',function(){

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

        $('#ch_sin_cobro').click(function(){
            if($(this).is(':checked'))
            {
                $('#ch_facturar').prop('checked',false);
                $('#forma_cxc').find('input,select').prop('disabled',true);
            }else{
                $('#forma_cxc').find('input,select').prop('disabled',false);
                $('#ch_sin_cobro,#ch_facturar').prop('disabled',false);
            }
        });

        $('#ch_facturar').click(function(){
            if($(this).is(':checked'))
            {
                $('#ch_sin_cobro').prop('checked',false);
                $('#forma_cxc').find('input,select').prop('disabled',false);
            }

            //-->Si la orden genero un cobro de cxc no podra seleccionar la opcion sin cobrar
            //pero si se habia guardado la orden con sin cobrar si puede cambiar a que se descheck y se generará un cxc
            if($('#b_cobrar').attr('alt3') > 0)
                $('#ch_sin_cobro').prop('disabled',true);
            else
                $('#ch_sin_cobro').prop('disabled',false);
        });

        $('#b_guardar_cxc').click(function(){

            $('#b_guardar_cxc').prop('disabled',true);

            //--- si el check de sin cobrar esta checkeado solo se guarada el sin cobrara en la tav¿bal orden servicio
            //--- si no se genera su
            if($('#ch_sin_cobro').is(':checked')){
                $('#b_cerrar_orden').attr('alt3',1);
                    
                $.ajax({
                    type: 'POST',
                    url: 'php/servicios_ordenes_seguimiento_sin_cobro.php', 
                    dataType:"json", 
                    
                    data: {

                            'idOrdenServicio':idOrdenServicio,
                            'idSucursal':$('#s_id_sucursales').val(),
                            'servicio':$('#ta_descripcion').val(),
                            'proceso':$('#ta_proceso').val(),
                            'accionesRealizadas':$('#ta_acciones_realizadas').val(),
                            'correos':$('#i_cliente').attr('correos'),
                            'sinCobro' : $('#ch_sin_cobro').is(':checked')?1:0
                    },
                    //una vez finalizado correctamente
                    success: function(data){
                        console.log(data);
                        if (data > 0 ) {
                            
                            mandarMensaje('La orden de servicio se marco como Pendiente correctamente');
                            $('#b_guardar_cxc').prop('disabled',false);
                        }else{
                                
                            mandarMensaje('Error la guardar el seguimiento');
                            $('#b_guardar_cxc').prop('disabled',false);
                        }

                    },
                    //si ha ocurrido un error
                    error: function(xhr){
                        console.log('php/servicios_ordenes_seguimiento_seguimiento.php -->'+JSON.stringify(xhr));
                        mandarMensaje('* Error la guardar el seguimiento');
                        $('#b_guardar_cxc').prop('disabled',false);
                    }
                });

                
            }else{
                
                var registro = $('#b_guardar_cxc').attr('id_registro');

                if($('#forma_cxc').validationEngine('validate'))
                {
                    if($('#b_guardar_cxc').attr('editar') == 'no')
                        guardar('guardar',0);
                    else{
                        //--> es una edición y en el alt5 del boton cobro nos indica si la orden se abia cobrado como sin cobrar o no
                        // 0 quiere decir que no se habia clasificado como sin cobrar, osea que se va a editar un cxc
                        if($('#b_cobrar').attr('alt5') == 0)
                            guardar('editar',registro);
                        else{
                            //-->Si es una edicion y anteriormente se habia guardado con la opcion de sin cobro
                            //primero se debera actualizar la orden a sin_cobro = 0
                            //despues se debe generar el cxc
                            $.ajax({
                                type: 'POST',
                                url: 'php/servicios_ordenes_seguimiento_sin_cobro.php', 
                                dataType:"json", 
                                
                                data: {

                                        'idOrdenServicio':idOrdenServicio,
                                        'idSucursal':$('#s_id_sucursales').val(),
                                        'servicio':$('#ta_descripcion').val(),
                                        'proceso':'',
                                        'accionesRealizadas':'',
                                        'correos':'',
                                        'sinCobro' : 0
                                },
                                //una vez finalizado correctamente
                                success: function(data){
                                    if (data > 0 ) {
                                        guardar('guardar',0);
                                    }else{ 
                                        mandarMensaje('Error la guardar');
                                        $('#b_guardar_cxc').prop('disabled',false);
                                    }

                                },
                                //si ha ocurrido un error
                                error: function(xhr){
                                    console.log('php/servicios_ordenes_seguimiento_seguimiento.php -->'+JSON.stringify(xhr));
                                    mandarMensaje('* Error la guardar el seguimiento');
                                    $('#b_guardar_cxc').prop('disabled',false);
                                }
                            });
                        }
                    }
                    
                }else{
                    $('#b_guardar_cxc').prop('disabled',false);
                }
            }
            
        });    

    function guardar(tipo,registro){

        var info = {
            'idOrdenServicio':idOrdenServicio,
            'idUnidadNegocio' : idUnidadActual,
            'idSucursal' : $('#s_id_sucursales').val(),
            'idRazonSocialReceptor' :0,
            'idRazonSocialServicio' : $('#i_cliente').attr('alt'),
            'tasaIva' : $('input[name=radio_iva]:checked').val(),

            'facturar' : $('#ch_facturar').is(':checked')?1:0,

            'idBanco' : $('#s_cuenta_banco option:selected').attr('alt'),
            'idCuentaBanco' : $('#s_cuenta_banco').val(),
            'vencimiento' : $('#i_vencimiento').val(),
            'mes' : $('#s_mes').val(),
            'anio' : $('#i_anio').val(),
            
        
            'fecha' : $('#i_fecha').val(),
            'idConcepto' : $('#s_concepto option:selected').val(),
            'cveConcepto' : $('#s_concepto option:selected').attr('alt'),
            'importe' : quitaComa($('#i_importe').val()),
            'totalIva' : quitaComa($('#i_total_iva').val()),
            'total' : quitaComa($('#i_total').val()),
            'referencia' : $('#i_referencia').val(),

            'cargoInicial': 1,
            'idUsuario' : idUsuario,
            'estatus' : 'A',//--MGFS 20-02-2020 SE AGREGA ESTATUS A EN ÑLUGAR DE P PARA QUE SE MUESTREN EN FACTURACION DESDE SU COBRO
            'conceptoCobro' : $('#i_concepto_cobro').val(),
            //-->NJES March/18/2020 se agrega concepto cobro
            //-->NJES July/02/2020 se envia parametro id cxc para poder editar el cobro de la orden
            'idCxC' : registro
        };

        if(tipo == 'guardar')
            var url = 'php/cxc_guardar.php';
        else
            var url = 'php/cxc_editar.php';
        console.log(url);
        $.ajax({
            type: 'POST',
            url: url,
            data:  {'datos':info},
            success: function(data) {
            console.log('data: '+data);
                if(data > 0 )
                { 
                   
                    idCxC = data;
                    $('#b_cobrar').attr('alt3',data);
                    $('#b_cerrar_orden').attr('alt2',data);
                    
                    if(tipo == 'guardar')
                        mandarMensaje('El cobro de la Orden de Servicio :'+idOrdenServicio+' se generó correctamente');
                    else
                        mandarMensaje('El cobro de la Orden de Servicio :'+idOrdenServicio+' se actualizó correctamente');

                    muestraRegistroCxC(idCxC);
                    $('#b_guardar_cxc').prop('disabled',true);
                
                }else{ 
                    mandarMensaje('Error al guardar.');
                    $('#b_guardar_cxc').prop('disabled',false);
                }
            },
            error: function (xhr) 
            {
                console.log('php/cxc_guardar.php --> '+JSON.stringify(xhr));
                mandarMensaje('* Error al guardar.');
                $('#b_guardar_cxc').prop('disabled',false);
            }
        });
    }

    function muestraRegistroCxC(id){
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        //-->NJES March/30/2020 se envia parametro uno para que no muestre las caja chica
        muestraCuentasBancosUnidad('s_cuenta_banco', 0,1,idUnidadActual);
        muestraConceptosCxP('s_concepto',7);
           
           $.ajax({
               type: 'POST',
               url: 'php/cxc_buscar_registro_id.php',
               dataType:"json", 
               data : {'tipo':'CXC',
                       'id':id
               },
               success: function(data) {
                  
                   if(parseInt(data.length) >0){                    
                       var dato = data[0];

                        $('#i_anio').val(dato.anio);
                        
                        $('#i_vencimiento').val(dato.vencimiento);

                        $('#s_cuenta_banco').val(dato.id_cuenta_banco);
                        $('#s_cuenta_banco').select2({placeholder: $(this).data('elemento')});
                        
                        $('#s_mes').val(dato.mes);
                        $('#s_mes').select2({placeholder: $(this).data('elemento')});
                    

                        if(parseInt(dato.porcentaje_iva) == 16)
                            $('#r_16').prop('checked',true);
                        else if(dato.porcentaje_iva == 8)
                            $('#r_8').prop('checked',true);
                        else
                            $('#r_0').prop('checked',true);

                        $('input[name=radio_iva]');    
                        
                        $('#s_concepto').val(dato.id_concepto);
                        $('#s_concepto').select2({placeholder: $(this).data('elemento')});    

                        $('#i_referencia').val(dato.referencia);
                        
                        
                        $('#i_importe').val(formatearNumero(dato.subtotal));
                        $('#i_total_iva').val(formatearNumero(dato.iva));
                        $('#i_total').val(formatearNumero(dato.total));

                        $('#b_cancelar_orden').prop('alt',dato.id_factura);
                        
                        
                        if(parseInt(dato.facturar)==1)
                        {
                            $('#ch_facturar').prop('checked',true);
                        }else
                            $('#ch_facturar').prop('checked',false);

                        //-->Si tiene abonos o una factura relacionada al cxc no podra editar el cobro
                        if(data[0].abonos > 0 || $('#b_cobrar').attr('id_factura') > 0)
                        {
                            $('#b_guardar_cxc').prop('disabled',true).attr('editar','no');
                            $('#forma_cxc').find('input,select').prop('disabled',true);
                        }else{
                            $('#b_guardar_cxc').prop('disabled',false).attr({'id_registro':id,'editar':'si'});
                            $('#forma_cxc').find('input,select').prop('disabled',false);
                            $('#ch_facturar').prop('disabled',false);
                        }

                        $('#ch_sin_cobro').prop('disabled',true);
                     
                    }else{
                        mandarMensaje('No se encontro Información del registro');
                    }
               },
               error: function (xhr) {
                   console.log('php/cxc_busca_registro_id.php --> '+JSON.stringify(xhr));
                   mandarMensaje('* No se encontró información al buscar el registro.');
               }
           });
    
       }

       $('#b_regresar').on('click',function(){
            
            window.open("fr_servicios_ordenes.php?regresarS=1","_self");
        });

         //---CANCELAR ---------------------------------------
        $('#b_cancelar_orden').on('click',function(){
            var idFactura= $(this).attr('alt');
            if(parseInt(idFactura)>0){
                mandarMensaje('No puedes cancelar esta orden de servicio ya que tiene una facura o prefactura, debes cancelar primero la factura o prefactura correspondiente');
            }else{
                $('#dialog_cobrar').modal('hide');
                $('#dialog_cancelar').modal('show');
            }
        });

        $('#b_aceptar_cancelar').on('click',function(){

            var idOrdenServicio = $(this).attr('alt1');
            $('#b_aceptar_cancelar').prop('disabled',true);

            if ($('#form_cancelacion').validationEngine('validate')){

                $.ajax({
                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_cancelar.php', 
                dataType:"json", 
                
                data: {

                        'idOrdenServicio':idOrdenServicio,
                        'idSucursal':$('#s_id_sucursales').val(),
                        'servicio':$('#ta_descripcion').val(),
                        'proceso':$('#ta_proceso').val(),
                        'accionesRealizadas':$('#ta_acciones_realizadas').val(),
                        'correos':$('#i_cliente').attr('correos'),
                        'justificacion' : $('#t_justificacion').val()
                },
                //una vez finalizado correctamente
                success: function(data){
                    console.log(data);
                    if (data > 0 ) {
                        
                        mandarMensaje('La orden de servicio se canceló correctamente');
                        limpiar();
    

                    }else{
                            
                        mandarMensaje('Error al cancelar la orden de servicio');
                        $('#b_aceptar_cancelar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                    error: function(xhr){
                    console.log('php/servicios_ordenes_seguimiento_cancelar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* Error al cerrar la orden de servicio (4)');
                    $('#b_aceptar_cancelar').prop('disabled',false);
                }
            });

            }else{
            
                $('#b_cerrar_orden').prop('disabled',false);
            }

        });


    //---SEGUIMIENTO---------------------------------------

    $('#b_seguimiento_orden').on('click',function(){

        var idOrdenServicio = $(this).attr('alt1');
        $('#l_tecnico').removeClass('requerido');
        $('#i_tecnico').removeClass('validate[required]').validationEngine('hide');
        $('#b_seguimiento_orden').prop('disabled',true);

        if ($(document).find('#forma').validationEngine('validate')){
        
            $.ajax({
            type: 'POST',
            url: 'php/servicios_ordenes_seguimiento_seguimiento.php', 
            dataType:"json", 
            
            data: {

                    'idOrdenServicio':idOrdenServicio,
                    'idSucursal':$('#s_id_sucursales').val(),
                    'servicio':$('#ta_descripcion').val(),
                    'proceso':$('#ta_proceso').val(),
                    'accionesRealizadas':$('#ta_acciones_realizadas').val(),
                    'correos':$('#i_cliente').attr('correos'),
                    'idTecnico':$('#i_tecnico').attr('alt'),
                    'tecnico':$('#i_tecnico').val()
            },
            //una vez finalizado correctamente
            success: function(data){
           
                if (data > 0 ) {
                    
                    mandarMensaje('La orden de servicio se marco como Pendiente correctamente');
                    limpiar();

                }else{
                        
                    mandarMensaje('Error la guardar el seguimiento');
                    $('#b_seguimiento_orden').prop('disabled',false);
                }

            },
                //si ha ocurrido un error
                error: function(xhr){
                console.log('php/servicios_ordenes_seguimiento_seguimiento.php -->'+JSON.stringify(xhr));
                mandarMensaje('* Error al cerrar la orden de servicio (3)');
                $('#b_seguimiento_orden').prop('disabled',false);
            }
        });

        }else{

            $('#b_seguimiento_orden').prop('disabled',false);
        }

    });

        /***SE AGREGA EL CAMPO DE TECNICO OBLIGATORIO PARA CERRAR UNA ORDEN */ 
        $('#b_buscar_tecnico').on('click',function(){
            $('#i_filtro').val('');
        
            $('.renglon_empleados').remove();
    
            $.ajax({

                type: 'POST',
                url: 'php/empleados_buscar_idUnidad.php',
                dataType:"json", 
                data:{
                    'idUnidadNegocio':idUnidadActual
                },

                success: function(data) {
  
                   if(data.length != 0 ){

                        $('.renglon_empleados').remove();
                   
                        for(var i=0;data.length>i;i++){

                            

                            var html='<tr class="renglon_empleados" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'">\
                                        <td data-label="usuario">' + data[i].id_trabajador+ '</td>\
                                        <td data-label="usuario">' + data[i].nombre+ '</td>\
                                         <td data-label="usuario">' + data[i].sucursal+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_empleados tbody').append(html);   
                            $('#dialog_buscar_empleados').modal('show'); 
                              
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/empleados_buscar_idUnidad.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        });

         

        $('#t_empleados').on('click', '.renglon_empleados', function() {
            
            var id = $(this).attr('alt');
            $('#i_tecnico').attr('alt', id);
            muestraEmpleado(id);

            $('#dialog_buscar_empleados').modal('hide');

        });

        function muestraEmpleado(idE){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/empleados_buscar_todos.php',
                dataType:"json", 
                data:{
                    'idEmpleado':idE
                },
                success: function(data) {

                    $('#i_tecnico').val(idE+' - '+data[0].nombre);
                    $('#i_tecnico').attr('alt', idE);

                },
                error: function (xhr) {
                    mandarMensaje(xhr.responseText);
                }
            });
        }  
        
        function limpiar(){
            location.reload();
        }


    });

</script>

</html>