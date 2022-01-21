<?php

include 'conectar.php';

class Servicios
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Servicios()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la cuenta del servicio no se repita
      *
      * @param varchar $cuenta  usada para indentificar en las Búsqueda de  un servicio
      *
    **/
    function verificarServicios($cuenta){
      
      $verifica = 0;

      $query = "SELECT id FROM servicios WHERE cuenta = '$cuenta'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaServicios

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una razon social
      *
    **/      
    function guardarServicios($datos){
      
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarServicios


     /**
      * Guarda los datos de una razon social, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del razon social para realizarla
      * @param varchar $clave es una clave para identificar una razon social en particular
      * @param varchar $descripcion brebe descripcion de una razon social
      * @param int $inactivo estatus de una razon social  1='activo' 0='Inactivo'  
      *
      **/ 
      function guardarActualizar($datos){
         
        $verifica = 0;

        $tipoMov = $datos[1]['tipoMov'];
        $idServicio = $datos[1]['idServicio'];
        $idSucursal = $datos[1]['idSucursal'];
        $cuenta = $datos[1]['cuenta'];
        $rfc = $datos[1]['rfc'];
        $nombreCorto = $datos[1]['nombreCorto'];
        $razonSocial = $datos[1]['razonSocial'];
        $representanteLegal = $datos[1]['representanteLegal'];
        $tasaIva = $datos[1]['tasaIva'];
        $activo = $datos[1]['activo'];

        $domicilio = $datos[1]['domicilio'];
        $numInt = $datos[1]['numInt'];
        $numExt = $datos[1]['numExt'];
        $codigoPostal = $datos[1]['codigoPostal'];
        $idPais = $datos[1]['idPais'];
        $idEstado = $datos[1]['idEstado'];
        $idMunicipio = $datos[1]['idMunicipio'];
        $colonia = $datos[1]['colonia'];

        $domicilioS = $datos[1]['domicilioS'];
        $numIntS = $datos[1]['numIntS'];
        $numExtS = $datos[1]['numExtS'];
        $codigoPostalS = $datos[1]['codigoPostalS'];
        $idPaisS = $datos[1]['idPaisS'];
        $idEstadoS = $datos[1]['idEstadoS'];
        $idMunicipioS = $datos[1]['idMunicipioS'];
        $coloniaS = $datos[1]['coloniaS'];
        $entreCallesS = $datos[1]['entreCallesS'];

        $telefonos = $datos[1]['telefonos'];
        $celular = $datos[1]['celular'];
        $extension = $datos[1]['extension'];
        $correos = $datos[1]['correos'];
        $contacto = $datos[1]['contacto'];
        $otrosContactos = $datos[1]['otrosContactos'];

        $idPlan = $datos[1]['idPlan'];
        $tipoReciboFactura = $datos[1]['tipoReciboFactura'];
        $tipoEntrega = $datos[1]['tipoEntrega'];
        $fechaCorte = $datos[1]['fechaCorte'];
        $tipoPago = $datos[1]['tipoPago'];
        $idUsuario = $datos[1]['idUsuario'];

        $usoCFDI = $datos[1]['usoCFDI'];
        $metodoPago = $datos[1]['metodoPago'];
        $formaPago = $datos[1]['formaPago'];
        $productoSAT = $datos[1]['productoSAT'];
        $nombreProducto = $datos[1]['nombreProducto'];
        $unidadSAT = $datos[1]['unidadSAT'];
        $nombreUnidad = $datos[1]['nombreUnidad'];
        $descripcion = $datos[1]['descripcion'];

        $digitosCuenta = $datos[1]['digitos_cuenta'];
        $especificacionesCobranza = $datos[1]['especificacionesCobranza'];

        $id_tipo_panel = isset($datos[1]['idTipoPanel']) ? $datos[1]['idTipoPanel'] : 0;

        if($tipoMov==0){

          $query = "INSERT INTO servicios(id_sucursal, cuenta, rfc, nombre_corto, razon_social,domicilio,no_exterior,no_interior,colonia,id_municipio,id_estado,id_pais,codigo_postal,otros_contactos,contacto,correos,telefonos,celular,ext,r_legal,id_plan,tipo_recibo_facura,entrega,dia_corte,pago,porcentaje_iva,id_usuario_captura,digitos_cuenta,domicilio_s,no_exterior_s,no_interior_s,colonia_s,id_municipio_s,id_estado_s,id_pais_s,codigo_postal_s,entre_calles_s,id_tipo_panel) 
          VALUES ('$idSucursal','$cuenta','$rfc','$nombreCorto', '$razonSocial','$domicilio','$numExt','$numInt','$colonia','$idMunicipio','$idEstado','$idPais','$codigoPostal','$otrosContactos','$contacto','$correos','$telefonos','$celular','$extension','$representanteLegal','$idPlan','$tipoReciboFactura','$tipoEntrega','$fechaCorte','$tipoPago','$tasaIva','$idUsuario','$digitosCuenta','$domicilioS','$numExtS','$numIntS','$coloniaS','$idMunicipioS','$idEstadoS','$idPaisS','$codigoPostalS','$entreCallesS','$id_tipo_panel')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idServicio = mysqli_insert_id($this->link);


        }else{

          $query = "UPDATE servicios SET
          id_sucursal='$idSucursal', 
          cuenta='$cuenta',
          rfc='$rfc',
          nombre_corto='$nombreCorto',
          razon_social='$razonSocial',
          domicilio='$domicilio', 
          no_exterior='$numExt',
          no_interior='$numInt',
          colonia='$colonia',
          id_municipio='$idMunicipio',
          id_estado='$idEstado',
          id_pais='$idPais',
          codigo_postal='$codigoPostal',
          domicilio_s='$domicilioS', 
          no_exterior_s='$numExtS',
          no_interior_s='$numIntS',
          colonia_s='$coloniaS',
          id_municipio_s='$idMunicipioS',
          id_estado_s='$idEstadoS',
          id_pais_s='$idPaisS',
          codigo_postal_s='$codigoPostalS',
          entre_calles_s='$entreCallesS',
          otros_contactos='$otrosContactos',
          contacto='$contacto',
          correos='$correos',
          telefonos='$telefonos',
          celular='$celular',
          ext='$extension',
          activo='$activo',
          r_legal='$representanteLegal',
          id_plan = '$idPlan',
          tipo_recibo_facura='$tipoReciboFactura',
          entrega='$tipoEntrega',
          dia_corte='$fechaCorte',
          pago= '$tipoPago',
          porcentaje_iva = '$tasaIva',
          digitos_cuenta = '$digitosCuenta',
          id_tipo_panel = '$id_tipo_panel'
          WHERE id=".$idServicio;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }

        $arrD = array('idServicio' => $idServicio,
                      'idPlan' => $idPlan,
                      'tipoReciboFactura' => $tipoReciboFactura,
                      'tipoEntrega' => $tipoEntrega,
                      'fechaCorte' => $fechaCorte,
                      'tipoPago' => $tipoPago,
                      'idUsuario' => $idUsuario,
                      'usoCFDI' => $usoCFDI,
                      'metodoPago' => $metodoPago,
                      'formaPago' => $formaPago,
                      'productoSAT' => $productoSAT,
                      'nombreProducto' => $nombreProducto,
                      'unidadSAT' => $unidadSAT,
                      'nombreUnidad' => $nombreUnidad,
                      'descripcion' => $descripcion,
                      'especificacionesCobranza'=>$especificacionesCobranza);
     
        if ($result) 
        $verifica = $this -> guardarBitacora($arrD);

        
        return $verifica;
    }


    function guardarBitacora($arrBitacora){
       
        $verifica = 0;

        $idServicio = $arrBitacora['idServicio'];
        $idPlan = $arrBitacora['idPlan'];
        $tipoReciboFactura = $arrBitacora['tipoReciboFactura'];
        $tipoEntrega = $arrBitacora['tipoEntrega'];
        $fechaCorte = $arrBitacora['fechaCorte'];
        $tipoPago = $arrBitacora['tipoPago'];
        $idUsuario = $arrBitacora['idUsuario'];
        $usoCFDI = $arrBitacora['usoCFDI'];
        $metodoPago = $arrBitacora['metodoPago'];
        $formaPago = $arrBitacora['formaPago'];
        $productoSAT = $arrBitacora['productoSAT'];
        $nombreProducto = $arrBitacora['nombreProducto'];
        $unidadSAT = $arrBitacora['unidadSAT'];
        $nombreUnidad = $arrBitacora['nombreUnidad'];
        $descripcion = $arrBitacora['descripcion'];
        $especificacionesCobranza = $arrBitacora['especificacionesCobranza'];

        $recibo='NO';
        $factura = 'NO';

        if($tipoReciboFactura=='R'){
            $recibo='SI';
        }else{
            $factura='SI';
        }

        $fisica='NO'; $correos='NO';

        if($entrega==2){
            $fisica='SI';
            $correos='SI';
        }elseif($entrega==0){
            $fisica='SI';
        }else{
            $correos='SI'; 
        }

        $query = "INSERT INTO servicios_bitacora_planes(id_servicio, id_plan, recibo, factura,entrega_fisica,entrega_correo,dia_corte,id_usuario_captura,uso_cfdi,metodo_pago,forma_pago,producto_sat,nombre_producto_sat,unidad_sat,nombre_unidad_sat,descripcion,especificaciones_cobranza) 
        VALUES ('$idServicio','$idPlan','$recibo','$factura','$fisica','$correos','$fechaCorte','$idUsuario','$usoCFDI','$metodoPago','$formaPago','$productoSAT','$nombreProducto','$unidadSAT','$nombreUnidad','$descripcion','$especificacionesCobranza')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if ($result) 
          $verifica = $idServicio;

        return $verifica;
    }

    
    /**
      * Busca los datos de una razon social, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activo 0=inactivo 2=todos
      *
      **/
      function buscarServicios($estatus,$idSucursal){

        $idSucursal = isset($idSucursal)? $idSucursal : 0 ;

        $condicionEstatus='';
        $condicionSucursal='';

        if($idSucursal>0 || $idSucursal != '')
        {
          if($idSucursal[0] == ',')
          {
              $dato=substr($idSucursal,1);
              $condicionSucursal = ' AND a.id_sucursal IN('.$dato.') ';
          }else{ 
              $condicionSucursal = ' AND a.id_sucursal ='.$idSucursal;
          }
        }else{

        }

        if($estatus==1){
          $condicionEstatus=' AND a.activo=1';
        }
        if($estatus==0){
          $condicionEstatus=' AND a.activo=0';
        }

        $query = "SELECT a.id,a.cuenta,IFNULL(a.razon_social,'') AS razon_social,IFNULL(a.rfc,'') AS rfc,a.nombre_corto,a.activo,IFNULL(a.codigo_postal,'') AS codigo_postal,IFNULL(a.id_pais,141) AS id_pais,  
                  IF(a.activo=1,'ACTIVO','INACTIVO') AS estatus,a.porcentaje_iva,IFNULL(a.correos,'') AS correos,b.descr AS sucursal,IFNULL(c.metodo_pago,'') AS metodo_pago,IFNULL(DATE(c.fecha_captura),'') AS fecha
                  FROM servicios a
                  LEFT JOIN sucursales b ON a.id_sucursal=b.id_sucursal
                  LEFT JOIN servicios_bitacora_planes c ON c.id=(SELECT MAX(id) FROM servicios_bitacora_planes WHERE id_servicio=a.id  GROUP BY id_servicio)
                  WHERE 1=1 AND a.nombre_corto NOT LIKE '%(MAQUILAD%' $condicionEstatus $condicionSucursal
                  ORDER BY a.nombre_corto ASC";

        // echo $query;
        // exit();

        //--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
        $resultado = $this->link->query($query);

        return query2json($resultado);

      }//- fin function buscarServicios

      function buscarServicios2($estatus,$idSucursal){

        $idSucursal = isset($idSucursal)? $idSucursal : 0 ;

        $condicionEstatus='';
        $condicionSucursal='';

        if($idSucursal>0 || $idSucursal != '')
        {
          if($idSucursal[0] == ',')
          {
              $dato=substr($idSucursal,1);
              $condicionSucursal = ' AND a.id_sucursal IN('.$dato.') ';
          }else{ 
              $condicionSucursal = ' AND a.id_sucursal ='.$idSucursal;
          }
        }else{

        }

        if($estatus==1){
          $condicionEstatus=' AND a.activo=1';
        }
        if($estatus==0){
          $condicionEstatus=' AND a.activo=0';
        }

        $query = "SELECT a.id,a.cuenta,IFNULL(a.razon_social,'') AS razon_social,IFNULL(a.rfc,'') AS rfc,a.nombre_corto,a.activo,IFNULL(a.codigo_postal,'') AS codigo_postal,IFNULL(a.id_pais,141) AS id_pais,  
                  IF(a.activo=1,'ACTIVO','INACTIVO') AS estatus,a.porcentaje_iva,IFNULL(a.correos,'') AS correos,b.descr AS sucursal,IFNULL(c.metodo_pago,'') AS metodo_pago,IFNULL(DATE(c.fecha_captura),'') AS fecha
                  FROM servicios a
                  LEFT JOIN sucursales b ON a.id_sucursal=b.id_sucursal
                  LEFT JOIN servicios_bitacora_planes c ON c.id=(SELECT MAX(id) FROM servicios_bitacora_planes WHERE id_servicio=a.id  GROUP BY id_servicio)
                  WHERE 1=1 $condicionEstatus $condicionSucursal
                  ORDER BY a.nombre_corto ASC";

        // echo $query;
        // exit();

        //--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
        $resultado = $this->link->query($query);

        return query2json($resultado);

      }//- fin function buscarServicios
      //--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO

      function buscarServiciosOtro($estatus,$idSucursal){

        $idSucursal = isset($idSucursal)? $idSucursal : 0 ;

        $condicionEstatus='';
        $condicionSucursal='';

        if($idSucursal>0 || $idSucursal != '')
        {
          if($idSucursal[0] == ',')
          {
              $dato=substr($idSucursal,1);
              $condicionSucursal = ' AND a.id_sucursal IN('.$dato.') ';
          }else{ 
              $condicionSucursal = ' AND a.id_sucursal ='.$idSucursal;
          }
        }else{

        }

        if($estatus==1){
          $condicionEstatus=' AND a.activo=1';
        }
        if($estatus==0){
          $condicionEstatus=' AND a.activo=0';
        }

        //--MGFS 20-01-2020 SE AGREGA VALIDACION MOSTRAR EN TODO ALARMAS NOMBRE CORTO
        $resultado = $this->link->query("SELECT a.id,a.cuenta,IFNULL(a.razon_social,'') AS razon_social,IFNULL(a.rfc,'') AS rfc,a.nombre_corto,a.activo,IFNULL(a.codigo_postal,'') AS codigo_postal,IFNULL(a.id_pais,141) AS id_pais,  
        IF(a.activo=1,'ACTIVO','INACTIVO') AS estatus,a.porcentaje_iva,IFNULL(a.correos,'') AS correos,b.descr AS sucursal,IFNULL(c.metodo_pago,'') AS metodo_pago,IFNULL(DATE(c.fecha_captura),'') AS fecha
        FROM servicios a
        LEFT JOIN sucursales b ON a.id_sucursal=b.id_sucursal
        LEFT JOIN servicios_bitacora_planes c ON c.id=(SELECT MAX(id) FROM servicios_bitacora_planes WHERE id_servicio=a.id  GROUP BY id_servicio)
        WHERE 1=1 $condicionEstatus $condicionSucursal
        ORDER BY a.nombre_corto ASC");
          
        return "SELECT a.id,a.cuenta,IFNULL(a.razon_social,'') AS razon_social,IFNULL(a.rfc,'') AS rfc,a.nombre_corto,a.activo,IFNULL(a.codigo_postal,'') AS codigo_postal,IFNULL(a.id_pais,141) AS id_pais,  
        IF(a.activo=1,'ACTIVO','INACTIVO') AS estatus,a.porcentaje_iva,IFNULL(a.correos,'') AS correos,b.descr AS sucursal,IFNULL(c.metodo_pago,'') AS metodo_pago,IFNULL(DATE(c.fecha_captura),'') AS fecha
        FROM servicios a
        LEFT JOIN sucursales b ON a.id_sucursal=b.id_sucursal
        LEFT JOIN servicios_bitacora_planes c ON c.id=(SELECT MAX(id) FROM servicios_bitacora_planes WHERE id_servicio=a.id  GROUP BY id_servicio)
        WHERE 1=1 $condicionEstatus $condicionSucursal
        ORDER BY a.nombre_corto ASC";

      }

      function buscarServiciosId($idServicio){

        $resultado = $this->link->query("SELECT 
        servicios.id,
        servicios.id_sucursal, 
        servicios.cuenta, 
        servicios.rfc, 
        servicios.nombre_corto, 
        IFNULL(servicios.razon_social,'') AS razon_social,
        servicios.domicilio,
        servicios.no_exterior,
        servicios.no_interior,
        servicios.colonia,
        servicios.id_municipio,
        servicios.id_estado,
        servicios.id_pais,
        servicios.codigo_postal,

        servicios.domicilio_s,
        servicios.no_exterior_s,
        servicios.no_interior_s,
        servicios.colonia_s,
        servicios.id_municipio_s,
        servicios.id_estado_s,
        servicios.id_pais_s,
        servicios.codigo_postal_s,
        servicios.entre_calles_s,
        ms.municipio AS municipio_s,
        es.estado AS estado_s,
        ps.pais AS pais_s,

        servicios.otros_contactos,
        servicios.contacto,
        servicios.correos,
        servicios.telefonos,
        servicios.celular,
        servicios.ext,

        servicios.r_legal,
        servicios.activo,

        servicios.id_plan,
        servicios_cat_planes.tipo AS tipo_plan,
        servicios.entrega,
        servicios.pago,
        servicios.porcentaje_iva,
        servicios.dia_corte,
        servicios.tipo_recibo_facura,
        servicios.digitos_cuenta,
        servicios.id_tipo_panel,

        municipios.municipio,
        estados.estado,
        paises.pais,
        c.uso_cfdi,c.metodo_pago,c.forma_pago,c.producto_sat,c.unidad_sat,c.descripcion,
        IFNULL(c.especificaciones_cobranza,'') AS especificaciones_cobranza
        FROM servicios 
        LEFT JOIN municipios  ON servicios.id_municipio=municipios.id
        LEFT JOIN estados  ON servicios.id_estado=estados.id
        LEFT JOIN paises  ON servicios.id_pais=paises.id
        LEFT JOIN municipios ms ON servicios.id_municipio_s=ms.id
        LEFT JOIN estados es  ON servicios.id_estado_s=es.id
        LEFT JOIN paises ps ON servicios.id_pais_s=ps.id
        LEFT JOIN servicios_cat_planes ON servicios.id_plan=servicios_cat_planes.id
        LEFT JOIN servicios_bitacora_planes c ON c.id=(SELECT MAX(id) FROM servicios_bitacora_planes WHERE id_servicio=servicios.id  GROUP BY id_servicio)
        WHERE servicios.id=$idServicio
        ORDER BY servicios.id");
        return query2json($resultado);
          

      }//- fin function buscarServiciosId


      function buscarBitacoraServicios($idServicio){

        $resultado = $this->link->query("SELECT a.id_servicio, a.id_plan, a.recibo, a.factura, a.entrega_fisica, a.entrega_correo, a.dia_corte,a.id_usuario_captura, a.fecha_captura,b.descripcion as plan,IFNULL(a.especificaciones_cobranza,'') AS especificaciones_cobranza
        FROM servicios_bitacora_planes a
        LEFT JOIN servicios_cat_planes b ON a.id_plan=b.id
        WHERE a.id_servicio=".$idServicio."
        ORDER BY a.id ASC");
        return query2json($resultado);
          

      }//- fin function buscarServiciosId

      function buscarCuentaServicios(){

        $query = "SELECT MAX(cuenta)+1 AS cuenta_siguiente FROM servicios";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $numRows = mysqli_num_rows($result);

        if($numRows>0){

          $dato= mysqli_fetch_array($result);
          return $dato['cuenta_siguiente'];

        }else{

          return 0;
        }
          

      }//- fin function buscarServiciosId

      //--- busca todas las ventas y ordnes que no se han facturado con la bandera de facturar=1
      //-- MGFS 05-02-2020 SE AGREGA CONDICION PARA QUE NO SE FACTURE UN REGISTRO CON ABONOS
      //-- MGFS 06-02-2020 SE AGREGA CONDICION PARA QUE APARESCAN LOS PNAES QUE NO SE FACTURAN
      function buscaTicketsPorFacturar($idServicio,$rfc){

        $condicion='';
        $havingS = '';
        $serviciosDiferentes = '';

        if($idServicio == 0 && $rfc==''){

          $condicion=" (a.estatus='A' AND a.id_factura=0 AND a.facturar=0 AND a.id_razon_social_servicio > 0)";
         
        }elseif($idServicio>0 && $rfc==''){

          $condicion=" (a.estatus='A' AND a.id_factura=0 AND a.facturar=1 AND a.id_razon_social_servicio > 0) AND a.id_razon_social_servicio=".$idServicio;
        }else{
        
          $condicion=" (a.estatus='A' AND a.id_factura=0 AND a.facturar=1 AND a.id_razon_social_servicio > 0) AND a.id_razon_social_servicio in (SELECT id FROM servicios WHERE rfc='$rfc' AND id!=".$idServicio.")";
       
        }

        // verificando ando

        /*
          "SELECT 
              a.id AS id_cxc,
              IF(a.id_venta>0,'VENTA',IF(a.id_plan>0,'PLAN',IF(a.id_orden_servicio>0,'ORDEN','')))AS tipo,
              IF(a.folio_venta>0,a.folio_venta,IF(a.id_plan>0,a.folio_recibo,a.id_orden_servicio))AS folio,
              IF(a.id_venta>0,a.id_venta,IF(a.id_plan>0,a.id_plan,a.id_orden_servicio))AS id_registro,
              IF(a.id_plan>0,a.fecha_corte_recibo,a.fecha) AS fecha,
              a.total as total,
              a.subtotal as subtotal, 
              a.tasa_iva AS porcentaje_iva,
              a.vencimiento,
              a.fecha_corte_recibo,
              (SELECT COUNT(id)AS registros FROM cxc WHERE folio_cxc=a.folio_cxc AND a.estatus NOT IN('P','C')) AS registros,
              d.factura
            FROM cxc a
            LEFT JOIN notas_e b ON a.id_venta=b.id  
            LEFT JOIN servicios_ordenes c ON a.id_orden_servicio=c.id 
            LEFT JOIN servicios_bitacora_planes d ON a.id_plan=d.id
            WHERE  $condicion 
            HAVING registros=1
            ORDER BY a.id DESC"
        */

        $resultado = $this->link->query("
          SELECT 
            a.id AS id_cxc,
            IF(a.id_venta>0,'VENTA',IF(a.id_plan>0,'PLAN',IF(a.id_orden_servicio>0,'ORDEN','')))AS tipo,
            IF(a.folio_venta>0,a.folio_venta,IF(a.id_plan>0,a.folio_recibo,a.id_orden_servicio))AS folio,
            IF(a.id_venta>0,a.id_venta,IF(a.id_plan>0,a.id_plan,a.id_orden_servicio))AS id_registro,
            IF(a.id_plan>0,a.fecha_corte_recibo,a.fecha) AS fecha,
            a.total AS total,
            a.subtotal AS subtotal, 
            a.tasa_iva AS porcentaje_iva,
            a.vencimiento,
            a.fecha_corte_recibo,
            folios.registros AS registros,
            d.factura,
            e.nombre_corto AS servicio,
            e.id AS id_servicio
            FROM cxc a
            LEFT JOIN notas_e b ON a.id_venta=b.id  
            LEFT JOIN servicios_ordenes c ON a.id_orden_servicio=c.id 
            LEFT JOIN servicios_bitacora_planes d ON a.id_plan=d.id
            LEFT JOIN servicios e ON a.id_razon_social_servicio=e.id
            LEFT JOIN 
            (
              SELECT folio_cxc AS folio, COUNT(id)AS registros FROM cxc WHERE estatus NOT IN('P','C') GROUP BY folio_cxc
            ) folios ON a.folio_cxc = folios.folio
            WHERE  $condicion 
            HAVING folios.registros=1
            ORDER BY a.id DESC");
        return query2json($resultado);
      }


    /**
      * ACTUALIZA LOS CORRESO DE LOS CLIENTES DESDE SEGUIMIENTO ORDENS
      *
    **/      
    function actualizaCorreos($idServicio,$correos){
      
      $verifica = 0;

     $this->link->begin_transaction();
     $this->link->query("START TRANSACTION;");

     $query = "UPDATE servicios SET correos='$correos' WHERE id=".$idServicio;
     $verifica = mysqli_query($this->link, $query) or die(mysqli_error());

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;

  } //-- fin function guardarServicios

  /**
   * busqueda de un recibo de plan para factura desde facturacion alarmas
   */
  function buscarServiciosPlanesId($idBitacoraPlan,$idCXC){

    $query = "SELECT
                a.id, 
                i.cantidad AS total_cat,
                k.total AS total,
                k.subtotal,
                IF(i.meses=12,YEAR(NOW()),0) AS anio_actual,
                YEAR(DATE_ADD(CURRENT_DATE(),INTERVAL 1 YEAR)) AS anio_siguiente,
                MONTH(k.fecha_corte_recibo) AS mes_actual,
                MONTH(k.vencimiento) AS mes_fin,
                i.meses,
                IF(i.meses=12,MONTH(DATE_ADD(CURRENT_DATE(),INTERVAL 12 MONTH)),IF(i.meses=6,MONTH(DATE_ADD(CURRENT_DATE(),INTERVAL 6 MONTH)),IF(i.meses=3,MONTH(DATE_ADD(CURRENT_DATE(),INTERVAL 3 MONTH)),MONTH(CURRENT_DATE())))) AS mes_fin_o,
                i.descripcion AS descripcion_cat,
                IFNULL(a.descripcion,'') AS descripcion_plan,
                IFNULL(j.cuenta,'') AS cuenta
              FROM cxc AS k 
              LEFT JOIN servicios_bitacora_planes a ON k.id_plan=a.id
              LEFT JOIN servicios_cat_planes i ON a.id_plan=i.id
              LEFT JOIN servicios j ON a.id_servicio=j.id
              WHERE k.id=".$idCXC;

    // echo $query;
    // exit();

    $resultado = $this->link->query($query);
    return query2json($resultado);      

  }//- fin function buscarServiciosId

  //-->NJES Feb/20/2020 obtiene los tickets de partidas que se usaron al generar una factura/refactura
  function buscaTicketsIdFactura($idFactura){
    $resultado = $this->link->query("SELECT a.id_cxc,
                IF(b.id_venta>0,'VENTA',IF(b.id_plan,'PLAN','ORDEN'))AS tipo,
                IF(b.folio_venta>0,b.folio_venta,IF(b.id_plan>0,b.folio_recibo,b.id_orden_servicio))AS folio,
                IF(b.id_venta>0,b.id_venta,IF(b.id_plan>0,b.id_plan,b.id_orden_servicio))AS id_registro,
                IF(b.id_plan>0,b.fecha_corte_recibo,b.fecha) AS fecha,
                b.total AS total,
                b.subtotal AS subtotal, 
                b.tasa_iva AS porcentaje_iva,
                c.id AS id_servicio,
                c.nombre_corto AS servicio,
                c.razon_social
                FROM facturas_d a
                LEFT JOIN cxc b ON a.id_cxc=b.id
                LEFT JOIN servicios c ON b.id_razon_social_servicio=c.id
                WHERE a.id_factura=$idFactura
                GROUP BY b.id
                ORDER BY b.id DESC");

    return query2json($resultado);
  }

  function buscarServiciosSaldosPendientes($idServicio){

    /*$query = "SELECT
                  a.id_orden_servicio,
                  a.folio_cxc as folio,
                  a.estatus,
                  a.cargo_inicial,
                  a.id,
                  a.fecha,
                  IFNULL(a.referencia,'') AS referencia,
                  CONCAT(a.cve_concepto ,'-', b.descripcion)AS concepto,
                  a.subtotal,
                  a.iva,
                  IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),0) AS cargos,
                  IF( IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) = 0, IFNULL(pagos_abonos.importe_pagado, 0), IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) ) AS abonos,
                  SUBSTR(a.cve_concepto,1,1)AS tipo,
                  IFNULL(IF(c.es_plan=1,a.vencimiento,DATE_ADD(c.fecha, INTERVAL c.dias_credito DAY)),'') AS fecha_vencimiento,
                  IF(c.folio>0,c.folio,'') AS folio_factura
              FROM cxc a
              LEFT JOIN conceptos_cxp b ON a.cve_concepto=b.clave AND b.tipo=1
              LEFT JOIN facturas c ON a.id_factura=c.id
              LEFT JOIN (
                SELECT
                  SUM(cxc.total) AS importe_pagado,
                      cxc.id AS id_cxc        
                FROM pagos_d
                  INNER JOIN pagos_e ON pagos_d.id_pago_e = pagos_e.id
                  INNER JOIN facturas ON pagos_d.id_factura = facturas.id
                  INNER JOIN cxc ON facturas.id_cxc = cxc.id
                  WHERE pagos_e.estatus != 'C'
                  GROUP BY cxc.id ) pagos_abonos ON a.id = pagos_abonos.id_cxc
              WHERE
                a.id_razon_social_servicio = $idServicio
                  AND a.estatus NOT IN('C','P')
                  AND (IF( IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) = 0, IFNULL(pagos_abonos.importe_pagado, 0), IF((SUBSTR(a.cve_concepto,1,1) = 'A'),(a.subtotal + a.iva),0) )) < (IF((SUBSTR(a.cve_concepto,1,1) = 'C'),(a.subtotal + a.iva),0))
                  AND a.folio_cxc IN(
                  SELECT
                    DISTINCT(a.folio_cxc ) AS folio_cxc
                  FROM cxc a
                      WHERE
                    a.id_razon_social_servicio = $idServicio
                          AND a.estatus NOT IN('C','P')
                          )
              ORDER BY a.id ASC";*/

    $query = "SELECT *
              FROM(
                SELECT
                  cxc.id,
                  cxc.id_factura blanco,
                  cxc.id_pago_d,    
                  cxc.id_orden_servicio,
                  cxc.id_plan,
                  cxc.id_venta,
                  cxc.folio_venta,
                  cxc.folio_cxc as folio,
                  cxc.estatus,
                  cxc.cargo_inicial,
                  cxc.fecha,
                  IFNULL(cxc.referencia,'') AS referencia,
                  CONCAT(cxc.cve_concepto, '-', ccxp.descripcion) AS concepto,
                  cxc.subtotal,
                  cxc.iva,
                  IF((SUBSTR(cxc.cve_concepto,1,1) = 'C'),(cxc.subtotal + cxc.iva),0) AS cargos,
                  IF((SUBSTR(cxc.cve_concepto,1,1) = 'A'),(cxc.subtotal + cxc.iva),0) AS abonos,    
                  SUBSTR(cxc.cve_concepto,1,1) AS tipo,
                  IFNULL(IF(facturas.es_plan=1,cxc.vencimiento,DATE_ADD(facturas.fecha, INTERVAL facturas.dias_credito DAY)),'') AS fecha_vencimiento,
                  IF(facturas.folio>0,facturas.folio,'') AS folio_factura
              FROM cxc cxc
              LEFT JOIN facturas ON cxc.id_factura = facturas.id
              INNER JOIN conceptos_cxp ccxp ON cxc.cve_concepto = ccxp.clave AND ccxp.tipo = 1
              WHERE cxc.id_razon_social_servicio = $idServicio and cxc.estatus NOT IN ('C') AND (SUBSTR(cxc.cve_concepto,1,1) = 'C') and facturas.id IN (SELECT id_factura FROM cxc WHERE id_razon_social_servicio = $idServicio and estatus NOT IN ('C'))
              UNION
              SELECT
                  cxc.id,
                  pagos_d.id_factura blanco,
                  cxc.id_pago_d,    
                  cxc.id_orden_servicio,
                  cxc.id_plan,
                  cxc.id_venta,
                  cxc.folio_venta,
                  cxc.folio_cxc as folio,
                  cxc.estatus,
                  cxc.cargo_inicial,
                  cxc.fecha,
                  IFNULL(cxc.referencia,'') AS referencia,
                  CONCAT(cxc.cve_concepto, '-', ccxp.descripcion) AS concepto,
                  cxc.subtotal,
                  cxc.iva,
                  IF((SUBSTR(cxc.cve_concepto,1,1) = 'C'),(cxc.subtotal + cxc.iva),0) AS cargos,
                  IF((SUBSTR(cxc.cve_concepto,1,1) = 'A'),(cxc.subtotal + cxc.iva),0) AS abonos,    
                  SUBSTR(cxc.cve_concepto,1,1) AS tipo,
                  IFNULL(IF(facturas.es_plan=1,cxc.vencimiento,DATE_ADD(facturas.fecha, INTERVAL facturas.dias_credito DAY)),'') AS fecha_vencimiento,
                  IF(facturas.folio>0,facturas.folio,'') AS folio_factura
              FROM cxc cxc
              LEFT JOIN facturas ON cxc.id_factura = facturas.id
              LEFT JOIN pagos_d ON cxc.id_pago_d = pagos_d.id
              INNER JOIN conceptos_cxp ccxp ON cxc.cve_concepto = ccxp.clave AND ccxp.tipo = 1
              AND cxc.id_pago_d IN (
                SELECT id
                FROM pagos_d
                  WHERE id_factura IN ( SELECT id_factura FROM cxc WHERE id_razon_social_servicio = $idServicio and estatus NOT IN ('C') ))
              ) test
              ORDER BY test.blanco ASC, test.id ASC";


    // echo $query;
    // exit();

    $resultado = $this->link->query($query);

    return query2json($resultado);

  }//- fin function buscarServicios
    
}//--fin de class Servicios
    
?>