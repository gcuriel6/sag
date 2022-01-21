<?php

require_once('conectar.php');

class PresupuestoEgresos
{

    public $link;

    function PresupuestoEgresos()
    {

      $this->link = Conectarse();

    }

    /**
      * Limpia la cadena quitando carecteres raros
      * @param $cadena string
      * @return string
      */
    function limpiarCadena($cadena)
    {

      $cadena = utf8_encode($cadena);
      $antes = array("á", "é", "í", 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ');
      $ahora   = array("a", "e", "i", 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N');
      $cadena = str_replace($antes, $ahora, $cadena);
      $cadena = strtoupper(trim($cadena));

      return $cadena;

    }

    function buscaIdUnidad($claveUnidad){
      $idUnidad = 0;
      $result = mysqli_query($this->link,"SELECT id,nombre FROM cat_unidades_negocio WHERE clave='$claveUnidad' AND inactivo=0");
      $row = mysqli_fetch_assoc($result);

      if(mysqli_num_rows($result) > 0)
          $idUnidad = $row['id'];
      
      return  $idUnidad;
    }

    function buscaIdSucursalClave($claveSucursal,$idUnidadNegocio){
      $idSucursal = 0;
      $result = mysqli_query($this->link,"SELECT id_sucursal,descr FROM sucursales WHERE clave='$claveSucursal' AND activo=1 AND id_unidad_negocio=".$idUnidadNegocio);
      $row = mysqli_fetch_assoc($result);

      if(mysqli_num_rows($result) > 0)
          $idSucursal = $row['id_sucursal'];
      
      return  $idSucursal;
    }

    function buscaIdSucursal($sucursal,$idUnidadNegocio){
      $idSucursal = 0;

      $result = mysqli_query($this->link,"SELECT id_sucursal 
                FROM sucursales
                WHERE id_sucursal='$sucursal' AND activo=1 AND id_unidad_negocio=".$idUnidadNegocio);     

      $row = mysqli_fetch_assoc($result);

      if(mysqli_num_rows($result) > 0)
          $idSucursal = $row['id_sucursal'];
      
      return  $idSucursal;
    }

    function buscarSucursalesUnidad($idUnidadNegocio){
      $sucursales = 0;
      $result = mysqli_query($this->link,"SELECT GROUP_CONCAT(id_sucursal) AS sucursales 
                                          FROM sucursales
                                          WHERE id_unidad_negocio=$idUnidadNegocio AND activo=1");
      $row = mysqli_fetch_assoc($result);

      if(mysqli_num_rows($result) > 0)
          $sucursales = $row['sucursales'];
      
      return  $sucursales;
    }

      /**
        * Busca area
        * @param $area string
        * @param $idSUcursal int
        * @return int
        */
      function buscarAreas($area)
      {
        //echo "SELECT id FROM cat_areas WHERE activa  = 1 AND id_sucursal = $idSucursal AND descripcion = '$area'";
        $idArea = 0;
        $result = mysqli_query($this->link, "SELECT id FROM cat_areas WHERE activa  = 1 AND clave = '$area'");
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0)
            $idArea = $row['id'];
        
        return  $idArea;

      }

      /**
        * Busca depto
        * @param $depto string
        * @param $idUnidad int
        * @param $idSUcursal int
        * @return int
        */
      function buscarDeptos($depto, $idSucursal, $idArea)
      {

        $idDepto = 0;
        $result = mysqli_query($this->link, "SELECT id_depto FROM deptos WHERE inactivo = 0 AND id_sucursal = $idSucursal AND id_area = $idArea AND des_dep = '$depto'");
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0)
            $idDepto = $row['id_depto'];
        
        return  $idDepto;

      }

      /**
        * Busca familia
        * @param $familia string
        * @return int
        */
      function buscarFamilias($familia)
      {

        $idFamilia = 0;
        $result = mysqli_query($this->link, "SELECT id_fam FROM fam_gastos WHERE descr = '$familia' AND activo = 0");
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0)
            $idFamilia = $row['id_fam'];
        
        return  $idFamilia;

      }

      /**
        * Busca concepto
        * @param $concepto string
        * @return int
        */      
      function buscarConceptos($concepto,$idFamilia)
      {
        $idConcepto = 0;
        $result = mysqli_query($this->link, "SELECT id_clas FROM gastos_clasificacion WHERE id_fam=$idFamilia AND activo = 0 AND descr = '$concepto'");
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0)
            $idConcepto = $row['id_clas'];
        
        return  $idConcepto;

      }

