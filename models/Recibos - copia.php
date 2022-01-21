<?php

require_once('conectar.php');
require_once('Facturacion.php');

class Recibos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Recibos()
    {
  
      $this->link = Conectarse();
      
    }

    /**
        * Obtiene los planes para generar recibos de los servicios activos en el rango de fechas y de la sucursal
        *
        * @param varchar $datos array que contiene fecha inicio, fecha fin y sucursal para hacer la busqueds
        *
    **/
    function obtenerPlanes($datos){
        $idSucursal = $datos['idSucursal'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];

        $query = "SELECT a.id,a.id_servicio,a.id_plan,a.factura,a.dia_corte,
                    IFNULL(c.id_plan,0) AS id_plan_cxc,
                    d.tipo AS tipo_plan,d.meses,DATE(a.fecha_captura) AS fecha_captura
                    FROM servicios_bitacora_planes a
                    INNER JOIN servicios b ON a.id_servicio=b.id
                    LEFT JOIN cxc c ON a.id=c.id_plan 
                    INNER JOIN servicios_cat_planes d ON a.id_plan=d.id
                    LEFT JOIN estados e ON b.id_estado = e.id
                    LEFT JOIN municipios f ON b.id_municipio = f.id
                    WHERE b.id_sucursal=$idSucursal AND b.activo=1 AND d.tipo!=0
                    AND a.id IN (SELECT MAX(id)
                                FROM servicios_bitacora_planes 
                                GROUP BY id_servicio)
                    GROUP BY a.id_servicio
                    ORDER BY a.id ASC";

        $result = $this->link->query($query);
        return $result;
    }//--fin de funcion obtenerPlanes

    function obtenerPlanesFormato($idSucursal){

        $query = "SELECT a.id,a.id_servicio,a.id_plan,a.factura,a.dia_corte,
                    IFNULL(c.id_plan,0) AS id_plan_cxc,
                    d.tipo AS tipo_plan,d.meses,DATE(a.fecha_captura) AS fecha_captura,
                    IFNULL(b.razon_social,'') AS razon_social,IFNULL(b.cuenta,'') AS cuenta,
                    IFNULL(b.rfc,'') AS rfc,IFNULL(CONCAT(b.domicilio,' No. Ext ' ,b.no_exterior,(IF(b.no_interior!='','No. Int ','')),b.no_interior),'') AS direccion, 
                    IFNULL(b.colonia,'') AS colonia, IFNULL(e.estado,'') AS estado, IFNULL(f.municipio,'') AS municipio,
                    IFNULL(b.codigo_postal,'') AS codigo_postal,
                    IF(b.entrega=0,'FISICA',IF(b.entrega=1,'CORREO','FISICA Y CORREO')) AS entrega,IF(b.pago='E','EFECTIVO','TRANSFERENCIA') AS pago,
                    d.descripcion AS plan, d.cantidad
                    FROM servicios_bitacora_planes a
                    INNER JOIN servicios b ON a.id_servicio=b.id
                    LEFT JOIN cxc c ON a.id=c.id_plan 
                    INNER JOIN servicios_cat_planes d ON a.id_plan=d.id
                    LEFT JOIN estados e ON b.id_estado = e.id
                    LEFT JOIN municipios f ON b.id_municipio = f.id
                    WHERE b.id_sucursal=$idSucursal AND b.activo=1 AND d.tipo!=0
                    AND a.id IN (SELECT MAX(id)
                                FROM servicios_bitacora_planes 
                                GROUP BY id_servicio)
                    GROUP BY a.id_servicio
                    ORDER BY a.id ASC";

        $result = $this->link->query($query);
        return $result;
    }


    function buscarFecha($fecha_captura,$meses,$tipo, $dia,  $fechaInicio, $fechaFin){
        $cont=0;
        $arrFechas=array();

        $diaF = "";

        //$diaActual = date("d",strtotime($fechaInicio));
        $diaActual = date("d",strtotime($fecha_captura));

        $semanal = array(
            'L'=>'Monday',
            'M'=>'Tuesday',
            'X'=>'Wednesday',
            'J'=>'Thursday',
            'V'=>'Friday',
            'S'=>'Saturday',
            'D'=>'Sunday'
        );

        $quincenal = array(

            'Q1'=>[1, 16],
            'Q2'=>[2, 17],
            'Q3'=>[3, 18],
            'Q4'=>[4, 19],
            'Q5'=>[5, 20],
            'Q6'=>[6, 21],
            'Q7'=>[7, 22],
            'Q8'=>[8, 23],
            'Q9'=>[9, 24],
            'Q10'=>[10, 25],
            'Q11'=>[11, 26],
            'Q12'=>[12, 27],
            'Q13'=>[13, 28],
            'Q14'=>[14, 29],
            'Q15'=>[15, 30]

        );

        if($tipo == 1)  //-> anual  (1)
        {
            $diaF = $dia;
            while($diaF<=$fechaFin){
                if($diaF>=$fechaInicio)
                    array_push($arrFechas, $diaF);
                
                $diaF = date("Y-m-d",strtotime($diaF."+ 1 year"));
            }
        }else if($tipo == 4)  //-> semanal  (4)
        {
            $dS =  $semanal[$dia];

            $diaF = date("Y-m-d",strtotime($dS.' next week',strtotime($fecha_captura)));

            while($diaF<=$fechaFin){
                if($diaF>=$fechaInicio)
                    array_push($arrFechas, $diaF);
                
                $diaF = date("Y-m-d",strtotime($dS.' next week',strtotime($diaF)));
            }

        }else if($tipo == 3) //-> quincenal  (3)
        {
            $anioInicio = date("Y", strtotime($fechaInicio));
            $anioFin = date("Y", strtotime($fechaFin));
            
            $anioInicioC = date("Y", strtotime($fecha_captura));

            $restaAnio=$anioFin - $anioInicio;

            $mesInicio = date("m", strtotime($fechaInicio));
            $mesFin = date("m", strtotime($fechaFin));

            $mesInicioC = date("m", strtotime($fecha_captura));

            $restaMes=$mesFin - $mesInicio;

            $nQ = $quincenal[$dia];
            $key = 0;
            if($diaActual > 15)
                $key = 1;
            
                
            $diaF = $anioInicioC . '-' . $mesInicioC . '-' . $nQ[$key];
            $diaA = date("d", strtotime($fecha_captura));

            $mesActual = date("m", strtotime($diaF));
            $anioActual = date("Y", strtotime($diaF));
            
            if($restaAnio > 0)
            {
                while($anioActual<$anioFin)
                {

                    if($mesActual <= 12)
                    {
                        while($mesActual <= 12)
                        {
                            if($nQ[0] < 10)
                                $diaF = $anioActual . '-' . $mesActual . '-0' . $nQ[0];
                            else
                                $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[0];

                            if($diaF >= $fechaInicio)
                            {
                                $nueva = date_diff(date_create($diaF),date_create($fecha_captura));
                                $dif = $nueva->format('%a');

                                if($diaF<=$fechaFin)
                                {
                                    if($dif >= 15)
                                        array_push($arrFechas, $diaF);
                                }
                            }

                            $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[1];

                            if($mesActual == 2)
                            {
                                $numDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);

                                if($dia == 'Q14' || $dia == 'Q15')
                                    $diaF = $anioActual . '-' . $mesActual . '-' . $numDias;
                                    
                            }

                            if($diaF >= $fechaInicio)
                            {
                                $nueva = date_diff(date_create($diaF),date_create($fecha_captura));
                                $dif = $nueva->format('%a');

                                if($diaF<=$fechaFin)
                                {
                                    if($dif >= 15)
                                        array_push($arrFechas, $diaF);
                                }
                            }

                            $mesActual++;
                        }
                    }else{
                        $anioActual++;
                        $mesActual=1;
                        while($mesActual <= $mesFin)
                        {
                            
                            if($mesActual < 10)
                            {
                                if($nQ[0] < 10)
                                    $diaF = $anioActual . '-0' . $mesActual . '-0' . $nQ[0];
                                else
                                    $diaF = $anioActual . '-0' . $mesActual . '-' . $nQ[0];
                            }else{
                                if($nQ[0] < 10)
                                    $diaF = $anioActual . '-' . $mesActual . '-0' . $nQ[0];
                                else
                                    $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[0];
                            }

                            if($diaF >= $fechaInicio)
                            {
                                $nueva = date_diff(date_create($diaF),date_create($fecha_captura));
                                $dif = $nueva->format('%a');

                                if($diaF<=$fechaFin)
                                {
                                    if($dif >= 15)
                                        array_push($arrFechas, $diaF);
                                }
                            }

                            if($mesActual < 10)
                            {
                                $diaF = $anioActual . '-0' . $mesActual . '-' . $nQ[1];

                                if($mesActual == 2)
                                {
                                    $numDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);

                                    if($dia == 'Q14' || $dia == 'Q15')
                                        $diaF = $anioActual . '-0' . $mesActual . '-' . $numDias;
                                        
                                }

                            }else
                                $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[0];

                            if($diaF >= $fechaInicio)
                            {
                                $nueva = date_diff(date_create($diaF),date_create($fecha_captura));
                                $dif = $nueva->format('%a');

                                if($diaF<=$fechaFin)
                                {
                                    if($dif >= 15)
                                        array_push($arrFechas, $diaF);
                                }
                            }

                            $mesActual++;
                        }
                    }
                }

            }else{
      
                while($mesActual <= $mesFin)
                {

                    if($nQ[0] < 10)
                        $diaF = $anioActual . '-' . $mesActual . '-0' . $nQ[0];
                    else
                        $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[0];
                    
                    if($diaF >= $fechaInicio)
                    {
                        $nueva = date_diff(date_create($diaF),date_create($fecha_captura));
                        $dif = $nueva->format('%a');

                        if($diaF<=$fechaFin)
                        {
                            if($dif >= 15)
                                array_push($arrFechas, $diaF);
                        }
                    }


                    $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[1];

                    if($mesActual == 2)
                    {
                        $numDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);

                        if($dia == 'Q14' || $dia == 'Q15')
                            $diaF = $anioActual . '-' . $mesActual . '-' . $numDias;
                            
                    }

                    if($diaF >= $fechaInicio)
                    {
                        $nueva = date_diff(date_create($diaF),date_create($fecha_captura));
                        $dif = $nueva->format('%a');

                        if($diaF<=$fechaFin)
                        {
                            if($dif >= 15)
                                array_push($arrFechas, $diaF);
                        }
                    }

                    $mesActual++;
                }
            }

        }else{ //-> mensual  (2)

            $anio = date("Y", strtotime($fecha_captura));
            $mes = date("m", strtotime($fecha_captura));

            if($dia < 10)
                $diaN = '0'.$dia;
            else
                $diaN = $dia;
            

            if($mes < 10)
                $diaF = $anio . '-' . $mes . '-' . $diaN;
            else
                $diaF = $anio . '-' . $mes . '-' . $diaN;


            if($dia > 28)
            {
                $dA = date("d", strtotime($diaF));
                $dS = date("d",strtotime($diaF."+ ".$meses." month"));

                if($dA != $dS)
                    $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month -".$dS." Day"));
                else
                    $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));

            }else
                $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));


            while($diaF<=$fechaFin){
                if($diaF>=$fechaInicio)
                    array_push($arrFechas, $diaF);
                
                
                if($dia > 28)
                {
                    //-- por si el mes llega a caer en febrero se le restan los dias del siguiente mes 
                    //-- para que si ponga la fecha de febrero con el ultimo dia de ese mes y no se lo pase
                    $diaA = date("d", strtotime($diaF));
                    $diaS = date("d",strtotime($diaF."+ ".$meses." month"));

                    if($dia == $diaA)
                    {
                        if($diaA != $diaS)
                            $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month -".$diaS." Day"));
                        else
                            $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));
                    }else{
                        $a = date("Y", strtotime($diaF."+ ".$meses." month"));
                        $m = date("m", strtotime($diaF."+ ".$meses." month"));

                        $diaF = $a . '-' . $m . '-' . $dia;
                    }
                    
                }else
                    $diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));
                
            }
            
        }

        //echo json_encode($arrFechas);

        return $arrFechas;

    }//--fin de funcion buscarFecha

    function verificaExisteCxC($idPlan, $fechaRecibo){
        $result = mysqli_query($this->link, "SELECT  COUNT(id) as verifica 
                                            FROM cxc WHERE id_plan = $idPlan 
                                            AND fecha_corte_recibo ='$fechaRecibo' 
                                            AND estatus!='C'");
        $row = mysqli_fetch_assoc($result);
        
        return $row['verifica']; 

    }//--fin de funcion verificaExisteCxC

    function generaCxC($idPlan, $fechaRecibo,$idUnidadNegocio,$idSucursal,$factura,$idServicio,$usuario){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardaCxC($idPlan, $fechaRecibo,$idUnidadNegocio,$idSucursal,$factura,$idServicio,$usuario);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//--fin de funcion generaCxC

    function guardaCxC($idPlan, $fechaRecibo,$idUnidadNegocio,$idSucursal,$factura,$idServicio,$usuario){
        $verifica = 0;

        $query = "INSERT INTO cxc(id_unidad_negocio,id_sucursal,id_plan,fecha_corte_recibo) 
        VALUES ('$idUnidadNegocio','$idSucursal','$idPlan','$fechaRecibo')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idCxC = mysqli_insert_id($this->link);

        if($result) 
        { 
            if($factura == 'SI')
            {
                $existeF = $this -> verificaExistePrefactura($idPlan, $fechaRecibo);
                
                if($existeF == 0 && $fechaRecibo != "")
                {
                    $verifica = $this -> guardaFactura($idServicio,$idPlan, $fechaRecibo,$idUnidadNegocio,$idCxC,$usuario);
                }else
                    $verifica = 1;
            }else{
                $verifica = 1;
            }
        }else
            $verifica = 0;

        return $verifica;
    }//--fin de funcion guardaCxC

    function verificaExistePrefactura($idPlan, $fechaRecibo){
        $result = mysqli_query($this->link, "SELECT COUNT(a.id) AS verifica
            FROM facturas_d a
            LEFT JOIN facturas b ON a.id_factura=b.id
            WHERE a.id_plan = $idPlan 
            AND a.fecha_recibo ='$fechaRecibo' 
            AND b.estatus!='C'");
        $row = mysqli_fetch_assoc($result);

        return $row['verifica']; 
    }//--fin de funcion verificaExistePrefactura

    //function guardaFactura($id_servicio,$idPlan,$fecha_recibo,$idUnidadNegocio,$idSucursal,$idCxC){
    function guardaFactura($id_servicio,$idPlan,$fecha_recibo,$idUnidadNegocio,$idCxC,$usuario){
        $verifica = 0;
      
        $buscaDC = mysqli_query($this->link, "SELECT id_sucursal,IFNULL(rfc,'') AS rfc,IFNULL(razon_social,'') AS razon_social,
        dias_credito,IFNULL(codigo_postal,'') AS codigo_postal,porcentaje_iva,digitos_cuenta
        FROM servicios 
        WHERE id=".$id_servicio);
        $row1 = mysqli_fetch_assoc($buscaDC);

        $idSucursal = $row1['id_sucursal'];
        $rfc = $row1['rfc'];
        $razon_social = $row1['razon_social'];
        $dias_credito = $row1['dias_credito'];
        $codigo_postal = $row1['codigo_postal'];
        $porcentaje_iva = $row1['porcentaje_iva'];
        $digitos_cuenta = $row1['digitos_cuenta'];

        $buscaP = mysqli_query($this->link, "SELECT IFNULL(a.uso_cfdi,'') AS uso_cfdi,IFNULL(a.metodo_pago,'') AS metodo_pago,IFNULL(a.forma_pago,'') AS forma_pago,
        IFNULL(a.producto_sat,'') AS producto_sat,IFNULL(a.unidad_sat,'') AS unidad_sat,IFNULL(a.nombre_producto_sat,'') AS nombre_producto_sat,
        IFNULL(a.nombre_unidad_sat,'') AS nombre_unidad_sat,IFNULL(a.descripcion,'') AS descripcion,b.cantidad AS precio
        FROM servicios_bitacora_planes a
        LEFT JOIN servicios_cat_planes b ON a.id_plan=b.id
        WHERE a.id=".$idPlan);
        $row2 = mysqli_fetch_assoc($buscaP);

        $usoCFDI = $row2['uso_cfdi'];
        $metodoPago = $row2['metodo_pago'];
        $formaPago = $row2['forma_pago'];
        $idClaveSATProducto = $row2['producto_sat'];
        $idClaveSATUnidad = $row2['unidad_sat'];
        $nombreUnidadSAT = $row2['nombre_unidad_sat'];
        $nombreProductoSAT = $row2['nombre_producto_sat'];
        $precio = $row2['precio'];
        $descripcion = $row2['descripcion'];

        $iva = ($precio * $porcentaje_iva)/100;
        $total = $precio + $iva;
        $fechaActual = date("Y/m/d");;
        $mesActual = date("m");
        $anioActual = date("Y");

        //verifica si los registros tienen datos para facturar y generar factura
        if($rfc != '' && $razon_social != '' && $codigo_postal != '' &&
            $usoCFDI != '' && $metodoPago != '' && $formaPago != '' && 
            $idClaveSATProducto != '' && $idClaveSATUnidad != '' && 
            $nombreUnidadSAT != '' && $nombreProductoSAT != '' && $descripcion != '')
        {
            $partidas[0] = array('idClaveSATProducto' => $idClaveSATProducto,
                            'idClaveSATUnidad' => $idClaveSATUnidad,
                            'nombreUnidadSAT' => $nombreUnidadSAT,
                            'nombreProductoSAT' => $nombreProductoSAT,
                            'cantidad' => 1,
                            'precio' => $precio,
                            'importe' => $precio,
                            'descripcion' => $descripcion,
                            'idPlan' => $idPlan,
                            'fechaRecibo' => $fecha_recibo,
                            'idCXC' => $idCxC);

        $factura = array('idUnidadNegocio' => $idUnidadNegocio,
                            'idSucursal' => $idSucursal,
                            'idCliente' => $id_servicio,
                            'idEmpresaFiscalEmisor' => 5,   //es el id la empresa fiscal SECORP ALARMAS  S DE RL DE CV en la tabla empresas_fiscales
                            'idRazonSocialReceptor' => $id_servicio,
                            'razonSocialReceptor' => $razon_social,
                            'rfc' => $rfc,
                            'idUsoCFDI' => $usoCFDI,
                            'idMetodoPago' => $metodoPago,
                            'idFormaPago' => $formaPago,
                            'fecha' => $fechaActual,
                            'diasCredito' => $dias_credito,
                            'tasaIva' => $porcentaje_iva,
                            'digitosCuenta' => $digitos_cuenta,
                            'mes' => $mesActual,
                            'anio' => $anioActual,
                            'observaciones' => 'Recibo de Plan',
                            'partidas' => $partidas,
                            'subtotal' => $precio,
                            'iva' => $iva,
                            'total' => $total,
                            'fechaInicioPeriodo' => $fechaActual,
                            'fechaFinPeriodo' => $fechaActual,
                            'codigoPostal' => $codigo_postal,
                            'idCFDIEmpresaFiscal' => 6,  //es el id_cfdi la empresa fiscal SECORP ALARMAS  S DE RL DE CV en la tabla empresas_fiscales
                            'usuario' => $usuario,
                            'esPlan' => 1,
                            'idCxC' => $idCxC);

            $modelFacturacion = new Facturacion();
            $idFactura = $modelFacturacion->guardarActualizar($factura); 

            if($idFactura > 0)
                $verifica = $this -> actualizaCxCidFactura($idFactura,$idCxC);
            else
                $verifica = 0;

        }
        else 
            $verifica = 1;

        


        return $verifica;
    }//--fin de funcion guardaFactura

    function actualizaCxCidFactura($idFactura,$idCxC){
        $verifica = 0;
        $query = "UPDATE cxc SET id_factura=$idFactura WHERE id=".$idCxC;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idCxC = mysqli_insert_id($this->link);

        if($result) 
            $verifica = 1;
        else
            $verifica = 0;

        return $verifica;
    }//--fin de funcion actualizaCxCidFactura
    
    function obtenerDatosServicio($idSucursal){
        $query = "SELECT b.logo AS logo,
        c.descr AS sucursal,c.codigopostal,
        CONCAT(c.calle,' No. Ext ' ,c.no_exterior,(IF(c.no_interior!='','No. Int ','')),c.no_interior) AS direccion,
        c.colonia AS colonia,
        d.estado,
        e.municipio
        FROM sucursales c
        LEFT JOIN cat_unidades_negocio b ON c.id_unidad_negocio=b.id
        LEFT JOIN estados d ON c.id_estado = d.id
        LEFT JOIN municipios e ON c.id_municipio = e.id
        WHERE c.id_sucursal=".$idSucursal;

        $result = $this->link->query($query);
        return $result;
    }//--fin de funcion obtenerDatosServicio

    function generaTablaTemporal($planes){
        $verifica = 1;

        $elimina1 = "TRUNCATE TABLE fechas_recibo_plan";
        $resultElimina = mysqli_query($this->link, $elimina1)or die(mysqli_error());
        
        /*$query = "CREATE TEMPORARY TABLE fechas_recibo_plan (id INT NOT NULL AUTO_INCREMENT,
                    id_plan INT,
                    temporal_num INT,
                    fecha_recibo DATE,
                    PRIMARY KEY ( id ))";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());*/
       
        foreach($planes AS $val)
        {
            $id = $val['id'];
            $fechas = $val['fecha_recibo'];
            $temporalNum = ceil($val['num']/50);

            $plan = $val['plan'];
            $forma_entrega = $val['entrega'];
            $forma_pago = $val['pago'];
            $cliente = $val['razon_social'];
            $cantidad = $val['cantidad'];
            $cuenta = $val['cuenta'];
            $direccion = $val['direccion'];
            $colonia = $val['colonia'];
            $estado = $val['estado'];
            $municipio = $val['municipio'];
            $codigo_postal = $val['codigo_postal'];
            $razon_social = $val['razon_social'];
            $rfc = $val['rfc'];

            foreach($fechas as $f)
            {
                $fechaRecibo = $f;

                $insert = "INSERT INTO fechas_recibo_plan
                            (id_plan,
                            temporal_num,
                            fecha_recibo,
                            plan,
                            forma_entrega,
                            forma_pago,
                            cliente,
                            cantidad,
                            cuenta,
                            direccion,
                            colonia,
                            estado,
                            municipio,
                            codigo_postal,
                            rfc)
                            VALUES
                            ('$id',
                            '$temporalNum',
                            '$fechaRecibo',
                            '$plan',
                            '$forma_entrega',
                            '$forma_pago',
                            '$cliente',
                            '$cantidad',
                            '$cuenta',
                            '$direccion',
                            '$colonia',
                            '$estado',
                            '$municipio',
                            '$codigo_postal',
                            '$rfc')";
                $result2 = mysqli_query($this->link,$insert) or die(mysqli_error());
                if(!$result2){
                    $verifica = 0;
                    break;
                }
              
            }
            
        }

        
        //$queryB = "SELECT MAX(temporal_num) as bloques FROM fechas_recibo_plan";
        $queryB = "SELECT MAX(temporal_num) AS bloques,
                    COUNT(*) AS totales
                    FROM fechas_recibo_plan
                    GROUP BY temporal_num
                    ORDER BY temporal_num ASC";
        //$resultB = mysqli_query($this->link,$queryB) or die(mysqli_error());
        //$dato = mysqli_fetch_array($resultB);
        //$verifica = $dato['bloques'];
        $resultB = $this->link->query($queryB);
        $verifica = $resultB;

        return $verifica;

    }//--fin de funcion generaTablaTemporal

    function obtenerRegistrosBloques($numBloque){
        $query = "SELECT id_plan, fecha_recibo,temporal_num,plan,forma_entrega,forma_pago,
                    cliente,cantidad,cuenta,direccion,colonia,estado,municipio,codigo_postal
                    FROM fechas_recibo_plan WHERE temporal_num=".$numBloque;

        $result = $this->link->query($query);
        return $result;
    }

    function buscaCxCsinFactura(){
        $result = mysqli_query($this->link, "SELECT COUNT(a.id) AS num_recibos_sin_factura
                FROM cxc a
                LEFT JOIN servicios_bitacora_planes b ON a.id_plan=b.id_plan
                WHERE a.id_plan > 0 AND a.id_factura=0 AND b.factura='SI'
                AND b.id IN (SELECT MAX(id)
                    FROM servicios_bitacora_planes 
                    GROUP BY id_servicio)");

        $row = mysqli_fetch_assoc($result);

        return $row['num_recibos_sin_factura'];
    }
    
}//--fin de class Recibos
    
?>