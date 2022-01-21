<?php

include 'conectar.php';

class Proveedores
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Proveedores()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el nombre en rfc no se repita
      *
      * @param varchar $rfc  usado para ingresar al sistema
      *
      **/
      function verificarProveedores($rfc){
      
        $verifica = 0;
  
        $query = "SELECT id FROM proveedores WHERE rfc = '$rfc'";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);
  
        if($num > 0)
          $verifica = 1;
  
         return $verifica;
  
      }//-- fin function verificaProveedores
  
      /**
        * Manda llamar a la funcion que guarda la informacion sobre una proveedor
        * @param array $datos todos los datos necesarios para dar de alta o actualizar un proveedor
        *
        **/      
      function guardarProveedores($datos){
      
          $verifica = 0;
  
         $this->link->begin_transaction();
         $this->link->query("START TRANSACTION;");
  
          $verifica = $this -> guardarActualizar($datos);
  
          if($verifica > 0)
              $this->link->query("commit;");
          else
              $this->link->query('rollback;');
  
          return $verifica;
  
      } //-- fin function guardarProveedores
  
  
       /**
        * Guarda los datos de una proveedor, regresa el id de la proveedor afectada si se realiza la accion correctamete ó 0 si ocurre algun error
        * 
        * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
        * @param int $idProveedor id del proveedor a generar si es nuevo es 0 si actualizacion debe ser mayor a 0
        * @param varchar $rfc es una rfc para identificar una proveedor
        * @param varchar $nombre es el nombre asignado a una proveedor
        * @param varchar $domicilio domicilio del proveedor
        * @param int $cp  Código Postal del provvedor
        * @param int  $inactivo estatus de una proveedor 0='Activo' 1='Inactivo'  
        *
        **/ 
        function guardarActualizar($datos){
            
          $verifica = 0;

          $tipo_mov = $datos[1]['tipo_mov'];
          $idProveedor = $datos[1]['idProveedor'];
          $nombre = $datos[1]['nombre'];
          $rfc = $datos[1]['rfc'];
          $domicilio = $datos[1]['domicilio'];
          $cp = $datos[1]['cp'];
          $colonia = $datos[1]['colonia'];
          $num_int = $datos[1]['numInt'];
          $num_ext = $datos[1]['numExt'];
          $facturable = $datos[1]['facturable'];
          $id_pais = $datos[1]['idPais'];
          $id_estado = $datos[1]['idEstado'];
          $id_municipio = $datos[1]['idMunicipio'];
          $id_banco = $datos[1]['idBanco'];
          $cuenta = $datos[1]['cuenta'];
          $clabe = $datos[1]['clabe'];
          $diasCredito = $datos[1]['diasCredito'];
          $telefono = $datos[1]['telefono'];
          $extension = $datos[1]['extension'];
          $web = $datos[1]['web'];
          $contacto = $datos[1]['contacto'];
          $condiciones = $datos[1]['condiciones'];
          $grupo = $datos[1]['grupo'];
          $inactivo = $datos[1]['inactivo'];
          $idUsuario = $datos[1]['idUsuario'];
          $modulo = $datos[1]['modulo'];
          $idUnidadNegocio = isset($datos[1]['idUnidadNegocio']) ? $datos[1]['idUnidadNegocio'] : 0;
          $aprobado = isset($datos[1]['aprobado']) ? $datos[1]['aprobado'] : 0;
  
          if($tipo_mov==0){
  
            $query = "INSERT INTO proveedores(nombre,rfc,domicilio,cp,colonia,num_int,num_ext,facturable,id_pais,id_estado,id_municipio,
            id_banco,cuenta,clabe,dias_credito,telefono,extension,web,contacto,condiciones,grupo,inactivo,id_usuario,modulo,aprobado) VALUES 
            ('$nombre','$rfc','$domicilio','$cp','$colonia','$num_int','$num_ext','$facturable','$id_pais','$id_estado','$id_municipio',
            '$id_banco','$cuenta','$clabe','$diasCredito','$telefono','$extension','$web','$contacto','$condiciones','$grupo','$inactivo','$idUsuario','$modulo','$aprobado')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idProveedor = mysqli_insert_id($this->link);
            if ($result) {

              //--MGFS 13-12-2019 Asignar unidad de negocio a proveedor desde su creación 
              //-- cuando se de de alta desde requisiciones o gastos ISSUE DEN18-2470
              if($modulo=='R' || $modulo=='G'){

                $queryA = "INSERT INTO proveedores_unidades(id_proveedor,id_unidad) VALUES ('$idProveedor','$idUnidadNegocio')";
                $resultA = mysqli_query($this->link, $queryA) or die(mysqli_error());
                if($resultA){

                  $verifica = $idProveedor;  

                }else{

                  $verifica = 0;
                }

              }else{
                $verifica = $idProveedor;  
              }
            }
            
  
          }else{
  
            $query = "UPDATE proveedores SET 
            nombre='$nombre',
            rfc='$rfc',
            domicilio='$domicilio',
            cp='$cp',
            colonia='$colonia',
            num_int='$num_int',
            num_ext='$num_ext',
            facturable='$facturable',
            id_pais='$id_pais',
            id_estado='$id_estado',
            id_municipio='$id_municipio',
            id_banco='$id_banco',
            cuenta='$cuenta',
            clabe='$clabe',
            dias_credito='$diasCredito',
            telefono='$telefono',
            extension='$extension',
            web='$web',
            contacto='$contacto',
            condiciones='$condiciones',
            grupo='$grupo',
            inactivo='$inactivo',
            id_usuario='$idUsuario',
            modulo='$modulo',
            aprobado='$aprobado'
            WHERE id=".$idProveedor;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if ($result) 
            $verifica = $idProveedor;  
      
          }
          
          
  
          
          return $verifica;
      }
  

    /**
      * Busca los datos de proveedores, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos
      *
      **/
    function buscarProveedores($estatus){
      
        $condicion='';
        if( $estatus == 0 )
        {
            $condicion=' WHERE proveedores.corporativo=0 AND proveedores.inactivo=0 AND proveedores.rechazado=0';
        }else if( $estatus == 1 ){
            $condicion=' WHERE proveedores.corporativo=0 AND proveedores.inactivo=1 AND proveedores.rechazado=0';
        }else{
            $condicion=' WHERE proveedores.corporativo=0 AND proveedores.rechazado=0';
        }
          
        $result1 = $this->link->query("SELECT proveedores.id,proveedores.nombre,proveedores.rfc,proveedores.grupo,proveedores.aprobado,usuarios.nombre_comp AS usuario
        FROM proveedores
        LEFT JOIN usuarios ON proveedores.id_usuario=usuarios.id_usuario
        $condicion 
        ORDER BY proveedores.nombre DESC");
    
        return query2json($result1);
    }//-- fin function buscarProveedores

    
    /** -- Muestra todos los proveedores que estan aprobados y activos (proveedores agregados de requis y gastos requieren aprobacion)--- */
    function buscarProveedoresUnidad($idUnidad)
    {

        $resultP = $this->link->query("SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc, proveedores.aprobado 
            FROM proveedores
            INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
            WHERE proveedores.inactivo = 0 AND proveedores.corporativo=0 AND proveedores.aprobado=1 AND proveedores_unidades.id_unidad = $idUnidad
            ORDER BY  proveedores.nombre");

        return query2json($resultP);

    }

    /**
      * Busca los datos de proveedores, retorna un JSON con los datos correspondientes
      * 
      * @param int $idProveedor del registro que esta buscando
      *
      **/
    function buscarProveedoresId($idProveedor){
      
        $result = $this->link->query("SELECT 
        a.id,
        a.nombre,
        a.rfc,
        a.domicilio,
        a.cp,
        IFNULL(a.colonia,'') AS colonia,
        IFNULL(a.num_int,'') AS num_int,
        IFNULL(a.num_ext,'') AS num_ext,
        a.facturable,
        a.id_pais,
        a.id_estado,
        a.id_municipio,
        a.id_banco,
        a.cuenta,
        a.clabe,
        a.dias_credito,
        IFNULL(a.telefono,'') AS telefono,
        IFNULL(a.extension,'') AS extension,
        IFNULL(a.web,'') AS web,
        IFNULL(a.contacto,'') AS contacto,
        IFNULL(a.condiciones,'') AS condiciones,
        a.grupo,
        a.inactivo,
        a.id_usuario,
        a.modulo,
        a.aprobado,
        IFNULL(b.municipio,'') AS municipio,
        IFNULL(c.estado,'') AS estado,
        IFNULL(d.pais,'') AS pais,
        IFNULL(e.descripcion,'') AS banco                                        
        FROM proveedores a
        LEFT JOIN municipios b ON a.id_municipio=b.id
        LEFT JOIN estados c ON a.id_estado=c.id
        LEFT JOIN paises d ON a.id_pais=d.id
        LEFT JOIN bancos e ON a.id_banco=e.id
        WHERE a.id=".$idProveedor);
    
        return query2json($result);
    }//-- fin function buscarProveedoresId


        /**
      * Busca los datos de proveedores se de dieron de alta en el modulo de gastos, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos

      *
      **/
      function buscarProveedoresAprobar($estatus){
        
        $result1 = $this->link->query("SELECT proveedores.id,proveedores.nombre,proveedores.rfc,proveedores.grupo,usuarios.nombre_comp AS usuario,GROUP_CONCAT(IFNULL(id_unidad,''))AS unidades
        FROM proveedores
        LEFT JOIN usuarios ON proveedores.id_usuario=usuarios.id_usuario
        LEFT JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
        WHERE proveedores.corporativo=0 AND proveedores.modulo IN('G','R') AND proveedores.rechazado=0  AND proveedores.aprobado=0
        GROUP BY proveedores.id
        ORDER BY proveedores.id DESC");
    
        return query2json($result1);
    }//-- fin function buscarProveedores

    /**
        * Manda llamar a la funcion que guarda la informacion sobre una proveedor
        * @param array $datos todos los datos necesarios para dar de alta o actualizar un proveedor
        *
        **/      
        function rechazarAprobarProveedor($idProveedor,$rechazar,$aprobar){
      
          $verifica = 0;
  
         $this->link->begin_transaction();
         $this->link->query("START TRANSACTION;");
          
         $query = "UPDATE proveedores SET rechazado='$rechazar', aprobado='$aprobar' WHERE id=".$idProveedor;
         $verifica = mysqli_query($this->link, $query) or die(mysqli_error());
  
          if($verifica > 0)
              $this->link->query("commit;");
          else
              $this->link->query('rollback;');
  
          return $verifica;
  
      } //-- fin function guardarProveedores

    function buscarProveedoresCorporativo($idUnidad)
    {

        $resultP = $this->link->query("SELECT sub.id, sub.nombre, sub.rfc 
        FROM (
          SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc
          FROM proveedores
          INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
          WHERE proveedores.inactivo = 0 AND  proveedores_unidades.id_unidad = ".$idUnidad."
          UNION 
          SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc
          FROM proveedores
          INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
          WHERE proveedores.inactivo = 0 AND  proveedores.corporativo=1 AND  proveedores.aprobado=1
              )AS sub
        ORDER BY sub.nombre ASC");

        return query2json($resultP);

    }

    function buscarProveedoresAprobadosUnidad($idUnidad,$rfc)
    {
      $condRFC = '';

      if($rfc != '')
        $condRFC = " AND proveedores.rfc != '$rfc'";

        $resultP = $this->link->query("SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc, proveedores.aprobado 
            FROM proveedores
            INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
            WHERE proveedores.inactivo = 0 AND proveedores.corporativo=0 AND proveedores.rechazado=0 AND proveedores.aprobado=1 
            AND proveedores_unidades.id_unidad = $idUnidad $condRFC
            ORDER BY  proveedores.nombre");

        return query2json($resultP);

    }
    /**
      * Verifica que el nombre en rfc no se repita
      *
      * @param varchar $rfc  usado para ingresar al sistema
      *
      **/
      function verificarProveedoresAsigna($rfc,$idUnidadNegocio){
      
        $verifica = 0;
  
        //-->verifico si existe el rfc
        $query = "SELECT id FROM proveedores WHERE rfc = '$rfc'";  
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);
  
        if($num > 0)
        {
          //-->verifico si el rfc esta asignado a una unidad de negocio
          $resultA = $this->link->query("SELECT a.id FROM proveedores a 
                      LEFT JOIN proveedores_unidades b ON a.id=b.id_proveedor
                      WHERE a.rfc = '$rfc'");     
          $numA = mysqli_num_rows($resultA);

          if($numA > 0)
          {
            //-->verifico si esta asignado a la unidad de negocio seleccionada
            $queryB = "SELECT a.id FROM proveedores a 
            LEFT JOIN proveedores_unidades b ON a.id=b.id_proveedor
            WHERE a.rfc = '$rfc' AND b.id_unidad=".$idUnidadNegocio;
            $resultB = mysqli_query($this->link, $queryB)or die(mysqli_error());
            $numB = mysqli_num_rows($resultB);

            if($numB > 0)
              $verifica = 1;
            else
            {
              $resultado = $this->link->query("SELECT GROUP_CONCAT(c.nombre) AS unidades,
                          a.id AS id_proveedor
                          FROM proveedores a         
                          LEFT JOIN proveedores_unidades b ON a.id=b.id_proveedor    
                          LEFT JOIN cat_unidades_negocio c ON b.id_unidad=c.id      
                          WHERE a.rfc = '$rfc'");
              $verifica = query2json($resultado);
            }

          }
        }
  
        return $verifica;
  
      }//-- fin function verificarProveedoresAsigna

      function asignarProveedores($idProveedor,$idUnidadNegocio){
        
        $verifica = 0;
  
        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");
 
        $verifica = $this -> guardarAsignar($idProveedor,$idUnidadNegocio);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
      }//-- fin function asignarProveedores
  
      function guardarAsignar($idProveedor,$idUnidadNegocio){
        $verifica = 0;

        $query = "INSERT INTO proveedores_unidades(id_proveedor,id_unidad) 
                  VALUES ('$idProveedor','$idUnidadNegocio')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result)
          $verifica = 1; 

        return $verifica;
      }


    function buscarProveedoresTodosUnidad($idUnidad)
    {

        $resultP = $this->link->query("SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc, proveedores.aprobado 
            FROM proveedores
            INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
            WHERE proveedores.inactivo = 0 AND proveedores.corporativo=0 AND proveedores.rechazado=0 AND proveedores_unidades.id_unidad = $idUnidad
            ORDER BY  proveedores.nombre");

        return query2json($resultP);

    }

}//--fin de class Proveedores
    
?>