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
        max-height: 65px; 
        min-height: 65px;
        width:120px;
    }
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
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
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Firmantes</div>
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
                    <div class="col-md-2"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <form id="forma" name="forma">
                                    <div class="form-group row">
                                        <label for="i_nombre" class="col-sm-2 col-md-2 col-form-label requerido">Nombre</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control validate[required]" id="i_nombre" name="i_nombre" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_email" class="col-sm-2 col-md-2 col-form-label requerido">Email</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control validate[required,custom[email]]" id="i_email" name="i_email" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_telefono" class="col-sm-2 col-md-2 col-form-label">Telefono</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control" id="i_telefono" name="i_telefono" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_iniciales" class="col-sm-2 col-md-2 col-form-label requerido">Iniciales</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control validate[required]" id="i_iniciales" name="i_iniciales" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_firma" class="col-sm-2 col-md-2 col-form-label requerido">Firma autógrafa </label>
                                        <div class="col-sm-12 col-md-4">
                                            <input type="file" class="form-control validate[required]" id="i_firma" name="i_firma" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-5" id="div_img"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ch_inactivo" class="col-sm-2 col-md-2 col-form-label">Activo</label>
                                        <div class="col-sm-10 col-md-2">
                                            <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                        </div>
                                        <div class="col-sm-12 col-md-2"></div>
                                        <div class="col-sm-12 col-md-5">
                                            <button type="button" class="btn btn-primary btn-sm form-control verificar_permiso" alt="BOTON_ASIGNAR_SUCURSALES" id="b_asignar_suc"><i class="fa fa-check-square" aria-hidden="true"></i> Asignar a Sucursales</button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-6"></div>
                                        <div class="col-sm-12 col-md-5">
                                            <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_FIRMANTES" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>  
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_firmantes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de  Firmantes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_firmante" id="i_filtro_firmante" class="form-control filtrar_renglones" alt="renglon_firmante" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_firmantes">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Iniciales</th>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_asignar_sucursales_firmantes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--<h5 class="modal-title">Asignar Firmante a Sucursales</h5>-->
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="titulo_ban">Asignar Firmante a Sucursales</div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <form id="forma_asignar_sucursales_firmantes" name="forma_asignar_sucursales_firmantes">
                            <div class="form-group row">
                                <div class="col-sm-10 col-md-1"></div>
                                <label for="i_firmante" class="col-sm-3 col-md-3 col-form-label requerido">Firmante </label>
                                <div class="input-group col-sm-12 col-md-5">
                                    <input type="text" id="i_firmante" name="i_firmante" class="form-control" autocomplete="off" aria-describedby="b_buscar_firmantes">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_firmantes" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="form-group row">
                                <div class="col-sm-10 col-md-1"></div>
                                <label for="s_id_unidades" class="col-sm-3 col-md-3 col-form-label requerido">Unidades Negocio </label>
                                <div class="col-sm-5 col-md-5">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 col-md-1"></div>
                                <div class="col-sm-10 col-md-10">
                                    <table class="tablon"  id="t_sucursales_disponibles">
                                        <thead>
                                        <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                            <th scope="col" style="text-align: left;">Sucursales Sin Asignar</th>
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
                                <div class="col-sm-10 col-md-1"></div>
                                <div class="col-sm-10 col-md-10" >
                                    <table class="tablon"  id="t_sucursales_agregadas">
                                        <thead>
                                        <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                            <th scope="col" style="text-align: left;">Sucursales Asignadas</th>
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
            </div>
            <br>
        </div>
    </div>
</div>

