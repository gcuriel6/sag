<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PORTAL PROVEEDORES</title>
    <!-- Hojas de estilo -->
    <link href="../css/css/bootstrap.css" rel="stylesheet"  type="text/css" media="all">
    <link href="../css/validationEngine.jquery.css" rel="stylesheet" />
    <link href="../css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <link href="../css/general.css" rel="stylesheet"  type="text/css"/>
    <link href="../vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="../vendor/select2/css/select2.css" rel="stylesheet"/>
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
                        <div class="titulo_ban">Proveedores</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
                   
                    <div class="col-sm-12 col-md-8"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-1"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="i_id_proveedor" class="col-sm-2 col-md-2 col-form-label requerido">ID </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control"  id="i_id_proveedor" autocomplete="off" disabled="disabled">
                                </div>
                            </div>
                           <div class="form-group row">
                                <label for="i_nombre" class="col-sm-2 col-md-2 col-form-label requerido">Nombre </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_rfc" class="col-sm-2 col-md-2 col-form-label requerido">RFC</label>
                                <div class="input-group col-sm-12 col-md-4">
                                    <input type="text" id="i_rfc" name="i_rfc" class="form-control validate[required,minSize[12],maxSize[13],custom[onlyLetterNumberN]]" size="13" autocomplete="off" readonly>
                                            
                                </div>

                               
                                <!--<div class="col-sm-10 col-md-2">
                                No Factura
                                    <input type="checkbox" id="ch_facturar" name="ch_facturar" value="">
                                </div>-->
                            </div>
                            <div class="form-group row">
                                <label for="i_domicilio" class="col-2 col-md-2 col-form-label requerido">Domicilio </label><br>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control validate[required]" id="i_domicilio">
                                </div>

                                <label for="i_num_ext" class="col-1 col-md-1 col-form-label requerido">Ext </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_num_ext">
                                </div>

                                <label for="i_num_int" class="col-1 col-md-1 col-form-label requerido">Int </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_num_int">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_cp" class="col-2 col-md-2 col-form-label requerido">Código Postal </label><br>
                                <div class="col-sm-12 col-md-3">
                                    <div class="row">
                                        
                                        <div class="input-group col-sm-12 col-md-9">
                                            <input type="text" id="i_cp" name="i_cp" class="form-control validate[required,custom[integer]]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_cp" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="s_pais" class="col-1 col-md-1 col-form-label requerido">País </label><br>
                                <div class="col-sm-12 col-md-3">
                                    <select id="s_pais" name="s_pais" class="form-control validate[required]"></select>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <label for="i_colonia" class="col-sm-2 col-md-2 col-form-label requerido">Colonia </label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control validate[required]" id="i_colonia" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_municipio" class="col-2 col-md-2 col-form-label requerido">Municipio </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_id_municipio" disabled>
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_municipio" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_estado" class="col-2 col-md-2 col-form-label requerido">Estado </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_id_estado" disabled>
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_estado" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_banco" class="col-2 col-md-2 col-form-label requerido">Banco </label><br>
                                <div class="col-sm-12 col-md-2">
                                    <div class="row">
                                        <div class="input-group col-sm-12 col-md-12">
                                            <input type="text" id="i_id_banco" name="i_id_banco" class="form-control validate[required]" readonly autocomplete="off">
                                            <input type="hidden" id="i_id_banco_original" name="i_id_banco_original" >
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_banco" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_banco" disabled>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label for="i_cuenta" class="col-2 col-md-2 col-form-label requerido">Cuenta </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_cuenta">
                                    <input type="hidden" id="i_cuenta_original" name="i_cuenta_original" >
                                </div>
                                <label for="i_clabe" class="col-sm-2 col-md-2 col-form-label requerido">Clabe </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_clabe" >
                                    <input type="hidden" id="i_clabe_original" name="i_clabe_original" >
                                </div>
                                <label for="i_dias_credito" class="col-sm-2 col-md-2 col-form-label requerido">Días de Credito </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control validate[required,custom[integer]]" id="i_dias_credito" >
                                    <input type="hidden" id="i_dias_credito_original" name="i_dias_credito_original" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_telefono" class="col-sm-2 col-md-2 col-form-label requerido">Teléfono(s) </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" class="form-control validate[required]" id="i_telefono" >
                                </div>
                                <label for="i_extension" class="col-sm-2 col-md-2 col-form-label requerido">Extensión </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_extension" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_web" class="col-sm-2 col-md-2 col-form-label">Web </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="i_web">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_contacto" class="col-sm-2 col-md-2 col-form-label requerido">Contacto </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_contacto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_condiciones" class="col-sm-2 col-md-2 col-form-label requerido">Condiciones </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_condiciones">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_inactivo" class="col-sm-2 col-md-2 col-form-label">Inactivo</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
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

