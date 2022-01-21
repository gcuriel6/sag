<?php

include 'conectar.php';

class Motivos
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Motivos()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los registros de la tabla motivos, retorna un JSON con los datos correspondientes
      **/
    function buscarMotivos(){
      
      $result1 = $this->link->query("SELECT id_motivo,clave,descr FROM motivos ORDER BY id_motivo");

      return query2json($result1);
    }//-- fin function buscarMotivos

    /**
      * Busca los registros de la tabla motivos de una sucursal, retorna un JSON con los datos correspondientes
      * @param int $idSucursal para buscar los importes del campos
      * @param int $idUnidadNegocio para buscar los importes del campos
      *
      **/
    function buscarMotivosIdSucursal($idSucursal){
    
      $result1 = $this->link->query("SELECT id_motivo,clave,descr,importe_".$idSucursal." AS importe FROM motivos ORDER BY id_motivo");
      
      return query2json($result1);
    }//-- fin function buscarMotivosIdSucursal

    /**
      * Busca las sucursales que se han registrado en motivos de una unidad de negocio
      **/
    function buscarMotivosOpcionesSucursales($idUnidadNegocio){

      $result1 = $this->link->query("SELECT a.id_sucursal,a.descr FROM sucursales a
                                      LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id 
                                      WHERE a.id_sucursal IN (SELECT DISTINCT(SUBSTRING_INDEX(COLUMN_NAME ,'_', -1)) AS id_suc
                                      FROM information_schema.columns 
                                      WHERE table_schema='ginthercorp' AND TABLE_NAME = 'motivos'  AND COLUMN_NAME LIKE '%importe%')
                                      AND a.id_unidad_negocio=".$idUnidadNegocio." ORDER BY a.descr");

      return query2json($result1);
    }

    /**
      * Busca los importes de la referencia sucursal seleccionada
      * @param int $id_referencia para buscar los importes del campos
      * @param int $idUnidadNegocio para buscar los importes del campos
      *
      **/
    function buscarMotivosImportesReferencia($id_referencia,$idUnidadNegocio){

      $result = $this->link->query("SELECT id_motivo,importe_".$id_referencia." AS importe FROM motivos ORDER BY id_motivo");

      return query2json($result);
    }
    
    /**
      * Solicita por correo electronico se den de alta nuevos campos y registros en motivos
      *
      * @param varchar $datos_importe es un array con los datos de motivos
      * id_motivo
      * clave
      * descripcion
      * importe
      * @param int $idSucursal de la sucural para construir los nuevos campos ej. "importe_1"
      * @param int $idUnidadNegocio de la unidad de negocio para contruir los nuevos campos ej. "importe_1"
      * @param varchar $sucursal nombre de la sucursal
      * @param varchar $unidad nombre de la unidad
      *
      **/
    function solicitarMotivos($datos,$idSucursal,$sucursal){
      include_once("../vendor/lib_mail/class.phpmailer.php");
      include_once("../vendor/lib_mail/class.smtp.php");
      
      $dest_mail = 'sistemas@secorp.mx, sistemas1@secorp.mx, desarrollo@secorp.mx';
      $destinatarios = explode(',',$dest_mail);

      $mensaje='<html><body>';
      $mensaje.='<h3>Solicitud Montos Nómina</h3>';
      $mensaje.='<p>Se solicita se den de alta nuevos campos para nomina</p>';
      //$mensaje.='<p><b>Id unidad negocio: '.$idUnidadNegocio.'</b></p>';
      //$mensaje.='<p><b>Nombre unidad: '.$unidad.'</b></p>';
      $mensaje.='<p><b>Id sucursal: '.$idSucursal.'</b></p>';
      $mensaje.='<p><b>Nombre sucursal: '.$sucursal.'</b></p>';
      $mensaje.='<p><b>Campo: importe_'.$idSucursal.'</b></p>';
      $mensaje.='<table border=1>';
      $mensaje.='<thead><tr><th>ID</th><th>CLAVE</th><th>DESCRIPCIÓN</th><th>IMPORTE</th></tr></thead>';
      $mensaje.='<tbody>';
      foreach($datos as $d){

        $id_motivo=$d['id_motivo'];
        $clave=$d['clave'];
        $descripcion=$d['descripcion'];
        $importe=$d['importe'];

        $mensaje.='<tr><td>'.$id_motivo.'</td><td>'.$clave.'</td><td>'.$descripcion.'</td><td>'.$importe.'</td></tr>';
    
      }
      $mensaje.='</tbody></table>';
      $mensaje.='</body></html>';

      $asunto ='Solicitud Montos Nomina';
      $mail = new PHPMailer();
      $mail->CharSet = 'UTF-8';
      $mail->IsSMTP();
      $mail->IsHTML(true);	
      $mail->SMTPSecure = "TLS";	
      $mail->SMTPAuth = true;
      
      $mail->Host = "denken.mx";
      $mail->Port = 26;
      $mail->Username = "noreply@denken.mx";
      $mail->Password = "Martinika8%#";
      
      $mail->SetFrom("noreply@denken.mx","Solicitud Montos Nomina");
      
      $mail->Subject = $asunto;
      $mail->MsgHTML($mensaje);

      for($i = 0; $i < count($destinatarios); $i++)
      {
        $mail->AddAddress($destinatarios[$i]);
      }

      if(!$mail->Send()){
        echo 0;  //error
      }else{
        echo 1;  //exito
      }

    }//-- fin function solicitarMotivos
    
}//--fin de class Motivos
    
?>