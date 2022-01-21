<?php session_start(); ?>
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
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_presupuesto{
        max-height:320px;
        min-height:320px;
        overflow:auto;
        border: 1px solid #ddd;
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
    #forma{
        border: 1px solid #ddd;
        padding:0px 5px 20px 5px;
    }
    #i_total{
        text-align:right;
    }
    #campo_filtro_importe{
        width:15%;
    }
    #campo_boton{
        width:5%;
    }

    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_presupuesto{
            height:auto;
            overflow:auto;
        }
        #campo_boton,#campo_filtro_importe{
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
                <div class="row form-group">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Bitacora Presupuesto de Egresos</div>
                    </div>

                    <div class="col-sm-12 col-md-5"></div>

                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                    
                    <div class="col-sm-12 col-md-1"></div>

                </div>

                <form id="forma_consultar" name="forma_consultar">
                    <div class="row">

                        <div class="col-sm-12 col-md-3">
                            <label for="s_id_unidad" class="col-sm-2 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                            <div class="col-sm-12 col-md-12">
                                <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-3">
                            <label for="s_id_sucursal" class="col-sm-2 col-md-6 col-form-label requerido">Sucursal </label>
                            <div class="col-sm-12 col-md-12">
                                <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <div class="col-sm-12 col-md-1">Del:</div>
                            <div class="input-group col-sm-12 col-md-11">
                                <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div> 

                        <div class="col-sm-12 col-md-3">   
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-11">
                                <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly disabled>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                <br>

                <div class="row form-group">
                    <div class="col-md-5">
                        <input type="text" name="i_filtro" id="i_filtro" class="form-control filtrar_renglones" alt="renglon_presupuesto" placeholder="Filtrar..." autocomplete="off">
                    </div>
                    <div class="col-md-5">
                        
                    </div>
                    
                </div>

                <div class="row" id="div_presupuesto">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">FECHA</th>
                                    <th scope="col">USUARIO</th>
                                    <!--<th scope="col">ÁREA</th> 
                                    <th scope="col">DEPARTAMENTO INTERNO</th>-->
                                    <th scope="col">FAMILIA</th>
                                    <th scope="col">CLASIFICACIÓN</th>
                                    <th scope="col">MES</th>
                                    <th scope="col">AÑO</th>
                                    <th scope="col">CAMPOS <BR> MODIFICADOS</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_presupuesto">
                            <table class="tablon"  id="t_presupuesto">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>

                <br>

            </div> <!--div_contenedor-->
        </div>      

        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
            <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
        </form>

    </div> <!--div_principal-->
    
</body>


<!-- DIALOGS -->

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>

<script>

    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var modulo = 'BITACORA_EGRESOS';

    $(function()
    {
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesAcceso('s_id_sucursal', idUnidadActual, idUsuario); 

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() == '')
            {
                $('#i_fecha_inicio').val(primerDiaMes);
                muestraRegistros(primerDiaMes,$('#i_fecha_fin').val());
            }else{
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#i_fecha_fin').val() == '')
            {
                $('#i_fecha_fin').val(ultimoDiaMes);
                muestraRegistros($('#i_fecha_inicio').val(),ultimoDiaMes);
            }else{
                muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            }
        });

                
        $('#s_id_unidad').change(function(){
            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesAcceso('s_id_sucursal', idUnidadNegocio, idUsuario);
        });

        $('#s_id_sucursal').change(function(){
           var idSucursal = $('#s_id_sucursal').val();
           if(idSucursal>0){
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
           }
        });

        function muestraRegistros(fechaInicio,fechaFin){
            
            $('#t_presupuesto >tbody tr').remove();
            var idUnidad =  $('#s_id_unidad').val();
            var idSucursal = $('#s_id_sucursal').val();

            $.ajax({

                type: 'POST',
                url: 'php/presupuesto_egresos_bitacora_buscar.php',
                dataType:"json", 
                data:
                {   
                    'modulo':'PRESUPUESTO_EGRESOS',
                    'idUnidad': idUnidad,
                    'idSucursal': idSucursal,
                    'fechaInicio': fechaInicio,
                    'fechaFin': fechaFin
                },
                success: function(data)
                {
                    console.log(data);
                    if(data.length > 0)
                    {
                        for(var i=0; data.length > i; i++)
                        {
                            var presupuesto = data[i];                        

                            var html = "<tr class='renglon_presupuesto'>";
                            html += "<td>" + presupuesto.fecha_modificacion + "</td>";
                            html += "<td>" + presupuesto.usuario+ "</td>";
                            //-->NJES July/15/2020 se quita area y departamento ya que no se usan en la carga r consumo de presupuesto egresos
                            //html += "<td>" + presupuesto.nombre_area + "</td>";
                            //html += "<td>" + presupuesto.nombre_depto + "</td>";
                            html += "<td>" + presupuesto.nombre_familia + "</td>";
                            html += "<td>" + presupuesto.nombre_clasificacion + "</td>";
                            html += "<td>" + presupuesto.mes + "</td>";
                            html += "<td>" + presupuesto.anio + "</td>";
                            html += "<td align='right'>" + presupuesto.campos_modificados +  "</td>";                            
                            html += "</tr>";

                            $('#t_presupuesto tbody').append(html);
                        
                        }
                    }else{
                        var html = '<tr><td colspan="7" align="center">No se encontró información</td></tr>';
                        $('#t_presupuesto tbody').append(html);
                    }

                 
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_bitacora_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

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
                'idUnidadNegocio':$('#s_id_unidad').val(),
                'idSucursal':$('#s_id_sucursal').val(),
                'fechaInicio':fechaInicio,
                'fechaFin':fechaFin,
                'tipo':'PRESUPUESTO_EGRESOS'
            };

            $("#i_nombre_excel").val('Bitacora Presupuesto de Egresos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });
</script>

</html>