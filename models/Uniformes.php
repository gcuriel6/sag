<?php

include 'conectar.php';

class Uniformes
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Uniformes()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la clave del uniforme no se repita
      *
      * @param varchar $clave  usado para indentificar en las Búsqueda de  des un uniforme
      *
    **/
    function verificarUniformes($clave,$idSucursal){
      
      $verifica = 0;

      $query = "SELECT id FROM cat_uniformes WHERE clave = '$clave' AND id_sucursal=".$idSucursal;
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaUniformes

    /**
      * Manda llamar a la funcion que guarda la informacion sobre un uniforme
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar un uniforme en particular
      * @param varchar $nombre  de la prenda particular
      * @param varchar $descripcion brebe descripcion de la prenda de un uniforme
      * @param double $costo  de la prenda particular
      * @param int $inactivo estatus de un uniforme  1='activo' 0='Inactivo'  
      *
    **/      
    function guardarUniformes($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarUniformes


     /**
      * Guarda los datos de un uniforme, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar un uniforme en particular
      * @param varchar $nombre  de la prenda particular
      * @param varchar $descripcion brebe descripcion de la prenda de un uniforme
      * @param double $costo  de la prenda particular
      * @param int $inactivo estatus de un uniforme  1='activo' 0='Inactivo' 
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idUniforme = $datos[1]['idUniforme'];
        $tipo_mov = $datos[1]['tipo_mov'];
        $clave = $datos[1]['clave'];
        $nombre = $datos[1]['nombre'];
        $descripcion = $datos[1]['descripcion'];
        $costo = $datos[1]['costo'];
        $activo = $datos[1]['activo'];
        $idSucursal = $datos[1]['idSucursal'];

        if($tipo_mov==0){

          $query = "INSERT INTO cat_uniformes(clave,nombre,descripcion,costo,activo,id_sucursal) VALUES ('$clave','$nombre','$descripcion','$costo','$activo','$idSucursal')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idUniforme = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_uniformes SET clave='$clave',nombre='$nombre',descripcion='$descripcion',costo='$costo',activo='$activo',id_sucursal='$idSucursal' WHERE id=".$idUniforme;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idUniforme;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de un uniforme, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activo 0=inactivo 2=todos
      *
      **/
      function buscarUniformes($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE activo=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE activo=0';
        }

        $resultado = $this->link->query("SELECT id,clave,nombre,descripcion,FORMAT(costo,2)as costo,activo,id_sucursal 
FROM cat_uniformes
$condicionEstatus
ORDER BY clave");
        return query2json($resultado);

      }//- fin function buscarUniformes

      function buscarUniformesId($idUniforme){
        $resultado = $this->link->query("SELECT id,clave,nombre,descripcion,FORMAT(costo,2)as costo,activo,id_sucursal  
FROM cat_uniformes 
WHERE id=$idUniforme
ORDER BY clave");
        return query2json($resultado);
          

      }//- fin function buscarUniformesId

      /**
      * Busca los registros de uniformes que pertenecen a una sucurdal especificada
      *
      * @param int $idSucursal de la que se van a buscar los datos
      * 
      **/
      function buscarUniformesIdSucursal($idSucursal){
        $resultado = $this->link->query("SELECT id,clave,nombre,descripcion,costo
                                            FROM cat_uniformes
                                            WHERE id_sucursal=$idSucursal
                                            ORDER BY clave");
        return query2json($resultado);
      }//- fin function buscarUniformesId
 

    
}//--fin de class Uniformes
    
?>