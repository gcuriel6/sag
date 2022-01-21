<?php

include 'conectar.php';

class Departamentos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Departamentos()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la clave del departamento no se repita
      *
      * @param varchar $clave  usado para indentificar en las Búsqueda de  des un departamento
      *
    **/
    function verificarDepartamentos($clave){
      
      $verifica = 0;

      $query = "SELECT id_depto FROM deptos WHERE cve_dep = '$clave'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaDepartamentos

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una departamento
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una departamento en particular
      * @param varchar $descripcion brebe descripcion de una departamento
      * @param int $ininactivo estatus de una departamento  1='inactivo' 0='Ininactivo'  
      *
    **/      
    function guardarDepartamentos($datos){
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarDepartamentos


     /**
      * Guarda los datos de una departamento, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del departamento para realizarla
      * @param varchar $clave es una clave para identificar una departamento en particular
      * @param varchar $descripcion brebe descripcion de una departamento
      * @param int $ininactivo estatus de una departamento  1='inactivo' 0='Ininactivo'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idDepartamento = $datos[1]['idDepartamento'];
        $tipo_mov = $datos[1]['tipo_mov'];
        $clave = $datos[1]['clave'];
        $descripcion = $datos[1]['descripcion'];
        $idSucursal = $datos[1]['idSucursal'];
        $idUnidad = $datos[1]['idUnidad'];
        $idArea = $datos[1]['idArea'];
        $servicioInicio = $datos[1]['servicioInicio'];
        $domicilio = $datos[1]['domicilio'];
        $colonia = $datos[1]['colonia'];
        $cp = $datos[1]['cp'];
        $numInt = $datos[1]['numInt'];
        $numExt = $datos[1]['numExt'];
        $tipo = $datos[1]['tipo'];
        $idPais = $datos[1]['idPais'];
        $idEstado = $datos[1]['idEstado'];
        $idMunicipio = $datos[1]['idMunicipio'];
        $idDepartamentoNomina = $datos[1]['idDepartamentoNomina'];
        $idDepartamentoInterno = $datos[1]['idDepartamentoInterno'];
        $ubicacion = $datos[1]['ubicacion'];
        $inactivo = $datos[1]['inactivo'];
        $idSupervisor = (isset($datos[1]['idSupervisor'])!='')?$datos[1]['idSupervisor']:0;
        //---MGFS 08-01-2020 ESTO ES PARA QUE PUEDAN ACCESAR DESDE EL PORTAL 
        $presupuesto=0;
        if($tipo=='O'){
          $presupuesto=1;
        }

        //-->NJES Feb/14/2020 se reciben parametros cliente y razón social para generar contrato cliente
        $idCliente = (isset($datos[1]['idCliente'])!='')?$datos[1]['idCliente']:0;
        $idRazonSocialCliente = (isset($datos[1]['idRazonSocialCliente'])!='')?$datos[1]['idRazonSocialCliente']:0;
        $idContrato = (isset($datos[1]['idContrato'])!='')?$datos[1]['idContrato']:0;

        if($tipo_mov==0){

          $query = "INSERT INTO deptos(cve_dep,des_dep,id_compania,id_unidad_negocio,id_sucursal,id_area,presupuesto,inactivo,domicilio,no_int,no_ext,colonia,codigo_postal,id_pais,
id_estado,id_municipio,id_departamento_nomina,id_departamento_interno,ubicacion,tipo,inicio_servicio,id_supervisor) VALUES ('$clave','$descripcion','$idSucursal','$idUnidad','$idSucursal'
,'$idArea','$presupuesto','$inactivo','$domicilio','$numInt','$numExt','$colonia','$cp','$idPais','$idEstado','$idMunicipio','$idDepartamentoNomina','$idDepartamentoInterno','$ubicacion','$tipo','$servicioInicio','$idSupervisor')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idDepartamento = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE deptos SET 
          cve_dep='$clave', 
          des_dep='$descripcion', 
          id_compania='$idSucursal',
          id_unidad_negocio='$idUnidad', 
          id_sucursal='$idSucursal',
          id_area='$idArea', 
          presupuesto='$presupuesto',
          inactivo='$inactivo', 
          domicilio='$domicilio', 
          no_int='$numInt',
          no_ext='$numExt', 
          colonia='$colonia',
          codigo_postal='$cp',
          id_pais='$idPais', 
          id_estado='$idEstado', 
          id_municipio='$idMunicipio', 
          id_departamento_nomina='$idDepartamentoNomina',
          id_departamento_interno='$idDepartamentoInterno',
          ubicacion='$ubicacion',
          tipo='$tipo',
          inicio_servicio='$servicioInicio',
          id_supervisor='$idSupervisor' 
          WHERE id_depto=".$idDepartamento;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
        {
          //$verifica = $idDepartamento;  
          $arr=array('idCliente'=>$idCliente,
                      'idRazonSocialCliente'=>$idRazonSocialCliente,
                      'idSupervisor'=>$idSupervisor,
                      'idDepartamento'=>$idDepartamento,
                      'tipo_mov'=>$tipo_mov,
                      'idContrato'=>$idContrato);

          $verifica = $this-> guardarContratoCliente($arr);
        }else
          $verifica = 0;

        
        return $verifica;
    }

    
    /**
      * Busca los datos de un departamento, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=activo 2=todos
      *
      **/
      function buscarDepartamentos($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE inactivo=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE inactivo=0';
        }

        $resultado = $this->link->query("SELECT deptos.id_depto AS id, deptos.cve_dep AS clave, 
        deptos.des_dep AS descripcion, deptos.inactivo,deptos.id_unidad_negocio,deptos.id_sucursal,
        IFNULL(cat_unidades_negocio.descripcion,'') AS unidad,IFNULL(sucursales.descr,'') AS sucursal,
        IFNULL(cat_areas.descripcion,'') AS area 
        FROM deptos 
        LEFT JOIN cat_unidades_negocio ON deptos.id_unidad_negocio=cat_unidades_negocio.id
        LEFT JOIN sucursales ON deptos.id_sucursal = sucursales.id_sucursal
        LEFT JOIN cat_areas ON deptos.id_area=cat_areas.id
        $condicionEstatus
        ORDER BY deptos.cve_dep");
        return query2json($resultado);

      }//- fin function buscarDepartamentos

      function buscarDepartamentosId($idDepartamento){
        //-->NJES Feb/14/2020 se obtiene el id_contrato,cliente y razons_social de contratos clientes si el departamentos es operativo y esta ligado
        $resultado = $this->link->query("SELECT
        deptos.id_depto as id, 
        deptos.cve_dep as clave,
        deptos.des_dep as descripcion,
        deptos.id_compania,
        deptos.id_unidad_negocio,
        deptos.id_sucursal,
        deptos.id_area,
        deptos.inactivo,
        deptos.domicilio,
        deptos.no_int,
        deptos.no_ext,
        deptos.colonia,
        deptos.codigo_postal,
        deptos.id_pais,
        deptos.id_estado,
        deptos.id_municipio,
        deptos.id_departamento_nomina,
        deptos.id_departamento_interno,
        IFNULL(deptos.ubicacion,'') AS ubicacion,
        deptos.tipo,
        IFNULL(deptos.inicio_servicio,'') AS inicio_servicio,
        deptos.id_supervisor,
        IFNULL(cat_areas.descripcion,'') AS area,
        IFNULL(cat_unidades_negocio.descripcion,'') AS unidad,IFNULL(sucursales.descr,'') AS sucursal,
        deptosN.des_dep AS departamento_nomina,
        deptosI.des_dep AS departamento_interno,
        municipios.municipio,
        estados.estado,
        paises.pais,
        IFNULL(CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)),'') AS supervisor,
        IFNULL(contratos_cliente.id_contrato,0) AS id_contrato,
        IFNULL(contratos_cliente.id_cliente,0) AS id_cliente,
        IFNULL(contratos_cliente.id_razon_social,0) AS id_razon_social,
        IFNULL(cat_clientes.nombre_comercial,'') AS cliente,
        IFNULL(razones_sociales.razon_social,'') AS razon_social_cliente
        FROM deptos 
        LEFT JOIN cat_unidades_negocio ON deptos.id_unidad_negocio=cat_unidades_negocio.id
        LEFT JOIN sucursales ON deptos.id_sucursal = sucursales.id_sucursal
        LEFT JOIN cat_areas ON deptos.id_area=cat_areas.id
        LEFT JOIN deptos AS  deptosN ON deptos.id_departamento_nomina= deptosN.id_depto
        LEFT JOIN deptos AS  deptosI ON deptos.id_departamento_interno= deptosI.id_depto
        LEFT JOIN municipios ON deptos.id_municipio=municipios.id
        LEFT JOIN estados ON deptos.id_estado=estados.id
        LEFT JOIN paises ON deptos.id_pais=paises.id
        LEFT JOIN trabajadores ON deptos.id_supervisor=trabajadores.id_trabajador
        LEFT JOIN contratos_cliente ON deptos.id_depto=contratos_cliente.id_depto
        LEFT JOIN cat_clientes ON contratos_cliente.id_cliente=cat_clientes.id
        LEFT JOIN razones_sociales ON contratos_cliente.id_razon_social = razones_sociales.id
        WHERE deptos.id_depto=".$idDepartamento."
        GROUP BY deptos.id_depto");
        return query2json($resultado);
          

      }//- fin function buscarDepartamentosId

      function buscarDepartamentosListaIds($idsDepartamento){
       
        $resultado = $this->link->query("SELECT id_depto AS idDepartamento, cve_dep AS clave, des_dep AS descripcion FROM deptos  WHERE id_depto in ($idsDepartamento) ORDER BY cve_dep");
        return query2json($resultado);
          

      }//- fin function buscarDepartamentosId

      /**
      * Busca la clave del deparamento en los 2 primero digitos del id de la sucursal y el incremental de departamento de la sucursal  0200001
      *
      * @param int $idSucursal  usado para indentificar en las Búsqueda de  des un departamento de esa sucursal y contar lo elemntos que existen e incrementarolo en 1
      *
    **/
    function buscarDepartamentoClave($idSucursal){

      /*
         if($num > 0){
         $dato=mysqli_fetch_array($result);
         $v = $dato['maximo'];
         $rest = substr($v, 2);
         $verifica = int($rest) + 1;
         
      }
      $verifica=str_pad($verifica, 5, "0", STR_PAD_LEFT);
      $suc=str_pad($idSucursal, 2, "0", STR_PAD_LEFT);
   
      return $suc.$verifica . ' werwerwerwer';

      */
      
      $verifica = 1;

      $query = "SELECT MAX(cve_dep) as maximo FROM deptos WHERE id_sucursal=".$idSucursal;
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0){
         $dato=mysqli_fetch_array($result);
         $rest = substr( $dato['maximo'], 2, strlen($dato['maximo']));
         $rest = intval($rest);
         $verifica = $rest + 1;
         
      }
      $verifica=str_pad($verifica, 5, "0", STR_PAD_LEFT);
      $suc=str_pad($idSucursal, 2, "0", STR_PAD_LEFT);
   
      return $suc.$verifica;

    }//-- fin function verificaDepartamentos

    /**
      * Busca los datos de un departamento, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=activo 2=todos
      *
      **/
      function buscarDepartamentosNomina(){

        $resultado = $this->link->query("SELECT deptos.id_depto AS id, deptos.cve_dep AS clave, 
        deptos.des_dep AS descripcion, deptos.inactivo,deptos.id_unidad_negocio,deptos.id_sucursal,
        IFNULL(cat_unidades_negocio.descripcion,'') AS unidad,IFNULL(sucursales.descr,'') AS sucursal,
        IFNULL(cat_areas.descripcion,'') AS area 
        FROM deptos 
        LEFT JOIN cat_unidades_negocio ON deptos.id_unidad_negocio=cat_unidades_negocio.id
        LEFT JOIN sucursales ON deptos.id_sucursal = sucursales.id_sucursal
        LEFT JOIN cat_areas ON deptos.id_area=cat_areas.id
        WHERE deptos.inactivo=0 AND deptos.id_unidad_negocio=1
        ORDER BY deptos.cve_dep");
        return query2json($resultado);

      }//- fin function buscarDepartamentos


      /**
      * Asigna un supervisor a un departamento
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=activo 2=todos
      *
      **/
      function asignarSupervisorDepartamentos($idDepartamento,$idSupervisor){
        $verifica = 0;

        $query = "UPDATE deptos SET id_supervisor='$idSupervisor' WHERE id_depto=".$idDepartamento;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
        if ($result) 
         $verifica = $idDepartamento;  

        return $verifica;  

    } //-- fin function guardarDepartamentos
 
    /**
      * Busca los departamentos de una cusursal seleccionada, y busca solo los activos (inactivo=0)
      * 
      * @param int $idSucursal para buscar los departamentos
      *
    **/
    function buscarDepartamentosIdSucursal($idSucursal){
      $result = $this->link->query("SELECT a.id_depto, a.des_dep AS departamento,
                                    a.id_area,IFNULL(b.descripcion,'') AS area,
                                    a.id_supervisor,IFNULL(CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido_p),' ',TRIM(c.apellido_m)),'') AS supervisor
                                    FROM deptos a
                                    LEFT JOIN cat_areas b ON a.id_area=b.id
                                    LEFT JOIN trabajadores c ON a.id_supervisor=c.id_trabajador
                                    WHERE a.id_sucursal=$idSucursal AND a.inactivo=0
                                    HAVING supervisor!=''
                                    ORDER BY a.des_dep");

        return query2json($result);
    }//-- fin function buscarDepartamentosIdSucursal

