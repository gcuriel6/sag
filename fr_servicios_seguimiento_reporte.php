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
                        <div class="titulo_ban">REPORTE SEGUIMIENTO TÉCNICO</div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-2">
                        <!--<button type="button" class="btn btn-info btn-sm form-control"  id="b_pdf" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>-->
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="i_filtro" id="i_filtro" alt="renglon_registros" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                            </div>
                        </div>
                    </div>
                   <!--NJES October/21/2020 se agrega filtro sucursal-->
                   <label for="s_id_sucursales_filtro" class="col-sm-2 col-md-1 col-form-label requerido">Sucursal </label>
                    <div class="col-sm-12 col-md-3">
                        <select id="s_id_sucursales_filtro" name="s_id_sucursales_filtro" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <div class="col-sm-12 col-md-4">
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

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon" id="t_registros">
                            <thead>
                                <tr class="renglon">
                                   <th scope="col" width="10%">Sucursal</th>
                                    <th scope="col" width="10%">Folio</th>
                                    <th scope="col" width="20%">Servicio</th>
                                    <th scope="col" width="20%">Descripción</th>
                                    <th scope="col" width="20%">Técnico</th>
                                    <th scope="col" width="20%">Atención</th>
                                    <th scope="col" width="5%">Hora <br>Llegada</th>
                                    <th scope="col" width="5%">GPS <br> Llegada</th>
                                    <th scope="col" width="5%">Hora <br>Salida</th>
                                    <th scope="col" width="5%">GPS <br> Salida</th>
                                </tr>
                            </thead>
                            <tbody>
                                    
                            </tbody>
                        </table>
                        <!--<div id="div_t_registros">
                            <table class="tablon"  id="t_registros">
                                
                            </table>  
                        </div> --> 
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
  
    var modulo='REPORTE_SEGUIMIENTO_ORDENES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
      
        mostrarRegistros(primerDiaMes,ultimoDiaMes);
            
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio').change(function(){
            
            if($('#i_fecha_inicio').val() == '')
            {
                $('#i_fecha_inicio').val(primerDiaMes);
    
                mostrarRegistros(primerDiaMes,$('#i_fecha_fin').val());
            }else{

                mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            }
            
        });

        $('#i_fecha_fin').change(function(){
            
            if($('#i_fecha_fin').val() == '')
            {
                $('#i_fecha_fin').val(ultimoDiaMes);
                
                mostrarRegistros($('#i_fecha_inicio').val(),ultimoDiaMes);
            }else{
                
                mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            }
           
        });

        //-->NJES October/21/2020 se agrega filtro sucursal
        $('#s_id_sucursales_filtro').change(function(){
            mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        function mostrarRegistros(fechaInicio,FechaFin){
            $('.renglon_registros').remove();

            //-->NJES October/21/2020 se agrega filtro sucursal
            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);
           
            $.ajax({
                type: 'POST',
                url: 'php/servicios_ordenes_seguimiento_reporte.php',
                dataType:"json", 
                data:  {
                    'idsSucursales':idSucursal,
                    'fechaInicio':fechaInicio,
                    'fechaFin':FechaFin
                },
                success: function(data) {
                    console.log(data);
                    if(data.length != 0){
                        $('#b_excel').prop('disabled',false);
                        $('#b_pdf').prop('disabled',false);
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros">\
                                        <td aling="top" width="10%" data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td aling="top" width="10%" data-label="Folio">'+data[i].folio+'</td>\
                                        <td aling="top" width="20%" data-label="Servicio">'+data[i].servicio+'</td>\
                                        <td aling="top" width="20%" data-label="Descripcion">'+data[i].descripcion+'</td>\
                                        <td aling="top" width="20%" data-label="Tecnico">'+data[i].tecnico+'</td>\
                                        <td aling="top" width="20%" data-label="Fecha Atención">'+data[i].fecha_atencion+'</td>\
                                        <td aling="top" width="5%" data-label="Hora Llegada">'+data[i].hora_llegada+'</td>\
                                        <td aling="top" width="5%" data-label="GPS Llegada">'+data[i].gps_llegada+'</td>\
                                        <td aling="top" width="5%" data-label="Hora Salida">'+data[i].hora_salida+'</td>\
                                        <td aling="top" width="5%" data-label="GPS Salida">'+data[i].gps_salida+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            
                            $('#t_registros tbody').append(html);   
                            
                        }

                    }else{
                        $('#b_excel').prop('disabled',true);
                        $('#b_pdf').prop('disabled',true);
                        var html='<tr class="renglon_registros">\
                                        <td colspan="9">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/servicios_ordenes_buscar_reporte.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar reporte de ordenes de servicio');
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

            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);
            
            var datos = {
                'idsSucursal':idSucursal,
                'fechaInicio':fechaInicio,
                'fechaFin':fechaFin
            };
            
            $("#i_nombre_excel").val('Reporte Seguimiento Tecnico');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });
        
    });

</script>

</html>