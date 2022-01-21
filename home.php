<?php
session_start();
include("php/conectar.php");
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
  <title>GINTHERCORP</title>
  <!-- Hojas de estilo -->
  <link rel="stylesheet" href="css/css/bootstrap.css" type="text/css" media="all">
  <link rel="stylesheet" href="css/validationEngine.jquery.css" />
  <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
  <link href="css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>

  <script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/js/bootstrap.js"></script>
  <script src="js/jquery.validationEngine.js"></script>
  <script src="js/jquery.validationEngine-es.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/general.js"></script>
</head>

<script>
  var matriz = <?php echo $_SESSION['sucursales']?>;
  $(function(){

    muestraUnidades(matriz,'div_contenedor','home');

    $(document).on('click','.unidad',function(){
       var idUnidadActual=$(this).attr('alt');
       $.post('php/unidades_negocio_actual.php',{'id_unidad':idUnidadActual},function(data){
        
         window.open('index.php','_top');
       });
    });    

  });

</script>

<?php
  $bg = array('bg1.jpg', 'bg2.jpg', 'bg3.jpg', 'bg4.jpg', 'bg5.jpg', 'bg6.jpg', 'fondo_home.jpg'); // array of filenames

  $i = rand(0, count($bg)-1); // generate random number size of the array
  $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
?>

<style>
  body{
    margin:auto;
    background-image: url('imagenes/<?php echo $selectedBg; ?>');
    background-color:#000;
    background-size:cover;
    background-repeat: repeat;
    overflow:auto;
  }

  #d_marco {
    position:absolute;
    top:0%;
    left:0%;
    width: 100%;
    /*background-color:rgba(250,250,250,0.8);*/
    /* background-color:rgba(4,5,5,.3); */
    /* background-color: #000; */
    bottom:0%;
    z-index: 0;
    /* margin-bottom: -800px;
    padding-bottom: 800px; */
    overflow: hidden;
  }
  .div_unidades{
    text-align:center;
    margin-bottom:5px;
  }

  .unidad{
    padding:1rem;
    margin: 0.5rem;
    border-radius: 0.6rem;
    /* background-color:rgba(250,250,250,.9); */
    /* box-shadow: 0 0 1em gray; */
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
    color:#000;
    cursor:pointer;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    box-sizing: initial;
    z-index: 2;
    background-color:#fff;
    border-radius: 0 0 0 1rem;
    border-left: black solid 1px;
    border-bottom: black solid 1px;
  }

  #sistema_logout:hover{
    color:#FFFFFF;
    background-color:#000;
    border-left: white solid 1px;
    border-bottom: white solid 1px;
  }

  #div_contenedor{
    margin-top: 50px;
  }

  @media only screen and (max-width:768px){
    .div_unidades{
      margin-bottom:20px;
    }

    body{
      background-image: url('imagenes/bg-mobile.jpg');
    }
  }
 
</style>

<body>
    <div id="d_marco"> </div>

    <a id="sistema_logout" href="php/logout.php">
      <div><i class="fa fa-power-off" aria-hidden="true"></i></div>
      <div>SALIR</div>
    </a>

    <div class="container" id="div_contenedor"></div>
</body>

</html>
