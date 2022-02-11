<?php

include 'conectar.php';

class Familias
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Familias()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el nombre en usuario no se repita
      *
      * @param varchar $clave  usado para ingresar al sistema
      *
      **/
    function verificarFamilias($clave){
      
      $verifica = 0;

      $query = "SELECT id FROM familias WHERE clave = '$clave'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaFamilias

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una familia
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una familia
      * @param varchar $nombre es el nombre asignado a una familia
      * @param varchar $descripcion brebe descripcion de una familia
      * @param varchar $logo es el logotipo que va a manejar la familian en todos los formatos y modulos
      * @param int $inactivo estatus de una familia 0='Activa' 1='Inactiva'  
      *
      **/      
    function guardarFamilias($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarFamilias


     /**
      * Guarda los datos de una familia, regresa el id de la familia afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una familia
      * @param int $tipo es para indicar lo que permite esta familia 0=gasto 1=stock 2= mantenimiento 3=activo fijo  
      * @param varchar $descripcion brebe descripcion de una familia
      * @param int $tallas indica si una familia va a solicitar tallas 1=si 0=no   
      * @param int $inactiva estatus de una familia 0='Activa' 1='Inactiva' 
      * @param int $id_familia_gasto id de familia gasto 
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idFamilia = $datos[1]['idFamilia'];
        $tipo_mov = $datos[1]['tipo_mov'];
        $clave = $datos[1]['clave'];
        $descripcion = $datos[1]['descripcion'];
        $tallas = $datos[1]['tallas'];
        $tipo = $datos[1]['tipo'];
        $inactiva = $datos[1]['inactiva'];
        $id_familia_gasto = $datos[1]['id_familia_gasto'];

        if($tipo_mov==0){

          $query = "INSERT INTO familias(clave,descripcion,tallas,tipo,inactiva,id_familia_gasto) VALUES ('$clave','$descripcion','$tallas','$tipo','$inactiva','$id_familia_gasto')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idFamilia = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE familias SET clave='$clave',descripcion='$descripcion', tallas='$tallas', tipo='$tipo',inactiva='$inactiva',id_familia_gasto='$id_familia_gasto' WHERE id=".$idFamilia;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idFamilia;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una familia, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activos 0=inactivos 2=todos
      *
      **/
      function buscarFamilias($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE a.inactiva=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE a.inactiva=0';
        }

        $query = "SELECT
                    a.id,
                    a.clave,
                    a.descripcion,
                    IF(a.tipo=1,'Gasto',IF(a.tipo=3,'Stock', IF(a.tipo=2,'Mantenimiento',IF(a.tipo=0,'Activo Fijo',''))))AS tipo,
                    IF(a.tallas=0,'No','Si') AS tallas,
                    a.inactiva,
                    a.id_familia_gasto,
                    IFNULL(b.descr,'') AS familia_gasto
                  FROM familias a
                  LEFT JOIN fam_gastos b ON a.id_familia_gasto=b.id_fam
                  $condicionEstatus
                  ORDER BY a.clave";

        $resultado = $this->link->query($query);
        return query2json($resultado);

      }//- fin function buscarFamilias

      function buscarFamiliasId($idFamilia){
        
           $resultado = $this->link->query("SELECT id,clave,descripcion,tipo,tallas,inactiva,id_familia_gasto
                                            FROM familias 
                                            WHERE id=$idFamilia
                                            ORDER BY clave");
           return query2json($resultado);
          

      }//- fin function buscarFamiliasId

      //buscarFamiliasNoTipoActivoFijo
      /**
      * Busca los datos de una familia sin tomar encuenta las de tipo activo fijo
      * para las salidas por responsiva, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activos 0=inactivos 2=todos
      *
      **/
      function buscarFamiliasNoTipoActivoFijo($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE a.inactiva=1 AND a.tipo>0';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE a.inactiva=0  AND a.tipo>0';
        }

        $resultado = $this->link->query("SELECT a.id,a.clave,a.descripcion,IF(a.tipo=1,'Gasto',IF(a.tipo=3,'Stock',
                                         IF(a.tipo=2,'Mantenimiento',IF(a.tipo=0,'Activo Fijo',''))))AS tipo,
                                         IF(a.tallas=0,'No','Si') AS tallas,a.inactiva,a.id_familia_gasto,IFNULL(b.descr,'') AS familia_gasto
                                         FROM familias a
                                         LEFT JOIN fam_gastos b ON a.id_familia_gasto=b.id_fam
                                         $condicionEstatus
                                         ORDER BY a.clave");
        return query2json($resultado);

      }//- fin function buscarFamilias

      //buscarFamiliasNoTipoActivoFijo
      /**
      * Busca los datos de una familia sin tomar encuenta las de tipo activo fijo
      * para las salidas por responsiva, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activos 0=inactivos 2=todos
      *
      **/
      function buscarFamiliasTipoGastos(){


        $resultado = $this->link->query("SELECT a.id,a.clave,a.descripcion,IF(a.tipo=1,'Gasto',IF(a.tipo=3,'Stock',
                                        IF(a.tipo=2,'Mantenimiento',IF(a.tipo=0,'Activo Fijo',''))))AS tipo,
                                        IF(a.tallas=0,'No','Si') AS tallas,a.inactiva,a.id_familia_gasto,IFNULL(b.descr,'') AS familia_gasto
                                        FROM familias a
                                        LEFT JOIN fam_gastos b ON a.id_familia_gasto=b.id_fam
                                        WHERE a.inactiva=0 AND a.tipo=1
                                        ORDER BY a.clave");
        return query2json($resultado);

      }//- fin function buscarFamilias
    
    
}//--fin de class Familias
    
?>