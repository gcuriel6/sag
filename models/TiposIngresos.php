<?php

include 'conectar.php';

class TiposIngresos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function TiposIngresos()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la descripcion del area no se repita
      *
      * @param varchar $descripcion  usado para indentificar en las Búsqueda de  des un area
      *
    **/
    function verificarTiposIngresos($descripcion){
      
      $verifica = 0;

      $query = "SELECT id FROM cat_tipos_ingreso WHERE descripcion = '$descripcion'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaTiposIngresos

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una area
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $ininactivo estatus de una area  1='inactivo' 0='Ininactivo'  
      *
    **/      
    function guardarTiposIngresos($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarTiposIngresos


     /**
      * Guarda los datos de una area, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del area para realizarla
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $ininactivo estatus de una area  1='inactivo' 0='Ininactivo'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idTipoIngreso = $datos[1]['idTipoIngreso'];
        $tipoMov = $datos[1]['tipoMov'];
        $descripcion = $datos[1]['descripcion'];
        $inactivo = $datos[1]['inactivo'];

        if($tipoMov==0){

          $query = "INSERT INTO cat_tipos_ingreso(descripcion, inactivo) VALUES ('$descripcion','$inactivo')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idTipoIngreso = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_tipos_ingreso SET descripcion='$descripcion', inactivo='$inactivo' WHERE id=".$idTipoIngreso;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idTipoIngreso;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=ininactivo 2=todos
      *
      **/
      function buscarTiposIngresos($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE inactivo=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE inactivo=0';
        }

        $resultado = $this->link->query("SELECT id,descripcion,inactivo 
FROM cat_tipos_ingreso
$condicionEstatus
ORDER BY descripcion");
        return query2json($resultado);

      }//- fin function buscarTiposIngresos

      function buscarTiposIngresosId($idTipoIngreso){
        $resultado = $this->link->query("SELECT id,descripcion,inactivo 
FROM cat_tipos_ingreso 
WHERE id=$idTipoIngreso
ORDER BY descripcion");
        return query2json($resultado);
          

      }//- fin function buscarTiposIngresosId
 

    
}//--fin de class TiposIngresos
    
?>