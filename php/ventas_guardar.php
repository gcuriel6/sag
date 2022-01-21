<?php
    session_start();
    include('../models/Ventas.php');
    include('../models/SalidasAlmacen.php');

    $datos = $_REQUEST['datos'];
    $cotizacion = $_REQUEST['cotizacion'];
   
    $modeloVentas = new Ventas();
    $modeloSalidasAlmacen = new SalidasAlmacen();

    $modeloVentas->link->begin_transaction();
    $modeloVentas->link->query("START TRANSACTION;");

    if (isset($_SESSION['usuario'])){

        $resultadoidVenta = $modeloVentas->guardarVentas($datos);

        if( $resultadoidVenta > 0 ){
            //--- si es una cotizacion solo se guarda la nota
            if($cotizacion==1){

                $modeloVentas->link->query("COMMIT;");
                echo $resultadoidVenta;
                
            }else{
                //--- si es una venta se saca el material del almcen
                /** MGFS 30-01-2020 SE CAMBIA EL CONCEPTO DE S01 A S07 PARA QUE SALGA COMO SALIDA POR VENTADE ALARMAS
                 * ESTE CONCEPTO TAMV¿BIEN ES PARA VENTA DE STOCK(COMERCIALIZADORA) POR ESO SE AGREGO UNA BANDERA (ventasAlarmas)
                 * PARA INDICAR QUE ESTA SALIDA ES POR VENTA DE ALARMAS Y NO GENERA FOLIO DE VENTA_STOCK
                 */
                $idVenta = $resultadoidVenta;
                $tipoSalida = 'S07';
                $idSalida = 0;
                $folio = 0;
                $idUnidadNegocio = $datos['idUnidadNegocio'];
                $idSucursal = $datos['idSucursal'];
                $fecha =  $datos['fecha'];
                $idUsuario = $datos['idUsuario'];
                $noPartidas = $datos['noPartidas'];
                $usuario = $datos['usuario'];
                //$detalle = $datos['detalle'];
                //-->NJES Jan/31/2020 se envian solo las partidas de ptoductos porque los servicios no generan una salida de almacen
                $detalle = $datos['detalleAlmacen'];
                $ventasAlarmas = 1;
                //-- MGFS 25-02-2020 Se agrega validacion si no hay productos y solo lleva servicios no realiza la salida de almacen
                if($detalle[0]>0){
                
                    $arr = array('idVenta' => $idVenta,
                                'tipoSalida' => $tipoSalida,
                                'idSalida' => $idSalida,
                                'folio' => $folio,
                                'idUnidadNegocio' => $idUnidadNegocio,
                                'idSucursal' => $idSucursal,
                                'fecha' => $fecha,
                                'noPartidas' => $noPartidas,
                                'idUsuario' => $idUsuario,
                                'usuario' => $usuario,
                                'ventasAlarmas' => $ventasAlarmas,
                                'detalle' => $detalle
                            );
                
                    $resultAlmacen =  $modeloSalidasAlmacen->guardarSalidas($arr);

                    if( $resultAlmacen > 0)
                    {
                        $modeloVentas->link->query("COMMIT;");
                        echo $idVenta;
                    }else{
                        
                        $modeloVentas->link->query("ROLLBACK;");
                        echo 0;
                    }
                }else{
                    $modeloVentas->link->query("COMMIT;");
                    echo $idVenta;
                }

            }

            

        }else{
                
            $modeloVentas->link->query("ROLLBACK;");
            echo 0;
        }
    
    }else{
        echo json_encode("sesion");
    }
 	
?>