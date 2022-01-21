<?php

include 'conectar.php';

class Accesos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Accesos()
    {
  
      $this->link = Conectarse();

    }

    
    /**
      * Busca las sucursales de todas las unidades de negocio a las que se puede acceder
      * 
      * @param int $idUsuario indica el id de usuario al que se le asignaran las sucursales
      * @param int $idUnidadNegocio unidades de negocio encontrada a la que no tiene acceso 
      *
      *
    **/  
    function buscarSucursalesDisponibles($idUnidadNegocio,$idUsuario){
        
      $resultado = $this->link->query("SELECT 
unidades.id AS id_unidad_negocio,
unidades.nombre AS unidad_negocio,
sucursales.id_sucursal,
sucursales.descr AS sucursal,
IFNULL(accesos.id,0) AS id_acceso
FROM cat_unidades_negocio unidades
LEFT JOIN sucursales ON unidades.id=sucursales.id_unidad_negocio
LEFT JOIN accesos ON unidades.id=accesos.id_unidad_negocio AND  sucursales.id_sucursal=accesos.id_sucursal  AND accesos.id_usuario=".$idUsuario."
WHERE unidades.inactivo=0 AND sucursales.activo=1 AND unidades.id=".$idUnidadNegocio."
HAVING id_acceso = 0
ORDER BY unidades.nombre,sucursales.descr ASC");
      return query2json($resultado);
          
    }//- fin function buscarSucursalesDisponibles




    /**
      * Busca todos los acceso de un usuario
      * 
      * @param int $idUsuario indica el id de usuario al que se le asignaron los accesos 
      *
    **/  
    function buscarSucursalesAgregadas($idUsuario){
       
       $resultado = $this->link->query("SELECT 
        unidades.nombre AS unidad_negocio,
        sucursales.descr AS sucursal,
        IFNULL(accesos.id,0) AS id_acceso,
        unidades.id AS id_unidad_negocio,
        sucursales.id_sucursal AS id_sucursal
        FROM cat_unidades_negocio unidades
        LEFT JOIN sucursales ON unidades.id=sucursales.id_unidad_negocio
        LEFT JOIN accesos ON unidades.id=accesos.id_unidad_negocio AND  sucursales.id_sucursal=accesos.id_sucursal  AND accesos.id_usuario=".$idUsuario."
        WHERE unidades.inactivo=0 AND sucursales.activo=1 
        HAVING id_acceso > 0
        ORDER BY unidades.nombre,sucursales.descr ASC 
        ");
      return query2json($resultado);
          
  }//- fin function buscarSucursalesAgregadas

  function accesoSucursales($mov, $datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        if($mov=='agregar')
          $verifica = $this -> insertaAcceso($datos);
        else
           $verifica = $this -> quitarAcceso($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

  } //-- fin function guardarUsuarios

      /**
      * Busca todos los acceso de un usuario
      * 
      * @param int $idUsuario indica el id de usuario al que se le asignaron los accesos 
      *
    **/  
  function insertaAcceso($datos){
    
    $verifica = 0;

    for($i=1; $i < count($datos); $i++)
    {

      $idUsuario = $datos[$i]['idUsuario'];
      $idUnidadNegocio = $datos[$i]['idUnidadNegocio'];
      $idSucursal = $datos[$i]['idSucursal'];
      $usuario = $datos[$i]['usuario'];

      $qB = "SELECT count(*) as total FROM accesos WHERE id_usuario = $idUsuario AND id_unidad_negocio = $idUnidadNegocio AND id_sucursal = $idSucursal AND usuario =  '$usuario' AND id_compania = $idSucursal";

      $rB = mysqli_query($this->link, $qB) or die(mysqli_error());
      $rowB = mysqli_fetch_assoc($rB);

      if($rowB['total'] == 0)
      {

        $query2 = "INSERT INTO accesos(id_usuario,id_unidad_negocio,id_sucursal,usuario,id_compania) 
                 VALUES ('$idUsuario','$idUnidadNegocio','$idSucursal','$usuario','$idSucursal')";
        $result2 = mysqli_query($this->link,$query2) or die(mysqli_error());

        if($result2)
        {

          if($i == $datos[0])
            $verifica = 1;
          //$verifica = $this -> reasignaUnidadesNegocioAcceso($idUsuario);
          
        }
        else
        {
          $verifica = 0;
          break;
        }

      } 
      else
        $verifica = 1;


      

    }
        
    return $verifica;
          
  }//- fin function insertaAcceso


   function quitarAcceso($datos){
   

    for($i = 1; $i < count($datos); $i++){

      $idAcceso=$datos[$i]['idAcceso'];
      $idUnidadnegocio=$datos[$i]['idUnidadnegocio'];
      $idSucursal=$datos[$i]['idSucursal'];
      $idUsuario=$datos[$i]['idUsuario'];
     
      $query2 = "DELETE FROM accesos WHERE id=".$idAcceso;
      $result2 = mysqli_query($this->link,$query2) or die(mysqli_error());

      if($result2){

        $query3 = 'DELETE FROM permisos WHERE id_usuario='.$idUsuario.' AND id_unidad_negocio='.$idUnidadnegocio.' AND id_sucursal='.$idSucursal;
        $result3 = mysqli_query($this->link,$query3) or die(mysqli_error());

        if($result3)
        {
          if($i==$datos[0]){
            $verifica = 1;
            //$verifica = $this-> reasignaUnidadesNegocioAcceso($idUsuario);  
          }
        }else{
      
          $verifica = 0;
          break;
        }
      }else{
       
        $verifica = 0;
        break;
      }
    }
        
    return $verifica;
          
  }//- fin function 


  function reasignaUnidadesNegocioAcceso($idUsuario){
    $arr_suc=array();
    $verifica = 0;

    $query_su="SELECT accesos.id_unidad_negocio,cat_unidades_negocio.logo,cat_unidades_negocio.nombre AS nombre_unidad
							FROM accesos 
							LEFT JOIN cat_unidades_negocio ON accesos.id_unidad_negocio=cat_unidades_negocio.id
							WHERE accesos.id_usuario=".$idUsuario." AND cat_unidades_negocio.inactivo=0 
							GROUP BY accesos.id_unidad_negocio";
    $result_su = mysqli_query($this->link,$query_su) or die(mysqli_error());
    $num = mysqli_num_rows($result_su);
    if($num>0){
      
      for($k=1;$k<=$num;$k++){
       
        $row_su = mysqli_fetch_array($result_su);
        $arr_suc[$k] = array('id_unidad' => $row_su['id_unidad_negocio'],'logo' => $row_su['logo'],'nombre_unidad' => $row_su['nombre_unidad']);
        
        if($k==$num){
          //session_start();
          $_SESSION['sucursales'] = json_encode($arr_suc);
  
          $verifica = 1;
        }
      }

    }else{

      $verifica = 0;
    }
        
    
		return $verifica;		
  }

    
}//--fin de class Accesos
    
?>