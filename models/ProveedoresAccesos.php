<?php

include 'conectar.php';

class ProveedoresAccesos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function ProveedoresAccesos()
    {
  
      $this->link = Conectarse();

    }

    
    /**
      * Busca las sucursales de todas las unidades de negocio a las que se puede acceder
      * 
      * @param int $idProveedor indica el id del producto al qu ese le asignaran las unidades
      *
      *
    **/  
    function buscarUnidadesDisponibles($idProveedor){
        
      $resultado = $this->link->query("SELECT 
      unidades.id AS id_unidad_negocio,
      unidades.nombre AS unidad_negocio,
      IFNULL(proveedores_unidades.id,0) AS id_acceso
      FROM cat_unidades_negocio unidades
      LEFT JOIN proveedores_unidades ON unidades.id=proveedores_unidades.id_unidad AND proveedores_unidades.id_proveedor=".$idProveedor."
      WHERE unidades.inactivo=0  
      HAVING id_acceso = 0
      ORDER BY unidades.nombre ASC");
      return query2json($resultado);
          
    }//- fin function buscarUnidadesDisponibles




    /**
      * Busca todos los acceso de un usuario
      * 
      * @param int $idProveedor se busca las unidades asignadas de este producto
      *
    **/  
    function buscarUnidadesAgregadas($idProveedor){
       
       $resultado = $this->link->query("SELECT 
       unidades.id AS id_unidad_negocio,
       unidades.nombre AS unidad_negocio,
       IFNULL(proveedores_unidades.id,0) AS id_acceso
       FROM cat_unidades_negocio unidades
       LEFT JOIN proveedores_unidades ON unidades.id=proveedores_unidades.id_unidad AND proveedores_unidades.id_proveedor=".$idProveedor."
       WHERE unidades.inactivo=0  
       HAVING id_acceso > 0
       ORDER BY unidades.nombre ASC
        ");
      return query2json($resultado);
          
  }//- fin function buscarSucursalesAgregadas

  function ProveedoresAccesosUnidades($mov,$datos){
    
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

  } //-- fin function ProveedoresAccesosUnidades

      /**
      * Inserta los accesos a las unidades correspondientes
      * 
      * @param int $idProveedor indica el id del producto al que se le asignaron las unidades
      *
    **/  
  function insertaAcceso($datos){
    
    $verifica = 0;

    for($i=1; $i < count($datos); $i++){

      $idProveedor=$datos[$i]['idProveedor'];
      $idUnidadNegocio=$datos[$i]['idUnidadNegocio'];

      $query2 = "INSERT INTO proveedores_unidades(id_proveedor,id_unidad) 
                 VALUES ('$idProveedor','$idUnidadNegocio')";
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

     /**
      * quita los accesos a un producto de  las unidades correspondientes
      * 
      * @param int $idProveedor indica el id del producto al que se le asignaron las unidades
      *
    **/  
   function quitarAcceso($datos){
   

    for($i = 1; $i < count($datos); $i++){

      $idAcceso=$datos[$i]['idAcceso'];
     
      $query2 = "DELETE FROM proveedores_unidades WHERE id=".$idAcceso;
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
          
  }//- fin function quitarAcceso

    
}//--fin de class ProveedoresAccesos
    
?>