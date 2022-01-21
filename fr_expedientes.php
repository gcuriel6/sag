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
    <link rel="stylesheet" type="text/css" href="css/jstree_themes/default/style.min.css" />
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
                        <div class="titulo_ban">Permisos a Expedientes</div>
                    </div>
                    <div class="col-sm-8 col-md-6"></div>
                    <div class="col-sm-2 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">  
                            
                            <div class="form-group row">
                                <label for="i_usuario" class="col-sm-3 col-md-3 col-form-label requerido">Usuario </label>
                                <!--NJES Feb/07/2020 se agrega boton a un input goup-->
                                <div class="input-group col-sm-12 col-md-5">
                                    <input type="text" id="i_usuario" name="i_usuario" placeholder="Usuario" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_usuarios" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                               <label for="s_id_sucursal" class="col-sm-3 col-md-3 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-5 col-md-5">
                                    <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            
                            <div class="form-group row">

                                <label class="radio-inline"><input type="radio" id="r_edicion" name='r_acceso' value="1" class="validate[required]"> Edición</label>
                                <div class="col-sm-12 col-md-3"></div>
                                <label class="radio-inline"><input type="radio" id="r_consulta" name='r_acceso' value="2" class="validate[required]"> Solo Consulta</label>
                                <div class="col-sm-12 col-md-3"></div>
                                <label class="radio-inline"><input type="radio" id="r_sin_acceso" name='r_acceso' value="3" class="validate[required]"> Sin Acceso</label>
                            </div>

                            <div class="form-group row">
                                <label class="radio-inline"><input type="radio" id="r_antidoping" name='r_estudios' value="1" class="validate[required]"> Antidoping</label>
                                <div class="col-sm-12 col-md-3"></div>
                                <label class="radio-inline"><input type="radio" id="r_cursos" name='r_estudios' value="2" class="validate[required]"> Cursos</label>
                                <div class="col-sm-12 col-md-3"></div>
                                <label class="radio-inline"><input type="radio" id="r_ambos" name='r_estudios' value="3" class="validate[required]"> Ambos</label>
                                <!--<div class="col-sm-12 col-md-2"></div>
                                <label class="radio-inline"><input type="radio" id="r_ninguno" name='r_estudios' value="0" class="validate[required]"> Ninguno</label>-->
                            </div>

                            <div class="form-group row">
                                <label for="ch_bajas" class="col-sm-3 col-md-3 col-form-label">Bajas  en Expedientes <input type="checkbox" id="ch_bajas" name="ch_bajas" value=""></label>
                            </div>

                            <div class="form-group row">
                               <label for="s_id_departamento" class="col-sm-3 col-md-3 col-form-label">Departamento </label>
                                <div class="col-sm-5 col-md-5">
                                    <select id="s_id_departamento" name="s_id_departamento" class="form-control" autocomplete="off"></select>
                                </div>
                                <div class="col-sm-1 col-md-1">
                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" id="b_agregar_departamento"><span class="fa fa-plus"></span> </button>
                                </div>
                                
                            </div>   
                        
                        </form>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-10 col-md-10">
                        <table class="tablon"  id="t_departamentos">
                            <thead>
                                <tr class="renglon" style="background-color: #fafafa;font-size: 14px;">
                                    <th scope="col" style="text-align: left;" colspan="2">Permiso solo para los siguientes departamentos </th>
                                </tr>
                                <tr class="renglon" style="background-color: #A3CED7;">
                                    <th scope="col">Clave</th>
                                    <th scope="col">Descripción</th>
                               </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> 
                        
                    </div>
                </div>
                <br>    
                <div class="row">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-10 col-md-10" style="background-color: #fafafa;font-size: 14";><label style="text-align: left;color:#D9534F">Sin departamentos aplica permisos a todos los de la sucursal</lable>
                                
                    </div>
                </div>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_usuarios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_usuarios" id="i_filtro_usuarios" class="form-control filtrar_renglones" alt="renglon_usuarios" placeholder="Filtrar" autocomplete="off"></div>
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
<script src="js/jstree.js"></script>

