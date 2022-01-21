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
    #div_t_registros,
    #div_t_registros_d{
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
        #div_t_registros,
        #div_t_registros_d{
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
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reporte de Comodatos de Almacen</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        Acumulado <input type="radio" name="radio_reporte" id="r_acumulado" value="0" checked> 
                    </div>
                    <div class="col-sm-12 col-md-2">
                        Detallado <input type="radio" name="radio_reporte" id="r_detallado" value="1">
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>
                <form id="forma_salida_comodato" name="forma_salida_comodato">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-3">
                            <label for="s_id_unidades" class="col-sm-12 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                            <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="s_id_sucursales" class="col-sm-12 col-md-12 col-form-label requerido">Sucursal </label>
                            <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-5">
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
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-5 col-md-5">
                            <input type="text" id="i_filtro" name="i_filtro" class="form-control form-control-sm filtrar_renglones" alt="renglon_comodatos" autocomplete="off" placeholder="Filtrar...">
                        </div>
                    </div>
                </form>

                <div class="row" id="div_acumulado">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">No. Movimiento</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col">Área</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">Partidas</th>
                                    <th scope="col">Importe Total</th>
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
                <div class="row" id="div_detallado" style="display:none;">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">No. Movimiento</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col">Área</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Importe Total</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros_d">
                            <table class="tablon"  id="t_registros_d">
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
</body>


<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='REPORTE_COMODATO';
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

        muestraRegistros(muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));

        $('#s_id_unidades').change(function(){
            var idUnidadNegocio = $('#s_id_unidades').val();
            muestraSucursalesPermiso('s_id_sucursales',idUnidadNegocio,modulo,idUsuario);

            muestraRegistros(muestraSucursalesPermisoListaId(idUnidadNegocio,modulo,idUsuario));
        });

        $(document).on('change','#s_id_sucursales',function(){
            muestraRegistros($('#s_id_sucursales').val());
        });

        $('#i_fecha_inicio').change(function(){
            if($('#s_id_sucursales').val() != null)
            {
                muestraRegistros($('#s_id_sucursales').val());
            }else{
                muestraRegistros(muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_id_sucursales').val() != null)
            {
                muestraRegistros($('#s_id_sucursales').val());
            }else{
                muestraRegistros(muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        //-->NJES March/16/2021 se agrega mostrar detallado de reporte
        $('input[name=radio_reporte]').change(function(){
            if($('#s_id_sucursales').val() != null)
            {
                muestraRegistros($('#s_id_sucursales').val());
            }else{
                muestraRegistros(muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }
        });

        function muestraRegistros(idSucursal){
            $('#i_filtro').val('');
            $('#t_registros tbody').html('');
            $('#t_registros_d tbody').html('');

            var info = {
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal': idSucursal,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'tipo' : $('input:radio[name=radio_reporte]:checked').val()
            };
            //console.log(JSON.stringify(info));

            $.ajax({
                type: 'POST',
                url: 'php/almacen_reporte_comodatos_buscar.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data) {
                    if(data.length != 0){                    
                        for(var i=0;data.length>i;i++){

                            //-->NJES March/16/2021 muestra acumulado o reporte de detallado, y muestra un divo u otro
                            if($('input:radio[name=radio_reporte]:checked').val() == 0)
                            {
                                $('#div_detallado').hide();
                                $('#div_acumulado').show();

                                var html='<tr class="renglon_comodatos" alt="'+data[i].id+'">\
                                            <td data-label="No. Movimiento">'+data[i].folio+'</td>\
                                            <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                            <td data-label="Fecha">'+data[i].fecha+'</td>\
                                            <td data-label="Departamento">'+data[i].departamento+'</td>\
                                            <td data-label="Área">'+data[i].area+'</td>\
                                            <td data-label="Supervisor">'+data[i].supervisor+'</td>\
                                            <td data-label="Partidas">'+data[i].partidas+'</td>\
                                            <td data-label="Importe Total">'+formatearNumero(data[i].importe_total)+'</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_registros tbody').append(html);  
                            }else{
                                $('#div_acumulado').hide();
                                $('#div_detallado').show();

                                var html='<tr class="renglon_comodatos" alt="'+data[i].id+'">\
                                            <td data-label="No. Movimiento">'+data[i].folio+'</td>\
                                            <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                            <td data-label="Fecha">'+data[i].fecha+'</td>\
                                            <td data-label="Departamento">'+data[i].departamento+'</td>\
                                            <td data-label="Área">'+data[i].area+'</td>\
                                            <td data-label="Supervisor">'+data[i].supervisor+'</td>\
                                            <td data-label="Producto">'+data[i].producto+'</td>\
                                            <td data-label="Precio">'+formatearNumero(data[i].precio)+'</td>\
                                            <td data-label="Cantidad">'+data[i].cantidad+'</td>\
                                            <td data-label="Importe Total">'+formatearNumero(data[i].importe_total)+'</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_registros_d tbody').append(html);  
                            } 
                        }
                        $('#b_excel').prop('disabled',false);
                    }else{
                        $('#b_excel').prop('disabled',true);
                        if($('input:radio[name=radio_reporte]:checked').val() == 0)
                        {
                            $('#div_detallado').hide();
                            $('#div_acumulado').show();

                            var html='<tr class="renglon">\
                                            <td colspan="8">No se encontró información</td>\
                                        </tr>';

                            $('#t_registros tbody').append(html);
                        }else{
                            $('#div_acumulado').hide();
                            $('#div_detallado').show();

                            var html='<tr class="renglon">\
                                            <td colspan="10">No se encontró información</td>\
                                        </tr>';

                            $('#t_registros_d tbody').append(html);
                        }
                    }
                },
                error: function (xhr) {
                    console.log('php/almacen_reporte_comodatos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar comodatos.');
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
                'tipo' : $('input:radio[name=radio_reporte]:checked').val()
            };
            
            $("#i_nombre_excel").val('Reporte Comodatos Almacen');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });
    });

</script>

</html>