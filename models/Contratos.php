<?php

include 'conectar.php';

class Contratos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Contratos()
    {
  
      $this->link = Conectarse();

    }
    /**
      * Manda llamar a la funcion que guarda la informacion sobre una cliente
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización

      *
    **/      
    function guardarContratos($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarContratos


     /**
      * Guarda los datos de una cliente, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del cliente para realizarla
      * @param varchar $clave es una clave para identificar una cliente en particular
      * @param varchar $descripcion brebe descripcion de una cliente
      * @param int $ininactivo estatus de una cliente  1='inactivo' 0='Ininactivo'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;
        $tipoMovC = $datos[1]['tipoMovC'];
        $idContrato = $datos[1]['idContrato'];
        $idCliente = $datos[1]['idCliente'];
        $idRazonSocial = $datos[1]['idRazonSocial'];
        $idSupervisor = $datos[1]['idSupervisor'];
        $idDepartamento = $datos[1]['idDepartamento'];
        $fecha = $datos[1]['fecha'];
        $vigencia = $datos[1]['vigencia'];
        $idRsFactura = $datos[1]['idRsFactura'];
        $idRsContrato = $datos[1]['idRsContrato'];
        $idCotizacion = $datos[1]['idCotizacion'];
        $folioCotizacion = $datos[1]['folioCotizacion'];
        $tipoContrato = $datos[1]['tipoContrato'];
        $archivoActual = $datos[1]['archivoActual'];

        
        if($tipoMovC==0){

          $folioContrato = 0;
          //--- verifico si la cotizacion ya tiene un folio de contrato  si no voy poor el folio de contrTO actual  DE LA UNIDA DE NEGOCIO
          $buscaFolioC="SELECT IFNULL(a.folio_contrato,0) AS folio_contrato FROM contratos_cliente a WHERE a.id_cotizacion=".$idCotizacion." LIMIT 1 ";
          $resultFC = mysqli_query($this->link, $buscaFolioC) or die(mysqli_error());
          $nrowsFC = mysqli_num_rows($resultFC);
          if($nrowsFC>0){

            $rowsFC = mysqli_fetch_array($resultFC);
            $folioContrato = $rowsFC['folio_contrato'];

          }else{

            $queryFolio="SELECT b.folio_doc_contrato,b.id as idUnidadNegocio
            FROM cat_unidades_negocio b
            WHERE b.id=(SELECT id_unidad_negocio FROM proyecto WHERE id=(SELECT id_proyecto FROM cotizacion WHERE id=".$idCotizacion."))";
            $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
            if($resultF){

              $dato_folio=mysqli_fetch_array($resultF);
              $idUnidadNegocio = $dato_folio['idUnidadNegocio'];
              $folioA=$dato_folio['folio_doc_contrato'];
              $folioContrato= $folioA+1;
    
              $queryU = "UPDATE cat_unidades_negocio SET folio_doc_contrato='$folioContrato' WHERE id=".$idUnidadNegocio;
              $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
            }
          }
        

            $query = "INSERT INTO contratos_cliente(id_cliente,id_razon_social, id_supervisor, id_depto, fecha, vigencia,id_razon_social_factura,id_razon_social_contratacion,id_cotizacion,folio_cotizacion,tipo_contrato,doc_contrato,folio_contrato) VALUES 
            ('$idCliente','$idRazonSocial','$idSupervisor','$idDepartamento','$fecha','$vigencia','$idRsFactura','$idRsContrato','$idCotizacion','$folioCotizacion','$tipoContrato','$archivoActual','$folioContrato')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idContrato = mysqli_insert_id($this->link);

          
        }else{

          $query = "UPDATE contratos_cliente SET 
          id_cliente='$idCliente',
          id_razon_social='$idRazonSocial',
          id_supervisor='$idSupervisor', 
          id_depto='$idDepartamento', 
          fecha='$fecha', 
          vigencia='$vigencia',
          id_razon_social_factura='$idRsFactura',
          id_razon_social_contratacion='$idRsContrato',
          id_cotizacion='$idCotizacion',
          folio_cotizacion='$folioCotizacion',
          tipo_contrato='$tipoContrato',
          doc_contrato='$archivoActual'
          WHERE id_contrato=".$idContrato;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result){
         
          //**Se actuliza la fecha incio de servicio del departamento solo si es operativo ** */
          $buscaDepto="SELECT id_depto FROM deptos WHERE id_depto=".$idDepartamento." AND tipo='O'";
          $resultDep = mysqli_query($this->link, $buscaDepto) or die(mysqli_error());
          $numDep = mysqli_num_rows($resultDep);

          if($numDep>0){

            $query2 = "UPDATE deptos SET inicio_servicio='$fecha' WHERE id_depto=".$idDepartamento." AND tipo='O'";
            $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());

            if($result2){
              //$verifica = $this-> descargarContrato($idContrato);
              $verifica = $idContrato;  
            }else{
              $verifica = 0;  
            }

          }else{
            //$verifica = $this-> descargarContrato($idContrato);
            $verifica = $idContrato;  
          }
          
         
         
          
          
        }
          

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una cliente, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=ininactivo 2=todos
      *
      **/
      function buscarContratos(){

        $resultado = $this->link->query("SELECT id_cliente, id_razon_social, id_supervisor, id_depto, fecha, vigencia,id_razon_social_factura,id_razon_social_contratacion,id_cotizacion,folio_cotizacion 
        FROM contratos_cliente
        ORDER BY vigencia");
        return query2json($resultado);

      }//- fin function buscarContratos

      function buscarContratosId($idContrato){
        
        $resultado = $this->link->query("SELECT
        contratos_cliente.id_contrato, 
        contratos_cliente.id_cliente,
        contratos_cliente.id_razon_social, 
        contratos_cliente.id_supervisor, 
        contratos_cliente.id_depto, 
        contratos_cliente.fecha, 
        contratos_cliente.vigencia,
        contratos_cliente.id_razon_social_factura,
        contratos_cliente.id_razon_social_contratacion,
        contratos_cliente.id_cotizacion,
        contratos_cliente.folio_cotizacion,
        contratos_cliente.tipo_contrato,
        contratos_cliente.doc_contrato,
        CONCAT(deptos.cve_dep,' - ',deptos.des_dep) AS departamento,
        IFNULL(empresas_fiscales.razon_social,'') AS rs_factura,
        IFNULL(e_fiscales.razon_social,'') AS rs_contrato,
        cotizacion.texto_inicio,
        cotizacion.texto_fin,
        proyecto.id_sucursal
            
            FROM contratos_cliente
            LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
            LEFT JOIN empresas_fiscales ON contratos_cliente.id_razon_social_factura=empresas_fiscales.id_empresa
            LEFT JOIN empresas_fiscales AS e_fiscales ON contratos_cliente.id_razon_social_contratacion=e_fiscales.id_empresa
            LEFT JOIN cotizacion ON contratos_cliente.id_cotizacion=cotizacion.id
            LEFT JOIN proyecto ON cotizacion.id_proyecto=proyecto.id
            WHERE contratos_cliente.id_contrato=".$idContrato."
            ORDER BY contratos_cliente.id_contrato");
        return query2json($resultado);
          
      }//- fin function buscarContratosId

      function buscarContratosIdCliente($idCliente){
        
        $resultado = $this->link->query("SELECT
        contratos_cliente.id_contrato, 
        contratos_cliente.fecha, 
        contratos_cliente.vigencia,
        CONCAT(deptos.cve_dep,' - ',deptos.des_dep)AS departamento,
        razones_sociales.razon_social AS rs_cliente,
        razones_sociales.rfc,
        razones_sociales.nombre_corto,
        IFNULL(CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido_p),' ',TRIM(c.apellido_m)),'') AS supervisor,
        IFNULL(empresas_fiscales.razon_social,'') AS rs_factura,
        IFNULL(e_fiscales.razon_social,'') AS rs_contrato
                FROM contratos_cliente
                LEFT JOIN deptos ON contratos_cliente.id_depto=deptos.id_depto
                LEFT JOIN trabajadores c ON contratos_cliente.id_supervisor=c.id_trabajador
                LEFT JOIN razones_sociales ON contratos_cliente.id_razon_social=razones_sociales.id
                LEFT JOIN empresas_fiscales ON contratos_cliente.id_razon_social_factura=empresas_fiscales.id_empresa
                LEFT JOIN empresas_fiscales AS e_fiscales ON contratos_cliente.id_razon_social_contratacion=e_fiscales.id_empresa
                WHERE contratos_cliente.id_cliente=".$idCliente."
                ORDER BY contratos_cliente.id_contrato");
        return query2json($resultado);
          

      }//- fin function buscarContratosId


      /**
      * GUARDAR CONTRATO
      *
      **/
      function guardarArchivoContrato($idContrato,$tipoContrato,$ele){
        
        $verifica = '';

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarArchivos($idContrato,$tipoContrato,$ele);

        if($verifica !='')
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarUnidadesNegocio




      function guardarArchivos($idContrato,$tipoContrato,$ele,$rutaAnterior){
    
        $verifica = '';
        
        @unlink($rutaAnterior);
       
        if(isset($_FILES['archivo_'.$ele]['name'])){
    
          $nombreDocBd=$tipoContrato.'_'.$idContrato.'.pdf';
          $ruta_img = "../contratos_editados/".$nombreDocBd;
          
          if((move_uploaded_file($_FILES['archivo_'.$ele]['tmp_name'],$ruta_img))){
  
             $query = "UPDATE contratos_cliente SET doc_contrato='$nombreDocBd' WHERE id_contrato=".$idContrato;
             $result = mysqli_query($this->link, $query) or die(mysqli_error());
          
             if ($result) {
              
               $verifica = $nombreDocBd; 
              
              }else{
                $verifica ='';
              }
  
          }
  
        }
         return $verifica;
       
      }
    
}//--fin de class Contratos
    
?>