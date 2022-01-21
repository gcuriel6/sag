<?php

include 'conectar.php';

class Autorizaciones
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Autorizaciones()
    {
  
      $this->link = Conectarse();

    }

  
    
    /**
      * Busca los datos de una area, retorna un JSON con los datos correspondientes
      * 
      * @param int $activo indica el estatus que debe tener el registro 1=activo 0=inactivo 2=todos
      *
      **/
      function buscarAutorizar($idsUnidades){

        $resultado = $this->link->query("SELECT a.id AS folio,a.descripcion,a.total,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'No Autorizada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar','Pagada'))))) AS estatus,b.nombre AS unidad_negocio,c.clave AS clave_suc,c.descripcion AS sucursal
        FROM requisiciones a
        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
        WHERE a.id_unidad_negocio IN ($idsUnidades) ORDER BY a.id desc");
        return query2json($resultado);

      }//- fin function buscarAutorizacion


    
}//--fin de class AsignacionAutorizacion
    
?>