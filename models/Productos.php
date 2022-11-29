<?php

require_once('conectar.php');
require_once('Lineas.php');  //--> cuando se hace una instancia a otro modelo, el otro debe tener
                            //tambien los archivos que use como require_once para que los lea en el momento

class Productos
{

    public $link;

    function Productos()
    {
  
      $this->link = Conectarse();

    }
        /**
      * Verifica que el nombre en clave no se repita
      *
      * @param varchar $clave  usado para ingresar al sistema
      *
      **/
      function verificarProductos($clave){
      
        $verifica = 0;
  
        $query = "SELECT id FROM productos WHERE clave = '$clave'";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);
  
        if($num > 0)
          $verifica = 1;
  
         return $verifica;
  
      }//-- fin function verificaProductos
  
      /**
        * Manda llamar a la funcion que guarda la informacion sobre un producto
        *
        **/      
      function guardarProductos($datos){
      
          $verifica = 0;
  
         $this->link->begin_transaction();
         $this->link->query("START TRANSACTION;");
  
          $verifica = $this -> guardarActualizar($datos);
  
          if($verifica > 0)
              $this->link->query("commit;");
          else
              $this->link->query('rollback;');
  
          return $verifica;
  
      } //-- fin function guardarProductos
  
  
       /**
        * Guarda los datos de un producto, regresa el id del producto afectado si se realiza la accion correctamete ó 0 si ocurre algun error
        * 
        * @param int $tipo_mov si tipo es 0 es una insercion si tipo=1 es una actualización
        * @param varchar $clave es una clave para identificar un producto
        * @param varchar $descripcion brebe descripcion de un producto
        * @param int $idFamilia  id de la familia a la que se va asignar
        * @param int $idLinea  id de la familia a la que se va asignar
        * @param varchar $concepto  de un producto
        * @param varchar  $descripcion brebe descripcion de un producto
        * @param int  $servicio indica si el producto es un servicio 1=si 0=no
        * @param int  $codigo_barras codigo con el que se identyifica el producto
        * @param double  $costo del prodcto
        * @param int  $iva del prodcto
        * @param int $inactivo estatus de un producto 0='Activa' 1='inactivo'  
        *
        **/ 
        function guardarActualizar($datos){
            
          $verifica = 0;
  
          $idProducto = $datos[1]['idProducto'];
          $tipo_mov = $datos[1]['tipo_mov'];
          $clave = $datos[1]['clave'];
          $idFamilia = $datos[1]['idFamilia'];
          $idLinea = $datos[1]['idLinea'];
          $idClasif = $datos[1]['idClasif'];
          $concepto = $datos[1]['concepto'];
          $servicio = $datos[1]['servicio'];
          $codigo_barras = $datos[1]['codigoBarras'];
          $costo = $datos[1]['costo'];
          $costoOriginal = $datos[1]['costoOriginal'];
          $iva = $datos[1]['iva'];
          $inactivo = $datos[1]['inactivo'];
          $idUnidad = $datos[1]['idUnidad'];
          $idUsuario = $datos[1]['idUsuario'];

          if($tipo_mov==0){
  
            $query = "INSERT INTO productos(clave,id_familia,id_linea,concepto,servicio,codigo_barras,costo,iva,inactivo, id_clas) VALUES ('$clave','$idFamilia','$idLinea','$concepto','$servicio','$codigo_barras','$costo','$iva','$inactivo', '$idClasif')";
            $result = mysqli_query($this->link, $query) or die(mysqli_error());
            $idProducto = mysqli_insert_id($this->link);

            //-->NJES April/28/2020 si es un nuevo registro y es de familia uniformes crear registro equivalente usado
            // con la familia 9 (uniforme usado) y asignarselo
            if($idFamilia == 1)
            {
              $obtenLineaEU = new Lineas();

              $claveEU = $clave.'-EU';
              $conceptoEU = $concepto.' USADO';
              $idLineaEU = $obtenLineaEU->buscarLineaUsadoIdLinea($idLinea);

              $queryEU = "INSERT INTO productos(clave,id_familia,id_linea,concepto,servicio,codigo_barras,costo,iva,inactivo, id_clas) VALUES 
              ('$claveEU',9,'$idLineaEU','$conceptoEU','$servicio','$codigo_barras','$costo','$iva','$inactivo', $idClasif)";
              $resultEU = mysqli_query($this->link, $queryEU) or die(mysqli_error());
              $idProductoEU = mysqli_insert_id($this->link);

              if($resultEU){
                $actualiza = "UPDATE productos SET equivalente_usado='$idProductoEU' WHERE id=".$idProducto;
                $result_a = mysqli_query($this->link, $actualiza) or die(mysqli_error());

                if($result_a)
                  $verifica = $idProducto;
              }
              
            }else
                $verifica = $idProducto;
          }else{
  
            $query = "UPDATE productos SET clave='$clave',id_familia='$idFamilia',id_linea='$idLinea',concepto='$concepto',servicio='$servicio',codigo_barras='$codigo_barras',costo='$costo',iva='$iva',inactivo='$inactivo',id_clas='$idClasif' WHERE id=".$idProducto;
            $result = mysqli_query($this->link, $query) or die(mysqli_error());

            if($result){
              if( $costo != $costoOriginal){
                $guardaPrecioPB="INSERT INTO productos_bitacora (modulo,id_producto,nuevo_costo,id_usuario_captura,id_unidad_negocio)values('PRODUCTOS','$idProducto','$costo','$idUsuario','$idUnidad')"; 
                $resultGuardaPrecioPB = mysqli_query($this->link, $guardaPrecioPB) or die(mysqli_error());
                
                if($resultGuardaPrecioPB)
                  $verifica = $idProducto;
              }else
                $verifica = $idProducto;
            }
      
          }
          
          //if ($result) 
            //$verifica = $idProducto;  
  
          
          return $verifica;
        }
  
      
      /**
        * Busca los datos de un producto, retorna un JSON con los datos correspondientes
        * 
        * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=inactivos 2=todos
        *
        **/
        function buscarProductos($estatus){
  
          $condicionEstatus='';
  
          if($estatus==1){ //los inactivos
            $condicionEstatus=' WHERE inactivo=1';
          }
          if($estatus==0){ //los activos
            $condicionEstatus=' WHERE inactivo=0';
          }
  
          $resultado = $this->link->query("SELECT
          productos.id AS id,
          productos.clave AS clave,
          productos.concepto AS concepto,
          productos.inactivo AS inactivo,
          familias.descripcion AS familia,
          familias.id_familia_gasto,
          lineas.descripcion AS linea
          FROM productos
          INNER JOIN familias ON productos.id_familia = familias.id
          INNER JOIN lineas ON productos.id_linea = lineas.id
          $condicionEstatus
          ORDER BY productos.id asc");
          return query2json($resultado);
  
        }//- fin function buscarProductos
         /**
        * Busca los datos de un producto, retorna un JSON con los datos correspondientes
        * 
        * @param int $estatus indica el estatus que debe tener el registro 0=activos 1=inactivos 2=todos
        *
        **/
        function buscarProductosFiltros($idFamilia,$idLinea){
  
          $condicionFamilia='';
          $condicionLinea='';
  
          if($idFamilia>0){
            $condicionFamilia=' AND productos.id_familia='.$idFamilia;
          }
          if($idLinea>0){
            $condicionLinea=' AND productos.id_linea='.$idLinea;
          }

          $query = "SELECT
                      productos.id AS id,
                      productos.clave AS clave,
                      productos.concepto AS concepto,
                      productos.inactivo AS inactivo,
                      familias.descripcion AS familia,
                      familias.id_familia_gasto,
                      lineas.descripcion AS linea,
                      IFNULL(sub.equivalente_usado,0) AS equivalente
                    FROM productos
                    INNER JOIN familias ON productos.id_familia = familias.id
                    INNER JOIN lineas ON productos.id_linea = lineas.id
                    LEFT JOIN 
                      (
                        SELECT equivalente_usado FROM productos WHERE equivalente_usado>0
                      ) sub ON productos.id=sub.equivalente_usado
                    WHERE 1=1 $condicionFamilia $condicionLinea
                    HAVING equivalente = 0
                    ORDER BY productos.id asc";

          $resultado = $this->link->query($query);
          return query2json($resultado);
  
        }//- fin function buscarProductos
        //--MGFS 22-10-2019  El campo "costo" se actualizará según el último precio de compra pero será posible modificarlo. Cuando se modifique, se agregará en bitácora el cambio.
        function buscarProductosId($idProducto){

          $query = "SELECT
                      productos.id AS id,
                      productos.equivalente_usado,
                      productos.clave AS clave,
                      productos.concepto AS concepto,
                      productos.descripcion AS descripcion,
                      productos.id_familia AS id_familia,
                      productos.id_linea AS id_linea,
                      productos.costo AS costo,
                      productos.servicio AS servicio,
                      productos.codigo_barras AS codigo_barras,
                      productos.iva AS iva,
                      productos.inactivo AS inactivo,
                      familias.descripcion AS familia,
                      familias.id_familia_gasto,
                      IFNULL(gastos_clasificacion.id_clas,0) AS id_clasif,
                      IFNULL(gastos_clasificacion.descr,'') AS descr_clasif,
                      lineas.descripcion AS linea
                    FROM productos
                    INNER JOIN familias ON productos.id_familia = familias.id
                    INNER JOIN lineas ON productos.id_linea = lineas.id
                    LEFT JOIN gastos_clasificacion ON gastos_clasificacion.id_clas = productos.id_clas
                    WHERE productos.id=$idProducto";
        
            $resultado = $this->link->query($query);
            return query2json($resultado);            
  
        }//- fin function buscarProductosId


    //function buscarProductosActivos($idUnidad, $tipo = null)
    /**
      * Busca los productos activos por unidad de negocio
      * 
      * @param int $idUnidad
      * @param int $tipo
      *
      **/
    function buscarProductosActivos($idUnidad,$idFamilia,$idLinea, $tipoProducto, $diferentesFamilias)
    {

      $familia='';
      $linea='';
      $tipo = '';

      if($tipoProducto == 4)
        $tipo = " AND productos.servicio = 1";
      else
      {

        if($idFamilia > 0)
          $familia=' AND productos.id_familia='.$idFamilia;
        
        if($idLinea > 0)
          $linea=' AND productos.id_linea='.$idLinea;
        
        if($tipoProducto != null)
            $tipo = " AND familias.tipo = $tipoProducto ";
        
      }

      //-->NJES July/30/2020 si diferentes familias es 1 no buscar familias gasto de caja chica y gasolina
      if($diferentesFamilias == 1)
        $condFamGasto = " AND fam_gastos.id_fam != 9 AND fam_gastos.id_fam != 19"; //$condFamGasto = " AND fam_gastos.id_fam != 9 AND fam_gastos.id_fam != 19";
      else
        $condFamGasto = "";

      $query = "SELECT
                  productos.id AS id,
                  productos.clave AS clave,
                  productos.concepto AS concepto,
                  IFNULL(productos.descripcion,'') AS descripcion,
                  productos.id_familia AS id_familia,
                  familias.descripcion AS familia,
                  productos.id_linea AS id_linea,
                  lineas.descripcion AS linea,
                  productos.costo AS costo,
                  productos_unidades.ultimo_precio_compra AS precio,
                  familias.tallas AS verifica_talla,
                  familias.id_familia_gasto,
                  fam_gastos.descr AS familia_gasto,
                  IFNULL(gastos_clasificacion.id_clas, 0) id_clas,
                  IFNULL(gastos_clasificacion.descr, '') as clasificacion
                FROM productos
                INNER JOIN familias ON productos.id_familia = familias.id
                INNER JOIN lineas ON productos.id_linea = lineas.id
                INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
                LEFT JOIN fam_gastos ON familias.id_familia_gasto=fam_gastos.id_fam
                LEFT JOIN gastos_clasificacion ON productos.id_clas = gastos_clasificacion.id_clas
                WHERE productos_unidades.id_unidades=$idUnidad $familia $linea $tipo $condFamGasto

                UNION ALL

                SELECT
                  productos.id AS id,
                  productos.clave AS clave,
                  productos.concepto AS concepto,
                  IFNULL(productos.descripcion,'') AS descripcion,
                  productos.id_familia AS id_familia,
                  familias.descripcion AS familia,
                  productos.id_linea AS id_linea,
                  lineas.descripcion AS linea,
                  productos.costo AS costo,
                  0 AS precio,
                  familias.tallas AS verifica_talla,
                  familias.id_familia_gasto,
                  fam_gastos.descr AS familia_gasto,
                  IFNULL(gastos_clasificacion.id_clas, 0) id_clas,
                  IFNULL(gastos_clasificacion.descr, '') as clasificacion
                FROM productos
                INNER JOIN familias ON productos.id_familia = familias.id
                INNER JOIN lineas ON productos.id_linea = lineas.id
                INNER JOIN productos prod ON productos.id = prod.equivalente_usado
                LEFT JOIN fam_gastos ON familias.id_familia_gasto=fam_gastos.id_fam
                LEFT JOIN gastos_clasificacion ON productos.id_clas = gastos_clasificacion.id_clas
                LEFT JOIN productos_unidades ON productos.id = productos_unidades.id_producto
                WHERE productos_unidades.id IS NULL $familia $linea $tipo $condFamGasto
                ";

      // echo $query;
      // exit();

      $resultado = $this->link->query($query);
      return query2json($resultado);

    }

    function buscarProductosActivosConEquivalentes($idUnidad,$idFamilia,$idLinea, $tipoProducto, $diferentesFamilias,$filtro){

      $familia='';
      $linea='';
      $tipo = '';
      $condFiltro = "";

      if($tipoProducto == 4)
        $tipo = " AND productos.servicio = 1";
      else
      {

        if($idFamilia > 0)
          $familia=' AND productos.id_familia='.$idFamilia;
        
        if($idLinea > 0)
          $linea=' AND productos.id_linea='.$idLinea;
        
        if($tipoProducto != null)
            $tipo = " AND familias.tipo = $tipoProducto ";
        
      }

      //-->NJES July/30/2020 si diferentes familias es 1 no buscar familias gasto de caja chica y gasolina
      if($diferentesFamilias == 1)
        $condFamGasto = " AND fam_gastos.id_fam != 9 AND fam_gastos.id_fam != 19";
      else
        $condFamGasto = "";


      if($filtro != ""){
        $condFiltro = "AND productos.concepto LIKE 'MP%$filtro%'";
      }

      $query = "SELECT
              productos.id AS id,
              productos.clave AS clave,
              productos.concepto AS concepto,
              IFNULL(productos.descripcion,'') AS descripcion,
              productos.id_familia AS id_familia,
              familias.descripcion AS familia,
              productos.id_linea AS id_linea,
              lineas.descripcion AS linea,
              productos.costo AS costo,
              IF(productos.precio_venta IS NULL, IF(productos_unidades.ultimo_precio_compra = 0, productos.costo, productos_unidades.ultimo_precio_compra), productos.precio_venta) AS precio,
              familias.tallas AS verifica_talla,
              familias.id_familia_gasto,
              fam_gastos.descr AS familia_gasto
              FROM productos
              INNER JOIN familias ON productos.id_familia = familias.id
              INNER JOIN lineas ON productos.id_linea = lineas.id
              INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
              LEFT JOIN fam_gastos ON familias.id_familia_gasto=fam_gastos.id_fam
              WHERE productos_unidades.id_unidades=$idUnidad $familia $linea $tipo $condFamGasto $condFiltro

              UNION ALL

              SELECT
              productos.id AS id,
              productos.clave AS clave,
              productos.concepto AS concepto,
              IFNULL(productos.descripcion,'') AS descripcion,
              productos.id_familia AS id_familia,
              familias.descripcion AS familia,
              productos.id_linea AS id_linea,
              lineas.descripcion AS linea,
              productos.costo AS costo,
              IF(productos.precio_venta IS NULL, IF(productos_unidades.ultimo_precio_compra = 0, productos.costo, productos_unidades.ultimo_precio_compra), productos.precio_venta) AS precio,
              familias.tallas AS verifica_talla,
              familias.id_familia_gasto,
              fam_gastos.descr AS familia_gasto
              FROM productos
              INNER JOIN familias ON productos.id_familia = familias.id
              INNER JOIN lineas ON productos.id_linea = lineas.id
              INNER JOIN 
              (

              SELECT 
              pr.id AS id_original,
              pr.equivalente_usado AS id_equivalente
              FROM productos pr

              ) po ON productos.id = po.id_equivalente
              INNER JOIN productos_unidades ON  po.id_original = productos_unidades.id_producto
              LEFT JOIN fam_gastos ON familias.id_familia_gasto=fam_gastos.id_fam
              WHERE productos_unidades.id_unidades = $idUnidad $familia $linea $tipo $condFamGasto $condFiltro

            ";

      $resultado = $this->link->query($query);
      return query2json($resultado);

    }

    //function buscarProductosActivosExistencia($idUnidad, $tipo = null)
    /**
      * Busca los productos activos por unidad de negocio
      * 
      * @param int $idUnidad
      * @param int $tipo
      *
      **/
      function buscarProductosActivosExistencia($idUnidad,$idSucursal,$idFamilia,$idLinea)
      {
  
        $familia='';
        $linea='';
  
        if($idFamilia > 0)
        {
          $familia=' AND productos.id_familia='.$idFamilia;
        }
        
        if($idLinea > 0)
        {
          $linea=' AND productos.id_linea='.$idLinea;
        }

        $query = "SELECT
                    productos.id AS id,
                    productos.clave AS clave,
                    productos.concepto AS concepto,
                    productos.descripcion AS descripcion,
                    productos.id_familia AS id_familia,
                    familias.descripcion AS familia,
                    productos.id_linea AS id_linea,
                    lineas.descripcion AS linea,
                    IFNULL(MAX(pb.nuevo_costo), productos.costo) AS costo,
                    IF(productos.precio_venta IS NULL, IF(productos_unidades.ultimo_precio_compra = 0, productos.costo, productos_unidades.ultimo_precio_compra) ,productos.precio_venta) AS precio,
                    productos.servicio,
                    familias.tallas AS verifica_talla,
                    IFNULL(SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),0) AS existencia,
                    familias.id_familia_gasto
                  FROM productos
                  INNER JOIN familias ON productos.id_familia = familias.id
                  INNER JOIN lineas ON productos.id_linea = lineas.id
                  INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
                  LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=$idSucursal
                  LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = productos.id
                  LEFT JOIN (
                    SELECT pb.id_producto, pb.nuevo_costo
                    FROM productos_bitacora pb
                    WHERE 
                    pb.id IN (SELECT MAX(id) FROM productos_bitacora WHERE id_unidad_negocio=1 GROUP BY id_producto )
                  ) pb ON almacen_d.id_producto = pb.id_producto
                  WHERE productos_unidades.id_unidades=$idUnidad $familia $linea AND familias.tipo NOT IN(0,2) and almacen_e.estatus != 'C'
                  GROUP BY productos.id
                  HAVING existencia>0
                  ORDER BY familias.descripcion,lineas.descripcion,productos.concepto";
        
        // echo $query;
        // exit();

        $resultado = $this->link->query($query);
        return query2json($resultado);
  
      }

      function buscarProductosActivosExistenciaConEquivalentes($idUnidad, $idSucursal, $idFamilia, $idLinea)
      {
  
        $familia='';
        $linea='';
  
        if($idFamilia > 0)
        {
          $familia=' AND productos.id_familia='.$idFamilia;
        }
        
        if($idLinea > 0)
        {
          $linea=' AND productos.id_linea='.$idLinea;
        }
        
        $resultado = $this->link->query("SELECT
        productos.id AS id,
        productos.clave AS clave,
        productos.concepto AS concepto,
        productos.descripcion AS descripcion,
        productos.id_familia AS id_familia,
        familias.descripcion AS familia,
        productos.id_linea AS id_linea,
        lineas.descripcion AS linea,
        productos.costo AS costo,
        productos_unidades.ultimo_precio_compra AS precio,
        productos.servicio,
        familias.tallas AS verifica_talla,
        IFNULL(SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),0) AS existencia,
        familias.id_familia_gasto
        FROM productos
        INNER JOIN familias ON productos.id_familia = familias.id
        INNER JOIN lineas ON productos.id_linea = lineas.id
        INNER JOIN 
        (

        SELECT 
        pr.id AS id_original,
        pr.equivalente_usado AS id_equivalente
        FROM productos pr

        ) po ON productos.id = po.id_equivalente
        INNER JOIN productos_unidades ON  po.id_original = productos_unidades.id_producto

        LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=".$idSucursal." 
        LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = productos.id
        WHERE productos_unidades.id_unidades=$idUnidad $familia $linea and almacen_e.estatus != 'C'
        GROUP BY productos.id
        HAVING existencia>0
        ORDER BY familias.descripcion,lineas.descripcion,productos.concepto");
        return query2json($resultado);
  
      }

  /**
  * Busca los unidades a las que pertenece  un producto, retorna un JSON con los datos correspondientes
  * 
  * @param int $idProducto producto de que se van a buscar las unidades
  *
  **/
  function buscarProductosUnidades($idProducto){

    $resultado = $this->link->query("SELECT b.descripcion as unidad,a.ultimo_precio_compra, a.ultima_fecha_compra 
    FROM productos_unidades a
    LEFT JOIN cat_unidades_negocio b ON  a.id_unidades=b.id
    WHERE a.id_producto=".$idProducto);
    return query2json($resultado);

  }//- fin function buscarProductos

  /**
    * Busca los productos que son uniformes de una unidad de negocio
    * 
    * @param int $idUnidad
    * @param int $idFamilia  para filtrar
    * @param int $idLinea  para filtrar
    *
  **/
  function buscarProductosActivosUniformes($idUnidad,$idFamilia,$idLinea)
  {

      $familia='';
      $linea='';

      if($idFamilia > 0)
      {
        $familia=' AND productos.id_familia='.$idFamilia;
      }
      
      if($idLinea > 0)
      {
        $linea=' AND productos.id_linea='.$idLinea;
      }
      
      $resultado = $this->link->query("SELECT
      productos.id AS id,
      productos.clave AS clave,
      productos.concepto AS concepto,
      productos.descripcion AS descripcion,
      productos.id_familia AS id_familia,
      familias.descripcion AS familia,
      productos.id_linea AS id_linea,
      lineas.descripcion AS linea,
      productos.costo AS costo,
      productos_unidades.ultimo_precio_compra AS precio,
      familias.tallas AS verifica_talla
      FROM productos
      INNER JOIN familias ON productos.id_familia = familias.id
      INNER JOIN lineas ON productos.id_linea = lineas.id
      INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
      WHERE productos_unidades.id_unidades=$idUnidad $familia $linea AND familias.tallas=1 AND productos.inactivo=0");
      return query2json($resultado);

  }//- fin function buscarProductosActivosUniformes


  /**
    * Busca los productos que son uniformes Existencia de una unidad de negocio
    * 
    * @param int $idUnidad
    * @param int $idFamilia  para filtrar
    * @param int $idLinea  para filtrar
    *
  **/
  function buscarProductosActivosUniformesExistencia($idUnidad,$idSucursal,$idFamilia,$idLinea)
  {

      $familia='';
      $linea='';

      if($idFamilia > 0)
      {
        $familia=' AND productos.id_familia='.$idFamilia;
      }
      
      if($idLinea > 0)
      {
        $linea=' AND productos.id_linea='.$idLinea;
      }

      $query = "SELECT
                  productos.id AS id,
                  productos.clave AS clave,
                  productos.concepto AS concepto,
                  productos.descripcion AS descripcion,
                  productos.id_familia AS id_familia,
                  familias.descripcion AS familia,
                  productos.id_linea AS id_linea,
                  lineas.descripcion AS linea,
                  productos.costo AS costo,
                  productos.servicio,
                  productos_unidades.ultimo_precio_compra AS precio,
                  familias.tallas AS verifica_talla,
                  familias.id_familia_gasto,
                  IFNULL(SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),0) AS existencia
                FROM productos
                INNER JOIN familias ON productos.id_familia = familias.id
                INNER JOIN lineas ON productos.id_linea = lineas.id
                INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
                LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=$idSucursal 
                LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = productos.id
                WHERE productos_unidades.id_unidades=$idUnidad $familia $linea AND familias.tallas=1 AND productos.inactivo=0 and almacen_e.estatus != 'C'
                GROUP BY productos.id
                HAVING existencia>0
                ORDER BY familias.descripcion,lineas.descripcion,productos.concepto";
      
      // echo $query;
      // exit();

      $resultado = $this->link->query($query);
      return query2json($resultado);

  }//- fin function buscarProductosActivosUniformes


  function buscarProductosActivosUniformesExistenciaEquivalente($idUnidad,$idSucursal,$idFamilia,$idLinea)
  {

      $familia='';
      $linea='';

      if($idFamilia > 0)
      {
        $familia=' AND productos.id_familia='.$idFamilia;
      }
      
      if($idLinea > 0)
      {
        $linea=' AND productos.id_linea='.$idLinea;
      }
      
      $resultado = $this->link->query("SELECT
      productos.id AS id,
      productos.clave AS clave,
      productos.concepto AS concepto,
      productos.descripcion AS descripcion,
      productos.id_familia AS id_familia,
      familias.descripcion AS familia,
      productos.id_linea AS id_linea,
      lineas.descripcion AS linea,
      productos.costo AS costo,
      productos.servicio,
      productos_unidades.ultimo_precio_compra AS precio,
      familias.tallas AS verifica_talla,
      familias.id_familia_gasto,
      IFNULL(SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),0) AS existencia
      FROM productos
      INNER JOIN familias ON productos.id_familia = familias.id
      INNER JOIN lineas ON productos.id_linea = lineas.id

      LEFT JOIN 
      (
       
       SELECT 
       pr.id AS id_original,
       pr.equivalente_usado AS id_equivalente
       FROM productos pr

      ) po ON productos.id = po.id_equivalente
      INNER JOIN productos_unidades ON  po.id_original = productos_unidades.id_producto
      -- INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
      
      LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal = " . $idSucursal . " 
      LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = productos.id
      WHERE productos_unidades.id_unidades=$idUnidad $familia $linea AND familias.tallas=1 AND productos.inactivo=0 and almacen_e.estatus != 'C'
      GROUP BY productos.id
      HAVING existencia>0
      ORDER BY familias.descripcion,lineas.descripcion,productos.concepto");
      return query2json($resultado);

  }


  /**
  * Busca bitacora  producto, retorna un JSON con los datos correspondientes
  * 
  * @param int $idProducto producto de que se van a buscar las unidades
  *
  **/
  function buscarBitacoraProducto($idProducto){

    $query = "SELECT b.descripcion AS unidad,a.nuevo_costo, a.fecha_cambio,a.modulo,c.usuario
              FROM productos_bitacora a
              LEFT JOIN cat_unidades_negocio b ON  a.id_unidad_negocio=b.id
              LEFT JOIN usuarios c ON a.id_usuario_captura=c.id_usuario
              WHERE a.id_producto=$idProducto";

    // echo $query;
    // exit();

    $resultado = $this->link->query($query);
    return query2json($resultado);

  }//- fin function buscarProductos

  //function buscarProductosActivosExistencia($idUnidad, $tipo = null)
    /**
      * Busca los productos activos por unidad de negocio
      * 
      * @param int $idUnidad
      * @param int $tipo
      *
      **/
      function buscarProductosActivosExistenciaSinActivosFijos($idUnidad,$idSucursal,$idFamilia,$idLinea)
      {
        
        $familia='';
        $linea='';
  
        if($idFamilia > 0)
        {
          $familia=' AND productos.id_familia='.$idFamilia;
        }
        
        if($idLinea > 0)
        {
          $linea=' AND productos.id_linea='.$idLinea;
        }
  
        $resultado = $this->link->query("SELECT
        productos.id AS id,
        productos.clave AS clave,
        productos.concepto AS concepto,
        productos.descripcion AS descripcion,
        productos.id_familia AS id_familia,
        familias.tipo AS tipo_familia_activo_fijo,
        familias.descripcion AS familia,
        productos.id_linea AS id_linea,
        lineas.descripcion AS linea,
        productos.costo AS costo,
        productos.servicio,
        productos_unidades.ultimo_precio_compra AS precio,
        familias.tallas AS verifica_talla,
        IFNULL(SUM(IF((SUBSTR(almacen_d.cve_concepto,1,1) = 'E'),almacen_d.cantidad,(almacen_d.cantidad * -(1)))),0) AS existencia,
        familias.id_familia_gasto
        FROM productos
        INNER JOIN familias ON productos.id_familia = familias.id
        INNER JOIN lineas ON productos.id_linea = lineas.id
        INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
        LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=".$idSucursal." --  AND estatus!='C'
        LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = productos.id
        WHERE productos_unidades.id_unidades=$idUnidad $familia $linea and almacen_e.estatus != 'C'
        GROUP BY productos.id
        HAVING existencia>0 AND tipo_familia_activo_fijo NOT IN (0,2)
        ORDER BY familias.descripcion,lineas.descripcion,productos.concepto");
        return query2json($resultado);
        //-->NJES October/12/2020 validar que tampoco se pueda hacer salida de tipo mantenimiento
      }

 
    //NJES Jan/16/2020 buscar los productos sin y con existencia
    /**
      * Busca los productos activos sin y con existencia
    **/
      function buscarProductosActivosTodos($idUnidad,$idSucursal,$idFamilia,$idLinea, $tipo)
      {
  
        $familia = '';
        $linea = '';
  
        if($idFamilia > 0)
          $familia = ' AND productos.id_familia=' . $idFamilia;
        
        if($idLinea > 0)
          $linea=' AND productos.id_linea=' . $idLinea;

        $tC = 'AND productos.servicio = 0';
        if((int)$tipo == 1)
          $tC = '';

        $query = "SELECT
        productos.id AS id,
        productos.clave AS clave,
        productos.concepto AS concepto,
        productos.descripcion AS descripcion,
        productos.id_familia AS id_familia,
        familias.descripcion AS familia,
        productos.id_linea AS id_linea,
        lineas.descripcion AS linea,
        productos.costo AS costo,
        productos_unidades.ultimo_precio_compra AS precio,
        IF(productos.precio_venta IS NULL, 0, productos.precio_venta) precio_venta,
        productos.servicio,
        familias.tallas AS verifica_talla,       
        IF(productos.servicio = 1, 0, IFNULL(existencias.existencia, 0)) AS existencia,
        familias.id_familia_gasto
        FROM productos
        LEFT JOIN 
        (
        SELECT  
        prod.id AS id_producto,        
        SUM( IF(SUBSTR(almacen_d.cve_concepto, 1, 1) = 'E', 
        almacen_d.cantidad, almacen_d.cantidad*-1)) AS existencia           
        FROM productos prod          
        INNER JOIN familias ON prod.id_familia = familias.id          
        INNER JOIN lineas ON prod.id_linea = lineas.id          
        INNER JOIN almacen_d ON prod.id = almacen_d.id_producto         
        INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id         
        WHERE almacen_e.id_sucursal = $idSucursal    
        AND almacen_e.estatus != 'C'          
        GROUP BY prod.id
        ) existencias ON productos.id = existencias.id_producto
        INNER JOIN familias ON productos.id_familia = familias.id
        INNER JOIN lineas ON productos.id_linea = lineas.id
        INNER JOIN productos_unidades ON productos.id = productos_unidades.id_producto
        LEFT JOIN almacen_e ON almacen_e.id_unidad_negocio=productos_unidades.id_unidades AND almacen_e.id_sucursal=$idSucursal
        LEFT JOIN almacen_d ON almacen_e.id = almacen_d.id_almacen_e AND almacen_d.id_producto = productos.id
        WHERE productos_unidades.id_unidades=$idUnidad $familia $linea AND familias.tipo NOT IN(0,2) 

        $tC

        AND  almacen_e.estatus != 'C'
        GROUP BY productos.id
        ORDER BY familias.descripcion,lineas.descripcion,productos.concepto";

        // echo $query;
        // exit();

        $resultado = $this->link->query($query);
        
        return query2json($resultado);
  
      }

      function buscarProductosFletesLogistica(){
        $query = "SELECT
                    productos.id AS id,
                    productos.clave AS clave,
                    productos.concepto AS concepto,
                    IFNULL(productos.descripcion,'') AS descripcion,
                    productos.id_familia AS id_familia,
                    familias.descripcion AS familia,
                    productos.id_linea AS id_linea,
                    lineas.descripcion AS linea,
                    productos.costo AS costo,
                    -- productos_unidades.ultimo_precio_compra AS precio,
                    familias.id_familia_gasto,
                    fam_gastos.descr AS familia_gasto,
                    familias.tipo
                    FROM productos
                    INNER JOIN familias ON productos.id_familia = familias.id
                    INNER JOIN lineas ON productos.id_linea = lineas.id
                    -- INNER JOIN productos_unidades ON productos.id != productos_unidades.id_producto
                    LEFT JOIN fam_gastos ON familias.id_familia_gasto=fam_gastos.id_fam 
                    WHERE productos.servicio=1 AND fam_gastos.id_fam=104";

        $result = mysqli_query($this->link, $query);

        return query2json($result);
      }

      function buscarProductosMateriaPrima($idUnidad){
        $query = "SELECT pr.id,
                          pr.concepto,
                          SUM(IF(substr(ae.cve_concepto, 1,1) = 'E', ad.cantidad, ad.cantidad * -1)) as existencia,
                          group_concat(distinct(pre.id_producto_terminado )) AS pt,
                          -- pre.id_producto_terminado AS pt,
                          pre.cantidad
                  FROM almacen_e ae
                  INNER JOIN almacen_d ad ON ad.id_almacen_e = ae.id
                  INNER JOIN productos pr ON pr.id = ad.id_producto
                  INNER JOIN productos_unidades pu ON pu.id_producto = pr.id
                  INNER JOIN productos_relacion pre ON pre.id_materia_prima = pr.id
                  WHERE pu.id_unidades = $idUnidad AND pr.id_familia IN (161, 162, 171)
                  GROUP BY pr.id";

        $result = mysqli_query($this->link, $query);

        return query2json($result);
      }


}//--fin de class Areas
    
?>