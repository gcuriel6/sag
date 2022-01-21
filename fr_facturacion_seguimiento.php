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

    #fondo_cargando {
        position: absolute;
        top: 1%;
        background-image:url('imagenes/3.svg');

        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:3%;
        border-radius: 5px;
        z-index:2;
        display:none;
    }

    body{
        background-color:rgb(238,238,238);
    }
    .div_contenedor{
        background-color: #ffffff;
    }
    #div_t_opciones{
        max-height:150px;
        min-height:150px;
        overflow-y:auto;
        border: 1px solid #ddd;
        overflow-x:hidden;
    }
    #div_t_facturas{
        max-height:200px;
        min-height:200px;
        overflow-y:auto;
        border: 1px solid #ddd;
        overflow-x:hidden;
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
    .boton_eliminar{
        width:50px;
    }
    #div_radio_iva{
        padding-top:38px;
    }
    #div_principal,
    #div_operaciones{
        position: absolute;
        top:10px;
        left : -101%;
        height: 95%;
    }
    #div_b_timbrar,.secundarios,#div_b_verificar_estatus,#div_b_descargar_acuse{
        display:none;
    }

    .border_gris{
        border-right:6px solid #f8f8f8;
    }
    .borde_rojo{
        border-right:6px solid #ff8c66;
    }
    .borde_amarillo{
        border-right:6px solid #ffff99;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_facturas,#div_t_opciones{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
        .boton_eliminar{
            width:100%;
        }
        #div_radio_iva{
            padding-top:10px;
        }
    }
    
</style>

