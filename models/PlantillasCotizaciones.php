<?php

include 'conectar.php';

class PlantillasCotizaciones
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function PlantillasCotizaciones()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la clave del area no se repita
      *
      * @param varchar $clave  usado para indentificar en las Búsqueda de  des un area
      *
    **/
    function verificarPlantillasCotizaciones($idUnidadNegocio){
      
      $verifica = 0;

      $query = "SELECT id FROM cat_plantillas_cotizacion WHERE id_unidad_negocio = '$idUnidadNegocio'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaPlantillasCotizaciones

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una area
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una area en particular
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $inactiva estatus de una area  1='Activa' 0='Inactiva'  
      *
    **/      
    function guardarPlantillasCotizaciones($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarPlantillasCotizaciones


     /**
      * Guarda los datos de una area, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del area para realizarla
      * @param varchar $clave es una clave para identificar una area en particular
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $inactiva estatus de una area  1='Activa' 0='Inactiva'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $id = $datos[1]['id'];
        $tipoMov = $datos[1]['tipoMov'];
        $idUnidadNegocio = $datos[1]['idUnidadNegocio'];
        $elementos = $datos[1]['elementos'];
        $servicios = $datos[1]['servicios'];
        $vehiculos = $datos[1]['vehiculos'];
        $tesoreria = $datos[1]['tesoreria'];
        $consumibles = $datos[1]['consumibles'];
        $equipo = $datos[1]['equipo'];
        $operaciones = $datos[1]['operaciones'];
        $compras = $datos[1]['compras'];
        $recursosHumanos = $datos[1]['recursosHumanos'];
        $activosFijos = $datos[1]['activosFijos'];
        $comercial = $datos[1]['comercial'];
        $contraloria = $datos[1]['contraloria'];
        $activo = $datos[1]['activo'];
        $textoInicio = $datos[1]['textoInicio'];
        $textoFin = $datos[1]['textoFin'];

        if($tipoMov==0){

          $query = "INSERT INTO cat_plantillas_cotizacion(elementos,equipo,servicios,vehiculos,consumibles,tesoreria,recursos_humanos,operaciones,compras,activos_fijos,comercial,contraloria,id_unidad_negocio,activo,texto_inicio,texto_fin) VALUES ('$elementos','$equipo','$servicios','$vehiculos','$consumibles','$tesoreria','$recursosHumanos','$operaciones','$compras','$activosFijos','$comercial','$contraloria','$idUnidadNegocio','$activo','$textoInicio','$textoFin')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_plantillas_cotizacion SET elementos='$elementos',equipo='$equipo',servicios='$servicios',vehiculos='$vehiculos', consumibles='$consumibles', tesoreria='$tesoreria',recursos_humanos='$recursosHumanos',operaciones='$operaciones',compras='$compras', activos_fijos='$activosFijos', comercial='$comercial', contraloria='$contraloria', id_unidad_negocio='$idUnidadNegocio', activo='$activo', texto_inicio='$textoInicio', texto_fin='$textoFin' WHERE id=".$id;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $id;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activa 0=inactiva 2=todos
      *
      **/
      function buscarPlantillasCotizaciones($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE activa=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE activa=0';
        }

        $resultado = $this->link->query("SELECT a.id,CONCAT(IF(a.elementos=0,'','ELEMENTOS,'),' ',IF(a.equipo=0,'','EQUIPO,'),' ',IF(a.servicios=0,'','SERVICIOS,'),' ',IF(a.vehiculos=0,'','VEHICULOS'),' ',IF(a.consumibles=0,'','CONSUMIBLES')) AS secciones,a.id_unidad_negocio,a.activo,a.texto_inicio,texto_fin,b.nombre AS unidad_negocio
FROM cat_plantillas_cotizacion a
LEFT JOIN cat_unidades_negocio  b ON a.id_unidad_negocio=b.id
$condicionEstatus
ORDER BY a.id");
        return query2json($resultado);

      }//- fin function buscarPlantillasCotizaciones

    function buscarPlantillasCotizacionesId($id){
        $resultado = $this->link->query("SELECT id,elementos,equipo,servicios,vehiculos,consumibles,tesoreria,recursos_humanos,operaciones,compras,activos_fijos,comercial,contraloria,id_unidad_negocio,activo,texto_inicio,texto_fin 
FROM cat_plantillas_cotizacion 
WHERE id=$id
ORDER BY id");
        return query2json($resultado);
          

      }//- fin function buscarPlantillasCotizacionesId
 
  /**
    * Busca los datos de cat_costos_administrativos, retorna un JSON con los datos correspondientes
    * 
    * @param int $idUnidadNegocio busca los datos de la plantilla de la unidad negocio requerida
    *
    **/
  function buscarPlantillasCotizacionesIdUnidad($idUnidadNegocio){
    
      $result = $this->link->query("SELECT id,elementos,equipo,servicios,vehiculos,consumibles,
                                      tesoreria,recursos_humanos,operaciones,compras,activos_fijos,
                                      comercial,contraloria,texto_inicio,texto_fin 
                                      FROM cat_plantillas_cotizacion 
                                      WHERE id_unidad_negocio=".$idUnidadNegocio." AND activo=1");

      return query2json($result);
      
  }//-- fin function buscarPlantillasCotizacionesIdUnidad

}//--fin de class PlantillasCotizaciones
    
?>