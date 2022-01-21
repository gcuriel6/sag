<?php

include 'conectar.php';

include_once('Autorizar.php');

class AutorizarPresupuesto
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function AutorizarPresupuesto()
    {
  
      $this->link = Conectarse();

    }

  
    
    /**
      * Busca los datos de una autorizacion, retorna un JSON con los datos correspondientes
      * 
      * @param int $activo indica el estatus 1=pendiente 2=aprobada 
      * -- MGFS 06-02-2020 SE CAMBIA a.id_unidad_negocio IN ($idsUnidades) POR $condicionSucursal
      **/
      function buscarAutorizarPresupuesto($idsUnidades,$idUsuario,$idsSucursales)
      {
        if($idsSucursales!=''){

          if (strpos($idsSucursales, ',') !== false) {
            
            $dato=substr(trim($idsSucursales),1);
            $condicionSucursal=' a.id_sucursal in ('.$dato.')';
          }else{
            $condicionSucursal=' a.id_sucursal ='.$idsSucursales;
          }
    
        }else{
          
          $condicionSucursal=' a.id_sucursal =0';
        }

        $query = "SELECT a.id,
                        a.folio,
                        a.descripcion,
                        a.total,
                        IF(a.presupuesto_aprobado=0,'Pendiente',IF(a.presupuesto_aprobado=1,'Autorizada','Rechazada')) AS estatus,
                        IF(a.tipo=0,'ACTIVOS FIJOS',IF(a.tipo=1,'GASTOS',IF(a.tipo=2,'MANTENIMIENTO', IF(a.tipo = 3,'STOCK', 'ORDEN DE SERVICIO'))))AS tipo,
                        b.nombre AS unidad_negocio,
                        c.clave AS clave_suc,
                        c.descripcion AS sucursal,
                        IF((a.total>d.monto_minimo OR a.total=d.monto_minimo) AND (a.total=d.monto_maximo OR a.total<d.monto_maximo),'si','no') AS editar,
                        DATE(a.fecha_creacion) as fechaCreacion,
                        e.nombre_comp as usuarioCapturo
                  FROM requisiciones a
                  LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                  LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                  LEFT JOIN cat_autorizaciones d ON d.id_usuario = $idUsuario AND d.activo=1
                  INNER JOIN usuarios e ON e.id_usuario = a.id_capturo
                  WHERE $condicionSucursal AND a.presupuesto_aprobado=0
                  AND a.estatus<=2 AND (a.id_orden_compra='' OR ISNULL(a.id_orden_compra) OR a.id_orden_compra=0)";
  
        // echo $query;
        // exit();

        $resultado = $this->link->query($query);
        return query2json($resultado);

      }//- fin function buscarAutorizarPresupuesto
    
      
    /**
      * Manda llamar a la funcion que actualiza el estatus de una requi
      * 
      * @param int $id es el id de a requisision a actualizar
      * @param int $estatus 1 = Pendiente, 2 = Autorizadar, 3 = NO autorizada, 4 = Orden de compra, 5 = Por Pagar, 6 =  Pagada
      *
      **/      
    function guardarAutorizarPresupuesto($id,$estatus,$idUsuario,$fecha){
    
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");
      //---estatus 0 es que se dio de alta con excedente de presupuesto
      //--- estatus = 1 se aprueba el presupuesto
      //--- estatus = 2 se rechaza el presupuesto

      //-->NJES February/04/2021 si se rechaza el presupuesto cambiar el estatus de la requi a no autorizada, sino sigue en pendiente
      //y cuando se reactive una requi de presupuesto rechazada el estatus cambiara a pendiente
      if($estatus == 2)
        $estatusRequi = 3;
      else
        $estatusRequi = 1;

      //GCM - 10/nov/2021 se cambia $estatusRequi = 1; a $estatusRequi = 2; para que se ponga en estatus 2 cuando el checkbox autorizar es chekeado
      // if($estatus == 2)
      //   $estatusRequi = 3;
      // else
      //   $estatusRequi = 2;

      $query = "UPDATE requisiciones SET presupuesto_aprobado='$estatus', 
                fecha_presupuesto='$fecha', usuario_presupuesto='$idUsuario',
                estatus='$estatusRequi'  
                WHERE id=".$id;
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      $datos = array('idRequisicion'=>$id,
                          'estatus'=>$estatus,
                          'idUsuario'=>$_SESSION['id_usuario']);

      $bitacoraAutorizarRequi = new Autorizar();

      if($result)
              $verifica = $bitacoraAutorizarRequi->guardaBitacoraAutorizaRechazaRequi($datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;

  } //-- fin function guardarAutorizarPresupuesto

  /**
  * Busca los datos de una autorizacion, retorna un JSON con los datos correspondientes
  * 
  * @param int $activo indica el estatus 1=pendiente 2=aprobada 
  *  -- MGFS 06-02-2020 SE CAMBIA a.id_unidad_negocio IN ($idsUnidades) POR $condicionSucursal
  **/
  function buscarPendientesAutorizarPresupuesto($idsUnidades,$idUsuario,$idsSucursales)
  {
    if($idsSucursales!=''){

      if (strpos($idsSucursales, ',') !== false) {
        
        $dato=substr(trim($idsSucursales),1);
        $condicionSucursal=' a.id_sucursal in ('.$dato.')';
      }else{
        $condicionSucursal=' a.id_sucursal ='.$idsSucursales;
      }

    }else{
      
      $condicionSucursal=' a.id_sucursal =0';
    }

    $resultado = $this->link->query("SELECT a.id,a.folio,a.descripcion,a.total,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar',IF(a.estatus=6,'Pagada','Cancelada')))))) AS estatusRequi,
    IF(a.tipo=0,'ACTIVOS FIJOS',IF(a.tipo=1,'GASTOS',IF(a.tipo=2,'MANTENIMIENTO',IF(a.tipo = 3,'STOCK', 'ORDEN DE SERVICIO'))))AS tipo,b.nombre AS unidad_negocio,c.clave AS clave_suc,c.descripcion AS sucursal,
    IF((a.total>d.monto_minimo OR a.total=d.monto_minimo) AND (a.total=d.monto_maximo OR a.total<d.monto_maximo),'si','no') AS editar,if(a.presupuesto_aprobado=0,'Pendiente',if(a.presupuesto_aprobado=1,'Aprobado','Rechazado')) as estatus
            FROM requisiciones a
            LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
            LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
            LEFT JOIN cat_autorizaciones d ON d.id_usuario = $idUsuario AND d.activo=1
            WHERE $condicionSucursal AND a.presupuesto_aprobado=0");
    return query2json($resultado);

  }//- fin function buscarAutorizarPresupuesto

     /**
      * Busca todas las requis que fueron rechazadas=3 o canceladas=7 para poder reactivarlas
      * -- MGFS 06-02-2020 SE CAMBIA a.id_unidad_negocio IN ($idsUnidades) POR $condicionSucursal
      **/
      function buscarRequisReactivar($idsUnidades,$idUsuario,$idsSucursales){
        if($idsSucursales!=''){

          if (strpos($idsSucursales, ',') !== false) {
            
            $dato=substr(trim($idsSucursales),1);
            $condicionSucursal=' AND a.id_sucursal in ('.$dato.')';
          }else{
            $condicionSucursal=' AND a.id_sucursal ='.$idsSucursales;
          }
    
        }else{
          
          $condicionSucursal=' AND a.id_sucursal =0';
        }

        $resultado = $this->link->query("SELECT a.id,a.folio,a.descripcion,a.total,a.fecha_pedido,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar',IF(a.estatus=6,'Pagada','Cancelada')))))) AS estatus,b.nombre AS unidad_negocio,c.clave AS clave_suc,c.descripcion AS sucursal,
        IF((a.total>d.monto_minimo OR a.total=d.monto_minimo) AND (a.total=d.monto_maximo OR a.total<d.monto_maximo),'si','no') AS editar
                FROM requisiciones a
                LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
                LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
                LEFT JOIN cat_autorizaciones d ON d.id_usuario=".$idUsuario." AND d.activo=1
                WHERE a.presupuesto_aprobado=1 $condicionSucursal AND a.estatus in ('3,7') AND  a.fecha_pedido >= DATE_SUB(CURDATE() , INTERVAL 60 DAY)");
        return query2json($resultado);

      }//- fin function buscarAutorizar

      /**
      * Busca una requis que fue rechazadas o canceladas para poder reactivarla
      *
      **/
      function buscarRequisReactivarId($idRequisicion){
      
        $resultado = $this->link->query("SELECT a.id,a.folio,a.descripcion,a.total,a.fecha_pedido,IF(a.estatus=1,'Pendiente',IF(a.estatus=2,'Autorizada',IF(a.estatus=3,'Rechazada',IF(a.estatus=4,'Orden Compra',IF(a.estatus=5,'Por pagar',IF(a.estatus=6,'Pagada','Cancelada')))))) AS estatus, a.total AS costo, IFNULL(a.solicito,'')AS solicito, e.des_dep AS departamento
        FROM requisiciones a
        LEFT JOIN cat_unidades_negocio b ON a.id_unidad_negocio=b.id
        LEFT JOIN sucursales c ON a.id_sucursal=c.id_sucursal
        LEFT JOIN cat_autorizaciones d ON d.id_usuario=1 AND d.activo=1
        LEFT JOIN deptos e ON a.id_departamento=e.id_depto
        WHERE a.id=".$idRequisicion);
        return query2json($resultado);

      }//- fin function buscarAutorizar


    
}//--fin de class AutorizarPresupuesto
    
?>