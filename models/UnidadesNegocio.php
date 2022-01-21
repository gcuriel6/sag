<?php

include 'conectar.php';

class UnidadesNegocio
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function UnidadesNegocio()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la clave de una unidad de negocio no se repita
      *
      * @param varchar $clave es una clave para identificar una unidad de negocio
      *
      **/
    function verificarUnidadesNegocio($clave){
      
      $verifica = 0;

      $query = "SELECT id FROM cat_unidades_negocio WHERE clave = '$clave' ORDER BY id";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaUnidadesNegocio

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
    function guardarUnidadesNegocio($tipo_mov,$id,$clave,$nombre,$descripcion,$inactivo,$ele,$img_ant){
        
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($tipo_mov,$id,$clave,$nombre,$descripcion,$inactivo,$ele,$img_ant);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarUnidadesNegocio


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
      function guardarActualizar($tipo_mov,$id,$clave,$nombre,$descripcion,$inactivo,$ele,$img_ant){
  
        $verifica = 0;

        if($tipo_mov==0){

          $query = "INSERT INTO cat_unidades_negocio(clave,nombre,descripcion,inactivo) VALUES ('$clave','$nombre','$descripcion','$inactivo')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id_registro = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_unidades_negocio SET clave='$clave',nombre='$nombre',descripcion='$descripcion',inactivo='$inactivo' WHERE id=".$id;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id_registro = $id;
        }
        
        if ($result) {
            
            if($ele>0){

              if($img_ant!=''){
                $ruta_img ="../imagenes/".$img_ant;
                @unlink($ruta_img);
                $verifica = $this-> guardarArchivos($ele,$id_registro,$nombre);
              }else{
                $verifica = $this-> guardarArchivos($ele,$id_registro,$nombre);
              }
             
              
            }else{

              $verifica = $id_registro;
            }
               
        }else{

            $verifica = 0;
        }
        
        return $verifica;
    }

    /**
      * Guarda los archivos que vengan en este caso el logo 
      * 
      * @param int $ele numero de archivos a subir
      * @param varchar $id es  para identificar el registro a modificar
      * @param varchar $nombre nombre que llevara la imagen la cual inicara con logo_nombre unidad 
      *
      **/ 
    function guardarArchivos($ele,$id,$nombre){
    
      $verifica = 0;

      if(isset($_FILES['logo_'.$ele]['name'])){
        $uTime = microtime(true);
        $rest = substr($uTime, -4); 
        $nombre_imagen=$_FILES['logo_'.$ele]['name']; 
        $tipo_a=explode('.', $nombre_imagen);
        $ext=$tipo_a[count($tipo_a)-1];
        $nombre_img_bd="logo_".$nombre."_".$rest.".".$ext;
        $ruta_img = "../imagenes/".$nombre_img_bd;
       
        if((move_uploaded_file($_FILES['logo_'.$ele]['tmp_name'],$ruta_img))){

           $query = "UPDATE cat_unidades_negocio SET logo='$nombre_img_bd' WHERE id=".$id;
           $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
           if ($result) {
            
             $verifica = $id; 
            
            }else{
              $verifica = 0;
            }

        }

      }
       return $verifica;
     
    }


    /**
      * Busca los datos de una unidad de negocio, retorna un JSON con los datos correspondientes
      * 
      * @param int $id si id es 0 trae todos los registros, si no trae los datos de id requerido
      *
      **/
      function buscarUnidadesNegocio($id = 0){

         $verifica = 0; 

        if( $id == 0 ){
            
            $resultado = $this->link->query("SELECT id,clave,nombre,inactivo 
FROM cat_unidades_negocio 
ORDER BY clave");

            if($resultado)
              $verifica = query2json($resultado); 

        }else{
            
            $resultado = $this->link->query("SELECT id,clave,nombre,descripcion,logo,inactivo 
FROM cat_unidades_negocio 
WHERE id=$id 
ORDER BY clave");

            if($resultado)
              $verifica = query2json($resultado); 
            
        }
    
        return $verifica;  
    }//- fin function buscarUnidaddesNegocio

    
}//--fin de class UnidadesNegocio
    
?>