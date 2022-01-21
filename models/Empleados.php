<?php

include 'conectar.php';

class Empleados
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Empleados()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los datos de una unidad de negocio, retorna un JSON con los datos correspondientes
      * 
      * @param int $id si id es 0 trae todos los registros, si no trae los datos de id requerido
      *
      **/
      function buscarEmpleadosSupervisor($idEmpleado){

        $verifica=0;

          if($idEmpleado == 0 ){

         $query = "SELECT 
         trabajadores.id_trabajador,
         trabajadores.id_sup,
         CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)) AS nombre,
         sucursales.descr AS sucursal,
         cat_unidades_negocio.nombre AS unidad_negocio
         FROM trabajadores 
         LEFT JOIN sucursales ON trabajadores.id_sucursal=sucursales.id_sucursal 
         LEFT JOIN cat_unidades_negocio ON sucursales.id_unidad_negocio = cat_unidades_negocio.id
         INNER JOIN cat_puestos ON trabajadores.id_puesto = cat_puestos.id_puesto
         WHERE cat_puestos.supervision = 1 AND trabajadores.fecha_baja = '0000-00-00'
         ORDER BY trabajadores.nombre";

        }else{

          $query = "SELECT 
          trabajadores.id_trabajador,
          trabajadores.id_sup,
          CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)) AS nombre,
          sucursales.descr AS sucursal,
          cat_unidades_negocio.nombre AS unidad_negocio
          FROM trabajadores 
          LEFT JOIN sucursales ON trabajadores.id_sucursal=sucursales.id_sucursal 
          LEFT JOIN cat_unidades_negocio ON sucursales.id_unidad_negocio = cat_unidades_negocio.id
          INNER JOIN cat_puestos ON trabajadores.id_puesto = cat_puestos.id_puesto
          WHERE cat_puestos.supervision = 1 AND trabajadores.fecha_baja = '0000-00-00'
          AND trabajadores.id_trabajador=".$idEmpleado."
          ORDER BY trabajadores.nombre";
        
        }

        // echo $query;
        // exit();

        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result)
          $verifica = query2json($result);

        return $verifica;

      }//- fin function buscarEmpleadosSupervisor

    /** 
     *Busca los empleados de una sucursal
     *@param int $idSucursal id de la sucursal para buscar los empleados
    **/
    function buscarEmpleadosIdSucursal($idSucursal){
      /*$busca_deptos="SELECT IFNULL(GROUP_CONCAT(id_depto),0) AS departamentos FROM deptos WHERE id_sucursal=".$idSucursal;
      $resultF = mysqli_query($this->link, $busca_deptos) or die(mysqli_error());
      
      $datos = mysqli_fetch_array($resultF);
      $deptos = $datos['departamentos'];

      $departamentos = ' a.id_depto IN('.$deptos.')';

      $result = $this->link->query("SELECT a.cve_nom,a.id_trabajador,a.iniciales,CONCAT(TRIM(a.nombre),' ',TRIM(a.apellido_p),' ',TRIM(a.apellido_m)) AS nombre,
                                      b.puesto AS puesto,c.des_dep AS departamento
                                      FROM trabajadores a
                                      LEFT JOIN cat_puestos b ON a.id_puesto=b.id_puesto
                                      LEFT JOIN deptos c ON a.id_depto=c.id_depto
                                      WHERE $departamentos AND c.inactivo=0 AND a.fecha_baja='0000-00-00'
                                      ORDER BY a.nombre ASC");*/

      //NJES Jan/07/2010  Se busca cualquier empleado de una unidad, la tabla trabajadores tiene el campo id_sucursal 
      //y si es el vinculo con la tabla sucursales
      $result = $this->link->query("SELECT a.cve_nom,a.cve_nom AS no_nomina,a.id_trabajador,a.iniciales,CONCAT(TRIM(a.nombre),' ',TRIM(a.apellido_p),' ',TRIM(a.apellido_m)) AS nombre,
                                      IFNULL(b.puesto,'') AS puesto,IFNULL(c.des_dep,'') AS departamento,IFNULL(d.descr,'') AS sucursal
                                      FROM trabajadores a
                                      LEFT JOIN cat_puestos b ON a.id_puesto=b.id_puesto
                                      LEFT JOIN deptos c ON a.id_depto=c.id_depto
                                      LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                                      WHERE  a.fecha_baja='0000-00-00' AND a.id_sucursal=$idSucursal
                                      ORDER BY a.nombre ASC");

      return query2json($result);
    }

    /** 
     *Busca los empleados de todas las sucursales de una unidad de negocio
     *@param int $idUnidadNegocio 
    **/
    //function buscarEmpleadosIdUnidad($idUnidadNegocio){
    function buscarEmpleadosIdUnidad($idUnidadNegocio){
      
      /*$busca_deptos="SELECT IFNULL(GROUP_CONCAT(id_depto),0) AS departamentos FROM deptos WHERE id_unidad_negocio=".$idUnidadNegocio;
      $resultF = mysqli_query($this->link, $busca_deptos) or die(mysqli_error());
      
      $datos = mysqli_fetch_array($resultF);
      $deptos = $datos['departamentos'];

      $departamentos = ' a.id_depto IN('.$deptos.')';
      
      $result = $this->link->query("SELECT a.cve_nom,a.cve_nom as no_nomina,a.id_trabajador,a.iniciales,CONCAT(TRIM(a.nombre),' ',TRIM(a.apellido_p),' ',TRIM(a.apellido_m)) AS nombre,
                                      b.puesto AS puesto,c.des_dep AS departamento,d.descr AS sucursal
                                      FROM trabajadores a
                                      LEFT JOIN cat_puestos b ON a.id_puesto=b.id_puesto
                                      LEFT JOIN deptos c ON a.id_depto=c.id_depto
                                      LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal 
                                      WHERE $departamentos AND c.inactivo=0  AND a.fecha_baja='0000-00-00'
                                      ORDER BY a.nombre ASC");*/

      //NJES Jan/07/2020  Se busca cualquier empleado de una unidad, la tabla trabajadores tiene el campo id_sucursal 
      //y si es el vinculo con la tabla sucursales
      //-->NJES Feb/10/2020 se obtiene el departamento y area del empleado
      $result = $this->link->query("SELECT a.cve_nom,a.cve_nom AS no_nomina,a.id_trabajador,a.iniciales,CONCAT(TRIM(a.nombre),' ',TRIM(a.apellido_p),' ',TRIM(a.apellido_m)) AS nombre,
                                    IFNULL(b.puesto,'') AS puesto,IFNULL(c.des_dep,'') AS departamento,IFNULL(d.descr,'') AS sucursal,
                                    c.id_depto,c.id_area
                                    FROM trabajadores a
                                    LEFT JOIN cat_puestos b ON a.id_puesto=b.id_puesto
                                    LEFT JOIN deptos c ON a.id_depto=c.id_depto
                                    LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal 
                                    LEFT JOIN  cat_unidades_negocio e ON d.id_unidad_negocio= e.id
                                    WHERE d.id_unidad_negocio=$idUnidadNegocio AND a.fecha_baja='0000-00-00'
                                    ORDER BY a.nombre ASC");                            

      return query2json($result);
    }

    function buscarEmpleadosTodosUnidades(){
      
      /*$busca_deptos="SELECT IFNULL(GROUP_CONCAT(id_depto),0) AS departamentos FROM deptos WHERE id_unidad_negocio=".$idUnidadNegocio;
      $resultF = mysqli_query($this->link, $busca_deptos) or die(mysqli_error());
      
      $datos = mysqli_fetch_array($resultF);
      $deptos = $datos['departamentos'];

      $departamentos = ' a.id_depto IN('.$deptos.')';
      
      $result = $this->link->query("SELECT a.cve_nom,a.cve_nom as no_nomina,a.id_trabajador,a.iniciales,CONCAT(TRIM(a.nombre),' ',TRIM(a.apellido_p),' ',TRIM(a.apellido_m)) AS nombre,
                                      b.puesto AS puesto,c.des_dep AS departamento,d.descr AS sucursal
                                      FROM trabajadores a
                                      LEFT JOIN cat_puestos b ON a.id_puesto=b.id_puesto
                                      LEFT JOIN deptos c ON a.id_depto=c.id_depto
                                      LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal 
                                      WHERE $departamentos AND c.inactivo=0  AND a.fecha_baja='0000-00-00'
                                      ORDER BY a.nombre ASC");*/

      //NJES Jan/07/2020  Se busca cualquier empleado de una unidad, la tabla trabajadores tiene el campo id_sucursal 
      //y si es el vinculo con la tabla sucursales
      //-->NJES Feb/10/2020 se obtiene el departamento y area del empleado
      $result = $this->link->query("SELECT a.cve_nom,a.cve_nom AS no_nomina,a.id_trabajador,a.iniciales,CONCAT(TRIM(a.nombre),' ',TRIM(a.apellido_p),' ',TRIM(a.apellido_m)) AS nombre,
                                    IFNULL(b.puesto,'') AS puesto,IFNULL(c.des_dep,'') AS departamento,IFNULL(d.descr,'') AS sucursal,
                                    c.id_depto,c.id_area
                                    FROM trabajadores a
                                    LEFT JOIN cat_puestos b ON a.id_puesto=b.id_puesto
                                    LEFT JOIN deptos c ON a.id_depto=c.id_depto
                                    LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal 
                                    LEFT JOIN  cat_unidades_negocio e ON d.id_unidad_negocio= e.id
                                    WHERE a.fecha_baja='0000-00-00'
                                    ORDER BY a.nombre ASC");                            

      return query2json($result);
    }


    /**
      * Busca los datos de una unidad de negocio, retorna un JSON con los datos correspondientes
      * 
      * @param int $id si id es 0 trae todos los registros, si no trae los datos de id requerido
      *  MGFS SE AGREGA LA CONDICION AND trabajadores.fecha_baja='0000-00-00' PARA QUE SOLO MUESTRE LOS ACTIVOS
      **/
      function buscarEmpleadosTodos($idEmpleado,$filtroId,$filtroNombre){

        $verifica=0;

          if($idEmpleado == 0 ){
            $codicionNombre="";
            $condicionId="";
            if($filtroId!=''){
              $condicionId="WHERE trabajadores.id_trabajador=".$filtroId;
            }
            if($filtroNombre!=''){
              $codicionNombre="WHERE CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)) LIKE '%$filtroNombre%'";
            }

            //-->NJES Jan/17/2020 Se busca el campo administrativo para saber si es operativo = 1 o administrativo = 2
            $query = "SELECT 
            trabajadores.id_trabajador,
            trabajadores.id_sup,
            trabajadores.administrativo,
            CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)) AS nombre,
            sucursales.descr AS sucursal,
            cat_unidades_negocio.nombre AS unidad_negocio
            FROM trabajadores 
            LEFT JOIN sucursales ON trabajadores.id_sucursal=sucursales.id_sucursal 
            LEFT JOIN cat_unidades_negocio ON sucursales.id_unidad_negocio = cat_unidades_negocio.id
            $condicionId $codicionNombre AND trabajadores.fecha_baja='0000-00-00'
            ORDER BY TRIM(trabajadores.nombre) ASC";

        }else{

          $query = "SELECT 
          trabajadores.id_trabajador,
          trabajadores.id_sup,
          CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)) AS nombre,
          sucursales.descr AS sucursal,
          cat_unidades_negocio.nombre AS unidad_negocio
          FROM trabajadores 
          LEFT JOIN sucursales ON trabajadores.id_sucursal=sucursales.id_sucursal 
          LEFT JOIN cat_unidades_negocio ON sucursales.id_unidad_negocio = cat_unidades_negocio.id
         WHERE trabajadores.id_trabajador=".$idEmpleado." AND trabajadores.fecha_baja='0000-00-00'
         ORDER BY trabajadores.nombre";
        
        }

        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if($result){
    
          $verifica = query2json($result);
        }

        return $verifica;
      }//- fin function buscarEmpleadosSupervisor

      /**
        * Busca los datos de un empleado
        * 
        * @param int $idEmpleado del empleado del que se quiere la información
        *
      **/
      function buscarEmpleadoId($idEmpleado){
        $result = $this->link->query("SELECT CONCAT(TRIM(a.nombre),' ',TRIM(a.apellido_p),' ',TRIM(a.apellido_m)) AS empleado,a.iniciales,a.direccion,
                                      a.colonia,c.municipio,b.estado,a.correo,a.telefono1 AS telefono
                                      FROM trabajadores a
                                      LEFT JOIN estados b ON a.cve_estado=b.id
                                      LEFT JOIN municipios c ON a.cve_municipio=c.id
                                      WHERE a.id_trabajador=".$idEmpleado);

        return query2json($result);
      }//- fin function buscarEmpleadoId

      function buscarEmpleadosIdsSucursales($idsSucursales,$modulo){     
        //-->NJES March/17/2020 si administrativo es 2 mostrar todos los empleados sin impotar unidad y sucursal,
        //si administrativ es 1 mostrar solo de las sucursales a las que tiene permiso el usuario logueado
        //-->NJES July/23/2020 si viene del modulo salida de uniformes, sin importar si es administrativo 1 o 2 
        //mostrar todos los empleados sin importar la unidad y sucursal

        

        if($idsSucursales != '')
        {
          $sucursales='';
          if($idsSucursales[0] == ',')
          {
            $sucursales=substr($idsSucursales,1);
          }

          if($modulo == 'S_DE_UNIFORMES')
            $condicion = '';
          else
            $condicion = 'AND IF(a.administrativo=2,a.administrativo=2,a.administrativo=1 AND a.id_sucursal IN('.$sucursales.'))';
          
          $result = $this->link->query("SELECT a.cve_nom,a.cve_nom AS no_nomina,a.id_trabajador,a.iniciales,CONCAT(TRIM(a.nombre),' ',TRIM(a.apellido_p),' ',TRIM(a.apellido_m)) AS nombre,
                                        IFNULL(b.puesto,'') AS puesto,IFNULL(c.des_dep,'') AS departamento,IFNULL(d.descr,'') AS sucursal,
                                        c.id_depto,c.id_area
                                        FROM trabajadores a
                                        LEFT JOIN cat_puestos b ON a.id_puesto=b.id_puesto
                                        LEFT JOIN deptos c ON a.id_depto=c.id_depto
                                        LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal 
                                        LEFT JOIN  cat_unidades_negocio e ON d.id_unidad_negocio= e.id
                                        WHERE a.fecha_baja='0000-00-00' $condicion 
                                        ORDER BY a.nombre ASC");                           
    
          return query2json($result);

        }else{
                
          $arr = array();
          $arr[] = '';
    
          return json_encode($arr);
        }
      }
    
}//--fin de class Empleados
    
?>