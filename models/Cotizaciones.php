<?php

include 'conectar.php';

class Cotizaciones
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Cotizaciones()
    {
  
      $this->link = Conectarse();

    }

    public $mensajeGlobalAC='';

    /**
      *Busca el ultimo registro de los correos electronicos al cual se envio la cotización de la sucursal seleccionada
      *
      * @param int $idUnidadNegocio seleccionada
      * @param int $idSucursal seleccionada
      * 
      **/
    function buscarCotizacionesCorreos($idUnidadNegocio,$idSucursal){
        $result = $this->link->query("SELECT id,id_sucursal,correos 
                                          FROM correos 
                                          WHERE id_unidad_negocio=".$idUnidadNegocio." AND id_sucursal=".$idSucursal."
                                          ORDER BY correos");

        return query2json($result);
    }//-- fin function buscarCotizacionesCorreos

    /**
      *Busca los clientes en la tabla pre_clientes
      * 
      **/
    function buscarCotizacionesClientes(){
        $result = $this->link->query("SELECT id,nombre
                                          FROM pre_clientes
                                          ORDER BY nombre");

        return query2json($result);
    }//-- fin function buscarCotizacionesClientes

    /**
      *Busca los datos del cliente especificado
      *
      * @param varchar $nombreCliente para buscar datos
      * 
      **/
    function buscarCotizacionesClientesId($nombreCliente){
        $result = $this->link->query("SELECT id,nombre_comercial,nombre,dirigido,razon_social,telefono,email,calle,num_exterior,num_interior,codigo_postal,colonia,id_municipio,id_estado,id_pais,rfc,representante_legal,contacto 
                                          FROM pre_clientes 
                                          WHERE nombre='$nombreCliente'");

        return query2json($result);
    }//-- fin function buscarCotizacionesClientesId

    /**
      *Verifica no se registren mas de un proyecto con el mismo nombre
      *
      * @param varchar $nombreProyecto nombre del proyecto
      * 
      **/
    function verificarCotizacionesProyecto($nombreProyecto){
        $verifica = 0;

        $query = "SELECT id FROM proyecto WHERE descripcion='$nombreProyecto'";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
            $verifica = 1;

        return $verifica;
    }//-- fin function verificarCotizacionesProyecto

    /**
      * Manda llamar a la funcion que guarda la informacion 
      *
      * @param varchar $datos array que contiene las parametros a guardar
      * 
      **/
    function guardarCotizacionesProyecto($datos){
        $verifica = 0;
    
       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizarProyecto($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }//-- fin function guardarCotizacionesProyectos

     /**
      * Guarda los datos de un proyecto, regresa el id del proyecto afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param varchar $datos es un array que contiene los parametros
      * $nombreProyecto nombre del proyecto a insertar
      * $idUnidadNegocio --> id_de la unidad de negocio a la que pertenece el registro
      * $idSucursal --> id_de la sucursal a la que pertenece el registro
      * $usuario --> nombre del usuario session que guarda registro
      * $idUsuario --> id del usuario session que guarda registro
      *
      **/ 
      function guardarActualizarProyecto($datos){
  
          $verifica = 0;

          $nombreProyecto = $datos['nombreProyecto'];
          $idUnidadNegocio = $datos['idUnidadNegocio'];
          $idSucursal = $datos['idSucursal'];
          $usuario = $datos['usuario'];
          $idUsuario = $datos['idUsuario'];
        
          $query = "INSERT INTO proyecto(descripcion,estatus,id_sucursal,usuario_captura,id_usuario,id_unidad_negocio) 
					              VALUES ('$nombreProyecto',1,'$idSucursal','$usuario','$idUsuario','$idUnidadNegocio')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id_registro = mysqli_insert_id($this->link);

          if ($result) {
              $verifica = $id_registro;
          }else{
              $verifica = 0;
          }
        
        return $verifica;
    }//--fin function guardarActualizar

    /**
      *Verifica si se guardara una nueva cotizacion o se va a editar alguna
      *
      * @param varchar $nombreCotizacion nombre de la cotizacion
      * 
      **/
    function verificarCotizaciones($nombreCotizacion){
        $verifica = 0;

        $query = "SELECT id FROM cotizacion WHERE nombre ='$nombreCotizacion'";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
            $verifica = 1;

        return $verifica;
    }//--fin function guardarActualizar

    /**
      * Manda llamar a la funcion que guarda la informacion
      *
      * @param varchar $datos es un array que contiene los parametros
      * 
      **/
    function guardarCotizaciones($datos){
        $verifica = 0;
  
       $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");
  
        $verifica = $this -> guardarActualizar($datos);
  
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
  
        return $verifica;
    }//--fin function guardarCotizaciones

    /**
      * Guarda los datos de una cotizacion, regresa el id de la sucursal afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param varchar $datos es un array que contiene los parametros
      * idCotizacion
      * usuario
      * idUsuario
      * idProyecto
      * nombreCotizacion
      * fecha_inicio_facturacion
      * periodicidad
      * tipo_facturacion
      * dia
      * id_firmante
      * razon_social_emisora
      * firma_digital
      * texto_inicio
      * texto_fin
      * observaciones_generales
      * tipo   (editar=update nueva=insertar nueva cotizacion)
        *-->datos cliente
      * nombre_comercial
      * cliente
      * dirigido
      * razon_social_cliente
      * telefono
      * email
      * calle
      * num_exterior
      * num_interior
      * colonia
      * codigo_postal
      * rfc
      * representante_legal
      * contacto
      * id_pais
      * id_estado
      * id_municipio
      * idCliente
      *
      **/ 
    function guardarActualizar($datos){
  
        $verifica = 0;
        
        $idCliente = $datos['idCliente'];
        $cliente = $datos['cliente'];

        $busca_cliente="SELECT id FROM pre_clientes WHERE nombre='$cliente'";
        $result_busca_cliente = mysqli_query($this->link,$busca_cliente) or die(mysqli_error());

        $num = mysqli_num_rows($result_busca_cliente);

        if($num > 0)
        {
            $row=mysqli_fetch_array($result_busca_cliente);
            $id_cliente=$row['id'];
            $tipoMovCliente = 1;

            $verifica = $this -> guardarClientes($id_cliente,$tipoMovCliente,$datos);
        }else{

            $tipoMovCliente = 0;
            $verifica = $this -> guardarClientes($idCliente,$tipoMovCliente,$datos);
        }

        return $verifica;
    }//--fin function guardarActualizar

    /**
      * Guarda/Edita una clientes
      *
      * @param int $idCliente id del registro si se va a actualizar
      * @param int $tipoMovCliente 1=actualizar, 0=insertar nuevo
      * @param varchar $datos es un array que contiene los parametros
      * 
      **/  
    function guardarClientes($idCliente,$tipoMovCliente,$datos){
        $tipoMovCliente = $tipoMovCliente;  
        $idCliente = $idCliente;
        $nombre_comercial = $datos['nombre_comercial'];
        $cliente = $datos['cliente'];
        $dirigido = $datos['dirigido'];
        $razon_social_cliente = $datos['razon_social_cliente'];
        $telefono = $datos['telefono'];
        $email = $datos['email'];
        $calle = $datos['calle'];
        $num_exterior = $datos['num_exterior'];
        $num_interior = $datos['num_interior'];
        $colonia = $datos['colonia'];
        $codigo_postal = $datos['codigo_postal'];
        $rfc = $datos['rfc'];
        $representante_legal = $datos['representante_legal'];
        $contacto = $datos['contacto'];
        $id_pais = $datos['id_pais'];
        $id_estado = $datos['id_estado'];
        $id_municipio = $datos['id_municipio'];

        if($tipoMovCliente == 0)
        {
            $query_cliente = "INSERT INTO pre_clientes(nombre_comercial,nombre,dirigido,razon_social,telefono,email,calle,num_exterior,num_interior,codigo_postal,colonia,id_municipio,id_estado,id_pais,rfc,representante_legal,contacto) 
                                    VALUES ('$nombre_comercial','$cliente','$dirigido','$razon_social_cliente','$telefono','$email','$calle','$num_exterior','$num_interior','$codigo_postal','$colonia','$id_municipio','$id_estado','$id_pais','$rfc','$representante_legal','$contacto')";
            $result_cliente = mysqli_query($this->link,$query_cliente) or die(mysqli_error());
            $id_cliente=mysqli_insert_id($this->link);
            
            if ($result_cliente)
            {
                $verifica = $this -> guardarCotizacion($id_cliente,$datos);
            }else{
                $verifica = 0;
            }

        }else{
            $query_cliente="UPDATE pre_clientes SET 
                                nombre_comercial='$nombre_comercial', 
                                nombre='$cliente',
                                dirigido='$dirigido',
                                razon_social='$razon_social_cliente',
                                telefono='$telefono',
                                email='$email',
                                calle='$calle',
                                num_exterior='$num_exterior',
                                num_interior='$num_interior',
                                codigo_postal='$codigo_postal',
                                colonia='$colonia',
                                id_municipio='$id_municipio',
                                id_estado='$id_estado',
                                id_pais='$id_pais',
                                rfc='$rfc',
                                representante_legal='$representante_legal',
                                contacto='$contacto'
                                WHERE id=".$idCliente;
            $result_cliente=mysqli_query($this->link,$query_cliente) or die(mysqli_error());

            if ($result_cliente)
            {
                $verifica = $this -> guardarCotizacion($idCliente,$datos);
            }else{
                $verifica = 0;
            }
        }

        return $verifica;

    }//--fin function guardarClientes

    /**
      * Guarda/Edita una cotización
      *
      * @param int $idCliente que se va a insertar o actualizar en la cotizacion
      * @param varchar $datos es un array que contiene los parametros
      * 
      **/ 
    function guardarCotizacion($idCliente,$datos){
        $idCliente = $idCliente;
        $tipo = $datos['tipo'];
        $idCotizacion = $datos['idCotizacion'];
        $folio= $datos['folio'];
        $usuario = $datos['usuario'];
        $idUsuario = $datos['idUsuario'];
        $idProyecto = $datos['idProyecto'];
        $nombreCotizacion = $datos['nombreCotizacion'];
        $id_firmante = $datos['id_firmante'];
        $firma_digital = $datos['firma_digital'];
        $texto_inicio = $datos['texto_inicio'];
        $texto_fin = $datos['texto_fin'];
        $observaciones_generales = $datos['observaciones_generales'];
        $observaciones_internas = $datos['observaciones_internas'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];

        if($tipo == 'nueva')
        {
          $queryFolio="SELECT folio_cotizacion FROM cat_unidades_negocio WHERE id=".$idUnidadNegocio;
          $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
          if($resultF){
            $dato_folio=mysqli_fetch_array($resultF);
            $folioA=$dato_folio['folio_cotizacion'];
            $folio= $folioA+1;
  
            $queryU = "UPDATE cat_unidades_negocio SET folio_cotizacion='$folio' WHERE id=".$idUnidadNegocio;
            $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
            if($resultU){

              $query_cotizacion = "INSERT INTO cotizacion(folio,nombre,texto_inicio,texto_fin,estatus,version,id_proyecto,id_cliente,observaciones_generales,observaciones_internas,usuario_captura,id_usuario,periodicidad,tipo_facturacion,fecha_inicio_facturacion,dia,id_firmante,firma_digital,id_razon_social_emisora) 
                                        VALUES ('$folio','$nombreCotizacion','$texto_inicio','$texto_fin',1,1,'$idProyecto','$idCliente','$observaciones_generales','$observaciones_internas','$usuario','$idUsuario','$periodicidad','$tipo_facturacion','$fecha_inicio_facturacion','$dia','$id_firmante','$firma_digital','$razon_social_emisora')";
              $result_cotizacion = mysqli_query($this->link,$query_cotizacion) or die(mysqli_error());
              $id_cotizacion=mysqli_insert_id($this->link);
          
              if ($result_cotizacion)
              {
                $verifica = $id_cotizacion;
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
            $query_cotizacion = "UPDATE cotizacion SET 
                                    nombre='$nombreCotizacion',
                                    texto_inicio='$texto_inicio',
                                    texto_fin='$texto_fin',
                                    id_cliente=$idCliente,
                                    observaciones_generales='$observaciones_generales',
                                    observaciones_internas='$observaciones_internas',
                                    usuario_captura='$usuario',
                                    id_usuario=$idUsuario,
                                    id_firmante='$id_firmante',
                                    firma_digital=$firma_digital
                                    WHERE id=".$idCotizacion;
            $result_cotizacion = mysqli_query($this->link,$query_cotizacion) or die(mysqli_error());

            if ($result_cotizacion)
            {
              $verifica = $idCotizacion;
            }else{
              $verifica = 0;
            }
        }

        return $verifica;
    } //--fin function guardarCotizacion

    /**
      * Buscar los datos de cotizacion de un id
      *
      * @param int $idCotizacion de la que se van a buscar los datos
      * 
      **/
    function buscarCotizacionesId($idCotizacion){
        $result = $this->link->query("SELECT a.id,a.folio,a.nombre AS nombre_cotizacion,a.texto_inicio,a.texto_fin,a.estatus AS estatus_cotizacion,
                                          a.version,a.timestamp_version,a.id_proyecto,a.id_cliente,a.observaciones_generales,a.observaciones_internas,a.periodicidad,a.observacion_aprobar,
                                          a.tipo_facturacion,a.fecha_inicio_facturacion,a.dia,a.id_firmante,a.firma_digital,a.id_razon_social_emisora,a.justificacion_rechazada,
                                          c.nombre_comercial,c.nombre AS cliente,c.dirigido,c.razon_social AS razon_social_cliente,a.comision,
                                          c.telefono,c.email,c.calle,c.num_exterior,c.num_interior,c.codigo_postal,c.colonia,
                                          c.id_municipio,c.id_estado,c.id_pais,c.rfc,c.representante_legal,c.contacto,
                                          b.descripcion AS proyecto,b.estatus AS estatus_proyecto,b.id_sucursal,b.id_unidad_negocio,
                                          h.nombre AS firmante,j.razon_social AS razon_social_emisora,IF(COUNT(k.id)>0,1,0) AS elementos,
                                          IF(COUNT(l.id)>0,1,0) AS equipo,IF(COUNT(m.id)>0,1,0) AS servicios,IF(COUNT(n.id)>0,1,0) AS vehiculos,IF(COUNT(o.id)>0,1,0) AS consumibles
                                          FROM cotizacion a
                                          LEFT JOIN proyecto b ON a.id_proyecto=b.id
                                          LEFT JOIN pre_clientes c ON a.id_cliente=c.id
                                          LEFT JOIN sucursales d ON b.id_sucursal=d.id_sucursal
                                          LEFT JOIN cat_unidades_negocio i ON b.id_unidad_negocio=i.id
                                          LEFT JOIN paises e ON c.id_pais=e.id
                                          LEFT JOIN estados f ON c.id_estado=f.id
                                          LEFT JOIN municipios g ON c.id_municipio=g.id
                                          LEFT JOIN cat_firmantes h ON a.id_firmante=h.id
                                          LEFT JOIN empresas_fiscales j ON a.id_razon_social_emisora=j.id_empresa
                                          LEFT JOIN cotizacion_elementos k ON a.id=k.id_cotizacion
                                          LEFT JOIN cotizacion_equipo l ON a.id=l.id_cotizacion
                                          LEFT JOIN cotizacion_servicios m ON a.id=m.id_cotizacion
                                          LEFT JOIN cotizacion_vehiculos n ON a.id=n.id_cotizacion
                                          LEFT JOIN cotizacion_consumibles o ON a.id=o.id_cotizacion
                                          WHERE a.id=".$idCotizacion);


        return query2json($result);
    }//--fin function buscarCotizacionesId

    /**
      * Buscar los datos de cotizacion segun el filtro ingresado por el suario
      *
      * @param int $filtroCliente recibe id cliente para buscar todas las cotizaciones realizadas a ese cliente
      * @param int $filtroProyecto recibe id proyecto para buscar todas las cotizaciones realizadas en ese proyecto
      * @param int $filtroSucursal id de la sucursal de una unidad actual
      * @param int $filtroUsuario muestra todos los usuarios dados de alta
      * @param int $filtroEstatus id esttaus de la cotizacion todos= Todos 1=Proceso 2=Negociación 3=Rechazada 4=Aprobada
      *
    **/
    function buscarCotizacionesFiltros($datos){

      $filtroCliente='';
      $filtroProyecto='';
      $filtroSucursal='';
      $filtroUsuario='';
      $filtroEstatus='';
      $radioFiltro='';
      $idsSucursales='';


        /*if($datos['radioFiltro']!='todas' ){

          if($datos['radioFiltro']=='activas' && $datos['filtroSucursal']==''){

            $radioFiltro=' AND a.estatus=1 AND b.id_sucursal in ('.$datos['idsSucursales'].')';

          }elseif($datos['radioFiltro']=='ultimas'){

            $radioFiltro=' AND a.id IN (SELECT MAX(id) FROM cotizacion GROUP BY id_proyecto) ';

          }else{*/

      $idUnidadNegocio = $datos['idUnidadNegocio'];

      if($datos['filtroCliente']!=''){
        $filtroCliente=' AND a.id_cliente='.$datos['filtroCliente'];
      }

      if($datos['filtroProyecto']!=''){
        $filtroProyecto=' AND a.id_proyecto='.$datos['filtroProyecto'];
      }

      if($datos['filtroSucursal']!=''){
          $filtroSucursal=' AND b.id_sucursal='.$datos['filtroSucursal'];
      }

      if($datos['filtroUsuario']!=''){
        $filtroUsuario=' AND a.id_usuario='.$datos['filtroUsuario'];
      }

      if($datos['filtroEstatus']!='' && $datos['filtroEstatus']!='todos'){
        $filtroEstatus=' AND a.estatus='.$datos['filtroEstatus'];
      }

      $condicion='';
      if($datos['radioFiltro'] == 'activas'){
        $condicion=' AND a.estatus=1';
      }else if($datos['radioFiltro'] == 'todas'){
        $condicion='';
      }else{  //ultimas
        $condicion=' AND a.id IN (SELECT MAX(a.id) FROM cotizacion a GROUP BY a.id_proyecto)';
      }

      $fecha='';
      $fechaInicio = $datos['fechaInicio'];
      $fechaFin = $datos['fechaFin'];
      if($fechaInicio == '' && $fechaFin == '')
      {
        $fecha=" AND DATE(a.timestamp_version) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
      }else if($fechaInicio != '' &&  $fechaFin == '')
      {
        $fecha=" AND DATE(a.timestamp_version) >= '$fechaInicio' ";
      }else{  //-->trae fecha inicio y fecha fin
        $fecha=" AND DATE(a.timestamp_version) >= '$fechaInicio' AND DATE(a.timestamp_version) <= '$fechaFin' ";
      }
        
      $result = $this->link->query("SELECT a.id,a.folio AS folio,a.nombre AS cotizacion,a.version,a.timestamp_version AS fecha_creacion,a.estatus AS estatus_cotizacion,c.nombre AS cliente,
                                            b.descripcion AS proyecto,b.usuario_captura AS usuario,b.id_usuario,
                                            b.id_sucursal,d.descr AS sucursal,b.id_unidad_negocio,IF(b.estatus=1,'Proceso',IF(b.estatus=2,'Negociación',IF(b.estatus=3,'Rechazada','Aprobada'))) AS estatus_proyecto,e.nombre AS unidad_negocio
                                            FROM cotizacion a
                                            LEFT JOIN proyecto b ON a.id_proyecto=b.id
                                            LEFT JOIN pre_clientes c ON a.id_cliente=c.id
                                            LEFT JOIN sucursales d ON b.id_sucursal=d.id_sucursal
                                            LEFT JOIN cat_unidades_negocio e ON d.id_unidad_negocio=e.id
                                            WHERE b.id_unidad_negocio=$idUnidadNegocio $filtroSucursal $condicion $filtroProyecto  $filtroCliente $filtroUsuario $filtroEstatus $radioFiltro $fecha
                                           ORDER BY a.id DESC");

        return query2json($result);
    }//--fin function buscarCotizacionesId

   /**
      * Buscar todos los proyectos de una idSucursal
      *
      * @param int $idSucursal solo mostrara las sucursales a las que tiene acceso de una unidad de negocio
      *
    **/
    function buscarCotizacionesProyectos($idSucursal){
       
       $result = $this->link->query("SELECT id,descripcion,IF(estatus=1,'Proceso',IF(estatus=2,'Negociación',IF(estatus=3,'Rechazada','Aprobada'))) AS estatus 
                                        FROM proyecto 
                                        WHERE id_sucursal = ".$idSucursal." 
                                        ORDER BY descripcion ASC ");

        return query2json($result);
    }//--fin function buscarCotizacionesId 

    /**
      *Busca los clientes en la tabla pre_clientes
      * 
      **/
    function buscarCotizacionesClientesProyecto($idProyecto){
  
        $result = $this->link->query("SELECT a.id_cliente,b.nombre_comercial,b.nombre,b.razon_social,c.municipio,d.estado FROM cotizacion a LEFT JOIN pre_clientes b ON a.id_cliente = b.id LEFT JOIN municipios c ON b.id_municipio=c.id LEFT JOIN  estados d ON b.id_estado=d.id WHERE a.id_proyecto = ".$idProyecto." ORDER BY b.nombre");

        return query2json($result);
    }//-- fin function buscarCotizacionesClientes
      
    /** Buscar los datos de cotizacion de un id
      *
      * @param int $idCotizacion de la que se van a buscar los datos
      * 
    **/
    function calcularResumen($idCotizacion){
        $result = $this->link->query("SELECT 'elementos' AS tabla,IFNULL(SUM(costo_total),0) AS costo_mensual, 
                                        IFNULL(SUM(precio_total),0) AS precio_mensual,
                                        0 AS inversion_secorp,0 AS inversion_cliente
                                        FROM cotizacion_elementos  WHERE id_cotizacion=".$idCotizacion."
                                        UNION ALL
                                        SELECT 'equipo' AS tabla,IFNULL(SUM(IF(tipo_pago = 1 AND prorratear = 0,costo_total,0)),0) AS costo_mensual,
                                        IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual,
                                        IFNULL(SUM(IF(tipo_pago = 2 AND prorratear = 0,costo_total,0)),0) AS inversion_secorp,
                                        IFNULL(SUM(IF(tipo_pago = 2,precio_total,0)),0) AS inversion_cliente
                                        FROM cotizacion_equipo WHERE id_cotizacion=".$idCotizacion."
                                        UNION ALL
                                        SELECT 'servicios' AS tabla ,IFNULL(SUM(IF(tipo_pago = 1,costo_total,0)),0) AS costo_mensual,
                                        IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual,
                                        IFNULL(SUM(IF(tipo_pago = 2,costo_total,0)),0) AS inversion_secorp,
                                        IFNULL(SUM(IF(tipo_pago = 2,precio_total,0)),0) AS inversion_cliente 
                                        FROM cotizacion_servicios WHERE id_cotizacion=".$idCotizacion."
                                        UNION ALL
                                        SELECT 'vehiculos' AS tabla,IFNULL(SUM(IF(tipo_pago = 1,costo_total,0)),0) AS costo_mensual,
                                        IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual,
                                        IFNULL(SUM(IF(tipo_pago = 2,costo_total,0)),0) AS inversion_secorp,
                                        IFNULL(SUM(IF(tipo_pago = 2,precio_total,0)),0) AS inversion_cliente
                                        FROM cotizacion_vehiculos WHERE id_cotizacion=".$idCotizacion."
                                        UNION ALL
                                        SELECT 'consumibles' AS tabla,IFNULL(SUM(IF(tipo_pago = 1 AND prorratear = 0,costo_total,0)),0) AS costo_mensual,
                                        IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual,
                                        IFNULL(SUM(IF(tipo_pago = 2 AND prorratear = 0,costo_total,0)),0) AS inversion_secorp,
                                        IFNULL(SUM(IF(tipo_pago = 2,precio_total,0)),0) AS inversion_cliente
                                        FROM cotizacion_consumibles WHERE id_cotizacion=".$idCotizacion);

       return query2json($result);
    } //--fin function buscarCotizacionesId

    /**
      * Manda llamar a la funcion que actualiza el estatus de la cotizacion y el proyecto
      *
      * @param int $idProyecto id del proyecto al que se va actualizar
      * @param int $idCotizacion id de la cotizacion que se va actualizar
      * @param int $estatusProyecto Al momento de imprimir cotización su esatatus es impresa(2) y en proyecto el estatus es Negociación(2)
      * 
      **/
    function actualizaEstatus($idCotizacion,$idProyecto,$estatusProyecto){
        $verifica = 0;
  
       $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");
  
        $verifica = $this -> estatusActualizar($idCotizacion,$idProyecto,$estatusProyecto);
  
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
  
        return $verifica;
    }//--fin function guardarCotizaciones

     /**
      * Modifica el estatus correpondiente
      *
      **/
    function estatusActualizar($idCotizacion,$idProyecto,$estatusProyecto){

      $verifica=0;

      $actualizaCotizacion = "UPDATE cotizacion SET estatus=2 WHERE id=".$idCotizacion;
      $result1 = mysqli_query($this->link, $actualizaCotizacion) or die(mysqli_error());
            
        if($result1){

          $actualizaProyecto = "UPDATE proyecto SET estatus='$estatusProyecto' WHERE id=".$idProyecto;
          $result2 = mysqli_query($this->link, $actualizaProyecto) or die(mysqli_error());

          if($result2){
              $verifica=1;   //se actualizó el estatus del proyecto y de la cotización
          }else{
              $verifica=2; //no se actualizó el estatus del proyecto, pero si de la cotización
          }

        }else{
           $verifica=0; //No se actualizó el estatus de la cotización
        }

      return $verifica;
    }

    /**
      * Verifica que todos los campos del cliente al cual va dirigida la cotizacion esten completos
      *
      * @param int $idCotizacion id de la cotizacion para validar los datos del cliente
      * 
      **/
    function validarDatosFiscales($idCotizacion){
      $valor=0;
    
      $query="SELECT id_cliente FROM cotizacion WHERE id=".$idCotizacion;
      $result = mysqli_query($this->link,$query) or die(mysqli_error());
  
      if ($result){
          $row_x = mysqli_fetch_array($result);
          $id_cliente=$row_x['id_cliente'];
  
          $query2="SELECT nombre_comercial,nombre,dirigido,razon_social,telefono,email,calle,num_exterior,codigo_postal,colonia,id_municipio,id_estado,id_pais,rfc,representante_legal,contacto 
          FROM pre_clientes WHERE id=".$id_cliente;
          $result2 = mysqli_query($this->link,$query2) or die(mysqli_error());
          if ($result2){
              $row_y= mysqli_fetch_array($result2);

              $nombre_comercial = $row_y['nombre_comercial'];
              $nombre = $row_y['nombre'];
              $dirigido = $row_y['dirigido'];
              $telefono = $row_y['telefono'];
              $email = $row_y['email'];
              $calle = $row_y['calle'];
              $num_exterior =$row_y['num_exterior'];
              $colonia = $row_y['colonia'];
              $rfc = $row_y['rfc'];
              $representante_legal = $row_y['representante_legal'];
              $codigo_postal = $row_y['codigo_postal'];
              $id_municipio = $row_y['id_municipio'];
              $id_estado = $row_y['id_estado'];
              $id_pais = $row_y['id_pais'];
              $razon_social = $row_y['razon_social'];
              $contacto = $row_y['contacto'];
  
              if($nombre_comercial != '' && $nombre != '' && $dirigido != '' && $telefono != '' && $email != '' && $calle != '' && $num_exterior != '' && $colonia != '' && $rfc != '' && $representante_legal != '' && $codigo_postal != 0 && $id_municipio != 0 && $id_estado != 0 && $id_pais != 0 && $razon_social != '' && $contacto != '')
              {
                  $valor = 1;
              }else{
                  $valor = 0;
              }
  
          }
      }
  
      return $valor;
    }//--fin function validarDatosFiscales

    /**
      * Aprobar o rechazar una cotizacion
      *
      * @param varchar $datos array que contiene los datos para cambiar los estatus de la cotizacion y proyecto
      * @param varchar $fecha_fin  fecha en la que finzaliza el proyecto
      * 
      **/
    function aprobarCotizacion($datos){
        //$verifica = 0;
        $verifica = array('verifica'=>false);
    
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> aprobarRechazarCotizacion($datos);

        //if($verifica > 0)
        if($verifica['verifica'] === false)
        {
            $this->link->query('rollback;');
        }else{
          $this->link->query("commit;");
        }

        //return $verifica;
        return json_encode($verifica);

    }//--fin function aprobarCotizacion

    /**
      * Verifica que todos los campos del cliente al cual va dirigida la cotizacion esten completos
      *
      * @param varchar $datos array que contiene los datos para cambiar los estatus de la cotizacion y proyecto
      * int $idCotizacion id de la cotizacion para validar los datos del cliente
      * varchar $fechaArranque  fecha en la que inicia el servicio
      * int $estatusProyecto  estatus del proyecto 4=aprobada 3=rechazada
      * varchar $correos  correos a donde se enviara el formato de cotizacion aprobada
      * 
      **/
    function aprobarRechazarCotizacion($datos){

      $verifica = array('verifica'=>false);

      $idCotizacion = $datos['idCotizacion'];
      $fechaArranque = isset($datos['fechaArranque']) ? $datos['fechaArranque'] : '';
      $observacion = isset($datos['observacion']) ? $datos['observacion'] : '';
      $estatusProyecto = $datos['estatusProyecto'];
      $correos = isset($datos['correos']) ? $datos['correos'] : '';
      $justificacionRechazada = $datos['justificacionRechazada'];
      $fecha_inicio_facturacion = isset($datos['fecha_inicio_facturacion']) ? $datos['fecha_inicio_facturacion'] : '0000-00-00';
      $periodicidad = isset($datos['periodicidad']) ? $datos['periodicidad'] : 0;
      $tipo_facturacion = isset($datos['tipo_facturacion']) ? $datos['tipo_facturacion'] : 0;
      $dia = isset($datos['dia']) ? $datos['dia'] : '';
      $razon_social_emisora = isset($datos['razon_social_emisora']) ? $datos['razon_social_emisora'] : 0;

      $buscaX="SELECT a.folio,a.id_proyecto,b.id_sucursal,b.id_unidad_negocio
                FROM cotizacion a
                LEFT JOIN proyecto b ON a.id_proyecto=b.id
                WHERE a.id=".$idCotizacion;
      $resultX = mysqli_query($this->link,$buscaX) or die(mysqli_error());
      
      $numX = mysqli_num_rows($resultX);
      if($numX > 0)
      {
        $rowX = mysqli_fetch_array($resultX);
        $idProyecto = $rowX['id_proyecto'];
        $idSucursal = $rowX['id_sucursal'];
        $idUnidadNegocio = $rowX['id_unidad_negocio'];
        $folioCotizacion = $rowX['folio'];
       

        $arr=array('idProyecto'=>$idProyecto,
                    'idSucursal'=>$idSucursal,
                    'idUnidadNegocio'=>$idUnidadNegocio,
                    'folioCotizacion'=>$folioCotizacion,
                    'correos'=>$correos,
                    'idCotizacion'=>$idCotizacion);

        $busca_correos="SELECT id FROM correos WHERE id_sucursal=".$idSucursal." AND id_unidad_negocio=".$idUnidadNegocio;
        $result_busca_correos = mysqli_query($this->link,$busca_correos) or die(mysqli_error());
        $num = mysqli_num_rows($result_busca_correos);
        if($num > 0)
        {
            $actualiza_correo="UPDATE correos SET correos='$correos' WHERE id_sucursal=".$idSucursal." AND id_unidad_negocio=".$idUnidadNegocio;
            $result_actualiza = mysqli_query($this->link,$actualiza_correo) or die(mysqli_error());

            if($result_actualiza)
            {
                $actualiza_cotizacion = "UPDATE cotizacion SET 
                periodicidad=$periodicidad,
                tipo_facturacion=$tipo_facturacion,
                fecha_inicio_facturacion='$fecha_inicio_facturacion',
                dia='$dia',
                id_razon_social_emisora='$razon_social_emisora',
                estatus='2',
                observacion_aprobar='$observacion', 
                justificacion_rechazada='$justificacionRechazada' 
                WHERE id=".$idCotizacion;
                $result = mysqli_query($this->link,$actualiza_cotizacion) or die(mysqli_error());

                if($result)
                {     
                    $actualiza_proyecto = "UPDATE proyecto SET estatus='$estatusProyecto',fecha_arranque='$fechaArranque',fecha_fin='CURDATE()' WHERE id=".$idProyecto;
                    $result2 = mysqli_query($this->link,$actualiza_proyecto) or die(mysqli_error());

                    if($result2)
                    {
                        if($estatusProyecto == 4)
                        {   //$this->link->query("commit;");
                            $verifica = $this -> enviarCorreoAprobacion($arr);
                        }else{
                            //$this->link->query("commit;");
                            $mensajeGlobalAC .= ' Estatus generado </br>';
                            $verifica = array('verifica'=>true,'mensaje'=>$mensajeGlobalAC);
                        }
                    }
                }
            }
        }else{
            $insert_correo="INSERT INTO correos(id_sucursal,correos,id_unidad_negocio) VALUES('$idSucursal','$correos','$idUnidadNegocio')";
            $result_insert = mysqli_query($this->link,$insert_correo) or die(mysqli_error());
            if($result_insert)
            {
                $actualiza_cotizacion = "UPDATE cotizacion SET justificacion_rechazada='$justificacionRechazada' WHERE id=".$idCotizacion;
                $result = mysqli_query($this->link,$actualiza_cotizacion) or die(mysqli_error());
                    
                if($result)
                {
                    $actualiza_proyecto = "UPDATE proyecto SET estatus='$estatusProyecto',fecha_arranque='$fechaArranque',fecha_fin='$fecha_fin' WHERE id=".$idProyecto;
                    $result2 = mysqli_query($this->link,$actualiza_proyecto) or die(mysqli_error());

                    if($result2)
                    {
                        if($estatusProyecto == 4)
                        {
                            $verifica = $this -> enviarCorreoAprobacion($arr);
                        }else{
                            $mensajeGlobalAC .= ' Estatus generado </br>';
                            $verifica = array('verifica'=>true,'mensaje'=>$mensajeGlobalAC);
                        }
                    }
                }
              }
        }
      }

      return $verifica;

    }//--fin function aprobarRechazarCotizacio

    /** 
      * 
      *Envia correo con formato de la cotizacion aprobada
      *
      **/
    function enviarCorreoAprobacion($arr){
      include_once("../vendor/lib_mail/class.phpmailer.php");
      include_once("../vendor/lib_mail/class.smtp.php");

      $verifica = array('verifica'=>false);

      $idCotizacion = $arr['idCotizacion'];
      $correos = $arr['correos'];

      $dest_mail=$correos;
      $destinatarios = explode(',',$dest_mail);

      $asunto ="Cotización Secorp";

      $mail = new PHPMailer();
      $mail->CharSet = 'UTF-8';
      $mail->IsSMTP();
      $mail->IsHTML(true);	
      $mail->SMTPSecure = "TLS";
      $mail->SMTPAuth = true;
      
      $mail->Host = "denken.mx";
      $mail->Port = 26;
      $mail->Username = "noreply@denken.mx";
      $mail->Password = "Martinika8%#";	
      $mail->SetFrom("noreply@denken.mx","Cotización Secorp");
      
      $mail->Subject = $asunto;

      $mensaje = '<html><body>';
      $mensaje .= '<h3>Te envió el formato de cotización aprobado</h3>';
      $mensaje .= '</body></html>';

      $archivo='../cotizaciones/cotizacion_'.$idCotizacion.'.pdf';
      
      $mail->AddAttachment($archivo,'cotizacion_'.$idCotizacion.'.pdf');
     
      $mail->MsgHTML($mensaje);

      for($i = 0; $i < count($destinatarios); $i++)
      {
          $mail->AddAddress($destinatarios[$i], "Cotización Secorp");	
      }

      
      if(!$mail->Send())
      { 
        if(file_exists($archivo))
            @unlink($archivo);
          //-->Fallo
          //$verifica = array('mensaje'=>'Error al enviar formato cotización.');
          $verifica = array('verifica'=>false);
      }else{
          //-->Exito
          //$verifica = 1;//llamar enviarDatosFiscales
          if(file_exists($archivo))
              @unlink($archivo);

          $verifica = $this -> enviarDatosCotizacion($arr);
      }

      return $verifica;
    }//--fin function enviarCorreo

    /** 
      * 
      *Busca el texto inicio y texto fin de la ultima cotizacion generada
      *
      **/
    function buscarCotizacionesTextoInicioFin(){
      $result = $this->link->query("SELECT texto_inicio,texto_fin FROM cotizacion ORDER BY id DESC LIMIT 1");

      return query2json($result);
    }//--fin function buscarCotizacionesTextoInicioFin

    /** 
      * 
      *Envia por correo los datos de la cotizacion aprobada a cada area segun las secciones de la plantilla
      *
      * @param varchar $datos array que contiene los datos
      *
      **/
    //function enviarDatosCotizacion($datos){
    function enviarDatosCotizacion($arr){
      
      $verifica = array('verifica'=>false);

      $idCotizacion = $arr['idCotizacion'];

      $query_clientes="SELECT id_cliente FROM cotizacion WHERE id=".$idCotizacion;
      $result = mysqli_query($this->link,$query_clientes) or die(mysqli_error());

      if ($result){
          $row_x = mysqli_fetch_array($result);
          $id_cliente=$row_x['id_cliente'];

          $query2="SELECT a.id,a.nombre_comercial,a.nombre,a.dirigido,a.razon_social,a.telefono,a.email,a.calle,a.num_exterior,a.num_interior,a.codigo_postal,
                      a.colonia,a.rfc,a.representante_legal,a.contacto,d.municipio,c.estado,b.pais 
                      FROM pre_clientes  a 
                      LEFT JOIN paises b ON a.id_pais=b.id
                      LEFT JOIN estados c ON a.id_estado=c.id 
                      LEFT JOIN municipios d ON a.id_municipio=d.id
                      WHERE a.id=".$id_cliente;
          $result2 = mysqli_query($this->link,$query2) or die(mysqli_error());

          if ($result2){
            $row = mysqli_fetch_array($result2);
            $nombre_comercial = $row['nombre_comercial'];
            $nombre = $row['nombre'];
            $dirigido = $row['dirigido'];
            $razon_social = $row['razon_social'];
            $telefono = $row['telefono'];
            $email = $row['email'];
            $calle = $row['calle'];
            $num_exterior = $row['num_exterior'];
            $num_interior = $row['num_interior'];
            $codigo_postal = $row['codigo_postal'];
            $colonia = $row['colonia'];
            $municipio = $row['municipio'];
            $estado = $row['estado'];
            $pais = $row['pais'];
            $rfc = $row['rfc'];
            $representante_legal = $row['representante_legal'];
            $contacto = $row['contacto'];
            
            $mensaje .= '<table border=1; width="600px;">';
            $mensaje .= '<tr><td width="50%">Cliente</td><td width="50%">'.$nombre.'</td></tr>';
            $mensaje .= '<tr><td>Nombre Comercial</td><td>'.$nombre_comercial.'</td></tr>';
            $mensaje .= '<tr><td>RFC</td><td>'.$rfc.'</td></tr>';
            $mensaje .= '<tr><td>Razón Social</td><td>'.$razon_social.'</td></tr>';
            $mensaje .= '<tr><td>Dirigido</td><td>'.$dirigido.'</td></tr>';
            $mensaje .= '<tr><td>Contacto</td><td>'.$contacto.'</td></tr>';
            $mensaje .= '<tr><td>Representante Legal</td><td>'.$representante_legal.'</td></tr>';
            $mensaje .= '<tr><td>Telefono</td><td>'.$telefono.'</td></tr>';
            $mensaje .= '<tr><td>Email</td><td>'.$email.'</td></tr>';
            $mensaje .= '<tr><td>Código Postal</td><td>'.$codigo_postal.'</td></tr>';
            $mensaje .= '<tr><td>Calle</td><td>'.$calle.'</td></tr>';
            $mensaje .= '<tr><td>No. Exterior</td><td>'.$num_exterior.'</td></tr>';
            $mensaje .= '<tr><td>No. Interior</td><td>'.$num_interior.'</td></tr>';
            $mensaje .= '<tr><td>Colonia</td><td>'.$colonia.'</td></tr>';
            $mensaje .= '<tr><td>Municipio</td><td>'.$municipio.'</td></tr>';
            $mensaje .= '<tr><td>Estado</td><td>'.$estado.'</td></tr>';
            $mensaje .= '<tr><td>Pais</td><td>'.$pais.'</td></tr>';
            $mensaje .= '</table>';

            //$verifica = $this -> enviarCorreoDatosFiscales($datos,$mensaje);
            $verifica = $this -> enviarCorreoDatosFiscales($arr,$mensaje);
          }else{
            //$verifica = 'Cliente no tiene datos';
            $mensajeGlobalAC .= ' Cliente no tiene datos </br>';
            $verifica = array('verifica'=>true,'mensaje'=>$mensajeGlobalAC);
          }

      }else{
        //$verifica = 'No hay cliente de cotización';
        $mensajeGlobalAC .= ' No hay cliente de cotización </br>';
        $verifica = array('verifica'=>true,'mensaje'=>$mensajeGlobalAC);
      }

      return $verifica;

    }//--fin function enviarDatosCotizacion

    /** 
      * 
      *Envia por correo los datos fiscales del cliente
      *
      * @param varchar $datos array que contiene los datos
      * @param varchar $datos_cliente tabla html con tatos del cliente
      *
      **/
    //function enviarCorreoDatosFiscales($datos,$datos_cliente){
    function enviarCorreoDatosFiscales($arr,$datos_cliente){
      
      include_once("../vendor/lib_mail/class.phpmailer.php");
      include_once("../vendor/lib_mail/class.smtp.php");

      $verifica = array('verifica'=>false);

      $idCotizacion = $arr['idCotizacion'];
      $folioCotizacion = $arr['folioCotizacion'];

      $dest_mail='ne@denken.mx,mh@denken.mx';   ///cambiar por correo de Mabel
      $destinatarios = explode(',',$dest_mail);

      $asunto ='Cotización Datos Fiscales';

      $mail = new PHPMailer();
      $mail->CharSet = 'UTF-8';
      $mail->IsSMTP();
      $mail->IsHTML(true);	
      $mail->SMTPSecure = "TLS";
      $mail->SMTPAuth = true;
      
      $mail->Host = "denken.mx";
      $mail->Port = 26;
      $mail->Username = "noreply@denken.mx";
      $mail->Password = "Martinika8%#";	
      $mail->SetFrom("noreply@denken.mx",$asunto);
      
      $mail->Subject = $asunto;
      $mensaje = '<html><body>';
      $mensaje .= '<h3>Datos fiscales de la cotización con folio: '.$folioCotizacion.'</h3>';
      $mensaje .= $datos_cliente.'<br>';
      $mensaje .= '</body></html>';
     
      $mail->MsgHTML($mensaje);

      for($i = 0; $i < count($destinatarios); $i++)
      {
          $mail->AddAddress($destinatarios[$i], $asunto);	
      }

      
      if(!$mail->Send()){
          //Error al enviar
          //$verifica = 'Error al enviar Datos Fiscales';
          $mensajeGlobalAC .= ' Error al enviar Datos Fiscales </br>';
          $verifica = array('verifica'=>true,'mensaje'=>$mensajeGlobalAC);
      }else{
          //Datos Enviados
          $verifica = $this -> buscaCorreosSecciones($arr,$datos_cliente);
      }
      
      return $verifica;
    }//--fin function enviarCorreoDatos

    /** 
      * 
      * Busca los datos de las secciones y las manda donde haya correos en las secciones de la plantilla de la cotización
      *
      * @param varchar $datos array que contiene los datos
      * @param varchar $datos_cliente tabla html con tatos del cliente
      *
      **/
    function buscaCorreosSecciones($datos,$datos_cliente){
      $verifica = array('verifica'=>false);

      $elementos='';
      $uniformes='';
      $num_elementos='';
      $servicios='';
      $vehiculos='';
      $equipo='';
      $consumibles='';

      $uniformesSinCP='';
      $serviciosSinCP='';
      $equipoSinCP='';
      $vehiculosSinCP='';
      $elementosSueldoMensual='';

      $elementosCosto='';
      $vehiculosCosto='';
      $equipoCosto='';
      $consumiblesCosto='';

      ///variables globales para el calculo de resumen inversion inicio
      $costoMensualTotal=0;
      $costoMensual=0;
      $precioMensual=0;
      $inversionSecorp=0;
      $inversionCliente=0;
      $totalIngresosElementos=0;
      $totalcostosElementos=0;
      ///variables globales para el calculo de resumen inversion fin

      $idCotizacion = $datos['idCotizacion'];
      $idUnidadNegocio = $datos['idUnidadNegocio'];
      $folioCotizacion = $datos['folioCotizacion'];

      $buscaTE="SELECT SUM(cantidad) AS total_elementos FROM cotizacion_elementos WHERE id_cotizacion=".$idCotizacion;
      $resultTE = mysqli_query($this->link,$buscaTE) or die(mysqli_error());
      $rowTE = mysqli_fetch_array($resultTE);
      $totalElmentos = $rowTE['total_elementos'];

      $buscaTotalesResumen="SELECT 'elementos' AS tabla,IFNULL(SUM(costo_total),0) AS costo_mensual, 
                              IFNULL(SUM(precio_total),0) AS precio_mensual,
                              0 AS inversion_secorp,0 AS inversion_cliente
                              FROM cotizacion_elementos  WHERE id_cotizacion=".$idCotizacion."
                              UNION ALL
                              SELECT 'equipo' AS tabla,IFNULL(SUM(IF(tipo_pago = 1 AND prorratear = 0,costo_total,0)),0) AS costo_mensual,
                              IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual,
                              IFNULL(SUM(IF(tipo_pago = 2 AND prorratear = 0,costo_total,0)),0) AS inversion_secorp,
                              IFNULL(SUM(IF(tipo_pago = 2,precio_total,0)),0) AS inversion_cliente
                              FROM cotizacion_equipo WHERE id_cotizacion=".$idCotizacion."
                              UNION ALL
                              SELECT 'servicios' AS tabla ,IFNULL(SUM(IF(tipo_pago = 1,costo_total,0)),0) AS costo_mensual,
                              IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual,
                              IFNULL(SUM(IF(tipo_pago = 2,costo_total,0)),0) AS inversion_secorp,
                              IFNULL(SUM(IF(tipo_pago = 2,precio_total,0)),0) AS inversion_cliente 
                              FROM cotizacion_servicios WHERE id_cotizacion=".$idCotizacion."
                              UNION ALL
                              SELECT 'vehiculos' AS tabla,IFNULL(SUM(IF(tipo_pago = 1,costo_total,0)),0) AS costo_mensual,
                              IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual,
                              IFNULL(SUM(IF(tipo_pago = 2,costo_total,0)),0) AS inversion_secorp,
                              IFNULL(SUM(IF(tipo_pago = 2,precio_total,0)),0) AS inversion_cliente
                              FROM cotizacion_vehiculos WHERE id_cotizacion=".$idCotizacion."
                              UNION ALL
                              SELECT 'consumibles' AS tabla,IFNULL(SUM(IF(tipo_pago = 1 AND prorratear = 0,costo_total,0)),0) AS costo_mensual,
                              IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual,
                              IFNULL(SUM(IF(tipo_pago = 2 AND prorratear = 0,costo_total,0)),0) AS inversion_secorp,
                              IFNULL(SUM(IF(tipo_pago = 2,precio_total,0)),0) AS inversion_cliente
                              FROM cotizacion_consumibles WHERE id_cotizacion=".$idCotizacion;
      $resultTR = mysqli_query($this->link,$buscaTotalesResumen) or die(mysqli_error());
      $numTR = mysqli_num_rows($resultTR);

      while($rowTR = mysqli_fetch_array($resultTR)){

        $costoMensual=$costoMensual+$rowTR['costo_mensual'];
        $precioMensual=$precioMensual+$rowTR['precio_mensual'];
        $inversionSecorp=$inversionSecorp+$rowTR['inversion_secorp'];
        $inversionCliente=$inversionCliente+$rowTR['inversion_cliente'];

        if($rowTR['tabla'] == 'elementos'){
            $totalIngresosElementos=$rowTR['precio_mensual'];
            $totalcostosElementos=$rowTR['costo_mensual'];
        }
      }

      $utilidad=($precioMensual*12)-($costoMensual*12)-($inversionSecorp+$inversionCliente);
      $inversion=($inversionSecorp-$inversionCliente)/($precioMensual-$costoMensual);
      if($inversion > 0){
        $totalInversion=$inversion;
      }else{
        $totalInversion=0;
      }
      $utilidadBruta=$precioMensual-$costoMensual;

      $prorrateoMensual = $inversionSecorp/12;
      $costoUnico = $prorrateoMensual + $costoMensual;
      $precio = $precioMensual + $inversionCliente;
      $prorrateo = ($precio*100)/$costoUnico;
      $porcentajeUtilidad = $prorrateo - 100;

      if($totalElmentos > 0){
        $numElementos = $totalElmentos;
        $utilidadElemento = ($totalIngresosElementos - $totalcostosElementos)/$numElementos;
      }else{
        $utilidadElemento = 0;
      }

      $costo_mensual =$costoMensual;
      $precio_mensual = $precioMensual;
      $inversion_secorp = $inversionSecorp;
      $inversion_cliente = $inversionCliente;
      $utilidad_primer_anio = $utilidad;
      $retorno_inversion = $totalInversion.' meses';
      $utilidad_bruta_mensual = $utilidadBruta;
      $utilidad_elemento = $utilidadElemento;
      $porcentaje_utilidad_final = $porcentajeUtilidad;

      $datos_cotizacion="SELECT i.nombre AS nombre_unidad_negocio,d.descr AS nombre_sucursal,a.nombre AS nombre_cotizacion,
                            a.periodicidad,a.tipo_facturacion,a.fecha_inicio_facturacion,a.dia,h.nombre AS nombre_firmante,
                            j.razon_social AS razon_social_emisora
                            FROM cotizacion a
                            LEFT JOIN proyecto b ON a.id_proyecto=b.id
                            LEFT JOIN sucursales d ON b.id_sucursal=d.id_sucursal
                            LEFT JOIN cat_unidades_negocio i ON b.id_unidad_negocio=i.id
                            LEFT JOIN cat_firmantes h ON a.id_firmante=h.id
                            LEFT JOIN empresas_fiscales j ON a.id_razon_social_emisora=j.id_empresa
                            WHERE a.id=".$idCotizacion;
      $result_cotizacion = mysqli_query($this->link,$datos_cotizacion) or die(mysqli_error());
      $row_cot = mysqli_fetch_array($result_cotizacion);
      $peri=$row_cot['periodicidad'];
      $tipo_fact=$row_cot['tipo_facturacion'];
      $dato_dia=$row_cot['dia'];

      $nombre_unidad_negocio = $row_cot['nombre_unidad_negocio'];
      $nombre_sucursal = $row_cot['nombre_sucursal'];
      $nombre_cotizacion = $row_cot['nombre_cotizacion'];
      $fecha_inicio_facturacion = $row_cot['fecha_inicio_facturacion'];
      $nombre_firmante = $row_cot['nombre_firmante'];
      $razon_social_emisora = $row_cot['razon_social_emisora'];

      switch ($peri) {
        case 1:
            $periodicidad = 'Semanal';
            break;
        case 2:
            $periodicidad = 'Quincenal';
            break;
        case 3:
            $periodicidad = 'Mensual';
            break;
        case 3:
              $periodicidad = 'Unico';
              break;
      }

      if($tipo_fact == 1)
      {
        $tipo_facturacion = 'Mes corriente';
      }else if($tipo_fact == 2)
      {
        $tipo_facturacion = 'Mes Vencido';
      }else{
        $tipo_facturacion = 'Mes anticipado';
      }

      switch ($dato_dia) {
        case 'D':
            $dia = 'Domingo';
            break;
        case 'L':
            $dia = 'Lunes';
            break;
        case 'M':
            $dia = 'Martes';
            break;
        case 'X':
            $dia = 'Miercoles';
            break;
        case 'J':
            $dia = 'Jueves';
            break;
        case 'V':
            $dia = 'Viernes';
            break;
        case 'S':
            $dia = 'Sabado';
            break;
        case 'Q1':
            $dia = '01 - 16';
            break;
        case 'Q2':
            $dia = '02 - 17';
            break;
        case 'Q3':
            $dia = '03 - 18';
            break;
        case 'Q4':
            $dia = '04 - 19';
            break;
        case 'Q5':
            $dia = '05 - 20';
            break;
        case 'Q6':
            $dia = '06 - 21';
            break;
        case 'Q7':
            $dia = '07 - 22';
            break;
        case 'Q8':
            $dia = '08 - 23';
            break;
        case 'Q9':
            $dia = '09 - 24';
            break;
        case 'Q10':
            $dia = '10 - 25';
            break;
        case 'Q11':
            $dia = '11 - 26';
            break;
        case 'Q12':
            $dia = '12 - 27';
            break;
        case 'Q13':
            $dia = '13 - 28';
            break;
        case 'Q14':
            $dia = '14 - 29';
            break;
        case 'Q15':
            $dia = '15 - 30';
            break;
        default:
            $dia = $dato_dia;
            break;
      }

      $unidadNegocio ='<h4>Unidad de Negocio: '.$nombre_unidad_negocio.'</h4>';
      $sucursal ='<h4>Sucursal: '.$nombre_sucursal.'</h4>';

      $datos_cotizacion = '<table border=1; width="600px;">';
      $datos_cotizacion .= '<tr><td colspan="2"><h4>Datos de la cotización</h4></td></tr>';
      $datos_cotizacion .= '<tr><td width="50%">Cotizacion</td><td width="50%">'.$nombre_cotizacion.'</td></tr>';
      $datos_cotizacion .= '<tr><td width="50%">Folio Cotizacion</td><td width="50%">'.$folioCotizacion.'</td></tr>';
      $datos_cotizacion .= '<tr><td>Inicio Fcacturación</td><td>'.$fecha_inicio_facturacion.'</td></tr>';
      $datos_cotizacion .= '<tr><td>Tipo Facturación</td><td>'.$tipo_facturacion.'</td></tr>';
      $datos_cotizacion .= '<tr><td>Periodicidad</td><td>'.$periodicidad.'</td></tr>';
      $datos_cotizacion .= '<tr><td>Día</td><td>'.$dia.'</td></tr>';
      $datos_cotizacion .= '<tr><td>Firmante</td><td>'.$nombre_firmante.'</td></tr>';
      $datos_cotizacion .= '<tr><td>Razón Social Emisora</td><td>'.$razon_social_emisora.'</td></tr>';
      $datos_cotizacion .= '</table>';

      $resumen_inversion ='<table border=1; width="600px;">';
      $resumen_inversion .='<tr><td colspan="2"><h4>Resumen Inversión</h4></td></tr>';
      $resumen_inversion .='<tr><td width="50%">Costo Mensual</td><td width="50%">'.$this-> dosDecimales($costo_mensual).'</td></tr>';
      $resumen_inversion .='<tr><td>Precio Mensual</td><td>'.$this-> dosDecimales($precio_mensual).'</td></tr>';
      $resumen_inversion .='<tr><td>Inversión Inicial Secorp</td><td>'.$this-> dosDecimales($inversion_secorp).'</td></tr>';
      $resumen_inversion .='<tr><td>Inversión Inicial Cliente</td><td>'.$this-> dosDecimales($inversion_cliente).'</td></tr>';
      $resumen_inversion .='<tr><td>Utilidad Primer Año</td><td>'.$this-> dosDecimales($utilidad_primer_anio).'</td></tr>';
      $resumen_inversion .='<tr><td>Retorno Inversión</td><td>'.$retorno_inversion.'</td></tr>';
      $resumen_inversion .='<tr><td>Utilidad Bruta Mensual</td><td>'.$this-> dosDecimales($utilidad_bruta_mensual).'</td></tr>';
      $resumen_inversion .='<tr><td>Utilidad Por Elemento</td><td>'.$this-> dosDecimales($utilidad_elemento).'</td></tr>';
      $resumen_inversion .='<tr><td>Porcentaje de Utilidad Final</td><td>'.$this-> dosDecimales($porcentaje_utilidad_final).'%</td></tr>';
      $resumen_inversion .='</table>';

      $busca_elementos = "SELECT a.id,a.sueldo,a.bono,a.tiempo_extra,a.otros,a.observaciones,a.cantidad,a.vacaciones,a.aguinaldo,
                              a.festivo,a.dia_31,a.administrativo,a.infonavit,a.imss,a.costo,a.costo_total,a.precio,a.precio_total,a.id_salario,
                              d.puesto
                              FROM cotizacion_elementos a
                              LEFT JOIN cat_salarios c ON a.id_salario=c.id
                              LEFT JOIN cat_puestos d ON c.id_puesto=d.id_puesto
                              WHERE a.id_cotizacion=".$idCotizacion."
                              ORDER BY d.puesto";
      $result_elementos = mysqli_query($this->link,$busca_elementos) or die(mysqli_error());
      $num_ele = mysqli_num_rows($result_elementos);
      if($num_ele > 0)
      {
        $elementos = '<table border=1; width="850px;">';
        $elementos .= '<tr><td colspan="17"><h4>Elementos</h4></td></tr>';
        $elementos .='<tr><td>PUESTO</td><td>CANTIDAD</td><td>SUELDO</td><td>BONO</td><td>TIEMPO EXTRA</td>';
        $elementos .='<td>OTROS</td><td>VACACIONES</td><td>AGUINALDO</td><td>FESTIVO</td><td>DÍA 31</td><td>COSTO ADMINISTRATIVO</td>';
        $elementos .='<td>INFONAVIT</td><td>IMSS</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td><td>PRECIO UNITARIO</td><td>PRECIO TOTAL</td></tr>';
        
        $elementosCosto = '<table border=1; width="850px;">';
        $elementosCosto .= '<tr><td colspan="15"><h4>Elementos</h4></td></tr>';
        $elementosCosto .='<tr><td>PUESTO</td><td>CANTIDAD</td><td>SUELDO</td><td>BONO</td><td>TIEMPO EXTRA</td>';
        $elementosCosto .='<td>OTROS</td><td>VACACIONES</td><td>AGUINALDO</td><td>FESTIVO</td><td>DÍA 31</td><td>COSTO ADMINISTRATIVO</td>';
        $elementosCosto .='<td>INFONAVIT</td><td>IMSS</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td></tr>';
        while($row_ele = mysqli_fetch_array($result_elementos))
        {
          $idElemento = $row_ele['id'];
          $puesto = $row_ele['puesto']; 
          $cantidad = $row_ele['cantidad'];
          $sueldo = $row_ele['sueldo'];
          $bono = $row_ele['bono'];
          $tiempo_extra = $row_ele['tiempo_extra'];
          $otros = $row_ele['otros'];
          $vacaciones = $row_ele['vacaciones'];
          $aguinaldo = $row_ele['aguinaldo'];
          $festivo = $row_ele['festivo'];
          $dia31 = $row_ele['dia_31'];
          $administrativo = $row_ele['administrativo'];
          $infonavit = $row_ele['infonavit'];
          $imss = $row_ele['imss'];
          $costo = $row_ele['costo'];
          $costo_total = $row_ele['costo_total'];
          $precio = $row_ele['precio'];
          $precio_total = $row_ele['precio_total'];

          $elementos .='<tr><td>'.$puesto.'</td><td>'.$cantidad.'</td><td>'.$sueldo.'</td><td>'.$bono.'</td>';
          $elementos .='<td>'.$tiempo_extra.'</td><td>'.$otros.'</td><td>'.$vacaciones.'</td><td>'.$aguinaldo.'</td>';
          $elementos .='<td>'.$festivo.'</td><td>'.$dia31.'</td><td>'.$administrativo.'</td><td>'.$infonavit.'</td><td>'.$imss.'</td>';
          $elementos .='<td>'.$costo.'</td><td>'.$costo_total.'</td><td>'.$precio.'</td><td>'.$precio_total.'</td></tr>';

          $elementosCosto .='<tr><td>'.$puesto.'</td><td>'.$cantidad.'</td><td>'.$sueldo.'</td><td>'.$bono.'</td>';
          $elementosCosto .='<td>'.$tiempo_extra.'</td><td>'.$otros.'</td><td>'.$vacaciones.'</td><td>'.$aguinaldo.'</td>';
          $elementosCosto .='<td>'.$festivo.'</td><td>'.$dia31.'</td><td>'.$administrativo.'</td><td>'.$infonavit.'</td><td>'.$imss.'</td>';
          $elementosCosto .='<td>'.$costo.'</td><td>'.$costo_total.'</td></tr>';

          $busca_uniformes = "SELECT a.id,a.id_uniforme,a.cantidad,b.nombre,b.descripcion,--b.costo
                                a.costo_unitario AS costo,a.costo_total,a.costo_unitario_mensual
                                FROM uniformes_elementos a
                                LEFT JOIN cat_uniformes b ON a.id_uniforme=b.id
                                WHERE a.id_elemento=".$idElemento."
                                ORDER BY b.nombre";
          $result_uniformes = mysqli_query($this->link,$busca_uniformes) or die(mysqli_error());
          $num_eniformes = mysqli_num_rows($result_uniformes);
          if($num_eniformes > 0)
          {
            $uniformes = '<table border=1; width="600px;">';
            $uniformes .= '<tr><td colspan="4"><h4>Uniformes</h4></td></tr>';
            $uniformes .='<tr><td>CANTIDAD</td><td>NOMBRE</td><td>DESCRIPCIÓN</td><td>COSTO</td></tr>';

            $uniformesSinCP = '<table border=1; width="600px;">';
            $uniformesSinCP .= '<tr><td colspan="3"><h4>Uniformes</h4></td></tr>';
            $uniformesSinCP .='<tr><td>CANTIDAD</td><td>NOMBRE</td><td>DESCRIPCIÓN</td></tr>';
            
            while($row_uniformes = mysqli_fetch_array($result_uniformes))
            {
              $cantidad = $row_uniformes['cantidad']; 
              $nombre = $row_uniformes['nombre'];
              $descripcion = $row_uniformes['descripcion'];
              $costo = $row_uniformes['costo'];

              $uniformes .='<tr><td>'.$cantidad.'</td><td>'.$nombre.'</td><td>'.$descripcion.'</td><td>'.$costo.'</td></tr>';
              $uniformesSinCP .='<tr><td>'.$cantidad.'</td><td>'.$nombre.'</td><td>'.$descripcion.'</td></tr>';
            }
            $uniformes .= '</table>';
            $uniformesSinCP .= '</table>';
          }

        }
        $elementos .= '</table>';
        $elementosCosto .= '</table>';
      }

      $busca_num_elementos = "SELECT COUNT(a.id_salario) AS num_elementos,d.puesto,a.sueldo
                                FROM cotizacion_elementos a
                                LEFT JOIN cat_salarios c ON a.id_salario=c.id
                                LEFT JOIN cat_puestos d ON c.id_puesto=d.id_puesto
                                WHERE a.id_cotizacion=".$idCotizacion."
                                GROUP BY a.id_salario ORDER BY d.puesto";
      $result_num_elementos = mysqli_query($this->link,$busca_num_elementos) or die(mysqli_error());
      $num_ele2 = mysqli_num_rows($result_num_elementos);
      if($num_ele2 > 0)
      {
        $num_elementos = '<table border=1; width="600px;">';
        $num_elementos .= '<tr><td colspan="2"><h4>Elementos</h4></td></tr>';
        $num_elementos .='<tr><td>CANTIDAD</td><td>PUESTO</td></tr>';

        $elementosSueldoMensual = '<table border=1; width="600px;">'; 
        $elementosSueldoMensual .= '<tr><td colspan="3"><h4>Elementos</h4></td></tr>';
        $elementosSueldoMensual .='<tr><td>CANTIDAD</td><td>PUESTO</td><td>SUELDO MENSUAL</td></tr>';

        while($row_ele2 = mysqli_fetch_array($result_num_elementos))
        {
          $cantidad = $row_ele2['num_elementos'];
          $puesto = $row_ele2['puesto'];
          $sueldo = $row_ele2['sueldo'];

          $num_elementos .='<tr><td>'.$cantidad.'</td><td>'.$puesto.'</td></tr>';
          $elementosSueldoMensual .='<tr><td>'.$cantidad.'</td><td>'.$puesto.'</td><td>'.$sueldo.'</td></tr>';
        }

        $num_elementos .= '</table>';
        $elementosSueldoMensual .= '</table>';
      }

      $busca_servicios = "SELECT a.id,a.nombre,IF(a.tipo_pago=1,'Pago Mensual','Pago Unico') AS tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.cantidad
                            FROM cotizacion_servicios a
                            LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                            WHERE a.id_cotizacion=".$idCotizacion."
                            ORDER BY a.nombre";
      $result_servicios = mysqli_query($this->link,$busca_servicios) or die(mysqli_error());
      $num_servicios = mysqli_num_rows($result_servicios);
      if($num_servicios > 0)
      {
        $servicios = '<table border=1; width="600px;">';
        $servicios .= '<tr><td colspan="7"><h4>Servicios</h4></td></tr>';
        $servicios .='<tr><td>SERVICIO</td><td>TIPO PAGO</td><td>CANTIDAD</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td><td>PRECIO UNITARIO</td><td>PRECIO TOTAL</td></tr>';
        
        $serviciosSinCP = '<table border=1; width="600px;">';
        $serviciosSinCP .= '<tr><td colspan="3"><h4>Servicios</h4></td></tr>';
        $serviciosSinCP .= '<tr><td>SERVICIO</td><td>TIPO PAGO</td><td>CANTIDAD</td></tr>';

        while($row_servicios = mysqli_fetch_array($result_servicios))
        {
          $nombre = $row_servicios['nombre'];
          $cantidad = $row_servicios['cantidad'];
          $tipo_pago = $row_servicios['tipo_pago'];
          $costo = $row_servicios['costo'];
          $costo_total = $row_servicios['costo_total'];
          $precio = $row_servicios['precio'];
          $precio_total = $row_servicios['precio_total'];

          $servicios .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td><td>'.$costo.'</td><td>'.$costo_total.'</td><td>'.$precio.'</td><td>'.$precio_total.'</td></tr>';
          $serviciosSinCP .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td></tr>';
        }

        $servicios .= '</table>';
        $serviciosSinCP .= '</table>';
      }

      $busca_vehiculos = "SELECT a.id,a.nombre,IF(a.tipo_pago=1,'Pago Mensual','Pago Unico') AS tipo_pago,a.costo,a.precio,a.costo_total,a.precio_total,a.cantidad
                            FROM cotizacion_vehiculos a
                            LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                            WHERE a.id_cotizacion=".$idCotizacion."
                            ORDER BY a.nombre";
      $result_vehiculos = mysqli_query($this->link,$busca_vehiculos) or die(mysqli_error());
      $num_vehiculos = mysqli_num_rows($result_vehiculos);
      if($num_vehiculos > 0)
      {
        $vehiculos = '<table border=1; width="600px;">';
        $vehiculos .= '<tr><td colspan="7"><h4>Vehiculos</h4></td></tr>';
        $vehiculos .='<tr><td>VEHICULO</td><td>TIPO PAGO</td><td>CANTIDAD</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td><td>PRECIO UNITARIO</td><td>PRECIO TOTAL</td></tr>';
        
        $vehiculosSinCP = '<table border=1; width="600px;">';
        $vehiculosSinCP .= '<tr><td colspan="3"><h4>Vehiculos</h4></td></tr>';
        $vehiculosSinCP .='<tr><td>VEHICULO</td><td>TIPO PAGO</td><td>CANTIDAD</td></tr>';

        $vehiculosCosto = '<table border=1; width="600px;">';
        $vehiculosCosto .= '<tr><td colspan="5"><h4>Vehiculos</h4></td></tr>';
        $vehiculosCosto .='<tr><td>VEHICULO</td><td>TIPO PAGO</td><td>CANTIDAD</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td></tr>';

        while($row_vehiculos = mysqli_fetch_array($result_vehiculos))
        {
          $nombre = $row_vehiculos['nombre'];
          $cantidad = $row_vehiculos['cantidad'];
          $tipo_pago = $row_vehiculos['tipo_pago'];
          $costo = $row_vehiculos['costo'];
          $costo_total = $row_vehiculos['costo_total'];
          $precio = $row_vehiculos['precio'];
          $precio_total = $row_vehiculos['precio_total'];

          $vehiculos .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td><td>'.$costo.'</td><td>'.$costo_total.'</td><td>'.$precio.'</td><td>'.$precio_total.'</td></tr>';
          $vehiculosSinCP .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td></tr>';
          $vehiculosCosto .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td><td>'.$costo.'</td><td>'.$costo_total.'</td></tr>';
        }

        $vehiculos .= '</table>';
        $vehiculosSinCP .= '</table>';
        $vehiculosCosto .= '</table>';
      }

      $busca_equipo = "SELECT a.id,a.nombre,IF(a.tipo_pago=1,'Pago Mensual','Pago Unico') AS tipo_pago,
                        a.costo,a.precio,a.costo_total,a.precio_total,a.cantidad,a.prorratear
                        FROM cotizacion_equipo a
                        LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                        WHERE a.id_cotizacion=".$idCotizacion."
                        ORDER BY a.nombre";
      $result_equipo = mysqli_query($this->link,$busca_equipo) or die(mysqli_error());
      $num_equipo = mysqli_num_rows($result_equipo);
      if($num_equipo > 0)
      {
        $equipo = '<table border=1; width="600px;">';
        $equipo .= '<tr><td colspan="7"><h4>Equipo</h4></td></tr>';
        $equipo .='<tr><td>EQUIPO</td><td>TIPO PAGO</td><td>CANTIDAD</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td><td>PRECIO UNITARIO</td><td>PRECIO TOTAL</td></tr>';
        
        $equipoSinCP = '<table border=1; width="600px;">';
        $equipoSinCP .= '<tr><td colspan="3"><h4>Equipo</h4></td></tr>';
        $equipoSinCP .='<tr><td>EQUIPO</td><td>TIPO PAGO</td><td>CANTIDAD</td></tr>';

        $equipoCosto = '<table border=1; width="600px;">';
        $equipoCosto .= '<tr><td colspan="5"><h4>Equipo</h4></td></tr>';
        $equipoCosto .='<tr><td>EQUIPO</td><td>TIPO PAGO</td><td>CANTIDAD</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td></tr>';

        while($row_equipo = mysqli_fetch_array($result_equipo))
        {
          $nombre = $row_equipo['nombre'];
          $cantidad = $row_equipo['cantidad'];
          $tipo_pago = $row_equipo['tipo_pago'];

          $prorratear = $row_equipo['prorratear'];
          if($prorratear == 0)
          {
            $costo = $row_equipo['costo'];
            $costo_total = $row_equipo['costo_total'];
            $precio = $row_equipo['precio'];
            $precio_total = $row_equipo['precio_total'];
          }else{
            $costo = 0;
            $costo_total = 0;
            $precio = 0;
            $precio_total = 0;
          }

          $equipo .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td><td>'.$costo.'</td><td>'.$costo_total.'</td><td>'.$precio.'</td><td>'.$precio_total.'</td></tr>';
          $equipoSinCP .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td></tr>';
          $equipoCosto .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td><td>'.$costo.'</td><td>'.$costo_total.'</td></tr>';
        }

        $equipo .= '</table>';
        $equipoSinCP .= '</table>';
        $equipoCosto .= '</table>';
      }

      $busca_consumibles = "SELECT a.id,a.nombre,IF(a.tipo_pago=1,'Pago Mensual','Pago Unico') AS tipo_pago,
                        a.costo,a.precio,a.costo_total,a.precio_total,a.cantidad,a.prorratear
                        FROM cotizacion_consumibles a
                        LEFT JOIN cotizacion b ON a.id_cotizacion=b.id
                        WHERE a.id_cotizacion=".$idCotizacion."
                        ORDER BY a.nombre";
      $result_consumibles = mysqli_query($this->link,$busca_consumibles) or die(mysqli_error());
      $num_consumibles = mysqli_num_rows($result_consumibles);
      if($num_consumibles > 0)
      {
        $consumibles = '<table border=1; width="600px;">';
        $consumibles .= '<tr><td colspan="7"><h4>Consumibles</h4></td></tr>';
        $consumibles .='<tr><td>EQUIPO</td><td>TIPO PAGO</td><td>CANTIDAD</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td><td>PRECIO UNITARIO</td><td>PRECIO TOTAL</td></tr>';

        $consumiblesCosto = '<table border=1; width="600px;">';
        $consumiblesCosto .= '<tr><td colspan="5"><h4>Consumibles</h4></td></tr>';
        $consumiblesCosto .='<tr><td>EQUIPO</td><td>TIPO PAGO</td><td>CANTIDAD</td><td>COSTO UNITARIO</td><td>COSTO TOTAL</td></tr>';

        while($row_consumibles = mysqli_fetch_array($result_consumibles))
        {
          $nombre = $row_consumibles['nombre'];
          $cantidad = $row_consumibles['cantidad'];
          $tipo_pago = $row_consumibles['tipo_pago'];

          $prorratear = $row_consumibles['prorratear'];
          if($prorratear == 0)
          {
            $costo = $row_consumibles['costo'];
            $costo_total = $row_consumibles['costo_total'];
            $precio = $row_consumibles['precio'];
            $precio_total = $row_consumibles['precio_total'];
          }else{
            $costo = 0;
            $costo_total = 0;
            $precio = 0;
            $precio_total = 0;
          }

          $consumibles .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td><td>'.$costo.'</td><td>'.$costo_total.'</td><td>'.$precio.'</td><td>'.$precio_total.'</td></tr>';
          $consumiblesCosto .='<tr><td>'.$nombre.'</td><td>'.$tipo_pago.'</td><td>'.$cantidad.'</td><td>'.$costo.'</td><td>'.$costo_total.'</td></tr>';
        }

        $consumibles .= '</table>';
        $consumiblesCosto .= '</table>';
      }
      
      $query_correos="SELECT tesoreria,recursos_humanos,operaciones,compras,activos_fijos
                        FROM cat_plantillas_cotizacion
                        WHERE id_unidad_negocio=".$idUnidadNegocio;
      $result_correos = mysqli_query($this->link,$query_correos) or die(mysqli_error());
      $num_correos = mysqli_num_rows($result_correos);
      
      if($num_correos > 0)
      {
        while($row_correos = mysqli_fetch_array($result_correos))
        {
          $tesoreria=$row_correos['tesoreria'];
          $recursos_humanos=$row_correos['recursos_humanos'];
          $operaciones=$row_correos['operaciones'];
          $compras=$row_correos['compras'];
          $activos_fijos=$row_correos['activos_fijos'];

          if($tesoreria != '')
          {
            $mensaje = '<html><body>';
            $mensaje .= $unidadNegocio;
            $mensaje .= $sucursal;
            $mensaje .= $datos_cotizacion.'<br>';
            $mensaje .= '<h4>Datos del Cliente</h4>'.$datos_cliente.'<br>';
            $mensaje .= $elementos.'<br>';
            $mensaje .= $uniformes.'<br>';
            $mensaje .= $equipo.'<br>';
            $mensaje .= $servicios.'<br>';
            $mensaje .= $vehiculos.'<br>';
            $mensaje .= $consumibles.'<br>';
            $mensaje .= $resumen_inversion;
            $mensaje .= '</body></html>';

            $verifica = $this -> enviarCorreoDatosSecciones($tesoreria,'Tesoreria Datos Cotización',$mensaje);
          }

          if($recursos_humanos != '')
          {
            $mensaje = '<html><body>';
            $mensaje .= $unidadNegocio;
            $mensaje .= $sucursal;
            $mensaje .= $datos_cotizacion.'<br>';
            $mensaje .= $num_elementos.'<br>';
            $mensaje .= $uniformesSinCP.'<br>';
            $mensaje .= $equipoSinCP.'<br>';
            $mensaje .= $serviciosSinCP;
            $mensaje .= '</body></html>';

            $verifica = $this -> enviarCorreoDatosSecciones($recursos_humanos,'Recursos Humanos Datos Cotización',$mensaje);
          }

          if($operaciones != '')
          {
            $mensaje = '<html><body>';
            $mensaje .= $unidadNegocio;
            $mensaje .= $sucursal;
            $mensaje .= $datos_cotizacion.'<br>';
            $mensaje .= '<h4>Datos del Cliente</h4>'.$datos_cliente.'<br>';
            $mensaje .= $elementosSueldoMensual.'<br>';
            $mensaje .= $uniformesSinCP.'<br>';
            $mensaje .= $equipoSinCP.'<br>';
            $mensaje .= $serviciosSinCP.'<br>';
            $mensaje .= $vehiculosSinCP.'<br>';
            $mensaje .= '</body></html>';

            $verifica = $this -> enviarCorreoDatosSecciones($operaciones,'Operaciones Datos Cotización',$mensaje);
          }

          if($compras != '')
          {
            $mensaje = '<html><body>';
            $mensaje .= $unidadNegocio;
            $mensaje .= $sucursal;
            $mensaje .= $datos_cotizacion.'<br>';
            $mensaje .= $elementosCosto.'<br>';
            $mensaje .= $uniformes.'<br>';
            $mensaje .= $equipoCosto.'<br>';
            $mensaje .= $vehiculosCosto.'<br>';
            $mensaje .= $consumiblesCosto.'<br>';
            $mensaje .= '</body></html>';

            $verifica = $this -> enviarCorreoDatosSecciones($compras,'Compras Datos Cotización',$mensaje);
          }

          if($activos_fijos != '')
          {
            $mensaje = '<html><body>';
            $mensaje .= $unidadNegocio;
            $mensaje .= $sucursal;
            $mensaje .= $datos_cotizacion.'<br>';
            $mensaje .= $equipo.'<br>';
            $mensaje .= $vehiculos.'<br>';
            $mensaje .= '</body></html>';

            $verifica = $this -> enviarCorreoDatosSecciones($activos_fijos,'Activos Fijos Datos Cotización',$mensaje);
          }
        }

      }else{
        //$verifica = 'Se enviaron los datos de la cotizacion';
        $mensajeGlobalAC .= ' Se enviaron los datos de la cotización. </br>';
        $verifica = array('verifica'=>true,'mensaje'=>$mensajeGlobalAC);
      }

      return $verifica;
    }//--fin function buscaCorreosSecciones

    /** 
      * 
      * Envia por correo los datos a cada area
      *
      * @param varchar $correos correos a donde se enviara el email
      * @param varchar $asunto que se enviara en el email
      * @param varchar $mensaje contenido del email
      *
      **/
    function enviarCorreoDatosSecciones($correos,$asunto,$mensaje){
      
      include_once("../vendor/lib_mail/class.phpmailer.php");
      include_once("../vendor/lib_mail/class.smtp.php");

      $verifica = array('verifica'=>false);

      $dest_mail=$correos;
      $destinatarios = explode(',',$dest_mail);

      $asunto = $asunto;

      $mail = new PHPMailer();
      $mail->CharSet = 'UTF-8';
      $mail->IsSMTP();
      $mail->IsHTML(true);	
      $mail->SMTPSecure = "TLS";
      $mail->SMTPAuth = true;
      
      $mail->Host = "denken.mx";
      $mail->Port = 26;
      $mail->Username = "noreply@denken.mx";
      $mail->Password = "Martinika8%#";	
      $mail->SetFrom("noreply@denken.mx",$asunto);
      
      $mail->Subject = $asunto;
     
      $mail->MsgHTML($mensaje);

      for($i = 0; $i < count($destinatarios); $i++)
      {
          $mail->AddAddress($destinatarios[$i], $asunto);	
      }

      
      if(!$mail->Send()){
          //Error al enviar
          //$verifica = 'Estatus generado con cotización. Error al enviar '.$asunto;
          $mensajeGlobalAC .= ' Estatus generado con cotización. Error al enviar '.$asunto.' </br>';
          $verifica = array('verifica'=>true,'mensaje'=>$mensajeGlobalAC);
      }else{
          //Datos Enviados
          //$verifica = 'Se enviaron los datos de la cotización';
          $mensajeGlobalAC .= ' Se enviaron los datos de la cotización. </br>';
          $verifica = array('verifica'=>true,'mensaje'=>$mensajeGlobalAC);
      }
      
      return $verifica;
    }//--fin function enviarCorreoDatosSecciones

    /** 
      * 
      * Envia por correo los datos de usuario que creo la cotizacion y datos del cliente de la
      * cotización porque el porcentaje es menor al asignado para la unidad de negocio y la sucursal
      * El correo se envia para que la persona pueda autorizar la cotización o no
      *
      * @param int $idCotizacion de la cotizacion
      * @param float $utilidad que se genero en la cotizacion
      * @param float $porcentajeUtilidad asignado a la unidad negocio y sucursal
      *
      **/
    function enviarNotificacionPorcentajeUtilidad($idCotizacion,$utilidad,$porcentajeUtilidad){
      include_once("../vendor/lib_mail/class.phpmailer.php");
      include_once("../vendor/lib_mail/class.smtp.php");

      $verifica = '';

      $busca_datos="SELECT a.nombre AS cotizacion,a.folio,b.nombre_comp AS nombre_usuario,c.nombre_comercial,c.nombre AS cliente,c.razon_social,c.rfc
                      FROM cotizacion a 
                      LEFT JOIN usuarios b ON a.id_usuario=b.id_usuario
                      LEFT JOIN pre_clientes c ON a.id_cliente=c.id
                      WHERE a.id=".$idCotizacion;
      $result = mysqli_query($this->link,$busca_datos) or die(mysqli_error());
      $num = mysqli_num_rows($result);
      
      if($num > 0)
      {
        $row = mysqli_fetch_array($result);

        $cotizacion = $row['cotizacion'];
        $folio = $row['folio'];
        $usuario = $row['nombre_usuario'];
        $cliente = $row['cliente'];
        $nombre_comercial = $row['nombre_comercial'];
        $razon_social = $row['razon_social'];
        $rfc = $row['rfc'];

        $fecha = date('Y').''.date('m').''.date('d');

        $dest_mail='ne@denken.mx,mh@denken.mx,soporte@denken.mx';
        $destinatarios = explode(',',$dest_mail);

        $asunto = 'Autorización de cotizacion con Porcentaje Utilidad menor';

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP();
        $mail->IsHTML(true);	
        $mail->SMTPSecure = "TLS";
        $mail->SMTPAuth = true;
        
        $mail->Host = "denken.mx";
        $mail->Port = 26;
        $mail->Username = "noreply@denken.mx";
        $mail->Password = "Martinika8%#";	
        $mail->SetFrom("noreply@denken.mx",$asunto);
        
        $mail->Subject = $asunto;
        //$miArray=array("azul","4 puertas","motores"=>array("1500", "2000"));
        $datosAutorizar = urlencode($idCotizacion.''.$fecha.'-'.$dest_mail.'['.$porcentajeUtilidad.']'.$utilidad);

        $mensaje = '<html><body>';
        $mensaje .= '<p>Se te notifica que el usuario: '.$usuario.' creó la cotización: '.$cotizacion.' con folio: '.$folio.'</p>';
        $mensaje .= '<p>para el cliente: '.$cliente.'. Con nombre comercial '.$nombre_comercial.', razon social: '.$razon_social.' y RFC: '.$rfc.'.</p>';
        $mensaje .= '<p>Para la cual se tiene asignado un porcentaje de utilidad de: '.$porcentajeUtilidad.'% y solicita un: '.$utilidad.'%</p>';
        //$mensaje .= '<br><a href="http://localhost/ginthercorp/fr_autorizar_PU.php?datos='.$idCotizacion.''.$fecha.'-'.$dest_mail.'" type="button">Autorizar</a>';
        //$mensaje .= '<br><a href="http://localhost/ginthercorp/fr_autorizar_PU.php?datos='.$datosAutorizar.'" type="button">Autorizar</a>';
        $mensaje .= '<br><a href="https://denken.com.mx:166/corporativo_ginther/fr_autorizar_PU.php?datos='.$datosAutorizar.'" type="button">Autorizar</a>';
        $mensaje .= '</body></html>';
      
        $mail->MsgHTML($mensaje);

        for($i = 0; $i < count($destinatarios); $i++)
        {
            $mail->AddAddress($destinatarios[$i], $asunto);	
        }

        
        if(!$mail->Send()){
            //Error al enviar
            $verifica = 'Error al enviar';
        }else{
            //Datos Enviados
            $verifica = 'Se enviaron los datos de la cotización para que se apruebe';
        }
      }else{
        $verifica = 'Sin datos para enviar';
      }
      
      return $verifica;
    }//--fin function enviarNotificacionPorcentajeUtilidad

    /** 
      *Busca si la cotizacion ya fue aprobada 
      * @param int $idCotizacion id de la cotizacion que se quiere verificar
    **/
    function verificarCotizacionesAprobada($idCotizacion){
      $result = $this->link->query("SELECT a.estatus AS estatus_cotizacion,b.estatus AS estatus_proyecto
                                      FROM cotizacion a
                                      LEFT JOIN proyecto b ON a.id_proyecto=b.id
                                      WHERE a.id='$idCotizacion'");

      return query2json($result);
    }//--fin function verificarCotizacionesAprobada

    /** 
      *Guarda la comision de la cotizacion 
      * @param varchar $datos array que contiene los datos para guardar
    **/
    function guardarCotizacionesComision($datos){
      $verifica = 0;
    
     $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> actualizaComision($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
    }//--fin function guardarCotizacionesComision

    function actualizaComision($datos){
      $verifica=0;

      $idCotizacion = $datos['idCotizacion'];
      $comision = $datos['comision'];

      $query = "UPDATE cotizacion SET comision=$comision WHERE id=".$idCotizacion;
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
            
      if($result){
        $verifica = 1;
      }else{
        $verifica = 0; 
      }

      return $verifica;
    }//--fin function actualizaComision

    function dosDecimales($number, $fractional=true) { 
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
        return $number; 
    }//--fin function dosDecimales


        /**
      * Buscar los datos de cotizacion segun el filtro ingresado por el suario
      *
      * @param int $filtroCliente recibe id cliente para buscar todas las cotizaciones realizadas a ese cliente
      * @param int $filtroProyecto recibe id proyecto para buscar todas las cotizaciones realizadas en ese proyecto
      * @param int $filtroSucursal id de la sucursal de una unidad actual
      * @param int $filtroUsuario muestra todos los usuarios dados de alta
      * @param int $filtroEstatus id esttaus de la cotizacion todos= Todos 1=Proceso 2=Negociación 3=Rechazada 4=Aprobada
      *
    **/
    function buscarCotizacionesPorRfc($rfc){
        
      $result = $this->link->query("SELECT a.id,c.rfc,a.folio AS folio,a.nombre AS cotizacion,a.version,a.timestamp_version AS fecha_creacion,a.estatus AS estatus_cotizacion,c.nombre AS cliente,a.texto_inicio,a.texto_fin,
      b.descripcion AS proyecto,b.usuario_captura AS usuario,b.id_usuario,
      b.id_sucursal,d.descr AS sucursal,b.id_unidad_negocio,IF(b.estatus=1,'Proceso',IF(b.estatus=2,'Negociación',IF(b.estatus=3,'Rechazada','Aprobada'))) AS estatus_proyecto,e.nombre AS unidad_negocio,
      IFNULL(f.id_contrato,0) AS id_contrato
      FROM cotizacion a
      LEFT JOIN proyecto b ON a.id_proyecto=b.id
      LEFT JOIN pre_clientes c ON a.id_cliente=c.id
      LEFT JOIN sucursales d ON b.id_sucursal=d.id_sucursal
      LEFT JOIN cat_unidades_negocio e ON d.id_unidad_negocio=e.id
      LEFT JOIN  contratos_cliente f ON a.id = f.id_cotizacion
      WHERE c.rfc='$rfc' AND ISNULL(f.id_contrato) AND b.estatus=4 
      AND a.id_proyecto IN (SELECT MAX(id)
                                      FROM proyecto 
                                      GROUP BY id)
      GROUP BY a.id_proyecto
      ORDER BY a.id DESC");

        return query2json($result);
    }//--fin function buscarCotizacionesId


     /**
      * Buscar los datos de cotizacion segun el filtro ingresado por el suario
      *
      * @param int $filtroCliente recibe id cliente para buscar todas las cotizaciones realizadas a ese cliente
      * @param int $filtroProyecto recibe id proyecto para buscar todas las cotizaciones realizadas en ese proyecto
      * @param int $filtroSucursal id de la sucursal de una unidad actual
      * @param int $filtroUsuario muestra todos los usuarios dados de alta
      * @param int $filtroEstatus id esttaus de la cotizacion todos= Todos 1=Proceso 2=Negociación 3=Rechazada 4=Aprobada
      *
    **/
    function buscarCotizacionesReportes($datos){

      $fecha='';
      $fechaInicio = $datos['fechaInicio'];
      $fechaFin = $datos['fechaFin'];
      if($fechaInicio == '' && $fechaFin == '')
      {
        $fecha=" AND DATE(a.timestamp_version) >= DATE_SUB(CURRENT_DATE(),INTERVAL 30 DAY) ";
      }else if($fechaInicio != '' &&  $fechaFin == '')
      {
        $fecha=" AND DATE(a.timestamp_version) >= '$fechaInicio' ";
      }else{  //-->trae fecha inicio y fecha fin
        $fecha=" AND DATE(a.timestamp_version) >= '$fechaInicio' AND DATE(a.timestamp_version) <= '$fechaFin' ";
      }
        
      $result = $this->link->query("SELECT a.id,a.folio AS folio,a.nombre AS cotizacion,a.version,a.timestamp_version AS fecha_creacion,a.estatus AS estatus_cotizacion, ifnull(a.justificacion_rechazada,'') as justificacion_rechazada,c.nombre AS cliente,
                                          b.descripcion AS proyecto,b.usuario_captura AS usuario,b.id_usuario,
                                          b.id_sucursal,d.descr AS sucursal,b.id_unidad_negocio,IF(b.estatus=1,'Proceso',IF(b.estatus=2,'Negociación',IF(b.estatus=3,'Rechazada','Aprobada'))) AS estatus_proyecto,e.nombre AS unidad_negocio,

                                          (IFNULL(SUM(cotizacion_elementos.costo_total),0) +
                                          IFNULL(SUM(IF(cotizacion_equipo.tipo_pago = 1 AND cotizacion_equipo.prorratear = 0,cotizacion_equipo.costo_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_servicios.tipo_pago = 1,cotizacion_servicios.costo_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_vehiculos.tipo_pago = 1,cotizacion_vehiculos.costo_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_consumibles.tipo_pago = 1 AND cotizacion_consumibles.prorratear = 0,cotizacion_consumibles.costo_total,0)),0)) AS costo_total,

                                          (IFNULL(SUM(cotizacion_elementos.precio_total),0) +
                                          IFNULL(SUM(IF(cotizacion_equipo.tipo_pago = 1,cotizacion_equipo.precio_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_servicios.tipo_pago = 1,cotizacion_servicios.precio_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_vehiculos.tipo_pago = 1,cotizacion_vehiculos.precio_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_consumibles.tipo_pago = 1,cotizacion_consumibles.precio_total,0)),0)) AS precio_total,

                                          (IFNULL(SUM(IF(cotizacion_equipo.tipo_pago = 2 AND cotizacion_equipo.prorratear = 0,cotizacion_equipo.costo_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_servicios.tipo_pago = 2,cotizacion_servicios.costo_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_vehiculos.tipo_pago = 2,cotizacion_vehiculos.costo_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_consumibles.tipo_pago = 2 AND cotizacion_consumibles.prorratear = 0,cotizacion_consumibles.costo_total,0)),0)) AS inversion_secorp,

                                          (IFNULL(SUM(IF(cotizacion_equipo.tipo_pago = 2,cotizacion_equipo.precio_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_servicios.tipo_pago = 2,cotizacion_servicios.precio_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_vehiculos.tipo_pago = 2,cotizacion_vehiculos.precio_total,0)),0) +
                                          IFNULL(SUM(IF(cotizacion_consumibles.tipo_pago = 2,cotizacion_consumibles.precio_total,0)),0)) AS inversion_cliente
                                          
                                          FROM cotizacion a
                                          LEFT JOIN proyecto b ON a.id_proyecto=b.id
                                          LEFT JOIN pre_clientes c ON a.id_cliente=c.id
                                          LEFT JOIN sucursales d ON b.id_sucursal=d.id_sucursal
                                          LEFT JOIN cat_unidades_negocio e ON d.id_unidad_negocio=e.id
                                          LEFT JOIN cotizacion_elementos ON a.id=cotizacion_elementos.id_cotizacion
                                          LEFT JOIN cotizacion_equipo ON a.id=cotizacion_equipo.id_cotizacion
                                          LEFT JOIN cotizacion_servicios ON a.id=cotizacion_servicios.id_cotizacion
                                          LEFT JOIN cotizacion_vehiculos ON a.id=cotizacion_vehiculos.id_cotizacion
                                          LEFT JOIN cotizacion_consumibles ON a.id=cotizacion_consumibles.id_cotizacion
                                          WHERE 1=1 $fecha
                                          GROUP BY a.id
                                          ORDER BY a.id DESC");

        return query2json($result);
    }//--fin function buscarCotizacionesId

    function bitacoraAprobacion($datos){
      $verifica = 0;

      $correo = $datos['correo'];
      $utilidadUnidad = $datos['utilidadUnidad'];
      $utilidad = $datos['utilidad'];
      $idCotizacion = $datos['idCotizacion'];
      $idUsuario = $datos['idUsuario'];
      $usuario = $datos['usuario'];

      $query="INSERT INTO cotizacion_bitacora_autoriza(correo_autoriza,porcentaje_utilidad,porcentaje_autoriza,id_cotizacion,id_usuario,usuario) 
              VALUES('$correo','$utilidadUnidad','$utilidad','$idCotizacion','$idUsuario','$usuario')";
      $result = mysqli_query($this->link,$query) or die(mysqli_error());
      
      if($result)
        $verifica = 1;

      return $verifica;
    }

    function buscarObservacionesSecciones($idCotizacion){
      $result = $this->link->query("SELECT elementos_observaciones_externas,
                elementos_observaciones_internas,
                equipo_observaciones_externas,
                equipo_observaciones_internas,
                servicios_observaciones_externas,
                servicios_observaciones_internas,
                vehiculos_observaciones_externas,
                vehiculos_observaciones_internas,
                consumibles_observaciones_externas,
                consumibles_observaciones_internas
                FROM cotizacion
                WHERE id=".$idCotizacion);

      return query2json($result);
    }

    function actualizaObservacionesSecciones($datos){
      $verifica = 0;

      $idCotizacion = $datos['idCotizacion'];
      $tipo = $datos['tipo'];
      $observacionInterna = $datos['observacionesInternas'];
      $observacionExterna = $datos['observacionesGenerales'];

      $query='';
      switch($tipo)
      {
        case 'elemento':
          $query = "UPDATE cotizacion SET elementos_observaciones_externas='$observacionExterna',
                    elementos_observaciones_internas='$observacionInterna' 
                    WHERE id =".$idCotizacion;
        break;
        case 'equipo':
          $query = "UPDATE cotizacion SET equipo_observaciones_externas='$observacionExterna', 
                    equipo_observaciones_internas='$observacionInterna' 
                    WHERE id =".$idCotizacion;
        break;
        case 'servicio':
          $query = "UPDATE cotizacion SET servicios_observaciones_externas='$observacionExterna', 
                    servicios_observaciones_internas='$observacionInterna' 
                    WHERE id =".$idCotizacion;
        break;
        case 'vehiculo':
          $query = "UPDATE cotizacion SET vehiculos_observaciones_externas='$observacionExterna', 
                    vehiculos_observaciones_internas='$observacionInterna' 
                    WHERE id =".$idCotizacion;
        break;
        default:  //consumible
          $query = "UPDATE cotizacion SET consumibles_observaciones_externas='$observacionExterna', 
                    consumibles_observaciones_internas='$observacionInterna' 
                    WHERE id =".$idCotizacion;
        break;
      }

      $result=mysqli_query($this->link,$query)or die(mysqli_error());

      if ($result)
          $verifica = 1;
      
      return $verifica;
    }//-- fin function actualizaObservacionesSecciones

    function buscarCotizaciones($fechaInicio, $fechaFin){
      /*
      Sucursales
      23 - Secorp Alarmas
      57 - Seycom
      72 - Secorp IT
      */

      $query = "SELECT
                  cxc.id,
                  cxc.id_orden_servicio,
                  cxc.folio_venta,
                  cxc.id_venta,
                  cxc.folio_recibo,
                  (cxc.total - IFNULL(tabla.abonado, 0)) as total,
                  se.nombre_corto,
                  se.cuenta,
                  se.telefonos,
                  cxc.fecha
                FROM cxc
                LEFT JOIN servicios se ON cxc.id_razon_social_servicio = se.id
                LEFT JOIN (
                  SELECT SUM(monto_ingresado) AS abonado, folio_cxc
                  FROM cxc_bitacora
                  GROUP BY folio_cxc
                ) AS tabla ON tabla.folio_cxc = cxc.folio_cxc 
                WHERE cxc.id_sucursal IN (23, 57, 72)
                AND cxc.fecha_captura BETWEEN '$fechaInicio' AND '$fechaFin'
                AND (cxc.folio_venta <> 0 OR cxc.folio_recibo <> 0 OR cxc.id_orden_servicio <> 0)
                AND cxc.estatus IN ('T', 'A')";

      $result = $this->link->query($query);

      return query2json($result);
    }//--fin function buscarCotizaciones

    function buscarCotizacionesCuenta($idCotiz){

      $query = "SELECT
                  se.nombre_corto AS cuentaNombre,
                  se.cuenta AS cuentaNum,
                  scp.descripcion AS cuentaPlan,
                  se.telefonos cuentaTel,
                  CONCAT_WS(' ', se.domicilio, se.no_exterior, se.codigo_postal) cuentaDirec,
                  se.colonia cuentaCol,
                  (cxc.total - IFNULL(tabla.abonado, 0)) as importe,
                  se.latitud,
                  se.longitud
                FROM cxc
                LEFT JOIN servicios se ON cxc.id_razon_social_servicio = se.id
                LEFT JOIN servicios_cat_planes scp ON se.id_plan = scp.id
                LEFT JOIN (
                  SELECT SUM(monto_ingresado) AS abonado, folio_cxc
                  FROM cxc_bitacora
                  GROUP BY folio_cxc
                ) AS tabla ON tabla.folio_cxc = cxc.folio_cxc 
                WHERE cxc.id = $idCotiz";

      $result = $this->link->query($query);

      return query2json($result);
    }//--fin function buscarCotizacionesCuenta

    function buscarCotizacionesCuentaHistorial($idCotiz){

      $query = "SELECT
                  DATE(cxc.fecha_corte_recibo) AS fecha_corte_recibo,
                  DATE(cxc.fecha_captura) AS fecha_captura,
                  IFNULL(DATE(pe.fecha_captura), '-') AS fecha_pago,
                  cxc.total AS importe
                FROM cxc
                LEFT JOIN pagos_e pe ON cxc.id_pago = pe.id
                WHERE cxc.id_razon_social_servicio = (SELECT id_razon_social_servicio FROM cxc WHERE id = $idCotiz)";

      $result = $this->link->query($query);

      return query2json($result);
    }//--fin function buscarCotizacionesCuentaHistorial

    function buscarCotizacionesCuentaComentarios($idCotiz){

      $query = "SELECT
                  bc.fecha_captura AS fecha,
                  us.usuario,
                  bc.comentario
                FROM bitacora_cobranza bc
                INNER JOIN usuarios us ON us.id_usuario = bc.fk_usuario
                WHERE fk_id_cxc = $idCotiz";

      $result = $this->link->query($query);

      return query2json($result);
    }//--fin function buscarCotizacionesCuentaComentarios

    function guardarCotizacionesCuentaComentarios($idCotiz, $comentario){

      $idUsuario = $_SESSION["id_usuario"];

      $query = "INSERT INTO bitacora_cobranza (comentario, fk_usuario, fk_id_cxc)
                VALUES ('$comentario', $idUsuario, $idCotiz);";

      $result = $this->link->query($query);

      return ($result);
    }//--fin function guardarCotizacionesCuentaComentarios

    function pagarCotizacionesCuenta($idCotiz, $montoPago, $forma, $tipo, $cuenta, $referencia){

      $query = "SELECT *
                FROM cxc
                WHERE id = $idCotiz";

      $detalleCxc = $this->link->query($query);

      $query = "SELECT *
                FROM cuentas_bancos
                WHERE id = $cuenta";

      $detalleCuenta = $this->link->query($query);

      $query = "SELECT *
                FROM conceptos_cxp
                WHERE id = $forma";

      $detalleForma = $this->link->query($query);

      $arregloBanco = $detalleCuenta->fetch_assoc();
      $arregloForma = $detalleForma->fetch_assoc();

      while($row = $detalleCxc->fetch_assoc()){
        $verifica = 0;

        $idCxC = $idCotiz;
        $idUnidadNegocio = $row['id_unidad_negocio'];
        $idSucursal = $row['id_sucursal'];
        $idRazonSocialReceptor = $row['id_razon_social'];
        $vencimiento = $row['vencimiento'];
        $tasaIva = $row['tasa_iva'];
        $mes = $row['mes'];
        $anio = $row['anio'];
        $idConcepto = $forma;
        $cveConcepto = $arregloForma['clave'];
        $fecha = $row['fecha'];
        $importe = $row['subtotal'];
        $totalIva = $row['iva'];
        $total = $row['total'];
        // $referencia = $row['referencia'];
        $idBanco = $arregloBanco['id_banco'];
        $idCuentaBanco = $cuenta;
        $idUsuario = $_SESSION['id_usuario'];
        $estatus = "S";
        $cargoInicial = 0;
        $idOrdenServicio = $row['id_orden_servicio'];
        $idRazonSocialServicio = $row['id_razon_social_servicio'];
        $facturar = isset($row['facturar']) ? $row['facturar'] : '0';
        //-->NJES March/18/2020 se agrega concepto cobro al generar cobro de orden servicio
        $conceptoCobro = isset($row['concepto_cobro']) ? $row['concepto_cobro'] : '';

        $observaciones = 'Pago';

        $query = "SELECT IFNULL(SUM(monto_ingresado), 0) AS yaPagado
                  FROM cxc_bitacora
                  WHERE folio_cxc = $idCotiz";

        $sumaBitacora = $this->link->query($query);

        if($sumaBitacora){
          $arregloBitacora = $sumaBitacora->fetch_assoc();

          $yaPagado = $arregloBitacora["yaPagado"];

          $restante = ($total - $yaPagado);
          $saldoDespues = ($restante - $montoPago);

          //[$montoPago, $yaPagado, $total]
          $query2 = "INSERT INTO cxc_bitacora(monto_inicial, monto_final, monto_ingresado, id_usuario_captura, folio_cxc, id_concepto, forma_pago, id_cuenta_banco, referencias)
                    VALUES($restante, $saldoDespues, $montoPago, $idUsuario, $idCotiz, $forma, '$tipo', $cuenta, '$referencia');";
          
          $result = mysqli_query($this->link, $query2) or die(mysqli_error($this->link));

          if($result){

            $arr=array(
              'idUnidadNegocio'=>$idUnidadNegocio,
              'idSucursal'=>$idSucursal,
              'importe'=>$montoPago,
              'idCuentaBanco'=>$idCuentaBanco,
              'idUsuario'=>$idUsuario,
              'categoria'=>'Seguimiento a Cobranza',
              'fechaAplicacion'=>$fecha
            );
            
            $verifica = $this -> guardarMovimientosBancos($idCotiz,$arr);

            if($montoPago == $restante){
              $queryU = "UPDATE cxc SET estatus='S' WHERE id=".$idCxC;
              $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());

              if($resultU){
                $query2 = "INSERT INTO cxc(id_unidad_negocio,id_sucursal,folio_cxc,id_razon_social,fecha,id_concepto,cve_concepto,tasa_iva,subtotal,iva,total,referencia,mes,anio,vencimiento,cargo_inicial,id_banco,id_cuenta_banco,estatus,usuario_captura,id_orden_servicio,id_razon_social_servicio,facturar,concepto_cobro,observaciones) 
                          VALUES ('$idUnidadNegocio','$idSucursal','$idCxC','$idRazonSocialReceptor','$fecha','$idConcepto','$cveConcepto','$tasaIva','$importe','$totalIva','$total','$referencia','$mes','$anio','$vencimiento','$cargoInicial','$idBanco','$idCuentaBanco','$estatus','$idUsuario','$idOrdenServicio','$idRazonSocialServicio','$facturar','$conceptoCobro','$observaciones')";
                
                $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
                if($result2){
                  $verifica = 1;
                }
              }
            }
          }
        }

        
        // $query2 = "INSERT INTO cxc(id_unidad_negocio,id_sucursal,folio_cxc,id_razon_social,fecha,id_concepto,cve_concepto,tasa_iva,subtotal,iva,total,referencia,mes,anio,vencimiento,cargo_inicial,id_banco,id_cuenta_banco,estatus,usuario_captura,id_orden_servicio,id_razon_social_servicio,facturar,concepto_cobro,observaciones) 
        //         VALUES ('$idUnidadNegocio','$idSucursal','$idCxC','$idRazonSocialReceptor','$fecha','$idConcepto','$cveConcepto','$tasaIva','$importe','$totalIva','$total','$referencia','$mes','$anio','$vencimiento','$cargoInicial','$idBanco','$idCuentaBanco','$estatus','$idUsuario','$idOrdenServicio','$idRazonSocialServicio','$facturar','$conceptoCobro','$observaciones')";
        
        // $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
        // $id = mysqli_insert_id($this->link);

        // if ($result2){
          
        //   $query="SELECT    
        //           IFNULL(SUM(IF(a.estatus NOT IN('C','P'),IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),((a.subtotal + a.iva) * -(1))),0)),0) AS saldo            
        //           FROM cxc a           
        //           WHERE a.folio_cxc=".$idCxC;

        //   $resultS=mysqli_query($this->link, $query);
        //   $numRows=mysqli_num_rows($resultS);

        //   if($numRows>0){

        //       $datoS = mysqli_fetch_array($resultS);
        //       $saldo= $datoS['saldo'];

        //       $arr=array(
        //           'idUnidadNegocio'=>$idUnidadNegocio,
        //           'idSucursal'=>$idSucursal,
        //           'importe'=>$total,
        //           'idCuentaBanco'=>$idCuentaBanco,
        //           'idUsuario'=>$idUsuario,
        //           'categoria'=>'Seguimiento a Cobranza',
        //           'fechaAplicacion'=>$fecha
        //       );
            
        //       if($saldo==0){

        //           $queryU = "UPDATE cxc SET estatus='S' WHERE id=".$idCxC;
        //           $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
        //           if($resultU){
        //               if(substr($cveConcepto,0,1)=='A')
        //               {
        //                 $verifica = $this -> guardarMovimientosBancos($id,$arr);

        //               }else
        //                   $verifica = $id; 
        //           }else{
        //               $verifica = 0;
        //           }

        //       }else{
        //           if(substr($cveConcepto,0,1)=='A')
        //           {
        //             $verifica = $this -> guardarMovimientosBancos($id,$arr);

        //           }else
        //               $verifica = $id;                        
        //       }
        //   }else{
        //       $verifica = $id;
        //   }

        // }else{
        // $verifica = 0;
        // }
      }

      return $verifica;
    }

    function guardarMovimientosBancos($idCxC,$datos){
      $verifica = 0;

      $idCuentaBanco = $datos['idCuentaBanco'];
      $idUsuario = $datos['idUsuario'];
      $importe = $datos['importe'];
      $categoria = $datos['categoria'];
      $fecha = $datos['fecha'];
      $fechaAplicacion = $datos['fechaAplicacion'];
      
      $query = "INSERT INTO movimientos_bancos(id_cuenta_banco,monto,tipo,id_usuario,observaciones,id_cxc,fecha_aplicacion) 
                VALUES ('$idCuentaBanco','$importe','A','$idUsuario','$categoria','$idCxC','$fechaAplicacion')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
      if($result)
          $verifica = $idCxC;          
      else
        $verifica = 0;
      

      return $verifica;
    }//- fin function guardarMovimientosBancos

}//--fin de class Cotizaciones
    
?>