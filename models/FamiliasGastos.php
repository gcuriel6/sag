<?php

include 'conectar.php';

class FamiliasGastos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function FamiliasGastos()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica si no se repita la clave de registro
      * 
      * @param varchar $clave palabra clave asignada a la familia gasto
      *
    **/
    function verificarFamiliasGastos($clave){
      $verifica = 0;

      $query = "SELECT id_fam FROM fam_gastos WHERE clave = '$clave'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
      {
        $verifica = 1;
      }

       return $verifica;
    }//- fin function verificarFamiliasGastos

    /**
      * Busca los registros de la familia segun el estatus
      * 
      * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=inactivos 2=todos
      *
    **/
    function buscarFamiliasGastos($estatus){
      $condicionEstatus='';

      if($estatus==1)
      {
        $condicionEstatus=' WHERE activo=1';
      }else if($estatus==0)
      {
        $condicionEstatus=' WHERE activo=0';
      }else{
        $condicionEstatus='';
      }

      $resultado = $this->link->query("SELECT id_fam,descr,clave,activo
                                        FROM fam_gastos
                                        $condicionEstatus
                                        ORDER BY id_fam ASC");
      return query2json($resultado);

    }//- fin function buscarFamiliasGastos

    /**
      * Busca los datos de un registro en especifico
      * 
      * @param int $idFamiliaGasto id del registro que se busca 
      *
    **/
    function buscarFamiliasGastosId($idFamiliaGasto){
      $resultado = $this->link->query("SELECT id_fam,descr,clave,activo
                                        FROM fam_gastos 
                                        WHERE id_fam=".$idFamiliaGasto);
      return query2json($resultado);
    }//- fin function buscarFamiliasGastosId

    /**
      * Guarda o Actualiza un registro 
      * 
      * @param varchar $datos array que contiene los datos a guardar o actualizar
      *
    **/
    function guardarFamiliasGastos($datos){
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardarActualizar($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
    }//- fin function guardarFamiliasGastos

     /**
      * Guarda o Actualiza un registro 
      * 
      * @param varchar $datos array que contiene los datos a guardar o actualizar
      *
    **/
    function guardarActualizar($datos){
          
    $verifica = 0;

    $idFamiliaGasto = $datos['idFamiliaGasto'];
    $clave = $datos['clave'];
    $descripcion = $datos['descripcion'];
    $activo = $datos['activo'];
    $tipo_mov = $datos['tipo_mov'];

    if($tipo_mov==0)
    {
      $query = "INSERT INTO fam_gastos(clave,descr,activo) VALUES ('$clave','$descripcion','$activo')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      $idFamiliaGasto = mysqli_insert_id($this->link);
    }else{
      $query = "UPDATE fam_gastos SET clave='$clave',descr='$descripcion', activo='$activo' WHERE id_fam=".$idFamiliaGasto;
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
    }
    
    if ($result) 
    {
      $verifica = $idFamiliaGasto;  
    }
    
    return $verifica;
  }//- fin function guardarActualizar

  function buscaIdFamiliaGasto($clave){
    $id = 0;
      
    $result = mysqli_query($this->link,"SELECT id_fam FROM fam_gastos WHERE clave='$clave'");                        
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0)
        $id = $row['id_fam'];
  
    return  $id;
  }
    
}//--fin de class FamiliasGastos
    
?>