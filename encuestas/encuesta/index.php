<?php
$id=0;
$termino=0;
if(isset($_GET['id'])!=0){
    $id=$_GET['id'];
}

if(isset($_GET['termino'])=='si'){
    $termino=1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Encuestas Alarmas</title>
    <!-- Hojas de estilo -->
    <link href="../css/css/bootstrap.css" rel="stylesheet"  type="text/css" media="all">
    <link href="../css/validationEngine.jquery.css" rel="stylesheet" />
    <link href="../css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <link href="../css/general.css" rel="stylesheet"  type="text/css"/>
    <link href="../vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="../vendor/select2/css/select2.css" rel="stylesheet"/>
</head>

<style>


    #fondo_cargando {
            position: absolute;
            top: 1%;
            background-image:url('../imagenes/5.svg');

            background-repeat:no-repeat;
            background-size: 500px 500px; 
            background-position:center;
            /*background-color:#000;*/
            left: 1%;
            width: 98%;
            bottom:3%;
            /*border: 2px solid #6495ed;*/
            /*opacity: .1;*/
            /*filter:Alpha(opacity=10);*/
            border-radius: 5px;
            z-index:2;
            display:none;
        }

        .btn-circle {
          width: 200px;
          height: 200px;
          padding: 10px 16px;
          font-size: 24px;
          line-height: 1.33;
          border-radius: 145px;

        }



    body{
        margin:auto;
        background-image: url('../imagenes/fondo_login.jpg');
        background-color:#ffffff;
        background-size:cover;
        background-repeat: no-repeat;
        overflow:auto;
    }
    #div_principal{
        position: absolute;
        top:0px;
        padding-top:3%;
        left:0px;
        height: 100%;
        left : -101%;
        background-color:rgba(250,250,250,0.6);
    }
   
    #div_encuestas{
        position: absolute;
        top:0px;
        height: 100%;
        left : -101%;
        background-color:rgba(250,250,250,0.6);
    }
    #div_cerrar{
        position: absolute;
        top:0px;
        height: 100%;
        left : -201%;
        background-color:rgba(250,250,250,0.6);
    }
    
    .div_contenedor{
        position:relative;
        top:20%;
        background-color: #ffffff;
        height:500px;
    }

    #div_respuestas{
        position: relative;
        bottom :2%;

        text-align:center;
    }
    .fa{
        font-size:50px;
        color:#fff;
    }
    .total{color:#00C201;}
    .muy{color:#88E74F;}
    .neutral{color:#FFDB00; }
    .poco{color:#E56F01; }
    .nada{color:#FF2952; }

    .back_total{background-color:#00C201;}
    .back_muy{background-color:#88E74F;}
    .back_neutral{background-color:#FFDB00; }
    .back_poco{background-color:#E56F01; }
    .back_nada{background-color:#FF2952; }

    button{
        padding:0px 4px;
    }

    #b_iniciar{
        font-size:40px;
        color:#fff;
    }
    

    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        
        .div_contenedor{
            height:700px;
        }

        #div_respuestas{
            text-align:left;
        }

        #b_iniciar{
            font-size:30px;
            color:#fff;
        }

        #b_iniciar .fa{
            font-size:30px;
            color:#fff;
        }
    }

    /* Responsive Web Design */
    @media only screen and (max-width:1024px){
        
    
        #b_iniciar{
            font-size:25px;
            color:#fff;
        }

        #b_iniciar .fa{
            font-size:25px;
            color:#fff;
        }
    }

  
</style>

<body>
    <div class="container-fluid" id="div_encuestas">
        <div class="row" style="height:40%;"> </div> 
        
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="text-align: center;">
                <button type="button" class="btn btn-info btn-sm form-control btn-circle" id="b_iniciar"> Iniciar<br><i class="fa fa-play" aria-hidden="true"></i></button>
            </div>
        </div>
    </div> <!--div_encuestas-->

    <div class="container-fluid" id="div_principal">
        <br>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-offset-1 col-md-8 div_contenedor"  style="border-radius: 25px; border: 2px solid #878787;">
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <!--<h1>Encuesta</h1>-->
                        <img src="../imagenes/alarmas.png" height="100px" width="100px" style="border-radius: 50%; border: 2px solid;">
                    </div>
                </div>
                <br>
                <div class="row" style="padding-top:8%;">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div id="carousel_preguntas" class="carousel slide" data-ride="carousel" data-interval="false">
                            <div class="carousel-inner" id="contenedor_preguntas"></div>
                            <br><br><br>
                            <div id="div_respuestas" class="row">

                                <div class="col-md-4">
                                    <button type="button" class="btn back_total b_respuesta" alt="3" role="button">
                                        <i class="fa fa-smile-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn back_neutral b_respuesta" alt="2" role="button">
                                        <i class="fa fa-meh-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn back_nada b_respuesta" alt="1" role="button">
                                        <i class="fa fa-frown-o" aria-hidden="true"></i>
                                    </button>
                                </div>

                            </div>

                            <br>

                        </div>

                    </div> 
                </div>
                <br><br>
            </div> <!--div_contenedor-->
        
        </div>
    </div> <!--div_principal-->
    
</body>

<div id="fondo_cargando"></div>

<script src="../js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/js/bootstrap.js"></script>
<script src="../js/jquery.validationEngine.js"></script>
<script src="../js/jquery.validationEngine-es.js"></script>
<script src="../js/general.js"></script>
<script src="../vendor/select2/js/select2.js"></script>

<script>
    
    var totalPreguntas = 0;
    var contador = 0;
    var id=<?php echo $id?>;
  
    $(function(){

        //->   #00C201    totalmente satisfecho
        //->   #88E74F    muy satisfecho
        //->   #FFDB00    neutral
        //->   #E56F01    poco satisfecho
        //->   #FF2952    nada satisfecho

        $("#div_encuestas").css({left : "0%"});
        $('#b_iniciar').prop('disabled',true);
        verificaEncuestaOrnde(id);

        function verificaEncuestaOrnde(id){

            $.ajax({
                type: 'POST',
                url: '../php/encuesta_buscar_orden_registro.php',
                dataType:"json", 
                data:{'id':id},//1=activos 0=inactivos 2=todos
                success: function(data) {
                 if(parseInt(data) > 0){
                     mandarMensaje('Muchas gracias por haber contestado nuestra encuesta!');
                 }else{
                    $('#b_iniciar').prop('disabled',false);
                 }
                },
                error: function (xhr) {
                    console.log('../php/preguntas_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar.');
                }
            });
        }



        $('#b_iniciar').click(function(){
            totalPreguntas = 0;
            contador = 0;
            muestraPreguntas();

            $("#div_encuestas").animate({left : "-101%"}, 500, 'swing');
            $('#div_principal').animate({left : "0%"}, 600, 'swing');

            //$('#div_cerrar').hide();

        });

        function muestraPreguntas(tipo){
            $('#contenedor_preguntas').html('');

            $.ajax({
                type: 'POST',
                url: '../php/preguntas_buscar.php',
                dataType:"json", 
                data:{'estatus':1},//1=activos 0=inactivos 2=todos
                success: function(data) {
                
                if(data.length > 0){
                    totalPreguntas = data.length;

                    for(var i=0;data.length>i;i++)
                    {

                        var html = '';
                        if(i == 0)
                            html = '<div style="text-align: center;" alt="'+data[i].id+'" class="carousel-item active"><h4>'+data[i].pregunta+'</h4></div>';
                        else
                            html = ' <div style="text-align: center;"  alt="'+data[i].id+'" class="carousel-item"><h4>'+data[i].pregunta+'</h4> </div>';
                        
                        $('#contenedor_preguntas').append(html); 
                    }

                }
                else
                    mandarMensaje('No se encontró información');
                

                },
                error: function (xhr) {
                    console.log('../php/preguntas_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar.');
                }
            });
        }

        $(document).on('click','.b_respuesta',function(){
            var respuesta = $(this).attr('alt');
            var idPregunta = $(document).find('.active').attr('alt');

            var preguntaActual = $(document).find('.active');
            //$(".carousel").carousel("next");

            var info = {
                'respuesta': respuesta,
                'idPregunta' : idPregunta,
                'idServicio' : id
            };

            $.ajax({
                type: 'POST',
                url: '../php/encuesta_guardar_respuesta.php',  
                data: {'datos':info},
                //una vez finalizado correctamente
                success: function(data){
                  
                    if (data > 0 ) {
                        contador++;
                        if(contador < totalPreguntas)
                        {
                            $(".carousel").carousel("next"); 
                        }else
                        {
                            
                            $('#fondo_cargando').show();

                            setTimeout(function()
                            {
                                window.location.replace("cerrar.php");
                            }, 2000);

                        }          
                    }else{
                        mandarMensaje('Fallo, intentalo nuevamente.');
                        $(this).prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('../php/encuesta_guardar_respuesta.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* Fallo, intentalo nuevamente.');
                    $(this).prop('disabled',false);
                }
            });
        });

    });

</script>

</html>