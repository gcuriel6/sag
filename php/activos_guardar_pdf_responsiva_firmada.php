<?php
    session_start();
       
    if(isset($_FILES['pdf']['name']))
    {
    
        $rutaPDF = "../activosResponsivaFirmada/responsiva_firmada_".$_SESSION["id_activo"].".pdf";
    
        if(move_uploaded_file($_FILES['pdf']['tmp_name'],$rutaPDF))
        {
            echo 1;
        }else{
            echo 0;
        }
    }else
        echo 0;

?>
