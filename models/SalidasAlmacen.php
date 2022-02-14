<?php

require_once('conectar.php');
require_once('Ventas.php');
require_once('MovimientosPresupuesto.php');

class SalidasAlmacen
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function SalidasAlmacen()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Manda llamar a la funcion que guarda la informacion de las salidas de almacen
      * 
      * @param array $datos contiene los datos de la orden a aguardar o auctualizar
      *
    **/      
    function guardarSalidas($datos){
       

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");
        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
          $this->link->query("commit;");
        else
          $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarSalidas


    /**
      * Guarda los datos de salidas almacen, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param varchar $datos contiene los parametros a guardar/actualizar
      *
      **/ 
      function guardarActualizar($datos){
       
        $verifica = 0;
        $teat = '*';

        $tipoSalida = $datos['tipoSalida'];
        $idSalida = $datos['idSalida'];
        $folio = $datos['folio'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $fecha = $datos['fecha'];
        $idUsuario = $datos['idUsuario'];
        $noPartidas = $datos['noPartidas'];
        $usuario = $datos['usuario'];
        $empleadoExterno = $datos["empleadoExterno"];

        $observacion = isset($datos['observacion']) ? $datos['observacion'] : '';
        $idProveedor = isset($datos['idProveedor']) ? $datos['idProveedor'] : 0;
        $idClasificacion = isset($datos['idClasificacion']) ? $datos['idClasificacion'] : 0;
        $idSucursalDestino = isset($datos['idSucursalDestino']) ? $datos['idSucursalDestino'] : 0;
        $idEmpleado = isset($datos['idEmpleado']) ? $datos['idEmpleado'] : 0;
        $ventasAlarmas = isset($datos['ventasAlarmas']) ? $datos['ventasAlarmas'] : 0;

        $idDepartamento = isset($datos['idDepartamento']) ? $datos['idDepartamento'] : 0;
        $idArea = isset($datos['idArea']) ? $datos['idArea'] : 0;

        //-->NJES July/28/2020 se agrega unidad negocio destino para cuando la unidad origen es ginthercorp en salida por transferencia
        $idUnidadNegocioDestino = isset($datos['idUnidadNegocioDestino']) ? $datos['idUnidadNegocioDestino'] : 0;

        //--> NJES October/29/2020 asignar empleado o cliente y clasificacion
        $idCliente = isset($datos['idCliente']) ? $datos['idCliente'] : 0;
        $clasificacion = isset($datos['clasificacion']) ? $datos['clasificacion'] : '';

        //-- MGFS 21-01-2020 SE AGREGA ID AREA Y ID DEPARTAMENTO CUANDO ES SALIDA POR UNIFORME(S02)
        if($tipoSalida=='S02'){

          $teat .= 'A';

          $buscaDepto="SELECT id_depto
                        FROM deptos
                        WHERE des_dep='RECLUTAMIENTO, SELECCION Y CONTRATACION' AND id_sucursal=".$idSucursal;

          $resultDepto = mysqli_query($this->link, $buscaDepto) or die(mysqli_error());
          $rowDepto=mysqli_fetch_array($resultDepto);

          $idDepartamento = $rowDepto['id_depto'];
          $idArea = 4;//--POR PARTE DE SECORP SE INGRESA ESTA AREA SIEMPRE
          $idFamiliaGasto = 43;
          //----MGFS 21-01-2020  LA CLASIFICACION SERA POR UNIDAD PERO SE VAN ASIGNANDO 
          //----YA QUE NO ESTA LIGADO A AUN ID UNIDAD SOLO AL ID FAMILIA GASTO PERO SOLO HAY 3 EN ESTE MOMENTO:
          //----116 - SECORP para unidad de negocio 1
          //----117 - REAL SHINY para unidad de negocio 4
          //----115 - GUARDERIAS para unidad de negocio  12
          if($idUnidadNegocio == 1){
            $idClasificacion = 116;
          }elseif($idUnidadNegocio == 4){
            $idClasificacion = 117;
          }elseif($idUnidadNegocio==12){
            $idClasificacion = 115;
          }else{
            $idClasificacion = isset($datos['idClasificacion']) ? $datos['idClasificacion'] : 0;
          }         
        }
      
        $idVenta = isset($datos['idVenta']) ? $datos['idVenta'] : 0;

        //-- SE AGREGAN DATOS PARA UNA SALIDA POR VENTA DE STOCK PARA COMERCIALIZADORA----
        $folioVentaStock = isset($datos['folioVenta']) ? $datos['folioVenta'] : 0;
        $iva = isset($datos['iva']) ? $datos['iva'] : 0;

        //--MGFS 04-02-2020 SE AGREGAN DATOS DE SECORP ALARMAS PARA CLASIFICAR LAS VENTAS
        if($tipoSalida=='S07' && $ventasAlarmas==1){
          $idUnidadNegocio = 2;
          $idDepartamento = 2911;
          $idArea = 7;
          $idFamiliaGasto = 70; 
          $idClasificacion = 171;
        }

        if($tipoSalida=='S07' && $ventasAlarmas==0){

          $teat .= 'B';

          $queryFolioVS="SELECT folio_ventas_stock FROM sucursales WHERE id_sucursal=".$idSucursal;
          $resultFVS = mysqli_query($this->link, $queryFolioVS) or die(mysqli_error());

          if($resultFVS){

            $datosVS=mysqli_fetch_array($resultFVS);
            $folioVentaStockA=$datosVS['folio_ventas_stock'];
            $folioVentaStock= $folioVentaStockA+1;

            $queryUVS = "UPDATE sucursales SET folio_ventas_stock='$folioVentaStock' WHERE id_sucursal=".$idSucursal;
            $resultUVS = mysqli_query($this->link, $queryUVS) or die(mysqli_error());
          }
        }
        //---  YA SE GENERO EL NUEVO FOLIO DE VENTA POR SUCRSAL PARA UNA VENTA DE STOCK

        $queryFolio="SELECT folio_salida_almacen FROM cat_unidades_negocio WHERE id=".$idUnidadNegocio;
        $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
        if($resultF)
        {

          $teat .= 'C';
          $datosX=mysqli_fetch_array($resultF);
          $folioA=$datosX['folio_salida_almacen'];
          $folio= $folioA+1;

          $queryU = "UPDATE cat_unidades_negocio SET folio_salida_almacen='$folio' WHERE id=".$idUnidadNegocio;
          $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
          if($resultU)
          {

            $teat .= 'D';
              $query = "INSERT INTO almacen_e (folio,cve_concepto,id_compania,id_unidad_negocio,id_sucursal,observacion,id_usuario_captura,usuario_captura,no_partidas,id_clasificacion,id_proveedor,id_trabajador,id_sucursal_destino,id_departamento,id_area,id_venta,folio_venta_stock,iva,id_unidad_negocio_destino,id_cliente,clasificacion, nombre_empleado) 
                              VALUES ('$folio','$tipoSalida','$idUnidadNegocio','$idUnidadNegocio','$idSucursal','$observacion','$idUsuario','$usuario','$noPartidas','$idClasificacion','$idProveedor','$idEmpleado','$idSucursalDestino','$idDepartamento','$idArea','$idVenta','$folioVentaStock','$iva','$idUnidadNegocioDestino','$idCliente','$clasificacion','$empleadoExterno')";
              $result = mysqli_query($this->link, $query) or die(mysqli_error());
              $idSalida = mysqli_insert_id($this->link);
                  
              if($result)
              {
                  if($tipoSalida=='S07' && $ventasAlarmas==0)
                    $verifica = $this -> guardarDetalle($idSalida,$folioVentaStock,$datos);
                  else
                    $verifica = $this -> guardarDetalle($idSalida,$folio,$datos);

                  $teat  .= $verifica;
                  //$teat .= $this->guardarDetalle($idSalida,$folio,$datos);
              }else{
                  $verifica = 0;
              }
          }else{
              $verifica = 0;
          }

        }else{
          $verifica = 0;
        }

        return $verifica;
    }//-- fin function guardarActualizar

    /**
      * Borra e inserta las partidas del registro almacen que se inserto, actualizo
      * 
      * @param int $idSalida id del registro al que pertenecen las partidas
      * @param varchar $tipoSalida tipo de entrada a guardar
      * @param int $folio id del movimiento que se genero, segun el id de la unidad de negocio
      * @param varchar $detalle array que contiene los datos de las partidas que se insertaran
      *
      **/ 
    function guardarDetalle($idSalida,$folio,$datos){
      
      $verifica=0;
      $test = '-';
      

      $tipoSalida = $datos['tipoSalida'];
      $fecha = $datos['fecha'];
      $detalle = $datos['detalle'];
      $idUnidadNegocio = $datos['idUnidadNegocio'];
      $idSucursal = $datos['idSucursal'];
      $idDepartamento = isset($datos['idDepartamento']) ? $datos['idDepartamento'] : 0;
      $idArea = isset($datos['idArea']) ? $datos['idArea'] : 0;
      $iva = $datos['iva'];
      $idVenta = isset($datos['idVenta']) ? $datos['idVenta'] : 0;
      $ventasAlarmas = isset($datos['ventasAlarmas']) ? $datos['ventasAlarmas'] : 0;

      $queryBorra = "DELETE FROM almacen_d WHERE id_almacen_e=".$idSalida;
      $result = mysqli_query($this->link, $queryBorra) or die(mysqli_error());

      if($result)
      {

        $test .= 'a';

        $afectarPresupuesto = new MovimientosPresupuesto();
      
        for($i=1;$i<=$detalle[0];$i++)
        {

         

          $test.= 'b';

          $idProducto = $detalle[$i]['idProducto'];
          $concepto = $detalle[$i]['concepto'];
          $descripcion = $detalle[$i]['descripcion'];
          $cantidad = $detalle[$i]['cantidad'];
          $precioVenta = $detalle[$i]['precioVenta'];
          $precio = $detalle[$i]['precio'];
          $importe = $detalle[$i]['importe'];
          $descuento = $detalle[$i]['descuento'];
          $iva_d = $detalle[$i]['iva_d'];
          if( $iva > 0 ){
            $totalIva = $importe*($iva/100);
            $importe = $importe+$totalIva;
          }

          if($precioVenta == null)
            $precioVenta = 0;

          $marca = $detalle[$i]['marca'];
          $talla = isset($detalle[$i]['talla']) ? $detalle[$i]['talla'] : '';
          $idFamiliaGasto = isset($detalle[$i]['idFamiliaGasto']) ? $detalle[$i]['idFamiliaGasto'] : 0;
          $idFamilia = isset($detalle[$i]['idFamilia']) ? isset($detalle[$i]['idFamilia']) : 0;
          

          //-- MGFS 21-01-2020 SE AGREGA ID AREA Y ID DEPARTAMENTO CUANDO ES SALIDA POR UNIFORME(S02)
          if($tipoSalida=='S02'){

            $buscaDepto="SELECT id_depto 
            FROM deptos 
            WHERE des_dep='RECLUTAMIENTO, SELECCION Y CONTRATACION' AND id_sucursal=".$idSucursal;
            $resultDepto = mysqli_query($this->link, $buscaDepto) or die(mysqli_error());
            $rowDepto=mysqli_fetch_array($resultDepto);

            $idDepartamento = $rowDepto['id_depto'];
            $idArea = 4;//--POR PARTE DE SECORP SE INGRESA ESTA AREA SIEMPRE
            $idFamiliaGasto = 43;
            //----MGFS 21-01-2020  LA CLASIFICACION SERA POR UNIDAD PERO SE VAN ASIGNANDO 
            //----YA QUE NO ESTA LIGADO A AUN ID UNIDAD SOLO AL ID FAMILIA GASTO PERO SOLO HAY 3 EN ESTE MOMENTO:
            //----116 - SECORP para unidad de negocio 1
            //----117 - REAL SHINY para unidad de negocio 4
            //----115 - GUARDERIAS para unidad de negocio  12
            if($idUnidadNegocio == 1){

              $idClasificacion = 116;

            }elseif($idUnidadNegocio == 4){

              $idClasificacion = 117;

            }elseif($idUnidadNegocio==12){

              $idClasificacion = 115;

            }else{
              $idClasificacion = isset($datos['idClasificacion']) ? $datos['idClasificacion'] : 0;
            }
          
          }
         
          //---NJES 30-01-2020 AGREGO UNA VALIDACION PARA VERICAR SI SE HACEN VENTAS A LA PAR Y NO VENDAN EL MISMO PRODUCTO 
          //--- AL MISMO TIENMPO 
          if($tipoSalida=='S07' && $ventasAlarmas==0){
            $verificaExistencia = new Ventas();
            $verificaE = $verificaExistencia->buscaProductoExistencia($idProducto,$idVenta);
            if($verificaE==0){ 
              $query = "INSERT INTO almacen_d (id_almacen_e,cve_concepto,id_producto,cantidad,precio,marca,talla,estatus,precio_venta,descuento_unitario,iva) 
                          VALUES ('$idSalida','$tipoSalida','$idProducto','$cantidad','$precio','$marca','$talla','A','$precioVenta','$descuento','$iva_d')";
              $resultD = mysqli_query($this->link, $query) or die(mysqli_error());
              $idAlmacenD = mysqli_insert_id($this->link);
            }else{
              $test.= ' - b1';
              $verifica = 0;
              break;
            }

          }else{

            //-->NJES April/08/2020 valida si el producto en la unidad y sucursal tiene existencia cuando es de tipo producto para poder hacer la salida
            $existenciaProd = "SELECT
                productos.id AS id,
                productos.servicio,
                IFNULL(IF(productos.servicio=0,SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),1),0) AS existencia
                FROM productos
                INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
                LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=$idSucursal AND estatus!='C'
                LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = productos.id
                WHERE productos_unidades.id_unidades=$idUnidadNegocio AND productos.id=$idProducto
                GROUP BY productos.id
                HAVING existencia>0";
            $resultProd = mysqli_query($this->link, $existenciaProd) or die(mysqli_error());
            $numRProd = mysqli_num_rows($resultProd);
            
            //if($numRProd > 0)
            if($resultProd)
            {
              $query = "INSERT INTO almacen_d (id_almacen_e,cve_concepto,id_producto,cantidad,precio,marca,talla,estatus,precio_venta) 
              VALUES ('$idSalida','$tipoSalida','$idProducto','$cantidad','$precio','$marca','$talla','A', '$precioVenta')";
              $test.= ' - b7';
              $resultD = mysqli_query($this->link, $query) or die(mysqli_error());
              $idAlmacenD = mysqli_insert_id($this->link);
            }else{
              $test.= ' - b2' ;
              $verifica = 0;
              break;
            }

          }

          if($resultD){
            //'S02' --> SALIDA DE UNIFORME solo si es uniforme nuevo (donde Id_familia es igual a 9)
            //'S01' --> SALIDA DE STOCK 
            //'S05' --> SALIDA POR RESPONSIVA 
            //'S07' --> SALIDA POR VENTA STOCK Y SALIDA POR VENTA DE ALARMAS
            //'S06' -> SALIDA POR COMODATO
            //-->NJES June/18/2020 se agrega afectar presupuesto al generar una salida por comodato
            if($tipoSalida == 'S01' || $tipoSalida == 'S05' || $tipoSalida == 'S07' || $tipoSalida == 'S06' || ($tipoSalida == 'S02' && $idFamilia == 9))
            {
              //--MGFS 04-02-2020 SE AGREGAN DATOS DE SECORP ALARMAS PARA CLASIFICAR LAS VENTAS
              if($tipoSalida=='S07' && $ventasAlarmas==1){
                //-->NJES June/22/2020 se quita area y departamento al afcetar presupuesto egresos
                $idUnidadNegocio = 2;
                //$idDepartamento = 2911;
                //$idArea = 7;
                $idFamiliaGasto = 70; 
                $idClasificacion = 171;
              }

              //-->NJES June/17/2020 DEN18-2760 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
              //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
              $arr = array('idAlmacenD'=>$idAlmacenD,
                            'total'=>$importe,
                            'idUnidadNegocio'=>$idUnidadNegocio,
                            'idSucursal'=>$idSucursal,
                            'idFamiliaGasto'=>$idFamiliaGasto,
                            'clasificacionGasto'=>$idClasificacion,
                            'tipo'=>'C'
                          );

              //->Guarda en movimientos_presupuesto el movimiento, segun los registros guardados en almacen_d
              if($i == 1)
              {
                // $movP = $afectarPresupuesto->guardarMovimientoPresupuesto($arr); 

                // if($movP > 0) 
                //   $verifica = $folio;
                // else
                //   $verifica = 0;
                $verifica = $folio;

              }else{
                if($verifica > 0)
                {
                  // $movP = $afectarPresupuesto->guardarMovimientoPresupuesto($arr);

                  // if($movP > 0) 
                  //   $verifica = $folio;
                  // else
                  //   $verifica = 0;
                  $verifica = $folio;

                }else{
                  $test.= ' - b3';
                  $verifica = 0;
                  break;
                }
              }
            }else{
              if($i==$detalle[0])
              {
                $test.= ' - b4';
                $verifica = $folio;
                break;
              }
            }
          }else{
            $test.= ' - b5';
            $verifica = 0;
            break;
          }

        }
      }else{
        $verifica = 0;
      }

      return $verifica;//$test . ' ** ' . $detalle[0];// json_encode($datos['detalle']);/
      
    }//-- fin function guardarDetalle

    /**
      * Busca los registros de las salidas almacen
      * 
      * @param varchar $datos array que contiene datos para filtrar las Búsqueda de  des
      *
      **/ 
    function buscarSalidas($datos){
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $tipoSalida = $datos['tipoSalida'];

        $condicion='';

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND a.fecha >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        if($idSucursal != NULL)
        {
          $sucursal=" AND a.id_sucursal=".$idSucursal;
        }else{
          $sucursal='';
        }

        $result = $this->link->query("SELECT a.id,a.folio,a.cve_concepto,a.id_unidad_negocio,a.id_sucursal,c.descr AS sucursal,DATE(a.fecha) AS fecha,a.observacion,
                                        a.no_partidas as partidas,a.id_usuario_captura,b.usuario,SUM(d.precio*d.cantidad) AS importe_total,a.id_area
                                        FROM almacen_e a
                                        LEFT JOIN usuarios b ON a.id_usuario_captura=b.id_usuario
                                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                                        LEFT JOIN almacen_d d ON a.id=d.id_almacen_e
                                        LEFT JOIN cat_areas e ON a.id_area=e.id
                                        WHERE a.cve_concepto='$tipoSalida' AND a.id_unidad_negocio=".$idUnidadNegocio." $sucursal $condicion
                                        GROUP BY a.id
                                        ORDER BY a.id");

        return query2json($result);

    }//-- fin function buscarSalidas

    /**
      * Busca los datos del id indicado
      * 
      * @param int $idSalida del registro que se quieren los datos
      *
      **/ 
    function buscarSalidasId($idSalida){
        $result = $this->link->query("SELECT a.id,a.folio,a.folio_venta_stock,a.iva,a.cve_concepto,a.id_unidad_negocio,a.id_sucursal,
                                          DATE(a.fecha) AS fecha,a.observacion,a.id_clasificacion,a.id_sucursal_destino,
                                          a.id_proveedor,a.id_trabajador,b.nombre AS proveedor,CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido_p),' ',TRIM(c.apellido_m)) AS empleado,
                                          a.id_departamento,d.des_dep AS departamento,a.id_area,IFNULL(e.descripcion,'') AS area,
                                          IFNULL(CONCAT(TRIM(f.nombre),' ',TRIM(f.apellido_p),' ',TRIM(f.apellido_m)),'') AS supervisor,
                                          a.id_unidad_negocio_destino,
                                          a.id_cliente,
                                          a.clasificacion,
                                          g.nombre_comercial AS cliente,
                                          MAX(almacen_d.iva) AS iva_m,
                                          a.estatus,
                                          a.cambio_estatus,
                                          a.nombre_empleado AS nombreExterno
                                      FROM almacen_e a
                                      LEFT JOIN proveedores b ON a.id_proveedor=b.id
                                      LEFT JOIN trabajadores c ON a.id_trabajador=c.id_trabajador
                                      LEFT JOIN deptos d ON a.id_departamento=d.id_depto
                                      LEFT JOIN cat_areas e ON d.id_area=e.id
                                      LEFT JOIN trabajadores f ON d.id_supervisor=f.id_trabajador
                                      LEFT JOIN cat_clientes g ON a.id_cliente=g.id
                                      INNER JOIN almacen_d ON a.id=almacen_d.id_almacen_e
                                      WHERE a.id=".$idSalida);

        return query2json($result);
    }//-- fin function buscarSalidasI

    function buscarDetalleSalidasIdEdicion($idSalida)
    {
      
        $result = $this->link->query("SELECT 
                  a.id_producto,
                  a.precio,
                  a.precio_venta,
                  a.cantidad,
                  a.talla,a.marca,
                  b.concepto,
                  b.descripcion,
                  c.descripcion AS familia,
                  c.id AS id_familia,
                  c.id_familia_gasto,
                  d.descripcion AS linea, 
                  d.id AS id_linea,
                  (a.precio * a.cantidad) AS importe,
                  b.equivalente_usado,
                  IFNULL(co.cantidad, 0)  + IFNULL(ce.cantidad, 0) AS cantidad_usada,
                  (a.cantidad - (IFNULL(co.cantidad, 0)  + IFNULL(ce.cantidad, 0)))  AS cantidad_sobrante
                  FROM almacen_d a
                  LEFT JOIN productos b ON a.id_producto=b.id
                  LEFT JOIN familias c ON b.id_familia = c.id
                  LEFT JOIN lineas d ON b.id_linea = d.id
                  LEFT JOIN 
                  (
                    SELECT
                    a.id,
                    a.id_producto AS id_producto,
                    SUM(a.cantidad) AS cantidad,
                    a.talla AS talla,
                    a.marca AS marca,
                    a.id_almacen_e,
                    b.equivalente_usado
                    FROM almacen_d a
                    LEFT JOIN productos b ON a.id_producto=b.id
                    LEFT JOIN almacen_e e ON a.id_almacen_e = e.id
                    WHERE e.id_contrapartida = $idSalida
                    GROUP BY b.id, a.talla, a.marca
                  ) AS co ON b.id = co.id_producto AND a.talla = co.talla AND a.marca = co.marca
                  LEFT JOIN
                  (
                    SELECT
                    a.id,
                    a.id_producto AS id_producto,
                    SUM(a.cantidad) AS cantidad,
                    a.talla AS talla,
                    a.marca AS marca,
                    a.id_almacen_e,
                    b.equivalente_usado,
                    bb.id AS original
                    FROM almacen_d a
                    LEFT JOIN productos b ON a.id_producto=b.id
                    LEFT JOIN almacen_e e ON a.id_almacen_e = e.id
                    INNER JOIN productos bb ON b.id = bb.equivalente_usado
                    WHERE e.id_contrapartida = $idSalida
                    GROUP BY b.id, a.talla, a.marca
                  
                  ) ce ON b.id = ce.original AND a.talla = ce.talla AND a.marca = ce.marca
                  WHERE a.id_almacen_e= $idSalida
                  ORDER BY a.id");

        return query2json($result);

    }

    function cancelarSalidaTransferencia($folioSalida){
      $verificar = 0;

      $query="INSERT INTO almacen_d(id_almacen_e, cve_concepto, id_producto, cantidad, precio, marca, fecha_cad, iva)
              SELECT id_almacen_e, 'E10', id_producto, cantidad, precio, marca, fecha_cad, iva
                  FROM almacen_d
                  WHERE id_almacen_e IN (SELECT id
                      FROM almacen_e ae
                      WHERE folio = $folioSalida)
                      AND cve_concepto = 'S03';";
              
      $resul1 = mysqli_query($this->link, $query) or die(mysqli_error());

      if($resul1){

        $query = "UPDATE almacen_e
                  SET estatus='C'
                  WHERE folio=$folioSalida";

        $resul2 = mysqli_query($this->link, $query) or die(mysqli_error());

        $verificar = 1;
      }

      return $verificar;
    } //fin cancelarSalidaTransferencia


    /**
      * Busca las partidas del id indicado
      * 
      * @param int $idSalida del que se quiere las partidas
      *
      **/ 
    function buscarDetalleSalidasId($idSalida)
    {
      
        $result = $this->link->query("SELECT 
                  a.id_producto,
                  a.precio,
                  a.precio_venta,
                  a.cantidad,
                  a.talla,a.marca,
                  b.concepto,
                  b.descripcion,
                  c.descripcion AS familia,
                  c.id AS id_familia,
                  c.id_familia_gasto,
                  d.descripcion AS linea, 
                  d.id AS id_linea,
                  (a.precio * a.cantidad) AS importe,
                  b.equivalente_usado,
                  IFNULL(co.cantidad, 0)  + IFNULL(ce.cantidad, 0) AS cantidad_usada,
                  (a.cantidad - (IFNULL(co.cantidad, 0)  + IFNULL(ce.cantidad, 0)))  AS cantidad_sobrante,
                  a.descuento_unitario AS descuento,a.iva
                  FROM almacen_d a
                  LEFT JOIN productos b ON a.id_producto=b.id
                  LEFT JOIN familias c ON b.id_familia = c.id
                  LEFT JOIN lineas d ON b.id_linea = d.id
                  LEFT JOIN 
                  (
                    SELECT
                    a.id,
                    a.id_producto AS id_producto,
                    SUM(a.cantidad) AS cantidad,
                    a.talla AS talla,
                    a.marca AS marca,
                    a.id_almacen_e,
                    b.equivalente_usado
                    FROM almacen_d a
                    LEFT JOIN productos b ON a.id_producto=b.id
                    LEFT JOIN almacen_e e ON a.id_almacen_e = e.id
                    WHERE e.id_contrapartida = $idSalida
                    GROUP BY b.id, a.talla, a.marca
                  ) AS co ON b.id = co.id_producto AND a.talla = co.talla AND a.marca = co.marca
                  LEFT JOIN
                  (
                    SELECT
                    a.id,
                    a.id_producto AS id_producto,
                    SUM(a.cantidad) AS cantidad,
                    a.talla AS talla,
                    a.marca AS marca,
                    a.id_almacen_e,
                    b.equivalente_usado,
                    bb.id AS original
                    FROM almacen_d a
                    LEFT JOIN productos b ON a.id_producto=b.id
                    LEFT JOIN almacen_e e ON a.id_almacen_e = e.id
                    INNER JOIN productos bb ON b.id = bb.equivalente_usado
                    WHERE e.id_contrapartida = $idSalida
                    GROUP BY b.id, a.talla, a.marca
                  
                  ) ce ON b.id = ce.original AND a.talla = ce.talla AND a.marca = ce.marca
                  WHERE a.id_almacen_e= $idSalida
                  HAVING cantidad_sobrante > 0
                  ORDER BY a.id");

        return query2json($result);

    }//-- fin function buscarDetalleSalidasId

    /**
      * Busca las salidas por transferencia de sucursal para la sucursal seleccionada
      * 
      * @param int $idUnidadNegocio de la unidad de negocio seleccionada
      * @param int $idSucursal de la sucursal seleccionada
      * @param varchar $tipo de salida que se va a buscar
      *
    **/ 
    function buscarSalidasImportar($idUnidadNegocio,$idSucursal,$tipo){
      if($tipo == 'S03')
      {
        //-->NJES July/28/2020 si la unidad origen (id_unidad_negocio) es 13 o 1 (Ginthercorp y Secorp respectivamente),
        //la unidad destino (id_unidad_negocio_destino) será mayor a 0,
        //y si es mayor a 0 importar de la id_unidad_negocio_destino, sino de id_unidad_negocio que sera la de destino y origen
        $condUnidad = " AND IF(a.id_unidad_negocio_destino = 0,a.id_unidad_negocio=$idUnidadNegocio,a.id_unidad_negocio_destino=$idUnidadNegocio)";
        $condicion = " AND a.id_sucursal_destino=".$idSucursal;
      }else if($tipo == 'S02')
      {
        //-->NJES September/09/2020 buscar las salidas de uniformes de todas las sucursales  a las que tiene permiso el usuario en el modulo de la unidad seleccionada
        $condUnidad = " AND a.id_unidad_negocio=".$idUnidadNegocio;

        $dato=substr($idSucursal,1);
        //$condicion = ' AND a.id_sucursal IN('.$dato.') ';
        $condicion = ' AND a.id_sucursal IN('.$idSucursal.') ';
        
      }else{
        $condUnidad = " AND a.id_unidad_negocio=".$idUnidadNegocio;
        $condicion = " AND a.id_sucursal=".$idSucursal;
      }


      if($idSucursal != '')
      {
          $result = $this->link->query("SELECT a.id,
                                    a.folio,
                                    DATE(a.fecha) AS fecha,
                                    a.id_unidad_negocio,
                                    b.nombre AS unidad,
                                    a.id_sucursal,
                                    c.descr AS sucursal,
                                    IFNULL(k.descr,'') AS sucursal_destino,
                                    IFNULL(IF(a.id_unidad_negocio_destino = 0,b.nombre,l.nombre),'') AS unidad_destino,
                                    a.id_proveedor,
                                    a.id_trabajador,
                                    d.nombre AS proveedor,
                                    CONCAT(TRIM(e.nombre),' ',TRIM(e.apellido_p),' ',TRIM(e.apellido_m)) AS empleado,
                                    f.cantidad,
                                    SUM(f.precio * f.cantidad) AS importe,
                                    a.id_departamento,
                                    IFNULL(j.des_dep,'') AS departamento,
                                    a.no_partidas,
                                    a.id_area,
                                    IFNULL(ar.descripcion,'') AS area,
                                    a.id_cliente,
                                    a.clasificacion,
                                    CASE
                                        WHEN a.clasificacion = 1 THEN 'Regalos a empleados del mes'
                                        WHEN a.clasificacion = 2 THEN 'Regalos cumpleaños a oficiales'
                                        WHEN a.clasificacion = 3 THEN 'Regalos a clientes'
                                        WHEN a.clasificacion = 4 THEN 'Muestras / degustaciones'
                                        WHEN a.clasificacion = 5 THEN 'Suplementos jugadores'
                                        WHEN a.clasificacion = 6 THEN 'Equipo médico'
                                        WHEN a.clasificacion = 7 THEN 'Uniformes jugadores'
                                        WHEN a.clasificacion = 8 THEN 'Otro'
                                        ELSE ''
                                    END AS clasificacion_stock,
                                    g.nombre_comercial AS cliente
                                    FROM almacen_e a
                                    LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                                    LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                                    LEFT JOIN sucursales k ON a.id_sucursal_destino=k.id_sucursal
                                    LEFT JOIN proveedores d ON a.id_proveedor=d.id
                                    LEFT JOIN trabajadores e ON a.id_trabajador=e.id_trabajador
                                    LEFT JOIN almacen_d f ON a.id=f.id_almacen_e
                                    LEFT JOIN deptos j ON a.id_departamento=j.id_depto
                                    LEFT JOIN cat_areas ar ON j.id_area=ar.id
                                    LEFT JOIN cat_unidades_negocio l ON a.id_unidad_negocio_destino=l.id
                                    LEFT JOIN cat_clientes g ON a.id_cliente=g.id
                                    WHERE 1 $condUnidad $condicion AND a.cve_concepto='$tipo' AND a.id_contrapartida=0
                                    GROUP BY a.id");

        return query2json($result);

      }
      else
      {
        $arr = array();

        return json_encode($arr);
      }

    }//-- fin function buscarSalidasTransaccionesImportar

     /**
      * Busca los registros de las salidas almacen
      * 
      * @param varchar $datos array que contiene datos para filtrar las Búsqueda de  des
      *
      **/ 
      function buscarSalidasVentaStock($datos){
        
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $tipoSalida = $datos['tipoSalida'];

        $condicion='';

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND a.fecha >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        if($idSucursal != NULL)
        {
          $sucursal=" AND a.id_sucursal=".$idSucursal;
        }else{
          $sucursal='';
        }

        $query = "SELECT a.id,a.folio,a.folio_venta_stock as folio_venta,a.iva,a.cve_concepto,a.id_unidad_negocio,a.id_sucursal,c.descr AS sucursal,DATE(a.fecha) AS fecha,a.observacion,
                a.no_partidas as partidas,a.id_usuario_captura,b.usuario,
                IF(a.iva=0,SUM(d.precio_venta*d.cantidad),(SUM(d.precio_venta*d.cantidad)+(SUM(d.precio_venta*d.cantidad)*(a.iva/100)))) AS importe_total,
                SUM(d.precio_venta*d.cantidad) as subtotal,
                SUM(d.precio_venta*d.cantidad)*(a.iva/100) as total_iva,
                a.id_area,
                SUM(d.cantidad*d.descuento_unitario) AS descuento_total_d,
                SUM((d.precio_venta*d.cantidad)*(d.iva/100)) as total_iva_d,
                SUM(d.precio_venta*d.cantidad)+SUM((d.precio_venta*d.cantidad)*(d.iva/100)) AS importe_total_d
                FROM almacen_e a
                LEFT JOIN usuarios b ON a.id_usuario_captura=b.id_usuario
                LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                LEFT JOIN almacen_d d ON a.id=d.id_almacen_e
                LEFT JOIN cat_areas e ON a.id_area=e.id
                WHERE a.cve_concepto='$tipoSalida' AND a.id_unidad_negocio=".$idUnidadNegocio." $sucursal $condicion
                GROUP BY a.id
                ORDER BY a.id";

        // echo $query;
        // exit();


        $result = $this->link->query($query);

        return query2json($result);

    }//-- fin function buscarSalidas

    function buscarCantidadActualSalida($idSalida){
      $busca = "SELECT IFNULL(GROUP_CONCAT(id),'') AS ids_e FROM almacen_e WHERE id_contrapartida=".$idSalida;
      $resultF = mysqli_query($this->link, $busca) or die(mysqli_error());
      
      $datosX=mysqli_fetch_array($resultF);

      if($datosX['ids_e'] != '')
      {
        $ids_e = $datosX['ids_e'];
      }else
        $ids_e = 'SELECT GROUP_CONCAT(id) AS ids_e FROM almacen_e WHERE id_contrapartida='.$idSalida.'';

      $result = $this->link->query("SELECT SUM(a.cantidad) AS cantidad,
        SUM(IFNULL(usad.cantidad,0)) AS cantidad_usada,
        SUM((a.cantidad-IFNULL(usad.cantidad,0))) AS cantidad_sobrante
        FROM almacen_d a
        LEFT JOIN productos b ON a.id_producto=b.id
        LEFT JOIN (
          SELECT a.id,a.id_producto,SUM(a.cantidad) AS cantidad,a.id_almacen_e,b.equivalente_usado
          FROM almacen_d a
          LEFT JOIN productos b ON a.id_producto=b.id
          WHERE a.id_almacen_e IN (".$ids_e.")
          GROUP BY a.id_producto ORDER BY a.id
          ) AS usad ON (a.id_producto=usad.id_producto || b.equivalente_usado=usad.id_producto)
        WHERE a.id_almacen_e=$idSalida
        HAVING cantidad_sobrante > 0
        ORDER BY a.id"); 

      return query2json($result);
  }//-- fin function buscarCantidadActualSalida

  function buscarSalidasVentaLibres($datos){
      $idUnidadNegocio = $datos['idUnidadNegocio'];
      $idSucursal = $datos['idSucursal'];
      $tipoSalida = $datos['tipoSalida'];

      $query = "SELECT a.id,
                      a.folio,
                      a.folio_venta_stock AS folio_venta,
                      b.nombre AS unidad,
                      c.descr AS sucursal,
                      DATE(a.fecha) AS fecha,
                      a.no_partidas AS partidas,
                      a.observacion,
                      IF(a.iva=0,SUM(d.precio_venta*d.cantidad),(SUM(d.precio_venta*d.cantidad)+(SUM(d.precio_venta*d.cantidad)*(a.iva/100)))) AS importe_total
                FROM almacen_e a
                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                LEFT JOIN almacen_d d ON a.id=d.id_almacen_e
                LEFT JOIN facturas e ON a.id=e.id_almacen_e
                WHERE a.cve_concepto='$tipoSalida' 
                AND a.id_unidad_negocio=$idUnidadNegocio
                AND a.id_sucursal=$idSucursal
                AND a.estatus='A'
                AND e.id_almacen_e IS NULL
                GROUP BY a.id
                ORDER BY a.id";

      // echo $query;
      // exit();

      $result = $this->link->query($query);

      return query2json($result);
  }//-- fin function buscarSalidasVentaLibres

  function buscarPartidasSalidasVenta ($datos){
    $idFolioVenta = $datos['idFolioVenta'];
    $idSucursal = $datos['idSucursal'];
    $tipoSalida = $datos['tipoSalida'];

    $query = "SELECT ad.cantidad, pr.concepto, pr.costo, pr.iva
              FROM almacen_d ad
              INNER JOIN almacen_e ae ON ae.id = ad.id_almacen_e
              INNER JOIN productos pr ON pr.id = ad.id_producto
              where ad.cve_concepto = '$tipoSalida'
                AND ae.folio_venta_stock IN ($idFolioVenta)
                  AND ae.id_sucursal = $idSucursal;";

    // echo $query;
    // exit();

    $result = $this->link->query($query);

    return query2json($result);
  }

}//--fin de class OrdenCompra
    
?>