<?php
    session_start();
    
    $id_activo = $_REQUEST['id_activo'];
    $id_bitacora = $_REQUEST['id_bitacora'];
    $tipo = $_REQUEST['tipo'];
       
    if($tipo == 'evidencia')
        $filename = "../activosBitacoraEvidencia/formato_evidencia_".$id_activo."_".$id_bitacora.".pdf";

     if($tipo == 'foto1')
        $filename = "../activosBitacoraFoto1/formato_foto1_".$id_activo."_".$id_bitacora.".jpg";


    if($tipo == 'foto2')
        $filename = "../activosBitacoraFoto2/formato_foto2_".$id_activo."_".$id_bitacora.".jpg";


    if(file_exists($filename)) 
        echo 1;
    else 
        echo 0;
    
?>
