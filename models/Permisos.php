<?php

include 'conectar.php';

class Permisos
{

  /**
  * Se declara la variable $link y en el constructor se asigna o inicializa
  * 
  **/

  public $link;

  function Permisos()
  {

    $this->link = Conectarse();

  }

  /**
    * Verifica que el nombre en usuario no se repita
    *
    * @param varchar $usuario  usado para ingresar al sistema
    *
    **/
  function buscarArbol($idUsuario,$idUnidadNegocio,$idSucursal){
    $raiz = "GINTHERCORP";
    $arr=array();

    $query="SELECT * FROM menus";
    $result=mysqli_query($this->link, $query);
    $num=mysqli_num_rows($result);


    for($i=0; $i < $num ; $i++) {

      $row=mysqli_fetch_array($result);
      $sistema = $row['sistema'];

      $query2 = "SELECT permiso 
      FROM permisos 
      WHERE id_usuario = ".$idUsuario." AND pantalla = '$sistema' AND  id_unidad_negocio=".$idUnidadNegocio." AND id_sucursal=".$idSucursal;
      $result2=mysqli_query($this->link, $query2);
      $row2=mysqli_fetch_array($result2);
      $per_usuario = $row2['permiso'];
      
      $aux = (int)$row['comando'] & (int)$per_usuario;
      if($aux==0){
          $selected = false;
      }else{
          $selected = true;
      }


      if($row['sistema']==$raiz){
        $sistema = '#';
      }

    $arr[$i]=array('id'=>$row['menuid'],'parent'=>$sistema,'text'=>$row['menuid'],'state'=> array('selected' => $selected));
    }
    echo json_encode($arr);

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
  function guardarPermisos($usuario,$idUsuario,$idUnidadNegocio,$idSucursal,$datos){
  
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardarActualizar($usuario,$idUsuario,$idUnidadNegocio,$idSucursal,$datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;

  } //-- fin function guardarUsuarios


  /**
    * Guarda los permisos de un usuario y su  unidad de negocio y sucursal en eparticular
    * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
    * @param varchar $clave es una clave para identificar una unidad de negocio
    * @param varchar $nombre es el nombre asignado a una unidad de negocio
    * @param varchar $descripcion brebe descripcion de una unidad de negocio
    * @param varchar $logo es el logotipo que va a manejar la unidad de negocion en todos los formatos y modulos
    * @param int $inactivo estatus de una unidad de negocio 0='Activa' 1='Inactiva'  
    *
  **/ 
  function guardarActualizar($usuario,$idUsuario,$idUnidadNegocio,$idsSucursales,$datos){
    
      $verifica = 0;

      $usuarioActualizo = $_SESSION["id_usuario"];

      for($j=0; $j< count($idsSucursales); $j++){

        $idSucursal=$idsSucursales[$j]['idSucursal'];

        $nuevos_permisos = array();

        for($i=0; $i< count($datos); $i++){
          $menu = $datos[$i];
          
          $query = "SELECT sistema,comando FROM menus WHERE menuid = '".$menu['menu']."'";
          $resultado = mysqli_query($this->link,$query);
          $row = mysqli_fetch_array($resultado);
          
          $permiso = $row['comando'];
          $padre = $row['sistema'];
          $estado = $menu['state'];
          
          $aux = $nuevos_permisos[$padre];
          if($estado=='true'){
            
            $nuevos_permisos[$padre] = $aux + $permiso;
          }

        }
  
        $queryB = "DELETE FROM permisos WHERE id_usuario=".$idUsuario." AND id_unidad_negocio=".$idUnidadNegocio." AND id_sucursal=".$idSucursal;
        $resultB = mysqli_query($this->link, $queryB) or die(mysqli_error());
              
        if($resultB){ 
          //--- MGFS se verifica que tenga nuevos permisos sino solo se va a 1 si tiene permisos nuevos entra al foreach
          if(count($nuevos_permisos)>0){

            foreach($nuevos_permisos as $pantalla => $permiso) {

              $query = "INSERT INTO permisos(usuario,id_usuario,pantalla,permiso,id_sucursal,id_compania,id_unidad_negocio, usuario_actualizo) VALUES ('$usuario','$idUsuario','$pantalla','$permiso','$idSucursal','$idUnidadNegocio','$idUnidadNegocio','$usuarioActualizo')";
              $result = mysqli_query($this->link, $query) or die(mysqli_error());

              if($result){
                $ele=count($datos);
              
                if($i==$ele){
                  $verifica = 1;
                      
                }

              }else{
                
                    $verifica = 0;
                    break;
              } 
            }

          }else{

            $verifica = 1;
          }
    
        }else{
          
          $verifica=0;
          break;
        }
      }  
      $suc=count($idsSucursales);
      if($j==$suc){
        
        return $verifica;
      }
      
  }

  function buscarMenuPadres(){
    $query = "SELECT sistema FROM menus GROUP BY sistema ORDER BY sistema ASC";

    $resultado = $this->link->query($query);

    return query2json($resultado);
  }
  
  function buscarMenuHijos($padre){
    $query = "SELECT menuid FROM menus WHERE sistema = '$padre' ORDER BY menuid ASC";

    $resultado = $this->link->query($query);

    return query2json($resultado);
  }

  function buscarMenuUsuarios(){
    $query = "SELECT usuario, id_usuario
              FROM usuarios
              ORDER BY usuario ASC;";

    $resultado = $this->link->query($query);

    return query2json($resultado);
  }  

  function buscarReportePermisos($datos){
    $sistemaF = $datos['sistema'];
    $menuid = $datos['menuid'];
    $idUnidadNegocio = $datos['idUnidadNegocio'];
    $idSucursal = $datos['idSucursal'];

    if($idUnidadNegocio != '')
      $condUnidad = ' AND permisos.id_unidad_negocio = '.$idUnidadNegocio;
    else
      $condUnidad = '';

    if($idSucursal != '')  
      $condSucursal = ' AND permisos.id_sucursal = '.$idSucursal;
    else
      $condSucursal = '';

    $arr=array();
	  $cont=0;

    if($sistemaF == '' &&  $menuid == '')
      $query = "SELECT sistema, menuid, comando, descripcion FROM menus ORDER BY sistema ASC";
    else if($sistemaF != '' &&  $menuid == '')
      $query = "SELECT sistema, menuid, comando, descripcion FROM menus WHERE sistema = '$sistemaF' ORDER BY sistema ASC";
    else if($sistemaF == '' &&  $menuid != '')
      $query = "SELECT sistema, menuid, comando, descripcion FROM menus WHERE menuid = '$menuid'";
    else
      $query = "SELECT sistema, menuid, comando, descripcion FROM menus WHERE sistema = '$sistemaF' AND menuid = '$menuid'";
    
    // echo $query;
    // exit();

    $result=mysqli_query($this->link, $query);
    $num=mysqli_num_rows($result);

    for($i=0; $i < $num ; $i++) {

      $row=mysqli_fetch_array($result);
      $sistema = $row['sistema'];

      /***VERIFICA LOS PERMISOS DE USUSRIO EN LA UNIDAD DE NEGOCIO POR CADA SUCURSAL */
      $query2 = "SELECT permisos.permiso,permisos.usuario,usuarios.nombre_comp AS nombre,
      IFNULL(trabajadores.cve_nom,'') AS cve_nom,IF(usuarios.activo=1,'Activo','Inactivo') AS estatus,
      cat_unidades_negocio.nombre AS unidad_negocio,sucursales.descr AS sucursal
      FROM permisos 
      LEFT JOIN cat_unidades_negocio ON permisos.id_unidad_negocio=cat_unidades_negocio.id
      LEFT JOIN sucursales ON permisos.id_sucursal= sucursales.id_sucursal
      LEFT JOIN usuarios ON permisos.id_usuario=usuarios.id_usuario
      LEFT JOIN trabajadores ON usuarios.id_empleado=trabajadores.id_trabajador
      WHERE permisos.pantalla = '$sistema' $condUnidad $condSucursal
      -- GROUP BY permisos.id_usuario
      ORDER BY permisos.usuario ASC";

      // echo $query2;
      // exit();
      $result2=mysqli_query($this->link, $query2);

      while($row2=mysqli_fetch_array($result2))
      {
        $per_usuario = $row2['permiso'];
        
        $aux = (int)$row['comando'] & (int)$per_usuario;
        //echo ' * '.$sistema.' - '.$row['comando'].' - '.$per_usuario.' = '.$aux.' * ';
        if($aux > 0)
        {
          $arr[$cont++]=array('padre'=>$row['sistema'],'hijo'=>$row['menuid'],'usuario'=>$row2['usuario'],'nombre'=>$row2['nombre'],
          'cve_nom'=>$row2['cve_nom'],'estatus'=>$row2['estatus'],'unidad_negocio'=>$row2['unidad_negocio'],'sucursal'=>$row2['sucursal'],'tipo'=>$row['descripcion']);
        }
      }
    }
      
    return json_encode($arr);
  }

  function buscarReportePermisosUsuario($datos){
    $idUsuario = $datos['idUsuario'];

    $query = "SELECT
                  per.usuario,
                  usu.id_empleado cve_nom,
                  usu.nombre_comp AS nombre,
                  IF(usu.activo=1,'Activo','Inactivo') AS estatus,
                  cut.nombre AS unidad_negocio,
                  suc.descr AS sucursal,
                  men.sistema padre,
                  men.menuid hijo
              FROM permisos per
              INNER JOIN menus men ON men.menuid = per.pantalla
              LEFT JOIN cat_unidades_negocio cut ON per.id_unidad_negocio = cut.id
              LEFT JOIN sucursales suc ON per.id_sucursal = suc.id_sucursal
              LEFT JOIN usuarios usu ON per.id_usuario = usu.id_usuario
              LEFT JOIN trabajadores tra ON usu.id_empleado = tra.id_trabajador
              WHERE usu.id_usuario = $idUsuario
              ORDER BY cut.nombre ASC;";

    $resultado = $this->link->query($query);

    return query2json($resultado);
  }

  function duplicarPermisos($origen, $destino){

    $query = "DELETE FROM permisos WHERE id_usuario=".$destino;
    $result = mysqli_query($this->link, $query) or die(mysqli_error());
          
    if($result){ 
      //--- MGFS se verifica que tenga nuevos permisos sino solo se va a 1 si tiene permisos nuevos entra al foreach
      $query = "INSERT INTO permisos(usuario, id_usuario, pantalla, permiso, id_sucursal, id_compania, id_unidad_negocio)
                SELECT us.usuario, us.id_usuario, per.pantalla, per.permiso, per.id_sucursal, per.id_compania, per.id_unidad_negocio
                FROM usuarios us
                INNER JOIN permisos per ON us.id_usuario = $destino
                where per.id_usuario = $origen;";
                
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      if($result){

        return 1;

      }else{
        
        return 0;
      } 

    }else{
      
      return 0;
    }
    
  }

}//--fin de class Permisos
    
?>