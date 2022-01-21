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
        height:330px;
        overflow:auto;
    }
    #dialog_buscar_productos > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    #dialog_buscar_salidas_comodato > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    .boton_eliminar{
        width:50px;
    }
    .leyenda_almacenes{
        float:right; 
        color:green; 
        font-size:13px;
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
        #dialog_buscar_salidas_comodato > .modal-lg{
            max-width: 100%;
        }
        .boton_eliminar{
            width:100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-offset-1 col-md-12" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Reporte Activos Fijos</div>
                    </div>
                    <div class="col-md-5"> 
                        <div class="row">
                            <label for="s_empresa_fiscal" class="col-md-3 col-form-label">Empresa Fiscal</label>
                            <div class="input-group form-control-sm col-sm-12 col-md-8">
                                <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="b_buscar_empresa_fiscal" style="margin:0px;">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-2">
                        <input type="checkbox" id="ch_todas_empresas" name="ch_todas_empresas" value="" checked> Mostrar todas
                    </div> 
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>
                <form id="forma_salida_comodato" name="forma_salida_comodato">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-3">
                            <label for="s_id_unidades" class="col-form-label requerido">Unidad de Negocio </label>
                            <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="s_id_sucursales" class="col-sm-12 col-md-12 col-form-label requerido">Sucursal </label>
                            <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-4">
                            <br>
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
                        <div class="col-sm-12 col-md-2">
                        <br>
                            <input type="text" name="i_filtro" id="i_filtro" class="form-control form-control-sm filtrar_renglones" alt="activo_renglon" placeholder="Filtrar" autocomplete="off">
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                            <tr class="renglon">
                                <th scope="col">Fecha<br> Adquisición</th>
                                <th scope="col">No. Serie</th>
                                <th scope="col">No. Económico</th>
                                <th scope="col">IMEI GPS</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Valor<br> Adquisición</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Propietario</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Responsable ó <br>cliente</th>
                                <th scope="col">Vigencia<br>Póliza</th>
                                <th scope="col">Póliza</th>
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
                </div>
            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>




    <div class="modal fade" id="dialog_detalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="label_pdf">Detalle del activo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <!-- Acordeon Vehiculo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  -->
                    <div class="col-md-12">
                    <a id="link_vehiculo" class="collapsed" data-toggle="collapse" href="#collapse_vehiculo" aria-expanded="true" aria-controls="collapse_vehiculo">
                        <div class="card-header badge-secondary" role="tab" id="heading_vehiculo">
                        <h4 class="mb-0">
                            <div class="row">
                            <div class="col-md-3">
                                <span class="badge badge-secondary">Vehículo</span>
                            </div>
                            </div>
                        </h4>
                        </div>
                    </a>
                    <div id="collapse_vehiculo" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_vehiculo" data-parent="#accordion">
                        <div class="card-body">

                        <form id="forma_vehiculo" name="forma_vehiculo">
                            <div class="row">
                            <div class="col-md-1">
                                <label for="s_veh_tipo" class="col-form-label">Tipo:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-md-13">
                                <select id="s_veh_tipo" name="s_veh_tipo" class="form-control form-control-sm validate[required]" autocomplete="off" readonly></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="i_veh_poliza" class="col-form-label">Póliza:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-sm-12 col-md-12">
    
                                <div class="input-group-btn">
                                    <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                                    <button class="btn btn-primary preview_poliza" type="button" id="b_preview_poliza" style="margin:0px;">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-1">
                                <label for="s_veh_marca" class="col-form-label">Marca:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-md-13">
                                <select id="s_veh_marca" name="s_veh_marca" class="form-control form-control-sm validate[required]" autocomplete="off" readonly></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="i_veh_vigencia" class="col-form-label">Vigencia Póliza:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-md-13">&nbsp;&nbsp;&nbsp;
                                <input type="text" id="i_veh_vigencia" name="i_veh_vigencia" class="form-control form-control-sm" autocomplete="off" readonly>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-1">
                                <label for="s_veh_color" class="col-form-label ">Color:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_veh_color" name="i_veh_color" class="form-control form-control-sm validate[required]" autocomplete="off" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="i_veh_circulacion" class="col-form-label">Tarjeta de Circulación:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-sm-12 col-md-12">
        
                                <div class="input-group-btn">
                                    <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                                    <button class="btn btn-primary preview_circulacion" type="button" id="b_preview_circulacion" style="margin:0px;">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-1">
                                <label for="i_veh_modelo" class="col-form-label">Modelo:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_veh_modelo" name="i_veh_modelo" class="form-control form-control-sm validate[required]" autocomplete="off" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="i_veh_vigencia_circulacion" class="col-form-label">Vigencia Tarjeta Circ.:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-md-13">&nbsp;&nbsp;&nbsp;
                                <input type="text" id="i_veh_vigencia_circulacion" name="i_veh_vigencia_circulacion" class="form-control form-control-sm" autocomplete="off" readonly>
    
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-1">
                                <label for="i_veh_placas" class="col-form-label">Placas:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_veh_placas" name="i_veh_vigencia_circulacion" class="form-control form-control-sm validate[required]" autocomplete="off" readonly>
                            </div>
                            
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    

                    <!-- Acordeon Celular - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                    <div class="col-md-12">
                    <a id="link_celular" class="collapsed" data-toggle="collapse" href="#collapse_celular" aria-expanded="true" aria-controls="collapse_celular">
                        <div class="card-header badge-secondary" role="tab" id="heading_celular">
                        <h4 class="mb-0">
                            <span class="badge badge-secondary">Celular</span>
                        </h4>
                        </div>
                    </a>
                    <div id="collapse_celular" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_celular" data-parent="#accordion">
                        <div class="card-body">
                        <form id="forma_celular" name="forma_celular">
                            <div class="row">
                            <div class="col-md-2">
                                <label for="s_cel_marca" class="col-form-label">Marca:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-md-13">
                                <select id="s_cel_marca" name="s_cel_marca" class="form-control form-control-sm validate[required]" autocomplete="off" readonly ></select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="s_cel_compania" class="col-form-label">Compañía:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-md-13">
                                <select id="s_cel_compania" name="s_cel_compania" class="form-control form-control-sm validate[required]" autocomplete="off" readonly></select>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2">
                                <label for="i_cel_modelo" class="col-form-label">Modelo:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_cel_modelo" name="i_cel_modelo" class="form-control form-control-sm validate[required]" autocomplete="off" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="i_cel_paquete" class="col-form-label">Paquete:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_cel_paquete" name="i_cel_paquete" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2">
                                <label for="i_cel_imei" class="col-form-label">Código IMEI:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_cel_imei" name="i_cel_imei" class="form-control form-control-sm validate[required,custom[integer],minSize[14],maxSize[15]]" autocomplete="off" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="i_cel_contrato" class="col-form-label">No. Contrato:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_cel_contrato" name="i_cel_contrato" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2">
                                <label for="i_cel_numero" class="col-form-label">Número Telefónico:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_cel_numero" name="i_cel_numero" class="form-control form-control-sm validate[required,custom[integer],minSize[10],maxSize[10]]" autocomplete="off" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="i_cel_vigencia_contrato" class="col-form-label">Vigencia de Contrato:</label>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group col-md-13">
                                <input type="text" id="i_cel_vigencia_contrato" name="i_cel_vigencia_contrato" class="form-control form-control-sm " autocomplete="off" readonly>
                                </div>
                            </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    

                    <!-- Acordeon E. Computo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

                    <div class="col-md-12">
                    <a id="link_computo" class="collapsed" data-toggle="collapse" href="#collapse_computo" aria-expanded="true" aria-controls="collapse_computo">
                        <div class="card-header badge-secondary" role="tab" id="heading_computo">
                        <h4 class="mb-0">
                            <span class="badge badge-secondary">Equipo de Computo</span>
                        </h4>
                        </div>
                    </a>
                    <div id="collapse_computo" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_computo" data-parent="#accordion">
                        <div class="card-body">
                        <form id="forma_computo" name="forma_computo">
                            <div class="row">
                            <div class="col-md-2">
                                <label for="s_eq_marca" class="col-form-label">Marca:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-md-13">
                                <select id="s_eq_marca" name="s_eq_marca" class="form-control form-control-sm validate[required]" autocomplete="off" readonly></select>
                                </div>
                            </div>

                            </div>
                            <div class="row">
                            <div class="col-md-2">
                                <label for="i_eq_modelo" class="col-form-label">Modelo:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_eq_modelo" name="i_eq_modelo" class="form-control form-control-sm validate[required]" autocomplete="off" readonly>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2">
                                <label for="s_eq_tipo" class="col-form-label">Tipo:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group col-md-13">
                                <select id="s_eq_tipo" name="s_eq_tipo" class="form-control form-control-sm validate[required]" autocomplete="off" readonly></select>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2">
                                <label class="col-form-label">No. Serie Cargador</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="i_cargador" name="i_cargador" class="form-control form-control-sm validate[required]" autocomplete="off" readonly>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2">
                                <label for="i_eq_caracteristicas" class="col-form-label">Características:</label>
                            </div>
                            <div class="col-md-10">
                                <textarea type="text" id="i_eq_caracteristicas" name="i_eq_caracteristicas" class="form-control form-control-sm" autocomplete="off" readonly></textarea>
                            </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Mostrar PDF -->
    <div class="modal fade" id="dialog_archivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="label_pdf"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
            <label style="font-size:10px;">Nota: En caso de reemplazar el archivo y no visualizarse Deshabilitar Cache  <button type="button" class="btn2" id="b__archivo_info" style=""><i class="fa fa-info" aria-hidden="true" style="font-size:9px;"></i></button> </label>
                    <div style="width:100%" id="div_archivo"></div>
                </div>

            </div>
        </div>
    </div>
</body>

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
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_empresa_fiscal" alt="renglon_empresa_fiscal" id="i_filtro_empresa_fiscal" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
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


<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='REPORTE_ACTIVOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var idSalidaComodato = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        }); 

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);
     
        muestraRegistros(primerDiaMes,ultimoDiaMes,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));

        $('#s_id_unidades').change(function(){
            var idUnidadNegocio = $('#s_id_unidades').val();
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);

            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId(idUnidadNegocio,modulo,idUsuario));
        });

        $(document).on('change','#s_id_sucursales',function(){
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),$('#s_id_sucursales').val());
        });

        $('#i_fecha_inicio').change(function(){
            if($('#s_id_sucursales').val() != null)
            {
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),$('#s_id_sucursales').val());
            }else{
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_id_sucursales').val() != null)
            {
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),$('#s_id_sucursales').val());
            }else{
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        function muestraRegistros(fechaInicio,fechaFin,idSucursal){

            $('#t_registros tbody').html('');

            $.ajax({
                type: 'POST',
                url: 'php/activos_buscar_reporte.php',
                dataType:"json",
                data:{
                    'idUnidadNegocio' : $('#s_id_unidades').val(),
                    'idSucursal': idSucursal,
                    'fechaInicio' : fechaInicio,
                    'fechaFin' : fechaFin,
                    'idEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt')
                },
                success: function(data){
                salida = "";
                if(data.length>0){

                    for (var i = 0; i < data.length; i++) {
                        actual=data[i];
                        var botonP ='';
                        if(actual.tipo=='Vehiculo'){
                            botonP ='<button type="button" class="btn btn-dark btn-sm preview_poliza" alt="'+actual.id+'"><i class="fa fa-eye" aria-hidden="true"></i> </button>';
                        }
                        var botonDetallle ='';
                        if(actual.tipo!='Otro'){
                            botonDetallle = '<button type="button" class="btn btn-info btn-sm ' + actual.tipo + '" alt="'+actual.id+'" ><i class="fa fa-eye" aria-hidden="true"></i> </button>';
                        }
                        salida += "<tr class='activo_renglon' alt="+actual.id+">";
                        salida += "<td>" + actual.fecha_adquisicion + "</td>";
                        salida += "<td>" + actual.no_serie + "</td>";
                        salida += "<td>" + actual.num_economico + "</td>";
                        salida += "<td>" + actual.imei_gps + "</td>";
                        salida += "<td>" + actual.descripcion + "</td>";
                        salida += "<td>" + actual.valor_adquisicion + "</td>";
                        salida += "<td>" + actual.sucursal + "</td>";
                        salida += "<td>" + actual.propietario + "</td>";
                        salida += "<td style='text-align:right;'>" + actual.tipo + " "+botonDetallle+"</td>";
                        salida += "<td>" + actual.responsable + "</td>";
                        salida += "<td>" + actual.vigencia_poliza + "</td>";
                        salida += "<td>" + botonP + "</td>";
                        salida += "</tr>";
                    }
                    $("#t_registros tbody").html(salida);
                    $('#b_excel').prop('disabled',false);
                }else{
                    $('#b_excel').prop('disabled',true);

                    var html = "<tr><td colspan='12'>No se encontró información</td></tr>";
                    $("#t_registros tbody").html(html);
                }
            
                },
                error: function (data) {
                    console.log('php/activos_fijos_reporte_buscar.php-->'+JSON.stringify(data));
                    mandarMensaje('* Erros al generar la busuqeda de activos fijos');
               
                }
            });
        }

        $('#b_excel').click(function(){
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            var idUnidadNegocio = $('#s_id_unidades').val();

            if($('#s_id_sucursales').val() != null)
            {
                var idSucursal = $('#s_id_sucursales').val();
            }else{
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadNegocio,modulo,idUsuario)
            }     

            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'idEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt')
            };
            
            $("#i_nombre_excel").val('Reporte Activos Fijos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });


        // Mostrar PDF Poliza en Modal


    $(document).on('click','.preview_poliza',function(){
        var id = $(this).attr('alt');
        
        $("#div_archivo").empty();
        $("#div_archivo").val('');
      
        if (id=='' || id==null) {
        //mandarMensaje("No se  Guardado o Seleccionado un Activo");
        }else {
        $("#div_archivo").empty();
        $("#div_archivo").val('');
        var ruta='activosPdf/formato_poliza_'+id+'.pdf';
        var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
        $('#label_pdf').html('Poliza de Seguro PDF')
        $.ajax({
            url:ruta,
            type:'HEAD',
            error: function()
            {
            mandarMensaje('Este activo no contiene archivo PDF guardado');
            },
            success: function()
            {
            $("#div_archivo").empty();
            $("#div_archivo").val('');
            $("#div_archivo").append(fil);
            $('#dialog_archivo').modal('show');
            }
        });
        }
    });

    $(document).on('click','.preview_circulacion',function(){
        var id = $(this).attr('alt');
        // Concatnar id al nombre con clave ejemplo poliza_20, circulacion_20, amortizacion_20
        $("#div_archivo").empty();
        $("#div_archivo").val('');
        id = $('#b_guardar_activo').attr('alt');
        if (id=='' || id==null) {
        mandarMensaje("No se ah Guardado o Seleccionado un Activo");
        }
        else {
        $("#div_archivo").empty();
        $("#div_archivo").val('');
        var ruta='activosPdf/formato_targeta_circulacion_'+id+'.pdf';
        var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
        $('#label_pdf').html('Targeta de Circulacion PDF')
        $.ajax({
            url:ruta,
            type:'HEAD',
            error: function()
            {
            mandarMensaje('Este activo no contiene archivo PDF guardado');
            },
            success: function()
            {
            $("#div_archivo").empty();
            $("#div_archivo").val('');
            $("#div_archivo").append(fil);
            $('#dialog_archivo').modal('show');
            }
        });
        }
    });

$('#r_otro').click(function(){
  $( "#heading_vehiculo" ).hide();
  $( "#collapse_vehiculo" ).hide();
  $( "#heading_celular" ).hide();
  $( "#collapse_celular" ).hide();
  $( "#heading_computo" ).hide();
  $( "#collapse_computo" ).hide();
});
//  Al dar check en vehiculo solo se muestra este acordeon y se limpian las entradas - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$(document).on('click','.Vehiculo',function(){
  var id= $(this).attr('alt');
  $('#b_preview_poliza').attr('alt',id);
  $('#b_preview_circulacion').attr('alt',id);

  $('#dialog_detalle').modal('show');
  // acordeones
  $( "#heading_vehiculo" ).show();
  $("#collapse_vehiculo").css("display", "");
  $( "#heading_celular" ).hide();
  $( "#collapse_celular" ).hide();
  $( "#heading_computo" ).hide();
  $( "#collapse_computo" ).hide();
  // entradas
  $("#collapse_vehiculo").addClass("show");
  $("#collapse_celular").removeClass("show");
  $("#collapse_computo").removeClass("show");
  document.getElementById('s_veh_tipo').selectedIndex = 0;
  $('#i_veh_poliza').val('');
  document.getElementById('s_veh_marca').selectedIndex = 0;
  $('#i_veh_vigencia').val('');
  $('#i_veh_color').val('');
  $('#i_veh_circulacion').val('');
  $('#i_veh_modelo').val('');
  $('#i_veh_vigencia_circulacion').val('');
  $('#i_veh_placas').val('');
  formularioVehiculo(id);
});
// Al dar check en celular solo se muestra este acordeon y se limpian sus entradas - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$(document).on('click','.Celular',function(){
  var id= $(this).attr('alt');
  $('#dialog_detalle').modal('show');
  // acordeones
  $( "#heading_vehiculo" ).hide();
  $( "#collapse_vehiculo" ).hide();
  $( "#heading_celular" ).show();
  $("#collapse_celular").css("display", "");
  $( "#heading_computo" ).hide();
  $( "#collapse_computo" ).hide();
  // entradas
  $("#collapse_celular").addClass("show");
  $("#collapse_computo").removeClass("show");
  $("#collapse_vehiculo").removeClass("show");
  document.getElementById('s_cel_marca').selectedIndex = 0;
  document.getElementById('s_cel_compania').selectedIndex = 0;
  $('#i_cel_modelo').val('');
  $('#i_cel_paquete').val('');
  $('#i_cel_imei').val('');
  $('#i_cel_contrato').val('');
  $('#i_cel_numero').val('');
  $('#i_cel_vigencia_contrato').val('');
  formularioCelular(id);
});
// Al dar check en eq. computo solo se muestra este acordeon y se limpian sus entradas - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$(document).on('click','.Equipo',function(){
    var id= $(this).attr('alt'); 
    $('#dialog_detalle').modal('show'); 
  // acordeones
  $( "#heading_vehiculo" ).hide();
  $( "#collapse_vehiculo" ).hide();
  $( "#heading_celular" ).hide();
  $( "#collapse_celular" ).hide();
  $( "#heading_computo" ).show();
  // entradas
  $("#collapse_computo").css("display", "");
  $("#collapse_computo").addClass("show");
  $("#collapse_celular").removeClass("show");
  $("#collapse_vehiculo").removeClass("show");
  document.getElementById('s_eq_marca').selectedIndex = 0;
  $('#i_eq_modelo').val('');
  $('#i_cargador').val('');
  document.getElementById('s_eq_tipo').selectedIndex = 0;
  $('#i_eq_caracteristicas').val('');
  formularioEqComp(id);
});
// Termina ------------------------------------------------------------------------------------------------------------

    // Busqueda de un Registro y Llenado de Datos Generales y Vehiculo
