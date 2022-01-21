<?php

include 'conectar.php';

class Usuarios
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function Usuarios()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que el nombre en usuario no se repita
      *
      * @param varchar $usuario  usado para ingresar al sistema
      *
      **/
    function verificarUsuarios($rfc,$folioE01,$folioOc,$cveUnidad){

      $verifica = 0;

      //-- busco el id ed unidad de negocio que tenga la clave ingresada por el proveedor
      $queryU="SELECT id FROM cat_unidades_negocio WHERE clave='$cveUnidad'";
      $resultU = mysqli_query($this->link, $queryU)or die(mysqli_error());
      $rowU = mysqli_fetch_array($resultU);
      $idUnidad = $rowU['id'];

      //--- Verifico que exista la oc y entrada por compra ingresada por el proveedor y que no tenga registros de cxp pendientes de pago 
      $query = "SELECT 
      orden_compra.id_proveedor,
      orden_compra.folio AS folio_oc,
      IFNULL(almacen_e.folio,0) AS folio_E01,
      IFNULL(cxp.id,0) AS id_cxp
      FROM orden_compra
      LEFT JOIN almacen_e ON  orden_compra.id=almacen_e.id_oc AND almacen_e.id_proveedor=orden_compra.id_proveedor AND almacen_e.id_unidad_negocio=orden_compra.id_unidad_negocio AND almacen_e.folio=".$folioE01." 
      LEFT JOIN cxp ON almacen_e.id=cxp.id_entrada_compra AND orden_compra.id_unidad_negocio=cxp.id_unidad_negocio  AND cxp.estatus NOT IN('C','L')
      WHERE orden_compra.folio=".$folioOc." AND orden_compra.estatus!='C' AND orden_compra.id_unidad_negocio=".$idUnidad." AND orden_compra.id_proveedor=(SELECT id FROM proveedores WHERE rfc='$rfc' AND inactivo=0) 
      ORDER BY cxp.id ASC 
      LIMIT 1";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);
      
      
      if($num > 0){
        $row=mysqli_fetch_array($result);

        $NfolioE01 = $row['folio_E01'];
        $NfolioOc = $row['folio_oc'];
        $Nid_cxp = $row['id_cxp'];
         /**--- se hace la compracion si existe el folio oc y el folio e01 y no tiene cargo cxp se puede dar de alta 
                porque significa que tiene un moviemiento pendiente**/
        //echo  "if".$folioE01."==".$NfolioE01 ."&& ".$folioOc."==". $NfolioOc ."&&". $Nid_cxp."==0";
        if($folioE01==$NfolioE01 && $folioOc== $NfolioOc && $Nid_cxp==0){
          $verifica = $row['id_proveedor'];
        }else{
          $verifica = 0;
        }
       
      }else{
        $verifica = 0;
      }

       return $verifica;

    }//-- fin function verificaUsuarios

    /**
      * Manda llamar a la funcion que guarda la informacion sobre una unidad de negocio
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una unidad de negocio
      * @param varchar $nombre es el nombre asignado a una unidad de negocio
      * @param varchar $descripcion brebe descripcion de una unidad de negocio
      * @param varchar $logo es el logotipo que va a manejar la unidad de negocion en todos los formatos y modulos
      * @param int $inactivo estatus de una unidad de negocio 0='Activa' 1='Inactiva'  
      *
      **/      
    function guardarUsuarios($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarUsuarios


     /**
      * Guarda los datos de una unidad de negocio, regresa el id de la unidad de negocio afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $clave es una clave para identificar una unidad de negocio
      * @param varchar $nombre es el nombre asignado a una unidad de negocio
      * @param varchar $descripcion brebe descripcion de una unidad de negocio
      * @param varchar $logo es el logotipo que va a manejar la unidad de negocion en todos los formatos y modulos
      * @param int $inactivo estatus de una unidad de negocio 0='Activa' 1='Inactiva'  
      *
      **/ 
      function guardarActualizar($datos){
          
        $verifica = 0;

        $idProveedor = $datos[1]['idProveedor'];
        $idOc = $datos[1]['idOc'];
        $password = sha1($datos[1]['password']);

        $query = "UPDATE proveedores SET password='$password',id_orden_compra='$idOc' WHERE id=".$idProveedor;
        $result = mysqli_query($this->link, $query) or die(mysqli_error());

        if ($result) 
          $verifica = $idProveedor;  

        
        return $verifica;
    }


    
}//--fin de class Usuarios
    
?>