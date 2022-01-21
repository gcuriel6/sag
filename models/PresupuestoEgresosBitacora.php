<?php

require_once('conectar.php');

class PresupuestoEgresosBitacora
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function PresupuestoEgresosBitacora()
    {
  
      $this->link = Conectarse();

    }

    

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una area
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una area en particular
      * @param varchar $descripcion brebe descripcion de una area
      * @param int $inactiva estatus de una area  1='Activa' 0='Inactiva'  
      *
    **/      
    function guardarPresupuestoEgresosBitacora($datos){
    
        $verifica = 0;

        $verifica = $this -> guardarActualizar($datos);

        return $verifica;

    } //-- fin function guardarPresupuestoEgresosBitacora


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
        $modulo = $datos['modulo'];
        $idRegistro = $datos['idRegistro'];
        $idUsuario = $datos['idUsuario'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $camposModificados = $datos['camposModificados'];
       

        $query = "INSERT INTO presupuestos_bitacora(modulo,id_registro,id_unidad_negocio,id_sucursal,campos_modificados,id_usuario_modificacion) 
        VALUES ('$modulo','$idRegistro','$idUnidadNegocio','$idSucursal','$camposModificados','$idUsuario')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
         
        if ($result) 
          $verifica = $idRegistro;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=activa 0=inactiva 2=todos
      *
      **/
      function buscarPresupuestoEgresosBitacora($modulo,$idUnidad,$idSucursal,$fechaInicio,$fechaFin){
       
        $condicion='';

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND MONTH(presupuestos_bitacora.fecha_modificacion)= MONTH(CURDATE()) AND YEAR(presupuestos_bitacora.fecha_modificacion)= YEAR(CURDATE()) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND presupuestos_bitacora.fecha_modificacion >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND presupuestos_bitacora.fecha_modificacion >= '$fechaInicio' AND presupuestos_bitacora.fecha_modificacion <= '$fechaFin' ";
        }

        $resultado = $this->link->query("SELECT 
        presupuestos_bitacora.campos_modificados,
        presupuestos_bitacora.fecha_modificacion,
              cat_unidades_negocio.id AS id_unidad,
              cat_unidades_negocio.nombre AS nombre_unidad,
              sucursales.id_sucursal AS id_sucursal,
              sucursales.descr AS nombre_sucursal,
              IFNULL(fam_gastos.id_fam,'') AS id_familia,
              IFNULL(fam_gastos.descr,'') AS nombre_familia,
              IFNULL(gastos_clasificacion.id_clas,'') AS id_clasificacion,
              IFNULL(gastos_clasificacion.descr,'') AS nombre_clasificacion,
              IFNULL(presupuesto_egresos.anio,'') AS anio,
              IFNULL(presupuesto_egresos.mes,'') AS mes,
              usuarios.usuario
              FROM presupuestos_bitacora 
              LEFT JOIN  presupuesto_egresos ON presupuestos_bitacora.id_registro=presupuesto_egresos.id
              LEFT JOIN cat_unidades_negocio ON presupuesto_egresos.id_unidad_negocio = cat_unidades_negocio.id
              LEFT JOIN sucursales ON presupuesto_egresos.id_sucursal = sucursales.id_sucursal
              LEFT JOIN fam_gastos ON presupuesto_egresos.id_familia_gasto = fam_gastos.id_fam
              LEFT JOIN gastos_clasificacion ON presupuesto_egresos.id_clasificacion = gastos_clasificacion.id_clas
              LEFT JOIN usuarios ON presupuestos_bitacora.id_usuario_modificacion = usuarios.id_usuario
        WHERE presupuestos_bitacora.modulo='$modulo' AND presupuestos_bitacora.id_unidad_negocio = ".$idUnidad."
        AND presupuestos_bitacora.id_sucursal = ".$idSucursal." $condicion 
        ORDER BY presupuestos_bitacora.id DESC");
        return query2json($resultado);

      }//- fin function buscarPresupuestoEgresosBitacora
    
}//--fin de class PresupuestoEgresosBitacora
    
?>