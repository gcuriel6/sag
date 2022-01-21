<?php
session_start();

if (isset($_GET['datos'])) {
    $datos = $_GET['datos'];
}

if (isset($_SESSION['usuario']) && $_SESSION['usuario']!='') {
	$usuario = $_SESSION['usuario'];
	$idUsuario=$_SESSION['id_usuario'];	
} else {
	$usuario = '';
	$idUsuario = 0;	
}

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
    #fondo_cargando{
        position: absolute;
        background-image:url('imagenes/3.svg');
        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:1%;
        border-radius: 5px;
        z-index:2000;
        display:none;
    }
    body{
        background-color:rgb(238,238,238);
    }
    #div_principal{
        padding-top:20px;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
    }
    
</style>

<body>
    <div id="fondo_cargando"></div>

    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="titulo_ban">Autorizar Cotizacion con Porcentaje Utilidad Menor</div>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-4" id="div_mensaje"></div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="form_aprobacion" name="form_aprobacion">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_inicio_facturacion" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Inicio de Facturación</label>
                                    <div class="col-sm-12 col-md-11">
                                        <input type="text" id="i_inicio_facturacion" name="i_inicio_facturacion" class="form-control datos_aprovar validate[required]" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="s_periodicidad" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Periodicidad</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="form-control datos_aprovar validate[required]" id="s_periodicidad" name="s_periodicidad">
                                            <option value="0" disabled selected>Selecciona</option>    
                                            <option value="1">Semanal</option>
                                            <option value="2">Quincenal</option>
                                            <option value="3">Mensual</option>
                                            <option value="4">Unico</option>
                                        </select>
                                    </div>    
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_dia" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Día</label>
                                    <div class="col-sm-6 col-md-6" id="contenedor_dia">
                                        <input type="text" id="i_dia" name="i_dia"  class="form-control datos_aprovar" autocomplete="off"  readonly>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="s_tipo_facturacion" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Tipo de Facturación</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="form-control datos_aprovar validate[required] " id="s_tipo_facturacion" name="s_tipo_facturacion">
                                            <option value="0" disabled selected>Selecciona</option>    
                                            <option value="1">Mes corriente</option>
                                            <option value="2">Mes Vencido</option>
                                            <option value="3">Mes anticipado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <label for="i_razon_social_emisora" class="col-sm-12 col-md-12 col-form-label label_aprovar requerido">Razón Social Emisora de la Factura </label>
                                    <div class="input-group col-sm-12 col-md-11">
                                        <input type="text" id="i_razon_social_emisora" name="i_razon_social_emisora" class="form-control datos_aprovar validate[required]" readonly autocomplete="off" aria-describedby="b_buscar_razon_social_emisora">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary coti" type="button" id="b_buscar_razon_social_emisora" style="margin:0px;">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_fecha_inicio_ap" class="col-sm-12 col-md-12 label_aprovar requerido">Fecha Inicio Servicio</label>
                                    <div class="col-sm-12 col-md-11">
                                        <input type="text" name="" id="i_fecha_inicio_ap" class="form-control datos_aprovar validate[required]" autocomplete="off" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 alert alert-primary">
                                    <input type="radio" name="radio_aprobada" id="radio_aprobada" value="4" checked>
                                    <label for="radio_aprobada">Aprobada</label>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-sm-12 col-md-3 alert alert-danger">
                                    <input type="radio" name="radio_aprobada" id="radio_rechazada" value="3">
                                    <label for="radio_rechazada">Rechazada</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="ta_observaciones">Observaciones</label>
                                    <textarea class="form-control validate[required]" id="ta_observaciones" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="ta_correos">Enviar a </label>
                                    <textarea class="form-control validate[required]" id="ta_correos" rows="3"></textarea>
                                    <span style="font-size:11px; color:#006600;">*Separar cuentas por comas</span>
                                </div>
                            </div>
                            <div class="row" id="div_justificacion_rechazada" style="display:none;">
                                <div class="col-md-12">
                                    <label for="ta_justificacion_rechazada requerido">Justificación </label>
                                    <textarea class="form-control validate[required]" id="ta_justificacion_rechazada" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <button type="button" id="b_guardar_aprobacion" class="btn btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <br><br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_razon_social_emisora" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Razón Social Emisora Factura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_razon_social_emisora" id="i_filtro_razon_social_emisora" class="form-control filtrar_renglones" alt="renglon_razon_social_emisora" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_razon_social_emisora">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Razón Social</th>
                            <th scope="col">RFC</th>
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

