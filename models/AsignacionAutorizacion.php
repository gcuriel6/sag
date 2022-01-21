<?php

include 'conectar.php';

class AsignacionAutorizacion
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function AsignacionAutorizacion()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el usuario no se repita
      *
      * @param int $idUsuario  usado para indentificar en las Búsqueda de  des una asignacion de uatorizacion
      *
    **/
    function verificarAsignacionAutorizacion($idUsuario){
      
      $verifica = 0;

      $query = "SELECT id FROM cat_autorizaciones WHERE id_usuario = '$idUsuario'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaAsignacionAutorizacion

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una area
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una area en particular
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $inactivo estatus de una area  1='activo' 0='Inactivo'  
      *
    **/      
    function guardarAsignacionAutorizacion($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarAsignacionAutorizacion


     /**
      * Guarda los datos de una autorizacion, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del autorizacion para realizarla
      * @param int $idUsuario es una clave para identificar una area en particular
      * @param double $montoMinimo cantidad decimal que indica lo minimo que puede ver para autorizacion
      * @param double $montoMinimo cantidad decimal que indica lo minimo que puede ver para autorizacion
      * @param int $inactivo estatus de una area  1='activo' 0='Inactivo'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $id = $datos[1]['id'];
        $tipoMov = $datos[1]['tipoMov'];
        $idUsuario = $datos[1]['idUsuario'];
        $montoMinimo = $datos[1]['montoMinimo'];
        $montoMaximo = $datos[1]['montoMaximo'];
        $activo = $datos[1]['activo'];

        if($tipoMov==0){

          $query = "INSERT INTO cat_autorizaciones(id_usuario,monto_minimo,monto_maximo,activo) VALUES ('$idUsuario','$montoMinimo','$montoMaximo','$activo')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_autorizaciones SET id_usuario='$idUsuario', monto_minimo='$montoMinimo', monto_maximo='$montoMaximo',activo='$activo' WHERE id=".$id;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $id;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $activo indica el estatus que debe tener el registro 1=activo 0=inactivo 2=todos
      *
      **/
      function buscarAsignacionAutorizacion($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE activo=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE activo=0';
        }

        $resultado = $this->link->query("SELECT a.id, FORMAT(a.monto_minimo,2) AS monto_minimo, FORMAT(a.monto_maximo,2) AS monto_maximo, a.activo ,b.nombre_comp AS usuario FROM cat_autorizaciones a LEFT JOIN usuarios b ON a.id_usuario=b.id_usuario $condicionEstatus ORDER BY b.nombre_comp");
        return query2json($resultado);

      }//- fin function buscarAsignacionAutorizacion

      function buscarAsignacionAutorizacionId($id){
        $resultado = $this->link->query("SELECT a.id, a.id_usuario, FORMAT(a.monto_minimo,2) AS monto_minimo, FORMAT(a.monto_maximo,2) AS monto_maximo, a.activo ,b.nombre_comp AS usuario
        FROM cat_autorizaciones a
        LEFT JOIN usuarios b ON a.id_usuario=b.id_usuario
        WHERE a.id=".$id."
        ORDER BY b.nombre_comp");
        return query2json($resultado);
          

      }//- fin function buscarAsignacionAutorizacionId
 

    
}//--fin de class AsignacionAutorizacion
    
?>