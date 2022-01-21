<?php

include 'conectar.php';

class ValesGasolina
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function ValesGasolina()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los registros de vales de gasolina del día actual
      * 
    **/
    function buscarValesGasolinaHoy($idSucursal){
        
    
        $result = $this->link->query("SELECT a.id,IFNULL(a.folio,'') AS folio,a.fecha,a.clave_concepto,CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,
                                        ifnull(a.nombre_empleado,'') as nombre_empleado,a.importe,a.observaciones,c.nombre AS unidad_negocio,a.no_economico,
                                        d.descr AS sucursal,IFNULL(e.descripcion,'') AS area, IFNULL(f.des_dep,'') AS departamento, 
                                        ifnull(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS empleado,a.estatus
                                        FROM vales_gasolina a
                                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                                        LEFT JOIN cat_areas e ON a.id_area=e.id
                                        LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
                                        LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
                                        WHERE a.id_sucursal=$idSucursal AND a.fecha=CURDATE() 
                                        ORDER BY folio");

        return query2json($result);
    }//- fin function buscarValesGasolinaHoy

    /**
      * Busca registro de vales de gasolina
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarValesGasolina($datos){
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function guardarValesGasolina

    /**
      * Busca registro de vales de gasolina
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardar($datos){
        $verifica = 0;

        //$folio = $datos['folio'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idArea = $datos['idArea'];
        $idDepartamento = $datos['idDepartamento'];
        $idConcepto = $datos['idConcepto'];
        $claveConcepto = $datos['claveConcepto'];
        $fecha = $datos['fecha'];
        $idEmpleado = $datos['idEmpleado'];
        $empleado = $datos['empleado'];
        $importe = $datos['importe'];
        $observaciones = $datos['observaciones'];
        $idUsuario = $datos['idUsuario'];
        $estatus = isset($datos['estatus']) ? $datos['estatus'] : 1;
        $idRegistro = isset($datos['idRegistro']) ? $datos['idRegistro'] : 0;
        $externoNoEconomico = isset($datos['externoNoEconomico']) ? $datos['externoNoEconomico'] : 0;
        $noEconomico = isset($datos['noEconomico']) ? $datos['noEconomico'] : 0;
        $justificacion = isset($datos['justificacion']) ? $datos['justificacion'] : 0;


        $queryFolio="SELECT folio_vales_gasolina FROM sucursales WHERE id_sucursal=".$idSucursal;
        $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
        
        if($resultF)
        {
            $datos=mysqli_fetch_array($resultF);
            $folioA=$datos['folio_vales_gasolina'];
            $folio= $folioA+1;

            $queryU = "UPDATE sucursales SET folio_vales_gasolina='$folio' WHERE id_sucursal=".$idSucursal;
            $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
            if($resultU)
            {
                $query="INSERT INTO vales_gasolina(folio,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_concepto,clave_concepto,fecha,id_empleado,nombre_empleado,importe,observaciones,estatus,id_usuario,externo_no_economico,no_economico,justificacion_cancelacion)
                        VALUES('$folio','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idConcepto','$claveConcepto','$fecha','$idEmpleado','$empleado','$importe','$observaciones','$estatus','$idUsuario','$externoNoEconomico','$noEconomico','$justificacion')";
                $result=mysqli_query($this->link, $query)or die(mysqli_error());
                $id = mysqli_insert_id($this->link);

                if($result)
                {
                    if($estatus == 0)
                    {
                        $queryC="UPDATE vales_gasolina SET estatus=0, observaciones=CONCAT('CANCELACIÓN ',observaciones), justificacion_cancelacion='$justificacion' WHERE id=".$idRegistro;
                        $resultC = mysqli_query($this->link, $queryC) or die(mysqli_error());

                        if($resultC)
                        {
                            $verifica = $id;
                        }else{
                            $verifica = 0;
                        }
                    }else{
                        $verifica = $id;
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
    }//- fin function guardar

    /** 
      * Cancela el registro de vale de casolina
      * @param int $idRegistro id del registro que se actualiza a cancelado (estatus=0)
    **/
    function cancelarValesGasolina($idRegistro,$justificacion){
        $queryB="SELECT id_unidad_negocio,id_sucursal,id_area,id_departamento,id_concepto,clave_concepto,fecha,id_empleado,nombre_empleado,importe,CONCAT('CANCELACIÓN ',observaciones) AS observaciones,id_usuario,externo_no_economico,no_economico
                    FROM vales_gasolina 
                    WHERE id=".$idRegistro;
        $resultB = mysqli_query($this->link, $queryB) or die(mysqli_error());

        if($resultB)
        {
            $datos=mysqli_fetch_array($resultB);

            $importe = $datos['importe'] * (-1);

            $arr=array('idUnidadNegocio'=>$datos['id_unidad_negocio'],
                        'idSucursal'=>$datos['id_sucursal'],
                        'idArea'=>$datos['id_area'],
                        'idDepartamento'=>$datos['id_departamento'],
                        'idConcepto'=>$datos['id_concepto'],
                        'claveConcepto'=>$datos['clave_concepto'],
                        'fecha'=>$datos['fecha'],
                        'idEmpleado'=>$datos['id_empleado'],
                        'empleado'=>$datos['nombre_empleado'],
                        'importe'=>$importe,
                        'observaciones'=>$datos['observaciones'],
                        'idUsuario'=>$datos['id_usuario'],
                        'externoNoEconomco'=>$datos['externo_no_economico'],
                        'noEconomico'=>$datos['no_economico'],
                        'estatus'=>0,
                        'justificacion'=>$justificacion,
                        'idRegistro'=>$idRegistro);

            $verifica = $this -> guardar($arr);
        }else{
            $verifica = 0;
        }

        return $verifica;
    }//- fin function cancelarValesGasolina

    /**
      * Busca el saldo actual 
      * 
      * @param int idSucursal 
      *
    **/
    function buscarSaldoActualIdSucursal($idSucursal){
        $result = $this->link->query("SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo
                                        FROM vales_gasolina
                                        WHERE id_sucursal=$idSucursal AND fecha <= CURDATE()
                                        GROUP BY id_sucursal");

        return query2json($result);
    }//- fin function buscarSaldoActualIdSucursal

    /**
      * Busca registros de vales de gasolina de la sucursal y fechas seleccionadas (por default es del mes actual) 
      * 
      * @param varchar $datos array que contiene los datos
      *
    **/
    function buscarValesGasolinaReporte($datos)
    {

        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idSucursal = $datos['idSucursal'];

        $condicion='';

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND a.fecha >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        $result = $this->link->query("SELECT a.id,IFNULL(a.folio,'') AS folio,a.fecha,CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,
                                        a.nombre_empleado,a.importe,a.observaciones,a.no_economico,c.nombre AS unidad_negocio,
                                        d.descr AS sucursal,IFNULL(e.descripcion,'') AS area, IFNULL(f.des_dep,'') AS departamento, 
                                        IFNULL(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS empleado
                                        FROM vales_gasolina a
                                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                                        LEFT JOIN cat_areas e ON a.id_area=e.id
                                        LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
                                        LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
                                        WHERE a.id_sucursal=$idSucursal $condicion
                                        ORDER BY a.id ASC");

        return query2json($result);
    }//- fin function buscarValesGasolina

    /**
      * Busca el saldo inicial (fecha inicio) y final (fecha fin) de vales de gasolina
      * 
      * @param varchar $datos array que contiene los datos
      *
    **/
    function buscarValesGasolinaSaldosReporte($datos)
    {

        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idSucursal = $datos['idSucursal'];

        $saldo_inicial = 0;
        $saldo_final = 0;

        // AND fecha<='$fechaInicio'
        $query1="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_inicial
                    FROM vales_gasolina
                    WHERE id_sucursal=$idSucursal AND fecha <= DATE_ADD('$fechaInicio', INTERVAL -1 DAY)
                    GROUP BY id_sucursal";
        $result1 = mysqli_query($this->link, $query1) or die(mysqli_error());

        if($result1)
        {
            $datos=mysqli_fetch_array($result1);
            if($datos['saldo_inicial'] != '')
            {
                $saldo_inicial = $datos['saldo_inicial'];
            }else{
                $saldo_inicial = 0;
            }
        }
        
        $query2="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_final
                    FROM vales_gasolina
                    WHERE id_sucursal=$idSucursal AND fecha<='$fechaFin'
                    GROUP BY id_sucursal";
        $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

        if($result2)
        {
            $datos2=mysqli_fetch_array($result2);
            if($datos2['saldo_final'] != '')
            {
                $saldo_final = $datos2['saldo_final'];
            }else{
                $saldo_final = 0;
            }
        }

        $arreglo = array('saldo_inicial'=>$saldo_inicial,'saldo_final'=>$saldo_final);

        return json_encode($arreglo);
    }//- fin function buscarValesGasolinaSaldosReporte


        /**
      * Busca los registros de vales de gasolina del día actual
      * 
    **/
    function buscarValesGasolinaId($idVale){
        
    
        $result = $this->link->query("SELECT 
            a.id,
            a.id_sucursal,
            a.id_unidad_negocio,
            a.id_area,
            a.id_departamento,
            IFNULL(a.folio,'') AS folio,
            a.fecha,
            a.clave_concepto,
            CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,
            a.id_empleado,
            ifnull(a.nombre_empleado,'') as nombre_empleado,
            a.importe,
            a.observaciones,
            c.nombre AS unidad_negocio,
            a.externo_no_economico,
            a.no_economico,
            d.descr AS sucursal,
            IFNULL(e.descripcion,'') AS area, 
            IFNULL(f.des_dep,'') AS departamento, 
            ifnull(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS empleado,
            a.estatus
        FROM vales_gasolina a
        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
        LEFT JOIN cat_areas e ON a.id_area=e.id
        LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
        LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
        WHERE a.id=".$idVale." 
        ORDER BY folio");

        return query2json($result);
    }//- fin function buscarValesGasolinaHoy
    
}//--fin de class ValesGasolina
    
?>