<div id="dialog_buscar_proveedores" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Proveedores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_proveedores" id="i_filtro_proveedores" class="form-control filtrar_renglones" alt="renglon_proveedores" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_proveedores">
                      <thead>
                        <tr class="renglon">
                          <th scope="col" width="10%">ID</th>
                          <th scope="col" width="10%">RFC</th>
                          <th scope="col" width="30%">Nombre</th>
                          <th scope="col" width="10%">Grupo</th>
                          <th scope="col" width="10%">Estatus</th>
                          <th scope="col" width="30%">Usuario</th>
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

<div id="dialog_buscar_cp" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Codigos Postales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label for="s_estados">Estado</label>
                    <select class="form-control coti" id="s_estados" style="width: 100%;"></select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label for="s_municipios">Municipio</label>
                    <select class="form-control coti" id="s_municipios" style="width: 100%;"></select>
                </div>
                <div class="col-sm-12 col-md-4"><input type="text" name="i_filtro_cp" id="i_filtro_cp" class="form-control filtrar_renglones" alt="renglon_cp" placeholder="Filtrar" autocomplete="off"></div>
            </div>                               
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cp">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Código Postal</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Municipio</th>
                          <th scope="col">Colonia</th>
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

<div id="dialog_buscar_banco" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_banco" id="i_filtro_banco" class="form-control filtrar_renglones" alt="renglon_banco" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_banco">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Clave</th>
                          <th scope="col">Banco</th>
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





<script src="../js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/js/bootstrap.js"></script>
<script src="../js/jquery.validationEngine.js"></script>
<script src="../js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="../vendor/select2/js/select2.js"></script>

