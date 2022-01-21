<?php

require_once('conectar.php');
require_once('MovimientosPresupuesto.php');

class DeudoresDiversos
{

  /**
  * Se declara la variable $link y en el constructor se asigna o inicializa
  * 
  **/

  public $link;

  function DeudoresDiversos()
  {

    $this->link = Conectarse();

  }

  /**
    * Busca los deudores diversos
    *
  **/
  function buscarDeudoresDiversos(){
    $result = $this->link->query("SELECT a.id,a.id_gasto,a.id_viatico,a.importe,a.categoria,fecha,IF(a.id_gasto > 0,'gasto','viatico') AS tipo,
                                  IF(a.id_empleado > 0,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m)),a.empleado) AS deudor_diverso
                                  FROM deudores_diversos a
                                  LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                                  WHERE a.comprobado=0
                                  ORDER BY a.fecha ASC");

    return query2json($result);
  }//- fin function buscarDeudoresDiversos

  function buscarDeudoresDiversosId($id){
    //-->NJES Jan/17/2020 se agrega buscar id_clasificacion_gasto
    $result = $this->link->query("SELECT a.id,a.importe,a.id_empleado,a.categoria,
                                  IF(a.id_empleado > 0,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m)),a.empleado) AS deudor_diverso,
                                  a.referencia,a.id_empleado,a.id_unidad_negocio,a.id_sucursal,a.id_departamento,a.id_area,a.id_familia_gastos,a.id_clasificacion_gasto
                                  FROM deudores_diversos a
                                  LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                                  WHERE a.id=".$id);

    return query2json($result);
  }//- fin function buscarDeudoresDiversosId

  /**
    * Guarda pago de deudor diverso
    * 
    * @param varchar $datos array que contiene los datos a insertar
    *
  **/
  function guardarPagoDeudoresDiversos($datos){
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardar($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
  }//- fin function guardarPagoDeudoresDiversos

  function guardar($datos){
    $verifica = 0;

    $idRegistro = $datos['idRegistro'];
    $idGasto = $datos['idGasto'];
    $idViatico = $datos['idViatico'];
    $importeDD = $datos['importeDD'];  //--> Importe que debe comprobar
    $importeC = $datos['importeC'];  //-->  Importe comprobado
    $tipo = $datos['tipo'];
    $referencia = $datos['referencia'];
    $fecha_inicio = $datos['fecha_inicio'];  //--> Fecha inicio descuento nomina
        
    $updateDD = "UPDATE deudores_diversos SET comprobado=1,referencia='$referencia',fecha_inicio='$fecha_inicio' WHERE id=".$idRegistro;
    $resultDD = mysqli_query($this->link, $updateDD) or die(mysqli_error());

    if ($resultDD)
    {
      if($importeC == $importeDD)
      {
        
        $verifica = $this -> compruebaGastosViaticos($tipo,$idGasto,$idViatico);

      }else{
        $verifica = $this -> guardaDinero($datos);
      }
    }else{
      $verifica = 0;
    }
    
    return $verifica;

  }//- fin function guardar

  function guardaDinero($datos){
    $verifica = 0;

    $devolucion = isset($datos['devolucion']) ? $datos['devolucion'] : 0;  //--> Monto dinero que se regresa
    $idCuentaBanco = isset($datos['idCuentaBanco']) ? $datos['idCuentaBanco'] : 0;
    $descuento = isset($datos['descuento']) ? $datos['descuento'] : 0; //--> Monto a desconetar de la nmina al empleado
    $quincenas = isset($datos['quincenas']) ? $datos['quincenas'] : 0; //--> numero de quincenas en que se hara el descuento
    $tipo = $datos['tipo'];//--- letra gasto o viatico
    $idUsuario = $datos['idUsuario'];
    $idEmpleado = $datos['idEmpleado'];
    $idUnidadNegocio = $datos['idUnidadNegocio'];
    $idSucursal = $datos['idSucursal'];
    $idArea = $datos['idArea'];
    $idDepartamento = $datos['idDepartamento'];
    $empleado = $datos['empleado'];
    $tipoCuentaBanco = $datos['tipoCuentaBanco'];  //--> 0=para movimientos bancos  1=para caja chica
    $fechaAplicacion = isset($datos['fechaAplicacion']) ? $datos['fechaAplicacion'] : '0000-00-00';
    $idGasto = isset($datos['idGasto']) ? $datos['idGasto'] : 0;
    $idViatico = isset($datos['idViatico']) ? $datos['idViatico'] : 0;
    $idFamiliaGasto = isset($datos['idFamiliaGasto']) ? $datos['idFamiliaGasto'] : 0;
    //-->NJES Jan/17/2020 se manda guardar id_clasificacion_gasto para movimientos_presupuesto
    $idClasificacionGasto = isset($datos['idClasificacionGasto']) ? $datos['idClasificacionGasto'] : 0;

    if($devolucion > 0)
    {
      //-->NJES August/04/2020 buscar si el gasto tiene requi andera varias familias en 1
      //y busca los detalles del gasto para hacer las afectaciones a presupuesto egresos
      $busca_bandera = "SELECT requisiciones.b_varias_familias
        FROM gastos 
        LEFT JOIN requisiciones ON gastos.id_requisicion=requisiciones.id
        WHERE gastos.id=$idGasto";
      $res_busca_bandera = mysqli_query($this->link,$busca_bandera) or die(mysqli_error());
      $row_bandera = mysqli_fetch_array($res_busca_bandera);
      $diferentes_familias = $row_bandera['b_varias_familias'];

      if($diferentes_familias == 1)
      {
        $busca_gastos_d = "SELECT gastos_d.id,
        gastos_d.id_familia_gasto,
        gastos_d.id_clasificacion
        FROM gastos_d
        LEFT JOIN gastos ON gastos_d.id_gasto=gastos.id
        WHERE gastos_d.id_gasto=$idGasto"; 

        $res_queryB = mysqli_query($this->link,$busca_gastos_d) or die(mysqli_error());
        $num_queryB = mysqli_num_rows($res_queryB);

        $montoD = $devolucion+$descuento;

        $montoP = $montoD/$num_queryB;

        if($num_queryB > 0)
        {
          while($d = mysqli_fetch_array($res_queryB))
          {
            $monto = '-'.$montoP;

            $idFamiliaGastoP = $d['id_familia_gasto'];
            $idClasificacionP = $d['id_clasificacion'];

            //-->NJES June/19/2020 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
            //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
            $afectarPresupuesto = new MovimientosPresupuesto();

            $arrDatosMP = array(
              'idUnidadNegocio' => $idUnidadNegocio,
              'idSucursal' => $idSucursal,
              'idFamiliaGasto' => $idFamiliaGastoP,
              'clasificacionGasto' => $idClasificacionP,
              'total' => $monto,
              'tipo' => 'C',
              'idGasto' => $idGasto,
              'idViatico' => $idViatico
            );

            $afecta = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 

            if($afecta > 0)
              $resultMP = $afecta;
            else{
              $resultMP = 0 ;
              break;
            }

          }
        }
      }else{
        if($idFamiliaGasto > 0)
        {
          $monto = '-'.($devolucion+$descuento);

          //-->NJES June/19/2020 Se quita el area y departamento al hacer la afectación a presupuesto egreso (movimientos_presupuesto)
          //se crea un modelo y funcion para afectar el presupuesto egresos y no se encuentre el insert en varios archivos
          $afectarPresupuesto = new MovimientosPresupuesto();

          $arrDatosMP = array(
            'idUnidadNegocio' => $idUnidadNegocio,
            'idSucursal' => $idSucursal,
            'idFamiliaGasto' => $idFamiliaGasto,
            'clasificacionGasto' => $idClasificacionGasto,
            'total' => $monto,
            'tipo' => 'C',
            'idGasto' => $idGasto,
            'idViatico' => $idViatico
          );

          $resultMP = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 

        }
      }

      if($resultMP > 0)
      {
        if($tipoCuentaBanco == 0)  //-->se guarda en movimientos bancos
        {
          $query = "INSERT INTO movimientos_bancos(id_cuenta_banco,monto,tipo,id_gasto,id_viatico,id_usuario,fecha_aplicacion) 
                VALUES('$idCuentaBanco','$devolucion','A','$idGasto','$idViatico','$idUsuario','$fechaAplicacion')";
          $resultCB=mysqli_query($this->link, $query)or die(mysqli_error());
          
          if($resultCB)
          {
            if($descuento > 0)
            {
              $verifica = $this -> guardaDescuentoNomina($datos);
            }else{
              $verifica = $this -> compruebaGastosViaticos($tipo,$idGasto,$idViatico);
            }
          }else{
            $verifica = 0;
          }
        }else{  //-->se guarda en caja chica

          //-->NJES Jan/21/2020 Busco id_unidad_negocio, id_sucursal de la cuenta banco caja chica de la que voy a hacer un egreso G01
          $buscaCuenta = "SELECT id_unidad_negocio,id_sucursal 
                FROM cuentas_bancos WHERE id=".$idCuentaBanco;
          $resultC = mysqli_query($this->link, $buscaCuenta) or die(mysqli_error());

          if($resultC)
          {
            $datosC=mysqli_fetch_array($resultC);
            $idUnidadNegocioG=$datosC['id_unidad_negocio']; 
            $idSucursalG=$datosC['id_sucursal'];
            //--> NJES Jan/21/2020 Aumentar folio en cualquier movimiento en caja chica
            //-->busca el folio de la sucursal para aumentarlo
            $queryFolio="SELECT folio_caja_chica FROM sucursales WHERE id_sucursal=".$idSucursal;
            $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
    
            if($resultF)
            {
              $datosX=mysqli_fetch_array($resultF);
              $folioA=$datosX['folio_caja_chica'];
              $folio= $folioA+1;
      
              //--> aumenta el folio de la sucursal
              $queryU = "UPDATE sucursales SET folio_caja_chica='$folio' WHERE id_sucursal=".$idSucursal;
              $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
              if($resultU)
              {
                //$query2 = "INSERT INTO caja_chica(folio,importe,id_gasto,id_viatico,id_concepto,clave_concepto,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_empleado,nombre_empleado,fecha,id_usuario) 
                //        VALUES('$folio','$devolucion','$idGasto','$idViatico',15,'C01','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idEmpleado','$empleado','$fechaAplicacion','$idUsuario')";
                //-->NJES Jan/21/2020 el abono a caja chica es de la sucursal y unidad de la caja chica y esa caja chica no tiene area, departamento y empleado
                $query2 = "INSERT INTO caja_chica(folio,importe,id_gasto,id_viatico,id_concepto,clave_concepto,id_unidad_negocio,id_sucursal,fecha,id_usuario,observaciones) 
                        VALUES('$folio','$devolucion','$idGasto','$idViatico',15,'C01','$idUnidadNegocioG','$idSucursalG','$fechaAplicacion','$idUsuario','Comprobado devolución Deudor Diverso')";
                $resultCCH=mysqli_query($this->link, $query2)or die(mysqli_error());

                if($resultCCH)
                {
                  if($descuento > 0)
                  {
                    $verifica = $this -> guardaDescuentoNomina($datos);
                  }else{
                    $verifica = $this -> compruebaGastosViaticos($tipo,$idGasto,$idViatico);
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
          }else{
            $verifica = 0;
          }
        }
      }else
        $verifica = 0;
      
    }else{
      if($descuento > 0)
      {
        $verifica = $this -> guardaDescuentoNomina($datos);  
      }else{
        $verifica = $this -> compruebaGastosViaticos($tipo,$idGasto,$idViatico);
      }
    }

    return $verifica;
  }//- fin function guardaDinero

  function guardaDescuentoNomina($datos){
    $verifica = 1;

    $concepto = 0;
    $idEmpleado = $datos['idEmpleado'];
    $descuento = $datos['descuento'];  //--> Monto a desconetar de la nmina al empleado
    $quincenas = $datos['quincenas'];   //--> numero de quincenas en que se hara el descuento
    $fecha_inicio = $datos['fecha_inicio'];   //--> Fecha de inicio en que se comenzara a descontar
    
    if($datos['idGasto'] == 0)
    {
      $justificacion = $datos['justificacion'].' '.$datos['idViatico'];
      $concepto = 33;  //--> Viaticos  //nos los dio salvador
    }else{
      $justificacion = $datos['justificacion'].' '.$datos['idGasto'];
      $concepto = 34;  //--> Gastos  //nos los dio salvador
    }
    
    $idGasto = $datos['idGasto'];
    $idViatico = $datos['idViatico'];
    $tipo = $datos['tipo'];

    $query = "CALL descuentos_nomina_guardar('$fecha_inicio', $idEmpleado, $concepto, $descuento, '$justificacion', $quincenas)";

    $result=mysqli_query($this->link, $query)or die(mysqli_error()); 
    if($result)
    {
      $verifica = $this -> compruebaGastosViaticos($tipo,$idGasto,$idViatico);
    }else{
      $verifica = 0;
    }

    return $verifica;
    
  }//- fin function guardaDescuentoNomina

  function compruebaGastosViaticos($tipo,$idGasto,$idViatico){
    $verifica = 0;

    if($tipo == 'gasto')
    {
      $update = "UPDATE gastos SET comprobado=1 WHERE id=".$idGasto;
    }else{
      $update = "UPDATE viaticos SET estatus='C' WHERE id=".$idViatico;
    }

    $result = mysqli_query($this->link, $update) or die(mysqli_error());
    if ($result)
    {
      $verifica = 1;
    }else{
      $verifica = 0;
    }

    return $verifica;
  }//- fin function compruebaGastosViaticos

  function buscarDeudoresDiversosReporte($datos){
    $idUnidadNegocio = $datos['idUnidadNegocio'];
    $idSucursal = $datos['idSucursal'];
    $fechaInicio = $datos['fechaInicio'];
    $fechaFin = $datos['fechaFin'];
    $idEmpleado = isset($datos['idEmpleado']) ? $datos['idEmpleado'] : 0;
    $empleadoN = isset($datos['empleado']) ? $datos['empleado'] : '';
    $tipo = $datos['tipo'];

    $unidad='';
    $sucursal='';
    $condicion='';
    $empleado='';

    if($idSucursal != '')
    {
      if($idUnidadNegocio != '')
      {
        if($idUnidadNegocio[0] == ',')
        {
          $dato=substr($idUnidadNegocio,1);
          $unidad = ' AND a.id_unidad_negocio IN('.$dato.') ';
        }else{ 
          $unidad = ' AND a.id_unidad_negocio ='.$idUnidadNegocio;
        }
      }

      if($idSucursal[0] == ',')
      {
        $dato=substr($idSucursal,1);
        $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
      }else{ 
        $sucursal = ' AND a.id_sucursal ='.$idSucursal;
      }

      if($idEmpleado != 0)
      {
        $empleado = ' AND a.id_empleado ='.$idEmpleado;
      }else{
        $empleado = " AND a.empleado ='$empleadoN'";
      }

      if($fechaInicio == '' && $fechaFin == '')
      {
        $condicion=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
      }else if($fechaInicio != '' &&  $fechaFin == '')
      {
        $condicion=" AND a.fecha >= '$fechaInicio' ";
      }else{  //-->trae fecha inicio y fecha fin
        $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
      }

      if($tipo == 1)
      {
        $result = $this->link->query("SELECT a.id,a.id_unidad_negocio,a.id_sucursal,c.nombre AS unidad_negocio,d.descr AS sucursal,SUM(a.importe) AS importe,a.fecha,
                                        IF(a.id_empleado > 0,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m)),a.empleado) AS deudor_diverso,a.id_empleado
                                        FROM deudores_diversos a
                                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal  
                                        LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                                        WHERE a.comprobado=0 $unidad $sucursal $condicion
                                        GROUP BY a.id_empleado
                                        ORDER BY a.fecha ASC");
      }else{
        $result = $this->link->query("SELECT a.id,IF(a.id_gasto>0,'GASTO','VIATICO') AS tipo,c.nombre AS unidad_negocio,d.descr AS sucursal,a.importe,a.categoria,a.fecha
                                      FROM deudores_diversos a
                                      LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                                      LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal  
                                      LEFT JOIN trabajadores b ON a.id_empleado=b.id_trabajador
                                      WHERE a.comprobado=0 $empleado $unidad $sucursal $condicion
                                      ORDER BY a.fecha ASC");
      }

      return query2json($result);

    }else{
              
      $arr = array();
      $arr[] = '';

      return json_encode($arr);
    }
  }//- fin function buscarDeudoresDiversosReporte
    
}//--fin de class DeudoresDiversos
    
?>