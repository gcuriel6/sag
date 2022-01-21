<?php
    session_start();
	// include('../models/Uniformes.php');

    // $estatus=$_REQUEST['estatus'];

    // $modeloUsuario = new Uniformes();

    if (isset($_SESSION['usuario'])){

        if(isset($_FILES['file']['name'])){
            $date = date("Y-m-d-H-i-s");
            $uid = uniqid();
            $filename = $_FILES['file']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
         
            // echo exec('whoami');
            // exit();
            // Location
            $archivo = $_SESSION['usuario'] . $date . '' . $uid . "." . $ext;
            $location = '../vision/'.$archivo;
        
            // Valid extensions
            $valid_ext = array("gif","jpg","png","jpeg");
         
            $response = 0;

            if(in_array($ext, $valid_ext)){
               // Upload file
               if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                  $response = json_encode(array("imagen"=>$archivo));
               } 
            }
         
            print_r( $response);
            exit;
        }
    }else{
        echo json_encode("sesion");
    }
 	
?>