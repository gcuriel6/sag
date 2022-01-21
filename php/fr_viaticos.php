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
</head>

<style> 
    body{
        background-color:rgb(238,238,238);
    }
    #div_principal,
    #div_proveedor{
      position: absolute;
      top:0px;
      left:0px;
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

   #dialog_buscar_gastos > .modal-lg{
        min-width: 90%;
        max-width: 90%;
    }
    #dialog_agregar_proveedor > .modal-lg{
        min-width: 90%;
        max-width: 90%;
        z-index :0;
    }  

    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_montos_nomina{
            height:auto;
            overflow:auto;
        }
        #td_descripcion{
            width:100%;
        }
        #td_clave{
            width:100%;
        }
        #dialog_buscar_gastos > .modal-lg{
            max-width: 100%;
        }
        #dialog_agregar_proveedor > .modal-lg{
            max-width: 100%;
        }
    }

    .input_num{
        text-align:right;
    }

    .Cancelada {
        color:#721C24;
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">
        <form id="form_gastos" name="form_gastos">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
                <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-2">
                        <div class="titulo_ban">Gastos</div>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-primary btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Cancelar</button>
                    </div>
                </div>
                <br>
                
                <div class="form-group row">
                    <label for="s_id_unidad" class="col-sm-2 col-md-2 col-form-label requerido">Unidad de Negocio </label>
                    <div class="col-sm-3 col-md-3">
                        <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <label for="s_id_area" class="col-sm-2 col-md-2 col-form-label requerido">Área </label>
                    <div class="col-sm-4 col-md-4">
                        <select id="s_id_area" name="s_id_area" class="form-control validate[required]" autocomplete="off"></select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="s_id_sucursal" class="col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                    <div class="col-sm-12 col-md-3">
                        <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <label for="s_id_departamento" class="col-sm-2 col-md-2 col-form-label requerido">Departamento </label>
                    <div class="col-sm- col-md-4">
                        <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="s_familia_gastos" class="col-sm-2 col-md-2 col-form-label requerido">Familia </label>
                    <div class="col-sm-12 col-md-3">
                        <select id="s_familia_gastos" name="s_familia_gastos" class="form-control validate[required]" autocomplete="off"></select>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <label for="s_cuenta" class="col-sm-2 col-md-2 col-form-label requerido">Cuenta</label>
                        <div class="col-sm-12 col-md-4">
                            <select id="s_cuenta" name="s_cuenta" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                     </div>
                    
                </div>

                <div class="form-group row"> 
                    <label for="s_clasificacion_gastos" class="col-sm-2 col-md-2 col-form-label requerido">Clasificación </label>
                    <div class="col-sm-12 col-md-3">
                        <select id="s_clasificacion_gastos" name="s_clasificacion_gastos" class="form-control validate[required]" autocomplete="off"></select>
                    </div> 
                    <div class="col-sm-1 col-md-1"></div>  
                    <label for="i_concepto" class="col-sm-2 col-md-2 col-form-label requerido">Concepto </label>
                    <div class="col-sm-4 col-md-4">
                        <input type="text" id="i_concepto" name="i_concepto" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                    </div>
                    
                </div>
                <div class="form-group row">    
                    <label for="i_fecha" class="col-sm-2 col-md-2 col-form-label requerido">Fecha </label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" id="i_fecha" name="i_fecha" class="form-control fecha validate[required]" readonly autocomplete="off"/>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <label for="s_tipo_gasto" class="col-sm-1 col-md-1 col-form-label requerido">Tipo </label>
                    <div class="col-sm-2 col-md-2">
                        <select id="s_tipo_gasto" name="s_tipo_gasto" class="form-control validate[required]" autocomplete="off"></select>
                    </div>
                    <label for="i_referencia" class="col-sm-1 col-md-1 col-form-label requerido">Referencia </label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" id="i_referencia" name="i_referencia" class="form-control form-control-sm validate[required]"  autocomplete="off"/>
                    </div>
                </div>
                <div class="form-group row">
                   <label for="ta_observaciones" class="col-sm-2 col-md-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10 col-md-10">
                        <textarea class="form-control" name="ta_observaciones" id="ta_observaciones" rows="1" autocomplete="off"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="i_proveedor" class="col-2 col-md-2 col-form-label requerido">Proveedor </label>
                   
                        <div class="input-group col-sm-6 col-md-6">
                            <input type="text" id="i_proveedor" name="i_proveedor" class="form-control validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar_proveedores" alt="no" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-info" type="button" id="b_detalle_proveedor" style="margin:0px;">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-1"></div>
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar_proveedor"><i class="fa fa-plus" aria-hidden="true"></i> Proveedor</button>
                        </div>
                </div>
               
               
                <div class="form-group row">    
                    <label for="i_subtotal" class="col-sm-2 col-md-2 col-form-label requerido">Subtotal </label>
                    <div class="col-sm-3 col-md-3">
                        <input type="text" id="i_subtotal" name="i_subtotal" class="form-control validate[required,custom[number]] numeroMoneda input_num" autocomplete="off"/>
                    </div>
                    
                    <div class="col-sm-1 col-md-1"></div>
                    <label for="ch_externo" class="col-sm-2 col-md-2 col-form-label requerido">Externo </label>
                    <div class="col-sm-1 col-md-1"><br>
                        <input type="checkbox" id="ch_externo" name="ch_externo" class="form-control" autocomplete="off"/>
                    </div>
                    <label for="ch_deudores" class="col-sm-2 col-md-2 col-form-label requerido">Deudores Diversos </label>
                    <div class="col-sm-1 col-md-1"><br>
                        <input type="checkbox" id="ch_deudores" name="ch_deudores" class="form-control" autocomplete="off"/>
                    </div>
                      
                </div>
                <div class="form-group row">    
                    <label for="i_iva" class="col-sm-2 col-md-2 col-form-label requerido">I.V.A </label>
                    <div class="col-sm-3 col-md-3">
                        <input type="text" id="i_iva" name="i_iva" class="form-control validate[required,custom[number]] numeroMoneda input_num" autocomplete="off"/>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <label for="i_empleado" class="col-2 col-md-2 col-form-label requerido">Empleado </label>
                   
                        <div class="input-group col-sm-4 col-md-4">
                            <input type="text" id="i_empleado" name="i_empleado" class="form-control validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn" id="b_empleado">
                                <button class="btn btn-primary" type="button" id="b_buscar_empleados" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    
                </div>
                <div class="form-group row">    
                    <label for="i_total" class="col-sm-2 col-md-2 col-form-label requerido">Total </label>
                    <div class="col-sm-3 col-md-3">
                        <input type="text" id="i_total" name="i_total" class="form-control validate[required,custom[number]] input_num" readonly autocomplete="off"/>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <div id="d_estatus" class="alert"></div>
                    </div>
                    
                </div>

            </div> <!--div_contenedor-->
        </div> 
        </form>     

    </div> <!--div_principal-->
    <div class="container-fluid" id="div_proveedor">

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-offset-1 col-md-10" id="div_contenedor">
    <br>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="titulo_ban">Proveedores</div>
            </div>
            <div class="col-sm-12 col-md-7"></div>
            <div class="col-sm-12 col-md-2">
                <button type="button" class="btn btn-info btn-sm form-control" id="b_regresar"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> regresar</button>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-5"></div>
            <div class="col-sm-12 col-md-2">
                <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo_proveedor"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
            </div>
            <div class="col-sm-12 col-md-2">
                <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_proveedor" alt="si"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
            </div>
            <div class="col-sm-12 col-md-2">
                <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_proveedor"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
        </div>
        <br><br>

        <div class="row">
            <div class="col-sm-12 col-md-1"><input id="i_id_sucursal" type="hidden"/></div>
            <div class="col-sm-12 col-md-10">
                <form id="forma_proveedor" name="forma_proveedor">
                <div class="col-sm-12 col-md-12 alert alert-warning" role="alert">
                        * Para que aparezca el nuevo proveedor se deberá asignar una unidad de negocio, comunicate con el administrador.
                        </div>
                    <div class="form-group row">
                        <label for="i_id_proveedor" class="col-sm-2 col-md-2 col-form-label requerido">ID </label>
                        <div class="col-sm-12 col-md-3">
                            <input type="text" class="form-control"  id="i_id_proveedor" autocomplete="off" disabled="disabled">
                        </div>
                        <div class="col-sm-12 col-md-1"></div>
                    </div>
                   <div class="form-group row">
                        <label for="i_nombre" class="col-sm-2 col-md-2 col-form-label requerido">Nombre </label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" class="form-control validate[required]" id="i_nombre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_rfc" class="col-sm-2 col-md-2 col-form-label requerido">RFC</label>
                        <div class="input-group col-sm-12 col-md-4">
                                    <input type="text" id="i_rfc" name="i_rfc" class="form-control validate[required,minSize[13],maxSize[13]]" size="13" autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_rfc" style="margin:0px;" title="Asigna un RFC extrangero: XEXX010101000">
                                            <i class="fa fa-globe" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>

                       
                        <div class="col-sm-10 col-md-2">
                        No Factura
                            <input type="checkbox" id="ch_facturar" name="ch_facturar" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_domicilio" class="col-2 col-md-2 col-form-label requerido">Domicilio </label><br>
                        <div class="col-sm-12 col-md-4">
                            <input type="text" class="form-control validate[required]" id="i_domicilio">
                        </div>

                        <label for="i_num_ext" class="col-1 col-md-1 col-form-label requerido">Ext </label><br>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" class="form-control validate[required]" id="i_num_ext">
                        </div>

                        <label for="i_num_int" class="col-1 col-md-1 col-form-label requerido">Int </label><br>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" class="form-control validate[required]" id="i_num_int">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_cp" class="col-2 col-md-2 col-form-label requerido">Código Postal </label><br>
                        <div class="col-sm-12 col-md-3">
                            <div class="row">
                                
                                <div class="input-group col-sm-12 col-md-9">
                                    <input type="text" id="i_cp" name="i_cp" class="form-control validate[required,custom[integer]]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_cp" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <label for="s_pais" class="col-1 col-md-1 col-form-label requerido">País </label><br>
                        <div class="col-sm-12 col-md-3">
                            <select id="s_pais" name="s_pais" class="form-control validate[required]"></select>
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <label for="i_colonia" class="col-sm-2 col-md-2 col-form-label requerido">Colonia </label>
                        <div class="col-sm-12 col-md-10">
                            <input type="text" class="form-control validate[required]" id="i_colonia" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_id_municipio" class="col-2 col-md-2 col-form-label requerido">Municipio </label><br>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" class="form-control validate[required]" id="i_id_municipio" disabled>
                        </div>
                        <div class="col-sm-2 col-md-8">
                            <input type="text" class="form-control validate[required]" id="i_municipio" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_id_estado" class="col-2 col-md-2 col-form-label requerido">Estado </label><br>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" class="form-control validate[required]" id="i_id_estado" disabled>
                        </div>
                        <div class="col-sm-2 col-md-8">
                            <input type="text" class="form-control validate[required]" id="i_estado" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_id_banco" class="col-2 col-md-2 col-form-label requerido">Banco </label><br>
                        <div class="col-sm-12 col-md-2">
                            <div class="row">
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_id_banco" name="i_id_banco" class="form-control validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_banco" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-8">
                            <input type="text" class="form-control validate[required]" id="i_banco" disabled>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="i_cuenta" class="col-2 col-md-2 col-form-label requerido">Cuenta </label><br>
                        <div class="col-sm-2 col-md-2">
                            <input type="text" class="form-control validate[required]" id="i_cuenta">
                        </div>
                        <label for="i_clabe" class="col-sm-2 col-md-2 col-form-label requerido">Clabe </label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" class="form-control validate[required]" id="i_clabe" >
                        </div>
                        <label for="i_dias_credito" class="col-sm-2 col-md-2 col-form-label requerido">Días de Credito </label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" class="form-control validate[required,custom[integer]]" id="i_dias_credito" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_telefono" class="col-sm-2 col-md-2 col-form-label requerido">Teléfono(s) </label>
                        <div class="col-sm-12 col-md-6">
                            <input type="text" class="form-control validate[required]" id="i_telefono" >
                        </div>
                        <label for="i_extension" class="col-sm-2 col-md-2 col-form-label requerido">Extensión </label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" class="form-control validate[required]" id="i_extension" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_web" class="col-sm-2 col-md-2 col-form-label requerido">Web </label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" class="form-control validate[required]" id="i_web">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_contacto" class="col-sm-2 col-md-2 col-form-label requerido">Contacto </label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" class="form-control validate[required]" id="i_contacto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="i_condiciones" class="col-sm-2 col-md-2 col-form-label requerido">Condiciones </label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" class="form-control validate[required]" id="i_condiciones">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ch_inactivo" class="col-sm-2 col-md-2 col-form-label">Inactivo</label>
                        <div class="col-sm-10 col-md-2">
                            <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                        </div>
                    </div>
                    
                </form>

            </div>
        </div>

    <br>
    </div> <!--div_contenedor-->
</div>      

</div> <!--div_principal-->       
    
</body>




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

<div id="dialog_buscar_gastos" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Gastos</h5>
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
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Ultimo Año</button>
                        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                        </form>
                </div>
                </div>       
                <div class="row">
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group row">
                            <div class="input-group col-sm-12 col-md-12">
                                <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control filtros" placeholder="Sucursal" autocomplete="off"></select>
                            </div>
                        </div> 
                    </div>
                     <div class="col-sm-12 col-md-4">
                        <input type="text" name="i_filtro_gastos" id="i_filtro_gastos" alt="gasto-busqueda" class="filtrar_renglones form-control filtrar_renglones"  placeholder="Filtrar" autocomplete="off"></div>
               
                    <div class="col-sm-12 col-md-1"> </div>
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
                    <table class="tablon"  id="t_gastos">
                      <thead>
                        <tr class="renglon">
                            <th scope="col" width="10%">Unidad de Negocio</th> 
                            <th scope="col" width="10%">Sucursal</th>
                            <th scope="col" width="10%">Departamento</th>
                            <th scope="col" width="10%">Familia</th>
                            <th scope="col" width="10%">Clasificación</th>
                            <th scope="col" width="10%">Fecha</th>
                            <th scope="col" width="5%">Referencia</th>
                            <th scope="col" width="10%">Proveedor</th>
                            <th scope="col" width="10%">Observaciones</th>
                            <th scope="col" width="10%">Total</th>
                            <th scope="col" width="10%">Cuenta</th>
                            <th scope="col" width="5%">Estatus</th>
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

<div id="dialog_justificacion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Justificación de la Cancelación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='form_justificacion' name='form_justificacion'>
            <div class="form-group row">
                <label for="ta_justificacion" class="col-sm-2 col-md-2 col-form-label requerido">Justificación </label>
                <div class="col-sm-9 col-md-9">
                    <textarea  id="ta_justificacion" name="ta_justificacion" class="form-control validate[required]" autocomplete="off"></textarea>
                </div>
            </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger btn-sm" id="b_cancelar_registro">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!---->
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

<div id="dialog_buscar_cp" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Codigos Postales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label for="s_estados">Estado</label>
                    <select class="form-control coti" id="s_estados" style="width: 100%;"></select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label for="s_municipios">Municipio</label>
                    <select class="form-control coti" id="s_municipios" style="width: 100%;"></select>
                </div>
                <div class="col-sm-12 col-md-4"><input type="text" name="i_filtro_cp" id="i_filtro_cp" class="form-control filtrar_renglones" alt="renglon_cp" placeholder="Filtrar" autocomplete="off"></div>
            </div>                               
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cp">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Código Postal</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Municipio</th>
                          <th scope="col">Colonia</th>
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

<div id="dialog_buscar_banco" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Bancos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_banco" id="i_filtro_banco" class="form-control filtrar_renglones" alt="renglon_banco" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_banco">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Clave</th>
                          <th scope="col">Banco</th>
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
<script src="vendor/select2/js/select2.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>

<script>
    var idGasto=0;
    var tipoMov=0;
    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var modulo = 'GASTOS';
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var totalPartidas = 0;
    var idProveedor=0;
    var proveedorOriginal='';
    var tipo_mov=0;
    $(function()
    {
    
       muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
       muestraSucursalesPermiso('s_id_sucursal', idUnidadActual, modulo,idUsuario);
       muestraAreasAcceso('s_id_area');
       muestraSelectFamiliaGastos('s_familia_gastos');
       muestraCuentasBancos('s_cuenta', 0);
       muestraTiposGasto('s_tipo_gasto');
       $('#b_cancelar').prop("disabled", true);
       $("#div_proveedor").css({left : "-101%"});
       $('#s_clasificacion_gastos').prop('disabled',true);
       $("#s_id_departamento").prop("disabled", true);

       $('#b_regresar').on('click',function(){
           
           $("#div_proveedor").animate({left : "-101%"}, 500, 'swing');
           $('#div_principal').animate({left : "0%"}, 600, 'swing');
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
           if(idSucursal > 0 && idArea > 0){
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }
        });


       $('#s_id_area').change(function()
       {

            var idSucursal = $('#s_id_sucursal').val();
            var idArea = $('#s_id_area').val();
            if(idSucursal > 0 && idArea > 0){
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }
           

        });

       $(document).on('change','#s_familia_gastos',function(){
           var idFamiliaGasto = $(this).val();
           if(idFamiliaGasto > 0){
            muestraSelectClasificacionGastos('s_clasificacion_gastos',idFamiliaGasto);
            $('#s_clasificacion_gastos').prop('disabled',false);
           }
           
       }); 

       $('#s_cuenta').change(function(){
            idBanco=$('#s_cuenta option:selected').attr('alt');
        });
       /************************BUSCA SOLO LOS EMPLEADOS DE LA UNIDAD ACTUAL ************* */
       $('#b_buscar_empleados').on('click',function(){
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
                    'idUnidad':$('#s_id_unidad').val(),
                    'filtroId' : $('#i_filtro_id').val(),
                    'filtroNombre' : $('#i_filtro_nombre').val()
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
                              
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    
                    mandarMensaje('Error en el sistema');
                }
            });
        });

         

        $('#t_empleados').on('click', '.renglon_empleados', function() {
            
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_empleado').attr('alt',id).val(id+' - '+nombre);
           

            $('#dialog_buscar_empleados').modal('hide');

        });

        $('#b_nuevo').click(function()
        {
            limpiarForma();
        });

        $('#b_guardar').click(function()
        {   $('#b_guardar').prop('disabled',true);
        
            guardar();
        });

        
        function guardar()
        {
            if($("#form_gastos").validationEngine('validate'))
            {
                    
                    $.ajax({
                        type: 'POST',
                        url: 'php/gastos_guardar.php',
                        dataType:"json", 
                        data: {
                        'datos':obtenerDatos()

                        },
                        success: function(data) 
                        {
                            if(data>0){
                                mandarMensaje("El gasto con registro " + data +  " se guardo de forma adecuada");
                                muestraRegistro(data);
                            }else{
                                mandarMensaje('Ocurrio un error durante el guardadó');
                                $('#b_guardar').prop('disabled',false);
                            }
                           
                                
                        },
                        error: function (xhr) {
                            console.log('php/gastos_guardar.php--->' + JSON.stringify(xhr));
                            mandarMensaje('Ocurrio un error al guardar el registro, intentelo nuevamente');
                            $('#b_guardar').prop('disabled',false);
                        }
                    });

            }else{
                $('#b_guardar').prop('disabled',false);
            }

        }

        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var paq = {
                        'tipoMov'   : tipoMov,
                        'idUsuario' : idUsuario,
                        'idGasto': idGasto,
                        'idUnidad': $('#s_id_unidad').val(),
                        'idSucursal': $('#s_id_sucursal').val(),
                        'idArea': $('#s_id_area').val(),
                        'idDepto': $('#s_id_departamento').val(),
                        'idProveedor': $('#i_proveedor').attr('alt'),
                        'fecha': $('#i_fecha').val(),
                        'tipoGasto':$('#s_tipo_gasto').val(),
                        'referencia':$('#i_referencia').val(),
                        'familiaGasto': $('#s_familia_gastos').val(),
                        'clasificacionGasto': $('#s_clasificacion_gastos').val(),
                        'nombreClasificacion': $('#s_clasificacion_gastos option:selected').text(),
                        'concepto': $('#i_concepto').val(),
                        'idCuenta': $('#s_cuenta').val(),
                        'idBanco':idBanco,
                        'observaciones' :  $('#ta_observaciones').val(),
                        'deudoresDiversos' : $("#ch_deudores").is(':checked') ? 1 : 0,
                        'idEmpleado': $('#i_empleado').attr('alt'),
                        'nomEmpleado': $('#i_empleado').val(),
                        'subtotal':quitaComa($('#i_subtotal').val()),
                        'iva': quitaComa($('#i_iva').val()),
                        'total': quitaComa($('#i_total').val())
                }
                paquete.push(paq);
              
            return paquete;
        }    

   
        $('#i_subtotal').change(function()
        {
            calcularMontos();
        });

        $('#i_iva').change(function()
        {
            calcularMontos();
        });

        function calcularMontos()
        {   var subtotal=0, iva=0;
            if($('#i_subtotal').val()!=''){
                subtotal = quitaComa($('#i_subtotal').val());
            }
            if($('#i_iva').val()!=''){
                iva = quitaComa($('#i_iva').val());
            }
            
            $('#i_total').val(formatearNumero(parseFloat(subtotal)+parseFloat(iva)));

        }

        function limpiarForma()
        {
            tipoMov=0;
            $('#form_gastos').validationEngine('hide');
            $('#form_gastos').find('input,select,textarea').val('').prop('disabled',false);
           
            limpiarCombos();

            $("#s_id_unidad").prop("disabled", false);
            $("#s_id_sucursal").prop("disabled", false);
            $("#s_id_area").prop("disabled", false);
            $("#s_id_departamento").prop("disabled", true);
            $("#s_familia_gastos").prop("disabled", false);
            $("#s_clasificacion_gastos").prop("disabled", true);

            muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursal', idUnidadActual, modulo,idUsuario);
            muestraAreasAcceso('s_id_area');
            muestraSelectFamiliaGastos('s_familia_gastos');
            $('#s_clasificacion_gastos').prop('disabled',true);
            muestraCuentasBancos('s_cuenta', 0);
            muestraTiposGasto('s_tipo_gasto');

            $('#i_fecha').val(hoy);
            $('#d_estatus').removeAttr('class').text('');
            $('#i_empleado').attr('alt',0).val('').prop('readonly',true);
            $('#b_empleado').show();
            $('#ch_externo').prop('checked', false);
            $('#ch_deudores').prop('checked', false);
            $('#b_buscar_empleados').prop("disabled", false);
            $('#b_guardar').prop("disabled", false);
            $('#b_cancelar').prop("disabled", true);

        }

        $('#b_buscar').click(function()
        {
            $('.renglon_orden_compra').remove();
            muestraSelectUnidades(matriz, 's_filtro_unidad', idUnidadActual);
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
            $('#s_filtro_unidad').prop('disabled',false);
            $('#s_filtro_sucursal').prop('disabled',false);
            $('#i_filtro_gastos').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');
            $('.gasto-busqueda').remove();
            $('#dialog_buscar_gastos').modal('show');
           
        });

        $(document).on('change','#s_filtro_unidad',function(){
            var idUnidad=$(this).val();
            if(idUnidad!= ''){
                $('.img-flag').css({'width':'50px','height':'20px'});
            }
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidad,modulo,idUsuario);
            $('#i_filtro_gastos').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');
            $('.gasto-busqueda').remove();
            
        });

    

        $(document).on('change', '#s_filtro_sucursal',function(){
            buscarGastos();
       });

        $('#i_fecha_inicio').change(function()
        {

            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscarGastos();
            }

        });

        $('#i_fecha_fin').change(function(){  
                buscarGastos();
        });

        function buscarGastos()
        {
            $('.gasto-busqueda').remove();

            $.ajax({
                type: 'POST',
                url: 'php/gastos_buscar.php',
                dataType:"json", 
                data:{
                    'idUnidadNegocio': $('#s_filtro_unidad').val(),
                    'idSucursal':$('#s_filtro_sucursal').val(),
                    'fechaInicio':$('#i_fecha_inicio').val(),
                    'fechaFin':$('#i_fecha_fin').val()
                },
                success: function(data)
                {
                    console.log(data);
                    for(var i=0; data.length>i; i++)
                    {
                        var estatus='';
                        var gasto = data[i];
                            
                            if(parseInt(data[i].estatus) == 1){

                                estatus='Activa';
                            }else{
                                estatus='Cancelada';
                            }
                        
                        var html = "<tr class='gasto-busqueda " + gasto.tipo_gasto + " " + estatus + "' alt='" + gasto.id + "'>";
                        html += "<td>" + gasto.unidad + "</td>";
                        html += "<td>" + gasto.sucursal + "</td>";
                        html += "<td>" + gasto.departamento + "</td>";
                        html += "<td>" + gasto.familia_gastos + "</td>";
                        html += "<td>" + gasto.clasificacion_gasto + "</td>";
                        html += "<td>" + gasto.fecha + "</td>";
                        html += "<td>" + gasto.referencia + "</td>";
                        html += "<td>" + gasto.proveedor + "</td>";
                        html += "<td>" + gasto.observaciones + "</td>";
                        html += "<td>" + gasto.total + "</td>";
                        html += "<td>" + gasto.cuenta + "</td>";
                        html += "<td>" + estatus + "</td>";
                        html += "</tr>";

                        $('#t_gastos tbody').append(html);
                    
                    }
                
         
                },
                error: function (xhr)
                {
                    console.log('php/gastos_buscar.php->'+JSON.stringify(xhr));
                    mandarMensaje('Ocurrio un error al buscar la gastos');
                }
            });

        }

       
        $("#t_gastos").on('click',".gasto-busqueda",function()
        {    tipoMov=1;
            $('#form_gastos').find('input,select,textarea').prop('disabled',true);
            $('#b_guardar').prop('disabled',true);
            idGasto = $(this).attr('alt');
            muestraRegistro(idGasto);         
        });

        function muestraRegistro(idGasto){
            $.ajax({
                type: 'POST',
                url: 'php/gastos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idGasto': idGasto
                },
                success: function(data)
                {
            
                    for(var i=0; data.length>i; i++)
                    {
                        var gasto = data[i];
                        $('#d_estatus').removeAttr('class');
                        idGasto = gasto.id;
                        idUnidad = gasto.id_unidad_negocio;
                        idSucursal = gasto.id_sucursal;
                        idArea = gasto.id_area;
                        idDepartamento = gasto.id_departamento;
                        nombreProveedor = gasto.nombre_proveedor;

                        $('#i_id_gasto').val(gasto.id);
                        limpiarCombos();

                        $('#s_id_unidad').val(idUnidad);
                        $("#s_id_unidad").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

                        optionSurucursal = new Option(gasto.sucursal, gasto.id_sucursal, true, true);
                        $('#s_id_sucursal').append(optionSurucursal).trigger('change');

                        optionArea = new Option(gasto.are, gasto.id_area, true, true);
                        $('#s_id_area').append(optionArea).trigger('change');

                        optionDepto = new Option(gasto.departamento, gasto.id_departamento, true, true);
                        $('#s_id_departamento').append(optionDepto).trigger('change');

                        optionFamilia = new Option(gasto.familia_gastos, gasto.id_familia_gasto, true, true);
                        $('#s_familia_gastos').append(optionFamilia).trigger('change');

                        optionClasificacion = new Option(gasto.clasificacion_gasto, gasto.id_clasificacion, true, true);
                        $('#s_clasificacion_gastos').append(optionClasificacion).trigger('change');

                        optionCuenta = new Option(gasto.banco+' - '+gasto.cuenta, gasto.id_cuenta_banco, true, true);
                        $('#s_cuenta').append(optionCuenta).trigger('change');


                        $("#s_id_unidad").prop("disabled", true)
                        $("#s_id_sucursal").prop("disabled", true)
                        $("#s_id_area").prop("disabled", true)
                        $("#s_id_departamento").prop("disabled", true)

                        $('#i_proveedor').attr('alt', gasto.id_proveedor).val( gasto.proveedor)
                        $('#i_fecha').val( gasto.fecha)
                        muestraTiposGasto('s_tipo_gasto');
                        $('#s_tipo_gasto').val( gasto.tipo)
                        $('#i_concepto').val( gasto.concepto)
                        $('#i_referencia').val( gasto.referencia)
                        $('#s_cuenta').attr('alt', gasto.id_banco)
                        idBanco = gasto.id_banco;
                        $('#ta_observaciones').val( gasto.observaciones)
                        if( gasto.deudor==0){
                            $('#ch_deudores').prop('checked', false);
                        } else {
                            $('#ch_deudores').prop('checked', true);
                        }

                        if(gasto.id_trabajador==0){
                            $('#i_empleado').attr('alt',0).val(gasto.nombre).prop('readonly',false);
                            $('#b_empleado').hide(); 
                            $('#ch_externo').prop('checked', true);

                        }else{

                            $('#i_empleado').attr('alt',0).val('').prop('readonly',true);
                            $('#b_empleado').show();
                            $('#b_buscar_empleados').prop('disabled',true); 
                            $('#ch_externo').prop('checked', false);
                        }
                        
                        $('#i_empleado').attr('alt',gasto.id_empleado).val(gasto.nombre)
                    
                        $('#i_subtotal').val(formatearNumero(gasto.subtotal));
                        $('#i_iva').val(formatearNumero(gasto.iva));
                        $('#i_total').val(formatearNumero(gasto.total));

                        if(data[0].estatus == 1){
                            $('#d_estatus').addClass('alert alert-sm alert-info').text('ACTIVA');
                            if(gasto.bandera_cancela == 1){
                                if(gasto.clasificacion_gasto == 'Vales de Gasolina' || gasto.clasificacion_gasto == 'Caja Chica')
                                {
                                    deshabilita();
                                    mandarMensaje('El gasto no se puede cancelar debido a la clasificación. Si desea cancelarlo favor de comunicarse con Denken');
                                }else{
                                    habilita();
                                }
                            }else{
                                deshabilita();
                            }

                        }

                        if(data[0].estatus == 0){
                            $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
                            if(gasto.bandera_cancela == 1){
                                if(gasto.clasificacion_gasto == 'Vales de Gasolina' || gasto.clasificacion_gasto == 'Caja Chica')
                                {
                                    deshabilita();
                                    mandarMensaje('El gasto no se puede cancelar debido a la clasificación. Si desea cancelarlo favor de comunicarse con Denken');
                                }else{
                                    habilita();
                                }
                            }else{
                                deshabilita();
                            }
                        }


                        $('#dialog_buscar_gastos').modal('hide');

                    }
         
                },
                error: function (xhr)
                {
                    console.log('php/gastos_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error al buscar información del gasto');
                }

            });
        }

        function habilita(){
            $('#b_guardar').prop('disabled',true);
            $('#b_cancelar').prop('disabled',false);
        }

        function deshabilita(){
            $('#b_guardar').prop('disabled',true);
            $('#b_cancelar').prop('disabled',true);
        }

        $('#b_cancelar').on('click',function(){
           
           $('#dialog_justificacion').modal('show');
           $('#b_cancelar_registro').prop('disabled',false);
           $('#form_justificacion').validationEngine('hide');
           $('#ta_justificacion').prop('disabled',false);
       });

       $(document).on('click','#b_cancelar_registro',function(){

           $('#b_cancelar_registro').prop('disabled',true);
           if($('#form_justificacion').validationEngine('validate')){
               tipoMov=1;
               guardar();
               $('#dialog_justificacion').modal('hide');
           }else{
               $('#b_cancelar_registro').prop('disabled',false);
           }
           
       });


        function limpiarCombos()
        {
            $('#s_id_sucursal').html('');
            $('#s_id_area').html('');
            $('#s_id_departamento').html('');
            $('#s_clasificacion_gastos').html('');
            $('#s_familia_gasto').html('');
            $('#s_cuenta').html('');
        }

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

        $('#b_buscar_proveedores,#b_buscar_proveedor').click(function()
        {   $('#t_proveedores tbody').empty();
            var forma = $(this).attr('alt');
            $('#i_filtro_proveedor').val('');
            if(forma=='si'){
                muestraModalProveedoresUnidades('renglon_proveedor','t_proveedores tbody','dialog_proveedores', $('#s_id_unidad').val());
    
            }else{
                muestraModalProveedoresUnidades('renglon_proveedores','t_proveedores tbody','dialog_proveedores', $('#s_id_unidad').val());
    
            }
        });

        $('#t_proveedores').on('click', '.renglon_proveedores', function()
        {
            
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_proveedor').attr('alt',id).val(nombre);
            $('#dialog_proveedores').modal('hide');

        });
