<?php 
session_start();
include("conectar.php");
include("../widgets/numerosLetras.php");
$link = Conectarse();

$datosO = $_REQUEST['D'];
$datosD = base64_decode($datosO);
$arreglo = json_decode($datosD, true); //estoy recibiendo un json string, entonces lo tengo que decodificar y

$idRegistro = $arreglo['idRegistro'];

// Informacion de la empresa 
$query = "SELECT
a.folio_contrato,
a.id_cotizacion,
b.razon_social AS rs_cliente,
b.rfc,
b.r_legal,
b.domicilio,
b.no_exterior,
b.no_interior,
b.colonia,
b.codigo_postal,
c.municipio,
d.estado
FROM contratos_cliente a
LEFT JOIN razones_sociales b ON a.id_razon_social=b.id
LEFT JOIN municipios c ON b.id_municipio = c.id
LEFT JOIN estados d ON b.id_estado=d.id
WHERE a.id_contrato=".$idRegistro."
ORDER BY a.id_contrato";

//DATE_ADD(DATE(a.fecha), INTERVAL b.dias_credito DAY)AS fecha_vigencia,

$consulta = mysqli_query($link,$query);
$row = mysqli_fetch_array($consulta);

//---datos almacen encabezado---
$folioContrato = date('Y-m').'-'.$row['folio_contrato'];
$idCotizacion = $row['id_cotizacion'];
$rs_cliente = $row['rs_cliente'];
$rfc = $row['rfc'];
$r_legal= $row['r_legal'];
$domicilio = $row['domicilio'];
$no_exterior = $row['no_exterior'];
$no_interior = $row['no_interior'];

$colonia = $row['colonia'];
$codigo_postal = $row['codigo_postal'];
$municipio = $row['municipio'];
$estado = $row['estado'];  

$precioMensual=0;
$buscaPrecioMensual="SELECT SUM(sub.precio_mensual)AS precio_mensual
FROM(
	SELECT 
	IFNULL(SUM(precio_total),0) AS precio_mensual
	FROM cotizacion_elementos  WHERE id_cotizacion=".$idCotizacion."
	UNION ALL
	SELECT 
	IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual
	FROM cotizacion_equipo WHERE id_cotizacion=".$idCotizacion."
	UNION ALL
	SELECT
	IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual
	FROM cotizacion_servicios WHERE id_cotizacion=".$idCotizacion."
	UNION ALL
	SELECT 
	IFNULL(SUM(IF(tipo_pago = 1,precio_total,0)),0) AS precio_mensual
	FROM cotizacion_vehiculos WHERE id_cotizacion=".$idCotizacion."
) sub";
      $resultTR = mysqli_query($link,$buscaPrecioMensual) or die(mysqli_error());
      $numTR = mysqli_num_rows($resultTR);
      $rowTR = mysqli_fetch_array($resultTR);

      $precioMensual=$rowTR['precio_mensual'];
        
      
?>
<style>

.texto{
    font-size:18px;
	font-weight:100;
}
.texto td{
    text-align:justify;
    line-height : 25px;
}

</style>
<!-- se usa para poner  marca de agua backimg="../images/logo_marca2.png" backimgy="380"-->
<page backtop="8mm" backright="8mm" backleft="9mm"  backbottom="9mm">

