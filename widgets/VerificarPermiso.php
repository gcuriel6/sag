<?php

//include 'conectar.php';
require_once('conectar.php');

class VerificarPermiso
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function VerificarPermiso()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Obtiene las sucursales a las que se puede aceder de una unidad de negocio un usuario especifico
      *
      * @param int $idUnidadNegocio dato que dice en que unidad de negocio se encuentra actialmente
      * @param varchar $modulo solo para indicar de modulo se quiere obtener el permiso
      * @param int $idUsuario usuario logueado actualmente
      *
    **/
    function buscarPermisosBotones($idUsuario,$boton,$idBoton,$idSucursal,$idUnidadNegocio){
      
      $verifica = 0;

      $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$boton' ORDER BY orden";
      $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
      $num = mysqli_num_rows($resultM);

      if($num > 0){

        $rowsM = $resultM->fetch_assoc();
        $pantallaM=$rowsM['sistema'];
        $permisoForma=$rowsM['comando'];


        $queryP = "SELECT permisos.id_sucursal,permisos.permiso,sucursales.descr as nombre 
                        FROM permisos 
                        LEFT JOIN sucursales ON permisos.id_sucursal=sucursales.id_sucursal
                        WHERE permisos.id_unidad_negocio = $idUnidadNegocio 
                        AND permisos.id_usuario=$idUsuario AND permisos.pantalla='$pantallaM' 
                        AND permisos.id_sucursal=$idSucursal
                        AND sucursales.activo=1
                        ORDER BY sucursales.descr";
        $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
        $numP = mysqli_num_rows($resultP);

        if($numP > 0){

          $cont=0;
          while($row = $resultP->fetch_assoc()){

             $permisoUsuario=$row['permiso'];
             if($this -> checaBit($permisoForma,$permisoUsuario)){
                $verifica = 1;
             }else{
                $verifica = 0;
             }
           
          }
          
      }else{
        
          $verifica = 0;
      }

    }else{
      
      $verifica = 0;
    }

    return $verifica;

  }//-- fin function buscarPermisosSucursal


  
    /**
      * Obtiene las sucursales a las que se puede aceder de una unidad de negocio un usuario especifico
      *
      * @param int $idUnidadNegocio dato que dice en que unidad de negocio se encuentra actialmente
      * @param varchar $modulo solo para indicar de modulo se quiere obtener el permiso
      * @param int $idUsuario usuario logueado actualmente
      *
    **/
    function buscarPermisosBotonesAlarmas($idUsuario,$boton,$idBoton,$idUnidadNegocio){
      
      $verifica = 0;

      $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$boton' ORDER BY orden";
      $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
      $num = mysqli_num_rows($resultM);

      if($num > 0){

        $rowsM = $resultM->fetch_assoc();
        $pantallaM=$rowsM['sistema'];
        $permisoForma=$rowsM['comando'];


        $queryP = "SELECT permisos.id_sucursal,permisos.permiso,sucursales.descr as nombre 
                        FROM permisos 
                        LEFT JOIN sucursales ON permisos.id_sucursal=sucursales.id_sucursal
                        WHERE permisos.id_unidad_negocio = $idUnidadNegocio 
                        AND permisos.id_usuario=$idUsuario AND permisos.pantalla='$pantallaM' 
                        AND sucursales.activo=1
                        ORDER BY permisos.permiso DESC LIMIT 1";
        $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
        $numP = mysqli_num_rows($resultP);

        if($numP > 0){

          $cont=0;
          while($row = $resultP->fetch_assoc()){

             $permisoUsuario=$row['permiso'];
             if($this -> checaBit($permisoForma,$permisoUsuario)){
                $verifica = 1;
             }else{
                $verifica = 0;
             }
           
          }
          
      }else{
        
          $verifica = 0;
      }

    }else{
      
      $verifica = 0;
    }

    return $verifica;

  }//-- fin function buscarPermisosSucursal

  /**
    * Obtiene las sucursales a las que se puede aceder de una unidad de negocio un usuario especifico
    *
    * @param int $idUnidadNegocio dato que dice en que unidad de negocio se encuentra actialmente
    * @param varchar $modulo solo para indicar de modulo se quiere obtener el permiso
    * @param int $idUsuario usuario logueado actualmente
    *
  **/
  function buscarPermisosBotonArchivosCarpeta($idUsuario,$boton,$idBoton,$idUnidadNegocio){
      $verifica = 0;

      $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$boton' ORDER BY orden";
      $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
      $num = mysqli_num_rows($resultM);

      if($num > 0){

        $rowsM = $resultM->fetch_assoc();
        $pantallaM=$rowsM['sistema'];
        $permisoForma=$rowsM['comando'];


        $queryP = "SELECT permisos.permiso 
                  FROM permisos 
                  WHERE permisos.id_unidad_negocio=$idUnidadNegocio 
                  AND permisos.id_usuario=$idUsuario AND permisos.pantalla='$pantallaM'";
                        
        $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
        $numP = mysqli_num_rows($resultP);

        if($numP > 0){

          $cont=0;
          while($row = $resultP->fetch_assoc()){

            $permisoUsuario=$row['permiso'];
            if($this -> checaBit($permisoForma,$permisoUsuario)){
                $verifica = 1;
            }else{
                $verifica = 0;
            }
          
          }
          
      }else{
        
          $verifica = 0;
      }

    }else{
      
      $verifica = 0;
    }

    return $verifica;
  }//-- fin function buscarPermisosBotonArchivosCarpeta

  //-->NJES April/30/2020 verifica si el usuario tiene permiso para ver opcion tipo armas en activos
  function buscarPermisosArmasActivo($idUsuario,$boton,$idSucursal,$idUnidadNegocio){
      
    $verifica = 0;

    $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$boton' ORDER BY orden";
    $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
    $num = mysqli_num_rows($resultM);

    if($num > 0){

      $rowsM = $resultM->fetch_assoc();
      $pantallaM=$rowsM['sistema'];
      $permisoForma=$rowsM['comando'];


      $queryP = "SELECT permisos.id_sucursal,permisos.permiso,sucursales.descr as nombre 
                      FROM permisos 
                      LEFT JOIN sucursales ON permisos.id_sucursal=sucursales.id_sucursal
                      WHERE permisos.id_unidad_negocio = $idUnidadNegocio 
                      AND permisos.id_usuario=$idUsuario AND permisos.pantalla='$pantallaM' 
                      AND permisos.id_sucursal=$idSucursal
                      AND sucursales.activo=1
                      ORDER BY sucursales.descr";
      $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
      $numP = mysqli_num_rows($resultP);

      if($numP > 0){

        $cont=0;
        while($row = $resultP->fetch_assoc()){

           $permisoUsuario=$row['permiso'];
           if($this -> checaBit($permisoForma,$permisoUsuario)){
              $verifica = 1;
           }else{
              $verifica = 0;
           }
         
        }
        
      }else{
        
          $verifica = 0;
      }

    }else{
      
      $verifica = 0;
    }

    return $verifica;

  }

  /**
      * Obtiene la comparacion binaria para saber si tiene permiso o no a un modulo
      *
      * @param int $permiso_forma es el permiso que se encuentra en la tabla de menus (comando) del modulo ingresado o (sistema)
      * @param int $permiso_usuario es el permiso que tiene un usuario en la tabla de permisos sobre una pantalla especifica (modulo->sistema)
      *
  **/
  function checaBit($permiso_forma,$permiso_usuario)
  { 
    if(((int)$permiso_forma & (int)$permiso_usuario)==0)
      return 0;
    else 
      return 1;
  }

}//--fin de class Combos
    
?>