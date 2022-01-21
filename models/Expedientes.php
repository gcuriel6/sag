<?php

include 'conectar.php';

class Expedientes
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Expedientes()
    {
  
      $this->link = Conectarse();

    }

 

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una unidad de negocio
      * 
      * @param int $idUsuario es el id del usuraio al que se le dará permiso a expedintes
      * @param int $idSucursal es la sucursal a la que se le dará el permiso
      * @param int $accesos  nivel de acceso a expedientes 3 SIN acc, 2 readonly, 1 edicion
      * @param int $estudios nivel de acceso a estudios 1=Antidopings, 2=Cursos, 3 = Ambos Dos 
      * @param int $bajas 1 puede ver los expedientes de epleados dados de baja 0 no puede ver expedientes
      * @param varchar $idsDepartamentos lista de ids de los departamentos a laos que se tendra acceso de esa sucursal
      *
      **/      
    function guardarExpedientes($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarExpendientes


     /**
      * Guarda los permisos a expedientes en la tabla de accesos y usuarios regresa 1 si se actualizo correctamnet y 0 so ocurre algun error
      *
      * @param int $idUsuario es el id del usuraio al que se le dará permiso a expedintes
      * @param int $idSucursal es la sucursal a la que se le dará el permiso
      * @param int $accesos  nivel de acceso a expedientes 3 SIN acc, 2 readonly, 1 edicion
      * @param int $estudios nivel de acceso a estudios 1=Antidopings, 2=Cursos, 3 = Ambos Dos 
      * @param int $bajas 1 puede ver los expedientes de epleados dados de baja 0 no puede ver expedientes
      * @param varchar $idsDepartamentos lista de ids de los departamentos a laos que se tendra acceso de esa sucursal
      *
      **/  
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idUsuario = $datos[1]['idUsuario'];
        $idUnidadNegocio = $datos[1]['idUnidadNegocio'];
        $idSucursal = $datos[1]['idSucursal'];
        $acceso = $datos[1]['acceso'];
        $estudios = $datos[1]['estudios'];
        $verBajas = $datos[1]['verBajas'];
        $deptos = $datos[1]['idsDepartamentos'];
      

          $query = "UPDATE accesos SET deptos='$deptos',nivel_web='$acceso',permisos_web='$estudios' WHERE id_usuario=".$idUsuario." AND id_sucursal=".$idSucursal;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
  
        
        if ($result) 
          $queryU = "UPDATE usuarios SET ver_bajas='$verBajas' WHERE id_usuario=".$idUsuario;
          $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
  
        if ($resultU) 
          $verifica = $idUsuario;    

        
        return $verifica;
    }

    function buscarExpedientes($idSucursal,$idUsuario){

      $query = "SELECT a.id_usuario,a.deptos,a.nivel_web AS accesos,a.permisos_web AS estudios ,b.ver_bajas  FROM accesos a LEFT JOIN usuarios b ON a.id_usuario=b.id_usuario WHERE a.id_sucursal=".$idSucursal." AND a.id_usuario=".$idUsuario." ORDER BY a.id_usuario";

      $result1 = $this->link->query($query);
  
      return query2json($result1);
    }//-- fin function buscarExpedientes
    
}//--fin de class Expedientes
    
?>