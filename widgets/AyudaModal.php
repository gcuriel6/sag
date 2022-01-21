<?php

include 'conectar.php';

class AyudaModal
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function AyudaModal()
    {
  
      $this->link = Conectarse();

    }

    /**
       * Busca los botones activos de una forma
       * @param varchar $pantalla nombre de la forma 
       * 
    **/
    function buscarBotonAyudaForma($pantalla){
        $result = $this->link->query("SELECT id_registro,boton FROM ayuda_modal WHERE pantalla = '$pantalla' AND activo=0");
        return query2json($result);
    }//-- fin function buscarBotonAyudaForma

  /**
    * Busca el texto de una forma y boton
    * @param varchar $pantalla nombre de la forma
    * @param varchar $boton nombre del boton
    *
  **/
  function buscarTextoAyudaForma($pantalla,$boton){ 
    
    $result = $this->link->query("SELECT id_registro,pantalla,boton,IFNULL(texto,'') AS texto FROM ayuda_modal WHERE pantalla = '$pantalla' AND boton='$boton' AND activo=0");
    return query2json($result);

  }//-- fin function buscarTextoAyudaForma

    
}//--fin de class AyudaModal
    
?>