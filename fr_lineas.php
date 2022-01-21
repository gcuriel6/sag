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

    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Líneas</div>
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
                                <label for="i_id_linea" class="col-sm-2 col-md-2 col-form-label requerido">ID </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control"  id="i_id_linea" autocomplete="off" disabled="disabled">
                                </div>
                            </div>
                           <div class="form-group row">
                                <label for="i_clave" class="col-sm-2 col-md-2 col-form-label requerido">Clave </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control validate[required,custom[onlyLetterNumberGb]]" id="i_clave" maxlength="8">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_descripcion" class="col-sm-2 col-md-2 col-form-label requerido">Descripción</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_descripcion">
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="i_familia" class="col-2 col-md-2 col-form-label requerido">Familia </label><br>
                               
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                    
                                        <div class="input-group col-sm-12 col-md-9">
                                            <input type="text" id="i_familia" name="i_familia" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_familias" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_inactiva" class="col-sm-2 col-md-2 col-form-label">Inactiva</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox" id="ch_inactiva" name="ch_inactiva" value="">
                                </div>
                            </div>
                            
                        </form>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_LINEAS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
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

<div id="dialog_buscar_lineas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Líneas</h5>
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var idLinea=0;
    var lineaOriginal='';
    var tipo_mov=0;
    var modulo='LINEAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#ch_inactiva').prop('checked',false).prop('disabled',true);  

        //************Solo muestra las familias activas */
        $('#b_buscar_familias').on('click',function(){
            
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
                            var inactiva='';
                            
                            if(parseInt(data[i].inactiva) == 1){

                                inactiva='Inactiva';
                            }else{
                                inactiva='Activa';
                            }

                            var html='<tr class="renglon_familias" alt="'+data[i].id+'" alt2="'+data[i].descripcion+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Tallas">' + data[i].tallas+ '</td>\
                                        <td data-label="Tipo">' + data[i].tipo+ '</td>\
                                        <td data-label="Estatus">' + inactiva+ '</td>\
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
        });

            $('#t_familias').on('click', '.renglon_familias', function() {

                var  idFamilia = $(this).attr('alt');
                var  familia = $(this).attr('alt2');

                $('#i_familia').attr('alt',idFamilia).val(familia);
                $('#dialog_buscar_familias').modal('hide');

            });



        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_lineas').val('');
            $('.renglon_lineas').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/lineas_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

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

                            var html='<tr class="renglon_lineas" alt="'+data[i].id+'">\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Descripción">' + data[i].familia+ '</td>\
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
        });

        $('#t_lineas').on('click', '.renglon_lineas', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactiva').prop('disabled', false);
            idLinea = $(this).attr('alt');
           
            $('#dialog_buscar_lineas').modal('hide');
            muestraRegistro();


        });



        function muestraRegistro(){ 
          
            $.ajax({
                type: 'POST',
                url: 'php/lineas_buscar_id.php',
                dataType:"json", 
                data:{
                    'idLinea':idLinea
                },
                success: function(data) {
                   
                    idLinea=data[0].id;
                    lineaOriginal=data[0].clave;
                    $('#i_clave').val(data[0].clave);
                    $('#i_id_linea').val(idLinea);
                    $('#i_descripcion').val(data[0].descripcion);
                    $('#i_familia').val(data[0].familia).attr('alt',data[0].id_familia);
                    
                    if (data[0].inactiva == 0) {
                        $('#ch_inactiva').prop('checked', false);
                    } else {
                        $('#ch_inactiva').prop('checked', true);
                    }
                   
                },
                error: function (xhr) {
                    console.log('php/lineas_buscar_id.php-->'+JSON.stringify(xhr));
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
                url: 'php/lineas_verificar.php',
                dataType:"json", 
                data:  {'clave':$('#i_clave').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipo_mov == 1 && lineaOriginal === $('#i_clave').val()) {
                            guardar();
                        } else {

                            mandarMensaje('La clave : '+ $('#i_clave').val()+' ya existe intenta con otra');
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

         $.ajax({
                type: 'POST',
                url: 'php/lineas_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

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
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var paq = {
                    'tipo_mov' : tipo_mov,
                    'idLinea' : idLinea,
                    'clave' : $('#i_clave').val(),
                    'descripcion' : $('#i_descripcion').val(),
                    'inactiva' : $("#ch_inactiva").is(':checked') ? 1 : 0,
                    'idFamilia':$('#i_familia').attr('alt')
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
        

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idLinea=0;
            lineaOriginal='';
            tipo_mov=0;
            $('input').val('');
            $('#i_familia').attr('alt',0);
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactiva').prop('checked',false).prop('disabled',true);
            
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Lineas');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('LINEAS');
            
            $("#f_imprimir_excel").submit();
        });
       

    });

</script>

</html>