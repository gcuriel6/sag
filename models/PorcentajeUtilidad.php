<?php

include 'conectar.php';

class PorcentajeUtilidad
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function PorcentajeUtilidad()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que no se registre mas de un porcentaje de utilidad con una misma sucursal y unidad de negocio
      *
      * @param int $id_unidad_negocio es una clave para identificar si ya existe un costo
      * @param int $id_sucursal es una clave para identificar si ya existe un costo
      *
      **/
    function verificarPorcentajeUtilidad($id_unidad_negocio,$id_sucursal){
        $verifica = 0;

        $query = "SELECT id FROM cat_porcentaje_utilidad WHERE id_unidad_negocio=$id_unidad_negocio AND id_sucursal=$id_sucursal";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
            $verifica = 1;

        return $verifica;
    }//-- fin function verificarPorcentajeUtilidad  

    /**
      * Busca los datos de cat_porcentaje_utilidad, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos
      * @param varchar $lista  lista con las unidades separadas por coma
      *
      **/
    function buscarPorcentajeUtilidad($estatus,$lista){

        $unidades='';
        if($lista != ''){
            $dato=substr($lista,1);
            $unidades = ' a.id_unidad_negocio IN('.$dato.') AND ';
        }
      
        $condicion='';
        if( $estatus == 0 )
        {
            $condicion=' AND a.activo=1 ';
        }else if( $estatus == 1 ){
            $condicion=' AND a.activo=0 ';
        }else{
            $condicion='';
        }
        
        $result1 = $this->link->query("SELECT a.id,a.id_unidad_negocio,a.utilidad,a.activo,b.nombre AS unidad_negocio, c.descr AS sucursal
                                            FROM cat_porcentaje_utilidad a 
                                            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                                            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                                            WHERE $unidades b.inactivo=0 $condicion
                                            ORDER BY a.id");
    
        return query2json($result1);
    }//-- fin function buscarPorcentajeUtilidad

    /**
      * Busca los datos de cat_porcentaje_utilidad, retorna un JSON con los datos correspondientes
      * 
      * @param int $idPorcentajeUtilidad trae los datos de idPorcentajeUtilidad requerido
      *
      **/
    function buscarPorcentajeUtilidadId($idPorcentajeUtilidad){
    
        $result = $this->link->query("SELECT a.id,a.utilidad,a.activo,a.id_unidad_negocio,a.id_sucursal
                                        FROM cat_porcentaje_utilidad a 
                                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                                        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                                        WHERE a.id=".$idPorcentajeUtilidad);
        return query2json($result);
        
    }//-- fin function buscarPorcentajeUtilidadId

    /**
      * Manda llamar a la funcion que guarda la informacion
      * 
      * @param varchar $datos es un array que contiene los parametros
      *
      **/   
    function guardarPorcentajeUtilidad($datos){
        $verifica = 0;
  
       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");
  
        $verifica = $this -> guardarActualizar($datos);
  
        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');
  
        return $verifica;
    }//-- fin function guardarPorcentajeUtilidad

    /**
      * Guarda los datos de un porcentaje de utilidad, regresa el id de la sucursal afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param varchar $datos es un array que contiene los parametros
      * idPorcentajeUtilidad del registro a actualizar
      * id_unidad_negocio --> id_de la unidad de negocio a la que pertenece el registro
      * id_sucursal --> id_de la sucursal a la que pertenece el registro
      * utilidad --> porcentaje de utilidad
      * inactivo  --> estatus del registro 1=activo, 0=inactivo 
      * tipo_mov  --> indica si es una insercion = 0 ó actualizacion = 1
      *
      **/ 
    function guardarActualizar($datos){
  
        $verifica = 0;

        $idPorcentajeUtilidad = $datos['idPorcentajeUtilidad'];
        $id_unidad_negocio = $datos['id_unidad_negocio'];
        $id_sucursal = $datos['id_sucursal'];
        $utilidad = $datos['utilidad'];
        $inactivo = $datos['inactivo'];
        $tipo_mov = $datos['tipo_mov'];
        
        if($tipo_mov==0){

            $query = "INSERT INTO cat_porcentaje_utilidad(utilidad,activo,id_unidad_negocio,id_sucursal)
                        VALUES ('$utilidad','$inactivo','$id_unidad_negocio','$id_sucursal')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $id_registro = mysqli_insert_id($this->link);

            if ($result) {
                $verifica = 1;
            }else{
                $verifica = 0;
            }

        }else{

            $query = "UPDATE cat_porcentaje_utilidad SET utilidad='$utilidad',activo='$inactivo',id_unidad_negocio='$id_unidad_negocio',id_sucursal='$id_sucursal' WHERE id=".$idPorcentajeUtilidad;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            
            if ($result) {
                $verifica = 1;
            }else{
                $verifica = 0;
            }
        }
        
        return $verifica;
    }//--fin function guardarActualizar

    /**
    * Busca el porcentaje de utilidad de la unidad y sucursal seleccionada
    * 
    * @param int $idUnidadNegocio seleccionada
    * @param int $idSucursal seleccionada
    *
    **/
    function buscarPorcentajeUtilidadIdUnidad($idUnidadNegocio,$idSucursal){
        
        $result = $this->link->query("SELECT utilidad 
                                        FROM cat_porcentaje_utilidad 
                                        WHERE id_unidad_negocio=".$idUnidadNegocio." AND id_sucursal=".$idSucursal);

        return query2json($result);
        
    }//-- fin function buscarPlantillasCotizacionesIdUnidad

}//--fin de class PorcentajeUtilidad
    
?>