<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GINTHER</title>
  <!-- Hojas de estilo -->
  <link rel="stylesheet" href="css/css/bootstrap.css" type="text/css" media="all">
  <link rel="stylesheet" href="css/validationEngine.jquery.css" />
  <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
  <link href="css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
</head>

<style>
 
  body{
    /* background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%); */
  }

  /* .wrapper {
    background: #28a9a7;
    background: linear-gradient(to bottom right, #28a9a7 0%, #a5e353 100%);
    position: absolute;
    width: 100%;
    overflow: hidden;
  }

  .card{
    z-index: 2;
  }

  .bg-bubbles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
  }
  .bg-bubbles li {
    position: absolute;
    list-style: none;
    display: block;
    width: 40px;
    height: 40px;
    background-color: rgba(255, 255, 255, 0.15);
    bottom: -160px;
    -webkit-animation: square 25s infinite;
    animation: square 25s infinite;
    transition-timing-function: linear;
  }
  .bg-bubbles li:nth-child(1) {
    left: 10%;
  }
  .bg-bubbles li:nth-child(2) {
    left: 20%;
    width: 80px;
    height: 80px;
    -webkit-animation-delay: 2s;
            animation-delay: 2s;
    -webkit-animation-duration: 17s;
            animation-duration: 17s;
  }
  .bg-bubbles li:nth-child(3) {
    left: 25%;
    -webkit-animation-delay: 4s;
            animation-delay: 4s;
  }
  .bg-bubbles li:nth-child(4) {
    left: 40%;
    width: 60px;
    height: 60px;
    -webkit-animation-duration: 22s;
            animation-duration: 22s;
    background-color: rgba(255, 255, 255, 0.25);
  }
  .bg-bubbles li:nth-child(5) {
    left: 70%;
  }
  .bg-bubbles li:nth-child(6) {
    left: 80%;
    width: 120px;
    height: 120px;
    -webkit-animation-delay: 3s;
            animation-delay: 3s;
    background-color: rgba(255, 255, 255, 0.2);
  }
  .bg-bubbles li:nth-child(7) {
    left: 32%;
    width: 160px;
    height: 160px;
    -webkit-animation-delay: 7s;
            animation-delay: 7s;
  }
  .bg-bubbles li:nth-child(8) {
    left: 55%;
    width: 20px;
    height: 20px;
    -webkit-animation-delay: 15s;
            animation-delay: 15s;
    -webkit-animation-duration: 40s;
            animation-duration: 40s;
  }
  .bg-bubbles li:nth-child(9) {
    left: 25%;
    width: 10px;
    height: 10px;
    -webkit-animation-delay: 2s;
            animation-delay: 2s;
    -webkit-animation-duration: 40s;
            animation-duration: 40s;
    background-color: rgba(255, 255, 255, 0.3);
  }
  .bg-bubbles li:nth-child(10) {
    left: 90%;
    width: 160px;
    height: 160px;
    -webkit-animation-delay: 11s;
            animation-delay: 11s;
  }
  @-webkit-keyframes square {
    0% {
      transform: translateY(0);
    }
    100% {
      transform: translateY(-700px) rotate(600deg);
    }
  }
  @keyframes square {
    0% {
      transform: translateY(0);
    }
    100% {
      transform: translateY(-700px) rotate(600deg);
    }
  } */

body {
  background-color: #6b92b9;
  background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0CAYAAADL1t+KAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBNYWNpbnRvc2giIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QTFCN0Y1NTYyMjczMTFFMUFCRDRFQUNEMjAzMjJFMkQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkU1MTk3OTQyMjc0MTFFMUFCRDRFQUNEMjAzMjJFMkQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpBMUI3RjU1NDIyNzMxMUUxQUJENEVBQ0QyMDMyMkUyRCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpBMUI3RjU1NTIyNzMxMUUxQUJENEVBQ0QyMDMyMkUyRCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PhaMNc4AABHpSURBVHja7N3BTlzX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"), url("data:image/png;base64,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"), url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAYAAAB5fY51AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBNYWNpbnRvc2giIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QTFCN0Y1NEUyMjczMTFFMUFCRDRFQUNEMjAzMjJFMkQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QTFCN0Y1NEYyMjczMTFFMUFCRDRFQUNEMjAzMjJFMkQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpBMUI3RjU0QzIyNzMxMUUxQUJENEVBQ0QyMDMyMkUyRCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpBMUI3RjU0RDIyNzMxMUUxQUJENEVBQ0QyMDMyMkUyRCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Prq/JMMAAAvPSURBVHja7N19bxTX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");
  -webkit-animation: snow 20s linear  infinite ;
  -moz-animation: snow 20s linear  infinite ;
  -ms-animation: snow 20s linear  infinite ;
  animation: snow 20s linear  infinite ;
}

