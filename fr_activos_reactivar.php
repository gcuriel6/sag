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
    #fondo_cargando
    {
        position: absolute;
        top: 1%;
        background-image:url('imagenes/3.svg');
        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:3%;
        border-radius: 5px;
        z-index:2000;
        display:none;
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
                        <div class="titulo_ban">Reactivar Activos</div>
                    </div>
                </div>
                <br>    
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <input type="text" name="i_filtro_buscar" id="i_filtro_buscar" class="form-control filtrar_renglones" alt="renglon_reactivar" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>
                
                <br>
                <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_reactivar">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">No. Económico</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Tipo</th>
                          <th scope="col">Estatus</th>
                          <th scope="col">Activar</th>
                          <th scope="col">Rechazar</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>

                </div>
                <br>

            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="fondo_cargando"></div>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>

    var modulo='REACTIVAR_ACTIVO';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idsUnidades=',<?php echo $_SESSION['unidades']?>';//--MGFS SE AGREGA UNA , PARA QUE IDENTIFIQUE LAS UNIDADDES
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){
   
        mostrarBotonAyuda(modulo);

        buscarInformacion();

        function buscarInformacion(){
            $('#fondo_cargando').show();
            $('#forma').validationEngine('hide');
            $('#i_filtro_buscar').val('');
            $('.renglon_reactivar').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/activos_reactivar_buscar.php',
                dataType:"json", 
                success: function(data) {
                 
                   console.log('Resultado:'+data);
                   if(data.length != 0){

                        $('.renglon_reactivar').remove();
                   
                        for(var i=0;data.length>i;i++){

                            var i_autorizar='<input type="radio" id="r_reactivar" name="r_reactivar" alt="'+data[i].id+'">';
                            var i_rechazar='<input type="radio" id="r_rechazar" name="r_rechazar" alt="'+data[i].id+'">';
                            
                            var html='<tr class="renglon_reactivar">\
                                        <td data-label="No. Económico">' + data[i].num_economico+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Tipo">' + data[i].tipo+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                        <td data-label="Activar">' + i_autorizar+ '</td>\
                                        <td data-label="Rechazar">' + i_rechazar+ '</td>\
                                    </tr>';
                            
                            $('#t_reactivar tbody').append(html);   
                        }

                        $('#fondo_cargando').hide();

                    }else{
                        $('#fondo_cargando').hide();
                        var html = '<tr class="renglon_reactivar"><td colspan="7">No se encontró información</td></tr>';
                        $('#t_reactivar tbody').append(html);  
                    }

                },
                error: function (xhr) {
                    $('#fondo_cargando').hide();
                    console.log('activos_reactivar_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar activos para reactivar');
                }
            });
        }
          
        $(document).on('change','#r_reactivar',function(){
            $('#fondo_cargando').show();
            var id=$(this).attr('alt');

            aprobarReactivar(id,$(this));
            
        });

        $(document).on('change','#r_rechazar',function(){
            $('#fondo_cargando').show();
            var id=$(this).attr('alt');

            rechazarReactivar(id,$(this));
            
        });

        function aprobarReactivar(id,input){
            $.ajax({
                type: 'POST',
                url: 'php/activos_aprobar_reactivar.php',
                //dataType:"json", 
                data:{
                    'id': id
                },
                success: function(data)
                {
                    if(data > 0)
                    {
                        $('#fondo_cargando').hide();
                        mandarMensaje('Existo al reactivar');
                        buscarInformacion();
                    }else{
                        $('#fondo_cargando').hide();
                        mandarMensaje('Error al aprobar reactivación de activo');
                        input.prop('checked',false);
                    }
                },
                error: function (xhr)
                {
                    $('#fondo_cargando').hide();
                    console.log('php/activos_aprobar_reactivar.php-->'+xhr.responseText);
                    mandarMensaje('*Error al aprobar reactivación de activo');
                    input.prop('checked',false);
                }
            });
        }

        function rechazarReactivar(id,input){
            $.ajax({
                type: 'POST',
                url: 'php/activos_rechazar_reactivar.php',
                //dataType:"json", 
                data:{
                    'id': id
                },
                success: function(data)
                {
                    if(data > 0)
                    {
                        $('#fondo_cargando').hide();
                        mandarMensaje('Se rechazo la activación del activo');
                        buscarInformacion();
                    }else{
                        $('#fondo_cargando').hide();
                        mandarMensaje('Error al rechazar reactivación de activo');
                        input.prop('checked',false);
                    }
                },
                error: function (xhr)
                {
                    $('#fondo_cargando').hide();
                    console.log('php/activos_rechazar_reactivar.php-->'+xhr.responseText);
                    mandarMensaje('*Error al rechazar reactivación de activo');
                    input.prop('checked',false);
                }
            });
        }
    
    });

</script>

</html>