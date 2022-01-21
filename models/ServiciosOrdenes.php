<?php

include 'conectar.php';

class ServiciosOrdenes
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function ServiciosOrdenes()
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
    function guardarServiciosOrdenes($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

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
      function guardarActualizar($datos){
          
        $verifica = 0;
      
        $tipoMov = $datos[1]['tipoMov'];
        $idOrdenServicio = $datos[1]['idOrdenServicio'];
        $idSucursal = $datos[1]['idSucursal'];
        $idServicio = $datos[1]['idServicio'];
        $reporta = $datos[1]['reporta'];
        $servicio = $datos[1]['servicio'];
        $descripcion = $datos[1]['descripcion'];
        $prioridad = $datos[1]['prioridad'];
        $idClasificacionServicio = $datos[1]['idClasificacionServicio'];
        $fechaProgramada = $datos[1]['fechaProgramada'];
        $fechaSolicitud = $datos[1]['fechaSolicitud'];
        $idUsuario = $datos[1]['idUsuario'];

        if($tipoMov==0){

          $query = "INSERT INTO servicios_ordenes(id_sucursal,id_servicio,reporta,servicio,descripcion,prioridad,id_clasificacion_servicio,fecha_servicio,id_usuario_captura,fecha_solicitud) 
          VALUES ('$idSucursal','$idServicio','$reporta','$servicio','$descripcion','$prioridad','$idClasificacionServicio','$fechaProgramada','$idUsuario','$fechaSolicitud')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idOrdenServicio = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE servicios_ordenes SET id_sucursal='$idSucursal',id_servicio='$idServicio',reporta='$reporta',servicio='$servicio',descripcion='$descripcion', prioridad='$prioridad', id_clasificacion_servicio='$idClasificacionServicio', fecha_servicio='$fechaProgramada', id_usuario_captura='$idUsuario',fecha_solicitud='$fechaSolicitud' WHERE id=".$idOrdenServicio;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idOrdenServicio;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una linea, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=inactivas 2=todos
      *
      **///--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
      function buscarServiciosOrdenes($fechaInicio,$fechaFin,$idSucursal){

        $condFecha = '';

        if($fechaInicio == '' && $fechaFin == '')
        {
            $condFecha=" AND a.fecha_servicio >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
            $condFecha=" AND a.fecha_servicio >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
            $condFecha=" AND DATE(a.fecha_servicio) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }

        //-->NJES November/11/2020 agregar filtro sucursales
        if($idSucursal != '') 
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
        a.id_sucursal,
        a.servicio,
        a.descripcion,
        a.fecha_servicio,
        a.fecha_captura,
        IF(a.prioridad=1,'BAJA',IF(a.prioridad=2,'MEDIA','ALTA'))AS prioridad,
        IF(a.estatus_cierre=1,'CERRADA',IF(a.estatus_orden='A','ABIERTA',IF(a.estatus_orden='P','PENDIENTE','CANCELADA'))) AS estatus,
        IFNULL(b.razon_social,'') AS razon_social,
        b.nombre_corto AS cliente,
        c.descr as sucursal,
        d.usuario,
        d.nombre_comp
        FROM servicios_ordenes a
        LEFT JOIN servicios b ON a.id_servicio=b.id
        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
        LEFT JOIN usuarios d ON a.id_usuario_captura= d.id_usuario
        WHERE 1 $sucursal $condFecha
        ORDER BY a.fecha_servicio DESC");
        return query2json($resultado);

      }//- fin function buscarOrdenesServicios
      //--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
      function buscarServiciosOrdenesP($params)
      {

        $where = "";

        foreach ($params as $key => $value)
        {
          
          $where .= " AND $key = $value";

        }

        $resultado = $this->link->query("SELECT
          servicios_ordenes.id AS id,
          servicios_ordenes.id_sucursal AS id_sucursal,
          servicios_ordenes.id_servicio AS id_servicio,
          servicios_ordenes.servicio AS servicio,
          servicios_ordenes.descripcion AS descripcion, 
          servicios_ordenes.prioridad AS prioridad,
          servicios_ordenes.fecha_servicio AS fecha,
          servicios.nombre_corto AS n_corto,
          IFNULL(servicios.razon_social,'') AS razon_social,
          usuarios.usuario,
          usuarios.nombre_comp
          FROM
          servicios_ordenes
          INNER JOIN servicios ON servicios_ordenes.id_servicio = servicios.id
          LEFT JOIN usuarios  ON servicios.id_usuario_captura= usuarios.id_usuario
          WHERE 1
          $where
          ORDER BY servicios_ordenes.id DESC");


          return query2json($resultado);

      }

      function obtenerVisita($idOrdenServicio)
      {

        $verifica = 0;
          
        $result = mysqli_query($this->link, " SELECT  id, fecha_salida FROM visitas_tecnicas WHERE id_orden_servicio = $idOrdenServicio ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc($result);

        if($row['fecha_salida'] == null && $row['id'] != null)
          $verifica = $row['id'];

        return $verifica;

      }

      function buscarVisitas($idOrdenServicio)
      {

        $resultado = $this->link->query("SELECT * FROM visitas_tecnicas INNER JOIN usuarios ON visitas_tecnicas.id_usuario = usuarios.id_usuario WHERE id_orden_servicio = $idOrdenServicio ORDER BY id DESC");
        return query2json($resultado);

      }

      function cerrarVisita($idVisita, $latitud, $longitud, $location, $obs)
      {

        $verifica = false;

        $fecha =  date('Y-m-d H:m:s');

        $query = "UPDATE visitas_tecnicas SET latitud_salida = '$latitud', longitud_salida = '$longitud', ubicacion_salida = '$location', fecha_salida = '$fecha', anotaciones = '$obs' WHERE id = $idVisita";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
          $verifica = true;

        return $verifica;

      }

      function guardarVisita($idOrdenServicio, $latitud, $longitud, $location, $idUsuario,$observaciones)
      {

        $verifica = false;

        //-->NJES Sep/28/2020 Al registrar la visita, únicamente guardar una fecha-hora, latitud, longitud, ubicación y observaciones (solo la visita, la salida no)
        //$fecha =  date('Y-m-d H:m:s');

        //$anterior = $this->obtenerVisita($idOrdenServicio);
        //if($anterior > 0)
         //$resultII = mysqli_query($this->link, "UPDATE visitas_tecnicas SET fecha_salida = '$fecha', anotaciones = 'NA' WHERE id = $anterior") or die(mysqli_error());

        $query = "INSERT INTO visitas_tecnicas(id_orden_servicio, latitud_llegada, longitud_llegada, ubicacion_llegada, fecha_llegada, id_usuario,observaciones)  
                  VALUES ($idOrdenServicio, '$latitud', '$longitud', '$location', '$fecha', $idUsuario,'$observaciones')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        

        if($result)
          $verifica = true;

        return  $verifica;

      }
      //--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
      function buscarServiciosOrdenesId($idOrdenServicio){

        $resultado = $this->link->query("SELECT 
        a.id,
        a.id_sucursal,
        a.id_servicio,
        a.reporta,
        a.servicio,
        a.estatus_cierre,
        a.estatus_orden,
        a.descripcion,
        a.proceso,
        a.acciones_realizadas,
        a.prioridad,
        a.id_clasificacion_servicio,
        a.fecha_servicio,
        a.fecha_captura,
        if(a.fecha_solicitud = '0000-00-00','',a.fecha_solicitud) AS fecha_solicitud,
        IFNULL(b.razon_social,'') AS razon_social,
        b.nombre_corto as cliente,
        b.cuenta,
        c.total,
        c.subtotal,
        d.usuario,
        d.nombre_comp as nombre,
        c.concepto_cobro
        FROM servicios_ordenes a
        LEFT JOIN servicios b ON a.id_servicio=b.id
        LEFT JOIN cxc c ON a.id=c.id_orden_servicio AND c.estatus NOT IN('C','P')
        LEFT JOIN usuarios d ON a.id_usuario_captura= d.id_usuario
        WHERE a.id=$idOrdenServicio");
        return query2json($resultado);
          

      }//- fin function buscarOrdenesServiciosId


      /**
      * Busca los datos para el reporte de ordenes de servicio, retorna un JSON con los datos correspondientes
      * 
      **/  //--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
      function buscarReporteServiciosOrdenes($fechaInicio,$fechaFin,$idsSucursales){

        //-->NJES October/21/2020 se agrega filtro sucursal, si solo tiene permiso a una sucursal
        //se pone por default en el combo y comienza la busqueda, de inicio busca de todas las sucursales a las que tiene permiso.
        if($idsSucursales[0] == ',')
        {
            $dato=substr($idsSucursales,1);
            $condicionSucursales='WHERE a.id_sucursal IN ('.$dato.')';
        }else{ 
            $condicionSucursales='WHERE a.id_sucursal ='.$idsSucursales;
        }
       
        //$dato=substr($idsSucursales,1);
        //$condicionSucursales='WHERE a.id_sucursal in ('.$dato.')';

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
        a.fecha_solicitud,
        a.fecha_captura,
        a.fecha_servicio,
        IF(a.fecha_pendiente='0000-00-00 00:00:00','',a.fecha_pendiente)AS fecha_seguimiento,
        IF(a.fecha_cierre='0000-00-00 00:00:00','',a.fecha_cierre)AS fecha_cierre,
        IF(a.fecha_cancelacion='0000-00-00 00:00:00','',a.fecha_cancelacion)AS fecha_cancelacion,
        IF(a.estatus_orden='A','GENERADA',IF(a.estatus_orden='P','PENDIENTE','CANCELADA')) AS estatus_orden,
        IF(a.estatus_cierre=0,'PENDIENTE','CERRADA') AS estatus_cierre,
        a.acciones_realizadas,
        b.cuenta,
        b.nombre_corto,
        IFNULL(b.razon_social,'') AS razon_social,
        c.descr AS sucursal,
        d.usuario,
        d.nombre_comp as nombre,
        h.descripcion AS clasificacion_servicio,
        IF(a.sin_cobro = 0 && IFNULL(cxc.id_orden_servicio,0) > 0,'Con cobro','Sin cobro') AS estatus_cobro,
        IFNULL(IF(a.sin_cobro = 0,cxc.total,''),'') AS monto
        FROM servicios_ordenes a
        LEFT JOIN servicios b ON a.id_servicio=b.id
        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
        LEFT JOIN usuarios d ON a.id_usuario_captura= d.id_usuario
        LEFT JOIN servicios_clasificacion h ON a.id_clasificacion_servicio=h.id
        LEFT JOIN cxc ON a.id=cxc.id_orden_servicio
        $condicionSucursales $condFecha
        ORDER BY a.fecha_captura DESC");
        return query2json($resultado);

      }//- fin function buscarOrdenesServicios


    
}//--fin de class OrdenesServicios
    
?>