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
        min-height:350px;
        max-height:350px;
        overflow:auto;
    }
    .tablon {
        font-size: 10px;
    }
    #pantalla_saldos_clientes,
    #pantalla_saldos_rs,
    #pantalla_detalle_rs{
        position: absolute;
        top:10px;
        left : -101%;
        height: 95%;
    }
    #i_total_clientes,
    #i_total_rs,
    #i_total{
        text-align:right;
    }
    #label_nombre_sucursal{
        background-color : #D4EDDA;
        width:100%;
        padding:2px;
        font-weight: bold;
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

    <div class="container-fluid"  id="pantalla_saldos_clientes">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Saldos Clientes</div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-1"></div>
                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="i_filtro_clientes" id="i_filtro_clientes" class="form-control filtrar_renglones" alt="renglon_clientes" placeholder="Filtrar" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-2"></div>
                            <div class="col-sm-12 col-md-2">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-1"></div>
                            <div class="col-sm-12 col-md-10">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Clave</th>
                                            <th scope="col">Nombre Comercial de Cliente</th>
                                            <th scope="col">Saldo</th>
                                            <th scope="col" width="10%"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_clientes">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5"></div>
                                    <div class="col-sm-12 col-md-2" style="text-align:right;">
                                        Total
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <input type="text" id="i_total_clientes" name="i_total_clientes" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div>   <!--pantalla_saldos_clientes-->  
    </div>

    <div class="container-fluid"  id="pantalla_saldos_rs">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Saldos Razones Sociales</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar1"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <input type="text" name="i_filtro_rs" id="i_filtro_rs" class="form-control filtrar_renglones" alt="renglon_rs" placeholder="Filtrar" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-2"></div>
                            <div class="col-sm-12 col-md-2">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_excel2"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Nombre Corto</th>
                                            <th scope="col">Razón Social</th>
                                            <th scope="col">Saldo</th>
                                            <th scope="col" width="10%"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_rs">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-7"></div>
                                    <div class="col-sm-12 col-md-1" style="text-align:right;">
                                        Total
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <input type="text" id="i_total_rs" name="i_total_rs" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div> 
    </div>  <!--pantalla_saldos_rs-->

    <div class="container-fluid" id="pantalla_detalle_rs">
        <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Saldos Razones Sociales</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar2"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <input type="text" name="i_filtro_rs_detalle" id="i_filtro_rs_detalle" class="form-control filtrar_renglones" alt="renglon_rs_detalle" placeholder="Filtrar" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-2"></div>
                            <div class="col-sm-12 col-md-2">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_excel3"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group" id="div_registros">
                            <div class="col-sm-12 col-md-12" style="text-align:center;">
                                <label id="label_nombre_sucursal"></label>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">No. Factura</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Monto Factura</th>
                                            <th scope="col">Inicio Periodo</th>
                                            <th scope="col">Fin Periodo</th>
                                            <th scope="col">Estatus de Factura</th>
                                            <th scope="col">Fecha Vencimiento</th>
                                            <th scope="col">Folios Pagos</th>
                                            <th scope="col">Fechas de Pagos</th>
                                            <th scope="col">Pago</th>
                                            <th scope="col">Nota de Credito</th>
                                            <th scope="col">Saldo Final Factura</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_registros">
                                    <table class="tablon"  id="t_registros_rs_detalle">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-1"></div>
                                    <div class="col-sm-12 col-md-1" style="text-align:right;">
                                        Total
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <input type="text" id="i_total" name="i_total" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div> 
    </div>  <!--pantalla_detalle_rs-->

    
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
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='SALDOS_CLIENTES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var fecha = '';

    $(function(){

        $("#pantalla_saldos_clientes").css({left : "0%"});

        mostrarBotonAyuda(modulo);

        mostrarSaldosClientes();

        $('#b_regresar1').click(function(){
            mostrarSaldosClientes();

            $("#pantalla_saldos_rs").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_saldos_clientes').animate({left : "0%"}, 600, 'swing');
        });

        $('#b_regresar2').click(function(){
            var idCliente = $(this).attr('alt');
            mostrarSaldosRazonSocial(idCliente);
            $('#b_excel2').attr({'alt':idCliente});

            $("#pantalla_detalle_rs").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_saldos_rs').animate({left : "0%"}, 600, 'swing');
        });

        function mostrarSaldosClientes(){
            //--> tipo: 1=saldos clientes  2=saldos razones sociales clientes    3=saldos facturas razón social
            $('.renglon_clientes').remove();
            $('.renglon_registros').remove();
            $('#i_total_clientes').val('');
            
            var total=0;

            var datos = {
                'tipo':1
            };
           
            $.ajax({
                type: 'POST',
                url: 'php/clientes_saldos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0 && data!=''){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_clientes">\
                                        <td data-label="Clave">'+data[i].id+'</td>\
                                        <td data-label="Nombre Comercial de Cliente">'+data[i].nombre_comercial+'</td>\
                                        <td data-label="Saldo">'+formatearNumero(data[i].total)+'</td>\
                                        <td width="10%"><button type="button" class="btn btn-info btn-sm b_detalle" alt="'+data[i].id+'">\
                                                <i class="fa fa-cubes" aria-hidden="true"></i>\
                                            </button></td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_clientes tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].total));
                        }

                        $('#i_total_clientes').val(formatearNumero(total));

                        $('#b_excel').prop('disabled',false);

                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="4">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_clientes tbody').append(html);

                        $('#b_excel').prop('disabled',true);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/clientes_saldos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Dash Gastos');
                }
            });
        }

        function mostrarSaldosRazonSocial(idCliente){
            //--> tipo: 1=saldos clientes  2=saldos razones sociales clientes    3=saldos facturas razón social
            $('.renglon_rs').remove();
            $('.renglon_registros').remove();
            $('#i_total_rs').val('');
           
            var total=0;

            var datos = {
                'id':idCliente,
                'tipo':2
            };
           
            $.ajax({
                type: 'POST',
                url: 'php/clientes_saldos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            ///llena la tabla con renglones de registros
                            //-->NJES July/19/2020 se muestra unidad de negoci y sucursal
                            var html='<tr class="renglon_rs">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Nombre Corto">'+data[i].nombre_corto+'</td>\
                                        <td data-label="Razón Social">'+data[i].razon_social+'</td>\
                                        <td data-label="Saldo">'+formatearNumero(data[i].total)+'</td>\
                                        <td width="10%"><button type="button" class="btn btn-info btn-sm b_detalle" alt="'+data[i].id+'" alt2="'+idCliente+'" alt3="'+data[i].razon_social+'">\
                                                <i class="fa fa-cubes" aria-hidden="true"></i>\
                                            </button></td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_rs tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].total));
                        }

                        $('#i_total_rs').val(formatearNumero(total));

                        $('#b_excel2').prop('disabled',false);

                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="4">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_rs tbody').append(html);

                        $('#b_excel2').prop('disabled',true);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/clientes_saldos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Detalle Dash Gastos');
                }
            });
        }

        function mostrarSaldosFacturasRS(idRazonSocial){
            //--> tipo: 1=saldos clientes  2=saldos razones sociales clientes    3=saldos facturas razón social
            $('.renglon_rs_detalle').remove();
            $('.renglon_registros').remove();
            $('#i_total').val('');

            var total=0;

            var datos = {
                'id':idRazonSocial,
                'tipo':3
            };
           
            $.ajax({
                type: 'POST',
                url: 'php/clientes_saldos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        
                            //-->NJES November/20/2020 agregar campos en pantalla y excel
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_rs_detalle">\
                                        <td data-label="No. Factura">'+data[i].folio+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Monto Factura">'+formatearNumero(data[i].monto_factura)+'</td>\
                                        <td data-label="Inicio Periodo">'+data[i].fecha_inicio+'</td>\
                                        <td data-label="Fin Periodo">'+data[i].fecha_fin+'</td>\
                                        <td data-label="Estatus de Factura">'+data[i].estatus+'</td>\
                                        <td data-label="Fecha Vencimiento">'+data[i].vencimiento+'</td>\
                                        <td data-label="Folios Pagos">'+data[i].folios_pagos+'</td>\
                                        <td data-label="Fechas de Pagos">'+data[i].fechas_pagos+'</td>\
                                        <td data-label="Pago">'+formatearNumero(data[i].pago)+'</td>\
                                        <td data-label="Nota de Credito">'+formatearNumero(data[i].nota_credito)+'</td>\
                                        <td data-label="Saldo Final Factura">'+formatearNumero(data[i].saldo)+'</td>\
                                        </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros_rs_detalle tbody').append(html);   
                            
                            total=total+(parseFloat(data[i].monto_factura));
                        }

                        $('#i_total').val(formatearNumero(total));

                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="6">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros_rs_detalle tbody').append(html);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/clientes_saldos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Detalle Dash Gastos');
                }
            });
        }

        $(document).on('click','#t_registros_clientes .b_detalle',function(){
            var idCliente = $(this).attr('alt');
            $('#b_excel2').attr({'alt':idCliente});
            mostrarSaldosRazonSocial(idCliente);
            $("#pantalla_saldos_clientes").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_saldos_rs').animate({left : "0%"}, 600, 'swing');
        });

        $(document).on('click','#t_registros_rs .b_detalle',function(){
            var idRazonSocial = $(this).attr('alt');
            var idCliente = $(this).attr('alt2');
            var razonSocial = $(this).attr('alt3'); 

            $('#b_regresar2').attr('alt',idCliente);  //id del cliente para mostrar sus razones sociales
            $('#b_excel3').attr({'alt':idRazonSocial,'alt_rs':razonSocial});

            //-->NJES December/15/2020 mostrar razón social en el tercer nivel
            $('#label_nombre_sucursal').text('').text(razonSocial);

            mostrarSaldosFacturasRS(idRazonSocial);

            $("#pantalla_saldos_rs").animate({left : "-101%"}, 500, 'swing');
            $('#pantalla_detalle_rs').animate({left : "0%"}, 600, 'swing');
        });

        $('#b_excel').click(function(){

            var datos = {
                'tipo':1
            };

            $("#i_nombre_excel").val('Saldos Clientes');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel2').click(function(){

            var idCliente=$(this).attr('alt');
            var datos = {
                'id':idCliente,
                'tipo':2
            };

            $("#i_nombre_excel").val('Saldos Razones Sociales');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel3').click(function(){

            var idRazonSocial=$(this).attr('alt');
            var razonSocial=$(this).attr('alt_rs');

            var datos = {
                'id':idRazonSocial,
                'razon_social' : razonSocial,
                'tipo':3
            };
            
            $("#i_nombre_excel").val('Saldos Facturas Razón Social');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>