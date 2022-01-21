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
                        <div class="titulo_ban">Unidades de Negocio</div>
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
                                <label for="i_clave" class="col-sm-2 col-md-2 col-form-label requerido">Clave </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control validate[required,custom[onlyLetterNumberGb], minSize[3],maxSize[3]]" id="i_clave">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_nombre" class="col-sm-2 col-md-2 col-form-label requerido">Nombre</label>
                                <div class="col-sm-12 col-md-5">
                                    <input type="text" class="form-control validate[required,custom[onlyLetterNumberSp]]" id="i_nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_descripcion" class="col-sm-2 col-md-2 col-form-label requerido">Descripción</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_descripcion">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_logo" class="col-sm-2 col-md-2 col-form-label">Logo</label>
                                <div class="col-sm-12 col-md-5">
                                    <input type="file" class="form-control validate[required]" id="i_logo">
                                </div>
                                <div class="col-sm-12 col-md-5" id="div_img">
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

                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_UNIDADES_NEGOCIO" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
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

<div id="dialog_buscar_unidades_negocio" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Unidades de Negocio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_unidad" id="i_filtro_unidad" class="form-control filtrar_renglones" alt="renglon_unidades_negocio" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_unidades_negocio">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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

<script>
  
    var idUnidadesNegocio=0;
    var claveOriginal='';
    var tipo_mov=0;
    var modulo='UNIDADES_NEGOCIO';
    var imagenVacia = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
    var nombreAnteriorImg='';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);
       
        $('#div_img').empty();

        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_unidad').val('');
            $('.renglon_unidades_negocio').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/unidades_negocio_buscar.php',
                dataType:"json", 
                data:{'id':''},

                success: function(data) {
                  
                   if(data.length != 0){

                        $('.renglon_unidades_negocio').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].inactivo) == 0){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_unidades_negocio" alt="'+data[i].id+'">\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Nombre">' + data[i].nombre+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_unidades_negocio tbody').append(html);   
                            $('#dialog_buscar_unidades_negocio').modal('show');   
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

        $('#t_unidades_negocio').on('click', '.renglon_unidades_negocio', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            idUnidadesNegocio = $(this).attr('alt');
            $('#dialog_buscar_unidades_negocio').modal('hide');
            muestraRegistro();


        });

        function muestraRegistro(){ 
           
            $('#div_img').html('');
            $.ajax({
                type: 'POST',
                url: 'php/unidades_negocio_buscar.php',
                dataType:"json", 
                data:{
                    'idUnidadesNegocio':idUnidadesNegocio
                },
                success: function(data) {
                  
                    claveOriginal=data[0].clave;
                    $('#i_nombre').val(data[0].nombre);
                    $('#i_clave').val(data[0].clave);
                    $('#i_descripcion').val(data[0].descripcion);

                    if (data[0].inactivo == 0) {
                        $('#ch_inactivo').prop('checked', false);
                    } else {
                        $('#ch_inactivo').prop('checked', true);
                    }
                   
                    nombreAnteriorImg=data[0].logo;

                    $('#i_logo').removeAttr('class');

                    if(nombreAnteriorImg!=''){
                        $('#i_logo').addClass('form-control');
                    }else{
                        $('#i_logo').addClass('form-control validate[required]');
                    }
                   
                    var cont_img='<img id="vistaPrevia_1" src="imagenes/'+data[0].logo+'" alt="" height="50%;" style="border: 1px solid rgb(214, 214, 194); background-color: #fff; max-height: 55px; min-height: 55px;">';
                    $('#div_img').append(cont_img);
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
                url: 'php/unidades_negocio_verificar.php',
                dataType:"json", 
                data:  {'clave':$('#i_clave').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipo_mov == 1 && claveOriginal === $('#i_clave').val()) {
                            guardar();
                        } else {

                            mandarMensaje('La clave: '+ $('#i_clave').val()+' ya existe intenta con otra');
                            $('#i_clave').val('');
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
          
            //Damos el valor del input tipo_mov file
            var archivos = document.getElementById("i_logo");

            //Obtenemos el valor del input (los archivos) en modo de arreglo
            var i_imagen = archivos.files; 

            var datos = new FormData();

            datos.append('tipo_mov',tipo_mov);
            datos.append('idUnidadesNegocio',idUnidadesNegocio);
            datos.append('nombreAnteriorImg',nombreAnteriorImg);
            datos.append('logo_1',i_imagen[0]);
            datos.append('clave',$('#i_clave').val());
            datos.append('nombre',$('#i_nombre').val());
            datos.append('descripcion',$('#i_descripcion').val());
            datos.append('inactivo',$("#ch_inactivo").is(':checked') ? 1 : 0);
            datos.append('elementos',$("#i_logo").val()!='' ? 1 : 0);

            var fichero = $('#i_logo').val();   
            var ext = fichero.split('.');
            ext = ext[ext.length -1];
            
            if(esImagen(ext)){  //valida la extension de la imagen
                $.ajax({
                    type: 'POST',
                    url: 'php/unidades_negocio_guardar.php',  
                    //dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: datos,
                    //mientras enviamos el archivo
                    //mensaje de que la imagen se esta subiendo
                    beforeSend: function(){
                     if($("#i_logo").val()!=''){ 
                        message ="Subiendo la imagen, por favor espere...";
                        mandarMensaje(message);     
                     }else{
                        mandarMensaje("Generando registro, por favor espere...");
                     }   
                    },
                    //una vez finalizado correctamente
                    success: function(data){
                        console.log(data);
                        if (data > 0 && $("#i_logo").val() == '')
                        {

                            if (tipo_mov == 0)
                            {
                                mandarMensaje('Se guardó el nuevo registro');
                                $('#b_nuevo').click();
                            }
                            else
                            {
                                mandarMensaje('Se actualizó el registro');
                                $('#b_nuevo').click();
                            }

                        }
                        else if(data >0 && $("#i_logo").val() != '')
                        {
                            if (tipo_mov == 0)
                            {
                                 
                                mandarMensaje('Se guardó el registro.');
                                $('#b_nuevo').click();
                               
                            }
                            else
                            {
                               
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
            }else{
                mandarMensaje('Verifica la extensión de la imagen');
                $('#b_guardar').prop('disabled',false);
            }   
        }
        /* Muestra la vista previa si surge algun cambio en el campo logo*/
        $('#i_logo').change(function(){
            mostrarVistaPrevia('i_logo',1);  
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

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){

            $('input').val('');
            $('form').validationEngine('hide');
            $('#div_img').html('');
            $('#b_guardar').prop('disabled',false);
            $('#i_logo').removeAttr('class');
            $('#i_logo').addClass('form-control validate[required]');
            
            tipo_mov=0;
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
            
                Archivos = $('#i_logo')[0].files;
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
                            var cont_img='<img id="vistaPrevia_1" src="'+origen.result+'" alt="" height="50%;" style="border: 1px solid rgb(214, 214, 194); background-color: #fff; max-height: 55px; min-height: 55px;">';
                            $('#div_img').append(cont_img);
                        }
            
                    };
                    
                    Lector.readAsDataURL(Archivos[0]);
            
                } else {
                    var objeto = $('#i_logo');
                    objeto.replaceWith(objeto.val('').clone());
                    $('#div_img').html('');
                };
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Unidades de Negocio');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('UNIDADES_NEGOCIO');
            
            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>