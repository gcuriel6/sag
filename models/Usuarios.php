<?php

include 'conectar.php';

class Usuarios
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Usuarios()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el nombre en usuario no se repita
      *
      * @param varchar $usuario  usado para ingresar al sistema
      *
      **/
    function verificarUsuarios($usuario){
      
      $verifica = 0;

      $query = "SELECT id_usuario FROM usuarios WHERE usuario = '$usuario'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaUsuarios

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una unidad de negocio
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una unidad de negocio
      * @param varchar $nombre es el nombre asignado a una unidad de negocio
      * @param varchar $descripcion brebe descripcion de una unidad de negocio
      * @param varchar $logo es el logotipo que va a manejar la unidad de negocion en todos los formatos y modulos
      * @param int $inactivo estatus de una unidad de negocio 0='Activa' 1='Inactiva'  
      *
      **/      
    function guardarUsuarios($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarUsuarios


     /**
      * Guarda los datos de una unidad de negocio, regresa el id de la unidad de negocio afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una unidad de negocio
      * @param varchar $nombre es el nombre asignado a una unidad de negocio
      * @param varchar $descripcion brebe descripcion de una unidad de negocio
      * @param varchar $logo es el logotipo que va a manejar la unidad de negocion en todos los formatos y modulos
      * @param int $inactivo estatus de una unidad de negocio 0='Activa' 1='Inactiva'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idUsuario = $datos[1]['idUsuario'];
        $tipo_mov = $datos[1]['tipo_mov'];
        $usuario = $datos[1]['usuario'];
        $password = sha1($datos[1]['password']);
        $no_empleado = $datos[1]['no_empleado'];
        $nombre = $datos[1]['nombre'];
        $activo = $datos[1]['activo'];
        $idSucursal = $datos[1]['idSucursal'];

        if($tipo_mov==0){

          $query = "INSERT INTO usuarios(usuario,contra,nombre_comp,id_empleado,activo,id_sucursal) VALUES ('$usuario','$password','$nombre','$no_empleado','$activo','$idSucursal')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idUsuario = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE usuarios SET usuario='$usuario',nombre_comp='$nombre',id_empleado='$no_empleado',activo='$activo',id_sucursal='$idSucursal' WHERE id_usuario=".$idUsuario;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idUsuario;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una unidad de negocio, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activos 0=inactivos 2=todos
      *
      **/
      function buscarUsuarios($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE activo=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE activo=0';
        }

        $resultado = $this->link->query("SELECT id_usuario,usuario,nombre_comp,id_supervisor,activo,id_sucursal 
FROM usuarios
$condicionEstatus
ORDER BY usuario");
        return query2json($resultado);

      }//- fin function buscarUsuarios

      function buscarUsuariosId($idUsuario){
        
           $resultado = $this->link->query("SELECT id_usuario,usuario,contra,nombre_comp,id_empleado,id_supervisor,activo,id_sucursal 
FROM usuarios 
WHERE id_usuario=$idUsuario
ORDER BY usuario");
           return query2json($resultado);
          

      }//- fin function buscarUsuariosId

    /**
      * Cambia la contraseña de un usuario existente
      * 
      * @param varchar $contra en base 64 cadena que contiene la nueva contraseña
      *
      **/
      function cambiarPasswordUsuarios($idUsuario,$contra){

        $verifica = 0;

        $query = "UPDATE usuarios SET contra='$contra' WHERE id_usuario=".$idUsuario;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result){

          $verifica = 1;
        }
   
        return $verifica;  
      }//- fin function cambiarPasswordUsuarios 
      
      /**
      * Asigna un supervisor a un Usuario
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=activo 2=todos
      *
      **/
      function asignarSupervisorUsuarios($idUsuario,$idSupervisor){
        $verifica = 0;

        $query = "UPDATE usuarios SET id_supervisor='$idSupervisor' WHERE id_usuario=".$idUsuario;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
        if ($result) 
         $verifica = $idUsuario;  

        return $verifica;  

    } //-- fin function guardarUsuarios

    function buscarTrabajadorUsuario($idUsuario){
      $resultado = $this->link->query("SELECT id_trabajador,CONCAT(TRIM(nombre),' ',TRIM(apellido_p),' ',TRIM(apellido_m)) AS vendedor
      FROM trabajadores
      WHERE id_trabajador = (SELECT id_empleado FROM usuarios WHERE id_usuario=$idUsuario)");

      return query2json($resultado);
    }
    
}//--fin de class Usuarios
    
?>