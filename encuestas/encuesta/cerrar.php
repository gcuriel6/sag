<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Encuestas</title>
    <!-- Hojas de estilo -->
    <link href="../css/css/bootstrap.css" rel="stylesheet"  type="text/css" media="all">
    <link href="../css/validationEngine.jquery.css" rel="stylesheet" />
    <link href="../css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <link href="../css/general.css" rel="stylesheet"  type="text/css"/>
    <link href="../vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="../vendor/select2/css/select2.css" rel="stylesheet"/>
</head>

<style>

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
        height:400px;
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

    <div class="row">
        <br><br><br><br>
    </div> 

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-offset-1 col-md-8 " >
            
            <div class="row" style="padding-top:8%;">
                <div class="col-md-2"></div>
                <div class="col-md-8 div_contenedor" style="border-radius: 25px; border: 2px solid #878787;">
                        
                        
                    <div  style="text-align:center">
                        <h3>¡Gracias por contestar!</h3>
                        <img src="../imagenes/okay.png" height="300" width="300">
                        <br>
                        <button type="button" class="btn btn-success " id="b_acabar_encuesta">Acabar Encuesta</button> 
                    </div>

                </div> 
            </div>
            <br><br>
        </div> <!--div_contenedor-->
        
    </div>
    
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
  
    $(function()
    {

        /*setTimeout(function()
        {
            window.location.replace("index.php");
        }, 10000);*/

        $('#b_acabar_encuesta').click(function()
        {

            window.location.replace("index.php");

        });

    });

</script>

</html>