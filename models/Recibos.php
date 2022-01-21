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
                    IFNULL(b.nombre_corto,'') AS nombre_corto,IFNULL(b.cuenta,'') AS cuenta,
                    UPPER(CONCAT(IFNULL(b.domicilio,''),' No. Ext ' ,IFNULL(b.no_exterior,''),(IF(IFNULL(b.no_interior,'')!='',', No. Int ','')),IFNULL(b.no_interior,''))) AS direccion,
                    IFNULL(UPPER(b.colonia),'') AS colonia, IFNULL(UPPER(e.estado),'') AS estado, IFNULL(UPPER(f.municipio),'') AS municipio,
                    IFNULL(b.codigo_postal,'') AS codigo_postal,
                    UPPER(CONCAT(IFNULL(b.domicilio_s,''),' No. Ext ' ,IFNULL(b.no_exterior_s,''),(IF(IFNULL(b.no_interior_s,'')!='',', No. Int ','')),IFNULL(b.no_interior_s,''))) AS direccion_s,
                    IFNULL(UPPER(b.colonia_s),'') AS colonia_s,IFNULL(UPPER(g.estado),'') AS estado_s, IFNULL(UPPER(h.municipio),'') AS municipio_s,
                    IFNULL(b.codigo_postal_s,'') AS codigo_postal_s,
                    IF(b.entrega=0,'FISICA',IF(b.entrega=1,'CORREO','FISICA Y CORREO')) AS entrega,IF(b.pago='E','EFECTIVO','TRANSFERENCIA') AS pago,
                    d.descripcion AS plan, d.cantidad,
                    IFNULL(a.especificaciones_cobranza,'') AS especificaciones_cobranza,
                    IFNULL(b.contacto,'') AS contacto,IFNULL(b.telefonos,'') AS telefono
                    FROM servicios_bitacora_planes a
                    INNER JOIN servicios b ON a.id_servicio=b.id
                    LEFT JOIN cxc c ON a.id=c.id_plan 
                    INNER JOIN servicios_cat_planes d ON a.id_plan=d.id
                    LEFT JOIN estados e ON b.id_estado = e.id
                    LEFT JOIN municipios f ON b.id_municipio = f.id
                    LEFT JOIN estados g ON b.id_estado_s = g.id
                    LEFT JOIN municipios h ON b.id_municipio_s = h.id
                    WHERE b.id_sucursal=$idSucursal AND b.activo=1 AND d.tipo!=0
                    AND a.id IN (SELECT MAX(id)
                                FROM servicios_bitacora_planes 
                                GROUP BY id_servicio)
                    GROUP BY a.id_servicio
                    ORDER BY a.id ASC";

        $result = $this->link->query($query);
        return $result;

    }


    function buscarFecha($fecha_captura,$meses,$tipo, $dia,  $fechaInicio, $fechaFin)
    {

        $cont=0;
        $arrFechas=array();

        $diaF = "";
    
        //--> NJES Jan/23/2020 Todos los cobros deben ser prepago

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
            while($diaF<=$fechaFin)
            {

                if($diaF>=$fechaInicio)
                    array_push($arrFechas, $diaF);
                
                $diaF = date("Y-m-d",strtotime($diaF."+ 1 year"));
            }

        }else if($tipo == 4)  //-> semanal  (4)
        {

            $dS =  $semanal[$dia];

            $diaF = date("Y-m-d",strtotime($dS.' this week',strtotime($fecha_captura)));//$diaF = date("Y-m-d",strtotime($dS.' next week',strtotime($fecha_captura)));

            while($diaF<=$fechaFin)
            {

                if($diaF>=$fechaInicio)
                {
                    if($diaF >= $fecha_captura)
                        array_push($arrFechas, $diaF);
                }
                   
                $diaF = date("Y-m-d",strtotime($dS.' next week',strtotime($diaF)));
            }

        }
        else if($tipo == 3) //-> quincenal  (3)
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
            
            if($nQ[$key] < 10)
                $diaF = $anioInicioC . '-' . $mesInicioC . '-0' . $nQ[$key];
            else
                $diaF = $anioInicioC . '-' . $mesInicioC . '-' . $nQ[$key];   
            
            $diaA = date("d", strtotime($fecha_captura));

            $mesActual = date("m", strtotime($diaF));
            $anioActual = date("Y", strtotime($diaF));
            
                while($anioActual<=$anioFin)
                {

                    if($mesActual <= 12)
                    {
                        while($mesActual <= 12)
                        {
                            if(strlen(trim($mesActual)) == 1)
                                $mesAN = '-0' . $mesActual;
                            else
                                $mesAN = '-' . $mesActual;

                            if($nQ[0] < 10)
                                $diaF = $anioActual . $mesAN . '-0' . $nQ[0];
                            else
                                $diaF = $anioActual . $mesAN . '-' . $nQ[0];


                            if($diaF >= $fechaInicio)
                            {
                                $nueva = date_diff(date_create($diaF),date_create($fecha_captura));
                                $dif = $nueva->format('%a');
                                
                                if($diaF<=$fechaFin)
                                {
                                    //if($dif >= 15)
                                    if($diaF >= $fecha_captura)
                                        array_push($arrFechas, $diaF);
                                }
                            }

                            if(strlen(trim($mesActual)) == 1)
                                $diaF = $anioActual . '-0' . $mesActual . '-' . $nQ[1];
                            else
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
                                    //if($dif >= 15)
                                    if($diaF >= $fecha_captura)
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
                                    //if($dif >= 15)
                                    if($diaF >= $fecha_captura)
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
                                    //if($dif >= 15)
                                    if($diaF >= $fecha_captura)
                                        array_push($arrFechas, $diaF);
                                }
                            }

                            $mesActual++;
                        }
                    }
                }

        }
        else
        { //-> mensual  (2)

            $anio = date("Y", strtotime($fecha_captura));
            $mes = date("m", strtotime($fecha_captura));

            $verificaFF = explode("-", $dia);

            if(count($verificaFF)  == 1)
            {

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
                            $diaF = date("Y-m-d",strtotime($diaF." -".$dS." Day"));//$diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month -".$dS." Day"));
                        else
                            $diaF = date("Y-m-d",strtotime($diaF));//$diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));

                    }else
                        $diaF = date("Y-m-d",strtotime($diaF));//$diaF = date("Y-m-d",strtotime($diaF."+ ".$meses." month"));


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
            
        }

        //echo json_encode($arrFechas);

        return $arrFechas;

    }//--fin de funcion buscarFecha

    function verificaExisteCxC($idPlan, $fechaRecibo){

        $query = "SELECT  COUNT(id) as verifica 
                    FROM cxc WHERE id_plan = $idPlan 
                    AND fecha_corte_recibo ='$fechaRecibo' 
                    AND estatus!='C'";

        // echo $query;
        // exit();

        $result = mysqli_query($this->link, $query);
        $row = mysqli_fetch_assoc($result);
        
        return $row['verifica']; 

    }//--fin de funcion verificaExisteCxC

    function generaCxC($info){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardaCxC($info);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//--fin de funcion generaCxC

    function guardaCxC($info){
        $verifica = 0;

        $idPlan = $info['idPlan'];
        $fechaRecibo = $info['fechaRecibo'];
        $idUnidadNegocio = $info['idUnidadNegocio'];
        $idSucursal = $info['idSucursal'];
        $factura = $info['factura'];
        $idServicio = $info['idServicio'];
        $usuario = $info['usuario'];
        $monto = $info['monto'];
        $fechaVencimiento = $info['fechaVencimiento'];
        $anio = $info['anio'];
        $mes = $info['mes'];
        $idUsuario = $info['idUsuario'];
        $meses = $info['meses'];
        $banderaExtraordinaria = isset($info['banderaExtraordinaria']) ? $info['banderaExtraordinaria']: 0;
        //-->NJES March/18/2020 agregar precio y descripcion de plan a recibo individual cuando es fecha extraordinaria
        $descripcionExtra = isset($info['descripcionExtra']) ? $info['descripcionExtra']: '';
        
        // NJES Jan/22/2020 el precio del plan ya lleva iva incluido del 16%
        //$subtotal = $monto/1.16;
        //$monto_iva = $subtotal*.16;

        //-->NJES Jun/10/2021 redondear a dos decimales
        $subtotal = $this -> num_2dec($monto/1.16);
        $monto_iva = $this -> num_2dec($subtotal*.16);

        if($factura == 'SI')
            $facturar = 1;
        else
            $facturar = 0;

        if($idSucursal == 57)
            $rfcE = 'SEY131211QS7';
        else
            $rfcE = 'SAL080528436';

        $buscaEmpresaFiscal = mysqli_query($this->link, "SELECT id_empresa,id_cfdi FROM empresas_fiscales WHERE rfc='$rfcE'");
        $numR = mysqli_num_rows($buscaEmpresaFiscal);
        if($numR > 0)
        {
            $rowEF = mysqli_fetch_assoc($buscaEmpresaFiscal);

            $idEmpresaFiscal = $rowEF['id_empresa'];
            $idCFDI = $rowEF['id_cfdi'];
        }else{
            $idEmpresaFiscal = 5;
            $idCFDI = 6;
        }

        //-->busca el folio de la sucursal para aumentarlo
        $queryFolio="SELECT folio_recibo FROM sucursales WHERE id_sucursal=".$idSucursal;
        $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());

        if($resultF)
        {
            $datosX=mysqli_fetch_array($resultF);
            $folioA=$datosX['folio_recibo'];
            $folio_recibo= $folioA+1;

            //--> aumenta el folio de la sucursal
            $queryU = "UPDATE sucursales SET folio_recibo='$folio_recibo' WHERE id_sucursal=".$idSucursal;

            // echo $queryU;
            // exit();

            $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
            if($resultU)
            {
                //-->NJES March/18/2020 agregar precio y descripcion de plan a recibo individual cuando es fecha extraordinaria
                $query = "INSERT INTO cxc(id_unidad_negocio,id_sucursal,id_plan,fecha_corte_recibo,cargo_inicial,tasa_iva,subtotal,iva,total,id_razon_social_servicio,mes,anio,fecha,vencimiento,id_concepto,cve_concepto,facturar,id_empresa_fiscal,usuario_captura,folio_recibo,b_fecha_extraordinaria,descripcion_plan) 
                VALUES ('$idUnidadNegocio','$idSucursal','$idPlan','$fechaRecibo',1,16,'$subtotal','$monto_iva','$monto','$idServicio','$mes','$anio','$fechaRecibo','$fechaVencimiento',32,'C01','$facturar','$idEmpresaFiscal','$idUsuario','$folio_recibo','$banderaExtraordinaria','$descripcionExtra')";
                
                // echo $query;
                // exit();

                $result = mysqli_query($this->link, $query) or die(mysqli_error());
                $idCxC = mysqli_insert_id($this->link);

                if($result) 
                {
                    $actualiza = "UPDATE cxc SET folio_cxc='$idCxC' WHERE id=".$idCxC;
                    $result_actualiza = mysqli_query($this->link, $actualiza) or die(mysqli_error());

                    if($result_actualiza)
                    {
                        if($factura == 'SI')
                        {
                            $existeF = $this -> verificaExistePrefactura($idPlan, $fechaRecibo);
                            
                            if($existeF == 0 && $fechaRecibo != "")
                            {
                                $verifica = $this -> guardaFactura($idServicio,$idPlan, $fechaRecibo,$idUnidadNegocio,$idCxC,$usuario,$idEmpresaFiscal,$idCFDI,$fechaVencimiento,$meses,$banderaExtraordinaria,$descripcionExtra,$monto);
                            }else
                                $verifica = 1;

                        }else
                            $verifica = 1;
                        
                    }else
                        $verifica = 0;

                }else
                    $verifica = 0;
            }else
                $verifica = 0;

        }else
            $verifica = 0;

        return $verifica;
    }//--fin de funcion guardaCxC

    function verificaExistePrefactura($idPlan, $fechaRecibo){

        $query = "SELECT COUNT(a.id) AS verifica
                    FROM facturas_d a
                    LEFT JOIN facturas b ON a.id_factura=b.id
                    WHERE a.id_plan = $idPlan 
                    AND a.fecha_recibo ='$fechaRecibo' 
                    AND b.estatus!='C'";

        // echo $query;
        // exit();

        $result = mysqli_query($this->link, $query);
        $row = mysqli_fetch_assoc($result);

        return $row['verifica']; 
    }//--fin de funcion verificaExistePrefactura

    //function guardaFactura($id_servicio,$idPlan,$fecha_recibo,$idUnidadNegocio,$idSucursal,$idCxC){
    function guardaFactura($id_servicio,$idPlan,$fecha_recibo,$idUnidadNegocio,$idCxC,$usuario,$idEmpresaFiscal,$idCFDI,$fechaVencimiento,$meses,$banderaExtraordinaria,$descripcionExtra,$monto){
        $verifica = 0;

        $query = "SELECT id_sucursal,IFNULL(rfc,'') AS rfc,IFNULL(razon_social,'') AS razon_social,
                dias_credito,IFNULL(codigo_postal,'') AS codigo_postal,porcentaje_iva,digitos_cuenta,cuenta
                FROM servicios 
                WHERE id=".$id_servicio;

        // echo $query;
        // exit();

        $buscaDC = mysqli_query($this->link, $query);
        $row1 = mysqli_fetch_assoc($buscaDC);

        $idSucursal = $row1['id_sucursal'];
        $rfc = $row1['rfc'];
        $razon_social = $row1['razon_social'];
        $dias_credito = $row1['dias_credito'];
        $codigo_postal = $row1['codigo_postal'];
        $porcentaje_iva = $row1['porcentaje_iva'];
        $digitos_cuenta = $row1['digitos_cuenta'];
        //-->NJES Feb/18/2020 se agregan variables que se toman para la concatenacion de la descripción de la prefactura
        $cuenta = $row1['cuenta'];

        $query = "SELECT IFNULL(a.uso_cfdi,'') AS uso_cfdi,IFNULL(a.metodo_pago,'') AS metodo_pago,IFNULL(a.forma_pago,'') AS forma_pago,
                IFNULL(a.producto_sat,'') AS producto_sat,IFNULL(a.unidad_sat,'') AS unidad_sat,IFNULL(a.nombre_producto_sat,'') AS nombre_producto_sat,
                IFNULL(a.nombre_unidad_sat,'') AS nombre_unidad_sat,IFNULL(a.descripcion,'') AS descripcion,b.cantidad AS precio,
                b.descripcion AS descripcion_cat,IF(b.meses=12,YEAR(NOW()),0) AS anio_actual,YEAR(DATE_ADD(CURRENT_DATE(),INTERVAL 1 YEAR)) AS anio_siguiente
                FROM servicios_bitacora_planes a
                LEFT JOIN servicios_cat_planes b ON a.id_plan=b.id
                WHERE a.id=".$idPlan;

        // echo $query;
        // exit();

        $buscaP = mysqli_query($this->link, $query);
        $row2 = mysqli_fetch_assoc($buscaP);

        $usoCFDI = $row2['uso_cfdi'];
        $metodoPago = $row2['metodo_pago'];
        $formaPago = $row2['forma_pago'];
        $idClaveSATProducto = $row2['producto_sat'];
        $idClaveSATUnidad = $row2['unidad_sat'];
        $nombreUnidadSAT = $row2['nombre_unidad_sat'];
        $nombreProductoSAT = $row2['nombre_producto_sat'];
        
        //-->NJES March/18/2020 agregar precio y descripcion de plan a recibo individual cuando es fecha extraordinaria
        if($banderaExtraordinaria == 1)
            $precio = $monto;
        else
            $precio = $row2['precio'];
        

        //-->NJES Feb/18/2020  se agregan variables que se toman para la concatenacion de la descripción de la prefactura
        $descripcion_cat = $row2['descripcion_cat'];
        $descripcion = $row2['descripcion'];
        

        // NJES Jan/22/2020 el precio del plan ya lleva iva incluido del 16%
        //$subtotal = $precio/1.16;
        //$monto_iva = $subtotal*.16;

        //-->NJES Jun/10/2021 redondear a dos decimales
        $subtotal = $this -> num_2dec($precio/1.16);
        $monto_iva = $this -> num_2dec($subtotal*.16);

        $fechaActual = date("Y/m/d");
        $mesActual = date("m");
        $anioActual = date("Y");

        //-->NJES Feb/18/2020 se agregan variables que se toman para la concatenacion de la descripción de la prefactura
        $mesPeriodo = date("n", strtotime($fecha_recibo));  //Representación numérica de un mes, sin ceros iniciales
        $mesPeriodoFin = date("n", strtotime($fechaVencimiento));
        $anioActualPeriodo = $row2['anio_actual'];
        $anioSiguientePeriodo = $row2['anio_siguiente'];

        //verifica si los registros tienen datos para facturar y generar factura
        if($rfc != '' && $razon_social != '' && $codigo_postal != '' &&
            $usoCFDI != '' && $metodoPago != '' && $formaPago != '' && 
            $idClaveSATProducto != '' && $idClaveSATUnidad != '' && 
            $nombreUnidadSAT != '' && $nombreProductoSAT != '' && $descripcion != '')
        {
            if($banderaExtraordinaria == 1)
            {
                $descripcionConcat = $descripcionExtra;
            }else{
                //-->NJES Feb/18/2020 se concatena la descripción de la prefactura
                if(intval($meses)==1){
                    $descripcionConcat = $descripcion . ' '.$descripcion_cat .' DE '. $this -> nombreMes(intval($mesPeriodo)) .' CUENTA: '. $cuenta ;
                }else if(intval($meses)==12){
                    $descripcionConcat = $descripcion .' '. $descripcion_cat. ' DEL PERIODO '. $this -> nombreMes(intval($mesPeriodo)).' '. $anioActualPeriodo .' - '. $this -> nombreMes(intval($mesPeriodoFin)).' '. $anioSiguientePeriodo .' CUENTA: '. $cuenta;
                }else{
                    $descripcionConcat = $descripcion .' '. $descripcion_cat. ' DEL PERIODO '. $this -> nombreMes(intval($mesPeriodo))  .' - '. $this -> nombreMes(intval($mesPeriodoFin)).' CUENTA: '. $cuenta;
                }
            }

            $partidas[0] = array('idClaveSATProducto' => $idClaveSATProducto,
                            'idClaveSATUnidad' => $idClaveSATUnidad,
                            'nombreUnidadSAT' => $nombreUnidadSAT,
                            'nombreProductoSAT' => $nombreProductoSAT,
                            'cantidad' => 1,
                            'precio' => $subtotal,
                            'importe' => $subtotal,
                            //-->NJES Feb/18/2020 se agrega la nueva descripción concatenada
                            'descripcion' => $descripcionConcat,
                            'idPlan' => $idPlan,
                            'fechaRecibo' => $fecha_recibo,
                            'idCXC' => $idCxC);

        $factura = array('idUnidadNegocio' => $idUnidadNegocio,
                            'idSucursal' => $idSucursal,
                            'idCliente' => $id_servicio,
                            'idEmpresaFiscalEmisor' => $idEmpresaFiscal,   //es el id la empresa fiscal SECORP ALARMAS  S DE RL DE CV en la tabla empresas_fiscales
                            'idRazonSocialReceptor' => $id_servicio,
                            'razonSocialReceptor' => $razon_social,
                            'rfc' => $rfc,
                            'idUsoCFDI' => $usoCFDI,
                            'idMetodoPago' => $metodoPago,
                            'idFormaPago' => $formaPago,
                            'fecha' => $fechaActual,
                            'diasCredito' => $dias_credito,
                            'tasaIva' => 16, //NJES Jan/22/2020 el iva siempre sera 16
                            'digitosCuenta' => $digitos_cuenta,
                            'mes' => $mesActual,
                            'anio' => $anioActual,
                            'observaciones' => 'Recibo de Plan',
                            'partidas' => $partidas,
                            'subtotal' => $subtotal,
                            'iva' => $monto_iva,
                            'total' => $precio,
                            'fechaInicioPeriodo' => $fecha_recibo,
                            'fechaFinPeriodo' => $fechaVencimiento,
                            'codigoPostal' => $codigo_postal,
                            'idCFDIEmpresaFiscal' => $idCFDI,  //es el id_cfdi la empresa fiscal SECORP ALARMAS  S DE RL DE CV en la tabla empresas_fiscales
                            'usuario' => $usuario,
                            'esPlan' => 1,
                            'idCxC' => $idCxC);

            // print_r( $factura );
            // exit();

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
    
    function obtenerDatosSucursal($idSucursal){
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
    }//--fin de funcion obtenerDatosSucursal

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
            $temporalNum = ceil($val['num']/25);

            $plan = $val['plan'];
            $forma_entrega = $val['entrega'];
            $forma_pago = $val['pago'];
            $cliente = $val['nombre_corto'];
            $cantidad = $val['cantidad'];
            $cuenta = $val['cuenta'];
            $direccion = $val['direccion'];
            $colonia = $val['colonia'];
            $estado = $val['estado'];
            $municipio = $val['municipio'];
            $codigo_postal = $val['codigo_postal'];
            $direccionS = $val['direccion_s'];
            $coloniaS = $val['colonia_s'];
            $estadoS = $val['estado_s'];
            $municipioS = $val['municipio_s'];
            $codigo_postalS = $val['codigo_postal_s'];
            $factura =($val['factura'] == 'SI')?1:0;
            $razon_social = $val['razon_social'];
            $rfc = $val['rfc'];
            $especificaciones_cobranza = $val['especificaciones_cobranza'];
            $contacto = $val['contacto'];
            $telefono = $val['telefono'];
            
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
                            rfc,
                            especificaciones_cobranza,
                            contacto,
                            telefono,
                            direccion_s,
                            colonia_s,
                            estado_s,
                            municipio_s,
                            codigo_postal_s,
                            factura)
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
                            '$rfc',
                            '$especificaciones_cobranza',
                            '$contacto',
                            '$telefono',
                            '$direccionS',
                            '$coloniaS',
                            '$estadoS',
                            '$municipioS',
                            '$codigo_postalS',
                            '$factura')";
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
        $query = "SELECT a.id_plan, a.fecha_recibo,a.temporal_num,a.plan,a.forma_entrega,a.forma_pago,
                    a.cliente,a.cantidad,a.cuenta,a.direccion,a.colonia,a.estado,a.municipio,a.codigo_postal,
                    a.direccion_s,a.colonia_s,a.estado_s,a.municipio_s,a.codigo_postal_s,a.factura,
                    IFNULL(a.especificaciones_cobranza,'') AS especificaciones_cobranza,b.folio_recibo,
                    IFNULL(a.contacto,'') AS contacto,IFNULL(a.telefono,'') AS telefono,b.vencimiento
                    FROM fechas_recibo_plan a
                    LEFT JOIN cxc b ON a.id_plan=b.id_plan AND a.fecha_recibo=b.fecha_corte_recibo
                    WHERE temporal_num=".$numBloque;

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

    /* para obtener la fecha de vencimiento de un recibo*/
    function fechaVencimiento($tipo,$dia,$meses,$fechaInicio){
        $diaF = "";

        $diaActual = date("d",strtotime($fechaInicio));
        $mesActual = date("m",strtotime($fechaInicio));
        $anioActual = date("Y",strtotime($fechaInicio));

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
            //--> para si el mes es febrero y el dia es 29, y el siguiente año del mes febrero no trae dia 29
            if($diaActual > 28)
            {
                $mes = date("m", strtotime($fechaInicio));
                $dS = date("d",strtotime($fechaInicio."+ 1 year"));

                if($diaActual != $dS)
                    $diaF = date("Y-m-d",strtotime($fechaInicio."+ 1 year -".$dS." Day"));
                else
                    $diaF = date("Y-m-d",strtotime($fechaInicio."+ 1 year"));

            }else
                $diaF = date("Y-m-d",strtotime($fechaInicio."+ 1 year"));
            
        }else if($tipo == 4)  //-> semanal  (4)
        {
            $dS =  $semanal[$dia];

            $diaF = date("Y-m-d",strtotime($dS.' next week',strtotime($fechaInicio)));

        }else if($tipo == 3) //-> quincenal  (3)
        {
            $nQ = $quincenal[$dia];
            
            if($diaActual > 15)
            {
                if($mesActual < 12)
                {
                    $mesActual++;
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
                }else{
                    $mesActual = '01';
                    $anioActual++;
                    if($nQ[0] < 10)
                        $diaF = $anioActual . '-' . $mesActual . '-0' . $nQ[0];
                    else
                        $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[0];
                }
            }else
            {
                $diaF = $anioActual . '-' . $mesActual  . '-' . $nQ[1];
            }

        }else{ //-> mensual  (2)

            $anio = date("Y", strtotime($fechaInicio));
            $mes = date("m", strtotime($fechaInicio));
            
            $diaF = $fechaInicio;

            if($dia > 28)
            {                
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

        return $diaF;
    }

    //-->NJES Feb/18/2020  para obtener el nombre del mes para la concatenacion de la descripcin de la prefactura
    function nombreMes($numMes){
        $mes='';
       switch($numMes) {
       case 1: 
           $mes = 'ENERO';
           break;
       case 2: 
           $mes = 'FEBRERO';
           break;
       case 3: 
           $mes = 'MARZO';
           break;  
       case 4: 
           $mes = 'ABRIL';
           break;
       case 5: 
           $mes = 'MAYO';
           break;
       case 6: 
           $mes = 'JUNIO';
           break;  
       case 7: 
           $mes = 'JULIO';
           break;
       case 8: 
           $mes = 'AGOSTO';
           break;
       case 9: 
           $mes = 'SEPTIEMBRE';
           break;  
       case 10: 
           $mes = 'OCTUBRE';
           break;
       case 11: 
           $mes = 'NOVIEMBRE';
           break;
       case 12:
           $mes = 'DICIEMBRE';
           break;        
       default:  $mes ='';
       }
       return  $mes;
    }

    //-->NJES Feb/27/2020 
    function buscarPlanIdServicio($idServicio){

        $query = "SELECT a.id,a.id_servicio,a.id_plan,a.factura,
        CASE
            WHEN a.dia_corte = 'L' THEN 'Semanal - LUNES'
            WHEN a.dia_corte = 'M' THEN 'Semanal - MARTES'
            WHEN a.dia_corte = 'X' THEN 'Semanal - MIERCOLES'
            WHEN a.dia_corte = 'J' THEN 'Semanal - JUEVES'
            WHEN a.dia_corte = 'V' THEN 'Semanal - VIERNES'
            WHEN a.dia_corte = 'S' THEN 'Semanal - SABADO'
            WHEN a.dia_corte = 'D' THEN 'Semanal - DOMINGO'
            WHEN a.dia_corte = 'Q1' THEN 'Quincenal días 1 y 16'
            WHEN a.dia_corte = 'Q2' THEN 'Quincenal días 2 y 17'
            WHEN a.dia_corte = 'Q3' THEN 'Quincenal días 3 y 18'
            WHEN a.dia_corte = 'Q4' THEN 'Quincenal días 4 y 19'
            WHEN a.dia_corte = 'Q5' THEN 'Quincenal días 5 y 20'
            WHEN a.dia_corte = 'Q6' THEN 'Quincenal días 6 y 21'
            WHEN a.dia_corte = 'Q7' THEN 'Quincenal días 7 y 22'
            WHEN a.dia_corte = 'Q8' THEN 'Quincenal días 8 y 23'
            WHEN a.dia_corte = 'Q9' THEN 'Quincenal días 9 y 24'
            WHEN a.dia_corte = 'Q10' THEN 'Quincenal días 10 y 25'
            WHEN a.dia_corte = 'Q11' THEN 'Quincenal días 11 y 26'
            WHEN a.dia_corte = 'Q12' THEN 'Quincenal días 12 y 27'
            WHEN a.dia_corte = 'Q13' THEN 'Quincenal días 13 y 28'
            WHEN a.dia_corte = 'Q14' THEN 'Quincenal días 14 y 29'
            WHEN a.dia_corte = 'Q15' THEN 'Quincenal días 15 y 30'
            ELSE a.dia_corte
        END AS dia_corte,
        d.tipo AS tipo_plan,d.descripcion,d.cantidad,
        IFNULL(c.id,0) AS id_cxc,
        IFNULL(MAX(c.fecha_corte_recibo),'') AS fecha_ultimo_recibo
        FROM servicios_bitacora_planes a
        INNER JOIN servicios b ON a.id_servicio=b.id
        LEFT JOIN cxc c ON a.id=c.id_plan AND c.b_fecha_extraordinaria=0 AND c.estatus!='C'
        INNER JOIN servicios_cat_planes d ON a.id_plan=d.id
        WHERE b.id=$idServicio AND d.tipo!=0
        AND a.id IN (SELECT MAX(id)
            FROM servicios_bitacora_planes 
            GROUP BY id_servicio)
        GROUP BY a.id_servicio
        ORDER BY a.id ASC";

        // echo $query;
        // exit();

        $result = $this->link->query($query);

        return query2json($result);
    }//- fin function buscarPlanIdServicio

    function obtenerPlanesFormatoIdServicio($idServicio){
        $query = "SELECT a.id,a.id_servicio,a.id_plan,a.factura,a.dia_corte,
        IFNULL(c.id_plan,0) AS id_plan_cxc,
        d.tipo AS tipo_plan,d.meses,DATE(a.fecha_captura) AS fecha_captura,
        IFNULL(b.nombre_corto,'') AS nombre_corto,IFNULL(b.cuenta,'') AS cuenta,
        UPPER(CONCAT(IFNULL(b.domicilio,''),' No. Ext ' ,IFNULL(b.no_exterior,''),(IF(IFNULL(b.no_interior,'')!='',', No. Int ','')),IFNULL(b.no_interior,''))) AS direccion,
        IFNULL(UPPER(b.colonia),'') AS colonia, IFNULL(UPPER(e.estado),'') AS estado, IFNULL(UPPER(f.municipio),'') AS municipio,
        IFNULL(b.codigo_postal,'') AS codigo_postal,
        UPPER(CONCAT(IFNULL(b.domicilio_s,''),' No. Ext ' ,IFNULL(b.no_exterior_s,''),(IF(IFNULL(b.no_interior_s,'')!='',', No. Int ','')),IFNULL(b.no_interior_s,''))) AS direccion_s,
        IFNULL(UPPER(b.colonia_s),'') AS colonia_s,IFNULL(UPPER(g.estado),'') AS estado_s, IFNULL(UPPER(h.municipio),'') AS municipio_s,
        IFNULL(b.codigo_postal_s,'') AS codigo_postal_s,
        IF(b.entrega=0,'FISICA',IF(b.entrega=1,'CORREO','FISICA Y CORREO')) AS entrega,IF(b.pago='E','EFECTIVO','TRANSFERENCIA') AS pago,
        d.descripcion AS plan, d.cantidad,
        IFNULL(a.especificaciones_cobranza,'') AS especificaciones_cobranza,
        IFNULL(b.contacto,'') AS contacto,IFNULL(b.telefonos,'') AS telefono
        FROM servicios_bitacora_planes a
        INNER JOIN servicios b ON a.id_servicio=b.id
        LEFT JOIN cxc c ON a.id=c.id_plan 
        INNER JOIN servicios_cat_planes d ON a.id_plan=d.id
        LEFT JOIN estados e ON b.id_estado = e.id
        LEFT JOIN municipios f ON b.id_municipio = f.id
        LEFT JOIN estados g ON b.id_estado_s = g.id
        LEFT JOIN municipios h ON b.id_municipio_s = h.id
        WHERE b.id=$idServicio AND d.tipo!=0
        AND a.id IN (SELECT MAX(id)
                    FROM servicios_bitacora_planes 
                    GROUP BY id_servicio)
        GROUP BY a.id_servicio
        ORDER BY a.id ASC";

        $result = $this->link->query($query);

        return $result;
    }

    /* para obtener la fecha recibo individual*/
    function fechaReciboIndividual($tipo,$dia,$meses,$fecha_captura){
        $diaF = "";

        $diaActual = date("d",strtotime($fecha_captura));
        $mesActual = date("m",strtotime($fecha_captura));
        $anioActual = date("Y",strtotime($fecha_captura));

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
            
        }else if($tipo == 4)  //-> semanal  (4)
        {
            $dS =  $semanal[$dia];

            $primerFecha = date("Y-m-d",strtotime($dS.' this week',strtotime($fecha_captura)));

            if($primerFecha >= $fecha_captura)
                $diaF = $primerFecha;
            else
                $diaF = date("Y-m-d",strtotime($dS.' next week',strtotime($fecha_captura)));

        }else if($tipo == 3) //-> quincenal  (3)
        {
            $nQ = $quincenal[$dia];

            $key = 0;
            if($diaActual > 15)
                $key = 1;
            
            if($nQ[$key] < 10)
                $primerFecha = $anioActual . '-' . $mesActual . '-0' . $nQ[$key];
            else
                $primerFecha = $anioActual . '-' . $mesActual . '-' . $nQ[$key];  
            
            if($primerFecha >= $fecha_captura)
            {
                $diaF = $primerFecha;
            }else{
                if($diaActual > 15)
                {
                    if($mesActual < 12)
                    {
                        $mesActual++;
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
                    }else{
                        $mesActual = '01';
                        $anioActual++;
                        if($nQ[0] < 10)
                            $diaF = $anioActual . '-' . $mesActual . '-0' . $nQ[0];
                        else
                            $diaF = $anioActual . '-' . $mesActual . '-' . $nQ[0];
                    }
                }else{
                    $diaF = $anioActual . '-' . $mesActual  . '-' . $nQ[1];
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
                $primerFecha = $anio . '-' . $mes . '-' . $diaN;
            else
                $primerFecha = $anio . '-' . $mes . '-' . $diaN;

            if($dia > 28)
            {
                $dA = date("d", strtotime($diaF));
                $dS = date("d",strtotime($diaF."+ ".$meses." month"));

                if($dA != $dS)
                    $primerFecha = date("Y-m-d",strtotime($primerFecha." -".$dS." Day"));
                else
                    $primerFecha = date("Y-m-d",strtotime($primerFecha));

            }else
                $primerFecha = date("Y-m-d",strtotime($primerFecha));


            if($primerFecha >= $fecha_captura)
            {
                $diaF = $primerFecha;
            }else{
                if($dia > 28)
                {
                    //-- por si el mes llega a caer en febrero se le restan los dias del siguiente mes 
                    //-- para que si ponga la fecha de febrero con el ultimo dia de ese mes y no se lo pase
                    $diaA = date("d", strtotime($primerFecha));
                    $diaS = date("d",strtotime($primerFecha."+ ".$meses." month"));

                    if($dia == $diaA)
                    {
                        if($diaA != $diaS)
                            $diaF = date("Y-m-d",strtotime($primerFecha."+ ".$meses." month -".$diaS." Day"));
                        else
                            $diaF = date("Y-m-d",strtotime($primerFecha."+ ".$meses." month"));
                    }else{
                        $a = date("Y", strtotime($primerFecha."+ ".$meses." month"));
                        $m = date("m", strtotime($primerFecha."+ ".$meses." month"));

                        $diaF = $a . '-' . $m . '-' . $dia;
                    }
                    
                }else
                    $diaF = date("Y-m-d",strtotime($primerFecha."+ ".$meses." month"));
            }
     
        }

        return $diaF;
    }

    //-->NJES Jun/10/2021 redondear a dos decimales
    function num_2dec($numero)
	{
		return number_format($numero, 2, '.', '');
	}
    
}//--fin de class Recibos
    
?>