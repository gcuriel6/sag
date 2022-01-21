<?php
    session_start();
    include('../models/Permisos.php');
    
    $datos = $_REQUEST['datos'];

    $modeloPermisos = new Permisos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPermisos->buscarReportePermisosUsuario($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>