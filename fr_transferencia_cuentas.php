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

    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Transferencia entre Cuentas</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-2"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-8">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="s_id_unidad_o" class="col-sm-3 col-md-3 col-form-label requerido">Unidad de Negocio </label>
                                <div class="col-sm-3 col-md-4">
                                    <select id="s_id_unidad_o" name="s_id_unidad_o" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="s_cuenta_origen" class="col-sm-3 col-md-3 col-form-label requerido">Origen </label>
                                <div class="col-sm-12 col-md-5">
                                    <select id="s_cuenta_origen" name="s_cuenta_origen" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_saldo_disponible" class="col-sm-3 col-md-3 col-form-label"><strong>Saldo Disponible </strong></label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="alert alert-success validate[required,custom[number]]" style="font-weight:bold;" id="i_saldo_disponible" name="i_saldo_disponible" readonly autocomplete="off">
                                </div>
                            </div>    
                            <div class="form-group row">
                                <label for="i_monto" class="col-sm-3 col-md-3 col-form-label requerido">Monto </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control validate[required,custom[number],min[0.01]]" id="i_monto" name="i_monto" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="s_id_unidad_d" class="col-sm-3 col-md-3 col-form-label requerido">Unidad de Negocio </label>
                                <div class="col-sm-4 col-md-4">
                                    <select id="s_id_unidad_d" name="s_id_unidad_d" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="form-group row"> 
                                <label for="s_cuenta_destino" class="col-sm-3 col-md-3 col-form-label requerido">Destino</label>
                                <div class="col-sm-12 col-md-5">
                                    <select id="s_cuenta_destino" name="s_cuenta_destino" class="form-control form-control-sm validate[required]" disabled autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_fecha" class="col-sm-12 col-md-3 col-form-label requerido">Fecha de aplicación</label>
                                <div class="input-group col-sm-12 col-md-3">
                                    <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm validate[required] fecha" autocomplete="off" readonly>
                                    <div class="input-group-addon input_group_span">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_observacion" class="col-sm-3 col-md-3 col-form-label">Observación</label>
                                <div class="col-sm-12 col-md-9"><br>
                                    <input type="text" class="form-control" id="i_observacion" name="i_observacion" autocomplete="off">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
  
    var modulo='TRANSFERENCIAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var saldoDisponible=0;
    var anteriorClase='';
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz, 's_id_unidad_o', idUnidadActual);
        muestraSelectUnidades(matriz, 's_id_unidad_d', idUnidadActual);
        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        muestraCuentasBancos('s_cuenta_origen', 0,0,idUnidadActual);
        muestraCuentasBancos('s_cuenta_destino', 0,0,idUnidadActual);

        $('#i_fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha').val(hoy);
        $('#s_id_unidad_o').change(function(){

            var idUnidadNegocio = $('#s_id_unidad_o').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_cuenta_origen',0,0,idUnidadNegocio);
            muestraCuentasBancos('s_cuenta_destino',0,0,idUnidadNegocio);
            muestraSelectUnidades(matriz, 's_id_unidad_d', idUnidadNegocio);
        });

        $('#s_id_unidad_d').change(function(){

            var idUnidadNegocio = $('#s_id_unidad_d').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_cuenta_destino',0,0,idUnidadNegocio);
        });

        $('#s_cuenta_origen').change(function(){
            var tipo = $('#s_cuenta_origen option:selected').attr('alt2');
            var idSucursal = $('#s_cuenta_origen option:selected').attr('alt3');
            anteriorClase = $('#i_monto').attr('class');
            //--MGFS 17-01-2020 SE HABLITAN NUEVAMENTE LAS TRASFERENCIAS ENTRE BANCOS 
            // -- FUE SOLICITADO POR MAVEL YA QUE SE COMETIO UN ERROR Y SE TRAFIRIO A UNA CUENTA INCORRECTA
            //muestraCuentasBancos('s_cuenta_destino', $('#s_cuenta_origen').val(),tipo);

            //-->El segundo parametro envia el id cuenta origen para que la en la 
            //cuenta destino no muestre la cuenta origen ya que no se puede tranferir de la misma cuenta a la misma cuenta 
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_cuenta_destino', $('#s_cuenta_origen').val(),0,$('#s_id_unidad_d').val()); 
            if(tipo == 0){
                muestraSaldoDisponible($('#s_cuenta_origen').val());
            }else{
                muestraSaldoDisponibleCajaChica(idSucursal);
            }
            $('#s_cuenta_destino').prop('disabled',false);
        });

        function muestraSaldoDisponible(idCuentaBanco){
            saldoDisponible = 0;
            $.ajax({
                type: 'POST',
                url: 'php/movimientos_cuentas_saldo_disponible.php',
                dataType:"json", 
                data:{'idCuentaBanco' : idCuentaBanco},
                success: function(data)
                {
                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        $('#i_saldo_disponible').val(formatearNumero(dato.saldo_disponible));
                        saldoDisponible = dato.saldo_disponible;
              
                        if(parseFloat(dato.saldo_disponible) > 0)
                        {
                            $('#i_monto').removeClass(anteriorClase).addClass('form-control validate[required,custom[number],min[0.01],max['+dato.saldo_disponible+']]');
                        }
                    }
                },
                error: function (xhr) {
                    console.log("movimientos_cuentas_saldo_disponible.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo disponible de la cuenta');
                }
            });
        }

        function muestraSaldoDisponibleCajaChica(idSucursal){
            saldoDisponible = 0;
            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_saldo_actual_buscar.php',
                dataType:"json", 
                data:{'idSucursal' : idSucursal},
                success: function(data)
                {
                    var arreglo=data;
                    if(arreglo.length > 0)
                    {
                        $('#i_saldo_disponible').val(formatearNumero(arreglo[0].saldo));
                        saldoDisponible = arreglo[0].saldo;
            
                        if(parseFloat(arreglo[0].saldo) > 0)
                        {
                            $('#i_monto').removeClass(anteriorClase).addClass('form-control validate[required,custom[number],min[0.01],max['+arreglo[0].saldo+']]');
                        }
                    }else{
                        $('#i_saldo_disponible').val(formatearNumero(0));
                    }
                },
                error: function (xhr) {
                    console.log("caja_chica_saldo_actual_buscar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo');
                }
            });
        }

        $('#i_monto').on('change',function(){
           
            if($(this).validationEngine('validate')==false) {

                var monto=quitaComa($('#i_monto').val());
                if(monto==''){
                    monto=0;
                }

                if(monto > 0){

                    $('#i_monto').val(formatearNumero(parseFloat(monto)));

                }else{
                    $('#i_monto').val(0);
                }
            }else{
                if(quitaComa($('#i_monto').val()) != '')
                {
                    var monto = quitaComa($('#i_monto').val());
                }else{
                    var monto = 0;
                }

                $('#i_monto').val(monto);
            }
       });

        $('#b_guardar').click(function(){
          
           $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                if(parseFloat(saldoDisponible) > 0)
                {
                    guardar();
                }else{
                    mandarMensaje('El saldo disponible es insuficiente para hacer la transferencia.');
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });

        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

            var info = {
                'idCuentaOrigen' : $('#s_cuenta_origen').val(),
                'idCuentaDestino' : $('#s_cuenta_destino').val(),
                'monto' : quitaComa($('#i_monto').val()),
                'observacion' : $('#i_observacion').val(),
                'idUsuario' :idUsuario,
                'tipo' : 'T',   ///Transferencia
                'tipoCuentaOrigen' : $('#s_cuenta_origen option:selected').attr('alt2'),
                'tipoCuentaDestino' : $('#s_cuenta_destino option:selected').attr('alt2'),
                'cuentaOrigen' : $('#s_cuenta_origen option:selected').text(),
                //--> NJES Jan/20/2020 obtiene los nombre de cuentas caja chica para la observacion al momento de hacer una tranferencia de caja chica a caja chica
                'cuentaDestino' : $('#s_cuenta_destino option:selected').text(),
                'fechaAplicacion' : $('#i_fecha').val()
            };
            
            $.ajax({
                type: 'POST',
                url: 'php/movimientos_cuentas_guardar.php', 
                data: {
                    'datos':info
                },
                //una vez finalizado correctamente
                success: function(data){
                    console.log(data);
                    if (data > 0 ) 
                    { 
                        mandarMensaje('Se guardó el movimiento');
                        limpiar();
                    }else{
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('php/movimientos_cuentas_guardar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al guardar');
                }
            });
           
        }
           
        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            $('input').not('input:radio').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);  
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraSelectUnidades(matriz, 's_id_unidad_o', idUnidadActual);
            muestraSelectUnidades(matriz, 's_id_unidad_d', idUnidadActual);
            muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancos('s_cuenta_origen', 0,0,idUnidadActual);
              
            $('#s_cuenta_destino').prop('disabled',true); 
            $('#s_cuenta_destino').val('').select2({placeholder: 'Selecciona'});
            $('#i_saldo_disponible').val('');

            $('#i_monto').removeClass('form-control validate[required,custom[number],min[0.01],max['+saldoDisponible+']]').addClass('form-control validate[required,custom[number],min[0.01]]');            
            $('#i_fecha').val(hoy);


        }

    });

</script>

</html>