<?php
session_start();

$idProductoP=0;
$productoP='';

if(isset($_GET['idProductoP'])!=0 && isset($_REQUEST['productoP'])!=''){

    $idProductoP=$_GET['idProductoP'];
    $productoP=$_REQUEST['productoP'];
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
                        <div class="titulo_ban">Asignar Productos a Unidades</div>
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
                            <label for="i_producto" class="col-2 col-md-2 col-form-label requerido">Producto </label><br>
                               
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                    
                                        <div class="input-group col-sm-12 col-md-9">
                                            <input type="text" id="i_producto" name="i_producto" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_productos" style="margin:0px;">
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
                                          <th scope="col" style="text-align: right;">Agregar Todas: <input type="checkbox" id="ch_agregar" name="ch_agregar" value=""></th>
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
                                          <th scope="col" style="text-align: right;">Quitar Todas:  <input type="checkbox" id="ch_quitar" name="ch_quitar" value=""></th>
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

<div id="dialog_buscar_productos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="input-group col-sm-12 col-md-4">
                    <input type="text" id="i_familia_filtro" name="i_familia_filtro" class="form-control" placeholder="Filtrar Por Familia" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_familia_filtro" style="margin:0px;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div> 
                <div class="input-group col-sm-12 col-md-4">
                    <input type="text" id="i_linea_filtro" name="i_linea_filtro" class="form-control" placeholder="Filtrar Por Línea" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_lineas_filtro" style="margin:0px;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>  
                <div class="col-sm-12 col-md-4"><input type="text" name="i_filtro_producto" id="i_filtro_producto" class="form-control filtrar_renglones" alt="renglon_producto" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_productos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Catalogo</th>
                          <th scope="col">Familia</th>
                          <th scope="col">Linea</th>
                          <th scope="col">Concepto</th>
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

<div id="dialog_buscar_familias" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Familias</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_familias" id="i_filtro_familias" class="form-control filtrar_renglones" alt="renglon_familias" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_familias">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Tallas</th>
                          <th scope="col">Tipo</th>
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

<div id="dialog_buscar_lineas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Lineas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_lineas" id="i_filtro_lineas" class="form-control filtrar_renglones" alt="renglon_lineas" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_lineas">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Familia</th>
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

    var modulo='PRODUCTOS_ACCESOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;

    var idProducto = <?php echo $idProductoP?>;
    var producto = '<?php echo $productoP?>';

    $(function(){

        mostrarBotonAyuda(modulo);
        //muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        verificaProducto();

        function verificaProducto(){
            if(idProducto>0){

                $('#i_producto').attr('alt',idProducto).val(producto);

                buscarUnidadesDisponibles(idProducto);
                buscarUnidadesAgregadas(idProducto);
            }
        }

        $('#s_id_unidades').prop('disabled',true);

        $('#b_buscar_productos').on('click',function(){
            $('#forma').validationEngine('hide');
            $('#i_filtro_producto').val('');
            $('.renglon_producto').remove();
            $('#i_familia_filtro').val('').attr('alt',0);
            $('#i_linea_filtro').val('').attr('alt',0);
            $('#dialog_buscar_productos').modal('show'); 
        });


        function buscarProductos(){
   
            $.ajax({

                type: 'POST',
                url: 'php/productos_buscar_filtros.php',
                dataType:"json", 
                data:{'idFamilia':$('#i_familia_filtro').attr('alt'),
                      'idLinea':$('#i_linea_filtro').attr('alt')
                },
                success: function(data) {
                   if(data.length != 0){

                        $('.renglon_producto').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activa';
                            }

                            //-->NJES November/11/2020 cuando es un producto de la familia gasto FLETES Y LOGISTICA no se puede asignar a ninguna unidad
                            if(data[i].id_familia_gasto != 104)
                            {
                                var html='<tr class="renglon_producto" alt="'+data[i].id+'" alt2="' + data[i].concepto+ '">\
                                            <td data-label="Catalogo">' + data[i].id+ '</td>\
                                            <td data-label="Familia">' + data[i].familia+ '</td>\
                                            <td data-label="Linea">' + data[i].linea+ '</td>\
                                            <td data-label="Concepto">' + data[i].concepto+ '</td>\
                                            <td data-label="Estatus">' + inactivo+ '</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_productos tbody').append(html);  
                            } 
                              
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/productos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_productos').on('click', '.renglon_producto', function() {
            
           
            $('#ch_inactivo').prop('disabled', false);
            var idProducto = $(this).attr('alt');
            var producto = $(this).attr('alt2');
            $('#i_producto').attr('alt',idProducto).val(producto);
            $('#dialog_buscar_productos').modal('hide');
            buscarUnidadesDisponibles(idProducto);
            buscarUnidadesAgregadas(idProducto);

        });


        //************Solo muestra las familias activas */
        $('#b_buscar_familias').on('click',function(){
           $('#i_familia').validationEngine('hide'); 
           buscaFamilias(1);
        });

        $('#b_buscar_familia_filtro').on('click',function(){
           buscaFamilias(2);
        });

        function buscaFamilias(boton){
            $('#i_filtro_familias').val('');
            $('.renglon_familias').remove();

            $.ajax({

                type: 'POST',
                url: 'php/familias_buscar.php',
                dataType:"json", 
                data:{'estatus':0},

                success: function(data) {
                
                if(data.length != 0){

                    $('.renglon_familias').remove();
                
                    for(var i=0;data.length>i;i++){

                        ///llena la tabla con renglones de registros
                        var inactivo='';
                        
                        if(parseInt(data[i].inactivo) == 1){

                            inactivo='inactivo';
                        }else{
                            inactivo='Activa';
                        }

                        var html='<tr class="renglon_familias" alt="'+data[i].id+'" alt2="'+data[i].descripcion+'" boton="'+boton+'">\
                                    <td data-label="ID">' + data[i].id+ '</td>\
                                    <td data-label="Clave">' + data[i].clave+ '</td>\
                                    <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                    <td data-label="Tallas">' + data[i].tallas+ '</td>\
                                    <td data-label="Tipo">' + data[i].tipo+ '</td>\
                                    <td data-label="Estatus">' + inactivo+ '</td>\
                                </tr>';
                        ///agrega la tabla creada al div 
                        $('#t_familias tbody').append(html);   
                        $('#dialog_buscar_familias').modal('show');   
                    }
                        
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/familias_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_familias').on('click', '.renglon_familias', function() {
            var boton = $(this).attr('boton');
            var  idFamilia = $(this).attr('alt');
            var  familia = $(this).attr('alt2');
            if(boton==1){
                $('#i_familia').attr('alt',idFamilia).val(familia);
            }else{
                $('#i_familia_filtro').attr('alt',idFamilia).val(familia);
                buscarProductos();
            }
            
            $('#dialog_buscar_familias').modal('hide');

        });


        //************Solo muestra las familias activas */
        $('#b_buscar_lineas').on('click',function(){
           $('#i_linea').validationEngine('hide');
           buscaLineas(1);
        });
        $('#b_buscar_lineas_filtro').on('click',function(){
            buscaLineas(2);
        });

        function buscaLineas(boton){

                $('#i_filtro_lineas').val('');
                $('.renglon_lineas').remove();

                $.ajax({

                    type: 'POST',
                    url: 'php/lineas_buscar.php',
                    dataType:"json", 
                    data:{'estatus':0},

                    success: function(data) {
                  
                    if(data.length != 0){

                            $('.renglon_lineas').remove();
                    
                            for(var i=0;data.length>i;i++){

                                ///llena la tabla con renglones de registros
                                var inactiva='';
                                
                                if(parseInt(data[i].inactiva) == 1){

                                    inactiva='Inactiva';
                                }else{
                                    inactiva='Activa';
                                }

                                var html='<tr class="renglon_lineas" alt="'+data[i].id+'" alt2="' + data[i].descripcion+ '" boton="'+boton+'">\
                                            <td data-label="Clave">' + data[i].clave+ '</td>\
                                            <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                            <td data-label="Familia">' + data[i].familia+ '</td>\
                                            <td data-label="Estatus">' + inactiva+ '</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_lineas tbody').append(html);   
                                $('#dialog_buscar_lineas').modal('show');   
                            }
                    }else{

                            mandarMensaje('No se encontró información');
                    }

                    },
                    error: function (xhr) {
                        console.log('php/lineas_buscar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }
                });
            }

            $('#t_lineas').on('click', '.renglon_lineas', function() {
                var boton = $(this).attr('boton');
                var idLinea = $(this).attr('alt');
                var linea = $(this).attr('alt2');

                if(boton==1){
                    $('#i_linea').val(linea).attr('alt',idLinea);
                }else{
                    $('#i_linea_filtro').val(linea).attr('alt',idLinea);
                    buscarProductos();
                }

                

                $('#dialog_buscar_lineas').modal('hide');


            });



    

        function buscarUnidadesDisponibles(idProducto){
       
            $.ajax({

                type: 'POST',
                url: 'php/productos_acceso_buscar_unidades_disponibles.php',
                dataType:"json", 
                data:{
                    'idProducto':idProducto
                },
                success: function(data) {
                  
                   if(data.length != 0){

                        $('.renglon_disponible').remove();
                        $('#ch_agregar').prop('disabled',false);
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
                        $('#ch_agregar').prop('disabled',true);
                   }

                },
                error: function (xhr) {
                    console.log('php/productos_acceso_buscar_unidades_disponibles.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        function buscarUnidadesAgregadas(idProducto){
            $.ajax({

                type: 'POST',
                url: 'php/productos_acceso_buscar_unidades_agregadas.php',
                dataType:"json", 
                data:{
                    'idProducto':idProducto
                },
                success: function(data) {
                 
                   if(data.length != 0){

                        $('.renglon_agregado').remove();
                        $('#ch_quitar').prop('disabled',false);
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
                        mandarMensaje('No se ha asignado a ninguna unidad de negocio');
                        $('#ch_quitar').prop('disabled',true);
                   }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_unidades_disponibles').on('click', '.renglon_disponible', function() {
            $(this).prop('disabled',true);
            var renglon=$(this);
             
            $.ajax({

                type: 'POST',
                url: 'php/productos_acceso_agregar_unidades.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregarUno(renglon)},

                success: function(data) {
                  console.log(data);
                   if(data==1){
                        renglon.remove();
                        buscarUnidadesAgregadas($('#i_producto').attr('alt'));
                        mandarMensaje('El registro se agregó correctamente.')
                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso.');
                   }

                },
                error: function (xhr) {
                    console.log('php/productos_acceso_agregar_unidades.php-->'+JSON.stringify(xhr));
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
                   'idProducto' : $('#i_producto').attr('alt')
                }
                paquete.push(paq);
              
            return paquete;
        }  

        $('#t_unidades_agregadas').on('click', '.renglon_agregado', function() {
            $(this).prop('disabled',true);
            var renglon=$(this);
            renglon.removeClass('renglon_agregado');
            
            $.ajax({

                type: 'POST',
                url: 'php/productos_acceso_quitar_unidades.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitarUno(renglon)},

                success: function(data) {
    
                   if(data==1){
                        renglon.remove();
                        buscarUnidadesDisponibles($('#i_producto').attr('alt'));
                        mandarMensaje('El registro se quitó correctamente');

                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log('php/productos_acceso_quitar_unidades.php-->'+JSON.stringify(xhr));
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
                url: 'php/productos_acceso_quitar_unidades.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_agregado').remove();
                        buscarUnidadesDisponibles($('#i_producto').attr('alt'));
                        mandarMensaje('Los registros se quitaron correctamente');
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



        $(document).on('click','#ch_agregar',function(){
            $.ajax({

                type: 'POST',
                url: 'php/productos_acceso_agregar_unidades.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_disponible').remove();
                        buscarUnidadesAgregadas($('#i_producto').attr('alt'));
                        mandarMensaje('Los registros se agregaron correctamente');
                        $('#ch_agregar').prop('checked', false);

                   }else{
                        $('#ch_agregar').prop('checked', false);
                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log('php/productos_acceso_agregar_unidades.php-->'+JSON.stringify(xhr));
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
                   'idProducto' : $('#i_producto').attr('alt')
                
                };
            });
            
            datos[0] = j;

            return datos;
        }  
       
       

        $(document).on('change','#i_producto',function(){
           
            if($('#i_producto').val()!= ''){
              
                buscarUnidadesDisponibles($('#i_producto').attr('alt'));
            }
        });

        $('#b_regresar').on('click',function(){
            var idProducto=$('#i_producto').attr('alt');
            window.open("fr_productos.php?idProducto="+idProducto+"&regresar=1","_self");
        });

    });

</script>

</html>