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
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Asignación de Autorizaciones</div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
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
                            
                            <div class="form-group row">
                                <label for="i_usuario" class="col-sm-3 col-md-3 col-form-label requerido">Usuario </label>
                                <div class="col-sm-5 col-md-5">
                                    <input type="text" class="form-control validate[required]" id="i_usuario" placeholder="Usuario" autocomplete="off" readonly="readonly">
                                </div>
                                <div class="col-sm-1 col-md-1">
                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" id="b_buscar_usuarios"><span class="fa fa-search"></span> Buscar</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_monto_minimo" class="col-sm-3 col-md-3 col-form-label requerido">Monto Mínimo</label>
                                <div class="col-sm-3 col-md-3">
                                    <input type="text" id="i_monto_minimo" name="i_monto_minimo" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_monto_maximo" class="col-sm-3 col-md-3 col-form-label requerido">Monto Máximo</label>
                                <div class="col-sm-3 col-md-3">
                                    <input type="text" id="i_monto_maximo" name="i_monto_maximo" class="form-control validate[required,custom[number],min[1]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_activo" class="col-sm-3 col-md-3">Activo</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox"  id="ch_activo" name="ch_activo" value="" style="width=20px;">
                                </div>
                                <div class="col-sm-12 col-md-2"></div>
                                <div class="col-sm-12 col-md-5">
                                <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_ASIGNACION_AUTORIZACION" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                
                                </div>
                            </div>
                              
                        
                        </form>
                        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                        </form>
                    </div>
                    
                </div>
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

<div id="dialog_buscar_asignacion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Asignación de Autorizaciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_asignacion" id="i_filtro_asignacion" class="form-control filtrar_renglones" alt="renglon_asignacion" placeholder="Filtrar" autocomplete="off"></div>
            </div>     
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_asignacion">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Usuario</th>
                          <th scope="col">Monto Mínimo</th>
                          <th scope="col">Monto Máximo</th>
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
<script src="js/jstree.js"></script>

<script>

    var modulo='ASIGNACION_AUTORIZACIONES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var tipoMov = 0;
    var id = 0;
    var usuarioOriginal = 0;
    $(function(){

        mostrarBotonAyuda(modulo);
       
        $('#ch_activo').prop('checked',true).prop('disabled',true);

        $('#b_buscar_usuarios').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_usuarios').val('');
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

                            var html='<tr class="renglon_usuarios" alt="'+data[i].id_usuario+'" alt2="'+data[i].nombre_comp+'" alt3="' + data[i].usuario+ '">\
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
         
            limpiarPantalla();
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var usuario = $(this).attr('alt2');
            $('#i_usuario').attr('alt',id).attr('alt2',usuario).val(nombre);

            $('#dialog_buscar_usuarios').modal('hide');

        });



        $('#b_buscar').on('click',function(){
            $('#i_filtro_asignacion').val('');
            $('.renglon_asignacion').remove();
            $.ajax({

                type: 'POST',
                url: 'php/asignacion_autorizacion_buscar.php',
                dataType:"json", 
                data:{'estatus' : 2},

                success: function(data) {
                    
                    for(var i=0;data.length>i;i++){

                        var estatus='Inactivo';
                        if(data[i].activo==1){
                            estatus='Activo';
                        }
                        var html="<tr class='renglon_asignacion' alt='"+data[i].id+"'>\
                        <td data-label='Clave'>"+data[i].usuario+"</td>\
                        <td data-label='Descripción'>"+data[i].monto_minimo+"</td>\
                        <td data-label='Descripción'>"+data[i].monto_maximo+"</td>\
                        <td data-label='Descripción'>"+estatus+"</td>\
                        </tr>";

                        $('#t_asignacion tbody').append(html);  
                        $('#dialog_buscar_asignacion').modal('show');
                    }

                },
                error: function (xhr) {
                    console.log("asignacion_autorizacion.php --> "+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });    

        });

        $('#t_asignacion').on('click', '.renglon_asignacion', function() {
            
            tipoMov = 1;
            $('#b_guardar').prop('disabled',false);
            
            id = $(this).attr('alt');
            
            $('#dialog_buscar_asignacion').modal('hide');
            muestraRegistro(id);


        });



        function muestraRegistro(id){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/asignacion_autorizacion_buscar_id.php',
                dataType:"json", 
                data:{
                    'id':id
                },
                success: function(data) {
                    
                    id=data[0].id;
                    usuarioOriginal=data[0].id_usuario;

                    $('#i_usuario').val(data[0].usuario).attr('alt',data[0].id_usuario);
                    $('#i_monto_minimo').val(data[0].monto_minimo);
                    $('#i_monto_maximo').val(data[0].monto_maximo);
                   
                    if (data[0].activo == 1) {
                        $('#ch_activo').prop('checked', true).prop('disabled',false);
                    } else {
                        $('#ch_activo').prop('checked', false).prop('disabled',false);
                    }
                   
                },
                error: function (xhr) {
                    console.log("asignacion_autorizacion_buscar_id.php --> "+JSON.stringify(xhr));
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
               url: 'php/asignacion_autorizacion_verificar.php',
               dataType:"json", 
               data:  {'idUsuario':$('#i_usuario').attr('alt')},
               success: function(data) 
               {
                   if(data == 1){
                      
                       if (tipoMov == 1 && usuarioOriginal == $('#i_usuario').attr('alt')) {
                           guardar();
                       } else {

                           mandarMensaje('Al usuario: '+ $('#i_usuario').val()+' ya se le asigno un rango de autorización intenta con otro usuario, o modifica su información');
                           $('#i_usuario').val('').attr('alt',0);
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
                url: 'php/asignacion_autorizacion_guardar.php',  
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                    console.log(JSON.stringify(data));
                    if (data > 0 ) {

                        mandarMensaje('La información se guardó correctamente');
                        $('#b_nuevo').click();
                               

                    }else{
                           
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log("asignacion_autorizacion_guardar.php --> "+JSON.stringify(xhr));
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
                    'id' : id,
                    'tipoMov' : tipoMov,
                    'idUsuario' : $('#i_usuario').attr('alt'),
                    'montoMinimo':quitaComa($('#i_monto_minimo').val()),
                    'montoMaximo' :quitaComa($('#i_monto_maximo').val()),
                    'activo' : $("#ch_activo").is(':checked') ? 1 : 0
                    
                }
                paquete.push(paq);
              
            return paquete;
        }

        $('#b_nuevo').click(function(){
            limpiarPantalla();
        });    

    

        function limpiarPantalla(){
            tipoMov = 0;
            id = 0;
            usuarioOriginal = 0;
            $('#i_usuario').val('').attr('alt',0).attr('alt2',''); 
            $('#i_monto_minimo').val('');
            $('#i_monto_maximo').val('');
            $('#ch_activo').prop('checked',true).prop('disabled',true);
            $('.renglon_asignacion').remove();

        } 

        $('#b_excel').click(function(){
           
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Asignacion de Autorizaciones');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('ASIGNACION_AUTORIZACIONES');
            
            $("#f_imprimir_excel").submit();
        });
        
    });

</script>

</html>