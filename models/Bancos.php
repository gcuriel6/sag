<?php

include 'conectar.php';

class Bancos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Bancos()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el nombre en clave no se repita
      *
      * @param varchar $clave  usado para ingresar al sistema
      *
      **/
      function verificarBancos($clave){
      
        $verifica = 0;
  
        $query = "SELECT id FROM bancos WHERE clave = '$clave'";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);
  
        if($num > 0)
          $verifica = 1;
  
         return $verifica;
  
      }//-- fin function verificaBancos
  
      /**
        * Manda llamar a la funcion que guarda la informacion sobre una Banco
        * 
        * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
        * @param varchar $clave es una clave para identificar una Banco
        * @param varchar $nombre es el nombre asignado a una Banco
        * @param varchar $descripcion brebe descripcion de una Banco
        * @param int $idFamilia  id de la familia a la que se va asignar
        * @param int $activo estatus de una Banco 0='Activa' 1='activo'  
        *
        **/      
      function guardarBancos($datos){
      
          $verifica = 0;
  
         $this->link->begin_transaction();
         $this->link->query("START TRANSACTION;");
  
          $verifica = $this -> guardarActualizar($datos);
  
          if($verifica > 0)
              $this->link->query("commit;");
          else
              $this->link->query('rollback;');
  
          return $verifica;
  
      } //-- fin function guardarBancos
  
  
       /**
        * Guarda los datos de una Banco, regresa el id de la Banco afectada si se realiza la accion correctamete ó 0 si ocurre algun error
        * 
        * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
        * @param varchar $clave es una clave para identificar una Banco
        * @param varchar $descripcion brebe descripcion de un banco
        * @param int $activo estatus de una Banco 1='activo' 0='inactivo'  
        *
        **/ 
        function guardarActualizar($datos){
            
          $verifica = 0;
  
          $idBanco = $datos[1]['idBanco'];
          $tipoMov = $datos[1]['tipoMov'];
          $clave = $datos[1]['clave'];
          $descripcion = $datos[1]['descripcion'];
          $activo = $datos[1]['activo'];
  
          if($tipoMov==0){
  
            $query = "INSERT INTO bancos(clave, descripcion, activo) VALUES ('$clave','$descripcion','$activo')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idBanco = mysqli_insert_id($this->link);
  
          }else{
  
            $query = "UPDATE bancos SET clave='$clave', descripcion='$descripcion', activo='$activo' WHERE id=".$idBanco;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
          }
          
          if ($result) 
            $verifica = $idBanco;  
  
          
          return $verifica;
      }
  
    
    /**
      * Busca los datos de una Banco, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=activos 2=todos
      *
      **/
      function buscarBancos($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE a.activo=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE a.activo=0';
        }

        $resultado = $this->link->query("SELECT a.id,a.clave,a.descripcion as banco,a.activo
        FROM bancos a
        $condicionEstatus
        ORDER BY a.descripcion desc");
        return query2json($resultado);

      }//- fin function buscarBancos

      function buscarBancosId($idBanco){
        
           $resultado = $this->link->query("SELECT a.id,a.clave,a.descripcion as banco,a.activo
           FROM bancos a
           WHERE  a.id=".$idBanco."
           ORDER BY a.descripcion desc");
           return query2json($resultado);
          

      }//- fin function buscarBancosId


    
}//--fin de class Bancos
    
?>