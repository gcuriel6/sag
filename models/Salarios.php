<?php

include 'conectar.php';

class Salarios
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Salarios()
    {
  
      $this->link = Conectarse();

    }

    function verificarSalarios($datos){
      $idUnidadNegocio = $datos['idUnidadNegocio'];
      $idSucursal = $datos['idSucursal'];
      $idPuesto = $datos['idPuesto'];
      $sueldoMensual = $datos['sueldoMensual'];

      $verifica = 0;

      $query = "SELECT id FROM cat_salarios 
                WHERE id_unidad_negocio=$idUnidadNegocio AND id_sucursal=$idSucursal 
                AND id_puesto=$idPuesto AND sueldo_mensual=$sueldoMensual";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;
    }


    /**
      * Manda llamar a la funcion que guarda la informacion sobre un salario
      * 
      * @param json $datos arreglo con todos los datos necesarios para insertar o actualizar un registro
      *
      **/      
    function guardarSalarios($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarSalarios


     /**
      * Guarda los datos de un salario, regresa el id del registro afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $idUnidadNegocio es un id para identificar una unidad de negocio
      * @param int $idPuesto es el id de la tabla  cat_puestos
      * @param double $salarioDiario monto de salario diario de un respinactivo puesto debe ser mayor a 0
      * @param double $salarioDiarioI monto de salario diario integrado de un respinactivo puesto debe ser mayor a 0
      * @param double $sueldoMensual monto de salario mensual de un respinactivo puesto debe ser mayor a 0
      * @param double $cuotaImss monto de la couta aignada al IMSS debe ser mayor a 0
      * @param double $cuotaInfonavit monto de la couta aignada al INFONAVIT debe ser mayor a 0
      * @param double $dispersion porcentaje de dispercion por dafult es 4% debe ser mayor a 0
      * @param int $inactivo estatus de una unidad de negocio 0='Activa' 1='Inactiva'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $tipoMov = $datos['tipoMov'];
        $id = $datos['id'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idPuesto = $datos['idPuesto'];
        $sueldoMensual = $datos['sueldoMensual'];
        $sueldoFestivo = $datos['sueldoFestivo'];
        $sueldoDia31 = $datos['sueldoDia31'];
        $vacaciones = $datos['vacaciones'];
        $dispersion = $datos['dispersion'];
        $inactivo = $datos['inactivo'];

        if($tipoMov==0){

          $query = "INSERT INTO cat_salarios(id_unidad_negocio, id_sucursal,id_puesto,sueldo_mensual,porcentaje_dispersion,sueldo_festivo,sueldo_dia31,dias_vacaciones) 
                    VALUES ('$idUnidadNegocio','$idSucursal','$idPuesto','$sueldoMensual','$dispersion','$sueldoFestivo','$sueldoDia31','$vacaciones')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_salarios SET id_unidad_negocio='$idUnidadNegocio',id_sucursal='$idSucursal', 
                    id_puesto='$idPuesto', sueldo_mensual='$sueldoMensual', porcentaje_dispersion='$dispersion', 
                    inactivo='$inactivo',sueldo_festivo='$sueldoFestivo',sueldo_dia31='$sueldoDia31',dias_vacaciones='$vacaciones' 
                    WHERE id=".$id;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $id;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una unidad de negocio, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivos 0=inactivos 2=todos
      *
      **/
      function buscarSalarios($estatus,$idUnidadNegocio,$idSucursal){

        if($idSucursal != '')  //-->No tengo sucursales con permisos en la unidad entonces debo regresar un array vacio
        {
          if($idSucursal[0] == ',')
          {
              $dato=substr($idSucursal,1);
              $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
          }else{ 
              $sucursal = ' AND a.id_sucursal ='.$idSucursal;
          }

          $condicionEstatus='';

          if($estatus==1){
            $condicionEstatus=' AND inactivo=1';
          }
          if($estatus==0){
            $condicionEstatus=' AND  inactivo=0';
          }
       
          $resultado = $this->link->query("SELECT a.id,a.id_unidad_negocio, a.id_puesto, a.sueldo_mensual,
                  a.sueldo_festivo,a.sueldo_dia31,IFNULL(a.dias_vacaciones,'') AS dias_vacaciones,
                  a.inactivo, b.nombre AS unidad_negocio,c.puesto,a.id_sucursal,IFNULL(d.descr,'') AS sucursal
                  FROM cat_salarios a
                  LEFT JOIN  cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                  LEFT JOIN cat_puestos c ON a.id_puesto=c.id_puesto
                  LEFT JOIN  sucursales d ON a.id_sucursal=d.id_sucursal
                  WHERE a.id_unidad_negocio=$idUnidadNegocio $sucursal $condicionEstatus
                  ORDER BY id");
          return query2json($resultado);
        }else{
                  
          $arr = array();

          return json_encode($arr);
        }

      }//- fin function buscarSalarios

      function buscarSalariosId($id){
        
           $resultado = $this->link->query("SELECT id,id_unidad_negocio,id_sucursal,id_puesto,sueldo_mensual,
              porcentaje_dispersion,inactivo,sueldo_festivo,sueldo_dia31,dias_vacaciones
              FROM cat_salarios 
              WHERE id=$id
              ORDER BY id");
           return query2json($resultado);
          

      }//- fin function buscarSalariosId

    
}//--fin de class Salarios
    
?>