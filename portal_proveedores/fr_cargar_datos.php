<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PORTAL PROVEEDORES</title>
    <!-- Hojas de estilo -->
    <link href="../css/css/bootstrap.css" rel="stylesheet"  type="text/css" media="all">
    <link href="../css/validationEngine.jquery.css" rel="stylesheet" />
    <link href="../css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <link href="../css/general.css" rel="stylesheet"  type="text/css"/>
    <link href="../vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="../vendor/select2/css/select2.css" rel="stylesheet"/>
</head>

<style> 
    body{
        background-color:rgb(238,238,238);
    }
    #div_principal{
        padding-top:20px;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
   
    #vistaPrevia_1{
        border: 1px solid rgb(214, 214, 194); 
        background-color: #fff; 
        max-height: 55px; 
        min-height: 55px;
        width:100px;
    }
    
    .d_fecha_pago,
    .d_contrarecibo,
    .d_contrarecibo_exi{
        display:none;
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Cargar Datos</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-8"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_cargar" disabled><i class="fa fa-floppy-o" aria-hidden="true"></i> Cargar</button>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-2"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="i_pdf" class="col-sm-3 col-md-3 col-form-label">PDF Factura</label>
                                <div class="col-sm-12 col-md-5">
                                    <input type="file" class="form-control" id="i_pdf">
                                </div>
                                <div class="col-sm-12 col-md-5" id="div_img">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_xml" class="col-sm-3 col-md-3 col-form-label">XML Factura</label>
                                <div class="col-sm-12 col-md-5">
                                    <input type="file" class="form-control" id="i_xml">
                                </div>
                                <div class="col-sm-12 col-md-5" id="div_img">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_oc" class="col-sm-3 col-md-3 col-form-label requerido">Folio de Orden Compra </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control validate[required,custom[integer]]" id="i_oc" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_entrada" class="col-sm-3 col-md-3 col-form-label requerido">Folio de recepción de mercancía y servicios</label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control validate[required,custom[integer]]" id="i_entrada" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_fecha_pago" class="col-sm-3 col-md-3 col-form-label d_fecha_pago">Fecha  de Pago</label>
                                <div class="col-sm-12 col-md-3 d_fecha_pago">
                                    <input type="text" class="form-control" id="i_fecha_pago" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-4"></div>
                  <div class="col-sm-12 col-md-8">
                    <table id="t_validaciones">
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                    
                <div class="row">
                    <div class="col-sm-12 col-md-3 d_contrarecibo"></div>
                    <div class="col-sm-12 col-md-9 d_contrarecibo">
                        <span class="label label-warning" style="color:red;">
                            <!--* Si las condiciones de pago son distintas  a las sugeridas, favor de ponerse en contacto con el personal de Tesorería-->
                            * Una vez generado el contra-recibo no se podrá modificar
                        </span>
                    </div>
                    <div class="col-sm-12 col-md-3 d_contrarecibo"></div>
                    <div class="col-sm-12 col-md-4 d_contrarecibo">
                        <button type="button" class="btn btn-info btn-sm form-control"  id="b_contrarecibo"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generar Contrarecibo</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-3 d_contrarecibo_exi"></div>
                    <div class="col-sm-12 col-md-9 d_contrarecibo_exi">
                        <span class="label label-warning" style="color:green;">
                            * Ya existe un registro relacionado a la entrada de almacen.
                        </span>
                    </div>
                </div>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_cargar_datos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Unidades de Negocio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_unidad" id="i_filtro_unidad" class="form-control filtrar_renglones" alt="renglon_cargar_datos" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cargar_datos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Estatus</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="../js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/js/bootstrap.js"></script>
<script src="../js/jquery.validationEngine.js"></script>
<script src="../js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>

<script>
  
    var idUnidadesNegocio=0;
    var tipo_mov=0;
    var modulo='CARGAR_DATOS';
    var imagenVacia = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
    var nombreAnteriorImg='';
    var idProveedor=<?php echo $_SESSION['idProveedor']?>;
    $(function(){

        $('#div_img').html('');

        $('#forma input').change(function(){
            if($('#i_oc').val() != '' && $('#i_entrada').val() != '' && $('#i_pdf').val() != '' && $('#i_xml').val() != '')
            {
                $('#b_cargar').prop('disabled',false);
            }else{
                $('#b_cargar').prop('disabled',true);
            }

            $('#t_validaciones tbody').html('');
            $('.d_fecha_pago').hide();
            $('.d_contrarecibo').hide();
            $('.d_contrarecibo_exi').hide();
        });

        $('#b_cargar').click(function(){

            $('#t_validaciones tbody').html('');
            $('.d_fecha_pago').hide();
            $('.d_contrarecibo').hide();
            $('.d_contrarecibo_exi').hide();
           
            $('#b_cargar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
               
                verificar();

            }else{
               
                $('#b_cargar').prop('disabled',false);
            }
        });


        /* funcion que manda verificar la informacion ingresada */    
        function verificar(){
          //Damos el valor del input tipo_mov file
          var archivoPDF = document.getElementById("i_pdf");
          var archivoXML = document.getElementById("i_xml");

          //Obtenemos el valor del input (los archivos) en modo de arreglo
          var i_pdf = archivoPDF.files; 
          var i_xml = archivoXML.files; 

          var datos = new FormData();

          datos.append('tipo_mov',tipo_mov);
          datos.append('idProveedor',idProveedor);
          datos.append('pdf',i_pdf[0]);
          datos.append('xml',i_xml[0]);
          datos.append('folioOc',$('#i_oc').val());
          datos.append('folioEntrada',$('#i_entrada').val());
  
          var ficheroPDF = $('#i_pdf').val();   
          var extPDF = ficheroPDF.split('.');
          extPDF = extPDF[extPDF.length -1];

          var ficheroXML = $('#i_xml').val();   
          var extXML = ficheroXML.split('.');
          extXML = extXML[extXML.length -1];
         
          var verificaExtenciones=esPDFXML(extPDF,extXML);
          
          if(verificaExtenciones==''){  //valida la extension de la imagen
              $.ajax({
                  type: 'POST',
                  url: 'php/cargar_datos_validar.php',  
                  dataType: "json",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: datos,
                  //una vez finalizado correctamente
                  success: function(data)
                  {
                      // verificando
                      console.log('verifica: '+data);
                      if(data.verifica == true)
                          guardar();
                      else
                      {
                          //mandarMensaje('Ocurrio un error al validar los datos intentalo nuevamente');
                          var validaciones = data.validaciones;
                          for(var i=0; validaciones.length>i; i++)
                          {

                              var validacion = validaciones[i];

                              //alert(validacion);
                              var html = "<tr class='renglon-validaciones' >";
                              html += "<td align='center' id='eliminar'><img src='../imagenes/cancelar.png' /></td>";
                              html += "<td>" + validacion + "</td>";
                              html += "</tr>";

                              $('#t_validaciones tbody').append(html);
                          
                          }
                          $('#b_cargar').prop('disabled',false);
                      }

                  },
                  //si ha ocurrido un error
                  error: function(xhr){
                      console.log('php/cargar_datos_validar.php --> '+JSON.stringify(xhr));
                      //mandarMensaje('Ocurrio un error al validar los datos intentalo nuevamente ***');
                      mandarMensaje('Ocurrio un error al cargar los archivos. Los archivos tienen errores de codfificación o de sintaxis');
                      $('#b_cargar').prop('disabled',false);
                  }
              });
          }else{
              mandarMensaje(verificaExtenciones);
              $('#b_cargar').prop('disabled',false);
          }   
        }
        
        /* funcion que manda guardar los archivos y generar la fceha de pago  */    
        function guardar(){
            //Damos el valor del input tipo_mov file
            var archivoPDF = document.getElementById("i_pdf");
            var archivoXML = document.getElementById("i_xml");

            //Obtenemos el valor del input (los archivos) en modo de arreglo
            var i_pdf = archivoPDF.files; 
            var i_xml = archivoXML.files; 

            var datos = new FormData();
            datos.append('idProveedor',idProveedor);
            datos.append('pdf',i_pdf[0]);
            datos.append('xml',i_xml[0]);
            datos.append('folioOc',$('#i_oc').val());
            datos.append('folioEntrada',$('#i_entrada').val());
    
            var ficheroPDF = $('#i_pdf').val();   
            var extPDF = ficheroPDF.split('.');
            extPDF = extPDF[extPDF.length -1];

            var ficheroXML = $('#i_xml').val();   
            var extXML = ficheroXML.split('.');
            extXML = extXML[extXML.length -1];

            console.log("** " + idProveedor);
           
            var verificaExtenciones=esPDFXML(extPDF,extXML);

            if(verificaExtenciones==''){  //valida la extension de la imagen
                 $.ajax({
                    type: 'POST',
                    url: 'php/cargar_datos_guardar.php',  
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: datos,
                    //una vez finalizado correctamente
                    success: function(data){
                        console.log('res data: '+data);
                        if (data!=0 && data!='') {

                            var datos = data.split(',');
                            var fechaPago = datos[0];
                            var idE01 = datos[1];
                            //-->NJES Jan/30/2020 tomamos el id de la orden de compra y lo agregamos como atributo al boton de contrarecibo
                            var idOC = datos[2];
                            //-->NJES Jan/30/2020 valida si mostrar boton para generar contrarecibo o ya solo indica que se cargaron los datos
                            // porque ya se generaron los cxp con las requis de anticipo
                            var generaC = datos[3];

                            //-->NJES April/17/2020 si el importe del xml de la factura no cohincide con la entrada compra no deja carar el archivo
                            if(generaC == 'IMPORTE_MAL')
                            {
                                mandarMensaje('El importe de la factura no cohincide con el importe de la recepción de mercancía.');
                            }
                            else if(generaC == 'DESCUENTO_MAL')
                            {
                                mandarMensaje('El descuento de la factura no cohincide con el descuento de la recepción de mercancía.');
                            }else{
                                if(generaC == 'SI')
                                {
                                    $('.d_fecha_pago').show();
                                    $('.d_contrarecibo').show();

                                    $('#i_fecha_pago').val(fechaPago);
                                    $('#b_contrarecibo').attr({'alt':idE01,'alt2':idOC});
                                }else{
                                    limpiar();
                                    mandarMensaje('Se cargaron los datos correctamente.');
                                }
                            }

                            $('#b_cargar').prop('disabled',false);

                        }else
                        {
                          // aqui esta 
                            mandarMensaje('Ocurrio un error al cargar los datos intentalo nuevamente');
                            $('#b_cargar').prop('disabled',false);
                        }
                            

                    },
                    //si ha ocurrido un error
                    error: function(xhr){
                        console.log('php/cargar_datos_guardar.php -->' + JSON.stringify(xhr));
                        mandarMensaje('* Ocurrio un error al cargar los datos intentalo nuevamente');
                        $('#b_cargar').prop('disabled',false);
                    }
                });
                
            }else{
                mandarMensaje(verificaExtenciones);
                $('#b_cargar').prop('disabled',false);
            }   
        }

        //--- se guarda el cxp y se genera el pdf del contrarecibo--
        $(document).on('click','#b_contrarecibo',function(){

            var idE01 = $(this).attr('alt');
            var idOC = $(this).attr('alt2');

            console.log(' * ' + idE01);

            $.ajax({
                type: 'POST',
                url: 'php/proveedores_verificar_existencia_idE.php', 
                data:  {
                    'idE01': idE01
                },
                success: function(data) 
                {
                    if(data == 1)
                    {
                        $('.d_contrarecibo').hide();
                        $('.d_contrarecibo_exi').show();
                        mandarMensaje('Ya existe un registro relacionado a la entrada de almacen.');
                    }else
                        guardarContrarecibo(idE01,idOC);
                        //-->NJES Jan/30/2020 enviamos el id de la orden de compra para poder buscar sus requisiciones de anticipo y ver si ya existen cxp de esas requisiciones
                },
                error: function (xhr) {
                    console.log('php/proveedores_verificar_existencia_idE.php-->'+JSON.stringify(xhr));
                    mandarMensaje('** Ocurrio un error al generar el contrarecibo');
                }
            });
        });

        function guardarContrarecibo(idE01,idOC)
        {

            console.log(JSON.stringify(
                {
                'idE01': idE01,
                    'idProveedor' : idProveedor,
                    'fechaVencimiento': $('#i_fecha_pago').val(),
                    'folioOc':$('#i_oc').val(),
                    'folioEntrada':$('#i_entrada').val(),
                    'idOC': idOC 
                }
            ));

            $.ajax({
                type: 'POST',
                url: 'php/cargar_datos_cxp.php',
                dataType:"json", 
                data:  {
                    'idE01': idE01,
                    'idProveedor' : idProveedor,
                    'fechaVencimiento': $('#i_fecha_pago').val(),
                    'folioOc':$('#i_oc').val(),
                    'folioEntrada':$('#i_entrada').val(),
                    'idOC': idOC //-->NJES Jan/30/2020 enviamos el id de la orden de compra para poder buscar sus requisiciones de anticipo y ver si ya existen cxp de esas requisiciones
                },
                success: function(data) 
                {
                    console.log(data);
                    if(data > 0){

                        limpiar();
                        
                        var idCxp=data;
                        var datos = {
                            'path':'formato_contrarecibo',
                            'idRegistro':idCxp,
                            'nombreArchivo':'contrarecibo',
                            'tipo':1,
                            'concepto':'CONTRA RECIBO'
                        };

                        let objJsonStr = JSON.stringify(datos);
                        let datosJ = datosUrl(objJsonStr);

                        window.open("php/convierte_pdf.php?D="+datosJ,'_new')
                    } else {
                       mandarMensaje('Ocurrio un error al generar el contrarecibo');
                    }
                },
                error: function (xhr) {
                    console.log('php/cargar_datos_cxp.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*** Ocurrio un error al generar el contrarecibo');
                }
            });
        }


        /* Funcion que verifica si es una imagen */
        //--MGFS se modifica la validacion convirtiendo cualquier convinacion a minusculas ejemplo 
        //---PDF=pdf Pdf=pdf igual con los archivos xml
        function esPDFXML(extPDF,extXML){
            var esPDF = extPDF.toLowerCase();
            var esXML = extXML.toLowerCase();
            var extenciones='';
            if(esPDF!='' && esPDF!='pdf'){
                extenciones+='Verifica la extencion de tu PDF <br/>';
            }
           
            if(esXML!='' && esXML!='xml'){
                extenciones+='Verifica la extencion de tu XML';
            }
            return extenciones;
        }

        $('#b_nuevo').click(function(){
            limpiar();
        });

        function limpiar(){
            $('#forma input').val('');
            $('.d_contrarecibo').hide();
            $('.d_contrarecibo_exi').hide();
            $('.d_fecha_pago').hide();
        }
        
    });

</script>

</html>