function formularioVehiculo(id){
  
  $.ajax({
    type: "POST",
    url: "php/activos_tipo_veh_query.php",
    data: {'id':id},
    dataType: 'json',
    success: function(data){
       
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        $('#s_veh_tipo').val(actual.tipo_vehiculo).prop('disabled',true);
        $('#s_veh_marca').val(actual.marca).prop('disabled',true);
        $('#i_veh_color').val(actual.color).prop('disabled',true);
        $('#i_veh_modelo').val(actual.modelo).prop('disabled',true);
        $('#i_veh_placas').val(actual.placas).prop('disabled',true);
        $('#i_veh_vigencia').val(actual.poliza).prop('disabled',true);
        $('#i_veh_vigencia_circulacion').val(actual.circulacion).prop('disabled',true);
        veh = actual.id_veh;
      }

      
    },
    error: function (data){
      console.log("php/activos_tipo_veh_query.php-->"+JSON.stringify(data));  
      mandarMensaje("* Error al buscar detalle de Vehículo");
    }
  });
}
// Busqueda de un Registro y Llenado de Datos Generales y Celular
function formularioCelular(id){
  $.ajax({
    type: "POST",
    url: "php/activos_tipo_cel_query.php",
    data: {'id':id},
    dataType: 'json',
    success: function(data){
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        $('#s_cel_marca').val(actual.marca).prop('disabled',true);
        $('#s_cel_compania').val(actual.compania).prop('disabled',true);
        $('#i_cel_modelo').val(actual.modelo).prop('disabled',true);
        $('#i_cel_paquete').val(actual.paquete).prop('disabled',true);
        $('#i_cel_imei').val(actual.imei).prop('disabled',true);
        $('#i_cel_contrato').val(actual.contrato).prop('disabled',true);
        $('#i_cel_numero').val(actual.telefono).prop('disabled',true);
        $('#i_cel_vigencia_contrato').val(actual.vigencia).prop('disabled',true);
        cel=actual.id_cel;
      }

     
    },
    error: function (data){
        mandarMensaje("* Error al buscar detalle de Celular");
    }
  });
}
// Busqueda de un Registro y Llenado de Datos Generales y Equipo de Computo
function formularioEqComp(id){
 
  $.ajax({
    type: "POST",
    url: "php/activos_tipo_eq_query.php",
    data: {'id':id},
    dataType: 'json',
    success: function(data){
        
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        $('#s_eq_marca').val(actual.marca);
        $('#i_eq_modelo').val(actual.modelo);
        $('#s_eq_tipo').val(actual.tipo_equipo);
        $('#i_cargador').val(actual.serie_cargador);
        $('#i_eq_caracteristicas').val(actual.caracteristicas);
        eq = actual.id_eq
      }
    
    },
    error: function (data){
        mandarMensaje("* Error al buscar detalle de Equipo de Computo");
    }
  });
}