<script>

    var modulo='EXPEDIENTES_PERMISOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;

    var id = <?php echo $idUsuarioP?>;
    var nombre = '<?php echo $nombreUsuarioP?>';
    var usuario = '<?php echo $usuarioP?>';

    $(function(){

        mostrarBotonAyuda(modulo);
       
        $('#s_id_sucursal').prop('disabled',true);
        $('#s_id_departamento').prop('disabled',true);
        $('#r_sin_acceso').prop('checked',true);
        $('#r_ninguno').prop('checked',true);
     

        verificaUsuario();

        function verificaUsuario(){
            if(id>0){

                $('#i_usuario').attr('alt',id).attr('alt2',usuario).val(nombre);

                muestraSucursalesPermisoUsuario('s_id_sucursal',modulo,id);
                $('#s_id_sucursal').prop('disabled',false); 
            }
        }

        $('#b_buscar_usuarios').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_usuarios').val('');
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
         
            limpiarPantalla();
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var usuario = $(this).attr('alt2');
            $('#i_usuario').attr('alt',id).attr('alt2',usuario).val(nombre);
           
            muestraSucursalesPermisoUsuario('s_id_sucursal',modulo,id);
            $('#s_id_sucursal').prop('disabled',false);

            $('#dialog_buscar_usuarios').modal('hide');

        });

        $(document).on('change','#s_id_sucursal',function(){
            var idSucursal=$(this).val();
            muestraSelectDepartamentos('s_id_departamento',idSucursal);
            $('#s_id_departamento').prop('disabled',false);
            buscaInformacion(idSucursal,$('#i_usuario').attr('alt'));
            $('#r_sin_acceso').prop('checked',true);
            $('#r_ninguno').prop('checked',true);
        });

        function buscaInformacion(idSucursal,idUsuarioA){
         
            $.ajax({

                type: 'POST',
                url: 'php/expedientes_buscar.php',
                dataType:"json", 
                data:{'idSucursal':idSucursal, 'idUsuario':idUsuarioA},

                success: function(data) {
                   //console.log(JSON.stringify(data));
                   if(data.length != 0){

                        if(data[0].accesos==1){
                            $('#r_edicion').prop('checked',true);
                        }else if(data[0].accesos==2){
                            $('#r_consulta').prop('checked',true);
                        }else{
                            $('#r_sin_acceso').prop('checked',true);
                        }

                        if(data[0].estudios==1){
                            $('#r_antidoping').prop('checked',true);
                        }else if(data[0].estudios==2){
                            $('#r_cursos').prop('checked',true);
                        }else if(data[0].estudios==3){
                            $('#r_ambos').prop('checked',true);    
                        }else{
                            $('#r_ninguno').prop('checked',true);
                        }

                        //NJES Feb/07/2020 estaba cambiada la condicion
                       if(data[0].ver_bajas==1){
                            $('#ch_bajas').prop('checked',true);
                       }else{
                            $('#ch_bajas').prop('checked',false);
                       }

                       if(data[0].deptos!=''){
                            buscaDepartamentos(data[0].deptos);
                       }
                       
                   }else{
                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    //console.log(xhr.responseText);
                    mandarMensaje('Error en el sistema');
                }
            });

        }

        function buscaDepartamentos(idsDepartamento){
            $('.renglon_departamento').remove();
            $.ajax({

                type: 'POST',
                url: 'php/departamentos_buscar_lista_ids.php',
                dataType:"json", 
                data:{'idsDepartamento':idsDepartamento},

                success: function(data) {
                    console.log(data);
                    
                    for(var i=0;data.length>i;i++){

                        var html="<tr class='renglon_departamento dep_"+data[i].idDepartamento+"' alt='"+data[i].idDepartamento+"'>\
                        <td data-label='Clave'>"+data[i].clave+"</td>\
                        <td data-label='Descripción'>"+data[i].descripcion+"</td>\
                        </tr>";

                        $('#t_departamentos tbody').append(html);  
                    }

                },
                error: function (xhr) {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });    

        }

        $(document).on('click','#b_agregar_departamento',function(){


            var idDepartamento = $('#s_id_departamento').val();

            if(idDepartamento>0){
                var descripcion = $('select[name="s_id_departamento"] option:selected').text();
                var clave = $('select[name="s_id_departamento"] option:selected').attr('alt');
                
                if($('.dep_'+idDepartamento).length > 0 ){

                    mandarMensaje('Ese Departamento ya fue agregado');

                }else{

                    var html="<tr class='renglon_departamento dep_"+idDepartamento+"' alt='"+idDepartamento+"'>\
                    <td data-label='Clave'>"+clave+"</td>\
                    <td data-label='Descripción'>"+descripcion+"</td>\
                    </tr>";

                    $('#t_departamentos tbody').append(html);  
                } 
            }else{
                mandarMensaje('Debes selecionar un Departamento');
            }
        });

        $('#t_departamentos').on('dblclick', '.renglon_departamento', function() {
            $(this).remove();

        });


        function obtenerIdsDepartamentos(){

            var listaDepartamentos='';
            //-->NJES March/31/2021 si no agrega ningun departamento a la tabla
            //quiere decir que tiene acceso a todos los departamentos
            if($('.renglon_departamento').length > 0){
                $('.renglon_departamento').each(function(){

                    var idDepartamento=$(this).attr('alt');
                    listaDepartamentos+=idDepartamento+",";

                });
            }

            var Departamentos=listaDepartamentos.substring(0,listaDepartamentos.length -1);
            return Departamentos;
        } 


        $('#b_guardar').click(function(){
          
           $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                
                guardar();

            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });


        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

         $.ajax({
                type: 'POST',
                url: 'php/expedientes_guardar.php',
                data: {
                        'datos':obtenerDatos()
                },
                //una vez finalizado correctamente
                success: function(data){
                    //console.log(data);
                    if (data > 0 ) {

                        mandarMensaje('La información se guardó correctamente');
                        $('#b_nuevo').click();
                        $('#b_guardar').prop('disabled',false);
                               

                    }else{
                           
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('php/expedientes_guardar.php -->'+JSON.stringify(xhr));
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

                    'idUsuario' : $('#i_usuario').attr('alt'),
                    'idSucursal':$('#s_id_sucursal').val(),
                    'acceso' : $('input[name="r_acceso"]:checked').val(),
                    'estudios' : $('input[name="r_estudios"]:checked').val(),
                    'verBajas' : $("#ch_bajas").is(':checked') ? 1 : 0,
                    'idsDepartamentos' : obtenerIdsDepartamentos()
                    
                }
                paquete.push(paq);
              
            return paquete;
        }    

        function limpiarPantalla(){
           
            $('#i_usuario').val('').attr('alt',0).attr('alt2',''); 
            $('#s_id_sucursal').html('').val('');
            $('#s_id_sucursal').prop('disabled',true);
            $('#s_id_departamento').html('').val('').prop('disabled',true);  //-->NJES Feb/07/2020 se limpia bien el combo
            $('#r_sin_acceso').prop('checked',true);
            $('#r_ninguno').prop('checked',true);
            $('#ch_bajas').prop('checked',false);
            $('.renglon_departamento').remove();

        } 
        
    });

</script>

</html>