<script>
  
    var idProveedor=<?php echo $_SESSION['idProveedor']?>;
    var proveedorOriginal='';
    var tipo_mov=0;
    var modulo='PROVEEDORES';
    $(function(){
       
        muestraSelectPaises('s_pais');

        $('#ch_inactivo').prop('checked',false).prop('disabled',true);  

        if(idProveedor>0){
            tipo_mov=1;
            muestraRegistro();
        }


        $('#b_buscar').on('click',function(){
            var url = 'php/proveedores_buscar.php';
            buscarProveedores(url);
        });
        $('#b_buscar_proveedores_gastos').on('click',function(){
            var url = 'php/proveedores_gastos_buscar.php';
            buscarProveedores(url);
        });
        function buscarProveedores(url){

            $('#forma').validationEngine('hide');
            $('#i_filtro_proveedores').val('');
            $('.renglon_proveedores').remove();
   
            $.ajax({

                type: 'POST',
                url: url,
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_proveedores').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activo';
                            }

                            var html='<tr class="renglon_proveedores" alt="'+data[i].id+'" >\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="RFC">' + data[i].rfc+ '</td>\
                                        <td data-label="Nombre">' + data[i].nombre+ '</td>\
                                        <td data-label="Grupo">' + data[i].grupo+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                        <td data-label="Usuario">' + data[i].usuario+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_proveedores tbody').append(html);   
                            $('#dialog_buscar_proveedores').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/proveedores_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_proveedores').on('click', '.renglon_proveedores', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('disabled', false);
            idProveedor = $(this).attr('alt');
           
            $('#dialog_buscar_proveedores').modal('hide');
            muestraRegistro();


        });



        function muestraRegistro(){ 
            $.ajax({
                type: 'POST',
                url: 'php/proveedores_buscar_id.php',
                dataType:"json", 
                data:{
                    'idProveedor':idProveedor
                },
                success: function(data) {
                   
                    idProveedor=data[0].id;
                    proveedorOriginal=data[0].rfc;
                   
                    $('#i_id_proveedor').val(idProveedor);
                    $('#i_nombre').val(data[0].nombre);
                    $('#i_rfc').val(data[0].rfc);
                    $('#i_domicilio').val(data[0].domicilio);
                    $('#i_cp').val(data[0].cp);
                    $('#i_colonia').val(data[0].colonia);
                    $('#i_num_ext').val(data[0].num_ext);
                    $('#i_num_int').val(data[0].num_int);
                    if (data[0].facturable == 0) {
                        $('#ch_facturable').prop('checked', false);
                    } else {
                        $('#ch_facturable').prop('checked', true);
                    }

                    if(data[0].id_pais != 0)
                    {
                        $('#s_pais').val(data[0].id_pais);
                        $('#s_pais').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_pais').val('');
                        $('#s_pais').select2({placeholder: 'Selecciona'});
                    }
                    $('#i_id_estado').val(data[0].id_estado);
                    $('#i_estado').val(data[0].estado);
                    $('#i_id_municipio').val(data[0].id_municipio);
                    $('#i_municipio').val(data[0].municipio);
                    $('#i_id_banco').val(data[0].id_banco);
                    $('#i_id_banco_original').val(data[0].id_banco);
                    $('#i_banco').val(data[0].banco);
                    $('#i_cuenta_original').val(data[0].cuenta);
                    $('#i_cuenta').val(data[0].cuenta);
                    $('#i_clabe').val(data[0].clabe);
                    $('#i_clabe_original').val(data[0].clabe);
                    $('#i_dias_credito').val(data[0].dias_credito);
                    $('#i_telefono').val(data[0].telefono);

                    $('#i_extension').val(data[0].extension);
                    $('#i_web').val(data[0].web);
                    $('#i_contacto').val(data[0].contacto);
                    $('#i_dias_credito_original').val(data[0].dias_credito);
                    $('#i_dias_credito').val(data[0].dias_credito);
                    $('#i_condiciones').val(data[0].condiciones);
                    $('#i_grupo').val(data[0].grupo);

                    if (data[0].inactivo == 0) {
                        $('#ch_inactivo').prop('checked', false);
                    } else {
                        $('#ch_inactivo').prop('checked', true);
                    }
                   
                },
                error: function (xhr) {
                    console.log('php/proveedores_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        $('#b_guardar').click(function(){
          
           $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                if($('#i_rfc').val()!='XEXX010101000'){
                    verificar();
                }else{
                    guardar();
                }
                

            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });


        function verificar(){

            $.ajax({
                type: 'POST',
                url: 'php/proveedores_verificar.php',
                dataType:"json", 
                data:  {'rfc':$('#i_rfc').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipo_mov == 1 && proveedorOriginal === $('#i_rfc').val()) {
                            guardar();
                        } else {

                            mandarMensaje('El RFC : '+ $('#i_rfc').val()+' ya existe intenta con otro');
                            $('#i_rfc').val('');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    mandarMensaje(JSON.stringify(xhr));
                    //mandarMensaje(xhr.responseText);
                }
            });
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

         $.ajax({
                type: 'POST',
                url: 'php/proveedores_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                   console.log(data);
                    if (data > 0 ) {
                        if (tipo_mov == 0){
                            
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
                    console.log(JSON.stringify(xhr));
                    mandarMensaje("Ha ocurrido un error.");
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
                    'tipo_mov' : tipo_mov,
                    'idProveedor' : idProveedor,
                    'nombre' : $('#i_nombre').val(),
                    'rfc' : $('#i_rfc').val(),
                    'domicilio' : $('#i_domicilio').val(),
                    'cp' : $('#i_cp').val(),
                    'idColonia' : $('#i_colonia').val(),
                    'numInt' : $('#i_num_int').val(),
                    'numExt' : $('#i_num_ext').val(),
                    'facturable' : $("#ch_facturable").is(':checked') ? 1 : 0,
                    'idPais' : $('#s_pais').val(),
                    'idEstado' : $('#i_id_estado').val(),
                    'idMunicipio' : $('#i_id_municipio').val(),
                    'idBancoAnterior' : $('#i_id_banco_original').val(),
                    'idBanco' : $('#i_id_banco').val(),
                    'cuenta' : $('#i_cuenta').val(),
                    'cuentaAnterior' : $('#i_cuenta_original').val(),
                    'clabe' : $('#i_clabe').val(),
                    'clabeAnterior' : $('#i_clabe_original').val(),
                    'diasCredito' : $('#i_dias_credito').val(),
                    'diasCreditoAnterior' : $('#i_dias_credito_original').val(),
                    'telefono' : $('#i_telefono').val(),
                    'extension' : $('#i_extension').val(),
                    'web' : $('#i_web').val(),
                    'contacto' : $('#i_contacto').val(),
                    'condiciones' : $('#i_condiciones').val(),
                    'grupo' : $('#i_grupo').val(),
                    'inactivo' : $("#ch_inactivo").is(':checked') ? 1 : 0,
                    'idUsuario' : idProveedor,
                    'modulo' : 'P'
                }

                paquete.push(paq);
              
            return paquete;
        }   
        
        //************Busca los cp por estado y municipio */
        $('#b_buscar_cp').on('click',function(){

            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();
            muestraSelectEstados('s_estados');
            muestraSelectMunicipios('s_municipios',0);
            $('#dialog_buscar_cp').modal('show'); 

        });

        $(document).on('change','#s_estados,#s_municipios',function(){
            buscarCp();
        });

        function buscarCp(){
           
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();

            $.ajax({

                type: 'POST',
                url: 'php/codigo_postal_buscar.php',
                dataType:"json", 
                data:{
                    'idEstado':$('#s_estados').val(),
                    'idMunicipio': $('#s_municipios').val()
                },
                success: function(data) {
                
                if(data.length != 0){

                    $('.renglon_cp').remove();
                
                    for(var i=0;data.length>i;i++){

                        ///llena la tabla con renglones de registros

                        var html='<tr class="renglon_cp" alt="'+data[i].id_colonia+'" alt2="'+data[i].colonia+'" alt3="'+data[i].codigo_postal+'" alt4="'+data[i].estado+'" alt5="'+data[i].id_estado+'"alt6="'+data[i].municipio+'"alt7="'+data[i].id_municipio+'">\
                                    <td data-label="ID">' + data[i].codigo_postal+ '</td>\
                                    <td data-label="Clave">' + data[i].estado+ '</td>\
                                    <td data-label="Descripción">' + data[i].municipio+ '</td>\
                                    <td data-label="Tallas">' + data[i].colonia+ '</td>\
                                </tr>';
                        ///agrega la tabla creada al div 
                        $('#t_cp tbody').append(html);   
                             
                    }
                }else{

                    mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/codigo_postal_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_cp').on('click', '.renglon_cp', function() {

            var  idColonia = $(this).attr('alt');
            var  colonia = $(this).attr('alt2');
            var  cp = $(this).attr('alt3');
            var  estado = $(this).attr('alt4');
            var  idEstado = $(this).attr('alt5');
            var  municipio = $(this).attr('alt6');
            var  idMunicipio = $(this).attr('alt7');

            $('#i_cp').val(cp);
            $('#i_colonia').val(colonia).attr('alt',idColonia);
            $('#i_id_estado').val(idEstado);
            $('#i_id_municipio').val(idMunicipio);
            $('#i_estado').val(estado);
            $('#i_municipio').val(municipio);
               
            $('#dialog_buscar_cp').modal('hide');

        });

         
        //************Busca los bancos activos */
        $('#b_buscar_banco').on('click',function(){
            
            $('#i_filtro_banco').val('');
            $('.renglon_banco').remove();

            $.ajax({

                type: 'POST',
                url: 'php/bancos_buscar.php',
                dataType:"json", 
                data:{
                    'estatus':1,

                },
                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_banco').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros

                            var html='<tr class="renglon_banco" alt="'+data[i].id+'" alt2="'+data[i].clave+'" alt3="'+data[i].banco+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].banco+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_banco tbody').append(html);   
                            $('#dialog_buscar_banco').modal('show');   
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

        $('#t_banco').on('click', '.renglon_banco', function() {

            var  id = $(this).attr('alt');
            var  clave = $(this).attr('alt2');
            var  banco = $(this).attr('alt3');

            $('#i_id_banco').val(id);
            $('#i_banco').val(banco);
               
            $('#dialog_buscar_banco').modal('hide');

        });

        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idProveedor=0;
            proveedorOriginal='';
            tipo_mov=0;
            $('input').val('');
            $('#i_familia').attr('alt',0);
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('checked',false).prop('disabled',true);
            muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);
            muestraSelectPaises('s_pais');
            $('#s_pais').prop('disabled',false);
            
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Proveedores');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('PROVEEDORES');
            
            $("#f_imprimir_excel").submit();
        });

        $('#b_asignar_unidades').on('click',function(){
            var idProveedor=0;
            var proveedor='';
            if($('#i_id_proveedor').val()!=''){
                idProveedor=$('#i_id_proveedor').val();
                proveedor=$('#i_nombre').val();
            }
            window.open("fr_proveedores_accesos.php?idProveedor="+idProveedor+"&proveedorP="+proveedor,"_self");
        });

        $('#i_rfc').on('change',function(){
           
            if($('#i_rfc').validationEngine('validate')==false){
              
               if($('#i_rfc').val()=='XEXX010101000'){
                 
                  $('#s_pais').val(236).prop('disabled',true);
                  $('#s_pais').select2({placeholder: $(this).data('elemento')});
               }else{
                  
                  $('#s_pais').val(141).prop('disabled',true);
                  $('#s_pais').select2({placeholder: $(this).data('elemento')}); 
               }
                
            }else{
                
                $('#s_pais').val('').prop('disabled',false);
                $('#s_pais').select2({placeholder: 'Selecciona'});
            }
           
        });

        $('#b_rfc').on('click',function(){
            
            $('#i_rfc').val('XEXX010101000');

            if($('#s_pais').val()==141){

                $('#s_pais').val(236).prop('disabled',true);
                $('#s_pais').select2({placeholder: $(this).data('elemento')});
            }
            
        });

        $('#s_pais').on('change',function(){
            
            if($('#i_rfc').val()=='XEXX010101000'){

                $('#s_pais').val(236).prop('disabled',true);
                $('#s_pais').select2({placeholder: $(this).data('elemento')});
            }
            
        });

    });

</script>

</html>