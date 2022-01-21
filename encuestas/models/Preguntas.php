<?php

include 'conectar.php';

class Preguntas
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Preguntas()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los registros de tabla preguntas, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus como filtro de busqueda 1=activos 0=inactivas 2=todos
      *
    **/
    function buscarPreguntas($estatus){

        if($estatus == 1)
          $condicionEstatus = ' WHERE activa=1';
        else if($estatus == 0)
          $condicionEstatus = ' WHERE activa=0';
        else
            $condicionEstatus = '';

        $result = $this->link->query("SELECT id,pregunta,fecha_captura,fecha_inactivacion,activa
                                      FROM preguntas $condicionEstatus
                                      ORDER BY id ASC");
        return query2json($result);

    }//- fin function buscarPreguntas

    /**
      * Busca los datos de un registro es especifico
      * 
      * @param int $idPregunta del registro que se esta buscando
      *
    **/
    function buscarPreguntaId($idPregunta){
        $resultado = $this->link->query("SELECT id,pregunta,fecha_captura,fecha_inactivacion,activa
                                        FROM preguntas 
                                        WHERE id=".$idPregunta);
        return query2json($resultado);
    }//- fin function buscarPreguntaId

    /**
      * Inserta/Actualiza registro
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarPregunta($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");
 
        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("COMMIT;");
        else
            $this->link->query('ROLLBACK;');

        return $verifica;
    }//- fin function guardarPregunta

    /**
      * Inserta/Actualiza registro
      * 
      * @param varchar $datos array que contiene los datos a guardar
      *
    **/
    function guardarActualizar($datos){
          
        $verifica = 0;

        $idPregunta = $datos['idPregunta'];
        $tipo_mov = $datos['tipo_mov'];
        $pregunta = $datos['pregunta'];
        $activa = $datos['activa'];
        $idUsuario = $datos['idUsuario'];

        if($activa == 0)
            $fecha_inactivacion = 'fecha_inactivacion=CURDATE()';
        else
            $fecha_inactivacion = 'fecha_inactivacion="0000-00-00"';

        if($tipo_mov==0)
        {

            $query = "INSERT INTO preguntas(pregunta,activa,id_usuario) 
                        VALUES ('$pregunta','$activa','$idUsuario')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idPregunta = mysqli_insert_id($this->link);

        }else{

            $query = "UPDATE preguntas 
                        SET pregunta='$pregunta',activa='$activa',$fecha_inactivacion,id_usuario='$idUsuario' 
                        WHERE id=".$idPregunta;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if($result) 
            $verifica = $idPregunta;  

        
        return $verifica;
    }//- fin function guardarActualizar
    
}//--fin de class Preguntas
    
?>