<body>
<div class="container-fluid" id="div_principal">
        <div class="row">
            <div class="col-md-12 div_contenedor">

            <br>

                <div class="form-group row">
                    <div class="col-sm-12 col-md-2">
                        <div class="titulo_ban">Facturación</div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">

                        <div class="card-header badge-secondary" role="tab" id="heading_semana">
                          <h4 class="mb-0">
                            <a id="link_semana" class="collapsed" data-toggle="collapse" href="#collapse_semana" aria-expanded="true" aria-controls="collapse_semana">
                                <span class="badge badge-secondary">Facturas para la Semana</span>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse_semana" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_semana" data-parent="#accordion">
                            <div class="card-body">
                                
                                <table class="tablon" id="t_semana">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Empresa Fiscal (Emisor)</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Razon Social (Receptor)</th>
                                            <th scope="col">RFC(Receptor)</th>
                                            <th scope="col">Fecha de Factura</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col" width="40px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-md-12">

                        <div class="card-header badge-secondary" role="tab" id="heading_siguiente">
                          <h4 class="mb-0">
                            <a id="link_siguiente" class="collapsed" data-toggle="collapse" href="#collapse_siguiente" aria-expanded="false" aria-controls="collapse_siguiente">
                                <span class="badge badge-secondary">Facturas para la Siguiente Semana</span>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse_siguiente" class="collapse" role="tabpanel" aria-labelledby="heading_siguiente" data-parent="#accordion">
                            <div class="card-body">
                                
                                <table class="tablon" id="t_siguiente">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Empresa Fiscal (Emisor)</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Razon Social (Receptor)</th>
                                            <th scope="col">RFC(Receptor)</th>
                                            <th scope="col">Fecha de Factura</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col" width="40px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-md-12">

                        <div class="card-header badge-danger" role="tab" id="heading_vencidas">
                          <h4 class="mb-0">
                            <a id="link_vencidas" class="collapsed" data-toggle="collapse" href="#collapse_vencidas" aria-expanded="false" aria-controls="collapse_vencidas">
                                <span class="badge badge-danger">Facturas Vencidas</span>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse_vencidas" class="collapse" role="tabpanel" aria-labelledby="heading_vencidas" data-parent="#accordion">
                            <div class="card-body">
                                
                                <table class="tablon" id="t_vencidas">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Empresa Fiscal (Emisor)</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Razon Social (Receptor)</th>
                                            <th scope="col">RFC(Receptor)</th>
                                            <th scope="col">Fecha de Factura</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col" width="20px"></th>
                                            <th scope="col" width="20px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                    </div>

                </div>

            </div> <!--div_contenedor-->
        </div>      
    </div> <!--div_principal-->

    <div class="container-fluid" id="div_operaciones">
        <div class="row">
            <div class="col-md-12 div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Facturación Seguimiento</div>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_nota"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar como Nota</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_timbrar"><i class="fa fa-bell" aria-hidden="true"></i> Timbrar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                
                <form class="forma_general" name="forma_general">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <label for="s_empresa_fiscal" class="col-sm-12 col-md-12 col-form-label requerido">Empresa Fiscal (emisora) de la cotización</label>
                                <div class="input-group col-sm-12 col-md-10">
                                    <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_empresa_fiscal" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label for="ta_email" class="col-sm-12 col-md-2 col-form-label requerido">Correos</label>
                                <div class="col-sm-12 col-md-9  ">
                                    <textarea class="form-control" id="ta_email" name="ta_email"></textarea>
                                    <span class='ejemplo'>Ejemplo: usuario@denken.mx,usuario@correo.mx</span> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="s_cfdi" class="col-form-label requerido">Uso de CFDI </label>
                            <select id="s_cfdi" name="s_cfdi" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-3">
                            <label for="s_metodo_pago" class="col-form-label requerido">Método de Pago </label>
                            <select id="s_metodo_pago" name="s_metodo_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-3">
                            <label for="s_forma_pago" class="col-form-label requerido">Forma de Pago </label>
                            <select id="s_forma_pago" name="s_forma_pago" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-sm-12 col-md-1"></div>
                        <div class="col-sm-12 col-md-2"> 
                            <br>
                            <label for="ch_retencion" class="col-form-label">Retención</label>
                            <input type="checkbox" id="ch_retencion" name="ch_retencion" value="">
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="i_observaciones" class="col-form-label requerido">Observaciones</label>
                            <input type="text" id="i_observaciones" name="i_observaciones" class="form-control form-control-sm validate[required]"  autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8" id="div_radio_iva">
                                    <div class="row">
                                        <label for="i_iva" class="col-md-3 col-form-label requerido">Tasa IVA</label>
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
                                <div class="col-md-4">
                                    <div class="row">
                                        <label for="i_4_cuenta" class="col-md-12 col-form-label">Últimos 4 digitos de la cuenta</label>
                                        <div class="col-md-6">
                                            <input type="text" id="i_4_cuenta" name="i_4_cuenta" class="form-control form-control-sm validate[custom[integer],minSize[4],maxSize[4]]"  autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>

                <div class="card">
                    <h5 class="card-header">Servicios</h5>
                    <div class="card-body">
                        <form id="forma_partidas" name="forma_partidas">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="s_clave_sat_s" class="col-form-label requerido">Clave SAT del Producto/Servicio </label>
                                    <select id="s_clave_sat_s" name="s_clave_sat_s" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-4">
                                    <label for="s_id_unidades_s" class="col-form-label requerido">Unidad SAT </label>
                                    <select id="s_id_unidades_s" name="s_id_unidades_s" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                
                            </div>
                            <div class="row form-group">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="i_cantidad_s" class="col-form-label requerido">Cantidad</label>
                                            <input type="text" id="i_cantidad_s" name="i_cantidad_s" class="form-control form-control-sm validate[required,custom[number],min[0.01]]"  autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="i_precio_s" class="col-form-label requerido">Precio Unitario</label>
                                            <input type="text" id="i_precio_s" name="i_precio_s" class="form-control form-control-sm validate[required,custom[number],min[0.01]]"  autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="i_importe_s" class="col-form-label requerido">Importe</label>
                                            <input type="text" id="i_importe_s" name="i_importe_s" class="form-control validate[required] form-control-sm"  autocomplete="off" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"><br>
                                    <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                </div>
                            </div>
                            <div class="row">
                                <label for="i_descripcion_s" class="col-md-2 col-form-label requerido">Descripción</label>
                                <div class="col-md-10">
                                    <textarea type="text" id="i_descripcion_s" name="i_descripcion_s" class="form-control form-control-sm validate[required]"  autocomplete="off"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!--div card-->

                <br>

                <div class="row form-group">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Clave SAT del producto</th>
                                    <th scope="col">Unidad SAT</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Precio Unitario</th>
                                    <th scope="col">Iva</th>
                                    <th scope="col">Retención</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col" width="10px"></th>
                                    <th scope="col" width="10px"></th>
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

                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-10">
                        <div class="row">
                            <label for="i_subtotal" class="col-sm-12 col-md-1 col-form-label">Subtotal: </label>
                            <div class="col-sm-12 col-md-2">
                                <input type="text" id="i_subtotal" name="i_subtotal" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                            </div>
                            <label for="i_iva_total" class="col-sm-12 col-md-1 col-form-label">IVA:</label>
                            <div class="col-sm-12 col-md-2">
                                <input type="text" id="i_iva_total" name="i_iva_total" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                            </div>
                            <label for="i_retencion" class="col-sm-12 col-md-1 col-form-label">Retención: </label>
                            <div class="col-sm-12 col-md-2">
                                <input id="i_retencion" type="text" class="form-control form-control-sm validate[custom[number]]"  autocomplete="off" readonly/>
                            </div>
                            <label for="i_total" class="col-sm-12 col-md-1 col-form-label">Total: </label>
                            <div class="col-sm-12 col-md-2">
                                <input type="text" id="i_total" name="i_total" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div> 

            </div> <!--div_contenedor-->
        </div>  

        <input id="dato_id_cliente" name="dato_id_cliente" type="hidden" />
        <input id="dato_id_unidad" name="dato_id_unidad" type="hidden" />
        <input id="dato_id_sucursal" name="dato_id_sucursal" type="hidden" />
        <input id="dato_idcfdi_empresa_fiscal" name="dato_idcfdi_empresa_fiscal" type="hidden" />
        <input id="dato_id_razon_social" name="dato_id_razon_social" type="hidden" />
        <input id="dato_razon_social" name="dato_razon_social" type="hidden" />
        <input id="dato_codigo_postal" name="dato_codigo_postal" type="hidden" />
        <input id="dato_rfc" name="dato_rfc" type="hidden" />
        <input id="dato_fecha" name="dato_fecha" type="hidden" />
        <input id="dato_dias_credito" name="dato_dias_credito" type="hidden" />
        <input id="dato_mes" name="dato_mes" type="hidden" />
        <input id="dato_anio" name="dato_anio" type="hidden" />
        <input id="dato_fecha_inicio_periodo" name="dato_fecha_inicio_periodo" type="hidden" />
        <input id="dato_fecha_fin_periodo" name="dato_fecha_fin_periodo" type="hidden" />
        <input id="dato_id_contrato" name="dato_id_contrato" type="hidden" />

    </div> <!--div_operaciones-->
</body>

