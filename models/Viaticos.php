<?php

include_once('conectar.php');
require_once('MovimientosPresupuesto.php');

class Viaticos
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    **/
    public $link;

    function Viaticos()
    {
  
      $this->link = Conectarse();

    }

    
    /**
      * Manda llamar a la funcion que guarda la informacion sobre una viaticos
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $descripcion brebe descripcion de una viaticos
      * @param int $ininactivo estatus de una viaticos  1='inactivo' 0='Ininactivo'  
      *
    **/      
    function guardarViaticos($datos){
    
        $verifica = 0;

       $this->link->begin_transaction();
       $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;

    } //-- fin function guardarViaticos


     /**
      * Guarda los datos de una viaticos, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del viaticos para realizarla
      * @param varchar $descripcion brebe descripcion de una viaticos
      * @param int $ininactivo estatus de una viaticos  1='inactivo' 0='Ininactivo'  
      *
      **/ 
      function guardarActualizar($datos)
      {
          
        $verifica = 0;
        $tipoMov = $datos['tipoMov'];
        $idUsuario = $datos['idUsuario'];
        $usuario = $datos['usuario'];
        $idViatico= $datos['idViatico'];
        $folio = $datos['folio'];
        $idUnidadNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];

        $idArea = $datos['idArea'];
        $idDepartamento = $datos['idDepartamento'];

        $idSolicito = $datos['idSolicito'];
        $idEmpleado = $datos['idEmpleado'];
        $empleado = $datos['empleado'];
        $reposicionGasto = $datos['reposicionGasto'];

        $destino = $datos['destino'];
        $distancia = $datos['distancia'];
        $fechaInicio = $datos['fechaInicio'];
        $fechaFin = $datos['fechaFin'];
        $fechaComprobacion = $datos['fechaComprobacion'];
        $dias = $datos['dias'];
        $noches = $datos['noches'];
        $motivos = $datos['motivos'];

        $prospectacion = $datos['prospectacion'];
        $atencion = $datos['atencion'];
        $otros = $datos['otros'];

        $idFamiliaGasto = $datos['idFamiliaGasto'];
        //-->NJES Jan/17/2020 Guardar id_clasificacion_gasto en el viatico
        $idClasificacionGasto = $datos['idClasificacionGasto'];

        $autorizo = $datos['autorizo'];
        $total = $datos['total'];
        $detalle = $datos['detalle'];

       
        if($tipoMov==0){
          $queryFolio="SELECT folio_viaticos FROM sucursales WHERE id_sucursal=".$idSucursal;
          $resultF = mysqli_query($this->link, $queryFolio) or die(mysqli_error());
          
          if($resultF)
          {
              $datos=mysqli_fetch_array($resultF);
              $folioA=$datos['folio_viaticos'];
              $folio= $folioA+1;
  
              $queryU = "UPDATE sucursales SET folio_viaticos='$folio' WHERE id_sucursal=".$idSucursal;
              $resultU = mysqli_query($this->link, $queryU) or die(mysqli_error());
              if($resultU)
              {
                $query="INSERT INTO viaticos(folio,id_unidad_negocio,id_sucursal,id_area,id_departamento,id_solicito,estatus,destino,distancia,id_empleado,nombre_empleado,reposicion_gasto,motivos,fecha_inicio,fecha_fin,dias,noches,prospectacion,atencion,otros,fecha_comprobacion,autorizo,total,id_usuario_captura,usuario_captura,id_familia_gasto,id_clasificacion_gasto)
                        VALUES('$folio','$idUnidadNegocio','$idSucursal','$idArea','$idDepartamento','$idSolicito','A','$destino','$distancia','$idEmpleado','$empleado','$reposicionGasto','$motivos','$fechaInicio','$fechaFin','$dias','$noches','$prospectacion','$atencion','$otros','$fechaComprobacion','$autorizo','$total','$idUsuario','$usuario','$idFamiliaGasto','$idClasificacionGasto')";
                $result=mysqli_query($this->link, $query)or die(mysqli_error());
                $idViatico= mysqli_insert_id($this->link);

                if($result)
                {
                  $verifica = $this -> guardarDetalleViaticos($tipoMov,$detalle,$idViatico,$folio,$reposicionGasto);
                    
                }else{
                    $verifica = 0;
                }
              }else{//--RESULT
                $verifica = 0;
            }
        }else{
            $verifica = 0;
        }
      }else{//---ACTUALIZA
        
        $query="UPDATE viaticos set folio='$folio',id_unidad_negocio='$idUnidadNegocio',
                id_sucursal='$idSucursal',id_area='$idArea',id_departamento='$idDepartamento',
                id_solicito='$idSolicito',estatus='A',destino='$destino',distancia='$distancia',
                id_empleado='$idEmpleado',nombre_empleado='$empleado',reposicion_gasto='$reposicionGasto',
                motivos='$motivos',fecha_inicio='$fechaInicio',fecha_fin='$fechaFin',dias='$dias',
                noches='$noches',prospectacion='$prospectacion',atencion='$atencion',otros='$otros',
                fecha_comprobacion='$fechaComprobacion',autorizo='$autorizo',total='$total',
                id_usuario_captura='$idUsuario',usuario_captura='$usuario',
                id_familia_gasto='$idFamiliaGasto',id_clasificacion_gasto='$idClasificacionGasto' 
                WHERE id=".$idViatico;
        $result=mysqli_query($this->link, $query)or die(mysqli_error());
        

        if($result)
        {
          
            //--- se eliminan las partidas actuales  para volverlas a insertar
            $queryBorra = "DELETE FROM viaticos_d WHERE id_viaticos=".$idViatico;
            $resultB = mysqli_query($this->link, $queryBorra) or die(mysqli_error());
            if($resultB){

              $verifica = $this -> guardarDetalleViaticos($tipoMov,$detalle,$idViatico,$folio,$reposicionGasto);

            }else{

              $verifica = 0;
            }
          
            
        }else{
            $verifica = 0;
        }

      }  
    

