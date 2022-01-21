<?php

include 'conectar.php';

class Correos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Correos()
    {
  
      $this->link = Conectarse();

    }

    
    /**
      * Manda llamar a la funcion que guarda la informacion sobre una area
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una area en particular
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $inactiva estatus de una area  1='Activa' 0='Inactiva'  
      *
    **/      
    function guardarCorreos($correos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($correos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarCorreos


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
      function guardarActualizar($correos){
          
        $verifica = 0;

        $existe = "SELECT COUNT(id) AS ids,id FROM correos_info_proveedores";
        $resultE = mysqli_query($this->link, $existe) or die(mysqli_error());
        $dato = mysqli_fetch_array($resultE);
        $num = $dato['ids'];

        if($num > 0)
        {
          $id = $dato['id'];

          $query = "UPDATE correos_info_proveedores SET correos='$correos' WHERE id=".$id;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
          if ($result) 
            $verifica = 1; 
        }else{
          $query = "INSERT INTO correos_info_proveedores(correos) VALUES ('$correos')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
          if ($result) 
            $verifica = 1; 
        }
        
        return $verifica;
    }

    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activa 0=inactiva 2=todos
      *
      **/
      function buscarCorreos(){
        $verifica = '';
        $query = "SELECT correos FROM correos_info_proveedores WHERE id=1 ORDER BY id";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if($result){
            $row = mysqli_fetch_array($result);
            $verifica =  $row['correos'];
        }
        return $verifica;

      }//- fin function buscarCorreos


    
}//--fin de class Correos
    
?>