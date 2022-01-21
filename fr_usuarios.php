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
   
    #vistaPrevia_1{
        border: 1px solid rgb(214, 214, 194); 
        background-color: #fff; 
        max-height: 55px; 
        min-height: 55px;
        width:100px;
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
                        <div class="titulo_ban">Usuarios</div>
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
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                               <label for="s_id_sucursal" class="col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-12 col-md-3">
                                    <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_usuario" class="col-sm-2 col-md-2 col-form-label requerido">Usuario </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control validate[required,custom[onlyLetterNumber]]" id="i_usuario"  autocomplete="off">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="i_password" class="col-sm-2 col-md-2 col-form-label requerido">Contraseña </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="password" class="form-control validate[required]" id="i_password" name="i_password" autocomplete="off">
                                </div>
                                <div class="col-sm-1 col-md-1">
                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" id="b_cambiar_pass"><span class="fa fa-pencil"></span> Cambiar</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_confirmar" class="col-sm-2 col-md-2 col-form-label requerido">Confirmar Contraseña</label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="password" class="form-control validate[required,equals[i_password]]" id="i_confirmar" name="i_confirmar" autocomplete="off">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="i_no_empleado" class="col-sm-2 col-md-2 col-form-label">No. Empleado </label>
                                <div class="col-sm-12 col-md-5">
                                    <input type="text" class="form-control" id="i_no_empleado" disabled="disabled" placeholder="No. Empleado" autocomplete="off">
                                </div>
                                <div class="col-sm-1 col-md-1">
                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" id="b_buscar_empleados"><span class="fa fa-search"></span> Buscar</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_nombre_completo" class="col-sm-2 col-md-2 col-form-label requerido">Nombre</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_nombre_completo" placeholder="Nombre Completo" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_activo" class="col-sm-2 col-md-2 col-form-label">Activo</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox" id="ch_activo" name="ch_activo" value="">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_USUARIOS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
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

<div id="dialog_buscar_usuarios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_usuarios" id="i_filtro_usuarios" class="form-control filtrar_renglones" alt="renglon_usuarios" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_usuarios">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Usuario</th>
                          <th scope="col">Nombre</th>
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

