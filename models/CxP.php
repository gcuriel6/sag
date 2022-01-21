<?php

include 'conectar.php';

class CxP
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function CxP()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los proveedores de los registros de CxP
      * 
      * @param varchar $factura . Si es != 0  buscar todos los proveedores que coincidan con esa factura
      *
    **/
    function buscarProveedoresCxP($datos){

        $factura = $datos['factura'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];

        $condicion='';
        $condFecha='';

        if($factura!=0)
        {
            $condicion=' AND a.id_cxp ='.$factura;

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condFecha=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condFecha=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condFecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }
        }else{
            if($fechaInicio == '' && $fechaFin == '')
            {
                $condFecha=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condFecha=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condFecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }
        }

        $resultado = $this->link->query("SELECT a.id_proveedor,b.nombre,b.rfc,b.grupo,IF(b.inactivo=0,'Activo','Inactivo') AS estatus
                                            FROM cxp a
                                            LEFT JOIN proveedores b ON a.id_proveedor=b.id
                                            WHERE a.id_viatico=0 $condicion $condFecha
                                            GROUP BY a.id_proveedor 
                                            ORDER BY b.nombre DESC");

        return query2json($resultado);

    }//- fin function buscarProveedoresCxP

    /**
      * Busca todas las facturas, o todas las facturas de un proveedor
      * 
      * @param int $idProveedor id del proveedor para buscar sus facturas. 
      * Si es != 0  buscar todos las facturas de ese proveedor, sino busca todas
      *
    **/
    function buscarFacturasCxP($datos){

        $idProveedor = $datos['idProveedor'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];

        $condicion='';
        $condFecha='';

        if($idProveedor!=0)
        {
            $condicion=' AND a.id_proveedor ='.$idProveedor;

            if($fechaInicio == '' && $fechaFin == '')
            {
                $condFecha=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 60 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condFecha=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condFecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }
        }else{
            if($fechaInicio == '' && $fechaFin == '')
            {
                $condFecha=" AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 60 DAY) ";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condFecha=" AND a.fecha >= '$fechaInicio' ";
            }else{  //-->trae fecha inicio y fecha fin
                $condFecha=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
            }
        }

        $query = "SELECT a.id,a.no_factura,a.id_proveedor,c.nombre AS proveedor,IFNULL(a.fecha,'') AS fecha,
                    CONCAT(b.clave,' ',b.descripcion) AS concepto,
                    IF(a.estatus = 'C','Cancelada',IF(IFNULL(SUM(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),((a.subtotal + a.iva -a.descuento) * -(1)))),0) = 0,'Liquidada','Pendiente')) AS estatus,
                    IFNULL((a.subtotal+a.iva -a.descuento),0) AS cargo,IFNULL(SUM(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),((a.subtotal + a.iva -a.descuento) * -(1)))),0) AS importe,
                    IF(MONTH(a.fecha) = MONTH(CURDATE()) AND YEAR(a.fecha) = YEAR(CURDATE()),1,0) AS bandera_cancela
                    FROM cxp a
                    LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                    LEFT JOIN proveedores c ON a.id_proveedor=c.id
                    WHERE a.id_viatico=0  AND a.id_cxp IN(SELECT DISTINCT(a.id_cxp ) AS id_cxp FROM cxp a  WHERE a.id_viatico=0 $condicion $condFecha) 
                    GROUP BY a.id_cxp
                    ORDER BY a.fecha DESC";

        // echo $query;
        // exit();
   
        $resultado = $this->link->query($query);

        return query2json($resultado);
    }//- fin function buscarFacturasCxP

    /**
      * Guardo cxp los cargos y abonos a una factura
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarCxP($datos){
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function guardarCxP

    /**
      * Guardo cxp los cargos y abonos a una factura
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarActualizar($datos){
        $verifica = 0;

        $idCxP = $datos['idCxP'];
        $factura = $datos['factura'];
        $idProveedor = $datos['idProveedor'];
        $idConcepto = $datos['idConcepto'];
        $claveConcepto = $datos['claveConcepto'];
        $fecha = $datos['fecha'];
        $importe = $datos['importe'];
        $referencia = $datos['referencia'];
        $idBanco = $datos['idBanco'];
        $idCuentaBanco = $datos['idCuentaBanco'];
        $idUsuario = $datos['idUsuario'];
        $estatus = isset($datos['estatus']) ? $datos['estatus'] : '';
        $idRegistro = isset($datos['idRegistro']) ? $datos['idRegistro'] : 0;
        $tipoCuenta = $datos['tipoCuenta'];
        $concepto = $datos['concepto'];
        $justificacion = isset($datos['justificacion']) ? $datos['justificacion'] : '';

        

            $query = "INSERT INTO cxp(id_cxp,id_proveedor,no_factura,id_concepto,clave_concepto,fecha,subtotal,referencia,id_banco,id_cuenta_banco,estatus,justificacion) 
                        VALUES ('$idCxP','$idProveedor','$factura','$idConcepto','$claveConcepto','$fecha','$importe','$referencia','$idBanco','$idCuentaBanco','$estatus','$justificacion')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $id = mysqli_insert_id($this->link);

            if ($result) 
            {
                //if($this -> generarMovimientosEgresos($datos,$id) == 1 ){

                    if($estatus != '')
                    {
                        $saldo_act = "SELECT IFNULL(SUM(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),((a.subtotal + a.iva -a.descuento) * -(1)))),0) AS saldo
                                        FROM cxp a
                                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                        WHERE a.id_cxp = $idCxP
                                        GROUP BY a.id_cxp";
                        $result_act = mysqli_query($this->link, $saldo_act) or die(mysqli_error());
                        
                        $datos_act = mysqli_fetch_array($result_act);
                        $saldo_actual = $datos_act['saldo'];

                        $queryC="UPDATE cxp SET estatus='C',justificacion='$justificacion' WHERE id=".$idRegistro;
                        $resultC = mysqli_query($this->link, $queryC) or die(mysqli_error());

                        if($resultC)
                        {
                            $arr=array();
                            $arr[0]=0;
                            $arr2=array();
                            $arr2[0]=0;
                            if($tipoCuenta==0)
                            {
                                $arr[0]=1;
                                $arr[1]=array('id'=>$id,
                                                'claveConcepto'=>$claveConcepto,
                                                'idConcepto'=>$idConcepto,
                                                'importe'=>$importe,
                                                'idCuentaBanco'=>$idCuentaBanco,
                                                'estatus'=>$estatus,
                                                'idUsuario'=>$idUsuario,
                                                'concepto'=>$concepto,
                                                'tipoCuenta'=>$tipoCuenta,
                                                'fecha'=>$fecha);
                            }else{
                                $arr2[0]=1;
                                $arr2[1]=array('id'=>$id,
                                                'claveConcepto'=>$claveConcepto,
                                                'idConcepto'=>$idConcepto,
                                                'importe'=>$importe,
                                                'idCuentaBanco'=>$idCuentaBanco,
                                                'estatus'=>$estatus,
                                                'idUsuario'=>$idUsuario,
                                                'concepto'=>$concepto,
                                                'tipoCuenta'=>$tipoCuenta,
                                                'fecha'=>$fecha); 
                            }

                            if($saldo_actual == 0)
                            {
                                $queryA="UPDATE cxp SET estatus='L' WHERE id=".$idCxP;
                                $resultA = mysqli_query($this->link, $queryA) or die(mysqli_error());
                                
                                if($resultA)
                                    $verifica = $this -> guardaMovimientoBanco($arr,$arr2,$idCxP);
                                else
                                    $verifica = 0;
                            }else
                                $verifica = $this -> guardaMovimientoBanco($arr,$arr2,$idCxP);
                        }else{
                            $verifica = 0;
                        }

                    }else{
                        $saldo_act = "SELECT IFNULL(SUM(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),((a.subtotal + a.iva -a.descuento) * -(1)))),0) AS saldo
                                        FROM cxp a
                                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                        WHERE a.id_cxp = $idCxP
                                        GROUP BY a.id_cxp";
                        $result_act = mysqli_query($this->link, $saldo_act) or die(mysqli_error());
                        
                        $datos_act = mysqli_fetch_array($result_act);
                        $saldo_actual = $datos_act['saldo'];

                        if($claveConcepto == 'A02')  //--> si es un abono por cancelación no registro en movimientos_banco
                        {
                            if($saldo_actual == 0)
                            {
                                $queryA="UPDATE cxp SET estatus='L' WHERE id=".$idCxP;
                                $resultA = mysqli_query($this->link, $queryA) or die(mysqli_error());
                                
                                if($resultA)
                                    $verifica = $idCxP;
                                else
                                    $verifica = 0;
                            }else
                                $verifica = $idCxP;
                        }else{    //--> registro en movimientos_banco el movimiento o en caja_chica
                            $arr=array();
                            $arr[0]=0;
                            $arr2=array();
                            $arr2[0]=0;
                            if($tipoCuenta==0)
                            {
                                $arr[0]=1;
                                $arr[1]=array('id'=>$id,
                                            'claveConcepto'=>$claveConcepto,
                                            'idConcepto'=>$idConcepto,
                                            'importe'=>$importe,
                                            'idCuentaBanco'=>$idCuentaBanco,
                                            'estatus'=>$estatus,
                                            'idUsuario'=>$idUsuario,
                                            'concepto'=>$concepto,
                                            'tipoCuenta'=>$tipoCuenta,
                                            'fecha'=>$fecha);
                            }else{
                                $arr2[0]=1;
                                $arr2[1]=array('id'=>$id,
                                            'claveConcepto'=>$claveConcepto,
                                            'idConcepto'=>$idConcepto,
                                            'importe'=>$importe,
                                            'idCuentaBanco'=>$idCuentaBanco,
                                            'estatus'=>$estatus,
                                            'idUsuario'=>$idUsuario,
                                            'concepto'=>$concepto,
                                            'tipoCuenta'=>$tipoCuenta,
                                            'fecha'=>$fecha); 
                            }

                            if($saldo_actual == 0)
                            {
                                $queryA="UPDATE cxp SET estatus='L' WHERE id=".$idCxP;
                                $resultA = mysqli_query($this->link, $queryA) or die(mysqli_error());
                                
                                if($resultA)
                                    $verifica = $this -> guardaMovimientoBanco($arr,$arr2,$idCxP);
                                else
                                    $verifica = 0;
                            }else
                                $verifica = $this -> guardaMovimientoBanco($arr,$arr2,$idCxP);
                        }
                     
                    }
                //}else{//--fin genera movimeintos_egreso
                  //  $verifica = 0;
                //}
            }else{//---fin result
                $verifica = 0;
            }
        
        return $verifica;
    }//- fin function guardarActualizar

    /**
      * Guardo en la tabla movimientos_bancos el movimiento por el monto que se ingresa o quita.
      * si es un abono se registra el monto negativo
      * si es un cargo se registra el monto positivo
      * 
      * @param varchar $datos array que contiene los datos
      * @param int id_cxp de la factura que se esta generando los movimientos 
      *
    **/
    function guardaMovimientoBanco($datos,$datos2,$idCxP){
        $verifica = 0;
        if($datos[0]>0)
        {
            for($i=1;$i<=$datos[0];$i++){
                
                $id = $datos[$i]['id'];
                $claveConcepto = $datos[$i]['claveConcepto'];
                $importe = $datos[$i]['importe'];
                $idCuentaBanco = $datos[$i]['idCuentaBanco'];
                $estatus = isset($datos[$i]['estatus']) ? $datos[$i]['estatus'] : '';
                $tipo = isset($datos[$i]['tipo']) ? $datos[$i]['tipo'] : '';
                $idUsuario = $datos[$i]['idUsuario'];
                $tipoCuenta= $datos[$i]['tipoCuenta'];
                $observaciones = $datos[$i]['concepto'];
                $fecha = $datos[$i]['fecha'];

                $clave=substr($claveConcepto,0,1);

                if($estatus == 'C')  //--> si es un cargo o abono cancelado (LOS MONTOS VIENEN NEGATIVOS)
                {
                    $est=0;
                    if($clave == 'C')  //--> Si es un cargo inserto el monto negativo.
                    {
                        $monto = $importe;
                    }else{ //--> Si es un abono inserto el monto positivo. (lo multiplico por negativo para que me de positivo)
                        $monto = $importe * (-1);
                    }
                }else{
                    $est=1;
                    if($tipo == 'completa')
                    {  //--> se cancelo una factura y se van a hacer contrapartidas de sus cargo-abonos no cancelados
                        if($clave == 'C')  //--> Si es un cargo inserto el monto positivo
                        {
                            $monto = $importe * (-1);
                        }else{ //--> Si es un abono inserto el monto negativo
                            $monto = $importe;
                        }
                    }else{
                        if($clave == 'C')  //--> Si es un cargo inserto el monto positivo
                        {
                            $monto = $importe;
                        }else{ //--> Si es un abono inserto el monto negativo
                            $monto = $importe * (-1);
                        }
                    }
                }

                $query = "INSERT INTO movimientos_bancos(id_cuenta_banco,monto,tipo,observaciones,estatus,id_usuario,id_cxp,fecha_aplicacion) 
                            VALUES ('$idCuentaBanco','$monto','$clave','$observaciones','$est','$idUsuario','$id','$fecha')";
                $result = mysqli_query($this->link, $query) or die(mysqli_error());

                if($result)
                { 
                    if($i==$datos[0])
                    {
                        $verifica = $this -> guardaCajaChica($datos2,$idCxP);
                    }            
                }else{
                    $verifica = 0;
                    break;
                }
            }
        }else{
            $verifica = $this -> guardaCajaChica($datos2,$idCxP);
        }

        return $verifica;
    }//- fin function guardaMovimientoBanco

    /**
      * Guardo en la tabla caja_chica el monto que se ingresa o quita.
      * si es un abono se registra el monto negativo
      * si es un cargo se registra el monto positivo
      * 
      * @param varchar $datos array que contiene los datos
      * @param int id_cxp de la factura que se esta generando los movimientos 
      *
    **/
    function guardaCajaChica($datos,$idCxP){
        $verifica = 0;

        if($datos[0]>0)
        {
            for($i=1;$i<=$datos[0];$i++){

                $id = $datos[$i]['id'];
                $claveConcepto = $datos[$i]['claveConcepto'];
                $importe = $datos[$i]['importe'];
                $idCuentaBanco = $datos[$i]['idCuentaBanco'];
                $estatus = isset($datos[$i]['estatus']) ? $datos[$i]['estatus'] : '';
                $tipo = isset($datos[$i]['tipo']) ? $datos[$i]['tipo'] : '';
                $idUsuario = $datos[$i]['idUsuario'];
                $observaciones = $datos[$i]['concepto'];
                $fecha = $datos[$i]['fecha'];

                $clave=substr($claveConcepto,0,1);

                if($estatus == 'C')  //--> si es un cargo o abono cancelado (LOS MONTOS VIENEN NEGATIVOS)
                {
                    $est=0;
                    if($clave == 'C')  //--> Si es un cargo inserto el monto negativo.
                    {
                        $monto = $importe;
                    }else{ //--> Si es un abono inserto el monto positivo. (lo multiplico por negativo para que me de positivo)
                        $monto = $importe * (-1);
                    }
                }else{
                    $est=1;
                    if($tipo == 'completa')
                    {  //--> se cancelo una factura y se van a hacer contrapartidas de sus cargo-abonos no cancelados
                        if($clave == 'C')  //--> Si es un cargo inserto el monto positivo
                        {
                            $monto = $importe * (-1);
                        }else{ //--> Si es un abono inserto el monto negativo
                            $monto = $importe;
                        }
                    }else{
                        if($clave == 'C')  //--> Si es un cargo inserto el monto positivo
                        {
                            $monto = $importe;
                        }else{ //--> Si es un abono inserto el monto negativo
                            $monto = $importe * (-1);
                        }
                    }
                }

                //-->busco id_unidad_negocio, id_sucursal de la cuenta banco origen de la que voy a hacer un egreso
                $buscaCuenta = "SELECT id_unidad_negocio,id_sucursal 
                                FROM cuentas_bancos WHERE id=".$idCuentaBanco;
                $resultC = mysqli_query($this->link, $buscaCuenta) or die(mysqli_error());
        
                if($resultC)
                {
                    $datosC=mysqli_fetch_array($resultC);
                    $idUnidadNegocio=$datosC['id_unidad_negocio']; 
                    $idSucursal=$datosC['id_sucursal']; 

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
                            //--> Inserta en caja chica el ingreso o egreso
                            $query="INSERT INTO caja_chica(folio,id_unidad_negocio,id_sucursal,id_concepto,clave_concepto,fecha,importe,observaciones,estatus,id_usuario,id_cxp)
                                    VALUES('$folio','$idUnidadNegocio','$idSucursal',16,'G01','$fecha','$monto','$observaciones','$est','$idUsuario','$id')";
                            $result=mysqli_query($this->link, $query)or die(mysqli_error());
                            $id = mysqli_insert_id($this->link);

                            if($result)
                            {
                                if($i==$datos[0])
                                {
                                    $verifica = $idCxP; 
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
        }else{
            $verifica = $idCxP; 
        }
        return $verifica;
    }//- fin function guardaCajaChica

    /**
      * Busca el saldo actual de la factura
      * 
      * @param int id_cxp de la factura
      *
    **/
    function buscarSaldoActualIdCxP($idCxP){
        $resultado = $this->link->query("SELECT IFNULL(SUM(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva - a.descuento),((a.subtotal + a.iva - a.descuento) * -(1)))),0) AS saldo
                                            FROM cxp a
                                            LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                            WHERE a.id_cxp = $idCxP
                                            GROUP BY a.id_cxp");

        return query2json($resultado);
    }//- fin function buscarSaldoActualIdCxP

    /**
      * Busca los cargos y abonos de una factura
      * 
      * @param int id_cxp de la factura
      *
    **/
    function buscarRegistrosIdCxP($idCxP){
        $resultado = $this->link->query("SELECT a.estatus,a.id,b.clave AS clave_concepto,b.descripcion AS concepto_cxp,a.fecha,IFNULL(a.referencia,'') AS referencia,
                                            IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento ),0) AS cargos,
                                            IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva  -a.descuento),0) AS abonos
                                            FROM cxp a
                                            LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                            WHERE a.id_cxp = $idCxP
                                            ORDER BY a.id ASC,a.fecha DESC");

        return query2json($resultado);
    }//- fin function buscarRegistrosIdCxP

    /**
      * Cancela una partida de una factura o la factura completa
      * 
      * @param varchar $tipo indica si se cancela una factura o una partida
      * @param int $idRegistro id de la partida para cancelar o id_cxp para cancelar la factura completa con sus partidas
      * @param int $idUsuario id del usuario que genera el movimiento
      *
    **/
    function cancelarCxP($tipo,$idRegistro,$idUsuario,$justificacion){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarcancelarCxP($tipo,$idRegistro,$idUsuario,$justificacion);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function cancelarCxP

    /**
      * Cancela una partida de una factura o la factura completa
      * 
      * @param varchar $tipo indica si se cancela una factura o una partida
      * @param int $idRegistro id de la partida para cancelar o id_cxp para cancelar la factura completa con sus partidas
      * @param int $idUsuario id del usuario que genera el movimiento
      *
    **/
    function guardarcancelarCxP($tipo,$idRegistro,$idUsuario,$justificacion){
        //---cancelo todos los registros de el folio cancelado en moviemientos presupuesto
        if($this -> cancelaMovimientosPresupuesto($tipo,$idRegistro)==1)
        {

            if($tipo == 'factura')
            {
                //--> busco el numero de partidas de una factura
                $busca="SELECT COUNT(id) AS num_registros FROM cxp WHERE id_cxp=".$idRegistro;
                $result_busca = mysqli_query($this->link, $busca) or die(mysqli_error());

                if($result_busca)
                {
                    $datos=mysqli_fetch_array($result_busca);
                    $valor = $datos['num_registros'];
                    if($valor == 1)  //--> si solo tiene un movimiento no voy a generar registro em movimientos_banco
                    {
                        //--> Cancelo todas las partidas de esa factura
                        $query="UPDATE cxp SET estatus='C',justificacion='$justificacion' WHERE id_cxp=".$idRegistro;
                        $result = mysqli_query($this->link, $query) or die(mysqli_error());

                        if($result)
                        {
                            $verifica = 1;
                        }else{
                            $verifica = 0;
                        }
                
                    }else{  //--> busco los abonos y cargos no cancelados
                        $busca_noC="SELECT a.id,a.clave_concepto,a.subtotal,a.id_cuenta_banco,b.descripcion AS concepto,c.tipo AS tipo_cuenta,a.fecha
                                    FROM cxp a 
                                    LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                    LEFT JOIN cuentas_bancos c ON a.id_cuenta_banco=c.id
                                    WHERE a.id_cxp=$idRegistro AND a.estatus != 'C' AND a.id != $idRegistro";
                        $result_noC = mysqli_query($this->link, $busca_noC) or die(mysqli_error());
                        $num_noC=mysqli_num_rows($result_noC);
                        if($num_noC > 0)
                        {
                            $num=mysqli_num_rows($result_noC);
                            $numB=0;
                            $numC=0;
                            $arr=array();
                            $arr[0]=$numB;

                            $arr2=array();
                            $arr2[0]=$numC;

                            for ($i=1; $i <=$num ; $i++) { 
                                $row=mysqli_fetch_array($result_noC);

                                if($row['tipo_cuenta'] == 0)
                                {
                                    $numB++;

                                    $arr[$numB]=array('id'=>$row['id'],
                                                'claveConcepto'=>$row['clave_concepto'],
                                                'importe'=>$row['subtotal'],
                                                'idCuentaBanco'=>$row['id_cuenta_banco'],
                                                'tipo'=>'completa',
                                                'idUsuario',$idUsuario,
                                                'concepto'=>$row['clave_concepto'].' '.$row['concepto'],
                                                'tipoCuenta'=>$row['tipo_cuenta'],
                                                'fecha'=>$row['fecha']);

                                    $arr[0]=$numB;
                                }else{
                                    $numC++;

                                    $arr2[$numC]=array('id'=>$row['id'],
                                                'claveConcepto'=>$row['clave_concepto'],
                                                'importe'=>$row['subtotal'],
                                                'idCuentaBanco'=>$row['id_cuenta_banco'],
                                                'tipo'=>'completa',
                                                'idUsuario',$idUsuario,
                                                'concepto'=>$row['clave_concepto'].' '.$row['concepto'],
                                                'tipoCuenta'=>$row['tipo_cuenta'],
                                                'fecha'=>$row['fecha']);

                                    $arr2[0]=$numC;
                                }
                                if($i == $num)
                                {
                                    //--> Cancelo todas las partidas de esa factura
                                    $query="UPDATE cxp SET estatus='C',justificacion='$justificacion' WHERE id_cxp=".$idRegistro;
                                    $result = mysqli_query($this->link, $query) or die(mysqli_error());

                                    if($result)
                                    {   //--> guardar en movimientos_banco los montos no cancelados de la factura cancelada 
                                        $verifica = $this -> guardaMovimientoBanco($arr,$arr2,$idRegistro);
                                    }else{
                                        $verifica = 0;
                                    }
                                }
                            }

                        }else{
                            //--> Cancelo todas las partidas de esa factura
                            $query="UPDATE cxp SET estatus='C',justificacion='$justificacion' WHERE id_cxp=".$idRegistro;
                            $result = mysqli_query($this->link, $query) or die(mysqli_error());

                            if($result)
                            {
                                $verifica = 1;
                            }else{
                                $verifica = 0;
                            }
                        }
                    }
                }else{
                    $verifica = 0;
                }
                

            }else{
                $queryB="SELECT a.id_cxp,a.id_proveedor,a.no_factura,a.id_concepto,a.clave_concepto,b.descripcion AS concepto,
                            a.fecha,(subtotal+iva -descuento) AS subtotal,a.referencia,a.id_banco,a.id_cuenta_banco,c.tipo AS tipo_cuenta
                            FROM cxp a
                            LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                            LEFT JOIN cuentas_bancos c ON a.id_cuenta_banco=c.id
                            WHERE a.id=".$idRegistro;
                $resultB = mysqli_query($this->link, $queryB) or die(mysqli_error());

                if($resultB)
                {
                    $datos=mysqli_fetch_array($resultB);

                    $importe = $datos['subtotal'] * (-1);

                    $arr=array('idCxP'=>$datos['id_cxp'],
                                'factura'=>$datos['no_factura'],
                                'idProveedor'=>$datos['id_proveedor'],
                                'idConcepto'=>$datos['id_concepto'],
                                'claveConcepto'=>$datos['clave_concepto'],
                                'fecha'=>$datos['fecha'],
                                'importe'=>$importe,
                                'referencia'=>$datos['referencia'],
                                'idBanco'=>$datos['id_banco'],
                                'idCuentaBanco'=>$datos['id_cuenta_banco'],
                                'estatus'=>'C',
                                'justificacion'=>$justificacion,
                                'idRegistro'=>$idRegistro,
                                'idUsuario'=>$idUsuario,
                                'concepto'=>$datos['concepto'],
                                'tipoCuenta'=>$datos['tipo_cuenta']);

                    $verifica = $this -> guardarActualizar($arr);
                }else{
                    $verifica = 0;
                }
            }

        }else{//---si ocurre un error al cancelar movimientos presupuesto
            $verifica = 0;
        }

        return $verifica;
    }//- fin function guardarcancelarCxP

    /**
      * Busca el cargo inicial de una factura
      * 
      * @param int $idCxP de la factura
      *
    **/
    function buscarCargoInicialIdCxP($idCxP){
        $resultado = $this->link->query("SELECT id,(subtotal+iva -descuento) AS cargo_inicial FROM cxp WHERE id=".$idCxP);

        return query2json($resultado);
    }//- fin function buscarCargoInicialIdCxP

    /**
      * Busca el estado de cuenta por proveedor
      * 
      * @param varchar $datos array que contiene los datos par la busqueda
      *
    **/
    function buscarEstadoCuentaIdProveedor($datos){
        
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $idProveedor = $datos['idProveedor'];

        $resultado = $this->link->query("SELECT a.id,a.id_cxp,a.no_factura,
                                        b.clave AS concepto,b.descripcion,IFNULL(a.fecha,'') AS fecha,IFNULL(a.referencia,'') AS referencia,
                                        IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0) AS cargos,
                                        IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva -a.descuento),0) AS abonos
                                        FROM cxp a
                                        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                        LEFT JOIN proveedores c ON a.id_proveedor=c.id
                                        WHERE a.id_proveedor = $idProveedor
                                        AND a.id_viatico=0  AND a.id_cxp IN(SELECT DISTINCT(a.id_cxp ) AS id_cxp FROM cxp a  WHERE a.id_viatico=0  AND a.id_proveedor = $idProveedor AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin') 
                                        ORDER BY a.id ASC,a.fecha DESC");

        return query2json($resultado);
    }//- fin function buscarEstadoCuentaIdProveedor

    function buscarReporteSaldosProveedores(){
        
    
        $resultado = $this->link->query("SELECT  
        a.id_proveedor,	
        b.clave,
        IFNULL(c.nombre,'') AS proveedor,                                   
        (SUM(IF(CURDATE() > DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY),(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0) - IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva-a.descuento),0)),0)))AS vencido,
        (SUM(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0))-SUM(IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva-a.descuento),0))) AS saldo
        FROM cxp a
        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
        LEFT JOIN proveedores c ON a.id_proveedor=c.id
        GROUP BY a.id_proveedor
        HAVING saldo!=0
        ORDER BY a.id ASC,a.fecha DESC");

        return query2json($resultado);
    }//- fin function buscarEstadoCuentaIdProveedor

    function buscarDesgloseSaldosProveedores($idProveedor){
        
    
        $resultado = $this->link->query("SELECT 
        a.id_proveedor,	
        a.fecha,
        a.referencia,
        CONCAT(b.clave,' - ',b.descripcion) AS concepto,
        IFNULL(c.nombre,'') AS proveedor,
        if(a.estatus='C','Cancelada','') as estatus,
        IF(CURDATE() > DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY),'Vencida','') AS vencida,
        (IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0))AS cargos,
        (IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva -a.descuento),0))AS abonos
        FROM cxp a
        LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
        LEFT JOIN proveedores c ON a.id_proveedor=c.id
        WHERE a.id_proveedor=".$idProveedor."
        GROUP BY a.id
        ORDER BY a.id ASC,a.fecha DESC");

        return query2json($resultado);
    }//- fin function buscarEstadoCuentaIdProveedor



    function generarMovimientosEgresos($datos,$id){
        $verifica=0;

        $idCxP = $datos['idCxP'];
        $importe = $datos['importe'];
        $concepto = $datos['concepto'];
        $estatus = isset($datos['estatus']) ? $datos['estatus'] : '';
        /*--- busco las llaves del cargo inicial 
        obtengo el id_unidad_negocio, id_sucursal para poder guardar los datos en cxp y poder generar el contrarecibo 
        con los datos correpondientes a su sucursal y logo de la unidad de negocio */
        $buscaUnidad = "SELECT 
        id_unidad_negocio, 
        IFNULL(id_sucursal,0) AS id_sucursal, 
        IFNULL(id_area,0) AS id_area, 
        IFNULL(id_departamento,0) AS id_departamento,
        IFNULL(id_entrada_compra,0) AS id_entrada_compra 
        FROM cxp 
        WHERE id=".$idCxP;
        $resultUnidad = mysqli_query($this->link, $buscaUnidad) or die(mysqli_error());
        $rowU = mysqli_fetch_array($resultUnidad);
        $idUnidadNegocio = $rowU['id_unidad_negocio'];
        $idSucursal = $rowU['id_sucursal'];
        $idArea = $rowU['id_area'];
        $idDepartamento = $rowU['id_departamento'];
        $idEntradaCompra = $rowU['id_entrada_compra'];

        $tipoC=substr($string1,0,1);      

        if($concepto!='A02' || $tipoC!='C'){
            //---CUANDO SE ABONA O LIQUIDA UN PAGO PORCOMPRA GENERA SU MOVIMIENTO_PRESUPUESTO (por la cantidad abonada)--
            $queryMP = "INSERT INTO movimientos_presupuesto (monto,tipo,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_unidad_negocio_o,id_sucursal_o,id_area_o,id_departamento_o,id_entrada_compra,id_cxp,estatus) 
            VALUES ('$importe','C','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idEntradaCompra','$id','A')";
            $resultMP = mysqli_query($this->link, $queryMP) or die(mysqli_error());

            if($resultMP)
            {
                $verifica = 1;
            }else{
                $verifica = 0;
            }

        }else{

            $verifica = 1;
        } 
        return $verifica; 
    }


    function cancelaMovimientosPresupuesto($tipo,$idRegistro){
        
        $verifica = 0;
        //---SI SE CANCELA UNA FACTURA COMPLETA SE CANCELAN TODOS SUS ABONOS----
        if($tipo=='factura'){

            //--> busco los id  de las partidas de una factura
            $busca="SELECT IFNULL(GROUP_CONCAT(id),'') AS ids FROM cxp WHERE id_cxp=".$idRegistro." AND id!=".$idRegistro;
            $result_busca = mysqli_query($this->link, $busca) or die(mysqli_error());
            $numRows= mysqli_num_rows($result_busca);
            if($numRows>0){

                $rowsD=mysqli_fetch_array($result_busca);
                $ids=$rowsD['ids'];

                if($ids != '')
                {
                    $updateMP="UPDATE movimientos_presupuesto SET estatus='C' WHERE id_cxp IN ($ids)";
                    $resultMP = mysqli_query($this->link, $updateMP) or die(mysqli_error());
                    if($resultMP){
                        $verifica = 1;
                    }else{
                        $verifica = 0;
                    }
                }else{
                    $verifica = 1;
                }

            }else{

                $verifica = 1;
            }
            

        }else{
            //---SI SOLO SE CANCELA UN ABONO -------------------------------------------------------
            $updateMP="UPDATE movimientos_presupuesto SET estatus='C' WHERE id_cxp=".$idRegistro;
            $resultMP = mysqli_query($this->link, $updateMP) or die(mysqli_error());
            if($resultMP){
                $verifica = 1;
            }else{
                $verifica = 0;
            }

        }

        return $verifica;
    }
    /**
     * Funcion que obtiene todas las facturas saldadas de los proveedores, y sus abonos  
     */
    function buscarReporteFacturasSaldadas(){
        
        $resultado = $this->link->query("SELECT
        b.id,
        cxp_s.id_cxp,
        b.no_factura,
        b.fecha,
        IFNULL(c.cuenta,'') AS cuenta,
        IFNULL(d.descripcion,'') AS banco,
        IFNULL(e.nombre,'') AS proveedor,
        IFNULL(IF((SUBSTR(b.clave_concepto,1,1) = 'C'),(b.subtotal +b.iva -b.descuento),0),0) AS cargo, 
        IFNULL(IF((SUBSTR(b.clave_concepto,1,1) = 'A'),(b.subtotal + b.iva -b.descuento),0),0) AS abono,
        b.estatus AS estatus
        FROM 
            (SELECT id_cxp,  estatus,
            IFNULL(SUM(IF((SUBSTR(a.clave_concepto,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0)),0) AS cargos,
            IFNULL(SUM(IF((SUBSTR(a.clave_concepto,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),((a.subtotal + a.iva -a.descuento) * -(1)))),0) AS saldo
            FROM cxp a
            GROUP BY a.id_cxp
            HAVING cargos>0 AND saldo=0) AS cxp_s
            
        LEFT JOIN cxp b ON b.id_cxp=cxp_s.id_cxp AND b.subtotal>0
        LEFT JOIN cuentas_bancos c ON c.id=b.id_cuenta_banco
        LEFT JOIN bancos d ON d.id=b.id_banco
        LEFT JOIN proveedores e ON b.id_proveedor=e.id
        LEFT JOIN conceptos_cxp f ON b.id_concepto=f.id
        GROUP BY b.id	
        ORDER BY b.no_factura,b.id_cxp");

        return query2json($resultado);

    }//- fin function buscarReporteFacturasSaldadas
    
    /**
     * Funcion que obtiene todas las facturas de los proveedores, sus abonos  y documentos respectivos
     */
    function buscarReporteFacturas($fechaDe, $fechaA){

      $condicionFecha = '';

      if($fechaDe == '' && $fechaA == '')
        $condicionFecha = " AND a.fecha >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
      else if($fechaDe != null &&  $fechaA == null)
        $condicionFecha = " AND a.fecha >= '$fechaDe' ";
      else  //-->trae fecha inicio y fecha fin
        $condicionFecha = " AND a.fecha >= '$fechaDe' AND a.fecha <= '$fechaA' ";
            
        $resultado = $this->link->query("SELECT
        a.id,
        a.id_cxp,
        a.no_factura,
        a.fecha,
        a.referencia,
        IFNULL(a.id_proveedor,0 ) AS id_proveedor,
        IFNULL(a.id_empleado,0) AS id_empleado,
        IF(a.id_entrada_compra > 0,'cxp_oc',IF(a.id_viatico>0,'cxp_viatico',''))AS tipo,
        IFNULL(c.cuenta,'') AS cuenta,
        IFNULL(d.descripcion,'') AS banco,
        IFNULL(e.nombre,'') AS proveedor,
        IF(a.id_empleado=0,a.nombre_empleado,CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m))) AS empleado,
        IFNULL(IF((SUBSTR(a.clave_concepto,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0),0) AS cargo, 
        IFNULL(IF((SUBSTR(a.clave_concepto,1,1) = 'A'),(a.subtotal + a.iva -a.descuento),0),0) AS abono,
        IFNULL(h.id_oc,0) AS id_oc,
        IFNULL(a.id_entrada_compra,0) as id_entrada_compra,
        GROUP_CONCAT(IFNULL(ruta_xml,''))AS rutas,
        a.estatus
        FROM  cxp a
        LEFT JOIN cuentas_bancos c ON c.id=a.id_cuenta_banco
        LEFT JOIN bancos d ON d.id=a.id_banco
        LEFT JOIN proveedores e ON a.id_proveedor=e.id
        LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
        LEFT JOIN conceptos_cxp f ON a.id_concepto=f.id
        LEFT JOIN almacen_e h ON a.id_entrada_compra = h.id
        LEFT JOIN cxp_complementos_pagos i ON a.id=i.id_cxp
        WHERE a.estatus!='C' AND a.id_cxp IN (SELECT id_cxp
                                              FROM cxp a 
                                              WHERE a.estatus!='C' $condicionFecha
                                              GROUP BY a.id_cxp)                    
        GROUP BY a.id	
        ORDER BY a.id_cxp,a.no_factura DESC");

        return query2json($resultado);
    }//- fin function buscarReporteFacturasSaldadas


    function generaReporteSaldosProveedores($idProveedor){

    $condicionProveedor='';

    if($idProveedor>0){
        $condicionProveedor ="WHERE a.id_proveedor=".$idProveedor;
    }
    $html='';
    
    $html.='<table class="tablon table-striped">';
        /*$html.='<thead>';
            $html.='<tr class="renglonE">';
                $html.='<th scope="col">PROVEEDOR</th>';
                $html.='<th scope="col">SIN VENCER</th>';
                $html.='<th scope="col">VENCIDO</th>';
                $html.='<th scope="col">SALDO</th>';
            $html.='</tr>';
        $html.='</thead>';*/
        $html.='<tbody>';

        $queryE = "SELECT  
                    a.id_proveedor,	
                    c.nombre AS proveedor,                                   
                    FORMAT((SUM(IF(CURDATE() > DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY),(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0) - IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva -a.descuento),0)),0))),2)AS vencido,
                    FORMAT((SUM(IF(CURDATE() <= DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY),(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0) - IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva -a.descuento),0)),0))),2)AS no_vencido,
                    FORMAT((SUM(IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0))-SUM(IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva -a.descuento),0))),2) AS saldo
                    FROM cxp a
                    LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                    LEFT JOIN proveedores c ON a.id_proveedor=c.id
                    $condicionProveedor
                    GROUP BY a.id_proveedor
                    -- HAVING saldo!=0
                    ORDER BY a.id ASC,a.fecha DESC";
        //-->NJES Nov/20/2020 mostrar todos los proveedores, incluyendo a los que ya se les pago y el saldo es 0

        $resultEncabezado = mysqli_query($this->link, $queryE);
        $numRegistro = mysqli_num_rows($resultEncabezado);
        if($numRegistro>0){
            while($rowE = mysqli_fetch_array($resultEncabezado))
            {
            
                $idProveedorE = $rowE['id_proveedor'];

                $html.='<tr class="renglonE">';
                    $html.='<th scope="col">PROVEEDOR</th>';
                    $html.='<th scope="col">SIN VENCER</th>';
                    $html.='<th scope="col">VENCIDO</th>';
                    $html.='<th scope="col">SALDO</th>';
                $html.='</tr>';

                $html.="<tr class='renglonP'>";
                    $html.="<td>" . $rowE['proveedor'] . "</td>";
                    $html.="<td align='right'>" . $rowE['no_vencido']. "</td>";
                    $html.="<td align='right'>" . $rowE['vencido']. "</td>";
                    $html.="<td align='right'>" . $rowE['saldo'] . "</td>";
                $html.="</tr>";

                $html.='<tr class="renglon">';
                $html.='<td colspan="4">';
                    $html.='<table class="tablon table-striped">';
                        $html.='<thead>';
                            $html.='<tr class="renglonE">';
                                $html.='<th scope="col">FOLIO FACTURA</th>';
                                $html.='<th scope="col">FECHA</th>';
                                $html.='<th scope="col">FECHA VENCIMIENTO</th>';
                                $html.='<th scope="col">REFERENCIA</th>';
                                $html.='<th scope="col">CONCEPTO</th>';
                                $html.='<th scope="col">CARGO</th>';
                                $html.='<th scope="col">ABONO</th>';
                                $html.='<th scope="col">SALDO</th>';
                        $html.='</tr></thead><tbody>';
                        

                        $queryD = "SELECT 
                                        a.id_proveedor,	
                                        IF(a.no_factura=0,'',a.no_factura) AS folio_factura,
                                        a.fecha,
                                        DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY) AS vencimiento,
                                        a.referencia,
                                        CONCAT(b.clave,' - ',b.descripcion) AS concepto,
                                        c.nombre AS proveedor,
                                        if(a.estatus='C','Cancelada','') as estatus,
                                        IF(CURDATE() > DATE_ADD(a.fecha,INTERVAL c.dias_credito DAY),'Vencida','') AS vencida,
                                        (IF((SUBSTR(b.clave,1,1) = 'C'),(a.subtotal + a.iva -a.descuento),0)) AS cargos,
                                        (IF((SUBSTR(b.clave,1,1) = 'A'),(a.subtotal + a.iva -a.descuento),0)) AS abonos
                                    FROM cxp a
                                    LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
                                    LEFT JOIN proveedores c ON a.id_proveedor=c.id
                                    WHERE a.id_proveedor=$idProveedorE
                                    GROUP BY a.id
                                    -- ORDER BY a.id ASC,a.fecha DESC
                                    ORDER BY a.id_cxp ASC,a.id ASC,a.fecha DESC";

                        // echo $queryD;
                        // exit();

                        $totalCargos=0;
                        $totalAbonos=0;
                        $saldo=0;

                        $resultDetalle = mysqli_query($this->link, $queryD);
                        while($rowD = mysqli_fetch_array($resultDetalle))
                        {

                            $totalCargos=$totalCargos+$rowD['cargos'];
                            $totalAbonos=$totalAbonos+$rowD['abonos'];
                            $saldo = $totalCargos - $totalAbonos;

                            //-->NJES November/04/2020 se agrega folio de la factura que subio el proveedor
                            $html.="<tr>";
                                $html.="<td>" . $rowD['folio_factura'] . "</td>";
                                $html.="<td>" . $rowD['fecha'] . "</td>";

                                if($rowE['saldo'] > 0)
                                    $html.="<td>" . $rowD['vencimiento'] . "</td>";
                                else
                                    $html.="<td></td>";
                                    
                                $html.="<td>" . $rowD['referencia'] . "</td>";
                                $html.="<td>" . $rowD['concepto']. "</td>";
                                $html.="<td align='right'>" .$this->dos_decimales($rowD['cargos']). "</td>";
                                $html.="<td align='right'>" .$this->dos_decimales($rowD['abonos']) . "</td>";
                                $html.="<td align='right'>" . $this->dos_decimales($saldo) . "</td>";
                            $html.="</tr>";

                        }

                    $html.='</tbody></table>';
                $html.='</td>';
                $html.='</tr>';
            }
        }else{
            $html.='<tr scope="col"><td colspan="4" align="center"><strong>No se encontró Informacion</strong></td></tr>';
        }
       $html.='</tbody>';
       $html.='</table>';

       return $html;//query2json($resultado);
    }//- fin function buscarEstadoCuentaIdProveedor


    function dos_decimales($number, $fractional=true) { 
        if ($fractional) { 
            $number = sprintf('%.2f', $number); 
        } 
        while (true) { 
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
            if ($replaced != $number) { 
                $number = $replaced; 
            } else { 
                break; 
            } 
        } 
        return '$ '.$number; 
    }


}//--fin de class CxP
    
?>