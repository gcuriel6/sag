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

    #div_xml_pagos{
        max-height:250px;
        min-height:250px;
        overflow-y:auto;
        overflow-x:hidden;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        #div_xml_pagos{
            height:auto;
            overflow:auto;
        }
    }
    
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-offset-3 col-md-6" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="titulo_ban">Consulta de Contrarecibos</div>
                    </div>
                </div>
                <br>    

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-sm-8 col-md-8">
                        <table class="tablon"  id="t_cargar_datos">
                        <thead>
                            <tr class="renglon">
                                <th scope="col" width="25%">Orden compra</th>
                                <th scope="col" width="25%">Recepción de Mercancías y Servicios</th>
                                <th scope="col" width="25%">Contrarecibo</th>
                                <th scope="col" width="25%">XML PAGO</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_pagos_xml" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagos xml  <span id="span_dato"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forma_archivos_xml_pagos" name="forma_archivos_xml_pagos">
                    <div class="row">
                        <label for="i_xml" class="col-sm-12 col-md-3 col-form-label requerido">XML Pago</label>
                        <div class="col-sm-12 col-md-6">
                            <input type="file" class="form-control validate[required]" id="i_xml">
                        </div>  
                        <div class="col-sm-12 col-md-3">
                            <button type="button" class="btn btn-success btn-sm form-control" id="b_agregar_xml"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                        </div>  
                    </div>
                </form>
                <br>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Folio CxP</th>
                                    <th scope="col">Folio Factura</th>
                                    <th scope="col">Folio Pago</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_xml_pagos">
                            <table class="tablon"  id="t_xml_pagos">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <table id="t_validaciones">
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
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

        $('#div_img').empty();

        buscaContrarecibos();

        function buscaContrarecibos(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_unidad').val('');
            $('.renglon_cargar_datos').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/cargar_datos_buscar.php',
                dataType:"json", 
                data:{'idProveedor':idProveedor},

                success: function(data) {
    
                   if(data.length != 0){

                        $('.renglon_cargar_datos').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var botonContrarecibo='<button type="button" class="btn btn-info btn-xs" id="b_contrarecibo" alt="'+data[i].id+'"><i class="fa fa-download" aria-hidden="true"></i></button>';
                            var botonPagosXml='';
                            if(data[i].metodo_pago)
                                botonPagosXml='<button type="button" class="btn btn-success btn-xs" id="b_pagos_xml" oc="'+data[i].folio_oc+'" rm="'+data[i].folio_entrada+'" alt="'+data[i].id+'" alt2="'+data[i].estatus_complemento_pago+'"><i class="fa fa-upload" aria-hidden="true"></i></button>';
                           
                            var html='<tr class="renglon_cargar_datos" alt="'+data[i].id+'">\
                                        <td data-label="ORDEN COMPRA">' + data[i].folio_oc+ '</td>\
                                        <td data-label="RECEPCIÓN DE MERCANCÍAS Y SERVICIOS">' + data[i].folio_entrada+ '</td>\
                                        <td data-label="CONTRARECIBO">' + botonContrarecibo + '</td>\
                                        <td data-label="XML PAGO">' + botonPagosXml + '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_cargar_datos tbody').append(html);   
                           
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log( 'php/cargar_datos_buscar.php -->'+ JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $(document).on('click','#b_contrarecibo',function(){
            var idCxp=$(this).attr('alt');
            console.log('**  ' + idCxp);
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

        });

        
        $(document).on('click','#b_pagos_xml',function(){
            var idCxP=$(this).attr('alt');
            var estatus=$(this).attr('alt2');
            $('#t_validaciones tbody').html('');
            $('#i_xml').val('');

            $('#b_agregar_xml').attr({'cxp':idCxP,'OC':$(this).attr('oc'),'EC':$(this).attr('rm')});

            if(estatus == 1)
                $('#b_agregar_xml').prop('disabled',true);
            else
                $('#b_agregar_xml').prop('disabled',false);

            $('#span_dato').text('OC: '+$(this).attr('oc')+' Recepcion: '+$(this).attr('rm'));
            muestraRegistrosXMLPagos(idCxP);
            $('#dialog_pagos_xml').modal('show');

        });

        $('#b_agregar_xml').click(function(){
            $('#b_agregar_xml').prop('disabled',true);

            if ($('#forma_archivos_xml_pagos').validationEngine('validate')){
                var idCxP = $('#b_agregar_xml').attr('cxp');
                var idOC = $('#b_agregar_xml').attr('OC');
                var idEC = $('#b_agregar_xml').attr('EC');

                $('#t_validaciones tbody').html('');

                verificar(idCxP);
            }else
                $('#b_agregar_xml').prop('disabled',false);

        });

        /* funcion que manda verificar la informacion ingresada */    
        function verificar(idCxP){
            //Damos el valor del input tipo_mov file
            var archivoXML = document.getElementById("i_xml");

            //Obtenemos el valor del input (los archivos) en modo de arreglo
            var i_xml = archivoXML.files; 

            var datos = new FormData();
            datos.append('xml',i_xml[0]);
            datos.append('idCxP',idCxP);
    
            var ficheroXML = $('#i_xml').val();   
            var extXML = ficheroXML.split('.');
            extXML = extXML[extXML.length -1];
            
            var verificaExtenciones=esXML(extXML);
          
            if(verificaExtenciones==''){  //valida la extension de la imagen
                $.ajax({
                    type: 'POST',
                    url: 'php/cargar_datos_validar_xmlPago.php',  
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: datos,
                    //una vez finalizado correctamente
                    success: function(data)
                    {
                        //console.log(data);
                        if(data.verifica == true)
                            guardarXMLPago(idCxP); 
                        else
                        {
                            //mandarMensaje('Ocurrio un error al validar los datos intentalo nuevamente');
                            var validaciones = data.validaciones;
                            for(var i=0; validaciones.length>i; i++)
                            {

                                var validacion = validaciones[i];

                                //alert(validacion);
                                var html = "<tr class='renglon-validaciones' >";
                                html += "<td id='eliminar'><img src='../imagenes/cancelar.png' /></td>";
                                html += "<td>" + validacion + "</td>";
                                html += "</tr>";

                                $('#t_validaciones tbody').append(html);
                            
                            }
                            $('#b_agregar_xml').prop('disabled',false);
                        }

                    },
                    //si ha ocurrido un error
                    error: function(xhr){
                        console.log('php/cargar_datos_validar_xmlPago.php --> '+JSON.stringify(xhr));
                        mandarMensaje('Ocurrio un error al validar los datos intentalo nuevamente ***');
                        $('#b_agregar_xml').prop('disabled',false);
                    }
                });
            }else{
                mandarMensaje(verificaExtenciones);
                $('#b_agregar_xml').prop('disabled',false);
            }   
        }

        function guardarXMLPago(idCxP){
            //Damos el valor del input tipo_mov file
            var archivoXML = document.getElementById("i_xml");

            //Obtenemos el valor del input (los archivos) en modo de arreglo
            var i_xml = archivoXML.files; 

            var datos = new FormData();
            datos.append('xml',i_xml[0]);
            datos.append('idCxP',idCxP);

            var ficheroXML = $('#i_xml').val();   
            var extXML = ficheroXML.split('.');
            extXML = extXML[extXML.length -1];
           
            var verificaExtenciones=esXML(extXML);
            
            if(verificaExtenciones==''){  //valida la extension de la imagen
                $.ajax({
                    type: 'POST',
                    url: 'php/cargar_datos_guardar_xmlPago.php',  
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: datos,
                    //una vez finalizado correctamente
                    success: function(data){
                        console.log('cargar: '+data);
                        if (data > 0) {

                            if(data == 2)
                            {
                                $('#b_agregar_xml').prop('disabled',true);
                                buscaContrarecibos();
                            }else
                                $('#b_agregar_xml').prop('disabled',false);

                            muestraRegistrosXMLPagos(idCxP);
                            $('#i_xml').val('');

                        }else{
                            mandarMensaje('Ocurrio un error al cargar archivo intentalo nuevamente');
                            $('#b_agregar_xml').prop('disabled',false);
                        }
                    },
                    //si ha ocurrido un error
                    error: function(xhr){
                        console.log('php/cargar_datos_guardar_xmlPago.php -->' + JSON.stringify(xhr));
                        mandarMensaje('* Ocurrio un error al cargar archivo intentalo nuevamente');
                        $('#b_agregar_xml').prop('disabled',false);
                    }
                });
            }else{
                mandarMensaje(verificaExtenciones);
                $('#b_agregar_xml').prop('disabled',false);
            }   
        }

        function muestraRegistrosXMLPagos(idCxP){
            
            $('#t_xml_pagos tbody').html('');   

            $.ajax({
                type: 'POST',
                url: 'php/cargar_datos_buscar_complementos_pago.php',
                dataType:"json", 
                data:{'idCxP':idCxP},

                success: function(data) 
                {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            //var botonXML='<button type="button" class="btn btn-info btn-xs" id="b_xml_descargar" alt="'+data[i].id+'" ruta="'+data[i].ruta_xml+'"><i class="fa fa-download" aria-hidden="true"></i></button>';
                            var botonXML='<a href="'+data[i].ruta_xml+'" download="file.xml" type="button" class="btn btn-info btn-xs" id="b_xml_descargar" alt="'+data[i].id+'" ruta="'+data[i].ruta_xml+'"><i class="fa fa-download" aria-hidden="true"></i></a>';
                            
                            var html='<tr class="renglon" alt="'+data[i].id+'">\
                                        <td data-label="FOLIO CXP">' + idCxP+ '</td>\
                                        <td data-label="FOLIO FACTURA">' + data[i].folio_xml_factura+ '</td>\
                                        <td data-label="FOLIO PAGO">' + data[i].folio_xml_pago+ '</td>\
                                        <td data-label="MONTO">' + data[i].monto + '</td>\
                                        <td data-label="XML PAGO">' + botonXML + '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_xml_pagos tbody').append(html);   
                        }
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="5">No se encontró información</td>\
                                    </tr>';
                        $('#t_xml_pagos tbody').append(html);   
                    }

                },
                error: function (xhr) {
                    console.log( 'php/cargar_datos_buscar_complementos_pago.php -->'+ JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar xml pagos');
                }
            });
        }

        /* Funcion que verifica si es una imagen */
        function esXML(extXML){
            var extenciones='';
            if(extXML!='' && extXML!='xml'){
                extenciones+='Verifica la extencion de tu XML';
            }
            return extenciones;
        }

    });

</script>

</html>