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
            <div class="col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Cuentas Bancos</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-2"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-9">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="i_id_cuenta" class="col-sm-2 col-md-2 col-form-label"> ID </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control"  id="i_id_cuenta" autocomplete="off" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="s_id_unidades" class="col-sm-2 col-md-3 col-form-label requerido">Unidad de Negocio</label>
                                <div class="col-sm-12 col-md-5">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]"  autocomplete="off"></select>
                                       
                                </div>
                            </div>    
                           <div class="form-group row">
                                <label for="i_cuenta" class="col-sm-2 col-md-2 col-form-label requerido">Cuenta </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" class="form-control validate[required,custom[integer]]" id="i_cuenta" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_descripcion" class="col-sm-2 col-md-2 col-form-label requerido">Descripción</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_descripcion">
                                </div>
                            </div>
                            <div class="form-group row div_banco_a">
                            <label for="i_banco" class="div_banco col-2 col-md-2 col-form-label requerido">Banco </label>
                               
                                <div class="div_banco col-sm-12 col-md-10">
                                    <div class="row">
                                    
                                        <div class="input-group col-sm-12 col-md-10">
                                            <input type="text" id="i_banco" name="i_banco" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_bancos" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 col-md-2">
                                    Activa <input type="checkbox" id="ch_activa" name="ch_activa" value="">
                                </div>
                                <div class="col-sm-10 col-md-2">
                                    Caja Chica <input type="checkbox" id="ch_caja_chica" name="ch_caja_chica" value="">
                                </div>
                            </div>
                            <div class="row">
                                <label style="display:none;" for="s_id_sucursales" class="div_sucursales col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                                <div style="display:none;" class="div_sucursales col-sm-12 col-md-5">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]"  autocomplete="off"></select>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <br>
                <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon"  id="t_cuentas_banco">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col" width="20%">Cuenta</th>
                                    <th scope="col" width="30%">Banco</th>
                                    <th scope="col" width="40%">Descripción</th>
                                    <th scope="col" width="10%">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        
                            </table>  
                        </div>
                    </div>
                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_LINEAS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                        </form>
                    </div>
                </div>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_cuentas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Cuentas Bancos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_cuentas" id="i_filtro_cuentas" class="form-control filtrar_renglones" alt="renglon_cuentas" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cuentas">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Sucursal</th>
                          <th scope="col">Cuenta</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Banco</th>
                          <th scope="col">Estatus</th>
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

