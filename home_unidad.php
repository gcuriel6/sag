<?php
  session_start();
  include("php/conectar.php");
  $link=Conectarse();
  header("Cache-control: private");
  header("Cache-control: no-cache, must-revalidate");
  header("Pragma: no-cache");
  //$aux = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GINTHERCORP</title>
  <!-- Hojas de estilo -->
  <link rel="stylesheet" href="css/css/bootstrap.css" type="text/css" media="all">
  <link rel="stylesheet" href="css/validationEngine.jquery.css" />
  <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
  <link href="css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
  <link href="vendor/select2/css/select2.css" rel="stylesheet"/>

  <script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/js/bootstrap.js"></script>
  <script src="js/jquery.validationEngine.js"></script>
  <script src="js/jquery.validationEngine-es.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/general.js"></script>
  <script src="vendor/select2/js/select2.js"></script>
</head>

<script>
  var matriz = <?php echo $_SESSION['sucursales']?>;
  var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
  $(function(){
  
    if(idUnidadActual != 0)
    {
      var logo=buscarLogoUnidad(matriz,idUnidadActual);
      $('#sistema_logo').attr('src','imagenes/'+logo);
    }else{
      $('#sistema_logo').attr('src','');
    }

  });

</script>

<style>
  
</style>

<body>

    <div class="container-fluid" id="div_contenedor">
        <div class="row">
          <div class="col align-self-center">
            <br><br><br><br><br><br><br>
            <div class="col-xs-10 col-md-12" style="text-align: center;">
                <img src="" id="sistema_logo" height="200" />
            </div>
          </div>
        </div>
    </div>

</body>

</html>
