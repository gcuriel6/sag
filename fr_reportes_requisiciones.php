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
    #div_principal{
        padding-top:20px;
        margin-left:4%;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_detalle_requisiciones,#div_t_requisiciones_agrupadas,#div_t_requisiciones_agrupadas{
        max-height:170px;
        overflow:auto;
    }
    .titulo_tabla{
        width:100%;
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: .15em;
        font-weight:bold;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_detalle_requisiciones,#div_t_requisiciones_agrupadas,#div_t_requisiciones_agrupadas{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-11" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Reportes Requisiciones</div>
                    </div>
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_REPORTES_REQUISICIONES" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="s_id_unidades" class="col-form-label">Unidad de Negocio </label>
                                        <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="s_id_sucursales" class="col-form-label">Sucursal</label>
                                        <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="s_id_area" class="col-form-label">Area </label>
                                        <select id="s_id_area" name="s_id_area" class="form-control form-control-sm validate[required]" disabled autocomplete="off" style="width:100%;"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="s_id_departamento" class="col-form-label">Departamento</label>
                                        <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm validate[required]" disabled autocomplete="off" style="width:100%;"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <br>
                        <div class="form-group row">
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
                                <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly disabled>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="i_proveedor" class="col-md-12 col-form-label">Proveedor</label>
                            <div class="input-group col-sm-12 col-md-12">
                                <input type="text" id="i_proveedor" name="i_proveedor" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="b_buscar_proveedor" style="margin:0px;">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   

                <hr><!--linea gris-->

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="titulo_tabla">Detalle de Requisiciones</div>
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">UN</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Depto</th>
                                    <th scope="col">OC</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Partida</th>
                                    <th scope="col">Familia</th>
                                    <th scope="col">Línea</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Unidad</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Costo U</th>
                                    <th scope="col">% Dcto</th>
                                    <th scope="col">% IVA</th>
                                    <th scope="col">Importe sin IVA</th>
                                    <th scope="col">Importe con IVA</th>
                                    <th scope="col">Estatus</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_detalle_requisiciones">
                            <table class="tablon"  id="t_detalle_requisiciones">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="titulo_tabla">Requisiciones Agrupadas</div>
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">UN</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Depto</th>
                                    <th scope="col">OC</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Descripción General</th>
                                    <th scope="col">Importe sin IVA</th>
                                    <th scope="col">Importe con IVA</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_requisiciones_agrupadas">
                            <table class="tablon"  id="t_requisiciones_agrupadas">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="titulo_tabla">Backorder de Requisiciones</div>
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">UN</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Depto</th>
                                    <th scope="col">OC</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Partida</th>
                                    <th scope="col">Familia</th>
                                    <th scope="col">Línea</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Unidad</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Costo U</th>
                                    <th scope="col">% Dcto</th>
                                    <th scope="col">% IVA</th>
                                    <th scope="col">Importe sin IVA</th>
                                    <th scope="col">Importe con IVA</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_backorder_requisiciones">
                            <table class="tablon"  id="t_backorder_requisiciones">
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
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_proveedores" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Busqueda Proveedores</h5>
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='REPORTES_REQUISICIONES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        console.log('difdifndfndfkn');

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesAcceso('s_id_sucursales',idUnidadActual,idUsuario);

        //7buscaDetalleRequisiciones(idUnidadActual);
        buscaRequisicionesAgrupadas(idUnidadActual);
        //buscaBackorderRequisiciones(idUnidadActual);
        
        $('#s_id_unidades').change(function(){
            muestraSucursalesAcceso('s_id_sucursales',$('#s_id_unidades').val(),idUsuario);
            buscaRequisicionesAgrupadas($('#s_id_unidades').val());
        });

        $('#s_id_sucursales').change(function(){
            muestraAreasAcceso('s_id_area');
            $('#s_id_area').prop('disabled',false);
            buscaRequisicionesAgrupadas($('#s_id_unidades').val());
        });

        $('#s_id_area').change(function(){
            muestraDepartamentoArea('s_id_departamento', $('#s_id_sucursales').val(), $('#s_id_area').val());
            $('#s_id_departamento').prop('disabled',false);
            buscaRequisicionesAgrupadas($('#s_id_unidades').val());
        });

        $('#b_buscar_proveedor').click(function(){
            $('#i_filtro_proveedor').val('');
            muestraModalProveedores('renglon_proveedor','t_proveedores tbody','dialog_proveedores');
        });

        $('#t_proveedores').on('click', '.renglon_proveedor', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_proveedor').attr('alt',id).val(nombre);
            $('#dialog_proveedores').modal('hide');
            buscaRequisicionesAgrupadas($('#s_id_unidades').val());
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscaRequisicionesAgrupadas($('#s_id_unidades').val());
            }
        });

        $('#i_fecha_fin').change(function(){
            buscaRequisicionesAgrupadas($('#s_id_unidades').val());
        });

        function buscaDetalleRequisiciones(idUnidadNegocio){
            $('#t_detalle_requisiciones .renglon').remove();

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idUnidadNegocio': idUnidadNegocio,
                'idSucursal':$('#s_id_sucursales').val(),
                'idArea':$('#s_id_area').val(),
                'idDepartamento':$('#s_id_departamento').val(),
                'idProveedor':$('#i_proveedor').attr('alt'),
                'tipoReporte':'detalleRequisiciones'
            }; 

            $.ajax({

                type: 'POST',
                url: 'php/requisiciones_reportes_buscar.php',
                dataType:"json", 
                data:{'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                    
                        for(var i=0;data.length>i;i++){
                            
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon">\
                                        <td data-label="UN"></td>\
                                        <td data-label="Sucursal"></td>\
                                        <td data-label="Area"></td>\
                                        <td data-label="Depto"></td>\
                                        <td data-label="OC"></td>\
                                        <td data-label="Fecha"></td>\
                                        <td data-label="Solicitante"></td>\
                                        <td data-label="Proveedor"></td>\
                                        <td data-label="Partida"></td>\
                                        <td data-label="Familia"></td>\
                                        <td data-label="Línea"></td>\
                                        <td data-label="Descripción"></td>\
                                        <td data-label="Detalle"></td>\
                                        <td data-label="Unidad"></td>\
                                        <td data-label="Cantidad"></td>\
                                        <td data-label="Costo U"></td>\
                                        <td data-label="% Dcto"></td>\
                                        <td data-label="% IVA"></td>\
                                        <td data-label="Importe sin IVA"></td>\
                                        <td data-label="Importe con IVA"></td>\
                                        <td data-label="Estatus"></td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_detalle_requisiciones tbody').append(html);   
                              
                        }
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="21">No se encontró información</td>\
                                    </tr>';

                        $('#t_detalle_requisiciones tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/requisiciones_reportes_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        function buscaRequisicionesAgrupadas(idUnidadNegocio)
        {
            
            $('#t_requisiciones_agrupadas .renglon').remove();

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idUnidadNegocio': idUnidadNegocio,
                'idSucursal':$('#s_id_sucursales').val(),
                'idArea':$('#s_id_area').val(),
                'idDepartamento':$('#s_id_departamento').val(),
                'idProveedor':$('#i_proveedor').attr('alt'),
                'tipoReporte':'requisicionesAgrupadas'
            }; 

            $.ajax({

                type: 'POST',
                url: 'php/requisiciones_reportes_buscar.php',
                dataType:"json", 
                data:{'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon">\
                                        <td data-label="UN">'+data[i].unidad+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Area">'+data[i].are+'</td>\
                                        <td data-label="Depto">'+data[i].depto+'</td>\
                                        <td data-label="OC">'+data[i].folio_orden_compra+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Solicitante">'+data[i].solicito+'</td>\
                                        <td data-label="Proveedor">'+data[i].proveedor+'</td>\
                                        <td data-label="Descripción General">'+data[i].descripcion+'</td>\
                                        <td data-label="Importe sin IVA">'+formatearNumero(data[i].subtotal)+'</td>\
                                        <td data-label="Importe con IVA">'+formatearNumero(data[i].total)+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_requisiciones_agrupadas tbody').append(html);   
                              
                        }
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="11">No se encontró información</td>\
                                    </tr>';

                        $('#t_requisiciones_agrupadas tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/requisiciones_reportes_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        function buscaBackorderRequisiciones(idUnidadNegocio){
            $('#t_backorder_requisiciones .renglon').remove();
        }
        
    });

</script>

</html>