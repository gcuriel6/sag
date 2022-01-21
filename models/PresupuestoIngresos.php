<?php

require_once('conectar.php');

require_once('PresupuestoEgresosBitacora.php');

class PresupuestoIngresos
{

    public $link;

    function PresupuestoIngresos()
    {

      $this->link = Conectarse();

    }

    function buscaInformacionPresupuesto($idUnidad, $idSucursal, $anio, $mes, $tipo){
     
      $condicionUnidad = "r.id_unidad_negocio=".$idUnidad;

      $estatus = "IF(r.estatus='P','PENDIENTE',IF(r.estatus='T','TIMBRADA',IF(r.estatus='A','SIN TIMBRAR','LIQUIDADA')))AS estatus,
                    r.estatus AS estatus_letra,";
      
      if($idUnidad != 2)
        $estatus = "IF(fc.estatus='T','TIMBRADA', 'PREFACTURA')AS estatus,
                      fc.estatus AS estatus_letra,";

      $condicionVencimiento = "AND IF(r.vencimiento='0000-00-00',MONTH(fn.vencimiento_factura)<=$mes AND YEAR(fn.vencimiento_factura)<=$anio,MONTH(r.vencimiento)<=$mes AND YEAR(r.vencimiento)<=$anio)";  

      if($idSucursal!=''){

        if (strpos($idSucursal, ',') !== false) {
          $dato=substr($idSucursal,1);
          $condicionSucursal=' AND r.id_sucursal in ('.$dato.')';
        }else{
          $condicionSucursal=' AND r.id_sucursal ='.$idSucursal;
        }
                
        $result = $this->link->query("SELECT * FROM (
                        SELECT  
                        r.id,
                        b.nombre AS unidad_negocio,
                        c.descr AS sucursal,
                        IFNULL(IF(r.folio_factura>0,r.folio_factura,''),'') AS folio_factura,
                        r.fecha,
                        IF(r.vencimiento='0000-00-00',fn.vencimiento_factura,r.vencimiento) AS vence,
                        d.razon_social,
                        IFNULL(r.referencia,'') AS referencia,
                        (r.total-r.descuento-IFNULL(fn.importe_retencion,0)) AS total,
                        $estatus
                        r.id_factura,
                        r.anio,
                        r.mes,  
                        IF(r.folio_cxc > 0,'CXC',IF(r.folio_factura>0,'FAC','NOT')) AS tipo,
                        (r.total-r.descuento-IFNULL(fn.importe_retencion,0))-(IFNULL(abonos.abonos_cxc,0)+IFNULL(fn.abonos_factura,0)) AS saldo
                        
                        FROM cxc r 
                        LEFT JOIN cat_unidades_negocio b ON r.id_unidad_negocio = b.id       
                        LEFT JOIN sucursales c ON r.id_sucursal = c.id_sucursal      
                        LEFT JOIN razones_sociales d ON r.id_razon_social = d.id

                        LEFT JOIN facturas ff ON r.id_factura = ff.id
                        LEFT JOIN facturas_cfdi fc ON ff.id = fc.id_factura

                        LEFT JOIN (
                          SELECT folio_cxc,IFNULL(SUM(total),0) AS abonos_cxc
                          FROM cxc
                          WHERE id!=folio_cxc AND estatus != 'C'
                          GROUP BY folio_cxc
                        ) AS abonos ON r.id=abonos.folio_cxc
                        LEFT JOIN (
                          SELECT   
                          a.folio,
                          a.fecha,
                          a.dias_credito,
                          DATE_ADD(a.fecha, INTERVAL IFNULL(a.dias_credito,0) DAY) AS vencimiento_factura,
                          a.id AS  id_factura,
                          a.importe_retencion,
                          IF(a.retencion=1,a.total-a.importe_retencion-a.descuento,a.total-a.descuento) AS total_factura,
                          IFNULL(nc.abonos_nc,0)+IFNULL(pagos.abonos_pagos,0) AS abonos_factura,
                          a.estatus AS estatus_factura,
                          a.anio,
                          a.mes
                          FROM facturas a
                          LEFT JOIN (
                            SELECT id, id_factura_nota_credito,SUM(total-importe_retencion) AS abonos_nc
                            FROM facturas 
                            WHERE estatus IN('T') AND id_factura_nota_credito!=0
                            GROUP BY id_factura_nota_credito
                          ) AS nc ON a.id=nc.id_factura_nota_credito
                          LEFT JOIN (
                            SELECT 
                            b.id_factura AS id_factura,
                            IFNULL(SUM(b.importe_pagado),0) AS abonos_pagos
                            FROM pagos_e a
                            LEFT JOIN pagos_d b ON a.id=b.id_pago_e
                            WHERE a.estatus IN('A','T')
                            GROUP BY b.id_factura
                          ) AS pagos ON a.id=pagos.id_factura
                          WHERE  a.id_factura_nota_credito=0
                          GROUP BY a.id
                        ) fn ON r.id_factura=fn.id_factura
                        WHERE $condicionUnidad  $condicionSucursal
                        AND r.estatus!='C' AND r.id_nota_credito=0 AND r.id_pago=0
                        $condicionVencimiento
                        GROUP BY r.folio_cxc,r.id_factura
                        UNION ALL
                        SELECT 
                        r.id,
                        b.nombre AS UNIDAD_NEGOCIO,														
                        c.descr AS SUCURSAL,
                        '' AS factura,
                        r.fecha,
                        r.fecha AS vence,
                        'OTROS_INGRESOS' AS cliente,
                        '' AS referencia,
                        SUM(r.importe) AS total,
                        IF(r.estatus=1,'Activa','Cancelada') AS estatus,
                        r.estatus AS estatus_letra,        
                        0 AS id_factura,        
                        YEAR(r.fecha) AS anio,        
                        MONTH(r.fecha) AS mes,          
                        'NOT' AS tipo,
                        SUM(r.importe) AS saldo
                        FROM ingresos_sin_factura r 
                        LEFT JOIN cat_unidades_negocio b ON r.id_unidad_negocio = b.id       														
                        LEFT JOIN sucursales c ON r.id_sucursal = c.id_sucursal  
                        WHERE $condicionUnidad  $condicionSucursal 
                        AND r.estatus!=0 AND MONTH(r.fecha)=$mes AND YEAR(r.fecha)=$anio
                      ) AS tbl
                      -- HAVING  tbl.saldo > 0 AND tbl.vence >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND (MONTH(tbl.vence)<=$mes AND YEAR(tbl.vence)<=$anio)
                      HAVING  tbl.saldo > 1 AND tbl.vence >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND (MONTH(tbl.vence)<=$mes AND YEAR(tbl.vence)<=$anio)
                      ORDER BY tbl.vence ASC");

        return query2json($result); // HAVING saldo > 0 AND vence >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND (MONTH(vence)<=$mes AND YEAR(vence)<=$anio)

      }else{
        
        $arr = array();

        return json_encode($arr);
      }
        
    }




