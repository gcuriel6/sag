<?php session_start(); ?>
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
    <link href="vendor/switch.css" rel="stylesheet"/>
</head>

<style> 
    body{
        background-color:rgb(238,238,238);
    }
    #div_principal,
    #div_busqueda,
    #div_comprobar{
      position: absolute;
      top:0px;
      left : -101%;
      height: 100%;
      background-color: rgba(250,250,250,0.6);
      
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_montos_nomina{
        height:170px;
        overflow:auto;
    }
    #td_descripcion{
        width:30%;
    }
    #td_clave{
        width:10%;
    }

    .izquierda { 
        text-align: right; 
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

    #d_estatus{
       padding-top:7px;
       text-align:center;
       font-weight:bold;
       font-size:15px;
       height:40px;
       vertical-align:middle;
   }


    #div_t_registros{
        height:170px;
        overflow:auto;
    }
    
    #b_comprobante_pdf{
        display:none;
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
       
    }

    .input_num{
        text-align:right;
    }

    .Cancelada {
        color:#721C24;
    }
    .der{
        text-align:right;
    }
    
</style>

<body>
    <div><input id="i_id_familia_gasto" type="hidden"/></div>
    <div class="container-fluid" id="div_principal">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor"><br>
                
                <form class="form_viaticos" name="form_viaticos">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-2">
                            <div class="titulo_ban">Viáticos</div>
                        </div>
                        <div class="col-sm-1 col-md-1" id="div_comodato"></div>
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-eraser" aria-hidden="true"></i> Nuevo</button>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-primary btn-sm form-control" id="b_imprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                        </div>
                        <div class="col-sm-12 col-md-2" id="div_cancelar">
                            <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_SOLICITAR" id="b_solicitar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Solicitar</button>
                        </div>
                    </div> <br>
            
                    <div class="form-group row">
                        <label for="s_id_unidad" class="col-sm-2 col-md-2 col-form-label requerido">Unidad de Negocio </label>
                        <div class="col-sm-3 col-md-3">
                            <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                        <div class="col-sm-1 col-md-1"></div>
                        <label for="i_folio" class="col-1 col-md-1 col-form-label">Folio </label>
                        <div class="input-group col-sm-2 col-md-2">
                            <input type="text" id="i_folio" name="i_folio" class="form-control" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-warning btn-sm form-control" id="b_comprobar"><i class="fa fa-check-square" aria-hidden="true"></i> Comprobar</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="s_id_sucursal" class="col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                        <div class="col-sm-12 col-md-3">
                            <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                        <div class="col-sm-1 col-md-1"></div>
                        <label for="i_estatus" class="col-sm-1 col-md-1 col-form-label ">Estatus </label>
                        <div class="col-sm-4 col-md-4">
                            <div id="d_estatus" class="alert"></div>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="s_id_area" class="col-sm-2 col-md-2 col-form-label requerido">Área </label>
                        <div class="col-sm-3 col-md-3">
                            <select id="s_id_area" name="s_id_area" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                        <div class="col-sm-12 col-md-1"></div>
                        <label for="i_solicito" class="col-1 col-md-1 col-form-label requerido">Solicitó </label>
                        <div class="input-group col-sm-4 col-md-4">
                            <input type="text" id="i_solicito" name="i_solicito" class="form-control validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn" >
                                <button class="btn btn-primary" type="button" id="b_buscar_empleado_solicito" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row"> 
                        <label for="s_id_departamento" class="col-sm-2 col-md-2 col-form-label requerido">Departamento </label>
                        <div class="col-sm-3 col-md-3">
                            <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                        </div>
                        <div class="col-sm-1 col-md-1"></div>  
                        <label for="i_capturo" class="col-sm-1 col-md-1 col-form-label requerido">Capturó </label>
                        <div class="col-sm-4 col-md-4">
                        <input type="text" id="i_capturo" name="i_capturo" class="form-control form-control-sm validate[required]" readonly autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_destino" class="col-sm-2 col-md-2 col-form-label requerido">Destino</label>
                        <div class="col-sm-4 col-md-4">
                            <input type="text" id="i_destino" name="i_destino" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                        </div>
                        
                        <label for="i_distancia" class="col-sm-1 col-md-1 col-form-label requerido">Distancia </label>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" id="i_distancia" name="i_distancia" class="form-control form-control-sm validate[required,custom[number]]" autocomplete="off"/>
                        </div>
                        <div class="col-sm-1 col-md-1" style="text-align:left;">KM</div>
                    </div>
                    <div class="form-group row">
                        <label for="i_empleado" class="col-md-auto col-form-label requerido"> <input type="checkbox" name="ch_externo" id="ch_externo"> Externo Nombre </label>
                        <div class="input-group col-sm-5 col-md-5">
                            <input type="text" id="i_empleado" name="i_empleado" class="form-control validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn" id="b_empleado">
                                <button class="btn btn-primary" type="button" id="b_buscar_empleados" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-1 col-md-1" style="backgroud:#D4EDDA;" title="Ya que no habrá devoluciones, ni descuentos a nomina y el empleado cuenta con la información suficiente para comprobar sus gastos">   
                            <input name="ch_reposicion_gasto" id="ch_reposicion_gasto"  type="checkbox" data-toggle="toggle" data-onstyle="success">
                        </div>
                        <label for="ch_reposicion_gasto"  class="col-sm-3 col-md-3 col-form-label" style="background:#F8D7DA;color:#721C24;border-radius:4px;text-align:center;font-weight:bold;">REPOSICIÓN DE GASTOS</label>
                    </div>
                    <div class="form-group row">
                    <label for="ta_motivos" class="col-sm-2 col-md-2 col-form-label">Motivos del Viaje</label>
                        <div class="col-sm-10 col-md-10">
                            <textarea class="form-control" name="ta_motivos" id="ta_motivos" rows="1" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">    
                        <label for="i_fecha_inicio" class="col-sm-2 col-md-2 col-form-label requerido">Del </label>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" id="i_fecha_inicio" name="i_fecha_inicio" class="form-control fecha validate[required]" readonly autocomplete="off"/>
                        </div>
                        <label for="i_fecha_fin" class="col-sm-1 col-md-1 col-form-label requerido">Al </label>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" id="i_fecha_fin" name="i_fecha_fin" class="form-control fecha validate[required]" readonly autocomplete="off"/>
                        </div>
                        <div class="col-sm-1 col-md-1"></div>
                        <label for="i_dias" class="col-sm-1 col-md-1 col-form-label requerido">Dias </label>
                        <div class="col-sm-1 col-md-1">
                            <input type="text" id="i_dias" name="i_dias" class="form-control validate[required]" readonly autocomplete="off"/>
                        </div>
                        <label for="i_noches" class="col-sm-1 col-md-1 col-form-label requerido">Noches </label>
                        <div class="col-sm-1 col-md-1">
                            <input type="text" id="i_noches" name="i_noches" class="form-control validate[required]" readonly autocomplete="off"/>
                        </div>
                    
                    
                    </div>
                    <div class="form-group row">
                    <div class="col-sm-1 col-md-1"></div>
                        <div class="col-sm-12 col-md-5">
                            <div class="row">

                                <div class="col-sm-12 col-md-4">
                                    <input type="checkbox" name="ch_prospectacion" id="ch_prospectacion" > Prospectación
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <input type="checkbox" name="ch_atencion" id="ch_atencion"> Atención 
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <input type="checkbox" name="ch_otros" id="ch_otros"> Otro
                                </div>
                                
                            </div>
                        </div>
                        <label for="i_fecha_comprobacion" class="col-md-auto col-form-label requerido">Fecha Límite de Comprobación </label>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" id="i_fecha_comprobacion" name="i_fecha_comprobacion" class="form-control fecha validate[required]" disabled autocomplete="off"/>
                        </div>
                    </div>
                </form>
                <br>
                <form id="form_viatico" name="form_viatico" style="background:#D1ECF1;padding-bottom:5px;">
                <div class="form-group row"> 
                    <div class="col-sm-12 col-md-3">
                        <label for="s_id_clasificacion" class="col-sm-12 col-md-3 col-form-label">Categoria </label>
                        <select id="s_id_clasificacion" name="s_id_clasificacion" class="form-control   validate[required] input_agregar" autocomplete="off"></select>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <label for="i_cantidad" class="col-sm-12 col-md-2 col-form-label">Cantidad </label>
                        <input type="text" id="i_cantidad" name="i_cantidad" class="form-control form-control-sm validate[required] input_agregar" autocomplete="off"/>
                    </div>
                   
                    <div class="col-sm-12 col-md-3">
                        <label for="i_importe" class="col-sm-12 col-md-3 col-form-label">Importe </label>
                        <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm  validate[required] input_agregar numeroMoneda" autocomplete="off"/>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2"><br>
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-2">
                        <label class="col-md-12 col-form-label">Observaciones</label>
                    </div>
                    <div class="col-sm-12 col-md-10">
                        <input type="text" id="i_observaciones" class="form-control input_agregar" autocomplete="off"/>
                    </div>
                </div> 
                </form>  
                    <div class="table-responsive">
                    <table class="table">      
                        <thead class="thead-light">
                            <tr class="renglon">
                                <th scope="col" width="30%">Categoria</th>
                                <th scope="col" width="28%">Observaciones</th>
                                <th scope="col" width="10%">Cantidad</th>
                                <th scope="col" width="20%">Importe Unitario</th>
                                <th scope="col" width="20%">Total</th>
                                <th scope="col" width="2%"></th>
                            </tr>
                        </thead>
                    </table>
                    </div>  
                    <div id="div_t_registros">
                        <table class="table table-hover"  id="t_partidas">
                            <tbody>
                                
                            </tbody>
                        </table>  
                    </div> 
                    <form class="form_viaticos" name="form_viaticos">
                        <div class="row">
                            <label for="i_autorizo" id="l_i_autorizo" class="col-sm-1 col-md-1 col-form-label ">Autorizó</label>
                            <div class="col-sm-5 col-md-5">
                                <input type="text" id="i_autorizo" name="i_autorizo" class="form-control form-control-sm" autocomplete="off"/>
                            </div>
                            <div class="col-sm-2 col-md-2"></div>
                            <label for="i_total" class="col-sm-1 col-md-1 col-form-label">Total</label>
                            <div class="col-sm-3 col-md-3">
                                <input type="text" id="i_total" name="i_total" class="form-control form-control-sm" readonly autocomplete="off"/>
                            </div>  
                        </div>
                    </form>
                    <br>
                </div>   

            </div> <!--div_contenedor-->
        </div> 
    </div> <!--div_principal-->
    </div>

    <div class="container-fluid" id="div_comprobar"> <!--div_ forma  comprobar -->
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Comprobar Viáticos</div>
                    </div>
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_regresar_a_viaticos"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> regresar</button>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    
                    <label for="i_folio_c" class="col-sm-2 col-md-2 col-form-label requerido">Folio</label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" id="i_folio_c" name="i_folio_c" class="form-control form-control-sm validate[required]" disabled autocomplete="off"/>
                    </div>
                  
                </div>

                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    
                    <label for="i_empleado_c" class="col-sm-2 col-md-2 col-form-label requerido">Empleado</label>
                    <div class="col-sm-6 col-md-6">
                        <input type="text" id="i_empleado_c" name="i_empleado_c" class="form-control form-control-sm validate[required]" disabled autocomplete="off"/>
                    </div>
                  
                </div>

                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    
                    <label for="i_destino_c" class="col-sm-2 col-md-2 col-form-label requerido">Destino</label>
                    <div class="col-sm-6 col-md-6">
                        <input type="text" id="i_destino_c" name="i_destino_c" class="form-control form-control-sm validate[required]" disabled autocomplete="off"/>
                    </div>
                  
                </div><br>
                
                <div class="row table-responsive">
                    
                    <br>
                    
                    <table class="table table-hover"  id="t_comprobar">
                        <thead class="thead-light">
                            <tr class="renglon">
                                <th scope="col" width="20%">Categoria</th> 
                                <th scope="col" width="10%">Cantidad</th>
                                <th scope="col" width="10%">Importe Unitario</th>
                                <th scope="col" width="10%">Por Comprobar</th>
                                <th scope="col" width="10%">Gasto Comprobado</th>
                                <th scope="col" width="10%">Diferencia</th>
                                <th scope="col" width="20%">Referencia</th>
                            </tr>
                        </thead>
                        <!--<form id="form_comprobado" name="form_comprobado">-->
                        <tbody>
                            
                        </tbody>
                        <!--</form>-->
                           
                        <tfoot>
                            <tr class="renglon">
                                <th scope="col" colspan="3"></th>
                                <th scope="col"><input type="text" id="i_por_comprobar" name="i_por_comprobar" class="form-control form-control-sm validate[required] der" disabled autocomplete="off"/></th>
                                <th scope="col"><input type="text" id="i_total_comprobado" name="i_total_comprobado" class="form-control form-control-sm validate[required] der" disabled autocomplete="off"/></th>
                                <th scope="col"><input type="text" id="i_total_diferencia" name="i_total_diferencia" class="form-control form-control-sm validate[required] der" disabled autocomplete="off"/></th>
                                <th scope="col"></th>
                            </tr> 
                            <tr style="background:#FFF; border:1px solid #FFF;">
                                <th scope="col" colspan="7" style="background:#D1ECF1;"></th>
                            </tr> 
                            
                            <tr style="background:#FFF; border:0px solid #FFF;">
                                <th scope="col" colspan="2"></th>
                                <th scope="col" style="text-align:right;"> FECHA DE APLICACIÓN</th>
                                <th scope="col"><input type="text" id="i_fecha_aplicacion" name="i_fecha_aplicacion" class="form-control form-control-sm validate[condRequired[i_devolucion]] fecha" readonly  autocomplete="off"/></th>
                                <th scope="col" style="text-align:right;"> Devolución</th>
                                <th scope="col"><input type="text" id="i_devolucion" name="i_devolucion" class="form-control form-control-sm validate[required] der"  autocomplete="off"/></th>
                                <th scope="col"><select id="s_cuenta_banco" name="s_cuenta_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select></th>
                            </tr> 
                            <tr style="background:#FFF; border:1px solid #FFF;">
                                <th scope="col" colspan="2"></th>
                                <th scope="col" style="text-align:right;"> Fecha Inicio</th>
                                <th scope="col"><input type="text" id="i_fecha_inicio_descuento" name="i_fecha_inicio_descuento" class="form-control form-control-sm validate[condRequired[i_descuento_n]] fecha" readonly  autocomplete="off"/></th>
                                <th scope="col" style="text-align:right;"> Descuento a Nómina</th>
                                <th scope="col"><input type="text" id="i_descuento_n" name="i_descuento_n" class="form-control form-control-sm validate[required] der"  autocomplete="off"/></th>
                                <th scope="col" align="bottom" style="text-align:bottom;">Quincenas <input type="text" id="i_quincenas" name="i_quincenas" style="width:50%; float:right;padding-right:5px;" class="form-control form-control-sm validate[custom[number],min[1]] der"  autocomplete="off"/></th>
                            </tr> 
                            <tr style="background:#FFF; border:1px solid #FFF;">
                                <th scope="col" colspan="2"></th>
                                <th scope="col" colspan="2" ="right"><button type="button" class="btn btn-primary btn-sm form-control" id="b_guardar_comprobacion" alt3='S'><i class="fa fa-pencil" aria-hidden="true"></i> GUARDAR-EDITAR</button></th>
                                <th scope="col" colspan="2" align="right"><button type="button" class="btn btn-dark btn-sm form-control verificar_permiso" alt="BOTON_APLICAR" alt3='C' id="b_aplicar"><i class="fa fa-check-square" aria-hidden="true"></i> APLICAR</button></th>
                                <th scope="col" colspan="1"><button type="button" class="btn btn-info btn-sm form-control" id="b_comprobante_pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Viatico Comprobado </button></th>
                            </tr>       
                        </tfoot>
                    </table>
                     
                </div> 
               <br>
            </div> <!--div_contenedor-->
        </div> <!--row-->
    </div><!-- fin foma div_razon_social-->
    

      
   


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
                <div class="table-responsive">
                    <table class="table table-striped table-hover"  id="t_empleados">
                      <thead class="thead-light">
                        <tr class="renglon">
                        <th scope="col" colspan="3"><span class="badge badge-warning">Para que inicie la busquedá ingresa un id de empleado ó un nombre</span>
                        </th>
                        </tr>
                        <tr class="renglon">
                          <th scope="col"><input type="text" name="i_filtro_id" id="i_filtro_id" class="form-control"  placeholder="Buscar ID" autocomplete="off"></th>
                          <th scope="col"><input type="text" name="i_filtro_nombre" id="i_filtro_nombre" class="form-control"  placeholder="Buscar Nombre" autocomplete="off"></th>
                          <th scope="col"><input type="text" name="i_filtro_empleado" id="i_filtro_empleado" class="form-control filtrar_renglones" alt="renglon_empleados" placeholder="Filtrar" autocomplete="off"></th>
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

