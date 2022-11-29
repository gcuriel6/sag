<?php 
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id = $_REQUEST["id"];	
	$doctype = $_REQUEST["doctype"];
	$dir = "../../../Portal/docsII/$id";
	
	if($doctype == "fotografia")
	{
		if(!file_exists($dir))
		{
			mkdir($dir, 0777);
			chmod($dir, 0777);
		}
		rename($_FILES["doc"]["tmp_name"],"$dir/". $_FILES["doc"]["name"]);
		$path = "$dir/". $_FILES["doc"]["name"];
		$size = $_FILES["doc"]["size"];
		chmod($path, 0777);
		
		$file = fopen($path,"rb");
		$info = addslashes(fread($file,$size));
		
		
		$query = "INSERT INTO fotos (id_trabajador,foto) VALUES ('$id','$info')";
		$Consulta=mysqli_query($link,$query);
		echo "<script language='javascript'>alert('archivo guardado'); window.open('detalle_trabajador.php?id=$id','_self');</script>";
		fclose($file);
		unlink($path);
	}
	else
	{
		if(!file_exists($dir))
		{
			mkdir($dir, 0777);
			chmod($dir, 0777);
		}
		rename($_FILES["doc"]["tmp_name"],"$dir/". $_FILES["doc"]["name"]);
		$path = "$dir/". $_FILES["doc"]["name"];
		chmod($path, 0777);
		
		if(file_exists("$dir/". $_FILES["doc"]["name"]))
		{
			$query = "UPDATE documentos_fijos SET $doctype = '$path' WHERE id_trabajador = $id";
			$Consulta=mysqli_query($link,$query);
			chmod($dir, 0777);
			chmod($path, 0777);
			//echo $query;
			echo "<script language='javascript'>alert('archivo guardado'); window.open('detalle_trabajador.php?id=$id','_self');</script>";
		}
		else
		{
			echo "<script language='javascript'>alert('archivo no guardado'); history.go(-1);</script>";
		}
	}
?>