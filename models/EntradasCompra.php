<?php

include_once('conectar.php');
require_once('MovimientosPresupuesto.php');

class EntradasCompra
{

    public $link;

    function EntradasCompra()
    {
  
      $this->link = Conectarse();

    }
    

    function guardarEntradasCompra($entradaA, $entradaD)
    {
    
      $verifica = 0;

      $idUnidad = $entradaA['idUnidadNegocio'];
      $idSucursal = $entradaA['idSucursal'];
      $idProveedor = $entradaA['idProveedor'];
      $idUsuario = $entradaA['idUsuario'];
      $usuario = $entradaA['usuario'];
      $idOrden = $entradaA['idOrden'];
      $tipoMov = $entradaA['tipoMov'];
      $noEconomico = $entradaA['noEconomico'];
      $servicio = $entradaA['servicio'];
      $tipoOC = $entradaA['tipoOC'];
      //-->NJES Feb/13/2020 se reciben id de area y departamento para afcetar presupuesto cuando sea una entrada de tipo mantenimiento
      $idArea = $entradaA['idArea'];
      $idDepartamento = $entradaA['idDepartamento'];
      $importe = $entradaA['importe'];
      $foliosRequis = $entradaA['foliosRequis'];
      $idsRequis = $entradaA['idsRequis'];

      $noPartidas = $entradaA['noPartidas'];
      
     
      $folio = $this->obtenerFolio($idUnidad) + 1;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

        $query = "INSERT INTO almacen_e 
            (folio, id_compania, id_sucursal, id_proveedor, cve_concepto, id_unidad_negocio, id_oc, id_usuario_captura, usuario_captura, no_partidas, vehiculo, recepcion_servicio, tipo_oc)
            VALUES($folio, $idSucursal, $idSucursal, $idProveedor, 'E01', '$idUnidad', '$idOrden', $idUsuario, '$usuario', '$noPartidas', '$noEconomico', '$servicio', '$tipoOC')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idE01 = mysqli_insert_id($this->link);

        if($result)
        {
          $idEntradaCompra = mysqli_insert_id($this->link);

          /*if($tipoOC==2){
            $this->guardaBitacoraActivos($idOrden,$noEconomico,$foliosRequis,$idsRequis);
          }*/

          if($this->actualizarFolio($idUnidad, $folio))
          {
            if($this->guardarDetalles($idUnidad, $idEntradaCompra, $entradaD, $tipoOC))
            {
              //-->NJES Feb/13/2020 si es de tipo mantenimiento afectar presupuesto al generar la entrada almacen
              if($tipoOC==2)
              {
                if($this->guardaBitacoraActivos($idOrden,$noEconomico,$foliosRequis,$idsRequis))
                {
                  //-->NJES June/19/2020 DEN18-2760 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
                  //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
                  
                  $afectarPresupuesto = new MovimientosPresupuesto();

                  //-->NJES November/11/2020 afecatr presupuesto por la cantidad del importe total menos el importe del flete de la requi 
                  //en caso de que tenga partidas con familia fletes y logistica (id 104), ya que se afecta al generar los detalles de almacen
                  $buscaTF = "SELECT IFNULL(SUM(orden_compra_d.costo_total),0) AS total_flete
                    FROM orden_compra_d
                    LEFT JOIN productos  ON orden_compra_d.id_producto=productos.id
                    LEFT JOIN familias ON productos.id_familia=familias.id
                    WHERE orden_compra_d.id_orden_compra=$idOrden AND familias.id_familia_gasto=104";

                  $resultTF = mysqli_query($this->link, $buscaTF) or die(mysqli_error());
                  $rowTF = mysqli_fetch_array($resultTF);
                  $total_flete = $rowTF['total_flete'];

                  $arr = array(
                            'total'=>$importe-$total_flete, 
                            'idUnidadNegocio'=>$idUnidad,
                            'idSucursal'=>$idSucursal,
                            'idFamiliaGasto'=>27, //--> familia gasto (MANTENIMIENTO)
                            'clasificacionGasto'=>88, //--> id clasificacion gasto (EQUIPO DE TRANSPORTE)
                            'idEntradaCompra'=>$idE01,
                            'tipo'=>'C');

                  $movP = $afectarPresupuesto->guardarMovimientoPresupuesto($arr);

                  if($movP > 0)
                    $verifica = $folio;
                  else
                    $verifica = 0;

                }else
                  $verifica = 0;
              }else
                $verifica = $folio;

            }
          }else
            $verifica = 0;
          
        }else
          $verifica = 0;
      

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        //return json_encode(array('id'=>$idEntradaCompra, 'folio'=>$folio));
        return $verifica;

    }


    /**
      * Obtiene el folio actual de las almacen_d
      *
      * @param int $idUnidad
      *
      **/ 
    function obtenerFolio($idUnidad)
    {

      $result = mysqli_query($this->link, "SELECT folio_entrada_almacen FROM cat_unidades_negocio WHERE id =$idUnidad");
      $row = mysqli_fetch_assoc($result);
      return $row['folio_entrada_almacen'];
    }


