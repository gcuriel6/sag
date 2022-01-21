<?php

include 'conectar.php';

class ClasificacionGasto
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function ClasificacionGasto()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica si no se repita la clave de registro
      * 
      * @param varchar $clave palabra clave asignada a la familia gasto
      *
    **/
    function verificarClasificacionGasto($clave){
      $verifica = 0;

      $query = "SELECT id_clas FROM gastos_clasificacion WHERE clave = '$clave'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
      {
        $verifica = 1;
      }

       return $verifica;
    }//- fin function verificarClasificacionGasto

    /**
      * Busca los registros de la familia segun el estatus
      * 
      * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=inactivos 2=todos
      *
    **/
    function buscarClasificacionGasto($estatus){
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

      $resultado = $this->link->query("SELECT id_clas,descr,clave,activo
                                        FROM gastos_clasificacion
                                        $condicionEstatus
                                        ORDER BY id_clas ASC");
      return query2json($resultado);

    }//- fin function buscarClasificacionGasto

    /**
      * Busca los datos de un registro en especifico
      * 
      * @param int $idClasificacionGasto id del registro que se busca 
      *
    **/
    function buscarClasificacionGastoId($idClasificacionGasto){
      $resultado = $this->link->query("SELECT a.id_clas,a.descr,a.clave,a.activo,a.no_editar,a.id_fam AS id_familia_gasto
                                        FROM gastos_clasificacion a
                                        LEFT JOIN fam_gastos b ON a.id_fam=b.id_fam
                                        WHERE a.id_clas=".$idClasificacionGasto);
      return query2json($resultado);
    }//- fin function buscarClasificacionGastoId

    /**
      * Guarda o Actualiza un registro 
      * 
      * @param varchar $datos array que contiene los datos a guardar o actualizar
      *
    **/
    function guardarClasificacionGasto($datos){
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardarActualizar($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
    }//- fin function guardarClasificacionGasto

     /**
      * Guarda o Actualiza un registro 
      * 
      * @param varchar $datos array que contiene los datos a guardar o actualizar
      *
    **/
    function guardarActualizar($datos){
          
    $verifica = 0;

    $idClasificacionGasto = $datos['idClasificacionGasto'];
    $clave = $datos['clave'];
    $descripcion = $datos['descripcion'];
    $activo = $datos['activo'];
    $tipo_mov = $datos['tipo_mov'];
    $idFamiliaGasto = $datos['idFamiliaGasto'];

    if($tipo_mov==0)
    {
      $query = "INSERT INTO gastos_clasificacion(clave,descr,activo,id_fam) VALUES ('$clave','$descripcion','$activo','$idFamiliaGasto')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      $idClasificacionGasto = mysqli_insert_id($this->link);
    }else{
      $query = "UPDATE gastos_clasificacion SET clave='$clave',descr='$descripcion', activo='$activo',id_fam='$idFamiliaGasto' WHERE id_clas=".$idClasificacionGasto;
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
    }
    
    if ($result) 
    {
      $verifica = $idClasificacionGasto;  
    }
    
    return $verifica;
  }//- fin function guardarActualizar
    
}//--fin de class ClasificacionGasto
    
?>