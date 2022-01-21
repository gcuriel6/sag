<?php

include 'conectar.php';

class CuentasBancos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function CuentasBancos()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el nombre en cuenta no se repita
      *
      * @param varchar $cuenta  usado para ingresar al sistema
      *
      **/
    function verificarCuentasBancos($cuenta){
      
      $verifica = 0;

      $query = "SELECT id FROM cuentas_bancos WHERE cuenta = '$cuenta'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

       return $verifica;

    }//-- fin function verificaCuentasBancos

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una linea
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $cuenta es una cuenta para identificar una linea
      * @param varchar $nombre es el nombre asignado a una linea
      * @param varchar $descripcion brebe descripcion de una linea
      * @param int $idBanco  id de la familia a la que se va asignar
      * @param int $activa estatus de una linea 0='Activa' 1='activa'  
      *
      **/      
    function guardarCuentasBancos($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarCuentasBancos


     /**
      * Guarda los datos de una linea, regresa el id de la linea afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $cuenta es una cuenta para identificar una linea
      * @param varchar $nombre es el nombre asignado a una linea
      * @param varchar $descripcion brebe descripcion de una linea
      * @param int $idBanco  id de la familia a la que se va asignar
      * @param int $activa estatus de una linea 0='Activa' 1='activa'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idCuentaBanco = $datos[1]['idCuentaBanco'];
        $tipoMov = $datos[1]['tipoMov'];
        $idUnidadNegocio = $datos[1]['idUnidadNegocio'];
        $cuenta = $datos[1]['cuenta'];
        $descripcion = $datos[1]['descripcion'];
        $idBanco = $datos[1]['idBanco'];
        $activa = $datos[1]['activa'];
        $tipoCuenta = $datos[1]['tipoCuenta'];
        $idSucursal = $datos[1]['idSucursal'];

        if($tipoMov==0){

          $query = "INSERT INTO cuentas_bancos(cuenta,descripcion,id_banco,id_unidad_negocio,activa,tipo,id_sucursal) VALUES ('$cuenta','$descripcion','$idBanco','$idUnidadNegocio','$activa','$tipoCuenta','$idSucursal')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idCuentaBanco = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cuentas_bancos SET cuenta='$cuenta',descripcion='$descripcion',id_banco='$idBanco',activa='$activa', id_unidad_negocio='$idUnidadNegocio',tipo='$tipoCuenta',id_sucursal='$idSucursal' WHERE id=".$idCuentaBanco;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $idCuentaBanco;  

        
        return $verifica;
    }

    
    /**
      * Busca los datos de una linea, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=activas 2=todos
      *
      **/
      function buscarCuentasBancos($estatus){

        $condicionEstatus='';

        if($estatus==1){
          $condicionEstatus=' WHERE a.activa=1';
        }
        if($estatus==0){
          $condicionEstatus=' WHERE a.activa=0';
        }

        $resultado = $this->link->query("SELECT a.id as id,a.cuenta,a.descripcion as descripcion,a.id_unidad_negocio,IF(a.tipo=1,'CAJA CHICA',b.descripcion) AS banco,a.activa,c.nombre as unidad_negocio
        FROM cuentas_bancos a
        LEFT JOIN bancos b ON a.id_banco=b.id
        LEFT JOIN cat_unidades_negocio c ON a.id_unidad_negocio=c.id
        $condicionEstatus
        ORDER BY a.descripcion desc");
        return query2json($resultado);

      }//- fin function buscarCuentasBancos

      function buscarCuentasBancosId($idCuentaBanco){
        
           $resultado = $this->link->query("SELECT a.id,a.cuenta,a.descripcion,a.id_banco,a.activa,a.id_unidad_negocio,b.clave,IF(a.tipo=1,'CAJA CHICA',b.descripcion) AS banco,a.tipo,a.id_sucursal
           FROM cuentas_bancos a
           LEFT JOIN bancos b ON a.id_banco=b.id
WHERE a.id=$idCuentaBanco
ORDER BY a.descripcion desc");
           return query2json($resultado);
          

      }//- fin function buscarCuentasBancosId

    /**
     * Busca las CuentasBancos activas que pertenecen a una familia
     * @param int $idBanco
     * 
    **/
    function buscarCuentasBancosidBanco($idBanco){
        $result = $this->link->query("SELECT a.id,a.cuenta,a.descripcion,IF(a.tipo=1,'CAJA CHICA',b.descripcion) AS banco,if(a.activa=1,'ACTIVA','INACTIVA')AS estatus
        FROM cuentas_bancos a
        LEFT JOIN bancos b ON a.id_banco=b.id
        WHERE a.id_banco=$idBanco 
        ORDER BY a.descripcion DESC");
        
        return query2json($result);
    }//- fin function buscarCuentasBancosidBanco
    

     /**
     * Busca las CuentasBancos activas que pertenecen a una familia
     * @param int $idBanco
     * 
    **/
    function buscarCuentasBancosidUnidadNegocio($idUnidadNegocio){

      $result = $this->link->query("SELECT a.id,a.cuenta,a.descripcion,IF(a.tipo=1,'CAJA CHICA',b.descripcion) AS banco,if(a.activa=1,'ACTIVA','INACTIVA')AS estatus
      FROM cuentas_bancos a
      LEFT JOIN bancos b ON a.id_banco=b.id
      WHERE a.id_unidad_negocio=".$idUnidadNegocio." 
      ORDER BY a.descripcion DESC");
      
      return query2json($result);
  }//- fin function buscarCuentasBancosidUnidadNegocio

  function verificarCuentaCajaChicaSucursal($idSucursal){
    $verifica = 0;

    $query = "SELECT id FROM cuentas_bancos WHERE id_sucursal = $idSucursal  AND activa=1 AND tipo=1";
    $result = mysqli_query($this->link, $query)or die(mysqli_error());
    $num = mysqli_num_rows($result);

    if($num > 0)
      $verifica = 1;

    return $verifica;
  }//- fin function buscarCuentasBancosidUnidadNegocio

}//--fin de class CuentasBancos
    
?>