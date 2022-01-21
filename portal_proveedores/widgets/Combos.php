<?php

include 'conectar.php';

class Combos
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Combos()
    {
  
      $this->link = Conectarse();

    }

  /**
   * Obtiene los registros de cat_paises para generar combo 
  **/
  function buscarPaises(){

    $result1 = $this->link->query("SELECT id,codigo3,pais FROM paises WHERE mostrar=1 ORDER BY id");
    return query2json($result1);

  }//-- fin function buscarPaises

  /**
   * Obtiene los registros de cat_paises para generar combo 
  **/
  function buscarEstados(){

    $result1 = $this->link->query("SELECT id,estado FROM estados ORDER BY id");
    return query2json($result1);

  }//-- fin function buscarEstados

  /**
   * Obtiene los registros de cat_paises para generar combo 
   * @param int $idEstado dato que indica que solo se buscaran los municipios que pertenecen a ese $idEstado
  **/
  function buscarMunicipios($idEstado){

    if($idEstado == 0)
    {

      $result1 = $this->link->query("SELECT id,municipio FROM municipios ORDER BY id");
      return query2json($result1);

    }else{

      $result1 = $this->link->query("SELECT id,municipio FROM municipios WHERE id_estado=".$idEstado);
      return query2json($result1);

    } 

  }//-- fin function buscarMunicipios

    
}//--fin de class Combos
    
?>