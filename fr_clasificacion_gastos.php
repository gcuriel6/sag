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
                        <div class="titulo_ban">Clasificación de Gasto</div>
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
                                <label for="i_id_clasificacion" class="col-sm-2 col-md-2 col-form-label">ID </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control"  id="i_id_clasificacion" autocomplete="off" disabled="disabled">
                                </div>
                            </div>
                           <div class="form-group row">
                                <label for="i_clave" class="col-sm-2 col-md-2 col-form-label requerido">Clave </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control validate[required,custom[onlyLetterNumberGb]]" id="i_clave" maxlength="8" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row"> 
                                <label for="i_descripcion" class="col-sm-2 col-md-2 col-form-label requerido">Descripción</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_descripcion" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="s_id_familia_gastos" class="col-sm-12 col-md-2 col-form-label requerido">Familia de gatos</label>
                                <div class="col-sm-12 col-md-5">
                                <select id="s_id_familia_gastos" name="s_id_familia_gastos" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_inactiva" class="col-sm-2 col-md-2 col-form-label">Inactiva</label>
                                <div class="col-sm-10 col-md-2"><br>
                                    <input type="checkbox" id="ch_inactiva" name="ch_inactiva" value="">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_CLASIFICACION_GASTOS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
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

<div id="dialog_buscar_clasificacion_gasto" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Clasificación de Gasto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_clasificacion_gasto" id="i_filtro_clasificacion_gasto" class="form-control filtrar_renglones" alt="renglon_clasificacion_gasto" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_clasificacion_gasto">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Clave</th>
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
  
    var idClasificacionGasto=0;
    var clasificacionOriginal='';
    var tipo_mov=0;
    var modulo='CLASIFICACION_GASTOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectFamiliaGastos('s_id_familia_gastos');

       // muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#ch_inactiva').prop('checked',false).prop('disabled',true); 
      
        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_clasificacion_gasto').val('');
            $('.renglon_clasificacion_gasto').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/clasificacion_gasto_buscar.php',
                dataType:"json", 
                data:{'estatus':2}, //0=activos 1=inactivos 2=todos
                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_clasificacion_gasto').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactiva='';
                            
                            if(parseInt(data[i].activo) == 1){

                                inactiva='Inactiva';
                            }else{
                                inactiva='Activa';
                            }

                            var html='<tr class="renglon_clasificacion_gasto" alt="'+data[i].id_clas+'">\
                                        <td data-label="ID">' + data[i].id_clas+ '</td>\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].descr+ '</td>\
                                        <td data-label="Estatus">' + inactiva+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_clasificacion_gasto tbody').append(html);   
                            $('#dialog_buscar_clasificacion_gasto').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/clasificacion_gasto_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar.');
                }
            });
        });

        $('#t_clasificacion_gasto').on('click', '.renglon_clasificacion_gasto', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactiva').prop('disabled', false);
            idClasificacionGasto = $(this).attr('alt');
             
            $('#dialog_buscar_clasificacion_gasto').modal('hide');
            muestraRegistro();

        });



        function muestraRegistro(){ 
          
            $.ajax({
                type: 'POST',
                url: 'php/clasificacion_gasto_buscar_id.php',
                dataType:"json", 
                data:{
                    'idClasificacionGasto':idClasificacionGasto
                },
                success: function(data) {
                   
                    idClasificacionGasto=data[0].id_clas;
                    clasificacionOriginal=data[0].clave;
                    $('#i_id_clasificacion').val(idClasificacionGasto);
                    $('#i_clave').val(data[0].clave);
                    $('#i_descripcion').val(data[0].descr);
                   
                    if (data[0].activo == 0) {
                        $('#ch_inactiva').prop('checked', false);
                    } else {
                        $('#ch_inactiva').prop('checked', true);
                    }

                    if(data[0].no_editar == 1)
                    {
                        $('#b_guardar').prop('disabled',true);
                    }else{
                        $('#b_guardar').prop('disabled',false);
                    }

                    if(data[0].id_familia_gasto != 0)
                    {
                        $('#s_id_familia_gastos').val(data[0].id_familia_gasto);
                        $('#s_id_familia_gastos').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_familia_gastos').val('');
                        $('#s_id_familia_gastos').select2({placeholder: 'Selecciona'});
                    }
                   
                },
                error: function (xhr) {
                    console.log('php/clasificacion_gasto_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar.');
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
                url: 'php/clasificacion_gasto_verificar.php',
                dataType:"json", 
                data:  {'clave':$('#i_clave').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipo_mov == 1 && clasificacionOriginal === $('#i_clave').val()) {
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
                    console.log('php/clasificacion_gasto_verificar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al verificar');
                }
            });
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

            var info = {
                'tipo_mov':tipo_mov,
                'idClasificacionGasto' : idClasificacionGasto,
                'clave' : $('#i_clave').val(),
                'descripcion' : $('#i_descripcion').val(),
                'idFamiliaGasto' : $('#s_id_familia_gastos').val(),
                'activo' : $("#ch_inactiva").is(':checked') ? 1 : 0
            };

         $.ajax({
                type: 'POST',
                url: 'php/clasificacion_gasto_guardar.php', 
                dataType:"json", 
                data: {
                    'datos':info
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
                        mandarMensaje('Error al guardar');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('php/clasificacion_gasto_guardar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al guardar');
                }
            });
           
        }
           
        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idClasificacionGasto=0;
            clasificacionOriginal='';
            tipo_mov=0;
            $('input').not('input:radio').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactiva').prop('checked',false).prop('disabled',true);    
            
            muestraSelectFamiliaGastos('s_id_familia_gastos');
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Clasificación de Gasto');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('CLASIFICACION_GASTOS');
            
            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>