<?php

include 'conectar.php';

class CodigoPostal
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function CodigoPostal()
    {
  
      $this->link = Conectarse();

    }

  

    /**
      * Busca los datos de CodigoPostal, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos
      *
      **/
    function buscarCodigoPostal($idEstado,$idMunicipio){
      
        $condicion='';
        
        if( $idEstado > 0 ){
            $condicion.=' AND a.id_estado='.$idEstado;
        }

        if( $idMunicipio > 0 ){
           $condicion.=' AND a.id_municipio='.$idMunicipio;
        }

       
        $result1 = $this->link->query("SELECT  a.id_colonia,a.codigo_postal,a.id_estado,a.id_municipio,b.estado,c.municipio,a.colonia
        FROM codigos_postales a
        LEFT JOIN estados b ON a.id_estado=b.id
        LEFT JOIN municipios c ON a.id_municipio=c.id
        WHERE 1=1 $condicion
        ORDER BY b.estado,a.codigo_postal");
    
        return query2json($result1);
    }//-- fin function buscarCodigoPostal

    /**
      * Busca los datos de CodigoPostal, retorna un JSON con los datos correspondientes
      * 
      * @param int $idProveedor del registro que esta buscando
      *
      **/
    function buscarCodigoPostalId($idColonia){
        $result = $this->link->query("SELECT a.id_colonia,a.codigo_postal,a.id_estado,a.id_municipio,b.estado,c.municipio,colonia
        FROM codigos_postales a
        LEFT JOIN estados b ON a.id_estado=b.id
        LEFT JOIN municipios c ON a.id_municipio=c.id
        WHERE id_colonia=".$idColonia."
        ORDER BY estado,codigo_postal");
    
        return query2json($result);
    }//-- fin function buscarCodigoPostalId

}//--fin de class CodigoPostal
    
?>