/**
      * Busca los datos de un departamento que aun no tiene contrato, retorna un JSON con los datos correspondientes
      * MGFS 14-11-2019 solo debe mostrar los departamentos operativos para la creacion de contratos (AND deptos.tipo='O')
      **/
      function buscarDepartamentosSinContratos($fecha,$idSucursal){


        $DeptosConContratos='';
        $deptosConContratos="SELECT IFNULL(GROUP_CONCAT(DISTINCT(id_depto)),'') AS ids_deptos FROM contratos_cliente WHERE vigencia<='$fecha'";
        $result = mysqli_query($this->link, $deptosConContratos) or die(mysqli_error());
        $numR = mysqli_num_rows($result);
        if($numR>0){
           $rowD = mysqli_fetch_array($result);
           $idsDptos= $rowD['ids_deptos'];
           if($idsDptos!=''){
              $DeptosConContratos='AND deptos.id_depto NOT IN($idsDptos)';
           }
           

        }

        $resultado = $this->link->query("SELECT deptos.id_depto AS id, deptos.cve_dep AS clave, IFNULL(deptos.id_supervisor,'') AS id_supervisor,
        deptos.des_dep AS descripcion, deptos.inactivo,deptos.id_unidad_negocio,deptos.id_sucursal,
        IFNULL(cat_unidades_negocio.descripcion,'') AS unidad,IFNULL(sucursales.descr,'') AS sucursal,
        IFNULL(cat_areas.descripcion,'') AS area 
        FROM deptos 
        LEFT JOIN cat_unidades_negocio ON deptos.id_unidad_negocio=cat_unidades_negocio.id
        LEFT JOIN sucursales ON deptos.id_sucursal = sucursales.id_sucursal
        LEFT JOIN cat_areas ON deptos.id_area=cat_areas.id
        WHERE deptos.inactivo=0  AND deptos.tipo='O' AND deptos.id_sucursal=".$idSucursal." $DeptosConContratos
        ORDER BY deptos.cve_dep");
        return query2json($resultado);

      }//- fin function buscarDepartamentos


      /**
      * Busca los datos de un departamento, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=activo 2=todos
      *
      **/
      function buscarDepartamentosInternos($idUnidadNegocio){

        $resultado = $this->link->query("SELECT deptos.id_depto AS id, deptos.cve_dep AS clave, 
        deptos.des_dep AS descripcion, deptos.inactivo,deptos.id_unidad_negocio,deptos.id_sucursal,
        IFNULL(cat_unidades_negocio.descripcion,'') AS unidad,IFNULL(sucursales.descr,'') AS sucursal,
        IFNULL(cat_areas.descripcion,'') AS area 
        FROM deptos 
        LEFT JOIN cat_unidades_negocio ON deptos.id_unidad_negocio=cat_unidades_negocio.id
        LEFT JOIN sucursales ON deptos.id_sucursal = sucursales.id_sucursal
        LEFT JOIN cat_areas ON deptos.id_area=cat_areas.id
        WHERE deptos.inactivo=0 AND deptos.id_unidad_negocio=".$idUnidadNegocio." AND deptos.tipo='I'
        ORDER BY deptos.cve_dep");
        return query2json($resultado);

      }//- fin function buscarDepartamentos


       /**
      * Busca los datos de un departamento, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=activo 2=todos
      *
      **/
      function buscarDepartamentosInternosOperaciones($idUnidad){
       
        $resultado = $this->link->query("SELECT deptos.id_depto AS id, deptos.cve_dep AS clave, 
        deptos.des_dep AS descripcion
        FROM deptos 
        WHERE deptos.id_unidad_negocio=".$idUnidad." AND inactivo=0 AND depto_operaciones=1 AND tipo='I'
        ORDER BY deptos.cve_dep");
        
        return query2json($resultado);
    
      }//- fin function buscarDepartamentos

      function guardarContratoCliente($datos){
        $verifica = 0;

        $idCliente = $datos['idCliente'];
        $idRazonSocialCliente = $datos['idRazonSocialCliente'];
        $idSupervisor = $datos['idSupervisor'];
        $idDepartamento = $datos['idDepartamento'];
        $tipo_mov = $datos['tipo_mov'];
        $idContrato = $datos['idContrato'];

        if($tipo_mov==0){

          $query = "INSERT INTO contratos_cliente(id_cliente,id_razon_social,id_supervisor,id_depto,fecha,vigencia) 
                    VALUES ('$idCliente','$idRazonSocialCliente','$idSupervisor','$idDepartamento',CURDATE(),'2030-12-31')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());

        }else{
          //-->NJES March/26/2020 verificar si el departamento ya tiene contrato, si ya lo tiene se actualiza, sino se inserta
          $busca = "SELECT id_contrato FROM contratos_cliente WHERE id_depto=".$idDepartamento;
          $resultB = mysqli_query($this->link, $busca) or die(mysqli_error());
          $numR = mysqli_num_rows($resultB);
          if($numR>0)
          {
            $query = "UPDATE contratos_cliente 
            SET id_cliente='$idCliente',id_razon_social='$idRazonSocialCliente',id_supervisor='$idSupervisor' 
            WHERE id_contrato=$idContrato AND id_depto=$idDepartamento";
          }else{
            $query = "INSERT INTO contratos_cliente(id_cliente,id_razon_social,id_supervisor,id_depto,fecha,vigencia) 
                    VALUES ('$idCliente','$idRazonSocialCliente','$idSupervisor','$idDepartamento',CURDATE(),'2030-12-31')";
          }
         
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
        }

        if($result)
          $verifica = $idDepartamento;
        else
          $verifica = 0;

        return $verifica;
      }
    
    
}//--fin de class Departamentos
    
?>