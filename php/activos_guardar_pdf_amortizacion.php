<?php
session_start();
// print_r($_FILES);
//--MGFS 17-01-2020 SE CAMBIA LA RUTA DE GUARDADO DE ARCHIVO YA QUE TENIA UNA RUTA ABSOLUTA
//--$_SERVER['DOCUMENT_ROOT'] . "/ginther-clone/ POR ../
if ($_FILES["i_amortizacion"]["type"] == "application/pdf") {
  move_uploaded_file(
    $_FILES['i_amortizacion']['tmp_name'],
    "../activosPdf/formato_amortizacion_".$_SESSION["id_activo"].".pdf"
  );
  return 1;
}
else {
  return 0;
}
// print_r($_FILES);



?>
