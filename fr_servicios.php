<?php
session_start();
$idServicio=0;
$regresar=0;

if(isset($_GET['idServicio'])!=0 && $_GET['regresar']==1){

    $idServicio=$_GET['idServicio'];
    $regresar=1;
}
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
    .div_datos_facturas{
        display:none;
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Servicios</div>
                    </div>
                    <div class="col-sm-12 col-md-7"></div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-12">
                        <form id="forma" name="forma">
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="s_id_sucursales" class="requerido">Sucursal </label>
                                        <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- PENDIENTE BOTON AQUI  -->
                                    <button class="btn btn-primary" id="b_saldos_pendientes" type="button" disabled>Saldos Pendientes</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="i_cuenta" class="requerido">Cuenta</label>
                                        <input type="text" class="form-control validate[required]" id="i_cuenta" autocomplete="off">                                 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="i_digitos_cuenta" class="">Últimos 4 digitos de la cuenta</label>
                                        <input type="text" class="form-control validate[custom[integer],minSize[4],maxSize[4]]" id="i_digitos_cuenta" autocomplete="off">                                  
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="i_rfc" class="l_requerido">RFC</label>
                                        <input type="text" id="i_rfc" name="i_rfc" class="form-control validate[minSize[12],maxSize[13],custom[onlyLetterNumberN]] dato_fiscal" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ch_activo" class="">Activo</label>
                                        <input type="checkbox" id="ch_activo" name="ch_activo" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="i_nombre_corto" class="requerido">Nombre Corto </label>
                                        <input type="text" class="form-control validate[required]" id="i_nombre_corto" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="s_tipo_panel" class="">Tipo de panel</label>
                                        <select id="s_tipo_panel" name="s_tipo_panel" class="form-control" autocomplete="off""></select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="i_razon_social" class="col-sm-2 col-md-2 col-form-label l_requerido">Razón Social </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control dato_fiscal" id="i_razon_social" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="i_representante" class="col-sm-2 col-md-2 col-form-label requerido">Representante Legal </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_representante" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="i_tasa_iva" class="col-sm-2 col-md-2 col-form-label requerido">Tasa IVA </label>
                                <div class="col-md-5">
                                    <div class="row"><!-- row--->
                                        <div class="col-sm-4 col-md-4">
                                            16% <input type="radio" name="radio_iva" id="r_16" value="16">  
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            8%  <input type="radio" name="radio_iva" id="r_8" value="8"> 
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </form>   
                    </div>
                </div>
                    
                            <div class="card">
                                <h5 class="card-header">Domicilio Fiscal</h5>
                                <div  class="card-body">
                                <form id="forma2" name="forma2">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="i_domicilio" class="col-sm-12 col-md-3 col-form-label l_requerido">Domicilio </label><br>
                                                <div class="col-sm-12 col-md-9">
                                                    <input type="text" class="form-control dato_fiscal" id="i_domicilio" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="i_num_ext" class="col-sm-12 col-md-3 col-form-label l_requerido">Num. Ext </label><br>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" class="form-control dato_fiscal" id="i_num_ext" name="i_num_ext" autocomplete="off">
                                                </div>

                                                <label for="i_num_int" class="col-sm-12 col-md-3 col-form-label">Num. Int </label><br>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" class="form-control" id="i_num_int" name="i_num_int" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_codigo_postal" class="col-2 col-md-2 col-form-label l_requerido">Código Postal </label><br>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="row">
                                                
                                                <div class="input-group col-sm-12 col-md-9">
                                                    <input type="text" id="i_codigo_postal" name="i_codigo_postal" class="form-control validate[custom[integer]minSize[5],maxSize[5]] dato_fiscal" readonly autocomplete="off">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-primary" type="button" id="b_buscar_cp" style="margin:0px;">
                                                            <i class="fa fa-search" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <label for="for_pais" class="col-1 col-md-1 col-form-label l_requerido">País </label><br>
                                        <div class="col-sm-12 col-md-3">
                                            <select id="s_pais" name="s_pais" class="form-control dato_fiscal" style="width:100%;"></select>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row">
                                        <label for="i_colonia" class="col-sm-2 col-md-2 col-form-label l_requerido">Colonia </label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" class="form-control  dato_fiscal" id="i_colonia" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_id_municipio" class="col-2 col-md-2 col-form-label l_requerido">Municipio </label><br>
                                        <div class="col-sm-2 col-md-2">
                                            <input type="text" class="form-control dato_fiscal" id="i_id_municipio" readonly>
                                        </div>
                                        <div class="col-sm-2 col-md-8">
                                            <input type="text" class="form-control  dato_fiscal" id="i_municipio" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_id_estado" class="col-2 col-md-2 col-form-label l_requerido">Estado </label><br>
                                        <div class="col-sm-2 col-md-2">
                                            <input type="text" class="form-control dato_fiscal" id="i_id_estado" readonly>
                                        </div>
                                        <div class="col-sm-2 col-md-8">
                                            <input type="text" class="form-control dato_fiscal" id="i_estado" readonly>
                                        </div>
                                    </div>
                                    </form>
                                 </div>   
                            </div>   
                            <br>
                            <div class="card">
                                <h5 class="card-header">Domicilio Servicio</h5>
                                <div  class="card-body">
                                <form id="formaS" name="formaS">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="i_domicilio_s" class="col-sm-12 col-md-3 col-form-label l_requerido">Domicilio </label><br>
                                                <div class="col-sm-12 col-md-9">
                                                    <input type="text" class="form-control" id="i_domicilio_s" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="i_num_ext_s" class="col-sm-12 col-md-3 col-form-label l_requerido">Num. Ext </label><br>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" class="form-control validate[custom[integer]]" id="i_num_ext_s" name="i_num_ext_s" autocomplete="off">
                                                </div>

                                                <label for="i_num_int_s" class="col-sm-12 col-md-3 col-form-label">Num. Int </label><br>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" class="form-control" id="i_num_int_s" name="i_num_int_s" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_codigo_postal_s" class="col-2 col-md-2 col-form-label l_requerido">Código Postal </label><br>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="row">
                                                
                                                <div class="input-group col-sm-12 col-md-9">
                                                    <input type="text" id="i_codigo_postal_s" name="i_codigo_postal_s" class="form-control validate[custom[integer]minSize[5],maxSize[5]]" readonly autocomplete="off">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-primary" type="button" id="b_buscar_cp_s" style="margin:0px;">
                                                            <i class="fa fa-search" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <label for="for_pais_s" class="col-1 col-md-1 col-form-label l_requerido">País </label><br>
                                        <div class="col-sm-12 col-md-3">
                                            <select id="s_pais_s" name="s_pais_s" class="form-control" style="width:100%;"></select>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row">
                                        <label for="i_colonia_s" class="col-sm-2 col-md-1 col-form-label l_requerido">Colonia </label>
                                        <div class="col-sm-12 col-md-4">
                                            <input type="text" class="form-control" id="i_colonia_s" readonly>
                                        </div>
                                        <label for="i_entre_calles_s" class="col-sm-2 col-md-2 col-form-label">Entre Calles </label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control" id="i_entre_calles_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_id_municipio_s" class="col-2 col-md-2 col-form-label l_requerido">Municipio </label><br>
                                        <div class="col-sm-2 col-md-2">
                                            <input type="text" class="form-control" id="i_id_municipio_s" readonly>
                                        </div>
                                        <div class="col-sm-2 col-md-8">
                                            <input type="text" class="form-control" id="i_municipio_s" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_id_estado_s" class="col-2 col-md-2 col-form-label l_requerido">Estado </label><br>
                                        <div class="col-sm-2 col-md-2">
                                            <input type="text" class="form-control" id="i_id_estado_s" readonly>
                                        </div>
                                        <div class="col-sm-2 col-md-8">
                                            <input type="text" class="form-control" id="i_estado_s" readonly>
                                        </div>
                                    </div>
                                    </form>
                                 </div>   
                            </div>   
                            <br>

                            <div class="card">
                                <h5 class="card-header">Datos Contacto</h5>
                                <div  class="card-body">
                                    <form id="forma3" name="forma3">
                                    <div class="form-group row">
                                        <label for="i_telefonos" class="col-sm-2 col-md-2 col-form-label requerido">Teléfono(s) </label>
                                        <div class="col-sm-12 col-md-6">
                                            <input type="text" class="form-control validate[required]" id="i_telefonos" autocomplete="off">
                                        </div>
                                        <label for="i_extension" class="col-sm-2 col-md-2 col-form-label">Extensión </label>
                                        <div class="col-sm-12 col-md-2">
                                            <input type="text" class="form-control" id="i_extension" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_correos" class="col-sm-2 col-md-2 col-form-label">Correo </label>
                                        <div class="col-sm-12 col-md-6">
                                            <input type="text" class="form-control validate[custom[multiEmail]]" id="i_correos" autocomplete="off" placeholder="ejemplo: correo1@alarmas.com,correo2@alarmas.com">
                                        </div>
                                        <label for="i_celular" class="col-sm-2 col-md-2 col-form-label">Celular </label>
                                        <div class="col-sm-12 col-md-2">
                                            <input type="text" class="form-control" id="i_celular" name="i_celular" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_contacto" class="col-sm-2 col-md-2 col-form-label">Contacto </label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="i_contacto" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ta_otros_contactos" class="col-sm-2 col-md-2 col-form-label">Otros Contactos </label>
                                        <div class="col-sm-12 col-md-8">
                                            <textarea  class="form-control" id="ta_otros_contactos" name="ta_otros_contactos" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>  
                        

                <!-- TABLA PLANES-->
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="titulo_ban">Planes</div>
                        </div>
                        <div class="col-sm-12 col-md-9"></div>
                    </div>
                    <br>
                    <form id="forma4" name="forma4">
                    <div class="form-group row">
                        <label for="s_plan" class="col-sm-2 col-md-2 col-form-label requerido">Plan </label>
                        <div class="col-sm-4 col-md-4">
                            <select class="form-control validate[required]" id="s_plan" name="s_plan" autocomplete="off"></select>
                        </div>
                        
                        <div class="col-sm-12 col-md-6">
                        
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                   Recibo <input type="radio" name="r_recibo_factura" id="r_recibo" value="R" checked> 
                                </div>
                                <div class="col-sm-12 col-md-3">
                                   Factura <input type="radio" name="r_recibo_factura" id="r_factura" value="F" > 
                                </div>
                            
                            </div>
                        </div>
                    </div>

                    <div class="div_datos_facturas">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="s_cfdi" class="col-form-label ">Uso de CFDI </label>
                                <select id="s_cfdi" name="s_cfdi" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                            <div class="col-md-4">
                                <label for="s_metodo_pago" class="col-form-label ">Método de Pago </label>
                                <select id="s_metodo_pago" name="s_metodo_pago" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                            <div class="col-md-4">
                                <label for="s_forma_pago" class="col-form-label ">Forma de Pago </label>
                                <select id="s_forma_pago" name="s_forma_pago" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-7">
                                <label for="s_clave_sat_s" class="col-form-label ">Clave SAT del Producto/Servicio </label>
                                <select id="s_clave_sat_s" name="s_clave_sat_s" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                            <div class="col-md-4">
                                <label for="s_id_unidades_s" class="col-form-label ">Unidad SAT </label>
                                <select id="s_id_unidades_s" name="s_id_unidades_s" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="i_descripcion_s" class="col-md-2 col-form-label ">Descripción</label>
                            <div class="col-md-10">
                                <textarea type="text" id="i_descripcion_s" name="i_descripcion_s" class="form-control form-control-sm validate[]"  autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-md-2 col-form-label requerido">Entrega: </label>
                        
                        <div class="col-sm-4 col-md-4">
                        
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <input type="checkbox" name="ch_fisico" id="ch_fisico" value="0"> Físico
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <input type="checkbox" name="ch_correo" id="ch_correo" value="1"> Correo Electrónico  
                                </div>
                            
                            </div>
                        </div>

                        <label for="i_fecha_corte" id="label_fecha_corte" class="col-sm-12 col-md-1 col-form-label requerido">Día </label>
                        <div class="col-sm-12 col-md-1" id="contenedor_dia">
                            <input type="text" class="form-control validate[required,custom[integer],min[1],max[31]]" id="i_fecha_corte" autocomplete="off">
                        </div>
                    </div>

                    </form>
                    <div class="form-group row">

                        <label for="i_pago" class="col-sm-2 col-md-2 col-form-label requerido">Pago: </label>
                        
                        <div class="col-sm-4 col-md-4">
                        
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <input type="radio" name="r_pago" id="r_efectivo" value="E" checked> Efectivo
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <input type="radio" name="r_pago" id="r_trasferencia" value="T">Trasferenecia  
                                </div>
                            
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <button type="button" class="btn btn-danger btn-sm form-control" id="b_instalacion"><i class="fa fa-wrench" aria-hidden="true"></i> Instalación</button>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="ta_especificaciones" class="col-sm-2 col-md-2 col-form-label">Especificaciones Cobranza </label>
                        <div class="col-sm-12 col-md-8">
                            <textarea  class="form-control" id="ta_especificaciones" name="ta_especificaciones" autocomplete="off"></textarea>
                        </div>
                    </div>
                   
                    <div class="alert alert-primary col-sm-12 col-md-2" role="alert">
                        BITÁCORA
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon"  id="t_bitacora_planes">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Plan</th>
                                    <th scope="col">Recibo</th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Entrega<br> Fisica</th>
                                    <th scope="col">Entrega<br> Correo</th>
                                    <th scope="col">Dia de<br> Corte</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Especificaciones <br>Cobranza</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        
                            </table>  
                        </div>
                    </div>
                         

                <div class="row">
                    
                    <div class="col-sm-12 col-md-4"> </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_SERVICIOS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                        </form>
                    </div>
                </div>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

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

<div id="dialog_buscar_servicios_saldos_pendientes" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Saldos Pendientes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <!-- <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_saldos" id="i_filtro_saldos" class="form-control filtrar_renglones" alt="renglon_saldos" placeholder="Filtrar" autocomplete="off"></div>
            </div>     -->
            <!-- <br> -->
            <div class="row">
                <div class="col-12">
                    <table class="tablon"  id="t_saldos_pendientes">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Fecha</th>
                          <th scope="col">Referencia</th>
                          <th scope="col">Folio Cxc</th>
                          <th scope="col">Folio Factura</th>
                          <th scope="col">Fecha Venc</th>
                          <th scope="col">Concepto</th>
                          <th scope="col">Subtotal</th>
                          <th scope="col">Cargos</th>
                          <th scope="col">Abonos</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Total Cargos</span>
                        </div>
                        <input type="text" class="form-control" id="total_cargos_saldos_pendientes" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                            <span class="input-group-text">Total Abonos</span>
                        </div>
                        <input type="text" class="form-control" id="total_abonos_saldos_pendientes" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                            <span class="input-group-text">Saldo</span>
                        </div>
                        <input type="text" class="form-control" id="total_saldo_saldos_pendientes" readonly>
                    </div>
                </div>
            </div> -->
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
  
    var idServicio=<?php echo $idServicio?>;
    var cuentaOriginal='';
    var tipoMov=0;
    var modulo='SERVICIOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var regresar=<?php echo $regresar?>;
    var buscarCPF=0;
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        verificarPermisosAlarmas(idUsuario,idUnidadActual);
        muestraSelectPaises('s_pais');
        muestraSelectPaises('s_pais_s');
        buscarCuenta();
        muestraSelectUsoCFDI('s_cfdi');
        muestraSelectMetodoPago('s_metodo_pago');
        muestraSelectClaveProductoSAT('s_clave_sat_s');
        muestraSelectClaveUnidadesSAT('s_id_unidades_s');

        //-->NJES December/15/2020 agregar combo tipo de panel
        muestraSelectTipoPanel('s_tipo_panel');

        $('#b_instalacion').attr('alt',0).prop('disabled',true);
        $('#ch_activo').prop('checked',true).prop('disabled',true);  
        $('#r_16').prop('checked',true);
        if(regresar==1){
            
            $('#b_nuevo').click();
            
        }

        //-->NJES March/23/2021 segun la sucursal mostrar los planes
        $('#s_id_sucursales').change(function()
        {
            //console.log(' ** ' + $('#s_id_sucursales').val());
            muestraSelectPlanes('s_plan',$('#s_id_sucursales').val());
        });

        function buscarCuenta(){

            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar_cuenta.php',
                data:{'estatus':2
                },
                success: function(data) {
                    $('#i_cuenta').val(data);
                },
                error: function (xhr) {
                    console.log('php/servicios_buscar_cuenta.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#s_plan').change(function(){
           var tipoPlan = $('#s_plan option:selected').attr('tipo');

           generaCampoDia(tipoPlan,'');

        });

        $('input[name=r_recibo_factura]').change(function(){

            if($("#r_factura").is(':checked')) 
                $('.div_datos_facturas').css('display','block');
            else
                $('.div_datos_facturas').css('display','none');
            
        }); 
        
        $('#s_metodo_pago').change(function(){
            var tipo = $(this).val();
            muestraSelectFormaPago(tipo,'s_forma_pago');
        });

        function generaCampoDia(tipo,valor){

            if(tipo == 1)
            {
                    $('#label_fecha_corte').removeClass('col-md-1').addClass('col-md-2').text('Fecha Inicio Cobro');
            }else{
                    $('#label_fecha_corte').removeClass('col-md-2').addClass('col-md-1').text('Día');
            }
           
            $('#contenedor_dia').removeClass('col-md-1').html('');

            switch(parseInt(tipo))
            {
                case 1:  //anual
                    var html='<input type="text" id="i_fecha_corte" name="i_fecha_corte"  class="form-control validate[required] fecha" readonly autocomplete="off" value="'+valor+'" >';
                    $('#contenedor_dia').addClass('col-md-2').append(html);
                    $('.fecha').datepicker({
                        format : "yyyy-mm-dd",
                        autoclose: true,
                        language: "es",
                        todayHighlight: true
                    }); 
                break;
                case 3:  //quincenal
                    var html='<select class="form-control validate[required]" id="i_fecha_corte" name="i_fecha_corte" autocomplete="off" style="width:100%;">';
                        html+='<option value="0" disabled selected>Selecciona</option>';   
                        html+='<option value="Q1">01 - 16</option>';
                        html+='<option value="Q2">02 - 17</option>';
                        html+='<option value="Q3">03 - 18</option>';
                        html+='<option value="Q4">04 - 19</option>';
                        html+='<option value="Q5">05 - 20</option>';
                        html+='<option value="Q6">06 - 21</option>';
                        html+='<option value="Q7">07 - 22</option>';
                        html+='<option value="Q8">08 - 23</option>';
                        html+='<option value="Q9">09 - 24</option>';
                        html+='<option value="Q10">10 - 25</option>';
                        html+='<option value="Q11">11 - 26</option>';
                        html+='<option value="Q12">12 - 27</option>';
                        html+='<option value="Q13">13 - 28</option>';
                        html+='<option value="Q14">14 - 29</option>';
                        html+='<option value="Q15">15 - 30</option>';
                        html+='</select>';
                    $('#contenedor_dia').removeClass('col-md-1').addClass('col-md-2').append(html);  
                    $('#i_fecha_corte').val(valor);
                break;
                case 4:  //semanal
                    var html='<select class="form-control validate[required]" id="i_fecha_corte" name="i_fecha_corte" autocomplete="off" style="width:100%;">';
                        html+='<option value="0" disabled selected>Selecciona</option>';   
                        html+='<option value="L">Lunes</option>';
                        html+='<option value="M">Martes</option>';
                        html+='<option value="X">Miercoles</option>';
                        html+='<option value="J">Jueves</option>';
                        html+='<option value="V">Viernes</option>';
                        html+='<option value="S">Sabado</option>';
                        html+='<option value="D">Domingo</option>';
                        html+='</select>';
                    $('#contenedor_dia').removeClass('col-md-1').addClass('col-md-2').append(html);  
                    $('#i_fecha_corte').val(valor);
                break;
                default:  //mensual ó sin plan
                    var html='<input type="text" class="form-control validate[required,custom[integer],min[1],max[31]]" id="i_fecha_corte" autocomplete="off" value="'+valor+'">';
                    $('#contenedor_dia').removeClass('col-md-2').addClass('col-md-1').append(html);
            }

        }

        $('input[name=r_recibo_factura]').on('change',function(){

            $('#forma').validationEngine('hide');

            if($('input[name=r_recibo_factura]:checked').val()=='R'){
               
                validacionRecibo();

            }else{
                
                validacionFactura();

            }

        });


        function validacionRecibo(){
            $(document).find('.l_requerido').removeClass('requerido');
            $('#i_razon_social').addClass('form-control dato_fiscal');
            $('#i_rfc').removeAttr('class').addClass('form-control validate[minSize[12],maxSize[13],custom[onlyLetterNumberN]] dato_fiscal');
            $('#i_domicilio').removeAttr('class').addClass('form-control dato_fiscal');
            $('#i_codigo_postal').removeAttr('class').addClass('form-control validate[custom[integer],minSize[5],maxSize[5]] dato_fiscal');
            $('#i_colonia').removeAttr('class').addClass('form-control dato_fiscal');
            $('#i_num_ext').removeAttr('class').addClass('form-control dato_fiscal');
            $('#i_num_int').removeAttr('class').addClass('form-control dato_fiscal');
            $('#s_pais').removeClass('validate[required]');
            $('#i_id_estado').removeAttr('class').addClass('form-control validate[custom[integer]] dato_fiscal');
            $('#i_estado').removeAttr('class').addClass('form-control dato_fiscal');
            $('#i_id_municipio').removeAttr('class').addClass('form-control validate[custom[integer]] dato_fiscal');
            $('#i_municipio').removeAttr('class').addClass('form-control dato_fiscal');
        }

        function validacionFactura(){
            $(document).find('.l_requerido').addClass('requerido');
            $('#i_razon_social').addClass('form-control  validate[required] dato_fiscal').prop('disabled',false);
            $('#i_rfc').removeAttr('class').addClass('form-control validate[required,minSize[12],maxSize[13],custom[onlyLetterNumberN]] dato_fiscal').prop('disabled',false);
            $('#i_domicilio').removeAttr('class').addClass('form-control validate[required] dato_fiscal');
            $('#i_codigo_postal').removeAttr('class').addClass('form-control validate[required,custom[integer],minSize[5],maxSize[5]] dato_fiscal');
            $('#i_colonia').removeAttr('class').addClass('form-control validate[required] dato_fiscal');
            $('#i_num_ext').removeAttr('class').addClass('form-control validate[required] dato_fiscal');
            $('#i_num_int').removeAttr('class').addClass('form-control validate[required] dato_fiscal');
            $('#s_pais').addClass('validate[required]');
            $('#i_id_estado').removeAttr('class').addClass('form-control validate[required,custom[integer]] dato_fiscal');
            $('#i_estado').removeAttr('class').addClass('form-control validate[required] dato_fiscal');
            $('#i_id_municipio').removeAttr('class').addClass('form-control validate[required,custom[integer]] dato_fiscal');
            $('#i_municipio').removeAttr('class').addClass('form-control validate[required] dato_fiscal');

        }
        
        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_servicios').val('');
            $('.renglon_servicios').remove();

            var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);
   
            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar2.php',
                dataType:"json", 
                data:{'estatus':2,'idSucursal':idSucursal},
                success: function(data) {
                   console.log(data);
                   if(data.length != 0){

                        $('.renglon_servicios').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                           
                            if(data[i].activo == 1){

                                var activo='Activo';
                            }else{
                                var activo='Inactivo';
                            }

                            var html='<tr class="renglon_servicios" alt="'+data[i].id+'" metodo="'+data[i].metodo_pago+'">\
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

        $('#t_servicios').on('click', '.renglon_servicios', function() {
            
            tipoMov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_activo').prop('disabled', false);
            idServicio = $(this).attr('alt');
            var metodoPago = $(this).attr('metodo');
            muestraSelectFormaPago(metodoPago,'s_forma_pago');
            $('#b_instalacion').attr('alt',idServicio).prop('disabled',false);      
            $("#b_saldos_pendientes").prop("disabled", false);
           
            $('#dialog_buscar_servicios').modal('hide');
            
            muestraSelectPaises('s_pais');
            muestraRegistro();
           
        });

        $("#b_saldos_pendientes").on("click",function(){
            idServicio = $('#b_instalacion').attr('alt');

            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar_saldos_pendientes.php',
                dataType:"json", 
                data:{idServicio},
                success: function(data) {
                    // console.log(data);
                    if(data.length != 0){

                            $('.renglon_saldos').remove();
                            let totalCargos = 0;
                            let totalAbonos = 0;
                    
                            for(var i=0;data.length>i;i++){

                                ///llena la tabla con renglones de registros
                            
                                if(data[i].activo == 1){

                                    var activo='Activo';
                                }else{
                                    var activo='Inactivo';
                                }

                                /*

                                <th scope="col" width="15%">Fecha</th>
                                <th scope="col" width="10%">Referencia</th>
                                <th scope="col" width="15%">Folio Cxc</th>
                                <th scope="col" width="15%">Folio Factura</th>
                                <th scope="col" width="15%">Fecha Venc</th>
                                <th scope="col" width="10%">Concepto</th>
                                <th scope="col" width="10%">Cargos</th>
                                <th scope="col" width="10%">Abonos</th>

                                */

                                if(data[i].cargos == "0.00"){
                                    totalCargos += parseFloat(data[i].subtotal);
                                }else{
                                    totalCargos += parseFloat(data[i].cargos);
                                }
                                totalAbonos += parseFloat(data[i].abonos);

                                // console.log(totalCargos, totalAbonos);

                                var html='<tr class="renglon_saldos">\
                                            <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                            <td data-label="Referencia">' + data[i].referencia+ '</td>\
                                            <td data-label="Folio Cxc">' + data[i].folio+ '</td>\
                                            <td data-label="Folio Factura">' + data[i].folio_factura+ '</td>\
                                            <td data-label="fecha Venc">' + data[i].fecha_vencimiento+ '</td>\
                                            <td data-label="Concepto">' + data[i].concepto+ '</td>\
                                            <td data-label="Subtotal">' + data[i].subtotal+ '</td>\
                                            <td data-label="Cargos">' + data[i].cargos+ '</td>\
                                            <td data-label="Abonos">' + data[i].abonos+ '</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_saldos_pendientes tbody').append(html);   
                            }

                            let saldo = totalCargos - totalAbonos;

                            var html='<tr class="renglon_saldos">\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label="">TOTALES</th>\
                                            <th data-label="Cargos">' + formatearNumero(totalCargos) + '</th>\
                                            <th data-label="Abonos">' + formatearNumero(totalAbonos) + '</th>\
                                        </tr>\
                                        <tr class="renglon_saldos">\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label=""></th>\
                                            <th data-label="">SALDO</th>\
                                            <th data-label="">' + formatearNumero(saldo) + '</th>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                            $('#t_saldos_pendientes tbody').append(html);   
                            
                            // $("#total_cargos_saldos_pendientes").val(totalCargos);
                            // $("#total_abonos_saldos_pendientes").val(totalAbonos);
                            // $("#total_saldo_saldos_pendientes").val(totalCargos - totalAbonos);


                            $('#dialog_buscar_servicios_saldos_pendientes').modal('show');   

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

        function muestraRegistro()
        {
            
            $.ajax({
                type: 'POST',
                url: 'php/servicios_buscar_id.php',
                dataType:"json", 
                data:{
                    'idServicio':idServicio
                },
                success: function(data) {
                  
                    idServicio=data[0].id;
                    cuentaOriginal=data[0].cuenta;
                   
                    $('#i_id_servicio').val(idServicio);
                    $('#i_cuenta').val(data[0].cuenta);
                    $('#i_nombre_corto').val(data[0].nombre_corto);
                    $('#i_razon_social').val(data[0].razon_social).prop('disabled',true);;
                    $('#i_representante').val(data[0].r_legal);
                    $('input[name=radio_iva]').prop('checked',false);   
                    
                    if(parseInt(data[0].porcentaje_iva) == 16){
                        $('#r_16').prop('checked',true);
                    }else if(data[0].porcentaje_iva == 8){
                        $('#r_8').prop('checked',true);
                    }

                    if(data[0].id_sucursal != 0)
                    {
                        $('#s_id_sucursales').val(data[0].id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_sucursales').val('');
                        $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
                    }

                    muestraSelectPlanes('s_plan', data[0].id_sucursal); 

                    //-->NJES December/15/2020 agregar combo tipo de panel
                    if(data[0].id_tipo_panel != 0)
                    {
                        $('#s_tipo_panel').val(data[0].id_tipo_panel);
                        $('#s_tipo_panel').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_tipo_panel').val('');
                        $('#s_tipo_panel').select2({placeholder: 'Seleccione'});
                    }
                   

                    $('#i_rfc').val(data[0].rfc).prop('disabled',true);
                    //---DATOS FISCALES-----
                    $('#i_domicilio').val(data[0].domicilio);
                    $('#i_codigo_postal').val(data[0].codigo_postal);
                    $('#i_colonia').val(data[0].colonia);
                    $('#i_num_ext').val(data[0].no_exterior);
                    $('#i_num_int').val(data[0].no_interior);

                    if(parseInt(data[0].id_pais) != 0)
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

                    //---DATOS SERVICIO-----
                    $('#i_domicilio_s').val(data[0].domicilio_s);
                    $('#i_codigo_postal_s').val(data[0].codigo_postal_s);
                    $('#i_colonia_s').val(data[0].colonia_s);
                    $('#i_num_ext_s').val(data[0].no_exterior_s);
                    $('#i_num_int_s').val(data[0].no_interior_s);
                    $('#i_entre_calles_s').val(data[0].entre_calles_s);

                    if(parseInt(data[0].id_pais_s) != 0)
                    {
                        $('#s_pais_s').val(data[0].id_pais_s);
                        $('#s_pais_s').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_pais_s').val('');
                        $('#s_pais_s').select2({placeholder: 'Selecciona'});
                    }

                    $('#i_id_estado_s').val(data[0].id_estado_s);
                    $('#i_estado_s').val(data[0].estado_s);
                    $('#i_id_municipio_s').val(data[0].id_municipio_s);
                    $('#i_municipio_s').val(data[0].municipio_s);
                    
                    $('#i_telefonos').val(data[0].telefonos);
                    $('#i_celular').val(data[0].celular);

                    $('#i_extension').val(data[0].ext);
                    $('#i_correos').val(data[0].correos);
                    $('#i_contacto').val(data[0].contacto);
                    $('#ta_otros_contactos').val(data[0].otros_contactos);
                    if(data[0].digitos_cuenta==0){
                        $('#i_digitos_cuenta').val('');
                    }else{
                        $('#i_digitos_cuenta').val(data[0].digitos_cuenta);
                    }
                  

                    if (data[0].activo == 0) {
                        $('#ch_activo').prop('checked', false);
                    } else {
                        $('#ch_activo').prop('checked', true);
                    }
                   
                    if(parseInt(data[0].id_plan) != 0)
                    {
                        $('#s_plan').val(data[0].id_plan);
                        $('#s_plan').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_plan').val('');
                        $('#s_plan').select2({placeholder: 'Selecciona'});
                    }
                    
                    $('input[name=r_recibo_factura]').prop('checked', false);
                    if (data[0].tipo_recibo_facura == 'R') {
                        $('#r_recibo').prop('checked', true);
                        validacionRecibo();
                        $('.div_datos_facturas').css('display','none');

                    } else {
                        $('#r_factura').prop('checked', true);
                        validacionFactura();
                        
                        $('.div_datos_facturas').css('display','block');
                        $('#s_cfdi').val(data[0].uso_cfdi);
                        $('#s_cfdi').select2({placeholder: $(this).data('elemento')});

                        $('#s_metodo_pago').val(data[0].metodo_pago);
                        $('#s_metodo_pago').select2({placeholder: $(this).data('elemento')});

                        $('#s_forma_pago').val(data[0].forma_pago);
                        $('#s_forma_pago').select2({placeholder: $(this).data('elemento')});

                        $('#s_clave_sat_s').val(data[0].producto_sat);
                        $('#s_clave_sat_s').select2({placeholder: $(this).data('elemento')});

                        $('#s_id_unidades_s').val(data[0].unidad_sat);
                        $('#s_id_unidades_s').select2({placeholder: $(this).data('elemento')});

                        $('#i_descripcion_s').val(data[0].descripcion);
                    }

                    if (data[0].entrega == 0) {
                        $('#ch_fisico').prop('checked', true);
                    } else if (data[0].entrega == 1) {
                        $('#ch_correo').prop('checked', true);    
                    } else {
                        $('#ch_fisico').prop('checked', true);
                        $('#ch_correo').prop('checked', true);
                    }

                    //$('#i_fecha_corte').val(data[0].dia_corte);
                    generaCampoDia(data[0].tipo_plan,data[0].dia_corte);

                    $('input[name=r_pago]').prop('checked', false);
                    
                    if (data[0].pago == 'E') {
                        $('#r_efectivo').prop('checked', true);
                    } else {
                        $('#r_trasferencia').prop('checked', true);
                    }

                    $('#ta_especificaciones').val(data[0].especificaciones_cobranza);

                    $('#b_instalacion').prop('disabled',false);
                    muestraBitacora();
                   
                },
                error: function (xhr) {
                    console.log('php/servicios_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }


        function muestraBitacora(){
           
            $('.renglon_servicios').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar_bitacora.php',
                dataType:"json", 
                data:{'idServicio':idServicio},

                success: function(data) {
                   
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

                            var html='<tr class="renglon_servicios" alt="'+data[i].id+'" >\
                                        <td data-label="ID">' + data[i].plan+ '</td>\
                                        <td data-label="RFC">' + data[i].recibo+ '</td>\
                                        <td data-label="Nombre">' + data[i].factura+ '</td>\
                                        <td data-label="Razón Social">' + data[i].entrega_fisica+ '</td>\
                                        <td data-label="Razón Social">' + data[i].entrega_correo+ '</td>\
                                        <td data-label="Razón Social">' + data[i].dia_corte+ '</td>\
                                        <td data-label="Razón Social">' + data[i].fecha_captura+ '</td>\
                                        <td data-label="Especificaciones">' + data[i].especificaciones_cobranza+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_bitacora_planes tbody').append(html);   
                           
                        }
                   }else{

                        //mandarMensaje('No se encontró información en Bitácora');
                   }

                },
                error: function (xhr) {
                    console.log('php/servicios_buscar_bitacora.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#b_guardar').click(function(){
          
           $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate') && $('#forma2').validationEngine('validate') && $('#forma3').validationEngine('validate') && $('#forma4').validationEngine('validate')){
                
                guardar();
    
            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });

        $('#i_cuenta').on('change',function(){
            verificar();
        });


        function verificar(){

            $.ajax({
                type: 'POST',
                url: 'php/servicios_verificar.php',
                data:  {'cuenta':$('#i_cuenta').val()},
                success: function(data) 
                {
                    
                    if(data == 1){
                        
                        if (tipoMov == 1 && cuentaOriginal === $('#i_cuenta').val()) {
                           
                        } else {

                            mandarMensaje('La Cuenta: '+ $('#i_cuenta').val()+' ya existe intenta con otra');
                            $('#i_cuenta').val('');
                            buscarCuenta();
                            
                        }
                    } 
                },
                error: function (xhr) {
                    buscarCuenta();
                    console.log('php/servicios_verificar.php->'+JSON.stringify(xhr));
                    mandarMensaje('*Ocurrio un error al verificar la cuenta');
                }
            });
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){
          
         $.ajax({
                type: 'POST',
                url: 'php/servicios_guardar.php', 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                  console.log(data);
                    if (data > 0 ) {
                        if (tipoMov == 0){
                            
                            mandarMensaje('Se guardó el nuevo registro');
                            $('#b_nuevo').click();
    
                        }else{
                                
                            mandarMensaje('Se actualizó el registro');
                            $('#b_nuevo').click();
                               
                        }
                      

                    }else{
                           
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                   console.log('php/servicios_guardar.php ->'+JSON.stringify(xhr));
                    mandarMensaje("Ha ocurrido un error.");
                    $('#b_guardar').prop('disabled',false);
                }
            });
           
        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var entrega=0;
            if($("#ch_fisico").is(':checked') && $('#ch_correo').is(':checked')){
                entrega=2;
            }else{

                if($("#ch_correo").is(':checked')){
                    entrega=1;
                }

            }

            var paq = {
                    'tipoMov' : tipoMov,
                    'idServicio' : idServicio,
                    'idSucursal' : $('#s_id_sucursales').val(),
                    'cuenta' : $('#i_cuenta').val(),
                    'nombreCorto' : $('#i_nombre_corto').val(),
                    'razonSocial' : $('#i_razon_social').val(),
                    'rfc' : $('#i_rfc').val(),
                    'representanteLegal' : $('#i_representante').val(),
                    'tasaIva' : $('input[name=radio_iva]:checked').val(),

                    'domicilio' : $('#i_domicilio').val(),
                    'codigoPostal' : $('#i_codigo_postal').val(),
                    'colonia' : $('#i_colonia').val(),
                    'numInt' : $('#i_num_int').val(),
                    'numExt' : $('#i_num_ext').val(),
                    'idPais' : $('#s_pais').val(),
                    'idEstado' : $('#i_id_estado').val(),
                    'idMunicipio' : $('#i_id_municipio').val(),

                    'domicilioS' : $('#i_domicilio_s').val(),
                    'codigoPostalS' : $('#i_codigo_postal_s').val(),
                    'coloniaS' : $('#i_colonia_s').val(),
                    'entreCallesS' : $('#i_entre_calles_s').val(),
                    'numIntS' : $('#i_num_int_s').val(),
                    'numExtS' : $('#i_num_ext_s').val(),
                    'idPaisS' : $('#s_pais_s').val(),
                    'idEstadoS' : $('#i_id_estado_s').val(),
                    'idMunicipioS' : $('#i_id_municipio_s').val(),

                    'telefonos' : $('#i_telefonos').val(),
                    'correos' : $('#i_correos').val(),
                    'extension' : $('#i_extension').val(),
                    'celular' : $('#i_celular').val(),
                    'contacto' : $('#i_contacto').val(),
                    'otrosContactos' : $('#ta_otros_contactos').val(),
                    'digitos_cuenta' : $('#i_digitos_cuenta').val(),

                    'usoCFDI' : $('#s_cfdi').val(),
                    'metodoPago' : $('#s_metodo_pago').val(),
                    'formaPago' : $('#s_forma_pago').val(),
                    'productoSAT' : $('#s_clave_sat_s').val(),
                    'nombreProducto' : $('#s_clave_sat_s option:selected').attr('alt'),
                    'unidadSAT' : $('#s_id_unidades_s').val(),
                    'nombreUnidad' : $('#s_id_unidades_s option:selected').attr('alt'),
                    'descripcion' : $('#i_descripcion_s').val(),

                    'idPlan' : $('#s_plan').val(),
                    'tipoReciboFactura' : $('input[name=r_recibo_factura]:checked').val(),
                    'tipoEntrega' :entrega,
                    'fechaCorte' : $('#i_fecha_corte').val(),
                    'tipoPago' : $('input[name=r_pago]:checked').val(),
                    'idUsuario' : idUsuario,
                    'modulo' : 'SERVICIOS',
                    'activo' : $('#ch_activo').is(':checked') ? 1 : 0,
                    'especificacionesCobranza' : $('#ta_especificaciones').val(),

                    'idTipoPanel' : $('#s_tipo_panel').val()
                }

                paquete.push(paq);
              
            return paquete;
        }   
        
        //************Busca los cp por estado y municipio */
        $('#b_buscar_cp').on('click',function(){
            buscarCPF=1;
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();
            muestraSelectEstados('s_estados');
            muestraSelectMunicipios('s_municipios',0);
            $('#dialog_buscar_cp').modal('show'); 

        });

         //************Busca los cp por estado y municipio */
         $('#b_buscar_cp_s').on('click',function(){
            buscarCPF=0;
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();
            muestraSelectEstados('s_estados');
            muestraSelectMunicipios('s_municipios',0);
            $('#dialog_buscar_cp').modal('show'); 

        });

        $(document).on('change','#s_estados',function(){
            buscarCp($('#s_estados').val(),0);
            muestraSelectMunicipios('s_municipios',$('#s_estados').val());
        });
        $(document).on('change','#s_municipios',function(){
            buscarCp($('#s_estados').val(),$('#s_municipios').val());
        });

        function buscarCp(idEstado,idMunicipio){
           
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();

            $.ajax({

                type: 'POST',
                url: 'php/codigo_postal_buscar.php',
                dataType:"json", 
                data:{
                    'idEstado':idEstado,
                    'idMunicipio': idMunicipio
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
            //---MGFS 14-02-2020 Si buscarCPF=1 es que esta buscando cp fiscal si buscarCPF=0 es el cp servicio
            if(buscarCPF==1){
                $('#i_codigo_postal').val(cp).validationEngine('hide');
                $('#i_colonia').val(colonia).attr('alt',idColonia).validationEngine('hide');
                $('#i_id_estado').val(idEstado).validationEngine('hide');
                $('#i_id_municipio').val(idMunicipio).validationEngine('hide');
                $('#i_estado').val(estado).validationEngine('hide');
                $('#i_municipio').val(municipio).validationEngine('hide');
            }else{
                $('#i_codigo_postal_s').val(cp).validationEngine('hide');
                $('#i_colonia_s').val(colonia).attr('alt',idColonia).validationEngine('hide');
                $('#i_id_estado_s').val(idEstado).validationEngine('hide');
                $('#i_id_municipio_s').val(idMunicipio).validationEngine('hide');
                $('#i_estado_s').val(estado).validationEngine('hide');
                $('#i_municipio_s').val(municipio).validationEngine('hide');
            }

           
               
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

         
        
       
        

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idServicio=0;
            cuentaOriginal='';
            tipoMov=0;
            $('input,textarea').not('input:radio,input:checkbox').val('');
            $('#i_familia').attr('alt',0);
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_activo').prop('checked',false).prop('disabled',true);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            buscarCuenta();
            $('#r_recibo').prop('checked',true);
            $('#ch_fisico').prop('checked',false);
            $('#ch_correo').prop('checked',false);
            $('#r_efectivo').prop('checked',true);

            validacionRecibo();

            $('#ch_activo').prop('checked',true).prop('disabled',true);
            $('#b_instalacion').attr('alt',0).prop('disabled',true);
            
            $('.renglon_servicios').remove();
            $('#i_rfc').prop('disabled',false);
            $('#i_razon_social').prop('disabled',false);
            $('input[name=radio_iva]').prop('checked',false);   
            $('#r_16').prop('checked',true);
            $('.div_datos_facturas').css('display','none');

            muestraSelectTipoPanel('s_tipo_panel');
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Servicios');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('SERVICIOS');
            
            $("#f_imprimir_excel").submit();
        });

        $('#b_asignar_unidades').on('click',function(){
            var idServicio=0;
            var proveedor='';
            if($('#i_id_servicio').val()!=''){
                idServicio=$('#i_id_servicio').val();
                proveedor=$('#i_nombre').val();
            }
            window.open("fr_proveedores_accesos.php?idServicio="+idServicio+"&proveedorP="+proveedor,"_self");
        });

        $('#b_instalacion').on('click',function(){
            var idServicio=$(this).attr('alt');
            window.open("fr_servicios_ordenes.php?idServicio="+idServicio+"&razonSocial="+$('#i_razon_social').val()+"&nombreCorto="+$('#i_nombre_corto').val()+"&cuenta="+$('#i_cuenta').val()+"&idSucursal="+$('#s_id_sucursales').val()+"&regresar=1"+"&tipo=instalacion","_self");
        });
    });

</script>

</html>