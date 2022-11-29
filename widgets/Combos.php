<?php

include 'conectar.php';

class Combos
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    *
    **/

    public $link;
    public $linkCFDI;

    function __construct()
    {

      $this->link = Conectarse();
      $this->linkCFDI = ConectarseCFDI();

    }

    /**
      * Obtiene las sucursales a las que se puede aceder de una unidad de negocio un usuario especifico
      *
      * @param int $idUnidadNegocio dato que dice en que unidad de negocio se encuentra actialmente
      * @param varchar $modulo solo para indicar de modulo se quiere obtener el permiso
      * @param int $idUsuario usuario logueado actualmente
      *
    **/
    function buscarPermisosSucursal($idUnidadNegocio,$modulo,$idUsuario){

      $verifica = 0;

      $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$modulo' ORDER BY orden";
      $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
      $num = mysqli_num_rows($resultM);

      if($num > 0){

        $rowsM = $resultM->fetch_assoc();
        $pantallaM=$rowsM['sistema'];
        $permisoForma=$rowsM['comando'];


        $queryP = "SELECT permisos.id_sucursal,permisos.permiso,sucursales.descr as nombre FROM permisos LEFT JOIN sucursales ON permisos.id_sucursal=sucursales.id_sucursal WHERE permisos.id_unidad_negocio = $idUnidadNegocio AND permisos.id_usuario=$idUsuario AND permisos.pantalla='$pantallaM' AND sucursales.activo=1 ORDER BY sucursales.descr";
        
        $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
        $numP = mysqli_num_rows($resultP);

        if($numP > 0){

          $array = array();
          $cont=0;
          while($row = $resultP->fetch_assoc()){

             $permisoUsuario=$row['permiso'];
             $id_sucursal=$row['id_sucursal'];
             $nombre=$row['nombre'];

             if($this -> checaBit($permisoForma,$permisoUsuario)){
                $array[$cont]=array('id_sucursal'=>$id_sucursal,'nombre'=>$nombre);
                $cont++;
             }

          }

          if(count($array)>0){

              $verifica=json_encode($array);
          }else{

              $verifica = 0;
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
      * @param int $idUsuario usuario logueado actualmente
      *
    **/
    function buscarSucursalesAcceso($idUnidadNegocio,$idUsuario){

       $resultado = $this->link->query("SELECT
sucursales.id_sucursal,
sucursales.descr AS nombre,
IFNULL(accesos.id,0) AS id_acceso
FROM cat_unidades_negocio unidades
LEFT JOIN sucursales ON unidades.id=sucursales.id_unidad_negocio
LEFT JOIN accesos ON unidades.id=accesos.id_unidad_negocio AND  sucursales.id_sucursal=accesos.id_sucursal  AND accesos.id_usuario=".$idUsuario."
WHERE unidades.inactivo=0 AND sucursales.activo=1 AND unidades.id=".$idUnidadNegocio."
HAVING id_acceso > 0
ORDER BY unidades.nombre,sucursales.descr ASC");
      return query2json($resultado);

  }//-- fin function buscarSucursalesAcceso

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

  /**
   * Obtiene los registros de cat_paises para generar combo
  **/
  function buscarPaises(){

    $result1 = $this->link->query("SELECT id,codigo3,pais FROM paises WHERE mostrar=1 ORDER BY id");
    return query2json($result1);

  }//-- fin function buscarPaises

  /**
   * Obtiene los registros de cat_paises para generar combo
  **/
  function buscarEstados(){

    $result1 = $this->link->query("SELECT id,estado FROM estados ORDER BY id");
    return query2json($result1);

  }//-- fin function buscarEstados

  /**
   * Obtiene los registros de cat_paises para generar combo
   * @param int $idEstado dato que indica que solo se buscaran los municipios que pertenecen a ese $idEstado
  **/
  function buscarMunicipios($idEstado){

    if($idEstado == 0)
    {

      $result1 = $this->link->query("SELECT id,municipio FROM municipios ORDER BY id");
      return query2json($result1);

    }else{

      $result1 = $this->link->query("SELECT id,municipio FROM municipios WHERE id_estado=".$idEstado);
      return query2json($result1);

    }

  }//-- fin function buscarMunicipios

  function buscarRegimenes(){

    $result1 = $this->linkCFDI->query("SELECT c_regimen_fiscal as id, descripcion as descr FROM cat_regimen_fiscal ORDER BY c_regimen_fiscal ASC");
    return query2json($result1);

  }//-- fin function buscarRegimenes

  /**
   * Obtiene los registros de deptos para generar combo
   * @param int $idSucursal dato que indica que solo se buscaran los departamentos que pertenecen a ese $idCompañia
  **/
  function buscarDepartamentos($idSucursal){
    $result1 = $this->link->query("SELECT id_depto as id, cve_dep as clave, des_dep as descripcion FROM deptos WHERE id_compania=".$idSucursal);
    return query2json($result1);

  }//-- fin function buscarDepartamentos

  function buscarPuestos(){
    $result1 = $this->link->query("SELECT id_puesto,puesto FROM cat_puestos ORDER BY puesto");
    return query2json($result1);

  }//-- fin function buscarPuestos

  function buscarFirmantes(){
    $result1 = $this->link->query("SELECT id,nombre FROM cat_firmantes WHERE activo=1 ORDER BY nombre");
    return query2json($result1);

  }//-- fin function buscarFirmantes

  function buscarUnidadesNegocioAcceso($idUsuario){
    $result1 = $this->link->query("SELECT DISTINCT(a.id_unidad_negocio)AS id_unidad,b.logo,b.nombre AS nombre_unidad FROM accesos a LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id WHERE a.id_usuario=".$idUsuario);
    return query2json($result1);

  }//-- fin function buscarFirmantes


  /**
      * Obtiene las sucursales a las que se puede aceder un usuario especifico
      *
      * @param varchar $modulo solo para indicar de modulo se quiere obtener el permiso
      * @param int $idUsuario usuario logueado actualmente
      *
    **/
    function buscarPermisosSucursalUsuario($modulo,$idUsuario){

      $verifica = 0;

      $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$modulo' ORDER BY orden";
      $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
      $num = mysqli_num_rows($resultM);

      if($num > 0){

        $rowsM = $resultM->fetch_assoc();
        $pantallaM=$rowsM['sistema'];
        $permisoForma=$rowsM['comando'];


        $queryP = "SELECT permisos.id_sucursal,permisos.permiso,sucursales.descr AS nombre
        FROM permisos
        INNER JOIN sucursales ON permisos.id_sucursal=sucursales.id_sucursal
        INNER JOIN
        (
        
        SELECT accesos.id_sucursal AS id_sucursal, id_usuario AS id_usuario 
        FROM accesos
        WHERE accesos.id_usuario= $idUsuario
        
        ) acc ON permisos.id_sucursal = acc.id_sucursal AND permisos.id_usuario = acc.id_usuario
        WHERE permisos.id_usuario= $idUsuario AND permisos.pantalla='$pantallaM' 
        AND sucursales.activo=1 ORDER BY sucursales.descr";
        $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
        $numP = mysqli_num_rows($resultP);

        if($numP > 0){

          $array = array();
          $cont=0;
          while($row = $resultP->fetch_assoc()){

             $permisoUsuario=$row['permiso'];
             $id_sucursal=$row['id_sucursal'];
             $nombre=$row['nombre'];

             if($this -> checaBit($permisoForma,$permisoUsuario)){
                $array[$cont]=array('id_sucursal'=>$id_sucursal,'nombre'=>$nombre);
                $cont++;
             }

          }

          if(count($array)>0){

              $verifica=json_encode($array);
          }else{

              $verifica = 0;
          }


      }else{

          $verifica = 0;
      }


    }else{

      $verifica = 0;
    }

    return $verifica;

  }//-- fin function buscarPermisosSucursalUsuario

  /**
    * Busca los puestos salarios de una unidad
    *
    * @param int $idUnidadNegocio para obtener los registros de ese id
    *
    **/
  function buscarSalariosPuestos($idUnidadNegocio,$idSucursal){
    $result1 = $this->link->query("SELECT a.id,b.puesto,a.sueldo_mensual
                                      FROM cat_salarios a
                                      LEFT JOIN cat_puestos b ON a.id_puesto=b.id_puesto
                                      WHERE a.id_unidad_negocio=$idUnidadNegocio
                                      AND a.id_sucursal=$idSucursal AND a.inactivo=0
                                      ORDER BY b.puesto");
    return query2json($result1);
  }//-- fin function buscarSalariosPuestos

  /*
   * Esta función obtiene las areas correspondientes
   **/
  function buscarAreas($idSucursal = 0)
  {
   
   if($idSucursal == '')
    $idSucursal = 0;

    $resultBA = $this->link->query("SELECT id, clave, descripcion FROM cat_areas WHERE activa = 1 and id_sucursal IN (0, $idSucursal) ORDER BY clave DESC");
    return query2json($resultBA);

  }

  /**
    * Esta función obtiene las areas correspondientes
    *
    * @param int $idSucursal id de la sucursal de la cual se mostraran los deptos
    * @param int $idArea id de area de la cual se mostraran los deptos
    *
  **/
  function  buscarDepartamentoArea($idSucursal, $idArea)
  {
    $resultDA = $this->link->query("SELECT id_depto, cve_dep, des_dep FROM deptos WHERE inactivo = 0 AND id_sucursal = $idSucursal AND id_area = $idArea");
    return query2json($resultDA);

  }

  /**
      * Busca los proveedores correspondientes a un unidad de negocio
      *
      * @param int $idSucursal id de la sucursal de la cual se mostraran los proveedores
      *
  **/
  function buscarProvedoresUnidad($idUnidad)
  {

    $resultP = $this->link->query("SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc
                                    FROM proveedores
                                   INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
                                    WHERE proveedores.inactivo = 0 AND proveedores.corporativo=0 AND proveedores_unidades.id_unidad = $idUnidad
                                    ORDER BY  proveedores.nombre");
    return query2json($resultP);

  }

  /**
    * Busca los familias activas
  **/
  function buscarFamiliasActivas()
  {

    $resultF = $this->link->query("SELECT id, clave, descripcion  FROM familias WHERE inactiva = 0");
    return query2json($resultF);

  }

  /**
    * Busca los lineas activas en base a una familia
    * @param int $idFamilia id de la familia de la cual se mostraran las lineas
  **/
  function buscarLineasActivas($idFamilia)
  {

    $resultL = $this->link->query("SELECT id, clave, descripcion  FROM lineas WHERE inactiva = 0 AND id_familia = $idFamilia");
    return query2json($resultL);

  }

  /**
    * Busca en la tabla clasificacion salidas la clasificacion a presupuestos para una salida por ajuste
  **/
  function buscarClasificacionPresupuesto(){
    $resultL = $this->link->query("SELECT id, nombre  FROM clasificacion_salidas WHERE activo = 0");
    return query2json($resultL);
  }

  /**
    * Trae todas las unidades de negocio dadas de alta y que etsen activas
  **/
  function buscarTodaUnidadesNegocio(){
    $resultL = $this->link->query("SELECT id AS id_unidad,nombre AS nombre_unidad,descripcion,logo FROM cat_unidades_negocio WHERE inactivo=0 ORDER BY id");
    return query2json($resultL);
  }

  /**
    * Busca los registros de familia gastos activos
  **/
  function buscarFamiliaGastos(){
    $result = $this->link->query("SELECT id_fam,descr AS familia_gasto,activo
                                    FROM fam_gastos
                                    WHERE activo=0
                                    ORDER BY descr");

    return query2json($result);
  }//-- fin function buscarFamiliaGastos

  /**
   * Busca las cuentas bancos activas para hacer transferencias
  **/
  function buscaCuentasBancos($idCuentaBanco,$tipo,$idsUnidadesPermiso){

    $cuenta='';

    if($idCuentaBanco != 0)
    {
      $cuenta=' AND a.id !='.$idCuentaBanco;
    }

    $cond='';
    if($tipo == 1)  ///si es tipo uno quiere decir que me debe mostrar las cuentas bancos diferentes de caja chica
    {
      $cond=' AND a.tipo = 0';   //tipo 0 son cuentas diferentes de caja chica
    }else{
      //--MUESTRA TODAS CUENTAS Y CAJAS CHICAS
      $cond='';
    }

    $condicionUnidades ='';

    if($idsUnidadesPermiso!=''){

      if (strpos($idsUnidadesPermiso, ',') !== false) {
        
        $dato=substr(trim($idsUnidadesPermiso),1);
        $condicionUnidades=' AND a.id_unidad_negocio in ('.$dato.')';
      }else{
        $condicionUnidades=' AND a.id_unidad_negocio='.$idsUnidadesPermiso;
      }

    }else{
      
      $condicionUnidades=' AND a.id_unidad_negocio =0';
    }

    /*$result = $this->link->query("SELECT a.id,a.id_banco,IF(a.tipo=1,a.descripcion,b.descripcion) AS cuenta,a.tipo,a.id_sucursal
                                  FROM cuentas_bancos a
                                  LEFT JOIN bancos b ON a.id_banco=b.id
                                  WHERE a.activa=1 $cuenta $cond
                                  ORDER BY b.clave ASC");*/
    //-->MGFS 13-02-2020 Se agrega condicion para que solo muestre las cuentas de la unidad de negocio actual si tiene permiso
    //-->NJES Se unifica para que en todos los casos se muestre la descripción de la cuenta_banco Dic/19/2019<--//
    $result = $this->link->query("SELECT a.id,a.id_banco,a.descripcion AS cuenta,a.tipo,a.id_sucursal
                                  FROM cuentas_bancos a
                                  LEFT JOIN bancos b ON a.id_banco=b.id
                                  WHERE a.activa=1 $cuenta $cond $condicionUnidades
                                  ORDER BY a.tipo,b.clave ASC");

    return query2json($result);
  }//-- fin function buscaCuentasBancos

  /**
   * Busca las cuentas Tipos Ingresos activos
  **/
  function buscaTiposIngresos(){

    $result = $this->link->query("SELECT id,descripcion
    FROM cat_tipos_ingreso
    WHERE inactivo=0
    ORDER BY descripcion ASC");

    return query2json($result);
  }//-- fin function buscaTiposIngresos

  function buscaConceptosCxP($tipo){
    $result = $this->link->query("SELECT id, clave,CONCAT(clave,' ',descripcion) AS concepto
                                  FROM conceptos_cxp
                                  WHERE tipo=$tipo
                                  ORDER BY clave ASC");

    return query2json($result);
  }//-- fin function buscaConceptosCxP

  function buscaConceptosCxPPagos($tipo){
    $result = $this->link->query("SELECT id, clave,CONCAT(clave,' ',descripcion) AS concepto
                                  FROM conceptos_cxp
                                  WHERE tipo=$tipo AND clave != 'C04' AND clave != 'A08' 
                                  ORDER BY clave ASC");

    return query2json($result);
  }//-- fin function buscaConceptosCxPPagos

  function buscaConceptosCxPAbonos(){
    $result = $this->link->query("SELECT id, clave,CONCAT(clave,' ',descripcion) AS concepto
                                  FROM conceptos_cxp
                                  WHERE tipo=1 AND clave != 'A02' AND SUBSTR(clave,1,1) != 'C'
                                  ORDER BY clave ASC");

    return query2json($result);
  }//-- fin function buscaConceptosCxPAbonos

  /****** si trae el idFamiliaGastos gastos mayor a 0 se busca por familia sinno muestra todos  */
  function buscaClasificacionGastos($idFamiliaGastos){

    $condicion='';

    if($idFamiliaGastos>0){
      $condicion=" AND  (id_fam=".$idFamiliaGastos." OR id_fam=0)";
    }

    $result = $this->link->query("SELECT id_clas AS id, descr AS clasificacion
    FROM gastos_clasificacion
    WHERE activo=0 $condicion
    ORDER BY descr ASC");

    return query2json($result);
  }//-- fin function buscaClasificacionGastos


  /**
    * Esta función obtiene las areas correspondientes
    *
    * @param int $idSucursal id de la sucursal de la cual se mostraran los deptos
    * @param int $idArea id de area de la cual se mostraran los deptos
    *
  **/
  function  buscarDepartamentoAreaInternos($idSucursal, $idArea)
  {
    $condicionArea ='';
   
    if($idArea>0){
      $condicionArea="AND id_area =".$idArea;
    }
    

    $resultDA = $this->link->query("SELECT id_depto, cve_dep, des_dep FROM deptos WHERE inactivo = 0 AND tipo='I' AND id_sucursal = $idSucursal $condicionArea");
    return query2json($resultDA);

  }

  /**
      * Obtiene las sucursales a las que se puede aceder de una unidad de negocio un usuario especifico
      *
      * @param int $idUnidadNegocio dato que dice en que unidad de negocio se encuentra actialmente
      * @param varchar $modulo solo para indicar de modulo se quiere obtener el permiso
      * @param int $idUsuario usuario logueado actualmente
      *
    **/
    function buscarPermisosSucursalListaId($idUnidadNegocio,$modulo,$idUsuario){

      $verifica = '';

      if($idUnidadNegocio != ''){
        if($idUnidadNegocio[0] == ',')
        {
          $dato=substr($idUnidadNegocio,1);
          $unidades = ' permisos.id_unidad_negocio IN('.$dato.') ';
        }else{
          $unidades = ' permisos.id_unidad_negocio ='.$idUnidadNegocio;
        }
      }

      $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$modulo' ORDER BY orden";
      $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
      $num = mysqli_num_rows($resultM);

      if($num > 0){

        $rowsM = $resultM->fetch_assoc();
        $pantallaM=$rowsM['sistema'];
        $permisoForma=$rowsM['comando'];


        $queryP = "SELECT permisos.id_sucursal,permisos.permiso,sucursales.descr as nombre FROM permisos LEFT JOIN sucursales ON permisos.id_sucursal=sucursales.id_sucursal WHERE $unidades AND permisos.id_usuario=$idUsuario AND permisos.pantalla='$pantallaM' AND sucursales.activo=1 ORDER BY sucursales.descr";
        $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error($this->link));
        $numP = mysqli_num_rows($resultP);

        if($numP > 0){

          $lista = '';
          $cont=0;
          while($row = $resultP->fetch_assoc()){

             $permisoUsuario=$row['permiso'];
             $id_sucursal=$row['id_sucursal'];
             $nombre=$row['nombre'];

             if($this -> checaBit($permisoForma,$permisoUsuario)){
                $lista .= ','.$id_sucursal;
                $cont++;
             }

          }

          $verifica = $lista;

      }else{
        $verifica = '';
      }


    }else{
      $verifica = '';
    }

    return $verifica;

  }//-- fin function buscarPermisosSucursalLista
  //buscarClasificacionViaticos
  /**
    * Esta función obtiene la clasificación de viaticos
    *
  **/
  function  buscarClasificacionViaticos()
  {

    $resultDA = $this->link->query("SELECT id, descripcion FROM viaticos_clasificacion ORDER BY descripcion ASC");
    return query2json($resultDA);

  }

  function buscarTodaUnidadesNegocioTodas()
  {

    $resultado = $this->link->query("SELECT id as id_unidad, nombre as nombre_unidad, logo as logo FROM cat_unidades_negocio");
    return query2json($resultado);
  }

  function buscarRazonesSocialesCliente($idCliente,$idUnidadNegocio)
  {

    $result = $this->link->query("SELECT a.id,a.razon_social,a.nombre_corto,a.dias_cred,a.rfc,a.codigo_postal,a.id_pais, ifnull(a.correo_facturas,'') as correo_facturas, a.adenda AS adenda, regimen_fiscal
                                  FROM razones_sociales a
                                  LEFT JOIN razones_sociales_unidades b ON a.id=b.id_razon_social
                                  WHERE a.id_cliente=$idCliente AND a.activo=1 AND b.id_unidad=$idUnidadNegocio
                                  GROUP BY a.id
                                  ORDER BY a.razon_social ASC");

    return query2json($result);

  }

  function buscarUsoCFDI(){
    $result = $this->link->query("SELECT clave,descripcion FROM cat_uso_cfdi");
    return query2json($result);
  }

  function buscarMetodoPago(){
    $result = $this->link->query("SELECT clave,descripcion FROM cat_metodo_pago");
    return query2json($result);
  }

  function buscarFormaPago($tipo)
  {

    $condicion = '';
    if($tipo == 'PUE')
      $condicion = ' WHERE clave!=99';
    else if($tipo == 'PPD')
      $condicion = ' WHERE clave=99';

    $result = $this->link->query("SELECT clave,descripcion FROM cat_formas_pago $condicion");

    return query2json($result);

  }

  function buscarClaveProductoSAT()
  {
    $query = "SELECT clave AS claves FROM cat_servicios_sat ORDER BY clave ASC";
    $resultB = mysqli_query($this->link, $query) or die(mysqli_error());

    if($resultB)
    {

      $array =array();
      while($result = $resultB->fetch_assoc())
      {
        array_push($array, $result['claves']);
      }

     $claves = implode(',', $array);

      $result = $this->linkCFDI->query("SELECT c_clave_prod_serv,descripcion FROM cat_productos_servicios
                                        WHERE c_clave_prod_serv IN($claves) ORDER BY descripcion ASC");

      return query2json($result);
    }

  }

  /*
  function buscarClaveProductoSAT(){
    $query = "SELECT GROUP_CONCAT(clave) AS claves FROM cat_servicios_sat ORDER BY clave ASC";
    $resultB = mysqli_query($this->link, $query) or die(mysqli_error());

    if($resultB)
    {
      $datos=mysqli_fetch_array($resultB);
      $claves=$datos['claves'];

      $result = $this->linkCFDI->query("SELECT c_clave_prod_serv,descripcion FROM cat_productos_servicios
                                        WHERE c_clave_prod_serv IN($claves) ORDER BY descripcion ASC");
      return query2json($result);
    }

  }
  */

  function buscarClaveUnidadesSAT(){
    $query = "SELECT clave FROM cat_unidades_sat ORDER BY clave ASC";
    $resultB = mysqli_query($this->link, $query) or die(mysqli_error());

    $claves='';
    if($resultB)
    {
      $num=mysqli_num_rows($resultB);
      for($i=1;$i<=$num;$i++){
        $datos=mysqli_fetch_array($resultB);
        $clave=$datos['clave'];

        if($i==$num)
        {
          $claves=$claves."'".$clave."'";
        }else{
          $claves=$claves."'".$clave."',";
        }
      }

      $result = $this->linkCFDI->query("SELECT c_clave_unidad,nombre FROM cat_unidades_medida
                                        WHERE c_clave_unidad IN($claves) ORDER BY nombre ASC");
      return query2json($result);
    }

  }
  // - - - - - - - - - - - - - - - - - - - - -
  // Ativos Fijos modulo - fr_activos.php
  // - - - - - - - - - - - - - - - - - - - - -
  // Select Marcas de Celular Acordeon Celular
  function buscarMarcasCelulares(){
    $sql= "SELECT id, marca FROM celulares_marcas ORDER BY(marca) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }
  // Select Compañias de Celular Acordeon Celular
  function buscarCompaniasCelulares(){
    $sql= "SELECT id, compania FROM celulares_companias ORDER BY(compania) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }

  // Select Marcas de Acordeon Equipo de Computo
  function buscarMarcasEComputo(){
    $sql= "SELECT id, marca FROM equipo_computo_marcas ORDER BY(marca) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }
  // Select Compañias de Celular Acordeon Celular
  function buscarTiposEComputo(){
    $sql= "SELECT id, tipo FROM equipo_computo_tipo ORDER BY(tipo) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }

  // Select Marcas de Acordeon Vehiculo
  function buscarMarcasVehiculo(){
    $sql= "SELECT id, marcas FROM vehiculos_marcas ORDER BY(marcas) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }
  // Select Compañias de Tipos Acordeon Vehiculo
  function buscarTiposVehiculo(){
    $sql= "SELECT id, tipos FROM vehiculos_tipos ORDER BY(tipos) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }

  // Select planes de servicios_cat_planes
  function buscarPlanes($idSucursal){
    //$sql= "SELECT id, descripcion,cantidad,tipo FROM servicios_cat_planes ORDER BY(descripcion) ASC";
    $sql= "SELECT id, descripcion,cantidad,tipo 
          FROM servicios_cat_planes 
          WHERE id_sucursal LIKE '%$idSucursal%' 
          ORDER BY(descripcion) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
    
  }

  // select Clasificacion de servicios de la tabla  servicios_clasificacion
  function buscarClasificacionServicios(){
    $sql= "SELECT id, descripcion,cantidad FROM servicios_clasificacion ORDER BY(descripcion) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }

  function buscaConceptosCxCAlarmas($tipo){
    $result = $this->link->query("SELECT id, clave,CONCAT(clave,' ',descripcion) AS concepto
                                  FROM conceptos_cxc_alarmas
                                  WHERE tipo=$tipo
                                  ORDER BY clave ASC");

    return query2json($result);
  }//-- fin function buscaConceptosCxP

  function buscarSalariosRazonSocial($idRazonSocial){
    $result = $this->link->query("SELECT id,salario_diario
                                  FROM cat_cuotas_obrero
                                  WHERE id_razon_social=$idRazonSocial AND inactivo=0
                                  ORDER BY id ASC");

    return query2json($result);
  }

  function buscarProvedoresCorporativo($idUnidad)
  {

    $resultP = $this->link->query("SELECT sub.id, sub.nombre, sub.rfc 
    FROM (
      SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc
      FROM proveedores
      INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
      WHERE proveedores.inactivo = 0 AND  proveedores_unidades.id_unidad = ".$idUnidad."
      UNION 
      SELECT proveedores.id AS id, proveedores.nombre, proveedores.rfc
      FROM proveedores
      INNER JOIN proveedores_unidades ON proveedores.id = proveedores_unidades.id_proveedor
      WHERE proveedores.inactivo = 0 AND  proveedores.corporativo=1
          )AS sub
    ORDER BY sub.nombre ASC");
    return query2json($resultP);

  }

  function buscarFamiliaAlarmas(){
    $result = $this->link->query("SELECT id, clave,descripcion FROM familias WHERE familia_alarmas = 1 AND inactiva = 0 LIMIT 1");

    return query2json($result);
  }


  /**
   * Busca las cuentas tipo caja chica activas y de sucursal donde se realizó el viatico para reposicion (devolucion) de viaticos 
  **/
  function buscaCuentaCajaChica($idSucursal){

    $idSucursal = (isset($idSucursal)>0)?$idSucursal:0;

    $condicionSucursal='';

    if($idSucursal>0){
      
      $condicionSucursal="AND a.id_sucursal=".$idSucursal;
    }
 
    $result = $this->link->query("SELECT a.id,a.id_banco,a.descripcion AS cuenta,a.tipo,a.id_sucursal
                                  FROM cuentas_bancos a
                                  LEFT JOIN bancos b ON a.id_banco=b.id
                                  WHERE a.activa=1 AND a.tipo=1 $condicionSucursal 
                                  ORDER BY b.clave ASC");

    return query2json($result);
  }//-- fin function buscaCuentaCajaChica

  function buscaEmpresasFiscales()
  {

      $result = $this->link->query("SELECT id_empresa, razon_social FROM empresas_fiscales");

      return query2json($result);

  }

  /**
   * Busca las cuentas bancos y sus saldos activas para hacer transferencias
  **/
  function buscaCuentasBancosSaldos($idCuentaBanco,$tipo,$idsUnidadesPermiso){

    $cuenta='';

    if($idCuentaBanco != 0)
    {
      $cuenta=' AND a.id !='.$idCuentaBanco;
    }else{
      $cuenta='';
    }

    $cond='';
    if($tipo == 1)  ///si es tipo uno quiere decir que me debe mostrar las cuentas bancos diferentes de caja chica
    {
      $cond=' AND a.tipo = 0';   //tipo 0 son cuentas diferentes de caja chica
    }else{
      $cond='';
    }
    //--MGFS se cambia condicion AND a.id_unidad_negocio=".$idUnidadNegocio." por $condicionUnidades
    $condicionUnidades ='';

    if($idsUnidadesPermiso!=''){

      if (strpos($idsUnidadesPermiso, ',') !== false) {
        
        $dato=substr(trim($idsUnidadesPermiso),1);
        $condicionUnidades=' AND a.id_unidad_negocio in ('.$dato.')';
      }else{
        $condicionUnidades=' AND a.id_unidad_negocio='.$idsUnidadesPermiso;
      }

    }else{
      
      $condicionUnidades=' AND a.id_unidad_negocio =0';
    }

    $query = "SELECT 
                a.id,
                a.id_banco,
                a.descripcion AS cuenta,
                a.tipo,
                a.id_sucursal,
                IFNULL(tabla.saldo_disponible, 0) AS saldo_disponible
              FROM cuentas_bancos a
              LEFT JOIN bancos b ON a.id_banco=b.id
              LEFT JOIN caja_chica c ON a.id_sucursal=c.id_sucursal
              LEFT JOIN movimientos_bancos d ON a.id = d.id_cuenta_banco
              LEFT JOIN (
                SELECT cb.id, sd.cantidad + (SUM(IF(mb.tipo = 'I' OR mb.tipo = 'A' OR (mb.tipo = 'T' AND mb.transferencia <> 0),mb.monto,0)) - SUM(IF(mb.tipo = 'C' OR (mb.tipo = 'T' AND mb.transferencia = 0),mb.monto,0))) as saldo_disponible
                FROM saldos_diarios sd
                INNER JOIN cuentas_bancos cb ON cb.id = sd.id_cuenta_banco
                LEFT JOIN movimientos_bancos mb ON mb.id_cuenta_banco = cb.id AND DATE(mb.fecha) = DATE(NOW())
                WHERE sd.fecha = (SELECT MAX(t2.fecha)
                                        FROM saldos_diarios t2
                                        WHERE t2.id_cuenta_banco = sd.id_cuenta_banco)
                GROUP BY sd.id_cuenta_banco
              ) as tabla ON tabla.id = a.id
              WHERE a.activa=1 $cuenta $cond $condicionUnidades
              GROUP BY a.id
              ORDER BY b.clave ASC";

              // echo $query;
              // exit();
    //-->NJES Se unifica para que en todos los casos se muestre la descripción de la cuenta_banco Dic/19/2019<--//
    $result = $this->link->query($query);

    return query2json($result);
  }//-- fin function buscaCuentasBancosSaldos

  /**
      * Obtiene las sucursales a las que se puede aceder de una unidad de negocio un usuario especifico
      * solo muestra las sucursales que tengan una cuenta banco caja chica
      *
      * @param int $idUnidadNegocio dato que dice en que unidad de negocio se encuentra actialmente
      * @param varchar $modulo solo para indicar de modulo se quiere obtener el permiso
      * @param int $idUsuario usuario logueado actualmente
      *
    **/
    function buscarPermisosSucursalCajaChica($idUnidadNegocio,$modulo,$idUsuario){

      $verifica = 0;

      $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$modulo' ORDER BY orden";
      $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
      $num = mysqli_num_rows($resultM);

      if($num > 0){

        $rowsM = $resultM->fetch_assoc();
        $pantallaM=$rowsM['sistema'];
        $permisoForma=$rowsM['comando'];


        $queryP = "SELECT permisos.id_sucursal,permisos.permiso,sucursales.descr as nombre FROM permisos LEFT JOIN sucursales ON permisos.id_sucursal=sucursales.id_sucursal WHERE permisos.id_unidad_negocio = $idUnidadNegocio AND permisos.id_usuario=$idUsuario AND permisos.pantalla='$pantallaM' AND sucursales.activo=1 ORDER BY sucursales.descr";
        $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
        $numP = mysqli_num_rows($resultP);

        if($numP > 0){

          $array = array();
          $cont=0;
          while($row = $resultP->fetch_assoc()){

            $permisoUsuario=$row['permiso'];
            $id_sucursal=$row['id_sucursal'];
            $nombre=$row['nombre'];

            if($this -> checaBit($permisoForma,$permisoUsuario)){
              $queryCC = "SELECT id FROM cuentas_bancos WHERE id_sucursal = $id_sucursal  AND activa=1 AND tipo=1";
              $resultCC = mysqli_query($this->link, $queryCC)or die(mysqli_error());
              $numCC = mysqli_num_rows($resultCC);
              
              if($numCC > 0)
              {
                $array[$cont]=array('id_sucursal'=>$id_sucursal,'nombre'=>$nombre);
                $cont++;
              }
              
            }

          }

          if(count($array)>0){

              $verifica=json_encode($array);
          }else{

              $verifica = 0;
          }


      }else{

          $verifica = 0;
      }


    }else{

      $verifica = 0;
    }

    return $verifica;

  }//-- fin function buscarPermisosSucursalCajaChica

  //-->NJES Jan/21/2020  busca las cuentas banco tipo banco y la cuenta caja chica de la sucursal y unidad seleccionada
  function buscaCuentasBancosCajaChicaSucursal($idUnidadNegocio,$idSucursal){
    $result = $this->link->query("SELECT a.id,a.id_banco,a.descripcion AS cuenta,a.tipo,a.id_sucursal
                                  FROM cuentas_bancos a
                                  LEFT JOIN bancos b ON a.id_banco=b.id
                                  WHERE a.activa=1 AND a.tipo=0 OR (a.id_unidad_negocio=1 AND a.id_sucursal=1 AND a.tipo=1)
                                  ORDER BY b.clave ASC");

    return query2json($result);
  }//-- fin function buscaCuentasBancosCajaChicaSucursal

   /**
   * Busca las cuentas bancos y sus saldos activas para hacer transferencias
  **/
  function buscaCuentasBancosSaldosPermiso($idCuentaBanco,$tipo,$idsUnidadesPermiso){

    $condicionUnidades ='';

    if($idsUnidadesPermiso!=''){

      if (strpos($idsUnidadesPermiso, ',') !== false) {
        
        $dato=substr(trim($idsUnidadesPermiso),1);
        $condicionUnidades=' AND a.id_unidad_negocio in ('.$dato.')';
      }else{
        $condicionUnidades=' AND a.id_unidad_negocio='.$idsUnidadesPermiso;
      }

    }else{
      
      $condicionUnidades=' AND a.id_unidad_negocio =0';
    }

    $cuenta='';

    if($idCuentaBanco != 0)
    {
      $cuenta=' AND a.id !='.$idCuentaBanco;
    }else{
      $cuenta='';
    }

    $cond='';
    if($tipo == 1)  ///si es tipo uno quiere decir que me debe mostrar las cuentas bancos diferentes de caja chica
    {
      $cond=' AND a.tipo = 0';   //tipo 0 son cuentas diferentes de caja chica
    }else{
      $cond='';
    }

    $query = "SELECT 
                a.id,
                a.id_banco,
                a.descripcion AS cuenta,
                a.tipo,
                a.id_sucursal,
                IFNULL(tabla.saldo_disponible, 0) AS saldo_disponible
              FROM cuentas_bancos a
              LEFT JOIN bancos b ON a.id_banco=b.id
              LEFT JOIN caja_chica c ON a.id_sucursal=c.id_sucursal
              LEFT JOIN movimientos_bancos d ON a.id = d.id_cuenta_banco
              LEFT JOIN (SELECT cb.id, sd.cantidad + (SUM(IF(mb.tipo = 'I' OR mb.tipo = 'A' OR (mb.tipo = 'T' AND mb.transferencia <> 0),mb.monto,0)) - SUM(IF(mb.tipo = 'C' OR (mb.tipo = 'T' AND mb.transferencia = 0),mb.monto,0))) as saldo_disponible
                          FROM saldos_diarios sd
                          INNER JOIN cuentas_bancos cb ON cb.id = sd.id_cuenta_banco
                          LEFT JOIN movimientos_bancos mb ON mb.id_cuenta_banco = cb.id AND DATE(mb.fecha) = DATE(NOW())
                          WHERE sd.fecha = (SELECT MAX(t2.fecha)
                                          FROM saldos_diarios t2
                                          WHERE t2.id_cuenta_banco = sd.id_cuenta_banco)
                          GROUP BY sd.id_cuenta_banco
                          ) AS tabla ON tabla.id = a.id
              WHERE a.activa=1 $cuenta $cond  $condicionUnidades 
              GROUP BY a.id
              ORDER BY b.clave ASC";

    // echo $query;
    // exit();
    //-->NJES Se unifica para que en todos los casos se muestre la descripción de la cuenta_banco Dic/19/2019<--//
    $result = $this->link->query($query);

    return query2json($result);
  }//-- fin function buscaCuentasBancosSaldos

  /**
   * Busca las cuentas bancos activas para hacer transferencias
  **/
  function buscaCuentasBancosUnidad($idCuentaBanco,$tipo,$idUnidadNegocio){

    $cuenta='';

    if($idCuentaBanco != 0)
    {
      $cuenta=' AND a.id !='.$idCuentaBanco;
    }

    $cond='';
    if($tipo == 1)  ///si es tipo uno quiere decir que me debe mostrar las cuentas bancos diferentes de caja chica
    {
      $cond=' AND a.tipo = 0';   //tipo 0 son cuentas diferentes de caja chica
    }else{
      //--MUESTRA TODAS CUENTAS Y CAJAS CHICAS
      $cond='';
    }
    $result = $this->link->query("SELECT a.id,a.id_banco,a.descripcion AS cuenta,a.tipo,a.id_sucursal
                                  FROM cuentas_bancos a
                                  LEFT JOIN bancos b ON a.id_banco=b.id
                                  WHERE a.activa=1 $cuenta $cond AND a.id_unidad_negocio=".$idUnidadNegocio."
                                  ORDER BY a.tipo,b.clave ASC");

    return query2json($result);
  }//-- fin function buscaCuentasBancos

  /**
   * Busca las cuentas bancos y sus saldos activas para hacer transferencias
  **/
  function buscaCuentasBancosSaldosUnidad($idCuentaBanco,$tipo,$idUnidadNegocio){

    $cuenta='';

    if($idCuentaBanco != 0)
    {
      $cuenta=' AND a.id !='.$idCuentaBanco;
    }else{
      $cuenta='';
    }

    $cond='';
    if($tipo == 1)  ///si es tipo uno quiere decir que me debe mostrar las cuentas bancos diferentes de caja chica
    {
      $cond=' AND a.tipo = 0';   //tipo 0 son cuentas diferentes de caja chica
    }else{
      $cond='';
    }
    
    //-->NJES Se unifica para que en todos los casos se muestre la descripción de la cuenta_banco Dic/19/2019<--//
    $result = $this->link->query("SELECT 
      a.id,
      a.id_banco,
      a.descripcion AS cuenta,
      a.tipo,
      a.id_sucursal,
      IF(a.tipo=1,(IFNULL(SUM(IF(c.clave_concepto IN('C01','D01'),c.importe,c.importe*(-1))),0)),
      (IFNULL((SUM(IF(d.tipo='A',monto,0))+SUM(IF(d.tipo='I',d.monto,0))+SUM(IF(d.tipo='T' && d.transferencia >0,d.monto,0)))-(SUM(IF(d.tipo='C',d.monto,0))+SUM(IF(d.tipo='T' && d.transferencia = 0,d.monto,0))),0))) AS saldo_disponible
    FROM cuentas_bancos a
    LEFT JOIN bancos b ON a.id_banco=b.id
    LEFT JOIN caja_chica c ON a.id_sucursal=c.id_sucursal
    LEFT JOIN movimientos_bancos d ON a.id = d.id
    WHERE a.activa=1 $cuenta $cond AND a.id_unidad_negocio=".$idUnidadNegocio."
    GROUP BY a.id
    ORDER BY b.clave ASC");

    return query2json($result);
  }//-- fin function buscaCuentasBancosSaldosUnidad

  //-->NJES April/29/2020 se agregan opciones para buscar los combos de marcas y clases armas en activos fijos
  function buscarClasesArmas(){
    $sql= "SELECT id, clase FROM armas_clases ORDER BY(clase) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }

  function buscarMarcasArmas(){
    $sql= "SELECT id, marca FROM armas_marcas ORDER BY(marca) ASC";
    $resultB = mysqli_query($this->link, $sql) or die(mysqli_error());

    if($resultB)
    {
      return query2json($resultB);
    }
  }

  /*busca las unidades donde tenga minimo una sucursal con permiso, por usuario y modulo*/
  function buscarPermisosUnidadesUsuario($modulo,$idUsuario,$listaIdUnidades){

    $verifica = 0;

    $idsUnidades=substr($listaIdUnidades,1);

    $queryM = "SELECT sistema,comando FROM menus WHERE menuid = '$modulo' ORDER BY orden";
    $resultM = mysqli_query($this->link, $queryM)or die(mysqli_error());
    $num = mysqli_num_rows($resultM);

    if($num > 0)
    {

      $rowsM = $resultM->fetch_assoc();
      $pantallaM=$rowsM['sistema'];
      $permisoForma=$rowsM['comando'];


      $queryP = "SELECT permisos.id_unidad_negocio,cat_unidades_negocio.logo,MAX(permisos.permiso) AS permiso,cat_unidades_negocio.nombre AS unidad_negocio 
                  FROM permisos 
                  LEFT JOIN cat_unidades_negocio ON permisos.id_unidad_negocio=cat_unidades_negocio.id
                  LEFT JOIN sucursales ON permisos.id_sucursal=sucursales.id_sucursal 
                  INNER JOIN accesos ON cat_unidades_negocio.id=accesos.id_unidad_negocio AND  sucursales.id_sucursal=accesos.id_sucursal  AND accesos.id_usuario=$idUsuario
                  WHERE  permisos.id_usuario=$idUsuario
                  AND permisos.id_unidad_negocio IN(".$idsUnidades.")
                  AND permisos.pantalla='$pantallaM'
                  AND cat_unidades_negocio.inactivo=0 
                  AND sucursales.activo=1 
                  GROUP BY permisos.id_unidad_negocio
                  ORDER BY cat_unidades_negocio.nombre";
      $resultP = mysqli_query($this->link, $queryP)or die(mysqli_error());
      $numP = mysqli_num_rows($resultP);

      if($numP > 0)
      {

        $array = array();
        $cont=0;
        while($row = $resultP->fetch_assoc()){

           $permisoUsuario=$row['permiso'];
           $logo=$row['logo'];
           $id_unidad_negocio=$row['id_unidad_negocio'];
           $nombre=$row['unidad_negocio'];

           if($this -> checaBit($permisoForma,$permisoUsuario)){
              $array[$cont]=array('id_unidad_negocio'=>$id_unidad_negocio,'logo'=>$logo,'nombre'=>$nombre);
              $cont++;
           }

        }

        if(count($array)>0)
        {

            $verifica=json_encode($array);
        }else{

            $verifica = 0;
        }


      }else{

          $verifica = 0;
      }


    }else{

      $verifica = 0;
    }

    return $verifica;

  }

  function buscarTiposPanel(){
    $result = $this->link->query("SELECT id,nombre FROM tipo_panel ORDER BY nombre ASC");

    return query2json($result);
  }

}//--fin de class Combos

?>
