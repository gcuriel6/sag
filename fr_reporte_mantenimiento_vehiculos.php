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

    .Vencida td{
        color:orange;
    }
    .Cancelada td{
        color:red;
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
    
    .abono td{
        background:#D1ECF1;
        color:#004085;
    }


    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-11" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reporte Mantenimiento Vehiculos </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL</button>
                    </div>
                </div>
                <BR>
                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>

                <div class="row">
                    <div class="col-md-6">
                    <input type="text" name="i_filtro" id="i_filtro" class="form-control form-control-sm filtrar_renglones" alt="renglon_registro" placeholder="Filtrar" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                          
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
                </div>
                <hr><!--linea gris-->
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Fecha Pedido</th>
                                    <th scope="col">Requisición</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">No Serie</th>
                                    <th scope="col">No Económico</th>
                                    <th scope="col">IMEI GPS</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Placas</th>
                                    <th scope="col">Kilometraje</th>
                                    <th scope="col">Total</th>
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
  
    var modulo='MANTENIMIENTO_VEHICULOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var nombreReporte='';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        mostrarBotonAyuda(modulo);
        //muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#i_fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha').val(hoy);

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
                buscaReporteManteminiento();
            }
        });

        $('#i_fecha_fin').change(function(){
            buscaReporteManteminiento();
        });


       

        buscaReporteManteminiento();

        function buscaReporteManteminiento(){
            $('#t_registros .renglon').remove();

            $.ajax({
                type: 'POST',
                url: 'php/activos_reporte_mantenimiento_vehiculos.php',
                dataType:"json", 
                data:{
                    'fechaInicio':$('#i_fecha_inicio').val(),
                    'fechaFin':$('#i_fecha_fin').val(),
                },
                success: function(data) {
                    console.log("resultado:"+data);
                    if(data.length != 0){
                
                        for(var i=0;data.length>i;i++){
                           
                            var html='<tr class="renglon renglon_registro">\
                                        <td data-label="Fecha Pedido">'+data[i].fecha_pedido+'</td>\
                                        <td data-label="Factura">'+data[i].requisicion+'</td>\
                                        <td data-label="Fecha">'+data[i].descripcion+'</td>\
                                        <td data-label="No Serie">'+data[i].no_serie+'</td>\
                                        <td data-label="Num Economico">'+data[i].num_economico+'</td>\
                                        <td data-label="IMEI GPS">'+data[i].imei_gps+'</td>\
                                        <td data-label="Modelo">'+data[i].modelo+'</td>\
                                        <td data-label="Placas">'+data[i].placas+'</td>\
                                        <td data-label="Kilometraje">'+formatearNumero(data[i].kilometraje)+'</td>\
                                        <td data-label="Total">'+formatearNumero(data[i].total)+'</td>\
                                     </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html); 

                        }
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="10">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxp_reporte_saldos_proveedores.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de saldos');
                }
            });
        }


        $('#b_excel').click(function()
        {

            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            var datos = 
            {
                'fechaInicio': $("#i_fecha_inicio").val(),
                'fechaFin': $("#i_fecha_fin").val()
            };

            $('#i_nombre_excel').val('REPORTE_MANTENIMIENTO_VEHICULOS');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('MANTENIMIENTO_VEHICULOS');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();

        });
        
    });

</script>

</html>