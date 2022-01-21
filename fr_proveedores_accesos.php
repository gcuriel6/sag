<?php
session_start();

$idProveedor=0;
$proveedorP='';

if(isset($_GET['idProveedor'])!=0 && isset($_REQUEST['proveedorP'])!=''){

    $idProveedor=$_GET['idProveedor'];
    $proveedorP=$_REQUEST['proveedorP'];
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
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Proveedores Accesos a Unidades</div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
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
                            <label for="i_proveedor" class="col-2 col-md-2 col-form-label requerido">Proveedor </label><br>
                               
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                    
                                        <div class="input-group col-sm-12 col-md-9">
                                            <input type="text" id="i_proveedor" name="i_proveedor" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_Proveedores" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             
                            <div class="row">
                                <div class="col-sm-10 col-md-10">
                                    <table class="tablon"  id="t_unidades_disponibles">
                                      <thead>
                                        <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                          <th scope="col" style="text-align: left;">Unidades Disponibles sin Acceso</th>
                                          <th scope="col" style="text-align: right;"><button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" id="b_agregar"><span class="fa fa-plus-circle"></span> Agregar Todas</button></th>
                                        </tr>
                                        <tr class="renglon" style="background-color: #A3CED7;">
                                          <th scope="col" colspan="2">Unidad Negocio</th>
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

                                    <table class="tablon"  id="t_unidades_agregadas">
                                      <thead>
                                        <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                          <th scope="col" style="text-align: left;">Unidades con Acceso</th>
                                          <th scope="col" style="text-align: right;"><button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" id="b_quitar"><span class="fa fa-minus-circle"></span> Quitar Todas</button></th>
                                        </tr>
                                        <tr class="renglon" style="background-color: #FEE89D;">
                                          <th scope="col" colspan="2">Unidad Negocio</th>
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
                          <th scope="col">ID</th>
                          <th scope="col">RFC</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Grupo</th>
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

    var modulo='PROVEEDORES_ACCESOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;

    var idProveedor = <?php echo $idProveedor?>;
    var proveedor = '<?php echo $proveedorP?>';

    $(function(){

        mostrarBotonAyuda();
        //muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        verificaproveedor();
        $('#b_agregar').prop('disabled',true);
        $('#b_quitar').prop('disabled',true);

        function verificaproveedor(){
            if(idProveedor>0){

                $('#i_proveedor').attr('alt',idProveedor).val(proveedor);

                buscarUnidadesDisponibles(idProveedor);
                buscarUnidadesAgregadas(idProveedor);
            }
        }

        $('#s_id_unidades').prop('disabled',true);

        $('#b_buscar_Proveedores').on('click',function(){
            $('#forma').validationEngine('hide');
            $('#i_filtro_proveedores').val('');
            $('.renglon_proveedores').remove();

            $.ajax({

                type: 'POST',
                url: 'php/proveedores_buscar.php',
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

                            var html='<tr class="renglon_proveedores" alt="'+data[i].id+'"  alt2="'+data[i].nombre+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="RFC">' + data[i].rfc+ '</td>\
                                        <td data-label="Nombre">' + data[i].nombre+ '</td>\
                                        <td data-label="Grupo">' + data[i].grupo+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
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
        });



        $('#t_proveedores').on('click', '.renglon_proveedores', function() {
           
            $('#ch_inactivo').prop('disabled', false);
            var idProveedor = $(this).attr('alt');
            var proveedor = $(this).attr('alt2');
            $('#i_proveedor').attr('alt',idProveedor).val(proveedor);
            $('#dialog_buscar_proveedores').modal('hide');
            buscarUnidadesDisponibles(idProveedor);
            buscarUnidadesAgregadas(idProveedor);

        });

        function buscarUnidadesDisponibles(idProveedor){
       
            $.ajax({

                type: 'POST',
                url: 'php/proveedores_acceso_buscar_unidades_disponibles.php',
                dataType:"json", 
                data:{
                    'idProveedor':idProveedor
                },
                success: function(data) {
                  
                   if(data.length != 0){

                        $('.renglon_disponible').remove();
                        $('#b_agregar').prop('disabled',false);
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_disponible" alt="'+data[i].id_unidad_negocio+'">\
                                        <td data-label="Unidad Negocio" colspan="2">' + data[i].unidad_negocio+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_unidades_disponibles tbody').append(html);   
                             
                        }
                   }else{
                        $('.renglon_disponible').remove();
                        mandarMensaje('No se encontraron unidades disponibles, ya se dio acceso a todas');
                        $('#b_agregar').prop('disabled',true);
                   }

                },
                error: function (xhr) {
                    console.log('php/proveedores_acceso_buscar_unidades_disponibles.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        function buscarUnidadesAgregadas(idProveedor){
            $.ajax({

                type: 'POST',
                url: 'php/proveedores_acceso_buscar_unidades_agregadas.php',
                dataType:"json", 
                data:{
                    'idProveedor':idProveedor
                },
                success: function(data) {
                 
                   if(data.length != 0){

                        $('.renglon_agregado').remove();
                        $('#b_quitar').prop('disabled',false);
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_agregado" alt="'+data[i].id_acceso+'" >\
                                        <td data-label="Unidad Negocio" colspan="2">' + data[i].unidad_negocio+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_unidades_agregadas tbody').append(html);   
                             
                        }
                   }else{
                        $('.renglon_agregado').remove();
                        mandarMensaje('No se ha asignado a ninguna unidad');
                        $('#b_quitar').prop('disabled',true);
                   }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_unidades_disponibles').on('click', '.renglon_disponible', function() {
            var renglon=$(this);
             
            $.ajax({

                type: 'POST',
                url: 'php/proveedores_acceso_agregar_unidades.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregarUno(renglon)},

                success: function(data) {
                  console.log(data);
                   if(data==1){
                        renglon.remove();
                        buscarUnidadesAgregadas($('#i_proveedor').attr('alt'));
                        mandarMensaje('El registro se agregó correctamente.')
                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso.');
                   }

                },
                error: function (xhr) {
                    console.log('php/proveedores_acceso_agregar_unidades.php-->'+JSON.stringify(xhr));
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
                   'idProveedor' : $('#i_proveedor').attr('alt')
                }
                paquete.push(paq);
              
            return paquete;
        }  

        $('#t_unidades_agregadas').on('click', '.renglon_agregado', function() {
            var renglon=$(this);
            $.ajax({

                type: 'POST',
                url: 'php/proveedores_acceso_quitar_unidades.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitarUno(renglon)},

                success: function(data) {
    
                   if(data==1){
                        renglon.remove();
                        buscarUnidadesDisponibles($('#i_proveedor').attr('alt'));
                        mandarMensaje('El registro se quitó correctamente');

                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log('php/proveedores_acceso_quitar_unidades.php-->'+JSON.stringify(xhr));
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

        $(document).on('click','#b_quitar',function(){
            $.ajax({

                type: 'POST',
                url: 'php/proveedores_acceso_quitar_unidades.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_agregado').remove();
                        buscarUnidadesDisponibles($('#i_proveedor').attr('alt'));
                        mandarMensaje('Los registros se quitaron correctamente');
                        $('#b_quitar').prop('disabled',true);
                        $('#ch_activo').prop('checked', false);

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
          
                datos[j] = {
                  'idAcceso':idAcceso,
                };
            });
            
            datos[0] = j;

            return datos;
        }



        $(document).on('click','#b_agregar',function(){
            $('#b_agregar').prop('disabled', true);
            $.ajax({

                type: 'POST',
                url: 'php/proveedores_acceso_agregar_unidades.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_disponible').remove();
                        buscarUnidadesAgregadas($('#i_proveedor').attr('alt'));
                        mandarMensaje('Los registros se agregaron correctamente');
                        $('#b_agregar').prop('disabled', true);

                   }else{
                        $('#b_agregar').prop('disabled', false);
                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log('php/proveedores_acceso_agregar_unidades.php-->'+JSON.stringify(xhr));
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
                   'idProveedor' : $('#i_proveedor').attr('alt')
                
                };
            });
            
            datos[0] = j;

            return datos;
        }  
       
       

        $(document).on('change','#i_proveedor',function(){
           
            if($('#i_proveedor').val()!= ''){
              
                buscarUnidadesDisponibles($('#i_proveedor').attr('alt'));
            }
        });

        $('#b_regresar').on('click',function(){
            var idProveedor=$('#i_proveedor').attr('alt');
            window.open("fr_proveedores.php?idProveedor="+idProveedor+"&regresar=1","_self");
        });

    });

</script>

</html>