<?php
session_start();

$idRazonSocial=0;
$idCliente=0;
$razonSocial='';

if(isset($_GET['idRazonSocial'])!=0 && isset($_GET['idCliente'])!=0  && isset($_REQUEST['razonSocial'])!=''){

    $idRazonSocial=$_GET['idRazonSocial'];
    $idCliente=$_GET['idCliente'];
    $razonSocial=$_REQUEST['razonSocial'];
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
    #dialog_buscar_razones_sociales > .modal-lg{
        min-width: 90%;
        max-width: 90%;
   }

   @media screen and(max-width: 1030px){
        .modal-lg{
            min-width: 800px;
            max-width: 800px;
        }
    }

    @media screen and (max-width: 600px) {
        .modal-dialog{
            max-width: 300px;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="titulo_ban">Razones Sociales Accesos a Sucursales</div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control"  id="b_regresar"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Regresar</button>
                    </div>   
                </div>

                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            
                            <div class="form-group row">
                                <label for="i_razon_social" class="col-sm-3 col-md-3 col-form-label requerido">Razon Social </label>
                                <div class="col-sm-5 col-md-5">
                                    <input type="text" class="form-control validate[required,custom[onlyLetterNumber]]" id="i_razon_social" placeholder="razonSocial" autocomplete="off">
                                </div>
                                <div class="col-sm-1 col-md-1">
                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" id="b_buscar_razones_sociales"><span class="fa fa-search"></span> Buscar</button>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                               <label for="s_id_unidades" class="col-sm-3 col-md-3 col-form-label requerido">Unidades Negocio </label>
                                <div class="col-sm-5 col-md-5">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" ></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 col-md-10">
                                    <table class="tablon"  id="t_sucursales_disponibles">
                                      <thead>
                                        <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                          <th scope="col" style="text-align: left;">Sucursales Disponibles sin Acceso</th>
                                          <th scope="col" style="text-align: right;">Agregar Todas: <input type="checkbox" id="ch_agregar" name="ch_agregar" value=""></th>
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
                                          <th scope="col" style="text-align: right;">Quitar Todas:  <input type="checkbox" id="ch_quitar" name="ch_quitar" value=""></th>
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

<div id="dialog_buscar_razones_sociales" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de razonSocials</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_razones_sociales" id="i_filtro_razones_sociales" class="form-control filtrar_renglones" alt="renglon_razones_sociales" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_razones_sociales">
                      <thead>
                        <tr class="renglon">
                          <th scope="col" width="15%">Clave</th>
                          <th scope="col" width="40%">Razon Social</th>
                          <th scope="col" width="20%">Nombre Corto</th>
                          <th scope="col" width="15%">RFC</th>
                          <th scope="col" width="15%">Estatus</th>
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

    var modulo='CLIENTES_RAZONES_SOCIALES_ACCESOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;

    var idRazonSocial = <?php echo $idRazonSocial?>;
    var idCliente = <?php echo $idCliente?>;
    var razonSocial = '<?php echo $razonSocial?>';

    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);

        verificaRazonSocial();


        function verificaRazonSocial(){
            if(idRazonSocial>0){

                $('#i_razon_social').attr('alt',idRazonSocial).attr('alt2',idCliente).val(razonSocial);

                buscarSucursalesDisponibles($('#s_id_unidades').val(),idRazonSocial);
                buscarSucursalesAgregadas(idRazonSocial);
                
            }
        }

        $('#b_regresar').on('click',function(){
            var idCliente=$('#i_razon_social').attr('alt2');
            window.open("fr_clientes.php?idCliente="+idCliente+"&regresar=1","_self");
        });



        $('#b_buscar_razones_sociales').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_razones_sociales').val('');
            $('.renglon_razones_sociales').remove();

            $.ajax({

                type: 'POST',
                url: 'php/razones_sociales_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_razones_sociales').remove();
                
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_razones_sociales" alt="'+data[i].id+'" alt2="'+data[i].id_cliente+'" alt3="'+data[i].razon_social+'">\
                                        <td data-label="Clave">' + data[i].id+ '</td>\
                                        <td data-label="Razon Social">' + data[i].razon_social+ '</td>\
                                        <td data-label="Nombre Corto">' + data[i].nombre_corto+ '</td>\
                                        <td data-label="RFC">' + data[i].rfc+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_razones_sociales tbody').append(html);   
                            $('#dialog_buscar_razones_sociales').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/razones_sociales_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_razones_sociales').on('click', '.renglon_razones_sociales', function() {

            var id = $(this).attr('alt');
            var idCliente = $(this).attr('alt2');
            var razonSocial = $(this).attr('alt3');
            $('#i_razon_social').attr('alt',id).attr('alt2',idCliente).val(razonSocial);
            $('#dialog_buscar_razones_sociales').modal('hide');

            buscarSucursalesDisponibles($('#s_id_unidades').val(),id);
            buscarSucursalesAgregadas(id);
            $('#s_id_unidades').prop('disabled',false);
            

        });
                
        


    

        function buscarSucursalesDisponibles(idUnidadS,idRazonSocial){
       
            $.ajax({

                type: 'POST',
                url: 'php/razones_sociales_accesos_buscar_sucursales_disponibles.php',
                dataType:"json", 
                data:{
                    'idUnidadNegocio':idUnidadS,
                    'idRazonSocial':idRazonSocial
                },
                success: function(data) {
                  
                   if(data.length != 0){

                        $('.renglon_disponible').remove();
                        $('#ch_agregar').prop('disabled',false);
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
                        $('#ch_agregar').prop('disabled',true);
                   }

                },
                error: function (xhr) {
                    console.log('php/razones_sociales_accesos_buscar_sucursales_disponibles.php -->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        function buscarSucursalesAgregadas(idRazonSocial){
            $.ajax({

                type: 'POST',
                url: 'php/razones_sociales_accesos_buscar_sucursales_agregadas.php',
                dataType:"json", 
                data:{
                    'idRazonSocial':idRazonSocial
                },
                success: function(data) {
                 
                   if(data.length != 0){

                        $('.renglon_agregado').remove();
                        $('#ch_quitar').prop('disabled',false);
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_agregado" alt="'+data[i].id_acceso+'" >\
                                        <td data-label="Unidad Negocio">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_sucursales_agregadas tbody').append(html);   
                             
                        }
                   }else{
                        $('.renglon_agregado').remove();
                        mandarMensaje('No se a asignado ninguna sucursal acceso');
                        $('#ch_quitar').prop('disabled',true);
                   }

                },
                error: function (xhr) {
                    console.log('php/razones_sociales_accesos_buscar_sucursales_agregadas.php -->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_sucursales_disponibles').on('click', '.renglon_disponible', function() {
            var renglon=$(this);
             
            $.ajax({

                type: 'POST',
                url: 'php/razones_sociales_accesos_agregar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregarUno(renglon)},

                success: function(data) {
                  console.log(data);
                   if(data==1){
                        renglon.remove();
                        buscarSucursalesAgregadas($('#i_razon_social').attr('alt'));
                        mandarMensaje('El registro se agregó correctamente.')
                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso.');
                   }

                },
                error: function (xhr) {
                    console.log('php/razones_sociales_accesos_agregar_sucursales.php-->'+xhr.responseText);
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
                   'idRazonSocial' : $('#i_razon_social').attr('alt'),
                   'razonSocial' : $('#i_razon_social').attr('alt3')
                }
                paquete.push(paq);
              
            return paquete;
        }  

        $('#t_sucursales_agregadas').on('click', '.renglon_agregado', function() {
            var renglon=$(this);
            $.ajax({

                type: 'POST',
                url: 'php/razones_sociales_accesos_quitar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitarUno(renglon)},

                success: function(data) {
    
                   if(data==1){
                        renglon.remove();
                        buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_razon_social').attr('alt'));
                        mandarMensaje('El registro se quitó correctamente');

                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log('php/razones_sociales_accesos_quitar_sucursales.php-->'+JSON.stringify(xhr));
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
                    'idAcceso' : renglon.attr('alt')
                }
                paquete.push(paq);
              
            return paquete;
        }  

        $(document).on('click','#ch_quitar',function(){
            $.ajax({

                type: 'POST',
                url: 'php/razones_sociales_accesos_quitar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_agregado').remove();
                        buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_razon_social').attr('alt'));
                        mandarMensaje('Los registros se quitaron correctamente');
                        $('#ch_activo').prop('checked', false);

                   }else{
                        $('#ch_activo').prop('checked', false);
                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log('php/razones_sociales_accesos_quitar_sucursales.php-->'+JSON.stringify(xhr));
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
          
                datos[j] = {
                  'idAcceso':idAcceso,
                };
            });
            
            datos[0] = j;

            return datos;
        }



        $(document).on('click','#ch_agregar',function(){
            $.ajax({

                type: 'POST',
                url: 'php/razones_sociales_accesos_agregar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_disponible').remove();
                        buscarSucursalesAgregadas($('#i_razon_social').attr('alt'));
                        mandarMensaje('Los registros se agregaron correctamente');
                        $('#ch_agregar').prop('checked', false);

                   }else{
                        $('#ch_agregar').prop('checked', false);
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
                   'idRazonSocial' : $('#i_razon_social').attr('alt'),
                   'razonSocial' : $('#i_razon_social').attr('alt3')
                
                };
            });
            
            datos[0] = j;

            return datos;
        }  
       
       

        $(document).on('change','#s_id_unidades',function(){
           
            if($('#s_id_unidades').val()!= ''){
              
                buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_razon_social').attr('alt'));
            }
        });

    });

</script>

</html>