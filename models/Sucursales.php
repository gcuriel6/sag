<?php

include 'conectar.php';

class Sucursales
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function Sucursales()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Verifica que la clave de una sucursal no se repita
      *
      * @param varchar $clave es una clave para identificar una sucursal
      *
      **/
    function verificarSucursales($clave){
      $verifica = 0;

      $query = "SELECT id_sucursal FROM sucursales WHERE clave = '$clave'";
      $result = mysqli_query($this->link, $query)or die(mysqli_error());
      $num = mysqli_num_rows($result);

      if($num > 0)
        $verifica = 1;

      return $verifica;
    }//-- fin function verificarSucursales  


    /**
      * Busca los datos de las sucursales, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus 0=activos 1=inactivos 2=todos
      * @param varchar $lista  lista con las unidades separadas por coma
      *
      **/
    function buscarSucursales($estatus,$lista){
      
      $unidades='';
      if($lista != ''){
        $dato=substr($lista,1);
        $unidades = ' a.id_unidad_negocio IN('.$dato.') AND ';
      }

      $condicion='';
      if( $estatus == 0 )
      {
        $condicion=' AND a.activo=1 ';
      }else if( $estatus == 1 ){
        $condicion=' AND a.activo=0 ';
      }else{
        $condicion='';
      }
     
      $result1 = $this->link->query("SELECT a.id_sucursal,a.clave,a.descr AS nombre,a.activo,a.id_unidad_negocio,b.nombre AS nombre_unidad_negocio
                                        FROM sucursales a
                                        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                                        WHERE $unidades b.inactivo=0 $condicion
                                        ORDER BY a.id_sucursal");
  
      return query2json($result1);
    }//-- fin function buscarSucursales

    /**
      * Busca los datos de las sucursales, retorna un JSON con los datos correspondientes
      * 
      * @param int $idSucursal trae los datos de idSucursal requerido
      *
      **/
    function buscarSucursalesId($idSucursal){
    
      $result1 = $this->link->query("SELECT a.id_sucursal,a.clave,a.descr AS nombre,a.descripcion AS descr,a.calle,a.no_exterior,a.no_interior,a.colonia,
                                      a.codigopostal,a.id_pais,c.pais,a.id_estado,d.estado,a.id_municipio,e.municipio,a.nomina,
                                      a.activo,a.id_unidad_negocio,b.nombre AS nombre_unidad_negocio,
                                      IFNULL(f.id_sucursal,0) AS dia_28,IFNULL(g.id_sucursal,0) AS anticipo,IFNULL(h.id_sucursal,0) AS anticipo_a,
                                      IFNULL(i.id_sucursal,0) AS descuento_caja,IFNULL(i.monto,0) AS monto_descuento_caja
                                      FROM sucursales a
                                      LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                                      LEFT JOIN paises c ON a.id_pais=c.id
                                      LEFT JOIN estados d ON a.id_estado=d.id
                                      LEFT JOIN municipios e ON a.id_municipio=e.id
                                      LEFT JOIN d28_suc f ON a.id_sucursal=f.id_sucursal
                                      LEFT JOIN suc_con_ant g ON a.id_sucursal=g.id_sucursal
                                      LEFT JOIN suc_con_ant_a h ON a.id_sucursal=h.id_sucursal
                                      LEFT JOIN descuento_caja i ON a.id_sucursal=i.id_sucursal
                                      WHERE a.id_sucursal=".$idSucursal);
      return query2json($result1);
      
    }//-- fin function buscarSucursalesId

    /**
      * Manda llamar a la funcion que guarda la informacion
      * 
      * @param varchar $datos es un array que contiene los parametros
      *
      **/   
    function guardarSucursales($datos){
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> guardarActualizar($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
    }//-- fin function guardarSucursales

    /**
      * Guarda los datos de una sucursal, regresa el id de la sucursal afectada si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param varchar $datos es un array que contiene los parametros
      * id_unidad_negocio --> id_de la unidad de negocio a la que pertenece la sucursal
      * clave  --> clave de la sucursal
      * nombre  --> nombre corto de la sucursal
      * descripcion  --> descripcion de la sucursal
      * calle  --> calle domicilio de la sucursal
      * no_exterior  --> numero exterior del domicilio
      * no_interior  --> numero interior del domiclio, en caso de que tenga
      * colonia  --> colonia del domiclio
      * codigo_postal --> Código Postal del domiclio
      * id_pais  --> id_pais del domicilio para relacionarlo con tabla paises
      * id_estado  --> id_estado del domcilio para relacionarlo con tabla estados
      * id_municipio --> id_municipio del domiclio para relacionarlo con tabla municpios
      * nomina  --> indica si la sucursal se asignara a nomina 0=no se asigna a nomina, 1=se asigna a nomina
      * inactivo  --> estatus de la sucursal 1=activo, 0=inactivo 
      * tipo_mov  --> indica si es una insercion = 0 ó actualizacion = 1
      *
      **/ 
    function guardarActualizar($datos){
  
        $verifica = 0;

        $idSucursal = $datos['idSucursal'];
        $id_unidad_negocio = $datos['id_unidad_negocio'];
        $clave = $datos['clave'];
        $nombre = $datos['nombre'];
        $descripcion = $datos['descripcion'];
        $calle = $datos['calle'];
        $no_exterior = $datos['no_exterior'];
        $no_interior = $datos['no_interior'];
        $colonia = $datos['colonia'];
        $codigo_postal = $datos['codigo_postal'];
        $id_pais = $datos['id_pais'];
        $id_estado = $datos['id_estado'];
        $id_municipio = $datos['id_municipio'];
        $nomina = $datos['nomina'];
        $inactivo = $datos['inactivo'];
        $tipo_mov = $datos['tipo_mov'];
        $ch_descuento_dia = $datos['ch_descuento_dia'];
        $ch_anticipos = $datos['ch_anticipos'];
        $ch_anticipos_administrativa = $datos['ch_anticipos_administrativa'];
        $ch_descuento_caja = $datos['ch_descuento_caja'];
        $descuento_caja = $datos['descuento_caja'];

        if($tipo_mov==0){

          $query = "INSERT INTO sucursales(id_unidad_negocio,clave,descr,descripcion,calle,no_exterior,no_interior,colonia,codigopostal,id_pais,id_estado,id_municipio,nomina,activo)VALUES ('$id_unidad_negocio','$clave','$nombre','$descripcion','$calle','$no_exterior','$no_interior','$colonia','$codigo_postal','$id_pais','$id_estado','$id_municipio','$nomina','$inactivo')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id_registro = mysqli_insert_id($this->link);

          if($result){

            $verifica = $this -> generaAreaFinanzas($id_registro,$datos);
          }

          

        }else{

          $query = "UPDATE sucursales SET id_unidad_negocio='$id_unidad_negocio',clave='$clave',descr='$nombre',descripcion='$descripcion',calle='$calle',no_exterior='$no_exterior',no_interior='$no_interior',colonia='$colonia',codigopostal='$codigo_postal',id_pais='$id_pais',id_estado='$id_estado',id_municipio='$id_municipio',nomina='$nomina',activo='$inactivo' WHERE id_sucursal=".$idSucursal;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          
          $arr=array('id_registro'=>$idSucursal,
                    'nombre'=>$nombre,
                    'id_unidad_negocio'=>$id_unidad_negocio,
                    'ch_descuento_dia'=>$ch_descuento_dia,
                    'ch_anticipos'=>$ch_anticipos,
                    'ch_anticipos_administrativa'=>$ch_anticipos_administrativa,
                    'ch_descuento_caja'=>$ch_descuento_caja,
                    'descuento_caja'=>$descuento_caja);

          if ($result) {
            
            $verifica = $this -> actualizaCompanias($arr,$id_municipio,$id_estado,$id_pais);
            
          }else{
  
            $verifica = 0;
          }
        }
        
        return $verifica;
    }//--fin function guardarActualizar

    /** 
      *Actualiza el campo id_compania en la tabla sucursales con el id del registro insertado 
      * 
      *@param varchar $arr es un array que contiene los parametros
      * $id_registro id de la sucursal insertada
      *@param int $id_municipio del domicilio para relacionarlo con municipios
      *@param int $id_estado del domicilio para relacionarlo con tabla estados
      *@param int $id_pais del domicilio para relacionarlo con tabla paises
      *
      **/
    function actualizaCompaniaId($arr,$id_municipio,$id_estado,$id_pais){

        $id_registro = $arr['id_registro'];

        $query2 = "UPDATE sucursales SET id_compania='$id_registro' WHERE id_sucursal=".$id_registro;
        $result2 = mysqli_query($this->link, $query2) or die(mysqli_error());
        
        if ($result2) {

          $verifica = $this -> insertaCompanias($arr,$id_municipio,$id_estado,$id_pais);
          
        }else{

          $verifica = 0;
        }

        return $verifica;

    }//--fin function actualizaCompaniaId

    /** 
      *Inserta en tabla companias registros
      * 
      *@param varchar $arr es un array que contiene los parametros
      * $id_registro id de la sucursal insertada
      * $nombre nombre de la sucursal
      * $id_unidad_negocio id_de la unidad de negocio a la que pertenece la sucursal/compania
      *@param int $id_municipio del domicilio para relacionarlo con municipios
      *@param int $id_estado del domicilio para relacionarlo con tabla estados
      *@param int $id_pais del domicilio para relacionarlo con tabla paises
      *
      **/
    function insertaCompanias($arr,$id_municipio,$id_estado,$id_pais){

        $id_registro = $arr['id_registro'];
        $nombre = $arr['nombre'];
        $id_unidad_negocio = $arr['id_unidad_negocio'];

        $query_companias = "INSERT INTO companias(id_compania,nombre,id_municipio,id_estado,id_pais,id_unidad_negocio) 
                              VALUES('$id_registro','$nombre','$id_municipio','$id_estado','$id_pais','$id_unidad_negocio')";
        $result_companias = mysqli_query($this->link, $query_companias) or die(mysqli_error());
        
        if ($result_companias) {
            
          $verifica = $this -> buscaDia28Sucursal($arr);
        }else{

          $verifica = 0;
        }

        return $verifica;

    }//--fin function insertaCompanias

    /** 
      *Busca en tabla el registro 
      * 
      *@param varchar $arr es un array que contiene los parametros
      *int $id_registro id de la sucursal insertada
      *
      **/
    function buscaDia28Sucursal($arr){

        $id_registro = $arr['id_registro'];

        //--Buscamos si existe el registro en la tabla para eliminarlo
        $busca="SELECT id_sucursal FROM d28_suc WHERE id_sucursal=".$id_registro;
        $result = mysqli_query($this->link, $busca)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0){
          //--Borrar el registro de la sucursal si existe
          $borrar_registro_dia28 = "DELETE FROM d28_suc WHERE id_sucursal=".$id_registro;
          $result_borrar_registro_dia28 = mysqli_query($this->link,$borrar_registro_dia28) or die(mysqli_error());
          
          if ($result_borrar_registro_dia28) //--mandamos llamar otra funcion para ver si se va a insertar
          {
            $verifica = $this -> insertaDia28Sucursal($arr);
          }else{
            $verifica = 0;
          }
        }else{

          $verifica = $this -> insertaDia28Sucursal($arr);
        }

        return $verifica;

    }//--fin function buscaDia28Sucursal

    /** 
      *Inserta en tabla d28_suc el id del registro de sucursal insertado 
      * 
      *@param varchar $arr es un array que contiene los parametros
      *int $id_registro id de la sucursal insertada
      *int $id_unidad_negocio id_de la unidad de negocio a la que pertenece la sucursal/compania
      *int $ch_descuento_dia indica si la sucursal tiene descuento de dia 28 ó 28 
      *
      **/
    function insertaDia28Sucursal($arr){

        $id_registro = $arr['id_registro'];
        $id_unidad_negocio = $arr['id_unidad_negocio'];
        $ch_descuento_dia = $arr['ch_descuento_dia'];

        if($ch_descuento_dia == 1) //--si el checkbox de descuento de dia 28 ó 29 es checked vamos a insertar el id de la sucursal
        {
          //--Insertar registro con id de la sucursal
          $query_dia = "INSERT INTO d28_suc(id_sucursal,id_unidad_negocio) 
                          VALUES('$id_registro','$id_unidad_negocio')";
          $result_dia = mysqli_query($this->link, $query_dia) or die(mysqli_error());

          if ($result_dia) //--mandamos llamar otra funcion para ver si se va a insertar
          {
            $verifica = $this -> buscaAnticipos($arr);
          }else{
            $verifica = 0;
          }

        }else{ //--mandamos llamar otra funcion para ver si se va a insertar
          $verifica = $this -> buscaAnticipos($arr);
        }

        return $verifica;

    }//--fin function insertaDia28Sucursal

    /** 
      *Busca en tabla el registro 
      * 
      *@param varchar $arr es un array que contiene los parametros
      *int $id_registro id de la sucursal insertada
      *
      **/
    function buscaAnticipos($arr){
        $id_registro = $arr['id_registro'];

        //--Buscamos si existe el registro en la tabla para eliminarlo
        $busca="SELECT id_sucursal FROM suc_con_ant WHERE id_sucursal=".$id_registro;
        $result = mysqli_query($this->link, $busca)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0){
          //--Borrar el registro de la sucursal si existe
          $borrar_registro_anticipo = "DELETE FROM suc_con_ant WHERE id_sucursal=".$id_registro;
          $result_borrar_registro_anticipo = mysqli_query($this->link,$borrar_registro_anticipo) or die(mysqli_error());
        
          if ($borrar_registro_anticipo) //--mandamos llamar otra funcion para ver si se va a insertar
          {
            $verifica = $this -> insertaAnticipos($arr);
          }else{
            $verifica = 0;
          }
        }else{
          $verifica = $this -> insertaAnticipos($arr);
        }

        return $verifica;

    }//--fin function buscaAnticipos

    /** 
      *Inserta en tabla suc_con_ant el id del registro de sucursal insertado 
      * 
      *@param varchar $arr es un array que contiene los parametros
      *int $id_registro id de la sucursal insertada
      *varchar $nombre nombre de la sucursal
      *int $id_unidad_negocio id_de la unidad de negocio a la que pertenece la sucursal/compania
      *int $ch_anticipos indica si la sucursal tiene anticipos
      *
      **/
    function insertaAnticipos($arr){
        $id_registro = $arr['id_registro'];
        $id_unidad_negocio = $arr['id_unidad_negocio'];
        $nombre = $arr['nombre'];
        $ch_anticipos = $arr['ch_anticipos'];

        if($ch_anticipos == 1) //--si el checkbox de descuento de anticipos es checked vamos a insertar el id de la sucursal
        {
          //--Insertar registro con id de la sucursal
          $query_anticipo = "INSERT INTO suc_con_ant(id_sucursal,id_compania,descr,id_unidad_negocio) 
                            VALUES('$id_registro','$id_registro','$nombre','$id_unidad_negocio')";
          $result_anticipo = mysqli_query($this->link, $query_anticipo) or die(mysqli_error());

          if ($result_anticipo) //--mandamos llamar otra funcion para ver si se va a insertar
          {
            $verifica = $this -> buscaAnticiposAdministrativa($arr);
          }else{
            $verifica = 0;
          }

        }else{ //--mandamos llamar otra funcion para ver si se va a insertar
          $verifica = $this -> buscaAnticiposAdministrativa($arr);
        }
    
        return $verifica;

    }//--fin function insertaAnticipos

    /** 
      *Busca en tabla el registro  
      * 
      *@param varchar $arr es un array que contiene los parametros
      *int $id_registro id de la sucursal insertada
      *
      **/
    function buscaAnticiposAdministrativa($arr){

        $id_registro = $arr['id_registro'];

        //--Buscamos si existe el registro en la tabla para eliminarlo
        $busca="SELECT id_sucursal FROM suc_con_ant_a WHERE id_sucursal=".$id_registro;
        $result = mysqli_query($this->link, $busca)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0){
          //--Borrar el registro de la sucursal si existe
          $borrar_registro_anticipo_a = "DELETE FROM suc_con_ant_a WHERE id_sucursal=".$id_registro;
          $result_borrar_registro_anticipo_a = mysqli_query($this->link,$borrar_registro_anticipo_a) or die(mysqli_error());
          
          if ($result_borrar_registro_anticipo_a) //--mandamos llamar otra funcion para ver si se va a insertar
          {
            $verifica = $this -> insertaAnticiposAdministrativa($arr);
          }else{
            $verifica = 0;
          }
        }else{
          $verifica = $this -> insertaAnticiposAdministrativa($arr);
        }

        return $verifica;

    }//--fin function buscaAnticiposAdministrativa

    /** 
      *Inserta en tabla suc_con_ant_a el id del registro de sucursal insertado 
      * 
      *@param varchar $arr es un array que contiene los parametros
      *int $id_registro id de la sucursal insertada
      *varchar $nombre nombre de la sucursal
      *int $id_unidad_negocio id_de la unidad de negocio a la que pertenece la sucursal/compania
      *int $ch_anticipos_administrativa indica si la sucursal tiene anticipos administrativos
      *
      **/
    function insertaAnticiposAdministrativa($arr){

        $id_registro = $arr['id_registro'];
        $id_unidad_negocio = $arr['id_unidad_negocio'];
        $nombre = $arr['nombre'];
        $ch_anticipos_administrativa = $arr['ch_anticipos_administrativa'];

        if($ch_anticipos_administrativa == 1) //--si el checkbox de descuento de anticipos nomina administrativa es checked vamos a insertar el id de la sucursal
        {
          //--Insertar registro con id de la sucursal
          $query_anticipo_a = "INSERT INTO suc_con_ant_a(id_sucursal,id_compania,descr,id_unidad_negocio) 
                              VALUES('$id_registro','$id_registro','$nombre','$id_unidad_negocio')";
          $result_anticipo_a = mysqli_query($this->link, $query_anticipo_a) or die(mysqli_error());

          if ($result_anticipo_a) //--mandamos llamar otra funcion para ver si se va a insertar
          {
            $verifica = $this -> buscaDescuentoCaja($arr);
          }else{
            $verifica = 0;
          }

        }else{ //--mandamos llamar otra funcion para ver si se va a insertar
          $verifica = $this -> buscaDescuentoCaja($arr);
        }

        return $verifica;

    }//--fin function insertaAnticiposAdministrativa

    /** 
      *Busca en tabla el registro 
      * 
      *@param varchar $arr es un array que contiene los parametros
      *int $id_registro id de la sucursal insertada
      *
      **/
    function buscaDescuentoCaja($arr){

        $id_registro = $arr['id_registro'];

        //--Buscamos si existe el registro en la tabla para eliminarlo
        $busca="SELECT id_sucursal FROM descuento_caja WHERE id_sucursal=".$id_registro;
        $result = mysqli_query($this->link, $busca)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0){
          //--Borrar el registro de la sucursal si existe
          $borrar_registro_descuento_caja = "DELETE FROM descuento_caja WHERE id_sucursal=".$id_registro;
          $result_borrar_registro_descuento_caja = mysqli_query($this->link,$borrar_registro_descuento_caja) or die(mysqli_error());
        
          if ($result_borrar_registro_descuento_caja) //--mandamos llamar otra funcion para ver si se va a insertar
          {
            $verifica = $this -> insertaDescuentoCaja($arr);
          }else{
            $verifica = 0;
          }
        }else{
          $verifica = $this -> insertaDescuentoCaja($arr);
        }

        return $verifica;

    }//--fin function buscaDescuentoCaja

    /** 
      *Inserta en tabla descuento_caja el id y monto del registro de sucursal insertado 
      * 
       *@param varchar $arr es un array que contiene los parametros
      *int $id_registro id de la sucursal insertada
      *int $id_unidad_negocio id_de la unidad de negocio a la que pertenece la sucursal/compania
      *int $ch_descuento_caja indica si la sucursal tiene descuento de caja
      *double $descuento_caja el monto que se inserta si la sucursal tiene descuento de caja
      *
      **/
    function insertaDescuentoCaja($arr){

        $id_registro = $arr['id_registro'];
        $id_unidad_negocio = $arr['id_unidad_negocio'];
        $ch_descuento_caja = $arr['ch_descuento_caja'];
        $descuento_caja = $arr['descuento_caja'];

        if($ch_descuento_caja == 1) //--si el checkbox de descuento de anticipos nomina administrativa es checked vamos a insertar el id de la sucursal
        {
          //--Insertar registro con id de la sucursal
          $query_descuento = "INSERT INTO descuento_caja(id_sucursal,monto,id_unidad_negocio) 
                              VALUES('$id_registro','$descuento_caja','$id_unidad_negocio')";
          $result_descuento = mysqli_query($this->link, $query_descuento) or die(mysqli_error());

          if ($result_descuento) //--no hay mas datos, todo se inserto bien. Regresamos el id de la sucursal $id_registro
          {
            $verifica = $id_registro; 
          }else{
            $verifica = 0;
          }
          
        }else{ //--regresamos el id de la sucursal $id_registro
          $verifica = $id_registro;
        }

        return $verifica;

    }//--fin function insertaDescuentoCaja

    /** 
      *Actualiza tabla companias 
      *
      *@param varchar $arr es un array que contiene los parametros
      * $id_registro id de la sucursal insertada
      * $nombre nombre de la sucursal
      * $id_unidad_negocio id_de la unidad de negocio a la que pertenece la sucursal/compania
      *@param int $id_municipio del domicilio para relacionarlo con municipios
      *@param int $id_estado del domicilio para relacionarlo con tabla estados
      *@param int $id_pais del domicilio para relacionarlo con tabla paises
      *
      **/
    function actualizaCompanias($arr,$id_municipio,$id_estado,$id_pais){

        $id_registro = $arr['id_registro'];
        $nombre = $arr['nombre'];
        $id_unidad_negocio = $arr['id_unidad_negocio'];
                     
        $query_u_companias = "UPDATE companias 
                              SET nombre='$nombre',
                              id_municipio='$id_municipio',
                              id_estado='$id_estado',
                              id_pais='$id_pais',
                              id_unidad_negocio='$id_unidad_negocio' 
                              WHERE id_compania=".$id_registro;
        $result_u_companias = mysqli_query($this->link, $query_u_companias) or die(mysqli_error());
        
        if ($result_u_companias) {
            
          $verifica = $this -> buscaDia28Sucursal($arr);
          
        }else{

          $verifica = 0;
        }

        return $verifica;

    }//--fin function actualizaCompanias


    /* ESTA FUNCION GENERA UNA AREA DE FINANZAS DE ESTA SUCURSAL 
    *  PARA PODER GENERAR EL DEPARTAMENTO INTERNO DE ADMINISTRACIÓN
     * */ 
    function generaAreaFinanzas($id_registro,$datos){

      $verifica = 0;

      $idSucursal = $id_registro;
      $nombre = $datos['nombre'];

      $area='FIN FINANZAS'.$nombre;
 

      $query = "INSERT INTO cat_areas(clave,descripcion,activa,id_sucursal)VALUES ('FIN','$area',1,'$idSucursal')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      $idArea = mysqli_insert_id($this->link);

      if($result){

      
        $verifica = $this -> generaDepartamentoAdmon($id_registro,$idArea,$datos);

      }else{
        $verifica = 0;
      }

      return $verifica;
    }//-- fin de  generaDepartamentoAdmon

    /* ESTA FUNCION GENERA UN DEPARTAMENTO DE AMONISTRACION O CLAVE ID_SUC00000 
     * El departamento debe componerse de la concatenación id_sucursal+00000 y debe tener el nombre ADMINISTRACION (nombre_sucursal). 
     * Por ejemplo, la sucursal 1 que es Chihuahua, deberá llamarse: ADMINISTRACION (CHIHUAHUA) con clave 0100000
     * */ 
    function generaDepartamentoAdmon($id_registro,$idArea,$datos){
     
      $verifica = 0;

      $idSucursal = $id_registro;
      $id_unidad_negocio = $datos['id_unidad_negocio'];
      $nombre = $datos['nombre'];
      //---MGFS 22-10-2019 Cuando se guarde una nueva sucursal, que el primer departamento que se genera automáticamente en lugar de llamarse "administración (sucursal)" se llame  "contraloría (sucursal)"
      $suc=str_pad($idSucursal, 2, "0", STR_PAD_LEFT);
      $claveDep=$suc.'00000';//contraloría
      $descripcion='CONTRALORÍA '.$nombre;

      $query = "INSERT INTO deptos(cve_dep,des_dep,id_compania,id_unidad_negocio,id_sucursal,id_area,tipo)
      VALUES ('$claveDep','$descripcion','$idSucursal','$id_unidad_negocio','$idSucursal','$idArea','I')";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());
      $idDepartamento = mysqli_insert_id($this->link);

      if($result){

        $arr=array('id_registro'=>$id_registro,
        'nombre'=>$nombre,
        'id_unidad_negocio'=>$id_unidad_negocio,
        'ch_descuento_dia'=>$ch_descuento_dia,
        'ch_anticipos'=>$ch_anticipos,
        'ch_anticipos_administrativa'=>$ch_anticipos_administrativa,
        'ch_descuento_caja'=>$ch_descuento_caja,
        'descuento_caja'=>$descuento_caja);

        $verifica = $this -> actualizaCompaniaId($arr,$id_municipio,$id_estado,$id_pais);

      }else{
        $verifica = 0;
      }

      return $verifica;
    }//-- fin de  generaDepartamentoAdmon
    
}//--fin de class Sucursales
    
?>