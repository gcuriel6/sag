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
    #fondo_cargando{
        position: absolute;
        background-image:url('imagenes/3.svg');
        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:1%;
        border-radius: 5px;
        z-index:2000;
        display:none;
    }
    body{
        background-color:rgb(238,238,238);
    }
    #div_principal{
        padding-top:20px;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #span_resumen_inversion{
        color:blue; 
        font-size: 23px;
    }
    #div_card_elementos,#div_card_equipo,#div_card_servicios,#div_card_vehiculos{
        display:none;
    }
    .mb-0 > span{
        float: right;
    }
    #c_precio_total_elemento,#c_precio_total_equipo,#c_precio_total_servicio,#c_precio_total_vehiculo{
       color:#000099;
    }
    button{
        cursor: pointer;
    }
    #l_estatus{ 
        padding: 3px 10px; 
        color: #fff;
        width:100%;
    }
    #i_folio{
        font-weight:bold;
    }
    #vehiculo_d,#servicio_d,#equipo_d{
        font-size:11px;
        color:#006600;
    }
    #div_b_elemento_a,#div_b_equipo_a,#div_b_servicio_a,#div_b_vehiculo_a{
        display: block;
    }
    #div_b_elemento_b,#div_b_equipo_b,#div_b_servicio_b,#div_b_vehiculo_b{
        display: none;
    }
    .listas_niv_dos{
        list-style: none;
    }
    #span_indica{
        font-size:11px;
        color:#006600;
    }
    #div_lista_elemento{
        overflow-y:auto;
    }
    .span_seccion{
        font-size:11px;
        color:#006600;
    }

    @media screen and(max-width: 1030px){
        .modal-lg{
            min-width: 800px;
            max-width: 800px;
        }
    }

    @media screen and (max-width: 700px) {
        #div_b_elemento_a,#div_b_equipo_a,#div_b_servicio_a,#div_b_vehiculo_a{
            display: none;
        }
        #div_b_elemento_b,#div_b_equipo_b,#div_b_servicio_b,#div_b_vehiculo_b{
            display: block;
        }
        #b_nuevo,#b_buscar,#b_guardar,#b_aprobar_cotizacion,#b_imprimir,#b_version{
            margin-bottom:10px;
        }
    }

    @media screen and (max-width: 600px) {
        .modal-dialog{
            max-width: 300px;
        }
    }
    #dialog_cotizaciones {
        overflow-y:auto;
    }

    #dialog_cotizaciones >  .modal-lg{
   
            min-width: 97%;
            max-width: 97%;
    }

    #leyenda_comision{
        color:#006600;
    }
    #div_comision_resumen{
        color:red;
    }
</style>

<body>
    <div id="fondo_cargando"></div>

    <div class="container-fluid" id="div_principal"> <!--div_principal-->

        <div class="row"> <!--div_row-->
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor"> <!--div_contenedor-->
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Cotización</div>
                    </div>
                    <div class="col-sm-12 col-md-4"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-4">
                        <span id="dato_fecha_creacion"></span>
                    </div>
                </div>
                <br><br>

                <div class="row"> <!--botones inicio-->
                    <div class="col-sm-12 col-md-3 div_botones_alt2"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Limpia campos pantalla" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Busca Cotizaciones" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Guardar/Editar" class="btn btn-dark btn-sm form-control" id="b_guardar" disabled><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2 div_botones_alt" style="display:none;">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Aprueba la cotización" class="btn btn-dark btn-sm form-control verificar_permiso" id="b_aprobar_cotizacion" alt="BOTON_CERRAR_COTIZACION"><i class="fa fa-eye" aria-hidden="true"></i> Cerrar</button>
                    </div>
                    <div class="col-sm-12 col-md-2 div_botones_alt" style="display:none;">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Imprime la cotización" class="btn btn-dark btn-sm form-control" id="b_imprimir" ><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                        <form id="f_imprimir" action="php/imprime_reporte.php" method="POST" target="_blank">
                            <input type="hidden" id="i_t_inicio_im" name='texto_inicio'>
                            <input type="hidden" id="i_t_fin_im" name='texto_fin'>
                            <input type="hidden" id="i_registro_im" name='registro'>
                            <input type="hidden" id="i_cotizacion" name='i_cotizacion'>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-2 div_botones_alt" style="display:none;">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Crea una nueva versión de la cotización" class="btn btn-dark btn-sm form-control" id="b_version"><i class="fa fa-files-o" aria-hidden="true"></i> Crear Versión</button>
                    </div>
                    <div class="col-sm-12 col-md-3 div_botones_alt2"></div>
                </div>  <!--botones fin-->
                <br>

                <form id="form_datos_proyecto" name="form_datos_proyecto"> <!--datos proyecto inicio-->
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="row">
                                <label id="i_folio" class="col-sm-12 col-md-12"></label>
                            </div>
                            <div class="row">
                                <label for="i_proyecto" class="col-sm-2 col-md-2 col-form-label requerido">Proyecto </label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" id="i_proyecto" name="i_proyecto" class="form-control validate[required]" autocomplete="off"/>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label id="l_estatus" class="col-sm-12 col-md-12"></label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="row">
                                <label for="s_id_unidades" class="col-sm-3 col-md-3 col-form-label requerido">Unidad de Negocio </label>
                                <div class="col-sm-12 col-md-9">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]"  autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="s_id_sucursales" class="col-sm-3 col-md-3 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-12 col-md-9">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12" style="text-align: right;"><br>
                            <button type="button" class="btn btn-primary btn-sm form-control" id="b_guardar_proyecto"><i class="fa fa-floppy-o" aria-hidden="true"></i> Comenzar Cotización</button>
                        </div>
                    </div>
                </form> <!--datos proyecto fin-->

                <form class="form_datos_cotizacion" name="form_datos_cotizacion"> <!--datos cotizacion inicio-->
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-5">
                            <div class="form-group row">
                                <label for="i_nombre_cotizacion" class="col-sm-12 col-md-12 col-form-label requerido">Versión</label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="text" name="i_nombre_cotizacion" id="i_nombre_cotizacion" class="form-control validate[required]" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <div class="form-group row">
                                <label for="i_firmante" class="col-sm-12 col-md-12 col-form-label requerido">Firmante </label>
                                <div class="input-group col-sm-12 col-md-11">
                                    <input type="text" id="i_firmante" name="i_firmante" class="form-control validate[required]" readonly autocomplete="off" aria-describedby="b_buscar_firmantes">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary coti" type="button" id="b_buscar_firmantes" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-auto">
                        <br><br>
                            <div class="form-check">
                                <input type="checkbox" name="ch_firma_digital" id="ch_firma_digital" class="coti">
                                <label class="form-check-label" for="ch_firma_digital">Firma Digital </label>
                            </div>
                        </div>
                        
                    </div>
                   
                    <div class="form-group">
                        <label for="ta_texto_inicio">Texto Inicio</label>
                        <textarea class="form-control validate[required] coti" name="ta_texto_inicio" id="ta_texto_inicio" rows="10" autocomplete="off"></textarea>
                    </div>
                </form> <!--datos cotizacion fin-->

                <div class="row"> <!--boton expandir/comprimir-->
                    <div class="col-sm-8 col-md-10"></div>
                    <div class="col-sm-4 col-md-2">
                    <button id="b_expandir" type="button" class="btn btn-primary btn-sm form-control">Expandir <i class="fa fa-expand" aria-hidden="true"></i></button>
                    <button id="b_comprimir" type="button" class="btn btn-primary btn-sm form-control" style="display: none;">Comprimir <i class="fa fa-compress" aria-hidden="true"></i></button>
                    </div>
                </div> <!--boton expandir/comprimir-->

                <div id="accordion" role="tablist"> <!--accordion inicio-->
                    <div class="card"> <!--div_card_clientes inicio-->
                        <div class="card-header" role="tab" id="heading_clientes">
                            <h5 class="mb-0">
                            <a data-toggle="collapse" href="#collapse_clientes" aria-expanded="true" aria-controls="collapse_clientes">
                                Clientes
                            </a>
                            </h5>
                        </div>
                        <div id="collapse_clientes" class="collapse" role="tabpanel" aria-labelledby="heading_clientes" data-parent="#accordion">
                            <div class="card-body">
                            <!-- aqui van -->
                                <form class="form_datos_cotizacion" name="form_datos_cotizacion">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <label for="i_nombre_comercial">Nombre Comercial</label>
                                            <input type="text" name="i_nombre_comercial" id="i_nombre_comercial" class="form-control validate[required] coti" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <datalist id="lista_clientes">
                                            </datalist>
                                            <label for="i_nombre_cliente">Nombre Corto</label>
                                            <input type="text" list="lista_clientes" name="lista_clientes" id="i_nombre_cliente" class="form-control validate[required] coti" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="i_dirigido">Dirigida a</label>
                                            <input type="text" name="i_dirigido" id="i_dirigido" class="form-control validate[required] coti" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <label for="i_razon_social_cliente">Razón Social</label>
                                            <input type="text" name="i_razon_social_cliente" id="i_razon_social_cliente" class="form-control coti" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="i_telefono">Teléfono</label>
                                            <input type="text" name="i_telefono" id="i_telefono" class="form-control validate[required] coti" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="i_email">Email</label>
                                            <input type="text" name="i_email" id="i_email" class="form-control validate[required,custom[email]] coti" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="i_calle">Calle</label>
                                            <input type="text" name="i_calle" id="i_calle" class="form-control coti" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_num_ext">No. Exterior</label>
                                            <input type="text" name="i_num_ext" id="i_num_ext" class="form-control coti" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_num_int">No. Interior</label>
                                            <input type="text" name="i_num_int" id="i_num_int" class="form-control coti" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8">
                                            <label for="i_colonia">Colonia</label>
                                            <input type="text" name="i_colonia" id="i_colonia" class="form-control coti" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_codigo_postal">Código Postal</label>
                                            <input type="text" name="i_codigo_postal" id="i_codigo_postal" class="form-control validate[required,custom[integer],minSize[5],maxSize[5]] coti" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="s_paises">País</label>
                                            <select class="form-control coti" id="s_paises" style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="s_estados">Estado</label>
                                            <select class="form-control coti" id="s_estados" style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="s_municipios">Municipio</label>
                                            <select class="form-control coti" id="s_municipios" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="i_rfc">RFC</label>
                                            <input type="text" name="i_rfc" id="i_rfc" class="form-control validate[minSize[12],maxSize[13],custom[onlyLetterNumber]] coti" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="i_rep_legal">Representante Legal</label>
                                            <input type="text" name="i_rep_legal" id="i_rep_legal" class="form-control coti" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <label for="i_contacto">Contacto</label>
                                            <input type="text" name="i_contacto" id="i_contacto" class="form-control coti" autocomplete="off">
                                        </div>
                                    </div>
                                    <br>
                                    <!--<div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <button type="button" data-toggle="tooltip" data-placement="top" title="Guardar Empresa" class="btn btn-primary btn-sm form-control" id="b_guardar_empresa" disabled><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Cliente</button>
                                        </div>
                                    </div>-->
                                </form>
                            </div>
                        </div>
                    </div> <!--div_card_clientes fin-->

                    <div class="card" id="div_card_elementos"> <!--div_card_elementos inicio-->
                        <div class="card-header" role="tab" id="heading_elementos">
                            <h5 class="mb-0">
                            <a data-toggle="collapse" href="#collapse_elementos" aria-expanded="true" aria-controls="collapse_elementos">
                                Elementos
                            </a>
                            <span><label id="c_costo_total_elemento"></label> <label id="c_precio_total_elemento"></label></span>
                            </h5>
                        </div>

                        <div id="collapse_elementos" class="collapse" role="tabpanel" aria-labelledby="heading_elementos" data-parent="#accordion">
                            <div class="card-body">
                                <form id="form_elemento" name="form_elemento">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10"></div>
                                        <div class="col-sm-12 col-md-2" id="div_b_elemento_a" style="text-align: right;">
                                            <button type="button" id="b_agrega_elemento" class="btn btn-info btn-sm" disabled>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_razon_social_salario" class="col-md-2 col-form-label requerido">Razón Social</label>
                                        <div class="input-group col-sm-12 col-md-5">
                                            <input type="text" id="i_razon_social_salario" name="i_razon_social_salario" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_razon_social_salario" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <label for="s_salario_diario" class="col-md-2 col-form-label requerido">Salario Diario</label>
                                        <div class="col-sm-8 col-md-3" id="div_salario_diario">
                                            <select class="form-control validate[required]" id="s_salario_diario" disabled style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="col-sm-8 col-md-3" id="div_salario_captura" style="display:none;">
                                            <input type="text" name="i_salario_diario" id="i_salario_diario" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8 col-md-6">
                                            <label>Puesto</label>
                                            <select class="form-control validate[required]" id="s_puestos" disabled style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="col-sm-4 col-md-2">
                                            <label>Cantidad</label>
                                            <input type="text" id="i_cantidad_elemento" name="i_cantidad_elemento" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_costo_total_elemento">Costo Total</label>
                                            <input type="text" name="i_costo_total_elemento" id="i_costo_total_elemento" class="form-control" disabled autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_precio_total_elemento">Precio Total</label>
                                            <input type="text" name="i_precio_total_elemento" id="i_precio_total_elemento" class="form-control" disabled autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_sueldo_elemento">Sueldo (mensual)</label>
                                            <input type="text" name="i_sueldo_elemento" id="i_sueldo_elemento" class="form-control validate[required]" autocomplete="off" readonly>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_bono_elemento">Bono</label>
                                            <input type="text" name="i_bono_elemento" id="i_bono_elemento" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_tiempo_elemento">Vacante Fija</label>
                                            <input type="text" name="i_tiempo_elemento" id="i_tiempo_elemento" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_otros_elemento">Otros</label>
                                            <input type="text" name="i_otros_elemento" id="i_otros_elemento" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_costo_elemento">Costo Unitario</label>
                                            <input type="text" name="i_costo_elemento" id="i_costo_elemento" class="form-control" readonly autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_precio_elemento">Precio</label>
                                            <input type="text" name="i_precio_elemento" id="i_precio_elemento" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_vacaciones">Vacaciones</label>
                                            <input type="text" name="i_vacaciones" id="i_vacaciones" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_aguinaldo">Aguinaldo</label>
                                            <input type="text" name="i_aguinaldo" id="i_aguinaldo" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_festivo">Festivo</label>
                                            <input type="text" name="i_festivo" id="i_festivo" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_costo_administrativo">Costo Admin</label>
                                            <input type="text" name="i_costo_administrativo" id="i_costo_administrativo" class="form-control" readonly autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_infonavit">Infonavit</label>
                                            <input type="text" name="i_infonavit" id="i_infonavit" class="form-control" autocomplete="off" readonly>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_imss">IMSS</label>
                                            <input type="text" name="i_imss" id="i_imss" class="form-control" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <label for="i_dia_31" class="col-sm-12 col-md-1">Día 31</label>
                                        <div class="col-sm-12 col-md-2">
                                            <input type="text" name="i_dia_31" id="i_dia_31" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="row">
                                                <label for="i_porcentaje_dispersion_captura" class="col-sm-12 col-md-auto col-form-label">% Dispersión</label>
                                                <div class="col-sm-12 col-md-6">
                                                    <input type="text" name="i_porcentaje_dispersion_captura" id="i_porcentaje_dispersion_captura" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-5">
                                            <div class="row">
                                                <label for="i_porcentaje_dispersion" class="col-sm-12 col-md-auto col-form-label">Porcentaje Dispersión $ </label>
                                                <div class="col-sm-12 col-md-5">
                                                    <input type="text" name="i_porcentaje_dispersion" id="i_porcentaje_dispersion" class="form-control" disabled autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                    <hr>
                                    <form name="forma_uniformes" id="forma_uniformes">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-2">
                                                <label for="i_cantidad_uniforme">Cantidad</label>
                                                <input type="text" name="i_cantidad_uniforme" id="i_cantidad_uniforme" class="form-control validate[required,custom[number]]" autocomplete="off">
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <label for="i_uniforme">Uniforme </label>
                                                <div class="form-group row">
                                                    <div class="input-group col-sm-12 col-md-12">
                                                        <input type="text" id="i_uniforme" name="i_uniforme" class="form-control validate[required]" readonly autocomplete="off" aria-describedby="b_buscar_firmantes">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-primary" type="button" id="b_buscar_uniforme" style="margin:0px;" autocomplete="off">
                                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-3">
                                                        <label for="i_costo_unitario_uniforme">Costo Unitario</label>
                                                        <input type="text" name="i_costo_unitario_uniforme" id="i_costo_unitario_uniforme" class="form-control validate[required]" readonly autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-12 col-md-4">
                                                        <label for="i_costo_total_uniforme">Costo Total</label>
                                                        <input type="text" name="i_costo_total_uniforme" id="i_costo_total_uniforme" class="form-control validate[required]" readonly autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-12 col-md-4">
                                                        <label for="i_costo_mensual_uniforme">Costo Mensual</label>
                                                        <input type="text" name="i_costo_mensual_uniforme" id="i_costo_mensual_uniforme" class="form-control validate[required]" readonly autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-12 col-md-1">
                                                        <button type="button" id="b_agrega_uniforme" class="btn btn-dark btn-sm">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--<div class="col-sm-12 col-md-2">
                                            <label for="i_costo_uniforme">Costo Unitario</label>
                                            <input type="text" name="i_costo_uniforme" id="i_costo_uniforme" class="form-control" readonly autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_costo_uniforme">Costo Total</label>
                                            <input type="text" name="i_costo_uniforme" id="i_costo_uniforme" class="form-control" readonly autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_costo_uniforme">Costo Unitario Mensual</label>
                                            <input type="text" name="i_costo_uniforme" id="i_costo_uniforme" class="form-control" readonly autocomplete="off">
                                        </div>-->
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12" id="div_lista_uniformes">
                                            <table class="tablon"  id="t_lista_uniformes">
                                                <thead>
                                                    <tr class="renglon">
                                                        <th scope="col">Cantidad</th>
                                                        <th scope="col">Nombre</th>
                                                        <th scope="col">Descripción</th>
                                                        <th scope="col">Costo Unitario</th>
                                                        <th scope="col">Costo Total</th>
                                                        <th scope="col">Costo Mensual</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_costo_uniforme" class="col-sm-12 col-md-auto col-form-label">Costo Total Uniformes</label>
                                        <div class="col-sm-12 col-md-2">
                                            <input type="text" class="form-control" id="i_costo_uniforme" name="i_costo_uniforme" disabled autocomplete="off">
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <div class="form-group row">
                                        <label for="i_prorrateado" class="col-sm-12 col-md-2 col-form-label">Costo Prorrateado</label>
                                        <div class="col-sm-12 col-md-3">
                                            <input type="text" class="form-control" id="i_prorrateado" name="i_prorrateado" disabled autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_observaciones_elemento" class="col-sm-12 col-md-5 col-form-label">Observaciones Internas</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" name="i_observaciones_elemento" id="i_observaciones_elemento" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2" id="div_b_elemento_b">
                                            <button type="button" id="b_agrega_elemento2" class="btn btn-info btn-sm" disabled>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                <br>
                                <div class="row form-group" id="div_lista_elemento" style="overflow:auto;">
                                    <!--<div class="col-sm-12 col-md-12" id="div_lista_elemento" style="overflow:auto;">
                                    </div>-->
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12" >
                                        <label style="background-color: rgba(238,238,238,0.8); width: 100%; padding: 10px;">Total elementos <span class="badge badge-primary badge-pill" id="dato_total_elementos"></span></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_generales_elemento" class="col-form-label">Observaciones generales (se muestra en formato) <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_generales_elemento" id="ta_observaciones_generales_elemento" rows="2" autocomplete="off"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-2" style="text-align: right;">
                                        <button type="button" id="b_guardar_observaciones_elemento" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_internas_elemento" class="col-form-label">Observaciones internas <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_internas_elemento" id="ta_observaciones_internas_elemento" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--div_card_elementos fin-->

                    <div class="card" id="div_card_equipo"> <!--div_card_equipo inicio-->
                        <div class="card-header" role="tab" id="heading_equipo">
                            <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse_equipo" aria-expanded="false" aria-controls="collapse_equipo">
                                Equipo
                            </a>
                            <span><label id="c_costo_total_equipo"></label> <label id="c_precio_total_equipo"></label></span>
                            </h5>
                        </div>
                        <div id="collapse_equipo" class="collapse" role="tabpanel" aria-labelledby="heading_equipo" data-parent="#accordion">
                            <div class="card-body">
                                <form id="form_equipo" name="form_equipo">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-5">
                                            <label for="i_equipo">Equipo</label>
                                            <input type="text" name="i_equipo" id="i_equipo" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_cantidad_equipo">Cantidad</label>
                                            <input type="text" name="i_cantidad_equipo" id="i_cantidad_equipo" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                        </div>
                                        <div class="col-sm-12 col-md-1" id="div_b_equipo_a">
                                            <button type="button" id="b_agrega_equipo" class="btn btn-info btn-sm" disabled>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-2">
                                            <label>Tipo Pago</label>
                                            <div class="form-check">
                                                <input type="radio" name="radio_equipo" id="radio_equipo1" value="1" checked>
                                                <label class="form-check-label" for="radio_equipo1">
                                                    Mensual
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="radio_equipo" id="radio_equipo2" value="2">
                                                <label class="form-check-label" for="radio_equipo2">
                                                Único
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-10">
                                            <div class="form-group row">
                                                <label for="i_costo_equipo" class="col-sm-12 col-md-2 col-form-label">Costo Unitario</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_costo_equipo" id="i_costo_equipo" class="form-control validate[required]" autocomplete="off">
                                                </div>
                                                <label for="i_costo_total_equipo" class="col-sm-12 col-md-2 col-form-label">Costo Total</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_costo_total_equipo" id="i_costo_total_equipo" class="form-control validate[required]" disabled autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="i_precio_equipo" class="col-sm-12 col-md-2 col-form-label">Precio Unitario</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_precio_equipo" id="i_precio_equipo" class="form-control validate[required]" autocomplete="off">
                                                </div>
                                                <label for="i_precio_total_equipo" class="col-sm-12 col-md-2 col-form-label">Precio Total</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_precio_total_equipo" id="i_precio_total_equipo" class="form-control validate[required]" disabled autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="form-check">
                                                <input type="checkbox" name="ch_prorratear_equipo" id="ch_prorratear_equipo">
                                                <label class="form-check-label" for="ch_prorratear_equipo">Prorratear </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <span id="equipo_d"></span>
                                        </div>
                                    </div>
                                    <br>-->
                                    <div class="row">
                                        <label for="i_observaciones_equipo" class="col-sm-12 col-md-5 col-form-label">Observaciones</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" name="i_observaciones_equipo" id="i_observaciones_equipo" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-sm-12 col-md-2" id="div_b_equipo_b">
                                        <button type="button" id="b_agrega_equipo2" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12" id="div_lista_equipo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="background-color: rgba(238,238,238,0.8); width: 100%; padding: 10px;">Total equipos  <span class="badge badge-primary badge-pill" id="dato_total_equipo"></span></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_generales_equipo" class="col-form-label">Observaciones generales (se muestra en formato) <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_generales_equipo" id="ta_observaciones_generales_equipo" rows="2" autocomplete="off"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-2" style="text-align: right;">
                                        <button type="button" id="b_guardar_observaciones_equipo" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_internas_equipo" class="col-form-label">Observaciones internas <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_internas_equipo" id="ta_observaciones_internas_equipo" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--div_card_equipo fin-->

                    <div class="card" id="div_card_servicios"> <!--div_card_servicios inicio-->
                        <div class="card-header" role="tab" id="heading_servicios">
                            <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse_servicios" aria-expanded="false" aria-controls="collapse_servicios">
                                Servicios
                            </a>
                            <span><label id="c_costo_total_servicio"></label> <label id="c_precio_total_servicio"></label></span>
                            </h5>
                        </div>
                        <div id="collapse_servicios" class="collapse" role="tabpanel" aria-labelledby="heading_servicios" data-parent="#accordion">
                            <div class="card-body">
                                <form id="form_servicio" name="form_servicio">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-5">
                                            <label for="i_servicio">Servicio</label>
                                            <input type="text" name="i_servicio" id="i_servicio" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_cantidad_servicio">Cantidad</label>
                                            <input type="text" name="i_cantidad_servicio" id="i_cantidad_servicio" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                        </div>
                                        <div class="col-sm-12 col-md-1" id="div_b_servicio_a">
                                            <button type="button" id="b_agrega_servicio" class="btn btn-info btn-sm" disabled>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-2">
                                            <label>Tipo Pago</label>
                                            <div class="form-check">
                                                <input type="radio" name="radio_servicio" id="radio_servicio1" value="1" checked>
                                                <label class="form-check-label" for="radio_servicio1">
                                                    Mensual
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="radio_servicio" id="radio_servicio2" value="2">
                                                <label class="form-check-label" for="radio_servicio2">
                                                    Único
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-10">
                                            <div class="form-group row">
                                                <label for="i_costo_servicio" class="col-sm-12 col-md-2 col-form-label">Costo Unitario</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_costo_servicio" id="i_costo_servicio" class="form-control validate[required]" autocomplete="off">
                                                </div>
                                                <label for="i_costo_total_servicio" class="col-sm-12 col-md-2 col-form-label">Costo Total</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_costo_total_servicio" id="i_costo_total_servicio" class="form-control validate[required]" disabled autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="i_precio_servicio" class="col-sm-12 col-md-2 col-form-label">Precio Unitario</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_precio_servicio" id="i_precio_servicio" class="form-control validate[required]" autocomplete="off">
                                                </div>
                                                <label for="i_precio_total_servicio" class="col-sm-12 col-md-2 col-form-label">Precio Total</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_precio_total_servicio" id="i_precio_total_servicio" class="form-control validate[required]" disabled autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <span id="servicio_d"></span>
                                        </div>
                                    </div>
                                    <br>-->
                                    <div class="row">
                                        <label for="i_observaciones_servicio" class="col-sm-12 col-md-5 col-form-label">Observaciones</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" name="i_observaciones_servicio" id="i_observaciones_servicio" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-sm-12 col-md-2" id="div_b_servicio_b">
                                        <button type="button" id="b_agrega_servicio2" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12" id="div_lista_servicio">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="background-color: rgba(238,238,238,0.8); width: 100%; padding: 10px;">Total servicios  <span class="badge badge-primary badge-pill" id="dato_total_servicio"></span></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_generales_servicio" class="col-form-label">Observaciones generales (se muestra en formato) <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_generales_servicio" id="ta_observaciones_generales_servicio" rows="2" autocomplete="off"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-2" style="text-align: right;">
                                        <button type="button" id="b_guardar_observaciones_servicio" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_internas_servicio" class="col-form-label">Observaciones internas <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_internas_servicio" id="ta_observaciones_internas_servicio" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--div_card_servicios fin-->

                    <div class="card" id="div_card_vehiculos"> <!--div_card_vehiculos inicio-->
                        <div class="card-header" role="tab" id="heading_vehiculos">
                            <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse_vehiculos" aria-expanded="false" aria-controls="collapse_vehiculos">
                                Vehiculos
                            </a>
                            <span><label id="c_costo_total_vehiculo"></label> <label id="c_precio_total_vehiculo"></label></span>
                            </h5>
                        </div>
                        <div id="collapse_vehiculos" class="collapse" role="tabpanel" aria-labelledby="heading_vehiculos" data-parent="#accordion">
                            <div class="card-body">
                                <form id="form_vehiculo" name="form_vehiculo">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-5">
                                            <label for="i_vehiculo">Vehiculo</label>
                                            <input type="text" name="i_vehiculo" id="i_vehiculo" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_cantidad_vehiculo">Cantidad</label>
                                            <input type="text" name="i_cantidad_vehiculo" id="i_cantidad_vehiculo" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                        </div>
                                        <div class="col-sm-12 col-md-1" id="div_b_vehiculo_a">
                                            <button type="button" id="b_agrega_vehiculo" class="btn btn-info btn-sm" disabled>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-2">
                                            <label>Tipo Pago</label>
                                            <div class="form-check">
                                                <input type="radio" name="radio_vehiculo" id="radio_vehiculo1" value="1" checked>
                                                <label class="form-check-label" for="radio_vehiculo1">
                                                    Mensual
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="radio_vehiculo" id="radio_vehiculo2" value="2">
                                                <label class="form-check-label" for="radio_vehiculo2">
                                                Único
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-10">
                                            <div class="form-group row">
                                                <label for="i_costo_vehiculo" class="col-sm-12 col-md-2 col-form-label">Costo Unitario</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_costo_vehiculo" id="i_costo_vehiculo" class="form-control validate[required]" autocomplete="off">
                                                </div>
                                                <label for="i_costo_total_vehiculo" class="col-sm-12 col-md-2 col-form-label">Costo Total</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_costo_total_vehiculo" id="i_costo_total_vehiculo" class="form-control validate[required]" disabled autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="i_precio_vehiculo" class="col-sm-12 col-md-2 col-form-label">Precio Unitario</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_precio_vehiculo" id="i_precio_vehiculo" class="form-control validate[required]" autocomplete="off">
                                                </div>
                                                <label for="i_precio_total_vehiculo" class="col-sm-12 col-md-2 col-form-label">Precio Total</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_precio_total_vehiculo" id="i_precio_total_vehiculo" class="form-control validate[required]" disabled autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <span id="vehiculo_d"></span>
                                        </div>
                                    </div>
                                    <br>-->
                                    <div class="row">
                                        <label for="i_observaciones_vehiculo" class="col-sm-12 col-md-5 col-form-label">Observaciones</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" name="i_observaciones_vehiculo" id="i_observaciones_vehiculo" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-sm-12 col-md-2" id="div_b_vehiculo_b">
                                        <button type="button" id="b_agrega_vehiculo2" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12" id="div_lista_vehiculo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="background-color: rgba(238,238,238,0.8); width: 100%; padding: 10px;">Total vehiculos  <span class="badge badge-primary badge-pill" id="dato_total_vehiculo"></span></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_generales_vehiculo" class="col-form-label">Observaciones generales (se muestra en formato) <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_generales_vehiculo" id="ta_observaciones_generales_vehiculo" rows="2" autocomplete="off"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-2" style="text-align: right;">
                                        <button type="button" id="b_guardar_observaciones_vehiculo" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_internas_vehiculo" class="col-form-label">Observaciones internas <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_internas_vehiculo" id="ta_observaciones_internas_vehiculo" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--div_card_vehiculos inicio-->
                    
                    <div class="card" id="div_card_consumibles"> <!--div_card_consumibles inicio-->
                        <div class="card-header" role="tab" id="heading_consumibles">
                            <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse_consumibles" aria-expanded="false" aria-controls="collapse_consumibles">
                                Consumibles
                            </a>
                            <span><label id="c_costo_total_consumibles"></label> <label id="c_precio_total_consumibles"></label></span>
                            </h5>
                        </div>
                        <div id="collapse_consumibles" class="collapse" role="tabpanel" aria-labelledby="heading_consumibles" data-parent="#accordion">
                            <div class="card-body">
                                <form id="form_consumibles" name="form_consumibles">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-5">
                                            <label for="i_consumibles">Consumibles</label>
                                            <input type="text" name="i_consumibles" id="i_consumibles" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <label for="i_cantidad_consumibles">Cantidad</label>
                                            <input type="text" name="i_cantidad_consumibles" id="i_cantidad_consumibles" class="form-control validate[required]" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                        </div>
                                        <div class="col-sm-12 col-md-1" id="div_b_consumibles_a">
                                            <button type="button" id="b_agrega_consumibles" class="btn btn-info btn-sm" disabled>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-2">
                                            <label>Tipo Pago</label>
                                            <div class="form-check">
                                                <input type="radio" name="radio_consumibles" id="radio_consumibles1" value="1" checked>
                                                <label class="form-check-label" for="radio_consumibles1">
                                                    Mensual
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="radio_consumibles" id="radio_consumibles2" value="2">
                                                <label class="form-check-label" for="radio_consumibles2">
                                                Único
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-10">
                                            <div class="form-group row">
                                                <label for="i_costo_consumibles" class="col-sm-12 col-md-2 col-form-label">Costo Unitario</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_costo_consumibles" id="i_costo_consumibles" class="form-control validate[required]" autocomplete="off">
                                                </div>
                                                <label for="i_costo_total_consumibles" class="col-sm-12 col-md-2 col-form-label">Costo Total</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_costo_total_consumibles" id="i_costo_total_consumibles" class="form-control validate[required]" disabled autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="i_precio_consumibles" class="col-sm-12 col-md-2 col-form-label">Precio Unitario</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_precio_consumibles" id="i_precio_consumibles" class="form-control validate[required]" autocomplete="off">
                                                </div>
                                                <label for="i_precio_total_consumibles" class="col-sm-12 col-md-2 col-form-label">Precio Total</label>
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="text" name="i_precio_total_consumibles" id="i_precio_total_consumibles" class="form-control validate[required]" disabled autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="form-check">
                                                <input type="checkbox" name="ch_prorratear_consumibles" id="ch_prorratear_consumibles">
                                                <label class="form-check-label" for="ch_prorratear_consumibles">Prorratear </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <span id="consumibles_d"></span>
                                        </div>
                                    </div>
                                    <br>-->
                                    <div class="row">
                                        <label for="i_observaciones_consumibles" class="col-sm-12 col-md-5 col-form-label">Observaciones</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" name="i_observaciones_consumibles" id="i_observaciones_consumibles" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-sm-12 col-md-2" id="div_b_equipo_b">
                                        <button type="button" id="b_agrega_consumibles2" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12" id="div_lista_consumibles">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="background-color: rgba(238,238,238,0.8); width: 100%; padding: 10px;">Total consumibles  <span class="badge badge-primary badge-pill" id="dato_total_consumibles"></span></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_generales_consumibles" class="col-form-label">Observaciones generales (se muestra en formato) <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_generales_consumibles" id="ta_observaciones_generales_consumibles" rows="2" autocomplete="off"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-2" style="text-align: right;">
                                        <button type="button" id="b_guardar_observaciones_consumibles" class="btn btn-info btn-sm" disabled>
                                            <i class="fa fa-plus" aria-hidden="true"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-10">
                                        <label for="ta_observaciones_internas_consumibles" class="col-form-label">Observaciones internas <span class="span_seccion">*Por sección, se actualiza cada que se genera un registro</span></label>
                                        <textarea class="form-control" name="ta_observaciones_internas_consumibles" id="ta_observaciones_internas_consumibles" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--div_card_consumibles fin-->
                </div> <!--accordion fin-->

                <form class="form_datos_cotizacion" name="form_datos_cotizacion"> <!--datos cotizacion final inicio-->
                    <div class="form-group">
                        <label for="ta_texto_fin">Texto Fin</label>
                        <textarea class="form-control validate[required] coti" name="ta_texto_fin" id="ta_texto_fin" rows="8" autocomplete="off"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ta_observaciones_generales">Observaciones Generales (se muestran en formato)</label>
                        <textarea class="form-control coti" name="ta_observaciones_generales" id="ta_observaciones_generales" rows="3" autocomplete="off"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ta_observaciones_internas">Observaciones Internas</label>
                        <textarea class="form-control coti" name="ta_observaciones_internas" id="ta_observaciones_internas" rows="3" autocomplete="off"></textarea>
                    </div>
                </form> <!--datos cotizacion final fin-->

                <!--resumen inversion inicio-->
                <div class="row" id="div_comision_cotizacion">
                    <div class="col-sm-12 col-md-2">Costo Comisión</div>
                    <div class="col-sm-12 col-md-2">
                        <form id="form_comision" name="form_comision">
                            <input id="i_comision_cotizacion" name="i_comision_cotizacion" class="form-control validate[required,custom[number]]"/>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-1">
                        <button type="button" id="b_guardar_comision" class="btn btn-info">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span id="leyenda_comision">*El costo de la comisión no es visible para quien captura la cotización.</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <span id="span_resumen_inversion">Resumen Inversión</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Costo Mensual</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                $<span id="dato_costo_mensual" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Precio Mensual</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                $<span id="dato_precio_mensual" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Inversión Inicial Secorp</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                $<span id="dato_inversion" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Inversión Inicial Cliente</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                $<span id="dato_cargo_cliente" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Utilidad Primer Año</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                $<span id="dato_utilidad_anual" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Retorno Inversión</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                <span id="dato_retorno_inversion" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Utilidad Bruta Mensual</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                $<span id="dato_utilidad_bruta_mensual" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Utilidad Por Elemento</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                $<span id="dato_utilidad_elemento" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-5">Porcentaje de Utilidad Final</div>
                            <div class="col-6 col-sm-6 col-md-7">
                                <span id="dato_porcentaje_utilidad_final" class="datos_resumen"></span><span id="dato_signo" class="datos_resumen"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5" id="div_comision_resumen" style="display:none;">
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Costo Mensual</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                $<span id="dato_costo_mensual_c" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Precio Mensual</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                $<span id="dato_precio_mensual_c" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Inversión Inicial Secorp</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                $<span id="dato_inversion_c" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Inversión Inicial Cliente</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                $<span id="dato_cargo_cliente_c" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Utilidad Primer Año</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                $<span id="dato_utilidad_anual_c" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Retorno Inversión</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                <span id="dato_retorno_inversion_c" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Utilidad Bruta Mensual</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                $<span id="dato_utilidad_bruta_mensual_c" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Utilidad Por Elemento</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                $<span id="dato_utilidad_elemento_c" class="datos_resumen"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6">Porcentaje de Utilidad Final</div>
                            <div class="col-6 col-sm-6 col-md-6">
                                <span id="dato_porcentaje_utilidad_final_c" class="datos_resumen"></span><span id="dato_signo_c" class="datos_resumen"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <!--resumen inversion fin-->

            </div> <!--div_contenedor-->
        </div> <!--div_row--> 

        <div class="row">
            <div class="col-md-12">
                <br>
            </div>
        </div>

    </div> <!--div_principal-->
    