.snowman{
  position:absolute;
  bottom: 0;
  left: 0;
  max-width: 20%;
}

/*Keyframes*/
@-webkit-keyframes snow {
  0% {
    background-position: 0px 0px, 0px 0px, 0px 0px;
  }
  100% {
    background-position: 500px 1000px, 400px 400px, 300px 300px;
  }
}
@-moz-keyframes snow {
  0% {
    background-position: 0px 0px, 0px 0px, 0px 0px;
  }
  100% {
    background-position: 500px 1000px, 400px 400px, 300px 300px;
  }
}
@-ms-keyframes snow {
  0% {
    background-position: 0px 0px, 0px 0px, 0px 0px;
  }
  100% {
    background-position: 500px 1000px, 400px 400px, 300px 300px;
  }
}
@keyframes snow {
  0% {
    background-position: 0px 0px, 0px 0px, 0px 0px;
  }
  100% {
    background-position: 500px 1000px, 400px 400px, 300px 300px;
  }
}


</style>

<body>

  <!-- <div id="d_marco"> </div>
  <br> -->

  <!-- <div class="container-fluid">
    <div id="div_login">
      <div class="row">
        <div class="form-group col-xs-12 col-md-10" id="div_cont">
          <br>
          <div class="col-xs-10 col-md-12" style="text-align: center;">
            <img src="imagenes/logoGinther2.png" width="300px"/>
          </div>
          <br>
          <div class="input-group col-xs-10 col-md-11 col-md-offset-1">
            <span class="input-group-addon input-group-addon-dark" style="background-color: rgb(4,5,5); border-color:#000; color: #fafafa;">
              <i class="fa fa-user-o" aria-hidden="true"></i>
            </span>
            <input type="text" class="form-control " id="i_usuario" placeholder="Usuario" autocomplete="off">
          </div>

          <div class="input-group col-xs-10  col-md-11 col-md-offset-1">
            <span class="input-group-addon" style="background-color: rgb(4,5,5); border-color:#000; color: white;">
              <i class="fa fa-key" aria-hidden="true"></i>
            </span>
              <input type="password" class="form-control" id="i_password" placeholder="Contraseña" autocomplete="off">
          </div>

          <div class="col-xs-10 col-md-12" style="text-align: center;">
            <button class="btn btn-lg btn-light" type="button" id="b_login">Login</button><br><br>
          </div>

        </div>
      </div>
    </div>
  </div> -->

  <div class="wrapper">
    <div class="container">
      <div class="row" style="height: 100vh">
        <div class="my-auto">
          <div class="col-md-4 mx-auto">
            <div class="row">
              <div class="card bg-transparent border-0">
                <div class="card-body">
                  <div class="col-12 mb-3">
                    <img src="imagenes/logoGinther2.png" class="img-fluid"/>
                    <!-- <div style="width: 320px; height: 30px;"></div> -->
                  </div>
                  
                  <div class="col-12 mb-3">
                    <div class="input-group">
                      <span class="input-group-addon" style="width: 2.7rem; text-align: center;">
                        <i class="fa fa-user-o"></i>
                      </span>
                      <input type="text" class="form-control " id="i_usuario" placeholder="Usuario" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-12 mb-3">
                    <div class="input-group">
                      <span class="input-group-addon" style="width: 2.7rem; text-align: center;">
                        <i class="fa fa-key"></i>
                      </span>
                      <input type="password" class="form-control" id="i_password" placeholder="Contraseña" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-light btn-block" type="button" id="b_login">Login</button>
                  </div>

                  <div class="col-12">
                    <div class="text-center text-light">
                      Powered by <a href="www.ginthersoft.com">Ginthersoft ®</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>

    <!-- <ul class="bg-bubbles">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul> -->
  </div>

  <img src="imagenes/hny.gif" class="snowman">

</body>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/general.js"></script>

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
  });

  document.addEventListener('copy', function(e){
    e.clipboardData.setData('text/plain', 'Información protegida por Ginthersoft');
    e.preventDefault(); // default behaviour is to copy any selected text
  });
</script>

</html>
