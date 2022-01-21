<?php
	include 'conectar.php';
	$link = Conectarse();

    $id_producto = $_REQUEST['id_producto'];
    $id_pedido = $_REQUEST['id_pedido'];
    $id_pedido_d = $_REQUEST['id_pedido_d'];
   
    $num_imagenes = $_REQUEST['num_imagenes'];
    
    if($num_imagenes > 0){

        if(isset($_FILES['i_imagen']['name'])){
                
            $query_img="INSERT INTO pedidos_imagenes(id_pedido,id_pedido_d,id_producto)VALUES ('$id_pedido','$id_pedido_d','$id_producto')";
            $result_img = mysqli_query($link,$query_img) or die(mysqli_error());
            $id_imagen=mysqli_insert_id($link);

            $nombre_imagen=$_FILES['i_imagen']['name']; 
            $tipo_a=explode('.', $nombre_imagen);
            $ext=$tipo_a[count($tipo_a)-1];
            $nombre_imagenes_bd="imagen_".$id_producto."_".$id_imagen.".".$ext;
            $ruta_imagenes = "../imagenes_pedidos/".$nombre_imagenes_bd;
            if(!(move_uploaded_file($_FILES['i_imagen']['tmp_name'],$ruta_imagenes))){
                $ruta_imagenes='';
                $nombre_imagenes_bd='';
                echo 0;
            }else{
                $query_insert_img="UPDATE pedidos_imagenes SET imagen='$nombre_imagenes_bd' WHERE id=".$id_imagen;
                $result_query_insert_img = mysqli_query($link,$query_insert_img) or die(mysqli_error());
                if($result_query_insert_img){
                    echo $id_imagen;
                }else{
                    echo 0;
                }
               
            }
        }else{
            echo 0;
        }

    }else{
        echo 0;
    }
			
	

		
?>