</body>

<div id="dialog_cotizaciones" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Cotizaciones</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <span id="span_indica">* Selecciona una sucursal para comenzar la búsqueda</span>
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="s_filtro_unidad">Unidad de Negocio </label>
                            <select id="s_filtro_unidad" name="s_filtro_unidad" class="form-control" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-6">
                            <label for="s_filtro_sucursal">Sucursal </label>
                            <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <label for="i_buscar_proyecto">Proyecto </label>
                            <div class="form-group row">
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_buscar_proyecto" name="i_buscar_proyecto" class="form-control" autocomplete="off" placeholder="Filtrar por Proyecto" disabled="disabled">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_filtro_proyecto" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label for="i_buscar_cliente">Cliente </label>
                            <div class="form-group row">
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_buscar_cliente" name="i_buscar_cliente" class="form-control" autocomplete="off" placeholder="Filtrar cliente" disabled="disabled">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_filtrar_cliente" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label for="i_buscar_usuario">Usuarios </label>
                            <div class="form-group row">
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_buscar_usuario" name="i_buscar_usuario" class="form-control" autocomplete="off" placeholder="Filtrar por Usuario" disabled="disabled">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_filtro_usuario" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-2">
                    <label for="s_filtro_estatus">Estatus </label>
                    <select class="form-control filtros" id="s_filtro_estatus">
                        <option value="" selected disabled>Filtrar por Estatus</option>
                        <option value="todos">Todos</option>
                        <option value="1">Proceso</option>
                        <option value="2">Negociación</option>
                        <option value="3">Rechazada</option>
                        <option value="4">Aprobada</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-3">
                    <br>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <input type="radio" name="radio_filtro" id="radio_activas" value="activas" checked> Activas
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <input type="radio" name="radio_filtro" id="radio_todas" value="todas"> Todas
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <input type="radio" name="radio_filtro" id="radio_ultimas" value="ultimas"> Última Versión
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">Del: </div>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control fecha" autocomplete="off" readonly>
                                    <div class="input-group-addon input_group_span">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">Al: </div>
                                <div class="input-group col-sm-12 col-md-12">
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
                </div>
                <div class="col-md-3">
                    <br>
                    <input type="text" name="i_filtro_cotizaciones" id="i_filtro_cotizaciones" alt="renglon_cotizaciones" class="form-control filtrar_renglones" placeholder="Filtrar">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cotizaciones">
                    <thead>
                        <tr class="renglon">
                        <th scope="col">Folio</th>
                        <th scope="col">Cotización</th>
                        <th scope="col">Versión</th>
                        <th scope="col">Fecha Creación</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Sucursal</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Estatus Cotización</th>
                        <th scope="col">Estatus Proyecto</th>
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

<div id="dialog_aprobacion" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Cerrar Cotización</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <form id="form_aprobacion" name="form_aprobacion">
                    
                    <div class="row divs_aprobar">
                        <div class="col-sm-12 col-md-4">
                            <label for="i_inicio_facturacion" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Inicio de Facturación</label>
                            <div class="col-sm-12 col-md-11">
                                <input type="text" id="i_inicio_facturacion" name="i_inicio_facturacion" class="form-control datos_aprovar validate[required]" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label for="s_periodicidad" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Periodicidad</label>
                            <div class="col-sm-12 col-md-10">
                                <select class="form-control datos_aprovar validate[required]" id="s_periodicidad" name="s_periodicidad">
                                    <option value="0" disabled selected>Selecciona</option>    
                                    <option value="1">Semanal</option>
                                    <option value="2">Quincenal</option>
                                    <option value="3">Mensual</option>
                                    <option value="4">Unico</option>
                                </select>
                            </div>    
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label for="i_dia" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Día</label>
                            <div class="col-sm-6 col-md-6" id="contenedor_dia">
                                <input type="text" id="i_dia" name="i_dia"  class="form-control datos_aprovar" autocomplete="off"  readonly>
                            </div>   
                        </div>
                    </div>
                    <div class="row divs_aprobar">
                        <div class="col-sm-12 col-md-4">
                            <label for="s_tipo_facturacion" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Tipo de Facturación</label>
                            <div class="col-sm-12 col-md-10">
                                <select class="form-control datos_aprovar validate[required] " id="s_tipo_facturacion" name="s_tipo_facturacion">
                                    <option value="0" disabled selected>Selecciona</option>    
                                    <option value="1">Mes corriente</option>
                                    <option value="2">Mes Vencido</option>
                                    <option value="3">Mes anticipado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <label for="i_razon_social_emisora" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Razón Social Emisora de la Factura </label>
                            <div class="input-group col-sm-12 col-md-12">
                                <input type="text" id="i_razon_social_emisora" name="i_razon_social_emisora" class="form-control datos_aprovar validate[required]" readonly autocomplete="off" aria-describedby="b_buscar_razon_social_emisora">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="b_buscar_razon_social_emisora" style="margin:0px;">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-4 divs_aprobar">
                            <label for="i_fecha_inicio_ap label_aprovar requerido">Fecha Inicio Servicio</label>
                            <input type="text" name="" id="i_fecha_inicio_ap" class="form-control datos_aprovar validate[required]" autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-12 col-md-3 alert alert-primary">
                            <input type="radio" name="radio_aprobada" id="radio_aprobada" value="4" checked>
                            <label for="radio_aprobada">Aprobada</label>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-sm-12 col-md-3 alert alert-danger">
                            <input type="radio" name="radio_aprobada" id="radio_rechazada" value="3">
                            <label for="radio_rechazada">Rechazada</label>
                        </div>
                    </div>
                    <div class="row divs_aprobar">
                        <div class="col-md-12 label_aprovar requerido">
                            <label for="ta_observaciones">Observaciones</label>
                            <textarea class="form-control datos_aprovar validate[required]" id="ta_observaciones" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row divs_aprobar">
                        <div class="col-md-12">
                            <label for="ta_correos" class="label_aprovar requerido">Enviar a </label>
                            <textarea class="form-control validate[required,custom[multiEmail]]" id="ta_correos" rows="3"></textarea>
                            <span style="font-size:11px; color:#006600;">*Separar cuentas por comas</span>
                        </div>
                    </div>
                    <div class="row" id="div_justificacion_rechazada" style="display:none;">
                        <div class="col-md-12">
                            <label for="ta_justificacion_rechazada" class="requerido">Justificación </label>
                            <textarea class="form-control validate[required]" id="ta_justificacion_rechazada" rows="3"></textarea>
                        </div>
                    </div>
                </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="b_guardar_aprobacion" class="btn btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Aprobación</button>
        </div>
        </div>
    </div>
</div>


<div id="dialog_version" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Nueva Versión Cotización</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <form id="form_version" name="form_version">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <label for="ta_porque">¿Por qué la nueva versión?</label>
                            <textarea class="form-control validate[required]" id="ta_porque" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="ta_justificacion">Justificación</label>
                            <textarea class="form-control validate[required]" id="ta_justificacion" rows="3"></textarea>
                        </div>
                    </div>
                </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="b_guardar_version" class="btn btn-info" data-dismiss="modal"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Versión</button>
        </div>
        </div>
    </div>
</div>

<div id="dialog_buscar_usuarios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_usuario" id="i_filtro_usuario" class="form-control filtrar_renglones" alt="renglon_usuarios" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_usuarios">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Usuario</th>
                          <th scope="col">Nombre</th>
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

<div id="dialog_buscar_proyectos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Proyectos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_proyecto" id="i_filtro_proyecto" class="form-control filtrar_renglones" alt="renglon_proyecto" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_proyectos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Proyecto</th>
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

<div id="dialog_buscar_clientes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Clientes de Proyecto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_clientes" id="i_filtro_clientes" class="form-control filtrar_renglones" alt="renglon_cliente" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_clientes">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Nombre</th>
                          <th scope="col">Nombre Comercial</th>
                          <th scope="col">Razón Social</th>
                          <th scope="col">Municipio</th>
                          <th scope="col">Estado</th>
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



<div id="dialog_buscar_firmantes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Firmantes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_firmantes" id="i_filtro_firmantes" class="form-control filtrar_renglones" alt="renglon_firmantes_asigna" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_firmantes">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Nombre</th>
                            <th scope="col">Iniciales</th>
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

<div id="dialog_buscar_razon_social_emisora" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Razón Social Emisora Factura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_razon_social_emisora" id="i_filtro_razon_social_emisora" class="form-control filtrar_renglones" alt="renglon_razon_social_emisora" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_razon_social_emisora">
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

<div id="dialog_buscar_razon_social_salario" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Razónes Sociales</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_razon_social_salario" id="i_filtro_razon_social_salario" class="form-control filtrar_renglones" alt="renglon_razon_social_salario" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_razon_social_salario">
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

<div id="dialog_buscar_uniformes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Uniformes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_uniformes" id="i_filtro_uniformes" class="form-control filtrar_renglones" alt="renglon_uniforme" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_uniformes">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Clave</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descrpción</th>
                            <th scope="col">Costo</th>
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

