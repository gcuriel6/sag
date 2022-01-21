<?php

require_once('conectar.php');

class Lineas
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Lineas()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el nombre en clave no se repita
      *
      * @param varchar $clave  usado para ingresar al sistema
      *
      **/
    function verificarLineas($clave){
      
      $verifica = 0;

      $query = "SELECT id FROM lineas WHERE clave = '$clave'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaLineas

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una linea
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una linea
      * @param varchar $nombre es el nombre asignado a una linea
      * @param varchar $descripcion brebe descripcion de una linea
      * @param int $idFamilia  id de la familia a la que se va asignar
      * @param int $inactiva estatus de una linea 0='Activa' 1='Inactiva'  
      *
      **/      
    function guardarLineas($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarLineas


     /**
      * Guarda los datos de una linea, regresa el id de la linea afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una linea
      * @param varchar $nombre es el nombre asignado a una linea
      * @param varchar $descripcion brebe descripcion de una linea
      * @param int $idFamilia  id de la familia a la que se va asignar
      * @param int $inactiva estatus de una linea 0='Activa' 1='Inactiva'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idLinea = $datos[1]['idLinea'];
        $tipo_mov = $datos[1]['tipo_mov'];
        $clave = $datos[1]['clave'];
        $descripcion = $datos[1]['descripcion'];
        $idFamilia = $datos[1]['idFamilia'];
        $inactiva = $datos[1]['inactiva'];

        if($tipo_mov==0){

          $query = "INSERT INTO lineas(clave,descripcion,id_familia,inactiva) VALUES ('$clave','$descripcion','$idFamilia','$inactiva')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idLinea = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE lineas SET clave='$clave',descripcion='$descripcion',id_familia='$idFamilia',inactiva='$inactiva' WHERE id=".$idLinea;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idLinea;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una linea, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=inactivas 2=todos
      *
      **/
      function buscarLineas($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE a.inactiva=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE a.inactiva=0';
        }

        $resultado = $this->link->query("SELECT a.id,a.clave,a.descripcion,b.descripcion AS familia,a.inactiva 
        FROM lineas a
        LEFT JOIN familias b ON a.id_familia=b.id
        $condicionEstatus
        ORDER BY a.descripcion desc");
        return query2json($resultado);

      }//- fin function buscarLineas

      function buscarLineasId($idLinea){
        
           $resultado = $this->link->query("SELECT a.id,a.clave,a.descripcion,a.id_familia,a.inactiva,b.descripcion AS familia 
           FROM lineas a
           LEFT JOIN familias b ON a.id_familia=b.id
WHERE a.id=$idLinea
ORDER BY a.descripcion desc");
           return query2json($resultado);
          

      }//- fin function buscarLineasId

    /**
     * Busca las lineas activas que pertenecen a una familia
     * @param int $idFamilia
     * 
    **/
    function buscarLineasIdFamilia($idFamilia){
        $result = $this->link->query("SELECT a.id,a.clave,a.descripcion,b.descripcion AS familia,a.inactiva
                                        FROM lineas a
                                        LEFT JOIN familias b ON a.id_familia=b.id
                                        WHERE a.id_familia=$idFamilia AND a.inactiva=0
                                        ORDER BY a.descripcion DESC");
        
        return query2json($result);
    }//- fin function buscarLineasIdFamilia
    function buscarLineaUsadoIdLinea($idLinea){
      
      $verifica = 0;

      $busca = "SELECT descripcion FROM lineas WHERE id=$idLinea";
      $result_a = mysqli_query($this->link, $busca)or die(mysqli_error());
      $row_a = mysqli_fetch_array($result_a);
      $linea = $row_a['descripcion'].' USAD';

      $query = "SELECT id FROM lineas WHERE descripcion LIKE '%$linea%'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
      {
        $row = mysqli_fetch_array($result);
        $id = $row['id'];

        $verifica = $id;
      }

      return $verifica;

    }//-- fin function buscarLineaUsadoIdLinea
    
}//--fin de class Lineas
    
?>