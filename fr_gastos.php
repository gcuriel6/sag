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
      left:-101%;
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
        min-width: 95%;
        max-width: 95%;
    }
    #dialog_agregar_proveedor > .modal-lg{
        min-width: 90%;
        max-width: 90%;
        z-index :0;
    }
    #dialog_buscar_requisiciones > .modal-lg{
        min-width: 95%;
        max-width: 95%;
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
        #dialog_buscar_requisiciones > .modal-lg{
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
            <div class="col-md-1"><input id="i_proveedor_n" type="hidden"/></div>
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
                    <label for="i_fecha" class="col-sm-2 col-md-2 col-form-label requerido">Fecha Gasto </label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" id="i_fecha" name="i_fecha" class="form-control fecha validate[required]" readonly autocomplete="off"/>
                    </div>
                    <div class="col-sm-2 col-md-2"></div>
                    <label for="i_folio" class="col-2 col-md-2 col-form-label">Folio </label>
                   
                    <div class="input-group col-sm-2 col-md-2">
                        <input type="text" id="i_folio" name="i_folio" class="form-control validate[custom[number]]" readonly autocomplete="off">
                        <div class="input-group-btn" id="b_empleado">
                            <button class="btn btn-primary" type="button" id="b_buscar_requisiciones_gastos" style="margin:0px;">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="s_id_unidad" class="col-sm-2 col-md-2 col-form-label requerido">Unidad de Negocio </label>
                    <div class="col-sm-3 col-md-3">
                        <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <label for="s_id_area" class="col-sm-2 col-md-2 col-form-label requerido">Área </label>
                    <div class="col-sm-4 col-md-4">
                        <select id="s_id_area" name="s_id_area" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="s_id_sucursal" class="col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                    <div class="col-sm-12 col-md-3">
                        <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <label for="s_id_departamento" class="col-sm-2 col-md-2 col-form-label requerido">Departamento </label>
                    <div class="col-sm- col-md-4">
                        <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="s_familia_gastos" class="col-sm-2 col-md-2 col-form-label requerido">Familia </label>
                    <div class="col-sm-12 col-md-3">
                        <select id="s_familia_gastos" name="s_familia_gastos" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <label for="s_cuenta" id="l_s_cuenta" class="col-sm-2 col-md-2 col-form-label requerido">Cuenta</label>
                        <div class="col-sm-12 col-md-4">
                            <select id="s_cuenta" name="s_cuenta" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" style="width:100%;"></select>
                     </div>
                    
                </div>

                <div class="form-group row"> 
                    <label for="s_clasificacion_gastos" class="col-sm-2 col-md-2 col-form-label requerido">Clasificación </label>
                    <div class="col-sm-12 col-md-3">
                        <select id="s_clasificacion_gastos" name="s_clasificacion_gastos" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div> 
                    <div class="col-sm-1 col-md-1"></div>  
                    <label for="i_concepto" class="col-sm-2 col-md-2 col-form-label requerido">Concepto </label>
                    <div class="col-sm-4 col-md-4">
                        <input type="text" id="i_concepto" name="i_concepto" class="form-control form-control-sm validate[required]" autocomplete="off"/>
                    </div>
                    
                </div>
                <div class="form-group row">    
                    <label for="s_tipo_gasto" class="col-sm-2 col-md-2 col-form-label requerido">Tipo </label>
                    <div class="col-sm-2 col-md-2">
                        <select id="s_tipo_gasto" name="s_tipo_gasto" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <label for="i_fecha_referencia" class="col-sm-2 col-md-2 col-form-label requerido">Fecha Referencia</label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" id="i_fecha_referencia" name="i_fecha_referencia" class="form-control fecha validate[required]" readonly autocomplete="off"/>
                    </div>
                    <div class="col-sm-1 col-md-1"></div> 
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
                    <label for="ch_externo" class="col-sm-12 col-md-2">Externo <input type="checkbox" id="ch_externo" name="ch_externo"/></label>
                    <label for="ch_deudores" class="col-sm-12 col-md-3 col-form-label">Deudores Diversos <input type="checkbox" id="ch_deudores" name="ch_deudores" /> </label>
                </div>
                <div class="form-group row">    
                    <label for="i_iva" class="col-sm-2 col-md-2 col-form-label requerido">I.V.A </label>
                    <div class="col-sm-3 col-md-3">
                        <input type="text" id="i_iva" name="i_iva" class="form-control validate[required,custom[number]] numeroMoneda input_num" autocomplete="off"/>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <!--NJES Jan/21/2020 Se pone obligatorio el empleado ya sea interno o externo-->
                    <!--NJES Jan/27/2020 Se pone obligatorio el empleado solo cuando sera deudor diverso-->
                    <label for="i_empleado" class="col-2 col-md-2 col-form-label" id="label_empleado">Empleado </label>
                   
                        <div class="input-group col-sm-4 col-md-4">
                            <input type="text" id="i_empleado" name="i_empleado" class="form-control" readonly autocomplete="off">
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
                    <label for="i_fecha_aplicacion" class="col-sm-2 col-md-2 col-form-label requerido">Fecha Aplicación</label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" id="i_fecha_aplicacion" name="i_fecha_aplicacion" class="form-control fecha validate[required]" readonly autocomplete="off"/>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div id="d_estatus" class="alert"></div>
                    </div>
                </div>

                <div class="form-group row" id="div_requis_diferentes_fg">
                    <div class="col-md-12">
                        <table class="tablon"  id="t_partidas_requis">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Familia Gasto</th>
                                    <th scope="col">Clasificación</ths>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Costo Unitario</th>
                                    <th scope="col">% Iva</th>
                                    <th scope="col">Iva</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
                        * Por default se le asignará acceso a la unidad de negocio de la cual se dio de alta al proveedor.
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
                                    <input type="text" class="form-control validate[required]" id="i_nombre" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_rfc" class="col-sm-2 col-md-2 col-form-label requerido">RFC</label>
                                <div class="input-group col-sm-12 col-md-4">
                                            <input type="text" id="i_rfc" name="i_rfc" class="form-control validate[required,minSize[12],maxSize[13],custom[onlyLetterNumber]]" size="13" autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_rfc" style="margin:0px;" title="Asigna un RFC extrangero: XEXX010101000">
                                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>

                            
                                <div class="col-sm-10 col-md-2">
                                No Factura
                                    <input type="checkbox" id="ch_facturar" name="ch_facturar" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_domicilio" class="col-2 col-md-2 col-form-label">Domicilio </label><br>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control" id="i_domicilio" autocomplete="off">
                                </div>

                                <label for="i_num_ext" class="col-1 col-md-1 col-form-label">Ext </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control" id="i_num_ext" autocomplete="off">
                                </div>

                                <label for="i_num_int" class="col-1 col-md-1 col-form-label">Int </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control" id="i_num_int" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_cp" class="col-2 col-md-2 col-form-label">Código Postal </label><br>
                                <div class="col-sm-12 col-md-3">
                                    <div class="row">
                                        
                                        <div class="input-group col-sm-12 col-md-9">
                                            <input type="text" id="i_cp" name="i_cp" class="form-control validate[custom[integer]]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_cp" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="s_pais" class="col-1 col-md-1 col-form-label">País </label><br>
                                <div class="col-sm-12 col-md-3">
                                    <select id="s_pais" name="s_pais" class="form-control" style="width:100%;" autocomplete="off"></select>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <label for="i_colonia" class="col-sm-2 col-md-2 col-form-label">Colonia </label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" id="i_colonia" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_municipio" class="col-2 col-md-2 col-form-label">Municipio </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control" id="i_id_municipio" disabled autocomplete="off">
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control" id="i_municipio" disabled autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_estado" class="col-2 col-md-2 col-form-label">Estado </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control" id="i_id_estado" disabled autocomplete="off">
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control" id="i_estado" disabled autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_banco" class="col-2 col-md-2 col-form-label">Banco </label><br>
                                <div class="col-sm-12 col-md-2">
                                    <div class="row">
                                        <div class="input-group col-sm-12 col-md-12">
                                            <input type="text" id="i_id_banco" name="i_id_banco" class="form-control" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_banco" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control" id="i_banco" disabled autocomplete="off">
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label for="i_cuenta" class="col-2 col-md-2 col-form-label">Cuenta </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control" id="i_cuenta" autocomplete="off">
                                </div>
                                <label for="i_clabe" class="col-sm-2 col-md-2 col-form-label">Clabe </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control" id="i_clabe" autocomplete="off">
                                </div>
                                <label for="i_dias_credito" class="col-sm-2 col-md-2 col-form-label">Días de Credito </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control validate[custom[integer]]" id="i_dias_credito" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_telefono" class="col-sm-2 col-md-2 col-form-label">Teléfono(s) </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" class="form-control" id="i_telefono" autocomplete="off">
                                </div>
                                <label for="i_extension" class="col-sm-2 col-md-2 col-form-label">Extensión </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control" id="i_extension" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_web" class="col-sm-2 col-md-2 col-form-label">Web </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="i_web" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_contacto" class="col-sm-2 col-md-2 col-form-label">Contacto </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="i_contacto" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_condiciones" class="col-sm-2 col-md-2 col-form-label">Condiciones </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="i_condiciones" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_inactivo" class="col-sm-2 col-md-2 col-form-label">Inactivo</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="" autocomplete="off">
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
                            <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                        </form>
                </div>
                </div>       
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group row">
                            <div class="input-group col-sm-12 col-md-12">
                                <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control filtros" placeholder="Sucursal" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                     <div class="col-sm-12 col-md-3">
                        <input type="text" name="i_filtro_gastos" id="i_filtro_gastos" alt="gasto-busqueda" class="filtrar_renglones form-control filtrar_renglones"  placeholder="Filtrar" autocomplete="off"></div>
               
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
                            <th scope="col" width="9%">Unidad de Negocio</th> 
                            <th scope="col" width="5%">Sucursal</th>
                            <th scope="col" width="9%">Departamento</th>
                            <th scope="col" width="9%">Familia</th>
                            <th scope="col" width="9%">Clasificación</th>
                            <th scope="col" width="5%">Fecha<br>Gasto</th>
                            <th scope="col" width="5%">Fecha<br>Ref</th>
                            <th scope="col" width="5%">Referencia</th>
                            <th scope="col" width="9%">Proveedor</th>
                            <!--NJES March/12/2020 se agrega campo folio requsición-->
                            <th scope="col" width="5%">Folio Requisición</th>
                            <th scope="col" width="10%">Observaciones</th>
                            <th scope="col" width="5%">Total</th>
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

