<?php

require_once('conectar.php');
require_once('MovimientosPresupuesto.php');

class EntradasAlmacen
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function EntradasAlmacen()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Manda llamar a la funcion que guarda la informacion de las entradas de almacen
      * 
      * @param array $datos contiene los datos de la orden a aguardar o auctualizar
      *
    **/      
    function guardarEntradas($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if((int)$verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarEntradas


    /**
      * Guarda los datos de entradas almacen, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param varchar $datos contiene los parametros a guardar/actualizar
      *
      **/ 
      function guardarActualizar($datos){
        // print_r($datos);
        // exit();
       
        $verifica = 0;

        $tipoEntrada = $datos['tipoEntrada'];
        $idEntrada = $datos['idEntrada'];
        $folio = $datos['folio'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $fecha = $datos['fecha'];
        $idUsuario = $datos['idUsuario'];
        $noPartidas = $datos['noPartidas'];
        $detalle = $datos['detalle'];
        $usuario = $datos['usuario'];

        $observacion = isset($datos['observacion']) ? $datos['observacion'] : '';
        $idProveedor = isset($datos['idProveedor']) ? $datos['idProveedor'] : 0;
        $idContrapartida = isset($datos['idContrapartida']) ? $datos['idContrapartida'] : 0;
        $idEmpleado = isset($datos['idEmpleado']) ? $datos['idEmpleado'] : 0;
        $idDepartamento = isset($datos['idDepartamento']) ? $datos['idDepartamento'] : 0;

        //-->NJES March/31/2020 se obtiene la cantidad total de productos de las partidas y la usada
        $cantidadT = isset($datos['cantidad_total']) ? $datos['cantidad_total'] : 0;
        $cantidadTotalUsada = isset($datos['cantidad_total_usada']) ? $datos['cantidad_total_usada'] : 0;
        
        //-->NJES November/06/2020 datos faltantes para generar la entrada por stock
        $idCliente = isset($datos['idCliente']) ? $datos['idCliente'] : 0;
        $clasificacion = isset($datos['clasificacion']) ? $datos['clasificacion'] : '';
        $idArea = isset($datos['idArea']) ? $datos['idArea'] : 0;

        $queryFolio="SELECT folio_entrada_almacen FROM cat_unidades_negocio WHERE id=".$idUnidadNegocio;
        $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
        if($resultF)
        {
          $datos=mysqli_fetch_array($resultF);
          $folioA=$datos['folio_entrada_almacen'];
          $folio= $folioA+1;

          $queryU = "UPDATE cat_unidades_negocio SET folio_entrada_almacen='$folio' WHERE id=".$idUnidadNegocio;
          $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
          if($resultU)
          {
              $query = "INSERT INTO almacen_e (folio,cve_concepto,id_compania,id_unidad_negocio,id_sucursal,observacion,id_usuario_captura,usuario_captura,no_partidas,id_proveedor,id_trabajador,id_contrapartida,id_departamento,id_area,id_cliente,clasificacion) 
              VALUES ('$folio','$tipoEntrada','$idUnidadNegocio','$idUnidadNegocio','$idSucursal','$observacion','$idUsuario','$usuario','$noPartidas','$idProveedor','$idEmpleado','$idContrapartida','$idDepartamento','$idArea','$idCliente','$clasificacion')";
              $result = mysqli_query($this->link, $query) or die(mysqli_error());
              $idEntrada = mysqli_insert_id($this->link);
                  
              if($result)
              { 
                  //-->NJES March/31/2020 solo se actualizara si ya se han usado todas las cantidades de las partidasde la salida
                  $updateC="UPDATE almacen_e SET cambio_estatus = 'A' WHERE id=$idContrapartida";
                  $resultC = mysqli_query($this->link, $updateC) or die(mysqli_error());

                  if($resultC)
                  {
                    $verifica = $this -> guardarDetalle($idEntrada,$tipoEntrada,$folio,$detalle,$idContrapartida,$cantidadT,$cantidadTotalUsada);
                  }else{
                    $verifica = 0;
                  }
                
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
      * @param int $idEntrada id del registro al que pertenecen las partidas
      * @param varchar $tipoEntrada tipo de entrada a guardar
      * @param int $folio id del movimiento que se genero, segun el id de la unidad de negocio
      * @param varchar $detalle array que contiene los datos de las partidas que s einsertaran
      *
      **/ 
    function guardarDetalle($idEntrada,$tipoEntrada,$folio,$detalle,$idContrapartida,$cantidadT,$cantidadTotalUsada){
  
      $verifica=0;

      //$cantidadO = 0;
      $cantidadN = 0;
      //$cantidadU = 0;

      $queryBorra = "DELETE FROM almacen_d WHERE id_almacen_e=".$idEntrada;
      $result = mysqli_query($this->link, $queryBorra) or die(mysqli_error());
     
      for($i=1;$i<=$detalle[0];$i++){

        $idProducto = $detalle[$i]['idProducto'];
        $concepto = $detalle[$i]['concepto'];
        $descripcion = $detalle[$i]['descripcion'];
        $cantidad = $detalle[$i]['cantidad'];
        $precio = $detalle[$i]['precio'];
        //$importe = $detalle[$i]['importe'];
        $importe = $cantidad * $precio; //->las entradas pueden ser parciales
        $marca = $detalle[$i]['marca'];
        $idFamiliaGasto = isset($detalle[$i]['idFamiliaGasto']) ? $detalle[$i]['idFamiliaGasto'] : 0;
        //-->NJES March/31/2020 voy sumando las cantidades usadas, originales y la indicada en el input de la partida
        //para saber si ya se usaron todas las de la salida seleccionada
        //$cantidad_usada = isset($detalle[$i]['cantidad_usada']) ? $detalle[$i]['cantidad_usada'] : 0;
        //$cantidadU = $cantidadU+$cantidad_usada;
        //$cantidad_original = isset($detalle[$i]['cantidad_original']) ? $detalle[$i]['cantidad_original'] : 0;
        //$cantidadO = $cantidadO+$cantidad_original;

        $talla = isset($detalle[$i]['talla']) ? $detalle[$i]['talla'] : '';
        $familia_usados = isset($detalle[$i]['familia_usados']) ? $detalle[$i]['familia_usados'] : 0;

        $familiaAnterior = isset($detalle[$i]['familiaAnterior']) ? $detalle[$i]['familiaAnterior'] : '';

        $query = "INSERT INTO almacen_d (id_almacen_e,cve_concepto,id_producto,cantidad,precio,talla,marca,estatus) 
                    VALUES ('$idEntrada','$tipoEntrada','$idProducto','$cantidad','$precio','$talla','$marca','A')";
        $resultD = mysqli_query($this->link, $query) or die(mysqli_error());
        $idAlmacenD = mysqli_insert_id($this->link);

        if($resultD){
          $cantidadN = $cantidadN+$cantidad;

          if($tipoEntrada == 'E08'){
            $query = "INSERT INTO almacen_d (id_almacen_e,cve_concepto,id_producto,cantidad,precio,talla,marca,estatus) 
                        SELECT '$idEntrada', 'S08', pr.id_materia_prima, pr.cantidad*$cantidad,'$precio','$talla','$marca','A'
                        FROM productos_relacion pr
                        WHERE pr.id_producto_terminado = $idProducto";
                        
            $resultE = mysqli_query($this->link, $query) or die(mysqli_error());
            
            if($resultE){
              $verifica = $folio;
            }
          }

          if($familia_usados == 1 && $familiaAnterior != 'UNIFORMES USADOS'){
             
            if($this->actualizaProducto($idAlmacenD, $idProducto) == true )
              $verifica = $folio;
            else
            {
              $verifica = 0;
              break;
            }

          }else{

              if($tipoEntrada == 'E02')
              {
                // $busca = "SELECT id_unidad_negocio,id_sucursal,id_departamento,id_area 
                //         FROM almacen_e WHERE id=$idEntrada";
                // $result1 = mysqli_query($this->link, $busca) or die(mysqli_error());
                // $row1 = mysqli_fetch_array($result1);
          
                // $idUnidadNegocio = $row1['id_unidad_negocio'];
                // $idSucursal = $row1['id_sucursal'];
                // //$idDepartamento = $row1['id_departamento'];
                // //$idArea = $row1['id_area'];

                // //-- MGFS 21-01-2020 SE AGREGA ID AREA Y ID DEPARTAMENTO CUANDO ES ENTRADA POR DEVOLUCION DE UNIFORME(E02)
                // $buscaDepto="SELECT id_depto 
                // FROM deptos 
                // WHERE des_dep='RECLUTAMIENTO, SELECCION Y CONTRATACION' AND id_sucursal=".$idSucursal;
                // $resultDepto = mysqli_query($this->link, $buscaDepto) or die(mysqli_error());
                // $rowDepto=mysqli_fetch_array($resultDepto);

                // $idDepartamento = $rowDepto['id_depto'];
                // $idArea = 4;//--POR PARTE DE SECORP SE INGRESA ESTA AREA SIEMPRE
                // $idFamiliaGasto = 43;
                // //----MGFS 21-01-2020  LA CLASIFICACION SERA POR UNIDAD PERO SE VAN ASIGNANDO 
                // //----YA QUE NO ESTA LIGADO A AUN ID UNIDAD SOLO AL ID FAMILIA GASTO PERO SOLO HAY 3 EN ESTE MOMENTO:
                // //----116 - SECORP para unidad de negocio 1
                // //----117 - REAL SHINY para unidad de negocio 4
                // //----115 - GUARDERIAS para unidad de negocio  12
                // if($idUnidadNegocio == 1){

                //   $idClasificacion = 116;

                // }elseif($idUnidadNegocio == 4){

                //   $idClasificacion = 117;

                // }elseif($idUnidadNegocio==12){

                //   $idClasificacion = 115;

                // }else{
                //   $idClasificacion = isset($datos['idClasificacion']) ? $datos['idClasificacion'] : 0;
                // }
                

                // $importeC = $importe/**(-1)*/;

                // //-->NJES June/17/2020 DEN18-2760 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
                // //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
                // $arr = array('idAlmacenD'=>$idAlmacenD,
                //             'total'=>$importeC,
                //             'idUnidadNegocio'=>$idUnidadNegocio,
                //             'idSucursal'=>$idSucursal,
                //             'idFamiliaGasto'=>$idFamiliaGasto,
                //             'clasificacionGasto'=>$idClasificacion,
                //             'tipo'=>'C'
                //           );

                // $afectarPresupuesto = new MovimientosPresupuesto();

                // $movP = $afectarPresupuesto->guardarMovimientoPresupuesto($arr); 

                // if($movP > 0)
                // {
                //   if($i==$detalle[0])
                //   {
                //     $verifica = $folio;
                //     break;
                //   }
                // }else{
                //   $verifica = 0;
                //   break;
                // }
                //19/Julio/2022 GCM se comenta todo lo de afectar presupuesto
                $verifica = $folio;

              }else{
                if($i==$detalle[0])
                {
                  $verifica = $folio;
                  break;
                }
              }
            }

        }else{
          $verifica = 0;
          break;
        }

      }

      //-->NJES March/31/2020 cuando ya se hyan usado todas las cantidades de las partidas de una salida 
      //se actualizará la salida con los ids de las entradas en las que se uso
      if($verifica > 0)
      {
        //-->NJES July/28/2020 se agrega entrada por responsiva para que se puedan hacer entradas parciales,
        //y se actualice la contrapartida del almacen cuando se hayan usado todas las cantidades
        if($tipoEntrada == 'E02' || $tipoEntrada == 'E05' || $tipoEntrada == 'E07')
        {
          if($cantidadT == ($cantidadN+$cantidadTotalUsada))
          {
            $buscaIds = "SELECT IFNULL(GROUP_CONCAT(id),'') AS ids_entradas FROM almacen_e WHERE id_contrapartida=".$idContrapartida;
            $resultP = mysqli_query($this->link,$buscaIds) or die(mysqli_error());
            
            $rowP = mysqli_fetch_assoc($resultP);
            $ids_entradas = $rowP['ids_entradas'];

            if($ids_entradas != '')
            {
              $updateC="UPDATE almacen_e SET id_contrapartida='$ids_entradas' WHERE id=$idContrapartida";
              $resultC = mysqli_query($this->link, $updateC) or die(mysqli_error());

              if($resultC)
              {
                $verifica = $folio;
              }else
                $verifica = 0;
            }else
              $verifica = 0;

          }else
            $verifica = $folio;
        }else{
          $updateC="UPDATE almacen_e SET id_contrapartida='$idEntrada' WHERE id=$idContrapartida";
          $resultC = mysqli_query($this->link, $updateC) or die(mysqli_error());

          if($resultC)
            $verifica = $folio;
          else
            $verifica = 0;
          
        }
      }

      return $verifica;
      
    }//-- fin function guardarDetalle

    function actualizaProducto($idDE, $idProducto)
    {

      $verifica = false;
      $resultP = mysqli_query($this->link, "SELECT  equivalente_usado as equivalente_usado FROM productos WHERE id = $idProducto");
      $rowP = mysqli_fetch_assoc($resultP);

      if((int)$rowP['equivalente_usado'] > 0)
      {

        $idEquivalente = $rowP['equivalente_usado'];
        $resultU = mysqli_query($this->link, "UPDATE almacen_d SET id_producto = $idEquivalente WHERE id = $idDE") or die(mysqli_error());


        if($resultU)  // mysqli_affected_rows($this->link)     
          $verifica = true;


      }

      return  $verifica;

    }

    /**
      * Busca los registros de las entradas almacen
      * 
      * @param varchar $datos array que contiene datos para filtrar las Búsqueda de  des
      *
      **/ 
    function buscarEntradas($datos){
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $tipoEntrada = $datos['tipoEntrada'];

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
          $sucursal= '';
        }

        $result = $this->link->query("SELECT a.id,a.folio,a.cve_concepto,a.id_unidad_negocio,a.id_sucursal,c.descr AS sucursal,DATE(a.fecha) AS fecha,a.observacion,
                    a.no_partidas as partidas,a.id_usuario_captura,b.usuario,SUM(d.precio*d.cantidad) AS importe_total
                    FROM almacen_e a
                    LEFT JOIN usuarios b ON a.id_usuario_captura=b.id_usuario
                    LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                    LEFT JOIN almacen_d d ON a.id=d.id_almacen_e
                    WHERE a.cve_concepto='$tipoEntrada' AND a.id_unidad_negocio=".$idUnidadNegocio." $sucursal $condicion
                    GROUP BY a.id
                    ORDER BY a.id");

        return query2json($result);

    }//-- fin function buscarEntradas

    /**
      * Busca los datos del id indicado
      * 
      * @param int $idEntrada del registro que se quieren los datos
      *
      **/ 
    function buscarEntradasId($idEntrada){
      $query = "SELECT a.id,a.folio,a.cve_concepto,a.id_unidad_negocio,a.id_sucursal,
      DATE(a.fecha) AS fecha,a.observacion,a.id_proveedor,a.id_trabajador,
      b.nombre AS proveedor,CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido_p),' ',TRIM(c.apellido_m)) AS empleado,
      a.id_departamento,
      d.des_dep AS departamento,
      a.id_area,
      IFNULL(e.descripcion,'') AS area,
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
      LEFT JOIN proveedores b ON a.id_proveedor=b.id
      LEFT JOIN trabajadores c ON a.id_trabajador=c.id_trabajador
      LEFT JOIN deptos d ON a.id_departamento=d.id_depto
      LEFT JOIN cat_areas e ON d.id_area=e.id
      LEFT JOIN cat_clientes g ON a.id_cliente=g.id
      WHERE a.id=".$idEntrada;

      // echo $query;
      // exit();

      $result = $this->link->query($query);

      return query2json($result);
    }//-- fin function buscarEntradasId

    /**
      * Busca las partidas del id indicado
      * 
      * @param int $idEntrada del que se quiere las partidas
      *
      **/ 
    function buscarDetalleEntradasId($idEntrada){
        $result = $this->link->query("SELECT a.id_producto,a.precio,a.cantidad,a.talla,a.marca,
                                        b.concepto,b.descripcion,c.descripcion AS familia,c.id AS id_familia, 
                                        d.descripcion AS linea, d.id AS id_linea,(a.precio * a.cantidad) AS importe
                                        FROM almacen_d a
                                        LEFT JOIN productos b ON a.id_producto=b.id
                                        LEFT JOIN familias c ON b.id_familia = c.id
                                        LEFT JOIN lineas d ON b.id_linea = d.id
                                        WHERE a.id_almacen_e=".$idEntrada."
                                        ORDER BY a.id");

        return query2json($result);
    }//-- fin function buscarDetalleEntradasId

}//--fin de class OrdenCompra
    
?>