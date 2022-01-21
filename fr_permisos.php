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
    <link rel="stylesheet" type="text/css" href="css/jstree_themes/default/style.min.css" />
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
                        <div class="titulo_ban">Permisos</div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-md-2"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            
                            <div class="form-group row">
                                <label for="i_usuario" class="col-sm-3 col-md-3 col-form-label requerido">Usuario </label>
                                <div class="col-sm-5 col-md-5">
                                    <input type="text" class="form-control validate[required,custom[onlyLetterNumber]]" id="i_usuario" placeholder="Usuario" autocomplete="off">
                                </div>
                                <div class="col-sm-1 col-md-1">
                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" id="b_buscar_usuarios"><span class="fa fa-search"></span> Buscar</button>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                               <label for="s_id_unidades" class="col-sm-3 col-md-3 col-form-label requerido">Unidades Negocio </label>
                                <div class="col-sm-5 col-md-5">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" ></select>
                                </div>
                            </div>
                             <div class="form-group row">
                               <label for="s_id_sucursal" class="col-sm-3 col-md-3 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-5 col-md-5">
                                    <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group row">
                                <label for="ch_aplicar" class="col-sm-3 col-md-3 col-form-label">Aplicar Todas: </label>
                                <div class="col-sm-1 col-md-1">
                                    <input type="checkbox" id="ch_aplicar" name="ch_aplicar" value="">
                                </div>
                                <div class="col-sm-5 col-md-5"></div>
                                 <div class="col-sm-2 col-md-2">
                                 <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                             </div>
                                
                            </div>
                            
                            
                        </form>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-8 col-md-8">
                        <div id="d_arbol"></div>
                    </div>
                    <div class="col-sm-2 col-md-2" style="vertical-align: top;text-align: right;">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" id="b_expedientes"><span class="fa fa-archive"></span> Permisos a Expedientes</button><br>

                        <?php
                            if($_SESSION["id_usuario"] == 404 || $_SESSION["id_usuario"] == 4 || $_SESSION["id_usuario"] == 316){
                                echo '<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" id="b_duplicar_permisos"><span class="fa fa-clone"></span> Duplicar Permisos</button><br>';
                            };
                        ?>
                
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" id="b_supervisor"><span class="fa fa-user-circle-o"></span> Supervisor</button><br>
                        
                        <button type="button" class="btn btn-primary btn-sm verificar_permiso" alt='ACCESOS' data-dismiss="modal" id="b_accesos"><span class="fa fa-unlock-alt"></span> Accesos</button>
                        
                       
                    </div>
                </div>
                <br>
            </div> <!--div_contenedor-->
            <br>
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_usuarios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_usuario" id="i_filtro_usuario" class="form-control filtrar_renglones" alt="renglon_usuarios" placeholder="Filtrar" autocomplete="off"></div>
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

<div id="dialog_asignar_supervisor" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asignar Supervisor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_supervisor"> 
            <div class="form-group row">
                <label for="i_usuario_actual" class="col-sm-3 col-md-3 col-form-label requerido">Usuario </label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control validate[required]" id="i_usuario_actual" readonly>
                </div>
            </div>
           
          
                <div class="form-group row">
                    <label for="i_supervisor" class="col-sm-3 col-md-3 col-form-label requerido">Supervisor Nómina </label>
                    <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control validate[required]" id="i_supervisor" disabled="disabled" placeholder="Supervisor Nomina" autocomplete="off">
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <button type="button" class="btn btn-info btn-sm"  id="b_buscar_empleados"><span class="fa fa-search"></span> Buscar</button>
                    </div>
                </div>
            
               
        </form>    
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-dark btn-sm" id="b_guardar_supervisor"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                   
      </div>
    </div>
  </div>
</div>

<div id="dialog_buscar_empleados" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Supervisores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_empleado" id="i_filtro_empleado" class="form-control filtrar_renglones" alt="renglon_empleados" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_empleados">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Unidad Negocio</th>
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
<script src="js/jstree.js"></script>

