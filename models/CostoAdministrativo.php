<?php

include 'conectar.php';

class CostoAdministrativo
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function CostoAdministrativo()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que no se registre mas de un costo con una misma sucursal y unidad de negocio
      *
      * @param int $id_unidad_negocio es una clave para identificar si ya existe un costo
      * @param int $id_sucursal es una clave para identificar si ya existe un costo
      *
      **/
    function verificarCostoAdministrativo($id_unidad_negocio,$id_sucursal){
        $verifica = 0;

        $query = "SELECT id FROM cat_costos_administrativos WHERE id_unidad_negocio=$id_unidad_negocio AND id_sucursal=$id_sucursal";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
            $verifica = 1;

        return $verifica;
    }//-- fin function verificarCostoAdministrativo  

    /**
      * Busca los datos de cat_costos_administrativos, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos
      * @param varchar $lista  lista con las unidades separadas por coma
      *
      **/
    function buscarCostoAdministrativo($estatus,$lista){

        $unidades='';
        if($lista != ''){
            $dato=substr($lista,1);
            $unidades = ' a.id_unidad_negocio IN('.$dato.') AND ';
        }
      
        $condicion='';
        if( $estatus == 0 )
        {
            $condicion=' AND a.activo=1 ';
        }else if( $estatus == 1 ){
            $condicion=' AND a.activo=0 ';
        }else{
            $condicion='';
        }
        
        $result1 = $this->link->query("SELECT a.id,a.id_unidad_negocio,a.costo,a.activo,b.nombre AS unidad_negocio, c.descr AS sucursal
                                            FROM cat_costos_administrativos a 
                                            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                                            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                                            WHERE $unidades b.inactivo=0 $condicion
                                            ORDER BY a.id");
    
        return query2json($result1);
    }//-- fin function buscarCostoAdministrativo

    /**
      * Busca los datos de cat_costos_administrativos, retorna un JSON con los datos correspondientes
      * 
      * @param int $idCostoAdministrativo trae los datos de idCostoAdministrativo requerido
      *
      **/
    function buscarCostoAdministrativoId($idCostoAdministrativo){
    
        $result = $this->link->query("SELECT a.id,a.costo,a.activo,a.id_unidad_negocio,a.id_sucursal
                                        FROM cat_costos_administrativos a 
                                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                                        WHERE a.id=".$idCostoAdministrativo);
        return query2json($result);
        
    }//-- fin function buscarCostoAdministrativoId

    /**
      * Manda llamar a la funcion que guarda la informacion
      * 
      * @param varchar $datos es un array que contiene los parametros
      *
      **/   
    function guardarCostosAdministrativos($datos){
        $verifica = 0;
  
       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");
  
        $verifica = $this -> guardarActualizar($datos);
  
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
  
        return $verifica;
    }//-- fin function guardarCostosAdministrativos

    /**
      * Guarda los datos de un costo administrativo, regresa el id de la sucursal afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param varchar $datos es un array que contiene los parametros
      * idCostoAdministrativo del registro a actualizar
      * id_unidad_negocio --> id_de la unidad de negocio a la que pertenece el registro
      * id_sucursal --> id_de la sucursal a la que pertenece el registro
      * costo --> cantidad consto
      * inactivo  --> estatus del registro 1=activo, 0=inactivo 
      * tipo_mov  --> indica si es una insercion = 0 ó actualizacion = 1
      *
      **/ 
    function guardarActualizar($datos){
  
        $verifica = 0;

        $idCostoAdministrativo = $datos['idCostoAdministrativo'];
        $id_unidad_negocio = $datos['id_unidad_negocio'];
        $id_sucursal = $datos['id_sucursal'];
        $costo = $datos['costo'];
        $inactivo = $datos['inactivo'];
        $tipo_mov = $datos['tipo_mov'];
        
        if($tipo_mov==0){

            $query = "INSERT INTO cat_costos_administrativos(costo,activo,id_unidad_negocio,id_sucursal)
                        VALUES ('$costo','$inactivo','$id_unidad_negocio','$id_sucursal')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);

            if ($result) {
                $verifica = 1;
            }else{
                $verifica = 0;
            }

        }else{

            $query = "UPDATE cat_costos_administrativos SET costo='$costo',activo='$inactivo',id_unidad_negocio='$id_unidad_negocio',id_sucursal='$id_sucursal' WHERE id=".$idCostoAdministrativo;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            
            if ($result) {
                $verifica = 1;
            }else{
                $verifica = 0;
            }
        }
        
        return $verifica;
    }//--fin function guardarActualizar

    /**
      * Busca el costo de una unidad de negocio y una sucursal
      * 
      * @param int $idUnidadNegocio de la unidad de negocio de registro
      * @param int $idSucursal de la sucursal de registro
      *
      **/
    function buscarCostoAdministrativoCosto($idUnidadNegocio,$idSucursal){
        $result = $this->link->query("SELECT id,costo
                                        FROM cat_costos_administrativos 
                                        WHERE id_unidad_negocio=".$idUnidadNegocio." 
                                        AND id_sucursal=".$idSucursal." 
                                        AND activo=1");
        return query2json($result);
    }//--fin function buscarCostoAdministrativoCosto

}//--fin de class CostoAdministrativo
    
?>