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
        height:170px;
        overflow:auto;
    }
    #dialog_importar_responsiva > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    #dialog_buscar_entradas_responsiva > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    .boton_eliminar{
        width:50px;
    }
    .leyenda_almacenes{
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
        #dialog_importar_responsiva > .modal-lg{
            max-width: 100%;
        }
        #dialog_buscar_entradas_responsiva > .modal-lg{
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
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Entrada Por Devolución de Responsiva</div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_imprimir" disabled><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                    </div>
                </div>

                <form id="forma_entrada_responsiva" name="forma_entrada_responsiva">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="i_num_movimiento" class="col-sm-12 col-md-12 col-form-label">No. Movimiento </label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" id="i_num_movimiento" name="i_num_movimiento" class="form-control form-control-sm" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="i_fecha" class="col-sm-12 col-md-12 col-form-label">Fecha </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" id="i_fecha" name="i_fecha" class="form-control form-control-sm" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="s_id_unidades" class="col-sm-12 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                                <div class="col-sm-12 col-md-12">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="s_id_sucursales" class="col-sm-12 col-md-12 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-12 col-md-12">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <label for="i_tipo_entrada" class="col-sm-12 col-md-12 col-form-label">Concepto </label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="text" id="i_tipo_entrada" name="i_tipo_entrada" value="E05 Entrada Por Devolución de Responsiva" class="form-control form-control-sm" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <span class="leyenda_almacenes">* El precio se toma del ultimo precio de compra</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr><!--LInea gris -->

                    <div class="form-group row">
                        <div class="col-sm-4 col-md-1"></div>
                        <div class="col-sm-4 col-md-4">
                            <button type="button" data-toggle="tooltip" data-placement="top" title="Importar Salida Por Responsiva " class="btn btn-success btn-sm form-control" id="b_importar_responsiva"><i class="fa fa-download" aria-hidden="true"></i> Importar Salida Por Responsiva</button>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="row">
                                <label for="i_empleado" class="col-sm-12 col-md-4 col-form-label">Referencia Empleado</label>
                                <div class="input-group col-sm-12 col-md-8">
                                    <input type="text" id="i_empleado" name="i_empleado" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div> 
                </form>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Catálogo</th>
                                    <th scope="col">Familia</th>
                                    <th scope="col">Línea</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio Unitario</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col"></th>
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
    
</body>

<div id="dialog_buscar_entradas_responsiva" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de  Entradas Por Devolución de Responsiva</h5>
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
                        <div class="row">
                            <label for="s_filtro_sucursal" class="col-sm-12 col-md-4 col-form-label">Sucursal </label>
                            <div class="col-sm-12 col-md-7">
                                <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
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
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="i_filtro_entradas_responsiva" id="i_filtro_entradas_responsiva" alt="renglon_entradas_responsiva" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_entradas_responsiva">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">No. Movimiento</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Usuario Captura</th>
                                    <th scope="col">Partidas</th>
                                    <th scope="col">Importe Total</th>
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

