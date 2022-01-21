<?php

include 'conectar.php';

class Areas
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Areas()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la clave del area no se repita
      *
      * @param varchar $clave  usado para indentificar en las Búsqueda de  des un area
      *
    **/
    function verificarAreas($clave){
      
      $verifica = 0;

      $query = "SELECT id FROM cat_areas WHERE clave = '$clave'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaAreas

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una area
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una area en particular
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $inactiva estatus de una area  1='Activa' 0='Inactiva'  
      *
    **/      
    function guardarAreas($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarAreas


     /**
      * Guarda los datos de una area, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del area para realizarla
      * @param varchar $clave es una clave para identificar una area en particular
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $inactiva estatus de una area  1='Activa' 0='Inactiva'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idArea = $datos[1]['idArea'];
        $tipo_mov = $datos[1]['tipo_mov'];
        $clave = $datos[1]['clave'];
        $descripcion = $datos[1]['descripcion'];
        $activa = $datos[1]['activa'];
        $idSucursal = ($datos[1]['idSucursal'] == null ? 0 : $datos[1]['idSucursal']);

        if($tipo_mov==0){

          $query = "INSERT INTO cat_areas(clave,descripcion,activa,id_sucursal) VALUES ('$clave','$descripcion','$activa','$idSucursal')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idArea = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_areas SET clave='$clave',descripcion='$descripcion',activa='$activa',id_sucursal='$idSucursal' WHERE id=".$idArea;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idArea;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activa 0=inactiva 2=todos
      *
      **/
      function buscarAreas($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE activa=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE activa=0';
        }

        $resultado = $this->link->query("SELECT id,clave,descripcion,activa,id_sucursal 
FROM cat_areas
$condicionEstatus
ORDER BY clave");
        return query2json($resultado);

      }//- fin function buscarAreas

      function buscarAreasId($idArea){
        $resultado = $this->link->query("SELECT id,clave,descripcion,activa,id_sucursal  
FROM cat_areas 
WHERE id=$idArea
ORDER BY clave");
        return query2json($resultado);
          

      }//- fin function buscarAreasId
 

    
}//--fin de class Areas
    
?>