<?php

include 'conectar.php';

class RazonesSociales
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function RazonesSociales()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la nombreCorto del razon social no se repita
      *
      * @param varchar $nombreCorto  usado para indentificar en las Búsqueda de  des un razon social
      *
    **/
    function verificarRazonesSociales($nombreCorto){
      
      $verifica = 0;

      $query = "SELECT id FROM razones_sociales WHERE nombre_corto = '$nombreCorto'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaRazonesSociales

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una razon social
      *
    **/      
    function guardarRazonesSociales($datos){
    
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardarActualizar($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;

    } //-- fin function guardarRazonesSociales


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

        /*
        [0] => 1
        [1] => Array (
            [tipoMovR] => 1
            [idRazonSocial] => 14
            [idCliente] => 12

            [rfc] => XEXX010101000
            [nombreCorto] => ALFA
            [razonSocial] => ALFA TRUCKING
            [representanteLegal] => ALFA TEST
            [correoRepresentanteLegal] => test_correo
            [telefonoRepresentanteLegal] => 614111111
            
            [domicilio] => GAZELLE DR
            [codigoPostal] => 79925
            [colonia] => SOCORRO
            [noInt] => 0
            [noExt] => 8616
            [idPais] => 236
            [idEstado] => 50
            [idMunicipio] => 500001
            
            [domicilio2] => calle del test
            [codigoPostal2] => 31410
            [colonia2] => Guadalupe
            [noInt2] => 0
            [noExt2] => 1111
            [idPais2] => 141
            [idEstado2] => 6
            [idMunicipio2] => 60014

            [telefonos] => 9157751297
            [extension] => 222
            [contacto] => contactest
            [correo] => test_correo2

            [telefonos2] => 614222222
            [extension2] => 333
            [contacto2] => contactest3
            [correo2] => correo_test3

            [diasCredito] => 7
            [creditoLimite] => 0
            [creditoActivo] => 1
            [periodicidad] => 
            [tipo_facturacion] => 
            [dia] => 
            [activo] => 1
        )
        */
          
        $verifica = 0;

        $tipoMov = $datos[1]['tipoMovR'];
        $idCliente = $datos[1]['idCliente'];
        $idRazonSocial = $datos[1]['idRazonSocial'];
        $rfc = $datos[1]['rfc'];
        $nombreCorto = $datos[1]['nombreCorto'];
        $razonSocial = $datos[1]['razonSocial'];
        $representanteLegal = $datos[1]['representanteLegal'];
        $correoRepresentanteLegal = $datos[1]['correoRepresentanteLegal'];
        $telefonoRepresentanteLegal = $datos[1]['telefonoRepresentanteLegal'];

        $domicilio = $datos[1]['domicilio'];
        $noInt = $datos[1]['noInt'];
        $noExt = $datos[1]['noExt'];
        $codigoPostal = $datos[1]['codigoPostal'];
        $idPais = $datos[1]['idPais'];
        $idEstado = $datos[1]['idEstado'];
        $idMunicipio = $datos[1]['idMunicipio'];
        $colonia = $datos[1]['colonia'];

        $domicilio2 = $datos[1]['domicilio2'];
        $noInt2 = $datos[1]['noInt2'];
        $noExt2 = $datos[1]['noExt2'];
        $codigoPostal2 = $datos[1]['codigoPostal2'];
        $idPais2 = $datos[1]['idPais2'];
        $idEstado2 = $datos[1]['idEstado2'];
        $idMunicipio2 = $datos[1]['idMunicipio2'];
        $colonia2 = $datos[1]['colonia2'];
        $entreCalles = $datos[1]['entreCalles'];
        $celularServicio = $datos[1]['celularServicio'];
        $posicion = $datos[1]['posicion'];

        $telefonos = $datos[1]['telefonos'];
        $extension = $datos[1]['extension'];
        $correo = $datos[1]['correo'];
        $contacto = $datos[1]['contacto'];

        $telefonos2 = $datos[1]['telefonos2'];
        $extension2 = $datos[1]['extension2'];
        $correo2 = $datos[1]['correo2'];
        $contacto2 = $datos[1]['contacto2'];

        $diasCredito = $datos[1]['diasCredito'];
        $creditoLimite = $datos[1]['creditoLimite'];
        $creditoActivo = $datos[1]['creditoActivo'];

        $periodicidad = $datos[1]['periodicidad'];
        $tipo_facturacion = $datos[1]['tipo_facturacion'];
        $dia = $datos[1]['dia'];

        $activo = $datos[1]['activo'];

        if($tipoMov==0){

          $query = "INSERT INTO razones_sociales(
                                        id_cliente,
                                        rfc,
                                        nombre_corto,
                                        razon_social,
                                        domicilio,
                                        no_exterior,
                                        no_interior,
                                        colonia,
                                        id_municipio,
                                        id_estado,
                                        id_pais,
                                        codigo_postal,
                                        dias_cred,
                                        limite_cred,
                                        cred_activo,
                                        otros_contactos,
                                        contacto,
                                        email,
                                        telefono,
                                        ext,
                                        r_legal,
                                        tipo_facturacion,
                                        periodicidad,
                                        dia,

                                        correo_r_legal,
                                        telefono_r_legal,
                                        domicilio_servicio,
                                        no_interior_servicio,
                                        no_exterior_servicio,
                                        codigo_postal_servicio,
                                        id_pais_servicio,
                                        id_estado_servicio,
                                        id_municipio_servicio,
                                        colonia_servicio,
                                        telefono_operativo,
                                        ext_operativo,
                                        correo_operativo,
                                        contacto_operativo,
                                        entrecalle_servicio,
                                        celular_servicio,
                                        posicion) 
                    VALUES (
                            '$idCliente',
                            '$rfc',
                            '$nombreCorto',
                            '$razonSocial',
                            '$domicilio',
                            '$noExt',
                            '$noInt',
                            '$colonia',
                            '$idMunicipio',
                            '$idEstado',
                            '$idPais',
                            '$codigoPostal',
                            '$diasCredito',
                            '$creditoLimite',
                            '$creditoActivo',
                            '',
                            '$contacto',
                            '$correo',
                            '$telefonos',
                            '$extension',
                            '$representanteLegal',
                            '$tipo_facturacion',
                            '$periodicidad',
                            '$dia',
                            
                            '$correoRepresentanteLegal',
                            '$telefonoRepresentanteLegal',
                            '$domicilio2',
                            '$noInt2',
                            '$noExt2',
                            '$codigoPostal2',
                            '$idPais2',
                            '$idEstado2',
                            '$idMunicipio2',
                            '$colonia2',
                            '$telefonos2',
                            '$extension2',
                            '$correo2',
                            '$contacto2',
                            '$entreCalles',
                            '$celularServicio',
                            '$posicion')";

          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idRazonSocial = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE razones_sociales SET 
                          id_cliente='$idCliente',
                          rfc='$rfc',
                          nombre_corto='$nombreCorto',
                          razon_social='$razonSocial',
                          domicilio='$domicilio', 
                          no_exterior='$noExt',
                          no_interior='$noInt',
                          colonia='$colonia',
                          id_municipio='$idMunicipio',
                          id_estado='$idEstado',
                          id_pais='$idPais',
                          codigo_postal='$codigoPostal',
                          dias_cred='$diasCredito',
                          limite_cred='$creditoLimite',
                          cred_activo='$creditoActivo',
                          otros_contactos='',
                          contacto='$contacto',
                          email='$correo',
                          telefono='$telefonos',
                          ext='$extension',
                          activo='$activo',
                          r_legal='$representanteLegal',
                          tipo_facturacion='$tipo_facturacion',
                          periodicidad='$periodicidad',
                          dia='$dia',
                          correo_r_legal='$correoRepresentanteLegal',
                          telefono_r_legal='$telefonoRepresentanteLegal',
                          domicilio_servicio='$domicilio2',
                          no_interior_servicio='$noInt2',
                          no_exterior_servicio='$noExt2',
                          codigo_postal_servicio='$codigoPostal2',
                          id_pais_servicio='$idPais2',
                          id_estado_servicio='$idEstado2',
                          id_municipio_servicio='$idMunicipio2',
                          colonia_servicio='$colonia2',
                          telefono_operativo='$telefonos2',
                          ext_operativo='$extension2',
                          correo_operativo='$correo2',
                          contacto_operativo='$contacto2',
                          entrecalle_servicio='$entreCalles',
                          celular_servicio='$celularServicio',
                          posicion='$posicion'
                    WHERE id=".$idRazonSocial;

          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idRazonSocial;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una razon social, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activo 0=inactivo 2=todos
      *
      **/
      function buscarRazonesSociales($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE activo=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE activo=0';
        }

        $resultado = $this->link->query("SELECT id,id_cliente,razon_social,rfc,nombre_corto,IF(activo=1,'ACTIVO','INACTIVO') AS estatus 
        FROM razones_sociales
        $condicionEstatus
        ORDER BY razon_social");
        return query2json($resultado);

      }//- fin function buscarRazonesSociales

      function buscarRazonesSocialesId($idRazonSocial){

        /*
        correo_r_legal VARCHAR(50)
        telefono_r_legal VARCHAR(50)
        domicilio_servicio LONGTEXT
        no_exterior_servicio VARCHAR(45)
        no_interior_servicio VARCHAR(45)
        entrecalle_servicio LONGTEXT
        id_municipio_servicio INT(5)
        id_estado_servicio INT(3)
        id_pais_servicio INT(2)
        codigo_postal_servicio CHAR(5)
        contacto_administrativo LONGTEXT
        correo_admin VARCHAR(50)
        celular VARCHAR(50)
        contacto_operativo LONGTEXT
        posicion VARCHAR(50)
        correo_operativo VARCHAR(50)
        telefono_operativo VARCHAR(50)
        */

        $query = "SELECT 
                    rs.id_cliente, 
                    rs.rfc, 
                    rs.nombre_corto, 
                    rs.razon_social,
                    rs.domicilio,
                    rs.no_exterior,
                    rs.no_interior,
                    rs.colonia,
                    rs.id_municipio,
                    rs.id_estado,
                    rs.id_pais,
                    rs.codigo_postal,
                    rs.dias_cred,
                    rs.limite_cred,
                    rs.cred_activo,
                    rs.otros_contactos,
                    rs.contacto,
                    rs.email,
                    rs.telefono,
                    rs.ext,
                    rs.r_legal,
                    rs.activo,
                    rs.tipo_facturacion,
                    rs.periodicidad,
                    rs.dia,
                    m1.municipio,
                    e1.estado,
                    p1.pais,
                    m2.municipio municipio2,
                    e2.estado estado2,
                    p2.pais pais2,
                    rs.correo_r_legal,
                    rs.telefono_r_legal,
                    rs.domicilio_servicio,
                    rs.no_exterior_servicio,
                    rs.no_interior_servicio,
                    rs.entrecalle_servicio,
                    rs.id_municipio_servicio,
                    rs.id_estado_servicio,
                    rs.id_pais_servicio,
                    rs.codigo_postal_servicio,
                    rs.celular_servicio,
                    rs.contacto_operativo,
                    rs.posicion,
                    rs.correo_operativo,
                    rs.telefono_operativo,
                    rs.colonia_servicio,
                    rs.ext_operativo,
                    rs.entrecalle_servicio
                  FROM razones_sociales rs
                  LEFT JOIN municipios m1 ON rs.id_municipio=m1.id
                  LEFT JOIN estados e1 ON rs.id_estado=e1.id
                  LEFT JOIN paises p1 ON rs.id_pais=p1.id
                  LEFT JOIN municipios m2 ON rs.id_municipio_servicio=m2.id
                  LEFT JOIN estados e2 ON rs.id_estado_servicio=e2.id
                  LEFT JOIN paises p2 ON rs.id_pais_servicio=p2.id
                  WHERE rs.id=$idRazonSocial
                  ORDER BY rs.id";

        // echo $query;
        // exit;
        
        $resultado = $this->link->query($query);
        return query2json($resultado);
          

      }//- fin function buscarRazonesSocialesId


      function buscarRazonesSocialesIdCliente($idCliente){
        
        $resultado = $this->link->query("SELECT id,razon_social,rfc,nombre_corto,IF(activo=1,'ACTIVO','INACTIVO') AS estatus 
        FROM razones_sociales
        WHERE id_cliente=$idCliente
        ORDER BY razon_social");
        return query2json($resultado);
          

      }//- fin function buscarRazonesSocialesId


      function buscarRazonesSocialesUnidadSucursal($idUnidadNegocio,$idSucursal){
        
        $resultado = $this->link->query("SELECT id,nombre_corto,razon_social,rfc 
                                         FROM razones_sociales 
                                         WHERE id=ANY(SELECT id_razon_social 
                                                      FROM razones_sociales_unidades 
                                                      WHERE id_unidad=".$idUnidadNegocio." AND id_sucursal=".$idSucursal.")
                                         ORDER BY  razon_social");
        return query2json($resultado);
          

      }//- fin function buscarRazonesSocialesUnidadSucursal

  

    
}//--fin de class RazonesSociales
    
?>