      /**
        * Recorre los diferentes registros de presupuesto para guardar
        * @param $idUnidad int
        * @param $idSucursal int
        * @param $anio int
        * @param $mes int
        * @param $tipo int
        * @return bool
        */
      function guardarPresupuesto($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo)
      {

        $verifica = 0;

        /* VERIFICO SI EXISTE UNA INSECION DE ESTE MES Y AÑO CON LAS LLAVES */
        $buscaPresupuesto = "SELECT id 
                            FROM presupuesto_ingresos 
                            WHERE modulo=0 AND id_unidad_negocio=".$idUnidad." AND id_sucursal=".$idSucursal." AND (anio='$anio' AND mes='$mes')";
        $resultP = mysqli_query($this->link, $buscaPresupuesto)or die (mysqli_error());
        $numP = mysqli_num_rows($resultP);   

        if($numP>0){
          
          $verifica = $this -> eliminarPresupuesto($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo);

        }else{
          
          $verifica = $this -> guardar($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo);
        }
        

        return $verifica;

      }

      /**
        * Borra presupuesto en caso de reemplazar
        * @param $anio int
        * @param $mes int
        * @param $tipo int
        * @return bool
        */
        function eliminarPresupuesto($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo)
        {
  
          $verifica = 0;
  
          $queryB = "DELETE FROM presupuesto_ingresos WHERE id_unidad_negocio=".$idUnidad." AND id_sucursal=".$idSucursal." AND (anio = $anio AND mes = $mes)  AND modulo=0";
          $resultB = mysqli_query($this->link, $queryB);
         
          if($resultB)
            $verifica = $this -> guardar($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo);
          
        
  
          return $verifica;
  
        }


      
      
      function guardar($idUnidad, $idSucursal, $anio, $mes, $datos, $idUsuario, $modulo)
      {
        $verifica = 0;
        
        for($i=1;$i <= $datos[0];$i++){
   
          $idRazonSocial = $datos[$i]['idRazonSocial'];
          $folioFactura = ($datos[$i]['folioFactura']!='')? $datos[$i]['folioFactura'] :0;
          $vence = $datos[$i]['vence'];
          $total = $datos[$i]['total'];
          $idCXC = $datos[$i]['idCXC'];

          $queryT = "INSERT INTO presupuesto_ingresos (id_unidad_negocio, id_sucursal, anio, mes, monto, modulo, factura, vencimiento, id_razon_social, id_cxc) 
                    VALUES ('$idUnidad', '$idSucursal', '$anio', '$mes', '$total',0,'$folioFactura','$vence','$idRazonSocial','$idCXC')";
          $result = mysqli_query($this->link, $queryT);
          $idRegistro = mysqli_insert_id($this->link);
          if($result){
          
            if($i==$datos[0]){
             
              $verifica = $idRegistro;
            
            }
            
          }else{
            $verifica = 0;
            break;
          }
            
        }

        return $verifica;

      }



}
    
?>