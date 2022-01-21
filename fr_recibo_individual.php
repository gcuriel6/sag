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
    .div_fecha_extraordinaria,#div_info_plan{
        display: none;
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
                        <div class="titulo_ban">Recibo Individual</div>
                    </div>
                </div>
                <br>
                <form id="forma_general" name="forma_general">
                    <div class="row">
                        <div class="col-sm-12 col-md-2"></div>
                        <div class="col-sm-12 col-md-8">
                            <div class="row">
                                <label for="s_id_sucursales" class="col-sm-12 col-md-3 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-12 col-md-8">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm filtros" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label for="i_cliente" class="col-sm-12 col-md-3 col-form-label requerido">Cliente </label>
                                <div class="input-group col-sm-12 col-md-8">
                                    <input type="text" id="i_cliente" name="i_cliente" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-md-12" id="div_info_plan">
                                    <div class="row">
                                        <label class="col-sm-12 col-md-1 col-form-label">Plan: </label>
                                        <label class="col-sm-12 col-md-6" id="dato_plan"></label>
                                        <label for="i_fecha_corte" id="label_fecha_corte" class="col-sm-12 col-md-1 col-form-label"></label>
                                        <label class="col-sm-12 col-md-4" id="contenedor_dia"> </label>
                                        <input id="valor_dia" type="hidden"/>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-12 col-md-6 col-form-label">Fecha ultimo recibo generado: </label>
                                        <label class="col-sm-12 col-md-4" id="dato_ultimo_recibo"></label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <input type="checkbox" name="ch_recibo_extraordinario" id="ch_recibo_extraordinario" > Recibo Extraordinario
                                </div>
                                <div class="col-sm-12 col-md-6 div_fecha_extraordinaria">
                                    <div class="row">
                                        <label for="i_fecha" class="col-sm-12 col-md-4 col-form-label" id="label_fecha_extraordinaria" style="text-align:right;">Fecha </label>
                                        <div class="input-group col-sm-12 col-md-8">
                                            <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm fecha" autocomplete="off" readonly>
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
                                <div class="col-sm-12 col-md-3 div_fecha_extraordinaria">
                                    <div class="row">
                                        <label for="i_precio" class="col-sm-12 col-md-12 col-form-label" id="label_precio">Precio </label>
                                        <div class="col-sm-12 col-md-12">
                                            <input type="text" class="form-control"  id="i_precio" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-9 div_fecha_extraordinaria">
                                    <div class="row">
                                        <label for="ta_descripcion" class="col-sm-12 col-md-12 col-form-label" id="label_descripcion">Descripción </label>
                                        <div class="col-sm-12 col-md-12">
                                            <textarea type="text" class="form-control"  id="ta_descripcion" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-md-4"></div>
                                <div class="col-sm-12 col-md-4">
                                    <button type="button" class="btn btn-success btn-sm form-control" id="b_generar" disabled><i class="fa fa-list-alt" aria-hidden="true"></i> Generar</button>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </form>
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