return $verifica;
}

    function guardarDetalleViaticos($tipoMov,$detalle,$idViatico,$folio,$reposicionGasto){
     
      $verifica=0;
      

      for($i=1;$i<=$detalle[0];$i++){

        $idClasificacion = $detalle[$i]['idClasificacion'];
        $cantidad = $detalle[$i]['cantidad'];
        $importe = $detalle[$i]['importe'];
        //-->NJES June/04/2020 agregar observaciones a cada partida
        $observaciones = $detalle[$i]['observaciones'];
        
        $query = "INSERT INTO viaticos_d (id_viaticos,id_clasificacion,cantidad,importe_unitario,observaciones) 
        VALUES ('$idViatico','$idClasificacion','$cantidad','$importe','$observaciones')";
        $resultD = mysqli_query($this->link, $query) or die(mysqli_error());
        if($resultD)
        {

          if($i==$detalle[0]){
            $verifica = $idViatico;
            break;
          }

        }else{
          $verifica = 0;
          break;
        }

      }

      return $verifica;
      
    }

    
    /**
      * Busca los datos de una viaticos, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=ininactivo 2=todos
      *
      **/
      function buscarViaticos($idsSucursal,$busqueda){

        $dato=substr($idsSucursal,1);

        $condicionSucursales='WHERE viaticos.id_sucursal in ('.$dato.')';
        $condicion='';

        if($busqueda==1){
          //-->NJES December/29/2020 cambiar CA (cancelado) por C
          $condicion = " AND viaticos.estatus IN ('A','S','C')";
        }

        if($busqueda==2){
          //-->NJES December/29/2020 cambiar C (comprobado) por CO
          $condicion = " AND viaticos.estatus='CO' AND viaticos.fecha_comprobacion >= DATE_SUB(CURRENT_DATE(),INTERVAL 2 MONTH) ";
        }

        if($busqueda==3){
          $condicion = "  AND viaticos.fecha_comprobacion >= DATE_SUB(CURRENT_DATE(),INTERVAL 1 YEAR) ";
        }
        
        $resultado = $this->link->query("SELECT 
          viaticos.id,
          viaticos.folio,
          DATE(viaticos.fecha_captura) AS fecha_captura,
          viaticos.destino,
          viaticos.total,
          viaticos.estatus,
          viaticos.impresa,
          unidad.nombre AS unidad,
          sucursales.descr AS sucursal,
          IF(viaticos.id_empleado=0,viaticos.nombre_empleado,(CONCAT(trabajadores.nombre,' ',trabajadores.apellido_p,' ',trabajadores.apellido_m))) AS empleado,
          IF(viaticos.estatus='S' AND viaticos.reposicion_gasto=0,IFNULL(deudores_diversos.id,0),1) AS id_deudor_diverso
          FROM  viaticos 
          LEFT JOIN cat_unidades_negocio AS unidad ON  viaticos.id_unidad_negocio = unidad.id
          LEFT JOIN sucursales ON viaticos.id_sucursal = sucursales.id_sucursal
          LEFT JOIN trabajadores ON viaticos.id_empleado =  trabajadores.id_trabajador
          LEFT JOIN deudores_diversos ON viaticos.id=deudores_diversos.id_viatico
          $condicionSucursales $condicion
          ORDER BY viaticos.id DESC");
          return query2json($resultado);

      }//- fin function buscarViaticos

      function buscarViaticosId($idViatico){
      
        $resultado = $this->link->query("SELECT 
        viaticos.id,
        viaticos.folio,
        viaticos.id_unidad_negocio,
        viaticos.id_sucursal,
        viaticos.id_area,
        viaticos.id_departamento,
        viaticos.id_solicito,
        viaticos.estatus,
        viaticos.destino,
        viaticos.distancia,
        viaticos.reposicion_gasto,
        viaticos.id_empleado,
        viaticos.motivos,
        viaticos.fecha_inicio,
        viaticos.fecha_fin,
        viaticos.dias,
        viaticos.noches,
        viaticos.prospectacion,
        viaticos.atencion,
        viaticos.otros,
        viaticos.fecha_comprobacion,
        viaticos.autorizo,
        viaticos.total,
        viaticos.id_usuario_captura,
        viaticos.usuario_captura,
        viaticos.devolucion,
        viaticos.id_cuenta,
        viaticos.descuento_nomina,
        viaticos.quincenas,
        viaticos.impresa,
        IF(viaticos.id_empleado=0,viaticos.nombre_empleado,
        CONCAT(TRIM(empleado.nombre),' ',TRIM(empleado.apellido_p),' ',TRIM(empleado.apellido_m))) AS empleado,
        CONCAT(TRIM(trabajadores.nombre),' ',TRIM(trabajadores.apellido_p),' ',TRIM(trabajadores.apellido_m)) AS solicito,
        unidad.nombre AS unidad,
        sucursales.descr AS sucursal,
        deptos.des_dep AS departamento,
        cat_areas.descripcion AS are,
        IF(viaticos.estatus='S' AND viaticos.reposicion_gasto=0,IFNULL(deudores_diversos.id,0),1) AS id_deudor_diverso,
        IFNULL(deudores_diversos.comprobado,0) AS comprobado_dd,
        IFNULL(cxp.estatus,'') AS estatus_cxp
      FROM  viaticos 
      LEFT JOIN cat_unidades_negocio AS unidad ON  viaticos.id_unidad_negocio = unidad.id
      LEFT JOIN sucursales ON viaticos.id_sucursal = sucursales.id_sucursal
      LEFT JOIN cat_areas ON viaticos.id_area = cat_areas.id
      LEFT JOIN deptos ON viaticos.id_departamento=deptos.id_depto
      LEFT JOIN trabajadores AS empleado ON viaticos.id_empleado=empleado.id_trabajador
      LEFT JOIN trabajadores ON viaticos.id_solicito=trabajadores.id_trabajador
      LEFT JOIN deudores_diversos ON viaticos.id=deudores_diversos.id_viatico
      LEFT JOIN cxp ON viaticos.id=cxp.id_viatico
      WHERE viaticos.id=".$idViatico);
        return query2json($resultado);
          

      }//- fin function buscarViaticosId


      /**
      * Busca los datos de detalle de un viaticos, retorna un JSON con los datos correspondientes
      * 
      **/
      function buscarViaticosIdDetalle($idViatico){

    
          $resultado = $this->link->query("SELECT 
          viaticos_d.id,
          viaticos_d.id_viaticos,
          viaticos_d.id_clasificacion,
          viaticos_d.cantidad,
          viaticos_d.importe_unitario AS importe,
          viaticos_d.gasto_comprobado,
          viaticos_d.diferencia,
          viaticos_d.referencia,
          viaticos_clasificacion.descripcion AS clasificacion,
          viaticos_d.observaciones
          FROM  viaticos_d 
          LEFT JOIN viaticos_clasificacion ON viaticos_d.id_clasificacion= viaticos_clasificacion.id
          WHERE viaticos_d.id_viaticos=".$idViatico."
          ORDER BY viaticos_d.id ASC ");
          return query2json($resultado);
  
        }//- fin function buscarViaticos


      /**
      * Busca los datos de detalle de un viaticos, retorna un JSON con los datos correspondientes
      * 
      **/
      function imprimirViaticos($idViatico){

        $verifica = 0;

        $queryI = "UPDATE viaticos SET impresa=1 WHERE id=".$idViatico;
        $resultI = mysqli_query($this->link, $queryI) or die(mysqli_error());
        if($resultI)
        {
          $verifica = $idViatico;
        }

        return $verifica;

      }//- fin function buscarViaticos  

      /**
      * Busca los datos de detalle de un viaticos, retorna un JSON con los datos correspondientes
      * 
      **/
      function solicitarViaticos($idViatico){

        $verifica = 0;

        $queryE = "UPDATE viaticos SET estatus='S' WHERE id=".$idViatico;
        $resultE = mysqli_query($this->link, $queryE) or die(mysqli_error());
        if($resultE)
        {
          $verifica = $idViatico;
        }

        return $verifica;

      }//- fin function buscarViaticos
 

      /**
      * Manda llamar a la funcion que guarda la informacion sobre una viaticos
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param varchar $descripcion brebe descripcion de una viaticos
      * @param int $ininactivo estatus de una viaticos  1='inactivo' 0='Ininactivo'  
      *
    **/      
    function comprobarViaticos($boton,$datos){
   
      $verifica = 0;

      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");

      $verifica = $this -> actualizaViaticos($boton,$datos);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;

  } //-- fin function comprobarViaticos


      /**
      * Guarda los datos de una viaticos, regresa el id afectado si se realiza la accion correctamete ó 0 si ocurre algun error
      * 
      * @param int $tipoMov si tipo es 0 es una insercion si tipo=1 es una actualización
      * @param int $id si es una actualizacion se usa el id del viaticos para realizarla
      * @param varchar $descripcion brebe descripcion de una viaticos
      * @param int $ininactivo estatus de una viaticos  1='inactivo' 0='Ininactivo'  
      *
      **/ 
      function actualizaViaticos($boton,$datos){
          
        $verifica = 0;
      
        $folio = $datos['folio'];
        
        $idViatico= $datos['idViatico'];
        $devolucion = $datos['devolucion'];
        $idCuentaBanco = $datos['idCuentaBanco'];
        $descuento = $datos['descuento'];
        $quincenas = $datos['quincenas'];
        $reposicionGasto = $datos['reposicionGasto'];
        $estatus = 'S';
        if($reposicionGasto == 1 && $boton=='b_aplicar'){
          $estatus = 'C';
        }
        
        $detalle = $datos['detalleC'];

        $query="UPDATE viaticos SET estatus='$estatus',devolucion='$devolucion',id_cuenta='$idCuentaBanco',descuento_nomina='$descuento',quincenas='$quincenas' WHERE id=".$idViatico;
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        if($result){
  
          if($reposicionGasto == 1 && $estatus=='C'){
          
            $verifica = $this -> guardarCXP($datos,$folio);

          }else{
           
            $verifica = $this -> guardarDetalleComprobacionViaticos($detalle,$idViatico);
          }

        }else{

          $verifica = 0;
        }
          
        return $verifica;
      }

    function guardarDetalleComprobacionViaticos($detalle,$idViatico){
      
      $verifica=0;
      

       foreach($detalle as $de)
      {

        $idViaticoD = $de['idViaticoD'];
        $comprobado = $de['comprobado'];
        $diferencia = $de['diferencia'];
        $referencia = $de['referencia'];
      
        $query="UPDATE viaticos_d set gasto_comprobado='$comprobado',diferencia='$diferencia',referencia='$referencia' WHERE id=".$idViaticoD;
        $result=mysqli_query($this->link, $query)or die(mysqli_error());
        $resultD = mysqli_query($this->link, $query) or die(mysqli_error());
        if($resultD)
        {

          //if($i==$detalle[0]){
            $verifica = $idViatico;
            ///break;
          //}

        }else{
          $verifica = 0;
          break;
        }

      }

      return $verifica;
      
    }

    function guardarCXP($datos,$folio){
     
        $verifica=0;

        $detalle = $datos['detalleC'];
        $idUnidadNegocioNegocio = $datos['idUnidadNegocio'];
        $idSucursal = $datos['idSucursal'];
        $idViatico = $datos['idViatico'];
        $idDepartamento = $datos['idDepartamento'];
        $idArea = $datos['idArea'];
        $idEmpleado = $datos['idEmpleado'];
        $empleado = $datos['empleado'];
        $importe = $datos['total'];
        $concepto = 'GASTOS DE VIAJE (VIATICOS)';
        $idConcepto = 18;
        $claveConcepto = 'C04';
        $estatus = 'P';//--MGFS 09-01-2020 SE CAMBIO A POR P YA QUE EN CXP SOLO SE MANEJAN ESTATUS P,C,L
        $idFamiliaGasto = $datos['idFamiliaGasto'];

        //-->NJES Jan/20/2020 Guardar id_clasificacion_gasto 
        $idClasificacionGasto = $datos['idClasificacionGasto'];


        $query = "INSERT INTO cxp(no_factura,id_concepto,clave_concepto,fecha,subtotal,referencia,id_unidad_negocio,id_sucursal,id_area,id_departamento,concepto,estatus,id_empleado,nombre_empleado,id_viatico,id_familia_gasto,id_clasificacion_gasto) 
                  VALUES ('$folio','$idConcepto','$claveConcepto',CURRENT_DATE(),'$importe','$folio','$idUnidadNegocioNegocio','$idSucursal','$idArea','$idDepartamento','$concepto','$estatus','$idEmpleado','$empleado','$idViatico','$idFamiliaGasto','$idClasificacionGasto')";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idCXP = mysqli_insert_id($this->link);

         /*--- se actualiza el registro generado para asiganrle el id_cxp para que sea el cargo inicial 
            ya que es como internamente lo reconocemos id=id_cxp*/
        $actualiza = "UPDATE cxp SET id_cxp='$idCXP' WHERE id=".$idCXP; 
        $result2 = mysqli_query($this->link, $actualiza) or die(mysqli_error());
        if($result2){

           $verifica = $this -> guardarDetalleComprobacionViaticos($detalle,$idViatico);
        }else{
          $verifica = 0;
        }
      
        return $verifica;
       
    }

    /**
      * Busca los datos de una viaticos, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivo 0=ininactivo 2=todos
      *
      **/
      function buscarReporteViaticos($idsSucursal,$fechaInicio,$fechaFin){

     
        $dato=substr($idsSucursal,1);
       
  
        $condicionSucursales='WHERE a.id_sucursal in ('.$dato.')';

        $condicion='';

        if($fechaInicio == '' && $fechaFin == '')
        {
          $condicion=" AND MONTH(a.fecha_captura)= MONTH(CURDATE()) AND YEAR(a.fecha)= YEAR(CURDATE()) ";
        }else if($fechaInicio != '' &&  $fechaFin == '')
        {
          $condicion=" AND a.fecha_captura >= '$fechaInicio' ";
        }else{  //-->trae fecha inicio y fecha fin
          $condicion=" AND DATE(a.fecha_captura) BETWEEN '$fechaInicio' AND '$fechaFin' ";
        }
       
        
         $resultado = $this->link->query("SELECT 
                                            a.id,
                                            a.folio,
                                            DATE(a.fecha_captura) AS fecha_captura,
                                            a.destino,
                                            a.fecha_inicio,
                                            a.fecha_fin,
                                            a.total,
                                            IF(a.estatus='A','ACTIVO',IF(a.estatus='S','SOLICITADO',IF(a.estatus='CA','CANCELADO','COMPROBADO'))) AS estatus,
                                            a.impresa,
                                            e.nombre AS unidad,
                                            b.descr AS sucursal,
                                            IF(a.id_empleado=0,a.nombre_empleado,(CONCAT(c.nombre,' ',c.apellido_p,' ',c.apellido_m))) AS empleado,
                                            IF(a.estatus='S' AND a.reposicion_gasto=0,IFNULL(d.id,0),1) AS id_deudor_diverso,
                                            IF(a.reposicion_gasto=0,'DEUDOR DIVERSO','REPOSICIÓN GASTO') AS tipo,
                                            IF(a.estatus='CA','CANCELADO', IF(IFNULL(d.id_viatico,0) > 0, IF(d.id is null, 'Sin Pagar','Pagado'),IF(IFNULL(f.id_viatico,0) > 0,IF(f.estatus='L','Pagado',IF(f.estatus='C','Cancelado','Sin Pagar')),'Sin Pagar'))) AS estatus_finanzas,
                                            a.usuario_captura
                                          FROM  viaticos a
                                          LEFT JOIN cat_unidades_negocio e ON  a.id_unidad_negocio = e.id
                                          LEFT JOIN sucursales b ON a.id_sucursal = b.id_sucursal
                                          LEFT JOIN trabajadores c ON a.id_empleado =  c.id_trabajador
                                          LEFT JOIN deudores_diversos d ON a.id=d.id_viatico
                                          LEFT JOIN cxp f ON a.id=f.id_viatico
                                          $condicionSucursales $condicion
                                          GROUP BY a.id
                                          ORDER BY a.id DESC");
          return query2json($resultado);
  
        }//- fin function buscarViaticos
  
        function cancelarViaticosId($idViatico){
          $verifica = 0;

          $this->link->begin_transaction();
          $this->link->query("START TRANSACTION;");
            
          //-->NJES September/09/2020 se agrega que se pueda solicitar un viatico si aun no ha sido comprobado o no tiene abonos.
          $verifica = $this -> cancelar($idViatico);

          if($verifica > 0)
              $this->link->query("commit;");
          else
              $this->link->query('rollback;');

          return $verifica;
        }

        function cancelar($idViatico){
          $verifica = 0;

          $query = "UPDATE viaticos SET estatus = 'CA' WHERE id = $idViatico";
          $result = mysqli_query($this->link, $query)or die(mysqli_error());

          if($result)
          {
            //-->busca si tiene cargo en cxp ligado al viatico para cancelarlo, ya que no tiene abonos
            $buscaCxP = "SELECT COUNT(id) AS id FROM cxp WHERE id_viatico=$idViatico";
            $resultCxP = mysqli_query($this->link, $buscaCxP)or die(mysqli_error());
            $rowCxP = mysqli_fetch_array($resultCxP);

            if($rowCxP['id'] > 0)
            {
              //-->si tiene registro y lo cancela
              $actualiza = "UPDATE cxp SET estatus='C' WHERE id_viatico=".$idViatico; 
              $result2 = mysqli_query($this->link, $actualiza) or die(mysqli_error());
              if($result2)
                $verifica = 1;
            }else{
              //-->no tiwnw registro en cxp, busca si tiene registro en deudores diversos ligado al viatico
              $buscaDD = "SELECT COUNT(id) AS num,importe,id_unidad_negocio,id_sucursal,id_familia_gastos,id_clasificacion_gasto 
                                FROM deudores_diversos WHERE id_viatico=".$idViatico;
              $resultDD = mysqli_query($this->link, $buscaDD)or die(mysqli_error());
              $rowDD = mysqli_fetch_array($resultDD);

              if($rowDD['num'] > 0)
              {
                //-->afectar movimientos_presupuesto con importe negativo para que funcione como contrapartida
                $afectarPresupuesto = new MovimientosPresupuesto();

                $monto = (-1)*$rowDD['importe'];
                $arrDatosMP = array(
                  'idUnidadNegocio' => $rowDD['id_unidad_negocio'],
                  'idSucursal' => $rowDD['id_sucursal'],
                  'idFamiliaGasto' => $rowDD['id_familia_gasto'],
                  'clasificacionGasto' => $rowDD['id_clasificacion'],
                  'total' => $monto,
                  'tipo' => 'C',
                  'idGasto' => 0,
                  'idViatico' => $idViatico
                );
    
                $resultMP = $afectarPresupuesto->guardarMovimientoPresupuesto($arrDatosMP); 

                if($resultMP > 0)
                {
                  //-->cancelar afectacion en movimientos_bancos
                  $cancelaCB = "UPDATE movimientos_bancos SET estatus=0 WHERE id_viatico=".$idViatico; 
                  $resultCB = mysqli_query($this->link, $cancelaCB) or die(mysqli_error());
                  if($resultCB)
                  {
                    //-->si tiene registro en deudores diversos, en este caso lo eliminara 
                    //porque no se maneja el estatus y para que no se siga mostrando en el modulo de Deudores Diveros
                    $elimina = "DELETE FROM deudores_diversos WHERE id_viatico=".$idViatico;
                    $result2 = mysqli_query($this->link, $elimina) or die(mysqli_error());
                    if($result2)
                      $verifica = 1;
                  }
                }

              }else  //-->no tiene registro ligado en cxp ni en viaticos y solo asigna en verifia 1 porque solo se cancelo el viatico que no habia sido solicitado
                $verifica = 1;
            }

          }

          return $verifica;
        }
    
}//--fin de class Viaticos
    
?>