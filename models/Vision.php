<?php

include 'conectar.php';

class Vision
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function __construct()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los registros de vales de gasolina del día actual
      * 
    **/
    // function buscarValesGasolinaHoy($idSucursal){
        
    
    //     $result = $this->link->query("SELECT a.id,IFNULL(a.folio,'') AS folio,a.fecha,a.clave_concepto,CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,
    //                                     ifnull(a.nombre_empleado,'') as nombre_empleado,a.importe,a.observaciones,c.nombre AS unidad_negocio,a.no_economico,
    //                                     d.descr AS sucursal,IFNULL(e.descripcion,'') AS area, IFNULL(f.des_dep,'') AS departamento, 
    //                                     ifnull(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS empleado,a.estatus
    //                                     FROM vales_gasolina a
    //                                     LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
    //                                     LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
    //                                     LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
    //                                     LEFT JOIN cat_areas e ON a.id_area=e.id
    //                                     LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
    //                                     LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
    //                                     WHERE a.id_sucursal=$idSucursal AND a.fecha=CURDATE() 
    //                                     ORDER BY folio");

    //     return query2json($result);
    // }//- fin function buscarValesGasolinaHoy

    /**
      * Busca registro de vales de gasolina
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardarVisionProductos($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//- fin function guardarVisionProductos

    /**
      * Busca registro de vales de gasolina
      * 
      * @param varchar $datos array que contiene los datos a insertar
      *
    **/
    function guardar($arreglo){

      // print_r($arreglo);

        $nombre = $arreglo[0];
        $descr = $arreglo[1];
        $clave = $arreglo[3];
        $cant = $arreglo[4];
        $image = $arreglo[5];
        $usuario = $_SESSION["usuario"];

        $query="INSERT INTO vision_productos(descripcion, nombre, clave, url_imagen, usuario_alta)
                VALUES ('$descr', '$nombre', '$clave', '$image', '$usuario');";

                // echo $query;

        $result=mysqli_query($this->link, $query)or die(mysqli_error());
        
        $id = mysqli_insert_id($this->link);

        if($result){
            return $id;
        }else{
            return 0;
        }
    }//- fin function guardar


    function guardarVisionCotizacion($prospecto, $materias, $productos){
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardarCotiz($prospecto, $materias, $productos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
    }

    function guardarCotiz($prospecto, $materias, $productos){

      $usuario = $_SESSION["usuario"];
      $cotizTotal = $prospecto[4];
      $prospectoDias = $prospecto[3];

      $query="INSERT INTO vision_cotizacion (total, fk_idcliente, usuario, tiempo_entrega)
              VALUES ($cotizTotal, '0', '$usuario', $prospectoDias);";

      $result=mysqli_query($this->link, $query)or die(mysqli_error());

      if($result){

        $idCotiz = mysqli_insert_id($this->link);

        $prospectoNombre = $prospecto[0];
        $prospectoTel = $prospecto[1];
        $prospectoCorreo = $prospecto[2];

        $query2 ="INSERT INTO vision_prospectos (nombre_cliente, telefono, correo, fk_cotizacion)
                  VALUES ('$prospectoNombre', '$prospectoTel', '$prospectoCorreo', $idCotiz);";

        $result2=mysqli_query($this->link, $query2)or die(mysqli_error());

        if($result2){

          $cadenaProdcutos = "";
          foreach ($productos as $valor) {
            $prodId = $valor[0];
            $prodCanti = $valor[1];
            $prodCosto = $valor[2];

            $cadenaProdcutos .= "($idCotiz, $prodId, $prodCanti, $prodCosto),";
          }

          $cadenaProductos = substr($cadenaProdcutos, 0, -1);

          $query3 = "INSERT INTO vision_cotizacion_productos (fk_cotizacion, fk_productos, cantidad, costo)
                    VALUES $cadenaProductos;";

          $result3=mysqli_query($this->link, $query3)or die(mysqli_error());

          if($result3){
            // enviarCorreoPdfCotizacion($idCotiz);

            return $idCotiz;
            
            // $cadenaMaterials = "";
            // foreach ($materias as $valor) {
            //   $matId = $valor[0];
            //   $matCanti = $valor[1];
  
            //   $cadenaMaterials .= "($matId, $idCotiz, $matCanti),";
            // }
  
            // $cadenaMaterias = substr($cadenaMaterials, 0, -1);
  
            // $query4 = "INSERT INTO vision_cotizacion_matprim (fk_matprim, fk_cotizacion, cantidad)
            //             VALUES $cadenaMaterias;";
  
            // $result4=mysqli_query($this->link, $query4)or die(mysqli_error());

            // if($result4){
            //   return $idCotiz;
            // }else{
            //   return 0;
            // }
          }else{
            return 0;
          }
        }else{
          return 0;
        }
      }else{
        return 0;
      }
    }//- fin function guardar

    function cambiarVisionCotizacionEstatus($arreglo){

      $idCotiz = $arreglo["idCotiz"];
      $idCliente = $arreglo["idCliente"];
      $estatus = $arreglo["estatus"];      
      $usuario = $_SESSION["usuario"];

      $query="UPDATE vision_cotizacion
              SET fk_idcliente = $idCliente, estatus = $estatus, usuario_autorizo = '$usuario'
              WHERE (id = $idCotiz );";

      $result=mysqli_query($this->link, $query)or die(mysqli_error());

      if($result){

        $rows = mysqli_affected_rows($this->link);

        // if($estatus == 1){
        //   $materias = $arreglo["materias"];

        //   $cadenaMaterials = "";
        //   foreach ($materias as $valor) {
        //     $matId = $valor[0];
        //     $matCanti = $valor[1];

        //     $cadenaMaterials .= "($matId, $idCotiz, $matCanti),";
        //   }

        //   $cadenaMaterias = substr($cadenaMaterials, 0, -1);

        //   $query4 = "INSERT INTO vision_cotizacion_matprim (fk_matprim, fk_cotizacion, cantidad)
        //               VALUES $cadenaMaterias;";

        //   $result4=mysqli_query($this->link, $query4)or die(mysqli_error());

        //   if($result4){
        //     // return $idCotiz;
        //     return $rows;
        //   }else{
        //     return 0;
        //   }
        // }else{
        //   return $rows;
        // }

        return $rows;
      }else{
        return 0;
      }
    }

    function terminarVisionCotizacionEstatus($arreglo){

      $idCotiz = $arreglo["id"];
      $usuario = $_SESSION["usuario"];
      $materias = $arreglo["materia"];

      $query="UPDATE vision_cotizacion
              SET estatus = 3, usuario_finalizo = '$usuario'
              WHERE (id = $idCotiz );";

      $result=mysqli_query($this->link, $query)or die(mysqli_error());

      if($result){
        $rows = mysqli_affected_rows($this->link);

        $cadenaMaterials = "";
        foreach ($materias as $valor) {
          $matId = $valor[0];
          $matCanti = $valor[1];

          $cadenaMaterials .= "($matId, $idCotiz, $matCanti),";
        }

        $cadenaMaterias = substr($cadenaMaterials, 0, -1);

        $query4 = "INSERT INTO vision_cotizacion_matprim (fk_matprim, fk_cotizacion, cantidad)
                    VALUES $cadenaMaterias;";

        $result4=mysqli_query($this->link, $query4)or die(mysqli_error());

        if($result4){
          // return $idCotiz;
          return $rows;
        }else{
          return 0;
        }
        
      }else{
        return 0;
      }
    }

    function editarVisionCotizacion($idCotiz, $productos){

      $cotizTotal = 0;

      $query="DELETE FROM vision_cotizacion_productos WHERE (fk_cotizacion = $idCotiz);";

      $result=mysqli_query($this->link, $query)or die(mysqli_error());

      if($result){

        $cadenaProdcutos = "";

        foreach ($productos as $valor) {
          $prodId = $valor[0];
          $prodCanti = $valor[1];
          $prodCosto = $valor[2];

          $cotizTotal += ($prodCanti * $prodCosto);

          $cadenaProdcutos .= "($idCotiz, $prodId, $prodCanti, $prodCosto),";
        }

        $cadenaProductos = substr($cadenaProdcutos, 0, -1);

        $query3 = "INSERT INTO vision_cotizacion_productos (fk_cotizacion, fk_productos, cantidad, costo)
                  VALUES $cadenaProductos;";

        $result3=mysqli_query($this->link, $query3)or die(mysqli_error());

        if($result3){

          $query2="UPDATE vision_cotizacion SET total = '$cotizTotal' WHERE (id = $idCotiz);";

          $result2=mysqli_query($this->link, $query2)or die(mysqli_error());

          if($result2){
            return $idCotiz;
          }else{
            return 0;
          }

        }else{
          return 0;
        }
      }else{
        return 0;
      }
    }//- fin function guardar
    /** 
      * Cancela el registro de vale de casolina
      * @param int $idRegistro id del registro que se actualiza a cancelado (estatus=0)
    **/
    // function cancelarValesGasolina($idRegistro,$justificacion){
    //     $queryB="SELECT id_unidad_negocio,id_sucursal,id_area,id_departamento,id_concepto,clave_concepto,fecha,id_empleado,nombre_empleado,importe,CONCAT('CANCELACIÓN ',observaciones) AS observaciones,id_usuario,externo_no_economico,no_economico
    //                 FROM vales_gasolina 
    //                 WHERE id=".$idRegistro;
    //     $resultB = mysqli_query($this->link, $queryB) or die(mysqli_error());

    //     if($resultB)
    //     {
    //         $datos=mysqli_fetch_array($resultB);

    //         $importe = $datos['importe'] * (-1);

    //         $arr=array('idUnidadNegocio'=>$datos['id_unidad_negocio'],
    //                     'idSucursal'=>$datos['id_sucursal'],
    //                     'idArea'=>$datos['id_area'],
    //                     'idDepartamento'=>$datos['id_departamento'],
    //                     'idConcepto'=>$datos['id_concepto'],
    //                     'claveConcepto'=>$datos['clave_concepto'],
    //                     'fecha'=>$datos['fecha'],
    //                     'idEmpleado'=>$datos['id_empleado'],
    //                     'empleado'=>$datos['nombre_empleado'],
    //                     'importe'=>$importe,
    //                     'observaciones'=>$datos['observaciones'],
    //                     'idUsuario'=>$datos['id_usuario'],
    //                     'externoNoEconomco'=>$datos['externo_no_economico'],
    //                     'noEconomico'=>$datos['no_economico'],
    //                     'estatus'=>0,
    //                     'justificacion'=>$justificacion,
    //                     'idRegistro'=>$idRegistro);

    //         $verifica = $this -> guardar($arr);
    //     }else{
    //         $verifica = 0;
    //     }

    //     return $verifica;
    // }//- fin function cancelarValesGasolina

    /**
      * Busca el saldo actual 
      * 
      * @param int idSucursal 
      *
    **/
    // function buscarSaldoActualIdSucursal($idSucursal){
    //     $result = $this->link->query("SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo
    //                                     FROM vales_gasolina
    //                                     WHERE id_sucursal=$idSucursal AND fecha <= CURDATE()
    //                                     GROUP BY id_sucursal");

    //     return query2json($result);
    // }//- fin function buscarSaldoActualIdSucursal

    /**
      * Busca registros de vales de gasolina de la sucursal y fechas seleccionadas (por default es del mes actual) 
      * 
      * @param varchar $datos array que contiene los datos
      *
    **/
    // function buscarValesGasolinaReporte($datos)
    // {

    //     $fechaInicio = $datos['fechaInicio'];
    //     $fechaFin = $datos['fechaFin'];
    //     $idSucursal = $datos['idSucursal'];

    //     $condicion='';

    //     if($fechaInicio == '' && $fechaFin == '')
    //     {
    //       $condicion=" AND MONTH(a.fecha)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
    //     }else if($fechaInicio != '' &&  $fechaFin == '')
    //     {
    //       $condicion=" AND a.fecha >= '$fechaInicio' ";
    //     }else{  //-->trae fecha inicio y fecha fin
    //       $condicion=" AND DATE(a.fecha) BETWEEN '$fechaInicio' AND '$fechaFin' ";
    //     }

    //     $result = $this->link->query("SELECT a.id,IFNULL(a.folio,'') AS folio,a.fecha,CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,
    //                                     a.nombre_empleado,a.importe,a.observaciones,a.no_economico,c.nombre AS unidad_negocio,
    //                                     d.descr AS sucursal,IFNULL(e.descripcion,'') AS area, IFNULL(f.des_dep,'') AS departamento, 
    //                                     IFNULL(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS empleado
    //                                     FROM vales_gasolina a
    //                                     LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
    //                                     LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
    //                                     LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
    //                                     LEFT JOIN cat_areas e ON a.id_area=e.id
    //                                     LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
    //                                     LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
    //                                     WHERE a.id_sucursal=$idSucursal $condicion
    //                                     ORDER BY a.id ASC");

    //     return query2json($result);
    // }//- fin function buscarValesGasolina

    /**
      * Busca el saldo inicial (fecha inicio) y final (fecha fin) de vales de gasolina
      * 
      * @param varchar $datos array que contiene los datos
      *
    **/
    // function buscarValesGasolinaSaldosReporte($datos)
    // {

    //     $fechaInicio = $datos['fechaInicio'];
    //     $fechaFin = $datos['fechaFin'];
    //     $idSucursal = $datos['idSucursal'];

    //     $saldo_inicial = 0;
    //     $saldo_final = 0;

    //     // AND fecha<='$fechaInicio'
    //     $query1="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_inicial
    //                 FROM vales_gasolina
    //                 WHERE id_sucursal=$idSucursal AND fecha <= DATE_ADD('$fechaInicio', INTERVAL -1 DAY)
    //                 GROUP BY id_sucursal";
    //     $result1 = mysqli_query($this->link, $query1) or die(mysqli_error());

    //     if($result1)
    //     {
    //         $datos=mysqli_fetch_array($result1);
    //         if($datos['saldo_inicial'] != '')
    //         {
    //             $saldo_inicial = $datos['saldo_inicial'];
    //         }else{
    //             $saldo_inicial = 0;
    //         }
    //     }
        
    //     $query2="SELECT IFNULL(SUM(IF(clave_concepto IN('C01','D01'),importe,importe*(-1))),0)AS saldo_final
    //                 FROM vales_gasolina
    //                 WHERE id_sucursal=$idSucursal AND fecha<='$fechaFin'
    //                 GROUP BY id_sucursal";
    //     $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

    //     if($result2)
    //     {
    //         $datos2=mysqli_fetch_array($result2);
    //         if($datos2['saldo_final'] != '')
    //         {
    //             $saldo_final = $datos2['saldo_final'];
    //         }else{
    //             $saldo_final = 0;
    //         }
    //     }

    //     $arreglo = array('saldo_inicial'=>$saldo_inicial,'saldo_final'=>$saldo_final);

    //     return json_encode($arreglo);
    // }//- fin function buscarValesGasolinaSaldosReporte


        /**
      * Busca los registros de vales de gasolina del día actual
      * 
    **/
    // function buscarValesGasolinaId($idVale){
        
    
    //     $result = $this->link->query("SELECT 
    //         a.id,
    //         a.id_sucursal,
    //         a.id_unidad_negocio,
    //         a.id_area,
    //         a.id_departamento,
    //         IFNULL(a.folio,'') AS folio,
    //         a.fecha,
    //         a.clave_concepto,
    //         CONCAT(a.clave_concepto,' ',b.descripcion) AS concepto,
    //         a.id_empleado,
    //         ifnull(a.nombre_empleado,'') as nombre_empleado,
    //         a.importe,
    //         a.observaciones,
    //         c.nombre AS unidad_negocio,
    //         a.externo_no_economico,
    //         a.no_economico,
    //         d.descr AS sucursal,
    //         IFNULL(e.descripcion,'') AS area, 
    //         IFNULL(f.des_dep,'') AS departamento, 
    //         ifnull(CONCAT(TRIM(g.nombre),' ',TRIM(g.apellido_p),' ',TRIM(g.apellido_m)),'') AS empleado,
    //         a.estatus
    //     FROM vales_gasolina a
    //     LEFT JOIN conceptos_cxp b ON a.id_concepto=b.id
    //     LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
    //     LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
    //     LEFT JOIN cat_areas e ON a.id_area=e.id
    //     LEFT JOIN deptos f ON a.id_departamento=f.id_depto AND f.tipo='I'
    //     LEFT JOIN trabajadores g ON a.id_empleado=g.id_trabajador
    //     WHERE a.id=".$idVale." 
    //     ORDER BY folio");

    //     return query2json($result);
    // }//- fin function buscarValesGasolinaHoy

    function traerVisionProductos(){
      $query = "SELECT id idProducto, nombre, clave, descripcion descr
                FROM vision_productos";

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionMaterias(){
      $query = "SELECT vmp.id idMateria, vmp.descripcion descr, vmp.clave, vmp.stock inicial, SUM(vcmp.cantidad) usado, (vmp.stock - SUM(vcmp.cantidad)) restante
                FROM vision_materiaprima vmp
                LEFT JOIN vision_cotizacion_matprim vcmp ON vcmp.fk_matprim = vmp.id
                GROUP BY vmp.id";

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionHistorial(){
      $query = "SELECT vc.id idCotiz,
                      DATE(vc.fecha) fecha,
                      vc.estatus,
                      IF(vc.fk_idcliente = 0,
                        (SELECT nombre_cliente FROM vision_prospectos WHERE fk_cotizacion = vc.id),
                        (SELECT nombre_corto FROM vision_clientes WHERE id_cliente = vc.fk_idcliente)) cliente,
                      total
                FROM vision_cotizacion vc";
      // echo $query;
      // exit();

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionClientes(){
      $query = "SELECT id_cliente idCliente,
                        nombre_corto nombreCorto,
                        rfc,
                        correo_factura correo
                FROM vision_clientes;";

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionAprobadas(){
      $query = "SELECT vc.id idCotiz,
                      DATE(vc.fecha) fecha,
                      vc.estatus,
                      vcl.nombre_corto cliente,
                      total
                FROM vision_cotizacion vc
                INNER JOIN vision_clientes vcl ON vcl.id_cliente = vc.fk_idcliente
                WHERE estatus = 1";

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionPendientes(){
      $query = "SELECT vc.id idCotiz,
                      DATE(vc.fecha) fecha,
                      vc.estatus,
                      vp.nombre_cliente cliente,
                      vc.total
                FROM vision_cotizacion vc
                INNER JOIN vision_prospectos vp ON vp.fk_cotizacion = vc.id
                WHERE estatus = 0";

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionProspectos(){
      $query = "SELECT vp.nombre_cliente, vp.telefono, vp.correo, vp.fk_cotizacion idCotiz, vc.total
                FROM vision_prospectos vp
                INNER JOIN vision_cotizacion vc ON vc.id = vp.fk_cotizacion;";

                // $query = "SELECT DATABASE();";
                // $query = "show databases";

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionMateriasAprobadas(){
      $query = "SELECT CONCAT(vcmp.cantidad,vmp.unidad_medida) cantidad, vcmp.fk_cotizacion idCotiz, vmp.descripcion materia, vmp.clave
                FROM vision_cotizacion_matprim vcmp
                INNER JOIN vision_cotizacion vc ON vc.id = vcmp.fk_cotizacion
                INNER JOIN vision_materiaprima vmp ON vmp.id = vcmp.fk_matprim
                WHERE vc.estatus = 1";

      // echo $query;
      // exit();

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionProductosAprobados(){
      $query = "SELECT vcp.cantidad, vcp.fk_cotizacion idCotiz, vp.descripcion, vp.nombre
                FROM vision_cotizacion_productos vcp
                INNER JOIN vision_cotizacion vc ON vc.id = vcp.fk_cotizacion
                INNER JOIN vision_productos vp ON vp.id = vcp.fk_productos
                WHERE vc.estatus = 1";

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionProductosPendientes(){
      $query = "SELECT vcp.cantidad, vcp.fk_cotizacion idCotiz, vp.descripcion, vp.nombre, vcp.costo, vp.id idProd
                FROM vision_cotizacion_productos vcp
                INNER JOIN vision_cotizacion vc ON vc.id = vcp.fk_cotizacion
                INNER JOIN vision_productos vp ON vp.id = vcp.fk_productos
                WHERE vc.estatus = 0";

      $result = $this->link->query($query);

      return query2json($result);
    }

    function traerVisionProductosCotizacion(){
      $query = "SELECT vcp.cantidad, vcp.fk_cotizacion idCotiz, vcp.costo, vp.nombre, vp.descripcion, vp.id, vp.clave
                FROM vision_cotizacion_productos vcp
                INNER JOIN vision_productos vp ON vp.id=vcp.fk_productos;";
      // echo $query;
      // exit();

      $result = $this->link->query($query);

      return query2json($result);
    }

    function enviarCorreoPdfCotizacion($idCotiz){
      // error_log("holi1");
      // include_once("../vendor/lib_mail/class.phpmailer.php");
      include("../vendor/lib_mail/class.phpmailer.php");
      // include_once("../vendor/lib_mail/class.smtp.php");
      include("../vendor/lib_mail/class.smtp.php");
      // error_log("holi2");

      $verifica = 0;

      $query = "SELECT 
                    IF(vc.fk_idcliente = 0,
                    (SELECT correo FROM vision_prospectos WHERE fk_cotizacion = vc.id),
                    (SELECT correo_factura FROM vision_clientes WHERE id_cliente = vc.fk_idcliente)) correo
                FROM vision_cotizacion vc
                WHERE id = $idCotiz;";
      // error_log( $query);
      // exit();

      $result = $this->link->query($query);

      if($result){
          $datos=mysqli_fetch_array($result);

          if(isset($datos['correo']) && $datos['correo'] != ''){
              $correo = $datos['correo'];

              error_log($correo);

              $mail = new PHPMailer();
              $mail->CharSet = 'UTF-8';
              $mail->IsSMTP();
              $mail->IsHTML(true);	
              // $mail->SMTPSecure = "STARTTLS";
              $mail->SMTPSecure = "ssl";
              $mail->SMTPAuth = true;
              // $mail->Host = "smtp.gmail.com";
              // $mail->Port = 587;
              // $mail->Username = "ginthercorp.info@gmail.com"; 
              // $mail->Password = "secorp2022";
              $mail->Host = "mail.ginthercorp.com";
              $mail->Port = 465;
              $mail->Username = "facturas@ginthercorp.com"; 
              $mail->Password = "secorp2022";


              $mail->SetFrom("facturas@ginthercorp.com","FACTURACIÓN");
              // $mail->From = "test@curiel.com";
              // $mail->FromName = "TEST2CURIEL";

              $mail->Subject = "Cotización Visión";
              $mail->MsgHTML("Cotización Visión");
              $mail->AddAddress($correo, "Contacto");	

              $rutaCompleta = '../vision/cotizaciones/vision_cotiz_'.$idCotiz.'.pdf';

              $mail->AddAttachment($rutaCompleta);

              $verifica = false;

              if(!$mail->Send()){
                $verifica = 0; //Intento Fallido;
                error_log($mail->ErrorInfo);
              }else{
                $verifica = 1; //exito
              }
          }
      }

      return $verifica;
    }
    
}//--fin de class ValesGasolina
    
?>