    /**
      * Actualiza el folio actual de las Entrada Comptra
      *
      * @param int $idUnidad
      * @param int $folio
      *
      **/
    function actualizarFolio($idUnidad, $folio)
    {
      $result = mysqli_query($this->link, "UPDATE cat_unidades_negocio SET folio_entrada_almacen = $folio WHERE id = $idUnidad");
      return $result;
    }

    /**
      * Guardar los detalles de la almacen_d, esta función es usada para guardar y para editar
      *
      * @param array $entradaA
      * @param array $entradaD
      *
      **/
    function guardarDetalles($idUnidad, $idEntradaCompra, $entradaD, $tipoOC)
    {

      $verifica = 0;

      $afectarPresupuesto = new MovimientosPresupuesto();

      foreach($entradaD as $detalle)
      {

          $idAlmacenD = $detalle['idAlmacenD'];
          $idProducto = $detalle['idProducto'];
          $precio = $detalle['costo'];
          $cantidad = $detalle['cantidad'];
          $iva = $detalle['iva'];
          $descuento = $detalle['descuento'];
          $idOrden = $detalle['idOrden'];
          $partida = $detalle['nPartida'];
          $llevaTallas = $detalle['llevaTallas'];
          $tallas = $detalle['tallas'];
          $id_familia_gasto = $detalle['id_familia_gasto'];
          $importe = $detalle['importe'];

          $actulizaPrecio="UPDATE productos_unidades SET ultimo_precio_compra='$precio', ultima_fecha_compra=CURRENT_DATE()
          WHERE  id_producto=".$idProducto. " AND id_unidades=".$idUnidad; 
          $resultAcutializa = mysqli_query($this->link, $actulizaPrecio) or die(mysqli_error());

          $actulizaCostoP="UPDATE productos SET costo='$precio' WHERE  id=".$idProducto; 
          $resultActulizaCostoP = mysqli_query($this->link, $actulizaCostoP) or die(mysqli_error());

          $guardaPrecioPB="INSERT INTO productos_bitacora (modulo,id_producto,nuevo_costo,id_usuario_captura,id_unidad_negocio)values('ENTRADA_COMPRA','$idProducto','$precio','$idUsuario','$idUnidad')"; 
          $resultGuardaPrecioPB = mysqli_query($this->link, $guardaPrecioPB) or die(mysqli_error());

          $actulizaDetalleOc="UPDATE orden_compra_d SET cantidad_entrega=(cantidad_entrega+'$cantidad') WHERE id=".$idAlmacenD; 
          $resultActuializaOc = mysqli_query($this->link, $actulizaDetalleOc) or die(mysqli_error());

          $query = " INSERT INTO almacen_d (id_almacen_e, cve_concepto, id_producto, cantidad, precio, id_oc, partida, iva, lleva_talla, id_oc_d,porcentaje_descuento) 
            VALUES ($idEntradaCompra,'E01', '$idProducto', '$cantidad', '$precio', '$idOrden', '$partida', '$iva', '$llevaTallas', '$idAlmacenD', '$descuento')";

          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idDetalle = mysqli_insert_id($this->link);

          if($result)
          {
              $arr = array(
                        'total'=>$importe, 
                        'idUnidadNegocio'=>$idUnidad,
                        'idSucursal'=>$idSucursal,
                        'idFamiliaGasto'=>104, //--> familia gasto (FLETES Y LOGISTICA)
                        'clasificacionGasto'=>295, //--> id clasificacion gasto (NO APLICA)
                        'idEntradaCompra'=>$idEntradaCompra,
                        'idAlmacenD'=>$idDetalle,
                        'tipo'=>'C');

            if($tallas != '')
            {

              $tallaArray = json_decode($tallas, true);
              foreach($tallaArray as $tA)
              {

                $tallaD = $tA['talla'];
                $cantidadD = $tA['cantidad'];
                $queryT = "INSERT INTO tallas (tipo, id_detalle, talla, cantidad) VALUES (3, $idDetalle, '$tallaD', $cantidadD)";
                $resultT = mysqli_query($this->link, $queryT) or die(mysqli_error());
                if($resultT)
                {
                  //-->NJES November/11/2020 afectar presupuesto por cada partida que sea de familia gastos fletes y logistica
                  if($id_familia_gasto == 104)
                  {
                    $movP = $afectarPresupuesto->guardarMovimientoPresupuesto($arr);
      
                    if($movP > 0)
                      $verifica = $idEntradaCompra;
                    else{
                      $verifica = 0;
                      break; 
                    }
                  }else
                    $verifica = $idEntradaCompra;

                }else
                {
                  $verifica = 0;
                  break; 
                }

              }

            }
            else{
              //-->NJES November/11/2020 afectar presupuesto por cada partida que sea de familia gastos fletes y logistica
              if($id_familia_gasto == 104)
              {
                $movP = $afectarPresupuesto->guardarMovimientoPresupuesto($arr);
  
                if($movP > 0)
                  $verifica = $idEntradaCompra;
                else{
                  $verifica = 0;
                  break; 
                }
              }else
                $verifica = $idEntradaCompra;

            }

          }
          else
          {
            //echo 'no se inserto';
            $verifica = 0;
            break;
          }

      }

      return $verifica;

    }