      /**
        * Borra presupuesto en caso de reemplazar
        * @param $anio int
        * @param $mes int
        * @param $tipo int
        * @return bool
        */
      function eliminarPresupuesto($id_unidad_negocio_select,$anio, $mes, $tipo)
      {

        $verifica = false;

        if($tipo == 0)
        {
          //echo "DELETE FROM presupuesto_egresos WHERE anio = $anio AND mes = $mes";
          $result = mysqli_query($this->link, "DELETE FROM presupuesto_egresos WHERE id_unidad_origen = $id_unidad_negocio_select AND anio = $anio AND mes = $mes");
          $row = mysqli_fetch_assoc($result);

          if($result)//if(mysqli_num_rows($result) > 0)
            $verifica = true;
          
        }
        else
          $verifica = true;

        return $verifica;

      }

      /**
        * Guardar o actualiza registros de presupuesto
        * @param $idUnidad int
        * @param $idSucursal int
        * @param $anio int
        * @param $mes int
        * @param $tipo int
        * @param $dV array
        * @return bool
        */
        function guardar($id_unidad_negocio_select,$anio, $mes, $tipo, $datosValidos)
        {
  
          $verifica = false;

          //$test = " ---------";
  
          foreach($datosValidos as $dV)
          {
            $idPresupuesto = 0;
  
            $claveUnidad = $dV['claveUnidad'];
  
            $idUnidadS = $dV['id_unidad_s'];
            $idSucursalS = $dV['id_sucursal_s'];
            
            $idUnidad = isset($dV['id_unidad_negocio']) ? $dV['id_unidad_negocio'] : '';
            $idSucursal = isset($dV['id_sucursal']) ? $dV['id_sucursal'] : '';
            $idArea = $dV['id_area'];
            $idDepto = $dV['id_depto'];
            $idFamilia = $dV['id_familia'];
            $idConcepto = $dV['id_concepto'];
            $importe = $dV['importe'];
  
            $datosRelacion = $dV['datosRelacion'];
  
            
            $unidad = $idUnidadS;
            $sucursal = $idSucursalS;

            //$test .= "*";

             /*$queryT = "INSERT INTO presupuesto_egresos (id_unidad_negocio, id_sucursal, id_area, id_depto, id_familia_gasto, id_clasificacion, anio, mes, monto) VALUES ($unidad, $sucursal, $idArea, $idDepto, $idFamilia, $idConcepto, $anio, $mes, $importe)";
                $test .= $queryT;*/


          
            if($tipo == 1)
            {

              //$test .= "A";
  
              $wClasificacion = $idConcepto == 'null' ? "AND id_clasificacion IS NULL" :  "AND id_clasificacion = $idConcepto";
              
              $resultB = mysqli_query($this->link, "SELECT id FROM  presupuesto_egresos  WHERE 
              id_unidad_origen = $id_unidad_negocio_select
              AND id_unidad_negocio = $unidad
              AND id_sucursal = $sucursal
              AND id_depto = $idDepto
              AND id_familia_gasto = $idFamilia
              $wClasificacion
              AND anio = $anio
              AND mes = $mes");
              $rowB = mysqli_fetch_assoc($resultB);
  
              if(mysqli_num_rows($resultB) > 0)
              {
                $idB = $rowB['id'];
                $queryT = "UPDATE presupuesto_egresos SET monto = $importe WHERE id = $idB";
                $result = mysqli_query($this->link, $queryT) or die(mysqli_error());
                $idPresupuesto = $idB;
              }
  
            }else{

              $id_concepto = $idConcepto == 'null' ? 0 : $idConcepto;
  
              $queryT = "INSERT INTO presupuesto_egresos (id_unidad_origen,id_unidad_negocio, id_sucursal, id_area, id_depto, id_familia_gasto, id_clasificacion, anio, mes, monto) 
                VALUES ($id_unidad_negocio_select,$unidad, $sucursal, $idArea, $idDepto, $idFamilia, $id_concepto, $anio, $mes, $importe)";

                //$test .= $queryT;
              $result = mysqli_query($this->link, $queryT) or die(mysqli_error());
              $idPresupuesto = mysqli_insert_id($this->link);
            }
            
  
            if($result) 
            {
                if(strtoupper($claveUnidad) == 'GINTHERCORP')
                {
                  $totalEmpleados = $this -> totalEmpleados($datosRelacion);
                  $verifica = $this -> guardarProrrateo($id_unidad_negocio_select,$datosRelacion,$idPresupuesto,$totalEmpleados,$importe,$anio,$mes);
                
                  if($verifica == true)
                    break;


                }else
                  $verifica = false;
                
            }else{
              $verifica = true;
                break;
            }
  
          }
    
          return $verifica;

        }

        function totalEmpleados($arrDatos){
          $verifica = false;
          $total = 0;
  
          foreach($arrDatos as $dV)
          {
            $idUnidad = $dV['id_unidad_negocio'];
            $idSucursal = $dV['id_sucursal'];
  
            //-->busco el ultimo anio en nomina para empleados operativos
            $buscaAQ1="SELECT MAX(ano) AS anio FROM nomina";
            $resultAQ1 = mysqli_query($this->link, $buscaAQ1) or die(mysqli_error());
            $rowAQ1 = mysqli_fetch_array($resultAQ1);
            $anioN = $rowAQ1['anio'];
  
            //-->busco la ultima quincena capturada del ultimo anio en nomina para empleados operativos
            $buscaAQ1x="SELECT MAX(quincena) AS quincena FROM nomina WHERE ano=$anioN";
            $resultAQ1x = mysqli_query($this->link, $buscaAQ1x) or die(mysqli_error());
            $rowAQ1x = mysqli_fetch_array($resultAQ1x);
            $quincenaN = $rowAQ1x['quincena'];
  
            //-->busco el ultimo anio en nomina_a para empleados administrativos
            $buscaAQ2="SELECT MAX(ano) AS anio FROM nomina_a";
            $resultAQ2 = mysqli_query($this->link, $buscaAQ2) or die(mysqli_error());
            $rowAQ2 = mysqli_fetch_array($resultAQ2);
            $anioNA = $rowAQ2['anio'];
  
            //-->busco la ultima quincena capturada del ultimo anio en nomina_a para empleados administrativos
            $buscaAQ2x="SELECT MAX(quincena) AS quincena FROM nomina_a WHERE ano=$anioNA";
            $resultAQ2x = mysqli_query($this->link, $buscaAQ2x) or die(mysqli_error());
            $rowAQ2x = mysqli_fetch_array($resultAQ2x);
            $quincenaNA = $rowAQ2x['quincena'];
  
            //-->busco los departamentos de la sucursal
            $busca_deptos="SELECT IFNULL(GROUP_CONCAT(id_depto),0) AS departamentos FROM deptos WHERE id_sucursal=".$idSucursal." AND inactivo=0";
            $resultF = mysqli_query($this->link, $busca_deptos) or die(mysqli_error());
            $datos = mysqli_fetch_array($resultF);
            $deptos = $datos['departamentos'];
  
            $deptos = rtrim($deptos, ',');
  
            $departamentos = ' AND id_depto IN('. $deptos.')';
  
            //-->busco los empleados operativos de la ultima quincena capturada
            $buscaEmpleadosO = "SELECT COUNT(id_empleado) AS empleados FROM nomina WHERE ano=$anioN AND quincena=$quincenaN $departamentos";
            $resultO = mysqli_query($this->link, $buscaEmpleadosO) or die(mysqli_error());
            $datosO = mysqli_fetch_array($resultO);
            $empleadosOperativos = $datosO['empleados'];
  
            /**/
            //-->busco los empleados administrativos de la ultima quincena capturada
            $buscaEmpleadosA = "SELECT COUNT(id_empleado) AS empleados FROM nomina_a WHERE ano=$anioNA AND quincena=$quincenaNA $departamentos";
            $resultA = mysqli_query($this->link, $buscaEmpleadosA) or die(mysqli_error());
            $datosA = mysqli_fetch_array($resultA);
            $empleadosAdministrativos = $datosA['empleados'];
  
            //$suma = $empleadosOperativos+$empleadosAdministrativos;
            $suma = (int)$empleadosOperativos+(int)$empleadosAdministrativos;
  
            $total = $total+$suma;
  
  
          }
          $verifica = $total;
  
          return $verifica;
        }

      function guardarProrrateo($id_unidad_negocio_select,$datosRelacion,$idPresupuesto,$totalEmpleados,$monto,$anio,$mes){
        $verifica = false;

          foreach($datosRelacion as $datos)
          {
            $idUnidad = $datos['id_unidad_negocio'];
            $idSucursal = $datos['id_sucursal'];
            $idFamilia = $datos['id_familia'];
            $idConcepto = $datos['id_concepto'];

            $condB = $idConcepto == 'null' ? 0 : $idConcepto;

            $busca_existe = mysqli_query($this->link, "SELECT a.id 
                                  FROM presupuestos_prorrateados a
                                  LEFT JOIN presupuesto_egresos b ON b.id=a.id_presupuesto_egreso
                                  WHERE b.id_unidad_origen=$id_unidad_negocio_select
                                  AND a.id_unidad_negocio=$idUnidad
                                  AND a.id_sucursal=$idSucursal
                                  AND a.id_familia_gasto=$idFamilia  
                                  AND a.id_clasificacion = $condB
                                  AND b.anio=$anio AND b.mes=$mes");
            $resultadoB = mysqli_fetch_assoc($busca_existe);

            if(mysqli_num_rows($busca_existe) > 0)
            {
              $verifica = true;
              break;
            }else{

            //-->busco el ultimo anio en nomina para empleados operativos
            $buscaAQ1="SELECT MAX(ano) AS anio FROM nomina";
            $resultAQ1 = mysqli_query($this->link, $buscaAQ1) or die(mysqli_error());
            $rowAQ1 = mysqli_fetch_array($resultAQ1);
            $anioN = $rowAQ1['anio'];

            //-->busco la ultima quincena capturada del ultimo anio en nomina para empleados operativos
            $buscaAQ1x="SELECT MAX(quincena) AS quincena FROM nomina WHERE ano=$anioN";
            $resultAQ1x = mysqli_query($this->link, $buscaAQ1x) or die(mysqli_error());
            $rowAQ1x = mysqli_fetch_array($resultAQ1x);
            $quincenaN = $rowAQ1x['quincena'];

            //-->busco el ultimo anio en nomina_a para empleados administrativos
            $buscaAQ2="SELECT MAX(ano) AS anio FROM nomina_a";
            $resultAQ2 = mysqli_query($this->link, $buscaAQ2) or die(mysqli_error());
            $rowAQ2 = mysqli_fetch_array($resultAQ2);
            $anioNA = $rowAQ2['anio'];

            //-->busco la ultima quincena capturada del ultimo anio en nomina_a para empleados administrativos
            $buscaAQ2x="SELECT MAX(quincena) AS quincena FROM nomina_a WHERE ano=$anioNA";
            $resultAQ2x = mysqli_query($this->link, $buscaAQ2x) or die(mysqli_error());
            $rowAQ2x = mysqli_fetch_array($resultAQ2x);
            $quincenaNA = $rowAQ2x['quincena'];

            //-->busco los departamentos de la sucursal
            $busca_deptos="SELECT IFNULL(GROUP_CONCAT(id_depto),0) AS departamentos FROM deptos WHERE id_sucursal=".$idSucursal." AND inactivo=0";
            $resultF = mysqli_query($this->link, $busca_deptos) or die(mysqli_error());
            $datos = mysqli_fetch_array($resultF);
            $deptos = $datos['departamentos'];

            $deptos = rtrim($deptos, ',');

            $departamentos = ' AND id_depto IN('.$deptos.')';

            //-->busco los empleados operativos de la ultima quincena capturada
            $buscaEmpleadosO = "SELECT COUNT(id_empleado) AS empleados FROM nomina WHERE ano=$anioN AND quincena=$quincenaN $departamentos";
            $resultO = mysqli_query($this->link, $buscaEmpleadosO) or die(mysqli_error());
            $datosO = mysqli_fetch_array($resultO);
            $empleadosOperativos = $datosO['empleados'];

            //-->busco los empleados administrativos de la ultima quincena capturada
            $buscaEmpleadosA = "SELECT COUNT(id_empleado) AS empleados FROM nomina_a WHERE ano=$anioNA AND quincena=$quincenaNA $departamentos";
            $resultA = mysqli_query($this->link, $buscaEmpleadosA) or die(mysqli_error());
            $datosA = mysqli_fetch_array($resultA);
            $empleadosAdministrativos = $datosA['empleados'];

            $total = $empleadosOperativos+$empleadosAdministrativos;

            if($totalEmpleados > 0)
              $porcent = ($total*100)/$totalEmpleados;
            else
              $porcent = 0;

            $porcentaje = round($porcent,0);
            
            $id_concepto = $idConcepto == 'null' ? 0 : $idConcepto;

            $query = "INSERT INTO presupuestos_prorrateados (id_presupuesto_egreso,porcentaje_prorrateo,id_unidad_negocio,id_sucursal,id_familia_gasto,id_clasificacion) 
                        VALUES ($idPresupuesto,$porcentaje,$idUnidad,$idSucursal,$idFamilia,$id_concepto)";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if($result)
              $verifica = false;
            else
            {
              $verifica = true;
              break;
            }
          }
        }

        return $verifica;
      }

      /**
        * Recorre los diferentes registros de presupuesto para guardar
        * @param $idUnidad int
        * @param $idSucursal int
        * @param $anio int
        * @param $mes int
        * @param $tipo int
        * @param datosValidos array
        * @return bool
        */
      function guardarPresupuesto($id_unidad_negocio_select,$anio, $mes, $tipo, $datosValidos)
      {

        $verifica = true;

        $this->link->begin_transaction();//$this->link->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
        $this->link->query("START TRANSACTION;");

        //$resultado = $this->link->query("SELECT id FROM presupuesto_egresos WHERE id_unidad_negocio = $id_unidad_negocio_select AND anio = $anio AND mes = $mes");
        $resultado = $this->link->query("SELECT id FROM presupuesto_egresos WHERE id_unidad_origen = $id_unidad_negocio_select AND anio = $anio AND mes = $mes");
        while($row = $resultado->fetch_assoc())
        {
          $idPresupuestoAnt = $row['id'];
          $delete = "DELETE FROM presupuestos_prorrateados WHERE id_presupuesto_egreso = $idPresupuestoAnt";
          $resultDelete = mysqli_query($this->link, $delete) or die(mysqli_error());
        }

   
        if($this->eliminarPresupuesto($id_unidad_negocio_select,$anio, $mes, $tipo))
        {

          //$verifica = $this->guardar($id_unidad_negocio_select,$anio, $mes, $tipo, $datosValidos);
          $verificaGuardar = $this->guardar($id_unidad_negocio_select,$anio, $mes, $tipo, $datosValidos);

          if($verificaGuardar == false)
          {

            $id_usuario = $_SESSION['id_usuario'];
            $queryIB = "INSERT INTO bitacora_presupuesto_egresos(tipo,id_unidad_negocio,id_usuario) 
                        VALUES ('$tipo','$id_unidad_negocio_select','$id_usuario')";
            $resultIB = mysqli_query($this->link, $queryIB) or die(mysqli_error());
            if($resultIB) 
              $verifica = false;  
            
          }
        }

        if($verifica == false)
         $this->link->query("commit;");
        else
           $this->link->query('rollback;');

        return $verifica;

      }

      /**
      * Busco si existe un presupuesto de egresos con los datos enviados en el mes y año actual
      * 
      * @param varchar $datos array con parametros pra filtrar busqueda
      * idUnidadNegocio,idSucursal,idArea,idDepartamento,idFamilia
      *
      **/ 
      function buscarExistenciaSaldo($datos){
       
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idArea = $datos['idArea'];
        $idDepartamento = $datos['idDepartamento'];
        $idFamilia = $datos['idFamilia'];

        $result = $this->link->query("SELECT IFNULL(a.id,0) AS id,IFNULL((a.monto - SUM(IF(b.tipo='C',b.monto,0))),0) AS saldo
                                      FROM presupuesto_egresos a
                                      LEFT JOIN movimientos_presupuesto b ON b.id_presupuesto_egreso=a.id
                                      WHERE a.id_unidad_negocio=$idUnidadNegocio AND a.id_sucursal=$idSucursal AND a.id_area=$idArea  
                                      AND a.id_depto=$idDepartamento AND a.id_familia_gasto=$idFamilia
                                      AND a.anio=YEAR(CURDATE()) AND mes=MONTH(CURDATE())");

        return query2json($result);
      }//-- fin function guardarActualizar

      /**
        * Busca el presupueto correspondiente por periodo en cierta unidad de negocio y sucursal
        * @param $idUnidad int
        * @param $idSucursal int
        * @param $anio int
        * @param $mes int
        * @return json
        */
      function buscar($anio, $mes,$id_unidad_negocio)
      {
        $unidad = '';

        if($id_unidad_negocio > 0)
        {
          $unidad = ' AND presupuesto_egresos.id_unidad_negocio = '.$id_unidad_negocio;
        }

        if($mes > 0)
        {
          $condMes = ' AND presupuesto_egresos.mes ='.$mes;
        }else{
          $condMes = '';
        }

        $resultado = $this->link->query("SELECT 
          presupuesto_egresos.id,
          cat_unidades_negocio.id AS id_unidad,
          cat_unidades_negocio.nombre AS nombre_unidad,
          sucursales.id_sucursal AS id_sucursal,
          ifnull(sucursales.descr, '') AS nombre_sucursal,
          fam_gastos.id_fam AS id_familia,
          fam_gastos.descr AS nombre_familia,
          gastos_clasificacion.id_clas AS id_clasificacion,
          gastos_clasificacion.descr AS nombre_clasificacion,
          presupuesto_egresos.anio AS anio,
          presupuesto_egresos.mes AS mes,
          presupuesto_egresos.monto AS monto,
          IF(presupuesto_egresos.mes >= MONTH(CURDATE()) AND presupuesto_egresos.anio >= YEAR(CURDATE()),1,0) AS editar,
          COUNT(a.id) AS prorrateo
          FROM presupuesto_egresos
          INNER JOIN cat_unidades_negocio ON presupuesto_egresos.id_unidad_negocio = cat_unidades_negocio.id
          LEFT JOIN sucursales ON presupuesto_egresos.id_sucursal = sucursales.id_sucursal
          INNER JOIN fam_gastos ON presupuesto_egresos.id_familia_gasto = fam_gastos.id_fam
          LEFT JOIN gastos_clasificacion ON presupuesto_egresos.id_clasificacion = gastos_clasificacion.id_clas
          LEFT JOIN presupuestos_prorrateados a ON presupuesto_egresos.id=a.id_presupuesto_egreso
          WHERE 1 $unidad 
          AND presupuesto_egresos.anio = $anio
          $condMes 
          GROUP BY presupuesto_egresos.id
          ORDER BY presupuesto_egresos.anio,presupuesto_egresos.mes DESC");

        return query2json($resultado);

      }

      /**
      * Actualiza el monto de un registro de la tabla prespuesto_egresos
      * 
      * @param varchar $datos array que contiene los datos a actualizar
      *
      **/ 
      function editarPresupuestoEgreso($datos){
        $verifica = 0;
  
        $verifica = $this -> guardarActualizar($datos);

        return $verifica;
      }//-- fin function editarPresupuestoEgreso

      /**
      * Actualiza el monto de un registro de la tabla prespuesto_egresos
      * 
      * @param varchar $datos array que contiene los datos a actualizar
      *
      **/ 
      function guardarActualizar($datos){
        $verifica = 0;

        $idPresupuestoEgreso = $datos['idPresupuestoEgreso'];
        $monto = $datos['importe'];

        $query = "UPDATE presupuesto_egresos SET monto=$monto WHERE id=".$idPresupuestoEgreso;

        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result) 
        {
          $verifica = 1;  
        }else{
          $verifica = 0;  
        }

        return $verifica;
      }//-- fin function guardarActualizar

      /**
      * Busca el porcentaje de factor prorrateo que esta relacionado a un presupuesto egreso
      * 
      * @param int $idPresupuesto del presupuesto egreso para buscar la relación del factor de prorrateo
      *
      **/ 
      function buscarFactorProrrateo($idPresupuesto){
        $result = $this->link->query("SELECT a.id,a.porcentaje_prorrateo AS factor_prorrateo, 
                                      b.nombre AS unidad_negocio,
                                      c.descr AS sucursal
                                      FROM presupuestos_prorrateados a
                                      LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                                      LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                                      WHERE a.id_presupuesto_egreso=".$idPresupuesto);

        return query2json($result);
      }//-- fin function buscarFactorProrrateo

      function actualizarFactorProrrateo($idProrrateo,$montoP,$montos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizarProrrateo($idProrrateo,$montoP,$montos);

        if($verifica === 0)
            $this->link->query('ROLLBACK;');
        else
            $this->link->query("COMMIT;");

        return $verifica;
      }

      function guardarActualizarProrrateo($idProrrateo,$montoP,$montos){
        $verifica = 0;

        $queryP = "UPDATE presupuesto_egresos SET monto=$montoP WHERE id=".$idProrrateo;

        $resultP = mysqli_query($this->link, $queryP) or die(mysqli_error());
        
        if($resultP) 
        {
          foreach($montos as $dato)
          {
            $monto = $dato['monto'];
            $id = $dato['id'];

            $query = "UPDATE presupuestos_prorrateados SET porcentaje_prorrateo=$monto 
                      WHERE id=".$id;

            $result = mysqli_query($this->link, $query) or die(mysqli_error());
                  
            if($result) 
            {
              $verifica = 1;  
            }else{
              $verifica = 0;
              break;  
            }
          } 
        }else{
          $verifica = 0;  
        }

        return $verifica;
      }

  function eliminarPresupuestoEgresos($anio, $mes){
    $verifica = 0;

    $this->link->begin_transaction();
    $this->link->query("START TRANSACTION;");

    $verifica = $this -> eliminarPE($anio, $mes);

    if($verifica > 0)
        $this->link->query("COMMIT;");
    else
        $this->link->query('ROLLBACK;');

    return $verifica;
  }

  function eliminarPE($anio, $mes){
    $verifica = 0;

    $eliminaP = $this -> eliminarProrrateoPE($anio, $mes);

    if($eliminaP > 0)
    {
      $result = mysqli_query($this->link, "DELETE FROM presupuesto_egresos WHERE anio = $anio AND mes = $mes");
            
      if($result)
      {
        $id_usuario = $_SESSION['id_usuario'];
        $queryIB = "INSERT INTO bitacora_presupuesto_egresos(tipo,id_usuario) 
                    VALUES ('2','$id_usuario')";
        $resultIB = mysqli_query($this->link, $queryIB) or die(mysqli_error());

        if($resultIB) 
          $verifica = 1;
      }
    }

    return $verifica;
  }

  function eliminarProrrateoPE($anio, $mes){
    $verifica = 0;

    $busca = "SELECT id FROM presupuesto_egresos WHERE anio = $anio AND mes = $mes";
    $resultB = mysqli_query($this->link,$busca) or die(mysqli_error());

    $num = mysqli_num_rows($resultB);
    if($num > 0)
    {
      while($rowB = mysqli_fetch_assoc($resultB))
      {
        $id_presupuesto_e = $rowB['id'];

        $resultPP = mysqli_query($this->link, "DELETE FROM presupuestos_prorrateados WHERE id_presupuesto_egreso = $id_presupuesto_e");
            
        if($resultPP)
          $verifica = 1;
        else{
          $verifica = 0;
          break;
        }

      }
    }else
      $verifica = 1;

    return $verifica;
  }

  function verificaUsuarioEliminarPresupuesto($idUsuario){
    $verifica = 0;

    $result = mysqli_query($this->link,"SELECT b_eliminar_presupuesto FROM usuarios WHERE id_usuario=".$idUsuario);
    $row = mysqli_fetch_assoc($result);

    $verifica = $row['b_eliminar_presupuesto'];

    return $verifica;
  }

}
    
?>