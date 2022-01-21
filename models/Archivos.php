<?php

include 'conectar.php';

class Archivos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Archivos()
    {
  
      $this->link = Conectarse();

    }

    function buscarCarpetasArea($idUnidadNegocio,$idArea){
        $result1 = $this->link->query("SELECT id,carpeta FROM carpetas_areas 
                                        WHERE id_unidad_negocio=$idUnidadNegocio 
                                        AND id_area=$idArea AND carpeta != ''");

        return query2json($result1);
    }

    function existeCarpetaArea($idUnidadNegocio,$idArea){
        $id = 0;
      
        $result = mysqli_query($this->link,"SELECT id FROM carpetas_areas 
                                            WHERE id_unidad_negocio=$idUnidadNegocio 
                                            AND id_area=$idArea AND carpeta=''");                        
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0)
            $id = $row['id'];
      
        return  $id;
    }

    function verificaCarpetaNombre($datos){
        $verifica = 0;

        $idArea = $datos['idArea'];
        $nombre = $datos['nombre'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        
        $query = "SELECT id FROM carpetas_areas WHERE id_unidad_negocio=$idUnidadNegocio 
                    AND id_area=$idArea AND carpeta='$nombre'";
    
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
            $verifica = 1;

        return $verifica;
    }

    function guardar($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $tipo = $datos['tipo'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idArea = $datos['idArea'];
        $idCarpeta = isset($datos['idCarpeta']) ? $datos['idCarpeta'] : 0;

        if($idCarpeta == 0)
        {  //--> Se guardara en raiz y verifica si ya existe creada la carpeta del area

            $id = $this->existeCarpetaArea($idUnidadNegocio,$idArea);

            if($id == 0)
                $verifica = $this->crearCarpetaArea($datos);
            else
            {

                if($tipo == 'carpeta')
                    $verifica = $this->crearCarpeta($datos);
                else
                    $verifica = $this->crearArchivo($datos,$id);
                
            }
        }else{//--> Ya selecciono una carpeta interna de una carpeta area
            $verifica = $this->crearArchivo($datos,$idCarpeta);
        }

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');


        return $verifica;
    }

    function crearCarpetaArea($datos){
        $verifica = 0;

        $idArea = $datos['idArea'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $tipo = $datos['tipo'];

        $query = "INSERT INTO carpetas_areas(id_unidad_negocio,id_area) 
                VALUES ('$idUnidadNegocio','$idArea')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idCarpeta = mysqli_insert_id($this->link);

        if($result) 
        {

            $carpetaR = "../administracion_archivos/".$idUnidadNegocio."/";
            $carpeta = "../administracion_archivos/".$idUnidadNegocio."/".$idArea. "/";
            mkdir($carpetaR, 0777);
            mkdir($carpeta, 0777);
            
            if(file_exists($carpeta))
            {

                if($tipo == 'carpeta')
                    $verifica = $this->crearCarpeta($datos);
                else
                    $verifica = $this->crearArchivo($datos,$idCarpeta);

            }else
                $verifica = 0;            

        }
           

        return $verifica;
    }

    function crearCarpeta($datos){
        $verifica = 0;

        $idArea = $datos['idArea'];
        $nombre = $datos['nombre'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];

        $query = "INSERT INTO carpetas_areas(id_unidad_negocio,id_area,carpeta) 
                VALUES ('$idUnidadNegocio','$idArea','$nombre')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idCarpeta = mysqli_insert_id($this->link);

        if($result) 
        {
            $carpeta = "../administracion_archivos/".$idUnidadNegocio."/".$idArea."/".$nombre;
            mkdir($carpeta, 0777);

            if(file_exists($carpeta))
                $verifica = $idCarpeta;
            else
                $verifica = 0;
            
        }

        return $verifica;
    }

    function verificaDescripcionArchivo($datos){
        $verifica = 0;

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idArea = $datos['idArea'];
        $descripcion = $datos['descripcion'];
        $idCarpeta = $datos['idCarpeta'];

        if($idCarpeta == 0)
        {
            $id = $this->existeCarpetaArea($idUnidadNegocio,$idArea);
            if($id > 0)
                $query = "SELECT id FROM archivos_carpeta WHERE id_carpeta=$id AND descripcion='$descripcion'";

        }else{
            $query = "SELECT id FROM archivos_carpeta WHERE id_carpeta=$idCarpeta AND descripcion='$descripcion'";
        }
    
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
            $verifica = 1;

        return $verifica;
    }

    function crearArchivo($datos,$idCarpeta){
        $verifica = 0;

        $descripcion = $datos['descripcion'];
        $idArea = $datos['idArea'];
        $nombreCarpeta = $datos['nombreCarpeta'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];

        $query = "INSERT INTO archivos_carpeta(id_carpeta,descripcion) 
                VALUES ('$idCarpeta','$descripcion')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idArchivo = mysqli_insert_id($this->link);

        if($result) 
        {
            if($nombreCarpeta == '')
                $carpeta = "../administracion_archivos/".$idUnidadNegocio."/".$idArea;
            else
                $carpeta = "../administracion_archivos/".$idUnidadNegocio."/".$idArea."/".$nombreCarpeta;

                if(isset($_FILES['archivo']['name'])){
                    $nombre_origen=strtolower($_FILES['archivo']['name']); //-->nombre original
                    $tipo_a=explode('.', $nombre_origen);
                    
                    $ext=$tipo_a[count($tipo_a)-1];
                    $nombre_nuevo=$idArchivo."_archivo.".$ext;
                    $ruta = $carpeta.'/'.$nombre_nuevo;
                    
                    if((move_uploaded_file($_FILES['archivo']['tmp_name'],$ruta))){
            
                        $query = "UPDATE archivos_carpeta SET nombre_original='$nombre_origen',nombre='$nombre_nuevo' 
                                    WHERE id=".$idArchivo;
                        $result = mysqli_query($this->link, $query) or die(mysqli_error());
                    
                        if ($result) {
                        
                            $verifica = $idArchivo;  //se inserto imagen
                        
                        }else{
                            $verifica = 0; 
                        }
            
                    }
            
                }
            
        }else
            $verifica = 0; 

        return $verifica;
    }

    function buscarArchivosIdCarpeta($idCarpeta,$carpeta){
        $result1 = $this->link->query("SELECT id,nombre,descripcion,nombre_original 
                                        FROM archivos_carpeta WHERE id_carpeta=".$idCarpeta);

        return query2json($result1);
    }

    function buscarArchivosIdArea($idUnidadNegocio,$idArea){
        $idCarpeta = $this->existeCarpetaArea($idUnidadNegocio,$idArea);

        $result = $this->link->query("SELECT id,nombre,descripcion,nombre_original 
        FROM archivos_carpeta WHERE id_carpeta=".$idCarpeta);

        return query2json($result);
    }

    function eliminarArchivo($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this->eliminar($datos);
        
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');


        return $verifica;
    }

    function eliminar($datos){
        $verifica = 0;

        $tipo = $datos['tipo'];
        $idArchivo = $datos['idArchivo'];
        $archivo = $datos['archivo'];
        $carpeta = isset($datos['carpeta']) ?$datos['carpeta'] : '';
        $carpetaRaiz = $datos['carpetaRaiz'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        
        if($tipo == 'carpeta')
            $archivo_eliminar = "../administracion_archivos/".$idUnidadNegocio."/".$carpetaRaiz."/".$carpeta."/".$archivo;
        else
            $archivo_eliminar = "../administracion_archivos/".$idUnidadNegocio."/".$carpetaRaiz."/".$archivo;
        

        $query = "DELETE FROM archivos_carpeta WHERE id=".$idArchivo;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if($result){
            
            if(!unlink($archivo_eliminar)){
                $verifica = 0;
            }else{
                $verifica = 1;
            }

        }else{
            $verifica = 0;
        }
       

        return $verifica;
    }

    function eliminarCarpeta($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this->eliminarCarpetaInt($datos);
        
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');


        return $verifica;
    }

    function eliminarCarpetaInt($datos){
        $verifica = 0;

        $idCarpeta = $datos['idCarpeta'];
        $carpeta = $datos['carpeta'];
        $carpetaRaiz = $datos['carpetaRaiz'];
        $archivos = $datos['archivos'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];

        $carpeta_eliminar = "../administracion_archivos/".$idUnidadNegocio."/".$carpetaRaiz."/".$carpeta;

        $query = "DELETE FROM carpetas_areas WHERE id=".$idCarpeta;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        if($result){
            if($archivos == 0)
            {
                if(!rmdir($carpeta_eliminar)){
                    $verifica = 0;
                }else{
                    $verifica = 1;
                }
            }else{
                $registros = json_decode($this-> buscarArchivosIdCarpeta($idCarpeta,$carpeta),true);

                foreach($registros as $a){
                    $idArchivo = $a['id'];
                    $archivo = $a['nombre'];

                    $arrD = array('tipo' => 'carpeta',
                                'idArchivo' => $idArchivo,
                                'archivo' => $archivo,
                                'carpeta' => $carpeta,
                                'carpetaRaiz' => $carpetaRaiz,
                                'idUnidadNegocio' => $idUnidadNegocio);

                    $verifica = $this-> eliminar($arrD);

                    if($verifica == 0)
                        break;

                }



                if($verifica > 0)
                {
                    if(!rmdir($carpeta_eliminar)){
                        $verifica = 0;
                    }else{
                        $verifica = 1;
                    } 
                }
            }
        }else{
            $verifica = 0;
        }

        return $verifica;
    }
    
}//--fin de class Archivos
    
?>