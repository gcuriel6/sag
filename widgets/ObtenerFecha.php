<?php

include 'conectar.php';

class ObtenerFecha
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function __construct()
    {
  
      $this->link = Conectarse();

    }


    function obtenerFechaDia($dia){
        if($dia=='hoy')
        {
          $query="SELECT CURDATE() as fecha";
        }else if($dia=='ayer')
        {
          $query="SELECT DATE_SUB(CURDATE(),INTERVAL 1 DAY) as fecha";
        }else if($dia=='primerDiaMes'){
          $query="SELECT DATE_FORMAT(CURDATE(), '%Y-%m-01') as fecha";
        }else{
          $query="SELECT LAST_DAY(CURDATE()) as fecha";
        }

        $resultado = mysqli_query($this->link ,$query);
        $dato = mysqli_fetch_array($resultado);
        return $dato['fecha'];
    }//- fin function buscarObtenerFechaId


}//--fin de class ObtenerFecha
    
?>