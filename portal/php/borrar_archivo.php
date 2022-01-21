<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id = $_REQUEST["id"];	
	$doc = $_REQUEST["doc"];
		
	//obtenemos la ruta del archivo a borrar
	$query = "SELECT $doc FROM documentos_fijos WHERE id_trabajador = $id";
	$Consulta=mysqli_query($link,$query);
	$resultado= mysqli_fetch_array($Consulta);
	
	$dir = $resultado["$doc"];
	//echo $dir;
	
	//borramos el archivo
	unlink($dir);
	
	//
	if(!file_exists($dir))
	{
		$query = "UPDATE documentos_fijos SET $doc = 'no' WHERE id_trabajador = $id";
		$Consulta = mysqli_query($link,$query);
		echo "archivo borrado";
	}
	else
	{
		echo "el archivo no se pudo borrar";
	}
?>