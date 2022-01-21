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
                        <div class="titulo_ban">Familias</div>
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
                                <label for="i_id_familia" class="col-sm-2 col-md-2 col-form-label">ID </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control"  id="i_id_familia" autocomplete="off" disabled="disabled">
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
                                <label for="s_id_familia_gastos" class="col-sm-12 col-md-2 col-form-label requerido">Familia de Gastos</label>
                                <div class="col-sm-12 col-md-5">
                                <select id="s_id_familia_gastos" name="s_id_familia_gastos" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-2">
                                   Gasto <input type="radio" name="radio_tipo" id="r_gasto" value="1"> 
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    Stock <input type="radio" name="radio_tipo" id="r_stock" value="3"> 
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    Mantenimiento <input type="radio" name="radio_tipo" id="r_mantenimiento" value="2"> 
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    Activo Fijo <input type="radio" name="radio_tipo" id="r_activo_fijo" value="0"> 
                                </div>
                            </div>

                            <div class="form-group row" >
                                <label for="ch_tallas" class="col-sm-2 col-md-2 col-form-label">Maneja Tallas</label>
                                <div class="col-sm-10 col-md-2" ><br>
                                    <input type="checkbox" id="ch_tallas" name="ch_tallas" value="">
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
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_FAMILIAS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
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
                          <th scope="col">Familia Gasto</th>
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
  
    var idFamilia=0;
    var familiaOriginal='';
    var tipo_mov=0;
    var modulo='FAMILIAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        muestraSelectFamiliaGastos('s_id_familia_gastos');

        $('#ch_inactiva').prop('checked',false).prop('disabled',true); 
        $('#r_gasto').prop('checked',true); 
        $('#ch_tallas').prop('disabled',true); 

        $('input[name=radio_tipo]').on('click', function(){
           
            if( $('#r_stock').is(':checked')==true){

                $('#ch_tallas').prop('disabled',false); 

            }else{
                
                $('#ch_tallas').prop('checked',false).prop('disabled',true);  
            }

        });


        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_familias').val('');
            $('.renglon_familias').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/familias_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

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

                            var html='<tr class="renglon_familias" alt="'+data[i].id+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Tallas">' + data[i].tallas+ '</td>\
                                        <td data-label="Tipo">' + data[i].tipo+ '</td>\
                                        <td data-label="Estatus">' + inactiva+ '</td>\
                                        <td data-label="Familia Gasto">' + data[i].familia_gasto+ '</td>\
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
                    
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_familias').on('click', '.renglon_familias', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactiva').prop('disabled', false);
            idFamilia = $(this).attr('alt');
             
            $('#dialog_buscar_familias').modal('hide');
            muestraRegistro();


        });



        function muestraRegistro(){ 
          
            $.ajax({
                type: 'POST',
                url: 'php/familias_buscar_id.php',
                dataType:"json", 
                data:{
                    'idFamilia':idFamilia
                },
                success: function(data) {
                   
                    idFamilia=data[0].id;
                    familiaOriginal=data[0].clave;
                    $('#i_id_familia').val(idFamilia);
                    $('#i_clave').val(data[0].clave);
                    $('#i_descripcion').val(data[0].descripcion);
                    $('#ch_tallas').prop('disabled',true); 
                    //0 = Activos Fijos, 1 = Gasto, 2 = Mantenimiento, 3 = Stock
                    if(data[0].tipo == 1){
                        $('#r_gasto').prop('checked',true);
                    }else if(data[0].tipo == 3){    
                        $('#r_stock').prop('checked',true);
                        $('#ch_tallas').prop('disabled',false); 
                    }else if(data[0].tipo == 2){
                        $('#r_mantenimiento').prop('checked',true);   
                    }else{
                        $('#r_activo_fijo').prop('checked',true);
                    }

                    if (data[0].tallas == 0) {
                        $('#ch_tallas').prop('checked', false);
                    } else {
                        $('#ch_tallas').prop('checked', true);
                    }
                
                    if (data[0].inactiva == 0) {
                        $('#ch_inactiva').prop('checked', false);
                    } else {
                        $('#ch_inactiva').prop('checked', true);
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
                    console.log('php/familias_buscar_id.php --> '+JSON.stringify(xhr));
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
                url: 'php/familias_verificar.php',
                dataType:"json", 
                data:  {'clave':$('#i_clave').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipo_mov == 1 && familiaOriginal === $('#i_clave').val()) {
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
                    console.log('php/familias_verificar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el Sistema');
                }
            });
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

         $.ajax({
                type: 'POST',
                url: 'php/familias_guardar.php', 
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
                   
                    console.log('php/familias_guardar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el Sistema');
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
                    'idFamilia' : idFamilia,
                    'clave' : $('#i_clave').val(),
                    'descripcion' : $('#i_descripcion').val(),
                    'tipo':$('input[name=radio_tipo]:checked').val(),
                    'tallas' : $("#ch_tallas").is(':checked') ? 1 : 0,
                    'inactiva' : $("#ch_inactiva").is(':checked') ? 1 : 0,
                    'id_familia_gasto' : $('#s_id_familia_gastos').val()
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
        

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idFamilia=0;
            familiaOriginal='';
            tipo_mov=0;
            $('input').not('input:radio').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_tallas').prop('checked',false);
            $('#ch_inactiva').prop('checked',false).prop('disabled',true);
            $('#r_gasto').prop('checked',true);

            muestraSelectFamiliaGastos('s_id_familia_gastos');
                     
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Familias');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('FAMILIAS');
            
            $("#f_imprimir_excel").submit();
        });
       

    });

</script>

</html>