<?php
    session_start();
    include('../models/Viaticos.php');
    include('../models/DeudoresDiversos.php');
    
    $boton = $_REQUEST['boton'];
    $reposicionGasto = $_REQUEST['reposicionGasto'];
    $datos = $_REQUEST['datos'];
   
    $modeloViaticos = new Viaticos();

    if (isset($_SESSION['usuario'])){

        if($reposicionGasto==1){

            echo $resultado = $modeloViaticos->comprobarViaticos($boton,$datos);

        }else{

            if($boton=='b_guardar_comprobacion'){

                echo $resultado = $modeloViaticos->comprobarViaticos($boton,$datos);

            }else{

                $resultado = $modeloViaticos->comprobarViaticos($boton,$datos);
                if($resultado > 0){

                    

                    $modeloDeudoresDiversos = new DeudoresDiversos();

                    $resultado = $modeloDeudoresDiversos->guardarPagoDeudoresDiversos($datos);

                    if($resultado>0){

                        echo $resultado;

                    }else{
                        echo 0;
                    }

                }

            }
            
        }
        
    }else{
        echo json_encode("sesion");
    }
 	
?>