/**************************  AGREGAR UN PROVEEDOR ********************************************* */
        $('#b_agregar_proveedor').on('click',function(){
            idProveedor=0;
            proveedorOriginal='';
            tipo_mov=0;
            $("#div_principal").animate({left : "-101%"}, 500, 'swing');
            $('#div_proveedor').animate({left : "0%"}, 600, 'swing');
            muestraSelectPaises('s_pais');
            $('#dialog_agregar_proveedor').modal('show');
            $('#ch_inactivo').prop('checked',false).prop('disabled',true);
            
        });

        $('#b_rfc').on('click',function(){
            
            $('#i_rfc').val('XEXX010101000');

            if($('#s_pais').val()==141){

                $('#s_pais').val(236).prop('disabled',true);
                $('#s_pais').select2({placeholder: $(this).data('elemento')});
            }
            
        });

        $('#t_proveedores').on('click', '.renglon_proveedor', function() {
           
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('disabled', false);
            idProveedor = $(this).attr('alt');
            $('#dialog_proveedores').modal('hide');
            muestraRegistroProveedor();


        });
        function muestraRegistroProveedor(){ 
          
          $.ajax({
              type: 'POST',
              url: 'php/proveedores_buscar_id.php',
              dataType:"json", 
              data:{
                  'idProveedor':idProveedor
              },
              success: function(data) {
                 
                  idProveedor=data[0].id;
                  proveedorOriginal=data[0].rfc;
                 
                  $('#i_id_proveedor').val(idProveedor);
                  $('#i_nombre').val(data[0].nombre);
                  $('#i_rfc').val(data[0].rfc);
                  $('#i_domicilio').val(data[0].domicilio);
                  $('#i_cp').val(data[0].cp);
                  $('#i_colonia').val(data[0].colonia);
                  $('#i_num_ext').val(data[0].num_ext);
                  $('#i_num_int').val(data[0].num_int);
                  if (data[0].facturable == 0) {
                      $('#ch_facturable').prop('checked', false);
                  } else {
                      $('#ch_facturable').prop('checked', true);
                  }

                  if(data[0].id_pais != 0)
                  {
                      $('#s_pais').val(data[0].id_pais);
                      $('#s_pais').select2({placeholder: $(this).data('elemento')});
                  }else{
                      $('#s_pais').val('');
                      $('#s_pais').select2({placeholder: 'Selecciona'});
                  }
                  $('#i_id_estado').val(data[0].id_estado);
                  $('#i_estado').val(data[0].estado);
                  $('#i_id_municipio').val(data[0].id_municipio);
                  $('#i_municipio').val(data[0].municipio);
                  $('#i_id_banco').val(data[0].id_banco);
                  $('#i_banco').val(data[0].banco);
                  $('#i_cuenta').val(data[0].cuenta);
                  $('#i_clabe').val(data[0].clabe);
                  $('#i_dias_credito').val(data[0].dias_credito);
                  $('#i_telefono').val(data[0].telefono);

                  $('#i_extension').val(data[0].extension);
                  $('#i_web').val(data[0].web);
                  $('#i_contacto').val(data[0].contacto);
                  $('#i_dias_credito').val(data[0].dias_credito);
                  $('#i_condiciones').val(data[0].condiciones);
                  $('#i_grupo').val(data[0].grupo);

                  if (data[0].inactivo == 0) {
                      $('#ch_inactivo').prop('checked', false);
                  } else {
                      $('#ch_inactivo').prop('checked', true);
                  }
                 
              },
              error: function (xhr) {
                  console.log('php/proveedores_buscar_id.php-->'+JSON.stringify(xhr));
                  mandarMensaje(xhr.responseText);
              }
          });
      }

      $('#b_guardar_proveedor').click(function(){
        
         $('#b_guardar_proveedor').prop('disabled',true);

          if ($('#forma_proveedor').validationEngine('validate')){
              if($('#i_rfc').val()!='XEXX010101000'){
                  verificar();
              }else{
                  guardarProveedor();
              }
              

          }else{
             
              $('#b_guardar_proveedor').prop('disabled',false);
          }
      });


      function verificar(){

          $.ajax({
              type: 'POST',
              url: 'php/proveedores_verificar.php',
              dataType:"json", 
              data:  {'rfc':$('#i_rfc').val()},
              success: function(data) 
              {
                  if(data == 1){
                      
                      if (tipo_mov == 1 && proveedorOriginal === $('#i_rfc').val()) {
                        guardarProveedor();
                      } else {

                          mandarMensaje('El RFC : '+ $('#i_rfc').val()+' ya existe intenta con otro');
                          $('#i_rfc').val('');
                          $('#b_guardar_proveedor').prop('disabled',false);
                      }
                  } else {
                    guardarProveedor();
                  }
              },
              error: function (xhr) {
                  mandarMensaje(JSON.stringify(xhr));
                  //mandarMensaje(xhr.responseText);
              }
          });
      }

      
      /* funcion que manda a generar la insecion o actualizacion de un registro */    
      function guardarProveedor(){

       $.ajax({
              type: 'POST',
              url: 'php/proveedores_guardar.php', 
              dataType:"json", 
              data: {
                      'datos':obtenerDatosProveedor()

              },
              //una vez finalizado correctamente
              success: function(data){
                
                  if (data > 0 ) {
                      if (tipo_mov == 0){
                          
                          mandarMensaje('Se guardó el nuevo registro');
                          $('#b_nuevo_proveedor').click();
  
                      }else{
                              
                          mandarMensaje('Se actualizó el registro');
                          $('#b_nuevo_proveedor').click();
                             
                      }
                    

                  }else{
                         
                      mandarMensaje('Error en el guardado');
                      $('#b_guardar_proveedor').prop('disabled',false);
                  }

              },
                  //si ha ocurrido un error
               error: function(xhr){
                 
                  mandarMensaje("Ha ocurrido un error.");
                  $('#b_guardar_proveedor').prop('disabled',false);
              }
          });
         
      }
      /* obtine los datos y los guarda en un arreglo*/
      function obtenerDatosProveedor(){
          var paquete = [];
              paquete[0]= 1;
          var cont = 0;
          var paq = {
                  'tipo_mov' : tipo_mov,
                  'idProveedor' : idProveedor,
                  'nombre' : $('#i_nombre').val(),
                  'rfc' : $('#i_rfc').val(),
                  'domicilio' : $('#i_domicilio').val(),
                  'cp' : $('#i_cp').val(),
                  'idColonia' : $('#i_colonia').val(),
                  'numInt' : $('#i_num_int').val(),
                  'numExt' : $('#i_num_ext').val(),
                  'facturable' : $("#ch_facturable").is(':checked') ? 1 : 0,
                  'idPais' : $('#s_pais').val(),
                  'idEstado' : $('#i_id_estado').val(),
                  'idMunicipio' : $('#i_id_municipio').val(),
                  'idBanco' : $('#i_id_banco').val(),
                  'cuenta' : $('#i_cuenta').val(),
                  'clabe' : $('#i_clabe').val(),
                  'diasCredito' : $('#i_dias_credito').val(),
                  'telefono' : $('#i_telefono').val(),
                  'extension' : $('#i_extension').val(),
                  'web' : $('#i_web').val(),
                  'contacto' : $('#i_contacto').val(),
                  'condiciones' : $('#i_condiciones').val(),
                  'grupo' : $('#i_grupo').val(),
                  'inactivo' : $("#ch_inactivo").is(':checked') ? 1 : 0,
                  'idUsuario' : idUsuario,
                  'modulo' : 'G'
              }

              paquete.push(paq);
            
          return paquete;
      }   
      
      //************Busca los cp por estado y municipio */
      $('#b_buscar_cp').on('click',function(){

          $('#i_filtro_cp').val('');
          $('.renglon_cp').remove();
          muestraSelectEstados('s_estados');
          muestraSelectMunicipios('s_municipios',0);
          $('#dialog_buscar_cp').modal('show'); 

      });

      $(document).on('change','#s_estados,#s_municipios',function(){
          buscarCp();
      });

      function buscarCp(){
         
          $('#i_filtro_cp').val('');
          $('.renglon_cp').remove();

          $.ajax({

              type: 'POST',
              url: 'php/codigo_postal_buscar.php',
              dataType:"json", 
              data:{
                  'idEstado':$('#s_estados').val(),
                  'idMunicipio': $('#s_municipios').val()
              },
              success: function(data) {
              
              if(data.length != 0){

                  $('.renglon_cp').remove();
              
                  for(var i=0;data.length>i;i++){

                      ///llena la tabla con renglones de registros

                      var html='<tr class="renglon_cp" alt="'+data[i].id_colonia+'" alt2="'+data[i].colonia+'" alt3="'+data[i].codigo_postal+'" alt4="'+data[i].estado+'" alt5="'+data[i].id_estado+'"alt6="'+data[i].municipio+'"alt7="'+data[i].id_municipio+'">\
                                  <td data-label="ID">' + data[i].codigo_postal+ '</td>\
                                  <td data-label="Clave">' + data[i].estado+ '</td>\
                                  <td data-label="Descripción">' + data[i].municipio+ '</td>\
                                  <td data-label="Tallas">' + data[i].colonia+ '</td>\
                              </tr>';
                      ///agrega la tabla creada al div 
                      $('#t_cp tbody').append(html);   
                           
                  }
              }else{

                  mandarMensaje('No se encontró información');
              }

              },
              error: function (xhr) {
                  console.log('php/codigo_postal_buscar.php-->'+JSON.stringify(xhr));
                  mandarMensaje('Error en el sistema');
              }
          });
      }

      $('#t_cp').on('click', '.renglon_cp', function() {

          var  idColonia = $(this).attr('alt');
          var  colonia = $(this).attr('alt2');
          var  cp = $(this).attr('alt3');
          var  estado = $(this).attr('alt4');
          var  idEstado = $(this).attr('alt5');
          var  municipio = $(this).attr('alt6');
          var  idMunicipio = $(this).attr('alt7');

          $('#i_cp').val(cp);
          $('#i_colonia').val(colonia).attr('alt',idColonia);
          $('#i_id_estado').val(idEstado);
          $('#i_id_municipio').val(idMunicipio);
          $('#i_estado').val(estado);
          $('#i_municipio').val(municipio);
             
          $('#dialog_buscar_cp').modal('hide');

      });

       
      //************Busca los bancos activos */
      $('#b_buscar_banco').on('click',function(){
          
          $('#i_filtro_banco').val('');
          $('.renglon_banco').remove();

          $.ajax({

              type: 'POST',
              url: 'php/bancos_buscar.php',
              dataType:"json", 
              data:{
                  'estatus':1,

              },
              success: function(data) {
              
              if(data.length != 0){

                      $('.renglon_banco').remove();
              
                      for(var i=0;data.length>i;i++){

                          ///llena la tabla con renglones de registros

                          var html='<tr class="renglon_banco" alt="'+data[i].id+'" alt2="'+data[i].clave+'" alt3="'+data[i].banco+'">\
                                      <td data-label="ID">' + data[i].id+ '</td>\
                                      <td data-label="Clave">' + data[i].clave+ '</td>\
                                      <td data-label="Descripción">' + data[i].banco+ '</td>\
                                  </tr>';
                          ///agrega la tabla creada al div 
                          $('#t_banco tbody').append(html);   
                          $('#dialog_buscar_banco').modal('show');   
                      }
              }else{

                      mandarMensaje('No se encontró información');
              }

              },
              error: function (xhr) {
                  console.log('php/bancos_buscar.php-->'+JSON.stringify(xhr));
                  mandarMensaje('Error en el sistema');
              }
          });
      });

      $('#t_banco').on('click', '.renglon_banco', function() {

          var  id = $(this).attr('alt');
          var  clave = $(this).attr('alt2');
          var  banco = $(this).attr('alt3');

          $('#i_id_banco').val(id);
          $('#i_banco').val(banco);
             
          $('#dialog_buscar_banco').modal('hide');

      });

       
      
     
      

      $(document).on('click','#b_nuevo_proveedor',function(){
          limpiarProveedor();
      });
      /* Limpia el modulo comple al dar click en nuevo o guardad*/
      function limpiarProveedor(){
       
          idProveedor=0;
          proveedorOriginal='';
          tipo_mov=0;
          $('#forma_proveedor input').val('');
          $('#i_familia').attr('alt',0);
          $('#form_proveedor').validationEngine('hide');
          $('#b_guardar_proveedor').prop('disabled',false);
          $('#ch_inactivo').prop('checked',false).prop('disabled',true);
          muestraSelectPaises('s_pais');
          $('#s_pais').prop('disabled',false);
          
      }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Gastos Ultimo Año');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('GASTOS');
            
            $("#f_imprimir_excel").submit();
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

      

        $("#i_subtotal,#i_iva").inputFilter(function(value){
            return /^-?\d*[.,]?\d{0,2}$/.test(value)
        });

    });

</script>

</html>