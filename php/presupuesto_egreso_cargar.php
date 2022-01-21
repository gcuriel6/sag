<?php

session_start();
include("conectar.php");
$link = Conectarse();
@unlink("../excel/presupuesto_egresos.xls");

if(file_exists($_FILES['i_excel']['tmp_name']))
{

	$rutaN = "../excel/presupuesto_egresos.xls";
	if(!(move_uploaded_file($_FILES['i_excel']['tmp_name'], $rutaN)))
		echo "El archivo no se pudo cargar verifica que no este dañado, intentalo nuevamente";
	else
		echo 1;

}
else
	echo "El archivo no existe o esta dañado";

?>
		