<div class="container-fluid" id="div_busqueda"> <!--div_ forma busqueda de viaticos-->
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Busqueda Viáticos</div>
                    </div>
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_regresar"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> regresar</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-12 col-md-3">
                        <input type="radio" name="r_busqueda" id="sin_comprobar" value="1" checked> Sin Comprobar 
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <input type="radio" name="r_busqueda" id="comprobados" value="2"> Comprobados 2 Meses
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <input type="radio" name="r_busqueda" id="todos" value="3"> Todos Ultimo Año
                    </div>

                </div>
                

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <input type="text" name="i_filtro_viaticos" id="i_filtro_viaticos" alt="viatico-busqueda" class="filtrar_renglones form-control filtrar_renglones"  placeholder="Filtrar" autocomplete="off"></div>
                    </div>
                    <br>
                    <div class="table-responsive">
                    <table class="table table-striped table-hover"  id="t_viaticos">
                        <thead class="thead-light">
                            <tr class="renglon">
                                <th scope="col" width="10%">Unidad de Negocio</th> 
                                <th scope="col" width="10%">Sucursal</th>
                                <th scope="col" width="10%">Folio</th>
                                <th scope="col" width="10%">Fecha</th>
                                <th scope="col" width="10%">Nombre</th>
                                <th scope="col" width="10%">Destino</th>
                                <th scope="col" width="5%">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    </div>  
                </div>
               <br>
            </div> <!--div_contenedor-->
        </div> <!--row-->
    </div><!-- fin foma busqueda de viaticos-->

