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
            <div class="col-md-2"></div>
            <div class="col-md-offset-1 col-md-8" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <div class="titulo_ban">Correos para Notificación de cambios en Portal Proveedores </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                       
                    </div>
                    <div class="col-sm-12 col-md-2">
                        
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
                                <label for="ta_correos" class="col-sm-2 col-md-2 col-form-label">Correos</label>
                                <div class="col-sm-10 col-md-10">
                                    <textarea id="ta_correos" name="ta_correos" rows="3" class="form-control validate[required,custom[multiEmail]]" placeholder="Ingrese correo(s) electrónico(s)"></textarea>
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var id=1;
    var modulo = 'CORREOS_PROVEEDORES_CAMBIOS';
    $(function(){

        mostrarBotonAyuda(modulo);

        buscarCorreos();
       
        function buscarCorreos(){    
            $('#ta_correos').val('');
            $.ajax({

                type: 'POST',
                url: 'php/correos_buscar.php',
                data:{'estatus':2},

                success: function(data) {
                   
                   if(data!= ''){

                    $('#ta_correos').val(data);  

                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/correos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
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
                url: 'php/correos_guardar.php', 
                dataType:"json", 
                data: {
                       'correos':$('#ta_correos').val()
                },
                //una vez finalizado correctamente
                success: function(data){
                  
                    if (data > 0 ) {
                        
                        mandarMensaje('Los correos se actualizaron correctamente');
                        $('#b_guardar').prop('disabled',false);
                        buscarCorreos();

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
       
       
    });

</script>

</html>