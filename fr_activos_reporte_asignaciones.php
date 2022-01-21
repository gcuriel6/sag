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
        #div_t_registros{
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
            <!--<div class="col-md-1"></div>-->
            <div class="col-md-offset-1 col-md-12" id="div_contenedor">
            <br>
                <div class="row form-group">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reporte Activos Fijos Historial Asignaciones</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>
                <form id="forma_salida_comodato" name="forma_salida_comodato">
                    <div class="form-group row"> 
                        <div class="col-sm-12 col-md-2">
                            <label for="s_id_unidades" class="col-sm-12 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>                       
                        <div class="col-md-4">
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
                        <!--<div class="col-md-2" style="text-align:center;">
                            <input type="checkbox" id="ch_responsable_mostrar_todo" name="ch_responsable_mostrar_todo" alt="" value=""> Mostrar Todo
                        </div>-->
                    </div>
                </form>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><input type="text" id="i_filtro_1" name="i_filtro_1" alt="i_filtro1" alt2="1" alt3="renglon_registro" alt4="5" class="form-control filtrar_campos_renglones" placeholder="No. Empleado" style="font-size:14px;" autocomplete="off"></th>
                                <th><input type="text" id="i_filtro_2" name="i_filtro_2" alt="i_filtro2" alt2="2" alt3="renglon_registro" alt4="5" class="form-control filtrar_campos_renglones" placeholder="No. Cliente" style="font-size:14px;" autocomplete="off"></th>
                                <th><input type="text" id="i_filtro_3" name="i_filtro_3" alt="i_filtro3" alt2="3" alt3="renglon_registro" alt4="5" class="form-control filtrar_campos_renglones" placeholder="Responsable" style="font-size:14px;" autocomplete="off"></th>
                                <th><input type="text" id="i_filtro_4" name="i_filtro_4" alt="i_filtro4" alt2="4" alt3="renglon_registro" alt4="5" class="form-control filtrar_campos_renglones" placeholder="No. Serie" style="font-size:14px;" autocomplete="off"></th>
                                <th><input type="text" id="i_filtro_5" name="i_filtro_5" alt="i_filtro5" alt2="5" alt3="renglon_registro" alt4="5" class="form-control filtrar_campos_renglones" placeholder="No. Economico" style="font-size:14px;" autocomplete="off"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr class="renglon">
                                <th scope="col">Razón Social</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Área</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">No. Empleado</th>
                                <th scope="col">No. Cliente</th>
                                <th scope="col">Responsable</th>
                                <th scope="col">(No. Serie)</th>
                                <th scope="col">(No. Economico)</th>
                                <th scope="col">IMEI GPS</th>
                                <th scope="col">Descripción Activo</th>
                                <th scope="col">Asignación - Fecha Inicio</th>
                                <th scope="col">Asignación - Fecha Fin</th>
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
 
    var modulo='REPORTE_ACTIVOS_ASIGNACIONES';
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
     
        muestraRegistros(primerDiaMes,ultimoDiaMes);

        $('#s_id_unidades').change(function(){
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#i_fecha_inicio').change(function(){
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#i_fecha_fin').change(function(){
            muestraRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        function muestraRegistros(fechaInicio,fechaFin){

            $('#t_registros tbody').html('');

            $.ajax({
                type: "POST",
                url: "php/activos_responsables_filtro.php",
                data: {
                    'unidad' : $('#s_id_unidades').val(),
                    'idActivo' : 0,
                    'fechaInicio' : fechaInicio,
                    'fechaFin' : fechaFin
                },
                dataType: 'json',
                success: function(data){
                    if(data.length>0)
                    {
                        var respon = "";
                        for (var i = 0; i < data.length; i++) {
                            var actual=data[i];
                            respon += "<tr class='renglon_registro' alt="+actual.id+">";
                            respon += "<td>" + actual.razon_social + "</td>";
                            respon += "<td>" + actual.sucursal + "</td>";
                            respon += "<td>" + actual.areas + "</td>";
                            respon += "<td>" + actual.dpto + "</td>";
                            respon += "<td class='i_filtro1'>" + actual.id_trabajador + "</td>";
                            respon += "<td class='i_filtro2'>" + actual.id_cliente + "</td>";
                            respon += "<td class='i_filtro3'>" + actual.responsable + "</td>";
                            respon += "<td class='i_filtro4'>" + actual.no_serie + "</td>";
                            respon += "<td class='i_filtro5'>" + actual.num_economico + "</td>";
                            respon += "<td>" + actual.imei_gps + "</td>";
                            respon += "<td>" + actual.descripcion + "</td>";
                            respon += "<td>" + actual.fecha_inicio + "</td>";
                            respon += "<td>" + (actual.fecha_fin=='0000-00-00'? "" : actual.fecha_fin) + "</td>";
                            respon += "</tr>";
                        }
                        
                        $("#t_registros tbody").html(respon);
                        $('#b_excel').prop('disabled',false);
                    }else{
                        $('#b_excel').prop('disabled',true);
                        var html = "<tr><td colspan='12'>No se encontro información</td></tr>";

                        $("#t_registros tbody").html(html);
                    }
                },
                    error: function (data){
                    console.log("php/activos_responsables_filtro.php-->"+JSON.stringify(data));
                    mandarMensaje("* Error al buscar activos asignaciones");
                }
            });
        }

        $('#b_excel').click(function(){
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            var idUnidadNegocio = $('#s_id_unidades').val();  

            var datos = {
                'idUnidadNegocio':idUnidadNegocio,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val()
            };
            
            $("#i_nombre_excel").val('Reporte Activos Historial Asignaciones');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>