<div id="dialog_buscar_firmantes_asigna" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Firmantes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_firmantes" id="i_filtro_firmantes" class="form-control filtrar_renglones" alt="renglon_firmantes_asigna" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_firmantes_asigna">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Nombre</th>
                          <th scope="col">Iniciales</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
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
 
    var idFirmante=0;
    var firmanteOriginal='';
    var tipo_mov=0;
    var modulo='FIRMANTES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var imagenAnterior='';

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){

        mostrarBotonAyuda(modulo);
        
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#s_id_unidades').prop('disabled',true);
        
        $('#div_img').empty();
       
        $('#ch_inactivo').prop('checked',false).attr('disabled',true);

        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_firmante').val('');
            $('.renglon_firmante').remove();

            $.ajax({

                type: 'POST',
                url: 'php/firmantes_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                if(data.length != 0){

                        $('.renglon_firmante').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].activo) == 1){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_firmante" alt="'+data[i].id+'">\
                                        <td data-label="Nombre">' + data[i].nombre+ '</td>\
                                        <td data-label="Emaill">' + data[i].telefono+ '</td>\
                                        <td data-label="Telefono">' + data[i].email+ '</td>\
                                        <td data-label="Iniciales">' + data[i].iniciales+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_firmantes tbody').append(html);   
                            $('#dialog_buscar_firmantes').modal('show');   
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

        $('#t_firmantes').on('click', '.renglon_firmante', function() {
            idFirmante = $(this).attr('alt');
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#dialog_buscar_firmantes').modal('hide');
            muestraRegistro();
            
        });

        function muestraRegistro(){ 

            $('#div_img').html('');

            $.ajax({
                type: 'POST',
                url: 'php/firmantes_buscar_id.php',
                dataType:"json", 
                data:{
                    'idFirmante':idFirmante
                },
                success: function(data) {

                    if(data[0].firma != ''){
                        $('#i_firma').removeClass('validate[required]');
                    }else{
                        if(!$('#i_firma').hasClass('validate[required]'))
                        {
                            $('#i_firma').addClass('validate[required]'); 
                        }
                    }

                    imagenAnterior=data[0].firma;
                    firmanteOriginal=data[0].nombre;

                    $('#i_nombre').val(data[0].nombre);
                    $('#i_email').val(data[0].email);
                    $('#i_telefono').val(data[0].telefono);
                    $('#i_iniciales').val(data[0].iniciales);
                   
                    if (data[0].activo == 1) {
                        $('#ch_inactivo').prop('checked', false).attr('disabled',false);
                    } else {
                        $('#ch_inactivo').prop('checked', true).attr('disabled',false);
                    }

                    var cont_img='<img id="vistaPrevia_1" src="firmantes/'+data[0].firma+'" alt="">';
                    $('#div_img').append(cont_img);

                },
                error: function (xhr) {
                    mandarMensaje('Error en el sistema');
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
                url: 'php/firmantes_verificar.php',
                dataType:"json", 
                data:  {'nombre':$('#i_nombre').val()},
                success: function(data) 
                {   
                    if(data == 1){
                        if (tipo_mov == 1 && firmanteOriginal === $('#i_nombre').val()) {
                            guardar();
                        } else {
                            mandarMensaje('Ya existe un registro con el nombre: '+ $('#i_nombre').val()+'. Intenta con otro');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    mandarMensaje('error: '+JSON.stringify(xhr));
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }


        /* funcion que manda a generar la insecion o actualizacion de un registro */
        function guardar(){
            //Damos el valor del input tipo_mov file
            var archivos = document.getElementById("i_firma");

            //Obtenemos el valor del input (los archivos) en modo de arreglo
            var i_imagen = archivos.files; 

            var datos = new FormData();

            datos.append('tipo_mov',tipo_mov);
            datos.append('idFirmante',idFirmante);
            datos.append('imagenAnterior',imagenAnterior);
            datos.append('firma_1',i_imagen[0]);
            datos.append('nombre',$('#i_nombre').val());
            datos.append('email',$('#i_email').val());
            datos.append('telefono',$('#i_telefono').val());
            datos.append('iniciales',$('#i_iniciales').val());
            datos.append('inactivo',$('#ch_inactivo').is(':checked') ? 0 : 1);
            datos.append('elementos',$("#i_firma").val()!='' ? 1 : 0);

            var fichero = $('#i_firma').val();   
            var ext = fichero.split('.');
            ext = ext[ext.length -1];
            
            if(esImagen(ext)){  //valida la extension de la imagen
                $.ajax({
                    type: 'POST',
                    url: 'php/firmantes_guardar.php',  
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: datos,
                    //mientras enviamos el archivo
                    //mensaje de que la imagen se esta subiendo
                    beforeSend: function(){
                     if($("#i_firma").val()!=''){ 
                        message ="Subiendo la imagen, por favor espere...";
                        mandarMensaje(message);     
                     }else{
                        mandarMensaje("Generando registro, por favor espere...");
                     }   
                    },
                    //una vez finalizado correctamente
                    success: function(data)
                    {
                        if(data == 1)
                        {
                            if (tipo_mov == 0)
                            {
                                mandarMensaje('Se inserto registro');
                                limpiar();
                            }else{
                                mandarMensaje('Se actualizó el registro');
                                limpiar();
                            }
                        }else if(data == 2)
                        {
                            if (tipo_mov == 0)
                            {
                                mandarMensaje('Se inserto el registro. Verifica la magen');
                                limpiar();
                            }else{
                                mandarMensaje('Se actualizo el registro. Verifica la imagen');
                                limpiar();
                            }
                        }else{
                            mandarMensaje('Error en el guardado');
                            $('#b_guardar').prop('disabled',false);
                        }
                    },
                    //si ha ocurrido un error
                    error: function(xhr){
                        message ="Ha ocurrido un error.";
                        mandarMensaje(message);
                        $('#b_guardar').prop('disabled',false);
                    }
                });
            }else{
                mandarMensaje('Verifica la extensión de la imagen');
                $('#b_guardar').prop('disabled',false);
            }   
        }

        $('#b_nuevo').on('click',function(){
            limpiar();
        });

        /*Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
            $('#div_img').html('');

            $('input,textarea').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('checked',false).attr('disabled',true);
            
            idFirmante=0;
            tipo_mov=0;
            imagenAnterior='';

            if(!$('#i_firma').hasClass('validate[required]'))
            {
                $('#i_firma').addClass('validate[required]');
            }
        }

        /* Muestra la vista previa si surge algun cambio en el campo logo*/
        $('#i_firma').change(function(){
            mostrarVistaPrevia('i_firma',1);  
        }); 
        /* Funcion que verifica si es una imagen */
        function esImagen(extension){
            if(extension!=''){
                        
                switch(extension.toLowerCase()) 
                {
                    case 'jpg': case 'gif': case 'png': case 'jpeg':
                    return true;
                    break;
                    default:
                    return false;
                    break;
                }
            }else{
                return true;    
            }
        }

        /* Funciones para obtene la vista previa de una imagen*/  
        function obtenertipo_movMIME(cabecera) {return cabecera.replace(/data:([^;]+).*/, '\$1');
        }
        function mostrarVistaPrevia() {  //mostrar la imagen en un contenedor
        
            var Archivos, Lector;
    
                //Para navegadores antiguos
                if (typeof FileReader !== "function") {
                    return;
                }
            
                Archivos = $('#i_firma')[0].files;
                if (Archivos.length > 0) {  //verifica si se ha seleccionado un archivo
            
                    Lector = new FileReader();
                    Lector.onloadend = function(e) {
                        var origen, tipo_img;
            
                        //Envia la imagen a la pantalla
                        origen = e.target; //objeto FileReader
                        
                        
                        //Prepara la información sobre la imagen
                        tipo_img = obtenertipo_movMIME(origen.result.substring(0, 30));
            
                        
                        //sino muestra un mensaje 
                        if (tipo_img !== 'image/jpeg' && tipo_img !== 'image/png' && tipo_img !== 'image/gif') {

                            $('#div_img').html('');
                            mandarMensaje('El formato de imagen no es válido: debe seleccionar una imagen JPG, PNG o GIF.');
                        }else {
                            imagen='si';
                            
                            $('#div_img').html('');
                            var cont_img='<img id="vistaPrevia_1" src="'+origen.result+'" alt="">';
                            $('#div_img').append(cont_img);
                        }
            
                    };
                    
                    Lector.readAsDataURL(Archivos[0]);
            
                } else {
                    var objeto = $('#i_firma');
                    objeto.replaceWith(objeto.val('').clone());
                    $('#div_img').html('');
                };
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $("#i_nombre_excel").val('Registros Firmantes');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('FIRMANTES');
            
            $("#f_imprimir_excel").submit();
        });

        $('#b_asignar_suc').click(function(){
            $('#dialog_asignar_sucursales_firmantes').modal('show');
        });

        $('#b_buscar_firmantes').click(function(){

            $('#i_filtro_firmantes').val('');
            $('.renglon_firmantes_asigna').remove();
   
            $.ajax({
                type: 'POST',
                url: 'php/firmantes_buscar.php',
                dataType:"json", 
                data:{'estatus':0}, //solo los activos
                success: function(data) {
                  
                   if(data.length != 0){

                        $('.renglon_firmantes_asigna').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_firmantes_asigna" alt="'+data[i].id+'" alt2="'+data[i].nombre+'">\
                                        <td data-label="Nombre">' + data[i].nombre+ '</td>\
                                        <td data-label="Iniciales">' + data[i].iniciales+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_firmantes_asigna tbody').append(html);   
                            $('#dialog_buscar_firmantes_asigna').modal('show');   
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

        
        $('#t_firmantes_asigna').on('click', '.renglon_firmantes_asigna', function() {
        
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_firmante').attr('alt',id).val(nombre);

            buscarSucursalesDisponibles($('#s_id_unidades').val(),id);
            buscarSucursalesAgregadas(id);
            $('#s_id_unidades').prop('disabled',false);
            $('#dialog_buscar_firmantes_asigna').modal('hide');

        });

        function buscarSucursalesDisponibles(idUnidadS,idFirmanteS){
            $.ajax({
                type: 'POST',
                url: 'php/firmantes_buscar_sucursales_disponibles.php',
                dataType:"json", 
                data:{
                    'idUnidadNegocio':idUnidadS,
                    'idFirmante':idFirmanteS
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
                        //mandarMensaje('No se encontró información');
                        $('#ch_agregar').prop('disabled',true);
                    }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        function buscarSucursalesAgregadas(idFirmanteS){
            $.ajax({

                type: 'POST',
                url: 'php/firmantes_buscar_sucursales_agregadas.php',
                dataType:"json", 
                data:{
                    'idFirmante':idFirmanteS
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
                        //mandarMensaje('No se encontró información');
                        $('#ch_quitar').prop('disabled',true);
                   }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_sucursales_disponibles').on('dblclick', '.renglon_disponible', function() {
            var renglon=$(this);
             
            $.ajax({

                type: 'POST',
                url: 'php/firmantes_agregar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregarUno(renglon)},

                success: function(data) {
                   if(data==1){
                        renglon.remove();
                        buscarSucursalesAgregadas($('#i_firmante').attr('alt'));
                        mandarMensaje('El registro se agregó correctamente.')
                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso.');
                   }

                },
                error: function (xhr) {
                    console.log(xhr.responseText);
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
                   'idFirmante' : $('#i_firmante').attr('alt')
                }
                paquete.push(paq);
              
            return paquete;
        }  

        $('#t_sucursales_agregadas').on('dblclick', '.renglon_agregado', function() {
            var renglon=$(this);
            $.ajax({

                type: 'POST',
                url: 'php/firmantes_quitar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitarUno(renglon)},

                success: function(data) {
    
                   if(data==1){
                        renglon.remove();
                        buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_firmante').attr('alt'));
                        mandarMensaje('El registro se quitó correctamente');

                   }else{

                        mandarMensaje('Ocurrio un error durante el proceso');
                   }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
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
                url: 'php/firmantes_quitar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosQuitar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_agregado').remove();
                        buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_firmante').attr('alt'));
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
                url: 'php/firmantes_agregar_sucursales.php',
                dataType:"json", 
                data:{'datos':obtenerDatosAgregar()},

                success: function(data) {
    
                   if(data==1){
                        $('.renglon_disponible').remove();
                        buscarSucursalesAgregadas($('#i_firmante').attr('alt'));
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
                   'idFirmante' : $('#i_firmante').attr('alt')
                
                };
            });
            
            datos[0] = j;

            return datos;
        }  

        $(document).on('change','#s_id_unidades',function(){
           
            if($('#s_id_unidades').val()!= ''){
              
                buscarSucursalesDisponibles($('#s_id_unidades').val(),$('#i_firmante').attr('alt'));
            }
        });

    });

</script>

</html>