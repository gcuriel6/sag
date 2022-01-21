<?php
session_start();
// print_r($_FILES);

if ($_FILES["i_veh_poliza"]["type"] == "application/pdf") {
  move_uploaded_file(
    $_FILES['i_veh_poliza']['tmp_name'],
    $_SERVER['DOCUMENT_ROOT'] . "/ginther-clone/activosPdf/formato_dictamen_seguro_".$_SESSION["id_activo"].".pdf"
  );
  return 1;
}
else {
  return 0;
}
// print_r($_FILES);



?>
