<?php

include 'conectar.php';

class MovimientosCuentas
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function MovimientosCuentas()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Guarda o Actualiza un registro 
      * 
      * @param varchar $datos array que contiene los datos a guardar o actualizar
      *
    **/
    function guardarMovimientosCuentas($datos){
        $verifica = 0;
  
       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");
  
        $verifica = $this -> guardarActualizar($datos);
  
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
  
        return $verifica;
    }//- fin function guardarMovimientosCuentas
  
    /**
        * Guarda o Actualiza un registro 
        * 
        * @param varchar $datos array que contiene los datos a guardar o actualizar
        *
    **/
    function guardarActualizar($datos){
        
        $verifica = 0;

        $idCuentaOrigen = isset($datos['idCuentaOrigen']) ? $datos['idCuentaOrigen'] : 0;
        $idCuentaDestino = isset($datos['idCuentaDestino']) ? $datos['idCuentaDestino'] : 0;
        $monto = isset($datos['monto']) ? $datos['monto'] : 0;
        $observacion = isset($datos['observacion']) ? $datos['observacion'] : '';
        $tipo = isset($datos['tipo']) ? $datos['tipo'] : '';
        $idUsuario = $datos['idUsuario'];
        $tipoCuentaOrigen = isset($datos['tipoCuentaOrigen']) ? $datos['tipoCuentaOrigen'] : 0;
        $tipoCuentaDestino = isset($datos['tipoCuentaDestino']) ? $datos['tipoCuentaDestino'] : 0;
        $fechaAplicacion = isset($datos['fechaAplicacion']) ? $datos['fechaAplicacion'] : '0000-00-00';
        $fondeo = isset($datos['fondeo']) ? $datos['fondeo'] : 0;

        //-->NJES Jan/20/2020 se agrga cambio para que de una caja chica pueda transferir tambien a otra caja chica
        if($tipoCuentaOrigen == 1)  //-->Transfiere de la caja chica (engreso) 
        {
            //-->busco id_unidad_negocio, id_sucursal de la cuenta banco origen de la que voy a hacer un egreso
            $buscaCuenta = "SELECT id_unidad_negocio,id_sucursal 
                            FROM cuentas_bancos WHERE id=".$idCuentaOrigen;
            $resultC = mysqli_query($this->link, $buscaCuenta) or die(mysqli_error());
    
            if($resultC)
            {
                $datosC=mysqli_fetch_array($resultC);
                $idUnidadNegocio=$datosC['id_unidad_negocio']; 
                $idSucursal=$datosC['id_sucursal']; 

                //--> Realiza un egreso a la caja chica
                $verifica = $this -> guardaCajaChica($idUnidadNegocio,$idSucursal,16,'G01',0,$datos);
            }else{
                $verifica = 0;
            }

        }else{ //-->transferencia de una cuanta banco  
            $query = "INSERT INTO movimientos_bancos(id_cuenta_banco,monto,transferencia,tipo,id_usuario,observaciones,fecha_aplicacion, fondeo) 
                        VALUES ('$idCuentaOrigen','$monto',0,'$tipo','$idUsuario','$observacion','$fechaAplicacion', $fondeo)";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idRegistro = mysqli_insert_id($this->link);
                
            if ($result) 
            {
                if($tipoCuentaDestino == 1)  //--> a una cuenta caja chica
                {
                    //-->busco id_unidad_negocio, id_sucursal de la cuenta banco destino a la que se realizará el ingreso
                    $buscaCuenta = "SELECT id_unidad_negocio,id_sucursal 
                            FROM cuentas_bancos WHERE id=".$idCuentaDestino;
                    $resultC = mysqli_query($this->link, $buscaCuenta) or die(mysqli_error());
            
                    if($resultC)
                    {
                        $datosC=mysqli_fetch_array($resultC);
                        $idUnidadNegocio=$datosC['id_unidad_negocio']; 
                        $idSucursal=$datosC['id_sucursal']; 

                        //--> Realiza un ingreso a la caja chica
                        $verifica = $this -> guardaCajaChica($idUnidadNegocio,$idSucursal,15,'C01',$idRegistro,$datos);
                    }else{
                        $verifica = 0;
                    }
                }else{  //-->Realiza un ingreso a una cuenta banco
                    $query2 = "INSERT INTO movimientos_bancos(id_cuenta_banco,monto,transferencia,tipo,id_usuario,observaciones,fecha_aplicacion, fondeo) 
                            VALUES ('$idCuentaDestino','$monto','$idRegistro','$tipo','$idUsuario','$observacion','$fechaAplicacion', $fondeo)";
                    $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
                    $idMovimientoBanco = mysqli_insert_id($this->link);
                    
                    if ($result) 
                    {
                        $verifica = $idMovimientoBanco;  
                    }else{
                        $verifica = 0;
                    }
                }
            }else{
                $verifica = 0;
            }
        }

        return $verifica;
    }//- fin function guardarActualizar

    /**
        * Guarda en movimientos banco el ingreso de dinero
        * 
        * @param varchar $datos array que contiene los datos a guardar o actualizar
        * @param int $id de la caja chica que se hizo el egreso
        *
    **/
    function guardarMovimientoBancoCC($datos,$id){
        $verifica = 0;

        $idCuentaDestino = isset($datos['idCuentaDestino']) ? $datos['idCuentaDestino'] : 0;
        $monto = isset($datos['monto']) ? $datos['monto'] : 0;
        $observacion = isset($datos['observacion']) ? $datos['observacion'] : '';
        $tipo = isset($datos['tipo']) ? $datos['tipo'] : '';
        $idUsuario = $datos['idUsuario'];
        $fechaAplicacion = isset($datos['fechaAplicacion']) ? $datos['fechaAplicacion'] : '0000-00-00';

        //--> Inserta el movimiento banco a la cuenta que se hace el ingreso
        $query = "INSERT INTO movimientos_bancos(id_cuenta_banco,monto,transferencia,tipo,id_usuario,observaciones,id_caja_chica,fecha_aplicacion) 
                    VALUES ('$idCuentaDestino','$monto','$id','$tipo','$idUsuario','$observacion','$id','$fechaAplicacion')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idRegistro = mysqli_insert_id($this->link);
            
        if ($result) 
        {
            //--> actualiza id de la caja chica con el movimiento banco que se inserto
            $updateCC = "UPDATE caja_chica SET id_movimiento_banco='$idRegistro' WHERE id=".$id;
            $resultCC = mysqli_query($this->link, $updateCC) or die(mysqli_error());
            if($resultCC)
            {
                $verifica = $idRegistro;
            }else{
                $verifica = 0;
            }
        }else{
            $verifica = 0;
        }

        return $verifica;
    }

    /**
        * Guarda o Actualiza un registro 
        * 
        * @param int $idUnidadNegocio id de la unidad de negocio a la que pertenece la cuenta banco
        * @param int $idSucursal id de la sucural de la cuenta banco
        * @param int $idConcepto  id de la clave concepto (15 ingreso, 16 egreso)
        * @param varchar $claveConcepto clave del concepto (C01 ingreso, G01 engreso)
        * @param int $idMovimiento banco del que se hiso el egreso
        * @param varchar $datos array que contiene los datos a guardar o actualizar
        *
    **/
    function guardaCajaChica($idUnidadNegocio,$idSucursal,$idConcepto,$claveConcepto,$idMovimiento,$datos){
        $verifica = 0;

        $monto = isset($datos['monto']) ? $datos['monto'] : 0;
        $observacion = isset($datos['observacion']) ? $datos['observacion'] : '';
        $idUsuario = $datos['idUsuario'];
        $tipoCuentaOrigen = isset($datos['tipoCuentaOrigen']) ? $datos['tipoCuentaOrigen'] : 0;
        $tipoCuentaDestino = isset($datos['tipoCuentaDestino']) ? $datos['tipoCuentaDestino'] : 0;
        $fechaAplicacion = isset($datos['fechaAplicacion']) ? $datos['fechaAplicacion'] : '0000-00-00';


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
                $query="INSERT INTO caja_chica(folio,id_unidad_negocio,id_sucursal,id_concepto,clave_concepto,fecha,importe,observaciones,estatus,id_usuario,id_movimiento_banco)
                        VALUES('$folio','$idUnidadNegocio','$idSucursal','$idConcepto','$claveConcepto','$fechaAplicacion','$monto','$observacion',1,'$idUsuario','$idMovimiento')";
                $result=mysqli_query($this->link, $query)or die(mysqli_error());
                $id = mysqli_insert_id($this->link);

                if($result)
                {
                    if($tipoCuentaOrigen == 1)
                    {
                        //--> inserta en movimienos banco el ingreso de dinero
                        $verifica = $this -> guardarMovimientoBancoCC($datos,$id);
                    }else{
                        //--> actualiza en el egreso de movimientos bancos el id de la caja chica donde se hizo el ingreso
                        $updateM = "UPDATE movimientos_bancos SET id_caja_chica='$id' WHERE id=".$idMovimiento;
                        $resultM = mysqli_query($this->link, $updateM) or die(mysqli_error());
                        if($resultM)
                        {
                            $verifica = $idMovimiento;
                        }else{
                            $verifica = 0;
                        }
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
    }

    function buscarSaldoDisponibleCuenta($idCuentaBanco){

        //2022-06-02 GCM - Se agrega un validador si el saldo esta en negativo se retornara 999999999 para que si deje capturar
        $query = "SELECT cb.id,
                    sd.cantidad + (SUM(IF(mb.tipo = 'I' OR mb.tipo = 'A' OR (mb.tipo = 'T' AND mb.transferencia <> 0),mb.monto,0)) - SUM(IF(mb.tipo = 'C' OR (mb.tipo = 'T' AND mb.transferencia = 0),mb.monto,0))) as saldo_disponible
                    FROM saldos_diarios sd
                    INNER JOIN cuentas_bancos cb ON cb.id = sd.id_cuenta_banco
                    LEFT JOIN movimientos_bancos mb ON mb.id_cuenta_banco = cb.id AND DATE(mb.fecha) = DATE(NOW())
                    WHERE sd.fecha = (SELECT MAX(t2.fecha)
                                        FROM saldos_diarios t2
                                        WHERE t2.id_cuenta_banco = sd.id_cuenta_banco)
                            AND sd.id_cuenta_banco = $idCuentaBanco";

        $resultado = $this->link->query($query);
        return query2json($resultado);
    }//- fin function buscarSaldoDisponibleCuenta

    function buscarMovimientosReporte($fechaInicio,$fechaFin,$idCuenta,$saldosCuentas){
        //-- MGFS SE CAMBIA WHERE DATE(a.fecha_aplicacion)='$fecha' POR  $condicionFecha
        $condicionFecha='';
        $condicionCuenta='';

        if($fechaInicio == '' && $fechaFin == '')
        {
            $condicionFecha=" AND MONTH(a.fecha_aplicacion) = MONTH(NOW()) AND YEAR(a.fecha_aplicacion) = YEAR(NOW())";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condicionFecha=" AND DATE(a.fecha_aplicacion) >= '$fechaInicio'";
        }else{  //-->trae fecha inicio y fecha fin
            $condicionFecha=" AND DATE(a.fecha_aplicacion) BETWEEN '$fechaInicio' AND '$fechaFin'";
        }
     
        /*-->NJES July/01/2020 En la columna de Importe se debe mostrar el saldo actual de la cuenta 
        y el nombre de la columna debe corresponder a ese dato.  
        El reporte debe contar un  filtro de fechas y un campo para visualizar el saldo de la 
        fecha inicio seleccionada, así como un campo para visualizar el saldo de la fecha fin 
        seleccionada. */
        if($idCuenta==''){

            $query = "SELECT pre.id,
                        pre.id_cuenta_banco,               
                        pre.id_banco,        
                        pre.cuenta,        
                        pre.banco,        
                        pre.descripcion,              
                        pre.fecha_aplicacion, 
                        SUM(pre.saldo_actual) AS saldo_actual,
                        SUM(pre.saldo_fecha_inicio) AS saldo_fecha_inicio, 
                        SUM(pre.saldo_fecha_fin) AS saldo_fecha_fin
                        FROM 
                            (SELECT a.id,a.id_cuenta_banco,               
                            IFNULL(b.id_banco,0) AS id_banco,        
                            IFNULL(b.cuenta,'') AS cuenta,        
                            IFNULL(c.descripcion,'') AS banco,        
                            IFNULL(b.descripcion,'') AS descripcion,              
                            a.fecha_aplicacion, 
                            0 AS saldo_actual,
                            0 AS saldo_fecha_inicio, 
                            0 AS saldo_fecha_fin
                            FROM movimientos_bancos a 
                            LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                            LEFT JOIN bancos c ON b.id_banco=c.id
                            WHERE 1 $condicionFecha 
                            GROUP BY a.id_cuenta_banco
                            UNION ALL
                            SELECT a.id,a.id_cuenta_banco,               
                            IFNULL(b.id_banco,0) AS id_banco,        
                            IFNULL(b.cuenta,'') AS cuenta,        
                            IFNULL(c.descripcion,'') AS banco,        
                            IFNULL(b.descripcion,'') AS descripcion,              
                            a.fecha_aplicacion, 
                            IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0) AS saldo_actual,
                            0 AS saldo_fecha_inicio, 
                            0 AS saldo_fecha_fin
                            FROM movimientos_bancos a 
                            LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                            LEFT JOIN bancos c ON b.id_banco=c.id 
                            GROUP BY a.id_cuenta_banco
                            UNION ALL
                            SELECT a.id,a.id_cuenta_banco,               
                            IFNULL(b.id_banco,0) AS id_banco,        
                            IFNULL(b.cuenta,'') AS cuenta,        
                            IFNULL(c.descripcion,'') AS banco,        
                            IFNULL(b.descripcion,'') AS descripcion,              
                            a.fecha_aplicacion, 
                            0 AS saldo_actual,
                            IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0) AS saldo_fecha_inicio, 
                            0 AS saldo_fecha_fin
                            FROM movimientos_bancos a 
                            LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                            LEFT JOIN bancos c ON b.id_banco=c.id
                            WHERE DATE(a.fecha_aplicacion) < '$fechaInicio'
                            GROUP BY a.id_cuenta_banco
                            UNION ALL
                            SELECT a.id,a.id_cuenta_banco,               
                            IFNULL(b.id_banco,0) AS id_banco,        
                            IFNULL(b.cuenta,'') AS cuenta,        
                            IFNULL(c.descripcion,'') AS banco,        
                            IFNULL(b.descripcion,'') AS descripcion,              
                            a.fecha_aplicacion, 
                            0 AS saldo_actual,
                            0 AS saldo_fecha_inicio, 
                            IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0) AS saldo_fecha_fin
                            FROM movimientos_bancos a 
                            LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                            LEFT JOIN bancos c ON b.id_banco=c.id
                            WHERE DATE(a.fecha_aplicacion) < '$fechaFin'
                            GROUP BY a.id_cuenta_banco
                        ) AS pre 
                        GROUP BY pre.id_cuenta_banco
                        ORDER BY pre.fecha_aplicacion DESC";

            // $resultado = $this->link->query($query);

        }else{
            $condicionCuenta=" AND  a.id_cuenta_banco=$idCuenta ";

            //-->NJES January/26/2021 de inicio buscar sin filtro de fechas, hasta que haga el change en los filtros en la siguiente pantalla
            if($fechaInicio == '' && $fechaFin == '')
            {
                $condicionFechaDetalle="";
            }else if($fechaInicio != '' &&  $fechaFin == '')
            {
                $condicionFechaDetalle=" AND DATE(a.fecha_aplicacion) >= '$fechaInicio'";
            }else{  //-->trae fecha inicio y fecha fin
                $condicionFechaDetalle=" AND DATE(a.fecha_aplicacion) BETWEEN '$fechaInicio' AND '$fechaFin'";
            }

            $query = "SELECT a.id,
                        IFNULL(sucursales.descr,'') AS sucursal,
                        a.id_cuenta_banco,
                        IFNULL(a.observaciones,'') as observaciones,
                        b.id_banco,
                        b.cuenta as cuenta,
                        c.descripcion AS banco,
                        b.descripcion,
                        CASE
                            WHEN a.tipo = 'T' THEN 'Transferencia'
                            WHEN a.tipo = 'I' THEN 'Monto Inicial'
                            WHEN a.tipo = 'C' THEN 'Cargo'
                            ELSE 'Abono'
                        END AS tipo,
                        CASE
                            WHEN a.tipo = 'I' THEN 'Ingreso'
                            WHEN a.tipo = 'A' THEN 'Ingreso'
                            WHEN a.tipo = 'C' THEN 'Egreso'
                            WHEN a.tipo = 'T' AND a.transferencia = 0 THEN 'Egreso'
                            ELSE 'Ingreso'
                        END AS movimiento,
                        a.monto,
                        a.fecha_aplicacion,
                        a.monto AS saldo,
                        a.id_cxc,
                        d.id_pago_d,
                        e.id_factura,
                        e.id_pago_e,
                        IFNULL(d.folio_pago,'') AS folio_pago,
                        IFNULL(e.folio_factura,'') AS folio_factura,
                        IFNULL(orden_compra.folio,'No aplica') AS folio_oc,
                        IFNULL(IF(cxp.id_requisicion > 0,requisiciones.folio,orden_compra.requisiciones),'No aplica') AS folio_requi
                        FROM movimientos_bancos a
                        LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                        LEFT JOIN bancos c ON b.id_banco=c.id
                        LEFT JOIN cxc d ON a.id_cxc=d.id
                        LEFT JOIN pagos_d e ON d.id_pago_d=e.id
                        LEFT JOIN cxp ON a.id_cxp=cxp.id
                        LEFT JOIN almacen_e ON cxp.id_entrada_compra=almacen_e.id
                        LEFT JOIN orden_compra ON almacen_e.id_oc=orden_compra.id
                        LEFT JOIN sucursales ON cxp.id_sucursal=sucursales.id_sucursal
                        LEFT JOIN requisiciones ON cxp.id_requisicion=requisiciones.id
                        WHERE 1 $condicionCuenta 
                        $condicionFechaDetalle 
                        ORDER BY a.fecha_aplicacion DESC,a.id DESC";
            //-->NJES October/09/2020 mostrar folio de pago y folio factura para los casos de los movimientos que se generaron al hacer pagos a facturas multiples
            //para que sea mas faci el rastreo de finanzas
            
            //-->NJES January/26/2021 hice la relacion a cxp.id porque en este caso solo queriamos los folios, 
            //y como tal los folio solo estan en el cargo inicial, no en los abonos
            //se muestra sucursales de los movimientos cuentas relacionados a las compras
        }

        // echo $query;
        // exit();

        $resultado = $this->link->query($query);

        return query2json($resultado);
    }//- fin function buscarMovimientosReporte

    function buscarMovimientosReporteTodos($fechaInicio,$fechaFin){
        //-- MGFS SE CAMBIA WHERE DATE(a.fecha_aplicacion)='$fecha' POR  $condicionFecha
        $condicionFecha='';

        if($fechaInicio == '' && $fechaFin == '')
        {
            $condicionFecha=" AND MONTH(a.fecha_aplicacion) = MONTH(NOW()) AND YEAR(a.fecha_aplicacion) = YEAR(NOW())";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condicionFecha=" AND DATE(a.fecha_aplicacion) >= '$fechaInicio'";
        }else{  //-->trae fecha inicio y fecha fin
            $condicionFecha=" AND DATE(a.fecha_aplicacion) BETWEEN '$fechaInicio' AND '$fechaFin'";
        }
     
        /*-->NJES July/01/2020 En la columna de Importe se debe mostrar el saldo actual de la cuenta 
        y el nombre de la columna debe corresponder a ese dato.  
        El reporte debe contar un  filtro de fechas y un campo para visualizar el saldo de la 
        fecha inicio seleccionada, así como un campo para visualizar el saldo de la fecha fin 
        seleccionada. */

        $query = "SELECT a.id,
                        IFNULL(sucursales.descr,'') AS sucursal,
                        a.id_cuenta_banco,
                        IFNULL(a.observaciones,'') as observaciones,
                        b.id_banco,
                        b.cuenta as cuenta,
                        c.descripcion AS banco,
                        b.descripcion,
                        CASE
                            WHEN a.tipo = 'A' THEN 'Abono'
                            WHEN a.tipo = 'I' THEN 'Ingreso'
                            WHEN a.tipo = 'T' AND a.transferencia <> 0 THEN 'Transferencia'
                            ELSE ''
                        END AS tipo,
                        CASE
                            WHEN a.tipo = 'A' THEN 'Ingreso'
                            WHEN a.tipo = 'I' THEN 'Ingreso'
                            WHEN a.tipo = 'T' AND a.transferencia <> 0 THEN 'Ingreso'
                            ELSE ''
                        END AS movimiento,
                        CASE
                            WHEN a.tipo = 'C' THEN 'Cargo'
                            WHEN a.tipo = 'T' AND a.transferencia = 0 THEN 'Transferencia'
                            ELSE ''
                        END AS tipo2,
                        CASE
                            WHEN a.tipo = 'C' THEN 'Egreso'
                            WHEN a.tipo = 'T' AND a.transferencia = 0 THEN 'Egreso'
                            ELSE ''
                        END AS movimiento2,
                        a.monto,
                        a.fecha_aplicacion,
                        a.monto AS saldo,
                        a.id_cxc,
                        d.id_pago_d,
                        e.id_factura,
                        e.id_pago_e,
                        IFNULL(d.folio_pago,'') AS folio_pago,
                        IFNULL(e.folio_factura,'') AS folio_factura,
                        IFNULL(orden_compra.folio,'No aplica') AS folio_oc,
                        IFNULL(IF(cxp.id_requisicion > 0,requisiciones.folio,orden_compra.requisiciones),'No aplica') AS folio_requi
                    FROM movimientos_bancos a
                    LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                    LEFT JOIN bancos c ON b.id_banco=c.id
                    LEFT JOIN cxc d ON a.id_cxc=d.id
                    LEFT JOIN pagos_d e ON d.id_pago_d=e.id
                    LEFT JOIN cxp ON a.id_cxp=cxp.id
                    LEFT JOIN almacen_e ON cxp.id_entrada_compra=almacen_e.id
                    LEFT JOIN orden_compra ON almacen_e.id_oc=orden_compra.id
                    LEFT JOIN sucursales ON cxp.id_sucursal=sucursales.id_sucursal
                    LEFT JOIN requisiciones ON cxp.id_requisicion=requisiciones.id
                    WHERE 1 
                    $condicionFecha 
                    ORDER BY a.fecha_aplicacion DESC,a.id DESC";

        // echo $query;
        // exit();

        $resultado = $this->link->query($query);

        return query2json($resultado);
    }//- fin function buscarMovimientosReporteTodos
    
    function buscarSaldosCuentasBancos($fechaInicio,$fechaFin){
        $resultado = $this->link->query("SELECT uno.cuenta,uno.banco,uno.descripcion,uno.saldo_inicial, dos.saldo_final
                                        FROM 
                                        (SELECT IFNULL(b.cuenta,'') AS cuenta,IFNULL(c.descripcion,'') AS banco,IFNULL(b.descripcion,'') AS descripcion,a.fecha_aplicacion,a.id_cuenta_banco,
                                            FORMAT(IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0),2) AS saldo_inicial,
                                            0 AS saldo_final
                                            FROM movimientos_bancos a
                                            LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                                            LEFT JOIN bancos c ON b.id_banco=c.id
                                            WHERE DATE(a.fecha_aplicacion) <= '$fechaInicio' 
                                            GROUP BY a.id_cuenta_banco)  uno
                                            LEFT JOIN 
                                            (
                                            SELECT a.id_cuenta_banco,
                                            0 AS saldo_inicial,
                                            FORMAT(IFNULL((SUM(IF(a.tipo='A',a.monto,0))+SUM(IF(a.tipo='I',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia >0,a.monto,0)))-(SUM(IF(a.tipo='C',a.monto,0))+SUM(IF(a.tipo='T' && a.transferencia = 0,a.monto,0))),0),2) AS saldo_final
                                            FROM movimientos_bancos a
                                            WHERE DATE(a.fecha_aplicacion) <= '$fechaFin' 
                                            GROUP BY a.id_cuenta_banco) dos ON uno.id_cuenta_banco = dos.id_cuenta_banco");
        
        return query2json($resultado);
    }//- fin function buscarSaldosCuentasBancos

    function buscarMovimientosReporteDetalle($idCuenta, $fechaInicio, $fechaFin){

        $condicionCuenta = "";

        if($idCuenta != 0 && $idCuenta != ""){
            $condicionCuenta = " AND a.id_cuenta_banco =$idCuenta ";
        }else{
            $idUsuario = $_SESSION["id_usuario"];

            $condicionCuenta = " AND b.id_unidad_negocio IN (
                                        SELECT DISTINCT(id_unidad_negocio)
                                        FROM permisos
                                        WHERE id_usuario = $idUsuario)";
        }

        $condicionFecha = " AND MONTH(a.fecha) = MONTH(NOW()) AND YEAR(a.fecha) = YEAR(NOW()) ";

        if($fechaInicio != "" && $fechaFin != ""){
            $condicionFecha = " AND DATE(a.fecha) BETWEEN DATE('$fechaInicio') AND DATE('$fechaFin') ";
        }

        $query = "SELECT 
                        a.id_cuenta_banco,
                        IFNULL(sucursales.descr,IFNULL(s2.descr,IFNULL(s3.descr,IFNULL(s4.descr,IFNULL(s5.descr,''))))) AS sucursal,
                        IFNULL(a.observaciones,'') as observaciones,
                        b.cuenta as cuenta,
                        c.descripcion AS banco,
                        b.descripcion,
                        CASE
                            WHEN a.tipo = 'A' THEN 'Ingreso'
                            WHEN a.tipo = 'I' THEN 'Ingreso'
                            WHEN a.tipo = 'T' AND a.transferencia <> 0 THEN 'Ingreso'
                            WHEN a.tipo = 'C' THEN 'Egreso'
                            WHEN a.tipo = 'T' AND a.transferencia = 0 THEN 'Egreso'
                            ELSE ''
                        END AS movimiento,
                        CASE
                            WHEN a.tipo = 'A' THEN a.monto
                            WHEN a.tipo = 'I' THEN a.monto
                            WHEN a.tipo = 'T' AND a.transferencia <> 0 THEN a.monto
                            ELSE ''
                        END AS montoIngreso,
                        CASE
                            WHEN a.tipo = 'C' THEN a.monto
                            WHEN a.tipo = 'T' AND a.transferencia = 0 THEN a.monto
                            ELSE ''
                        END AS montoEgreso,
                        a.fecha_aplicacion,
                        a.fecha,
                        a.monto AS saldo,
                        IFNULL(d.folio_pago,psf.folio) AS folio_pago,
                        IFNULL(e.folio_factura,'') AS folio_factura,
                        IFNULL(orden_compra.folio,'No aplica') AS folio_oc,
                        IFNULL(IF(cxp.id_requisicion > 0,requisiciones.folio,orden_compra.requisiciones),'No aplica') AS folio_requi,
                        IFNULL(gas.folio_requisicion,'') AS folio_gasto,
                        IFNULL(vi.folio,'') AS folio_viatico
                    FROM movimientos_bancos a
                    LEFT JOIN pagos_sin_factura psf ON psf.id = a.id_psf
                    LEFT JOIN cuentas_bancos b ON a.id_cuenta_banco=b.id
                    LEFT JOIN bancos c ON b.id_banco=c.id
                    LEFT JOIN cxc d ON a.id_cxc=d.id
                    LEFT JOIN pagos_d e ON d.id_pago_d=e.id
                    LEFT JOIN cxp ON a.id_cxp=cxp.id
                    LEFT JOIN almacen_e ON cxp.id_entrada_compra=almacen_e.id
                    LEFT JOIN orden_compra ON almacen_e.id_oc=orden_compra.id
                    LEFT JOIN sucursales ON cxp.id_sucursal=sucursales.id_sucursal
                    LEFT JOIN requisiciones ON cxp.id_requisicion=requisiciones.id
                    LEFT JOIN gastos gas ON gas.id = a.id_gasto
                    LEFT JOIN sucursales s2 ON gas.id_sucursal=s2.id_sucursal
                    LEFT JOIN sucursales s3 ON d.id_sucursal=s3.id_sucursal
                    LEFT JOIN viaticos vi ON vi.id= a.id_viatico
                    LEFT JOIN sucursales s4 ON vi.id_sucursal=s4.id_sucursal
                    LEFT JOIN sucursales s5 ON psf.id_sucursal=s5.id_sucursal
                    WHERE 1 
                    $condicionFecha 
                    $condicionCuenta 
                    ORDER BY a.id_cuenta_banco, a.fecha_aplicacion DESC,a.id DESC";

                // echo $query;
                // exit();

        $resultado = $this->link->query($query);
        
        return query2json($resultado);
    }

    function buscarCuentasBanco(){
        $idUsuario = $_SESSION["id_usuario"];

        $query = "SELECT cb.id, cb.cuenta, cb.descripcion descr, ba.descripcion banco
                    FROM cuentas_bancos cb
                    INNER JOIN bancos ba ON cb.id_banco = ba.id
                    WHERE cb.id_unidad_negocio IN (
                                        SELECT DISTINCT(id_unidad_negocio)
                                        FROM permisos
                                        WHERE id_usuario = $idUsuario)
                            AND cb.tipo = 0
                            AND cb.activa = 1";

        $resultado = $this->link->query($query);
        
        return query2json($resultado);
    }

    function buscarCuentasSaldos($idCuenta, $fechaInicio, $fechaFin){

        $condicionCuenta = "";
        $condicionFecha1 = " AND MONTH(a.fecha_aplicacion) = MONTH(NOW()) AND YEAR(a.fecha_aplicacion) = YEAR(NOW()) ";

        if($fechaInicio != "" && $fechaFin != ""){
            $condicionFecha1 = " AND DATE(a.fecha_aplicacion) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        if($idCuenta != 0 && $idCuenta != ""){
            $condicionCuenta = " AND a.id_cuenta_banco = $idCuenta ";
        }else{
            $idUsuario = $_SESSION["id_usuario"];

            $condicionCuenta = " AND b.id_unidad_negocio IN (
                                        SELECT DISTINCT(id_unidad_negocio)
                                        FROM permisos
                                        WHERE id_usuario = $idUsuario)";
        }

        $query = "SELECT
                        b.id AS id_cuenta_banco,
                        b.descripcion,
                        b.cuenta,
                        SUM(IF(a.tipo = 'I' OR a.tipo = 'A' OR (a.tipo = 'T' AND a.transferencia <> 0),a.monto,0)) as ingresos,
                        SUM(IF(a.tipo = 'C' OR (a.tipo = 'T' AND a.transferencia = 0),a.monto,0)) as egresos,
                        SUM(IF(a.tipo = 'I' OR a.tipo = 'A' OR (a.tipo = 'T' AND a.transferencia <> 0),a.monto,0)) - SUM(IF(a.tipo = 'C' OR (a.tipo = 'T' AND a.transferencia = 0),a.monto,0)) AS saldo
                    FROM movimientos_bancos a
                    INNER JOIN cuentas_bancos b ON b.id = a.id_cuenta_banco
                    WHERE 1=1
                    $condicionFecha1
                    $condicionCuenta
                    GROUP BY a.id_cuenta_banco;";

                    // echo $query;
                    // exit();

        $resultado = $this->link->query($query);
                
        return query2json($resultado);
    }

}//--fin de class MovimientosCuentas
    
?>