/**
// Acordeon Equipo de Computo ----------------------------------------------------------------------------------------------
// Select Marca Equipo de Computo
**/
function selectMarcaEq(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_MARCAS_ECOMPUTO'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonMarcaEq= "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.marca+"</option>";
        renglonMarcaEq += "<tr>";
        renglonMarcaEq += "<td>"+actual.marca+"</td>";
        renglonMarcaEq += "</tr>";
      }
      $("#s_eq_marca").html(options);
      $("#t_eq_marca").html(renglonMarcaEq);
      return select_tipo_ecomputo();
    },
    error: function (data){
      mandarMensaje('Marcas de Equipos Error 500 ');
    }
  });
}


// Select tipo Equipo de Computo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function select_tipo_ecomputo(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_TIPO_ECOMPUTO'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonTipoEq= "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.tipo+"</option>";
        renglonTipoEq += "<tr>";
        renglonTipoEq += "<td>"+actual.tipo+"</td>";
        renglonTipoEq += "</tr>";
      }
      $("#s_eq_tipo").html(options);
      $("#t_eq_tipo").html(renglonTipoEq);
    },
    error: function (data){
      mandarMensaje('Equipo de computo Error 500 ');
    }
  });
}

// Inicia SELECT_TIPOS_VEHICULO
$( document ).ready(function() {
  return selectMarcasVehiculo(), selectMarcasCelular(), selectMarcaEq()
});

