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

    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>-->
</head>

<style>
    

    #fondo_cargando
    {

        position: absolute;
        top: 1%;
        background-image:url('imagenes/3.svg');

        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        /*background-color:#000;*/
        left: 1%;
        width: 98%;
        bottom:3%;
        /*border: 2px solid #6495ed;*/
        /*opacity: .1;*/
        /*filter:Alpha(opacity=10);*/
        border-radius: 5px;
        z-index:2000;
        display:none;
        
    }

    body{
        background-color:rgb(238,238,238);
    }
    #div_contenedor{
        background-color: #ffffff;
        padding-bottom:10px;
    }
    #div_t_facturas{
        max-height:200px;
        min-height:200px;
        overflow-y:auto;
        border: 1px solid #ddd;
        overflow-x:hidden;
    }
    #div_t_facturas_canceladas,
    #div_t_buscar_notas_credito,
    #div_t_notas_credito{
        max-height:300px;
        min-height:300px;
        overflow-y:auto;
        overflow-x:hidden;
    }
    #div_t_facturas_relacionadas
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
    #div_radio_iva,
    #div_radio_iva_nc{
        padding-top:28px;
    }
    .boton_eliminar{
        width:50px;
    }
    #dialog_visita > .modal-lg,
    #dialog_sustituir > .modal-lg,
    #dialog_buscar_notas_credito > .modal-lg,
    #dialog_notas_credito > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    } 
    #div_b_timbrar,
    .secundarios,
    #div_b_verificar_estatus,
    #div_b_descargar_acuse,
    #div_cont_estatus,
    #div_relacion_facturas{
        display:none;
    }
    #forma_notas_credito{
        border: 1px solid #ddd;
        padding:15px;
    }
    #dialog_correo{
        z-index:2000;
    }
    .modal{
        overflow-y: scroll !important;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_facturas,
        #div_t_facturas_canceladas,
        #div_t_buscar_notas_credito,
        #div_t_notas_credito{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
        #div_radio_iva,
        #div_radio_iva_nc{
            padding-top:10px;
        }
        .boton_eliminar{
            width:100%;
        }
        #dialog_vdffisita > .modal-lg,
        #dialog_fgsustituir > .modal-lg,
        #dialog_buscar_notas_credito > .modal-lg,
        #dialog_notas_credito > .modal-lg{
            max-width: 100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-12" id="div_contenedor">
            <br>

                <div class="form-group row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Seg. Técnico de Ordenes de Servicio</div>
                    </div>
                </div>

                
                <div class="form-group row">
                    <label for="s_id_sucursales" class="col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                    <div class="col-sm-4 col-md-4">
                        <select id="s_id_sucursales" name="s_id_sucursales" class="form-control" autocomplete="off" style="width:100%;"></select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">

                        <table class="tablon" id="t_seg">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Nom. Corto</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Servicio</th>
                                    <th scope="col">Descripcíón</th>
                                    <th scope="col">Prioridad</th>
                                    <th scope="col">Fecha Programada</th>
                                    <th scope="col" width="40px"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div> <!--div_contenedor-->

        </div>   

    </div> <!--div_principal-->


</body>

<div id="fondo_cargando"></div>

<div id="dialog_visita" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Seg. Técnico</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-4"></div>
                <div class="col-sm-12 col-md-4">
                    <input type="hidden" id="i_id_orden_servicio" name="i_id_orden_servicio">
                    <input type="hidden" id="location">
                    <input type="hidden" id="latitud">
                    <input type="hidden" id="longitud">
                    <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Visita</button>
                </div>
                <div class="col-sm-12 col-md-4"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_visitas">
                    <thead>
                       <!--<tr class="renglon">
                            <th scope="col"></th>
                            <th scope="col" colspan="4">LLEGADA</th>

                            <th scope="col" colspan="4">SALIDA</th>

                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>--> 
                        <tr class="renglon">
                            <th scope="col">Técnico</th>
                            <th scope="col">HORA</th>
                            <th scope="col">LATITUD</th>
                            <th scope="col">LONGITUD</th>
                            <th scope="col">UBICACIÓN</th>

                            <!--<th scope="col">HORA</th>
                            <th scope="col">LATITUD</th>
                            <th scope="col">LONGITUD</th>
                            <th scope="col">UBICACIÓN</th>-->

                            <th scope="col">OBSERVACIONES</th>
                            <th scope="col" width="5%"></th>
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