<div id="dialog_proveedor" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_proveedor" id="i_filtro_proveedor" alt="renglon_proveedor" class="filtrar_renglones form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_proveedor">
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
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_proveedores" id="i_filtro_proveedores" alt="renglon_proveedores" class="filtrar_renglones form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
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

<div id="dialog_buscar_requisiciones" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Requisiciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
               <label for="s_filtro_unidad_r" class="col-sm-12 col-md-2 col-form-label">Unidad de Negocio </label> 
                <div class="col-md-4">
                    <div class="form-group row">
                         <div class="col-sm-12 col-md-10">
                            <select id="s_filtro_unidad_r" name="s_filtro_unidad_r" class="form-control" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>
                </div> 
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <input type="checkbox" id="ch_todas" name="ch_todas" value=""> Todas las Unidades
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success btn-sm form-control" id="b_excel_requis" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                </div>
            </div>    
            <div class="row">
                <div class="col-sm-12 col-md-1">
                    Sucursal
                    <input type="text" name="i_filtro_requisiciones" id="i_filtro_requisiciones" alt="requisicion-busqueda-tr" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group row">
                        <div class="input-group col-sm-12 col-md-12">
                            <select id="s_filtro_sucursal_r" name="s_filtro_sucursal_r" class="form-control filtros" placeholder="Sucursal" style="width:100%;" autocomplete="off"></select>
                        </div>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="row">
                        <div class="col-sm-12 col-md-1">Del: </div>
                        <div class="input-group col-sm-12 col-md-5">
                            <input type="text" name="i_fecha_inicio_r" id="i_fecha_inicio_r" class="form-control fecha" autocomplete="off" readonly>
                            <div class="input-group-addon input_group_span">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-1">Al: </div>
                        <div class="input-group col-sm-12 col-md-5">
                            <input type="text" name="i_fecha_fin_r" id="i_fecha_fin_r" class="form-control fecha" autocomplete="off" readonly disabled>
                            <div class="input-group-addon input_group_span">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <input type="text" name="i_filtro_requisiciones" id="i_filtro_requisiciones" alt="requisicion-busqueda-tr" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_requisiciones_b">
                      <thead>
                        <tr class="renglon">
                            <th scope="col">Folio</th>
                            <th scope="col">Unidad de Negocio</th> 
                            <th scope="col">Sucursal</th>
                            <th scope="col">Área</th>
                            <th scope="col">Depto</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Estatus</th>
                            <th scope="col"></th>
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
    var saldoDisponibleCuentaB=0;
    var idBanco=0;
    $(function()
    {

        $('#div_requis_diferentes_fg').hide();
    
       mostrarBotonAyuda(modulo);
       muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
       muestraSucursalesPermiso('s_id_sucursal', idUnidadActual, modulo,idUsuario);
       muestraAreasAcceso('s_id_area');
       muestraSelectFamiliaGastos('s_familia_gastos');
       //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
       muestraCuentasBancos('s_cuenta',0,0,idUnidadActual);
       muestraTiposGasto('s_tipo_gasto');
       $('#b_cancelar').prop("disabled", true);
       $("#div_principal").css({left : "0%"});
       $('#s_clasificacion_gastos').prop('disabled',true);
       $("#s_id_departamento").prop("disabled", true);

        /* MGFS 08-01-2019 Que por default, se tenga seleccionada la casilla de Externo 
           y quitar obligatorio  el campo de empleado*/
        $('#ch_externo').prop('checked',true);
        $('#i_empleado').attr('alt',0).val('').prop('readonly',false);
        $('#b_buscar_empleados').hide(); 

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
                $('#b_buscar_empleados').hide(); 

            }else{

                $('#i_empleado').attr('alt',0).val('').prop('readonly',true);
                $('#b_buscar_empleados').show(); 
            }
        }); 

       $('#s_id_unidad').change(function()
       {

            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocio, modulo,idUsuario);
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_cuenta',0,0,idUnidadNegocio);
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

        $('#ch_deudores').on('change',function(){
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_cuenta',0,0,$('#s_id_unidad').val());

            //-->NJES Jan/20/2020 verificar que si selecciona como deudor diverso  quitar clases requerido, sino agregarlas
            if($('#ch_deudores').is(':checked'))
            {
                $('#l_s_cuenta').removeClass('requerido');
                $('#s_cuenta').prop('disabled',true).removeClass('validate[required]');

                //-->NJES Jan/27/2020 solo si es deudor diverso es obligatorio el empleado
                $('#label_empleado').removeClass('requerido').addClass('requerido');
                $('#i_empleado').removeClass('validate[required]').addClass('validate[required]');
            }else{
                $('#l_s_cuenta').removeClass('requerido').addClass('requerido');
                $('#s_cuenta').prop('disabled',false).removeClass('validate[required]').addClass('validate[required]');
            
                //-->NJES Jan/27/2020 solo si es deudor diverso es obligatorio el empleado
                $('#label_empleado').removeClass('requerido');
                $('#i_empleado').removeClass('validate[required]').validationEngine('hide');
            }
        });

       $(document).on('change','#s_familia_gastos',function(){
           var idFamiliaGasto = $(this).val();
           if(idFamiliaGasto > 0){
                muestraSelectClasificacionGastos('s_clasificacion_gastos',idFamiliaGasto);
                $('#s_clasificacion_gastos').prop('disabled',false);
                //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                //--> NJES October/28/2020 a petición de mabel se solicita que se quite validacion de que cuando se requiere un gasto para
                //familia gasto CAJA CHICA no pueda hacerlo con cuentas de tipo caja chica
                /*if($('#s_familia_gastos option:selected').text() == 'CAJA CHICA')
                {
                        muestraCuentasBancos('s_cuenta',0,1,$('#s_id_unidad').val());
                }else*/
                        muestraCuentasBancos('s_cuenta',0,0,$('#s_id_unidad').val());
                
           }
           
       }); 

       $('#s_cuenta').change(function(){
            idBanco=$('#s_cuenta option:selected').attr('alt');
            var cuenta = $('#s_cuenta').val();
            var tipo = $('#s_cuenta option:selected').attr('alt2');
            var idSucursal = $('#s_cuenta option:selected').attr('alt3');

            if(tipo == 0)
            {
                muestraSaldoDisponibleCuentaBanco(cuenta);
            }else{
                muestraSaldoDisponibleCajaChica(idSucursal);
            }
        });

        function muestraSaldoDisponibleCuentaBanco(idCuentaBanco){
            
            $.ajax({
                type: 'POST',
                url: 'php/movimientos_cuentas_saldo_disponible.php',
                dataType:"json", 
                data:{'idCuentaBanco' : idCuentaBanco},
                success: function(data)
                {
                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        
                        saldoDisponibleCuentaB = dato.saldo_disponible;
                    }
                },
                error: function (xhr) {
                    console.log("movimientos_cuentas_saldo_disponible.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo disponible de la cuenta');
                }
            });
        }

        function muestraSaldoDisponibleCajaChica(idSucursal){
            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_saldo_actual_buscar.php',
                dataType:"json", 
                data:{'idSucursal' : idSucursal},
                success: function(data)
                {
                    var arreglo=data;
                    if(arreglo.length>0)
                    {
                        saldoDisponibleCuentaB = arreglo[0].saldo;
                    }
                },
                error: function (xhr) {
                    console.log("caja_chica_saldo_actual_buscar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo');
                }
            });
        }
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
        {   
            var arr = buscaIgualesDiferentes();
            var diferentesFamilias = $('#i_folio').attr('diferentes_familias');
            
            $('#b_guardar').prop('disabled',true);
            if($("#form_gastos").validationEngine('validate'))
            {  
                //NJES GASTOS (2) (DEN18-2424) verificar que exista una cuenta banco caja chica de la sucursal seleccionada cuando se insertara movimiento a caja chica de sucursal Dic/26/2019
                if($('#s_familia_gastos option:selected').text() == 'CAJA CHICA' && $('#s_clasificacion_gastos option:selected').text() == 'CAJA CHICA')
                {
                    if(existeCajaChicaSucursal($('#s_id_sucursal').val()) == 1)
                    {
                        if(parseFloat(saldoDisponibleCuentaB) >= parseFloat(quitaComa($('#i_total').val())))
                        {  
                            if(diferentesFamilias == 0)
                                guardar();
                            else{
                                if(diferentesFamilias == 1 && ((arr[0] == arr[1]) || (arr[0] == arr[2]) || (arr[0] == arr[3])))
                                    guardar();
                                else{
                                    mandarMensaje('Todas las clasficaciones de las partidas deben ser CAJA CHICA ó VALES');
                                    $('#b_guardar').prop('disabled',false);
                                }
                            }
                        }else{
                            mandarMensaje('El saldo actual de la cuenta banco '+$('#s_cuenta option:selected').text()+' es insuficiente para realizar el movimiento.');
                            $('#b_guardar').prop('disabled',false);
                        }
                    }else{
                        mandarMensaje('No existe una cuenta banco caja chica para la sucursal, solicita crearla o activarla.');
                        $('#b_guardar').prop('disabled',false);
                    }
                }
                else
                {

                    //-->NJES Jan/20/2020 verificar que si selecciona como deudor diverso no verifique el saldo de la cuenta banco ya que no se hace el descuento en ese momento
                    if($("#ch_deudores").is(':checked'))
                    {

                        if(diferentesFamilias == 0)
                            guardar();
                        else
                        {

                            if(diferentesFamilias == 1 && ((arr[0] == arr[1]) || (arr[0] == arr[2]) || (arr[0] == arr[3])))
                                guardar();
                            else
                            {


                                if($('#i_folio').val() == '')
                                    guardar();
                                else
                                {
                                    mandarMensaje('Todas las clasficaciones de las partidas deben ser CAJA CHICA ó VALES');
                                    $('#b_guardar').prop('disabled',false);
                                }


                            }

                        }

                    }
                    else
                    {
                        if(parseFloat(saldoDisponibleCuentaB) >= parseFloat(quitaComa($('#i_total').val())))
                        {  

                            if(diferentesFamilias == 0)
                                guardar();
                            else
                            {

                                if(diferentesFamilias == 1 && ((arr[0] == arr[1]) || (arr[0] == arr[2]) || (arr[0] == arr[3])))
                                    guardar();
                                else
                                {

                                    if($('#i_folio').val() == '')
                                        guardar();
                                    else
                                    {
                                        mandarMensaje('Todas las clasficaciones de las partidas deben ser CAJA CHICA ó VALES');
                                        $('#b_guardar').prop('disabled',false);
                                    }

                                }
                            }

                        }
                        else
                        {
                            mandarMensaje('El saldo actual de la cuenta banco '+$('#s_cuenta option:selected').text()+' es insuficiente para realizar el movimiento.');
                            $('#b_guardar').prop('disabled',false);
                        }

                    }
                }
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function buscaIgualesDiferentes(){
            var contCCH = 0;
            var contG = 0;
            var contDif = 0;
            var cont = 0;
            var arreglo = [];

            $("#t_partidas_requis .renglon_requi").each(function() {
                cont++;
                var clasificacion = $(this).find('td').eq(1).find('.s_clasificacion_p option:selected').text();
                if(clasificacion == 'CAJA CHICA')
                    contCCH++;
                else if(clasificacion == 'VALES')
                    contG++;
                else
                    contDif++;

            });

            //la posición 0 = número de partidas
            //la posición 1 = número de clasificaciones caja chica
            //la posición 2 = número de clasificaciones vales de gasolina
            //la posición 3 = número de clasificaciones diferentes de caja chica y vales
            
            var arreglo = [cont,contCCH,contG,contDif];

            return arreglo;            
        }

        
        function guardar()
        {
            console.log(JSON.stringify(obtenerDatos()));
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
                        limpiarForma();
                        //muestraRegistro(data);
                    }else{
                        mandarMensaje('Ocurrio un error durante el guardadó');
                        $('#b_guardar').prop('disabled',false);
                    }
                        
                },
                error: function (xhr) {
                    console.log('php/gastos_guardar.php--->' + JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al guardar el registro, intentelo nuevamente');
                    $('#b_guardar').prop('disabled',false);
                }
            });
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
                        'fechaReferencia': $('#i_fecha_referencia').val(),
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
                        'total': quitaComa($('#i_total').val()),
                        'tipoCuenta' : $('#s_cuenta option:selected').attr('alt2'),
                        'idRequisicion' : $('#i_folio').attr('alt'),
                        'folioRequisicion' : $('#i_folio').val(),
                        'diferentesFamilias' : $('#i_folio').attr('diferentes_familias'),
                        'datosRequisDiferentesFamilias' : obtienePartidasRequis(),
                        //-->NJES April/05/2021 agregar fecha de aplicacion para saber cuando afecta el movimiento presupuesto y cuentas bancos
                        'fecha_aplicacion' : $('#i_fecha_aplicacion').val()
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

        function limpiarForma(){
            
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
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_cuenta',0,0,idUnidadActual);
            muestraTiposGasto('s_tipo_gasto');

            $('#i_fecha').val(hoy);
            $('#i_fecha_referencia').val('');
            $('#d_estatus').removeAttr('class').text('');
            $('#ch_deudores').prop('checked', false);
            $('#b_buscar_empleados').prop("disabled", false);
            $('#b_guardar').prop("disabled", false);
            $('#b_cancelar').prop("disabled", true);

            $('#ch_externo').prop('checked',true);
            $('#i_empleado').attr('alt',0).val('').prop('readonly',false);
            $('#b_buscar_empleados').hide(); 

            //-->NJES Jan/20/2020 agregar clases requerido
            $('#l_s_cuenta').removeClass('requerido').addClass('requerido');
            $('#s_cuenta').prop('disabled',false).removeClass('validate[required]').addClass('validate[required]');
            
            //-->NJES Jan/27/2020 solo si es deudor diverso es obligatorio el empleado
            $('#label_empleado').removeClass('requerido');
            $('#i_empleado').removeClass('validate[required]').validationEngine('hide');

            $('#div_requis_diferentes_fg').hide();
            //-->NJES 23/sep/2020 limpia rl atributo alt donde guardaba el di de la requi porque estaba insertando el ultimo id de la requi tomada
            //aunque ya no se estuviera importando ninguna requi 
            $('#i_folio').attr('diferentes_familias',0).attr('alt',0);

            $('#b_buscar_requisiciones_gastos').prop('disabled',false);
            $('#b_agregar_proveedor').prop('disabled',false);
            $('#b_buscar_proveedores').prop('disabled',false);

            $('#i_fecha_aplicacion').val('');
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
                        html += "<td>" + gasto.fecha_referencia + "</td>";
                        html += "<td>" + gasto.referencia + "</td>";
                        html += "<td>" + gasto.proveedor + "</td>";
                        html += "<td>" + gasto.folio_requisicion + "</td>";  //-->NJES March/12/2020 se agrega folio requsiición cuando aplique
                        html += "<td>" + gasto.observaciones + "</td>";
                        html += "<td>" + formatearNumero(gasto.total) + "</td>";
                        html += "<td>" + gasto.cuenta + "</td>";
                        html += "<td>" + estatus + "</td>";
                        html += "</tr>";

                        $('#t_gastos tbody').append(html);
                    
                    }
                
         
                },
                error: function (xhr)
                {
                    console.log('php/gastos_buscar.php->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al buscar la gastos');
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

                        $('#b_buscar_requisiciones_gastos').prop('disabled',true);
                        $('#b_agregar_proveedor').prop('disabled',true);
                        $('#b_buscar_proveedores').prop('disabled',true);

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

                        //-->NJES July/30/2020 si la requi de gasto tiene diferentes familias de gastos mostrar partidas en tabla
                        //para mostrar familias gastos y permitir seleccionar la clasificación
                        if(gasto.b_varias_familias == 1)
                        {
                            $('#s_familia_gastos').prop('disabled',true);
                            $('#s_clasificacion_gastos').prop('disabled',true);

                            /*if(gasto.familia_gasto == 'CAJA CHICA')
                                muestraCuentasBancos('s_cuenta',0,1,idUnidad);
                            else
                                muestraCuentasBancos('s_cuenta',0,0,idUnidad);*/

                            $('#div_requis_diferentes_fg').show();

                            muestraPartidasDetalleIdGasto(gasto.id);
                        }else{
                            optionFamilia = new Option(gasto.familia_gastos, gasto.id_familia_gasto, true, true);
                            $('#s_familia_gastos').append(optionFamilia).trigger('change');

                            optionClasificacion = new Option(gasto.clasificacion_gasto, gasto.id_clasificacion, true, true);
                            $('#s_clasificacion_gastos').append(optionClasificacion).trigger('change');
                        
                            $('#div_requis_diferentes_fg').hide();
                        }

                        if(gasto.id_cuenta_banco > 0)
                        {   //optionCuenta = new Option(gasto.banco+' - '+gasto.cuenta, gasto.id_cuenta_banco, true, true);                    
                            optionCuenta = new Option(gasto.cuenta, gasto.id_cuenta_banco, true, true);
                            $('#s_cuenta').append(optionCuenta);
                        }else{
                            $('#s_cuenta').val('');
                            $('#s_cuenta').select2({placeholder: 'Selecciona'});
                        }

                        $("#s_id_unidad").prop("disabled", true)
                        $("#s_id_sucursal").prop("disabled", true)
                        $("#s_id_area").prop("disabled", true)
                        $("#s_id_departamento").prop("disabled", true)

                        $('#i_proveedor').attr('alt', gasto.id_proveedor).val( gasto.proveedor)
                        $('#i_fecha').val( gasto.fecha)
                        $('#i_fecha_referencia').val( gasto.fecha_referencia);

                        $('#i_fecha_aplicacion').val(gasto.fecha_aplicacion);
                        
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
                            $('#b_buscar_empleados').hide(); 
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

                    
                        $('#i_folio').attr('alt',gasto.id_requisicion).val(gasto.folio_requisicion);


                        if(data[0].estatus == 1){
                            $('#d_estatus').addClass('alert alert-sm alert-info').text('ACTIVA');
                            //-->si no tiene un movimiento en banco y si de hoy se puede cancelar 
                            //(la bandera viene como 1 si deja cancelar, si es 0 no deja cancelar)
                            if(gasto.bandera_cancela == 1){
                                //-->NJES Jan/27/2020 la clasificacion gasto se llamara VALES en lugar de GASOLINA
                                if(gasto.clasificacion_gasto == 'VALES' || gasto.clasificacion_gasto == 'CAJA CHICA')
                                {
                                    //-->si la clasificacion es caja chica o gasolina no me permite cancelar gasto
                                    deshabilita();
                                    mandarMensaje('El gasto no se puede cancelar debido a la clasificación. Si desea cancelarlo favor de comunicarse con Denken');
                                }else{
                                    habilita();
                                }
                            }else{
                                deshabilita();
                                mandarMensaje('El gasto no se puede cancelar porque se registro un movimiento en bancos ó no es del día de hoy, verificalo con finanzas o administración.');
                            }
                        }

                        if(data[0].estatus == 0){
                            $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
                            deshabilita();
                        }
                       

                        $('#dialog_buscar_gastos').modal('hide');

                    }
         
                },
                error: function (xhr)
                {
                    console.log('php/gastos_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error al buscar información del gasto');
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
                        mandarMensaje('* Error en el sistema');
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
            $('#i_filtro_proveedores').val('');
            if(forma=='si'){
                muestraModalProveedoresUnidades('renglon_proveedor','t_proveedor tbody','dialog_proveedor', $('#s_id_unidad').val());
    
            }else{
                muestraModalProveedoresCorporativo('renglon_proveedores','t_proveedores tbody','dialog_proveedores', $('#s_id_unidad').val());
    
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
            //$('#dialog_agregar_proveedor').modal('show');
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
                  mandarMensaje('* No se encontro información al buscar proveedores');
              }
          });
      }

      $('#b_guardar_proveedor').click(function(){
        
         $('#b_guardar_proveedor').prop('disabled',true);

          if ($('#forma_proveedor').validationEngine('validate')){
              if($('#i_rfc').val()!='XEXX010101000' && $('#i_rfc').val()!='NO APLICA'){
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
            url: 'php/proveedores_verificar_asiga.php',
            dataType:"json", 
            data:  {'rfc':$('#i_rfc').val(),
                    'idUnidadNegocio':$('#s_id_unidad').val()},
            success: function(data) 
            {
                //console.log('data: '+data+' num: '+data.length);
                if(data != 0){
                    if(data == 1)
                    {
                        mandarMensaje('El RFC : '+ $('#i_rfc').val()+' ya existe intenta con otro');
                        $('#i_rfc').val('');
                        $('#b_guardar_proveedor').prop('disabled',false);
                    }else{
                        $('#i_proveedor_n').val(data[0].id_proveedor);
                        mandarMensajeConfimacion('El RFC ya esta asignados a las siguientes unidades de negocio "'+data[0].unidades+'". ¿Deseas asignarla a la unidad '+$('#s_id_unidad option:selected').text()+'?',0,'aceptar_asignar');
                    }
                }else
                    guardarProveedor();
                
            },
            error: function (xhr) {
                console.log('php/proveedores_verificar_asiga.php-->'+JSON.stringify(xhr));
                mandarMensaje('* No se encontro información al verificar si existe el proveedor.');
            }
        });
    }

    
    $(document).on('click','.b_cancelar',function(){ 
        $('#b_guardar_proveedor').prop('disabled',false);
    });

    $(document).on('click','#b_aceptar_asignar',function(){ 
        var boton = $(this);
        $.ajax({
            type: 'POST',
            url: 'php/proveedores_guardar_asignar.php', 
            dataType:"json", 
            data: {'idProveedor':$('#i_proveedor_n').val(),
                   'idUnidadNegocio':$('#s_id_unidad').val()},
            success: function(data){
                if (data > 0 ) {
                    mandarMensaje('Se asigno el proveedor correctamente');
                    boton.prop('disabled',false);
                    $('#b_nuevo_proveedor').click();
                }else{
                    mandarMensaje('Error en el guardado');
                    boton.prop('disabled',false);
                }
            },
                //si ha ocurrido un error
            error: function(xhr){
                console.log('php/proveedores_guardar_asignar.php-->'+JSON.stringify(xhr));
                boton.prop('disabled',false);
                mandarMensaje('* Error en el guardado');
            }
        });

        $('#b_guardar_proveedor').prop('disabled',false);
    });

      
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
                 
                  mandarMensaje("* Ha ocurrido un error.");
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
                  'modulo' : 'G',
                  'idUnidadNegocio' : idUnidadActual
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
                  mandarMensaje('* Error en el sistema');
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
                  mandarMensaje('* Error en el sistema');
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
          $('#forma_proveedor').validationEngine('hide');
          $('#b_guardar_proveedor').prop('disabled',false);
          $('#ch_inactivo').prop('checked',false).prop('disabled',true);
          muestraSelectPaises('s_pais');
          $('#s_pais').prop('disabled',false);
          $('#i_proveedor_n').val('');
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

        $('#ch_facturar').on('click',function(){
            $('#i_rfc').validationEngine('hide');
            if($('#ch_facturar').is(':checked')){
                $('#i_rfc').removeAttr('class');
                $('#i_rfc').addClass('form-control').val('NO APLICA').prop('disabled',true);
            }else{
                $('#i_rfc').removeAttr('class');
                $('#i_rfc').val('').addClass('form-control validate[required,minSize[12],maxSize[13],custom[onlyLetterNumber]]').prop('disabled',false);
            }
        });

        //---MGFS 17-12-2019 SE AGREGA LA BUSQUEDA DE REQUISICIONES DE GASTOS PARA HAVER LA RELACION CON UN  GASTO TAREA: DEN18-2406
        $('#b_buscar_requisiciones_gastos').click(function()
        {
            muestraSelectUnidades(matriz, 's_filtro_unidad_r', idUnidadActual);
            muestraSucursalesPermiso('s_filtro_sucursal_r',idUnidadActual,modulo,idUsuario);
            $('#i_filtro_1').val('');
            $('#i_fecha_inicio_r').val('');
            $('#i_fecha_fin_r').val('');
            $('.requisicion-busqueda-tr').remove();
            $('#dialog_buscar_requisiciones').modal('show');

        });

        $(document).on('change','#s_filtro_unidad_r',function(){
            var idUnidad=$(this).val();
            if(idUnidad!= ''){
                $('.img-flag').css({'width':'50px','height':'20px'});
            }
            muestraSucursalesPermiso('s_filtro_sucursal_r',idUnidad,modulo,idUsuario);
            $('#i_filtro_requisiciones').val('');
            $('#i_fecha_inicio_r').val('');
            $('#i_fecha_fin_r').val('');
            $('.requisicion-busqueda-tr').remove();
            
        });

        $(document).on('change', '#s_filtro_sucursal_r',function(){
            buscarRequisicion();
        });

        $('#i_fecha_inicio_r').change(function(){

            if($("#ch_todas").is(':checked'))
            {
                if($('#i_fecha_inicio_r').val() != ''){
                    $('#i_fecha_fin_r').prop('disabled',false);
                    buscarRequisicion();
                }
            }else{
                if($('#s_filtro_sucursal_r').val()>0)
                {
                    if($('#i_fecha_inicio_r').val() != ''){
                        $('#i_fecha_fin_r').prop('disabled',false);
                        buscarRequisicion();
                    }
                }else{
                    mandarMensaje('Selecciona una sucursal para iniciar la busqueda');
                    if($('#i_fecha_inicio_r').val() != ''){
                        $('#i_fecha_fin_r').prop('disabled',false);
                    }
                }
            }

        });

        $('#i_fecha_fin_r').change(function(){  

            if($("#ch_todas").is(':checked'))
            {
                buscarRequisicion();
                
            }else{
                if($('#s_filtro_sucursal_r').val()>0)
                {
                    if($('#i_fecha_inicio_r').val() != ''){
                        buscarRequisicion();
                    }
                }else{
                    mandarMensaje('Selecciona una sucursal para iniciar la busqueda');
                }
            }
            
        });
        //--- MGFS 08-01-2020 SE AGREGAN EL DATO PROVEEDOR Y MONTO A LA BUSUQEDA DE REQUIS DE GASTOS
        function buscarRequisicion(){

            $('#i_filtro_requisiciones').val('');
            $('.requisicion-busqueda-tr').remove();

            //-->NJES February/17/2021 se agrega checked para mostrar registros de las sucursales y 
            //unidades a las que tiene permiso el usuario en el modulo gastos
            if($("#ch_todas").is(':checked'))
            {
                var id_unidad = listaUnidadesNegocioId(matriz);
                var id_sucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario);
            }else{
                var id_unidad = $('#s_filtro_unidad_r').val();
                var id_sucursal = $('#s_filtro_sucursal_r').val();
            }

            $.ajax({
                type: 'POST',
                url: 'php/requisiciones_gastos_buscar.php',
                dataType:"json", 
                data:{
                    'idUnidadNegocio':id_unidad,
                    'idSucursal':id_sucursal,
                    'fecha_de':$('#i_fecha_inicio_r').val(),
                    'fecha_a':$('#i_fecha_fin_r').val()
                },
                success: function(data)
                {
                    
                    if(data.length > 0)
                    {
                        for(var i=0; data.length>i; i++)
                        {

                            var requisicion = data[i];

                            var estatus = 'Pendiente';

                            if(requisicion.estatus == 2)
                                estatus = 'Autorizada';

                            var html = "<tr class='requisicion-busqueda-tr' alt='" + requisicion.id + "' alt2='"+requisicion.id_familia_gasto+"' alt3='"+requisicion.b_varias_familias+"'>";
                            html += "<td class='requisicion-busqueda'>" + requisicion.folio + "</td>";
                            html += "<td class='requisicion-busqueda'>" + requisicion.unidad + "</td>";
                            html += "<td class='requisicion-busqueda'>" + requisicion.sucursal + "</td>";
                            html += "<td class='requisicion-busqueda'>" + requisicion.are + "</td>";
                            html += "<td class='requisicion-busqueda'>" + requisicion.depto + "</td>";
                            html += "<td class='requisicion-busqueda'>" + requisicion.proveedor + "</td>";
                            html += "<td class='requisicion-busqueda'>" + formatearNumero(requisicion.total) + "</td>";
                            html += "<td class='requisicion-busqueda'>" + estatus + "</td>";
                            html += "<td><button type='button' class='btn btn-danger btn-sm form-control boton_omitir' alt='"+requisicion.id+"'><i class='fa fa-remove' aria-hidden='true'></i> Omitir</button></td>";
                            html += "</tr>";

                            $('#t_requisiciones_b tbody').append(html);
                        
                        }

                        $('#b_excel_requis').prop('disabled',false);
                    }else{
                        var html = "<tr class='requisicion-busqueda-tr'><td colspan='9'>No se encontró información</td></tr>";
                        $('#t_requisiciones_b tbody').append(html);
                    }
                
         
                },
                error: function (xhr)
                {
                    console.log('php/requisiciones_buscar_todas.php->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al buscar la requisiciones');
                }
            });

        }

        //-->NJES November/06/2020 omitir requisicion para que no aparezca en esta lista y no se ligue a un gasto
        $(document).on('click','.boton_omitir',function(){
            var id_requi = $(this).attr('alt');
            mandarMensajeConfimacion('Se omitirá la requisición y ya no aparecerá para usarla en un gasto, ¿Deseas continuar?',id_requi,'aceptar_omitir');
        });

        $(document).on('click','#b_aceptar_omitir',function(){
            var idRequisicion = $(this).attr('alt'); 

            $.ajax({
                type: 'POST',
                url: 'php/gastos_omitir_requisicion.php',
                data:{
                    'id':idRequisicion
                },
                success: function(data)
                {
                    if(data > 0)
                        buscarRequisicion();
                    else
                        mandarMensaje('Error al omitir requisición');
                },
                error: function (xhr)
                {
                    console.log('php/gastos_omitir_requisicion.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* Error al omitir requisición');
                }
            });
        });

        $("#t_requisiciones_b").on('click',".requisicion-busqueda",function()
        {
            //-->NJES Jan/20/2020 tomar el id_familia_gasto de la requisicion para usarlo en la busqueda de gastos
            muestraSelectFamiliaGastos('s_familia_gastos');
            $('#s_familia_gastos').prop('disabled',false);
            $('#s_clasificacion_gastos').prop('disabled',true);

            var idR = $(this).parent().attr('alt');
            
            var idFamiliaGasto = $(this).parent().attr('alt2');
            if(idFamiliaGasto > 0)
            {
                muestraSelectClasificacionGastos('s_clasificacion_gastos',idFamiliaGasto);
                $('#s_clasificacion_gastos').prop('disabled',false);
            }

            //->si es 1 quiere decir que es una requi con diferentes familias de gastos
            var diferentesFamilias = $(this).parent().attr('alt3');//  $(this).parent().attr('alt') $(this).attr('alt3');
            $('#i_folio').attr('diferentes_familias',diferentesFamilias);
                
            $.ajax({
                type: 'POST',
                url: 'php/requisiciones_buscar_id.php',
                dataType:"json", 
                data:{
                    'mantenimiento':0,
                    'id': idR
                },
                success: function(data)
                { console.log('Resultado: '+data);
            
                    for(var i=0; data.length>i; i++)
                    {

                        var requisicion = data[i];
                        id = requisicion.id;
                        idUnidad = requisicion.id_unidad_negocio;
                        idSucursal = requisicion.id_sucursal;
                        idArea = requisicion.id_area;
                        idDepartamento = requisicion.id_departamento;

                        nombreProveedor = requisicion.nombre_proveedor;

                        $('#i_folio').attr('alt',requisicion.id).val(requisicion.folio);


                        limpiarCombos();

                        $('#s_id_unidad').val(idUnidad);
                        $("#s_id_unidad").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

                        optionSurucursal = new Option(requisicion.sucursal, requisicion.id_sucursal, true, true);
                        $('#s_id_sucursal').append(optionSurucursal).trigger('change');

                        optionArea = new Option(requisicion.are, requisicion.id_area, true, true);
                        $('#s_id_area').append(optionArea).trigger('change');

                        optionDepto = new Option(requisicion.depto, requisicion.id_departamento, true, true);
                        $('#s_id_departamento').append(optionDepto).trigger('change');

                        //-->NJES July/30/2020 si la requi de gasto tiene diferentes familias de gastos mostrar partidas en tabla
                        //para mostrar familias gastos y permitir seleccionar la clasificación
                        if(diferentesFamilias == 1)
                        {
                            $('#s_familia_gastos').prop('disabled',true);
                            $('#s_clasificacion_gastos').prop('disabled',true);
                            //--> NJES October/28/2020 a petición de mabel se solicita que se quite validacion de que cuando se requiere un gasto para
                            //familia gasto CAJA CHICA no pueda hacerlo con cuentas de tipo caja chica
                            /*if(requisicion.familia_gasto == 'CAJA CHICA')
                                muestraCuentasBancos('s_cuenta',0,1,idUnidad);
                            else*/
                                muestraCuentasBancos('s_cuenta',0,0,idUnidad);

                            $('#div_requis_diferentes_fg').show();

                            muestraPartidasRequisicion(requisicion.id);
                        }else{
                            $('#s_clasificacion_gastos').prop('disabled',false);
                            $('#div_requis_diferentes_fg').hide();

                            //-->NJES Jan/20/2020 tomar el id_familia_gasto de la requisicion para usarlo en la busqueda de gastos
                            if(requisicion.id_familia_gasto > 0){
                                var optionFamiliaGasto = new Option(requisicion.familia_gasto, requisicion.id_familia_gasto, true, true);
                                $('#s_familia_gastos').append(optionFamiliaGasto).trigger('change').prop('disabled',true);
                                //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                                //--> NJES October/28/2020 a petición de mabel se solicita que se quite validacion de que cuando se requiere un gasto para
                                //familia gasto CAJA CHICA no pueda hacerlo con cuentas de tipo caja chica
                                /*if(requisicion.familia_gasto == 'CAJA CHICA')
                                {
                                        muestraCuentasBancos('s_cuenta',0,1,idUnidad);
                                }else*/
                                        muestraCuentasBancos('s_cuenta',0,0,idUnidad);
                                
                            }else
                                $('#s_familia_gastos').prop('disabled',false);
                        }

                        $("#s_id_unidad").prop("disabled", true);
                        $("#s_id_sucursal").prop("disabled", true);
                        $("#s_id_area").prop("disabled", true);
                        $("#s_id_departamento").prop("disabled", true);


                        $('#i_subtotal').val(formatearNumero(requisicion.subtotal));
                        $('#i_iva').val(formatearNumero(requisicion.iva));
                        $('#i_total').val(formatearNumero(requisicion.total));

                        $('#i_proveedor').attr('alt', requisicion.id_proveedor).val(requisicion.proveedor);

                    }              

                    $('#dialog_buscar_requisiciones').modal('hide');
         
                },
                error: function (xhr)
                {
                    console.log('php/requisiciones_buscar_todas.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar la requisición.');
                }

            });

            
        });

        function muestraPartidasRequisicion(idRequi){
            $('#t_partidas_requis tbody').empty();   

            $.ajax({
                type: 'POST',
                url: 'php/requisiciones_buscar_partidas.php',
                dataType:"json", 
                data:{
                    'idRequisicion':idRequi
                },
                success: function(data)
                {
                    for(var i=0; data.length>i; i++){
                        var detalle = data[i];
                        
                        var selectClasificacion='<select id="s_id_clasificacion_'+detalle.id+'" name="s_id_clasificacion_'+detalle.id+'" class="form-control form-control-sm s_clasificacion_p validate[required]" autocomplete="off" style="width:100%;"></select>';
                        muestraSelectClasificacionGastos('s_id_clasificacion_'+detalle.id,detalle.id_familia_gasto);
                        var total = (parseFloat(detalle.costo_unitario) * parseFloat(detalle.cantidad)) + parseFloat(detalle.iva);
                        var html = "<tr class='renglon_requi' alt='"+detalle.id+"' id_familia_gasto='"+detalle.id_familia_gasto+"' id_requi_d='"+detalle.id+"' total='"+total+"'>";
                        html += "<td>" + detalle.familia_gasto + "</td>";
                        html += "<td>"+selectClasificacion+"</td>";
                        html += "<td>" + detalle.concepto + "</td>";
                        html += "<td align='right'>" + detalle.cantidad + "</td>";
                        html += "<td align='right'>" + formatearNumero(detalle.costo_unitario) + "</td>";
                        html += "<td align='right'>" + detalle.porcentaje_iva + "</td>";
                        html += "<td align='right'>" + formatearNumero(detalle.iva) + "</td>";
                        html += "<td align='right'>" + formatearNumero(total) + "</td>";
                        html += "</tr>";

                        $('#t_partidas_requis tbody').append(html);                    
                    }
                },
                error: function (xhr)
                {
                    console.log('php/requisiciones_buscar_partidas.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar las partidas de la requisición');
                }
            });
        }

        function muestraPartidasDetalleIdGasto(id){
            $('#t_partidas_requis tbody').empty();   

            $.ajax({
                type: 'POST',
                url: 'php/gastos_buscar_detalles_id.php',
                dataType:"json", 
                data:{
                    'idGasto':id
                },
                success: function(data)
                {
                    for(var i=0; data.length>i; i++){
                        var detalle = data[i];
                        
                         total = (parseFloat(detalle.costo_unitario) * parseFloat(detalle.cantidad)) + parseFloat(detalle.iva);
                        var html = "<tr class='renglon_detalle_gasto_requi'>";
                        html += "<td>" + detalle.familia_gasto + "</td>";
                        html += "<td>"+detalle.clasificacion_gasto+"</td>";
                        html += "<td>" + detalle.concepto + "</td>";
                        html += "<td align='right'>" + detalle.cantidad + "</td>";
                        html += "<td align='right'>" + formatearNumero(detalle.costo_unitario) + "</td>";
                        html += "<td align='right'>" + detalle.porcentaje_iva + "</td>";
                        html += "<td align='right'>" + formatearNumero(detalle.iva) + "</td>";
                        html += "<td align='right'>" + formatearNumero(total) + "</td>";
                        html += "</tr>";

                        $('#t_partidas_requis tbody').append(html);                    
                    }
                },
                error: function (xhr)
                {
                    console.log('php/gastos_buscar_detalles_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar las partidas de la requisición del gasto');
                }
            });
        }

        function obtienePartidasRequis(){
            var partidas = [];
            var j = 0;
            $("#t_partidas_requis .renglon_requi").each(function()
            {
                var id = $(this).attr('alt');
                var idRequiD = $(this).attr('id_requi_d');
                var idFamiliaGasto = $(this).attr('id_familia_gasto');
                var idClasificacion = $(this).find('.s_clasificacion_p').val();
                var total = $(this).attr('total');

                partidas[j] =
                {
                    'idRequisicionD' : idRequiD,
                    'idFamiliaGasto' : idFamiliaGasto,
                    'idClasificacion' : idClasificacion,
                    'total' : total
                };
                
                j++;
                
            });

            return partidas;
        }

        function listaUnidadesNegocioId(datos)
        {
            var lista='';
            if(datos.length > 0)
            {
                for (i = 0; i < datos.length; i++) {
                    lista+=','+datos[i].id_unidad;
                }
            
            }else{
                lista='';
            }
            return lista;
        }

        //-->NJES February/17/2021 se agrega checked para mostrar registros de las sucursales y 
        //unidades a las que tiene permiso el usuario en el modulo gastos
        $('#ch_todas').change(function(){
            if($("#ch_todas").is(':checked'))
            {
                $('#s_filtro_unidad_r').val('').select2({placeholder: 'Selecciona',
                                                    templateResult: setCurrency,
                                                    templateSelection: setCurrency});
                $('#s_filtro_sucursal_r').val('').select2({placeholder: ''}).prop('disabled',true);

                buscarRequisicion();
            }else{
                muestraSelectUnidades(matriz,'s_filtro_unidad_r',idUnidadActual);
                $('#s_filtro_sucursal_r').prop('disabled',false);
                muestraSucursalesPermiso('s_filtro_sucursal_r',idUnidadActual,modulo,idUsuario);

                $('#i_filtro_requisiciones').val('');
                $('.requisicion-busqueda-tr').remove();
                $('#b_excel_requis').prop('disabled',true);
            }
        });

        //-->NJES February/17/2021 agregar boton para descargar excel de folios requisiciones autorizadas disponibles
        $('#b_excel_requis').click(function(){

            if($("#ch_todas").is(':checked'))
            {
                var id_unidad = listaUnidadesNegocioId(matriz);
                var id_sucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario);
            }else{
                var id_unidad = $('#s_filtro_unidad_r').val();
                var id_sucursal = $('#s_filtro_sucursal_r').val();
            }

            var datos = {
                'idUnidadNegocio':id_unidad,
                'idSucursal':id_sucursal,
                'fecha_inicio':$('#i_fecha_inicio_r').val(),
                'fecha_fin':$('#i_fecha_fin_r').val()
            };

            console.log(JSON.stringify(datos));

            $("#i_nombre_excel").val('Requisiciones de gasto');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('GASTOS_REQUIS_AUTORIZADAS');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>