<div id="dialog_buscar_servicios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Servicios</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_servicios" id="i_filtro_servicios" class="form-control filtrar_renglones" alt="renglon_servicios" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_servicios">
                        <thead>
                            <tr class="renglon">
                            <th scope="col" width="10%">Cuenta</th>
                            <th scope="col" width="10%">RFC</th>
                            <th scope="col" width="10%">Nombre Corto</th>
                            <th scope="col" width="15%">Razon Social</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>  
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
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
 
    var modulo='RECIBO_INDIVIDUAL';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        mostrarBotonAyuda(modulo);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        }); 

        $('#ch_recibo_extraordinario').change(function(){
            $('#i_fecha,#i_precio,#ta_descripcion').validationEngine('hide');
            verificaChkReciboExtraOrdinario();
        });

        function verificaChkReciboExtraOrdinario(){
            if($("#ch_recibo_extraordinario").is(':checked'))
            {    
                $('.div_fecha_extraordinaria').css('display','block');
                $('#label_fecha_extraordinaria,#label_descripcion,#label_precio').removeClass('requerido').addClass('requerido');
                $('#i_fecha,#ta_descripcion').removeClass('validate[required]').addClass('validate[required]'); 
                $('#i_precio').removeClass('validate[required,custom[number]]').addClass('validate[required,custom[number]]');
            }else
            {
                $('.div_fecha_extraordinaria').css('display','none');
                $('#label_fecha_extraordinaria,#label_descripcion,#label_precio').removeClass('requerido');
                $('#i_fecha,#ta_descripcion').removeClass('validate[required]');
                $('#i_precio').removeClass('validate[required,custom[number]]');
            }  
        }

        $(document).ready(function(){
            $('#i_precio').keypress(function (event){
                return validateDecimalKeyPressN(this, event, 2);
            });
        });

        $('#i_fecha').change(function(){
            var tipoPlan = $('#valor_dia').attr('tipo_plan');

            switch(parseInt(tipoPlan))
            {
                case 1:  //anual
                    var str = $('#i_fecha').val();
                    var res = str.replace(/-/g, ",");
                    var d = new Date(res);
                    var n = d.getDate();
                    var m = d.getMonth();

                    var fechaCorte = $('#valor_dia').attr('dia_corte');
                    var fechaNuC = fechaCorte.replace(/-/g, ",");
                    var fNC = new Date(fechaNuC);
                    var dC = fNC.getDate();
                    var mC = fNC.getMonth();
                    var yC = fNC.getFullYear();

                    //-- por si el mes llega a caer en febrero se le restan los dias del siguiente mes 
                    //-- para que si ponga la fecha de febrero con el ultimo dia de ese mes y no se lo pase
                    if((parseInt(m)+1) == 2 && (parseInt(m)+1) == (parseInt(mC)+1))
                    {
                        if(n == 28 || n == 29)
                        {
                            mandarMensaje('No es posible crear un recibo extraordinario con fecha '+ $('#i_fecha').val()+' ya que esta programada para el plan.');
                            $('#i_fecha').val('');
                        }
                    }else{
                        if(n == dC && (parseInt(m)+1) == (parseInt(mC)+1))
                        {
                            mandarMensaje('No es posible crear un recibo extraordinario con fecha '+ $('#i_fecha').val()+' ya que esta programada para el plan.');
                            $('#i_fecha').val('');
                        }
                    }
                break;
                case 3:
                    var quincenal = {
                        'Q1':[1,16],
                        'Q2':[2,17],
                        'Q3':[3,18],
                        'Q4':[4,19],
                        'Q5':[5,20],
                        'Q6':[6,21],
                        'Q7':[7,22],
                        'Q8':[8,23],
                        'Q9':[9,24],
                        'Q10':[10,25],
                        'Q11':[11,26],
                        'Q12':[12,27],
                        'Q13':[13,28],
                        'Q14':[14,29],
                        'Q15':[15,30]
                    };

                    var dia = $('#valor_dia').attr('dia_corte');
                    var quincenaUno = quincenal[dia][0];
                    var quincenaDos = quincenal[dia][1];

                    var str = $('#i_fecha').val();
                    var res = str.replace(/-/g, ",");
                    var d = new Date(res);
                    var n = d.getDate();
                    var m = d.getMonth();

                    //-- por si el mes llega a caer en febrero se le restan los dias del siguiente mes 
                    //-- para que si ponga la fecha de febrero con el ultimo dia de ese mes y no se lo pase
                    if((parseInt(m)+1) == 2 && quincenaDos > 28)
                    {
                        if(n == 28 || n == 29)
                        {
                            mandarMensaje('No es posible crear un recibo extraordinario con fecha '+ $('#i_fecha').val()+' ya que esta programada para el plan.');
                            $('#i_fecha').val('');
                        }
                    }else{
                        if(n == quincenaUno || n == quincenaDos)
                        {
                            mandarMensaje('No es posible crear un recibo extraordinario con fecha '+ $('#i_fecha').val()+' ya que esta programada para el plan.');
                            $('#i_fecha').val('');
                        }
                    }
                break;
                case 4:  //semanal
                    var semanal = {
                        'L':'Monday',
                        'M':'Tuesday',
                        'X':'Wednesday',
                        'J':'Thursday',
                        'V':'Friday',
                        'S':'Saturday',
                        'D':'Sunday'
                    };   
     
                    var dia = $('#valor_dia').attr('dia_corte');
                    var diaSemana = semanal[dia];


                    var weekday = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                    var str = $('#i_fecha').val();
                    var res = str.replace(/-/g, ",");
                    var d = new Date(res);
                    var diaS = weekday[d.getDay()];

                    if(diaS == diaSemana)
                    {
                        mandarMensaje('No es posible crear un recibo extraordinario con fecha '+ $('#i_fecha').val()+' ya que esta programada para el plan.');
                        $('#i_fecha').val('');
                    }
                break;
                default:  //mensual
                    var str = $('#i_fecha').val();
                    var res = str.replace(/-/g, ",");
                    var d = new Date(res);
                    var n = d.getDate();
                    var m = d.getMonth();

                    //-- por si el mes llega a caer en febrero se le restan los dias del siguiente mes 
                    //-- para que si ponga la fecha de febrero con el ultimo dia de ese mes y no se lo pase
                    if((parseInt(m)+1) == 2 && $('#valor_dia').attr('dia_corte') > 28)
                    {
                        if(n == 28 || n == 29)
                        {
                            mandarMensaje('No es posible crear un recibo extraordinario con fecha '+ $('#i_fecha').val()+' ya que esta programada para el plan.');
                            $('#i_fecha').val('');
                        }
                    }else{
                        if(n == $('#valor_dia').attr('dia_corte'))
                        {
                            mandarMensaje('No es posible crear un recibo extraordinario con fecha '+ $('#i_fecha').val()+' ya que esta programada para el plan.');
                            $('#i_fecha').val('');
                        }
                    }
            }

        });

        $('#b_buscar_clientes').on('click',function(){

            $('#i_filtro_servicios').val('');
            $('.renglon_servicios').remove();

            $.ajax({

                type: 'POST',
                url: 'php/servicios_buscar2.php',
                dataType:"json", 
                data:{
                    'estatus':1, //--solo los activos
                    'idSucursal':$('#s_id_sucursales').val()
                },  
                success: function(data) {
                    console.log(data);
                    if(data.length != 0){

                            $('.renglon_servicios').remove();
                    
                            for(var i=0;data.length>i;i++){

                                var html='<tr class="renglon_servicios" alt="'+data[i].id+'" razon_social="'+ data[i].razon_social +'"  nombre_corto="' + data[i].nombre_corto + '" >\
                                            <td data-label="Cuenta">' + data[i].cuenta+ '</td>\
                                            <td data-label="RFC">' + data[i].rfc+ '</td>\
                                            <td data-label="Nombre">' + data[i].nombre_corto+ '</td>\
                                            <td data-label="Razón Social">' + data[i].razon_social+ '</td>\
                                        </tr>';
                                
                                $('#t_servicios tbody').append(html);   
                                
                            }
                    }else{

                            mandarMensaje('No se encontró información');
                    }
                    
                    $('#dialog_buscar_servicios').modal('show'); 

                },
                error: function (xhr) {
                    console.log('php/servicios_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar clientes servicios.');
                }
            });
        });

        $('#t_servicios').on('click', '.renglon_servicios', function() {
            var idServicio = $(this).attr('alt');
            var nombreCorto = $(this).attr('nombre_corto');

            $('#i_cliente').val(nombreCorto).attr('alt',idServicio);

            muestraDatosCliente(idServicio);
             
        });

        function muestraDatosCliente(idServicio){
            $.ajax({
                type: 'POST',
                url: 'php/recibo_buscar_plan_id_servicio.php',
                dataType:"json", 
                data:{'idServicio' : idServicio},  
                success: function(data) {
                    console.log(data);
                    if(data.length != 0){
                        $('#div_info_plan').css({'display':'block','font-weight': 'bold'});
                        $('#dato_plan').text(data[0].descripcion+' $'+data[0].cantidad);
                        generaCampoDia(data[0].tipo_plan,data[0].dia_corte);
                        $('#valor_dia').attr({'dia_corte':data[0].dia_corte,'tipo_plan':data[0].tipo_plan});
                        $('#dato_ultimo_recibo').text(data[0].fecha_ultimo_recibo);
                        
                        $('#b_generar').prop('disabled',false);
                    }else{
                        $('#div_info_plan').css({'display':'block','font-weight': 'bold'});
                        $('#dato_plan').text('El cliente no tiene plan para generar recibo.');
                        $('#dato_ultimo_recibo').text('');
                        $('#b_generar').prop('disabled',true);
                    }

                    $('#dialog_buscar_servicios').modal('hide'); 
                },
                error: function (xhr) {
                    console.log('php/recibo_buscar_plan_id_servicio.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar el pan del servicios.');
                }
            });
        }

        $('#s_id_sucursales').change(function(){
            $('#i_cliente').val('');
            $('#b_generar').prop('disabled',true);
            $('#div_info_plan').css('display','none');
        });

        function generaCampoDia(tipo,valor){
            /*if(tipo == 1)
            {
                    $('#label_fecha_corte').removeClass('col-md-1').addClass('col-md-2').text('Fecha Inicio Cobro');
            }else{
                    $('#label_fecha_corte').removeClass('col-md-2').addClass('col-md-1').text('Día');
            }*/

            $('#contenedor_dia').text('');

            switch(parseInt(tipo))
            {
                case 1:  //anual
                    $('#contenedor_dia').text('Anual - fecha primer corte : '+valor); 
                break;
                case 3:  //quincenal
                    $('#contenedor_dia').text(valor);  
                break;
                case 4:  //semanal
                    $('#contenedor_dia').text(valor);  
                break;
                default:  //mensual
                    $('#contenedor_dia').text('Mensual el día: '+valor);
            }
        }

        $('#b_generar').click(function(){
            $('#b_generar').prop('disabled',true);

            if ($('#forma_general').validationEngine('validate'))
            {
                $('#fondo_cargando').show();

                var info = {
                    'idServicio' : $('#i_cliente').attr('alt'),
                    'idUnidadNegocio' : idUnidadActual,
                    'idSucursal' : $('#s_id_sucursales').val(),
                    'usuario' : usuario,
                    'idUsuario' : idUsuario,
                    'fechaUltimoRecibo' : $('#dato_ultimo_recibo').text(),
                    'fechaExtraordinaria' : $('#i_fecha').val(),
                    'reciboExtraordinario' : $('#ch_recibo_extraordinario').is(':checked') ? 1 : 0,
                    //-->NJES March/18/2020 agregar precio y descripcion de plan a recibo individual cuando es fecha extraordinaria
                    'precio' : quitaComa($('#i_precio').val()),
                    'descripcion' : $('#ta_descripcion').val()
                };

                console.log(' info:'+JSON.stringify(info));

                $.ajax({
                    type: 'POST',
                    url: 'php/recibo_individual_generar.php',
                    dataType:"json", 
                    data : {'datos':info},
                    success: function(data)
                    {
                        //console.log(" retorna:"+JSON.stringify(data));

                        if(data.num == 1)
                        {
                            var datos = {
                                'path':'formato_recibo_individual',
                                'nombreArchivo':'Recibo_individual',
                                'tipo':4,
                                'idUnidadNegocio' : idUnidadActual,
                                'idSucursal' : $('#s_id_sucursales').val(),
                                'idServicio' : $('#i_cliente').attr('alt'),
                                'datosRecibo' : data.datos
                            };

                            //console.log('datos_pdf:'+JSON.stringify(datos));

                            let objJsonStr = JSON.stringify(datos);
                            let datosJ = datosUrl(objJsonStr);

                            window.open("php/convierte_pdf.php?D="+datosJ,'_blank');

                            $('#fondo_cargando').hide();
                            mandarMensaje('Se ha generado el recibo.');
                            muestraDatosCliente($('#i_cliente').attr('alt'));
                        }else{
                            $('#fondo_cargando').hide();
                            mandarMensaje(data.warning);
                            $('#b_generar').prop('disabled',false);
                        }
                    },
                    error: function (xhr) {
                        console.log('php/recibo_individual_generar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* No se encontró información al generar recibo individual.');
                        $('#b_generar').prop('disabled',false);
                        $('#fondo_cargando').hide();
                    }
                });
            }else{
                $('#b_generar').prop('disabled',false);
            }
        });

    });

</script>

</html>