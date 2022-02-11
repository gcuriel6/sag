<?php
require_once('php/conectar.php');

$link = Conectarse();

$query="SELECT CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) nombreCompleto, dia_n, cve_nom
        FROM trabajadores
        WHERE mes_n = MONTH(NOW()) AND fecha_baja = '0000-00-00' AND administrativo = 2
        ORDER BY dia_n ASC";

$result = mysqli_query($link,$query);
$numRows = mysqli_num_rows($result);

?>

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

  .wrapper {
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
            
            <div class="card bg-transparent border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 mb-3">
                    <img src="imagenes/logoGinther2.png" class="img-fluid"/>
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

                  <?php
                    if($numRows>0){            
                  ?>
                  <div class="col-12">
                    <button class="btn btn-secondary btn-block" type="button" id="btnCumples">Cumpleaños</button>
                  </div>
                  <?php
                    }
                  ?>
                </div>
              </div>
            </div>            
          </div>
          
        </div>
      </div>
    </div>

    <ul class="bg-bubbles">
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
    </ul>
  </div>

  <div class="modal fade" id="dialog_bdays" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
              <h4 class="modal-title">Cumpleaños del Mes</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody>

            <?php
            while($row = mysqli_fetch_array($result)){
              $nombre=$row["nombreCompleto"];
              $dia = $row["dia_n"];
              $cve = $row["cve_nom"];

              echo "<tr>
                        <td scope='col'>$cve</td>
                        <td scope='col'>$nombre</td>
                        <td scope='col'>$dia</td>
                      </tr>";

              // print_r($row);
            }
            ?>

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

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

        $('#btnCumples').click(function(){
            $("#dialog_bdays").modal("toggle");
        });

        $("#i_password").keyup(function(event) {
          if (event.keyCode == 13) {
            $("#b_login").click();
          }
        });
  });
</script>

</html>
