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
        overflow-x:hidden;
    }
    .div_contenedor{
        background-color: #ffffff;
    }
    .div_t_registros{
        min-height:310px;
        max-height:310px;
        overflow:auto;
    }
    .tablon {
        font-size: 10px;
    }
    #pantalla_detalle_otros_ingresos,
    #pantalla_detalle_finanzas,
    #pantalla_finanzas_totales{
        position: absolute;
        top:10px;
        left : -101%;
        height: 95%;
    }
    .totales{
        text-align:right;
    }
    .ren_facturado_detalle:hover,
    .ren_verificado_detalle:hover,
    .ren_saldo_facturado_detalle:hover,
    .ren_cobranza_mes_detalle:hover,
    .ren_cobrado_facturado_detalle:hover,
    .ren_otros_ingresos_detalle:hover{
        background-color:rgba(102, 153, 255,.5);
        cursor:pointer;
    }
    .b_verificado:not(.active) > .fa-check-circle {
        display: none;
    }
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        .div_t_registros{
            height:auto;
            overflow:auto;
        }
    }
    
</style>

<body>
    <div><input id="i_id_sucursal" type="hidden"/></div>

    <div class="container-fluid"  id="pantalla_finanzas_totales">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Dashboard De Finanzas</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row form-group">
                            <div class="col-md-7"> 
                                <div class="row">
                                    <label for="s_empresa_fiscal" class="col-md-4 col-form-label">Empresa Fiscal (emisora)</label>
                                    <div class="input-group col-sm-12 col-md-8">
                                        <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="b_buscar_empresa_fiscal" style="margin:0px;">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="ch_todas_empresas" name="ch_todas_empresas" value="" checked> Mostrar todas
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6"> 
                                <div class="row">
                                    <label for="s_id_unidades" class="col-form-label col-md-4">Unidad de Negocio </label>
                                    <div class="col-md-8">
                                        <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <?php
                                    /*solo ciertos usuarios pueden ver el boton
                                        3 - cynthia mora
                                        316 - jessy limas
                                        404 - gabriel curiel
                                        4 - emanuel garcia
                                        32 - paola barraza
                                        237 - despacho contable
                                    */

                                    $permisos = array(3, 316, 404, 4, 32, 237);

                                    if(in_array($_SESSION['id_usuario'], $permisos)){
                                        echo '<input type="checkbox" id="ch_todas" name="ch_todas" value=""> Mostrar todas';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="s_id_sucursales" class="col-form-label col-md-4">Sucursal</label>
                                    <div class="col-md-8">
                                        <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Mes/Año</th>
                                            <th scope="col">Facturado</th>
                                            <th scope="col">Verificado</th>
                                            <th scope="col">Saldo Por Cobrar</th>
                                            <th scope="col">Cobranza del Mes</th>
                                            <th scope="col">Cobrado de lo Facturado</th>
                                            <th scope="col">Otros Ingresos</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_totales">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon">
                                            <tbody>
                                                <tr>
                                                    <th>Totales</th>
                                                    <th data-label="Total Facturado"><input type="text" id="i_t_facturado" name="i_t_facturado" class=" totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th data-label="Total Verificado"><input type="text" id="i_t_verificado" name="i_t_verificado" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th data-label="Total Saldo Por Cobrar"><input type="text" id="i_t_saldo" name="i_t_saldo" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th data-label="Total Cobranza del mes"><input type="text" id="i_t_mes" name="i_t_mes" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th data-label="Total Cobrado de lo facturado"><input type="text" id="i_t_cobrado" name="i_t_cobrado" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div> 
    </div>  <!--pantalla_finanzas_totales-->

    <div class="container-fluid" id="pantalla_detalle_finanzas">
        <div class="row">
            <div class="col-md-12 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Dashboard De Finanzas</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar1"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                    <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-5 div_empresa_fiscal"></div>
                                    <div class="col-md-3 div_fecha"></div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel2" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5" id="div_unidad"></div>
                                    <div class="col-md-5" id="div_sucursal"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12" id="div_filtros">
                                <table class="tablon">
                                    <tbody>
                                        <tr>
                                            <th class="unidad_hide"></th>
                                            <th class="sucursal_hide"></th>
                                            <th><input type="text" name="i_filtro_emisor" id="i_filtro_1" alt="filtro_emisor" alt2="1" alt3="renglon_registros_d" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Emisor" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_receptor" id="i_filtro_2" alt="filtro_receptor" alt2="2" alt3="renglon_registros_d" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Receptor" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_folio" id="i_filtro_3" alt="filtro_folio" alt2="3" alt3="renglon_registros_d" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Folio" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_uuid" id="i_filtro_4" alt="filtro_uuid" alt2="4" alt3="renglon_registros_d" alt4="4" class="filtrar_campos_renglones form-control" placeholder="UUID" autocomplete="off"></th>
                                            <th colspan="8"></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col" class="unidad_hide">Unidad de Negocio</th>
                                            <th scope="col" class="sucursal_hide">Sucursal</th>
                                            <th scope="col">Emisor</th>
                                            <th scope="col">Receptor</th>
                                            <th scope="col">Folio</th>
                                            <th scope="col">UUID</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Feha de Vencimiento</th>
                                            <th scope="col">Días de Vencimiento</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col">Facturado</th>
                                            <th scope="col">Cobrado</th>
                                            <th scope="col">Nota de Credito</th>
                                            <th scope="col">Saldo</th>
                                            <th scope="col" class="fecha_aplicacion" style="display:none;">Fecha Aplicación Pago</th>
                                            <th scope="col">Verificado</th>
                                            <th width="1%"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_detalle">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon">
                                            <tbody>
                                                <tr>
                                                    <th class="unidad_hide"></th>
                                                    <th class="sucursal_hide"></th>
                                                    <th id="th_totales" colspan="5"></th>
                                                    <th>Totales</th>
                                                    <th data-label="Subtotal"><input type="text" id="i_subtotal_facturado" name="i_subtotal_facturado" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th data-label="Total Facturado"><input type="text" id="i_total_facturado" name="i_total_facturado" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th data-label="Total Cobrado"><input type="text" id="i_total_cobrado" name="i_total_cobrado" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th data-label="Total Saldo"><input type="text" id="i_total_saldo" name="i_total_saldo" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th colspan="2"></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div> 
    </div>  <!--pantalla_detalle_finanzas-->

    <div class="container-fluid" id="pantalla_detalle_otros_ingresos">
        <div class="row">
            <div class="col-md-12 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Dashboard De Finanzas</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar2"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                    <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-5 div_empresa_fiscal"></div>
                                    <div class="col-md-3 div_fecha"></div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel3" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5" id="div_unidad_oi"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <tbody>
                                        <tr>
                                            <th class="unidad_hide"></th>
                                            <th><input type="text" name="i_filtro_sucursal_oi" id="i_filtro_io_1" alt="filtro_sucursal_oi" alt2="1" alt3="renglon_registros_d_oi" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Sucursal" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_cliente_oi" id="i_filtro_io_2" alt="filtro_cliente_oi" alt2="2" alt3="renglon_registros_d_oi" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Cliente" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_folio_oi" id="i_filtro_io_3" alt="filtro_folio_oi" alt2="3" alt3="renglon_registros_d_oi" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Folio" autocomplete="off"></th>
                                            <th><input type="text" name="i_filtro_tipo_oi" id="i_filtro_io_4" alt="filtro_tipo_oi" alt2="4" alt3="renglon_registros_d_oi" alt4="4" class="filtrar_campos_renglones form-control" placeholder="Tipo" autocomplete="off"></th>
                                            <th colspan="3"></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col" class="unidad_hide">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Folio</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_detalle_otros_ingresos">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon">
                                            <tbody>
                                                <tr>
                                                    <th class="unidad_hide"></th>
                                                    <th></th>
                                                    <th id="th_totales" colspan="4"></th>
                                                    <th>Totales</th>
                                                    <th data-label="Subtotal"><input type="text" id="i_subtotal_otros_ingresos" name="i_subtotal_otros_ingresos" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                    <th data-label="Total"><input type="text" id="i_total_otros_ingresos" name="i_total_otros_ingresos" class="totales form-control form-control-sm" autocomplete="off" readonly></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div> 
    </div>  <!--pantalla_detalle_otros_ingresos-->
    
    <form id="f_imprimir_excel" action="php/excel_genera_dash.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>

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
    
</body>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='DASH_FINANZAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var renglonExcel = '';
    var verificadoExcel = '';

    var fecha = '';

    $(function()
    {

        console.log('ffjfjfjfjfjf');

        $('.unidad_hide').hide();
        $('.sucursal_hide').hide();

        $("#pantalla_finanzas_totales").css({left : "0%"});

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

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

        //mostrarRegistrosTotales(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
        mostrarRegistrosTotales(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario),'');

        $('#b_buscar_empresa_fiscal').click(function()
        {
            $('#i_filtro_empresa_fiscal').val('');
            muestraModalEmpresasFiscales('renglon_empresa_fiscal','t_empresa_fiscal tbody','dialog_empresa_fiscal');
        });

        $('#t_empresa_fiscal').on('click', '.renglon_empresa_fiscal', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var idCFDI = $(this).attr('alt3');
            $('#i_empresa_fiscal').attr('alt',id).attr('alt2',idCFDI).val(nombre);
            $('#dialog_empresa_fiscal').modal('hide');
            $('#ch_todas_empresas').prop('checked',false);

            if($("#ch_todas").is(':checked'))
            {
                mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),id);
            }else{
                if($('#s_id_sucursales').val() >= 1)
                {
                    mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),id);
                }else{
                    mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),id);
                }
            }
        });

        $('#s_id_unidades').change(function(){
            $('#ch_todas').prop('checked',false)
            muestraSucursalesPermiso('s_id_sucursales',$('#s_id_unidades').val(),modulo,idUsuario);
            $('#s_id_sucursales').prop('disabled',false);

            if($('#i_empresa_fiscal').val()!='' || $("#ch_todas_empresas").is(':checked'))
            {
                if($("#ch_todas_empresas").is(':checked'))
                {
                    //mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
                    mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),'');
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                    mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),idEmpresaFiscal);
                }                
            }else{
                mandarMensaje('Selecciona una empresa fiscal');
                $('#t_registros_totales tbody').html('');
            }
            
        });

        $('#s_id_sucursales').change(function(){
            if($('#s_id_sucursales').val() >= 1)
            {
                if($("#ch_todas_empresas").is(':checked'))
                {
                    //mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),muestraIdsEmpresasFiscalesTodas());
                    mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),'');
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                    mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),idEmpresaFiscal);
                }  

                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0">Mostrar Todas</option>');
            }else{
                if($("#ch_todas_empresas").is(':checked'))
                {
                    //mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
                    mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),'');
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                    mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),idEmpresaFiscal);
                } 

                $('#s_id_sucursales').find('option[value="0"]').remove();
                $('#s_id_sucursales').append('<option value="0" selected>Mostrar Todas</option>');
            }
        });

        $('#ch_todas').change(function(){
            if($("#ch_todas").is(':checked'))
            {
                $('#s_id_unidades').val('').select2({placeholder: 'Selecciona',
                                                    templateResult: setCurrency,
                                                    templateSelection: setCurrency});
                $('#s_id_sucursales').val('').select2({placeholder: ''}).prop('disabled',true);

                if($("#ch_todas_empresas").is(':checked'))
                {
                    //mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
                    mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),'');
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                    mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),idEmpresaFiscal);
                }
            }else{
                muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
                $('#s_id_sucursales').val('').select2({placeholder: 'Elige una Sucursal'}).prop('disabled',false);
                
                if($("#ch_todas_empresas").is(':checked'))
                {
                    //mostrarRegistrosTotales(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
                    mostrarRegistrosTotales(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario),'');
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                    mostrarRegistrosTotales(idUnidadActual,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario),idEmpresaFiscal);
                }
            }
        });

        $('#ch_todas_empresas').change(function(){
            if($("#ch_todas_empresas").is(':checked'))
            {
                $('#b_buscar_empresa_fiscal').prop('disabled',true);
                $('#i_empresa_fiscal').attr('alt','').attr('alt2','').val('');
                
                if($("#ch_todas").is(':checked'))
                {
                    //mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
                    mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),'');
                }else{
                    if($('#s_id_sucursales').val() >= 1)
                    {
                        //mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),muestraIdsEmpresasFiscalesTodas());
                        mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),'');
                    }else{
                        //mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
                        mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),'');
                    }
                }
            }else{
                $('#b_buscar_empresa_fiscal').prop('disabled',false);
                if($('#i_empresa_fiscal').val()!='')
                {
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');

                    if($("#ch_todas").is(':checked'))
                    {
                        mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),idEmpresaFiscal);
                    }else{
                        if($('#s_id_sucursales').val() >= 1)
                        {
                            mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),idEmpresaFiscal);
                        }else{
                            mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),idEmpresaFiscal);
                        }
                    }
                }else{
                    mandarMensaje('Selecciona una empresa fiscal');
                    $('#t_registros_totales tbody').html('');
                }
            }
        });

        $('#b_regresar1').click(function(){
            if($("#ch_todas").is(':checked'))
            {
                if($("#ch_todas_empresas").is(':checked'))
                {
                    //mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
                    mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),'');
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                    mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),idEmpresaFiscal);
                }
            }else{
                if($("#ch_todas_empresas").is(':checked'))
                {
                    if($('#s_id_sucursales').val() >= 1)
                    {
                        //mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),muestraIdsEmpresasFiscalesTodas());
                        mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),'');
                    }else{
                        //mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),muestraIdsEmpresasFiscalesTodas());
                        mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),'');
                    }
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');

                    if($('#s_id_sucursales').val() >= 1)
                    {
                        mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),idEmpresaFiscal);
                    }else{
                        mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),idEmpresaFiscal);
                    }
                }
            }

            $("#pantalla_detalle_finanzas").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_finanzas_totales').animate({left : "0%"}, 600, 'swing');
        });

        function mostrarRegistrosTotales(idUnidadNegocio,idSucursal,idEmpresaFiscal){
            //--> 1= totales    2=detalle
            $('#t_registros_totales tbody').html('');
            $('#t_registros_totales tbody').empty();
            $('#i_t_facturado,#i_t_verificado,#i_t_saldo,#i_t_mes,#i_t_cobrado').val('');
            
            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'idEmpresaFiscal':idEmpresaFiscal,
                'tipo':1
            };

            var totalFacturado=0;
            var totalVerificado=0;
            var totalSaldo=0;
            var totalMes=0;
            var totalCobrado=0;
           
            $.ajax({
                type: 'POST',
                url: 'php/dash_finanzas_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros" mes="'+data[i].mes+'" anio="'+data[i].anio+'" fecha="'+data[i].anio+'-'+data[i].mes+'" unidad="'+idUnidadNegocio+'" sucursal="'+idSucursal+'" empresa="'+idEmpresaFiscal+'">\
                                        <td data-label="Mes/Año">'+data[i].fecha+'</td>\
                                        <td data-label="Facturado" class="ren_facturado_detalle">'+formatearNumero(data[i].facturado)+'</td>\
                                        <td data-label="Verificado" class="ren_verificado_detalle">'+formatearNumero(data[i].verificado)+'</td>\
                                        <td data-label="Saldo Por Cobrar" class="ren_saldo_facturado_detalle">'+formatearNumero(data[i].saldo_facturado)+'</td>\
                                        <td data-label="Cobranza del Mes" class="ren_cobranza_mes_detalle">'+formatearNumero(data[i].cobranza_mes)+'</td>\
                                        <td data-label="Cobrado de lo Facturado" class="ren_cobrado_facturado_detalle">'+formatearNumero(data[i].cobrado_facturado)+'</td>\
                                        <td data-label="Otros Ingresos" class="ren_otros_ingresos_detalle">'+formatearNumero(data[i].total_otros_ingresos)+'</td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_totales tbody').append(html);   
                            
                            totalFacturado=totalFacturado+(parseFloat(data[i].facturado));
                            totalVerificado=totalVerificado+(parseFloat(data[i].verificado));
                            totalSaldo=totalSaldo+(parseFloat(data[i].saldo_facturado));
                            totalMes=totalMes+(parseFloat(data[i].cobranza_mes));
                            totalCobrado=totalCobrado+(parseFloat(data[i].cobrado_facturado));
                        }

                        $('#i_t_facturado').val(formatearNumero(totalFacturado));
                        $('#i_t_verificado').val(formatearNumero(totalVerificado));
                        $('#i_t_saldo').val(formatearNumero(totalSaldo));
                        $('#i_t_mes').val(formatearNumero(totalMes));
                        $('#i_t_cobrado').val(formatearNumero(totalCobrado));

                        $('#b_excel').prop('disabled',false);

                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_totales tbody').append(html);

                        $('#b_excel').prop('disabled',true);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/dash_finanzas_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de totales Dashboard de Finanzas');
                }
            });
        }

        $(document).on('click','#t_registros_totales .ren_facturado_detalle',function()
        {

            // verificando

            fecha = $(this).parent().attr('fecha');
            var idUnidadNegocio = $(this).parent().attr('unidad');
            var idSucursal = $(this).parent().attr('sucursal');
            var idEmpresaFiscal = $(this).parent().attr('empresa');
            var tipoRenglon = 'facturado';
            var anio = $(this).parent().attr('anio');
            var mes = $(this).parent().attr('mes');
            renglonExcel = tipoRenglon;
            verificadoExcel = '';

            console.log('I ' + tipoRenglon); // este de aqui
            mostrarRegistrosDetalle(idUnidadNegocio,idSucursal,idEmpresaFiscal,fecha,anio,mes,tipoRenglon,'','');

            $("#pantalla_finanzas_totales").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_finanzas').animate({left : "0%"}, 600, 'swing');

        });

        $(document).on('click','#t_registros_totales .ren_verificado_detalle',function(){
            fecha = $(this).parent().attr('fecha');
            var idUnidadNegocio = $(this).parent().attr('unidad');
            var idSucursal = $(this).parent().attr('sucursal');
            var idEmpresaFiscal = $(this).parent().attr('empresa');
            var tipoRenglon = 'facturado';
            var anio = $(this).parent().attr('anio');
            var mes = $(this).parent().attr('mes');
            renglonExcel = tipoRenglon;
            verificadoExcel = 'S';

            console.log('II ' + tipoRenglon);


            mostrarRegistrosDetalle(idUnidadNegocio,idSucursal,idEmpresaFiscal,fecha,anio,mes,tipoRenglon,'S','');

            $("#pantalla_finanzas_totales").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_finanzas').animate({left : "0%"}, 600, 'swing');
        });

        $(document).on('click','#t_registros_totales .ren_saldo_facturado_detalle',function(){
            fecha = $(this).parent().attr('fecha');
            var idUnidadNegocio = $(this).parent().attr('unidad');
            var idSucursal = $(this).parent().attr('sucursal');
            var idEmpresaFiscal = $(this).parent().attr('empresa');
            var tipoRenglon = 'facturado';
            var anio = $(this).parent().attr('anio');
            var mes = $(this).parent().attr('mes');
            renglonExcel = tipoRenglon;
            verificadoExcel = '';

            console.log('III ' + tipoRenglon);

            mostrarRegistrosDetalle(idUnidadNegocio,idSucursal,idEmpresaFiscal,fecha,anio,mes,tipoRenglon,'','');

            $("#pantalla_finanzas_totales").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_finanzas').animate({left : "0%"}, 600, 'swing');
        });

        $(document).on('click','#t_registros_totales .ren_cobranza_mes_detalle',function(){
            
            fecha = $(this).parent().attr('fecha');
            var idUnidadNegocio = $(this).parent().attr('unidad');
            var idSucursal = $(this).parent().attr('sucursal');
            var idEmpresaFiscal = $(this).parent().attr('empresa');
            var tipoRenglon = 'cobranza_mes';
            var anio = $(this).parent().attr('anio');
            var mes = $(this).parent().attr('mes');
            renglonExcel = tipoRenglon;
            verificadoExcel = '';

            console.log('IV ' + tipoRenglon);

            mostrarRegistrosDetalle(idUnidadNegocio,idSucursal,idEmpresaFiscal,fecha,anio,mes,tipoRenglon,'','');

            $("#pantalla_finanzas_totales").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_finanzas').animate({left : "0%"}, 600, 'swing');
        });

        $(document).on('click','#t_registros_totales .ren_cobrado_facturado_detalle',function(){
            fecha = $(this).parent().attr('fecha');
            
            var idUnidadNegocio = $(this).parent().attr('unidad');
            var idSucursal = $(this).parent().attr('sucursal');
            var idEmpresaFiscal = $(this).parent().attr('empresa');
            var tipoRenglon = 'facturado';
            var anio = $(this).parent().attr('anio');
            var mes = $(this).parent().attr('mes');
            renglonExcel = tipoRenglon;
            verificadoExcel = '';

            //console.log(tipoRenglon);
            // verificando verificando
            console.log('V ' + tipoRenglon);
            mostrarRegistrosDetalle(idUnidadNegocio,idSucursal,idEmpresaFiscal,fecha,anio,mes,tipoRenglon,'','fecha_aplicacion');

            $("#pantalla_finanzas_totales").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_finanzas').animate({left : "0%"}, 600, 'swing');

        });

        function mostrarRegistrosDetalle(idUnidadNegocio,idSucursal,idEmpresaFiscal,fecha,anio,mes,tipoRenglon,verificado,campo)
        {
            //--> 1= totales    2=detalle
            $('#t_registros_detalle tbody').html('');
            $('#i_subtotal_facturado,#i_total_facturado,#i_total_cobrado,#i_total_saldo').val('');

            if(campo == '')
            {
                $('.fecha_aplicacion').css('display','none');
                $('#b_excel2').attr('fecha_applicacion',0);
            }else{
                $('.fecha_aplicacion').css('display','block');
                $('#b_excel2').attr('fecha_applicacion',1);
            }
            
            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'fecha':fecha,
                'tipoRenglon':tipoRenglon,
                'idEmpresaFiscal':idEmpresaFiscal,
                'tipo':2,
                'verificado':verificado
            };

            var totalFacturado=0;
            var totalCobrado=0;
            var totalSaldo=0;
            var totalSubtotal=0;
           
            $.ajax({
                type: 'POST',
                url: 'php/dash_finanzas_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {

                    //console.log(data);

                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){

                            if(data[i].estatus=='C')
                                var cancelada = 'style="background-color:#ffe6e6;"';
                            else
                                var cancelada = '';

                            if(data[i].verificado == 'N')
                            {
                                var activadoN = 'active';
                                var activadoS = '';
                            }else{
                                var activadoN = '';
                                var activadoS = 'active';
                            }

                            if(idUnidadNegocio != '')
                            {
                                var res = idUnidadNegocio.substr(0, 1);
                                if(res == ',')
                                {
                                    var columnaUnidad = '<td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>';
                                }else{ 
                                    var columnaUnidad = '';
                                }
                            }

                            if(idSucursal != '')
                            {
                                var res = idSucursal.substr(0, 1);
                                if(res == ',')
                                {
                                    var columaSucursal = '<td data-label="Sucursal">'+data[i].sucursal+'</td>';
                                }else{ 
                                    var columaSucursal = '';
                                }
                            }

                            if(tipoRenglon != 'facturado')
                            {
                                if(data[i].id_cxc == 0)
                                {
                                    var columnaVerificado = '<div class="btn-group" data-toggle="buttons">\
                                                    <label class="b_verificado  btn btn-sm btn-primary '+activadoN+'"><input alt="'+data[i].id+'" type="radio" name="radio_verificado" value="N" autocomplete="off" checked><i class="fa fa-check-circle" aria-hidden="true"></i> N</label>\
                                                    <label class="b_verificado btn btn-sm btn-primary '+activadoS+'"><input alt="'+data[i].id+'" type="radio" name="radio_verificado" value="S" autocomplete="off"><i class="fa fa-check-circle" aria-hidden="true"></i> S</label>\
                                                </div>';
                                }else{
                                    var columnaVerificado = '';
                                }
                            }else{
                                var columnaVerificado = '<div class="btn-group" data-toggle="buttons">\
                                                <label class="b_verificado  btn btn-sm btn-primary '+activadoN+'"><input alt="'+data[i].id+'" type="radio" name="radio_verificado" value="N" autocomplete="off" checked><i class="fa fa-check-circle" aria-hidden="true"></i> N</label>\
                                                <label class="b_verificado btn btn-sm btn-primary '+activadoS+'"><input alt="'+data[i].id+'" type="radio" name="radio_verificado" value="S" autocomplete="off"><i class="fa fa-check-circle" aria-hidden="true"></i> S</label>\
                                            </div>';
                            }
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros_d" '+cancelada+'>'+columnaUnidad+' '+columaSucursal+'\
                                        <td data-label="Emisor" class="filtro_emisor">'+data[i].emisor+'</td>\
                                        <td data-label="Receptor" class="filtro_receptor">'+data[i].receptor+'</td>\
                                        <td data-label="Folio" class="filtro_folio">'+data[i].folio+'</td>\
                                        <td data-label="UUID" class="filtro_uuid">'+data[i].uuid+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Fecha de Vencimiento">'+data[i].fecha_vencimiento+'</td>\
                                        <td data-label="Días de Vencimiento">'+data[i].dias_vencimiento+'</td>\
                                        <td data-label="Subtotal">'+formatearNumero(data[i].subtotal)+'</td>\
                                        <td data-label="Facturado">'+formatearNumero(data[i].facturado)+'</td>\
                                        <td data-label="Cobrado">'+formatearNumero(data[i].cobrado_facturado)+'</td>\
                                        <td data-label="Nota de Crédito">'+formatearNumero(data[i].notas_credito)+'</td>\
                                        <td data-label="Saldo">'+formatearNumero(data[i].saldo_facturado)+'</td>\
                                        <td data-label="Fecha Aplicación Pago" class="fecha_aplicacion">'+data[i].fecha_aplicacion_pago+'</td>\
                                        <td data-label="Verificado">'+columnaVerificado+'</td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_detalle tbody').append(html);   
                            
                            totalSubtotal=totalSubtotal+(parseFloat(data[i].subtotal));
                            totalFacturado=totalFacturado+(parseFloat(data[i].facturado));
                            totalCobrado=totalCobrado+(parseFloat(data[i].cobrado_facturado));
                            totalSaldo=totalSaldo+(parseFloat(data[i].saldo_facturado));
                        }

                        if(campo == '')
                            $('.fecha_aplicacion').css('display','none');
                        else
                            $('.fecha_aplicacion').css('display','block');

                        $('#i_subtotal_facturado').val(formatearNumero(totalSubtotal));
                        $('#i_total_facturado').val(formatearNumero(totalFacturado));
                        $('#i_total_cobrado').val(formatearNumero(totalCobrado));
                        $('#i_total_saldo').val(formatearNumero(totalSaldo));

                        $('#b_excel2').prop('disabled',false);

                    }else{
                        var html='<tr class="renglon_registros_d">\
                                        <td colspan="15">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_detalle tbody').append(html);

                    }

                },
                error: function (xhr) 
                {
                    console.log('php/dash_finanzas_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Detalle Dash Gastos');
                }
            });

            if(idUnidadNegocio != '')
            {
                var res = idUnidadNegocio.substr(0, 1);
                if(res == ',')
                {
                    $(document).find('.unidad_hide').each(function(){
                        $(this).show();
                    });
                    $('#div_unidad').text('');
                }else{ 
                    $(document).find('.unidad_hide').each(function(){
                        $(this).hide();
                    });
                    $('#div_unidad').text('Unidad de Negocio: '+$('#s_id_unidades option:selected').text());
                }
            }

            if(idSucursal != '')
            {
                var res = idSucursal.substr(0, 1);
                if(res == ',')
                {
                    $(document).find('.sucursal_hide').each(function(){
                        $(this).show();
                    });

                    $('#div_sucursal').text('');
                }else{ 
                    $(document).find('.sucursal_hide').each(function(){
                        $(this).hide();
                    });
                    $('#div_sucursal').text('Sucursal: '+$('#s_id_sucursales option:selected').text());
                }
            }

            var mes_letra = '';

            switch(mes){
                case '01':
                    mes_letra = 'Enero';
                break;
                case '02':
                    mes_letra = 'Febrero';
                break;
                case '03':
                    mes_letra = 'Marzo';
                break;
                case '04':
                    mes_letra = 'Abril';
                break;
                case '05':
                    mes_letra = 'Mayo';
                break;
                case '06':
                    mes_letra = 'Junio';
                break;
                case '07':
                    mes_letra = 'Julio';
                break;
                case '08':
                    mes_letra = 'Agosto';
                break;
                case '09':
                    mes_letra = 'Septiembre';
                break;
                case '10':
                    mes_letra = 'Octubre';
                break;
                case '11':
                    mes_letra = 'Noviembre';
                break;
                default:
                    mes_letra = 'Diciembre';
                break;
            }

            $('.div_fecha').text(mes_letra+' '+anio);
            
        }

        $(document).on('change','#t_registros_detalle input[name=radio_verificado]',function(){
            var idFactura = $(this).attr('alt');
            var valor = $(this).val();

            guardaVerificado(idFactura,valor);
        });

        function guardaVerificado(idFactura,valor){
            var info = {
                'idFactura':idFactura,
                'valor':valor
            };

            $.ajax({
                type: 'POST',
                url: 'php/dash_finanzas_guardar_verificado.php',
                data:  {'datos':info},
                success: function(data) {
                    if(data == 0)
                        mandarMensaje(' Error al verificar.');
                },
                error: function (xhr) 
                {
                    console.log('php/dash_finanzas_guardar_verificado.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al verificar.');
                }
            });
        }

        $('#b_excel').click(function(){

            console.log('***********');

            if($("#ch_todas").is(':checked'))
            {
                var idUnidadNegocio = listaUnidadesNegocioId(matriz);
                var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario);

                if($("#ch_todas_empresas").is(':checked'))
                {
                    var idEmpresaFiscal = '';
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                }
            }else{

                var idUnidadNegocio = $('#s_id_unidades').val();
                if($('#s_id_sucursales').val() >= 1)
                {
                    var idSucursal = $('#s_id_sucursales').val();
                }else{
                    var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario)
                }
                
                if($("#ch_todas_empresas").is(':checked'))
                {
                    var idEmpresaFiscal = '';
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                }
            }

            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'idEmpresaFiscal':idEmpresaFiscal,
                'tipo':1
            };

            $("#i_nombre_excel").val('Dash Finanzas');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('DASH_FINANZAS');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel2').click(function()
        {

            console.log('**A****'); // verificando verificando verificando

            if($("#ch_todas").is(':checked'))
            {
                var idUnidadNegocio = listaUnidadesNegocioId(matriz);
                var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario);

                if($("#ch_todas_empresas").is(':checked'))
                {
                    var idEmpresaFiscal = '';
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                }
            }else{

                var idUnidadNegocio = $('#s_id_unidades').val();
                if($('#s_id_sucursales').val() >= 1)
                {
                    var idSucursal = $('#s_id_sucursales').val();
                }else{
                    var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario)
                }
                
                if($("#ch_todas_empresas").is(':checked'))
                {
                    var idEmpresaFiscal = '';
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                }
            }

            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'fecha':fecha,
                'tipoRenglon':renglonExcel,
                'idEmpresaFiscal':idEmpresaFiscal,
                'tipo':2,
                'verificado':verificadoExcel,
                'campo_fecha_aplicacion':$('#b_excel2').attr('fecha_applicacion')
            };

            console.log(JSON.stringify(datos));

            $("#i_nombre_excel").val('Dash Finanzas Detalle');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('DASH_FINANZAS');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $(document).on('click','#t_registros_totales .ren_otros_ingresos_detalle',function(){
            fecha = $(this).parent().attr('fecha');
            
            var idUnidadNegocio = $(this).parent().attr('unidad');
            var idSucursal = $(this).parent().attr('sucursal');
            var idEmpresaFiscal = $(this).parent().attr('empresa');
            var anio = $(this).parent().attr('anio');
            var mes = $(this).parent().attr('mes');

            mostrarDetalleOtrosIngresos(idUnidadNegocio,idSucursal,idEmpresaFiscal,fecha,anio,mes);

            $("#pantalla_finanzas_totales").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_otros_ingresos').animate({left : "0%"}, 600, 'swing');
        });

        function mostrarDetalleOtrosIngresos(idUnidadNegocio,idSucursal,idEmpresaFiscal,fecha,anio,mes)
        {
            $('#t_registros_detalle_otros_ingresos tbody').html('');
            $('#i_subtotal_otros_ingresos').val('');
            
            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'fecha':fecha,
                'idEmpresaFiscal':idEmpresaFiscal
            };
            //console.log(JSON.stringify(datos));

            var totalSubtotal=0;
            var total=0;
           
            $.ajax({
                type: 'POST',
                url: 'php/dash_finanzas_detalle_otros_ingresos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {

                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){

                            if(data[i].estatus=='C')
                                var cancelada = 'style="background-color:#ffe6e6;"';
                            else
                                var cancelada = '';

                            if(idUnidadNegocio != '')
                            {
                                var res = idUnidadNegocio.substr(0, 1);
                                if(res == ',')
                                {
                                    var columnaUnidad = '<td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>';
                                }else{ 
                                    var columnaUnidad = '';
                                }
                            }
                        
                            var html='<tr class="renglon_registros_d_oi" '+cancelada+'>'+columnaUnidad+'\
                                        <td data-label="Sucursal" class="filtro_sucursal_oi">'+data[i].sucursal+'</td>\
                                        <td data-label="Cliente" class="filtro_cliente_oi">'+data[i].cliente+'</td>\
                                        <td data-label="Folio" class="filtro_folio_oi">'+data[i].folio+'</td>\
                                        <td data-label="tipo" class="filtro_tipo_oi">'+data[i].tipo+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Subtotal">'+formatearNumero(data[i].subtotal)+'</td>\
                                        <td data-label="Total">'+formatearNumero(data[i].total_otros_ingresos)+'</td>\
                                        </tr>';
                            $('#t_registros_detalle_otros_ingresos tbody').append(html);   
                            
                            totalSubtotal=totalSubtotal+(parseFloat(data[i].total_otros_ingresos));
                            total=total+(parseFloat(data[i].subtotal));
                        }

                        $('#i_subtotal_otros_ingresos').val(formatearNumero(total));
                        $('#i_total_otros_ingresos').val(formatearNumero(totalSubtotal));

                        $('#b_excel3').prop('disabled',false);

                    }else{
                        var html='<tr class="renglon_registros_d_oi">\
                                        <td colspan="8">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_detalle_otros_ingresos tbody').append(html);

                    }

                },
                error: function (xhr) 
                {
                    console.log('php/dash_finanzas_detalle_otros_ingresos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Detalle Dash Gastos');
                }
            });

            if(idUnidadNegocio != '')
            {
                var res = idUnidadNegocio.substr(0, 1);
                if(res == ',')
                {
                    $(document).find('.unidad_hide').each(function(){
                        $(this).show();
                    });
                    $('#div_unidad_oi').text('');
                }else{ 
                    $(document).find('.unidad_hide').each(function(){
                        $(this).hide();
                    });
                    $('#div_unidad_oi').text('Unidad de Negocio: '+$('#s_id_unidades option:selected').text());
                }
            }

            var mes_letra = '';

            switch(mes){
                case '01':
                    mes_letra = 'Enero';
                break;
                case '02':
                    mes_letra = 'Febrero';
                break;
                case '03':
                    mes_letra = 'Marzo';
                break;
                case '04':
                    mes_letra = 'Abril';
                break;
                case '05':
                    mes_letra = 'Mayo';
                break;
                case '06':
                    mes_letra = 'Junio';
                break;
                case '07':
                    mes_letra = 'Julio';
                break;
                case '08':
                    mes_letra = 'Agosto';
                break;
                case '09':
                    mes_letra = 'Septiembre';
                break;
                case '10':
                    mes_letra = 'Octubre';
                break;
                case '11':
                    mes_letra = 'Noviembre';
                break;
                default:
                    mes_letra = 'Diciembre';
                break;
            }

            $('.div_fecha').text(mes_letra+' '+anio);
            
        }

        $('#b_regresar2').click(function(){
            if($("#ch_todas").is(':checked'))
            {
                if($("#ch_todas_empresas").is(':checked'))
                {
                    mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),'');
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                    mostrarRegistrosTotales(listaUnidadesNegocioId(matriz),muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario),idEmpresaFiscal);
                }
            }else{
                if($("#ch_todas_empresas").is(':checked'))
                {
                    if($('#s_id_sucursales').val() >= 1)
                    {
                        mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),'');
                    }else{
                        mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),'');
                    }
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');

                    if($('#s_id_sucursales').val() >= 1)
                    {
                        mostrarRegistrosTotales($('#s_id_unidades').val(),$('#s_id_sucursales').val(),idEmpresaFiscal);
                    }else{
                        mostrarRegistrosTotales($('#s_id_unidades').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario),idEmpresaFiscal);
                    }
                }
            }

            $("#pantalla_detalle_otros_ingresos").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_finanzas_totales').animate({left : "0%"}, 600, 'swing');
        });

        $('#b_excel3').click(function(){
            if($("#ch_todas").is(':checked'))
            {
                var idUnidadNegocio = listaUnidadesNegocioId(matriz);
                var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario);

                if($("#ch_todas_empresas").is(':checked'))
                {
                    var idEmpresaFiscal = '';
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                }
            }else{

                var idUnidadNegocio = $('#s_id_unidades').val();
                if($('#s_id_sucursales').val() >= 1)
                {
                    var idSucursal = $('#s_id_sucursales').val();
                }else{
                    var idSucursal = muestraSucursalesPermisoListaId(listaUnidadesNegocioId(matriz),modulo,idUsuario)
                }
                
                if($("#ch_todas_empresas").is(':checked'))
                {
                    var idEmpresaFiscal = '';
                }else{
                    var idEmpresaFiscal = $('#i_empresa_fiscal').attr('alt');
                }
            }

            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal,
                'fecha':fecha,
                'idEmpresaFiscal':idEmpresaFiscal
            };

            //console.log(JSON.stringify(datos));

            $("#i_nombre_excel").val('Dash Finanzas Detalle Otros Ingresos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('DASH_FINANZAS_OTROS_INGRESOS');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>