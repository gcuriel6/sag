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
    .div_contenedor{
        background-color: #ffffff;
    }
    #fondo_cargando{
        position: absolute;
        top: 1%;
        background-image:url('imagenes/3.svg');
        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:3%;
        border-radius: 5px;
        z-index:2000;
        display:none;
    }
    
</style>

<body>
    <div><input id="i_id_sucursal" type="hidden"/></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-1 col-lg-2"></div>
            <div class="col-sm-12 col-md-10 col-lg-8 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="titulo_ban">Generar Recibos</div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <label for="s_id_sucursales" class="col-md-1 col-form-label requerido">Sucursal </label>
                            <div class="col-md-5">
                                <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm filtros" autocomplete="off" style="width:100%;"></select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-1 requerido">Del: </div>
                                    <div class="input-group col-sm-12 col-md-5">
                                        <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                        <div class="input-group-addon input_group_span">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div> 
                                    <div class="col-sm-12 col-md-1 requerido">Al: </div>
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
                        <div class="row">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-4">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_generar_recibos" disabled><i class="fa fa-list-alt" aria-hidden="true"></i> Generar Recibos</button>
                            </div>
                            <div class="col-sm-12 col-md-1"></div>
                            <div class="col-sm-12 col-md-2" id="div_b_descargar_RF" style="display:none;">
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_descargar_RF" data-toggle="tooltip" data-placement="bottom" data-html="true" title="">
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Generar
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12" style="color:green; font-size:11px;">* Si los archivos pdf de los recibos se tardan 
                            aproximadamente mas de 32 segundos en generarse, puede que no se generen, verifica que tengan buena conexion y velocidad de internet, 
                            ó prueba con un rango de fechas menor.</div>
                        </div>
                        <h>
                        <div class="row" >
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-4" id="div_botones"></div>
                        </div>
                    </div>  
                </div>
            <br>
           </div> <!--div_contenedor-->
        </div>      
    </div>
    <div id="fondo_cargando"></div>

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
 
    var modulo='RECIBOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');

        function habilitaBoton(){
            if($('#s_id_sucursales').val() != null && $('#i_fecha_inicio').val() != '' && $('#i_fecha_fin').val() != '')
            {
                $('#b_generar_recibos').prop('disabled',false);
            }else{
                $('#b_generar_recibos').prop('disabled',true);
            }
        }

        //$('[data-toggle="tooltip"]').tooltip();

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        }); 

        $('#s_id_sucursales,#i_fecha_inicio,#i_fecha_fin').change(function(){
            habilitaBoton();
        });

        $('#b_generar_recibos').click(function()
        {

            $('#b_generar_recibos').prop('disabled',true);
            $('#fondo_cargando').show();
            $('#div_b_descargar_RF').css('display','none');
            $('#div_botones').empty();

            var info = {
                'idUnidadNegocio' : idUnidadActual,
                'idSucursal' : $('#s_id_sucursales').val(),
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val(),
                'usuario' : usuario,
                'idUsuario' : idUsuario
            };

            $.ajax({
                type: 'POST',
                url: 'php/recibos_generar.php',
                dataType:"json", 
                data : {'datos':info},
                success: function(data)
                {

                    //console.log('-> ' + JSON.stringify(data));
                    //console.log('-> ' + data);

                    if(data.dato == 1)
                        generaPDF(data.valor,data.warning,data.bloques,data.num_recibos_sf);
                    else
                    {
                        $('#fondo_cargando').hide();
                        mandarMensaje('No existen datos para generar recibos.');
                    }

                    $('#b_generar_recibos').prop('disabled', false);

                },
                error: function (xhr)
                {
                    console.log('php/recibos_generar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al generar recibos.');
                    $('#b_generar_recibos').prop('disabled',false);
                    $('#fondo_cargando').hide();
                }
            });

        });

        function generaPDF(valor,info,numBloques,numRecibosSF){
            //console.log('numBloques: '+JSON.stringify(numBloques));
            $('#div_botones').html('');
            $('#div_botones').empty();
            var cont = 0; 
            var inicia = 1;
            for(var i=0; i<numBloques.length; i++){
                var bloque = numBloques[i].bloques;
                cont = cont+(parseInt(numBloques[i].totales))
                
                /*var datos = {
                    'path':'formato_recibo',
                    'nombreArchivo':bloque+'_Recibos_'+$('#i_fecha_inicio').val()+'_'+$('#i_fecha_fin').val(),
                    'tipo':4,
                    'numBloque':bloque,
                    'idUnidadNegocio' : idUnidadActual,
                    'idSucursal' : $('#s_id_sucursales').val(),
                    'fechaInicio' : $('#i_fecha_inicio').val(),
                    'fechaFin' : $('#i_fecha_fin').val()
                };

                let objJsonStr = JSON.stringify(datos);
                let datosJ = datosUrl(objJsonStr);

                window.open("php/convierte_pdf.php?D="+datosJ,'_blank');*/

                var html='<button type="button" alt="'+bloque+'" class="btn btn-success btn-sm form-control boton_genera"><i class="fa fa-list-alt" aria-hidden="true"></i> Generar Recibos Del '+inicia+' al '+cont+'</button><br>';
                $('#div_botones').append(html);
                inicia = cont+1;
            }

            if(numRecibosSF > 0)
            {
                $('#div_b_descargar_RF').css('display','block');
                $('#b_descargar_RF').attr('title',' Existen '+numRecibosSF+' recibos que facturan pero no tienen datos para facturar.');
            }

            $('#fondo_cargando').hide();
            ///mandarMensaje('Se han generado los recibos en PDF.');
            if(valor > 0)
                mandarMensaje(info);
        }

        $(document).on('click','.boton_genera',function(){
            var valor = $(this).attr('alt');
            $('#fondo_cargando').show();
            var datos = {
                'path':'formato_recibo',
                'nombreArchivo':valor+'_Recibos_'+$('#i_fecha_inicio').val()+'_'+$('#i_fecha_fin').val(),
                'tipo':4,
                'numBloque':valor,
                'idUnidadNegocio' : idUnidadActual,
                'idSucursal' : $('#s_id_sucursales').val(),
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val()
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_blank');


            $('#fondo_cargando').hide();
            mandarMensaje('Se han generado los recibos en PDF.');
        });

        $('#b_descargar_RF').click(function(){
            $("#i_nombre_excel").val('Recibos para facturar sin factura');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>