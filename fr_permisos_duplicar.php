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
                        <div class="titulo_ban">Duplicar Permisos</div>
                    </div>
                </div>

                <br><br>
                
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-primary" id="b_duplicar_usuario_a_usuario">
                            Usuario a Usuario
                        </button>
                    </div>
                </div>
                <br>
            </div> <!--div_contenedor-->
            <br>
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
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_usuario" id="i_filtro_usuario" class="form-control filtrar_renglones" alt="renglon_usuarios" placeholder="Filtrar" autocomplete="off"></div>
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

<div id="dialog_usuario_a_usuario" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Usuario a Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <form action="#">
                        <div class="form-group">
                            <label for="i_usuario_origen">Usuario Origen</label>
                            <select class="form-control" id="i_usuario_origen">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="i_usuario_destino">Usuario Destino</label>
                            <select class="form-control" id="i_usuario_destino">

                            </select>
                        </div>
                    </form>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-sm" id="b_duplicar_permisos">Duplicar</button>
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

    $(function(){

        /*
            29 julio 2021
            se agregara funcion para duplicar permisos de usuario a usuario
        */

        let traerUsuarios = () => {
            $.ajax({

                type: 'POST',
                url: 'php/usuarios_buscar.php',
                dataType:"json", 
                data:{'estatus':'1'},

                success: function(data) {
                
                if(data.length != 0){

                        $('#i_usuario_origen, #i_usuario_destino').html("");
                
                        for(var i=0;data.length>i;i++){

                            // var html='<tr class="renglon_usuarios" alt="'+data[i].id_usuario+'" alt2="'+data[i].nombre_comp+'" alt3="' + data[i].usuario+ '" alt4="' + data[i].id_supervisor+ '">\
                            //             <td data-label="usuario">' + data[i].usuario+ '</td>\
                            //             <td data-label="Nombre">' + data[i].nombre_comp+ '</td>\
                            //             <td data-label="Estatus">' + activo+ '</td>\
                            //         </tr>';

                            var html='<option value="'+data[i].id_usuario+'">(' + data[i].usuario+ ') ' + data[i].nombre_comp+ '</option>';
                            ///agrega la tabla creada al div 
                            $('#i_usuario_origen, #i_usuario_destino').append(html);  
                        }
                        $('#i_usuario_origen, #i_usuario_destino').select2(
                            {dropdownParent: $("#dialog_usuario_a_usuario")}
                        );
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        let duplicarUsuarioUsuario = (origen, destino) => {
            $.ajax({

                type: 'POST',
                url: 'php/duplicar_permisos.php',
                dataType:"json", 
                data:{origen, destino},

                success: function(data) {

                if(data.length != 0){

                        if(data > 0){
                            mandarMensaje("Permisos duplicados.");
                        }else{
                            mandarMensaje("Permisos no duplicados.");
                        }
                }else{

                        mandarMensaje('No se duplicaron los permisos');
                }

                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        traerUsuarios();

        $("#b_duplicar_usuario_a_usuario").on("click",()=>{
            $("#dialog_usuario_a_usuario").modal("toggle");
        });

        $("#b_duplicar_permisos").on("click",()=>{
            let origen = $("#i_usuario_origen").val();
            let destino = $("#i_usuario_destino").val();

            if(origen != 0){
                if(destino != 0){
                    if(origen != destino){
                        duplicarUsuarioUsuario(origen, destino);
                    }else{
                        mandarMensaje("Usuarios no pueden estar iguales");
                    }
                }else{
                    ("#i_usuario_destino").addClass("is-invalid");
                }
            }else{
                ("#i_usuario_origen").addClass("is-invalid");
            }
        });

    });

</script>

</html>