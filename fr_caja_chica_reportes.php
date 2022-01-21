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
    #div_t_registros{
        max-height:400px;
        overflow:auto;
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

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_registros{
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
                <div class="form-group row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes de Caja Chica</div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control"  id="b_pdf" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group row">
                            <label for="s_id_unidades" class="col-sm-12 col-md-5 col-form-label">Unidad de Negocio</label>
                            <div class="col-sm-12 col-md-7">
                                <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="s_id_sucursales" class="col-sm-12 col-md-5 col-form-label">Sucursal</label>
                            <div class="col-sm-12 col-md-7">
                                <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-7">
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
                            <div class="col-sm-12 col-md-5">
                                <div class="row">
                                    <label for="i_saldo_inicial" class="col-sm-12 col-md-4 col-form-label">Saldo Inicial</label> 
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" name="i_saldo_inicial" id="i_saldo_inicial" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <input type="text" name="i_filtro" id="i_filtro" alt="renglon_registros" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <div class="row">
                                    <label for="i_saldo_final" class="col-sm-12 col-md-4 col-form-label">Saldo Final</label> 
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" name="i_saldo_final" id="i_saldo_final" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Unidad de Negocio</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Área</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Saldo</th>
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

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
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
  
    var modulo='REPORTES_CCH';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermisoCajaChica('s_id_sucursales',idUnidadActual,modulo,idUsuario);

        $('#s_id_unidades').change(function(){
            muestraSucursalesPermisoCajaChica('s_id_sucursales',$('#s_id_unidades').val(),modulo,idUsuario);
            $('#b_excel').prop('disabled',false);
            $('#b_pdf').prop('disabled',false);
            //-->NJES March/12/2020 se limpia busqueda registros
            $('#t_registros tbody').empty();
        });

        $('#s_id_sucursales').change(function(){
            $('#b_excel').prop('disabled',false);
            $('#b_pdf').prop('disabled',false);

            mostrarSaldos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio').change(function(){
            if($('#s_id_sucursales').val() != null)
            {
                if($('#i_fecha_inicio').val() == '')
                {
                    $('#i_fecha_inicio').val(primerDiaMes);
                    mostrarSaldos(primerDiaMes,$('#i_fecha_fin').val());
                    mostrarRegistros(primerDiaMes,$('#i_fecha_fin').val());
                }else{
                    mostrarSaldos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                    mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                }
            }else{
                mandarMensaje('Selecciona una sucursal');
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_id_sucursales').val() != null)
            {
                if($('#i_fecha_fin').val() == '')
                {
                    $('#i_fecha_fin').val(ultimoDiaMes);
                    mostrarSaldos($('#i_fecha_inicio').val(),ultimoDiaMes);
                    mostrarRegistros($('#i_fecha_inicio').val(),ultimoDiaMes);
                }else{
                    mostrarSaldos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                    mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                }
            }else{
                mandarMensaje('Selecciona una sucursal');
            }
        });

        function mostrarSaldos(fechaInicio,FechaFin){
            var datos = {
                'idSucursal':$('#s_id_sucursales').val(),
                'fechaInicio':fechaInicio,
                'fechaFin':FechaFin
            };

            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_saldos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    $('#i_saldo_inicial').val(formatearNumero(data.saldo_inicial));
                    $('#i_saldo_final').val(formatearNumero(data.saldo_final));
                },
                error: function (xhr) 
                {
                    console.log('php/caja_chica_saldos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de saldos de caja chica');
                }
            });
        }

        function mostrarRegistros(fechaInicio,FechaFin){
            $('.renglon_registros').remove();

            var datos = {
                'idSucursal':$('#s_id_sucursales').val(),
                'fechaInicio':fechaInicio,
                'fechaFin':FechaFin
            };
           
            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_saldos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {

                    var saldoFinal = data.saldo_final;
                    var saldoInicial = data.saldo_inicial;
                    var saldoRestante = 0;

                    $.ajax({
                        type: 'POST',
                        url: 'php/caja_chica_buscar.php',
                        dataType:"json", 
                        data:  {'datos':datos},
                        success: function(data) {
                            if(data.length != 0){

                                saldoRestante = parseFloat(saldoInicial);
                                
                                var num=data.length;
                                for(var i=0;data.length>i;i++){

                                    if(data[i].nombre_empleado != '')
                                    {
                                        var empleado = data[i].nombre_empleado;
                                    }else{
                                        var empleado = data[i].empleado;
                                    }

                                    saldoRestante += parseFloat(data[i].saldo);
                                    console.log("importe:",data[i].saldo,"- saldo:",saldoRestante);
                                
                                    ///llena la tabla con renglones de registros
                                    var html='<tr class="renglon_registros">\
                                                <td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>\
                                                <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                                <td data-label="Área">'+data[i].area+'</td>\
                                                <td data-label="Departamento">'+data[i].departamento+'</td>\
                                                <td data-label="Empleado">'+empleado+'</td>\
                                                <td data-label="Observaciones">'+data[i].observaciones+'</td>\
                                                <td data-label="Fecha">'+data[i].fecha+'</td>\
                                                <td data-label="Concepto">'+data[i].concepto+'</td>\
                                                <td data-label="Monto">'+formatearNumero(data[i].importe)+'</td>\
                                                <td data-label="Saldo">'+formatearNumero(saldoRestante)+'</td>\
                                            </tr>';
                                    ///agrega la tabla creada al div 
                                    $('#t_registros tbody').append(html);   
                                    
                                }

                            }else{
                                var html='<tr class="renglon_registros">\
                                                <td colspan="9">No se encontró información</td>\
                                            </tr>';

                                $('#t_registros tbody').append(html);

                            }
                        },
                        error: function (xhr) 
                        {
                            console.log('php/caja_chica_buscar.php --> '+JSON.stringify(xhr));
                            mandarMensaje('* No se encontró información al buscar reporte de caja chica');
                        }
                    });
                },
                error: function (xhr) 
                {
                    console.log('php/caja_chica_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar reporte de caja chica');
                }
            });
        }

        $('#b_pdf').click(function(){

            if($('#i_fecha_inicio').val() != '')
            {
                var fechaInicio = $('#i_fecha_inicio').val();
            }else{
                var fechaInicio = primerDiaMes;
            }

            if($('#i_fecha_fin').val() != '')
            {
                var fechaFin = $('#i_fecha_fin').val();
            }else{
                var fechaFin = ultimoDiaMes;
            }

            var datos = {
                    'path':'formato_caja_chica_sucursal',
                    'idRegistro':$('#s_id_sucursales').val(),
                    'fechaInicio':fechaInicio,
                    'fechaFin':fechaFin,
                    'nombreArchivo':'caja_chica_'+$('#s_id_sucursales options:selected').text(),
                    'tipo':3
                };

                let objJsonStr = JSON.stringify(datos);
                let datosJ = datosUrl(objJsonStr);
                
                window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        });

        $('#b_excel').click(function(){

            if($('#i_fecha_inicio').val() != '')
            {
                var fechaInicio = $('#i_fecha_inicio').val();
            }else{
                var fechaInicio = primerDiaMes;
            }

            if($('#i_fecha_fin').val() != '')
            {
                var fechaFin = $('#i_fecha_fin').val();
            }else{
                var fechaFin = ultimoDiaMes;
            }
            
            var datos = {
                'idSucursal':$('#s_id_sucursales').val(),
                'fechaInicio':fechaInicio,
                'fechaFin':fechaFin
            };
            
            $("#i_nombre_excel").val('Reportes Caja Chica');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('REPORTES_CCH');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });
        
    });

</script>

</html>