</body> 

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>
<script src="vendor/switch.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>

<script>
    var idViatico = 0;
    var tipoMov = 0;
    var idUnidadNegocioActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var usuario ='<?php echo $_SESSION['usuario']; ?>';
    var modulo = 'VIATICOS';
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var totalPartidas = 0;
    var botonEmpleado=0;
    var estatus='';
    var banderaRD = 0;
    var banderaRN = 0;
    $(function()
    {

       $("#div_principal").css({left : "0%"});
       $('#div_cancelar').hide();

       mostrarBotonAyuda(modulo);
       muestraSelectUnidades(matriz, 's_id_unidad', idUnidadNegocioActual);
       muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocioActual, modulo,idUsuario);
       muestraAreasAcceso('s_id_area');
       muestraSelectClasificacionViaticos('s_id_clasificacion');
       $('#i_capturo').val(usuario);
       $("#s_id_departamento").prop("disabled", true);

       $('#b_imprimir').prop('disabled',true);
       $('#b_solicitar').prop('disabled',true);
       $('#b_comprobar').prop('disabled',true);
       $('#ch_reposicion_gasto').bootstrapToggle();
       $('#ch_reposicion_gasto').bootstrapToggle('off');

       idFamiliaGastoViatico();
       function idFamiliaGastoViatico(){
            $('#i_id_familia_gasto').val(0);

            $.ajax({
                type: 'POST',
                url: 'php/familias_gastos_buscar_id_clave.php', 
                data:{'clave' : 'GASVIAJ'},
                success: function(data) {
                    //console.log(data);
                    if(data!=0)
                        $('#i_id_familia_gasto').val(data);
                    else{
                        $('#i_id_familia_gasto').val(0);
                        console.log('No hay registro con esa clave de familia gasto.');
                    }

                },
                error: function (xhr) {
                    console.log("php/familias_gastos_buscar_id_clave.php: -->"+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Familia Gastos');
                }
            });
       }
       
       $('#b_regresar').on('click',function(){
           
           $("#div_busqueda").animate({left : "-101%"}, 500, 'swing');
           $('#div_principal').animate({left : "0%"}, 600, 'swing');
           $('#div_cancelar').hide();
           $('#div_comodato').show();
       });

       $('#i_fecha').val(hoy);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#ch_externo').on('click',function(){
            if($(this).is(':checked')){
        
                $('#i_empleado').attr('alt',0).val('').prop('readonly',false);
                $('#b_empleado').hide(); 

            }else{

                $('#i_empleado').attr('alt',0).val('').prop('readonly',true);
                $('#b_empleado').show(); 
            }
        }); 

       
       $('#s_id_unidad').change(function()
       {
            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocio, modulo,idUsuario);

        });

       $('#s_id_sucursal').change(function(){
           var idSucursal = $('#s_id_sucursal').val();
           var idArea = $('#s_id_area').val();
           $("#s_id_departamento").empty();
           if(idSucursal > 0 && idArea > 0){
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }
        });


       $('#s_id_area').change(function()
       {

            var idSucursal = $('#s_id_sucursal').val();
            var idArea = $('#s_id_area').val();
            $("#s_id_departamento").empty();
            if(idSucursal > 0 && idArea > 0){
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }
           

        });

      
       /************************BUSCA SOLO LOS EMPLEADOS DE LA UNIDAD ACTUAL ************* */
       $('#b_buscar_empleado_solicito').on('click',function(){
            botonEmpleado=1;
            $('#i_filtro_id').val('');
            $('#i_filtro_nombre').val('');
            $('#i_filtro_empleado').val('');
            $('.renglon_empleados').remove();
            $('#dialog_buscar_empleados').modal('show'); 
        });

        $('#b_buscar_empleados').on('click',function(){
            botonEmpleado=0;
            $('#i_filtro_id').val('');
            $('#i_filtro_nombre').val('');
            $('#i_filtro_empleado').val('');
            $('.renglon_empleados').remove();
            $('#dialog_buscar_empleados').modal('show'); 
        });


        $(document).on('click','#i_filtro_id',function(){
            $('#i_filtro_nombre').val('');
            $('#i_filtro_empleado').val('');
        });

        $(document).on('click','#i_filtro_nombre',function(){
            $('#i_filtro_id').val('');
            $('#i_filtro_empleado').val('');
        });


         $(document).on('change','#i_filtro_id,#i_filtro_nombre',function(){
                
            $('#i_filtro_empleado').val('');
            $('.renglon_empleados').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/empleados_buscar_todos.php',
                dataType:"json", 
                data:{
                    'idUnidadNegocio':$('#s_id_unidad').val(),
                    'filtroId' : $('#i_filtro_id').val(),
                    'filtroNombre' : $('#i_filtro_nombre').val()
                },

                success: function(data) {

                   if(data.length != 0 ){

                        $('.renglon_empleados').remove();
                   
                        for(var i=0;data.length>i;i++){    
                            var html='<tr class="renglon_empleados" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'" alt3="'+data[i].administrativo+'">\
                                        <td data-label="usuario">' + data[i].id_trabajador+ '</td>\
                                        <td data-label="usuario">' + data[i].nombre+ '</td>\
                                         <td data-label="usuario">' + data[i].sucursal+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_empleados tbody').append(html);   
                              
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/empleados_buscar_todos.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error al buscar información');
                }
            });
        });

         

        $('#t_empleados').on('click', '.renglon_empleados', function() {
            
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var tipo = $(this).attr('alt3');
            if(botonEmpleado==0){
                $('#i_empleado').attr({'alt':id,'administrativo':tipo}).val(id+' - '+nombre);
            }else{
                $('#i_solicito').attr('alt',id).val(id+' - '+nombre);
            }
            
           

            $('#dialog_buscar_empleados').modal('hide');

        });

        $('#b_agregar').click(function(){

            if($('#form_viatico').validationEngine('validate'))
            {

                totalPartidas++;

                var idClasificacion = $('#s_id_clasificacion').val();
                var clasificacion = $('select[name="s_id_clasificacion"] option:selected').text();
                var cantidad = $('#i_cantidad').val();
                var importe = quitaComa($('#i_importe').val());
                var total= cantidad * importe;
                var botonEliminar='<button type="button" class="btn btn-danger btn-sm form-control boton_eliminar" id="b_eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                //-->NJES June/04/2020 agregar observaciones a cada partida
                var observaciones = $('#i_observaciones').val();

                var html = "<tr class='partida-viatico'  idClasificacion='" + idClasificacion + "' clasificacion='" + clasificacion + "'  cantidad='" +  cantidad + "' importe='" + importe + "' observaciones='"+observaciones+"'>";
                html += "<td width='30%'>" + clasificacion + "</td>";
                html += "<td width='28%'>" + observaciones + "</td>";
                html += "<td width='10%' align='right'>" + cantidad + "</td>";
                html += "<td width='20%' align='right'>" + formatearNumero(importe) + "</td>";
                html += "<td width='20%' align='right'>" + formatearNumero(total) + "</td>";
                html += "<td width='2%' align='right'>" + botonEliminar + "</td>";
               html += "</tr>";

                $('#t_partidas tbody').append(html);

                
                muestraSelectClasificacionViaticos('s_id_clasificacion');
                $('#i_cantidad').val('');
                $('#i_importe').val('');
                $('#i_observaciones').val('');

                calcularTotal();
            }

        });

        $(document).on('click','#b_eliminar',function(){
            $(this).parent().parent().remove();
            calcularTotal();
        });

        $('#b_nuevo').click(function()
        {
            limpiarForma();
        });

        $('#b_guardar').on('click',function(){  
            $('#b_guardar').prop('disabled',true);
            console.log(JSON.stringify(obtenerDatos()));
            if($('#i_id_familia_gasto').val() > 0)
            {

                $('#b_guardar').prop('disabled',true);
            
                if($(".form_viaticos").validationEngine('validate'))
                {
                    if($('.partida-viatico').length>0){

                        $.ajax({
                            type: 'POST',
                            url: 'php/viaticos_guardar.php',
                            dataType:"json", 
                            data: {'datos':obtenerDatos()},
                            success: function(data) 
                            {
                                console.log(data);
                                if(data>0){
                                    idViatico=data;
                                    mandarMensaje("La requisición del viático se guardó de forma adecuada");
                                    limpiarForma();
                                    // SE QUITO LA BUSQUEDA YA QUE COMO AUN NO SE IMPRIME PERMITE EDITAR(GUARDAR) CADA VEZ, 
                                    //AUNQUE SE BUSQUE VA ACTIVAR EL BOTON DE GUARDAR SI NO SE A IMPRESO*
                                    //muestraRegistro(data);
                                    //muestraDetalle(data);
                                }else{
                                    mandarMensaje('Ocurrio un error durante el guardadó');
                                    $('#b_guardar').prop('disabled',false);
                                }
                            
                                    
                            },
                            error: function (xhr) {
                                console.log('php/viaticos_guardar.php--->' + JSON.stringify(xhr));
                                mandarMensaje('* Ocurrio un error al guardar el registro, intentelo nuevamente');
                                $('#b_guardar').prop('disabled',false);
                            }
                        });
                    }else{
                        mandarMensaje('Debe haber por lo menos un registro');
                        $('#b_guardar').prop('disabled',false);
                    }

                }else{
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
                mandarMensaje('Verifica con el administrador que exista una familia de gastos con la clave GASVIAJ.');
                $('#b_guardar').prop('disabled',false);
            }

        });

        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){

            //-->NJES Jan/17/2020 Guardar id_clasificacion_gasto en el viatico
            //*si el empleado es externo la clasificacion es 67
            //*si es un empleado interno obtenemos si es administrativo = 2 u operativo = 1, 
            //si es 2 la calsificacion es 67, si es 1 la clasificacion es 68
            if($('#i_empleado').attr('alt') == 0)
                var idClasificacionGasto = 67;
            else{
                if($('#i_empleado').attr('administrativo') == 2)
                    var idClasificacionGasto = 67;
                else
                    var idClasificacionGasto = 68;
            }
           
            var paq = {
                        'tipoMov'   : tipoMov,
                        'idUsuario' : idUsuario,
                        'usuario' : $('#i_capturo').val(),
                        'idViatico': idViatico,
                        'folio': $('#i_folio').val(),
                        'idUnidadNegocio': $('#s_id_unidad').val(),
                        'idSucursal': $('#s_id_sucursal').val(),

                        'idArea': $('#s_id_area').val(),
                        'idDepartamento': $('#s_id_departamento').val(),

                        'idSolicito': $('#i_solicito').attr('alt'),
                        'idEmpleado': $('#i_empleado').attr('alt'),
                        'empleado': $('#i_empleado').val(),

                        'destino':$('#i_destino').val(),
                        'distancia':$('#i_distancia').val(),

                        'fechaInicio': $('#i_fecha_inicio').val(),
                        'fechaFin': $('#i_fecha_fin').val(),
                        'fechaComprobacion': $('#i_fecha_comprobacion').val(),
                        'dias': $('#i_dias').val(),
                        'noches': $('#i_noches').val(),

                        'motivos': $('#ta_motivos').val(),
                        'prospectacion': ($('#ch_prospectacion').is(':checked'))?1:0,
                        'atencion' : ($('#ch_atencion').is(':checked'))?1:0,
                        'otros' : ($('#ch_otros').is(':checked'))?1:0,
                        'reposicionGasto': ($('#ch_reposicion_gasto').is(':checked'))?1:0,

                        'idFamiliaGasto':$('#i_id_familia_gasto').val(),
                        'idClasificacionGasto' : idClasificacionGasto,

                        'autorizo': $('#i_autorizo').val(),
                        'total' : quitaComa($('#i_total').val()),
                        'detalle' : obtenerPartidas()
                }
               // paq.push(paq);
              
            return paq;
        } 
        
        //****************OBTENER PARTIDAS***************** */
        function obtenerPartidas(){
            
            var j = 0;
            var arreDatos = [];
            
            $("#t_partidas .partida-viatico").each(function() {

                var idClasificacion = $(this).attr('idClasificacion');
                var cantidad = $(this).attr('cantidad');
                var importeU = quitaComa($(this).attr('importe'));
                var nPartida = $(this).attr('total_partidas');
                //-->NJES June/04/2020 agregar observaciones a cada partida
                var observaciones = $(this).attr('observaciones');

                j++;

                arreDatos[j] = {
                    
                   'idClasificacion' : idClasificacion,
                   'cantidad' : cantidad,
                   'importe' : importeU,
                   'observaciones' : observaciones
                  
                };
            });
            
            arreDatos[0] = j;
        
            return arreDatos;
        }


        function calcularTotal()
        {   var total=0;
            
            $("#t_partidas .partida-viatico").each(function() {
                var cantidad = quitaComa($(this).attr('cantidad'));
                var importeU = quitaComa($(this).attr('importe'));
                total+=parseFloat(cantidad) * parseFloat(importeU);
               
            });
            $('#i_total').val(formatearNumero(parseFloat(total)));


        }

        function limpiarForma()
        {
            
            tipoMov=0;
            $('.form_viaticos').validationEngine('hide');
            $('.form_viaticos').find('input,select,textarea').val('').prop('disabled',false);
            $('#t_partidas tbody').empty();
            
           
            limpiarCombos();

            $("#s_id_unidad").prop("disabled", false);
            $("#s_id_sucursal").prop("disabled", false);
            $("#s_id_area").prop("disabled", false);
            $("#s_id_departamento").prop("disabled", true);
        
            muestraSelectUnidades(matriz, 's_id_unidad', idUnidadNegocioActual);
            muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocioActual, modulo,idUsuario);
            muestraAreasAcceso('s_id_area');
            $('input:checkbox').prop('checked', false);

           
            $('#d_estatus').removeAttr('class').text('');
            $('#i_capturo').val(usuario);
            $('#i_empleado').attr('alt',0).val('');
            $('#i_solicito').attr('alt',0).val('');
            $('#ch_reposicion_gasto').prop('checked', false);
            $('#ch_reposicion_gasto').bootstrapToggle('off');
            $('#b_buscar_empleado_solicito').prop("disabled", false);
            $('#b_buscar_empleados').prop("disabled", false);
           
            $('#b_guardar').prop("disabled", false);
            
            $('#b_imprimir').prop("disabled", true);
            $('#b_solicitar').attr({'alt2':0,'autorizo':''}).prop("disabled", true);
            $('#b_guardar_comprobacion').attr('alt2',0);
            $('#b_aplicar').attr('alt2',0).prop("disabled", true);
            $('#b_comprobante_pdf').css('display','none');// lo agrego NORA 
            $('#b_comprobar').prop("disabled", true);


            $('.input_agregar').prop('disabled',false);
            $('#b_agregar').prop('disabled',false);
            $('#i_autorizo').val('').prop('disabled',false).removeClass('validate[required]');
            $('#l_i_autorizo').removeClass('requerido');
            $('#i_total').val('');

            $('#t_viaticos tbody').empty();
            $('#i_folio').val('');
            $('#i_folio_c').val('');
            $('#i_empleado_c').val('');
            $('#i_destino_c').val('');

            $('#i_devolucion').val('');
            $('#s_cuenta_banco').val('');
            $('#i_descuento_n').val('');
            $('#i_quincenas').val('');

            $('#b_empleado').show(); 
            $('#div_cancelar').hide();

        }

        //-->NJES March/04/2020 Corregir cálculo de días y noches, si por ejemplo es del 2020-03-04 al 2020-03-04
        //son 1 día y 0 noches. Si es del 2020-03-04 al 2020-03-05 son 2 días y 1 noche.
        //validar que no la fecha fin sea mayor o igual a la fecha inicio
        $('#i_fecha_inicio').change(function(){

            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);

                if($('#i_fecha_fin').val() != ''){
                    if($('#i_fecha_inicio').val() <= $('#i_fecha_fin').val())
                        obtineFechaComprobacion();
                    else{
                        mandarMensaje('La fecha inicio no puede ser mayor a la fecha fin.');
                        $('#i_fecha_inicio').val('');
                    }
                }
            }

        });

        $('#i_fecha_fin').change(function(){
            if($('#i_fecha_fin').val()!=''){
                if($('#i_fecha_fin').val() >= $('#i_fecha_inicio').val())
                    obtineFechaComprobacion();
                else{
                    mandarMensaje('La fecha fin no puede ser menor a la fecha inicio.');
                    $('#i_fecha_fin').val('');
                }
            }  
        });

        function  obtineFechaComprobacion(){

            var fechaI = new Date($('#i_fecha_inicio').val());
            var fechaF = new Date($('#i_fecha_fin').val());
            
            var difM = fechaF - fechaI // diferencia en milisegundos
            var difD = difM / (1000 * 60 * 60 * 24) // diferencia en dias

            $('#i_dias').val(difD+1);
            $('#i_noches').val((difD));
            
            var TuFecha = new Date($('#i_fecha_fin').val());
  
            //dias a sumar
            //-->NJES June/04/2020 calcular 3 días después de la fecha de regreso
            var dias = parseInt(4);
            
            //nueva fecha sumada
            TuFecha.setDate(TuFecha.getDate() + dias);
            //formato de salida para la fecha
            $('#i_fecha_comprobacion').val(TuFecha.getFullYear() + '-' + addZ((TuFecha.getMonth() + 1))  + '-' +addZ(TuFecha.getDate()));
            
        }

        
        

        function limpiarCombos()
        {
            $('#s_id_sucursal').html('');
            $('#s_id_area').html('');
            $('#s_id_departamento').html('');
        }

        
