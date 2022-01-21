<?php
session_start();

$id_bitacora = $_REQUEST['id_bitacora_activo'];

if(isset($_FILES['evidencia']['name']))
{
    move_uploaded_file(
        $_FILES['evidencia']['tmp_name'],
        "../activosBitacoraEvidencia/formato_evidencia_".$_SESSION["id_activo"]."_".$id_bitacora.".pdf"
    );
}

if(isset($_FILES['foto1']['name']))
{
    move_uploaded_file(
        $_FILES['foto1']['tmp_name'],
        "../activosBitacoraFoto1/formato_foto1_".$_SESSION["id_activo"]."_".$id_bitacora.".jpg"
    );
}

if(isset($_FILES['foto2']['name']))
{
    move_uploaded_file(
        $_FILES['foto2']['tmp_name'],
        "../activosBitacoraFoto2/formato_foto2_".$_SESSION["id_activo"]."_".$id_bitacora.".jpg"
    );
}
            
echo 1;
       
?>