<div id="dialog_login" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Iniciar Sesion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12" id="div_cont">
                    <br>
                    <!--<div class="col-xs-10 col-md-12" style="text-align: center;">
                        <img src="imagenes/logoGinther2.png" width="300px"/>
                    </div>
                    <br>-->
                    <div class="input-group col-xs-10 col-md-12 col-md-offset-1">
                        <span class="input-group-addon input-group-addon-dark" style="background-color: rgb(4,5,5); border-color:#000; color: #fafafa;">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control " id="i_usuario" placeholder="Usuario" autocomplete="off">
                    </div><br>

                    <div class="input-group col-xs-10  col-md-12 col-md-offset-1">
                        <span class="input-group-addon" style="background-color: rgb(4,5,5); border-color:#000; color: white;">
                        <i class="fa fa-key" aria-hidden="true"></i>
                        </span>
                        <input type="password" class="form-control" id="i_password" placeholder="Contraseña" autocomplete="off">
                    </div><br/>

                    <div class="col-xs-10 col-md-12" style="text-align: center;">
                        <button class="btn btn-lg btn-dark"  style="background-color: rgb(4,5,5); border-color:#000; color: #fafafa;" type="button" id="b_login">Login</button><br><br>
                    </div>
                </div>
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

    var cadena = '<?php echo $datos ?>';
    var idUsuario = <?php echo $idUsuario ?>;
    var usuario = '<?php echo $usuario ?>';
    var idCotizacion=0;

    $(function(){

        iniciaSession();

        mostrarBotonAyuda('COTIZACION_AUTORIZAR_PU');
        var totalF = cadena.length;
        var totalF = cadena.length;
        var pos = cadena.indexOf('-');
        var pos2 = cadena.indexOf('[');
        var pos3 = cadena.indexOf(']');
        var email = cadena.substring(pos+1, pos2);
        var utilidadUnidad = cadena.substring(pos2+1, pos3);
        var utilidad = cadena.substring(pos3+1, totalF);

        var datos = cadena.substr(0, pos);

        var valor = datos.length;
        var dia = datos.substr(-2); //dia fecha actual
        var res = datos.substr(0, parseInt(valor)-2);
        var valor2 = res.length;
        var mes = res.substr(-2); //mes fecha actual
        var res2 = res.substr(0, parseInt(valor2)-2);
        var anio = res2.substr(-4); //año fecha actual
        var valor3 = res2.length;
        idCotizacion = res2.substr(0, parseInt(valor3)-4); //id de la cotizacion

        var fecha_recibida = anio+'-'+mes+'-'+(parseInt(dia)+3);

        var fecha = new Date();
        if(fecha.getDay() < 10)
        {
            var diaN='0'+fecha.getDay();
        }else{
            var diaN=fecha.getDay();
        }
        var fecha_actual = fecha.getFullYear()+'-'+diaN+'-'+fecha.getDate();

        if(fecha_recibida >= fecha_actual)
        {
            $('#b_guardar_aprobacion').prop('disabled',false);
            $('#div_mensaje').text('');
        }else{
            $('#b_guardar_aprobacion').prop('disabled',true);
            $('#div_mensaje').css('color','red').text('Se exedio el tiempo de tres dias para poder autorizar la cotización.');
        }
        

        $('#i_inicio_facturacion').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#i_inicio_facturacion').change(function(){
            $('#i_fecha_inicio_ap').val($('#i_inicio_facturacion').val());
        });

        $('#b_buscar_razon_social_emisora').click(function(){
            $.post('php/verifica_session.php',function(data){
                if(data==0){
                    limpiarUP();
                    $('#dialog_login').modal('show');
                }else{    
                    $('#i_filtro_razon_social_emisora').val('');
                    muestraModalEmpresasFiscales('renglon_razon_social_emisora','t_razon_social_emisora tbody','dialog_buscar_razon_social_emisora');
                }
            });
        });

        $('#t_razon_social_emisora').on('click', '.renglon_razon_social_emisora', function() {

            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_razon_social_emisora').attr('alt',id).val(nombre);
            $('#dialog_buscar_razon_social_emisora').modal('hide');

        });

        $('#b_guardar_aprobacion').click(function(){
            $('#fondo_cargando').show();
            $('#b_guardar_aprobacion').prop('disabled',true);
            $('#div_mensaje').text('');
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_verificar_cotizacion_aprobada.php',
                dataType:"json",
                data:  {'idCotizacion':idCotizacion},
                success: function(data)
                {
                   if(data.length > 0)
                   {
                        if(data[0].estatus_cotizacion == 2 && data[0].estatus_proyecto == 4)
                        {
                            mandarMensaje('La cotización ya fue autorizada anteriormente.');
                            $('#b_guardar_aprobacion').prop('disabled',true);
                        }else{
                            aprobarCotizacion();
                        }
                   }else{
                        $('#div_mensaje').css('color','red').text('No hay registro.');
                        mandarMensaje('No hay registro.');
                        $('#b_guardar_aprobacion').prop('disabled',false);
                   }

                },
                error: function (xhr) {
                    console.log('php/cotizaciones_verificar_cotizacion_aprobada.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                    $('#b_guardar_aprobacion').prop('disabled',false);
                }
            });

        });

        function aprobarCotizacion(){
            
            if ($('#form_aprobacion').validationEngine('validate')){

                $('#fondo_cargando').show();
                var datosBitacora = {
                    'correo' :email,
                    'utilidadUnidad':utilidadUnidad,
                    'utilidad':utilidad,
                    'idCotizacion':idCotizacion,
                    'idUsuario':idUsuario,
                    'usuario':usuario
                };

                var datos = Array();

                datos = {
                    'idCotizacion' : idCotizacion,
                    'fechaArranque':$('#i_fecha_inicio_ap').val(),
                    'observacion':$('#ta_observaciones').val(),
                    'estatusProyecto':$('input[name=radio_aprobada]:checked').val(),
                    'correos':$('#ta_correos').val(),
                    'fecha_inicio_facturacion' : $('#i_inicio_facturacion').val(),
                    'periodicidad' : $('#s_periodicidad').val(),
                    'tipo_facturacion':$('#s_tipo_facturacion').val(),
                    'razon_social_emisora' : $('#i_razon_social_emisora').attr('alt'),
                    'dia' : $('#i_dia').val(),
                    'justificacionRechazada':$('#ta_justificacion_rechazada').val()
                };

                var estatusRadio =  $('input[name=radio_aprobada]:checked').val();

                $.ajax({
                    type: 'POST',
                    url: 'php/cotizaciones_guardar_aprobacion.php', 
                    data:  {'datos':datos},
                    dataType:"json",
                    success: function(data) {
                        console.log('*data: '+data+' *');
                        
                        $('#ta_correos').val('');
                        $('#ta_observaciones').val('');
                        $('#i_fecha_inicio_ap').val('');
                        $('#radio_aprobada').prop('checked',true);
                        $('#radio_rechazada').prop('checked',false);
                        $('#i_inicio_facturacion').val('');
                        $('#s_periodicidad').val('');
                        $('#s_tipo_facturacion').val('');
                        $('#i_razon_social_emisora').attr('alt','').val('');
                        $('#i_dia').val('');
                        $('#ta_justificacion_rechazada').val('');

                        $('#b_guardar_aprobacion').prop('disabled',false);

                        if(data.verifica == false)
                        {
                            mandarMensaje('Error al aprobar la cotización.');
                            $('#fondo_cargando').hide();
                        }else{
                            mandarMensaje(data.mensaje);
                            $('#fondo_cargando').hide();

                            if(estatusRadio == 4)
                                generarBitacoraAutorizacion(datosBitacora);

                        }
                    },
                    error: function (xhr) {
                        console.log('php/cotizaciones_guardar_aprobacion.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* Error en el sistema');
                        $('#fondo_cargando').hide();
                        $('#b_guardar_aprobacion').prop('disabled',false);
                    }
                });
            }else{
                $('#b_guardar_aprobacion').prop('disabled',false);
                $('#fondo_cargando').hide();
            }
        }

        function generarBitacoraAutorizacion(info){
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar_bitacora_aprobacion.php', 
                data:  {'datos':info},
                success: function(data) {
                    console.log('* guardar bitacora: '+data+' *');
                },
                error: function (xhr) {
                    console.log('php/cotizaciones_guardar_bitacora_aprobacion.php --> '+JSON.stringify(xhr));
                }
            });
        }

        $('#s_periodicidad').on('change',function(){
            var valor=$(this).val();
            if( valor > 0 ){
                generaCampoDia(valor,'');
            }
        });

        $(document).on('change','#i_dia',function(){
            $(this).validationEngine('validate');
        });

        
        function generaCampoDia(periodicidad,valor){
            //-->NJES May/20/2020 cuando la periodicidad es 4 (Unico) solicitar fecha en especifico
            $('#contenedor_dia').html('').removeAttr('class');

            if(periodicidad==1){
                var html='<select class="form-control validate[required] coti" id="i_dia" name="i_dia">';
                    html+='<option value="0" disabled selected>Selecciona</option>';   
                    html+='<option value="L">Lunes</option>';
                    html+='<option value="M">Martes</option>';
                    html+='<option value="X">Miercoles</option>';
                    html+='<option value="J">Jueves</option>';
                    html+='<option value="V">Viernes</option>';
                    html+='<option value="S">Sabado</option>';
                    html+='<option value="D">Domingo</option>';
                    html+='</select>';
                $('#contenedor_dia').addClass('col-sm-12 col-md-10').append(html);  
                $('#i_dia').val(valor);
                              
            }else if( periodicidad==3){
                var html='<input type="text" id="i_dia" name="i_dia"  class="form-control validate[required,custom[integer],min[1],max[30]] coti" size="2" autocomplete="off" value="'+valor+'" >';
                $('#contenedor_dia').addClass('col-sm-6 col-md-6').append(html);
            }else if( periodicidad==2){
                var html='<select class="form-control validate[required] coti" id="i_dia" name="i_dia">';
                    html+='<option value="0" disabled selected>Selecciona</option>';   
                    html+='<option value="Q1">01 - 16</option>';
                    html+='<option value="Q2">02 - 17</option>';
                    html+='<option value="Q3">03 - 18</option>';
                    html+='<option value="Q4">04 - 19</option>';
                    html+='<option value="Q5">05 - 20</option>';
                    html+='<option value="Q6">06 - 21</option>';
                    html+='<option value="Q7">07 - 22</option>';
                    html+='<option value="Q8">08 - 23</option>';
                    html+='<option value="Q9">09 - 24</option>';
                    html+='<option value="Q10">10 - 25</option>';
                    html+='<option value="Q11">11 - 26</option>';
                    html+='<option value="Q12">12 - 27</option>';
                    html+='<option value="Q13">13 - 28</option>';
                    html+='<option value="Q14">14 - 29</option>';
                    html+='<option value="Q15">15 - 30</option>';
                    html+='</select>';
                $('#contenedor_dia').addClass('col-sm-12 col-md-10').append(html);  
                $('#i_dia').val(valor);
            }else{
                var html='<input type="text" id="i_dia" name="i_dia"  class="form-control validate[required] fecha coti" readonly autocomplete="off" value="'+valor+'" >';
                $('#contenedor_dia').addClass('col-sm-11 col-md-11').append(html);
                $('.fecha').datepicker({
                    format : "yyyy-mm-dd",
                    autoclose: true,
                    language: "es",
                    todayHighlight: true
                }); 
            }
            
        }

        $(document).on('click','#radio_rechazada',function(){
            $('.label_aprovar').removeClass('requerido');
            $('.datos_aprovar').removeClass('validate[required]');
            $('#ta_correos').removeAttr('class');
            $('#ta_correos').addClass('form-control validate[custom[multiEmail]]');

            $('#div_justificacion_rechazada').show();
        });

        $(document).on('click','#radio_aprobada',function(){
            $('.label_aprovar').addClass('requerido');
            $('.datos_aprovar').addClass('validate[required]');
            $('#ta_correos').removeAttr('class');
            $('#ta_correos').addClass('form-control validate[required,custom[multiEmail]]');
          
            
            $('#div_justificacion_rechazada').hide().val('').validationEngine('hide');
        });

        function iniciaSession(){
            $.post('php/verifica_session.php',function(data){
                if(data==0){
                    limpiarUP();
                    $('#dialog_login').modal('show');
                }
            }); 
        }

        $('#b_login').click(function(){
            if($('#i_usuario').val() != ''){
                if($('#i_password').val() != ''){
                    $.post("php/login.php",{ usuario: $('#i_usuario').val(), password: $('#i_password').val()},function(data){
                        if(data == '1'){
                            $('#dialog_login').modal('hide');
                            limpiarUP();
                        }
                        else{
                            mandarMensaje(data);
                            limpiarUP();
                        }
                    });
                }else{
                    mandarMensaje('Ingresa una contraseña');
                }
            }else{
                mandarMensaje('Ingresa un usuario');
            }
        });

        function limpiarUP(){
            $('#i_usuario').val('');
            $('#i_password').val('');
        }

    });

</script>

</html>