<div id="dialog_buscar_bancos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Bancos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_bancos" id="i_filtro_bancos" class="form-control filtrar_renglones" alt="renglon_bancos" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_bancos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Estatus</th>
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
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var idCuentaBanco=0;
    var cuentaOriginal='';
    var tipoMov=0;
    var modulo='CUENTAS_BANCOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectTodasUnidades('s_id_unidades',idUnidadActual);
        muestraCuentasUnidad(idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
    
        $('#s_id_unidades').change(function(){
            var idUnidadNegocio=$(this).val();
            muestraCuentasUnidad(idUnidadNegocio);
            muestraSucursalesPermiso('s_id_sucursales',$('#s_id_unidades').val(),modulo,idUsuario);
        });

        $('#ch_caja_chica').click(function(){
            if($('#ch_caja_chica').is(':checked'))
            {
                $('.div_sucursales').css('display','block');
                $('.div_banco').css('display','none');
                $('.div_banco_a').removeClass('form-group row');
            }else{
                $('.div_sucursales').css('display','none');
                $('#i_descripcion').val('').prop('disabled',false);
                $('#i_cuentan').val('').prop('disabled',false);
                $('.div_banco').css('display','block');
                $('.div_banco_a').addClass('form-group row');
            }
        });

        $('#s_id_sucursales').change(function(){
            $('#i_descripcion').val(' Caja Chica '+$('#s_id_sucursales option:selected').text()).prop('disabled',true);
            $('#i_cuenta').val($('#s_id_sucursales option:selected').text()).prop('disabled',true);
        });

        /*function muestarBancoCajaChica(){

        }*/

        $('#ch_activa').prop('checked',true).prop('disabled',true);  

        //************Solo muestra los bancos activos */
        $('#b_buscar_bancos').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_bancos').val('');
            $('.renglon_bancos').remove();

            $.ajax({

                type: 'POST',
                url: 'php/bancos_buscar.php',
                dataType:"json", 
                data:{'estatus':1},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_bancos').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].activo) == 1){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_bancos" alt="'+data[i].id+'" alt2="' + data[i].clave+ '" alt3="' + data[i].banco+ '">\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].banco+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_bancos tbody').append(html);   
                            $('#dialog_buscar_bancos').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/bancos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_bancos').on('click', '.renglon_bancos', function() {

            var idBanco = $(this).attr('alt');
            var clave = $(this).attr('alt2');
            var banco = $(this).attr('alt3');
            $('#i_banco').attr('alt',idBanco).val(clave+' - '+banco);
            $('#dialog_buscar_bancos').modal('hide');
            

        });

        function muestraCuentasUnidad(idUnidadNegocio){
           
            $('.renglon_cuentas_banco').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/cuentas_bancos_buscar_cuentas_por_unidad.php',
                dataType:"json", 
                data:{'idUnidadNegocio':idUnidadNegocio},

                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_cuentas_banco').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                               var html='<tr class="renglon_cuentas_banco" alt="' + data[i].id+ '">\
                                        <td data-label="cuenta">' + data[i].cuenta+ '</td>\
                                        <td data-label="Banco">' + data[i].banco+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus + '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_cuentas_banco tbody').append(html);   
                        }
                   }else{

                        mandarMensaje('No se encontraron cuentas relacionadas');
                   }

                },
                error: function (xhr) {
                    console.log('php/cuentas_bancos_buscar_cuentas_por_unidad.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontraron cuentas relacionadas');
                }
            });
        }

       $(document).on('dblclick','.renglon_cuentas_banco', function() {
        idCuentaBanco = $(this).attr('alt');

           muestraRegistro();
        }); 



        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_cuentas').val('');
            $('.renglon_cuentas').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/cuentas_bancos_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_cuentas').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activa='';
                            
                            if(parseInt(data[i].activa) == 1){

                                activa='Activa';
                            }else{
                                activa='Inactiva';
                            }

                            var html='<tr class="renglon_cuentas" alt="'+data[i].id+'" alt2="'+data[i].id_unidad_negocio+'">\
                                        <td data-label="cuenta">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="cuenta">' + data[i].cuenta+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Descripción">' + data[i].banco+ '</td>\
                                        <td data-label="Estatus">' + activa+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_cuentas tbody').append(html);   
                            $('#dialog_buscar_cuentas').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/cuentas_bancos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_cuentas').on('click', '.renglon_cuentas', function() {
            muestraSucursalesPermiso('s_id_sucursales',$(this).attr('alt2'),modulo,idUsuario);
            tipoMov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#i_cuenta').prop('disabled',true);
            $('#i_descripcion').prop('disabled',true);
            $('#b_buscar_bancos').prop('disabled',true);
            $('#ch_activa').prop('disabled', false);

            $('#ch_activa').prop('disabled', false);
            idCuentaBanco = $(this).attr('alt');
           
            $('#dialog_buscar_cuentas').modal('hide');
            muestraRegistro();
        });



        function muestraRegistro(){ 
       
            $.ajax({
                type: 'POST',
                url: 'php/cuentas_bancos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idCuentaBanco':idCuentaBanco
                },
                success: function(data) {
                   
                    idCuentaBanco=data[0].id;
                    cuentaOriginal=data[0].cuenta;

                    $('#s_id_unidades').val(data[0].id_unidad_negocio).prop('disabled',true);
                    $("#s_id_unidades").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                    });
                    $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                    $('#i_cuenta').val(data[0].cuenta);
                    $('#i_id_cuenta').val(idCuentaBanco);
                    //$('#i_descripcion').val(data[0].descripcion);
                    $('#i_banco').val(data[0].clave+' - '+ data[0].banco).attr('alt',data[0].id_banco);
                  
                    muestraCuentasUnidad(data[0].id_banco);

                    if (data[0].activa == 0) {
                        $('#ch_activa').prop('checked', false);
                    } else {
                        $('#ch_activa').prop('checked', true);
                    }

                    if(data[0].tipo == 1)
                    {
                        $('#ch_caja_chica').prop('checked',true);
                        $('.div_sucursales').css('display','block');
                        $('#i_descripcion').val(data[0].descripcion).prop('disabled',true);
                        $('#s_id_sucursales').val(data[0].id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                        $('.div_banco').css('display','none');
                    }else{
                        $('#ch_caja_chica').prop('checked',false);
                        $('.div_sucursales').css('display','none');
                        $('#i_descripcion').val(data[0].descripcion).prop('disabled',true);
                        $('.div_banco').css('display','block');
                    }
                   
                },
                error: function (xhr) {
                    console.log('php/cuentas_bancos_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        function verificaCuentaCajaChicaSucursal(){
            $.ajax({
                type: 'POST',
                url: 'php/cuentas_bancos_caja_sucursal_verificar.php',
                dataType:"json", 
                data:  {'idSucursal':$('#s_id_sucursales').val()},
                success: function(data) 
                {
                    if(data == 1){
                        if (tipoMov == 1 && cuentaOriginal === $('#i_cuenta').val()) 
                        {
                            guardar();
                        }else{
                            mandarMensaje('La cuenta : '+ $('#i_cuenta').val()+' ya existe activa intenta con otra ó buscala e inactivala');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    console.log('php/cuentas_bancos_vecuentas_bancos_caja_sucursal_verificarrificar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error al verificar cuenta caja chica de la sucursal');
                }
            });
        }

        $('#b_guardar').click(function(){
          
           $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                
                if($('#ch_caja_chica').is(':checked'))
                {
                    verificaCuentaCajaChicaSucursal();
                }else{
                    verificar();
                }

            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });


        function verificar(){

            $.ajax({
                type: 'POST',
                url: 'php/cuentas_bancos_verificar.php',
                dataType:"json", 
                data:  {'cuenta':$('#i_cuenta').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipoMov == 1 && cuentaOriginal === $('#i_cuenta').val()) {
                            guardar();
                        } else {

                            mandarMensaje('La cuenta : '+ $('#i_cuenta').val()+' ya existe intenta con otra');
                            $('#i_cuenta').val('');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    console.log('php/cuentas_bancos_verificar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error al verificar la cuenta');
                    //mandarMensaje(xhr.responseText);
                }
            });
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

         $.ajax({
                type: 'POST',
                url: 'php/cuentas_bancos_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                  
                    if (data > 0 ) {
                        if (tipoMov == 0){
                            
                            mandarMensaje('Se guardó el nuevo registro');
                            $('#b_nuevo').click();
    
                        }else{
                                
                            mandarMensaje('Se actualizó el registro');
                            $('#b_nuevo').click();
                               
                        }
                      

                    }else{
                           
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('php/cuentas_bancos_guardar.php-->'+JSON.stringify(xhr));
                    mandarMensaje("Error an guardar la información.");
                    $('#b_guardar').prop('disabled',false);
                }
            });
           
        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var paq = {
                    'tipoMov' : tipoMov,
                    'idCuentaBanco' : idCuentaBanco,
                    'idUnidadNegocio' : $('#s_id_unidades').val(),
                    'cuenta' : $('#i_cuenta').val(),
                    'descripcion' : $('#i_descripcion').val(),
                    'activa' : $("#ch_activa").is(':checked') ? 1 : 0,
                    'idBanco' : $('#i_banco').attr('alt'),
                    'tipoCuenta' : $('#ch_caja_chica').is(':checked') ? 1 : 0,
                    'idSucursal' : $('#s_id_sucursales').val()
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
        

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idCuentaBanco=0;
            cuentaOriginal='';
            tipoMov=0;
            $('input').val('');
            $('#i_banco').attr('alt',0);
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            muestraSelectTodasUnidades('s_id_unidades',idUnidadActual);
            $('#s_id_unidades').prop('disabled',false);
            $('#ch_activa').prop('checked',true).prop('disabled',true); 
            $('.renglon_cuentas_banco').remove();
            $('#i_cuenta').prop('disabled',false);
            $('#i_descripcion').prop('disabled',false);
            $('#b_buscar_bancos').prop('disabled',false);
            $('#ch_caja_chica').prop('checked',false);
            $('.div_sucursales').css('display','none');
            $('.div_banco').css('display','block');
            $('.div_banco_a').removeClass('form-group row').addClass('form-group row');
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Cuentas Bancos');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('CUENTAS_BANCOS');
            
            $("#f_imprimir_excel").submit();
        });
       

    });

</script>

</html>