<?php

include 'conectar.php';

class CargarDatos
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function CargarDatos()
    {
  
      $this->link = Conectarse();

    }

    function validaFormato() // 1
    {

      $verifica = false;
      if( mime_content_type($_FILES['xml']['tmp_name'])  == 'application/xml')
        $verifica = true;
  
      return  $verifica;

    }

    function validarUTF8()
    {

      $verifica = false;
      if( mb_detect_encoding($_FILES['xml']['tmp_name'], 'UTF-8') == 'UTF-8')
        $verifica = true;
  
      return  $verifica;

    }

    function validaRFCPruebas($rfc)
    {

      $verifica = false;
      $rfcPruebas = array( 'LAN7008173R5', 'SUL010720JN8', 'LAN8507268IA', 'TCM970625MB1', 'MAG041126GT8', 'TME960709LR2', 
        'MAR980114GQA', 'ULC051129GC0', 'MSE061107IA8', 'URU070122S28', 'PZA000413788', 'VOC990129I26'
      );

      if(array_search($rfc, $rfcPruebas) === false)
        $verifica = true;

      return $verifica;

    }

    function validaRFCEmisor($idProveedor, $rfcEmisor)
    {

      $verifica = false;

      $result = mysqli_query($this->link, "SELECT rfc FROM proveedores WHERE id = $idProveedor");
      $row = mysqli_fetch_assoc($result);

      if($row['rfc'] == $rfcEmisor)
        $verifica = true;

      return $verifica;

    }

    function validaRFCReceptor($idProveedor, $folio, $rfcReceptor, $folioEntrada)
    {

      $verifica = false;

      $result = mysqli_query($this->link, "SELECT empresas_fiscales.rfc AS rfc
      FROM empresas_fiscales
      INNER JOIN orden_compra ON empresas_fiscales.id_empresa = orden_compra.id_empresa_fiscal
      LEFT JOIN almacen_e ON orden_compra.id=almacen_e.id_oc
      WHERE orden_compra.id_proveedor = ".$idProveedor."
      AND orden_compra.folio = ".$folio." AND almacen_e.folio=".$folioEntrada);
      $row = mysqli_fetch_assoc($result);

      if(trim($row['rfc']) == trim($rfcReceptor))
        $verifica = true;

      return $verifica;

    }

    function validaRFCReceptorCorp($rfcReceptor)
    {

      $verifica = false;

      $result = mysqli_query($this->link, "SELECT rfc
      FROM empresas_fiscales
      WHERE rfc = '$rfcReceptor");
      $row = mysqli_fetch_assoc($result);

      if($row['rfc'] == $rfcReceptor)
        $verifica = true;

      return $verifica;

    }

    function validaPartidasEntrada($idProveedor, $folioEntrada, $totalConceptos)
    {

      $verifica = false;

      $result = mysqli_query($this->link, "SELECT COUNT(almacen_d.id) as total
        FROM almacen_d
        INNER JOIN almacen_e ON almacen_d.id_almacen_e = almacen_e.id
        WHERE almacen_e.id_proveedor  = $idProveedor        
        AND almacen_e.folio = $folioEntrada");
      $row = mysqli_fetch_assoc($result);

      if($row['total'] == $totalConceptos)
        $verifica = true;

      return $verifica;

    }

    function validaTipo($idProveedor, $folioOC, $folioEntrada)
    {

      $verifica = false;

      $query = "SELECT tipo FROM orden_compra WHERE id_proveedor = $idProveedor AND folio = $folioOC";
      $result = mysqli_query($this->link, $query) or die(mysqli_error());

      if($result)
      {

        $r = mysqli_fetch_array($result);
        if($r['tipo'] == 4)
         $verifica = true;

      }


      return $verifica;

    }

    function validarXML($idProveedor, $folioOC, $folioEntrada)
    {

      $verificaA = array();
      $verifica = true;
      $validaciones = array();

      $xml= file_get_contents($_FILES['xml']['tmp_name']);
      $sxml = simplexml_load_string($xml);
      $sxml->registerXPathNamespace('c','http://www.sat.gob.mx/cfd/3');
      $comprobante = (array)$sxml->xpath('//c:Comprobante');
      $comprobanteData = $comprobante[0];

      $receptor = (array)$sxml->xpath('//c:Receptor');//CORP
      $receptorData = $receptor[0];

      $emisor = (array)$sxml->xpath('//c:Emisor');//PROVEEDOR
      $emisorData = $emisor[0];

      $conceptos = $sxml->xpath('//c:Concepto');

      if(($_FILES['xml']['tmp_name']))
      {


        if($this->validarUTF8() != true)
        {
          $verifica = false;
          array_push($validaciones, 'La codificación del archivo es UTF-8');
        }

        if($this->validaRFCPruebas($emisorData['Rfc']) != true)
        {
          $verifica = false;
          array_push($validaciones, 'El RFC no corresponde a un RFC de pruebas para Timbrado');
        }

        if($this->validaRFCEmisor($idProveedor, $emisorData['Rfc']) != true)
        {
          $verifica = false;
          array_push($validaciones, 'El RFC del emisor corresponde al RFC del Proveedor ');
        }

        if($this->validaEntradaRepetida($folioEntrada, $folioOC) == true)
        {
          $verifica = false;
          array_push($validaciones, 'La factura ya se encuentra cargada');
        }

        if($this->validaTipo($idProveedor, $folioOC, $folioEntrada))
        {

          if($this->validaRFCReceptorCorp($receptorData['Rfc']) != true)
          {
            $verifica = false;
            array_push($validaciones, 'El RFC del receptor corresponde al RFC de la empresa fiscal de Corporativo' . $receptorData['Rfc'] );
          }

        }
        else
        {

          if($this->validaRFCReceptor($idProveedor, $folioOC, $receptorData['Rfc'], $folioEntrada) != true)
          {
            $verifica = false;
            array_push($validaciones, 'El RFC del receptor corresponde al RFC de la empresa fiscal');          
          }

        }

        

      }

      $verificaA['verifica'] = $verifica;
      $verificaA['validaciones'] = $validaciones;

      return json_encode($verificaA);

    }

    /**
      * Verifica que la clave de una unidad de negocio no se repita
      *
      * @param varchar $clave es una clave para identificar una unidad de negocio
      *
      **/
    function validarCargarDatos($idProveedor,$folioOc,$folioEntrada)
    {


      $verifica = $this->validarXML($idProveedor, $folioOc, $folioEntrada);
     
      //$verifica = 1;
      //--- debes validar que no  se haya ingresado esa informacion solo debes verificar que en la entrada por compra no tenga el xml 
      //--- o vericar si no tiene un cxp con estatus ='P' por que si no te dejara cargar la misma informacion y se generaran varios cargos por la misma factura
     
       return $verifica;

    }//-- fin function verificaCargarDatos

    /**
      * Manda llamar a la funcion que carga los datos del proveedor sobre una factura PDF,XML OC y en Entrada por Compra (E01)
      * 
      * @param int $idProveedor es id del proveedor que esta cargando sus datos
      * @param int $folioOc folio de la orden de compra se tiene que calcular el id del registro
      * @param int $folioEntrada es el folio generado segun la unidad de negocio se tiene que obtener el id de registro 
      *
      **/      
    function guardarCargarDatos($idProveedor,$folioOc,$folioEntrada){
        
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $buscaIdE01 = "SELECT a.id,a.id_oc 
        FROM almacen_e a
        LEFT JOIN orden_compra b ON a.id_oc=b.id
        WHERE a.folio=".$folioEntrada." AND a.id_proveedor=".$idProveedor." AND b.folio=".$folioOc;
        
        // echo $buscaIdE01;
        // exit();
        $resultIdE01 =  mysqli_query($this->link, $buscaIdE01) or die(mysqli_error());
        $rowE01 = mysqli_fetch_array($resultIdE01);
        $idE01 = $rowE01['id'];
        $idOc = $rowE01['id_oc'];

        //--> NJES Jan/30/2020 enviar el id de la orden de compra para despues poder obtener sus requisiciones
        $verifica = $this-> guardarArchivosPDF($idProveedor,$idE01,$idOc);

        if($verifica === 0)//if($verifica > 0)  |||||||||||||
            $this->link->query('rollback;');
        else
            $this->link->query("commit;");

        return $verifica;

    } //-- fin function guardarCargarDatos


     
    /**
      * Guarda el PDF de la factura
      * Los parametros recibidos son solo para asiganrle el nombre al archivo (pdf_idProveedor_idE01.pdf) y buscar la info del proveedor
      * como ya es el id de entrada por compra no se repetiran los nombres 
      * 
      * @param int $idProveedor
      * @param int $idE01 = id de registro de la entrada por compra de la factura (es el auto incremental y es unico)
      *
      **/ 
    function guardarArchivosPDF($idProveedor,$idE01,$idOc){
    
        $verifica = 0;
       
        if(isset($_FILES['pdf']['name'])){
        
          $nombrePdf="pdf_".$idProveedor."_".$idE01.".pdf";
          $rutaPDF = "../PDF/".$nombrePdf;
        
          if((move_uploaded_file($_FILES['pdf']['tmp_name'],$rutaPDF))){
           
            $verifica = $this -> guardarArchivosXML($idProveedor,$idE01,$idOc);

          }else
            $verifica = 0;

        }
        return $verifica;
     
    }

     /**
      * Guardo el xml en la carpeta XML y obtencgo su contenido para guardarlo en almacen_e donde el folio y la oc sean igual
      * Los parametros recibidos son solo para asiganrle el nombre al archivo (xml_idProveedor_idE01.xml) y buscar la info del proveedor
      * @param int $idProveedor
      * @param int $idE01 = id de registro de la entrada por compra (almacen_e) de la factura
      *
      **/ 
    function guardarArchivosXML($idProveedor,$idE01,$idOc){
      $verifica = 0;

      $valorDefault = 2;  //-->Valor para restar o sumar y comparar el subtotal del xml de la factura al cargar dato con el subtotal de la 
      // entrada por compra a pagar, por ejemplo el subttal de la entrada compra es de 1000 y el proveedor sube una factura
      // con un subtotal de 1010 no lo deja subirlo, pero si sube un xml de 1002, 1001, 1000, 998 o 999 si dejara subirlo.

      if(isset($_FILES['xml']['name'])){

        $nombre_imagen=$_FILES['xml']['name']; 
        $nombreXml="xml_".$idProveedor."_".$idE01.".xml";
        $rutaXML = "../XML/".$nombreXml;
       
        if((move_uploaded_file($_FILES['xml']['tmp_name'],$rutaXML)))
        {

          $xml= file_get_contents($rutaXML);   //--- obtengo el contenido del xml y lo convierto a string para insertarlo en almacen
          $sxml = simplexml_load_string($xml); //-- se carga el string generado para obtener la informacion de sus nodos

          $sxml->registerXPathNamespace('c','http://www.sat.gob.mx/cfd/3');//Declaramos el Name Space cfdi como c

          $comprobante = (array)$sxml->xpath('//c:Comprobante');//Obtenemos el array de cfdi:Comprobante
          $comprobante_data = $comprobante[0];
          $factura = $comprobante_data['Folio'];

          //-->NJES Jan/30/2020 calcularemos si se va a generar cxp con monto restante o ya se cubrio con los cxp de las requis de la OC si los genero por anticipo
          $importe = $comprobante_data['SubTotal'];
          $importeTotal = $comprobante_data['Total'];

          $descuento = 0;

          if(isset($comprobante_data['Descuento']))
            $descuento = $comprobante_data['Descuento'];



          $sxml->registerXPathNamespace('t', 'http://www.sat.gob.mx/TimbreFiscalDigital');//Declaramos el Name Space tfd como t
          $traslado = (array)$sxml->xpath('//c:Impuestos');//Obtenemos el array de tfd:TimbreFiscalDigital
          end($traslado);
          $key = key($traslado);
          $traslado_data = $traslado[$key];
          $iva = $traslado_data['TotalImpuestosTrasladados'];

          //-->NJES April/17/2020 obtener el onto de la entrada compr

          $entradaC = "SELECT SUM(cantidad*precio) + SUM( (cantidad*precio) / 100 * iva  )  AS total FROM almacen_d WHERE id_almacen_e = ".$idE01;
          $resultEntradaC =  mysqli_query($this->link, $entradaC) or die(mysqli_error());
          $rowECO = mysqli_fetch_array($resultEntradaC);
          $subtotalECOrigen = $rowECO['total'];  // subtotal

          $subtotalECOrigen = (float)$subtotalECOrigen; //+ (float)$descuento; 

          if($importeTotal >= ($subtotalECOrigen-$valorDefault) && $importeTotal <= ($subtotalECOrigen+$valorDefault))
          {

            //-->NJES Jan/30/2020 busca los id requisiciones de la orden de compra para ver si ya existen cxp de esas requisiciones
            $buscaIdRD = "SELECT ids_requisiciones FROM orden_compra WHERE id=".$idOc;
            $resultIdRD = mysqli_query($this->link, $buscaIdRD) or die(mysqli_error());

            $rowIdRD = mysqli_fetch_array($resultIdRD);
            $idRequisD = $rowIdRD['ids_requisiciones'];

            $buscaDT = "SELECT SUM(almacen_d.cantidad*requisiciones_d.descuento_unitario) AS descuento_total
            FROM almacen_d
            LEFT JOIN orden_compra_d ON almacen_d.id_oc_d=orden_compra_d.id
            LEFT JOIN requisiciones_d ON orden_compra_d.id_requi_d=requisiciones_d.id
            where almacen_d.id_almacen_e=".$idE01;

            $resultDT = mysqli_query($this->link, $buscaDT) or die(mysqli_error());
                  
            $rowDT = mysqli_fetch_array($resultDT);
            $descuento_total = $rowDT['descuento_total'];

      


                $buscaIdR = "SELECT ids_requisiciones FROM orden_compra WHERE id=".$idOc;
                $resultIdR = mysqli_query($this->link, $buscaIdR) or die(mysqli_error());

                $numIdR = mysqli_num_rows($resultIdR);
                if($numIdR > 0)
                {
                  //echo 'si hay';
                  $rowIdR = mysqli_fetch_array($resultIdR);
                  $idRequis = $rowIdR['ids_requisiciones'];

                  $buscaCxpR = "SELECT IFNULL(SUM(iva+subtotal),0) AS total_anticipo FROM cxp WHERE id_requisicion IN(".$idRequis.") AND estatus!='C'";
                  $resultCxpR = mysqli_query($this->link, $buscaCxpR) or die(mysqli_error());
                  
                  $rowCxpR = mysqli_fetch_array($resultCxpR);
                  $total_anticipo = $rowCxpR['total_anticipo'];

                  $total_OC = $importe+$iva;
                  $importeActual = $importeTotal - $total_anticipo;  

                
                }
                else
                  $importeActual = $importe;  //-->NJES Jan/30/2020 la variable toma el valor de la variable

                $buscaFechaE01="SELECT date(fecha) as fecha_registro FROM almacen_e WHERE id=".$idE01;
                $resultFechaE01 =  mysqli_query($this->link, $buscaFechaE01) or die(mysqli_error());
                $rowFechaE01 = mysqli_fetch_array($resultFechaE01);
                $fechaE01 = $rowFechaE01['fecha_registro'];

                //--- se calcula la fecha de pago con la fecha de entrada por compra en lugar de la fecha de timbre
                $calculaFechaPago="SELECT  
                    IF(WEEKDAY(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY))=0,
                    DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY),
                    CASE 
                    WHEN WEEKDAY(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY)) = 1 THEN DATE_ADD(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY), INTERVAL 6 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY)) = 2 THEN DATE_ADD(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY), INTERVAL 5 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY)) = 3 THEN DATE_ADD(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY), INTERVAL 4 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY)) = 4 THEN DATE_ADD(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY), INTERVAL 3 DAY)
                    WHEN WEEKDAY(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY)) = 5 THEN DATE_ADD(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY), INTERVAL 2 DAY)
                    ELSE DATE_ADD(DATE_ADD(DATE('$fechaE01'), INTERVAL dias_credito DAY), INTERVAL 1 DAY)
                    END) AS fecha_pago FROM proveedores WHERE id=".$idProveedor;
                $resultFecha =  mysqli_query($this->link, $calculaFechaPago) or die(mysqli_error());
                $rowFPago = mysqli_fetch_array($resultFecha);
                $fechaPago = $rowFPago['fecha_pago'];
                
                $xml = addslashes($xml);
                $query = "UPDATE almacen_e SET referencia='$factura',  xml='$xml' WHERE id=".$idE01;
                $result = mysqli_query($this->link, $query) or die(mysqli_error());
              
                if ($result) 
                {
                    // se envia la fecha de pago calculada y el id de registro de entrada por compra ya que se envia el folio originalmente
                    if($importeActual > 0)
                    {
                      $inf='SI';
                      $verifica = $fechaPago.','.$idE01.','.$idOc.','.$inf;  //-->Si va a generar contrarecibo y cxp
                    }
                    else
                    {

                      $inf='NO';
                      $verifica = $fechaPago.','.$idE01.','.$idOc.','.$inf;  //-->No va a generar contrarecibo ni cxp

                      $pos = strpos($idRequis, ',');

                      // Note our use of ===.  Simply == would not work as expected
                      // because the position of 'a' was the 0th (first) character.
                      if ($pos === false) 
                      {

                        //
                        $queryRequi = "SELECT b_anticipo, monto_anticipo FROM requisiciones WHERE id = $idRequis";
                        $resultRequi =  mysqli_query($this->link, $queryRequi) or die(mysqli_error());
                        $rowRequi = mysqli_fetch_array($resultRequi);
                        $bAnticipo = $rowRequi['b_anticipo'];


                        if($bAnticipo == 1)
                        {
                          
                          $queryCXP = "SELECT id, id_entrada_compra  FROM cxp WHERE id_requisicion = $idRequis";
                          $resultCXP =  mysqli_query($this->link, $queryCXP) or die(mysqli_error());
                          $rCXP = mysqli_fetch_array($resultCXP);
                          $idCXP = $rCXP['id'];
                          $idCXPE = $rCXP['id_entrada_compra'];


                          if($idCXPE == null)
                          {

                              $queryX = "UPDATE almacen_e SET referencia = '$factura',  xml = '$xml' WHERE id = $idE01" ;
                              $resultX = mysqli_query($this->link, $queryX) or die(mysqli_error());
                            
                              if ($resultX)
                              {

                                //$updateCxpReq = "UPDATE cxp SET id_entrada_compra=".$idE01.", estatus='L' WHERE id = $idCXP";
                                $updateCxpReq = "UPDATE cxp SET id_entrada_compra=".$idE01." WHERE id = $idCXP";
                                $resultCxpReq = mysqli_query($this->link, $updateCxpReq) or die(mysqli_error());
                                
                                if($resultCxpReq)
                                {

                                  $inf='ANTICIPO';
                                  $verifica = $fechaPago.','.$idE01.','.$idOc.','. $idRequis  . ',' . $idCXP .  ',' . $queryCXP . ' * ' . $updateCxpReq . $inf;
                                
                                }

                              }
                          
                          }                   

                        }
                        
                      }

                    }
                  
                }
                else
                  $verifica = 0; // result
            
            

          }
          else
          {
            //-->NJES April/17/2020  no permite cargar el archivo
            $inf='IMPORTE_MAL';
            $verifica = '0000-00-00,'.$idE01.','.$idOc.','. $inf .', ** ' . $subtotalECOrigen . ' *** ' . $importeTotal ;
          }

        }

      }
       return $verifica;
     
    }

    function verificaExistenciaEA($idE01)
    {

      $verifica = 0;

      $buscaRegistro = "SELECT id FROM cxp WHERE id_entrada_compra=".$idE01;
      $resultReg = mysqli_query($this->link, $buscaRegistro)or die(mysqli_error());
      $numReg = mysqli_num_rows($resultReg);

      if($numReg > 0)
        $verifica = 1;

      return $verifica;

    }

    function validaEntradaRepetida($folioEntrada, $folioOC)
    {

      $idProv = $_SESSION["idProveedor"];

      $verifica = 0;

      $buscaRegistro = "SELECT *
                        FROM cxp cxp
                        WHERE cxp.id_entrada_compra IN (SELECT id
                                                        FROM almacen_e
                                                        WHERE folio = '$folioEntrada' AND id_proveedor = $idProv 
                                                        AND id_oc IN (SELECT id
                                                                      FROM orden_compra
                                                                      WHERE folio = '$folioOC' AND id_proveedor = $idProv AND tipo NOT IN(0,3)
                                                                      )
                                                          );";

      $resultReg = mysqli_query($this->link, $buscaRegistro)or die(mysqli_error());
      $numReg = mysqli_num_rows($resultReg);

      if($numReg > 0)
        $verifica = 1;

      return $verifica;

    }

    //-->NJES Jan/30/2020 Se agrega funcion de transaccion al generar el cxp
    function guardarCXP($idProveedor,$idE01,$fechaVencimiento,$folioOc,$folioEntrada,$idOC){
      $verifica = 0;
  
      $this->link->begin_transaction();
      $this->link->query("START TRANSACTION;");
  
      $verifica = $this -> generarCXP($idProveedor,$idE01,$fechaVencimiento,$folioOc,$folioEntrada,$idOC);

      if($verifica > 0)
          $this->link->query("commit;");
      else
          $this->link->query('rollback;');

      return $verifica;
    }


    function generarCXP($idProveedor,$idE01,$fechaVencimiento,$folioOc,$folioEntrada,$idOC){
    
      $verifica = 0;

      $nombreXml="xml_".$idProveedor."_".$idE01.".xml"; //-- obtengo el nombre del archivo guardado
      $rutaXML = "../XML/".$nombreXml;                  //-- obtengo la ruta del xml

      $xml= file_get_contents($rutaXML);   //--- obtengo el contenido del xml y lo convierto a string para insertarlo en almacen
      $sxml = simplexml_load_string($xml); //-- se carga el string generado para obtener la informacion de sus nodos 

      $sxml->registerXPathNamespace('c','http://www.sat.gob.mx/cfd/3');//Declaramos el Name Space cfdi como c
      
      $receptor = (array)$sxml->xpath('//c:Receptor');
      $receptorData = $receptor[0];
      $rfcReceptor = $receptorData['Rfc'];

      $emisor = (array)$sxml->xpath('//c:Emisor');
      $emisorData = $emisor[0];
      $rfcEmisor = $emisorData['Rfc'];

      $comprobante = (array)$sxml->xpath('//c:Comprobante');//Obtenemos el array de cfdi:Comprobante
      $comprobante_data = $comprobante[0];

      $factura = $comprobante_data['Folio'];
      $total = $comprobante_data['Total'];
      $MetodoPago = $comprobante_data['MetodoPago'];
      $importe = $comprobante_data['SubTotal'];
      $descuento = 0; //$comprobante_data['Descuento'];

      //if(isset($comprobante_data['Descuento']))
        //$descuento = $comprobante_data['Descuento'];

      $sxml->registerXPathNamespace('t', 'http://www.sat.gob.mx/TimbreFiscalDigital');//Declaramos el Name Space tfd como t
      $timbre = (array)$sxml->xpath('//t:TimbreFiscalDigital');//Obtenemos el array de tfd:TimbreFiscalDigital
      $timbre_data = $timbre[0];
      $fecha = $timbre_data['FechaTimbrado'];
      $UUID = $timbre_data['UUID'];

      $traslado = (array)$sxml->xpath('//c:Impuestos');//Obtenemos el array de tfd:TimbreFiscalDigital
      end($traslado);
      $key = key($traslado);
      $traslado_data = $traslado[$key];
      //$iva = $traslado_data['TotalImpuestosTrasladados'];

      $iva = 0;
      if(isset($traslado_data['TotalImpuestosTrasladados']))
        $iva = $traslado_data['TotalImpuestosTrasladados'];

      //-->NJES September/08/2020 tomar el iva del xml
      /*$traslado_iva = (array)$sxml->xpath('//c:Traslado');
      end($traslado_iva);
      $keyT = key($traslado_iva);
      $traslado_iva_A = $traslado_iva[$keyT]->attributes();
      $TasaIva = bcdiv($traslado_iva_A['TasaOCuota'],'1',2); *///-->divide dos números de precisión arbitraria con el agregado que te permite recortar el resultado a una escala determinada sin redondear.
                                                            //-->Si la división es entre 1 entonces el resultado siempre es el número pero usas la escala para recortar a tu gusto.

      /*--- esta informacion se puso directanente ya que son tablas internas que no se van a modificar 
            en caso de modificacion se tendrá que cambiar aqui tambien */

      $idConcepto = 8;
      $claveConcepto= 'C01'; 
      $estatus = 'P';

      $referencia = 'PP OC-'.$folioOc.' RM-'.$folioEntrada;
      if($this->validaTipo($idProveedor, $folioOc, $folioEntrada))
        $referencia = 'PP OS-'.$folioOc.' RM-'.$folioEntrada;

      $ivaN = $iva;

      //-->NJES Jan/30/2020 busca los id requisiciones de la orden de compra para ver si ya existen cxp de esas requisiciones
      $buscaIdR = "SELECT ids_requisiciones FROM orden_compra WHERE id=".$idOC;
      $resultIdR = mysqli_query($this->link, $buscaIdR) or die(mysqli_error());
      $numIdR = mysqli_num_rows($resultIdR);

      $rowIdR = mysqli_fetch_array($resultIdR);
      $idRequis = $rowIdR['ids_requisiciones'];

      if($numIdR > 0)
      {
        $buscaCxpR = "SELECT IFNULL(SUM(iva+subtotal),0) AS total_anticipo FROM cxp WHERE id_requisicion IN(".$idRequis.") AND estatus!='C'";
        $resultCxpR = mysqli_query($this->link, $buscaCxpR) or die(mysqli_error());
        
        $rowCxpR = mysqli_fetch_array($resultCxpR);
        $total_anticipo = $rowCxpR['total_anticipo']; 

        //-->NJES December/02/2020 cuando la compra tiene requis con anticipos el iva sera 0 
        //y el subtotal sera el total de la factura menos anticipo porque no se puede calcular el iva 
        //ya que puede se agrego que puede tener iva de 0 y 16 ó 0 y 8
        if($total_anticipo > 0)
        {
          //$importeActual =  ( (double)$importe  - (double)$total_anticipo );
          $importeActual =  ( (double)$total  - (double)$total_anticipo );
          
          //-->NJES September/08/2020 tomar el iva del xml
          //$ivaN = $importeActual / 100 * ($TasaIva * 100); 
          //-->NJES December/02/2020 como las requis permiten diferentes iva en las partidas ya no se guardará
          //el iva, solo el total menos el anticipo
          $ivaN = 0;
          //-->NJES Jan/30/2020 se guarda el cxp con lo que resta del anticipo, sino existen cxp para esas requisiciones el
          //total anticipo es 0 y se le restara al total de la OC y el importe actual sera igual al original
        }else{
          //-->NJES December/02/2020 calcular el iva de las partidas de la entrada
          $query_ivas = "SELECT SUM((cantidad*precio)*(iva/100)) AS iva, SUM(cantidad*precio) AS importe
          FROM almacen_d
          WHERE id_almacen_e=".$idE01;
          $result_ivas = mysqli_query($this->link, $query_ivas) or die(mysqli_error());
                  
          $row_ivas = mysqli_fetch_array($result_ivas);
          $suma_ivas = $row_ivas['iva']; 
          $importeD =  $row_ivas['importe'];

          //$importeActual =  $importe;
          $importeActual =  $importeD;
          $ivaN = $suma_ivas;
        }
      }else{
        $importeActual = $importe;  //-->NJES Jan/30/2020 la variable toma el valor de la variable
      }

        /*--- obtengo el id_unidad_negocio, id_sucursal para poder guardar los datos en cxp y poder generar el contrarecibo 
              con los datos correpondientes a su sucursal y logo de la unidad de negocio */
        $buscaUnidad = "SELECT id_unidad_negocio, id_sucursal FROM almacen_e WHERE id=".$idE01;
        $resultUnidad = mysqli_query($this->link, $buscaUnidad) or die(mysqli_error());
        $rowU = mysqli_fetch_array($resultUnidad);
        $idUnidad = $rowU['id_unidad_negocio'];
        $idSucursal = $rowU['id_sucursal'];
        
      
        //--- se genera el cargo inicial en cxp de la factura ingresada
        $query = "INSERT INTO cxp(id_proveedor,no_factura,id_concepto,clave_concepto,fecha,subtotal,iva,referencia,id_unidad_negocio,id_sucursal,id_entrada_compra,estatus,metodo_pago,uuid_factura,rfc_emisor_factura,rfc_receptor_factura, descuento) 
                  VALUES ('$idProveedor','$factura','$idConcepto','$claveConcepto',CURDATE(),'$importeActual','$ivaN','$referencia','$idUnidad','$idSucursal','$idE01','$estatus','$MetodoPago','$UUID','$rfcEmisor','$rfcReceptor', $descuento)";
        $result = mysqli_query($this->link, $query) or die(mysqli_error());
        $idCXP = mysqli_insert_id($this->link);

        if($result)
        {
          /*--- se actualiza el registro generado para asignarle el id_cxp para que sea el cargo inicial 
                ya que es como internamente lo reconocemos id=id_cxp*/
          $actualiza = "UPDATE cxp SET id_cxp='$idCXP' WHERE id=".$idCXP; 
          $result2 = mysqli_query($this->link, $actualiza) or die(mysqli_error());
          if($result2)
          {
            $updateCxpReq = "UPDATE cxp SET id_entrada_compra=".$idE01." WHERE id_requisicion IN(".$idRequis.") AND estatus!='C'";
            $resultCxpReq = mysqli_query($this->link, $updateCxpReq) or die(mysqli_error());
            
            if($resultCxpReq)
              $verifica = $idCXP;
            else
              $verifica = 0;

          }else
            $verifica = 0;

        }else
          $verifica = 0;
      
      
      return $verifica;
     
    }

    /**
      * Busca los datos de una unidad de negocio, retorna un JSON con los datos correspondientes
      * 
      * @param int $id si id es 0 trae todos los registros, si no trae los datos de id requerido
      *
      **/
      function buscarCargarDatos($idProveedor){
        
        $resultado = $this->link->query("SELECT cxp.id,almacen_e.folio AS folio_entrada,orden_compra.folio AS folio_oc,
        cxp.estatus_complemento_pago,cxp.metodo_pago
        FROM cxp 
        inner JOIN almacen_e ON cxp.id_entrada_compra=almacen_e.id
        inner JOIN orden_compra ON almacen_e.id_oc=orden_compra.id
        WHERE cxp.id_proveedor=".$idProveedor." AND cxp.estatus NOT IN ('C','L') AND clave_concepto='C01' AND cxp.id=cxp.id_cxp
        ORDER BY almacen_e.id_oc");

        if($resultado)
          return query2json($resultado); 

    }//- fin function buscarUnidaddesNegocio


    function validarXMLPago($idCxP)
    {
      $verificaA = array();
      $verifica = true;
      $validaciones = array();

      $xml= file_get_contents($_FILES['xml']['tmp_name']);
      $sxml = simplexml_load_string($xml);
      $sxml->registerXPathNamespace('c','http://www.sat.gob.mx/cfd/3');
      
      $receptor = (array)$sxml->xpath('//c:Receptor');
      $receptorData = $receptor[0];

      $emisor = (array)$sxml->xpath('//c:Emisor');
      $emisorData = $emisor[0];

      $sxml->registerXPathNamespace('p', 'http://www.sat.gob.mx/Pagos');//Declaramos el Name Space tfd como t
      $pago = (array)$sxml->xpath('//p:DoctoRelacionado');//Obtenemos el array de tfd:TimbreFiscalDigital
      
      $sxml->registerXPathNamespace('t', 'http://www.sat.gob.mx/TimbreFiscalDigital');//Declaramos el Name Space tfd como t
      $timbre = (array)$sxml->xpath('//t:TimbreFiscalDigital');//Obtenemos el array de tfd:TimbreFiscalDigital
      $timbre_data = $timbre[0];
      $uuidPago = $timbre_data['UUID'];

      $buscaCXP = "SELECT id_proveedor,subtotal,uuid_factura,rfc_emisor_factura,rfc_receptor_factura 
                    FROM cxp WHERE id=".$idCxP;
      $resultCXP =  mysqli_query($this->link, $buscaCXP) or die(mysqli_error());
      $rowCXP = mysqli_fetch_array($resultCXP);
      $idProveedor = $rowCXP['id_proveedor'];
      $rfcEmisorCxP = $rowCXP['rfc_emisor_factura'];
      $rfcReceptorCxP = $rowCXP['rfc_receptor_factura'];
      $uuidCxP = $rowCXP['uuid_factura'];

      $buscaUUID = "SELECT COUNT(id) AS num FROM cxp_complementos_pagos 
                    WHERE id_cxp=$idCxP AND uuid_pago='$uuidPago'";
      $resultUUID =  mysqli_query($this->link, $buscaUUID) or die(mysqli_error());
      $rowUUID = mysqli_fetch_array($resultUUID);
      $numeroUUID = $rowUUID['num'];

      if(($_FILES['xml']['tmp_name']))
      {
        if($numeroUUID > 0)
        {
          $verifica = false;
          array_push($validaciones, 'El XML ya esta registrado para esa factura');
        }

        if($this->validarUTF8() != true)
        {
          $verifica = false;
          array_push($validaciones, 'La codificación del archivo es UTF-8');
        }

        if($this->validaRFCPruebas($emisorData['Rfc']) != true)
        {
          $verifica = false;
          array_push($validaciones, 'El RFC no corresponde a un RFC de pruebas para Timbrado');
        }

        if($emisorData['Rfc'] != $rfcEmisorCxP)
        {
          $verifica = false;
          array_push($validaciones, 'El RFC del emisor del pago no corresponde a la factura');
        }

        if($receptorData['Rfc'] != $rfcReceptorCxP)
        {
          $verifica = false;
          array_push($validaciones, 'El RFC del receptor del pago no corresponde a la factura');
        }

        $valor = 0;
        foreach ($pago AS $registro)
        {
          if ($registro['IdDocumento'] == $uuidCxP)
          {
            $valor = 1;
            break;
          }
        }

        if($valor == 0)
        {
          $verifica = false;
          array_push($validaciones, 'El pago no corresponde a la factura.');
        }

      }

      $verificaA['verifica'] = $verifica;
      $verificaA['validaciones'] = $validaciones;

      return json_encode($verificaA);

    }

    function guardarXMLPago($idCxP){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this-> guardarArchivosXMLPago($idCxP);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }

    function guardarArchivosXMLPago($idCxP){
      $verifica = 0;

      $xml= file_get_contents($_FILES['xml']['tmp_name']);
      $sxml = simplexml_load_string($xml);
      $sxml->registerXPathNamespace('c','http://www.sat.gob.mx/cfd/3');

      $comprobante = (array)$sxml->xpath('//c:Comprobante');
      $comprobanteData = $comprobante[0];
      $folioPago = $comprobanteData['Folio'];

      $sxml->registerXPathNamespace('p', 'http://www.sat.gob.mx/Pagos');//Declaramos el Name Space tfd como t
      $pago = (array)$sxml->xpath('//p:DoctoRelacionado');//Obtenemos el array de tfd:TimbreFiscalDigital
      
      $sxml->registerXPathNamespace('t', 'http://www.sat.gob.mx/TimbreFiscalDigital');//Declaramos el Name Space tfd como t
      $timbre = (array)$sxml->xpath('//t:TimbreFiscalDigital');//Obtenemos el array de tfd:TimbreFiscalDigital
      $timbre_data = $timbre[0];
      $UUID = $timbre_data['UUID'];

      $buscaCXP = "SELECT id_proveedor,subtotal,uuid_factura,rfc_emisor_factura,rfc_receptor_factura FROM cxp WHERE id=".$idCxP;
      $resultCXP =  mysqli_query($this->link, $buscaCXP) or die(mysqli_error());
      $rowCXP = mysqli_fetch_array($resultCXP);
      
      $uuidCxP = $rowCXP['uuid_factura'];
      $total = $rowCXP['subtotal'];

      if(($_FILES['xml']['tmp_name']))
      {

        $valor = 0;
        $monto = 0;
        $folioFactura = 0;
        foreach ($pago AS $registro)
        {
          if ($registro['IdDocumento'] == $uuidCxP)
          {
            $valor = 1;
            $monto = $registro['ImpPagado'];
            $folioFactura = $registro['Folio'];
            break;
          }
        }

        if($valor == 1)
        {

          $query = "INSERT INTO cxp_complementos_pagos(id_cxp,folio_xml_factura,folio_xml_pago,monto,uuid_pago) 
                  VALUES ('$idCxP','$folioFactura','$folioPago','$monto','$UUID')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $idRegistro = mysqli_insert_id($this->link);

          if($result)
          {
            if(isset($_FILES['xml']['name'])){

              $nombre_imagen=$_FILES['xml']['name']; 
              $nombreXml="xml_".$idCxP."_".$idRegistro.".xml";
              $rutaXML = "../XML_PAGOS/".$nombreXml;
              $rutaC = "XML_PAGOS/".$nombreXml;
            
              if((move_uploaded_file($_FILES['xml']['tmp_name'],$rutaXML))){
      
                $xml= file_get_contents($rutaXML);   //--- obtengo el contenido del xml y lo convierto a string para insertarlo en almacen
                $sxml = simplexml_load_string($xml); //-- se carga el string generado para obtener la informacion de sus nodos
      
                $sxml->registerXPathNamespace('c','http://www.sat.gob.mx/cfd/3');//Declaramos el Name Space cfdi como c
                
                $actualizaRuta = "UPDATE cxp_complementos_pagos SET ruta_xml='$rutaC'";
                $resultA = mysqli_query($this->link, $actualizaRuta) or die(mysqli_error());

                if($resultA)
                {
                  $buscaAB = "SELECT SUM(monto) AS total_abonos 
                    FROM cxp_complementos_pagos
                    WHERE id_cxp=".$idCxP;
                  $resultAB =  mysqli_query($this->link, $buscaAB) or die(mysqli_error());
                  $rowAB = mysqli_fetch_array($resultAB);

                  $montoAbonos = $rowAB['total_abonos'];

                  if($montoAbonos >= $total)
                  {
                    $actualizaEstatus = "UPDATE cxp SET estatus_complemento_pago=1 WHERE id=".$idCxP;
                    $resultEs = mysqli_query($this->link, $actualizaEstatus) or die(mysqli_error());

                    if($resultEs)
                      $verifica = 2;

                  }else
                    $verifica = 1;

                }

              }
      
            }
          }
          
        }

      }

      return $verifica;
    }

    function buscarComplementosPago($idCxP){
        $resultado = $this->link->query("SELECT id,folio_xml_factura,folio_xml_pago,ruta_xml, monto 
                    FROM cxp_complementos_pagos
                    WHERE id_cxp=".$idCxP);

        if($resultado)
          return query2json($resultado); 
    }
    
}//--fin de class CargarDatos
    
?>