<div id="dialog_version" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Versión Cotización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form_version" name="form_version">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <label for="ta_porque">¿Por qué la nueva versión?</label>
                        <textarea class="form-control validate[required]" id="ta_porque" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="ta_justificacion">Justificación</label>
                        <textarea class="form-control validate[required]" id="ta_justificacion" rows="3"></textarea>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="b_guardar_version" class="btn btn-info" data-dismiss="modal"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Versión</button>
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
 
    var idCotizacion=0;
    var folioCotizacion=0;
    var tipo_mov=0;
    var modulo='CREAR_COTIZACIONES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';

    var cotizacionOriginal='';
    var proyectoOriginal='';
    var idProyecto=0;
    var idCliente=0;
    var actualizaCotizacion=0;
    var estatusProyecto=0;
    var idSucursal=0;
    var idUnidadNegocio=0;

    var elementosP = 0;
    var equipoP = 0;
    var serviciosP = 0;
    var vehiculosP = 0;
    var consumiblesP = 0;

    //var porcentajeDispersion = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var estatus = 0;
    var estatusProyecto = 0;
    var estatusCotizacion = 0; 

    var porcentajeUtilidadIdUnidad = 0;

    $(function(){

        mostrarBotonAyuda(modulo);
        
        $('#div_comision_cotizacion div').css('display','none'); 

        $('[data-toggle="tooltip"]').tooltip();

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSelectUnidades(matriz,'s_filtro_unidad',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
        
        muestraSeccionesPlantilla(idUnidadActual);
        //muestraSelectSalariosPuestos('s_puestos',idUnidadActual);
        
        //-->NJES February/05/2021 ya no se puede capturar el salario diario, solo se puede seleccionar del combo
        //-->NJES Sep/29/2020 verificar si tiene permiso para capturar salario sin importar puesto y razón social
        /*if(verificaPermisoElemento(idUsuario,'CAPTURAR_SALARIO',idUnidadActual) == 1)
        {
            $('#div_salario_diario').hide(); 
            $('#div_salario_captura').show();
        }else{*/ 
            $('#div_salario_captura').hide();  
            $('#div_salario_diario').show();  
        //}   

        //-->NJES February/05/2021 si tiene permiso poder editar el sueldo mensula en elementos
        if(verificaPermisoElemento(idUsuario,'EDITAR_SUELDO',idUnidadActual) == 1)
        {
            $('#i_sueldo_elemento').prop('readonly',false); 
        }else{ 
            $('#i_sueldo_elemento').prop('readonly',true);  
        }

        if(verificaPermisoElemento(idUsuario,'CAPTURA_COSTO_UNIFORME',idUnidadActual) == 1)
        {
            $('#i_costo_unitario_uniforme').prop('readonly',false); 
        }else{ 
            $('#i_costo_unitario_uniforme').prop('readonly',true);  
        }

        //-->NJES February/05/2021 ya no se puede capturar el salario diario, solo se puede seleccionar del combo
        /*$('#heading_elementos').click(function(){
            if(verificaPermisoElemento(idUsuario,'CAPTURAR_SALARIO',idUnidadActual) == 1)
            {
                $('#div_salario_diario').hide(); 
                $('#div_salario_captura').show();
            }else{ 
                $('#div_salario_captura').hide();  
                $('#div_salario_diario').show();  
            } 
        });*/
                
        $('#s_id_unidades').change(function(){
            muestraSucursalesPermiso('s_id_sucursales',$('#s_id_unidades').val(),modulo,idUsuario);
            muestraSeccionesPlantilla($('#s_id_unidades').val());
            $('#s_puestos').val('').prop('disabled',true);
            obtenerTextos();

            //-->NJES Sep/29/2020 verificar si tiene permiso para capturar salario sin importar puesto y razón social
            /*if(verificaPermisoElemento(idUsuario,'CAPTURAR_SALARIO',$('#s_id_unidades').val()) == 1)
            {
                $('#div_salario_diario').hide(); 
                $('#div_salario_captura').show();
            }else{ */
                $('#div_salario_captura').hide();  
                $('#div_salario_diario').show();  
            //}   

        });

        muestraSelectPaises('s_paises');
        muestraSelectEstados('s_estados');
        muestraSelectMunicipios('s_municipios',0);

        $('#s_estados').change(function(){
            muestraSelectMunicipios('s_municipios',$('#s_estados').val());
        });

        muestraClientes();
        obtenerTextos();

        $('.coti').prop('disabled',true); //-->Pone en disabled los input que son necesarios para crear la cotizacion. Loa habilita una vez creado el proyecto

        $('#i_inicio_facturacion,#i_fecha_inicio_ap,#i_fecha_inicio,#i_fecha_fin').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('.btn').click(function(){
            $('[data-toggle="tooltip"]').tooltip('hide');
        });


        $('#b_expandir').click(function(){     //-->expande todas las opciones del accordeon
            $('.collapse').addClass('show');
            $('#b_expandir').css('display','none');
            $('#b_comprimir').css('display','block');
        });

        $('#b_comprimir').click(function(){   //-->comprime todas las opciones del accordeon
            $('.collapse').removeClass('show');
            $('#b_comprimir').css('display','none');
            $('#b_expandir').css('display','block');
        });

        function obtienePorcentajeUtilidad(idUnidadNegocio,idSucursal){
            $.ajax({
                type: 'POST',
                url: 'php/porcentaje_utilidad_buscar_id_unidad.php',
                dataType:"json", 
                data:  {'idUnidadNegocio' : idUnidadNegocio,'idSucursal':idSucursal},
                success: function(data) {
                     
                    if(data.length>0)
                    {
                        porcentajeUtilidadIdUnidad = data[0].utilidad;
                    }

                },
                error: function (xhr) {
                    console.log('php/porcentaje_utilidad_buscar_id_unidad.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar el procentaje de utilidad.');
                }
            });
        }

        function muestraSeccionesPlantilla(idUnidadNegocio){
            $.ajax({
                type: 'POST',
                url: 'php/plantillas_cotizaciones_buscar_id_unidad.php',
                dataType:"json", 
                data:{'idUnidadNegocio':idUnidadNegocio},
                success: function(data) {
                    if(data.length != 0){

                        elementosP = data[0].elementos;
                        equipoP = data[0].equipo;
                        serviciosP = data[0].servicios;
                        vehiculosP = data[0].vehiculos;
                        consumiblesP = data[0].consumibles;
                        
                        if(data[0].elementos == 1)
                        {
                            $('#div_card_elementos').css('display','block');
                        }else{
                            $('#div_card_elementos').css('display','none');
                        }

                        if(data[0].equipo == 1)
                        {
                            $('#div_card_equipo').css('display','block');
                        }else{
                            $('#div_card_equipo').css('display','none');
                        }

                        if(data[0].servicios == 1)
                        {
                            $('#div_card_servicios').css('display','block');
                        }else{
                            $('#div_card_servicios').css('display','none');
                        }

                        if(data[0].vehiculos == 1)
                        {
                            $('#div_card_vehiculos').css('display','block');
                        }else{
                            $('#div_card_vehiculos').css('display','none');
                        }

                        if(data[0].consumibles == 1)
                        {
                            $('#div_card_consumibles').css('display','block');
                        }else{
                            $('#div_card_consumibles').css('display','none');
                        }

                    }else{
                        $('#div_card_elementos,#div_card_equipo,#div_card_servicios,#div_card_vehiculos,#div_card_consumibles').css('display','none');
                        mandarMensaje('No existe una plantilla de cotizacion para la unidad ó podría estar inactiva.');
                        elementosP = 0;
                        equipoP = 0;
                        serviciosP = 0;
                        vehiculosP = 0;
                        consumiblesP = 0;
                    }
                },
                error: function (xhr) {
                    console.log('php/plantillas_cotizaciones_buscar_id_unidad.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar las secciones.');
                }
            });
        }

        $('#s_id_sucursales').change(function(){
            $('#s_puestos').prop('disabled',false);
             
            muestraSelectSalariosPuestos('s_puestos',$('#s_id_unidades').val(),$('#s_id_sucursales').val(),idUsuario);
            
            muestraCorreos($('#s_id_unidades').val(),$('#s_id_sucursales').val());
        });

        function muestraCorreos(idUnidadNegocio,idSucursal){
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_correos.php',
                dataType:"json", 
                data:  {'idUnidadNegocio' : idUnidadNegocio,'idSucursal':idSucursal},
                success: function(data) {
                     
                    for(var i=0;data.length>i;i++){
                        $('#ta_correos').val(data[i].correos);
                    }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_buscar_correos.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar los correos.');
                }
            });
        }

        /*Muestra costo administrativo segun la unidad negocio y sucursal seleccionada*/
        function muestraCostoAdministrativo(idUnidadNegocio,idSucursal){
            $('#i_costo_administrativo').val(0);
            $.ajax({
                type: 'POST',
                url: 'php/costo_administrativo_buscar_costo.php',
                dataType:"json", 
                data:  {'idUnidadNegocio' : idUnidadNegocio,'idSucursal':idSucursal},
                success: function(data) {
                    if(data.length > 0){
                        $('#i_costo_administrativo').val(formatearNumero(data[0].costo));
                    }else{
                        $('#i_costo_administrativo').val(0);
                    }
                },
                error: function (xhr) {
                    console.log('php/costo_administrativo_buscar_costo.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar el costo administrativo.');
                }
            });
        }

        /*Busca firmantes y selecciona*/
        $('#b_buscar_firmantes').click(function(){
            $('#i_filtro_firmantes').val('');
            muestraModalFirmantes('renglon_firmantes_asigna','t_firmantes tbody','dialog_buscar_firmantes',$('#s_id_unidades').val(),$('#s_id_sucursales').val());
        });

        $('#t_firmantes').on('click', '.renglon_firmantes_asigna', function() {

            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_firmante').attr('alt',id).val(nombre);
            $('#dialog_buscar_firmantes').modal('hide');

        });

        /*Busca razón social y selecciona*/
        $('#b_buscar_razon_social_emisora').click(function(){
            $('#i_filtro_razon_social_emisora').val('');
            muestraModalEmpresasFiscales('renglon_razon_social_emisora','t_razon_social_emisora tbody','dialog_buscar_razon_social_emisora');
        });

        $('#t_razon_social_emisora').on('click', '.renglon_razon_social_emisora', function() {

            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_razon_social_emisora').attr('alt',id).val(nombre);
            $('#dialog_buscar_razon_social_emisora').modal('hide');

        });

        $('#b_buscar_razon_social_salario').click(function(){
            $('#i_filtro_razon_social_salario').val('');
            muestraModalEmpresasFiscalesCuotas('renglon_razon_social_salario','t_razon_social_salario tbody','dialog_buscar_razon_social_salario');
        });

        $('#t_razon_social_salario').on('click', '.renglon_razon_social_salario', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_razon_social_salario').attr('alt',id).val(nombre);
            $('#dialog_buscar_razon_social_salario').modal('hide');
            $('#s_salario_diario').attr('disabled',false);

            //-->NJES February/05/2021 ya no se puede capturar el salario diario, solo se puede seleccionar del combo
            //-->NJES Sep/29/2020 verificar si tiene permiso para capturar salario sin importar puesto y razón social
            /*if(verificaPermisoElemento(idUsuario,'CAPTURAR_SALARIO',idUnidadActual) == 1)
            {
                $('#div_salario_diario').hide(); 
                $('#div_salario_captura').show();
            }else{ */
                $('#div_salario_captura').hide();  
                $('#div_salario_diario').show();  
                muestraSelectSalariosRazonSocial('s_salario_diario',id,0);
            //} 

            //muestraSelectSalariosRazonSocial('s_salario_diario',id,0);
            $('#i_infonavit').val('');
            $('#i_imss').val('');

            calculaCostoTotalUnitarioElementos();
            calculaCostoTotalElementos();
            calculaPrecioTotalElementos();
        });

        /*Busca uniformes y selecciona*/
        $('#b_buscar_uniforme').click(function(){
            if($('#s_id_sucursales').val() > 0)
            {
                if($('#i_cantidad_uniforme').val() != '')
                {
                    $('#i_uniforme').val('');
                    $('.renglon_uniforme').remove();

                    $.ajax({
                        type: 'POST',
                        url: 'php/uniformes_buscar_id_sucursal.php',
                        dataType:"json", 
                        data:{'idSucursal':$('#s_id_sucursales').val()},
                        success: function(data) {
                        
                        if(data.length != 0){

                                $('.renglon_uniforme').remove();
                        
                                for(var i=0;data.length>i;i++){

                                    ///llena la tabla con renglones de registros
                                    var html='<tr class="renglon_uniforme" alt="'+data[i].id+'" alt2="'+data[i].nombre+'" alt3="'+data[i].descripcion+'" alt4="'+data[i].costo+'">\
                                                <td data-label="Clave">' + data[i].clave+ '</td>\
                                                <td data-label="Nombre">' + data[i].nombre+ '</td>\
                                                <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                                <td data-label="Costo">' + data[i].costo+ '</td>\
                                            </tr>';
                                    ///agrega la tabla creada al div 
                                    $('#t_uniformes tbody').append(html);   
                                    $('#dialog_buscar_uniformes').modal('show');   
                                }
                        }else{

                                mandarMensaje('No se encontró información');
                        }

                        },
                        error: function (xhr) {
                            console.log('php/empresas_fiscales_buscar.php --> '+JSON.stringify(xhr));
                            mandarMensaje('* No se encontró información al buscar uniformes');
                        }
                    });
                }else{
                    mandarMensaje('Ingresa una cantidad primero');
                    $('#i_cantidad_uniforme').css('border','2px solid #39c');
                }
            }else{
                mandarMensaje('Seleccionar una sucursal primero');
            }
        });

        $('#t_uniformes').on('click', '.renglon_uniforme', function() {

            $('#i_cantidad_uniforme').css('border','2px solid #ced4da');

            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var descripcion = $(this).attr('alt3');
            var costo = $(this).attr('alt4');

            var cantidad = $('#i_cantidad_uniforme').val();

            var costo_total = parseFloat(quitaComa(cantidad))*parseFloat(quitaComa(costo));

            var costo_mensual = costo_total/6;

            $('#i_uniforme').val(nombre).attr({'id_uniforme':id,'descripcion':descripcion});
            $('#i_costo_unitario_uniforme').val(formatearNumero(costo));
            $('#i_costo_total_uniforme').val(formatearNumero(costo_total));
            $('#i_costo_mensual_uniforme').val(formatearNumero(costo_mensual));

            $('#dialog_buscar_uniformes').modal('hide');

        });

        $('#i_costo_unitario_uniforme').change(function(){
            if($('#i_cantidad_uniforme').val() != ''){
                var cantidad = $('#i_cantidad_uniforme').val();
                var costo = $('#i_costo_unitario_uniforme').val();

                var costo_total = parseFloat(quitaComa(cantidad))*parseFloat(quitaComa(costo));

                var costo_mensual = costo_total/6;

                $('#i_costo_mensual_uniforme').val(formatearNumero(costo_mensual));
            }
        });

        $('#b_agrega_uniforme').click(function(){
            $('#b_agrega_uniforme').prop('disabled',true);

            if ($('#forma_uniformes').validationEngine('validate')){
                var id= $('#i_uniforme').attr('id_uniforme');
                var nombre = $('#i_uniforme').val();
                var descripcion = $('#i_uniforme').attr('descripcion');
                var costo = quitaComa($('#i_costo_unitario_uniforme').val());
                var costo_total = quitaComa($('#i_costo_total_uniforme').val());
                var costo_mensual = quitaComa($('#i_costo_mensual_uniforme').val());

                var html='<tr class="renglon_uniforme_lista" alt="'+id+'">';
                    html += '<td data-label="Cantidad">' + $('#i_cantidad_uniforme').val() + '</td>';
                    html += '<td data-label="Nombre">' + nombre + '</td>';
                    html += '<td data-label="Descripción">' + descripcion + '</td>';
                    html += '<td data-label="Costo Unico">' + formatearNumero(costo) + '</td>';
                    html += '<td data-label="Costo Total">' + formatearNumero(costo_total) + '</td>';
                    html += '<td data-label="Costo Mensual">' + formatearNumero(costo_mensual) + '</td>';
                    html += '<td><button type="button" class="btn btn-secondary btn-sm b_eliminar_uniforme eliminar" alt="'+id+'">\
                                    <i class="fa fa-times" aria-hidden="true"></i>\
                                </button></td>';
                    html += '</tr>';

                $('#t_lista_uniformes tbody').append(html);

                calculaCostoTotalUniforme();

                $('#i_uniforme').val('').attr({'id_uniforme':0,'descripcion':''});
                $('#i_costo_unitario_uniforme').val('');
                $('#i_costo_total_uniforme').val('');
                $('#i_costo_mensual_uniforme').val('');
                $('#i_cantidad_uniforme').val('');

                $('#b_agrega_uniforme').prop('disabled',false);
                $('#forma_uniformes').validationEngine('hide');
            }else
                $('#b_agrega_uniforme').prop('disabled',false);
        });

        $(document).on('click','.b_eliminar_uniforme',function(){
            $(this).parent().parent().remove();
            calculaCostoTotalUniforme();
        });
        
        /*********************inicio llena lista clientes*********************/
        function muestraClientes(){
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_clientes.php',
                dataType:"json", 
                success: function(data) {
                    $('#lista_clientes').empty();
                    for(var i=0;data.length>i;i++){

                        var html='<option value="'+data[i].nombre+'" alt="'+data[i].id+'"></option>';
                        
                        $('#lista_clientes').append(html);
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_buscar_clientes.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar clientes.');
                }
            });
        }

        $('#i_nombre_cliente').change(function(){
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_clientes_id.php',
                dataType:"json", 
                data:  {'nombreCliente' : $('#i_nombre_cliente').val()},
                success: function(data) {
                    if(data.length > 0)
                    {
                        $('#i_nombre_comercial').val(data[0].nombre_comercial);
                        $('#i_dirigido').val(data[0].dirigido);
                        $('#i_telefono').val(data[0].telefono);
                        $('#i_email').val(data[0].email);
                        $('#i_calle').val(data[0].calle);
                        $('#i_num_ext').val(data[0].num_exterior);
                        $('#i_num_int').val(data[0].num_interior);
                        $('#i_colonia').val(data[0].colonia);
                        $('#i_codigo_postal').val(data[0].codigo_postal);
                        $('#i_rfc').val(data[0].rfc);
                        $('#i_rep_legal').val(data[0].representante_legal);
                        $('#i_razon_social_cliente').val(data[0].razon_social);
                        $('#i_contacto').val(data[0].contacto);
                        
                        if(data[0].id_pais != 0)
                        {
                            $('#s_paises').val(data[0].id_pais);
                            $('#s_paises').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_paises').val('');
                            $('#s_paises').select2({placeholder: 'Selecciona'});
                        }

                        if(data[0].id_estado != 0)
                        {
                            $('#s_estados').val(data[0].id_estado);
                            $('#s_estados').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_estados').val('');
                            $('#s_estados').select2({placeholder: 'Selecciona'});
                        }

                        if(data[0].id_municipio != 0)
                        {
                            $('#s_municipios').val(data[0].id_municipio);
                            $('#s_municipios').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_municipios').val('');
                            $('#s_municipios').select2({placeholder: 'Selecciona'});
                        }
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_buscar_clientes_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar cliente');
                }
            });
        });
        /*********************Fin llena lista clientes*********************/

        /***********************Inicio Guarda Proyecto**************************/
        $('#b_guardar_proyecto').click(function(){
            $('#b_guardar_proyecto').prop('disabled',true);

            if($('#form_datos_proyecto').validationEngine('validate'))  {
                verificaProyecto();
            }else{
                $('#b_guardar_proyecto').prop('disabled',false);
            }
        });

        function verificaProyecto(){
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_verificar_proyecto.php',
                data:  {'nombreProyecto':$('#i_proyecto').val()},
                success: function(data) {
                    if(data == 1)
                    {
                        $('#b_guardar_proyecto').prop('disabled',false);

                        if (proyectoOriginal == $('#i_proyecto').val()) 
                        {
                            guardaProyecto();
                        } else {
                            mandarMensaje('El proyecto: '+ $('#i_proyecto').val()+' ya existe intenta con otro nombre');
                            $('#i_proyecto').val('');
                        }
                    } else {
                        guardaProyecto();
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_verificar_proyecto.php --> '+JSON.stringify(xhr))
                    mandarMensaje('* No se encontró información al verificar proyecto.');
                    $('#b_guardar_proyecto').prop('disabled',false);
                }
            });
        }

        function guardaProyecto(){
            var datos = Array();

            datos = {
                'nombreProyecto' : $('#i_proyecto').val(),
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'usuario' : usuario,
                'idUsuario' : idUsuario
            };
        
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar_proyecto.php',  
                data:{'datos':datos},
                success: function(data){
                    
                    if (data != 0) {
                        idProyecto = data;
                        $('#l_estatus').css('background-color','rgb(128,128,128)').text('En proceso');
                        mandarMensaje('Se guardó el nuevo registro');
                        $('#b_guardar_proyecto').prop('disabled',false);

                        $('#b_guardar_proyecto').css('display','none');
                        $('#b_guardar').prop('disabled',false);

                        //--> habilitamos guardar empresa
                        $('#b_guardar_empresa').prop('disabled', false);

                        $('#i_nombre_cotizacion').val($('#i_proyecto').val()+' 1');

                        $('.coti').prop('disabled',false);

                        $('#i_proyecto, #s_id_unidades, #s_id_sucursales').prop('disabled',true);

                        $('#collapse_clientes').addClass('show');

                        muestraCostoAdministrativo($('#s_id_unidades').val(),$('#s_id_sucursales').val());
                        obtienePorcentajeUtilidad($('#s_id_unidades').val(),$('#s_id_sucursales').val());
                    }else{
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar_proyecto').prop('disabled',false);
                    }
                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_guardar_proyecto.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar proyecto');
                    $('#b_guardar_proyecto').attr('disabled',false);
                }
            });
        }
        /***********************Fin Guarda Proyecto**************************/

        /********************Inicio Guardar Cotización*********************/
        $('#b_guardar').click(function(){
            $('#b_guardar').prop('disabled',true);
            if($('.form_datos_cotizacion').validationEngine('validate'))  {
                verificaCotizacion();
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function verificaCotizacion(){
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_verificar.php',
                data:  {'nombreCotizacion':$('#i_nombre_cotizacion').val()},
                success: function(data) {
                    if(data == 1)
                    {
                        $('#b_guardar').prop('disabled',false);

                        if (parseInt(actualizaCotizacion) == 1 && cotizacionOriginal === $('#i_nombre_cotizacion').val()) {
                            guardarCotizacion('editar');
                        } else {
                            mandarMensaje('La cotización: '+ $('#i_nombre_cotizacion').val()+' ya existe intenta con otro nombre');
                            $('#i_nombre_cotizacion').val('');
                        }
                    }
                    else
                    {
                        $('#b_guardar_empresa').css('display', 'none');
                        guardarCotizacion('nueva');
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_verificar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al verificar cotización');
                }
            });
        }

        function guardarCotizacion(tipo){
            
            var datos = Array();
            datos = {
                'idCotizacion' : idCotizacion,
                'folio':folioCotizacion,
                'usuario' : usuario,
                'idUsuario' : idUsuario,
                'idProyecto' : idProyecto,
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'nombreCotizacion' : $('#i_nombre_cotizacion').val(),
                'id_firmante' : $('#i_firmante').attr('alt'),
                'firma_digital' : $('#ch_firma_digital').is(':checked') ? 1 : 0,
                'texto_inicio' : $('#ta_texto_inicio').val(),
                'texto_fin' : $('#ta_texto_fin').val(),
                'observaciones_generales' : $('#ta_observaciones_generales').val(),
                'observaciones_internas' : $('#ta_observaciones_internas').val(),
                'tipo' : tipo,
                //datos cliente
                'nombre_comercial' : $('#i_nombre_comercial').val(),
                'cliente' : $('#i_nombre_cliente').val(),
                'dirigido' : $('#i_dirigido').val(),
                'razon_social_cliente' : $('#i_razon_social_cliente').val(),
                'telefono' : $('#i_telefono').val(),
                'email' : $('#i_email').val(),
                'calle' : $('#i_calle').val(),
                'num_exterior' : $('#i_num_ext').val(),
                'num_interior' : $('#i_num_int').val(),
                'colonia' : $('#i_colonia').val(),
                'codigo_postal' : $('#i_codigo_postal').val(),
                'rfc' : $('#i_rfc').val(),
                'representante_legal' :$('#i_rep_legal').val(),
                'contacto' : $('#i_contacto').val(),
                'id_pais' : $('#s_paises').val(),
                'id_estado' : $('#s_estados').val(),
                'id_municipio' : $('#s_municipios').val(),
                'idCliente' : idCliente
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar.php', 
                data: {'datos':datos},
                success: function(data){
                    //console.log(data);
                    if(data > 0)
                    {
                        idCotizacion = data;
                        $('#i_cotizacion').val(idCotizacion);
                            
                        buscaCotizacion(idCotizacion);

                        if(tipo == 'nueva'){
                            mandarMensaje('Se creo correctamente la cotización');
                        }else{
                            mandarMensaje('Se actualizó correctamente la cotización');
                        }

                    }else{
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar cotización');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }
        /********************Fin Guardar Cotización*********************/

        function buscaCotizacion(idCotizacion){
            $('#div_comision_resumen').css('display','none'); 

            $('#b_guardar_aprobacion,#b_guardar_comision,#b_aprobar_cotizacion').prop('disabled',false);
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_id.php',
                dataType:"json", 
                data:{'idCotizacion':idCotizacion},
                success: function(data) {
                   
                   if(data.length > 0){

                        muestraSucursalCorporativo('i_id_sucursal',data[0].id_unidad_negocio,'CREAR_COTIZACIONES',idUsuario);  //permisos boton
                       
                        folioCotizacion=data[0].folio;
                        idCliente=data[0].id_cliente;
                        idProyecto=data[0].id_proyecto;
                        cotizacionOriginal=data[0].nombre_cotizacion;
                        proyectoOriginal=data[0].proyecto;
                        idSucursal=data[0].id_sucursal;
                        idUnidadNegocio=data[0].id_unidad_negocio;
                        
                        $('#i_folio').text('Folio: '+data[0].folio);
                        $('#dato_fecha_creacion').text('Creada el: '+data[0].timestamp_version+' * Versión '+data[0].version);
                        $('#i_proyecto').val(data[0].proyecto);
                        $('#i_nombre_cotizacion').val(data[0].nombre_cotizacion);
                        $('#s_periodicidad').val(data[0].periodicidad);
                        generaCampoDia(data[0].periodicidad,data[0].dia);
                        $('#s_tipo_facturacion').val(data[0].tipo_facturacion);
                        $('#i_firmante').attr('alt',data[0].id_firmante).val(data[0].firmante);
                        $('#i_razon_social_emisora').attr('alt',data[0].id_razon_social_emisora).val(data[0].razon_social_emisora);
                        $('#ta_justificacion_rechazada').val(data[0].justificacion_rechazada);
                        $('#i_comision_cotizacion').val(data[0].comision);
                        if(data[0].id_unidad_negocio != 0)
                        {
                            $('#s_id_unidades').val(data[0].id_unidad_negocio);
                            $('#s_id_unidades').select2({placeholder: $(this).data('elemento')});

                            //-->NJES February/05/2021 si tiene permiso poder editar el sueldo mensula en elementos
                            if(verificaPermisoElemento(idUsuario,'EDITAR_SUELDO',data[0].id_unidad_negocio) == 1)
                            {
                                $('#i_sueldo_elemento').prop('readonly',false); 
                            }else{ 
                                $('#i_sueldo_elemento').prop('readonly',true);  
                            }

                            if(verificaPermisoElemento(idUsuario,'CAPTURA_COSTO_UNIFORME',data[0].id_unidad_negocio) == 1)
                            {
                                $('#i_costo_unitario_uniforme').prop('readonly',false); 
                            }else{ 
                                $('#i_costo_unitario_uniforme').prop('readonly',true);  
                            }

                        }

                        //-->NJES February/05/2021 ya no se puede capturar el salario diario, solo se puede seleccionar del combo
                        //-->NJES Sep/29/2020 verificar si tiene permiso para capturar salario sin importar puesto y razón social
                        /*if(verificaPermisoElemento(idUsuario,'CAPTURAR_SALARIO',data[0].id_unidad_negocio) == 1)
                        {
                            $('#div_salario_diario').hide(); 
                            $('#div_salario_captura').show();
                        }else{ */
                            $('#div_salario_captura').hide();  
                            $('#div_salario_diario').show();  
                        //} 

                        if(data[0].id_sucursal != 0)
                        {
                            $('#s_id_sucursales').val(data[0].id_sucursal);
                            $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                        }

                        if(data[0].firma_digital == 1)
                        {
                            $('#ch_firma_digital').prop('checked', true).attr('disabled',false);
                        }else{
                            $('#ch_firma_digital').prop('checked', false).attr('disabled',false);
                        }
                        
                        $('#ta_texto_inicio').val(data[0].texto_inicio);
                        $('#ta_texto_fin').val(data[0].texto_fin);
                        $('#ta_observaciones_generales').text(data[0].observaciones_generales);
                        $('#ta_observaciones_internas').text(data[0].observaciones_internas);
                        $('#i_nombre_comercial').val(data[0].nombre_comercial);
                        $('#i_nombre_cliente').val(data[0].cliente);
                        $('#i_dirigido').val(data[0].dirigido);
                        $('#i_razon_social_cliente').val(data[0].razon_social_cliente);
                        $('#i_telefono').val(data[0].telefono);
                        $('#i_email').val(data[0].email);
                        $('#i_calle').val(data[0].calle);
                        $('#i_num_ext').val(data[0].num_exterior);
                        $('#i_num_int').val(data[0].num_interior);
                        $('#i_colonia').val(data[0].colonia);
                        $('#i_codigo_postal').val(data[0].codigo_postal);
                        $('#i_rfc').val(data[0].rfc);
                        $('#i_rep_legal').val(data[0].representante_legal);
                        $('#i_contacto').val(data[0].contacto);
                        $('#ta_observaciones').val(data[0].observacion_aprobar);

                        if(data[0].id_pais != 0)
                        {
                            $('#s_paises').val(data[0].id_pais);
                            $('#s_paises').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_paises').val('');
                            $('#s_paises').select2({placeholder: 'Selecciona'});
                        }

                        if(data[0].id_estado != 0)
                        {
                            $('#s_estados').val(data[0].id_estado);
                            $('#s_estados').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_estados').val('');
                            $('#s_estados').select2({placeholder: 'Selecciona'});
                        }

                        if(data[0].id_municipio != 0)
                        {
                            $('#s_municipios').val(data[0].id_municipio);
                            $('#s_municipios').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_municipios').val('');
                            $('#s_municipios').select2({placeholder: 'Selecciona'});
                        }
                        
                        if(data[0].fecha_inicio_facturacion != '0000-00-00')
                        {
                            $('#i_inicio_facturacion').val(data[0].fecha_inicio_facturacion);
                        }else{
                            $('#i_inicio_facturacion').val('');
                        }

                        $('#ta_observaciones').prop('disabled',false);
                        $('#ta_correos').prop('disabled',false);
                        $('#ta_justificacion_rechazada').prop('disabled',false);
                        $('input[name=radio_aprobada]:checked').prop('disabled',false);
                        $('input[name=radio_aprobada]').prop('disabled',false);
                        $('#s_periodicidad').prop('disabled',false);
                        $('#s_tipo_facturacion').prop('disabled',false);

                        if(data[0].estatus_proyecto == 1){  //Proceso
                            $('#l_estatus').css('background-color','rgb(128,128,128)').text('En proceso');
                        }else if(data[0].estatus_proyecto == 2){  //Negociación
                            $('#l_estatus').css('background-color','rgb(204,153,0)').text('Negociación');
                        }else if(data[0].estatus_proyecto == 3){  //Rechazada
                            $('#l_estatus').css('background-color','rgb(220,53,69)').text('Rechazada');
                            $('#div_justificacion_rechazada').show();
                            $('#radio_rechazada').click();
                            $('#b_guardar_aprobacion,#b_aprobar_cotizacion').prop('disabled',true);

                            $('#ta_observaciones').prop('disabled',true);
                            $('#ta_correos').prop('disabled',true);
                            $('#ta_justificacion_rechazada').prop('disabled',true);
                            $('input[name=radio_aprobada]').prop('disabled',true);
                            $('#s_periodicidad').prop('disabled',true);
                            $('#s_tipo_facturacion').prop('disabled',true);

                        }else{  //Aprobada 
                            $('#l_estatus').css('background-color','rgb(40,167,69)').text('Aprobada ');
                            $('#div_justificacion_rechazada').hide();
                            $('#b_guardar_aprobacion,#b_aprobar_cotizacion').prop('disabled',true);
                            $('#radio_aprobada').click();

                            $('#ta_observaciones').prop('disabled',true);
                            $('#ta_correos').prop('disabled',true);
                            $('#ta_justificacion_rechazada').prop('disabled',true);
                            $('input[name=radio_aprobada]').prop('disabled',true);
                            $('#s_periodicidad').prop('disabled',true);
                            $('#s_tipo_facturacion').prop('disabled',true);
                            
                        }

                        muestraCorreos(data[0].id_unidad_negocio,data[0].id_sucursal);
                        muestraCostoAdministrativo(data[0].id_unidad_negocio,data[0].id_sucursal);
                        obtienePorcentajeUtilidad(data[0].id_unidad_negocio,data[0].id_sucursal);

                        estatusProyecto=data[0].estatus_proyecto;

                        estatusCotizacion=data[0].estatus_cotizacion;
                            
                        if(data[0].estatus_cotizacion == 1) ///se puede editar la cotizacion
                        {   
                            $('#b_guardar').prop('disabled',false);
                            $('.coti').prop('disabled',false);
                            
                            $('#b_agrega_elemento, #b_agrega_elemento2, #b_agrega_equipo, #b_agrega_equipo2, #b_agrega_servicio, #b_agrega_servicio2, #b_agrega_vehiculo, #b_agrega_vehiculo2,#b_agrega_consumibles,#b_agrega_consumibles2,#b_guardar_observaciones_elemento,#b_guardar_observaciones_equipo,#b_guardar_observaciones_servicio,#b_guardar_observaciones_vehiculo,#b_guardar_observaciones_consumibles').prop('disabled',false);
                            actualizaCotizacion=1;
                            $('#s_puestos').prop('disabled',false);
                        }else{   ///ya no se puede editar la cotizacion, solo crear una nueva version
                            $('#b_guardar').prop('disabled',true);
                            $('.coti').prop('disabled',true);
                            
                            $('#b_guardar_comision').prop('disabled',true);

                            $('#b_agrega_elemento, #b_agrega_elemento2, #b_agrega_equipo, #b_agrega_equipo2, #b_agrega_servicio, #b_agrega_servicio2, #b_agrega_vehiculo, #b_agrega_vehiculo2,#b_agrega_consumibles,#b_agrega_consumibles2,#b_guardar_observaciones_elemento,#b_guardar_observaciones_equipo,#b_guardar_observaciones_servicio,#b_guardar_observaciones_vehiculo,#b_guardar_observaciones_consumibles').prop('disabled',true);
                            actualizaCotizacion=0;
                        }
                            
                        if(elementosP == 1)
                        {
                            $('#div_card_elementos').css('display','block');
                        }else{
                            if(data[0].elementos == 1)
                            {
                                $('#div_card_elementos').css('display','block');
                                $('#b_agrega_elemento, #b_agrega_elemento2,#b_guardar_observaciones_elemento').prop('disabled',true);
                                $('.b_eliminar_elemento,.b_editar_elemento').prop('disabled',true);
                            }else{
                                $('#div_card_elementos').css('display','none');
                            }
                        }   

                        if(equipoP == 1)
                        {
                            $('#div_card_equipo').css('display','block');
                        }else{
                            if(data[0].equipo == 1)
                            {
                                $('#div_card_equipo').css('display','block');
                                $('#b_agrega_equipo, #b_agrega_equipo2,#b_guardar_observaciones_equipo').prop('disabled',true);
                                $('.b_eliminar_equipo,.b_editar_equipo').prop('disabled',true);
                            }else{
                                $('#div_card_equipo').css('display','none');
                            }
                        }   

                        if(serviciosP == 1)
                        {
                            $('#div_card_servicios').css('display','block');
                        }else{
                            if(data[0].servicios == 1)
                            {
                                $('#div_card_servicios').css('display','block');
                                $('#b_agrega_servicio, #b_agrega_servicio2,#b_guardar_observaciones_servicio').prop('disabled',true);
                                $('.b_eliminar_servicio,.b_editar_servicio').prop('disabled',true);
                            }else{
                                $('#div_card_servicios').css('display','none');
                            }
                        }   

                        if(vehiculosP == 1)
                        {
                            $('#div_card_vehiculos').css('display','block');
                        }else{
                            if(data[0].vehiculos == 1)
                            {
                                $('#div_card_vehiculos').css('display','block');
                                $('#b_agrega_vehiculo, #b_agrega_vehiculo2,#b_guardar_observaciones_vehiculo').prop('disabled',true);
                                $('.b_eliminar_vehiculo,.b_editar_vehiculo').prop('disabled',true);
                            }else{
                                $('#div_card_vehiculos').css('display','none');
                            }
                        }  

                        if(consumiblesP == 1)
                        {
                            $('#div_card_consumibles').css('display','block');
                        }else{
                            if(data[0].consumibles == 1)
                            {
                                $('#div_card_consumibles').css('display','block');
                                $('#b_agrega_consumibles, #b_agrega_consumibles2,#b_guardar_observaciones_consumibles').prop('disabled',true);
                                $('.b_eliminar_consumibles,.b_editar_consumibles').prop('disabled',true);
                            }else{
                                $('#div_card_consumibles').css('display','none');
                            }
                        }  
                         
                        //$('#s_puestos').prop('disabled',false);
                        muestraSelectSalariosPuestos('s_puestos',data[0].id_unidad_negocio,data[0].id_sucursal,idUsuario);

                        buscarElementos(idCotizacion);
                        buscarEquipo(idCotizacion);
                        buscarServicio(idCotizacion);
                        buscarVehiculo(idCotizacion);
                        buscaEquipoProrrateo(idCotizacion);
                        buscarConsumible(idCotizacion);

                        $('#i_proyecto, #s_id_unidades, #s_id_sucursales').prop('disabled',true);

                        $('.div_botones_alt2').css('display','none');
                        $('.div_botones_alt').css('display','block');

                        $('#b_guardar_proyecto').css('display','none');
                        $('#b_imprimir').prop('disabled',false);

                        muestraObservacionesSecciones(idCotizacion);
                   }
                    
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar cotización.');
                }
            });

            muestraClientes();

            $('.collapse').addClass('show');
            $('#b_expandir').css('display','none');
            $('#b_comprimir').css('display','block');
        }

        function muestraObservacionesSecciones(idCotizacion){
            $('#ta_observaciones_generales_elemento').val('');
            $('#ta_observaciones_internas_elemento').val('');
            $('#ta_observaciones_generales_equipo').val('');
            $('#ta_observaciones_internas_equipo').val('');
            $('#ta_observaciones_generales_servicio').val('');
            $('#ta_observaciones_internas_servicio').val('');
            $('#ta_observaciones_generales_vehiculo').val('');
            $('#ta_observaciones_internas_vehiculo').val('');
            $('#ta_observaciones_generales_consumibles').val('');
            $('#ta_observaciones_internas_consumibles').val('');

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_id_observaciones_secciones.php',
                dataType:"json", 
                data:{'idCotizacion':idCotizacion},
                success: function(data) {
                   if(data.length > 0)
                    {
                        $('#ta_observaciones_generales_elemento').val(data[0].elementos_observaciones_externas);
                        $('#ta_observaciones_internas_elemento').val(data[0].elementos_observaciones_internas);
                        $('#ta_observaciones_generales_equipo').val(data[0].equipo_observaciones_externas);
                        $('#ta_observaciones_internas_equipo').val(data[0].equipo_observaciones_internas);
                        $('#ta_observaciones_generales_servicio').val(data[0].servicios_observaciones_externas);
                        $('#ta_observaciones_internas_servicio').val(data[0].servicios_observaciones_internas);
                        $('#ta_observaciones_generales_vehiculo').val(data[0].vehiculos_observaciones_externas);
                        $('#ta_observaciones_internas_vehiculo').val(data[0].vehiculos_observaciones_internas);
                        $('#ta_observaciones_generales_consumibles').val(data[0].consumibles_observaciones_externas);
                        $('#ta_observaciones_internas_consumibles').val(data[0].consumibles_observaciones_internas);
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_buscar_id_observaciones_secciones.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar observaciones de secciones.');
                }
            });
        }

        /**************Inicio Muestra leyenda segun el radio que este seleccionado*************/
        $('input[type=radio]').click(function(){
            //muestraLeyendas();
        });

        //muestraLeyendas();

        function muestraLeyendas(){
            if($('#radio_vehiculo1').is(':checked')){
                $('#vehiculo_d').text('* Si el precio es 0 no se mostrará en la cotización');
            }else{
                $('#vehiculo_d').text('');
            }

            if($('#radio_servicio1').is(':checked')){
                $('#servicio_d').text('* Si el precio es 0 no se mostrará en la cotización');
            }else{
                $('#servicio_d').text('');
            }

            if($('#radio_equipo1').is(':checked')){
                $('#equipo_d').text('* Si el precio es 0 no se mostrará en la cotización');
            }else{
                $('#equipo_d').text('');
            }
        }
        /**************Fin Muestra leyenda segun el radio que este seleccionado*************/

        /******* Busca todas las cotixzaciones mediante filtros ingresados*********/
        /******* primero se limpian todos los filtros y por defaul muestra todos las cotizaciones activas de todas las sucursales a las que tiene acceso de la unidad de negocio actual****/
        $('#b_buscar').on('click',function(){
            muestraSelectUnidades(matriz,'s_filtro_unidad',$('#s_id_unidades').val());
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_id_unidades').val(),modulo,idUsuario);

            $('#i_buscar_cliente').val('').attr('alt','');
            $('#b_filtrar_cliente').prop('disabled',true);
            $('#i_buscar_proyecto').val('').attr('alt','');
            $('#b_filtro_proyecto').prop('disabled',true);
            $('#i_buscar_usuario').val('').attr('alt','');
            $('#s_filtro_estatus').val('').prop('disabled',true);
            $('#i_filtro_cotizaciones').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');

            $('#radio_activas').prop('checked',true);
            $('#radio_todas').prop('checked',false);
            $('#radio_ultimas').prop('checked',false);

            $('.renglon_cotizaciones').remove();

            $('#dialog_cotizaciones').modal('show');
        });
        /******* Fin boton buscar mediante filtros ingresados*********/

        $(document).on('change','#s_filtro_unidad',function(){
            if($('#s_filtro_unidad').val()!= ''){
                $('.img-flag').css({'width':'50px','height':'20px'});
            }
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);
            $('#i_buscar_cliente').val('').attr('alt','');
            $('#i_buscar_usuario').val('').attr('alt','');
            $('#b_filtrar_cliente').prop('disabled',true);
            $('#i_buscar_proyecto').val('').attr('alt','');
            $('#b_filtro_proyecto').prop('disabled',true);
            $('#i_filtro_cotizaciones').val('');
            $('#s_filtro_estatus').val('').prop('disabled',true);
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('').prop('disabled',true);

            $('.renglon_cotizaciones').remove();

            mandarMensaje('Selecciona una sucursal para comenzar la búsqueda');
        });

        $(document).on('change','#s_filtro_sucursal',function(){

            $('#i_buscar_cliente').val('').attr('alt','');
            $('#b_filtrar_cliente').prop('disabled',true);
            $('#i_buscar_proyecto').val('').attr('alt','');
            $('#b_filtro_proyecto').prop('disabled',true);
            $('#i_filtro_cotizaciones').val('');
            $('#b_filtro_proyecto').prop('disabled',false);
            $('#s_filtro_estatus').val('').prop('disabled',true);

            buscarCotizacionesFiltros($('#s_filtro_unidad').val());
        });

        /******* Manda llamar la funcion si algunos de los filtros se activa usuarios o estatus *********/
        $(document).on('change','.filtros',function(){
            if($('#s_filtro_sucursal').val() != null)
            {
                buscarCotizacionesFiltros($('#s_filtro_unidad').val());
            }else{
                mandarMensaje('Selecciona una sucursal para comenzar la búsqueda');
            }
        });
        /******* Fin Manda llamar la funcion si algunos de los filtros se activa *********/

        /******* Manda llamar la funcion si algunos de los filtros cualquier radio limpia los filtros y manda hacer la buqueda con el radio seleccionado 'Activas' 'Todas' 'Ultimas' *********/    
        $(document).on('change','input[name="radio_filtro"]',function(){
            if($('#s_filtro_sucursal').val() != null)
            {
                buscarCotizacionesFiltros($('#s_filtro_unidad').val());
            }else{
                mandarMensaje('Selecciona una sucursal para comenzar la búsqueda');
            }
        });
         /******* Fin radios Manda llamar la funcion si algunos de los filtros se activa *********/

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                if($('#s_filtro_sucursal').val() != null)
                {
                    buscarCotizacionesFiltros($('#s_filtro_unidad').val());
                    $('#i_fecha_fin').prop('disabled',false);
                }else{
                    mandarMensaje('Selecciona una sucursal para comenzar la búsqueda');
                    $('#i_fecha_inicio').val(null);
                    $('#i_fecha_fin').prop('disabled',true);
                }
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_filtro_sucursal').val() != null)
            {
                buscarCotizacionesFiltros($('#s_filtro_unidad').val());
            }else{
                mandarMensaje('Selecciona una sucursal para comenzar la búsqueda');
            }
        });

        /******* Busca todas las cotixzaciones mediante filtros ingresados*********/
        function buscarCotizacionesFiltros(idFiltroUnidad){
            $('.renglon_cotizaciones').remove();
            var datos={
                'idUnidadNegocio':idFiltroUnidad,
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'filtroCliente':$('#i_buscar_cliente').attr('alt'),
                'filtroProyecto':$('#i_buscar_proyecto').attr('alt'),
                'filtroSucursal':$('#s_filtro_sucursal').val(),
                'filtroUsuario':$('#i_buscar_usuario').attr('alt'),
                'filtroEstatus': $('#s_filtro_estatus').val(),
                'radioFiltro': $('input[name="radio_filtro"]:checked').val()
            };
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_filtros.php',
                dataType:"json", 
                data:{'datos':datos},
                success: function(data) {
                       
                    $('.renglon_cotizaciones').remove();

                    if(data.length != 0){
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].estatus_cotizacion) == 1){

                                activo='Activa';
                            }else{
                                activo='Impresa';
                            }

                            var html='<tr class="renglon_cotizaciones" alt="'+data[i].id+'">\
                                        <td data-label="Folio">' + data[i].folio+ '</td>\
                                        <td data-label="Cotizacion">' + data[i].cotizacion+ '</td>\
                                        <td data-label="Version">' + data[i].version+ '</td>\
                                        <td data-label="Fecha Creacion">' + data[i].fecha_creacion+ '</td>\
                                        <td data-label="Proyecto">' + data[i].proyecto+ '</td>\
                                        <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Usuario">' + data[i].usuario+ '</td>\
                                        <td data-label="Estatus Cotizacion">' + activo+ '</td>\
                                        <td data-label="Estatus Proyecto">' + data[i].estatus_proyecto+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_cotizaciones tbody').append(html);   
 
                        }
                   }else{

                        mandarMensaje('No se encontraron cotizaciones con esos datos.');
                   }

                },
                error: function (xhr) {
                    console.log('php/buscarCotizacionesFiltros:'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar cotizacion con filtros');
                }
            });
        }    
        

        /******* Al dar click sobre alguna cotizacion esta manda a buscar los datos de la cotizacion selecionada *********/
        $('#t_cotizaciones').on('click', '.renglon_cotizaciones', function() {
            
            idCotizacion = $(this).attr('alt');
            
            buscaCotizacion(idCotizacion);
            $('#dialog_cotizaciones').modal('hide');

        });
        /******* Fin de click sobre renglon cotizacion  *********/

        /******* Buscar todos los usuarios *********/
        $('#b_filtro_usuario').on('click',function(){

            $('#i_buscar_usuario').val('').attr('alt','');
            $('.renglon_usuarios').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/usuarios_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_usuarios').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].activo) == 1){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_usuarios" alt="'+data[i].id_usuario+'" alt2="'+data[i].usuario+'">\
                                        <td data-label="usuario">' + data[i].usuario+ '</td>\
                                        <td data-label="Nombre">' + data[i].nombre_comp+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_usuarios tbody').append(html);   
                            $('#dialog_buscar_usuarios').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/usuarios_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar usuarios.');
                }
            });
        });
        /*******Fin de Buscar todos los usuarios *********/

        /*******Click en renglon usuarios al dar click se le da los valores correpondintes al iput de usurio y se manda hacer la busuqeda por filtros *********/
        $('#t_usuarios').on('click', '.renglon_usuarios', function() {
            
            var id = $(this).attr('alt');
            var usuario= $(this).attr('alt2');

            $('#i_buscar_usuario').val(usuario).attr('alt',id);

            if($('#s_filtro_sucursal').val() != null)
            {
                buscarCotizacionesFiltros($('#s_filtro_unidad').val());
            }else{
                mandarMensaje('Selecciona una sucursal para comenzar la búsqueda');
            }

            $('#dialog_buscar_usuarios').modal('hide');

        });
        /*******Fin Click en renglon usuarios *********/

         /*******Busca todos los proyectos realcionados a la sucursal seleccionada *********/
        $('#b_filtro_proyecto').on('click',function(){

            $('#i_buscar_proyecto').val('').attr('alt','');
            $('.renglon_proyecto').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/cotizaciones_buscar_proyectos.php',
                dataType:"json", 
                data:{'idSucursal':$('#s_filtro_sucursal').val()},

                success: function(data) {
                   //console.log(data);
                   if(data.length != 0){

                        $('.renglon_proyecto').remove();
                   
                        for(var i=0;data.length>i;i++){

                    
                            var html='<tr class="renglon_proyecto" alt="'+data[i].id+'" alt2="'+data[i].descripcion+'">\
                                        <td data-label="usuario">' + data[i].descripcion+ '</td>\
                                        <td data-label="Nombre">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_proyectos tbody').append(html);   
                            $('#dialog_buscar_proyectos').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_buscar_proyectos.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar proyectos');
                }
            });
        });
         /*******Fin buscar proyectos *********/

         /*******Click en renglon proyectos al dar click se le da los valores correpondintes al iput de i_buscar_proyecto y se manda hacer la busuqeda por filtros *********/
        $('#t_proyectos').on('click', '.renglon_proyecto', function() {
            
            var id = $(this).attr('alt');
            var proyecto= $(this).attr('alt2');

            $('#i_buscar_proyecto').val(proyecto).attr('alt',id);
            $('#b_filtrar_cliente').prop('disabled',false);
            $('#s_filtro_estatus').prop('disabled',false);
            
            if($('#s_filtro_sucursal').val() != null)
            {
                buscarCotizacionesFiltros($('#s_filtro_unidad').val());
            }else{
                mandarMensaje('Selecciona una sucursal para comenzar la búsqueda');
            }

            $('#dialog_buscar_proyectos').modal('hide');

        });
        /*******Fin click renglon proyectos *********/

        /*******Busca todos los clientes relacionados con el proyecto selecionado *********/
        $('#b_filtrar_cliente').on('click',function(){

            $('#i_buscar_cliente').val('').attr('alt','');
            $('.renglon_cliente').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/cotizaciones_buscar_clientes_proyecto.php',
                dataType:"json", 
                data:{'idProyecto':$('#i_buscar_proyecto').attr('alt')},

                success: function(data) {
                   //console.log(data);
                   if(data.length != 0){

                        $('.renglon_cliente').remove();
                   
                        for(var i=0;data.length>i;i++){

                    
                            var html='<tr class="renglon_cliente" alt="'+data[i].id_cliente+'" alt2="'+data[i].nombre+'">\
                                        <td data-label="Nombre">' + data[i].nombre+ '</td>\
                                        <td data-label="Nombre Comercial">' + data[i].nombre_comercial+ '</td>\
                                        <td data-label="Razón Social">' + data[i].razon_social+ '</td>\
                                        <td data-label="Municipio">' + data[i].municipio+ '</td>\
                                        <td data-label="Estado">' + data[i].estado+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_clientes tbody').append(html);   
                            $('#dialog_buscar_clientes').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_buscar_clientes_proyecto.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al filtrar clientes');
                }
            });
        });
        /*******Fin buscar clientes *********/

        /*******Click en renglon clientes al dar click se le da los valores correpondintes al iput de i_buscar_cliente y se manda hacer la busuqeda por filtros *********/
        $('#t_clientes').on('click', '.renglon_cliente', function() {
            
            var id = $(this).attr('alt');
            var nombre= $(this).attr('alt2');

            $('#i_buscar_cliente').val(nombre).attr('alt',id);
            
            if($('#s_filtro_sucursal').val() != null)
            {
                buscarCotizacionesFiltros($('#s_filtro_unidad').val());
            }else{
                mandarMensaje('Selecciona una sucursal para comenzar la búsqueda');
            }

            $('#dialog_buscar_clientes').modal('hide');

        });
       /*******Fin click renglon clientes *********/

        /***************** Funciones para secciones inicio ********************/
        /**************Inicio funciones equipo***************/
        
        //--> se agrega prorrateado de consumibles
        function buscaEquipoProrrateo(idCotizacion){
            
            $('#i_prorrateado').val('');
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_equipos_prorrateados_buscar.php',
                dataType:"json", 
                data:  {'idCotizacion':idCotizacion},
                success: function(data) {
                    $('#i_prorrateado').val(formatearNumero(data[0].prorrateo));
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_equipos_prorrateados_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro informacion al buscar prorrateo');
                }
            });
        }

        $('#b_agrega_equipo, #b_agrega_equipo2').click(function(){
            $('#b_agrega_equipo, #b_agrega_equipo2').prop('disabled',true);

            if ($('#form_equipo').validationEngine('validate')){
                if(parseInt($('#i_cantidad_equipo').val()) > 0){
                    //--> warning de que el precio es menor al costo
                    if(parseFloat(quitaComa($('#i_precio_equipo').val())) < parseFloat(quitaComa($('#i_costo_equipo').val()))){
                        $('#b_agrega_equipo, #b_agrega_equipo2').prop('disabled',false);
                        mandarMensajeConfimacion('El precio es menor al costo, ¿Deseas continuar?',0,'equipo_n');
                    }else{
                        guardarEquipo();
                    } 
                }else{
                    mandarMensaje('La cantidad debe ser mayor a 0');
                    $('#b_agrega_equipo, #b_agrega_equipo2').prop('disabled',false);
                }
            }else{
                $('#b_agrega_equipo, #b_agrega_equipo2').prop('disabled',false);
            }
        });

        //--> continua y si agrega el elemento aunque el precio sea menor al costo
        $(document).on('click','#b_equipo_n',function(){  
            guardarEquipo();
        });

        //--> Toma el id, elimina el registro de la tabla. Y toma los datos del renglon para subirlos a los campos a editar y despues guardar.
        $(document).on('click','.b_editar_equipo',function(){
            var idEquipo=$(this).attr('alt');

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_equipos_buscar_id.php',
                dataType:"json", 
                data:  {'idEquipo':idEquipo},
                success: function(data) {
           
                    $('#i_equipo').val(data[0].nombre);
                    $('#i_cantidad_equipo').val(data[0].cantidad);
                    $('#i_costo_equipo').val(formatearNumero(data[0].costo));
                    $('#i_precio_equipo').val(formatearNumero(data[0].precio));
                    $('#i_costo_total_equipo').val(formatearNumero(data[0].costo_total));
                    $('#i_precio_total_equipo').val(formatearNumero(data[0].precio_total));
                    $('#i_observaciones_equipo').val(data[0].observaciones);

                    if(data[0].prorratear == 1)
                    {
                        $('#ch_prorratear_equipo').prop('checked',true);
                    }else{
                        $('#ch_prorratear_equipo').prop('checked',false);
                    }

                    if(data[0].tipo_pago == 1)
                    {
                        $('#radio_equipo1').prop('checked',true);
                    }else{
                        $('#radio_equipo2').prop('checked',true);
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'php/cotizaciones_equipos_eliminar.php',
                        dataType:"json", 
                        data:  {'idEquipo':idEquipo},
                        success: function(data) {
                    
                            if(data != 0 ){
                                buscarEquipo(idCotizacion);
                                actualizaCostoTotalElementos(idCotizacion);
                            }
                        },
                        error: function (xhr) {
                            console.log('php/cotizaciones_equipos_eliminar.php --> '+JSON.stringify(xhr));
                            mandarMensaje('* No se encontró información al eliminar equipo');
                        }
                    });

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_equipos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar equipo para editar');
                }
            });
        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY 
        $(document).on('click','.b_eliminar_equipo',function(){

           var idEquipo=$(this).attr('alt');
           mandarMensajeConfimacion('Se eliminara el equipo de forma permanente, ¿Deseas continuar?',idEquipo,'equipo');

        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY                 
        $(document).on('click','#b_equipo',function(){  

            var idEquipo=$(this).attr('alt');
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_equipos_eliminar.php',
                dataType:"json", 
                data:  {'idEquipo':idEquipo},
                success: function(data) {
                    if(data == 0 ){
                        mandarMensaje('Error al eliminar equipo');
                    }else{
                        mandarMensaje('Se elimino el equipo');
                        buscarEquipo(idCotizacion);
                        actualizaCostoTotalElementos(idCotizacion);
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_equipos_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al eliminar equipo');
                }
            });
        });

        //--> cada que se hace un cambio en campos se recalcula el costo total
        $('#i_costo_equipo,#i_cantidad_equipo,#i_precio_equipo').change(function(){
            calculaCostoTotalEquipo();
        });

        function guardarEquipo(){
            calculaCostoTotalEquipo();   //--> se calcula el costo total unitario para guardarlo en cada registro que se inserte
            var datos = Array();

            datos = {
                'nombre': $('#i_equipo').val(),
                'cantidad': $('#i_cantidad_equipo').val(),
                'tipo_pago': $('input[name=radio_equipo]:checked').val(),
                'costo': quitaComa($('#i_costo_equipo').val()),
                'precio': quitaComa($('#i_precio_equipo').val()),
                'costoTotal': quitaComa($('#i_costo_total_equipo').val()),
                'precioTotal': quitaComa($('#i_precio_total_equipo').val()),
                'observaciones': $('#i_observaciones_equipo').val(),
                'prorratear': $('#ch_prorratear_equipo').is(':checked') ? 1 : 0,
                'idCotizacion': idCotizacion
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_equipos_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                   if(data > 0){
                        
                        buscarEquipo(idCotizacion);
                        actualizaCostoTotalElementos(idCotizacion);
                        limpiarEquipo();

                        $('#b_agrega_equipo, #b_agrega_equipo2').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al agregar equipo. Verifica e intenta nuevamente');
                        $('#b_agrega_equipo, #b_agrega_equipo2').prop('disabled',false);

                        buscarEquipo(idCotizacion);
                        limpiarEquipo();
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_equipos_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar equipo.');
                    $('#b_agrega_equipo, #b_agrega_equipo2').prop('disabled',false);
                }
            });
        }

        function buscarEquipo(idCotizacion){
            $('#div_lista_equipo').empty();
            $('#dato_total_equipo').text('');
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_equipos_buscar.php',
                dataType:"json", 
                data:  {'idCotizacion':idCotizacion},
                success: function(data) {
                    //console.log('buscarEquipo: '+JSON.stringify(data));
                    if(data.length > 0)
                    {
                        var costoTotalEquipo=0;
                        var precioTotalEquipo=0;

                        //-->crea inicio de la tabla
                        var html='<table class="tablon"  id="ul_lista_equipo">\
                                    <thead>\
                                        <tr class="renglon">\
                                        <th scope="col"></th>\
                                        <th scope="col">Equipo</th>\
                                        <th scope="col">Cantidad</th>\
                                        <th scope="col">Tipo Pago</th>\
                                        <th scope="col">Costo Unitario</th>\
                                        <th scope="col">Costo Total</th>\
                                        <th scope="col">Precio Unitario</th>\
                                        <th scope="col">Precio Total</th>\
                                        <th scope="col">Observaciones</th>\
                                        </tr>\
                                    </thead>\
                                    <tbody>';

                        for(var i=0;data.length>i;i++){
                            //-->llena la tabla con renglones de registros
                            if(data[i].tipo_pago == 1)
                            {
                                var tipo_pago='Pago Mensual';
                            }else{
                                var tipo_pago='Pago Único';
                            }

                            if(equipoP == 1)
                            {
                                if(data[i].estatus == 2)
                                {
                                    var b_disabled='disabled';
                                }else{
                                    var b_disabled='';
                                }
                            }else{
                                var b_disabled='disabled';
                            }

                            if(data[i].prorratear == 1)
                            {
                                var costo = 0;
                                var precio = 0;
                                var costoTotal = 0;
                                var precioTotal = 0;
                                var costoTotalAlt = 0;
                                var precioTotalAlt = 0;
                            }else{
                                var costo = formatearNumero(data[i].costo);
                                var precio = formatearNumero(data[i].precio);
                                var costoTotal = formatearNumero(data[i].costo_total);
                                var precioTotal = formatearNumero(data[i].precio_total);
                                var costoTotalAlt = data[i].costo_total;
                                var precioTotalAlt = data[i].precio_total;
                            }
        
                                html += '<tr class="renglon_equipo">';
                                html += '<td>\
                                            <button type="button" class="btn btn-secondary btn-sm b_eliminar_equipo eliminar" alt="'+data[i].id+'" '+b_disabled+'>\
                                                <i class="fa fa-times" aria-hidden="true"></i>\
                                            </button>\
                                            <button type="button" class="btn btn-warning btn-sm b_editar_equipo editar" alt="'+data[i].id+'" '+b_disabled+' style="float:right;">\
                                                <i class="fa fa-pencil" aria-hidden="true"></i>\
                                            </button></td>';
                                html += '<td data-label="Equipo">' + data[i].nombre+ '</td>';
                                html += '<td data-label="Cantidad">' + data[i].cantidad+ '</td>';
                                html += '<td data-label="Tipo Pago">' + tipo_pago + '</td>';
                                html += '<td data-label="Costo Unitario">$'+ costo +'</td>';
                                html += '<td data-label="Costo Total">$'+ costoTotal +'</td>';
                                html += '<td data-label="Precio Unitario">$' + precio + '</td>';
                                html += '<td data-label="Precio Total">$'+ precioTotal +'</td>';
                                html += '<td data-label="Observaciones">'+ data[i].observaciones +'</td>';
                                html += '</tr>';

                            costoTotalEquipo=costoTotalEquipo+parseFloat(costoTotalAlt);   //-->suma los costos totales de los equipos
                            precioTotalEquipo=precioTotalEquipo+parseFloat(precioTotalAlt);  //-->suma los precios totales de los equipos
                        }   

                        //-->crea fin de la tabla
                        html += '</tbody></table>';

                        $('#div_lista_equipo').append(html);   //-->agrega la tabla creada al div

                        $('#c_costo_total_equipo').text('Costo Total: $'+formatearNumero(costoTotalEquipo));
                        $('#c_precio_total_equipo').text('Precio Total: $'+formatearNumero(precioTotalEquipo));

                        $('#dato_total_equipo').text(countEquipo()); 

                        calculaSumas(idCotizacion);
                    }else{
                        var costoTotalEquipo=0;
                        var precioTotalEquipo=0;

                        $('#c_costo_total_equipo').text('Costo Total: $'+formatearNumero(costoTotalEquipo));
                        $('#c_precio_total_equipo').text('Precio Total: $'+formatearNumero(precioTotalEquipo));

                        calculaSumas(idCotizacion);
                    }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_equipos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar equipos.');
                }
            });
        }

        function countEquipo(){    //-->cuenta los equipos 
            var numEquipo=0;
            $('#ul_lista_equipo tbody tr').each(function(){
                numEquipo=numEquipo + parseInt($(this).children('td:eq(2)').text());
            });

            return numEquipo;
        }

        function calculaCostoTotalEquipo(){     //-->calcula el costo total de los elementos a insertar
            var costoTotal=0;
            var precioTotal=0;

            if($('#i_costo_equipo').val() != ''){
                var sueldo=quitaComa($('#i_costo_equipo').val());
            }else{
                var sueldo=0;
            }

            if($('#i_precio_equipo').val() != ''){
                var precio=quitaComa($('#i_precio_equipo').val());
            }else{
                var precio=0;
            }

            if($('#i_cantidad_equipo').val() != ''){
                var cantidad=$('#i_cantidad_equipo').val();
            }else{
                var cantidad=0;
            }

            costoTotal=parseFloat(sueldo);
            precioTotal=parseFloat(precio);

            $('#i_costo_total_equipo').val(formatearNumero(costoTotal*parseInt(cantidad)));
            $('#i_precio_total_equipo').val(formatearNumero(precioTotal*parseInt(cantidad)));
            
        }

        function limpiarEquipo(){
            $("#form_equipo").find('input').not(':radio').val('');
            $('#ch_prorratear_equipo').prop('checked',false);
        }
        /**************Fin funciones equipo***************/

        /**************Inicio funciones elementos***************/
        $('#b_agrega_elemento, #b_agrega_elemento2').click(function(){
            $('#b_agrega_elemento, #b_agrega_elemento2').prop('disabled',true);

            if ($('#form_elemento').validationEngine('validate')){
                if(parseFloat(quitaComa($('#i_cantidad_elemento').val())) > 0){ 
                    //--> warning de que el precio es menor al costo
                    if(parseFloat(quitaComa($('#i_precio_elemento').val())) < parseFloat(quitaComa($('#i_costo_elemento').val()))){
                        $('#b_agrega_elemento, #b_agrega_elemento2').prop('disabled',false);
                        mandarMensajeConfimacion('El precio es menor al costo, ¿Deseas continuar?',0,'elemento_n');
                    }else{
                        guardarElementos();
                    }                
                }else{
                    mandarMensaje('La cantidad debe ser mayo a 0');
                    $('#b_agrega_elemento, #b_agrega_elemento2').prop('disabled',false);
                }
            }else{
                $('#b_agrega_elemento, #b_agrega_elemento2').prop('disabled',false);
            }
        });

        //-->continua y si agrega el elemento aunque el precio sea menor al costo
        $(document).on('click','#b_elemento_n',function(){  
            guardarElementos();
        });

        //--> Toma el id, elimina el registro de la tabla. Y toma los datos del renglon para subirlos a los campos a editar y despues guardar.
        $(document).on('click','.b_editar_elemento',function(){
            var idElemento=$(this).attr('alt');
            
            buscarUniformes(idElemento);

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_elementos_buscar_id.php',
                dataType:"json", 
                data:  {'idElemento':idElemento},
                success: function(data) {

                    if(data[0].id_cuota_obrero > 0)
                    {
                        muestraSelectSalariosRazonSocial('s_salario_diario',data[0].id_razon_social,data[0].id_cuota_obrero);
                        $('#i_razon_social_salario').val(data[0].razon_social).attr('alt',data[0].id_razon_social);
                    }else{
                        $('#i_razon_social_salario').val(data[0].razon_social_capturada).attr('alt',data[0].id_razon_social_capturada);
                    }

                    $('#s_puestos').val(data[0].id_salario).prop('disabled',false);
                    $('#s_puestos').select2({placeholder: $(this).data('elemento')});
                    $('#i_cantidad_elemento').val(data[0].cantidad);
                    $('#i_sueldo_elemento').val(formatearNumero(data[0].sueldo));
                    $('#i_precio_elemento').val(formatearNumero(data[0].precio));
                    $('#i_costo_elemento').val(formatearNumero(data[0].costo));
                    $('#i_costo_total_elemento').val(formatearNumero(data[0].costo_total));
                    $('#i_precio_total_elemento').val(formatearNumero(data[0].precio_total));
                    $('#i_otros_elemento').val(formatearNumero(data[0].otros));
                    $('#i_vacaciones').val(formatearNumero(data[0].vacaciones));
                    $('#i_aguinaldo').val(formatearNumero(data[0].aguinaldo));
                    $('#i_festivo').val(formatearNumero(data[0].festivo));
                    $('#i_dia_31').val(formatearNumero(data[0].dia_31));
                    $('#i_costo_administrativo').val(formatearNumero(data[0].administrativo));
                    $('#i_infonavit').val(formatearNumero(data[0].infonavit));
                    $('#i_imss').val(formatearNumero(data[0].imss));
                    $('#i_tiempo_elemento').val(formatearNumero(data[0].tiempo_extra));
                    $('#i_bono_elemento').val(formatearNumero(data[0].bono));
                    $('#i_observaciones_elemento').val(data[0].observaciones);
                    $('#s_salario_diario').prop('disabled',false);
                                        
                    $('#i_porcentaje_dispersion').val(formatearNumero(data[0].dispersion));

                    $('#i_salario_diario').val(data[0].salario);
                
                    //-->NJES February/05/2021 el porcentaje dispersion se sugiere del puesto, pero se puede editar
                    //porcentajeDispersion = data[0].porcentaje_dispersion;
                    $('#i_porcentaje_dispersion_captura').val(data[0].porcentaje_dispersion);
                    
                    $.ajax({
                        type: 'POST',
                        url: 'php/cotizaciones_elementos_eliminar.php', 
                        data:  {'idElemento':idElemento},
                        success: function(data) {
                            if(data != 0 ){
                                actualizaCostoTotalElementos(idCotizacion);
                            }
                        },
                        error: function (xhr) {
                            console.log('php/cotizaciones_elementos_eliminar.php --> '+JSON.stringify(xhr));
                            mandarMensaje('* No se encontró información al eliminar elementos');
                        }
                    });

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_elementos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar elementos para editar');
                }
            });
        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY 
        $(document).on('click','.b_eliminar_elemento',function(){
            var idElemento=$(this).attr('alt');
            mandarMensajeConfimacion('Se eliminara el elemento de forma permanente, ¿Deseas continuar?',idElemento,'elemento');
        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY                 
        $(document).on('click','#b_elemento',function(){  

            var idElemento=$(this).attr('alt');
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_elementos_eliminar.php',
                data:  {'idElemento':idElemento},
                success: function(data) {
                    if(data == 0 ){
                        mandarMensaje('Error al eliminar elemento');
                    }else{
                        mandarMensaje('Se elimino el elemento');
                        actualizaCostoTotalElementos(idCotizacion);
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_elementos_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al eliminar elementos');
                }
            });
        });

        //--> cada que se hace un cambio en campos se recalcula el costo total
        $('#i_sueldo_elemento, #i_costo_elemento, #i_bono_elemento, #i_tiempo_elemento, #i_otros_elemento, #i_cantidad_elemento,#i_precio_elemento,#i_vacaciones,#i_aguinaldo,#i_festivo,#i_costo_administrativo,#i_infonavit,#i_imss,#i_infonavit,#i_imss,#i_porcentaje_dispersion_captura').change(function(){                                                
            calculaCostoTotalUnitarioElementos();
            calculaCostoTotalElementos();
            calculaPrecioTotalElementos();
        });

        function guardarElementos(){   //-->se calcula el costo total unitario para guardarlo en cada registro que se inserte
            calculaCostoTotalUnitarioElementos();
            calculaCostoTotalElementos();
            calculaPrecioTotalElementos();

            var datos = Array();

            datos = {
                'id_salario':$('#s_puestos').val(),
                'cantidad': quitaComa($('#i_cantidad_elemento').val()),
                'sueldo':quitaComa($('#i_sueldo_elemento').val()),
                'precio':quitaComa($('#i_precio_elemento').val()),
                'costo':quitaComa($('#i_costo_elemento').val()),
                'costo_total':quitaComa($('#i_costo_total_elemento').val()),
                'precio_total':quitaComa($('#i_precio_total_elemento').val()),
                'bono':quitaComa($('#i_bono_elemento').val()),
                'tiempo':quitaComa($('#i_tiempo_elemento').val()),
                'otros':quitaComa($('#i_otros_elemento').val()),
                'vacaciones':quitaComa($('#i_vacaciones').val()),
                'aguinaldo':quitaComa($('#i_aguinaldo').val()),
                'festivo':quitaComa($('#i_festivo').val()),
                'dia31':quitaComa($('#i_dia_31').val()),
                'costo_administrativo':quitaComa($('#i_costo_administrativo').val()),
                'infonavit':quitaComa($('#i_infonavit').val()),
                'imss':quitaComa($('#i_imss').val()), 
                'observaciones':$('#i_observaciones_elemento').val(),
                'idCotizacion': idCotizacion,
                'uniformes':obtieneUniformes(),
                'idCuotaObrero':$('#s_salario_diario').val(),
                'salario' : quitaComa($('#i_salario_diario').val()),
                'id_razon_social' : $('#i_razon_social_salario').attr('alt'),
                'porcentaje_dispersion' : quitaComa($('#i_porcentaje_dispersion_captura').val())
            };

            //alert(JSON.stringify(datos));

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_elementos_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                    //console.log(data);
                   if(data > 0){
                        $('.renglon_uniforme_lista').remove();
                        actualizaCostoTotalElementos(idCotizacion);
                        limpiarElementos();

                        $('#b_agrega_elemento, #b_agrega_elemento2').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al agregar algun elemento. Verifica e intenta nuevamente');
                        $('#b_agrega_elemento, #b_agrega_elemento2').prop('disabled',false);

                        actualizaCostoTotalElementos(idCotizacion);
                        limpiarElementos();
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_elementos_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar elementos.');
                    $('#b_agrega_elemento, #b_agrega_elemento2').prop('disabled',false);
                }
            });
        }

        function buscarElementos(idCotizacion){

            $('#div_lista_elemento').empty();
            $('#dato_total_elementos').text('');
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_elementos_buscar.php',
                dataType:"json", 
                data:  {'idCotizacion':idCotizacion},
                success: function(data) {
                    //console.log('buscarElementos: '+JSON.stringify(data));
                    if(data.length > 0)
                    {
                        var costoTotalElemento=0;
                        var precioTotalElemento=0;

                        //-->crea inicio de la tabla
                        var html='<table class="tablon table-striped"  id="ul_lista_elemento">\
                                <thead>\
                                    <tr class="renglon">\
                                    <th scope="col" width="80px;"></th>\
                                    <th scope="col" width="150px;">Elemento</th>\
                                    <th scope="col" width="70px;">Cantidad</th>\
                                    <th scope="col" width="70px;">Sueldo</th>\
                                    <th scope="col" width="70px;">Bono</th>\
                                    <th scope="col" width="70px;">Tiempo extra</th>\
                                    <th scope="col" width="70px;">Otros</th>\
                                    <th scope="col" width="75px;">Vacaciones</th>\
                                    <th scope="col" width="70px;">Aguinaldo</th>\
                                    <th scope="col" width="70px;">Festivo</th>\
                                    <th scope="col" width="70px;">Día 31</th>\
                                    <th scope="col" width="70px;">Costo Admin</th>\
                                    <th scope="col" width="70px;">Infonavit</th>\
                                    <th scope="col" width="70px;">Imss</th>\
                                    <th scope="col" width="70px;">% Dispersión</th>\
                                    <th scope="col" width="70px;">Uniformes</th>\
                                    <th scope="col" width="70px;">Costo U</th>\
                                    <th scope="col" width="70px;">Costo T</th>\
                                    <th scope="col" width="70px;">Precio U</th>\
                                    <th scope="col" width="70px;">Precio T</th>\
                                    <th scope="col" width="200px;">Observaciones</th>\
                                    </tr>\
                                </thead>\
                                <tbody>';

                        for(var i=0;data.length>i;i++){
                            //-->llena la tabla con renglones de registros
                            if(elementosP == 1)
                            {
                                if(data[i].estatus == 2){
                                    var b_disabled='disabled';
                                }else{
                                    var b_disabled='';
                                }
                            }else{
                                var b_disabled='disabled';
                            }
        
                            html += '<tr class="renglon_elemento">';
                            html += '<td>\
                                        <button type="button" class="btn btn-secondary btn-sm b_eliminar_elemento eliminar" alt="'+data[i].id+'" '+b_disabled+'>\
                                            <i class="fa fa-times" aria-hidden="true"></i>\
                                        </button>\
                                        <button type="button" class="btn btn-warning btn-sm b_editar_elemento editar" alt="'+data[i].id+'" '+b_disabled+' style="float:right;">\
                                            <i class="fa fa-pencil" aria-hidden="true"></i>\
                                        </button></td>';
                            html += '<td data-label="Elemento">' + data[i].puesto+ '</td>';
                            html += '<td data-label="Cantidad">' + data[i].cantidad+ '</td>';
                            html += '<td data-label="Sueldo">' + formatearNumero(data[i].sueldo) + '</td>';
                            html += '<td data-label="Bono">' + formatearNumero(data[i].bono) + '</td>';
                            html += '<td data-label="Tiempo Extra">' + formatearNumero(data[i].tiempo_extra) + '</td>';
                            html += '<td data-label="Otros">' + formatearNumero(data[i].otros) + '</td>';
                            html += '<td data-label="Vacaciones">' + formatearNumero(data[i].vacaciones) + '</td>';
                            html += '<td data-label="Aguinaldo">' + formatearNumero(data[i].aguinaldo) + '</td>';
                            html += '<td data-label="Festivo">' + formatearNumero(data[i].festivo) + '</td>';
                            html += '<td data-label="Día 31">' + formatearNumero(data[i].dia_31) + '</td>';
                            html += '<td data-label="Costo Administrativo">' + formatearNumero(data[i].administrativo) + '</td>';
                            html += '<td data-label="Infonavit">' + formatearNumero(data[i].infonavit) + '</td>';
                            html += '<td data-label="Imss">' + formatearNumero(data[i].imss) + '</td>';
                            html += '<td data-label="% Dispersión">' + formatearNumero(data[i].dispersion)+ '</td>';
                            html += '<td data-label="Uniformes">' + formatearNumero(data[i].uniformes) + '</td>';
                            html += '<td data-label="Costo Unitario">' + formatearNumero(data[i].costo) + '</td>';
                            html += '<td data-label="Costo Total">' + formatearNumero(data[i].costo_total) + '</td>';
                            html += '<td data-label="Precio Unitario">' + formatearNumero(data[i].precio) + '</td>';
                            html += '<td data-label="Costo Total">' + formatearNumero(data[i].precio_total) + '</td>';
                            html += '<td data-label="Observaciones">' + data[i].observaciones + '</td>';
                            html += '</tr>';

                            costoTotalElemento=costoTotalElemento+parseFloat(data[i].costo_total);   ///suma los costos totales de los elementos
                            precioTotalElemento=precioTotalElemento+parseFloat(data[i].precio_total);  //-->suma los precios totales de los elementos
                        }   

                        //-->crea fin de la tabla
                        html += '</tbody></table>';

                        $('#div_lista_elemento').append(html);
                    
                        $('#c_costo_total_elemento').text('Costo Total: $'+formatearNumero(costoTotalElemento));
                        
                        $('#c_precio_total_elemento').text('Precio Total: $'+formatearNumero(precioTotalElemento));
                    
                        $('#dato_total_elementos').text(countElementos()); 

                        calculaSumas(idCotizacion);
                    }else{
                        var costoTotalElemento=0;
                        var precioTotalElemento=0;

                        $('#c_costo_total_elemento').text('Costo Total: $'+formatearNumero(costoTotalElemento));
                        
                        $('#c_precio_total_elemento').text('Precio Total: $'+formatearNumero(precioTotalElemento));
                        
                        calculaSumas(idCotizacion);
                    }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_elementos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar elementos.');
                }
            });
        }

        function actualizaCostoTotalElementos(idCotizacion){
            //dividir costo total equipos prorrateo entre 12 y entre el numero de elementos y el 
            //resultado sumarlo al total de cada elemento

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_elementos_guardar_prorrateo.php',  
                data: {'idCotizacion':idCotizacion},
                success: function(data){
                    //console.log('actualizaCostoTotalElementos: '+data);
                    
                    buscarElementos(idCotizacion);
                    buscaEquipoProrrateo(idCotizacion);
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_elementos_guardar_prorrateo.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar prorrateo');
                }
            });
        }

        function obtieneUniformes(){
            var j = 0;
			var datos = [];
			
			$("#t_lista_uniformes .renglon_uniforme_lista").each(function() {//recorre los renglones de tabla t_proceso
				
                j++;

                var id_uniforme = $(this).attr('alt');
                var cantidad = $(this).children('td:eq(0)').text(); 
                var costo_unitario = quitaComa($(this).children('td:eq(3)').text()); 
                var costo_total = quitaComa($(this).children('td:eq(4)').text()); 
                var costo_mensual = quitaComa($(this).children('td:eq(5)').text()); 

                datos[j] = {
                    'id_uniforme':id_uniforme,
                    'cantidad':cantidad,
                    'costo_unitario':costo_unitario,
                    'costo_total':costo_total,
                    'costo_mensual':costo_mensual
                };

			});
			
			datos[0] = j;
			
			return datos;
        }

        function buscarUniformes(idElemento){
            $('.renglon_uniforme_lista').remove();

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_elementos_uniformes_buscar.php',
                dataType:"json", 
                data:  {'idElemento':idElemento},
                success: function(data) {
                    if(data.length > 0)
                    {
                        for(var i=0;data.length>i;i++){
                            var html='<tr class="renglon_uniforme_lista" alt="'+data[i].id_uniforme+'">';
                                html += '<td data-label="Cantidad">' + data[i].cantidad + '</td>';
                                html += '<td data-label="Nombre">' + data[i].nombre + '</td>';
                                html += '<td data-label="Descripción">' + data[i].descripcion + '</td>';
                                html += '<td data-label="Costo Unico">' + formatearNumero(data[i].costo) + '</td>';
                                html += '<td data-label="Costo Total">' + formatearNumero(data[i].costo_total) + '</td>';
                                html += '<td data-label="Costo Mensual">' + formatearNumero(data[i].costo_mensual) + '</td>';
                                html += '<td><button type="button" class="btn btn-secondary btn-sm b_eliminar_uniforme eliminar" alt="'+data[i].id+'">\
                                                <i class="fa fa-times" aria-hidden="true"></i>\
                                            </button></td>';
                                html += '</tr>';

                            $('#t_lista_uniformes tbody').append(html);  
                        } 

                        calculaCostoTotalUniforme(); 
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_elementos_uniformes_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar uniformes.');
                }
            });
        }

        function countElementos(){    ///cuenta los elementos 
            var numElementos=0;
            $('#ul_lista_elemento tbody tr').each(function(){
                numElementos=numElementos + parseInt($(this).children('td:eq(2)').text());
            });

            return numElementos;
        }

        function calculaCostoTotalUniforme(){
            var costoTotal=0;
            $('#t_lista_uniformes .renglon_uniforme_lista').each(function(){
                //costoTotal = costoTotal + (parseInt($(this).children('td:eq(0)').text()) * parseFloat(quitaComa($(this).children('td:eq(5)').text())));
                costoTotal = costoTotal + parseFloat(quitaComa($(this).children('td:eq(5)').text()));
            });

            $('#i_costo_uniforme').val(formatearNumero(costoTotal));

            calculaCostoTotalUnitarioElementos();
            calculaCostoTotalElementos();
            calculaPrecioTotalElementos();
        }

        function calculaCostoTotalUnitarioElementos(){     ///calcula el costo total de cada elemento de manera unitaria
            var costoTotal=0;

            if($('#i_sueldo_elemento').val() != ''){
                var sueldo=quitaComa($('#i_sueldo_elemento').val());
            }else{
                var sueldo=0;
            }

            if($('#i_bono_elemento').val() != ''){
                var bono=quitaComa($('#i_bono_elemento').val());
            }else{
                var bono=0;
            }

            if($('#i_tiempo_elemento').val() != ''){
                var tiempo=quitaComa($('#i_tiempo_elemento').val());
            }else{
                var tiempo=0;
            }

            if($('#i_otros_elemento').val() != ''){
                var otros=quitaComa($('#i_otros_elemento').val());
            }else{
                var otros=0;
            }

            if($('#i_vacaciones').val() != ''){
                var vacaciones=quitaComa($('#i_vacaciones').val());
            }else{
                var vacaciones=0;
            }

            if($('#i_aguinaldo').val() != ''){
                var aguinaldo=quitaComa($('#i_aguinaldo').val());
            }else{
                var aguinaldo=0;
            }

            if($('#i_festivo').val() != ''){
                var festivo=quitaComa($('#i_festivo').val());
            }else{
                var festivo=0;
            }
            
            if($('#i_dia_31').val() != ''){
                var dia_31=quitaComa($('#i_dia_31').val());
            }else{
                var dia_31=0;
            }

            if($('#i_costo_administrativo').val() != ''){
                var administrativo=quitaComa($('#i_costo_administrativo').val());
            }else{
                var administrativo=0;
            }

            if($('#i_infonavit').val() != ''){
                var infonavit=quitaComa($('#i_infonavit').val());
            }else{
                var infonavit=0;
            }

            if($('#i_imss').val() != ''){
                var imss=quitaComa($('#i_imss').val());
            }else{
                var imss=0;
            } 

            if($('#i_costo_uniforme').val() != ''){
                var uniforme=quitaComa($('#i_costo_uniforme').val());
            }else{
                var uniforme=0;
            }

            if($('#dato_total_elementos').text() != ''){
                var numE=$('#dato_total_elementos').text();
            }else{
                var numE=0;
            }
            
            if($('#i_cantidad_elemento').val() != ''){
                var cantidad=$('#i_cantidad_elemento').val();
            }else{
                var cantidad=1;
            }

            if($('#i_prorrateado').val() != ''){
                var total_prorrateo = (quitaComa($('#i_prorrateado').val())/12)/(parseFloat(quitaComa(cantidad))+parseInt(numE));
            }else{
                var total_prorrateo = 0;
            }

            if($('#i_salario_diario').val() != '')
                var salario = quitaComa($('#i_salario_diario').val());
            else
                var salario = 0;

            //console.log(' salario='+salario);
            if($('#i_porcentaje_dispersion_captura').val() != '')
                var por_dispersion = quitaComa($('#i_porcentaje_dispersion_captura').val());
            else
                var por_dispersion = 0;

            costoTotal=parseFloat(sueldo)+parseFloat(bono)+parseFloat(tiempo)+parseFloat(otros)+parseFloat(vacaciones)+parseFloat(aguinaldo)+parseFloat(festivo)+parseFloat(dia_31)+parseFloat(administrativo)+parseFloat(infonavit)+parseFloat(imss)+parseFloat(uniforme);
            var costoTotalNomina=((parseFloat(por_dispersion)*costoTotal)/100)+parseFloat(total_prorrateo)+parseFloat(salario);
            $('#i_porcentaje_dispersion').val(formatearNumero(costoTotalNomina));
            
            $('#i_costo_elemento').val(formatearNumero(costoTotal+parseFloat(costoTotalNomina)));
            
        }

        function calculaCostoTotalElementos(){     ///calcula el costo total de cada elemento de manera unitaria
            var costoTotal=0;

            if($('#i_sueldo_elemento').val() != ''){
                var sueldo=quitaComa($('#i_sueldo_elemento').val());
            }else{
                var sueldo=0;
            }

            if($('#i_bono_elemento').val() != ''){
                var bono=quitaComa($('#i_bono_elemento').val());
            }else{
                var bono=0;
            }

            if($('#i_tiempo_elemento').val() != ''){
                var tiempo=quitaComa($('#i_tiempo_elemento').val());
            }else{
                var tiempo=0;
            }

            if($('#i_otros_elemento').val() != ''){
                var otros=quitaComa($('#i_otros_elemento').val());
            }else{
                var otros=0;
            }

            if($('#i_vacaciones').val() != ''){
                var vacaciones=quitaComa($('#i_vacaciones').val());
            }else{
                var vacaciones=0;
            }

            if($('#i_aguinaldo').val() != ''){
                var aguinaldo=quitaComa($('#i_aguinaldo').val());
            }else{
                var aguinaldo=0;
            }

            if($('#i_festivo').val() != ''){
                var festivo=quitaComa($('#i_festivo').val());
            }else{
                var festivo=0;
            }
            
            if($('#i_dia_31').val() != ''){
                var dia_31=quitaComa($('#i_dia_31').val());
            }else{
                var dia_31=0;
            }

            if($('#i_costo_administrativo').val() != ''){
                var administrativo=quitaComa($('#i_costo_administrativo').val());
            }else{
                var administrativo=0;
            }

            if($('#i_infonavit').val() != ''){
                var infonavit=quitaComa($('#i_infonavit').val());
            }else{
                var infonavit=0;
            }

            if($('#i_imss').val() != ''){
                var imss=quitaComa($('#i_imss').val());
            }else{
                var imss=0;
            }

            if($('#i_costo_uniforme').val() != ''){
                var uniforme=quitaComa($('#i_costo_uniforme').val());
            }else{
                var uniforme=0;
            } 

            if($('#i_cantidad_elemento').val() != ''){
                var cantidad=$('#i_cantidad_elemento').val();
            }else{
                var cantidad=1;
            }

            if($('#i_salario_diario').val() != '')
                var salario = quitaComa($('#i_salario_diario').val());
            else
                var salario = 0;
           
            //console.log(' salario='+salario);
            if($('#i_porcentaje_dispersion_captura').val() != '')
                var por_dispersion = quitaComa($('#i_porcentaje_dispersion_captura').val());
            else
                var por_dispersion = 0;

            costoTotal=parseFloat(sueldo)+parseFloat(bono)+parseFloat(tiempo)+parseFloat(otros)+parseFloat(vacaciones)+parseFloat(aguinaldo)+parseFloat(festivo)+parseFloat(dia_31)+parseFloat(administrativo)+parseFloat(infonavit)+parseFloat(imss)+parseFloat(uniforme)+parseFloat(salario);
            var cantTotal = costoTotal*parseFloat(quitaComa(cantidad));
            var costoTotalNomina=(parseFloat(por_dispersion)*cantTotal)/100;

            $('#i_costo_total_elemento').val(formatearNumero(cantTotal+parseFloat(costoTotalNomina)));
            
        }

        function calculaPrecioTotalElementos(){     ///calcula el costo total de cada elemento de manera unitaria
            var precioTotal=0;

            if($('#i_precio_elemento').val() != ''){
                var precio=quitaComa($('#i_precio_elemento').val());
            }else{
                var precio=0;
            }

            if($('#i_cantidad_elemento').val() != ''){
                var cantidad=$('#i_cantidad_elemento').val();
            }else{
                var cantidad=1;
            }

            precioTotal=parseFloat(precio);
           
            $('#i_precio_total_elemento').val(formatearNumero(parseFloat(precioTotal)*parseFloat(quitaComa(cantidad))));
            
        }

        function limpiarElementos(){
            $("#form_elemento input").val('');
            $('#s_puestos').val('').prop('disabled',false);
            $('#s_puestos').select2({placeholder: 'Selecciona'});
            $('#s_salario_diario').val('').prop('disabled',true);
            $('#s_salario_diario').select2({placeholder: 'Selecciona'});
            $('#i_razon_social_salario').val('').attr('alt','');
            $('#i_salario_diario').val('');
            $('#forma_uniformes input').val('');
            $('#i_costo_uniforme').val('');
            $('.renglon_uniforme_lista').remove();
        }

        $('#s_puestos').change(function(){
            
            var idSalario=$('#s_puestos').val();
            
            $.ajax({
                type: 'POST',
                url: 'php/salarios_buscar_id.php',
                dataType:"json", 
                data:  {'id' : idSalario},
                success: function(data) {
                    if(data.length > 0){
                        $('#i_sueldo_elemento').val(formatearNumero(data[0].sueldo_mensual));
                        $('#i_vacaciones').val(formatearNumero((data[0].sueldo_mensual/30)*(data[0].dias_vacaciones)));
                        $('#i_festivo').val(formatearNumero(data[0].sueldo_festivo));
                        $('#i_dia_31').val(formatearNumero(data[0].sueldo_dia31));
                        $('#i_aguinaldo').val(formatearNumero(((data[0].sueldo_mensual/30.4)*15)/12));
                        
                        //--> NJES Calcular aguinaldo en cotizaciones (DEN18-2476) -- Dic/13/2019  <--//
                        //FÓRMULA DE AGUINALDOS = SUELDO MENSUAL (ENTRE) 30.4 (POR) 15 (ENTRE) 12

                        //-->NJES February/05/2021 el porcentaje dispersion se sugiere del puesto, pero se puede editar
                        //porcentajeDispersion = data[0].porcentaje_dispersion;
                        quitaComa($('#i_porcentaje_dispersion_captura').val(data[0].porcentaje_dispersion));
                        
                        muestraCostoAdministrativo(idUnidadNegocio,idSucursal);

                        calculaCostoTotalUnitarioElementos();
                        calculaCostoTotalElementos();
                        calculaPrecioTotalElementos();
                    }
                },
                error: function (xhr) {
                    console.log('php/salarios_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos del puesto');
                }
            });

        });

        $(document).on('keypress','#i_salario_diario',function (event){
            return validateDecimalKeyPressN(this, event, 2);
        });

        $(document).on('keypress','#i_sueldo_elemento,#i_porcentaje_dispersion_captura',function (event){
            return validateDecimalKeyPressN(this, event, 2);
        });

        //-->NJES Sep/29/2020
        /*$('#i_salario_diario').change(function(){
            $('#i_infonavit').val(0);
            $('#i_imss').val(0);
            
            calculaCostoTotalUnitarioElementos();
            calculaCostoTotalElementos();
            calculaPrecioTotalElementos();
        });*/

        $('#s_salario_diario').change(function(){
            //
            
            var idSalario=$('#s_salario_diario').val();
            //alert($('#s_salario_diario option:selected').attr('salario'));
            $('#i_salario_diario').val($('#s_salario_diario option:selected').attr('salario'));
            
            $.ajax({
                type: 'POST',
                url: 'php/cuotas_obrero_buscar_id.php',
                dataType:"json", 
                data:  {'id' : idSalario},
                success: function(data) {
                    if(data.length > 0){
                        var totalInfonavit = parseFloat(data[0].infonavit)+parseFloat(data[0].sar);
                        $('#i_infonavit').val(formatearNumero(totalInfonavit));
                        $('#i_imss').val(formatearNumero(data[0].imss));
                                                
                        calculaCostoTotalUnitarioElementos();
                        calculaCostoTotalElementos();
                        calculaPrecioTotalElementos();
                    }
                },
                error: function (xhr) {
                    console.log('php/cuotas_obrero_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos del puesto');
                }
            });

        });
        /**************Fin funciones elementos***************/

        /*************SECCION SERVICIO****************************************/
        $('#b_agrega_servicio, #b_agrega_servicio2').click(function(){
            $('#b_agrega_servicio, #b_agrega_servicio2').prop('disabled',true);

            if ($('#form_servicio').validationEngine('validate')){

                guardarServicio();
              
            }else{
                $('#b_agrega_servicio, #b_agrega_servicio2').prop('disabled',false);
            }
        });

        //--> continua y si agrega el elemento aunque el precio sea menor al costo
        $(document).on('click','#b_servicio_n',function(){  
            guardarServicio();
        });

        //--> Toma el id, elimina el registro de la tabla. Y toma los datos del renglon para subirlos a los campos a editar y despues guardar.
        $(document).on('click','.b_editar_servicio',function(){
            var idServicio=$(this).attr('alt');
               
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_servicios_buscar_id.php',
                dataType:"json", 
                data:  {'idServicio':idServicio},
                success: function(data) {
                    //console.log("Editar busqueda:"+data);
                    $('#i_servicio').val(data[0].nombre);
                    $('#i_cantidad_servicio').val(data[0].cantidad);
                    $('#i_costo_servicio').val(formatearNumero(data[0].costo));
                    $('#i_precio_servicio').val(formatearNumero(data[0].precio));
                    $('#i_costo_total_servicio').val(formatearNumero(data[0].costo_total));
                    $('#i_precio_total_servicio').val(formatearNumero(data[0].precio_total));
                    $('#i_observaciones_servicio').val(data[0].observaciones);

    
                    if(data[0].tipo_pago == 1)
                    {
                        $('#radio_servicio1').prop('checked',true);
                    }else{
                        $('#radio_servicio2').prop('checked',true);
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'php/cotizaciones_servicios_eliminar.php',
                        dataType:"json", 
                        data:  {'idServicio':idServicio},
                        success: function(data) {
                           
                            if(data != 0 ){
                                buscarServicio(idCotizacion);
                            }
                        },
                        error: function (xhr) {
                            console.log('php/cotizaciones_servicios_buscar_id.php --> '+JSON.stringify(xhr));
                            mandarMensaje('* No se encontró información al eliminar servicio.');
                        }
                    });

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_servicios_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar servicios para editar.');
                }
            });
        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY 
        $(document).on('click','.b_eliminar_servicio',function(){

           var idServicio=$(this).attr('alt');
           mandarMensajeConfimacion('Se eliminara el servicio de forma permanente, ¿Deseas continuar?',idServicio,'servicio');

        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY                 
        $(document).on('click','#b_servicio',function(){  

            var idServicio=$(this).attr('alt');
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_servicios_eliminar.php',
                dataType:"json", 
                data:  {'idServicio':idServicio},
                success: function(data) {
                    if(data == 0 ){
                        mandarMensaje('Error al eliminar servicio');
                    }else{
                        mandarMensaje('Se elimino el servicio');
                        buscarServicio(idCotizacion);
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_equipos_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al eliminar servicio.');
                }
            });
        });

        //--> cada que se hace un cambio en campos se recalcula el costo total
        $(document).on('change','#i_costo_servicio,#i_cantidad_servicio,#i_precio_servicio',function(){
            calculaCostoTotalServicio();
        });

        function guardarServicio(){
            calculaCostoTotalServicio();   //--> se calcula el costo total unitario para guardarlo en cada registro que se inserte
            var datos = Array();

            datos = {
                'nombre': $('#i_servicio').val(),
                'cantidad': $('#i_cantidad_servicio').val(),
                'tipo_pago': $('input[name=radio_servicio]:checked').val(),
                'costo': quitaComa($('#i_costo_servicio').val()),
                'precio': quitaComa($('#i_precio_servicio').val()),
                'costoTotal': quitaComa($('#i_costo_total_servicio').val()),
                'precioTotal': quitaComa($('#i_precio_total_servicio').val()),
                'observaciones': $('#i_observaciones_servicio').val(),
                'idCotizacion': idCotizacion
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_servicios_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                    
                   if(data > 0){
                        
                        buscarServicio(idCotizacion);
                        limpiarServicio();

                        $('#b_agrega_servicio, #b_agrega_servicio2').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al agregar servicio. Verifica e intenta nuevamente');
                        $('#b_agrega_servicio, #b_agrega_servicio2').prop('disabled',false);

                        buscarServicio(idCotizacion);
                        limpiarServicio();
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_servicios_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar servicio.');
                    $('#b_agrega_servicio, #b_agrega_servicio2').prop('disabled',false);
                }
            });
        }

        function buscarServicio(idCotizacion){
            $('#div_lista_servicio').empty();
            $('#dato_total_servicio').text('');
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_servicios_buscar.php',
                dataType:"json", 
                data:  {'idCotizacion':idCotizacion},
                success: function(data) {
                    if(data.length > 0)
                    {
                        
                        var costoTotalServicio=0;
                        var precioTotalServicio=0;

                        //-->crea inicio de la tabla
                        var html='<table class="tablon"  id="ul_lista_servicio">\
                                    <thead>\
                                        <tr class="renglon">\
                                        <th scope="col"></th>\
                                        <th scope="col">Servicio</th>\
                                        <th scope="col">Cantidad</th>\
                                        <th scope="col">Tipo Pago</th>\
                                        <th scope="col">Costo Unitario</th>\
                                        <th scope="col">Costo Total</th>\
                                        <th scope="col">Precio Unitario</th>\
                                        <th scope="col">Precio Total</th>\
                                        <th scope="col">Observaciones</th>\
                                        </tr>\
                                    </thead>\
                                    <tbody>';

                        for(var i=0;data.length>i;i++){
                            //-->llena la tabla con renglones de registros
                            if(data[i].tipo_pago == 1)
                            {
                                var tipo_pago='Pago Mensual';
                            }else{
                                var tipo_pago='Pago Único';
                            }

                            if(serviciosP == 1)
                            {
                                if(data[i].estatus == 2)
                                {
                                    var b_disabled='disabled';
                                }else{
                                    var b_disabled='';
                                }
                            }else{
                                var b_disabled='disabled';
                            }

                            
                                var costo = formatearNumero(data[i].costo);
                                var precio = formatearNumero(data[i].precio);
                                var costoTotal = formatearNumero(data[i].costo_total);
                                var precioTotal = formatearNumero(data[i].precio_total);
                            
        
                                html += '<tr class="renglon_servicio">';
                                html += '<td>\
                                            <button type="button" class="btn btn-secondary btn-sm b_eliminar_servicio eliminar" alt="'+data[i].id+'" '+b_disabled+'>\
                                                <i class="fa fa-times" aria-hidden="true"></i>\
                                            </button>\
                                            <button data-servicio="'+data[i].nombre+'" data-cantidad="'+data[i].cantidad+'" data-tipo_pago="'+data[i].tipo_pago+'" data-costo="'+data[i].costo+'" data-precio="'+data[i].precio+'" data-costoTotal="'+data[i].costo_total+'" data-precioTotal="'+data[i].precio_total+'" data-observaciones="'+data[i].observaciones+'" type="button" class="btn btn-warning btn-sm b_editar_servicio editar" alt="'+data[i].id+'" '+b_disabled+' style="float:right;">\
                                                <i class="fa fa-pencil" aria-hidden="true"></i>\
                                            </button></td>';
                                html += '<td data-label="Servicio">' + data[i].nombre+ '</td>';
                                html += '<td data-label="Cantidad">' + data[i].cantidad+ '</td>';
                                html += '<td data-label="Tipo Pago">' + tipo_pago + '</td>';
                                html += '<td data-label="Costo Unitario">$'+ costo +'</td>';
                                html += '<td data-label="Costo Total">$'+ costoTotal +'</td>';
                                html += '<td data-label="Precio Unitario">$' + precio + '</td>';
                                html += '<td data-label="Precio Total">$'+ precioTotal +'</td>';
                                html += '<td data-label="Observaciones">'+ data[i].observaciones +'</td>';
                                html += '</tr>';

                            costoTotalServicio=costoTotalServicio+parseFloat(data[i].costo_total);   //-->suma los costos totales de los equipos
                            precioTotalServicio=precioTotalServicio+parseFloat(data[i].precio_total);  //-->suma los precios totales de los equipos
                        }   

                        //-->crea fin de la tabla
                        html += '</tbody></table>';

                        $('#div_lista_servicio').append(html);   //-->agrega la tabla creada al div

                        $('#c_costo_total_servicio').text('Costo Total: $'+formatearNumero(costoTotalServicio));
                        $('#c_precio_total_servicio').text('Precio Total: $'+formatearNumero(precioTotalServicio));

                        $('#dato_total_servicio').text(countServicio()); 

                        calculaSumas(idCotizacion);
                    }else{
                        var costoTotalServicio=0;
                        var precioTotalServicio=0;

                        $('#c_costo_total_servicio').text('Costo Total: $'+formatearNumero(costoTotalServicio));
                        $('#c_precio_total_servicio').text('Precio Total: $'+formatearNumero(precioTotalServicio));

                        calculaSumas(idCotizacion);
                    }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_servicios_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar servicios.');
                }
            });
        }
        /******* Fin Busca todas las cotixzaciones mediante filtros ingresados*********/


        function countServicio(){    //-->cuenta los equipos 
            var numServicio=0;
            $('#ul_lista_servicio tbody tr').each(function(){
                numServicio=numServicio + parseInt($(this).children('td:eq(2)').text());
            });

            return numServicio;
        }

        function calculaCostoTotalServicio(){     //-->calcula el costo total de los elementos a insertar
            
            var costoTotal=0;
            var precioTotal=0;

            if($('#i_costo_servicio').val() != ''){
                var sueldo=quitaComa($('#i_costo_servicio').val());
            }else{
                var sueldo=0;
            }

            if($('#i_precio_servicio').val() != ''){
                var precio=quitaComa($('#i_precio_servicio').val());
            }else{
                var precio=0;
            }

            if($('#i_cantidad_servicio').val() != ''){
                var cantidad=$('#i_cantidad_servicio').val();
            }else{
                var cantidad=0;
            }

            costoTotal=parseFloat(sueldo);
            precioTotal=parseFloat(precio);

            $('#i_costo_total_servicio').val(formatearNumero(costoTotal*parseInt(cantidad)));
            $('#i_precio_total_servicio').val(formatearNumero(precioTotal*parseInt(cantidad)));
            
        }

        function limpiarServicio(){
            $("#form_servicio").find('input').not(':radio').val('');
        }
        /*************FIN SECCION SERVICIO************************************/


        /*************SECCION VEHICULOS****************************************/
        $('#b_agrega_vehiculo, #b_agrega_vehiculo2').click(function(){
            $('#b_agrega_vehiculo, #b_agrega_vehiculo2').prop('disabled',true);

            if ($('#form_vehiculo').validationEngine('validate')){

                guardarVehiculo();
              
            }else{
                $('#b_agrega_vehiculo, #b_agrega_vehiculo2').prop('disabled',false);
            }
        });

        //--> continua y si agrega el elemento aunque el precio sea menor al costo
        $(document).on('click','#b_vehiculo_n',function(){  
            guardarVehiculo();
        });

        //--> Toma el id, elimina el registro de la tabla. Y toma los datos del renglon para subirlos a los campos a editar y despues guardar.
        $(document).on('click','.b_editar_vehiculo',function(){
            var idVehiculo=$(this).attr('alt');
               
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_vehiculos_buscar_id.php',
                dataType:"json", 
                data:  {'idVehiculo':idVehiculo},
                success: function(data) {
                    
                    $('#i_vehiculo').val(data[0].nombre);
                    $('#i_cantidad_vehiculo').val(data[0].cantidad);
                    $('#i_costo_vehiculo').val(formatearNumero(data[0].costo));
                    $('#i_precio_vehiculo').val(formatearNumero(data[0].precio));
                    $('#i_costo_total_vehiculo').val(formatearNumero(data[0].costo_total));
                    $('#i_precio_total_vehiculo').val(formatearNumero(data[0].precio_total));
                    $('#i_observaciones_vehiculo').val(data[0].observaciones);

    
                    if(data[0].tipo_pago == 1)
                    {
                        $('#radio_vehiculo1').prop('checked',true);
                    }else{
                        $('#radio_vehiculo2').prop('checked',true);
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'php/cotizaciones_vehiculos_eliminar.php',
                        dataType:"json", 
                        data:  {'idVehiculo':idVehiculo},
                        success: function(data) {
                            
                            if(data != 0 ){
                                buscarVehiculo(idCotizacion);
                            }
                        },
                        error: function (xhr) {
                            console.log('php/cotizaciones_vehiculos_eliminar.php --> '+JSON.stringify(xhr));
                            mandarMensaje('* No se encontró información al eliminar vehiculo.');
                        }
                    });

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_vehiculos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar vehiculo para editar.');
                }
            });
        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY 
        $(document).on('click','.b_eliminar_vehiculo',function(){

           var idVehiculo=$(this).attr('alt');
           mandarMensajeConfimacion('Se eliminara el vehiculo de forma permanente, ¿Deseas continuar?',idVehiculo,'vehiculo');

        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY                 
        $(document).on('click','#b_vehiculo',function(){  

            var idVehiculo=$(this).attr('alt');
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_vehiculos_eliminar.php',
                dataType:"json", 
                data:  {'idVehiculo':idVehiculo},
                success: function(data) {
                    if(data == 0 ){
                        mandarMensaje('Error al eliminar vehiculo');
                    }else{
                        mandarMensaje('Se eliminó el vehiculo');
                        buscarVehiculo(idCotizacion);
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_vehiculos_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al eliminar vehiculo.');
                }
            });
        });

        //--> cada que se hace un cambio en campos se recalcula el costo total
        $(document).on('change','#i_costo_vehiculo,#i_cantidad_vehiculo,#i_precio_vehiculo',function(){
            calculaCostoTotalVehiculo();
        });

        function guardarVehiculo(){
            calculaCostoTotalVehiculo();   //--> se calcula el costo total unitario para guardarlo en cada registro que se inserte
            var datos = Array();

            datos = {
                'nombre': $('#i_vehiculo').val(),
                'cantidad': $('#i_cantidad_vehiculo').val(),
                'tipo_pago': $('input[name=radio_vehiculo]:checked').val(),
                'costo': quitaComa($('#i_costo_vehiculo').val()),
                'precio': quitaComa($('#i_precio_vehiculo').val()),
                'costoTotal': quitaComa($('#i_costo_total_vehiculo').val()),
                'precioTotal': quitaComa($('#i_precio_total_vehiculo').val()),
                'observaciones': $('#i_observaciones_vehiculo').val(),
                'idCotizacion': idCotizacion
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_vehiculos_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                    //console.log(data);
                   if(data > 0){
                        
                        buscarVehiculo(idCotizacion);
                        limpiarVehiculo();

                        $('#b_agrega_vehiculo, #b_agrega_vehiculo2').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al agregar vehiculo. Verifica e intenta nuevamente');
                        $('#b_agrega_vehiculo, #b_agrega_vehiculo2').prop('disabled',false);

                        buscarVehiculo(idCotizacion);
                        limpiarVehiculo();
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_vehiculos_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar vehiculo.');
                    $('#b_agrega_vehiculo, #b_agrega_vehiculo2').prop('disabled',false);
                }
            });
        }

        function buscarVehiculo(idCotizacion){
            $('#div_lista_vehiculo').empty();
            $('#dato_total_vehiculo').text('');
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_vehiculos_buscar.php',
                dataType:"json", 
                data:  {'idCotizacion':idCotizacion},
                success: function(data) {
                    
                    if(data.length > 0)
                    {
                        
                        var costoTotalVehiculo=0;
                        var precioTotalVehiculo=0;

                        //-->crea inicio de la tabla
                        var html='<table class="tablon"  id="ul_lista_vehiculo">\
                                    <thead>\
                                        <tr class="renglon">\
                                        <th scope="col"></th>\
                                        <th scope="col">Vehiculo</th>\
                                        <th scope="col">Cantidad</th>\
                                        <th scope="col">Tipo Pago</th>\
                                        <th scope="col">Costo Unitario</th>\
                                        <th scope="col">Costo Total</th>\
                                        <th scope="col">Precio Unitario</th>\
                                        <th scope="col">Precio Total</th>\
                                        <th scope="col">Observaciones</th>\
                                        </tr>\
                                    </thead>\
                                    <tbody>';

                        for(var i=0;data.length>i;i++){
                            //-->llena la tabla con renglones de registros
                            if(data[i].tipo_pago == 1)
                            {
                                var tipo_pago='Pago Mensual';
                            }else{
                                var tipo_pago='Pago Único';
                            }

                            if(vehiculosP == 1)
                            {
                                if(data[i].estatus == 2)
                                {
                                    var b_disabled='disabled';
                                }else{
                                    var b_disabled='';
                                }
                            }else{
                                var b_disabled='disabled';
                            }

                          
                            var costo = formatearNumero(data[i].costo);
                            var precio = formatearNumero(data[i].precio);
                            var costoTotal = formatearNumero(data[i].costo_total);
                            var precioTotal = formatearNumero(data[i].precio_total);
                            
        
                                html += '<tr class="renglon_vehiculo">';
                                html += '<td>\
                                            <button type="button" class="btn btn-secondary btn-sm b_eliminar_vehiculo eliminar" alt="'+data[i].id+'" '+b_disabled+'>\
                                                <i class="fa fa-times" aria-hidden="true"></i>\
                                            </button>\
                                            <button data-vehiculo="'+data[i].nombre+'" data-cantidad="'+data[i].cantidad+'" data-tipo_pago="'+data[i].tipo_pago+'" data-costo="'+data[i].costo+'" data-precio="'+data[i].precio+'" data-costoTotal="'+data[i].costo_total+'" data-precioTotal="'+data[i].precio_total+'" data-observaciones="'+data[i].observaciones+'" type="button" class="btn btn-warning btn-sm b_editar_vehiculo editar" alt="'+data[i].id+'" '+b_disabled+' style="float:right;">\
                                                <i class="fa fa-pencil" aria-hidden="true"></i>\
                                            </button></td>';
                                html += '<td data-label="Servicio">' + data[i].nombre+ '</td>';
                                html += '<td data-label="Cantidad">' + data[i].cantidad+ '</td>';
                                html += '<td data-label="Tipo Pago">' + tipo_pago + '</td>';
                                html += '<td data-label="Costo Unitario">$'+ costo +'</td>';
                                html += '<td data-label="Costo Total">$'+ costoTotal +'</td>';
                                html += '<td data-label="Precio Unitario">$' + precio + '</td>';
                                html += '<td data-label="Precio Total">$'+ precioTotal +'</td>';
                                html += '<td data-label="Observaciones">'+ data[i].observaciones +'</td>';
                                html += '</tr>';

                            costoTotalVehiculo=costoTotalVehiculo+parseFloat(data[i].costo_total);   //-->suma los costos totales de los equipos
                            precioTotalVehiculo=precioTotalVehiculo+parseFloat(data[i].precio_total);  //-->suma los precios totales de los equipos
                        }   

                        //-->crea fin de la tabla
                        html += '</tbody></table>';

                        $('#div_lista_vehiculo').append(html);   //-->agrega la tabla creada al div

                        $('#c_costo_total_vehiculo').text('Costo Total: $'+formatearNumero(costoTotalVehiculo));
                        $('#c_precio_total_vehiculo').text('Precio Total: $'+formatearNumero(precioTotalVehiculo));

                        $('#dato_total_vehiculo').text(countVehiculo()); 

                        calculaSumas(idCotizacion);
                    }else{
                        var costoTotalVehiculo=0;
                        var precioTotalVehiculo=0;

                        $('#c_costo_total_vehiculo').text('Costo Total: $'+formatearNumero(costoTotalVehiculo));
                        $('#c_precio_total_vehiculo').text('Precio Total: $'+formatearNumero(precioTotalVehiculo));

                        calculaSumas(idCotizacion);
                    }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_vehiculos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar vehiculos.');
                }
            });
        }
        /******* Fin Busca todas las cotixzaciones mediante filtros ingresados*********/


        function countVehiculo(){    //-->cuenta los equipos 
            var numVehiculo=0;
            $('#ul_lista_vehiculo tbody tr').each(function(){
                numVehiculo=numVehiculo + parseInt($(this).children('td:eq(2)').text());
            });

            return numVehiculo;
        }

        function calculaCostoTotalVehiculo(){     //-->calcula el costo total de los elementos a insertar
           
            var costoTotal=0;
            var precioTotal=0;

            if($('#i_costo_vehiculo').val() != ''){
                var sueldo=quitaComa($('#i_costo_vehiculo').val());
            }else{
                var sueldo=0;
            }

            if($('#i_precio_vehiculo').val() != ''){
                var precio=quitaComa($('#i_precio_vehiculo').val());
            }else{
                var precio=0;
            }

            if($('#i_cantidad_vehiculo').val() != ''){
                var cantidad=$('#i_cantidad_vehiculo').val();
            }else{
                var cantidad=0;
            }

            costoTotal=parseFloat(sueldo);
            precioTotal=parseFloat(precio);

            $('#i_costo_total_vehiculo').val(formatearNumero(costoTotal*parseInt(cantidad)));
            $('#i_precio_total_vehiculo').val(formatearNumero(precioTotal*parseInt(cantidad)));
            
        }

        function limpiarVehiculo(){
            $("#form_vehiculo").find('input').not(':radio').val('');
        }
        /*************FIN SECCION SERVICIO************************************/



        /****************** Funciones para secciones fin *******************/



        /***************************PERIODICIDAD*********************************/
        $('#s_periodicidad').on('change',function(){
            var valor=$(this).val();
            if( valor > 0 ){
                generaCampoDia(valor,'');
            }
        });

        $(document).on('change','#i_dia',function(){
            $(this).validationEngine('validate');
        });

        
        function generaCampoDia(periodicidad,valor){
            //-->NJES May/20/2020 cuando la periodicidad es 4 (Unico) solicitar fecha en especifico
            $('#contenedor_dia').html('').removeAttr('class');

            if(periodicidad==1){
                var html='<select class="form-control validate[required] coti" id="i_dia" name="i_dia">';
                    html+='<option value="0" disabled selected>Selecciona</option>';   
                    html+='<option value="L">Lunes</option>';
                    html+='<option value="M">Martes</option>';
                    html+='<option value="X">Miercoles</option>';
                    html+='<option value="J">Jueves</option>';
                    html+='<option value="V">Viernes</option>';
                    html+='<option value="S">Sabado</option>';
                    html+='<option value="D">Domingo</option>';
                    html+='</select>';
                $('#contenedor_dia').addClass('col-sm-12 col-md-11').append(html);  
                $('#i_dia').val(valor);
                              
            }else if( periodicidad==3){
                var html='<input type="text" id="i_dia" name="i_dia"  class="form-control validate[required,custom[integer],min[1],max[30]] coti" size="2" autocomplete="off" value="'+valor+'" >';
                $('#contenedor_dia').addClass('col-sm-6 col-md-6').append(html);
            }else if( periodicidad==2){
                var html='<select class="form-control validate[required] coti" id="i_dia" name="i_dia">';
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
                $('#contenedor_dia').addClass('col-sm-12 col-md-11').append(html);  
                $('#i_dia').val(valor);
            }else{
                var html='<input type="text" id="i_dia" name="i_dia"  class="form-control validate[required] fecha coti" readonly autocomplete="off" value="'+valor+'" >';
                $('#contenedor_dia').addClass('col-sm-11 col-md-11').append(html);
                $('.fecha').datepicker({
                    format : "yyyy-mm-dd",
                    autoclose: true,
                    language: "es",
                    todayHighlight: true
                }); 
            }
            
        }
        /***************************FIN PERIODICIDAD*****************************/

        /**************Inicio funcionalidad para calcular resumen**************/
        
        function calculaSumas(idCotizacion){
            //var costoTotalProrrateoEquipos=0;
            var costoMensualTotal=0;
            var costoMensual=0;
            var precioMensual=0;
            var inversionSecorp=0;
            var inversionCliente=0;
            var totalIngresosElementos=0;
            var totalcostosElementos=0;
            //var prorrateoEquipos=0;

            $('#dato_costo_mensual').text('');
            $('#dato_precio_mensual').text('');
            $('#dato_inversion').text('');
            $('#dato_cargo_cliente').text(''); 
            $('#dato_utilidad_anual').text('');
            $('#dato_retorno_inversion').text('');
            $('#dato_utilidad_bruta_mensual').text('');
            $('#dato_porcentaje_utilidad_final').text('');
            $('#dato_signo').text('');
            $('#dato_utilidad_elemento').text('');

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_calcular_inversion.php',  
                dataType: 'json',
                data: {'idCotizacion':idCotizacion},
                success: function(data){
            
                    for(var i=0;data.length>i;i++){
                        costoMensual=costoMensual+parseFloat(data[i].costo_mensual);
                        precioMensual=precioMensual+parseFloat(data[i].precio_mensual);
                        inversionSecorp=inversionSecorp+parseFloat(data[i].inversion_secorp);
                        inversionCliente=inversionCliente+parseFloat(data[i].inversion_cliente);

                        if(data[i].tabla == 'elementos'){
                            totalIngresosElementos=data[i].precio_mensual;
                            totalcostosElementos=data[i].costo_mensual;
                        }
                        //prorrateoEquipos=prorrateoEquipos+parseFloat(data[i].costo_pro);
                    }

                    //costoTotalProrrateoEquipos=parseFloat(prorrateoEquipos)/12;  //sumar costo total de los equipos prorrateados entre 12 meses (prorrateado/12)+costoMensual
                    //costoMensualTotal = parseFloat(costoMensual)+parseFloat(costoTotalProrrateoEquipos);
                    
                    $('#dato_costo_mensual').text(formatearNumero(costoMensual));  //(A) suma total costo mensual (y de equipos, servicios, vehiculos tipo pago mensual + suma de costo total equipos prorrateados) (A)
                    $('#dato_precio_mensual').text(formatearNumero(precioMensual));  //(B) suma total precio mensual (y de equipos, servicios, vehiculos tipo pago mensual) (B)
                    $('#dato_inversion').text(formatearNumero(inversionSecorp));  //(C) suma costo total de equipos, servicios, vehiculos tipo pago unicos (C)
                    $('#dato_cargo_cliente').text(formatearNumero(inversionCliente)); //(D) suma precio total de equipos, servisios, vehiculos tipo pago unicos (D)

                    var utilidad=(parseFloat(precioMensual)*12)-(parseFloat(costoMensual)*12)-(parseFloat(inversionSecorp)+parseFloat(inversionCliente));
                    var inversion=(parseFloat(inversionSecorp)-parseFloat(inversionCliente))/(parseFloat(precioMensual)-parseFloat(costoMensual));
                    if(parseFloat(inversion) > 0){
                        var totalInversion=inversion;
                    }else{
                        var totalInversion=0;
                    }
                    var utilidadBruta=parseFloat(precioMensual)-parseFloat(costoMensual);

                    var prorrateoMensual = parseFloat(inversionSecorp)/12;
                    var costoUnico = parseFloat(prorrateoMensual)+parseFloat(costoMensual);
                    var precio = parseFloat(precioMensual) + parseFloat(inversionCliente);

                    if(parseFloat(costoUnico) == 0)
                        var prorrateo = (parseFloat(precio)*100)/1;
                    else
                        var prorrateo = (parseFloat(precio)*100)/parseFloat(costoUnico);

                    if(parseFloat(costoUnico) == 0)
                        var porcentajeUtilidad = 0;
                    else
                        var porcentajeUtilidad = parseFloat(prorrateo)-100;

                    if(parseInt($('#dato_total_elementos').text()) > 0){
                        var numElementos = parseInt($('#dato_total_elementos').text());
                        var utilidadElemento = formatearNumero((parseFloat(totalIngresosElementos)-parseFloat(totalcostosElementos))/numElementos);
                    }else{
                        var utilidadElemento = '';
                    }
                    $('#dato_utilidad_anual').text(formatearNumero(utilidad));  //(B*12)-(A*12)-(C+D)
                    $('#dato_retorno_inversion').text(totalInversion+' meses');  //(C-D)/(B-A) = n meses (si me da - poner 0, sino poner la cantidad)
                    $('#dato_utilidad_bruta_mensual').text(formatearNumero(utilidadBruta)); //(B-A)
                    $('#dato_porcentaje_utilidad_final').text(formatearNumero(porcentajeUtilidad));
                    $('#dato_signo').text('%');
                    //$('#dato_prorrateo').text();
                    $('#dato_utilidad_elemento').text(utilidadElemento);


                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_calcular_inversion.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al calcular resumen inversión.');
                }
            });

            muestraSumaComision();
        }

        //-->suma total costo mensual (A)
        //-->suma total precio mensual (B)
        //-->suma costo total de equipos, servicios, vehiculos unicos (C)
        //-->suma precio total de equipos, servisios, vehiculos unicos (D)
        //-->(B*12)-(A*12)-(C+D)
        //-->(C-D)/(B-A) = n meses (si me da - poner 0, sino poner la cantidad)
        //-->utilidad bruta mensual //(B-A)  agregar
        // prorrateo mensual = suma gastos unicos / 12
        // costosgastos unicos = prorrateo mensual + suma gastos mensuales --- 100%
        // precio = precio mensual + precio total de equipos, servisios, vehiculos unicos
        // prorrateo = precio * 100 / costosgastos unicos
        //porcentaje de utilidad = prorrateo - 100

        /**************Fin funcionalidad para calcular resumen**************/

        function muestraSumaComision(){
           
            var costoMensualTotal=0;
            var costoMensual=0;
            var precioMensual=0;
            var inversionSecorp=0;
            var inversionCliente=0;
            var totalIngresosElementos=0;
            var totalcostosElementos=0;

            $('#dato_costo_mensual_c').text('');
            $('#dato_precio_mensual_c').text('');
            $('#dato_inversion_c').text('');
            $('#dato_cargo_cliente_c').text(''); 
            $('#dato_utilidad_anual_c').text('');
            $('#dato_retorno_inversion_c').text('');
            $('#dato_utilidad_bruta_mensual_c').text('');
            $('#dato_porcentaje_utilidad_final_c').text('');
            $('#dato_signo_c').text('');
            $('#dato_utilidad_elemento_c').text('');

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_calcular_inversion.php',  
                dataType: 'json',
                data: {'idCotizacion':idCotizacion},
                success: function(data){
            
                    for(var i=0;data.length>i;i++){
                        costoMensual=costoMensual+parseFloat(data[i].costo_mensual);
                        precioMensual=precioMensual+parseFloat(data[i].precio_mensual);
                        inversionSecorp=inversionSecorp+parseFloat(data[i].inversion_secorp);
                        inversionCliente=inversionCliente+parseFloat(data[i].inversion_cliente);

                        if(data[i].tabla == 'elementos'){
                            totalIngresosElementos=data[i].precio_mensual;
                            totalcostosElementos=data[i].costo_mensual;
                        }
                    }

                    var costoMensualTotal = parseFloat(costoMensual) + parseFloat($('#i_comision_cotizacion').val());

                    $('#dato_costo_mensual_c').text(formatearNumero(costoMensualTotal));
                    $('#dato_precio_mensual_c').text(formatearNumero(precioMensual));
                    $('#dato_inversion_c').text(formatearNumero(inversionSecorp));
                    $('#dato_cargo_cliente_c').text(formatearNumero(inversionCliente));

                    var utilidad=(parseFloat(precioMensual)*12)-(parseFloat(costoMensualTotal)*12)-(parseFloat(inversionSecorp)+parseFloat(inversionCliente));
                    var inversion=(parseFloat(inversionSecorp)-parseFloat(inversionCliente))/(parseFloat(precioMensual)-parseFloat(costoMensualTotal));
                    if(parseFloat(inversion) > 0){
                        var totalInversion=inversion;
                    }else{
                        var totalInversion=0;
                    }
                    var utilidadBruta=parseFloat(precioMensual)-parseFloat(costoMensualTotal);

                    var prorrateoMensual = parseFloat(inversionSecorp)/12;
                    var costoUnico = parseFloat(prorrateoMensual)+parseFloat(costoMensualTotal);
                    var precio = parseFloat(precioMensual) + parseFloat(inversionCliente);

                    if(parseFloat(costoUnico) == 0)
                        var prorrateo = (parseFloat(precio)*100)/1;
                    else
                        var prorrateo = (parseFloat(precio)*100)/parseFloat(costoUnico);

                    if(parseFloat(costoUnico) == 0)
                        var porcentajeUtilidad = 0;
                    else    
                        var porcentajeUtilidad = parseFloat(prorrateo)-100;

                    if(parseInt($('#dato_total_elementos_c').text()) > 0){
                        var numElementos = parseInt($('#dato_total_elementos_c').text());
                        var utilidadElemento = formatearNumero((parseFloat(totalIngresosElementos)-parseFloat(totalcostosElementos))/numElementos);
                    }else{
                        var utilidadElemento = '';
                    }
                    $('#dato_utilidad_anual_c').text(formatearNumero(utilidad));
                    $('#dato_retorno_inversion_c').text(totalInversion+' meses');
                    $('#dato_utilidad_bruta_mensual_c').text(formatearNumero(utilidadBruta));
                    $('#dato_porcentaje_utilidad_final_c').text(formatearNumero(porcentajeUtilidad));
                    $('#dato_signo_c').text('%');
                    $('#dato_utilidad_elemento_c').text(utilidadElemento);


                },
                error: function(xhr){
                    console.log('php/cotizaciones_calcular_inversion.php --> '+JSON.stringify(xhr));
                    mandarMensaje('No se encontró información al calcular comisión.');
                }
            });
        }

        /***************************IMPRIMIR*****************************/
        
        //Al momento de imprimir cotización su esatatus es impresa(2) y en proyecto el estatus es Negociación(2)
        $('#b_imprimir').click(function(){

             $('#b_imprimir').prop('disabled',true);

            if(estatusProyecto == 0 || estatusProyecto == 1){  ///cambiaremos el esatatus a Negociación(2) e imprimiremos
                
                $.ajax({
                    type: 'POST',
                    url: 'php/cotizaciones_actualizar_estatus.php',
                    dataType:"json", 
                    data:  {
                        'idCotizacion' : idCotizacion,
                        'idProyecto' : idProyecto,
                        'estatusProyecto':2
                    },
                    success: function(data) {
                       
                        if(data != 0){
                            $('#b_imprimir').prop('disabled',false);
                            
                            imprimirFormato();
                          
                        }else{
                            mandarMensaje('Error, intentalo nuevamente.');
                            $('#b_imprimir').prop('disabled',false);
                        }
                    },
                    error: function (xhr) {
                        console.log('php/cotizaciones_actualizar_estatus.php -->'+JSON.stringify(xhr));   
                        mandarMensaje('* No se encontró información al actualizar estatus.');
                        $('#b_imprimir').prop('disabled',false);
                    }
                });
            }else{   ///Solo imprimiremos
                $('#b_imprimir').prop('disabled',false);
               
                imprimirFormato();
                
            }
            
        });

        function imprimirFormato(){
            $('#b_imprimir').prop('disabled',true);

            if(idCotizacion != 0){
                $('#b_imprimir').prop('disabled',true);
                var tipo = 1;
                //var textoInicio=niveles($('#ta_texto_inicio').val().replace(/\n/g, '<br />'));
                //var textoFin=niveles($('#ta_texto_fin').val().replace(/\n/g, '<br />'));

                var datos = {
                    'path':'formato_cotizacion',
                    'idRegistro':idCotizacion,
                    'nombreArchivo':'cotizacion',
                    'tipo':tipo
                };
                let objJsonStr = JSON.stringify(datos);
                let datosJ = datosUrl(objJsonStr);

                window.open("php/convierte_pdf.php?D="+datosJ,'_new');
                buscaCotizacion(idCotizacion);
            }else{
                mandarMensaje('Debes seleccionar una cotización, primero');
            }
        }
        /***************************FIN IMPRIMI*****************************/

        /****************Cerrar cotizacion inicio****************/
        //-->Al momento de aprobar cotización su estatus es impresa(2) y en proyecto el estatus es Aprobada(4)
        $('#b_aprobar_cotizacion').click(function(){
            //-->asi me aseguro de que se ejecute primero el proceso de generar y guardar pdf y ya hecho hago el proceso de actualizacion y envio de correo
            enviarFormato();
            $('#i_fecha_inicio_ap').val($('#i_inicio_facturacion').val()).prop('disabled',true);
            $('#dialog_aprobacion').modal('show');
        });

        function enviarFormato(){
            var tipo = 2;
            //var textoInicio = niveles($('#ta_texto_inicio').val().replace(/\n/g, '<br />'));
            //var textoFin = niveles($('#ta_texto_fin').val().replace(/\n/g, '<br />'));

            var datos = {
                'path':'formato_cotizacion',
                'idRegistro':idCotizacion,
                'nombreArchivo':'cotizacion',
                'tipo':tipo
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            $.post('php/convierte_pdf.php',{'D':datosJ},function(data)
            {  
                console.log('guarda formato: '+data);  
            });

        }

        $('#b_guardar_aprobacion').click(function(){
            $('#b_guardar_aprobacion').prop('disabled',true);
            
            if ($('#form_aprobacion').validationEngine('validate')){
                
                if($('input[name=radio_aprobada]:checked').val() == 4)
                {
                    if(parseInt(countVehiculo()) > 0 || parseInt(countEquipo()) > 0 || parseInt(countElementos()) > 0 || parseInt(countServicio()) > 0)
                    {
                        $('#i_calle').addClass('validate[required]');
                        $('#i_colonia').addClass('validate[required]');
                        $('#i_num_ext').addClass('validate[required]');
                        $('#i_codigo_postal').addClass('validate[required]');
                        $('#i_rfc').addClass('validate[required]');
                        $('#i_rep_legal').addClass('validate[required]');
                        $('#i_razon_social_cliente').addClass('validate[required]');
                        $('#i_contacto').addClass('validate[required]');
                        $('#s_paises').addClass('validate[required]');
                        $('#s_estados').addClass('validate[required]');
                        $('#s_municipios').addClass('validate[required]');
        
                        if($('.form_datos_cotizacion').validationEngine('validate'))
                        {   
                            /*$.post('php/cotizaciones_validar_datos_fiscales.php', {'idCotizacion':idCotizacion}, function(data) {
                                if(data == 1){*/
                                    ////validar que el porcentaje ultilidad sea mayor al minimo que se indica segun la unidad de negocio
                                    if(parseFloat($('#dato_porcentaje_utilidad_final').text()) >= porcentajeUtilidadIdUnidad)
                                    {
                                        aprobarCotizacion();
                                    }else{
                                        notificaPorcentajeUtilidad();
                                    }
                                /*}else{
                                    $('#b_guardar_aprobacion').prop('disabled',false);
                                    mandarMensaje('Primero debes guardar dando click en boton Guardar');
                                    $('#dialog_aprobacion').modal('hide');
                                }
                            });*/
                        }else{
                            $('#b_guardar_aprobacion').prop('disabled',false);
                            mandarMensaje('Verifica que todos los campos del cliente esten llenos y guardalos dando click en boton Guardar');
                            $('#dialog_aprobacion').modal('hide');
                        }
                    }else{
                        mandarMensaje('No es posible aprobar una cotización vacia');
                        $('#b_guardar_aprobacion').prop('disabled',false);
                    }
                }else{
                    aprobarCotizacion();
                }
            }else{
                $('#b_guardar_aprobacion').prop('disabled',false);
            }
        });

        function aprobarCotizacion(){
            $('#fondo_cargando').show();
            //actualizar cotización con observación y  fecha inicio servicio
            
            //-->NJES May/26/2020 al rechazar algunos campos no son requeridos, validar que no vayan nulls
            var datos = {
                'idCotizacion' : idCotizacion,
                'fechaArranque':$('#i_fecha_inicio_ap').val(),
                'observacion':$('#ta_observaciones').val(),
                'estatusProyecto':$('input[name=radio_aprobada]:checked').val(),
                'correos':$('#ta_correos').val(),
                'fecha_inicio_facturacion' : $('#i_inicio_facturacion').val(),
                'periodicidad' : $('#s_periodicidad').val() != null ? $('#s_periodicidad').val() : 0,
                'tipo_facturacion': $('#s_tipo_facturacion').val() != null ? $('#s_tipo_facturacion').val() : 0,
                'razon_social_emisora' : $('#i_razon_social_emisora').attr('alt'),
                'dia' : $('#i_dia').val(),
                'justificacionRechazada':$('#ta_justificacion_rechazada').val()
            };

            console.log(JSON.stringify(datos));

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar_aprobacion.php', 
                data:  {'datos':datos},
                dataType:"json",
                success: function(data) {
                    console.log(JSON.stringify(data));
                    $('#i_calle').removeClass('validate[required]');
                    $('#i_colonia').removeClass('validate[required]');
                    $('#i_num_ext').removeClass('validate[required]');
                    $('#i_codigo_postal').removeClass('validate[required]');
                    $('#i_rfc').removeClass('validate[required]');
                    $('#i_rep_legal').removeClass('validate[required]');
                    $('#i_razon_social_cliente').removeClass('validate[required]');
                    $('#i_contacto').removeClass('validate[required]');
                    $('#s_paises').removeClass('validate[required]');
                    $('#s_estados').removeClass('validate[required]');
                    $('#s_municipios').removeClass('validate[required]');

                    $('#ta_correos').val('');
                    $('#ta_observaciones').val('');
                    $('#ta_justificacion_rechazada').val('');
                    $('#i_fecha_inicio_ap').val('');
                    $('#i_inicio_facturacion').val('');
                    $('#s_periodicidad').val('');
                    $('#s_tipo_facturacion').val('');
                    $('#i_razon_social_emisora').attr('alt','').val('');
                    $('#i_dia').val('');
                    $('#radio_aprobada').prop('checked',true);
                    $('#radio_rechazada').prop('checked',false);
                    $('#dialog_aprobacion').modal('hide');
                    $('#b_guardar_aprobacion').prop('disabled',false);
                    buscaCotizacion(idCotizacion);
                    
                    if(data.verifica == false)
                    {
                        mandarMensaje('Error al aprobar la cotización.');
                        $('#fondo_cargando').hide();
                        $('#dialog_aprobacion').modal('hide');
                    }else{
                        mandarMensaje(data.mensaje);
                        $('#fondo_cargando').hide();
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_guardar_aprobacion.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al cerrar cotización.');
                    $('#dialog_aprobacion').modal('hide');

                    $('#b_guardar_aprobacion').prop('disabled',false);
                    $('#i_calle').removeClass('validate[required]');
                    $('#i_colonia').removeClass('validate[required]');
                    $('#i_num_ext').removeClass('validate[required]');
                    $('#i_codigo_postal').removeClass('validate[required]');
                    $('#i_rfc').removeClass('validate[required]');
                    $('#i_rep_legal').removeClass('validate[required]');
                    $('#i_razon_social_cliente').removeClass('validate[required]');
                    $('#i_contacto').removeClass('validate[required]');
                    $('#s_paises').removeClass('validate[required]');
                    $('#s_estados').removeClass('validate[required]');
                    $('#s_municipios').removeClass('validate[required]');
                    $('#fondo_cargando').hide();
                }
            });
        }

        //Toma los datos de facturacion y los envia por correo
        function enviaDatosFiscales(idCotizacion,idUnidadNegocio,idSucursal,folioCotizacion){
            $('#fondo_cargando').show();
            var datos_resumen = Array();
                    
            datos_resumen = {
                'idCotizacion':idCotizacion,
                'folioCotizacion':folioCotizacion,
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'costo_mensual' : $('#dato_costo_mensual').text(),
                'precio_mensual': $('#dato_precio_mensual').text(),
                'inversion_secorp': $('#dato_inversion').text(),
                'inversion_cliente': $('#dato_cargo_cliente').text(),
                'utilidad_primer_anio': $('#dato_utilidad_anual').text(),
                'retorno_inversion': $('#dato_retorno_inversion').text(),
                'utilidad_bruta_mensual': $('#dato_utilidad_bruta_mensual').text(),
                'utilidad_elemento': $('#dato_utilidad_elemento').text(),
                'porcentaje_utilidad_final': $('#dato_porcentaje_utilidad_final').text()+''+$('#dato_signo').text()
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_enviar_datos.php',
                data:  {'datos':datos_resumen},
                success: function(data) {
                    //console.log('success '+data);
                    mandarMensaje(data);
                    $('#fondo_cargando').hide();
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_enviar_datos.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al enviar datos fiscales');
                    $('#fondo_cargando').hide();
                }
            });
        }

        /****************Cerrar cotizacion fin****************/

        $('#b_nuevo').click(function(){
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
            muestraSeccionesPlantilla(idUnidadActual);

            $('#i_proyecto').val('');
            $('#i_proyecto, #s_id_unidades, #s_id_sucursales').prop('disabled',false);
            $('#l_estatus').css('background-color','white').text('');
            $('#i_folio').text('');

            $('#s_tipo_facturacion').val(0);
            $('#s_periodicidad').val(0);
            $('#i_dia').val(0);

            $('.form_datos_cotizacion').validationEngine('hide');
            $('.form_datos_cotizacion input, textarea').val('');

            $('#b_guardar_proyecto').css('display','block');

            $('#b_guardar').text('');
            $('#b_guardar').append('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar').prop('disabled',true);
            $('.coti').prop('disabled',true);
            $('#b_comprimir').css('display','none');
            $('#b_expandir').css('display','block');
            $('.collapse').removeClass('show');

            limpiarElementos();
            limpiarEquipo();
            limpiarServicio();
            limpiarVehiculo();
            muestraClientes();
            obtenerTextos();

            $('#dato_fecha_creacion').text('');

            $('.div_botones_alt2').css('display','block');
            $('.div_botones_alt').css('display','none');

            $('#div_lista_elemento,#div_lista_equipo,#div_lista_servicio,#div_lista_vehiculo').empty();
            $('#c_costo_total_elemento,#c_costo_total_equipo,#c_costo_total_servicio,#c_costo_total_vehiculo').text('');
            $('#dato_total_elementos,#dato_total_equipo,#dato_total_servicio,#dato_total_vehiculo').text('');
            $('#c_costo_total_elemento,#c_precio_total_elemento,#c_costo_total_equipo,#c_precio_total_equipo,#c_costo_total_servicio,#c_precio_total_servicio,#c_costo_total_vehiculo,#c_precio_total_vehiculo').text('');

            $('#b_agrega_elemento, #b_agrega_elemento2, #b_agrega_equipo, #b_agrega_equipo2, #b_agrega_servicio, #b_agrega_servicio2, #b_agrega_vehiculo, #b_agrega_vehiculo2,#b_agrega_consumibles,#b_agrega_consumibles2,#b_guardar_observaciones_elemento,#b_guardar_observaciones_equipo,#b_guardar_observaciones_servicio,#b_guardar_observaciones_vehiculo,#b_guardar_observaciones_consumibles').prop('disabled',true);
            $('.datos_resumen').text('');
            
            actualizaCotizacion=0;
            idProyecto=0;
            idCotizacion=0;
            idCliente=0;
            folioCotizacion=0;
            
            $('#i_calle').removeClass('validate[required]');
            $('#i_colonia').removeClass('validate[required]');
            $('#i_num_ext').removeClass('validate[required]');
            $('#i_codigo_postal').removeClass('validate[required]');
            $('#i_rfc').removeClass('validate[required]');
            $('#i_rep_legal').removeClass('validate[required]');
            $('#i_razon_social_cliente').removeClass('validate[required]');
            $('#i_contacto').removeClass('validate[required]');
            $('#s_paises').removeClass('validate[required]');
            $('#s_estados').removeClass('validate[required]');
            $('#s_municipios').removeClass('validate[required]');

            $('#b_imprimir').prop('disabled',false);

            $('#div_comision_cotizacion div').css('display','none'); 
            $('#div_comision_resumen').css('display','none'); 

            $('#s_puestos').attr('disabled',true);

            //-->NJES February/05/2021 ya no se puede capturar el salario diario, solo se puede seleccionar del combo
            //-->NJES Sep/29/2020 verificar si tiene permiso para capturar salario sin importar puesto y razón social
            /*if(verificaPermisoElemento(idUsuario,'CAPTURAR_SALARIO',idUnidadActual) == 1)
            {
                $('#div_salario_diario').hide(); 
                $('#div_salario_captura').show();
            }else{ */
                $('#div_salario_captura').hide();  
                $('#div_salario_diario').show();  
            //}   
        });

        function obtenerTextos(){
            /*$.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_textos_inicio_fin.php',
                dataType:"json", 
                success: function(data)
                {

                    for(var i=0;data.length>i;i++)
                    {
                        $('#ta_texto_inicio').val(data[i].texto_inicio);
                        $('#ta_texto_fin').val(data[i].texto_fin);
                    }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_buscar_textos_inicio_fin.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar Textos.');
                }
            });*/
            $('#ta_texto_inicio').val('');
            $('#ta_texto_fin').val('');

            $.ajax({
                type: 'POST',
                url: 'php/plantillas_cotizaciones_buscar_id_unidad.php',
                dataType:"json", 
                data: {'idUnidadNegocio':$('#s_id_unidades').val()},
                success: function(data)
                {

                    for(var i=0;data.length>i;i++)
                    {
                        $('#ta_texto_inicio').val(data[i].texto_inicio);
                        $('#ta_texto_fin').val(data[i].texto_fin);
                    }

                },
                error: function (xhr) {
                    console.log('php/plantillas_cotizaciones_buscar_id_unidad.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar Textos.');
                }
            });
        }

       /***************************CREAR VERSION DE COTIZACION*****************************/


        //*** Al momento de generar una nueva verión de cotización su estatus es impreso(2) y el de todas las anteriores 
        //*** y el estatus de la nueva cotización es activo(1) y en proyecto el estatus es negociación(2)

        //*** Verificar siempre estatus de proyecto, si el proyecto estaba aprobado y se genera versión, 
        //*** el esatatus de la nueva versión es activo(1) y en proyecto el estatus es Rechazada(3)
        $('#b_version').click(function(){
            $('#dialog_version').modal('show');
        });

        $('#b_guardar_version').click(function(){
            $('#b_guardar_version').prop('disabled',true);
            if ($('#form_version').validationEngine('validate')){
                //crearNuevaVersion('nueva');
                crearNuevaVersion();
            }else{
                $('#b_guardar_version').prop('disabled',false);
            }
        });

        function crearNuevaVersion(){
            var datos = Array();
            datos = {
                'idCotizacion' : idCotizacion,
                'usuario' : usuario,
                'idUsuario' : idUsuario,
                'idProyecto' : idProyecto,
                'justificacionVersion':$('#ta_justificacion').val(),
                'necesidadVersion':$('#ta_porque').val(),
                'estatusProyecto':estatusProyecto,
                'idUnidadNegocio':$('#s_id_unidades').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar_version.php',  
                data: {'datos':datos},
                success: function(data){
                    if(data != 0){
                        idCotizacion=data;
                        buscaCotizacion(idCotizacion);
                        $('#form_version textarea').val('');
                        mandarMensaje('Se creó correctamente la versión de cotización.');
                        $('#b_guardar_version').prop('disabled',false);
                        $('#dialog_version').modal('hide');
                    }else{
                        mandarMensaje('Ocurrio un error al crear la versión.');
                        $('#b_guardar_version').prop('disabled',false);
                    }
                    
                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_guardar_version.php -->'+JSON.stringify(xhr));
                    mandarMensaje("* No se encontró información al crear versión.");
                    $('#b_guardar_version').prop('disabled',false);
                }
            });
        }
        /***************************FIN DE CREAR VERSION DE COTIZACION*****************************/

        function notificaPorcentajeUtilidad(){
            $('#dialog_aprobacion').modal('hide');
            $('#fondo_cargando').show();

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_enviar_notificacion_porcentaje_u.php',
                data:  {'idCotizacion':idCotizacion,
                        'utilidad':parseFloat($('#dato_porcentaje_utilidad_final').text()),
                        'porcentajeUtilidad':porcentajeUtilidadIdUnidad},
                success: function(data) {
                    if(data== '')
                        mandarMensaje('Error al enviar datos para aprobar cotización.');
                    else
                        mandarMensaje(data);
                    

                    $('#ta_correos').val('');
                    $('#ta_observaciones').val('');
                    $('#ta_justificacion_rechazada').val('');
                    $('#i_fecha_inicio_ap').val('');
                    $('#i_inicio_facturacion').val('');
                    $('#s_periodicidad').val('');
                    $('#s_tipo_facturacion').val('');
                    $('#i_razon_social_emisora').attr('alt','').val('');
                    $('#i_dia').val('');
                    $('#radio_aprobada').prop('checked',true);
                    $('#radio_rechazada').prop('checked',false);
                    $('#dialog_aprobacion').modal('hide');
                    $('#b_guardar_aprobacion').prop('disabled',false);
                    $('#fondo_cargando').hide();
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_enviar_notificacion_porcentaje_u.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al solicitar aprobacion porcentaje utilidad.');
                    $('#fondo_cargando').hide();
                    $('#b_guardar_aprobacion').prop('disabled',false);
                }
            });
        }

        

        
        $('#b_guardar_comision').click(function(){
            $('#b_guardar_comision').prop('disabled',true);

            var datos = {
                'idCotizacion': idCotizacion,
                'comision': $('#i_comision_cotizacion').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar_comision.php',  
                data: {'datos':datos},
                success: function(data){
                    if(data == 1)
                    {
                        $('#b_guardar_comision').prop('disabled',false);
                        muestraSumaComision();
                    }else{
                        mandarMensaje('Error al guardar comisión');
                        $('#b_guardar_comision').prop('disabled',false);
                    }                  
                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_guardar_comision.php -->'+JSON.stringify(xhr));
                    mandarMensaje("* No se encontró información al guardar comisión.");
                    $('#b_guardar_comision').prop('disabled',false);
                }
            });
        });


        //---MGFS CAMBIOS AL CERRAR LA COTIZACIÓN ---

        $(document).on('change','#i_inicio_facturacion',function(){
            var valor=$(this).val();
            $('#i_fecha_inicio_ap').val(valor);
        });

        $(document).on('click','#radio_rechazada',function(){
            $('.label_aprovar').removeClass('requerido');
            $('.datos_aprovar').removeClass('validate[required]');
            $('#ta_correos').removeAttr('class');
            $('#ta_correos').addClass('form-control validate[custom[multiEmail]]');

            $('#div_justificacion_rechazada').show();
            $('.divs_aprobar').hide();
        });

        //---MGFS CAMBIOS AL CERRAR LA COTIZACIÓN ---
        $(document).on('click','#radio_aprobada',function(){
            $('.label_aprovar').addClass('requerido');
            $('.datos_aprovar').addClass('validate[required]');
            $('#ta_correos').removeAttr('class');
            $('#ta_correos').addClass('form-control validate[required,custom[multiEmail]]');
          
            
            $('#div_justificacion_rechazada').hide().val('').validationEngine('hide');
            $('.divs_aprobar').show();
        });

        $(document).ready(function()
        {
            $('#i_bono_elemento,#i_tiempo_elemento,#i_otros_elemento,#i_precio_elemento,#i_vacaciones,#i_aguinaldo,#i_festivo,#i_dia_31').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });

            //-->NJES March/19/2020 permitir capturar decimales en cantidad de sección elementos
            $('#i_cantidad_elemento,#i_costo_equipo,#i_precio_equipo,#i_costo_servicio,#i_precio_servicio,#i_costo_vehiculo,#i_precio_vehiculo,#i_costo_consumibles,#i_precio_consumibles,#i_costo_unitario_uniforme').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });

            $('#i_cantidad_equipo,#i_cantidad_uniforme,#i_cantidad_vehiculo,#i_cantidad_servicio,#i_cantidad_consumibles').keypress(function (event){
                return valideKeySoloNumeros(event);
            });
        });

        /**************Inicio funciones consumibles***************/
        $('#b_agrega_consumibles, #b_agrega_consumibles2').click(function(){
            $('#b_agrega_consumibles, #b_agrega_consumibles2').prop('disabled',true);

            if ($('#form_consumibles').validationEngine('validate')){
                if(parseInt($('#i_cantidad_consumibles').val()) > 0){
                    //--> warning de que el precio es menor al costo
                    if(parseFloat(quitaComa($('#i_precio_consumibles').val())) < parseFloat(quitaComa($('#i_costo_consumibles').val()))){
                        $('#b_agrega_consumibles, #b_agrega_consumibles2').prop('disabled',false);
                        mandarMensajeConfimacion('El precio es menor al costo, ¿Deseas continuar?',0,'consumibles_n');
                    }else{
                        guardarConsumible();
                    } 
                }else{
                    mandarMensaje('La cantidad debe ser mayor a 0');
                    $('#b_agrega_consumibles, #b_agrega_consumibles2').prop('disabled',false);
                }
            }else{
                $('#b_agrega_consumibles, #b_agrega_consumibles2').prop('disabled',false);
            }
        });

        //--> continua y si agrega el elemento aunque el precio sea menor al costo
        $(document).on('click','#b_consumibles_n',function(){  
            guardarConsumible();
        });

        //--> Toma el id, elimina el registro de la tabla. Y toma los datos del renglon para subirlos a los campos a editar y despues guardar.
        $(document).on('click','.b_editar_consumibles',function(){
            var idConsumible=$(this).attr('alt');

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_consumibles_buscar_id.php',
                dataType:"json", 
                data:  {'idConsumible':idConsumible},
                success: function(data) {
           
                    $('#i_consumibles').val(data[0].nombre);
                    $('#i_cantidad_consumibles').val(data[0].cantidad);
                    $('#i_costo_consumibles').val(formatearNumero(data[0].costo));
                    $('#i_precio_consumibles').val(formatearNumero(data[0].precio));
                    $('#i_costo_total_consumibles').val(formatearNumero(data[0].costo_total));
                    $('#i_precio_total_consumibles').val(formatearNumero(data[0].precio_total));
                    $('#i_observaciones_consumibles').val(data[0].observaciones);

                    if(data[0].prorratear == 1)
                    {
                        $('#ch_prorratear_consumibles').prop('checked',true);
                    }else{
                        $('#ch_prorratear_consumibles').prop('checked',false);
                    }

                    if(data[0].tipo_pago == 1)
                    {
                        $('#radio_consumibles1').prop('checked',true);
                    }else{
                        $('#radio_consumibles2').prop('checked',true);
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'php/cotizaciones_consumibles_eliminar.php',
                        dataType:"json", 
                        data:  {'idConsumible':idConsumible},
                        success: function(data) {
                    
                            if(data != 0 ){
                                buscarConsumible(idCotizacion);
                                actualizaCostoTotalElementos(idCotizacion);
                            }
                        },
                        error: function (xhr) {
                            console.log('php/cotizaciones_consumibles_eliminar.php --> '+JSON.stringify(xhr));
                            mandarMensaje('* No se encontró información al eliminar consumible');
                        }
                    });

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_consumibles_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar consumibles para editar');
                }
            });
        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY 
        $(document).on('click','.b_eliminar_consumibles',function(){

           var idConsumible=$(this).attr('alt');
           mandarMensajeConfimacion('Se eliminara el registro de forma permanente, ¿Deseas continuar?',idConsumible,'consumibles');

        });

        //CUANDO ALGO NO EXISTE PERO LO CREO CON JQUERY                 
        $(document).on('click','#b_consumibles',function(){  

            var idConsumible=$(this).attr('alt');
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_consumibles_eliminar.php',
                dataType:"json", 
                data:  {'idConsumible':idConsumible},
                success: function(data) {
                    if(data == 0 ){
                        mandarMensaje('Error al eliminar registro');
                    }else{
                        mandarMensaje('Se elimino el registro');
                        buscarConsumible(idCotizacion);
                        actualizaCostoTotalElementos(idCotizacion);
                    }
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_consumibles_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al eliminar registro');
                }
            });
        });

        //--> cada que se hace un cambio en campos se recalcula el costo total
        $('#i_costo_consumibles,#i_cantidad_consumibles,#i_precio_consumibles').change(function(){
            calculaCostoTotalConsumible();
        });

        function guardarConsumible(){
            calculaCostoTotalConsumible();   //--> se calcula el costo total unitario para guardarlo en cada registro que se inserte
            var datos = Array();

            datos = {
                'nombre': $('#i_consumibles').val(),
                'cantidad': $('#i_cantidad_consumibles').val(),
                'tipo_pago': $('input[name=radio_consumibles]:checked').val(),
                'costo': quitaComa($('#i_costo_consumibles').val()),
                'precio': quitaComa($('#i_precio_consumibles').val()),
                'costoTotal': quitaComa($('#i_costo_total_consumibles').val()),
                'precioTotal': quitaComa($('#i_precio_total_consumibles').val()),
                'observaciones': $('#i_observaciones_consumibles').val(),
                'prorratear': $('#ch_prorratear_consumibles').is(':checked') ? 1 : 0,
                'idCotizacion': idCotizacion
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_consumibles_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                   if(data > 0){
                        
                        buscarConsumible(idCotizacion);
                        actualizaCostoTotalElementos(idCotizacion);
                        limpiarConsumible();

                        $('#b_agrega_consumibles, #b_agrega_consumibles2').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al agregar equipo. Verifica e intenta nuevamente');
                        $('#b_agrega_consumibles, #b_agrega_consumibles2').prop('disabled',false);

                        buscarConsumible(idCotizacion);
                        limpiarConsumible();
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_consumibles_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar registro.');
                    $('#b_agrega_consumibles, #b_agrega_consumibles2').prop('disabled',false);
                }
            });
        }

        function buscarConsumible(idCotizacion){
            $('#div_lista_consumibles').empty();
            $('#dato_total_consumibles').text('');
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_consumibles_buscar.php',
                dataType:"json", 
                data:  {'idCotizacion':idCotizacion},
                success: function(data) {
                    if(data.length > 0)
                    {
                        var costoTotalConsumible=0;
                        var precioTotalConsumible=0;

                        //-->crea inicio de la tabla
                        var html='<table class="tablon"  id="ul_lista_consumibles">\
                                    <thead>\
                                        <tr class="renglon">\
                                        <th scope="col"></th>\
                                        <th scope="col">Consumible</th>\
                                        <th scope="col">Cantidad</th>\
                                        <th scope="col">Tipo Pago</th>\
                                        <th scope="col">Costo Unitario</th>\
                                        <th scope="col">Costo Total</th>\
                                        <th scope="col">Precio Unitario</th>\
                                        <th scope="col">Precio Total</th>\
                                        <th scope="col">Observaciones</th>\
                                        </tr>\
                                    </thead>\
                                    <tbody>';

                        for(var i=0;data.length>i;i++){
                            //-->llena la tabla con renglones de registros
                            if(data[i].tipo_pago == 1)
                            {
                                var tipo_pago='Pago Mensual';
                            }else{
                                var tipo_pago='Pago Único';
                            }

                            if(consumiblesP == 1)
                            {
                                if(data[i].estatus == 2)
                                {
                                    var b_disabled='disabled';
                                }else{
                                    var b_disabled='';
                                }
                            }else{
                                var b_disabled='disabled';
                            }

                            if(data[i].prorratear == 1)
                            {
                                var costo = 0;
                                var precio = 0;
                                var costoTotal = 0;
                                var precioTotal = 0;
                                var costoTotalAlt = 0;
                                var precioTotalAlt = 0;
                            }else{
                                var costo = formatearNumero(data[i].costo);
                                var precio = formatearNumero(data[i].precio);
                                var costoTotal = formatearNumero(data[i].costo_total);
                                var precioTotal = formatearNumero(data[i].precio_total);
                                var costoTotalAlt = data[i].costo_total;
                                var precioTotalAlt = data[i].precio_total;
                            }
        
                                html += '<tr class="renglon_consumibles">';
                                html += '<td>\
                                            <button type="button" class="btn btn-secondary btn-sm b_eliminar_consumibles eliminar" alt="'+data[i].id+'" '+b_disabled+'>\
                                                <i class="fa fa-times" aria-hidden="true"></i>\
                                            </button>\
                                            <button type="button" class="btn btn-warning btn-sm b_editar_consumibles editar" alt="'+data[i].id+'" '+b_disabled+' style="float:right;">\
                                                <i class="fa fa-pencil" aria-hidden="true"></i>\
                                            </button></td>';
                                html += '<td data-label="Consumible">' + data[i].nombre+ '</td>';
                                html += '<td data-label="Cantidad">' + data[i].cantidad+ '</td>';
                                html += '<td data-label="Tipo Pago">' + tipo_pago + '</td>';
                                html += '<td data-label="Costo Unitario">$'+ costo +'</td>';
                                html += '<td data-label="Costo Total">$'+ costoTotal +'</td>';
                                html += '<td data-label="Precio Unitario">$' + precio + '</td>';
                                html += '<td data-label="Precio Total">$'+ precioTotal +'</td>';
                                html += '<td data-label="Observaciones">'+ data[i].observaciones +'</td>';
                                html += '</tr>';

                            costoTotalConsumible=costoTotalConsumible+parseFloat(costoTotalAlt);   //-->suma los costos totales de los equipos
                            precioTotalConsumible=precioTotalConsumible+parseFloat(precioTotalAlt);  //-->suma los precios totales de los equipos
                        }   

                        //-->crea fin de la tabla
                        html += '</tbody></table>';

                        $('#div_lista_consumibles').append(html);   //-->agrega la tabla creada al div

                        $('#c_costo_total_consumibles').text('Costo Total: $'+formatearNumero(costoTotalConsumible));
                        $('#c_precio_total_consumibles').text('Precio Total: $'+formatearNumero(precioTotalConsumible));

                        $('#dato_total_consumibles').text(countConsumible()); 

                        calculaSumas(idCotizacion);
                    }else{
                        var costoTotalConsumible=0;
                        var precioTotalConsumible=0;

                        $('#c_costo_total_consumibles').text('Costo Total: $'+formatearNumero(costoTotalConsumible));
                        $('#c_precio_total_consumibles').text('Precio Total: $'+formatearNumero(precioTotalConsumible));

                        calculaSumas(idCotizacion);
                    }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_consumibles_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar registro.');
                }
            });
        }

        function countConsumible(){    //-->cuenta los consumibles 
            var numConsumible=0;
            $('#ul_lista_consumibles tbody tr').each(function(){
                numConsumible=numConsumible + parseInt($(this).children('td:eq(2)').text());
            });

            return numConsumible;
        }

        function calculaCostoTotalConsumible(){     //-->calcula el costo total de los consumibles a insertar
            var costoTotal=0;
            var precioTotal=0;

            if($('#i_costo_consumibles').val() != ''){
                var sueldo=quitaComa($('#i_costo_consumibles').val());
            }else{
                var sueldo=0;
            }

            if($('#i_precio_consumibles').val() != ''){
                var precio=quitaComa($('#i_precio_consumibles').val());
            }else{
                var precio=0;
            }

            if($('#i_cantidad_consumibles').val() != ''){
                var cantidad=$('#i_cantidad_consumibles').val();
            }else{
                var cantidad=0;
            }

            costoTotal=parseFloat(sueldo);
            precioTotal=parseFloat(precio);

            $('#i_costo_total_consumibles').val(formatearNumero(costoTotal*parseInt(cantidad)));
            $('#i_precio_total_consumibles').val(formatearNumero(precioTotal*parseInt(cantidad)));
            
        }

        function limpiarConsumible(){
            $("#form_consumibles").find('input').not(':radio').val('');
            $('#ch_prorratear_consumibles').prop('checked',false);
        }
        /**************Fin funciones consumibles***************/

        /**************Inicio guardar observaciones secciones***************/
        $('#b_guardar_observaciones_consumibles').click(function(){
            $('#b_guardar_observaciones_consumibles').prop('disabled',true);

            var datos = {
                'tipo':'consumible',
                'idCotizacion': idCotizacion,
                'observacionesGenerales':$('#ta_observaciones_generales_consumibles').val(),
                'observacionesInternas':$('#ta_observaciones_internas_consumibles').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_observaciones_secciones_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                   if(data > 0){
                        muestraObservacionesSecciones(idCotizacion);
                        mandarMensaje('Obervación guardada correctamente.');
                        $('#b_guardar_observaciones_consumibles').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al guardar observación. Verifica e intenta nuevamente.');
                        $('#b_guardar_observaciones_consumibles').prop('disabled',false);
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_observaciones_secciones_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar registro.');
                    $('#b_guardar_observaciones_consumibles').prop('disabled',false);
                }
            });
        });

        $('#b_guardar_observaciones_elemento').click(function(){
            $('#b_guardar_observaciones_elemento').prop('disabled',true);

            var datos = {
                'tipo':'elemento',
                'idCotizacion': idCotizacion,
                'observacionesGenerales':$('#ta_observaciones_generales_elemento').val(),
                'observacionesInternas':$('#ta_observaciones_internas_elemento').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_observaciones_secciones_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                   if(data > 0){
                        muestraObservacionesSecciones(idCotizacion);
                        mandarMensaje('Obervación guardada correctamente.');
                        $('#b_guardar_observaciones_elemento').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al guardar observación. Verifica e intenta nuevamente.');
                        $('#b_guardar_observaciones_elemento').prop('disabled',false);
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_observaciones_secciones_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar registro.');
                    $('#b_guardar_observaciones_elemento').prop('disabled',false);
                }
            });
        });

        $('#b_guardar_observaciones_equipo').click(function(){
            $('#b_guardar_observaciones_equipo').prop('disabled',true);

            var datos = {
                'tipo':'equipo',
                'idCotizacion': idCotizacion,
                'observacionesGenerales':$('#ta_observaciones_generales_equipo').val(),
                'observacionesInternas':$('#ta_observaciones_internas_equipo').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_observaciones_secciones_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                   if(data > 0){
                        muestraObservacionesSecciones(idCotizacion);
                        mandarMensaje('Obervación guardada correctamente.');
                        $('#b_guardar_observaciones_equipo').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al guardar observación. Verifica e intenta nuevamente.');
                        $('#b_guardar_observaciones_equipo').prop('disabled',false);
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_observaciones_secciones_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar registro.');
                    $('#b_guardar_observaciones_equipo').prop('disabled',false);
                }
            });
        });

        $('#b_guardar_observaciones_servicio').click(function(){
            $('#b_guardar_observaciones_servicio').prop('disabled',true);

            var datos = {
                'tipo':'servicio',
                'idCotizacion': idCotizacion,
                'observacionesGenerales':$('#ta_observaciones_generales_servicio').val(),
                'observacionesInternas':$('#ta_observaciones_internas_servicio').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_observaciones_secciones_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                   if(data > 0){
                        muestraObservacionesSecciones(idCotizacion);
                        mandarMensaje('Obervación guardada correctamente.');
                        $('#b_guardar_observaciones_servicio').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al guardar observación. Verifica e intenta nuevamente.');
                        $('#b_guardar_observaciones_servicio').prop('disabled',false);
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_observaciones_secciones_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar registro.');
                    $('#b_guardar_observaciones_servicio').prop('disabled',false);
                }
            });
        });

        $('#b_guardar_observaciones_vehiculo').click(function(){
            $('#b_guardar_observaciones_vehiculo').prop('disabled',true);

            var datos = {
                'tipo':'vehiculo',
                'idCotizacion': idCotizacion,
                'observacionesGenerales':$('#ta_observaciones_generales_vehiculo').val(),
                'observacionesInternas':$('#ta_observaciones_internas_vehiculo').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_observaciones_secciones_guardar.php',  
                data: {'datos':datos},
                success: function(data){
                   if(data > 0){
                        muestraObservacionesSecciones(idCotizacion);
                        mandarMensaje('Obervación guardada correctamente.');
                        $('#b_guardar_observaciones_vehiculo').prop('disabled',false);
                   }else{
                        mandarMensaje('Error al guardar observación. Verifica e intenta nuevamente.');
                        $('#b_guardar_observaciones_vehiculo').prop('disabled',false);
                   }
                },
                //-->si ha ocurrido un error
                error: function(xhr){
                    console.log('php/cotizaciones_observaciones_secciones_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar registro.');
                    $('#b_guardar_observaciones_vehiculo').prop('disabled',false);
                }
            });
        });
         
    });

</script>

</html>