<?php

include 'conectar.php';

class Proveedores
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Proveedores()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el nombre en rfc no se repita
      *
      * @param varchar $rfc  usado para ingresar al sistema
      *
      **/
      function verificarProveedores($rfc){
      
        $verifica = 0;
  
        $query = "SELECT id FROM proveedores WHERE rfc = '$rfc'";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);
  
        if($num > 0)
          $verifica = 1;
  
         return $verifica;
  
      }//-- fin function verificaProveedores
  
      /**
        * Manda llamar a la funcion que guarda la informacion sobre una proveedor
        * @param array $datos todos los datos necesarios para dar de alta o actualizar un proveedor
        *
        **/      
      function guardarProveedores($datos){
      
          $verifica = 0;
  
         $this->link->begin_transaction();
         $this->link->query("START TRANSACTION;");
  
          $verifica = $this -> guardarActualizar($datos);
  
          if($verifica > 0)
              $this->link->query("commit;");
          else
              $this->link->query('rollback;');
  
          return $verifica;
  
      } //-- fin function guardarProveedores
  
  
       /**
        * Guarda los datos de una proveedor, regresa el id de la proveedor afectada si se realiza la accion correctamete ó 0 si ocurre algun error
        * 
        * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
        * @param int $idProveedor id del proveedor a generar si es nuevo es 0 si actualizacion debe ser mayor a 0
        * @param varchar $rfc es una rfc para identificar una proveedor
        * @param varchar $nombre es el nombre asignado a una proveedor
        * @param varchar $domicilio domicilio del proveedor
        * @param int $cp  Código Postal del provvedor
        * @param int  $inactivo estatus de una proveedor 0='Activo' 1='Inactivo'  
        *
        **/ 
        function guardarActualizar($datos){
            
          $verifica = 0;

          $tipo_mov = $datos[1]['tipo_mov'];
          $idProveedor = $datos[1]['idProveedor'];
          $nombre = $datos[1]['nombre'];
          $rfc = $datos[1]['rfc'];
          $domicilio = $datos[1]['domicilio'];
          $cp = $datos[1]['cp'];
          $colonia = $datos[1]['colonia'];
          $num_int = $datos[1]['numInt'];
          $num_ext = $datos[1]['numExt'];
          $facturable = $datos[1]['facturable'];
          $id_pais = $datos[1]['idPais'];
          $id_estado = $datos[1]['idEstado'];
          $id_municipio = $datos[1]['idMunicipio'];
          $id_bancoA = $datos[1]['idBancoAnterior'];
          $id_banco = $datos[1]['idBanco'];
          $cuentaA = $datos[1]['cuentaAnterior'];
          $cuenta = $datos[1]['cuenta'];
          $clabe = $datos[1]['clabe'];
          $clabeA = $datos[1]['clabeAnterior'];
          $diasCreditoA = $datos[1]['diasCreditoAnterior'];
          $diasCredito = $datos[1]['diasCredito'];
          $telefono = $datos[1]['telefono'];
          $extension = $datos[1]['extension'];
          $web = $datos[1]['web'];
          $contacto = $datos[1]['contacto'];
          $condiciones = $datos[1]['condiciones'];
          $grupo = $datos[1]['grupo'];
          $inactivo = $datos[1]['inactivo'];
          $idUsuario = $datos[1]['idUsuario'];
          $modulo = $datos[1]['modulo'];
         
  
          if($tipo_mov==0){
  
            $query = "INSERT INTO proveedores(nombre,rfc,domicilio,cp,colonia,num_int,num_ext,facturable,id_pais,id_estado,id_municipio,
            id_banco,cuenta,clabe,dias_credito,telefono,extension,web,contacto,condiciones,grupo,inactivo,id_usuario,modulo) VALUES 
            ('$nombre','$rfc','$domicilio','$cp','$colonia','$num_int','$num_ext','$facturable','$id_pais','$id_estado','$id_municipio',
            '$id_banco','$cuenta','$clabe','$diasCredito','$telefono','$extension','$web','$contacto','$condiciones','$grupo','$inactivo','$idUsuario','$modulo')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idProveedor = mysqli_insert_id($this->link);
  
          }else{
  
            $query = "UPDATE proveedores SET 
            nombre='$nombre',
            rfc='$rfc',
            domicilio='$domicilio',
            cp='$cp',
            colonia='$colonia',
            num_int='$num_int',
            num_ext='$num_ext',
            facturable='$facturable',
            id_pais='$id_pais',
            id_estado='$id_estado',
            id_municipio='$id_municipio',
            id_banco='$id_banco',
            cuenta='$cuenta',
            clabe='$clabe',
            dias_credito='$diasCredito',
            telefono='$telefono',
            extension='$extension',
            web='$web',
            contacto='$contacto',
            condiciones='$condiciones',
            grupo='$grupo',
            inactivo='$inactivo',
            id_usuario='$idUsuario',
            modulo='$modulo'
            WHERE id=".$idProveedor;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
      
          }
          
          if ($result){

            if( $tipo_mov== 1 && ($id_bancoA!=$id_banco || $cuentaA!=$cuenta || $diasCreditoA!=$diasCredito || $clabe!=$clabeA)){

                $verifica = $this -> enviaCorreoCambios($idProveedor, $nombre, $rfc, $id_bancoA, $id_banco, $cuentaA, $cuenta, $diasCreditoA, $diasCredito, $clabeA, $clabe);

            }else{

              $verifica = $idProveedor;  
            }
               
          }else{
            $verifica = 0;
          }

           
  
          
          return $verifica;
      }
  

    /**
      * Busca los datos de proveedores, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos
      *
      **/
    function buscarProveedores($estatus){
      
        $condicion='';
        if( $estatus == 0 )
        {
            $condicion=' WHERE inactivo=0 ';
        }else if( $estatus == 1 ){
            $condicion=' WHERE inactivo=1 ';
        }else{
            $condicion='';
        }
        
        $result1 = $this->link->query("SELECT proveedores.id,proveedores.nombre,proveedores.rfc,proveedores.grupo,usuarios.nombre_comp AS usuario
        FROM proveedores
        LEFT JOIN usuarios ON proveedores.id_usuario=usuarios.id_usuario
        $condicion 
        ORDER BY proveedores.nombre DESC");
    
        return query2json($result1);
    }//-- fin function buscarProveedores

    

    function buscarProveedoresUnidad($idUnidad)
    {

      // print_r($_SESSION);
      // exit();

      $query = "SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc 
                FROM proveedores
                INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
                WHERE proveedores.inactivo = 0 AND proveedores_unidades.id_unidad = $idUnidad
                ORDER BY  proveedores.nombre";

      // echo $query;
      // exit();

      $resultP = $this->link->query($query);

      return query2json($resultP);

    }

    /**
      * Busca los datos de proveedores, retorna un JSON con los datos correspondientes
      * 
      * @param int $idProveedor del registro que esta buscando
      *
      **/
    function buscarProveedoresId($idProveedor){
      
        $result = $this->link->query("SELECT 
        a.id,
        a.nombre,
        a.rfc,
        a.domicilio,
        a.cp,
        a.colonia,
        a.num_int,
        a.num_ext,
        a.facturable,
        a.id_pais,
        a.id_estado,
        a.id_municipio,
        a.id_banco,
        a.cuenta,
        a.clabe,
        a.dias_credito,
        a.telefono,
        a.extension,
        a.web,
        a.contacto,
        a.condiciones,
        a.grupo,
        a.inactivo,
        a.id_usuario,
        a.modulo,
        b.municipio,
        c.estado,
        d.pais,
        e.descripcion AS banco                                        
        FROM proveedores a
        LEFT JOIN municipios b ON a.id_municipio=b.id
        LEFT JOIN estados c ON a.id_estado=c.id
        LEFT JOIN paises d ON a.id_pais=d.id
        LEFT JOIN bancos e ON a.id_banco=e.id
        WHERE a.id=".$idProveedor);
    
        return query2json($result);
    }//-- fin function buscarProveedoresId


        /**
      * Busca los datos de proveedores se de dieron de alta en el modulo de gastos, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos

      *
      **/
      function buscarProveedoresGastos($estatus){
      
        $condicion='';
        if( $estatus == 0 )
        {
            $condicion=' AND inactivo=0 AND modulo="G" ';
        }else if( $estatus == 1 ){
            $condicion=' AND inactivo=1 AND modulo="G" ';
        }else{
            $condicion='';
        }
        
        $result1 = $this->link->query("SELECT proveedores.id,proveedores.nombre,proveedores.rfc,proveedores.grupo,usuarios.nombre_comp AS usuario
        FROM proveedores
        LEFT JOIN usuarios ON proveedores.id_usuario=usuarios.id_usuario
        WHERE proveedores.modulo='G' $condicion 
        ORDER BY proveedores.id DESC");
    
        return query2json($result1);
    }//-- fin function buscarProveedores


      /** 
      * Se envia un correo si se actualizan banco, cuenta o dias de credito  
      * A los correos correspondientes ingresados en el modulo correos_info_proveedor
      *
      * @param int $idProveedor 
      * @param array de datos
      *
      **/
      function enviaCorreoCambios($idProveedor, $nombre, $rfc, $id_bancoA, $id_banco, $cuentaA, $cuenta, $diasCreditoA, $diasCredito, $clabeA, $clabe){
        
        include_once("../vendor/lib_mail/class.phpmailer.php");
        include_once("../vendor/lib_mail/class.smtp.php");
  
        $verifica = '';
  
     
        $busca_datos="SELECT a.correos,b.descripcion AS bancoA, c.descripcion AS banco 
        FROM correos_info_proveedores a
        LEFT JOIN bancos b ON b.id=".$id_bancoA."
        LEFT JOIN bancos c ON c.id=".$id_banco."
        WHERE a.id=1";
        $result = mysqli_query($this->link, $busca_datos)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
        {
          $row = mysqli_fetch_array($result);
          $correos = $row['correos'];
          $bancoA = $row['bancoA'];
          $banco = $row['banco'];

          $fecha = date('Y').''.date('m').''.date('d');

          $dest_mail = $correos;//'ne@denken.mx,mh@denken.mx,soporte@denken.mx';
          $destinatarios = explode(',',$dest_mail);
  
          $asunto = 'Cambios en Proveedor';
  
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
          $mail->SetFrom("noreply@denken.mx",$asunto);
          
          $mail->Subject = $asunto;
  
          $mensaje = '<html><body>';
          $mensaje .= '<p>Se te notifica que el proveedor: '.$nombre.' con RFC: '.$rfc.' modificó algunos de sus datos:</p>';
          $mensaje .= '<table border="0" style="border: 1px solid #333;">';
            $mensaje .= '<tr style="border: 1px solid #333; background-color: #002699;color: white;"><td></td><td><strong>Original</strong></td><td><strong>Nuevo</strong></td></tr>';
            $mensaje .= '<tr><td><strong>Banco</strong></td><td>'.$id_bancoA.' - '.$bancoA.'</td><td>'.$id_banco.' - '.$banco.'</td></tr>';
            $mensaje .= '<tr style="background-color: #f5f5f5;"><td><strong>Cuenta</strong></td><td>'.$cuentaA.'</td><td>'.$cuenta.'</td></tr>';
            $mensaje .= '<tr><td><strong>Dias Credito</strong></td><td>'.$diasCreditoA.'</td><td>'.$diasCredito.'</td></tr>';
            $mensaje .= '<tr style="background-color: #f5f5f5;"><td><strong>Clabe</strong></td><td>'.$clabeA.'</td><td>'.$clabe.'</td></tr>';
            $mensaje .= '</table>';
        
          $mensaje .= '</body></html>';
        
          $mail->MsgHTML($mensaje);
  
          for($i = 0; $i < count($destinatarios); $i++)
          {
              $mail->AddAddress($destinatarios[$i], $asunto);	
          }
  
          
          if(!$mail->Send()){
              //Error al enviar
              $verifica = 0;// 'Error al enviar';
          }else{
              //Datos Enviados
              $verifica = 1;//'Se enviaron los datos correctamente';
          }

        }else{
          $verifica = 0;//'No hay destinatarios';
        }
       
        
        return $verifica;
      }//--fin function enviarNotificacionPorcentajeUtilidad

}//--fin de class Proveedores
    
?>