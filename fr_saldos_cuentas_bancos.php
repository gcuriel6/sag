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
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes Saldos Cuentas Bancos</div>
                    </div>
                    <div class="col-sm-12 col-md-1">
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <label for="i_fecha_inicio" class="col-sm-12 col-md-2 col-form-label">Del</label>
                                    <div class="input-group col-sm-12 col-md-8">
                                        <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                        <div class="input-group-addon input_group_span">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <label for="i_fecha_fin" class="col-sm-12 col-md-2 col-form-label">Al</label>
                                    <div class="input-group col-sm-12 col-md-8">
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
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" alt="BOTON_EXCEL_SALDO_CUENTAS_BANCOS" id="b_excel_saldos"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Saldos</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Banco</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Saldo Inicial</th>
                                    <th scope="col">Saldo Final</th>
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
  
    var modulo='SALDOS_CUENTAS_BANCOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var nombreReporte='';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio,#i_fecha_fin').change(function(){
            buscaSaldosCuentasBancos();
        });

        buscaSaldosCuentasBancos();

        function buscaSaldosCuentasBancos(){
            $('#t_registros .renglon').remove();

            $.ajax({
                type: 'POST',
                url: 'php/movimientos_saldos_cuentas_bancos_buscar.php',
                dataType:"json", 
                data:{'fechaInicio' : $('#i_fecha_inicio').val(),
                      'fechaFin' : $('#i_fecha_fin').val()},
                success: function(data) {
                    if(data.length != 0){
                
                        for(var i=0;data.length>i;i++){
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon">\
                                        <td data-label="Cuenta">'+data[i].cuenta+'</td>\
                                        <td data-label="Banco">'+data[i].banco+'</td>\
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td data-label="Saldo Inicial">$'+formatearNumero(data[i].saldo_inicial)+'</td>\
                                        <td data-label="Saldo Final">$'+formatearNumero(data[i].saldo_final)+'</td>\
                                        </td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html); 

                        }
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="4">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/movimientos_saldos_cuentas_bancos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de saldos');
                }
            });
        }

        $('#b_excel_saldos').click(function(){
            if($('#i_fecha').val() != '')
            {
                var datos = {
                    'fechaInicio':$('#i_fecha_inicio').val(),
                    'fechaFin':$('#i_fecha_fin').val()
                };
                
                $("#i_nombre_excel").val('Saldo Cuentas Bancos');
                $("#i_fecha_excel").val($('#i_fecha').val());
                $('#i_modulo_excel').val(modulo);
                $('#i_datos_excel').val(JSON.stringify(datos));
                
                $("#f_imprimir_excel").submit();
            }else{
                mandarMensaje('Selecciona una fecha para generar reporte');
            }
        });
        
    });

</script>

</html>