<div id="dialog_pass" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cambiar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_pass">
            <div class="row" >
                <div class="form-group row">
                    <div class="col-sm-2 col-md-2"></div>
                    <label for="i_nueva" class="col-sm-4 col-md-4 col-form-label">Nueva </label>
                    <div class="col-sm-6 col-md-6">
                        <input type="password" class="form-control validate[required]" id="i_nueva" name="i_nueva">
                    </div>
                </div>
                            
            </div>
            <div class="row" >
                <div class="form-group row">
                    <div class="col-sm-2 col-md-2"></div>
                    <label for="i_nueva_confirmar" class="col-sm-4 col-md-4 col-form-label">Confirmar</label>
                    <div class="col-sm-6 col-md-6">
                        <input type="password" class="form-control validate[required,equals[i_nueva]]" id="i_nueva_confirmar" name="i_nueva_confirmar">
                    </div>
                </div>
                            
            </div>    
            <br>
        </form>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-dark btn-sm" id="b_guardar_pass"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Cambio</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_buscar_empleados" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Empleados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
             </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_empleados">
                      <thead>
                        <tr class="renglon">
                        <th scope="col" colspan="3"><h6><span class="badge badge-warning">Para que inicie la busquedá ingresa un id de empleado ó un nombre</span></h6>
           </th>
                        </tr>
                        <tr class="renglon">
                          <th scope="col"><input type="text" name="i_filtro_id" id="i_filtro_id" class="form-control" placeholder="Buscar ID" autocomplete="off"></th>
                          <th scope="col"><input type="text" name="i_filtro_nombre" id="i_filtro_nombre" class="form-control"  placeholder="Buscar Nombre" autocomplete="off"></th>
                          <th scope="col"><input type="text" name="i_filtro_empleado" id="i_filtro_empleado" class="form-control filtrar_renglones" alt="renglon_empleados" placeholder="Filtrar" autocomplete="off"></th>
                        </tr>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Sucursal</th>
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
  
    var id=0;
    var usuarioOriginal='';
    var tipo_mov=0;
    var modulo='USUARIOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#ch_activo').prop('checked', true).prop('disabled',true);

        $('#b_cambiar_pass').prop('disabled',true);
        $('#b_buscar_empleados').prop('disabled',true);

    
        muestraSucursalesPermiso('s_id_sucursal',idUnidadActual,modulo,idUsuario);


        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_usuarios').val('');
            $('.renglon_usuarios').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/usuarios_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_usuarios').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].activo) == 1){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_usuarios" alt="'+data[i].id_usuario+'">\
                                        <td data-label="usuario">' + data[i].usuario+ '</td>\
                                        <td data-label="Nombre">' + data[i].nombre_comp+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_usuarios tbody').append(html);   
                            $('#dialog_buscar_usuarios').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_usuarios').on('click', '.renglon_usuarios', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#b_cambiar_pass').prop('disabled',false);

            id = $(this).attr('alt');
            
            $('#dialog_buscar_usuarios').modal('hide');
            muestraRegistro();


        });



        function muestraRegistro(){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/usuarios_buscar_id.php',
                dataType:"json", 
                data:{
                    'idUsuario':id
                },
                success: function(data) {
                    id=data[0].id_usuario;
                    usuarioOriginal=data[0].usuario;
                    $('#i_usuario').val(data[0].usuario);
                    $('#i_nombre_completo').val(data[0].nombre_comp);
                    $('#i_password').val(1234578).prop('disabled',true);
                    $('#i_confirmar').val(1234578).prop('disabled',true);
                    if(data[0].id_empleado > 0 ){
                        muestraEmpleado(data[0].id_empleado);
                    }else{
                       $('#i_no_empleado').val(''); 
                    }

                    if(data[0].id_sucursal > 0){    
                        $('#s_id_sucursal').val(data[0].id_sucursal);
                        $('#s_id_sucursal').select2({placeholder: $(this).data('elemento')});
                        $('#b_buscar_empleados').prop('disabled',false);
                    }else{
                        $('#s_id_sucursal').val('');
                        $('#s_id_sucursal').select2({placeholder: 'Elige una Sucursal'});
                    }

                    $('#ch_activo').prop('disabled',false);

                    if (data[0].activo == 0) {
                        $('#ch_activo').prop('checked', false);
                    } else {
                        $('#ch_activo').prop('checked', true);
                    }
                   
                },
                error: function (xhr) {
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        $('#b_guardar').click(function(){
          
           $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                
                verificar();

            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });


        function verificar(){

            $.ajax({
                type: 'POST',
                url: 'php/usuarios_verificar.php',
                dataType:"json", 
                data:  {'usuario':$('#i_usuario').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipo_mov == 1 && usuarioOriginal === $('#i_usuario').val()) {
                            guardar();
                        } else {

                            mandarMensaje('La usuario: '+ $('#i_usuario').val()+' ya existe intenta con otro');
                            $('#i_usuario').val('');
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
                url: 'php/usuarios_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()// guardando usuarios

                },
                //una vez finalizado correctamente
                success: function(data){
                  
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
                   
                    mandarMensaje("Ha ocurrido un error.");
                    $('#b_guardar').prop('disabled',false);
                }
            });
           
        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){

            //alert('TEST --> '  + $('#i_no_empleado').attr('alt'));1

            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
                var paq = {
                    'tipo_mov' : tipo_mov,
                    'idUsuario' : id,
                    'usuario' : $('#i_usuario').val(),
                    'password' : $('#i_password').val(),
                    'no_empleado' : $('#i_no_empleado').attr('alt'),
                    'nombre' : $('#i_nombre_completo').val(),
                    'activo' : $("#ch_activo").is(':checked') ? 1 : 0,
                    'idSucursal':$('#s_id_sucursal').val()
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
        /* Limpia el modulo cambia la contraseña de un usuario*/
        $('#b_cambiar_pass').click(function(){
            $('#dialog_pass').modal('show');
            $('#i_nueva').val('').validationEngine('hide');
            $('#i_nueva_confirmar').val('').validationEngine('hide');
        });

        $('#b_guardar_pass').click(function(){

            if($('#form_pass').validationEngine('validate')){

                $.post('php/usuarios_cambiar_password.php',{
                    'idUsuario':id,'contra':$('#i_nueva').val()
                },function(data){
                     
                    if(data > 0){
                        mandarMensaje('La contraseña se cambió correctamente');
                       $('#dialog_pass').modal('hide');      
                    }else{
                        mandarMensaje('Ocurrio un error en el sistema.');
                        $('#dialog_pass').modal('hide');
                    }    
                    

                });
            }
        });


        $(document).on('change','#s_id_sucursal',function(){
           
            if($('#s_id_sucursal').val()!= ''){
              
                $('#b_buscar_empleados').prop('disabled',false);
            }
        });


        $('#b_buscar_empleados').on('click',function(){
            $('#i_filtro_id').val('');
            $('#i_filtro_nombre').val('');
            $('#i_filtro_empleado').val('');
            $('.renglon_empleados').remove();
            $('#dialog_buscar_empleados').modal('show'); 
        });


        $(document).on('click','#i_filtro_id',function(){ // buscando aquiq
            $('#i_filtro_nombre').val('');
            $('#i_filtro_empleado').val('');
        });

        $(document).on('click','#i_filtro_nombre',function(){
            $('#i_filtro_id').val('');
            $('#i_filtro_empleado').val('');
        });


         $(document).on('change','#i_filtro_id,#i_filtro_nombre',function(){
                
            $('#i_filtro_empleado').val('');
            $('.renglon_empleados').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/empleados_buscar_todos.php',
                dataType:"json", 
                data:{
                    'idEmpleado':0,
                    'filtroId' : $('#i_filtro_id').val(),
                    'filtroNombre' : $('#i_filtro_nombre').val()
                },

                success: function(data) {

                   if(data.length != 0 ){

                        $('.renglon_empleados').remove();
                   
                        for(var i=0;data.length>i;i++){

                            

                            var html='<tr class="renglon_empleados" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'">\
                                        <td data-label="usuario">' + data[i].id_trabajador+ '</td>\
                                        <td data-label="usuario">' + data[i].nombre+ '</td>\
                                         <td data-label="usuario">' + data[i].sucursal+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_empleados tbody').append(html);   
                              
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    
                    mandarMensaje('Error en el sistema');
                }
            });
        });

         

        $('#t_empleados').on('click', '.renglon_empleados', function() {
            
            var id = $(this).attr('alt');
            $('#i_no_empleado').attr('alt', id);
            muestraEmpleado(id);

            $('#dialog_buscar_empleados').modal('hide');

        });

        function muestraEmpleado(idE){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/empleados_buscar_todos.php',
                dataType:"json", 
                data:{
                    'idEmpleado':idE
                },
                success: function(data) {

                    $('#i_no_empleado').val(idE+' - '+data[0].nombre);
                    $('#i_no_empleado').attr('alt', idE);

                },
                error: function (xhr) {
                    mandarMensaje(xhr.responseText);
                }
            });
        }


        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
            
            id=0;
            usuarioOriginal='';
            tipo_mov=0;
            $('input').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#b_cambiar_pass').prop('disabled',true);
            $('#b_buscar_empleados').prop('disabled',true);
            $('#i_no_empleado').attr('alt',0);
            $('#i_password').prop('disabled',false);
            $('#i_confirmar').prop('disabled',false);
            $('#ch_activo').prop('checked', true).prop('disabled',true);
            muestraSucursalesPermiso('s_id_sucursal',idUnidadActual,modulo,idUsuario);
            
        }


        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Usuarios');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('USUARIOS');
            
            $("#f_imprimir_excel").submit();
        });

        $(document).ready(function(){
            $('[id^=i_filtro_id]').keypress(soloNumero);
        });
       

    });

</script>

</html>