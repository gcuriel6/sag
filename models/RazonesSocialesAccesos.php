<?php

include 'conectar.php';

class RazonesSocialesAccesos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function RazonesSocialesAccesos()
    {
  
      $this->link = Conectarse();

    }

    
    /**
      * Busca las sucursales de todas las unidades de negocio a las que se puede acceder
      * 
      * @param int $idRazonSocial indica el id de usuario al que se le asignaran las sucursales
      * @param int $idUnidadNegocio unidades de negocio encontrada a la que no tiene acceso 
      *
      *
    **/  
    function buscarSucursalesDisponibles($idUnidadNegocio,$idRazonSocial){
        
      $resultado = $this->link->query("SELECT 
      unidades.id AS id_unidad_negocio,
      unidades.nombre AS unidad_negocio,
      sucursales.id_sucursal,
      sucursales.descr AS sucursal,
      IFNULL(razones_sociales_unidades.id,0) AS id_acceso
      FROM cat_unidades_negocio unidades
      LEFT JOIN sucursales ON unidades.id=sucursales.id_unidad_negocio
      LEFT JOIN razones_sociales_unidades ON unidades.id=razones_sociales_unidades.id_unidad AND  sucursales.id_sucursal=razones_sociales_unidades.id_sucursal  AND razones_sociales_unidades.id_razon_social=".$idRazonSocial."
      WHERE unidades.inactivo=0 AND sucursales.activo=1 AND unidades.id=".$idUnidadNegocio."
      HAVING id_acceso = 0
      ORDER BY unidades.nombre,sucursales.descr ASC");
      return query2json($resultado);
          
    }//- fin function buscarSucursalesDisponibles




    /**
      * Busca todos los acceso de un usuario
      * 
      * @param int $idRazonSocial indica el id de usuario al que se le asignaron los RazonesSocialesAccesos 
      *
    **/  
    function buscarSucursalesAgregadas($idRazonSocial){
       
       $resultado = $this->link->query("SELECT 
        unidades.nombre AS unidad_negocio,
        sucursales.descr AS sucursal,
        IFNULL(razones_sociales_unidades.id,0) AS id_acceso
        FROM cat_unidades_negocio unidades
        LEFT JOIN sucursales ON unidades.id=sucursales.id_unidad_negocio
        LEFT JOIN razones_sociales_unidades ON unidades.id=razones_sociales_unidades.id_unidad AND  sucursales.id_sucursal=razones_sociales_unidades.id_sucursal  AND razones_sociales_unidades.id_razon_social=".$idRazonSocial."
        WHERE unidades.inactivo=0 AND sucursales.activo=1 
        HAVING id_acceso > 0
        ORDER BY unidades.nombre,sucursales.descr ASC 
        ");
      return query2json($resultado);
          
  }//- fin function buscarSucursalesAgregadas

  function RazonesSocialesAccesosucursales($mov,$datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        if($mov=='agregar'){

          $verifica = $this -> insertaAcceso($datos);

        }else{
           
           $verifica = $this -> quitarAcceso($datos);
        }

        

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

  } //-- fin function guardarUsuarios

      /**
      * Busca todos los acceso de un usuario
      * 
      * @param int $idRazonSocial indica el id de usuario al que se le asignaron los RazonesSocialesAccesos 
      *
    **/  
  function insertaAcceso($datos){
    
    $verifica = 0;

    for($i=1; $i < count($datos); $i++){

      $idRazonSocial=$datos[$i]['idRazonSocial'];
      $idUnidadNegocio=$datos[$i]['idUnidadNegocio'];
      $idSucursal=$datos[$i]['idSucursal'];
  

      $query2 = "INSERT INTO razones_sociales_unidades(id_razon_social,id_unidad,id_sucursal) 
                 VALUES ('$idRazonSocial','$idUnidadNegocio','$idSucursal')";
      $result2 = mysqli_query($this->link,$query2) or die(mysqli_error());

      if($result2){

        if($i==$datos[0]){

          $verifica = 1;    
        }  

      }else{

        $verifica = 0;
        break;
      }
    }
        
    return $verifica;
          
  }//- fin function insertaAcceso


   function quitarAcceso($datos){
   

    for($i = 1; $i < count($datos); $i++){

      $idAcceso=$datos[$i]['idAcceso'];
     
      $query2 = "DELETE FROM razones_sociales_unidades WHERE id=".$idAcceso;
      $result2 = mysqli_query($this->link,$query2) or die(mysqli_error());

      if($result2){

        if($i==$datos[0]){

          $verifica = 1;    
        }  

      }else{

        $verifica = 0;
        break;
      }
    }
        
    return $verifica;
          
  }//- fin function insertaAcceso

    
}//--fin de class RazonesSocialesAccesos
    
?>