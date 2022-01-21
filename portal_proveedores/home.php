<?php
session_start();
include("../php/conectar.php");
$link=Conectarse();
	
header("Cache-control: private");
header("Cache-control: no-cache, must-revalidate");
header("Pragma: no-cache");
$aux = 0;
?>
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

</head>

<style>
  body{
    margin:auto;
    background-image: url('../imagenes/fondo_home.jpg');
    background-color:#ffffff;
    background-size:cover;
    background-repeat: no-repeat;
    overflow:auto;
  }

  #d_marco {
    position:absolute;
    top:0%;
    left:0%;
    width: 100%;
    background-color:rgba(250,250,250,0.8);
    bottom:0%;
    z-index: 0;
    margin-bottom: -800px;
    padding-bottom: 800px;
    overflow: hidden;
  }
  .div_unidades{
    text-align:center;
    margin-bottom:5px;
  }

  .unidad{
    padding:10px;
    background-color:rgba(250,250,250,.9);
    box-shadow: 0 0 1em gray;
  }

  .unidad:hover{
    cursor:pointer;
    box-shadow: inset 0 0 .5em gray;
  }

  #sistema_logout{
    position:fixed;
    top:0px;
    right:0%;
    width:50px;
    height:40px;
    padding: 5px;
    text-align:center;
    color:#9aa3b5;
    cursor:pointer;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    box-sizing: initial;
    z-index: 2;
    background-color:rgba(250, 250, 250,.4);
  }

  #sistema_logout:hover{
    color:#FFFFFF;
    background-color:#9aa3b5;
    color:#fff;
  }

  @media only screen and (max-width:768px){
    .div_unidades{
      margin-bottom:20px;
    }
  }
 
</style>

<body>
    <div id="d_marco"> </div>

    <!--<a id="sistema_logout" href="php/logout.php">
      <div><i class="fa fa-power-off" aria-hidden="true"></i></div>
      <div>SALIR</div>
    </a>-->

    <div class="container-fluid" id="div_contenedor">
        BIENVENIDO PROVEEDORES
    </div>
</body>

<script src="../js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/js/bootstrap.js"></script>
<script src="../js/jquery.validationEngine.js"></script>
<script src="../js/jquery.validationEngine-es.js"></script>
<script src="../js/bootstrap-datepicker.min.js"></script>
<script src="js/general.js"></script>

<script>
  var usuarioP = '<?php echo $_SESSION['usuarioP']?>';
  $(function(){

  });

</script>

</html>
