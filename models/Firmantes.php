<?php

include 'conectar.php';

class Firmantes
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Firmantes()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que no se registre mas de un registro con el mismo nombre
      *
      * @param varchar $nombre para identificar si ya existe un registro con ese nombre y no lo deje guardar
      *
      **/
    function verificarFirmantes($nombre){
        $verifica = 0;

        $query = "SELECT id FROM cat_firmantes WHERE nombre='$nombre'";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
            $verifica = 1;

        return $verifica;
    }//-- fin function verificarFirmantes  

    /**
      * Busca los datos de cat_costos_administrativos, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos
      *
      **/
    function buscarFirmantes($estatus){
      
        $condicion='';
        if( $estatus == 0 )
        {
            $condicion=' WHERE activo=1 ';
        }else if( $estatus == 1 ){
            $condicion=' WHERE activo=0 ';
        }else{
            $condicion='';
        }
        
        $result1 = $this->link->query("SELECT id,nombre,telefono,email,iniciales,activo 
                                            FROM cat_firmantes
                                            $condicion
                                            ORDER BY id");
    
        return query2json($result1);
    }//-- fin function buscarFirmantes

    /**
      * Busca los datos de cat_costos_administrativos, retorna un JSON con los datos correspondientes
      * 
      * @param int $idFirmantes trae los datos de idFirmantes requerido
      *
      **/
    function buscarFirmantesId($idFirmante){
    
        $result = $this->link->query("SELECT id,nombre,telefono,email,iniciales,firma,activo
                                        FROM cat_firmantes 
                                        WHERE id=".$idFirmante);
        return query2json($result);
        
    }//-- fin function buscarFirmantesId

    /**
      * Manda llamar a la funcion que guarda la informacion
      * 
      * @param int $tipo_mov movimiento que se va a ejecutar, si es insercion=0 ó update=1
      * @param int $idFirmante del firmante para cuando es una edicion
      * @param varchar $nombre del firmante
      * @param varchar $email correo electronico del firmante
      * @param varchar $telefono del firmante
      * @param varchar $iniciales del firmante
      * @param int $inactivo  estatus del registro 1=activo 0=inactivo
      * @param varchar $imagenAnterior nombre de la imagen anterior para borrarla de carpeta
      * @param int $elementos numero de archvos imagenes 1 ó 0
      *
      **/   
    function guardarFirmantes($tipo_mov,$idFirmante,$nombre,$email,$telefono,$iniciales,$inactivo,$imagenAnterior,$elementos){
        $verifica = 0;
  
       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");
  
        $verifica = $this -> guardarActualizar($tipo_mov,$idFirmante,$nombre,$email,$telefono,$iniciales,$inactivo,$imagenAnterior,$elementos);
  
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
  
        return $verifica;
    }//-- fin function guardarCostosAdministrativos

    /**
      * Guarda los datos de un costo administrativo, regresa el id de la sucursal afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov movimiento que se va a ejecutar, si es insercion=0 ó update=1
      * @param int $idFirmante del firmante para cuando es una edicion
      * @param varchar $nombre del firmante
      * @param varchar $email correo electronico del firmante
      * @param varchar $telefono del firmante
      * @param varchar $iniciales del firmante
      * @param int $inactivo  estatus del registro 1=activo 0=inactivo
      * @param varchar $imagenAnterior nombre de la imagen anterior para borrarla de carpeta
      * @param int $elementos numero de archvos imagenes 1 ó 0
      *
      **/ 
    function guardarActualizar($tipo_mov,$idFirmante,$nombre,$email,$telefono,$iniciales,$inactivo,$imagenAnterior,$elementos){
  
        $verifica = 0;

        if($tipo_mov==0){

            $query = "INSERT INTO cat_firmantes(nombre,telefono,email,iniciales,activo) 
                        VALUES ('$nombre','$telefono','$email','$iniciales','$inactivo')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);

        }else{

            $query = "UPDATE cat_firmantes 
                        SET nombre='$nombre',
                        telefono='$telefono',
                        email='$email',
                        iniciales='$iniciales',
                        activo='$inactivo' 
                        WHERE id=".$idFirmante;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id_registro = $idFirmante;
        }
        
        if ($result) {
            
            if($elementos>0){

                if($imagenAnterior!=''){
                    $ruta_img ="../firmantes/".$imagenAnterior;
                    @unlink($ruta_img);
                    $verifica = $this-> guardarArchivos($elementos,$id_registro);
                }else{
                    $verifica = $this-> guardarArchivos($elementos,$id_registro);
                }
             
            }else{

              $verifica = 1; //se inserto registro
            }
               
        }else{

            $verifica = 0;
        }
        
        return $verifica;
    }//--fin function guardarActualizar

    /**
      * Guarda los archivos que vengan en este caso el logo 
      * 
      * @param int $elementos numero de archivos a subir
      * @param varchar $id_registro es  para identificar el registro a modificar
      * @param varchar $nombre nombre que llevara la imagen la cual inicara con firma_ nombre del firmante 
      *
      **/ 
    function guardarArchivos($elementos,$id_registro){

    $verifica = 0;

    if(isset($_FILES['firma_'.$elementos]['name'])){
        $uTime = microtime(true);
        $rest = substr($uTime, -4); 
        $nombre_imagen=$_FILES['firma_'.$elementos]['name']; 
        $tipo_a=explode('.', $nombre_imagen);
        $ext=$tipo_a[count($tipo_a)-1];
        $nombre_img_bd="firma_".$id_registro."_".$rest.".".$ext;
        $ruta_img = "../firmantes/".$nombre_img_bd;
        
        if((move_uploaded_file($_FILES['firma_'.$elementos]['tmp_name'],$ruta_img))){

            $query = "UPDATE cat_firmantes SET firma='$nombre_img_bd' WHERE id=".$id_registro;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
            if ($result) {
            
                $verifica = 1;  //se inserto imagen
            
            }else{
                $verifica = 2; //no se inserto imagen
            }

        }

    }
        return $verifica;
    }//--fin function guardarArchivos

    /**
      * Busca las sucursales de todas las unidades de negocio a las que se puede acceder,
      * las que aun no se han asignado
      * 
      * @param int $idUnidadNegocio unidades de negocio encontrada a la que no tiene acceso 
      * @param int $idFirmante indica el id de firmante al que se le asignaran las sucursales
      *
      *
    **/  
    function buscarSucursalesDisponibles($idUnidadNegocio,$idFirmante){
        
        $resultado = $this->link->query("SELECT 
                                            unidades.id AS id_unidad_negocio,
                                            unidades.nombre AS unidad_negocio,
                                            sucursales.id_sucursal,
                                            sucursales.descr AS sucursal,
                                            IFNULL(accesos_firmantes.id,0) AS id_acceso
                                            FROM cat_unidades_negocio unidades
                                            LEFT JOIN sucursales ON unidades.id=sucursales.id_unidad_negocio
                                            LEFT JOIN accesos_firmantes ON unidades.id=accesos_firmantes.id_unidad_negocio 
                                            AND  sucursales.id_sucursal=accesos_firmantes.id_sucursal  AND accesos_firmantes.id_firmante=".$idFirmante."
                                            WHERE unidades.inactivo=0 AND sucursales.activo=1 AND unidades.id=".$idUnidadNegocio."
                                            HAVING id_acceso = 0
                                            ORDER BY unidades.nombre,sucursales.descr ASC");
        return query2json($resultado);
            
    }//- fin function buscarSucursalesDisponibles
  
    /**
      * Busca todos los acceso de un usuario, las sucursales que ya fueron agregadas
      * 
      * @param int $idFirmante indica el id de usuario al que se le asignaron los accesos  
      *
    **/  
    function buscarSucursalesAgregadas($idFirmante){
         
        $resultado = $this->link->query("SELECT 
                                            unidades.nombre AS unidad_negocio,
                                            sucursales.descr AS sucursal,
                                            IFNULL(accesos_firmantes.id,0) AS id_acceso
                                            FROM cat_unidades_negocio unidades
                                            LEFT JOIN sucursales ON unidades.id=sucursales.id_unidad_negocio
                                            LEFT JOIN accesos_firmantes ON unidades.id=accesos_firmantes.id_unidad_negocio 
                                            AND sucursales.id_sucursal=accesos_firmantes.id_sucursal AND accesos_firmantes.id_firmante=".$idFirmante."
                                            WHERE unidades.inactivo=0 AND sucursales.activo=1
                                            HAVING id_acceso > 0
                                            ORDER BY unidades.nombre,sucursales.descr ASC");
        return query2json($resultado);
            
    }//- fin function buscarSucursalesAgregadas
  
    /**
      * Agega o quita sucursales a firmante
      * 
      * @param varchar $mov indica que es lo que se va a hacer: agregar, quitar
      * @param varchar $datos array que contiene 
      * idFirmante id del firmante a agregar o qutar la sucursal
      * idUnidadNegocio  id de la unidad de negocio a la que pertenece la sucursal
      * idSucursal  id dela sucursal a agregar o quitar
      *
    **/ 
    function AccesoSucursales($mov,$datos){
      
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
  
    }//-- fin function guardarUsuarios
  
    /**
      * asigna las sucursales al firmante
      * 
      * @param varchar $datos array que contiene 
      * idFirmante id del firmante a agregar o qutar la sucursal
      * idUnidadNegocio  id de la unidad de negocio a la que pertenece la sucursal
      * idSucursal  id dela sucursal a agregar o quitar
      *
    **/ 
    function insertaAcceso($datos){
      
        $verifica = 0;
    
        for($i=1; $i < count($datos); $i++){
    
            $idFirmante=$datos[$i]['idFirmante'];
            $idUnidadNegocio=$datos[$i]['idUnidadNegocio'];
            $idSucursal=$datos[$i]['idSucursal'];
    
            $query2 = "INSERT INTO accesos_firmantes(id_firmante,id_unidad_negocio,id_sucursal,id_compania) 
                    VALUES ('$idFirmante','$idUnidadNegocio','$idSucursal','$idSucursal')";
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
      * quita las sucursales al firmante
      * 
      * @param varchar $datos array que contiene 
      * idFirmante id del firmante a agregar o qutar la sucursal
      * idUnidadNegocio  id de la unidad de negocio a la que pertenece la sucursal
      * idSucursal  id dela sucursal a agregar o quitar
      *
    **/ 
    function quitarAcceso($datos){
        for($i = 1; $i < count($datos); $i++){
    
            $idAcceso=$datos[$i]['idAcceso'];
        
            $query2 = "DELETE FROM accesos_firmantes WHERE id=".$idAcceso;
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

    /**
      * Busca los firmantes que pertenecen a una unidad de negocio y una sucursal 
      * 
      * @param int $idUnidadNegocio de la unidad de negocio  
      * @param int $idSucursal de la sucursal
      *
    **/  
    function buscarFirmantesUnidadSucursal($idUnidadNegocio,$idSucursal){
        $result1 = $this->link->query("SELECT a.id,a.nombre,a.iniciales
                                            FROM cat_firmantes a 
                                            LEFT JOIN accesos_firmantes b ON a.id=b.id_firmante
                                            WHERE b.id_unidad_negocio=".$idUnidadNegocio." AND b.id_sucursal=".$idSucursal." AND a.activo=1
                                            ORDER BY a.nombre");
    
        return query2json($result1);
    }//- fin function buscarFirmantesUnidadSucursal

}//--fin de class Firmantes
    
?>