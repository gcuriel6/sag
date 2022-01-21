<?php
    session_start();
	include('../models/Accesos.php');
    $arr_suc=array();
    
    $datos=$_REQUEST['datos'];
 
    $modeloAccesos = new Accesos();

    if (isset($_SESSION['usuario'])){

        $resultado = $modeloAccesos->AccesoSucursales('quitar',$datos);
        if($resultado==1){
            unset($_SESSION['sucursales']);
            
            $_SESSION['sucursales'] = json_encode($arr_suc);
            $idUsuario=$datos[1]['idUsuario'];
            $query_su="SELECT accesos.id_unidad_negocio,cat_unidades_negocio.logo,cat_unidades_negocio.nombre AS nombre_unidad
                                    FROM accesos 
                                    LEFT JOIN cat_unidades_negocio ON accesos.id_unidad_negocio=cat_unidades_negocio.id
                                    WHERE accesos.id_usuario=".$idUsuario." AND cat_unidades_negocio.inactivo=0 
                                    GROUP BY accesos.id_unidad_negocio";
            $result_su = mysqli_query($modeloAccesos->link,$query_su) or die(mysqli_error());
            $num = mysqli_num_rows($result_su);
       
            if($num>0){
              
                for($k=0;$k<$num;$k++){
                    
                    $row_su = mysqli_fetch_array($result_su);
                    $arr_suc[$k] = array('id_unidad' => $row_su['id_unidad_negocio'],'logo' => $row_su['logo'],'nombre_unidad' => $row_su['nombre_unidad']);
                    
                }
         
                $_SESSION['sucursales'] = json_encode($arr_suc);
                echo 1;
        
            }else{
        
              echo 0;
            }
	
          }
    }else{
        echo json_encode("sesion");
    }
 	
?>