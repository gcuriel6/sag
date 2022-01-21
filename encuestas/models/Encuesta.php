<?php

include 'conectar.php';

class Encuesta
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Encuesta()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Inserta/Actualiza registro
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarRespuestaPregunta($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");
 
        $verifica = $this -> guardarRespuesta($datos);

        if($verifica > 0)
            $this->link->query("COMMIT;");
        else
            $this->link->query('ROLLBACK;');

        return $verifica;
    }//- fin function guardarRespuestaPregunta

    /**
      * Inserta/Actualiza registro
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarRespuesta($datos){
          
        $verifica = 0;

        $idPregunta = $datos['idPregunta'];
        $respuesta = $datos['respuesta'];
        $idServicio = $datos['idServicio'];

        $query = "INSERT INTO encuestas_d(id_orden_servicio,id_pregunta,respuesta) 
                    VALUES ('$idServicio','$idPregunta','$respuesta')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        
        if($result) 
            $verifica = 1;  

        
        return $verifica;
    }//- fin function guardarRespuesta


    /**
      * Busca los registros de tabla preguntas, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus como filtro de busqueda 1=activos 0=inactivas 2=todos
      *
    **/
    function buscaEncuestaServicio($id){

      $query="SELECT id FROM encuestas_d WHERE id_orden_servicio=".$id;
      $result=mysqli_query($this->link,$query);
      $numsR=mysqli_num_rows($result);
      
      return $numsR;
  }//- fin function buscarPreguntas

    
}//--fin de class Encuesta
    
?>