       /**
      * Busca los registros de las entradas almacen
      * 
      * @param varchar $datos array que contiene datos para filtrar las Búsqueda de  des
      *
      **/ 
      function buscarEntradasCompra($datos){
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
          $condicion=" AND a.fecha >= '$fechaInicio' AND a.fecha <= '$fechaFin' ";
        }
       
        $result = $this->link->query("SELECT a.id,a.folio as folio_ec,a.cve_concepto,a.id_unidad_negocio,a.id_sucursal,DATE(a.fecha) AS fecha,a.id_proveedor,a.id_oc, o.folio as folio,
        a.no_partidas AS partidas,a.id_usuario_captura,a.vehiculo as no_economico,a.recepcion_servicio as servicio,a.tipo_oc,b.usuario,TRIM(c.nombre) AS proveedor, s.descr as sucursal
        FROM almacen_e a
        LEFT JOIN usuarios b ON a.id_usuario_captura=b.id_usuario
        LEFT JOIN proveedores c ON a.id_proveedor=c.id
        LEFT JOIN sucursales s ON a.id_sucursal = s.id_sucursal
        INNER JOIN orden_compra  o on a.id_oc = o.id
        WHERE a.cve_concepto='$tipoEntrada' AND a.id_unidad_negocio=".$idUnidadNegocio." AND a.id_sucursal=".$idSucursal." $condicion
        GROUP BY a.id
        ORDER BY a.folio DESC");

        return query2json($result);

    }//-- fin function buscarEntradas
   


     /**
      * Buscar los detalles de determidada requisicion
      *
      * @param int $idRequisicin
      *
      **/
      function buscarDetallesEntradaCompra($idEntradaCompra)
      {
        
        $resultado = $this->link->query("SELECT 
          almacen_d.id,
          almacen_d.id_oc_d,
          almacen_d.id_producto,
          almacen_d.cantidad,
          orden_compra_d.cantidad AS cantidad_oc,
          almacen_d.iva,
          orden_compra_d.costo_unitario AS precio_oc,
          almacen_d.precio,
          almacen_d.partida,
          almacen_d.lleva_talla,
          almacen_d.porcentaje_descuento AS descuento,
          productos.concepto,
          lineas.descripcion AS linea,
          familias.descripcion AS familia
          FROM almacen_d 
          INNER JOIN productos ON almacen_d.id_producto=productos.id
          INNER JOIN lineas ON productos.id_linea=lineas.id
          INNER JOIN familias ON productos.id_familia=familias.id
          LEFT JOIN orden_compra_d ON almacen_d.id_oc_d = orden_compra_d.id
          WHERE almacen_d.id_almacen_e=".$idEntradaCompra."
          ORDER BY almacen_d.id desc");
          return query2json($resultado);
  
      }
  
      /**
        * Busca las tallas de determinada partida
        *
        * @param int $idDetalle
        * @param int $tipo
        *
        **/
      function obtenerTallasDetalle($idDetalle, $tipo)
      {
  
        $resultado = $this->link->query("SELECT * FROM tallas WHERE tipo = $tipo AND id_detalle = $idDetalle");
          return query2json($resultado);
  
      }
  
      /**
        * Eliminar los detalles de determinada requisición
        *
        * @param int $idRequisicion
        *
        **/
      function eliminarDetalles($idRequisicion)
      {
  
        $resultado = $this->link->query("SELECT id FROM almacen_d WHERE id_requisicion = $idRequisicion");
        while($row = $resultado->fetch_assoc())
        {
  
          $idDetalle = $row['id'];
          $this->link->query("DELETE FROM tallas WHERE tipo = 1 AND id_detalle = $idDetalle");
          $this->link->query("DELETE from almacen_d where id = $idDetalle");
        
        }
  
      }

      function guardaBitacoraActivos($idOrden,$noEconomico,$foliosRequis,$idsRequis){

        $buscaA="SELECT id,CURRENT_DATE() AS fecha FROM activos WHERE num_economico='$noEconomico'";
        $resultA = mysqli_query($this->link, $buscaA) or die(mysqli_error());
        $rowA = mysqli_fetch_array($resultA);
        $idActivo = $rowA['id'];
        $fecha = $rowA['fecha'];

        $buscaD="SELECT descripcion,kilometraje FROM requisiciones  WHERE id_orden_compra=".$idOrden." AND no_economico='$noEconomico' AND estatus!=3";
        $resultD = mysqli_query($this->link, $buscaD) or die(mysqli_error());
        $rowD = mysqli_fetch_array($resultD);
        $descripcionG = $rowD['descripcion'];
        $kilometraje = $rowD['kilometraje'];

        $queryB = "INSERT INTO activos_bitacora (tipo, descripcion, fecha, id_activo,kilometraje,ids_requisicion,folios_requisicion) 
          VALUES ('Mantenimiento', '$descripcionG','$fecha','$idActivo','$kilometraje','$idsRequis','$foliosRequis')";
        $resultB = mysqli_query($this->link, $queryB) or die(mysqli_error());
        


        return $resultB;
        
    }

}//--fin de class almacen_d
    
?>