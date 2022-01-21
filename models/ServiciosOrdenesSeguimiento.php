<?php

include 'conectar.php';

class ServiciosOrdenesSeguimiento
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function ServiciosOrdenesSeguimiento()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una linea
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una linea
      * @param varchar $nombre es el nombre asignado a una linea
      * @param varchar $descripcion brebe descripcion de una linea
      * @param int $idFamilia  id de la familia a la que se va asignar
      * @param int $inactiva estatus de una linea 0='Activa' 1='Inactiva'  
      *
      **/      
    function guardarCierreOrdenes($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos,$idTecnico,$tecnico){
    
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos,$idTecnico,$tecnico);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarOrdenesServicios


     /**
      * Guarda los datos de una linea, regresa el id de la linea afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una linea
      * @param varchar $nombre es el nombre asignado a una linea
      * @param varchar $descripcion brebe descripcion de una linea
      * @param int $idFamilia  id de la familia a la que se va asignar
      * @param int $inactiva estatus de una linea 0='Activa' 1='Inactiva'  
      *
      **/ 
      function guardarActualizar($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos,$idTecnico,$tecnico){
          
        $verifica = 0;

        $query = "UPDATE servicios_ordenes SET proceso='".$proceso."',acciones_realizadas='".$accionesRealizadas."', estatus_cierre=1, fecha_cierre=NOW(), id_tecnico='$idTecnico', tecnico='$tecnico' WHERE id=".$idOrdenServicio;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        //if ($result) 
        //   $verifica = $this -> enviarCorreoCierre($idOrdenServicio,$servicio,$accionesRealizadas,$correos);
    
        return $idOrdenServicio;
    }

    
    /**
      * Busca los datos de una linea, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=inactivas 2=todos
      *
      **///--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
      function buscarServiciosOrdenesSeguimiento($semana,$idSucursal){

        $condFecha = '';
        $condicionC = '';
        if($semana=='menos'){
            //$condFecha=" AND a.fecha_servicio BETWEEN (DATE_SUB(CURRENT_DATE(),INTERVAL 7 DAY)) AND CURDATE() ";
            
            //-->NJES Jan/27/2020 Las de menos una semana son donde la fecha servicio este entre mañana y  los proximos 8 días
            $condFecha=" AND DATE(a.fecha_servicio) BETWEEN DATE_ADD(CURRENT_DATE(),INTERVAL 1 DAY) AND DATE_ADD(CURRENT_DATE(),INTERVAL 7 DAY) ";
            $orden="  ORDER BY a.fecha_servicio ASC";
        }else if($semana=='mas'){
            //$condFecha=" AND a.fecha_servicio > DATE_SUB(CURRENT_DATE(),INTERVAL -7 DAY) ";
            
            //-->NJES Jan/27/2020 Las de mas de una semana en donde la fecha servicio sea mayor a las proximos 7 días
            $condFecha=" AND a.fecha_servicio > DATE_ADD(CURRENT_DATE(),INTERVAL 7 DAY) ";
            $condicionC = " HAVING diferencia < 48";
            $orden="  ORDER BY a.fecha_servicio ASC";
        }else if($semana=='sin_atender') //--> NJES Jan/24/2020 Las ordenes de servicio que no he atendido y las que tengo que atender en el día
        {
            $condFecha=" AND a.fecha_servicio <= CURRENT_DATE() AND a.estatus_orden!='C' ";
            $orden="  ORDER BY a.fecha_servicio DESC";
        }else{
            $condFecha=" AND (IF(a.fecha_pendiente='0000-00-00 00:00:00',0,TIMESTAMPDIFF(HOUR,a.fecha_pendiente,NOW())) > 48
            OR IF(a.fecha_cancelacion='0000-00-00 00:00:00',0,TIMESTAMPDIFF(HOUR,a.fecha_cancelacion,NOW())) > 48)";
            $orden="  ORDER BY a.fecha_servicio DESC";    
        }

        if($idSucursal != '')  //-->No tengo sucursales con permisos en la unidad entonces debo regresar un array vacio
        {
            if($idSucursal[0] == ',')
            {
                $dato=substr($idSucursal,1);
                $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
                $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }
        }  

        $resultado = $this->link->query("SELECT 
        a.id,
        a.fecha_servicio,
        a.fecha_captura,
        IF(a.estatus_orden='A','SIN REVISAR',IF(a.estatus_orden='P','PENDIENTE','CANCELADA')) AS estatus,
        IF(a.prioridad=1,'BAJA',IF(a.prioridad=2,'MEDIA','ALTA'))AS prioridad,
        b.nombre_corto AS  cliente,
        IFNULL(b.razon_social,'') AS razon_social,
        c.descripcion AS tipo_servicio,
        IF(a.fecha_cancelacion='0000-00-00 00:00:00',0,TIMESTAMPDIFF(HOUR,a.fecha_cancelacion,NOW())) AS diferencia,
        d.usuario,
        d.nombre_comp AS nombre,
        IFNULL(s.descr,'') AS sucursal
        FROM servicios_ordenes a
        LEFT JOIN servicios b ON a.id_servicio=b.id
        LEFT JOIN servicios_clasificacion c ON a.id_clasificacion_servicio=c.id
        LEFT JOIN usuarios d ON a.id_usuario_captura= d.id_usuario
        LEFT JOIN sucursales s ON a.id_sucursal=s.id_sucursal
        WHERE a.estatus_cierre=0 $sucursal $condFecha
        $condicionC
        $orden");
        return query2json($resultado);

      }//- fin function buscarOrdenesServicios
    
      //--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
      function buscarServiciosOrdenesSeguimientoId($idOrdenServicio){

        $resultado = $this->link->query("SELECT 
        a.id,
        a.id_sucursal,
        a.id_servicio,
        a.reporta,
        a.servicio,
        a.descripcion,
        a.proceso,
        a.acciones_realizadas,
        a.prioridad,
        a.id_clasificacion_servicio,
        a.fecha_servicio,
        IF(a.fecha_solicitud='0000-00-00','',a.fecha_solicitud) AS fecha_solicitud,
        a.fecha_captura,
        a.estatus_cierre,
        a.estatus_orden,
        a.justificacion_cancelacion,
        a.sin_cobro,
        a.tecnico,
        a.fecha_atencion,
        b.nombre_corto  AS cliente,
        IFNULL(b.razon_social,'') AS razon_social,
        IFNULL(b.correos,'') as correos,
        b.porcentaje_iva,
        c.cantidad,
        IFNULL(d.id,0) AS id_cxc,
        IFNULL(d.id_factura,0) AS id_factura,
        d.referencia,
        d.subtotal,
        d.iva,
        d.total,
        d.id_factura,
        d.concepto_cobro
        FROM servicios_ordenes a
        LEFT JOIN servicios b ON a.id_servicio=b.id
        LEFT JOIN servicios_clasificacion c ON a.id_clasificacion_servicio=c.id
        LEFT JOIN cxc d ON a.id=d.id_orden_servicio AND d.estatus!='C'
        WHERE a.id=$idOrdenServicio");
        return query2json($resultado);
          

      }//- fin function buscarOrdenesServiciosId


      /** 
      * 
      *Envia correo con formato de la cotizacion aprobada
      *
      **/
    function enviarCorreoCierre($idOrdenServicio,$servicio,$accionesRealizadas,$correos){
     
        include_once("../vendor/lib_mail/class.phpmailer.php");
        include_once("../vendor/lib_mail/class.smtp.php");
      
        $verifica = 0;

        $destinatarios = explode(',',$correos);
  
        $asunto ="ORDEN DE SERVICIO CERRADA";
  
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP();
        $mail->IsHTML(true);	
        $mail->SMTPSecure = "TLS";
        $mail->SMTPAuth = true;
        
        $mail->Host = "ginthersoft.com";
        $mail->Port = 26;
        $mail->Username = "no-reply@secorp.mx";
        $mail->Password = "secorp.01";	
        $mail->SetFrom("no-reply@secorp.mx","Orden de Servicio");

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->SMTPDebug = 2;
        
        $mail->Subject = $asunto;
  
        $mensaje = '<html><body>';
        $mensaje .= '<h3>Cierre de Orden de Servicio con ID: '.$idOrdenServicio.'</h3>';
        $mensaje .= '<h4>Servicio:</h4><br>';
        $mensaje .= $servicio.'<br>';
        $mensaje .= '<h4>Acciones realizadas:</h4><br>';
        $mensaje .= $accionesRealizadas.'<br><br>';
        $mensaje .= 'Nos gustaría que evaluara nuestro servicio: http://localhost/ginthercorp/encuestas/encuesta/index.php?id='.$idOrdenServicio;
        $mensaje .= '<h3>¡Saludos cordiales!</h3>';
        $mensaje .= '</body></html>';
  
        //$archivo='../cotizaciones/cotizacion_'.$idCotizacion.'.pdf';
        
        //$mail->AddAttachment($archivo,'cotizacion_'.$idCotizacion.'.pdf');
       
        $mail->MsgHTML($mensaje);
  
        for($i = 0; $i < count($destinatarios); $i++)
        {
            $mail->AddAddress($destinatarios[$i], "Orden de Servicio Secorp Alarmas");	
        }
  
        
        if(!$mail->Send())
        { 
            //-->Fallo
            $verifica = 0;
        }else{
            //-->Exito
            $verifica = $idOrdenServicio;
        }
  
        return $verifica;
      }//--fin function enviarCorreo


    function guardarCancelacionOrdenes($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos,$justificacion){
    
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $query = "UPDATE servicios_ordenes SET proceso='".$proceso."',acciones_realizadas='".$accionesRealizadas."', estatus_orden='C', justificacion_cancelacion='$justificacion', fecha_cancelacion=now() WHERE id=".$idOrdenServicio;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) 
           $verifica = $idOrdenServicio;
    
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarOrdenesServicios


    function guardarSeguimientoOrdenes($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos,$idTecnico,$tecnico){

        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $query = "UPDATE servicios_ordenes SET proceso='".$proceso."',acciones_realizadas='".$accionesRealizadas."', estatus_orden='P', fecha_pendiente=NOW(), id_tecnico='$idTecnico', tecnico='$tecnico' WHERE id=".$idOrdenServicio;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) 
          $verifica = $idOrdenServicio;
    
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarOrdenesServicios


    function guardarSinCobrarOrdenes($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos,$sinCobro){
    
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $query = "UPDATE servicios_ordenes SET proceso='".$proceso."',acciones_realizadas='".$accionesRealizadas."', sin_cobro='$sinCobro' WHERE id=".$idOrdenServicio;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) 
           $verifica = $idOrdenServicio;
    
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarOrdenesServicios


    /**
      * Busca los datos para el reporte de seguimiento de ordenes de servicio, retorna un JSON con los datos correspondientes
      * 
      **/
      function buscarReporteSeguimiento($fechaInicio,$fechaFin,$idsSucursales){

        //$dato=substr($idsSucursales,1);
        //$condicionSucursales='WHERE a.id_sucursal in ('.$dato.')';
        
        //-->NJES October/21/2020 se agrega filtro sucursal, si solo tiene permiso a una sucursal
        //se pone por default en el combo y comienza la busqueda, de inicio busca de todas las sucursales a las que tiene permiso.
        if($idsSucursales[0] == ',')
        {
            $dato=substr($idsSucursales,1);
            $condicionSucursales='WHERE a.id_sucursal IN ('.$dato.')';
        }else{ 
            $condicionSucursales='WHERE a.id_sucursal ='.$idsSucursales;
        }

        $condFecha = '';

        if($fechaInicio == '' && $fechaFin == '')
        {
            $condFecha=" AND a.fecha_captura >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condFecha=" AND  a.fecha_captura >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
            $condFecha=" AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }
        

        $resultado = $this->link->query("SELECT 
        a.id AS folio,
        a.servicio,
        a.descripcion,
        a.id_tecnico,
        a.tecnico,
        IF(a.fecha_atencion='0000-00-00','',a.fecha_atencion) AS fecha_atencion,
        if(a.hora_llegada='00:00:00','',a.hora_llegada) as hora_llegada,
        a.gps_llegada,
        if(a.hora_salida='00:00:00','',a.hora_salida) as hora_salida,
        a.gps_salida,
        c.descr AS sucursal
        FROM servicios_ordenes a
        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
        $condicionSucursales $condFecha
        ORDER BY a.fecha_captura DESC");
        return query2json($resultado);

      }//- fin function buscarOrdenesServicios



      /**
      * Manda llamar a la funcion que guarda la fecha de atencion de un servicio
      * 
      * @param int $idOrden id de la orden que se esta cerrando y se solicita la fecha de atencion
      * @param date $fechaAntencion fecha ingresada
      *
      **/      
    function guardarFechaAtencion($idOrdenServicio,$fechaAtencion){
    
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $query = "UPDATE servicios_ordenes SET fecha_atencion='$fechaAtencion' WHERE id=".$idOrdenServicio;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if ($result) 
           $verifica = $idOrdenServicio;
    
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarOrdenesServicios

    
}//--fin de class OrdenesServicios
    
?>