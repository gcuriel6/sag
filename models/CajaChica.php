<?php

include 'conectar.php';

class CajaChica
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function CajaChica()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los registros de caja chica del día actual
      * 
    **/
    function buscarCajaChicaHoy($idSucursal){
        
    
        $result = $this->link->query("SELECT a.id,IFNULL(a.folio,'') AS folio,a.fecha,a.clave_concepto,CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,
                                        a.nombre_empleado,a.importe,a.observaciones,c.nombre AS unidad_negocio,
                                        d.descr AS sucursal,IFNULL(e.descripcion,'') AS area, IFNULL(f.des_dep,'') AS departamento, 
                                        IFNULL(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS empleado,a.estatus
                                        FROM caja_chica a
                                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                                        LEFT JOIN cat_areas e ON a.id_area=e.id
                                        LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
                                        LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
                                        WHERE a.id_sucursal=$idSucursal AND a.fecha=CURDATE() 
                                        ORDER BY folio");

        return query2json($result);
    }//- fin function buscarCajaChicaHoy

    /**
      * Busca registro de caja chica
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarCajaChica($datos){
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function guardarCajaChica

    /**
      * Busca registro de vales de gasolina
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardar($datos){
        $verifica = 0;

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

        $queryFolio="SELECT folio_caja_chica FROM sucursales WHERE id_sucursal=".$idSucursal;
        $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
        
        if($resultF)
        {
            $datos=mysqli_fetch_array($resultF);
            $folioA=$datos['folio_caja_chica'];
            $folio= $folioA+1;

            $queryU = "UPDATE sucursales SET folio_caja_chica='$folio' WHERE id_sucursal=".$idSucursal;
            $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
            if($resultU)
            {
                $query="INSERT INTO caja_chica(folio,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_concepto,clave_concepto,fecha,id_empleado,nombre_empleado,importe,observaciones,estatus,id_usuario)
                        VALUES('$folio','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idConcepto','$claveConcepto','$fecha','$idEmpleado','$empleado','$importe','$observaciones','$estatus','$idUsuario')";
                $result=mysqli_query($this->link, $query)or die(mysqli_error());
                $id = mysqli_insert_id($this->link);

                if($result)
                {
                    if($estatus == 0)
                    {
                        $queryC="UPDATE caja_chica SET estatus=0,observaciones='$observaciones' WHERE id=".$idRegistro;
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
      * Cancela el registro de caja chica
      * @param int $idRegistro id del registro que se actualiza a cancelado (estatus=0)
    **/
    function cancelarCajaChica($idRegistro){
        $queryB="SELECT id_unidad_negocio,id_sucursal,id_area,id_departamento,id_concepto,clave_concepto,fecha,id_empleado,nombre_empleado,importe,observaciones,id_usuario
                    FROM caja_chica 
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
                        'observaciones'=>'CANCELACIÓN '.$datos['observaciones'],
                        'idUsuario'=>$datos['id_usuario'],
                        'estatus'=>0,
                        'idRegistro'=>$idRegistro);

            $verifica = $this -> guardar($arr);
        }else{
            $verifica = 0;
        }

        return $verifica;
    }//- fin function cancelarCajaChica

    /**
      * Busca el saldo actual 
      * 
      * @param int idSucursal 
      *
    **/
    function buscarSaldoActualIdSucursal($idSucursal){
        $result = $this->link->query("SELECT IFNULL(SUM(IF(b.clave_concepto IN('C01','D01'),b.importe,b.importe*(-1))),0)AS saldo
                                        FROM sucursales a
                                        LEFT JOIN caja_chica b ON b.id_sucursal=a.id_sucursal
                                        WHERE a.id_sucursal=$idSucursal AND b.fecha <= CURDATE()
                                        GROUP BY a.id_sucursal");

        return query2json($result);
    }//- fin function buscarSaldoActualIdSucursal

    /**
      * Busca registros de caja chica de la sucursal y fechas seleccionadas (por default es del mes actual) 
      * 
      * @param varchar $datos array que contiene los datos
      *
    **/
    function buscarCajaChicaReporte($datos){
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
                                        IF(a.estatus=1,'Activo','Cancelado') AS estatus,
                                        a.nombre_empleado,a.importe,a.observaciones,c.nombre AS unidad_negocio,a.id_sucursal,a.id_area,
                                        d.descr AS sucursal,IFNULL(e.descripcion,'') AS area, IFNULL(f.des_dep,'') AS departamento, 
                                        IFNULL(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS empleado,
                                        IF(a.clave_concepto IN('C01','D01'),a.importe,a.importe*(-1)) as saldo
                                        FROM caja_chica a
                                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                                        LEFT JOIN cat_areas e ON a.id_area=e.id
                                        LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
                                        LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
                                        WHERE a.id_sucursal=$idSucursal $condicion
                                        ORDER BY a.id ASC");

        return query2json($result);
    }//- fin function buscarCajaChica

    /**
      * Busca el saldo inicial (fecha inicio) y final (fecha fin) de caja chica
      * 
      * @param varchar $datos array que contiene los datos
      *
    **/
    function buscarCajaChicaSaldosReporte($datos){
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idSucursal = $datos['idSucursal'];

        $saldo_inicial = 0;
        $saldo_final = 0;

        $query1="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_inicial
                    FROM caja_chica
                    WHERE id_sucursal=$idSucursal AND fecha<='$fechaInicio'
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
                    FROM caja_chica
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
    }//- fin function buscarCajaChicaSaldosReporte

    function buscarCajaChicaId($idCajaChica){
        $result = $this->link->query("SELECT a.folio,
                    a.id_unidad_negocio,c.nombre AS unidad_negocio,
                    a.id_sucursal,d.descr AS sucursal,
                    a.id_area,IFNULL(e.descripcion,'') AS area,
                    a.id_departamento,IFNULL(f.des_dep,'') AS departamento,
                    a.id_concepto,CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,
                    a.fecha,
                    a.id_empleado,IF(a.id_empleado>0,CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),a.nombre_empleado) AS nombre_empleado,
                    a.importe,a.observaciones,a.estatus
                    FROM caja_chica a
                    LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                    LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                    LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                    LEFT JOIN cat_areas e ON a.id_area=e.id
                    LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
                    LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
                    WHERE a.id=".$idCajaChica);

        return query2json($result);
    }//- fin function buscarCajaChicaId
    
}//--fin de class CajaChica
    
?>