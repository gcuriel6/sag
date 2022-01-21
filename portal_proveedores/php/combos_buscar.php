<?php
    session_start();
	include('../widgets/Combos.php');
    
    $tipoSelect=$_REQUEST['tipoSelect'];

            
    if($tipoSelect=='PAISES'){
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuarioP'])){

            echo $resultado = $modeloCombos->buscarPaises();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='ESTADOS'){
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuarioP'])){

            echo $resultado = $modeloCombos->buscarEstados();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='MUNICIPIOS'){

        $idEstado = $_REQUEST['idEstado'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuarioP'])){

            echo $resultado = $modeloCombos->buscarMunicipios($idEstado);
        }else{
            echo json_encode("sesion");
        }
    }

 	
?>