<table border="0" width="660" class="texto">
    <tr>
        <td width="660" align="right"> 
        <br><br>
        <strong>FOLIO: </strong><?php echo $folioContrato;?>
        </td>
    </tr>
    <tr>
        <td width="660">
        <br>
            Contrato de prestaci??n de servicios profesionales de vigilancia y protecci??n 
            <strong>K-9</strong> que celebran por una parte, <strong style="text-decoration: underline solid black;">???<?php echo $rs_cliente;?>???</strong>, representada en este acto por <strong style="text-decoration: underline solid black;">???<?php echo $r_legal;?>???</strong> a quien en lo sucesivo se le denominar?? 
            <strong>???EL CLIENTE???</strong>   y por la otra parte <strong>???SECORP ALARMAS DE JUAREZ??? S. DE R.L DE C.V.???</strong>,  representada en este acto por el <strong>LIC. JORGE GINTHER ARZAGA</strong>, a quien en lo sucesivo se le denominar?? 
            <strong>???EL PRESTADOR DEL SERVICIO???</strong> , los cuales se someten al contenido de las siguientes declaraciones y cl??usulas.
        </td>
    </tr>
    <tr>
        <td align="center">
            <br><br>
            <strong>DECLARACIONES:</strong>
            <br><br>
        </td>
    </tr>
  
    <tr>
        <td>
        <strong>I.-</strong> Declara <strong>???EL CLIENTE???</strong>  que su representada es una persona moral, constituida bajo las leyes mexicanas, cuyas instalaciones se ubican en (<strong style="text-decoration: underline solid black;">???<?php echo $domicilio.' No. '. $no_exterior.($no_interior!='')?'INT. '.$no_interior:'';?>???</strong>), C??digo Postal <strong style="text-decoration: underline solid black;">???<?php echo $codigo_postal;?>???</strong> de Ciudad  <strong style="text-decoration: underline solid black;">???<?php echo $municipio.", ".$estado;?>???</strong>, tributando bajo el n??mero de Registro Federal de Contribuyentes <strong style="text-decoration: underline solid black;">???<?php echo $rfc;?>???</strong>.
        <br><br><br>
        <strong>II.-</strong> Manifiesta <strong style="text-decoration: underline solid black;">???<?php echo $r_legal;?>???</strong> en su car??cter de representante legal de <strong style="text-decoration: underline solid black;">???<?php echo $rs_cliente;?>???</strong>, bajo protesta de decir verdad, que cuenta con las facultades necesarias para celebrar el presente contrato.
        <br><br><br>
        <strong>III.-</strong> Que actualmente tiene la necesidad de contratar los servicios especializados y profesionales de seguridad que ???EL PRESTADOR DE SERVICIOS??? otorga, consistentes en revisiones k-9 en los puentes internacionales a los tr??ileres propiedad 
        <strong>???DEL CLIENTE???</strong> , para efecto de tener un control de seguridad en el desarrollo de su actividad comercial, en los t??rminos y condiciones que en este contrato se establecen.

        </td>
    </tr>
    <tr>
        <td align="center">
        <br><br>
            <strong>DECLARA EL PRESTADOR DEL SERVICIO:</strong>
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>IV.-</strong> Que su representada, es una sociedad mercantil legalmente constituida conforme a las leyes de la Rep??blica Mexicana seg??n consta en la Escritura N??mero 28,339, de fecha 19 de noviembre de 2010, otorgada ante la fe del Licenciado Francisco De As??s Garc??a Ramos, Notario P??blico No. 9 de la ciudad de Chihuahua, cuyo primer testimonio obra inscrito en el Registro P??blico de la Propiedad y del Comercio del Estado de Chihuahua, bajo el folio electr??nico mercantil n??mero 26275 * 10.
            <br><br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>V.-</strong> Que para efectos del presente contrato, ???SECORP ALARMAS DE JUAREZ??? S. DE R.L DE C.V.???,  con domicilio en Rio de la Plata n??mero 4439, Colonia C??rdova Am??ricas de Ciudad Ju??rez, Chihuahua, est?? representada por el Licenciado JORGE IVAN GINTHER ARZAGA, quien cuenta con facultades suficientes para celebrar el presente contrato, facultades que a la fecha no le han sido revocadas ni modificadas.
            <br><br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>VI.-</strong> Que una parte de su objeto social consiste en la prestaci??n de servicios de seguridad privada, protecci??n, vigilancia y custodia a personas f??sicas y morales, as?? como a los bienes muebles e inmuebles de ??stas; revisi??n canina a medios de transporte terrestres, as?? como revisi??n a empresas, escuelas, centros de diversi??n, etc??tera. 
            <br><br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>VII.</strong> Que cuenta con la infraestructura completa y suficiente para satisfacer plenamente las necesidades del servicio que se contrata; as?? como, con las autorizaciones expedidas por la Secretaria del Trabajo y Previsi??n Social, Secretaria de Seguridad P??blica del Gobierno Federal y la Secretaria de la Defensa Nacional, para prestar servicios en la modalidad de seguridad privada en toda la Rep??blica Mexicana a trav??s de personal debidamente seleccionado y capacitado para el correcto desempe??o de dicho servicio. 
            <br><br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>VIII.</strong> Es voluntad de su representada celebrar el presente Contrato y obligarse en los t??rminos que m??s adelante se indican.
            <br><br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Las partes en su conjunto reconocen expresamente y declaran:</strong>
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            
            <strong>A.-</strong> Que se reconocen mutuamente la personalidad y capacidad legal con las cuales concurren a la celebraci??n del presente contrato, estando facultados los respectivos representantes para obligar a su mandante en los t??rminos y condiciones que en el mismo se contienen.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>B.-</strong> Que es su deseo e inter??s celebrar el presente contrato en los t??rminos, plazo y condiciones que en el mismo se establecen y anexos que tambi??n lo integran.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>C.-</strong> En caso de que las partes cambien sus domicilios, se obligan a dar comunicaci??n por escrito a la otra por lo menos 3 (tres) d??as de anticipaci??n los cuales ser??n presentadas en las instalaciones de los domicilios anteriormente citados.
            De conformidad con las anteriores declaraciones las partes de mutuo acuerdo convienen en celebrar el presente contrato de conformidad con las siguientes:
            <br><br>
        </td>
    </tr>
   <tr>
        <td align="center"> 
                              
            <strong>C L ?? U S U L A S:</strong>
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>PRIMERA.??? OBJETO DEL CONTRATO.</strong> 
            La operaci??n objeto del presente acuerdo de voluntades consistir?? en la prestaci??n de servicios de revisiones k-9 en los puentes internacionales a los tr??ileres de 
            <strong>???EL CLIENTE???</strong>, mediante binomios constituidos por gu??as de seguridad capacitados para el correcto y profesional manejo y cuidado de agentes caninos, as?? como por agentes caninos (K-9), debidamente entrenados para la detecci??n de narc??ticos o estupefacientes, realizado mediante revisi??n, utilizando el sistema olfatorio para su detecci??n; agentes ??stos, dependientes de 
            <strong>???EL PRESTADOR???</strong>.
            <br><br>
        </td>
            
    </tr>
    <tr>
        <td>
            <strong>SEGUNDA.- PERSONAL CONTRATADO.</strong> 
            <strong>???EL PRESTADOR???</strong>  para el debido cumplimiento del objeto de este contrato, se obliga a mantener para la revisi??n de los bienes muebles o tr??ileres del contratante, una plantilla de gu??as de seguridad y de K-9 (caninos), guardias de seguridad para el manejo de espejo c??ncavo y marro de goma,  en d??as y horas en que las aduanas de los puentes Internacionales de Ciudad Ju??rez, Chihuahua, est??n abiertas al transporte de carga, para as?? cubrir el servicio de vigilancia contratado, a partir del d??a primero (1??.) de octubre de 2019 y durante la vigencia del presente contrato.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>TERCERA. ??? PAGO: Las partes establecen como precio o pago que  por los SERVICIOS  que  </strong>
            <strong>???EL PRESTADOR???</strong>  se obliga a destinar y asignar a 
            <strong>???EL CLIENTE???</strong> ,  para el debido cumplimiento en los t??rminos pactados en este contrato, la cantidad de <strong style="text-decoration: underline solid black;">???<?php echo dos_decimales($precioMensual);?>???</strong> (<strong style="text-decoration: underline solid black;">???<?php echo numtoletras($precioMensual);?>???</strong>) m??s I.V.A. mensual, misma que ser?? pagada dentro de los primeros 5 d??as de cada mes a partir de la fecha fijada. Dicha suma solo ser?? modificada ??nicamente en igual proporci??n al incremento del salario m??nimo general al ser publicado en el Diario Oficial de la Federaci??n.
            <br><br>
            Este monto se puede modificar en funci??n de los elementos que se tengan asignados y aceptados por 
            <strong>???EL CLIENTE???</strong> .

            Sin perjuicio de lo anterior 
            <strong>???EL CLIENTE???</strong>  pagar?? las facturas correspondientes que presente 
            <strong>???EL PRESTADOR???</strong>  a los treinta d??as de su presentaci??n, al no ser pagadas en tiempo causar?? un inter??s moratorio del 2% diario por cada d??a de atraso.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>CUARTA.- DURACI??N DEL CONTRATO.</strong> La duraci??n del presente contrato ser?? de quince meses, obligatorio para ambas partes, contados a partir del d??a primero de octubre de dos mil diecinueve y hasta el d??a treinta y uno de diciembre de dos mil veinte; s?? al concluir dicho plazo, no existe aviso de cualquiera de las partes para no mantener esta relaci??n contractual en t??rminos de la cl??usula d??cima, el presente contrato se prorrogar?? autom??ticamente, mientras se emite otro por escrito.
            <br><br>
        </td>
    </tr>
    <tr> 
        <td>
            <strong>QUINTA.??? INFORMACI??N OPORTUNA.</strong> 
            <strong>???EL PRESTADOR???</strong>  tendr?? la obligaci??n de informar a 
            <strong>???EL CLIENTE???</strong>  de manera inmediata de cualquier problema, irregularidad o anomal??a que se detecte en las revisiones K9 que realice en los bienes muebles o tr??ileres propiedad <strong>???DEL CLIENTE???</strong>  mediante un reporte que se entregar?? al personal encargado de la contratante.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>SEXTA.??? UNIFORMES DEL PERSONAL.</strong> 
            <strong>???EL PRESTADOR???</strong>  se obliga a uniformar de manera adecuada a los elementos de seguridad que destine para el cumplimiento del objeto del presente contrato.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>S??PTIMA.- SUPERVICI??N.</strong> 
            <strong>???EL PRESTADOR???</strong>  estar?? encargado de supervisar constantemente y durante la vigencia del presente instrumento a los elementos de seguridad que sean destinados para el cumplimiento del presente contrato. 
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>OCTAVA.- OBLIGACI??N PATRONAL.</strong> 
            <strong>???EL PRESTADOR???</strong>  ser?? el ??nico responsable de los trabajadores que en su caso empleare para la ejecuci??n de este contrato y asumir??, frente a ellos, todas y cada una de las obligaciones patronales que contemplan las leyes en materia laboral y de seguridad social, por lo que deber?? contar con documentos id??neos que acrediten su ??nica y exclusiva relaci??n laboral, tales como contratos laborales, altas de su personal ante el IMSS, AFORE e INFONAVIT y gafetes de la empresa de seguridad, oblig??ndose tambi??n a presentar los documentos que as?? lo demuestren cuando 
            <strong>???EL CLIENTE???</strong>  se lo requiera.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>NOVENA.- REEMPLAZO DE PERSONAL.</strong> 
            <strong>???EL PRESTADOR???</strong>  se obliga a reemplazar de manera inmediata a aquellos elementos que 
            <strong>???EL CLIENTE???</strong>  no quiera por motivos justificados y se lo har?? saber al ???PRESTADOR??? mediante simple notificaci??n por escrito.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>D??CIMA.??? DE LA TERMINACI??N DEL CONTRATO.</strong> El presente contrato no podr?? culminar de manera anticipada por voluntad unilateral, en la reserva de que se puede rescindir la relaci??n contractual si alguna de las partes no cumple con lo que se ha obligado en el actual convenio, sin estar obligados a cumplir con ninguna formalidad para los efectos de una posible rescisi??n bilateral solamente la cual se realizara por escrito de las partes.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
           <strong>D??CIMA PRIMERA.- CUESTIONES PREVENTIVAS.</strong> 
            <strong>???EL PRESTADOR???</strong>  entregar?? a 
            <strong>???EL CLIENTE???</strong>  de manera anual un an??lisis de riesgo donde se mostrar??n los puntos vulnerables que tenga la empresa, as?? como las mejoras que se soliciten, para lo cual 
            <strong>???EL CLIENTE???</strong>  puede o realizar las mejoras o no realizarlas,  sin embargo si llegase a ocurrir alg??n percance debido a la omisi??n de las observaciones presentadas en el an??lisis de riesgo,  
            <strong>???EL PRESTADOR???</strong>  no se har?? responsable de las consecuencias econ??micas de dicho percance. 
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>D??CIMA SEGUNDA. - RESPONSABILIDAD LABORAL.</strong> - Es aquella que sobreviene a 
            <strong>???EL PRESTADOR???</strong>  a virtud de los servicios que le prestan sus trabajadores.
            <br><br>
            </td>
    </tr>
    <tr>
        <td>        
            Ambas partes al celebrar este contrato, expresamente manifiestan que es de naturaleza estrictamente civil y por tal, los servicios contratados se prestaran con los propios elementos de que dispone 
            <strong>???EL PRESTADOR???</strong> , por lo que si ??ste, requiriera contratar a su vez trabajadores para el cumplimiento de sus objetivos, la relaci??n laboral ser?? ??nica y exclusivamente entre 
            <strong>???EL PRESTADOR???</strong>  y las personas que le presten sus servicios, pues al margen del presente contrato, 
            <strong>???EL PRESTADOR???</strong>  acepta contar con elementos propios con los que se desempe??ar??n los servicios contratados y cuenta adem??s, con los recursos econ??micos necesarios y suficientes para cumplir con las obligaciones laborales que llegare a asumir con sus empleados, por lo que libera a 
            <strong>???EL CLIENTE???</strong>  de cualquier tipo de responsabilidad laboral que EL PRESTADOR configure con terceras personas.
            <br><br>
            Adem??s ambas partes manifiestan que por medio del presente contrato no se crea ning??n v??nculo laboral o de cualquier otro tipo entre 
            <strong>???EL CLIENTE???</strong>  y 
            <strong>???EL PRESTADOR???</strong>  ni entre 
            <strong>???EL CLIENTE???</strong>  y los empleados actuales o futuros de EL PRESTADOR, quien es el ??nico patr??n del personal que ocupe para brindar el servicio, por lo que toda la responsabilidad laboral es ??nica y exclusivamente de 
            <strong>???EL PRESTADOR???</strong>  haci??ndose responsable 
            <strong>???EL PRESTADOR???</strong>  de todas y cada una de las obligaciones laborales que tenga con sus empleados, incluy??ndose obligaciones fiscales y las relacionadas con las cuotas obrero patronales, incluy??ndose los pagos del Instituto Mexicano del Seguro Social (IMSS) y del Instituto del Fondo Nacional de la Vivienda para los Trabajadores (INFONAVIT).
            <strong>???EL PRESTADOR???</strong>  se obliga a sacar a salvo y en paz a 
            <strong>???EL CLIENTE???</strong>  en caso de que se presente cualquier tipo de conflicto. 
            <br>
            <strong>???EL PRESTADOR???</strong>  ser?? el ??nico responsable de los trabajadores que en su caso empleare para la ejecuci??n de este contrato y asumir??, frente a ellos, todas y cada una de las obligaciones patronales que contemplan los ordenamientos legales en materia laboral y de seguridad social.

            Congruente con lo anterior 
            <strong>???EL PRESTADOR???</strong>  se obliga a atender las reclamaciones judiciales o extrajudiciales que le llegaren a formular dichos trabajadores en las que involucre a su contraparte, y se compromete a sacar a ??sta en paz y a salvo de tales circunstancias.

            En consecuencia, 
            <strong>???EL PRESTADOR???</strong>  queda en libertad de dedicarse por cuenta propia al ejercicio de su actividad en la forma y t??rminos que convengan a sus intereses y pacte con terceros.

            As?? mismo 
            <strong>???EL PRESTADOR???</strong>  faculta a 
            <strong>???EL CLIENTE???</strong> , para que esta ??ltima retenga y disponga de los Cr??ditos que existan a favor de 
            <strong>???EL PRESTADOR???</strong> , en caso de que esta ??ltima incumpla con sus obligaciones laborales como son el pago de salarios, indemnizaciones o cualquier tipo de prestaci??n laboral, as?? como tambi??n en caso de que incumpla con sus obligaciones fiscales ante el IMSS, INFONAVIT, SAT y AFORES. 
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>D??CIMA TERCERA. ??? OBLIGACIONES FISCALES.</strong> 
            <strong>???EL PRESTADOR???</strong>  se obliga con 
            <strong>???EL CLIENTE???</strong>  a dar el exacto y debido cumplimiento a su costa, de todas y cada una de las obligaciones fiscales, administrativas, judiciales que pudieran corresponderle por la ejecuci??n y cumplimiento del presente contrato. El incumplimiento a dicha obligaci??n facultar?? 
            <strong>???EL CLIENTE???</strong>  a rescindir este contrato sin necesidad de declaraci??n judicial al efecto, y a ejercitar las acciones civiles y/o penales que correspondan, as?? como a exigir de su contraparte el pago de los da??os y perjuicios que dicho incumplimiento le cause.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>D??CIMA CUARTA.??? DE LAS CONFIDENCIALIDAD DE DATOS PERSONALES.</strong> Las partes se obligan en este acto que de manera permanente e indefinida, a??n despu??s de terminada la relaci??n profesional, comercial y/o de negocios a guardar en el m??s absoluto secreto y confidencialidad, de toda la informaci??n pactada en el presente acto jur??dico, el cual ponga a su disposici??n o haga de su conocimiento por cualquier medio cualquiera que fuera su naturaleza. 
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>D??CIMA QUINTA. ??? DE LAS MODIFICACIONES.</strong> 
            <strong>???EL CLIENTE???</strong>  podr?? en cualquier tiempo modificar los t??rminos respecto a las condiciones de la prestaci??n del servicio contemplado en el presente contrato, por lo que al mismo tiempo 
            <strong>???EL PRESTADOR???</strong> , actualizara los costos por dichas modificaciones en menci??n, dichas modificaciones se integrar??n al presente instrumento y formar?? parte integral de la misma declaraci??n contractual. 
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>D??CIMA SEXTA.??? DE LA FALSEDAD EN DECLARACIONES.</strong> En el caso de incumplimiento de cualquiera de ???LAS PARTES??? respecto a las presentes obligaciones que se adquieren en este instrumento o que cualesquiera de las declaraciones fuesen falsas o inexactas facultar?? a la parte diversa parte contractual a elegir entre demandar a su contraparte el cumplimiento forzoso o su rescisi??n y en ambos casos, a exigirle la reparaci??n y el pago de los da??os y perjuicios que le ocasionar?? su incumplimiento. 
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>D??CIMA S??PTIMA.??? DE LA TERMINACION DE OBLIGACIONES PREVIAS. </strong>Las partes convienen en que todo acuerdo verbal y/o escrito celebrado con anterioridad a la firma del presente instrumento, relacionado con la operaci??n que en este acto se celebra, se dar?? por terminado, sin responsabilidad para las partes, ya que el presente instrumento re??ne todas y cada una de las condiciones y t??rminos pactados con anticipaci??n, cualquier nuevo acuerdo deber?? ser por escrito y firmado por las partes, formar?? parte del presente contrato.
            <br><br>
        </td>
    </tr>
    <tr>
        <td>        
            <strong>D??CIMA OCTAVA.??? DE LA CAPACITACI??N.</strong> 
            <strong>???EL PRESTADOR???</strong>  establecer?? los programas espec??ficos de capacitaci??n y adiestramiento de su personal, as?? como su filosof??a interna de la empresa, con respecto al seguimiento de pol??ticas procedimientos para todo su personal, de acuerdo a las necesidades y circunstancias que 
            <strong>???EL CLIENTE???</strong>  requiera. 
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <strong>D??CIMA NOVENA.??? DE LA JURISDICCI??N.</strong> Ambas partes se someten expresamente a la Jurisdicci??n de los Tribunales del fuero com??n de este Distrito Bravos y a las leyes civiles del estado de Chihuahua para todo lo relativo a las gestiones que se susciten sobre la interpretaci??n y cumplimiento de este contrato.    

            Una vez que ambas partes leyeron el contenido del presente contrato, manifestaron su conformidad con el mismo, firmando para constancia el d??a primero de octubre de dos mil diecinueve.
            <br><br>
        </td>
    </tr>
    <tr>
        <td align="center">
        <br><br>
            <strong>???EL PRESTADOR DEL SERVICIO???</strong> 
            <br><br>
            LIC. JORGE IVAN GINTHER ARZAGA<br>
            Representante legal de <br>
            ???SECORP ALARMAS DE JUAREZ??? S. DE R.L DE C.V.???<br><br>

            <strong>???EL CLIENTE???</strong> <br><br>
            ------------------------
        </td>
    </tr>
</table>

</page>
          
<?php 

function fecha($fecha) {
    list($anyo, $mes, $dia) = explode("-", $fecha);
    $fechamod = $dia . "/" . $mes . "/" . $anyo;
    return $fechamod;
}
function dos_decimales($number, $fractional=true) { 
    if ($fractional) { 
        $number = sprintf('%.2f', $number); 
    } 
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
        if ($replaced != $number) { 
            $number = $replaced; 
        } else { 
            break; 
        } 
    } 
    return '$'.$number; 
}
?>