/**
// Acordeon Vehiculo ----------------------------------------------------------------------------------------------
// Select Marca Vehiculo
**/
function selectMarcasVehiculo(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_MARCAS_VEHICULO'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglones2 = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.marcas+"</option>";
        renglones2 += "<tr>";
        renglones2 += "<td>"+actual.marcas+"</td>";
        renglones2 += "</tr>";
      }
      $("#s_veh_marca").html(options);
      // Llenamos tambien la tabla con los datos de los tipos existentes
      $("#t_veh_marca").html(renglones2);
      return select_tipo_vehiculo();
    },
    error: function (data){
      mandarMensaje('Marcas vehiculo Error 500 ');
    }
  });
}


// Select tipo Vehiculo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function select_tipo_vehiculo(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_TIPOS_VEHICULO'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglones = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.tipos+"</option>";
        renglones += "<tr>";
        renglones += "<td>"+actual.tipos+"</td>";
        renglones += "</tr>";
      }
      $("#s_veh_tipo").html(options);
      // Llenamos tambien la tabla con los datos de los tipos existentes
      $("#t_veh_tipo").html(renglones);
    },
    error: function (data){
      mandarMensaje('Tipo Vehiculo Error 500 ');
    }
  });
}

/**
// Acordeon Celulares ----------------------------------------------------------------------------------------------
// Select Marca Celular
**/
function selectMarcasCelular(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_MARCAS_CELULARES'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonMarca = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.marca+"</option>";
        renglonMarca += "<tr>";
        renglonMarca += "<td>"+actual.marca+"</td>";
        renglonMarca += "</tr>";
      }
      $("#s_cel_marca").html(options);
      $("#t_cel_marca").html(renglonMarca);
      return select_companias_celulares();
    },
    error: function (data){
      mandarMensaje('Marcas de celular Error 500 ');
    }
  });
}


