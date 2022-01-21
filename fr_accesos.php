<?php
session_start();

$idUsuarioP=0;
$nombreUsuarioP='';
$usuarioP='';

if(isset($_GET['idUsuarioP'])!=0 && isset($_REQUEST['nombreUsuarioP'])!='' && isset($_REQUEST['usuarioP'])!=''){

    $idUsuarioP=$_GET['idUsuarioP'];
    $nombreUsuarioP=$_REQUEST['nombreUsuarioP'];
    $usuarioP=$_REQUEST['usuarioP'];
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
    #label_nota{
        font-size:14px;
        color:#006600;
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
                        <div class="titulo_ban">Accesos</div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
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

                            <div class="row">
                                <div class="col-sm-10 col-md-10" style="text-align:right;">
                                    <label id="label_nota">* Dar clic para agregar o quitar sucursal</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-10 col-md-10">
                                    <table class="tablon"  id="t_sucursales_disponibles">
                                      <thead>
                                        <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                          <th scope="col" style="text-align: left;">Sucursales Disponibles sin Acceso</th>
                                          <th scope="col" style="text-align: right;">
                                          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" id="b_agregar"><span class="fa fa-plus-circle"></span> Agregar Todas</button>
                                          </th>
                                        </tr>
                                        <tr class="renglon" style="background-color: #A3CED7;">
                                          <th scope="col">Unidad Negocio</th>
                                          <th scope="col">Sucursales</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        
                                      </tbody>
                                    </table>  
                                </div>
                            </div>
                            <br>
                            
                            <div class="row">

                                <div class="col-sm-10 col-md-10" >

                                    <table class="tablon"  id="t_sucursales_agregadas">
                                      <thead>
                                        <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                            <th scope="col" style="text-align: left;">Sucursales con Acceso</th>
                                            <th scope="col" style="text-align: right;">
                                                 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" id="b_quitar"><span class="fa fa-minus-circle"></span> Quitar Todas</button>
                                            </th>
                                        </tr>
                                        <tr class="renglon" style="background-color: #FEE89D;">
                                              <th scope="col">Unidad Negocio</th>
                                              <th scope="col">Sucursales</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        
                                      </tbody>
                                    </table>  
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


<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>

    var modulo='ACCESOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;

    var id = <?php echo $idUsuarioP?>;
    var nombre = '<?php echo $nombreUsuarioP?>';
    var usuario = '<?php echo $usuarioP?>';

    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSelectTodasUnidades('s_id_unidades',idUnidadActual);

        verificaUsuario();

        function verificaUsuario(){
            if(id>0){

                $('#i_usuario').attr('alt',id).attr('alt2',usuario).val(nombre);

                buscarSucursalesDisponibles($('#s_id_unidades').val(),id);
                buscarSucursalesAgregadas(id);
                $('#s_id_unidades').prop('disabled',false); 
            }
        }

        $('#s_id_unidades').prop('disabled',true);

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
        
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var usuario = $(this).attr('alt3');
            $('#i_usuario').attr('alt',id).attr('alt2',usuario).val(nombre);

            buscarSucursalesDisponibles($('#s_id_unidades').val(),id);
            buscarSucursalesAgregadas(id);
            $('#s_id_unidades').prop('disabled',false);
            $('#dialog_buscar_usuarios').modal('hide');

        });



    

        function buscarSucursalesDisponibles(idUnidadS,idUsuarioS){
       
            $.ajax({

                type: 'POST',
                url: 'php/accesos_buscar_sucursales_disponibles.php',
                dataType:"json", 
                data:{
                    'idUnidadNegocio':idUnidadS,
                    'idUsuario':idUsuarioS
                },
                success: function(data) {
                   console.log(data);
                   if(data.length != 0){

                        $('.renglon_disponible').remove();
                        $('#b_agregar').prop('disabled', false);
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_disponible" alt="'+data[i].id_unidad_negocio+'" alt2="'+data[i].id_sucursal+'">\
                                        <td data-label="Unidad Negocio">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_sucursales_disponibles tbody').append(html);   
                             
                        }
                   }else{
                        $('.renglon_disponible').remove();
                        mandarMensaje('No se encontraron sucursales disponibles en esta unidad de negocio, ya se dio acceso a todas');
                        $('#b_agregar').prop('disabled', true);
                   }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        function buscarSucursalesAgregadas(idUsuarioS){
            $.ajax({

                type: 'POST',
                url: 'php/accesos_buscar_sucursales_agregadas.php',
                dataType:"json", 
                data:{
                    'idUsuario':idUsuarioS
                },
                success: function(data) {
                 
                   if(data.length != 0){

                        $('.renglon_agregado').remove();
                        $('#b_quitar').prop('disabled', false);
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_agregado" alt="'+data[i].id_acceso+'" alt2="'+data[i].id_unidad_negocio+'" alt3="'+data[i].id_sucursal+'">\
                                        <td data-label="Unidad Negocio">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_sucursales_agregadas tbody').append(html);   
                             
                        }
                   }else{
                        $('.renglon_agregado').remove();
                        mandarMensaje('No se ha asignado acceso a ninguna sucursal');
                        $('#b_quitar').prop('disabled',true);
                   }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_sucursales_disponibles').on('click', '.renglon_disponible', function() {
            var renglon=$(this);
             
            $.ajax({

                type: 'POST',
                url: 'php/accesos_agregar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregarUno(renglon)},

                success: function(data) {
                  
                   if(data==1){
                      
                        renglon.remove();
                        buscarSucursalesAgregadas($('#i_usuario').attr('alt'));
                        mandarMensaje('El registro se agregó correctamente.')
                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso.');
                   }

                },
                error: function (xhr) {
                    console.log("Error  al agregar unidad suscursal-->"+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });

        });

        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatosAgregarUno(renglon){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
                var paq = {
                   'idUnidadNegocio' : renglon.attr('alt'),
                   'idSucursal' : renglon.attr('alt2'),
                   'idUsuario' : $('#i_usuario').attr('alt'),
                   'usuario' : $('#i_usuario').attr('alt2')
                }
                paquete.push(paq);
              
            return paquete;
        }  

        $('#t_sucursales_agregadas').on('click', '.renglon_agregado', function() {
            var renglon=$(this);
            $.ajax({

                type: 'POST',
                url: 'php/accesos_quitar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitarUno(renglon)},

                success: function(data) {
                   
                   if(data==1){
                  
                        renglon.remove();
                        buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_usuario').attr('alt'));
                        mandarMensaje('El registro se quitó correctamente');

                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log("Error  al quitar unidad suscursal-->"+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });

        });

        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatosQuitarUno(renglon){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
                var paq = {
                    'idAcceso' : renglon.attr('alt'),
                    'idUnidadnegocio' : renglon.attr('alt2'),
                    'idSucursal' : renglon.attr('alt3'),
                    'idUsuario' : $('#i_usuario').attr('alt')
                }
                paquete.push(paq);
              
            return paquete;
        }  

        $(document).on('click','#b_quitar',function(){
            $.ajax({

                type: 'POST',
                url: 'php/accesos_quitar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitar()},

                success: function(data) {
    
                   if(data==1)
                   {

                        $('.renglon_agregado').remove();
                        buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_usuario').attr('alt'));
                        mandarMensaje('Los registros se quitaron correctamente');
                        $('#ch_activo').prop('checked', false);
                        $('#b_quitar').prop('disabled', true);

                   }else{
                        $('#ch_activo').prop('checked', false);
                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });

        });

        function obtenerDatosQuitar(){
            var j = 0;
            var datos = [];
            
            $(".renglon_agregado").each(function() {
                j++;
            
                var idAcceso = $(this).attr('alt');
                var idUnidadnegocio = $(this).attr('alt2');
                var idSucursal = $(this).attr('alt3');
                var idUsuario = $(this).attr('alt');
          
                datos[j] = {
                    'idAcceso':idAcceso,
                    'idUnidadnegocio':idUnidadnegocio,
                    'idSucursal':idSucursal,
                    'idUsuario':idUsuario 
                };
            });
            
            datos[0] = j;

            return datos;
        }



        $(document).on('click','#b_agregar',function(){
            $.ajax({

                type: 'POST',
                url: 'php/accesos_agregar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_disponible').remove();
                        buscarSucursalesAgregadas($('#i_usuario').attr('alt'));
                        mandarMensaje('Los registros se agregaron correctamente');
                        $('#b_agregar').prop('disabled', true);

                   }else{
                        $('#b_agregar').prop('checked', false);
                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });

        });

        function obtenerDatosAgregar(){
            var j = 0;
            var datos = [];
            
            $(".renglon_disponible").each(function() {
                j++;
            
                var idAcceso = $(this).attr('alt');
          
                datos[j] = {
                
                   'idUnidadNegocio' : $(this).attr('alt'),
                   'idSucursal' : $(this).attr('alt2'),
                   'idUsuario' : $('#i_usuario').attr('alt'),
                   'usuario' : $('#i_usuario').attr('alt2')
                
                };
            });
            
            datos[0] = j;

            return datos;
        }  
       
       

        $(document).on('change','#s_id_unidades',function(){
           
            if($('#s_id_unidades').val()!= ''){
              
                buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_usuario').attr('alt'));
            }
        });

    });

</script>

</html>