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
                        <div class="titulo_ban">Tipos Ingresos</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-2"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="i_descripcion" class="col-sm-2 col-md-2 col-form-label">Descripción</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_descripcion">
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_agregar"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_inactivo" class="col-sm-2 col-md-2 col-form-label">Inactivo</label>
                                <div class="col-sm-10 col-md-2"><br>
                                    <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                </div>
                            </div>
                            
                        </form>

                    </div>
                    <br>
                    <div class="row">
                            <div class="col-sm-2 col-md-2"></div>
                            <div class="col-sm-8 col-md-8">
                                <table class="tablon"  id="t_tipos_ingresos">
                                <thead>
                                    <tr class="renglon">
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                </table>  
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
               
        

            
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var idTipoIngreso=0;
    var descripcionOriginal='';
    var tipoMov=0;
    var modulo='FINANZAS_BANCOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){

        mostrarBotonAyuda(modulo);

        $('#ch_inactivo').prop('checked',true).prop('disabled',true);  

        buscaTiposIngresosActual();

        function buscaTiposIngresosActual(){

            $('#forma').validationEngine('hide');
            $('.renglon_tipos_ingresos').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/tipos_ingresos_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_tipos_ingresos').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activo';
                            }

                            var html='<tr class="renglon_tipos_ingresos" alt="'+data[i].id+'" alt2="' + data[i].descripcion+ '" alt3="'+data[i].inactivo+'">\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_tipos_ingresos tbody').append(html);   
                           
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/tipos_ingresos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información');
                }
            });
        }

        $('#t_tipos_ingresos').on('dblclick', '.renglon_tipos_ingresos', function() {
            
            tipoMov = 1;
            $('#b_agregar').prop('disabled',false);
            $('#ch_inactivo').prop('disabled', false);
            idTipoIngreso = $(this).attr('alt');
            
            var descripcion = $(this).attr('alt2');
            descripcionOriginal=descripcion;
            var estatus=$(this).attr('alt3');
            $('#i_descripcion').val(descripcion);
            if (estatus == 0) {
                $('#ch_inactivo').prop('checked', false);
            } else {
                $('#ch_inactivo').prop('checked', true);
            }

            $(this).remove();

        });



        function muestraRegistro(){ 
          
            $.ajax({
                type: 'POST',
                url: 'php/tipos_ingresos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idTipoIngreso':idTipoIngreso
                },
                success: function(data) {
                   
                    idTipoIngreso=data[0].id;
                    descripcionOriginal=data[0].descripcion;
                    $('#i_id_tipo_ingreso').val(idTipoIngreso);
                    $('#i_descripcion').val(data[0].descripcion);
                
                    if (data[0].inactivo == 0) {
                        $('#ch_inactivo').prop('checked', false);
                    } else {
                        $('#ch_inactivo').prop('checked', true);
                    }
                   
                },
                error: function (xhr) {
                    console.log('php/tipos_ingresos_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información');
                }
            });
        }

        $('#b_agregar').click(function(){
          
           $('#b_agregar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                
                verificar();

            }else{
               
                $('#b_agregar').prop('disabled',false);
            }
        });


        function verificar(){

            $.ajax({
                type: 'POST',
                url: 'php/tipos_ingresos_verificar.php',
                dataType:"json", 
                data:  {'descripcion':$('#i_descripcion').val()},
                success: function(data) 
                {
                    if(data == 1){
                      
                        if (tipoMov == 1 && descripcionOriginal == $('#i_descripcion').val()) {
                            guardar();
                        } else {

                            mandarMensaje('El tipo de ingreso : '+ $('#i_descripcion').val()+' ya existe intenta con otro tipo');
                            $('#i_descripcion').val('');
                            $('#b_agregar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    console.log('php/tipos_ingresos_verificar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al verifcar la descripción');
                    $('#b_agregar').prop('disabled',false);
                  
                }
            });
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

         $.ajax({
                type: 'POST',
                url: 'php/tipos_ingresos_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                  
                    if (data > 0 ) {
                        if (tipoMov == 0){
                            
                            mandarMensaje('Se guardó el nuevo registro');
                            $('#b_nuevo').click();
    
                        }else{
                                
                            mandarMensaje('Se actualizó el registro');
                            $('#b_nuevo').click();
                               
                        }
                      

                    }else{
                           
                        mandarMensaje('Error en el guardado');
                        $('#b_agregar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('php/tipos_ingresos_guardar.php-->'+JSON.stringify(xhr));
                    mandarMensaje("Ha ocurrido un error durante el guardado");
                    $('#b_agregar').prop('disabled',false);
                }
            });
           
        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var paq = {
                    'tipoMov' : tipoMov,
                    'idTipoIngreso' : idTipoIngreso,
                    'descripcion' : $('#i_descripcion').val(),
                    'inactivo' : $("#ch_inactivo").is(':checked') ? 1 : 0
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
        

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idTipoIngreso=0;
            descripcionOriginal='';
            tipoMov=0;
            $('input').val('');
            $('form').validationEngine('hide');
            $('#b_agregar').prop('disabled',false);
            $('#ch_inactivo').prop('checked',true).prop('disabled',true);
            buscaTiposIngresosActual();
        }
    });

</script>

</html>