/**************************  BUSCAR VITACORA ********************************************* */

        $('#b_buscar').click(function()
        {
            
            $("#div_principal").animate({left : "-101%"}, 500, 'swing');
            $('#div_busqueda').animate({left : "0%"}, 600, 'swing');
            $('#i_filtro_viaticos').val('');
            $('#t_viaticos tbody').empty();
            $('#sin_comprobar').prop('checked','checked');
            buscarViaticos(1);
        });

    

        $(document).on('change', 'input:radio[name=r_busqueda]',function(){
            var valor=$('input:radio[name=r_busqueda]:checked').val();
            buscarViaticos(valor);
       });

     

        function buscarViaticos(busca)
        {
            $('#t_viaticos tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/viaticos_buscar.php',
                dataType:"json", 
                data:{
                    'idsSucursal': muestraSucursalesPermisoListaId(idUnidadNegocioActual,modulo,idUsuario),
                    'busqueda' : busca
                },
                success: function(data)
                {
                    console.log(data);
                    for(var i=0; data.length>i; i++)
                    {
                        
                        var viatico = data[i];

                        
                        var html = "<tr class='viatico-busqueda' alt='" + viatico.id + "' alt2='" + viatico.impresa + "' alt3='" + viatico.estatus + "'>";
                        html += "<td>" + viatico.unidad + "</td>";
                        html += "<td>" + viatico.sucursal + "</td>";
                        html += "<td>" + viatico.folio + "</td>";
                        html += "<td>" + viatico.fecha_captura + "</td>";
                        html += "<td>" + viatico.empleado + "</td>";
                        html += "<td>" + viatico.destino + "</td>";
                        html += "<td>" + formatearNumero(viatico.total) + "</td>";
                        html += "</tr>";

                        $('#t_viaticos tbody').append(html);
                    
                    }
                
         
                },
                error: function (xhr)
                {
                    console.log('php/viaticos_buscar.php->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al buscar la viáticos');
                }
            });

        }

       
        $("#t_viaticos").on('click',".viatico-busqueda",function()
        {   idViatico = $(this).attr('alt');
            var impresa = $(this).attr('alt2');
            estatus = $(this).attr('alt3');
            $('#b_imprimir').attr('alt',$(this).attr('alt2'));


            tipoMov=1;
            $('.form_viaticos').find('input,select,textarea').prop('disabled',true);
            
            $("#div_busqueda").animate({left : "-101%"}, 500, 'swing');
            $('#div_principal').animate({left : "0%"}, 600, 'swing');
            muestraRegistro(idViatico);    
            muestraDetalle(idViatico);    
        });

        function muestraRegistro(idViatico){
            $('#b_guardar').prop('disabled',true);
            $.ajax({
                type: 'POST',
                url: 'php/viaticos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idViatico': idViatico
                },
                success: function(data)
                {
            
                    for(var i=0; data.length>i; i++)
                    {
                        var viatico = data[i];

                        tipoMov=1;

                        $('#b_guardar').prop('disabled',true);
                        $('#b_imprimir').attr('alt',viatico.impresa);
                        $('#b_imprimir').prop('disabled',false);
                        $('#b_solicitar').attr({'alt2':viatico.id,'autorizo':viatico.autorizo}).prop('disabled',true);
                        $('#b_comprobar').attr('alt', viatico.id).prop('disabled',true);
                        $('#b_guardar_comprobacion').attr('alt2', viatico.id).prop('disabled',true);
                        $('#b_aplicar').attr('alt2', viatico.id).prop('disabled',true);
                        $('#b_comprobante_pdf').attr('alt2', viatico.id);
                        $('#i_devolucion').prop('disabled',false)
                        $('#s_cuenta_banco').prop('disabled',false)
                        $('#i_descuento_n').prop('disabled',false)
                        $('#i_quincenas').prop('disabled',false);
                        $('#i_fecha_aplicacion').prop('disabled',false);
                        $('#i_fecha_inicio_descuento').prop('disabled',false);
                        $('#ch_reposicion_gasto').prop('disabled',true);
                        $('#b_agregar').prop('disabled',true);

                        $('#d_estatus').removeAttr('class');
                        idUnidadNegocio = viatico.id_unidad_negocio;
                        idSucursal = viatico.id_sucursal;
                        idArea = viatico.id_area;
                        idDepartamento = viatico.id_departamento;
                        nombreProveedor = viatico.nombre_proveedor;
                        $('#i_folio').val(viatico.folio);
                        $('#i_folio_c').val(viatico.folio);
                       
                        limpiarCombos();

                        $('#s_id_unidad').val(idUnidadNegocio);
                        $("#s_id_unidad").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

                        optionSurucursal = new Option(viatico.sucursal, viatico.id_sucursal, true, true);
                        $('#s_id_sucursal').append(optionSurucursal).trigger('change');

                        optionArea = new Option(viatico.are, viatico.id_area, true, true);
                        $('#s_id_area').append(optionArea).trigger('change');
                        
                        optionDepto = new Option(viatico.departamento, viatico.id_departamento, true, true);
                        $('#s_id_departamento').append(optionDepto).trigger('change');

                        $("#s_id_unidad").prop("disabled", true)
                        $("#s_id_sucursal").prop("disabled", true)
                        $("#s_id_area").prop("disabled", true)
                        $("#s_id_departamento").prop("disabled", true)

                        $('#i_folio_requi').attr('alt', viatico.id).val( viatico.folio)
                        $('#i_solicito').attr('alt',viatico.id_solicito).val(viatico.solicito)
                        $('#i_capturo').val(viatico.usuario_captura);
                        //--- empleado externo  id_empleado=0
                        if(viatico.id_empleado==0){
                            $('#i_empleado').attr('alt',0).val(viatico.empleado).prop('readonly',false);
                            $('#b_empleado').hide(); 
                            $('#ch_externo').prop('checked', true);

                        }else{

                            $('#i_empleado').attr('alt',viatico.id_empleado).val(viatico.empleado).prop('readonly',true);
                            $('#b_empleado').show();
                            $('#b_buscar_empleados').prop('disabled',false); 
                            $('#ch_externo').prop('checked', false);
                        }
                       
                        $('#ch_reposicion_gasto').prop('disabled',false);
                        if(viatico.reposicion_gasto==1){
                            //Es una cantidad exacta porque ya gasto el dinero el empleado y se lo van a reponer
                            $('#ch_reposicion_gasto').prop('checked',true)
                            $('#ch_reposicion_gasto').bootstrapToggle('on')
                            $('#ch_reposicion_gasto').prop('disabled',true);

                            $('#i_devolucion').prop('disabled',true);
                            $('#s_cuenta_banco').prop('disabled',true);
                            $('#i_descuento_n').prop('disabled',true);
                            $('#i_quincenas').prop('disabled',true);
                            $('#i_fecha_aplicacion').prop('disabled',true);
                            $('#i_fecha_inicio_descuento').prop('disabled',true);
                           

                        }else{
                            $('#ch_reposicion_gasto').prop('checked',false)
                            $('#ch_reposicion_gasto').bootstrapToggle('off');
                            $('#ch_reposicion_gasto').prop('disabled',true);

                            $('#i_devolucion').prop('disabled',false);
                            $('#s_cuenta_banco').prop('disabled',false);
                            $('#i_descuento_n').prop('disabled',false);
                            $('#i_quincenas').prop('disabled',false);
                            $('#i_fecha_aplicacion').prop('disabled',false);
                            $('#i_fecha_inicio_descuento').prop('disabled',false);
                        }
                        $('#i_empleado_c').attr('alt',viatico.id_empleado).val(viatico.empleado)
                        

                        $('#i_destino').val(viatico.destino)
                        $('#i_destino_c').val(viatico.destino)
                        $('#i_distancia').val(viatico.distancia)

                        $('#i_fecha_inicio').val(viatico.fecha_inicio)
                        $('#i_fecha_fin').val(viatico.fecha_fin)
                        $('#i_fecha_comprobacion').val(viatico.fecha_comprobacion)
                        $('#i_dias').val(viatico.dias)
                        $('#i_noches').val(viatico.noches)

                        $('#ta_motivos').val(viatico.motivos)

                        $("#ch_prospectacion").attr('checked', false);
                        $("#ch_atencion").attr('checked', false);
                        $("#ch_otros").attr('checked', false);

                        if(viatico.prospectacion==1){
                            $("#ch_prospectacion").attr('checked', true);
                        }
                        if(viatico.atencion==1){
                            $("#ch_atencion").attr('checked', true);
                        }
                        if(viatico.otros==1){
                            $("#ch_otros").attr('checked', true);
                        }
                        
                        $('#i_autorizo').val(viatico.autorizo);

                        //--- Si esta impresa ya no se puede modificar la información
                        if(viatico.impresa==1){
                            $('.form_viaticos').find('input,textarea,select,input:checkbox').prop('disabled',true);
                            
                            $('#b_buscar_empleado_solicito').prop('disabled',true);
                            $('#b_buscar_empleados').prop('disabled',true);
                            $('#b_guardar').prop('disabled',true);
                            $('.input_agregar').prop('disabled',true);
                            $('#ch_reposicion_gasto').prop('disabled',true);

                            //-->NJES Jan/31/2020 se habilita para que pueda guardar  quien autorizo el viatico para que se pueda solicitar
                            if(viatico.autorizo != '')
                            {
                                $('#b_guardar').prop('disabled',true);
                                $('#i_autorizo').prop('disabled',true).removeClass('validate[required]');
                                $('#l_i_autorizo').removeClass('requerido');
                            }else{
                                $('#b_guardar').prop('disabled',false);
                                $('#i_autorizo').prop('disabled',false).removeClass('validate[required]').addClass('validate[required]');
                                $('#l_i_autorizo').removeClass('requerido').addClass('requerido');
                            }
                    
                            
                            if(viatico.estatus == 'A'){
                                verificarPermisoBoton('b_solicitar',idUsuario,idSucursal,idUnidadNegocio)
                                $('#d_estatus').addClass('alert alert-sm alert-primary').text('IMPRESA');
                                
                                $('#div_comodato').hide();
                                $('#div_cancelar').show();
                                $('#b_cancelar').attr('alt',viatico.id);
                            }

                            //-->NJES June/04/2020 si el estatus es cancelado ocultar botones de cancelar
                            if(viatico.estatus == 'CA')
                            {
                                $('#div_cancelar').hide();
                                $('#div_comodato').show();
                                $('#b_cancelar').attr('alt',viatico.id);


                                $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADO'); 
                                $('.form_viaticos').find('input,textarea,select,input:checkbox').prop('disabled',true);
                                
                                $('#b_buscar_empleado_solicito').prop('disabled',true);
                                $('#b_buscar_empleados').prop('disabled',true);
                                $('#b_guardar').prop('disabled',true);
                                $('.input_agregar').prop('disabled',true);
                                $('#ch_reposicion_gasto').prop('disabled',true);
                                $('#i_autorizo').prop('disabled',true);
                            }

                            if(viatico.estatus == 'S'){
                                verificarPermisoBoton('b_aplicar',idUsuario,idSucursal,idUnidadNegocio)

                                $('#d_estatus').removeAttr('class');
                                $('#d_estatus').addClass('alert alert-sm alert-success').text('SOLICITADA');
                                $('#b_comprobar').attr('idDD',viatico.id_deudor_diverso);
                                $('#b_comprobar').prop('disabled',true);
                                $('#b_guardar_comprobacion').prop('disabled',true); 
                                $('#b_comprobante_pdf').css('display','none');

                                if(parseInt(viatico.id_deudor_diverso) > 0){

                                    $('#b_comprobar').prop('disabled',false);
                                    $('#b_guardar_comprobacion').prop('disabled',false);
                                }

                                //-->NJES February/04/2020 si un viatico ya fue pagado por finanzas en pagos cxp ya no se puede cancelar
                                //es decir si el viatico no esta ligado en deudores_diversos aun se podra cancelar, sino no
                                if(viatico.reposicion_gasto==0 && viatico.comprobado_dd==0 && viatico.id_deudor_diverso==0)
                                {
                                    console.log('A');    
                                    $('#div_cancelar').show();
                                    $('#b_cancelar').attr('alt',viatico.id).prop('disabled',false);
                                }
                                else if(viatico.reposicion_gasto==1 && viatico.estatus_cxp=='' && viatico.id_deudor_diverso==0)
                                {
                                    console.log('B');    
                                    $('#div_cancelar').show();
                                    $('#b_cancelar').attr('alt',viatico.id).prop('disabled',false);
                                }
                                else
                                {
                                    console.log('C');
                                    console.log('Reposicion gasto -> ' + viatico.reposicion_gasto);
                                    console.log('Estatus CXP -> ' + viatico.estatus_cxp);
                                    console.log('Deudor diverso -> ' + viatico.id_deudor_diverdo);
                                    console.log('Comprobado -> ' + viatico.comprobado_dd);
                                    $('#div_cancelar').hide();
                                }

                                console.log('verificando: ' + viatico.id);

                                $('#div_comodato').show();

                            }

                            if(viatico.estatus == 'C')
                            {

                                $('#d_estatus').removeAttr('class');
                                $('#b_aplicar').prop('disabled',true);
                                $('#b_guardar_comprobacion').prop('disabled',true);
                                $('#d_estatus').addClass('alert alert-sm alert-warning').text('COMPROBADA');
                                $('#b_comprobar').attr('alt', viatico.id).prop('disabled',false);
                                $('#i_devolucion').prop('disabled',true);
                                $('#s_cuenta_banco').prop('disabled',true);
                                $('#i_descuento_n').prop('disabled',true);
                                $('#i_quincenas').prop('disabled',true);
                                $('#i_fecha_aplicacion').prop('disabled',true);
                                $('#i_fecha_inicio_descuento').prop('disabled',true);
                                $('#b_comprobante_pdf').css('display','block');

                                if(viatico.reposicion_gasto==1 && (viatico.estatus_cxp=='P' || viatico.estatus_cxp=='A'))
                                {
                                    //alert('A');    
                                    $('#div_cancelar').show();
                                    $('#b_cancelar').attr('alt',viatico.id).prop('disabled',false);
                                }
                                else
                                {
                                    //alert('CC');
                                    $('#div_cancelar').hide();
                                }
                                
                                $('#div_comodato').show();
                            }

                        }else{
                            
                            $('#d_estatus').addClass('alert alert-sm alert-info').text('ACTIVA');   
                            $('.form_viaticos').find('input,textarea,select,input:checkbox').prop('disabled',false);
                            $('#b_agregar').prop('disabled',false);
                            $('#b_buscar_empleado_solicito').prop('disabled',false);
                            $('#b_buscar_empleados').prop('disabled',false);
                            $('#b_guardar').prop('disabled',false);
                            $('.input_agregar').prop('disabled',false);
                            $('#i_autorizo').prop('disabled',false);
                            $('#ch_reposicion_gasto').prop('disabled',false);

                            //-->NJES June/04/2020 se agrega bonton cancelar si el viatico no ha sido solicitado
                            if(viatico.estatus == 'A')
                            {
                                $('#div_comodato').hide();
                                $('#div_cancelar').show();
                                $('#b_cancelar').attr('alt',viatico.id);
                            }

                            //-->NJES June/04/2020 si el estatus es cancelado ocultar botones de cancelar
                            if(viatico.estatus == 'CA')
                            {
                                $('#div_cancelar').hide();
                                $('#div_comodato').show();
                                $('#b_cancelar').attr('alt',viatico.id);

                                $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADO'); 
                                $('.form_viaticos').find('input,textarea,select,input:checkbox').prop('disabled',true);
                                
                                $('#b_buscar_empleado_solicito').prop('disabled',true);
                                $('#b_buscar_empleados').prop('disabled',true);
                                $('#b_guardar').prop('disabled',true);
                                $('.input_agregar').prop('disabled',true);
                                $('#ch_reposicion_gasto').prop('disabled',true);
                                $('#i_autorizo').prop('disabled',true);
                            }
        
                        }


                        
                        
                        

                        $('#i_total').val(formatearNumero(viatico.total));
                    
                        $('#i_devolucion').val(viatico.devolucion);
                        $('#s_cuenta_banco').val(viatico.id_cuenta);
                        $('#i_descuento_n').val(viatico.descuento_nomina);
                        $('#i_quincenas').val(viatico.quincenas);

                    }
         
                },
                error: function (xhr)
                {
                    console.log('php/viaticos_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error al buscar información del viático');
                }

            });
        }

        function muestraDetalle(idViatico)
        {
            
            $('#t_partidas tbody').empty();
            $('#t_comprobar tbody').empty();
        

            $.ajax({
                type: 'POST',
                url: 'php/viaticos_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idViatico':idViatico
                },
                success: function(data)
                {
                    var bloquear='';
                    var bloquearInput='';
                    if(parseInt($('#b_imprimir').attr('alt'))==1){
                       bloquear='disabled';
                    }
                   
                    if(estatus=='C'){
                        bloquearInput='disabled';
                    }
                    var porComprobar = 0;
                    var comprobado = 0;
                    var diferencia = 0;
                    for(var i=0; data.length>i; i++)
                    { 
                        
                        var viatico = data[i];

                        var total = viatico.cantidad*viatico.importe;

                        var botonEliminar = '<button type="button" class="btn btn-danger btn-sm form-control elimina_partida" id="b_eliminar" alt="'+viatico.id+'" '+bloquear+'><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        
                        var html = "<tr class='partida-viatico'  idClasificacion='" + viatico.id_clasificacion + "' clasificacion='" + viatico.clasificacion + "'  cantidad='" +  viatico.cantidad + "' importe='" + viatico.importe + "' observaciones='"+viatico.observaciones+"'>";
                        html += "<td width='30%'>" + viatico.clasificacion + "</td>";
                        html += "<td width='28%'>" + viatico.observaciones + "</td>";
                        html += "<td width='10%' align='right'>" + viatico.cantidad + "</td>";
                        html += "<td width='20%' align='right'>" + formatearNumero(viatico.importe) + "</td>";
                        html += "<td width='20%' align='right'>" + formatearNumero(total) + "</td>";
                        html += "<td width='2%' align='right'>" + botonEliminar + "</td>";
                        html += "</tr>";

                        $('#t_partidas tbody').append(html);

                        /******TABLA DE COMPROBAR VIATICOS**** */

                        var inputC = '<input type="text" id="i_gasto_c_'+viatico.id+'" name="i_gasto_c_'+viatico.id+'" alt="' + viatico.id +'" alt2="'+total+'" class="form-control form-control-sm validate[required,custom[number]] numeroMoneda der gasto_c" value="' + formatearNumero(viatico.gasto_comprobado) + '" '+bloquearInput+' autocomplete="off"/>';
                        var inputR = '<input type="text" class="form-control form-control-sm validate[required] referencia" value="' + viatico.referencia + '" '+bloquearInput+' autocomplete="off"/>';
                        var diferencia = parseFloat(total) - parseFloat(viatico.gasto_comprobado);
                        porComprobar += total;
                        var htmlC = "<tr class='partida-comprobar' idViaticoD='" + viatico.id + "' idClasificacion='" + viatico.id_clasificacion + "' clasificacion='" + viatico.clasificacion + "'  cantidad='" +  viatico.cantidad + "' importe='" + viatico.importe + "' >";
                        htmlC += "<td width='35%'>" + viatico.clasificacion + "</td>";
                        htmlC += "<td width='20%' align='right'>" + viatico.cantidad + "</td>";
                        htmlC += "<td width='20%' align='right'>" + formatearNumero(viatico.importe) + "</td>";
                        htmlC += "<td width='20%' align='right'>" + formatearNumero(total) + "</td>";
                        htmlC += "<td width='20%' align='right'>" + inputC + "</td>";
                        htmlC += "<td width='20%' align='right' class='td_diferencia' id='td_diferencia_"+viatico.id+"'>" + formatearNumero(diferencia) + "</td>";
                        htmlC += "<td width='20%'>" + inputR + "</td>";
                        htmlC += "</tr>";

                        $('#t_comprobar tbody').append(htmlC);
                    }
                    if(i==data.length){

                        $('#i_por_comprobar').val(formatearNumero(porComprobar));
                        $('#i_total_diferencia').val(formatearNumero(porComprobar));

                        //calcularTotal();
                        calculaComprobadoDiferencia();

                    }
                    
                
         
                },
                error: function (xhr)
                {
                    console.log('php/viaticos_buscar.php->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al buscar la viáticos');
                }
            });

        }

        $('#b_imprimir').click(function(){
 
            var impresa=$(this).attr('alt');

            if(parseInt(impresa)==0){

                $.ajax({
                    type: 'POST',
                    url: 'php/viaticos_actualiza_estatus_impresa.php',
                    data:{
                        'idViatico':idViatico
                    },
                    success: function(data)
                    {  
                        
                        if(data>0){
                            idViatico=data;
                            limpiarForma();
                            muestraRegistro(idViatico);
                            muestraDetalle(idViatico);
                            mandarMensaje('Esta requisición de viático ya no podrá ser editada');
                        }else{
                            mandarMensaje('Ocurrio un error al cambiar a estatus impresa');
                        }
                    },
                    error: function (xhr)
                    {
                        console.log('php/viaticos_actualiza_estatus_impresa.php-->'+ JSON.stringify(xhr));
                        mandarMensaje('* Ocurrio un error al cambiar a estatus impresa');
                    }
                });

            }


            var datos = {
                'path':'formato_viatico',
                'idRegistro':idViatico,
                'nombreArchivo':'viatico_'+$('#i_folio').val(),
                'tipo':1
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new')

        });

        

        $('#b_solicitar').on('click',function(){
            $('#b_solicitar').prop('disabled',true);
            var idViatico = $(this).attr('alt2');
            var autorizo = $(this).attr('autorizo');
            if(autorizo != '')
            {
                $.ajax({
                    type: 'POST',
                    url: 'php/viaticos_solicitar.php',
                    data:{
                        'idViatico':idViatico
                    },
                    success: function(data)
                    {
                        if(data>0){
                            idViatico=data;
                            mandarMensaje('La solicitud de viáticos con folio: '+$('#i_folio').val()+' se realizó correctamente');
                            limpiarForma();
                            muestraRegistro(idViatico);
                            muestraDetalle(idViatico);
                        }else{
                            mandarMensaje('Ocurrio un error al hacer la solicitud de viáticos');
                        
                        }
                    
                        $('#b_solicitar').prop('disabled',false);
                    },
                    error: function (xhr)
                    {
                        console.log('php/viaticos_solicitar.php->'+JSON.stringify(xhr));
                        mandarMensaje('* Ocurrio un error al hacer la solicitud de viáticos');
                        $('#b_solicitar').prop('disabled',false);
                    }
                });
            }else{
                mandarMensaje('Es necesario guardar quien autoriza el viatico.');
                $('#b_solicitar').prop('disabled',false);
            }
        });

       /*$(document).on('click','#b_cancelar_registro',function(){

           $('#b_cancelar_registro').prop('disabled',true);
           if($('#form_justificacion').validationEngine('validate')){
               tipoMov=1;
               guardar();
               $('#dialog_justificacion').modal('hide');
           }else{
               $('#b_cancelar_registro').prop('disabled',false);
           }
           
       });*/

       /**************************  COMPROBAR VITACORA ********************************************* */

        $('#b_comprobar').click(function(){

            $("#div_principal").animate({left : "-101%"}, 500, 'swing');
            $('#div_comprobar').animate({left : "0%"}, 600, 'swing');
            $('.viatico-comprobar').remove();
            //** MGFS 20-12-2019 Muestra solo las cuenta de caja chica issue DEN18-2425 */
            muestraCuentaCajaChica('s_cuenta_banco','');
            
        });

        $('#b_regresar_a_viaticos').on('click',function(){
           
           $("#div_comprobar").animate({left : "-101%"}, 500, 'swing');
           $('#div_principal').animate({left : "0%"}, 600, 'swing');
           
        });


        $(document).on('change','.gasto_c',function(){
           
            if($(this).validationEngine('validate')==false){

                var valor = quitaComa($(this).val());
                var idViaticoD = $(this).attr('alt');
                var total = quitaComa($(this).attr('alt2'));
                var diferencia = parseFloat(total)-parseFloat(valor);
                $('#i_gasto_c_'+idViaticoD).val(formatearNumero(valor));
                $('#td_diferencia_'+idViaticoD).text('').text(formatearNumero(diferencia));

                calculaComprobadoDiferencia();
            }
            
        });

        function calculaComprobadoDiferencia(){
            var totalComprobado = 0;
            var totalDiferencia = 0;

            $("#t_comprobar .partida-comprobar").each(function() {
                var comprobado = quitaComa($(this).find('.gasto_c').val());
                var diferencia = quitaComa($(this).find('.td_diferencia').text());
                comprobado=(comprobado!='' && comprobado >=0)?comprobado:0;
                totalComprobado += comprobado;
                totalDiferencia += diferencia;

            });

            $('#i_total_comprobado').val(formatearNumero(totalComprobado));
            $('#i_total_diferencia').val(formatearNumero(totalDiferencia));

            

        }

         /* obtine los datos y los guarda en un arreglo*/
         function obtenerDatosComprobacion(estatus){
            //-->NJES Jan/17/2020 Guardar id_clasificacion_gasto en el viatico
            //*si el empleado es externo la clasificacion es 67
            //*si es un empleado interno obtenemos si es administrativo = 2 u operativo = 1, 
            //si es 2 la calsificacion es 67, si es 1 la clasificacion es 68
            if($('#i_empleado').attr('alt') == 0)
                var idClasificacionGasto = 67;
            else{
                if($('#i_empleado').attr('administrativo') == 2)
                    var idClasificacionGasto = 67;
                else
                    var idClasificacionGasto = 68;
            }

            var paq = {
                       
                        'folio' : $('#i_folio').val(),
                        'idViatico': idViatico,
                        'idUsuario' : idUsuario,
                        'usuario' : $('#i_capturo').val(),
                        'idUnidadNegocio': $('#s_id_unidad').val(),
                        'idSucursal': $('#s_id_sucursal').val(),

                        'idArea': $('#s_id_area').val(),
                        'idDepartamento': $('#s_id_departamento').val(),
                        'idEmpleado': $('#i_empleado').attr('alt'),
                        'empleado': $('#i_empleado').val(),
                        'reposicionGasto': ($('#ch_reposicion_gasto').is(':checked'))?1:0,

                        'total' : quitaComa($('#i_total').val()),
                        'importeDD' : quitaComa($('#i_total').val()),
                        'importeC' : quitaComa($('#i_total_comprobado').val()),
                        'tipo' : 'viatico',

                        'idFamiliaGasto':$('#i_id_familia_gasto').val(),
                        'idClasificacionGasto' : idClasificacionGasto,

                        'idRegistro' : $('#b_comprobar').attr('idDD'),
                        'devolucion': quitaComa($('#i_devolucion').val()),
                        'fechaAplicacion' : $('#i_fecha_aplicacion').val(),
                        'tipoCuentaBanco': $('#s_cuenta_banco option:selected').attr('alt2'),
                        'referencia': 'V-'+$('#i_folio').val(),
                        'idCuentaBanco': $('#s_cuenta_banco').val(),
                        'descuento': quitaComa($('#i_descuento_n').val()),
                        'quincenas': $('#i_quincenas').val(),
                        'fecha_inicio' : $('#i_fecha_inicio_descuento').val(),
                        'estatus' : estatus,
                        'detalleC' : obtenerPartidasComprobadas()
                }
                //paquete.push(paq);
                
            return paq;
        } 



        //****************OBTENER PARTIDAS COMPROBADAS***************** */
        function obtenerPartidasComprobadas(){
            
            var j = 0;
            var arreDatos = [];
            
            $("#t_comprobar .partida-comprobar").each(function() {
               
                var idViaticoD = $(this).attr('idViaticoD');
                var cantidad = $(this).attr('cantidad');
                var importeU = quitaComa($(this).attr('importe'));
                var comprobado = quitaComa($(this).find('.gasto_c').val());
                var diferencia = quitaComa($(this).find('.td_diferencia').text());
                var referencia = $(this).find('.referencia').val();
                var nPartida = $(this).attr('total_partidas');

                j++;

                arreDatos[j] = {
                    
                   'idViaticoD' : idViaticoD,
                   'comprobado' : comprobado,
                   'diferencia' : diferencia,
                   'referencia' : referencia
                  
                };
            });
            
            arreDatos[0] = j;
           
            return arreDatos;
        }


        

        $('#b_aplicar').click(function(){ 
            verificaRequiredDevolucion();
            verificaRequiredNomina(); 

            $('#b_aplicar').prop('disabled',true);
            var idViatico = $(this).attr('alt2');
            var estatusB = $(this).attr('alt3');
            var mensaje ='La comprobación de la requisición se aplicó de forma adecuada';

            guardarAplicar('b_aplicar',idViatico,estatusB,mensaje);

        });

        $('#b_guardar_comprobacion').click(function(){  

            $('#b_guardar').prop('disabled',true);
            var idViatico = $(this).attr('alt2');
            var estatusB = $(this).attr('alt3');
            var mensaje ='La comprobación de la requisición se guardó de forma adecuada';

            guardarAplicar('b_guardar_comprobacion',idViatico,estatusB,mensaje);

        });


        function guardarAplicar(boton,idViatico,estatusB,mensaje){

            var diferencia = quitaComa($('#i_total_diferencia').val());
            var devolucion = $('#i_devolucion').val();
            var descuento = $('#i_descuento_n').val();
            var suma = parseFloat(devolucion) + parseFloat(descuento);
            
            //-->NJES March/13/2020 se agrega validacion para que si va una cantidad en devolución o descuento solicite los campos obligatorios
            if(parseFloat(diferencia) == parseFloat(suma))
            {
                if(banderaRD == 0 && banderaRN == 0)
                {
                    if($('.partida-comprobar').length > 0){
                        
                        $.ajax({
                            type: 'POST',
                            url: 'php/viaticos_comprobar.php',
                            data: {
                                'boton':boton,
                                'reposicionGasto': ($('#ch_reposicion_gasto').is(':checked'))?1:0,
                                'datos':obtenerDatosComprobacion(estatusB)

                            },
                            success: function(data) 
                            {
                                //console.log(data);
                                if(data>0){

                                    //idViatico=data;
                                    estatus=estatusB;
                                    mandarMensaje(mensaje);
                                    limpiarForma();
                                    muestraRegistro(idViatico);
                                    muestraDetalle(idViatico);

                                    if(boton == 'b_aplicar')
                                    {
                                        generarPdfViaticosComprobados(idViatico);
                                    }
                                    
                                }else{
                                    
                                    mandarMensaje('Ocurrio un error durante el guardadó');
                                    $('#'+boton).prop('disabled',false);
                                }
                            
                                    
                            },
                            error: function (xhr) {
                                console.log('php/viaticos_comprobar.php--->' + JSON.stringify(xhr));
                                mandarMensaje('* Ocurrio un error al guardar el registro, intentelo nuevamente');
                                $('#'+boton).prop('disabled',false);
                            }
                        });
                    }else{
                        mandarMensaje('Debe haber por lo menos un registro');
                        $('#'+boton).prop('disabled',false);
                    }
                }else
                {
                    if((parseFloat(quitaComa($('#i_devolucion').val())) > 0 && $('#i_devolucion').val() != '')
                    && ($('#s_cuenta_banco').val() == 0 || $('#s_cuenta_banco').val() == null || $('#s_cuenta_banco').val() == ''))
                    {
                        mandarMensaje('La cuenta banco es obligatoria.');
                    }else{
                        if((parseFloat(quitaComa($('#i_descuento_n').val())) > 0 && $('#i_descuento_n').val() != '')
                        && ($('#i_quincenas').val() == 0 || $('#i_quincenas').val() == '') ){
                            mandarMensaje('Las quincenas debe ser minimo 1');
                            $('#i_quincenas').css('border','1px solid red');
                        }else{
                            mandarMensaje('Los campos en rojo son obligatorios.');
                        }
                    }
                    verificaRequiredDevolucion();
                    verificaRequiredNomina();
                   $('#'+boton).prop('disabled',false);
                }

            }else{
                mandarMensaje('La cantidad de Diferencia debe ser igual a la suma de Devolución y Descuento Nómina');
                $('#'+boton).prop('disabled',false);
            }

        }

        function generarPdfViaticosComprobados(idViatico){
            var datos = {
                'path':'formato_viatico_comprobado',
                'idRegistro':idViatico,
                'nombreArchivo':'Viatico_Comprobado',
                'tipo':4
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        }

        $('#b_comprobante_pdf').click(function(){
            var id = $(this).attr('alt2');
            generarPdfViaticosComprobados(id);
        });

//-->NJES March/13/2020 se agrega validacion para que si va una cantidad en devolución o descuento solicite los campos obligatorios
        $('#i_devolucion').change(function(){
            verificaRequiredDevolucion();
            verificaRequiredNomina();
        });

        $('#i_descuento_n').change(function(){
            verificaRequiredDevolucion();
            verificaRequiredNomina();
        });

        function verificaRequiredDevolucion(){
            if((parseFloat(quitaComa($('#i_devolucion').val())) > 0 && $('#i_devolucion').val() != ''))
            {
                if(($('#s_cuenta_banco').val() > 0 || $('#i_quincenas').val() != null || $('#s_cuenta_banco').val() == '') 
                && $('#i_fecha_aplicacion').val() != '')
                {
                    banderaRD = 0;
                    $('#s_cuenta_banco,#i_fecha_aplicacion').css('border','1px solid #ced4da');
                }else{
                    banderaRD = 1;
                    $('#s_cuenta_banco,#i_fecha_aplicacion').css('border','1px solid red');
                }
            }else{
                banderaRD = 0;
                $('#i_fecha_aplicacion').val(''); 
                $('#s_cuenta_banco,#i_fecha_aplicacion').css('border','1px solid #ced4da');
                $('#i_devolucion').val(0);
            }
        }

        function verificaRequiredNomina(){
            if((parseFloat(quitaComa($('#i_descuento_n').val())) > 0 && $('#i_descuento_n').val() != ''))
            {
                if(($('#i_quincenas').val() > 0 || $('#i_quincenas').val() != '') 
                && $('#i_fecha_inicio_descuento').val() != '')
                {
                    banderaRN = 0;
                    $('#i_quincenas,#i_fecha_inicio_descuento').css('border','1px solid #ced4da');
                }else{
                    banderaRN = 1;
                    $('#i_quincenas,#i_fecha_inicio_descuento').css('border','1px solid red');
                }
            }else{
                banderaRN = 0;
                $('#i_quincenas').val(''); 
                $('#i_quincenas,#i_fecha_inicio_descuento').css('border','1px solid #ced4da');
                $('#i_descuento_n').val(0);
            }
        }

        //-->NJES June/04/2020 cancelar viaticos mientras no se haya solicitado
        $('#b_cancelar').click(function(){
            var id = $(this).attr('alt');
            $('#b_cancelar').prop('disabled',true);

            $.ajax({
                type: 'POST',
                url: 'php/viaticos_cancelar.php',
                dataType:"json", 
                data:{
                    'idViatico':id
                },
                success: function(data) {
                    
                    if(data>0){
                        muestraRegistro(id);
                        muestraDetalle(id);
                        mandarMensaje('Registro cancelado');
                    }else{
                        mandarMensaje('Ocurrio un error al cancelar intentalo nuevamente');
                        $('#b_cancelar').prop('disabled',false);
                    }
                },
                error: function (xhr) {
                    console.log('php/viaticos_cancelar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al cancelar intentalo nuevamente');
                    $('#b_cancelar').prop('disabled',false);
                }
            });   
        });

    });

</script>

</html>