<div id="dialog_importar_responsiva" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Importar Salida Por Responsiva</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-5"><input type="text" name="i_filtro_importar_responsiva" id="i_filtro_importar_responsiva" alt="renglon_ts" class="filtrar_renglones form-control filtrar_renglones"  placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_importar_responsiva">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Unidad de Negocio</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">No. Movimiento</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Empleado</th>
                                <th scope="col">Partidas</th>
                                <th scope="col">Importe Total</th>
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
 
    var modulo='E_POR_RESPONSIVA';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var idEntradaResponsiva = 0;
    var idContrapartida = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){

        mostrarBotonAyuda(modulo);
        
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

        $('#s_id_unidades').change(function(){
            var idUnidadNegocio = $('#s_id_unidades').val();
            $('#b_buscar_empleados').prop('disabled',true);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);
            
            $('#i_empleado').val('').attr('alt',0);
            $("#t_registros tr").remove();

        });

        $(document).on('change','#s_id_sucursales',function(){

            $('#i_empleado').val('').attr('alt',0);
            $("#t_registros tr").remove();

        });

        var fecha = new Date();
        if(fecha.getMonth() <9)
        {
            var mes = '0'+(fecha.getMonth()+1);
        }else{
            var mes = fecha.getMonth()+1;
        }

        if(fecha.getDate() < 9)
        {
            var dia = '0'+fecha.getDate();
        }else{
            var dia = fecha.getDate();
        }

        var fecha_hoy = fecha.getFullYear() + "-" + mes + "-" + dia;
        $('#i_fecha').val(fecha_hoy);

        $('#b_buscar_lineas_filtro').prop('disabled',true);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

            //****************OBTENER PARTIDAS***************** */
        function obtenerPartidas(){

            var j = 0;
            var arreDatos = [];

            $("#t_registros .partida").each(function() {
            
                var idProducto = $(this).attr('producto');
                var concepto = $(this).attr('concepto');
                var descripcion =$(this).attr('descripcion');

                //-->NJES July/28/2020 se agregan parametros para poder actualizar los ids de la contrapartida cuando 
                //ya se hayan usado todos los productos del la salida importada
                var cantidad_original = $(this).attr('cantidad'); 
                var cantidad_usada = $(this).attr('cantidad_usada'); 
                var cantidad = $(this).find('.cantidad_partida').val();

                var precio = quitaComa($(this).attr('precio'));
                var importe = quitaComa($(this).attr('importe'));
                var marca = $(this).attr('marca');

                j++;

                arreDatos[j] = {
                    'idProducto' : idProducto,
                    'concepto' : concepto,
                    'descripcion' : descripcion,
                    'cantidad_original' : cantidad_original,
                    'cantidad_usada' : cantidad_usada,
                    'cantidad' : cantidad,
                    'precio' : precio,
                    'importe' : importe,
                    'marca' : marca
                };
            });

            arreDatos[0] = j;
            return arreDatos;
        }

        //-->NJES July/28/2020 se obtienen datos de consulta porque se pueden quitar partidas y los datos totales ya no se pueden obtener
        function obtenerCantidadTotal(idContrapartida){
            var verifica = 0;

            $.ajax({
                type: 'POST',
                url: 'php/almacen_salidas_cantidad_usada_buscar.php',
                dataType:"json", 
                data:  {'idSalida':idContrapartida},
                async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
                success: function(data) 
                {
                    verifica = data[0].cantidad;
                },
                error: function (xhr) {
                    console.log('error --> php/almacen_salidas_cantidad_usada_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar buscar las cantidades.');
                }
            });

            return verifica;
        }

        function obtenerCantidadTotalUsada(idContrapartida){
            var verifica = 0;

            $.ajax({
                type: 'POST',
                url: 'php/almacen_salidas_cantidad_usada_buscar.php',
                dataType:"json", 
                data:  {'idSalida':idContrapartida},
                async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
                success: function(data) 
                {
                    verifica = data[0].cantidad_usada;
                },
                error: function (xhr) {
                    console.log('error --> php/almacen_salidas_cantidad_usada_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar buscar las cantidades.');
                }
            });

            return verifica;
        }

        $(document).on('keypress','.cantidad_partida',function (event){
            return valideKeySoloNumerosInt(event);
        });

        //-->NJES July/28/2020 se validan solo las cantidades de las paridas que se checaron para devolverse
        $(document).on('change','.cantidad_partida',function(){
           
            var cantidad = parseFloat($(this).val());
            var cantidad_disponible = parseFloat($(this).attr('alt'));

            if(cantidad > cantidad_disponible)
            {
                mandarMensaje('La cantidad disponible para la partida es maximo '+cantidad_disponible);
                $(this).val('').val(cantidad_disponible);
            }else{
                if(cantidad <= 0)
                {
                    mandarMensaje('La cantidad minima es 1, y la cantidad disponible para la partida es maximo '+cantidad_disponible);
                    $(this).val('').val(cantidad_disponible);
                }
            }
            
        });

        $('#b_nuevo').click(function(){
            limpiar();
        });

        $('#b_guardar').click(function(){
            $('#b_guardar').prop('disabled',true);
           
            if ($('#forma_entrada_responsiva').validationEngine('validate')){
                if($('#t_registros .partida').length > 0)
                {
                    guardar();
                    
                }else{
                    mandarMensaje('Debe existir por lo menos un producto para generar la entrada por responsiva de sucursal');
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardar(){

            //E05 = Entrada Por Transferencia de Sucursal
            var datos = {
                'tipoEntrada':'E05',
                'idEntrada':idEntradaResponsiva,
                'folio':$('#i_num_movimiento').val(),
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'idSucursal':$('#s_id_sucursales').val(),
                'fecha':$('#i_fecha').val(),
                'idUsuario':idUsuario,
                'noPartidas': $('#t_registros .partida').length,
                'usuario':usuario,
                'idEmpleado':$('#i_empleado').attr('alt'),
                'detalle':obtenerPartidas(),
                'idContrapartida':idContrapartida,
                //-->NJES July/29/2020 devoluciones parciales
                'cantidad_total':obtenerCantidadTotal(idContrapartida),
                'cantidad_total_usada':obtenerCantidadTotalUsada(idContrapartida)
            };

            $.ajax({
                type: 'POST',
                url: 'php/almacen_entradas_guardar.php',
                data:  {'datos':datos},
                success: function(data) {
                    if(data > 0 )
                    { 
                        mandarMensaje('La entrada por devolución de responsiva: '+data+' se guardó correctamente');
                        limpiar();
                    
                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/almacen_entradas_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        $('#b_buscar').click(function(){
            muestraSelectUnidades(matriz,'s_filtro_unidad',$('#s_id_unidades').val());
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_id_unidades').val(),modulo,idUsuario);
            $('form').validationEngine('hide');
            $('#i_filtro_entradas_responsiva').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('').prop('disabled',true);
            $('.renglon_entradas_responsiva').remove();
            $('#dialog_buscar_entradas_responsiva').modal('show');

        });

        $(document).on('change','#s_filtro_unidad',function(){
            if($('#s_filtro_unidad').val()!= ''){
                $('.img-flag').css({'width':'50px','height':'20px'});
            }
            muestraSucursalesPermiso('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);

            $('#i_filtro_entradas_responsiva').val('');
            $('#i_fecha_inicio').val('').prop('disabled',false);
            $('#i_fecha_fin').val('').prop('disabled',true);
            $('.renglon_entradas_responsiva').remove();

        });

        $(document).on('change','#s_filtro_sucursal',function(){
            buscarEntradasPorResponsiva($('#s_filtro_unidad').val());
        });

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscarEntradasPorResponsiva($('#s_filtro_unidad').val());
            }
        });

        $('#i_fecha_fin').change(function(){
            buscarEntradasPorResponsiva($('#s_filtro_unidad').val());
        });

        function buscarEntradasPorResponsiva(idUnidadNegocio){
            $('.renglon_entradas_responsiva').remove();

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idUnidadNegocio': idUnidadNegocio,
                'idSucursal':$('#s_filtro_sucursal').val(),
                'tipoEntrada':'E05'
            }; 

            $.ajax({

                type: 'POST',
                url: 'php/almacen_entradas_buscar.php',
                dataType:"json", 
                data:{'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_entradas_responsiva" alt="'+data[i].id+'" alt2="'+data[i].id_unidad_negocio+'" alt3="'+data[i].id_sucursal+'">\
                                        <td data-label="No. Movimiento">' + data[i].folio+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="Usuario Captura">' + data[i].usuario+ '</td>\
                                        <td data-label="Partidas">' + data[i].partidas+ '</td>\
                                        <td data-label="Importe Total">' + formatearNumero(data[i].importe_total)+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_entradas_responsiva tbody').append(html);   
                              
                        }
                    }else{

                            mandarMensaje('No se encontró información');
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/almacen_entradas_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar');
                }
            });
        }

        $('#t_entradas_responsiva').on('click', '.renglon_entradas_responsiva', function() {
            muestraSucursalesPermiso('s_id_sucursales',$(this).attr('alt2'),modulo,idUsuario);
            idEntradaResponsiva = $(this).attr('alt');
            $('#dialog_buscar_entradas_responsiva').modal('hide');
            muestraRegistro(idEntradaResponsiva);
            muestraRegistroDetalle(idEntradaResponsiva); 
            $('#b_guardar').prop('disabled',true);
            $('#b_imprimir').prop('disabled',false);
            $('#forma_entrada_responsiva').find('input,select').prop('disabled',true);
            $('#b_importar_responsiva').prop('disabled',true);
        });

        function muestraRegistro(idEntradaResponsiva){
            $.ajax({
                type: 'POST',
                url: 'php/almacen_entradas_buscar_id.php',
                dataType:"json", 
                data:{
                    'idEntrada':idEntradaResponsiva
                },
                success: function(data) {
                    if(data.length > 0){
                        
                        $('#i_num_movimiento').val(data[0].folio);
                        $('#i_fecha').val(data[0].fecha);
                        $('#i_empleado').attr('alt',data[0].id_trabajador).val(data[0].empleado);

                        $('#s_id_unidades').val(data[0].id_unidad_negocio);
                        $("#s_id_unidades").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                        });
                        $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                        if(data[0].id_sucursal != 0)
                        {
                            $('#s_id_sucursales').val(data[0].id_sucursal);
                            $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                        }else{
                            $('#s_id_sucursales').val('');
                            $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
                        }

                    }
                    
                },
                error: function (xhr) 
                {
                    console.log('php/almacen_entradas_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al mostrar registros');
                }
            });
        }

        function muestraRegistroDetalle(idEntradaResponsiva){
            $('#t_registros tbody').empty();
            $.ajax({
                type: 'POST',
                url: 'php/almacen_entradas_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idEntrada':idEntradaResponsiva
                },
                success: function(data)
                {
                    for(var i=0; data.length>i; i++)
                    {
                        var html = "<tr class='partida' producto='" + data[i].id_producto + "' concepto='" + data[i].concepto+ "' id_familia='" + data[i].id_familia + "' familia='" + data[i].familia + "' id_linea='" + data[i].id_linea + "' linea='" + data[i].linea + "' precio='" + data[i].precio + "' cantidad='" +  data[i].cantidad + "' descripcion='" + data[i].descripcion + "' importe='" + data[i].importe + "' marca='"+data[i].marca+"'>";
                            html += "<td data-label='CATÁLOGO'>" + data[i].id_producto + "</td>";
                            html += "<td data-label='FAMILIA'>" + data[i].familia + "</td>";
                            html += "<td data-label='LÍNEA'>" + data[i].linea + "</td>";
                            html += "<td data-label='CONCEPTO'>" + data[i].concepto + "</td>";
                            html += "<td data-label='MARCA'>" + data[i].marca + "</td>";
                            html += "<td align='right' data-label='CANTIDAD'>" + data[i].cantidad + "</td>";
                            html += "<td align='right' data-label='PRECIO UNITARIO'>" + formatearNumero(data[i].precio) + "</td>";
                            html += "<td data-label='IMPORTE'>" + formatearNumero(data[i].importe) + "</td>";

                            html += "<td class='boton_eliminar'></td>";

                            html += "</tr>";

                        $('#t_registros tbody').append(html);
                    
                    }
         
                },
                error: function (xhr)
                {
                    console.log('php/almacen_entradas_buscar_detalle.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al mostrar detalle');
                }
            });
        }

        $('#b_importar_responsiva').click(function(){
            if(($('#s_id_unidades').val() != null) && ($('#s_id_sucursales').val() != null))
            {
                $('#i_filtro_importar_responsiva').val('');
                $('#form_partidas').validationEngine('hide');

                var idUnidad = $('#s_id_unidades').val();
                var idSucursal = $('#s_id_sucursales').val();
                $('#t_importar_responsiva >tbody tr').remove();

                $.ajax({
                    type: 'POST',
                    url: 'php/almacen_salidas_buscar_importar.php',
                    dataType:"json", 
                    data:{
                        'idUnidadNegocio':idUnidad,
                        'idSucursal':idSucursal,
                        'tipo':'S05'
                    },
                    success: function(data)
                    {
                    
                        for(var i=0; data.length>i; i++)
                        {
                            var html = "<tr class='renglon_ts' alt='" + data[i].id + "' alt1='" + data[i].folio + "' alt2='"+data[i].id_trabajador+"' alt3='"+data[i].empleado+"'>";
                                html += "<td data-label='Unidad de Negocio'>"+data[i].unidad+"</td>";
                                html += "<td data-label='Sucursal'>"+data[i].sucursal+"</td>";
                                html += "<td data-label='No. Movimiento'>"+data[i].folio+"</td>";
                                html += "<td data-label='Fecha'>"+data[i].fecha+"</td>";
                                html += "<td data-label='Empleado'>"+data[i].empleado+"</td>";
                                html += "<td data-label='Partidas'>"+data[i].no_partidas+"</td>";
                                html += "<td data-label='Importe Total'>"+formatearNumero(data[i].importe)+"</td>";
                                html += "</tr>";

                            $('#t_importar_responsiva tbody').append(html);
                        
                        }

                        $('#dialog_importar_responsiva').modal('show');

                    },
                    error: function (xhr)
                    {   
                        console.log('php/almacen_salidas_buscar_importar.php-->'+ JSON.stringify(xhr));
                        mandarMensaje('* No se encontro información al buscar datos para importar');
                    }
                });
            }else{
                mandarMensaje('Seleccionar Unidad de Negocio y Sucursal para buscar información');
            }
        });

        $("#t_importar_responsiva").on('click',".renglon_ts",function(){

            idContrapartida=$(this).attr('alt');
            var idEmpleado = $(this).attr('alt2');
            var empleado = $(this).attr('alt3');

            $('#i_empleado').val(empleado).attr('alt',idEmpleado);

            agregaDetalleResponsiva(idContrapartida);

            $('#dialog_importar_responsiva').modal('hide');
        });

        function agregaDetalleResponsiva(idContrapartida){

            $('#t_registros tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/almacen_salidas_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idSalida':idContrapartida
                },
                success: function(data)
                {   
                    for(var i=0; data.length>i; i++)
                    {
                        var html = "<tr class='partida' producto='" + data[i].id_producto + "' concepto='" + data[i].concepto+ "' id_familia='" + data[i].id_familia + "' familia='" + data[i].familia + "' id_linea='" + data[i].id_linea + "' linea='" + data[i].linea + "' precio='" + data[i].precio + "' cantidad='" +  data[i].cantidad + "' descripcion='" + data[i].descripcion + "' importe='" + data[i].importe + "' marca='"+data[i].marca+"'>";
                            html += "<td data-label='CATÁLOGO'>" + data[i].id_producto + "</td>";
                            html += "<td data-label='FAMILIA'>" + data[i].familia + "</td>";
                            html += "<td data-label='LÍNEA'>" + data[i].linea + "</td>";
                            html += "<td data-label='CONCEPTO'>" + data[i].concepto + "</td>";
                            html += "<td data-label='MARCA'>" + data[i].marca + "</td>";
                            //html += "<td align='right' data-label='CANTIDAD'>" + data[i].cantidad + "</td>";
                            //-->NJES July/28/2020 se agrega input a cantidad para que se pueda modificar y se hagan devoluciones parciales
                            html += "<td align='right' data-label='CANTIDAD'><input type='text' style='width:100%;' class='form-control form-control-sm cantidad_partida' value='"+data[i].cantidad_sobrante+"' alt='"+data[i].cantidad_sobrante+"'/></td>";
                            html += "<td align='right' data-label='PRECIO UNITARIO'>" + formatearNumero(data[i].precio) + "</td>";
                            html += "<td data-label='IMPORTE'>" + formatearNumero(data[i].importe) + "</td>";

                            //html += "<td class='boton_eliminar'></td>";
                            //-->NJES July/28/2020 se agrega check para que se checken las partidas que se desean devolver
                            html += "<td><button type='button' class='btn btn-danger btn-sm form-control boton_eliminar' id='b_eliminar'><i class='fa fa-remove' style='font-size:10px;' aria-hidden='true'></i></button></td>";

                            html += "</tr>";

                        $('#t_registros tbody').append(html);
                    }

                },
                error: function (xhr)
                {
                    console.log('php/almacen_salidas_buscar_detalle.php-->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar los detalles para importar');
                }
            });
        }

        $(document).on('click','#b_eliminar',function(){
            $(this).parent().parent().remove();
        });

        $('#b_imprimir').click(function(){
            
            var datos = {
                'path':'formato_almacen',
                'idRegistro':idEntradaResponsiva,
                'nombreArchivo':'entrada_por_responsiva',
                'tipo':1,
                'concepto':'E05 Entrada Por Devolución de Responsiva'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');

        });

        function limpiar(){
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            $('#i_num_movimiento,#i_empleado').val('');

            $('#form_partidas input').val('');
            $('select').prop('disabled',false);
            $("#t_registros tr").remove();
            $('#b_guardar').prop('disabled',false);
            
            $('#forma_entrada_responsiva').validationEngine('hide');
            $('#form_partidas').validationEngine('hide');
            $('#b_importar_responsiva').prop('disabled',false);

            $('#b_imprimir').prop('disabled',true);
            idEntradaResponsiva = 0;
            idContrapartida = 0;
        }

    });

</script>

</html>