<div id="dialog_cerrar" class="modal fade bd-example-modal-lg" tabindex="1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Seg. Técnico</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <!---->
                <div class="col-sm-12 col-md-12">
                    <label for="i_obs" class="col-md-2 col-form-label">Observaciones</label>
                    <input type="hidden" id="i_id_orden_servicio_cerrar" name="i_id_orden_servicio_cerrar">
                    <textarea type="text" id="i_obs" name="i_obs" class="form-control form-control-sm"  autocomplete="off"></textarea>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4"></div>
                <div class="col-sm-12 col-md-4">
                    
                    <button type="button" class="btn btn-secondary btn-sm form-control" id="b_cerrar_visita"><i class="fa fa-close" aria-hidden="true"></i> Cerrar Visita</button>
                </div>
                <div class="col-sm-12 col-md-4"></div>
            </div> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>

<div id="dialog_observaciones_visita" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form_observaciones_visita" name="form_observaciones_visita">
                <div class="row">
                    <div class="col-md-12">
                        <label for="ta_observaciones_visita">Observaciones</label>
                        <textarea class="form-control validate[required]" id="ta_observaciones_visita" rows="3"></textarea>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="b_guardar_visita" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
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
  
    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']?>;
    var usuario = '<?php echo $_SESSION['usuario']?>';
    var modulo = 'ORDEN_SERVICIO';//'SEG_ORDENES';

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function()
    {

        //
        muestraSucursalesPermiso('s_id_sucursales', idUnidadActual, modulo, idUsuario);

        $('#s_id_sucursales').change(function()
        {
            var idSuc = $(this).val();
            
            $.ajax({
                type: 'POST',
                url: 'php/servicios_seg.php',
                dataType: "json", 
                data : {'id_sucursal': idSuc},
                success: function(data)
                {   

                    $('#t_seg tbody').html('');

                    for(var i=0; data.length>i; i++)
                    {

                        var ordenServicio = data[i];
                        var html = '';

                        html += '<tr class="renglon_ordenes" id_orden_servicio="' + ordenServicio.id + '" >';
                        html += '<td>' + ordenServicio.n_corto + '</td>';
                        html += '<td>' + ordenServicio.razon_social + '</td>';
                        html += '<td>' + ordenServicio.servicio + '</td>';
                        html += '<td>' + ordenServicio.descripcion + '</td>';
                        html += '<td>' + (ordenServicio.prioridad == 1 ? 'BAJA' : (ordenServicio.prioridad == 2 ? 'MEDIA' : 'ALTA')) + '</td>';
                        html += '<td>' + ordenServicio.fecha + '</td>';
                        html += '<td><button type="button" class="btn btn-success btn-sm form-control add-os" id_orden_servicio="' + ordenServicio.id + '"   ><i class="fa fa-plus" style="font-size:10px;" aria-hidden="true"></i></button></td>';
                        html += '</tr>';

                        $('#t_seg tbody').append(html);

                    }
                       

                },
                error: function (xhr)
                {
                    console.log(' ****************************** --> '+JSON.stringify(xhr));
                }
            });

        });

        //$('#dialog_relacion_facturas').modal('show');
        $(document).on('click','.add-os',function()
        {

            //$('#dato_id_cliente').val($(this).attr('id_cliente'));
            var idOS = $(this).attr('id_orden_servicio');
            $('#dialog_visita').modal('show');
            $('#i_id_orden_servicio').val(idOS);
            buscarVisistas(idOS);

        });

        function buscarVisistas(idOrdenServico)
        {

            $.ajax({
                type: 'POST',
                url: 'php/servicios_visitas_buscar.php',
                dataType: "json", 
                data : {'id_orden_servicio': idOrdenServico},
                success: function(data)
                {   

                    $('#t_visitas tbody').html('');

                    for(var i=0; data.length>i; i++)
                    {

                        var visita = data[i];
                        var html = '';


                        //HORA  LATITUD LONGITUD    UBICACIÓN   HORA    LATITUD LONGITUD    UBICACIÓN   OBSERVACIONES


                        html += '<tr class="renglon_visitas" id_visita="' + visita.id + '" >';

                        html += '<td>' + visita.usuario + '</td>';

                        html += '<td>' + visita.fecha_llegada + '</td>';
                        html += '<td>' + visita.latitud_llegada + '</td>';
                        html += '<td>' + visita.longitud_llegada + '</td>';
                        html += '<td>' + visita.ubicacion_llegada + '</td>';

                        /*html += '<td>' + (visita.fecha_salida != null ? visita.fecha_salida : ' - ') + '</td>';
                        html += '<td>' + (visita.latitud_salida != null ? visita.latitud_salida : ' - ') + '</td>';
                        html += '<td>' +  (visita.longitud_salida != null ? visita.longitud_salida : ' - ') + '</td>';
                        html += '<td>' +  (visita.ubicacion_salida != null ? visita.ubicacion_salida : ' - ') + '</td>';

                        html += '<td>' +  (visita.anotaciones != null ? visita.anotaciones : ' - ') + '</td>';*/

                        html += '<td>' + (visita.observaciones != null ? visita.observaciones : ' - ') + '</td>';

                        if(visita.fecha_salida == null )
                            html += '<td width="5%"><button type="button" class="btn btn-secondary  btn-sm form-control add-visita" id_visita="' + visita.id + '"   ><i class="fa fa-close" style="font-size:10px;" aria-hidden="true"></i></button></td>';
                        else
                            html += '<td width="5%"></td>';

                        html += '</tr>';

                        $('#t_visitas tbody').append(html);

                    }
                       

                },
                error: function (xhr)
                {
                    console.log(' ****************************** --> '+JSON.stringify(xhr));
                }

            });

        }

        $(document).on('click','.add-visita',function()
        {

            var idVisita = $(this).attr('id_visita');
            $('#dialog_cerrar').modal('show');
            $('#i_id_orden_servicio_cerrar').val(idVisita);

        });

        $('#b_cerrar_visita').click(function()
        {

            var idVisita = $('#i_id_orden_servicio_cerrar').val();
            var obs = $('#i_obs').val();
            var location = $('#location').val();
            var latitud = $('#latitud').val();
            var longitud = $('#longitud').val();


            $.ajax({
                url : 'php/servicios_guardar_cierre.php',
                cache: false,
                data:{'id_visita': idVisita, 'location': location, 'latitud': latitud, 'longitud': longitud, 'obs': obs},
                success: function(data){

                    if(data == true)
                    {

                        mandarMensaje('Se Agrego el cierre de la Visita de forma adecuada');
                        $('#dialog_cerrar').modal('hide');
                        buscarVisistas($('#i_id_orden_servicio').val());

                    }
                        
                }
                        
            });

        });


        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(searchLocation);
        }else{ 
            $('#location').val('Geolocation is not supported by this browser.');
        }

        function searchLocation(position){
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            //alert(latitude +  ' ** ' +    longitude);
            $("#latitud").val(latitude);
            $("#longitud").val(longitude);
            $.ajax({
                type:'POST',
                url:'php/get_location.php',
                data:'latitude='+latitude+'&longitude='+longitude,
                success:function(msg){
                    if(msg){
                       $("#location").val(msg);
                    }else{
                        $("#location").val('No Disponible');
                    }
                }
            });
        }

        $('#b_agregar').click(function()
        {
            $('#dialog_observaciones_visita').modal('show');
        });

        $('#b_guardar_visita').click(function(){
            $('#b_guardar_visita').prop('disabled',true);

            if($("#form_observaciones_visita").validationEngine('validate'))
            {
                var idOS = $('#i_id_orden_servicio').val();
                var location = $('#location').val();
                var latitud = $('#latitud').val();
                var longitud = $('#longitud').val();
                var observaciones = $('#ta_observaciones_visita').val();

                $.ajax({
                    url : 'php/servicios_guardar_seg.php',
                    cache: false,
                    data:{'id_orden_servicio': idOS, 'location': location, 'latitud': latitud, 'longitud': longitud, 'observaciones':observaciones},
                    success: function(data){


                        if(data == true)
                        {
                            $('#ta_observaciones_visita').val('');
                            $('#dialog_observaciones_visita').modal('hide');
                            mandarMensaje('Se Agrego  la Visita de forma adecuada');
                            buscarVisistas(idOS);
                            $('#b_guardar_visita').prop('disabled',false);
                        }
                            
                    }
                            
                });
            }else
                $('#b_guardar_visita').prop('disabled',false);
            
        });


    });

</script>

</html>