// Select compañias celulares  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function select_companias_celulares(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_COMPANIAS_CELULARES'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonCom = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.compania+"</option>";
        renglonCom += "<tr>";
        renglonCom += "<td>"+actual.compania+"</td>";
        renglonCom += "</tr>";
      }
      $("#s_cel_compania").html(options);
      $("#t_cel_compania").html(renglonCom);
    },
    error: function (data){
      mandarMensaje('Compañias celulares Error 500 ');
    }
  });
}

    //-->NJES March/17/2021 agregar filtro empresa fiscal
    $('#b_buscar_empresa_fiscal').click(function()
    {
        $('#i_filtro_empresa_fiscal').val('');
        muestraModalEmpresasFiscales('renglon_empresa_fiscal','t_empresa_fiscal tbody','dialog_empresa_fiscal');
    });

    $('#t_empresa_fiscal').on('click', '.renglon_empresa_fiscal', function() {
        $('#ch_todas_empresas').prop('checked',false);

        var id = $(this).attr('alt');
        var nombre = $(this).attr('alt2');
        var idCFDI = $(this).attr('alt3');
        $('#i_empresa_fiscal').attr('alt',id).attr('alt2',idCFDI).val(nombre);
        $('#dialog_empresa_fiscal').modal('hide');

        if($('#s_id_sucursales').val() != null)
        {
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),$('#s_id_sucursales').val());
        }else{
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
        }
        
    });

    $("#ch_todas_empresas").change(function(){
        if($("#ch_todas_empresas").is(':checked'))
        {
            $('#i_empresa_fiscal').attr('alt','').attr('alt2','').val('');

            if($('#s_id_sucursales').val() != null)
            {
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),$('#s_id_sucursales').val());
            }else{
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }

        }else{
            if($('#s_id_sucursales').val() != null)
            {
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),$('#s_id_sucursales').val());
            }else{
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        }
    });

});

</script>

</html>