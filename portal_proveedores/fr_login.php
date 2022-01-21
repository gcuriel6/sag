<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PORTAL PROVEEDORES</title>
  <!-- Hojas de estilo -->
  <link rel="stylesheet" href="../css/css/bootstrap.css" type="text/css" media="all">
  <link rel="stylesheet" href="../css/validationEngine.jquery.css" />
  <link href="../vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
  <link href="../css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>

  <script src="../js/jquery3.3.1/jquery-3.3.1.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/js/bootstrap.js"></script>
  <script src="../js/jquery.validationEngine.js"></script>
  <script src="../js/jquery.validationEngine-es.js"></script>
  <script src="../js/bootstrap-datepicker.min.js"></script>
  <script src="js/general.js"></script>
</head>

<style>
 
  body{
    margin:auto;
    background-image: url('../imagenes/fondo_login.jpg');
    background-color:#ffffff;
    background-size:cover;
    background-repeat: no-repeat;
    overflow:hidden;
  }

  #d_marco {
    position:absolute;
    top:0%;
    left:0%;
    width: 100%;
    background-color:rgba(4,5,5,.4);
    bottom:0%;
    z-index: 0;
    border-radius:5px;
    margin-bottom: -800px;
    padding-bottom: 800px;
    overflow: hidden;
  }
  #div_login{
  
    margin-top: 2%;
    margin-left: 30%;
    margin-right: 30%;
  
  }
  #div_cont{
    left:10%;
  }
  .linea {
    position:relative;
    background-color: #00669C;
    height: 2px;
    width: 100%;
  }
  #img_logo{
    width: 200px;
  }

  @media screen and (max-width: 1030px) {
    #div_login{
      margin-top: 10%;
    }
    body{
      height:800px;
    }
  }

  @media screen and (max-width: 780px) {
        #div_login{
          margin-top:30%;
          margin-left: 20%;
          margin-right: 20%;
        }

        body{
          height:1050px;
          background-size:cover;
          background-repeat: no-repeat;
          background-position:48%;
        }
    }

  @media screen and (max-width: 680px) {
      #div_login{
        margin-left: 20%;
        margin-right: 20%;
        margin-top: 5%;
        margin-bottom: 5%;
      }
      #div_cont{
        left:0%;
      }
      #img_logo{
        width: 150px;
      }
      body{
        height:468px;
        background-size:cover;
        background-repeat: no-repeat;
        background-position:48%;
        overflow: auto;
      }

    }
    @media screen and (max-width: 480px) {
        #div_login{
          margin-top: 30%;
          background-color:rgba(250,250,250,0.9);
          margin-left: 10%;
          margin-right: 10%;
        }
        body{
          height:668px;
          background-size:cover;
          background-repeat: no-repeat;
          background-position:48%;
        }
        #div_cont{
          left:0%;
        }
    }
</style>

<body>

  <div id="d_marco"> </div>

  <div class="container-fluid">
    <div id="div_login">
      <div class="row">
        <div class="form-group col-xs-12 col-md-10" id="div_cont">
          
          <div class="col-xs-10 col-md-12" style="text-align: center;">
              <img src="../imagenes/logoGinther2.png" width="300px"/>
              <h4 style="color:rgb(4,5,5);">PORTAL PROVEEDORES</h4>
          </div>
          <br>
          <div class="input-group col-xs-10 col-md-11 col-md-offset-1">
            <span class="input-group-addon" style="background-color: rgb(4,5,5); border-color:#000; color: #fafafa;">
              <i class="fa fa-user-o" aria-hidden="true"></i>
            </span>
            <input type="text" class="form-control input-md" id="i_usuario" placeholder="RFC" autocomplete="off">
          </div><br>

          <div class="input-group col-xs-10  col-md-11 col-md-offset-1">
            <span class="input-group-addon" style="background-color: rgb(4,5,5); border-color:#000; color: #fafafa;">
              <i class="fa fa-key" aria-hidden="true"></i>
            </span>
              <input type="password" class="form-control input-md" id="i_password" placeholder="Contraseña" autocomplete="off">
          </div><br/>

          <div class="col-xs-10 col-md-12" style="text-align: center;">
            <button class="btn btn-lg btn-dark" style="background-color: rgb(4,5,5); border-color:#000; color: #fafafa;" type="button" id="b_login">Entrar</button><br><br>
          </div>

          <div class="row">
              <div class="col-sm-12 col-md-6" style="text-align: center;">
              <button class="btn btn-md btn-dark"  style="color:#fafafa;" type="button" id="b_olvide_contrasena"><i class="fa fa-question-circle" aria-hidden="true"></i> Olvide mi contraseña</button><br><br>
              </div>
              <div class="col-sm-12 col-md-6" style="text-align: center;">
              <button class="btn btn-md btn-primary"  style="background-color:rgb(26,64,103);color:#fafafa;" type="button" id="b_crear_cuenta"><i class="fa fa-address-card-o" aria-hidden="true"></i> Crear Cuenta</button><br><br>
              </div>
          </div>


          <div class="col-xs-10 col-md-12 linea"></div>
          <br>

          <div  class="col-xs-10 col-md-12">
            <h6 style="text-align: center">Powered by &nbsp; <img  src="../imagenes/logo_denken.png" class="logo" width="65px;"/>&nbsp;&nbsp;&nbsp;<a href="https://www.denken.mx/" target="new">www.denken.mx</a></h6>
          </div>

        </div>
      </div>
    </div>
  </div>

</body>

<script>
  $(function(){
        $('#b_login').click(function(){
            if($('#i_usuario').val() != ''){
                if($('#i_password').val() != ''){
                    $.post("php/login.php",{ usuario: $('#i_usuario').val(), password: $('#i_password').val()},function(data){
                        
                        if(data == '1'){
                            window.open('index.php','_top');
                        }
                        else{
                            mandarMensaje(data);
                        }
                    });
                }else{
                    mandarMensaje('ingresa una contraseña');
                }
            }else{
            mandarMensaje('Ingresa un usuario');
            }
        });

        $("#i_password").keyup(function(event) {
          if (event.keyCode == 13) {
            $("#b_login").click();
          }
        });

        
        $('#b_olvide_contrasena').on('click',function(){
          
            window.open("fr_usuarios.php?boton=0","_top");
        });

        $('#b_crear_cuenta').on('click',function(){
          
            window.open("fr_usuarios.php?boton=1","_top");
        });
  });
</script>

</html>