<script>

    var modulo='PERMISOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var arra=[];
    var cont = 0;
    $(function(){

        mostrarBotonAyuda(modulo);
        
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        $("#s_id_unidades option").each(function(){
            arra[cont++]=$(this).val();
        });
    
        

        $('#s_id_unidades').prop('disabled',true);
        $('#s_id_sucursal').prop('disabled',true);

        $('#b_duplicar_permisos').prop('disabled',false);
        $('#b_supervisor').prop('disabled',true);
        $('#b_expedientes').prop('disabled',true);
        $('#b_guardar').prop('disabled',true);
        $('#b_accesos').prop('disabled',false);

        //verificaPermiso('b_duplicar_permisos',idUnidadActual,1,idUsuario);

        $('#b_buscar_usuarios').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_usuario').val('');
            $('.renglon_usuarios').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/usuarios_buscar.php',
                dataType:"json", 
                data:{'estatus':'1'},

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

                            var html='<tr class="renglon_usuarios" alt="'+data[i].id_usuario+'" alt2="'+data[i].nombre_comp+'" alt3="' + data[i].usuario+ '" alt4="' + data[i].id_supervisor+ '">\
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
                    console.log(xhr.responseText);
                    mandarMensaje('Error en el sistema');
                }
            });
        });


        $('#t_usuarios').on('click', '.renglon_usuarios', function() {
        
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var usuario = $(this).attr('alt3');
            var idSupervisor = $(this).attr('alt4');
            $('#i_usuario').attr('alt',0).attr('alt2','').attr('alt3',0).val('');
           
            $('#d_arbol').jstree('destroy');
            $('#i_usuario').attr('alt',id).attr('alt2',usuario).attr('alt3',idSupervisor).val(nombre);
           
            muestraSelectUnidadesAccesoUsuario('s_id_unidades','',id);
            $('#s_id_unidades').prop('disabled',false);
            $('#s_id_sucursal').prop('disabled',false);

            $('#dialog_buscar_usuarios').modal('hide');

        });

        $(document).on('change','#s_id_unidades',function(){
            var unidad=$('select[name="s_id_unidades"] option:selected').text();
            $('#d_arbol').jstree('destroy');
            var idUnidadNegocio=$(this).val();
            var idUsuario=$('#i_usuario').attr('alt');
            muestraSucursalesAcceso('s_id_sucursal',idUnidadNegocio,$('#i_usuario').attr('alt'));
            $('#s_id_sucursal').prop('disabled',false);

            if(unidad=='SECORP' || unidad=='REAL SHINY' || unidad == 'PREMIUM PARKING')
            {

                console.log('* ' + unidad);
                
                $('#b_supervisor').prop('disabled',false);
            }
            else
                $('#b_supervisor').prop('disabled', true); 
            
        });

        $(document).on('change','#s_id_sucursal',function(){
            $('#d_arbol').empty().jstree('destroy');
            buscaPermisosUsuario();
        });

      

        function buscaPermisosUsuario(){

            $('#d_arbol').jstree('destroy');
            $('#b_guardar').attr('disabled',true);
            
            $.ajax({
                    type: 'POST',
                    url: 'php/permisos_buscar_arbol.php',
                    dataType:"json",
                    data:{
                        'idUsuario':$('#i_usuario').attr('alt'),
                        'idUnidadNegocio':$('#s_id_unidades').val(),
                        'idSucursal':$('#s_id_sucursal').val()
            },
            success: function(data) {
                
                info=data;
                $('#d_arbol').jstree({ 
                    'core' : {
                    'data' : data,
                    'themes': {
                        'responsive': true
                        }
                    },
                    "checkbox" : {
                        "keep_selected_style" : false,
                        "three_state": false
                    },
                    "plugins" : [ "checkbox" ]
                });
                $('#b_guardar').attr('disabled',false);
                //---- recorre data para saber si expedientes tiene permiso
                for (i = 0; i < info.length; i++) {

                    //if (info[i].id == 'EXPEDIENTES') {
                    //-->NJES Feb/07/2020 se cambia porque en menus esta de esta manera
                    if (info[i].id == 'EXPEDIENTES_PERMISOS') {

                        var estado=JSON.stringify(info[i].state);
                        if(estado.indexOf("true")!=-1){
                            $('#b_expedientes').prop('disabled',false);
                        }else{
                             $('#b_expedientes').prop('disabled',true);
                        }
                    }

                }
            },
            error: function (xhr) {
                console.log("ERROR aqui"+JSON.stringify(xhr));
                mandarMensaje('Error en el sistema');
            }
            });
        }

         $('#b_guardar').click(function(){
            guardar('b_guardar');

         });

        

        function guardar(boton){

            $('#b_guardar').attr('disabled',true);
            //--verificó que aun exista la session para no perder datos de usuario
            <?php if (isset($_SESSION['usuario'])){ ?>
                var aux = [];
                var arbol = $('#d_arbol').jstree(true)._model.data;
                var tamaño = Object.keys(info).length;
                for(var i = 0; i<tamaño;i++){
                    var id = info[i];
                    var nodo = arbol[id.id];
                    aux.push({'menu':nodo.id,'sistema':nodo.parent,'state':nodo.state.selected});
                }
            
                $.ajax({
                    type: 'POST',
                    url: 'php/permisos_guardar_arbol.php',
                    //dataType:"json",
                    data:{
                        'permisos':aux,
                        'usuario':$('#i_usuario').attr('alt2'),
                        'idUsuario':$('#i_usuario').attr('alt'),
                        'idUnidadNegocio':$('#s_id_unidades').val(),
                        'idsSucursales':obtenerIdsSucursales()
                },
                success: function(data) {
                    console.log(data);
                    if(data==1){

                        if(boton=='b_expedientes'){
                            window.open("fr_expedientes.php?idUsuarioP="+$('#i_usuario').attr('alt')+"&nombreUsuarioP="+$('#i_usuario').val()+"&usuarioP="+$('#i_usuario').attr('alt2'),"_self");
                        }else{
                            mandarMensaje('Los permisos se guardaron correctamente');
                            limpiarPantalla();
                        }
                        
                        
                    }else{
                        
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').attr('disabled',false);
                        
                    }
                    
                },
                error: function (xhr) {
                    console.log('php/permisos_guardar_arbol.php -->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                    $('#b_guardar').attr('disabled',false);
                    
                }
                });
            <?php }else{ ?>
               $('#b_guardar').attr('disabled',false);
                include('php/logout.php');
            <?php } ?>
                
        }


         function obtenerIdsSucursales(){
            var paquete = [];
            if($('#ch_aplicar').is(':checked')){
            
                $("#s_id_sucursal option").each(function(){

                    if($(this).attr('value')>0){

                        var paq = {'idSucursal': $(this).attr('value')}
                        paquete.push(paq);
                    }
                });
            
            }else{
                 var paq = {'idSucursal': $('#s_id_sucursal').val()}
                 paquete.push(paq);

            }
            
            return paquete;
        } 


        function limpiarPantalla(){
            $('#d_arbol').jstree('destroy');
            $('#i_usuario').val('').attr('alt',0).attr('alt2','').attr('alt3','');
            $('#s_id_sucursal').val('');
            $('#s_id_unidades').val('');
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            
            $('#s_id_sucursal').val('');

            $('#s_id_unidades').prop('disabled',true);
            $('#s_id_sucursal').prop('disabled',true);

            $('#b_duplicar_permisos').prop('disabled',true);
            $('#b_supervisor').prop('disabled',true);
            $('#b_expedientes').prop('disabled',true);
            $('#b_guardar').prop('disabled',true);
            $('#b_accesos').prop('disabled',false);
            $('#ch_aplicar').prop('checked',false);

        } 

        $(document).on('click','#EXPEDIENTES_anchor',function(){

            if($(this).hasClass('jstree-clicked')){
                $('#b_expedientes').prop('disabled',false);
            }else{
                $('#b_expedientes').prop('disabled',true);
            }
            
        }); 

        $('#b_accesos').on('click',function(){
            window.open("fr_accesos.php?idUsuarioP="+$('#i_usuario').attr('alt')+"&nombreUsuarioP="+$('#i_usuario').val()+"&usuarioP="+$('#i_usuario').attr('alt2'),"_self");
        });

        $('#b_duplicar_permisos').on('click',function(){
            window.open("fr_permisos_duplicar.php","_self");
        });

        $('#b_expedientes').on('click',function(){
            guardar('b_expedientes'); 
        });

        $('#b_supervisor').on('click',function(){
            $('#dialog_asignar_supervisor').modal('show');
            $('#i_usuario_actual').val('');
            $('#i_supervisor').val('');
    
            var usuario=$('#i_usuario').val();
            var idSupervisor = $('#i_usuario').attr('alt3');
            $('#i_usuario_actual').val(usuario);
            if(idSupervisor>0){
                muestraSupervisor(idSupervisor);
            }
            
            
        });


        $('#b_buscar_empleados').on('click',function(){
                
                $('#i_filtro_empleado').val('');
                $('.renglon_empleados').remove();
       
                $.ajax({
    
                    type: 'POST',
                    url: 'php/empleados_buscar_supervisores.php',
                    dataType:"json", 
                    data:{
                        'idEmpleado':0
                    },
    
                    success: function(data) {
    
                       if(data.length != 0 ){
    
                            $('.renglon_empleados').remove();
                       
                            for(var i=0;data.length>i;i++){
    
                                
    
                                var html='<tr class="renglon_empleados" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'">\
                                            <td data-label="usuario">' + data[i].id_trabajador+ '</td>\
                                            <td data-label="usuario">' + data[i].nombre+ '</td>\
                                            <td data-label="usuario">' + data[i].unidad_negocio+ '</td>\
                                            <td data-label="usuario">' + data[i].sucursal+ '</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_empleados tbody').append(html);   
                                $('#dialog_buscar_empleados').modal('show');   
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
                var nombre = $(this).attr('alt2');
                $('#i_supervisor').attr('alt',id).val(id+' - '+nombre);
    
                $('#dialog_buscar_empleados').modal('hide');
    
            });

            

        function muestraSupervisor(idSupervisor){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/empleados_buscar_supervisores.php',
                dataType:"json", 
                data:{
                    'idEmpleado':idSupervisor
                },
                success: function(data) {

                    $('#i_supervisor').val(idSupervisor+' - '+data[0].nombre);

                },
                error: function (xhr) {
                    mandarMensaje(xhr.responseText);
                }
            });
        }

            $('#b_guardar_supervisor').on('click',function(){
                 $('#b_guardar_supervisor').prop('disabled',true);

                if ($('#form_supervisor').validationEngine('validate')){
                    $.ajax({
    
                        type: 'POST',
                        url: 'php/usuarios_asignar_supervisor.php',
                        data:{
                            'idUsuario' : $('#i_usuario').attr('alt'),
                            'idSupervisor' : $('#i_supervisor').attr('alt')
                        },
                        success: function(data){
                            $('#b_guardar_supervisor').prop('disabled',false);
                            if(data > 0){
                                $('#b_asignar_supervisor').attr('alt',$('#i_supervisor').attr('alt')).attr('alt2',$('#i_supervisor').val());
             
                                mandarMensaje('El supervisor: '+$('#i_supervisor').val()+' fue asignado correctamente');
                            }else{
                                mandarMensaje('Ocurrio un error durante el proceso')
                            }
                        },
                        error: function (xhr) {
                            console.log('php/usuarios_asignar_supervisor.php'+JSON.stringify(xhr))
                            mandarMensaje('Error en el sistema');
                        }
                    });

                }else{
                
                    $('#b_guardar_supervisor').prop('disabled',false);
                }
            });



/*
ESTA FUNCION COMPARA LOS ACCESO DE QUIE ENTA DANDO PERMISO 
Y AQUIE SE LE ESTA DANDO ACCESO Y SOLO MUESTRA LAS UNIDADES A LA QUE OS 2 TIENEN ACCESO
Crea el combo select con imagen de las unidades de negoio a las que tiene acceso el usuario 
*contenedor = nombre id de contenedor select
*idUnidadActual = id de la unidad actual para que al entrar al modulo muestre por default la unidad en la que se encuentra
*/
function muestraSelectUnidadesAccesoUsuario(contenedor,idUnidadActual,idUsuario){   
    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{
            'tipoSelect' : 'UNIDADES_NEGOCIO_ACCESO',
            'idUsuario'  : idUsuario
        },
        success: function(datos) {
            
            $("#s_id_unidades option").remove();
            if(datos!=0){

                var html='';
                html='<option value="" selected>Selecciona</option>';
                 
                for (i = 0; i < datos.length; i++) {
                   
                    $.each(arra,function(indice,elemento){
                      
                       if(elemento!='' && parseInt(datos[i].id_unidad) == parseInt(elemento)){

                            html+='<option value="'+datos[i].id_unidad+'" label="'+datos[i].logo+'">'+datos[i].nombre_unidad+'</option>';
                        }

                    });
                    
                }

                $("#"+contenedor).html(html);

                }

                //$('#'+contenedor).val(idUnidadActual);

                $("#"+contenedor).select2({
                  templateResult: setCurrency,
                  templateSelection: setCurrency
                });

                $('.img-flag').css({'width':'50px','height':'20px'});

                 },
        error: function (xhr) {
             console.log("muestraSelectUnidadesAcceso: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Unidades de Negocio Acceso');
        }
    });
}

    /* Funcion que muestra solo las sucursales a las que tiene permiso para un modulo especifico 
    sin importar la unidad de negocio*/
    function muestraSucursalesPermisoUsuario(idSelect,modulo,idUsuario){

        $('#'+idSelect).select2();

        $('#'+idSelect).html('');
        var html='<option selected disabled>Elige una Sucursal</option>';
        $('#'+idSelect).append(html);
        
        $.ajax({

                type: 'POST',
                url: 'php/combos_buscar.php',
                dataType:"json", 
                data:{

                    'tipoSelect' : 'PERMISOS_SUCURSALES_USUARIO',
                    'modulo' : modulo,
                    'idUsuario' : idUsuario

                },
                success: function(data) {
                console.log(data);
                    if(data!=0){

                        var arreglo=data;
                        for(var i=0;i<arreglo.length;i++){
                            var dato=arreglo[i];
                            
                            var html="<option value="+dato.id_sucursal+">"+dato.nombre+"</option>";
                            $('#'+idSelect).append(html);
                        }

                    }

                },
                error: function (xhr) {
                    console.log("muestraSucursalesPermisoUsuario: "+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de Sucursales Permiso por Usuario');
                }
        });
    }


    });

</script>

</html>