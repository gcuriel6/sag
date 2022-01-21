<?php
    
	session_start();
	include '../../php/conectar.php';
	$link = Conectarse();

    if (isset($_SESSION['usuario'])){

        $verifica = "0";

        if(isset($_FILES['archivo']['name'])){
            $nombre_origen=strtolower($_FILES['archivo']['name']); //-->nombre original
            $tipo_a=explode('.', $nombre_origen);
            
            $ext=$tipo_a[count($tipo_a)-1];

            $nombre_nuevo=uniqid($_SESSION['usuario']).".".$ext;

            $ruta = '../clientes/docs/'.$nombre_nuevo;
            
            if(move_uploaded_file($_FILES['archivo']['tmp_name'],$ruta)){

                $idCliente = $_POST['idCliente'];
                $campo = $_POST['campo'];

                $query1 = "SELECT *
                            FROM documentos_clientes
                            WHERE id_cliente = $idCliente;";

                $documentos = mysqli_query($link,$query1);
                $rows = mysqli_affected_rows($link);

                if($rows > 0){
                    $query2 = "UPDATE documentos_clientes
                                SET $campo = '$nombre_nuevo'
                                WHERE id_cliente = $idCliente;";
                }else{
                    $query2 = "INSERT INTO documentos_clientes(id_cliente, $campo)
                                VALUES($idCliente, '$nombre_nuevo')";
                }

                $result = mysqli_query($link,$query2);
    
                if($result){
                    $verifica = "1"; 
                }else{
                    $verifica = "0"; 
                }
    
            }else
                $verifica = "0"; 
    
        }else
            $verifica = "0";

        echo $verifica;
    }else{
        echo json_encode("sesion");
    }
 	
?>