<div id="fondo_cargando"></div>

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
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_empresa_fiscal" id="i_filtro_empresa_fiscal" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
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
  
    var modulo='SEGUIMIENTO_FACTURAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var idCliente = 0;
    var idPartida = 0;

    $(function(){
        $("#div_principal").css({left : "0%"});

        cargarFacturasSemana();
        cargarFacturasSiguiente();  

        mostrarBotonAyuda(modulo);
        muestraSelectUsoCFDI('s_cfdi');
        muestraSelectMetodoPago('s_metodo_pago');
        muestraSelectClaveProductoSAT('s_clave_sat_s');
        muestraSelectClaveUnidadesSAT('s_id_unidades_s');

        function cargarFacturasSemana()
        {

            $('#t_semana tbody').html('');
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_semana.php',
                dataType:"json", 
                data : {},
                success: function(data)
                {
                    if(data.length != 0)
                    {

                        for(var i=0;data.length>i;i++)
                        {
                            var color = 'borde_gris'; 
                            var timbre = '';
                            if(parseInt(data[i].dias_contrato <= 0))
                            {
                                color = 'borde_rojo'; 
                                timbre = 'disabled';
                            }else if(parseInt(data[i].dias_contrato >= 1) && parseInt(data[i].dias_contrato <= 60)){
                                color = 'borde_amarillo';
                                timbre = '';
                            }

                            var html = "<tr>";
                            html += "<td data-label='Unidad de Negocio'>" + data[i].unidad + "</td>";
                            html += "<td data-label='Sucursal'>" + data[i].sucursal + "</td>";
                            html += "<td data-label='Empresa Fiscal (Emisor)'>" + data[i].empresa_fiscal + "</td>";
                            html += "<td data-label='Cliente'>" + data[i].cliente + "</td>";
                            html += "<td data-label='Razon Social (Receptor)'>" + data[i].razon_social_receptor + "</td>";
                            html += "<td data-label='RFC (Receptor)'>" + data[i].rfc_receptor + "</td>";
                            //html += "<td data-label='Tipo de Facturación'>" + data[i].tipo_facturacion + "</td>";
                            html += "<td data-label='Fecha de Factura'>" + data[i].fecha_facturar + "</td>";
                            html += "<td data-label='Periodo'>" + (data[i].periodicidad == 1 ? 'Semanal' : (data[i].periodicidad == 2 ? 'Quincenal' : (data[i].periodicidad == 3 ? 'Mensual' : 'Unico'))) + "</td>";
                            html += "<td data-label='' class="+color+"><button type='button' class='btn btn-success btn-sm form-control' id='b_plantilla' "+timbre+" id_contrato='" + data[i].id_contrato + "' id_unidad_negocio='" + data[i].id_unidad_negocio + "' id_sucursal='" + data[i].id_sucursal + "' id_empresa_fiscal='" + data[i].id_empresa_fiscal + "' id_razon_social='" + data[i].id_razon_social + "' razon_social_receptor='" + data[i].razon_social_receptor + "' rfc_receptor='" + data[i].rfc_receptor + "' id_cliente='" + data[i].id_cliente + "' correo_facturas='" + data[i].correo_facturas + "' fecha_facturar='" + data[i].fecha_facturar + "' fecha_inicio_periodo='"+data[i].fecha_inicio_periodo+"' fecha_fin_periodo='"+data[i].fecha_fin_periodo+"' id_cfdi='" + data[i].id_cfdi + "' ><i class='fa fa-bell' style='font-size:10px;' aria-hidden='true'></i></button></td>";
                            //html += "<td data-label='' class="+color+"></td>";
                            html += "</tr>";
                            ///agrega la tabla creada al div 
                            $('#t_semana tbody').append(html);   
                        }

                    }
                    else
                    {

                        var html = '<tr class="renglon_fact">\
                            <td colspan="9">No se encontró información</td>\
                        </tr>';

                        $('#t_semana tbody').append(html);

                    }

                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_semana.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas.');
                }
            });

        }

        function cargarFacturasSiguiente()
        {

            $('#t_siguiente tbody').html('');
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_siguiente.php',
                dataType:"json", 
                data : {},
                success: function(data)
                {

                    if(data.length != 0)
                    {

                        for(var i=0;data.length>i;i++)
                        {
                            var color = 'borde_gris'; 
                            var timbre = '';
                            if(parseInt(data[i].dias_contrato <= 0))
                            {
                                color = 'borde_rojo'; 
                                timbre = 'disabled';
                            }else if(parseInt(data[i].dias_contrato >= 1) && parseInt(data[i].dias_contrato <= 60)){
                                color = 'borde_amarillo';
                                timbre = '';
                            }

                            var html = "<tr>";
                            html += "<td data-label='Unidad de Negocio'>" + data[i].unidad + "</td>";
                            html += "<td data-label='Sucursal'>" + data[i].sucursal + "</td>";
                            html += "<td data-label='Empresa Fiscal (Emisor)'>" + data[i].empresa_fiscal + "</td>";
                            html += "<td data-label='Cliente'>" + data[i].cliente + "</td>";
                            html += "<td data-label='Razon Social (Receptor)'>" + data[i].razon_social_receptor + "</td>";
                            html += "<td data-label='RFC (Receptor)'>" + data[i].rfc_receptor + "</td>";
                            //html += "<td data-label='Tipo de Facturación'>" + data[i].tipo_facturacion + "</td>";
                            html += "<td data-label='Fecha de Factura'>" + data[i].fecha_facturar + "</td>";
                            html += "<td data-label='Periodo'>" + (data[i].periodicidad == 1 ? 'Semanal' : (data[i].periodicidad == 2 ? 'Quincenal' : (data[i].periodicidad == 3 ? 'Mensual' : 'Unico'))) + "</td>";
                            html += "<td data-label='' class="+color+"><button type='button' class='btn btn-success btn-sm form-control' id='b_plantilla' "+timbre+" id_contrato='" + data[i].id_contrato + "' id_unidad_negocio='" + data[i].id_unidad_negocio + "' id_sucursal='" + data[i].id_sucursal + "' id_empresa_fiscal='" + data[i].id_empresa_fiscal + "' empresa_fiscal='"+data[i].empresa_fiscal+"' id_razon_social='" + data[i].id_razon_social + "' razon_social_receptor='" + data[i].razon_social_receptor + "' rfc_receptor='" + data[i].rfc_receptor + "' id_cliente='" + data[i].id_cliente + "' correo_facturas='" + data[i].correo_facturas + "' codigo_postal_receptor='"+data[i].codigo_postal_receptor+"' fecha_facturar='" + data[i].fecha_facturar + "' fecha_inicio_periodo='"+data[i].fecha_inicio_periodo+"' fecha_fin_periodo='"+data[i].fecha_fin_periodo+"' id_cfdi='" + data[i].id_cfdi + "' ><i class='fa fa-bell' style='font-size:10px;' aria-hidden='true'></i></button></td>";
                            //html += "<td data-label='' class="+color+"></td>";
                            html += "</tr>";
                            ///agrega la tabla creada al div 
                            $('#t_siguiente tbody').append(html);   
                        }

                    }
                    else
                    {

                        var html = '<tr class="renglon_fact">\
                            <td colspan="9">No se encontró información</td>\
                        </tr>';

                        $('#t_siguiente tbody').append(html);

                    }

                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_semana.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas s.');
                }
            });

        }

        $(document).on('click','#b_plantilla',function()
        {
            $('#dato_id_cliente').val($(this).attr('id_cliente'));
            $('#dato_id_unidad').val($(this).attr('id_unidad_negocio'));
            $('#dato_id_sucursal').val($(this).attr('id_sucursal'));
            $('#i_empresa_fiscal').attr('alt','id_empresa_fiscal').attr('alt2','id_cfdi').val('empresa_fiscal');
            $('#dato_id_razon_social').val($(this).attr('id_razon_social'));
            $('#dato_razon_social').val($(this).attr('razon_social_receptor'));
            $('#dato_codigo_postal').val($(this).attr('codigo_postal_receptor'));
            $('#dato_rfc').val($(this).attr('rfc_receptor'));
            $('#dato_fecha').val($(this).attr('fecha_facturar'));
            $('#dato_dias_credito').val($(this).attr(''));
            $('#dato_mes').val($(this).attr(''));
            $('#dato_anio').val($(this).attr(''));
            $('#dato_fecha_inicio_periodo').val($(this).attr('fecha_inicio_periodo'));
            $('#dato_fecha_fin_periodo').val($(this).attr('fecha_fin_periodo'));

            if($(this).attr('correo_facturas') == 'null')
                $('#ta_email').val('');
            else
                $('#ta_email').val($(this).attr('correo_facturas'));
            

            $('#dato_id_contrato').val($(this).attr('id_contrato'));

            idCliente = $(this).attr('id_cliente');

            muestraRegistro(idCliente);
            muestraRegistroDetalle(idCliente);
            $("#div_principal").animate({left : "-101%"}, 500, 'swing');
            $('#div_operaciones').animate({left : "0%"}, 600, 'swing');

            $('#forma_general input').not('[type=radio]').val('');
            $('#i_subtotal, #i_iva_total, #i_total').val('');
            muestraSelectClaveProductoSAT('s_clave_sat_s');
            muestraSelectClaveUnidadesSAT('s_id_unidades_s');

        });

        $('#b_regresar').click(function(){
            $("#div_operaciones").animate({left : "-101%"}, 500, 'swing');
            $('#div_principal').animate({left : "0%"}, 600, 'swing');
            cargarFacturasSemana();
            cargarFacturasSiguiente();
        });

        $('#b_buscar_empresa_fiscal').click(function()
        {
            $('#i_filtro_empresa_fiscal').val('');
            muestraModalEmpresasFiscalesCFDI('renglon_empresa_fiscal','t_empresa_fiscal tbody','dialog_empresa_fiscal');
        });

        $('#t_empresa_fiscal').on('click', '.renglon_empresa_fiscal', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var idCFDI = $(this).attr('alt3');
            $('#i_empresa_fiscal').attr('alt',id).attr('alt2',idCFDI).val(nombre);
            $('#dialog_empresa_fiscal').modal('hide');
        });

        $('#s_metodo_pago').change(function(){
            var tipo = $(this).val();
            muestraSelectFormaPago(tipo,'s_forma_pago');
        });

        $('input[name=radio_iva]').change(function(){
            if($("#r_0").is(':checked'))
                $('#ch_retencion').prop({'checked':false,'disabled':true});
            else
                $('#ch_retencion').prop('disabled',false);
                
            calculaTotales();
            calcularRetencionPartidas();
        });

        /*function calculaTotales(){
           
            var subtotal=0;
            var iva=0;
            var total=0;
            var retencion = 0;

            $(".ch_opcion").each(function() {
                if($(this).is(':checked'))
                {
                    var valor= parseFloat($(this).parent().parent().attr('precio'))*parseFloat($(this).parent().parent().attr('cantidad'));
                    
                    subtotal=subtotal+valor;
                }
            });

            var valorIva = $('input[name=radio_iva]:checked').val();

            iva=(subtotal*parseInt(valorIva))/100;

            //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
            if($("#ch_retencion").is(':checked'))
                retencion = (6*subtotal)/100;

            total=subtotal+iva-parseFloat(retencion);

            $('#i_subtotal').val(formatearNumero(subtotal.toFixed(2)));
            $('#i_iva_total').val(formatearNumero(iva.toFixed(2)));
            $('#i_total').val(formatearNumero(total.toFixed(2)));
            $('#i_retencion').val(formatearNumero(retencion.toFixed(2)));
        }*/

        function calculaTotales(){
           
           var subtotal=0;
           var iva=0;
           var total=0;
           var retencion = 0;

           $(".ch_opcion").each(function() {
               if($(this).is(':checked'))
               {
                   //var valor= parseFloat($(this).parent().parent().attr('precio'))*parseFloat($(this).parent().parent().attr('cantidad'));
                   
                   //subtotal=subtotal+valor;

                   $.ajax({
                        type: 'POST',
                        async: false,
                        url: 'php/verifica_importes.php',
                        dataType:"json", 
                        data:  {'tipo':1, 'cantidad': parseFloat($(this).parent().parent().attr('cantidad')), 'precio': parseFloat($(this).parent().parent().attr('precio'))},
                        success: function(data)
                        {
                        
                            subtotal=subtotal+data;
                            //<--
                            //$('#i_sub_calculado').val(data);

                        }
                    });
            

                //var valor = $('#i_sub_calculado').val();
               }
           });

           console.log('subtotal: '+subtotal);
           var valorIva = $('input[name=radio_iva]:checked').val();

           iva=(subtotal*parseInt(valorIva))/100;

           //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
            //-->NJES May/21/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
           if($("#ch_retencion").is(':checked'))
           {
                if(parseInt($('input[name=radio_iva]:checked').val()) == 16)
                    retencion = (6*subtotal)/100;
                else
                    retencion = (3*subtotal)/100;
            }

           total=subtotal+iva-parseFloat(retencion);

           $('#i_subtotal').val(formatearNumero(subtotal.toFixed(2)));
           $('#i_iva_total').val(formatearNumero(iva.toFixed(2)));
           $('#i_total').val(formatearNumero(total.toFixed(2)));
           $('#i_retencion').val(formatearNumero(retencion.toFixed(2)));
       }

        $('#b_timbrar').click(function(){
            $('#b_timbrar').prop('disabled',true);
            if ($('.forma_general').validationEngine('validate'))
            {
                if(obtienePartidasATimbrar().length > 0)
                {
                    guardar();
                }else{
                    mandarMensaje('Debe existir por lo menos un producto/servicio para guardar');
                    $('#b_timbrar').prop('disabled',false);
                }
            }else{
                $('#b_timbrar').prop('disabled',false);
            }
        });

        function guardar(){

            //-->NJES May/21/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
            var ivaR = $('input[name=radio_iva]:checked').val();

            if(parseInt(ivaR) == 16)
                var porcentajeR = 6;
            else
                var porcentajeR = 3;
            
            var info={
                'idUnidadNegocio' : $('#dato_id_unidad').val(),
                'idSucursal' : $('#dato_id_sucursal').val(),
                'idCliente' : $('#dato_id_cliente').val(),
                'idEmpresaFiscalEmisor' : $('#i_empresa_fiscal').attr('alt'),
                'idCFDIEmpresaFiscal' : $('#i_empresa_fiscal').attr('alt2'),
                'idRazonSocialReceptor' : $('#dato_id_razon_social').val(),
                'razonSocialReceptor' : $('#dato_razon_social').val(),
                'codigoPostal' : $('#dato_codigo_postal').val(),
                'rfc' : $('#dato_rfc').val(),
                'idUsoCFDI' : $('#s_cfdi').val(),
                'idMetodoPago' : $('#s_metodo_pago').val(),
                'idFormaPago' : $('#s_forma_pago').val(),
                'fecha' : $('#dato_fecha').val(),
                'diasCredito' : $('#dato_dias_credito').val(),
                'tasaIva' : $('input[name=radio_iva]:checked').val(),
                'digitosCuenta' : $('#i_4_cuenta').val(),
                'mes' : $('#dato_mes').val(),
                'anio' : $('#dato_anio').val(),
                'observaciones' : $('#i_observaciones').val(),
                'partidas' : obtienePartidasATimbrar(),
                'subtotal' : quitaComa($('#i_subtotal').val()),
                'iva' : quitaComa($('#i_iva_total').val()),
                'total' : parseFloat(quitaComa($('#i_total').val()))+parseFloat(quitaComa($('#i_retencion').val())),
                'fechaInicioPeriodo' : $('#dato_fecha_inicio_periodo').val(),
                'fechaFinPeriodo' : $('#dato_fecha_fin_periodo').val(),
                'idContrato' : $('#dato_id_contrato').val(),
                'retencion' : $("#ch_retencion").is(':checked') ? 1 : 0,
                'importeRetencion' : quitaComa($('#i_retencion').val()),
                'porcentajeRetencion' : porcentajeR,
                'usuario' : usuario

            };

            console.log(JSON.stringify(info));

            var idEmpresa = $('#i_empresa_fiscal').attr('alt2');

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_actualizar_cliente.php',
                data:  {'datos':info},
                success: function(data) {
                    console.log(data);
                    if(data > 0 )
                    { 
                        var idFactura = data;

                        $.ajax({
                            type: 'POST',
                            url: 'php/facturacion_buscar_id_cfdi.php',
                            dataType:"json", 
                            data : {'idFactura':idFactura},
                            success: function(data2) {
                                if(data2.length >0){                    
                                    var dato = data2[0];

                                    var idCFDI = dato.id_factura_cfdi;

                                    timbrarFactura(idFactura,idCFDI,idEmpresa);
                                }
                            },
                            error: function (xhr) {
                                console.log('php/facturacion_buscar_id_cfdi.php --> '+JSON.stringify(xhr));
                                mandarMensaje('* No se encontró información al buscar cfdi factura.');
                                $('#b_timbrar').prop('disabled',false);
                            }
                        });
                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_timbrar').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_actualizar_cliente.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_timbrar').prop('disabled',false);
                }
            });
        }

        function timbrarFactura(id,idCFDI,idEmpresa){
            $('#fondo_cargando').show();
            $.ajax({
                type: 'GET',
                url: 'http://192.168.0.180/cfdi_3_3/php/ws_genera_factura.php',
                data : {'empresa':idEmpresa, 'registro': idCFDI},
                success: function(data)
                {
                    if(data == 'OK')
                    {
                        if(parseInt(actualizarDatosCFDI(id, idCFDI)) == parseInt(id))
                        {
                            mandarMensaje('Se timbro correctamente'); 
                        }else{
                            mandarMensaje('se timbro pero no me actualizo los datos xml');  ////vacio
                        }
                    }
                    else
                        mandarMensaje('Datos guardados. Error al generar timbre');

                        
                    $('#fondo_cargando').hide();  
                    $('#b_timbrar').prop('disabled',false);
                    $("#div_operaciones").animate({left : "-101%"}, 500, 'swing');
                    $('#div_principal').animate({left : "0%"}, 600, 'swing'); 
                    cargarFacturasSemana();
                    cargarFacturasSiguiente(); 
                    $("#ch_retencion").prop('checked',false);
                },
                error: function (xhr) {
                    //console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al generar timbre');
                    $('#b_timbrar').prop('disabled',false);
                }
            });
        }

        $(document).ready(function()
         {

            $('#i_cantidad_s').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 6);
            });

        });

         $(document).ready(function()
         {

            $('#i_precio_s').keypress(function (event)
            {
                return validateDecimalKeyPressN(this, event, 2);
            });
            
        });

        $('#i_precio_s, #i_cantidad_s').change(function(){

            if($(this).validationEngine('validate')==false) {
                var precio=quitaComa($('#i_precio_s').val());
                var cantidad=quitaComa($('#i_cantidad_s').val());

                if(precio==''){
                    precio=0;
                }

                if(precio > 0 && cantidad > 0)
                {
                    var valorIva = $('input[name=radio_iva]:checked').val();
                    var iva = ((parseFloat(cantidad)*parseFloat(precio))*parseInt(valorIva))/100;

                    //-->NJES May/21/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                    if($("#ch_retencion").is(':checked')){
                        if(parseInt(valorIva) == 16)
                            var retencionP = (6*(parseFloat(cantidad)*parseFloat(precio)))/100;
                        else
                            var retencionP = (3*(parseFloat(cantidad)*parseFloat(precio)))/100;
                    }else
                        var retencionP = 0;

                    var t = ((parseFloat(cantidad)*parseFloat(precio))+iva)-retencionP;
                    $('#i_importe_s').val(formatearNumeroA6Dec(t));
                    
                }else{
                    $('#i_importe_s').val('');
                }
            }else{
                $('#i_importe_s').val('');
                $(this).val('');
            }

        });

        function obtienePartidasATimbrar(){
            var j = 0;
            var arreglo = [];

            $(".ch_opcion").each(function(){
                if($(this).is(':checked'))
                {
                    var renglon = $(this).parent().parent();
                    var idClaveSATProducto = renglon.attr('claveProducto');
                    var idClaveSATUnidad = renglon.attr('claveUnidad');
                    var nombreUnidadSAT = renglon.attr('nombreUnidad');
                    var nombreProductoSAT = renglon.attr('nombreProducto');
                    var cantidad = renglon.attr('cantidad');
                    var precio = renglon.attr('precio');
                    var importe = parseFloat(renglon.attr('precio'))*parseFloat(renglon.attr('cantidad'));
                    var descripcion = renglon.attr('descripcion');
                    
                    arreglo[j] = {
                        'idClaveSATProducto' : idClaveSATProducto,
                        'idClaveSATUnidad' : idClaveSATUnidad,
                        'nombreUnidadSAT' : nombreUnidadSAT,
                        'nombreProductoSAT' : nombreProductoSAT,
                        'cantidad' : cantidad,
                        'precio' : precio,
                        'importe' : importe,
                        'descripcion' : descripcion
                    };  

                    j++;
                }
            });

            return arreglo;
        }

        $('#b_agregar').click(function(){
            $('#b_agregar').prop('disabled',true);
            if($('#forma_partidas').validationEngine('validate'))
            {
                guardarPartida();
            }else{
                $('#b_agregar').prop('disabled',false);
            }
        });

        function guardarPartida(){
            var idClaveSATProducto = $('#s_clave_sat_s').val(); 
            var idClaveSATUnidad = $('#s_id_unidades_s').val(); 
            var nombreUnidadSAT = $('#s_id_unidades_s option:selected').attr('alt');
            var nombreProductoSAT = $('#s_clave_sat_s option:selected').attr('alt');
            var cantidad = parseFloat(quitaComa($('#i_cantidad_s').val()));
            var precio = parseFloat(quitaComa($('#i_precio_s').val()));
            var importe = parseFloat(quitaComa($('#i_cantidad_s').val()))*parseFloat(quitaComa($('#i_precio_s').val()));
            var descripcion = $('#i_descripcion_s').val();

            var info = {
                'idPartida' : idPartida,
                'idClaveSATProducto' : idClaveSATProducto,
                'idClaveSATUnidad' : idClaveSATUnidad,
                'nombreUnidadSAT' : nombreUnidadSAT,
                'nombreProductoSAT' : nombreProductoSAT,
                'cantidad' : cantidad,
                'precio' : precio,
                'importe' : importe,
                'descripcion' : descripcion,
                'idCliente' : idCliente
            };

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_seguimiento_guardar_partida.php',
                data:  {'datos':info},
                success: function(data) {
                    if(data > 0 )
                    { 
                        limpiaFormaPartidas();
                        muestraRegistroDetalle(idCliente);
                    }else{ 
                        mandarMensaje('Error al agregar.');
                        $('#b_agregar').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_seguimiento_guardar_partida.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al agregar.');
                    $('#b_agregar').prop('disabled',false);
                }
            });
        }

        function muestraRegistro(idCliente){
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_seguimiento_buscar_idCliente.php',
                dataType:"json", 
                data : {'idCliente':idCliente},
                success: function(data) {                   
                    if(data.length > 0)
                    {
                        var dato = data[0];

                        muestraSelectFormaPago(dato.metodo_pago,'s_forma_pago');

                        $('#i_empresa_fiscal').attr('alt', dato.id_empresa_fiscal).attr('alt2',dato.id_cfdi).val(dato.empresa_fiscal);
                        
                        $('#s_cfdi').val(dato.uso_cfdi);
                        $('#s_cfdi').select2({placeholder: $(this).data('elemento')});

                        $('#s_metodo_pago').val(dato.metodo_pago);
                        $('#s_metodo_pago').select2({placeholder: $(this).data('elemento')});

                        $('#s_forma_pago').val(dato.forma_pago);
                        $('#s_forma_pago').select2({placeholder: $(this).data('elemento')});

                        $('#i_4_cuenta').val(dato.digitos_cuenta);
                        $('#i_observaciones').val(dato.observaciones);

                        if(dato.tasa_iva == 16)
                            $('#r_16').prop('checked',true);
                        else if(dato.tasa_iva == 8)
                            $('#r_8').prop('checked',true);
                        else
                            $('#r_0').prop('checked',true);

                        $("#ch_retencion").prop('checked',false);
                    }
                },
                error: function (xhr) {
                    console.log('php/facturacion_seguimiento_buscar_idCliente.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar partidas facturas cliente.');
                }
            });
        }

        function muestraRegistroDetalle(idCliente){
            $('#t_facturas tbody').html('');

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_seguimiento_buscar_detalle_idCliente.php',
                dataType:"json", 
                data : {'idCliente':idCliente},
                success: function(data) {                   
                    for(var i=0;data.length>i;i++)
                    {
                        var registro='';
                        var id = data[i].id;
                        var claveProducto = data[i].clave_producto_sat; 
                        var producto = data[i].clave_producto_sat+' - '+data[i].producto_sat;
                        var claveUnidad = data[i].clave_unidad_sat; 
                        var unidad = data[i].clave_unidad_sat+' - '+data[i].unidad_sat;
                        var nombreUnidad = data[i].unidad_sat;
                        var nombreProducto = data[i].producto_sat;
                        var descripcion = data[i].descripcion;
                        var precio = parseFloat(data[i].precio_unitario);
                        var valorIva = $('input[name=radio_iva]:checked').val();

                        if($("#ch_retencion").is(':checked'))
                        {
                            if(parseInt(valorIva) == 16)
                                var retencionP = (6*parseFloat(data[i].importe))/100;
                            else
                                var retencionP = (3*parseFloat(data[i].importe))/100;
                        }else
                            var retencionP = 0;

                        var importe = (((parseFloat(data[i].importe)*parseInt(valorIva))/100)+parseFloat(data[i].importe))-parseFloat(retencionP);
                        var cantidad = parseFloat(data[i].cantidad);
                        var iva = (parseFloat(data[i].importe)*parseInt(valorIva))/100;

                        if(data[i].chk_timbrar == 1)
                            var check = 'checked';
                        else
                            var check = '';

                        var registro='';
                            registro+= '<tr class="renglon_partida" alt="'+id+'" claveProducto="'+claveProducto+'" producto="'+producto+'" claveUnidad="'+claveUnidad+'" unidad="'+unidad+'" nombreUnidad="'+nombreUnidad+'" nombreProducto="'+nombreProducto+'" cantidad="'+cantidad+'" precio="'+precio+'" importe="'+importe+'" descripcion="'+descripcion+'">';
                            registro+= '<td class="editar">'+producto+'</td>';
                            registro+= '<td class="editar">'+unidad+'</td>';
                            registro+= '<td class="editar" style="text-align:right;">'+formatearNumeroCSS(cantidad.toFixed(6) + '')+'</td>';
                            registro+= '<td class="editar">'+descripcion+'</td>';
                            registro+= '<td class="editar" style="text-align:right;">'+formatearNumeroCSS(precio.toFixed(2) + '')+'</td>';
                            registro+= '<td class="editar" style="text-align:right;">'+formatearNumeroCSS(iva.toFixed(2) + '')+'</td>';
                            registro+= '<td class="editar" style="text-align:right;">'+formatearNumeroCSS(retencionP.toFixed(2) + '')+'</td>';
                            registro+= '<td class="editar" style="text-align:right;">'+formatearNumeroCSS(importe.toFixed(6) + '')+'</td>';
                            registro+='<td class="boton_eliminar" align="center"><input type="checkbox" name="ch_opcion" class="ch_opcion" value="'+id+'" '+check+'></td>';
                            registro+= '<td class="boton_eliminar"><button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar" alt="'+id+'"><i class="fa fa-remove" style="font-size:10px;" aria-hidden="true"></i></button></td>';
                            registro+= '</tr>';
                        $('#t_facturas tbody').append(registro);
                    }

                    calculaTotales();
                },
                error: function (xhr) {
                    console.log('php/facturacion_seguimiento_buscar_detalle_idCliente.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar partidas facturas cliente.');
                }
            });
        }

        $('#t_facturas').on('click', '.ch_opcion', function() {
            var info = {
                'idPartida' :  $(this).val(),
                'opcion' : $(this).is(':checked') ? 1 : 0
            };

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_seguimiento_actualiza_chk.php',
                data:  {'datos':info},
                success: function(data) {
                    if(data > 0 )
                    { 
                        muestraRegistroDetalle(idCliente);
                    }else{ 
                        mandarMensaje('Error al aplicar.');
                        $(this).prop('checked',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_seguimiento_actualiza_chk.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al aplicar.');
                    $(this).prop('checked',false);
                }
            });
        });

        $(document).ready(function(){
            $('#i_4_cuenta').keypress(function (event){
                return valideKeySoloNumeros(event);
            });
        });

        $(document).on('click','#b_eliminar',function(){
            $(this).prop('disabled',true);
            var id = $(this).attr('alt');

            $.ajax({
                type: 'POST',
                url: 'php/facturacion_seguimiento_eliminar_id.php',
                data:  {'idPartida':id},
                success: function(data) {
                    if(data > 0 )
                    { 
                        idPartida = 0;
                        muestraRegistroDetalle(idCliente);
                    }else{ 
                        mandarMensaje('Error al eliminar.');
                        $(this).prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/facturacion_seguimiento_eliminar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al eliminar.');
                    $(this).prop('disabled',false);
                }
            });
        });

        $('#t_facturas').on('dblclick', '.editar', function() {
            if($('#s_clave_sat_s').val() == null)
            {
                var renglon=$(this).parent();

                var cantidad = renglon.attr('cantidad');
                var precio = renglon.attr('precio');
                var importe = renglon.attr('importe')

                idPartida = renglon.attr('alt');
                
                $('#s_clave_sat_s').val(renglon.attr('claveProducto'));
                $('#s_clave_sat_s').select2({placeholder: $(this).data('elemento')});
                $('#s_id_unidades_s').val(renglon.attr('claveUnidad'));
                $('#s_id_unidades_s').select2({placeholder: $(this).data('elemento')}); 

                $('#i_cantidad_s').val(formatearNumeroA6Dec(cantidad));
                $('#i_precio_s').val(formatearNumero(precio));
                $('#i_importe_s').val(formatearNumeroA6Dec(importe));
                $('#i_descripcion_s').val(renglon.attr('descripcion'));

                renglon.remove();
                calculaTotales();
            }else{
                mandarMensaje('Debes agregar primero el producto/servicio actual');
            }
        });

        function limpiaFormaPartidas(){
            $('#b_agregar').prop('disabled',false);
            $('#forma_partidas input').val('');
            $('#i_descripcion_s').val('');
            muestraSelectClaveProductoSAT('s_clave_sat_s');
            muestraSelectClaveUnidadesSAT('s_id_unidades_s');
            idPartida = 0;
        }

        //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
        $('#ch_retencion').change(function(){
            calculaTotales();
            calcularRetencionPartidas();
        });

        //--> NJES Agregar campo retención, sera una bandera, y las facturas que lo tengan se aplicara un descuento del 6% al subtotal calculado (aplica para todas los modulos donde generan facturas, alarmas, facturación, seguimiento facturación) (DEN18-2413) Dic/17/2019<--//
        /*function calcularRetencionPartidas(){
            $('.renglon_partida').each(function(){
                var valor= parseFloat($(this).attr('precio'))*parseFloat($(this).attr('cantidad'));

                var ivaP = $('input[name=radio_iva]:checked').val();
                var ivaP=(valor*parseInt(ivaP))/100;
                var datoIvaP =  formatearNumeroCSS(ivaP.toFixed(2) + '');
                $(this).find('td').eq(5).text('').append(datoIvaP);

                if($("#ch_retencion").is(':checked'))
                    var retencionP = (6*valor)/100;
                else
                    var retencionP = 0;

                $(this).find('td').eq(6).text('').append(formatearNumeroCSS(retencionP.toFixed(2)));
                var importe = valor + parseFloat(ivaP) - parseFloat(retencionP);
                var importeP =  formatearNumeroCSS(importe.toFixed(7) + '');
                $(this).find('td').eq(7).text('').append(importeP);
            });

            if($('#i_importe_s').val() != '')
            {
                var precio=quitaComa($('#i_precio_s').val());
                var cantidad=quitaComa($('#i_cantidad_s').val());

                var valorIva = $('input[name=radio_iva]:checked').val();
                var iva = ((parseFloat(cantidad)*parseFloat(precio))*parseInt(valorIva))/100;
                var importe = (parseFloat(cantidad))*parseFloat(precio);

                if($("#ch_retencion").is(':checked'))
                    var retencionP = (6*(parseFloat(cantidad)*parseFloat(precio)))/100;
                else
                    var retencionP = 0;

                var t = ((parseFloat(cantidad)*parseFloat(precio))+iva)-retencionP;
                $('#i_importe_s').val(formatearNumeroA6Dec(t));
            }
        }*/

        function calcularRetencionPartidas(){
            $('.renglon_partida').each(function(){
                //var valor= parseFloat($(this).attr('precio'))*parseFloat($(this).attr('cantidad'));

                var valor = 0;
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: 'php/verifica_importes.php',
                    dataType:"json", 
                    data:  {'tipo':1, 'cantidad': parseFloat($(this).attr('cantidad')), 'precio': parseFloat($(this).attr('precio'))},
                    success: function(data)
                    {
                      
                        valor = data;

                    }
                });

                var ivaP = $('input[name=radio_iva]:checked').val();
                var ivaP=(valor*parseInt(ivaP))/100;
                var datoIvaP =  formatearNumeroCSS(ivaP.toFixed(2) + '');
                $(this).find('td').eq(5).text('').append(datoIvaP);

                //-->NJES May/21/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                if($("#ch_retencion").is(':checked'))
                {
                    if(parseInt($('input[name=radio_iva]:checked').val()) == 16)
                        var retencionP = (6*valor)/100;
                    else
                        var retencionP = (3*valor)/100;
                }else
                    var retencionP = 0;

                $(this).find('td').eq(6).text('').append(formatearNumeroCSS(retencionP.toFixed(2)));
                var importe = valor + parseFloat(ivaP) - parseFloat(retencionP);
                var importeP =  formatearNumeroCSS(importe.toFixed(7) + '');
                $(this).find('td').eq(7).text('').append(importeP);
            });

            if($('#i_importe_s').val() != '')
            {
                var precio=quitaComa($('#i_precio_s').val());
                var cantidad=quitaComa($('#i_cantidad_s').val());

                var valorIva = $('input[name=radio_iva]:checked').val();
                var iva = ((parseFloat(cantidad)*parseFloat(precio))*parseInt(valorIva))/100;
                var importe = (parseFloat(cantidad))*parseFloat(precio);

                if($("#ch_retencion").is(':checked'))
                {
                    //var retencionP = (6*(parseFloat(cantidad)*parseFloat(precio)))/100;
                    //-->NJES May/05/2020 si el iva es de 16 la retención es 6, si el iva es de 8 la retención es 3
                    if(parseInt(valorIva) == 16)
                        var retencionP = (6*(parseFloat(cantidad)*parseFloat(precio)))/100;
                    else
                        var retencionP = (3*(parseFloat(cantidad)*parseFloat(precio)))/100;
                }else
                    var retencionP = 0;
                    

                var t = ((parseFloat(cantidad)*parseFloat(precio))+iva)-retencionP;
                $('#i_importe_s').val(formatearNumeroA6Dec(t));
            }
        }
        
    });

</script>

</html>