<?php

include 'conectar.php';

class DashGastos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function DashGastos()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los registros de dash gastos segun el tipo de informacion que se requiere
      * 
      * @param varchar $datos array que contiene los datos para la busqueda
      * idUnidadNegocio
      * idSucursal
      * idDepartamento
      * tipo    1=registros dash  2=registros departamento    3=registros gastos
      *
    **/
    function buscarDashGastos($datos){

        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idDepartamento = isset($datos['idDepartamento']) ? $datos['idDepartamento'] : 0;
        $fecha = isset($datos['fecha']) ? $datos['fecha'] : '';
        $tipo = $datos['tipo'];

        $unidad='';
        $sucursal='';
        $departamento='';

        if($idSucursal != '')
        {
            if($idUnidadNegocio != '')
            {
                if($idUnidadNegocio[0] == ',')
                {
                    $dato=substr($idUnidadNegocio,1);
                    $unidad = ' AND a.id_unidad_negocio IN('.$dato.') ';
                }else{ 
                    $unidad = ' AND a.id_unidad_negocio ='.$idUnidadNegocio;
                }
            }

            if($idSucursal[0] == ',')
            {
              $dato=substr($idSucursal,1);
              $sucursal = ' AND a.id_sucursal IN('.$dato.') ';
            }else{ 
              $sucursal = ' AND a.id_sucursal ='.$idSucursal;
            }
        
            $departamento = ' AND a.id_departamento ='.$idDepartamento;
            

            if($fecha != '')
            {
                $condFecha = " AND MONTH(b.fecha) = MONTH('$fecha') AND YEAR(b.fecha) = YEAR('$fecha')";
            }
            
            if($tipo == 1)
            {
                $query = "SELECT b.fecha AS fecha_c,MONTH(b.fecha) AS mes,YEAR(b.fecha) AS anio,
                            CONCAT(IF(MONTH(b.fecha) < 10,CONCAT('0',MONTH(b.fecha)),MONTH(b.fecha)),'-',YEAR(b.fecha)) AS fecha,
                            SUM(a.monto) AS total,
                            IF(b.fecha_referencia='0000-00-00','',b.fecha_referencia)AS fecha_referencia,IFNULL(b.referencia,'') AS referencia
                            FROM movimientos_presupuesto a
                            LEFT JOIN gastos b ON a.id_gasto=b.id
                            WHERE 1 $unidad $sucursal AND a.tipo='C' AND a.estatus='A' AND !ISNULL(b.fecha) 
                            GROUP BY YEAR(b.fecha),MONTH(b.fecha)
                            ORDER BY YEAR(b.fecha) DESC,MONTH(b.fecha) DESC";

                $result = $this->link->query($query);
               
            }else if($tipo == 2)
            {
                $query = "SELECT a.id_departamento,a.id_unidad_negocio,a.id_sucursal,IFNULL(c.nombre,'') AS unidad_negocio,
                            IFNULL(d.descr,'') AS sucursal,IFNULL(e.descripcion,'') AS area, 
                            IFNULL(f.des_dep,'') AS departamento,SUM(a.monto) AS total,
                            IF(b.fecha_referencia='0000-00-00','',b.fecha_referencia) AS fecha_referencia,IFNULL(b.referencia,'') AS referencia
                            FROM movimientos_presupuesto a
                            LEFT JOIN gastos b ON a.id_gasto=b.id
                            LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
                            LEFT JOIN sucursales d ON a.id_sucursal=d.id_sucursal
                            LEFT JOIN cat_areas e ON a.id_area=e.id
                            LEFT JOIN deptos f ON a.id_departamento=f.id_depto
                            WHERE 1 $unidad $sucursal $condFecha AND a.tipo='C' AND a.estatus='A' AND !ISNULL(b.fecha)
                            GROUP BY a.id_departamento 
                            ORDER BY c.nombre,d.descr,f.des_dep";

                $result = $this->link->query($query);
                           
            }else{
                $query = "SELECT IFNULL(b.concepto,'') AS descripcion,IFNULL(e.nombre,'') AS proveedor,IFNULL(c.descr,'') AS familia,
                            IFNULL(d.descr,'') AS clasificacion,b.fecha,(a.monto) AS importe,
                            IF(b.fecha_referencia='0000-00-00','',b.fecha_referencia)AS fecha_referencia,IFNULL(b.referencia,'') AS referencia
                            FROM movimientos_presupuesto a 
                            LEFT JOIN gastos b ON a.id_gasto=b.id
                            LEFT JOIN fam_gastos c ON a.id_familia_gasto=c.id_fam
                            LEFT JOIN gastos_clasificacion d ON a.id_clasificacion=d.id_clas
                            LEFT JOIN proveedores e ON b.id_proveedor = e.id
                            WHERE 1 $unidad $sucursal $condFecha $departamento AND a.tipo='C' AND a.estatus='A' AND !ISNULL(b.fecha)
                            ORDER BY b.fecha DESC";

                $result = $this->link->query($query);
            }
            return query2json($result);
        }else{
            
            $arr = array();
            $arr[] = '';

            return json_encode($arr);
        }
    }//- fin function buscarDashGastos
    
}//--fin de class DashGastos
    
?>