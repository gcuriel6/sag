<?php
    session_start();

    $id_activo = $_REQUEST['id'];
       
    $filename = "../activosResponsivaFirmada/responsiva_firmada_".$id_activo.".pdf";

    if(file_exists($filename)) 
        echo 1;
    else 
        echo 0;
    
?>
